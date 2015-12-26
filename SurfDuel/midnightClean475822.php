<?php
include 'cleanConfig.php';


$db->query("UPDATE `websites` SET `winnerYesterday` = `winner`");
$db->query("UPDATE `websites` SET `winner` = '0'");


$query = $db->query("SELECT `id` FROM `websites` WHERE `inSurf` = '1' && `enabled` = '1' ORDER BY (`likes` / `views`) DESC LIMIT 5");
if($query->getNumRows())
{
    $count = 1;
    while($result = $query->getNext())
    {
        $db->query("UPDATE `websites` SET `winner` = '{$count}' WHERE `id` = '{$result->id}'");   
        $count++;
    }
}

$db->query("UPDATE `websites` SET `inSurf` = '0'");

foreach($membership as $key => $mem)
{
    $db->query("UPDATE `websites` LEFT OUTER JOIN `users` ON `users`.`id` = `websites`.`userid` SET `inSurf` = '1' WHERE `users`.`dailyViews` >= {$mem['dailyViews']} && `users`.`membership` = '{$key}' && `enabled` = '1'");   
    $db->query("UPDATE `users` SET `dailyViews` = `dailyViews` - {$mem['dailyViews']} WHERE `membership` = '{$key}'");
    $db->query("UPDATE `users` SET `dailyViews` = {$mem['dailyViews']} WHERE `dailyViews` > {$mem['dailyViews']} && `membership` = '{$key}'");
}

$db->query("UPDATE `users` SET `dailyViews` = '0' WHERE  `dailyViews` < 0");
$db->query("UPDATE `users` SET `dailyViews` = '0' WHERE  `membership` = '0003'");
$db->query("UPDATE `users` SET `winnerViews` = '0'");


$db->query("UPDATE `websites` SET `viewsYesterday` = `views`");
$db->query("UPDATE `websites` SET `views` = '0', `likes` = '0'");


$db->query("DELETE FROM `sessions` WHERE `timestamp` < NOW() - INTERVAL 1 WEEK");
$db->query("DELETE FROM `clicks` WHERE `timestamp` < NOW() - INTERVAL 1 DAY");


///FIRST

/*$result = $db->query("SELECT `url` FROM `websites` WHERE `winner` = '1'");
$url = $result->getNext()->url;
$name = "one.jpg";
$command = "/usr/bin/wkhtmltoimage-amd64 --load-error-handling ignore --height 230 --width 340 --disable-smart-width --zoom 0.35";
$image_dir = "/var/www/surfduel/winners/";
$ex = $command . ' "' . $url . '" ' . $image_dir . $name;
$output = shell_exec($ex);*/


///SECOND

/*$result2 = $db->query("SELECT `url` FROM `websites` WHERE `winner` = '2'");
$url2 = $result2->getNext()->url;
$name2 = "two.jpg";
$command2 = "/usr/bin/wkhtmltoimage-amd64 --load-error-handling ignore --height 230 --width 340 --disable-smart-width --zoom 0.35";
$image_dir2 = "/var/www/surfduel/winners/";
$ex2 = $command2 . ' "' . $url2 . '" ' . $image_dir2 . $name2;
$output2 = shell_exec($ex2);*/


?>