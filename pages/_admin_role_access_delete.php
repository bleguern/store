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
	
	$admin_role_id = isset($_GET['admin_role_id']) ? $_GET['admin_role_id'] : $_POST['admin_role_id'];
	$admin_role_access_id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	
	try {
		$result = $data->AdminRoleAccessDelete($admin_role_access_id);
		
		$data->AdminSaveLog('ADMIN_ROLE_ACCESS_DELETED', 'ID : '.$result);
		header('Location: admin_role_update.php?id='.$admin_role_id.'&message2='.ADMIN_ROLE_ACCESS_DELETED);
		exit();
	} catch (DataException $ex) {
		header('Location: admin_role_update.php?id='.$admin_role_id.'&message2='.$ex->getMessage());
		exit();
	}
?>







