<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_menu')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	
	try {
		$result = $data->AdminMenuDelete($id);
			
		$data->AdminSaveLog('ADMIN_MENU_DELETED', 'ID : '.$result);
		echo ADMIN_MENU_DELETED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







