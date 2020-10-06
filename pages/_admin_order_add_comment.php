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
	$order_comment = isset($_GET['order_comment']) ? $_GET['order_comment'] : $_POST['order_comment'];
	
	try {
		$result = $data->AdminOrderCommentAdd($id, $order_comment);
		
		$data->AdminSaveLog('ADMIN_ORDER_COMMENT_ADDED', 'ID : '.$result);
		echo ADMIN_ORDER_COMMENT_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







