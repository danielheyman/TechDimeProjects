<?php namespace BriskSurf\Notifications;

use Jenssegers\Mongodb\Model as Eloquent;

class NotificationLogModel extends Eloquent {

	protected $collection = 'notification_logs';
	
}
