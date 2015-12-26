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
		
			<h1>Remind Password</h1>		
			<br>
            <?php
            if($sec->post("loginEmail"))
            {
                $account = $db->query("SELECT `id` FROM `users` WHERE `email`='{$sec->post('loginEmail')}'");
                if($account->getNumRows())
                {
                    $password = $sec->randomCode();
                    $result = $db->insertUpdate("update", "users", [
                        ["name" => "password", "type" => "post", "pass" => true, "value" => $password, "field" => "tempPassword", "min" => 5, "max" => 25]
                    ], ["`email`='{$sec->post('loginEmail')}'"]);
                    if($result != "success") echo $result;
                    else{
                        //SEND EMAIL
                        $ch = curl_init();
                    
                        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/surfsavant.com/messages');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'Surf Savant <support@surfsavant.com>',
                                                                     'to' => $sec->post("loginEmail"),
                                                                     'subject' => 'Surf Savant Password',
                                                                     'text' => "Hi,
    
We have temporarily changed your password. It will only work for one login so make sure to update your password in your settings.
Temporary Password: {$password}

http://surfsavant.com/login

Best Regards,
The Surf Savant Team"));
                        
                        $result = curl_exec($ch);
                        curl_close($ch);
                            
                            
                        echo "We have sent you an email containing a temporary password.";
                    }
                }
                else 
                {
                    echo "Email was not found.";
                }
                echo "<br><br>";
            }
            ?>
			<div class="login-fields">
				
				<div class="field">
					<label for="username">Email:</label>
					<input type="text" id="username" name="loginEmail" value="" placeholder="Email" class="form-control input-lg username-field" />
				</div> <!-- /field -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
									
				<button class="login-action btn btn-primary">Remind</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">
	Don't have an account? <a href="<?=$site["url"]?>login">Sign In</a><br/>
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
