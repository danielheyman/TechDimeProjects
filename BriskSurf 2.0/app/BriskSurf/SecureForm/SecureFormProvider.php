<?php namespace BriskSurf\SecureForm;

class SecureFormProvider extends \BriskSurf\Helpers\BaseProvider {

	public function register()
	{	
		parent::load('SecureForm');

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			//ProcessEvent Alias
			$loader->alias('SecureForm', 'BriskSurf\SecureForm\SecureFormFacade');
	      	});

	}

}