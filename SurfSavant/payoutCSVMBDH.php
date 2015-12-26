<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");

include 'cleanConfig.php';

/*$query = $db->query("SELECT `users`.`fullName`,`users`.`paypal`,`userid`, SUM(`amount`) as `amount` FROM `commissions`
LEFT JOIN `users` ON `users`.`id` = `commissions`.`userid`
WHERE (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`)  < DATE(Now() - INTERVAL 14 DAY)  && `status` = 1 && `users`.`paypal` != ''
GROUP BY `userid` HAVING SUM(`amount`) >= 15");*/

$query = $db->query("SELECT * FROM (SELECT `fullName`, `paypal`, `commissions`.`userid`, SUM(`commissions`.`amount`) AS `amount` FROM `commissions` LEFT JOIN `transactions` ON `commissions`.`transactionid` = `transactions`.`id` LEFT JOIN `users` ON `commissions`.`userid` = `users`.`id` WHERE `status` = 1 && ((DATE(`transactions`.`date`)  <= DATE(Now() - INTERVAL 0 DAY) && `commissions`.`amount` > 0) || (`commissions`.`amount` < 0)) && `paypal` != '' GROUP BY `commissions`.`userid`) AS `new` WHERE `amount` >= 10");
if($query->getNumRows())
{
    $count = 0;
    while($row = $query->getNext())
    {
        if($count != 0) echo "\n";
        echo $row->paypal . "," . number_format($row->amount,2) . ",USD," . $row->userid . ",Here are your Surf Savant earnings. Thank you for your support!";   
        $count++;
    }
}
?>