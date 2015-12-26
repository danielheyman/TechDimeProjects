<?php
setcookie("ajax_chat","/",time()-3600); 
$usr->logOut();
$usr->redirect($site["url"]);
?>