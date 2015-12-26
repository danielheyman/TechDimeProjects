<?php namespace BriskSurf\Events;

use Jenssegers\Mongodb\Model as Eloquent;

class ActionModel extends Eloquent {

	protected $collection = 'history_actions';
	
	public function records()
	{
		return $this->embedsMany('BriskSurf\Events\RecordActionModel');
	}
}








