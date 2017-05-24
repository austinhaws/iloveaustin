// == END - do not put this in jquery onload ==
google.load('visualization', '1.0', {'packages':['corechart']});
// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawCharts);
// == BEGIN - do not put this in jquery onload ==

$(function() {

});

function selectHandler(chart_obj) {
	var selection = chart_obj.chart.getSelection();
	var url = chart_obj.data[selection[0]['row']].url;
	window.location = globals.base_url + 'graphs/monthly/' + url;
}


// Callback that creates and populates a data table,
// instantiates the pie chart, passes in the data and
// draws it.
function drawCharts() {
	var chart_container = $('#charts-container');
	var chart_size = {x: '700px', y: '466px'};

	function draw_chart(chart_obj) {
		// create chart holder
		chart_container.append('<div id="' + chart_obj.div_id + '" class="chart_div" style="width: ' + chart_size.x + '; height: ' + chart_size.y + ';"></div>');

		// setup chart data table
		chart_obj.data_table = new google.visualization.DataTable();
		chart_obj.data_table.addColumn('string', chart_obj.column_1);
		chart_obj.data_table.addColumn('number', chart_obj.column_2);

		var data = [];
		for (var i = 0; i < chart_obj.data.length; i++) {
			data[data.length] = [chart_obj.data[i]['name'], chart_obj.data[i]['amount']];
		}
		chart_obj.data_table.addRows(data);

		// create google chart
		chart_obj.chart = new google.visualization.PieChart($('#' + chart_obj.div_id)[0])

		// draw the chart
		chart_obj.chart.draw(chart_obj.data_table, chart_obj.options);

		google.visualization.events.addListener(chart_obj.chart, 'select', function() {
			selectHandler(chart_obj);
		});
	}

	// Instantiate charts
	// - monthly goals
	globals.charts.monthly_goals = {
		chart: false
		, div_id: 'chart_monthly_goals'
		, data: globals.monthlies.monthly_goals
		, options: {
			'title':'Month\'s Goals'
			, 'width':chart_size.x
			, 'height':chart_size.y
		}
		, column_1: 'Fund'
		, column_2: 'Amount'
	}

	// - monthly spent
	globals.charts.monthly_spent = {
		chart: false
		, div_id: 'chart_monthly_spent'
		, data: globals.monthlies.monthly_spent
		, options: {
			'title':'Spent This Month'
			, 'width':chart_size.x
			, 'height':chart_size.y
		}
		, column_1: 'Fund'
		, column_2: 'Amount'
	}

	// - monthly all - goal
	globals.charts.monthly_all_goal = {
		chart: false
		, div_id: 'chart_monthly_all_goal'
		, data: globals.monthlies.monthly_all_goal
		, options: {
			'title':'All Time\'s Goals'
			, 'width':chart_size.x
			, 'height':chart_size.y
		}
		, column_1: 'Fund'
		, column_2: 'Amount'
	}

	// - monthly all - spent
	globals.charts.monthly_all_spent = {
		chart: false
		, div_id: 'chart_monthly_all_spent'
		, data: globals.monthlies.monthly_all_spent
		, options: {
			'title':'All Time Spent'
			, 'width':chart_size.x
			, 'height':chart_size.y
		}
		, column_1: 'Fund'
		, column_2: 'Amount'
	}

	// draw charts
	for (var i in globals.charts) {
		draw_chart(globals.charts[i]);
	}
}
