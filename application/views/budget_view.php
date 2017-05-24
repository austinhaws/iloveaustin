<script>
	globals.has_next = <?=$has_next ? 'true' : 'false'?>;
	globals.next_period = '<?=$next_period['combined']?>';
	globals.prev_period = '<?=$last_period['combined']?>';
	globals.food_amt_goal = 0;
	globals.food_amt_spent = 0;
	globals.last_weeks = <?=$account->weeks_remaining?>;
</script>
<script src="<?=base_url()?>js/budget_view.js"></script>

<link href="<?=base_url()?>css/budget_view.less" rel="stylesheet/less" type="text/css" media="screen" />


	<div class="budget_title">
		<div class="title-container">
			<a href="<?=base_url()?>budget/budget/<?=$last_period['month']?>/<?=$last_period['year']?>"><img src="<?=base_url()?>images/arrow_left.png" /></a>
			<div class="title"><?=$period['combined']?></div>
			<a href="<?=base_url()?>budget/budget/<?=$next_period['month']?>/<?=$next_period['year']?>"><img src="<?=base_url()?>images/arrow_right.png" /></a>
		</div>
		<? if ($period['combined'] != $current_period['combined']) { ?>
			<div class="goto-current"><a href="<?=base_url()?>budget/budget/<?=$current_period['month']?>/<?=$current_period['year']?>">Go To Current Month</a></div>
		<? } ?>
	</div>

	<br />

	<div class="fargo-balance">Wells Fargo Balance = <?=format_currency($snapshots_totals['amt_current'] + $monthly_totals['amt_goal'])?></div>

	<br />

<div class="add-link"><a href="<?=base_url()?>monthly/add/<?=$period['month']?>/<?=$period['year']?>">Add New Monthly</a></div>
<?	if (!$monthlies) {	?>
	<div class="no-items-message">No Monthlies. Click "Add New Monthly" to get started.</div>
<?	} else {	?>
	<table class="table_center table_padding">
		<thead>
			<tr>
				<th class="border_bottom">Name</th>
				<th class="border_bottom">Goal</th>
				<th class="border_bottom">Spent</th>
				<th class="border_bottom">Left</th>
				<th class="border_bottom">Weeks<br />Remaining</th>
				<th class="border_bottom">Weekly<br />Allotment</th>
				<th />
			</tr>
		</thead>
		<tbody>
		<?	foreach ($monthlies as $monthly) {	?>
			<tr monthly_id="<?=$monthly->id?>">
				<td><a href="<?=base_url()?>monthly/edit/<?=$monthly->id?>"><?=$monthly->name?></a></td>
				<td class="align-right"><?=format_currency($monthly->amt_goal)?></td>
				<td class="align-right"><?=format_currency($monthly->amt_spent)?></td>
				<td class="align-right"><?=format_currency($monthly->amt_goal - $monthly->amt_spent)?></td>
				<? if (strtolower($monthly->name) == 'food') {	?>
					<script>
						globals.food_amt_goal = <?=$monthly->amt_goal?>;
						globals.food_amt_spent = <?=$monthly->amt_spent?>;
					</script>
					<td class="align-center"><input type="text" size="2" id="weeks_remaining" value="<?=$account->weeks_remaining?>" /></td>
					<td class="align-right"><span id="weeks_remaining_output" /></td>
				<?	} else {	?>
					<td /><td />
				<?	}	?>
				<td>
					<img class="delete-monthly delete-link" title="Delete" alt="Delete" src="<?=base_url()?>images/x.png" />
				</td>
			</tr>
		<?	}	?>
		</tbody>
		<tfoot>
			<tr>
				<td class="bold border_top right">Totals:</td>
				<td class="bold border_top right"><?=format_currency($monthly_totals['amt_goal'])?></td>
				<td class="bold border_top right"><?=format_currency($monthly_totals['amt_spent'])?></td>
				<td class="bold border_top right"><?=format_currency($monthly_totals['amt_left'])?></td>
			</tr>
		</tfoot>
	</table>
	<br />
<?	}	?>


<br />
	<div class="budget_title"><span class="title">Snapshots</span></div>
	<br />

<div class="add-link"><a href="<?=base_url()?>snapshot/add/<?=$period['month']?>/<?=$period['year']?>">Add New Snapshot</a></div>

	<br />
<?	if (!$snapshots) {	?>
	<div class="no-items-message">No Snapshots. Click "Add New Snapshot" to get started.</div>
<?	} else {	?>
	<table class="table_center table_padding">
		<thead>
			<tr>
				<th class="border_bottom">Name</th>
				<th class="border_bottom">Goal</th>
				<th class="border_bottom">Current</th>
				<th />
			</tr>
		</thead>
		<tbody>
		<?
			foreach ($snapshots as $snapshot) {
		?>
			<tr snapshot_id="<?=$snapshot->id?>">
				<td><a href="<?=base_url()?>snapshot/edit/<?=$snapshot->id?>/<?=$period['month']?>/<?=$period['year']?>"><?=$snapshot->name?></a></td>
				<td class="<?=!$snapshot->is_totalable ? 'not-totalable' : ''?>"><?=format_currency($snapshot->amt_goal)?></td>
				<td class="<?=!$snapshot->is_totalable ? 'not-totalable' : ''?>"><?=format_currency($snapshot->amt_current)?></td>
				<td>
					<img title="Delete" alt="Delete" class="delete-snapshot delete-link" src="<?=base_url()?>images/x.png" />
				</td>
			</tr>
		<?	}	?>
		</tbody>
		<tfoot>
			<tr>
				<td class="bold border_top">Totals:</td>
				<td class="bold border_top"><?=format_currency($snapshots_totals['amt_goal'])?></td>
				<td class="bold border_top"><?=format_currency($snapshots_totals['amt_current'])?></td>
				<td />
			</tr>
			<tr>
				<td class="bold border_top">No Wells Fargo Totals:</td>
				<td class="bold border_top"><?=format_currency($snapshots_totals['amt_goal_not_totalable'])?></td>
				<td class="bold border_top"><?=format_currency($snapshots_totals['amt_current_not_totalable'])?></td>
				<td />
			</tr>
		</tfoot>
	</table>
	<br />
<?	}	?>
