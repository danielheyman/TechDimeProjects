<?php namespace BriskSurf\Helpers;

use Illuminate\Foundation\Application;

abstract class BaseValidatorsBank {

	protected $validators;
	protected $folder;

	public function get($validator)
	{
		if(!isset($this->validators[$validator]))
		{
			$this->validators[$validator] = $this->app->make("BriskSurf\\" . $this->folder . "\Validators\\" . $validator);
		}

		return $this->validators[$validator];
	}
}