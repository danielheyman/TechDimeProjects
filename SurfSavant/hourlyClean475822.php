<?php
include 'cleanConfig.php';

$db->query("DELETE FROM `rotatorHits` WHERE `timestamp` < NOW() - INTERVAL 3 HOUR");


$db->query("UPDATE `users` SET `membership` = '0001' WHERE `membershipExpires` < NOW()");
foreach ($membership as $key => $value)
{
    if($key != "0001")
    {
        $db->query("UPDATE `users` SET `membershipCoins` = NOW() + INTERVAL 1 MONTH, `coins` = `coins` + {$value['monthlyCoins']}, `vacations` = `vacations` + {$value['monthlyVacation']} WHERE `membershipCoins` < NOW() && `membership` = '{$key}'");
    }
}
?>