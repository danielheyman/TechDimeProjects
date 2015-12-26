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
            if($JSONArray["amount"] !== null && $JSONArray["id"] !== null)
            {
                $amount = $sec->filter($JSONArray["amount"]);
                $id = $sec->filter($JSONArray["id"]);
                if(is_numeric($amount) && $amount >= 0 && $amount <= 100)
                {
                    $result = $db->query("SELECT SUM(`autoAssign`) AS `autoAssign` FROM `websites` WHERE `userid`='{$usr->data->id}'");
                    $result2 = $db->query("SELECT `autoAssign` FROM `websites` WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                    if($result->getNumRows() && $result2->getNumRows())
                    {
                        $one = $result->getNext()->autoAssign;
                        $two = $result2->getNext()->autoAssign;
                        if(100 - ($one - $two + $amount) >= 0)
                        {
                            $db->query("UPDATE `websites` SET `autoAssign` = '{$amount}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                        }
                        else if($one - $two > 0)  $post['error'] = "You have reached the cap of 100% between all your sites.";
                        else $post['error'] = "You cannot exceed 100%.";
                    }
                    else $post['error'] = "Invalid website";
                }
                else $post['error'] = "Invalid auto assign amount";
            }
            else $post['error'] = "Error during request";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>