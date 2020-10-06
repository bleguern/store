<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$data = new Data();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	
	try {
		$result = $data->BasketDeleteFromItem($id);
		
		$data->AdminSaveLog('BASKET_DELETED', 'ID : '.$result);
		header('Location: basket.php?message='.BASKET_DELETED);
		exit();
	} catch (DataException $ex) {
		header('Location: basket.php?message='.$ex->getMessage());
		exit();
	}
?>







