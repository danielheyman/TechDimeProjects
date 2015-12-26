<?php

Event::listen("user.changed", function($user, $changed)
{
	Queue::push('BriskSurf\Lists\ListManager@processUser', array("user" => $user, "changed" => $changed));
});

Event::listen("user.made_action", function($user, $action, $data)
{
	Queue::push('BriskSurf\Lists\ListManager@processAction', array("user" => $user, "action" => $action));
});

Event::listen("attribute.changed", function($attributes)
{
	Queue::push('BriskSurf\Lists\ListManager@processAttribute', $attributes);
});