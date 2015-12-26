<?php namespace BriskSurf\Helpers;

use View;

abstract class BaseProvider extends \Illuminate\Support\ServiceProvider {

	public function load($folder)
	{	
		$base_path = base_path() . "/app/BriskSurf/{$folder}";

		//Add configs
		$files = $this->app['files']->files("{$base_path}/Config");
		foreach($files as $file)
		{
			$config = $this->app['files']->getRequire($file);
			$name = $this->app['files']->name($file);
			
			$this->app['config']->set(lcfirst($folder) . "::" . $name, $config);
		}

		//Add views
		View::addNamespace(lcfirst($folder), "{$base_path}/Views");
		
		//Add routes
		if(file_exists("{$base_path}/routes.php")) require "{$base_path}/routes.php";
	}

}