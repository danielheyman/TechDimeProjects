<?php
    include '../cleanConfig.php';
    $result = $db->query("select count(id) as count from users WHERE `activation` = '1'");
    $result = $result->getNext();
    $first = number_format($result->count);

    $result = $db->query("SELECT SUM(`viewsYesterday`) AS `count` FROM `websites`");
    $result = number_format($result->getNext()->count);
    $second = $result;

echo "Total Members: {$first}
Views Delivered Yesterday: {$second}";
?>