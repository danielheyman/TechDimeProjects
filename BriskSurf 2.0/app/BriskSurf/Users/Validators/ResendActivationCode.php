<?php namespace BriskSurf\Users\Validators;

class ResendActivationCode extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$rules = array(
			'email' => 'required|email|exists:users,email'
		);
			
		$validator = \Validator::make($this->input(), $rules);
		
		if($validator->passes()) 
		{
			$user = \User::whereEmail($this->input('email'))->first();
			
			if($user->having('activation', 'exists', true)->get(['_id'])->isEmpty()) $this->error( ['global' => 'This account has already been activated.'] );
		}
		else $this->error($validator);
	}
}