$(function() {
	// load games menu
	var select = $('#games-list');
	$.each(globals.games, function(idx, game) {
		select.append('<option value="' + game.id + '">' + game.name + '</option>');
	});

	// hook up child games checkbox
	$('#child-only').click(function(e) {
		var child_can_play = $('#child-can-play');

		if ($(this).prop('checked')) {
			child_can_play.prop('disabled', 'disabled');
			child_can_play.prop('checked', 'checked');
		} else {
			child_can_play.removeProp('disabled');
		}
	});

	// hookup randomize button
	$('#button-random').click(function(e) {
		e.preventDefault();

		randomize();
	});

	// hookup game play saving
	$('#record-play').click(function(e) {
		e.preventDefault();

		get_post_data('games/played', {game_id:$('#games-list').val(), winner:$('#winner').val()}, function(data) {
			alert('Saved');
			$('#winner').val('');
		});
	});

	// randomize!
	randomize();
});


function randomize() {
	var true_string = '1';
	var false_string = '0';
	var child_game = $('#child-only').prop('checked') ? true_string : false_string;
	var child_can_play = $('#child-can-play').prop('checked') ? true_string : false_string;
	var spouse_will_play = $('#spouse-will-play').prop('checked') ? true_string : false_string;
	var num_players = +$('#number-players').val(); // convert to number

	function game_matches(game) {
		return child_can_play == game.children_can_play
			&& child_game == game.children_only
			&& spouse_will_play == game.spouse_will_play
			&& num_players <= game.players_max
			&& num_players >= game.players_min;
	}

	// find what game has been played the most
	var plays_max = 0;
	$.each(globals.games, function(idx, game) {
		if (game_matches(game)) {
			plays_max = Math.max(plays_max, game.plays);
		}
	});
	// load games and give weight based on plays_max - num_plays
	var matches = [];
	var i;
	var count, total = 0;
	$.each(globals.games, function(idx, game) {
		if (game_matches(game)) {
			count = plays_max - game.plays + 1;
			matches.push({idx:idx, count:count});
			total += count;
		}
	});

	// shuffle
	var selected = Math.floor(Math.random() * (total + 1));
	var i = 0;
	do {
		selected -= matches[i++].count;
	} while (selected > 0);

	// pick the first game in the list
	var game = globals.games[matches[i - 1].idx];

	$('#games-list').val(game.id);
}

function fisherYates ( myArray ) {
	var i = myArray.length, j, tempi, tempj;
	if ( i == 0 ) {
		return false;
	}
	while ( --i ) {
		j = Math.floor( Math.random() * ( i + 1 ) );
		tempi = myArray[i];
		tempj = myArray[j];
		myArray[i] = tempj;
		myArray[j] = tempi;
	}
}
