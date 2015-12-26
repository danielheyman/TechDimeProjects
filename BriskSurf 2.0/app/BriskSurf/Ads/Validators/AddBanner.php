<?php namespace BriskSurf\Ads\Validators;

class AddBanner extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$rules = array(
			'image_url' => 'required|url',
			'target_url' => 'required|url'
		);
			
		$validator = \Validator::make($this->input(), $rules);
		
		if($validator->passes())
		{
			$image_size = GetImageSize($this->input('image_url'));
			if(!$image_size) $this->error(['image_url' => 'The image url must be an image.']);
			if($image_size[3] != 'width="468" height="60"') $this->error(['image_url' => 'The image size must be 468 by 60.']);
		}
		else $this->error($validator); 
	}
}