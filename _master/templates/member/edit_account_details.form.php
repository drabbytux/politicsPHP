<style>
#billing_details_div { display: none;}
#billing_details_swap_same { display: block;}
#billing_details_swap_diff { display: none;}
</style>
<script type="text/javascript">
function swap_billing(){
	billingdiv = document.getElementById('billing_details_div');
	billingsuggestsame = document.getElementById('billing_details_swap_same');
	billingsuggestdiff = document.getElementById('billing_details_swap_diff');
	
	if( billingdiv.style.display == "" ) {
		billingdiv.style.display = "none";
	}
	// alert( billingdiv.style.display);
	if( billingdiv.style.display == "none"){
		billingdiv.style.display = "block";	// Show billing
		billingsuggestsame.style.display = "none";
		billingsuggestdiff.style.display = "block";
	} else {
		billingdiv.style.display = "none";
		billingsuggestdiff.style.display = "none";
		billingsuggestsame.style.display = "block";
	}
}
</script>
<div id="simpleform">
<h2>Edit your Account</h2>
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
			<legend>PDF / Email Notifications</legend>
				<table>
					<tr><td class="label" colspan=2><input type="radio" name="member_preference_email_pdf" value="1" <?=is_selected('checked', $this->Get_Data('member_preference_email_pdf'), 1, true);?>/> <label for="name">I would like a PDF version of the paper sent to my email.</label> </td></tr>
					<tr><td class="label" colspan=2><input type="radio" name="member_preference_email_pdf" value="2" <?=is_selected('checked', $this->Get_Data('member_preference_email_pdf'), 2);?>/> 	 <label for="name">I would like to be notified by email when a new issue is published.</label> </td></tr>
					<tr><td class="label" colspan=2><input type="radio" name="member_preference_email_pdf" value="3" <?=is_selected('checked', $this->Get_Data('member_preference_email_pdf'), 3);?>/> 	 <label for="name">No notifications, thanks.</label> </td></tr> 
	
				</table>				
		</fieldset>	
	<br /><br />
		<fieldset>
			<legend>Change your password</legend>
				<table>
					<tr><td class="label"><label for="member_new_password_1">New Password</label></td>					<td class="inputs"><input class="text" type="password" name="member_new_password_1" value=""></td></tr>
					<tr><td class="label"><label for="member_new_password_2">New Password (repeated)</label></td>		<td class="inputs"><input class="text" type="password" name="member_new_password_2" value=""></td></tr>
				</table>				
		</fieldset>

<!-- 
<br /><br />
		<fieldset>
			<legend>Delivery Information</legend>
				<table>
					<tr>
						<td class="label"><label for="name_first">Street Address</label></td>
						<td class="inputs"><input class="text" style="margin-bottom: 2px;" id="member_street_address_1" name="member_street_address_1" value="<?=$this->Get_Data('member_street_address_1');?>" />
			
						<input class="text" id="member_street_address_2" name="member_street_address_2" value="<?=$this->Get_Data('member_street_address_2');?>" />
						</td>
					</tr>
					<tr>
						<td class="label"><label for="member_city">City</label></td>
						<td class="inputs"><input class="text" id="member_city" name="<?=$this->Get_Data('member_city');?>"  value="<?=$this->Get_Data('member_city');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_province">State/Province</label></td>
						<td  class="inputs"><input class="text" id="member_province" value="<?=$this->Get_Data('member_province');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_postal_code">Postal Code</label></td>
						<td  class="inputs"><input class="text" id="member_postal_code" value="<?=$this->Get_Data('member_postal_code');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_preference_email_pdf">Email a PDF version</label></td>
						<td class="inputs" style="text-align: left;"><input type="radio" name="member_preference_email_pdf" value="1" />Yes <input type="radio" name="member_preference_email_pdf" value="2" />No Thanks</td>
					</tr>
				</table>
				<br />
					<div id="billing_details_swap_same">
						Bill this address <a href="javascript:swap_billing();" class="small_function_link">Modify billing information</a>
					</div>
					<div id="billing_details_swap_diff">
						Use the billing address <a href="javascript:swap_billing();" class="small_function_link">Use delivery information</a>
					</div>
		</fieldset>
<br />
		<div id="billing_details_div">
			<fieldset>
			<legend>Billing Information</legend>
				<table>
					<tr>
						<td class="label"><label for="name_first">Street Address</label></td>
						<td class="inputs"><input class="text" style="margin-bottom: 2px;" id="member_street_address_1" name="member_street_address_1" value="<?=$this->Get_Data('member_street_address_1');?>" />
			
						<input class="text" id="member_street_address_2" name="member_street_address_2" value="<?=$this->Get_Data('member_street_address_2');?>" />
						</td>
					</tr>
					<tr>
						<td class="label"><label for="member_city">City</label></td>
						<td class="inputs"><input class="text" id="member_city" name="<?=$this->Get_Data('member_city');?>"  value="<?=$this->Get_Data('member_city');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_province">State/Province</label></td>
						<td  class="inputs"><input class="text" id="member_province" value="<?=$this->Get_Data('member_province');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_postal_code">Postal Code</label></td>
						<td  class="inputs"><input class="text" id="member_postal_code" value="<?=$this->Get_Data('member_postal_code');?>" /></td>
					</tr>
				</table>
			</fieldset>
		</div>
				// -->
	<br /><br />
		<fieldset>	
				<table>
					<tr><td class="tdbuttons"><div class="button_area"><input class="button_good" type="submit" value="Update my account" name="submit_member_update_profile" /></div><div class="button_area"><input class="button_warning" type="submit" value="cancel" name="cancel" /></div></td></tr>
				</table>
		</fieldset>

</form>
</div>
