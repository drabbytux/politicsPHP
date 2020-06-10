<?php



require_once( $_SERVER['DOCUMENT_ROOT'].'/_master/configs/config.php');
require_once( $_SERVER['DOCUMENT_ROOT'].'/_master/classes/database.class.php');
define('STORY_FOLDER_DIR', $_SERVER['DOCUMENT_ROOT']. '/'. SITE  );
$message = NULL;


if( SITE=='HT'){
$folders = array('2002','2003','2004', '2005', '2006','2007', '2008'); // HT
} else {
// $folders = array('2004', '2005','2006','2007', '2008'); // EM
// $folders = array('2005'); // EM
}
	
$db = new Database();
	
function createFolderStructureArray($folders){
	global $message, $db;
	
// TESTING

	
	// THE DROP
	
	$db->Execute( "TRUNCATE story");
	$db->Execute( "TRUNCATE story_comment");
	$db->Execute( "TRUNCATE `join-author-story`");
	$db->Execute( "TRUNCATE `join-photo-story`");
	// $db->Execute( "TRUNCATE `join-tag-story`");
	$db->Execute( "TRUNCATE author");
	$db->Execute( "TRUNCATE section");
	$db->Execute( "TRUNCATE section_heading");
	$db->Execute( "TRUNCATE issue");

// THE IMPORT

	// Get the current author table so there isn't any mixups with author IDs
	$db->Execute( file_get_contents(SITE.'author.sql') );
	$db->Execute( file_get_contents(SITE.'section.sql') );	
	// $db->Execute( file_get_contents(SITE.'section_heading.sql') );

	
// Set new array stuff

	/*
	$arr_section_heading = array();
	foreach( $db->ExecuteArray('select section_heading_id from section_heading') as $sec_head_id ){
		$arr_section_heading[] = $sec_head_id['section_heading_id'];
	}
*/
	
	
	
	// Get each year folder
	$x=0;
	$multiple_author_counter=0;
	foreach( $folders as $year_dir) {
	
	
		// Get the months folder
		$arr_months = getDirectory( STORY_FOLDER_DIR .'/'.$year_dir );
	
			// Now we have the months in an array. Lets find the date folders inside the month
			if( is_array( $arr_months) ) {
				foreach( $arr_months as $month_folder) {
					$arr_days = getDirectory( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder );
					
					// Get all the days (issues)
					if( is_array( $arr_days ) ) {
						foreach( $arr_days as $day ){
							
							$arr_story_folders_and_files = getDirectory( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day, true );
							
							/**
								author.inc (see info.php for id/name, if NOT, use author.inc)
								body.inc
								cutline.inc
								header.inc
								index.php (not needed)
								info.php *** SuPER importantay
								kicker.inc
							
							*/

							
						// Import the  I S S U E S  data for Issues table
							if( file_exists( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day . '/content_index.php') ){
								$str_content_index = file_get_contents( STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day . '/content_index.php' );
								$str_content_index = str_replace('<?', '', $str_content_index );
								$str_content_index = str_replace('?>', '', $str_content_index );
								// N E W - let the bare bones array be placed in the data array
								// $str_content_index = str_replace('$result_array = ', '', $str_content_index );
								if( trim( $str_content_index ) ){
									$the_date = strtotime("$day $month_folder $year_dir");							
									$sql = "insert into issue(issue_date, issue_old_array_content) values (".db_ready( $the_date ) .", ".db_ready( $str_content_index ).")";
									$db->Execute($sql);
									// print "<h4>ISSUE ". $the_date. " inserted.</h4>";
								}
							}
						
							
						// Do all the stories						
							if( is_array( $arr_story_folders_and_files ) ) {
								foreach( $arr_story_folders_and_files as $story ) {
								
									if( $story != "web_docs" && $story !='lists' && $story !='letters') {
											$story_folder_url = STORY_FOLDER_DIR .'/'.$year_dir .'/'.$month_folder . '/'. $day . '/'. $story;
											$str_kicker = NULL;
											$str_body = NULL;
											$str_title = NULL;
											$str_cutline = NULL;
											
											
											// bring in the body of the story in the DB
											if( file_exists( $story_folder_url .'/body.inc' )    ) {
												$str_body 		= file_get_contents($story_folder_url .'/body.inc');
											} else {
												// page.inc may exist - check it
												if( file_exists( $story_folder_url .'/page.inc' ) ){
													 $str_body  = file_get_contents($story_folder_url .'/page.inc');
												} else {
													$str_body = "";
												}
											}
											
											// bring in the title of the story in the DB
											if( file_exists( $story_folder_url .'/header.inc') ) {
												$str_title	 	= strip_tags( file_get_contents($story_folder_url .'/header.inc') );
											}
																				// bring in the title of the story in the DB
											if( file_exists( $story_folder_url .'/kicker.inc') ) {
												$str_kicker	 	= strip_tags( file_get_contents($story_folder_url .'/kicker.inc') );
											}
											if( file_exists( $story_folder_url .'/cutline.inc') ) {
												$str_cutline 	= strip_tags( file_get_contents($story_folder_url .'/cutline.inc') );
											}		
												
											/*
											print '<pre style="background-color: #FFFFff; border: 2px #CC6633 solid; color: #CC6633; padding: 8px;">';
											print_r('/'.$year_dir .'/'.$month_folder . '/'. $day . '/'. $story);
											print "</pre>";							
											print '<pre style="background-color: #FFFFCC; border: 2px #CC6633 solid; color: #CC6633; padding: 8px;">';
											print_r($str_title);
											print "</pre>";									
											print '<pre style="background-color: #99CCFF; border: 2px #3333FF solid; color: #3333FF; padding: 8px;">';
											print_r($str_body);
											print "</pre>";
											*/
											
											// Forget inserting it if there is NO title
											if( trim($str_title) ) {
												// All the cars must be reset in case there is NO info.php file
													$GLBSectionID=NULL;
													$GLBSuperSectionID=NULL;
													$GLBStoryDate=NULL;
													$GLBSectionImage=NULL;
													$GLBAuthorID=NULL;
													$GLBAuthor=NULL;
													
													$GLBSuperSectionID = ($GLBSuperSectionID)?$GLBSuperSectionID:0;
												// Bring in the variables set for the story in info.php
												if( file_exists( $story_folder_url.'/info.php' ) ) {
													// problem with the name Kady O'Malley
													// COMMENT OUT AFTER RUNNING SUCCESSFULLY ONCE!

													$str_info_file = file_get_contents( $story_folder_url.'/info.php');
													$str_info_file = str_replace('=;','="";', $str_info_file);
													$str_info_file = str_replace("Kady O'Malley","Kady O\'Malley", $str_info_file);
													file_put_contents($story_folder_url.'/info.php', $str_info_file);
													// print '<span style="color: orange;">Omalley changed</span><br />';
								
													// END COMMENT OUT
													include($story_folder_url.'/info.php');
													

												}
												
												// Get The AUTHOR
												$author_id = 0;
												$author_array = NULL;
												
												if( $GLBAuthorID == '0' || $GLBAuthorID == 0 || !$GLBAuthorID ){
													if( file_exists($story_folder_url.'/author.inc') ) {
														$author_name =  file_get_contents($story_folder_url.'/author.inc') ;
														// Clean up the author
														$author_name = strip_tags( $author_name );
														$author_name = preg_replace('/^by\s/i', '', $author_name); // removed and "By" removed
														$author_name = preg_replace('/^Compiled by\s/i', '', $author_name); // removed and "Complied By" removed
														
														// Lets split all the names - with some rules
														$author_array = preg_split("/(\s&\s)|(,\s)|(\sand\s)|(,\sand\s)/i", $author_name );

														// Remove from array -> ALL CAP words (including accronyms EG: M.P)
														//						trim "," , trim l-r spaces
														// 
				
													} else {
														$author_name = NULL;
													}
												}	else {
													$author_id = $GLBAuthorID;
												}
												// NOW - Split the author up into individual authors	

												// !!!!!!!NEW!!!!!!!!!!!!!!

												$author_id_array = getDBAuthorIDArray( $author_id, $author_array );
if( count($author_id_array)>1 ){
	$multiple_author_counter++;
}
												$str_section_heading_id = NULL;
												// If it's a section that is a column, attribute the NEW section_heading for it, and set to 5
												/*
												if( in_array($GLBSectionID, $arr_section_heading ) ) {
													$str_section_heading_id = $GLBSectionID;
													$GLBSectionID = 5;
												}
*/
												
												
										
															
												// print "\nInserting /". $year_dir .'/'.$month_folder . '/'. $day . '/'. $story . "...";
												// Place story into DB
												$sql = "INSERT INTO story (story_title,story_content,story_kicker,story_cutline,story_section_id,story_super_section_id, story_section_heading_id, story_url_id, story_issue_date) values (";
												$sql .= db_ready( $str_title );
												$sql .= ", ". db_ready( $str_body );
												$sql .= ", ". db_ready( $str_kicker );
												$sql .= ", ". db_ready( $str_cutline );
												$sql .= ", ". db_ready( $GLBSectionID );
												$sql .= ", ". db_ready( $GLBSuperSectionID );
												$sql .= ", ". db_ready( $str_section_heading_id );
												$sql .= ", ". db_ready( "/". $year_dir .'/'.$month_folder . '/'. $day . '/'. $story );
												// $sql .= ", ". db_ready( $author_id ); //removed for author join table
												$sql .= ", '". $GLBStoryDate ."'";
												$sql .= ")";
												$db->Execute( $sql );
												$last_story_insert_id = mysql_insert_id();
												
												
												/**
												print '<pre style="background-color: #99CCFF; border: 2px red solid; color: #3333FF; padding: 8px;">';
												print_r( 'AUTHOR ID: '. $author_id );
												print "</pre>";		

												print '<pre style="background-color: #99CCFF; border: 2px #3333FF solid; color: #3333FF; padding: 8px;">';
												print_r( $author_id_array  );
												print "</pre>";	
												
												print '<pre style="background-color: #99CCFF; border: 2px #3333FF solid; color: #3333FF; padding: 8px;">';
												print_r( 'STORY ID: '. $last_story_insert_id  );
												print "</pre>";															
												*/
												
	
												// Insert the Author(s) into the join table. 
												if( is_array( $author_id_array ) ) {
													$auth_count_x=1;
													foreach( $author_id_array as $aid ) {
														$sql = "INSERT INTO `join-author-story` (`join-author-story_author_id`, `join-author-story_story_id`,`join-author-story_order`) values (";
														$sql .= db_ready( $aid );
														$sql .= ", ". db_ready( $last_story_insert_id ) ;
														$sql .= ", ". db_ready( $auth_count_x ) ;
														$sql .= ")";
														$db->Execute( $sql );
														$auth_count_x++;
													}
												}
												
												$x++;
												// print '<span style="color:green;">SUCCESS</span><br />';
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
$message .= "<br />Number of stories with multiple authors: ". $multiple_author_counter;
}

function db_ready( $str ) {
	return "'". addSlashes($str) . "'";
}

// Going through each dir found and removing '.', '..', and any other hidden files/folders	
function getDirectory( $folder, $remove_php_files = NULL ){
			$arr_months = NULL;
			if( is_dir($folder) ) {
				$arr_whatever = scandir( $folder );
				if( is_array($arr_whatever) ){
					foreach( $arr_whatever as $dir_or_file ){
						if( substr( $dir_or_file, 0, 1) != '.' ){
							if( $remove_php_files && substr( $dir_or_file, -3, 3) == 'php') {
								// NULL
							} else {
								$arr_months[] = $dir_or_file;
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



function getDBAuthorIDArray( $cauthor_id, $cauthor_array ){
	global $db;
	$array_ids_return = array();
	if( !$cauthor_id && is_array($cauthor_array) ){
		foreach( $cauthor_array as $author_a_name ){
			$sql = "SELECT author_id from author where author_name=". db_ready( trim($author_a_name) );
			$res = $db->Execute( $sql );
			if( mysql_num_rows($res) > 0 ){
				$row = mysql_fetch_row( $res );
				$array_ids_return[] = $row[0];
				
			} else { // You better add the author into the DB or else!
				if( trim($author_a_name) && preg_match('/[a-z]+/', $author_a_name) ) {
					$author_name = trim( str_replace(',','', $author_a_name) );
					
					$sql = "insert into author (author_name) values (".db_ready( trim($author_a_name) ).")";
					$db->Execute($sql);
					$array_ids_return[] = mysql_insert_id();			
				}
			}
		}
		return $array_ids_return;
		
	} else if( $cauthor_id ) { // Just use the author id
		return array($cauthor_id);
	} else { // No author at all... a mystery...
		return NULL;
	}

	
}


?>

<form action="" method="post">
<?=$message;?>
<input type="submit" name="runscript" value="Run the Script" />
</form>
