<?php
include '../cleanConfig.php';
$post = ['error' => false];

if(isset($_POST["data"])){
    $data_json = $_POST["data"];
    $JSONArray  = json_decode($data_json, true); //returns null if not decoded
    //Values can now be accessed like standard PHP array
    if($JSONArray !== null){
        if($JSONArray["id"] !== null && $JSONArray["text"] !== null)
        {
            $id = $sec->filter($JSONArray["id"]);
            $text = $sec->filter($JSONArray["text"]);
            $db->query("UPDATE `rotator` SET `reported` = 1, `reportText` = '{$text}' WHERE `id` = '{$id}'");
        }
        else $post['error'] = "Error during request3";
    }
    else $post['error'] = "Error during request";
}
else $post['error'] = "Error during request";

echo json_encode($post);
?>