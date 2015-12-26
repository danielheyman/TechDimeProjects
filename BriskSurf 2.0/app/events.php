<?php

function process_ref_url_event($user, $source, $page, $unique_date)
{
	$user->mega('referral_stats_from_user', array('hits' => 1, 'signups' => 0, 'sales' => 0));
	
	$completely_unique = array();
	if($unique_date) $completely_unique['unique_hits'] = $unique_date;
	
	Event::fire("megaCounter", array(
		'type' => 'referral_stats_from_source',
		'source' => $source,
		'page' => $page
	), array('hits' => 1, 'unique_hits' => 1, 'signups' => 0, 'sales' => 0), $completely_unique);
}

function login_event_ip($user, $ip)
{
	$user->action("new_login_ip", array('ip' => $ip));
}

function login_event($user)
{
	Event::fire('event.counter', array('unique_logins', array("completely_unique" => $user->last_login), true));

	$user->counter('login_minutes', array("unique_to_minute" => $user->last_login));
}

function send_activation_event($user, $code)
{
	$user->action('send_activation', array('activate_link' => $code));
}

function remind_password_event($user, $pass)
{
	$user->action('remind_password', array('password' => $pass));
}

function register_event($user, $ip, $code)
{
	send_activation_event($user, $code);

	$user->action('registered', array('ip' => $ip));

	Event::fire('event.counter', array('registrations', array(), true));

	if($user->upline_source != null)
	{
		Event::fire('event.mega', array(array(
			'type' => 'referral_stats_from_source',
			'source' => $user->upline_source,
			'page' => $user->upline_page
		), array('hits' => 0, 'unique_hits' => 0, 'signups' => 1, 'sales' => 0)));
	}
}

function register_upline_event($upline)
{
	$upline->megaCounter('referral_stats_from_user', array('hits' => 0, 'signups' => 1, 'sales' => 0));
	//$upline->megaCounter('referral_stats_from_user', array('hits' => 0, 'unique_hits' => 0, 'signups' => 1, 'sales' => 0));
}

function activate_event($user)
{
	$user->action('activate_account', array('ip' => Request::getClientIp()));

	Event::fire('event.mega', array('activations', array(), true));
}

function made_purchase_event($user, $data, $amount)
{
	$user->action('made_purchase', $data, true);

	Event::fire('event.counter', array('profits', array('amount' => $amount), true));

	if($user->upline != null)
	{
		Event::fire('event.mega', array(array(
			'type' => 'referral_stats_from_user',
			'source' => $user->upline
		), array('hits' => 0, 'signups' => 0, 'sales' => $amount)));
		
		Event::fire('event.mega', array(array(
			'type' => 'referral_stats_from_source',
			'source' => $user->upline_source,
			'page' => $user->upline_page
		), array('hits' => 0, 'unique_hits' => 0, 'signups' => 0, 'sales' => $amount)));
	}
}

function commission_event($upline, $input, $cash)
{
	$upline->action('ref_commission', array(
		"ref" => $input->custom, 
		"item" => $input->item_name, 
		"txn" => $input->txn_id, 
		"amount" => $cash
	), true);

	Event::fire('event.counter', array('commissions', array('amount' => $cash), true));
}

function surf_event($user, $credits)
{
	Event::fire('event.counter', array('pages_surfed', array(), true));

	$user->counter('user_surfed');

	Event::fire('event.counter', array('credits_earned', array('amount' => $credits), true));

	$user->counter('user_earned_credits', array('amount' => $credits));
}

function ref_surf_event($ref, $credits)
{
	Event::fire('event.counter', array('credits_earned', array('amount' => $credits)));

	$ref->counter('user_ref_credits', array('amount' => $credits));
}

function website_view_event($id, $rating)
{
	Event::fire('event.mega', array(array(
		'type' => 'website_rating',
		'website' => $id
	), array('ratings' => $rating, 'out_of' => 3)));

	Event::fire('event.counter', array(array(
		'type' => 'website_views',
		'website' => $id
	)));
}

function banner_view_event($id)
{
	Event::fire('event.counter', array(array(
		'type' => 'banner_views',
		'website' => $id
	)));
}


