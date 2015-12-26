<?php
include '../cleanConfig.php';
if($sec->post("message"))
{
    $message = $sec->post("message");
    $db->query("UPDATE `users` SET `splash2` = '{$message}' WHERE `id` = '{$usr->data->id}'");
}
?>