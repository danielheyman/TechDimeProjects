<!doctype html>
<html>
<head>
    <title>SurfDuel</title>
    <style>
        body{
            padding:0;
            margin:0;
            background:url(<?=$site['url']?>promo/splash.png), #3687bf;
            background-repeat:no-repeat;
            background-position:center top; 
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
    </style>
</head>
<body>
    <a href="<?php echo $site['url'] . $getVar ?>"><div id="center"> </div></a>
</body>
</html>