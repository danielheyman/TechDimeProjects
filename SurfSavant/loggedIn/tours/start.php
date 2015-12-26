<?php
if($usr->data->tourCompleted != "0000-00-00 00:00:00")
{
    $tourAutostart = false;
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Let's go!</strong> To continue on with the tour, fuel your account by finding the shield in all the traffic exchanges. Come back when your experience has started to fill up your leveling tube. Click <a href='javascript:tourGuide.start();'>here</a> to show this step of the tour again.
            </div>
        </div>
    </div>
    <?php
}
if($usr->data->tourType == 1)
{
    $tour = '["", "center", "So you like making money? Of course you do, and that is what we are here for. Before we dive into our Paid to Click feature and all the other ways you can grow your earnings potential, we need to begin talking about activity websites.", true, 500]'
    . ',["", "center", "The Surf Savant activity websites fuel your account and are the basis for keeping your account in a healthy condition. Remaining active has great rewards such as but not limited to getting referral earnings, playing our amazing games for chances to win even more rewards, and leveling up.", true, 500]'
    . ',["", "center", "But we both know that all that goodness means nothing to you without some prizes. While going through the process of remaining active, you will find cash prizes and when you complete level 5, you will have a chance to win $50.", true, 500]'
    . ',[".tourStop1", "right", "So now you might be wondering, what in the world is leveling up? Glad you asked, first off you begin at level 1."]'
    . ',[".tourStop2", "top", "Every day you are active, you will gain experience that will fill up this tube with a green liquid. Reach the end, and you level up."]'
    . ',[".tourStop3", "left", "Simple enough, eh? Now let me explain how you can remain active. To the right is what we call a traffic exchange. You must surf the sites found here before midnight every day to remain active.", true, 500]'
    . ',[".tourStop3", "left", "We have hidden a Surf Savant shield in the traffic exchange that looks like this:<br><br><center><img src=\'' . $site['url']  . 'res/img/shield.png\' height=\'130\' width=\'120\'></center><br>You will find it while you surf and all you have to do is claim it. I will give you one clue, keep your eyes peeled around 27 pages."]'
    . ',[".tourStop4", "top", "This tube lets you know when you find the shield. It will get filled with a green liquid when you claim the shield. You have to fill in all the tubes below to remain active."]'
    . ', ["", "center", "And that’s how you fuel your Surf Savant account. But don’t forget, if you continue surfing even after finding the shields, you will find some awesome cash prizes.", true, 500]'
    . ', ["", "center", "The next step in our tour is what you have been waiting for, our paid to click feature. To continue on, remain active and come back here when your experience has started to fill up your leveling tube.<br><br><form method=\'post\'><input type=\'hidden\' name=\'seenTour\' value=\'1\'><input class=\'form-control\' value=\'Finish\' type=\'submit\'></form>", false, 500]';
}
else if($usr->data->tourType == 2)
{
    $tour = '["", "center", "So you want to build your website and gain exposure? Of course you do, and that is what we are here for. Before we dive into our Traffic Rotator feature and all the other ways you can funnel in members to your website, we need to begin talking about activity websites.", true, 500]'
    . ',["", "center", "The Surf Savant activity websites fuel your account and are the basis for keeping your account in a healthy condition. Remaining active will allow you to get traffic much faster to your website as it will expand your potential to earn coins and cash.", true, 500]'
    . ',["", "center", "Coins will allow you get exposure through the Traffic Rotator, which is seen through websites across the web. Cash will allow you to advertise through features such as our Paid to Click, giving you a chance to present your website to all our members.", true, 500]'
    . ',[".tourStop1", "right", "So what the heck does remaining active have to do with this? Fair question, as you remain active you level up, and the higher level you are the more gifts we give you. First off you begin at level 1."]'
    . ',[".tourStop2", "top", "Every day you are active, you will gain experience that will fill up this tube with a green liquid. Reach the end, and you level up."]'
    . ',[".tourStop3", "left", "Simple enough, eh? Now let me explain how you can remain active. To the right is what we call a traffic exchange. You must surf the sites found here before midnight every day to remain active.", true, 500]'
    . ',[".tourStop3", "left", "We have hidden a Surf Savant shield in the traffic exchange that looks like this:<br><br><center><img src=\'' . $site['url']  . 'res/img/shield.png\' height=\'130\' width=\'120\'></center><br>You will find it while you surf and all you have to do is claim it. I will give you one clue, keep your eyes peeled around 27 pages."]'
    . ',[".tourStop4", "top", "This tube lets you know when you find the shield. It will get filled with a green liquid when you claim the shield. You have to fill in all the tubes below to remain active."]'
    . ', ["", "center", "And that’s how you fuel your Surf Savant account. But don’t forget, if you continue surfing even after finding the shields, you will build up your credits at these traffic exchanges, giving you a chance to add in your own website and present it to others. We also thought we would throw in a little cash bonuses as you surf along.", true, 500]'
    . ', ["", "center", "The next step in our tour is what you have been waiting for, our Traffic Rotator feature. To continue on, remain active and come back here when your experience has started to fill up your leveling tube.<br><br><form method=\'post\'><input type=\'hidden\' name=\'seenTour\' value=\'1\'><input class=\'form-control\' value=\'Finish\' type=\'submit\'></form>", false, 500]';
}
else if($usr->data->tourType == 3)
{
    $tour = '["", "center", "So you want to build your list and gain exposure? Of course you do, and that is what we are here for. Before we dive into our Branding Game feature and all the other ways you can build your list, we need to begin talking about activity websites.", true, 500]'
    . ',["", "center", "The Surf Savant activity websites fuel your account and are the basis for keeping your account in a healthy condition. Remaining active will allow you to be displayed in our Branding Game. In addition, it will allow you to brand yourself faster as it will expand your potential to earn coins and cash.", true, 500]'
    . ',["", "center", "Coins will allow you get exposure through the Traffic Rotator, which is seen through websites across the web. Cash will allow you to advertise yourself through features such as our Paid to Click, giving you a chance to present a portfolio about yourself to all our members.", true, 500]'
    . ',[".tourStop1", "right", "So what the heck does remaining active have to do with this? Fair question, as you remain active you level up, and the higher level you are the more gifts we give you. First off you begin at level 1."]'
    . ',[".tourStop2", "top", "Every day you are active, you will gain experience that will fill up this tube with a green liquid. Reach the end, and you level up."]'
    . ',[".tourStop3", "left", "Simple enough, eh? Now let me explain how you can remain active. To the right is what we call a traffic exchange. You must surf the sites found here before midnight every day to remain active.", true, 500]'
    . ',[".tourStop3", "left", "We have hidden a Surf Savant shield in the traffic exchange that looks like this:<br><br><center><img src=\'' . $site['url']  . 'res/img/shield.png\' height=\'130\' width=\'120\'></center><br>You will find it while you surf and all you have to do is claim it. I will give you one clue, keep your eyes peeled around 27 pages."]'
    . ',[".tourStop4", "top", "This tube lets you know when you find the shield. It will get filled with a green liquid when you claim the shield. You have to fill in all the tubes below to remain active."]'
    . ', ["", "center", "And that’s how you fuel your Surf Savant account. But don’t forget, if you continue surfing even after finding the shields, you will build up your credits at these traffic exchanges, giving you a chance to add in a page about yourself and present it to others. We also thought we would throw in a little cash bonuses as you surf along.", true, 500]'
    . ', ["", "center", "The next step in our tour is what you have been waiting for, our Branding Game feature. To continue on, remain active and come back here when your experience has started to fill up your leveling tube.<br><br><form method=\'post\'><input type=\'hidden\' name=\'seenTour\' value=\'1\'><input class=\'form-control\' value=\'Finish\' type=\'submit\'></form>", false, 500]';
}
else if($usr->data->tourType == 4)
{
    $tour = '["", "center", "So you know you own the best traffic exchange in the world and it would be a huge hit if you could simply expose it? Of course you do, and that is what we are here for. We have many features that can help you funnel in members and traffic to your traffic exchange but the most prominent of them are the activity websites.", true, 500]'
    . ',["", "center", "The Surf Savant activity websites fuel your account and are the basis for keeping your account in a healthy condition. Remaining active will allow you to get new members to your traffic exchange much faster as it will expand your potential to earn coins and cash.", true, 500]'
    . ',["", "center", "How exactly? Coins will allow you get exposure through the Traffic Rotator, which is seen through websites across the web. Cash will allow you to advertise through features such as our Paid to Click, giving you a chance to present your website to all our members.", true, 500]'
    . ',[".tourStop1", "right", "So what the heck does remaining active have to do with this? Fair question, as you remain active you level up, and the higher level you are the more gifts we give you. First off you begin at level 1."]'
    . ',[".tourStop2", "top", "Every day you are active, you will gain experience that will fill up this tube with a green liquid. Reach the end, and you level up."]'
    . ',[".tourStop3", "left", "Simple enough, eh? Now let me explain how you can remain active. To the right is a traffic exchange (keep on reading and we will show you how to add yours). You must surf the sites found here before midnight every day to remain active.", true, 500]'
    . ',[".tourStop3", "left", "We have hidden a Surf Savant shield in the traffic exchange that looks like this:<br><br><center><img src=\'' . $site['url']  . 'res/img/shield.png\' height=\'130\' width=\'120\'></center><br>You will find it while you surf and all you have to do is claim it. I will give you one clue, keep your eyes peeled around 27 pages."]'
    . ',[".tourStop4", "top", "This tube lets you know when you find the shield. It will get filled with a green liquid when you claim the shield. You have to fill in all the tubes below to remain active."]'
    . ', ["", "center", "And that’s how you fuel your Surf Savant account. But don’t forget, if you continue surfing even after finding the shields, you will build up your credits at these traffic exchanges, giving you a chance to add in yours and present it to others. We also thought we would throw in a little cash bonuses as you surf along.", true, 500]'
    . ', ["", "center", "In the next step of the tour we will show you how to add in your own exchange. But before we show you what you are getting into, we want you to test us out and remain active. Come back here when your experience has started to fill up your leveling tube.<br><br><form method=\'post\'><input type=\'hidden\' name=\'seenTour\' value=\'1\'><input class=\'form-control\' value=\'Finish\' type=\'submit\'></form>", false, 500]';
}
?>