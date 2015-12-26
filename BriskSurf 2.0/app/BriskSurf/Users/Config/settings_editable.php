<?php

return array(
	"_id" => "id",
	"username" => "string",
	"name" => "string",
	"email" => "string",
	"created_at" => "date",
	"paypal" => "string",
	"newsletter" => "bool",
	"admin_emails" => "bool",
	"membership" => array( "free", "premium", "platinum" ),
	"membership_expires" => "date",
	"register_ip" => "string",
	"login_ip" => "string",
	"last_login" => "date",
	"admin" => "bool",
	"referrals" => "number",
	"upline" => "string",
	"cash" => "number",
	'views_today' => "number",
	'views_total' => "number",
	'credits_today' => "number",
	'credits' => "number"
);