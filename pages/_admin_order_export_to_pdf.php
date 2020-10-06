<?php  
/* V1.0
 * 
 */
	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	include_once($root.'./library/pdf.php');
	
	if(!Util::IsAllowed('admin_order')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	if (isset($_SESSION['script']) && ($_SESSION['script'] != '')) {
		print_pdf('TEST', 
		          'subject', 
		          'author', 
		          'header', 
			      'data', 
		          'keyword',
		          $_SESSION['script'],
		          $_SESSION[SITE_ID]['admin_configuration_theme'].'.css',
		          '12');
	}
?>







