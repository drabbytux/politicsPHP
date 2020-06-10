<style>
<?
if( !$this->Get_Data('billing_address_flag') ) {
	?>	#billing_details_div { display: none;}
		#billing_details_swap_same { display: block;}
		#billing_details_swap_diff { display: none;}
	<?
} else {
	?>	#billing_details_div { display: block;}
		#billing_details_swap_same { display: none;}
		#billing_details_swap_diff { display: block;}	
	<?	
}
?>


</style>
<script type="text/javascript">
function swap_billing(){
	billingdiv = document.getElementById('billing_details_div');
	billingflag = document.getElementById('billing_address_flag');
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
		billingflag.value="true";
	} else {
		billingdiv.style.display = "none";
		billingsuggestdiff.style.display = "none";
		billingsuggestsame.style.display = "block";
		billingflag.value="";
	}
}
</script>


				<br />
				<!-- 
					<div id="billing_details_swap_same">
						Bill the <strong>delivery</strong> address <a href="javascript:swap_billing();" class="small_function_link">Change</a>
					</div>
					<div id="billing_details_swap_diff">
						Bill the <strong>following</strong> address <a href="javascript:swap_billing();" class="small_function_link">Change</a>
					</div>
					<input type="hidden" id="billing_address_flag" name="billing_address_flag" value="<?=$this->Get_Data('billing_address_flag');?>" />
					//  -->
					 
<div id="billing_details_div">
			<fieldset style="width: 90%;">
			<legend>Billing Information</legend>
				<table>
					<tr>
						<td class="label"><label for="member_member_city">Billing Full Name/Company</label></td>
						<td class="inputs"><input class="text" id="member_member_billing_name" name="member_member_billing_name"  value="<?=$this->Get_Data('member_member_billing_name');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="name_first">Street Address</label></td>
						<td class="inputs"><input class="text" style="margin-bottom: 2px;" id="member_member_billing_street_address_1" name="member_member_billing_street_address_1" value="<?=$this->Get_Data('member_member_billing_street_address_1');?>" />
			
						<input class="text" id="member_member_billing_street_address_2" name="member_member_billing_street_address_2" value="<?=$this->Get_Data('member_member_billing_street_address_2');?>" />
						</td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_billing_city">City</label></td>
						<td class="inputs"><input class="text" id="member_member_billing_city" name="member_member_billing_city"  value="<?=$this->Get_Data('member_member_billing_city');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_billing_province">State/Province</label></td>
						<td  class="inputs"><input class="text" id="member_member_billing_province" name="member_member_billing_province" value="<?=$this->Get_Data('member_member_billing_province');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_member_billing_postal_code">Postal Code</label></td>
						<td  class="inputs"><input class="text" id="member_member_billing_postal_code" name="member_member_billing_postal_code" value="<?=$this->Get_Data('member_member_billing_postal_code');?>" /></td>
					</tr>
				</table>
			</fieldset>
		</div>	