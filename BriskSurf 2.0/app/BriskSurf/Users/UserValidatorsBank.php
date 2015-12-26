<?php namespace BriskSurf\Users;

use Illuminate\Foundation\Application;

class UserValidatorsBank extends \BriskSurf\Helpers\BaseValidatorsBank {

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->folder = "Users";
	}
}