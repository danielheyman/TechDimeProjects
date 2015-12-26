<?php namespace BriskSurf\Lists\Commands;

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;
use BriskSurf\Lists\ListModel;

class Process extends ScheduledCommand {

	protected $name = 'lists:process';

	protected $description = 'Process any lists that are pending.';

	protected $list;

	public function __construct(ListModel $list)
	{
		parent::__construct();

		$this->list = $list;
	}

	public function schedule(Schedulable $scheduler)
	{
		return $scheduler;
	}

	public function fire()
	{
		$list = $this->list->where('status', 'process')->first();
		if($list != null)
		{
			$list->status = "processing";
			$list->save();
			\App::make('BriskSurf\Lists\ListManager')->process(false, $list);
		}
	}

}
