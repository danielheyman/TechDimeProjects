<?php include 'header.php'; ?>
<div id="scrollingbg">&nbsp;</div>
<div id="scrolling">
<?php
    $query = $db->query("SELECT `amount`, TIME_TO_SEC(TIMEDIFF(NOW(), (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`))) AS `time`, (SELECT `item_name` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`) AS `type`, (SELECT `fullName` FROM `users` WHERE `users`.`id` = `commissions`.`userid`) AS `name` FROM `commissions` WHERE `amount` >= 0.01 ORDER BY ID DESC LIMIT 10");
    while($prize = $query->getNext())
    {
        $name = explode(" ", $prize->name)[0];
        $type = $prize->type;
        
        echo "<div class='spot'>{$name} won $" . $prize->amount . " from {$type}!</div>";
    }
?>
</div>
<script>
$(document).ready(function() {
setTimeout(function(){
setInterval(function(){
    $("#scrolling").scrollLeft($("#scrolling").scrollLeft() + 1);
    if($("#scrolling").scrollLeft() >= $("#scrolling .spot").outerWidth( true ))
    {
        $("#scrolling").append("<div class='spot'>" + $('#scrolling .spot').html() + "</div>");
        $('#scrolling .spot').first().remove();
        $("#scrolling").scrollLeft(0);
    }
}, 20);
}, 500);
});
</script>
<div class="row">
    <div class="col-md-12">
        <div id="websiteTitle">Learn to Succeed<div class="period">.</div> Make Money<div class="period">.</div> Have Fun<div class="period">.</div></div>
    </div>
    <div class="col-md-4">
        <div class="grayboxing">
            <div class="lightbulb"><i class="icon-lightbulb"></i></div>
            <div class="line">&nbsp;</div>
            <div class="description">
                We will show you how to build your online business from the ground up. We have a wide range of tools that will not only introduce you to the countless programs that can push your success, but we will also assist you in building a greatly profitable downline network. To make the package even sweeter, we will help brand your online business.
            </div>
            <a href="<?=$site['url']?>register"><div class="button">What are you waiting for?<br><div class="bolding">Let's Succeed!</div></div></a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="blueboxing">
            <div class="money"><i class="icon-money"></i></div>
            <div class="line">&nbsp;</div>
            <div class="description">
                We want you to feel welcomed into the Surf Savant community so we made sure that you can jump into making money right from day one. Between our paid to click feature, our contests, and our many daily tasks, you will never be done earning your style. We are putting the decision in your hands to test your limits and see how much you want to earn.
            </div>
            <a href="<?=$site['url']?>register"><div class="button">What are you waiting for?<br><div class="bolding">Let's Make Money!</div></div></a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="grayboxing">
            <div class="thumbsup">&nbsp;</div>
            <div class="line">&nbsp;</div>
            <div class="description">
                We believe that success, money, and fame are of little importance if they do not come with a little fun. You can play our multitude of games. Not only will you be able to put your skillset to the test, but you will also be able to invest in virtual stocks and have a great time with the super amazing members of the Surf Savant community. It is one great ride!
            </div>
            <a href="<?=$site['url']?>register"><div class="button">What are you waiting for?<br><div class="bolding">Let the Fun Begin!</div></div></a>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>