<?php include 'header.php'; ?>
<div class="title">Promotion</div>
<hr>
<div class="text">
    <?php if($usr->data->membership == 0001) { ?><a href="<?=$site["url"]?>upgrade"><div class="promo">Get 50% commissions as an upgraded member!</div></a><?php } ?>
    <div class="subtitle">Referrals</div>
    <?php
    $result = $db->query("SELECT COUNT(`ref`) AS `count` FROM `users` WHERE `ref` = '{$usr->data->id}'");
    $count = $result->getNext()->count;
    echo "You have a total of {$count} referral";
    if($count != 1) echo "s";
    ?>
    <?php
        $results = $db->query("SELECT `views`, `id`, `fullName`, `dailyViews` FROM `users` WHERE `ref` = '{$usr->data->id}'");
        if($results->getNumRows())
        {
            echo "<br><br><div style='max-height:200px; overflow:auto;'><table><tr class='first'><td><strong>Name</strong></td><td><strong>Surfed more than 20</strong></td><td><strong>Daily Views</strong></td><td><strong>Message</strong></td></tr>";
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
                $surfed20 = ($result->views >= 20) ? "Yes" : "No";
                echo "<td>{$result->fullName}</td><td>{$surfed20}</td><td>{$result->dailyViews}</td><td><a href='javascript:startChat(\"{$result->fullName}\",\"{$result->id}\");'>Send a Message</a></td></tr>";
                $count++;
            }
            echo "</table></div>";
        }
    ?>
    
    <br><br><div class="subtitle">Promotion URL</div>
    Make sure to share you referral link
    <div class="form">
        <input style="width:250px;" onClick="this.select();" type="text" value="<?php echo $site["url"] . $usr->data->id; ?>"/> 
        <a target="_blank" href="<?php echo $site["url"] . $usr->data->id; ?>"><input type="submit" value="Open"/></a>
    </div>
    <br><div class="subtitle">Splash Pages</div>
    Get maximum exposure using our promotion tools
    <div class="form">
        <input style="width:250px;" onClick="this.select();" type="text" value="<?php echo $site["url"] . "splash.php?r=" . $usr->data->id; ?>"/>
        <a target="_blank" href="<?php echo $site["url"] . "splash.php?r=" . $usr->data->id; ?>"><input type="submit" value="Open"/></a>
    </div>
    <br>
    <div class="form">
        <input style="width:250px;" onClick="this.select();" type="text" value="<?php echo $site["url"] . "splash2.php?r=" . $usr->data->id; ?>"/>
        <a target="_blank" href="<?php echo $site["url"] . "splash2.php?r=" . $usr->data->id; ?>"><input type="submit" value="Open"/></a>
    </div>
    <br>
    <div class="form">
        <input style="width:250px;" onClick="this.select();" type="text" value="<?php echo $site["url"] . "splash3/" . $usr->data->id; ?>"/>
        <a target="_blank" href="<?php echo $site["url"] . "splash3/" . $usr->data->id; ?>"><input type="submit" value="Open"/></a>
    </div>
    <br>
    <div class="subtitle">Banners</div>
    <div class="form">
    <a href="<?php echo $site["url"] . $usr->data->id; ?>" target="_BLANK" rel="external"><img src="http://www.brisksurf.com/banner.png" style="border:none;"/></a><br>
        HTML<br> <input style="width:250px;" onClick="this.select();" type="text" value='<a href="<?php echo $site["url"] . $usr->data->id; ?>" target="_BLANK" rel="external"><img src="http://www.brisksurf.com/banner.png" style="border:none;"></a>'/><br>
        Link<br> <input style="width:250px;" onClick="this.select();" type="text" value='http://www.brisksurf.com/banner.png'/>
        <a target="_blank" href="http://www.brisksurf.com/banner.png"><input type="submit" value="Open"/></a>
    </div>
    <br>
    <div class="form">
    <a href="<?php echo $site["url"] . $usr->data->id; ?>" target="_BLANK" rel="external"><img src="http://www.brisksurf.com/banner2.png" style="border:none;"/></a><br>
        HTML<br> <input style="width:250px;" onClick="this.select();" type="text" value='<a href="<?php echo $site["url"] . $usr->data->id; ?>" target="_BLANK" rel="external"><img src="http://www.brisksurf.com/banner2.png" style="border:none;"></a>'/><br>
        Link<br> <input style="width:250px;" onClick="this.select();" type="text" value='http://www.brisksurf.com/banner2.png'/>
        <a target="_blank" href="http://www.brisksurf.com/banner2.png"><input type="submit" value="Open"/></a>
    </div>
</div>
<?php include 'footer.php'; ?>