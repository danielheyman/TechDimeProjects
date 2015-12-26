<?php namespace BriskSurf\Users\Validators;

class ActivateAccount extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		if(\User::whereActivation($this->input('code'))->get(['_id'])->isEmpty()) 
			$this->error( ['subject' => 'Oops!', 'message' => 'Invalid activation code. Are you sure you have not already activated your account?'] );
	}
}