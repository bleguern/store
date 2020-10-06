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

	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$order_discount = isset($_GET['order_discount']) ? $_GET['order_discount'] : $_POST['order_discount'];
	$order_status = isset($_GET['order_status']) ? $_GET['order_status'] : $_POST['order_status'];
	
	try {
		$result = $data->AdminOrderUpdate($id, 
										  $order_discount, 
										  $order_status);
		
		$data->AdminSaveLog('ADMIN_ORDER_UPDATED', 'ID : '.$result);
		echo ADMIN_ORDER_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







