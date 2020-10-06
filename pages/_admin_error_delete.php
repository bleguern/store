<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_error')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$error_delete_start_date = isset($_GET['error_delete_start_date']) ? $_GET['error_delete_start_date'] : $_POST['error_delete_start_date'];
	$error_delete_end_date = isset($_GET['error_delete_end_date']) ? $_GET['error_delete_end_date'] : $_POST['error_delete_end_date'];
	
	try {
		$result = $data->AdminErrorDelete($error_delete_start_date, 
				                		  $error_delete_end_date);
		
		$data->AdminSaveLog('ADMIN_ERROR_DELETED', 'ID : '.$result);
		echo ADMIN_ERROR_DELETED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







