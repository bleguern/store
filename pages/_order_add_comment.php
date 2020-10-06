<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$data = new Data();

	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$order_comment = isset($_GET['order_comment']) ? $_GET['order_comment'] : $_POST['order_comment'];
	
	try {
		$result = $data->OrderCommentAdd($id, $order_comment);
		
		$data->AdminSaveLog('ORDER_COMMENT_ADDED', 'ID : '.$result);
		echo ORDER_COMMENT_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







