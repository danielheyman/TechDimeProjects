google.load("visualization", "1", {packages:["corechart"]});

function drawChart(labels, points, legend) {
	var data = new google.visualization.DataTable();

	data.addColumn('string', 'Date');
	for(var i in labels) data.addColumn('number', labels[i]);
	data.addRows(points);

	if(legend == null) legend = 'bottom';

	var options = {
		legend: {position: 'none'},
		height: 500,
   		chartArea: {width: '90%'},
		legend: { position: legend },
		backgroundColor: '#fff',
		isStacked: false,
		focusTarget: 'category',
	};

	var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart'));
	chart.draw(data, options);
}

$(".datetime").datetimepicker({
	format:'Y/m/d H:i',
	mask: true
});