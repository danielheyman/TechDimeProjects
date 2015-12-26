<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndexHistory extends Migration {

	public function up()
	{
		Schema::create('history_actions', function($collection)
	      	{
	      		$collection->index('meta');
	      		$collection->index('count');
	      		$collection->index('expire', array('expireAfterSeconds' => 0));
	        	});

		Schema::create('history_day_counters', function($collection)
	      	{
	      		$collection->index('meta');
	      		$collection->index('expire', array('expireAfterSeconds' => 0));
	        	});

		Schema::create('history_year_counters', function($collection)
	      	{
	      		$collection->index('meta');
	      		$collection->index('expire', array('expireAfterSeconds' => 0));
	        	});

		Schema::create('history_mega_counters', function($collection)
	      	{
	      		$collection->index('meta');
	      		$collection->index('expire', array('expireAfterSeconds' => 0));
	        	});
	}

	public function down()
	{
		Schema::drop('history_actions');
		Schema::drop('history_day_counters');
		Schema::drop('history_year_counters');
		Schema::drop('history_mega_counters');
	}

}
