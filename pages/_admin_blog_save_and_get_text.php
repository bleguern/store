<?php  
/* V1.0 : 20121115 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_blog')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$blog_id = isset($_GET['blog_id']) ? $_GET['blog_id'] : $_POST['blog_id'];
	$blog_text_id = isset($_GET['blog_text_id']) ? $_GET['blog_text_id'] : $_POST['blog_text_id'];
	$blog_text_lang = isset($_GET['blog_text_lang']) ? $_GET['blog_text_lang'] : $_POST['blog_text_lang'];
	$blog_text_lang_new_value = isset($_GET['blog_text_lang_new_value']) ? $_GET['blog_text_lang_new_value'] : $_POST['blog_text_lang_new_value'];
	$blog_text_title = isset($_GET['blog_text_title']) ? $_GET['blog_text_title'] : $_POST['blog_text_title'];
	$blog_text_value = isset($_GET['blog_text_value']) ? $_GET['blog_text_value'] : $_POST['blog_text_value'];

	try {
		if ($blog_text_value != '') {
			if ($blog_text_id == '') {
				$data->BlogAddText($blog_id, $blog_text_lang, $blog_text_title, $blog_text_value);
			} else {
				$data->BlogUpdateText($blog_text_id, $blog_text_title, $blog_text_value);
			}
		} else {
			$data->BlogDeleteText($blog_text_id);
		}
		
		$result = $data->BlogGetText($blog_id, $blog_text_lang_new_value);
		
		if (count($result) == 4) {
			echo $result[0].'#'.$result[1].'#'.$result[2].'#'.$result[3];
		} else {
			echo '';
		}
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}	
?>