<?php
if($usr->data->tourCompleted != "0000-00-00 00:00:00" && $getVar != 'tourContinue')
{
    $tourAutostart = false;
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Let's go!</strong> To continue to the next step of the tour, view all the paid to click advertisements available to you and then return to your dashboard. Click <a href='javascript:tourGuide.start();'>here</a> to show this step of the tour again.
            </div>
        </div>
    </div>
    <?php
}
if($usr->data->tourType == 1)
{
    if($getVar == 'tourContinue')
    {
        $tour = '[".tourStop1", "top", "Once you complete a view, it will turn green so you can keep track of your progress. Pretty simple right?"]'
        . ', ["", "center", "To continue to the next step of the tour and learn how you can earn even more, view all the paid to click advertisements available to you and then return to your dashboard.<br><br><form method=\'post\' action=\'' . $site['url'] . 'ptc\'><input type=\'hidden\' name=\'seenTour\' value=\'1\'><input class=\'form-control\' value=\'Finish\' type=\'submit\'></form>", false]';   
    }
    else
    {
        $tour = '["", "center", "Now’s the fun part. I am going to introduce the paid to click feature."]'
        . ', ["", "center", "If you do not know yet what it means, a PTC allows you to click our members’ advertisements in return for up to one cent per click."]'
        . ', ["", "center", "You know what rocks even more? Every day at midnight, the ads will reset and you can click them again for more cash."]'
        . ', [".tourStop1", "top", "Let’s take a look at the BriskSurf advertisement as an example. Click on it to begin.", false, 300, function() { $(\'.tourStop1\').attr(\'href\', \'' . $site['url']  . 'ptcview/t\'); }]';
    }
}

?>