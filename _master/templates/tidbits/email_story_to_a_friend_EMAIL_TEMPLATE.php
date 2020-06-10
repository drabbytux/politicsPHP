<?
	/**
	 * Used as the email for sending out the "Send to a Friend" message
	 */
?>You have been sent this story from <?=$this->Get('email_story_email_from');?>:

<?=$this->Get_Data('email_story_message');?>


<?=strip_tags( $this->Get_Data('story_title') );?>

<?=SERVER_URL;?>/page/view/<?=$this->Get_Data('story_url_id');?>


----------------------------------------
<?=DEFAULT_TITLE;?>

http://www.<?=DOMAIN;?>/

Subscribe: http://<?=DOMAIN;?>/subscribe