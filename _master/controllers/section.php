<?php
/**
 * ------------------
 * Section Controller
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
class Section extends Issue {

	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Section(){
		$this->__construct();
		$this->data['page_type'] = 'section';
	}

	/**
	 * Index - If called (from where, I don't know), show entire list of sectional information
	 * Soon to be dynamic
	 */
	public function index(){
		$this->Set_Template( 'output', 'section/index.php' );	// Default page with everything
		$this->Set_Common_Templates();
		$this->Output_Page();
	}

	/**
	 * News Section
	 * Display all the current News items
	 */
	public function news(){
		$this->setPageTitle('News Stories');
		$this->_fetchSectionStories( 1 ); 	// 1 = news section type id
		$this->commonSectionOutput('index');
	}


	/**
	 * THE HILL TIMES Sections *******************************
	 */

	public function qa(){
		$this->setPageTitle('Q & A');
		$this->_fetchStories( 31 );  					// $this->_fetchStories( array(26) ); 	// 7 = feature section id
		$this->commonSectionOutput();
	}

	public function features(){
		$this->setPageTitle('Features');
		$this->_fetchSectionStories( 5 ); 			// 1 = news section type id
		$this->commonSectionOutput();
	}



	/**
	 * EMBASSY Sections *******************************
	 */

	public function immigration(){
		$this->_fetchAreaStories( 1 );  // $this->_fetchStories( array(26) ); 	// 7 = feature section id
		$this->commonSectionOutput();
	}

	public function trade(){
		$this->_fetchAreaStories( 2 );  // $this->_fetchStories( array(26) ); 	// 7 = feature section id
		$this->commonSectionOutput();
	}

	public function opinion(){
		$this->_fetchStoriesInSectionType(1); // 1 opinions
		$this->commonSectionOutput();
	}

	public function defence(){
		$this->_fetchAreaStories( 4 );  // $this->_fetchStories( array(26) ); 	// 7 = feature section id
		$this->commonSectionOutput();
	}

	public function development(){
		$this->_fetchAreaStories( 5 );  // $this->_fetchStories( array(26) ); 	// 7 = feature section id
		$this->commonSectionOutput();
	}

	public function diplomacy(){
		$this->_fetchAreaStories( 6 );  // $this->_fetchStories( array(26) ); 	// 7 = feature section id
		$this->commonSectionOutput();
	}

	public function columns(){
		// Column names
		$this->_fetchStoriesInSectionType(2); // 2 columns
		
		// Set columnist names
		$this->setColumnistList();
		
		// Set column Names
		$this->setSectionsInSectionType(2);
		
		// The column names came in as raw. (there may be some undesirable names we don't want to highlight right now)
		$this->parseGoodColumnNames();
		
		// set output
		$this->commonSectionOutput('columns');
	}

	public function pb() {
		$this->data['pb_year'] = ($this->Get_URL_Element( VAR_1 ) )? $this->Get_URL_Element( VAR_1 ): date('Y');
		$this->data['latest_pb_issue_date'] = $this->_getLatestPBDate();
		$this->set_policy_briefing_published_list();
		$this->set_policy_briefing_upcoming_list();
		
		$this->commonSectionOutput('policy_briefings');
	}

	public function blogs(){
		$this->commonSectionOutput();
	}

	public function diplomaticcontacts(){

		$this->data['ambassadors_1'] = $this->getAmbassadorsBySection(1);
		$this->data['ambassadors_2'] = $this->getAmbassadorsBySection(2);
		$this->commonSectionOutput('ambassadors');
	}

	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\

	private function parseGoodColumnNames(){
		$arr_new_data = NULL;
		if( $this->get_data('column_list') ){
			foreach( $this->get_data('column_list') as $col ){
				if( $col['section_shown_in_current_columns'] == 1){
					$arr_new_data[] = $col;
				}
			}
			$this->data['column_list'] = $arr_new_data;
		}
	}
	/**
	 * Sets the PB published lists to include the year passed or this year, as long as it's before today's date
	 *
	 */
	private function set_policy_briefing_published_list(){
		$sql = "SELECT * from policy_briefing where policy_briefing_publish_date <=". mktime();
		if( $this->Get_URL_Element( VAR_1 ) ){  // A year has been passed
			$sql .= ' and policy_briefing_publish_date >=' . mktime(0,0,0,1,1, $this->Get_URL_Element( VAR_1 ) );
			$sql .= ' and policy_briefing_publish_date <=' . mktime(11,59,59,12,31,$this->Get_URL_Element( VAR_1 ) );
		} else {
			$sql .= ' and policy_briefing_publish_date >=' . mktime(0,0,0,1,1, date('Y') );
			$sql .= ' and policy_briefing_publish_date <=' . mktime(11,59,59,12,31, date('Y') );
		}
		$res = $this->ExecuteArray( $sql );
		$this->data['policy_briefing_published_list'] = $res;
	
	}
	
	private function set_policy_briefing_upcoming_list(){
		$sql = "SELECT * from policy_briefing where policy_briefing_publish_date >=". mktime();
		$res = $this->ExecuteArray( $sql );
		$this->data['policy_briefing_upcoming_list'] = $res;
	}
	
	/**
	 * gets the latest stories from the section_type
	 *
	 * @param unknown_type $section_type_id
	 */
	private function _fetchStoriesInSectionType( $section_type_id ){
		if( $section_type_id ){
			
			/*
			$sql = "SELECT DISTINCT st.*, se.* from story as st left join section as se on (se.section_id=st.story_section_id)";
			$sql .= " left join `join-author-story` as jas on (jas.`join-author-story_story_id`=st.story_id)";
			// $sql .= " right join author as a on (jas.`join-author-story_author_id`=a.author_id)" ;
			$sql .= " where se.section_section_type_id='". $section_type_id . "' and st.story_issue_date <=". mktime() . " and st.story_status=". STATUS_LIVE; //and se.section_highlighted=". STATUS_LIVE;
			$sql .= " order by st.story_issue_date desc limit 0, 20";
			*/		
			// Gets the stories
			$sql = "SELECT DISTINCT st.*, se.* from story as st left join section as se on (se.section_id=st.story_section_id) where se.section_section_type_id='2' and st.story_issue_date <=1229530467 and st.story_status=1 order by st.story_issue_date desc limit 0, 20";
			$res = $this->ExecuteArray( $sql );
			$story_ids = NULL;
			if( is_array( $res )){
				
				$this->data['section_columns'] =  $res;
				
				foreach( $res as $column_item ){
					$story_ids[] = $column_item['story_id'];					
				}

				//We have the story keys - Get the authors
				$this->data['story_authors'] = $this->justGetTheAuthors( $story_ids );
			
			}
		}
	}

	
	private function commonSectionOutput( $template_file_name = NULL ){
		$template_file_name = ($template_file_name)? $template_file_name: $this->Get_URL_Element(REQUEST_ACTION);
		$this->Set_Template( 'output', 'section/'.$template_file_name.'.php' );	// Default page with everything
		$this->Set_Common_Templates();
		$this->Output_Page();
	}

	private function getAmbassadorsBySection($section_id = 1){
		$sql = "SELECT * from ambassador where ambassador_section_id=".$section_id;
		$sql .= " ORDER by title";
		return $this->ExecuteArray($sql);
	}



}
?>