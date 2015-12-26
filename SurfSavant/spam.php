<?php
include 'cleanConfig.php';
if($sec->get("url") != "")
{
    $db->query("DELETE FROM `rotator` WHERE `url` LIKE '%{$sec->get('url')}%'");
}
?>