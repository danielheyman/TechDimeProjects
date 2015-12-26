<?php if($usr->data->registeredOffer != "1") { include 'home.php'; exit; } ?>
<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=$site["url"]?>loggedOut/style.css">
    <link rel="icon" type="image/png" href="<?=$site["url"]?>favicon.ico">
    <script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
    <title><?=$site["name"]?></title>
    <meta name="description" content="<?=$site["description"]?>" />
    <style>
        #header,#bgGrey{min-width:700px;}
        #header .logo,#content{width:700px;}
        
        .wrapper2 {
          border-radius: 10px;
          position: relative;
            margin:0;
            padding:0;
        }
        
        .ribbon-wrapper-green {
          width: 120px;
          height: 120px;
          overflow: hidden;
          position: absolute;
          top: -8px;
          right: -9px;
          z-index: 90;
            
        }
        
        .ribbon-green {
          font: bold 14px Sans-Serif;
          color: #333;
          text-align: center;
          text-shadow: rgba(255,255,255,0.5) 0px 1px 0px;
          -webkit-transform: rotate(45deg);
          -moz-transform:    rotate(45deg);
          -ms-transform:     rotate(45deg);
          -o-transform:      rotate(45deg);
          position: relative;
          padding: 7px 0;
          left: -10px;
          top: 35px;
          width: 160px;
          background-color: #c74e4e;
          background-image: -webkit-gradient(linear, left top, left bottom, from(#BFDC7A), to(#8EBF45)); 
          background-image: -webkit-linear-gradient(top, #c74e4e, #c54545); 
          background-image:    -moz-linear-gradient(top, #c74e4e, #c54545); 
          background-image:     -ms-linear-gradient(top, #c74e4e, #c54545); 
          background-image:      -o-linear-gradient(top, #c74e4e, #c54545); 
          color: #fff;
          -webkit-box-shadow: 0px 0px 5px rgba(0,0,0,0.7);
          -moz-box-shadow:    0px 0px 5px rgba(0,0,0,0.7);
          box-shadow:         0px 0px 5px rgba(0,0,0,0.7);
        }
        
        .ribbon-green:before, .ribbon-green:after {
          content: "";
          border-top:   3px solid #9f1f1f;   
          border-left:  3px solid transparent;
          border-right: 3px solid transparent;
          position:absolute;
          bottom: -3px;
        }
        
        .ribbon-green:before {
          left: 0;
        }
        .ribbon-green:after {
          right: 0;
        }
        
        h1{
            color:#c74e4e;   
        }
        
        .box{
            margin:20px;
            border:3px dashed #c74e4e;
            padding:20px;
        }
    </style>
</head>
<body>
    <div id="header">
        <div class="logo"><a href="<?=$site["url"]?>"><div class="click"></div></a></div>
    </div>
    <div id="bgGrey"></div>
    <div id="content">
        <div class="header">Special New Member Offer</div>
        <div class="commonFormWrapper">
            <div style="width:650px;" class="form commonForm wrapper2">
            <div class="ribbon-wrapper-green"><div class="ribbon-green">SPECIAL OFFER</div></div>
               <iframe width="640" height="426" src="//www.youtube.com/embed/Sv6LxQARoMk?rel=0&autohide=1&showinfo=0&wmode=transparent&autoplay=1" frameborder="0" allowfullscreen></iframe>
                <h1>Save Over 46% On Monthly Membership!</h1>
                <h3>5,000 Credits per Month<br>50% Commissions<br>3 Credits Per Page View<br>0.5 Credits Per Referral View<br>15 Seconds Viewing Time</h3>
                <h1>Platinum Membership Now Only $7</h1>
                <div class="box">
                    <h3>
                        <font color="c74e4e">Yes!</font> Daniel, I want to take advantage of this crazy offer and get a one year premium upgrade.                           <br><br><br>
                        <font color="c74e4e">$7</font> is too good a deal to pass up!
                        <br><br>
                        <?php $subscription = 28; ?>
                        <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_xclick-subscriptions">
                            <input type="hidden" name="a3" value="<?=$packages[$subscription]["price"]?>">
                            <input type="hidden" name="p3" value="1">
                            <input type="hidden" name="t3" value="M">
                            <input type="hidden" name="src" value="1">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="item_name" value="<?=$site["name"]?> Platinum Monthly Upgrade">
                            <input type="hidden" name="item_number" value="<?=$subscription?>">
                            <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                            <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                            <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                            <input type="hidden" name="return" value="<?=$site["url"]?>">
                            <input type="submit" value='Upgrade Now' name="submit">
                        </form>
                        <br><br>
                        After making the purchase, you will instantly be upgraded to a platinum membership.
                    </h3>
                </div>
                <br><br><a href="<?=$site['url']?>home">No Thanks, I know this is a great value but not today.</a>
            </div>
        </div>
    </div>
</body>
</html>