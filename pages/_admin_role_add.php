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
	
	$admin_role_name = isset($_GET['admin_role_name']) ? $_GET['admin_role_name'] : $_POST['admin_role_name'];
	
	try {
		$result = $data->AdminRoleAdd($admin_role_name);
		
		$data->AdminSaveLog('ADMIN_ROLE_ADDED', 'ID : '.$result);
		echo ADMIN_ROLE_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







