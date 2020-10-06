<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_order')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();

	$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : $_POST['order_id'];
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	
	try {
		$result = $data->AdminOrderDeleteLine($id);
		
		$data->AdminSaveLog('ADMIN_ORDER_LINE_DELETED', 'ID : '.$result);
		header('Location: admin_order_update.php?id='.$order_id.'&message='.ADMIN_ORDER_LINE_DELETED);
		exit();
	} catch (DataException $ex) {
		header('Location: admin_order_update.php?id='.$order_id.'&message='.$ex->getMessage());
		exit();
	}
?>







