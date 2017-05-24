function get_post_data(url, data, callback) {
	// add csrf protection to data
	data['csrf_ila'] = $('[name="csrf_ila"]').val(); // comes from layout_view

	$.post(
		globals.base_url + url
		, data
	).done(function(data) {
		if (callback) {
			callback(data);
		}
	});
}

function encrypt(string) {
	var salt = 'vjhuskedh!Â£)8J)03uIoO4jjde!';
	return $.rc4EncryptStr(string, salt);
}
function decrypt(string) {
	return $.rc4DecryptStr(string, 'ujhuskedh!Â£)8J)o3uIoO4jjd3!');
}

function hasWhiteSpace(s) {
	return /\s+/.test(s);
}

function strip_px(px) {
	return parseInt(px.substr(0, px.length - 2), 10);
}

function strcmp(str1, str2) {
	var str1 = str1.toLowerCase();
	var str2 = str2.toLowerCase();
	return (str1 == str2) ? 0 : ((str1 > str2) ? 1 : -1);
}

function input_enter_key(elem, callback) {
	$(elem).keypress(function(e) {
		switch(e.keyCode) {
			case 13:
				callback(elem);
			break;
		}
	});
}
