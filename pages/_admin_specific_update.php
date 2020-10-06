<?php  
/* V1.0 : 20131126 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	// Param
	$table_name = '';
	$hidden_field = '';
	// End param
	
	// Param init
	$table_name = isset($_GET['specific_table']) ? $_GET['specific_table'] : $_POST['specific_table'];
	$hidden_field = isset($_GET['hidden_field']) ? $_GET['hidden_field'] : $_POST['hidden_field'];
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
	$table = $data->AdminGetTableFields($table_name);
	$values = Array();
	$i = 0;
	
	foreach ($table as $field) {
		if (strpos($field['Type'], '(')) {
			preg_match('/(\w+)\((\d+)\)/', $field['Type'], $type);
		} else {
			$type[0] = $field['Type'];
			$type[1] = $field['Type'];
			$type[2] = 8;
		}
			
		$value = Array();
		
		$value[0] = $field['Field'];
		$value[1] = '';
		$value[2] = $type[1];
		$value[3] = $type[2];
		
		if ($field['Key'] == 'PRI') {
			$value[1] = 'NULL';
			$value[2] = 'constant';
			$value[3] = '';
		} else if (strtolower($field['Field']) == $table_name.'_creation_date') {
			$value[1] = 'NOW()';
			$value[2] = 'constant';
			$value[3] = '';
		} else if (strtolower($field['Field']) == $table_name.'_last_update_date') {
			$value[1] = 'NOW()';
			$value[2] = 'constant';
			$value[3] = '';
		} else if (strtolower($field['Field']) == $table_name.'_last_update_admin_user_id') {
			$admin_user_id = NULL;
						
			if (isset($_SESSION[SITE_ID]['user_id'])) {
				$admin_user_id = $_SESSION[SITE_ID]['user_id'];
			} else {
				$admin_user_id = 0;
			}
			
			$value[1] = $admin_user_id;
			$value[2] = 'constant';
			$value[3] = '';
		} else if (strtolower($field['Field']) == $hidden_field) {
			$value[1] = isset($_GET[$field['Field']]) ? $_GET[$field['Field']] : $_POST[$field['Field']];
		} else {
			if (strpos(strtolower($field['Field']), '_id') !== FALSE) {
				$field_name = substr($field['Field'], strlen($table_name.'_'));
				$field_name = substr($field_name, 0, strpos($field_name, '_id'));
				
				// NOT USED AT THIS TIME, WHY?
				$selected = $field['Default'];
				
				$value[1] = isset($_GET[$field_name]) ? $_GET[$field_name] : $_POST[$field_name];
			} else {
				$value[1] = isset($_GET[$field['Field']]) ? $_GET[$field['Field']] : $_POST[$field['Field']];
			}		
		}
		
		$values[$i] = $value;
			
		$i++;
	}
	
	try {
		$result = $data->AdminSpecificUpdate($id,
							      			 $table_name,
							      			 $values);
							      			 
	    $data->AdminSaveLog('ADMIN_'.strtoupper($table_name).'_UPDATED', 'ID : '.$result);
		echo constant('ADMIN_'.strtoupper($table_name).'_UPDATED');
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>


