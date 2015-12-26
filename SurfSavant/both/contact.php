<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <?php
        if($sec->post("contactSubject"))
        {
            if($usr->loggedIn)
            {
                $name = $usr->data->fullName;  
                $email = $usr->data->email;
                $id = $usr->data->id;
            }
            else
            {
                $name = $_POST["contactName"];  
                $email = $_POST["contactEmail"];   
                $id = "N\A";
            }
            $to      = 'support@surfsavant.com';
            $subject = 'SurfSavant: ' . $_POST["contactSubject"];
            $message = "Userid: " . $id . "\r\nName: " . $name . "\r\n\r\nContent:\r\n" . $_POST["contactText"];
            $headers = 'From: ' . $email . "\r\n" .
                'Reply-To:  ' . $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
            
            mail($to, $subject, $message, $headers);
            ?>
            <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <strong>Congrats!</strong> We have recieved your ticket and will reply within 48 hours.
            </div>
            <?php
        }
        ?>
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-envelope"></i>
                <h3>Contact Support</h3>
            </div>
            
            <div class="widget-content">
                <form method="post" class="form-horizontal col-md-8">
                    <fieldset>
                        <?php if(!$usr->loggedIn) { ?>
                        <div class="form-group">											
                            <label for="contactName" class="col-md-4">Name</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="contactName" name="contactName">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        <div class="form-group">											
                            <label for="contactEmail" class="col-md-4">Email</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="contactEmail" name="contactEmail">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        <?php } ?>
                        
                        <div class="form-group">											
                            <label class="col-md-4" for="contactSubject">Subject</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="contactSubject" name="contactSubject">
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        <div class="form-group">											
                            <label class="col-md-4" for="contactText">Message</label>
                            <div class="col-md-8">
                                <textarea name="contactText" class="form-control" id="contactText" value="rod.howard@example.com"></textarea>
                            </div> <!-- /controls -->				
                        </div> <!-- /control-group -->
                        
                        <div class="form-group">
        
                            <div class="col-md-offset-4 col-md-8">
                                <button type="submit" class="btn btn-primary">Send</button> 
                            </div>
                        </div> <!-- /form-actions -->
    
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>