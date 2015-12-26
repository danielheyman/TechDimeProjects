<?php namespace BriskSurf\Ads;

use Jenssegers\Mongodb\Model as Eloquent;

class WebsiteModel extends Eloquent {

    	protected $collection = 'websites';

    	public function user()
    	{
        		return $this->belongsTo('User');
    	}

}