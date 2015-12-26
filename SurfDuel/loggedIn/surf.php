<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=$site["url"]?>loggedIn/surf.css">
    <script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
      
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
    $(document).ready(function(){
        window.onbeforeunload = function() { prevent_bust++ }
        setInterval(function() {
          if (prevent_bust > 0) {
            prevent_bust -= 2;
            window.top.location = 'http://techdime.com/204.php';
          }
        }, 1);
        
        <?php if($sec->post("websiteSubmit")) {
            $page = $sec->post("websiteURL");
            if((substr($page, 0, 7) !== 'http://') && (substr($page, 0, 8) !== 'https://')) $page = 'http://' . $page;
            ?>
            check = '<?=$page?>';
        <?php } ?>
        postData();
        
        $("#next").click(function(){
            if(select)
            {
                if($("#next div").html() == "Next") postData();
            }
        });
        
        $("#pannel").mouseenter(function(){
            $("#iframe").stop().animate({"width": "74.7%"}, 200);
            $("#iframe2").stop().animate({"width": "24.7%"}, 200);
            $("#pannel").stop().animate({"width": "74.7%"}, 200);
            $("#pannel2").stop().animate({"width": "24.7%"}, 200);
            $("#divider").stop().animate({"left": "74.7%"}, 200);
        });
        
        $("#pannel2").mouseenter(function(){
            $("#iframe").stop().animate({"width": "24.7%"}, 200);
            $("#iframe2").stop().animate({"width": "74.7%"}, 200);
            $("#pannel").stop().animate({"width": "24.7%"}, 200);
            $("#pannel2").stop().animate({"width": "74.7%"}, 200);
            $("#divider").stop().animate({"left": "24.7%"}, 200);
        });
        
        $("#pannel").click(function() {
            $("#iframe").stop().animate({"width": "100%"}, 200);
            $("#iframe2").stop().animate({"width": "0%"}, 200);
            $("#pannel").hide();
            $("#pannel2").hide();
            $("#divider").stop().animate({"left": "100%"}, 200);
            winner = "0";
            select = true;
            $("#next").show();
        });
        
        $("#pannel2").click(function() {
            $("#iframe").stop().animate({"width": "0%"}, 200);
            $("#iframe2").stop().animate({"width": "100%"}, 200);
            $("#pannel").hide();
            $("#pannel2").hide();
            $("#divider").stop().animate({"left": "-1%"}, 200);
            winner = "1";
            select = true;
            $("#next").show();
        });
        
        $(document).click( function(e) {
           randomx = e.clientX; 
           randomy = e.clientY;
         });
    });
    
    var select = true;
    var check = "";
    var link1 = "";
    var id1 = "";
    var link2 = "";
    var id2 = "";
    var winner = "0";
    var timestamp = 0;
    var randomx = 0;
    var randomy = 0;
        
    function postData()
    {
        select = true;
        $("#pannel").hide();
        $("#pannel2").hide();
        $("#divider").hide();
        $("#next").hide();
        changeError("Loading");
        /*$('#iframe').stop().animate({
            left: "-100%"
        }, 500);
        $('#iframe2').stop().animate({
            right: "-100%"
        }, 500);*/
        $('#iframe').stop().fadeOut();
        $('#iframe2').stop().fadeOut();
        
        timestamp = new Date().getTime();
        var data = {"check": check, "link1": link1, "id1": id1, "link2": link2, "id2": id2, "winner": winner, "randomx": randomx, "randomy": randomy};
        console.log(data);
        check = "";
        var data_encoded = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "<?=$site['url']?>loggedIn/surfpost.php",
            dataType: "json",
            data: {
                "data" : data_encoded
            },
            success: function(data) {
                console.log(data);
                $("#views").html(data.count + " Views");
                if(!data.loggedIn)
                {
                    changeError("ERROR: You must login. Click <a href='<?=$site['url']?>'>here</a> to continue");
                }
                else if(data.error)
                {
                    changeError("ERROR: " + data.error);
                }
                else if(data.redirect)
                {
                    prevent_bust = -5;
                    window.location = "<?=$site["url"]?>sites";
                }
                else if(data.link1 != "" && data.id1 != "" && data.link2 != "" && data.id2 != "")
                {
                    select = false;
                    $("#divider").css("left", "49.7%");
                    $("#next div").html("Next");
                    $("#pannel").css("width", "50%");
                    $("#pannel2").css("width", "50%");
                    link1 = data.link1;
                    id1 = data.id1;
                    link2 = data.link2;
                    id2 = data.id2;
                    
                    waitDelay = 500 - (new Date().getTime() - timestamp);
                    if(waitDelay < 0) waitDelay = 1;
                    setTimeout(function() {
                        $('#iframe').css({
                            left: 0,
                            width: "49.7%"
                        });
                        $('#iframe2').css({
                            right: 0,
                            width: "49.7%"
                        });
                        $("#iframe").attr('src', data.link1);
                        $("#iframe2").attr('src', data.link2);
                        $("#verses").html(data.text);
                        setTimeout(function() {
                            $("#divider").fadeIn(1000);
                            $("#verses").fadeIn(300);
                            $("#iframe").fadeIn(500,function() {
                                $("#pannel").show();
                                $("#pannel2").show();   
                            });
                            $("#iframe2").fadeIn(500);
                            setTimeout(function() {
                                $("#verses").fadeOut(300);
                            },500);
                        },500);
                    }, waitDelay);
                    
                    /*setTimeout(function() {
                        $('#iframe').animate({
                            left: 0,
                            width: "49.7%"
                        }, 500, function(){
                            $("#pannel").show();
                            $("#pannel2").show();   
                        });
                        $('#iframe2').animate({
                            right: 0,
                            width: "49.7%"
                        }, 500);
                    }, 1500);*/
                        
                    changeText(data.text);
                }
                else if(data.link1 != "" && data.id1 != "")
                {
                    $("#next").show();
                    $("#next div").html("5");
                    link1 = data.link1;
                    id1 = data.id1;
                    link2 = data.link2;
                    id2 = data.id2;
                    
                    waitDelay = 500 - (new Date().getTime() - timestamp);
                    if(waitDelay < 0) waitDelay = 1;
                    setTimeout(function() {
                        $('#iframe').css({
                            left: 0,
                            width: "100%"
                        });
                        $("#iframe").attr('src', data.link1);
                        $("#iframe2").attr('src', data.link2);
                        $("#verses").html(data.text);
                        setTimeout(function() {
                            $("#iframe").fadeIn(500);
                            $("#verses").fadeIn(300);
                            setTimeout(function() {
                                $("#verses").fadeOut(300);
                            },1000);
                        },500);
                    }, waitDelay);
                    /*$('#iframe').animate({
                        left: 0,
                        width: "100%"
                    }, 500);*/
                        
                    changeText(data.text);
                }
                
                if(data.link1 != "" && data.id1 != "")
                {
                    $(".reportid").show();
                    $(".reporturl").show();
                    $(".reportid2").show();
                    $(".reporturl2").show();
                    $(".reportid3").show();
                    $(".reporturl3").show();
                    $(".reportid4").show();
                    $(".reporturl4").show();
                    $(".reportid").val(data.reportid);
                    $(".reportid2").val(data.reportid2);
                    $(".reportid3").val(data.reportid3);
                    $(".reportid4").val(data.reportid4);
                    $(".reporturl").html(data.reporturl);
                    $(".reporturl2").html(data.reporturl2);
                    $(".reporturl3").html(data.reporturl3);
                    $(".reporturl4").html(data.reporturl4);
                    $(".reporturl").attr("href", data.reporturl);
                    $(".reporturl2").attr("href", data.reporturl2);
                    $(".reporturl3").attr("href", data.reporturl3);
                    $(".reporturl4").attr("href", data.reporturl4);
                    if(data.reportid == "" || data.reportid < 5)
                    {
                        $(".reportid").hide();
                        $(".reporturl").hide();
                    }
                    if(data.reportid2 == "" || data.reportid2 < 5)
                    {
                        $(".reportid2").hide();
                        $(".reporturl2").hide();
                    }
                    if(data.reportid3 == "" || data.reportid3 < 5)
                    {
                        $(".reportid3").hide();
                        $(".reporturl3").hide();
                    }   
                    if(data.reportid4 == "" || data.reportid4 < 5)
                    {
                        $(".reportid4").hide();
                        $(".reporturl4").hide();
                    }   
                }
            },
            error: function(data)
            {
                console.log(data);   
            }
        });
    }
        
        
    function changeError(text)
    {
        $('#error').html(text);
    }
        
    function changeText(text)
    {
        
    }
        
    function count()
    {
        if($("#next div").html() != "Next")
        {
            if(parseInt($("#next div").html()) <= 1)
            {
                $("#next div").html("Next");
            }
            else
            {
                $("#next div").html($("#next div").html() - 1);
            }
        }
        setTimeout(count, 1000);
    }
        
    count();
        
        
    function reportSite() {
        $(".jquery-lightbox-move, .jquery-lightbox-overlay").fadeOut();
        
        var data = {"id": $(".jquery-lightbox-html input[type=radio]:checked").val(), "text": $(".jquery-lightbox-html .reportInput").val()};
        var data_encoded = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: "<?=$site['url']?>loggedIn/report.php",
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
        <div id="header">
            <div id="views" style="line-height:35px; font-size:18px;"></div>
            <div id="views" style="line-height:35px; margin-top:35px; font-size:18px; z-index:10;"><a style="color:#fff;" href="#reportSites" class="lightbox">Report</a></div>
        <div style="display:none;" class="reportSites" id="reportSites">
            <center style="width:400px;">
                Please select the website you would like to report:<br><br>
                <input class="reportid" type="radio" value="" name="reportid"> <a target="_blank" href="" class="reporturl"></a><br>
                <input class="reportid2" type="radio" value="" name="reportid"> <a target="_blank" href="" class="reporturl2"></a><br>
                <input class="reportid3" type="radio" value="" name="reportid"> <a target="_blank" href="" class="reporturl3"></a><br>
                <input class="reportid4" type="radio" value="" name="reportid"> <a target="_blank" href="" class="reporturl4"></a><br><br>
                Please enter the reason for reporting the website:<br><br>
                <textarea style="width:370px;" class="form-control reportInput"></textarea><br>
                <button onclick="reportSite()" id="reportSite" type="button" class="btn btn-primary">Report</button>
            </center>
        </div>
            <div class="menu">
                <a href="javascript:void(0);" id="next"><div>Next</div></a>
            </div>
            <a href="javascript:gohome();"><div class="logo" style="position:relative;z-index:10;">the revamped traffic exchange<br>in open beta</div></a>
        </div>
        <div id="error"></div>
        <div id="divider"></div>
        <iframe id="iframe" src=""></iframe>
        <iframe id="iframe2" src=""></iframe>
        <div id="pannel"></div>
        <div id="pannel2"></div>
        <div id="verses">VS.</div>
    </div>
</body>
</html>