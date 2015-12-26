<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'cleanConfig.php';

//cleanURL
//<ifModule mod_rewrite.c>
//    RewriteEngine on
//    RewriteBase /brisksurf/
//    RewriteCond %{REQUEST_FILENAME} !-f
//    RewriteCond %{REQUEST_FILENAME} !-d
//    RewriteRule ^(.*)$ index.php/$1
//</IfModule>

$result = $gui->cleanURL($usr->loggedIn, $site);
$getVar = $sec->filter($result[1]);
//if($getVar == "testerMDY") $_SESSION["tester"] = "true";
$result[0] = $sec->filter($result[0]);

$thePage = $result[0];

//if(!isset($_SESSION["tester"]) && $result[0] != "both/hit.php" && $result[0] != "both/stream.php") $result[0] = "both/soon.php";
if($usr->loggedIn && $result[0] == "loggedIn/home.php" && $usr->data->registeredOffer == "0" && $usr->data->membership == "0001")
{
    $db->query("UPDATE `users` SET `registeredOffer` = '1', `loginOffer` = NOW() WHERE `id` = '{$usr->data->id}'");
    $result[0] = "loggedIn/offer.php";
}
else if($usr->loggedIn && $result[0] == "loggedIn/home.php" && $usr->data->registeredOffer == "1" && $usr->data->membership == "0001")
{
    $db->query("UPDATE `users` SET `registeredOffer` = '2', `loginOffer` = NOW() WHERE `id` = '{$usr->data->id}'");
    $result[0] = "loggedIn/offer2.php";
}
else if($usr->loggedIn && $result[0] == "loggedIn/home.php") {
     if($db->query("SELECT `id` FROM `users` WHERE `id` = '{$usr->data->id}' && `loginOffer` < NOW() - INTERVAL 1 DAY")->getNumRows())
     {
        $result[0] = "loggedIn/loginoffer.php";
     }
}
//if($result[0] == "loggedOut/register.php") $result[0] = "both/soon.php";
if($result[0] == "loggedOut/home.php" && $getVar != "") setcookie("ref", $getVar, time()+3600*24, "/");
if($result[0] == "both/splashc.php") setcookie("bonus", "1", time()+60*60*24*7,"/");

include($result[0]);
?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42820344-2', 'www.surfsavant.com');
  ga('send', 'pageview');

</script>