<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if (isset($_SESSION[SITE_ID]['authenticated'])) {
		$order_delivery_type = Util::GetPostValue('order_delivery_type');
	
		if($order_delivery_type == '') {
			header('Location: basket.php');
			exit();
		}
		
		try {
			$data = new Data();
		
			$result = $data->BasketCreateOrder($order_delivery_type);
			$data->AdminSaveLog('ORDER_CREATED', 'ID : '.$result);
			header('Location: order.php?message='.ORDER_CREATED.'&id='.$result);
			exit();
		} catch (DataException $ex) {
			header('Location: basket.php?message='.$ex->getMessage());
			exit();
		}
	} else {
		header('Location: login.php?message='.PLEASE_CONNECT_BEFORE_CREATE_ORDER.'&gotourl=_basket_go_to_order.php');
		exit();
	}
?>







