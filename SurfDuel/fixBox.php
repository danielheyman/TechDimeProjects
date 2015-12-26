<?php
include 'cleanConfig.php';



///FIRST

$result = $db->query("SELECT `url` FROM `websites` WHERE `winner` = '1'");

$url = $result->getNext()->url;

// The URL to get your HTML
//$url = "http://www.google.com/";
 
// Name of your output image
$name = "one.jpg";
 
// Command to execute
$command = "/usr/bin/wkhtmltoimage-amd64 --load-error-handling ignore --height 230 --width 340 --disable-smart-width --zoom 0.35";
 
// Directory for the image to be saved
$image_dir = "/var/www/surfduel/winners/";
 
// Putting together the command for `shell_exec()`
$ex = $command . ' "' . $url . '" ' . $image_dir . $name;
 
// The full command is: "/usr/bin/wkhtmltoimage-i386 --load-error-handling ignore http://www.google.com/ /var/www/images/example.jpg"
// If we were to run this command via SSH, it would take a picture of google.com, and save it to /vaw/www/images/example.jpg
 
// Generate the image
// NOTE: Don't forget to `escapeshellarg()` any user input!
$output = shell_exec($ex);


///SECOND

$result2 = $db->query("SELECT `url` FROM `websites` WHERE `winner` = '2'");

$url2 = $result2->getNext()->url;

// The URL to get your HTML
//$url = "http://www.google.com/";
 
// Name of your output image
$name2 = "two.jpg";
 
// Command to execute
$command2 = "/usr/bin/wkhtmltoimage-amd64 --load-error-handling ignore --height 230 --width 340 --disable-smart-width --zoom 0.35";
 
// Directory for the image to be saved
$image_dir2 = "/var/www/surfduel/winners/";
 
// Putting together the command for `shell_exec()`
$ex2 = $command2 . ' "' . $url2 . '" ' . $image_dir2 . $name2;
 
// The full command is: "/usr/bin/wkhtmltoimage-i386 --load-error-handling ignore http://www.google.com/ /var/www/images/example.jpg"
// If we were to run this command via SSH, it would take a picture of google.com, and save it to /vaw/www/images/example.jpg
 
// Generate the image
// NOTE: Don't forget to `escapeshellarg()` any user input!
$output2 = shell_exec($ex2);

?>