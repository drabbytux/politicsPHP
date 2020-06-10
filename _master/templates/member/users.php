<?$this->setUserStats(); ?>
<div class="gradient_background">
<h2>User Management</h2>
<?
print $this->Get_Data('messages');
print $this->Get_Data('errors');
?>
<fieldset><legend>Stats and Frats</legend>
<strong>Total Members: </strong><?=$this->get_data('stats_total_members');?> &nbsp; &nbsp; &nbsp; &nbsp;
<strong>Total LIVE Members: </strong><?=$this->get_data('stats_live_members');?>

</fieldset>

<fieldset><legend>Functions</legend>
<form action="/thestone/mailout" method="POST"><input type="submit" name="submit_mailout_default" value="Start an Issue Mailout" /></form>


</fieldset>

<fieldset><legend><img src="/site/images/thestone/filemaker.gif" border=0 /> </legend>
Upload latest Filemaker User data
<form action="/thestone/uploadFileMaker" enctype="multipart/form-data" method="POST">
<p>Select the file you wish to replenish the web database</p>
	<input type="file" name="file" />
	<input class="button_good" type="submit" name="submit_upload_filemaker_file" value="Upload your file">
</form>
</fieldset>
</div>