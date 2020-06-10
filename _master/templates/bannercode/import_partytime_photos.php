<?



require_once( $_SERVER['DOCUMENT_ROOT'].'/_master/configs/config.php');
require_once( $_SERVER['DOCUMENT_ROOT'].'/_master/classes/database.class.php');
$message = NULL;
define('STORY_FOLDER_DIR', $_SERVER['DOCUMENT_ROOT']. '/EM' );


// $folders = array('2007');
$folders = array('2006','2007','2008');

function createFolderStructureArray($folders) {
	
	global $message;
	$db = new Database();


	// Get each year folder
	foreach( $folders as $year_dir) {
		$x=0;
		
		// Get the months folder
		$arr_months = getDirectory( STORY_FOLDER_DIR .'/'.$year_dir );
		
		foreach ($arr_months as $month_folder ){
			$arr_days = getDirectory( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder );
			
			if( is_array( $arr_days ) ) {
				foreach( $arr_days as $day ){
					if( file_exists( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day .'/party_time' ) )  { // Is there a party Time? Yes? Good.
				
						$arr_story_folders_and_files = getDirectory( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day . '/party_time', true );
						if( is_array( $arr_story_folders_and_files ) ) {	// There are parties!
							foreach( $arr_story_folders_and_files as $party ){
								$arr_folders_containing_images = getDirectory( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day . '/party_time/'. $party, true );
								if( is_array( $arr_folders_containing_images ) ){ // There are photo folders!
									foreach( $arr_folders_containing_images as $photo_folder ){
										$arr_images = getDirectory( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day . '/party_time/'. $party . '/'. $photo_folder, true, true );
										
										// We have an array of image names!
										if( is_array($arr_images ) ) {
											foreacH( $arr_images as $image ) {
												$bn_image = NULL;
												// Does a directory exist? Make it if not
												$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/EM/partytime/'.$year_dir.'/'. $month_folder.'/'. $day ;
												$view_dir = '/EM/partytime/'.$year_dir.'/'. $month_folder.'/'. $day ;
												if( !file_exists( $upload_dir ) ) {
													mkdir( $upload_dir, 0777, 1 );
												}									
							
												// Store the file on the server
												$bn_image = file_get_contents(STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day . '/party_time/'. $party . '/'. $photo_folder .'/'. $image);
												if( $bn_image ){
													file_put_contents($upload_dir .'/'. $image, $bn_image );
													chmod( $upload_dir .'/'. $image, 0644);
												}
												
												// Make and store a thumbnail too!
													
		
													list($width, $height) = getimagesize( $upload_dir .'/'. $image );
													
													// Is it landscape or vertical?
													if( $width < $height ){
														$landscape=false;
													} else {
														$landscape=true;
													}
													
													$size=80;
													// Calculate the new sizes
													$percent_change 	= ( $landscape )? $size / $width: $size / $height;
													$new_width			= ( $landscape )? $size : $width * $percent_change;
													$new_height			= ( $landscape )? $height * $percent_change : $size;
												
													
													// Resample
													$image_p 		= imagecreatetruecolor($new_width, $new_height);
													$image_thumb 	= imagecreatefromjpeg($upload_dir .'/'. $image);
													imagecopyresampled($image_p, $image_thumb, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
													
													// Output
													imagejpeg($image_p, $upload_dir .'/th-'. $image, 100);
											
												// I think we're all done. Let me know everything is good
												 print $upload_dir .'/'. $image . " has been created<br />";
											}
										}
									}
								}
							}
						}
					}
				}
			}
			
		}
	}

	 
	$message = "Script Compete. $x records inserted.";
}

function db_ready( $str ) {
	return "'". addSlashes($str) . "'";
}

// Going through each dir found and removing '.', '..', and any other hidden files/folders	
function getDirectory( $folder, $remove_php_files = NULL, $just_get_image_names = NULL ){
			$arr_months = NULL;
			if( is_dir($folder) ) {
				$arr_whatever = scandir( $folder );
				if( is_array($arr_whatever) ){
					foreach( $arr_whatever as $dir_or_file ){
						if( substr( $dir_or_file, 0, 1) != '.' ){
							if( $remove_php_files && substr( $dir_or_file, -3, 3) == 'php') {
								// NULL
							} else {
									
								if( $just_get_image_names ){
									if( substr( strtolower($dir_or_file), -3, 3) == 'jpg'){
										$arr_months[] = $dir_or_file;
									}
								} else {
									$arr_months[] = $dir_or_file;
								}
								
							}
						} 
					}
				}
			}
	return $arr_months;
}

if( array_key_exists('runscript', $_REQUEST) && $_REQUEST['runscript'] ) {
	createFolderStructureArray($folders);
}

?>
<h1>Partytime Removal Machine</h1>
<form action="" method="post">
<?=$message;?>
<input type="submit" name="runscript" value="Run the Script" />
</form>
