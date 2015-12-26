<?php include 'header.php'; ?>
<div class="title">Commissions</div>
<hr>
<div class="text">
    <?php if($usr->data->membership == 0001) { ?><a href="<?=$site["url"]?>upgrade"><div class="promo">Get 50% commissions as an upgraded member!</div></a><?php } ?>
    <div class="subtitle">How it works</div>
    We issue payments every Friday through Paypal. You must have a minimum of $10 in your commission balance to recieve the payment. Make sure to update your Paypal email in the <a href="<?=$site["url"]?>settings">Settings.</a><br><br>
    <div class="subtitle">Total</div>
    <?php
    $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'");
    $sum = $result->getNext()->sum;
    if($sum == "") $sum = "0";
    echo "You have a total of &#36;{$sum} in unpaid commissions<br>";
    $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '0' && `userid` = '{$usr->data->id}'");
    $sum = $result->getNext()->sum;
    if($sum == "") $sum = "0";
    echo "You have a total of &#36;{$sum} in paid commissions<br><br>";
    ?>
    <div class="subtitle">Pending Commissions</div>
    <table>
        <tr class="first"><td width='50%'><strong>Date</strong></td><td><strong>Amount</strong></td><td><strong>Item</strong></td></tr>
        <?php
            $results = $db->query("SELECT `amount`, (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`) AS `date`, (SELECT `item_name` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`) AS `name` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'");
            $odd = true;
            $count = 1;
            while($result = $results->getNext())
            {
                if($odd)
                {
                    echo "<tr class='odd'>";
                    $odd = false;
                }
                else
                {
                    echo "<tr class='even'>";
                    $odd = true;
                }
                $date = date('F j, Y @ g:i A',strtotime($result->date));
                echo "<td>{$date}</td><td>&#36;{$result->amount}</td><td>{$result->name}</td></tr>";
                $count++;
            }
        ?>
    </table><br>
    <div class="subtitle">Paid Commissions</div>
    <table>
        <tr class="first"><td width='50%'><strong>Date</strong></td><td><strong>Amount</strong></td><td><strong>Item</strong></td></tr>
        <?php
            $results = $db->query("SELECT `amount`, (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`) AS `date`, (SELECT `item_name` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`) AS `name` FROM `commissions` WHERE `status` = '0' && `userid` = '{$usr->data->id}'");
            $odd = true;
            $count = 1;
            while($result = $results->getNext())
            {
                if($odd)
                {
                    echo "<tr class='odd'>";
                    $odd = false;
                }
                else
                {
                    echo "<tr class='even'>";
                    $odd = true;
                }
                $date = date('F j, Y @ g:i A',strtotime($result->date));
                echo "<td>{$date}</td><td>&#36;{$result->amount}</td><td>{$result->name}</td></tr>";
                $count++;
            }
        ?>
    </table>
</div>
<?php include 'footer.php'; ?>