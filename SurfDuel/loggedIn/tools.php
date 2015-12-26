<?php include 'header.php'; ?>
<div class="header">Promo Tools</div>
<div class="content">
    <div class="subtitle">Promotion URL</div>
    <div class="form">
        <input style="width:250px;" onClick="this.select();" type="text" value="<?php echo $site["url"] . $usr->data->id; ?>"/> 
        <a target="_blank" href="<?php echo $site["url"] . $usr->data->id; ?>"><input type="submit" value="Open"/></a>
    </div>
    <br><div class="subtitle">Splash Pages</div>
    <div class="form">
        <input style="width:250px;" onClick="this.select();" type="text" value="<?php echo $site["url"] . "splash/" . $usr->data->id; ?>"/>
        <a target="_blank" href="<?php echo $site["url"] . "splash/" . $usr->data->id; ?>"><input type="submit" value="Open"/></a>
    </div>
    <br><br>
    <div class="form">
        <input style="width:250px;" onClick="this.select();" type="text" value="<?php echo $site["url"] . "cash/" . $usr->data->id; ?>"/>
        <a target="_blank" href="<?php echo $site["url"] . "cash/" . $usr->data->id; ?>"><input type="submit" value="Open"/></a>
    </div>
    <br><br>The following is a personal branded splash page. Suprise your viewers with a specialized message just for them.<br><br>
    <div class="form" id="personal">
        <textarea maxlength="215" style="width:100%; height:27px;"><?php echo ($usr->data->splash2 == "") ? "Enter your message here." : $usr->data->splash2; ?></textarea><br><input id="newMessage" type="submit" value="Update Message"/><div id="updateMessage"></div><br><br>
        <input style="width:250px;" onClick="this.select();" type="text" value="<?php echo $site["url"] . "splash2/" . $usr->data->id; ?>"/>
        <a target="_blank" href="<?php echo $site["url"] . "splash2/" . $usr->data->id; ?>"><input type="submit" value="Open"/></a>
        
        <script>
            $("#newMessage").click(function() {
                $("#updateMessage").html("<br>Updating...please wait");
                $.ajax({
                    type: "POST",
                    url: "<?=$site["url"]?>loggedIn/updateSplash2.php",
                    data: {"message": $("#personal textarea").val()},
                    success: function(data) {
                        $("#updateMessage").html("<br><div class='success'>The message has been updated</div>");   
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            $("#personal textarea").focus(function() {
               if($(this).val() == "Enter your message here.") $(this).val("");
            });
        </script>
    </div>
    <br>
    <div class="subtitle">Banners</div>
    <div class="form">
    <a href="<?php echo $site["url"] . $usr->data->id; ?>" target="_BLANK" rel="external"><img src="<?=$site["url"]?>promo/banner.png" style="border:none;"/></a><br><br>
        HTML<br><br> <input style="width:250px;" onClick="this.select();" type="text" value='<a href="<?php echo $site["url"] . $usr->data->id; ?>" target="_BLANK" rel="external"><img src="<?=$site["url"]?>promo/banner.png" style="border:none;"></a>'/><br><br>
        Link<br><br> <input style="width:250px;" onClick="this.select();" type="text" value='<?=$site["url"]?>promo/banner.png'/>
        <a target="_blank" href="<?=$site["url"]?>promo/banner.png"><input type="submit" value="Open"/></a>
    </div>
    <br><br>
    <div class="form">
    <a href="<?php echo $site["url"] . $usr->data->id; ?>" target="_BLANK" rel="external"><img src="<?=$site["url"]?>promo/banner2.png" style="border:none;"/></a><br><br>
        HTML<br><br> <input style="width:250px;" onClick="this.select();" type="text" value='<a href="<?php echo $site["url"] . $usr->data->id; ?>" target="_BLANK" rel="external"><img src="<?=$site["url"]?>promo/banner2.png" style="border:none;"></a>'/><br><br>
        Link<br><br> <input style="width:250px;" onClick="this.select();" type="text" value='<?=$site["url"]?>promo/banner2.png'/>
        <a target="_blank" href="<?=$site["url"]?>promo/banner2.png"><input type="submit" value="Open"/></a>
    </div>
</div>
<?php include 'footer.php'; ?>