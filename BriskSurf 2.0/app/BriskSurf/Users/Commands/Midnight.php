<?php namespace BriskSurf\Users\Commands;

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;

class Midnight extends ScheduledCommand {

	protected $name = 'users:midnight';

	protected $description = 'Midnight users clean.';

	public function __construct()
	{
		parent::__construct();
	}

	public function schedule(Schedulable $scheduler)
	{
		return $scheduler->daily();
	}

	public function fire()
	{
		DB::collection('users')->update(array("views_today" => 0, "credits_today" => 0));

    		Queue::push('BriskSurf\Lists\ListManager@processAttribute', array("views_today", "credits_today"));
	}

}
