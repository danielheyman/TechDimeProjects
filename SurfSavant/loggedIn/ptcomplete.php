<?php
include '../cleanConfig.php';
//header('Content-Type: application/json');
$post = ['loggedIn' => $usr->loggedIn, 'error' => false];

if($usr->loggedIn)
{
    if(isset($_POST["data"])){
        $data_json = $_POST["data"];
        $JSONArray  = json_decode($data_json, true); //returns null if not decoded
        //Values can now be accessed like standard PHP array
        if($JSONArray !== null){
            if($JSONArray["userid"] !== null && $JSONArray["ptcid"] !== null)
            {
                $userid = $sec->filter($JSONArray["userid"]);
                $ptcid = $sec->filter($JSONArray["ptcid"]);
                $exists = $db->query("SELECT `id` FROM `ptcviews` WHERE `userid` = '{$userid}' && `ptcid` = '{$ptcid}' LIMIT 1");
                if(!$exists->getNumRows())
                {
                    $earn = $db->query("SELECT `earn` FROM `ptc` WHERE `id` = '{$ptcid}' LIMIT 1");
                    if($earn->getNumRows())
                    {
                        $earn = $earn->getNext()->earn / 1000;
                        $db->query("INSERT INTO `transactions` (`id`, `userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES (NULL, '{$userid}', '-1', 'PTC Cash Bonus', '', '0', CURRENT_TIMESTAMP)");   
                        $id = $db->insertID;
                        $db->query("INSERT INTO `commissions` (`id`, `userid`, `transactionid`, `amount`, `status`) VALUES (NULL, '{$userid}', '{$id}', '{$earn}', '1')"); 
                        $earn *= 2;
                        if($earn == .008) $earn == .007;
                        else if($earn == .01) $earn == .008;
                        $db->query("UPDATE `ptc` SET `amount` = `amount` - {$earn}, `views` = `views` + 1 WHERE `id` = '{$ptcid}' && `amount` >= {$earn} LIMIT 1");
                        $db->query("INSERT INTO `ptcviews` (`ptcid`, `userid`) VALUES ('{$ptcid}','{$userid}')");
                    }
                }
            }
            else $post['error'] = "Error during request";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>