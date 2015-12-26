<?php namespace BriskSurf\Events;

use Jenssegers\Mongodb\Model as Eloquent;

class MegaCounterModel extends Eloquent {

	protected $collection = 'history_mega_counters';
}