<?// Standard Configuration Variables used in the system.// DO NOT TOUCH.
// Unix timestamp to signify when the system became live.
// This is for retro fitting the old data with the new functions

define('SYSTEM_IMPLEMENTATION_DATE', 1210950840);	// *NEVER* change. Never ever ever.


// Directories
define('DIRECTORY_CONTROLLERS', BASE_MASTER.'controllers/'); 
define('DIRECTORY_TEMPLATES',	BASE_MASTER.'templates/');
define('DIRECTORY_SECURE_PDF',	BASE_SECURE_FILES.'pdf/');
define('DIRECTORY_PHOTOS',	BASE. SITE);	// like '/www/home/public_html/HT or EM
define('URL_PHOTOS_DIR',	'/'.SITE);
define('PATH_TO_COVER_IMAGES', DIRECTORY_PHOTOS);
define('PATH_TO_COLUMNIST_PHOTOS', DIRECTORY_PHOTOS . '/columnists');
define('URL_TO_COLUMNIST_PHOTOS', URL_PHOTOS_DIR . '/columnists');
define('MEMBER_FILEMAKER_FILE', BASE_SECURE_FILES . 'thestone/membership_last_uploaded.txt');
// URL Pieces
define('REQUEST_CONTROLLER', 	0);
define('REQUEST_ACTION', 		1);
define('VAR_1', 	2);
define('VAR_2', 	3);
define('VAR_3', 	4);
define('VAR_4', 	5);define('TEMPLATE_VAR_START', 	'{{');
define('TEMPLATE_VAR_END', 		'}}');// Sessions
define('SESSION_NAME', 'hilltimesdotcom');
define('STATUS_LIVE',	1);
define('STATUS_NOT_LIVE', 2);// Locked stories
define('STORY_LOCKED', 1);
define('STORY_UNLOCKED', 2);// Member Auth Level
define('MEMBER_AUTH_LEVEL_NORMAL', 	1);
define('MEMBER_AUTH_LEVEL_EDITOR', 	2);
define('MEMBER_AUTH_LEVEL_ADMIN', 	3);

define('NUMBER_CHARS_RETURN_MEMBER_ONLY',	500);



// Photo sizes
define('SMALL', 	'small-');	// 80px X 80px

define('MEDIUM', 	'medium-');	// 150px x 150px

define('LARGE', 	'large-');	// 300px X 300px


define('SIZE_SMALL', 80);

define('SIZE_MEDIUM', 150);

define('SIZE_LARGE', 300);

// Search vars
define('SEARCH_MAX_RESULTS_COUNT', '400');

// Include Files
define('FILE_FCKEDITOR' , 			$_SERVER['DOCUMENT_ROOT'] . '/site/system/fckeditor/fckeditor.php');
define('FILE_SPRY' , 				$_SERVER['DOCUMENT_ROOT'] . '/site/system/spry_init.php');
define('FILE_YAHOO_CALENDAR' , 		$_SERVER['DOCUMENT_ROOT'] . '/site/system/yahoo_calendar_init.php');
define('FILE_YAHOO_SLIDER',			$_SERVER['DOCUMENT_ROOT'] . '/site/system/yahoo_slider_init.php');
define('FILE_SCRIPTACULOUS_INIT',	$_SERVER['DOCUMENT_ROOT'] . '/site/system/scriptaculous_init.php');define('FILE_PAGE_FUNCTIONS',	DIRECTORY_TEMPLATES . '/tidbits/page_functions.php');
define('FILE_STORY_FUNCTIONS',	DIRECTORY_TEMPLATES . '/tidbits/story_functions.php');
define('FILE_POPULAR_STORIES',	DIRECTORY_TEMPLATES . '/tidbits/popular_stories.php');
define('FILE_SPECIAL_SUB_MENU',	DIRECTORY_TEMPLATES . '/tidbits/section_sub_menu.php');

define('FILE_HILLTIMES_FEED',	DIRECTORY_TEMPLATES . '/tidbits/hilltimes_feed.php');

define('FILE_EMBASSY_FEED',	DIRECTORY_TEMPLATES . '/tidbits/embassy_feed.php');

?>