<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-group"></i>
                <h3>Referrals</h3>
            </div>
            <div class="widget-content">
                <?php
                $result = $db->query("SELECT COUNT(`ref`) AS `count` FROM `users` WHERE `ref` = '{$usr->data->id}' && `activation` = '1'"); 
                $count = $result->getNext()->count;
                if($count == 0)
                {
                    echo "<div class='error'>You do not have any referrals to be viewed.</div>";  
                }
                else
                {
                    echo "You have a total of {$count} referral";
                    if($count != 1) echo "s";
                    echo ".";
                    
                    $results = $db->query("SELECT `membership`, (SELECT SUM(`amount`) FROM `transactions` WHERE `userid` = `users`.`id`) AS `amount`, `fullName`, `registerDate` FROM `users` WHERE `ref` = '{$usr->data->id}' && `activation` = '1' ORDER BY `id` DESC");
                    if($results->getNumRows())
                    {
                        echo "<br><br><div style='max-height:300px;overflow:auto;'><table class='table table-bordered table-hover table-striped'><thead><tr><th>Date Joined</th><th>Name</th><th>Membership</td><th>Amount Spent</td></tr></thead>";
                        while($result = $results->getNext())
                        {
                            $cash = ($result->amount != "") ? number_format($result->amount,2) : "0.00";
                            echo "<td>{$result->registerDate}</td><td>{$result->fullName}</td><td>{$membership[$result->membership]['name']}</td><td>$ {$cash}</td></tr>";
                        }
                        echo "</table></div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <h4>Referral Link</h4>
            <input value="<?=$site['url']?><?=$usr->data->id?>" class="form-control">
        </div>		
        <div class="well">
            <h4>Earnings</h4>
            Not only will referrals take part in your downline network, but you also currently earn <?=$membership[$usr->data->membership]["refEarnings"] * 100?>% of referral earnings &amp; <?=$membership[$usr->data->membership]["refCommisionPercent"] * 100?>% commissions. Referral earnings include their surfing bonuses, paid to click earnings, and much more coming soon. Earnings for the whole day are added to your account every day at midnight if you remain active. You will earn commissions on upgrades and coin purchases for all your referrals. <a href="<?=$site['url']?>upgrade">Learn more</a>.
        </div>
        <!--<div class="well">
            <h4>How it works</h4>
            <p>You will earn commissions on upgrades and coin purchases for all your referrals. In addition, they will take part in your downline network.</p>
        </div>	-->			
    </div>
</div>
<?php include 'footer.php'; ?>