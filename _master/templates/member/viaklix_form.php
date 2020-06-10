<? //Loaded for processing ?>
<body onLoad="document.forms[0].submit()">
<form action="https://www.viaKLIX.com/process.asp" method="POST" name="viaform">
	<!-- <input type="hidden" name="ssl_test_mode" value="TRUE"> --><!-- COMMENT OUT FOR ACTIVE PROCESSING-->
	<input type="hidden" name="ssl_show_form" value="FALSE">
	<input type="hidden" name="ssl_cvv2" value="bypassed">
	<input type="hidden" name="ssl_merchant_id" value="406713">
	<input type="hidden" name="ssl_user_id" value="WEBORDER">
	<input type="hidden" name="ssl_pin" value="MZDQDM">
	<input type="hidden" name="ssl_result_format" value="HTML">
	<input type="hidden" name="ssl_receipt_link_method" value="REDG">
	<input type="hidden" name="ssl_receipt_link_url" value="<?=SERVER_URL?>/member/subscriptionProcessResult/" >

	<input type="hidden" name="ssl_amount" value="<?=$this->Get_Data('ssl_amount');?>"> 
	<input type="hidden" name="ssl_description" value="<?=$this->Get_Data('ssl_description');?>"> 
	<input type="hidden" name="ssl_company" value="<?=$this->Get_Data('ssl_company');?>"> 
	<input type="hidden" name="ssl_first_name" value="<?=$this->Get_Data('ssl_first_name');?>"> 
	<input type="hidden" name="ssl_last_name" value="<?=$this->Get_Data('ssl_last_name');?>"> 
	<input type="hidden" name="ssl_email" value="<?=$this->Get_Data('ssl_email');?>"> 
	<input type="hidden" name="ssl_phone" value="<?=$this->Get_Data('ssl_phone');?>"> 
	<input type="hidden" name="ssl_city" value="<?=$this->Get_Data('ssl_city');?>"> 
	<input type="hidden" name="ssl_country" value="<?=$this->Get_Data('ssl_country');?>"> 
	<input type="hidden" name="ssl_state" value="<?=$this->Get_Data('ssl_state');?>"> 
	<input type="hidden" name="ssl_avs_address" value="<?=$this->Get_Data('ssl_avs_address');?>"> 
	<input type="hidden" name="ssl_address2" value="<?=$this->Get_Data('ssl_address2');?>"> 
	<input type="hidden" name="ssl_avs_zip" value="<?=$this->Get_Data('member_postal_code');?>"> 
	<input type="hidden" name="ssl_card_number" value="<?=$this->Get_Data('ssl_card_number');?>">
	<input type="hidden" name="ssl_exp_date" value="<?=$this->Get_Data('ssl_exp_date');?>">
	<input type="hidden" name="ssl_invoice_number" value="<?=$this->Get_Data('ssl_invoice_number');?>">
</form>
</body>