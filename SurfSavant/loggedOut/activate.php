<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-ok"></i>
                <h3>Activate Account</h3>
            </div>
            <div class="widget-content">
                <p>
                    <?php
                    $account = $db->query("SELECT `id`, `email`, `fullName` FROM `users` WHERE `activation`='{$getVar}' LIMIT 1");
                    if(strlen($getVar) == 6 && $account->getNumRows())
                    {
                        $account = $account->getNext();
                        $db->query("UPDATE `users` set `activation` = '1', `registerIP` = '{$usr->visitorIP()}' WHERE `activation`='{$getVar}' LIMIT 1");
                        
                        //ADD MEMBER TO LIST
                        $ch = curl_init();
                    
                        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    
                        curl_setopt(
                        $ch, CURLOPT_URL, 'https://api.mailgun.net/v2/lists/sendout@surfsavant.com/members');
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                        curl_setopt($ch, CURLOPT_POSTFIELDS, array('address' => $account->email,
                                                                 'name' => $account->fullName,
                                                                 'vars' => '{"id": "' . $account->id . '"}'));
                    
                        $result = curl_exec($ch);
                        curl_close($ch);
                        
                        echo "Your account has been successfuly activated. You may now sign in.";   
                    }
                    else
                    {
                        echo "Invalid activation code.";  
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>