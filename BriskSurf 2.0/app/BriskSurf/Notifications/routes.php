<?php

Event::listen("email.sent", function($email, $emailLog)
{
	Queue::push('BriskSurf\Notifications\NotificationsManager@addEmailNotification', array("email" => $email->toArray(), "emailLog" => $emailLog->toArray()));
});

Event::listen("campaign.notification", function($notification_id, $user, $status, $action_data)
{
	Queue::push('BriskSurf\Notifications\NotificationsManager@processNotification', array("notification_id" => $notification_id, "user" => $user, "status" => $status));
});

Route::group(array('before' => array('auth', 'targeting_setup')), function()
{
	Route::post('notification/seen', 'BriskSurf\Notifications\NotificationsController@postSeenNotification'); 
});