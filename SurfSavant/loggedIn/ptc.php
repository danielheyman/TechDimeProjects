<?php include 'header.php'; ?>
<style>
a.ptc
    {
        border:1px solid #D5D5D5;
        padding:20px;
        background:#f5f5f5;
        display:inline-block;
        color:#333;
        -moz-border-radius:5px;
        -o-border-radius:5px;
        -webkit-border-radius:5px;
        border-radius:5px;
        min-width:200px;
        text-align:left;
        -moz-transition: all .3s ease-in; 
        -o-transition: all .3s ease-in; 
        -webkit-transition: all .3s ease-in; 
        transition: all .3s ease-in; 
        width:100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        text-decoration:none;
        margin-bottom:20px;
    }
    
    a.ptc.completed{
        background:#59d167;   
    }
    
    a.ptc:hover{
        background:#d0d0d0;
    }
    
    a.ptc .banner{
        width:150px;
        position:absolute;
    }
    
    a.ptc .banner img{
        -moz-border-top-left-radius:2px;
        -moz-border-bottom-left-radius:2px;
        -o-border-top-left-radius:2px;
        -o-border-bottom-left-radius:2px;
        -webkit-border-top-left-radius:2px;
        -webkit-border-bottom-left-radius:2px;
        border-top-left-radius:2px;
        border-bottom-left-radius:2px;
        margin-right:5px;
        border:0;
        height:100px;
        width:100px;
    }
    
    a.ptc .grouped{
        min-height:100px;
        padding-left:130px;
    }
    
    a.ptc .title{
        font-size:20px;
        font-weight:bold;
        width:100%;
        margin-bottom:10px;
        padding-bottom:10px;
        border-bottom:1px solid #bcbaba;
    }
    
    a.ptc.completed .title{
        border-bottom:1px solid #FFF;
    }
    
    td a.pausesite{
        color:#87b24d;
    }
    
    td a.playsite{
        color:#c54545;
    }
    
    td a.pausesite:hover{
        color:#567e20;
    }
    
    td a.playsite:hover{
        color:#8e1717;
    }
    
    td a{
        text-decoration:none!important;   
    }
    
    .icon-remove, .icon-ok{
        color:#777;   
    }
</style>
<div class="row">

    <?php
        $form = false;
        if($sec->post("newSiteInput"))
        {
            $form = true;
            $siteurl = str_replace("&amp;", "&", $sec->post("newSiteInput"));
            
            if((substr($siteurl, 0, 7) !== 'http://') && (substr($siteurl, 0, 8) !== 'https://')) $siteurl = 'http://' . $siteurl;
            if(!$sec->isURL($siteurl))
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> The URL is invalid.
                    </div>
                </div>
                <?php
            }
            else
            {
                $db->query("INSERT INTO `ptc` (`url`, `userid`,`earn`,`active`) VALUES ('{$siteurl}', '{$usr->data->id}','1','1')");
                ?>
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Well done!</strong> The website have been added for promotion. You may now assign cash.
                    </div>
                </div>
                <?php
            }
        }
        else if($sec->post("rotatorid"))
        {
            $form = true;
            $update = $db->query("SELECT `amount` FROM `ptc` WHERE `id` = '{$sec->post('rotatorid')}' && `userid` = '{$usr->data->id}'");
            if($update->getNumRows())
            {
                $update = $update->getNext()->amount;  
                $db->query("UPDATE `users` SET `piggybank` = `piggybank` + {$update} WHERE `id` = '{$usr->data->id}'");
                $usr->getData();
            }
            $db->query("DELETE FROM `ptc` WHERE `id` = '{$sec->post('rotatorid')}' && `userid` = '{$usr->data->id}'");
            ?>
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Well done!</strong> Your website has been removed.
                </div>
            </div>
            <?php
        }
        else if($sec->post("rotatorid2"))
        {
            $form = true;
            $value = $sec->post("value");
            $id = $sec->post("rotatorid2");
            if(($value == "1" || $value == "2" || $value == "3" || $value == "4" || $value == "5") && is_numeric($value))
            {
                $db->query("UPDATE `ptc` SET `earn` = '{$value}' WHERE `userid` = '{$usr->data->id}' && `id` = '{$id}'");   
                ?>
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Well done!</strong> Your website has been removed.
                    </div>
                </div>
                <?php
            }
            else
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> The type is invalid.
                    </div>
                </div>
                <?php
            }
        }
        else if($sec->post("rotatorid3"))
        {
            $form = true;
            $value = $sec->post("value");
            $id = $sec->post("rotatorid3");
            if(is_numeric($value) && $value >= 0)
            {
                $result = $db->query("SELECT `amount` FROM `ptc` WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                if($result->getNumRows())
                {
                    $websiteCash = $result->getNext()->amount;
                    $userCash = $usr->data->piggybank;
                    if($websiteCash < $value)
                    {
                        $changeCash = $value - $websiteCash;
                        if($userCash >= $changeCash)
                        {
                            $newCash = $userCash - $changeCash;
                            $db->query("UPDATE `ptc` SET `amount` = '{$value}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                            $db->query("UPDATE `users` SET `piggybank` = '{$newCash}' WHERE `id`='{$usr->data->id}'");
                            ?>
                            <div class="col-md-12">
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Well done!</strong> The amount assigned have been updated.
                                </div>
                            </div>
                            <?php
                            $usr->getData();
                        }
                        else
                        {
                            ?>
                            <div class="col-md-12">
                                <div class="alert alert-danger alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Oops!</strong> You do not have enough coins.
                                </div>
                            </div>
                            <?php   
                        }
                    }
                    else if($websiteCash > $value)
                    {
                        $changeCash = $websiteCash - $value;
                        $newCash = $userCash + $changeCash;
                        $db->query("UPDATE `ptc` SET `amount` = '{$value}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                        $db->query("UPDATE `users` SET `piggybank` = '{$newCash}' WHERE `id`='{$usr->data->id}'"); 
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Well done!</strong> The amount assigned have been updated.
                            </div>
                        </div>
                        <?php
                        $usr->getData();
                    }
                }
            }
        }
        else if($sec->post("rotatorid4"))
        {
            $form = true;
            $value = $sec->post("value");
            $id = $sec->post("rotatorid4");
            
            $siteurl = str_replace("&amp;", "&", $value);
            
            
            if((substr($siteurl, 0, 7) !== 'http://') && (substr($siteurl, 0, 8) !== 'https://')) $siteurl = 'http://' . $siteurl;
            if($value != "" && !$sec->isURL($siteurl))
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> The URL is invalid.
                    </div>
                </div>
                <?php
            }
            else
            {
                $db->query("UPDATE `ptc` SET `banner` = '{$siteurl}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                ?>
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Well done!</strong> The banner URL has been updated.
                    </div>
                </div>
                <?php
            }
        }
        else if($sec->post("rotatorid5"))
        {
            $form = true;
            $value = $sec->post("value");
            $id = $sec->post("rotatorid5");
            
            $db->query("UPDATE `ptc` SET `title` = '{$value}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
            ?>
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Well done!</strong> The title has been updated.
                </div>
            </div>
            <?php
        }
        else if($sec->post("rotatorid6"))
        {
            $form = true;
            $value = $sec->post("value");
            $id = $sec->post("rotatorid6");
            
            $db->query("UPDATE `ptc` SET `description` = '{$value}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
            ?>
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Well done!</strong> The description has been updated.
                </div>
            </div>
            <?php
        }
        else if($sec->post("rotatorid7"))
        {
            $form = true;
            $id = $sec->post("rotatorid7");
            
            $db->query("UPDATE `ptc` SET `active` = IF(`active` = 1, 0, 1) WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
            ?>
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Well done!</strong> The activity has been toggled.
                </div>
            </div>
            <?php
        }
        
    ?>
    <div class="col-md-9">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-hand-down"></i>
                <h3>Paid to Click</h3>
            </div>
            <div class="widget-content">
                <script>
                $(function() { 
                    
                  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    localStorage.setItem('lastTab', $(e.target).attr('class'));
                  });
                
                  var lastTab = localStorage.getItem('lastTab');
                  if (lastTab) {
                      $('.'+lastTab).tab('show');
                  }
                });
                </script>
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#earn" class="earn" data-toggle="tab">Earn</a></li>
                    <li class=""><a href="#advertise" class="advertise" data-toggle="tab">Advertise</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="earn">
                        <?php
                        $ptcs = $db->query("SELECT *, CASE WHEN EXISTS (SELECT `id` FROM `ptcviews` WHERE `userid` = '{$usr->data->id}' && `ptcid` = `ptc`.`id` LIMIT 1) THEN 'completed' ELSE '0' END AS `completed` FROM `ptc` WHERE `amount` >= `earn` / 500 && `active` = 1 && `description` != '' && `title` != '' ORDER BY `completed`, `earn` DESC, RAND()");
                        if($ptcs->getNumRows())
                        {
                            while($ptc = $ptcs->getNext())
                            {
                                ?>
                                <a href="<?=$site['url']?>ptcview/<?=$ptc->id?>" class="ptc <?=$ptc->completed?> <?php if($ptc->id == "1") echo "tourStop1"; ?>">
                                    <div class="banner"><?php if($ptc->banner != '') { ?><img src='<?=$ptc->banner?>'><?php } ?></div>
                                    <div class="grouped">
                                        <div class="title"><?=$ptc->title?> : <?php echo ($ptc->completed == "0") ? "$" . $ptc->earn/1000 : "Completed"; ?></div>
                                        <div class="text"><?=$ptc->description?></div>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        else echo "There are currently no advertisements.";
                        ?>
                    </div>
                    <div class="tab-pane fade" id="advertise">
                        <center>
                            As a promoter, you can advertise your website to increase sales and traffic. For an advertisement to begin showing, it must have a title, description, and a cash amount assigned. You can click the green circle to pause your site, and the red one to enable it once again.<br><br>
                            <form method="post">
                                <div style="width:500px;" class="input-group">
                                    <input name="newSiteInput" placeholder="Website URL" type="text" class="form-control">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="submit">Add</button>
                                    </span>
                                </div>
                            </form>
                            <br>
                            <script>
                                function removeSite(id)
                                {
                                    $.msgbox("Are you sure you want to delete the website?", {
                                      type: "confirm",
                                      buttons : [
                                        {type: "submit", value: "Yes"},
                                        {type: "submit", value: "No"}
                                      ]
                                    }, function(result) {
                                        if(result == "Yes")
                                        {
                                            $("#removeSiteForm" + id).submit();
                                        }
                                    });
                                }
                                
                                function pauseSite(id, value)
                                {
                                    $.msgbox("Are you sure you want to " + value + " the website?", {
                                      type: "confirm",
                                      buttons : [
                                        {type: "submit", value: "Yes"},
                                        {type: "submit", value: "No"}
                                      ]
                                    }, function(result) {
                                        if(result == "Yes")
                                        {
                                            $("#pauseSiteForm" + id).submit();
                                        }
                                    });
                                }
                                
                                function editTitle(id, value)
                                {
                                    $.msgbox("Enter a new title:", {
                                            type: "prompt",
                                            inputs  : [
                                              {type: "text", value: value.replace(/"/g,"'"), required: true}
                                            ],
    
                                        }, function(result) {
                                            if (result) {
                                                $("#editTitleInput" + id).val(result);
                                                $("#editTitle" + id).submit();
                                            }
                                    });
                                }
                                
                                function editDesc(id, value)
                                {
                                    $.msgbox("Enter a new description:", {
                                            type: "prompt",
                                            inputs  : [
                                              {type: "text", value: value.replace(/"/g,"'"), required: true}
                                            ],
    
                                        }, function(result) {
                                            if (result) {
                                                $("#editDescInput" + id).val(result);
                                                $("#editDesc" + id).submit();
                                            }
                                    });
                                }
                                
                                function editBanner(id, value)
                                {
                                    $.msgbox("Enter a new banner URL (leave it blank for no banner):", {
                                            type: "prompt",
                                            inputs  : [
                                              {type: "text", value: value, required: true}
                                            ]
    
                                        }, function(result) {
                                            if(result !== false)
                                            {
                                                $("#editBannerInput" + id).val(result);
                                                $("#editBanner" + id).submit();
                                            }
                                    });
                                }
                                
                                function editType(id)
                                {
                                    $.msgbox("Which type of ad would you prefer?<br><br>1) 10 second timer costs you $.002 / View.<br>2) 15 second timer costs you $.004 / View.<br>3) 20 second timer costs you $.006 / View.<br>4) 25 second timer costs you $.007 / View.<br>5) 30 second timer costs you $.008 / View.<br><br> Please type in the number of your selection:", {
                                            type: "prompt"
                                        }, function(result) {
                                            if (result) {
                                                $("#editTypeInput" + id).val(result);
                                                $("#editType" + id).submit();
                                            }
                                    });
                                }
                                
                                function editCash(id, value)
                                {
                                    $.msgbox("You currently have <?=$usr->data->piggybank?> in your piggybank. <a href='<?=$site['url']?>piggybank'>Click here to  add money to your piggybank</a>. Enter the new amount of cash you want to have assigned:", {
                                            type: "prompt",
                                            inputs  : [
                                              {type: "text", value: value, required: true}
                                            ]
                                        }, function(result) {
                                            if (result) {
                                                $("#editCashInput" + id).val(result);
                                                $("#editCash" + id).submit();
                                            }
                                    });
                                }
                            </script>
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th>Title</th>
                                        <th>Info</th>
                                        <th>Image</th>
                                        <th>Type</th>
                                        <th>Assigned</th>
                                        <th>Today</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <?php
                                $ptcs = $db->query("SELECT *, (SELECT COUNT(`id`) FROM `ptcviews` WHERE `ptcid` = `ptc`.`id`) AS `count` FROM `ptc` WHERE `userid` = '{$usr->data->id}'");
                                if($ptcs->getNumRows())
                                {
                                    while($ptc = $ptcs->getNext())
                                    {
                                        $url = (strlen($ptc->url) > 20) ? substr($ptc->url, 0, 17) . "..." : $ptc->url;
                                        $title = (strlen($ptc->title) > 14) ? substr($ptc->title, 0, 11) . "..." : $ptc->title;
                                        $ptc->description = str_replace("'","\'",$ptc->description);
                                        $ptc->title = str_replace("'","\'",$ptc->title);
                                        if($ptc->count == '') $ptc->count = '0';
                                        ?>
                                        <form method="post" style="display:none" id="removeSiteForm<?=$ptc->id?>"><input name="rotatorid" type="hidden" value="<?=$ptc->id?>"></form>
                                        <form method="post" style="display:none" id="pauseSiteForm<?=$ptc->id?>"><input name="rotatorid7" type="hidden" value="<?=$ptc->id?>"></form>
                                        <form method="post" style="display:none" id="editTitle<?=$ptc->id?>"><input name="rotatorid5" type="hidden" value="<?=$ptc->id?>"><input id="editTitleInput<?=$ptc->id?>" name="value" type="hidden" value="0"></form>
                                        <form method="post" style="display:none" id="editDesc<?=$ptc->id?>"><input name="rotatorid6" type="hidden" value="<?=$ptc->id?>"><input id="editDescInput<?=$ptc->id?>" name="value" type="hidden" value="0"></form>
                                        <form method="post" style="display:none" id="editType<?=$ptc->id?>"><input name="rotatorid2" type="hidden" value="<?=$ptc->id?>"><input id="editTypeInput<?=$ptc->id?>" name="value" type="hidden" value="0"></form>
                                        <form method="post" style="display:none" id="editCash<?=$ptc->id?>"><input name="rotatorid3" type="hidden" value="<?=$ptc->id?>"><input id="editCashInput<?=$ptc->id?>" name="value" type="hidden" value="0"></form>
                                        <form method="post" style="display:none" id="editBanner<?=$ptc->id?>"><input name="rotatorid4" type="hidden" value="<?=$ptc->id?>"><input id="editBannerInput<?=$ptc->id?>" name="value" type="hidden" value="0"></form>
                                        <tr>
                                            <td><a href="javascript:;" onclick="javascript:removeSite(<?=$ptc->id?>)"><i class="icon-remove-sign"></i></a> &nbsp;<a class="<?php echo ($ptc->active == "1") ? "pausesite" : "playsite"; ?>" href="javascript:;" onclick="javascript:pauseSite(<?=$ptc->id?>, '<?php echo ($ptc->active == "1") ? "pause" : "play"; ?>')"><i class="icon-circle"></i></a> &nbsp;<?=$url?></td>
                                            <td><a href="javascript:;" onclick="javascript:editTitle(<?=$ptc->id?>,'<?=$ptc->title?>')"><i class="icon-edit"></i></a> &nbsp;<?php echo ($ptc->title != "") ? $title : "No Title"; ?></td>
                                            <td><a href="javascript:;" onclick="javascript:editDesc(<?=$ptc->id?>,'<?=$ptc->description?>')"><i class="icon-edit"></i></a> &nbsp;<?php echo ($ptc->description == "") ? "<i class='icon-remove'></l>" : "<i class='icon-ok'></l>"; ?></td>
                                            <td><a href="javascript:;" onclick="javascript:editBanner(<?=$ptc->id?>,'<?=$ptc->banner?>')"><i class="icon-edit"></i></a> &nbsp;<?php echo ($ptc->banner == "") ? "<i class='icon-remove'></l>" : "<i class='icon-ok'></l>"; ?></td>
                                            <td><a href="javascript:;" onclick="javascript:editType(<?=$ptc->id?>)"><i class="icon-edit"></i></a> &nbsp;<?=$ptc->earn?></td>
                                            <td><a href="javascript:;" onclick="javascript:editCash(<?=$ptc->id?>,'<?=$ptc->amount?>')"><i class="icon-edit"></i></a> &nbsp;$<?=$ptc->amount?></td>
                                            <td><?=$ptc->count?> Hits</td>
                                            <td><?=$ptc->views?> Hits</td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="well">
            <h4>How it works</h4>
            <p>You can earn money simply by viewing the advertisements that our members wish to display to you. Ads will turn green when you have seen them and you will not earn from them again until they reset at midnight. The current server time is <?=date("h:i A")?>!</p>
        </div>				
    </div>
</div>
<?php include 'footer.php'; ?>