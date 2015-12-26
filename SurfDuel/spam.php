<?php
include 'cleanConfig.php';
if($sec->get("url") != "")
{
    $db->query("DELETE FROM `websites` WHERE `url` LIKE '%{$sec->get('url')}%'");
}
?>