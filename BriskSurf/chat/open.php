<?php include '../cleanConfig.php'; ?><!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=$site["url"]?>chat/chat.css">
    <script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
    <script>
        $(document).ready(function()
        {
            $("#sendMessage").keypress(function(e) {
                if(e.which == 13) {
                    sendMessage();
                }
            });
            $("#submitMessage").click(function() {
                    sendMessage();
            });
        });
        
        function sendMessage()
        {
            var content = $("#sendMessage").val();
            $("#sendMessage").val("Sending...");
            data = {"id": '<?=$_GET["id"]?>', "content": content}
            var data_encoded = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: "<?=$site['url']?>chat/openSubmit.php",
                dataType: "json",
                data: {
                    "data" : data_encoded
                },
                success: function(data) {
                    if(!data.loggedIn)
                    {
                         $("#sendMessage").val("Not Logged In");
                    }
                    else if(data.error)
                    {
                        $("#sendMessage").val("ERROR: " + data.error);
                    }
                    else
                    {
                        $("#sendMessage").val("");
                    }
                },
                error: function(data)
                {
                    console.log(data);
                }
            });
        }
        
        var chatid = 0;
        function update()
        {
            data = {"id": '<?=$_GET["id"]?>', "chatid": chatid, "seen": parent["chat<?=$_GET["id"]?>"]}
            var data_encoded = JSON.stringify(data);
            $.ajax({
                type: "POST",
                url: "<?=$site['url']?>chat/openUpdate.php",
                dataType: "json",
                data: {
                    "data" : data_encoded
                },
                success: function(data) {
                    if(data.data != "")
                    {
                        if(data.chatid) chatid = data.chatid;
                        $("#chat").append(data.data);
                        $("html, body").animate({ scrollTop: $(document).height() });
                    }
                    setTimeout(update, 500);
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
    <div id="chat">
        
    </div>
    <div id="message"><?php $gui->input(["id" => "sendMessage", "name" => "sendMessage", "type" => "text"], "Say Hello :)"); ?><input id="submitMessage" type="Submit" name="submitMessage" value="Send"/></div>
</body>
</html>