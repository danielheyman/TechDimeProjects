<?php
$getVar = explode("-", $getVar);
if(sizeof($getVar) == 2)
{
    $ref = $getVar[0];
    $getVar = $getVar[1];
}
else
{
    $ref = $getVar[0];
    if(rand(0,1) == 0) $getVar = $ref;
    else $getVar = $db->query("SELECT `id` FROM `users` WHERE `membership` != '0001' ORDER BY RAND() LIMIT 1")->getNext()->id;
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

      
    <!--<script src="<?=$site["url"]?>res/js/libs/jquery-1.9.1.min.js"></script>-->
    <script src="<?=$site["url"]?>res/jquery-1.7.min.js"></script>
    <script src="<?=$site["url"]?>res/js/plugins/lightbox/jquery.lightbox.min.js"></script>
      
    <script type="text/javascript">
        $(document).ready(function($){
            $('.lightbox').lightbox();
        });
    </script>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

  </head>

<body>

    
<nav class="navbar navbar-inverse" role="navigation">

	<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <i class="icon-cog"></i>
    </button>
    <a target="_blank" class="navbar-brand" href="<?=$site["url"]?><?=$ref?>"><!--<i class="icon-shield"></i> &nbsp;<?=$site["name"]?>-->&nbsp;</a>
  </div>
</div> <!-- /.container -->
</nav>
    
<br>
    
    
<div class="main">
    <div class="container"> 
        <div class="row">
            <?php
            if($sec->post("id"))
            {
                $user = $db->query("SELECT `facebook`, `twitter`, `email`, `fullName`, `id`,`description` FROM `users` WHERE `id` = '{$getVar}'");
                $user = $user->getNext();
                $email = md5(strtolower(trim($user->email)));
                $description = ($user->description != "") ? $sec->closetags($user->description) : "The user has not filled in a description.";
                ?>
                <style>a:hover{text-decoration:none;}</style>
                <div style="display:none;" id="profileDescription">
                    <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$user->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($user->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$user->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($user->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$user->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($user->twitter == "" && $user->facebook == "")) echo "<br>"; ?><hr>
                    <?=$description?>
                </div>
                <?php
                $url = $sec->post("url");
                if($url != "surfsavant.com" && $url != "unknown")
                {
                    if($db->query("SELECT `id` FROM `brandingHits` WHERE `userid` = '{$getVar}' && `site` = '{$url}' && DATE(`timestamp`) = DATE(NOW())")->getNumRows())
                    {
                        $correct = ($sec->post("id") == $getVar) ? ", `correct` = `correct` + 1" : "";
                        $db->query("UPDATE `brandingHits` SET `views` = `views` + 1{$correct} WHERE `userid` = '{$getVar}' && `site` = '{$url}'");
                    }
                    else
                    {
                        $correct = ($sec->post("id") == $getVar) ? ",correct" : "";
                        $correct2 = ($sec->post("id") == $getVar) ? ",'1'" : "";
                        $db->query("INSERT INTO `brandingHits` (`userid`,`site`,`views`{$correct}) VALUES ('{$getVar}','{$url}','1'{$correct2})");
                    }
                }
                if($sec->post("id") == $getVar)
                {
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Well done!</strong> Thank you for the help. Learn more about <a href="#profileDescription" class="lightbox"><?=$user->fullName?></a>.
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
                            <strong>Oops!</strong> It seems to not match. Learn more about <a href="#profileDescription" class="lightbox"><?=$user->fullName?></a>.
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="col-md-12">
                <div class="widget stacked">
                <div class="widget stacked">
                    <div class="widget-content">
                        <style>
                            h2{
                                margin-top: 20px;
                                margin-bottom: 30px;
                                font-size: 24px;
                                font-weight: 600;   
                            }
                            h3 img{
                                margin-bottom: 30px;  
                            }
                            h3{
                                font-size: 18px;
                                font-weight: 400;
                                color: #777;   
                            }
                            
                            #getin{
                                padding: 10px 20px;
                                font-size: 20px;
                            }
                        </style>
                        <?php 
                        if($sec->post("id")) {
                            echo "<center><h2><i class='icon-shield'></i> Surf Savant</h2><h3><i class='icon-lightbulb'></i> Learn to Succeed &nbsp; <i class='icon-money'></i> Make Money &nbsp; <i class='icon-thumbs-up'></i> Have Fun!</h3><br><a target='_blank' href='{$site['url']}{$ref}'><button type='button' class='btn btn-primary' id='getin'>Get in the Game!</button></a></center><br>";
                        }
                        else {
                            if(isset($_SERVER['HTTP_REFERER'])){
                                $url = $sec->formatURL($_SERVER['HTTP_REFERER']);
                            }
                            else $url = "unknown";
                            echo "<center>";
                            $type = rand(1,3);
                            switch($type)
                            {
                                case 1:
                                    $user = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `id` = '{$getVar}' ORDER BY RAND() LIMIT 1");
                                    $users = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `id` != '{$getVar}' && `activeBrandingYesterday` = 1 ORDER BY RAND() LIMIT 3");
                                    $win = rand(1,4);
                                    $winner = $user->getNext();
                                    echo "<center><h2>Oh No! Looks like we forgot our user. Can you help?</h2><h3>Who is {$winner->fullName}?</h3></center><br>";
                                    for($x = 1; $x <= 4; $x++)
                                    {
                                        if($win == $x)
                                        {
                                            $email = md5(strtolower(trim($winner->email)));
                                            $id = $getVar;
                                        }
                                        else
                                        {
                                            $email = md5(strtolower(trim($users->getNext()->email)));
                                            $id = -1;
                                        }
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form action='{$site['url']}splashb/{$ref}-{$getVar}' method='post'><input type='hidden' name='url' value='{$url}'><input type='hidden' name='id' value='{$id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'></a></form></center><br></div>";
                                    }
                                    break;
                                case 2:
                                    $user = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `id` = '{$getVar}' ORDER BY RAND() LIMIT 1");
                                    $users = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `id` != '{$getVar}' && `activeBrandingYesterday` = 1 ORDER BY RAND() LIMIT 3");
                                    $win = rand(1,4);
                                    $winner = $user->getNext();
                                    $email = md5(strtolower(trim($winner->email)));
                                    echo "<center><h2>Oh No! Looks like we forgot our user. Can you help?</h2><h3><img src='http://www.gravatar.com/avatar/{$email}?s=125'><br>What is this surfer's name?</h3></center><br>";
                                    for($x = 1; $x <= 4; $x++)
                                    {
                                        if($win == $x)
                                        {
                                            $name = $winner->fullName;
                                            $id = $getVar;
                                        }
                                        else
                                        {
                                            $name = $users->getNext()->fullName;
                                            $id = -1;
                                        }
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form action='{$site['url']}splashb/{$ref}-{$getVar}' method='post'><input type='hidden' name='url' value='{$url}'><input type='hidden' name='id' value='{$id}'><a href='javascript:;' onclick='parentNode.submit();'>{$name}</a></form></center><br></div>";
                                    }
                                    break;
                                case 3:
                                    $user = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `id` = '{$getVar}' ORDER BY RAND() LIMIT 1");
                                    $users = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `id` != '{$getVar}' && `activeBrandingYesterday` = 1 ORDER BY RAND() LIMIT 6");
                                    $win = rand(1,4);
                                    $winner = $user->getNext();
                                    echo "<center><h2>Oh No! Looks like we forgot our user. Can you help?</h2><h3>What is the correct group?</h3></center><br>";
                                    for($x = 1; $x <= 4; $x++)
                                    {
                                        if($win == $x)
                                        {
                                            $email = md5(strtolower(trim($winner->email)));
                                            $name = $winner->fullName;
                                            $id = $getVar;
                                        }
                                        else
                                        {
                                            $email = md5(strtolower(trim($users->getNext()->email)));
                                            $name = $users->getNext()->fullName;
                                            $id = -1;
                                        }
                                        echo "<div class='col-md-3' style='display:inline-block;'><center><form action='{$site['url']}splashb/{$ref}-{$getVar}' method='post'><input type='hidden' name='url' value='{$url}'><input type='hidden' name='id' value='{$id}'><a href='javascript:;' onclick='parentNode.submit();'><img src='http://www.gravatar.com/avatar/{$email}?s=125'><br>{$name}</a></form></center><br></div>";
                                    }
                                    break;
                            }
                            echo "</center><style>.col-md-3 form:hover img{ -moz-box-shadow: 0 0 5px #454545; -o-box-shadow: 0 0 5px #454545; -webkit-box-shadow: 0 0 5px #454545; box-shadow: 0 0 5px #454545; }</style>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>