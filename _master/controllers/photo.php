<?php

/**
 *  Paragraph standards
 *  - - - - - - - - - - 
 * 1)Use on-the-fly paragraph tags:
 *	 	story_current_story_dir has an entry
 * 			AND
 *	 	story_updated is NULL
 *	 		AND
 *		story_super_section_id is present
 * 
 * 2) Edit - insert paragraph tags with ALL proper code
 * 
 * 
 */


require_once 'controllers/issue.php';
class Photo extends Issue {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Photo(){
		$this->__construct( true );
	}
	
	
	// ----------- PUBLIC EDITING FUNCTIONS --------------- \\
	
	public function addphoto(){
		if( $this->MemberAllowed( MEMBER_AUTH_LEVEL_EDITOR )){
			$this->data['story_id'] = $this->Get_URL_Element( VAR_1 );
			
			//A photo is being updated after being uploaded
			if( $this->Get('photo_id') && $this->Get('photo_name')&& $this->Get('photo_dir')  ){
				// Cutline and byline are coming in, along with story_id and photo_id.
				$this->updateStoryPhoto();
				//NEW
					// Create web ready versions of the original
						$this->resizePhotoAndSave( $this->Get('photo_dir'), $this->Get('photo_name') );
			
				$this->Redirect_URL_Wrapper();
				exit();
			}
			
			
			//A photo is begin uploaded
			if( $this->Get('submit_upload_photo') && array_key_exists( 'file', $_FILES ) && array_key_exists( 'name', $_FILES['file'] ) ){

					$this->data['photo_id'] = $this->savePhoto();
					if( $this->Get_Data('photo_id') ){
					
						$this->saveStoryPhotoAssociation($this->Get_Data('story_id'), $this->Get_Data('photo_id') );
						$this->Set_Template( 'output', 'page/uploaded_photo_splash.php' );
					}
			} else {
				$this->Set_Template( 'output', 'page/addphoto.php' );	
			}
			
			
			//Default
				
				$this->Set_Common_Templates();
				$this->Output_Page();
			
		} else {
			$this->toPreviousPage();
		}
	}
	
	
	
	
	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\
	
	private function updateStoryPhoto(){
		// Cutline passed - update join table	
		if( $this->Get('cutline') ) {
			$sql = "update `join-photo-story` set `join-photo-story_cutline`=". $this->dbReady( $this->Get('cutline') , true);
			$sql .= " where `join-photo-story_story_id`=".$this->dbReady($this->Get('story_id'), true);
			$sql .= " and `join-photo-story_photo_id`=".$this->dbReady($this->Get('photo_id'), true);
			
			$this->Execute( $sql );
		}
		// Byline passed - update photo table
		if( $this->Get('byline') ) {
			$sql = "update photo set photo_byline=". $this->dbReady( $this->Get('byline') , true);
			$sql .= " where photo_id=".$this->dbReady($this->Get('photo_id'), true);
	
			$this->Execute( $sql );
		}
		
	}
	
	
	private function saveStoryPhotoAssociation( $story_id, $photo_id ){
		$sql = "INSERT into `join-photo-story` (`join-photo-story_photo_id`,`join-photo-story_story_id`,`join-photo-story_order`,`join-photo-story_cutline`)";
		$sql .= " values (";
		$sql .= $this->dbReady($photo_id);
		$sql .= $this->dbReady($story_id);
		$sql .= $this->dbReady(NULL);
		$sql .= $this->dbReady(NULL, true);
		$sql .= ")";
		
		$this->Execute($sql);
	}
	
	private function savePhoto( $file_name_reference = 'file' ) {
		// Is there a file?
		if( array_key_exists( $file_name_reference, $_FILES ) ) {

			// Does a directory exist? Make it if not
			$upload_dir = DIRECTORY_PHOTOS.'/'.date('Y').'/'. strtolower( date('F') );
			$view_dir = URL_PHOTOS_DIR.'/'.date('Y').'/'. strtolower( date('F') );
			if( !file_exists( $upload_dir ) ) {
				mkdir( $upload_dir, 0777, 1 );
			}
			
			// Is there a duplicate on the server? Add a distinct filename
			if( file_exists( $upload_dir . '/' . $this->cleanedUpFileName( $_FILES['file']['name'] ) ) ){
				$clean_file_name = mktime(). $this->cleanedUpFileName( $_FILES['file']['name'] );
			} else {
				$clean_file_name = $this->cleanedUpFileName( $_FILES['file']['name'] );
			}
			
	
			// Refer to them after for the form
			$this->data['photo_dir'] 		= $upload_dir;
			$this->data['photo_name'] 		= $clean_file_name;
			
			// Store the file on the server
			if( move_uploaded_file(  $_FILES['file']['tmp_name'], $upload_dir . '/'. $clean_file_name  ) ){
				chmod( $upload_dir . '/'. $clean_file_name, 0644);
				$this->data['new_photo_data'] = getimagesize( $upload_dir . '/'. $clean_file_name );
				$this->data['new_photo_path_and_name'] = $view_dir . '/'. $clean_file_name;
			}
			

			
			// Save it in the database now
			$sql = "INSERT into photo (photo_file_name, photo_description,photo_inserted_year,photo_inserted_month,photo_byline,photo_tags)";
			$sql .= " values (";
			$sql .= $this->dbReady($clean_file_name);
			$sql .= $this->dbReady(NULL);
			$sql .= $this->dbReady(date('Y'));
			$sql .= $this->dbReady(strtolower( date('F') ) );
			$sql .= $this->dbReady(NULL);
			$sql .= $this->dbReady(NULL, true);
			$sql .= ")";
			
			$res = $this->Execute( $sql );
			
			if( $res ){
				return mysql_insert_id();
			}
		}

		
	}
	
	/** 
	  * resizePhotoAndSave will take in a path and file name and resize the photo into the three versions
	  * used by the system (sizes are in the constants file) - small, medium and large.
	  * 
	  */
	private function resizePhotoAndSave( $path, $file_name ){
	
		// Consider the first one coming in as the largest image.
		// If the image is cropped bigger than LARGE, resize it to large
			$new_y 	= $this->Get('photo_crop_top');
			$new_x 	= $this->Get('photo_crop_left');
			$new_ht = $this->Get('photo_crop_height');
			$new_wt = $this->Get('photo_crop_width');
		
		// Resample
			$image_new 	= imagecreatetruecolor( SIZE_LARGE, SIZE_LARGE );
			$image 		= imagecreatefromjpeg( $path . '/'. $file_name );
			imagecopyresampled($image_new, $image,  0, 0, $new_x, $new_y, SIZE_LARGE, SIZE_LARGE, $new_wt, $new_ht);
			imagejpeg($image_new, $path . '/'. LARGE . $file_name, 100);
			$source_file_name = LARGE . $file_name;
			$source_file_path = $path;
			
		// Each of the sizes
			$arr_sizes = array(SIZE_SMALL=>SMALL, SIZE_MEDIUM=>MEDIUM );
			list($width, $height) = getimagesize($path . '/'. $file_name );
	
		foreach( $arr_sizes as $size=>$tag ){
			// Resample
			$image_new 	= imagecreatetruecolor( $size, $size );
			$image 		= imagecreatefromjpeg( $source_file_path . '/'. $source_file_name );
			imagecopyresampled($image_new, $image,  0, 0, 0, 0, $size, $size, SIZE_LARGE, SIZE_LARGE);
						
			// Output
			imagejpeg($image_new, $source_file_path . '/'. $tag . $file_name, 100);	
		}
	}
	
	
	private function backup_oldresize(){
		// Take care of the other two sizes based on the cropped large image
		$arr_sizes = array(SIZE_SMALL=>SMALL, SIZE_MEDIUM=>MEDIUM, SIZE_LARGE=>LARGE);
		list($width, $height) = getimagesize($path . '/'. $file_name );
		
		/*
		 * At this point there are x,y and h,w dimensions coming in on the POST train, man.
		 * Use these to crop the photo down, then resize the square for each of the sizes
		 */		
		foreach( $arr_sizes as $size=>$tag ){
		
			// Calculate the new sizes
			/// $percent_change 	= ( $landscape )? $size / $width: $size / $height;
			$new_width			= $width;
			$new_height			= $height;
		
			
			// Resample
			$image_p 	= imagecreatetruecolor($new_width, $new_height);
			$image 		= imagecreatefromjpeg($path . '/'. $file_name);
			imagecopyresampled($image_p, $image,  0, 0, $this->Get('photo_crop_top'), $this->Get('photo_crop_left'), $new_width, $new_height, $width, $height);
			
			// Output
			imagejpeg($image_p, $path . '/'. $tag . $file_name, 100);	
		}
			
			
		
		/*
			// Is it landscape or vertical?
			if( $width < $height ){
				$landscape=false;
			} else {
				$landscape=true;
			}
			
			foreach( $arr_sizes as $size=>$tag){
			
				// Calculate the new sizes
				$percent_change 	= ( $landscape )? $size / $width: $size / $height;
				$new_width			= ( $landscape )? $size : $width * $percent_change;
				$new_height			= ( $landscape )? $height * $percent_change : $size;
			
				
				// Resample
				$image_p 	= imagecreatetruecolor($new_width, $new_height);
				$image 		= imagecreatefromjpeg($path . '/'. $file_name);
				imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
				
				// Output
				imagejpeg($image_p, $path . '/'. $tag . $file_name, 100);	
			}
		*/
		
	}
	
	
	private function cleanedUpFileName( $file_name ){
		$file_name = str_replace(' ','-', $file_name );
		$file_name = str_replace(';','-', $file_name );
		$file_name = strtolower( $file_name );
		$file_name = str_replace('.jpeg','.jpg', $file_name);
		return $file_name;
	}

	

}
?>