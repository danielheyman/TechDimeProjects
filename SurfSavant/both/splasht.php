
<?php $user = $db->query("SELECT `testimonial`, `fullName`,`email` FROM `users` WHERE `id` = '{$getVar}'")->getNext(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <link href='http://fonts.googleapis.com/css?family=Cedarville+Cursive' rel='stylesheet' type='text/css'>
    <style>
        img{border:0;}
        body
        {
            background:#2f3840;   
        }
            
        .box
        {
            border: 1px solid #cecece;
            border-bottom-width:2px;
            font-family: Frutiger,"Frutiger Linotype",Univers,Calibri,"Gill Sans","Gill Sans MT","Myriad Pro",Myriad,"DejaVu Sans Condensed","Liberation Sans","Nimbus Sans L",Tahoma,Geneva,"Helvetica Neue",Helvetica,Arial,sans-serif;
            color:#6f6f6f;
            padding:30px;
            border-radius:3px;
            -moz-border-radius:3px;
            -o-border-radius:3px;
            -webkit-border-radius:3px;
            font-size:14px;
            line-height:20px;
            width:500px;
            margin:auto;
            background:#fefefe;
            margin-top:20px;
        }
        
        .top
        {
            min-height:90px;
            padding-left:40px;
            text-align:justify;
        }
        
        .top img
        {
            float:left;
            margin-right:15px;
            border-radius:2px;
            -moz-border-radius:2px;
            -o-border-radius:2px;
            -webkit-border-radius:2px;
        }
        
        .top .quotes
        {
            font-size:40px;
            font-weight:bold;
            position:absolute;
            margin-left:-30px;
            font-family:'Cedarville Cursive', cursive;
            margin-top:10px;
        }
        
        .bottom
        {
            margin-top:20px;
            padding-top:20px;  
            border-top: 1px solid #cecece; 
            text-align:right;
        }
        
        .bottom .button
        {
            float:left;
            padding:5px 10px;
            margin-top:-5px;
            background:#F90;
            color:#FFF;
            border-radius:2px;
            -moz-border-radius:2px;
            -o-border-radius:2px;
            -webkit-border-radius:2px;
            margin-left:35px;
            text-decoration:none;
        }
        
        .bottom .button:hover
        {
            background:#333;
        }
        
        .name
        {
            font-weight:bold;
            font-style:italic;
            display:inline-block;
        }
        
        .edges
        {
            padding-left:440px;
            width:70px;
            margin:auto;
            margin-top:-2px;
        }
        
        .edge
        {
            margin-top:1px;
            position:absolute;
            width: 0; 
            height: 0; 
            border-left: 45px solid transparent;
            border-right: 0px solid transparent;
            border-top: 40px solid #cecece;
        }
        
        .edge2
        {
            position:relative;
            margin-left:5px;
            width: 0; 
            height: 0; 
            border-left: 40px solid transparent;
            border-right: 0px solid transparent;
            border-top: 40px solid #fefefe;
        }
        
        a{
            color:#F90;
            text-decoration:none;
        }
        
        a:hover{
            text-decoration:underline;
        }
        
        .logo{
            margin-top:20px;   
        }
    </style>
</head>
<body>
    <center><img class="logo" src="http://www.surfsavant.com/res/img/logo2.png"></center>
    <div class="box">
        <div class="top">
            <div class="quotes">"</div>
            <img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($user->email)))?>?s=95">
            <?=($user->testimonial != "") ? $sec->closetags($user->testimonial) : "Surf Savant is a finely tuned learning tool for anyone who wants to build an online business. It’s a smart system to grow your downlines and your earning potential. We also do our best to make this experience as fun and effortless as possible. And of course you can make money as a Savant. We've got prizes and contests with a huge amount of opportunities to win cash."?>
            
            So what are you waiting for, <a target="_blank" href="<?=$site['url'].$getVar?>">join me now</a>!
        </div>
        <div class="bottom">
            <a target="_blank" href="<?=$site['url'].$getVar?>" class="button">Join me now!</a>
            <div class="name"><?=$user->fullName?></div>, a great Savant!
        </div>  
    </div>
    <div class="edges"><div class="edge"></div><div class="edge2"></div></div>
</body>