<?php
include 'home.php'; exit;
if(!$db->query("SELECT `id` FROM `users` WHERE `id` = '{$usr->data->id}' && `loginOffer` < NOW() - INTERVAL 1 DAY")->getNumRows())
{
    include 'home.php'; 
    exit;
}
$db->query("UPDATE `users` SET `loginOffer` = NOW() WHERE `id` = '{$usr->data->id}'");
?>
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
            font-size:40px;
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
        <div class="header"></div>
        <div class="commonFormWrapper">
            <div style="width:650px;" class="form commonForm wrapper2">
            <div class="ribbon-wrapper-green"><div class="ribbon-green">SPECIAL OFFER</div></div>
               <div style="width:100%; background: url(http://techdime.com/bday.jpg); height:370px; background-position:center; background-size:100%;"></div>
                
                
                
                <h1>The Top Premium Upgrade For Only $40 a Year!</h1>
                <div class="box">
                    <h3>
                        <font color="c74e4e" >Yes!</font> Daniel, I want to take advantage of this crazy offer and save over 60%.<br><br>
                        <?php $subscription = 32; ?>
                        <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_xclick-subscriptions">
                            <input type="hidden" name="a3" value="<?=$packages[$subscription]["price"]?>">
                            <input type="hidden" name="p3" value="1">
                            <input type="hidden" name="t3" value="Y">
                            <input type="hidden" name="src" value="1">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="item_name" value="<?=$site["name"]?> Platinum Annual Upgrade">
                            <input type="hidden" name="item_number" value="<?=$subscription?>">
                            <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                            <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                            <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                            <input type="hidden" name="return" value="<?=$site["url"]?>">
                            <input type="submit" value='Upgrade Now' name="submit">
                        </form>
                    </h3>
                </div>
                
                <h1>5000 Credits For Only $4!</h1>
                <div class="box">
                    <h3>
                        <font color="c74e4e" >Yes!</font> Daniel, I want to take advantage of this crazy offer and save over 70%.<br><br>
                        <?php
                        $key = 30;
                        $value = (array) $db->query("SELECT * FROM `packages` WHERE `id` = '{$key}'")->getNext();
                        ?>
                        <form target="_blank" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="amount" value="<?=$value["price"]?>">
                            <input type="hidden" name="rm" value="1">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="item_name" value="<?=number_format($value["value"])?> <?=$site["name"]?> Credits">
                            <input type="hidden" name="item_number" value="<?=$key?>">
                            <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                            <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                            <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                            <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                            <input type="submit" value='Purchase Now' name="submit">
                        </form> 
                    </h3>
                </div>
                
                <h1>50,000 Credits For Only $40!</h1>
                <div class="box">
                    <h3>
                        <font color="c74e4e" >Yes!</font> Daniel, I want to take advantage of this crazy offer and save over 65%.<br><br>
                        <?php
                        $key = 30;
                        $value = (array) $db->query("SELECT * FROM `packages` WHERE `id` = '{$key}'")->getNext();
                        ?>
                        <form target="_blank" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                            <input type="hidden" name="cmd" value="_xclick">
                            <input type="hidden" name="amount" value="<?=$value["price"]?>">
                            <input type="hidden" name="rm" value="1">
                            <input type="hidden" name="no_note" value="1">
                            <input type="hidden" name="no_shipping" value="1">
                            <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                            <input type="hidden" name="currency_code" value="USD">
                            <input type="hidden" name="item_name" value="<?=number_format($value["value"])?> <?=$site["name"]?> Credits">
                            <input type="hidden" name="item_number" value="<?=$key?>">
                            <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                            <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                            <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                            <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                            <input type="submit" value='Purchase Now' name="submit">
                        </form> 
                    </h3>
                </div>
                
                
                <br><br><a href="<?=$site['url']?>home">No Thanks, I know these are great values but not today.</a>
            </div>
        </div>
    </div>
</body>
</html>