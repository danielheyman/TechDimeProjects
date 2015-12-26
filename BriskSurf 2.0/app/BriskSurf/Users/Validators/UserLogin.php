<?php namespace BriskSurf\Users\Validators;

class UserLogin extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$rules = array(
			'username' => 'required|alpha_num|exists:users,username',
			'password' => 'required|min:3'
		);
			
		$validator = \Validator::make($this->input(), $rules);
		
		if($validator->passes()) 
		{
			$username = $this->input('username');
			$password = $this->input('password');
			
			if(!\Auth::validate(array('username' => $username, 'password' => $password))) $this->error( ['password' => 'Your password is incorrect.'] );
			else
			{
				$user = \User::whereUsername($username)->first(['_id']);
				if($user->banned != null) $this->error( ['global' => 'Your account has been suspended. If you believe this is a mistake, please contact support.'] );
				else if($user->activation != null) $this->error( ['global' => 'You must click the activation link in the email we sent you.'] );
			}
		}
		else $this->error($validator);   
	}
}