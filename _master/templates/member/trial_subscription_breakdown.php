<h2 style="vertical-align: middle; width: 100%;">Step 2 of 4<br />Enter your information and choose a subscription</h2>

<div id="simpleform">
<?=$this->Get_Data('messages');?>
<?=$this->Get_Data('errors');?>
<form action="" method="POST">

		<fieldset>
			<legend>Account Details</legend>
				<table>
					<tr>
						<td class="label"><label for="name_first">First Name</label></td>
						<td class="inputs"><input class="text" id="name" <?=errorTextBoxHighlighter( $this->Get_Error('member_name_first') );?> title="click to edit" name="member_name_first" value="<?=$this->Get_Data('member_name_first');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="name_last">Last Name</label></td>
						<td class="inputs"><input class="text" id="name_last" name="member_name_last"  value="<?=$this->Get_Data('member_name_last');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_email">Email Address</label></td>
						<td  class="inputs"><input class="text" <?=errorTextBoxHighlighter( $this->Get_Error('member_email') );?> name="member_email" value="<?=$this->Get_Data('member_email');?>" /></td>
					</tr>
				</table>
			
		</fieldset>
		
<br /><br />
		<fieldset>
			<legend>Delivery Information</legend>
				<table>
					<tr>
						<td class="label"><label for="name_first">Street Address</label></td>
						<td class="inputs">	<input class="text" <?=errorTextBoxHighlighter( $this->Get_Error('member_street_address_1') );?>  id="member_street_address_1" name="member_street_address_1" value="<?=$this->Get_Data('member_street_address_1');?>" />
											<input class="text" id="member_street_address_2" name="member_street_address_2" value="<?=$this->Get_Data('member_street_address_2');?>" />
						</td>
					</tr>
					<tr>
						<td class="label"><label for="member_city">City</label></td>
						<td class="inputs"><input class="text" <?=errorTextBoxHighlighter( $this->Get_Error('member_city') );?> id="member_city" name="member_city"  value="<?=$this->Get_Data('member_city');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_province">State/Province</label></td>
						<td  class="inputs"><input class="text" <?=errorTextBoxHighlighter( $this->Get_Error('member_province') );?> id="member_province" name="member_province" value="<?=$this->Get_Data('member_province');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_country">Country</label></td>
						<td  class="inputs">
						<select name="member_country">
<?
$arr_countries = array("CA"=>"Canada" ,"US"=>"United States" ,"AF"=>"Afghanistan" ,"AX"=>"ALand Islands" ,"AL"=>"Albania" ,"DZ"=>"Algeria" ,"AS"=>"American Samoa" ,"AD"=>"Andorra" ,"AO"=>"Angola" ,"AI"=>"Anguilla" ,"AQ"=>"Antarctica" ,"AG"=>"Antigua And Barbuda" ,"AR"=>"Argentina" ,"AM"=>"Armenia" ,"AW"=>"Aruba" ,"AU"=>"Australia" ,"AT"=>"Austria" ,"AZ"=>"Azerbaijan" ,"BS"=>"Bahamas" ,"BH"=>"Bahrain" ,"BD"=>"Bangladesh" ,"BB"=>"Barbados" ,"BY"=>"Belarus" ,"BE"=>"Belgium" ,"BZ"=>"Belize" ,"BJ"=>"Benin" ,"BM"=>"Bermuda" ,"BT"=>"Bhutan" ,"BO"=>"Bolivia" ,"BA"=>"Bosnia And Herzegovina" ,"BW"=>"Botswana" ,"BV"=>"Bouvet Island" ,"BR"=>"Brazil" ,"IO"=>"British Indian Ocean Territory" ,"BN"=>"Brunei Darussalam" ,"BG"=>"Bulgaria" ,"BF"=>"Burkina Faso" ,"BI"=>"Burundi" ,"KH"=>"Cambodia" ,"CM"=>"Cameroon" ,"CV"=>"Cape Verde" ,"KY"=>"Cayman Islands" ,"CF"=>"Central African Republic" ,"TD"=>"Chad" ,"CL"=>"Chile" ,"CN"=>"China" ,"CX"=>"Christmas Island" ,"CC"=>"Cocos (Keeling) Islands" ,"CO"=>"Colombia" ,"KM"=>"Comoros" ,"CG"=>"Congo" ,"CD"=>"Congo, The Democratic Republic Of The" ,"CK"=>"Cook Islands" ,"CR"=>"Costa Rica" ,"CI"=>"Cote D'Ivoire" ,"HR"=>"Croatia" ,"CU"=>"Cuba" ,"CY"=>"Cyprus" ,"CZ"=>"Czech Republic" ,"DK"=>"Denmark" ,"DJ"=>"Djibouti" ,"DM"=>"Dominica" ,"DO"=>"Dominican Republic" ,"EC"=>"Ecuador" ,"EG"=>"Egypt" ,"SV"=>"El Salvador" ,"GQ"=>"Equatorial Guinea" ,"ER"=>"Eritrea" ,"EE"=>"Estonia" ,"ET"=>"Ethiopia" ,"FK"=>"Falkland Islands (Malvinas)" ,"FO"=>"Faroe Islands" ,"FJ"=>"Fiji" ,"FI"=>"Finland" ,"FR"=>"France" ,"GF"=>"French Guiana" ,"PF"=>"French Polynesia" ,"TF"=>"French Southern Territories" ,"GA"=>"Gabon" ,"GM"=>"Gambia" ,"GE"=>"Georgia" ,"DE"=>"Germany" ,"GH"=>"Ghana" ,"GI"=>"Gibraltar" ,"GR"=>"Greece" ,"GL"=>"Greenland" ,"GD"=>"Grenada" ,"GP"=>"Guadeloupe" ,"GU"=>"Guam" ,"GT"=>"Guatemala" ,"Gg"=>"Guernsey" ,"GN"=>"Guinea" ,"GW"=>"Guinea-Bissau" ,"GY"=>"Guyana" ,"HT"=>"Haiti" ,"HM"=>"Heard Island And Mcdonald Islands" ,"VA"=>"Holy See (Vatican City State)" ,"HN"=>"Honduras" ,"HK"=>"Hong Kong" ,"HU"=>"Hungary" ,"IS"=>"Iceland" ,"IN"=>"India" ,"ID"=>"Indonesia" ,"IR"=>"Iran, Islamic Republic Of" ,"IQ"=>"Iraq" ,"IE"=>"Ireland" ,"IM"=>"Isle Of Man" ,"IL"=>"Israel" ,"IT"=>"Italy" ,"JM"=>"Jamaica" ,"JP"=>"Japan" ,"JE"=>"Jersey" ,"JO"=>"Jordan" ,"KZ"=>"Kazakhstan" ,"KE"=>"Kenya" ,"KI"=>"Kiribati" ,"KP"=>"Korea, Democratic People'S Republic Of" ,"KR"=>"Korea, Republic Of" ,"KW"=>"Kuwait" ,"KG"=>"Kyrgyzstan" ,"LA"=>"Lao People'S Democratic Republic" ,"LV"=>"Latvia" ,"LB"=>"Lebanon" ,"LS"=>"Lesotho" ,"LR"=>"Liberia" ,"LY"=>"Libyan Arab Jamahiriya" ,"LI"=>"Liechtenstein" ,"LT"=>"Lithuania" ,"LU"=>"Luxembourg" ,"MO"=>"Macao" ,"MK"=>"Macedonia, The Former Yugoslav Republic Of" ,"MG"=>"Madagascar" ,"MW"=>"Malawi" ,"MY"=>"Malaysia" ,"MV"=>"Maldives" ,"ML"=>"Mali" ,"MT"=>"Malta" ,"MH"=>"Marshall Islands" ,"MQ"=>"Martinique" ,"MR"=>"Mauritania" ,"MU"=>"Mauritius" ,"YT"=>"Mayotte" ,"MX"=>"Mexico" ,"FM"=>"Micronesia, Federated States Of" ,"MD"=>"Moldova, Republic Of" ,"MC"=>"Monaco" ,"MN"=>"Mongolia" ,"MS"=>"Montserrat" ,"MA"=>"Morocco" ,"MZ"=>"Mozambique" ,"MM"=>"Myanmar" ,"NA"=>"Namibia" ,"NR"=>"Nauru" ,"NP"=>"Nepal" ,"NL"=>"Netherlands" ,"AN"=>"Netherlands Antilles" ,"NC"=>"New Caledonia" ,"NZ"=>"New Zealand" ,"NI"=>"Nicaragua" ,"NE"=>"Niger" ,"NG"=>"Nigeria" ,"NU"=>"Niue" ,"NF"=>"Norfolk Island" ,"MP"=>"Northern Mariana Islands" ,"NO"=>"Norway" ,"OM"=>"Oman" ,"PK"=>"Pakistan" ,"PW"=>"Palau" ,"PS"=>"Palestinian Territory, Occupied" ,"PA"=>"Panama" ,"PG"=>"Papua New Guinea" ,"PY"=>"Paraguay" ,"PE"=>"Peru" ,"PH"=>"Philippines" ,"PN"=>"Pitcairn" ,"PL"=>"Poland" ,"PT"=>"Portugal" ,"PR"=>"Puerto Rico" ,"QA"=>"Qatar" ,"RE"=>"Reunion" ,"RO"=>"Romania" ,"RU"=>"Russian Federation" ,"RW"=>"Rwanda" ,"SH"=>"Saint Helena" ,"KN"=>"Saint Kitts And Nevis" ,"LC"=>"Saint Lucia" ,"PM"=>"Saint Pierre And Miquelon" ,"VC"=>"Saint Vincent And The Grenadines" ,"WS"=>"Samoa" ,"SM"=>"San Marino" ,"ST"=>"Sao Tome And Principe" ,"SA"=>"Saudi Arabia" ,"SN"=>"Senegal" ,"CS"=>"Serbia And Montenegro" ,"SC"=>"Seychelles" ,"SL"=>"Sierra Leone" ,"SG"=>"Singapore" ,"SK"=>"Slovakia" ,"SI"=>"Slovenia" ,"SB"=>"Solomon Islands" ,"SO"=>"Somalia" ,"ZA"=>"South Africa" ,"GS"=>"South Georgia And The South Sandwich Islands" ,"ES"=>"Spain" ,"LK"=>"Sri Lanka" ,"SD"=>"Sudan" ,"SR"=>"Suriname" ,"SJ"=>"Svalbard And Jan Mayen" ,"SZ"=>"Swaziland" ,"SE"=>"Sweden" ,"CH"=>"Switzerland" ,"SY"=>"Syrian Arab Republic" ,"TW"=>"Taiwan, Province Of China" ,"TJ"=>"Tajikistan" ,"TZ"=>"Tanzania, United Republic Of" ,"TH"=>"Thailand" ,"TL"=>"Timor-Leste" ,"TG"=>"Togo" ,"TK"=>"Tokelau" ,"TO"=>"Tonga" ,"TT"=>"Trinidad And Tobago" ,"TN"=>"Tunisia" ,"TR"=>"Turkey" ,"TM"=>"Turkmenistan" ,"TC"=>"Turks And Caicos Islands" ,"TV"=>"Tuvalu" ,"UG"=>"Uganda" ,"UA"=>"Ukraine" ,"AE"=>"United Arab Emirates" ,"GB"=>"United Kingdom" ,"UM"=>"United States Minor Outlying Islands" ,"UY"=>"Uruguay" ,"UZ"=>"Uzbekistan" ,"VU"=>"Vanuatu" ,"VE"=>"Venezuela" ,"VN"=>"Viet Nam" ,"VG"=>"Virgin Islands, British" ,"VI"=>"Virgin Islands, U.S." ,"WF"=>"Wallis And Futuna" ,"EH"=>"Western Sahara" ,"YE"=>"Yemen" ,"ZM"=>"Zambia" ,"ZW"=>"Zimbabwe");
print dropdown(NULL,$this->Get_Data('member_country'), $arr_countries);
?>
</select>
						<br /><br />
						</td>
					</tr>
					<tr>
						<td class="label"><label for="member_postal_code">Postal Code</label></td>
						<td  class="inputs"><input class="text" <?=errorTextBoxHighlighter( $this->Get_Error('member_postal_code') );?> id="member_postal_code" name="member_postal_code" value="<?=$this->Get_Data('member_postal_code');?>" /></td>
					</tr>
					<tr>
						<td class="label"><label for="member_phone">Phone Number</label></td>
						<td  class="inputs"><input class="text" <?=errorTextBoxHighlighter( $this->Get_Error('member_phone') );?> id="member_phone" name="member_phone" value="<?=$this->Get_Data('member_phone');?>" /></td>
					</tr>
				</table>
	
					
					
		</fieldset>
<br />
		

		<br />
		<fieldset>
			<legend>PDF / Email Notifications</legend>
				<table>
					<tr><td class="label" colspan=2><input type="radio" name="member_preference_email_pdf" value="1" <?=is_selected('checked', $this->Get_Data('member_preference_email_pdf'), '1', true);?>/> <label for="name">I would like a PDF version of the paper sent to my email.</label> </td></tr>
					<tr><td class="label" colspan=2><input type="radio" name="member_preference_email_pdf" value="2" <?=is_selected('checked', $this->Get_Data('member_preference_email_pdf'), '2');?>/> 	 <label for="name">I would like to be notified by email when a new issue is published.</label> </td></tr>
					<tr><td class="label" colspan=2><input type="radio" name="member_preference_email_pdf" value="3" <?=is_selected('checked', $this->Get_Data('member_preference_email_pdf'), '3');?>/> 	 <label for="name">No notifications, thanks.</label> </td></tr> 
				</table>				
		</fieldset>	
	<br /><br />
		<fieldset>
			<legend>Create your password</legend>
				<table>
					<tr><td class="label"><label for="name">New Password</label></td>					<td class="inputs"><input class="text" <?=errorTextBoxHighlighter( $this->Get_Error('member_new_password_1') );?> type="password" name="member_new_password_1" value="<?=$this->Get_Data('member_new_password_1');?>" /></td></tr>
					<tr><td class="label"><label for="name">New Password (repeated)</label></td>		<td class="inputs"><input class="text" <?=errorTextBoxHighlighter( $this->Get_Error('member_new_password_2') );?> type="password" name="member_new_password_2" value="<?=$this->Get_Data('member_new_password_2');?>" /></td></tr>
				</table>				
		</fieldset>
		
	<br /><br />

		<fieldset>
				<legend>Subscription Options</legend>
					<table><tr><td class="label" colspan=2>
					
					<input type="radio" id="member_price_free" name="member_price" value="Free Trial" checked>
					<label style="font-size: 12pt;"  for="member_price_free">Four week free trial</label><br />
					<input type="checkbox" name="member_please_contact_after_trial" value="1" /> Please have someone contact me when my free trial is finished.
					
					
					</td></tr>
					</table>
		</fieldset>
	<br /><br />
	
		<fieldset>	
				<table>
					<tr><td class="tdbuttons"><!--  <div class="button_area"><input class="button_warning" type="submit" value="cancel" name="member_subscription_profile_cancel" /></div>  --><div class="button_area"><input class="button_good" type="submit" value="Continue" name="member_subscription_profile_submit" /></div></td></tr>
				</table>
		</fieldset>

</form>
