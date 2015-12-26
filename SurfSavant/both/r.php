<?php
$continue = true;
if(isset($_SERVER['HTTP_REFERER'])){
	$url = $_SERVER['HTTP_REFERER'];
	$spam = @file_get_contents("http://techdime.com/rotatorBanned.php?url=" . $url);
	if($spam == "1") $continue = false;
}
if($continue)
{
	$check = $db->query("SELECT `id` FROM `rotatorHits` WHERE `userid` = '{$getVar}' && `ip` = '{$usr->visitorIP()}' LIMIT 1");
	if(!$check->getNumRows())
	{
		$db->query("INSERT INTO `rotatorHits` (`userid`, `ip`) VALUE ('{$getVar}', '{$usr->visitorIP()}')");
		$db->query("UPDATE `users` SET `coins` = `coins` + 0.05 WHERE `id` = '{$getVar}'");
	}
}
else echo "error";

$url = $db->query("SELECT `users`.`facebook`, `users`.`twitter`, `rotator`.`id`, `users`.`id` AS `id2`, `description`, `url`,`fullName`,`email` FROM `rotator` LEFT JOIN `users` ON `users`.`id` = `rotator`.`userid` WHERE `rotator`.`coins` >= 0.1 && `reported` = 0 ORDER BY RAND() LIMIT 1");
$url = $url->getNext();
$description = ($url->description != "") ? $sec->closetags($url->description) : "The user has not filled in a description.";
if($continue)
{
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
	  
	<style>
		body{background:#fff;}
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
<head>
<body>
	<?php if(strpos($url->url, "surfsavant.com") === FALSE) { ?>
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
	<?php } ?>
	<iframe style="width:100%; height:100%; position:fixed; padding-top:<?php echo (strpos($url->url, "surfsavant.com") === FALSE) ? "62" : "0"; ?>px; top:0; border:0; box-sizing:border-box;" src="<?=$url->url?>"></iframe>