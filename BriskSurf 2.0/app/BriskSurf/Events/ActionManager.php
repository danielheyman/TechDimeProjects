<?php namespace BriskSurf\Events;

use \User;

class ActionManager {

	private $action;
	private $user;

	public function __construct(ActionModel $action, User $user)
	{
		$this->action = $action;
		$this->user = $user;
	}

	public function makeConditions($data)
	{
		$new = array();
		foreach($data as $key => $value) $new["records." . $key] = $value; 
		return $new;
	}

	public function mongoTime($time = false)
	{
		if(!$time) $time = \Carbon::now();

		return new \MongoDate($time->getTimestamp());
	}

	public function processEvent($data)
	{
		foreach($data as $key => $value) ${$key} = $value;

		$this->createAction($meta, $other_meta, $data, $expire);
	}

	public function createAction($meta, $other_meta, $data, $expire) 
	{
		$data = array_merge($data, array("created_at" => $this->mongoTime(), "updated_at" => $this->mongoTime(), "_id" => new \MongoId()));

		$this->action->raw()->findAndModify(
			array(
				'meta' => $meta,
				'count' => array( '$lt' => 100 )
			), 
			array(
				'$inc' => array( "count" => 1 ),
				'$push' => array( 'records' => $data ),
				'$currentDate' => array( 'updated_at' => true ),
				'$setOnInsert' => array( 'created_at' => $this->mongoTime(), 'other_meta' => $other_meta, 'expire' => ($expire ? $this->mongoTime($expire) : false) )
			), 
			null,
			array(
				'upsert' => true,
				'new' => true
			)
		);
	}
 	
 	public function getActions($conditions) 
 	{
		$vars = array( 'meta' => false, 'start' => false, 'end' => false, 'conditions' => array(), 'sort' => 'created_at' );
		$result = array_merge($vars, $conditions);
		foreach($result as $key => $value) ${$key} = $value;

		if(!$meta) return array();

		if(is_array($meta))$query = $this->action->whereRaw(array('meta' => $meta));
		else $query = $this->action->whereRaw(array('meta.type' => $meta));

		if($start) $query = $query->where('updated_at', '>=', $start);
		if($end) $query = $query->where('created_at', '<=', $end);
		if(count($conditions) != 0) $query = $query->whereRaw($this->makeConditions($conditions));
		
		$result = $query->get();
		$results = array();

		foreach($result as $action)
		{
			$meta = $action->meta;
			$other_meta = $action->other_meta;
			$records = $action->records()->get();

			foreach($records as $record)
			{
				$record = (object) $record;

				$passed = true;
				
				if($start != null && $record->updated_at <= $start) $passed = false;
				if($end != null && $record->created_at >= $end) $passed = false;

				$conditions = array_where($conditions, function($key, $value) use($record)
				{
					$key = $record->{$key};
					if(is_array($value))
					{
						foreach($value as $k => $v)
						{
							if($k == '$ne') return ($key != $v);
							else if($k == '$gt') return ($key > $v);
							else if($k == '$gte') return ($key >= $v);
							else if($k == '$in') return (in_array($key, $v));
							else if($k == '$lt') return ($key < $v);
							else if($k == '$lte') return ($key <= $v);
							else if($k == '$nin') return (!in_array($key, $v));
						}
					}
					else return ($key == $value);
				});
	
				if($passed)
				{
					if($record->created_at != $record->updated_at) $record->minutes = round($record->updated_at->diffInSeconds( $record->created_at ) / 60, 2);
					$results[] = (object) ["meta" => $meta, "other_meta" => $other_meta, "data" => $record];
				}
			}
		}

		$results = array_values(array_sort($results, function($value) use($sort)
		{
		    	return $value->data->{ $sort };
		}));

		return $results;
 	}
}