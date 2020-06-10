<?php

require_once 'classes/inhouse.controller.class.php';
class TheStone extends InHouseController {
	private $arr_import_tags = array('header','kicker','url','author','section','pullquote');
	private $arr_stories = array();
	// - - - - - - - - - - - - - - P U B L I C     M E T H O D S - - - - - - - - - - - - - - - \\

	function TheStone(){
		if( $this->MemberAllowed() ){
			 $this->__construct(true);
		} else {
			header('Location: /member/login');	// Let them login first, then perhaps we'll see...
		}
	}

// ---- JUMPOFF POINTS ------------------------------------------------
	
	public function index(){
		$this->setTheStoneCommonTemplates();
		$this->Set_Template('output', 'thestone/default.php');
		$this->Output_Page();
	}
	
	public function pages(){
		$this->setTheStoneCommonTemplates();
		$this->data['issue_dates_array'] = $this->_getIssueDates();
		$this->Set_Template('output', 'thestone/pages.php');
		$this->Output_Page();
	}
	
	/**
	 * Fetch Page
	 * Looks for the POST item entered and looks it up
	 * as if it were an ID. If it cannot be found, it will use
	 * it as a search string and output the results
	 * Also, it will strip out a passed URL, so a quick-copy-paste
	 * will end up using the last bit as the lookup ID
	 *
	 */
	public function fetchpage(){
		$this->setTheStoneCommonTemplates();
		$this->data['issue_dates_array'] = $this->_getIssueDates();
		$page_id = NULL;
		if( $this->Get('submit_page_fetch') && $this->Get('page_retrieve') ){
			$page_id = array_pop( explode('/', $this->Get('page_retrieve') ) ); 	// Strips out URL stuff, if it's there
			$page_id = $this->toURL($page_id, true); // In case it was an older story, put back the / in
		}
		
		// First Time in for editing a page. Fetching the data from the DB
		if( $this->getPage( $page_id ) ) {
			// Page has been found, use it!
			$this->getEveryPageComponant( $page_id );	// Retrieves everything the page needs for editing
			$this->editPageTags();		// Process POST/SESSION Tags
			$this->editPageAuthors();	// Process POST/SESSION Authors
			$this->data['author_list'] 			= $this->setAuthorList();	// The MASTER author list
			$this->data['section_list'] 		= $this->setSectionList();	// The MASTER section list
			$this->data['tag_added_list']		= $this->Get_Session( 'EDIT_tag_session' );		// Display the tags you have added, but not DB saved yet
			$this->data['author_added_list']	= $this->Get_Session( 'EDIT_author_session' );	// Display the authors you have added, but not DB saved yet
			$this->Set_Post_Sessions();	// Places all the post elements into sessions
			$this->setTheStoneCommonTemplates();
			$this->Set_Template_With_PHP('output', 'thestone/page_edit.php');
			$this->Output_Page();
		} else if ( $page_id ){
			$this->data['page_fetch_list'] = $this->searchStories( $page_id ); // List for search results
			$this->Set_Template('output', 'thestone/pages.php');
			$this->Output_Page();
		} else {
			$this->Set_Template('output', 'thestone/pages.php');
			$this->Output_Page();
		}
	}
	
	
	public function settings(){
		$this->setTheStoneCommonTemplates();
		$this->Set_Template('output', 'thestone/settings.php');
		$this->Output_Page();
	}
	
	public function media(){
		$this->setTheStoneCommonTemplates();
		$this->Set_Template('output', 'thestone/media.php');
		$this->Output_Page();
	}
	
	public function loadentireissue(){
		$this->setTheStoneCommonTemplates();
		$this->Set_Template('output', 'thestone/load_entire_issue.php');
		$this->Output_Page();
	}
	
	public function uploadissuefile() {
	$str_file= NULL;
		if( array_key_exists('issuefile', $_FILES) ){
			if( file_exists($_FILES['issuefile']['tmp_name']) ){
				$new_fil =  BASE_SECURE_FILES . 'data_file.txt';
				move_uploaded_file($_FILES['issuefile']['tmp_name'], $new_fil);
				$str_file = file_get_contents($new_fil); // Retrieve all the contents!
			}
			if( $str_file ){ 
				$str_file = $this->htmlButTags( $str_file );	// change to HTML Entities 
				$this->parseOutEntrys( $str_file );			// Parse out all the stories and attributes
	
				// This is where we can show what is going on.
				// We REALLY want it to insert it all and thats that.
				$this->_storeIssueFileDB();
				
			}
				// If the file is there, start the process!
				$this->data['upload_status'] = "Story Count:". count( $this->arr_stories );
			$this->Set_Template('output', 'thestone/load_entire_issue_status.php');
		} else {
			$this->Set_Template('output', 'thestone/load_entire_issue.php');
		}

		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}

	
	
	public function users(){
		
		$this->Set_Template('output', 'thestone/users.php');
		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}

	public function mailout(){
		$this->setHTMLMailoutTemplate();
		$this->Set_Template('output', 'thestone/mailout.php');
		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}
	
	public function processMailout(){
		if( $this->Get('submit_send_email_test') ) {		// Send a test
			print '<pre style="margin: 4px; border: 2px #74D30C solid; background-color: #ECFFD7; padding: 8px;">';
			print_r('testing');
			print '</pre>';
		} else if( $this->Get('submit_send_email') ){		// The real deal - send it to the maillist
		
			
		}
		$this->Set_Template('output', 'thestone/mailout.php');
		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}
	
	public function sendTestMailout(){
		$email_content = html_entity_decode( $this->Get('email_content') );
		require_once('classes/htmlMimeMail5/htmlMimeMail5.php');
		
		$mm = new htmlMimeMail5();
		$mm->setFrom('Embassy <no-reply@embassymag.ca>');
		$mm->setSubject("Embassy newspaper electronic edition");
		$mm->setPriority('normal');
		$mm->setHTML( $email_content );
		$mm->setReturnPath("no-reply@embassymag.ca");
		// $mail->addAttachment(new fileAttachment($file));

		// SEND IT!
		$mm->send( array('drabbytux@gmail.com') );
		
	}
	
	public function setHTMLMailoutTemplate(){
		$arr_latest_issue = $this->_getIssue(); // Get the latest issue
		$this->_setIssueStories( $arr_latest_issue['issue_date'] );
		$html_email_content = NULL;
		
		
		if( is_array($this->Get_data('issue_stories') ) &&  array_key_exists(0, $this->Get_data('issue_stories') )){
			foreach( $this->Get_data('issue_stories',0) as $story ){
				if( $story['story_front_page'] == 1) {
					$html_email_content .= '<li><a href="'.SERVER_URL.'/page/view/'.$story['story_url_id'].'">' . $story['story_title'] .'</a><br />';
					$html_email_content .=  $story['story_brief'];
					$html_email_content .= "</li>\n";
				}
			}
		}
		//[story_front_page] => 1
		$this->data['email_content_issue'] = $html_email_content;
		$this->Set_Template('email_content', 'thestone/email_basic_template.php');
	}
	
	
	
	public function uploadFilemaker() {
		// File submit
		if( $this->Get('submit_upload_filemaker_file') ){
			if( isset( $_FILES )){
				if( $_FILES['file']['error']==0) { // No errors 
					move_uploaded_file($_FILES['file']['tmp_name'], MEMBER_FILEMAKER_FILE);
					$this->loadFileMakerFile( MEMBER_FILEMAKER_FILE );
					$this->Set_Template('output', 'thestone/upload_filemaker_file_review.php');
				} else{
					$this->Set_Error('There was something wrong with the file you attempted to upload.', 'uploaded_file');
					$this->Set_Template('output', 'thestone/upload_filemaker_file.php');
				}
				
			} else {
			
				$this->Set_Error('There was something wrong with the file you attempted to upload.', 'uploaded_file');
				$this->Set_Template('output', 'thestone/upload_filemaker_file.php');
			}
			
		} elseif( $this->Get('submit_process_filemaker_file')  ) {
			
		}else {
			$this->Set_Template('output', 'thestone/upload_filemaker_file.php');
		}
		
		
		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}

	public function processFilemaker() {
		// File submit
		if( $this->Get('submit_process_filemaker_file') ){
			if( file_exists( MEMBER_FILEMAKER_FILE )){
				$this->loadFileMakerFile( MEMBER_FILEMAKER_FILE );	
				
				if( $this->_processFileIntoDB() ){
					$this->Set_Template('output', 'thestone/process_filemaker_file.php');
				} else {
					$this->Set_Template('output', 'thestone/process_filemaker_file_failed.php');
				}

			} else {
				$this->Set_Error(MEMBER_FILEMAKER_FILE . ' doesn\'t exist... Problems?', 'saved_file');
			}
			
		} elseif( $this->Get('submit_cancel')  ) {
			$this->Redirect_URL_Wrapper( '/thestone/uploadFileMaker');
			exit;
		}else {
			$this->Set_Template('output', 'thestone/upload_filemaker_file.php');
		}
		
		
		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}
	
	public function databaseSettings(){
		$this->Set_Template('output', 'thestone/database.php');
		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}
	
	public function addAreaToStory(){
		
		// Coming in:
		if( $this->Get('submit_addArea')) {
			
			// process
			$sql = "INSERT into `join-area-story` (`join-area-story_story_id`, `join-area-story_area_id`) values(";
			$sql .= "'". $this->Get_URL_Element(VAR_1) . "', '". $this->Get('area_id') ."'";
			$sql .= ")";
			if( $this->Execute($sql ) ){
				$this->Redirect_URL_Wrapper();
			}
		} else {
			
			$sql = "SELECT * from area";
			foreach( $this->ExecuteArray( $sql ) as $res ){
				$arr_areas[ $res['area_id'] ] = $res['area_id'] . ' - ' . $res['area_title'];
			}
			
			$this->data['arr_areas'] = $arr_areas;
			$this->Set_Template('output', 'thestone/addAreaToStory.php');
			$this->setTheStoneCommonTemplates();
			$this->Output_Page();
		}
	}
	
	
	
	/** --- P A R T Y    T I M E    ----------------- */
	public function partytime(){	
		$this->Set_Template('output', 'thestone/partytime.php');
		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}
	
	public function partytimecreate() {
		if( $this->get('month') &&  $this->get('day') &&  $this->get('year') ){
			$this->data['party_date'] = mktime(0,0,0, $this->get('month'), $this->get('day'),$this->get('year'));
			if( $pt_directory = $this->doesPartyTimeDirectoryExist() ){
				// Excellent, the directory is there. Show the photos
				$this->fetchPhotosInPartyTimeDirectory();
				
				$this->Set_Template('output', 'thestone/partytime_create.php');
			}	else {
				$this->Set_Error('Sorry to disappoint. You have not uploaded your files yet to the date specific directory. How about doing that now, smart guy?', 'partytime_date');
				$this->Set_Template('output', 'thestone/partytime.php');	
			}
		} else{
			$this->Set_Error('A Date was not found. You will have to set a date first','partytime_date');
			$this->Set_Template('output', 'thestone/partytime.php');
		}
		$this->setTheStoneCommonTemplates();
		$this->Output_Page();
	}
	
	/**
	 * The big one that add captions, bylines and others to the system
	 *
	 */
	public function processPartyTimePhotos(){

		// Take in the directory listing for party time
		if( $this->get('party_time_date') ){

			$this->data['party_date'] = $this->get('party_time_date');
			if( $this->doesPartyTimeDirectoryExist() ){
				$this->fetchPhotosInPartyTimeDirectory();
			}

			// DELETE previous entries, just so we don't mix this up.
			// $this->Execute( "DELETE from party_time_parties where pt_pa_date=". $this->get_data('party_date') );
			$this->Execute( "DELETE from party_time_images where pt_im_date=". $this->get_data('party_date') );

			// Go through each and use the names to fetch the post variables
			if( is_array( $this->get_data( 'party_time_photos' ) ) ){
				
				foreach(  $this->get_data( 'party_time_photos' )  as $fn ){
					$actual_file_name = $fn;
					$file_name = str_replace( '.','_', $fn );
					
					// Fix the party name
					$party_name = $this->fixPartyName( $this->get( $file_name . '_party' ) );

					// Place the party in, if it's not in there already...
					if( !$this->partyNameExistInDB( $party_name, $this->get_data('party_date') ) ){
							$sql = "INSERT into party_time_parties (`pt_pa_date`,`pt_pa_party_name`,`pt_pa_title`) values (";
							$sql .= $this->dbReady( $this->get_data('party_date') );
							$sql .= $this->dbReady( $party_name );
							$sql .= $this->dbReady($this->get( $file_name . '_party' ), true );
							$sql .= ")";
	
							if( $this->Execute( $sql ) ){
								$this->Set_Message("The Party <em>" .$this->get( $file_name . '_party' ) . "(".$party_name.")</em> has been added to the database.");
							}
					}
					
					// Place the image in : party name, caption, by line, order

						$sql = "INSERT into party_time_images (`pt_im_date`,`pt_im_party_name`,`pt_im_img_name`,`pt_im_cutline`,`pt_im_credit`,`pt_im_img_number`) values (";
						$sql .= $this->dbReady( $this->get_data('party_date') );
						$sql .= $this->dbReady( $party_name );
						$sql .= $this->dbReady( $actual_file_name );
						$sql .= $this->dbReady( $this->get( $file_name . '_caption' ));
						$sql .= $this->dbReady( $this->get( $file_name . '_byline' ));
						$sql .= $this->dbReady( $this->get( $file_name . '_order' ), true );
						$sql .= " )";

						if( $this->Execute( $sql ) ){
							$this->Set_Message($file_name . " has been added to the database.");
						}

						
				}
			}
		}
			$this->Set_Template('output', 'thestone/partytime_finished_photos.php');
			$this->setTheStoneCommonTemplates();
			$this->Output_Page();
	}
	
	
	
	
	/**
	 * Sets a variety of stats for the user homepage
	 *
	 */
	public function setUserStats(){
		
		// # members total
			$res = $this->ExecuteAssoc( "SELECT count(*) as total_number from member" );
			$this->data['stats_total_members'] = $res['total_number'];
			
		// # members total
			$res = $this->ExecuteAssoc( "SELECT count(*) as total_number from member where member_status=". STATUS_LIVE );
			$this->data['stats_live_members'] = $res['total_number'];
	}
	
	
	
// ---- Issues and Pages ------------------------------------------------


	
	public function createPage(){
		
		$this->setTheStoneCommonTemplates();
		
		// Cancel button?
		if( $this->Get('EDIT_cancel')){
			$this->Clear_Session_Variables('EDIT_'); 
			header('Location: /thestone/pages');
			exit();
		}
		// Save button?
	
		if( $this->Get('EDIT_save')){
			// Check the fields for errors
				
			// Do session/post data stuff
				// Everything is POST Except
				// - Authors
				// - Tags
				// - Photo
				
			// Save the data
				if( $this->saveStory() ){
					$this->Clear_Session_Variables('EDIT_'); 
					$this->Set_Message("Page Saved", 'message');
					header('Location: /thestone/pages');
					exit();
				}	
		}
		
		$this->editPageTags();		// Process POST/SESSION Tags
		$this->editPageAuthors();	// Process POST/SESSION Authors
		
		$this->data['author_list'] 			= $this->setAuthorList();
		$this->data['section_list'] 		= $this->setSectionList();
		
		$this->data['tag_added_list']		= $this->Get_Session( 'EDIT_tag_session' );
		$this->data['author_added_list']	= $this->Get_Session( 'EDIT_author_session' );
		$this->Set_Post_Sessions();	// Places all the post elements into sessions
		
		
		$this->Set_Template_With_PHP('output', 'thestone/page_edit.php');

		$this->Output_Page();

	}

	
	/**
	 *  P R I V A T E   F U N C T I O N S 
	 */
	//$_FILES['file']['tmp_name'] 
	
	
	private function fixPartyName( $str_party_name ){
		return str_replace(" ", '', strtolower( str_replace($this->language_html_entities, "", $str_party_name) ) ); 
	}
	
	private function partyNameExistInDB( $party_name, $party_date ){
		$sql =  "select pt_pa_date from party_time_parties where pt_pa_party_name=". $this->dbReady( $party_name, true);
		$sql .= " and pt_pa_date=". $this->dbReady( $party_date, true );
		return $this->ExecuteAssoc( $sql );
	}
	
	private function doesPartyTimeDirectoryExist(){
		if( $this->get_data('party_date') ){
			
			$directory = '/partytime/' . date('Y', $this->Get_Data('party_date') ) .'/'.  strtolower( date('F', $this->Get_Data('party_date') ) ) . '/'.  date('j', $this->Get_Data('party_date') );
			$directory_to_check = DIRECTORY_PHOTOS . $directory;
			$url_directory = '/'.SITE . $directory;
			
			if ( file_exists( $directory_to_check ) ){
				$this->data['party_time_folder'] = $directory_to_check;
				$this->data['party_time_url_folder'] = $url_directory;
				return true;
			}
		}
	}
	private function fetchPhotosInPartyTimeDirectory(){
		if( $this->Get_Data('party_time_folder') ){
				$arr_photos =array();
				$photos = scandir( $this->Get_Data('party_time_folder') );
		
				foreach ($photos as $fl ){
					if( strstr($fl, '.jpg' ) && !strstr($fl, 'th-' )) {
						$arr_photos[ str_replace(  '.','_', $fl ) ] = $fl; 
					}
				}
				$this->data['party_time_photos'] = $arr_photos;
		}
	}
	
	
	private function loadFileMakerFile( $path_and_file ){
		if( file_exists(  $path_and_file )){
				$arr_user_file = file(  $path_and_file );

				// Get the original member array
				$orig_user_data = $this->_getEntireMemberArray( 'return only live ones' );

				if( is_array( $arr_user_file ) ){
					$new_file_email_keys 	= array();	// Gets all the keys
					$new_user_array		= array();	// A new user array
					
					// This gets all the new users and makes a keyed array of all users
					foreach ($arr_user_file as $u ){
						$status = NULL;
						// Pattern of orig file: /tFIRST/tLAST/tEMAIL/tRECEIVE PDF/tAuth level
						$u_details = explode("\t", $u );
						if ( array_key_exists( 2, $u_details ) && trim( $u_details[2] ) ){ 
							// If a new key is not within the orig, it's a new user. Add it a new user array as well.

							if( !array_key_exists( strtolower( trim( $u_details[2] ) ), $orig_user_data ) ) {
								// New user
								$new_user_array[ trim( strtolower( $u_details[2] ) )  ] = $u_details;
								$pdf_pref = ( trim( $u_details[3]) == 'No')? 3:1;
								$orig_user_data[ trim( strtolower( $u_details[2]) )  ] = array('member_email'=>strtolower( trim( $u_details[2] )), 'member_name_first'=>$u_details[0], 'member_name_last'=>$u_details[1], 'member_preference_email_pdf'=>$pdf_pref);
								
							}
							$new_file_email_keys[  strtolower( trim( $u_details[2] ) ) ] = $u_details[3];
						}
					}
					
					// Returns an array containing all the entries from array1  that are not present in the new upload file - Subscriptions that are dead. 
					$not_live_status_array = array_diff_key( $orig_user_data, $new_file_email_keys );
				}
			$this->data['orig_user_array']	= $orig_user_data;
			$this->data['new_user_array']	= $arr_user_file;	// From file
			$this->data['new_users'] 		= $new_user_array;
			$this->data['removed_users'] 	= $not_live_status_array;
			
		}
		
	
	}
	
	private function _processFileIntoDB(){
		
		
		// Step 1 - Set the status of the Removed users to status 2
		// Also, set the member_expire date to today. This way, we can delete them perm from the system
		// after a year.
	
			if( is_array( $this->Get_Data('removed_users') ) && count( $this->Get_Data('removed_users') ) ) {

				$sql = "UPDATE member set member_status=". STATUS_NOT_LIVE . ", member_expire_date=".$this->dbReady(mktime(), true)." where member_email in (";
				$x=0;
				foreach( $this->Get_Data('removed_users') as $key=>$val) {
					$x++;
					$sql .= ($x==count($this->Get_Data('removed_users')))? $this->dbReady( strtolower( $key ), true ):$this->dbReady( strtolower( $key ) );
				}
				$sql .= ")";
				
				$this->Execute($sql);
			}

			
		// Next, add the new users to the DB, but double check that they aren't already in the db with a status of 2!
			if( is_array( $this->Get_Data('new_users') ) && count( $this->Get_Data('new_users') ) ) {
				$x=0;
				foreach( $this->Get_Data('new_users') as $nui_key=>$new_user_item ) {
					 $status_flag = NULL;
					// Let's check to see if the email already exists so we can just switch the status flag
						if( $status_flag = $this->doesEmailExist( $new_user_item[ 2 ] ) ) {
							if( $status_flag == STATUS_NOT_LIVE ){ // We found them, make 'em live... they paid their bill.
								$sql ="UPDATE member set member_status=". STATUS_LIVE . ", member_expire_date=NULL  where member_email=".$this->dbReady( strtolower( $new_user_item[2] ) , true);
								$this->Execute($sql);
							} else {	// What??? They are in the database AND their status is 1??? WTF? How did they get this far!
								print "JUST A WARNING:". $new_user_item[ 2 ] ." must be exported twice... Why is that?<br />";
							}
						} else {
						// Ok, it's a new member!
							$sql = "INSERT into member (member_email, member_name_first, member_name_last) values (";
							$sql .= $this->dbReady( strtolower( $new_user_item[ 2 ] ) );
							$sql .= $this->dbReady( $new_user_item[ 0 ] );
							$sql .= $this->dbReady( $new_user_item[ 1 ], true ) . ")";
							$this->Execute($sql);
						}
				}
			}
		return true;
	}
	
	private function _getIssue( $date = NULL ){
		
		if($date){
			$sql = "SELECT * from issue as i left join issue_template as it on ( i.issue_template_id=it.issue_template_id ) where issue_date='".$this->_URLToUnixDate($date)."'";
			$sql .= " and issue_status=1";
			return $this->ExecuteAssoc($sql);
		} else {	// Get most current version if date isn't specified - The Home Page
			if( $this->MemberAllowed(MEMBER_AUTH_LEVEL_ADMIN)){
				$sql = "SELECT * from issue as i left join issue_template as it on ( i.issue_template_id=it.issue_template_id ) where ";
				$sql .= " issue_status=1 order by issue_date desc limit 1";	
			} else {
				$sql = "SELECT * from issue as i left join issue_template as it on ( i.issue_template_id=it.issue_template_id ) where issue_date<='".mktime()."'";
				$sql .= " and issue_status=1 order by issue_date desc limit 1";				
			}

			return $this->ExecuteAssoc($sql);	
		}
	}
	
	private function _setIssueStories( $date ){
		$sql = "SELECT s.* from story as s ";
		$sql .= " where s.story_issue_date=$date and s.story_status=1";
		$sql .= " order by s.story_front_page asc, s.story_section_id asc, s.story_order asc";

		$this->data['issue_stories'] = $this->ExecuteArray($sql);
	//	$this->_processIssueStoriesOrder( $this->Get_Data('issue_stories') );
	}
	
	/**
	 * Retrieves normal, member users array (member_authority_level_id = 1).
	 * 
	 */
	private function _getEntireMemberArray( $return_only_live_ones = NULL ){	
		$arr_members = array();
		$sql = "SELECT * from member where member_authority_level_id=1";
		$sql .= ( $return_only_live_ones)? " and member_status=". STATUS_LIVE: NULL;
		$res = $this->ExecuteArray($sql);
		if( is_array( $res ) ) {
			foreach( $res as $row ){
				$arr_members[ strtolower( trim( $row['member_email']) ) ] = $row;
			} 
		}
		return $arr_members;
	}
	
	
	
	// Saves both new and existing pages
	private function saveStory(){
		
		if( $this->Get_Data('EDIT_story_id') ) {	// Save existing Story
			$sql  = "UPDATE story set ";
			$sql .= "story_title=" . $this->dbReady( $this->Get_Data( 'EDIT_story_title' ) );
			$sql .= "story_content=" . $this->dbReady( $this->Get_Data( 'EDIT_story_content' ) );
			$sql .= "story_kicker=" . $this->dbReady( $this->Get_Data( 'EDIT_story_kicker' ) );
			$sql .= "story_cutline=" . $this->dbReady( $this->Get_Data( 'EDIT_story_cutline' ) );
			$sql .= "story_section_id=" . $this->dbReady( $this->Get_Data( 'EDIT_story_section_id' ) );
			$sql .= "story_url_id=" . $this->dbReady( $this->Get_Data( 'EDIT_story_url_id' ) );
			$sql .= "story_date=" . $this->dbReady( $this->Get_Data( 'EDIT_story_date' ) );
			$sql .= "story_status=" . $this->dbReady( $this->Get_Data( 'EDIT_story_status' ) );
			$sql .= "story_updated=" . $this->dbReady( $this->Get_Data( 'EDIT_story_updated' ) );
			$sql .= "story_lock_current_issue=" . $this->dbReady( $this->Get_Data( 'EDIT_story_lock_current_issue' ) );
			$sql .= "story_lock_archives=" . $this->dbReady( $this->Get_Data( 'EDIT_story_lock_archives' ), true );
			$sql .= " where story_id=". $this->Get_Data( 'EDIT_story_id' );
	
		} else {	// Brand NEW story
			$sql =  "INSERT into story ";
			$sql .= "( story_title, story_content, story_kicker, story_cutline, story_section_id,";
			$sql .= "story_url_id, story_date, story_status, story_updated, story_lock_current_issue,story_lock_archives";
			$sql .= ") values (";
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_title' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_content' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_kicker' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_cutline' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_section_id' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_url_id' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_date' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_status' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_updated' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_lock_current_issue' ) );
			$sql .= $this->dbReady( $this->Get_Data( 'EDIT_story_lock_archives' ), true );
			$sql .= ")";
		}
		
		// Do the DB work
			$this->Execute($sql);
		
		// If successful, clean up the session vars
		
		// If all good, return true
		return true;
	}
	
	private function doesEmailExist( $email ){
		if( trim($email) ){
			$sql = "SELECT member_status from member where member_email=". $this->dbReady( $email , true );
			$record = $this->ExecuteAssoc($sql);
			if( is_array( $record ) ){
				return $record['member_status'];
			}
		}
	}
	
	private function searchStories( $page_id ){
		
	}
	
	
	/**
	 * Using other private methods, it gets everything the page needs, including
	 * the page, authors, tags and photos
	 *
	 */
	private function getEveryPageComponant( $page_id = NULL ){
		$this->data_holder['arr_story'] 	= $this->getPage( $page_id );
		$this->Set_Data_From_Data_Holder_Array('arr_story', 'EDIT');
		
		// Fix Stories previous to SYSTEM_IMPLEMENTATION_DATE for HTML
		if( $this->data['EDIT_story_date'] <= SYSTEM_IMPLEMENTATION_DATE ){
			$this->data['EDIT_story_content'] = nl2br( $this->data['EDIT_story_content'] );
		}
		
		// Get the Authors for this story
		$this->data_holder['arr_story_authors'] 	= $this->getStoryAuthors();
		$this->Set_Data_From_Data_Holder_Array('arr_story_authors', 'EDIT_STORY_AUTHORS');
		
		// Get the Tags used for this story
		$this->data_holder['arr_story_tags'] 	= $this->getStoryTags();
		$this->Set_Data_From_Data_Holder_Array('arr_story_tags', 'EDIT_STORY_TAGS');
		
		// Get the Photos used for this story
		$this->data_holder['arr_story_photos'] 	= $this->getStoryPhotos();
		$this->Set_Data_From_Data_Holder_Array('arr_story_photos', 'EDIT_STORY_PHOTOS');
	}
	
	private function getPage( $url_id ){
		$sql = "SELECT * from story where story_url_id='".$url_id."'";
		$res = $this->ExecuteAssoc($sql);
		if( is_array( $res ) ) {
			return $res;
		}
	}
	
	
	/**
	 * Retrieves the author IDs and Names from the join author/story tables
	 *
	 */
	private function getStoryAuthors() {
		if( $this->Get_Data('EDIT_story_id') ){
			$sql = "SELECT ja.`join-author-story_author_id` as author_id, a.author_name from `join-author-story` as ja left join author as a on (ja.`join-author-story_author_id`=a.author_id) where ja.`join-author-story_story_id`='".$this->Get_Data('EDIT_story_id')."'";
			$res = $this->ExecuteArray($sql);
			if( is_array( $res ) ) {
				return $res;
			}	
		}
	}
	
	/**
	 * Retrieves the Tag IDs and Names from the join tag/story tables
	 *
	 */
	private function getStoryTags(){
		if( $this->Get_Data('EDIT_story_id') ){
			$sql = "SELECT jt.`join-tag-story_tag_id` as tag_id, t.tag_name from `join-tag-story` as jt left join tag as t on (jt.`join-tag-story_tag_id`=t.tag_id) where jt.`join-tag-story_story_id`='".$this->Get_Data('EDIT_story_id')."'";
			$res = $this->ExecuteArray($sql);
			if( is_array( $res ) ) {
				return $res;
			}	
		}
	}
	
	/**
	 * Retrieves the photo details from the join photo/story tables
	 *
	 */
	private function getStoryPhotos(){
		if( $this->Get_Data('EDIT_story_id') ){
			$sql = "SELECT jp.`join-photo-story_photo_id` as photo_id, p.photo_file_name from `join-photo-story` as jp left join photo as p on (jp.`join-photo-story_photo_id`=p.photo_id) where jp.`join-photo-story_story_id`='".$this->Get_Data('EDIT_story_id')."'";
			$res = $this->ExecuteArray($sql);
			if( is_array( $res ) ) {
				return $res;
			}	
		}
	}
	
	
	
	private function editPageTags(){
			// TAGS --------------------------
		$this->data['array_tags'] = $this->Get_Session('array_tag_session'); // array of id=>names
		// Tag Button pressed?  - Add the tag!
		if( $this->Get('EDIT_submit_tag') ) {
			if( $this->Get('EDIT_tag_item') ) {
				$this->data['tag_display'] = $this->Get_Data('array_tags') .  $this->Get('EDIT_tag_item');
				$this->Append_to_Session_Array('EDIT_tag_session', array( $this->Get('EDIT_tag_item') ) );
			}
		}
	}
	
	private function editPageAuthors(){
			// AUTHORS --------------------------
		$this->data['array_authors'] = $this->Get_Session('array_author_session'); // array of id=>names
		// Tag Button pressed?  - Add the tag!
		if( $this->Get('EDIT_submit_author') ) {
			if( $this->Get('EDIT_new_author') ) {
				$this->data['author_display'] = $this->Get_Data('array_authors') .  $this->Get('EDIT_new_author');
				$this->Append_to_Session_Array('EDIT_author_session', array( $this->Get('EDIT_new_author') ) );
			} else {
				$this->data['author_display'] = $this->Get_Data('array_authors') .  $this->Get('EDIT_author_list');
				$this->Append_to_Session_Array('EDIT_author_session', array( $this->Get('EDIT_author_list') ) );
			}
		}
		
	}
	
	private function setAuthorList(){
		$sql = "SELECT * from author order by author_name";
		$res = $this->ExecuteArray($sql);
		if( is_array( $res ) ){
			return $res;
		}
	}
	
	private function setSectionList(){
		$sql = "SELECT * from section order by section_title";
		$res = $this->ExecuteArray($sql);
		if( is_array( $res ) ){
			return $res;
		}
	}
	

	/**
	 * parseout entrys
	 * 
	 * Takes the file string and creates a good, global array for all the stories
	 * Combines the old with the new!
	 */
	private function parseOutEntrys($issue){
			
		// Each Story
		// $arr_stories = preg_split ( "/\*\*\*/", $issue, -1, PREG_SPLIT_NO_EMPTY);
		$arr_stories = explode("***", $issue);
		
		foreach( $arr_stories as $story_key=>$story_item ){
			$arr_story_attributes = preg_split ( "/##([a-zA-Z0-9_]+)##\s*/", $story_item, -1, PREG_SPLIT_DELIM_CAPTURE);
			
			// $this->arr_stories[ $story_key ] = $arr_story_attributes;
			
			foreach( $arr_story_attributes as $key=>$story_attribute) {
				if ( $story_attribute == "DAY") { $this->arr_stories[ $story_key ]['Day'] 			= trim( $arr_story_attributes[$key+1] ); $this->data['new_issue_date_day'] = trim( $arr_story_attributes[$key+1] ); }
				if ( $story_attribute == "MON") { $this->arr_stories[ $story_key ]['Month'] 		= trim( $arr_story_attributes[$key+1] ); $this->data['new_issue_date_month'] = trim( $arr_story_attributes[$key+1] ); }
				if ( $story_attribute == "YEA") { $this->arr_stories[ $story_key ]['Year'] 			= trim( $arr_story_attributes[$key+1] ); $this->data['new_issue_date_year'] = trim( $arr_story_attributes[$key+1] ); }
				if ( $story_attribute == "ISS") { $this->arr_stories[ $story_key ]['Issue'] 		= trim( $arr_story_attributes[$key+1] ); $this->data['new_issue_number'] = trim( $arr_story_attributes[$key+1] ); }
				if ( $story_attribute == "DIR") { $this->arr_stories[ $story_key ]['Dir'] 			= trim( $arr_story_attributes[$key+1] ); }
				if ( $story_attribute == "SEC") { $this->arr_stories[ $story_key ]['Section'] 		= trim( $arr_story_attributes[$key+1] ); }
				if ( $story_attribute == "COV") { $this->arr_stories[ $story_key ]['OnCover'] 		= 1; $this->arr_stories[ $story_key ]['Unlock'] 		= 2; }
				if ( $story_attribute == "HEA") { $this->arr_stories[ $story_key ]['Header'] 		= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "BRI") { $this->arr_stories[ $story_key ]['Brief'] 		= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "KIC") { $this->arr_stories[ $story_key ]['Kicker'] 		= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "AUT") { $this->arr_stories[ $story_key ]['Author'] 		= trim( $arr_story_attributes[$key+1] ); }
				if ( $story_attribute == "POS") { $this->arr_stories[ $story_key ]['Position'] 		= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "ISH") { $this->arr_stories[ $story_key ]['keysHtml']		= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "BOD") { $this->arr_stories[ $story_key ]['Body'] 			= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "PHO") { $this->arr_stories[ $story_key ]['Photo'] 		= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "PHN") { $this->arr_stories[ $story_key ]['Photo_name'] 	= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "PHC") { $this->arr_stories[ $story_key ]['PhotoCut'] 		= $arr_story_attributes[$key+1]; }
				if ( $story_attribute == "UNL") { $this->arr_stories[ $story_key ]['Unlock'] 		= 2; }
			}
		}	
	}
	
	private function _storeIssueFileDB() {
		if( is_array( $this->arr_stories ) ){
			// using the old method right now for the date
			if( $this->Get_Data('new_issue_date_day') && $this->Get_Data('new_issue_date_month') && $this->Get_Data('new_issue_date_year') ) {
				$this->data['new_issue_date_unix'] = mktime(0,0,0, $this->Get_Data('new_issue_date_month'), $this->Get_Data('new_issue_date_day'), $this->Get_Data('new_issue_date_year') ); 
			}
			
			if( $this->Get('delete_issue_stories') ) {
				$sql ="DELETE from story where story_issue_date=".  $this->dbReady( $this->Get_Data('new_issue_date_unix'), true );
				$this->Execute( $sql );
			}
		
			foreach($this->arr_stories as $story_key=>$story_item ){
				$multiple_author_counter=0;
				if(  $this->_getFieldFromArrStories( $story_key, 'Header' ) ){
					// First, check to see if the issue exists first
						$sql = "SELECT issue_date from issue where issue_date=". $this->dbReady( $this->Get_Data('new_issue_date_unix'), true );
						$res = $this->ExecuteArray( $sql );
						
						if( !is_array( $res ) ) {	
							$sql =  "INSERT into issue ";
							$sql .= "( issue_date, issue_number";
							$sql .= ") values (";
							$sql .= $this->dbReady( $this->Get_Data('new_issue_date_unix') );
							$sql .= $this->dbReady( $this->Get_Data('new_issue_number'), true );
							$sql .= ")";
							$this->Execute( $sql );
						}
						
					// Second, lets make a brief, unless a brief or kicker already exists
						if( !($this->_getFieldFromArrStories( $story_key, 'Brief' ) || $this->_getFieldFromArrStories( $story_key, 'Kicker' ) ) ) {
							// Neither exist, so lets make it.
							/** 	Rules: 	The first line until a period
								*				An abbreviation period has no space after it, but a complete sentence does.
								*				A new line may be right after a period instead of a space char
								*				Take a shortest version
								*/
								$str_pos_space = strpos($this->_getFieldFromArrStories( $story_key, 'Body' ), ". ");
								$str_pos_new_line = strpos($this->_getFieldFromArrStories( $story_key, 'Body' ), ".\n");
								$str_pos = ( $str_pos_new_line <= $str_pos_space )? $str_pos_new_line: $str_pos_space;
								$this->arr_stories[ $story_key ]['Brief']  = substr($this->_getFieldFromArrStories( $story_key, 'Body' ), 0, $str_pos+1);
						}
		
				
					// Third, the story goes in
						$sql =  "INSERT into story ";
						$sql .= "( story_title, story_content, story_brief, story_kicker, story_section_id, story_front_page, ";
						$sql .= "story_url_id, story_issue_date, story_lock_current_issue, story_lock_archives";
						$sql .= ") values (";
						$sql .= $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'Header' ) );
						$sql .= $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'Body' ) );
						$sql .= $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'Brief' ) );
						$sql .= $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'Kicker' ) );
						$sql .= $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'Section' ) );
						$sql .= ($this->_getFieldFromArrStories( $story_key, 'OnCover' ))? $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'OnCover' ) ) : "'2',";
						// Using the date as a unique identifier, for now
						$sql .= $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'Dir' ) .'-'. $this->Get_Data('new_issue_date_month') .'-'. $this->Get_Data('new_issue_date_day') .'-'. $this->Get_Data('new_issue_date_year')   ); //story_issue_date
						$sql .= $this->dbReady( $this->Get_Data('new_issue_date_unix') );
						$sql .= ($this->_getFieldFromArrStories( $story_key, 'Unlock' ))? $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'Unlock' ) ):"'1',"; // Doing the same for both.
						$sql .= ($this->_getFieldFromArrStories( $story_key, 'Unlock' ))? $this->dbReady( $this->_getFieldFromArrStories( $story_key, 'Unlock' ), true ):"'1'";
						$sql .= ")";
						
						$this->Execute( $sql );
						$last_story_insert_id = mysql_insert_id();
						$author_id = NULL;
						
						
					// Third, insert any new authors and join them up with id
						/*
						 
						// Get The AUTHOR
						if( !$this->_getFieldFromArrStories( $story_key, 'Author' ) &&  $this->_getFieldFromArrStories( $story_key, 'Position' )){
		
						//Look up Author, just in case if its a full name
							$sql = "SELECT author_id from author where author_name=". $this->dbReady( trim( $this->_getFieldFromArrStories( $story_key, 'Position' ) ), true );
							$res = $this->ExecuteArray( $sql );
							
							if( is_array( $res )  &&  array_key_exists(0, $res ) ){
									$author_id = $res[0]['author_id'];							
							} else { // You better add the author into the DB or else!
								if( trim( $this->_getFieldFromArrStories( $story_key, 'Position' ) ) ) {
									$sql = "insert into author (`author_name`) values (".$this->dbReady( trim($this->_getFieldFromArrStories( $story_key, 'Position' ) ), true ).")";
									$this->Execute($sql);
									$author_id = mysql_insert_id();
								}
							}
						} else{
							$author_id = $this->_getFieldFromArrStories( $story_key, 'Author' ); // Could return NULL, we don't know
						}

					*/
																// Get The AUTHOR
						$author_id = 0;
						$author_array = NULL;
						
						if( !$this->_getFieldFromArrStories( $story_key, 'Author' ) ){	// No author ID, must be text
							if( $this->_getFieldFromArrStories( $story_key, 'Position' ) ) {
								$author_name =  $this->_getFieldFromArrStories( $story_key, 'Position' );
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
							$author_id = $this->_getFieldFromArrStories( $story_key, 'Author' );
						}
						// NOW - Split the author up into individual authors	

						// !!!!!!!NEW!!!!!!!!!!!!!!

						$author_id_array = $this->_getDBAuthorIDArray( $author_id, $author_array );
						
						if( count($author_id_array)>1 ){
							$multiple_author_counter++;
						}
	
						// Insert the Author(s) into the join table. 
						if( is_array( $author_id_array ) ) {
							$auth_count_x=1;
							foreach( $author_id_array as $aid ) {
								$sql = "INSERT INTO `join-author-story` (`join-author-story_author_id`, `join-author-story_story_id`,`join-author-story_order`) values (";
								$sql .= $this->dbReady( $aid );
								$sql .= $this->dbReady( $last_story_insert_id ) ;
								$sql .= $this->dbReady( $auth_count_x, true ) ;
								$sql .= ")";
								$this->Execute( $sql );
								$auth_count_x++;
							}
						}					
						
						
					// and Last, take a break and enjoy a beverage of your choice
				
				} // End of 
					
			}
		}
	}
	
	private function _getFieldFromArrStories($story_key, $story_item){
		if( array_key_exists( $story_key, $this->arr_stories ) ) {
			if( array_key_exists($story_item, $this->arr_stories[$story_key] ) ){
				return ( trim( $this->arr_stories[ $story_key ][ $story_item ] ) )? $this->arr_stories[ $story_key ][ $story_item ]:NULL;
			}
		}		
	}
	
	private function _getDBAuthorIDArray( $cauthor_id, $cauthor_array ){

		$array_ids_return = array();
		if( !$cauthor_id && is_array($cauthor_array) ){
			foreach( $cauthor_array as $author_a_name ){
				$sql = "SELECT author_id from author where author_name=". $this->dbReady( trim($author_a_name), true );
				$res = $this->Execute( $sql );
				if( mysql_num_rows($res) > 0 ){
					$row = mysql_fetch_row( $res );
					$array_ids_return[] = $row[0];
					
				} else { // You better add the author into the DB or else!
					if( trim($author_a_name) && preg_match('/[a-z]+/', $author_a_name) ) {
						$author_name = trim( str_replace(',','', $author_a_name) );
						
						$sql = "insert into author (author_name) values (".$this->dbReady( trim($author_a_name), true ).")";
						$this->Execute($sql);
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
	
	private function setTheStoneCommonTemplates(){
		$this->Set_Template('header', 'thestone/header-http.php');
		$this->Set_Template('footer', 'thestone/footer-http.php');
	}
	
	private function htmlButTags($str) {

        // Take all the html entities
        $chars = get_html_translation_table(HTML_ENTITIES);
        // Find out the "tags" entities
        $remove = get_html_translation_table(HTML_SPECIALCHARS);
       	// Remove the space char as well
        array_push($remove, "&nbsp;");
        // Spit out the tags entities from the original table
        $chars = array_diff($chars, $remove);
        // Translate the string....
        $str = strtr($str, $chars);

        // And that's it!
        return $str;
    }

    private function _getIssueDates(){
    	$sql = "SELECT * from issue order by issue_date desc";
    	$res = $this->ExecuteArray( $sql );
    	if( is_array($res )) {
    		return $res;
    	}
    }
}
?>