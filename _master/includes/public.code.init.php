<?php

/**
 * Public Code initialization
 * Gets all the common classes
 * and sets them in motion
 * 
 */

require_once('classes/database.class.php');
require_once('classes/request.class.php');
require_once('includes/basic_functions.php');

// Start up the Session
session_name(SESSION_NAME);
session_start();
header("Cache-control: private");

/* MObile Detection */
require_once('includes/mobile_detection_script.php');

// The request object is created and the URL/Request variables are set
	$Req = new Request();

/**
 * T H E   M A S T E R   B E A S T   O F    I T    A L L
 */
// The Controller Object is created based on the URL Controller segment
	$Controller_Name = $Req->getURLElement(REQUEST_CONTROLLER);
	
	//Mobile Redirect
	if($Req->getURLElement(REQUEST_CONTROLLER) != 'mobile') {
		if($isMobile){
   			header('Location: /mobile/');
   			exit();
		}
	}
	
	if( file_exists(DIRECTORY_CONTROLLERS . $Controller_Name . '.php' ) ) {
		include( DIRECTORY_CONTROLLERS . $Controller_Name . '.php' );
		$Con = new $Controller_Name();
		// Every controller extends the Controller Class
		$Con->Set_URL_Request_Array( $Req->getURLElementArray() );			
		$Con->Set_POST_Request_Array( $Req->getRequestArray() );
		$Con->Call_Action();
	} else if ( !$Controller_Name ) {
		include( DIRECTORY_CONTROLLERS . 'issue.php' );	// HOME PAGE
		$Con = new Issue();
		$Con->Set_URL_Request_Array( $Req->getURLElementArray() );	// This is just to set the PageWrapper Session
		$Con->Call_Action();
	}	else {
		print "Sorry - The <strong>". $Controller_Name ."</strong> Page cannot be found - DL.";
	}

	
?>