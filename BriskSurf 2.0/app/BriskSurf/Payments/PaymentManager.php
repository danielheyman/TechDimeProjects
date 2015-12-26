<?php namespace BriskSurf\Payments;

use Settings;
use Packages;
use Mailgun;
use SubscriptionModel as Subscription;
use BriskSurf\Helpers\Result;

class PaymentManager {

	public function get($id, $subid = null)
	{
		$subscription = Subscription::find($subid);

		if($subscription != null) return $subscription;

		$package = Packages::get($id);
		if(!$package) return false;
	}

	public function getCost($id)
	{
		return Packages::get($id)->cost;
	}

	public static function makeButton($package, $button = null)
	{
		if(is_string($package)) $package = Packages::get($package);
		$package->updated_at = \Carbon::now();
		$website = Settings::get('main');
		$paypal = ($website->sandbox) ? "www.sandbox.paypal" : "www.paypal";

		$payment = "";
		if($package->renew == "none")
		{
			$payment .= '<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                	<input type="hidden" name="cmd" value="_xclick">';
                                	$payment .= "<input type='hidden' name='amount' value='" . number_format($package->cost) . "'>";
		}
		else
		{
			$payment .= '<form name="_xclick" action="https://' . $paypal . '.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_xclick-subscriptions">';
                        	$payment .= '<input type="hidden" name="a3" value="' . number_format($package->cost) . '">';
                        	$renew = explode(" ", $package->renew);
                        	$payment .= '<input type="hidden" name="p3" value="' . $renew[0] . '">';
                        	$payment .= '<input type="hidden" name="t3" value="' . strtoupper($renew[1][0]) . '">';
                        	$payment .= "<input type='hidden' name='src' value='1'>";
		}

		if($package->trial != "none")
		{
			$trial = explode(" ", $package->trial);
			$payment .= '<input type="hidden" name="a1" value="0">
		    	<input type="hidden" name="p1" value="' . $trial[0] . '">
		    	<input type="hidden" name="t1" value="' . strtoupper($trial[1][0]) . '">';
		}

		
		$email = ($website->sandbox) ? $website->sandbox_email : $website->paypal_email;

		$payment .= "<input type='hidden' name='no_shipping' value='1'>
                        	<input type='hidden' name='business' value='" . $email  . "'>
                        	<input type='hidden' name='currency_code' value='USD'>
                        	<input type='hidden' name='item_name' value='" . $website->website_name . " " . $package->name . "'>
                        	<input type='hidden' name='item_number' value='" . $package->_id . "'>
                        	<input type='hidden' name='notify_url' value='" . \URL::to('ipn') . "'>
                        	<input type='hidden' name='custom' value='" . \Auth::user()->_id . "'>
                        	<input type='hidden' name='cancel_return' value='" . \URL::to('memberships') . "'>
                        	<input type='hidden' name='return' value='" . \URL::to('success') . "'>";
                      	$payment .= ($button == null) ? "<input type='submit' value='Upgrade Now'>" : $button;
                      	$payment .= "</form>";
                    	return $payment;
	}

	public function process($report, $input)
	{
		$input = (object) $input;
		$package = ($input->txn_type == "subscr_payment") ? $input->subscr_id : null;
		$package = $this->get($input->item_number, $package);
		$user = \User::find($input->custom);


		$check = $this->validateData($package, $input, $user);

		if($check->fails())
		{
			$error = "IPN failed fraud checks: <br>{$check->errors()}<br><br>" . $report;
			$this->emailAdmin($error, "IPN Fraud Warning");
		}

		if($package->type == "membership")
		{
			$value = ($input->txn_type == "subscr_signup" && $package->trial != "none") ? $package->trial : $package->renew;
			$value = explode(" ", $value);
			$date = \Carbon::now();
			if($value[1] == "year") $date->addYears($amount[0]);
			else if($value[1] == "month") $date->addMonths($amount[0]);
			else if($value[1] == "day") $date->addDays($amount[0]);

			$user->membership = $package->value;
			$user->membership_expires = $date;
			$user->save();
			
		}
		else if($package->type == "credit")
		{
			$user->increment('credits', $package->value);
		}
		
		if($input->txn_type != "subscr_signup") $user->increment('sales', $input->mc_gross);

		if($input->txn_type == "subscr_signup")
		{
			$date = \Carbon::now();
			if($package->trial != "none")
			{
				$trial = explode(" ", $package->trial);
				if($trial[1] == "year") $date->addYears($trial[0]);
				else if($trial[1] == "month") $date->addMonths($trial[0]);
				else if($trial[1] == "day") $date->addDays($trial[0]);
			}

			$sub = new Subscription;
			$sub->_id = $input->subscr_id;
			$sub->user_id = $input->custom;
			$sub->name = $package->name;
			$sub->cost = $package->cost;
			$sub->renew = $package->renew;
			$sub->type = $package->type;
			$sub->expires = $date;
			$sub->save();
		}
		else
		{
			$renew = explode(" ", $package->renew);
			$date = \Carbon::now();
			if($renew[1] == "year") $date->addYears($renew[0]);
			else if($renew[1] == "month") $date->addMonths($renew[0]);
			else if($renew[1] == "day") $date->addDays($renew[0]);

			$package->expires = $date;
			$package->save();
		}

		made_purchase_event($user, (array) $input, $data->mc_gross);

		//GIVE REF COMMISSIONS

		if($user->upline != null)
		{
			$upline = \User::where("id", $user->upline)->get();
			if($upline->isEmpty()) return;

			$upline = $upline->first();
			$cash = round(Settings::get('memberships')[$upline->membership]['commission'] / 100 * $input->mc_gross, 2);
			$upline->increment("cash", $cash);

			commission_event($upline, $input, $cash);
		}
	}

	public function validateData($package, $input, $user)
	{
		$settings = Settings::get('general');
		$email = ($settings->sandbox) ? $settings->sandbox_email : $settings->paypal_email;
		$error = '';

		if(!$package)  $error .= "'Item_number' was not found: {$input->item_number}<br>";
		else if ($input->mc_gross != $package->cost) $error .= "'Mc_gross' does not match: {$input->mc_gross}<br>";

		if ($input->receiver_email != $email) $error .= "'Receiver_email' does not match: {$input->receiver_email}<br>";

		if($input->txn_type != "subscr_payment") return new Result($error);

		//Only continues checking if the type is a payment

		if ($input->mc_currency != "USD") $error .= "'Mc_currency' does not match: {$input->mc_currency}<br>";

		if(count($user) == 0) $error .= "'Custom' does not match a user: {$input->custom}<br>";

		if($input->payment_status != "Completed") $error .= "'Payment_status' is not completed: {$input->payment_status}<br>";

		$record = \HistoryManager::get(array(
			'meta' => array(
				'type' => 'made_purchase',
				'user' => $input->custom
			),
			'conditions' => [ ['txn_id', '=', $input->txn_id] ]
		));

		if(count($record) != 0) $error .= "'Txn_id' has already been processed: {$input->txn_id}<br>";

		return new Result($error);
	}

	public function emailAdmin($data, $subject)
	{
		$data = array(
			"data" => $data
		);
		$settings = Settings::get('general');
		Mailgun::send('emails.empty', $data, function($message) use ($subject, $settings)
		{
			$message->to($settings->paypal_email, "TechDime Admin")->subject($settings->website_name . ": " . $subject);
		});
	}
}