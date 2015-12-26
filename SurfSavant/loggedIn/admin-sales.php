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


if(isset($_COOKIE['admin_control']) && $_COOKIE['admin_control'] == 'enabled' && $sec->post("loginUser") && $getVar)
{
    
    $hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $sec->cookie("YDSESSION"));
    $admin = ($usr->data->id > 3) ? '' : ", `admin` = {$usr->data->id}";
    $result = $db->query("UPDATE `sessions` SET `userid` = '{$getVar}'{$admin} WHERE `hash` = '{$hash}' LIMIT 1");
    $usr->redirect($site['url'] . 'home'); 
    exit;
}

include 'header.php';  

if(isset($_COOKIE['admin_control']) && $_COOKIE['admin_control'] == 'enabled')
{
?>
<div class="row">
    <div class="col-md-12">
        
        
        <?php
            if($sec->post("name"))
            {
                $name = $sec->post("name");
                $id = $sec->post("id");
                $sale = $sec->post("sale");
                $start = $sec->post("start");
                $end = $sec->post("end");
                $count = $sec->post("count");
                $display = $sec->post("display");
                $text = $sec->post("text");
                if($name == 'new')
                {
                    $type = $sec->post("type");
                    $db->query("INSERT INTO `{$type}`.`sales` (`sale`, `start`, `end`, `count`, `display`, `text`) VALUES ('{$sale}', '{$start}', '{$end}', '{$count}', '{$display}', '{$text}')");   
                }
                else if($name == 'delete')
                {
                    $type = $sec->post("type");
                    $db->query("DELETE FROM `{$type}`.`sales` WHERE `id` = '{$id}'"); 
                }
                else
                {
                    $db->query("UPDATE `{$name}`.`sales` SET `sale` = '{$sale}', `start` = '{$start}', `end` = '{$end}', `count` = '{$count}', `display` = '{$display}', `text` = '{$text}' WHERE `id` = '{$id}'"); 
                }
                $usr->redirect("{$site['url']}admin-sales");
            }
        ?>
        
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
                    <li class="active"><a href="<?=$site['url']?>admin-sales">Sales</a></li>
                </ul>
                
                <br>
                
                <center>
                    <?php 
                    $continue = true;
                    if($getVar)
                    {
                        echo "<a href='{$site['url']}admin-sales'>Return</a><br><br>";
                        $name = $getVar;
                        $website = 'New';
                        $id = '';
                        $sale = '';
                        $start = '';
                        $end = '';
                        $count = '';
                        $display = '';
                        $text = '';
                        $form = true;
                        if($getVar != 'new')
                        {
                            $getVar = explode("-", $getVar);
                            $name = $getVar[0];
                            $id = $getVar[1];
                            if($name == "savant") $website = "SurfSavant";
                            else if($name == "brisk") $website = "BriskSurf";
                            if($name == "savant") $name = "surfsavant";
                            else if($name == "brisk") $name = "brisksurf";
                            $query = $db->query("SELECT * FROM `{$name}`.`sales` WHERE `id` = '{$id}'");
                            if($query->getNumRows())
                            {
                                $query = $query->getNext();
                                $sale = $query->sale;
                                $start = $query->start;
                                $end = $query->end;
                                $count = $query->count;
                                $display = $query->display;
                                $text = $query->text;
                            }
                            else 
                            {
                                echo "Sale not found.";
                                $form = false;
                            }
                        }
                        if($start == "")
                        {
                            $start = $db->query("SELECT NOW() AS `now`")->getNext()->now;
                            $end = $start;
                        }
                        if($form)
                        {
                            ?>
                            <form style="text-align:left;" method="post" id="edit-profile" class="form-horizontal col-md-12">
                                <input name="name" type="hidden" class="form-control" value="<?=$name?>">
                                <input name="id" type="hidden" class="form-control" value="<?=$id?>">
                                <fieldset>
                                    <div class="form-group">											
                                        <label class="col-md-2">Website</label>
                                        <div class="col-md-10">
                                            <?=$website?>
                                        </div>				
                                    </div>
                                    <?php if($name == 'new') { ?>
                                    <div class="form-group">											
                                        <label class="col-md-2">Type</label>
                                        <div class="col-md-10">
                                            <select name="type" class="form-control">
                                                <option value="surfsavant">SurfSavant</option>
                                                <option value="brisksurf">BriskSurf</option>
                                            </select>
                                        </div>				
                                    </div>
                                    <?php } ?>
                                    <div class="form-group">											
                                        <label class="col-md-2">Sale</label>
                                        <div class="col-md-10">
                                            Enter a percent 1 to 100:<br>
                                            <div class="input-group">
                                                <input name="sale" type="text" value="<?=$sale?>" class="form-control">
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>				
                                    </div>
                                    <div class="form-group">											
                                        <label class="col-md-2">Start</label>
                                        <div class="col-md-10">
                                            <input name="start" type="text" class="form-control" value="<?=$start?>">
                                        </div>				
                                    </div>
                                    <div class="form-group">											
                                        <label class="col-md-2">End</label>
                                        <div class="col-md-10">
                                            <input name="end" type="text" class="form-control" value="<?=$end?>">
                                        </div>				
                                    </div>
                                    <div class="form-group">											
                                        <label class="col-md-2">Count</label>
                                        <div class="col-md-10">
                                            Enter a limit for how many times this sales can be used. Enter a large number for unlimited.
                                            <input name="count" type="text" class="form-control" value="<?=$count?>">
                                        </div>				
                                    </div>
                                    <div class="form-group">											
                                        <label class="col-md-2">Countdown</label>
                                        <div class="col-md-10">
                                            <select name="display" class="form-control">
                                                <option value="0" <?php if($display == '0') echo 'selected'; ?>>Don't display anything.</option>
                                                <option value="1" <?php if($display == '1') echo 'selected'; ?>>Display packages left.</option>
                                                <option value="2" <?php if($display == '2') echo 'selected'; ?>>Display time left.</option>
                                            </select>
                                        </div>				
                                    </div>
                                    <div class="form-group">											
                                        <label class="col-md-2">Description</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" name="text"><?=$text?></textarea>
                                        </div>				
                                    </div>
                                    <div class="form-group">											
                                        <label class="col-md-2"></label>
                                        <div class="col-md-10">
                                            <input type="submit" class="form-control" value="Submit">
                                        </div>				
                                    </div>
                                </fieldset>
                            </form>
                    
                            <?php if($name != 'new') { ?>
                                <br><br><br><br><br>
                                <form method="post" id="edit-profile" class="form-horizontal col-md-12">
                                    <input name="name" type="hidden" class="form-control" value="delete">
                                    <input name="type" type="hidden" class="form-control" value="<?=$name?>">
                                    <input name="id" type="hidden" class="form-control" value="<?=$id?>">
                                    <input style="width:100px;" type="submit" class="form-control" value="Delete">
                                </form>
                            <?php }
                        }
                    }
                    else
                    {
                        echo "<a href='{$site['url']}admin-sales/new'>Add new sale</a><br><br>";
                        
                        $query = $db->query("
                        (SELECT 'savant' AS `name`, `id`, `sale`, UNIX_TIMESTAMP(`start`) - UNIX_TIMESTAMP(NOW()) AS `start`, UNIX_TIMESTAMP(`end`) - UNIX_TIMESTAMP(NOW()) AS `end`, `count`, `used` FROM `sales` WHERE `end` > NOW() && `count` > 0) 
                        UNION
                        (SELECT 'brisk' AS `name`, `id`, `sale`, UNIX_TIMESTAMP(`start`) - UNIX_TIMESTAMP(NOW()) AS `start`, UNIX_TIMESTAMP(`end`) - UNIX_TIMESTAMP(NOW()) AS `end`, `count`, `used` FROM `brisksurf`.`sales` WHERE `end` > NOW() && `count` > 0) ORDER BY `start` ASC");
                        if($query->getNumRows())
                        {
                            ?>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Site</th>
                                        <th>Sale</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Left</th>
                                        <th>Used</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <?php
                            
                            while($result = $query->getNext())
                            {
                                if($result->name == "savant") $name = "SurfSavant";
                                else if($result->name == "brisk") $name = "BriskSurf";
                                echo "<tr><td>{$name}</td><td>{$result->sale}%</td><td>{$gui->timeFormat($result->start)}</td><td>{$gui->timeFormat($result->end)}</td><td>{$result->count}</td><td>{$result->used}</td><td><a href='{$site['url']}admin-sales/{$result->name}-{$result->id}'>Manage</a></td></tr>";
                            }
                            
                            echo "</table>";
                        }
                    }
                    ?>
                </center>
            </div>
        </div>
    </div>
</div>
<?php } else include 'loggedIn/admin-signin.php'; include 'footer.php'; ?>