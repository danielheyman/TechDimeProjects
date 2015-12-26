<?php

Event::listen("user.made_action", function($user, $action, $data)
{
	Queue::push('BriskSurf\Campaigns\ActionCampaignManager@process', array("user" => $user, "action" => $action, "data" => $data));
});