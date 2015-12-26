<?php namespace BriskSurf\Email;

use Jenssegers\Mongodb\Model as Eloquent;

class EmailLogModel extends Eloquent {

	protected $collection = 'email_logs';
	
}
