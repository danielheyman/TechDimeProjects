<?php include 'header.php'; ?>
<div class="title">Dashboard</div>
<hr>
<div class="text">
    <div class="subtitle">Profile Picture</div>
    <div style="padding-left:100px; height:75px; background: url(http://www.gravatar.com/avatar/<?php echo md5($usr->data->email); ?>?s=75);  background-repeat:no-repeat; line-height:75px;"> 
        We use the <a target="_blank" href="http://gravatar.com/">Gravatar</a> linked to your email for your profile picture
    </div>
    
    <br>
    <div class="subtitle">General Settings</div>
    <?php
        if($sec->post("updateSettings"))
        {
            $values = [
                ["name" => "full name", "type" => "post", "value" => $sec->post("settingsFullName"), "field" => "fullName", "valid" => "fullname", "min" => 5, "max" => 50],
                ["name" => "continent", "type" => "post", "value" => $sec->post("settingsContinent"), "field" => "continent", "min" => 4, "max" => 4], 
                ["name" => "age", "type" => "post", "value" => $sec->post("settingsAge"), "field" => "age", "min" => 4, "max" => 4]
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
    <div class="form commonForm">
        <form method="post">
            <?php 
                echo "Full Name <div class='red'>*</div><br>";
                $gui->input(["name" => "settingsFullName", "type" => "text", "value" => $usr->data->fullName]);
                echo "<br><br>Continent <div class='red'>*</div><br>";
                $gui->select(["name" => "settingsContinent", "default" => $usr->data->continent], $arrayManager->getCategory($vars, "Continent"));
                echo "<br><br>Age <div class='red'>*</div><br>";
                $gui->select(["name" => "settingsAge", "default" => $usr->data->age], $arrayManager->getCategory($vars, "Age"));
                echo "<br><br>Paypal Email<br>";
                $gui->input(["name" => "settingsPaypal", "type" => "text", "value" => $usr->data->paypal]);
                echo "<br><br>New Password<br>";
                $gui->input(["name" => "settingsPassword", "type" => "password"]);
                echo "<br><br>Confirm New Password<br>";
                $gui->input(["name" => "settingsConfirmPassword", "type" => "password"]);
                echo "<br><br>";
                $gui->input(["name" => "updateSettings", "type" => "submit", "value" => "Update"]); 
            ?>
        </form>
        <br><div class='red'>*</div> Required Fields
        <br><br>We hate spam as much as you. Your details will NEVER be shared.
    </div>
</div>
<?php include 'footer.php'; ?>