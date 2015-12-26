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
                    <li class="active"><a href="<?=$site['url']?>admin-report">Ban Website</a></li>
                    <li><a href="<?=$site['url']?>admin-sales">Sales</a></li>
                </ul>
                
                <br>
                
                <center>
                <p>Here you can ban a URL from appearing at Surf Savant, BriskSurf, and SurfDuel. This automatically deletes any existing sites that are rotating.</p>
                <br>
                <p>There are a couple of things to note before you ban a URL.</p>
                <br>
                <p>1. Avoid entering http://www. For example. Instead of entering http://www.google.com. Enter google.com.</p>
                <br>
                <p>2. Any URL that contains the parameter you enter will be banned. For example: If you enter surfsavant.com: <br><br> The following will be banned:<br>http://surfsavant.com<br>www.surfsavant.com<br>surfsavant.com/refurl<br>And surfsavant.com itself<br><br>The following will not be banned:<br>savant.com</p>
                <br><br>
                <p>Pass: Our Pass</p>
                <iframe style="width:100%; height:70px;" src="http://techdime.com/report.php"></iframe>
                </center>
            </div>
        </div>
    </div>
</div>
<?php } else include 'loggedIn/admin-signin.php'; include 'footer.php'; ?>