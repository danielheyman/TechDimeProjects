<?php 
include 'profit.php'; 
include 'cleanConfig.php';

$datestring= 'first day of last month';
$dt=date_create($datestring);
$dt = $dt->format('F Y');

if($lastUpdate != $dt)
{
	$lastMonthComms = $comms;
	$lastMonthExpenses = $expenses;
	$lastMonthFeesTotal = $feesTotal;
	$lastMonthCommsTotal = $commsTotal;
}

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
$commissions = round($commissions + $listviral[7], 2);
$paypalFees = round($loss + $listviral[10] + $massPayFees + $listviral[8], 2);
$gross = round($profit + $listviral[9] + $lastMonthCommsTotal, 2);
if($lastUpdate != $dt) $totalGross = $totalGross + $gross;
if($lastUpdate != $dt) $totalYearGross = $totalYearGross + $gross;
$expense = round($commissions + $paypalFees + $lastMonthFeesTotal, 2);
$net = round($profit + $listviral[9] + $lastMonthCommsTotal - $commissions - $paypalFees - $lastMonthFeesTotal, 2);
if($lastUpdate != $dt) $totalNet = $totalNet + $net;
if($lastUpdate != $dt) $totalYearNet = $totalYearNet + $net;
$profit = round($profit, 2);

$list = array("BriskSurf" => $profit, "ListViral" => $listviral[9]);
$list  = array_merge($list, $lastMonthComms);
arsort($list, SORT_NUMERIC);
echo "<strong>{$dt} Summary</strong><br><br>Profits:<br>";
foreach($list as $key => $value)
{
	if($value != 0) echo "+ {$key}: " . number_format($value, 2) . "<br>";
}
echo "= Gross Profit: " . number_format($gross,2) . "<br><br>Expenses:<br>";
$list = array("Commissions" => $commissions, "Paypal Fees" => $paypalFees);
$list2 = array();
foreach($lastMonthExpenses["TechDime"] as $cat)
{
	foreach($cat as $key => $value) $list2[$key] = $value;
}
$list  = array_merge($list, $list2);
arsort($list, SORT_NUMERIC);
foreach($list as $key => $value) echo "+ {$key}: " . number_format($value, 2) . "<br>";
echo "= Expenses: " . number_format($expense,2) . "<br><br>Net Profit: " .number_format($net,2) . "<br><br>";


//PROFITS FOR YEAR
//PROFITS FOR YEAR
//PROFITS FOR YEAR
$totalYearGross = number_format($totalYearGross, 2);
$totalYearNet = number_format($totalYearNet, 2);
echo "2014 Total Summary:<br>Total Gross: {$totalYearGross}<br>Total Net: {$totalYearNet}<br><br>";

//PROFITS FROM BEGINNING
//PROFITS FROM BEGINNING
//PROFITS FROM BEGINNING
$totalGross = number_format($totalGross, 2);
$totalNet = number_format($totalNet, 2);
echo "From the Dawn of Time:<br>Total Gross: {$totalGross}<br>Total Net: {$totalNet}<br><br><hr><br><br>";


echo "<strong>{$dt} Summary<br><br>Part I:</strong><br>";

echo "1 (Gross receipts or sales): $" . number_format($gross, 2) . "<br>";
echo "3 (#1 - #2): $" . number_format($gross, 2) . "<br>";
echo "5 (Gross profit): $" . number_format($gross, 2) . "<br>";
echo "7 (Gross income): $" . number_format($gross, 2);


$lastMonthExpenses["TechDime"]["Commissions & Fees"]["Commissions"] = $commissions;
$lastMonthExpenses["TechDime"]["Commissions & Fees"]["Paypal Fees"] = $paypalFees;

$add = function ($type, $value) use ($lastMonthExpenses)
{
	if(isset($lastMonthExpenses["TechDime"][$value])) $techdime = $lastMonthExpenses["TechDime"][$value];
	if(isset($lastMonthExpenses["Work"][$value])) $work = $lastMonthExpenses["Work"][$value];

	$total = 0;
	if(isset($techdime)) foreach($techdime as $value) $total+= $value;
	if(isset($work)) foreach($work as $value) $total+= $value;

	if($total != 0)
	{

		echo "{$type}<br>";

		if(isset($techdime)) foreach($techdime as $key => $value) echo "+ {$key}: $" . number_format($value, 2) . "<br>";
		if(isset($work)) foreach($work as $key => $value) echo "+ {$key}: $" . number_format($value, 2) . "<br>";
		echo "= Total: $" . number_format($total, 2) . "<br><br>";
	}
};

echo "<br><br><strong>Part II:</strong><br><br>";

$add("8 (Advertising):", "Advertising");
$add("10 (Commissions and fees):", "Commissions & Fees");
$add("18 (Office expense):", "Office Expense");
$add("25 (Utilities):", "Utilities");
$add("27 (other expenses):", "Web Hosting");
$add("27 (other expenses):", "Web Design");

echo "<strong>Part III:</strong><br><br>";

foreach($lastMonthExpenses["Work"] as $cat)
{
	foreach($cat as $value) $expense += $value;
}
echo"28 (Total expenses): $" . number_format($expense, 2) . "<br>";
echo "29 (Tentative profit or loss): $" . number_format($gross - $expense, 2) . "<br>";
echo "31 (Net profit or loss): $" . number_format($gross - $expense, 2) . "<br>";




echo "<br><br><br>";

