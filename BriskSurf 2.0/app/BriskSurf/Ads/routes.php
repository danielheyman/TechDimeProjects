<?php

Route::pattern('id', '[a-zA-Z0-9]+');
	
Route::group(array('before' => array('auth', 'setup')), function()
{
	Route::get('dash', 'InnerController@getDashboard');

	Route::get('websites', 'BriskSurf\Ads\WebsiteController@getWebsites');
	Route::get('websites/{id}', 'BriskSurf\Ads\WebsiteController@getWebsiteSettings');
	Route::get('websites/graph/{id}', 'BriskSurf\Ads\WebsiteController@getWebsiteGraph');

	Route::get('banners', 'BriskSurf\Ads\BannerController@getBanners');
	Route::get('banners/{id}', 'BriskSurf\Ads\BannerController@getBannerSettings');
	Route::get('banners/graph/{id}', 'BriskSurf\Ads\BannerController@getBannerGraph');

	Route::group(array('before' => 'crsf'), function()
	{
		Route::post('websites', 'BriskSurf\Ads\WebsiteController@postWebsites');
		Route::put('websites/{id}/toggle', 'BriskSurf\Ads\WebsiteController@toggleWebsites');
		Route::delete('websites/{id}', 'BriskSurf\Ads\WebsiteController@deleteWebsites');
		Route::post('websites/{id}', 'BriskSurf\Ads\WebsiteController@postWebsiteSettings');
		Route::put('websites/assign', 'BriskSurf\Ads\WebsiteController@assignWebsiteCredits');

		Route::post('banners', 'BriskSurf\Ads\BannerController@postBanner');
		Route::put('banners/{id}/toggle', 'BriskSurf\Ads\BannerController@toggleBanners');
		Route::delete('banners/{id}', 'BriskSurf\Ads\BannerController@deleteBanners');
		Route::post('banners/{id}', 'BriskSurf\Ads\BannerController@postBannerSettings');
		Route::put('banners/assign', 'BriskSurf\Ads\BannerController@assignBannerCredits');
	});
});