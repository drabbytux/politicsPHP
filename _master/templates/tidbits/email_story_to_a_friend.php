<p>Let someone know about this story:</p>
<?=$this->Get_Data('errors');?>
<div id="highlighter_email"></div><?// Placeholder ?>
<table>
	<tr><td>Your E-mail: </td><td><input class="<?=($this->Get_Error('error_email_story_email_from') )? 'texterror':'text';?>" style="width: 410px;" name="email_story_email_from" type="text" value="<?=( $this->MemberAllowed() && !$this->Get_Data('email_story_email_from') )? $this->Get_Session('member_email') : $this->Get_Data('email_story_email_from');?>" /></td></tr>
	<tr><td>Recipient E-mail: 	</td><td><input class="<?=($this->Get_Error('error_email_story_email_to') )? 'texterror':'text';?>" style="width: 410px;" name="email_story_email_to" type="text" value="<?=$this->Get_Data('email_story_email_to');?>" /></td></tr>
	<tr><td>Message (optional): 	</td><td><textarea name="email_story_message" class="text" style="width: 410px; height: 80px;"><?=$this->Get_Data('email_story_message');?></textarea></td></tr>
	<tr><td>&nbsp;</td><td style="text-align: left;">
		<div class="button_area" style="padding: 0px;"><input type="submit" class="button_good" style="margin-top: 10px; width: 410px;" name="submit_email_story" value="Send" /></div>
	</td></tr>
</table>