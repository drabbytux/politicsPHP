<?
// Unix timestamp to signify when the system became live.
// This is for retro fitting the old data with the new functions

define('SYSTEM_IMPLEMENTATION_DATE', 1210950840);	// *NEVER* change. Never ever ever.



define('DIRECTORY_CONTROLLERS', BASE_MASTER.'controllers/'); 
define('DIRECTORY_TEMPLATES',	BASE_MASTER.'templates/');
define('DIRECTORY_SECURE_PDF',	BASE_SECURE_FILES.'pdf/');
define('DIRECTORY_PHOTOS',	BASE. SITE);	// like '/www/home/public_html/HT or EM
define('URL_PHOTOS_DIR',	'/'.SITE);
define('PATH_TO_COVER_IMAGES', DIRECTORY_PHOTOS);
define('PATH_TO_COLUMNIST_PHOTOS', DIRECTORY_PHOTOS . '/columnists');
define('URL_TO_COLUMNIST_PHOTOS', URL_PHOTOS_DIR . '/columnists');
define('MEMBER_FILEMAKER_FILE', BASE_SECURE_FILES . 'thestone/membership_last_uploaded.txt');

define('REQUEST_CONTROLLER', 	0);
define('REQUEST_ACTION', 		1);
define('VAR_1', 	2);
define('VAR_2', 	3);
define('VAR_3', 	4);
define('VAR_4', 	5);
define('TEMPLATE_VAR_END', 		'}}');









define('NUMBER_CHARS_RETURN_MEMBER_ONLY',	500);



// Photo sizes
define('SMALL', 	'small-');	// 80px X 80px

define('MEDIUM', 	'medium-');	// 150px x 150px

define('LARGE', 	'large-');	// 300px X 300px


define('SIZE_SMALL', 80);

define('SIZE_MEDIUM', 150);

define('SIZE_LARGE', 300);





define('FILE_FCKEDITOR' , 			$_SERVER['DOCUMENT_ROOT'] . '/site/system/fckeditor/fckeditor.php');
define('FILE_SPRY' , 				$_SERVER['DOCUMENT_ROOT'] . '/site/system/spry_init.php');
define('FILE_YAHOO_CALENDAR' , 		$_SERVER['DOCUMENT_ROOT'] . '/site/system/yahoo_calendar_init.php');
define('FILE_YAHOO_SLIDER',			$_SERVER['DOCUMENT_ROOT'] . '/site/system/yahoo_slider_init.php');
define('FILE_SCRIPTACULOUS_INIT',	$_SERVER['DOCUMENT_ROOT'] . '/site/system/scriptaculous_init.php');
define('FILE_STORY_FUNCTIONS',	DIRECTORY_TEMPLATES . '/tidbits/story_functions.php');
define('FILE_POPULAR_STORIES',	DIRECTORY_TEMPLATES . '/tidbits/popular_stories.php');
define('FILE_SPECIAL_SUB_MENU',	DIRECTORY_TEMPLATES . '/tidbits/section_sub_menu.php');

define('FILE_HILLTIMES_FEED',	DIRECTORY_TEMPLATES . '/tidbits/hilltimes_feed.php');

define('FILE_EMBASSY_FEED',	DIRECTORY_TEMPLATES . '/tidbits/embassy_feed.php');

