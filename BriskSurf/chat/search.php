<?php include '../cleanConfig.php'; ?>
<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=$site["url"]?>chat/chat.css">
    <script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
</head>
<body>
    <div id="chat" class="search">
    <?php
    if($usr->loggedIn)
    {
        $search = $sec->filter($_GET["s"]);
        $results = $db->query("SELECT `id`, `fullName`, `email` FROM `users` WHERE `fullName` LIKE '%{$search}%' && `id` != '{$usr->data->id}' limit 5");
        if($results->getNumRows())
        {
            while($user = $results->getNext())
            {
                $userEmail = md5(strtolower(trim($user->email)));
                echo "<a href='javascript:parent.parent.startChat(\"{$user->fullName}\",\"{$user->id}\");'><div class='left' style='background:url(http://www.gravatar.com/avatar/{$userEmail}?s=50); background-position: top left; background-repeat:no-repeat;'><div class='text'>{$user->fullName}</div></div></a>";
                    
            }
        } else echo "<div style='padding:10px'/>No results found</div>";
    }
    ?>
        </div>
</body>
</html>