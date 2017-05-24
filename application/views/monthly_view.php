<link href="<?=base_url()?>css/monthly_view.less" rel="stylesheet/less" type="text/css" media="screen" />
<script src="<?=base_url()?>js/monthly_view.js"></script>

<h2 class="title"><?=$is_editing ? 'Edit' : 'Add'?> Monthly</h2>
<table>
	<tr>
		<td>
			<?=form_open(base_url() . 'monthly/save', array('id' => 'monthly-form', 'method' => 'post', ))?>
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" name="period" value="<?=$period?>" />
				<table>
					<tr>
						<td width="30%" class="field-title">Name:</td>
						<td width="70%"><input type="text" size="40" name="name" value="<?=$name?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="field-title">Goal:</td>
						<td width="70%"><input type="text" size="10" name="goal" value="<?=format_currency($amt_goal)?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="field-title">Spent:</td>
						<td width="70%"><input type="text" size="10" name="spent" value="<?=format_currency($amt_spent)?>" /> <span style="font-weight:bold;font-size:1.5em;">+</span> <input type="text" size="4" name="spent_add" value="" /></td>
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
