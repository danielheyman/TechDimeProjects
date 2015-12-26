<?php include 'header.php'; ?>
<div class="row">
    <?php
        if($sec->post("newSiteInput"))
        {
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
                $spam = @file_get_contents("http://techdime.com/spam.php?url=" . $siteurl);
                
                if($spam != "0") {
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Oops!</strong> The website is suspended. If you believe it is an error, please contact support.
                        </div>
                    </div>
                    <?php
                }
                else
                {
                    $db->query("INSERT INTO `rotator` (`url`, `userid`) VALUES ('{$siteurl}', '{$usr->data->id}')");
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Well done!</strong> The website have been added for promotion. You may now assign tokens.
                        </div>
                    </div>
                    <?php
                }
            }
        }
        else if($sec->post("rotatorid"))
        {
            $update = $db->query("SELECT `coins` FROM `rotator` WHERE `id` = '{$sec->post('rotatorid')}' && `userid` = '{$usr->data->id}'");
            if($update->getNumRows())
            {
                $update = $update->getNext()->coins;  
                $db->query("UPDATE `users` SET `coins` = `coins` + {$update} WHERE `id` = '{$usr->data->id}'");
                $usr->getData();
            }
            $db->query("DELETE FROM `rotator` WHERE `id` = '{$sec->post('rotatorid')}' && `userid` = '{$usr->data->id}'")   
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
            $coins = $sec->post("coins");
            $id = $sec->post("rotatorid2");
            if(is_numeric($coins) && $coins >= 0)
            {
                $result = $db->query("SELECT `coins` FROM `rotator` WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                if($result->getNumRows())
                {
                    $websiteCoins = $result->getNext()->coins;
                    $userCoins = $usr->data->coins;
                    if($websiteCoins < $coins)
                    {
                        $changeCoins = $coins - $websiteCoins;
                        if($userCoins >= $changeCoins)
                        {
                            $newCoins = $userCoins - $changeCoins;
                            $db->query("UPDATE `rotator` SET `coins` = '{$coins}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                            $db->query("UPDATE `users` SET `coins` = '{$newCoins}' WHERE `id`='{$usr->data->id}'");
                            ?>
                            <div class="col-md-12">
                                <div class="alert alert-success alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>Well done!</strong> The coins have been updated.
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
                    else if($websiteCoins > $coins)
                    {
                        $changeCoins = $websiteCoins - $coins;
                        $newCoins = $userCoins + $changeCoins;
                        $db->query("UPDATE `rotator` SET `coins` = '{$coins}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                        $db->query("UPDATE `users` SET `coins` = '{$newCoins}' WHERE `id`='{$usr->data->id}'"); 
                        ?>
                        <div class="col-md-12">
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong>Well done!</strong> The coins have been updated.
                            </div>
                        </div>
                        <?php
                        $usr->getData();
                    }
                }
            }
        }
        
    ?>
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-repeat"></i>
                <h3>Traffic Rotator</h3>
            </div>
            <div class="widget-content">
                <center>
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
                        
                        function editCoins(id)
                        {
                            $.msgbox("You have <?=$usr->data->coins?>. Enter the amount of coins you would like the website to have:", {
                                    type: "prompt"
                                }, function(result) {
                                    if (result) {
                                        $("#editCoinsInput" + id).val(result);
                                        $("#editCoins" + id).submit();
                                    }
                            });
                        }
                    </script>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Promoted URL</th>
                                <th>Assigned Coins</th>
                                <th>Hits Recieved</th>
                            </tr>
                        </thead>
                        <?php
                        $rotators = $db->query("SELECT `id`, `url`, `hits`, `coins` FROM `rotator` WHERE `userid` = '{$usr->data->id}'");
                        if($rotators->getNumRows())
                        {
                            while($rotator = $rotators->getNext())
                            {
                                ?>
                                <form method="post" style="display:none" id="removeSiteForm<?=$rotator->id?>"><input name="rotatorid" type="hidden" value="<?=$rotator->id?>"></form>
                                <form method="post" style="display:none" id="editCoins<?=$rotator->id?>"><input name="rotatorid2" type="hidden" value="<?=$rotator->id?>"><input id="editCoinsInput<?=$rotator->id?>" name="coins" type="hidden" value="0"></form>
                                <tr>
                                    <td><a href="javascript:;" onclick="javascript:removeSite(<?=$rotator->id?>)"><i class="icon-remove-sign"></i></a> &nbsp; <?=$rotator->url?></td>
                                    <td><a href="javascript:;" onclick="javascript:editCoins(<?=$rotator->id?>)"><i class="icon-edit"></i></a> &nbsp; <?=$rotator->coins?></td>
                                    <td><?=$rotator->hits?></td>
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
    <div class="col-md-4">
        <div class="well">
            <h4>Promotion Page</h4>
            <input value="<?=$site['url']?>r/<?=$usr->data->id?>" class="form-control">
        </div>			
        <div class="well">
            <h4>How it works</h4>
            <p>Promote this rotator, and gain 0.05 coins for every hit. You lose 0.1 coins for every hit your website receives.</p>
        </div>			
    </div>
</div>
<?php include 'footer.php'; ?>