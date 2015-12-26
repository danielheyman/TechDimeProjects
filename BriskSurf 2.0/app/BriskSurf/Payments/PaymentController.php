<?php namespace BriskSurf\Payments;

use Auth;
use View;
use Input;
use Settings;
use Packages;
use Exception;

class PaymentController extends \BriskSurf\Helpers\BaseController
{

	public function testIpn()
	{
		$input = [];
		$data = 'transaction_subject=Surf Savant Pro Monthly Upgrade&payment_date=05:04:02 Feb 09, 2014 PST&txn_type=subscr_payment&subscr_id=I-FA42M8TWD2B9&last_name=Calic&residence_country=HR&item_name=Surf Savant Pro Monthly Upgrade&payment_gross=9.00&mc_currency=USD&business=techdime&payment_type=instant&protection_eligibility=Ineligible&verify_sign=AvRQY6s.wGosTE2ZGWr-sz8RM.<wbr>GtA6Tucyo--FfEGWFXFMNr6mu0vWTA&payer_status=verified&payer_email=anemail&txn_id=92S16949Y4420992S&receiver_email=payments@techdime.com&first_name=Bruno&payer_id=HV2TFQVGDR8XA&receiver_id=2ELYJL29SJKKQ&item_number=5386071d90390dd2070041a7&payer_business_name=Dr BRUNO CALIC&payment_status=Completed&payment_fee=0.65&mc_fee=0.65&mc_gross=7.00&custom=537a384290390dbe19d63af1&charset=windows-1252&notify_version=3.7&ipn_track_id=2bfea8ea1adbd';
		$data = explode("&", $data);
		foreach($data as $d)
		{
			$d = explode("=", $d);
			$input[$d[0]] = $d[1];
		}
		return PaymentManager::process(implode("<br>", $data), $input);
	}
	
	public function ipn()
	{
		$settings = Settings::get('general');
		$paypal = new PaypalManager;
		$paypal->use_sandbox = $settings->sandbox;


		try 
		{
			$verified = $paypal->processIpn();
		}
		catch( Exception $e )
		{
			PaymentManager::emailAdmin($e, "Invalid Post");
			return "A post error has occured";
		}

		if(!$verified)
		{
			PaymentManager::emailAdmin($paypal->getTextReport(), "Invalid IPN");
			return;
		}

		return paymentManager::process($paypal->getTextReport(), Input::all());
	}

	public function getMemberships()
	{
		parent::getNotifications();

		$packages = Packages::all()->filter(function($package) {
			return $package->type == "membership" && $package->active != "false";
		});

		return View::make('payments::memberships')->with(array(
			"packages" => $packages,
			"memberships" => array_reverse(Settings::get("memberships")->toArray()),
			"user" => Auth::user(),
			"paymentManager" => new PaymentManager
		));
	}

	public function getCredits()
	{
		parent::getNotifications();
		
		$packages = Packages::all()->filter(function($package) {
			return $package->active == "true" && $package->type == "credit";
		});

		return View::make('payments::credits')->with(array(
			"packages" => $packages, 
			"credits" => Auth::user()->credits,
			"paymentManager" => new PaymentManager
		));
	}
}