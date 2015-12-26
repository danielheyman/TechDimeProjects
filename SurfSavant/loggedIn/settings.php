<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <?php
            if($sec->post("settingsFullName"))
            {
                $values = [
                    ["name" => "full name", "type" => "post", "value" => $sec->post("settingsFullName"), "field" => "fullName", "valid" => "fullname", "min" => 5, "max" => 50]
                    ];
                if($sec->post("settingsPassword") != "")
                {
                    $values[] = ["name" => "password", "type" => "post", "pass" => true, "value" => $sec->post("settingsPassword"), "field" => "password", "min" => 5, "max" => 25];
                    $values[] = ["name" => "password", "type" => "compare", "pass" => true, "value" => $sec->post("settingsConfirmPassword")];
                }
                if($sec->post("settingsPaypal") != "")
                {
                    $values[] = ["name" => "paypal email", "type" => "post", "value" => $sec->post("settingsPaypal"), "field" => "paypal", "valid" => "email", "max" => 50];
                }
                $result = $db->insertUpdate("update", "users", $values, ["`id`='{$usr->data->id}'"]);
                if($result != "success") 
                {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> <?=$result?>.
                    </div>
                    <?php
                }
                else{
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Well done!</strong> Your settings have been updated.
                    </div>
                    <?php
                    $usr->getData();
                }
            }
        ?>
    </div>
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-user"></i>
                <h3>Account Settings</h3>
            </div>
            <div class="widget-content">
                <form method="post" id="edit-profile" class="form-horizontal col-md-12">
                    <fieldset>
                        <img src="http://www.gravatar.com/avatar/<?=md5($usr->data->email)?>?s=50"> &nbsp; We use the <a target="_blank" href="http://gravatar.com">Gravatar</a> linked to your email for your profile picture<br>
                        <hr><br>
                        <div class="form-group">											
                            <label for="firstname" class="col-md-4">Full Name</label>
                            <div class="col-md-8">
                                <input name="settingsFullName" type="text" class="form-control" id="firstname" value="<?php echo ($sec->post("settingsFullName")) ? $sec->post("settingsFullName") : $usr->data->fullName?>">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        <div class="form-group">											
                            <label class="col-md-4" for="email">Paypal Email</label>
                            <div class="col-md-8">
                                <input name="settingsPaypal" type="text" class="form-control" id="email" value="<?php echo ($sec->post("settingsPaypal")) ? $sec->post("settingsPaypal") : $usr->data->paypal?>">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        
                        <hr /><br />
                        
                        <div class="form-group">											
                            <label class="col-md-4" for="password1">Password</label>
                            <div class="col-md-8">
                                <input name="settingsPassword" type="password" class="form-control" id="password1" value="">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        
                        <div class="form-group">											
                            <label class="col-md-4" for="password2">Confirm</label>
                            <div class="col-md-8">
                                <input name="settingsConfirmPassword" type="password" class="form-control" id="password2" value="">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        
                            
                            <br />
                        
                            
                        <div class="form-group">
                
                            <div class="col-md-offset-4 col-md-8">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div> <!-- /form-actions -->
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
      		<div class="well">
      			<h4>Paypal Email</h4>
				<p>You want to paid commissions and cash prizes? Right? Don't forget to enter your paypal email so you are not ommited from any payments.</p>
      		</div>
								
	   </div> <!-- /span4 -->

</div>
<?php include 'footer.php'; ?>