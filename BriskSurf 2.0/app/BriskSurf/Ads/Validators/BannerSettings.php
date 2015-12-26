<?php namespace BriskSurf\Ads\Validators;

class BannerSettings extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$rules = array(
			'credits' => 'numeric|required|between:0,' . ($this->input('user')->credits + $this->input('banner')->credits),
			'hours' => array(
				"regex:[^((1[0-2])|[1-9]) (a|p)m((,(1[0-2]|[1-9]) (a|p)m)?)+$]"
			),
			'days' => array(
				"regex:[^[a-z]+((,[a-z]+)?)+$]"
			)
		);
		
		$validator = \Validator::make($this->input(), $rules);
		if(!$validator->passes()) $this->error($validator);
	}
}