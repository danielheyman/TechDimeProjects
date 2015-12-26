<?php

class SurfSeeder extends Seeder {
	
	public function run() 
	{
		Banner::truncate();
		Website::truncate();

		$user = User::create(array(
			"username" => "danheyman",
		    	"name" => "Daniel Heyman",
		    	"email" => "heymandan@gmail.com",
		    	"password" => "hello",
		    	"newsletter" => true,
		    	"admin_emails" => true,
		    	"membership" => "platinum",
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

		for($x = 0; $x < 20; $x++)
		{
			$website = new Website;
			$website->url = "http://listviral.com";
			$website->enabled = true;
			$website->credits = 10000;
			$website->views = 0;
			$website->days = array();
			$website->hours = array();
			$user->websites()->save($website);

			$banner = new Banner;
			$banner->banner = "http://brisksurf.com/banner.png";
			$banner->url = "http://brisksurf.com";
			$banner->enabled = true;
			$banner->credits = 10000;
			$banner->views = 0;
			$banner->days = array();
			$banner->hours = array();
			$user->banners()->save($banner);
		}

	}
}