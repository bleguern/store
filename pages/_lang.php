<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$lang = isset($_GET['lang']) ? $_GET['lang'] : $_POST['lang'];
	
	if ($lang) {
		switch($lang)
		{
			case "de":
				include_once('locale_de.php');
				$_SESSION[SITE_ID]['lang'] = 'de';
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
				include_once('locale_en.php');
				$_SESSION[SITE_ID]['lang'] = 'en';
			break;
		}
		
		header('Location: index.php');
		exit();
	} else {
		header('Location: index.php?message='.MISSING_ARGUMENT_ERROR);
		exit();
	}
?>







