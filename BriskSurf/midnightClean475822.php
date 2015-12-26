<?php
include 'cleanConfig.php';

$db->query("UPDATE `users` SET `dailyViews` = 0");
$db->query("DELETE FROM `users` WHERE `registerDate` < (NOW() - INTERVAL 1 WEEK) && LENGTH(`activation`) = '6'");
$db->query("DELETE FROM `views` WHERE `timestamp` < (NOW() - INTERVAL 1 MONTH)");
$db->query("DELETE FROM `websites` WHERE `timestamp` < (NOW() - INTERVAL 1 MONTH) && NOT EXISTS (SELECT `id` FROM `views` WHERE `views`.`siteid` = `websites`.`id` LIMIT 1)");
$db->query("DELETE FROM `sessions` WHERE `timestamp` < NOW() - INTERVAL 1 WEEK");
$db->query("DELETE FROM `clicks` WHERE `timestamp` < NOW() - INTERVAL 1 DAY");
$db->query("DELETE FROM `sales` WHERE `end` < NOW() - INTERVAL 1 DAY");
?>