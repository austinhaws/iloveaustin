<?php
    session_start();
	require_once('global.inc');

	$city = new city_class();

	if ($_POST) {
		$_POST['wards-added'] = json_decode($_POST['wards-added']);
		if (!$_POST['wards-added']) {
			$_POST['wards-added'] = array();
		}
	} else {
		$_POST = array(
			'name' => '',
			'population_type' => 'random',
			'sea' => 'random',
			'river' => 'random',
			'military' => 'random',
			'gates' => 'random',
			'buildings' => 'on',
			'professions' => 'on',
			'race' => 'random',
			'racial_mix' => 'random',
			'wards' => array(),
			'wards-added' => array(),
		);
	}

	$city->random($_POST);
	$city->generate_map();

	function show_report_description() {
		global $use_statement;
		return '
<div id="content">
<div id="recent-posts">
	<h2>Your city has generated!</h2>
	<p>Click each section title to see its contents. Click the <a href="index.php">Homepage</a> button to generate a new city.</p>
	<div style="clear: both; height: 40px;">&nbsp;</div>' . $use_statement . '
</div>
		';
	}
	$bottom_data = 'show_report_description';
?>
<link rel="stylesheet" type="text/css" href="city_generator.css" />

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/jquery.mustache-0.2.7.js"></script>
<script src="animatedcollapse.js"></script>
<script src="js/global.js"></script>
<script src="js/mustache.js"></script>
<script src="js/jquery.quickfit.js"></script>
<script src="js/city-layout.js"></script>
<script>
	var globals = {};
	$(function(){
		// setup city data; have to do some conversions to make it mustache happy
		globals.last_show_layout_ward_id = false; // the last shown ward detail from the layout
		globals.sticky_layout_ward_id = false; // if no ward is hovered, show this ward
		globals.city = <?=json_encode($city)?>;
		$.extend(globals.city, {
			population_size_formatted: number_format_integer(globals.city.population_size)
			, acres_formatted : number_format_double(globals.city.acres)
			, population_density : number_format_double(globals.city.population_size / globals.city.acres)
			, gold_piece_limit_output : number_format_double(globals.city.gold_piece_limit_output)
			, wealth_output : number_format_double(globals.city.wealth_output)
			, king_income_output : number_format_double(globals.city.king_income_output)
			, magic_resources_output : number_format_double(globals.city.magic_resources_output)
			, wards_count : number_format_integer(globals.city.wards.length)
			, buildings_total_output : number_format_integer(globals.city.buildings_total)
			, power_centers_count : number_format_integer(globals.city.power_centers.length)
			, guilds_count : globals.city.guilds_count
			, gates : +globals.city.gates
			, power_centers_exists : globals.city.power_centers.length > 0
		});
		for (var i = globals.city.wards.length - 1; i >= 0; i--) {
			globals.city.wards[i].acres_output = number_format_double(globals.city.wards[i].acres);
			globals.city.wards[i].building_total_output = number_format_integer(globals.city.wards[i].building_total);
		}
		for (var i = globals.city.power_centers.length - 1; i >= 0; i--) {
			globals.city.power_centers[i].wealth_output = number_format_double(globals.city.power_centers[i].wealth);
			globals.city.power_centers[i].influence_points_output = number_format_integer(globals.city.power_centers[i].influence_points);
			globals.city.power_centers[i].npcs_total_output = number_format_integer(globals.city.power_centers[i].npcs_total);
		}

		// load mustache template and render data
		globals.templates = new template_loader();
		globals.templates.load_templates('templates/citygen.htm', function() {
			globals.templates.render($('#report') , 'city-detail', globals.city, 'html');

			$('.toggleable').click(handle_event(function(e) {
				var target = $($(this).data('toggle-target'));
				if (!$(this).is('.toggleable')) {
					target = $($(this).closest('.toggleable').data('toggle-target'));
				}
				console.log(target);
				$.each(target, function(idx, elem) {
					var jelem = $(elem);
					if (jelem.css('display') == 'block') {
						jelem.hide();
//						jelem.prop('orig-height', jelem.css('height'));
//						jelem.animate({height: 0}, function() {
//							jelem.hide();
//						});
					} else {
						jelem.show();
//						jelem.animate({height: jelem.prop('orig-height')});
					}
				});
			}));

			$('#hide-all').click(handle_event(function(e) {
				$.each($('.toggleable'), function(idx, elem) {
					var target = $($(elem).data('toggle-target'));
					$.each(target, function(idx, elem) {
						$(elem).hide();
					});
				});
			}));
			$('#show-all').click(handle_event(function(e) {
				$.each($('.toggleable'), function(idx, elem) {
					var target = $($(elem).data('toggle-target'));
					$.each(target, function(idx, elem) {
						$(elem).show();
					});
				});
			}));

			$('#regenerate').click(function(e) {
				$('#form_regenerate').submit();
			});
			$('#printable').click(function(e) {
				window.print();
			});
			// set up clicking letter in ward title to show ward detail
			$('.ward-letter').click(function() {
				show_layout_ward($(this).closest('.ward_type').data('ward-id'), true);
			});

			globals.city_layout = new city_layout({container:$('#layout-container'), city: globals.city});
		});
	});

</script>

<form id="form_regenerate" action="generate.php" method="post">
<?
	foreach ($_POST as $key => $value) {
		if ($key == 'wards-added' || $key == 'wards') {
		?>
			<script>
				$(function() {
					$('[name="wards-added"]').val(JSON.stringify(<?=json_encode($value)?>));
				});
			</script>
			<input type="hidden" name="<?=$key?>" value="" />
		<?
		} else {
		?>
			<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
		<?
		}
	}
?>
</form>


<?	include('template_top.inc');	?>
<div id="report"></div>
<?	include('template_bottom.inc');	?>
<script>

	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-15960643-1']);
	_gaq.push(['_setDomainName', 'strategerygames.com']);
	_gaq.push(['_setAllowLinker', true]);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();

</script>
