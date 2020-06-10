<? include( FILE_FCKEDITOR ); ?>

<br /><form action="" method="post">

	<fieldset>
	<legend>Editing story <?=($this->Get_Data('EDIT_story_id') )? '(ID: '.$this->Get_Data('EDIT_story_id').')': NULL; ?></legend>
		<div class="buttons" style="text-align: left;"><input type="submit" name="EDIT_cancel" value="cancel" /> &nbsp; <input type="submit" name="EDIT_save" value="save" /></div>
	
		<table width="100%">
			<tr>
				<td class="medium">
					
					<div class="editheading">Heading</div>
					<textarea class="long" name="EDIT_story_title"><?=$this->Get_Data('EDIT_story_title');?></textarea>
					<br />
					<div class="editheading">Kicker</div><textarea class="long" name="EDIT_story_kicker" ><?=$this->Get_Data('EDIT_story_kicker');?></textarea>

					<div class="editheading">Story </div>
					<?
						$oFCKeditor 				= new FCKeditor('EDIT_story_content');
						$oFCKeditor->ToolbarSet 	= 'Hilltimes';
						$oFCKeditor->Value			= $this->Get_Data('EDIT_story_content');
						$oFCKeditor->Height 		= '450';
						$oFCKeditor->Width 			= '560';
						$oFCKeditor->Create();
					?>
				</td>
				
				<td  class="small">
					<div class="editheading">Section ( <a href="#" id="tooltip_section" onClick="return false;">add new</a> )</div>
						<select name="EDIT_section">
							<?
								if( is_array($this->Get_Data('section_list') ) ) {
									foreach( $this->Get_Data('section_list') as $sect ) {
										$selected = ($sect['section_id'] == $this->Get('EDIT_section') )? ' selected': NULL;
										print '<option value="'. $sect['section_id'].'" '.$selected.'>'. $sect['section_title'] ."</option>";
									}
								}
							?>
						</select>
					
					<div id="tooltip_section_list" class="tooltipcontent">
						<input type="text" value=""  name="new_section" /> <input type="submit" name="EDIT_submit_new_section" value="Add New Section" />
					</div>
				<br />
					<div class="editheading">Tags / Keywords</div>
						<form style="vertical-align: middle;">
							<div id="tagMasterDiv" class="container">
							   <input type="text" name="EDIT_tag_item" />
							   <input type="submit" name="EDIT_submit_tag" value="add" />
							   <div id="tagListDiv" spry:region="tagXML">
							   		<span spry:repeat="tagXML" spry:suggest="{name}">{name}<br /></span>
							   </div>
							   <?
							   	if( is_array( $this->Get_Data('tag_added_list') ) ) {
							   		foreach( $this->Get_Data('tag_added_list') as $tagkey=>$tagval ){
							   			print $tagval . "<br />\n";
							   		}
							   	}
							   ?>
							</div>
						</form>
				<br />
					<div class="editheading">Authors ( <a href="#" id="tooltip_author" onClick="return false;">add</a> )</div>
					<div id="tooltip_author_list" class="tooltipcontent">
						<select name="EDIT_author_list">
							<?
								if( is_array($this->Get_Data('author_list') ) ) {
									foreach( $this->Get_Data('author_list') as $auth ) {
										$selected = ($auth['author_id'] == $this->Get('EDIT_author_list') )? ' selected': NULL;
										print '<option value="'. $auth['author_name'].'"'.$selected.'>'. $auth['author_name'] ."</option>";
										// $auth['author_id']
									}
								}
							?>
						</select>
						<br />
						<input type="text" value=""  name="EDIT_new_author" />
						<br />
						<input type="submit" name="EDIT_submit_author" value="Add Author" />

					</div>
					<div id="authorlistdiv">
						<table width="100%">
						
						
						<?
						   	if( is_array( $this->Get_Data('author_added_list') ) ) {
						   		foreach( $this->Get_Data('author_added_list') as $authkey=>$authval ){
						   			print '<tr><td>'. $authval . '</td><td style="text-align: right;"><input type="button" name="remove_author_'.$authval .'" value="remove" /></td></tr>'."\n";
						   		}
						   	}
						?>
			
							
						</table>
					</div>
					
					
					<br />
					<div class="editheading">Photos  ( <a href="#" id="tooltip_photo" onClick="return false;">add</a> )</div>
					<div id="photo_clips">
						<div style="text-align: right;background-color: #000; border: 1px black solid;">
							<img src="/site/photos/2008/23_John-Baird-5737.jpg" /><br />
							<input type="button" name="photo_replace" value="replace" /><input type="button" name="photo_remove" value="delete" />
						</div>
					</div>
					
					<div id="tooltip_photo_list" class="tooltipcontent">
						<form>
							<input type="file" name="newimage" />
							<br />
							<input type="submit" name="uploadimage" value="Upload New Photo">
						</form>
					</div>
				</td>
			</tr>
			</table>

		

		<? // Save Buttons  ?>
		
	</fieldset>
	<div class="buttons"><input type="submit" name="EDIT_cancel" value="cancel" /> &nbsp; <input type="submit" name="EDIT_save" value="save" /></div>
	
	
</form>


<? // Tool Tip / Pop Ups ?>
<script type="text/javascript">

 var sectionList = new Spry.Widget.Tooltip('tooltip_section_list', '#tooltip_section', {useEffect: 'Fade', hideDelay: 1500, closeOnTooltipLeave: true, offsetX: "10px", offsetY:"-10px"});
 // var tagList = new Spry.Widget.Tooltip('tooltip_tag_list', '#tooltip_tag', {useEffect: 'Fade', hideDelay: 1500, closeOnTooltipLeave: true, offsetX: "10px", offsetY:"-10px"}); */
 var authorList = new Spry.Widget.Tooltip('tooltip_author_list', '#tooltip_author', {useEffect: 'Fade', hideDelay: 1500, closeOnTooltipLeave: true, offsetX: "10px", offsetY:"-10px"});
 var photoList = new Spry.Widget.Tooltip('tooltip_photo_list', '#tooltip_photo', {useEffect: 'Fade', hideDelay: 1500, closeOnTooltipLeave: true, offsetX: "10px", offsetY:"-10px"}); 

</script>
<? // Auto Suggest ?>
<script type="text/javascript">
	<? /* Tags */ ?>
	var tagXML = new Spry.Data.XMLDataSet("/xml/tags", "/tags/tag", { sortOnLoad: "name" });
	var suggesttags = new Spry.Widget.AutoSuggest('tagMasterDiv', 'tagListDiv', 'tagXML','name');
</script>




