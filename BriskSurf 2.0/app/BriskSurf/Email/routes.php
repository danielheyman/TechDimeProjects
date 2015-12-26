<?php

Event::listen("campaign.email", function($email_id, $user, $status, $action_data)
{
	Queue::push('BriskSurf\Email\EmailManager@processEmail', array("email_id" => $email_id, "user" => $user, "status" => $status, "action_data" => $action_data));
});