<?php
include '../../cleanConfig.php';
//header('Content-Type: application/json');
$post = ['loggedIn' => $usr->loggedIn, 'error' => false, 'count' => false];

if($usr->loggedIn)
{
    if(isset($_POST["data"])){
        $data_json = $_POST["data"];
        $JSONArray  = json_decode($data_json, true); //returns null if not decoded
        //Values can now be accessed like standard PHP array
        if($JSONArray !== null){
            if($JSONArray["value"] !== null && $JSONArray["id"] !== null && $JSONArray["code"] !== null)
            {
                $id = $sec->filter($JSONArray["id"]);
                $value = $sec->filter($JSONArray["value"]);
                $code = $sec->filter($JSONArray["code"]);
                if($usr->data->surfHash == $code)
                {
                    if($value == "Yes")
                    {
                        $db->query("UPDATE `websites` SET `status` = '1' WHERE `id`='{$id}' && `status`='0'");
                        $post['data'] = "Your site has been added to your account. Click <a href='javascript:gourl(\"{$site['url']}view/{$id}\")'>here</a> to assign credits."; 
                    }
                    else
                    {
                        $db->query("DELETE FROM `websites` WHERE `id`='{$id}' && `status`='0'");
                        $post['data'] = "Your site has been removed. Click <a href='javascript:gourl(\"{$site['url']}\")'>here</a> to return to {$site['name']}.";
                    }
                }
                else $post['error'] = "Error during request";
            }
            else $post['error'] = "Error during request";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>