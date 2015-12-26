<?php

Route::pattern('id', '[a-zA-Z0-9]+');

Route::group(array('before' => 'guest'), function()
{  
	Route::get('r/{id}', 'BriskSurf\HomeReferral\HomeController@getHome');
	Route::get('/', 'BriskSurf\HomeReferral\HomeController@getHome');
	
});
	
Route::group(array('before' => array('auth', 'setup')), function()
{
	Route::get('dash', 'BriskSurf\HomeReferral\HomeController@getDashboard');
});