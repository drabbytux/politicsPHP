<?php
/**
 * ------------------
 * Mobile Controller - Mobile version
 * ------------------
 * Created by David Little
 * March 2008
 * Modified History
 * - - - - - - - - - - -
 * March, 2008 -  Started
 * 
 * - - - - - - - - - - - 
 * 
 */


require_once 'classes/controller.class.php';
require_once 'controllers/issue.php';
class Mobile extends Issue {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Mobile(){
		$this->__construct();
		$this->data['page_type'] = 'mobile';
	}
	
	/**
	 * Index - If called (from where, I don't know), show entire list of sectional information
	 * Soon to be dynamic
	 */
	public function index(){
		$this->data['story_list_array'] = $this->_fetchStories( 1, 0, 6 ); 	// 1 = news section id
		$this->Set_Template( 'output', 'mobile/index.php' );	// Default page with everything
		$this->_setMobileCommon();
		$this->Output_Page();
	}

	public function story(){
		// View requires var 1 
		if(  $this->_doesStoryExist( $this->Get_URL_Element( VAR_1 ) ) ){		// This will be the story URL id now...

			// Special Member Details
			$this->data['page_type'] = 'story';
			
			// Get the Page Itself
			$this->data_holder['arr_story'] 	= $this->_getStory( $this->Get_URL_Element( VAR_1 ) );
			$this->Set_Data_From_Data_Holder_Array('arr_story');
			
			// Get the extras
			$this->_setIssueStoryAuthors( $this->Get_Data( 'story_id' ) );
			$this->_setIssueStoryTags( $this->Get_Data( 'story_id' ) );
			
			// Customization a few of the passed variables
			$this->data['story_date']					= $this->_formatDate( $this->Get_Data_Holder('arr_story', 'story_issue_date') );
			$this->data['story_unix_date']				= $this->Get_Data_Holder('arr_story', 'story_issue_date');
			$this->data['story_content']				= (!$this->Get_Data_Holder('arr_story', 'story_updated') )? $this->_nl2paragraph( $this->Get_Data_Holder('arr_story', 'story_content') ) : $this->Get_Data_Holder('arr_story', 'story_content');
			$this->data['page_title'] 					= $this->setPageTitle( $this->data['story_title'] );

			
			$this->Set_Template_With_PHP( 'output', 'mobile/story.php' );	// Uses the previous variables
			// Member only page?
			/*
			if( $this->_IsAccessGranted( $this->Get_URL_Element( VAR_1 ) ) ) {	
				
				
			} else {			
				$this->data['page_type'] = 'nonmemberstory';
				$this->Set_Message('Please login to view this story', 'message');
				$this->Set_Template( 'output_page_view', 'page/mini_view_non_member.php' );	
				$this->Set_Template( 'output_mini_subscribe', 'member/mini_subscribe.php' );
				$this->Set_Template( 'output_login', 'member/login.form.php');	
				$this->Set_Template( 'output', 'member/splash_non_member_view_story.php', true );	
			}
			*/
			
		} else {
			$this->Set_Template( 'output', 'page/404.php' );	// 404 or main page. Hmmmmmm.
		}
		// $this->Set_Common_Templates();
		$this->_setMobileCommon();
		$this->Output_Page();
	}

	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\

	/**
	 * _fetchStories retrieves the stories with a given integer ID OR
	 * an array of integers, for multiple section gathering.
	 *
	 * @param unknown_type $story_section_id
	 * @param unknown_type $start_row
	 * @param unknown_type $num_rows
	 * @return unknown
	 */
	public function _fetchStories( $story_section_id, $start_row=0, $num_rows=20 ){
		$sql_elements = NULL;
		if( is_array( $story_section_id) ){
			foreach( $story_section_id as $key=>$id ) {
				$sql_elements .= 'story_section_id='.$id;
				$sql_elements .= ( $key < (count( $story_section_id)-1) )? ' OR ' : NULL;
			}
		} else {
			$sql_elements = 'story_section_id='.$story_section_id;
		}
		$sql =  "SELECT * from story where ".$sql_elements;
		$sql .= " order by story_issue_date desc limit $start_row, $num_rows";
		$res = $this->ExecuteArray( $sql );
		if( is_array( $res )) {
			return $res;
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
	
	private function _setMobileCommon(){
		$this->Set_Template( 'header', 'mobile/header.php' );
		$this->Set_Template( 'footer', 'mobile/footer.php' );
		
	}
	

}
?>