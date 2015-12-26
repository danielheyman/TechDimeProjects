<?php
include 'cleanConfig.php';

if($sec->post("password") != "MAndDHairs!" && !isset($_POST["completePayout"])) die("<form method='post'>Pass: <input name='password' type='password'><input type='submit'></form>");

if(isset($_POST["completePayout"]))
{
    $db->query("UPDATE `commissions` LEFT JOIN (SELECT `commissions`.`userid`, SUM(`commissions`.`amount`) AS `amount` FROM `commissions` LEFT JOIN `transactions` ON `commissions`.`transactionid` = `transactions`.`id` LEFT JOIN `users` ON `commissions`.`userid` = `users`.`id` WHERE `status` = 1 && ((DATE(`transactions`.`date`)  <= DATE(Now() - INTERVAL 0 DAY) && `commissions`.`amount` > 0) || (`commissions`.`amount` < 0)) && `paypal` != '' GROUP BY `commissions`.`userid`) AS `new` ON `commissions`.`userid` = `new`.`userid` LEFT JOIN `transactions` ON `commissions`.`transactionid` = `transactions`.`id` SET `status` = '0' WHERE `new`.`amount` >= 10 && `commissions`.`status` = 1 && ((DATE(`transactions`.`date`)  <= DATE(Now() - INTERVAL 0 DAY) && `commissions`.`amount` > 0) || (`commissions`.`amount` < 0))");
}

$query = $db->query("SELECT * FROM (SELECT `fullName`, `paypal`, `commissions`.`userid`, SUM(`commissions`.`amount`) AS `amount` FROM `commissions` LEFT JOIN `transactions` ON `commissions`.`transactionid` = `transactions`.`id` LEFT JOIN `users` ON `commissions`.`userid` = `users`.`id` WHERE `status` = 1 && ((DATE(`transactions`.`date`)  <= DATE(Now() - INTERVAL 0 DAY) && `commissions`.`amount` > 0) || (`commissions`.`amount` < 0)) && `paypal` != '' GROUP BY `commissions`.`userid`) AS `new` WHERE `amount` >= 10");

echo "<textarea style='width:100%; height:200px;'>";
if($query->getNumRows())
{
    $count = 0;
    while($row = $query->getNext())
    {
        if($count != 0) echo "\n";
        echo $row->paypal . "," . $row->amount . ",USD," . $row->userid . ",Here are your Surf Savant earnings. Thank you for your support!";
        $count++;
    }
}
else echo "Nothing to be paid.";
echo "</textarea>";
?>
<br><br><a href="payoutCSVMBDH.php"><button>Download</button></a><br><br><form method="post"><input name="completePayout" type="submit" value="Complete"/></form>