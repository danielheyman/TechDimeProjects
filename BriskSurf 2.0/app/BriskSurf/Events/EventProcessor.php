<?php namespace BriskSurf\Events;

use Event;

class EventProcessor
{
	protected $action;
	protected $counter;
	protected $megaCounter;

	public function __construct(ActionManager $action, CounterManager $counter, MegaCounterManager $megaCounter)
	{
		$this->action = $action;
		$this->counter = $counter;
		$this->megaCounter = $megaCounter;
	}

	public function action($job, $data)
	{
	        	if(isset($data['meta']))
	        	{
		        	if(!isset($data['other_meta'])) $data['other_meta'] = array();
		        	if(!isset($data['data'])) $data['data'] = array();
		        	$data['no_expire'] = (isset($data['no_expire']) && $data['no_expire'] == true) ? false : \Carbon::now()->addDays(90);
			if(isset($data['no_expire'])) unset($data['no_expire']);
		
		        	$this->action->processEvent($data);

			if(isset($data['meta']['user'])) Event::fire("user.made_action", array($data['meta']['user'], $data['meta']['type'], $data['data']));
			/*{

				$this->actionCampaign->process($data['meta']['user'], $data['meta']['type'], $data['data']);
				$this->listManager->processAction($data['meta']['type'], $data['meta']['user']);
			}*/
		}

	        	$job->delete();
	}

	public function counter($job, $data)
	{
		if(isset($data['meta']))
		{
			$process_event = true;
			$data['amount'] = (isset($data['amount'])) ? floatval($data['amount']) : 1;
			if(!isset($data['completely_unique'])) $data['update_for'] = "year";
			else
			{
				$date = \Carbon::parse($data['completely_unique']['date']);
				$now = \Carbon::now();
				if($now->year != $date->year) $data['update_for'] = "year";
				else if($now->month != $date->month) $data['update_for'] = "month";
				else if($now->day != $date->day) $data['update_for'] = "day";
				else if($now->hour != $date->hour) $data['update_for'] = "hour";
				else if($now->minute != $date->minute) $data['update_for'] = "minute";
				else $process_event = false;

				unset($data['completely_unique']);
			}
			if(isset($data['unique_to_minute']))
			{
				$date = \Carbon::parse($data['unique_to_minute']['date']);
				$now = \Carbon::now();
				if($now->year == $date->year &&
					$now->month == $date->month &&
					$now->day == $date->day &&
					$now->hour == $date->hour &&
					$now->minute == $date->minute
					) $process_event = false;

				unset($data['unique_to_minute']);
			}

		        	$data['expireDay'] = \Carbon::now()->addDays(7);
		        	$data['expireYear'] = (isset($data['no_expire']) && $data['no_expire'] == true) ? false : \Carbon::now()->addDays(365);
			if(isset($data['no_expire'])) unset($data['no_expire']);

			if($process_event) $this->counter->processEvent($data);
		}
		$job->delete();
	}

	public function megaCounter($job, $data)
	{
		if(isset($data['meta']))
		{
			$process_event = true;

			$inc = array();
			foreach($data['fields'] as $field => $amount)
			{
				if($amount != 0) $inc[$field] = $amount;
			}
			$data["fields"] = array_keys($data['fields']);

			$data['update_for'] = array();	

			if(isset($data['completely_unique']))
			{
				$now = \Carbon::now();

				foreach($data['completely_unique'] as $field => $date)
				{
					$inc[$field] = intval($inc[$field]);

					$date = \Carbon::parse($date['date']);

					if($now->year == $date->year && $now->month == $date->month)
					{
						$data['update_for'][$field] = "day";
						if($now->day == $date->day) unset($inc[$field]);
					}
					else $data['update_for'][$field] = "month";
				}

				if(count($inc) == 0) $process_event = false;

				unset($data['completely_unique']);
			}

			$data['expire'] = (isset($data['no_expire']) && $data['no_expire'] == true) ? false : \Carbon::now()->addDays(365);
			if(isset($data['no_expire'])) unset($data['no_expire']);

			$data['inc'] = $inc;

			if($process_event) $this->megaCounter->processEvent($data);
		}
		$job->delete();
	}
}