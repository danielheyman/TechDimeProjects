<?php
///////////////
//I NEED TO UPDATE
///////////////
$ipn_message = "transaction_subject=BriskSurf Platinum Annual Upgrade&payment_date=03:50:49 Oct 25, 2014 PDT&txn_type=subscr_payment&subscr_id=I-SX56RGF6P5KW&last_name=Caine&residence_country=US&item_name=BriskSurf Platinum Annual Upgrade&payment_gross=68.00&mc_currency=USD&business=payments@techdime.com&payment_type=instant&protection_eligibility=Ineligible&verify_sign=AJmJGtQpMruUwyQm53dyYn8hLcB4AwX6sDcLpUKwfx1Gpuassm6C40yC&payer_status=verified&payer_email=bobcaine@charter.net&txn_id=64V79778AD070201J&receiver_email=payments@techdime.com&first_name=Robert&payer_id=F43H628ESUHXG&receiver_id=2ELYJL29SJKKQ&item_number=23&payment_status=Completed&payment_fee=2.27&mc_fee=2.27&mc_gross=68.00&custom=8727&charset=windows-1252&notify_version=3.8&ipn_track_id=fd5a1268de75a";


///////////////
//EXTRACT ARRAY
///////////////
require("cleanConfig.php");

$ipn_message = explode("&", $ipn_message);
foreach($ipn_message as $key => $value)
{
    $message = explode("=", $ipn_message[$key]);
    $message = [$message[0] => $message[1]];
    extract($message);
}
$payment_amount = $mc_gross;
$userid = $custom;
$payment_currency = $mc_currency;


if($db->query("SELECT `id` FROM `transactions` WHERE `txn_id` = '{$txn_id}' LIMIT 1")->getNumRows()) die( "Error #1" );



///////////////
//COPIED FROM IPN.PHP. ONLY CHANGE ERROR_LOG TO DIE & ADD ECHO "POSTED"
///////////////
if (
    ($payment_currency == "USD") &&
    ($receiver_email == $site["paypal"]) &&
    ("{$payment_amount}" == "{$packages[$item_number]['price']}") &&
    ($payment_status == "Completed")
    )
{
    if($packages[$item_number]['type'] == 0)
    {
        $db->query("UPDATE `users` SET `credits` = `credits` + {$membership[$packages[$item_number]['membership']]['monthlyCredits']}, `membership`='{$packages[$item_number]['membership']}', `membershipExpires` = NOW() + INTERVAL 1 MONTH, `membershipCredits` = NOW() + INTERVAL 1 MONTH WHERE `id`='{$userid}'");
    }
    else if($packages[$item_number]['type'] == 1)
    {
        $db->query("UPDATE `users` SET `credits` = `credits` + {$membership[$packages[$item_number]['membership']]['monthlyCredits']}, `membership`='{$packages[$item_number]['membership']}', `membershipExpires` = NOW() + INTERVAL 1 YEAR, `membershipCredits` = NOW() + INTERVAL 1 MONTH WHERE `id`='{$userid}'");	
    }
    else if($packages[$item_number]['type'] == 2)
    {
        $db->query("UPDATE `users` SET `credits` = `credits` + {$membership[$packages[$item_number]['membership']]['monthlyCredits']}, `membership`='{$packages[$item_number]['membership']}', `membershipExpires` = NOW() + INTERVAL 20 YEAR, `membershipCredits` = NOW() + INTERVAL 1 MONTH WHERE `id`='{$userid}'");		
    }
    else if($packages[$item_number]['type'] == 3)
    {
        $db->query("UPDATE `users` SET `credits` = `credits` + {$packages[$item_number]['credits']} WHERE `id`='{$userid}'");	
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
    echo "posted";
}
else
{
    if (!($payment_currency == "USD")) die( "Error #4" );   
    if(!($receiver_email == $site["paypal"])) die( "Error #5" );   
    if(!("{$payment_amount}" == "{$packages[$item_number]['price']}")) die( "Error #6" );   
    if(!($payment_status == "Completed")) die( "Error #7" );   
}
?>