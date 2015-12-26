<?php

Route::pattern('id', '[a-zA-Z0-9]+');

Route::get('e/o/{id}', 'BriskSurf\Admin\AdminController@getEmailOpen');
Route::get('e/c/{id}', 'BriskSurf\Admin\AdminController@getEmailClick');

Route::group(array('prefix' => 'admin', 'before' => array('auth', 'admin_check')), function()
{
	Route::group(array('before' => 'admin_auth'), function()
	{  
		Route::get('/', 'BriskSurf\Admin\AdminController@dash');

		Route::get('settings', 'BriskSurf\Admin\AdminController@settings');
		Route::get('users/{id?}', 'BriskSurf\Admin\AdminController@users');

		Route::get('packages', 'BriskSurf\Admin\AdminController@packages');
		Route::get('packages/{id}', 'BriskSurf\Admin\AdminController@getPackage');

		Route::get('lists', 'BriskSurf\Admin\AdminController@lists');
		Route::get('lists/{id}', 'BriskSurf\Admin\AdminController@getList');

		Route::get('campaigns', 'BriskSurf\Admin\Controllers\CampaignController@getCampaigns');
		Route::get('campaigns/action', 'BriskSurf\Admin\Controllers\CampaignController@getActionCampaigns');
		Route::get('campaigns/action/{id}', 'BriskSurf\Admin\Controllers\CampaignController@getActionCampaign');

		Route::get('emails/drafts', 'BriskSurf\Admin\AdminController@getDrafts');
		Route::get('emails/logs', 'BriskSurf\Admin\AdminController@getEmailLogs');
		Route::get('emails/draft/{id}', 'BriskSurf\Admin\AdminController@getDraft');
		Route::get('emails/log/{id}', 'BriskSurf\Admin\AdminController@getEmailLog');
		Route::get('email/{id}', 'BriskSurf\Admin\AdminController@getEmail');
		Route::get('email/preview/{id}', 'BriskSurf\Admin\AdminController@getEmailPreview');
		Route::get('emails', 'BriskSurf\Admin\AdminController@getEmails');

		Route::get('emails/layouts', 'BriskSurf\Admin\AdminController@getLayouts');
		Route::get('emails/layouts/{id}', 'BriskSurf\Admin\AdminController@getLayout');

		Route::get('notification/{id}', 'BriskSurf\Admin\Controllers\NotificationsController@getNotification');
		

		Route::group(array('before' => 'crsf'), function()
		{
			Route::post('users/{id?}', 'BriskSurf\Admin\AdminController@postUsers');

			Route::post('packages/{id}', 'BriskSurf\Admin\AdminController@postPackage');

			Route::post('settings', 'BriskSurf\Admin\AdminController@postSettings');

			Route::post('lists/{id}', 'BriskSurf\Admin\AdminController@postList');
			Route::delete('lists/{id}', 'BriskSurf\Admin\AdminController@deleteList');

			Route::post('campaigns/action/{id}', 'BriskSurf\Admin\Controllers\CampaignController@postActionCampaign');
			Route::delete('campaigns/action/{id}', 'BriskSurf\Admin\Controllers\CampaignController@deleteActionCampaign');

			Route::post('emails/draft/{id}', 'BriskSurf\Admin\AdminController@sendDraft');
			Route::delete('emails/draft/{id}', 'BriskSurf\Admin\AdminController@deleteDraft');
			Route::post('email/{id}', 'BriskSurf\Admin\AdminController@postEmail');
			Route::post('emails/layouts/{id}', 'BriskSurf\Admin\AdminController@postLayout');
			Route::delete('emails/layouts/{id}', 'BriskSurf\Admin\AdminController@deleteLayout');

			Route::post('notification/{id}', 'BriskSurf\Admin\Controllers\NotificationsController@postNotification');
		});
	});

	Route::group(array('before' => 'admin_guest'), function()
	{  
		Route::get('login', 'BriskSurf\Admin\AdminController@login');

		Route::group(array('before' => 'crsf'), function()
		{
			Route::post('login', 'BriskSurf\Admin\AdminController@loginPost');
		});

	});
});