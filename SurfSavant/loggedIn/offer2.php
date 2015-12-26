<?php if($usr->data->registeredOffer != "1") { include 'home.php'; exit; } ?>
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
            margin:20px;
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
          }
          
          .coloring{
            display:inline-block;
            color:#F90;    
          }
          
          .account-container{width:720px;text-align:center;margin-top:10px;}
          .content{padding-top:0;};
      </style>
  </head>

<body>



    
    
    
    
<div class="main">
    <div class="container">
        
      

	
<div class="account-container stacked">
	
	<div class="content clearfix">


            <h1>Special New Member Offer!</h1>
            
            <iframe width="640" height="360" src="//www.youtube.com/embed/KU8l-8QGfUE?rel=0&autohide=1&showinfo=0&wmode=transparent&autoplay=1" frameborder="0" allowfullscreen></iframe>
            
            <h2>Save Over 20% On Monthly Membership!</h2>
            <h3>
                20% Referral Earnings<br>
                30% Commissions<br>
                Fast Rotator Traffic<br>
                5 Monthly Vacation Days<br>
                100 Monthly Coins<br>
                Exclusive Splash Pages<br>
                Exclusive Tutorial Series<br>
            </h3>
            <h2>Pro Membership Now Only $7</h2>
            <div class="boxing">
                <div class="coloring">Yes!</div> Matt, I want to take advantage of this crazy offer and get a one month pro upgrade. <br><br>
                <div class="coloring">$7</div> is too good a deal to pass up!<br><br><br>
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <input type="hidden" name="a3" value="<?=$packages[10]["price"]?>">
                    <input type="hidden" name="p3" value="1">
                    <input type="hidden" name="t3" value="M">
                    <input type="hidden" name="src" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="<?=$site["name"]?> Pro Monthly Upgrade">
                    <input type="hidden" name="item_number" value="10">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success">
                    <input type="submit" value='Upgrade Now' name="submit" class="btn btn-primary">
                </form>	
                <br><br>
                After making the purchase, you will instantly be upgraded to a pro membership.
            </div>
            <br><br><a href="<?=$site['url']?>">No Thanks, I know this is a great value but not today.</a>     
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