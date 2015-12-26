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
            if($JSONArray["id"] !== null && $JSONArray["ref"] !== null)
            {
                $id = $sec->filter($JSONArray["id"]);
                $ref = $sec->filter($JSONArray["ref"]);
                $test = $db->query("SELECT `id` FROM `videoRefs` WHERE `userid` = '{$usr->data->id}' && `videoid` = '{$id}'");
                if(!$test->getNumRows())
                {
                    $db->query("INSERT INTO `videoRefs` (`userid`,`videoid`, `ref`) VALUES ('{$usr->data->id}','{$id}','{$ref}')");
                }
                else
                {
                    $db->query("UPDATE `videoRefs` SET `ref` = '{$ref}' WHERE `userid` = '{$usr->data->id}' && `videoid` = '{$id}'");
                }
            }
            else $post['error'] = "Error during request3";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>