<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-shield"></i>
                <h3>Claim Shield</h3>
            </div>
            <div class="widget-content">
                <p>
                    <?php
                    $shield = $db->query("SELECT `activitySite` FROM `shield` WHERE `code`='{$getVar}' && `userid` = '0' LIMIT 1");
                    if($shield->getNumRows())
                    {
                        $activitySite = $shield->getNext()->activitySite;
                        $taken = $db->query("SELECT `id` FROM `shield` WHERE `activitySite`='{$activitySite}' && `userid` = '{$usr->data->id}' LIMIT 1");
                        
                        if($taken->getNumRows())
                        {
                            echo "You have already found the shield for this traffic exchange. Click <a href='{$site['url']}'>here</a> to go to your dashboard."; 
                        }
                        else
                        {
                            $db->query("UPDATE `shield` set `userid` = '{$usr->data->id}' WHERE `code`='{$getVar}' LIMIT 1");
                            echo "Your shield has been successfuly claimed. Click <a href='{$site['url']}'>here</a> to go to your dashboard.";   
                        }
                    }
                    else
                    {
                        echo "Invalid shield code. Click <a href='{$site['url']}'>here</a> to go to your dashboard.";  
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>