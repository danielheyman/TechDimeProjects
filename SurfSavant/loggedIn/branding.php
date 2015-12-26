<?php include 'header.php'; ?>
<div class="row">
    <?php if($usr->data->activeBranding != '1') { ?>
    <div class="col-md-12">
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Oops!</strong> You will not appear in the branding game tomorrow. Simply select 'Yes' when you click on the activity websites in your dashboard if you are currently branding youself in the traffic exchanges.
        </div>
    </div>
    <?php
    }
    if(isset($_POST["descriptionUpdate"]))
    {
        $desc = $_POST["descriptionUpdate"];
        if (get_magic_quotes_gpc()) $desc = stripslashes($desc);
        $desc = mysql_real_escape_string($desc);
        $db->query("UPDATE `users` SET `description` = '{$desc}' WHERE `id` = '{$usr->data->id}'");
        ?>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Well done!</strong> Your profile description have been updated.
            </div>
        </div>
        <?php
        $usr->getData();
    }
    else if(isset($_POST["fbInput"]))
    {
        $input = $sec->post("fbInput");
        $db->query("UPDATE `users` SET `facebook` = '{$input}' WHERE `id` = '{$usr->data->id}'");
        ?>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Well done!</strong> Your facebook ID have been updated.
            </div>
        </div>
        <?php
        $usr->getData();
    }
    else if(isset($_POST["twInput"]))
    {
        $input = $sec->post("twInput");
        $db->query("UPDATE `users` SET `twitter` = '{$input}' WHERE `id` = '{$usr->data->id}'");
        ?>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Well done!</strong> Your twitter ID have been updated.
            </div>
        </div>
        <?php
        $usr->getData();
    }
    ?>
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-gamepad"></i>
                <h3>Who Am I?</h3>
            </div>
            <div class="widget-content">
                <script>
                $(function() { 
                    
                  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    localStorage.setItem('lastTab', $(e.target).attr('name'));
                  });
                
                  var lastTab = localStorage.getItem('lastTab');
                  if (lastTab) {
                      $('a[name="'+lastTab+'"').tab('show');
                  }
                });
                </script>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#play" data-toggle="tab" name="play">Play</a></li>
                    <li class=""><a href="#profile" data-toggle="tab" name="profile">Profile</a></li>
                    <li class=""><a href="#stats" data-toggle="tab" name="stats">Stats</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="play">
                        <?php
                        if($sec->post("id") && $usr->data->brandingWinner != 0)
                        {
                            $chosen = $sec->post("id");
                            $brandingWins = ($chosen == $usr->data->brandingWinner) ? ", `brandingMeWins` = `brandingMeWins` + 1" : "";
                            $db->query("UPDATE `users` SET `brandingMeTries` = `brandingMeTries` + 1{$brandingWins} WHERE `id` = '{$usr->data->brandingWinner}'");
                            $brandingWins = ($chosen == $usr->data->brandingWinner) ? ", `brandingWins` = `brandingWins` + 1, `coins` = `coins` + 0.5 + (0.125 * (`level` - 1))" : "";
                            $db->query("UPDATE `users` SET `brandingWinner` = 0, `brandingTries` = `brandingTries` + 1{$brandingWins} WHERE `id` = '{$usr->data->id}'");
                            
                            $user = $db->query("SELECT `twitter`, `facebook`, `email`, `fullName`, `id`,`description` FROM `users` WHERE `id` = '{$usr->data->brandingWinner}'");
                            $user = $user->getNext();
                            $email = md5(strtolower(trim($user->email)));
                            $description = ($user->description != "") ? $sec->closetags($user->description) : "The user has not filled in a description.";
                            ?>
                            <style>a:hover{text-decoration:none;}</style>
                            <div style="display:none;" id="profileDescription">
                                <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$user->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($user->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$user->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($user->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$user->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($user->twitter == "" && $user->facebook == "")) echo "<br>"; ?><hr>
                                <!--<iframe style='border:0; width:700px; height: 400px;' src="<?=$site["url"]?>profile/<?=$user->id?>"></iframe>-->
                                <?=$description?>
                            </div>
                            <?php
                            if($chosen == $usr->data->brandingWinner)
                            {
                                ?>
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>Well done!</strong> You chose the correct option. Learn more about <a href="#profileDescription" class="lightbox"><?=$user->fullName?></a>.
                                    </div>
                                </div>
                                <?php
                            }
                            else
                            {
                                ?>
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <strong>Oops!</strong> You chose the incorrect option. Learn more about <a href="#profileDescription" class="lightbox"><?=$user->fullName?></a>.
                                    </div>
                                </div>
                                <?php
                            }
                            
                            $usr->getData();
                        }
                        if($usr->data->active)
                        {
                            if($usr->data->brandingTries < 15)
                            {
                                echo "<center>";
                                $type = rand(1,3);
                                switch($type)
                                {
                                    case 1:
                                        $users = $db->query("SELECT `id`, `fullName`, `email` FROM `users` WHERE `id` != '{$usr->data->id}' && `activeBrandingYesterday` = 1 ORDER BY RAND() LIMIT 4");
                                        $winner = rand(1,4);
                                        $one = $users->getNext();
                                        $two = $users->getNext();
                                        $three = $users->getNext();
                                        $four = $users->getNext();
                                        if($winner == 1) { $name = $one->fullName; $id = $one->id; }
                                        else if($winner == 2) { $name = $two->fullName; $id = $two->id; }
                                        else if($winner == 3) { $name = $three->fullName; $id = $three->id; }
                                        else if($winner == 4) { $name = $four->fullName; $id = $four->id; }
                                        echo "<center>Who is {$name}?</center><br><br>";
                                        $email = md5(strtolower(trim($one->email)));
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$one->id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'></a></form></center><br></div>";
                                        $email = md5(strtolower(trim($two->email)));
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$two->id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'></a></form></center><br></div>";
                                        $email = md5(strtolower(trim($three->email)));
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$three->id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'></a></form></center><br></div>";
                                        $email = md5(strtolower(trim($four->email)));
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$four->id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'></a></form></center><br></div>";
                                        break;
                                    case 2:
                                        $users = $db->query("SELECT `id`, `fullName`, `email` FROM `users` WHERE `id` != '{$usr->data->id}' && `activeBrandingYesterday` = 1 ORDER BY RAND() LIMIT 4");
                                        $winner = rand(1,4);
                                        $one = $users->getNext();
                                        $two = $users->getNext();
                                        $three = $users->getNext();
                                        $four = $users->getNext();
                                        if($winner == 1) { $email = md5(strtolower(trim($one->email))); $id = $one->id; }
                                        else if($winner == 2) { $email = md5(strtolower(trim($two->email))); $id = $two->id; }
                                        else if($winner == 3) { $email = md5(strtolower(trim($three->email))); $id = $three->id; }
                                        else if($winner == 4) { $email = md5(strtolower(trim($four->email))); $id = $four->id; }
                                        echo "<center><img src='http://www.gravatar.com/avatar/{$email}?s=125'><br>What is this surfer's name?</center><br><br>";
                                        $fullName = $one->fullName;
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$one->id}'><a href='javascript:;' onclick='parentNode.submit();'>{$fullName}</a></form></center><br></div>";
                                        $fullName = $two->fullName;
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$two->id}'><a href='javascript:;' onclick='parentNode.submit();'>{$fullName}</a></form></center><br></div>";
                                        $fullName = $three->fullName;
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$three->id}'><a href='javascript:;' onclick='parentNode.submit();'>{$fullName}</a></form></center><br></div>";
                                        $fullName = $four->fullName;
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$four->id}'><a href='javascript:;' onclick='parentNode.submit();'>{$fullName}</a></form></center><br></div>";
                                        break;
                                    case 3:
                                        $users = $db->query("SELECT `id`, `fullName`, `email` FROM `users` WHERE `id` != '{$usr->data->id}' && `activeBrandingYesterday` = 1 ORDER BY RAND() LIMIT 8");
                                        $winner = rand(1,4);
                                        $one = $users->getNext();
                                        $two = $users->getNext();
                                        $three = $users->getNext();
                                        $four = $users->getNext();
                                        $five = $users->getNext();
                                        $six = $users->getNext();
                                        $seven = $users->getNext();
                                        $eight = $users->getNext();
                                        if($winner == 1) { $id = $one->id; }
                                        else if($winner == 2) { $id = $two->id; }
                                        else if($winner == 3) { $id = $three->id; }
                                        else if($winner == 4) { $id = $four->id; }
                                        echo "<center>What is the correct group?</center><br><br>";
                                        $email = md5(strtolower(trim($one->email)));
                                        $fullName = ($winner == 1) ? $one->fullName : $five->fullName;
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$one->id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'><br>{$fullName}</a></form></center><br></div>";
                                        $email = md5(strtolower(trim($two->email)));
                                        $fullName = ($winner == 2) ? $two->fullName : $six->fullName;
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$two->id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'><br>{$fullName}</a></form></center><br></div>";
                                        $email = md5(strtolower(trim($three->email)));
                                        $fullName = ($winner == 3) ? $three->fullName : $seven->fullName;
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$three->id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'><br>{$fullName}</a></form></center><br></div>";
                                        $email = md5(strtolower(trim($four->email)));
                                        $fullName = ($winner == 4) ? $four->fullName : $eight->fullName;
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form method='post'><input type='hidden' name='id' value='{$four->id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'><br>{$fullName}</a></form></center><br></div>";
                                        break;
                                }
                                $db->query("UPDATE `users` SET `brandingWinner` = '{$id}' WHERE `id` = '{$usr->data->id}'");
                                echo "</center><style>.col-md-3 form:hover img{ -moz-box-shadow: 0 0 5px #454545; -o-box-shadow: 0 0 5px #454545; -webkit-box-shadow: 0 0 5px #454545; box-shadow: 0 0 5px #454545; }</style>";
                            }
                            else 
                            {
                                if($usr->data->brandingWins >= 5) echo "<center>Wooh, you won! <a href='{$site['url']}card'>Continue</a> for a chance to win some cash!</center>";
                                else echo "<center>You have reached the maximum of 15 plays.</center>";
                            }
                        }
                        else echo "You cannot play the branding game today since you were not active yesterday.";
                        ?>
                    </div>
                    <div class="tab-pane fade" id="profile">
                        This is your profile description. Others will be able to see this when playing the branding game.<br><br>
                        <center>
                            <form style="width:500px;" class="input-group" method="post">
                                <span class="input-group-addon">http://facebook.com/</span>
                                <input name="fbInput" value="<?=$usr->data->facebook?>" placeholder="Your Facebook ID" type="text" class="form-control">
                                <span class="input-group-btn">
                                    <input class="btn btn-primary" type="submit" value="Go!">
                                </span>
                            </form>
                            <br>
                            <form style="width:500px;" class="input-group" method="post">
                                <span class="input-group-addon">http://twitter.com/</span>
                                <input name="twInput" value="<?=$usr->data->twitter?>" placeholder="Your Twitter ID" type="text" class="form-control">
                                <span class="input-group-btn">
                                    <input class="btn btn-primary" type="submit" value="Go!">
                                </span>
                            </form>
                        </center>
                        <form method="post">
                            <textarea name="descriptionUpdate"><?=$usr->data->description?></textarea>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                        <script>$("textarea").jqte();</script>
                        
                    </div>
                    <div class="tab-pane fade" id="stats">
                        <center><strong>Your Branding Game Stats: The percentage of people who correctly identified you.</strong></center>
                        <br>
						<div class="cirque-stats">
					        <div class='col-md-6'><center>Today:<br><div class="ui-cirque" data-value="<?php echo $usr->data->brandingMeWins / $usr->data->brandingMeTries * 100; ?>" data-arc-color="#FF9900"></div></center></div>
					        <div class='col-md-6'><center>Yesterday:<br><div class="ui-cirque" data-value="<?php echo $usr->data->brandingMeRatio2; ?>" data-arc-color="#FF9900"></div></center></div>
					    </div>
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        <br><br>
                        <center><strong><a href='<?=$site["url"]?>tools'>Your Branding Splash Page</a> Stats: The percentage of people who correctly identified you in your <a href='<?=$site["url"]?>tools'>splash page</a>.</strong></center>
                        <br>
                        <table class="table table-bordered table-hover table-striped">
                            <thead><tr><th>Site</th><th>Today</th><th>Yesterday</th><th>Week</th></tr></thead>
                            <?php
                            $statsArray = [];
                            $stats = $db->query("SELECT `site`, `correct`, `views`, ROUND((`correct` / `views` * 100),2) AS `percent` FROM `brandingHits` WHERE `userid` = '{$usr->data->id}' && DATE(`timestamp`) = DATE(NOW())");
                            while($stat = $stats->getNext())
                            {
                                $statsArray[$stat->site] = [$stat->percent . "%" . " [ " . $stat->correct . " / " . $stat->views . " ] ", "N/A", "N/A"];
                            }
                            $stats = $db->query("SELECT `site`, `correct`, `views`, ROUND((`correct` / `views` * 100),2) AS `percent` FROM `brandingHits` WHERE `userid` = '{$usr->data->id}' && DATE(`timestamp`) = DATE(NOW() - INTERVAL 1 DAY)");
                            while($stat = $stats->getNext())
                            {
                                if(isset($statsArray[$stat->site])) $statsArray[$stat->site] = [$statsArray[$stat->site][0], $stat->percent . "%" . " [ " . $stat->correct . " / " . $stat->views . " ] ", "N/A"];
                                else $statsArray[$stat->site] = ["N/A", $stat->percent . "%" . " [ " . $stat->correct . " / " . $stat->views . " ] ", "N/A"];
                            }
                            $stats = $db->query("SELECT `site`, `correct`, `views`, ROUND((SUM(`correct`) / SUM(`views`) * 100),2) AS `percent` FROM `brandingHits` WHERE `userid` = '{$usr->data->id}' GROUP BY `site`");
                            while($stat = $stats->getNext())
                            {
                                if(isset($statsArray[$stat->site])) $statsArray[$stat->site] = [$statsArray[$stat->site][0], $statsArray[$stat->site][1], $stat->percent . "%" . " [ " . $stat->correct . " / " . $stat->views . " ] "];
                                else $statsArray[$stat->site] = ["N/A", "N/A", $stat->percent . "%" . " [ " . $stat->correct . " / " . $stat->views . " ] "];
                            }
                            asort($statsArray);
                            foreach($statsArray as $key => $val)
                            {
                                echo "<tr><td>{$key}</td><td>{$val[0]}</td><td>{$val[1]}</td><td>{$val[2]}</td></tr>";   
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <h4>How it works</h4>
            <p>Answer the question correctly to gain up to 1 coin, depending on your level. The game continues for 15 rounds. If you answer five correctly, you will have a chance to win some cash!</p>
        </div>				
    </div>
</div>
<?php include 'footer.php'; ?>