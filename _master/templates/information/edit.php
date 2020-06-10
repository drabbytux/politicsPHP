<? include( FILE_FCKEDITOR ); ?>
<? include( FILE_YAHOO_CALENDAR ); ?>
<form id="pageform" action="/information/save/<?=$this->Get_URL_Element( VAR_1 );?>" method="POST">
<br />
<div id="calendarContainer"></div>

<?
	$oFCKeditor 				= new FCKeditor('information_page_content');
	$oFCKeditor->BasePath		= '/site/system/fckeditor/';
	$oFCKeditor->ToolbarSet 	= 'Hilltimes';
	$oFCKeditor->Value			= $this->Get_Data('information_page_content');
	$oFCKeditor->Height 		= '450';
	$oFCKeditor->Width 			= '680';
	$oFCKeditor->Create();

?>

<h4>Page Title</h4>
<input name="information_page_name" style="width: 680px;"  type="text" value="<?=$this->Get_Data('information_page_name');?>" />

<h4>Page Linking Name (one word prefered, no spaces)</h4>
<input name="information_page_link_name" style="width: 680px; "  type="text" value="<?=$this->Get_Data('information_page_link_name');?>" />

<h4>Tags</h4>
<input name="information_page_tags" style="width: 680px; "  type="text" value="<?=$this->Get_Data('information_page_tags');?>" />

<br />
<input class="button_warning" type="button" value="cancel" onClick="submitForm(\'pageform\',\'/information/cancel/<?=$this->Get_URL_Element( VAR_1 )?>">
<input class="button_good" type="submit" value="save" >
</form>


<div style="clear:both" ></div>

