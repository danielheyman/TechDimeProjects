<?php
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn-error.log');

include("cleanConfig.php");

include('ipnFiles/ipnlistener.php');
$listener = new IpnListener();

//SANDBOX???
$sandbox = false;
$listener->use_sandbox = $sandbox;
$site_email = ($sandbox) ? "payments-facilitator@techdime.com" : $site["paypal"];

try {
    $listener->requirePostMethod();
    $verified = $listener->processIpn();
} catch (Exception $e) {
    error_log($e->getMessage());
    exit(0);
}

if ($verified) {

    $item_name = $_POST['item_name'];
    $item_number = $_POST['item_number'];
    $payment_status = $_POST['payment_status'];
    $payment_amount = $_POST['mc_gross'];
    $mc_currency = $_POST['mc_currency'];
    $txn_id = $_POST['txn_id'];
    $receiver_email = $_POST['receiver_email'];
    $payer_email = $_POST['payer_email'];
    $sale = false;
    
    if(count(explode("-", $_POST['custom'])) == 1)
    {
        $userid = $_POST['custom'];
    }
    else
    {
        $custom  = explode("-", $_POST['custom']);
        $userid = $custom[0];
        if($custom[1] == "s")
        {
            $query = $db->query("SELECT `sale` FROM `sales` WHERE `id` = '{$custom[2]}'");
            $sale = false;
            if($query->getNumRows())
            {
                $sale = $query->getNext()->sale;  
            }
        }
    }
    
    $errmsg = '';
    
    if ($payment_status != 'Completed') { 
        exit(0); 
    }

    if ($receiver_email != $site_email) {
        $errmsg .= "'receiver_email' does not match: ";
        $errmsg .= $receiver_email."\n";
    }
    
    $price = ($sale) ? ceil($packages[$item_number]['price'] * (100 - $sale)) / 100 : $packages[$item_number]['price'];
    if ($payment_amount != $price && "{$item_number}" != "99999") {
        $errmsg .= "'mc_gross' does not match: ";
        $errmsg .= $payment_amount."\n";
    }
    
    if ($mc_currency != 'USD') {
        $errmsg .= "'mc_currency' does not match: ";
        $errmsg .= $mc_currency."\n";
    }
    
    if($db->query("SELECT `id` FROM `transactions` WHERE `txn_id` = '{$txn_id}' LIMIT 1")->getNumRows())
    {
        $errmsg .= "'txn_id' has already been processed: ".$txn_id."\n";
    }
    
    if (!empty($errmsg)) {
    
        $body = "IPN failed fraud checks: \n$errmsg\n\n";
        $body .= $listener->getTextReport();
        mail('daniel.heyman@gmail.com', 'IPN Fraud Warning', $body);
        
    } 
    else 
    {
        if("{$item_number}" == "99999")
        {
            $db->query("UPDATE `users` SET `piggybank` = `piggybank` + {$payment_amount} WHERE `id`='{$userid}'");
            $db->query("INSERT INTO `transactions` (`userid`, `item_name`, `item_number`, `txn_id`, `amount`) VALUES('{$userid}', '{$item_name}', '{$item_number}', '{$txn_id}', '{$payment_amount}')");
        }
        else
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
            $insertid = $db->insertID;
            
            $result = $db->query("SELECT `ref` FROM `users` WHERE `id` = '{$userid}'");
            $ref = $result->getNext()->ref;
            if($ref != 0)
            {
                $result = $db->query("SELECT `membership` FROM `users` WHERE `id` = '{$ref}'");
                if($result->getNumRows())
                {
                    $mem = $result->getNext()->membership;		
                    $commission = $payment_amount * $membership[$mem]["refCommisionPercent"];
                    $db->query("INSERT INTO `commissions` (`userid`, `transactionid`, `amount`) VALUES('{$ref}', '{$insertid}', '{$commission}')");
                    for($x = 0; $x < floor($payment_amount / 5); $x++)
                    {
                        //salesman shield
                        $db->query("INSERT INTO `contestShields` (`userid`, `type`) VALUES ('{$ref}', 'salesman')");
                    }
                }
            }
        }
    }
    
} else {
    mail('daniel.heyman@gmail.com', 'Invalid IPN', $listener->getTextReport());
}

?>