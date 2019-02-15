<link href="<?php echo base_url()?>css/keying_view.less" rel="stylesheet/less" type="text/css" media="screen" />
<script src="<?php echo base_url()?>js/keying_view.js"></script>

<h2 class="title"><?php echo $is_editing ? 'Edit' : 'Add'?> File</h2>

<table>
	<tr>
		<td>
			<?php echo form_open(base_url() . 'keying/save', array('id' => 'keying-form', 'method' => 'post', ))?>
				<input type="hidden" name="id" value="<?php echo $id?>" />
				<table>
					<tr>
						<td width="30%" class="title">Date:</td>
						<td width="70%"><input type="text" size="40" name="date" value="<?php echo $date?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title"># Pages:</td>
						<td width="70%"><input type="text" size="40" name="num_pages" value="<?php echo $num_pages?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title">Claim Agent:</td>
						<td width="70%"><input type="text" size="40" name="claim_agent" value="<?php echo $claim_agent?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title">Agent Note:</td>
						<td width="70%"><input type="text" size="40" name="claim_agent_note" value="<?php echo $claim_agent_note?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title">Claimant:</td>
						<td width="70%"><input type="text" size="40" name="claimant" value="<?php echo $claimant?>" /></td>
					</tr>
					<tr>
						<td width="30%" class="title">QC:</td>
						<td width="70%"><input type="checkbox" name="qc" <?php echo $qc ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">EX:</td>
						<td width="70%"><input type="checkbox" name="ex" <?php echo $ex ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">INV:</td>
						<td width="70%"><input type="checkbox" name="inv" <?php echo $inv ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">INV-QC:</td>
						<td width="70%"><input type="checkbox" name="inv_qc" <?php echo $inv_qc ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">INV-EX:</td>
						<td width="70%"><input type="checkbox" name="inv_ex" <?php echo $inv_ex ? 'checked="checked"' : ''?> /></td>
					</tr>
					<tr>
						<td width="30%" class="title">Rating:</td>
						<td width="70%">
							<select name="rating">
								<option value="1" <?php echo $rating == 1 ? 'selected="selected"' : ''?>>1</option>
								<option value="2" <?php echo $rating == 2 ? 'selected="selected"' : ''?>>2</option>
								<option value="3" <?php echo $rating == 3 ? 'selected="selected"' : ''?>>3</option>
							</select>
						</td>
					</tr>
					<tr>
						<td width="30%" class="title">Notes:</td>
						<td width="70%">
							<textarea name="note" cols="35" rows="4"><?php echo $note?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="buttons">
							<a href="#" id="cancel-button" class="fakebutton">Cancel</a>
							<a href="#" id="submit-button" class="fakebutton">Save</a>
						</td>
					</tr>
				</table>
			<?php echo form_close()?>
		</td>
	</tr>
</table>
