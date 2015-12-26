<?php include 'header.php'; ?>
<?php $subscription = 24; $subscription2 = 29; ?>
<?php $subscription3 = 26; $subscription4 = 27; ?>
<div class="title">Upgrade</div>
<hr>
<div class="text">
    <table>
        <tr class="first"><td><strong>Free</strong></td><td><strong>Premium</strong></td><td><strong>Platinum</strong></td></tr>
        
        <tr class="odd"><td><?=$membership["0001"]["viewCredit"]?> Credits Per Page View</td><td><?=$membership["0002"]["viewCredit"]?> Credits Per Page View</td><td><?=$membership["0003"]["viewCredit"]?> Credit Per Page View</td></tr>
        
        <tr class="even"><td>Your Ads Display for <?=$membership["0001"]["viewTime"]?> Seconds</td><td>Your Ads Display for <?=$membership["0002"]["viewTime"]?> Seconds</td><td>Your Ads Display for <?=$membership["0003"]["viewTime"]?> Seconds</td></tr>
        
        <tr class="odd"><td><?=$membership["0001"]["refCredit"] * 100?>% Referral Credits</td><td><?=$membership["0002"]["refCredit"] * 100?>% Referral Credits</td><td><?=$membership["0003"]["refCredit"] * 100?>% Referral Credits</td></tr>
        
        <tr class="even"><td><?php echo $membership["0001"]["refCommisionPercent"] * 100; ?>% Commission</td><td><?php echo $membership["0002"]["refCommisionPercent"] * 100; ?>% Commission</td><td><?php echo $membership["0003"]["refCommisionPercent"] * 100; ?>% Commission</td></tr>
        
        <tr class="odd"><td><?=$membership["0001"]["monthlyCredits"]?> Credits Per Month</td><td><?=$membership["0002"]["monthlyCredits"]?> Credits Per Month</td><td><?=$membership["0003"]["monthlyCredits"]?> Credits Per Month</td></tr>
        
<?php if($usr->data->membership == 0001) { ?>
        
    <tr class="even">
        <td>FREE</td>    
        <td>
            $7 per Month
            <div class="form">
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="a3" value="<?=$packages[$subscription]["price"]?>">
                    <input type="hidden" name="p3" value="1">
                    <input type="hidden" name="t3" value="M">
                    <input type="hidden" name="src" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="<?=$site["name"]?> Premium Monthly Upgrade">
                    <input type="hidden" name="item_number" value="<?=$subscription?>">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                    <input type="submit" value='Upgrade Now' name="submit">
                </form>
            </div>
        </td>    
        <td>
            $14 per Month
            <div class="form">
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="a3" value="<?=$packages[$subscription2]["price"]?>">
                    <input type="hidden" name="p3" value="1">
                    <input type="hidden" name="t3" value="M">
                    <input type="hidden" name="src" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="<?=$site["name"]?> Platinum Monthly Upgrade">
                    <input type="hidden" name="item_number" value="<?=$subscription2?>">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                    <input type="submit" value='Upgrade Now' name="submit">
                </form>
            </div>
        </td>    
    </tr>
        
    <tr class="odd">
        <td>FREE</td>    
        <td>
            <div class="red"><del>$84</del></div> 4 Months Free<br>$56 per Year
            <div class="form">
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="a3" value="<?=$packages[$subscription3]["price"]?>">
                    <input type="hidden" name="p3" value="1">
                    <input type="hidden" name="t3" value="Y">
                    <input type="hidden" name="src" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="<?=$site["name"]?> Premium Annual Upgrade">
                    <input type="hidden" name="item_number" value="<?=$subscription3?>">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                    <input type="submit" value='Upgrade Now' name="submit">
                </form>
            </div>
        </td>    
        <td>
            <div class="red"><del>$168</del></div> 4 Months Free<br>$112 per Year
            <div class="form">
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="a3" value="<?=$packages[$subscription4]["price"]?>">
                    <input type="hidden" name="p3" value="1">
                    <input type="hidden" name="t3" value="Y">
                    <input type="hidden" name="src" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="<?=$site["name"]?> Platinum Annual Upgrade">
                    <input type="hidden" name="item_number" value="<?=$subscription4?>">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                    <input type="submit" value='Upgrade Now' name="submit">
                </form>
            </div>
        </td>    
    </tr>
        
        
        
        
<?php } ?>
    </table><br>
    <?php
    if($usr->data->membership != 0001)
    {
        $date = date('F j, Y @ g:i A',strtotime($usr->data->membershipExpires));
        echo "You are an " . $membership[$usr->data->membership]["name"] . " member [Expires {$date}]<br><br>You can cancel your subscription through your Paypal account.";
    } ?>
</div>
<?php include 'footer.php'; ?>