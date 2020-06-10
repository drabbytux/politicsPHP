<form method="POST" action="" name="photoform" id="photoform">
	<h2>New Photo Uploaded</h2>
	<?
	if( $this->Get_Data('new_photo_path_and_name')){ ?>
	
		<? include( $_SERVER['DOCUMENT_ROOT']. '/site/system/yui_imagecropper_init.php'); ?>
		
		
		<div class="yui-skin-sam">
		<img src="<?=$this->Get_Data('new_photo_path_and_name');?>" id="new_photo" <?=$this->Get_Data('new_photo_data', 3);?> />
			<script>
	
			    var Dom = YAHOO.util.Dom, Event = YAHOO.util.Event;
			    
			    var cropImg = new YAHOO.widget.ImageCropper('new_photo', { initialXY: [10, 10],
			        initHeight: ( <?=SIZE_LARGE;?> ),
			    	initWidth: ( <?=SIZE_LARGE;?> ),       
			        keyTick: 5,
			        ratio: true,
			        shiftKeyTick: 50
			    });	    
	
	
				 function postTheNewImageSize() {
				 	var cropArea = cropImg.getCropCoords(); 
				 	document.getElementById('photo_crop_top').value 	= cropArea.top;
				 	document.getElementById('photo_crop_left').value 	= cropArea.left;
				 	document.getElementById('photo_crop_height').value 	= cropArea.height;
				 	document.getElementById('photo_crop_width').value 	= cropArea.width; 
				 	
				 	document.photoform.submit();
				 }
			
			</script>
		
		</div>
	
	<? } ?>
	
	<p>Cutine:<br />
		<textarea  class="text" name="cutline"></textarea>
	<p>By Line:<br />
		<input class="text" type="text" name="byline" />
	</p>
		<input type="hidden" name="photo_id" value="<?=$this->Get_Data('photo_id');?>" />
		<input type="hidden" name="photo_name" value="<?=$this->Get_Data('photo_name');?>" />
		<input type="hidden" name="photo_dir" value="<?=$this->Get_Data('photo_dir');?>" />
		<input type="hidden" name="story_id" value="<?=$this->Get_Data('story_id');?>" />
		
		<input type="hidden" id="photo_crop_top" name="photo_crop_top" value="" />
		<input type="hidden" id="photo_crop_left" name="photo_crop_left" value="" />
		<input type="hidden" id="photo_crop_height" name="photo_crop_height" value="" />
		<input type="hidden" id="photo_crop_width" name="photo_crop_width" value="" />
		
		<input type="button" name="submit_save_uploaded_photo_details" value="Save" onClick="postTheNewImageSize();">
</form>