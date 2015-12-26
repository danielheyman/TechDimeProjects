<?php include 'header.php'; ?>
<div class="header">Sites</div>
<?php
    if($getVar)
    {
        if(strstr($getVar, '-'))
        {
            $getVar = explode("-", $getVar);
            $query = $db->query("SELECT`enabled` FROM `websites` WHERE `id` = '{$getVar[1]}' LIMIT 1");
            if($query->getNumRows())
            {
                $enabled = $query->getNext()->enabled;
                switch($getVar[0])
                {
                    case "del":
                        $db->query("DELETE FROM `websites` WHERE `id` = '{$getVar[1]}' && `userid` = '{$usr->data->id}'");
                        echo "<div class='success'>SUCCESS: The site has been deleted.</div><br><br>";
                        break;
                    case "pau":
                        if($enabled == "1")
                        {
                            $db->query("UPDATE `websites` SET `enabled` = '0' WHERE `id` = '{$getVar[1]}' && `userid` = '{$usr->data->id}'");
                            echo "<div class='success'>SUCCESS: The site has been paused.</div><br><br>";
                        }
                        else echo "<div class='error'>Your website is already pause.</div><br><br>";
                        break;
                    case "ena":
                        if($enabled == "0")
                        {
                            $result = $db->query("SELECT COUNT(`id`) AS `count` FROM `websites` WHERE `userid` = '{$usr->data->id}' && `enabled` = '1'");
                            $count = $result->getNext()->count;
                            if($count < $membership[$usr->data->membership]["maximumSites"])
                            {
                                $db->query("UPDATE `websites` SET `enabled` = '1' WHERE `id` = '{$getVar[1]}' && `userid` = '{$usr->data->id}'");
                                echo "<div class='success'>SUCCESS: The site has been enabled.</div><br><br>";
                            }
                            else echo "<div class='error'>You have reached the maximum amount of active websites you may have. <br>You may either disable one or upgrade <a href='{$site['url']}upgrade'>here</a>.</div><br><br>";
                        }
                        else echo "<div class='error'>Your website is already enabled.</div><br><br>";
                        break;
                }
            }
            else echo "<div class='error'>Website not found.</div><br><br>";
        }
    }
    $result = $db->query("SELECT COUNT(`id`) AS `count` FROM `websites` WHERE `userid` = '{$usr->data->id}' && `enabled` = '1'");
    $count = $result->getNext()->count;
    if($count > 0 && $usr->data->dailyViews < $membership[$usr->data->membership]["dailyViews"]) echo "<div class='error'>You must get " . ($membership[$usr->data->membership]["dailyViews"] - $usr->data->dailyViews)  . " more views today for your websites to be active in surf tomorrow.</div><br><br>";
    else echo "<div class='success'>Your websites will be active in surf tomorrow.</div><br><br>";

?>
<script>
    function deleteSite(id){
        var confirmLeave = confirm('Are you sure you want to delete the website?');
        if (confirmLeave==true)
        {
            window.location = "<?=$site["url"]?>sites/del-" + id;
        }
        else
        {
            return false;
        }
    }
    function pauseSite(id){
        var confirmLeave = confirm('Are you sure you want to pause the website?');
        if (confirmLeave==true)
        {
            window.location = "<?=$site["url"]?>sites/pau-" + id;
        }
        else
        {
            return false;
        }
    }
    function enableSite(id){
        var confirmLeave = confirm('Are you sure you want to enable the website?');
        if (confirmLeave==true)
        {
            window.location = "<?=$site["url"]?>sites/ena-" + id;
        }
        else
        {
            return false;
        }
    }
</script>
<?php
    echo "<div class='content'>";
    
    $totalViews = $db->query("SELECT SUM(`viewsYesterday`) AS `count` FROM `websites` WHERE `userid` = '{$usr->data->id}'")->getNext()->count;
    if($totalViews > 0 && $usr->data->membership == "0001")
    {
        $totalViews = number_format($totalViews * 30);
        echo "<a href='{$site['url']}upgrade'><div class='promo'>As a platinum member, you would be getting {$totalViews} views a month doing absolutely nothing.</div></a><br>"; 
    }

    $results = $db->query("SELECT `id`, `url`, `enabled`, `inSurf`, `views`, `likes`, `winner`, `winnerYesterday` FROM `websites` WHERE `userid` = '{$usr->data->id}'");
    if($results->getNumRows())
    {
        $winner = "";
        $winner2 = "";
        echo "Likes and views for your websites reset every day at midnight.<br>Current server time: " . date("h:i A") . "<br><br><div style='max-height:200px; overflow:auto;'><table cellspacing='0'><tr class='first'><td><strong>URL</strong></td><td><strong>Enabled</strong></td><td><strong>In Surf</strong></td><td><strong>Views</strong></td><td><strong>Likes</strong></td><td></td></tr>";
        $odd = true;
        $count2 = 1;
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
            $enabled = ($result->enabled == "1") ? "<a href='javascript:pauseSite({$result->id})'>Pause</a>" : "<a href='javascript:enableSite({$result->id})'>Enable</a>";
            $surf = ($result->inSurf) ? "Yes" : "No";
            if($result->winner != "0") {
                $winner .= "<br>" . $result->url . " won place #" . $result->winner;
            }
            if($result->winnerYesterday != "0") {
                $winner2 .= "<br>" . $result->url . " won place #" . $result->winnerYesterday;
            }
            echo "<td>{$result->url}</td><td>{$enabled}</td><td>{$surf}</td><td>{$result->views}</td><td>{$result->likes}</td><td><a href='javascript:deleteSite({$result->id})'>Delete</a></td></tr>";
            $count2++;
        }
        echo "</table></div></div><table style='margin-top:-20px; width:100%;'><tr valign='top'><td width='50%'><div style='padding-right:20px;text-align:right; font-size:10pt;'>Today's Winners: ";
        echo ($winner != "") ? $winner : "Your websites didn't win today.";
        echo "</div></td><td><div style='padding-left:20px; text-align:left; font-size:10pt;'>Yesterday's Winners: ";
        echo ($winner2 != "") ? $winner2 : "Your websites didn't win yesterday.";
        echo "</div></td></tr></table><br><br>";
    }
?>
<?php
if($usr->data->views - $count * 100 >= 100)
{
    if($count < $membership[$usr->data->membership]["maximumSites"])
    {
        ?>
            <div class="tableinfo" style="height:180px;">
                <div class="wrap">
                    <div class="column one">
                    </div>
                    <div class="column two">
                        <div class="register">
                            <form method="post" action="<?=$site["url"]?>surf">
                                    <?php 
                                        $gui->input(["name" => "websiteURL", "type" => "text"],"Website URL");
                                        echo "<br>";
                                        $gui->input(["name" => "websiteSubmit", "type" => "submit", "value" => "Submit"]); 
                                    ?>
                            </form>
                        </div>
                    </div>
                    <div class="column three">
                   </div>
                </div>
            </div>
        <?php
    }
    else echo "<div class='error'>You have reached the maximum amount of active websites you may have. <br>You may either disable one or upgrade <a href='{$site['url']}upgrade'>here</a>.</div>";
}
else echo "<div class='error'>You must surf another " . ( 100 - ($usr->data->views - $count * 100) ) . " websites before you can add your own site.</div>";
?>
<?php include 'footer.php'; ?>