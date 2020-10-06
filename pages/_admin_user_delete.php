<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_user')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	
	try {
		$result = $data->AdminUserDelete($id);
		
		$data->AdminSaveLog('ADMIN_USER_DELETED', 'ID : '.$result);
		echo ADMIN_USER_DELETED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







