<link href="<?=base_url()?>css/snapshot_view.less" rel="stylesheet/less" type="text/css" media="screen" />
<script src="<?=base_url()?>js/snapshot_view.js"></script>

<script>
	globals.month = <?=$month?>;
	globals.year = <?=$year?>;
</script>

<h2 class="title"><?=$is_editing ? 'Edit' : 'Add'?> Snapshot</h2>
<br />
<table>
	<tr>
		<td>
			<?=form_open(base_url() . 'snapshot/save', array('id' => 'snapshot-form', 'method' => 'post', ))?>
				<input type="hidden" name="month" value="<?=$month?>" />
				<input type="hidden" name="year" value="<?=$year?>" />
				<input type="hidden" name="id" value="<?=$id?>" />
				<table>
					<tr>
						<td width="30%" class="field-title">Name:</td>
						<td width="70%"><input type="text" size="40" name="name" value="<?=$name?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="field-title">Wells Fargo?:</td>
						<td width="70%"><input type="checkbox" name="is_totalable" value="1" <?=$is_totalable ? 'checked="checked"' : '' ?> /> (Does this add to the Well's Fargo total?)</td>
					</tr>
					<tr>
						<td width="30%" class="field-title">Goal:</td>
						<td width="70%"><input type="text" size="10" name="goal" value="<?=format_currency($amt_goal)?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="field-title">Current:</td>
						<td width="70%"><input type="text" size="10" name="current" value="<?=format_currency($amt_current)?>" /> <span style="font-weight:bold;font-size:1.5em;">+</span> <input type="text" size="4" name="current_add" value="" /></td>
					</tr>
					<tr>
						<td width="30%" class="field-title">Notes:</td>
						<td width="70%">
							<textarea name="notes" cols="35" rows="4"><?=$notes?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttons">
							<a href="#" id="cancel-button" class="fakebutton">Cancel</a>
							<a href="#" id="submit-button" class="fakebutton">Save</a>
						</td>
					</tr>
				</table>
			<?=form_close()?>
		</td>
	</tr>
</table>

