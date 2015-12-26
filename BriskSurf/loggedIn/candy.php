<!DOCTYPE html>
<html>
<head>
	<title>Halloween</title>
	<style type="text/css">
		body{
			background: #eee;

		}
		.text{
			color: #333;
			font-size: 30px;
			text-align: center;
			margin-top: 150px;
			text-shadow: 3px 3px 2px #aaa;
		}
		a{
			text-decoration: none;
			color: #333;
		}
		a:hover{
			color: #f6921e;
		}
		input[type=submit]{
			margin-top: 20px;
			padding: 15px;
			border: 0;
			border-radius: 3px;
			background: #f6921e;
			color: #fff;
			font-size: 15px;
		}
		input[type=submit]:hover{
			background: #333;
		}
	</style>
</head>
<body>
	<div class="text">
		Congratulations! You found a candy!
		<br><br>
		<img src="<?=$site['url']?>images/halloween/candies/<?=$sec->get('c')?>.png">
		<br><br>
		<a target="_blank" href="<?=$site['url']?>halloween">View Progress</a>

		<?php if($sec->get('d')): ?>
		<br><br><br>
		Woah, you found a deal! <?=$packages[$sec->get('d')]['value'] == "0002" ? "Premium" : "Platinum" ?> Halloween Special for $<?=$packages[$sec->get('d')]["price"]?> / <?=$packages[$sec->get('d')]['type'] == "month" ? "Month" : "Year" ?>!
		<br>
		<form target="_blank" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
	                    <input type="hidden" name="a3" value="<?=$packages[$sec->get('d')]["price"]?>">
	                    <input type="hidden" name="p3" value="1">
	                    <input type="hidden" name="t3" value="<?=$packages[$sec->get('d')]['type'] == "month" ? "M" : "Y" ?>">
	                    <input type="hidden" name="src" value="1">
	                    <input type="hidden" name="no_shipping" value="1">
	                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
	                    <input type="hidden" name="currency_code" value="USD">
	                    <input type="hidden" name="item_name" value="<?=$site["name"]?> <?=$packages[$sec->get('d')]['value'] == "0002" ? "Premium" : "Platinum" ?> Halloween Special">
	                    <input type="hidden" name="item_number" value="<?=$subscription?>">
	                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
	                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
	                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
	                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
	                    <input type="submit" value='Upgrade Now' name="submit">
                	</form>
		<?php endif; ?>
	</div>

</body>
</html>