<?php include 'header.php'; ?>
<div class="header">Contact Us</div>
    <?php
        $form = true;
        if($sec->post("contactSubmit"))
        {
            if($usr->loggedIn)
            {
                $name = $usr->data->fullName;  
                $email = $usr->data->email;
                $id = $usr->data->id;
            }
            else
            {
                $name = $_POST["contactName"];  
                $email = $_POST["contactEmail"];   
                $id = "N\A";
            }
            $to      = 'support@techdime.com';
            $subject = 'SurfDuel: ' . $_POST["contactSubject"];
            $message = "Userid: " . $id . "\r\nName: " . $name . "\r\n\r\nContent:\r\n" . $_POST["contactText"];
            $headers = 'From: ' . $email . "\r\n" .
                'Reply-To:  ' . $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            mail($to, $subject, $message, $headers);
            echo "<div class='success'>Your message has been sent. We will reply within the next 48 hours.</div>";
            $form = false;
            //send email with the activation code.
        }
        if($form)
        {
            ?>
                <div class="tableinfo" style="height:450px;">
                    <div class="wrap">
                        <div class="column one" style="width:157px;height:450px;">
                        </div>
                        <div class="column two" style="width:397px;height:450px;">
                            <div class="register">
                                <form method="post">
                                        <?php 
                                            if(!$usr->loggedIn)
                                            {
                                                $gui->input(["name" => "contactName", "type" => "text"], "Name");
                                                echo "<br>";
                                                $gui->input(["name" => "contactEmail", "type" => "text"], "Email");
                                                echo "<br>";
                                            }
                                            $gui->input(["name" => "contactSubject", "type" => "text"], "Subject");
                                            echo "<br><br>Message:<br><textarea name='contactText'></textarea><br>";
                                            $gui->input(["name" => "contactSubmit", "type" => "submit", "value" => "Send"]); 
                                        ?>
                                </form>
                            </div>
                        </div>
                        <div class="column three" style="width:157px;height:450px;"
                       </div>
                    </div>
                </div>
            <?php
        }
    ?>
<?php include 'footer.php'; ?>