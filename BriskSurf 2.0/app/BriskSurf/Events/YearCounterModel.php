<?php namespace BriskSurf\Events;

use Jenssegers\Mongodb\Model as Eloquent;

class YearCounterModel extends Eloquent {

	protected $collection = 'history_year_counters';
}