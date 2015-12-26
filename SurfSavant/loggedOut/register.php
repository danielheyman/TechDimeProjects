<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Surf Savant</title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes"> 
    
	<link href="<?=$site["url"]?>res/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="<?=$site["url"]?>res/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
	
	<link href="<?=$site["url"]?>res/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    
    <link href="<?=$site["url"]?>res/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">
    
    <link href="<?=$site["url"]?>res/css/base-admin-3.css" rel="stylesheet">
    <link href="<?=$site["url"]?>res/css/base-admin-3-responsive.css" rel="stylesheet">
      
    <link href="<?=$site["url"]?>res/css/base-admin-tweaks.css" rel="stylesheet">
    
    <link href="<?=$site["url"]?>res/css/pages/signin.css" rel="stylesheet" type="text/css">

    <link href="<?=$site["url"]?>res/css/custom.css" rel="stylesheet">

</head>

<body>
	
<nav class="navbar navbar-inverse" role="navigation">

	<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="<?=$site["url"]?>"><!--<i class="icon-shield"></i> &nbsp;<?=$site["name"]?>-->&nbsp;</a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav navbar-right">
      <li class="">						
			<a href="<?=$site["url"]?>login">
				Sign In
			</a>			
		</li>

		<li class="">
						
			<a href="<?=$site["url"]?>">
				<i class="icon-chevron-left"></i>&nbsp;&nbsp; 
				Back to Homepage
			</a>
			
		</li>
    </ul>
  </div><!-- /.navbar-collapse -->
</div> <!-- /.container -->
</nav>



<div class="account-container stacked">
	
	<div class="content clearfix">
		
		<form method="post">
		
			<h1>Create Your Account</h1>	
			<br>
            <?php
            $getVar = $sec->cookie("ref");
            if($getVar == "") $getVar = "0";
            $registered = false;
            if($sec->post("registerName"))
            {
                if(isset($_POST['registerTOS']))
                {
                    $activation = $sec->randomCode();
                    $result = $db->insertUpdate("insert", "users", [
                        ["name" => "full name", "type" => "post", "value" => $sec->post("registerName"), "field" => "fullName", "valid" => "fullname", "min" => 5, "max" => 50], 
                        ["name" => "email", "type" => "post", "value" => $sec->post("registerEmail"), "field" => "email", "valid" => "email", "exists" => true, "max" => 50],
                        ["name" => "password", "type" => "post", "pass" => true, "value" => $sec->post("registerPassword"), "field" => "password", "min" => 5, "max" => 25], 
                        ["name" => "password", "type" => "check", "pass" => true, "value" => $sec->post("registerPassword2"), "field" => "password"], 
                        ["type" => "post", "value" => $activation, "field" => "activation", "min" => 6, "max" => 6],
                        ["type" => "post", "value" => $getVar, "field" => "ref", "min" => 1, "max" => 9]
                    ]);
                    if($result != "success") echo $result;
                    else{
                        if(isset($_COOKIE["bonus"]) && $_COOKIE["bonus"] == "1")
                        {
                            setcookie("bonus", "0", time()-3600, "/");
                            $getid = $db->query("SELECT `id` FROM `users` WHERE `activation` = '{$activation}'")->getNext()->id;
                            $db->query("INSERT INTO `transactions` (`id`, `userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES (NULL, '0', '-1', 'Signup Cash Bonus', '', '0', CURRENT_TIMESTAMP)");   
                            $id = $db->insertID;
                            $db->query("INSERT INTO `commissions` (`id`, `userid`, `transactionid`, `amount`, `status`) VALUES (NULL, '{$getid}', '{$id}', '2.00', '1')");
                        }
                        //SEND EMAIL
                        $ch = curl_init();
                    
                        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/surfsavant.com/messages');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'Surf Savant <support@surfsavant.com>',
                                                                     'to' => $sec->post("registerEmail"),
                                                                     'subject' => 'Welcome to Surf Savant!',
                                                                     'text' => "Hi,
            
Welcome to Surf Savant !

Confirm your account by clicking the link below:
http://www.surfsavant.com/activate/{$activation}

Best Regards,
The Surf Savant Team"));
                        
                        $result = curl_exec($ch);
                        curl_close($ch);
                        
                        echo "You have been successfully registered. Please check your email for a confirmation code.";
                        $registered = true;
                        //send email with the activation code.
                    }
                }
                else echo "You must agree to the terms of service.";
                echo "<br><br>";
            }
            if(!$registered)
            {
            ?>
			<div class="login-fields">
				
				
				<div class="field">
					<label for="firstname">Full Name:</label>
					<input type="text" id="firstname" name="registerName" value="<?php if(!$registered && $sec->post("registerName")) echo $sec->post("registerName"); ?>" placeholder="Full Name" class="form-control username-field" />
				</div> <!-- /field -->
				
				
				<div class="field">
					<label for="email">Email Address:</label>
					<input type="text" id="email" name="registerEmail" value="<?php if(!$registered && $sec->post("registerEmail")) echo $sec->post("registerEmail"); ?>" placeholder="Email" class="form-control username-field"/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="registerPassword" value="<?php if(!$registered && $sec->post("registerPassword")) echo $sec->post("registerPassword"); ?>" placeholder="Password" class="form-control password-field"/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="confirm_password">Confirm Password:</label>
					<input type="password" id="confirm_password" name="registerPassword2" value="<?php if(!$registered && $sec->post("registerPassword2")) echo $sec->post("registerPassword2"); ?>" placeholder="Confirm Password" class="form-control password-field"/>
				</div> <!-- /field -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
				<span class="login-checkbox">
					<input id="Field" name="registerTOS" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
					<label class="choice" for="Field">I have read and agree with the <a href="<?=$site['url']?>tos">Terms of Service</a>.</label>
				</span>
									
				<button class="login-action btn btn-primary">Register</button>
				
			</div> <!-- .actions -->
			<?php } ?>
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">
	Already have an account? <a href="<?=$site["url"]?>login">Sign In</a>
</div> <!-- /login-extra -->


<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?=$site["url"]?>res/js/libs/jquery-1.9.1.min.js"></script>
<script src="<?=$site["url"]?>res/js/libs/jquery-ui-1.10.0.custom.min.js"></script>
<script src="<?=$site["url"]?>res/js/libs/bootstrap.min.js"></script>

<script src="<?=$site["url"]?>res/js/Application.js"></script>

<script src="<?=$site["url"]?>res/js/demo/signin.js"></script>

</body>
</html>
