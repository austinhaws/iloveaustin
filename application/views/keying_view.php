<link href="<?=base_url()?>css/keying_view.less" rel="stylesheet/less" type="text/css" media="screen" />
<script src="<?=base_url()?>js/keying_view.js"></script>

<h2 class="title"><?=$is_editing ? 'Edit' : 'Add'?> File</h2>

<table>
	<tr>
		<td>
			<?=form_open(base_url() . 'keying/save', array('id' => 'keying-form', 'method' => 'post', ))?>
				<input type="hidden" name="id" value="<?=$id?>" />
				<table>
					<tr>
						<td width="30%" class="title">Date:</td>
						<td width="70%"><input type="text" size="40" name="date" value="<?=$date?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title"># Pages:</td>
						<td width="70%"><input type="text" size="40" name="num_pages" value="<?=$num_pages?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title">Claim Agent:</td>
						<td width="70%"><input type="text" size="40" name="claim_agent" value="<?=$claim_agent?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title">Agent Note:</td>
						<td width="70%"><input type="text" size="40" name="claim_agent_note" value="<?=$claim_agent_note?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title">Claimant:</td>
						<td width="70%"><input type="text" size="40" name="claimant" value="<?=$claimant?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title">QC:</td>
						<td width="70%"><input type="checkbox" name="qc" <?=$qc ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">EX:</td>
						<td width="70%"><input type="checkbox" name="ex" <?=$ex ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">INV:</td>
						<td width="70%"><input type="checkbox" name="inv" <?=$inv ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">INV-QC:</td>
						<td width="70%"><input type="checkbox" name="inv_qc" <?=$inv_qc ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">INV-EX:</td>
						<td width="70%"><input type="checkbox" name="inv_ex" <?=$inv_ex ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">Rating:</td>
						<td width="70%">
							<select name="rating">
								<option value="1" <?=$rating == 1 ? 'selected="selected"' : ''?>>1</option>
								<option value="2" <?=$rating == 2 ? 'selected="selected"' : ''?>>2</option>
								<option value="3" <?=$rating == 3 ? 'selected="selected"' : ''?>>3</option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="30%" class="title">Notes:</td>
						<td width="70%">
							<textarea name="note" cols="35" rows="4"><?=$note?></textarea>
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
