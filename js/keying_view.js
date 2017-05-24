$(function() {
	$('#cancel-button').click(function(e) {
		window.location = globals.base_url + 'keyings';
		e.preventDefault();
	});

	$('#submit-button').click(function(e) {
		$('#keying-form').submit();
		e.preventDefault();
	});
});
