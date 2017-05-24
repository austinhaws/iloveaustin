<link href="<?=base_url()?>css/saving_view.less" rel="stylesheet/less" type="text/css" media="screen" />
<script src="<?=base_url()?>js/saving_view.js"></script>

<h2 class="title"><?=$is_editing ? 'Edit' : 'Add'?> Saving</h2>
<br />
<table>
	<tr>
		<td>
			<?=form_open(base_url() . 'saving/save', array('id' => 'saving-form', 'method' => 'post', ))?>
				<input type="hidden" name="id" value="<?=$id?>" />
				<table>
					<tr>
						<td width="30%" class="right bold title">Name:</td>
						<td width="70%"><input type="text" size="40" name="name" value="<?=$name?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="right bold title">Due Date:</td>
						<td width="70%"><input type="text" size="15" name="due_date" value="<?=$due_date?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="right bold title">Goal:</td>
						<td width="70%"><input type="text" size="10" name="amt_goal" value="<?=format_currency($amt_goal)?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="right bold title">Current:</td>
						<td width="70%"><input type="text" size="10" name="amt_current" value="<?=format_currency($amt_current)?>" /> <span style="font-weight:bold;font-size:1.5em;">+</span> <input type="text" size="4" name="amt_current_add" value="" /></td>
					</tr>
					<tr>
						<td width="30%" class="right bold title">Notes:</td>
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

