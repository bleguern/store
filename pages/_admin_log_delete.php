<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_log')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$log_delete_start_date = isset($_GET['log_delete_start_date']) ? $_GET['log_delete_start_date'] : $_POST['log_delete_start_date'];
	$log_delete_end_date = isset($_GET['log_delete_end_date']) ? $_GET['log_delete_end_date'] : $_POST['log_delete_end_date'];
	
	try {
		$result = $data->AdminLogDelete($log_delete_start_date, 
				              			$log_delete_end_date);
			
		$data->AdminSaveLog('ADMIN_LOG_DELETED', 'ID : '.$result);
		echo ADMIN_LOG_DELETED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







