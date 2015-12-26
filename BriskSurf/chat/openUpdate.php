<?php
include '../cleanConfig.php';
$post = ['loggedIn' => $usr->loggedIn, 'error' => false];

if($usr->loggedIn)
{
    if(isset($_POST["data"])){
        $data_json = $_POST["data"];
        $JSONArray  = json_decode($data_json, true); //returns null if not decoded
        //Values can now be accessed like standard PHP array
        if($JSONArray !== null){
            if($JSONArray["id"] !== null && $JSONArray["seen"] !== null && $JSONArray["chatid"] !== null)
            {
                $userid = $sec->filter($JSONArray["id"]);
                $chatid = $sec->filter($JSONArray["chatid"]);
                $userEmail = md5(strtolower(trim($usr->data->email)));
                $result = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `users`.`id` = '{$userid}'");
                if($result->getNumRows())
                {
                    $user = $result->getNext();
                    $userEmail2 = md5(strtolower(trim($user->email)));
                    $post['data'] = "";
                    if(isset($JSONArray["seen"]) && $JSONArray["seen"] == true)
                    {
                        $db->query("UPDATE `chat` SET `seen` = '2' WHERE (`fromid`='{$userid}' && `toid`='{$usr->data->id}')");
                    }
                    $query = $db->query("SELECT `id`, `timestamp`, `content`, `fromid`, `toid` FROM `chat` WHERE ((`fromid`='{$userid}' && `toid`='{$usr->data->id}') || (`fromid`='{$usr->data->id}' && `toid`='{$userid}')) && `id` > '{$chatid}' ORDER BY `timestamp` asc");
                    if($query->getNumRows())
                    {
                        while($chat = $query->getNext())
                        {
                            $date = $date = date('M j @ g:i A',strtotime($chat->timestamp));
                            if($chat->fromid == $userid)
                            {
                                $post['data'] .= "<div class='left' style='background:url(http://www.gravatar.com/avatar/{$userEmail2}?s=30); background-position: top left; background-repeat:no-repeat;'><div class='text'>{$chat->content}</div><div class='subtext'>{$date}</div></div>";
                            }
                            else
                            {
                                $post['data'] .="<div class='right' style='background:url(http://www.gravatar.com/avatar/{$userEmail}?s=30); background-position: top right; background-repeat:no-repeat;'><div class='text'>{$chat->content}</div><div class='subtext'>{$date}</div></div>";
                            }
                            $post['chatid'] = $chat->id;
                        }
                    }
                }
                else
                {
                    $post['error'] = "Invalid User";
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