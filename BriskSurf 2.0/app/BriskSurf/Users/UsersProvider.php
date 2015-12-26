<?php namespace BriskSurf\Users;

use Auth;

class UsersProvider extends \BriskSurf\Helpers\BaseProvider {

	public function register()
	{	
		parent::load('Users');

		$this->commands('BriskSurf\Users\Commands\Midnight');

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			//ProcessEvent Alias
			$loader->alias('User', 'BriskSurf\Users\UserModel');
	      	});

	}

}