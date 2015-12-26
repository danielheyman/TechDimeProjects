<?php include 'header.php'; 
$pumpkin = $db->query("SELECT count(`id`) as `count` FROM `halloweenHunt` where `candy` = 'pumpkin' && `userid` = '{$usr->data->id}' ")->getNext()->count;
$ghost = $db->query("SELECT count(`id`) as `count` FROM `halloweenHunt` where `candy` = 'ghost' && `userid` = '{$usr->data->id}' ")->getNext()->count;
$corn = $db->query("SELECT count(`id`) as `count` FROM `halloweenHunt` where `candy` = 'corn' && `userid` = '{$usr->data->id}' ")->getNext()->count;
$skull = $db->query("SELECT count(`id`) as `count` FROM `halloweenHunt` where `candy` = 'skull' && `userid` = '{$usr->data->id}' ")->getNext()->count;
$completion = ($corn + $skull) / 100;
if($completion > 1) $completion = 1;
?>
<div class="title" style="color: #f6921e;">Trick or Treat Halloween Hunt</div>
<hr>
<div class="text">
            <center>
                        <div style="display:inline-block; padding: 20px 0; margin-right: 20px; background-image: url(<?=$site['url']?>images/halloween/candies/pumpkin.png); background-repeat:no-repeat; padding-left:250px; height: 100px;">
                            Find this candy during surf for <strong>&cent;50</strong>.<br>You found: <strong><?=$pumpkin?></strong>
                        </div>
                        <div style="display:inline-block; padding: 20px 0; background-image: url(<?=$site['url']?>images/halloween/candies/ghost.png); background-repeat:no-repeat; padding-left:250px; height: 100px;">
                            Find this candy during surf for <strong>$1</strong>.<br>You found: <strong><?=$ghost?></strong>
                        </div>
            </center>
    	<div style="height:399px; overflow:hidden;">
	    	<div style="background-image: url(http://www.brisksurf.com/images/halloween/bag.png); height:399px; width:100%; background-size:399px auto; background-repeat: no-repeat; background-position:center;"></div>
	    	<div style="width:100%; height:<?=round((1-$completion)*350, 2)?>px; background: rgba(255,255,255,0.9); position:relative; margin:auto; margin-top:-399px; width: 400px;"></div>
    	</div>
    	<div style="width: 400px; background: #979797; height:20px; margin:auto; margin-top:30px; border-radius:5px; overflow:hidden;"><div style="height:20px; width:<?=5+round(($completion)*95, 2)?>%; background: #f6921e;"></div></div>
    	<center>
    		<br>Your candy will accumulate over the course of the event (count will not restart at midnight). Completed: <strong><?=round(($completion)*100, 2)?>% (<?=$corn+$skull?> Found)</strong><br>
    		Find <img style="position:relative; top:50px; margin-left: 20px; margin-right: 20px;" src="<?=$site['url']?>images/halloween/candies/corn.png"> and <img style="position:relative; top:50px; margin-left: 20px; margin-right: 20px;" src="<?=$site['url']?>images/halloween/candies/skull.png"> to fill up the bag.
    	</center>
    	<br><br><br><br>
    	<style type="text/css">
    		table{
    			border-radius: 5px;
    			overflow: hidden;
    		}
    		table td{
    			padding: 10px 20px;
    		}
    		table thead td{
    			background: #ff6000;
		}
    		table tr:nth-child(odd){
    			background: #ff9506;
    			color: #fff;
    		}
    		table tr:nth-child(even){
    			background: #f67407;
    			color: #fff;
    		}
    		table tr.selected{
    			background: #93b80a;
    		}
    	</style>
    	<table cellpadding="0" cellspacing="0">
    		<thead>
    			<td>Progress</td>
    			<td>Reward</td>
    		</thead>
    		<tr <?=($corn + $skull >= 100)?'class="selected"':''?>>
    			<td>Fill up 100% (100 Candies)</td>
    			<td>Get 1000 credits and platinum upgrade special for $1</td>
    		</tr>
    		<tr <?=($corn + $skull >= 90 && $corn + $skull <= 99)?'class="selected"':''?>>
    			<td>Fill up 90% (90 Candies)</td>
    			<td>Get 900 credits and platinum upgrade special for $2</td>
    		</tr>
    		<tr <?=($corn + $skull >= 80 && $corn + $skull <= 89)?'class="selected"':''?>>
    			<td>Fill up 80% (80 Candies)</td>
    			<td>Get 800 credits and platinum upgrade special for $3</td>
    		</tr>
    		<tr <?=($corn + $skull >= 70 && $corn + $skull <= 79)?'class="selected"':''?>>
    			<td>Fill up 70% (70 Candies)</td>
    			<td>Get 700 credits and platinum upgrade special for $4</td>
    		</tr>
    		<tr <?=($corn + $skull >= 60 && $corn + $skull <= 69)?'class="selected"':''?>>
    			<td>Fill up 60% (60 Candies)</td>
    			<td>Get 600 credits and platinum upgrade special for $5</td>
    		</tr>
    		<tr <?=($corn + $skull >= 50 && $corn + $skull <= 59)?'class="selected"':''?>>
    			<td>Fill up 50% (50 Candies)</td>
    			<td>Get 500 credits and platinum upgrade special for $6</td>
    		</tr>
    		<tr <?=($corn + $skull >= 40 && $corn + $skull <= 49)?'class="selected"':''?>>
    			<td>Fill up 40% (40 Candies)</td>
    			<td>Get 400 credits and platinum upgrade special for $7</td>
    		</tr>
    		<tr <?=($corn + $skull >= 30 && $corn + $skull <= 39)?'class="selected"':''?>>
    			<td>Fill up 30% (30 Candies)</td>
    			<td>Get 300 credits and platinum upgrade special for $8</td>
    		</tr>
    		<tr <?=($corn + $skull >= 20 && $corn + $skull <= 29)?'class="selected"':''?>>
    			<td>Fill up 20% (20 Candies)</td>
    			<td>Get 200 credits and platinum upgrade special for $9</td>
    		</tr>
    		<tr <?=($corn + $skull >= 10 && $corn + $skull <= 19)?'class="selected"':''?>>
    			<td>Fill up 10% (10 Candies)</td>
    			<td>Get 100 credits and platinum upgrade special for $10</td>
    		</tr>
    		<tr <?=($corn + $skull >= 0 && $corn + $skull <= 9)?'class="selected"':''?>>
    			<td>Fill up 0% (0 Candies)</td>
    			<td>Are you even tryin'?</td>
    		</tr>
    	</table>
    	<br><br><br>
</div>
<script src="<?=$site['url']?>loggedIn/src/bats/halloween-bats.js"></script>
<script type="text/javascript">
	$.fn.halloweenBats({
		image: '<?=$site['url']?>loggedIn/src/bats/bats.png',
		amount: 3
	});
</script>
<?php include 'footer.php'; ?>