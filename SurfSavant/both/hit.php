<?php
if(isset($_SERVER['HTTP_REFERER'])){
    $formatURL = $sec->formatURL($_SERVER['HTTP_REFERER']);
    
    $getVar = substr($getVar, 0, 6);
    
    $db->query("UPDATE `uniqueHits` SET `hits` = `hits` + 1 WHERE `code` = '{$getVar}' && `worth` = 0");
    
    $activitySite = false;
    $activitySiteID = 0;
    $activitySiteName = "";
    $shield = false;
    
    $active = $db->query("SELECT `name`, `active`, `url` FROM `activitySites` WHERE `code` = '{$getVar}' && `url` LIKE '%{$formatURL}%' LIMIT 1");
    if($active->getNumRows()) 
    {   
        $active = $active->getNext();
        if($sec->formatURL($active->url) == $formatURL)
        {
            $db->query("UPDATE `activitySites` SET `lastHit` = NOW(), `totalHits` = `totalHits` + 1 WHERE `code` = '{$getVar}' && `url` LIKE '%{$formatURL}%'");
            
            if($active->active != "0")
            {
                $activitySiteID = $active->active;
                $activitySiteName = $active->name;
                $activitySite = true;
                
                if(!$usr->loggedIn || ($usr->loggedIn && !$db->query("SELECT `id` FROM `shield` WHERE `userid` = '{$usr->data->id}' && `activitySite` = '{$active->active}'")->getNumRows()))
                {
                    $userid = ($usr->loggedIn) ? $usr->data->id : "";
                    $code = ($usr->loggedIn) ? "------" : $sec->randomCode();
                    $db->query("INSERT INTO `shield` (`code`, `activitySite`, `userid`) values ('{$code}', '{$active->active}', '{$userid}')");   
                    $shield = true;
                }
            }
        }
    }
    
    if(!$shield)
    {
        if(rand(0,1) == 1)
        {
            $url = $db->query("SELECT `users`.`twitter`,`users`.`facebook`,`rotator`.`id`, `users`.`id` AS `id2`, `description`, `url`,`email`,`fullName` FROM `rotator` LEFT JOIN `users` ON `users`.`id` = `rotator`.`userid` WHERE `rotator`.`coins` >= 0.1 && `membership` != '0001' && `reported` = 0 ORDER BY RAND() LIMIT 1");
        }
        else
        {
           $url = $db->query("SELECT `users`.`twitter`,`users`.`facebook`,`rotator`.`id`, `users`.`id` AS `id2`, `description`, `url`,`email`,`fullName` FROM `rotator` LEFT JOIN `users` ON `users`.`id` = `rotator`.`userid` WHERE `rotator`.`coins` >= 0.1 && `reported` = 0 ORDER BY RAND() LIMIT 1"); 
        }
        $url = $url->getNext();
        
        $description = ($url->description != "") ? $sec->closetags($url->description) : "The user has not filled in a description.";
        $db->query("UPDATE `rotator` SET `coins` = `coins` - 0.1, `hits` = `hits` + 1 WHERE `id` = '{$url->id}'");
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>Surf Savant</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">    
        
        <link href="<?=$site["url"]?>res/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?=$site["url"]?>res/css/bootstrap-responsive.min.css" rel="stylesheet">
        
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
        <link href="<?=$site["url"]?>res/css/font-awesome.min.css" rel="stylesheet">        
        
        <link href="<?=$site["url"]?>res/css/base-admin-3.css" rel="stylesheet">
        <link href="<?=$site["url"]?>res/css/base-admin-3-responsive.css" rel="stylesheet">
      
        <link href="<?=$site["url"]?>res/css/base-admin-tweaks.css" rel="stylesheet">
          
          
        <link href="<?=$site["url"]?>res/js/plugins/lightbox/themes/evolution-dark/jquery.lightbox.css" rel="stylesheet">	
          
          
        <script src="<?=$site["url"]?>res/jquery-1.7.min.js"></script>
        <script src="<?=$site["url"]?>res/js/plugins/lightbox/jquery.lightbox.min.js"></script>
          
        <script type="text/javascript">
            $(document).ready(function($){
                $('.lightbox').lightbox();
            });
        </script>
          
        <style>body{background:<?=(!$shield) ? "#fff" : "#2f3840"?>;}</style>
      
        <style>
            @media (max-width: 767px)
            {
                body {
                    padding-right: 0px;
                    padding-left: 0px;
                }  
            
                .navbar .container{
                    margin-right: 20px;
                    margin-left: 20px;
                }
            }
        </style>
          
        <?php if(!$shield) { ?>
        <script>
                
            function reportSite() {
            $(".jquery-lightbox-html .reportSites").fadeOut("slow", function()
            {
                $(".reportSites").html("<center style='width:400px;'><br><br>Thank you for taking the time to report a possible issue!<br><br>You may now close this popup.<br><br></center>");
                $(".jquery-lightbox-html .reportSites").fadeIn();
            });
            
            var data = {"id": "<?=$url->id?>", "text": $(".jquery-lightbox-html .reportInput").val()};
            var data_encoded = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: "<?=$site['url']?>both/report.php",
                dataType: "json",
                data: {
                    "data" : data_encoded
                },
                success: function(data)
                {
                    //console.log(data);
                },
                error: function(data)
                {
                    console.log(data);
                }
            });
        };
        </script>
        <?php } ?>
      </head>
    <body>
    
        
    <?php if(!$shield && strpos($url->url, "surfsavant.com") === FALSE) { ?>
    <nav class="navbar navbar-inverse" role="navigation">
    
        <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <i class="icon-cog"></i>
        </button>
        <a target="_blank" class="navbar-brand" href="<?=$site['url']?>"><!--<i class="icon-shield"></i> &nbsp;<?=$site["name"]?>-->&nbsp;</a>
      </div>
    <style>a:hover{text-decoration:none;}</style>
    <div style="display:none;" id="profileDescription">
        <img src='http://www.gravatar.com/avatar/<?=md5($url->email)?>?s=75'> &nbsp; <b><?=$url->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($url->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$url->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($url->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$url->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($url->twitter == "" && $url->facebook == "")) echo "<br>"; ?><hr>
        <!--<iframe style='border:0; width:700px; height: 400px;' src="<?=$site["url"]?>profile/<?=$user->id?>"></iframe>-->
        <?=$description?>
    </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav navbar-right">
        <li><a style="padding:0;" href="#profileDescription" class="lightbox"><img style="margin-top:8px;" src="http://www.gravatar.com/avatar/<?=md5($url->email)?>?s=40"></a></li>
        <li style="color:#fff;margin-right:100px;"><a href="#profileDescription" class="lightbox"><?=$url->fullName?></a></li>
            <li>
                <a href="#reportSites" class="lightbox">Report Website</a>
                <!--<a href="javascript:;" id="reportsite">Report Website</a>-->
                <div style="display:none;" class="reportSites" id="reportSites">
                    <center style="width:400px;">
                        Please enter the reason for reporting the website:<br><br>
                        <textarea style="width:370px;" class="form-control reportInput"></textarea><br>
                        <button onclick="reportSite()" id="reportSite" type="button" class="btn btn-primary">Report</button>
                    </center>
                </div>
            </li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div> <!-- /.container -->
    </nav>
    <?php }
    if($activitySite) {
        if($usr->loggedIn) {
            $cash = 0;
            $test = $db->query("SELECT `id` FROM `transactions` WHERE `item_name` = '{$activitySiteName} Surfing Bonus' && `userid` = '{$usr->data->id}' && `date` > NOW() - INTERVAL 20 MINUTE");
            if($test->getNumRows() == 0) {
                $amount = ($activitySiteID == 4) ? 0.04 : 0.02; 
                $test2 = $db->query("SELECT `commissions`.`id` FROM `commissions` LEFT JOIN `transactions` ON `transactions`.`id` = `commissions`.`transactionid` WHERE `item_name` = '{$activitySiteName} Surfing Bonus' && `commissions`.`userid` = '{$usr->data->id}' && DATE(`date`) = DATE(NOW()) GROUP BY `commissions`.`userid` HAVING SUM(`commissions`.`amount`) >= {$amount}");
                if(!$test2->getNumRows()) {
                    $cash = 0.01 - rand(0,7) / 1000;
                    
                    if(($activitySiteID == 4)) $cash *= 2;
                    $db->query("INSERT INTO `transactions` (`id`, `userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES (NULL, '{$usr->data->id}', '-1', '{$activitySiteName} Surfing Bonus', '', '0', CURRENT_TIMESTAMP)");   
                        $id = $db->insertID;
                        $db->query("INSERT INTO `commissions` (`id`, `userid`, `transactionid`, `amount`, `status`) VALUES (NULL, '{$usr->data->id}', '{$id}', '{$cash}', '1')"); 
                }
            }
        }
        else $cash = 1;
    }
    else $cash = 2;
    if($cash != 2)
    {
    ?>
    <style>
        a{text-decoration:none;}
        #bar{
            text-align:center;
            height:40px;
            line-height:40px;
            background:#93A3BB;
            color:#fff;
            cursor:pointer;
            z-index:5;
            position:relative;
            font-size:12pt;
        }
        
        #bar:hover{
            background:#F90;
        }
    </style>
    <?php if($cash != 1) { ?>
    <div id="bar"><i class="icon-money"></i> &nbsp; Click here to see if you won some cash! &nbsp; <i class="icon-money"></i></div>
    <script>
    $("#bar").click(function() {
        if($("#bar").html() == '<i class="icon-money"></i> &nbsp; Click here to see if you won some cash! &nbsp; <i class="icon-money"></i>')
        {
            $("#bar").fadeOut(500, function() {
                if("<?=$cash?>" == "0") $("#bar").html("Aw man, you didn't win :( &nbsp; &nbsp; &nbsp; &nbsp; [ Click to close ]");
                else $("#bar").html("Congratulations, you won $<?=$cash?> :) &nbsp; &nbsp; &nbsp; &nbsp; [ Click to close ]");
                $("#bar").fadeIn(500);
            });
        }
        else
        {
            $("#bar").fadeOut(function() {
                <?php if(!$shield) { ?>
                $("iframe").animate({"padding-top": "<?php echo (strpos($url->url, "surfsavant.com") === FALSE) ? 62 : 0; ?>"});
                <?php } ?>
            });   
        }
    });    
    </script>
    <?php } else { ?>
    <a target="_blank" href="<?=$site["url"]?>"><div id="bar"><i class="icon-money"></i> &nbsp; Login for a chance to see if you won some cash! &nbsp; <i class="icon-money"></i></div></a>
    <?php } $cash = 40; } else $cash = 0; 
    if(!$shield) 
    { 
        ?>
        <iframe style="width:100%; height:100%; position:fixed; padding-top:<?php echo (strpos($url->url, "surfsavant.com") === FALSE) ? 62 + $cash : 0 + $cash; ?>px; top:0; border:0; box-sizing:border-box;" src="<?=$url->url?>"></iframe>
        <?php
    }
    else
    {
        ?>
        <div style="position: absolute; display: block; top: 50%; margin-top:-110px; text-align:center; width:100%; color:#fff; font-size:25px; font-style:italic; font-weight:bold;">
            You found a Surf Savant Shield!
            <br><br><br>
            <?php if(!$usr->loggedIn) echo "<a target='_blank' href='{$site['url']}shield/{$code}'>"; ?><img src="<?=$site['url']?>res/img/shield.png"><?php if(!$usr->loggedIn) echo "</a>"; ?>
            <br><br>
            <div style="font-size:15px;"><?=($usr->loggedIn) ? "<font style='color:green;'>Shield Automatically Claimed</font>" : "Click shield to claim"?></div>
        </div>
        <?php
    }
}
else echo "error";
?>