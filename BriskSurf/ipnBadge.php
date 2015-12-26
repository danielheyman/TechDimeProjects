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
	$userid = $_POST['custom'];
	
	$errmsg = '';
	
	if ($payment_status != 'Completed') { 
		exit(0); 
	}

	if ($receiver_email != $site_email) {
		$errmsg .= "'receiver_email' does not match: ";
		$errmsg .= $receiver_email."\n";
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
		if($payment_amount == 2)
		{
			$db->query("INSERT INTO `surfHistory` (`userid`, `views`, `timestamp`) VALUES ('{$userid}', 100, '{$item_number}') ");
		}
		else if($payment_amount == 5)
		{
			if($item_number == 114) $url = 'http://clicktrackprofit.com/api.php?bid=5922&key=3d7b6d56d7';
			else if($item_number == 115) $url = 'http://clicktrackprofit.com/api.php?bid=5923&key=132055aad4';
			else if($item_number == 116) $url = 'http://clicktrackprofit.com/api.php?bid=5924&key=d9e305b797';
			else if($item_number == 117) $url = 'http://clicktrackprofit.com/api.php?bid=5925&key=d07a76cc71';
			else if($item_number == 118) $url = 'http://clicktrackprofit.com/api.php?bid=5926&key=81608ee0e9';
			$code = file_get_contents($url);

			$db->query("INSERT INTO `badgeHunt` (`badge`, `userid`, `code`) VALUES ('{$item_number}', {$userid}, '{$code}') ");
		}
		else if($payment_amount == 20)
		{
			for($x = 114; $x <= 118; $x++)
			{
				if($x == 114) $url = 'http://clicktrackprofit.com/api.php?bid=5922&key=3d7b6d56d7';
				else if($x == 115) $url = 'http://clicktrackprofit.com/api.php?bid=5923&key=132055aad4';
				else if($x == 116) $url = 'http://clicktrackprofit.com/api.php?bid=5924&key=d9e305b797';
				else if($x == 117) $url = 'http://clicktrackprofit.com/api.php?bid=5925&key=d07a76cc71';
				else if($x == 118) $url = 'http://clicktrackprofit.com/api.php?bid=5926&key=81608ee0e9';
				$code = file_get_contents($url);

				$db->query("INSERT INTO `badgeHunt` (`badge`, `userid`, `code`) VALUES ('{$x}', {$userid}, '{$code}') ");	
			}
		}


		$db->query("INSERT INTO `transactions` (`userid`, `item_name`, `item_number`, `txn_id`, `amount`) VALUES('{$userid}', '{$item_name}', '{$item_number}', '{$txn_id}', '{$payment_amount}')");
	}
	
} else {
	mail('daniel.heyman@gmail.com', 'Invalid IPN', $listener->getTextReport());
}

?>