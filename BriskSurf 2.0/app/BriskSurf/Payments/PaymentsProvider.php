<?php namespace BriskSurf\Payments;

class PaymentsProvider extends \BriskSurf\Helpers\BaseProvider {

	public function register()
	{
		parent::load('Payments');

		$this->app->bind('payments.process_memberships', function($app) {
		    	return new Commands\ProcessMemberships;
		});

		$this->commands('payments.process_memberships');

		//\Log::debug("PackagesProvider registered");

		//SETTINGS SINGLETON
		$this->app->singleton('packages', function()
		{
		    	return new PackagesBank;
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			//SETTINGS FACADE
			$loader->alias('Packages', 'BriskSurf\Payments\PackagesFacade');
	      	});
	}

}