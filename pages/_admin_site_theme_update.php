<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_site_theme')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$site_theme_code = isset($_GET['site_theme_code']) ? $_GET['site_theme_code'] : $_POST['site_theme_code'];
	$site_theme_name = isset($_GET['site_theme_name']) ? $_GET['site_theme_name'] : $_POST['site_theme_name'];
	
	try {
		$result = $data->AdminSiteThemeUpdate($id,
							      			  $site_theme_code,
							      			  $site_theme_name);
			
		$data->AdminSaveLog('ADMIN_SITE_THEME_UPDATED', 'ID : '.$result);
		echo ADMIN_SITE_THEME_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







