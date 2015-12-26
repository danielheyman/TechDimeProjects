<?php

$genders = array();
foreach(array("male", "female") as $gender) $genders[$gender] = ucwords($gender);

$continents = array();
foreach(array("asia", "africa", "north america", "south america", "europe", "australia") as $continent) $continents[$continent] = ucwords($continent);

$years_raw = range(1910, 1999);
$years_raw = array_reverse($years_raw);
$years = array();
foreach($years_raw as $year) $years[$year] = $year;

return array(
	'genders' => $genders,
	'continents' => $continents,
	'years' => $years
);