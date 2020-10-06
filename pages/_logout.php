<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$data = new Data();
	
	try {
		Util::Logout();
		echo LOGIN_DISCONNECTED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







