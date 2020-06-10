<a href="/classifieds/"><?=NEWSPAPER_NAME?> Classifieds</a> &raquo; Post your ad

<h1>Post your ad</h1>

<p>If you have any specific requirements or have an idea that requires a little more explination, please contact our classified ad department at 613-.... or email at <a href="mailto:classifieds@<?=DOMAIN?>">classifieds@<?=DOMAIN;?></a>.</p>
<form action="/classifieds/post" method="post">
<style>
#classified_area td {padding: 6px 0px; border-bottom: 1px #ddd solid;}
</style>
	<div id="classified_area">
		<table width="100%">
			<tr>
				<td colspan=2 style="padding: 12px 0px 6px 0px;"><h3>Contact Details</h3></td>
			</tr>
			<tr>
				<td>Full Name</td>
				<td><input name="classified_item_contact_name" class="text" type="text" value="<?=$this->Get_Data('classified_item_contact_name');?>"></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input name="classified_item_contact_email" class="text" type="text" value="<?=$this->Get_Data('classified_item_contact_email');?>"></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td><input name="classified_item_contact_phone" class="text" type="text" value="<?=$this->Get_Data('classified_item_contact_phone');?>"></td>
			</tr>
			<tr>
				<td>Company (optional)</td>
				<td><input name="classified_item_contact_company" class="text" type="text" value="<?=$this->Get_Data('classified_item_contact_company');?>"></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input name="classified_item_contact_address" class="text" type="text" value="<?=$this->Get_Data('classified_item_contact_address');?>"></td>
			</tr>
			<tr>
				<td>City</td>
				<td><input name="classified_item_contact_city" class="text" type="text" value="<?=$this->Get_Data('classified_item_contact_city');?>"></td>
			</tr>
			<tr>
				<td>Province </td>
				<td><input name="classified_item_contact_province" class="text" type="text" value="<?=$this->Get_Data('classified_item_contact_province');?>"></td>
			</tr>
		
			<tr>
				<td colspan=2 style="padding: 12px 0px 6px 0px;"><h3>Ad Details</h3></td>
			</tr>
			
			<tr>
				<td>Select the paper(s) you wish to be published in</td>
				<td><select name="">
					<option>The Hill Times and Embassy Newspapers</option>
					<option>The Hill Times Newspaper</option>
					<option>Embassy Newspaper Newspaper</option>
				</select></td>
			</tr>
			<tr>
				<td>Duration<br />
					
				</td>
				<td>
				Base Cost, $<div id="week_amount" style="display: inline;">32.00</div>
				<select id="classified_item_number_weeks" name="classified_item_number_weeks" onChange="updateBaseAmount();">
						<option value="6" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '6', true);?>>6 Weeks</option>
						<option value="8" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '8');?>>8 Weeks</option>
						<option value="10" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '10');?>>10 Weeks</option>
						<option value="12" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '12');?>>12 Weeks</option>
						<option value="14" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '14');?>>14 Weeks</option>
						<option value="16" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '16');?>>16 Weeks</option>
						<option value="18" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '18');?>>18 Weeks</option>
						<option value="20" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '20');?>>20 Weeks</option>
						<option value="22" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '22');?>>22 Weeks</option>
						<option value="24" <?=is_selected('selected', $this->Get_Data('classified_item_number_weeks'), '24');?>>24 Weeks</option>
						
					</select>
					<p style="font-size: 10pt;">NOTE: You may stop your ad before the duration<br /> and only pay for the time published.</p>
					
					
					Week Starting
						<select>
							<option>Monday July 7 </option>
							<option>Monday July 14 </option>
							<option>Monday July 21 </option>
							<option>Monday July 28 </option>
						</select>
				</td>
			</tr>
			<tr>
				<td>Category</td>
				<td><?	
						if( count( $this->Get_Data('classified_sections') ) ) {
							print '<select name="classified_item_category_id">' . "\n";
							foreach( $this->Get_Data('classified_sections') as $sec ){ ?>
								<option value="<?=$sec['classified_category_id']?>" <?=is_selected('selected', $this->Get_Data('classified_item_category_id'), $sec['classified_category_id']);?>><?=$sec['classified_category_title']?></option>
							<?}
							print "</select>\n";
						}
					?>
				</td>
			</tr>
				
			<tr>
				<td>Title</td>
				<td><input name="classified_item_title" class="text" type="text"  value="<?=$this->post_cleaner( 'classified_item_title', true );?>">
				</td>
			</tr>
			<tr>
				<td>Description		</td>
				<td><textarea class="text" style="width: 420px; height: 200px;" id="classified_item_description" name="classified_item_description" onkeypress="updateReceipt();"><?=$this->post_cleaner( 'classified_item_description' );?></textarea>
	
				</td>
			</tr>	
			<tr><td>&nbsp;</td><td style="padding-top: 10px;">
				<div style="display: none; font-size: 8pt; background-color: #fff; border: 1px #999 solid; padding: 4px;">
							BASE
				15 words for 1st week is $32.00 + GST <br />
				Each additional week is $10.50 + GST <br/ >
				Each additional word is $0.70 per week<br/ >
				
				<br/ >
				HOTLINK is an additional $10.00 + GST per week.<br/ >
				SUPERSIZED TITLE is an additional $18.00 + GST per week<br/ >
				</div>
	
	
				</td></tr>
				<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
			<tr><td>&nbsp;</td><td><input type="submit" class="button_good" value="Continue to payment details..."></td></tr>
			
		</table>
	</div>
	
</form>


<script language="JavaScript"><!--

function updateBaseAmount() {
	obj_weeks 			= document.getElementById('classified_item_number_weeks');
	obj_week_amount 	= document.getElementById('week_amount');
	
	// Base amounts with weeks
	if( obj_weeks.value == 1 ){
		week_cost = Number( 32.00 );
	} else {
		week_cost = Number( (17 * obj_weeks.value) + 32.00 );
	}
	
    obj_week_amount.innerHTML = week_cost.toFixed(2);
}

updateBaseAmount();
//--></script>


