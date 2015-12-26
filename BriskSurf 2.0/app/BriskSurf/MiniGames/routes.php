<?php

Route::pattern('id', '[a-zA-Z0-9]+');
	
Route::group(array('before' => array('auth', 'setup')), function()
{
	Route::get('minigame', 'BriskSurf\MiniGames\MiniGamesController@chooseGame');
	Route::get('minigame/{type}', 'BriskSurf\MiniGames\MiniGamesController@showGame');

	Route::group(array('before' => 'crsf'), function()
	{
		Route::post('minigame/{type}', 'BriskSurf\MiniGames\MiniGamesController@postGame');
	});
});