<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IndexSecureForm extends Migration {

	public function up()
	{
		Schema::create('form_records', function($collection)
	      	{
	      		$collection->index('created_at', array('expireAfterSeconds' => 360));
	        	});
	}

	public function down()
	{
		Schema::drop('form_records');
	}

}
