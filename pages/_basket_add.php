<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$data = new Data();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	
	try {
		$result = $data->BasketAdd($id);
		
		$data->AdminSaveLog('BASKET_ADDED', 'ID : '.$result);
		echo BASKET_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







