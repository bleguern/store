<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_role')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$admin_role_id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$admin_access_id = isset($_GET['admin_role_access']) ? $_GET['admin_role_access'] : $_POST['admin_role_access'];
	
	try {
		$result = $data->AdminRoleAccessAdd($admin_role_id, $admin_access_id);
		
		$data->AdminSaveLog('ADMIN_ROLE_ACCESS_ADDED', 'ID : '.$result);
		echo ADMIN_ROLE_ACCESS_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>






