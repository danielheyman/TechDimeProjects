<?php 
$title = "Activate your account!";
$subtext = "Complete the following form to continue to the membership area.";
include 'header.php'; 
?>
<div class="commonFormWrapper">
    <?php
        $account = $db->query("SELECT `id`, `email`, `fullName` FROM `users` WHERE `activation`='{$getVar}'");
        if(strlen($getVar) == 6 && $account->getNumRows())
        {
            $account = $account->getNext();
            $form = true;
            if($sec->post("registerActivate"))
            {
                if(isset($_POST['registerTOS']))
                {
                    $result = $db->insertUpdate("update", "users", [
                        ["name" => "password", "type" => "post", "pass" => true, "value" => $sec->post("registerPassword"), "field" => "password", "min" => 5, "max" => 25], 
                        ["name" => "password", "type" => "compare", "pass" => true, "value" => $sec->post("registerConfirmPassword")],
                        ["name" => "gender", "type" => "post", "value" => $sec->post("registerGender"), "field" => "gender", "min" => 4, "max" => 4], 
                        ["name" => "continent", "type" => "post", "value" => $sec->post("registerContinent"), "field" => "continent", "min" => 4, "max" => 4], 
                        ["name" => "age", "type" => "post", "value" => $sec->post("registerAge"), "field" => "age", "min" => 4, "max" => 4], 
                        ["name" => "activation", "type" => "post", "value" => "1", "field" => "activation", "min" => 1, "max" => 1], 
                        ["name" => "registerIP", "type" => "post", "value" => "{$usr->visitorIP()}", "field" => "registerIP"],
                    ], ["`activation`='{$getVar}'"]);
                    if($result != "success") echo "<div class='error'>ERROR: " . $result . "</div>";
                    else{
                        //ADD MEMBER TO LIST
                        $ch = curl_init();
                    
                        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    
                        curl_setopt(
                        $ch, CURLOPT_URL, 'https://api.mailgun.net/v2/lists/brisksurf@techdime.com/members');
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, array('address' => $account->email,
                                                                 'name' => $account->fullName,
                                                                 'vars' => '{"id": "' . $account->id . '"}'));
                    
                        $result = curl_exec($ch);
                        curl_close($ch);
                        
                        
                        echo "<div class='success'>You have been successfully activated. You can now login</div>";
                        $form = false;
                        //$usr->redirect($site["url"]);
                    }
                }
                else echo "<div class='error'>ERROR: You must agree to the terms of service</div>";
            }
            if($form)
            {
                ?>
                    <div class="form commonForm">
                        <form method="post">
                            <?php 
                                $gui->input(["name" => "registerPassword", "type" => "password"],"Password");
                                echo "<br>";
                                $gui->input(["name" => "registerConfirmPassword", "type" => "password"], "Confirm Password");
                                echo "<br>";
                                $gui->select(["name" => "registerGender"], $arrayManager->getCategory($vars, "Gender"));
                                echo "<br>";
                                $gui->select(["name" => "registerContinent"], $arrayManager->getCategory($vars, "Continent"));
                                echo "<br>";
                                $gui->select(["name" => "registerAge"], $arrayManager->getCategory($vars, "Age"));
                                echo "<br>";
                                echo '<input name="registerTOS" type="checkbox"/>';
                                echo " I agree to the <a href='http://brisksurf.com/tos'>Terms of Service</a><br><br>";
                                $gui->input(["name" => "registerActivate", "type" => "submit", "value" => "Activate"]); 
                            ?>
                        </form>
                        <br>We hate spam as much as you<br>Your details will NEVER be shared.
                    </div>
                <?php
            }
        }
        else
        {
            echo "<div class='error'>ERROR: Invalid activation code</div>";
        }
    ?>
</div>
<?php include 'footer.php'; ?>