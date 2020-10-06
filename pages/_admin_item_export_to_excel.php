<?php  
/* V1.0
 * 
 */
	$root = dirname(__FILE__)."/../";
	include_once($root.'./library/util.php');
	include_once($root.'./library/data.php');
	
	session_cache_limiter("must-revalidate");
	header("Content-type: application/vnd.ms-excel; charset=utf-8");
	header("Content-disposition: attachment; filename=item_list.xls");
	header("Content-Transfer-Encoding: binary");
	
	if(!Util::IsAllowed('admin_item')) {
		header('Location: '.BASE_LINK.'/pages/not_allowed.php');
		exit();
	}
	
	try
	{
		$data = new Data();
		$dataSpecific = new DataSpecific();
		$item_list = $dataSpecific->ItemGetList();
		
		echo '<TABLE>';
		echo '<TR>';
		echo '<TH>item_id</TH>';
		echo '<TH>item_item_type_id</TH>';
		echo '<TH>item_item_type_2_id</TH>';
		echo '<TH>item_type_name</TH>';
		echo '<TH>item_type_2_name</TH>';
		echo '<TH>item_active</TH>';
		echo '<TH>item_name</TH>';
		echo '<TH>item_hit</TH>';
		echo '<TH>item_last_update_date</TH>';
		echo '<TH>admin_user_login</TH>';
		echo '<TH>item_specific_price</TH>';
		echo '<TH>item_specific_weight</TH>';
		echo '<TH>item_specific_item_specific_brand_id</TH>';
		echo '<TH>item_specific_brand_name</TH>';
		echo '</TR>';
		
		
		for($i = 0; $i < count($item_list); $i++) {
			echo '<TR>';
			
			for($j = 0; $j < count($item_list[$i]); $j++) {
				
				echo '<TD>'.$item_list[$i][$j].'</TD>';
			}
			
			echo '</TR>';
		}
		
		echo '</TABLE>';
	} catch (Exception $ex) {
		$_SESSION[SITE_ID]['error'] = ADMIN_ITEM_EXCEL_ERROR;
	}
?>







