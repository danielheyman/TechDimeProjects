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
			<a href="<?=$site["url"]?>register">
				Create an Account
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
			<h1>Sign In</h1>		
			<br>
            <?php
            if($sec->post("loginEmail"))
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
                        
                        echo "You have been successfully logged in. Redirecting to the members area.";
                        
                        $url = $site["url"];
                        
                        if (strpos($getVar,'s-') !== false) {
                            $getVar = str_replace("s-", "", $getVar);
                            $url = $url . "shield/" . $getVar;
                        }
                        
                        $usr->redirect($url);
                        $form = false;
                    }
                    else if($status == "2") echo "Your account has been suspended. If you beleive this is a mistake, please contact support.";
                    else echo "You must click the activation link in the email we sent you.";
                }
                else echo "Incorrect Username/Password.";
                echo "<br><br>";
            }
            ?>
			<div class="login-fields">
				
				<div class="field">
					<label for="username">Email:</label>
					<input type="text" id="username" name="loginEmail" value="<?php if($sec->post("loginEmail")) echo $sec->post("loginEmail"); ?>" placeholder="Email" class="form-control input-lg username-field" />
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="loginPassword" value="<?php if($sec->post("loginPassword")) echo $sec->post("loginPassword"); ?>" placeholder="Password" class="form-control input-lg password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
									
				<button class="login-action btn btn-primary">Sign In</button>
				
			</div> <!-- .actions -->
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->


<!-- Text Under Box -->
<div class="login-extra">
	Don't have an account? <a href="<?=$site["url"]?>register">Sign Up</a><br/>
	Remind <a href="<?=$site["url"]?>forgot">Password</a><br/>
	Resent <a href="<?=$site["url"]?>resend">Activation</a>
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
