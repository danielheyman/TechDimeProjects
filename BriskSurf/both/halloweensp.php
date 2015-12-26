<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="http://brisksurf.com/jquery-latest.js" type="text/javascript"></script>
	<style type="text/css">
	body{
		margin:0;
		background: #aaa;
	}
	img{
		position: fixed;
		margin: auto;
		top: 50%;
		left: 50%;
		margin-top: -208px;
		margin-left: -500px;
		box-shadow: 0px 0px 10px #333;
	}
	.bg{
		position: fixed;
		z-index: 99;
		left: 0;
		top: 0;
		height: 100%;
		width: 100%;
	}
	</style>
</head>
<body>
<center>
	<a target="_blank" href="<?=$site['url'] . $sec->get('id')?>"><div class="bg"></div></a>
	<img class="image" src="<?=$site['url']?>both/halloween.jpg">
	<script type="text/javascript">
	if($(window).width() < 1000)
	{
		resize();
	}
	function resize() 
	{
		var w = $(window).width() - 50;
		if(w > 1000) w = 1000;

		$(".image").css({
			"width": w,
			"margin-left": -w / 2
		});

		$(".image").css({
			"margin-top": $(".image").css("height").replace("px", "") / -2
		});
	}
	$(window).resize(function() {
		resize();
	});
	</script>
</center>
</body>
</html>