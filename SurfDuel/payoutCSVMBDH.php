<?php
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");

include 'cleanConfig.php';

$query = $db->query("SELECT `users`.`fullName`,`users`.`paypal`,`userid`, SUM(`amount`) as `amount` FROM `commissions`
LEFT JOIN `users` ON `users`.`id` = `commissions`.`userid`
WHERE (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`)  < DATE(Now())  && `status` = 1 && `users`.`paypal` != ''
GROUP BY `userid` HAVING SUM(`amount`) >= 5");
if($query->getNumRows())
{
    $count = 0;
    while($row = $query->getNext())
    {
        if($count != 0) echo "\n";
        echo $row->paypal . "," . $row->amount . ",USD," . $row->userid . ",Here are your SurfDuel earnings. Thank you for your support!";   
        $count++;
    }
}
?>