<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	$data = new Data();
	
	$login_login = isset($_GET['login_login']) ? $_GET['login_login'] : $_POST['login_login'];
	$login_password = isset($_GET['login_password']) ? $_GET['login_password'] : $_POST['login_password'];
	
	try {
		Util::Login($login_login, $login_password, 'local');
		echo LOGIN_CONNECTED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







