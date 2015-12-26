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
            if($JSONArray["id"] !== null && $JSONArray["content"] !== null)
            {
                $id = $sec->filter($JSONArray["id"]);
                $content = $sec->filter($JSONArray["content"]);
                $db->query("INSERT INTO `chat` (`fromid`, `toid`, `content`) VALUES ('{$usr->data->id}','{$id}','{$content}')");
            }
            else $post['error'] = "Error during request";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>