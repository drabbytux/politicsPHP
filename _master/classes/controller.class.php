<?php
 /**
 * Hill Times Publishing Inc.
 * Online Services Department
 * Created by David L. Little
 * drabbytux@gmail.com
 * (c) Copyright 2007-2012 Hill Times Publishing Inc.
 *
*/
require_once('classes/database.class.php');
/**
 * Controller Class
 * 
 */
class Controller extends Database{
	public $URL_Request_Array = array();
	public $POST_Request_Array = array();
	public $data_holder = array();
	public $data = array();
	public $errors = array();
	public $messages = array();
	public $language_html_entities;
	private $ignoreURLSet = false;

	/**
	 * __contstruct
	 * Gets the Database reved up and sets some of the
	 * typical data variables to NULL values
	 */
	public function __construct( $ignoreURLSet = NULL ){
		$this->Database();
		$this->_SetAtAGlanceContent();
		$this->data['header'] 	= NULL;
		$this->data['output'] 	= NULL;
		$this->data['footer'] 	= NULL;
		$this->data['page_title'] 	= DEFAULT_TITLE;
		$this->Set_Member_Segment(); // Set Member Details
		$this->_SetHTMLTransTable();
		if( $ignoreURLSet ) {
			$this->ignoreURLSet = true;
		}
		// AUTH Member stuff - REMOVED july 28, 2008 - Editing static files shouldn't use the editor
		// $this->Set_Special_Authorized_Member_Segment(); //Set the special header for editor
	}

	public function Set_Common_Templates(){
		// $this->Load_All_Banners();
		$this->Set_Template( 'footer_links', 'common/footer_links.php' );
		$this->Set_Template( 'header', 'common/header-http.php' );
		$this->Set_Template( 'footer', 'common/footer-http.php' );
	}
	
	public function Set_Common_Secure_Templates() {
		// $this->Load_All_Banners();
		$this->Set_Template( 'footer_links', 'common/footer_links.php' );
		$this->Set_Template( 'header', 'common/header_secure-https.php' );
		$this->Set_Template( 'footer', 'common/footer_secure-https.php' );
	}	
	
	
	public function Load_All_Banners() {
		$this->Set_Template_With_PHP( 'banner_leaderboard', 'bannercode/leaderboard.php');
	}
	
	/**
	 * Call_Action()
	 * Is called to find out if the action exists and can be accessed.
	 * It then calls the method within your class
	 */
	public function Call_Action(){
		if( array_key_exists(REQUEST_ACTION, $this->URL_Request_Array) ){
			// If a cancel button is hit, forget the action, just go for the controller
			if( $this->Get_POST_Element('cancel') ){
				$this->index();
			}
			else if( !$this->Get_POST_Element('cancel') && method_exists($this, $this->URL_Request_Array[ REQUEST_ACTION ] ) && is_callable( array($this, $this->URL_Request_Array[ REQUEST_ACTION ] ) ) ){
				$action = $this->URL_Request_Array[ REQUEST_ACTION ];
				$this->$action();
			}else {
				$this->index();
			}
		} else {
			$this->index();
		}
	}
	
	/**
	 * index()
	 * Just a default index() method to make sure you make your own :)
	 */
	public function index(){
		print "Please define your own index() function within your controller.";
	}
	
	/**
	 * Set_URL_Request_Array
	 * Set a shared variable for your controller to access
	 * the URL Request
	 */
	public function Set_URL_Request_Array( $URL_Request_Array ){
		$this->URL_Request_Array = $URL_Request_Array;
		if( !$this->ignoreURLSet ) {
			$this->Set_URL_Wrapper();
		}
	}

	public function Set_POST_Element($key, $val){
		$this->POST_Request_Array[ $key ] = $val;
	}
	
	/**
	 * Set_POST_Request_Array
	 * Set a shared variable for your controller to access
	 * the POST vars
	 * @param $POST_Request_Array
	 */
	public function Set_POST_Request_Array( $POST_Request_Array ){
		$this->POST_Request_Array = $POST_Request_Array;
		$this->data = array_merge($this->data, $POST_Request_Array);
	}
	
	/**
	 * Get
	 * @param POST Variable $param
	 * An ALIAS of Get_Post_Element()
	 * Since we're using it sooooo much
	 */
	public function Get($POST_variable, $raw = false){
		return $this->Get_POST_Element($POST_variable, $raw);
	}
	
	public function Get_DB_Ready($POST_variable){
		return "'". addSlashes( $this->Get_POST_Element($POST_variable, true) ) . "'";
	}
	/**
	 * Get_URL_Element
	 * Fetch a segment off of the URL
	 */
	public function Get_URL_Element( $key ){
		if( array_key_exists($key, $this->URL_Request_Array ) ) {
			return $this->URL_Request_Array[ $key ];
		} else {
			return NULL;
		}
	}
	
	/**
	 * Get_Current_URL returns the current URL with all the GET stuff
	 * You can specify a limited number of URL elements to return - default is ALL
	 */
	public function Get_Current_URL( $get_variables_to_keep = NULL ) {
		if( is_array( $this->URL_Request_Array ) ) {
			if( $get_variables_to_keep ) {
				$str_url = NULL;
				for( $c=0; $c<=$get_variables_to_keep; $c++) {
					if( count( $this->URL_Request_Array ) > $c ) {
						$str_url .= '/'.$this->Get_URL_Element( $c );
					}
				}
				return $str_url;
			} else {		
				return '/'. implode('/', $this->URL_Request_Array );
			}
		} else { 
			return '/';
		}
	}
	
	/**
	 * Get_URL will return the current URL... Duh.
	 *
	 */
	public function Get_URL(){
		return SERVER_URL . $this->Get_Current_URL();
	}
	public function Set_URL_Element( $key, $val ){
		$this->URL_Request_Array[ $key ] = $val;
	}
	
	/**
	 * Get_POST_Element
	 * Fetch a segment from the POST array.
	 * This will return NULL if the key doesnt exist OR
	 * the field only had blanks
	 */
	public function Get_POST_Element( $key, $raw = false ){
		if( array_key_exists($key, $this->POST_Request_Array ) && trim( $this->POST_Request_Array[$key]) ) {
			if ($raw) {
				return stripSlashes($this->POST_Request_Array[ $key ]);
			} else {
				$tt = get_html_translation_table(HTML_ENTITIES); 
				return stripSlashes( strtr( $this->POST_Request_Array[ $key ], $this->language_html_entities ) );
			}
		} else {
			return NULL;
		}
	}
	
	/**
	 * Set_Template
	 * @param $template_name
	 * @param $file_name
	 * An Alias for Set_Template_With_PHP
	 * 
	 */
	public function Set_Template( $template_name, $file_name, $append_to_existing_template = false ){
		// Place any errors in the data before it's passed - thanks.
			$this->Set_Template_With_PHP( $template_name, $file_name, $append_to_existing_template );
	}

	/**
	 * Get_Error returns the message contained in the key sent
	 *
	 * @param unknown_type $key
	 * @return unknown
	 */
	public function Get_Error($key){
		if( array_key_exists( $key, $this->errors )){
			return $this->errors[$key];
		}
	}
	/**
	 * getData
	 * Now with an extra array element.
	 * @param $key
	 * Get a data element
	 */
	public function Get_Data($key, $array_sub_key = NULL ){
		if( array_key_exists( $key, $this->data ) ){
			if( $array_sub_key ){
				if( is_array( $this->data[$key] ) && array_key_exists( $array_sub_key, $this->data[$key] ) ) {
					return $this->data[$key][$array_sub_key];
				}
			} else {
				return $this->data[$key];
			}
		} else {
			return NULL;
		}
	}
	/**
	 * getDataHolder
	 * @param $key
	 * @param $array_element
	 * Get one of the arrays that exist within the data_holder variable
	 * or get an element of one of those arrays.
	 */
	public function Get_Data_Holder($key, $array_element = NULL){
		if( array_key_exists( $key, $this->data_holder ) ){
			if( $array_element ) {
					if( array_key_exists( $array_element, $this->data_holder[$key] ) ) {
						return $this->data_holder[$key][$array_element];
					}
				return NULL;
			} else {
				return $this->data_holder[$key];
			}
		} else {
			return NULL;
		}
	}

	/**
	 * Set_Data_from_Data_Holder_Array
	 * Pass it a key from the data_holder and all the elements
	 * within that array will be set to ind. data keys=>elements
	 */
	public function Set_Data_From_Data_Holder_Array($key, $front_append = NULL){
		if( array_key_exists( $key, $this->data_holder ) ){
			if( is_array($this->data_holder[$key] ) ){
				foreach( $this->data_holder[$key] as $k=>$item ){
					$data_key = ( $front_append ) ? $front_append. '_'. $k: $k;
					$this->data[ $data_key ] = $item;
				}
			}
		}
	}
	

	
	/**
	 * 	Set_Template_Loop
	 *  A Template that contains A Loop structure Piece to be
	 *  included within the body content
	 *  This function **DOES NOT** search-and-replace {{values}}.
	 * NEW: checks to see if there is a custom template by HT or EM first,
	 * then uses the default
	 */ 
	public function Set_Template_With_PHP( $template_name, $file_name, $append_to_existing_template = false ){
		if( $file_name ){
			$arr_file_name = explode( '/', $file_name);
			$fn = SITE. end( $arr_file_name );
			$arr_file_name[ count($arr_file_name)-1 ] = $fn;
			$rev_file_name = implode('/', $arr_file_name);
		}

		$file_name = ( file_exists( DIRECTORY_TEMPLATES. $rev_file_name ) )? $rev_file_name : $file_name;
	
		if ( file_exists(DIRECTORY_TEMPLATES . $file_name ) ) {
			$this->Place_Errors_In_Data();
			$this->Place_Messages_In_Data();
			ob_start();
            eval(" ?>" . file_get_contents( DIRECTORY_TEMPLATES . $file_name ). "<? ");
            $this->data[ $template_name ] = ( $append_to_existing_template )? $this->Get_Data( $template_name ) . ob_get_contents(): ob_get_contents();
            ob_end_clean();
		}
	}

	/**
	 * Parse_PHP_String
	 * The $incoming_php variable is optional. When set, it assumes pure PHP data is coming
	 * through without initial <? ?> tags
	 */
	public function Parse_PHP_String( $template_name, $str, $incoming_php = NULL ){
			ob_start();
            if( $incoming_php ) {
            	// $this->data[ $template_name ] = eval( $str );
            	// $this->data[ $template_name ] = ob_get_contents();
             } else {
            	eval(" ?>" .$str. "<? ");
            	$this->data[ $template_name ] = ob_get_contents();
            }
            ob_end_clean();	
       
	}
	
	/**
	 * Output_Page()
	 * Send everything to the user NOW!
	 */
	public function Output_Page(){
		print $this->data['header'];
		print $this->data['output'];
		print $this->data['footer'];
	}

	
	/**
	 * Adds on to the javascript string that will be placed within the body
	 * tag of the header template
	 */
	public function setJavascriptBodyOnLoadString( $javascript_str ){
		if( !array_key_exists('javascript_body_items', $this->data )) { $this->data['javascript_body_items'] = $javascript_str; }
		else { $this->data['javascript_body_items'] .= $javascript_str; }
	}
	/**
	 * Set_Error
	 * Set an error message
	 */
	public function Set_Error($Error_Message, $key_name = NULL){
		if ( $key_name ){
			$this->errors[$key_name] = $Error_Message;
		} else {
			$this->errors[] = $Error_Message;
		}
	}

	public function Has_Errors(){
		return count( $this->errors );
	}
	
	public function Set_Message($Message, $key_name = NULL){
		if ( $key_name ){
			$this->messages[$key_name] = $Message;
		} else {
			$this->messages[] = $Message;
		}
	}

	/**
	 * Place_Errors_In_Data
	 * This contains the HTML div tag for the errors
	 *
	 * @param unknown_type $flag_plain_text
	 */
	public function Place_Errors_In_Data( $flag_plain_text = NULL ){
		$str = NULL;
		foreach( $this->errors as $key=>$mesg ){
			$str .= ''. $mesg;
			$str .= ( count($this->errors) != $key+1 ) ? '<br />': NULL;
		}
		if( $flag_plain_text ) { 
			$str = ($str)? '<div class="errormessage">'. $str."</div>":NULL;
		}
		else {
			$str = ($str)? '<div id="error"><div class="topright"><img src="/site/images/spacer.gif" style="height: 1px;" /></div><div class="top"><img src="/site/images/blank.gif" style="height: 1px;" /></div><div class="content">'. $str.'</div><div class="bottomright"><img src="/site/images/spacer.gif" style="height: 1px;" /></div><div class="bottom"><img src="/site/images/blank.gif"  style="height: 1px;" /></div></div>':NULL;
		}
		$this->data['errors'] = $str;
	}
	
	public function Place_Messages_In_Data( $flag_plain_text = NULL ){
		$str = NULL;
		foreach( $this->messages as $key=>$mesg ){
			$str .= ''. $mesg;
			$str .= ( count($this->errors) != $key+1 ) ? '<br />': NULL;
		}
		if( $flag_plain_text ) { 
			$str = ($str)? '<div class="goodmessage">'. $str."</div>":NULL;
		}
		else {
			$str = ($str)? '<div id="goodmessage"><div class="top"><img src="/site/images/blank.gif" style="height: 1px;" /></div><div class="content">'. $str.'</div><div class="bottom"><img src="/site/images/blank.gif"  style="height: 1px;" /></div></div>':NULL;
		}
		$this->data['messages'] = $str;
	}
	
	/**
	 * Set_Session
	 * You can send it either a key and val seperatly,
	 * or an array of keys and values
	 *
	 * @param unknown_type $key
	 * @param unknown_type $value
	 */
	public function Set_Session($key, $value=NULL){
		if( is_array( $key ) ){
			// Use the key=> values if the $key is an array
			foreach( $key as $k=>$v) {
				$_SESSION[$k] = $v;
			}
		} else {
			$_SESSION[$key] = $value;	
		}
	}
	
	/**
	 * Append it, Sucker!
	 * Reteives the array from the session and appends it, if there is one.
	 * If not, it just creates the session variable.
	 *
	 * @param unknown_type $key
	 * @param unknown_type $array_key_val
	 */
	public function Append_to_Session_Array( $key, $array_key_val ){
		$value_already_exists = false;
		if( is_array( $this->Get_Session( $key ) ) ){
			$sess_arr = $this->Get_Session( $key );
			foreach( $array_key_val as $pass_key=>$pass_val ){
				if( in_array( $pass_val, $sess_arr ) ){
					$value_already_exists = true;
				}
			}
			if( !$value_already_exists ) {
				$final_arr = array_merge( $sess_arr, $array_key_val );
				$this->Set_Session( $key, $final_arr );
			}
		} else{
			$this->Set_Session( $key, $array_key_val );
		}
	}
	
	/**
	 * Get_Session
	 * Get a value of the key set, or pass it an
	 * array of keys (as values) and it will
	 * return an array of keys=>vals
	 *
	 * @param key/array $key
	 * @return unknown
	 */
	public function Get_Session($key){
		if( is_array( $key ) ){
			$return_array = NULL;
			// Use the key=> values if the $key is an array
			foreach( $key as $v) {
				if( array_key_exists( $v, $_SESSION ) ) {
					$return_array[ $v ] = $_SESSION[$v];
				}
			}
			return $return_array;
		} else {
			if( array_key_exists( $key, $_SESSION ) ) {
				return $_SESSION[$key];
			}
		}
	}
	
	public function Remove_Session($key){
		if( array_key_exists( $key, $_SESSION ) ) {
			$_SESSION[$key] = NULL;
			unset( $_SESSION[$key] );
		}
	}
	
	
	/**
	 * Removes Session Variables with keys that start with a specific string
	 * 
	 * 
	 * @param string $starting_string
	 */
	public function Clear_Session_Variables( $starting_string = NULL){
		$arr_session = $_SESSION;
		foreach( $arr_session as $key=>$var ){
			if( $starting_string ){
				$pattern = "/^".$starting_string."/i";
				if( preg_match($pattern, $key ) ){
					$this->Remove_Session( $key );
				}
			}
		}	
	}
	
	/**
	 * Set_Post_Sessions
	 * Places the the whole shabang of post variables
	 * into the session
	 * You can pass it the into piece of text to search for
	 * in a bundle of POST variables to store. ie: "member_" will
	 * store only post variables that start with "member_".
	 * !! HAS NOT BEEN TESTED YET  !!
	 *
	 */
	public function Set_Post_Sessions( $start_piece = NULL ){
		foreach( $this->POST_Request_Array as $key=>$var ){
			if( $start_piece ){
				if( preg_match("/^".$start_piece."/s", $key ) ){
					$this->Set_Session( $key, $var );
				}
			} else {
				$this->Set_Session( $key, $var );
			}
		}
	}
	
	/**
	 * Remove Array Elements
	 * Default is to remove BLANK elements from the array
	 * Send it an array of value(s) to remove as the second val
	 */
	public function Remove_Array_Elements( $arr, $arr_vals_to_remove = NULL ) {
		$tmparr = array();
		if( is_array( $arr ) ) {
			foreach( $arr as $key=>$val ){
				if( $arr_vals_to_remove ){
					if( !in_array( $val, $arr_vals_to_remove ) ) {	// If it's NOT a value to remove, then place it in the temp
						$tmparr[ $key ] = $val;
					}
				} else {
					if ( trim( $val ) ) {
						$tmparr[ $key ] = $val;
					}
				}
			}
		}
		return $tmparr;
	}


	
	public function Set_Member_Segment(){
		$str = NULL;
		if( $this->Get_Session('member_id') ){
			$str .= '<span class="topnavitem"><a href="/member/logout" style="color: red">Logout</a></span>';
			$this->data['member_link'] = $str;
			$this->data['member_edit_link'] = '<span class="topnavitem">Welcome '.$this->Get_Session('member_name_first').' &nbsp;(<a href="/member/edit">edit your account</a>)</span>';
		} else {
			$this->data['member_link'] = '<span class="topnavitem"><a href="/member/login">Login</a></span>';
		}
	}
	/**
	 * It's now an edit button
	 *
	 */
	public function Set_Special_Authorized_Member_Segment(){
			$str = NULL;
		if( $this->Get_Session('member_id') ){
			$this->Set_Template_With_PHP('authorized_member_menu', 'member/authorized_member_menu.php');	// Removed for the time being
		} else {
			// Nothing at all, man.
		}
	}
	
	/**
	 * Member Allowed
	 * Are they? Pass a level number to see if they meet or exceed the level
	 */
	public function MemberAllowed( $level_id = 1 ){
		if ( $this->Get_Session('member_level') >= $level_id ) {
			return true;
		}
		return false;
	}
	

	
	/**
	 * Set_URL_Wrapper
	 */
	public function Set_URL_Wrapper( $url = NULL ){
		$this->_SetOriginalPageWrapper( $url );
	}
	
	public function Get_URL_Wrapper(){
		return $this->Get_Session('PageWrapper');
	}
	
	/**
	 * Redirects the user to the last page known in the session wrapper
	 * Send it somewhere else to go if you don't want the default session wrapper location
	 *
	 * @param unknown_type $or_perhaps_another_place
	 */
	public function Redirect_URL_Wrapper( $or_perhaps_another_place = NULL ){
		$goto = $this->Get_URL_Wrapper();
		$this->Destroy_URL_Wrapper();
		if( $or_perhaps_another_place ){ 
			header('Location: '.  $or_perhaps_another_place);	
		} else {
			header('Location: '.  $goto);	
		}
	}
	
	public function Destroy_URL_Wrapper(){
		$this->Remove_Session('PageWrapper');
	}
	
	public function toPreviousPage() {
		header('Location: /' );
	}
	
	
	
	/**
	 * isActiveLink
	 */
	public function isActiveLink( $url=NULL, $class_name = NULL ){
		$str_return=NULL;
		if( $url ){
			if( $url == $this->Get_Current_URL(1) ){
				if( $class_name ){
					$str_return = 'class="'.$class_name.'"';
				}
			}
		} else {
			if( $this->Get_Current_URL() =='/' ){
				if( $class_name ){
					$str_return = 'class="'.$class_name.'"';
				}
			}
		}
		return $str_return;
	}
	/**
	 * Get Array Values
	 * Fetches values within multi-dim arrays.
	 */
	public function Get_Array_Values( $array_var, $key_name ){
		$arr_temp = NULL;
		if( is_array($array_var) ){
			foreach( $array_var as $var ){
				if( array_key_exists( $key_name, $var ) ) {
					$arr_temp[] = $var[$key_name];
				}
			}
		}
		return $arr_temp;
	}
	
	public function _validateEmailSyntax( $email_address ){
		if ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email_address))
			return FALSE;
		else
			return TRUE;	
	}
	
	/**
	 * Post cleaner cleans up tags from the incoming POST variable
	 * If the HTML_CLEANER var is set to true, it won't strip out the HTML within it.
	 * 
	 * @param unknown_type $post_var
	 * @param unknown_type $html_cleaner
	 * @return unknown
	 */
	public function post_cleaner($post_var = NULL, $html_cleaner = NULL){
		if( $html_cleaner ){
			return  htmlentities( stripslashes( strip_tags( trim( $this->Get_Data( $post_var ) ) ) ) ) ;
		} else {
			return stripcslashes( trim( $this->Get_Data( $post_var ) ) );
		}
	}
	
	/**
	 * Scrub exploits will take in your string and check it for problem
	 * words and phrases. If it finds something, 'error_spam' error is set
	 *
	 * @param unknown_type $str
	 */
	public function scrub_exploits( $str ){
		// Identify exploits
     	$head_expl = "/(bcc:|cc:|document.cookie|document.write|onclick|onload)/i";
  		$inpt_expl = "/(content-type|to:|bcc:|cc:|document.cookie|document.write|onclick|onload)/i";
  		
  		// identify Spam Words
  		$arr_spam_list = file( BASE_MASTER . "/includes/spam_words.txt");
  		$spam_expl = "/";
  		$word_count=0;
  		foreach( $arr_spam_list as $spam_word ){
  			$spam_expl .= str_replace("\r", "", str_replace("\n", "", $spam_word) );
  			$word_count++;
  			if( $word_count < count( $arr_spam_list )){
  				$spam_expl .= "|";
  			}
  		}
  		$spam_expl .= "/i";

		if( preg_match($head_expl, $str) || preg_match($inpt_expl, $str) ) {
    		 $this->Set_Error('<strong>&raquo;</strong> Please refrain from using any of the following words within any field: <strong>content-type</strong>, <strong>to:</strong>, <strong>bcc:</strong>, <strong>cc:</strong>, <strong>document.cookie</strong>, <strong>document.write</strong>, <strong>onclick</strong>, or <strong>onload</strong>. For security reasons, please find another way of communicating these terms.','error_spam');
		}
		
		$spam_match = preg_match($spam_expl, $str);

		// Find the SPAM
		if( $spam_match === false ) {
    		$this->Set_Error("<strong>&raquo;</strong>There was a system error - scrub_exploits function.", 'error_spam');
		}
		if(  $spam_match ) {
			$this->Set_Error('<strong>&raquo;</strong>There are certain words used in your message that could be mistaken for spam. For security reasons, please find another way of communicating these terms.', 'error_spam');
		}
		
	}
	
	

        
	/*	- - - - - - -   P R I V A T E   F U N C T I O N S - - - - - - - - - - */
	private function _SetHTMLTransTable(){
		$tt = get_html_translation_table(HTML_ENTITIES);
		unset( $tt['<'] );
		unset( $tt['>'] );
		unset( $tt['&'] );
		$this->language_html_entities = $tt;
	}
	
	private function _SetOriginalPageWrapper( $url = NULL){

		$url = ($url)? $url: $this->Get_Current_URL();
		$this->Set_Session( 'PageWrapper', $url );
	}
	
	/**
	 * _SetAtAGlanceContent
	 * Sets the main content for the drop-down AAG section
	 * This Breaks my rules for this controller, since it's very
//	 * content/site specific
	 */
	private function _SetAtAGlanceContent(){
		$this->data['aag_news'] =  $this->_CreateAAGContent(1);
		$this->data['aag_opinions'] =  $this->_CreateAAGContent(25);
		//$this->data['aag_policybriefings'] =  $this->_CreateAAGContent(25);
		$this->data['aag_letters'] =  $this->_CreateAAGContent(4);
		$this->data['aag_features'] =  $this->_CreateAAGContent(26);
		$this->data['aag_lists'] =  $this->_CreateAAGContent(15);
	}
	
	private function _CreateAAGContent( $section_id ){
		$arr_section_items = $this->_QueryAAGSection( $section_id );
		$str_html = '<div>';
		if( is_array( $arr_section_items ) ) {
			foreach( $arr_section_items as $item ){
				$str_html .= '<a width="100%;" href="/story/view/'.$item['story_url_id'].'">'.$item['story_title'].'</a>';
				$str_html .= '<br />';
			}
		}
		$str_html .= '</div>';
		return $str_html;
	}

	private function _QueryAAGSection($section_id, $limit=NULL){
		$sql  = "Select story_url_id, story_title, story_issue_date from story where story_section_id=$section_id";
		$sql .= " AND story_status=1";
		$sql .= " order by story_issue_date desc";
		$sql .= ($limit)? " limit $limit": " limit 5";
		
		return $this->ExecuteArray( $sql );
	}
	
}
?>