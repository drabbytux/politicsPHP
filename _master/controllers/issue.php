<?php
/**
 * ------------------
 * Issue Controller
 * ------------------
 * Created by David Little
 * August 2007
 * Modified History
 * - - - - - - - - - - -
 * Nov 19, 2007 -  Now used to extend the Page controller.
 * 
 * - - - - - - - - - - - 
 * 
 */


require_once 'classes/inhouse.controller.class.php';
class Issue extends InHouseController {
	public $issueXML = NULL;
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Issue( $ignoreURLSet = NULL ){
		$this->__construct( $ignoreURLSet );
	}

	public function index(){
		$this->view();
	}

	public function view(){
		// View requires var 1 
		
			// $this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor

			// Special Member Details
			$this->data['auth_member_menu_items'] 	= '[ <a href="/page/edit/'. $this->Get_URL_Element( VAR_1 ) .'">edit story</a> ]';
			$this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
			$this->data['page_type'] = 'story';
			
			// Issue data stuff
				$this->data_holder['arr_issue'] 		= $this->_getIssue( $this->Get_URL_Element( VAR_1 ) );
				$this->Set_Data_From_Data_Holder_Array('arr_issue');
				$this->data['page_type'] = 'issue';
				if( $this->Get_Data('issue_template_file') ){
					$this->setIssueTemplate();
				}
				if( $this->Get_Data('issue_old_array_content') ) {
					// Pre 2007 Array methodology
					$this->_crunchOldResultArrayData();
				} else { 
					// The POST 2007 stuff
					$this->_setIssueStories( $this->Get_Data('issue_date') );					
				}
			$this->data['issue_date'] =	$this->_formatDate( $this->Get_Data_Holder('arr_issue', 'issue_date')); // Set the issue date
			// Issue throw override photo - just uploaded the file will cause this
			$this->data['normal_throw'] = $this->doesNormalThrowExist( $this->Get_Data_Holder('arr_issue', 'issue_date') );
			
			
			// Embassy Specific Stuff
			if( SITE=='EM') {
				$this->_setTalkingPoints();
				$this->Set_Template( 'talking_points_highlight', 'issue/talking_points_highlight_box.php'); // Talking Points
				
				// Set the rotation Items for this issue
				$this->setRotationItems();
			}
			

			 	
			$this->Parse_PHP_String('compiled_issue', $this->Get_Data('issue_template_body' ) ); // Populate the template
			$this->Set_Template( 'output', 'issue/view.php' );	// Uses the previous variables
				
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	/**
	 * takes the TPs out of issue_stories array, if any, and sets the talking_point_random and talking_point_items
	 * 
	 */ 
	
	private function _setTalkingPoints(){
		if( $this->Get_Data('formatted_issue_stories') && array_key_exists( TALKING_POINTS, $this->Get_Data('formatted_issue_stories') ) ) {
			$this->data['talking_point_items'] = $this->data['formatted_issue_stories'][TALKING_POINTS];
			if( is_array( $this->data['talking_point_items'] ) && count( $this->data['talking_point_items'] )){
				$this->data['taling_point_random_number'] = rand(0, (count( $this->data['talking_point_items'] )-1) );
				$this->data['talking_point_random'] =  $this->data['talking_point_items'][ $this->data['taling_point_random_number'] ];
			}
		}
	}
	
	/**
	 * Display the list of issues available for
	 * viewing. Member only security should be put in 
	 * place here
	 */
	public function archive(){
		
		if( !$this->Get_URL_Element( VAR_2 ) && !$this->Get_URL_Element( VAR_1 ) ) { // No year or date available - set em up
			$this->Set_URL_Element( VAR_1 , $this->_getLatestIssueDate(true, NULL, 'Y') );	// Set The Year
			$this->Set_URL_Element( VAR_2 , $this->_getLatestIssueDate(true) );				// Entire Date
		} else if( !$this->Get_URL_Element( VAR_2 ) && $this->Get_URL_Element( VAR_1 ) ) { // We have a year, but no date
			$this->Set_URL_Element( VAR_2 , $this->_getLatestIssueDate(true, $this->Get_URL_Element( VAR_1 )) ); // Entire Date
		}
		$this->_setAllIssueDates();
		$this->_getArchiveIssues( $this->Get_URL_Element( VAR_1 ) );	// Retrieve all the issues, defaults to the current year to display, and current issue
		$this->data['current_date_selected_URL'] 	= $this->Get_URL_Element( VAR_2 );
		$this->data['current_date_selected'] 		= $this->_URLToUnixDate( $this->Get_URL_Element( VAR_2 ) );
		$this->_getStoryHeadlinesForIssue();		// Get Current Headlines

		//	'all_issues'
		$this->_getAvailableArchiveYears();	
		$this->Set_Template( 'output', 'issue/archive.php' );	// Uses the previous variables
		
		// Output
		$this->Set_Common_Templates();
		// $this->Set_Template( 'footer', 'issue/archive_footer.php' );	// Uses the previous variables
		$this->Output_Page();
	}
	
	public function Get_Story_ID_By_Folder_Name( $folder_URL ){
		if($folder_URL){
			$folder_URL = rtrim($folder_URL, '/');
			$sql = "SELECT story_id from story where story_current_story_dir='$folder_URL'";
			$arr_id =  $this->ExecuteAssoc($sql);
			return $arr_id['story_id'];
		}
	}
	
	
	public function authorPhotoExists($author_id, $small_large = 'small'){
		if( file_exists( PATH_TO_COLUMNIST_PHOTOS . '/headshots/'. $small_large .'/'. $author_id . '.jpg') ) {
			return URL_TO_COLUMNIST_PHOTOS . '/headshots/'.$small_large .'/'. $author_id . '.jpg';
		}
	}
	
	
	/**
	 * Get a URL based on a sortable 3rd variable
	 * The normal get_URL doesn't work, since it appends it each time,
	 * so we check for the 3rd variable first before we send it back.
	 * 
	 */
	public function Get_Sort_URL(){
		if( $this->Get_URL_Element( VAR_3 ) ) {
			return $this->Get_Current_URL( VAR_2 );
		} else {
			return $this->Get_Current_URL();
		}
		
	}
	
	
	/**
	 * Pass it either an array or a single ID
	 * Will fetch the array of author ids when you pass it a story id, or if a story id is already set.
	 * $story_id is either an array or a single int
	 */
	public function _fetchAuthorsForStoryID( $story_id = NULL, $return_array=false ){
		if( is_array($story_id) ){
			$x=0;
			$sql = "SELECT *, `join-author-story_author_id` from `join-author-story` where `join-author-story_story_id`=";
			foreach( $story_id as $val ){
				$sql .= "'$val'";
				$x++;
				$sql .= ( $x < count( $story_id ) )? ' OR `join-author-story_story_id`=':NULL;
			}
		} else {
			$story_id = ($story_id)? $story_id: $this->Get_Data('story_id');
			$sql = "SELECT * from `join-author-story` where `join-author-story_story_id`='$story_id'";
		}
		if( $return_array ){
			return $this->ExecuteArray($sql);
		} else {
			$this->data_holder['story_author_ids'] = $this->ExecuteArray($sql);
		}
	
	}
	
	/**
	 * Send it either an array or int id(s) of the authors.
	 * If is NULL, will look to story_author_ids data holder
	 * Will return an array of id(s)
	 * FOR ARRAYS:
	 * Array in -> array('45','23');
	 * Array out -> array( array('45', 'Arthur Sukin', '[image.jpg]', etc...) );
	 * 
	 */
	public function _getAuthors( $arr_or_int_of_author_id = NULL, $just_return_array = false ) {
		$arr_authors = NULL;
		if( is_array($arr_or_int_of_author_id) ){
			foreach( $arr_or_int_of_author_id as $id ){
				if($id){
					$sql = "SELECT * from author where author_id='$id'";
					$res = $this->ExecuteAssoc($sql);
					$arr_authors[] = $res;
				}
			}	
		} else if( $arr_or_int_of_author_id ) {
			$sql = "SELECT * from author where author_id='$id'";
			$res = $this->ExecuteAssoc($sql);
			$arr_authors[] = $res;
		} else if( $this->Get_Data_Holder('story_author_ids') ){	// Nothing was passed, so check the author id Array
			foreach( $this->Get_Data_Holder('story_author_ids') as $id ){
				if( $id['join-author-story_author_id'] ){
					$sql = "SELECT * from author where author_id='".$id['join-author-story_author_id']."'";
					$res = $this->ExecuteAssoc($sql);
					$arr_authors[] = array_merge($id, $res);
				}
			}
		}
		
		if( $just_return_array ){ 
			return $arr_authors;
		} else {
			$this->data_holder['authors'] = $arr_authors;
		}
	}
	
	public function _getAllAuthors(){
		$arr_return = array();
		$sql = "SELECT * from author order by author_name";
		$res = $this->ExecuteArray($sql);
		foreach($res as $arr){
			$arr_return[ $arr['author_id'] ] = $arr['author_name'];
		}
		return$arr_return;
	}
	
	/*
	 * A simple (complex) version to get the authors. Created for the column section area
	 */
	public function justGetTheAuthors( $story_id ){
			if( is_array($story_id) ){
			$x=0;
			$sql = "SELECT jas.*, a.author_name  from `join-author-story` jas";
			$sql .= " left join author a on (a.author_id=jas.`join-author-story_author_id`)";
			$sql .= " where `join-author-story_story_id`=";
			foreach( $story_id as $val ){
				$sql .= "'$val'";
				$x++;
				$sql .= ( $x < count( $story_id ) )? ' OR `join-author-story_story_id`=':NULL;
			}
		} else {
			$story_id = ($story_id)? $story_id: $this->Get_Data('story_id');
			$sql = "SELECT * from `join-author-story` where `join-author-story_story_id`='$story_id'";
		}
		
			$arr_authors = array();
			$res = $this->ExecuteArray( $sql );
			
			// Place the authors in order by the story ids
			foreach( $res as $au ){
				$arr_authors[ $au['join-author-story_story_id'] ][] = $au;
			}
			
			return $arr_authors;

	}
	
	
	public function _getLatestIssueDate( $unixToUrl = false, $year = NULL, $format = NULL ) {
			$sql = "SELECT issue_date from issue where issue_date<='".mktime()."'";
			$sql .= " and issue_status=1 ";
			if( $year ){
				$sql .= " and issue_date<='".mktime(23,59,59,12,31,$year)."'";	//Last moment of the year
			}
			$sql .= "order by issue_date desc limit 1";
			$res = $this->ExecuteAssoc($sql);
			return ($unixToUrl)? $this->_URLToUnixDate( $res['issue_date'], true, $format ): $res['issue_date'];		
	}
	

	/**
	 * Gets the authors from the issue author array
	 * Send it the story ID and it will pump back
	 * an array of names  or NULL
	 * @param int $stosry_id
	 * @return unknown
	 */
	public function getIssueStoryAuthors($story_id){
		$return_arr=NULL;

		if( is_array( $this->Get_Data('issue_story_authors') ) ){
			foreach( $this->Get_Data('issue_story_authors') as $authors){
				if( $story_id == $authors['author_story_id']){
					$return_arr[] = $authors;
				}
			}
		}
		return $return_arr;
	}
	
	public function getIssueStoryPhotos($story_id, $just_the_first = false){
		$return_arr=NULL;
		if( is_array($this->Get_Data('issue_story_photos') ) ){
			foreach( $this->Get_Data('issue_story_photos') as $photos){
				if( $story_id == $photos['photo_story_id']){
					$return_arr[] = $photos;
				}
			}
		}
		if( sizeof($return_arr) == 1 || $just_the_first ){
			return $return_arr[0];
		}
		return $return_arr;
	}
	
	
	/**
	 * Provides the number of front page stories divided by 2 so that table columns can be split
	 * rounds down!
	 *
	 */
	public function getFPSplitCount(){
		if( is_array($this->getIssueSectionArray(FRONT_PAGE, '0', true ) ) ) {
			return floor( count( $this->getIssueSectionArray(FRONT_PAGE, '0', true ) ) / 2 ) ;
		}
	}
	
	
	/**
	 * getIssueSectionArray
	 * You can specify the section and it will return an array of stories.
	 * If you specify the story_element, it will return the array of that story
	 * If you specify the 'get the rest', it will return the rest of the stories
	 * starting from (and exluding) the $story_element.
	 * 
	 * @param unknown_type $section
	 * @param unknown_type $story_element
	 * @param unknown_type $get_the_rest_from_story_element
	 * @return unknown
	 */
	public function getIssueSectionArray($section, $story_element = NULL, $get_the_rest_from_story_element= NULL){
		if( is_array($this->Get_Data('formatted_issue_stories')) && array_key_exists($section, $this->Get_Data('formatted_issue_stories') )){
			if( $story_element != NULL || $story_element == '0' ){ 		// Get the story array
				if( array_key_exists($story_element, $this->data['formatted_issue_stories'][$section] ) ) {
					if( $get_the_rest_from_story_element ){
						$story_element_reached =false;
						$return_arr = array();
						foreach( $this->data['formatted_issue_stories'][$section] as $key=>$st ){
	
							if( $story_element_reached ){
								$return_arr[] = $st;
							}
							if( $key==$story_element ){
								$story_element_reached = true;
							}
						}
						return $return_arr;
					} else {
						return $this->data['formatted_issue_stories'][$section][$story_element];
					}
				}
			}  else {
				return $this->data['formatted_issue_stories'][$section];
			}
		}
		
	}
	
	/**
	 * Will return the element of a story item with the formatted_issue_stories array
	 * 
	 *
	 * @param unknown_type $section
	 * @param unknown_type $story_element
	 * @param unknown_type $story_element_key
	 * @return unknown
	 */
	public function getIssueStoryElement( $section, $story_element, $story_element_key ){
		if( is_array($this->Get_Data('formatted_issue_stories')) && array_key_exists($section, $this->Get_Data('formatted_issue_stories') ) ) {
			if( is_array($this->data['formatted_issue_stories'][$section]) && array_key_exists( $story_element, $this->data['formatted_issue_stories'][$section] ) ) {
				if( array_key_exists( $story_element_key, $this->data['formatted_issue_stories'][$section][ $story_element ] ) ) {
					return $this->data['formatted_issue_stories'][$section][ $story_element ][$story_element_key];
				}
			}
		}
	}

	/**
	 * getDBPhoto will get a photo details from the database
	 *
	 * @param unknown_type $photo_id
	 * @return unknown
	 */
	public function getDBPhoto( $photo_id ){
		$sql = "SELECT * from photo where photo_id=$photo_id";
		$res = $this->ExecuteAssoc( $sql );
		if( is_array( $res ) ) {
			return $res;
		}
	}
	
	public function outputSection( $section_id, $return_brief = true, $size_of_photo = SMALL, $photo_class = 'smallphotoright' ){
		$output = NULL;
		if( $this->getIssueSectionArray($section_id) ) {
			foreach( $this->getIssueSectionArray($section_id) as $stories ) {
				$output .= '<div class="storyseperator">';
				
				$output .= '<h4><a href="/page/view/'. $stories['story_url_id'] .'">' . $stories['story_title'] .'</a></h4>';
				$output .= $this->outputStoryAuthors( $stories['story_id'] );
				if( $return_brief ) {
					$output .= $this->outputStoryPhoto( $stories['story_id'], $size_of_photo, $photo_class );
					if( trim($stories['story_kicker']) ){
						$output .= '<p style="font-size: 9pt;">'.$stories['story_kicker']. '</p>';
					} else if( trim($stories['story_brief']) ){
						$output .= '<p style="font-size: 9pt;">'.$stories['story_brief']. '</p>';
					}
				}
				$output .= $this->outputIssueAdminSection( $stories['story_id'] );	
				
				$output .= '</div>';
			}
		}
		return $output;
	}
	
	
	public function setRotationItems(){
		$sql = "SELECT * from rotation where rotation_issue_date='".$this->Get_Data_Holder('arr_issue', 'issue_date')."'"; // Unix issue date
		$sql .= " order by rotation_column_id asc, rotation_order asc";
		$res = $this->ExecuteArray($sql);
		
		if( is_array( $res )) {
			$this->data['rotation_items'] = $res;
		}
	}
	
	
	public function outputRotationItems(){
		$str_output = NULL;
		if( $this->Get_Data('rotation_items') ){
			
			$current_column_id = 0;
			$str_output .= '<table width="100%"><tr>';
			foreach( $this->Get_Data('rotation_items') as $ri ){
				if( $current_column_id != $ri['rotation_column_id'] ) {
					$str_output .= ($current_column_id != 0)? '</td><td style="background: transparent;" >': '<td style="background: transparent;" >';
					$current_column_id =  $ri['rotation_column_id'];
				}
				if( trim( $ri['rotation_link'] ) ) {
					$str_output .= '<a href="'.$ri['rotation_link'].'">';
				}
				if( trim( $ri['rotation_image'] ) ) {
					$str_output .= '<img style="margin: 2px; 0px;" src="/'. SITE . $ri['rotation_image'].'" /><br />';
				} else{
					if( trim( $ri['rotation_text'] ) ){
						$str_output .= $ri['rotation_text'] .'<br />';
					}
				}
				if( trim( $ri['rotation_link'] ) ) {
					$str_output .= '</a>';
				}
				
			}
			$str_output .= "</td></tr></table>";
		}
		print $str_output;
	}
	

	
	/**
	 * outputAreaStory pumps out stories to the areas.
	 *
	 * @param unknown_type $start_arr_element 
	 * @param unknown_type $end_arr_element
	 * @param unknown_type $photo_size
	 * @param unknown_type $css_class_photo
	 */
	public function outputAreaStory($start_arr_element, $return_this_many_stories = 1, $photo_size = SMALL, $css_class_photo = NULL) {
		$output = NULL;
		$last_array_element_to_return = $start_arr_element + $return_this_many_stories;
		if( is_array( $this->Get_Data('formatted_issue_stories') ) ) {
			if( array_key_exists($start_arr_element, $this->Get_Data('formatted_issue_stories') ) ) {
				for( $x=$start_arr_element; $x<=$last_array_element_to_return; $x++ ){
					if( array_key_exists( $x, $this->Get_Data('formatted_issue_stories') ) ){
						$output .= '<div class="storyseperator">';
						$output .= '<table><tr><td>';
						$output .= '<h4><a href="/page/view/'. $this->data['formatted_issue_stories'][$x]['story_url_id'] .'">' . $this->data['formatted_issue_stories'][$x]['story_title'] .'</a></h4>';
						$output .= $this->outputStoryAuthors( $this->data['formatted_issue_stories'][$x]['story_id'] );
						if( trim($this->data['formatted_issue_stories'][$x]['story_kicker']) ){
							$output .= '<p style="font-size: 9pt;">'.$this->data['formatted_issue_stories'][$x]['story_kicker']. '</p>';
						} else if( trim($this->data['formatted_issue_stories'][$x]['story_brief']) ){
							$output .= '<p style="font-size: 9pt;">'.$this->data['formatted_issue_stories'][$x]['story_brief']. '</p>';
						}
						if( $this->MemberAllowed( MEMBER_AUTH_LEVEL_EDITOR ) ) {
							$output .= $this->outputIssueAdminSection( $this->data['formatted_issue_stories'][$x]['story_id'] );	
							
						}
						$output .= '</td><td style="vertical-align: top;">';
						$output .= $this->outputStoryPhoto( $this->data['formatted_issue_stories'][$x]['story_id'], $photo_size, $css_class_photo );
						$output .= '</td></tr></table>';
						$output .= '</div>';
					}
				}
				
			}
			
			return $output;			
		}
		return $output;
	}
	
	
	/**
	 * Outputs the Header delivered IF any of the section IDs sent have any stories in them.
	 *
	 * @param unknown_type $section_heading_text
	 * @param unknown_type $arr_sections_verify
	 * @return unknown
	 */
	public function outputHeader($section_heading_text, $arr_sections_verify = NULL, $encompassing_div_id = NULL ){
		$send_section_heading = false;
		if( $arr_sections_verify && is_array( $arr_sections_verify ) ){
			foreach( $arr_sections_verify as $section_id ){
				if( $this->areThereStoriesInSection( $section_id ) ){
					$send_section_heading = true;	
				}
			}
		}
		if( $encompassing_div_id ) {
			return ($send_section_heading)? '<div id="'.$encompassing_div_id.'"><div class="heading">'.$section_heading_text.'</div>': NULL;
		} else {
			return ($send_section_heading)? '<div class="heading">'.$section_heading_text.'</div>': NULL;
		}
	}
	/**
	 * Outputs the Header delivered IF any of the section IDs sent have any stories in them.
	 *
	 * @param unknown_type $section_heading_text
	 * @param unknown_type $arr_sections_verify
	 * @return unknown
	 */
	public function outputFooter( $arr_sections_verify = NULL ){
		$send_section_heading = false;
		if( $arr_sections_verify && is_array( $arr_sections_verify ) ){
			foreach( $arr_sections_verify as $section_id ){
				if( $this->areThereStoriesInSection( $section_id ) ){
					$send_section_heading = true;	
				}
			}
		}
		return ($send_section_heading)? '</div>': NULL;
	}
	
	
/**
 * BY SO AND SO
 *
 * @param unknown_type $story_id
 */
	public function outputStoryAuthors( $story_id, $just_return_author_id_array = false ){
		$output = NULL;
		$arr_authors = $this->getIssueStoryAuthors( $story_id );
		if( is_array( $arr_authors ) ) {
			if( $just_return_author_id_array ){
				return $arr_authors;
			}			
			$output = '<div class="author">by ';
			$author_count=0;
			foreach( $arr_authors as $a ){
				$output .=  (SITE=='HT')? strtoupper( $a['author_name']): $a['author_name']; //WITH LINK: $output .= '<a href="/section/author/'.$a['author_id'].'">'. $a['author_name']   . "</a>";
				$author_count++;
				if ( $author_count < count( $arr_authors ) ){
					$output .= ", ";
				}
			}
			$output .= '</div>';
		}
		return $output;
	}

	/**
	 * Will output the MAIN story photo, with a specified size (if it exists)
	 * + photo class
	 * @param unknown_type $story_id
	 * @return unknown
	 */
	public function outputStoryPhoto( $story_id, $size=NULL, $class=NULL ){
		$output = NULL;
		$arr_photos = $this->getIssueStoryPhotos( $story_id, true );

		if( is_array( $arr_photos ) ) {
				if( file_exists( DIRECTORY_PHOTOS .'/'. $arr_photos['photo_inserted_year'] . '/'. $arr_photos['photo_inserted_month'] . '/'.$size. $arr_photos['photo_file_name'] ) ) {
					$output = '<div class="'.$class.'">';
					$output .= '<img title="'.htmlentities( $arr_photos['photo_cutline'] ). '" src="'.URL_PHOTOS_DIR.'/'. $arr_photos['photo_inserted_year'] . '/'. $arr_photos['photo_inserted_month'] . '/'.$size. $arr_photos['photo_file_name'].'">';
					$output .= '</div>';
				}
		}
		return $output;
	}
	
	public function outputStoryTags( $story_id ){
		/* NOT WORKING YET
		$output = NULL;
		$arr_authors = $this->getIssueStoryAuthors( $story_id );
		if( is_array( $arr_authors ) ) {
			$output = '<div class="author">BY ';
			$author_count=0;
			foreach( $arr_authors as $a ){
				$output .= '<a href="/section/author/'.$a['author_id'].'">'. strtoupper( $a['author_name'] ) . "</a>";
				$author_count++;
				if ( $author_count < count( $arr_authors ) ){
					$output .= " AND ";
				}
			}
			$output .= '</div>';
		}
		return $output;
		*/
	}
	
	/**
	 * Date, Comments and whatever is there!
	 *
	 * @param unknown_type $story_id
	 */
	public function outputStoryDetailDiv( $story_id ){
		 
	}
	
	public function _setIssueStoryAuthors($id=NULL){
		$sql_caught = false;
		$sql = "SELECT jas.`join-author-story_story_id` as author_story_id, jas.`join-author-story_author_id` as author_id, jas.`join-author-story_order` as author_order, a.author_name from `join-author-story` as jas";
		$sql .= ' left join author as a on (a.author_id=jas.`join-author-story_author_id`)';
		$sql .= " where `join-author-story_story_id` in (";
		$x=1;
		
		if( $id ){
			$sql .= "'". $id. "'";
			$sql_caught = true;
		} else {
			if( is_array( $this->Get_Data( 'story_ids' ) ) && count( $this->Get_Data( 'story_ids' ) ) ) {
				foreach( $this->Get_Data( 'story_ids' ) as $id ){
					$sql .= "'". $id. "'";
					$sql .= ( $x < count( $this->Get_Data( 'story_ids' ) ) ) ? ",": NULL;
					$x++;
				}
				$sql_caught = true;
			}
		}
		
		$sql .= ") order by `join-author-story_story_id` asc, `join-author-story_order` asc";
		if( $sql_caught ) {
			$res = $this->ExecuteArray( $sql );
			$this->data['issue_story_authors'] = $res;

		}
	}
	
	/**
	 * Sets an an issue's photo array
	 * If an ID is sent, a single story has requested it.
	 *
	 * @param unknown_type $id
	 */
	public function _setIssueStoryPhotos($id=NULL){
		$sql_caught = false;
		$sql = "SELECT jps.`join-photo-story_cutline` as photo_cutline, jps.`join-photo-story_order` as photo_order, jps.`join-photo-story_story_id` as photo_story_id, jps.`join-photo-story_photo_id` as photo_id, p.* from `join-photo-story` as jps";
		$sql .= ' left join photo as p on (p.photo_id=jps.`join-photo-story_photo_id`)';
		$sql .= " where `join-photo-story_story_id` in (";
		$x=1;
		
		if( $id ){
			$sql .= "'". $id. "'";
			$sql_caught = true;
		} else {
			if( is_array( $this->Get_Data( 'story_ids' ) ) && count( $this->Get_Data( 'story_ids' ) ) ) {
				foreach( $this->Get_Data( 'story_ids' ) as $id ){
					$sql .= "'". $id. "'";
					$sql .= ( $x < count($this->Get_Data( 'story_ids' ) ) )? ",": NULL;
					$x++;
				}
				$sql_caught = true;
			}
		}
		$sql .= ") order by `join-photo-story_story_id` asc";

		if( $sql_caught ) {
			$res = $this->ExecuteArray( $sql );
			$this->data['issue_story_photos'] = $res;
		}
	}
	/**
	 * Sets an an issue's tag array
	 * If an ID is sent, a single story has requested it.
	 *
	 * @param unknown_type $id
	 */
	public function _setIssueStoryTags($id=NULL){
		$sql_caught = false;
		$sql = "SELECT jps.`join-tag-story_story_id` as tag_story_id, jps.`join-tag-story_tag_id` as tag_id, p.* from `join-tag-story` as jps";
		$sql .= ' left join tag as p on (p.tag_id=jps.`join-tag-story_tag_id`)';
		$sql .= " where `join-tag-story_story_id` in (";
		$x=1;
		if( $id ){
			$sql .= "'". $id. "'";
			$sql_caught = true;
		} else {
			if( is_array( $this->Get_Data( 'story_ids' ) ) ) {
				foreach( $this->data[ 'story_ids' ] as $id ){
					$sql .= "'". $id. "'";
					$sql .= ( $x < count($this->data[ 'story_ids' ]) )? ",": NULL;
					$x++;
				}
				$sql_caught = true;
			}
		}
		$sql .= ") order by `join-tag-story_story_id` asc";
		if( $sql_caught ) {
			$res = $this->ExecuteArray( $sql );
			$this->data['issue_story_tags'] = $res;
		}
	}
	
	/**
	 * The issue array is passed to this function
	 * and is placed in a nice tidy order (data[formatted_issue_stories])
	 * AND the authors and photos are retrieved and placed in.
	 * If the $forget_the_section_ids is set to true, it will set the stories
	 * in order, but without setting the sub-array of sections - everything is set to 0
	 *
	 * @param unknown_type $arr_data
	 */
	public function _processIssueStoriesOrder( $arr_data, $forget_the_section_ids = NULL ){

		$arr_processed 							= array();		// 
		$current_section 						= NULL;	// The currently selected section ID
		$this->data[ 'formatted_issue_stories' ]= array();
		$this->data[ 'story_ids' ] 				= array();
		$story_ids 								= array();
		$top_story_id = NULL;
		if( is_array( $arr_data) ){
			foreach( $arr_data as $item ){
				if( $current_section != $item['story_section_id'] ){$current_section = $item['story_section_id']; }
				// Front page stories override the section area:
				if($item['story_front_page']==1){ $current_section=0; }
				
				if( !array_key_exists($current_section, $this->data['formatted_issue_stories'] ) && !$forget_the_section_ids ) {
					$this->data['formatted_issue_stories'][ $current_section ] = array();
				}
				$this->data[ 'story_ids' ][] = $item['story_id'];
				
				if( $forget_the_section_ids ){
					$this->data['formatted_issue_stories'][] = $item;
				} else {
					$this->data['formatted_issue_stories'][ $current_section ][] = $item;
				}
				
				if( !$top_story_id ) {	// fetching the first story through to get it's ID, used to get it's photo
					$top_story_id = $item['story_id'];
				}				
			}
		}

		// Now, all the issue ids are in place, we can retrieve the authors and photos
		$this->_setIssueStoryAuthors();
		$this->_setIssueStoryPhotos();
						
		// THROW IMAGE - Use the first story image as the throw unless the issue throw override has been set
		if( $this->Get_Data('issue_override_throw_photo_id') ){
			$this->data['throw'] = $this->getDBPhoto( $this->Get_Data('issue_override_throw_photo_id') );
		} else {
			$this->data['throw'] = $this->getIssueStoryPhotos( $top_story_id );
		}
	}
	
	
	
	public function _getLatestPBDate() {
		$sql = "SELECT policy_briefing_publish_date from policy_briefing";
		$sql .= " Where policy_briefing_publish_date <= '".mktime()."'";
		
		$res = $this->ExecuteAssoc($sql);
		if( $res ){
			$this->data['policy_briefing_publish_date'] = $res['policy_briefing_publish_date'];
		}
	}
	
	

	/**
	 * _fetchStories retrieves the stories with a given integer ID OR
	 * an array of integers, for multiple section gathering.
	 * Sending a $just_return will return only the titles and URLs without going through
	 * the story process order
	 *
	 * @param unknown_type $story_section_id
	 * @param unknown_type $start_row
	 * @param unknown_type $num_rows
	 * @return unknown
	 */
	public function _fetchStories( $story_section_id, $start_row=0, $num_rows=20, $just_return = NULL ){
		$sql_elements = NULL;

		if( is_array( $story_section_id) ){
			foreach( $story_section_id as $key=>$id ) {
				$sql_elements .= ' story_section_id='.$id;
				$sql_elements .= ( $key < (count( $story_section_id)-1) )? ' OR ' : NULL;
			}
		} else {
			$sql_elements = ' story_section_id='.$story_section_id;
		}
		$sql =  ($just_return )? "SELECT s.story_title, s.story_issue_date, s.story_url_id from story as s ": "SELECT s.* from story as s ";
		$sql .= " where (".$sql_elements .")";
		$sql .= " and s.story_issue_date <=". mktime();
		$sql .= " order by story_issue_date desc, story_front_page asc, story_order asc limit $start_row, $num_rows";

	//	$sql .= ( $policy_briefing_only_publish_date )? ' and story_issue_date='.$policy_briefing_only_publish_date : NULL;


		
		$res = $this->ExecuteArray( $sql );
			
		if( is_array( $res ) && $just_return ) {
			return $res;
			exit();
		}
		
		if( $res ){ 
			$this->_processIssueStoriesOrder( $res, true );
		}

	}
	
	/**
	 * Each story is attributed to a section, which in tern is attributed
	 * to a section_type. Let's get all the sections based on the section_type, shall we?
	 *
	 * @param unknown_type $section_type_id
	 */
	public function _fetchSectionIDsBasedOnSectionTypeID( $section_type_id ){
		if( $section_type_id ){
			$sql = "SELECT section_id from section where section_section_type_id=$section_type_id";
			$res = $this->ExecuteArray($sql);
			if( is_array( $res ) ) {
				foreach( $res as $sd ){
					$arr_ids[] = $sd['section_id'];
				}
				
				$this->data['section_ids_from_type'] = $arr_ids;
			}
		}
	}
	
	public function _fetchSectionStories($section_type_id, $start_row=0, $num_rows=20, $just_return = NULL){
		$this->_fetchSectionIDsBasedOnSectionTypeID( $section_type_id );
		return $this->_fetchStories( $this->Get_Data('section_ids_from_type'), $start_row, $num_rows, $just_return);
	}
	

	/**
	 * _fetchAreaStories
	 * Used by each of the main nav 'areas' to get each of the areas
	 *
	 * @param unknown_type $story_section_id
	 * @param unknown_type $start_row
	 * @param unknown_type $num_rows
	 * @param unknown_type $just_return
	 * @return unknown
	 */

	
	public function _fetchAreaStories( $area_id, $start_row=0, $num_rows=20, $just_return = NULL ){
		$sql_elements = NULL;
		if( is_array( $area_id) ){
			foreach( $area_id as $key=>$id ) {
				$sql_elements .= '`join-area-story_area_id`='.$id;
				$sql_elements .= ( $key < (count( $area_id)-1) )? ' OR ' : NULL;
			}
		} else {
			$sql_elements = '`join-area-story_area_id`='.$area_id;
		}
		
		$sql = "SELECT jas.*, s.* from `join-area-story` as jas ";
		$sql .= " left join story as s on (jas.`join-area-story_story_id`=s.story_id)";
		$sql .= " where ". $sql_elements;
		
		
		
		// $sql =  ($just_return )? "SELECT s.story_title, s.story_issue_date, s.story_url_id from story as s ": "SELECT s.* from story as s ";
		// $sql .= " where ".$sql_elements;
		$sql .= " and s.story_issue_date <=". mktime();
		$sql .= " order by story_issue_date desc, story_front_page asc, story_order asc limit $start_row, $num_rows";
	//	$sql .= ( $policy_briefing_only_publish_date )? ' and story_issue_date='.$policy_briefing_only_publish_date : NULL;
		

		
		$res = $this->ExecuteArray( $sql );
			
		if( is_array( $res ) && $just_return ) {
			return $res;
			exit();
		}
		
		if( $res ){ 
			$this->_processIssueStoriesOrder( $res, true );
		}

	}
	
	
	/**
	 * What a great function! Returns an array of details for the section when you send it a lowercase, no-space
	 * equivilent to the section_title.
	 *
	 */
	public function _getSectionDetailBySectionTitle( $str_title ){
		//Lookup this name
			// LCASE(str) REPLACE(str,from_str,to_str)
		$sql = "SELECT section_id, section_title, section_image, LCASE( REPLACE(section_title, ' ','') ) as abbr_section_title from section";
		$res1 = $this->ExecuteArray($sql, 'abbr_section_title');
		if( is_array($res1) && array_key_exists($str_title, $res1) ) {
			return $res1[$str_title];
		}
	}
	
	
	
	public function outputIssueAdminSection( $story_id ){
		if( $this->MemberAllowed( MEMBER_AUTH_LEVEL_EDITOR ) ) {
			$return_html = '<div style="font-size: 7pt; padding: 3px; background-color: #eee; border: 1px dashed #ccc; color: #444; font-family: verdana, arial;">ADMIN ::  ';
			$return_html .= "STORYID: ". $story_id;
			$return_html .= ' | <a href="/photo/addphoto/'.$story_id.'">Add Photo</a> ';
			$return_html .= '| <a href="/thestone/addAreaToStory/'.$story_id.'">Add Areas</a>';
			$return_html .= '</div>';

			return $return_html;
		}
	}
	
	
	public function setColumnistList(){
		$sql = "SELECT * from author where author_order !=0 order by author_order asc, author_name asc";
		$res = $this->ExecuteArray( $sql );
		if( $res ){
			$this->data['columnist_list'] = $res;
		}
	}
	
	/**
	 * Gets the names within the section table that fall under a specific section type
	 *
	 * @param unknown_type $section_type_id
	 */
	public function setSectionsInSectionType($section_type_id){
		$sql = "SELECT * from section where section_section_type_id=$section_type_id";
		$res = $this->ExecuteArray($sql);
		$this->data['column_list'] = $res;
	}
	
	
	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\

	/**
	 * returns true if there are any stories within the given section
	 *
	 * @param unknown_type $section_id
	 * @return unknown
	 */
	private function areThereStoriesInSection( $section_id ){
		if( is_array($this->Get_Data('formatted_issue_stories')) && array_key_exists($section_id, $this->Get_Data('formatted_issue_stories') )){
			if( is_array( $this->data['formatted_issue_stories'][$section_id] ) ) {
				if(count( $this->data['formatted_issue_stories'][$section_id] ) >= 1 ){
					return true;
				}
			}
		}
	}
	
	

	
	
	/**
	 * _getIssue
	 * $date - we use a unixtimestamp in the database, but
	 * we are using a easier-to-read 2007-12-25 verion here
	 */
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
	
	/**
	 * _setIssueStories sets the issue array with all stories
	 * associated with the issue. It's up to the issue template to
	 * actually display them all (or some)
	 *
	 * @param unixtimestamp $date
	 */
	private function _setIssueStories( $date ){
		$this->_setSectionArray();
		$sql = "SELECT s.* from story as s ";
		$sql .= " where s.story_issue_date=$date and s.story_status=1";
		$sql .= " order by s.story_front_page asc, s.story_section_id asc, s.story_order asc";
		$this->data['issue_stories'] = $this->ExecuteArray($sql);
		$this->_processIssueStoriesOrder( $this->Get_Data('issue_stories') );
	}
	
	private function _setSectionArray(){
		$sql = "SELECT * from section";
		$res = $this->ExecuteArray( $sql );
		if( is_array( $res ) ) {
			$this->data['arr_sections'] = $res;
		} 
	}
	
	

	
	private function _getCurrentIssue(){
		return $this->_getIssue();
	}

	/**
	 * Gets the latest issue date.
	 * The default is to send back the date in UNIX format, set the first var to true to send it back as a URL date format
	 * Send a year as the second variable to get the last issue in that year. Comes in handy for archives.
	 * Send a date('') string to set the format of the returned variable, ie: 'Y' to only return the year/
	 */

	

	private function _setAllIssueDates(){
		$arr_dates = array();
		$sql = "SELECT issue_date from issue";
		$sql .= " where issue_status=1 order by issue_date asc";
		$res = $this->ExecuteArray( $sql );
		if( is_array( $res )){
			foreach( $res as $issue_date ){
				$arr_dates[ date('Y', $issue_date['issue_date']) ][ date('F', $issue_date['issue_date']) ][date('j', $issue_date['issue_date'])] = $issue_date['issue_date'];
			}
		}
		
		$this->data['all_issue_dates'] = $arr_dates;
			
	}
	
	private function _getArchiveIssues( $year = NULL ){
		// Default to current Year if year is NULL
		$this->data['current_archive_year'] = ( $year )? $year: date('Y');
		$year_start_timestamp = mktime(0,0,0,1,0,$this->data['current_archive_year']);
		$year_end_timestamp = mktime(0,0,0,12,31,$this->data['current_archive_year']);
		
		 
		$sql = "SELECT issue_date, FROM_UNIXTIME(issue_date, '%M %e') as issue_formatted_date, issue_number from issue";
		$sql .= " where issue_date >= $year_start_timestamp AND issue_date <= $year_end_timestamp"; 
		$sql .= " and issue_date <=". mktime(); 
		$sql .= " AND issue_status=1 order by issue_date asc";
		$this->data_holder['all_issues'] = $this->ExecuteArray( $sql );
	}
	
	private function _getAvailableArchiveYears(){
		$sql = "SELECT DISTINCT FROM_UNIXTIME(issue_date, '%Y') as issue_formatted_date from issue order by issue_formatted_date desc";
		$this->data_holder['archive_years'] = $this->ExecuteArray($sql);
		
	}

	
	/**
	 * Now with sorting! Get the issue headlines for archive showing, based on the 3rd variable
	 */
	private function _getStoryHeadlinesForIssue(){
		$sql = "SELECT story_id, story_title, story_url_id from story where story_issue_date=" . $this->_URLToUnixDate( $this->Get_URL_Element( VAR_2 ) );
		$sql .= " order by story_title";
		$this->data_holder['issue_headlines'] = $this->ExecuteArray($sql, 'story_id');

		// Now, get the story IDs from the headlines and fetch those authors
		$this->_fetchAuthorsForStoryID( $this->Get_Array_Values( $this->data_holder['issue_headlines'], 'story_id' ) ); // places in data_holder story_author_ids
		$this->_getAuthors();
		$this->_mergeStoryAndAuthors();
		
		// Sort the arrays depending on the third variable
		if( $this->Get_URL_Element( VAR_3 )){
			if( $this->Get_URL_Element( VAR_3 ) == 'author' ){
				$this->_sortHeadlinesByAuthor();
			}
		}
		
	}
	


	private function _mergeStoryAndAuthors(){
		// Go through each story - since the story ids are unique
		if( $issue_headlines = $this->Get_Data_Holder('issue_headlines') ){
		
			foreach( $this->Get_Data_Holder('authors') as $author ){
				if( array_key_exists($author['join-author-story_story_id'], $issue_headlines ) ) {	
					$issue_headlines[ $author['join-author-story_story_id'] ]['arr_authors'][] = array( 'author_id'=>$author['author_id'], 'author_name'=>$author['author_name'] );
				}
			}
			$this->data_holder['issue_headlines'] = $issue_headlines;
		}
	}
	
	/**
	 * Sorts by Author name - The first one that shows up in the array
	 *
	 */
	private function _sortHeadlinesByAuthor(){
		$issue_headlines = $this->Get_Data_Holder('issue_headlines');
		$tmp_headline_array =  NULL;
		$tmp_headline_array_no_author = NULL;
		foreach($issue_headlines as $story_id => $story ){
			if( array_key_exists('arr_authors', $story) ){
				$tmp_headline_array[ $story_id ] = array_merge( array('main_author_name'=>$story['arr_authors'][0]['author_name']), $story);
			} else {
				$tmp_headline_array_no_author[ $story_id ] = $story;
			}
		}
		sort( $tmp_headline_array);
		$this->data_holder['issue_headlines'] = array_merge($tmp_headline_array, $tmp_headline_array_no_author);
	}
	
	private function _doesIssueExist( $date ){
		if( $date ){
			$sql = "SELECT issue_date from issue where issue_date='".$this->_URLToUnixDate($date)."'";
			$res = $this->Execute($sql);
			if( mysql_num_rows( $res ) >= 1 ){
				return true;
			}
		}
		return false;
	}
	
	
	private function setIssueTemplate() {
		if( $this->Get_Data('issue_template_file' ) ) {
			// Scoop up the file
			if( file_exists(DIRECTORY_TEMPLATES . 'issue/custom/'.$this->Get_Data('issue_template_file' ) ) )  {
				$this->data['temp_issue_template_body'] = file_get_contents(  DIRECTORY_TEMPLATES . 'issue/custom/'.$this->Get_Data('issue_template_file' ) );
			}
		}
		
		if( $this->Get_Data('temp_issue_template_body') ) {
			$this->data['issue_template_body'] = $this->Get_Data('temp_issue_template_body');
		}
	}
	
	/**
	 * Crunch Old Result Array Data
	 * Takes the old methodology of using a static result array
	 * and places them into usable, programmer-friendly vars for the template
	 */
	private function _crunchOldResultArrayData(){
		$str_results = str_replace("\r", '', $this->Get_Data_Holder( 'arr_issue', 'issue_old_array_content') );
		$str_results = str_replace("\n", '', $str_results );
		eval($str_results);	// Returns the $result_array var, $custom_template and define('THROW_PHOTO_HORIZ', 1); 
		$this->data['orig_issue_result_array'] = $result_array;	
	}
	
	private function doesNormalThrowExist( $unix_issue_date ){
		if( $unix_issue_date  ){

				$file_name = $this->getFileNameFormatFromUnix( $unix_issue_date ) . '_throw.jpg';
				$dir = date('Y', $unix_issue_date ) . '/'.  strtolower( date('F', $unix_issue_date ));

				if ( file_exists( DIRECTORY_PHOTOS . '/'. $dir .'/'. $file_name)){
					return URL_PHOTOS_DIR . '/'. $dir . '/' . $file_name;
				}
		}
	}
	
	/**
	 * Will return the file name such as mmddyy if sent a unix timestamp 
	 * Will set it to mmddyy to issue_date data var if no unix timestamp
	 *
	 * @param unknown_type $unix_time_stamp
	 * @return unknown
	 */
	private function getFileNameFormatFromUnix( $unix_time_stamp = NULL ){
		if( $unix_time_stamp ){
			return date('m', $unix_time_stamp). date('d', $unix_time_stamp) . date('y', $unix_time_stamp);
		} else {
			return date('m', $this->get_data('issue_date')). date('d', $this->get_data('issue_date')) . date('y', $this->get_data('issue_date'));
		}
	}

}
?>