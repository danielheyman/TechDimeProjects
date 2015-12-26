<style>body{font-family:Frutiger,"Frutiger Linotype",Univers,Calibri,"Gill Sans","Gill Sans MT","Myriad Pro",Myriad,"DejaVu Sans Condensed","Liberation Sans","Nimbus Sans L",Tahoma,Geneva,"Helvetica Neue",Helvetica,Arial,sans-serif;color:#2E3041;} a{ text-decoration:none;color:#4f81bd;} a:hover{color:#2f3840;} button{color:#fff;background:#4f81bd;border:0;padding:10px 20px;cursor:pointer;} button:hover{background:#9cbfea;}</style>
<center>
<?php
include 'cleanConfig.php';
echo "We love giving away badges so we are going to make this one quite easy:<br><br>Fuel your <a target='_blank' href='http://surfsavant.com'>Surf Savant</a> account by surfing the traffic exchanges listed in your dashboard.<br><br>&#9660; &#9660; Badge appears here once the task is completed &#9660; &#9660;";  

if($usr->loggedIn)
{
    $countSites = $db->query("SELECT COUNT(`id`) AS `count` FROM `activitySites` WHERE active != 0")->getNext()->count;
    $countSites2 = $db->query("SELECT COUNT(`id`) AS `count` FROM `shield` WHERE `userid` = '{$usr->data->id}'")->getNext()->count;
    if($countSites == $countSites2)
    {
        ?><br>Woah, you won a <a target="_blank" style="position: relative; top: 45px;" href="http://clicktrackprofit.com/reloaded/ctpis3claimpage.php?bid=5373&key=448d53762e"><img src="http://clicktrackprofit.com/images/ctpthree004.png"></a> (click to claim) <?php
    }
}
else
{
    echo "<br><br>Login to Surf Savant by clicking <a target='_blank' href='http://surfsavant.com'>here</a> to get started.";  
}
?>
</center>



<!--

ON CTP:

<iframe src="http://surfsavant.com/activebadge.php" style="border:0; width:100%; height:300px;margin-top: -30px; background: #FFF; padding: 0 10px; margin-left: -10px;">
</iframe>
<style>table h1, table h3, table b{color:#F90;}.notification{border-color: #2f3840;background: #FFF; box-shadow: 3px 3px 0px #F90; -moz-box-shadow: 3px 3px 0px #F90;-o-box-shadow: 3px 3px 0px #F90; -webkit-box-shadow: 3px 3px 0px #F90;  background: #FFF; }</style>



-->