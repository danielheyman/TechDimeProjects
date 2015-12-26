<?php
include 'cleanConfig.php';
if($sec->get("url") != "")
{
    $result = $db->query("SELECT `userid` FROM `websites` WHERE `url` LIKE '%{$sec->get('url')}%'");
    if($result->getNumRows())
    {
        while($user = $result->getNext())
        {
            $db->query("UPDATE `users` SET `activation` = '2' WHERE `id` = '{$user->userid}'");   
        }
    }
    $db->query("DELETE FROM `websites` WHERE `url` LIKE '%{$sec->get('url')}%'");
}
?>