<?php namespace BriskSurf\Events;

use Jenssegers\Mongodb\Model as Eloquent;

class DayCounterModel extends Eloquent {

	protected $collection = 'history_day_counters';
}