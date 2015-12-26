<?php include 'header.php'; ?>
<div class="title">My Websites: New Website</div>
<hr>
<div class="text">
    <?php
        if(isset($requirement) && $requirement)
        {
            echo "<div class='error'>ERROR: You must have at least one website added to begin surfing.</div>";   
        }
            
        $form = true;
        if($sec->post("newSiteSubmit"))
        {
            $activation = $sec->randomCode();
            $id = mysql_insert_id() + 1;
            $siteurl = str_replace("&amp;", "&", $sec->post("newSiteURL"));
        
            $spam = @file_get_contents("http://techdime.com/spam.php?url=" . $siteurl);
            if($spam != "0") echo "<div class='error'>ERROR: The inputed website has been suspended. If you beleive this is a mistake, please contact support.</div>";
            else
            {
                $autoAssign = $db->query("SELECT SUM(`autoAssign`) AS `autoAssign` FROM `websites` WHERE `userid`='{$usr->data->id}'");
                $autoAssign = round(85 - $autoAssign->getNext()->autoAssign);
                if($autoAssign < 0) $autoAssign = 0;
                
                $result = $db->insertUpdate("insert", "websites", [
                    ["name" => "userid", "type" => "post", "value" => $usr->data->id, "field" => "userid", "max" => 9], 
                    ["name" => "website name", "type" => "post", "value" => $sec->post("newSiteName"), "field" => "name", "max" => 30], 
                    ["name" => "website url", "type" => "post", "value" => $siteurl, "field" => "url", "valid" => "url", "max" => 100],
                    ["name" => "status", "type" => "post", "value" => "0", "field" => "status", "max" =>1],
                    ["name" => "auto assign", "type" => "post", "value" => $autoAssign, "field" => "autoAssign"]
                ]);
                if($result != "success") echo "<div class='error'>ERROR: " . $result . "</div>";
                else{
                    echo "<div class='success'>The site has been successfully added. Click <a href='{$site['url']}surf/{$db->insertID}'>here</a> to continue.</div>";
                    $usr->redirect($site['url'] . "surf/" . $db->insertID);
                    $form = false;
                    //send email with the activation code.
                }
            }
        }
        if($form)
        {
            ?>
                <div class="form">
                    <form method="post" action="<?=$site['url']?>new">
                        <?php 
                            $gui->input(["name" => "newSiteName", "type" => "text"], "Website Name");
                            echo "<br><br>";
                            $gui->input(["name" => "newSiteURL", "type" => "text"], "Website URL");
                            echo "<br><br>";
                            $gui->input(["name" => "newSiteSubmit", "type" => "submit", "value" => "Add Website"]); 
                        ?>
                    </form>
                </div>
            <?php
        }
    ?>
</div>
<?php include 'footer.php'; ?>