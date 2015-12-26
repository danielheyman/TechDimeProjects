<?php namespace BriskSurf\Email;

use Jenssegers\Mongodb\Model as Eloquent;

class EmailModel extends Eloquent {

	protected $collection = 'emails';
	
}
