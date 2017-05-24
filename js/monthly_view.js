$(function() {
	$('#cancel-button').click(function(e) {
		window.location = globals.base_url + 'budget';
		e.preventDefault();
	});

	$('#submit-button').click(function(e) {
		$('#monthly-form').submit();
		e.preventDefault();
	});
});
