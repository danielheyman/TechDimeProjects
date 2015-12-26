<?php

if(Auth::check()) 
{
	$user = Auth::user();

	if($user->login_ip != Request::getClientIp())
	{
		$user->login_ip = Request::getClientIp();
		login_event_ip($user, $user->login_ip);
	}

	login_event($user);

	$user->last_login = Carbon::now();
	$user->save();
}