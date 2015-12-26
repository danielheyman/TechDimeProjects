<?php namespace BriskSurf\Helpers;

use Auth;
use App;
use View;

class BaseController extends \Controller 
{

	public function __construct()
	{
		
	}

	public function getNotifications()
	{
		if(!Auth::check()) return;

		$notificationManager = App::make('BriskSurf\Notifications\NotificationsManager');
		$notifications = $notificationManager->getNotifications(Auth::user()->id);

    		View::share('notifications', $notifications);
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout)) $this->layout = View::make($this->layout);
	}

}