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
            if($JSONArray["id"] !== null && $JSONArray["filters"] !== null)
            {
                $id = $sec->filter($JSONArray["id"]);
                $result = $db->query("SELECT `exceptions` FROM `websites` WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                if($result->getNumRows())
                {
                    $exceptions = $result->getNext()->exceptions;
                    foreach($JSONArray["filters"] as $key => $value)
                    {
                        $key = $sec->filter($key);
                        $value = $sec->filter($value);
                        if($value)
                        {
                            if(strpos($exceptions, $key) !== false)
                            {
                                $exceptions = str_replace("{$key}", "", $exceptions);   
                                $exceptions = str_replace(",,", ",", $exceptions);   
                            }
                        }
                        else
                        {
                            if(strpos($exceptions, $key) === false) $exceptions .= ",{$key}";
                        }
                    }
                    if($exceptions[0] == ",") $exceptions = substr($exceptions, 1);
                    $db->query("UPDATE `websites` SET `exceptions` = '{$exceptions}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                }
                else $post['error'] = "Invalid website";
            }
            else $post['error'] = "Error during request";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>