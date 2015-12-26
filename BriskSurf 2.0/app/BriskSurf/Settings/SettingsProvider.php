<?php namespace BriskSurf\Settings;

class SettingsProvider extends \Illuminate\Support\ServiceProvider {

	public function register()
	{

		//SETTINGS SINGLETON
		$this->app->singleton('settings', function()
		{
		    	return new SettingsBank;
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();

			//SETTINGS FACADE
			$loader->alias('Settings', 'BriskSurf\Settings\SettingsFacade');
		});
	}

}