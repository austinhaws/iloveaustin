$(function() {
	$('#cancel-button').click(function(e) {
		window.location = globals.base_url + 'savings';
		e.preventDefault();
	});

	$('#submit-button').click(function(e) {
		$('#saving-form').submit();
		e.preventDefault();
	});
});
