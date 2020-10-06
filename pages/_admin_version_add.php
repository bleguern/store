<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_version')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$admin_version_date = isset($_GET['admin_version_date']) ? $_GET['admin_version_date'] : $_POST['admin_version_date'];
	$admin_version_number = isset($_GET['admin_version_number']) ? $_GET['admin_version_number'] : $_POST['admin_version_number'];
	$admin_version_name = isset($_GET['admin_version_name']) ? $_GET['admin_version_name'] : $_POST['admin_version_name'];
	$admin_version_description = isset($_GET['admin_version_description']) ? $_GET['admin_version_description'] : $_POST['admin_version_description'];
	
	try {
		$result = $data->AdminVersionAdd($admin_version_date,
										 $admin_version_number, 
										 $admin_version_name,
				 						 $admin_version_description);
		
		$data->AdminSaveLog('ADMIN_VERSION_ADDED', 'ID : '.$result);
		echo ADMIN_VERSION_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







