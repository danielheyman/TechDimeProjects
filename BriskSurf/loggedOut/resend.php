<?php 
$title = "Resend activation email";
$subtext = "Please check your spam folder and add 'noreply@techdime.com' to your contact list.<br>If you are using the new Gmail interface, make sure to check the Promotions tab.";
include 'header.php'; 
?>
<div class="commonFormWrapper">
    <?php
        $form = true;
        if($sec->post("resendEmail"))
        {
            $query = $db->query("SELECT activation FROM `users` WHERE `email`='{$sec->post('resendEmail')}' LIMIT 1");
            if($query->getNumRows())
            {
                $query = $query->getNext(); 
                $activation = $query->activation;
                if($activation != "1" && $activation != "2")
                {
                    
                    //SEND EMAIL
                    $ch = curl_init();
                
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/techdime.com/messages');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'BriskSurf <noreply@techdime.com>',
                                                                 'to' => $sec->post("resendEmail"),
                                                                 'subject' => 'Welcome to BriskSurf!',
                                                                 'text' => "Hi,

Welcome to BriskSurf!

Confirm your account by clicking the link below:
http://brisksurf.com/activate/{$activation}

Best Regards,
The TechDime Team"));
                
                    $result = curl_exec($ch);
                    curl_close($ch);
                    echo "<div class='success'>We have resent you the email.<br>Please check your spam folder and add 'noreply@techdime.com' to your contact list.<br>If you are using the new Gmail interface, make sure to check the Promotions tab.</div>";
                    $form = false;
                }
                else echo "<div class='error'>ERROR: You are already activated</div>";
            }
            else echo "<div class='error'>ERROR: The email was not found</div>";
        }
        if($form)
        {
            ?>
                <div class="form commonForm">
                    <form method="post">
                        <?php 
                            $gui->input(["name" => "resendEmail", "type" => "text"],"Email");
                            echo "<br>";
                            $gui->input(["name" => "resendSubmit", "type" => "submit", "value" => "Resend"]);
                        ?>
                    </form>
                </div>
            <?php
        }
    ?>
</div>
<?php include 'footer.php'; ?>