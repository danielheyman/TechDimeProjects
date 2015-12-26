<?php 
    if($getVar)
    {
    $query = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `id` = '{$getVar}'");
    if($query->getNumRows()) {
    $query = $query->getNext();
    $fullName = $query->fullName;
    $email = md5(strtolower(trim($query->email)));
    if($getVar == 1) $getVar = "";
?>
    <!doctype html>
    <html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Cedarville+Cursive' rel='stylesheet' type='text/css'>
        <title>BriskSurf</title>
        <style>
            body{
                padding:0;
                margin:0;
                background:url(<?=$site["url"]?>both/splash3.png), #c74e4e;
                background-repeat:no-repeat;
                background-position: top center;
                color:#fff;
                font-size:25px;
                text-align:center;
                height:100%;
                font-family:Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;
            }
            
            img{
                position:absolute;
                margin-left:75px;
                margin-top:128px;
            }
            
            #name{
                width:300px;
                position:absolute;
                margin-top:310px;
                text-align:center;
                display:inline-block;
                font-family: 'Cedarville Cursive', cursive;
            }
            
            #hover{
                position: fixed;
                top: 0; 
                left: 0;
                bottom:0;
                right:0;
            }
        </style>
    </head>
    <body>
        <img src="http://www.gravatar.com/avatar/<?=$email?>?s=150"/>
        <div id="name"><?=$fullName?></div>
        <a href="<?php echo $site["url"]. $getVar; ?>"><div id="hover">&nbsp;</div></a>
    </body>
    </html>

<?php }} ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42820344-1', 'brisksurf.com');
  ga('send', 'pageview');

</script>