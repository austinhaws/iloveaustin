$(function() {
	var bars = $('.progress-bar');
	var bar;
	for (var i = 0, counti = bars.length; i < counti; i++) {
		bar = $(bars[i]);
		bar.animate({
			width: bar.attr('target_width')
		}, {
			duration: 1000
		});
	}

	$('.delete-savings').click(function(e) {
		window.location = globals.base_url + 'savings/delete/' + $(this).closest('tr').attr('saving_id');
		e.preventDefault();
	});
});

function delete_savings(savings_id) {
	$('savings_id').value = savings_id;
	$('method').value = 'savings_delete';
	$('form').submit();
}
