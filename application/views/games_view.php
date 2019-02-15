<script src="https://www.google.com/jsapi"></script>
<script src="<?php echo base_url()?>js/games_view.js"></script>
<link href="<?php echo base_url()?>css/games_view.less" rel="stylesheet/less" type="text/css" media="screen" />

<script>
	globals.games = <?php echo $games?>;
</script>

<div class="games-container">
	<table class="games-table">
		<tr>
			<td class="title">Child Games:</td>
			<td class="data"><input type="checkbox" id="child-only" /></td>
		</tr>
		<tr>
			<td class="title">Children Can Play:</td> <!-- auto check this and diable if child games slected -->
			<td class="data"><input type="checkbox" id="child-can-play" /></td>
		</tr>
		<tr>
			<td class="title">Jenni Will Play:</td>
			<td class="data"><input type="checkbox" id="spouse-will-play" checked="checked" /></td>
		</tr>
		<tr>
			<td class="title"># Players:</td>
			<td class="data"><input type="input" id="number-players" size="2" value="2" /> <a href="#" class="fakebutton small" id="button-random">Random Game</a></td>
		</tr>
	</table>

	<hr class="games-divider" />

	<table class="games-table">
		<tr>
			<td class="title">Game:</td>
			<td class="data"><select id="games-list" /></td>
		</tr>
		<tr>
			<td class="title">Winner:</td>
			<td class="data"><input type="input" id="winner" /></td>
		</tr>
		<tr>
			<td class="title" colspan="100">
				<a href="#" class="fakebutton small" id="record-play">Record Play</a>
			</td>
		</tr>
	</table>
</div>
