<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$data = new Data();
	
	try {
		$result = $data->BasketEmpty();
		
		$data->AdminSaveLog('BASKET_EMPTIED', 'ID : '.$result);
		echo BASKET_EMPTIED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







