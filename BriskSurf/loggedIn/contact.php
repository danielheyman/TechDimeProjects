<?php include 'header.php'; ?>
<div class="title">Contact Us</div>
<hr>
<div class="text">
    <?php
        $form = true;
        if($sec->post("contactSubmit"))
        {
            $to      = 'support@techdime.com';
            $subject = 'BriskSurf: ' . $_POST["contactSubject"];
            $message = "Userid: {$usr->data->id}\r\nName: {$usr->data->fullName}\r\n\r\nContent:\r\n" . $_POST["contactText"];
            $headers = 'From: ' . $usr->data->email . "\r\n" .
                'Reply-To:  ' . $usr->data->email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            mail($to, $subject, $message, $headers);
            echo "<div class='success'>Your message has been sent. We will reply within the next 48 hours.</div>";
            $form = false;
            //send email with the activation code.
        }
        if($form)
        {
            ?>
                <div class="form">
                    <form method="post">
                        <?php 
                            $gui->input(["name" => "contactSubject", "type" => "text"], "Subject");
                            echo "<br><br>Message:<br><textarea name='contactText'></textarea><br><br>";
                            $gui->input(["name" => "contactSubmit", "type" => "submit", "value" => "Send"]); 
                        ?>
                    </form>
                </div>
            <?php
        }
    ?>
</div>
<?php include 'footer.php'; ?>