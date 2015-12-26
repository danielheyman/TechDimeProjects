<?php namespace BriskSurf\Ads\Validators;

class WebsiteAssign extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$user = $this->input('user');

		$quick_assign_list = array("mass");
		foreach($this->input('websites') as $website) $quick_assign_list[] = $website->id;

		if(count($quick_assign_list) == 1) $this->error(['global', 'Cannot quick assign, no websites found.']);
		else
		{
			$rules = array(
				'quick_assign' => array('required', 'in:' . implode(',', $quick_assign_list)),
				'number_of_credits' => 'numeric|required|between:1,' . ($user->credits)
			);
			
			$validator = \Validator::make($this->input(), $rules);
			if(!$validator->passes()) $this->error($validator);
		}
	}
}