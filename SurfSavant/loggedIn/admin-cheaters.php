<?php
$hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $sec->cookie("YDSESSION"));
$result = $db->query("SELECT `userid` FROM `sessions` WHERE `hash` = '{$hash}' && `admin` >= 1 && `admin` <= 3 LIMIT 1");
if($usr->data->id > 3 && !$result->getNumRows())
{
    include 'home.php'; 
    exit;
}

if($sec->post('adminSubmitter') == 'MAndDHairs!') 
{
    setcookie("admin_control", "enabled", time()+60*60*24*1,"/");
    $_COOKIE['admin_control'] = "enabled";
}
else if(isset($_COOKIE['admin_control']) && $_COOKIE['admin_control'] == 'enabled')
{
    setcookie("admin_control", "enabled", time()+60*60*24*1,"/");   
}

include 'header.php';  

if(isset($_COOKIE['admin_control']) && $_COOKIE['admin_control'] == 'enabled')
{
?>
<div class="row">
    <div class="col-md-12">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-gear"></i>
                <h3>Administration</h3>
            </div>
            <div class="widget-content">
                <ul class="nav nav-tabs">
                    <li><a href="<?=$site['url']?>admin">Stats</a></li>
                    <li><a href="<?=$site['url']?>admin-newsletter">Newsletter</a></li>
                    <li><a href="<?=$site['url']?>admin-users">Manage Users</a></li>
                    <li><a href="<?=$site['url']?>admin-report">Ban Website</a></li>
                    <li class="active"><a href="<?=$site['url']?>admin-cheaters">Cheaters</a></li>
                </ul>
                
                <br>
                <style>
                .check{
                    padding:15px;
                    margin:5px;
                    border:1px solid #D5D5D5;
                    border-radius:5px;
                    -moz-border-radius:5px;
                    -o-border-radius:5px;
                    -webkit-border-radius:5px;
                    text-align:center;
                }
                    
                .check table{
                    width:100%;
                }
                </style>
                <center>The way it works is when a user is detected as a potential cheater, it will scan all our site databases against the login IP, register IP, and email.</center>
                <br><br>
                <?php
                $checks = $db->query("SELECT * FROM `techdime_cheaters`.`checks` WHERE id > 353");
                if($checks->getNumRows())
                {
                    while($check = $checks->getNext())
                    {
                        if($check->registerIP == "") $check->registerIP = "---";
                        if($check->loginIP == "") $check->loginIP = "---";
                        ?>
                            <div class="check">
                                <?=$check->fullName?> : <?=$check->email?>
                                <br><?=$check->reason?>
                                <hr>
                                <table>
                                    <tr>
                                        <td>Surf Savant:
                                            <?php 
                                            $info = $db->query("SELECT `id`, `email` FROM `users` WHERE `email` = '{$check->email}' || `registerIP` = '{$check->registerIP}' || `loginIP` = '{$check->loginIP}'");
                                            if($info->getNumRows())
                                            {
                                                while($in = $info->getNext())
                                                {
                                                    $type = ($check->email == $in->email) ? 'Email' : 'IP';
                                                    echo "<br><a href='{$site['url']}admin-users/{$in->id}'>ID #{$in->id}</a> ({$type})";
                                                }
                                            }
                                            else echo "<br>No Matches";
                                            ?>
                                        </td>
                                        <td>BriskSurf:
                                            <?php 
                                            $info = $db->query("SELECT `id`, `email` FROM `brisksurf`.`users` WHERE `email` = '{$check->email}' || `registerIP` = '{$check->registerIP}' || `loginIP` = '{$check->loginIP}'");
                                            if($info->getNumRows())
                                            {
                                                echo "<br>Manage Soon";
                                                while($in = $info->getNext())
                                                {
                                                    $type = ($check->email == $in->email) ? 'Email' : 'IP';
                                                    echo "<br><a href='#'>ID #{$in->id}</a> ({$type})";
                                                }
                                            }
                                            else echo "<br>No Matches";
                                            ?>
                                        </td>
                                        <td>SurfDuel:
                                            <?php 
                                            $info = $db->query("SELECT `id`, `email` FROM `surfduel`.`users` WHERE `email` = '{$check->email}' || `registerIP` = '{$check->registerIP}' || `loginIP` = '{$check->loginIP}'");
                                            if($info->getNumRows())
                                            {
                                                echo "<br>Manage Soon";
                                                while($in = $info->getNext())
                                                {
                                                    $type = ($check->email == $in->email) ? 'Email' : 'IP';
                                                    echo "<br><a href='#'>ID #{$in->id}</a> ({$type})";
                                                }
                                            }
                                            else echo "<br>No Matches";
                                            ?>
                                        </td>
                                        <td>Surfing Socially:<br>Coming Soon</td>
                                        <td>ListViral:<br>Coming Soon</td>
                                    </tr>
                                </table>
                                <hr>
                                <a href="#">Not a cheater</a>, coming soon.<br>
                                <a href="#">Ban all accounts listed above</a>, coming soon.<br>
                                <a href="#">Global IP Ban</a>, coming soon.<br>
                                <a href="#">Global Email Ban</a>, coming soon.
                            </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php } else include 'loggedIn/admin-signin.php'; include 'footer.php'; ?>