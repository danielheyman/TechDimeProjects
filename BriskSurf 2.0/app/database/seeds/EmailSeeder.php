c<?php

class EmailSeeder extends Seeder{
	
	public function run() 
	{
		$emails = array(
			"remind" => 'Hi {{ $name}},\r\n\r\nWe have changed your password. Make sure to update your password in your settings as soon as you login.\r\nTemporary Password: {{ $pass }}\r\n\r\nYou may login <a href="{{ $url }}">here</a>.\r\n\r\nBest Regards,\r\nThe TechDime Team',
    				"register" => 'Hi {{ $name }},\r\n\r\nWelcome to SurfDuel!\r\n\r\nClick <a href="{{ $url }}">here</a> to confirm your account.\r\n\r\nBest Regards,\r\nThe SurfDuel Team'
		);

		foreach($emails as $key => $value) $emails[$key] = str_replace('\r\n', "\r\n", $value);

		/*DB::collection('settings')->insert(array(
			"_id" => "emails",
			"list" => $emails
		));*/
	}
}