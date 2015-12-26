<?php namespace BriskSurf\Ads;

use Jenssegers\Mongodb\Model as Eloquent;

class BannerModel extends Eloquent {

    	protected $collection = 'banners';

    	public function user()
    	{
        		return $this->belongsTo('User');
    	}

}