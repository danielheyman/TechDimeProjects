<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Start extends Migration {

	public function up()
	{
		Schema::create('users', function($collection)
        		{
            		$collection->unique('username');
            		$collection->unique('email');
        		});

		Schema::create('hits', function($collection)
	      	{
	      		$collection->index('meta');
	      		$collection->index('updated_at', array('expireAfterSeconds' => 60 * 60 * 24 * 365));
	        	});
	}
	
	public function down()
	{
		Schema::drop('users');
	}

}
