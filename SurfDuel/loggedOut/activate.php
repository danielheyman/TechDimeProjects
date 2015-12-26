<?php include 'header.php'; ?>
    <div class="header">Account Activation</div>
    <?php
    $account = $db->query("SELECT `id`, `email`, `fullName` FROM `users` WHERE `activation`='{$getVar}' LIMIT 1");
    if(strlen($getVar) == 6 && $account->getNumRows())
    {
        $account = $account->getNext();
        $db->query("UPDATE `users` set `activation` = '1' WHERE `activation`='{$getVar}' LIMIT 1");
        
        //ADD MEMBER TO LIST
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        curl_setopt(
        $ch, CURLOPT_URL, 'https://api.mailgun.net/v2/lists/surfduel@techdime.com/members');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('address' => $account->email,
                                                 'name' => $account->fullName,
                                                 'vars' => '{"id": "' . $account->id . '"}'));
    
        $result = curl_exec($ch);
        curl_close($ch);
        
        //ADD $3 COMMISSIONS
        $db->query("INSERT INTO `transactions` (`id`, `userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES (NULL, '0', '-1', 'Cash Bonus', '', '0', CURRENT_TIMESTAMP)");   
        $id = $db->insertID;
        $db->query("INSERT INTO `commissions` (`id`, `userid`, `transactionid`, `amount`, `status`) VALUES (NULL, '{$account->id}', '{$id}', '3.00', '1')"); 
        
        echo "<div class='success'>SUCCESS: Your account has been successfuly activated. You may now login.</div>";   
    }
    else
    {
        echo "<div class='error'>ERROR: Invalid activation code.</div>";  
    }
    ?>
<?php include 'footer.php'; ?>