<?php include 'header.php'; ?>
<div class="row">
	<?php
	if($getVar) $query = $db->query("SELECT * FROM `stockSites` WHERE `id` = '{$getVar}'");
	if($getVar && $query->getNumRows())
	{
		$stockSite = $query->getNext();
		$query = $db->query("SELECT `worth` FROM `uniqueHits` WHERE `code` = '{$stockSite->code}' && `worth` != 0 ORDER BY `id` DESC LIMIT 1");
		$stockworth = $query->getNext()->worth;
		if($sec->post("addStockValue"))
		{
			$count = $sec->post("addStockValue");
			if(is_numeric($count) && $count >= 0)
			{
				$count = round($count);
				if($usr->data->coins >= $stockworth * $count)
				{
					$success = false;
					if($db->query("SELECT `id` FROM `stockOwners` WHERE `stockid` = '{$getVar}' && `userid` = '{$usr->data->id}'")->getNumRows())
					{
						$counterquery = $db->query("SELECT `count` FROM `stockOwners` WHERE `stockid` = '{$getVar}' && `userid` = '{$usr->data->id}'"); 
						$counter = 0;
						if($counterquery->getNumRows()) $counter = $counterquery->getNext()->count;
						if($counter + $count <= 100)
						{
							$db->query("UPDATE `stockOwners` SET `count` = `count` + {$count} WHERE `stockid` = '{$getVar}' && `userid` = '{$usr->data->id}'");
							$success = true;
						}
						else
						{
							?>
							<div class="col-md-12">
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<strong>Dude!</strong> Save some for the rest of us. You can't have more than 100!
								</div>
							</div>
							<?php
						}
					}
					else
					{
						$db->query("INSERT INTO `stockOwners` (`count`, `stockid`, `userid`) VALUES ({$count}, '{$getVar}', '{$usr->data->id}')");
						$success = true;
					}
					if($success)
					{
						$db->query("INSERT INTO `stockHistory` (`stockid`, `userid`, `count`, `worth`) VALUES ('{$getVar}', '{$usr->data->id}','{$count}','{$stockworth}')");
						$cost = $stockworth * $count;
						$db->query("UPDATE `users` SET `coins` = `coins` - {$cost} WHERE `id` = '{$usr->data->id}'");
						?>
						<div class="col-md-12">
							<div class="alert alert-success alert-dismissable">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>Well done!</strong> The stocks have been added.
							</div>
						</div>
						<?php
						$usr->getData();
					}
				}
				else
				{
					?>
					<div class="col-md-12">
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Oops!</strong> You do not have enough coins.
						</div>
					</div>
					<?php
				}
			}
			else
			{
				?>
				<div class="col-md-12">
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>Oops!</strong> You have entered an invalid stock count.
					</div>
				</div>
				<?php
			}
		}
		else if($sec->post("removeStockValue"))
		{
			$count = $sec->post("removeStockValue");
			if(is_numeric($count) && $count >= 0)
			{
				$count = round($count);
				$query = $db->query("SELECT `count` FROM `stockOwners` WHERE `stockid` = '{$getVar}' && `userid` = '{$usr->data->id}'");
				if($query->getNumRows() && $query->getNext()->count >= $count)
				{
					$db->query("UPDATE `stockOwners` SET `count` = `count` - {$count} WHERE `stockid` = '{$getVar}' && `userid` = '{$usr->data->id}'");
					$cost = $stockworth * $count;
					$db->query("INSERT INTO `stockHistory` (`stockid`, `userid`, `count`, `worth`) VALUES ('{$getVar}', '{$usr->data->id}','-{$count}','{$stockworth}')");
					$db->query("UPDATE `users` SET `coins` = `coins` + {$cost} WHERE `id` = '{$usr->data->id}'");
					?>
					<div class="col-md-12">
						<div class="alert alert-success alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Well done!</strong> The stocks have been removed.
						</div>
					</div>
					<?php
					$usr->getData();
				}
				else
				{
					?>
					<div class="col-md-12">
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<strong>Oops!</strong> You do not have enough stock to sell.
						</div>
					</div>
					<?php
				}
			}
			else
			{
				?>
				<div class="col-md-12">
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>Oops!</strong> You have entered an invalid stock count.
					</div>
				</div>
				<?php
			}
		}
	}
	?>

	<div class="col-md-8">
		<div class="widget stacked">
			<div class="widget-header">
				<i class="icon-gamepad"></i>
				<h3>Virtual Stocks</h3>
			</div>
			<div class="widget-content">
				<select id="selectStock" class="form-control">
					<option value="0">Select a Stock</option>
					<?php
					$options = $db->query("SELECT `id`, `name` FROM `stockSites` WHERE EXISTS (SELECT `worth` FROM `uniqueHits` WHERE `uniqueHits`.`code` = `stockSites`.`code` && `worth` != 0 ORDER BY `id` DESC LIMIT 1)");
					while($option = $options->getNext())
					{
						$query = $db->query("SELECT `worth` FROM `uniqueHits` WHERE `code` = '{$stockSite->code}' && `worth` != 0 ORDER BY `id` DESC LIMIT 1");
						$selected = ($option->id == $getVar) ? "selected " : "";
						echo "<option {$selected}value='{$option->id}'>{$option->name}</option>";
					}
					?>
					<script>
					$("#selectStock").change(function()
					{
						var value = $("#selectStock").val();
						window.location = "<?=$site['url']?>stocks/" + value;
					});
					</script>
				</select>
				<?php
				if($getVar && $query->getNumRows())
				{
				?>
					<br>
					<h5><center><b><a href="<?php 
						
						$query = $db->query("SELECT `id` FROM `videos` WHERE `code` = '{$stockSite->code}' LIMIT 1");
						if($query->getNumRows()) echo $site['url'] . 'video/' . $query->getNext()->id;
						else echo $stockSite->url;
						?>"><?=$stockSite->name?></a></b>: You can see the history of the stock.</center></h5><br>
					<div id="area-chart" class="chart-holder"></div>
					<div style="position:relative; float:left; margin-top:-25px; margin-left:30px;">Before</div>
					<div style="position:relative; float:right; margin-top:-25px; margin-right:10px;">Now</div>
					<script>
					$(function () {
						data = [<?php
						$query = $db->query("SELECT `worth` FROM `uniqueHits` WHERE `code` = '{$stockSite->code}' && `worth` != 0  && id >= 810  ORDER BY `id` DESC LIMIT 30");
						$count = 0;
						$min = 9999;
						$max = 0;
						while($result = $query->getNext())
						{
							if($result->worth > $max) $max = $result->worth;
							if($result->worth < $min) $min = $result->worth;
							$number = 15 - ($count);
							if($count != 0) echo ",";
							echo "[{$number},{$result->worth}]";
							$count++;
						}
						
						$diff = ($max - $min) * 0.2;
						
						$min = $min - $diff;
						$max = $max + $diff;
						
						if($min < 0) $min = 0;
							
						?>]
						// setup plot
						var options = {
							//yaxis: { min: 0, max: 100 },
							//xaxis: { min: 0, max: 100 },
							xaxis: { 
								ticks: [
									[1, "15 days"], [2, "14 days"], [3, "13 days"], [4, "12 days"], [5, "11 days"], 
									[6, "10 days"], [7, "9 days"], [8, "8 days"], [9, "7 days"], [10, "6 days"],
									[11, ""], [12, "4 days"], [13, "3 days"], [14, "2 days"], [15, "Yesterday"]
								],
								color: "#fff"
							},
							yaxis: { 
								minTickSize : 0.01,
								min: <?=$min?>,
								max: <?=$max?> 
							},
							colors: ["#F90", "#222", "#666", "#BBB"],
							series: {
									   lines: { 
											lineWidth: 2, 
											fill: true,
											fillColor: { colors: [ { opacity: 0.6 }, { opacity: 0.2 } ] },
											steps: false,
										}
								   }
						};
						
						var plot = $.plot($("#area-chart"), [ data ], options);
					});
				</script>
				</div>
			</div>
			<div class="widget stacked">
				<div class="widget-content">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#stocks" data-toggle="tab">Stocks</a></li>
						<li class=""><a href="#add" data-toggle="tab">Buy</a></li>
						<li class=""><a href="#remove" data-toggle="tab">Sell</a></li>
						<li class=""><a href="#history" data-toggle="tab">History</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade active in" id="stocks">
							<strong>Your stocks</strong>
							<p>
								<?php
								$query = $db->query("SELECT `count` FROM `stockOwners` WHERE `stockid` = '{$getVar}' && `userid` = '{$usr->data->id}'"); 
								$count = 0;
								$s = "s";
								if($query->getNumRows())
								{
									$count = $query->getNext()->count;
									if($count != 0)
									{
										$s = ($count == 1) ? "" : "s";
										$dividend = number_format($db->query("SELECT ((SELECT `count` FROM `stockOwners` WHERE `stockOwners`.`stockid` = '{$getVar}' && `stockOwners`.`userid` = {$usr->data->id} LIMIT 1) / (SELECT SUM(`count`) FROM `stockOwners` WHERE `stockOwners`.`stockid` = '{$getVar}' && `stockOwners`.`userid` > 3 LIMIT 1) * {$stockworth} * 20 * (1 + ({$usr->data->level} - 1) * 0.25)) AS `count` LIMIT 1")->getNext()->count, 2);
										$totalworth = $count * $stockworth;
										$s2 = ($totalworth == 1) ? "" : "s";
										$totalworth = number_format($totalworth);
										echo "You have {$count} stock{$s} invested in {$stockSite->name}.<br>You have a stock worth of {$totalworth} coin{$s}.<br>Every day you are active, you will earn {$dividend} coins.";
									}
									else echo "You do not have any stocks invested.";
								}
								else echo "You do not have any stocks invested.";
								?>
							</p>
						</div>
						<div class="tab-pane fade" id="add">
							<div class="form-group">
								Each stock costs <?=$stockworth?> coins. This price may vary from day to day. You have <?=$usr->data->coins?> coins.<br><br>
								<label class="col-md-2">
									Buy Stocks
								</label>
								<?php if($count >= 100) echo "You have already bought all the available stocks!"; else { ?>
								<form method="post" id="addStockForm">
									<div class="col-md-10">
										<div class="input-group">
											<span class="input-group-addon">#</span>
											<input name="addStockValue" id="addStockValue" type="text" class="form-control" placeholder="Enter a stock count">
											<span class="input-group-btn">
												<button id="addStockSubmit" class="btn btn-primary" type="button">Go!</button>
											</span>
										</div>
									</div>
								</form>
								<script>
								$("#addStockSubmit").click(function()
								{
									var count = $("#addStockValue").val();
									var price = Math.round(count * <?=$stockworth?> * 100) / 100;
									if(price != 0)
									{
										$.msgbox("Are you sure you want to buy " + count + " stocks for " + price + " coins?", {
										  type: "confirm",
										  buttons : [
											{type: "submit", value: "Yes"},
											{type: "submit", value: "No"}
										  ]
										}, function(result) {
											if(result == "Yes")
											{
												$("#addStockForm").submit();
											}
										});
									}
								});
								</script>
								<?php } ?>
							</div>
						</div>
						<div class="tab-pane fade" id="remove">
							<div class="form-group">
								Each stock costs <?=$stockworth?> coins. This price may vary from day to day. You have <?=$count?> stock<?=$s?>.<br><br>
								<label class="col-md-2">
									Sell Stocks
								</label>
								<form method="post" id="removeStockForm">
									<div class="col-md-10">
										<div class="input-group">
											<span class="input-group-addon">#</span>
											<input name="removeStockValue" id="removeStockValue" type="text" class="form-control" placeholder="Enter a stock count">
											<span class="input-group-btn">
												<button id="removeStockSubmit" class="btn btn-primary" type="button">Go!</button>
											</span>
										</div>
									</div>
								</form>
								<script>
								$("#removeStockSubmit").click(function()
								{
									var count = $("#removeStockValue").val();
									var price = Math.round(count * <?=$stockworth?> * 100) / 100;
									if(price != 0)
									{
										$.msgbox("Are you sure you want to sell " + count + " stocks for a profit of " + price + " coins?", {
										  type: "confirm",
										  buttons : [
											{type: "submit", value: "Yes"},
											{type: "submit", value: "No"}
										  ]
										}, function(result) {
											if(result == "Yes")
											{
												$("#removeStockForm").submit();
											}
										});
									}
								});
								</script>
							</div>
						</div>
						<div class="tab-pane fade" id="history">
							<?php
							if($usr->data->membership != "0001") {
								$histories = $db->query("SELECT `count`,`worth`, TIME_TO_SEC(TIMEDIFF(NOW(),`timestamp`)) AS `time` FROM `stockHistory` WHERE `userid` = '{$usr->data->id}' && `stockid` = '{$getVar}' ORDER BY `timestamp` DESC");
								if($histories->getNumRows())
								{
									echo '<table class="table table-bordered table-hover table-striped"><thead><tr><th>Date</th><th>Investment</th><th>Past Worth</th><th>Gain / Loss Possibility</th></tr></thead>';
									while($history = $histories->getNext())
									{
										$secondsInAMinute = 60;
										$secondsInAnHour  = 60 * $secondsInAMinute;
										$secondsInADay    = 24 * $secondsInAnHour;
									
										// extract days
										$days = floor($history->time / $secondsInADay);
									
										// extract hours
										$hourSeconds = $history->time % $secondsInADay;
										$hours = floor($hourSeconds / $secondsInAnHour);
									
										// extract minutes
										$minuteSeconds = $hourSeconds % $secondsInAnHour;
										$minutes = floor($minuteSeconds / $secondsInAMinute);
									
										// extract the remaining seconds
										$remainingSeconds = $minuteSeconds % $secondsInAMinute;
										$seconds = ceil($remainingSeconds);
										
										
										if($days != 0) $time = $days . " days";
										else if($hours != 0) $time = $hours . " hours";
										else if($minutes != 0) $time = $minutes . " minutes";
										else $time = $seconds . " seconds";
											
										
										$type = (strstr($history->count, "-")) ? "Sold " : "Bought ";
										$history->count = str_replace("-","",$history->count);
										$change = ($stockworth - $history->worth) * $history->count;
										$change = ($change < 0) ? "<font color='#c54545'>" . number_format($change,2) : "<font color='#87b24d'>" . number_format($change,2);
										$change .= " coins</font>";
										echo "<tr><td>{$time}</td><td>{$type}{$history->count} Stocks</td><td>{$history->worth} Coins / Stock</td><td>{$change}</td></tr>";
									}
									echo "</table>";
								}
								else echo "You do not have any investment history.";
							}
							else echo "<a href='{$site['url']}upgrade'>This is another great feature available to our upgraded members.</a>";
							?>
						</div>
					</div>
				<?php } else {
						
						
					$query = $db->query("SELECT COUNT(`stockOwners`.`id`) AS `totalsites`, SUM(`count`) AS `count`, SUM(`count` * (SELECT `worth` FROM `uniqueHits` WHERE `code` = `stockSites`.`code` && `worth` != 0 ORDER BY `id` DESC LIMIT 1)) AS `stockworth`, SUM(`count` / (SELECT SUM(`count`) FROM `stockOwners` AS `b` WHERE `b`.`stockid` = `stockOwners`.`stockid` && `b`.`userid` > 3 LIMIT 1) * (1 + ({$usr->data->level} - 1) * 0.25) * (SELECT `worth` FROM `uniqueHits` WHERE `code` = `stockSites`.`code` && `worth` != 0 ORDER BY `id` DESC LIMIT 1) * 20) AS `dividend` FROM `stockOwners` LEFT JOIN `stockSites` ON `stockSites`.`id` = `stockOwners`.`stockid` WHERE `stockOwners`.`userid` = '{$usr->data->id}' && `count` > 0"); 
					if($query->getNumRows())
					{
						$query = $query->getNext();
						$totalsites = $query->totalsites;
						$count = number_format($query->count);
						$s = ($count == 1) ? "" : "s";
						$stockworth = $query->stockworth;
						$dividend = number_format($query->dividend, 2);
						$s2 = ($stockworth == 1) ? "" : "s";
						$stockworth = number_format($stockworth);
						echo "<br><center>You have {$count} stock{$s} invested across {$totalsites} different exchanges worth {$stockworth} coin{$s}.<br>At your current level, you could earn {$dividend} coins daily just by being active.</center>";
					}
						
						
					$options = $db->query("SELECT CASE WHEN EXISTS(SELECT `stockOwners`.`id` FROM `stockOwners` WHERE `stockOwners`.`userid` = '{$usr->data->id}' && `stockid` = `stockSites`.`id` && `count` > 0 LIMIT 1) THEN ' &nbsp; : &nbsp; invested <i class=\"icon-thumbs-up\"></i>' ELSE '' END AS `selected`, (SELECT count(`worth`) FROM `uniqueHits` WHERE `code` = `stockSites`.`code` && `worth` != 0 ORDER BY `id` DESC LIMIT 1) AS `count`, (SELECT `worth` FROM `uniqueHits` WHERE `code` = `stockSites`.`code` && `worth` != 0 ORDER BY `id` DESC LIMIT 1) AS `worth`,
					(((SELECT `worth` FROM `uniqueHits` WHERE `code` = `stockSites`.`code` && `worth` != 0 ORDER BY `id` DESC LIMIT 1) - (SELECT `worth` FROM `uniqueHits` WHERE `code` = `stockSites`.`code` && `worth` != 0 ORDER BY `id` DESC LIMIT 1, 1)) / (SELECT `worth` FROM `uniqueHits` WHERE `code` = `stockSites`.`code` && `worth` != 0 ORDER BY `id` DESC LIMIT 1, 1) * 100) AS `day`,
					
					`name`,`id`, `code` FROM `stockSites` WHERE EXISTS (SELECT `worth` FROM `uniqueHits` WHERE `uniqueHits`.`code` = `stockSites`.`code` && DATE(`timestamp`) != DATE(NOW()) ORDER BY `timestamp` DESC LIMIT 1)");
						
					
					echo '<br><table class="table table-bordered table-hover table-striped"><thead><tr><th>Stock</th><th>Current Worth</th><th>Daily Change</th><th>Weekly Change</th></tr></thead>';
					while($option = $options->getNext())
					{
						$day = ($option->count >= 2) ? round($option->day, 2) . " %" : "N/A";
						if($day != "N\A")
						{
							$day = ($day < 0) ? "<font color='#c54545'>" . $day : "<font color='#87b24d'>" . $day;
							$day .= "</font>";
						}
						
						
						$week = $db->query("SELECT ((SELECT sum(`worth`) / 7 FROM (SELECT `worth`, `code` FROM `uniqueHits` WHERE `worth` != 0 && `code` = '{$option->code}' ORDER BY `id` DESC LIMIT 7) AS `thisWeek`) - (SELECT sum(`worth`) / 7 FROM (SELECT `worth`, `code` FROM `uniqueHits` WHERE `worth` != 0 && `code` = '{$option->code}' ORDER BY `id` DESC LIMIT 7, 7) AS `lastWeek`)) / (SELECT sum(`worth`) / 7 FROM (SELECT `worth`, `code` FROM `uniqueHits` WHERE `worth` != 0 && `code` = '{$option->code}' ORDER BY `id` DESC LIMIT 7, 7) AS `lastWeek`) * 100 AS `week`")->getNext()->week;
						
						$week = ($option->count >= 14) ? round($week, 2) . " %" : "N/A";
						if($week != "N\A")
						{
							$week = ($week < 0) ? "<font color='#c54545'>" . $week : "<font color='#87b24d'>" . $week;
							$week .= "</font>";
						}
						echo "<tr><td><a href='{$site['url']}stocks/{$option->id}'>{$option->name}</a>{$option->selected}</td><td>{$option->worth} coins</td><td>{$day}</td><td>{$week}</td></tr>";
					}
					echo '</table>';
				} ?>    
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="well">
			<h4>How it works</h4>
			<p>Buy stocks in your favorite TE and sell them for profit. In addition, every day you are active, you will earn a percentage of the stock worth in coins. The more stocks you own and the higher level you are, the more you will get in return.</p>
		</div>				
	</div>
</div>
<?php include 'footer.php'; ?>