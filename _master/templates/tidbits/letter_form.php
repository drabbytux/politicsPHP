<p>You can use this form to submit your letter, or email your letter directly to <a href="mailto:<?=EMAIL_EDITOR;?>"><?=EMAIL_EDITOR;?></a></p>
<?=$this->Get_Data('errors');?>
<div id="highlighter_letter"></div><?// Placeholder ?>
<table>
	<tr><td>Your name: </td><td><input tabindex="4" class="<?=($this->Get_Error('error_letter_name') )? 'texterror':'text';?>" style="width: 410px;" name="letter_name" type="text" value="<?=( $this->MemberAllowed() && !$this->Get_Data('letter_name') )? $this->Get_Session('member_name_first') . " " . $this->Get_Session('member_name_last'): $this->Get_Data('letter_name');?>" /></td></tr>
	<tr><td>Your E-mail: 	</td><td><input tabindex="4" class="<?=($this->Get_Error('error_letter_email') )? 'texterror':'text';?>" style="width: 410px;" name="letter_email" type="text" value="<?=( $this->MemberAllowed() && !$this->Get_Data('letter_email') )? $this->Get_Session('member_email') : $this->Get_Data('letter_email');?>" /></td></tr>
	<tr><td>City: 	</td><td><input tabindex="4"  class="<?=($this->Get_Error('error_letter_city') )? 'texterror':'text';?>" style="width: 410px;" name="letter_city" type="text" value="<?=$this->Get_Data('letter_city');?>" /></td></tr>
	<tr><td>Prov/State: 	</td><td><input tabindex="4" class="<?=($this->Get_Error('error_letter_prov') )? 'texterror':'text';?>" style="width: 410px;" name="letter_prov" type="text" value="<?=$this->Get_Data('letter_prov');?>" /></td></tr>
	<tr><td>Phone(optional): 	</td><td><input tabindex="4" class="<?=($this->Get_Error('error_letter_phone') )? 'texterror':'text';?>" style="width: 410px;" name="letter_phone" type="text" value="<?=$this->Get_Data('letter_phone');?>" /></td></tr>
	<tr><td>Position(optional): 	</td><td><input tabindex="4" class="<?=($this->Get_Error('error_letter_position') )? 'texterror':'text';?>" style="width: 410px;" name="letter_position" type="text" value="<?=$this->Get_Data('letter_position');?>" /></td></tr>
	<tr><td>Letter: 	</td><td><textarea tabindex="4" name="letter_letter" class="<?=($this->Get_Error('error_letter_letter') )? 'texterror':'text';?>" style="width: 410px; height: 360px;"><?=$this->Get_Data('letter_letter');?></textarea></td></tr>
	<tr><td>&nbsp;</td><td><div style="width: 410px; font-size: 7pt; font-weight: bold;">DISCLAIMER: All letters received by the editorial department are subject to reproduction in print or web formats. We are unable to acknowledge receipt of every letter received.</div></td></tr>
	<tr><td>&nbsp;</td><td style="text-align: center;">
		<div class="button_area"><input tabindex="4"  type="submit" class="button_good" style="width: 400px;" name="submit_letter" value="Submit" /></div>
	</td></tr>
</table>