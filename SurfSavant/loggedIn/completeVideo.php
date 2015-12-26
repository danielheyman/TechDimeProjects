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
            if($JSONArray["id"] !== null)
            {
                $id = $sec->filter($JSONArray["id"]);
                $test = $db->query("SELECT `id` FROM `videoCompletes` WHERE `userid` = '{$usr->data->id}' && `videoid` = '{$id}'");
                if(!$test->getNumRows())
                {
                    $db->query("INSERT INTO `videoCompletes` (`userid`,`videoid`) VALUES ('{$usr->data->id}','{$id}')");
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