<?php
include 'cleanConfig.php';
$count = $db->query("select count(`id`) as 'sum' from `users`")->getNext();
echo "AF Member Count: {$count->sum}";