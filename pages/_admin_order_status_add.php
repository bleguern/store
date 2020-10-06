<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_order_status')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$order_status_name = Util::GetPostValue('order_status_name');
	$order_status_active = Util::GetPostValue('order_status_active');
	$order_status_inventory_reserve = Util::GetPostValue('order_status_inventory_reserve');
	$order_status_inventory_cleanup = Util::GetPostValue('order_status_inventory_cleanup');
	$order_status_lock = Util::GetPostValue('order_status_lock');
	$order_status_other_possible_status = Util::GetPostValue('order_status_other_possible_status');
	
	try {
		$result = $data->AdminOrderStatusAdd($order_status_name, 
										     $order_status_active, 
										     $order_status_inventory_reserve, 
										     $order_status_inventory_cleanup, 
										     $order_status_lock, 
										     $order_status_other_possible_status);
		
		$data->AdminSaveLog('ADMIN_ORDER_STATUS_ADDED', 'ID : '.$result);
		echo ADMIN_ORDER_STATUS_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







