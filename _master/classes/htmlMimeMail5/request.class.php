<?php
 /**
  * 
  *  Request Class
  * 
  *  Retrieves and cleans the URL and POST variables.
  *  There are no _GET variables allowed on the site, instead
  *  all _GET variables are within the URL itself
  *  
  */


class Request {
	private $url;		// Holds the current URL
	private $element;	// URL Element Array
	private $request;	// POST array
	
	public function __construct(){
		reset( $_POST );
		$this->url 		= $_SERVER['REQUEST_URI'];
		$this->request	= $_POST;
		$this->Set_URL_Request();
		$this->Set_Request_Variables();
	}

	/**
	 * Get
	 * Returns the request variable by key name
	 */
	public function get( $key ){
		if( array_key_exists($key, $this->request ) ) {
			return $this->request[ $key ];
		} else {
			return NULL;
		}
	}
	
	/**
	 * Set
	 * Sets the request variable by $key, then by $value
	 */
	public function set($key, $val){
		$this->request[ $key ] = $val;
	}
	
	/**
	 * Get Url Element
	 * Get a URL element by Key Name
	 */
	public function getURLElement( $key ){
		if( array_key_exists($key, $this->element ) ) {
			return $this->element[ $key ];
		} else {
			return NULL;
		}
	}
	
	/**
	 * Get Request Array
	 * Get cleaned up Post variables
	 */
	public function getRequestArray(){
		return $this->request;
	}
	
	public function getURLElementArray(){
		return $this->element;
	}
	
	public function getURL(){
		return $this->url;
	}

	/**
	 * Split_URL_Request
	 * Instead of GET variables, we are using
	 * the URL entry as variables.
	 * Each slice is variable, and they are defined within the config.php
	 */
	private function Set_URL_Request(){
		$this->element = explode( '/', trim( $this->url, '/') );
		$tmparr = array();
		foreach( $this->element as $key=>$val ){
			if( trim($val) ){
				$tmparr[ $key ] = $val;
			}
		}
		$this->element = $tmparr;
	}
	
	/**
	 * Set_Request_Variables
	 * We are ONLY accepting POST variables
	 * for our website.
	 */
	private function Set_Request_Variables(){
		$tmparr = array();
		if( is_array( $this->request ) ) {
			foreach( $this->request as $key=>$val ){
				if( trim( $val ) ){
					$tmparr[ $key ] = $val;
				}
			}
		}
		$this->request = $tmparr;
	}
	


	
}
?>