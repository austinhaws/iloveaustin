$(function() {
	$('#logout_button').click(function() {
		post_to_url(globals.base_url + 'login/logoutUser', {
		});
	});
});
