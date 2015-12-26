<?php namespace BriskSurf\Admin\Controllers;

use View;
use BriskSurf\Notifications\NotificationsManager;
use BriskSurf\Email\EmailManager;
use Redirect;

class NotificationsController extends \BriskSurf\Helpers\BaseController
{
	protected $notification;

	public function __construct(NotificationsManager $notification)
	{
		$this->notification = $notification;

        		View::share('draft_count', EmailManager::getDraftCount());
	}

	public function getNotification($id)
	{
		return View::make("admin::notifications.view")->with('notification', $this->notification->find($id));
	}

	public function postNotification($id)
	{
		$this->notification->updateFromInput($id);

		return Redirect::to('admin/notification/' . $id);
	}
}





