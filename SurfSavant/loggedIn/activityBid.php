<?php include 'header.php'; ?>
<div class="row">

    <?php
        $form = false;
        if($sec->post("newSiteInput"))
        {
            $form = true;
            $siteurl = str_replace("&amp;", "&", $sec->post("newSiteInput"));
            if((substr($siteurl, 0, 7) !== 'http://') && (substr($siteurl, 0, 8) !== 'https://')) $siteurl = 'http://' . $siteurl;
            
            if(!$sec->isURL($siteurl))
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> The URL is invalid.
                    </div>
                </div>
                <?php
            }
            else
            {
                $formatURL = $sec->formatURL($siteurl);
                $code = $sec->randomCode();
                $check = $db->query("SELECT `code`, `url` FROM `stockSites` WHERE `url` LIKE '%{$formatURL}%'");
                if($check->getNumRows())
                {
                    $check = $check->getNext();
                    if($sec->formatURL($check->url) == $formatURL) $code = $check->code;
                }
                else
                {
                    $check = $db->query("SELECT `code`, `url` FROM `activitySites` WHERE `url` LIKE '%{$formatURL}%'");
                    if($check->getNumRows())
                    {
                        $check = $check->getNext();
                        if($sec->formatURL($check->url) == $formatURL) $code = $check->code;
                    }
                }
                $db->query("INSERT INTO `activitySites` (`userid`, `code`, `url`) VALUES ('{$usr->data->id}', '{$code}', '{$siteurl}')");
                ?>
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Well done!</strong> The website have been added. You may now activate it.
                    </div>
                </div>
                <?php
            }
        }
        else if($sec->post("removeSite"))
        {
            $form = true;
            $value = $sec->post("removeSite");
            $db->query("DELETE FROM `activitySites` WHERE `id` = '{$value}' && `userid` = '{$usr->data->id}'");
            ?>
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Well done!</strong> Your website has been removed.
                </div>
            </div>
            <?php
        }
        else if($sec->post("editBanner"))
        {
            $form = true;
            $value = $sec->post("value");
            $id = $sec->post("editBanner");
            
            $siteurl = str_replace("&amp;", "&", $value);
            if((substr($siteurl, 0, 7) !== 'http://') && (substr($siteurl, 0, 8) !== 'https://')) $siteurl = 'http://' . $siteurl;
            
            if($value != "" && !$sec->isURL($siteurl))
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> The URL is invalid.
                    </div>
                </div>
                <?php
            }
            else
            {
                $db->query("UPDATE `activitySites` SET `banner` = '{$siteurl}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                ?>
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Well done!</strong> The banner URL has been updated.
                    </div>
                </div>
                <?php
            }
        }
        else if($sec->post("editName"))
        {
            $form = true;
            $value = $sec->post("value");
            $id = $sec->post("editName");
            
            $db->query("UPDATE `activitySites` SET `name` = '{$value}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
            ?>
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Well done!</strong> The name has been updated.
                </div>
            </div>
            <?php
        }
        else if($sec->post("bidDay"))
        {
            $day = $sec->post("bidDay");
            $amount = floor($sec->post("bidAmount") * 100) / 100;
            $website = $sec->post("bidWebsite");
            if($day >= date('j') + 2 || $day <= date('j') + 7)
            {
                $query = $db->query("SELECT `bid`, `reserved` FROM `activityBids` WHERE `day` = '{$day}' ORDER BY `bid` DESC LIMIT 1");
                $bid = 5;
                $reserved = 0;
                if($query->getNumRows())
                {
                    $query = $query->getNext();
                    $bid = floor($query->bid * 100 + 25) / 100;
                    $reserved = $query->reserved;
                }
                if($amount < $bid)
                {
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Oops!</strong> Your bid does not meet the minimum bid amount.
                        </div>
                    </div>
                    <?php  
                }
                else if($reserved == 1)
                {
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Oops!</strong> The bid day has already been reserved.
                        </div>
                    </div>
                    <?php  
                }
                else if($amount > $usr->data->piggybank)
                {
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Oops!</strong> Your bid exceeds the amount you have in your Piggy Bank.
                        </div>
                    </div>
                    <?php   
                }
                else if($usr->data->id == 2148)
                {
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Oops!</strong> You have been suspended from making any bids. This is a feature that is only for traffic exchange owners.
                        </div>
                    </div>
                    <?php  
                }
                else
                { 
                    $query = $db->query("SELECT `id` FROM `activitySites` WHERE `userid` = '{$usr->data->id}' && `name` != '' && `banner` != '' && `lastHit` > NOW() - INTERVAL 1 HOUR && `id` = '{$website}'");
                    if($query->getNumRows())
                    {
                        $db->query("UPDATE `users` SET `piggybank` = `piggybank` + (SELECT `bid` FROM `activityBids` WHERE `day` = '{$day}'  && `userid` = `users`.`id` ORDER BY `bid` DESC LIMIT 1) WHERE EXISTS (SELECT `bid` FROM `activityBids` WHERE `day` = '{$day}'  && `userid` = `users`.`id` ORDER BY `bid` DESC LIMIT 1)");
                        $db->query("UPDATE `activityBids` SET `bid` = 0 WHERE `day` = '{$day}'");
                        $db->query("INSERT INTO `activityBids` (`userid`, `activityid`, `bid`, `day`) VALUES ('{$usr->data->id}', '{$website}', '{$amount}', '{$day}')");
                        $db->query("UPDATE `users` SET `piggybank` = `piggybank` - {$amount} WHERE `id` = '{$usr->data->id}'");
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Well done!</strong> Your bid has been placed.
                            </div>
                        </div>
                        <?php
                        $usr->getData();
                    }
                    else
                    {
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Oops!</strong> You have selected a website that is not active.
                            </div>
                        </div>
                        <?php 
                    }
                }
            }
            else
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> Day is no longer available for bidding.
                    </div>
                </div>
                <?php  
            }
        }
        
    ?>
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-clock"></i>
                <h3>Activity Bids</h3>
            </div>
            <div class="widget-content">
                <script>
                $(function() { 
                    
                  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    localStorage.setItem('lastTab', $(e.target).attr('class'));
                  });
                
                  var lastTab = localStorage.getItem('lastTab');
                  if (lastTab) {
                      $('.'+lastTab).tab('show');
                  }
                });
                </script>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#bid" class="bid" data-toggle="tab">Bid</a></li>
                    <li class=""><a href="#te" class="te" data-toggle="tab">Traffic Exchanges</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="bid">
                        <style>
                            .bidblock{
                                display:inline-block;
                                border:1px solid #D5D5D5;
                                border-radius:5px;
                                -moz-border-radius:5px;
                                -o-border-radius:5px;
                                -webkit-border-radius:5px;
                                text-align:left;
                                margin-right:2%;
                                margin-left:2%;
                                margin-bottom:20px;
                                width:43%;
                                overflow:hidden;
                                box-sizing:border-box;
                                -moz-box-sizing:border-box;
                                -webkit-box-sizing:border-box;
                            }
                            
                            .bidblock img{
                                border-top-left-radius:5px; 
                                border-bottom-left-radius:5px;   
                                -webkit-border-top-left-radius:5px; 
                                -webkit-border-bottom-left-radius:5px;   
                                -o-border-top-left-radius:5px; 
                                -o-border-bottom-left-radius:5px;   
                                -moz-border-top-left-radius:5px; 
                                -moz-border-bottom-left-radius:5px;   
                                position:absolute;
                                height:100px;
                                width:100px;
                                border:0;
                            }
                            
                            .bidblock .inner{
                                display:block;
                                width:400px;
                                box-sizing:border-box;
                                -moz-box-sizing:border-box;
                                -webkit-box-sizing:border-box;
                                padding-top:5px;
                                padding-right:20px;
                                padding-left:120px;
                                height:100px;
                                line-height:23px;
                            }
                            
                            .bidblock .yellow{
                                display:inline-block;
                                color:#F90;
                                line-height:30px;
                                font-size:20px;
                                padding-bottom:5px;
                                margin-bottom:5px;
                                border-bottom:1px solid #D5D5D5;
                                min-width:300px;
                            }
                        </style>
                        <center>
                            <?php
                            $result = $db->query("SELECT `activitySites`.`id`, `url`, `refurl`, `countdown`, `banner`, `description`, `email`, `facebook`, `twitter`, `fullName` FROM `activitySites` LEFT JOIN `users` ON `users`.`id` = `activitySites`.`userid` WHERE `activitySites`.`active` != 0 && `activitySites`.`id` > 3");

                            $result2 = $db->query("SELECT `activitySites`.`id`, `url`, `refurl`, `countdown`, `banner`, `description`, `email`, `facebook`, `twitter`, `fullName` FROM `activitySites` LEFT JOIN `users` ON `users`.`id` = `activitySites`.`userid` WHERE `countdown` = 1 && `activitySites`.`id` > 3");

                            $upcoming = ($result->getNumRows() || $result2->getNumRows());

                            if($upcoming) echo "<b>Upcoming Winners:</b><br><hr>";

                            if($result->getNumRows())
                            {
                                $box = $result->getNext();
                                $box->countdown = 0;
                                
                                $formatURL = $sec->formatURL($box->url);
                        
                                $video = $db->query("SELECT `downlineLink`, `techdimeRef`, `mattRef`, (SELECT `ref` FROM `videoRefs` WHERE `videoRefs`.`videoid` = `videos`.`id` && `videoRefs`.`userid` = '{$usr->data->ref}') AS `ref` FROM `videos` WHERE `downlineLink` like '%{$formatURL}%'");
                                
                                if($video->getNumRows())
                                {
                                    $video = $video->getNext();
                                    $ref = $video->ref;
                                    if($ref == "")
                                    {
                                        $ref = (rand(0,1) == 0) ? $video->mattRef : $video->techdimeRef;
                                    }
                                    $url = $video->downlineLink . $ref;
                                }
                                else if($box->refurl != "") $url = $box->refurl;  
                                else $url = $box->url;
                                
                                    
                                $email = md5(strtolower(trim($box->email)));
                                $description = ($box->description != "") ? $sec->closetags($box->description) : "The user has not filled in a description.";
                                
                                if($box->countdown == '0') $currentday = "Running Today";
                                else
                                {
                                    $datetime = new DateTime("{$box->countdown} day"); 
                                    $currentday = $datetime->format('D, M j');  
                                }
                                
                                
                                $daycheck = date('Y-m-d');
                                $bidwin = $db->query("SELECT `bid` FROM `activityBids` WHERE `day` = '{$daycheck}' ORDER BY `bid` DESC LIMIT 1")->getNext()->bid;
                                
                                ?>
                                <div style="display:none;" id="profileDescriptionWon<?=$box->id?>">
                                    <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$box->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($box->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$box->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($box->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$box->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($box->twitter == "" && $box->facebook == "")) echo "<br>"; ?><hr>
                                    <?=$description?>
                                </div>
                        
                                <div class="bidblock">
                                    <a href="<?=$url?>" target="_blank"><img src="<?=$box->banner?>" height="100" width="100"></a>
                                    <div class="inner">
                                        <div class="yellow"><?=$currentday?></div>
                                        <br>
                                        Winning Bid: $<?=$bidwin?>
                                        <br>
                                        <a class='lightbox' href='#profileDescriptionWon<?=$box->id?>'><?=$box->fullName?></a>
                                    </div>
                                </div>
                                <?php
                            }

                            if($result2->getNumRows())
                            {
                                $box = $result2->getNext();
                                $formatURL = $sec->formatURL($box->url);
                        
                                $video = $db->query("SELECT `downlineLink`, `techdimeRef`, `mattRef`, (SELECT `ref` FROM `videoRefs` WHERE `videoRefs`.`videoid` = `videos`.`id` && `videoRefs`.`userid` = '{$usr->data->ref}') AS `ref` FROM `videos` WHERE `downlineLink` like '%{$formatURL}%'");
                                
                                if($video->getNumRows())
                                {
                                    $video = $video->getNext();
                                    $ref = $video->ref;
                                    if($ref == "")
                                    {
                                        $ref = (rand(0,1) == 0) ? $video->mattRef : $video->techdimeRef;
                                    }
                                    $url = $video->downlineLink . $ref;
                                }
                                else if($box->refurl != "") $url = $box->refurl;  
                                else $url = $box->url;
                                
                                    
                                $email = md5(strtolower(trim($box->email)));
                                $description = ($box->description != "") ? $sec->closetags($box->description) : "The user has not filled in a description.";
                                
                                if($box->countdown == '0') $currentday = "Running Today";
                                else
                                {
                                    $datetime = new DateTime("{$box->countdown} day"); 
                                    $currentday = $datetime->format('D, M j');  
                                }
                                
                                
                                $daycheck = date('Y-m-d', strtotime("+1 days"));;
                                $bidwin = $db->query("SELECT `bid` FROM `activityBids` WHERE `day` = '{$daycheck}' ORDER BY `bid` DESC LIMIT 1")->getNext()->bid;
                                ?>
                                <div style="display:none;" id="profileDescriptionWon<?=$box->id?>">
                                    <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$box->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($box->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$box->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($box->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$box->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($box->twitter == "" && $box->facebook == "")) echo "<br>"; ?><hr>
                                    <?=$description?>
                                </div>
                        
                                <div class="bidblock">
                                    <a href="<?=$url?>" target="_blank"><img src="<?=$box->banner?>" height="100" width="100"></a>
                                    <div class="inner">
                                        <div class="yellow"><?=$currentday?></div>
                                        <br>
                                        Winning Bid: $<?=$bidwin?>
                                        <br>
                                        <a class='lightbox' href='#profileDescriptionWon<?=$box->id?>'><?=$box->fullName?></a>
                                    </div>
                                </div>
                                <?php
                            }
                            if($upcoming) echo "<br><br><br>";

                                
                            $time = date('h:i A');
                            echo "<b>Start Bidding ( The time is {$time} )</b><br><hr>";
                            for($x = 2; $x <= 7; $x++)
                            {
                                $datetime = new DateTime("{$x} day");
                                $currentday = $datetime->format('D, M j'); 
                                $day = date('Y-m-d', strtotime("+" . $x . " days"));
                                $banner = "<img src='{$site['url']}banner2.png' height='100' width='100'>";
                                $bid = "Starting Bid: $5.00";
                                $bidAmount = 5;
                                $reserved = 0;
                                
                                $result = $db->query("SELECT `reserved`, `activityid` AS `id`, `bid`, `url`, `refurl`, `banner`, `description`, `email`, `facebook`, `twitter`, `fullName` FROM `activityBids` LEFT JOIN `users` ON `users`.`id` = `activityBids`.`userid` LEFT JOIN `activitySites` ON `activitySites`.`id` = `activityBids`.`activityid` WHERE `day` = '{$day}' ORDER BY `bid` DESC LIMIT 1");
                                if($result->getNumRows())
                                {
                                    $box = $result->getNext();
                                    
                                    $reserved = $box->reserved;
                                    
                                    $bidAmount = floor($box->bid * 100 + 25) / 100;
                                    $bid = "Current Bid: <a class='lightbox' href='#profileDescriptionLost{$box->id}'>$" . $box->bid . "</a>";
                                    
                                    $formatURL = $sec->formatURL($box->url);
                            
                                    $video = $db->query("SELECT `downlineLink`, `techdimeRef`, `mattRef`, (SELECT `ref` FROM `videoRefs` WHERE `videoRefs`.`videoid` = `videos`.`id` && `videoRefs`.`userid` = '{$usr->data->ref}') AS `ref` FROM `videos` WHERE `downlineLink` like '%{$formatURL}%'");
                                    
                                    if($video->getNumRows())
                                    {
                                        $video = $video->getNext();
                                        $ref = $video->ref;
                                        if($ref == "")
                                        {
                                            $ref = (rand(0,1) == 0) ? $video->mattRef : $video->techdimeRef;
                                        }
                                        $url = $video->downlineLink . $ref;
                                    }
                                    else if($box->refurl != "") $url = $box->refurl;  
                                    else $url = $box->url;
                                    
                                    $banner = "<a href='{$url}' target='_blank'><img src='{$box->banner}' height='100' width='100'></a>";
                                        
                                    $email = md5(strtolower(trim($box->email)));
                                    $description = ($box->description != "") ? $sec->closetags($box->description) : "The user has not filled in a description.";
                                    
                                    ?>
                                    <div style="display:none;" id="profileDescriptionLost<?=$box->id?>">
                                        <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$box->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($box->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$box->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($box->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$box->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($box->twitter == "" && $box->facebook == "")) echo "<br>"; ?><hr>
                                        <?=$description?>
                                    </div>
                                    <?php
                                }
                                ?>
                            
                                <div style="display:none;" id="bid<?=$x?>">
                                    <?php
                                    if($usr->data->piggybank < $bidAmount) echo "<center>You do not have enough funds in your Piggy Bank to bid on this day.<br><br><a href='{$site['url']}piggybank'>Click here to add some.</a></center>";
                                    else
                                    {
                                        $activitySites = $db->query("SELECT `id`, `name` FROM `activitySites` WHERE `userid` = '{$usr->data->id}' && `name` != '' && `banner` != '' && `lastHit` > NOW() - INTERVAL 1 HOUR");
                                        if($activitySites->getNumRows())
                                        {
                                            
                                            echo "<div style='width:350px; height:280px;'><center><form method='post'><input type='hidden' value='{$day}' name='bidDay'>Select Site:<br><select style='width:300px;' class='form-control' name='bidWebsite'>";
                                            while($as = $activitySites->getNext())
                                            {
                                                echo "<option value='{$as->id}'>{$as->name}</option>";
                                            }
                                            echo "</select><br>Enter Bid ( Minimum: $" . $bidAmount. " )<br>You have $" . $usr->data->piggybank . " in your piggybank<br><br>";
                                            echo "<div style='width:300px;' class='input-group'><span class='input-group-addon'>$</span><input name='bidAmount' value='{$bidAmount}' type='text' class='form-control' style='width:250px;'></div><br><input type='submit' style='width:300px;' value='Place Bid' class='form-control'>";
                                            echo "</form></center></div>";
                                        }
                                        else echo "<center>You must have an activated traffic exchange to start bidding.<br><br><a href='javascript:$(\".te\").tab(\"show\"); $(\".jquery-lightbox-button-close span\").click(); $(document).scrollTop(0); return(0);'>Click here to add one.</a></center>";
                                    }
                                    ?>
                                </div>
                                <div class="bidblock">
                                    <?=$banner?>
                                    <div class="inner">
                                        <div class="yellow"><?=$currentday?></div>
                                        <br>
                                        <?=$bid?>
                                        <br>
                                        <?php if($reserved == 1): ?>
                                            Day Reserved
                                        <?php else: ?>
                                            <a class='lightbox' href='#bid<?=$x?>'>Make a bid!</a> 
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                            }
                            
                            ?>
                        </center>
                    </div>
                    <div class="tab-pane fade" id="te">
                        <center>
                            As a promoter, you can advertise your traffic exchange to increase surfers. Enter your TE link below to get started!<br><br>
                            <form method="post">
                                <div style="width:500px;" class="input-group">
                                    <input name="newSiteInput" placeholder="TE URL" type="text" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">Add</button>
                                    </span>
                                </div>
                            </form>
                            <br>
                            <script>
                                function removeSite(id)
                                {
                                    $.msgbox("Are you sure you want to delete the website?", {
                                      type: "confirm",
                                      buttons : [
                                        {type: "submit", value: "Yes"},
                                        {type: "submit", value: "No"}
                                      ]
                                    }, function(result) {
                                        if(result == "Yes")
                                        {
                                            $("#removeSiteForm" + id).submit();
                                        }
                                    });
                                }
                                
                                function editName(id, value)
                                {
                                    $.msgbox("Enter a new name:", {
                                            type: "prompt",
                                            inputs  : [
                                              {type: "text", value: value.replace(/"/g,"'"), required: true}
                                            ],
    
                                        }, function(result) {
                                            if (result) {
                                                $("#editNameInput" + id).val(result);
                                                $("#editName" + id).submit();
                                            }
                                    });
                                }
                                
                                function editBanner(id, value)
                                {
                                    $.msgbox("Enter a new square banner URL:", {
                                            type: "prompt",
                                            inputs  : [
                                              {type: "text", value: value, required: true}
                                            ]
    
                                        }, function(result) {
                                            if(result !== false)
                                            {
                                                $("#editBannerInput" + id).val(result);
                                                $("#editBanner" + id).submit();
                                            }
                                    });
                                }
                            </script>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th>Name</th>
                                        <th>Banner</th>
                                        <th>Activate</th>
                                    </tr>
                                </thead>
                                <?php
                                $activitySites = $db->query("SELECT `id`, `code`, `name`, `url`, `banner`, `active`, `countdown`, CASE WHEN `lastHit` > NOW() - INTERVAL 1 HOUR THEN 'true' ELSE 'false' END AS `lastHit` FROM `activitySites` WHERE `userid` = '{$usr->data->id}'");
                                if($activitySites->getNumRows())
                                {
                                    while($activitySite = $activitySites->getNext())
                                    {
                                        //$url = (strlen($activitySite->url) > 20) ? substr($activitySite->url, 0, 17) . "..." : $activitySite->url;
                                        //$name = (strlen($activitySite->name) > 14) ? substr($activitySite->name, 0, 11) . "..." : $activitySite->name;
                                        $url = $activitySite->url;
                                        $name = $activitySite->name;
                                        $activated = ($activitySite->name != "" && $activitySite->banner != "" && $activitySite->lastHit == "true") ? true : false;
                                        $deleteSite = ($activitySite->active == '0' && $activitySite->countdown != '1' && !$db->query("SELECT `id` FROM `activityBids` WHERE `userid` = '{$usr->data->id}' && `activityid` = '{$activitySite->id}'")->getNumRows());
                                        ?>
                                        <?php if($deleteSite) { ?><form method="post" style="display:none" id="removeSiteForm<?=$activitySite->id?>"><input name="removeSite" type="hidden" value="<?=$activitySite->id?>"></form><?php } ?>
                                        <form method="post" style="display:none" id="editName<?=$activitySite->id?>"><input name="editName" type="hidden" value="<?=$activitySite->id?>"><input id="editNameInput<?=$activitySite->id?>" name="value" type="hidden" value="0"></form>
                                        <form method="post" style="display:none" id="editBanner<?=$activitySite->id?>"><input name="editBanner" type="hidden" value="<?=$activitySite->id?>"><input id="editBannerInput<?=$activitySite->id?>" name="value" type="hidden" value="0"></form>
                                        <tr>
                                            <td><?php if($deleteSite) { ?><a href="javascript:;" onclick="javascript:removeSite(<?=$activitySite->id?>)"><i class="icon-remove-sign"></i></a> &nbsp;<?php } ?><?=$url?></td>
                                            <td><a href="javascript:;" onclick="javascript:editName(<?=$activitySite->id?>,'<?=$activitySite->name?>')"><i class="icon-edit"></i></a> &nbsp;<?php echo ($activitySite->name != "") ? $name : "No Name"; ?></td>
                                            <td><a href="javascript:;" onclick="javascript:editBanner(<?=$activitySite->id?>,'<?=$activitySite->banner?>')"><i class="icon-edit"></i></a> &nbsp;<?php echo ($activitySite->banner == "") ? "<i class='icon-remove'></l>" : "<i class='icon-ok'></l>"; ?></td>
                                            <td>
                                                <div style="display:none;" id="activitySite<?=$activitySite->id?>">
                                                    <center>
                                                    <?php
                                                    if($activated) echo "<div style='width:500px; height:140px;'>Your website is activated. To keep it active, you must get a hit to the following page at least once every hour. The page needs to be in rotation at your traffic exchange every 27 page views. You may now start bidding.<br><br><input class='form-control' value='{$site['url']}hit/{$activitySite->code}' style='width:300px;'></div>";
                                                    else if($activitySite->name == "") echo "<div style='width:500px; height:30px;'>You must fill in your traffic exchange name to continue with the activation.</div>";
                                                    else if($activitySite->banner == "") echo "<div style='width:500px; height:30px;'>You must fill in your traffic exchange banner to continue with the activation.</div>";
                                                    else echo "<div style='width:450px; height:190px;'>To complete the activation, you must add the following page into rotation at your traffic exchange every 27 page views. You cannot place a bid until you complete this step.<br><br><input class='form-control' value='{$site['url']}hit/{$activitySite->code}' style='width:300px;'><br>It will automatically be activated as soon as the page gets the first hit.</div>";
                                                    ?>
                                                    </center>
                                                </div>
                                                <a href="#activitySite<?=$activitySite->id?>" class="lightbox"><?=($activated) ? "Done" : "Activate"?></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <h4>How it works</h4>
            <p>This feature is only for traffic exchange owners. Want some additional activity at your Traffic Exchange? Add it in as one of the sites required for Surf Savant Members to remain active. All you need to do is add your Traffic Exchange in under the Traffic Exchange tab, complete the activation process and then you can start bidding on upcoming days using your <a href="<?=$site['url']?>piggybank">Piggy Bank</a> funds. Bidding ends at midnight. The current server time is <?=date("h:i A")?>!</p>
        </div>
        <div class="well">
            <h4>Refunds</h4>
            <p>If you have won a bid and it is your day to be one of the activity websites, you must ensure that your traffic exchange is active (the 'Activate' field should say 'Done'). A failure to do so when the clock hits midnight EST time, then your bid will be canceled and you will not be given a refund.</p>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>