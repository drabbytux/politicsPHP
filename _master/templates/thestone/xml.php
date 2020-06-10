<?php

require_once 'classes/inhouse.controller.class.php';
class XML extends InHouseController  {
	// - - - - - - - - - - - - - - P U B L I C     M E T H O D S - - - - - - - - - - - - - - - \\

	function XML(){
		$this->__construct();
		$this->Set_Template( 'header', 'rss/header-xml.php' );
		$this->Set_Template( 'footer', 'rss/footer-xml.php' );
	}
	
	public function index(){
		//$this->data_holder['arr_stories'] = $this->_getStories();
		// $this->Set_Template_With_PHP( 'output', 'rss/content-rss.php' );
		$this->Output_Page();
	}

	public function authors(){
		$str_out = NULL;
		$sql = "SELECT * from author";
		if( $this->Get_URL_Element( VAR_1 ) ){
			if( $this->Get_URL_Element( VAR_1 ) == 'id'){
				 $sql .= " order by author_id";
			}
			else if ( $this->Get_URL_Element( VAR_1 ) == 'name' ) {
				 $sql .= " order by author_name";
			} 
		}else {
				 $sql .= " order by author_name";
		}
		$res = $this->ExecuteArray($sql);
		if( is_array( $res ) ){
			$str_out = "\n\t<authors>\n";
			foreach( $res as $au ){
				$str_out .= "\t\t<author>\n";
				$str_out .= "\t\t\t<id>". $this->RSS_Text( $au['author_id'] )."</id>\n";
				$str_out .= "\t\t\t<name>".$this->RSS_Text( $au['author_name'] )."</name>\n";
				$str_out .= "\t\t</author>\n";
				
			}
			$str_out .= "\t</authors>\n";
		}
		$this->data['xml'] = $str_out;
		$this->Set_Template( 'output', 'rss/content-xml.php' );
		$this->Output_Page();
	}
	
	public function sections(){
		$str_out = NULL;
		$sql = "SELECT * from section";
		if( $this->Get_URL_Element( VAR_1 ) ){
			if( $this->Get_URL_Element( VAR_1 ) == 'id'){
				 $sql .= " order by section_id";
			}
			else if ( $this->Get_URL_Element( VAR_1 ) == 'title' ) {
				 $sql .= " order by section_title";
			}
		}else {
				 $sql .= " order by section_title";
		}
		$res = $this->ExecuteArray($sql);
		if( is_array( $res ) ){
			$str_out = "\n\t<sections>\n";
			foreach( $res as $au ){
				$str_out .= "\t\t<section>\n";
				$str_out .= "\t\t\t<id>". $this->RSS_Text( $au['section_id'] )."</id>\n";
				$str_out .= "\t\t\t<title>".$this->RSS_Text( $au['section_title'] )."</title>\n";
				$str_out .= "\t\t</section>\n";
			}
			$str_out .= "\t</sections>\n";
		}
		$this->data['xml'] = $str_out;
		$this->Set_Template( 'output', 'rss/content-xml.php' );
		$this->Output_Page();
	}

	public function tags(){
		$str_out = NULL;
		$sql = "SELECT * from tag";
		if( $this->Get_URL_Element( VAR_1 ) ){
			if( $this->Get_URL_Element( VAR_1 ) == 'id'){
				 $sql .= " order by tag_id";
			}
			else if ( $this->Get_URL_Element( VAR_1 ) == 'name' ) {
				 $sql .= " order by tag_name";
			}
		} else {
				 $sql .= " order by tag_name";
		}
		$res = $this->ExecuteArray($sql);
		if( is_array( $res ) ){
			$str_out = "\n\t<tags>\n";
			foreach( $res as $au ){
				$str_out .= "\t\t<tag>\n";
				$str_out .= "\t\t\t<id>". $this->RSS_Text( $au['tag_id'] )."</id>\n";
				$str_out .= "\t\t\t<name>".$this->RSS_Text( $au['tag_name'] )."</name>\n";
				$str_out .= "\t\t</tag>\n";
			}
			$str_out .= "\t</tags>\n";
		}
		
		if( $str_out ) {
			$this->data['xml'] = $str_out;
			$this->Set_Template( 'output', 'rss/content-xml.php' );
			$this->Output_Page();
		}
	}
	
	
	public function RSS_Text( $str ){
		$str = str_replace( "\r", '', $str );
		$str = str_replace( "\n", '', $str );
		$str = strip_tags( $str );
		return trim( htmlentities( $str ) );
	}


	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\
	private function _getStories( $max = 10 ){
		$sql = "SELECT story_id, story_title, story_url_id, story_kicker, LEFT( story_content, LOCATE( ' ', story_content, 200) ) AS story_description from story";
		$sql .= " order by story_issue_date desc";
		$sql .= ( $max )? ' limit '. $max: NULL;
		
		return $this->ExecuteArray($sql);
	}
	
	private function _getSection( $section_id, $max = NULL ){
		$this->_setSectionName( $section_id );
		$sql = "SELECT story_id, story_url_id, story_title, story_url_id, story_kicker, LEFT( story_content, LOCATE( ' ', story_content, 200) ) AS story_description from story";
		$sql .= " where story_section_id=$section_id";
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