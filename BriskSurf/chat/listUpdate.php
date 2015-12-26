<?php
include '../cleanConfig.php';
//header('Content-Type: application/json');

if($usr->loggedIn)
{
    $query = $db->query("SELECT type, otherperson, id, content, timestamp, seen FROM (SELECT DISTINCT 'from' as type, toid AS otherperson, id, content, timestamp, seen from chat where chat.fromid= '{$usr->data->id}' UNION SELECT DISTINCT 'to' as type, fromid AS otherperson, id, content, timestamp, seen from chat where chat.toid= '{$usr->data->id}' order by id desc) as results group by otherperson ORDER BY id desc");
    if($query->getNumRows())
    {
        $unseen = 0;
        while($chat = $query->getNext())
        {
            $date = $date = date('M j @ g:i A',strtotime($chat->timestamp));
            $result = $db->query("SELECT `fullName`, `email` FROM `users` WHERE `users`.`id` = '{$chat->otherperson}'");
            $user = $result->getNext();
            $userEmail2 = md5(strtolower(trim($user->email)));
            $firstName = explode(" ", $user->fullName)[0];
            $userEmail = md5(strtolower(trim($usr->data->email)));
            $seen = ($chat->seen == "1" && $chat->type == "to") ? "seen" : "";
            if($seen != "")
            {
                echo "<script>parent['newunseen'] = true;</script>";
                $unseen++;
            }
            $content = implode(' ', array_slice(explode(' ', $chat->content), 0, 7));
            if($content != $chat->content) $content .= " ...";
            if($chat->type == "to")
            {
                echo "<a href='javascript:parent.startChat(\"{$user->fullName}\",\"{$chat->otherperson}\");'><div class='left {$seen}' style='background:url(http://www.gravatar.com/avatar/{$userEmail2}?s=30); background-position: top left; background-repeat:no-repeat;'><div class='text'>{$content}</div><div class='subtext'>{$firstName} - {$date}</div></div></a>";
            }
            else
            {
                $userEmail = md5(strtolower(trim($usr->data->email)));
                echo "<a href='javascript:parent.startChat(\"{$user->fullName}\",\"{$chat->otherperson}\");'><div class='right {$seen}' style='background:url(http://www.gravatar.com/avatar/{$userEmail}?s=30); background-position: top right; background-repeat:no-repeat;'><div class='text'>{$content}</div><div class='subtext'>{$firstName} - {$date}</div></div></a>";
            }
        }
        if($unseen == 0) echo "<script>parent['newunseen'] = false;</script>";
    }
}
?>