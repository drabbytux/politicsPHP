<?php
/**
 * SERVER SPECIFIC SETTINGS - PRODUCTION
 * Included within the config file dynamically, depending on
 * what server it's being run on.
 * 
 */
	// Database
/*
	define('DB_HOST', 		'mysqlvws1.magma.ca');
	define('DB_USERNAME', 		'publinet');
	define('DB_PASSWORD', 		'pubSqlPA2');
	define('DB_NAME', 		'publinet');
*/
        define('DB_HOST',               'mysqlvws1.magma.ca');
        define('DB_USERNAME',           'magfest');
        define('DB_PASSWORD',           'HGw37Lq9');
        define('DB_NAME',               'magfest');	
	// Live Date - for retro fitting older style stuff
	define('NEW_SITE_LIVE_DATE', 1217390400);
	
	
	// Document Root
	define('BASE',				$_SERVER['DOCUMENT_ROOT'].'/');
	define('BASE_MASTER',		BASE.'_master/');
	
	// URL
	define('URL_BASIC',		'embassymag.ca');
	define('SERVER_URL',		'http://'.URL_BASIC);
	define('SECURE_SERVER_URL',	'http://embassymag.ca');
//	define('SECURE_SERVER_URL',	'https://vws1.magma.ca/www.festmag.com');
	
	// Secure Document Root - MUST BE EDITED FOR THE SERVER!!!!!!
	define('BASE_SECURE_FILES',	'/magma/users/u32/magfest/secure_files/');
	// /magma/users/u32/magfest
	// The Development server is defined, used for openx ads, among others
	 define('DEVELOPMENT', false);
	

	// Items to be placed in the database for settings config
define('NEWSPAPER_NAME', "Embassy");
define('OTHER_NEWSPAPER_NAME', "The Hill Times");
define('DEFAULT_TITLE', "Embassy - Foreign Policy Newsweekly");
define('EMAIL_EDITOR', 'editor@embassymag.ca'); // TESTING - change to editor when testing is complete
define('DOMAIN', 'embassymag.ca');

define('EMAIL_SALES', 'sales@embassymag.ca');
define('EMAIL_WEBMASTER', 'onlineservices@embassymag.ca');
define('EMAIL_CIRCULATION', 'circulation@embassymag.ca');
define('EMAIL_ADDRESS_SYSTEM_1', 'Embassy Newsweekly <no-reply@embassymag.ca>');
define('EMAIL_SUBJECT_LETTER_SUBMISSION', 'Embassy Website - Online Letter Submission');
	

// Page Area and Sections - just to help with the clarification
// when making templates. Define here as they appear in the database
define('FRONT_PAGE', 0);
define('NEWS', 1);
define('TALKING_POINTS', 2);
define('EDITORIAL', 4);
define('COLUMNS', 3);
define('LISTINGS', 6);
define('POLICYBRIEFING', 25);
//define('SURVEY', 14);
//define('ALIST', 15);
//define('CAREERS', 16);
//define('CLASSIFIED', 17);
//define('TRAVEL', 18);
//define('CORRECTION', 21);
define('OPED', 12);
define('FEATURE', 7);
define('QA', 20);
// define('BREAKINGNEWS', 36);
define('CULTURE', 8);
	
?>
