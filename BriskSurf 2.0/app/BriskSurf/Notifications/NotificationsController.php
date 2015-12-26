<?php namespace BriskSurf\Notifications;

use Request;
use Input;
use Auth;

class NotificationsController extends \BriskSurf\Helpers\BaseController 
{
	protected $notification;

	public function __construct(NotificationsManager $notification)
	{
		$this->notification = $notification;
	}

	public function postSeenNotification()
	{
		 if(!Request::ajax()) return null;

		$this->notification->markSeen(Input::get('id'));
		return array("notification_id" => Input::get('id'));
	}
}