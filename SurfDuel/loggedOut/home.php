<?php include 'header.php'; ?>
<div class="header">May The Best Site Win.</div>
<div class="battleDemo">
    <div class="websiteWrapper">
        <a target="_blank" href="<?php $result = $db->query("SELECT `url` FROM `websites` WHERE `winner` = '1'"); echo $result->getNext()->url; ?>">
            <div class="website websiteOne">
                <!--<div class="head"></div><div class="body"></div><div class="body"></div><div class="body"></div>-->
            </div>
        </a>
    </div>
    <div class="verses">Vs.</div>
    <div class="websiteWrapper">
        <a target="_blank" href="<?php $result = $db->query("SELECT `url` FROM `websites` WHERE `winner` = '2'"); echo $result->getNext()->url; ?>">
            <div class="website websiteTwo">
                <!--<div class="head"></div><div class="body"></div><div class="body"></div><div class="body"></div>-->
            </div>
        </a>
    </div>
</div>
<?php
    $getVar = $sec->cookie("ref");
    if($getVar == "") $getVar = "0";
    if($sec->post("registerSubmit"))
    {
        if(isset($_POST['registerTOS']))
        {
            $activation = $sec->randomCode();
            $result = $db->insertUpdate("insert", "users", [
                ["name" => "full name", "type" => "post", "value" => $sec->post("registerName"), "field" => "fullName", "valid" => "fullname", "min" => 5, "max" => 50], 
                ["name" => "email", "type" => "post", "value" => $sec->post("registerEmail"), "field" => "email", "valid" => "email", "exists" => true, "max" => 50],
                ["name" => "password", "type" => "post", "pass" => true, "value" => $sec->post("registerPassword"), "field" => "password", "min" => 5, "max" => 25], 
                ["type" => "post", "value" => $activation, "field" => "activation", "min" => 6, "max" => 6],
                ["type" => "post", "value" => $getVar, "field" => "ref", "min" => 1, "max" => 9]
            ]);
            if($result != "success") echo "<div class='error'>ERROR: " . $result . "</div>";
            else{
                //SEND EMAIL
                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/techdime.com/messages');
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'SurfDuel <noreply@techdime.com>',
                                                             'to' => $sec->post("registerEmail"),
                                                             'subject' => 'Welcome to SurfDuel!',
                                                             'text' => "Hi,
    
Welcome to SurfDuel!

Confirm your account by clicking the link below:
http://www.surfduel.com/activate/{$activation}

Best Regards,
The TechDime Team"));
                
                $result = curl_exec($ch);
                curl_close($ch);
                
                echo "<div class='success'>You have been successfully registered. Please check your email for a confirmation code.</div>";
                //send email with the activation code.
            }
        }
        else echo "<div class='error'>ERROR: You must agree to the terms of service.</div>";
    }
?>
<div class="tableinfo">
    <div class="wrap">
        <div class="column one image">
            <div class="title">A Revamped TE</div>
            <div class="text">Completely redesigned to deliver more traffic</div>
        </div>
        <div class="column two image">
            <div class="title">Dueling System</div>
            <div class="text">Battle your way to become the winner of the day</div>
       </div>
        <div class="column three">
            <div class="title">Register Now</div>
            <div class="register">
                <form method="post">
                    <?php $gui->input(["name" => "registerName", "type" => "text"],"Full Name"); ?><br>
                    <?php $gui->input(["name" => "registerEmail", "type" => "text"],"Email"); ?><br>
                    <?php $gui->input(["name" => "registerPassword", "type" => "password"],"Password"); ?><br>
                    <input name="registerTOS" type="checkbox"/> I agree to the <a href="<?=$site["url"]?>tos">Terms of Service</a><br>
                    <?php $gui->input(["name" => "registerSubmit", "type" => "submit", "value" => "Register"]); ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>