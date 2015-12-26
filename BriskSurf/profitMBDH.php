<?php 
include 'profit.php'; 
include 'cleanConfig.php';

$new = array();
foreach($expenses["TechDime"] as $expense)
{
	foreach($expense as $key => $value) $new[$key] = $value;
}
$expenses = $new;
$new = array();
foreach($lastMonthExpenses["TechDime"] as $expense)
{
	foreach($expense as $key => $value) $new[$key] = $value;
}
$lastMonthExpenses = $new;
?>

<style>
body{
	margin:0;
}

.title{
	padding:20px;
	background: #e84e40;
	color: #ECF0F1;
	text-align: center;
	margin:0;
	font-family: Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size:17px;
}
.sub{
	padding:15px;
	background: #34495E;
	color: #ECF0F1;
	text-align: center;
	margin:0;
	font-family: Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size:15px;
}
.list{
	font-family: Frutiger, "Frutiger Linotype", Univers, Calibri, "Gill Sans", "Gill Sans MT", "Myriad Pro", Myriad, "DejaVu Sans Condensed", "Liberation Sans", "Nimbus Sans L", Tahoma, Geneva, "Helvetica Neue", Helvetica, Arial, sans-serif;
	color: #2C3E50;
	width:100%;
	margin:0;
	border-spacing: 0px;
}
.list tr{
	background:#e0e0e0;
}
.list tr:nth-child(2n+1)
{
	background: #eeeeee;
}
.list td{
	padding:10px;
	width:50%;
	font-size: 15px;
}
.list tr td:nth-child(1){
	/*text-align: right;*/
}
.list tr td:nth-child(2){
	text-align: right;
}
.list:not(.no_dollar) tr td:nth-child(2):before{
	content:"$ ";
}

.card{
	padding: 0;
	margin:0px;
	width:100%;
	display: inline-block;
	vertical-align:top;
}

@media(min-width:800px)
{
	.card{
		width:50%;
	}
}

.card .inner{
	overflow: hidden;
	margin:10px;
	border-radius: 2px;
	box-shadow: 0 0px 3px rgba(0,0,0,0.5), 0 2px 2px rgba(0,0,0,0.3);
}

.card .inner:hover{
	box-shadow: 0 0px 10px rgba(0,0,0,0.7), 0 2px 4px rgba(0,0,0,0.5);
}

</style>
<?php 


//BRISKSURF DAILY STATS
//BRISKSURF DAILY STATS
//BRISKSURF DAILY STATS
echo "<div class='card'><div class='inner'>";
$result = $db->query("select count(id) as count, sum(views) as views, sum(dailyViews) as dailyViews from users WHERE `activation` = '1'");
$result = $result->getNext();
echo "<div class='title'>BriskSurf</div><table class='list no_dollar'><tr><td>Users</td><td>{$result->count}</td></tr><tr><td>Total views today</td><td>{$result->dailyViews}</td></tr>";
$result = $db->query("select count(id) as count from users where membership != '0001'");
$result = $result->getNext();
$count = $result->count - 2;
echo "<tr><td>Upgraded</td><td>{$count}</td></tr>";
$result = $db->query("select count(id) as count from users where registerDate >= DATE(Now())");
$result = $result->getNext();
echo "<tr><td>Registered today</td><td>{$result->count}</td></tr>";
$result = $db->query("select count(id) as count from users where lastLogin >= Now() - INTERVAL 1 DAY");
$result = $result->getNext();
echo "<tr><td>Loggedin 24 hours</td><td>{$result->count}</td></tr>";
$result = $db->query("select count(id) as count from users where lastLogin >= Now() - INTERVAL 1 WEEK");
$result = $result->getNext();
echo "<tr><td>Loggedin 1 week</td><td>{$result->count}</td></tr>";
$result = $db->query("select count(id) as count from websites where credits >= 1");
$result = $result->getNext();
echo "<tr><td>Active websites</td><td>{$result->count}</td></tr></table>";
echo "</div></div>";


//PROFITS TODAY
//PROFITS TODAY
//PROFITS TODAY
echo "<div class='card'><div class='inner'>";
$result = $db->query("SELECT SUM( transactions.amount ) as profit FROM transactions LEFT JOIN commissions on transactions.id = commissions.transactionid where date >= DATE(Now())");
$result = number_format($result->getNext()->profit, 2);
$list = array("BriskSurf" => $result, "ListViral" => $listviral[0]);
arsort($list, SORT_NUMERIC);
echo "<div class='title'>Gains Today</div><table class='list'>";
foreach($list as $key => $value) echo "<tr><td>{$key}</td><td>" . number_format($value, 2) . "</td></tr>";
echo "<tr><td><strong>Total</strong></td><td><strong>" . number_format(($result + $listviral[0]),2) . "</strong></td></tr></table>";
echo "</div></div>";


//PROFITS YESTERDAY
//PROFITS YESTERDAY
//PROFITS YESTERDAY
echo "<div class='card'><div class='inner'>";
$result = $db->query("SELECT SUM( transactions.amount ) as profit FROM transactions LEFT JOIN commissions on transactions.id = commissions.transactionid where date >= DATE(Now() - INTERVAL 1 DAY) && date <= DATE(Now())");
$result = number_format($result->getNext()->profit, 2);
$list = array("BriskSurf" => $result, "ListViral" => $listviral[1]);
arsort($list, SORT_NUMERIC);
echo "<div class='title'>Gains Yesterday</div><table class='list'>";
foreach($list as $key => $value) echo "<tr><td>{$key}</td><td>" . number_format($value, 2) . "</td></tr>";
echo "<tr><td><strong>Total</strong></td><td><strong>" . number_format(($result + $listviral[1]),2) . "</strong></td></tr></table>";
echo "</div></div>";

//PROFITS WEEK
//PROFITS WEEK
//PROFITS WEEK
echo "<div class='card'><div class='inner'>";
$result = $db->query("SELECT SUM( transactions.amount ) as profit FROM transactions LEFT JOIN commissions on transactions.id = commissions.transactionid where date >= DATE(Now() - INTERVAL 1 WEEK)");
$result = number_format($result->getNext()->profit, 2);
$list = array("BriskSurf" => $result, "ListViral" => $listviral[2]);
arsort($list, SORT_NUMERIC);
echo "<div class='title'>Week Gains</div><table class='list'>";
foreach($list as $key => $value) echo "<tr><td>{$key}</td><td>" . number_format($value, 2) . "</td></tr>";
echo "<tr><td><strong>Total</strong></td><td><strong>" . number_format(($result + $listviral[2]),2) . "</strong></td></tr></table>";
echo "</div></div>";

//PROFITS MONTH CALC BRISKSURF
//PROFITS MONTH CALC BRISKSURF
//PROFITS MONTH CALC BRISKSURF
$result = $db->query("SELECT SUM( `amount` ) AS `sum`, ROUND((SUM( `amount` ) * .02),2) AS `massPayFees` FROM `commissions` WHERE `status` = '0' && MONTH(`paidDate`) = MONTH(NOW()) && YEAR(`paidDate`) = Year(NOW())");
$result = $result->getNext();
$result2 = $db->query("SELECT SUM( transactions.amount ) as profit, ROUND((SUM( transactions.amount ) * .029) + (SUM( if(transactions.amount != '0', 1, 0) ) * .3), 2) as loss FROM transactions LEFT JOIN commissions on transactions.id = commissions.transactionid where MONTH(`date`) = MONTH(NOW()) &&  YEAR(`date`) = Year(NOW())");
$result2 = $result2->getNext();
$commissions = $result->sum;
$massPayFees = $result->massPayFees;
$profit = $result2->profit;
$loss = $result2->loss;


//PROFITS MONTH DISPLAY
//PROFITS MONTH DISPLAY
//PROFITS MONTH DISPLAY
echo "<div class='card'><div class='inner'>";
$commissions = number_format($commissions + $listviral[3], 2);
$paypalFees = number_format($loss + $listviral[6] + $massPayFees + $listviral[4], 2);
$gross = number_format($profit + $listviral[5] + $commsTotal, 2);
$totalGross = number_format($totalGross + $gross, 2);
$totalYearGross = number_format($totalYearGross + $gross, 2);
$expense = number_format($commissions + $paypalFees + $feesTotal, 2);
$net = number_format($profit + $listviral[5]+ $commsTotal - $commissions - $paypalFees - $feesTotal, 2);
$totalNet = number_format($totalNet + $net, 2);
$totalYearNet = number_format($totalYearNet + $net, 2);
$profit = number_format($profit, 2);
$list = array("BriskSurf" => $profit, "ListViral" => $listviral[5]);
$list  = array_merge($list, $comms);
arsort($list, SORT_NUMERIC);
echo "<div class='title'>Month Gains</div><div class='sub'>Profits</div><table class='list'>";
foreach($list as $key => $value)
{
	if($value != 0) echo "<tr><td>{$key}</td><td>" . number_format($value, 2) . "</td></tr>";
}
echo "<tr><td><strong>Gross Profit</strong></td><td><strong>" . $gross . "</strong></td></tr></table><div class='sub'>Expenses</div><table class='list'>";
$list = array("Commissions" => $commissions, "Paypal Fees" => $paypalFees);
$list  = array_merge($list, $expenses);
arsort($list, SORT_NUMERIC);
foreach($list as $key => $value) echo "<tr><td>{$key}</td><td>" . number_format($value, 2) . "</td></tr>";
echo "<tr><td><strong>Expenses</strong></td><td><strong>" . $expense . "</strong></td></tr></table><div class='sub'>Net Profit: $ " . $net . "</div>";
echo "</div></div>";

//PROFITS LAST MONTH CALC BRISKSURF
//PROFITS LAST MONTH CALC BRISKSURF
//PROFITS LAST MONTH CALC BRISKSURF
$result = $db->query("SELECT SUM( `amount` ) AS `sum`, ROUND((SUM( `amount` ) * .02),2) AS `massPayFees` FROM `commissions` WHERE `status` = '0' && MONTH(`paidDate`) = MONTH(NOW() - INTERVAL 1 MONTH) && YEAR(`paidDate`) = YEAR(NOW() - INTERVAL 1 MONTH)");
$result = $result->getNext();
$result2 = $db->query("SELECT SUM( transactions.amount ) as profit, ROUND((SUM( transactions.amount ) * .029) + (SUM( if(transactions.amount != '0', 1, 0) ) * .3), 2) as loss FROM transactions LEFT JOIN commissions on transactions.id = commissions.transactionid where MONTH(`date`) = MONTH(NOW() - INTERVAL 1 MONTH) && YEAR(`date`) = YEAR(NOW() - INTERVAL 1 MONTH)");
$result2 = $result2->getNext();
$commissions = $result->sum;
$massPayFees = $result->massPayFees;
$profit = $result2->profit;
$loss = $result2->loss;


//PROFITS LAST MONTH DISPLAY
//PROFITS LAST MONTH DISPLAY
//PROFITS LAST MONTH DISPLAY
echo "<div class='card'><div class='inner'>";
$commissions = number_format($commissions + $listviral[7], 2);
$paypalFees = number_format($loss + $listviral[10] + $massPayFees + $listviral[8], 2);
$gross = number_format($profit + $listviral[9] + $lastMonthCommsTotal, 2);
$expense = number_format($commissions + $paypalFees + $lastMonthFeesTotal, 2);
$net = number_format($profit + $listviral[9] + $lastMonthCommsTotal - $commissions - $paypalFees - $lastMonthFeesTotal, 2);
$profit = number_format($profit, 2);

$datestring= 'first day of last month';
$dt=date_create($datestring);
$list = array("BriskSurf" => $profit, "ListViral" => $listviral[9]);
$list  = array_merge($list, $lastMonthComms);
arsort($list, SORT_NUMERIC);
echo "<div class='title'>{$dt->format('F Y')} Gains</div><div class='sub'>Profits</div><table class='list'>";
foreach($list as $key => $value)
{
	if($value != 0) echo "<tr><td>{$key}</td><td>" . number_format($value, 2) . "</td></tr>";
}
echo "<tr><td><strong>Gross Profit</strong></td><td><strong>" . $gross . "</strong></td></tr></table><div class='sub'>Expenses</div><table class='list'>";
$list = array("Commissions" => $commissions, "Paypal Fees" => $paypalFees);
$list  = array_merge($list, $lastMonthExpenses);
arsort($list, SORT_NUMERIC);
foreach($list as $key => $value) echo "<tr><td>{$key}</td><td>" . number_format($value, 2) . "</td></tr>";
echo "<tr><td><strong>Expenses</strong></td><td><strong>" . $expense . "</strong></td></tr></table><div class='sub'>Net Profit: $ " . $net . "</div>";
echo "</div></div>";

//PROFITS FOR YEAR
//PROFITS FOR YEAR
//PROFITS FOR YEAR
echo "<div class='card'><div class='inner'>";
echo "<div class='title'>2015 Total Summary</div><table class='list'><tr><td>Total Gross</td><td>{$totalYearGross}</td></tr><tr><td>Total Net</td><td>{$totalYearNet}</tr></table>";
echo "</div></div>";

//PROFITS FROM BEGINNING
//PROFITS FROM BEGINNING
//PROFITS FROM BEGINNING
echo "<div class='card'><div class='inner'>";
echo "<div class='title'>From the Dawn of Time</div><table class='list'><tr><td>Total Gross</td><td>{$totalGross}</td></tr><tr><td>Total Net</td><td>{$totalNet}</tr></table>";
echo "</div></div>";
?>