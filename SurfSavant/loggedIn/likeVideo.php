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
            if($JSONArray["isLike"] !== null && $JSONArray["id"] !== null)
            {
                $isLike = $sec->filter($JSONArray["isLike"]);
                $id = $sec->filter($JSONArray["id"]);
                if($isLike == 1 || $isLike == 2)
                {
                    if($db->query("SELECT * FROM `videoLikes` WHERE `videoid` = '{$id}' && `userid` = '{$usr->data->id}'")->getNumRows())
                    {
                        $db->query("UPDATE `videoLikes` SET `isLike` = '{$isLike}' WHERE `videoid` = '{$id}' && `userid` = '{$usr->data->id}'");      
                    }
                    else
                    {
                        $db->query("INSERT INTO `videoLikes` (`isLike`, `videoid`, `userid`) VALUES ('{$isLike}', '{$id}', '{$usr->data->id}')");   
                    }
                }
                else $post['error'] = "Invalid data";
            }
            else $post['error'] = "Error during request3";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>