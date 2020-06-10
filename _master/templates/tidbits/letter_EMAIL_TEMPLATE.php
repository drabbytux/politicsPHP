<?
	/**
	 * Used as the email for sending out the "Letter" message
	 */
?>A letter has been submitted to the Editor in regards to:

<?=$this->Get_Data('story_title');?>

<?=SERVER_URL;?>/page/view/<?=$this->Get_Data('story_url_id');?>


--------------------------------------------------------------------------

<?=$this->Get_Data('letter_letter');?>


--------------------------------------------------------------------------


/```````````````````````````````````````````````````
| DETAILS
| Name: <?=$this->Get('letter_name');?>

| Email: <?=$this->Get('letter_email');?>

| City: <?=$this->Get('letter_city');?>

| Prov: <?=$this->Get('letter_prov');?>

| Phone: <?=$this->Get('letter_phone');?>

| Postion: <?=$this->Get('letter_position');?>

| IP Address: <?=$_SERVER['REMOTE_ADDR'];?>

\___________________________________________________