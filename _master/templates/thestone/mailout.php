<? include( FILE_FCKEDITOR ); ?>

<h2>Issue Mailout</h2>

<form method="post" action="/thestone/processMailout" >

<?
	$oFCKeditor 						= new FCKeditor('email_content');
	$oFCKeditor->ToolbarSet 	= 'Hilltimes';
	$oFCKeditor->Value			= $this->Get_Data('email_content');
	$oFCKeditor->Height 			= '450';
	$oFCKeditor->Width 			= '800';
	$oFCKeditor->Create();
?>
	
	<input value="submit" name="submit_send_email_test" type="submit" />

</form>