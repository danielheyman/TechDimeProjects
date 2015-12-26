<?php
include 'home.php'; exit;
if(!$db->query("SELECT `id` FROM `users` WHERE `id` = '{$usr->data->id}' && `loginOffer` < NOW() - INTERVAL 1 DAY")->getNumRows())
{
    include 'home.php'; 
    exit;
}
if($usr->data->membership != "0001")
{
    //include 'home.php'; 
    //exit;
}
$db->query("UPDATE `users` SET `loginOffer` = NOW() WHERE `id` = '{$usr->data->id}'");
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
    <link href="<?=$site["url"]?>res/css/pages/signin.css" rel="stylesheet" type="text/css">

    

      

      
    <script src="<?=$site["url"]?>res/js/libs/jquery-1.9.1.min.js"></script>


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
      <style>
          
        body{      
            background: #efefef;
        }
          
        .account-container h1{
            font-size:45px;
            margin:30px;
            color:#838383;
        }
          
        .account-container h2{
            font-size:30px; 
              font-weight:bold; 
              color:#F90;
            margin-top:40px;
              margin-bottom:20px;
        }
          
        .account-container h3{
            font-size:18px;
            margin:20px;
              line-height:23px;
              font-weight:bold;
        }
          
          .boxing{
              font-size:14px;
              border:3px dashed #F90; 
              width:640px; 
              margin:auto; 
              padding:20px; 
              font-weight:bold;
              background:#fff;
              line-height:20px;
              width:100%;
          }
          
          .coloring{
            display:inline-block;
            color:#F90;    
          }
          
          .account-container{width:720px;text-align:center;margin-top:10px;}
          .content{padding-top:0;}
          
      </style>
  </head>

<body>



    
    
    
    
<div class="main">
    <div class="container">
        
      

	
<div class="account-container stacked">
	
	<div class="content clearfix" style="background:#fff;">


            <!--<h1>Special Halloween Offer!</h1>--><br>
        
               <div style="width:100%; background: url(http://techdime.com/bday.jpg); height:370px; background-position:center; background-size:100%;"></div>
        
            <h2>Annual Upgrade Now Only $40!</h2>
            <div class="boxing">
                <div class="coloring">Yes!</div>, I want to take advantage of this crazy offer and get a year long upgrade. <br><br><br>
                <form target="_blank" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="a3" value="<?=$packages[14]["price"]?>">
                    <input type="hidden" name="p3" value="1">
                    <input type="hidden" name="t3" value="Y">
                    <input type="hidden" name="src" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="<?=$site["name"]?> Annual Pro Upgrade">
                    <input type="hidden" name="item_number" value="14">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success">
                    <input type="submit" value='Upgrade Now' name="submit" class="btn btn-primary">
                </form>	
            </div>
            <br>
            <h2>500 Coins For Only $4!</h2>
            <div class="boxing">
                <div class="coloring">Yes!</div>, I want to take advantage of this crazy offer and get some awesome coins. <br><br><br>
                <form target="_blank" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="amount" value="4.00">
                    <input type="hidden" name="rm" value="1">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="500 Surf Savant Coins">
                    <input type="hidden" name="item_number" value="15">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                    <input type="submit" value='Purchase Now' name="submit" class="btn btn-primary">
                </form>
            </div>
            <br>
            <h2>5000 Coins For Only $40!</h2>
            <div class="boxing">
                <div class="coloring">Yes!</div>, I want to take advantage of this crazy offer and get some awesome coins. <br><br><br>
                <form target="_blank" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="amount" value="40.00">
                    <input type="hidden" name="rm" value="1">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="5000 Surf Savant Coins">
                    <input type="hidden" name="item_number" value="16">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                    <input type="submit" value='Purchase Now' name="submit" class="btn btn-primary">
                </form>
            </div>
            <br><br><a href="<?=$site['url']?>">No Thanks, I know these are great deals but not today.</a>  
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