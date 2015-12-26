<?php namespace BriskSurf\SecureForm;

use Illuminate\Support\Facades\Facade;

class SecureFormFacade extends Facade {

    	protected static function getFacadeAccessor() { return new \BriskSurf\SecureForm\SecureFormManager; }

}