<?php include 'header.php'; ?>
<script src="<?=$site["url"]?>loggedIn/raty/jquery.raty.min.js" type="text/javascript"></script>
<?php
if($getVar)
{
    $website = $db->query("SELECT * FROM `websites` WHERE `id`='{$getVar}' && `status`='1' && `userid`='{$usr->data->id}' LIMIT 1");
    if($website->getNumRows())
    {
        $data = $website->getNext();
        $results = $db->query("SELECT `rateType`, AVG(`rated`) AS `avg` FROM `views` WHERE `siteid` = '{$getVar}' && `rateType` != -1 GROUP BY `rateType`");
        $ratings = [0 => "Rate the readibility of the website", 1 => "Rate the design of the website", 2 => "Rate the service provided by the website"];
        ?>
        <div class="title">My Websites: <?=$data->name?></div>
        <div class="subheader">
            URL: <a target="_blank" href="<?=$data->url?>"><?=$data->url?></a>
        </div>
        <div class="menu">
            <a href="<?=$site['url']?>view/<?=$getVar?>">Settings</a>
            <a href="<?=$site['url']?>weekday/<?=$getVar?>">Weekday</a>
            <a href="<?=$site['url']?>gender/<?=$getVar?>">Gender</a>
            <a href="<?=$site['url']?>age/<?=$getVar?>">Age</a>
            <a href="<?=$site['url']?>continent/<?=$getVar?>">Continent</a>
            <a style="margin-right:0px;" href="<?=$site['url']?>membership/<?=$getVar?>">Membership</a>
        </div>
        <hr>
        <div class="text">
            <div class="subtitle">Views</div>
            Your website has recieved <?=$data->views?> view<?php if($data->views != 1) echo "s"; ?> in its lifetime
            <br><br>
            <div class="subtitle">Rating</div>
            <?php
                while($result = $results->getNext())
                {
                    echo "Type: " . $ratings[$result->rateType] . "<br>" . round($result->avg, 2);
                    ?>
                    <div class="viewStar" id='star<?=$result->rateType?>'></div>
                    <script>
                    $('#star<?=$result->rateType?>').raty({ path: '<?=$site['url']?>loggedIn/raty/img', number: 3, score: <?php echo round($result->avg, 2); ?>, readOnly: true });
                    </script>
                    <br><br>
                    <?php
                    
                }
                if(!$results->getNumRows())
                {
                    echo "No ratings were found. Get more views to your website to start accumilating ratings.<br><br>";
                }
            ?>
            <div class="subtitle">Credits</div>
            <div class="websiteCredits">Your website has <?=$data->credits?> credits</div>
            <br>
            <div class="subtitle">Change Credits</div>
            <div class="form">
                <?php $gui->input(["id" => "changeCreditsAmount", "name" => "changeCreditsAmount", "type" => "text", "value" => $data->credits]); ?>
                <input id="changeCreditsSubmit" name="addCreditsSubmit" type="submit" value="Change">
            </div>
            <div class="loading"><br></div>
            <script>
                $("#changeCreditsSubmit").click(function()
                {
                    loading("<br><br>Credits are being added");
                    var data_encoded = JSON.stringify({"credits": $("#changeCreditsAmount").val(), "id": "<?=$getVar?>"});
                    $.ajax({
                        type: "POST",
                        url: "<?=$site['url']?>loggedIn/changeCredits.php",
                        dataType: "json",
                        data: {
                            "data" : data_encoded
                        },
                        success: function(data) {
                            if(!data.loggedIn)
                            {
                                changeText("<br><div class='error'>ERROR: You must login. Click <a href='<?=$site['url']?>'>here</a> to continue</div>");
                            }
                            else if(data.error)
                            {
                                changeText("<br><div class='error'>ERROR: " + data.error + "</div>");
                            }
                            else
                            {
                                changeText("<br><div class='success'>The coins have been changed</div>");
                                $("#content .content .websiteCredits").html("Your website has " + data.websiteCredits + " credits");
                                $("#content .content .availableCredits").html("You have " + data.availableCredits + " credits available for use ( <a href='javascript:addAll()'>Add All</a> )");
                            }
                        },
                        error: function(data)
                        {
                            console.log(data);
                        }
                    });
                });
                function loading(text)
                {
                    changeText(text + "<br><img src='<?=$site["url"]?>loggedIn/images/whiteLoader.gif'/>");
                }
                
                function changeText(text)
                {
                    $("#content .content .loading").html(text);
                }
                
                function addAll()
                {
                    $("#changeCreditsAmount").val(<?php echo $data->credits + $usr->data->credits; ?>);
                }
            </script>
            <div class="availableCredits">You have <?=$usr->data->credits?> credits available for use ( <a href="javascript:addAll()">Add All</a> )</div>
            <br>
            <div class="subtitle">Auto Assign</div>
            <div class="form">
                <?php $gui->input(["id" => "changeAutoAssign", "name" => "changeAutoAssign", "type" => "text", "value" => $data->autoAssign]); ?> Percent of your surf earnings. <br>
                <input id="autoAssignSubmit" name="autoAssignSubmit" type="submit" value="Change">
            </div>
            <div class="loading2"><br></div>
            <script>
                $("#autoAssignSubmit").click(function()
                {
                    loading2("<br><br>Auto Assign is being updated");
                    var data_encoded = JSON.stringify({"amount": $("#changeAutoAssign").val(), "id": "<?=$getVar?>"});
                    $.ajax({
                        type: "POST",
                        url: "<?=$site['url']?>loggedIn/changeAutoAssign.php",
                        dataType: "json",
                        data: {
                            "data" : data_encoded
                        },
                        success: function(data) {
                            if(!data.loggedIn)
                            {
                                changeText2("<br><div class='error'>ERROR: You must login. Click <a href='<?=$site['url']?>'>here</a> to continue</div>");
                            }
                            else if(data.error)
                            {
                                changeText2("<br><div class='error'>ERROR: " + data.error + "</div>");
                            }
                            else
                            {
                                changeText2("<br><div class='success'>Auto assign have been updated</div>");
                            }
                        },
                        error: function(data)
                        {
                            console.log(data);
                        }
                    });
                });
                function loading2(text)
                {
                    changeText2(text + "<br><img src='<?=$site["url"]?>loggedIn/images/whiteLoader.gif'/>");
                }
                
                function changeText2(text)
                {
                    $("#content .content .loading2").html(text);
                }
            </script>
            <div class="subtitle">Delete Site</div>
            Type "DELETE" in the box below to continue<br>
            <div class="form">
                <?php $gui->input(["id" => "deleteWebsiteInput", "type" => "text"]); ?>
                <input type="submit" value="Delete" id="deleteWebsiteSubmit" style="display:none;"/>
            </div>
            <script>
                $("#deleteWebsiteInput").keyup(function(){
                    if($(this).val() == "DELETE")
                    {
                        $("#deleteWebsiteSubmit").show();
                    }
                });
                $("#deleteWebsiteSubmit").click(function() {
                    window.location = "<?=$site['url']?>delete/<?=$getVar?>"; 
                });
            </script>
        </div>
        <?php
    }
    else echo 'ERROR: An error has occured';
}
else echo 'ERROR: An error has occured';
?>
<?php include 'footer.php'; ?>