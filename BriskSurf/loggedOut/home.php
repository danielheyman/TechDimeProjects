<?php 
$title = "The Simpler Traffic Exchange.";
$subtext = "BriskSurf is here to do one thing: to make every minute count.<br>
All you have to do is sit back, relax, and watch your click rates go through the roof!";
include 'header.php'; 
?>
<div class="table">
    <div class="one">
        <div class="title">TRACK</div>
        <div class="image"></div>
        <div class="content">
            Completely built around finding what demographic most interacts with your website, our tracking tools allow you to determine which group is best fit to become your target audience.
        </div>
    </div>
    <div class="two">
        <div class="title">TARGET</div>
        <div class="image"></div>
        <div class="content">
            Our powerful interaction rate system with filtering allows you to target your website toward your target audience, bringing in more relevant traffic that will boost your website’s popularity.
        </div>
    </div>
    <div class="three">
        <div class="title">RESULTS</div>
        <div class="image"></div>
        <div class="content">
            Our tools let you track and target your audience, bringing you great results with minimal effort. Every minute you spend brings you more relevant traffic to your website.
        </div>
    </div>
</div>
<div class="signup">
    <div class="title"><!--some message`--></div>
    <?php
        $form = true;
        $getVar = $sec->cookie("ref");
        if($getVar == "") $getVar = "0";
        if($sec->post("registerSubmit"))
        {
            $activation = $sec->randomCode();
            $result = $db->insertUpdate("insert", "users", [
                ["name" => "full name", "type" => "post", "value" => $sec->post("registerFullName"), "field" => "fullName", "valid" => "fullname", "min" => 5, "max" => 50], 
                ["name" => "email", "type" => "post", "value" => $sec->post("registerEmail"), "field" => "email", "valid" => "email", "exists" => true, "max" => 50],
                ["type" => "post", "value" => $activation, "field" => "activation", "min" => 6, "max" => 6],
                ["type" => "post", "value" => "0001", "field" => "membership", "min" => 4, "max" => 4],
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
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'BriskSurf <noreply@techdime.com>',
                                                             'to' => $sec->post("registerEmail"),
                                                             'subject' => 'Welcome to BriskSurf!',
                                                             'text' => "Hi,

Welcome to BriskSurf!

Confirm your account by clicking the link below:
http://brisksurf.com/activate/{$activation}

Best Regards,
The TechDime Team"));
                
                $result = curl_exec($ch);
                curl_close($ch);
                
                echo "<div class='success'>You have been successfully registered. Please check your email for a confirmation code.</div>";
                $form = false;
                //send email with the activation code.
            }
        }
        if($form)
        {
            ?>
                <div class="form">
                    <form method="post">
                        <?php 
                            $gui->input(["name" => "registerFullName", "type" => "text"], "Full Name");
                            $gui->input(["name" => "registerEmail", "type" => "text"], "Email");
                            $gui->input(["name" => "registerSubmit", "type" => "submit", "value" => "Register"]); 
                        ?>
                    </form>
                </div>
            <?php
        }
    ?>
</div>
<?php include 'footer.php'; ?>