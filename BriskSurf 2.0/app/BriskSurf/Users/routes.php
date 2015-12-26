<?php

Route::pattern('id', '[a-zA-Z0-9]+');

Route::group(array('before' => 'guest'), function()
{  
	Route::get('register', 'BriskSurf\Users\UserController@getRegister'); 
	Route::get('registered', 'BriskSurf\Users\UserController@getRegistered');  
	Route::get('login', 'BriskSurf\Users\UserController@getLogin');    
	Route::get('remind', 'BriskSurf\Users\UserController@getRemind'); 
	Route::get('resend', 'BriskSurf\Users\UserController@getResend'); 
	Route::get('reminded', 'BriskSurf\Users\UserController@getReminded');  
	Route::get('resent', 'BriskSurf\Users\UserController@getResent');   
	Route::get('activate/{code}', 'BriskSurf\Users\UserController@getActivate')->where('code', '\w{6}');
	
	Route::group(array('before' => 'crsf'), function()
	{
		Route::post('login', 'BriskSurf\Users\UserController@postLogin'); 
		Route::post('register', 'BriskSurf\Users\UserController@postRegister');  
		Route::post('remind', 'BriskSurf\Users\UserController@postRemind');  
		Route::post('resend', 'BriskSurf\Users\UserController@postResend');  
	});
	
});

Route::group(array('before' => array('auth', 'targeting_not_setup')), function()
{
	Route::get('setup', 'BriskSurf\Users\UserController@getTargeting');

	Route::group(array('before' => 'crsf'), function()
	{
		Route::post('setup', 'BriskSurf\Users\UserController@postTargeting');
	});
});

Route::group(array('before' => array('auth', 'targeting_setup')), function()
{
	Route::get('logout', 'BriskSurf\Users\UserController@getLogout');
	Route::get('settings', 'BriskSurf\Users\UserController@getSettings');

	Route::group(array('before' => 'crsf'), function()
	{
		Route::post('settings', 'BriskSurf\Users\UserController@postSettings');
	});
});