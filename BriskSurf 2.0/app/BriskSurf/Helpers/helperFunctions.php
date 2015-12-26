<?php

function set_active($path, $active = 'active')
{
	$is_active = false;
	if(is_array($path))
	{
		foreach($path as $p) if(Request::is($p)) $is_active = true;
	}
	else if(Request::is($path)) $is_active = true;
	return $is_active ? $active : '';
}