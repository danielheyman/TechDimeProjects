<?php namespace BriskSurf\Users\Validators;

class SetupTargeting extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$targeting = Config::get('users::targeting');

		$rules = array(
			'gender' => array('required', 'in:' . implode(',', $targeting['genders'])),
			'continent' => array('required', 'in:' . implode(',', $targeting['continents'])),
			'year' => array('required', 'in:' . implode(',', $targeting['years'])),
		);
		
		$validator = \Validator::make($this->input(), $rules);
		if(!$validator->passes()) $this->error($validator);
	}
}