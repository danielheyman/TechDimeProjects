<?php namespace BriskSurf\Users;

use Auth;
use Input;
use URL;
use Cookie;
use BriskSurf\HomeReferral\ReferralManager;

class UserManager extends \BriskSurf\Helpers\BaseManager {

	protected $user;
	protected $validators;
	protected $referralManager;

	public function __construct(UserModel $user, UserValidatorsBank $validators, ReferralManager $referralManager)
	{
		$this->user = $user;
		$this->validators = $validators;
		$this->referralManager = $referralManager;
	}

	public function registerUser()
	{
		if ($this->validators->get("MakeUser")->fails()) return $this->setError($this->validators->get("MakeUser"));

		$options = array(
			'username'   => Input::get('username'),
			'name'       => Input::get('name'),
			'email'      => Input::get('email'),
			'password'   => Input::get('password'),
			'activation' => str_random(6),
			'newsletter' => true,
			'admin_emails' => true,
			'credits'  => 0,
			'credits_today'  => 0,
			'membership' => "free",
			'views_today' => 0,
			'views_total' => 0,
			'register_ip' => Request::getClientIp(),
			'auto_assign' => 0,
			'cash' => 0,
	    		'referrals' => 0
		);

		if($referralManager->addReferralFromCookies()->passes())
		{
			$options["upline"] = Cookie::get('ref');
			$options["upline_source"] = Cookie::get('source');
			$options["upline_page"] = Cookie::get('page');
		}

		$user = new $this->user($options);
		
		register_event($user, Request::getClientIp(), URL::to('activate', $user->activation));

		return $this;
	}

	public function loginUser()
	{
		if($this->validators->get("UserLogin")->fails()) return $this->setError($this->validators->get("UserLogin")->errors());

		Auth::attempt(Input::only('username', 'password'));

		return $this;
	}

	public function activateUser()
	{
		if($this->validators->get("ActivateAccount")->addInput(['code' => $code])->fails()) return $this->setError($this->validators->get("ActivateAccount")->errors());

		$user = $this->user->whereActivation($code)->first();
		$user->unset('activation');

		activate_event($user);

		return $this;
	}

	public function sendPasswordReminder()
	{
		if($this->validators->get("RemindPassword")->fails()) return $this->setError($this->validators->get("RemindPassword")->errors());

		$pass = str_random(6);

		$user = $this->user->whereEmail(Input::get('email'))->first(['name', 'email']);
		$user->password = $pass;
		$user->save();

		remind_password_event($user, $pass);

		return $this;
	}

	public function resendActivationCode()
	{
		if($this->validators->get("ResentActivationCode")->fails()) return $this->setError($this->validators->get("ResentActivationCode")->errors());

		$user = $this->user->whereEmail(Input::get('email'))->first(['name', 'email']);

		send_activation_event($user, URL::to('activate', $user->activation));

		return $this;
	}

	public function logoutUser()
	{
		Auth::logout();

		return $this;
	}

	public function saveUserSettings()
	{
		if($this->validators->get("EditSettings")->fails()) return $this->setError($this->validators->get("EditSettings")->errors());
		
		$user = Auth::user();
		$user->name = Input::get('name');
		$user->email = Input::get('email');
		$user->paypal = Input::get('paypal');
		$user->continent = Input::get('continent');
		$user->birthyear = Input::get('year');
		if (Input::get('password') != "") $user->password = Input::get('password');
		$user->newsletter = (Input::get('newsletter')) ? true : false;
		$user->admin_emails = (Input::get('admin_emails')) ? true : false;
		$user->save();

		return $this;
	}

	public function saveUserTargeting()
	{
		if($this->validators->get("SetupTargeting")->fails()) return $this->setError($this->validators->get("SetupTargeting")->errors());
		
		$user = Auth::user();
		$user->gender = Input::get('gender');
		$user->continent = Input::get('continent');
		$user->birthyear = Input::get('year');
		$user->save();

		return $this;
	}
}