<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Surf Savant</title>
    
    <link rel="icon" type="image/png" href="<?=$site["url"]?>favicon.png">
      
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="<?=$site["url"]?>res/css/bootstrap.min.css" rel="stylesheet">
    <?php if($thePage != 'loggedIn/home2.php') { ?><link href="<?=$site["url"]?>res/css/bootstrap-responsive.min.css" rel="stylesheet"><?php } ?>
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?=$site["url"]?>res/css/font-awesome.min.css" rel="stylesheet">        
    
    <link href="<?=$site["url"]?>res/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">
    
    <link href="<?=$site["url"]?>res/css/base-admin-3.css" rel="stylesheet">
    <?php if($thePage != 'loggedIn/home2.php') { ?><link href="<?=$site["url"]?>res/css/base-admin-3-responsive.css" rel="stylesheet"><?php } ?>
      
      
    <?php if($thePage == 'loggedIn/home2.php') { ?><link href="<?=$site["url"]?>res/css/base-admin-3-dashboard.css?version=1.002" rel="stylesheet"><?php } ?>
      
      
      
    <link href="<?=$site["url"]?>res/css/base-admin-tweaks.css?version=1.002" rel="stylesheet">
    
    <link href="<?=$site["url"]?>res/css/pages/dashboard.css" rel="stylesheet">   

    <link href="<?=$site["url"]?>res/css/custom.css" rel="stylesheet">
      
    <link href="<?=$site["url"]?>res/css/pages/reports.css" rel="stylesheet">
      
      
	<link href="<?=$site["url"]?>res/js/plugins/msgGrowl/css/msgGrowl.css" rel="stylesheet">
	<link href="<?=$site["url"]?>res/js/plugins/lightbox/themes/evolution-dark/jquery.lightbox.css" rel="stylesheet">	
	<link href="<?=$site["url"]?>res/js/plugins/msgbox/jquery.msgbox.css" rel="stylesheet">	
      
      
    <link href="<?=$site["url"]?>res/js/plugins/cirque/cirque.css" rel="stylesheet">

      
      
	<link href="<?=$site["url"]?>res/js/plugins/jqueryte/jquery-te-1.4.0.css" rel="stylesheet">	

      
    <!--<script src="<?=$site["url"]?>res/js/libs/jquery-1.9.1.min.js"></script>-->
    <script src="<?=$site["url"]?>res/jquery-1.7.min.js"></script>
    <script src="<?=$site["url"]?>res/js/plugins/jqueryte/jquery-te-1.4.0.min.js"></script>
    <script src="<?=$site["url"]?>res/js/plugins/lightbox/jquery.lightbox.min.js"></script>
    <script type="text/javascript" src="<?=$site['url']?>res/jquery-ui-1.10.3.js"></script>
      
    <script type="text/javascript">
        $(document).ready(function($){
            $('.lightbox').lightbox();
        });
    </script>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

      
	<link href="<?=$site["url"]?>tourGuide/style.css" rel="stylesheet">	
    <script type="text/javascript" src="<?=$site['url']?>tourGuide/script.js?version=1.001"></script>
    <style>
    .navbar {
        position: static;
    }
    </style>


    <!-- Begin Inspectlet Embed Code -->
<script type="text/javascript" id="inspectletjs">
	window.__insp = window.__insp || [];
	__insp.push(['wid', 1989608970]);
	(function() {
		function __ldinsp(){var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js'; var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); }
		if (window.attachEvent){
			window.attachEvent('onload', __ldinsp);
		}else{
			window.addEventListener('load', __ldinsp, false);
		}
	})();
</script>
<!-- End Inspectlet Embed Code -->
      
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
    <a class="navbar-brand" href="<?=$site["url"]?>">&nbsp;</a>
    
    <?php if(false && $usr->loggedIn) { ?>
    <a href="<?=$site['url']?>chat" class="smallStats"><?=$db->query("SELECT count(`userID`) AS `count` FROM `chat`.`ajax_chat_online`")->getNext()->count?> Chatting</a>
    <a href="<?=$site['url']?>tools" class="smallStats">$<?php
        $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'");
        $sum = number_format($result->getNext()->sum,3);
        echo ($sum == "") ? "0" : $sum;
        ?> Cash
    </a>
    <a href="<?=$site['url']?>coins" class="smallStats"><?=number_format($usr->data->coins,2)?> Coins</a>
    <?php } ?>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav navbar-right">
        <?php if($usr->loggedIn) { ?>
		<li class="dropdown">
			<a href="javscript:;" class="dropdown-toggle" data-toggle="dropdown">
                <style>
                .profileImage{
                    border-radius:50px;
                    -moz-border-radius:50px;
                    -o-border-radius:50px;
                    -webkit-border-radius:50px;
                    margin-right:10px;
                    box-shadow:0px 0px 7px #93A3BB;
                    -moz-box-shadow:0px 0px 7px #93A3BB;
                    -o-box-shadow:0px 0px 7px #93A3BB;
                    -webkit-box-shadow:0px 0px 7px #93A3BB;
                }
                </style>
				<img class="profileImage" src="http://www.gravatar.com/avatar/<?=md5($usr->data->email)?>?s=30">
                <?=$usr->data->fullName?>
				<b class="caret"></b>
			</a>
			
			<ul class="dropdown-menu">
				<!--<li><a href="<?=$site["url"]?>settings">Account Settings</a></li>
				<li><a href="<?=$site['url']?>upgrade"><?php echo ($usr->data->membership == "0001") ? "Upgrade" : $membership[$usr->data->membership]["name"] . " Member"; ?></a></li>
				<li class="divider"></li>
				<li><a href="<?=$site["url"]?>home/resettut">Restart Tutorial</a></li>
				<li class="divider"></li>
				<li><a href="<?=$site["url"]?>logout">Logout</a></li>-->
			</ul>
			
		</li>
        <?php } ?>
    </ul>
  </div><!-- /.navbar-collapse -->
</div> <!-- /.container -->
</nav>
    



    
<div class="subnavbar">

	<div class="subnavbar-inner">
	
		<div class="container">
			
			<a href="javascript:;" class="subnav-toggle" data-toggle="collapse" data-target=".subnav-collapse">
		      <span class="sr-only">Toggle navigation</span>
		      <i class="icon-reorder"></i>
		      
		    </a>

			<div class="collapse subnav-collapse">
                
                <?php if(!$usr->loggedIn) { ?>
                <div id="earningSummary"><?php echo number_format($db->query("SELECT COUNT(`id`) as `count` FROM `users` WHERE `activation` = 1")->getNext()->count); ?> Members Have Earned $<?php echo number_format($db->query("SELECT SUM(`amount`) as `count` FROM `commissions`")->getNext()->count,2); ?></div>
                <?php } ?>
				
                <ul class="mainnav">
                    
                    <?php if($usr->loggedIn) { ?>
					<li class="active">
						<a href="<?=$site["url"]?>">
							<i class="icon-home"></i>
							<span>Dashboard</span>
						</a>	    				
					</li>
					<li class="">
						<a href="<?=$site["url"]?>tools">
							<i class="icon-money"></i>
							<span>Commissions</span>
						</a>	    				
					</li>
					<li class="">
						<a href="<?=$site["url"]?>settings">
							<i class="icon-gear"></i>
							<span>Settings</span>
						</a>	    				
					</li>
					<li class="">
						<a href="<?=$site["url"]?>logout">
							<i class="icon-trash"></i>
							<span>Logout</span>
						</a>	    				
					</li>
					<!--
					<li class="active">
						<a href="<?=$site["url"]?>">
							<i class="icon-home"></i>
							<span>Dashboard</span>
						</a>	    				
					</li>
                    
                    <li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-dollar"></i>
							<span>Earn</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a target="_blank" href="http://blog.surfsavant.com/let-me-count-the-ways-baby/">Getting Started</a></li>
							<li><a href="<?=$site["url"]?>ptc">Paid to Click</a></li>
							<li><a href="<?=$site["url"]?>contest">Contest</a></li>
							<li><a href="<?=$site["url"]?>tools">Affiliate Tools</a></li>
						</ul> 				
					</li>
                    
                    <li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gamepad"></i>
							<span>Games</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="<?=$site["url"]?>branding">Who Am I?</a></li>
							<li><a href="<?=$site["url"]?>stocks">Virtual Stocks</a></li>
						</ul> 				
					</li>
                    
                    <li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-comments"></i>
							<span>Connect</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="<?=$site["url"]?>chat">Chat Room</a></li>
							<li><a href="<?=$site["url"]?>directory/1">Directory</a></li>
						</ul> 				
					</li>
                    
                    <li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-bullhorn"></i>
							<span>Advertise</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="<?=$site["url"]?>ptc">Paid to Click</a></li>
							<li><a href="<?=$site["url"]?>rotator">Traffic Rotator</a></li>
							<li><a href="<?=$site["url"]?>activityBid">TE Owners</a></li>
							<li><a href="<?=$site["url"]?>piggybank">Piggy Bank</a></li>
						</ul> 				
					</li>
                    
                    <li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-star"></i>
							<span>Discover</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="<?=$site["url"]?>tutorials/1">Programs</a></li>
							<li><a target="_blank" href="http://blog.surfsavant.com/">Official Blog</a></li>
						</ul> 				
					</li>
                    
                    <li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-shopping-cart"></i>
							<span>Shop</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="<?=$site["url"]?>upgrade">Upgrade</a></li>
							<li><a href="<?=$site["url"]?>coins">Coins</a></li>
							<li><a href="<?=$site["url"]?>piggybank">Piggy Bank</a></li>
							<li><a href="<?=$site["url"]?>vacation">Vacation Days</a></li>
						</ul> 				
					</li>-->







                    
					<!--<li class="dropdown">
						<a href="<?=$site["url"]?>contest">
							<i class="icon-trophy"></i>
							<span>Contest</span>
						</a>	    				
					</li>
                    
					<li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-hand-down"></i>
							<span>Ads</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="<?=$site["url"]?>ptc">Paid to Click</a></li>
							<li><a href="<?=$site["url"]?>rotator">Traffic Rotator</a></li>
							<li><a href="<?=$site["url"]?>activityBid">Activity Website</a></li>
							<li><a href="<?=$site["url"]?>piggybank">Piggy Bank</a></li>
						</ul> 				
					</li>
                    
					<li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gamepad"></i>
							<span>Games</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="<?=$site["url"]?>branding">Who Am I?</a></li>
							<li><a href="<?=$site["url"]?>stocks">Virtual Stocks</a></li>
						</ul> 				
					</li>
                    
					<li class="dropdown">					
						<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-comments"></i>
							<span>Friends</span>
							<b class="caret"></b>
						</a>	    
					
						<ul class="dropdown-menu">
							<li><a href="<?=$site["url"]?>chat">Chat Room</a></li>
							<li><a href="<?=$site["url"]?>directory">Directory</a></li>
						</ul> 				
					</li>
					
					<li class="dropdown">					
						<a href="<?=$site["url"]?>tutorials/1">
							<i class="icon-book"></i>
							<span>Tutorials</span>
						</a>			
					</li>
					
					<li class="dropdown">					
						<a href="<?=$site["url"]?>tools">
							<i class="icon-group"></i>
							<span>Affiliate</span>
						</a>			
					</li>
					
					<li class="dropdown">					
						<a href="<?=$site["url"]?>upgrade">
							<i class="icon-arrow-up"></i>
							<span>Upgrade</span>
						</a>			
					</li>
					
					<li class="dropdown">					
						<a target="_blank" href="http://blog.surfsavant.com/">
							<i class="icon-bullhorn"></i>
							<span>Blog</span>
						</a>			
					</li>-->
					
                    <?php
    
                    $hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $sec->cookie("YDSESSION"));
                    $result = $db->query("SELECT `userid` FROM `sessions` WHERE `hash` = '{$hash}' && `admin` >= 1 && `admin` <= 3 LIMIT 1");
                    if($usr->data->id <= 3 || $result->getNumRows()) { ?>
					<li class="dropdown">					
						<a href="<?=$site["url"]?>admin">
							<i class="icon-gear"></i>
							<span>Admin</span>
						</a>			
					</li>
                    <?php } if($result->getNumRows()) { ?>
					<li class="dropdown">					
						<a href="<?=$site["url"]?>home/leaveAccount">
							<i class="icon-gear"></i>
							<span>Leave Account</span>
						</a>			
					</li>
                    <?php } } else { ?>
                    
                    
					<li class="active">
						<a href="<?=$site["url"]?>">
							<i class="icon-home"></i>
							<span>Home</span>
						</a>	    				
					</li>
                    
					<li>
						<a href="<?=$site["url"]?>register">
							<i class="icon-pencil"></i>
							<span>Sign Up</span>
						</a>	    				
					</li>
					<li>
						<a href="<?=$site["url"]?>login">
							<i class="icon-user"></i>
							<span>Sign In</span>
						</a>	    				
					</li>
                    
                    <?php } ?>
				
				</ul>
                
			</div> <!-- /.subnav-collapse -->

		</div> <!-- /container -->
	
	</div> <!-- /subnavbar-inner -->

</div> <!-- /subnavbar -->
    
    
    
    
    
    
<div class="main">
    <div class="container" >
        <?php  //include 'loggedIn/tutorial.php'; ?>
        <?php if($usr->loggedIn) {
        if($thePage == 'loggedIn/home.php' || $thePage == 'loggedIn/coins.php')
        {
            $query = $db->query("SELECT UNIX_TIMESTAMP(`end`) - UNIX_TIMESTAMP(NOW()) AS `end`, `count`, `display`, `text` FROM `sales` WHERE `end` > NOW() &&  `start` < NOW() && `count` > 0");
            if($query->getNumRows())
            {
                $query = $query->getNext();
                $display = '';
                if($query->display == '1') $display = "Only {$query->count} packages left.";
                else if($query->display == '2') $display = "Only " . $gui->timeFormat($query->end) . ' left.';
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?=$query->text?> <strong><?=$display?></strong> <?php if($thePage != 'loggedIn/coins.php') { ?><a href="<?=$site['url']?>coins">Check it out now!</a><?php } ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        //include 'loggedIn/tour.php';
        for($x = 2; $x <= 7; $x++)
        {
            $day = date('j') + $x;
            $datetime = new DateTime("{$x} day"); 
            $currentday = $datetime->format('D, M j'); 
            
            $check = $db->query("SELECT `userid` FROM `activityBids` WHERE `day` = '{$day}' ORDER BY `bid` DESC LIMIT 1");
            $check2 = $db->query("SELECT `id` FROM `activityBids` WHERE `day` = '{$day}' && `userid` = '{$usr->data->id}' && `bid` = 0 ORDER BY `bid` DESC LIMIT 1");
            if($check->getNumRows() && $check->getNext()->userid != $usr->data->id && $check2->getNumRows())
            {
            ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oh No!</strong> Looks like someone outbid you on <?=$currentday?>. Click <a href="<?=$site['url']?>activityBid">here</a> to fight back.
                    </div>
                </div>
            </div>
        <?php } } } ?>
        