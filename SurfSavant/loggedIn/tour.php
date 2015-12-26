
<?php

if($getVar == 'resettut')
{
    $db->query("UPDATE `users` SET `tourCompleted` = '0000-00-00 00:00:00', `tourStep` = 'start', `tourType` = '0' WHERE `id` = '{$usr->data->id}'");  
    $usr->getData(); 
    $usr->redirect($site['url']);
}

$tour = false;
$tourAutostart = true;
if($sec->post('tourType'))
{
    $tourType = $sec->post('tourType');
    if($tourType >= 1 && $tourType <= 4)
    {
        $db->query("UPDATE `users` SET `tourType` = '{$tourType}' WHERE `id` = '{$usr->data->id}'");
        $usr->data->tourType = $tourType;
    }
}
else if($sec->post('seenTour') == 1)
{
    $db->query("UPDATE `users` SET `tourCompleted` = NOW() WHERE `id` = '{$usr->data->id}'");
    $usr->getData();
}

if($usr->data->tourCompleted != "0000-00-00 00:00:00") 
{
    $update = "";
    if($usr->data->tourStep == "start")
    {
        if($usr->data->active == "1")
        {
            if($usr->data->tourType == 1) $update = "ptc";
            if($usr->data->tourType == 2) $update = "rotator";
            if($usr->data->tourType == 3) $update = "branding";
            if($usr->data->tourType == 4) $update = "activityBid";
        }
    }
    else if($usr->data->tourStep == "ptc" && $getVar != 'tourContinue')
    {
        if($db->query("SELECT CASE WHEN (SELECT COUNT(`id`) FROM `ptc` WHERE `amount` >= `earn` / 500 && `active` = 1 && `description` != '' && `title` != '') <= (SELECT COUNT(`id`) FROM `ptcviews` WHERE `userid` = '{$usr->data->id}') THEN 'y' ELSE 'n' END AS `completed`")->getNext()->completed == 'y')
        {
            if($usr->data->tourType == 1) $update = "tools";
        }
    }
    if($update != "") $db->query("UPDATE `users` SET `tourCompleted` = '0000-00-00 00:00:00', `tourStep` = '{$update}' WHERE `id` = '{$usr->data->id}'");
    $usr->getData();
}

if($usr->data->tourType == 0 && $thePage == "loggedIn/home.php")
{
    $tour = "[\"\", \"center\", \"Welcome to Surf Savant. We will walk you through the amazing features that we have created just for you! To get started, please choose the option that best describes you:<br><br><form method='post'><input type='hidden' name='tourType' value='1'><input class='form-control' value='I want to increase my online earnings' type='submit'></form><br><form method='post'><input type='hidden' name='tourType' value='2'><input class='form-control' value='I own a website and I want more traffic' type='submit'></form><br><form method='post'><input type='hidden' name='tourType' value='3'><input class='form-control' value='I love building my list and brand' type='submit'></form><br><form method='post'><input type='hidden' name='tourType' value='4'><input class='form-control' value='I am a traffic exchange owner' type='submit'></form>\", false, 400]";
}
else if(($thePage == "loggedIn/{$usr->data->tourStep}.php" && file_exists("loggedIn/tours/{$usr->data->tourStep}.php")) || ($usr->data->tourStep == "start" && $thePage == "loggedIn/home.php")) include "loggedIn/tours/{$usr->data->tourStep}.php";
else if($thePage == "loggedIn/home.php" && file_exists("loggedIn/tours/{$usr->data->tourStep}.php"))
{
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Let's go!</strong> <a href="<?=$site['url'].$usr->data->tourStep?>">Continue</a> the Surf Savant tour now!
            </div>
        </div>
    </div>
    <?php
}
else if($thePage == "loggedIn/home.php")
{
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Stay alert!</strong> We are working hard on building the next step of the tour.
            </div>
        </div>
    </div>
    <?php
}
if($tour)
{
?>
<script>
    var tourGuide;
    $(document).ready(function() {
        tourGuide = new TourGuide("tourGuide", [
            <?=$tour?>
        ], function() {
            
        });
        <?php if($tourAutostart) echo "tourGuide.start();"; ?>
    });
</script>
<?php
}
?>