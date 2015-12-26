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
    <div class="col-md-6">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-unlock"></i>
                <h3>Remain active</h3>
            </div>
            <div class="widget-content">
                <p>
                    <center>
                        <script>
                        function launch(id, name)
                        {
                            $.msgbox("Are you branding yourself at " + name + "? ( If you are using the default <a target='_blank' href='<?=$site['url']?>settings'>Gravatar</a>, then you will not appear in the branding game. )", {
                              type: "confirm",
                              buttons : [
                                {type: "submit", value: "No"},
                                {type: "submit", value: "Yes"},
                                {type: "cancel", value: "Cancel"}
                              ]
                            }, function(result) {
                                if(result)
                                {
                                    window.open("<?=$site["url"]?>redirect/" + id + "-" + result);
                                }
                            });
                        }
                        </script>
                        <font style="color:#4A6896;"><b>Find the Surf Savant shield</b></font> while surfing at each one of these traffic exchanges to be marked as active for the day (hint: keep your eyes peeled at around 27 pages), and don't forget to keep surfing for random cash prizes!
                        <br><br>
                        <?php
                        $countSites = $db->query("SELECT COUNT(`id`) AS `count` FROM `activitySites` WHERE active != 0")->getNext()->count;
                        $result = $db->query("SELECT * FROM `activitySites` WHERE active != 0 ORDER BY RAND()");
                        while($page = $result->getNext())
                        {
                            ?> <div class="activeSite" style="display:inline-block; float:left; width:33%; text-align:center; height:150px;"><a href="javascript:launch('<?=$page->active?>', '<?=$page->name?>')"><img src="<?=$page->banner?>" style="border-radius:3px; -moz-border-radius:3px; -o-border-radius:3px; -moz-border-radius:3px;">
                            <?php 
                            $completed = $db->query("SELECT `id` FROM `shield` WHERE `userid` = '{$usr->data->id}' && `activitySite` = '{$page->active}'")->getNumRows();
                            if($completed) 
                            {
                                ?><div class="completedSite"><i class="icon-shield"></i></div><?php
                            }
                            echo "</a>";
                            $video = $db->query("SELECT `id` FROM `videos` WHERE `code` = '{$page->code}'");
                            if($video->getNumRows())
                            {
                                $id = $video->getNext()->id;
                                echo "<br><a";
                                if($completed) 
                                {
                                    echo " style='position:relative; top:-120px;'";
                                }
                                echo " href='{$site['url']}video/{$id}'>Update Ref Link</a>";
                            }
                                
                            echo "</div>";
                        }
                        ?>
                        <style>.activeSite a:hover{text-decoration: none;}.activeSite a:hover img{ -moz-box-shadow: 0 0 5px #454545; -o-box-shadow: 0 0 5px #454545; -webkit-box-shadow: 0 0 5px #454545; box-shadow: 0 0 5px #454545;} .completedSite{height:125px; position:relative; width:125px; background:#59d167; top:-125px; display:inline-block;color:#fff;line-height:125px; text-align:center;font-size:50px; -moz-opacity:0.8; -o-opacity:0.8; -webkit-opacity:0.8; opacity:0.8; border-radius:3px; -moz-border-radius:3px; -o-border-radius:3px; -moz-border-radius:3px;}</style>
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br>
                        Current server time: <?=date("h:i A")?> 
                    </center>
                </p>
            </div>
        </div>
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-question-sign"></i>
                <h3>How it Works</h3>
            </div>
            <div class="widget-content">
                <style>
                .icon-angle-right{
                        color:#4A6896;   
                    }
                </style>
                <!--<p><a href="skype:?chat&blob=uyf1mCcBQr4a5qDvV1ql8H7jzxm6qBLJNxZ4Y98Nr1yxdlHfZhJtajDZlFDl_AhutMskqd8pFFZuBe6OlVSG">Join Us On <i class="icon-skype"></i> Skype</a> if you need assistance or just want to say hello :)</p>-->
                <p style="color:#4A6896;">Every day you are active you get the following benefits the next day:</p>
                <p>
                    &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Get up to 20% of your referral earnings.
                    <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Play the the branding game and become a star.
                    <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Play the stock game to keep up with the trends.
                    <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Reach level five for a chance to win a fancy $50.
                </p><br>
                <p style="color:#4A6896;">You can use your coins to:</p>
                <p>
                    &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Get exposure through the rotator, advertised by members.
                    <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Level up and to earn greater stock rewards and more daily coins.
                    <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Buy stocks in your favorite TE and sell them for profit.
                    <br> &nbsp; &nbsp; <i class="icon-angle-right"></i> &nbsp; Buy vacation days and take days off.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-signal"></i>
                <h3>Level <?=$usr->data->level?></h3>
            </div>
            <div class="widget-content">
                <?php if($usr->data->level * 2 - $usr->data->xp > 0 && $usr->data->level < 5) { ?>
                    <p>Be active for <u><b><?php echo ($usr->data->level * 2 - $usr->data->xp); ?></b></u> more day<?php if($usr->data->level * 2 - $usr->data->xp > 1) echo "s"; ?> to level up. </p>
                <?php } else if($usr->data->level * 2 - $usr->data->xp > 0 && $usr->data->level = 5) { ?>
                    <p>Be active for <u><b><?php echo ($usr->data->level * 2 - $usr->data->xp); ?></b></u> more day<?php if($usr->data->level * 2 - $usr->data->xp > 1) echo "s"; ?> for a chance to win up to $50. </p>
                <?php } else if($usr->data->coins >= pow($usr->data->level, 2) * 2 && $usr->data->level < 5) { ?>
                    <p><a href="javascript:;" id="levelup">Click here to level up for <?=pow($usr->data->level, 2) * 2?> coins.</a></p>
                    <form id="levelupform" method="post" id="levelup"><input value="1" type="hidden" name="levelup"></form>
                    <script>
                        $("#levelup").click(function()
                        {
                            $.msgbox("Are you sure you want to level up for <?=pow($usr->data->level, 2) * 2?> coins?", {
                              type: "confirm",
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
                    <p><a href="javascript:;" id="levelsfor50">Return to level one for a chance to win up to $50 ($0.50 guaranteed).</a></p>
                    <script>
                        $("#levelsfor50").click(function()
                        {
                            $.msgbox("Are you sure you want to return to level one for a chance to win up to $50 with a $0.50 guarantee win?", {
                              type: "confirm",
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
                    <p>You are eligible to level up, but you must first gain <?=pow($usr->data->level, 2) * 2?> coins.</p>
                <?php } ?>
                <p>Be active today to earn <?=$usr->data->level?> coin<?php if($usr->data->level > 1) echo "s"; ?>.</p>
                <p>Complete level 5 for a chance to win $50.</p>
                <div class="progress">
                    <div class="progress-bar progress-bar-primary" role="progressbar" style="width: <?php $percent = (1 - ($usr->data->level * 2 - $usr->data->xp) / ($usr->data->level * 2)) * 100; echo ($percent == 0) ? $percent = 1 : $percent; ?>%"></div>
                </div>
                <p style="color:#aaa; text-align:center; margin-top:-20px; font-size:11px;">You will return to level one if you are not active for a day.<br><a href="<?=$site["url"]?>vacation"><?=$usr->data->vacations?> Vacation Days</a></p>
            </div>
        </div>
        <div class="widget stacked">
            <div class="widget-content">
                <div id="big_stats" class="cf">
                    <div class="stat">								
                        <h4 style="color:#4A6896;">Coins</h4>
                        <span class="value"><?=number_format($usr->data->coins,2)?></span>								
                    </div>
                    <div class="stat">
                        <h4 style="color:#4A6896;">Cash</h4>
                        <span class="value">$<?php
                        $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'");
                        $sum = number_format($result->getNext()->sum,3);
                        echo ($sum == "") ? "0" : $sum;
                        ?>
                        </span>								
                    </div>
                </div>
            </div>
        </div>
        <div class="widget stacked">
            <div class="widget-content">
                <p><i>"Do the one thing you think you cannot do. Fail at it. Try again. Do better the second time. The only people who never tumble are those who never mount the high wire. This is your moment. Own it."</i></p>
                <p style="float:right; margin-right:20px;">-- Oprah Winfrey</p>
            </div>
        </div>

    </div>
</div>
<?php include 'footer.php'; ?>