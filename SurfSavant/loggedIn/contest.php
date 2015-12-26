<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-trophy"></i>
                <h3>The Big Monthly Contest</h3>
            </div>
            <div class="widget-content">
                <center>
                    <?php if(date('m') == "04") { ?>
                    <div style="font-weight:bold; color:#F90;">You have earned <?=$db->query("SELECT COUNT(`id`) AS `count` FROM `contestShields` WHERE MONTH(NOW()) = MONTH(`timestamp`) && `userid` = '{$usr->data->id}'")->getNext()->count?> shields!</div>
                    <br><br>
                    <style>
                    .box
                    {
                        width:28%;
                        display:inline-block;
                        margin:10px;
                        height:300px;
                    }
                        
                    .box .shield{
                        width:100%;
                        height:100px;
                        background:url(<?=$site['url']?>loggedIn/images/shieldBanner.png);
                        background-repeat:no-repeat;
                        background-size:100px;
                        background-position:center;
                        padding-top:26px;
                        width:120px;
                        padding-left:10px;
                        color:#ebebeb;
                        margin-bottom:10px;
                    }
                        
                    .box .text{
                        margin-top:10px;
                        padding:10px;
                        text-align:left;
                        border:1px solid #d3d3d3;
                        border-radius:3px;
                        -moz-border-radius:3px;
                        -o-border-radius:3px;
                        -webkit-border-radius:3px;
                        line-height:20px;
                        height:142px;
                        overflow:auto;
                    }
                        
                    .box .count{
                        font-weight:bold; 
                        color:#F90;   
                    }
                    </style>
                    
                    <div class="box">
                        <div class="shield">Referral</div>
                        <div class="count">You have <?=$db->query("SELECT COUNT(`id`) AS `count` FROM `contestShields` WHERE MONTH(NOW()) = MONTH(`timestamp`) && `userid` = '{$usr->data->id}' && `type` = 'referral'")->getNext()->count?></div>
                        <div class="text">Get a referral shield when you refer a member who fuels their account 3 times within a week of registering.</div>
                    </div>
                    <div class="box">
                        <div class="shield">Salesman</div>
                        <div class="count">You have <?=$db->query("SELECT COUNT(`id`) AS `count` FROM `contestShields` WHERE MONTH(NOW()) = MONTH(`timestamp`) && `userid` = '{$usr->data->id}' && `type` = 'salesman'")->getNext()->count?></div>
                        <div class="text">Get a salesman shield for every five dollars your referrals spend on upgrades and coins.</div>
                    </div>
                    <div class="box">
                        <div class="shield">Branding</div>
                        <div class="count">You have <?=$db->query("SELECT COUNT(`id`) AS `count` FROM `contestShields` WHERE MONTH(NOW()) = MONTH(`timestamp`) && `userid` = '{$usr->data->id}' && `type` = 'branding'")->getNext()->count?></div>
                        <div class="text">Get this shield every day you play the branding game and be a part of the users who appear in the game. You cannot have the default <a target="_blank" href="<?=$site['url']?>settings">gravatar</a>.</div>
                    </div>
                    <div class="box">
                        <div class="shield">Activity</div>
                        <div class="count">You have <?=$db->query("SELECT COUNT(`id`) AS `count` FROM `contestShields` WHERE MONTH(NOW()) = MONTH(`timestamp`) && `userid` = '{$usr->data->id}' && `type` = 'activity'")->getNext()->count?></div>
                        <div class="text">Get an activity shield every time you fuel your account for three consecutive days.</div>
                    </div>
                    <div class="box">
                        <div class="shield">Stock</div>
                        <div class="count">You have <?=$db->query("SELECT COUNT(`id`) AS `count` FROM `contestShields` WHERE MONTH(NOW()) = MONTH(`timestamp`) && `userid` = '{$usr->data->id}' && `type` = 'stock'")->getNext()->count?></div>
                        <div class="text">Get a stock shield every Sunday night when you have made at least three trades during the week.</div>
                    </div>
                    <?php } else echo "<b>The Big Monthly Contest has ended, but stay tuned for some awesome stuff coming soon :)</b><br><br>"; ?>
                    <br><br>
                    
                    <?php if(false) { ?>
                    <ul class="nav nav-tabs">
                        <?php if(date('m') == "04") { ?>
                        <li class="active"><a href="#prizes" data-toggle="tab" name="prizes">Prizes</a></li>
                        <?php } ?>
                        <li class="<?php if(date('m') != "04") echo "active"; ?>"><a href="#previous" data-toggle="tab" name="previous">Previous Winners</a></li>
                        <?php if(date('m') == "04") { ?>
                        <li class=""><a href="#referral" data-toggle="tab" name="referral">Referral</a></li>
                        <li class=""><a href="#salesman" data-toggle="tab" name="salesman">Salesman</a></li>
                        <li class=""><a href="#branding" data-toggle="tab" name="branding">Branding</a></li>
                        <li class=""><a href="#activity" data-toggle="tab" name="activity">Activity</a></li>
                        <li class=""><a href="#stock" data-toggle="tab" name="stock">Stock</a></li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content">
                        <?php if(date('m') == "04") { ?>
                        <div class="tab-pane fade active in" id="prizes">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Name</th>
                                        <th>Shields</th>
                                        <th>Prize</th>
                                    </tr>
                                </thead>
                                <?php
                                $users = $db->query("SELECT COUNT(`contestShields`.`id`) AS `count`, `description`, `email`, `facebook`, `twitter`, `fullName` FROM `contestShields` LEFT JOIN `users` ON `users`.`id` = `userid` WHERE MONTH(NOW()) = MONTH(`timestamp`) && `userid` > 3 GROUP BY `userid` ORDER BY COUNT(`userid`) DESC, DATE(MAX(`timestamp`)) ASC, COUNT(CASE WHEN `type` = 'referral' THEN 1 ELSE 0 END) DESC LIMIT 20");
                                if($users->getNumRows())
                                {
                                    $count = 1;
                                    while($user = $users->getNext())
                                    {
                                        $email = md5(strtolower(trim($user->email)));
                                        $description = ($user->description != "") ? $sec->closetags($user->description) : "The user has not filled in a description.";
                                        ?>
                                        <style>a:hover{text-decoration:none;}</style>
                                        <div style="display:none;" id="profileDescription<?=$count?>">
                                            <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$user->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($user->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$user->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($user->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$user->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($user->twitter == "" && $user->facebook == "")) echo "<br>"; ?><hr>
                                            <?=$description?>
                                        </div>
                                        <?php
                                        if($count == 1) $prize = "60";
                                        else if($count == 2) $prize = "30";
                                        else if($count == 3) $prize = "20";
                                        else if($count == 4) $prize = "10";
                                        else if($count == 5 || $count == 6) $prize = "5";
                                        else if($count == 7 || $count == 8) $prize = "3";
                                        else if($count == 9 && $count == 10) $prize = "2";
                                        else if($count >= 11 && $count <= 20) $prize = "1";
                                        echo "<tr><td>#{$count}</td><td><a class='lightbox' href='#profileDescription{$count}'>{$user->fullName}</a></td><td>{$user->count}</td><td>$" . $prize . "</td></tr>";
                                        $count++;
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <?php } ?>
                        <div class="tab-pane fade <?php if(date('m') != "04") echo "active in"; ?>" id="previous">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Position</th>
                                        <th>Name</th>
                                        <th>Shields</th>
                                        <th>Prize</th>
                                    </tr>
                                </thead>
                                <?php
                                $users = $db->query("SELECT COUNT(`contestShields`.`id`) AS `count`, `description`, `email`, `facebook`, `twitter`, `fullName` FROM `contestShields` LEFT JOIN `users` ON `users`.`id` = `userid` WHERE MONTH(NOW() - INTERVAL 1 MONTH) = MONTH(`timestamp`) && `userid` > 3 GROUP BY `userid` ORDER BY COUNT(`userid`) DESC, DATE(MAX(`timestamp`)) ASC, COUNT(CASE WHEN `type` = 'referral' THEN 1 ELSE 0 END) DESC LIMIT 20");
                                if($users->getNumRows())
                                {
                                    $count = 1;
                                    while($user = $users->getNext())
                                    {
                                        $email = md5(strtolower(trim($user->email)));
                                        $description = ($user->description != "") ? $sec->closetags($user->description) : "The user has not filled in a description.";
                                        ?>
                                        <style>a:hover{text-decoration:none;}</style>
                                        <div style="display:none;" id="secondProfileDescription<?=$count?>">
                                            <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$user->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($user->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$user->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($user->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$user->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($user->twitter == "" && $user->facebook == "")) echo "<br>"; ?><hr>
                                            <?=$description?>
                                        </div>
                                        <?php
                                        if($count == 1) $prize = "60";
                                        else if($count == 2) $prize = "30";
                                        else if($count == 3) $prize = "20";
                                        else if($count == 4) $prize = "10";
                                        else if($count == 5 || $count == 6) $prize = "5";
                                        else if($count == 7 || $count == 8) $prize = "3";
                                        else if($count == 9 && $count == 10) $prize = "2";
                                        else if($count >= 11 && $count <= 20) $prize = "1";
                                        echo "<tr><td>#{$count}</td><td><a class='lightbox' href='#secondProfileDescription{$count}'>{$user->fullName}</a></td><td>{$user->count}</td><td>$" . $prize . "</td></tr>";
                                        $count++;
                                    }
                                }
                                ?>
                            </table>
                        </div>
                        <?php 
                        if(date('m') == "04") {
                        for($x = 0; $x < 5; $x++) {
                            if($x == 0) $type = 'referral'; 
                            if($x == 1) $type = 'salesman'; 
                            if($x == 2) $type = 'branding'; 
                            if($x == 3) $type = 'activity'; 
                            if($x == 4) $type = 'stock';
                            ?>
                            <div class="tab-pane fade" id="<?=$type?>">
                                <b>This is a list of the top <?=$type?> shield earners:</b><br><br>
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Position</th>
                                            <th>Name</th>
                                            <th>Shields</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $users = $db->query("SELECT COUNT(`contestShields`.`id`) AS `count`, `description`, `email`, `facebook`, `twitter`, `fullName` FROM `contestShields` LEFT JOIN `users` ON `users`.`id` = `userid` WHERE MONTH(NOW()) = MONTH(`timestamp`) && `userid` > 3 && `type` = '{$type}' GROUP BY `userid` ORDER BY COUNT(`userid`) DESC LIMIT 20");
                                    if($users->getNumRows())
                                    {
                                        $count = 1;
                                        while($user = $users->getNext())
                                        {
                                            $email = md5(strtolower(trim($user->email)));
                                            $description = ($user->description != "") ? $sec->closetags($user->description) : "The user has not filled in a description.";
                                            ?>
                                            <style>a:hover{text-decoration:none;}</style>
                                            <div style="display:none;" id="<?=$type?>ProfileDescription<?=$count?>">
                                                <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$user->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($user->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$user->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($user->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$user->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($user->twitter == "" && $user->facebook == "")) echo "<br>"; ?><hr>
                                                <?=$description?>
                                            </div>
                                            <?php
                                            echo "<tr><td>#{$count}</td><td><a class='lightbox' href='#{$type}ProfileDescription{$count}'>{$user->fullName}</a></td><td>{$user->count}</td></tr>";
                                            $count++;
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        <?php } } ?>
                        <div class="tab-pane fade" id="promotion">
                        
                        </div>
                    </div>
                    <?php } ?>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-4">	
        <div class="well">
            <h4>Promotion tools</h4>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#splash" data-toggle="tab" name="splash">Splashes</a></li>
                <li class=""><a href="#banner" data-toggle="tab" name="banner">Banners</a></li>
                <style>.well .nav-tabs > li > a, .well .nav-pills > li > a{ padding: 7px 4px; }</style>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="splash">
                    Splash Page<br>
                    <input value="<?=$site['url']?>scontest/<?=$usr->data->id?>" class="form-control"><br>
                    Personal Splash Page<br>
                    <input value="<?=$site['url']?>pscontest/<?=$usr->data->id?>" class="form-control">
                </div>
                <div class="tab-pane fade" id="banner">
                    468x60 Banner<br>
                    <input value="<?=$site['url']?>contest2.png" class="form-control"><br>
                    125x125 Banner<br>
                    <input value="<?=$site['url']?>contest3.png" class="form-control"><br>
                    250x250 Banner<br>
                    <input value="<?=$site['url']?>contest.png" class="form-control">
                </div>
            </div>
            
        </div>	
        <div class="well">
            <h4>How to win</h4>
            <p>
                It is as simple as finding more shields than anyone else. The contest ends on the last day of every month. There are a total of $150 in prizes given out to 20 lucky members. They are added to your cash balance seven days after the end of every contest due to the need to process any referrals that are still becoming active. All winnings will be paid out with commission earnings.
            </p>
        </div>	
        <div class="well">
            <h4>No cheating</h4>
            <p>
                Anyone caught cheating of course will be disqualified. Cheating icludes the use of proxies, bots, getting friends to sign up multiple times and of course buying signups. If it is not listed here that does not mean its not cheating. Any attempts to artificially inflate signups or claiming of sheilds whatsoever will result in disqualification.
            </p>
        </div>
        <div class="well">
            <h4>Monthly qualification</h4>
            <p>
                 Rules and qualification are subject to change month to month and shields may be traded out for new shields. Be sure to refer to these rules at the beginning of a new contest. But no worries, rules will not change during an active contest.
            </p>
        </div>		
    </div>
</div>
<?php include 'footer.php'; ?>