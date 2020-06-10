<p>You can also use the following form to inquire about sales rates</p>
<form action="/information/contact/advertise" method="post">
	<?=$this->Get_Data('errors');?>
	<fieldset>
		<legend>Quick Contact Form</legend>
			<div id="quickform">
				<table style="width: 100%;">
				    <tbody>
				        <tr>
				            <td>Name</td>
				            <td><input type="text" <?=( $this->Get_Error('adv_error_name') )? 'class="error_text"': NULL; ?> name="adv_name" value="<?=$this->Get('adv_name')?>" /></td>
				        </tr>
				        <tr>
				            <td>Email</td>
				            <td><input type="text" <?=( $this->Get_Error('adv_error_email') )? 'class="error_text"': NULL; ?> name="adv_email" value="<?=$this->Get('adv_email')?>" /></td>
				        </tr>
		
				        <tr>
				            <td>Company</td>
				            <td><input type="text" name="adv_company" value="<?=$this->Get('adv_company')?>" /></td>
				        </tr>
				        <tr>
				            <td>Type of Business</td>
				            <td><input type="text" name="adv_type_business" value="<?=$this->Get('adv_type_business')?>" /></td>
				        </tr>
				        <tr>
				            <td>Position</td>
				            <td><input type="text" name="adv_position" value="<?=$this->Get('adv_position')?>" /></td>
				        </tr>
				        <tr>
				            <td>Phone</td>
				            <td><input type="text" <?=( $this->Get_Error('adv_error_phone') )? 'class="error_text"': NULL; ?> name="adv_phone" value="<?=$this->Get('adv_phone')?>" /></td>
				        </tr>
				        <tr>
				            <td>Fax</td>
				            <td><input type="text" name="adv_fax" value="<?=$this->Get('adv_fax')?>" /></td>
				        </tr>
				        <tr>
				            <td>Address</td>
				            <td><input type="text" <?=( $this->Get_Error('adv_error_address') )? 'class="error_text"': NULL; ?> name="adv_address" value="<?=$this->Get('adv_address')?>" /></td>
				        </tr>
				        <tr>
				            <td>City</td>
				            <td><input type="text" <?=( $this->Get_Error('adv_error_city') )? 'class="error_text"': NULL; ?> name="adv_city" value="<?=$this->Get('adv_city')?>" /></td>
				        </tr>
				        <tr>
				            <td>Prov/State</td>
				            <td><input type="text" <?=( $this->Get_Error('adv_error_prov') )? 'class="error_text"': NULL; ?> style="width: 100px;" name="adv_prov" value="<?=$this->Get('adv_prov')?>" /></td>
				        </tr>
				        <tr>
				            <td>Postal Code/Zip</td>
				            <td><input type="text" <?=( $this->Get_Error('adv_error_postal') )? 'class="error_text"': NULL; ?> style="width: 100px;" name="adv_postal" value="<?=$this->Get('adv_postal')?>" /></td>
				        </tr> 
				        
				        <tr>
				            <td colspan=2>
				            	<fieldset>
				            		Please send me <?=NEWSPAPER_NAME?> Rate Card
				           			<input type="radio" name="adv_further_contact" value="Email" <?=is_selected('checked', $this->Get('adv_further_contact'), 'Email', true) ?>/>By Email &nbsp;&nbsp; <input type="radio" name="adv_further_contact" value="Fax" <?=is_selected('checked', $this->Get('adv_further_contact'), 'Fax') ?>/>By Fax<br/>
				           			
				           			
				            	</fieldset>
				            </td>
				        </tr> 
				        <tr>
				            <td style="border-top: 1px #888 solid;border-bottom: 1px #888 solid;"><input type="checkbox" name="adv_further_contact2" value="mail" <?=is_selected('checked', $this->Get('adv_further_contact2'), 'mail') ?>/></td>
				            <td style="border-top: 1px #888 solid;border-bottom: 1px #888 solid;">Please mail me a complete media kit including rate card information.</td>
				        </tr> 
				        <tr>
				            <td style="border-bottom: 1px #888 solid;"><input type="checkbox" name="adv_further_contact3" value="phone" <?=is_selected('checked', $this->Get('adv_further_contact3'), 'phone') ?>/></td>
				            <td style="border-bottom: 1px #888 solid;">Please call me at your earliest convenience.</td>
				        </tr> 	        
				       	<tr>
				            <td colspan=2><br /><input class="button_good" style="width: 100%;" type="submit" name="submit_adv_form" value="Submit" /></td>
				        </tr> 
				        
				    </tbody>
				</table>
			</div>
	
	</fieldset>
	
</form>
