<?php include '../cleanConfig.php'; ?><!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=$site["url"]?>chat/chat.css">
    <script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
    <script>
        $(document).ready(function()
        {
            $("#searchMessage").keypress(function(e) {
                if(e.which == 13) {
                    sendMessage();
                }
            });
            $("#searchSubmit").click(function() {
                    sendMessage();
            });
            $("#cancel").click(function() {
                $("#chat").show();
                $("#cancel").hide();
                $("#searchResults").hide();
            });
        });
        
        function sendMessage()
        {
            if($("#searchMessage").val() != "" && $("#searchMessage").val() != " " && $("#searchMessage").val() != "Search Name")
            {
                $("#searchResults").attr("src", "<?=$site['url']?>chat/search.php?s=" + $("#searchMessage").val());
                $("#chat").hide();
                $("#cancel").show();
                $("#searchResults").show();
            }
        }
        
        
        function update()
        {
            $.ajax({
                type: "POST",
                url: "<?=$site['url']?>chat/listUpdate.php",
                success: function(data) {
                    if(data != "")
                    {
                        $("#chat").html(data);
                    }
                    else
                    {
                        $("#chat").html("<div style='margin:10px'>Click <a href='javascript: window.top.location.href = \"<?=$site["url"]?>promo\"'>here</a> to message your referrals. You can also search and chat with members by searching for their names below.</div>");
                    }
                    setTimeout(update, 2000);
                        
                },
                error: function(data)
                {
                    console.log(data);
                }
            });
        }
        update();
    </script>
</head>
<body>
    <a href="javascript:void(0);"><div id="cancel">Cancel</div></a>
    <iframe id="searchResults" src=""></iframe>
    <div id="chat">
        
    </div>
    <div id="search"><?php $gui->input(["id" => "searchMessage", "name" => "sendMessage", "type" => "text"], "Search Name"); ?><input id="searchSubmit" type="submit" name="submitMessage" value="Search"/></div>
</body>
</html>