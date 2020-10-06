<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (!isset($_SESSION[SITE_ID]['connection_id'])) {
		Util::Init();
	}
	
	if(!Util::IsAllowed('admin')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}

	phpinfo();

	Util::AdminFixPages();
	Util::AdminGenerateSiteMap();
?>