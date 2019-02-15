<script src="<?php echo base_url()?>js/keyings_view.js"></script>
<link href="<?php echo base_url()?>css/keyings_view.less" rel="stylesheet/less" type="text/css" media="screen" />


<script>
	globals.agents = <?php echo $agents?>;
</script>

	<div class="keyings_title">
		<div class="title-container">
			<a href="<?php echo base_url()?>keyings/keyings/<?php echo $last_period['month']?>/<?php echo $last_period['year']?>"><img src="<?php echo base_url()?>images/arrow_left.png" /></a>
			<div class="title"><?php echo $period['combined']?></div>
			<a href="<?php echo base_url()?>keyings/keyings/<?php echo $next_period['month']?>/<?php echo $next_period['year']?>"><img src="<?php echo base_url()?>images/arrow_right.png" /></a>
		</div>
		<?php if ($period['combined'] != $current_period['combined']) { ?>
			<div class="goto-current"><a href="<?php echo base_url()?>keyings/keyings/<?php echo $current_period['month']?>/<?php echo $current_period['year']?>">Go To Current Month</a></div>
		<?php } ?>
	</div>

	<br />

<div class="add-link"><a href="<?php echo base_url()?>keying/add/<?php echo $period['month']?>/<?php echo $period['year']?>">Add New File</a></div>
<?php  	if (!$keyings) {	?>
	<div class="no-items-message">No Files. Click "Add New File" to get started.</div>
<?php
	} else {
?>
	<table>
		<thead>
			<tr>
				<th class="border_bottom">Date</th>
				<th class="border_bottom"># Pages</th>
				<th class="border_bottom">Claim Agent</th>
				<th class="border_bottom">Claimant</th>
				<th class="border_bottom">QC</th>
				<th class="border_bottom">EX</th>
				<th class="border_bottom">INV</th>
				<th class="border_bottom">INVQC</th>
				<th class="border_bottom">INVEX</th>
				<th class="border_bottom">Rating</th>
				<th class="border_bottom">Note</th>
				<th class="border_bottom" />
			</tr>
		</thead>
		<tbody>
		<?php
			foreach ($keyings as $keying) {
		?>
			<tr keying_id="<?php echo $keying->id?>">
				<td><a href="<?php echo base_url()?>keying/edit/<?php echo $keying->id?>"><?php echo $keying->date?></a></td>
				<td class="align-right"><?php echo $keying->num_pages?></td>
				<td><a href="<?php echo base_url()?>keying/edit/<?php echo $keying->id?>"><?php echo $keying->claim_agent?></a></td>
				<td><?php echo $keying->claimant?></td>
				<td class="align-center"><?php echo $keying->qc ? 'X' : ''?></td>
				<td class="align-center"><?php echo $keying->ex ? 'X' : ''?></td>
				<td class="align-center"><?php echo $keying->inv ? 'X' : ''?></td>
				<td class="align-center"><?php echo $keying->inv_qc ? 'X' : ''?></td>
				<td class="align-center"><?php echo $keying->inv_ex ? 'X' : ''?></td>
				<td class="align-center"><?php echo $keying->rating?></td>
				<td><div style="height:20px;width:150px;overflow:hidden;white-space:nowrap;"><?php echo $keying->note?></div></td>
				<td>
					<a href="#" class="delete-keying"><img title="Delete" alt="Delete" class="delete-link" src="<?php echo base_url()?>images/x.png" /></a>
				</td>
			</tr>
		<?php  	}	?>
		</tbody>
		<tfoot>
			<tr>
				<td class="align-right">Total Pages</td>
				<td class="align-right"><?php echo $keying_total?></td>
			</tr>
			<tr>
				<td class="align-right">Total Earned</td>
				<td class="align-right">$<?php echo $keying_total_earned?></td>
			</tr>
		</tfoot>
	</table>
	<br />
<?php  	}	?>

<br />
<div class="keyings_title"><span class="title">Claim Agents</span></div>
<br />
<?php  	if (!$agents) {	?>
	<div class="no-items-message">No Agents. Click "Add New File" to get started.</div>
<?php  	} else {	?>
	<div id="search-box">
		Search For Agent: <input type="text" id="search-text" /> <a href="#" class="fakebutton small" id="search-clear">Clear</a>
	</div>
	<table id="agents-table">
		<thead>
			<tr>
				<th class="border_bottom column_agent">Claim Agent</th>
				<th class="border_bottom column_rating">Rating</th>
				<th class="border_bottom column_files"># Files</th>
				<th class="border_bottom column_comment">Comments</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="100">
					<div id="agent-container">
						<table>
							<tbody>
							<?php /* Javascript will load this table so that filtering is all javascript */ ?>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td class="align-right" colspan="2">Total Files</td>
				<td class="align-center"><?php echo $total_files?></td>
			</tr>
		</tfoot>
	</table>
	<br />
<?php  	}	?>
