<?php
$tour = false;
if($getVar == "t")
{
    $tour = true;
    $getVar = "1";
}

$url = $db->query("SELECT `earn`, `users`.`facebook`, `users`.`twitter`, `users`.`id`, `users`.`description`, `url`,`fullName`,`email` FROM `ptc` LEFT JOIN `users` ON `users`.`id` = `ptc`.`userid` WHERE `ptc`.`amount` >= `ptc`.`earn` / 500 && `ptc`.`active` = 1 && `ptc`.`id` = '{$getVar}' LIMIT 1");
if(!$url->getNumRows()) die("This ad is invalid");
$url = $url->getNext();
$description = ($url->description != "") ? $sec->closetags($url->description) : "The user has not filled in a description.";
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
      
    <?php if($tour) {
        ?>
        <link href="<?=$site["url"]?>tourGuide/style.css" rel="stylesheet">	
        <script type="text/javascript" src="<?=$site['url']?>tourGuide/script.js?version=1.001"></script>
        <script>              
            var tourGuide;
            $(document).ready(function() {
                tourGuide = new TourGuide("tourGuide", [
                    [".tourStop1", "bottom", "View the ad until the bar is filled up orange and click the close button once it appears."]
                ], function() {
                    
                });
                tourGuide.start();
            });
            
        </script>
        <?php
    } ?>
      
    <style>body{background:#fff;}</style>
    <script>
       var prevent_bust = 0;
        function closewindow() {
            prevent_bust = -5;
            window.location = "<?=$site['url']?>ptc<?php if($tour) echo '/tourContinue'; ?>";
        }
        
        $(document).ready(function(){
            window.onbeforeunload = function() { prevent_bust++ }
            setInterval(function() {
              if (prevent_bust > 0) {
                prevent_bust -= 2;
                window.top.location = 'http://techdime.com/204.php';
              }
            }, 1);
            
            setTimeout( function() { $("#percent").animate({width:($('body').width())},<?php echo 10000 + ($url->earn - 1) * 5000 ?>, function() {
                var data_encoded = JSON.stringify({"userid": "<?=$usr->data->id?>", "ptcid": "<?=$getVar?>"});
                $.ajax({
                    type: "POST",
                    url: "<?=$site['url']?>loggedIn/ptcomplete.php",
                    dataType: "json",
                    data: {
                        "data" : data_encoded
                    },
                    success: function(data) {
                        $("#closewin").fadeIn(); 
                    },
                    error: function(data)
                    {
                        console.log(data);
                    }
                });
                  
            }) }, 1000);
        });
      </script>
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
    <a target="_blank" class="navbar-brand" href="<?=$site['url']?><?=$getVar?>"><!--<i class="icon-shield"></i> &nbsp;<?=$site["name"]?>-->&nbsp;</a>
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
        <li><a id="closewin" href="javascript:closewindow();" style="display:none; padding:10px;border:0; background:#F90;color:#FFF; margin-top:7px; margin-right:20px;">Close Window</a></li>
        <li><a style="padding:0;" href="#profileDescription" class="lightbox"><img style="margin-top:8px;" src="http://www.gravatar.com/avatar/<?=md5($url->email)?>?s=40"></a></li>
        <li style="color:#fff"><a href="#profileDescription" class="lightbox"><?=$url->fullName?></a></li>
    </ul>
  </div><!-- /.navbar-collapse -->
</div> <!-- /.container -->
</nav>
<div class="tourStop1" style="width:100%; background:#93A3BB;"><div id="percent" style=" background:#F90; width:0%; height:8px;"></div></div>

<!--<div style="width:100%; height:5px; background:#F80;"></div>-->
<iframe style="width:100%; height:100%; position:fixed; padding-top:69px; top:0; border:0; box-sizing:border-box;" src="<?=$url->url?>"></iframe>