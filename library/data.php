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
	
class DataException extends Exception	
{
	public function __construct($message) {
		parent :: __construct($message);
	}

	public function getError() {
		return $this->getMessage();
	}
}

class Data
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
//////// 		BASIC ADMINISTRATION PART
			case 'DisplayBooleanList' : {
				$result = NULL;
					
				if (isset($args[0])) {
					try {
						$result = $this->database->PrintBooleanSelectOption($args[0], true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_DISPLAY_BOOLEAN_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				return $result;
					
				break;
			}
			case 'AdminCurrencyDisplayList' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT admin_currency_id, admin_currency_code FROM '.DATABASE_PREFIX.'admin_currency ORDER BY admin_currency_code;';
			
						return $this->database->PrintSelectOption($sql_query,$args[0], true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ADMIN_CURRENCY_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'ValueTextLangDisplayList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_value.admin_value_value, '.DATABASE_PREFIX.'admin_value.admin_value_value ' .
										'FROM '.DATABASE_PREFIX.'admin_value ' .
										'WHERE '.DATABASE_PREFIX.'admin_value.admin_value_name = \'TEXT_LANG\' ' .
										'ORDER BY '.DATABASE_PREFIX.'admin_value.admin_value_value;';
						
					return $this->database->PrintSelectOption($sql_query,$args[0], true);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(VALUE_TEXT_LANG_DISPLAY_LIST_ERROR);
				}
					
				break;
			}
//////// 		END OF BASIC ADMINISTRATION PART
			
//////// 		USER ADMINISTRATION PART
			case 'AdminUserSaveConnection' : {
				if (isset($args[0])) {
					$ip_address = $args[0];
					$country = $args[1];
					$city = $args[2];
					$latidude = $args[3];
					$longitude = $args[4];
					$operating_system = $args[5];
					$browser = $args[6];
					$browser_version = $args[7];
					$javascript = $args[8];
					$java_applets = $args[9];
					$activex_controls = $args[10];
					$cookies = $args[11];
					$css_version = $args[12];
					$frames = $args[13];
					$iframes = $args[14];
					
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_connection (admin_connection_id, admin_connection_ip_address, admin_connection_country, admin_connection_city, admin_connection_latitude, admin_connection_longitude, admin_connection_date, admin_connection_operating_system, admin_connection_browser, admin_connection_browser_version, admin_connection_javascript, admin_connection_java_applets, admin_connection_activex_controls, admin_connection_cookies, admin_connection_css_version, admin_connection_frames, admin_connection_iframes) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToVarchar($ip_address, 20).', ' .
									 ''.$this->database->FormatDataToVarchar($country, 100).', ' .
									 ''.$this->database->FormatDataToVarchar($city, 100).', ' .
									 ''.$this->database->FormatDataToVarchar($latidude, 50).', ' .
									 ''.$this->database->FormatDataToVarchar($longitude, 50).', ' .
									 'NOW(), ' .
					           	     ''.$this->database->FormatDataToVarchar($operating_system, 50).', ' .
								 	 ''.$this->database->FormatDataToVarchar($browser, 200).', ' .
								 	 ''.$this->database->FormatDataToVarchar($browser_version, 20).', ' .
								 	 ''.$this->database->FormatDataToInteger($javascript).', ' .
								 	 ''.$this->database->FormatDataToInteger($java_applets).', ' .
								 	 ''.$this->database->FormatDataToInteger($activex_controls).', ' .
								 	 ''.$this->database->FormatDataToInteger($cookies).', ' .
								 	 ''.$this->database->FormatDataToInteger($css_version).', ' .
								 	 ''.$this->database->FormatDataToInteger($frames).', ' .
								 	 ''.$this->database->FormatDataToInteger($iframes).');';
					
						$result = $this->database->InsertQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_USER_SAVE_CONNECTION);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserGetPasswordWithUserLogin' : {
				if (isset($args[0])) {
					$user_login = strtolower($args[0]);
					
					try {
						$sql_query = 'SELECT admin_user_password ' .
									 'FROM '.DATABASE_PREFIX.'admin_user ' .
									 'WHERE admin_user_login ='.$this->database->FormatDataToVarchar($user_login, 30).' OR admin_user_email ='.$this->database->FormatDataToVarchar($user_login, 30).' LIMIT 1;';

						return $this->database->SelectSingleValueQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_GET_PASSWORD_WITH_USER_LOGIN_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserGetPasswordWithUserId' : {
				if (isset($args[0])) {
					$user_id = strtolower($args[0]);
			
					try {
						$sql_query = 'SELECT admin_user_password ' .
											'FROM '.DATABASE_PREFIX.'admin_user ' .
											'WHERE admin_user_id ='.$this->database->FormatDataToInteger($user_id).' LIMIT 1;';
			
						return $this->database->SelectSingleValueQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_GET_PASSWORD_WITH_USER_ID_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserGetInformationWithUserLogin' : {
				if (isset($args[0])) {
					$user_login = strtolower($args[0]);
					
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_user.admin_user_id, ' .
									 ''.DATABASE_PREFIX.'admin_role.admin_role_name, ' .
					           	     ''.DATABASE_PREFIX.'admin_user.admin_user_active, ' .
					            	 ''.DATABASE_PREFIX.'admin_user.admin_user_email, ' .
					           	     ''.DATABASE_PREFIX.'admin_user.admin_user_first_name, ' .
					           	     ''.DATABASE_PREFIX.'admin_user.admin_user_last_name, ' .
					                 ''.DATABASE_PREFIX.'admin_user.admin_user_lang, ' .
					                 ''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_code, ' .
					                 ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_1, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_2, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_3, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_postal_code, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_city, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_region, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_country ' .
								     'FROM '.DATABASE_PREFIX.'admin_user ' .
					                 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user_address ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_user_address.admin_user_address_admin_user_id ' .
									 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_role ON '.DATABASE_PREFIX.'admin_role.admin_role_id = '.DATABASE_PREFIX.'admin_user.admin_user_admin_role_id ' .
					                 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_site_theme ON '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_id = '.DATABASE_PREFIX.'admin_user.admin_user_admin_site_theme_id ' .
					                 'WHERE admin_user_login ='.$this->database->FormatDataToVarchar($user_login, 30).' OR admin_user_email ='.$this->database->FormatDataToVarchar($user_login, 30).' LIMIT 1;';
					
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_GET_INFORMATION_WITH_USER_LOGIN_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserGetInformationWithUserId' : {
				if (isset($args[0])) {
					$user_id = strtolower($args[0]);
					
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_role.admin_role_name as role_name, ' .
					           	     ''.DATABASE_PREFIX.'admin_user.admin_user_active as user_active, ' .
					            	 ''.DATABASE_PREFIX.'admin_user.admin_user_name as user_name, ' .
					           	     ''.DATABASE_PREFIX.'admin_user.admin_user_email as user_email, ' .
					           	     ''.DATABASE_PREFIX.'admin_user.admin_user_first_name as user_first_name, ' .
					           	     ''.DATABASE_PREFIX.'admin_user.admin_user_last_name as user_last_name, ' .
					                 ''.DATABASE_PREFIX.'admin_user.admin_user_lang as user_lang, ' .
					                 ''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_code as site_theme_code, ' .
					                 ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_1, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_2, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_3, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_postal_code, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_city, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_region, ' .
								     ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_country ' .
								     'FROM '.DATABASE_PREFIX.'admin_user ' .
					                 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user_address ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_user_address.admin_user_address_admin_user_id ' .
									 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_role ON '.DATABASE_PREFIX.'admin_role.admin_role_id = '.DATABASE_PREFIX.'admin_user.admin_user_admin_role_id ' .
					                 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_site_theme ON '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_id = '.DATABASE_PREFIX.'admin_user.admin_user_admin_site_theme_id ' .
					                 'WHERE admin_user_id ='.$this->database->FormatDataToInteger($user_id).' LIMIT 1;';
					
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ADMIN_USER_GET_INFORMATION_WITH_USER_ID);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserGetRightWithUserLogin' : {
				if (isset($args[0])) {
					$user_login = strtolower($args[0]);
					
					try {
						$sql_query = 'SELECT DISTINCT LOWER(admin_access_url) FROM '.DATABASE_PREFIX.'admin_access ' .
					        	     'WHERE admin_access_id IN (SELECT DISTINCT admin_role_access_admin_access_id FROM '.DATABASE_PREFIX.'admin_role_access ' .
					         	     'WHERE admin_role_access_admin_role_id = (SELECT admin_user_admin_role_id FROM '.DATABASE_PREFIX.'admin_user ' .
					         	     'WHERE admin_user_login = '.$this->database->FormatDataToVarchar($user_login, 30).' OR admin_user_email ='.$this->database->FormatDataToVarchar($user_login, 30).' LIMIT 1));';
 
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ADMIN_USER_GET_RIGHT);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserActivate' : {
				if (isset($args[0])) {
						
					$admin_user_id = $args[0];
						
					$admin_admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_admin_user_id = 0;
					}
						
					try {
						$value = '0';
			
						$sql_query = 'SELECT admin_user_active FROM '.DATABASE_PREFIX.'admin_user WHERE admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' LIMIT 1;';
						$result = $this->database->SelectSingleValueQuery($sql_query);
			
						if ($result == '0') {
							$value = '1';
						}
			
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_user SET ' .
											'admin_user_active = '.$value.', ' .
											'admin_user_last_update_date = NOW(), ' .
											'admin_user_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_admin_user_id).' ' .
											'WHERE admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
						return $admin_user_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_ACTIVATE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserResetPasswordWithPassword' : {
				if (isset($args[0]) &&
					isset($args[1])) {
						
					$admin_user_id = $args[0];
					$password = $args[1];
						
					$admin_admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_admin_user_id = 0;
					}
						
					$admin_user_password = Util::CryptPassword($password);
						
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_user SET ' .
											'admin_user_password = '.$this->database->FormatDataToVarchar($admin_user_password, 30).', ' .
											'admin_user_last_update_date = NOW(), ' .
											'admin_user_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_admin_user_id).' ' .
											'WHERE admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
						return $admin_user_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_PASSWORD_RESET_WITH_PASSWORD_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserResetPassword' : {
				if (isset($args[0])) {
			
					$email = $args[0];
					$email = strtolower($email);
			
					$admin_admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_admin_user_id = 0;
					}
					
					$password = Util::GeneratePassword();
					$admin_user_password = Util::CryptPassword($password);
			
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_user SET ' .
									 'admin_user_password = '.$this->database->FormatDataToVarchar($admin_user_password, 30).', ' .
									 'admin_user_last_update_date = NOW(), ' .
									 'admin_user_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_admin_user_id).' ' .
									 'WHERE admin_user_email = '.$this->database->FormatDataToVarchar($email, 100).' LIMIT 1;';
							
						$result = $this->database->UpdateQuery($sql_query);
						
						if ($result == 1) {
							// Email new password
							
							// FINALLY SEND MAIL
								
							$message = '<?php echo Util::PageGetHtmlTop(); ?>
									      <BODY>
											<TABLE>
												<TR>
													<TD>'.MAIL_RESET_PASSWORD_MESSAGE_1.'<B>'.$password.'</B>'.MAIL_RESET_PASSWORD_MESSAGE_2.'<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/login.php" TARGET="_blank">'.SITE_TITLE.'</A>.</TD>
												</TR>
									       	</TABLE>
									      </BODY>
									     </HTML>';
								
							Util::SendMail($email, SITE_TITLE.' - '.MAIL_RESET_PASSWORD, $message);
							
							return $admin_user_id;
						} else  {
							throw new DataException(ADMIN_USER_PASSWORD_RESET_MISSING_EMAIL);
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_PASSWORD_RESET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			
			case 'AdminUserDelete' : {
				if (isset($args[0])) {
						
					$admin_user_id = $args[0];
						
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_user ' .
											'WHERE admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' LIMIT 1;';
							
						$this->database->DeleteQuery($sql_query);
						return $admin_user_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_user.admin_user_id, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_admin_role_id, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_active, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_email, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_first_name, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_last_name, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_phone, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_lang, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_admin_site_theme_id, ' .
											''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_1, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_2, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_3, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_postal_code, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_city, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_region, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_country ' .
										    'FROM '.DATABASE_PREFIX.'admin_user ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user_address ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_user_address.admin_user_address_admin_user_id ' .
											'WHERE '.DATABASE_PREFIX.'admin_user.admin_user_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
											'LIMIT 1;';
							
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'AdminUserGetList' : {
				$order = 5;
				$sort = 'ASC';
			
				if (isset($args[0])) {
					$order = $args[0];
				}
			
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_user.admin_user_id, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_admin_role_id, ' .
										''.DATABASE_PREFIX.'admin_role.admin_role_name, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_active, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_email, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_first_name, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_last_name, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_phone, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_lang, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_admin_site_theme_id, ' .
										''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_name, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_last_update_date, ' .
										''.DATABASE_PREFIX.'admin_user2.admin_user_login, ' .
										''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_1, ' .
									    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_2, ' .
									    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_3, ' .
									    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_postal_code, ' .
									    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_city, ' .
									    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_region, ' .
									    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_country ' .
									    'FROM '.DATABASE_PREFIX.'admin_user ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user_address ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_user_address.admin_user_address_admin_user_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_role ON '.DATABASE_PREFIX.'admin_user.admin_user_admin_role_id = '.DATABASE_PREFIX.'admin_role.admin_role_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_site_theme ON '.DATABASE_PREFIX.'admin_user.admin_user_admin_site_theme_id = '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user '.DATABASE_PREFIX.'admin_user2 ON '.DATABASE_PREFIX.'admin_user.admin_user_last_update_admin_user_id = '.DATABASE_PREFIX.'admin_user2.admin_user_id ' .
										'ORDER BY '.$order.' '.$sort.';';
			
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_USER_GET_LIST_ERROR);
				}
			
				if ($order != 4) {
					array_multisort($result[$order], SORT_ASC, SORT_STRING);
				}
			
				break;
			}
			case 'AdminUserAdd' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3]) &&
					isset($args[4]) &&
					isset($args[5]) &&
					isset($args[6]) &&
					isset($args[7]) &&
					isset($args[8]) &&
					isset($args[9]) &&
					isset($args[10]) &&
					isset($args[13]) &&
					isset($args[14]) &&
					isset($args[16])) {
						
					$admin_role_id = $args[0];
					$admin_user_active = $args[1];
					$admin_user_login = strtolower($args[2]);
					$admin_user_password = $args[3];
					$admin_user_email = strtolower($args[4]);
					$admin_user_first_name = $args[5];
					$admin_user_last_name = $args[6];
					$admin_user_phone = $args[7];
					$admin_user_lang = $args[8];
					$admin_site_theme_id = $args[9];
					$admin_user_address_line_1 = $args[10];
					$admin_user_address_line_2 = $args[11];
					$admin_user_address_line_3 = $args[12];
					$admin_user_address_postal_code = $args[13];
					$admin_user_address_city = $args[14];
					$admin_user_address_region = $args[15];
					$admin_user_address_country = $args[16];
						
					$admin_admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_admin_user_id = 0;
					}
						
					$admin_user_password = Util::CryptPassword($admin_user_password);
						
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_user (admin_user_id, admin_user_admin_role_id, admin_user_active, admin_user_login, admin_user_password, admin_user_email, admin_user_first_name, admin_user_last_name, admin_user_phone, admin_user_creation_date, admin_user_last_update_date, admin_user_last_update_admin_user_id, admin_user_last_admin_connection_id, admin_user_lang, admin_user_admin_site_theme_id) ' .
												'VALUES ' .
												'(NULL, ' .
												''.$this->database->FormatDataToInteger($admin_role_id).', ' .
												''.$this->database->FormatDataToBoolean($admin_user_active).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_login, 30).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_password, 30).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_email, 100).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_first_name, 50).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_last_name, 50).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_phone, 20).', ' .
												'NOW(), ' .
												'NOW(), ' .
												''.$this->database->FormatDataToInteger($admin_admin_user_id).', ' .
												'NULL, ' .
												''.$this->database->FormatDataToVarchar($admin_user_lang, 2).', ' .
												''.$this->database->FormatDataToInteger($admin_site_theme_id).');';
							
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							
							$admin_user_id = $result[1];
								
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_user_address (admin_user_address_id, admin_user_address_admin_user_id, admin_user_address_line_1, admin_user_address_line_2, admin_user_address_line_3, admin_user_address_postal_code, admin_user_address_city, admin_user_address_region, admin_user_address_country, admin_user_address_creation_date, admin_user_address_last_update_date, admin_user_address_last_update_admin_user_id) ' .
												'VALUES ' .
												'(NULL, ' .
												''.$this->database->FormatDataToInteger($admin_user_id).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_address_line_1, 50).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_address_line_2, 50).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_address_line_3, 50).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_address_postal_code, 20).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_address_city, 100).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_address_region, 100).', ' .
												''.$this->database->FormatDataToVarchar($admin_user_address_country, 100).', ' .
												'NOW(), ' .
												'NOW(), ' .
												''.$this->database->FormatDataToInteger($admin_admin_user_id).');';
								
							$result = $this->database->InsertQuery($sql_query);
							
							if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
								return $admin_user_id;
							}
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_USER_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_USER_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminUserUpdate' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3]) &&
					isset($args[4]) &&
					isset($args[5]) &&
					isset($args[6]) &&
					isset($args[7]) &&
					isset($args[8]) &&
					isset($args[9]) &&
					isset($args[10]) &&
					isset($args[13]) &&
					isset($args[14]) &&
					isset($args[16])) {
							
					$admin_user_id = $args[0];
					$admin_role_id = $args[1];
					$admin_user_active = $args[2];
					$admin_user_login = strtolower($args[3]);
					$admin_user_email = strtolower($args[4]);
					$admin_user_first_name = $args[5];
					$admin_user_last_name = $args[6];
					$admin_user_phone = $args[7];
					$admin_user_lang = $args[8];
					$admin_site_theme_id = $args[9];
					$admin_user_address_line_1 = $args[10];
					$admin_user_address_line_2 = $args[11];
					$admin_user_address_line_3 = $args[12];
					$admin_user_address_postal_code = $args[13];
					$admin_user_address_city = $args[14];
					$admin_user_address_region = $args[15];
					$admin_user_address_country = $args[16];
						
					$admin_admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_admin_user_id = 0;
					}
						
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_user SET ' .
											'admin_user_admin_role_id = '.$this->database->FormatDataToInteger($admin_role_id).', ' .
											'admin_user_active = '.$this->database->FormatDataToBoolean($admin_user_active).', ' .
											'admin_user_login = '.$this->database->FormatDataToVarchar($admin_user_login, 30).', ' .
											'admin_user_email = '.$this->database->FormatDataToVarchar($admin_user_email, 100).', ' .
											'admin_user_first_name = '.$this->database->FormatDataToVarchar($admin_user_first_name, 50).', ' .
											'admin_user_last_name = '.$this->database->FormatDataToVarchar($admin_user_last_name, 50).', ' .
											'admin_user_phone = '.$this->database->FormatDataToVarchar($admin_user_phone, 20).', ' .
											'admin_user_last_update_date = NOW(), ' .
											'admin_user_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_admin_user_id).', ' .
											'admin_user_lang = '.$this->database->FormatDataToVarchar($admin_user_lang, 2).', ' .
											'admin_user_admin_site_theme_id = '.$this->database->FormatDataToInteger($admin_site_theme_id).' ' .
											'WHERE admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
			
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_user_address (admin_user_address_id, admin_user_address_admin_user_id, admin_user_address_line_1, admin_user_address_line_2, admin_user_address_line_3, admin_user_address_postal_code, admin_user_address_city, admin_user_address_region, admin_user_address_country, admin_user_address_creation_date, admin_user_address_last_update_date, admin_user_address_last_update_admin_user_id) ' .
									'VALUES ' .
									'(NULL, ' .
									''.$this->database->FormatDataToInteger($admin_user_id).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_line_1, 50).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_line_2, 50).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_line_3, 50).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_postal_code, 20).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_city, 100).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_region, 100).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_country, 100).', ' .
									'NOW(), ' .
									'NOW(), ' .
									''.$this->database->FormatDataToInteger($admin_admin_user_id).') ON DUPLICATE KEY UPDATE ' .
							        'admin_user_address_line_1 = '.$this->database->FormatDataToVarchar($admin_user_address_line_1, 50).', ' .
									'admin_user_address_line_2 = '.$this->database->FormatDataToVarchar($admin_user_address_line_2, 50).', ' .
									'admin_user_address_line_3 = '.$this->database->FormatDataToVarchar($admin_user_address_line_3, 50).', ' .
									'admin_user_address_postal_code = '.$this->database->FormatDataToVarchar($admin_user_address_postal_code, 20).', ' .
									'admin_user_address_city = '.$this->database->FormatDataToVarchar($admin_user_address_city, 100).', ' .
									'admin_user_address_region = '.$this->database->FormatDataToVarchar($admin_user_address_region, 100).', ' .
									'admin_user_address_country = '.$this->database->FormatDataToVarchar($admin_user_address_country, 100).', ' .
									'admin_user_address_last_update_date = NOW(), ' .
									'admin_user_address_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_admin_user_id);
							
						$this->database->InsertQuery($sql_query);
							
						return $admin_user_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_USER_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_USER_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
//////// 		END OF USER ADMINISTRATION PART
			
//////// 		SEARCH/TAG PART
			case 'BlogSearch' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'blog.blog_id, ' .                                                               // 0
										''.DATABASE_PREFIX.'blog.blog_image_number, ' .                                                     // 1
										''.DATABASE_PREFIX.'blog.blog_image_type, ' .                                                       // 2
										'DATE_FORMAT('.DATABASE_PREFIX.'blog.blog_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .  // 3
										''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .                                                  // 4
										''.DATABASE_PREFIX.'blog_text.blog_text_value, ' .                                                  // 5
										''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .                                                // 6
										''.DATABASE_PREFIX.'admin_user.admin_user_email, ' .                                                // 7
										'DATE_FORMAT('.DATABASE_PREFIX.'blog.blog_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .      // 8
										''.DATABASE_PREFIX.'blog.blog_hit ' .                                                              // 9
										'FROM '.DATABASE_PREFIX.'blog ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'blog_text ON '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.DATABASE_PREFIX.'blog.blog_id AND '.DATABASE_PREFIX.'blog_text.blog_text_lang = \''.LANG.'\' ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'blog.blog_last_update_admin_user_id ' .
										'WHERE '.DATABASE_PREFIX.'blog.blog_active = 1 ' .
										'ORDER BY '.DATABASE_PREFIX.'blog.blog_last_update_date DESC;';
					
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(BLOG_SEARCH_ERROR);
				}
				break;
			}
			case 'BlogSearchTag' : {
				if (isset($args[0])) {
					
					$tag = $args[0];
					
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'blog.blog_id, ' .                                                               // 0
											''.DATABASE_PREFIX.'blog.blog_image_number, ' .                                                     // 1
											''.DATABASE_PREFIX.'blog.blog_image_type, ' .                                                       // 2
											'DATE_FORMAT('.DATABASE_PREFIX.'blog.blog_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .  // 3
											''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .                                                  // 4
											''.DATABASE_PREFIX.'blog_text.blog_text_value, ' .                                                  // 5
											''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .                                                // 6
											''.DATABASE_PREFIX.'admin_user.admin_user_email, ' .                                                // 7
											'DATE_FORMAT('.DATABASE_PREFIX.'blog.blog_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .     // 8
										    ''.DATABASE_PREFIX.'blog.blog_hit ' .                                                              // 9
											'FROM '.DATABASE_PREFIX.'blog ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'blog_text ON '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.DATABASE_PREFIX.'blog.blog_id AND '.DATABASE_PREFIX.'blog_text.blog_text_lang = \''.LANG.'\' ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'blog.blog_last_update_admin_user_id ' .
											'WHERE '.DATABASE_PREFIX.'blog.blog_active = 1 AND ' .
											'('.DATABASE_PREFIX.'blog.blog_id IN (SELECT DISTINCT tag_object_id FROM '.DATABASE_PREFIX.'tag WHERE tag_type = \'blog\' AND UPPER(tag_text) = \''.$tag.'\')) ' .
											'ORDER BY '.DATABASE_PREFIX.'blog.blog_last_update_date DESC;';
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_SEARCH_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			
//////// 		END OF SEARCH/TAG PART
			
//////// 		ACCOUNT ADMINISTRATION PART
			case 'AccountGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_user.admin_user_id, ' .
										    ''.DATABASE_PREFIX.'admin_role.admin_role_name, ' .
										    ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
										    ''.DATABASE_PREFIX.'admin_user.admin_user_email, ' .
										    ''.DATABASE_PREFIX.'admin_user.admin_user_first_name, ' .
										    ''.DATABASE_PREFIX.'admin_user.admin_user_last_name, ' .
										    ''.DATABASE_PREFIX.'admin_user.admin_user_phone, ' .
										    ''.DATABASE_PREFIX.'admin_user.admin_user_lang, ' .
										    ''.DATABASE_PREFIX.'admin_user.admin_user_admin_site_theme_id, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_1, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_2, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_line_3, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_postal_code, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_city, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_region, ' .
										    ''.DATABASE_PREFIX.'admin_user_address.admin_user_address_country ' .
										    'FROM '.DATABASE_PREFIX.'admin_user ' .
										    'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user_address ON '.DATABASE_PREFIX.'admin_user_address.admin_user_address_admin_user_id = '.DATABASE_PREFIX.'admin_user.admin_user_id ' .
										    'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_role ON '.DATABASE_PREFIX.'admin_user.admin_user_admin_role_id = '.DATABASE_PREFIX.'admin_role.admin_role_id ' .
										    'WHERE '.DATABASE_PREFIX.'admin_user.admin_user_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
										    'LIMIT 1;';
							
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_USER_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'AccountRegister' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3])) {
						
					$admin_user_email = strtolower($args[0]);
					$admin_user_password = $args[1];
					$admin_user_lang = $args[2];
					$admin_site_theme_id = $args[3];
			
					$admin_admin_user_id = NULL;
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_admin_user_id = 0;
					}
			
					$admin_user_password = Util::CryptPassword($admin_user_password);
			
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_user (admin_user_id, admin_user_admin_role_id, admin_user_active, admin_user_login, admin_user_password, admin_user_email, admin_user_first_name, admin_user_last_name, admin_user_phone, admin_user_creation_date, admin_user_last_update_date, admin_user_last_update_admin_user_id, admin_user_last_admin_connection_id, admin_user_lang, admin_user_admin_site_theme_id) ' .
								'VALUES ' .
								'(NULL, ' .
								'(SELECT admin_role_id FROM '.DATABASE_PREFIX.'admin_role WHERE admin_role_name = \'User\' LIMIT 1), ' .
								'1, ' .
								''.$this->database->FormatDataToVarchar($admin_user_email, 30).', ' .
								''.$this->database->FormatDataToVarchar($admin_user_password, 30).', ' .
								''.$this->database->FormatDataToVarchar($admin_user_email, 100).', ' .
								'NULL, ' .
								'NULL, ' .
								'NULL, ' .
								'NOW(), ' .
								'NOW(), ' .
								''.$this->database->FormatDataToInteger($admin_admin_user_id).', ' .
								'NULL, ' .
								''.$this->database->FormatDataToVarchar($admin_user_lang, 2).', ' .
								''.$this->database->FormatDataToInteger($admin_site_theme_id).');';
							
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							$admin_user_id = $result[1];
			
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_user_address (admin_user_address_id, admin_user_address_admin_user_id, admin_user_address_line_1, admin_user_address_line_2, admin_user_address_line_3, admin_user_address_postal_code, admin_user_address_city, admin_user_address_region, admin_user_address_country, admin_user_address_creation_date, admin_user_address_last_update_date, admin_user_address_last_update_admin_user_id) ' .
									'VALUES ' .
									'(NULL, ' .
									''.$this->database->FormatDataToInteger($admin_user_id).', ' .
									'NULL, ' .
									'NULL, ' .
									'NULL, ' .
									'NULL, ' .
									'NULL, ' .
									'NULL, ' .
									'NULL, ' .
									'NOW(), ' .
									'NOW(), ' .
									''.$this->database->FormatDataToInteger($admin_admin_user_id).');';
								
							$result = $this->database->InsertQuery($sql_query);
			
							if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
			
								// FINALLY SEND MAIL
								$message = '<?php echo Util::PageGetHtmlTop(); ?>
										      <BODY>
												<TABLE>
													<TR>
														<TD>'.MAIL_ACCOUNT_CREATED_MESSAGE_1.'<B>'.$admin_user_login.'</B>'.MAIL_ACCOUNT_CREATED_MESSAGE_2.'<B>'.$args[1].'</B>'.MAIL_ACCOUNT_CREATED_MESSAGE_3.'<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/login.php" TARGET="_blank">'.SITE_TITLE.'</A>.</TD>
													</TR>
										       	</TABLE>
										      </BODY>
										     </HTML>';
			
								Util::SendMail($admin_user_email, SITE_TITLE.' - '.MAIL_ACCOUNT_CREATED.$admin_user_login, $message);
			
								return $admin_user_id;
							}
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_USER_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ACCOUNT_CREATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AccountAdd' : {
				if (isset($args[0]) &&
				isset($args[1]) &&
				isset($args[2]) &&
				isset($args[3]) &&
				isset($args[4]) &&
				isset($args[5]) &&
				isset($args[6]) &&
				isset($args[7]) &&
				isset($args[8]) &&
				isset($args[11]) &&
				isset($args[12]) &&
				isset($args[14])) {
			
					$admin_user_login = strtolower($args[0]);
					$admin_user_password = $args[1];
					$admin_user_email = strtolower($args[2]);
					$admin_user_first_name = $args[3];
					$admin_user_last_name = $args[4];
					$admin_user_phone = $args[5];
					$admin_user_lang = $args[6];
					$admin_site_theme_id = $args[7];
					$admin_user_address_line_1 = $args[8];
					$admin_user_address_line_2 = $args[9];
					$admin_user_address_line_3 = $args[10];
					$admin_user_address_postal_code = $args[11];
					$admin_user_address_city = $args[12];
					$admin_user_address_region = $args[13];
					$admin_user_address_country = $args[14];
						
					$admin_admin_user_id = NULL;
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_admin_user_id = 0;
					}
						
					$admin_user_password = Util::CryptPassword($admin_user_password);
						
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_user (admin_user_id, admin_user_admin_role_id, admin_user_active, admin_user_login, admin_user_password, admin_user_email, admin_user_first_name, admin_user_last_name, admin_user_phone, admin_user_creation_date, admin_user_last_update_date, admin_user_last_update_admin_user_id, admin_user_last_admin_connection_id, admin_user_lang, admin_user_admin_site_theme_id) ' .
								'VALUES ' .
								'(NULL, ' .
								'(SELECT admin_role_id FROM '.DATABASE_PREFIX.'admin_role WHERE admin_role_name = \'User\' LIMIT 1), ' .
								'1, ' .
								''.$this->database->FormatDataToVarchar($admin_user_login, 30).', ' .
								''.$this->database->FormatDataToVarchar($admin_user_password, 30).', ' .
								''.$this->database->FormatDataToVarchar($admin_user_email, 100).', ' .
								''.$this->database->FormatDataToVarchar($admin_user_first_name, 50).', ' .
								''.$this->database->FormatDataToVarchar($admin_user_last_name, 50).', ' .
								''.$this->database->FormatDataToVarchar($admin_user_phone, 20).', ' .
								'NOW(), ' .
								'NOW(), ' .
								''.$this->database->FormatDataToInteger($admin_admin_user_id).', ' .
								'NULL, ' .
								''.$this->database->FormatDataToVarchar($admin_user_lang, 2).', ' .
								''.$this->database->FormatDataToInteger($admin_site_theme_id).');';
							
						$result = $this->database->InsertQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							$admin_user_id = $result[1];
				
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_user_address (admin_user_address_id, admin_user_address_admin_user_id, admin_user_address_line_1, admin_user_address_line_2, admin_user_address_line_3, admin_user_address_postal_code, admin_user_address_city, admin_user_address_region, admin_user_address_country, admin_user_address_creation_date, admin_user_address_last_update_date, admin_user_address_last_update_admin_user_id) ' .
										'VALUES ' .
										'(NULL, ' .
										''.$this->database->FormatDataToInteger($admin_user_id).', ' .
										''.$this->database->FormatDataToVarchar($admin_user_address_line_1, 50).', ' .
										''.$this->database->FormatDataToVarchar($admin_user_address_line_2, 50).', ' .
										''.$this->database->FormatDataToVarchar($admin_user_address_line_3, 50).', ' .
										''.$this->database->FormatDataToVarchar($admin_user_address_postal_code, 20).', ' .
										''.$this->database->FormatDataToVarchar($admin_user_address_city, 100).', ' .
										''.$this->database->FormatDataToVarchar($admin_user_address_region, 100).', ' .
										''.$this->database->FormatDataToVarchar($admin_user_address_country, 100).', ' .
										'NOW(), ' .
										'NOW(), ' .
										''.$this->database->FormatDataToInteger($admin_admin_user_id).');';
							
							$result = $this->database->InsertQuery($sql_query);
				
							if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
								
								// FINALLY SEND MAIL
								$message = '<?php echo Util::PageGetHtmlTop(); ?>
										      <BODY>
												<TABLE>
													<TR>
														<TD>'.MAIL_ACCOUNT_CREATED_MESSAGE_1.'<B>'.$admin_user_login.'</B>'.MAIL_ACCOUNT_CREATED_MESSAGE_2.'<B>'.$args[1].'</B>'.MAIL_ACCOUNT_CREATED_MESSAGE_3.'<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/login.php" TARGET="_blank">'.SITE_TITLE.'</A>.</TD>
													</TR>
										       	</TABLE>
										      </BODY>
										     </HTML>';
								
								Util::SendMail($admin_user_email, SITE_TITLE.' - '.MAIL_ACCOUNT_CREATED.$admin_user_login, $message);
								
								return $admin_user_id;
							}
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_USER_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ACCOUNT_CREATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AccountUpdate' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3]) &&
					isset($args[4]) &&
					isset($args[5]) &&
					isset($args[6]) &&
					isset($args[7]) &&
					isset($args[8]) &&
					isset($args[9]) &&
					isset($args[12]) &&
					isset($args[13]) &&
					isset($args[15])) {
			
					$admin_user_id = $args[0];
					$admin_user_old_password = $args[1];
					$admin_user_password = $args[2];
					$admin_user_email = strtolower($args[3]);
					$admin_user_first_name = $args[4];
					$admin_user_last_name = $args[5];
					$admin_user_phone = $args[6];
					$admin_user_lang = $args[7];
					$admin_site_theme_id = $args[8];
					$admin_user_address_line_1 = $args[9];
					$admin_user_address_line_2 = $args[10];
					$admin_user_address_line_3 = $args[11];
					$admin_user_address_postal_code = $args[12];
					$admin_user_address_city = $args[13];
					$admin_user_address_region = $args[14];
					$admin_user_address_country = $args[15];
			
					$admin_admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_admin_user_id = 0;
					}
			
					if ($admin_user_old_password != '')
					{
						$password = $this->AdminUserGetPasswordWithUserId($admin_user_id);
						$salt = substr($password, 0, 2);
							
						if (crypt($admin_user_old_password, $salt) == $password) {
			
							$admin_user_password = Util::CryptPassword($admin_user_password);
			
							$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_user SET ' .
												'admin_user_password = '.$this->database->FormatDataToVarchar($admin_user_password, 30).' ' .
												'WHERE admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' LIMIT 1;';
			
							$this->database->UpdateQuery($sql_query);
						} else {
							throw new DataException(ADMIN_USER_OLD_PASSWORD_INCORRECT);
						}
					}
			
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_user SET ' .
										    'admin_user_email = '.$this->database->FormatDataToVarchar($admin_user_email, 100).', ' .
										    'admin_user_first_name = '.$this->database->FormatDataToVarchar($admin_user_first_name, 50).', ' .
										    'admin_user_last_name = '.$this->database->FormatDataToVarchar($admin_user_last_name, 50).', ' .
										    'admin_user_phone = '.$this->database->FormatDataToVarchar($admin_user_phone, 20).', ' .
										    'admin_user_last_update_date = NOW(), ' .
										    'admin_user_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_admin_user_id).', ' .
										    'admin_user_lang = '.$this->database->FormatDataToVarchar($admin_user_lang, 2).', ' .
										    'admin_user_admin_site_theme_id = '.$this->database->FormatDataToInteger($admin_site_theme_id).' ' .
										    'WHERE admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
						
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_user_address (admin_user_address_id, admin_user_address_admin_user_id, admin_user_address_line_1, admin_user_address_line_2, admin_user_address_line_3, admin_user_address_postal_code, admin_user_address_city, admin_user_address_region, admin_user_address_country, admin_user_address_creation_date, admin_user_address_last_update_date, admin_user_address_last_update_admin_user_id) ' .
									'VALUES ' .
									'(NULL, ' .
									''.$this->database->FormatDataToInteger($admin_user_id).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_line_1, 50).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_line_2, 50).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_line_3, 50).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_postal_code, 20).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_city, 100).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_region, 100).', ' .
									''.$this->database->FormatDataToVarchar($admin_user_address_country, 100).', ' .
									'NOW(), ' .
									'NOW(), ' .
									''.$this->database->FormatDataToInteger($admin_admin_user_id).') ON DUPLICATE KEY UPDATE ' .
							        'admin_user_address_line_1 = '.$this->database->FormatDataToVarchar($admin_user_address_line_1, 50).', ' .
									'admin_user_address_line_2 = '.$this->database->FormatDataToVarchar($admin_user_address_line_2, 50).', ' .
									'admin_user_address_line_3 = '.$this->database->FormatDataToVarchar($admin_user_address_line_3, 50).', ' .
									'admin_user_address_postal_code = '.$this->database->FormatDataToVarchar($admin_user_address_postal_code, 20).', ' .
									'admin_user_address_city = '.$this->database->FormatDataToVarchar($admin_user_address_city, 100).', ' .
									'admin_user_address_region = '.$this->database->FormatDataToVarchar($admin_user_address_region, 100).', ' .
									'admin_user_address_country = '.$this->database->FormatDataToVarchar($admin_user_address_country, 100).', ' .
									'admin_user_address_last_update_date = NOW(), ' .
									'admin_user_address_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_admin_user_id);
							
						$this->database->InsertQuery($sql_query);
							
						return $admin_user_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_USER_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_USER_ACCOUNT_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
//////// 		END OF ACCOUNT ADMINISTRATION PART
			
			
//////// 		VERSION ADMINISTRATION PART		
			case 'AdminVersionGetList' : {
				$order = 2;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_version.admin_version_id, ' .
									    ''.DATABASE_PREFIX.'admin_version.admin_version_date, ' .
									    ''.DATABASE_PREFIX.'admin_version.admin_version_number, ' .
									    ''.DATABASE_PREFIX.'admin_version.admin_version_name, ' .
									    ''.DATABASE_PREFIX.'admin_version.admin_version_description, ' .
									    ''.DATABASE_PREFIX.'admin_version.admin_version_last_update_date, ' .
									    ''.DATABASE_PREFIX.'admin_user.admin_user_login ' .
									    'FROM '.DATABASE_PREFIX.'admin_version ' .
									    'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_version.admin_version_last_update_admin_user_id = '.DATABASE_PREFIX.'admin_user.admin_user_id ' .
									    'ORDER BY '.$order.' '.$sort.';';
				
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_VERSION_GET_LIST_ERROR);
				}
				
				break;
			}
			case 'AdminVersionAdd' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
					
					$version_date = $args[0];
					$version_number = $args[1];
					$version_name = $args[2];
					
					if (isset($args[3])) {
						$version_description = $args[3];
					}
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_version (admin_version_id, admin_version_admin_user_id, admin_version_date, admin_version_number, admin_version_name, admin_version_description, admin_version_creation_date, admin_version_last_update_date, admin_version_last_update_admin_user_id) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).', ' .
									 ''.$this->database->FormatDataToDate($version_date, DATABASE_DATE_FORMAT).', ' .
									 ''.$this->database->FormatDataToVarchar($version_number, 10).', ' .
									 ''.$this->database->FormatDataToVarchar($version_name, 50).', ' .
									 ''.$this->database->FormatDataToVarchar($version_description, 4000).', ' .
									 'NOW(), ' .
					        	     'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).');';
					
						$result = $this->database->InsertQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_VERSION_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_VERSION_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminVersionUpdate' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3])) {
					
					$version_id = $args[0];
					$version_date = $args[1];
					$version_number = $args[2];
					$version_name = $args[3];
					$version_description = $args[4];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_version SET ' .
										    'admin_version_date = '.$this->database->FormatDataToDate($version_date, DATABASE_DATE_FORMAT).', ' .
										    'admin_version_number = '.$this->database->FormatDataToVarchar($version_number, 10).', ' .
										    'admin_version_name = '.$this->database->FormatDataToVarchar($version_name, 50).', ' .
										    'admin_version_description = '.$this->database->FormatDataToVarchar($version_description, 4000).', ' .
										    'admin_version_last_update_date = NOW(), ' .
										    'admin_version_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
										    'WHERE admin_version_id = '.$this->database->FormatDataToInteger($version_id).' LIMIT 1;';
					
						$result = $this->database->UpdateQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_VERSION_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_VERSION_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminVersionDelete' : {
				if (isset($args[0])) {
					
					$version_id = $args[0];
					
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_version ' .
									 'WHERE admin_version_id = '.$this->database->FormatDataToInteger($version_id).' LIMIT 1;';
					
						$this->database->DeleteQuery($sql_query);
						
						return $version_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_VERSION_DELETE_ERROR);
					}	
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminVersionGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_version.admin_version_id, ' .
									 'DATE_FORMAT('.DATABASE_PREFIX.'admin_version.admin_version_date, \''.DATABASE_DATE_FORMAT.'\'), ' .
									 ''.DATABASE_PREFIX.'admin_version.admin_version_number, ' . 		
									 ''.DATABASE_PREFIX.'admin_version.admin_version_name, ' . 		
									 ''.DATABASE_PREFIX.'admin_version.admin_version_description ' . 		
									 'FROM '.DATABASE_PREFIX.'admin_version ' .
									 'WHERE '.DATABASE_PREFIX.'admin_version.admin_version_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
									 'LIMIT 1;';
			
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_VERSION_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
//////// 		END OF VERSION ADMINISTRATION PART
			
//////// 		SITE THEME ADMINISTRATION PART
			case 'AdminSiteThemeGetList' : {
				$order = 2;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_id, ' .
								 ''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_code, ' .
								 ''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_name, ' .
								 ''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_last_update_date, ' .
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login ' .
								 'FROM '.DATABASE_PREFIX.'admin_site_theme ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_last_update_admin_user_id = '.DATABASE_PREFIX.'admin_user.admin_user_id ' .
								 'ORDER BY '.$order.' '.$sort.';';
				
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_SITE_THEME_GET_LIST_ERROR);
				}
				break;
			}
			case 'AdminSiteThemeDisplayList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_id, ' .
										''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_name ' .
										'FROM '.DATABASE_PREFIX.'admin_site_theme ' .
										'ORDER BY '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_name;';
			
					return $this->database->PrintSelectOption($sql_query,$args[0], true);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_SITE_THEME_DISPLAY_LIST_ERROR);
				}
				break;
			}
			case 'AdminSiteThemeAdd' : {
				if (isset($args[0]) &&
					isset($args[1])) {
					
					$site_theme_code = $args[0];
					$site_theme_name = $args[1];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_site_theme (admin_site_theme_id, admin_site_theme_code, admin_site_theme_name, admin_site_theme_creation_date, admin_site_theme_last_update_date, admin_site_theme_last_update_admin_user_id) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToVarchar($site_theme_code, 4).', ' .
									 ''.$this->database->FormatDataToVarchar($site_theme_name, 50).', ' .
									 'NOW(), ' .
					        	     'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).');';
					
						$result = $this->database->InsertQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_SITE_THEME_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_SITE_THEME_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminSiteThemeUpdate' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
					
					$site_theme_id = $args[0];
					$site_theme_code = $args[1];
					$site_theme_name = $args[2];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_site_theme SET ' .
									 'admin_site_theme_code = '.$this->database->FormatDataToVarchar($site_theme_code, 4).', ' .
									 'admin_site_theme_name = '.$this->database->FormatDataToVarchar($site_theme_name, 50).', ' .
									 'admin_site_theme_last_update_date = NOW(), ' .
									 'admin_site_theme_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE admin_site_theme_id = '.$this->database->FormatDataToInteger($site_theme_id).' LIMIT 1;';
					
						$this->database->UpdateQuery($sql_query);
						
						return $site_theme_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_SITE_THEME_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_SITE_THEME_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminSiteThemeDelete' : {
				if (isset($args[0])) {
					
					$site_theme_id = $args[0];
					
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_site_theme ' .
									 'WHERE admin_site_theme_id = '.$this->database->FormatDataToInteger($site_theme_id).' LIMIT 1;';
					
						$result = $this->database->DeleteQuery($sql_query);
						
						return $site_theme_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_SITE_THEME_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminSiteThemeGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_id, ' .
											''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_code, ' .
											''.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_name ' .
											'FROM '.DATABASE_PREFIX.'admin_site_theme ' .
											'WHERE '.DATABASE_PREFIX.'admin_site_theme.admin_site_theme_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
											'LIMIT 1;';
			
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TYPE_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
//////// 		END OF SITE THEME ADMINISTRATION PART
			
//////// 		TYPE & TYPE 2 ADMINISTRATION PART			
			case 'ItemTypeGetList' : {
				$order = 2;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item_type.item_type_id, ' .
					             ''.DATABASE_PREFIX.'item_type.item_type_name, ' .
					             ''.DATABASE_PREFIX.'item_type.item_type_logo_filename, ' .
					             ''.DATABASE_PREFIX.'item_type.item_type_last_update_date, ' .
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login ' .
								 'FROM '.DATABASE_PREFIX.'item_type ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'item_type.item_type_last_update_admin_user_id ' .
								 'ORDER BY '.$order.' '.$sort.';';
				
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ITEM_TYPE_GET_LIST);
				}
				
				break;
			}
			case 'ItemType2GetList' : {
				$order = 2;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item_type_2.item_type_2_id, ' .
					             ''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .
					             ''.DATABASE_PREFIX.'item_type_2.item_type_2_logo_filename, ' .
					             ''.DATABASE_PREFIX.'item_type_2.item_type_2_last_update_date, ' .
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login ' .
								 'FROM '.DATABASE_PREFIX.'item_type_2 ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'item_type_2.item_type_2_last_update_admin_user_id ' .
								 'ORDER BY '.$order.' '.$sort.';';
				
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ITEM_TYPE_2_GET_LIST);
				}
				
				break;
			}
			case 'ItemTypeDisplayList' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT item_type_id, item_type_name FROM '.DATABASE_PREFIX.'item_type ORDER BY item_type_name;';
				
						return $this->database->PrintTranslatedSelectOption($sql_query,$args[0], true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_TYPE_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'ItemType2DisplayList' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT item_type_2_id, item_type_2_name FROM '.DATABASE_PREFIX.'item_type_2 ORDER BY item_type_2_name;';
				
						return $this->database->PrintTranslatedSelectOption($sql_query,$args[0], true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_TYPE_2_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'ItemTypeAdd' : {
				if (isset($args[0])) {
						
					$item_type_name = $args[0];
					$item_type_logo_filename = $args[1];
						
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_type (item_type_id, item_type_name, item_type_logo_filename, item_type_creation_date, item_type_last_update_date, item_type_last_update_admin_user_id) ' .
								   	 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToVarchar($item_type_name, 50).', ' .
									 ''.$this->database->FormatDataToVarchar($item_type_logo_filename, 100).', ' .
									 'NOW(), ' .
									 'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).');';
							
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ITEM_TYPE_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_TYPE_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemType2Add' : {
				if (isset($args[0])) {
						
					$item_type_2_name = $args[0];
					$item_type_2_logo_filename = $args[1];
						
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_type_2 (item_type_2_id, item_type_2_name, item_type_2_logo_filename, item_type_2_creation_date, item_type_2_last_update_date, item_type_2_last_update_admin_user_id) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToVarchar($item_type_2_name, 50).', ' .
									 ''.$this->database->FormatDataToVarchar($item_type_2_logo_filename, 100).', ' .
									 'NOW(), ' .
									 'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).');';
						
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ITEM_TYPE_2_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_TYPE_2_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemTypeUpdate' : {
				if (isset($args[0]) &&
					isset($args[1])) {
						
					$item_type_id = $args[0];
					$item_type_name = $args[1];
					$item_type_logo_filename = $args[2];
						
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'item_type SET ' .
									 'item_type_name = '.$this->database->FormatDataToVarchar($item_type_name, 50).', ' .
									 'item_type_logo_filename = '.$this->database->FormatDataToVarchar($item_type_logo_filename, 100).', ' .
									 'item_type_last_update_date = NOW(), ' .
									 'item_type_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE item_type_id = '.$this->database->FormatDataToInteger($item_type_id).' LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
			
						return $item_type_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ITEM_TYPE_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_TYPE_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemType2Update' : {
				if (isset($args[0]) &&
					isset($args[1])) {
						
					$item_type_2_id = $args[0];
					$item_type_2_name = $args[1];
					$item_type_2_logo_filename = $args[2];
						
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'item_type_2 SET ' .
									 'item_type_2_name = '.$this->database->FormatDataToVarchar($item_type_2_name, 50).', ' .
									 'item_type_2_logo_filename = '.$this->database->FormatDataToVarchar($item_type_2_logo_filename, 100).', ' .
									 'item_type_2_last_update_date = NOW(), ' .
									 'item_type_2_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE item_type_2_id = '.$this->database->FormatDataToInteger($item_type_2_id).' LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
			
						return $item_type_2_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ITEM_TYPE_2_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_TYPE_2_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemTypeDelete' : {
				if (isset($args[0])) {
						
					$item_type_id = $args[0];
						
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'item_type ' .
									 'WHERE item_type_id = '.$this->database->FormatDataToInteger($item_type_id).' LIMIT 1;';
							
						$this->database->DeleteQuery($sql_query);
			
						return $item_type_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1451) {
							throw new DataException(ITEM_TYPE_DELETE_CONSTRAINT);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_TYPE_DELETE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemType2Delete' : {
				if (isset($args[0])) {
						
					$item_type_2_id = $args[0];
						
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'item_type_2 ' .
									 'WHERE item_type_2_id = '.$this->database->FormatDataToInteger($item_type_2_id).' LIMIT 1;';
							
						$this->database->DeleteQuery($sql_query);
			
						return $item_type_2_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1451) {
							throw new DataException(ITEM_TYPE_2_DELETE_CONSTRAINT);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_TYPE_2_DELETE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemTypeGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item_type.item_type_id, ' .
									 ''.DATABASE_PREFIX.'item_type.item_type_name, ' .
									 ''.DATABASE_PREFIX.'item_type.item_type_logo_filename ' .
									 'FROM '.DATABASE_PREFIX.'item_type ' .
									 'WHERE '.DATABASE_PREFIX.'item_type.item_type_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
									 'LIMIT 1;';
							
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TYPE_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemType2Get' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item_type_2.item_type_2_id, ' .
									 ''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .
									 ''.DATABASE_PREFIX.'item_type_2.item_type_2_logo_filename ' .
									 'FROM '.DATABASE_PREFIX.'item_type_2 ' .
									 'WHERE '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
									 'LIMIT 1;';
							
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TYPE_2_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemTypeGetName' : {
				if (isset($args[0])) {
					$item_type_id = $args[0];
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item_type.item_type_name ' .                                //   0
								'FROM '.DATABASE_PREFIX.'item_type ' .
								'WHERE '.DATABASE_PREFIX.'item_type.item_type_id = '.$this->database->FormatDataToInteger($item_type_id).' LIMIT 1;';
							
						$result = $this->database->SelectSingleValueQuery($sql_query);
			
						if ($result != '') {
							return constant($result);
						} else {
							return '';
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_TYPE_GET_NAME);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemTypeGetInformation' : {
				if (isset($args[0])) {
					$item_type_id = $args[0];
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item_type.item_type_name, ' .                                //   0
											''.DATABASE_PREFIX.'item_type.item_type_logo_filename ' .                                 //   1
											'FROM '.DATABASE_PREFIX.'item_type ' .
											'WHERE '.DATABASE_PREFIX.'item_type.item_type_id = '.$this->database->FormatDataToInteger($item_type_id).' LIMIT 1;';
							
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_TYPE_GET_INFORMATION);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemType2GetName' : {
				if (isset($args[0])) {
					$item_type_2_id = $args[0];
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item_type_2.item_type_2_name ' .                                //   0
								'FROM '.DATABASE_PREFIX.'item_type_2 ' .
								'WHERE '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.$this->database->FormatDataToInteger($item_type_2_id).' LIMIT 1;';
							
						$result = $this->database->SelectSingleValueQuery($sql_query);
			
						if ($result != '') {
							return constant($result);
						} else {
							return '';
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_TYPE_2_GET_NAME);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemType2GetInformation' : {
				if (isset($args[0])) {
					$item_type_2_id = $args[0];
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .                                //   0
											''.DATABASE_PREFIX.'item_type_2.item_type_2_logo_filename ' .                       //   1
											'FROM '.DATABASE_PREFIX.'item_type_2 ' .
											'WHERE '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.$this->database->FormatDataToInteger($item_type_2_id).' LIMIT 1;';
							
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ITEM_TYPE_2_GET_INFORMATION);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}

//////// 		END OF TYPE & TYPE 2 ADMINISTRATION PART
			
			
//////// 		ITEM ADMINISTRATION PART
			case 'ItemGetText' : {
				if (isset($args[0])) {
					try {
						if (isset($args[1])) {
							$sql_query = 'SELECT '.DATABASE_PREFIX.'item_text.item_text_id, ' .
										 ''.DATABASE_PREFIX.'item_text.item_text_lang, ' .
										 ''.DATABASE_PREFIX.'item_text.item_text_value ' .
										 'FROM '.DATABASE_PREFIX.'item_text ' .
										 'WHERE '.DATABASE_PREFIX.'item_text.item_text_item_id = '.$this->database->FormatDataToInteger($args[0]).' AND ' .
										 ''.DATABASE_PREFIX.'item_text.item_text_lang = '.$this->database->FormatDataToVarchar($args[1], 2).' ' .
										 'LIMIT 1;';
						} else {
							$sql_query = 'SELECT '.DATABASE_PREFIX.'item_text.item_text_id, ' .
										 ''.DATABASE_PREFIX.'item_text.item_text_lang, ' .
										 ''.DATABASE_PREFIX.'item_text.item_text_value ' .
										 'FROM '.DATABASE_PREFIX.'item_text ' .
										 'WHERE '.DATABASE_PREFIX.'item_text.item_text_item_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
										 'LIMIT 1;';
						}
			
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TEXT_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'ItemTagGetList' : {
				if (isset($args[0])) {
			
					$item_id = $args[0];
						
					try {
						$sql_query = 'SELECT tag_text ' .
											'FROM '.DATABASE_PREFIX.'tag ' .
											'WHERE tag_object_id = '.$this->database->FormatDataToInteger($item_id).' AND tag_type = \'item\' ' .
											'ORDER BY tag_text;';
			
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TAG_GET_LIST_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemAddTag' : {
				if (isset($args[0]) &&
					isset($args[1])) {
						
					$admin_user_id = NULL;
					
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'tag (tag_id, tag_type, tag_object_id, tag_text, tag_creation_date, tag_last_update_date, tag_last_update_admin_user_id) ' .
													'VALUES ' .
													'(NULL, ' .
													'\'item\', ' .
													''.$this->database->FormatDataToInteger($args[0]).', ' .
													''.$this->database->FormatDataToVarchar($args[1], 50).', ' .
													'NOW(), ' .
													'NOW(), ' .
													''.$this->database->FormatDataToInteger($admin_user_id).') ON DUPLICATE KEY UPDATE ' .
													'tag_last_update_date = NOW(), ' .
													'tag_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id);
							
						$result = $this->database->InsertQuery($sql_query);
	
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TAG_ADD_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemDeleteTag' : {
				if (isset($args[0]) &&
					isset($args[1])) {
		
						try {
							$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'tag ' .
										 'WHERE tag_type = \'item\' AND ' .
									 	 'tag_object_id = '.$this->database->FormatDataToInteger($args[0]).' AND ' .
									 	 'tag_text = '.$this->database->FormatDataToVarchar($args[1], 50).' LIMIT 1;';
						
							$this->database->DeleteQuery($sql_query);
							return $args[0];
						} catch (SqlException $ex) {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ITEM_TAG_DELETE_ERROR);
						}
					} else {
						throw new DataException(MISSING_ARGUMENT_ERROR);
					}
					break;
			}
			case 'ItemAddText' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'item_text (item_text_id, item_text_item_id, item_text_lang, item_text_value) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToInteger($args[0]).', ' .
									 ''.$this->database->FormatDataToVarchar($args[1], 2).', ' .
									 ''.$this->database->FormatDataToVarchar($args[2], 10000).');';
			
						$result = $this->database->InsertQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TEXT_ADD_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'ItemUpdateText' : {
				if (isset($args[0]) &&
					isset($args[1])) {
					
					$item_text_id = $args[0];
					$item_text_value = $args[1];
					
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'item_text SET ' .
								     'item_text_value = '.$this->database->FormatDataToVarchar($item_text_value, 10000).' ' .
									 'WHERE item_text_id = '.$this->database->FormatDataToInteger($item_text_id).' ' .
									 'LIMIT 1;';
						
						$this->database->UpdateQuery($sql_query);
						return $item_text_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TEXT_UPDATE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				
				break;
			}
			case 'ItemDeleteText' : {
				if (isset($args[0])) {
					
					$item_text_id = $args[0];
					
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'item_text ' .
									 'WHERE item_text_id = '.$this->database->FormatDataToInteger($item_text_id).' ' .
								     'LIMIT 1;';
			
						$this->database->DeleteQuery($sql_query);
						return $item_text_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_TEXT_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'ItemDelete' : {
				if (isset($args[0])) {
					$item_id = $args[0];
			
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'item_text ' .
									 'WHERE item_text_item_id = '.$this->database->FormatDataToInteger($item_id).';';
			
						$result = $this->database->DeleteQuery($sql_query);
						
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'item_specific ' .
									 'WHERE item_specific_item_id = '.$this->database->FormatDataToInteger($item_id).';';
						
						$result = $this->database->DeleteQuery($sql_query);
						
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'item_image ' .
									 'WHERE item_image_item_id = '.$this->database->FormatDataToInteger($item_id).';';
						
						$result = $this->database->DeleteQuery($sql_query);
			
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'item ' .
									 'WHERE item_id = '.$this->database->FormatDataToInteger($item_id).' LIMIT 1;';
			
						$this->database->DeleteQuery($sql_query);
						return $item_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemActivate' : {
				if (isset($args[0])) {
					
					$item_id = $args[0];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$value = '0';
						
						$sql_query = 'SELECT item_active FROM '.DATABASE_PREFIX.'item WHERE item_id = '.$this->database->FormatDataToInteger($item_id).' LIMIT 1;';
						$result = $this->database->SelectSingleValueQuery($sql_query);
						
						if ($result == '0') {
							$value = '1';
						}
						
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'item SET ' .
									 'item_active = '.$value.', ' .
									 'item_last_update_date = NOW(), ' .
									 'item_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE item_id = '.$this->database->FormatDataToInteger($item_id).' LIMIT 1;';
					
						$this->database->UpdateQuery($sql_query);
						
						return $item_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_ACTIVATE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemAddHit' : {
				if (isset($args[0])) {
					
					$item_id = $args[0];
					
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'item SET ' .
									 'item_hit = item_hit + 1 ' .
									 'WHERE item_id = '.$this->database->FormatDataToInteger($item_id).' LIMIT 1;';
					
						$this->database->UpdateQuery($sql_query);
						return $item_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_ADD_HIT_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ItemResetHit' : {
				if (isset($args[0])) {
					
					$item_id = $args[0];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'item SET ' .
									 'item_hit = 0, ' .
									 'item_last_update_date = NOW(), ' .
									 'item_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE item_id = '.$this->database->FormatDataToInteger($item_id).' LIMIT 1;';
					
						$this->database->UpdateQuery($sql_query);
						return $item_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ITEM_RESET_HIT_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ImageGetList' : {
				if (isset($args[0]) &&
					isset($args[1])) {
						
					$object_id = $args[0];
					$object_type = $args[1];
			
					try {
						$sql_query = 'SELECT image_id, ' .
									 'image_number, ' .
									 'image_format, ' .
									 'image_copyright_title, ' .
									 'image_copyright_link, ' .
									 'DATE_FORMAT(image_copyright_date, \''.DATABASE_DATE_YEAR_FORMAT.'\') ' .
									 'FROM '.DATABASE_PREFIX.'image ' .
									 'WHERE image_object_id = '.$this->database->FormatDataToInteger($object_id).' ' .
									 'AND image_type = '.$this->database->FormatDataToVarchar($object_type, 20).' ' .
									 'AND image_top = 0 ' .
									 'ORDER BY image_number;';
								
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(IMAGE_GET_LIST_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ImageGetFirst' : {
				if (isset($args[0]) &&
					isset($args[1])) {
						
					$object_id = $args[0];
					$object_type = $args[1];
						
					try {
						$sql_query = 'SELECT image_id, ' .
									 'image_number, ' .
									 'image_format, ' .
									 'image_copyright_title, ' .
									 'image_copyright_link, ' .
									 'DATE_FORMAT(image_copyright_date, \''.DATABASE_DATE_YEAR_FORMAT.'\') ' .
									 'FROM '.DATABASE_PREFIX.'image ' .
									 'WHERE image_object_id = '.$this->database->FormatDataToInteger($object_id).' ' .
									 'AND image_type = '.$this->database->FormatDataToVarchar($object_type, 20).' ' .
									 'AND image_top = 1 ' .
									 'LIMIT 1;';
						
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(IMAGE_GET_FIRST_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ImageAdd' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3]) &&
					isset($args[4])) {
						
					try {
						$type = $args[0];
						$object_id = $args[1];
						$tmp_name = $args[2];
						$is_first = $args[3];
						$is_full_path = $args[4];
						$image_copyright_title = '';
						if (isset($args[5])) {
							$image_copyright_title = $args[5];
						}
						$image_copyright_link = '';
						if (isset($args[6])) {
							$image_copyright_link = $args[6];
						}
						$image_copyright_date = '';
						if (isset($args[7])) {
							$image_copyright_date = $args[7];
						}
			
						$admin_user_id = NULL;
							
						if (isset($_SESSION[SITE_ID]['user_id'])) {
							$admin_user_id = $_SESSION[SITE_ID]['user_id'];
						} else {
							$admin_user_id = 0;
						}
							
						$imageFile = new Image();
			
						if ($is_full_path) {
							$imageFile->load($tmp_name);
						} else {
							$imageFile->load(IMAGE_FULL_DIRECTORY.$tmp_name);
						}
			
			
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_default SET admin_default_value = admin_default_value + 1 WHERE admin_default_name = \'TMP_IMAGE_ID\' LIMIT 1;';
						$this->database->UpdateQuery($sql_query);
			
						$sql_query = 'SELECT admin_default_value FROM '.DATABASE_PREFIX.'admin_default WHERE admin_default_name = \'TMP_IMAGE_ID\' LIMIT 1;';
						$image_number = $this->database->SelectSingleValueQuery($sql_query);
			
						$imageFile->resizeAndKeepRatio($_SESSION[SITE_ID]['admin_configuration_image_full_width'], $_SESSION[SITE_ID]['admin_configuration_image_full_height']);
						$imageFile->save(IMAGE_FULL_DIRECTORY.$image_number.'.'.$imageFile->GetType());
						$imageFile->resizeAndKeepRatio($_SESSION[SITE_ID]['admin_configuration_image_medium_width'], $_SESSION[SITE_ID]['admin_configuration_image_medium_height']);
						$imageFile->save(IMAGE_MEDIUM_DIRECTORY.$image_number.'.'.$imageFile->GetType());
						$imageFile->resizeAndKeepRatio($_SESSION[SITE_ID]['admin_configuration_image_little_width'], $_SESSION[SITE_ID]['admin_configuration_image_little_height']);
						$imageFile->save(IMAGE_LITLLE_DIRECTORY.$image_number.'.'.$imageFile->GetType());
			
						if ($is_first == 1) {
							$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'image ' .
										 'WHERE image_object_id = '.$this->database->FormatDataToInteger($object_id).' ' .
										 'AND image_type = '.$this->database->FormatDataToVarchar($type, 20).' ' .
										 'AND image_top = 1 ' .
										 'LIMIT 1;';
							
							$this->database->DeleteQuery($sql_query);
						}
			
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'image (image_id, ' .
																		   'image_type, ' .
																		   'image_object_id, ' .
																		   'image_number, ' .
																		   'image_top, ' .
																		   'image_format, ' .
																		   'image_copyright_title, ' .
																		   'image_copyright_link, ' .
																		   'image_copyright_date, ' .
																		   'image_creation_date, ' .
																		   'image_last_update_date, ' .
																		   'image_last_update_admin_user_id) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToVarchar($type, 20).', ' .
									 ''.$this->database->FormatDataToInteger($object_id).', ' .
									 ''.$this->database->FormatDataToInteger($image_number).', ' .
									 ''.$is_first.', ' .
									 ''.$this->database->FormatDataToVarchar($imageFile->GetType(), 20).', ' .
									 ''.$this->database->FormatDataToVarchar($image_copyright_title, 100).', ' .
									 ''.$this->database->FormatDataToVarchar($image_copyright_link, 200).', ' .
									 ''.$this->database->FormatDataToDate($image_copyright_date, DATABASE_DATE_FORMAT).', ' .
									 'NOW(), ' .
									 'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).');';
			
						$result = $this->database->InsertQuery($sql_query);
						$result = $result[1].'|'.$image_number.'.'.$imageFile->GetType();
			
						$imageFile = null;
			
						return $result;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(IMAGE_ADD_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'ImageUpdate' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3])) {
		
						try {
							$image_id = $args[0];
							$image_copyright_link = $args[1];
							$image_copyright_title = $args[2];
							$image_copyright_date = $args[3];
								
							$admin_user_id = NULL;
								
							if (isset($_SESSION[SITE_ID]['user_id'])) {
								$admin_user_id = $_SESSION[SITE_ID]['user_id'];
							} else {
								$admin_user_id = 0;
							}
								
							$sql_query = 'UPDATE '.DATABASE_PREFIX.'image SET ' .
										 'image_copyright_title = '.$this->database->FormatDataToVarchar($image_copyright_title, 100).', ' .
										 'image_copyright_link = '.$this->database->FormatDataToVarchar($image_copyright_link, 200).', ' .
										 'image_copyright_date = '.$this->database->FormatDataToDate($image_copyright_date, DATABASE_DATE_FORMAT).', ' .
										 'image_last_update_date = NOW(), ' .
										 'image_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
										 'WHERE image_id = '.$this->database->FormatDataToInteger($image_id).' LIMIT 1;';
								
							$this->database->UpdateQuery($sql_query);
							return $image_id;
						} catch (SqlException $ex) {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(IMAGE_UPDATE_ERROR);
						}
					} else {
						throw new DataException(MISSING_ARGUMENT_ERROR);
					}
						
					break;
			}
			case 'ImageDelete' : {
				if (isset($args[0]) &&
					isset($args[0])) {
					try {
						$image_id = $args[0];
						$filename = $args[1];
			
						$imageFile = new Image();
			
						$imageFile->delete(IMAGE_FULL_DIRECTORY.$filename);
						$imageFile->delete(IMAGE_MEDIUM_DIRECTORY.$filename);
						$imageFile->delete(IMAGE_LITLLE_DIRECTORY.$filename);
			
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'image ' .
									 'WHERE image_id = '.$this->database->FormatDataToInteger($image_id).' LIMIT 1;';
			
						$result = $this->database->DeleteQuery($sql_query);
			
						return $filename;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(IMAGE_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'ImageLink' : {
				if (isset($args[0]) &&
					isset($args[1])) {
		
					try {
						$image_id = $args[0];
						$object_id = $args[1];
							
						$admin_user_id = NULL;
							
						if (isset($_SESSION[SITE_ID]['user_id'])) {
							$admin_user_id = $_SESSION[SITE_ID]['user_id'];
						} else {
							$admin_user_id = 0;
						}
						
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'image SET ' .
											 'image_object_id = '.$this->database->FormatDataToInteger($object_id).', ' .
											 'image_last_update_date = NOW(), ' .
										 	 'image_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
										     'WHERE image_id = '.$this->database->FormatDataToInteger($image_id).' LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
						return $image_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(IMAGE_LINK_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
//////// 		END OF ITEM ADMINISTRATION PART
			
//////// 		BLOG ADMINISTRATION PART
			case 'BlogAddHit' : {
				if (isset($args[0])) {
			
					$blog_id = $args[0];
			
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'blog SET ' .
									 'blog_hit = blog_hit + 1 ' .
									 'WHERE blog_id = '.$this->database->FormatDataToInteger($blog_id).' LIMIT 1;';
			
						$this->database->UpdateQuery($sql_query);
						return $blog_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_ADD_HIT_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BlogResetHit' : {
				if (isset($args[0])) {
			
					$blog_id = $args[0];
			
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
			
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'blog SET ' .
									 'blog_hit = 0, ' .
									 'blog_last_update_date = NOW(), ' .
									 'blog_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE blog_id = '.$this->database->FormatDataToInteger($blog_id).' LIMIT 1;';
			
						$this->database->UpdateQuery($sql_query);
						return $blog_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_RESET_HIT_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BlogActivate' : {
				if (isset($args[0])) {
						
					$blog_id = $args[0];
						
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$value = '0';
							
						$sql_query = 'SELECT blog_active FROM '.DATABASE_PREFIX.'blog WHERE blog_id = '.$this->database->FormatDataToInteger($blog_id).' LIMIT 1;';
						$result = $this->database->SelectSingleValueQuery($sql_query);
							
						if ($result == '0') {
							$value = '1';
						}
							
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'blog SET ' .
									 'blog_active = '.$value.', ' .
									 'blog_last_update_date = NOW(), ' .
									 'blog_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE blog_id = '.$this->database->FormatDataToInteger($blog_id).' LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
							
						return $blog_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_ACTIVATE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BlogAdd' : {
				if (isset($args[0]) &&
				isset($args[1]) &&
				isset($args[2]) &&
				isset($args[3])) {
						
					$blog_active = $args[0];
					$blog_text_lang = $args[1];
					$blog_text_title = $args[2];
					$blog_text_value = $args[3];
					$first_image_id = $args[4];
					$image_id = $args[5];
					$tag_list_value = $args[6];
						
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'blog (blog_id, blog_active, blog_creation_date, blog_last_update_date, blog_last_update_admin_user_id, blog_hit) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToBoolean($blog_active).', ' .
									 'NOW(), ' .
									 'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).', ' .
									 '0);';
							
						$result = $this->database->InsertQuery($sql_query);
							
						$blog_id = $result[1];
							
						/* TEXT PART */
						if ($blog_text_title != '' && $blog_text_value!= '') {
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'blog_text (blog_text_id, blog_text_blog_id, blog_text_lang, blog_text_title, blog_text_value) ' .
										 'VALUES ' .
										 '(NULL, ' .
										 ''.$this->database->FormatDataToInteger($blog_id).', ' .
										 ''.$this->database->FormatDataToVarchar($blog_text_lang, 2).', ' .
										 ''.$this->database->FormatDataToVarchar($blog_text_title, 300).', ' .
										 ''.$this->database->FormatDataToVarchar($blog_text_value, 10000).');';
								
							$result = $this->database->InsertQuery($sql_query);
						}
						/* END OF TEXT PART */
						
						/* IMAGE PART */
						if ($first_image_id != '') {
							$this->ImageLink($first_image_id, $blog_id);
						}
							
						if ($image_id != '') {
							$image_list = explode(';',$image_id);
						
							foreach ($image_list as $image) {
								$this->ImageLink($image, $blog_id);
							}
						}
						/* END OF IMAGE PART */
						
						/* TAG PART */
						if ($tag_list_value != '') {
							$tag_list = explode(';',$tag_list_value);
						
							foreach ($tag_list as $tag) {
								if ($tag != '') {
									$this->BlogAddTag($blog_id, $tag);
								}
							}
						}
						/* END OF TAG PART */
						
						Util::AdminGenerateSiteMap();
						return $blog_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(BLOG_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(BLOG_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BlogUpdate' : {
				if (isset($args[0]) &&
					isset($args[1])) {
						
					$blog_id = $args[0];
					$blog_active = $args[1];
					$blog_text_id = $args[2];
					$blog_text_lang = $args[3];
					$blog_text_title = $args[4];
					$blog_text_value = $args[5];
						
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'blog SET ' .
									 'blog_active = '.$this->database->FormatDataToBoolean($blog_active).', ' .
									 'blog_last_update_date = NOW(), ' .
									 'blog_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE blog_id = '.$this->database->FormatDataToInteger($blog_id).' LIMIT 1;';
							
						$result = $this->database->UpdateQuery($sql_query);
			
						/* TEXT PART */
						if (($blog_text_lang != '') && (($blog_text_title != '') || ($blog_text_value != ''))) {
							if ($blog_text_id == '') {
								$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'blog_text (blog_text_id, blog_text_blog_id, blog_text_lang, blog_text_title, blog_text_value) ' .
											 'VALUES ' .
											 '(NULL, ' .
											 ''.$this->database->FormatDataToInteger($blog_id).', ' .
											 ''.$this->database->FormatDataToVarchar($blog_text_lang, 2).', ' .
											 ''.$this->database->FormatDataToVarchar($blog_text_title, 300).', ' .
											 ''.$this->database->FormatDataToVarchar($blog_text_value, 10000).');';
			
								$result = $this->database->InsertQuery($sql_query);
							} else {
								$sql_query = 'UPDATE '.DATABASE_PREFIX.'blog_text ' .
											 'SET blog_text_lang = '.$this->database->FormatDataToVarchar($blog_text_lang, 2).', ' .
											 'blog_text_title = '.$this->database->FormatDataToVarchar($blog_text_title, 300).', ' .
											 'blog_text_value = '.$this->database->FormatDataToVarchar($blog_text_value, 10000).' ' .
											 'WHERE blog_text_id = '.$this->database->FormatDataToInteger($blog_text_id).' LIMIT 1;';
			
								$result = $this->database->UpdateQuery($sql_query);
							}
						}
						/* END OF TEXT PART */
			
						Util::AdminGenerateSiteMap();
						return $blog_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(BLOG_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(BLOG_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BlogGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'blog.blog_id, ' .
									 ''.DATABASE_PREFIX.'blog.blog_active, ' .
									 'DATE_FORMAT('.DATABASE_PREFIX.'blog.blog_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .
									 ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
									 ''.DATABASE_PREFIX.'admin_user.admin_user_email, ' .
									 'DATE_FORMAT('.DATABASE_PREFIX.'blog.blog_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .
									 ''.DATABASE_PREFIX.'blog.blog_hit ' .
									 'FROM '.DATABASE_PREFIX.'blog ' .
									 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'blog.blog_last_update_admin_user_id ' .
									 'WHERE '.DATABASE_PREFIX.'blog.blog_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
									 'LIMIT 1;';
			 
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'BlogGetText' : {
				if (isset($args[0])) {
					try {
						if (isset($args[1])) {
							$sql_query = 'SELECT '.DATABASE_PREFIX.'blog_text.blog_text_id, ' .
										 ''.DATABASE_PREFIX.'blog_text.blog_text_lang, ' .
										 ''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .
										 ''.DATABASE_PREFIX.'blog_text.blog_text_value ' .
										 'FROM '.DATABASE_PREFIX.'blog_text ' .
										 'WHERE '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.$this->database->FormatDataToInteger($args[0]).' AND ' .
										 ''.DATABASE_PREFIX.'blog_text.blog_text_lang = '.$this->database->FormatDataToVarchar($args[1], 2).' ' .
										 'LIMIT 1;';
						} else {
							$sql_query = 'SELECT '.DATABASE_PREFIX.'blog_text.blog_text_id, ' .
										 ''.DATABASE_PREFIX.'blog_text.blog_text_lang, ' .
										 ''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .
										 ''.DATABASE_PREFIX.'blog_text.blog_text_value ' .
										 'FROM '.DATABASE_PREFIX.'blog_text ' .
										 'WHERE '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.$this->database->FormatDataToInteger($args[0]).' AND ' .
										 ''.DATABASE_PREFIX.'blog_text.blog_text_lang = \''.LANG.'\' ' .
										 'LIMIT 1;';
						}
							
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_GET_TEXT_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'BlogGetMultilanguageText' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'blog_text.blog_text_blog_id, ' .
									 ''.DATABASE_PREFIX.'blog_text.blog_text_lang, ' .
									 ''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .
									 ''.DATABASE_PREFIX.'blog_text.blog_text_value ' .
									 'FROM '.DATABASE_PREFIX.'blog_text ' .
									 'WHERE '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.$this->database->FormatDataToInteger($args[0]);
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_GET_MULTILANGUAGE_TEXT_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'BlogAddText' : {
				if (isset($args[0]) &&
				isset($args[1]) &&
				isset($args[2]) &&
				isset($args[3])) {
					try {
						$blog_text_blog_id = $args[0];
						$blog_text_lang = $args[1];
						$blog_text_title = $args[2];
						$blog_text_value = $args[3];
			
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'blog_text (blog_text_id, blog_text_blog_id, blog_text_lang, blog_text_title, blog_text_value) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToInteger($blog_text_blog_id).' , ' .
									 ''.$this->database->FormatDataToVarchar($blog_text_lang, 2).' , ' .
									 ''.$this->database->FormatDataToVarchar($blog_text_title, 300).' , ' .
									 ''.$this->database->FormatDataToVarchar($blog_text_value, 10000).');';
			
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_TEXT_ADD_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'BlogUpdateText' : {
				if (isset($args[0]) &&
				isset($args[1]) &&
				isset($args[2])) {
					try {
						$blog_text_id = $args[0];
						$blog_text_title = $args[1];
						$blog_text_value = $args[2];
			
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'blog_text SET ' .
									 'blog_text_title = '.$this->database->FormatDataToVarchar($args[1], 300).', ' .
									 'blog_text_value = '.$this->database->FormatDataToVarchar($args[2], 10000).' ' .
									 'WHERE blog_text_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
									 'LIMIT 1;';
			
						$this->database->UpdateQuery($sql_query);
						return $blog_text_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_TEXT_UPDATE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'BlogDeleteText' : {
				if (isset($args[0])) {
					try {
						$blog_text_id = $args[0];
			
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'blog_text ' .
									 'WHERE blog_text_id = '.$this->database->FormatDataToInteger($blog_text_id).' ' .
									 'LIMIT 1;';
							
						$this->database->DeleteQuery($sql_query);
						return $blog_text_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_TEXT_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'BlogGetList' : {
				$order = 5;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'blog.blog_id, ' .
								 ''.DATABASE_PREFIX.'blog.blog_active, ' .
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
								 ''.DATABASE_PREFIX.'blog.blog_last_update_date, ' .
								 ''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .
								 ''.DATABASE_PREFIX.'blog_text.blog_text_value ' .
								 'FROM '.DATABASE_PREFIX.'blog ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'blog_text ON '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.DATABASE_PREFIX.'blog.blog_id AND '.DATABASE_PREFIX.'blog_text.blog_text_lang = \''.LANG.'\' ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'blog.blog_last_update_admin_user_id ' .
								 'ORDER BY '.$order.' '.$sort.';';
						 
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(BLOG_GET_LIST_ERROR);
				}
			
				break;
			}
			case 'BlogGetMultilanguageList' : {
				$order = 5;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'blog.blog_id, ' .
								 ''.DATABASE_PREFIX.'blog.blog_active, ' .
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
								 ''.DATABASE_PREFIX.'blog.blog_last_update_date, ' .
								 ''.DATABASE_PREFIX.'blog_text.blog_text_lang, ' .
								 ''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .
								 ''.DATABASE_PREFIX.'blog_text.blog_text_value ' .
								 'FROM '.DATABASE_PREFIX.'blog ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'blog_text ON '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.DATABASE_PREFIX.'blog.blog_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'blog.blog_last_update_admin_user_id ' .
								 'ORDER BY '.$order.' '.$sort.';';
						
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(BLOG_GET_MULTILANGUAGE_LIST_ERROR);
				}
					
				break;
			}
			case 'BlogGetMultilanguageList' : {
				$order = 5;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'blog.blog_id, ' .
							     ''.DATABASE_PREFIX.'blog.blog_active, ' .
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
								 ''.DATABASE_PREFIX.'blog.blog_last_update_date, ' .
								 ''.DATABASE_PREFIX.'blog_text.blog_text_lang, ' .
								 ''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .
								 ''.DATABASE_PREFIX.'blog_text.blog_text_value ' .
								 'FROM '.DATABASE_PREFIX.'blog ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'blog_text ON '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.DATABASE_PREFIX.'blog.blog_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'blog.blog_last_update_admin_user_id ' .
								 'ORDER BY '.$order.' '.$sort.';';
						
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(BLOG_GET_MULTILANGUAGE_LIST_ERROR);
				}
					
				break;
			}
			case 'BlogGetActiveList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'blog.blog_id, ' .
										'DATE_FORMAT('.DATABASE_PREFIX.'blog.blog_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .
										''.DATABASE_PREFIX.'blog_text.blog_text_title, ' .
										''.DATABASE_PREFIX.'blog_text.blog_text_value, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_email, ' .
										'DATE_FORMAT('.DATABASE_PREFIX.'blog.blog_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .
										''.DATABASE_PREFIX.'blog.blog_hit ' .
										'FROM '.DATABASE_PREFIX.'blog ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'blog_text ON '.DATABASE_PREFIX.'blog_text.blog_text_blog_id = '.DATABASE_PREFIX.'blog.blog_id AND '.DATABASE_PREFIX.'blog_text.blog_text_lang = \''.LANG.'\' ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'blog.blog_last_update_admin_user_id ' .
										'WHERE '.DATABASE_PREFIX.'blog.blog_active = 1 ' .
										'ORDER BY '.DATABASE_PREFIX.'blog.blog_last_update_date DESC;';
									
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(BLOG_GET_ACTIVE_LIST_ERROR);
				}
					
				break;
			}
			case 'BlogDelete' : {
				if (isset($args[0])) {
						
					$blog_id = $args[0];
						
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'blog ' .
											'WHERE blog_id = '.$this->database->FormatDataToInteger($blog_id).' LIMIT 1;';
							
						$result = $this->database->DeleteQuery($sql_query);
							
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'blog_text ' .
											'WHERE blog_text_blog_id = '.$this->database->FormatDataToInteger($blog_id).' LIMIT 1;';
			
						$result = $this->database->DeleteQuery($sql_query);
			
						Util::AdminGenerateSiteMap();
						
						return blog_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BlogTagGetList' : {
				if (isset($args[0])) {
						
					$blog_id = $args[0];
			
					try {
						$sql_query = 'SELECT tag_text ' .
											'FROM '.DATABASE_PREFIX.'tag ' .
											'WHERE tag_object_id = '.$this->database->FormatDataToInteger($blog_id).' AND tag_type = \'blog\' ' .
											'ORDER BY tag_text;';
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BLOG_TAG_GET_LIST_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BlogAddTag' : {
				if (isset($args[0]) &&
					isset($args[1])) {
		
						$admin_user_id = NULL;
							
						if (isset($_SESSION[SITE_ID]['user_id'])) {
							$admin_user_id = $_SESSION[SITE_ID]['user_id'];
						} else {
							$admin_user_id = 0;
						}
		
						try {
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'tag (tag_id, tag_type, tag_object_id, tag_text, tag_creation_date, tag_last_update_date, tag_last_update_admin_user_id) ' .
									'VALUES ' .
									'(NULL, ' .
									'\'blog\', ' .
									''.$this->database->FormatDataToInteger($args[0]).', ' .
									''.$this->database->FormatDataToVarchar($args[1], 50).', ' .
									'NOW(), ' .
									'NOW(), ' .
									''.$this->database->FormatDataToInteger($admin_user_id).') ON DUPLICATE KEY UPDATE ' .
									'tag_last_update_date = NOW(), ' .
									'tag_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id);
								
							$result = $this->database->InsertQuery($sql_query);
		
							if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
								return $result[1];
							}
						} catch (SqlException $ex) {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(BLOG_TAG_ADD_ERROR);
						}
					} else {
						throw new DataException(MISSING_ARGUMENT_ERROR);
					}
					break;
			}
			case 'BlogDeleteTag' : {
				if (isset($args[0]) &&
					isset($args[1])) {
		
						try {
							$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'tag ' .
													'WHERE tag_type = \'blog\' AND ' .
													'tag_object_id = '.$this->database->FormatDataToInteger($args[0]).' AND ' .
													'tag_text = '.$this->database->FormatDataToVarchar($args[1], 50).' LIMIT 1;';
		
							$this->database->DeleteQuery($sql_query);
							return $args[0];
						} catch (SqlException $ex) {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(BLOG_TAG_DELETE_ERROR);
						}
					} else {
						throw new DataException(MISSING_ARGUMENT_ERROR);
					}
					break;
			}
//////// 		END OF BLOG ADMINISTRATION PART

//////// 		ITEM/BLOG COMMENT ADMINISTRATION PART
			case 'CommentAdd' : {
				$result = NULL;
					
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
							
						$id = $args[0];
						$type = $args[1];
						$comment = $args[2];
							
						$admin_user_id = NULL;
						$admin_user_email = NULL;
							
						if (isset($_SESSION[SITE_ID]['user_id'])) {
							$admin_user_id = $_SESSION[SITE_ID]['user_id'];
						} else {
							$admin_user_id = 0;
						}
						
						if (isset($_SESSION[SITE_ID]['user_email'])) {
							$admin_user_email = $_SESSION[SITE_ID]['user_email'];
						} else {
							$admin_user_email = '';
						}
							
						try {
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'comment (comment_id, comment_type, comment_object_id, comment_text, comment_creation_date, comment_admin_user_id) ' .
														'VALUES ' .
														'(NULL, ' .
														''.$this->database->FormatDataToVarchar($type, 20).', ' .
														''.$this->database->FormatDataToInteger($id).', ' .
														''.$this->database->FormatDataToVarchar($comment, 10000).', ' .
														'NOW(), ' .
														''.$this->database->FormatDataToInteger($admin_user_id).');';
							
							$result = $this->database->InsertQuery($sql_query);
								
							if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
								$message = '<?php echo Util::PageGetHtmlTop(); ?>
								      <BODY>
										<TABLE>
											<TR>
												<TD>'.MAIL_COMMENT_ADDED_MESSAGE.'</TD>
											</TR>
											<TR>
												<TD>
													<TABLE>
											    		'.$comment.'
											    	</TABLE>
												</TD>
											</TR>
								       	</TABLE>
								      </BODY>
								     </HTML>';
									
								Util::SendMail($admin_user_email, SITE_TITLE.' - '.MAIL_COMMENT_ADDED, $message);

								return $result[1];
							}
						} catch (SqlException $ex) {
							if ($ex->getErrorNumber() == 1062) {
								throw new DataException(COMMENT_DUPLICATE_KEY);
							} else {
								$this->AdminSaveError($method, $ex->getError());
								throw new DataException(COMMENT_ADD_ERROR);
							}
						}
					} else {
						throw new DataException(MISSING_ARGUMENT_ERROR);
					}
					break;
				}
				case 'GetCommentList' : {
					if (isset($args[0]) &&
						isset($args[1])) {
						$id = $args[0];
						$type = $args[1];
				
						try {
							$sql_query = 'SELECT '.DATABASE_PREFIX.'comment.comment_id, ' .                                //   0
												''.DATABASE_PREFIX.'comment.comment_text, ' .                    //   1
												'DATE_FORMAT('.DATABASE_PREFIX.'comment.comment_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .            //  2
												''.DATABASE_PREFIX.'admin_user.admin_user_login ' .                //   3
												'FROM '.DATABASE_PREFIX.'comment ' .
												'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'comment.comment_admin_user_id ' .
												'WHERE '.DATABASE_PREFIX.'comment.comment_object_id = '.$this->database->FormatDataToInteger($id).' AND ' .
												''.DATABASE_PREFIX.'comment.comment_type = '.$this->database->FormatDataToVarchar($type, 20).';';
								
							return $this->database->SelectTableQuery($sql_query);
						} catch (SqlException $ex) {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ERROR_GET_COMMENT_LIST);
						}
					} else {
						throw new DataException(MISSING_ARGUMENT_ERROR);
					}
					break;
				}
//////// 		END OF ITEM/BLOG COMMENT ADMINISTRATION PART
			
//////// 		LINKS ADMINISTRATION PART	
			case 'LinksActivate' : {
				if (isset($args[0])) {
			
					$links_id = $args[0];
			
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
			
					try {
						$value = '0';
			
						$sql_query = 'SELECT links_active FROM '.DATABASE_PREFIX.'links WHERE links_id = '.$this->database->FormatDataToInteger($links_id).' LIMIT 1;';
						$result = $this->database->SelectSingleValueQuery($sql_query);
			
						if ($result == '0') {
							$value = '1';
						}
			
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'links SET ' .
											'links_active = '.$value.', ' .
											'links_last_update_date = NOW(), ' .
											'links_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
											'WHERE links_id = '.$this->database->FormatDataToInteger($links_id).' LIMIT 1;';
			
						$this->database->UpdateQuery($sql_query);
			
						return $links_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(LINKS_ACTIVATE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'LinksAdd' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3]) &&
					isset($args[4])) {
			
					$links_active = $args[0];
					$links_link = $args[1];
					$links_title = $args[2];
					$links_text_lang = $args[3];
					$links_text_value = $args[4];
					$image_id = $args[5];
			
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
			
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'links (links_id, links_active, links_link, links_title, links_creation_date, links_last_update_date, links_last_update_admin_user_id, links_hit) ' .
													    'VALUES ' .
													    '(NULL, ' .
													    ''.$this->database->FormatDataToBoolean($links_active).', ' .
													    ''.$this->database->FormatDataToVarchar($links_link, 500).', ' .
													    ''.$this->database->FormatDataToVarchar($links_title, 300).', ' .
													    'NOW(), ' .
													    'NOW(), ' .
													    ''.$this->database->FormatDataToInteger($admin_user_id).', ' .
													    '0);';
			
						$result = $this->database->InsertQuery($sql_query);
			
						$links_id = $result[1];
			
						/* TEXT PART */
						if ($links_text_value!= '') {
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'links_text (links_text_id, links_text_links_id, links_text_lang, links_text_value) ' .
																'VALUES ' .
																'(NULL, ' .
																''.$this->database->FormatDataToInteger($links_id).', ' .
																''.$this->database->FormatDataToVarchar($links_text_lang, 2).', ' .
																''.$this->database->FormatDataToVarchar($links_text_value, 10000).');';
			
							$result = $this->database->InsertQuery($sql_query);
						}
						/* END OF TEXT PART */
						
						/* IMAGE PART */
						if ($image_id != '') {
							$this->ImageLink($image_id, $links_id);
						}
						/* END OF IMAGE PART */
						
						return $links_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(LINKS_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(LINKS_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'LinksUpdate' : {
				if (isset($args[0]) &&
					isset($args[1])) {
			
					$links_id = $args[0];
					$links_active = $args[1];
					$links_link = $args[2];
					$links_title = $args[3];
					$links_text_id = $args[4];
					$links_text_lang = $args[5];
					$links_text_value = $args[6];
			
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
			
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'links SET ' .
											'links_active = '.$this->database->FormatDataToBoolean($links_active).', ' .
											'links_link = '.$this->database->FormatDataToVarchar($links_link, 500).', ' .
											'links_title = '.$this->database->FormatDataToVarchar($links_title, 300).', ' .
											'links_last_update_date = NOW(), ' .
											'links_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
											'WHERE links_id = '.$this->database->FormatDataToInteger($links_id).' LIMIT 1;';
			
						$result = $this->database->UpdateQuery($sql_query);
						
						/* TEXT PART */
						if (($links_text_lang != '') && ($links_text_value != '')) {
							if ($links_text_id == '') {
								$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'links_text (links_text_id, links_text_links_id, links_text_lang, links_text_value) ' .
											  'VALUES ' .
											  '(NULL, ' .
											  ''.$this->database->FormatDataToInteger($links_id).', ' .
											  ''.$this->database->FormatDataToVarchar($links_text_lang, 2).', ' .
											  ''.$this->database->FormatDataToVarchar($links_text_value, 10000).');';
								
								$result = $this->database->InsertQuery($sql_query);
							} else {
								$sql_query = 'UPDATE '.DATABASE_PREFIX.'links_text ' .
											 'SET links_text_lang = '.$this->database->FormatDataToVarchar($links_text_lang, 2).', ' .
											 'links_text_value = '.$this->database->FormatDataToVarchar($links_text_value, 10000).' ' . 
											 'WHERE links_text_id = '.$this->database->FormatDataToInteger($links_text_id).' LIMIT 1;';
								
								$result = $this->database->UpdateQuery($sql_query);
							}
						}
						/* END OF TEXT PART */
						
						return $links_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(LINKS_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(LINKS_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'LinksGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'links.links_id, ' .
											''.DATABASE_PREFIX.'links.links_active, ' .
											''.DATABASE_PREFIX.'links.links_link, ' .
											''.DATABASE_PREFIX.'links.links_title, ' .
											'DATE_FORMAT('.DATABASE_PREFIX.'links.links_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
											''.DATABASE_PREFIX.'admin_user.admin_user_email ' .
											'FROM '.DATABASE_PREFIX.'links ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'links.links_last_update_admin_user_id ' .
									 		'WHERE '.DATABASE_PREFIX.'links.links_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
											'LIMIT 1;';
						
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(LINKS_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				
				break;
			}
			case 'LinksGetText' : {
				if (isset($args[0])) {
					try {
						if (isset($args[1])) {
							$sql_query = 'SELECT '.DATABASE_PREFIX.'links_text.links_text_id, ' .
												''.DATABASE_PREFIX.'links_text.links_text_lang, ' .
												''.DATABASE_PREFIX.'links_text.links_text_value ' .
												'FROM '.DATABASE_PREFIX.'links_text ' .
												'WHERE '.DATABASE_PREFIX.'links_text.links_text_links_id = '.$this->database->FormatDataToInteger($args[0]).' AND ' .
												''.DATABASE_PREFIX.'links_text.links_text_lang = '.$this->database->FormatDataToVarchar($args[1], 2).' ' .
												'LIMIT 1;';
						} else {
							$sql_query = 'SELECT '.DATABASE_PREFIX.'links_text.links_text_id, ' .
												''.DATABASE_PREFIX.'links_text.links_text_lang, ' .
												''.DATABASE_PREFIX.'links_text.links_text_value ' .
												'FROM '.DATABASE_PREFIX.'links_text ' .
												'WHERE '.DATABASE_PREFIX.'links_text.links_text_links_id = '.$this->database->FormatDataToInteger($args[0]).' AND ' .
												''.DATABASE_PREFIX.'links_text.links_text_lang = \''.LANG.'\' ' .
												'LIMIT 1;';
						}
			
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(LINKS_GET_TEXT_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'LinksGetMultilanguageText' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'links_text.links_text_id, ' .
									 ''.DATABASE_PREFIX.'links_text.links_text_lang, ' .
									 ''.DATABASE_PREFIX.'links_text.links_text_value ' .
									 'FROM '.DATABASE_PREFIX.'links_text ' .
									 'WHERE '.DATABASE_PREFIX.'links_text.links_text_links_id = '.$this->database->FormatDataToInteger($args[0]);
			
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(LINKS_GET_MULTILANGUAGE_TEXT_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'LinksAddText' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
					try {
						$links_text_links_id = $args[0];
						$links_text_lang = $args[1];
						$links_text_value = $args[2];
						
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'links_text (links_text_id, links_text_links_id, links_text_lang, links_text_value) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToInteger($links_text_links_id).' , ' .
									 ''.$this->database->FormatDataToVarchar($links_text_lang, 2).' , ' .
									 ''.$this->database->FormatDataToVarchar($links_text_value, 10000).');';
						
						$result = $this->database->InsertQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(LINKS_TEXT_ADD_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'LinksUpdateText' : {
				if (isset($args[0]) &&
					isset($args[1])) {
					try {
						$links_text_id = $args[0];
						$links_text_value = $args[1];
						
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'links_text SET ' .
								     'links_text_value = '.$this->database->FormatDataToVarchar($args[1], 10000).' ' .
									 'WHERE links_text_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
									 'LIMIT 1;';
						
						$this->database->UpdateQuery($sql_query);
						return $links_text_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(LINKS_TEXT_UPDATE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'LinksDeleteText' : {
				if (isset($args[0])) {
					try {
						$links_text_id = $args[0];
						
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'links_text ' .
									 'WHERE links_text_id = '.$this->database->FormatDataToInteger($links_text_id).' ' .
								     'LIMIT 1;';
			
						$this->database->DeleteQuery($sql_query);
						return $links_text_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(LINKS_TEXT_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'LinksGetList' : {
				$order = 5;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'links.links_id, ' .                  // 0
										''.DATABASE_PREFIX.'links.links_active, ' .              // 1
										''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .     // 2
										''.DATABASE_PREFIX.'links.links_last_update_date, ' .    // 3
										''.DATABASE_PREFIX.'links.links_link, ' .                // 4
										''.DATABASE_PREFIX.'links.links_title, ' .               // 5
										''.DATABASE_PREFIX.'links_text.links_text_value ' .      // 6
										'FROM '.DATABASE_PREFIX.'links ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'links_text ON '.DATABASE_PREFIX.'links_text.links_text_links_id = '.DATABASE_PREFIX.'links.links_id AND '.DATABASE_PREFIX.'links_text.links_text_lang = \''.LANG.'\' ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'links.links_last_update_admin_user_id ' .
										'ORDER BY '.$order.' '.$sort.';';
			
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(LINKS_GET_LIST_ERROR);
				}

				break;
			}
			case 'LinksGetActiveList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'links.links_id, ' .                                                     // 0
							'DATE_FORMAT('.DATABASE_PREFIX.'links.links_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .    // 1
							''.DATABASE_PREFIX.'links.links_link, ' .                                                               // 2
							''.DATABASE_PREFIX.'links.links_title, ' .                                                              // 3
							''.DATABASE_PREFIX.'links_text.links_text_value, ' .                                                    // 4
							''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .                                                    // 5
							''.DATABASE_PREFIX.'admin_user.admin_user_email ' .                                                     // 6
							'FROM '.DATABASE_PREFIX.'links ' .
							'LEFT OUTER JOIN '.DATABASE_PREFIX.'links_text ON '.DATABASE_PREFIX.'links_text.links_text_links_id = '.DATABASE_PREFIX.'links.links_id AND '.DATABASE_PREFIX.'links_text.links_text_lang = \''.LANG.'\' ' .
							'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'links.links_last_update_admin_user_id ' .
							'WHERE '.DATABASE_PREFIX.'links.links_active = 1 ' .
							'ORDER BY '.DATABASE_PREFIX.'links.links_last_update_date DESC;';
						
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(LINKS_GET_ACTIVE_LIST_ERROR);
				}
					
				break;
			}
			case 'LinksDelete' : {
				if (isset($args[0])) {
						
					$links_id = $args[0];
						
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'links ' .
											'WHERE links_id = '.$this->database->FormatDataToInteger($links_id).' LIMIT 1;';
							
						$result = $this->database->DeleteQuery($sql_query);
							
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'links_text ' .
										'WHERE links_text_links_id = '.$this->database->FormatDataToInteger($links_id).' LIMIT 1;';
			
						$result = $this->database->DeleteQuery($sql_query);
			
						return blog_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(LINKS_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
//////// 		END OF LINKS ADMINISTRATION PART

/////// ROLE ADMINISTRATION PART
		case 'AdminRoleGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_role.admin_role_id, ' .
											''.DATABASE_PREFIX.'admin_role.admin_role_name ' .
											'FROM '.DATABASE_PREFIX.'admin_role ' .
											'WHERE '.DATABASE_PREFIX.'admin_role.admin_role_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
											'LIMIT 1;';
			
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ROLE_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'AdminRoleGetList' : {
				$order = 2;
				$sort = 'ASC';
				
				if (isset($args[0])) {
					$order = $args[0];
				}
				
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_role.admin_role_id, ' .
										''.DATABASE_PREFIX.'admin_role.admin_role_name, ' .
									    ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
										''.DATABASE_PREFIX.'admin_role.admin_role_last_update_date ' .
										'FROM '.DATABASE_PREFIX.'admin_role ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_role.admin_role_last_update_admin_user_id ' .
										'ORDER BY '.$order.' '.$sort.';';
				
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_ROLE_GET_LIST_ERROR);
				}

				break;
			}
			case 'AdminRoleDisplayList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_role.admin_role_id, ' .
										''.DATABASE_PREFIX.'admin_role.admin_role_name ' .
										'FROM '.DATABASE_PREFIX.'admin_role ' .
										'ORDER BY '.DATABASE_PREFIX.'admin_role.admin_role_name;';
			
					return $this->database->PrintSelectOption($sql_query,$args[0], true);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_ROLE_DISPLAY_LIST_ERROR);
				}
			
				break;
			}
			case 'AdminRoleAdd' : {
				if (isset($args[0])) {
					
					$admin_role_name = $args[0];
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_role (admin_role_id, admin_role_name, admin_role_creation_date, admin_role_last_update_date, admin_role_last_update_admin_user_id) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToVarchar($admin_role_name, 50).', ' .
									 'NOW(), ' .
					            	 'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).');';
					
						$result = $this->database->InsertQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_ROLE_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_ROLE_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminRoleUpdate' : {
				if (isset($args[0]) &&
					isset($args[1])) {
					
					$admin_role_id = $args[0];
					$admin_role_name = $args[1];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_role SET ' .
									 'admin_role_name = '.$this->database->FormatDataToVarchar($admin_role_name, 50).', ' .
									 'admin_role_last_update_date = NOW(), ' .
									 'admin_role_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE admin_role_id = '.$this->database->FormatDataToInteger($admin_role_id).' LIMIT 1;';
					
						$this->database->UpdateQuery($sql_query);
						return $admin_role_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_ROLE_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_ROLE_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminRoleDelete' : {
				if (isset($args[0])) {
					$admin_role_id = $args[0];
					
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_role_access ' .
								 	 'WHERE admin_role_access_admin_role_id = '.$this->database->FormatDataToInteger($admin_role_id).';';
					
						$result = $this->database->DeleteQuery($sql_query);
						
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_role ' .
								 	 'WHERE admin_role_id = '.$this->database->FormatDataToInteger($admin_role_id).' LIMIT 1;';

						$this->database->DeleteQuery($sql_query);
						return $admin_role_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ROLE_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
/////// END OF ROLE ADMINISTRATION PART

/////// ROLE ACCESS ADMINISTRATION PART
			case 'AdminRoleAccessGetList' : {
				if (isset($args[0])) {
						
					$admin_role_id = $args[0];
					$order = 2;
					$sort = 'ASC';
						
					if (isset($args[1])) {
						$order = $args[1];
					}
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_role_access.admin_role_access_id, ' .
											''.DATABASE_PREFIX.'admin_access.admin_access_url, ' .
											''.DATABASE_PREFIX.'admin_access.admin_access_description ' .
											'FROM '.DATABASE_PREFIX.'admin_role_access ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_access ON '.DATABASE_PREFIX.'admin_role_access.admin_role_access_admin_access_id = '.DATABASE_PREFIX.'admin_access.admin_access_id ' .
											'WHERE admin_role_access_admin_role_id = '.$this->database->FormatDataToInteger($admin_role_id).' ' .
											'ORDER BY '.$order.' '.$sort.';';
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ROLE_ACCESS_GET_LIST_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminRoleAccessDisplayAvailableList' : {
				if (isset($args[0])) {
						
					$admin_role_id = $args[0];
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_access.admin_access_id, ' .
											''.DATABASE_PREFIX.'admin_access.admin_access_url ' .
											'FROM '.DATABASE_PREFIX.'admin_access ' .
											'WHERE '.DATABASE_PREFIX.'admin_access.admin_access_id NOT IN (SELECT DISTINCT '.DATABASE_PREFIX.'admin_role_access.admin_role_access_admin_access_id FROM '.DATABASE_PREFIX.'admin_role_access WHERE '.DATABASE_PREFIX.'admin_role_access.admin_role_access_admin_role_id = '.$this->database->FormatDataToInteger($admin_role_id).') ' .
											'ORDER BY '.DATABASE_PREFIX.'admin_access.admin_access_url;';
							
						return $this->database->PrintSelectOption($sql_query,'', true);
			
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ROLE_ACCESS_DISPLAY_AVAILABLE_LIST_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminRoleAccessAdd' : {
				if (isset($args[0]) && 
				    isset($args[1])) {
					
					$admin_role_id = $args[0];
					$admin_access_id = $args[1];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_role_access (admin_role_access_id, admin_role_access_admin_role_id, admin_role_access_admin_access_id, admin_role_access_creation_date, admin_role_access_last_update_date, admin_role_access_last_update_admin_user_id) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToInteger($admin_role_id).', ' .
									 ''.$this->database->FormatDataToInteger($admin_access_id).', ' .
									 'NOW(), ' .
					        	     'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).');';

						$result = $this->database->InsertQuery($sql_query);

						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_ROLE_ACCESS_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_ROLE_ACCESS_ADD);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminRoleAccessDelete' : {
				if (isset($args[0])) {
					
					$admin_role_access_id = $args[0];
					
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_role_access ' .
									 'WHERE admin_role_access_id = '.$this->database->FormatDataToInteger($admin_role_access_id).' LIMIT 1;';
					
						$this->database->DeleteQuery($sql_query);
						return $admin_role_access_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ROLE_ACCESS_DELETE);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
/////// END OF ROLE ACCESS ADMINISTRATION PART
			
/////// ACCESS ADMINISTRATION PART
			case 'AdminAccessGetList' : {
				$order = 2;
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_access.admin_access_id, ' .
								 ''.DATABASE_PREFIX.'admin_access.admin_access_url, ' .
								 ''.DATABASE_PREFIX.'admin_access.admin_access_description, ' .
								 ''.DATABASE_PREFIX.'admin_access.admin_access_last_update_date, ' .
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login ' .
								 'FROM '.DATABASE_PREFIX.'admin_access ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_access.admin_access_last_update_admin_user_id ' .
								 'ORDER BY '.$order.' '.$sort.';';
				
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_ACCESS_GET_LIST_ERROR);
				}
				
				break;
			}
			case 'AdminAccessDisplayList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_access.admin_access_id, ' .
								 ''.DATABASE_PREFIX.'admin_access.admin_access_url ' .
								 'FROM '.DATABASE_PREFIX.'admin_access ' .
								 'ORDER BY '.DATABASE_PREFIX.'admin_access.admin_access_url;';
				
					return $this->database->PrintSelectOption($sql_query,$args[0], true);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_ACCESS_DISPLAY_LIST_ERROR);
				}
				break;
			}
			case 'AdminAccessAdd' : {
				if (isset($args[0]) && 
				    isset($args[1])) {
					
					$admin_access_url = $args[0];
					$admin_access_description = $args[1];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_access (admin_access_id, admin_access_url, admin_access_description, admin_access_creation_date, admin_access_last_update_date, admin_access_last_update_admin_user_id) ' .
									 'VALUES ' .
									 '(NULL, ' .
									 ''.$this->database->FormatDataToVarchar($admin_access_url, 100).', ' .
									 ''.$this->database->FormatDataToVarchar($admin_access_description, 200).', ' .
									 'NOW(), ' .
					          		 'NOW(), ' .
									 ''.$this->database->FormatDataToInteger($admin_user_id).');';
					
						$result = $this->database->InsertQuery($sql_query);
						
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {						
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_ACCESS_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_ACCESS_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminAccessUpdate' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
					
					$admin_access_id = $args[0];
					$admin_access_url = $args[1];
					$admin_access_description = $args[2];
					
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_access SET ' .
									 'admin_access_url = '.$this->database->FormatDataToVarchar($admin_access_url, 100).', ' .
									 'admin_access_description = '.$this->database->FormatDataToVarchar($admin_access_description, 200).', ' .
									 'admin_access_last_update_date = NOW(), ' .
									 'admin_access_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE admin_access_id = '.$this->database->FormatDataToInteger($admin_access_id).' LIMIT 1;';
					
						$this->database->UpdateQuery($sql_query);
						
						return $admin_access_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_ACCESS_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_ACCESS_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminAccessDelete' : {
				if (isset($args[0])) {
					
					$admin_access_id = $args[0];
				
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_role_access ' .
									 'WHERE admin_role_access_admin_access_id = '.$this->database->FormatDataToInteger($admin_access_id).';';
					
						$result = $this->database->DeleteQuery($sql_query);
						
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_access ' .
								     'WHERE admin_access_id = '.$this->database->FormatDataToInteger($admin_access_id).' LIMIT 1;';
					
						$result = $this->database->DeleteQuery($sql_query);
						
						return $admin_access_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ACCESS_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminAccessGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_access.admin_access_id, ' .
									 ''.DATABASE_PREFIX.'admin_access.admin_access_url, ' .
									 ''.DATABASE_PREFIX.'admin_access.admin_access_description ' .
									 'FROM '.DATABASE_PREFIX.'admin_access ' .
									 'WHERE '.DATABASE_PREFIX.'admin_access.admin_access_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
									 'LIMIT 1;';
			
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ACCESS_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
/////// END OF ACCESS ADMINISTRATION PART			
			
			
/////// ERROR ADMINISTRATION PART
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
			case 'AdminErrorGetList' : {
				$result = NULL;
			
				$order = '2,4';
			
				$sort = 'DESC';
			
				if (isset($args[0]) && ($args[0] > -1)) {
					$order = $args[0];
				}
			
				if (isset($args[1])) {
					if ($args[1] == 'ASC') {
						$sort = $args[1];
					}
				}
			
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_error.admin_error_id, ' .
										''.DATABASE_PREFIX.'admin_error.admin_error_date, ' .
										''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
										''.DATABASE_PREFIX.'admin_error.admin_error_url, ' .
										''.DATABASE_PREFIX.'admin_error.admin_error_name, ' .
										''.DATABASE_PREFIX.'admin_error.admin_error_description ' .
										'FROM '.DATABASE_PREFIX.'admin_error ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_error.admin_error_admin_user_id ' .
										'ORDER BY '.$order.' '.$sort.';';
			
					$result = $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_ERROR_GET_LIST_ERROR);
				}
			
				return $result;
			
				break;
			}
			case 'AdminErrorDelete' : {
				$result = NULL;
			
				if (isset($args[0]) &&
					isset($args[1])) {
			
					$error_delete_start_date = $args[0];
					$error_delete_end_date = $args[1];
			
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_error ' .
									 'WHERE admin_error_date BETWEEN '.$this->database->FormatDataToDate($error_delete_start_date, DATABASE_DATE_FORMAT).' ' .
									 'AND '.$this->database->FormatDataToDate($error_delete_end_date, DATABASE_DATE_FORMAT).';';
			
						$result = $this->database->DeleteQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ERROR_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
/////// END OF ERROR ADMINISTRATION PART	

/////// CONFIGURATION ADMINISTRATION PART
			case 'AdminActiveConfigurationGet' : {
				$result = NULL;
				
				try {
					$sql_query = 'SHOW COLUMNS FROM '.DATABASE_PREFIX.'admin_configuration;';	
					$fields = $this->database->SelectTableQuery($sql_query);
					
					$sql_query = 'SELECT ';
							
					for ($i = 0; $i < count($fields); $i++) {
							
						if ($i > 0) {
							$sql_query .= ', ';
						}
							
						$sql_query .= $fields[$i][0];
					}
				
					$sql_query .= ' FROM '.DATABASE_PREFIX.'admin_configuration ' .
								  'WHERE '.DATABASE_PREFIX.'admin_configuration.admin_configuration_active = 1 ' .
								  'LIMIT 1;';
				
					
					$result = $this->database->SelectRowQuery($sql_query);
					
					$i = 0;
					
					for ($i = 0; $i < count($result); $i++) {
						$_SESSION[SITE_ID][$fields[$i][0]] = $result[$i];
					}
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_GET_ACTIVE_CONFIGURATION_ERROR);
				}
				break;
			}
			case 'AdminConfigurationGetList' : {
				$result = NULL;
					
				$order = '2,3';
					
				$sort = 'DESC';
					
				if (isset($args[0]) && ($args[0] > -1)) {
					$order = $args[0];
				}
					
				if (isset($args[1])) {
					if ($args[1] == 'ASC') {
						$sort = $args[1];
					}
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_configuration.admin_configuration_id, ' .
										''.DATABASE_PREFIX.'admin_configuration.admin_configuration_name, ' .
										''.DATABASE_PREFIX.'admin_configuration.admin_configuration_active, ' .
										''.DATABASE_PREFIX.'admin_configuration.admin_configuration_last_update_date, ' .
								 		''.DATABASE_PREFIX.'admin_user.admin_user_login ' .
								 		'FROM '.DATABASE_PREFIX.'admin_configuration ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_configuration.admin_configuration_last_update_admin_user_id ' .
										'ORDER BY '.$order.' '.$sort.';';
			
					$result = $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_CONFIGURATION_GET_LIST_ERROR);
				}
				
				return $result;
				break;
			}
			case 'AdminConfigurationAdd' : {
				$result = NULL;
					
				if (isset($args[0])) {
					
						$values = $args[0];
		
						try {
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_configuration (';
		
							$i = 0;
		
							foreach ($values as $value) {
									
								if ($i > 0) {
									$sql_query .= ', ';
								}
									
								$sql_query .= $value[0];
								$i++;
							}
		
							$sql_query .= ')
					VALUES
					(';
		
							$i = 0;
							foreach ($values as $value) {
									
								if ($i > 0) {
									$sql_query .= ',
							';
								}
									
								switch($value[2]) {
									case 'int':
									case 'bigint':
									case 'tinyint': {
										$sql_query .= $this->database->FormatDataToInteger($value[1]);
										break;
									}
									case 'datetime ': {
										$sql_query .= $this->database->FormatDataToDate($value[1], DATABASE_DATE_FORMAT);
										break;
									}
									case 'constant': {
										$sql_query .= $value[1];
										break;
									}
									case 'varchar':
									default: {
										$sql_query .= $this->database->FormatDataToVarchar($value[1], $value[3]);
										break;
									}
								}
									
								$i++;
							}
		
							$sql_query .= ');';
		
							$result = $this->database->InsertQuery($sql_query);
								
							if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
								return $result[1];
							}
						} catch (SqlException $ex) {
							if ($ex->getErrorNumber() == 1062) {
								throw new DataException(ADMIN_CONFIGURATION_ADD_DUPLICATE_KEY);
							} else {
								$this->AdminSaveError($method, $ex->getError());
								throw new DataException(ADMIN_CONFIGURATION_ADD_ERROR);
							}
						}
					} else {
						throw new DataException(MISSING_ARGUMENT_ERROR);
					}
						
					return $result;
		
					break;
			}
			case 'AdminConfigurationUpdate' : {
				$result = NULL;
					
				if (isset($args[0]) &&
					isset($args[1])) {
		
						$id = $args[0];
						$values = $args[1];
		
						try {
							$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_configuration SET ';
		
							$i = 0;
		
							foreach ($values as $value) {
								if ($value[0] != 'admin_configuration_id') {
										
									if ($i > 0) {
										$sql_query .= ', ';
									}
										
									$sql_query .= $value[0].' = ';
		
									switch($value[2]) {
										case 'int':
										case 'bigint':
										case 'tinyint': {
											$sql_query .= $this->database->FormatDataToInteger($value[1]);
											break;
										}
										case 'datetime ': {
											$sql_query .= $this->database->FormatDataToDate($value[1], DATABASE_DATE_FORMAT);
											break;
										}
										case 'constant': {
											$sql_query .= $value[1];
											break;
										}
										case 'varchar':
										default: {
											$sql_query .= $this->database->FormatDataToVarchar($value[1], $value[3]);
											break;
										}
									}
		
									$i++;
								}
							}
		
							$sql_query .= ' WHERE admin_configuration_id = '.$this->database->FormatDataToInteger($id).' LIMIT 1;';
		
							$result = $this->database->UpdateQuery($sql_query);
								
							if (isset($result) && $result == 1) {
								return $result[1];
							}
						} catch (SqlException $ex) {
							if ($ex->getErrorNumber() == 1062) {
								throw new DataException(ADMIN_CONFIGURATION_UPDATE_DUPLICATE_KEY);
							} else {
								$this->AdminSaveError($method, $ex->getError());
								throw new DataException(ADMIN_CONFIGURATION_UPDATE_ERROR);
							}
						}
					} else {
						throw new DataException(MISSING_ARGUMENT_ERROR);
					}
						
					return $result;
		
					break;
			}

/////// END OF CONFIGURATION ADMINISTRATION PART
			
/////// MENU ADMINISTRATION PART
			
			case 'AdminMenuGetList' : {
				$result = NULL;
				
				$order = '6,7';
				
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
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_menu.admin_menu_id, ' .                     // 0
								         ''.DATABASE_PREFIX.'admin_menu.admin_menu_name, ' .                  // 1
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_admin_access_id, ' .       // 2
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_link, ' .                  // 3
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_target, ' .                // 4
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_level_0, ' .               // 5
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_level_1, ' .               // 6
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_last_update_date, ' .      // 7
										 ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .                 // 8
										 ''.DATABASE_PREFIX.'admin_access.admin_access_url, ' .               // 9
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_item_type_id, ' .          // 10
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_item_type_2_id, ' .        // 11
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_style, ' .                 // 12
										 ''.DATABASE_PREFIX.'admin_menu.admin_menu_image ' .                  // 13
										 'FROM '.DATABASE_PREFIX.'admin_menu ' .
										 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_menu.admin_menu_last_update_admin_user_id ' .
										 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_access ON '.DATABASE_PREFIX.'admin_access.admin_access_id = '.DATABASE_PREFIX.'admin_menu.admin_menu_admin_access_id ' .
										 'ORDER BY '.$order.' '.$sort.';';
			
					$result = $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_MENU_GET_LIST_ERROR);
				}
				
				return $result;
			
				break;
			}
			case 'AdminMenuGet' : {
				$result = NULL;
			
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_menu.admin_menu_id, ' .
								 	 ''.DATABASE_PREFIX.'admin_menu.admin_menu_name, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_admin_access_id, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_link, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_target, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_level_0, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_level_1, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_style, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_item_type_id, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_item_type_2_id, ' .
									 ''.DATABASE_PREFIX.'admin_menu.admin_menu_image ' .
									 'FROM '.DATABASE_PREFIX.'admin_menu ' .
									 'WHERE '.DATABASE_PREFIX.'admin_menu.admin_menu_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
									 'LIMIT 1;';
			
						$result = $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_MENU_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				return $result;
			
				break;
			}
			case 'AdminMenuAdd' : {
				$result = NULL;
			
				if (isset($args[0]) &&
					isset($args[1])) {
			
					$admin_menu_name = $args[0];
					$admin_menu_admin_access_id = $args[1];
					$admin_menu_link = $args[2];
					$admin_menu_target = $args[3];
					$admin_menu_level_0 = $args[4];
					$admin_menu_level_1 = $args[5];
					$admin_menu_style = $args[6];
					$admin_menu_item_type_id = $args[7];
					$admin_menu_item_type_2_id = $args[8];
					$admin_menu_image = $args[9];
			
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
			
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_menu (admin_menu_id, admin_menu_name, admin_menu_admin_access_id, admin_menu_link, admin_menu_target, admin_menu_level_0, admin_menu_level_1, admin_menu_style, admin_menu_item_type_id, admin_menu_item_type_2_id, admin_menu_image, admin_menu_creation_date, admin_menu_last_update_date, admin_menu_last_update_admin_user_id) ' .
									  'VALUES ' .
									  '(NULL, ' .
									  ''.$this->database->FormatDataToVarchar($admin_menu_name, 100).', ' .
									  ''.$this->database->FormatDataToInteger($admin_menu_admin_access_id).', ' .
									  ''.$this->database->FormatDataToVarchar($admin_menu_link, 200).', ' .
									  ''.$this->database->FormatDataToVarchar($admin_menu_target, 20).', ' .
									  ''.$this->database->FormatDataToInteger($admin_menu_level_0).', ' .
									  ''.$this->database->FormatDataToInteger($admin_menu_level_1).', ' .
									  ''.$this->database->FormatDataToVarchar($admin_menu_style, 50).', ' .
									  ''.$this->database->FormatDataToInteger($admin_menu_item_type_id).', ' .
									  ''.$this->database->FormatDataToInteger($admin_menu_item_type_2_id).', ' .
									  ''.$this->database->FormatDataToVarchar($admin_menu_image, 50).', ' .
									  'NOW(), ' .
									  'NOW(), ' .
									  ''.$this->database->FormatDataToInteger($admin_user_id).');';
			
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_MENU_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_MENU_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminMenuUpdate' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
			
					$admin_menu_id = $args[0];
					$admin_menu_name = $args[1];
					$admin_menu_admin_access_id = $args[2];
					$admin_menu_link = $args[3];
					$admin_menu_target = $args[4];
					$admin_menu_level_0 = $args[5];
					$admin_menu_level_1 = $args[6];
					$admin_menu_style = $args[7];
					$admin_menu_item_type_id = $args[8];
					$admin_menu_item_type_2_id = $args[9];
					$admin_menu_image = $args[10];
			
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
			
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'admin_menu SET ' .
									 'admin_menu_name = '.$this->database->FormatDataToVarchar($admin_menu_name, 100).', ' .
									 'admin_menu_admin_access_id = '.$this->database->FormatDataToInteger($admin_menu_admin_access_id).', ' .
									 'admin_menu_link = '.$this->database->FormatDataToVarchar($admin_menu_link, 200).', ' .
									 'admin_menu_target = '.$this->database->FormatDataToVarchar($admin_menu_target, 20).', ' .
									 'admin_menu_level_0 = '.$this->database->FormatDataToInteger($admin_menu_level_0).', ' .
									 'admin_menu_level_1 = '.$this->database->FormatDataToInteger($admin_menu_level_1).', ' .
									 'admin_menu_style = '.$this->database->FormatDataToVarchar($admin_menu_style, 50).', ' .
									 'admin_menu_item_type_id = '.$this->database->FormatDataToInteger($admin_menu_item_type_id).', ' .
									 'admin_menu_item_type_2_id = '.$this->database->FormatDataToInteger($admin_menu_item_type_2_id).', ' .
									 'admin_menu_image = '.$this->database->FormatDataToVarchar($admin_menu_image, 50).', ' .
									 'admin_menu_last_update_date = NOW(), ' .
									 'admin_menu_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
									 'WHERE admin_menu_id = '.$this->database->FormatDataToInteger($admin_menu_id).' LIMIT 1;';
			
						$this->database->UpdateQuery($sql_query);
						
						return $admin_menu_id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_MENU_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_MENU_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminMenuDelete' : {
				if (isset($args[0])) {
			
					$admin_menu_id = $args[0];
			
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_menu ' .
									 'WHERE admin_menu_id = '.$this->database->FormatDataToInteger($admin_menu_id).' LIMIT 1;';
			
						$this->database->DeleteQuery($sql_query);
						return $admin_menu_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_MENU_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
/////// END OF MENU ADMINISTRATION PART

/////// STORE PART
			case 'AdminOrderStatusAdd' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3]) &&
					isset($args[4])) {
						
					$order_status_name = $args[0];
					$order_status_active = $args[1];
					$order_status_inventory_reserve = $args[2];
					$order_status_inventory_cleanup = $args[3];
					$order_status_lock = $args[4];
					$order_status_other_possible_status = '';
					
					if (isset($args[5])) {
						$order_status_other_possible_status = $args[5];
					}
					
					$admin_user_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'store_order_status (store_order_status_id, store_order_status_name, store_order_status_active, store_order_status_inventory_reserve, store_order_status_inventory_cleanup, store_order_status_lock, store_order_status_other_possible_status, store_order_status_creation_date, store_order_status_last_update_date, store_order_status_last_update_admin_user_id) ' .
											'VALUES ' .
											'(NULL, ' .
											''.$this->database->FormatDataToVarchar($order_status_name, 50).', ' .
											''.$this->database->FormatDataToBoolean($order_status_active).', ' .
											''.$this->database->FormatDataToBoolean($order_status_inventory_reserve).', ' .
											''.$this->database->FormatDataToBoolean($order_status_inventory_cleanup).', ' .
											''.$this->database->FormatDataToBoolean($order_status_lock).', ' .
											''.$this->database->FormatDataToVarchar($order_status_other_possible_status, 20).', ' .
											'NOW(), ' .
											'NOW(), ' .
											''.$this->database->FormatDataToInteger($admin_user_id).');';
							
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_ORDER_STATUS_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_ORDER_STATUS_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminOrderStatusUpdate' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2]) &&
					isset($args[3]) &&
					isset($args[4]) &&
					isset($args[5])) {
			
					$id = $args[0];
					$order_status_name = $args[1];
					$order_status_active = $args[2];
					$order_status_inventory_reserve = $args[3];
					$order_status_inventory_cleanup = $args[4];
					$order_status_lock = $args[5];
					$order_status_other_possible_status = '';
						
					if (isset($args[6])) {
						$order_status_other_possible_status = $args[6];
					}
						
					$admin_user_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
			
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'store_order_status SET ' .
											 'store_order_status_name = '.$this->database->FormatDataToVarchar($order_status_name, 50).', ' .
											 'store_order_status_active = '.$this->database->FormatDataToBoolean($order_status_active).', ' .
											 'store_order_status_inventory_reserve = '.$this->database->FormatDataToBoolean($order_status_inventory_reserve).', ' .
											 'store_order_status_inventory_cleanup = '.$this->database->FormatDataToBoolean($order_status_inventory_cleanup).', ' .
											 'store_order_status_lock = '.$this->database->FormatDataToBoolean($order_status_lock).', ' .
											 'store_order_status_other_possible_status = '.$this->database->FormatDataToVarchar($order_status_other_possible_status, 20).', ' .
											 'store_order_status_last_update_date = NOW(), ' .
											 'store_order_status_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
											 'WHERE store_order_status_id = '.$this->database->FormatDataToInteger($id).' ' .
											 'LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
						
						return $id;
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_ORDER_STATUS_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_ORDER_STATUS_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminOrderStatusGet' : {
				$result = NULL;
					
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_status.store_order_status_id, ' .
											''.DATABASE_PREFIX.'store_order_status.store_order_status_name, ' .
											''.DATABASE_PREFIX.'store_order_status.store_order_status_active, ' .
											''.DATABASE_PREFIX.'store_order_status.store_order_status_inventory_reserve, ' .
											''.DATABASE_PREFIX.'store_order_status.store_order_status_inventory_cleanup, ' .
											''.DATABASE_PREFIX.'store_order_status.store_order_status_lock, ' .
											''.DATABASE_PREFIX.'store_order_status.store_order_status_other_possible_status ' .
											'FROM '.DATABASE_PREFIX.'store_order_status ' .
											'WHERE '.DATABASE_PREFIX.'store_order_status.store_order_status_id = '.$this->database->FormatDataToInteger($args[0]).' ' .
											'LIMIT 1;';
							
						$result = $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ORDER_STATUS_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				return $result;
					
				break;
			}
			case 'AdminOrderStatusGetList' : {
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_status.store_order_status_id, ' .  // 0
					             ''.DATABASE_PREFIX.'store_order_status.store_order_status_name, ' .       // 1
					             ''.DATABASE_PREFIX.'store_order_status.store_order_status_active, ' .       // 2
					             ''.DATABASE_PREFIX.'store_order_status.store_order_status_inventory_reserve, ' .  // 3
					             ''.DATABASE_PREFIX.'store_order_status.store_order_status_inventory_cleanup, ' .  // 4
					             ''.DATABASE_PREFIX.'store_order_status.store_order_status_lock, ' .  // 5
					             ''.DATABASE_PREFIX.'store_order_status.store_order_status_other_possible_status, ' .  // 6
					             'DATE_FORMAT('.DATABASE_PREFIX.'store_order_status.store_order_status_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . 		  //   7
								 ''.DATABASE_PREFIX.'admin_user.admin_user_login ' .                //   8
								 'FROM '.DATABASE_PREFIX.'store_order_status ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order_status.store_order_status_last_update_admin_user_id ' .
								 'ORDER BY '.DATABASE_PREFIX.'store_order_status.store_order_status_id;';
						
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ADMIN_ORDER_STATUS_GET_LIST);
				}
				break;
			}
			case 'OrderStatusDisplayList' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT store_order_status_id, store_order_status_name ' .
						             'FROM '.DATABASE_PREFIX.'store_order_status ' .
						             'WHERE '.DATABASE_PREFIX.'store_order_status.store_order_status_active = 1 ' .
						             'ORDER BY store_order_status_id;';
			
						return $this->database->PrintTranslatedSelectOption($sql_query,$args[0], true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ORDER_STATUS_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'OrderStatusDisplayPossibleList' : {
				$script = '';
				
				if (isset($args[0])) {
					$script .= '<option value=""></option>';
					$current_id = $args[0];
					$possible_status_list = '';
					
					try {
						$sql_query = 'SELECT store_order_status_id, ' . // 0
									 'store_order_status_name, ' .      // 1
									 'store_order_status_other_possible_status ' . // 2 
									 'FROM '.DATABASE_PREFIX.'store_order_status ' .
									 'WHERE '.DATABASE_PREFIX.'store_order_status.store_order_status_active = 1 ' .
									 'ORDER BY store_order_status_id;';
						
						$result = $this->database->SelectTableQuery($sql_query);
						
						for ($i = 0; $i < count($result); $i++) {
							if ($result[$i][0] == $current_id) {
								$script .= '<option value=\''.$result[$i][0].','.$result[$i][1].'\' SELECTED>'.constant($result[$i][1]).'</option>';
								$possible_status_list = $result[$i][2];
								break;
							}
						}
						
						if ($possible_status_list != '') {
							$possible_status_list = explode(',', $possible_status_list);
						
							for ($i = 0; $i < count($result); $i++) {
								for ($j = 0; $j < count($possible_status_list); $j++) {
									if ($result[$i][0] == $possible_status_list[$j]) {
										$script .= '<option value=\''.$result[$i][0].','.$result[$i][1].'\'>'.constant($result[$i][1]).'</option>';
									}
								}
							}
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ORDER_STATUS_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}

				return $script;
				break;
			}
			case 'OrderUserDisplayList' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT DISTINCT '.DATABASE_PREFIX.'admin_user.admin_user_id, ' .
											 ''.DATABASE_PREFIX.'admin_user.admin_user_login ' .
											 'FROM '.DATABASE_PREFIX.'store_order ' .
											 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_admin_user_id ' .
											 'ORDER BY '.DATABASE_PREFIX.'admin_user.admin_user_login ASC;';
							
						return $this->database->PrintSelectOption($sql_query,$args[0], true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ORDER_STATUS_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'OrderDeliveryTypeDisplayList' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT store_order_delivery_type_id, store_order_delivery_type_name FROM '.DATABASE_PREFIX.'store_order_delivery_type ORDER BY store_order_delivery_type_id;';
							
						return $this->database->PrintTranslatedSelectOption($sql_query,$args[0], true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ORDER_DELIVERY_TYPE_DISPLAY_LIST);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'BasketAdd' : {
				if (isset($args[0])) {
						
					$item_id = $args[0];
			
					$admin_connection_id = NULL;
			
					if (isset($_SESSION[SITE_ID]['connection_id'])) {
						$admin_connection_id = $_SESSION[SITE_ID]['connection_id'];
					} else {
						$admin_connection_id = 0;
					}
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, IFNULL('.DATABASE_PREFIX.'store_inventory.store_inventory_count, 0), IFNULL('.DATABASE_PREFIX.'store_basket.store_basket_quantity, 0) ' .
									 'FROM '.DATABASE_PREFIX.'item ' .
									 'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_inventory ON '.DATABASE_PREFIX.'store_inventory.store_inventory_item_id = '.DATABASE_PREFIX.'item.item_id ' .
									 'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_basket ON '.DATABASE_PREFIX.'store_basket.store_basket_item_id = '.DATABASE_PREFIX.'item.item_id AND '.DATABASE_PREFIX.'store_basket.store_basket_admin_connection_id = '.$this->database->FormatDataToInteger($admin_connection_id).' ' .
									 'WHERE '.DATABASE_PREFIX.'item.item_id = '.$this->database->FormatDataToInteger($item_id).' LIMIT 1';
						
						$result = $this->database->SelectRowQuery($sql_query);
						
						if (isset($result[1]) && is_numeric($result[1])) {
							if ((int)$result[1] > 0) {
								if (isset($result[2]) && is_numeric($result[2])) {
									if ((int)$result[2] >= (int)$result[1]) {
										throw new DataException(BASKET_ADD_NO_INVENTORY);
									}
								}
							} else if ((int)$result[1] == 0) {
								throw new DataException(BASKET_ADD_NO_INVENTORY);
							} else {
								throw new DataException(BASKET_ADD_ERROR);
							}
						} else {
							throw new DataException(BASKET_ADD_NO_INVENTORY);
						}
						
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'store_basket (store_basket_id, store_basket_admin_connection_id, store_basket_item_id, store_basket_quantity) ' .
									  'VALUES ' .
									  '(NULL, ' .
									  ''.$this->database->FormatDataToInteger($admin_connection_id).', ' .
									  ''.$this->database->FormatDataToInteger($item_id).', ' .
									  '1) ON DUPLICATE KEY UPDATE ' .
									  'store_basket_quantity = store_basket_quantity + 1';
			
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(BASKET_ADD_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(BASKET_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BasketEmpty' : {
				$admin_connection_id = NULL;
			
				if (isset($_SESSION[SITE_ID]['connection_id'])) {
					$admin_connection_id = $_SESSION[SITE_ID]['connection_id'];
				} else {
					$admin_connection_id = 0;
				}
					
				try {
					$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'store_basket ' .
								 'WHERE store_basket_admin_connection_id = '.$this->database->FormatDataToInteger($admin_connection_id).';';
					
					$this->database->DeleteQuery($sql_query);
					return $admin_connection_id;
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(BASKET_EMPTY_ERROR);
				}
				break;
			}
			case 'BasketDeleteFromItem' : {
				if (isset($args[0])) {
			
					$item_id = $args[0];
					
					$admin_connection_id = NULL;
						
					if (isset($_SESSION[SITE_ID]['connection_id'])) {
						$admin_connection_id = $_SESSION[SITE_ID]['connection_id'];
					} else {
						$admin_connection_id = 0;
					}
						
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'store_basket ' .
									 'WHERE store_basket_item_id = '.$this->database->FormatDataToInteger($item_id).' AND store_basket_admin_connection_id = '.$this->database->FormatDataToInteger($admin_connection_id).' LIMIT 1;';
							
						$this->database->DeleteQuery($sql_query);
						return $item_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BASKET_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BasketDelete' : {
				if (isset($args[0])) {
						
					$basket_id = $args[0];
			
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'store_basket ' .
									 'WHERE store_basket_id = '.$this->database->FormatDataToInteger($basket_id).' LIMIT 1;';
							
						$this->database->DeleteQuery($sql_query);
						return $basket_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(BASKET_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BasketGet' : {
				$order = 3;
				$sort = 'ASC';
					
				if (isset($args[0]) && ($args[0] > -1)) {
					$order = $args[0];
				}
					
				if (isset($args[1])) {
					if ($args[1] == 'DESC') {
						$sort = $args[1];
					}
				}
				
				$admin_connection_id = NULL;
					
				if (isset($_SESSION[SITE_ID]['connection_id'])) {
					$admin_connection_id = $_SESSION[SITE_ID]['connection_id'];
				} else {
					$admin_connection_id = 0;
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                                //   0
										''.DATABASE_PREFIX.'item_type.item_type_name, ' .                    //   1
										''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .                //   2
										''.DATABASE_PREFIX.'item.item_name, ' .                              //   3
										''.DATABASE_PREFIX.'store_basket.store_basket_quantity, ' . 		  /* SPECIFIC PART */  //   4
										'CONCAT(FORMAT('.DATABASE_PREFIX.'store_basket.store_basket_quantity * '.DATABASE_PREFIX.'item_specific.item_specific_price,2), " ", '.DATABASE_PREFIX.'admin_currency.admin_currency_code) ' . 		      /* SPECIFIC PART */  //   5
										'FROM '.DATABASE_PREFIX.'store_basket ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item ON '.DATABASE_PREFIX.'item.item_id = '.DATABASE_PREFIX.'store_basket.store_basket_item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'admin_currency.admin_currency_id = '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id ' .
										'WHERE '.DATABASE_PREFIX.'store_basket.store_basket_admin_connection_id = '.$this->database->FormatDataToInteger($admin_connection_id).' ' .
										'ORDER BY '.$order.' '.$sort.';';
					
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_BASKET_GET);
				}
				break;
			}
			case 'BasketGetV2' : {
				$admin_connection_id = NULL;
					
				if (isset($_SESSION[SITE_ID]['connection_id'])) {
					$admin_connection_id = $_SESSION[SITE_ID]['connection_id'];
				} else {
					$admin_connection_id = 0;
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'store_basket.store_basket_item_id, ' .                                //   0
								''.DATABASE_PREFIX.'store_basket.store_basket_quantity, ' . 		      /* SPECIFIC PART */  //   1
								'FORMAT('.DATABASE_PREFIX.'store_basket.store_basket_quantity * '.DATABASE_PREFIX.'item_specific.item_specific_price,2), ' . 		      /* SPECIFIC PART */  //   2
								''.DATABASE_PREFIX.'item_specific.item_specific_weight ' . 		      /* SPECIFIC PART */  //   3
								'FROM '.DATABASE_PREFIX.'store_basket ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'store_basket.store_basket_item_id ' .
								'WHERE '.DATABASE_PREFIX.'store_basket.store_basket_admin_connection_id = '.$this->database->FormatDataToInteger($admin_connection_id).' ' .
								'ORDER BY 1 ASC;';
						
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_BASKET_GET_V2);
				}
				break;
			}
			case 'BasketGetCount' : {
					
				$admin_connection_id = NULL;
					
				if (isset($_SESSION[SITE_ID]['connection_id'])) {
					$admin_connection_id = $_SESSION[SITE_ID]['connection_id'];
				} else {
					$admin_connection_id = 0;
				}
					
				try {
					$sql_query = 'SELECT COUNT(*) ' .                                //   0
										'FROM '.DATABASE_PREFIX.'store_basket ' .
										'WHERE '.DATABASE_PREFIX.'store_basket.store_basket_admin_connection_id = '.$this->database->FormatDataToInteger($admin_connection_id).';';
					
					return $this->database->SelectSingleValueQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_BASKET_GET_COUNT);
				}
				break;
			}
			case 'PostalChargesGetWithOrderId' : {
				if (isset($args[0])) {
				
					$order_id = $args[0];
				
					
					try {
						$sql_query = 'SELECT store_order_delivery_price ' .                                //   0
									 'FROM '.DATABASE_PREFIX.'store_order ' .
									 'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).';';
							
						return $this->database->SelectSingleValueQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_POSTAL_CHARGES_GET_WITH_ORDER_ID);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'DiscountGetWithOrderId' : {
				if (isset($args[0])) {
			
					$order_id = $args[0];
			
						
					try {
						$sql_query = 'SELECT store_order_discount ' .                                //   0
									 'FROM '.DATABASE_PREFIX.'store_order ' .
									 'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).';';
							
						return $this->database->SelectSingleValueQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_DISCOUNT_GET_WITH_ORDER_ID);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'BasketCreateOrder' : {
				if (isset($args[0])) {
				
					$order_delivery_type = $args[0];
					$admin_connection_id = NULL;
					$admin_user_email = NULL;
					$admin_user_id = NULL;
					$total_amount = 0;
					$postal_charges = 0;
					
					
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
					
					if (isset($_SESSION[SITE_ID]['user_email'])) {
						$admin_user_email = $_SESSION[SITE_ID]['user_email'];
					} else {
						$admin_user_email = '';
					}
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_basket.store_basket_item_id, ' .                                //   0
											''.DATABASE_PREFIX.'store_basket.store_basket_quantity, ' . 		      /* SPECIFIC PART */  //   1
											'FORMAT('.DATABASE_PREFIX.'store_basket.store_basket_quantity * '.DATABASE_PREFIX.'item_specific.item_specific_price,2), ' . 		      /* SPECIFIC PART */  //   2
											''.DATABASE_PREFIX.'item_specific.item_specific_weight ' . 		      /* SPECIFIC PART */  //   3
											'FROM '.DATABASE_PREFIX.'store_basket ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'store_basket.store_basket_item_id ' .
											'WHERE '.DATABASE_PREFIX.'store_basket.store_basket_admin_connection_id = '.$this->database->FormatDataToInteger($admin_connection_id).' ' .
											'ORDER BY 1 ASC;';
						
						$result = $this->database->SelectTableQuery($sql_query);
						
						$count = count($result);
						
						if ($count > 0) {
							
							// ORDER STATUS
							/*
							 * 0 : CREATED
							 * 1 : VALIDATED
							 * 2 : CANCELLED
							 * 3 : PENDING_PAYMENT
							 * 4 : DELIVERING
							 * 5 : DELIVERED
							 * 6 : CLOSED
							 */
							
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'store_order (store_order_id, ' .
												 'store_order_admin_user_id, ' .
												 'store_order_store_order_status_id, ' .
												 'store_order_store_order_delivery_type_id, ' .
												 'store_order_discount, ' .
												 'store_order_delivery_price, ' .
												 'store_order_creation_date, ' .
												 'store_order_last_update_date, ' .
												 'store_order_last_update_admin_user_id) ' .
									     		 'VALUES ' .
									        	 '(NULL, ' .
									        	 ''.$this->database->FormatDataToInteger($admin_user_id).', ' .
									        	 ''.$_SESSION[SITE_ID]['admin_configuration_store_order_status_initial'].', ' . // CREATED
									        	 ''.$this->database->FormatDataToInteger($order_delivery_type).', ' .
									        	 '0, ' . // DISCOUNT
									        	 '0, ' . // DELIVERY_PRICE
									        	 'NOW(), ' .
									        	 'NOW(), ' .
									        	 ''.$this->database->FormatDataToInteger($admin_user_id).');';
								
							$order_id = $this->database->InsertQuery($sql_query);
							
							$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_status.store_order_status_inventory_reserve ' .                                //   0
												 'FROM '.DATABASE_PREFIX.'store_order_status ' .
												 'WHERE '.DATABASE_PREFIX.'store_order_status.store_order_status_id = '.$_SESSION[SITE_ID]['admin_configuration_store_order_status_initial'].' LIMIT 1;';
								
							$order_status_inventory_reserve = $this->database->SelectSingleValueQuery($sql_query);
							
							for ($i = 0; $i < $count; $i++) {
								
								$total_amount += $result[$i][2];
								
								$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'store_order_line (store_order_line_id, ' .
											 'store_order_line_store_order_id, ' .
											 'store_order_line_number, ' .
											 'store_order_line_item_id, ' .
											 'store_order_line_quantity) ' .
											 'VALUES ' .
											 '(NULL, ' .
											 ''.$this->database->FormatDataToInteger($order_id[1]).', ' .
											 ''.$this->database->FormatDataToInteger($i+1).', ' .
											 ''.$this->database->FormatDataToInteger($result[$i][0]).', ' .
											 ''.$this->database->FormatDataToInteger($result[$i][1]).');';
									
								$this->database->InsertQuery($sql_query);
								
								/* INVENTORY PART */
								if ($order_status_inventory_reserve == '1') { // Status to reserve stock
									
									$sql_query = 'UPDATE '.DATABASE_PREFIX.'store_inventory SET ' .
														 'store_inventory_count = store_inventory_count - '.$this->database->FormatDataToInteger($result[$i][1]).',' .
														 'store_inventory_last_update_date = NOW(), ' .
														 'store_inventory_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' . 
														 'WHERE store_inventory_item_id = '.$this->database->FormatDataToInteger($result[$i][0]).' LIMIT 1;';
										
									$this->database->UpdateQuery($sql_query);
								}
								/* END OF INVENTORY PART */
							}
							
							/* POSTAL CHARGES */
							$postal_charges = Util::GetPostalChargesV2($order_delivery_type);
							
							$sql_query = 'UPDATE '.DATABASE_PREFIX.'store_order SET ' .
												 'store_order_delivery_price = '.$this->database->FormatDataToFloat($postal_charges).' ' .
												 'WHERE store_order_id = '.$this->database->FormatDataToInteger($order_id[1]).' LIMIT 1;';
							
							$this->database->UpdateQuery($sql_query);
							/* END OF POSTAL CHARGES */
							
							/* NOW EMPTY BASKET */
							$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'store_basket ' .
										 'WHERE store_basket_admin_connection_id = '.$this->database->FormatDataToInteger($admin_connection_id).';';
								
							$this->database->DeleteQuery($sql_query);
							/* END OF NOW EMPTY BASKET */
							
							// FINALLY SEND MAIL
							
							$order_line_list = Util::GetOrderLineList($order_id[1], true);
							
							$message = '<?php echo Util::PageGetHtmlTop(); ?>
									      <BODY>
											<TABLE>
												<TR>
													<TD>'.MAIL_ORDER_CREATED_MESSAGE.'<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/order_list.php" TARGET="_blank">'.SITE_TITLE.'</A>.</TD>
												</TR>
												<TR>
													<TD><H3>'.MAIL_ORDER_INFORMATIONS.'</H3></TD>
												</TR>
												<TR>
													<TD>'.Util::GetOrderHeader($order_id[1], true).'</TD>
												</TR>
												<TR>
													<TD><H3>'.ORDER_ITEM_LIST.'</H3></TD>
												</TR>
												<TR>
													<TD>'.$order_line_list[0].'</TD>
												</TR>
												<TR>
													<TD class="max_separator">
												</TR>
												<TR>
													<TD COLSPAN="6">
														<TABLE>
															<TR>
																<TD ALIGN="RIGHT">'.POSTAL_CHARGES_AMOUNT.' :</TD>
																<TD class="field_separator"></TD>
																<TD>'.number_format($postal_charges, 2, '.', '').' &euro;</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>
												<TR>
													<TD COLSPAN="6">
														<TABLE>
															<TR>
																<TD ALIGN="RIGHT"><B>'.TABLE_FULL_AMOUNT.' :</B></TD>
																<TD class="field_separator"></TD>
																<TD><B>'.number_format($order_line_list[1] + $postal_charges, 2, '.', '').' &euro;</B></TD>
															</TR>
														</TABLE>
													</TD>
												</TR>
									       	</TABLE>
									      </BODY>
									     </HTML>';
							
							Util::SendMail($admin_user_email, SITE_TITLE.' - '.MAIL_ORDER_CREATED_1.$order_id[1].MAIL_ORDER_CREATED_2, $message);
							
							return $order_id[1];
						} else {
							throw new DataException(BASKET_IS_EMPTY);
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_BASKET_CREATE_ORDER);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'OrderGetHeader' : {
				if (isset($args[0])) {
					$order_id = $args[0];
						
					$admin_user_id = NULL;
				
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order.store_order_id, ' .                                //   0
											 ''.DATABASE_PREFIX.'store_order_status.store_order_status_id, ' .                    //   1
											 ''.DATABASE_PREFIX.'store_order_status.store_order_status_name, ' .                //   2
											 'DATE_FORMAT('.DATABASE_PREFIX.'store_order.store_order_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .            //   3
											 'DATE_FORMAT('.DATABASE_PREFIX.'store_order.store_order_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . 		  //   4
											 ''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .                //   5
											 ''.DATABASE_PREFIX.'store_order_delivery_type.store_order_delivery_type_name ' .                //   6
											 'FROM '.DATABASE_PREFIX.'store_order ' .
											 'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order_status ON '.DATABASE_PREFIX.'store_order.store_order_store_order_status_id = '.DATABASE_PREFIX.'store_order_status.store_order_status_id ' .
											 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_last_update_admin_user_id ' .
											 'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order_delivery_type ON '.DATABASE_PREFIX.'store_order_delivery_type.store_order_delivery_type_id = '.DATABASE_PREFIX.'store_order.store_order_store_order_delivery_type_id ' .
											 'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).' AND '.DATABASE_PREFIX.'store_order.store_order_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' LIMIT 1;';
				
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ORDER_GET_HEADER);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'OrderGetOwner' : {
				if (isset($args[0])) {
					$order_id = $args[0];
			
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order.store_order_admin_user_id ' .                                //   0
										'FROM '.DATABASE_PREFIX.'store_order ' .
										'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).' LIMIT 1;';
					
						return $this->database->SelectSingleValueQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ORDER_GET_OWNER);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminOrderGetLockStatus' : {
				if (isset($args[0])) {
					$order_id = $args[0];
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_status.store_order_status_lock ' .                                //   0
									 'FROM '.DATABASE_PREFIX.'store_order_status ' .
									 'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order ON '.DATABASE_PREFIX.'store_order.store_order_store_order_status_id = '.DATABASE_PREFIX.'store_order_status.store_order_status_id ' .
									 'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).' LIMIT 1;';
							
						return $this->database->SelectSingleValueQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ADMIN_ORDER_GET_LOCK_STATUS);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminOrderDeleteLine' : {
				if (isset($args[0])) {
						
					$order_line_id = $args[0];
					
					$admin_user_id = NULL;
					
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						/* INVENTORY PART */
						$sql_query = 'UPDATE '.DATABASE_PREFIX.'store_inventory SET ' .
											 'store_inventory_count = store_inventory_count + 1,' .
											 'store_inventory_last_update_date = NOW(), ' .
											 'store_inventory_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
											 'WHERE store_inventory_item_id = (SELECT store_order_line_item_id FROM '.DATABASE_PREFIX.'store_order_line WHERE store_order_line_id = '.$this->database->FormatDataToInteger($order_line_id).' LIMIT 1) LIMIT 1;';
							
						$this->database->UpdateQuery($sql_query);
						/* END OF INVENTORY PART */
						
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'store_order_line ' .
									 'WHERE store_order_line_id = '.$this->database->FormatDataToInteger($order_line_id).' LIMIT 1;';
							
						$this->database->DeleteQuery($sql_query);
						return $order_line_id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ORDER_LINE_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminGetOrderCommentList' : {
				if (isset($args[0])) {
					$order_id = $args[0];
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_text.store_order_text_id, ' .                                //   0
											''.DATABASE_PREFIX.'store_order_text.store_order_text_value, ' .                    //   1
											'DATE_FORMAT('.DATABASE_PREFIX.'store_order_text.store_order_text_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .            //  2
											''.DATABASE_PREFIX.'admin_user.admin_user_login ' .                //   3
											'FROM '.DATABASE_PREFIX.'store_order_text ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order_text.store_order_text_admin_user_id ' .
											'WHERE '.DATABASE_PREFIX.'store_order_text.store_order_text_store_order_id = '.$this->database->FormatDataToInteger($order_id).';';
							
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ORDER_GET_COMMENT);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'GetOrderCommentList' : {
				if (isset($args[0])) {
					$order_id = $args[0];
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_text.store_order_text_id, ' .                                //   0
								''.DATABASE_PREFIX.'store_order_text.store_order_text_value, ' .                    //   1
								'DATE_FORMAT('.DATABASE_PREFIX.'store_order_text.store_order_text_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .            //  2
								''.DATABASE_PREFIX.'admin_user.admin_user_login ' .                //   3
								'FROM '.DATABASE_PREFIX.'store_order_text ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order_text.store_order_text_admin_user_id ' .
								'WHERE '.DATABASE_PREFIX.'store_order_text.store_order_text_store_order_id = '.$this->database->FormatDataToInteger($order_id).';';
				
						return $this->database->SelectTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ERROR_ORDER_GET_COMMENT);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminOrderUpdate' : {
				$result = NULL;
					
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
					
					$order_id = $args[0];
					$order_discount = $args[1];
					$order_status = $args[2];
					
					$admin_user_id = NULL;
					$admin_user_email = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order.store_order_admin_user_id, ' . //   0
									''.DATABASE_PREFIX.'admin_user.admin_user_email ' .                    //   1
									'FROM '.DATABASE_PREFIX.'store_order ' .
									'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_admin_user_id ' .
									'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).' LIMIT 1;';
						
						$result = $this->database->SelectRowQuery($sql_query);
						
						if (isset($result) && count($result) == 2) {
							$admin_user_email = $result[1];
							
							$sql_query = 'UPDATE '.DATABASE_PREFIX.'store_order SET ' .
												 'store_order_store_order_status_id = '.$this->database->FormatDataToInteger($order_status).', ' .
												 'store_order_discount = '.$this->database->FormatDataToFloat($order_discount).', ' .
												 'store_order_last_update_date = NOW(), ' .
												 'store_order_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
												 'WHERE store_order_id = '.$this->database->FormatDataToInteger($order_id).' LIMIT 1;';
								
							$result = $this->database->UpdateQuery($sql_query);
							
							if (isset($result) && $result == 1) {
								
								/* INVENTORY PART */
								$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_status.store_order_status_inventory_reserve, ' .                                //   0
													 ''.DATABASE_PREFIX.'store_order_status.store_order_status_inventory_cleanup ' .                                //   1
												     'FROM '.DATABASE_PREFIX.'store_order_status ' .
													 'WHERE '.DATABASE_PREFIX.'store_order_status.store_order_status_id = '.$this->database->FormatDataToInteger($order_status).' LIMIT 1;';
								
								$order_status_result = $this->database->SelectRowQuery($sql_query);
									
								if ($order_status_result[0] == '1') { // Stock reserve!
										
									$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_line.store_order_line_item_id, ' . //   0
													''.DATABASE_PREFIX.'store_order_line.store_order_line_quantity ' .                    //   1
													'FROM '.DATABASE_PREFIX.'store_order_line ' .
													'WHERE '.DATABASE_PREFIX.'store_order_line.store_order_line_store_order_id = '.$this->database->FormatDataToInteger($order_id).';';
										
									$result = $this->database->SelectTableQuery($sql_query);
										
									for ($i = 0; $i < count($result); $i++) {
										$sql_query = 'UPDATE '.DATABASE_PREFIX.'store_inventory SET ' .
												'store_inventory_count = store_inventory_count - '.$this->database->FormatDataToInteger($result[$i][1]).',' .
												'store_inventory_last_update_date = NOW(), ' .
												'store_inventory_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
												'WHERE store_inventory_item_id = '.$this->database->FormatDataToInteger($result[$i][0]).' LIMIT 1;';
										
										$this->database->UpdateQuery($sql_query);
									}
								}
								
								if ($order_status_result[1] == '1') { // Stock cleanup!
									
									$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order_line.store_order_line_item_id, ' . //   0
														''.DATABASE_PREFIX.'store_order_line.store_order_line_quantity ' .                    //   1
														'FROM '.DATABASE_PREFIX.'store_order_line ' .
														'WHERE '.DATABASE_PREFIX.'store_order_line.store_order_line_store_order_id = '.$this->database->FormatDataToInteger($order_id).';';
									
									$result = $this->database->SelectTableQuery($sql_query);
									
									for ($i = 0; $i < count($result); $i++) {
										$sql_query = 'UPDATE '.DATABASE_PREFIX.'store_inventory SET ' .
															 'store_inventory_count = store_inventory_count + '.$this->database->FormatDataToInteger($result[$i][1]).',' .
															 'store_inventory_last_update_date = NOW(), ' .
															 'store_inventory_last_update_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
															 'WHERE store_inventory_item_id = '.$this->database->FormatDataToInteger($result[$i][0]).' LIMIT 1;';
											
										$this->database->UpdateQuery($sql_query);
									}
								}
								/* END OF INVENTORY PART */
								
								$order_line_list = Util::AdminGetOrderLineList($order_id, true);
								$comment = Util::GetOrderCommentList($order_id);
								$postal_charges = Util::GetPostalChargesWithOrderId($order_id);
								$discount = Util::GetDiscountWithOrderId($order_id);
							
								$message = '<?php echo Util::PageGetHtmlTop(); ?>
										      <BODY>
												<TABLE>
													<TR>
														<TD>'.MAIL_ORDER_UPDATED_MESSAGE.'<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/'.LOWER_LANG.'/pages/order_list.php" TARGET="_blank">'.SITE_TITLE.'</A>.</TD>
													</TR>
													<TR>
														<TD><H3>'.MAIL_ORDER_INFORMATIONS.'</H3></TD>
													</TR>
													<TR>
														<TD>'.Util::AdminGetOrderHeader($order_id, true).'</TD>
													</TR>
													<TR>
														<TD><H3>'.ORDER_ITEM_LIST.'</H3></TD>
													</TR>
													<TR>
														<TD>'.$order_line_list[0].'</TD>
													</TR>
													<TR>
														<TD class="max_separator">
													</TR>
													<TR>
														<TD COLSPAN="6">
															<TABLE>
																<TR>
																	<TD ALIGN="RIGHT">'.POSTAL_CHARGES_AMOUNT.' :</TD>
																	<TD class="field_separator"></TD>
																	<TD>'.number_format($postal_charges, 2, '.', '').' &euro;</TD>
																</TR>
															</TABLE>
														</TD>
													</TR>';
									
								if ($discount > 0) {
										
									$message .= '<TR>
													<TD COLSPAN="6">
														<TABLE>
															<TR>
																<TD ALIGN="RIGHT">'.ORDER_DISCOUNT.' :</TD>
																<TD class="field_separator"></TD>
																<TD>'.number_format($discount, 2, '.', '').' &euro;</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>';
								}
									
								$message .= '<TR>
														<TD COLSPAN="6">
															<TABLE>
																<TR>
																	<TD ALIGN="RIGHT"><B>'.TABLE_FULL_AMOUNT.' :</B></TD>
																	<TD class="field_separator"></TD>
																	<TD><B>'.number_format($order_line_list[1] + $postal_charges - $discount, 2, '.', '').' &euro;</B></TD>
																</TR>
															</TABLE>
														</TD>
													</TR>
													<TR>
														<TD class="title"><H3>'.ORDER_COMMENT.'</H3></TD>
													</TR>
													<TR>
														<TD>
															<TABLE>
													    		'.$comment.'
													    	</TABLE>
														</TD>
													</TR>
										       	</TABLE>
										      </BODY>
										     </HTML>';
							
								Util::SendMail($admin_user_email, SITE_TITLE.' - '.MAIL_ORDER_UPDATED_1.$order_id.MAIL_ORDER_UPDATED_2, $message);
									
								return $order_id;
							}
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ORDER_UPDATE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminOrderCommentAdd' : {
				$result = NULL;
					
				if (isset($args[0]) &&
					isset($args[1])) {
						
					$order_id = $args[0];
					$order_text_value = $args[1];
						
					$admin_user_id = NULL;
					$admin_user_email = NULL;
						
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
						
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order.store_order_admin_user_id, ' . //   0
											''.DATABASE_PREFIX.'admin_user.admin_user_email ' .                    //   1
											'FROM '.DATABASE_PREFIX.'store_order ' .
											'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_admin_user_id ' .
											'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).' LIMIT 1;';
						
						$result = $this->database->SelectRowQuery($sql_query);
						
						if (isset($result) && count($result) == 2) {
							$admin_user_email = $result[1];
							
							$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'store_order_text (store_order_text_id, store_order_text_store_order_id, store_order_text_value, store_order_text_creation_date, store_order_text_admin_user_id) ' .
										 'VALUES ' .
										 '(NULL, ' .
										 ''.$this->database->FormatDataToInteger($order_id).', ' .
										 ''.$this->database->FormatDataToVarchar($order_text_value, 10000).', ' .
										 'NOW(), ' .
										 ''.$this->database->FormatDataToInteger($admin_user_id).');';
								
							$result = $this->database->InsertQuery($sql_query);
								
							if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
								
								$order_line_list = Util::AdminGetOrderLineList($order_id, true);
								$comment = Util::GetOrderCommentList($order_id);
								$postal_charges = Util::GetPostalChargesWithOrderId($order_id);
								$discount = Util::GetDiscountWithOrderId($order_id);
									
								$message = '<?php echo Util::PageGetHtmlTop(); ?>
										      <BODY>
												<TABLE>
													<TR>
														<TD>'.MAIL_ORDER_COMMENT_ADDED_MESSAGE.'<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/pages/order_list.php" TARGET="_blank">'.SITE_TITLE.'</A>.</TD>
													</TR>
													<TR>
														<TD><H3>'.MAIL_ORDER_INFORMATIONS.'</H3></TD>
													</TR>
													<TR>
														<TD>'.Util::AdminGetOrderHeader($order_id, true).'</TD>
													</TR>
													<TR>
														<TD><H3>'.ORDER_ITEM_LIST.'</H3></TD>
													</TR>
													<TR>
														<TD>'.$order_line_list[0].'</TD>
													</TR>
													<TR>
														<TD class="max_separator">
													</TR>
													<TR>
														<TD COLSPAN="6">
															<TABLE>
																<TR>
																	<TD ALIGN="RIGHT">'.POSTAL_CHARGES_AMOUNT.' :</TD>
																	<TD class="field_separator"></TD>
																	<TD>'.number_format($postal_charges, 2, '.', '').' &euro;</TD>
																</TR>
															</TABLE>
														</TD>
													</TR>';
								
								if ($discount > 0) {
								
									$message .= '<TR>
													<TD COLSPAN="6">
														<TABLE>
															<TR>
																<TD ALIGN="RIGHT">'.ORDER_DISCOUNT.' :</TD>
																<TD class="field_separator"></TD>
																<TD>'.number_format($discount, 2, '.', '').' &euro;</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>';
								}
								
									$message .= '<TR>
														<TD COLSPAN="6">
															<TABLE>
																<TR>
																	<TD ALIGN="RIGHT"><B>'.TABLE_FULL_AMOUNT.' :</B></TD>
																	<TD class="field_separator"></TD>
																	<TD><B>'.number_format($order_line_list[1] + $postal_charges - $discount, 2, '.', '').' &euro;</B></TD>
																</TR>
															</TABLE>
														</TD>
													</TR>
													<TR>
														<TD class="title"><H3>'.ORDER_COMMENT.'</H3></TD>
													</TR>
													<TR>
														<TD>
															<TABLE>
													    		'.$comment.'
													    	</TABLE>
														</TD>
													</TR>
										       	</TABLE>
										      </BODY>
										     </HTML>';
									
								Util::SendMail($admin_user_email, SITE_TITLE.' - '.MAIL_ORDER_COMMENT_ADDED_1.$order_id.MAIL_ORDER_COMMENT_ADDED_2, $message);
								
								return $result[1];
							}
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_MENU_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_ORDER_COMMENT_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'OrderCommentAdd' : {
				$result = NULL;
					
				if (isset($args[0]) &&
					isset($args[1])) {
			
					$order_id = $args[0];
					$order_text_value = $args[1];
			
					$admin_user_id = NULL;
					$admin_user_email = NULL;
			
					if (isset($_SESSION[SITE_ID]['user_id'])) {
						$admin_user_id = $_SESSION[SITE_ID]['user_id'];
					} else {
						$admin_user_id = 0;
					}
					
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order.store_order_admin_user_id, ' . //   0
											 ''.DATABASE_PREFIX.'admin_user.admin_user_email ' .                    //   1
											 'FROM '.DATABASE_PREFIX.'store_order ' .
											 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_admin_user_id ' .
											 'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).' LIMIT 1;';
						
						$result = $this->database->SelectRowQuery($sql_query);
						
						if (isset($result) && count($result) == 2) {
							if ($admin_user_id == $result[0]) {
							
								$admin_user_email = $result[1];
						
								$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'store_order_text (store_order_text_id, store_order_text_store_order_id, store_order_text_value, store_order_text_creation_date, store_order_text_admin_user_id) ' .
													'VALUES ' .
													'(NULL, ' .
													''.$this->database->FormatDataToInteger($order_id).', ' .
													''.$this->database->FormatDataToVarchar($order_text_value, 10000).', ' .
													'NOW(), ' .
													''.$this->database->FormatDataToInteger($admin_user_id).');';
									
								$result = $this->database->InsertQuery($sql_query);
									
								if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
									$order_line_list = Util::GetOrderLineList($order_id, true);
									$comment = Util::GetOrderCommentList($order_id);
									$postal_charges = Util::GetPostalChargesWithOrderId($order_id);
									$discount = Util::GetDiscountWithOrderId($order_id);
									
									$message = '<?php echo Util::PageGetHtmlTop(); ?>
											      <BODY>
													<TABLE>
														<TR>
															<TD>'.MAIL_ORDER_COMMENT_ADDED_MESSAGE.'<A HREF="'.$_SESSION[SITE_ID]['admin_configuration_site_name'].'/'.LOWER_LANG.'/pages/order_list.php" TARGET="_blank">'.SITE_TITLE.'</A>.</TD>
														</TR>
														<TR>
															<TD><H3>'.MAIL_ORDER_INFORMATIONS.'</H3></TD>
														</TR>
														<TR>
															<TD>'.Util::GetOrderHeader($order_id, true).'</TD>
														</TR>
														<TR>
															<TD><H3>'.ORDER_ITEM_LIST.'</H3></TD>
														</TR>
														<TR>
															<TD>'.$order_line_list[0].'</TD>
														</TR>
														<TR>
															<TD class="max_separator">
														</TR>
														<TR>
															<TD COLSPAN="6">
																<TABLE>
																	<TR>
																		<TD ALIGN="RIGHT">'.POSTAL_CHARGES_AMOUNT.' :</TD>
																		<TD class="field_separator"></TD>
																		<TD>'.number_format($postal_charges, 2, '.', '').' &euro;</TD>
																	</TR>
																</TABLE>
															</TD>
														</TR>';
										
									if ($discount > 0) {
											
										$message .= '<TR>
														<TD COLSPAN="6">
															<TABLE>
																<TR>
																	<TD ALIGN="RIGHT">'.ORDER_DISCOUNT.' :</TD>
																	<TD class="field_separator"></TD>
																	<TD>'.number_format($discount, 2, '.', '').' &euro;</TD>
																</TR>
															</TABLE>
														</TD>
													</TR>';
									}
										
									$message .= '<TR>
															<TD COLSPAN="6">
																<TABLE>
																	<TR>
																		<TD ALIGN="RIGHT"><B>'.TABLE_FULL_AMOUNT.' :</B></TD>
																		<TD class="field_separator"></TD>
																		<TD><B>'.number_format($order_line_list[1] + $postal_charges - $discount, 2, '.', '').' &euro;</B></TD>
																	</TR>
																</TABLE>
															</TD>
														</TR>
														<TR>
															<TD class="title"><H3>'.ORDER_COMMENT.'</H3></TD>
														</TR>
														<TR>
															<TD>
																<TABLE>
														    		'.$comment.'
														    	</TABLE>
															</TD>
														</TR>
											       	</TABLE>
											      </BODY>
											     </HTML>';
									
									Util::SendMail($admin_user_email, SITE_TITLE.' - '.MAIL_ORDER_COMMENT_ADDED_1.$order_id.MAIL_ORDER_COMMENT_ADDED_2, $message);
										
									return $result[1];
								}
							} else {
								throw new DataException(ORDER_COMMENT_NOT_YOUR_ORDER_ERROR);
							}
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ORDER_COMMENT_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ORDER_COMMENT_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminOrderGetHeader' : {
				$order_id = $args[0];
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order.store_order_id, ' .                                //   0
								''.DATABASE_PREFIX.'store_order_status.store_order_status_id, ' .                    //   1
								''.DATABASE_PREFIX.'store_order_status.store_order_status_name, ' .                //   2
								'DATE_FORMAT('.DATABASE_PREFIX.'store_order.store_order_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .            //   3
								'DATE_FORMAT('.DATABASE_PREFIX.'store_order.store_order_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . 		  //   4
								'order_user.admin_user_login, ' .                //   5
								'last_user.admin_user_login, ' .                 //   6
								''.DATABASE_PREFIX.'store_order.store_order_admin_user_id, ' .                //   7
								''.DATABASE_PREFIX.'store_order.store_order_last_update_admin_user_id, ' .     //   8
								''.DATABASE_PREFIX.'store_order_delivery_type.store_order_delivery_type_name, ' .                //   9
								''.DATABASE_PREFIX.'store_order_status.store_order_status_lock ' .                //   10
								'FROM '.DATABASE_PREFIX.'store_order ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order_status ON '.DATABASE_PREFIX.'store_order.store_order_store_order_status_id = '.DATABASE_PREFIX.'store_order_status.store_order_status_id ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user order_user ON order_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_admin_user_id ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user last_user ON last_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_last_update_admin_user_id ' .
								'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order_delivery_type ON '.DATABASE_PREFIX.'store_order_delivery_type.store_order_delivery_type_id = '.DATABASE_PREFIX.'store_order.store_order_store_order_delivery_type_id ' .
								'WHERE '.DATABASE_PREFIX.'store_order.store_order_id = '.$this->database->FormatDataToInteger($order_id).' LIMIT 1;';
					
					return $this->database->SelectRowQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ORDER_GET_HEADER);
				}
				break;
			}
			case 'OrderGetLineList' : {
				$order = 3;
				$sort = 'ASC';
				
				$order_id = $args[0];
					
				if (isset($args[1]) && ($args[1] > -1)) {
					$order = $args[1];
				}
					
				if (isset($args[2])) {
					if ($args[2] == 'DESC') {
						$sort = $args[2];
					}
				}
			
				$admin_user_id = NULL;
				
				if (isset($_SESSION[SITE_ID]['user_id'])) {
					$admin_user_id = $_SESSION[SITE_ID]['user_id'];
				} else {
					$admin_user_id = 0;
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                                //   0
										''.DATABASE_PREFIX.'item_type.item_type_name, ' .                    //   1
										''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .                //   2
										''.DATABASE_PREFIX.'item.item_name, ' .                              //   3
										''.DATABASE_PREFIX.'store_order_line.store_order_line_quantity, ' . 		  /* SPECIFIC PART */  //   4
										'CONCAT(FORMAT('.DATABASE_PREFIX.'store_order_line.store_order_line_quantity * '.DATABASE_PREFIX.'item_specific.item_specific_price,2), " ", '.DATABASE_PREFIX.'admin_currency.admin_currency_code), ' . 		      /* SPECIFIC PART */  //   5
										''.DATABASE_PREFIX.'store_order_line.store_order_line_id ' .                //   6
										'FROM '.DATABASE_PREFIX.'store_order_line ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order ON '.DATABASE_PREFIX.'store_order.store_order_id = '.DATABASE_PREFIX.'store_order_line.store_order_line_store_order_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item ON '.DATABASE_PREFIX.'item.item_id = '.DATABASE_PREFIX.'store_order_line.store_order_line_item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'admin_currency.admin_currency_id = '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id ' .
										'WHERE '.DATABASE_PREFIX.'store_order_line.store_order_line_store_order_id = '.$this->database->FormatDataToInteger($order_id).' AND '.DATABASE_PREFIX.'store_order.store_order_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
										'ORDER BY '.$order.' '.$sort.';';
						
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ORDER_GET_LIST);
				}
				break;
			}
			case 'AdminOrderGetLineList' : {
				$order = 3;
				$sort = 'ASC';
			
				$order_id = $args[0];
					
				if (isset($args[1]) && ($args[1] > -1)) {
					$order = $args[1];
				}
					
				if (isset($args[2])) {
					if ($args[2] == 'DESC') {
						$sort = $args[2];
					}
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'item.item_id, ' .                                //   0
							''.DATABASE_PREFIX.'item_type.item_type_name, ' .                    //   1
							''.DATABASE_PREFIX.'item_type_2.item_type_2_name, ' .                //   2
							''.DATABASE_PREFIX.'item.item_name, ' .                              //   3
							''.DATABASE_PREFIX.'store_order_line.store_order_line_quantity, ' . 		  /* SPECIFIC PART */  //   4
							'CONCAT(FORMAT('.DATABASE_PREFIX.'store_order_line.store_order_line_quantity * '.DATABASE_PREFIX.'item_specific.item_specific_price,2), " ", '.DATABASE_PREFIX.'admin_currency.admin_currency_code), ' . 		      /* SPECIFIC PART */  //   5
							''.DATABASE_PREFIX.'store_order_line.store_order_line_id ' .                //   6
							'FROM '.DATABASE_PREFIX.'store_order_line ' .
							'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order ON '.DATABASE_PREFIX.'store_order.store_order_id = '.DATABASE_PREFIX.'store_order_line.store_order_line_store_order_id ' .
							'LEFT OUTER JOIN '.DATABASE_PREFIX.'item ON '.DATABASE_PREFIX.'item.item_id = '.DATABASE_PREFIX.'store_order_line.store_order_line_item_id ' .
							'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'item.item_id ' .
							'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type ON '.DATABASE_PREFIX.'item_type.item_type_id = '.DATABASE_PREFIX.'item.item_item_type_id ' .
							'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_type_2 ON '.DATABASE_PREFIX.'item_type_2.item_type_2_id = '.DATABASE_PREFIX.'item.item_item_type_2_id ' .
							'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_currency ON '.DATABASE_PREFIX.'admin_currency.admin_currency_id = '.DATABASE_PREFIX.'item_specific.item_specific_admin_currency_id ' .
							'WHERE '.DATABASE_PREFIX.'store_order_line.store_order_line_store_order_id = '.$this->database->FormatDataToInteger($order_id).' ' .
							'ORDER BY '.$order.' '.$sort.';';
			
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ADMIN_ORDER_GET_LIST);
				}
				break;
			}
			case 'OrderGetList' : {
				$order = 3;
				$sort = 'ASC';
			
				if (isset($args[0]) && ($args[0] > -1)) {
					$order = $args[0];
				}
					
				if (isset($args[1])) {
					if ($args[1] == 'DESC') {
						$sort = $args[1];
					}
				}
					
				$admin_user_id = NULL;
			
				if (isset($_SESSION[SITE_ID]['user_id'])) {
					$admin_user_id = $_SESSION[SITE_ID]['user_id'];
				} else {
					$admin_user_id = 0;
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order.store_order_id, ' .                                //   0
								 'DATE_FORMAT('.DATABASE_PREFIX.'store_order.store_order_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .            //   3
								 'DATE_FORMAT('.DATABASE_PREFIX.'store_order.store_order_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . 		  //   4
								 ''.DATABASE_PREFIX.'store_order_status.store_order_status_name, ' .                //   2
								 'COUNT('.DATABASE_PREFIX.'store_order_line.store_order_line_item_id), ' .                //   5
								 'FORMAT(SUM('.DATABASE_PREFIX.'store_order_line.store_order_line_quantity * '.DATABASE_PREFIX.'item_specific.item_specific_price) + '.DATABASE_PREFIX.'store_order.store_order_delivery_price,2) ' .                    //   1
								 'FROM '.DATABASE_PREFIX.'store_order ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order_line ON '.DATABASE_PREFIX.'store_order.store_order_id = '.DATABASE_PREFIX.'store_order_line.store_order_line_store_order_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order_status ON '.DATABASE_PREFIX.'store_order_status.store_order_status_id = '.DATABASE_PREFIX.'store_order.store_order_store_order_status_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_admin_user_id ' .
								 'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'store_order_line.store_order_line_item_id ' .
								 'WHERE '.DATABASE_PREFIX.'store_order.store_order_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ' .
								 'GROUP BY '.DATABASE_PREFIX.'store_order.store_order_id ' .
								 'ORDER BY '.$order.' '.$sort.';';
			
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ORDER_GET_LIST);
				}
				break;
			}
			case 'AdminOrderGetList' : {
				$order = 3;
				$sort = 'ASC';
					
				if (isset($args[0]) && ($args[0] > -1)) {
					$order = $args[0];
				}
					
				if (isset($args[1])) {
					if ($args[1] == 'DESC') {
						$sort = $args[1];
					}
				}

				$order_status_id = '';
				
				if (isset($args[2])) {
					$order_status_id = $args[2];
				}
				
				$admin_user_id = '';
				
				if (isset($args[3])) {
					$admin_user_id = $args[3];
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'store_order.store_order_id, ' .                                //   0
										''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .            //   1
										'DATE_FORMAT('.DATABASE_PREFIX.'store_order.store_order_creation_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' .            //   2
										'DATE_FORMAT('.DATABASE_PREFIX.'store_order.store_order_last_update_date, \''.DATABASE_DATETIME_FORMAT.'\'), ' . 		  //   3
										''.DATABASE_PREFIX.'store_order_status.store_order_status_name, ' .                //   4
										'COUNT('.DATABASE_PREFIX.'store_order_line.store_order_line_item_id), ' .                //   5
										'FORMAT(SUM('.DATABASE_PREFIX.'store_order_line.store_order_line_quantity * '.DATABASE_PREFIX.'item_specific.item_specific_price) + '.DATABASE_PREFIX.'store_order.store_order_delivery_price,2) ' .                    //   6
										'FROM '.DATABASE_PREFIX.'store_order ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order_line ON '.DATABASE_PREFIX.'store_order.store_order_id = '.DATABASE_PREFIX.'store_order_line.store_order_line_store_order_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'store_order_status ON '.DATABASE_PREFIX.'store_order_status.store_order_status_id = '.DATABASE_PREFIX.'store_order.store_order_store_order_status_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'store_order.store_order_admin_user_id ' .
										'LEFT OUTER JOIN '.DATABASE_PREFIX.'item_specific ON '.DATABASE_PREFIX.'item_specific.item_specific_item_id = '.DATABASE_PREFIX.'store_order_line.store_order_line_item_id ' .
										'WHERE 1 ';
					
					if ($order_status_id != '') {
						$sql_query .= 'AND '.DATABASE_PREFIX.'store_order.store_order_store_order_status_id = '.$this->database->FormatDataToInteger($order_status_id).' ';
					}
					
					if ($admin_user_id != '') {
						$sql_query .= 'AND '.DATABASE_PREFIX.'store_order.store_order_admin_user_id = '.$this->database->FormatDataToInteger($admin_user_id).' ';
					}
					
					$sql_query .= 'GROUP BY '.DATABASE_PREFIX.'store_order.store_order_id ' .
								  'ORDER BY '.$order.' '.$sort.';';
					
							
							
					return $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ERROR_ORDER_GET_LIST);
				}
				break;
			}
/////// END OF STORE PART

/////// LOG ADMINISTRATION PART
			case 'AdminSaveLog' : {
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
						
						if ($_SESSION[SITE_ID]['admin_configuration_log_database']) {
							try {
								$sql_query = 'INSERT INTO '.DATABASE_PREFIX.'admin_log (admin_log_id, admin_log_date, admin_log_admin_connection_id, admin_log_admin_user_id, admin_log_name, admin_log_description) ' .
								     		 'VALUES ' .
								        	 '(NULL, ' .
								        	 'NOW(), ' .
								       	     ''.$this->database->FormatDataToInteger($admin_connection_id).', ' .
								        	 ''.$this->database->FormatDataToInteger($admin_user_id).', ' .
								        	 ''.$this->database->FormatDataToVarchar($name, 100).', ' .
								        	 ''.$this->database->FormatDataToVarchar($description, 400).');';
							
								$this->database->InsertQuery($sql_query);
							} catch (SqlException $ex) {
								$this->AdminSaveError($method, $ex->getError());
								throw new DataException(ERROR_ADMIN_SAVE_LOG);
							}
						}
						
						if ($_SESSION[SITE_ID]['admin_configuration_log_file']) {
							$file = new File(LOG_DIRECTORY.date('Ymd').'.log');
							$file->WriteLine(date('Ymd|h:i:s').'|url:'.$_SERVER['PHP_SELF'].'|name:'.$name.'|description:'.$description);
						}
						
						if ($_SESSION[SITE_ID]['admin_configuration_log_show']) {
							$show = new Show();
							$show->SayLine($name.'|'.$description);
						}
					}
				}
				break;
			}
			case 'AdminLogDelete' : {
				$result = NULL;
					
				if (isset($args[0]) &&
				isset($args[1])) {
						
					$log_delete_start_date = $args[0];
					$log_delete_end_date = $args[1];
						
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.'admin_log ' .
										'WHERE admin_log_date BETWEEN '.$this->database->FormatDataToDate($log_delete_start_date, DATABASE_DATE_FORMAT).' ' .
										'AND '.$this->database->FormatDataToDate($log_delete_end_date, DATABASE_DATE_FORMAT).';';
							
						$result = $this->database->DeleteQuery($sql_query);
							
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_LOG_DELETE_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminLogGetList' : {
				$result = NULL;
					
				$order = '2,4';
					
				$sort = 'DESC';
					
				if (isset($args[0]) && ($args[0] > -1)) {
					$order = $args[0];
				}
					
				if (isset($args[1])) {
					if ($args[1] == 'ASC') {
						$sort = $args[1];
					}
				}
					
				try {
					$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_log.admin_log_id, ' .
									''.DATABASE_PREFIX.'admin_log.admin_log_date, ' .
									''.DATABASE_PREFIX.'admin_user.admin_user_login, ' .
									''.DATABASE_PREFIX.'admin_log.admin_log_name, ' .
									''.DATABASE_PREFIX.'admin_log.admin_log_description ' .
									'FROM '.DATABASE_PREFIX.'admin_log ' .
									'LEFT OUTER JOIN '.DATABASE_PREFIX.'admin_user ON '.DATABASE_PREFIX.'admin_user.admin_user_id = '.DATABASE_PREFIX.'admin_log.admin_log_admin_user_id ' .
									'ORDER BY '.$order.' '.$sort.';';
						
					$result = $this->database->SelectTableQuery($sql_query);
				} catch (SqlException $ex) {
					$this->AdminSaveError($method, $ex->getError());
					throw new DataException(ADMIN_LOG_GET_LIST_ERROR);
				}
					
				return $result;
					
				break;
			}
/////// END OF LOG ADMINISTRATION PART
			
/////// SPECIFIC TABLE PART
			case 'AdminGetTableFields' : {
				if (isset($args[0])) {
					$table = strtolower($args[0]);
			
					try {
						$sql_query = 'SHOW COLUMNS FROM '.DATABASE_PREFIX.$table.';';
							
						return $this->database->SelectAssocTableQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_GET_TABLE_FIELDS_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'SpecificTableDisplayList' : {
				if (isset($args[0]) &&
				isset($args[1])) {
			
					$table_name = strtolower($args[0]);
					$selected = $args[1];
						
					try {
						$sql_query = 'SELECT '.$table_name.'_id, '.$table_name.'_name FROM '.DATABASE_PREFIX.$table_name.' ORDER BY '.$table_name.'_name;';
			
						return $this->database->PrintSelectOption($sql_query,$selected, true);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(SPECIFIC_TABLE_DISPLAY_LIST_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
					
				break;
			}
			case 'AdminSpecificGet' : {
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
					
					$table_name = $args[0];
					$fields = $args[1];
					$id = $args[2];
					
					try {
						$sql_query = 'SELECT ';

						$i = 0;
						
						foreach ($fields as $field) {
							
							if ($i > 0) {
								$sql_query .= ', ';
							}
							
							$sql_query .= $field['Field'];
							$i++;
						}
						
						$sql_query .= ' FROM '.DATABASE_PREFIX.$table_name.' ' .
									  'WHERE '.DATABASE_PREFIX.$table_name.'.'.$table_name.'_id = '.$this->database->FormatDataToInteger($id).' ' .
									  'LIMIT 1;';
						
						return $this->database->SelectRowQuery($sql_query);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_SPECIFIC_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				
				break;
			}
			case 'AdminSpecificAdd' : {
				$result = NULL;
			
				if (isset($args[0]) &&
					isset($args[1])) {
						
						
					$table_name = $args[0];
					$values = $args[1];
						
					try {
						$sql_query = 'INSERT INTO '.DATABASE_PREFIX.$table_name.' (';
						
						$i = 0;
						
						foreach ($values as $value) {
							
							if ($i > 0) {
								$sql_query .= ', ';
							}
							
							$sql_query .= $value[0];
							$i++;
						}
						
						$sql_query .= ')
						VALUES 
						(';
						
						$i = 0;
						foreach ($values as $value) {
							
							if ($i > 0) {
								$sql_query .= ', 
								';
							}
							
							switch($value[2]) {
								case 'int':
								case 'bigint':
								case 'tinyint': {
									$sql_query .= $this->database->FormatDataToInteger($value[1]);
									break;
								}
								case 'datetime ': {
									$sql_query .= $this->database->FormatDataToDate($value[1], DATABASE_DATE_FORMAT);
									break;
								}
								case 'constant': {
									$sql_query .= $value[1];
									break;
								}
								case 'varchar':
								default: {
									$sql_query .= $this->database->FormatDataToVarchar($value[1], $value[3]);
									break;
								}
							}
							
							$i++;
						}
						
						$sql_query .= ');';
						
						$result = $this->database->InsertQuery($sql_query);
			
						if (isset($result[0]) && isset($result[1]) && $result[0] == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_SPECIFIC_ADD_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_SPECIFIC_ADD_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				return $result;

				break;
			}
			case 'AdminSpecificUpdate' : {
				$result = NULL;
			
				if (isset($args[0]) &&
					isset($args[1]) &&
					isset($args[2])) {
						
					$id = $args[0];
					$table_name = $args[1];
					$values = $args[2];
						
					try {
						$sql_query = 'UPDATE '.DATABASE_PREFIX.$table_name.' SET ';
						
						$i = 0;
						
						foreach ($values as $value) {
							if ($value[0] != $table_name.'_id') {
									
								if ($i > 0) {
									$sql_query .= ', ';
								}
							
								$sql_query .= $value[0].' = ';
								
								switch($value[2]) {
									case 'int':
									case 'bigint':
									case 'tinyint': {
										$sql_query .= $this->database->FormatDataToInteger($value[1]);
										break;
									}
									case 'datetime ': {
										$sql_query .= $this->database->FormatDataToDate($value[1], DATABASE_DATE_FORMAT);
										break;
									}
									case 'constant': {
										$sql_query .= $value[1];
										break;
									}
									case 'varchar':
									default: {
										$sql_query .= $this->database->FormatDataToVarchar($value[1], $value[3]);
										break;
									}
								}
								
								$i++;
							}
						}
						
						$sql_query .= ' WHERE '.$table_name.'_id = '.$this->database->FormatDataToInteger($id).' LIMIT 1;';
						
						$result = $this->database->UpdateQuery($sql_query);
			
						if (isset($result) && $result == 1) {
							return $result[1];
						}
					} catch (SqlException $ex) {
						if ($ex->getErrorNumber() == 1062) {
							throw new DataException(ADMIN_SPECIFIC_UPDATE_DUPLICATE_KEY);
						} else {
							$this->AdminSaveError($method, $ex->getError());
							throw new DataException(ADMIN_SPECIFIC_UPDATE_ERROR);
						}
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				return $result;

				break;
			}
			case 'AdminSpecificDelete' : {
				if (isset($args[0]) &&
				isset($args[1])) {
						
					$id = $args[0];
					$table_name = $args[1];
						
					try {
						$sql_query = 'DELETE FROM '.DATABASE_PREFIX.$table_name.' ' .
								'WHERE '.$table_name.'_id = '.$this->database->FormatDataToInteger($id).' LIMIT 1;';
							
						$result = $this->database->DeleteQuery($sql_query);
			
						return $id;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(constant('ADMIN_'.strtoupper($table_name).'_DELETE_ERROR'));
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
				break;
			}
			case 'AdminSpecificTableListGet' : {
				if (isset($args[0])) {
					try {
						$sql_query = 'SELECT '.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_header_name, ' .
											''.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_database_column_id, ' .
											''.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_align, ' .
											''.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_format, ' .
											''.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_order, ' .
											''.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_database_link_id, ' .
											''.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_link, ' .
											''.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_link_target, ' .
											''.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_number ' .
											'FROM '.DATABASE_PREFIX.'admin_specific_table_list ' .
											'WHERE '.DATABASE_PREFIX.'admin_specific_table_list.admin_specific_table_list_table_name = '.$this->database->FormatDataToVarchar($args[0], 50).' ' .
											'ORDER BY 9 ASC;';
							
						$header_list = $this->database->SelectTableQuery($sql_query);
			
						for ($i = 0; $i < count($header_list); $i++) {
							$header = $header_list[$i];
							$header[0] = constant($header[0]);
							$header_list[$i] = $header;
						}
			
						return $header_list;
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_SPECIFIC_TABLE_LIST_GET_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
			case 'AdminSpecificTableGetList' : {
				if (isset($args[0])) {
					$table_name = $args[0];
					$order = -1;
					$sort = '';
			
					if (isset($args[1])) {
						$order = $args[1];
					}
						
					if (isset($args[2])) {
						$sort = $args[2];
					}
						
					try {
						$sql_query_1 = 'SELECT '.DATABASE_PREFIX.'admin_specific_table_selection.admin_specific_table_selection_table_select, ' .
								''.DATABASE_PREFIX.'admin_specific_table_selection.admin_specific_table_selection_default_order, ' .
								''.DATABASE_PREFIX.'admin_specific_table_selection.admin_specific_table_selection_default_sort ' .
								'FROM '.DATABASE_PREFIX.'admin_specific_table_selection ' .
								'WHERE admin_specific_table_selection_table_name = '.$this->database->FormatDataToVarchar($args[0], 50).' ' .
								'LIMIT 1;';
			
						$result = $this->database->SelectRowQuery($sql_query_1);
			
						if ($order == -1) {
							$order = $result[1];
						}
			
						if ($sort == '') {
							$sort = $result[2];
						}
			
						$sql_query_2 = $result[0].' '.$order.' '.$sort;
			
						return $this->database->SelectTableQuery($sql_query_2);
					} catch (SqlException $ex) {
						$this->AdminSaveError($method, $ex->getError());
						throw new DataException(ADMIN_ROLE_GET_LIST_ERROR);
					}
				} else {
					throw new DataException(MISSING_ARGUMENT_ERROR);
				}
			
				break;
			}
/////// SPECIFIC TABLE PART END
			default:
				throw new DataException(MISSING_METHOD_ERROR);
				break;
		}
	}
}

include_once($root.'./library/data_specific.php');
?>