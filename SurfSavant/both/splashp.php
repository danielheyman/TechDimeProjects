<link href="<?=$site["url"]?>res/css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">
<script src="<?=$site["url"]?>res/jquery-1.7.min.js"></script>
<script type="text/javascript" src="<?=$site['url']?>res/jquery-ui-1.10.3.js"></script>
<link href="http://www.surfsavant.com/res/css/font-awesome.min.css" rel="stylesheet">        
<style>
    <style>
    body{
            margin:0;
            padding:0;
            padding-top:30px;
            font-family:Frutiger,"Frutiger Linotype",Univers,Calibri,"Gill Sans","Gill Sans MT","Myriad Pro",Myriad,"DejaVu Sans Condensed","Liberation Sans","Nimbus Sans L",Tahoma,Geneva,"Helvetica Neue",Helvetica,Arial,sans-serif;
            background: #3687bf;
            font-size:12pt;
            text-align:center;
        }
        
        #wrapper
        {
            width:800px;
            height:600px;
            margin:auto;
            padding:20px;
            text-align:center;
            background:#fff;
            box-shadow:0px 3px #454545, 0 0 10px #454545;
            -moz-border-radius:10px;
            -o-border-radius:10px;
            -webkit-border-radius:10px;
            border-radius:10px;
        }
    
    
    body {
	    font-family: 'Lucida Grande', 'Helvetica Neue', sans-serif;
	    font-size: 13px;
    }

    h1 {
        margin-top:1140px;
        width: 100%;
        font-size: 30px;
        text-align: center;
        color: #fff;
        color:#454545;
        -o-text-shadow: 0px 1px 1px #ddd,
                     0px 2px 1px #d6d6d6;
        -moz-text-shadow: 0px 1px 1px #ddd,
                     0px 2px 1px #d6d6d6;
        -webkit-text-shadow: 0px 1px 1px #ddd,
                     0px 2px 1px #d6d6d6;
        text-shadow: 0px 1px 1px #ddd,
                     0px 2px 1px #d6d6d6;
        position:relative;
    }
    
    #more{
       width:300px;
        height:70px;
        background:#F90;
        color:#fff;
        -moz-border-radius:10px;
        -o-border-radius:10px;
        -webkit-border-radius:10px;
        line-height:70px;
        font-size:30px;
        margin:auto;
        position:relative;
        animation: slidein 3s;
        -webkit-animation: slidein 3s;
        -o-animation: slidein 3s;
        -moz-animation: slidein 3s;
        border:3px solid #F90;
    }
    
    #more:hover{
        color:#F90;
        background:#fff;
    }

	h1 {
        animation: slidein 3s;
        -webkit-animation: slidein 3s;
        -o-animation: slidein 3s;
        -moz-animation: slidein 3s;
    }
    
    @keyframes slidein
    {
    0% {left: -1200px;}
    50% {left: -1200px;}
    100% {left: 0px;}
    }
    
    @-webkit-keyframes slidein /* Safari and Chrome */
    {
    0% {left: -1200px;}
    50% {left: -1200px;}
    100% {left: 0px;}
    }
    
    @-o-keyframes slidein /* Safari and Chrome */
    {
    0% {left: -1200px;}
    50% {left: -1200px;}
    100% {left: 0px;}
    }
    
    @-moz-keyframes slidein /* Safari and Chrome */
    {
    0% {left: -1200px;}
    50% {left: -1200px;}
    100% {left: 0px;}
    }

    h2 {
        
        color:#F90;
        position:relative;
    }

	h2 {
        animation: slidein2 4s;
        -webkit-animation: slidein2 4s;
        -o-animation: slidein2 4s;
        -moz-animation: slidein2 4s;
    }
    
    @keyframes slidein2
    {
    0% {left: 1200px;}
    60% {left: 1200px;}
    100% {left: 0px;}
    }
    
    @-webkit-keyframes slidein2 /* Safari and Chrome */
    {
    0% {left: 1200px;}
    60% {left: 1200px;}
    100% {left: 0px;}
    }
    
    @-o-keyframes slidein2 /* Safari and Chrome */
    {
    0% {left: 1200px;}
    60% {left: 1200px;}
    100% {left: 0px;}
    }
    
    @-moz-keyframes slidein2 /* Safari and Chrome */
    {
    0% {left: 1200px;}
    60% {left: 1200px;}
    100% {left: 0px;}
    }
    
    .weekday2 {
        animation: slidein2 2s;
        -webkit-animation: slidein2 2s;
        -o-animation: slidein2 2s;
        -moz-animation: slidein2 2s;
    }
    
    
    
    
    
    body{
        background:#F90;
    }
    
    #box{
        width:535px;
        height:300px;
        margin:auto;
        margin-top:-1000px;
        position:relative;
        z-index:2;
    }
    #box2{
        width:534px;
        height:300px;
        position:absolute;
        z-index:1;
        top:-500px;
        -moz-box-shadow:0 0 15px #454545; 
        -webkit-box-shadow:0 0 15px #454545; 
        -o-box-shadow:0 0 15px #454545; 
        box-shadow:0 0 15px #454545; 
        border:2px solid #F90;
    }
    .tile{
        float:left;
    }
    .glow{
        -moz-box-shadow:0 0 15px #454545; 
        -webkit-box-shadow:0 0 15px #454545; 
        -o-box-shadow:0 0 15px #454545; 
        box-shadow:0 0 15px #454545; 
    }
    a{text-decoration:none; display:inline-block;}
</style>
<div id="wrapper">
    <div id="box"></div>
    <div id="box2"></div>
    <h1>Oh No! Looks like our logo broke. Can you help?</h1>
    <h2><i class="icon-lightbulb"></i> Learn to Succeed &nbsp; <i class="icon-money"></i> Make Money &nbsp; <i class="icon-thumbs-up"></i> Have Fun!</h2>
    <a target="_blank" href="<?=$site['url']?><?=$getVar?>"><div id="more">Learn More</div></a>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var img = new Image();
        img.src = '<?=$site['url']?>both/images/splash.png';
        count = 0;
        img.onload = function(){
            var w = 640;
            var h = 360;
            var w = 640 / 1.2;
            var h = 360 / 1.2;
            var r = 2;
            var c = 3;
            var source = img;
            var tileW = Math.round(w / c);
            var tileH = Math.round(h / r);
            for(var ri = 0; ri < r; ri += 1) {
              for(var ci = 0; ci < c; ci += 1) {
                var tile = $('<canvas class="tile glow tile' + ri + ci + '" id="tile' + ri + ci + '" height="' + tileH + '" width="' + tileW + '"></canvas>').get(0);
                $("#box").append(tile);
                $("#tile" + ri + ci).css("top", Math.floor((Math.random()*6)-4+2*ri) * 15);
                $("#tile" + ri + ci).css("left", Math.floor((Math.random()*12)-8+2*ci) * 15);
                var getit = $('#tile' + ri + ci).get(0);
                context = getit.getContext('2d');
                context.drawImage(source, ci*tileW * 1.19, ri*tileH * 1.19, tileW * 1.19, tileH * 1.19, 0, 0, tileW, tileH);
                $("#tile" + ri + ci).delay(count*200).animate({
                    top: "+=1060",
                }, 500);
                count++;
              }
            }
            
            $(".tile").draggable({snap: true,
                start: function(event,i)
                {
                    $( "canvas" ).addClass( "glow" );
                    $( "#box2" ).css( "top", -500);
                }
            });
            
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
              if(minxcount == 2 && maxxcount == 2 && minycount == 3 && maxycount == 3 && maxx - minx >= 354 && maxx - minx <= 358 && maxy - miny >= 149 && maxy - miny <= 151) complete = true;   
              else complete = false;
              if(complete) 
                {
                    $( "canvas" ).removeClass( "glow" );
                    $( "#box2" ).css( "top", $( "#tile00" ).offset().top - 2);
                    $( "#box2" ).css( "left", $( "#tile00" ).offset().left - 2);
                }
                else
                {
                    $( "canvas" ).addClass( "glow" );
                    $( "#box2" ).css( "top", -500);
                }
            });
        }
        
        var complete = false;
        
    });
</script>