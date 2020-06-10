<?php

require_once 'classes/inhouse.controller.class.php';
class Information extends InHouseController  {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Information(){
		$this->__construct();
	}
	
	public function index(){
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	
	
	public function view(){
		// View requires var 1 
		if(  $this->_doesPageExist( $this->Get_URL_Element( VAR_1 ) ) ){ 



			// $this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
			
			$this->data_holder['arr_information_page'] 		= $this->_getPage( $this->Get_URL_Element( VAR_1 ) );
			// Get the file instead of the content, if it's there.
			if( $this->Get_Data_Holder('arr_information_page', 'information_page_file_name') ) {
				if( !$this->_getFileFromName('information_page_body', $this->Get_Data_Holder('arr_information_page', 'information_page_file_name') ) ) {
					$this->Parse_PHP_String('information_page_body', $this->Get_Data_Holder('arr_information_page', 'information_page_content') ); // Now parsing PHP out of DB entries
				}
			} else {
				$this->Parse_PHP_String('information_page_body', $this->Get_Data_Holder('arr_information_page', 'information_page_content') ); // Now parsing PHP out of DB entries
			}
			
			$this->data['information_page_name']			= $this->Get_Data_Holder('arr_information_page', 'information_page_name');
			
		
			$this->data['page_date']						= $this->_formatDate( $this->Get_Data_Holder('arr_information_page', 'information_page_date_updated') );
			$this->data['page_long_date']					= $this->_formatDate( $this->Get_Data_Holder('arr_information_page', 'information_page_date_updated'), true );
			$this->data['page_title']						= $this->Get_Data_Holder('arr_information_page', 'information_page_name');

			$this->Set_Template( 'output', 'information/view.php' );	// Uses the previous variables

		} else {
			$this->Set_Template( 'output', 'information/404.php' );	// 404 or main page. Hmmmmmm.
		}
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	


	public function edit(){
		if( $this->MemberAllowed( MEMBER_AUTH_LEVEL_EDITOR ) ){
			
			if(  $this->_doesPageExist( $this->Get_URL_Element( VAR_1 ) ) ){
					// Get the Page Itself, and set custom stuff
				$this->data_holder['arr_page'] 	= $this->_getPage( $this->Get_URL_Element( VAR_1 ) );
				$this->Set_Data_From_Data_Holder_Array('arr_page');
				$this->data['page_date']					= $this->_formatDate( $this->Get_Data_Holder('arr_page', 'information_page_date_updated') );
				$this->data['page_unix_date']				= $this->Get_Data_Holder('arr_page', 'information_page_date_updated');
	
				$this->data['page_content']					= $this->Get_Data_Holder('arr_page', 'information_page_content');
				$this->Set_Template_With_PHP( 'output', 'information/edit.php' );	// Uses the previous variables	
				$this->Set_Common_Templates();
				$this->Output_Page();
			} else { // NEW page
				$this->Set_Template_With_PHP( 'output', 'information/edit.php' );	// Uses the previous variables	
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
	
	/**
	*	Contact uses the var_1 as what contact page to make
	*/
	public function contact(){
		
		if( $this->Get_URL_Element( VAR_1 ) ){
			
			if( $this->Get_URL_Element( VAR_1 ) == 'advertise' ) {
				// Validate form
				// Name, email, phone, address, city, prov, postal code
					if( !$this->Get('adv_name') ){
						$this->Set_Error('Please fill in your full name.','adv_error_name');
					}
					
					if( !$this->Get('adv_email') ){
						$this->Set_Error('Please fill in your email address.','adv_error_email');
					}
					
					if( !$this->_validateEmailSyntax( $this->Get('adv_email') ) ){
						$this->Set_Error('Please fill a proper email address.','adv_error_email');
					}
								
					if( !$this->Get('adv_phone') ){
						$this->Set_Error('Please fill in your phone number.','adv_error_phone');
					}
					
					if( !$this->Get('adv_address') ){
						$this->Set_Error('Please fill in your Address.','adv_error_address');
					}
								
					if( !$this->Get('adv_city') ){
						$this->Set_Error('Please fill in your city.','adv_error_city');
					}
								
					if( !$this->Get('adv_prov') ){
						$this->Set_Error('Please fill in your province/state.','adv_error_prov');
					}
								
					if( !$this->Get('adv_postal') ){
						$this->Set_Error('Please fill in your Postal code/Zip code.','adv_error_postal');
					}
				
					
			}
			
			if( !$this->Has_Errors() ){
				// Good to go
				
				// 1 send email
						$this->Set_Template( 'sales_email_message', 'information/advertise_email_response.php');
						$this->_Send_Email( 'sales_email_message', 'Advertising Request from Website', EMAIL_SALES, EMAIL_ADDRESS_SYSTEM_1 );
			
						$this->Set_Template_With_PHP( 'advertising_output', 'information/advertise_contact_response.php' );	// Uses the previous variables	
						
				// 2 show complete page
				$this->Set_Template_With_PHP( 'output', 'information/advertise.php' );	// Uses the previous variables	
				$this->Set_Common_Templates();
				$this->Output_Page();
				
			} else {
				$this->Set_Template_With_PHP( 'advertising_output', 'information/advertise_contact_form.php' );	// Uses the previous variables	
			
				$this->view();
			}
		
		}
	
	}
	
	// - - - - - - - - - - - - - - P R I V A T E     M E T H O D S - - - - - - - - - - - - - - - \\

	
	private function _Send_Email( $data_variable_email_content, $email_subject, $email_to, $email_from ) {
		if( $this->Get_Data( $data_variable_email_content ) && $email_to && $email_from ) {
			if( mail( $email_to, $email_subject, $this->Get_Data( $data_variable_email_content ), "From: $email_from") ) {
				return true;
			} else {
				$this->Set_Error('Could not send Email. The system is not configured to send mail');
			}
		}
	}
	
	private function _getPage( $link_id ){
		if($link_id){
			$sql = "SELECT * from information_page where information_page_link_name='$link_id'";
			return $this->ExecuteAssoc($sql);
		}

	}
	
	private function _getFileFromName( $data_name, $file_name ) {
		if( $file_name ) {
			// Scoop up the file
			if( file_exists(DIRECTORY_TEMPLATES . 'information/'. $file_name ) )  {
				$this->Set_Template( $data_name, 'information/'. $file_name );
				$this->data['file_used'] = true;
				return true;
			}
		}
	}
	
	
	private function _doesPageExist( $link_id ){
		if( $link_id ){
			$sql = "SELECT information_page_id from information_page where information_page_link_name='$link_id'";
			$res = $this->Execute($sql);
			if( mysql_num_rows( $res ) >= 1 ){
				return true;
			}
		}
		return false;		
	}

	private function _SavePage() {
		if( $this->_doesPageExist( $this->Get_URL_Element( VAR_1 ) ) ) {
			//Update existing story

			$sql  = "UPDATE information_page set ";
			$sql .= 'information_page_name='. 				$this->Get_DB_Ready('information_page_name')  			. ", ";
			$sql .= 'information_page_link_name='.			str_replace(' ', "-", $this->Get_DB_Ready('information_page_link_name') ) 	 	. ", ";
			$sql .= 'information_page_tags='.				$this->Get_DB_Ready('information_page_tags')  			. ", ";
			$sql .= 'information_page_content='.			$this->Get_DB_Ready('information_page_content')  		. ", ";
			$sql .= 'information_page_date_updated='.		mktime()  	. " ";
			$sql .= " WHERE information_page_link_name=".	"'". $this->Get_URL_Element( VAR_1 )  ."'";	

			$res = $this->Execute( $sql ) or die( 'There was a database error. Please contact the system administrator.' );
			$this->Set_Message('Information Page saved successfully', 'auth_message');
		} else {
			//Insert new story
			$link_name = str_replace(' ', '_', $this->Get('information_page_link_name') );
			$sql = "INSERT into information_page";
			$sql .= " ( information_page_name, information_page_content, information_page_tags,information_page_link_name, information_page_date_updated )";
			$sql .= " values (";
			$sql .= $this->Get_DB_Ready('information_page_name')  			. ", ";
			$sql .= $this->Get_DB_Ready('information_page_content')  			. ", ";
			$sql .= $this->Get_DB_Ready('information_page_tags')  			. ", ";
			$sql .= "'". $link_name	."'"									. ", ";
			$sql .= mktime();
			$sql .= ")";
			$res = $this->Execute( $sql ) or die( 'Error INFOSAVE : There was a database error. Please contact the system administrator.' );

			$this->Set_Message('The New page was created successfully', 'auth_message');
			
			// Set the view page as THIS one
			$this->Set_URL_Element(VAR_1, $link_name);
		}
	}
	
}
?>