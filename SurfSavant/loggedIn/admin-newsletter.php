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
else if(isset($_POST['newsletter']) && $_POST['preview'] != '2')
{
    $newsletter_sending = true;
    $newsletter_website = $sec->post('website');
    $newsletter_subject = $_POST['subject'];
    $newsletter_message = $sec->closetags($_POST['message']);
    $newsletter_preview = ($_POST['preview'] == '0') ? true : false;
    include 'adminContent/email.php';
    if($_POST['preview'] == '0')
    {
        echo "<br><br><center><form method='post'><input name='website' type='hidden' value='{$newsletter_website}'><textarea name='subject' style='display:none;'>{$newsletter_subject}</textarea><textarea name='message' style='display:none;'>{$newsletter_message}</textarea><input name='preview' type='hidden' value='1'><input name='newsletter' type='submit' value='SEND NOOWWW'></form> <form method='post'><input name='website' type='hidden' value='{$newsletter_website}'><textarea name='subject' style='display:none;'>{$newsletter_subject}</textarea><textarea name='message' style='display:none;'>{$newsletter_message}</textarea><input name='preview' type='hidden' value='2'><input name='newsletter' type='submit' value='HELL NO'></form></center><br><br>";
        exit;
    }
    else
    {
        header( 'Location: ' . $site['url'] . 'admin-newsletter/sentNewsletter' );
        exit;
    }
}
else if(isset($_COOKIE['admin_control']) && $_COOKIE['admin_control'] == 'enabled')
{
    setcookie("admin_control", "enabled", time()+60*60*24*1,"/");   
}

include 'header.php';  
if($getVar == 'sentNewsletter')
{
    ?>
    <div class="row"><div class="col-md-12">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Well done!</strong> The newsletter has been sent out.
        </div>
    </div></div>
    <?php   
}

if(isset($_COOKIE['admin_control']) && $_COOKIE['admin_control'] == 'enabled')
{
?>
<style>
.well hr{
    border: 1px solid #d9d9d9;
}
    
.jqte
{
    margin:0;   
}
    
.jqte .jqte_editor{
    min-height:200px;
}
</style>
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
                    <li class="active"><a href="<?=$site['url']?>admin-newsletter">Newsletter</a></li>
                    <li><a href="<?=$site['url']?>admin-users">Manage Users</a></li>
                    <li><a href="<?=$site['url']?>admin-report">Ban Website</a></li>
                    <li><a href="<?=$site['url']?>admin-sales">Sales</a></li>
                </ul>
                
                <br>
                
                <b><center>You do not need to include the 'Wishing you success' or the 'Hi Name' part of the message as it is included automatically. Simply write the body of the email.</center></b><br>
                <form method="post" class="form-horizontal col-md-12">
                    <fieldset>
                        <input name='preview' type='hidden' value='0'>
                        
                        <div class="form-group">											
                            <label for="website" class="col-md-2">Website</label>
                            <div class="col-md-10">
                                <select name="website" type="text" class="form-control">
                                    <option value="1" <?php if(isset($_POST['newsletter']) && $_POST['preview'] == '2' && $sec->post('website') == '1') echo 'selected'; ?>>Surf Savant</option>
                                    <option value="2" <?php if(isset($_POST['newsletter']) && $_POST['preview'] == '2' && $sec->post('website') == '2') echo 'selected'; ?>>BriskSurf</option>
                                    <option value="3" <?php if(isset($_POST['newsletter']) && $_POST['preview'] == '2' && $sec->post('website') == '3') echo 'selected'; ?>>SurfDuel</option>
                                </select>
                            </div>				
                        </div>
                        
                        <div class="form-group">											
                            <label for="subject" class="col-md-2">Subject</label>
                            <div class="col-md-10">
                                <input name="subject" type="text" class="form-control" value="<?php if(isset($_POST['newsletter']) && $_POST['preview'] == '2') echo $_POST['subject']; ?>">
                            </div>				
                        </div>
                        
                        <div class="form-group">											
                            <label for="message" class="col-md-2">Message</label>
                            <div class="col-md-10">
                                <textarea id="textarea" rows="10" name="message" type="text" class="form-control"><?php if(isset($_POST['newsletter']) && $_POST['preview'] == '2') echo $_POST['message']; ?></textarea>
                            </div>				
                        </div>
                        <script>$("#textarea").jqte();</script>
                        
                        <div class="form-group">											
                            <label for="newsletter" class="col-md-2"></label>
                            <div class="col-md-10">
                                <input name="newsletter" type="submit" class="form-control">
                            </div>				
                        </div>
                        
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } else include 'loggedIn/admin-signin.php'; include 'footer.php'; ?>