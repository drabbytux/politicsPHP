<?php

require_once 'classes/inhouse.controller.class.php';
class RSS extends InHouseController  {
	// - - - - - - - - - - - - - - P U B L I C     M E T H O D S - - - - - - - - - - - - - - - \\

	function RSS(){
		$this->__construct();
		$this->Set_Template( 'header', 'rss/header-rss.php' );
		$this->Set_Template( 'footer', 'rss/footer-rss.php' );
	}
	
	public function index(){
		$this->data_holder['arr_stories'] = $this->_getStories();
		$this->Set_Template_With_PHP( 'output', 'rss/content-rss.php' );
		$this->Output_Page();
	}

	public function section(){
	
		// 
		switch( $this->Get_URL_Element( VAR_1 ) ) {
		
			case 'news':
				$section_id = NEWS;
			break;
			default:
				$section_id = NEWS;
			break;
		
		}
	
		$this->data_holder['arr_stories'] = $this->_getSection( $section_id );
		$this->Set_Template_With_PHP( 'output', 'rss/content-rss.php' );
		$this->Set_Template( 'header', 'rss/header-rss.php' ); // reapply the header, since we have new instructions for the header
		$this->Output_Page();
	}
	
	public function overview(){
		$this->Set_Template_With_PHP( 'output', 'rss/overview.php' );
		$this->Set_Template( 'header', 'common/header-http.php' );
		$this->Set_Template( 'footer', 'common/footer-http.php' );
		$this->Output_Page();
	}
	


	public function feed(){
		
	}
	
	public function RSS_Text( $str ){
		$str = str_replace( "\r", '', $str );
		$str = str_replace( "\n", '', $str );
		$str = strip_tags( $str );
		return trim( htmlentities( $str ) );
	}


	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\
	private function _getStories( $max = 10 ){
		$sql = "SELECT story_id, story_issue_date, story_title, story_url_id, story_kicker, LEFT( story_content, LOCATE( ' ', story_content, 200) ) AS story_description from story";
		$sql .= " where story_issue_date <=". mktime();
		$sql .= " and story_status=". STATUS_LIVE;
		// Remove some of the entities from each paper
		if( SITE == 'HT'){
			$sql .= " and story_section_id not in (4)"; // Removed Letters
		}
		if( SITE == 'EM'){
			$sql .= " and story_section_id not in (2,13)"; // Removed Talking points, Letters
		}
		
		$sql .= " order by story_issue_date desc";
		$sql .= ( $max )? ' limit '. $max: NULL;
		
		return $this->ExecuteArray($sql);
	}
	
	private function _getSection( $section_id, $max = NULL ){
		$this->_setSectionName( $section_id );
		$sql = "SELECT story_id, story_issue_date,  story_url_id, story_title, story_url_id, story_kicker, LEFT( story_content, LOCATE( ' ', story_content, 200) ) AS story_description from story";
		$sql .= " where story_section_id=$section_id";
		$sql .= " and story_issue_date <=". mktime();
		$sql .= " order by story_issue_date desc";
		$sql .= ( $max )? ' limit '. $max: ' limit 10';
		

		return $this->ExecuteArray($sql);
	}
	
	private function _setSectionName( $section_id ){
		$sql ="SELECT section_title from section where section_id=$section_id";
		$row = $this->ExecuteAssoc($sql);
		$this->data['section_name'] = $row['section_title'] .' Feed - ';

	}
	
}

?>