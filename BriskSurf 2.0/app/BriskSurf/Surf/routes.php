<?php

Route::pattern('id', '[a-zA-Z0-9]+');
	
Route::group(array('before' => array('auth', 'setup')), function()
{
	Route::get('surf/{type?}', 'BriskSurf\Surf\SurfController@getSurf')->where(array('type' => 'classic'));

	Route::group(array('before' => 'crsf'), function()
	{
		Route::post('surf/{type?}', 'BriskSurf\Surf\SurfController@postSurf')->where(array('type' => 'classic'));
	});
});