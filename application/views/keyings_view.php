<script src="<?=base_url()?>js/keyings_view.js"></script>
<link href="<?=base_url()?>css/keyings_view.less" rel="stylesheet/less" type="text/css" media="screen" />


<script>
	globals.agents = <?=$agents?>;
</script>

	<div class="keyings_title">
		<div class="title-container">
			<a href="<?=base_url()?>keyings/keyings/<?=$last_period['month']?>/<?=$last_period['year']?>"><img src="<?=base_url()?>images/arrow_left.png" /></a>
			<div class="title"><?=$period['combined']?></div>
			<a href="<?=base_url()?>keyings/keyings/<?=$next_period['month']?>/<?=$next_period['year']?>"><img src="<?=base_url()?>images/arrow_right.png" /></a>
		</div>
		<? if ($period['combined'] != $current_period['combined']) { ?>
			<div class="goto-current"><a href="<?=base_url()?>keyings/keyings/<?=$current_period['month']?>/<?=$current_period['year']?>">Go To Current Month</a></div>
		<? } ?>
	</div>

	<br />

<div class="add-link"><a href="<?=base_url()?>keying/add/<?=$period['month']?>/<?=$period['year']?>">Add New File</a></div>
<?	if (!$keyings) {	?>
	<div class="no-items-message">No Files. Click "Add New File" to get started.</div>
<?
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
		<?
			foreach ($keyings as $keying) {
		?>
			<tr keying_id="<?=$keying->id?>">
				<td><a href="<?=base_url()?>keying/edit/<?=$keying->id?>"><?=$keying->date?></a></td>
				<td class="align-right"><?=$keying->num_pages?></td>
				<td><a href="<?=base_url()?>keying/edit/<?=$keying->id?>"><?=$keying->claim_agent?></a></td>
				<td><?=$keying->claimant?></td>
				<td class="align-center"><?=$keying->qc ? 'X' : ''?></td>
				<td class="align-center"><?=$keying->ex ? 'X' : ''?></td>
				<td class="align-center"><?=$keying->inv ? 'X' : ''?></td>
				<td class="align-center"><?=$keying->inv_qc ? 'X' : ''?></td>
				<td class="align-center"><?=$keying->inv_ex ? 'X' : ''?></td>
				<td class="align-center"><?=$keying->rating?></td>
				<td><div style="height:20px;width:150px;overflow:hidden;white-space:nowrap;"><?=$keying->note?></div></td>
				<td>
					<a href="#" class="delete-keying"><img title="Delete" alt="Delete" class="delete-link" src="<?=base_url()?>images/x.png" /></a>
				</td>
			</tr>
		<?	}	?>
		</tbody>
		<tfoot>
			<tr>
				<td class="align-right">Total Pages</td>
				<td class="align-right"><?=$keying_total?></td>
			</tr>
			<tr>
				<td class="align-right">Total Earned</td>
				<td class="align-right">$<?=$keying_total_earned?></td>
			</tr>
		</tfoot>
	</table>
	<br />
<?	}	?>

<br />
<div class="keyings_title"><span class="title">Claim Agents</span></div>
<br />
<?	if (!$agents) {	?>
	<div class="no-items-message">No Agents. Click "Add New File" to get started.</div>
<?	} else {	?>
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
							<?/* Javascript will load this table so that filtering is all javascript */?>
							</tbody>
						</table>
					</div>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td class="align-right" colspan="2">Total Files</td>
				<td class="align-center"><?=$total_files?></td>
			</tr>
		</tfoot>
	</table>
	<br />
<?	}	?>
