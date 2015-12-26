<!doctype html>
<html>
<head>
    <title>SurfDuel</title>
    <link href='http://fonts.googleapis.com/css?family=Cedarville+Cursive' rel='stylesheet' type='text/css'>
    <style>
        body{
            padding:0;
            margin:0;
            background:url(<?=$site['url']?>promo/splash2.png), #3687bf;
            background-repeat:no-repeat;
            background-position:center top; 
            font-family:Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;
            color:#926f4f;
        }
        
        #center{
            width:100%;
            height:100%;
            position:fixed;
            top:0;
            left:0;
            right:0;
            bottom:0;
        }
        
        #right{
            margin-top:86px;
            border-left:665px solid transparent;
            width:254px;
            height:255px;
            text-align:left;
            padding:40px;
        }
        
        #name img{
            width:70px;
            height:70px;
            -moz-border-radius:5px;
            -webkit-border-radius:5px;
            border-radius:5px;
            border:2px solid #926f4f;
        }
        
        #name div{
            display:inline-block;
            position:absolute;
            padding:12px;
            height:50px;
            font-size:14pt;
            line-height:25px;
            font-style:italic;
        }
        
        #quote{
            border-left:4px solid #926f4f;
            padding:10px;
            margin-top:20px;
            height:100px;
            max-width:250px;
            font-size:11pt;
            padding-right:0;
            text-align:justify;
            font-style:italic;
        }
        
        #sign{
            border-left:4px solid #926f4f;
            padding:10px;
            margin-top:0;
            height:40px;
            max-width:230px;
            line-height:20px;
            font-size:11pt;
        }
        
        #sign span{
            font-family: 'Cedarville Cursive', cursive;
        }
    </style>
</head>
<body>
    <?php 
    $user = $db->query("SELECT `splash2`, `fullName`, `email` FROM `users` WHERE `id` = '{$getVar}' LIMIT 1");
    $user = $user->getNext();
    ?>
    <center><div id="right">
        <div id="name">
            <img src="http://www.gravatar.com/avatar/<?php echo md5(strtolower(trim($user->email))); ?>?s=70">
            <div>
                <?=$user->fullName?><br>recommends SurfDuel
            </div>
        </div>
        <div id="quote">
            <?php echo $user->splash2; ?>
        </div>
        <div id="sign">
            Signed,<br><span><?=$user->fullName?></span>
        </div>
    </div></center>
    <a href="<?php echo $site['url'] . $getVar ?>"><div id="center"> </div></a>
</body>
</html>