<?php namespace BriskSurf\Users\Validators;

class RemindPassword extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$rules = array(
			'email' => 'required|email|exists:users,email'
		);
			
		$validator = \Validator::make($this->input(), $rules);
		
		if(!$validator->passes()) $this->error($validator);
	}
}