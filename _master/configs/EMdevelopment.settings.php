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
	define('DB_NAME', 			'embassy_dirty');
	
	// Live Date - for retro fitting older style stuff - The site will break if this is changed!!! ;)
	define('NEW_SITE_LIVE_DATE', 1218859200); // Aug 16, 2008
	
	
	// Document Root
	define('BASE',				$_SERVER['DOCUMENT_ROOT'].'/');
	define('BASE_MASTER',		BASE.'_master/');
	
	// URL
	define('URL_BASIC',			'dirty.embassymag.ca');
	define('SERVER_URL',		'http://'.URL_BASIC);
	define('SECURE_SERVER_URL',	'http://dirty.embassymag.ca');
	
	// Search engine URLS
	define('SEARCHL_URL_BASIC',	'www.embassymag.ca');
	define('SEARCH_URL',		'http://www.embassymag.ca');
	
	// Secure Document Root - MUST BE EDITED FOR THE SERVER!!!!!!
	define('BASE_SECURE_FILES',	'/www/core/secure_files/');

	// The Development server is defined, used for openx ads, among others
	define('DEVELOPMENT', true);

	
	// Items to be placed in the database for settings config
define('NEWSPAPER_NAME', "Embassy");
define('OTHER_NEWSPAPER_NAME', "The Hill Times");
define('DEFAULT_TITLE', "Embassy - Canada's Foreign Policy Newsweekly");
define('EMAIL_EDITOR', 'drabbytux@gmail.com'); // TESTING - change to editor when testing is complete
define('EMAIL_CIRCULATION', 'dlittle@hilltimes.com');
define('DOMAIN', 'embassymag.ca');
define('EMAIL_WEBMASTER', 'onlineservices@embassymag.ca');
define('EMAIL_SALES', 'webmaster@hilltimes.com');

define('EMAIL_ADDRESS_SYSTEM_1', 'Embassy Newspaper <no-reply@hilltimes.com>');
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