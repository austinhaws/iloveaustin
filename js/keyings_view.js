$(function() {
	$('.delete-keying').click(function(e) {
		window.location = globals.base_url + 'keyings/delete_keying/' + $(this).closest('tr').attr('keying_id');
	});

	$('#search-clear').click(function(e) {
		// clear the filter
		$('#search-text').val('');
		apply_filter();
		e.preventDefault();
	});

	$('#search-text').keyup(function(e) {
		// do the filter
		apply_filter();
	});

	// load agents list
	var table_body = $('#agent-container table tbody');
	var agent;
	var tr;
	for (var i = 0, counti = globals.agents.length; i < counti; i++ ) {
		agent = globals.agents[i];
		tr = $('<tr class="agent-row">\
					<td class="column_agent">' + agent.claim_agent + '</a></td>\
					<td class="align-center column_rating">' + agent.rating_formatted + '</td>\
					<td class="align-right column_files">' + agent.num_files + '</td>\
					<td class="align-left column_comment">' + agent.comments + '</td>\
				</tr>\
		');
		tr.data('agent', agent);
		table_body.append(tr);
	}

	apply_filter(); // in case the page was refreshed and text was already in the input
});

function apply_filter() {
	var filter = $('#search-text').val();
	var pieces = filter.split(' ');

	for (var i = 0, counti = pieces.length; i < counti; i++) {
		pieces[i] = pieces[i].toLowerCase();
	}

	var agents = $('.agent-row');
	var agent;
	var tr;
	for (var i = 0, counti = agents.length; i < counti; i++) {
		tr = $(agents[i]);
		agent = tr.data('agent');
		var matches = true;
		for (var j = 0, countj = pieces.length; matches && j < countj; j++) {
			matches = agent.claim_agent.toLowerCase().indexOf(pieces[j]) >= 0;
		}

		if (matches) {
			tr.show();
		} else {
			tr.hide();
		}
	}
}
