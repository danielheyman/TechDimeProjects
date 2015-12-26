<?php namespace BriskSurf\Surf;

use Illuminate\Foundation\Application;

class SurfValidatorsBank extends \BriskSurf\Helpers\BaseValidatorsBank {

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->folder = "Surf";
	}
}