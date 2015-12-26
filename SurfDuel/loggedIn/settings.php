<?php include 'header.php'; ?>
<div class="header">Settings</div>
<?php
    if($sec->post("updateSettings"))
    {
        $values = [
            ["name" => "full name", "type" => "post", "value" => $sec->post("settingsFullName"), "field" => "fullName", "valid" => "fullname", "min" => 5, "max" => 50]
            ];
        if($sec->post("settingsPassword") != "")
        {
            $values[] = ["name" => "password", "type" => "post", "pass" => true, "value" => $sec->post("settingsPassword"), "field" => "password", "min" => 5, "max" => 25];
            $values[] = ["name" => "password", "type" => "compare", "pass" => true, "value" => $sec->post("settingsConfirmPassword")];
        }
        if($sec->post("settingsPaypal") != "")
        {
            $values[] = ["name" => "paypal email", "type" => "post", "value" => $sec->post("settingsPaypal"), "field" => "paypal", "valid" => "email", "max" => 50];
        }
        $result = $db->insertUpdate("update", "users", $values, ["`id`='{$usr->data->id}'"]);
        if($result != "success") echo "<div class='error'>ERROR: " . $result . "</div>";
        else{
            echo "<div class='success'>Your settings have been updated</div>";
            $usr->getData();
        }
    }
?>
<div class="tableinfo" style="height:580px;">
    <div class="wrap">
        <div class="column one" style="height:600px;">
        </div>
        <div class="column two" style="height:540px;">
            <div class="register">
                <form method="post">
                    <div style="padding-left:100px; height:75px; background: url(http://www.gravatar.com/avatar/<?php echo md5($usr->data->email); ?>?s=75);  background-repeat:no-repeat; line-height:75px;"> 
                        We use the <a target="_blank" href="http://gravatar.com/">Gravatar</a>
                    </div>
                    
                    <br><br>
                    <?php
                        echo "Full Name <div class=' red'>*</div><br>";
                        $gui->input(["name" => "settingsFullName", "type" => "text", "value" => $usr->data->fullName]);
                        echo "<br><br>Paypal Email<br>";
                        $gui->input(["name" => "settingsPaypal", "type" => "text", "value" => $usr->data->paypal]);
                        echo "<br><br>New Password<br>";
                        $gui->input(["name" => "settingsPassword", "type" => "password"]);
                        echo "<br><br>Confirm New Password<br>";
                        $gui->input(["name" => "settingsConfirmPassword", "type" => "password"]);
                        echo "<br>";
                        $gui->input(["name" => "updateSettings", "type" => "submit", "value" => "Update"]); 
                    ?>
                    <br><div style="margin-top:10px;" class='red'>*</div> Required Fields
                </form>
            </div>
        </div>
        <div class="column three" style="height:600px;">
       </div>
    </div>
</div>
<?php include 'footer.php'; ?>