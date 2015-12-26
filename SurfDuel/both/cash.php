
<head>
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
            width:600px;
            margin:auto;
            padding:20px;
            text-align:center;
            background:#fff;
            box-shadow:0px 3px #454545, 0 0 10px #454545;
            border-radius:10px;
        }
        
        img{
            width:200px;
            border:0;
        }
        
        button{
            padding:10px;
            border:0;
            border-radius:5px;
            background: #3687bf;
            color:#fff;
            box-shadow:0px 2px #454545;
            cursor:pointer;
        }
        
        button:hover{
            background:#454545;
            color:#3687bf;
            box-shadow:0px 2px #3687bf;
        }
        
        .color{
        }
        
        .large{
            color: #3687bf;   
            font-size:20pt; 
            display:inline-block;
        }
        
        a{
            text-decoration:none;   
        }
        
        .large2{
            color: #3687bf;   
            font-size:40pt; 
            display:inline-block; 
        }
        
        .blink{ 
            animation: myfirst 0.5s linear 0.5s infinite alternate;
            -moz-animation: myfirst 0.5s linear 0.5s infinite alternate; /* Safari and Chrome */
            -o-animation: myfirst 0.5s linear 0.5s infinite alternate; /* Safari and Chrome */
            -webkit-animation: myfirst 0.5s linear 0.5s infinite alternate; /* Safari and Chrome */
            display:inline-block;
        }
        
        @keyframes myfirst
        {
            from {color: #3687bf;}
            to {color: #8add38;}
        }

        @-webkit-keyframes myfirst /* Safari and Chrome */
        {
            from {color: #3687bf;}
            to {color: #8add38;}
        }

        @-moz-keyframes myfirst /* Safari and Chrome */
        {
            from {color: #3687bf;}
            to {color: #8add38;}
        }

        @-o-keyframes myfirst /* Safari and Chrome */
        {
            from {color: #3687bf;}
            to {color: #8add38;}
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div class="large2">GET <div class="blink">$3.00</div> NOW!</div>
        <br><br>
        A Revamped Traffic Exchange With a Cutting Edge Dueling System.
        <br><br>
        <div class="large">Surf 50 pages and have $3.00 added to your account!</div>
        <br><br>
        Only available for new members. Expires in 45 minutes.
        <br><br>
        <a href="http://www.surfduel.com/<?=$getVar?>" target="_blank"><button>Click here to Redeem</button></a>
    </div>
    <br><br>
    <center><img src="http://www.surfduel.com/images/logo.png"/></center>
</body>
