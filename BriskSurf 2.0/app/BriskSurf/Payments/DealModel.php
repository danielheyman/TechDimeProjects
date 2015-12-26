<?php namespace BriskSurf\Payments;

use Jenssegers\Mongodb\Model as Eloquent;

class DealModel extends Eloquent {

	protected $dates = array("expires");
	
    	public function package()
    	{
        		return $this->belongsTo('Package');
    	}
}