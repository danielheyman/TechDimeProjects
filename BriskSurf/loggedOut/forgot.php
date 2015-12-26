<?php 
$title = "Forgot Password?";
$subtext = "Complete the following form to recieve a temporary password.";
include 'header.php'; 
?>
<div class="commonFormWrapper">
    <?php
        $form = true;
        if($sec->post("forgotSubmit"))
        {
            $account = $db->query("SELECT `id` FROM `users` WHERE `email`='{$sec->post('forgotEmail')}'");
            if($account->getNumRows())
            {
                $password = $sec->randomCode();
                $result = $db->insertUpdate("update", "users", [
                    ["name" => "password", "type" => "post", "pass" => true, "value" => $password, "field" => "tempPassword", "min" => 5, "max" => 25]
                ], ["`email`='{$sec->post('forgotEmail')}'"]);
                if($result != "success") echo "<div class='error'>ERROR: " . $result . "</div>";
                else{
                    //SEND EMAIL
                    $ch = curl_init();
                
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/techdime.com/messages');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'BriskSurf <noreply@techdime.com>',
                                                                 'to' => $sec->post("forgotEmail"),
                                                                 'subject' => 'BriskSurf Password',
                                                                 'text' => "Hi,

We have temporarily changed your password. It will only work for one login so make sure to update your password in your settings.
Temporary Password: {$password}

http://brisksurf.com/login

Best Regards,
The TechDime Team"));
                    
                    $result = curl_exec($ch);
                    curl_close($ch);
                        
                        
                    echo "<div class='success'>We have sent you an email containing a temporary password</div>";
                    $form = false;
                    //$usr->redirect($site["url"]);
                }
            }
            else 
            {
                echo "<div class='error'>ERROR: Email was not found</div>";
            }
        }
        if($form)
        {
            ?>
                <div class="form commonForm">
                    <form method="post">
                        <?php 
                            $gui->input(["name" => "forgotEmail", "type" => "text"],"Email");
                            echo "<br>";
                            $gui->input(["name" => "forgotSubmit", "type" => "submit", "value" => "Submit"]); 
                        ?>
                    </form>
                </div>
            <?php
        }
    ?>
</div>
<?php include 'footer.php'; ?>