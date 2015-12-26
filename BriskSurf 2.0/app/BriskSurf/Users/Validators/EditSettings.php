<?php namespace BriskSurf\Users\Validators;

use Config;

class EditSettings extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$targeting = Config::get('users::targeting');

		$rules = array(
			'name' => array(
				'required',
				'min:3',
				'regex:[^[a-zA-Z\s._]+$]',
				'regex:[[[:space:]]]'
			),
			'email' => 'required|email|unique:users,email,' . \Auth::user()->id . ',_id',
			'paypal' => 'email',
			'password' => 'min:3|same:password_confirmation',
			'continent' => array('required', 'in:' . implode(',', array_keys($targeting['continents']))),
			'year' => array('required', 'in:' . implode(',', array_keys($targeting['years'])))
		);
		
		$validator = \Validator::make($this->input(), $rules);
		if(!$validator->passes()) $this->error($validator);
	}
}