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
if($result[0] == "loggedOut/home.php" && $getVar != "") setcookie("ref", $getVar, time()+3600*24, "/");

include($result[0]);
?>