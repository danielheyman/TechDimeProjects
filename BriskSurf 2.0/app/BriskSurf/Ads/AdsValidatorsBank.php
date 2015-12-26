<?php namespace BriskSurf\Ads;

use Illuminate\Foundation\Application;

class AdsValidatorsBank extends \BriskSurf\Helpers\BaseValidatorsBank {

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->folder = "Ads";
	}
}