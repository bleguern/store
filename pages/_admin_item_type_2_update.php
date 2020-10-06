<?php  
/* V1.0 : 20131007 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_item_type_2')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$item_type_2_name = isset($_GET['item_type_2_name']) ? $_GET['item_type_2_name'] : $_POST['item_type_2_name'];
	
	try {
		$result = $data->ItemType2Update($id,
						      			 $item_type_2_name);
			
		$data->AdminSaveLog('ITEM_TYPE_2_UPDATED', 'ID : '.$result);
		echo ITEM_TYPE_2_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







