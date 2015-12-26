<?php
$query = $db->query("SELECT `description` FROM `users` WHERE `id` = '{$getVar}'");
$des = $query->getNext()->description;
echo ($des != "") ? $des : "The user has not filled in a description."; 
?>