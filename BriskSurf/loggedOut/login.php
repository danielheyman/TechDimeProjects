<?php 
$title = "Login to your account!";
$subtext = "";
include 'header.php'; 
?>
<div class="commonFormWrapper">
    <?php
        $form = true;
        if($sec->post("loginSubmit"))
        {
            $pass = md5($sec->post('loginPassword'));
            $query = $db->query("SELECT id, activation FROM `users` WHERE `email`='{$sec->post('loginEmail')}' && (`password`='{$pass}' || `tempPassword`='{$pass}') LIMIT 1");
            if($query->getNumRows())
            {
                $query = $query->getNext(); 
                $status = $query->activation;
                $id = $query->id;
                if($status == "1")
                {
                    $db->query("UPDATE `users` SET `lastLogin` = NOW(), `tempPassword` = '', loginIP = '{$usr->visitorIP()}' WHERE `id` = '{$id}' LIMIT 1");
                    $ydsession = md5($sec->randomCode());
                    $hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $ydsession);
                    $db->query("INSERT INTO `sessions` (`userid`, `hash`) VALUES ('{$id}', '{$hash}')");
                    setcookie("YDSESSION", $ydsession, time()+60*60*24*7,"/");
                    
                    echo "<div class='success'>You have been successfully logged in. Redirecting to the members area.</div>";
                    $usr->redirect($site["url"]);
                    $form = false;
                }
                else if($status == "2") echo "<div class='error'>ERROR: Your account has been suspended. If you beleive this is a mistake, please contact support.</div>";
                else echo "<div class='error'>ERROR: You must click the activation link in the email we sent you.</div>";
            }
            else echo "<div class='error'>ERROR: The login details are incorrect</div>";
        }
        if($form)
        {
            ?>
                <div class="form commonForm">
                    <form method="post">
                        <?php 
                            $gui->input(["name" => "loginEmail", "type" => "text"],"Email");
                            echo "<br>";
                            $gui->input(["name" => "loginPassword", "type" => "password"], "Password");
                            echo "<br>";
                            $gui->input(["name" => "loginSubmit", "type" => "submit", "value" => "Login"]);
                        ?>
                    </form>
                    <br><br>
                    <a href='<?=$site["url"]?>forgot'><?php
                        $gui->input(["name" => "forgotPassword", "type" => "submit", "value" => "Forgot Password?"]); 
                    ?></a><br>
                    <a href='<?=$site["url"]?>resend'><?php
                        $gui->input(["name" => "resendActivation", "type" => "submit", "value" => "Resend Activation"]); 
                    ?></a>
                </div>
            <?php
        }
    ?>
</div>
<?php include 'footer.php'; ?>