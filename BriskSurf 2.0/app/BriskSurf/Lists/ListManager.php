<?php namespace BriskSurf\Lists;

use BriskSurf\Events\ActionManager;
use User;
use Carbon;

class ListManager
{
	protected $user;
	protected $listUser;
	protected $list;
	protected $action;

	public function __construct(User $user, ListUserModel $listUser, ListModel $list, ActionManager $action)
	{
		$this->user = $user;
		$this->listUser = $listUser;
		$this->list = $list;
		$this->action = $action;
	}

	public function getAllWithName()
	{
		return $this->list->get(['name']);
	}

	public function processAttribute($job, $attributes)
	{
		$lists = $this->list->where('status', 'processed')->get()->filter(function($list) use($changed) 
		{
			$changes = array();
			foreach($attributes as $key)
			{
				$changes[] = "attribute." . $key;
			}
			return count(array_intersect($changes, $list->dependencies)) != 0;
		});

		foreach($lists as $list)
		{
			$list->status = "process";
			$list->save();
		}

		$job->delete();
	}

	public function processAction($job, $data)
	{
		$type = $data["action"];
		$user_id = $data["user"];

		$lists = $this->list->where('status', 'processed')->get()->filter(function($list) use($type) 
		{
			return in_array("action." . $type, $list->dependencies);
		});

		foreach($lists as $list)
		{
			$this->process(false, $list->id, $user_id);
		}

		$job->delete();
	}

	public function processUser($job, $data)
	{
		$lists = $this->list->where('status', 'processed')->get()->filter(function($list) use($data) 
		{
			$changes = array();
			foreach($data['changed'] as $key)
			{
				$changes[] = "attribute." . $key;
			}
			return count(array_intersect($changes, $list->dependencies)) != 0;
		});

		foreach($lists as $list)
		{
			$this->process(false, $list->id, $data['user']);
		}

		$job->delete();
	}

	public function processAttributeOr($list_recheck_or, $status_recheck_or, $list_or, $data_or, $user_id)
	{
		$comparison = $this->getData($data_or['comparison'], $data_or['value'], "c");
		$value = $this->getData($data_or['comparison'], $data_or['value'], "v");

		$users = ($user_id) ? $this->user->where('_id', $user_id)->where($data_or['field'], $comparison, $value)->get(['_id'], $data_or['field']) : 
			$this->user->where($data_or['field'], $comparison, $value)->get(['_id', $data_or['field']]);

		foreach($users as $user)
		{
			if($data_or['comparison'] == "is a timestamp after")
			{
				$date = Carbon::now()->addSeconds($user[$data_or['field']]->timestamp - $value->timestamp);

				//If the user doesn't have an alternative or field with a non-recheck status, then enter it into into the list checker 
				if(!in_array($user->id, $list_or) || isset($status_recheck_or[$user->id])) $list_recheck_or[$user->id] = $date;
				//If the user does have an alternative or field and it requires a recheck, then set the later required date
				else if(in_array($user->id, $list_or) && isset($list_recheck_or[$user->id]) && $list_recheck_or[$user->id] < $date) $list_recheck_or[$user->id] = $date;
			}
			//If it does not require a recheck and a recheck is stored, get rid of it
			else if(isset($list_recheck_or[$user->id])) unset($list_recheck_or[$user->id]);

			//If it is not in the list or, then add it in
			if(!in_array($user->id, $list_or)) $list_or[] = $user->id;

			//If a status recheck is set, get rid of it because a match was found
			if(isset($status_recheck_or[$user->id])) unset($status_recheck_or[$user->id]);
		}

		if($data_or['comparison'] == "is a timestamp before")
		{
			$comparison = ">";
			$users = ($user_id) ? $this->user->where('_id', $user_id)->where($data_or['field'], $comparison, $value)->get(['_id', $data_or['field']]) : 
				$this->user->where($data_or['field'], $comparison, $value)->get(['_id', $data_or['field']]);

			foreach($users as $user)
			{
				if(!in_array($user->id, $list_or) || isset($status_recheck_or[$user->id]))
				{
					$date = Carbon::now()->addSeconds($user[$data_or['field']]->timestamp - $value->timestamp);
					//If the status recheck does not exist, then set it
					if(!isset($status_recheck_or[$user->id])) $status_recheck_or[$user->id] = $date;
					//If there is a sooner alternative, then replace it
					else if($status_recheck_or[$user->id] > $date) $status_recheck_or[$user->id] = $date;
				}

				if(!in_array($user->id, $list_or))
				{
					$list_or[] = $user->id;
				}
			}
		}

		return [$list_recheck_or, $status_recheck_or, $list_or];
	}

	public function processActionOr($list_recheck_or, $status_recheck_or, $list_or, $data_or, $user_id)
	{
		$actions = $this->action->getActions(array(
			'meta' => (!$user_id) ? $data_or['field'] : array(
				'type' => $data_or['field'],
				'user' => $user_id
			),
			'start' => ($data_or['within'] == "start") ? false : Carbon::now()->subDays($data_or['within'])
		));

		$users = array();
		$users_recheck = array();

		foreach($actions as $action)
		{
			if($data_or['within'] != 'signup')
			{
				$date = (Carbon::now()->addSeconds($action->data->created_at->timestamp - Carbon::now()->subDays($data_or['within'])->timestamp));

				//If it doesn't exist in the users recheck, then add it in
				if(!isset($users_recheck[$action->meta["user"]])) $users_recheck[$action->meta["user"]] = $date;
				//If it does exist, and a sooner recheck is required, add it in
				else if($users_recheck[$action->meta["user"]] > $date) $users_recheck[$action->meta["user"]] = $date;
			}
			if(isset($users[$action->meta["user"]])) $users[$action->meta["user"]]++;
			$users[$action->meta["user"]] = 1;
		}

		foreach($users as $user => $frequency)
		{
			if(($frequency >= $data_or['frequency']) == $data_or['performed'])
			{
				if(isset($users_recheck[$user]))
				{

					//If the user doesn't have an alternative or field with a non-recheck status, then enter it into into the list checker 
					if(!in_array($user, $list_or) || isset($status_recheck_or[$user])) $list_recheck_or[$user] = $users_recheck[$user];
					//If the user does have an alternative or field and it requires a recheck, then set the later required date
					else if(in_array($user, $list_or) && isset($list_recheck_or[$user]) && $list_recheck_or[$user] < $date) $list_recheck_or[$user] = $users_recheck[$user];
				}
				
				if(!in_array($user, $list_or)) $list_or[] = $user;

				//If a status recheck is set, get rid of it because a match was found
				if(isset($status_recheck_or[$user])) unset($status_recheck_or[$user]);
			}
		}

		return [$list_recheck_or, $status_recheck_or, $list_or];
	}

	public function process($job, $list_id, $user_id = false)
	{
		$list = (is_string($list_id)) ? $this->list->find($list_id) : $list_id;

		$dependencies = array();
		$list_and = false;
		$list_recheck = array();
		$status_recheck = array();

		foreach($list->data as $data_and)
		{
			$list_recheck_or = array();
			$status_recheck_or = array();
			$list_or = array();
			foreach($data_and as $data_or)
			{
				$dependencies[] = $data_or['type'] . "." . $data_or['field'];

				$methodName = "process" . ucfirst($data_or['type']) . "Or";
				$result = $this->{$methodName}($list_recheck_or, $status_recheck_or, $list_or, $data_or, $user_id);
				$list_recheck_or = $result[0];
				$status_recheck_or = $result[1];
				$list_or = $result[2];
			}
			foreach($status_recheck_or as $user => $date)
			{
				//If it doesn't exist, add it in
				if(!isset($status_recheck[$user])) $status_recheck[$user] = $date;
				//If it does exist, select the latest status recheck it depends on
				if(isset($status_recheck[$user]) && $status_recheck[$user] < $date) $status_recheck[$user] = $date;
			}
			foreach($list_recheck_or as $user => $date)
			{
				//If it doesn't exist, add it in
				if(!isset($list_recheck[$user])) $list_recheck[$user] = $date;
				//If it does exist, select the soonest required recheck
				if(isset($list_recheck[$user]) && $list_recheck[$user] > $date) $list_recheck[$user] = $date;
			}

			if(!$list_and) $list_and = $list_or;
			else
			{
				$list_and = array_intersect($list_or, $list_and);
			}
		}

		if($user_id)
		{
			$listUser = $this->listUser->where('user_id', $user_id)->where('list_id', $list->id)->first();
			if($listUser != null && count($list_and) == 0)
			{
				$listUser->delete();
				$list->decrement('user_count');
			}
			else if($listUser != null || ($listUser == null && count($list_and) == 1))
			{
				if($listUser == null && !isset($status_recheck[$user_id])) $list->increment('user_count');
				else if($listUser != null && $listUser->status == "on" && isset($status_recheck[$user_id])) $list->decrement('user_count');

				$user = ($listUser != null) ? $listUser : new $this->listUser;
				$user->name = $list->name;
				if($listUser == null)
				{
					$user->list_id = $list->id;
					$user->user_id = $user_id;
				}
				if(isset($status_recheck[$user_id]))
				{
					$user->status = "recheck";
					$user->recheck = $status_recheck[$user_id];
				}
				else
				{
					$user->status = "on";
					$user->recheck = (isset($list_recheck[$user_id])) ? $list_recheck[$user_id] : false;
				}
				$user->save();
			}
		}
		else
		{
			$user_count = 0;
			$this->listUser->where('list_id', $list->id)->delete();
			foreach($list_and as $id)
			{
				$user = new $this->listUser;
				$user->name = $list->name;
				$user->list_id = $list->id;
				$user->user_id = $id;
				if(isset($status_recheck[$id]))
				{
					$user->status = "recheck";
					$user->recheck = $status_recheck[$id];
				}
				else
				{
					$user_count++;
					$user->status = "on";
					$user->recheck = (isset($list_recheck[$id])) ? $list_recheck[$id] : false;
				}
				$user->save();
			}
			$list->status = 'processed';
			$list->dependencies = $dependencies;
			$list->user_count = $user_count;
			$list->save();
		}

		if($job) $job->delete();
	}

	public function getData($comparison, $value, $type)
	{
		switch($comparison)
		{
			case("is equal to"):
				if($type == "c") return "=";
				return $value;
				break;
			case("is not equal to"):
				if($type == "c") return "!=";
				return $value;
				break;
			case("is greater than"):
				if($type == "c") return ">";
				return $value;
				break;
			case("is less than"):
				if($type == "c") return "<";
				return $value;
				break;
			case("is true"):
				if($type == "c") return "=";
				return true;
				break;
			case("is false"):
				if($type == "c") return "=";
				return false;
				break;
			case("is a timestamp after"):
				if($type == "c") return ">";
				return Carbon::now()->subDays($value);
				break;
			case("is a timestamp before"):
				if($type == "c") return "<";
				return Carbon::now()->subDays($value);
				break;
			case("exists"):
				if($type == "c") return "exists";
				return true;
				break;
			case("does not exist"):
				if($type == "c") return "exists";
				return false;
				break;
		}
	}
}