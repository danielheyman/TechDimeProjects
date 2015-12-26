<?php
include 'cleanConfig.php';

$db->query("UPDATE `users` SET `membership` = '0001' WHERE `membershipExpires` < NOW()");

?>