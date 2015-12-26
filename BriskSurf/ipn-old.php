<?php
ini_set("log_errors", 1);
ini_set("error_log", "ipn-error.log");
require("cleanConfig.php");

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
    $value = urlencode(stripslashes($value));
    $req .= "&$key=$value";
}

// post back to PayPal system to validate
$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

//$fp = fsockopen ('www.sandbox.paypal.com', 80, $errno, $errstr, 30);

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
$userid = $_POST['custom'];

if (!$fp) {
    error_log( "Error #1" );
    // HTTP ERROR
} else {
    fputs ($fp, $header . $req);
    while (!feof($fp)) {
        $res = fgets ($fp, 1024);
        if (strcmp ($res, "VERIFIED") == 0) {
            //$saleprice = $pack->price * (1 - $site->sale);
            if (
                ($payment_currency == "USD") &&
                ($receiver_email == $site["paypal"]) &&
                ("{$payment_amount}" == "{$subscriptions[$item_number]['price']}") &&
                ($payment_status == "Completed")
                )
            {
                if($subscriptions[$item_number]['type'] == 0)
                {
                    $db->query("UPDATE `users` SET `credits` = `credits` + {$membership[$subscriptions[$item_number]['membership']]['monthlyCredits']}, `membership`='{$subscriptions[$item_number]['membership']}', `membershipExpires` = NOW() + INTERVAL 1 MONTH, `membershipCredits` = NOW() + INTERVAL 1 MONTH WHERE `id`='{$userid}'");	
                }
                else if($subscriptions[$item_number]['type'] == 1)
                {
                    $db->query("UPDATE `users` SET `credits` = `credits` + {$membership[$subscriptions[$item_number]['membership']]['monthlyCredits']}, `membership`='{$subscriptions[$item_number]['membership']}', `membershipExpires` = NOW() + INTERVAL 1 YEAR, `membershipCredits` = NOW() + INTERVAL 1 MONTH WHERE `id`='{$userid}'");	
                }
                else if($subscriptions[$item_number]['type'] == 2)
                {
                    $db->query("UPDATE `users` SET `credits` = `credits` + {$membership[$subscriptions[$item_number]['membership']]['monthlyCredits']}, `membership`='{$subscriptions[$item_number]['membership']}', `membershipExpires` = NOW() + INTERVAL 20 YEAR, `membershipCredits` = NOW() + INTERVAL 1 MONTH WHERE `id`='{$userid}'");		
                }
                else if($subscriptions[$item_number]['type'] == 3)
                {
                    $db->query("UPDATE `users` SET `credits` = `credits` + {$subscriptions[$item_number]['credits']} WHERE `id`='{$userid}'");	
                }
                $db->query("INSERT INTO `transactions` (`userid`, `item_name`, `item_number`, `txn_id`, `amount`) VALUES('{$userid}', '{$item_name}', '{$item_number}', '{$txn_id}', '{$payment_amount}')");
                $result = $db->query("SELECT `ref` FROM `users` WHERE `id` = '{$userid}'");
                $ref = $result->getNext()->ref;
                if($ref != 0)
                {
                    $result = $db->query("SELECT `membership` FROM `users` WHERE `id` = '{$ref}'");
                    if($result->getNumRows())
                    {
                        $mem = $result->getNext()->membership;		
                        $commission = $payment_amount * $membership[$mem]["refCommisionPercent"];
                        $db->query("INSERT INTO `commissions` (`userid`, `transactionid`, `amount`) VALUES('{$ref}', '{$db->insertID}', '{$commission}')");
                    }
                }
            }
            else
            {
                if (!($payment_currency == "USD")) error_log( "Error #4" );   
                if(!($receiver_email == $site["paypal"])) error_log( "Error #5" );   
                if(!("{$payment_amount}" == "{$subscriptions[$item_number]['price']}")) error_log( "Error #6" );   
                if(!($payment_status == "Completed")) error_log( "Error #7" );   
            }
        }
        else if (strcmp ($res, "INVALID") == 0) {
            error_log( "Error #2" );
            // log for manual investigation
        }
    }
    fclose ($fp);
}
?>