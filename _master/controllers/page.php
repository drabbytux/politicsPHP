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
class Page extends Issue {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Page(){
		$this->__construct();
	}
	
	public function php(){
		phpinfo();
	}

	public function index(){
		$this->Set_Common_Templates();
		$this->Output_Page();
	}

	public function view(){ 

		// View requires var 1 
		if(  $this->_doesStoryExist( $this->Get_URL_Element( VAR_1 ) ) ){		// This will be the story URL id now...

			// Special Member Details
			$this->data['auth_member_menu_items'] 	= '[ <a href="/page/edit/'. $this->Get_URL_Element( VAR_1 ) .'">edit story</a> ]';
			$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
			$this->data['page_type'] = 'story';
			
			// Get the Page Itself
			$this->data_holder['arr_story'] 	= $this->_getStory( $this->Get_URL_Element( VAR_1 ) );
			$this->Set_Data_From_Data_Holder_Array('arr_story');
			
			// Get the extras
			$this->data['story_comments'] 		= $this->getStoryComments( $this->Get_Data( 'story_id' ) );
			$this->_setIssueStoryAuthors( $this->Get_Data( 'story_id' ) );
			$this->_setIssueStoryPhotos( $this->Get_Data( 'story_id' ) );
			$this->_setIssueStoryTags( $this->Get_Data( 'story_id' ) );
			
			// Customization a few of the passed variables
			$this->data['story_date']					= $this->_formatDate( $this->Get_Data_Holder('arr_story', 'story_issue_date') );
			$this->data['story_unix_date']				= $this->Get_Data_Holder('arr_story', 'story_issue_date');
			$this->data['story_content']				= (!$this->Get_Data_Holder('arr_story', 'story_updated') )? $this->_nl2paragraph( $this->Get_Data_Holder('arr_story', 'story_content') ) : $this->Get_Data_Holder('arr_story', 'story_content');
			$this->data['page_title'] 					= $this->setPageTitle( $this->data['story_title'] );

			// Set Generic Header, used by the page view template
			$this->Set_Template( 'template_story_heading_area', 'page/story_heading_area.php');
			
			// Member only page?
			if( $this->_IsAccessGranted( $this->Get_URL_Element( VAR_1 ) ) ) {	
				
				// Click it up a view...
				$this->_AddViewHit( $this->Get_Data( 'story_id' ) );
				
				$this->Set_Template_With_PHP( 'output', 'page/view.php' );	// Uses the previous variables
			} else {			
				$this->data['page_type'] = 'nonmemberstory';
				$this->Set_Message('Please login to view this story', 'message');
				$this->Set_Template( 'output_page_view', 'page/mini_view_non_member.php' );	
				$this->Set_Template( 'output_mini_subscribe', 'member/mini_subscribe.php' );
				$this->Set_Template( 'output_login', 'member/login.form.php');	
				$this->Set_Template( 'output', 'member/splash_non_member_view_story.php', true );	
			}
			
		} else {
			$this->Set_Template( 'output', 'page/404.php' );	// 404 or main page. Hmmmmmm.
		}
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	/**
	 * Retrieves the latest listings from the database.
	 * Originally made for Embassy Ottawa cultural listings, I'm
	 * sure it will come in handy for quick links from the hill times website as well.
	 * 
	 *
	 */
	public function listings(){
		$this->data['page_type'] = 'story';
			if( SITE=='EM'){
				$sql = "SELECT * from story where story_section_id=6 order by story_issue_date desc limit 0,1";
				$res = $this->ExecuteAssoc( $sql );
				if( is_array( $res )){
								$this->data_holder['arr_story'] = $res;
			$this->Set_Data_From_Data_Holder_Array('arr_story');
						// Customization a few of the passed variables
					$this->data['story_date']					= $this->_formatDate( $res['story_issue_date'] );
					$this->data['story_unix_date']				= $res['story_issue_date'] ;
					$this->data['story_content']				= $this->_nl2paragraph( $res['story_content']) ;
					$this->data['page_title'] 					= $this->setPageTitle( $res['story_title'] );
				}
			}

			

			// Set Generic Header, used by the page view template
			$this->Set_Template( 'template_story_heading_area', 'page/story_heading_area.php');

				
		$this->Set_Template_With_PHP( 'output', 'page/view.php' );	// Uses the previous variables
				
		$this->Set_Common_Templates();
		$this->Output_Page();
		
	}
	
	public function printpage(){ 
		// View requires var 1 
		if(  $this->_doesStoryExist( $this->Get_URL_Element( VAR_1 ) ) ){		// This will be the story URL id now...

			// Special Member Details
			$this->data['auth_member_menu_items'] 	= '[ <a href="/page/edit/'. $this->Get_URL_Element( VAR_1 ) .'">edit story</a> ]';
			$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
			$this->data['page_type'] = 'story';
			
			// Get the Page Itself
			$this->data_holder['arr_story'] 	= $this->_getStory( $this->Get_URL_Element( VAR_1 ) );
			$this->Set_Data_From_Data_Holder_Array('arr_story');
			
			// Get the extras
			$this->data['story_comments'] 		= $this->getStoryComments( $this->Get_Data( 'story_id' ) );
			$this->_setIssueStoryAuthors( $this->Get_Data( 'story_id' ) );
			$this->_setIssueStoryPhotos( $this->Get_Data( 'story_id' ) );
			
			// Customization a few of the passed variables
			$this->data['story_date']					= $this->_formatDate( $this->Get_Data_Holder('arr_story', 'story_issue_date') );
			$this->data['story_unix_date']				= $this->Get_Data_Holder('arr_story', 'story_issue_date');
			$this->data['story_content']				= (!$this->Get_Data_Holder('arr_story', 'story_updated') )? $this->_nl2paragraph( $this->Get_Data_Holder('arr_story', 'story_content') ) : $this->Get_Data_Holder('arr_story', 'story_content');
			$this->data['page_title'] 					= $this->data['story_title'].' | '. $this->data['page_title'];

			// Set Generic Header, used by the page view template
			$this->Set_Template( 'template_story_heading_area', 'page/story_heading_area.php');
			
			// Member only page?
			if( $this->_IsAccessGranted( $this->Get_URL_Element( VAR_1 ) ) ) {	
				
				$this->Set_Template_With_PHP( 'output', 'page/print.php' );	// Uses the previous variables
			} else {			
				$this->data['page_type'] = 'nonmemberstory';
				$this->Set_Message('Please login to view this story', 'message');
				$this->Set_Template( 'output_page_view', 'page/mini_view_non_member.php' );	
				$this->Set_Template( 'output_mini_subscribe', 'member/mini_subscribe.php' );
				$this->Set_Template( 'output_login', 'member/login.form.php');	
				$this->Set_Template( 'output', 'member/splash_non_member_view_story.php', true );	
			}
			
		} else {
			$this->Set_Template( 'output', 'page/404.php' );	// 404 or main page. Hmmmmmm.
		}
		$this->Set_Template( 'header', 'common/header-print.php' );
		$this->Set_Template( 'footer', 'common/footer-print.php' );	

		$this->Output_Page();
	}

	
	public function edit(){
		if( $this->MemberAllowed( MEMBER_AUTH_LEVEL_EDITOR ) ){
			if(  $this->_doesStoryExist( $this->Get_URL_Element( VAR_1 ) ) ){

			// Get the Page Itself, and set custom stuff
			$this->data_holder['arr_story'] 	= $this->_getStory( $this->Get_URL_Element( VAR_1 ) );
			$this->Set_Data_From_Data_Holder_Array('arr_story', 'EDIT_');
			$this->data['story_date']					= $this->_formatDate( $this->Get_Data_Holder('arr_story', 'story_issue_date') );
			$this->data['story_unix_date']				= $this->Get_Data_Holder('arr_story', 'story_issue_date');

			$this->data['story_content']				= ( trim( $this->Get_Data_Holder('arr_story', 'story_current_story_dir') ) )? $this->_nl2paragraph( $this->Get_Data_Holder('arr_story', 'story_content'), false, false, true ) : $this->Get_Data_Holder('arr_story', 'story_content');
			$this->Set_Template_With_PHP( 'output', 'page/edit.php' );	// Uses the previous variables	
			$this->Set_Common_Templates();
			$this->Output_Page();
			}
		} else {
			$this->view();	// Not allowed to edit. How about viewing?
		}
	}
	
	public function save(){
		if( $this->MemberAllowed( MEMBER_AUTH_LEVEL_EDITOR ) ){
			$this->_SavePage();
			$this->view();
		} else {
			$this->view();	// Not allowed to edit. How about viewing?
		}
	}
	
	public function cancel(){
		$this->view(); 
	}

	

	public function outputStoryPhotoArea(){
		$str_output = NULL;
		$this->_setIssueStoryPhotos( $this->Get_Data('story_id') );
		$arr_photos = $this->getIssueStoryPhotos( $this->Get_Data('story_id') );
		if( is_array( $arr_photos ) ) {
			$str_output .=  '<div class="photos">';
			if( array_key_exists(0, $arr_photos) ){ // Means there is more than one photo
				foreach( $arr_photos as $ph ) {
					if( file_exists(DIRECTORY_PHOTOS. '/'.$ph['photo_inserted_year'].'/'.$ph['photo_inserted_month'].'/'.LARGE.$ph['photo_file_name'] )) {
					
						list($width, $height) = getimagesize( DIRECTORY_PHOTOS. '/'.$ph['photo_inserted_year'].'/'.$ph['photo_inserted_month'].'/'.LARGE.$ph['photo_file_name'] );
						$str_output .= '<img class="photo" src="'.URL_PHOTOS_DIR.'/'.$ph['photo_inserted_year'].'/'.$ph['photo_inserted_month'].'/'.LARGE. $ph['photo_file_name'].'" /><br />';
						$str_output .= ( $ph['photo_byline'])? '<div class="byline" style="width:'.$width.'px">'. $ph['photo_byline'] . '</div>': NULL;
						$str_output .= ( $ph['photo_cutline'])? '<div class="cutline" style="width:'.$width.'px">'. $ph['photo_cutline'] . '</div>': NULL;
					}
				}
			} else { // only the one photo 
				if( file_exists(DIRECTORY_PHOTOS. '/'.$arr_photos['photo_inserted_year'].'/'.$arr_photos['photo_inserted_month'].'/'.LARGE.$arr_photos['photo_file_name'] )) {
					list($width, $height) = getimagesize( DIRECTORY_PHOTOS. '/'.$arr_photos['photo_inserted_year'].'/'.$arr_photos['photo_inserted_month'].'/'.LARGE.$arr_photos['photo_file_name'] );
					$str_output .= '<img class="photo" src="'.URL_PHOTOS_DIR.'/'.$arr_photos['photo_inserted_year'].'/'.$arr_photos['photo_inserted_month'].'/'.LARGE.$arr_photos['photo_file_name'].'" /><br />';
					$str_output .= ( $arr_photos['photo_byline'])? '<div class="byline" style="width:'.$width.'px">'. $arr_photos['photo_byline'] . '</div>': NULL;
					$str_output .= ( $arr_photos['photo_cutline'])? '<div class="cutline" style="width:'.$width.'px">' . $arr_photos['photo_cutline'] . '</div>': NULL;
				}
			}
			$str_output .= '</div>';
		}
		return $str_output;
	}
	
	public function outputPageComments() {
	$str_output = NULL;
	
	if( $this->Get_Data('story_comments') ) {
		$str_output = "Comments<br />";
			foreach( $this->Get_Data('story_comments') as $comment ){
				$str_output .= '<div style="border-top: 1px #ccc solid; border-bottom: 1px #ccc solid;margin: 5px; ">';
				$str_output .= '<div style="background-color: #eee; font-size: 8pt; border-bottom: 1px #ccc solid;padding: 2px;">';
				$str_output .= (array_key_exists('member_id', $comment ) )? 'Comment by '.$comment['member_name_first']. " " . $comment['member_name_last']:NULL;
				$str_output .= '</div>';
				$str_output .= '<div style="padding: 12px;">';
				$str_output .= $comment['story_comment_text'];
				$str_output .= '</div>';
				$str_output .= "</div>";
			}
		}
	
		return $str_output;

	}
	
	


	// Email This story to a friend - Response from the server via AJAX/SPRY
	public function ajaxResponseEmailThisStory(){
		// POST has been clicked
		if( $this->Get('submit_email_story') ) {
			// Data check - Email from
			if( !$this->_validateEmailSyntax( $this->Get('email_story_email_from') )){
				if( $this->Get('email_story_email_from') ) { 
					$this->Set_Error('Please fill in a proper email address in the FROM field.', 'error_email_story_email_from');
				} else {
					$this->Set_Error('Please fill in your email address.', 'error_email_story_email_from');
				}
			}
			// Data check - Email TO
			if( !$this->_validateEmailSyntax( $this->Get('email_story_email_to') )){
				if( $this->Get('email_story_email_to') ) { 
					$this->Set_Error('Please fill in a proper recipient email address.', 'error_email_story_email_to');
				} else {
					$this->Set_Error('Please fill in a recipient email address.', 'error_email_story_email_to');
				}
			}
			// Data check - check to make sure each field is free of spam crap
			$this->scrub_exploits( $this->Get('email_story_email_from') );
			$this->scrub_exploits( $this->Get('email_story_email_tp') );
			$this->scrub_exploits( $this->Get('email_story_message') );
			$this->scrub_exploits( $this->Get('story_title') );
			$this->scrub_exploits( $this->Get('story_url_id') );
			
			// No errors, sent it out.
			if( !$this->Has_Errors() ) {
				$this->Set_Template('email_message', 'tidbits/email_story_to_a_friend_EMAIL_TEMPLATE.php');
				if( $this->sendCleanEmail( $this->Get_Data('email_story_email_to'), $this->Get_Data('email_story_email_from'), 'Embassy - Canada\'s Foreign Policy Newsweekly', $this->Get_Data('email_message') ) ) {
					$this->data['response_output'] = '<div id="highlighter_email">This story has been mailed to '. $this->Get('email_story_email_to') .'.</div>';
					$this->data['response_output'] .= '<br /><input type=submit value="Send this story to someone else" />';	
					$this->_AddEmailHit( $this->Get('story_id') );
				}
				

			} else {
				$this->Set_Template('response_output','tidbits/email_story_to_a_friend.php', true );
			}
		} else {
			$this->Set_Template('response_output','tidbits/email_story_to_a_friend.php', true );
		}
		
		// Remeber to reset the incoming POST vars if there were no errors so it won't show up
		// when we display the form again.
		print $this->data['response_output'];
	}
	
	
	public function ajaxResponsePublicComment() {
// POST has been clicked
		if( $this->Get('submit_public_comment') ) {
			
			// Data check - Name
			if( !$this->Get('public_comment_name') ){
				$this->Set_Error('Please fill your name.', 'error_public_comment_name');
			}
			
			// Data check - Email
			if( !$this->_validateEmailSyntax( $this->Get('public_comment_email') )){
				if( $this->Get('public_comment_email') ) { 
					$this->Set_Error('Please fill in a proper email address.', 'error_public_comment_email');
				} else {
					$this->Set_Error('Please fill in your email address.', 'error_public_comment_email');
				}
			}
			// Data Check - Comment
					if( !$this->Get('public_comment_comment') ){
				$this->Set_Error('Please fill in the comment field.', 'error_public_comment_comment');
			}

			// Data check - check to make sure each field is free of spam crap
			$this->scrub_exploits( $this->Get('public_comment_name') );
			$this->scrub_exploits( $this->Get('public_comment_email') );
			$this->scrub_exploits( $this->Get('public_comment_comment') );
			$this->scrub_exploits( $this->Get('story_title') );
			$this->scrub_exploits( $this->Get('story_url_id') );
			$this->scrub_exploits( $this->Get('story_id') );

			// No errors, sent it out.
			if( !$this->Has_Errors() ) {
			
				if( $this->saveStoryCommentInDB() ) {
					$this->sendCleanEmail(EMAIL_WEBMASTER, EMAIL_ADDRESS_SYSTEM_1, 'New public comment made', 'Check it out.');
					$this->data['response_output'] = '<div id="highlighter_comment">Thanks for your comments. We will post them shortly.</div>';
				}
			} else {
				//$this->data['response_output'] = "errors";
				$this->Set_Template('response_output','tidbits/public_comment_form.php', true );
			}
		} else {
				//$this->data['response_output'] = "nothing found";
			$this->Set_Template('response_output','tidbits/public_comment_form.php', true );
		}
		
		// Remeber to reset the incoming POST vars if there were no errors so it won't show up
		// when we display the form again.
		print $this->data['response_output'];
	}
	

public function ajaxResponseLetter() {
// POST has been clicked
		if( $this->Get('submit_letter') ) {
			
			// Data check - Name
			if( !$this->Get('letter_name') ){
				$this->Set_Error('Please fill in your name.', 'error_letter_name');
			}
			
			// Data check - Email
			if( !$this->_validateEmailSyntax( $this->Get('letter_email') )){
				if( $this->Get('letter_email') ) { 
					$this->Set_Error('Please fill in a proper email address.', 'error_letter_email');
				} else {
					$this->Set_Error('Please fill in your email address.', 'error_letter_email');
				}
			}
			// Data check - City
			if( !$this->Get('letter_city') ){
				$this->Set_Error('Please fill your city.', 'error_letter_city');
			}
			// Data check - Prov/State
			if( !$this->Get('letter_prov') ){
				$this->Set_Error('Please fill your province/state (or country).', 'error_letter_prov');
			}
			// Data Check - Letter Body
					if( !$this->Get('letter_letter') ){
				$this->Set_Error('Please fill in the letter field.', 'error_letter_letter');
			}

			// Data check - check to make sure each field is free of spam crap
			$this->scrub_exploits( $this->Get('letter_name') );
			$this->scrub_exploits( $this->Get('letter_email') );
			$this->scrub_exploits( $this->Get('letter_city') );
			$this->scrub_exploits( $this->Get('letter_prov') );
			$this->scrub_exploits( $this->Get('letter_phone') );
			$this->scrub_exploits( $this->Get('letter_position') );
			$this->scrub_exploits( $this->Get('letter_letter') );
			$this->scrub_exploits( $this->Get('story_title') );
			$this->scrub_exploits( $this->Get('story_url_id') );
			$this->scrub_exploits( $this->Get('story_id') );
			

			// No errors, sent it out.
			if( !$this->Has_Errors() ) {
				$this->Set_Template('email_message', 'tidbits/letter_EMAIL_TEMPLATE.php');
				if( $this->sendCleanEmail( EMAIL_EDITOR, EMAIL_ADDRESS_SYSTEM_1, EMAIL_SUBJECT_LETTER_SUBMISSION, $this->Get_Data('email_message') ) ) {
					$this->data['response_output'] = '<div id="highlighter_letter">Your letter has been delivered.</div>';
				}

			} else {
				//$this->data['response_output'] = "errors";
				$this->Set_Template('response_output','tidbits/letter_form.php', true );
			}
		} else {
				//$this->data['response_output'] = "nothing found";
			$this->Set_Template('response_output','tidbits/letter_form.php', true );
		}
		
		// Remeber to reset the incoming POST vars if there were no errors so it won't show up
		// when we display the form again.
		print $this->data['response_output'];
	}
	
	
	
	
	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\
	

	private function sendCleanEmail( $to, $from, $subject, $message ){
		if( mail($to,$subject, $message, "From: $from") ){
			return true;		
		}
	}

	private function saveStoryCommentInDB(){
		$sql = "INSERT into story_comment (story_comment_story_id, story_comment_text, story_comment_member_id, story_comment_email, story_comment_ip_address, story_comment_date)";
		$sql .= " values (";
		$sql .= $this->dbReady( $this->Get('story_id') );
		$sql .= $this->dbReady( $this->Get('public_comment_comment') ) ;
		$sql .= $this->dbReady( $this->Get_Session('member_id') ) ;
		$sql .= $this->dbReady( $this->Get('public_comment_email') ) ;
		$sql .= $this->dbReady( $_SERVER['REMOTE_ADDR']) ;
		$sql .= $this->dbReady( mktime(), true ) ;
		$sql .= ")";

		$res = $this->Execute( $sql );
		if( $res ){
			return true;
		}
	}
	
	private function getStoryComments( $story_id ){
		$sql = "SELECT sc.*, m.member_name_first, m.member_name_last from story_comment as sc left join member as m on (sc.story_comment_member_id = m.member_id) where sc.story_comment_story_id=$story_id";
		$sql .= " and story_comment_status=". STATUS_LIVE;
		$res = $this->ExecuteArray( $sql );
		if( is_array( $res ) ){
			return $res;
		}
	}
	
	private function _AddViewHit( $story_id ){
		$sql = "UPDATE story set story_hit_view=story_hit_view+1 where story_id=$story_id";
		$this->Execute($sql);
	}

	private function _AddEmailHit( $story_id ){
		$sql = "UPDATE story set story_hit_email=story_hit_email+1 where story_id=$story_id";
		$this->Execute($sql);
	}
	/**
	 * _IsAccessGranted
	 * Returns true based on if the story is locked and if the member is logged in
	 *
	 * @param unknown_type $story_id
	 * @return unknown
	 */
	private function _IsAccessGranted( $story_id ){
		$arr_story_security_elements = $this->_getStory( $story_id, true);	// will return story_lock_current_issue, story_lock_archives

		// Is story a part of the current issue? Check the current issue lock status
		if( $arr_story_security_elements['story_issue_date'] == $this->_getLatestIssueDate() ){
			if( $arr_story_security_elements['story_lock_current_issue'] == STORY_LOCKED ){
				if( $this->MemberAllowed() ) {
					return true;
				}
			} else if ( $arr_story_security_elements['story_lock_current_issue'] == STORY_UNLOCKED ) {
				return true;
			}
		} else { // Now an archived file - use the archive lock
			if( $arr_story_security_elements['story_lock_archives'] == STORY_LOCKED ) {
				if( $this->MemberAllowed() ) {
					return true;
				}
			} else if ( $arr_story_security_elements['story_lock_archives'] == STORY_UNLOCKED ) {
					return true;
			}
		}
	}
	
	
	private function _getStory( $id, $security_code_only = NULL ){
		if($id){
			$sql_selection = ($security_code_only)? "story_issue_date, story_lock_current_issue, story_lock_archives":'*';	// Fetch security settings or ALL
			if( is_int( $id ) ) {
				$sql = "SELECT " . $sql_selection . " from story where story_id='$id'";
			} else {
				$sql = "SELECT " . $sql_selection . " from story where story_url_id='". $this->_folderFriendlyVariable( $id ). "'";
			}
			return $this->ExecuteAssoc($sql);
		}

	}

	

	private function _doesStoryExist( $id ){
		if( $id ){
			if( is_int( $id ) ) {
				$sql = "SELECT story_id from story where story_id='$id'";
			} else {
				$sql = "SELECT story_id from story where story_url_id='". $this->_folderFriendlyVariable( $id ). "'";
			}
			
			$res = $this->Execute($sql);
			if( mysql_num_rows( $res ) >= 1 ){
				return true;
			}
		}
		return false;	
	}
	
	
	private function _SavePage() {
		if( $this->_doesStoryExist( $this->Get_URL_Element( VAR_1 ) ) ) {
			//Update existing story
			$sql  = "UPDATE story set ";
			$sql .= 'story_title='. 			$this->Get_DB_Ready('story_title')  			. ", ";
			$sql .= 'story_content='.			$this->Get_DB_Ready('story_content')  			. ", ";
			$sql .= 'story_kicker='.			$this->Get_DB_Ready('story_kicker')  			. ", ";
			$sql .= 'story_cutline='.			$this->Get_DB_Ready('story_cutline')  			. ", ";
			$sql .= 'story_author_id='.			$this->Get_DB_Ready('story_author_id')  		. ", ";
			$sql .= 'story_section_id='.		$this->Get_DB_Ready('story_section_id')  		. ", ";
			$sql .= 'story_super_section_id='.	$this->Get_DB_Ready('story_super_section_id')  	. ", ";
			$sql .= 'story_current_story_dir='.	$this->Get_DB_Ready('story_current_story_dir')  . ", ";
			// $sql .= 'date='.					$this->Get_DB_Ready('story_date')  				. ", ";
			$sql .= 'story_status='.			$this->Get_DB_Ready('story_status')  			. ", ";
			$sql .= 'story_updated='.			"'". time() ."'"		;
			$sql .= " WHERE story_id=".			$this->Get_URL_Element( VAR_1 );
			
			$res = $this->Execute( $sql );
			$this->Set_Message('Story saved successfully', 'auth_message');
		} else {
			//Insert new story
			$sql = "INSERT into story";
			$sql .= " (story_title, story_content, story_kicker, story_cutline, story_author_id, story_section_id, story_super_section_id, story_current_story_dir, story_issue_date, story_status, story_updated )";
			$sql .= " values (";
			$sql .= $this->Get_DB_Ready('story_title')  				. ", ";
			$sql .= $this->Get_DB_Ready('story_content')  			. ", ";
			$sql .= $this->Get_DB_Ready('story_kicker')  			. ", ";
			$sql .= $this->Get_DB_Ready('story_cutline')  			. ", ";
			$sql .= $this->Get_DB_Ready('story_author_id')  			. ", ";
			$sql .= $this->Get_DB_Ready('story_section_id')  		. ", ";
			$sql .= $this->Get_DB_Ready('story_super_section_id')  	. ", ";
			$sql .= $this->Get_DB_Ready('story_current_story_dir')  	. ", ";
			// $sql .= $this->Get_DB_Ready('story_date')  				. ", ";
			$sql .= $this->Get_DB_Ready('story_status')  			. ", ";
			$sql .= "'".	 time()  ."'"								;
			$sql .= ")";
			$res = $this->Execute( $sql );
			$this->Set_Message('The New story created successfully', 'auth_message');
		}
	}
	
	/**
	 * This has to be redone to incorporate the new rules of markup DB storage
	 */
	private function _nl2paragraph( $str, $paragraph_class = NULL, $dropcap_class = NULL, $edit_with_plain_paragraphs = NULL ) { 
		$str = ($edit_with_plain_paragraphs)? str_replace(" \n", '<p>', $str) : str_replace("\n", "\n". '<p>', $str);
		$str = ($edit_with_plain_paragraphs)? str_replace(" \r", '<p>', $str) : str_replace("\n", "\n". '<p>', $str);
		$first_char = substr( $str, 0, 1 );
		if( $first_char != "<" && $first_char != ">" && !$edit_with_plain_paragraphs ) {
			return substr_replace( $str, '<p><span class="dropcap_2">'.$first_char.'</span>',0,1);
		} else if( !$edit_with_plain_paragraphs ) {
			return "\n". '<p>'. $str;
		} else {
			return "\n". '<p>'. $str;
		}
	
	}
	

}
?>