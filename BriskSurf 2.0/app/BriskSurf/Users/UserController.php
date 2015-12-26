<?php namespace BriskSurf\Users;

use Auth;
use URL;
use View;
use Redirect;
use Config;

class UserController extends \BriskSurf\Helpers\BaseController {

	protected $user;
	protected $userManager;

	public function __construct(UserModel $user, UserManager $userManager)
	{
		$this->user = $user;
		$this->userManager = $userManager;

		parent::getNotifications();
	}

	public function getRegister()
	{
		return View::make('users::register');
	}

	public function postRegister()
	{
		if($this->userManager->registerUser()->fails()) return Redirect::to('register')->withErrors($this->userManager->errors())->withInput();
		
		return Redirect::to('registered');
	}

	public function getRegistered()
	{
		return View::make('templates.message')->with(array('subject' => 'Congrats!', 'message' => 'You have been successfully signed up. Please check your email for a confirmation link.'));
	}

	public function getLogin()
	{
		return view('users::login');
	}

	public function postLogin()
	{
		if($this->userManager->loginUser()->fails()) return Redirect::to('login')->withErrors($this->userManager->errors())->withInput();

		return Redirect::intended('/dash');
	}

	public function getActivate($code)
	{
		if($this->userManager->activateUser()->fails()) return View::make('templates.message')->with($this->userManager->errors());

		return View::make('templates.message')->with(['subject' => 'Congrats!', 'message' => "Your account has been successfully activated. Click <a href='" . URL::to('login') . "'>here</a> to sign in."]);
	}

	public function getRemind()
	{
		return View::make('users::remind');
	}

	public function postRemind()
	{
		if($this->userManager->sendPasswordReminder()->fails()) return Redirect::to('remind')->withErrors($this->userManager->errors())->withInput();

		return Redirect::to('reminded');
	}

	public function getReminded()
	{
		return View::make('templates.message')->with(array('subject' => 'Congrats!', 'message' => 'Please check your email for a temporary password.'));
	}

	public function getResend()
	{
		return View::make('users::resend');
	}

	public function postResend()
	{
		if($this->userManager->resendActivationCode()->fails()) return Redirect::to('resend')->withErrors($this->userManager->errors())->withInput();

		return Redirect::to('resent');
	}

	public function getResent()
	{
		return View::make('templates.message')->with(array('subject' => 'Congrats!', 'message' => 'Please check your email for your confirmation link.'));
	}

	public function getLogout()
	{
		$this->userManager->logoutUser();

		return Redirect::to('/');
	}

	public function getSettings()
	{
		$targeting = Config::get('users::targeting');

		return View::make('users::settings')->with(array(
			'user' => Auth::user(),
			"continents" => $targeting['continents'],
			"years" => $targeting['years'],
		));
	}

	public function postSettings()
	{
		if($this->userManager->saveUserSettings()->fails()) return Redirect::to('settings')->withErrors($this->userManager->errors())->withInput();

		return Redirect::to('settings')->withErrors(["global" => "Settings updated successfully"]);
	}

	public function getSetup()
	{
		$targeting = Config::get('users::targeting');

		return View::make('users::targeting')->with(array(
			"genders" => $targeting['genders'],
			"continents" => $targeting['continents'],
			"years" => $targeting['years'],
		));
	}

	public function postSetup()
	{
		if($this->userManager->saveUserTargeting()->fails()) return Redirect::to('setup')->withErrors($this->userManager->errors())->withInput();
		
		return Redirect::to('dash');
	}
}