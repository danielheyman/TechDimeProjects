<?php


Route::get('emailBatch', function() 
{
	$data = array();
	
	Mailgun::send('emails.emailBatch', $data, function($message)
	{
		$message->to(array(
		       	"Daniel Heyman <daniel@techdime.com>" => array('name' =>  'Hello','code' => 'poop'),
		       	"Dan Heyman <daniel.heyman@gmail.com>" => array('name' => 'Bananna', 'code' => 'cdf')
	  	))->subject('Welcome to BriskSurf!');
	});

	return 'hello';
});