<?php

return array(
	'counter' => array(
		'system' => array('logins', 'registers', 'transactions', 'commissions')
	),
	'action' => array(
		'user' => array(
			'logged_in' => array(
				'ip' => 'string',
				'minutes' => 'number',
			),
			'register' => array(
				'ip' => 'string'
			),
			'activate_account' => array(
				'ip' => 'string'
			),
			'made_purchase' => array(
				'transaction_subject '=> 'string',
				'payment_date' => 'string',
				'txn_type' => 'string',
				'subscr_id' => 'string',
				'last_name' => 'string',
				'residence_country' => 'string',
				'item_name' => 'string',
				'payment_gross' => 'number',
				'mc_currency' => 'string',
				'business' => 'string',
				'payment_type' => 'string',
				'protection_eligibility' => 'string',
				'verify_sign' => 'string',
				'payer_status' => 'string',
				'payer_email' => 'string',
				'txn_id' => 'string',
				'receiver_email' => 'string',
				'first_name' => 'string',
				'payer_id' => 'string',
				'receiver_id' => 'string',
				'item_number' => 'string',
				'payer_business_name' => 'string',
				'payment_status' => 'string',
				'payment_fee' => 'number',
				'mc_fee' => 'number',
				'mc_gross' => 'number',
				'custom' => 'string',
				'charset' => 'string',
				'notify_version' => 'string',
				'ipn_track_id' => 'string'
			),
			'ref_commission' => array(
				'ref' => 'string',
				'item' => 'string',
				'amount' => 'number'
			),
			'got_referral' => array(
				'user' => 'string'
			)
		),
		'system' => array(
			'referral_hits' => array(
				'page' => 'string',
				'source' => 'string',
				'signups' => 'number',
				'hits' => 'number'
			)
		)
	)
);