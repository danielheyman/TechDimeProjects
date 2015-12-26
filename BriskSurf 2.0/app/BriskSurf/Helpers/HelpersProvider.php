<?php namespace BriskSurf\Helpers;

class HelpersProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{	
		require 'helperFunctions.php';
	}

}