<div id="simpleform">
<div style="text-align: center;"><?=$this->Get_Data('messages');?>
<?=$this->Get_Data('errors');?></div>
	<form action="" method="POST">
		<fieldset>
			<legend>Account Details</legend>
				<table>
					<tr>
						<td class="label"><label for="name_first">First Name<em>*</em></label></td>
						<td class="inputs"><input class="text" id="name" title="click to edit" name="member_name_first" value="<?=$this->Get_Data('member_name_first');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="name_first">Last Name</label></td>
						<td class="inputs"><input class="text" id="name_last" name="member_name_last"  value="<?=$this->Get_Data('member_name_last');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_email">Email Address<em>*</em></label></td>
						<td  class="inputs"><input class="text" name="member_email" value="<?=$this->Get_Data('member_email');?>" /></td>
					</tr>
				</table>
			
		</fieldset>
	<br /><br />
		<fieldset>
			<legend>Change your password</legend>
				<table>
					<tr><td class="label"><label for="name">New Password</label></td>					<td class="inputs"><input class="text" type="password" name="member_new_password_1" value="<?=$this->Get_Data('member_new_password_1');?>" /></td></tr>
					<tr><td class="label"><label for="name">New Password (repeated)</label></td>		<td class="inputs"><input class="text" type="password" name="member_new_password_2" value="<?=$this->Get_Data('member_new_password_2');?>" /></td></tr>
				</table>				
		</fieldset>
	<br /><br />
		<fieldset>	
				<table>
					<tr><td class="tdbuttons"><div class="button_area"><input class="button_good" type="submit" value="Update my account" name="submit_member_update_profile" /></div><div class="button_area"><input class="button_warning" type="submit" value="cancel" name="cancel" /></div></td></tr>
				</table>
		</fieldset>
		
	</form>
</div>