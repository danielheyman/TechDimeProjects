<?php
include 'cleanConfig.php';

///////////////////////////
//UPDATE USER ACTIVITY
///////////////////////////


//branding shield
$db->query("INSERT INTO `contestShields` (`userid`, `type`, `timestamp`) SELECT `id`, 'branding', NOW() - INTERVAL 1 DAY FROM `users` WHERE `brandingTries` = 15 && `brandingMeTries` > 0");

$db->query("UPDATE `users` SET `active` = 0");

$countSites = $db->query("SELECT COUNT(`id`) AS `count` FROM `activitySites` WHERE active != 0")->getNext()->count;

$db->query("INSERT INTO `lostLevel` (`userid`, `level`, `xp`) SELECT `id`, `level`, `xp` FROM `users` WHERE `vacations` = 0 && (`level` != 1 || `xp` != 0) && (SELECT COUNT(`id`) FROM `shield` WHERE `userid` = `users`.`id`) != {$countSites}");

$db->query("UPDATE `users` SET `xp` = 0, `level` = 1 WHERE `vacations` = 0 && (SELECT COUNT(`id`) FROM `shield` WHERE `userid` = `users`.`id`) != {$countSites}");

$db->query("UPDATE `users` SET `xp` = `xp` + 1, `active` = 1 WHERE (SELECT COUNT(`id`) FROM `shield` WHERE `userid` = `users`.`id`) = {$countSites}");

$db->query("UPDATE `users` SET `xp` = `xp` + 1, `active` = 1, `vacations` = `vacations` - 1 WHERE `vacations` > 0 && `active` = 0");

$db->query("UPDATE `users` SET `coins` = `coins` + `level`, `consecutiveActive` = `consecutiveActive` + 1 WHERE `active` = 1");

$db->query("UPDATE `users` SET `activeBrandingYesterday` = `activeBranding`, `brandingMeRatio2` = (`brandingMeWins` / `brandingMeTries` * 100)");

$db->query("UPDATE `users` SET `activeBrandingYesterday` = '1' WHERE `id` <= 3");

$db->query("DELETE FROM `shield`");

$db->query("UPDATE `users` SET `activeBranding` = 0, `brandingTries` = 0, `brandingWins` = 0, `brandingMeWins` = 0, `brandingMeTries` = 0");

$db->query("INSERT INTO `activeHistory` (`userid`) SELECT `id` FROM `users` WHERE `active` = 1");

//activity shield
$db->query("INSERT INTO `contestShields` (`userid`, `type`, `timestamp`) SELECT `id`, 'activity', NOW() - INTERVAL 1 DAY FROM `users` WHERE `consecutiveActive` = 3");

$db->query("UPDATE `users` SET `consecutiveActive` = 0 WHERE `consecutiveActive` = 3");

if(date("j") == 1)
{
    $db->query("UPDATE `users` SET `consecutiveActive` = 0");
}

//referral shield
$db->query("INSERT INTO `contestShields` (`userid`, `type`, `timestamp`) SELECT `ref`, 'referral', `registerDate` FROM `activeHistory` LEFT JOIN `users` ON `users`.`id` = `userid` WHERE `ref` != 0 && DATE(`registerDate`) >= DATE(NOW() - INTERVAL 8 DAY) GROUP BY `userid` HAVING COUNT(`userid`) = 3 && DATE(MAX(`timestamp`)) = DATE(NOW())");

///////////////////////////
//UPDATE ACTIVITY SITES
///////////////////////////    

$db->query("UPDATE `activitySites` SET `active` = 0, `countdown` = `countdown` - 1 WHERE `id` > 3");
$db->query("UPDATE `activitySites` SET `hitsYesterday` = `totalHits`");
$db->query("UPDATE `activitySites` SET `totalHits` = 0");
//$db->query("UPDATE `activitySites` SET `active` = '4' WHERE `id` > 3 && `countdown` = '0'");
$db->query("UPDATE `activitySites` SET `active` = '4' WHERE `id` > 3 && `countdown` = '0' && `lastHit` > NOW() - INTERVAL 2 HOUR");


$query = $db->query("SELECT `activityid` FROM `activityBids` WHERE `day` = DATE(NOW() + INTERVAL 1 DAY) ORDER BY `bid` DESC LIMIT 1");
if($query->getNumRows())
{
    $activityid = $query->getNext()->activityid;
    //$query = $db->query("SELECT `id` FROM `activitySites` WHERE `id` = '{$activityid}' && `lastHit` > NOW() - INTERVAL 1 HOUR LIMIT 1");
    $query = $db->query("SELECT `id` FROM `activitySites` WHERE `id` = '{$activityid}' LIMIT 1");
    if($query->getNumRows())
    {
        $db->query("UPDATE `activitySites` SET `countdown` = 1 WHERE `id` = '{$activityid}'");
    }
}
$db->query("DELETE FROM `activityBids` WHERE `day` <= DATE(NOW() - INTERVAL 1 DAY)");
$db->query("DELETE FROM `activitySites` WHERE `countdown` < -14 && `lastHit` = '0000-00-00 00:00:00'");
$db->query("DELETE FROM `activitySites` WHERE `countdown` < -14 && `lastHit` = '0000-00-00 00:00:00'");

///////////////////////////
//UPDATE STOCKS
///////////////////////////

$query = $db->query("SELECT `id`, `code` FROM `stockSites");
while($result = $query->getNext())
{
    $stock = $db->query("SELECT `worth` FROM `uniqueHits` WHERE `code` = '{$result->code}' && `worth` != 0 ORDER BY `id` DESC LIMIT 1");
    if($stock->getNumRows())
    {
        $stockworth = $stock->getNext()->worth;

        $dividend = $stockworth * 20;
        $db->query("UPDATE `users` SET `coins` = `coins` + ((SELECT `count` FROM `stockOwners` WHERE `stockOwners`.`stockid` = '{$result->id}' && `stockOwners`.`userid` = `users`.`id` LIMIT 1) / (SELECT SUM(`count`) FROM `stockOwners` WHERE `stockOwners`.`stockid` = '{$result->id}' && `stockOwners`.`userid` > 3 LIMIT 1) * {$dividend} * (1 + (`level` - 1) * 0.25)) WHERE `active` = 1 && EXISTS (SELECT `count` FROM `stockOwners` WHERE `stockOwners`.`stockid` = '{$result->id}' && `stockOwners`.`userid` = `users`.`id`)");


        $stock = $db->query("SELECT ((`hits` / 20) * ((SELECT SUM(`count`) AS `count` FROM `stockOwners` WHERE `stockid` = '{$result->id}') / (SELECT SUM(`count`) FROM `stockOwners`)) * (SELECT COUNT(`id`) FROM `stockSites`) / 3) AS `worth` FROM `uniqueHits` WHERE `code` = '{$result->code}' ORDER BY `id` DESC LIMIT 1");
        $worth = $stock->getNext()->worth;

        $newpercent = ($worth - $stockworth) / $stockworth * 5;
        if($newpercent < -6) $newpercent = -6 + rand(-500, 500) / 1000;
        if($newpercent > 6) $newpercent = 6 + rand(-500, 500) / 1000;

        $newpercent /= 100;

        $newworth = $newpercent * $stockworth + $stockworth;
    }
    else
    {
        $stock = $db->query("SELECT ((`hits` / 20) * ((SELECT SUM(`count`) AS `count` FROM `stockOwners` WHERE `stockid` = '{$result->id}') / (SELECT SUM(`count`) FROM `stockOwners`)) * (SELECT COUNT(`id`) FROM `stockSites`) / 3) AS `worth` FROM `uniqueHits` WHERE `code` = '{$result->code}' ORDER BY `id` DESC LIMIT 1");
        $newworth = $stock->getNext()->worth;
    }
    $db->query("UPDATE `uniqueHits` SET `worth` = {$newworth} WHERE `code` = '{$result->code}' ORDER BY `id` DESC LIMIT 1");
}

$db->query("DELETE FROM `uniqueHits` WHERE `timestamp` < NOW() - INTERVAL 3 MONTH");


$stockSites = $db->query("SELECT `code` FROM `stockSites`");
while($stock = $stockSites->getNext())
{
    $db->query("INSERT INTO `uniqueHits` (`code`) VALUES ('{$stock->code}')");   
}

if(date("l") == "Monday") //End of Sunday
{
    //stock shield
    $db->query("INSERT INTO `contestShields` (`userid`, `type`, `timestamp`) SELECT `userid`, 'stock', NOW() - INTERVAL 1 DAY FROM `stockHistory` WHERE DATE(`timestamp`) >= DATE(NOW() - INTERVAL 8 DAY) GROUP BY `userid` HAVING COUNT(`userid`) >= 3");
}

///////////////////////////
//INSERT REFERRAL EARNINGS
///////////////////////////

$db->query("INSERT INTO `transactions` (`userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES ('-1', '-1', 'Referral Earnings', '', '0', CURRENT_TIMESTAMP)");   
$id = $db->insertID;
$db->query("INSERT INTO `commissions` (`userid`, `transactionid`, `amount`, `status`)
SELECT `users`.`id`, '{$id}', SUM(`commissions`.`amount`) * CASE WHEN `membership` = '0001' THEN 0.1 ELSE 0.2 END AS `amount`, '1' FROM `commissions` LEFT JOIN `transactions` ON `commissions`.`transactionid` = `transactions`.`id` LEFT JOIN `users` ON `users`.`id` = (SELECT `ref` FROM `users` WHERE `users`.`id` = `commissions`.`userid`) WHERE DATE(`date`) = DATE(NOW() - INTERVAL 1 DAY) && (`item_name` = 'PTC Cash Bonus' || `item_name` like '%Surfing Bonus') && `active` = 1 GROUP BY `users`.`id`");


if(false && date("j") == 8)
{
    $db->query("INSERT INTO `transactions` (`userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES ('-1', '-1', 'Monthly Contest', '', '0', CURRENT_TIMESTAMP)");   
    $id = $db->insertID;
    
    
    $query = $db->query("SELECT `users`.`id` FROM `contestShields` LEFT JOIN `users` ON `users`.`id` = `userid` WHERE MONTH(NOW() - INTERVAL 1 MONTH) = MONTH(`timestamp`) && `userid` > 3 GROUP BY `userid` ORDER BY COUNT(`userid`) DESC, DATE(MAX(`timestamp`)) ASC, COUNT(CASE WHEN `type` = 'referral' THEN 1 ELSE 0 END) DESC LIMIT 20");
    $count = 1;
    while($q = $query->getNext())
    {
        if($count == 1) $cash = 60;
        else if($count == 2) $cash = 30;
        else if($count == 3) $cash = 20;
        else if($count == 4) $cash = 10;
        else if($count >= 5 && $count <= 6) $cash = 5;
        else if($count >= 7 && $count <= 10) $cash = 3;
        else if($count >= 11 && $count <= 20) $cash = 1;
        $db->query("INSERT INTO `commissions` (`userid`, `transactionid`, `amount`, `status`) VALUES ('{$q->id}', '{$id}', '{$cash}', '1')");
        $count++;
    }
}

///////////////////////////
//CLEANING DATABASE
///////////////////////////

$db->query("DELETE FROM `sessions` WHERE `timestamp` < NOW() - INTERVAL 1 WEEK");
$db->query("DELETE FROM `brandingHits` WHERE DATE(`timestamp`) < DATE(NOW() - INTERVAL 1 WEEK)");
$db->query("DELETE FROM `ptcviews`");
$db->query("DELETE FROM `activeHistory` WHERE `timestamp` < NOW() - INTERVAL 1 MONTH");
$db->query("DELETE FROM `lostLevel` WHERE `timestamp` < NOW() - INTERVAL 1 WEEK");
$db->query("DELETE FROM `sales` WHERE `end` < NOW() - INTERVAL 1 DAY");
?>