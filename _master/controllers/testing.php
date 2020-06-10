<?php


require_once 'controllers/issue.php';
class Testing extends Issue {
	
	// - - - - - - - - - - - - - - P U B L I C    M E T H O D S - - - - - - - - - - - - - - - \\

	function Testing(){
		$this->__construct( true );
	}
	
	function Data() {
		print '<pre style="background-color: #99CCFF; border: 2px #3333FF solid; color: #3333FF; padding: 8px;">';
		print_r($this->data);
		print "</pre>";
	}
	function Post(){
		print '<pre style="background-color: #99CCFF; border: 2px #3333FF solid; color: #3333FF; padding: 8px;">';
		print_r( $_POST );
		print "</pre>";
		
	}
	function php(){
		phpinfo();
	}

}
?>