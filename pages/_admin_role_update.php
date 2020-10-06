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
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$admin_role_name = isset($_GET['admin_role_name']) ? $_GET['admin_role_name'] : $_POST['admin_role_name'];
	
	try {
		$result = $data->AdminRoleUpdate($id,
								    	 $admin_role_name);
			
		$data->AdminSaveLog('ADMIN_ROLE_UPDATED', 'ID : '.$result);
		echo ADMIN_ROLE_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







