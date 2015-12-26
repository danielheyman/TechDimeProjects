<?php namespace BriskSurf\Payments;

use Illuminate\Support\Facades\Facade;

class PackagesFacade extends Facade {

    	protected static function getFacadeAccessor() { return 'packages'; }

}