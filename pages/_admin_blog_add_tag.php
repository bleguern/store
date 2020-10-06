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
	$tag_value = isset($_GET['tag_value']) ? $_GET['tag_value'] : $_POST['tag_value'];
	
	try {
		$result = $data->BlogAddTag($id, $tag_value);
		
		$data->AdminSaveLog('ADMIN_BLOG_TAG_ADDED', 'ID : '.$result);
		echo ADMIN_BLOG_TAG_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







