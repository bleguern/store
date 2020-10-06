<?php  
/* V1.2
 * 
 * V1.1 : 20131008 : Type 2 added
 * V1.2 : 20131015 : Item specific price added
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	if(!Util::IsAllowed('admin_item')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	$data = new Data();
	$dataSpecific = new DataSpecific();
	
	$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
	$item_type = isset($_GET['item_type']) ? $_GET['item_type'] : $_POST['item_type'];
	$item_type_2 = isset($_GET['item_type_2']) ? $_GET['item_type_2'] : $_POST['item_type_2'];
	$item_active = isset($_GET['item_active']) ? $_GET['item_active'] : $_POST['item_active'];
	$item_name = isset($_GET['item_name']) ? $_GET['item_name'] : $_POST['item_name'];
/////// SPECIFIC PART
	$item_specific_price = isset($_GET['item_specific_price']) ? $_GET['item_specific_price'] : $_POST['item_specific_price'];
	$item_specific_weight = isset($_GET['item_specific_weight']) ? $_GET['item_specific_weight'] : $_POST['item_specific_weight'];
	$item_specific_admin_currency = isset($_GET['item_specific_admin_currency']) ? $_GET['item_specific_admin_currency'] : $_POST['item_specific_admin_currency'];
	$store_inventory_count = isset($_GET['store_inventory_count']) ? $_GET['store_inventory_count'] : $_POST['store_inventory_count'];
	$item_specific_brand_id = isset($_GET['item_specific_brand']) ? $_GET['item_specific_brand'] : $_POST['item_specific_brand'];
	$item_specific_brand_text = isset($_GET['item_specific_brand_text']) ? $_GET['item_specific_brand_text'] : $_POST['item_specific_brand_text'];
/////// END OF SPECIFIC PART
	$item_text_id = isset($_GET['item_text_id']) ? $_GET['item_text_id'] : $_POST['item_text_id'];
	$item_text_lang = isset($_GET['item_text_lang']) ? $_GET['item_text_lang'] : $_POST['item_text_lang'];
	$item_text_value = isset($_GET['item_text_value']) ? $_GET['item_text_value'] : $_POST['item_text_value'];
	$item_text_value = urldecode($item_text_value);
	
	try {
		Util::ItemDeletePage($id);
		$result = $dataSpecific->ItemUpdate($id,
										    $item_type,
										    $item_type_2,
										    $item_active,
										    $item_name,
										    $item_specific_price,                        /* SPECIFIC PART */
										    $item_specific_admin_currency,				 /* SPECIFIC PART */
										    $store_inventory_count,				         /* SPECIFIC PART */
										    $item_specific_weight,           /* SPECIFIC PART */
									        $item_specific_brand_id,           /* SPECIFIC PART */
									        $item_specific_brand_text,           /* SPECIFIC PART */
									        $item_text_id,
										    $item_text_lang,
										    $item_text_value);           
			
		$data->AdminSaveLog('ITEM_UPDATED', 'ID : '.$result);
		Util::ItemAddOrUpdatePage($id);
		echo ITEM_UPDATED;
	} catch (DataException $ex) {
		echo $ex->getMessage();
	}
?>







