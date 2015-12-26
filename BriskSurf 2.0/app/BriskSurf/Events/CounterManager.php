<?php namespace BriskSurf\Events;

use \User;

class CounterManager {

	private $dayCounter;
	private $yearCounter;
	private $user;

	public function __construct(DayCounterModel $dayCounter, YearCounterModel $yearCounter, User $user)
	{
		$this->dayCounter = $dayCounter;
		$this->yearCounter = $yearCounter;
		$this->user = $user;
	}

	public function mongoTime($time = false)
	{
		if(!$time) $time = \Carbon::now();

		return new \MongoDate($time->getTimestamp());
	}

	public function processEvent($data)
	{
		$this->processDay($data);
		$this->processYear($data);
	}

	public function processDay($data)
	{
		foreach($data as $key => $value) ${$key} = $value;

		$now = \Carbon::now();

		$hours = [];
		$minutes = [];
		for($i = 0; $i < 24; $i++)
		{
			$hours[$i] = floatval(0);
			$minutes[$i] = [];
			for($j = 0; $j < 60; $j++) $minutes[$i][$j] = floatval(0);
		}

		$minute = $now->minute;
		$hour = $now->hour;
		$now->second = 0;
		$now->minute = 0;
		$now->hour = 0;
		$hours[$hour] = 1;
		$minutes[$hour][$minute] = 1;

		$inc = array('minute.' . $hour . '.' . $minute => floatval($amount));
		if($update_for != "minute") $inc["hour." . $hour] = floatval($amount);
		if($update_for != "minute" && $update_for != "hour") $inc["day"] = floatval($amount);
		$result = $this->increment($this->dayCounter, $now, $meta, $inc, $expireDay);

		if(!$result)
		{
			$counter = new $this->dayCounter;
			$counter->meta = $meta;
			$counter->hour = $hours;
			$counter->minute = $minutes;
			$counter->day = $amount;
			$counter->created_at = $this->mongoTime($now);
			$counter->expire = ($expireDay ? $this->mongoTime($expireDay) : false);
			$counter->save();
		}
	}

	public function processYear($data)
	{
		foreach($data as $key => $value) ${$key} = $value;

		$now = \Carbon::now();

		$months = [];
		$days = [];
		$daysInMonth = \Carbon::now();
		for($i = 0; $i < 12; $i++)
		{
			$months[$i] = floatval(0);
			$daysInMonth->month = $i + 1; 
			$days[$i] = [];
			for($j = 0; $j < $daysInMonth->daysInMonth; $j++) $days[$i][$j] = floatval(0);
		}

		$day = $now->day;
		$month = $now->month;
		$now->second = 0;
		$now->minute = 0;
		$now->hour = 0;
		$now->day = 1;
		$now->month = 1;
		$months[$month - 1] = 1;
		$days[$month - 1][$day - 1] = 1;


		$inc = array();
		if($update_for == "year") $inc["year"] = floatval($amount);
		if($update_for == "year" || $update_for == "month") $inc["month." . ($month - 1)] = floatval($amount);
		if($update_for != "minute" && $update_for != "hour") $inc["day." . ($month - 1) . '.' . ($day - 1)] = floatval($amount);

		if(count($inc) == 0) $result = $this->yearCounter->whereRaw(array('meta' => $meta, 'created_at' => $this->mongoTime($now)))->exists();
		else $result = $this->increment($this->yearCounter, $now, $meta, $inc, $expireYear);

		if(!$result)
		{
			$counter = new $this->yearCounter;
			$counter->meta = $meta;
			$counter->month = $months;
			$counter->day = $days;
			$counter->year = floatval($amount);
			$counter->created_at = $this->mongoTime($now);
			$counter->expire = ($expireYear ? $this->mongoTime($expireYear) : false);
			$counter->save();
		}
	}

	public function increment($counter, $date, $meta, $inc, $expire)
	{
		return $counter->raw()->findAndModify(
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

	public function graphDays($meta, $start, $end)
	{
		$dates = array();
		$copy_start = \Carbon::createFromTimeStamp( $start->timestamp);
		while($copy_start <= $end)
		{
			$dates[str_pad($copy_start->month, 2, '0', STR_PAD_LEFT) . "/" . str_pad($copy_start->day, 2, '0', STR_PAD_LEFT)] = 0;
			$copy_start->addDay();
		}

		$results = $this->yearCounter->where("updated_at", ">", $start)->orWhere("created_at", "<", $end)->whereRaw(array("meta" => $meta))->get();

		$start->day = 1;
		$start->hour = 0;
		$start->minute = 0;
		$start->second = 0;
		foreach($results as $result)
		{
			$date = $result["created_at"];
			for($month = 0; $month < 12; $month++)
			{
				if($date >= $start && $date <= $end)
				{
					foreach($result["day"][$date->month - 1] as $day => $value)
					{
						$day += 1;
						$date_string = str_pad($result["created_at"]->month, 2, '0', STR_PAD_LEFT) . "/" . str_pad($day, 2, '0', STR_PAD_LEFT);
						if(isset($dates[$date_string])) $dates[$date_string] = $value;
					}
				}
				$date->addMonth();
			}
			
		}
		return $dates;
	}
}