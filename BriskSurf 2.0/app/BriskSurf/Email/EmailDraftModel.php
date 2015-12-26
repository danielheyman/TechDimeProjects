<?php namespace BriskSurf\Email;

use Jenssegers\Mongodb\Model as Eloquent;

class EmailDraftModel extends Eloquent {

	protected $collection = 'email_drafts';
	
}
