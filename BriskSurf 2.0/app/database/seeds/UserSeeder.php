<?php

class UserSeeder extends Seeder {
	
	public function run() 
	{
		User::truncate();

		$user = User::create(array(
			"username" => "danielheyman",
		    	"name" => "Daniel Heyman",
		    	"email" => "daniel.heyman@gmail.com",
		    	"password" => "hello",
		    	"newsletter" => true,
		    	"admin_emails" => true,
		    	"membership" => "platinum",
		    	"admin" => true,
		    	"paypal" => "",
		    	"membership_expires" => Carbon::now()->addMonth(),
		    	"referrals" => 0,
		    	"upline" => "",
		    	"cash" => 0,
		    	"credits"=> 0,
		    	"credits_today"=> 0,
		    	"views_total" => 0,
		    	"views_today" => 0,
			'auto_assign' => 0,
			'register_ip' => Request::getClientIp(),
			'last_login' => Carbon::now()
		));

		register_event($user, Request::getClientIp(), "http://activation.link");
		login_event($user);

	}
}