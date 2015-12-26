
<?php
$countSites = $db->query("SELECT COUNT(`id`) AS `count` FROM `websites` WHERE `userid`='{$usr->data->id}'");
$countSites = $countSites->getNext()->count;
if($countSites < 1 && !$getVar)
{
    $requirement = true;
    include 'loggedIn/new.php';
    exit;
}
?>
<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=$site["url"]?>loggedIn/surf.css?version=1.005">
    <script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
    <script src="<?=$site["url"]?>loggedIn/jquery.animate-colors-min.js" type="text/javascript"></script>
    <script src="<?=$site["url"]?>loggedIn/raty/jquery.raty.min.js" type="text/javascript"></script>
    <script type='text/javascript' src='//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-51f28e7a17cad498'></script>
      
	<link href="<?=$site["url"]?>lightbox/themes/evolution-dark/jquery.lightbox.css" rel="stylesheet">
    <script src="<?=$site["url"]?>lightbox/jquery.lightbox.min.js"></script>
      
    <script type="text/javascript">
        $(document).ready(function($){
            $('.lightbox').lightbox();
        });
    </script>
    
    <title><?=$site["name"]?></title>
    <meta name="description" content="<?=$site["description"]?>" />
    <script>
    var prevent_bust = 0;
    function gohome() {
        prevent_bust = -5;
        window.location = "<?=$site['url']?>";
    }
    function gourl(url) {
        prevent_bust = -5;
        window.location = url;
    }
    $(document).ready(function(){
        
        $(".chat .chatBox").click(function(){
            if($(".chatframe iframe").attr("src") == "")
            {
                $(".chatframe iframe").attr("src", "http://www.surfsavant.com/chatbox/?small");
                
            }
            $(".chatframe").toggle();
        });
        
        window.onbeforeunload = function() { prevent_bust++ }
        setInterval(function() {
          if (prevent_bust > 0) {
            prevent_bust -= 2;
            window.top.location = 'http://techdime.com/204.php';
          }
        }, 1);
        
        $("#surf .count").click(function(e){
            if($("#surf .count").html() == "GO")
            {
                $('#surf .dropdown').stop().animate({
                    top: 0
                }, 500);
            }
        });
        
        <?php if($getVar) { ?>
            var data = {"id": <?=$getVar?>};
            postData(data, "checkRequest.php");
        <?php } else { ?>
            postData({}, "siteRequest.php");
        <?php } ?>
        
        $("#iframe").load(function(){
            if(timesRefreshed == 1){
                redirect = true;
            }
            timesRefreshed++; 
        });
        
        $(document).click( function(e) {
           randomx = e.clientX; 
           randomy = e.clientY;
         });
        
    });
        
    function count()
    {
        if($("#surf .count").html() != "GO")
        {
            if(parseInt($("#surf .count").html()) <= 1)
            {
                $('#surf .count').animate({
                    backgroundColor: '#87b24d'
                }, 800, function() {
                    $("#surf .count").html("GO");
                    $("#surf .count").css("cursor", "pointer");
                });
            }
            else
            {
                $("#surf .count").html($("#surf .count").html() - 1);
            }
        }
        setTimeout(count, 1000);
    }
        count();
    
    var redirect = false;
    var social = false;
    var timesRefreshed = 0;
    var rated = 0;
    var hash = '';
    var randomx = 0;
    var randomy = 0;
        
    function postData(data, url)
    {
        hide();
        var data_encoded = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "<?=$site['url']?>loggedIn/surfData/" + url,
            dataType: "json",
            data: {
                "data" : data_encoded
            },
            success: function(data) {
                if(data.hash) hash = data.hash;
                if(!data.loggedIn)
                {
                    changeText("ERROR: You must login. Click <a href='<?=$site['url']?>'>here</a> to continue");
                }
                else if(data.error)
                {
                    changeText("ERROR:" + data.error);
                }
                else if(data.count)
                {
                    $(".reportid").show();
                    $(".reporturl").show();
                    $(".reportid2").show();
                    $(".reporturl2").show();
                    $(".reportid3").show();
                    $(".reporturl3").show();
                    $(".reportid").val(data.reportid);
                    $(".reportid2").val(data.reportid2);
                    $(".reportid3").val(data.reportid3);
                    $(".reporturl").html(data.reporturl);
                    $(".reporturl2").html(data.reporturl2);
                    $(".reporturl3").html(data.reporturl3);
                    $(".reporturl").attr("href", data.reporturl);
                    $(".reporturl2").attr("href", data.reporturl2);
                    $(".reporturl3").attr("href", data.reporturl3);
                    if(data.reportid == "")
                    {
                        $(".reportid").hide();
                        $(".reporturl").hide();
                    }
                    if(data.reportid2 == "")
                    {
                        $(".reportid2").hide();
                        $(".reporturl2").hide();
                    }
                    if(data.reportid3 == "")
                    {
                        $(".reportid3").hide();
                        $(".reporturl3").hide();
                    }
                    
                    
                    hide();
                    if(data.views) $('#surf .viewCount .views').html(data.views + " Views");
                    if(data.badge) $("#surf .badge").html(data.badge);
                    else if($("#surf .badge").css("right") == "30px")
                    {
                        $('#surf .badge').animate({
                            right: -150
                        }, 800, function() {
                            $("#surf .chatframe").css("top", "100px");
                        });
                    }
                        
                    if(data.bonus) $("#surf .bonus .bonusPercent").html(data.bonus + "% Bonus");
                    else if($("#surf .bonus").css("left") == "30px")
                    {
                        $('#surf .bonus').animate({
                            left: -150
                        }, 800);
                    }
                        
                    setTimeout(function() {
                        $("#surf .dropdown").html(data.data);
                    }, 1000);
                    setTimeout(function() {
                        if(data.badge)
                        {
                            $("#surf .chatframe").css("top", "220px");
                            $('#surf .badge').animate({
                                right: 30
                            }, 800);   
                        }
                        if(data.bonus)
                        {
                            $('#surf .bonus').animate({
                                left: 30
                            }, 800);   
                        }
                        $('iframe').each(function() {
                            //var fixed_src = $(this).attr('src') + '&amp;wmode=transparent';
                            //$(this).attr('src', fixed_src);
                        });
                    }, 2000);
                    $("#iframe").attr('src', data.url);
                    $("#image").attr('src', "http://www.gravatar.com/avatar/" + data.email + "?s=50");
                    $("#surf .count").html(data.time);
                    $("#surf .count").css("cursor", "auto");
                    $('#surf .count').animate({
                        backgroundColor: '#c74e4e'
                    }, 800);
                    redirect = false;
                    social = false;
                    timesRefreshed = 0;
                }
                else if(!data.count)
                {
                    hide();
                    if($("#surf .dropdown").css("top") == "0px")
                    {
                        $('#surf .dropdown').stop().animate({
                            top: -10 - $("#surf .dropdown").outerHeight()
                        }, 500, function() {
                            $("#surf .dropdown").html(data.data);
                            $('#surf .dropdown').stop().animate({
                                top: 0
                            }, 500);
                        });
                    }
                    else
                    {
                        $("#surf .dropdown").html(data.data);
                        $('#surf .dropdown').stop().animate({
                            top: 0
                        }, 500);
                    }
                }
            },
            error: function(data)
            {
                console.log(data);   
            }
        });
    }
    function loading(text)
    {
        changeText(text + "<br><br><img src='<?=$site["url"]?>loggedIn/images/redLoader.gif'/>");
    }
        
    function hide()
    {
        $('#surf .dropdown').stop().animate({
            top: -200
        }, 500);
    }
    function changeText(text)
    {
        hide();
        $("#surf .dropdown").html(text);
        $("#surf .dropdown").css("top", -10 - $("#surf .dropdown").outerHeight());
        $('#surf .dropdown').stop().animate({
            top: 0
        }, 500);
        
    }
        
    function reportSite() {
        $(".jquery-lightbox-move, .jquery-lightbox-overlay").fadeOut();
        
        var data = {"id": $(".jquery-lightbox-html input[type=radio]:checked").val(), "text": $(".jquery-lightbox-html .reportInput").val()};
        var data_encoded = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "<?=$site['url']?>loggedIn/surfData/report.php",
            dataType: "json",
            data: {
                "data" : data_encoded
            },
            success: function(data)
            {
                alert("Thank you for taking the time to report a possible issue!");
            },
            error: function(data)
            {
                console.log(data);
            }
        });
    }
</script>
</head>
<body>
    <div id="surf">
        <iframe id="iframe" src=""></iframe>
        <div class="dropdown">
            
        </div>
        <div class="countdown">
            <img id="image" src=''/>
            <div class="count"></div>
        </div>
        <div class="home">
            <a href="javascript:gohome();">Exit</a>
        </div>
        <div class="home report" style="margin-top:70px; height:30px;">
            <a href="#reportSites" class="lightbox" style="height:30px; line-height:30px; font-size:12px;">Report</a>
        </div>
        <div style="display:none;" class="reportSites" id="reportSites">
            <center style="width:400px;">
                Please select the website you would like to report:<br><br>
                <input class="reportid" type="radio" value="" name="reportid"> <a target="_blank" href="" class="reporturl"></a><br>
                <input class="reportid2" type="radio" value="" name="reportid"> <a target="_blank" href="" class="reporturl2"></a><br>
                <input class="reportid3" type="radio" value="" name="reportid"> <a target="_blank" href="" class="reporturl3"></a><br><br>
                Please enter the reason for reporting the website:<br><br>
                <textarea style="width:370px;" class="form-control reportInput"></textarea><br>
                <button onclick="reportSite()" id="reportSite" type="button" class="btn btn-primary">Report</button>
            </center>
        </div>
        <div class="badge">
            <a href="http://brisksurf.com"><img src="" height="90"/></a>
        </div>
        <div class="viewCount">
            <div class="views"></div>
        </div>
        <div class="bonus">
            <div class="bonusPercent"></div>
        </div>
        <div class="chat">
            <div class="chatBox">Group Chat</div>
        </div>
        <div class="chatframe">
            <iframe src=""></iframe>
        </div>
    </div>
</body>
</html>