<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('account_update')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$id = $_SESSION[SITE_ID]['user_id'];
	$admin_user_old_password = isset($_GET['admin_user_old_password']) ? $_GET['admin_user_old_password'] : $_POST['admin_user_old_password'];
	$admin_user_password = isset($_GET['admin_user_password']) ? $_GET['admin_user_password'] : $_POST['admin_user_password'];
	$admin_user_email = isset($_GET['admin_user_email']) ? $_GET['admin_user_email'] : $_POST['admin_user_email'];
	$admin_user_first_name = isset($_GET['admin_user_first_name']) ? $_GET['admin_user_first_name'] : $_POST['admin_user_first_name'];
	$admin_user_last_name = isset($_GET['admin_user_last_name']) ? $_GET['admin_user_last_name'] : $_POST['admin_user_last_name'];
	$admin_user_phone = isset($_GET['admin_user_phone']) ? $_GET['admin_user_phone'] : $_POST['admin_user_phone'];
	$admin_user_lang = isset($_GET['admin_user_lang']) ? $_GET['admin_user_lang'] : $_POST['admin_user_lang'];
	$admin_user_admin_site_theme = isset($_GET['admin_user_admin_site_theme']) ? $_GET['admin_user_admin_site_theme'] : $_POST['admin_user_admin_site_theme'];
	$admin_user_address_line_1 = isset($_GET['admin_user_address_line_1']) ? $_GET['admin_user_address_line_1'] : $_POST['admin_user_address_line_1'];
	$admin_user_address_line_2 = isset($_GET['admin_user_address_line_2']) ? $_GET['admin_user_address_line_2'] : $_POST['admin_user_address_line_2'];
	$admin_user_address_line_3 = isset($_GET['admin_user_address_line_3']) ? $_GET['admin_user_address_line_3'] : $_POST['admin_user_address_line_3'];
	$admin_user_address_postal_code = isset($_GET['admin_user_address_postal_code']) ? $_GET['admin_user_address_postal_code'] : $_POST['admin_user_address_postal_code'];
	$admin_user_address_city = isset($_GET['admin_user_address_city']) ? $_GET['admin_user_address_city'] : $_POST['admin_user_address_city'];
	$admin_user_address_region = isset($_GET['admin_user_address_region']) ? $_GET['admin_user_address_region'] : $_POST['admin_user_address_region'];
	$admin_user_address_country = isset($_GET['admin_user_address_country']) ? $_GET['admin_user_address_country'] : $_POST['admin_user_address_country'];
	
	try {
		$result = $data->AccountUpdate($id,
								 	   $admin_user_old_password,
							     	   $admin_user_password,
							           $admin_user_email,
							           $admin_user_first_name,
							           $admin_user_last_name,
							           $admin_user_phone,
							           $admin_user_lang,
							           $admin_user_admin_site_theme,
							           $admin_user_address_line_1,
							           $admin_user_address_line_2,
							           $admin_user_address_line_3,
							           $admin_user_address_postal_code,
							           $admin_user_address_city,
							           $admin_user_address_region,
							           $admin_user_address_country);
		
	    $data->AdminSaveLog('ADMIN_USER_ACCOUNT_UPDATED', 'ID : '.$result);   
		echo ADMIN_USER_ACCOUNT_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>


