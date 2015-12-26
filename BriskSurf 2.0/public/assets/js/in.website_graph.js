google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(init_graph);

function init_graph() {
	var data = new google.visualization.DataTable();
	data.addColumn('string', 'Date');
	data.addColumn('number', 'Views');

	data.addRows(points);

	var options = {
		height: 300,
   			chartArea: {width: '90%', 'height': '75%'},
		legend: { position: "none" },
		backgroundColor: '#f9fafb',
		isStacked: false,
		focusTarget: 'category',
	};

	var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart'));
	chart.draw(data, options);

	data = new google.visualization.DataTable();
	data.addColumn('string', 'Date');
	data.addColumn('number', 'Rating');

	data.addRows(points2);


	var chart2 = new google.visualization.SteppedAreaChart(document.getElementById('chart2'));
	chart2.draw(data, options);

}