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
	<form action="" method="POST">
<br /><br />
		<fieldset>
			<legend>Delivery Information</legend>
				<table>
					<tr>
						<td class="label"><label for="name_first">Street Address</label></td>
						<td class="inputs"><input class="text" style="margin-bottom: 2px;" id="member_member_street_address_1" name="member_member_street_address_1" value="<?=$this->Get_Data('member_member_street_address_1');?>" />
			
						<input class="text" id="member_member_street_address_2" name="member_member_street_address_2" value="<?=$this->Get_Data('member_member_street_address_2');?>" />
						</td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_city">City</label></td>
						<td class="inputs"><input class="text" id="member_member_city" name="<?=$this->Get_Data('member_member_city');?>"  value="<?=$this->Get_Data('member_member_city');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_province">State/Province</label></td>
						<td  class="inputs"><input class="text" id="member_member_province" value="<?=$this->Get_Data('member_member_province');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_postal_code">Postal Code</label></td>
						<td  class="inputs"><input class="text" id="member_member_postal_code" value="<?=$this->Get_Data('member_member_postal_code');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_preference_email_pdf">Email a PDF version</label></td>
						<td class="inputs" style="text-align: left;"><input type="radio" name="member_member_preference_email_pdf" value="1" />Yes <input type="radio" name="member_member_preference_email_pdf" value="2" />No Thanks</td>
					</tr>
				</table>
				<!-- 
				<br />
					<div id="billing_details_swap_same">
						Bill this address <a href="javascript:swap_billing();" class="small_function_link">Modify billing information</a>
					</div>
					<div id="billing_details_swap_diff">
						Use the billing address <a href="javascript:swap_billing();" class="small_function_link">Use delivery information</a>
					</div>
				//	 -->
		</fieldset>
<br />
		<div id="billing_details_div">
			<fieldset>
			<legend>Billing Information</legend>
				<table>
					<tr>
						<td class="label"><label for="name_first">Street Address</label></td>
						<td class="inputs"><input class="text" style="margin-bottom: 2px;" id="member_member_street_address_1" name="member_member_street_address_1" value="<?=$this->Get_Data('member_member_street_address_1');?>" />
			
						<input class="text" id="member_member_street_address_2" name="member_member_street_address_2" value="<?=$this->Get_Data('member_member_street_address_2');?>" />
						</td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_city">City</label></td>
						<td class="inputs"><input class="text" id="member_member_city" name="<?=$this->Get_Data('member_member_city');?>"  value="<?=$this->Get_Data('member_member_city');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_province">State/Province</label></td>
						<td  class="inputs"><input class="text" id="member_member_province" value="<?=$this->Get_Data('member_member_province');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_postal_code">Postal Code</label></td>
						<td  class="inputs"><input class="text" id="member_member_postal_code" value="<?=$this->Get_Data('member_member_postal_code');?>" /></td>
					</tr>
				</table>
			</fieldset>
		</div>

	<br /><br />
		<fieldset>
			
				<table>
					<tr><td class="tdbuttons"><div class="button_area"><input class="button_good" type="submit" value="Update my subscription information" name="member_update_password_submit" /></div><div class="button_area"><input class="button_warning" type="submit" value="cancel" name="cancel" /></div></td></tr>
				</table>
	
		</fieldset>
		
	</form>
</div>