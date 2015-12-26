<?php
date_default_timezone_set("America/New_York");

include 'database.php';

//classes include
include ('classes/security.php'); 
include ('classes/database.php');
include ('classes/user.php');  
include ('classes/layout.php');
include ('classes/arrayManager.php');

//classes init
$sec = new Security();
$db = new Database($host, $user, $pass, $database, $sec);
if(!$db->db) die("MSQL ERROR");
$usr = new User($db, $sec);
$gui = new Layout($sec);
$arrayManager = new arrayManager();

$site = [];
$query = $db->query("SELECT * FROM `settings`");
while($setting = $query->getNext())  $site[$setting->name] = $setting->value;


$membership = [];
$query = $db->query("SELECT * FROM `memberships`");
while($mem = $query->getNext())  $membership[$mem->type] = (array) $mem;


$packages = [];
$query = $db->query("SELECT * FROM `packages`");
while($package = $query->getNext())  $packages[$package->id] = (array) $package;

$vars = [];
$query = $db->query("SELECT * FROM `variables`");
while($var = $query->getNext())  $vars[] = [$var->name, $var->type, $var->value];

if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['REQUEST_URI'],'ipn.php') === false && $_SERVER['REQUEST_METHOD'] === 'POST' && !strstr($_SERVER['HTTP_REFERER'], $site["url"]))
{
    die("An error has occured");
}

?>