<?php
	require_once('global.inc');

	include 'template_top.inc';
?>


<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/vendor/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<script src="js/index.js"></script>
<script src="js/global.js"></script>
<script src="js/mustache.js"></script>
<script src="js/jquery.mustache-0.2.7.js"></script>
<script src="js/vendor/select2-3.5.2/select2.min.js"></script>
<link href="js/vendor/select2-3.5.2/select2.css" rel="stylesheet" type="text/css" />
<link href="js/vendor/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="city_generator.css" />
<script>

	var globals = {};

	globals.wards = <?=json_encode($table_buildings)?>;
	globals.wards_list = ['<?=kWard_Administration?>'
						, '<?=kWard_Craftsmen?>'
						, '<?=kWard_Gate?>'
						, '<?=kWard_Market?>'
						, '<?=kWard_Merchant?>'
						, '<?=kWard_Military?>'
						, '<?=kWard_Oderiforous?>'
						, '<?=kWard_Patriciate?>'
						, '<?=kWard_River?>'
						, '<?=kWard_Sea?>'
						, '<?=kWard_Shanty?>'
						, '<?=kWard_Slum?>'];
	globals.wards_mustache = [];
	globals.templates = new template_loader();

	$(function(){
		var select2s = $('.select2');
		select2s.filter('.hand-entered').select2({
			tags: true
			, maximumSelectionSize: 1
			//Allow manually entered text in drop down.
			, createSearchChoice: function (term, data) {
				if ($(data).filter(function () {
						return this.text.localeCompare(term) === 0;
					}).length === 0) {
					return {id: term, text: term};
				}
			}
			, data: [
				{id: '<?php echo kRandom; ?>', text:'Random'}
				, {id: '<?php echo kPopulationType_Thorp; ?>', text:'Thorp (20-80)'}
				, {id: '<?php echo kPopulationType_Hamlet; ?>', text:'Hamlet (81-400)'}
				, {id: '<?php echo kPopulationType_Village; ?>', text:'Village (401-900)'}
				, {id: '<?php echo kPopulationType_SmallTown; ?>', text:'Small Town (901-2000)'}
				, {id: '<?php echo kPopulationType_LargeTown; ?>', text:'Large Town (2001-5000)'}
				, {id: '<?php echo kPopulationType_SmallCity; ?>', text:'Small City (5001-12000)'}
				, {id: '<?php echo kPopulationType_LargeCity; ?>', text:'Large City (12001-32000)'}
				, {id: '<?php echo kPopulationType_Metropolis; ?>', text:'Metropolis (32001+)'}
			]
		});

		select2s.not('.hand-entered').select2({
			minimumResultsForSearch: -1
		});
	});

</script>

<div class="center">
	<br />
	<form method="POST" action="generate.php" id="generate-form">
		<input type="hidden" name="wards-added" />
		<table class="table_center" id="options-table">
			<thead />
			<tbody>
				<tr>
					<td class="field_title">Name:</td>
					<td class="input"><input type="input" name="name" value="" /></td>
				</tr>
				<tr>
					<td class="field_title">Population:</td>
					<td class="input">
						<input name="population_type" class="select2 hand-entered" />
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="center italic">(You can enter any population size you want. The generator was designed for a maximum population of 90000. The higher above this you go the slower it will be. Make sure to press enter after typing the number for it to stick.)</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="field_title">By the Sea:</td>
					<td class="input">
						<input type="Radio" name="sea" value="1">Yes</input>
						<input type="Radio" name="sea" value="0">No</input>
						<input type="Radio" name="sea" value=<?php echo kRandom; ?> checked="checked">Random</input>
					</td>
				</tr>
				<tr>
					<td class="field_title">By a River:</td>
					<td class="input">
						<input type="Radio" name="river" value="1">Yes</input>
						<input type="Radio" name="river" value="0">No</input>
						<input type="Radio" name="river" value=<?php echo kRandom; ?> checked="checked">Random</input>
					</td>
				</tr>
				<tr>
					<td class="field_title">Has Military:</td>
					<td class="input">
						<input type="Radio" name="military" value="1">Yes</input>
						<input type="Radio" name="military" value="0">No</input>
						<input type="Radio" name="military" value=<?php echo kRandom; ?> checked="checked">Random</input>
					</td>
				</tr>
				<tr>
					<td class="field_title">Number of Gates</td>
					<td class="input" valign="top">
						<select name="gates" class="select2">
							<option value=<?php echo kRandom; ?> selected="selected">Random</option>
							<option>--------------------</option>
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="center italic">(At least one gate means city has walls)</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td
				</tr>
				<tr>
					<td class="field_title">Generate Buildings</td>
					<td class="input"><input type="checkbox" name="buildings" checked="checked" /></td>
				</tr>
				<tr class="wards-defining">
					<td class="field_title">Add Ward:</td>
					<td class="input">
						<select name="ward-list" class="select2">
							<option value=<?=kRandom?> selected="selected">Random</option>
							<option value="">--------------------</option>
							<option value="<?=kWard_Administration?>"><?=kWard_Administration?></option>
							<option value="<?=kWard_Craftsmen?>"><?=kWard_Craftsmen?></option>
							<option value="<?=kWard_Gate?>"><?=kWard_Gate?></option>
							<option value="<?=kWard_Market?>"><?=kWard_Market?></option>
							<option value="<?=kWard_Merchant?>"><?=kWard_Merchant?></option>
							<option value="<?=kWard_Military?>"><?=kWard_Military?></option>
							<option value="<?=kWard_Oderiforous?>"><?=kWard_Oderiforous?></option>
							<option value="<?=kWard_Patriciate?>"><?=kWard_Patriciate?></option>
							<option value="<?=kWard_River?>"><?=kWard_River?></option>
							<option value="<?=kWard_Sea?>"><?=kWard_Sea?></option>
							<option value="<?=kWard_Shanty?>"><?=kWard_Shanty?></option>
							<option value="<?=kWard_Slum?>"><?=kWard_Slum?></option>
						</select> <input type="button" value="Add Ward" class="sub-button" id="add-ward-button" />
					</td>
				</tr>
				<tr>
					<td class="field_title">Generate Professions</td>
					<td class="input"><input type="checkbox" name="professions" checked="checked" /></td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="field_title">Society Type</td>
					<td class="input">
						<select name="racial_mix" class="select2">
							<option value=<?php echo kRandom; ?> selected="selected">Random</option>
							<option>--------------------</option>
							<option value="<?php echo kIntegration_Isolated;?>"><?php echo kIntegration_Isolated;?></option>
							<option value="<?php echo kIntegration_Mixed;?>"><?php echo kIntegration_Mixed;?></option>
							<option value="<?php echo kIntegration_Integrated;?>"><?php echo kIntegration_Integrated;?></option>
							<option value="<?php echo kIntegration_Custom;?>"><?php echo kIntegration_Custom;?></option>
						</select>
					</td>
				</tr>
				<tr id="race-row">
					<td class="field_title">Major Race</td>
					<td class="input">
						<select name="race" class="select2">
							<option value=<?php echo kRandom; ?> selected="selected">Random</option>
							<option>--------------------</option>
							<option value="<?php echo kRace_Human;?>"><?php echo kRace_Human;?></option>
							<option value="<?php echo kRace_Halfling;?>"><?php echo kRace_Halfling;?></option>
							<option value="<?php echo kRace_Elf;?>"><?php echo kRace_Elf;?></option>
							<option value="<?php echo kRace_Dwarf;?>"><?php echo kRace_Dwarf;?></option>
							<option value="<?php echo kRace_Gnome;?>"><?php echo kRace_Gnome;?></option>
							<option value="<?php echo kRace_HalfElf;?>"><?php echo kRace_HalfElf;?></option>
							<option value="<?php echo kRace_HalfOrc;?>"><?php echo kRace_HalfOrc;?></option>
							<option value="<?php echo kRace_Other;?>"><?php echo kRace_Other;?></option>
						</select>
					</td>
				</tr>
				<tr id="race-ratio-row">
					<td class="field_title">Race Proportions</td>
					<td class="input">
						<ul>
							<li><?php echo kRace_Human?> <div class="<?php echo kRace_Human?> slider"></div></li>
							<li><?php echo kRace_Halfling?> <div class="<?php echo kRace_Halfling?> slider"></div></li>
							<li><?php echo kRace_Elf?> <div class="<?php echo kRace_Elf?> slider"></div></li>
							<li><?php echo kRace_Dwarf?> <div class="<?php echo kRace_Dwarf?> slider"></div></li>
							<li><?php echo kRace_Gnome?> <div class="<?php echo kRace_Gnome?> slider"></div></li>
							<li><?php echo kRace_HalfElf?> <div class="<?php echo kRace_HalfElf?> slider"></div></li>
							<li><?php echo kRace_HalfOrc?> <div class="<?php echo kRace_HalfOrc?> slider"></div></li>
							<li><?php echo kRace_Other?> <div class="<?php echo kRace_Other?> slider"></div></li>
						</ul>
						<input type="hidden" name="raceRatio" value=""/>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td class="center" colspan="100"><input type="button" id="generate-button" value="Generate" /></td>
				</tr>
			</tbody>
		</table>
	</form>
</div>
<?php
	function show_index_description() {
		global $use_statement;
		return '
<div id="content">
<div id="recent-posts">
	<h2>Explanation</h2><br />
			<h3>The RPG City Generator takes a number of inputs and returns detailed, randomly generated, information about a city. It includes  professions, medieval buildings, guilds, local hero classes and levels, and many other role playing tools to make your campaign worlds more believable. Your fantasy adventures just got more detailed and exciting for your players with information about each city\'s wards, establishments, imports and exports, income, and lots more to make your role playing game full of rich detail for your players to enjoy. Here is a description of the settings involved.</h3>
			<p class="byline">	</p>
			<table class="table_center">
				<thead />
				<tbody>
					<tr>
						<td class="right field_title2">Name:</td>
						<td class="explanation">The city\'s name. If this field is blank, then a name will be randomly generated for the city. The generated name will be translated to the majority race language.</td>
					</tr>
					<tr>
						<td class="right field_title2">Population:</td>
						<td class="explanation">The number of people in the city. This is the base determiner for most all the stats, so choose wisely.</td>
					</tr>
					<tr>
						<td class="right field_title2">By the Sea:</td>
						<td class="explanation">Does this city exist by the sea or ocean? If so, then one or more "Sea" ward(s) will be added to the city.</td>
					</tr>
					<tr>
						<td class="right field_title2">By a River:</td>
						<td class="explanation">Does this city exist by a river? Or maybe one or more rivers flow through the city?</td>
					</tr>
					<tr>
						<td class="right field_title2">Has Military:</td>
						<td class="explanation">Does this city have a military stationed in it? Not even the biggest cities always have an army. This is not the local constabulary, but a full blown army.</td>
					</tr>
					<tr>
						<td class="right field_title2">Number of Gates:</td>
						<td class="explanation">How many gates does the city have in its walls? If the city has no walls, then the number of gates is 0 and vice versa.</td>
					</tr>
					<tr>
						<td class="right field_title2">Generate Buildings:</td>
						<td class="explanation">If you don\'t want to know all the buildings in a ward and you find it extremely annoying, you can have them turned off.</td>
					</tr>
					<tr>
						<td class="right field_title2">Add Ward:</td>
						<td class="explanation">If you are generating buildings you can specify which wards and the randomness weight of the buildings in that ward instead of having them completely randomly generated. Please note that the numbers are the weight that the building will occur. If you put houses at a weight of 5 and the total of all the weights for all the buildings for the ward is 120 then houses have a 5 in 120 chance of being generated. Make the weight 0 to not allow a building to generate in that ward. The size of the city determines how many wards are normally generated. If more wards are specified than the city uses all the wards will be added which may throw off the totals. If there are less wards specified than the city needs then wards will be generated to fill the extra slots.</td>
					</tr>
					<tr>
						<td class="right field_title2">Generate Professions:</td>
						<td class="explanation">If you don\'t want to know all the professions of each and every member of the city and you find it extremely annoying, you can have them turned off. If generate professions is turned off, guilds will also not generate.</td>
					</tr>
					<tr>
						<td class="right field_title2">Major Race:</td>
						<td class="explanation">This allows selecting the predominant race of the city. Depending on the Society Type, other races have a percentage of minority for the city. The race also determines the type of name that will be randomly generated for a city (if the name isn\'t specifically given).</td>
					</tr>
					<tr>
						<td class="right field_title2">Society Type:</td>
						<td class="explanation">Depending on how remote or popular a city is, this effects the types of inhabitants found in it.</td>
					</tr>
				</tbody>
			</table>
        <br /><br />
        <div id="latest-post" class="post"  />
        <div class="thanks">Thanks to bruno71 for ward bug spotting and ideas on ward frequency.</div>
        <div class="thanks">Thanks to terrancefarrel for awesome ideas on custom wards and professions.</div>
        <div class="thanks">Thanks to karrakerchris for compelling releasing layouts.</div>
        <div class="thanks">Thanks to jmöller, owbrogers, and karrakerchris for suggesting custom entering population size.</div>
        <div class="thanks contact">Please <a href="mailto:strategerygames@gmail.com">Contact Us</a> if you have a feature you would like to see added.</div>
        <br />
	<div style="clear: both; height: 40px;">&nbsp;</div>' . $use_statement . '
</div>
</div>
		';
	}

	$bottom_data = 'show_index_description';
	include 'template_bottom.inc';
?>
<script type="text/javascript">

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
