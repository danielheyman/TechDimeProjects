<?php
$hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $sec->cookie("YDSESSION"));
$result = $db->query("SELECT `admin` FROM `sessions` WHERE `hash` = '{$hash}' && `admin` >= 1 && `admin` <= 3 LIMIT 1");
if($result->getNumRows() && $getVar == "leaveAccount")
{
    $hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $sec->cookie("YDSESSION"));
    $admin = $result->getNext()->admin;
    $result = $db->query("UPDATE `sessions` SET `userid` = '{$admin}', `admin` = 0 WHERE `hash` = '{$hash}' LIMIT 1");
    $usr->getData();   
}
?>

<?php include 'header.php'; ?>
<div class="row">
    <?php
    if($sec->post("levelup") && $usr->data->level * 2 - $usr->data->xp <= 0 && $usr->data->coins >= pow($usr->data->level, 2) * 2 && $usr->data->level < 5)
    {
        $price = pow($usr->data->level, 2) * 2;
        $query = $db->query("UPDATE `users` SET `level` = `level` + 1, `xp` = 0, `coins` = `coins` - {$price} WHERE `id` = '{$usr->data->id}' && `level` < 5");
        ?>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Well done!</strong> You are leveled up.
            </div>
        </div>
        <?php
        $usr->getData();
    }
    ?>
    <div class="col-md-12">
        <!--<a target="_blank" href="http://kore4.com/?referer=introace"><div style="background:url(http://kore4.com/images/introducing.png); background-repeat:no-repeat; background-position:center 10px; border:1px solid #D5D5D5; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; -0-border-radius:5px; padding-top:80px; background-size:120px; text-align:center; color:#816e6e; font-size:20px; padding-bottom:10px;">Putting Affiliates Before All</div></a>
        <br>-->
        <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
            <tr style="height:360px;">
                <td width="33%;">
                    <div style="border: 1px solid #D5D5D5; height:360px; text-align:center; overflow:hidden; border-radius:5px; -webkit-border-radius:5px; -o-border-radius:5px; -moz-border-radius:5px; background:#fff;">
                        <div style="margin-top:30px; font-size:27px; font-weight:bold; color:#F90; line-height:35px;">
                            Fuel Your Account<br>By Remaining Active
                        </div>
                        <div style="padding-top:20px; width:270px; margin:auto;">
                            <p style="font-weight:bold; margin-bottom:10px;">Find the Surf Savant shield while surfing at each one of these traffic exchanges to be marked as active for the day.</p>
                            
                            <p style="font-weight:bold; margin-bottom:10px;">Hint: Keep your eyes peeled at around 27 pages, and don't forget to keep surfing for random cash prizes!</p>
                            
                            <p style="font-weight:bold; margin-bottom:10px;"><a target="_blank" href="http://blog.surfsavant.com/remain-active-at-surf-savant/">Learn more</a> about remaining active.</p>
                            
                            <p style="font-weight:bold;">Current server time: <?=date("h:i A")?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
                        <?php
                            $email = md5(strtolower(trim($usr->data->email)));
                            $handle = curl_init("http://www.gravatar.com/avatar/{$email}?s=125&default=404");
                            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
                            $response = curl_exec($handle);
                            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
                            if($httpCode == 404) 
                            {
                                $buttons = '{type: "submit", value: "Continue"},{type: "cancel", value: "Cancel"}';
                                $message = '"If you want to appear in the \'Who Am I?\' branding game then you must change you <a target=\'_blank\' href=\'' . $site['url'] . 'settings\'>Gravatar</a> from the default."';
                            }
                            else 
                            {
                                $buttons = '{type: "submit", value: "Yes"},{type: "submit", value: "No"},{type: "cancel", value: "Cancel"}';
                                $message = '"Are you branding yourself at " + name + "? Selecting Yes will add you to the \'Who Am I?\' Branding Game. Be sure to do this each day to participate in the game."';
                            }
                            curl_close($handle);
                        ?>
                        <style>
                            .jquery-msgbox-wrapper {
                                padding: 20px 20px 20px 20px;
                            }
                        </style>
                        <script>
                            function launch(id, name)
                            {
                                <?php if($usr->data->activeBranding == '1') { ?>
                                    window.open("<?=$site["url"]?>redirect/" + id + "-n");
                                <?php } else { ?>
                                $.msgbox(<?=$message?>, {
                                  type: "warning",
                                  buttons : [
                                    <?=$buttons?>
                                  ]
                                }, function(result) {
                                    if(result)
                                    {
                                        window.open("<?=$site["url"]?>redirect/" + id + "-" + result);
                                    }
                                });
                                <?php } ?>
                            }
                        </script>
                        <?php
                        
                        $countSites = $db->query("SELECT COUNT(`id`) AS `count` FROM `activitySites` WHERE active != 0")->getNext()->count;
                        
                        $result = $db->query("SELECT * FROM `activitySites` WHERE active != 0 ORDER BY CASE WHEN `active` = 4 THEN 0 ELSE `active` END ASC LIMIT 4");
                        $count = 1;
                        $completedCount = 0;
                        $name = "";
                        $dayofmonth = date("j");
                        while($page = $result->getNext())
                        {
                            $completedSurf = $db->query("SELECT `id` FROM `shield` WHERE `userid` = '{$usr->data->id}' && `activitySite` = '{$page->active}'")->getNumRows();
                            $formatURL = $sec->formatURL($page->url);
                            $video = $db->query("SELECT `id` FROM `videos` WHERE `downlineLink` like '%{$formatURL}%'");
                            if($video->getNumRows())
                            {
                                $id = $video->getNext()->id;
                                $reflink = $site['url'] . "video/" . $id;
                                $reflink = '<a href="' . $reflink . '"><div class="updateref">Update<br>Referral<br>Link</div></a>';
                                $check = $db->query("SELECT `ref` FROM `videoRefs` WHERE `userid` = '{$usr->data->id}' && `videoid` = '{$id}'");
                                $completedRef = ($check->getNumRows() && $check->getNext()->ref != "");
                            }
                            else
                            {
                                $reflink = '<div class="updateref">No<br>Downline<br>Builder</div>';
                                $completedRef = true;
                            }
                            
                            if($completedSurf) $completedCount++;
                            
                            $completedShield = ($completedSurf) ? '' : ' display:none;';
                            $completedSurf = ($completedSurf) ? '8cbb83' : '979797';
                            $completedRef = ($completedRef) ? '8cbb83' : '979797';
                            if($page->active == 4) $name = $page->name;
                            ?>
                            <tr>
                                <td style="width:20px;"></td>
                                <td>
                                    <?=$reflink?>
                                    <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="width:75px;"></td>
                                            <td style="width:7px;"><div class="leftpipe"></div></td>
                                            <td><div style="height:15px; background:#<?=$completedRef?>;"></div></td>
                                            <td style="width:7px;"><div class="rightpipe"></div></td>
                                            <td style="width:75px;">
                                                
                                                <a href="javascript:launch('<?=$page->active?>', '<?=$page->name?>')">
                                                    
                                                <div style="height:75px; width:75px; border-radius:5px; -webkit-border-radius:5px; -o-border-radius:5px; -moz-border-radius:5px; text-align:center; background:#4fba5c; color:#fff;line-height:125px; text-align:center; font-size:50px; -moz-opacity:0.8; -o-opacity:0.8; -webkit-opacity:0.8; opacity:0.8; line-height:75px; position:absolute;<?=$completedShield?>"><i class="icon-shield"></i></div>
                                                
                                                <img class="<?php if($count == 1) echo 'tourStop3'; ?> <?php if($page->active == 4) echo 'guestSite' . $dayofmonth; ?>" src="<?=$page->banner?>" style="height:75px; width:75px; border-radius:5px; -webkit-border-radius:5px; -o-border-radius:5px; -moz-border-radius:5px;">
                                                </a>
                                            </td>        
                                            <td style="width:7px;"><div class="leftpipe"></div></td>
                                            <td><div class="<?php if($count == 1) echo 'tourStop4'; ?>" style="height:15px; background:#<?=$completedSurf?>;"></div></td>
                                            <td style="width:7px;"><div class="rightpipe"></div></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php
                                
                            if($count != 4)
                            {
                                echo '<tr style="height:20px;"><td></td></tr>';   
                            }
                            
                            $count++;
                        }
                        if($count == 4)
                        {
                            ?>
                            <tr>
                                <td style="width:20px;"></td>
                                <td>
                                    <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td style="width:75px;"></td>
                                            <td style="width:7px;"></td>
                                            <td></td>
                                            <td style="width:7px;"></td>
                                            <td style="width:75px;">
                                                <a href="<?=$site['url']?>activityBid" style="text-decoration:none;"><div style="position:relative; margin:auto;" class="updateref">TE Owners<br>Add Your<br>Site Here</div></a>
                                            </td>        
                                            <td style="width:7px;"></td>
                                            <td></td>
                                            <td style="width:7px;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <?php   
                        }
                        else if($usr->data->tourStep != "start" && $count == 5 && !$sec->cookie("guestSite{$dayofmonth}"))
                        {
                            ?>
                            <script>
                                
                                var tourGuest;
                                $(document).ready(function() {
                                    tourGuest = new TourGuide("tourGuest", [
                                        [".guestSite<?=$dayofmonth?>", "left", "We are thrilled to present <?=$name?>. This traffic exchange is our guest of the day."], 
                                        [".guestSite<?=$dayofmonth?>", "left", "In celebration, you will earn twice as many cash rewards when surfing here."]
                                    ], function() {
                                        this.setCookie("guestSite<?=$dayofmonth?>", "-", 1);
                                    });
                                    tourGuest.start();
                                });
                            </script>
                            <?php
                        }
                        
                        if($completedCount == 0) $boiler = 'empty';
                        else if($completedCount == 1 && $count == 4) $boiler = 'third';
                        else if($completedCount == 2 && $count == 4) $boiler = 'twothird';
                        else if($completedCount == 1 && $count == 5) $boiler = 'fourth';
                        else if($completedCount == 2 && $count == 5) $boiler = 'half';
                        else if($completedCount == 3 && $count == 5) $boiler = 'threefourth';
                        else $boiler = 'full';
                            
                        $completeActivity = ($completedCount == $count - 1) ? '8cbb83' : '979797';
                        ?>
                        
                    </table>
                </td>
                <td style="width:250px;"><div style="width:250px; height:360px; background:url(<?=$site['url']?>loggedIn/images/boiler/<?=$boiler?>.png), #93a3bb; background-position:center; background-repeat:no-repeat; border: 5px solid #D5D5D5; border-radius:5px; -webkit-border-radius:5px; -o-border-radius:5px; -moz-border-radius:5px;"></div></td>
            </tr>
        </table>
        <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td></td>
                <td style="width:249px;">
                    <div class="toppipe" style="margin-left:auto; margin-right:auto;"></div>
                    <div style="width:15px; height:40px; background:#<?=$completeActivity?>; margin:auto;"></div>
                    <div class="bottompipe" style="margin-left:auto; margin-right:auto;"></div>
                </td>
            </tr>
        </table>
        <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:56px;"><div class="curvedpipe"></div></td>
                <td><div style="height:15px; background:#<?=$completeActivity?>;"></div></td>
                <td style="width:148px;"><div class="longrightpipe"></div></td>
            </tr>
        </table>
        <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td style="width:65px;">
                    <div class="toppipe" style="margin-left:auto; margin-right:auto;"></div>
                    <div style="width:15px; height:40px; background:#<?=$completeActivity?>; margin:auto;"></div>
                    <div class="bottompipe" style="margin-left:auto; margin-right:auto;"></div>
                </td>
                <td></td>
                <td style="width:249px;">
                    <div class="toppipe" style="margin-left:auto; margin-right:auto;"></div>
                    <div style="width:15px; height:40px; background:#<?=$completeActivity?>; margin:auto;"></div>
                    <div class="bottompipe" style="margin-left:auto; margin-right:auto;"></div>
                </td>
            </tr>
        </table>
        <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
            <tr>
                <td>    
                    <table style="height:290px; table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
                        <tr style="height:64px;">
                            <td>
                                <table style="table-layout:fixed; border:0; width:100%;" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td style="width:64px;">
                                            <div class="tourStop1 levelbox">Level<br><?=$usr->data->level?></div>
                                        </td>
                                        <td style="width:7px;"><div class="leftpipe"></div></td>
                                        <td><div class="tourStop2" style="height:15px; background:#979797;"><div style="height:15px; background:#8cbb83; width:<?php $percent = (1 - ($usr->data->level * 2 - $usr->data->xp) / ($usr->data->level * 2)) * 100; if($percent > 100) $percent = 100; echo ($percent == 0) ? $percent = 1 : $percent; ?>%"></div></div></td>
                                        <td style="width:7px;"><div class="rightpipe"></div></td>
                                        <td style="width:64px;">
                                            <div class="levelbox"><?php $level = $usr->data->level + 1;echo ($level <= 5) ? "Level<br>{$level}" : "$50<br>Draw"; ?></div>
                                        </td>
                                        <td style="width:30px;"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="border: 1px solid #D5D5D5; height:197px; text-align:center; overflow:hidden; border-radius:5px; -webkit-border-radius:5px; -o-border-radius:5px; -moz-border-radius:5px; padding-top:30px; line-height:34px; margin-right:30px; margin-top:30px; font-weight:bold;">
                                        <?php if($usr->data->level * 2 - $usr->data->xp > 0 && $usr->data->level < 5) { ?>
                                            Be active for <?php echo ($usr->data->level * 2 - $usr->data->xp); ?> more day<?php if($usr->data->level * 2 - $usr->data->xp > 1) echo "s"; ?> to level up.
                                        <?php } else if($usr->data->level * 2 - $usr->data->xp > 0 && $usr->data->level = 5) { ?>
                                            Be active for <?php echo ($usr->data->level * 2 - $usr->data->xp); ?> more day<?php if($usr->data->level * 2 - $usr->data->xp > 1) echo "s"; ?> for a chance to win up to $50.
                                        <?php } else if($usr->data->coins >= pow($usr->data->level, 2) * 2 && $usr->data->level < 5) { ?>
                                            <a href="javascript:;" id="levelup">Click here to level up for <?=pow($usr->data->level, 2) * 2?> coins.</a>
                                            <form style="display:none;" id="levelupform" method="post" id="levelup"><input value="1" type="hidden" name="levelup"></form>
                                            <script>
                                                $("#levelup").click(function()
                                                {
                                                    $.msgbox("Are you sure you want to level up for <?=pow($usr->data->level, 2) * 2?> coins?", {
                                                      type: "warning",
                                                      buttons : [
                                                        {type: "submit", value: "Yes"},
                                                        {type: "submit", value: "No"}
                                                      ]
                                                    }, function(result) {
                                                        if(result == "Yes")
                                                        {
                                                            $("#levelupform").submit();
                                                        }
                                                    });
                                                });
                                                </script>
                                        <?php } else if($usr->data->level == 5) { ?>
                                            <a href="javascript:;" id="levelsfor50">Return to level one for a chance to win up to $50 ($0.50 guaranteed).</a>
                                            <script>
                                                $("#levelsfor50").click(function()
                                                {
                                                    $.msgbox("Are you sure you want to return to level one for a chance to win up to $50 with a $0.50 guarantee win?", {
                                                      type: "warning",
                                                      buttons : [
                                                        {type: "submit", value: "Yes"},
                                                        {type: "submit", value: "No"}
                                                      ]
                                                    }, function(result) {
                                                        if(result == "Yes")
                                                        {
                                                            window.location = "<?=$site['url']?>card2";
                                                        }
                                                    });
                                                });
                                            </script>
                                        <?php } else if($usr->data->level < 5) { ?>
                                            You are eligible to level up, but you must first gain <?=pow($usr->data->level, 2) * 2?> coins.
                                        <?php } ?>
                                        <br>Be active today to earn <?=$usr->data->level?> coin<?php if($usr->data->level > 1) echo "s"; ?>.
                                        <br>Complete level 5 for a chance to win $50.
                                        <br>
                                        <a href="<?=$site["url"]?>vacation"><?=$usr->data->vacations?> Vacation Days</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width:480px">
                    <div style="border: 1px solid #D5D5D5; height:290px; overflow:hidden; border-radius:5px; -webkit-border-radius:5px; -o-border-radius:5px; -moz-border-radius:5px; text-align:left; padding:20px;">
                            <p style="color:#4A6896; line-height:15px;">Every day you are active you get the following benefits the next day:</p>
                            <p style="line-height:22px;">
                                &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Get up to 20% of your referral earnings.
                                <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Play the the branding game and become a star.
                                <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Play the stock game to keep up with the trends.
                                <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Reach level five for a chance to win a fancy $50.
                            </p><br>
                            <p style="color:#4A6896; line-height:15px;">You can use your coins to:</p>
                            <p style="line-height:22px;">
                                &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Get exposure through the rotator, advertised by members.
                                <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Level up and to earn greater stock rewards and more daily coins.
                                <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Buy stocks in your favorite TE and sell them for profit.
                                <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Buy vacation days and take days off.
                            </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>
<?php include 'footer.php'; ?>