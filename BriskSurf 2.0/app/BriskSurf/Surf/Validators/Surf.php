<?php namespace BriskSurf\Surf\Validators;

class Surf extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$user = \Auth::user();

		if($user->views_today % 36 == 0)
		{
			$security = \SecureForm::check();
			if(!$security->passes()) $this->error( $security->errors() );
		}
		
		if(!\Cache::has('hash_' . $user->id) || $this->input('hash') != md5(\Cache::get('hash_' . $user->id ) . $this->input('id') . $this->input('banner_id') ) ) $this->error(["global" => "You cannot have more than one surf tabs open at a time"]);
		
		if(!$this->input('rating') || $this->input('rating') < 1 || $this->input('rating') > 3)  $this->error(["global" => "An incorrect rating was entered"]);
	}
}