<?php namespace BriskSurf\Payments;

use Jenssegers\Mongodb\Model as Eloquent;

class SubscriptionModel extends Eloquent {

    	protected $collection = 'subscriptions';

	protected $dates = array('expires');

    	public function user()
    	{
        		return $this->belongsTo('User');
   	}

}