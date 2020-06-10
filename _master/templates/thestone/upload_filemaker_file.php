<div class="gradient_background">
<div class="breadcrumb"><a href="/thestone/users">Users</a> &raquo;
<h2>    Upload <img src="/site/images/thestone/filemaker.gif" border=0 /> User File </h2>
<?
print $this->Get_Data('messages');
print $this->Get_Data('errors');
?>
<form action="" enctype="multipart/form-data" method="POST">
<p>Select the file you wish to replenish the web database</p>
	<input type="file" name="file" />
	<input class="button_good" type="submit" name="submit_upload_filemaker_file" value="Upload your file">
</form>
</div>
