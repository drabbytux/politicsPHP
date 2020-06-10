<?=$this->Get_Data('errors');?>
<div id="simpleform">
	<form action="" method="POST">
		<fieldset>
			<legend>Change your password</legend>
				<table>
					<tr><td class="label"><label for="name">New Password</label></td>					<td class="inputs"><input class="text" type="password" name="member_new_password_1" value="<?=$this->Get_Data('member_new_password_1');?>" /></td></tr>
					<tr><td class="label"><label for="name">New Password (repeated)</label></td>		<td class="inputs"><input class="text" type="password" name="member_new_password_2" value="<?=$this->Get_Data('member_new_password_2');?>" /></td></tr>
					<tr><td class="label" colspan=2><input type="checkbox" name="member_password_send" /> Send me an email with my password for future reference.</td></tr>
				</table>				
		</fieldset>
<br />
		<fieldset>	
				<table>
					<tr><td class="tdbuttons"><div class="button_area"><input class="button_good" type="submit" value="Update my password" name="member_update_password_submit" /></div></td></tr>
				</table>
		</fieldset>
	</form>
</div>