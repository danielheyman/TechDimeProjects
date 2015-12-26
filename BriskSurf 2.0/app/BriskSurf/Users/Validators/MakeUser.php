<?php namespace BriskSurf\Users\Validators;

class MakeUser extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$rules = array(
			'username' => 'required|alpha_num|unique:users,username',
			'name' => array(
				'required',
				'min:5',
				"regex:[^[a-zA-Z._']+(?:[\s][a-zA-Z._']+)+$]"
			),
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:3|same:password_confirmation'
		);
		
		$validator = \Validator::make($this->input(), $rules);
		
		if($validator->passes())
		{
			$security = \SecureForm::check();
			if(!$security->passes()) $this->error( $security->errors() );
		}
		else $this->error($validator);
	}
}