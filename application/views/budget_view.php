<script>
	globals.has_next = <?php echo $has_next ? 'true' : 'false'?>;
	globals.next_period = '<?php echo $next_period['combined']?>';
	globals.prev_period = '<?php echo $last_period['combined']?>';
	globals.food_amt_goal = 0;
	globals.food_amt_spent = 0;
	globals.last_weeks = <?php echo $account->weeks_remaining?>;
</script>
<script src="<?php echo base_url()?>js/budget_view.js"></script>

<link href="<?php echo base_url()?>css/budget_view.less" rel="stylesheet/less" type="text/css" media="screen" />


	<div class="budget_title">
		<div class="title-container">
			<a href="<?php echo base_url()?>budget/budget/<?php echo $last_period['month']?>/<?php echo $last_period['year']?>"><img src="<?php echo base_url()?>images/arrow_left.png" /></a>
			<div class="title"><?php echo $period['combined']?></div>
			<a href="<?php echo base_url()?>budget/budget/<?php echo $next_period['month']?>/<?php echo $next_period['year']?>"><img src="<?php echo base_url()?>images/arrow_right.png" /></a>
		</div>
		<?php if ($period['combined'] != $current_period['combined']) { ?>
			<div class="goto-current"><a href="<?php echo base_url()?>budget/budget/<?php echo $current_period['month']?>/<?php echo $current_period['year']?>">Go To Current Month</a></div>
		<?php } ?>
	</div>

	<br />

	<div class="fargo-balance">Wells Fargo Balance = <?php echo format_currency($snapshots_totals['amt_current'] + $monthly_totals['amt_goal'])?></div>

	<br />

<div class="add-link"><a href="<?php echo base_url()?>monthly/add/<?php echo $period['month']?>/<?php echo $period['year']?>">Add New Monthly</a></div>
<?php  	if (!$monthlies) {	?>
	<div class="no-items-message">No Monthlies. Click "Add New Monthly" to get started.</div>
<?php  	} else {	?>
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
		<?php  	foreach ($monthlies as $monthly) {	?>
			<tr monthly_id="<?php echo $monthly->id?>">
				<td><a href="<?php echo base_url()?>monthly/edit/<?php echo $monthly->id?>"><?php echo $monthly->name?></a></td>
				<td class="align-right"><?php echo format_currency($monthly->amt_goal)?></td>
				<td class="align-right"><?php echo format_currency($monthly->amt_spent)?></td>
				<td class="align-right"><?php echo format_currency($monthly->amt_goal - $monthly->amt_spent)?></td>
				<?php if (strtolower($monthly->name) == 'food') {	?>
					<script>
						globals.food_amt_goal = <?php echo $monthly->amt_goal?>;
						globals.food_amt_spent = <?php echo $monthly->amt_spent?>;
					</script>
					<td class="align-center"><input type="text" size="2" id="weeks_remaining" value="<?php echo $account->weeks_remaining?>" /></td>
					<td class="align-right"><span id="weeks_remaining_output" /></td>
				<?php  	} else {	?>
					<td /><td />
				<?php  	}	?>
				<td>
					<img class="delete-monthly delete-link" title="Delete" alt="Delete" src="<?php echo base_url()?>images/x.png" />
				</td>
			</tr>
		<?php  	}	?>
		</tbody>
		<tfoot>
			<tr>
				<td class="bold border_top right">Totals:</td>
				<td class="bold border_top right"><?php echo format_currency($monthly_totals['amt_goal'])?></td>
				<td class="bold border_top right"><?php echo format_currency($monthly_totals['amt_spent'])?></td>
				<td class="bold border_top right"><?php echo format_currency($monthly_totals['amt_left'])?></td>
			</tr>
		</tfoot>
	</table>
	<br />
<?php  	}	?>


<br />
	<div class="budget_title"><span class="title">Snapshots</span></div>
	<br />

<div class="add-link"><a href="<?php echo base_url()?>snapshot/add/<?php echo $period['month']?>/<?php echo $period['year']?>">Add New Snapshot</a></div>

	<br />
<?php  	if (!$snapshots) {	?>
	<div class="no-items-message">No Snapshots. Click "Add New Snapshot" to get started.</div>
<?php  	} else {	?>
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
		<?php
			foreach ($snapshots as $snapshot) {
		?>
			<tr snapshot_id="<?php echo $snapshot->id?>">
				<td><a href="<?php echo base_url()?>snapshot/edit/<?php echo $snapshot->id?>/<?php echo $period['month']?>/<?php echo $period['year']?>"><?php echo $snapshot->name?></a></td>
				<td class="<?php echo !$snapshot->is_totalable ? 'not-totalable' : ''?>"><?php echo format_currency($snapshot->amt_goal)?></td>
				<td class="<?php echo !$snapshot->is_totalable ? 'not-totalable' : ''?>"><?php echo format_currency($snapshot->amt_current)?></td>
				<td>
					<img title="Delete" alt="Delete" class="delete-snapshot delete-link" src="<?php echo base_url()?>images/x.png" />
				</td>
			</tr>
		<?php  	}	?>
		</tbody>
		<tfoot>
			<tr>
				<td class="bold border_top">Totals:</td>
				<td class="bold border_top"><?php echo format_currency($snapshots_totals['amt_goal'])?></td>
				<td class="bold border_top"><?php echo format_currency($snapshots_totals['amt_current'])?></td>
				<td />
			</tr>
			<tr>
				<td class="bold border_top">No Wells Fargo Totals:</td>
				<td class="bold border_top"><?php echo format_currency($snapshots_totals['amt_goal_not_totalable'])?></td>
				<td class="bold border_top"><?php echo format_currency($snapshots_totals['amt_current_not_totalable'])?></td>
				<td />
			</tr>
		</tfoot>
	</table>
	<br />
<?php  	}	?>
