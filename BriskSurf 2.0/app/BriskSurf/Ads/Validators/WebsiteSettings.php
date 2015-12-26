<?php namespace BriskSurf\Ads\Validators;

class WebsiteSettings extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$user = \Auth::user();

		$rules = array(
			'credits' => 'numeric|required|between:0,' . ($user->credits + $this->input('website')->credits),
			'auto_assign' => 'integer|required|between:0,' . (100 - $user->auto_assign + $this->input('website')->auto_assign),
			'hours' => array(
				"regex:[^((1[0-2])|[1-9]) (a|p)m((,(1[0-2]|[1-9]) (a|p)m)?)+$]"
			),
			'days' => array(
				"regex:[^[a-z]+((,[a-z]+)?)+$]"
			)
		);

		$messages = array(
		    	'auto_assign.between' => 'The :attribute must be between :min - :max. You may have a maximum of 100% assigned between your websites.',
		);
		
		$validator = \Validator::make($this->input(), $rules, $messages);
		if(!$validator->passes()) $this->error($validator);
	}
}