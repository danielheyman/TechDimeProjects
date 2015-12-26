<?php if(!($usr->data->brandingWins >= 5 && $usr->data->brandingTries >= 15)) include 'loggedIn/home.php'; else { ?>
<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="widget stacked" id="old">
            <div class="widget-header">
                <i class="icon-gamepad"></i>
                <h3>Card Game</h3>
            </div>
            <div class="widget-content" id="width-widget">
                <?php if($getVar) { 
    
                $rand = rand(1,10);
            
                if($rand == 1) $prize = .03;
                else if($rand < 5) $prize = .02;
                else if($rand >= 5) $prize = .01;
                
                $db->query("UPDATE `users` SET `brandingWins` = 0 WHERE `id` = '{$usr->data->id}'");
                
                $db->query("INSERT INTO `transactions` (`id`, `userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES (NULL, '0', '-1', 'Branding Cash Bonus', '', '0', CURRENT_TIMESTAMP)");   
                $id = $db->insertID;
                $db->query("INSERT INTO `commissions` (`id`, `userid`, `transactionid`, `amount`, `status`) VALUES (NULL, '{$usr->data->id}', '{$id}', '{$prize}', '1')"); 
                ?>
                <center>
                    <b>Woah!</b> Flip your card to see how much you won!<br><br>
                    <div id="myCard" class="flip-container" ontouchstart="this.classList.toggle('hover');">
                        <div class="flipper">
                            <div class="front">
                                &nbsp;
                            </div>
                            <div class="back">
                                $<?=$prize?>
                            </div>
                        </div>
                    </div>
                    <style>
                        /* entire container, keeps perspective */
                        
                        .flip-container, .front, .back {
                            width: 300px;
                            height: 375px;
                            border-radius:10px;
                            -moz-border-radius:10px;
                            -webkit-border-radius:10px;
                        }
                        
                        .front{
                            background:url(<?php 
                            $cards = ["club", "diamond", "spade", "heart"]; 
                            shuffle($cards);
                            echo "{$site['url']}loggedIn/images/{$cards[0]}.png";
                            ?>);    
                            background-size:cover;
                        }
                        
                        .back{
                            background:#F90;
                            color:#fff;
                            line-height:375px;
                            text-align:center;
                            font-size:30pt;
                            font-weight:bold;
                            border:3px solid #000;
                        }
                        
                        .flip-container {
                            perspective: 1000;
                        }
                        /* flip the pane when hovered */
                        .flip-container:hover .flipper, .flip-container.hover .flipper {
                            -webkit-transform: rotateY(180deg);
                            -moz-transform: rotateY(180deg);
                            transform: rotateY(180deg);
                        }
                        
                        /* flip speed goes here */
                        .flipper {
                            -webkit-transition: 1s;
                            -webkit-transform-style: preserve-3d;
                
                            -moz-transition: 1s;
                            -moz-transform-style: preserve-3d;
                
                            transition: 1s;
                            transform-style: preserve-3d;
                        
                            position: relative;
                        }
                        
                        /* hide back of pane during swap */
                        .front, .back {
                            -webkit-backface-visibility: hidden;
                            -moz-backface-visibility: hidden;
                            backface-visibility: hidden;
                        
                            position: absolute;
                            top: 0;
                            left: 0;
                        }
                        
                        /* front pane, placed above back */
                        .front {
                            z-index: 2;
                        }
                        
                        /* back, initially hidden pane */
                        .back {
                            -webkit-transform: rotateY(180deg);
                            -moz-transform: rotateY(180deg);
                            transform: rotateY(180deg);
                        }
                        
                        .flip-container:hover .flipper, .flip-container.hover .flipper, .flip-container.flip .flipper {
                            -webkit-transform: rotateY(180deg);
                            -moz-transform: rotateY(180deg);
                            transform: rotateY(180deg);
                        }
                        
                        .flipit {
                            -webkit-transform: rotateY(180deg);
                            -moz-transform: rotateY(180deg);
                            transform: rotateY(180deg);
                        }
                    </style>
                </center>
                <?php } else { ?>
                <center><b>Congratulations!</b> You have a chance to win a cash prize. Choose a card below. Each card has a different cash amount hidden inside of it, choose wisely :)</center>
                <br><br>
                <center style="margin-left:-50px;">
                       <style>
                        .card{
                            position:relative;
                            width:150px;
                            height:220px;
                            margin-right:-75px;
                            transition: all .8s;
                            -webkit-transition: all .8s;
                            -moz-transition: all .8s;
                            -o-transition: all .8s;
                        }
                        .card1{
                            z-index:1;
                            transform:rotate(-30deg);
                            -ms-transform:rotate(-30deg); /* IE 9 */
                            -webkit-transform:rotate(-30deg); /* Safari and Chrome */
                            left:35px;
                            top:20px;
                            margin-top:0;
                        }
                        .card2{
                            z-index:2;
                            transform:rotate(-10deg);
                            -ms-transform:rotate(-10deg); /* IE 9 */
                            -webkit-transform:rotate(-10deg); /* Safari and Chrome */
                            top:-15px;
                            left: 25px;
                            margin-top:15px;
                        }
                        .card3{
                            z-index:3;
                            transform:rotate(15deg);
                            -ms-transform:rotate(15deg); /* IE 9 */
                            -webkit-transform:rotate(15deg); /* Safari and Chrome */
                            top:-15px;
                            left:25px;
                            margin-top:15px;
                        }
                        .card4{
                            z-index:4;
                            z-index:3;
                            transform:rotate(37deg);
                            -ms-transform:rotate(37deg); /* IE 9 */
                            -webkit-transform:rotate(37deg); /* Safari and Chrome */
                            margin-right:0;
                            top:20px;
                            left:20px;
                            margin-top:20px;
                        }
                        .card:hover{
                            top:-50px;
                    
                        }
                        .card1:hover{
                            left:-5px;
                        }
                        .card4:hover{
                            left:80px;
                        }
                        .card2:hover, .card3:hover{
                            top:-75px;
                        }
                        .card2:hover{
                            left:0;
                        }
                        .card3:hover{
                            left:45px;
                        }
                    </style>
                                        <br><br>
                    <a href="<?=$site['url']?>card/club"><img class="card card1" src="<?=$site['url']?>loggedIn/images/back.jpg"></a>
                    <a href="<?=$site['url']?>card/club"><img class="card card2" src="<?=$site['url']?>loggedIn/images/back.jpg"></a>
                    <a href="<?=$site['url']?>card/club"><img class="card card3" src="<?=$site['url']?>loggedIn/images/back.jpg"></a>
                    <a href="<?=$site['url']?>card/club"><img class="card card4" src="<?=$site['url']?>loggedIn/images/back.jpg"></a>
                    <br><br><br><br>
                </center>
            <?php } ?>
            </div>
        </div>
    </div>
    <!--
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-gamepad"></i>
                <h3>Pick a Card</h3>
            </div>
            <div class="widget-content">
                
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <h4>How it works</h4>
            <p>Buy stocks in your favorite TE and sell them for profit. Every day that you are active, you will earn up to 3%, depending on your level, of the worth of every stock that you own.</p>
        </div>				
    </div>
    -->
</div>
<?php include 'footer.php'; } ?>