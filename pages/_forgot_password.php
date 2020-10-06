<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$data = new Data();
	
	$email = isset($_GET['email']) ? $_GET['email'] : $_POST['email'];
	
	try {
		$result = $data->AdminUserResetPassword($email);
	    $data->AdminSaveLog('PASSWORD_RESETED', 'Email : '.$email);
		echo PASSWORD_RESETED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>


