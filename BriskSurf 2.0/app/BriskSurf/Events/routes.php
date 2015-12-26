<?php

Event::listen("event.action", function($type, $data = array(), $no_expire = false)
{
	$meta = (is_array($type)) ? $type : array(
		'type' => $type
	);
	Queue::push('BriskSurf\Events\EventProcessor@action', array(
		'meta' => $meta,
		'data' => $data,
		'expire' => $no_expire
	));
});

Event::listen("event.counter", function($type, $options = array(), $no_expire = false)
{
	$meta = (is_array($type)) ? $type : array(
		'type' => $type
	);
	$data = array(
		'meta' => $meta,
		'no_expire' => $no_expire
	);
	$data = array_merge($data, $options);
	Queue::push('BriskSurf\Events\EventProcessor@counter', $data);
});

Event::listen("event.mega", function($type, $fields, $completely_unique = array(), $no_expire = false)
{
	$meta = (is_array($type)) ? $type : array(
		'type' => $type
	);
	Queue::push('BriskSurf\Events\EventProcessor@megaCounter', array(
		'meta' => $meta,
		'fields' => $fields,
		'completely_unique' => $completely_unique,
		'no_expire' => $no_expire
	));
});