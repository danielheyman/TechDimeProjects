<?php
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
                ($payment_status == "Completed")
                )
            {
                if("{$payment_amount}" == "{$packages[$item_number]['price']}")
                {
                    if($packages[$item_number]['type'] == "coin")
                    {
                        $db->query("UPDATE `users` SET `coins` = `coins` + {$packages[$item_number]['value']} WHERE `id`='{$userid}'");	
                    }
                    else
                    {
                        if($packages[$item_number]['type'] == "month") $type = "1 MONTH";
                        else if($packages[$item_number]['type'] == "annual") $type = "1 YEAR";
                        else if($packages[$item_number]['type'] == "life") $type = "20 YEAR";
                        else if($packages[$item_number]['type'] == "semi") $type = "6 MONTH";
                        else $type = false;
                        if($type)
                        {
                            $mem = $packages[$item_number]['value'];
                            $db->query("UPDATE `users` SET `coins` = `coins` + {$membership[$mem]['monthlyCoins']}, `vacations` = `vacations` + {$membership[$mem]['monthlyVacation']}, `membership`='{$mem}', `membershipExpires` = NOW() + INTERVAL {$type}, `membershipCoins` = NOW() + INTERVAL 1 MONTH WHERE `id`='{$userid}'");	
                        }
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
                else if("{$item_number}" == "99999")
                {
                    $db->query("UPDATE `users` SET `piggybank` = `piggybank` + {$payment_amount} WHERE `id`='{$userid}'");
                    $db->query("INSERT INTO `transactions` (`userid`, `item_name`, `item_number`, `txn_id`, `amount`) VALUES('{$userid}', '{$item_name}', '{$item_number}', '{$txn_id}', '{$payment_amount}')");
                }
                else error_log( "Error #6" );
            }
            else
            {
                if (!($payment_currency == "USD")) error_log( "Error #4" );   
                if(!($receiver_email == $site["paypal"])) error_log( "Error #5" );   
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