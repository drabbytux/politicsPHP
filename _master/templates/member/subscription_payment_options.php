<?php

?>
<h2 style="padding: 2px;vertical-align: middle;"><img src="/site/images/icons/ssl-lock.jpg" style="vertical-align: center;" />Step 3 of 4 - Fill in your Payment Details</h2>
<form method="POST" name="form_viaklix" id="form_viaklix" action="/member/subscriptionProcess"> <?//action="https://www.viaKLIX.com/process.asp"  // /member/ajaxResponseViaKlixResponse ?>
				
<div id="simpleform">
<?=$this->Get_Session('messages');?>
<?=$this->Get_Session('errors');?>


	<div id="response_ajax_viaklix">
		<fieldset>
			<legend>Delivery Information</legend>
				
				<h3 style="font-family: courier; font-weight: bold; font-size: 14pt; ">
				<?
	/**
	 * Name
	 * street
	 * city, prov
	 * postal
	 * 
	 * email address
	 */
				print $this->Get_Session('member_name_first') . " " . $this->Get_Session('member_name_last') . "<br />";
				print ( $this->Get_Session('member_street_address_1'))? $this->Get_Session('member_street_address_1') . "<br />": NULL;
				print ( $this->Get_Session('member_street_address_2'))? $this->Get_Session('member_street_address_2') . "<br />": NULL;
				print ( $this->Get_Session('member_city'))? $this->Get_Session('member_city'): NULL;
				print ( $this->Get_Session('member_province'))? ", ". $this->Get_Session('member_province') . "<br />" : NULL;
				print $this->Get_Session('member_postal_code') . "<br />";
				
				print "<br />". $this->Get_Session('member_email') . "<br />";
				?>			 
				</h3>
			
			
		</fieldset>
		<br /><br />
		
	<input type="hidden" name="ssl_amount" value="<?=$this->getSubscriptionInfo( $this->Get_Session('member_price'), 'subscription_prices_price' );?>"> 
	<input type="hidden" name="ssl_description" value="<?=$this->getSubscriptionInfo( $this->Get_Session('member_price'), 'subscription_prices_description' );?>, <?=$this->getSubscriptionInfo( $this->Get_Session('member_price'), 'subscription_group_description' );?>">
	<input type="hidden" name="ssl_company" value="<?=$this->Get_Session('member_company');?>">
	<input type="hidden" name="ssl_first_name" value="<?=$this->Get_Session('member_name_first');?>">
	<input type="hidden" name="ssl_last_name" value="<?=$this->Get_Session('member_name_last');?>">
	<input type="hidden" name="ssl_email" value="<?=$this->Get_Session('member_email');?>"> 
	<input type="hidden" name="ssl_phone" value="<?=$this->Get_Session('member_phone');?>"> 
	<input type="hidden" name="ssl_city" value="<?=$this->Get_Session('member_city');?>"> 
	<input type="hidden" name="ssl_country" value="<?=$this->Get_Session('member_country');?>"> 
	<input type="hidden" name="ssl_state" value="<?=$this->Get_Session('member_province');?>"> 
	<input type="hidden" name="ssl_avs_address" value="<?=$this->Get_Session('ssl_avs_address');?>"> 
	<input type="hidden" name="ssl_address2" value="<?=$this->Get_Session('ssl_address2');?>"> 
	<input type="hidden" name="ssl_avs_zip" value="<?=$this->Get_Session('ssl_avs_zip');?>"> 
	<input type="hidden" name="ssl_invoice_number" value="<?=$this->Get_Session('ssl_invoice_number');?>">

<?

/*
 *             [subscription_prices_id] => 1
            [subscription_prices_price] => 179
            [subscription_prices_description] => 1 year/50 issues
            [subscription_prices_group_id] => 1
            [subscription_group_id] => 1
            [subscription_group_title] => canada
            [subscription_group_description] => Canadian Subscription, Print Edition (includes electronic edition)
        )
 * 
 */
?>

		<fieldset>
			<legend>Price</legend>
				<table style="width: 100%;">
				<tr>
					<td style="text-align: left;"><?=$this->getSubscriptionInfo( $this->Get_Session('member_price'), 'subscription_prices_description' );?><br /><?=$this->getSubscriptionInfo( $this->Get_Session('member_price'), 'subscription_group_description' );?> to <?=$this->getSubscriptionInfo( $this->Get_Session('member_price'), 'subscription_paper_name' );?></td>
					<td style="text-align: right;">$<?=$this->getSubscriptionInfo( $this->Get_Session('member_price'), 'subscription_prices_price' );?>.00</td>
				</tr>
					<tr>
						<td style="text-align: left;border-top: 1px #333 solid;">&nbsp;</td>
						<td style="text-align: right;font-weight: bold;border-top: 1px #333 solid;">Total: $<?=$this->getSubscriptionInfo( $this->Get_Session('member_price'), 'subscription_prices_price' );?>.00</td>
					</tr>			
				</table>	
			
		</fieldset>
		
		<br /><br />
<fieldset>
			<legend>Payment</legend>
			<?=$this->Get_Data('errors');?>
								<table style="width: 100%;">
				<tr>
					<td style="text-align: left; width: 70%;padding: 4px; background-color: #eee;"><!-- <input type="radio" name="payment_type" value="credit_card" <?=is_selected('checked', $this->Get_Session('payment_type'), 'credit_card', true);?>>  -->By Credit Card</td>
					<td style="padding: 0px 4px; font-weight: bold;"> or </td>
					<td style="text-align: left; width: 30%;padding: 4px; background-color: #ddd;"><!-- <input type="radio" name="payment_type" value="invoice" <?=is_selected('checked', $this->Get_Session('payment_type'), 'billing');?>> -->By Billing</td>
				</tr>
				<tr>
					<td style="text-align: left; width: 70%; vertical-align: top;">
					
						<input type="radio" name="ssl_payment_card_type" value="visa" <?=is_selected('checked', $this->Get_Session('ssl_payment_card_type'), 'visa', true);?> /><img src="/site/images/logos/visa.jpg" alt="Visa" style="width: 60px;" />
						&nbsp; &nbsp; <input type="radio" name="ssl_payment_card_type" value="mastercard" <?=is_selected('checked', $this->Get_Session('ssl_payment_card_type'), 'mastercard');?> /><img src="/site/images/logos/mastercard.jpg" alt="Master Card" style="width: 60px;" />
						&nbsp; &nbsp; <input type="radio" name="ssl_payment_card_type" value="amex" <?=is_selected('checked', $this->Get_Session('ssl_payment_card_type'), 'amex');?> /><img src="/site/images/logos/american-express.jpg" alt="American Express" style="width: 60px;" />
						
						<table style="width: 100%;">
							<tr>
								<td>Card Number</td><td><input type="text" name="ssl_card_number" id="ssl_card_number" value="<?=$this->Get_Session('ssl_card_number'); ?>" /></td>
							</tr>
							<tr>
								<td>Card Expiry</td><td><input style="width: 60px;" type="text" name="ssl_exp_date" id="ssl_exp_date" value="<?=$this->Get_Session('ssl_exp_date'); ?>" /></td>
							</tr>
						</table>
						
					</td>
					<td></td>
					<td style="text-align: left; width: 30%;font-size: 9pt;">The Hill Times/Embassy will bill you for subscription orders. Invoices are payable by cheque or credit card (Visa, MasterCard or American Express).
					<br /><input type="checkbox" onclick="shadeOutCrediCardInfo();" name="send_invoice" value="1"> Send me an invoice</td>
				</tr>	
				</table>
			
			
		</fieldset>
		<fieldset>	
				<table>
					<tr><td class="tdbuttons"><!--  <div class="button_area"><input class="button_warning" type="submit" value="cancel" name="cancel" /></div> --> <div class="button_area"><input class="button_good" type="submit" value="Submit Details and Finish" name="member_update_password_submit" /></div></td></tr>
				</table>
		</fieldset>	
		
	
	</div>
</div>
</form>