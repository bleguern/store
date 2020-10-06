<?php  
/* V1.0 : 20130524 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_links')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	
	try {
		$result = $data->LinksDelete($id);
			
		$data->AdminSaveLog('LINKS_DELETED', 'ID : '.$result);
		echo LINKS_DELETED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







