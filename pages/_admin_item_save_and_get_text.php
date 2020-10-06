<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_item')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$item_id = isset($_GET['item_id']) ? $_GET['item_id'] : $_POST['item_id'];
	$item_text_id = isset($_GET['item_text_id']) ? $_GET['item_text_id'] : $_POST['item_text_id'];
	$item_text_lang = isset($_GET['item_text_lang']) ? $_GET['item_text_lang'] : $_POST['item_text_lang'];
	$item_text_lang_new_value = isset($_GET['item_text_lang_new_value']) ? $_GET['item_text_lang_new_value'] : $_POST['item_text_lang_new_value'];
	$item_text_value = isset($_GET['item_text_value']) ? $_GET['item_text_value'] : $_POST['item_text_value'];
	$item_text_value = urldecode($item_text_value);
	
	try {
		if ($item_text_value != '') {
			if ($item_text_id == '') {
				$data->ItemAddText($item_id, $item_text_lang, $item_text_value);
			} else {
				$data->ItemUpdateText($item_text_id, $item_text_value);
			}
		} else {
			$data->ItemDeleteText($item_text_id);
		}
		
		$result = $data->ItemGetText($item_id, $item_text_lang_new_value);
		
		if (count($result) == 3) {
			echo $result[0].'#'.$result[1].'#'.$result[2];
		} else {
			echo '';
		}
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
	
?>