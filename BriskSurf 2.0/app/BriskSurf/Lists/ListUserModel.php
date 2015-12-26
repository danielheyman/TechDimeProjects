<?php namespace BriskSurf\Lists;

use Jenssegers\Mongodb\Model as Eloquent;

class ListUserModel extends Eloquent {

	protected $collection = 'list_users';

	protected $dates = array('recheck');
}
