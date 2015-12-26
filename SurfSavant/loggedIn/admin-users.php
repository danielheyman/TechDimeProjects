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
            if($sec->post("submitSettings"))
            {
                $banned = $db->query("SELECT `activation` FROM `users` WHERE `id`='{$getVar}'")->getNext()->activation;
                $banned2 = $banned;
                
                $values = [
                    ["name" => "", "type" => "post", "value" => $sec->post("one"), "field" => "fullName"],
                    ["name" => "", "type" => "post", "value" => $sec->post("two"), "field" => "email"],
                    ["name" => "", "type" => "post", "value" => $sec->post("four"), "field" => "active"],
                    ["name" => "", "type" => "post", "value" => $sec->post("six"), "field" => "ref"],
                    ["name" => "", "type" => "post", "value" => $sec->post("seven"), "field" => "membership"],
                    ["name" => "", "type" => "post", "value" => $sec->post("eight"), "field" => "membershipExpires"],
                    ["name" => "", "type" => "post", "value" => $sec->post("nine"), "field" => "level"],
                    ["name" => "", "type" => "post", "value" => $sec->post("ten"), "field" => "xp"],
                    ["name" => "", "type" => "post", "value" => $sec->post("eleven"), "field" => "coins"],
                    ["name" => "", "type" => "post", "value" => $sec->post("twelve"), "field" => "vacations"],
                    ["name" => "", "type" => "post", "value" => $sec->post("thirteen"), "field" => "piggybank"]
                ];
                
                if($sec->post("three") != "")
                {
                    $values[] = ["name" => "", "type" => "post", "value" => md5($sec->post("three")), "field" => "tempPassword"];
                }
                
                if($sec->post("fourteen") != "")
                {
                    $values[] = ["name" => "", "type" => "post", "value" => $sec->post("fourteen"), "field" => "paypal"];
                }
                
                if($sec->post("five"))
                {
                    $banned2 = $sec->post("five");
                    $values[] = ["name" => "", "type" => "post", "value" => $sec->post("five"), "field" => "activation"];
                }
                
                if($sec->post("fifteen"))
                {
                    $values[] = ["name" => "", "type" => "post", "value" => $sec->post("fifteen"), "field" => "newsletter"];
                    
                    $subscribed = ($sec->post("fifteen") == "2") ? false : true;
                    if($banned != "2" && $sec->post("fifteen") != $db->query("SELECT `newsletter` FROM `users` WHERE `id`='{$getVar}'")->getNext()->newsletter)
                    {
                        //CHANGE MEMBER SUBSCRIPTION
                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                        curl_setopt(
                        $ch, CURLOPT_URL, "https://api.mailgun.net/v2/lists/sendout@surfsavant.com/members/{$sec->post('two')}");
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, array('subscribed' => $subscribed));

                        $result = curl_exec($ch);
                        curl_close($ch);
                    }
                }
                
                $result = $db->insertUpdate("update", "users", $values, ["`id`='{$getVar}'"]);
                if($result != "success") 
                {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> <?=$result?>.
                    </div>
                    <?php
                }
                else{
                    
                    if($banned != $banned2)
                    {
                        $subscribed = ($banned2 == "2") ? false : true;
                        if(!($subscribed && !$db->query("SELECT `newsletter` FROM `users` WHERE `id`='{$getVar}'")->getNext()->newsletter))
                        {
                            //CHANGE MEMBER SUBSCRIPTION
                            $ch = curl_init();

                            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                            curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

                            curl_setopt(
                            $ch, CURLOPT_URL, "https://api.mailgun.net/v2/lists/sendout@surfsavant.com/members/{$sec->post('two')}");
                            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                            curl_setopt($ch, CURLOPT_POSTFIELDS, array('subscribed' => $subscribed));

                            $result = curl_exec($ch);
                            curl_close($ch);
                        }
                    }
                    
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Well done!</strong> Your settings have been updated.
                    </div>
                    <?php
                }
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
                    <li class="active"><a href="<?=$site['url']?>admin-users">Manage Users</a></li>
                    <li><a href="<?=$site['url']?>admin-report">Ban Website</a></li>
                    <li><a href="<?=$site['url']?>admin-sales">Sales</a></li>
                </ul>
                
                <br>
                
                <center>
                    <?php 
                    $continue = true;
                    if($sec->post('userSearch')) {
                        $search = $sec->post('userSearch');
        
                        echo "Search Term: <strong>{$search}</strong><br><br>";
        
                        $query = $db->query("SELECT `id`, `email`, `fullName` FROM `users` WHERE `email` = '{$search}' || `fullName` like '%{$search}%' || `id` = '{$search}'");
                        if($query->getNumRows())
                        {
                            ?>
                            <a href='<?=$site['url']?>admin-users'>New Search</a><br><br>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Gravatar</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Manage</th>
                                    </tr>
                                </thead>
                                <?php
                            
                            while($result = $query->getNext())
                            {
                                $email = md5($result->email);
                                echo "<tr><td><img src='http://www.gravatar.com/avatar/{$email}?s=50'></td><td>{$result->fullName}</td><td>{$result->email}</td><td><a href='{$site['url']}admin-users/{$result->id}'>Manage</a></td></tr>";
                            }
                            
                            echo "</table><a href='{$site['url']}admin-users'>New Search</a>";
                            
                            $continue = false;   
                        }
                        else echo "No Results found. <br><br>";
                    } 
                    else if($getVar)
                    {
                        $query = $db->query("SELECT `email`, `fullName`, `tempPassword`, `activation`, `ref`, `membership`, `membershipExpires`, `level`, `xp`, `coins`, `piggybank`, `vacations`, `active`, `paypal`, `newsletter`, (SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$getVar}') AS `cash`, NOW() AS `now` FROM `users` WHERE `id` = '{$getVar}' LIMIT 1");
                        if($query->getNumRows())
                        {
                            echo "User ID: <strong>{$getVar}</strong><br><a href='{$site['url']}admin-users'>New Search</a><br><br><form method='post'><input type='hidden' name='loginUser' value='1'><button class='form-control' style='width:200px;'>Login as User</button></form><br><hr><br>";
                            
                            
                            $query = $query->getNext();
                            
                            
                            ?>
                            <form style="text-align:left;" method="post" id="edit-profile" class="form-horizontal col-md-12">
                                <fieldset>
                                    <div class="form-group">											
                                        <label class="col-md-2">Gravatar</label>
                                        <div class="col-md-10">
                                            <img src="http://www.gravatar.com/avatar/<?=md5($query->email)?>?s=100">
                                        </div>				
                                    </div>
                                    <div class="form-group">											
                                        <label class="col-md-2">Full Name</label>
                                        <div class="col-md-10">
                                            <input name="one" type="text" class="form-control" value="<?=$query->fullName?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Email</label>
                                        <div class="col-md-10">
                                            <input name="two" type="text" class="form-control" value="<?=$query->email?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Temporary Password</label>
                                        <div class="col-md-10">
                                            Use this if you want to give them a temporary password to use if they forgot theirs. The current temporary password will not be displayed here because it is encrypted.<br><br>
                                            <input name="three" type="text" class="form-control" value="">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Active</label>
                                        <div class="col-md-10">
                                            Being active means that they have surfed the activity sites yesterday. If you want them to be active for tomorrow, simply add a vacation day.<br><br>
                                            <select name="four" class="form-control"><option value="1" <?php if($query->active == "1") echo "selected"; ?>>True</option><option value="0" <?php if($query->active == "0") echo "selected"; ?>>False</option></select>
                                        </div>				
                                    </div>
                                    
                                    <?php if(strlen($query->activation) == 1) { ?>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Banned</label>
                                        <div class="col-md-10">
                                            <select name="five" class="form-control"><option value="1" <?php if($query->activation == "1") echo "selected"; ?>>False</option><option value="2" <?php if($query->activation == "2") echo "selected"; ?>>True</option></select>
                                        </div>				
                                    </div>
                                    
                                    <?php } ?>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Referrer ID</label>
                                        <div class="col-md-10">
                                            <input name="six" type="text" class="form-control" value="<?=$query->ref?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Membership</label>
                                        <div class="col-md-10">
                                            If you change the membership from free to upgraded, make sure to change the Membership Expires field. Click on Enter Current Date and add however much time you would like.<br><br>
                                            <select name="seven" class="form-control"><option value="0001" <?php if($query->membership == "0001") echo "selected"; ?>>Free</option><option value="0002" <?php if($query->membership == "0002") echo "selected"; ?>>Pro</option><option value="0003" <?php if($query->membership == "0003") echo "selected"; ?>>JV</option></select>
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Membership Expires</label>
                                        <div class="col-md-6">
                                            Never enter a date past the year 2023.<br><br>
                                            <input name="eight" id="eight" type="text" class="form-control" value="<?=$query->membershipExpires?>">
                                        </div>	
                                        <div class="col-md-4">
                                            <br><br>
                                            <button class="form-control" onclick="javascript:$('#eight').val('<?=$query->now?>'); return false;">Enter Current Date</button>
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Level</label>
                                        <div class="col-md-10">
                                            <input name="nine" type="text" class="form-control" value="<?=$query->level?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">XP</label>
                                        <div class="col-md-10">
                                            <input name="ten" type="text" class="form-control" value="<?=$query->xp?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Coins</label>
                                        <div class="col-md-10">
                                            <input name="eleven" type="text" class="form-control" value="<?=$query->coins?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Vacation Days</label>
                                        <div class="col-md-10">
                                            <input name="twelve" type="text" class="form-control" value="<?=$query->vacations?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Piggy Bank</label>
                                        <div class="col-md-10">
                                            <input name="thirteen" type="text" class="form-control" value="<?=$query->piggybank?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Paypal Email</label>
                                        <div class="col-md-10">
                                            <input name="fourteen" type="text" class="form-control" value="<?=$query->paypal?>">
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Newsletter</label>
                                        <div class="col-md-10">
                                            <select name="fifteen" class="form-control"><option value="1" <?php if($query->newsletter == "1") echo "selected"; ?>>True</option><option value="2" <?php if($query->newsletter == "2") echo "selected"; ?>>False</option></select>
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Cash</label>
                                        <div class="col-md-10">
                                            $ <?=$query->cash?>
                                        </div>				
                                    </div>
                                    
                                    <div class="form-group">											
                                        <label class="col-md-2">Lost Level</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" style="height:80px;"><?php
                                                $levels = $db->query("SELECT * FROM `lostLevel` WHERE `userid` = '{$getVar}' ORDER BY `timestamp` DESC");
                                                if($levels->getNumRows())
                                                {
                                                    while($level = $levels->getNext())
                                                    {
                                                        echo "{$level->timestamp} : Level {$level->level} with {$level->xp} XP\n";  
                                                    }
                                                }
                                                else echo "Didn't lose any levels in the past week";
                                            ?></textarea>
                                        </div>				
                                    </div>
                                    
                                    
                                        
                                    <br />
                                        
                                    <div class="form-group">
                            
                                        <div class="col-md-offset-2 col-md-10">
                                            <input name="submitSettings" value="Save" type="submit" class="btn btn-primary">
                                        </div>
                                    </div> <!-- /form-actions -->
                                </fieldset>
                            </form>
                                
                            <?php
                            
                            $continue = false;   
                        }
                        else echo "No Results found. <br><br>";  
                    }
                    
                    if($continue)
                    {
                         ?>
                         <form method="post">
                            <div style="width:500px;" class="input-group">
                                <input name="userSearch" placeholder="Enter Email or Name or ID" type="text" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </span>
                            </div>
                        </form>
                        <?php 
                    }
                    ?>
                </center>
            </div>
        </div>
    </div>
</div>
<?php } else include 'loggedIn/admin-signin.php'; include 'footer.php'; ?>