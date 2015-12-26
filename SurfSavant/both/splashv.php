<?php
    $user = $db->query("SELECT `splashVideo` FROM `users` WHERE `id` = '{$getVar}'")->getNext();
    $splashVideo = ($user->splashVideo == "") ? "9tadTgogZXo" : $user->splashVideo;
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
    
    <link href="<?=$site["url"]?>res/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">
    
    <link href="<?=$site["url"]?>res/css/base-admin-3.css" rel="stylesheet">
    <link href="<?=$site["url"]?>res/css/base-admin-3-responsive.css" rel="stylesheet">
      
    <link href="<?=$site["url"]?>res/css/base-admin-tweaks.css" rel="stylesheet">
      
    <link href="<?=$site["url"]?>res/css/pages/signin.css" rel="stylesheet" type="text/css">

    

      

      
    <script src="<?=$site["url"]?>res/js/libs/jquery-1.9.1.min.js"></script>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
      <style>
        .account-container h1{
            font-size:23px;
              line-height:35px;
            margin:30px;
            color:#838383;
            font-weight:bold;
        }
          
        .account-container h2{
            font-size:30px; 
              font-weight:bold; 
              color:#F90;
            margin:20px;
        }
          
        .account-container h3{
            font-size:15px;
            margin:20px;
              line-height:23px;
              font-weight:bold;
        }
          
          .coloring{
            display:inline-block;
            color:#F90;    
          }
          
          .account-container .btn-primary{
            padding: 10px 20px;
            font-size: 30px;
          }
          .account-container{width:720px;text-align:center;margin-top:10px;}
          .content{padding-top:0;};
      </style>
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
    <a class="navbar-brand" href="<?=$site["url"]?><?=$getVar?>"><!--<i class="icon-shield"></i> &nbsp;<?=$site["name"]?>-->&nbsp;</a>
  </div>
</div> <!-- /.container -->
</nav>
    
<br>   
    
    
<div class="main">
    <div class="container">
        
      

	
<div class="account-container stacked">
	
	<div class="content clearfix">


            <h1 style="width:600px;"><i class="icon-lightbulb"></i> Learn to Succeed &nbsp; <i class="icon-money"></i> Make Money &nbsp; <i class="icon-thumbs-up"></i> Have Fun!<br></h1>
            <iframe width="640" height="360" src="//www.youtube.com/embed/<?=$splashVideo?>?rel=0&autoplay=1&controls=0&showinfo=0&loop=1" frameborder="0" allowfullscreen></iframe>
        <br><br>
            <a target="_blank" href="<?=$site['url'].$getVar?>"><input type="submit" value='Join In Now' name="submit" class="btn btn-primary"></a>
            
            <h2>What is this all about?</h2>
            <h3>
                Surf Savant is a finely tuned learning tool for anyone who wants to build an online business. It’s a smart system to grow your down lines and your earning potential. We also do our best to make this experience as fun and effortless as possible.
            </h3>
            <h2>I can make money?</h2>
            <h3>Of course you can make money as a Surf Savant. We've got prizes and contests with a huge amount of opportunities to win cash. In addition, you can also promote our awesome tool, and you earn commissions for others' purchases.</h3>
        </div> <!-- /error-container -->			
        
    </div> <!-- /span12 -->
    
</div> <!-- /row -->

        
        
            
    
        
    </div>
</div>


<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?=$site["url"]?>res/js/libs/jquery-ui-1.10.0.custom.min.js"></script>
<script src="<?=$site["url"]?>res/js/libs/bootstrap.min.js"></script>

  </body>
</html>