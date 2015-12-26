<?php
    $user = $db->query("SELECT `testimonial`, `fullName`,`email` FROM `users` WHERE `id` = '{$getVar}'")->getNext();
?>
<link href="http://www.surfsavant.com/res/css/font-awesome.min.css" rel="stylesheet">    
<link href='http://fonts.googleapis.com/css?family=Cedarville+Cursive' rel='stylesheet' type='text/css'>
<style>
	img{border:0;}
	body{
		background: #797676;
		font-family: Frutiger,"Frutiger Linotype",Univers,Calibri,"Gill Sans","Gill Sans MT","Myriad Pro",Myriad,"DejaVu Sans Condensed","Liberation Sans","Nimbus Sans L",Tahoma,Geneva,"Helvetica Neue",Helvetica,Arial,sans-serif;
        color:#333;
	}
	a{
		color:inherit;
		text-decoration:inherit;
		margin:0;
		border:0;
		padding:0;
	}
	.wrapper{
		padding-left:10px;
		padding-right:10px;
		margin:auto;
		margin-top:20px;
		border: 2px solid #333;
		width: 700px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		-o-border-radius: 10px;
		border-radius: 10px;
		background: #F2F2F5;
		-o-box-shadow: 0px 3px #333, 0 0 10px #333;
		-moz-box-shadow: 0px 3px #333, 0 0 10px #333;
		-webkit-box-shadow: 0px 3px #333, 0 0 10px #333;
		box-shadow: 0px 3px #333, 0 0 10px #333;
	}
	.rec{
		position:relative;
		background:#fafafc;
		border: 1px solid #a3a3a3;
		padding:20px;
		margin-left:10px;
		margin-right:10px;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		-o-border-radius: 5px;
		border-radius: 5px;
		z-index:1;
	}
	.userinfo{
		position:relative;
		float:right;
		margin-right:50px;
		margin-top:-1px;
		z-index:2;
		height: 45px;
		width: 230px;
		background:#fafafc;
		border:1px solid #a3a3a3;
		border-top: none;
		padding:10px;
		-webkit-border-bottom-right-radius: 10px;
		-webkit-border-bottom-left-radius: 10px;
		-moz-border-radius-bottomright: 10px;
		-moz-border-radius-bottomleft: 10px;
		-o-border-radius-bottomright: 10px;
		-o-border-radius-bottomleft: 10px;
		border-bottom-right-radius: 10px;
		border-bottom-left-radius: 10px;
	}
	.buffer{
		height: 70px;
        margin-top: 5px;
	}
	.grav{
		float:right;
		height:65px;
		width:65px;
		margin-top:-10px;
		margin-bottom:-10px;
		margin-right:-10px;
		background:url(http://www.gravatar.com/avatar/<?=md5(strtolower(trim($user->email)))?>?s=65);
		-webkit-border-bottom-right-radius: 10px;
		-moz-border-radius-bottomright: 10px;		
		-o-border-radius-bottomright: 10px;
		border-bottom-right-radius: 10px;
	}
	.button{
		position:relative;
		width:300px;
		margin-left:-152px;
		margin-right:-152px;
		margin-top:10px;
		margin-bottom:0;
		height:25px;
		border: 2px solid #F90;
		padding: 10px;
		font-size: 20px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;		
		-o-border-radius: 10px;
		border-radius: 10px;
		font-weight:bold;
	}.button:hover{
		background: #F90;
		color:white;
	}
	.buffer2{
		height:20px;
	}
    h1{
        color:#F90;   
    }
</style>
<div class="wrapper">
	<center>
		<h1><i class="icon-shield"></i> Surf Savant</h1>
		<div class="rec">
            <?php
            echo ($user->testimonial != "") ? $sec->closetags($user->testimonial) : "Surf Savant is One Word: Awesome!!";
            
            ?>
		</div>
		<div class="userinfo"><i style="line-height:45px;font-family:'Cedarville Cursive',cursive;"><?=$user->fullName?></i><div class="grav"></div></div>
		<div class="buffer"><br><strong><i class="icon-lightbulb"></i> Learn to succeed &nbsp;<i class="icon-money"></i> Make money &nbsp;<i class="icon-thumbs-up"></i> Have fun</strong></div>
		<div class="button"><a target="_blank" href="http://www.surfsavant.com/<?=$getVar?>">Find Out More</a></div>
		<div class="buffer2"></div>
	</center>
</div>