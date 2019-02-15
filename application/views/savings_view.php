<script src="<?php echo base_url()?>js/savings_view.js"></script>
<link href="<?php echo base_url()?>css/savings_view.less" rel="stylesheet/less" type="text/css" media="screen" />

	<div class="add-link"><a href="<?php echo base_url()?>saving/add">Add New Savings</a></div>
<?php  	if (!$savings) {	?>
	<div>No Savings. Click "Add New Savings" to get started.</div>
<?php  	} else {	?>
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
		<?php  	foreach ($savings as $saving) {	?>
			<tr saving_id="<?php echo $saving->id?>">
				<td>
				<?php  	if ($saving->amt_goal && $saving->amt_goal != '000') {	?>
					<div class="progress-container">
						<div class="progress-bar" target_width="<?php echo 100.0 * $saving->amt_current / $saving->amt_goal?>%"></div>
					</div>
				<?php  	}	?>
				</td>
				<td><a href="<?php echo base_url()?>saving/edit/<?php echo $saving->id?>"><?php echo $saving->name?></a></td>
				<td class="align-right"><?php echo $saving->due_date?></td>
				<td class="align-right"><?php echo format_currency($saving->amt_goal)?></td>
				<td class="align-right"><?php echo format_currency($saving->amt_current)?></td>
				<td class="align-center">
					<img class="delete-savings delete-link" title="Delete" alt="Delete" src="<?php echo base_url()?>images/x.png" />
				</td>
			</tr>
		<?php  	}	?>
		</tbody>
		<tfoot>
			<tr>
				<td />
				<td />
				<td class="bold border_top">Totals:</td>
				<td class="bold border_top"><?php echo format_currency($total_goal)?></td>
				<td class="bold border_top"><?php echo format_currency($total_current)?></td>
				<td />
			</tr>
		</tfoot>
	</table>
	<br />
<?php  	}	?>
