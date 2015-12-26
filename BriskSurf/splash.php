<!doctype html>
<html>
<head>
    <title>BriskSurf</title>
    <style>
        /*
        bgGrey = #f1f1f1
        red = #c74e4e
        darkred = #c54545
        darkerred = #b43232
        green = #87b24d
        darkgreen = #78a43e
        darkergreen = #65902c
        textGrey = #454545
        */
        body{
            padding:0;
            margin:0;
            background:#c74e4e;
            color:#fff;
            font-size:25px;
            text-align:center;
            height:100%;
            font-family:Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        
        #center {
            position: absolute;
            display: block;
            top: 50%;
            margin-top: -200px;
            height: 200px;
            text-align: center;
            width:100%;
        }   
        
        #submit{
            color:#c74e4e;
            background:#fff;
            padding:10px 30px;
            display:inline-block;
            font-size:20px;
            margin-top:100px;
            cursor:pointer;
            -webkit-border-radius: 5px; 
            -moz-border-radius: 5px; 
            border-radius: 5px; 
            font-weight:bold;
        }
    </style>
</head>
<body>
    <div id="center">
        <img src="images/smile.png"/><br>
        We Make Life Simple.<br><a href="http://brisksurf.com/<?php echo $_GET["r"]; ?>"><div id="submit">Find Out More</div></a>
    </div>
</body>
</html>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42820344-1', 'brisksurf.com');
  ga('send', 'pageview');

</script>