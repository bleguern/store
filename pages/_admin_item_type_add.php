<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_item_type')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$item_type_name = isset($_GET['item_type_name']) ? $_GET['item_type_name'] : $_POST['item_type_name'];
	
	try {
		$result = $data->ItemTypeAdd($item_type_name);
		
		$data->AdminSaveLog('ITEM_TYPE_ADDED', 'ID : '.$result);
		echo ITEM_TYPE_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







