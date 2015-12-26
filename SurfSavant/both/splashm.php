<link href="http://www.surfsavant.com/res/css/font-awesome.min.css" rel="stylesheet">     
<style>
	img{border:0;}
	body, .cover{
		position:fixed;
		width:100%;
		height:100%;
		top:0;
		left:0;
		margin:0;
		padding:0;
		border:0;
		overflow:hidden;
		font-family: Frutiger,"Frutiger Linotype",Univers,Calibri,"Gill Sans","Gill Sans MT","Myriad Pro",Myriad,"DejaVu Sans Condensed","Liberation Sans","Nimbus Sans L",Tahoma,Geneva,"Helvetica Neue",Helvetica,Arial,sans-serif;
	}
	body{
		background: #A8C0AA;
        font-family: 'Lucida Grande', 'Helvetica Neue', sans-serif;
	}
	.box{
		position:absolute;
		left: 50%;
		top: 20px;
		margin-left:-215px;
		height: 400px;
		width: 450px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		background:white;
        -o-box-shadow: 0px 3px #454545, 0 0 10px #454545;
        -moz-box-shadow: 0px 3px #454545, 0 0 10px #454545;
        -webkit-box-shadow: 0px 3px #454545, 0 0 10px #454545;
        box-shadow: 0px 3px #454545, 0 0 10px #454545;
	}
	a{
		color:inherit;
		text-decoration:inherit;
		margin:0;
		border:0;
		padding:0;
	}
	h1{
		font-size:40px;
	}
	h1, h2{
		margin:0;
		border:0;
	}
	.cover{
		position:fixed;
		z-index:1;
		background:white;
		animation: finished 3s linear 7s;
		-webkit-animation: finished 3s linear 7s;
		-o-animation: finished 3s linear 7s;
		-moz-animation: finished 3s linear 7s;
		animation-fill-mode:forwards;
		-webkit-animation-fill-mode:forwards;
		-moz-animation-fill-mode:forwards;
		-o-animation-fill-mode:forwards;
	}
	.stuffone{
		position:relative;
		width:300px;
		margin-left:-150px;
		margin-right:-150px;
		margin-top:60px;
		margin-bottom:20px;
		height:50px;
		left:50%;
		animation: leftheading 5s linear 0s;
		-webkit-animation: leftheading 5s linear 0s;
		-o-animation: leftheading 5s linear 0s;
		-moz-animation: leftheading 5s linear 0s;
		animation-fill-mode:forwards;
		-webkit-animation-fill-mode:forwards;
		-moz-animation-fill-mode:forwards;
		-o-animation-fill-mode:forwards;
	}
	.stufftwo{
		position:relative;
		width:300px;
		margin-left:-150px;
		margin-right:-150px;
		margin-top:0;
		margin-bottom:0;
		height:38px;
		left:50%;
		animation: fromleft 5s linear 1.5s;
		-webkit-animation: fromleft 5s linear 1.5s;
		-o-animation: fromleft 5s linear 1.5s;
		-moz-animation: fromleft 5s linear 1.5s;
		color: #aa2b2b;
	}
	.stuffthree{
		position:relative;
		width:300px;
		margin-left:-150px;
		margin-right:-150px;
		margin-top:0;
		margin-bottom:0;
		height:38px;
		left:50%;
		animation: fromright 5s linear 1.5s;
		-webkit-animation: fromright 5s linear 1.5s;
		-o-animation: fromright 5s linear 1.5s;
		-moz-animation: fromright 5s linear 1.5s;
		color: #227ebc;
	}
	.stufffour{
		position:relative;
		width:300px;
		margin-left:-150px;
		margin-right:-150px;
		margin-top:0;
		margin-bottom:0;
		height:38px;
		left:50%;
		animation: fromleft 5s linear 1.5s;
		-webkit-animation: fromleft 5s linear 1.5s;
		-o-animation: fromleft 5s linear 1.5s;
		-moz-animation: fromleft 5s linear 1.5s;
		color: #F90;
	}
	.stufffive{
		position:relative;
		width:350px;
		margin-left:-167px;
		margin-right:-150px;
		margin-top:20;
		margin-bottom:0;
		height:38px;
		left:50%;
		animation: leftheading 5s linear 4s;
		-webkit-animation: leftheading 5s linear 4s;
		-moz-animation: leftheading 5s linear 4s;
		-o-animation: leftheading 5s linear 4s;
		animation-fill-mode:forwards;
		-webkit-animation-fill-mode:forwards;
		-moz-animation-fill-mode:forwards;
		-o-animation-fill-mode:forwards;
		color: #2c3f52;
	}
	.stuffsix{
		position:relative;
		width:300px;
		margin-left:-152px;
		margin-right:-152px;
		margin-top:20px;
		margin-bottom:0;
		height:25px;
		left:50%;
		animation: rightheading 5s linear 4s;
		-webkit-animation: rightheading 5s linear 4s;
		-webkit-animation: rightheading 5s linear 4s;
		-o-animation: rightheading 5s linear 4s;
		animation-fill-mode:forwards;
		-webkit-animation-fill-mode:forwards;
		-moz-animation-fill-mode:forwards;
		-o-animation-fill-mode:forwards;
		border: 2px solid #F90;
		padding: 10px;
		font-size: 20px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		font-weight:bold;
	}
	.stuffsix:hover{
		background: #F90;
		color:white;
	}
	@-webkit-keyframes fromleft{
		0% {z-index: 2; opacity:0; left:-20%;}
		25% {z-index: 2; opacity:1; left:45%;}
		75% {z-index: 2; opacity:1; left:55%;}
		100% {z-index: 2; opacity:0; left:200%;}
	}
	@-o-keyframes fromleft{
		0% {z-index: 2; opacity:0; left:-20%;}
		25% {z-index: 2; opacity:1; left:45%;}
		75% {z-index: 2; opacity:1; left:55%;}
		100% {z-index: 2; opacity:0; left:200%;}
	}
	@-moz-keyframes fromleft{
		0% {z-index: 2; opacity:0; left:-20%;}
		25% {z-index: 2; opacity:1; left:45%;}
		75% {z-index: 2; opacity:1; left:55%;}
		100% {z-index: 2; opacity:0; left:200%;}
	}
	@keyframes fromleft{
		0% {z-index: 2; opacity:0; left:-20%;}
		25% {z-index: 2; opacity:1; left:45%;}
		75% {z-index: 2; opacity:1; left:55%;}
		100% {z-index: 2; opacity:0; left:200%;}
	}
	@-webkit-keyframes leftheading{
		0% {z-index: 2; opacity:0; left:-20%;}
		25% {z-index: 2; opacity:1; left:40%;}
		100% {z-index: 2; opacity:1; left:50%;}
	}
	@-o-keyframes leftheading{
		0% {z-index: 2; opacity:0; left:-20%;}
		25% {z-index: 2; opacity:1; left:40%;}
		100% {z-index: 2; opacity:1; left:50%;}
	}
	@-moz-keyframes leftheading{
		0% {z-index: 2; opacity:0; left:-20%;}
		25% {z-index: 2; opacity:1; left:40%;}
		100% {z-index: 2; opacity:1; left:50%;}
	}
	@keyframes leftheading{
		0% {z-index: 2; opacity:0; left:-20%;}
		25% {z-index: 2; opacity:1; left:40%;}
		100% {z-index: 2; opacity:1; left:50%;}
	}
	@-webkit-keyframes rightheading{
		0% {z-index: 2; opacity:0; left:120%;}
		25% {z-index: 2; opacity:1; left:60%;}
		100% {z-index: 2; opacity:1; left:50%;}
	}
	@-o-keyframes rightheading{
		0% {z-index: 2; opacity:0; left:120%;}
		25% {z-index: 2; opacity:1; left:60%;}
		100% {z-index: 2; opacity:1; left:50%;}
	}
	@-moz-keyframes rightheading{
		0% {z-index: 2; opacity:0; left:120%;}
		25% {z-index: 2; opacity:1; left:60%;}
		100% {z-index: 2; opacity:1; left:50%;}
	}
	@keyframes rightheading{
		0% {z-index: 2; opacity:0; left:120%;}
		25% {z-index: 2; opacity:1; left:60%;}
		100% {z-index: 2; opacity:1; left:50%;}
	}
	@-webkit-keyframes fromright{
		0% {z-index: 2; opacity:0; left:120%;}
		25% {z-index: 2; opacity:1; left:55%;}
		75% {z-index: 2; opacity:1; left:45%;}
		100% {z-index: 2; opacity:0; left:-100%;}
	}
	@-o-keyframes fromright{
		0% {z-index: 2; opacity:0; left:120%;}
		25% {z-index: 2; opacity:1; left:55%;}
		75% {z-index: 2; opacity:1; left:45%;}
		100% {z-index: 2; opacity:0; left:-100%;}
	}
	@-moz-keyframes fromright{
		0% {z-index: 2; opacity:0; left:120%;}
		25% {z-index: 2; opacity:1; left:55%;}
		75% {z-index: 2; opacity:1; left:45%;}
		100% {z-index: 2; opacity:0; left:-100%;}
	}
	@keyframes fromright{
		0% {z-index: 2; opacity:0; left:120%;}
		25% {z-index: 2; opacity:1; left:55%;}
		75% {z-index: 2; opacity:1; left:45%;}
		100% {z-index: 2; opacity:0; left:-100%;}
	}
	@-webkit-keyframes finished{
		0% {opacity:1;}
		100% {opacity:0;}
	}
	@-o-keyframes finished{
		0% {opacity:1;}
		100% {opacity:0;}
	}
	@-moz-keyframes finished{
		0% {opacity:1;}
		100% {opacity:0;}
	}
	@keyframes finished{
		0% {opacity:1;}
		100% {opacity:0;}
	}
	
</style>
<body>
<div class = "cover"></div>
<div class = "box"></div>
<div class = "stuffone"><h1><center><i class="icon-shield"></i> Surf Savant</center></h1></div>
<div class = "stufftwo"><h2><center><i class="icon-lightbulb"></i> Learn To Succeed</center></h2></div>
<div class = "stuffthree"><h2><center><i class="icon-money"></i> Make Money</center></h2></div>
<div class = "stufffour"><h2><center><i class="icon-thumbs-up"></i> Have Fun</center></h2></div>
<div class = "stufffive"><h2><center>Win up to $50 every month!</center></h2></div>
<a target="_blank" href="http://www.surfsavant.com/<?=$getVar?>"><div class = "stuffsix"><center>Find Out More</center></div></a>
</body>