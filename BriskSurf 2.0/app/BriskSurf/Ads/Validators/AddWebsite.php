<?php namespace BriskSurf\Ads\Validators;

class AddWebsite extends \BriskSurf\Helpers\BaseValidationResult {

	public function validate() 
	{
		$user = \Auth::user();
		$website_count = $user->websites->count();

		$rules = array(
			'website' => 'required|url'
		);
			
		$validator = \Validator::make($this->input(), $rules);
		
		if($validator->passes())
		{
			if($website_count + 1 >= \Settings::get("memberships")[$user->membership]['maximum_websites']) $this->error( ['website' => 'You have reached the maximum number of websites allowed for your membership level.'] );
			else
			{
				$website = str_replace("&amp;", "&", html_entity_decode($this->input('website')));
			        	$spam = @file_get_contents("http://techdime.com/spam.php?url=" . $website);
			        	
			        	if($spam != "0") $this->error( ['website' => 'The inputed website has been suspended. If you believe this is a mistake, please contact support.'] );
			}
		}
		else $this->error($validator); 
	}
}