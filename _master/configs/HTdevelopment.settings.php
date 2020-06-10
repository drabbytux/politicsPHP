<?php
/**
 * SERVER SPECIFIC SETTINGS - DEVELOPMENT
 * Included within the config file dynamically, depending on
 * what server it's being run on.
 * 
 */
	// Database
	define('DB_HOST', 			'127.0.0.1');
	define('DB_USERNAME', 		'root');
	define('DB_PASSWORD', 		'webserver');
	define('DB_NAME', 			'hilltimes_dirty');
	
	// Live Date - for retro fitting older style stuff
	define('NEW_SITE_LIVE_DATE', 1228021200); // Nov 30, 2008
	
	// Document Root
	define('BASE',				$_SERVER['DOCUMENT_ROOT'].'/');
	define('BASE_MASTER',		BASE.'_master/');
	
	// URL
	define('URL_BASIC',			'dirty.hilltimes.com');
	define('SERVER_URL',		'http://'.URL_BASIC);
	define('SECURE_SERVER_URL',	'http://dirty.hilltimes.com');
	
	// Search engine URLS
	define('SEARCHL_URL_BASIC',	'www.hilltimes.com');
	define('SEARCH_URL',		'http://'.SEARCHL_URL_BASIC);
	
	// Secure Document Root - MUST BE EDITED FOR THE SERVER!!!!!!
	define('BASE_SECURE_FILES',	BASE . SITE .'/secure_files/');
	
	// The Development server is defined, used for openx ads, among others
	define('DEVELOPMENT', true);
	

	// Items to be placed in the database for settings config
define('NEWSPAPER_NAME', "The Hill Times");
define('OTHER_NEWSPAPER_NAME', "Embassy");
define('DEFAULT_TITLE', "The Hill Times - Canada's Politics and Government Newsweekly");
define('EMAIL_EDITOR', 'dlittle@hilltimes.com'); // TESTING - change to editor when testing is complete
define('DOMAIN', 'hilltimes.com');

define('EMAIL_SALES', 'webmaster@hilltimes.com');

define('EMAIL_ADDRESS_SYSTEM_1', 'The Hill Times <no-reply@hilltimes.com>');
define('EMAIL_SUBJECT_LETTER_SUBMISSION', 'Embassy Website - Online Letter Submission');
	

// Page Area and Sections - just to help with the clarification
// when making templates. Define here as they appear in the database
define('FRONT_PAGE', 0);
define('NEWS', 1);
define('EDITORIAL', 3);
define('COLUMNS', 5);
define('CALENDAR', 11);
define('POLICYBRIEFING', 13);
define('SURVEY', 14);
define('ALIST', 15);
define('CAREERS', 16);
define('CLASSIFIED', 17);
define('TRAVEL', 18);
define('CORRECTION', 21);
define('OPED', 25);
define('FEATURE', 26);
define('QA', 31);
define('BREAKINGNEWS', 36);	
define('CULTURE', 37);	
	
?>