<style>
body{
	font-family: Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;
	color:#333;
}
p{
	max-width: 700px;
	margin:20px;
}
</style>
<center>
	<br><br>
	<strong>Surf Duel is now closed</strong>
	<br><br><br>
	<p>We have completed all verified upgrade transfers that were requested and final payouts have been made. We want to thank everyone who has supported this website, it has always been our pleasure to serve you.</p>
</center>
<?php exit; ?>

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
$usr->loggedIn = false;
$gui = new Layout($sec);
$arrayManager = new arrayManager();

$site = [];
$query = $db->query("SELECT * FROM `settings`");
while($setting = $query->getNext())  $site[$setting->name] = $setting->value;


$membership = [];
$query = $db->query("SELECT * FROM `memberships`");
while($mem = $query->getNext())  $membership[$mem->type] = (array) $mem;


$packages = [];
$query = $db->query("SELECT * FROM `packages` WHERE `status` = 1");
while($package = $query->getNext())  $packages[$package->id] = (array) $package;

$vars = [];
$query = $db->query("SELECT * FROM `variables`");
while($var = $query->getNext())  $vars[] = [$var->name, $var->type, $var->value];


if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['REQUEST_URI'],'ipn.php') === false && $_SERVER['REQUEST_METHOD'] === 'POST' && !strstr($_SERVER['HTTP_REFERER'], $site["url"]))
{
    die("An error has occured");
}

?>