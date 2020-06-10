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



require_once 'classes/inhouse.controller.class.php';
class Classifieds extends InHouseController {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Classifieds(){
		$this->__construct();
	}

	public function index(){
		$this->Set_Template('output', 'classifieds/temp.php' ); // 'classifieds/index.php' );	// 404 or main page. Hmmmmmm.
		$this->_setClassifiedHeaders();
		$this->Output_Page();
	}
	
	public function vacation(){
		$this->Set_Template('output', 'classifieds/vacation.php' ); // 'classifieds/index.php' );	// 404 or main page. Hmmmmmm.
		$this->_setClassifiedHeaders();
		$this->Output_Page();
	}
	
	/**
	 * Sections will show the available sections that have items under it.
	 * First var sent will be a specific section to view it's items.
	 *
	 */
	public function sections(){
		if( $this->Get_URL_Element( VAR_1 )){
			$this->_setSection( $this->Get_URL_Element( VAR_1 ) );
			$this->_setSectionItems( $this->Get_URL_Element( VAR_1 ) );
			$this->Set_Template('output', 'classifieds/section_items.php' );	
		} else {
			$this->_setSections();
			$this->Set_Template('output', 'classifieds/sections.php' );
		}
		$this->_setClassifiedHeaders();
		$this->Output_Page();	
	}
	
	public function real_estate(){
		$this->Set_Template('output', 'classifieds/real_estate.php' );
		$this->_setClassifiedHeaders();
		$this->Output_Page();
	}
	
	public function services(){
		$this->Set_Template('output', 'classifieds/services.php' );
		$this->_setClassifiedHeaders();
		$this->Output_Page();
	}
	
	public function forsale(){
		$this->Set_Template('output', 'classifieds/forsale.php' );
		$this->_setClassifiedHeaders();
		$this->Output_Page();
	}

	public function careers(){
		$this->Set_Template('output', 'classifieds/careers.php' );
		$this->_setClassifiedHeaders();
		$this->Output_Page();
	}
	
	public function restaurants(){
		$this->Set_Template('output', 'classifieds/restaurants.php' );
		$this->_setClassifiedHeaders();
		$this->Output_Page();
	}
	public function travel(){
		$this->Set_Template('output', 'classifieds/travel.php' );
		$this->_setClassifiedHeaders();
		$this->Output_Page();
	}	
	
	// Posting your ad
	public function post(){
		
		//Incoming stuff from form
		if( $this->Get('submit_classified_post') ){
			// Error checking
			if( !$this->Get('classified_item_contact_name') ){
				
			}
			if( !$this->Get('classified_item_contact_email') ){
				
			}
			if( !$this->Get('classified_item_contact_phone') ){
				
			}
			if( !$this->Get('classified_item_contact_address') ){
				
			}
			if( !$this->Get('classified_item_contact_city') ){
				
			}
			if( !$this->Get('classified_item_contact_province') ){
				
			}
			if( !$this->Get('classified_item_contact_name') ){
				
			}
			if( !$this->Get('classified_item_contact_name') ){
				
			}
/*


 */
			
		} else {		
			$this->_setSections(true);
			$this->Set_Template('output', 'classifieds/post.php' );	// 404 or main page. Hmmmmmm.
			$this->_setClassifiedHeaders();
			$this->Output_Page();
		}
	}

	// ------- P R I V A T E ------------------------------ //
	
	private function _setClassifiedHeaders(){
		$this->Set_Common_Templates();
		//$this->Set_Template('header', 'classifieds/header-http.php');
		//$this->Set_Template('footer', 'classifieds/footer-http.php');
	}
	
	/**
	 * Sets the sections that contain active items, with the item count
	 * If you set $show_all to true, it will return all categories regardless
	 * of item counts
	 *
	 */
	private function _setSections( $show_all = false ){
		if( $show_all ){
			$sql = "SELECT * from classified_category order by classified_category_title";
		} else {
			$sql = "SELECT cc.*, count(ci.classified_item_id) as item_count from classified_category as cc left join classified_item as ci on ( ci.classified_item_category_id=cc.classified_category_id ) group by cc.classified_category_title";
		}
		$res = $this->ExecuteArray($sql);
		if( is_array( $res ) ) {
			$this->data['classified_sections'] = $res;
		}
	}
	
	private function _setSection( $section_id ){
		$sql = "SELECT * from classified_category where classified_category_id=$section_id";
		$res = $this->ExecuteAssoc( $sql );
		if( is_array( $res ) ) {
			$this->data['classified_section'] = $res;
		}
	}
	
	private function _setSectionItems( $section_id ){
		$sql = "SELECT * from classified_item where classified_item_category_id=$section_id";
		$res = $this->ExecuteArray( $sql );
		if( is_array( $res ) ) {
			$this->data['classified_items'] = $res;
		}
	}


}
?>