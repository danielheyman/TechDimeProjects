<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-dollar"></i>
                <h3>Pending Cash</h3>
            </div>
            <div class="widget-content">
                 <?php
                $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'");
                $result2 = $db->query("SELECT SUM(`commissions`.`amount`) AS `sum` FROM `commissions`  LEFT JOIN `transactions` ON `transactions`.`id` = `commissions`.`transactionid` WHERE `status` = '1' && `commissions`.`userid` = '{$usr->data->id}' && ((DATE(`transactions`.`date`)  < DATE(NOW() - INTERVAL 13 DAY) && `commissions`.`amount` > 0) || (`commissions`.`amount` < 0))");

    
                $sum = $result->getNext()->sum;
                if($sum == "") $sum = "0";
                $sum2 = $result2->getNext()->sum;
                if($sum2 == "") $sum2 = "0";
                echo "You have a total of &#36;{$sum} in unpaid commissions out of which &#36;{$sum2} is available.<br><br>";
                ?>
                <div style="max-height:300px;overflow:auto;"><table class="table table-bordered table-hover table-striped">
                    <thead><tr><th>Date</th><th>User</th><th>Amount</th><th>Item</th><th>Status</th></tr></thead>
                    <?php
                        $results = $db->query("SELECT `commissions`.`amount`, CASE WHEN (DATE(`transactions`.`date`) < DATE(NOW() - INTERVAL 13 DAY) || `commissions`.`amount` < 0) THEN 'Available' ELSE 'Grace Period' END AS `status`, (SELECT `users`.`fullName` FROM `users` WHERE `transactions`.`userid` = `users`.`id`) AS `fullName`, `transactions`.`date`, `transactions`.`item_name` FROM `commissions` LEFT JOIN `transactions` ON `transactions`.`id` = `commissions`.`transactionid` WHERE `status` = '1' && `commissions`.`userid` = '{$usr->data->id}' ORDER BY `commissions`.`id` DESC");

                        while($result = $results->getNext())
                        {
                            if($result->fullName == "" || $result->fullName == $usr->data->fullName) $result->fullName = "You";
                            $date = date('F j, Y @ g:i A',strtotime($result->date));
                            $result->amount = (strpos($result->amount, "-") !== false) ? str_replace("-", "- $", $result->amount) : "$" . $result->amount;
                            echo "<tr><td>{$date}</td><td>{$result->fullName}</td><td>{$result->amount}</td><td>{$result->item_name}</td><td>{$result->status}</td></tr>";
                        }
                    ?>
                </table></div>
            </div>
        </div>
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-dollar"></i>
                <h3>Paid Cash</h3>
            </div>
            <div class="widget-content">
                 <?php
                $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '0' && `userid` = '{$usr->data->id}'");
                $sum = $result->getNext()->sum;
                if($sum == "") $sum = "0";
                echo "You have a total of &#36;{$sum} in paid commissions<br><br>";
                ?>
                <div style="max-height:300px;overflow:auto;"><table class="table table-bordered table-hover table-striped">
                    <thead><tr><th>Date</th><th>User</th><th>Amount</th><th>Item</th></tr></thead>
                    <?php
                        $results = $db->query("SELECT `commissions`.`amount`, (SELECT `users`.`fullName` FROM `users` WHERE `transactions`.`userid` = `users`.`id`) AS `fullName`, `transactions`.`date`, `transactions`.`item_name` FROM `commissions` LEFT JOIN `transactions` ON `transactions`.`id` = `commissions`.`transactionid` WHERE `status` = '0' && `commissions`.`userid` = '{$usr->data->id}' ORDER BY `commissions`.`id` DESC");
                        while($result = $results->getNext())
                        {
                            if($result->fullName == "" || $result->fullName == $usr->data->fullName) $result->fullName = "You";
                            $date = date('F j, Y @ g:i A',strtotime($result->date));
                            $result->amount = (strpos($result->amount, "-") !== false) ? str_replace("-", "- $", $result->amount) : "$" . $result->amount;
                            echo "<tr><td>{$date}</td><td>{$result->fullName}</td><td>{$result->amount}</td><td>{$result->item_name}</td></tr>";
                        }
                    ?>
                </table></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <h4>How it works</h4>
            <p>We issue payments every Friday through Paypal. You must have a minimum of $15 in your commission balance to recieve the payment, with a 14 day grace period. This means commissions earned won't be paid for 14 days, allowing time for refunds and cheat detection. Make sure to update your Paypal email in the <a href="<?=$site["url"]?>settings">Settings</a>.</p>
        </div>
        <div class="well">
            <h4>Earnings</h4>
            Not only will referrals take part in your downline network, but you also currently earn <?=$membership[$usr->data->membership]["refEarnings"] * 100?>% of referral earnings &amp; <?=$membership[$usr->data->membership]["refCommisionPercent"] * 100?>% commissions. Referral earnings include their surfing bonuses, paid to click earnings, and much more coming soon. Earnings for the whole day are added to your account every day at midnight if you remain active. You will earn commissions on upgrades and coin purchases for all your referrals. <a href="<?=$site['url']?>upgrade">Learn more</a>.
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>