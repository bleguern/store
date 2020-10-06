<?php  
/* V1.2
 * 
 * V1.1 : 20131004 : Style added
 * V1.2 : 20131015 : Item type 2 added
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_menu')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	
	$menu_name = isset($_GET['menu_name']) ? $_GET['menu_name'] : $_POST['menu_name'];
	$menu_access = isset($_GET['menu_access']) ? $_GET['menu_access'] : $_POST['menu_access'];
	$menu_link = isset($_GET['menu_link']) ? $_GET['menu_link'] : $_POST['menu_link'];
	$menu_target = isset($_GET['menu_target']) ? $_GET['menu_target'] : $_POST['menu_target'];
	$menu_level_0 = isset($_GET['menu_level_0']) ? $_GET['menu_level_0'] : $_POST['menu_level_0'];
	$menu_level_1 = isset($_GET['menu_level_1']) ? $_GET['menu_level_1'] : $_POST['menu_level_1'];
	$menu_style = isset($_GET['menu_style']) ? $_GET['menu_style'] : $_POST['menu_style'];
	$menu_item_type = isset($_GET['menu_item_type']) ? $_GET['menu_item_type'] : $_POST['menu_item_type'];
	$menu_item_type_2 = isset($_GET['menu_item_type_2']) ? $_GET['menu_item_type_2'] : $_POST['menu_item_type_2'];
	$menu_image = isset($_GET['menu_image']) ? $_GET['menu_image'] : $_POST['menu_image'];
	
	try {
		$result = $data->AdminMenuAdd($menu_name, 
									  $menu_access,
									  $menu_link,
				                      $menu_target,
									  $menu_level_0,
									  $menu_level_1,
									  $menu_style,
									  $menu_item_type,
									  $menu_item_type_2,
									  $menu_image);
		
		$data->AdminSaveLog('ADMIN_MENU_ADDED', 'ID : '.$result);
		echo ADMIN_MENU_ADDED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







