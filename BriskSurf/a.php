<?php
include 'cleanConfig.php';
$ip = $sec->get("i");
echo ($db->query("SELECT * FROM `users` WHERE (`id` = 46 || `id` = 1) && `loginIP` = '{$ip}' ")->getNumRows()) ? 1 : 0;
