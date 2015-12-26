<?php

class PackageSeeder extends Seeder{
	
	public function run()
	{
		Package::truncate();
		
		$packages = [ 
			// Memberships
			["name" => "Premium Month", "cost" => 9, "renew" => "1 month", "type" => "membership", "value" => "premium", "active" => "premium month", "trial" => "none"],
			["name" => "Platinum Month", "cost" => 17, "renew" => "1 month", "type" => "membership", "value" => "platinum", "active" => "platinum month", "trial" => "none"],
			["name" => "Premium Annual", "cost" => 90, "renew" => "1 year", "type" => "membership", "value" => "premium", "active" => "premium annual", "trial" => "none"],
			["name" => "Platinum Annual", "cost" => 170, "renew" => "1 year", "type" => "membership", "value" => "platinum", "active" => "platinum annual", "trial" => "none"],
			// Credits
			["name" => "1,000 Credits", "cost" => 5, "renew" => "none", "type" => "credit", "value" => "1000", "active" => "true", "trial" => "none"],
			["name" => "2,500 Credits", "cost" => 10, "renew" => "none", "type" => "credit", "value" => "2500", "active" => "true", "trial" => "none"],
			["name" => "5,000 Credits", "cost" => 15, "renew" => "none", "type" => "credit", "value" => "5000", "active" => "true", "trial" => "none"],
			["name" => "10,000 Credits", "cost" => 20, "renew" => "none", "type" => "credit", "value" => "10000", "active" => "true", "trial" => "none"]
		];

		foreach($packages as $package) Package::create($package);
	}
}