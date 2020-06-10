<?php
/**
 * Home controller
 * ** NOW DEFUNCT - Using the issue controller for the home page **
 * 
 * 
 */
require_once 'classes/inhouse.controller.class.php';
class Home extends InHouseController {
	
	// - - - - - - - - - - - - - - P U B L I C     M E T H O D S - - - - - - - - - - - - - - - \\

	function Home(){
		$this->__construct();
	}
	
	function index(){
		$this->Set_Common_Templates();
		$this->Output_Page();
	}
	

}
?>