<?php 
if($usr->loggedIn) {
$pageArray = ["home","home","home","home","home","stocks","stocks","stocks","stocks/1","branding","branding","branding","branding","tutorials/1","video/1","video/1","rotator","rotator","rotator","home"];
$skipArray = [0,0,0,0,0,0,0,0,1,0,0,0,0,0,1,0,0,0,0,0];
$textArray = ["Welcome! Thanks for signing up. I’m here to be your guide, and by the time we’re done, you’ll be a savant.", "This is the Dashboard. You can see your coins and cash, the traffic exchanges you need to surf, as well as your current level.", "To level up, you have to be active. Find the Surf Savant shield at the Traffic Exchanges whose thumbnails are shown every day to remain active. Leveling up gets you a lot of perks, from increased coins per day to more winnings from our games. The best part is that once you complete level 5, you can risk all of your levels for a sweet chance to win $50!", "Now, remember to stay active every day, otherwise you’ll lose your levels and go back to level one! You can use coins to purchase vacation days that allow you to take a day off and still remain active.", "Lets continue the tutorial on other pages. Click next.", "Welcome to the stock market. Here you can buy stocks on various TE’s and profit from their success.", "Here you can see the all of the TE’s in the stock game, and how they’ve changed since yesterday and the week before. Remember, you want to buy low, sell high, so you can make a profit. Buy a stock when you think it’s going to go up, and then sell it when it does for more. You also get daily coins from your stocks, but this pales in comparison to what you could make strategically buying and selling stocks.", "Now, please select the stock for BriskSurf from the dropdown list.", "Now, you can see the graph on how BriskSurf has been doing in the last 15 days. You can see in the box below it that you don’t currently own any stocks. The Buy and the Sell tabs will allow you to buy and sell stocks. Remember, you can only have a maximum of 100 stocks per program.","Hi, now it’s time to take a test. I hope you studied. Nah I’m just kidding. This here is the branding game. Answer questions about people in the industry and win coins and cash.","You’ll be asked a series of questions, 15 in total. For every correct answer, you win coins based on your level, and if you answer any 5 correctly, you get a chance to win some cash.","To have questions about you appear to others, just go to SurfSavant Dashboard, click the three TE icons, and answer 'yes' to the question.","To see how well you’ve been doing once you’ve been added, just click the Stats tab and you’ll see how well you’ve been branding yourself.","Welcome to the tutorial videos page. This is also the basis of our downline builder. Please click on the BriskSurf video in the TE section to continue.","As you can see, the video is broken into pieces. Put it together to get it to start playing. Just click and drag the pieces.","Now, for the downline builder. Just enter your referral id for each program you’re interested in, and all of your referrals will use your referral link when they go to that program. It’s as simple as that.","Welcome to the best way to advertise your websites. Here is how it works:","To add your website to our rotator, just type in the URL and click the add button. Your website will be added to the rotator. Assign coins to it to have it be seen. Remember, it takes 0.1 of a coin for every view your website receives.","You can earn coins by promoting our rotator. For every view it gets under you, you’ll earn .05 coins. All TE’s in our stock game also heavily promote the rotator.","Congratulations! You completed the tutorial. To start the tutorial over simply click your name in the upper righthand corner and click 'Restart Tutorial'."];



$url = $sec->filter($_SERVER['REQUEST_URI']);
$url = explode("?", $url);
$url = $url[0];
$url = str_replace($site["directory"], "", $url);
if($url[strlen($url) - 1] == '/') $url = rtrim($url, '/');
if(strlen($url) != 0 && $url[0] == '/') $url = ltrim($url, '/');
if($url == "") $url = "home";

if($url == "home/resettut")
{
    $db->query("UPDATE `users` SET `tutorial` = 0 WHERE `id` = '{$usr->data->id}'");
    $usr->data->tutorial = 0;
    $url = "home";
}

if((isset($_POST["submitTutorial"]) || (isset($skipArray[$usr->data->tutorial + 1]) && $skipArray[$usr->data->tutorial + 1])) && ((isset($pageArray[$usr->data->tutorial + 1]) && $url == $pageArray[$usr->data->tutorial + 1]) || ($usr->data->tutorial + 1 >= count($pageArray) && $url == "home")))
{
    $db->query("UPDATE `users` SET `tutorial` = `tutorial` + 1 WHERE `id` = '{$usr->data->id}'");
    $usr->data->tutorial += 1;
}
if($usr->data->tutorial < count($pageArray) && ($url == $pageArray[$usr->data->tutorial] || $url == "home")) { ?>
<style>
    .tutorialcontent{
        padding:20px; 
        background:#fff;
        -webkit-border-radius:5px;
        -o-border-radius:5px;
        -moz-border-radius:5px;
        border-radius:5px;
        text-align:center;
        border: 2px solid #F90;
        color: #F90;
        background: #333;
    }
    
    .tutorialcontent p{
        font-size:15px; 
        font-weight:bold;
    }
</style>
<div style="margin-bottom:20px;">
    <img style="position:absolute;" height="100" src="<?=$site['url']?>loggedIn/images/tutorial-owl.png">
    <div style="padding-left:130px; min-height:100px;">
    <div class="tutorialcontent">
        
        <?php 
            if($url == $pageArray[$usr->data->tutorial])
            {
                
                echo "<p>" . $textArray[$usr->data->tutorial] . "</p>";
                ?>
                <form action="<?php echo ($usr->data->tutorial + 1 < count($pageArray)) ? $site['url'].$pageArray[$usr->data->tutorial + 1]  : $site['url']; ?>" method="post"><input type="submit" value='<?php echo ($usr->data->tutorial + 1 < count($pageArray)) ? "Next" : "Complete Tutorial"; ?>' name="submitTutorial" class="btn btn-primary"></form>	
                <?php
            }
            else{
                ?>
                <p>You have not completed the tutorial, click the next button to continue.</p>
                <a href="<?=$site['url'].$pageArray[$usr->data->tutorial]?>"><input type="submit" value='Next' name="submitTutorial" class="btn btn-primary"></a>
                <?php
            }
        ?> 
        
    </div>
    </div>
</div>
<?php } } ?>