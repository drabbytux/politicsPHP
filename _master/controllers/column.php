<?php
/**
 * ------------------
 * Column Controller
 * ------------------
 * Created by David Little
 * Sept 2008
 * Modified History
 * - - - - - - - - - - -
 * 
 * - - - - - - - - - - - 
 * 
 */

require_once 'classes/controller.class.php';
require_once 'controllers/issue.php';
class Column extends Issue {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Column(){
		$this->__construct();
		$this->data['page_type'] = 'column';
	}
	

	public function index(){
		$this->Set_Template( 'output', 'columns/index.php' );	// Default page with everything		
		$this->Set_Common_Templates();
		$this->Output_Page();
	}

	
	public function all(){
		$arr_section = NULL;
		
		if( $this->Get_URL_Element(VAR_1) ){
			$arr_section = $this->_getSectionDetailBySectionTitle( $this->Get_URL_Element(VAR_1) );
		}
		
		if( is_array( $arr_section ) ){
			$this->_fetchStories( $arr_section['section_id'] );
			$this->setPageTitle( $arr_section['section_title'] );
			$this->data['section_details'] = 	$arr_section;
		}
		
		$this->Set_Template( 'output', 'column/default.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();
	}

	
	
	public function view(){
		if( $this->Get_URL_Element(VAR_1) ){ // A Column has been called out!
			$this->setColumnStories( $this->Get_URL_Element(VAR_1) ); 
			$this->setColumnDetails( $this->Get_URL_Element(VAR_1) );
		}
				// Set columnist names
		$this->setColumnistList();
		
		// Set column Names
		$this->setSectionsInSectionType(2);
		
		$this->Set_Template( 'output', 'column/column.php' );
		$this->Set_Common_Templates();
		$this->Output_Page();	
	}
	
	public function author(){
		
		
		
	}
	
	
	
	/* ****** PRIVATE ******************************** */
	
	private function setColumnStories( $var_1 ){
		$sql = "SELECT s.* from story s where s.story_section_id=$var_1";
		$sql .= " and story_status=". STATUS_LIVE ." and story_issue_date <=". mktime();
		$sql .= " order by story_issue_date desc limit 0,25";
		$res = $this->ExecuteArray($sql);
		$this->data['column_stories'] = $res;
	}
	
	private function setColumnDetails( $var_1 ) {
		$sql = "SELECT * from section where section_id=$var_1";
		$res = $this->ExecuteAssoc($sql);
		$this->data['column_details'] = $res;
	}

}
?>