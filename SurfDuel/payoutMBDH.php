<?php
include 'cleanConfig.php';

if($sec->post("password") != "MAndDHairs!" && !isset($_POST["completePayout"])) die("<form method='post'>Pass: <input name='password' type='password'><input type='submit'></form>");

if(isset($_POST["completePayout"]))
{
    $db->query("UPDATE `commissions` AS `a` SET `status` = '0' WHERE (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `a`.`transactionid`)  < DATE(Now())  && (SELECT `paypal` FROM `users` WHERE `users`.`id` = `a`.`userid`) != '' && `status` = 1 && (SELECT SUM(`amount`) FROM (SELECT `amount`,`userid` FROM `commissions` AS `c` WHERE (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `c`.`transactionid`)  < DATE(Now())  && `c`.`status` = 1 ) AS `b` WHERE `b`.`userid` = `a`.`userid`) >= 5");
}

$query = $db->query("SELECT `users`.`fullName`,`users`.`paypal`,`userid`, SUM(`amount`) as `amount` FROM `commissions`
LEFT JOIN `users` ON `users`.`id` = `commissions`.`userid`
WHERE (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`)  < DATE(Now())  && `status` = 1 && `users`.`paypal` != ''
GROUP BY `userid` HAVING SUM(`amount`) >= 5");
echo "<textarea style='width:100%; height:200px;'>";
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
else echo "Nothing to be paid.";
echo "</textarea>";
?>
<br><br><a href="payoutCSVMBDH.php"><button>Download</button></a><br>Subject: Here are your SurfDuel earnings. Thank you for your support!<br><br><form method="post"><input name="completePayout" type="submit" value="Complete"/></form>