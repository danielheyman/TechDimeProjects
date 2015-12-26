<?php

Route::post('ipn', 'BriskSurf\Payments\PaymentController@ipn');
Route::get('ipn', 'BriskSurf\Payments\PaymentController@testIpn');

Route::group(array('before' => array('auth', 'setup')), function()
{
	Route::get('memberships', 'BriskSurf\Payments\PaymentController@getMemberships');
	Route::get('credits', 'BriskSurf\Payments\PaymentController@getCredits');
});