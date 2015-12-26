$("#selection").change(function() {
	init();
});

$(".checkbox input").click(function() {
	init();
});

google.setOnLoadCallback(init);

function init() {
	var type = $("#selection").val();
	var labels = [];
	var points = [];

	$("input[type=checkbox]:checked").each(function() {
		labels.push($(this).attr('name'));

		var current_points = window[type + "_" + $(this).attr('name')];
		var position = 0;

		for(var i in current_points)
		{
			if(points.length != current_points.length) points.push(current_points[i].slice(0))
			else points[position].push(current_points[i][1]);
			position++;
		}
	});

	drawChart(labels, points);
}