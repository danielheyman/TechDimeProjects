<?php include 'header.php'; ?>
<div class="title" style="color:#289e48">Big Foot Badge Hunt</div>
<hr>
<div class="text">
	<?php
	if($sec->post("listviral"))
        	{
        		$db->query("UPDATE `users` SET `listviral` = '{$sec->post("listviral")}' WHERE `id`='{$usr->data->id}'");
        		$usr->getData();
        	}
        	?>
	<a href="http://clicktrackprofit.com/?referer=introace" target="_blank"><img src='http://www.clicktrackprofit.com/reloaded/badgehuntsept.jpg'></a>
	<br><br>
   	<strong>How it works</strong>: The person who collects the most badge hunt badges will receive a $500 cash prize! if it's a tie, the prize will be split amongst the top collectors. On top of that, during the event Click Track Profit will be giving out tons of XP randomly when members collect the badges!
	<br><br>
	<a style="color:#289e48" href="http://clicktrackprofit.com/?referer=introace" target="_blank">Join the Hunt Now!</a>


	<style>
		.calendar .top{
			background:#b26c24;
			padding: 5px 20px;
			color: #fff;
		}
		.calendar table td{
			border: 1px solid #b26c24;
			text-align: center;
		}
		.calendar table .r{
			background: #c54545;
			color: #fff;
		}
		#content .content .text .calendar table .r a{
			color: #fff;
		}
		#content .content .text .calendar table .r a:hover{
			color: #ffa9ad;
		}

		.calendar table .g{
			background: #289e48;
			color: #fff;
		}
	</style>
	<br><br>
	<?php
	function buyBadge($number, $name, $userid, $site, $price = 5, $text = "Buy this badge for $5", $color = true)
	{
		?>
		<form style="display:inline-block;" name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	                    <input type="hidden" name="cmd" value="_xclick">
	                    <input type="hidden" name="amount" value="<?=$price?>">
	                    <input type="hidden" name="rm" value="1">
	                    <input type="hidden" name="no_note" value="1">
	                    <input type="hidden" name="no_shipping" value="1">
	                    <input type="hidden" name="business" value="<?=$site['paypal']?>">
	                    <input type="hidden" name="currency_code" value="USD">
	                    <input type="hidden" name="item_name" value="<?=$name?>">
	                    <input type="hidden" name="item_number" value="<?=$number?>">
	                    <input type="hidden" name="notify_url" value="<?=$site['url']?>ipnBadge.php">
	                    <input type="hidden" name="custom" value='<?=$userid?>'>
	                    <input type="hidden" name="cancel_return" value="<?=$site['url']?>">
	                    <input type="hidden" name="return" value="<?=$site['url']?>success">
	                    <a style='<?=$color ? 'color:#289e48' : '' ?>' href='javascript:void()'  onclick="$(this).closest('form').submit()"><?=$text?></a>
                	</form> 
                	<?php
	}
	function checkBadge($db, $badge, $userid, $listviral = false)
	{
		$hash = md5($badge . $listviral . 'odA7WV7PkZE8GcRuUaStxE2UBWddHvbX');
		$listviral = ($listviral) ? file_get_contents("http://www.listviral.com/badgeCheck.php?id={$listviral}&b={$badge}&h={$hash}") : false;
		$badge = $db->query("SELECT `code` FROM `badgeHunt` WHERE `badge` = '{$badge}' && `userid` = {$userid}");
		if($listviral != '0' || $badge->getNumRows())
		{
			$code = ($listviral != '0') ? $listviral : $badge->getNext()->code;
			return "<br><br>You found the badge! <a style='color:#289e48' href='http://clicktrackprofit.com/reloaded/claimbadge.php?{$code}'' target='_blank'>Click here to claim</a>";
		}
		return false;
	}


	$calendar = $db->query("SELECT `timestamp` from `surfHistory` WHERE `userid` = {$usr->data->id} && `views` >= 100 && `timestamp` >= DATE('2014-09-22') && `timestamp` <= DATE('2014-10-05') ");
	$calendar_array = [
		"22" => 0, 
		"23" => 0, 
		"24" => 0, 
		"25" => 0, 
		"26" => 0, 
		"27" => 0, 
		"28" => 0, 
		"29" => 0, 
		"30" => 0, 
		"01" => 0, 
		"02" => 0, 
		"03" => 0, 
		"04" => 0, 
		"05" => 0
	];
	while($c = $calendar->getNext()) $calendar_array[explode("-",$c->timestamp)[2]] = 1;

	$longest_time_array = [0];
	$longest_time = 0;
	for($x = 0; $x < count($calendar_array); $x++)
	{
		$val = array_values(array_slice($calendar_array, $x, $x + 1))[0];
		if ($val == 0) $longest_time_array[] = 0;
		else $longest_time_array[count($longest_time_array) - 1]++;
	}
	for($x = 0; $x < count($longest_time_array); $x++)
	{
		if($longest_time_array[$x] > $longest_time) $longest_time = $longest_time_array[$x];
	}

	if($longest_time >= 6 && !checkBadge($db, 114, $usr->data->id))
	{
		$code = file_get_contents("http://clicktrackprofit.com/api.php?bid=5922&key=3d7b6d56d7");
		$db->query("INSERT INTO `badgeHunt` (`badge`, `userid`, `code`) VALUES ('114', {$usr->data->id}, '{$code}') ");
	}
	if($longest_time >= 12 && !checkBadge($db, 115, $usr->data->id))
	{
		$code = file_get_contents("http://clicktrackprofit.com/api.php?bid=5923&key=132055aad4");
		$db->query("INSERT INTO `badgeHunt` (`badge`, `userid`, `code`) VALUES ('115', {$usr->data->id}, '{$code}') ");
	}

	if(($db->query("SELECT count(`id`) as `count` FROM `badgeHunt` WHERE `userid` = {$usr->data->id} && `badge` != 118")->getNext()->count +  (checkBadge($db, 116, $usr->data->id, $usr->data->listviral) != false) + (checkBadge($db, 117, $usr->data->id, $usr->data->listviral) != false)) >= 4 && !checkBadge($db, 118, $usr->data->id))
	{
		$code = file_get_contents("http://clicktrackprofit.com/api.php?bid=5926&key=81608ee0e9");
		$db->query("INSERT INTO `badgeHunt` (`badge`, `userid`, `code`) VALUES ('118', {$usr->data->id}, '{$code}') ");
	}

	function show_dates($begin, $end, $cal, $userid, $site)
	{
		for($x = $begin; $x <= $end; $x++)
		{
			
			if($cal[str_pad($x, 2, "0", STR_PAD_LEFT)] == 0)
			{
				$item = str_pad($x, 2, "0", STR_PAD_LEFT);
				if($x > 20) $item = "2014-09-{$item}";
				else $item = "2014-10-{$item}";
				echo "<td class='r'>";
				buyBadge($item, "Day {$item} Surf 100", $userid, $site, 2, $x, false);
				echo "</td>";
			}
			else echo "<td class='g'>{$x}</td>";
		}
	}
	?>

    	<div class="subtitle" style="color:#289e48">Hassle-Free Zone</div>
    	<img src="http://max.clicktrackprofit.com/images/bigfoot114.png">
    	<img src="http://max.clicktrackprofit.com/images/bigfoot115.png">
    	<img src="http://max.clicktrackprofit.com/images/bigfoot116.png">
    	<img src="http://max.clicktrackprofit.com/images/bigfoot117.png">
    	<img src="http://max.clicktrackprofit.com/images/bigfoot118.png">
    	<br><br>
    	Feel like getting all five badges hassle free? <?php buyBadge(1000, "5 BriskSurf & ListViral Badges", $usr->data->id, $site, 20, "Buy all 5 for $20"); ?>
    	<br><br>

    	<div class="subtitle" style="color:#289e48">BriskSurf Badges</div>
    	<div style="padding: 37px 0; background-image: url(http://max.clicktrackprofit.com/images/bigfoot114.png); background-repeat:no-repeat; padding-left:120px;">
    		Earn this badge by surfing <strong>100</strong> pages for <strong>6</strong> consecutive days. <?php buyBadge(114, "BriskSurf 6 Day Badge", $usr->data->id, $site); ?>
    		<?php echo checkBadge($db, 114, $usr->data->id); ?>
    	</div>
    	<div style="padding: 37px 0; background-image: url(http://max.clicktrackprofit.com/images/bigfoot115.png); background-repeat:no-repeat; padding-left:120px;">
    		Earn this badge by surfing <strong>100</strong> pages for <strong>12</strong> consecutive days. <?php buyBadge(115, "BriskSurf 12 Day Badge", $usr->data->id, $site); ?>
    		<?php echo checkBadge($db, 115, $usr->data->id); ?>
    	</div>

    	<br><br>
    	<strong>Progress (Red - not surfed, green - surfed):</strong>
    	<br>Click on a red date (a day that you have not surfed), to purchase a skip date for $2. You can use this feature for many reasons such as if you happen to miss a day or you know that you will not have time on a certain day. This will mark any day as surfed without any additional work required.
    	<br><br>
	<div class="calendar">
		<div class="top">September 22nd - October 5 2014</div>
		<table cellspacing=0 cellpadding=0>
			<tr>
				<td>Mon</td>
				<td>Tue</td>
				<td>Wed</td>
				<td>Thu</td>
				<td>Fri</td>
				<td>Sat</td>
				<td>Sun</td>
			</tr>
			<tr>
				<?php show_dates(22, 28, $calendar_array, $usr->data->id, $site); ?>
			</tr>
			<tr>
				<?php show_dates(29, 30, $calendar_array, $usr->data->id, $site); ?>
				<?php show_dates(1, 5, $calendar_array, $usr->data->id, $site); ?>
			</tr>
		</table>
	</div>

	
	 <br><br>
    	<div class="subtitle" style="color:#289e48">List Viral Badges</div>
    	Enter your List Viral Username: <form style="display:inline-block;" method="post"><input name="listviral" type="text" value="<?=$usr->data->listviral?>"> <input type="submit"></form>
    	<br><br>
    	<div style="padding: 37px 0; background-image: url(http://max.clicktrackprofit.com/images/bigfoot116.png); background-repeat:no-repeat; padding-left:120px;">
    		You will find this badge randomly after claiming emails at <a style="color:#289e48" href="http://listviral.com" target="_blank">List Viral</a>.
    		<?php echo checkBadge($db, 116, $usr->data->id, $usr->data->listviral); ?>
    	</div>
    	<div style="padding: 37px 0; background-image: url(http://max.clicktrackprofit.com/images/bigfoot117.png); background-repeat:no-repeat; padding-left:120px;">
    		You will find this badge randomly after claiming emails at <a style="color:#289e48" href="http://listviral.com" target="_blank">List Viral</a>.
    		<?php echo checkBadge($db, 117, $usr->data->id, $usr->data->listviral); ?>
    	</div>

	
	 <br><br>
    	<div class="subtitle" style="color:#289e48">Bonus Badge</div>
    	<div style="padding: 37px 0; background-image: url(http://max.clicktrackprofit.com/images/bigfoot118.png); background-repeat:no-repeat; padding-left:120px;">
    		Earn this badge when you find <strong>all four</strong> previous badges. Make sure you have your ListViral username entered in order to win this badge. <?php buyBadge(118, "Four Badge Combo Badge", $usr->data->id, $site); ?>
    		<?php echo checkBadge($db, 118, $usr->data->id); ?>
    	</div>
</div>
<?php include 'footer.php'; ?>