<?php include 'header.php'; ?>
<div id="box2"></div>
<div class="row">
    <div class="col-md-12">
        <?php
        $video = $db->query("SELECT `related`, `creator`, `title`, `downlineLink`, `techdimeRef`, `mattRef`, (SELECT `ref` FROM `videoRefs` WHERE `videoRefs`.`videoid` = '{$getVar}' && `videoRefs`.`userid` = '{$usr->data->ref}') AS `ref`, (SELECT count(`id`) FROM `videoLikes` WHERE `videoLikes`.`videoid` = `videos`.`id` && `isLike` = 1) AS `likes`, (SELECT count(`id`) FROM `videoLikes` WHERE `videoLikes`.`videoid` = `videos`.`id` && `isLike` = 2) AS `dislikes`, (SELECT count(`id`) FROM `videoLikes` WHERE `videoLikes`.`videoid` = `videos`.`id` && `isLike` = 1 && `userid` = '{$usr->data->id}') AS `liked`, (SELECT count(`id`) FROM `videoLikes` WHERE `videoLikes`.`videoid` = `videos`.`id` && `isLike` = 2 && `userid` = '{$usr->data->id}') AS `disliked` FROM `videos` WHERE `id` = '{$getVar}'")->getNext();
        ?>
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-book"></i>
                <h3><?=$video->title?> : Produced by <?=$video->creator?></h3>
            </div>
            <div class="widget-content">
                <style>
                    #box{
                        width:640px;
                        height:360px;
                        margin:100px auto;
                        position:relative;
                        z-index:2;
                    }
                    #box2{
                        width:645px;
                        height:366px;
                        position:absolute;
                        z-index:1;
                        top:-500px;
                    }
                    .tile{
                        float:left;
                    }
                    .glow{
                        -moz-box-shadow:0 0 15px #454545; 
                        -webkit-box-shadow:0 0 15px #454545; 
                        -o-box-shadow:0 0 15px #454545; 
                        box-shadow:0 0 15px #454545; 
                        border:3px solid #F90;
                    }
                    .glow2{
                        -moz-box-shadow:0 0 15px #454545; 
                        -webkit-box-shadow:0 0 15px #454545; 
                        -o-box-shadow:0 0 15px #454545; 
                        box-shadow:0 0 15px #454545; 
                    }
                    #video-controls{
                        text-align:center;   
                        margin-top:10px; 
                        border:1px solid #ccc;
                        -moz-border-radius:5px;
                        -o-border-radius:5px;
                        -webkit-border-radius:5px;
                        border-radius:5px;
                        display:inline-block;
                        background:#eee;
                    }
                    
                    #play-pause{
                        -webkit-border-top-right-radius:0;  
                        -webkit-border-bottom-right-radius:0;   
                        -o-border-top-right-radius:0;  
                        -o-border-bottom-right-radius:0;   
                        -moz-border-top-right-radius:0;  
                        -moz-border-bottom-right-radius:0;   
                        border-top-right-radius:0;  
                        border-bottom-right-radius:0;  
                        border-bottom:0;
                        border-top:0;
                        border-left:0;
                    }
                    
                    #mute{
                        -moz-border-radius:0px;
                        -o-border-radius:0px;
                        -webkit-border-radius:0px;
                        border-radius:0px; 
                        border-bottom:0;
                        border-top:0;
                    }
                </style>
                <p><center>
                    <?php if($video->downlineLink) { 
                        $ref = $video->ref;
                        if($ref == "")
                        {
                            $ref = (rand(0,1) == 0) ? $video->mattRef : $video->techdimeRef;
                        }
            
                        $test = $db->query("SELECT `ref` FROM `videoRefs` WHERE `userid` = '{$usr->data->id}' && `videoid` = '{$getVar}'");
                        $value = ($test->getNumRows()) ? " value='" . $test->getNext()->ref . "'" : "";
                        ?>
                        <div style="width:500px;" class="input-group">
                            <span class="input-group-addon"><a target="_blank" href='<?=$video->downlineLink . $ref?>'><?=$video->downlineLink?></a></span>
                            <input id="updateRefInput"<?=$value?> placeholder="Your ID" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button id="updateRefSubmit" class="btn btn-primary" type="button">Go!</button>
                            </span>
                        </div>
                    <br>
                    <button type="button" class="btn btn-primary" id="athumbsup">
                        <i class="icon-thumbs-up"></i> <div id="thumbsup" style="display:inline;"><?php if($video->liked) echo "You and "; echo ($video->liked) ? $video->likes - 1 : $video->likes; if($video->liked) echo " others"; ?></div>
                    </button>
                    
                    <button type="button" class="btn btn-primary" id="athumbsdown">
                        <i class="icon-thumbs-down"></i> <div id="thumbsdown" style="display:inline;"><?php if($video->disliked) echo "You and "; echo ($video->disliked) ? $video->dislikes - 1 : $video->dislikes; if($video->disliked) echo " others"; ?></div>
                    </button>
                    <!--<a id="athumbsup" href='javascript:;' style="color:#333;">
                        <i class="icon-thumbs-up"></i> <div id="thumbsup" style="display:inline;"><?php if($video->liked) echo "You and "; echo ($video->liked) ? $video->likes - 1 : $video->likes; if($video->liked) echo " others"; ?></div>
                    </a>
                    &nbsp;&nbsp;
                    
                    <a id="athumbsdown" href='javascript:;' style="color:#333;">
                        <i class="icon-thumbs-down"></i> <div id="thumbsdown" style="display:inline;"><?php if($video->disliked) echo "You and "; echo ($video->disliked) ? $video->dislikes - 1 : $video->dislikes; if($video->disliked) echo " others"; ?></div>
                    </a>-->
                    <br>
                        <script>
                        $("#updateRefSubmit").click(function() {
                            var value =  $("#updateRefInput").val();
                            var data = {"id": "<?=$getVar?>", "ref": value};
                            var data_encoded = JSON.stringify(data);
                            $.ajax({
                                type: "POST",
                                url: "<?=$site['url']?>loggedIn/videoRef.php",
                                dataType: "json",
                                data: {
                                    "data" : data_encoded
                                },
                                success: function(data) {
                                    $.msgbox("You have successfully updated your downline link. All your referrals will be using it.");
                                },
                                error: function(data)
                                {
                                    console.log(data);
                                }
                            });
                        });
                        </script>
                        <br>
                    <?php } ?>
                    <a href='javascript:;' onclick='javascript:history.back()'><i class="icon-arrow-left"></i> Go Back</a> &nbsp; &nbsp; &nbsp; &nbsp; Put the video together and enjoy! 
                    <?php if(false && $getVar == 4) { ?>
                    <div style="display:none;" id="badge"><br><br>Woah, you found a <a target="_blank" href="http://clicktrackprofit.com/reloaded/claimbadge.php?<?=file_get_contents("http://clicktrackprofit.com/api.php?bid=5057&key=c4a7f8fda2")?>"><img src="http://clicktrackprofit.com/images/spooktacular002.png"></a> (click to claim)</div>
                    <?php } ?>
                    <script>
                        $("#athumbsup").click(function() {
                            var text = $("#thumbsup").html();
                            if(text.indexOf("You and ") == -1)
                            {
                                $("#thumbsup").html("You and " + text + " others");
                                var text2 = $("#thumbsdown").html();
                                if(text2.indexOf("You and ") != -1)
                                {
                                    $("#thumbsdown").html(text2.replace("You and ","").replace(" others", ""));
                                }
                                var data = {"isLike": "1", "id": "<?=$getVar?>"};
                                var data_encoded = JSON.stringify(data);
                                $.ajax({
                                    type: "POST",
                                    url: "<?=$site['url']?>loggedIn/likeVideo.php",
                                    dataType: "json",
                                    data: {
                                        "data" : data_encoded
                                    },
                                    success: function(data) {
                                        if(data.error)
                                        {
                                            console.log(data.error);
                                        }
                                    },
                                    error: function(data)
                                    {
                                        console.log(data);
                                    }
                                });
                            }
                        });
                        $("#athumbsdown").click(function() {
                            var text = $("#thumbsdown").html();
                            if(text.indexOf("You and ") == -1)
                            {
                                $("#thumbsdown").html("You and " + text + " others");
                                var text2 = $("#thumbsup").html();
                                if(text2.indexOf("You and ") != -1)
                                {
                                    $("#thumbsup").html(text2.replace("You and ","").replace(" others", ""));
                                }
                                var data = {"isLike": "2", "id": "<?=$getVar?>"};
                                var data_encoded = JSON.stringify(data);
                                $.ajax({
                                    type: "POST",
                                    url: "<?=$site['url']?>loggedIn/likeVideo.php",
                                    dataType: "json",
                                    data: {
                                        "data" : data_encoded
                                    },
                                    success: function(data) {
                                        if(data.error)
                                        {
                                            console.log(data.error);
                                        }
                                    },
                                    error: function(data)
                                    {
                                        console.log(data);
                                    }
                                });
                            }
                        });
                    </script>
                </center></p>
                <center>
                    <div id="videohide" style="display:none">
                        <br>
                        <video class="glow" id="source-vid" > 
                            <source src="<?=$site['url']?>videos/<?=$getVar?>.mp4" type='video/mp4'/>                  
                            <source src="<?=$site['url']?>videos/<?=$getVar?>.ogv" type='video/ogg'/> 
                        </video> 
                        <br>
                <div id="video-controls">
                    <button disabled type="button" id="play-pause" class="btn btn-primary"><i class="icon-play"></i></button>
                    <div id="seek-bar" class="slider-primary" style="top:2px;width:150px; position:relative; display:inline-block; margin-left:10px;"></div>
                    <div id="location" style='display:inline-block; margin-right:20px; margin-left:15px; position:relative;'>00:00</div>
                    <button type="button" id="mute" class="btn btn-primary"><i class='icon-volume-off'></i></button>
                    <div id="volume-bar" class="slider-primary" style="top:2px; width:100px; position:relative; display:inline-block; margin-left:10px; margin-right:20px;"></div>
                </div>
                    <script>
                        $("#volume-bar").slider({
                            range: "min",
                            animate: true,
                            //orientation: "vertical",
                            min: 0,
                            max: 1,
                            step: 0.1,
                            value: 1,
                            slide: function( event, ui ) {
                                var video = document.getElementById("source-vid");
                                video.volume = ui.value;
                            } 
                        });
                        $("#volume-bar").val(100);
                        $( "#seek-bar" ).slider({ 
                            value: 0, range: 'min',
                            slide: function( event, ui ) {
                                var video = document.getElementById("source-vid");
                                var time = video.duration * (ui.value / 100);
                                video.currentTime = time;
                            } 
                        });
                        window.onload = function() {
                            var video = document.getElementById("source-vid");
                        
                            // Buttons
                            var playButton = document.getElementById("play-pause");
                            var muteButton = document.getElementById("mute");
                            
                            playButton.addEventListener("click", function() {
                              if (video.paused == true) {
                                // Play the video
                                video.play();
                            
                                // Update the button text to 'Pause'
                                //playButton.innerHTML = "Pause";
                                $("#play-pause i").attr("class","icon-pause");
                              } else {
                                // Pause the video
                                video.pause();
                            
                                // Update the button text to 'Play'
                                //playButton.innerHTML = "Play";
                                $("#play-pause i").attr("class","icon-play");
                              }
                            });
                            var volumevalue = 100;
                            muteButton.addEventListener("click", function() {
                            var video = document.getElementById("source-vid");
                              if ($( "#volume-bar" ).slider( "option", "value") == 0) {
                                $( "#volume-bar" ).slider( "option", "value", volumevalue);
                                video.volume = volumevalue;
                              } else {
                                  volumevalue = $( "#volume-bar" ).slider( "option", "value");
                                $( "#volume-bar" ).slider( "option", "value", 0);
                                video.volume = 0;
                              }
                            });
                                
                                // Update the seek bar as the video plays
                            video.addEventListener("timeupdate", function() {
                                <?php if(false && $getVar == 4) { ?>
                                if(video.currentTime > 60)
                                {
                                     $("#badge").show();  
                                }
                                <?php } ?>
                                var seconds = Math.ceil(video.duration - video.currentTime);
                                var minutes = Math.floor(seconds / 60);
                                var seconds = seconds - minutes * 60
                                var text = (minutes >= 10) ? minutes : "0" + minutes;
                                text += ":";
                                text += (seconds >= 10) ? seconds : "0" + seconds;
                                $("#location").html(text);
                              // Calculate the slider value
                              var value = (100 / video.duration) * video.currentTime;
                              // Update the slider value
                             if(value == 100) {
                                //playButton.innerHTML = "Play";
                                $("#play-pause i").attr("class","icon-play");
                                var data = {"id": "<?=$getVar?>"};
                                var data_encoded = JSON.stringify(data);
                                 $.ajax({
                                    type: "POST",
                                    url: "<?=$site['url']?>loggedIn/completeVideo.php",
                                    dataType: "json",
                                    data: {
                                        "data" : data_encoded
                                    },
                                    success: function(data) {
                                        if(data.error)
                                        {
                                            console.log(data.error);
                                        }
                                    },
                                    error: function(data)
                                    {
                                        console.log(data);
                                    }
                                });
                             }
                            $( "#seek-bar" ).slider( "option", "value", value );
                            });
                        }
                        
                    </script>
                    </div>
                </center>
                <div id="box"></div>
                <script type="text/javascript">
                    $(document).ready(function() {
                        ROWS = 2;
                        COLS = 3;
                        tiles(640, 360, ROWS, COLS);
                        $('canvas').mouseup(function() {
                          var minxcount = 0;
                          var minx = 9999;
                          var maxxcount = 0;
                          var maxx = 0;
                          var miny = 9999;
                          var minycount = 0;
                          var maxy = 0;
                          var maxycount = 0;
                        $( "canvas" ).each(function() {
                          var left = Math.round($( this ).offset().left);
                          var top = Math.round($( this ).offset().top);
                            
                            if(left == minx) minxcount += 1;
                            else if(left < minx) { minx = left; minxcount = 1; }
                            if(left == maxx) maxxcount += 1;
                            else if(left > maxx) { maxx = left; maxxcount = 1; }
                            if(top == miny) minycount += 1;
                            else if(top < miny) { miny = top; minycount = 1; }
                            if(top == maxy) maxycount += 1;
                            else if(top > maxy) { maxy = top; maxycount = 1; }
                        });
                          if(minxcount == 2 && maxxcount == 2 && minycount == 3 && maxycount == 3 && maxx - minx >= 425 && maxx - minx <= 427 && maxy - miny >= 179 && maxy - miny <= 181) complete = true;   
                          else complete = false;
                          if(complete) 
                          {
                                $('#play-pause').removeAttr('disabled');
                                var video = document.getElementById("source-vid");
                                var playButton = document.getElementById("play-pause");
                                video.play();
                                $("#play-pause i").attr("class","icon-pause");
                                //playButton.innerHTML = "Pause";
                                $(".tile").draggable( 'destroy' );
                                $("#videohide").show();
                                $("#box").hide();
                          }
                        });

                        var video = $("#source-vid")[0];
                        update(video);
                        setTimeout(function() { update(video) }, 500);
                        setTimeout(function() { update(video) }, 1000);
                        setTimeout(function() { update(video) }, 1500);
                        setTimeout(function() { update(video) }, 2000);
                        function update(video) {
                          tiles(640, 360, ROWS, COLS, video);
                          
                        }
                        var complete = false;
                        function tiles(w, h, r, c, source) {
                            var tileW = Math.round(w / c);
                            var tileH = Math.round(h / r);
                    
                            for(var ri = 0; ri < r; ri += 1) {
                              for(var ci = 0; ci < c; ci += 1) {
                                //if source is not specified, just build canvas object, otherwise draw inside them
                                if (typeof source === 'undefined') {
                                    var tile = $('<canvas class="tile glow2 tile' + ri + ci + '" id="tile' + ri + ci + '" height="' + tileH + '" width="' + tileW + '"></canvas>').get(0);
                                    $("#box").append(tile);
                                    $(".tile").draggable({ snap: true, grid: [1,1],
                                                          start: function(event,i)
                                                          {
                                                             $( "#box2" ).removeClass( "glow" ); 
                                                          },
                                                         stop: function(event,i)
                                                          {
                                                              
                                                          }
                                                         });
                                    $("#tile" + ri + ci).css("top", Math.floor((Math.random()*150)-75));
                                    $("#tile" + ri + ci).css("left", Math.floor((Math.random()*75)-(25 + ci * 12)));
                                } else {
                                    var getit = $('#tile' + ri + ci).get(0);
                                    context = getit.getContext('2d');
                                    context.drawImage(source, ci*tileW, ri*tileH, tileW, tileH, 0, 0, tileW, tileH);
                                }
                              }
                            }   
                        }
                    });
                </script>
                <?php
                if($video->related != 0)
                {
                    $new = $db->query("SELECT `title`,`creator` FROM `videos` WHERE `id` = '{$video->related}'");
                    $new = $new->getNext();
                    ?>
                    <center><br>After completing this video, we recommend you watch <a href="<?=$site['url']?>video/<?=$video->related?>"><?=$new->title?></a> by <?=$new->creator?>.</center>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>