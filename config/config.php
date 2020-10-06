<?php 
/* V1.2
 * 
 * V1.1 : 20131015 : Like box update
 * V1.1 : 20140127 : Store mode...
 * 
 */

session_start();


/*
 * BASIS
*/
// Root directory
define ('ROOT_DIRECTORY', dirname(__FILE__).'/..');
// Page location & properties
define ('ITEM_DIRECTORY', ROOT_DIRECTORY.'/item/');
define ('BLOG_DIRECTORY', ROOT_DIRECTORY.'/blog/');
define ('PAGE_EXTENSION', '.php');
// Log & error directories
define ('ERROR_DIRECTORY', ROOT_DIRECTORY.'/error/');
define ('LOG_DIRECTORY', ROOT_DIRECTORY.'/log/');
// Image directories
define ('IMAGE_FULL', '/images/data/full/');
define ('IMAGE_FULL_DIRECTORY', ROOT_DIRECTORY.IMAGE_FULL);
define ('IMAGE_MEDIUM', '/images/data/medium/');
define ('IMAGE_MEDIUM_DIRECTORY', ROOT_DIRECTORY.IMAGE_MEDIUM);
define ('IMAGE_LITLLE', '/images/data/little/');
define ('IMAGE_LITLLE_DIRECTORY', ROOT_DIRECTORY.IMAGE_LITLLE);

// Specific part
$root = dirname(__FILE__)."/../";
include_once($root.'./config/config_specific.php');

// Language
if (isset($_REQUEST['lang'])) {
	switch($_REQUEST['lang']) {
		case "de":
			$_SESSION[SITE_ID]['lang'] = 'de';
			break;
		case "en":
			$_SESSION[SITE_ID]['lang'] = 'en';
			break;
		case "es":
			$_SESSION[SITE_ID]['lang'] = 'es';
			break;
		case "fr":
			$_SESSION[SITE_ID]['lang'] = 'fr';
			break;
		default:
			$_SESSION[SITE_ID]['lang'] = 'fr';
			break;
		break;
	}
}

// Language
if (isset($_SESSION[SITE_ID]['lang']))
{
	switch($_SESSION[SITE_ID]['lang'])
	{
		case "de":
			include_once('locale_de.php');
			break;
		case "en":
			include_once('locale_en.php');
			break;
		case "es":
			include_once('locale_es.php');
			break;
		case "fr":
			include_once('locale_fr.php');
			break;
		default:
			include_once('locale_fr.php');
			$_SESSION[SITE_ID]['lang'] = 'fr';
		break;
	}
} else {
	$browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	
	switch($browser_lang)
	{
		case "de":
			include_once('locale_de.php');
			$_SESSION[SITE_ID]['lang'] = 'de';
			break;
		case "en":
			include_once('locale_en.php');
			$_SESSION[SITE_ID]['lang'] = 'en';
			break;
		case "es":
			include_once('locale_es.php');
			$_SESSION[SITE_ID]['lang'] = 'es';
			break;
		case "fr":
			include_once('locale_fr.php');
			$_SESSION[SITE_ID]['lang'] = 'fr';
			break;
		default:
			include_once('locale_fr.php');
			$_SESSION[SITE_ID]['lang'] = 'fr';
		break;
	}
}

define ('BASE_LINK', SITE_HTTP.SITE_NAME);
define ('BLOG_LINK', BASE_LINK.'/blog/');
define ('ITEM_LINK', BASE_LINK.'/item/');
define ('ITEM_MENU_LINK', '../item/');
define ('BLOG_QUICK_LINK', BASE_LINK.'/blog/');
define ('ITEM_QUICK_LINK', BASE_LINK.'/item/');
define ('IMAGE_MEDIUM_LINK', BASE_LINK.IMAGE_MEDIUM);
define ('IMAGE_FULL_LINK', BASE_LINK.IMAGE_FULL);
define ('IMAGE_LITTLE_LINK', BASE_LINK.IMAGE_LITLLE);
?>