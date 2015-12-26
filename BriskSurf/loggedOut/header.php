<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=$site["url"]?>loggedOut/style.css">
    <link rel="icon" type="image/png" href="<?=$site["url"]?>favicon.ico">
    <script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
    <title><?=$site["name"]?></title>
    <meta name="description" content="<?=$site["description"]?>" />
</head>
<body>
    <div id="header">
        <div class="logo"><a href="<?=$site["url"]?>"><div class="click"></div></a></div>
        <div class="memberLogin">
            <!--<a href="<?=$site["url"]?>contact"><button id="contact" class="button">Contact</button></a>-->
            <a href="<?=$site["url"]?>login"><button id="login" class="button">Login</button></a>
            <a href="http://www.techdime.com/support" target="_blank"><button class="button">Contact Us</button></a>
            <script>
                $("#login").click(function()
               {
                   window.location.href = "<?=$site["url"]?>login";
               });
                /*$("#contact").click(function()
               {
                   window.location.href = "<?=$site["url"]?>contact";
               });*/
            </script>
        </div>
    </div>
    <div id="bgGrey"></div>
    <div id="content">
        <div class="header"><?=$title?></div>
        <div class="subtext">
            <?=$subtext?>
        </div>