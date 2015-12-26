            </div>
        </div>
    </div>
    <div id="chat">
        <div class="area group"><div class="title">Private Chat Log</div><iframe src="<?=$site['url']?>chat/list.php"></iframe></div>
    </div>
    <script>
        
        window['newunseen'] = false;
        var red = false;
        function checkunseen()
        {
            if(window['newunseen'])
            {
                if(red)
                {
                    $("#chat .area.group .title").css({
                       "background": "#87b24d"
                    });
                    red = false;
                }
                else
                {
                    $("#chat .area.group .title").css({
                       "background": "#c74e4e"
                    });
                    red = true;
                }
            }
            else
            {
                if(red)
                {
                    $("#chat .area.group .title").css({
                       "background": "#87b24d"
                    });
                    red = false;
                }
            }
            setTimeout(checkunseen, 500);
        }
        
        $("#chat .area.group .title").hover(function() {
            $("#chat .area.group .title").css({
               "background": "#65902c"
            });
        });
        checkunseen();
        function startChat(chat_name, chat_id)
        {
            if($("#" + chat_id).length == 0)
            {
                window["chat" + chat_id] = true;
                $("#chat").prepend("<div id='" + chat_id + "' class='area'><div class='title'>" + chat_name + " [<a href='javascript:void(0);'>close</a>]</div><iframe src='<?=$site['url']?>chat/open.php?id=" + chat_id + "'></iframe></div>");
                add();
            }
            $("#" + chat_id + " .title").trigger("click");
        }
        
        function add()
        {
            $("#chat .area .title").unbind("click");
            $("#chat .area .title").bind("click", function(){
                if($(this).parent().css("height") == "356px")
                {
                    window["chat" + $(this).parent().attr("id")] = false;
                    $(this).parent().css({"height": "40px", "margin-top": "316px"});
                    var open = false;
                    $("#chat .area").each(function() {
                        if($(this).css("height") == "40px") $(this).css("margin-top", "316px");
                        else open = true;
                    });
                    if(!open) $("#chat .area").css("margin-top", "0px");
                }
                else{
                    window["chat" + $(this).parent().attr("id")] = true;
                    $("#chat .area").each(function() {
                        if($(this).css("height") == "40px") $(this).css("margin-top", "316px");
                    });
                    $(this).parent().css({"height": "356px", "margin-top": "0px"});
                }
                $(this).parent().find('iframe').toggle();
            });
            $("#chat .area .title a").click(function(){
                    window["chat" + $(this).parent().parent().attr("id")] = false;
                $(this).parent().parent().remove();
            });
            var open = false;
            $("#chat .area").each(function() {
                if($(this).css("height") == "40px") $(this).css("margin-top", "316px");
                else open = true;
            });
            if(!open) $("#chat .area").css("margin-top", "0px");
        }
        
        add();
    </script>



<!--<script type='text/javascript'>
  //<![CDATA[
    var grooveOnLoad = myInitFunction; 
    (function() {var s=document.createElement('script');
      s.type='text/javascript';s.async=true;
      s.src=('https:'==document.location.protocol?'https':'http') + '://techdime.groovehq.com/widgets/d4cb2127-aa02-4b2f-a26d-dd2452c1f385/ticket.js'; 
      var q = document.getElementsByTagName('script')[0];q.parentNode.insertBefore(s, q);})();
  //]]>
    function myInitFunction()
    {
        GrooveWidget.open({category: "Brisk Surf"});
        GrooveWidget.close();
        GrooveWidget.options({about: 'Brisk Surf --- Member ID #<?=$usr->data->id?> is a <?=$membership[$usr->data->membership]["name"]?> member.', email: '<?=$usr->data->email?>', name: '<?=$usr->data->fullName?>'});
    }
</script>
<style>
#groove-feedback.right
{
    left: 20px;
    bottom:0px;
    right:auto;
}
    
#gw-footer
{
    display:none;   
}
</style>-->
</body>