function city_layout(options) {
	var data = $.extend(
		{
			container : false // the jquery canvas
			, height: 100 // the height of the canvas
			, width: 100 // width of the canvas
			, city : false // the city rendered
			, cells : [] // the raphael cells of the city
		}
		, options
	);
	globals.ward_lookup = {}; // key = ward_id, value = ward // made global so external functions can use it (HACK!!!)

	if (data.container) {
		// show the cells
		var cell;
		var output = '';
		var layout_size = data.city.layout.width * data.city.layout.height;
		var ward_id;

		// give wards a letter and set up a ward_id_index for easier lookup
		$.each(data.city.wards, function(idx, ward) {
			globals.ward_lookup[ward.id] = ward;
		});
		// add a letter for the outskirt wards
		globals.ward_lookup[-1] = {letter:'-'};
		// add non-wards letters
		for (var i = 0; i < layout_size; i++) {
			ward_id = data.city.layout.cells[i].ward_id;
			if (!globals.ward_lookup[ward_id]) {
				globals.ward_lookup[ward_id] = {
					letter:'&nbsp;'
					, id:ward_id
				}; // add the letter for the ward for later use
			}
		}
		var ward_lookup_count = 0;
		var location;
		var ratio;
		// count wards and give each ward an idx/location for the ratio
		$.each(globals.ward_lookup, function(ward_id, ward) {
			ward.location = ward_lookup_count++;
		});
		$.each(globals.ward_lookup, function(ward_id, ward) {
			location = ward.location;
			// get the ratio of hue
			ratio = location / ward_lookup_count; // ratio of 360
		});



		// output ascii for the wards
		var cell;
		for (var i = 0; i < layout_size; i++) {
			cell = data.city.layout.cells[i];
			// start a row
			if (i && i % data.city.layout.width == 0) {
				output += '<div class="layout-row">';
			}
			// show letters for wards
			ward_id = cell.ward_id;
			if (ward_id === false) {
				ward_id = -1;
			}
			var ward_lookup = globals.ward_lookup[ward_id];
			var letter = ward_lookup.id_letter;
			if (!ward_lookup.show_ward_list) {
				letter = '&nbsp;';
			}
			var walls_id = 0;
			if (cell.walls.top) {
				walls_id += 1;
			}
			if (cell.walls.bottom) {
				walls_id += 2;
			}
			if (cell.walls.right) {
				walls_id += 4;
			}
			if (cell.walls.left) {
				walls_id += 8;
			}
			output += '<div class="layout-cell" data-letter="' + ward_lookup.letter + '" data-ward-id="' + ward_id + '">' +
				'<img src="images/walls.png" class="cell-' + walls_id + '" />' +
				letter +
				'</div>';

			// close the row
			if ((i + 1) % data.city.layout.width == 0) {
				output += '</div>';
			}
		}
		// show the layout
		data.container.html(output);

		// set up hover for the wards
		data.container.find('.layout-cell')
			.hover(function() {
				show_layout_ward($(this).data('ward-id'));
			}, function () {
				// on out hover, remove all selecteds
				show_layout_ward(false);
			})
			.click(function() {
				var ward_id = $(this).data('ward-id');
				globals.sticky_layout_ward_id = ward_id;
				show_layout_ward(ward_id);
			});

	}
}

// ward_id: the ward_id with which to interact
// hovered: (bool) true = show in black being hovered; false = show in original color not being hovered
function show_layout_ward(ward_id) {
	// hide previous if there is one
	var ward = globals.ward_lookup[ward_id];

	if (globals.last_show_layout_ward_id || globals.sticky_layout_ward_id) {
		$('[data-ward-id]').removeClass('hover');
		$('#layout-container-detail').hide();
	}

	if (ward.show_ward_list) {
		// show the new ward
		var ward_lookup = globals.ward_lookup[ward_id];
		if (ward_lookup.show_ward_list) {
			globals.last_show_layout_ward_id = ward_id;
			$('#layout-container-container').show();
			$('[data-ward-id="' + ward_id + '"]').addClass('hover');
			show_ward_detail(ward_id);
		}
	} else {
		var ward_lookup = globals.ward_lookup[globals.sticky_layout_ward_id];
		if (ward_lookup.show_ward_list) {
			$('#layout-container-container').show();
			$('[data-ward-id="' + ward_lookup.id + '"]').addClass('hover');
			show_ward_detail(ward_lookup.id);
		}
	}
}

function show_ward_detail(ward_id) {
	for (var i = 0; i < globals.city.wards.length; i++) {
		if (globals.city.wards[i].id == ward_id) {
			if (globals.city.wards[i].show_ward_list) {
				globals.templates.render($('#layout-container-detail'), 'city-ward-detail', globals.city.wards[i], 'html');
				$('#layout-container-detail').show();
			}
			break;
		}
	}
}
