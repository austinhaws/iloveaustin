$(function() {
	input_enter_key($('[name="username"],[name="password"]'), login);

	$('.login_button').click(login);

	$('.create_button').click(function(e) {
		globals.model.create_user($('[name="username"]').val(), $('[name="password"]').val(), function(data) {
			if (data.success) {
				window.location = globals.base_url + 'arena';
			} else {
				alert(data.error);
			}
		});
		e.preventDefault();
	});
});

function login(e) {
	var data = {
		username: $('[name="username"]').val()
		, password: encrypt($('[name="password"]').val())
	};
	get_post_data('account_service/login', data, function(data) {
		if (data['destination']) {
			window.location = globals.base_url + data['destination'];
		} else {
			alert('Could not login. Please try again.');
		}
	});
	if (e && e.preventDefault) {
		e.preventDefault();
	}
}
