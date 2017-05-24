// == BEGIN - do not put this in jquery onload ==
google.load('visualization', '1.0', {'packages':['corechart']});
// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawCharts);
// == END - do not put this in jquery onload ==

// Callback that creates and populates a data table,
// instantiates the line chart, passes in the data and
// draws it.
function drawCharts() {
	var chart_container = $('#charts-container');
	var chart_size = {x: '700px', y: '466px'};

	function draw_chart(chart_obj) {
		// create chart holder
		chart_container.append('<div id="' + chart_obj.div_id + '" class="chart_div" style="width: ' + chart_size.x + '; height: ' + chart_size.y + ';"></div>');

		// setup chart data table
		var data = [['Period', 'Goal', 'Spent']];
		for (var i = 0; i < globals.monthlies.length; i++) {
			data[data.length] = [
				globals.monthlies[i]['period']
				, globals.monthlies[i]['amt_goal']
				, globals.monthlies[i]['amt_spent']
			];
		}
		chart_obj.data_table = google.visualization.arrayToDataTable(data);

		// create google chart
		chart_obj.chart = new google.visualization.LineChart($('#' + chart_obj.div_id)[0])

		// draw the chart
		chart_obj.chart.draw(chart_obj.data_table, chart_obj.options);
	}

	// Instantiate charts
	// - monthly - goal
	globals.charts.monthly = {
		chart: false
		, div_id: 'chart_monthly_goal'
		, options: {
			'title':'All Time (' + globals.monthly_name + ')'
			, 'width':chart_size.x
			, 'height':chart_size.y
		}
	}


	// draw chart
	draw_chart(globals.charts.monthly);
}
