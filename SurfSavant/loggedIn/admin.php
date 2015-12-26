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
                    <li class="active"><a href="<?=$site['url']?>admin">Stats</a></li>
                    <li><a href="<?=$site['url']?>admin-newsletter">Newsletter</a></li>
                    <li><a href="<?=$site['url']?>admin-users">Manage Users</a></li>
                    <li><a href="<?=$site['url']?>admin-report">Ban Website</a></li>
                    <li><a href="<?=$site['url']?>admin-sales">Sales</a></li>
                </ul>
                
                <br>
                
                <p><?=str_replace("<br><br><br>", "<hr>", str_replace("<hr>", "", file_get_contents('http://brisksurf.com/profitMBDH.php')))?></p>
            </div>
        </div>
    </div>
</div>
<?php } else include 'loggedIn/admin-signin.php'; include 'footer.php'; ?>