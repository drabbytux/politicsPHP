<?php
/**
 * ------------------
 * PDF Controller
 * ------------------
 * Created by David Little
 * September 2007
 * Modified History
 * - - - - - - - - - - -
 * 
 * - - - - - - - - - - - 
 * 
 */


require_once 'controllers/issue.php';
class Pdf extends Issue {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Pdf(){
		$this->__construct();
	}
	

	public function index(){
		$this->Set_Common_Templates();
		$this->Output_Page();
	}

	public function view(){
		if( !$this->Get_URL_Element( VAR_1 ) )	{		
			$this->Set_Template( 'output', 'issue/404.php' );	// 404 or main page. Hmmmmmm.
			$this->Set_Common_Templates();
			$this->Output_Page();
		} else {	// Creditentials set?
			if( $this->_doesPDFFileExist() ){
				if( $this->_IsAccessGranted() ){ // Access allowed, send the PDF
					$this->_loadPDFFile();
					$this->_sendPDFHeaders();
					$this->_sendPDF();	
							
				} else {
					$this->Set_Common_Templates();
					$this->Set_Message('Please sign into your account to download this PDF', 'message');
					$this->Set_Template( 'output', 'member/login.form.php' );	// Please login
					$this->Output_Page();
				}
					
			}	else { // The PDF file doesn't exists
				$this->Set_Common_Templates();
				$this->Set_Template( 'output', 'pdf/pdf_does_not_exist.php' );	// Ooops - no pdf
				$this->Output_Page();
			}
		}
	}
	
	
	/* private functions */

	
	/**
	 * _IsAccessGranted
	 * Returns true if is logged in
	 *
	 * @param unknown_type $story_id
	 * @return unknown
	 */
	private function _IsAccessGranted(){
		// $arr_story_security_elements = $this->_getStory( $story_id, true);	// will return story_lock_current_issue, story_lock_archives
		if( $this->MemberAllowed() ) {
			return true;
		}

	}
	
	private function _loadPDFFile(){
		$this->data['pdf_contents'] = file_get_contents( DIRECTORY_SECURE_PDF . $this->_getFileName() );
	
	}
	private function _sendPDFHeaders(){
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="'.$this->_getFileName().'"');
	}
	
	private function _sendPDF() {
		print $this->data['pdf_contents'];
	}
	
	private function _doesPDFFileExist(){
		if( file_exists( DIRECTORY_SECURE_PDF . $this->_getFileName() ) ) {
			return true;				
		}
		return NULL;
	}
	
	private function _getFileName(){
		if( $this->_setFileDate( ) ){
			return $this->data['pdf_year'].'/'.$this->data['pdf_month']. $this->data['pdf_day'] . $this->data['pdf_short_year']. '_'.strtolower(SITE).'.pdf'; 
		} else {
			return NULL;
		}
		
	}
	
	private function _setFileDate( ){
		if( $this->Get_URL_Element( VAR_1 ) ){
			$arr_date = explode('-', $this->Get_URL_Element( VAR_1 ));
			if( count( $arr_date)==3 ) {
				$this->data['pdf_year'] 	= $arr_date[0];
				$this->data['pdf_short_year'] = substr( $arr_date[0], 2 );
				$this->data['pdf_month'] 	= $arr_date[1];
				$this->data['pdf_day'] 		= $arr_date[2];
			} else {
				return false;
			}
			return true;
		}
		return false;
	}

}
?>