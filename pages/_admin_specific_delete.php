<?php  
/* V1.0 : 20131126 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	// Param
	$table_name = '';
	// End param
	
	// Param init
	$table_name = isset($_GET['specific_table']) ? $_GET['specific_table'] : $_POST['specific_table'];
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	// End param init
	
	if ($table_name == '') {
		header('Location: error.php?message='.ADMIN_MISSING_SPECIFIC_TABLE);
		exit();
	}
	
	if(!Util::IsAllowed('admin_'.$table_name)) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}

	$data = new Data();
	
	try {
		$result = $data->AdminSpecificDelete($id,
							      			 $table_name);
		
	    $data->AdminSaveLog('ADMIN_'.strtoupper($table_name).'_DELETED', 'ID : '.$result);
		echo constant('ADMIN_'.strtoupper($table_name).'_DELETED');
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>


