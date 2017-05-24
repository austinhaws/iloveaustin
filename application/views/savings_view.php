<script src="<?=base_url()?>js/savings_view.js"></script>
<link href="<?=base_url()?>css/savings_view.less" rel="stylesheet/less" type="text/css" media="screen" />

	<div class="add-link"><a href="<?=base_url()?>saving/add">Add New Savings</a></div>
<?	if (!$savings) {	?>
	<div>No Savings. Click "Add New Savings" to get started.</div>
<?	} else {	?>
	<table id="savings-table">
		<thead>
			<tr>
				<th />
				<th class="border_bottom">Name</th>
				<th class="border_bottom">Due Date</th>
				<th class="border_bottom">Goal</th>
				<th class="border_bottom">Current</th>
				<th />
			</tr>
		</thead>
		<tbody>
		<?	foreach ($savings as $saving) {	?>
			<tr saving_id="<?=$saving->id?>">
				<td>
				<?	if ($saving->amt_goal && $saving->amt_goal != '000') {	?>
					<div class="progress-container">
						<div class="progress-bar" target_width="<?=100.0 * $saving->amt_current / $saving->amt_goal?>%"></div>
					</div>
				<?	}	?>
				</td>
				<td><a href="<?=base_url()?>saving/edit/<?=$saving->id?>"><?=$saving->name?></a></td>
				<td class="align-right"><?=$saving->due_date?></td>
				<td class="align-right"><?=format_currency($saving->amt_goal)?></td>
				<td class="align-right"><?=format_currency($saving->amt_current)?></td>
				<td class="align-center">
					<img class="delete-savings delete-link" title="Delete" alt="Delete" src="<?=base_url()?>images/x.png" />
				</td>
			</tr>
		<?	}	?>
		</tbody>
		<tfoot>
			<tr>
				<td />
				<td />
				<td class="bold border_top">Totals:</td>
				<td class="bold border_top"><?=format_currency($total_goal)?></td>
				<td class="bold border_top"><?=format_currency($total_current)?></td>
				<td />
			</tr>
		</tfoot>
	</table>
	<br />
<?	}	?>
