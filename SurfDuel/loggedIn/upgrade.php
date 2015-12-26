<?php include 'header.php'; $subscription = 7; $subscription2 = 8; ?>
<div class="header">Upgrade</div>
<div class="content">
    
    <div class="red">*</div> Required Views Per Day: The amount of daily views you need to get in order for your websites to be active and surfed the next day.
    <br><br><div class="red">**</div> Views Per Ref View: The amount of views you get for every view a referral makes.<br><br>
    <table cellspacing="0">
            <tr class="first"><?php foreach($membership as $mem) { echo "<td><strong>{$mem['name']}</strong></td>"; } ?></tr>
            <tr class="odd"><?php foreach($membership as $mem) { echo "<td>{$mem['dailyViews']} Required Views Per Day<div class='red'>*</div></td>"; } ?></tr>
            <tr class="even"><?php foreach($membership as $mem) { if($mem['refViews'] != "0") echo "<td>{$mem['refViews']} Views Per Ref View<div class='red'>**</div></td>"; else echo "<td>You don't need any views!</td>"; } ?></tr>
            <tr class="odd"><?php foreach($membership as $mem) { echo "<td>" . ($mem['refCommisionPercent'] * 100) . "%  Commission on Upgrades</td>"; } ?></tr>
            <tr class="even"><?php foreach($membership as $mem) { echo "<td>{$mem['maximumSites']} Maximum Websites</td>"; } ?></tr>
            
    <?php if($usr->data->membership == 0001) { ?>
            
            <tr class="odd"><td>It's FREE</td><td>$7 per Month</td><td>$13 per Month</td></tr>
        <tr class="even">
            <td></td>    
            <td>
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
                        <input type="hidden" name="item_name" value="<?=$site["name"]?> Monthly Upgrade">
                        <input type="hidden" name="item_number" value="<?=$subscription?>">
                        <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                        <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                        <input type="hidden" name="cancel_return" value="<?=$site["url"]?>upgrade">
                        <input type="hidden" name="return" value="<?=$site["url"]?>success">
                        <input type="submit" value='Upgrade Now' name="submit">
                    </form>
                </div>
            </td>    
            <td>
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
                        <input type="hidden" name="item_name" value="<?=$site["name"]?> Monthly Upgrade">
                        <input type="hidden" name="item_number" value="<?=$subscription2?>">
                        <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                        <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                        <input type="hidden" name="cancel_return" value="<?=$site["url"]?>upgrade">
                        <input type="hidden" name="return" value="<?=$site["url"]?>success">
                        <input type="submit" value='Upgrade Now' name="submit">
                    </form>
                </div>
            </td>    
        </tr>
    <?php } ?>
        </table>
        <?php
        if($usr->data->membership != 0001)
        {
            $date = date('F j, Y @ g:i A',strtotime($usr->data->membershipExpires));
            echo "<br><br>You are an " . $membership[$usr->data->membership]["name"] . " member [Expires {$date}]<br><br>You can cancel your subscription through your Paypal account.<br>";
        } ?>
</div>
<?php include 'footer.php'; ?>