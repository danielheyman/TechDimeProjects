<?php
///////////////
//I NEED TO UPDATE
///////////////
$ipn_message = "transaction_subject=Surf Savant Pro Monthly Upgrade&payment_date=03:25:03 Feb 10, 2014 PST&txn_type=subscr_payment&subscr_id=I-FPTR6FSJ4URU&last_name=Haning&residence_country=US&item_name=Surf Savant Pro Monthly Upgrade&payment_gross=9.00&mc_currency=USD&business=payments@techdime.com&payment_type=instant&protection_eligibility=Ineligible&verify_sign=Ay7osq2Fl9EAcAsfNJzr-2gIsNrgAWouPhpghxnvJeV-lATKqTEvZHcf&payer_status=verified&payer_email=jfhaning@gmail.com&txn_id=6JY33151XX658835P&receiver_email=payments@techdime.com&first_name=James&payer_id=MLA98RRJ33MDJ&receiver_id=2ELYJL29SJKKQ&item_number=1&payment_status=Completed&payment_fee=0.56&mc_fee=0.56&mc_gross=9.00&custom=602&charset=windows-1252&notify_version=3.7&ipn_track_id=b12efe4a73d22";


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
                for($x = 0; $x < floor($payment_amount / 5); $x++)
                {
                    //salesman shield
                    $db->query("INSERT INTO `contestShields` (`userid`, `type`) VALUES ('{$ref}', 'salesman')");
                }
            }
        }
        echo "posted";
    }
    else if("{$item_number}" == "99999")
    {
        $db->query("UPDATE `users` SET `piggybank` = `piggybank` + {$payment_amount} WHERE `id`='{$userid}'");
        $db->query("INSERT INTO `transactions` (`userid`, `item_name`, `item_number`, `txn_id`, `amount`) VALUES('{$userid}', '{$item_name}', '{$item_number}', '{$txn_id}', '{$payment_amount}')");
        echo "posted";
    }
}
else
{
    if (!($payment_currency == "USD")) die( "Error #4" );   
    if(!($receiver_email == $site["paypal"])) die( "Error #5" );   
    if(!($payment_status == "Completed")) die( "Error #7" );   
}
?>