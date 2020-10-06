<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_access')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$access_url = isset($_GET['access_url']) ? $_GET['access_url'] : $_POST['access_url'];
	$access_description = isset($_GET['access_description']) ? $_GET['access_description'] : $_POST['access_description'];
	
	try {
		$result = $data->AdminAccessUpdate($id,
									       $access_url, 
							               $access_description);
			
		$data->AdminSaveLog('ADMIN_ACCESS_UPDATED', 'ID : '.$result);
		echo ADMIN_ACCESS_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







