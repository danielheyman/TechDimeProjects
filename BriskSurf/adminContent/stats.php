<?php
    include '../cleanConfig.php';
    $result = $db->query("select count(id) as count from users WHERE `activation` = '1'");
    $result = $result->getNext();
    $first = number_format($result->count);

    $result = $db->query("SELECT COUNT(`id`) AS `count` FROM `views` WHERE DATE(`timestamp`) = DATE(NOW() - INTERVAL 1 DAY)");
    $result = number_format($result->getNext()->count);
    $second = $result;

//echo "Total Members: {$first}
//Views Delivered Yesterday: {$second}";
echo "Total Members: {$first}";
?>