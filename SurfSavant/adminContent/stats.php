<?php
    include '../cleanConfig.php';
    $result = $db->query("select count(id) as count from users WHERE `activation` = '1'");
    $result = $result->getNext();
    $first = number_format($result->count);

    $result = $db->query("SELECT SUM(`amount`) as `count` FROM `commissions`");
    $result = number_format($result->getNext()->count,2);
    $second = $result;

    $result = $db->query("SELECT COUNT(`id`) AS `count` FROM `ptc` WHERE `amount` >= `earn` / 500 && `active` = 1 && `description` != '' && `title` != ''");
    $result = $result->getNext()->count;
    $third = $result;

echo "Total Members: {$first}
Total Earned: $" . $second . "
Available PTC Ads: {$third}";
?>