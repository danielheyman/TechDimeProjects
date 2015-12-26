<?php include 'header.php'; ?>
<?php $subscription = 6; $subscription2 = 7; ?>
<div class="title">Upgrade</div>
<hr>
<div class="text">
    <table>
        <tr class="first"><td><strong>Free</strong></td><td><strong>Premium</strong></td><td><strong>Platinum</strong></td></tr>
        <tr class="odd"><td><?=$membership["0001"]["viewCredit"]?> Credits Per Page View</td><td><?=$membership["0002"]["viewCredit"]?> Credits Per Page View</td><td><?=$membership["0003"]["viewCredit"]?> Credits Per Page View</td></tr>
        <tr class="even"><td><?=$membership["0001"]["viewTime"]?> Seconds View Time <div class="red">*</div></td><td><?=$membership["0002"]["viewTime"]?> Seconds View Time <div class="red">*</div></td><td><?=$membership["0003"]["viewTime"]?> Seconds View Time <div class="red">*</div></td></tr>
        <tr class="odd"><td><?=$membership["0001"]["refCredit"]?> Credits Per Referral View <div class="red">**</div></td><td><?=$membership["0002"]["refCredit"]?> Credits Per Referral View <div class="red">**</div></td><td><?=$membership["0003"]["refCredit"]?> Credits Per Referral View <div class="red">**</div></td></tr>
        <tr class="even"><td><?php echo $membership["0001"]["refCommisionPercent"] * 100; ?>% Commission on Upgrades</td><td><?php echo $membership["0002"]["refCommisionPercent"] * 100; ?>% Commission on Upgrades</td><td><?php echo $membership["0003"]["refCommisionPercent"] * 100; ?>% Commission on Upgrades</td></tr>
        <tr class="odd"><td><?=$membership["0001"]["monthlyCredits"]?> Credits Per Month</td><td><?=$membership["0002"]["monthlyCredits"]?> Credits Per Month</td><td><?=$membership["0003"]["monthlyCredits"]?> Credits Per Month</td></tr>
        
<?php if($usr->data->membership == 0001) { ?>
        
        <tr class="even"><td>It's FREE</td><td><div class="red"><del>$9 per Month</del></div><br>Now only $5.40 per Month</td><td><div class="red"><del>$19 per Month</del></div><br>Now only $11.40 per Month</td></tr>
    <tr class="odd">
        <td></td>    
        <td>
            <div class="form">
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="a3" value="<?=$subscriptions[$subscription]["price"]?>">
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
            <div class="form">
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="a3" value="<?=$subscriptions[$subscription2]["price"]?>">
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
<?php } ?>
    </table><br>
    <div class="red">*</div> View Time: The amount of time other users have to view your website<br>
    <div class="red">**</div> Credits Per Referral View: The amount of credits you earn for every website your referral views<br><br>
    <?php
    if($usr->data->membership != 0001)
    {
        $date = date('F j, Y @ g:i A',strtotime($usr->data->membershipExpires));
        echo "You are an " . $membership[$usr->data->membership]["name"] . " member [Expires {$date}]<br><br>You can cancel your subscription through your Paypal account.";
    } ?>
</div>
<?php include 'footer.php'; ?>