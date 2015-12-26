<?php

use App\Modules\Payments\Models\Package as Package;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		Setting::truncate();
		App\Modules\History\Models\HistoryAction::truncate();
		
		$this->call("GeneralSettingsSeeder");
		$this->call("AdminSeeder");
		$this->call("PackageSeeder");
		$this->call("EmailSeeder");
		$this->call("UserSeeder");
		$this->call("SurfSeeder");
	}
}