<?php
include 'cleanConfig.php';
if($sec->get("id"))
{
    $query = $db->query("SELECT `email` FROM `users` WHERE `id` = '{$sec->get('id')}'");
    if($query->getNumRows())
    {
        $email = md5($query->getNext()->email);
        
        header( "Location: http://www.gravatar.com/avatar/{$email}?s=30" );
    }
}
?>