<?php
///////////////
//I NEED TO UPDATE
///////////////
$ipn_message = "transaction_subject=SurfDuel Monthly Upgrade&payment_date=03:42:37 Feb 02, 2014 PST&txn_type=subscr_payment&subscr_id=I-RGNSW45RK9EY&last_name=Arnold&residence_country=US&item_name=SurfDuel Monthly Upgrade&payment_gross=19.00&mc_currency=USD&business=payments@techdime.com&payment_type=instant&protection_eligibility=Ineligible&verify_sign=AYCr3DUJcYnsGfM1pSSBLgRCq1xzAtT2cofg-IPVj4ac7Ua9DOgZMPOp&payer_status=verified&payer_email=rarnold1@nc.rr.com&txn_id=8JG672012E7480748&receiver_email=payments@techdime.com&first_name=Robert&payer_id=WBZM37JNZQ4QC&receiver_id=2ELYJL29SJKKQ&item_number=2&payment_status=Completed&payment_fee=0.85&mc_fee=0.85&mc_gross=19.00&custom=214&charset=windows-1252&notify_version=3.7&ipn_track_id=46d8df181d22a";


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
    ("{$payment_amount}" == "{$subscriptions[$item_number]['price']}") &&
    ($payment_status == "Completed")
    )
{
    $db->query("UPDATE `users` SET `membership`='{$subscriptions[$item_number]['membership']}', `membershipExpires`= NOW() + INTERVAL 1 MONTH WHERE `id`='{$userid}'");			
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
?>