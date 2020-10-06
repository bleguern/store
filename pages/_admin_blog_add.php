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
	
	$blog_active = isset($_GET['blog_active']) ? $_GET['blog_active'] : $_POST['blog_active'];
	$blog_text_lang = isset($_GET['blog_text_lang']) ? $_GET['blog_text_lang'] : $_POST['blog_text_lang'];
	$blog_text_title = isset($_GET['blog_text_title']) ? $_GET['blog_text_title'] : $_POST['blog_text_title'];
	$blog_text_value = isset($_GET['blog_text_value']) ? $_GET['blog_text_value'] : $_POST['blog_text_value'];
	$blog_text_value = urldecode($blog_text_value);
	$first_image_id = isset($_GET['first_image_id']) ? $_GET['first_image_id'] : $_POST['first_image_id'];
	$image_id = isset($_GET['image_id']) ? $_GET['image_id'] : $_POST['image_id'];
	$tag_list_value = isset($_GET['tag_list_value']) ? $_GET['tag_list_value'] : $_POST['tag_list_value'];
	
	try {
		$result = $data->BlogAdd($blog_active,
							     $blog_text_lang,
							     $blog_text_title,           
							     $blog_text_value,
							     $first_image_id,
							     $image_id,
								 $tag_list_value);
	      
	    $data->AdminSaveLog('BLOG_ADDED', 'ID : '.$result);
	    Util::BlogAddOrUpdatePage($result);
		echo BLOG_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







