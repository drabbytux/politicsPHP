<?php
// advertise_email_response.php
?>
An online advertising request has been filled out for <?=NEWSPAPER_NAME;?>.
<?=date('l, F nS - g:iA')?>.
-------------------------- 

Name: <?=$this->Get('adv_name');?>

Email: <?=$this->Get('adv_email');?>

<? if( $this->Get('adv_company') ) {?>Company: <?=$this->Get('adv_company') . "\r\n";?><?} ?>
<? if( $this->Get('adv_type_business') ) {?>Type of Business: <?=$this->Get('adv_type_business') . "\r\n"; } ?>
<? if( $this->Get('adv_position') ) {?>Position: <?=$this->Get('adv_position') . "\r\n";?><?} ?>	
Phone: <?=$this->Get('adv_phone');?> 

<? if( $this->Get('adv_fax') ) {?>Fax: <?=$this->Get('adv_fax') . "\r\n";?><?} ?>
Address: <?=$this->Get('adv_address');?>

City: <?=$this->Get('adv_city');?>

Prov/State: <?=$this->Get('adv_prov');?>

Postal Code/Zip: <?=$this->Get('adv_postal');?>	

---Extra Details---

Please send me The Hill Times Rate Card By <?=$this->Get('adv_further_contact');?>

<? if( $this->Get('adv_further_contact2') ) {?>Please mail me a complete media kit including rate card information.<?; print "\r\n"; } ?>
<? if( $this->Get('adv_further_contact3') ) {?>Please call me at your earliest convenience.<?; print "\r\n"; } ?>
	
-------------------------- 