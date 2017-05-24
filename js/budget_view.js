$(function() {
	$('#weeks_remaining').keyup(function(e) {
		update_weeks_remaining();
	});

	$('.delete-snapshot').click(function(e) {
		window.location = globals.base_url + 'budget/delete_snapshot/' + $(this).closest('tr').attr('snapshot_id');
	});

	$('.delete-monthly').click(function(e) {
		window.location = globals.base_url + 'budget/delete_monthly/' + $(this).closest('tr').attr('monthly_id');
	});

	update_weeks_remaining();
});

function update_weeks_remaining() {
	var weeks = parseFloat($('#weeks_remaining').val(), 10);
	if (!weeks) {
		weeks = 0;
	}

	if (globals.last_weeks != weeks) {
		globals.last_weeks = weeks;
		var left = (globals.food_amt_goal - globals.food_amt_spent) / 100.0;
		var per_week = (weeks == 0 ? left : left / weeks);
		$('#weeks_remaining_output').html("$" + per_week.toFixed(2));

		get_post_data('account_service/setWeeksRemaining', {weeks:weeks}, false);
	}
}
