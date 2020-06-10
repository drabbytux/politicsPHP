<?



/**
 * Dynamic Configs that aid in deployment of
 * bug fixes and development of new apps
 */
// Dynamically get the proper server configuration variables
// for no-worry uploads/downloads


// define('SITE', 'EM');



if( strstr($_SERVER["HTTP_HOST"], 'hilltimes') ) {
	define('SITE', 'HT');
	if( strstr($_SERVER["HTTP_HOST"], 'dirty.') || strstr($_SERVER["HTTP_HOST"], 'clean.') ) {
		require_once(SITE.'development.settings.php');
	} else {
		require_once(SITE.'production.settings.php');
	}
} else if(  strstr($_SERVER["HTTP_HOST"], 'embassymag') ) {
	define('SITE', 'EM');
	if( strstr($_SERVER["HTTP_HOST"], 'dirty.') || strstr($_SERVER["HTTP_HOST"], 'clean.') ) {
		require_once(SITE.'development.settings.php');
	} else {
		require_once(SITE.'production.settings.php');
	}
}

include('constants.php');
?>