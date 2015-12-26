<?php

Route::get('help/{type}', 'BriskSurf\Help\HelpController@getList')->where(array('type' => 'faq|tos'));