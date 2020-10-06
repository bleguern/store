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
		$data->LinksActivate($id);
		header('Location: admin_links.php');
		exit();
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
	
?>