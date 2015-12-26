<?php namespace BriskSurf\Lists;

class ListsProvider extends \BriskSurf\Helpers\BaseProvider {

	public function register()
	{	
		parent::load("Lists");

		$this->app->bind('list.process', function($app) {
		    	return new Commands\Process(new ListModel);
		});

		$this->commands('list.process');

		$this->app->bind('list.recheck', function($app) {
		    	return new Commands\Recheck(new ListUserModel);
		});

		$this->commands('list.recheck');
	}

}