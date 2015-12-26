<!doctype html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="<?=$site["url"]?>style.css">
	<link rel="stylesheet" href="<?=$site["url"]?>msgGrowl/css/msgGrowl.css" type="text/css" media="screen" title="no title" charset="utf-8" />
	<script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8" src="<?=$site["url"]?>msgGrowl/js/msgGrowl.js"></script>
	<title><?=$site["name"]?></title>
	<meta name="description" content="<?=$site["description"]?>" />
	<script>
		var hover = false;   
		var hover2 = false;   
		$(document).ready(function(){  
			<?php if(false && !$sec->cookie("salePromo")) { ?>
			$.msgGrowl ({
				title: "Save a whopping 40% on memberships.",
				text: "Don't surf for another day with the sweet Platinum upgrade. This is the first time laziness and success work together. Expires 10am on Friday EST.",
				sticky: true,
				position: "bottom-right",
				onClose: function () {
					setCookie("salePromo", ":D", 1);
					location.reload();
				},
				onOpen: function () {
					$('.msgGrowl').hover(function() {
						$('.msgGrowl').css("opacity",".5");
						$('.msgGrowl').css("cursor","pointer");
					}, function() {
						$('.msgGrowl').css("opacity",".9");
					});
					$('.msgGrowl-content').click(function() {
						window.location = "<?=$site['url']?>upgrade";
					});
				}
			});
			function setCookie(c_name,value,exdays)
			{
				var exdate=new Date();
				exdate.setDate(exdate.getDate() + exdays);
				var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
				document.cookie=c_name + "=" + c_value;
			}
			<?php } ?>
			$("#header .menu .openSubmenu").hover(function(){
				hover = true;
				html = $("div", this).html();
				$("#content .submenu").hide();
				$("#content div[name = '" + html + "']").show();
				var left = $(this).position().left;
				if(left > $("#content").width() - $("#content div[name = '" + html + "']").width()) 
				{
					left = $("#content").width() - $("#content div[name = '" + html + "']").width() - 15;
					$("#content div[name = '" + html + "'] .top").css({
						marginLeft: $("#content div[name = '" + html + "']").width() - $("div", this).innerWidth()
					});
				}
				else
				{
					$("#content div[name = '" + html + "'] .top").css({
						marginLeft: 0
					});
				}
				
				$("#content div[name = '" + html + "']").css({
					left: left,
					top: 70
				});
				$("#content div[name = '" + html + "'] .top").css({
					width: $("div", this).innerWidth()
				});
			},function() {
				hover = false;
			});

			$("body").mousemove(function(e){
				if($(e.target).parent().parent().attr("class") == "submenu") hover2 = true;
				else if($(e.target).parent().attr("class") == "submenu") hover2 = true;
				else hover2 = false;
				if(!hover && !hover2) $("#content .submenu").hide();
			});
			/*$("#content .submenu").hover(function(){
				hover2 = true;
			},function() {
				hover2 = false;   
			})*/
				
		});
	</script>
</head>
<body>
	
	<?php if(false && $usr->loggedIn && !$sec->cookie("promotionRaffle")) { ?>
	<div style="position:fixed;bottom:15px;right:15px; text-align:center; z-index:2;"><a href='javascript:setCookie("promotionRaffle", ":D", 1);' style="color:#c54545; font-weight:bold;"><img style="position:absolute; margin-left:233px; margin-top:-12px;" src="<?=$site['url']?>button_close.png"></a><a href="http://www.brisksurf.com/raffle.html"><img height="250" style="box-shadow:0 0 10px #454545;" src="http://www.brisksurf.com/raffle.png"></a></div>
	<script>
	function setCookie(c_name,value,exdays)
	{
		var exdate=new Date();
		exdate.setDate(exdate.getDate() + exdays);
		var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
		document.cookie=c_name + "=" + c_value;
		location.reload();
	}
	</script>
	<?php } ?>
	<div id="topBlueLine"></div>
	<div id="wrapper">
		<div id="header">
			<div class="menu">
				<?php if($usr->loggedIn) { ?>
					<a href="<?=$site["url"]?>surf"><div>Home</div></a>
					<a href="<?=$site["url"]?>commissions"><div>Commissions</div></a>
					<a href="<?=$site["url"]?>settings"><div>Settings</div></a>
					<a href="<?=$site["url"]?>logout"><div>Logout</div></a>
					<!--<a href="<?=$site["url"]?>surf"><div>Surf</div></a>
					<a href="#" class="openSubmenu">
						<div><?php echo $usr->firstName(); ?></div>
					</a>
					<a href="<?=$site["url"]?>sites"><div>My Sites</div></a>
					<a href="#" class="openSubmenu">
						<div>Promo</div>
					</a>
					<a href="#" class="openSubmenu">
						<div>Help Me</div>
					</a>-->
				<?php } else { ?>
					<!--<a href="<?=$site["url"]?>contact"><div>Contact Us</div></a>-->
					<a href="<?=$site["url"]?>login"><div>Login</div></a>
				<?php } ?>
			</div>
			<a href="<?=$site["url"]?>"><div class="logo">the revamped traffic exchange<br>in open beta</div></a>
		</div>
		<div id="content">
			<?php if($usr->loggedIn) { ?>
				<div class="submenu" class="openSubmenu" name="<?=$usr->firstName()?>">
					<div class="top"> </div>
					<a href="<?=$site["url"]?>upgrade"><div>Upgrade</div></a>
					<a href="<?=$site["url"]?>settings"><div>Settings</div></a>
					<a href="<?=$site["url"]?>logout"><div>Logout</div></a>
				</div>
				<div class="submenu" class="openSubmenu" name="Promo">
					<div class="top"> </div>
					<a href="<?=$site["url"]?>tools"><div>Tools</div></a>
					<a href="<?=$site["url"]?>referrals"><div>Referrals</div></a>
					<a href="<?=$site["url"]?>commissions"><div>Commissions</div></a>
				</div>
				<div class="submenu" class="openSubmenu" name="Help Me">
					<div class="top"> </div>
					<a href="<?=$site["url"]?>tos"><div>TOS</div></a>
					<a href="<?=$site["url"]?>faq"><div>FAQ</div></a>
					<!--<a href="<?=$site["url"]?>contact"><div>Contact</div></a>-->
				</div>
			<?php } ?>