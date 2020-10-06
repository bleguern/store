<?php  
/* V1.0 : 20130524 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_links')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$links_id = isset($_GET['links_id']) ? $_GET['links_id'] : $_POST['links_id'];
	$links_text_id = isset($_GET['links_text_id']) ? $_GET['links_text_id'] : $_POST['links_text_id'];
	$links_text_lang = isset($_GET['links_text_lang']) ? $_GET['links_text_lang'] : $_POST['links_text_lang'];
	$links_text_lang_new_value = isset($_GET['links_text_lang_new_value']) ? $_GET['links_text_lang_new_value'] : $_POST['links_text_lang_new_value'];
	$links_text_value = isset($_GET['links_text_value']) ? $_GET['links_text_value'] : $_POST['links_text_value'];

	try {
		if ($links_text_value != '') {
			if ($links_text_id == '') {
				$data->LinksAddText($links_id, $links_text_lang, $links_text_value);
			} else {
				$data->LinksUpdateText($links_text_id, $links_text_value);
			}
		} else {
			$data->LinksDeleteText($links_text_id);
		}
		
		$result = $data->LinksGetText($links_id, $links_text_lang_new_value);
		
		if (count($result) == 3) {
			echo $result[0].'#'.$result[1].'#'.$result[2];
		} else {
			echo '';
		}
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}	
?>