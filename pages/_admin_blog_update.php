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
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$blog_active = isset($_GET['blog_active']) ? $_GET['blog_active'] : $_POST['blog_active'];
	$blog_text_id = isset($_GET['blog_text_id']) ? $_GET['blog_text_id'] : $_POST['blog_text_id'];
	$blog_text_lang = isset($_GET['blog_text_lang']) ? $_GET['blog_text_lang'] : $_POST['blog_text_lang'];
	$blog_text_title = isset($_GET['blog_text_title']) ? $_GET['blog_text_title'] : $_POST['blog_text_title'];
	$blog_text_value = isset($_GET['blog_text_value']) ? $_GET['blog_text_value'] : $_POST['blog_text_value'];
	$blog_text_value = urldecode($blog_text_value);
	
	try {
		Util::BlogDeletePage($id);
		$result = $data->BlogUpdate($id,
								    $blog_active,
								    $blog_text_id,
								    $blog_text_lang,
								    $blog_text_title, 
								    $blog_text_value);
			
		$data->AdminSaveLog('BLOG_UPDATED', 'ID : '.$result);
		Util::BlogAddOrUpdatePage($id);
		echo BLOG_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







