<?php namespace BriskSurf\Lists\Commands;

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use BriskSurf\Lists\ListUserModel;

class Recheck extends ScheduledCommand {

	protected $name = 'lists:recheck';

	protected $description = 'Recheck any lists that are pending.';

	protected $listUser;

	public function __construct(ListUserModel $listUser)
	{
		parent::__construct();

		$this->listUser = $listUser;
	}

	public function schedule(Schedulable $scheduler)
	{
		return $scheduler;
	}

	public function fire()
	{
		$rechecks = $this->listUser->where('recheck', '<', \Carbon::now())->get();
		foreach($rechecks as $recheck)
		{
			\App::make('ListManager')->process(false, $recheck->list_id, $recheck->user_id);
		}
	}

}
