<?php   
/* V1.6
 * 
 * V1.1 : 20130524 : Links
 * V1.2 : 20130528 : Links update
 * V1.3 : 20131004 : Menu style added
 * V1.4 : 20131007 : Item type 2 added
 * V1.5 : 20131015 : Item specific price added
 * V1.6 : 20140128 : Major design update
 * 
 */

	$root = dirname(__FILE__)."/../";
	include_once($root.'./config/config.php');
	
	include_once($root.'./library/mysql.php');
	include_once($root.'./library/pgsql.php');
	include_once($root.'./library/file.php');
	include_once($root.'./library/show.php');
	include_once($root.'./library/ipaddress.php');
	include_once($root.'./library/image.php');
	
class DataSpecificException extends Exception	
{
	public function __construct($message) {
		parent :: __construct($message);
	}

	public function getError() {
		return $this->getMessage();
	}
}

class DataSpecific
{
	private $dataType = DATABASE_TYPE;
	protected $database;
			
	public function __construct() {	
		switch ($this->dataType) {
			case "mysql" :
		   		$this->database = new MySql(); 
		   		break;
		   	case "pgsql" :
		   		// $this->database = new Pgsql(); // No yet
		   	 	break;
		   	default :
		   		$this->database = new MySql(); 
		   		break;
		}
	}

	public function __destruct() {
		
	}
	
	public function __call($method = '', $args = '') 
	{

		switch ($method) {
			

			///////////////////////////////////////////////////////////////////////
			//////////////       STANDARD WITH SPECIFIC PART      /////////////////
			///////////////////////////////////////////////////////////////////////
//////// 		SEARCH/TAG PART

		case 'AdminSaveError' : {
			if (isset($args[0]) &&
			isset($args[1])) {
					
				$name = $args[0];
				$description = $args[1];
					
				if ($_SESSION[SITE_ID]['admin_configuration_log_database'] || $_SESSION[SITE_ID]['admin_configuration_log_file'] || $_SESSION[SITE_ID]['admin_configuration_log_show']) {
					$admin_connection_id = NULL;
					$admin_user_id = NULL;
		
					if (isset($_SESSION[SITE_ID]['connection_id'])) {
						$admin_connection_id = $_SESSION[SITE_ID]['connection_id'];
					} else {
						$admin_connection_id = 0;
					}
		
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
		
					if ($_SESSION[SITE_ID]['admin_configuration_error_database']) {
						try {
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_error (admin_error_id, admin_error_date, admin_error_admin_connection_id, admin_error_admin_user_id, admin_error_url, admin_error_name, admin_error_description) ' .
									'VALUES ' .
									'(NULL, ' .
									'NOW(), ' .
									''.$this->database->FormatDataToInteger($admin_connection_id).', ' .
									''.$this->database->FormatDataToInteger($admin_user_id).', ' .
									''.$this->database->FormatDataToVarchar($_SERVER['PHP_SELF'], 200).', ' .
									''.$this->database->FormatDataToVarchar($name, 100).', ' .
									''.$this->database->FormatDataToVarchar($description, 400).');';
								
							$this->database->InsertQuery($sql_query);
						} catch (SqlException $ex) {
							if ($_SESSION[SITE_ID]['admin_configuration_error_file']) {
								$file = new File(ERROR_DIRECTORY.date('Ymd').'.err');
								$file->WriteLine(date('Ymd|h:i:s').'|url:'.$_SERVER['PHP_SELF'].'|'.$ex->getError());
							}
		
							if ($_SESSION[SITE_ID]['admin_configuration_error_show']) {
								$show = new Show();
								$show->SayLine($ex->getError());
							}
						}
					}
		
					if ($_SESSION[SITE_ID]['admin_configuration_error_file']) {
						$file = new File(ERROR_DIRECTORY.date('Ymd').'.err');
						$file->WriteLine(date('Ymd|h:i:s').'|url:'.$_SERVER['PHP_SELF'].'|name:'.$name.'|description:'.$description);
					}
		
					if ($_SESSION[SITE_ID]['admin_configuration_error_show']) {
						$show = new Show();
						$show->SayLine($name.'|'.$description);
					}
				}
			}
			break;
		}
			
		case 'ItemSearch' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                     //  0
										''.DATABASE_PREFIX.'item.item_item_type_id, ' .           //  1
										''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .         //  2
										''.DATABASE_PREFIX.'item_type.item_type_name, ' .         //  3
										''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .     //  4
										''.DATABASE_PREFIX.'item.item_active, ' .                 //  5
										''.DATABASE_PREFIX.'item.item_name, ' .                   //  6
										''.DATABASE_PREFIX.'item.item_hit, ' .                    //  7
										'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */    //  8
										''.DATABASE_PREFIX.'admin_currency.admin_currency_code, ' . 		/* SPECIFIC PART */    //  9
										'DATE_FORMAT('.DATABASE_PREFIX.'item.item_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . // 10
										''.DATABASE_PREFIX.'store_inventory.store_inventory_count, ' .      /* SPECIFIC PART */    // 11
										''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */    // 12
										''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  13
										''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  14
										'FROM '.DATABASE_PREFIX.'item ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id = '.DATABASE_PREFIX.'admin_currency.admin_currency_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id = '.DATABASE_PREFIX.'item.item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
										'WHERE '.DATABASE_PREFIX.'item.item_active = 1 ' . 
										'ORDER BY '.DATABASE_PREFIX.'item.item_last_update_date DESC;';

					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ITEM_SEARCH_ERROR);
				}
				break;
			}
		case 'ItemSearchTag' : {
				if (isset($args[0])) {
					
					$tag = $args[0];
					
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                     //  0
											''.DATABASE_PREFIX.'item.item_item_type_id, ' .           //  1
											''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .         //  2
											''.DATABASE_PREFIX.'item_type.item_type_name, ' .         //  3
											''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .     //  4
											''.DATABASE_PREFIX.'item.item_active, ' .                 //  5
											''.DATABASE_PREFIX.'item.item_name, ' .                   //  6
											''.DATABASE_PREFIX.'item.item_hit, ' .                    //  7
											'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */    //  8
											''.DATABASE_PREFIX.'admin_currency.admin_currency_code, ' . 		/* SPECIFIC PART */    //  9
											'DATE_FORMAT('.DATABASE_PREFIX.'item.item_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . // 10
											''.DATABASE_PREFIX.'store_inventory.store_inventory_count, ' .      /* SPECIFIC PART */    // 11
											''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */    // 12
											''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  13
											''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  14
											'FROM '.DATABASE_PREFIX.'item ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id = '.DATABASE_PREFIX.'admin_currency.admin_currency_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
											'WHERE '.DATABASE_PREFIX.'item.item_active = 1 AND ' .
											'('.DATABASE_PREFIX.'item.item_id IN (SELECT DISTINCT tag_object_id FROM '.DATABASE_PREFIX.'tag WHERE tag_type = \'item\' AND UPPER(tag_text) = \''.$tag.'\')) ' .
											'ORDER BY '.DATABASE_PREFIX.'item.item_last_update_date DESC;';
				
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_SEARCH_TAG_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
		case 'ItemAdd' : {
				if (isset($args[0]) &&
				isset($args[1]) &&
				isset($args[2]) &&
				isset($args[3])) {
						
					$item_type_id = $args[0];
					$item_type_2_id = $args[1];
					$item_active = $args[2];
					$item_name = $args[3];
					/* START OF SPECIFIC PART */
					$item_specific_price = $args[4];
					$item_specific_admin_currency_id = $args[5];
					$store_inventory_count = $args[6];
					$item_specific_weight = $args[7];
					$item_specific_brand_id = $args[8];
					$item_specific_brand_text = $args[9];
					/* END OF SPECIFIC PART */
					$item_text_lang = $args[10];
					$item_text_value = $args[11];
						
					$first_item_image_id = $args[12];
					$item_image_id = $args[13];
					$tag_list_value = $args[14];
						
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$data = new Data();
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item (item_id, item_item_type_id, item_item_type_2_id, item_active, item_name, item_creation_date, item_last_update_date, item_last_update_admin_user_id, item_hit) ' .
								'VALUES ' .
								'(NULL, ' .
								''.$this->database->FormatDataToInteger($item_type_id).', ' .
								''.$this->database->FormatDataToInteger($item_type_2_id).', ' .
								''.$this->database->FormatDataToBoolean($item_active).', ' .
								''.$this->database->FormatDataToVarchar($item_name, 50).', ' .
								'NOW(), ' .
								'NOW(), ' .
								''.$this->database->FormatDataToInteger($admin_user_id).', ' .
								'0);';
						
						$result = $this->database->InsertQuery($sql_query);
			
						$item_id = $result[1];
						
						if (($item_specific_brand_id == '') && ($item_specific_brand_text != '')) {
								
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_specific_brand (item_specific_brand_id, item_specific_brand_name, item_specific_brand_logo_filename, item_specific_brand_web_site_url, item_specific_brand_creation_date, item_specific_brand_last_update_date, item_specific_brand_last_update_admin_user_id) VALUES ' .
									'(NULL, ' .
									''.$this->database->FormatDataToVarchar($item_specific_brand_text, 50).', ' .
									'NULL, ' .
									'NULL, ' .
									'NOW(), ' .
									'NOW(), ' .
									''.$this->database->FormatDataToInteger($admin_user_id).');';
								
							$result = $this->database->InsertQuery($sql_query);
							$item_specific_brand_id = $result[1];
						}
			
						/* START OF SPECIFIC PART */
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_specific (item_specific_id, item_specific_item_id, item_specific_item_specific_brand_id, item_specific_price, item_specific_weight, item_specific_admin_currency_id, item_specific_creation_date, item_specific_last_update_date, item_specific_last_update_admin_user_id) ' .
											'VALUES ' .
											'(NULL, ' .
											''.$this->database->FormatDataToInteger($item_id).', ' .
											''.$this->database->FormatDataToInteger($item_specific_brand_id).', ' .
											''.$this->database->FormatDataToFloat($item_specific_price).', ' .
											''.$this->database->FormatDataToInteger($item_specific_weight).', ' .
											''.$this->database->FormatDataToInteger($item_specific_admin_currency_id).', ' .
											'NOW(), ' .
											'NOW(), ' .
											''.$this->database->FormatDataToInteger($admin_user_id).');';
						
						$result = $this->database->InsertQuery($sql_query);
						/* END OF SPECIFIC PART */
						
						/* START OF INVENTORY PART */
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'store_inventory (store_inventory_id, store_inventory_item_id, store_inventory_count, store_inventory_creation_date, store_inventory_last_update_date, store_inventory_last_update_admin_user_id) ' .
											'VALUES ' .
											'(NULL, ' .
											''.$this->database->FormatDataToInteger($item_id).', ' .
											''.$this->database->FormatDataToInteger($store_inventory_count).', ' .
											'NOW(), ' .
											'NOW(), ' .
											''.$this->database->FormatDataToInteger($admin_user_id).');';
						
						$result = $this->database->InsertQuery($sql_query);
						/* END OF INVENTORY PART */
			
						/* TEXT PART */
						if ($item_text_value != '') {
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_text (item_text_id, item_text_item_id, item_text_lang, item_text_value) ' .
									'VALUES ' .
									'(NULL, ' .
									''.$this->database->FormatDataToInteger($item_id).', ' .
									''.$this->database->FormatDataToVarchar($item_text_lang, 2).', ' .
									''.$this->database->FormatDataToVarchar($item_text_value, 10000).');';
							
							$result = $this->database->InsertQuery($sql_query);
						}
						/* END OF TEXT PART */
			
						/* IMAGE PART */
						if (($first_item_image_id != '') && (strpos($_SESSION[SITE_ID]['admin_configuration_image_tmp_prefix'], $first_item_image_id) != -1)) {
							$data->ImageLink($first_item_image_id, $item_id);
						}
							
						if ($item_image_id != '') {
							$image_list = explode(';',$item_image_id);
						
							foreach ($image_list as $image) {
								if (strpos($_SESSION[SITE_ID]['admin_configuration_image_tmp_prefix'], $image) != -1) {
									$data->ImageLink($image, $item_id);
								}
							}
						}
						/* END OF IMAGE PART */
						
						/* TAG PART */
						if ($tag_list_value != '') {
							$tag_list = explode(';',$tag_list_value);
						
							foreach ($tag_list as $tag) {
								if ($tag != '') {
									$data->ItemAddTag($item_id, $tag);
								}
							}
						}
						/* END OF TAG PART */
						
						Util::AdminGenerateSiteMap();
			
						return $item_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ITEM_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
		case 'ItemUpdate' : {
				if (isset($args[0]) &&
				isset($args[1]) &&
				isset($args[2]) &&
				isset($args[3])) {
						
					$item_id = $args[0];
					$item_type_id = $args[1];
					$item_type_2_id = $args[2];
					$item_active = $args[3];
					$item_name = $args[4];
					/* START OF SPECIFIC PART */
					$item_specific_price = $args[5];
					$item_specific_admin_currency_id = $args[6];
					$store_inventory_count = $args[7];
					$item_specific_weight = $args[8];
					$item_specific_brand_id = $args[9];
					$item_specific_brand_text = $args[10];
					/* END OF SPECIFIC PART */
					/* TEXT PART */
					$item_text_id = $args[11];
					$item_text_lang = $args[12];
					$item_text_value = $args[13];
					/* END OF TEXT PART */
						
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						if (($item_specific_brand_id == '') && ($item_specific_brand_text != '')) {
							
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_specific_brand (item_specific_brand_id, item_specific_brand_name, item_specific_brand_logo_filename, item_specific_brand_web_site_url, item_specific_brand_creation_date, item_specific_brand_last_update_date, item_specific_brand_last_update_admin_user_id) VALUES ' .
									     '(NULL, ' .
									     ''.$this->database->FormatDataToVarchar($item_specific_brand_text, 50).', ' .
									     'NULL, ' .
									     'NULL, ' .
									     'NOW(), ' .
									     'NOW(), ' .
										 ''.$this->database->FormatDataToInteger($admin_user_id).');';
							
							$result = $this->database->InsertQuery($sql_query);
							$item_specific_brand_id = $result[1];
						}
						
						
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'item SET ' .
											'item_item_type_id = '.$this->database->FormatDataToInteger($item_type_id).', ' .
											'item_item_type_2_id = '.$this->database->FormatDataToInteger($item_type_2_id).', ' .
											'item_active = '.$this->database->FormatDataToBoolean($item_active).', ' .
											'item_name = '.$this->database->FormatDataToVarchar($item_name, 50).', ' .
											'item_last_update_date = NOW(), ' .
											'item_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
											'WHERE item_id = '.$this->database->FormatDataToInteger($item_id).' LIMIT 1;';
							
						$result = $this->database->UpdateQuery($sql_query);
			
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_specific (item_specific_id, item_specific_item_id, item_specific_item_specific_brand_id, item_specific_price, item_specific_weight, item_specific_admin_currency_id, item_specific_creation_date, item_specific_last_update_date, item_specific_last_update_admin_user_id) ' .
											'VALUES ' .
											'(NULL, ' .
											''.$this->database->FormatDataToInteger($item_id).', ' .
											''.$this->database->FormatDataToInteger($item_specific_brand_id).', ' .
											''.$this->database->FormatDataToFloat($item_specific_price).', ' .
											''.$this->database->FormatDataToInteger($item_specific_weight).', ' .
											''.$this->database->FormatDataToInteger($item_specific_admin_currency_id).', ' .
											'NOW(), ' .
											'NOW(), ' .
											''.$this->database->FormatDataToInteger($admin_user_id).') ON DUPLICATE KEY UPDATE ' .
											'item_specific_item_specific_brand_id = '.$this->database->FormatDataToInteger($item_specific_brand_id).', ' .
											'item_specific_price = '.$this->database->FormatDataToFloat($item_specific_price).', ' .
											'item_specific_weight = '.$this->database->FormatDataToInteger($item_specific_weight).', ' .
											'item_specific_admin_currency_id = '.$this->database->FormatDataToInteger($item_specific_admin_currency_id).', ' .
											'item_specific_last_update_date = NOW(), ' .
											'item_specific_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id);
			
						$result = $this->database->InsertQuery($sql_query);
						
						/* INVENTORY PART */
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'store_inventory (store_inventory_id, store_inventory_item_id, store_inventory_count, store_inventory_creation_date, store_inventory_last_update_date, store_inventory_last_update_admin_user_id) ' .
											'VALUES ' .
											'(NULL, ' .
											''.$this->database->FormatDataToInteger($item_id).', ' .
											''.$this->database->FormatDataToInteger($store_inventory_count).', ' .
											'NOW(), ' .
											'NOW(), ' .
											''.$this->database->FormatDataToInteger($admin_user_id).') ON DUPLICATE KEY UPDATE ' .
											'store_inventory_count = '.$this->database->FormatDataToInteger($store_inventory_count).', ' .
											'store_inventory_last_update_date = NOW(), ' .
											'store_inventory_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id);
							
						$result = $this->database->InsertQuery($sql_query);
						/* END OF INVENTORY PART */
						
						
						/* TEXT PART */
						if (($item_text_lang != '') && ($item_text_value != '')) {
							if ($item_text_id == '') {
								$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_text (item_text_id, item_text_item_id, item_text_lang, item_text_value) ' .
													'VALUES ' .
													'(NULL, ' .
													''.$this->database->FormatDataToInteger($item_id).', ' .
													''.$this->database->FormatDataToVarchar($item_text_lang, 2).', ' .
													''.$this->database->FormatDataToVarchar($item_text_value, 10000).');';
									
								$result = $this->database->InsertQuery($sql_query);
							} else {
								$sql_query = 'UPDATE '.DATABASE_PREFIX.'item_text ' .
													'SET item_text_lang = '.$this->database->FormatDataToVarchar($item_text_lang, 2).', ' .
													'item_text_value = '.$this->database->FormatDataToVarchar($item_text_value, 10000).' ' .
													'WHERE item_text_id = '.$this->database->FormatDataToInteger($item_text_id).' LIMIT 1;';
			
								$result = $this->database->UpdateQuery($sql_query);
							}
						}
						
						Util::AdminGenerateSiteMap();
						/* END OF TEXT PART */
						return $item_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ITEM_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
		case 'AdminItemGetList' : {
				$order = 7;
				$sort = 'ASC';
					
				if (isset($args[0]) && ($args[0] > -1)) {
					$order = $args[0];
				}
					
				if (isset($args[1])) {
					if ($args[1] == 'DESC') {
						$sort = $args[1];
					}
				}
				
				$item_active = '';
				
				if (isset($args[2])) {
					$item_active = $args[2];
				}
				
				$item_type = '';
				
				if (isset($args[3])) {
					$item_type = $args[3];
				}
				
				$item_type2 = '';
				
				if (isset($args[4])) {
					$item_type2 = $args[4];
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                         //   0
								 ''.DATABASE_PREFIX.'item.item_item_type_id, ' .                      //   1
								 ''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .                    //   2
								 ''.DATABASE_PREFIX.'item_type.item_type_name, ' .                    //   3
								 ''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .                //   4
								 ''.DATABASE_PREFIX.'item.item_active, ' .                            //   5
								 ''.DATABASE_PREFIX.'item.item_name, ' .                              //   6
								 ''.DATABASE_PREFIX.'item.item_hit, ' .                               //   7
								 ''.DATABASE_PREFIX.'item.item_last_update_date, ' .                  //   8
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .                 //   9
								 'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */ // 10
								 ''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */         // 11
								 ''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  12
								 ''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  13
							     'FROM '.DATABASE_PREFIX.'item ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'item.item_last_update_admin_user_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
								 'WHERE 1 ';
					
					if ($item_active != '') {
						$sql_query .= 'AND '.DATABASE_PREFIX.'item.item_active = '.$this->database->FormatDataToInteger($item_active).' ';
					}
					
					if ($item_type != '') {
						$sql_query .= 'AND '.DATABASE_PREFIX.'item.item_item_type_id = '.$this->database->FormatDataToInteger($item_type).' ';
					}
					
					if ($item_type2 != '') {
						$sql_query .= 'AND '.DATABASE_PREFIX.'item.item_item_type_2_id = '.$this->database->FormatDataToInteger($item_type2).' ';
					}
					
					$sql_query .= 'ORDER BY '.$order.' '.$sort.';';
						
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ITEM_GET_LIST);
				}
				break;
			}
		case 'ItemGetList' : {
				$order = 7;
				$sort = 'ASC';
			
				if (isset($args[0]) && ($args[0] > -1)) {
					$order = $args[0];
				}
			
				if (isset($args[1])) {
					if ($args[1] == 'DESC') {
						$sort = $args[1];
					}
				}
			
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                         //   0
										''.DATABASE_PREFIX.'item.item_item_type_id, ' .                      //   1
										''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .                    //   2
										''.DATABASE_PREFIX.'item_type.item_type_name, ' .                    //   3
										''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .                //   4
										''.DATABASE_PREFIX.'item.item_active, ' .                            //   5
										''.DATABASE_PREFIX.'item.item_name, ' .                              //   6
										''.DATABASE_PREFIX.'item.item_hit, ' .                               //   7
										''.DATABASE_PREFIX.'item.item_last_update_date, ' .                  //   8
										''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .                 //   9
										'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */   //  10
										''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */           //  11
										''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  12
										''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  13
										'FROM '.DATABASE_PREFIX.'item ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'item.item_last_update_admin_user_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
										'ORDER BY '.$order.' '.$sort.';';
			
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ITEM_GET_LIST);
				}
				break;
			}
		case 'ItemGetActiveListByType' : {
				$type = 0;
				$order = 6;
			
				if (isset($args[0])) {
					$type = $args[0];
			
					if (isset($args[1])) {
						$order = $args[1];
					}
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .
											''.DATABASE_PREFIX.'item.item_item_type_id, ' .
											''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .
											''.DATABASE_PREFIX.'item_type.item_type_name, ' .
											''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .
											''.DATABASE_PREFIX.'item.item_active, ' .
											''.DATABASE_PREFIX.'item.item_name, ' .
											''.DATABASE_PREFIX.'item.item_hit, ' .
											'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */    //  8
											''.DATABASE_PREFIX.'admin_currency.admin_currency_code, ' . 		/* SPECIFIC PART */    //  9
											'DATE_FORMAT('.DATABASE_PREFIX.'item.item_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . // 10
											''.DATABASE_PREFIX.'store_inventory.store_inventory_count, ' .      /* SPECIFIC PART */    // 10
											''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */    // 11
										    ''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  12
										    ''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  13
										    'FROM '.DATABASE_PREFIX.'item ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id = '.DATABASE_PREFIX.'admin_currency.admin_currency_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
										    'WHERE '.DATABASE_PREFIX.'item.item_item_type_id = '.$this->database->FormatDataToInteger($type).' AND '.DATABASE_PREFIX.'item.item_active = 1 ' .
											'ORDER BY '.DATABASE_PREFIX.'item.item_name;';
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_GET_ACTIVE_LIST_BY_TYPE);
					}
						
					if ($order != 6) {
						array_multisort($result[$order], SORT_ASC, SORT_STRING);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemGetActiveListByTypeAndType2' : {
				$type = 0;
				$type2 = 0;
				$order = 6;
			
				if (isset($args[0])) {
					$type = $args[0];
					$type2 = $args[1];
			
					if (isset($args[2])) {
						$order = $args[2];
					}
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .
											''.DATABASE_PREFIX.'item.item_item_type_id, ' .
											''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .
											''.DATABASE_PREFIX.'item_type.item_type_name, ' .
											''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .
											''.DATABASE_PREFIX.'item.item_active, ' .
											''.DATABASE_PREFIX.'item.item_name, ' .
											''.DATABASE_PREFIX.'item.item_hit, ' .
											'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */    //  8
											''.DATABASE_PREFIX.'admin_currency.admin_currency_code, ' . 		/* SPECIFIC PART */    //  9
											'DATE_FORMAT('.DATABASE_PREFIX.'item.item_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . // 10
											''.DATABASE_PREFIX.'store_inventory.store_inventory_count, ' .      /* SPECIFIC PART */    // 10
											''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */    // 11
										    ''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  12
										    ''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  13
										    'FROM '.DATABASE_PREFIX.'item ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id = '.DATABASE_PREFIX.'admin_currency.admin_currency_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
										    'WHERE '.DATABASE_PREFIX.'item.item_item_type_id = '.$this->database->FormatDataToInteger($type).' AND '.DATABASE_PREFIX.'item.item_item_type_2_id = '.$this->database->FormatDataToInteger($type2).' AND '.DATABASE_PREFIX.'item.item_active = 1 ' .
											'ORDER BY '.DATABASE_PREFIX.'item.item_name;';
						
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_GET_ACTIVE_LIST_BY_TYPE_AND_TYPE2);
					}
						
					if ($order != 6) {
						array_multisort($result[$order], SORT_ASC, SORT_STRING);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemGetActiveListByType2' : {
				$type2 = 0;
				$order = 6;
			
				if (isset($args[0])) {
					$type2 = $args[0];
			
					if (isset($args[1])) {
						$order = $args[1];
					}
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                  //  0
											''.DATABASE_PREFIX.'item.item_item_type_id, ' .               //  1
											''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .             //  2
											''.DATABASE_PREFIX.'item_type.item_type_name, ' .             //  3
											''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .         //  4
											''.DATABASE_PREFIX.'item.item_active, ' .                     //  5
											''.DATABASE_PREFIX.'item.item_name, ' .                       //  6
											''.DATABASE_PREFIX.'item.item_hit, ' .                        //  7
											'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */    //  8
											''.DATABASE_PREFIX.'admin_currency.admin_currency_code, ' . 		/* SPECIFIC PART */    //  9
											'DATE_FORMAT('.DATABASE_PREFIX.'item.item_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . // 10
											''.DATABASE_PREFIX.'store_inventory.store_inventory_count, ' .      /* SPECIFIC PART */    // 11
											''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */    // 12
										    ''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  13
										    ''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  14
										    'FROM '.DATABASE_PREFIX.'item ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id = '.DATABASE_PREFIX.'admin_currency.admin_currency_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
										    'WHERE '.DATABASE_PREFIX.'item.item_item_type_2_id = '.$this->database->FormatDataToInteger($type2).' AND '.DATABASE_PREFIX.'item.item_active = 1 ' .
											'ORDER BY '.DATABASE_PREFIX.'item.item_name;';
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_GET_ACTIVE_LIST_BY_TYPE2);
					}
						
					if ($order != 6) {
						array_multisort($result[$order], SORT_ASC, SORT_STRING);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemGetActiveList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                     //  0
										''.DATABASE_PREFIX.'item.item_item_type_id, ' .           //  1
										''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .         //  2
										''.DATABASE_PREFIX.'item_type.item_type_name, ' .         //  3
										''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .     //  4
										''.DATABASE_PREFIX.'item.item_active, ' .                 //  5
										''.DATABASE_PREFIX.'item.item_name, ' .                   //  6
										''.DATABASE_PREFIX.'item.item_hit, ' .                    //  7
										'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */    //  8
										''.DATABASE_PREFIX.'admin_currency.admin_currency_code, ' . 		/* SPECIFIC PART */    //  9
										'DATE_FORMAT('.DATABASE_PREFIX.'item.item_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . // 10
										''.DATABASE_PREFIX.'store_inventory.store_inventory_count, ' .      /* SPECIFIC PART */    // 11
										''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */    // 12
										''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  13
										''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  14
										'FROM '.DATABASE_PREFIX.'item ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id = '.DATABASE_PREFIX.'admin_currency.admin_currency_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id = '.DATABASE_PREFIX.'item.item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
										'WHERE '.DATABASE_PREFIX.'item.item_active = 1 ' .
										'ORDER BY '.DATABASE_PREFIX.'item.item_last_update_date DESC;';
			
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ITEM_GET_ACTIVE_LIST);
				}
				break;
			}
		case 'ItemGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                                                                          //  0
											''.DATABASE_PREFIX.'item.item_item_type_id, ' .                                                                //  1
											''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .                                                              //  2
											''.DATABASE_PREFIX.'item_type.item_type_name, ' .                                                              //  3
											''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .                                                          //  4
											''.DATABASE_PREFIX.'item.item_active, ' .                                                                      //  5
											''.DATABASE_PREFIX.'item.item_name, ' .                                                                        //  6
											'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' .                         /* SPECIFIC PART */         //  7
											''.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id, ' . 	        /* SPECIFIC PART */         //  8
											''.DATABASE_PREFIX.'admin_currency.admin_currency_code, ' . 	                 	/* SPECIFIC PART */         //  9
											''.DATABASE_PREFIX.'store_inventory.store_inventory_count, ' . 	       			    /* SPECIFIC PART */         //  10
											''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */        //  11
										    ''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  12
										    ''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  13
										    'FROM '.DATABASE_PREFIX.'item ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item.item_item_type_id = '.DATABASE_PREFIX.'item_type.item_type_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item.item_item_type_2_id = '.DATABASE_PREFIX.'item_type_2.item_type_2_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id = '.DATABASE_PREFIX.'admin_currency.admin_currency_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'item.item_id = '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
											'WHERE '.DATABASE_PREFIX.'item.item_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
											'LIMIT 1;';
			
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_GET);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
///////////////////////////////////////////////////////////////////////
//////////       END OF STANDARD WITH SPECIFIC PART      //////////////
///////////////////////////////////////////////////////////////////////
			
			
			
			
			
///////////////////////////////////////////////////////////////////////
///////////////    100% SPECIFIC PART             /////////////////////
///////////////////////////////////////////////////////////////////////
		case 'SpecificItemBrandDiplayList' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT item_specific_brand_id, item_specific_brand_name FROM '.DATABASE_PREFIX.'item_specific_brand ORDER BY item_specific_brand_name;';
			
						return $this->database->PrintSelectOption($sql_query,$args[0], true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_SPECIFIC_ITEM_BRAND_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'SpecificItemBrandGetName' : {
				if (isset($args[0])) {
					$item_specific_brand_id = $args[0];
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' .                                //   0
											'FROM '.DATABASE_PREFIX.'item_specific_brand ' .
											'WHERE '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id = '.$this->database->FormatDataToInteger($item_specific_brand_id).' LIMIT 1;';
							
						return $this->database->SelectSingleValueQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_SPECIFIC_BRAND_GET_NAME);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemGetActiveListByBrand' : {
				$brand = 0;
				$order = 6;
					
				if (isset($args[0])) {
					$brand = $args[0];
						
					if (isset($args[1])) {
						$order = $args[1];
					}
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                  //  0
								''.DATABASE_PREFIX.'item.item_item_type_id, ' .               //  1
								''.DATABASE_PREFIX.'item.item_item_type_2_id, ' .             //  2
								''.DATABASE_PREFIX.'item_type.item_type_name, ' .             //  3
								''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .         //  4
								''.DATABASE_PREFIX.'item.item_active, ' .                     //  5
								''.DATABASE_PREFIX.'item.item_name, ' .                       //  6
								''.DATABASE_PREFIX.'item.item_hit, ' .                        //  7
								'FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_price, 2), ' . 		/* SPECIFIC PART */    //  8
								''.DATABASE_PREFIX.'admin_currency.admin_currency_code, ' . 		/* SPECIFIC PART */    //  9
								'DATE_FORMAT('.DATABASE_PREFIX.'item.item_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . // 10
								''.DATABASE_PREFIX.'store_inventory.store_inventory_count, ' .      /* SPECIFIC PART */    // 10
								''.DATABASE_PREFIX.'item_specific.item_specific_weight, ' . 		/* SPECIFIC PART */
								''.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id, ' . 		/* SPECIFIC PART */        //  11
								''.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_name ' . 		/* SPECIFIC PART */        //  12
								'FROM '.DATABASE_PREFIX.'item ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id = '.DATABASE_PREFIX.'admin_currency.admin_currency_id ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id = '.DATABASE_PREFIX.'item.item_id ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific_brand ON '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.DATABASE_PREFIX.'item_specific_brand.item_specific_brand_id ' .
								'WHERE '.DATABASE_PREFIX.'item_specific.item_specific_item_specific_brand_id = '.$this->database->FormatDataToInteger($brand).' AND '.DATABASE_PREFIX.'item.item_active = 1 ' .
								'ORDER BY '.DATABASE_PREFIX.'item.item_name;';
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_GET_ACTIVE_LIST_BY_BRAND);
					}
			
					if ($order != 6) {
						array_multisort($result[$order], SORT_ASC, SORT_STRING);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
		case 'SpecificItemParentDisplayList' : {
				if (isset($args[0])) {
						
					$item_id = $args[0];
					$selected  = $args[1];
					$item_specific_sex = $args[2];
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, '.DATABASE_PREFIX.'item.item_name ' .
											'FROM '.DATABASE_PREFIX.'item ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item.item_id = '.DATABASE_PREFIX.'item_specific.item_specific_item_id ' .
											'WHERE '.DATABASE_PREFIX.'item.item_id <> '.$this->database->FormatDataToInteger($item_id).' AND ' .
											''.DATABASE_PREFIX.'item_specific.item_specific_sex IN ('.$item_specific_sex.') ' .
											'ORDER BY '.DATABASE_PREFIX.'item.item_name;';
							
						return $this->database->PrintSelectOption($sql_query,$selected, true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_TYPE_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'SpecificItemFatherAndMotherLinkGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item_specific.item_specific_father_link, ' .
											'father.item_name, ' .
											'CONCAT(father_image.item_image_number, \'.\', father_image.item_image_type), ' .
											''.DATABASE_PREFIX.'item_specific.item_specific_father_name, ' .
											''.DATABASE_PREFIX.'item_specific.item_specific_mother_link, ' .
											'mother.item_name, ' .
											'CONCAT(mother_image.item_image_number, \'.\', mother_image.item_image_type), ' .
											''.DATABASE_PREFIX.'item_specific.item_specific_mother_name, ' .
											'father.item_active, ' .   // 8
											'mother.item_active ' .    // 9
											'FROM '.DATABASE_PREFIX.'item_specific ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item father ON father.item_id = '.DATABASE_PREFIX.'item_specific.item_specific_father_link ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item mother ON mother.item_id = '.DATABASE_PREFIX.'item_specific.item_specific_mother_link ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_image father_image ON father_image.item_image_item_id = '.DATABASE_PREFIX.'item_specific.item_specific_father_link AND father_image.item_image_top = 1 ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_image mother_image ON mother_image.item_image_item_id = '.DATABASE_PREFIX.'item_specific.item_specific_mother_link AND mother_image.item_image_top = 1 ' .
											'WHERE '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
											'LIMIT 1;';
							
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_SPECIFIC_FATHER_AND_MOTHER_LINK_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'SpecificItemChildrenGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .
											''.DATABASE_PREFIX.'item.item_name, ' .
											'CONCAT('.DATABASE_PREFIX.'item_image.item_image_number, \'.\', '.DATABASE_PREFIX.'item_image.item_image_type), ' .
											'DATE_FORMAT('.DATABASE_PREFIX.'item_specific.item_specific_date_of_birth, \''.DATABASE_DATE_FORMAT.'\'), ' .
											''.DATABASE_PREFIX.'item_specific.item_specific_sex, ' .
											''.DATABASE_PREFIX.'item.item_active ' .
											'FROM item_specific ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item ON item.item_id = '.DATABASE_PREFIX.'item_specific.item_specific_item_id ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_image ON item_image.item_image_item_id = '.DATABASE_PREFIX.'item.item_id AND '.DATABASE_PREFIX.'item_image.item_image_top = 1 ' .
											'WHERE '.DATABASE_PREFIX.'item_specific.item_specific_father_link = '.$this->database->FormatDataToInteger($args[0]).' OR '.DATABASE_PREFIX.'item_specific.item_specific_mother_link = '.$this->database->FormatDataToInteger($args[0]).' ' .
											'ORDER BY '.DATABASE_PREFIX.'item_specific.item_specific_date_of_birth DESC;';
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_SPECIFIC_CHILDREN_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ValueSpecificSexDisplayList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_value.admin_value_value, ' .
									 ''.DATABASE_PREFIX.'admin_value.admin_value_value ' .
									 'FROM '.DATABASE_PREFIX.'admin_value ' .
									 'WHERE '.DATABASE_PREFIX.'admin_value.admin_value_name = \'ITEM_SPECIFIC_SEX\' ' .
									 'ORDER BY '.DATABASE_PREFIX.'admin_value.admin_value_id;';
						
					return $this->database->PrintTranslatedSelectOption($sql_query,$args[0], true);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(VALUE_TEXT_LANG_DISPLAY_LIST_ERROR);
				}
					
				break;
			}
///////////////////////////////////////////////////////////////////////
///////////////        END OF 100% SPECIFIC PART            ///////////
///////////////////////////////////////////////////////////////////////
			default:
				throw new DataSpecificException(MISSING_METHOD_ERROR);
				break;
		}
	}
}

?>