<?php namespace BriskSurf\Notifications;

use BriskSurf\Email\EmailLogModel;
use Input;
use URL;
use Auth;

class NotificationsManager
{
	protected $notification;
	protected $notificationLog;
	protected $emailLog;

	public function __construct(NotificationModel $notification, NotificationLogModel $notificationLog, EmailLogModel $emailLog)
	{
		$this->notification = $notification;
		$this->notificationLog = $notificationLog;
		$this->emailLog = $emailLog;
	}

	public function markSeen($id)
	{
		$notificationLog = $this->notificationLog->where("_id", $id)->where("user_id", Auth::user()->id)->first(["seen"]);
		if($notificationLog != null && !$notificationLog->seen)
		{
			if($notificationLog->notification_id) $this->notification->where('_id', $notificationLog->notification_id)->increment("views");
			$notificationLog->seen = true;
			$notificationLog->save();
		}

	}

	public function updateFromInput($id)
	{
		$notification = $this->notification->find($id);

		$notification->name = Input::get('name');
		$notification->subject = Input::get('subject');
		$notification->message = Input::get('message');
		$notification->type = Input::get('type');
		if($notification->type == "message") $notification->type_data = false;
		else if($notification->type == "link") $notification->type_data = Input::get("type_data_link");

		$notification->save();
	}

	public function newTransactional($campaign_id)
	{
		$notification = new $this->notification;
		$notification->name = "New Notification";
		$notification->subject = "New Notification";
		$notification->message = "Some message";
		$notification->type = "message";
		$notification->type_data = false;
		$notification->views = 0;
		$notification->campaign_id = $campaign_id;
		$notification->save();

		return $notification;
	}

	public function deleteById($id)
	{
		$this->notification->where("_id", $id)->delete();
	}

	public function find($id)
	{
		return $this->notification->find($id);
	}

	public function processNotification($job, $data)
	{
		$notification_id = $data["notification_id"];
		$user = $data["user"];
		$status = $data["status"];

		$notification = $this->notification->find($notification_id);
		if($status == "auto")
		{
			$notificationLog = new $this->notificationLog;
			$notificationLog->subject = $notification->subject;
			$notificationLog->message = $notification->message;
			$notificationLog->type = $notification->type;
			$notificationLog->type_data = $notification->type_data;
			$notificationLog->seen = false;
			$notificationLog->user_id = $user['_id'];
			$notificationLog->notification_id = $notification_id;
			$notificationLog->save();
		}
		$job->delete();
	}

	public function addEmailNotification($job, $data)
	{
		$emailLog = $data["emailLog"];
		$email = $data["email"];

		if($email->notification)
		{
			$notification = new $this->notificationLog;
			$notification->subject = $emailLog['from_name'];
			$notification->message = "Sent you an email";
			$notification->type = "email";
			$notification->type_data = $emailLog["_id"];
			$notification->seen = false;
			$notification->user_id = $emailLog["user_id"];
			$notification->notification_id = false;
			$notification->save();
		}
	}

	public function getNotifications($user_id)
	{
		$notifications = $this->notificationLog->where("user_id", $user_id)->where('seen', false)->get();

		foreach($notifications as $key => $notification)
		{
			if($notification['type'] == "email")
			{
				$emailLog = $this->emailLog->find($notification->type_data, ["data", "subject"]);
				$type_data = str_replace("\"", "&quot;", $emailLog->data);
				$type_data = "<iframe style='width: 100%; height: 200px; border: 0;' srcdoc='{$type_data}'></iframe>";
				$notification->type_data = $type_data;
				$notification->type_data_title = $emailLog->subject;
			}
			else if($notification['type'] == "link")
			{
				$notification->type_data = preg_replace_callback('/{{url::(.+)}}/i', function($matches) {
					return URL::to($matches[1]);
				}, $notification->type_data);
			}
			$notifications[$key] = $notification;
		}
		
		return $notifications;
	}
}