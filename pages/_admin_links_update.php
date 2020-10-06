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
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$links_active = isset($_GET['links_active']) ? $_GET['links_active'] : $_POST['links_active'];
	$links_link = isset($_GET['links_link']) ? $_GET['links_link'] : $_POST['links_link'];
	$links_link = urldecode($links_link);
	$links_title = isset($_GET['links_title']) ? $_GET['links_title'] : $_POST['links_title'];
	$links_text_id = isset($_GET['links_text_id']) ? $_GET['links_text_id'] : $_POST['links_text_id'];
	$links_text_lang = isset($_GET['links_text_lang']) ? $_GET['links_text_lang'] : $_POST['links_text_lang'];
	$links_text_value = isset($_GET['links_text_value']) ? $_GET['links_text_value'] : $_POST['links_text_value'];
	$links_text_value = urldecode($links_text_value);
	$image_id = isset($_GET['image_id']) ? $_GET['image_id'] : $_POST['image_id'];
	
	try {
		$result = $data->LinksUpdate($id,
								     $links_active,
								     $links_link, 
								     $links_title, 
								     $links_text_id,
								     $links_text_lang,
								     $links_text_value,
								     $image_id);
			
		$data->AdminSaveLog('LINKS_UPDATED', 'ID : '.$result);
		echo LINKS_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







