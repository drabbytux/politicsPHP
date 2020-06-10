<?php
/**
 * Site Initiation
 * A global file to initialize include paths
 * Retrieves Server specific settings and calls the creation of standard classes
 */
ini_set('include_path', ini_get('include_path'). ':'. $_SERVER['DOCUMENT_ROOT'] . '/_master/' );
require_once('configs/config.php');
include_once('includes/public.code.init.php');

?>
