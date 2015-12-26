<?php include 'header.php'; ?>
<div class="header">Login</div>
<?php
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
?>
<div class="tableinfo">
    <div class="wrap">
        <div class="column one">
        </div>
        <div class="column two">
            <div class="register">
                <form method="post">
                    <?php $gui->input(["name" => "loginEmail", "type" => "text"],"Email"); ?><br>
                    <?php $gui->input(["name" => "loginPassword", "type" => "password"],"Password"); ?><br>
                    <?php $gui->input(["name" => "loginSubmit", "type" => "submit", "value" => "Login"]); ?><br>
                </form><br><br><br>
                <a href="<?=$site["url"]?>forgot"><?php $gui->input(["type" => "submit", "value" => "Forgot Password?"]); ?></a><br>
                <a href="<?=$site["url"]?>resend"><?php $gui->input(["type" => "submit", "value" => "Resend Activation"]); ?></a>
            </div>
        </div>
        <div class="column three">
       </div>
    </div>
</div>
<?php include 'footer.php'; ?>