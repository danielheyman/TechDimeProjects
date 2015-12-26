<?php

$lastUpdate = "June 2014";
$totalGross = 13147.1;
$totalNet = 355.01;
$totalYearGross = 6310.04;
$totalYearNet = -281.14;

$comms = array("Trck.me" => 10.80, "CTP" => 15, "BuildMyDownlines" => 8.98, "ListNerds" => 14);
$expenses = array(
	"TechDime" => array(
		"Advertising" => array(
			"100k Doctor Traffic" => 81, 
			"2 Mil BannerMonkey" => 31, 
			"CSN" => 6.97, 
			"LTC" => 4
		),
		"Commissions & Fees" => array(

		),
		"Office Expense" => array(

		),
		"Utilities" => array(
			"GrooveHQ" => 30
		),
		"Web Hosting" => array(
			"DigitalOcean" => 6.41,
			"LiquidWeb" => 2.33
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

$lastMonthComms = array("Russell" => 60, "BuildMyDownlines" => 8.98, "Shockwave-Traffic" => 22.50, "Social Ad Surf" => 34.44, "LTC" => 22.26);
$lastMonthExpenses = array(
	"TechDime" => array(
		"Advertising" => array(
			"Doctor Traffic" => 81
		),
		"Commissions & Fees" => array(

		),
		"Office Expense" => array(

		),
		"Utilities" => array(
			"GrooveHQ" => 30
		),
		"Web Hosting" => array(
			"LiquidWeb" => 117.71, 
			"Rackspace" => 234.87
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
			"Microsoft Office" => 106.99
		),
		"Utilities" => array(

		),
		"Web Hosting" => array(
			"1and1" => 29.98
		),
		"Web Design" => array(

		)
	)
);


//$lastMonthComms = ["Russell" => 60, "BuildMyDownlines" => 8.98, "RocketResponder" => 10, "PTCProfessor" => 20, "ListNerds" => 14, "CTP" => 15];
//$lastMonthExpenses = ["Hosting Matt" => 118.00, "Hosting Dan" => 430.43, "Hosting Dan 2" => 417.37, "GrooveHQ" => 30, "Doctor Traffic" => 81];


$listviral = explode(",", @file_get_contents("http://listviral.com/profitMBDH.php"));
$surfingsocially = explode(",", @file_get_contents("http://surfingsocially.com/profitMBDH.php"));

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