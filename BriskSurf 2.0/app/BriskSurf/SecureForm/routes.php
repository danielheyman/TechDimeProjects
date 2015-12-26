<?php

Route::get('secure/form/{id}/{number}', 'BriskSurf\SecureForm\SecureFormController@getImage')->where(array('number' => '[0-4]+', 'id' => '[a-zA-Z0-9]+'));