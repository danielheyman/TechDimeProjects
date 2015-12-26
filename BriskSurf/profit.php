<?php

$lastUpdate = "December 2014";
$totalYearGross = 0;
$totalYearNet = 0;
$totalGross = 16901.12;
$totalNet = 1491.77;

$comms = array("BuildMyDownlines" => 8.98, "ClickTrackProfit" => 15);
$expenses = array(
	"TechDime" => array(
		"Advertising" => array(
			"SocialSurf4U 10k Credits" => 20
		),
		"Commissions & Fees" => array(

		),
		"Office Expense" => array(

		),
		"Utilities" => array(
			"GrooveHQ" => 30
		),
		"Web Hosting" => array(
			"DigitalOcean" => 60
		),
		"Web Design" => array(

		)
	),
	"Work" => array(
		"Advertising" => array(

		),
		"Commissions & Fees" => array(

		),
		"Office Expense" => array(

		),
		"Utilities" => array(

		),
		"Web Hosting" => array(

		),
		"Web Design" => array(

		)
	)
);

$lastMonthComms = array("Shockwave-Traffic" => 78.80, "BuildMyDownlines" => 8.98, "ListNerds" => 21);
$lastMonthExpenses = array(
	"TechDime" => array(
		"Advertising" => array(
			"Traffic Splash LifeTime" => 147,
			"Traffic Swirl 220k Tokens" => 80,
			"Banner Snack Year Pro" => 72
		),
		"Commissions & Fees" => array(

		),
		"Office Expense" => array(

		),
		"Utilities" => array(
			"GrooveHQ" => 30
		),
		"Web Hosting" => array(
			"DigitalOcean" => 60
		),
		"Web Design" => array(

		)
	),
	"Work" => array(
		"Advertising" => array(

		),
		"Commissions & Fees" => array(

		),
		"Office Expense" => array(

		),
		"Utilities" => array(

		),
		"Web Hosting" => array(

		),
		"Web Design" => array(

		)
	)
);

$listviral = explode(",", @file_get_contents("http://listviral.com/profitMBDH.php"));

$feesTotal = 0;
foreach($expenses["TechDime"] as $expense)
{
	foreach($expense as $value) $feesTotal += $value;
}

$commsTotal = 0;
foreach($comms as $value) $commsTotal += $value;

$lastMonthFeesTotal = 0;
foreach($lastMonthExpenses["TechDime"] as $expense)
{
	foreach($expense as $value) $lastMonthFeesTotal += $value;
}

$lastMonthCommsTotal = 0;
foreach($lastMonthComms as $value) $lastMonthCommsTotal += $value;