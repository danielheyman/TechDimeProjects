<?php namespace BriskSurf\Events;

use \User;

class MegaCounterManager {

	private $counter;
	private $user;

	public function __construct(MegaCounterModel $counter, User $user)
	{
		$this->counter = $counter;
		$this->user = $user;
	}

	public function mongoTime($time = false)
	{
		if(!$time) $time = \Carbon::now();

		return new \MongoDate($time->getTimestamp());
	}

	public function processEvent($data)
	{
		foreach($data as $key => $value) ${$key} = $value;

		$now = \Carbon::now();

		$fieldData = array();
		foreach($fields as $field)
		{
			if(!isset($update_for[$field])) $update_for[$field] = "month";
			$fieldData[$field] = array("month" => (isset($inc[$field])) ? floatval($inc[$field]) : floatval(0), "day" => array());

			for($i = 0; $i < $now->daysInMonth; $i++)
			{
				$fieldData[$field]["day"][$i] = ($i + 1 == $now->day && isset($inc[$field])) ? floatval($inc[$field]) : floatval(0);
			}
		}

		$inc_new = array();
		foreach($inc as $field => $amount)
		{
			$inc_new[$field . ".day." . ($now->day - 1)] = floatval($amount);
			if($update_for[$field] == "month") $inc_new[$field . ".month"] = floatval($amount);
		}

		$now->second = 0;
		$now->minute = 0;
		$now->hour = 0;
		$now->day = 1;

		$result = $this->increment($now, $meta, $inc_new, $expire);

		if(!$result)
		{
			$counter = new $this->counter;
			$counter->meta = $meta;
			foreach($fieldData as $field => $value)
			{
				$counter->$field = $value;
			}
			$counter->created_at = $this->mongoTime($now);
			$counter->expire = ($expire ? $this->mongoTime($expire) : false);
			$counter->save();
		}
	}

	public function increment($date, $meta, $inc, $expire)
	{
		return $this->counter->raw()->findAndModify(
			array(
				'meta' => $meta,
				'created_at' => $this->mongoTime($date)
			),
			array(
				'$inc' => $inc,
				'$set' => array( 'expire' => ($expire ? $this->mongoTime($expire) : false) ),
				'$currentDate' => array( 'updated_at' => true)
			)
		);
	}

	public function graph($meta, $start, $end, $fields)
	{
		$dates = array();
		foreach($fields as $field) $dates[$field] = array();
		while($start <= $end)
		{
			foreach($fields as $field) $dates[$field][str_pad($start->month, 2, '0', STR_PAD_LEFT) . "/" . str_pad($start->day, 2, '0', STR_PAD_LEFT)] = 0;
			$start->addDay();
		}

		$results = $this->counter->where("updated_at", ">", $start)->orWhere("created_at", "<", $end)->whereRaw(array("meta" => $meta))->get();
		foreach($results as $result)
		{
			foreach($fields as $field)
			{
				foreach($result[$field]["day"] as $day => $value)
				{
					$day += 1;
					$date_string = str_pad($result["created_at"]->month, 2, '0', STR_PAD_LEFT) . "/" . str_pad($day, 2, '0', STR_PAD_LEFT);
					if(isset($dates[$field][$date_string])) $dates[$field][$date_string] = $value;
				}
			}
		}
		return $dates;
	}
}