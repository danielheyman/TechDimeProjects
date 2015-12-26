<?php namespace BriskSurf\Payments\Commands;

use Indatus\Dispatcher\Scheduling\ScheduledCommand;
use Indatus\Dispatcher\Scheduling\Schedulable;
use Indatus\Dispatcher\Drivers\Cron\Scheduler;

class ProcessMemberships extends ScheduledCommand {

	protected $name = 'payments:process_memberships';

	protected $description = 'Process any credits owed to upgraded members and demote expired memberships.';

	public function __construct()
	{
		parent::__construct();
	}

	public function schedule(Schedulable $scheduler)
	{
		return $scheduler->everyMinutes(30);
	}

	public function fire()
	{
		\User::where('membership_expires', '<', \Carbon::now())->update(array("membership_credits" => \Carbon::now(), "membership" => 'free'));

		foreach(\Settings::get('memberships')->toArray() as $key => $value)
		{
			if($key != "free" && $key != "_id")
			{
				\User::where('membership_credits', '<', \Carbon::now())->orWhere('membership_credits', 'exists', false)
					->where('membership', $key)->increment('credits', $value['monthly_credits'], array('membership_credits' => \Carbon::now()->addDays(30)));
			}
		}

		Event::fire("attribute.changed", array(array("membership_expires", "credits_today")));
	}

}
