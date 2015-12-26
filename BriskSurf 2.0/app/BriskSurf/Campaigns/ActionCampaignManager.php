<?php namespace BriskSurf\Campaigns;

use Event;
use BriskSurf\Email\EmailManager;
use BriskSurf\Notifications\NotificationsManager;
use Config;
use Input;

class ActionCampaignManager
{
	protected $actionCampaign;
	protected $email;
	protected $notification;

	public function __construct(ActionCampaignModel $actionCampaign, EmailManager $email, NotificationsManager $notification)
	{
		$this->actionCampaign = $actionCampaign;
		$this->email = $email;
		$this->notification = $notification;
	}

	public function getAll()
	{
		return $this->actionCampaign->all();
	}

	public function getAllActionKeys()
	{
		return array_keys(Config::get('events::actions'));
	}

	public function find($id)
	{
		$campaign = $this->actionCampaign->find($id);
		$results = $campaign->results;
		foreach($results as $key => $result)
		{
			$result[1] = $this->{$result[0]}->find($result[1]);
			$results[$key] = $result;
		}
		$campaign->results = $results;

		return $campaign;
	}

	public function createFromInput()
	{
		return $this->updateObjectFromInput(new $this->actionCampaign);
	}

	public function updateFromInput($id)
	{
		return $this->updateObjectFromInput($this->actionCampaign->find($id));
	}

	public function updateObjectFromInput($campaign)
	{
		$campaign->name = Input::get('name');
		$campaign->action = Input::get('action');
		$campaign->filters = json_decode(Input::get('filters'));

		$results = json_decode(Input::get('results'));
		foreach(array_filter($results, function($result) { return $result[1] == "new"; }) as $key => $result)
		{
			$result[1] = $this->{$result[0]}->newTransactional($campaign->id)->id;

			$results[$key] = $result;
		}

		foreach($campaign->results as $result)
		{
			$foundObjects = array_filter($results, function($value) use ($result) { return ($value[0] == $result[0] && $value[1] == $result[1]); });

			if(count($foundObjects) == 0) $this->{$result[0]}->deleteById($result[1]);
		}

		$campaign->results = $results;

		$campaign->save();

		return $campaign;
	}

	public function delete($id)
	{
		$campaign = $this->actionCampaign->find($id);

		foreach($campaign->results as $result) $this->{$result[0]}->deleteById($result[1]);
		$campaign->delete();
	}

	public function getSampleActionData($action)
	{
		foreach(Config::get('events::actions')[$action] as $attribute => $type)
		{
			if($type != "bool" && $type != "exist") $attributes[$attribute] = Config::get('events::action_samples')[$action][$attribute];
		}
		return $attributes;
	}

	public function process($job, $data)
	{
		$user = $data["user"];
		$action = $data["action"];
		$action_data = $data["data"];

		$user = \User::find($user);
		$campaigns = $this->actionCampaign->where('action', $action)->get()->toArray();
		foreach($campaigns as $campaign)
		{
			$lists = array_map(function($list) {
				return $list["list_id"];
			}, $user->lists()->where('status', 'on')->get(["list_id"])->toArray());

			$passed = true;
			foreach($campaign['filters'] as $filter_and)
			{
				$passed_or = false;
				foreach($filter_and as $filter_or)
				{
					if(in_array($filter_or, $lists)) $passed_or = true;
				}
				$passed = $passed && $passed_or;
			}
			if(!$passed) continue;

			foreach($campaign['results'] as $result)
			{
				if($result[2] != "off") Event::fire("campaign." . $result[0], array($result[1], $user->toArray(), $result[2], $action_data));
			}
		}
		$job->delete();
	}
}