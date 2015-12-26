<?php 
$title = "Contact Us";
$subtext = "";
include 'header.php'; 
?>
<div class="commonFormWrapper">
    <?php
        $form = true;
        if($sec->post("contactSubmit"))
        {
            $to      = 'support@techdime.com';
            $subject = 'BriskSurf: ' . $_POST["contactSubject"];
            $message = "Name: " . $_POST["contactName"] . "\r\n\r\nContent:\r\n" . $_POST["contactText"];
            $headers = 'From: ' . $_POST["contactEmail"] . "\r\n" .
                'Reply-To:  ' . $_POST["contactEmail"] . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            mail($to, $subject, $message, $headers);
            echo "<div class='success'>Your message has been sent. We will reply within the next 48 hours.</div>";
            $form = false;
            //send email with the activation code.
        }
        if($form)
        {
            ?>
                <div class="form commonForm">
                    <form method="post">
                        <?php 
                            $gui->input(["name" => "contactName", "type" => "text"], "Name");
                            echo "<br>";
                            $gui->input(["name" => "contactEmail", "type" => "text"], "Email");
                            echo "<br>";
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