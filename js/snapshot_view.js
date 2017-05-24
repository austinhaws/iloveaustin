$(function() {
	$('#cancel-button').click(function(e) {
		window.location = globals.base_url + 'budget/budget/' + globals.month + '/' + globals.year;
		e.preventDefault();
	});

	$('#submit-button').click(function(e) {
		$('#snapshot-form').submit();
		e.preventDefault();
	});
});
