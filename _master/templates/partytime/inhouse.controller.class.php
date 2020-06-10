<?php

/**
 * InHouse Controller Class
 * Model
 * 
 * A global class with specific, in-house functions found globally across the website
 * Extends the Master Class, and is extended by all other controllers within the site.
 * 
 * This keeps site specific modules and logic out of the master controller to keep it clean with
 * only the basic stuff
 * 
 */

require_once('classes/controller.class.php');
class InHouseController extends Controller {
	
	function InHouseController(){
		$this->__construct();
	}
	
	public function outputColumnistScrollerHTML(){
		$html_output = NULL;
		
		$arr_dir = scandir( DIRECTORY_PHOTOS . '/columnists/scroller');
		if( is_array( $arr_dir ) ) {
			foreach( $arr_dir as $photo ) {
				if( strstr($photo, '.jpg' ) ) {
					$html_output .= '<div class="glidecontent">' . "\n";
					 $html_output .= '<table style="width: 100%;"><tr><td style="width: 100px;"><img src="'. URL_PHOTOS_DIR . '/columnists/scroller/'. $photo .'" /></td>' . "\n";
					 $html_output .= '<td style="width: 200px; background-image: url(\'/site/images/backgrounds/scroller.gif\');">';
					 // Send out the info for this photo/author id
					 $arr_author_details = $this->getAuthorScrollerDetails($photo);
					
					$html_output .= '<h3>'.$arr_author_details['author_name'].'</h3>';
					$html_output .= '<a href="/view/page/'.$arr_author_details['story_url_id'].'">'. $arr_author_details['story_title'].'</a>'; 
					$html_output .= '</td></tr></table>';
					 $html_output .= '</div>' . "\n";
			}
			}
		}
		return $html_output;
	}
	
	public function getAuthorScrollerDetails($photo){
		$auth_arr = explode(".", $photo);
		if( array_key_exists(0, $auth_arr ) ){
			$sql = "Select * from author where author_id=". $auth_arr[0];
			$author = $this->ExecuteAssoc($sql);
			
			if( $author ){
				$sql = "SELECT s.story_title, s.story_issue_date, s.story_url_id from story s left join `join-author-story` on ( `join-author-story_author_id`= ". $auth_arr[0] ." )";
				$sql .= " where story_issue_date <=". mktime() . " and story_status=". STATUS_LIVE;
				$sql .= "  and `join-author-story_story_id`=s.story_id";
				$sql .= " order by story_issue_date desc limit 0,1";
				
				$story = $this->ExecuteAssoc( $sql );
			}
		}
		
		$arr_data = array_merge( $author, $story);
		return $arr_data;
	}
	
	/**
	 * Any piece of HTML that should be kept as a static file
	 * can be placed within the public_embedded_html folder
	 * and called into a DB entry.
	 *
	 * @param unknown_type $file_in_pubilc_folder
	 */
	public function Output_Public_Piece( $file_in_pubilc_folder ){
		if( file_exists( DIRECTORY_TEMPLATES. 'public_embedded_html/'. $file_in_pubilc_folder ) ){
			$this->Set_Template( 'public_seg', 'public_embedded_html/'. $file_in_pubilc_folder );
			return $this->Get_Data('public_seg');
		}
	}
	/** ---------- Box Modules ---------- **/
	
	/**
	 * MostEmailed - Query for the Most Emailed stories
	 * 
	 * @return array 
	 *
	 */
	public function MostEmailed( $limit = 5 ){
		$sql = "SELECT story_url_id, story_title from story";
		$sql .= " where story_issue_date >=" . strtotime("-1 month");
		$sql .= " order by story_hit_email desc limit " . $limit;
		$arr_res = $this->ExecuteArray( $sql );
		if( is_array( $arr_res ) ){
			return $arr_res;
		}
	}
	
	/**
	 * MostViewed - Query for the Most  Viewed stories this month
	 * 
	 * @return array 
	 *
	 */
	public function MostViewed( $limit = 5 ){
		$sql = "SELECT story_url_id, story_title from story";
		$sql .= " where story_issue_date >=" . strtotime("-1 month");
		$sql .= " order by story_hit_view desc limit " . $limit;
		$arr_res = $this->ExecuteArray( $sql );
		if( is_array( $arr_res ) ){
			return $arr_res;
		}
	}
	
	/**
	 * MostSearched - Query for the most searched stories
	 *
	 * @param unknown_type $limit
	 * @return unknown
	 */
	public function MostSearched( $limit = 5 ){
		$sql = "SELECT story_url_id, story_title from story";
		$sql .= " where story_issue_date >=" . strtotime("-1 month");
		$sql .= " order by story_hit_email desc limit " . $limit;
		$arr_res = $this->ExecuteArray( $sql );
		if( is_array( $arr_res ) ){
			// return $arr_res;
		}
	}
	
	
	public function policy_briefing_side(){
		$str_out = NULL;
		
		// Retrieve the latest pb 
		$sql = "SELECT * from policy_briefing where policy_briefing_publish_date <= '".mktime()."' order by policy_briefing_publish_date desc limit 1";

		$pb_latest = $this->ExecuteAssoc( $sql );

		// and get the next one coming up.
		$sql = "SELECT * from policy_briefing where policy_briefing_publish_date >= '".mktime()."' order by policy_briefing_publish_date asc limit 1";
		$pb_coming = $this->ExecuteAssoc( $sql );
		
		$str_out .= '<table style="width: 280px;">';
		$str_out .= (is_array($pb_latest))? '<tr><td style="background: transparent; width: 100px;"><small>'. $this->_formatDate( $pb_latest['policy_briefing_publish_date'] ) . '</small></td><td style="background: transparent; width: 200px;"><a href="/reports/2008/120308_pb.pdf">'. $pb_latest['policy_briefing_title'] .'</a></td></tr>' : NULL;
		$str_out .= (is_array($pb_coming))? '<tr><td style="border-top: 1px #ccc solid; background: transparent; width: 100px;"><small>'. $this->_formatDate( $pb_coming['policy_briefing_publish_date'] ) . '</small></td><td style="border-top: 1px #ccc solid;background: transparent; width: 200px;">'. $pb_coming['policy_briefing_title'].'</td></tr>' : NULL;
		$str_out .= '</table>';
		// $str_out .= '<a href="" style="font-size: 8pt;font-family: verdana;">View the schedule</a>';
		return $str_out;
	}
	
	/**
	 * Returns the first paragraph of a string passed
	 *
	 * @param unknown_type $str
	 */
	public function Return_First_Paragraph( $str ){
		$p_exists = strpos( $str, '</p>');
		$br_exists = strpos( $str, '<br');
		if( $p_exists )	{ // If the end of paragraph exists, send it back. 

			return substr( $str, 0, $p_exists );
		} else if ( $br_exists ) { // No paragraph exists. Find the first BR
			return substr( $str, 0, $br_exists );
		} else { // No breaks are found. Send back a limited amount of chars with '...'
			$sub_str = substr( $str, 0, NUMBER_CHARS_RETURN_MEMBER_ONLY );
			if( $sub_str ) {
				$whole_word_sub_str_pos = strpos( $sub_str, ' ', NUMBER_CHARS_RETURN_MEMBER_ONLY - 20 );
				return substr( $sub_str, 0 , $whole_word_sub_str_pos ) . '...';
			}
		}
	}
	
	/**
	 * A quick alias to Get_Folder_name_for_view
	 *
	 * @param unknown_type $folder_name
	 * @param unknown_type $revert_to_original
	 */
	public function toURL($folder_name, $revert_to_original = NULL, $unix_date = NULL){
		return $this->Get_Folder_Name_For_View($folder_name, $revert_to_original, $unix_date);
}
	/**
	 * Fixes the issue of folder structures being passed as variables in the URL
	 *
	 * @param unknown_type $folder_name
	 * @param unknown_type $revert_to_original
	 * @return unknown $compare_date will not worry about doing anything if it's later than live date
	 */
	public function Get_Folder_Name_For_View( $folder_name, $revert_to_original = NULL, $compare_date = NULL ){
		// One thing about the issue result vars: the slashes are in the wrong place when
		// associated to the story DB entries. Yuk. Fix em here.
		if( $compare_date && $folder_name  ){
			if( $compare_date >= NEW_SITE_LIVE_DATE ) {
				return $folder_name;
				exit();
			} else {
				if( $folder_name ){
					if( $revert_to_original ){
						return str_replace('.','/', ltrim( $folder_name, '/') );
					} else {
						$folder_name =  '/'. trim( $folder_name, '/');
						return str_replace('/','.', $folder_name); 
					}
				}
			}
		} else {
			return $folder_name;
		}

		
	}
	
	public function _folderFriendlyVariable( $folder_var )	{ // Returns the URL with '.' replaced with '/' for older versions of story
		return str_replace('.','/', $folder_var); 
	}
	
	public function _formatDate( $date ){
		return date('F j Y', $date);
	}
	
	public function _URLToUnixDate( $date, $dateIsAlreadyUnix=NULL, $format = NULL ){
		if( $dateIsAlreadyUnix ){
			return ($format)? date($format, $date) : date('Y-m-d', $date);
		} else {
			$arr_date = explode('-', $date);
			return mktime( 0,0,0, $arr_date[1], $arr_date[2], $arr_date[0] );
		}		
	}
	
	public function setPageTitle( $pageTitle = NULL ){
		if( $pageTitle) {
			$this->data['page_title'] = $pageTitle . " | ". $this->Get_Data('page_title');
		}
	}

	public function xmlTag($name, $value, $arr_attributes = NULL){
		$str_return = "<". str_replace(' ', '_', $name);
		if ( $arr_attributes && is_array( $arr_attributes ) ){
			foreach( $arr_attributes as $key=>$val){
				$str_return .= ' $key="'. $val . '"';
			}
		}
		$str_return .= ">".$value;
		$str_return .= "</". str_replace(' ', '_', $name) . ">\n";
		return $str_return;
	}
}



?>