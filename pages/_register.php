<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$data = new Data();
	
	$admin_user_password = isset($_GET['admin_user_password']) ? $_GET['admin_user_password'] : $_POST['admin_user_password'];
	$admin_user_email = isset($_GET['admin_user_email']) ? $_GET['admin_user_email'] : $_POST['admin_user_email'];
	$admin_user_lang = isset($_GET['admin_user_lang']) ? $_GET['admin_user_lang'] : $_POST['admin_user_lang'];
	$admin_user_admin_site_theme = isset($_GET['admin_user_admin_site_theme']) ? $_GET['admin_user_admin_site_theme'] : $_POST['admin_user_admin_site_theme'];
	
	try {
		$result = $data->AccountRegister($admin_user_email,	
										 $admin_user_password,
								    	 $admin_user_lang,
								    	 $admin_user_admin_site_theme);
	    
		$data->AdminSaveLog('ACCOUNT_REGISTERED', 'ID : '.$result);
	    Util::Login($admin_user_email, $admin_user_password, 'local');
		echo ACCOUNT_REGISTERED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>


