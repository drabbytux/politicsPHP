<p>Make a public comment on this story:</p>
<?=$this->Get_Data('errors');?>
<div id="highlighter_comment"></div><?// Placeholder ?>
<table>
	<tr><td>Your name: </td><td><input class="<?=($this->Get_Error('error_public_comment_name') )? 'texterror':'text';?>" style="width: 410px;" name="public_comment_name" type="text" value="<?=( $this->MemberAllowed() && !$this->Get_Data('public_comment_name') )? $this->Get_Session('member_name_first') . " " . $this->Get_Session('member_name_last'): $this->Get_Data('public_comment_name');?>" /></td></tr>
	<tr><td>Your E-mail: 	</td><td><input class="<?=($this->Get_Error('error_public_comment_email') )? 'texterror':'text';?>" style="width: 410px;" name="public_comment_email" type="text" value="<?=( $this->MemberAllowed() && !$this->Get_Data('public_comment_email') )? $this->Get_Session('member_email') : $this->Get_Data('public_comment_email');?>" /></td></tr>
	<tr><td>Comment: 	</td><td><textarea name="public_comment_comment" class="<?=($this->Get_Error('error_public_comment_comment') )? 'texterror':'text';?>" style="width: 410px; height: 80px;"><?=$this->Get_Data('public_comment_comment');?></textarea></td></tr>
	<tr><td>&nbsp;</td><td style="text-align: left;">
		<div class="button_area" style="padding: 0px;"><input type="submit" class="button_good" style="margin-top: 10px; width: 410px;" name="submit_public_comment" value="Submit Comment" /></div>
	</td></tr>
</table>