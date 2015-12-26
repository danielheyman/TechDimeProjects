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
$result[0] = $sec->filter($result[0]);
$thePage = $result[0];
if($usr->loggedIn && $result[0] == "loggedIn/home.php" && $usr->data->registeredOffer == "0")
{
    $db->query("UPDATE `users` SET `registeredOffer` = '1' WHERE `id` = '{$usr->data->id}'");
    $result[0] = "loggedIn/offer.php";
}
else if($usr->loggedIn && $result[0] == "loggedIn/home.php" && $usr->data->registeredOffer == "1")
{
    $db->query("UPDATE `users` SET `registeredOffer` = '2' WHERE `id` = '{$usr->data->id}'");
    $result[0] = "loggedIn/offer2.php";
}
else if($usr->loggedIn && $result[0] == "loggedIn/home.php") {
     if($db->query("SELECT `id` FROM `users` WHERE `id` = '{$usr->data->id}' && `loginOffer` < NOW() - INTERVAL 1 DAY")->getNumRows())
     {
        $result[0] = "loggedIn/loginoffer.php";
     }
}
if($result[0] == "loggedOut/home.php" && $getVar != "") setcookie("ref", $getVar, time()+3600*24, "/");

include($result[0]);
?>