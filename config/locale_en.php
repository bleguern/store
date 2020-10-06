<?php
/* V1.3
 * 
 * V1.1 : 20130524 : Links
 * V1.2 : 20131004 : Menu style added
 * V1.3 : 20131015 : Item type 2 added
 * 
 */

// Lang

define ('LANG','EN');
define ('LOWER_LANG','en');

// Legals

define ('LEGALS', 'Design & development');

// Date

define ('DATABASE_DATE_FORMAT','%m/%d/%Y');
define ('DATABASE_DATE_YEAR_FORMAT','%Y');
define ('DATABASE_DATETIME_FORMAT','%m/%d/%Y %H:%i:%s');
define ('PHP_DATE_FORMAT','m/d/Y');
define ('PHP_DATETIME_FORMAT','m/d/Y H:i:s');
define ('HTML_DATE_FORMAT','mm/dd/YYYY');

define('ON', 'On ');
define('AT', ' at ');
define('BY', ' by ');
define('FROM', ' from ');
define('YEAR', 'year old');
define('YEARS', 'years old');
define('THIS_YEAR', 'Born this year!');
define('READ_NEXT', '...read next');

define('JANUARY', 'January');
define('FEBRUARY', 'Februry');
define('MARCH', 'March');
define('APRIL', 'April');
define('MAY', 'May');
define('JUNE', 'June');
define('JULY', 'July');
define('AUGUST', 'August');
define('SEPTEMBER', 'September');
define('OCTOBER', 'October');
define('NOVEMBER', 'November');
define('DECEMBER', 'December');
define('JANUARY_LITTLE', 'Jan');
define('FEBRUARY_LITTLE', 'Feb');
define('MARCH_LITTLE', 'Mar');
define('APRIL_LITTLE', 'Apr');
define('MAY_LITTLE', 'May');
define('JUNE_LITTLE', 'Jun');
define('JULY_LITTLE', 'Jul');
define('AUGUST_LITTLE', 'Aug');
define('SEPTEMBER_LITTLE', 'Sep');
define('OCTOBER_LITTLE', 'Oct');
define('NOVEMBER_LITTLE', 'Nov');
define('DECEMBER_LITTLE', 'Dec');

define('MONDAY', 'Monday');
define('TUESDAY', 'Tuesday');
define('WEDNESDAY', 'Wednesday');
define('THURSDAY', 'Thursday');
define('FRIDAY', 'Friday');
define('SATURDAY', 'Saturday');
define('SUNDAY', 'Sunday');

define('MONDAY_LITTLE', 'Mon');
define('TUESDAY_LITTLE', 'Tue');
define('WEDNESDAY_LITTLE', 'Wed');
define('THURSDAY_LITTLE', 'Thu');
define('FRIDAY_LITTLE', 'Fri');
define('SATURDAY_LITTLE', 'Sat');
define('SUNDAY_LITTLE', 'Sun');

define('MONDAY_LETTER', 'M');
define('TUESDAY_LETTER', 'T');
define('WEDNESDAY_LETTER', 'W');
define('THURSDAY_LETTER', 'T');
define('FRIDAY_LETTER', 'F');
define('SATURDAY_LETTER', 'S');
define('SUNDAY_LETTER', 'S');

define('TODAY', 'Today');

// General

define ('ERROR', 'Error');
define ('LOADING', 'Loading...');

define ('YES', 'Yes');
define ('NO', 'No');

define ('BACK', 'Back');
define ('NEW', 'New');
define ('UPDATE', 'Update');
define ('DELETE', 'Delete');
define ('ADD', 'Add');

define ('UPLOAD_MAIN_IMAGE', 'Upload main image');
define ('UPLOAD_IMAGE', 'Upload image');

define ('MANDATORY_FIELDS','* : Mandatory field');

define ('NO_RESULT','No result');

define ('TABLE_TOTAL_NUMBER','Total');
define ('TABLE_PAGE_NUMBER','page');

define ('LAST_UPDATE_DATE','Last update');
define ('LAST_UPDATE_USER','User');

// Error logging

define ('ERROR_FATAL','Fatal error : please contact <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'" TARGET="_blank">administrator</A>!');
define ('ERROR_INITIALISE','Initialise error : please contact <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'" TARGET="_blank">administrator</A>!');

define ('MISSING_ARGUMENT_ERROR', 'Missing field(s)!');
define ('MISSING_METHOD_ERROR', 'Missing method!');
define ('MISSING_FIELDS_ERROR', 'Missing field(s)!');

define ('ERROR_LOGIN','Login error!');
define ('ERROR_LOGOUT','Logout error!');

define ('ERROR_LOAD_URL','URL loading error!');

define ('ERROR_RIGHT','Rights error!');

define ('ERROR_ADMIN_SAVE_LOG','Save log error!');

define ('ERROR_USER_SAVE_CONNECTION','User save connection error!');
define ('ERROR_USER_GET_PASSWORD','User password error!');
define ('ERROR_USER_GET_INFORMATION','User information error!');
define ('ERROR_USER_GET_RIGHT','User right error!');
define ('ERROR_ITEM_GET_ACTIVE_LIST','Get active list error!');
define ('ERROR_GET_HOME_ACTIVE_ITEM_LIST','Get home active item list error!');

define ('ERROR_SAVE_CONNECTION_ERROR','Save connection error!');

define ('GET_LIST_ERROR','List error!');

define ('MESSAGE_BAD_LOGIN','Username or password is incorrect!');
define ('MESSAGE_USER_DESACTIVATED','User has been desactivated : please contact <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'" TARGET="_blank">administrator</A>!');

define ('MESSAGE_AUTHORISATION','You are not authorized to access this page!');

// Site definition

define ('MENU', 'Menu');
define ('MENU_HOME', 'Home');
define ('MENU_BLOG', 'Blog');
define ('MENU_CONTACT', 'Contact');
define ('MENU_CONNECTION', 'Connection');
define ('MENU_DISCONNECTION', 'Disconnection');
define ('MENU_ADMIN', 'Admin');
define ('MENU_ADMIN_ACCESS', 'Access');
define ('MENU_ADMIN_ERROR', 'Errors');
define ('MENU_ADMIN_ITEM', 'Items');
define ('MENU_ADMIN_LOG', 'Logs');
define ('MENU_ADMIN_BLOG', 'Blog');
define ('MENU_ADMIN_LINKS', 'Links');
define ('MENU_ADMIN_ROLE', 'Roles');
define ('MENU_ADMIN_STATS', 'Stats');
define ('MENU_ADMIN_SITE_THEME', 'Theme');
define ('MENU_ADMIN_VERSION', 'Version');
define ('MENU_ADMIN_USER', 'Users');
define ('MENU_ADMIN_MENU', 'Menu');
define ('MENU_ADMIN_ITEM_TYPE', 'Data type');
define ('MENU_ADMIN_ITEM_TYPE_2', 'Data category');
define ('MENU_LINKS', 'Links');
define ('MENU_SEARCH', '');

// Store mode

define ('MENU_CONNECTION_ACCOUNT', 'My account');
define ('MENU_CONNECTION_BASKET', 'My basket');
define ('MENU_CONNECTION_ORDER', 'My orders');
define ('MENU_ADMIN_ORDER', 'Orders');
define ('MENU_ADMIN_ORDER_STATUS', 'Order status');

define ('ADD_TO_BASKET', 'Add to basket');
define ('NOT_AVAILABLE', 'Not available');
define ('BASKET_ADDED', 'Item added to <A HREF="../pages/basket.php" TARGET="_self">basket</A>!');
define ('BASKET_ADD_NO_INVENTORY', 'Item not added, not enough inventory!'); 
define ('BASKET_DELETED', 'Item deleted from basket');
define ('BASKET_GO_TO_ORDER_QUESTION', 'Are you sure you want to go to order?');
define ('PLEASE_CONNECT_BEFORE_CREATE_ORDER', 'Veuillez-vous connecter ou créer un compte pour saisir une commande!');
define ('PLEASE_CONNECT_BEFORE_LIST_ORDER', 'Veuillez-vous connecter ou créer un compte pour lister vos commandes!');
define ('GO_TO_ORDER', 'Go to order');
define ('EMPTY_BASKET', 'Empty basket');
define ('BASKET_EMPTIED', 'Basket emptied!');
define ('BASKET_IS_EMPTY', 'Your basket is empty!');
define ('BASKET_TITLE', 'My basket');
define ('BASKET_DELETE_QUESTION', 'Are you sure you want to empty your basket?');
define ('GET_BASKET_ERROR', 'Basket loading error!');

define ('QUANTITY', 'Quantity');
define ('PRICE', 'Price');
define ('UNIT_PRICE', 'Unit price');
define ('TOTAL_PRICE', 'Total price');

define ('TABLE_TOTAL_AMOUNT','Item sub-total');
define ('POSTAL_CHARGES_AMOUNT','Delivery amount');
define ('ORDER_DISCOUNT','Discount');
define ('TABLE_FULL_AMOUNT','Total amount');

define ('ADMIN_ORDER_LIST_TITLE','Order list');
define ('ADMIN_ORDER_STATUS_LIST_TITLE','Order status list');
define ('ADMIN_ORDER_STATUS_ADD_TITLE','Add order order status');
define ('ADMIN_ORDER_STATUS_UPDATE_TITLE','Update order status');
define ('ADMIN_ORDER_STATUS_ADD_ADD','Add');
define ('ADMIN_ORDER_STATUS_UPDATE_UPDATE','Update');
define ('ADMIN_ORDER_STATUS_DELETE_DELETE','Delete');
define ('ADMIN_ORDER_STATUS_DUPLICATE_KEY','Order status already exists!');
define ('ADMIN_ORDER_STATUS_ADDED','Order status added!');
define ('ADMIN_ORDER_STATUS_ADD_ERROR','Order status not added!');
define ('ADMIN_ORDER_STATUS_UPDATE_ERROR','Error while order status update!');
define ('ADMIN_ORDER_STATUS_UPDATED','Order status updated!');
define ('ADMIN_ORDER_STATUS_DELETED','Order status deleted!');
define ('ADMIN_ORDER_STATUS_DELETE_QUESTION','Are you sure you want to delete this order status?');
define ('ADMIN_ORDER_STATUS_ID','ID');
define ('ADMIN_ORDER_STATUS_NAME','Status');
define ('ADMIN_ORDER_STATUS_ACTIVE','Active');
define ('ADMIN_ORDER_STATUS_INVENTORY_RESERVE','Inventory reserve');
define ('ADMIN_ORDER_STATUS_INVENTORY_CLEANUP','Inventory cleanup');
define ('ADMIN_ORDER_STATUS_LOCK','Order lock');
define ('ADMIN_ORDER_STATUS_OTHER_POSSIBLE_STATUS','Other possible status');
define ('ORDER_TITLE','Order');
define ('ERROR_ORDER_GET_HEADER','Order header loading error!');
define ('CANCEL_ORDER','Cancel order');
define ('ORDER_CREATED','Order created!');
define ('ORDER_CREATION_DATE','Creation date');
define ('ORDER_STATUS','Order status');
define ('ORDER_LAST_UPDATE','Last update');
define ('ORDER_LAST_UPDATE_BY',' by ');
define ('ORDER_ITEM_LIST','Item list');
define ('ORDER_ITEM_COUNT','Item number');
define ('ORDER_LIST_TITLE','My orders');
define ('ORDER_NUMBER','Order n°');
define ('ORDER_CUSTOMER','Customer');
define ('ORDER_USER','User');

define ('ORDER_UPDATE_UPDATE','Update');
define ('ADMIN_ORDER_UPDATED','Order updated!');
define ('ADMIN_ORDER_LINE_DELETED','Order line deleted!');
define ('ORDER_ADD_COMMENT','Add a comment');
define ('ORDER_COMMENT','Comment');
define ('ORDER_COMMENT_ADDED','Comment added!');
define ('ADMIN_ORDER_COMMENT_ADDED','Comment added!');
define ('ORDER_COMMENT_NOT_YOUR_ORDER_ERROR','Impossible to add a comment on this order!');

define ('MAIL_ORDER_CREATED_1','Order n°');
define ('MAIL_ORDER_CREATED_2',' created');
define ('MAIL_ORDER_ORDER_NUMBER','Order number');
define ('MAIL_ORDER_INFORMATIONS','Informations');
define ('MAIL_ORDER_SEE_ONLINE','Manage order online');
define ('MAIL_ORDER_CREATED_MESSAGE', '<H2>Hello,</H2><BR>
Your order has been successfully created, and will next validated. An email will be sent on each order modification.<BR>
If you want to see another order, please check your order list on ');

define ('MAIL_ORDER_UPDATED_1','Order n°');
define ('MAIL_ORDER_UPDATED_2',' updated');
define ('MAIL_ORDER_UPDATED_MESSAGE', '<H2>Hello,</H2><BR>
Your order have been updated. An email will be sent on each order modification.<BR>
If you want to see another order, please check your order list on ');

define ('MAIL_ORDER_COMMENT_ADDED_1','Order n°');
define ('MAIL_ORDER_COMMENT_ADDED_2',' : comment added');
define ('MAIL_ORDER_COMMENT_ADDED_MESSAGE', '<H2>Hello,</H2><BR>
A comment has been added to your order. An email will be sent on each order modification.<BR>
If you want to see another order, please check your order list on ');


define ('ORDER_STATUS_CREATED','Created');
define ('ORDER_STATUS_VALIDATED','Validated');
define ('ORDER_STATUS_CANCELLED','Cancelled');
define ('ORDER_STATUS_PENDING_PAYMENT','Pending payment');
define ('ORDER_STATUS_DELIVERING','Delivering...');
define ('ORDER_STATUS_DELIVERED','Delivered');
define ('ORDER_STATUS_CLOSED','Closed');


define ('ORDER_DELIVERY_TYPE','Delivery type');

define ('ORDER_DELIVERY_TYPE_POST','Send by post');
define ('ORDER_DELIVERY_TYPE_HAND_OVER','Hand over delivery');


define ('BASKET_INFORMATIONS_TITLE','Informations');
define ('BASKET_INFORMATIONS_EMPTY_MESSAGE','To buy one or more items now, click on "Add to backet" button.<BR><BR>Item avaibility and price are subject to change.<BR><BR>A question on item or this website? Please go to <A HREF="contact.php" TARGET="_self"><B>contact</B></A> page.');
define ('BASKET_INFORMATIONS_NOT_EMPTY_MESSAGE','You can now go to order or choose more item on this website.<BR><BR>Item avaibility and price are subject to change.<BR><BR>A question on item or this website? Please go to <A HREF="contact.php" TARGET="_self"><B>contact</B></A> page.');

// Value 

define ('VALUE_TEXT_LANG_DISPLAY_LIST_ERROR','Text lang list error!');

// Login

define ('LOGIN_LOGIN_TITLE', 'Connect to site');
define ('LOGIN_LOGOUT_TITLE', 'Disconnect from site');
define ('LOGIN_LOGIN', 'Login');
define ('LOGIN_PASSWORD', 'Password');
define ('LOGIN_CONNECT', 'Connect');
define ('LOGIN_CONNECTED', 'User connected!');;
define ('LOGIN_CONNECTED_AS', 'Connected as ');
define ('LOGIN_DISCONNECT', 'Disconnect');
define ('LOGIN_DISCONNECTED', 'User disconnected!');
define ('LOGIN_INCORRECT', 'Login or password incorrect!');
define ('LOGIN_INACTIVE', 'User not activated! Please contact <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'" TARGET="_blank">administrator</A>');
define ('LOGIN_CONNECT_ERROR', 'Login error!');
define ('LOGIN_DISCONNECT_ERROR', 'Logout error!');
define ('LOGIN_CREATE_ACCOUNT', 'Create an account');
define ('LOGIN_FORGOT_PASSWORD', 'Forgot password');
define ('LOGIN_REGISTER', 'Register');
define ('LOGIN_RESET_PASSWORD', 'Reset password');
define ('MAIL_ACCOUNT_CREATED', 'Account created : ');
define ('PASSWORD_RESETED', 'Password reseted!');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_1', '<H2>Hello,</H2><BR>
Your account has been successfully created on our website.<BR><BR>
Your credentials informations :<BR>
User : ');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_2', '<BR>Password : ');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_3', '<BR>
Please mind capital letters.<BR><BR>
You can now logon on our website at this address : ');
define ('MAIL_REGISTERED', 'Account created : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_1', '<H2>Hello	,</H2><BR>
Your account has been successfully created on our website.<BR><BR>
Your credentials informations :<BR>
User / email : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_2', '<BR>Password : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_3', '<BR>
Please mind capital letters.<BR><BR>
You can now logon on our website at this address : ');
define ('MAIL_RESET_PASSWORD', 'Reset password');
define ('MAIL_RESET_PASSWORD_MESSAGE_1', '<H2>Hello,</H2><BR>
Your password has been successfully reseted on our website.<BR><BR>
Here is your new password : ');
define ('MAIL_RESET_PASSWORD_MESSAGE_2', '<BR>
Please mind capital letters.<BR><BR>
You can now logon on our website at this address : ');

// Account

define ('ACCOUNT_CREATED', 'Account created');
define ('ACCOUNT_REGISTERED', 'Account created');
define ('UPDATE_ACCOUNT_TITLE','My account');


// Contact

define ('CONTACT_TITLE', 'Contact');
define ('CONTACT_EMAIL', 'Your email');
define ('CONTACT_NAME', 'Your name');
define ('CONTACT_MESSAGE', 'Your message');
define ('CONTACT_COPY', 'Send a copy to my address');
define ('CONTACT_SEND', 'Send message');
define ('CONTACT_MESSAGE_SENT', 'Message sent!');
define ('CONTACT_MAIL_MESSAGE', 'Message');
define ('CONTACT_FORM', 'Contact form');
define ('CONTACT_INFORMATIONS', 'Informations');

// Link

define ('LINK_TITLE', 'Links');

// Link

define ('ADMIN_TITLE', 'Administration');

// Item type

define ('ITEM_TYPE_ADD_TITLE', 'Add data type');
define ('ITEM_TYPE_ADD_ADD', 'Add type');
define ('ITEM_TYPE_NAME', 'Type');
define ('ITEM_TYPE_LOGO_FILENAME', 'Logo');
define ('ITEM_TYPE_LIST_TITLE', 'Data type list');
define ('ITEM_TYPE_DUPLICATE_KEY','Data type already exists!');
define ('ITEM_TYPE_ADDED','Data type added!');
define ('ITEM_TYPE_ADD_ERROR','Data type add error!');
define ('ITEM_TYPE_UPDATE_UPDATE','Data type update');
define ('ITEM_TYPE_DELETE_DELETE','Data type delete');
define ('ITEM_TYPE_UPDATE_TITLE','Update data type');
define ('ITEM_TYPE_UPDATED','Data type updated!');
define ('ITEM_TYPE_UPDATE_ERROR','Data type update error!');
define ('ITEM_TYPE_GET_ERROR','Data type get error!');
define ('ITEM_TYPE_DELETE_QUESTION','Are you sure you want to delete this data type?');
define ('ITEM_TYPE_DELETED','Data type deleted!');
define ('ITEM_TYPE_DELETE_ERROR','Data type delete error!');
define ('ITEM_TYPE_DELETE_CONSTRAINT','Data type could not be deleted : constraint!');

// Item type 2

define ('ITEM_TYPE_2_ADD_TITLE', 'Add data type 2');
define ('ITEM_TYPE_2_ADD_ADD', 'Add type 2');
define ('ITEM_TYPE_2_NAME', 'Type 2');
define ('ITEM_TYPE_2_LIST_TITLE', 'Data type 2 list');
define ('ITEM_TYPE_2_DUPLICATE_KEY','Data type 2 already exists!');
define ('ITEM_TYPE_2_ADDED','Data type 2 added!');
define ('ITEM_TYPE_2_ADD_ERROR','Data type 2 add error!');
define ('ITEM_TYPE_2_UPDATE_UPDATE','Data type 2 update');
define ('ITEM_TYPE_2_DELETE_DELETE','Data type 2 delete');
define ('ITEM_TYPE_2_UPDATE_TITLE','Update data type 2');
define ('ITEM_TYPE_2_UPDATED','Data type 2 updated!');
define ('ITEM_TYPE_2_UPDATE_ERROR','Data type 2 update error!');
define ('ITEM_TYPE_2_GET_ERROR','Data type get error!');
define ('ITEM_TYPE_2_DELETE_QUESTION','Are you sure you want to delete this data type 2?');
define ('ITEM_TYPE_2_DELETED','Data type 2 deleted!');
define ('ITEM_TYPE_2_DELETE_ERROR','Data type 2 delete error!');
define ('ITEM_TYPE_2_DELETE_CONSTRAINT','Data type 2 could not be deleted : constraint!');

// Access

define ('ADMIN_ACCESS_ADD_TITLE', 'Add access');
define ('ADMIN_ACCESS_ADD_ADD', 'Add access');
define ('ADMIN_ACCESS_URL', 'Url');
define ('ADMIN_ACCESS_DESCRIPTION', 'Description');
define ('ADMIN_ACCESS_LIST_TITLE', 'Access list');
define ('ADMIN_ACCESS_DUPLICATE_KEY','Access already exists!');
define ('ADMIN_ACCESS_ADDED','Access added');
define ('ADMIN_ACCESS_ADD_ERROR','Access add error!');
define ('ADMIN_ACCESS_UPDATE_UPDATE','Access update');
define ('ADMIN_ACCESS_DELETE_DELETE','Access delete');
define ('ADMIN_ACCESS_UPDATE_TITLE','Update access');
define ('ADMIN_ACCESS_UPDATED','Access updated!');
define ('ADMIN_ACCESS_UPDATE_ERROR','Access update error!');
define ('ADMIN_ACCESS_GET_ERROR','Access get error!');
define ('ADMIN_ACCESS_DELETE_QUESTION','Are you sure you want to delete this access?');
define ('ADMIN_ACCESS_DELETED','Access deleted!');
define ('ADMIN_ACCESS_DELETE_ERROR','Access delete error!');

// Role

define ('ADMIN_ROLE_ADD_TITLE', 'Add role');
define ('ADMIN_ROLE_ADD_ADD', 'Add role');
define ('ADMIN_ROLE_NAME', 'Url');
define ('ADMIN_ROLE_LIST_TITLE', 'Role list');
define ('ADMIN_ROLE_DUPLICATE_KEY','Role already exists!');
define ('ADMIN_ROLE_ADDED','Role added!');
define ('ADMIN_ROLE_ADD_ERROR','Role add error!');
define ('ADMIN_ROLE_ACCESS_ADDED','Role access added!');
define ('ADMIN_ROLE_ACCESS_ADD_ERROR','Role access add error!');
define ('ADMIN_ROLE_ACCESS_DELETED','Role access deleted!');
define ('ADMIN_ROLE_ACCESS_DELETE_ERROR','Role access delete error!');
define ('ADMIN_ROLE_UPDATE_UPDATE','Role update');
define ('ADMIN_ROLE_DELETE_DELETE','Role delete');
define ('ADMIN_ROLE_UPDATE_TITLE','Update role');
define ('ADMIN_ROLE_UPDATED','Role updated!');
define ('ADMIN_ROLE_UPDATE_ERROR','Role update error!');
define ('ADMIN_ROLE_GET_ERROR','Role get error!');
define ('ADMIN_ROLE_DELETE_QUESTION','Are you sure you want to delete this role?');
define ('ADMIN_ROLE_DELETED','Role deleted!');
define ('ADMIN_ROLE_DELETE_ERROR','Role delete error!');
define ('ADMIN_ROLE_GET_LIST_ERROR', 'Role get list error!');
define ('ADMIN_ROLE_ACCESS_GET_LIST_ERROR', 'Role access get list error!');

// User

define ('ADMIN_USER_ADD_TITLE', 'Add user');
define ('ADMIN_USER_ADD_ADD', 'Add user');
define ('ADMIN_USER_ROLE', 'Role');
define ('ADMIN_USER_ACTIVE', 'Active');
define ('ADMIN_USER_LOGIN', 'Login');
define ('ADMIN_USER_PASSWORD', 'Password');
define ('ADMIN_USER_PASSWORD2', 'Password (confirm)');
define ('ADMIN_USER_OLD_PASSWORD', 'Old password');
define ('ADMIN_USER_EMAIL', 'Email');
define ('ADMIN_USER_LANG', 'Language');
define ('ADMIN_USER_THEME', 'Theme');
define ('ADMIN_USER_FIRST_NAME', 'First name');
define ('ADMIN_USER_LAST_NAME', 'Last name');
define ('ADMIN_USER_PHONE', 'Phone');
define ('ADMIN_USER_LIST_TITLE', 'User list');
define ('ADMIN_USER_DUPLICATE_KEY','User already exists!');
define ('ADMIN_USER_ADDED','User added!');
define ('ADMIN_USER_ADD_ERROR','User add error!');
define ('ADMIN_USER_UPDATE_UPDATE','User update');
define ('ADMIN_USER_DELETE_DELETE','User delete');
define ('ADMIN_USER_UPDATE_TITLE','Update user');
define ('ADMIN_USER_UPDATED','User updated!');
define ('ADMIN_USER_UPDATE_ERROR','User update error!');
define ('ADMIN_USER_GET_ERROR','User get error!');
define ('ADMIN_USER_DELETE_QUESTION','Are you sure you want to delete this user?');
define ('ADMIN_USER_DELETED','User deleted!');
define ('ADMIN_USER_DELETE_ERROR','User delete error!');
define ('ADMIN_USER_GET_LIST_ERROR', 'User get list error!');
define ('ADMIN_USER_PASSWORD_NOT_THE_SAME', 'Passwords are not the same!');
define ('ADMIN_USER_RESET_PASSWORD','Reset');
define ('ADMIN_USER_RESET_PASSWORD_QUESTION','Are you sure you want to reset user password to \'password\'?');
define ('ADMIN_USER_PASSWORD_RESETED','Password reseted!');
define ('ADMIN_USER_PASSWORD_RESET_ERROR','Password reset error!');
define ('ADMIN_USER_GET_PASSWORD_WITH_USER_LOGIN_ERROR','Get password error!');
define ('ADMIN_USER_GET_INFORMATION_WITH_USER_LOGIN_ERROR','Get user information error!');
define ('ADMIN_USER_OLD_PASSWORD_INCORRECT','Old password is incorrect!');
define ('ADMIN_USER_ACCOUNT_UPDATE_ERROR','Account update error!');
define ('ADMIN_USER_GET_PASSWORD_WITH_USER_ID_ERROR','Password getting error!');
define ('ADMIN_USER_ACCOUNT_UPDATED','Account updated!');
define ('ADMIN_USER_EMAIL_NOT_CORRECT', 'Email format is incorrect!');
define ('ADMIN_USER_PASSWORD_RESET_MISSING_EMAIL', 'Email not available!');
define ('ADMIN_USER_ADDRESS_LINE_1','Address line 1');
define ('ADMIN_USER_ADDRESS_LINE_2','Address line 2');
define ('ADMIN_USER_ADDRESS_LINE_3','Address line 3');
define ('ADMIN_USER_ADDRESS_POSTAL_CODE','Postal code');
define ('ADMIN_USER_ADDRESS_CITY','City');
define ('ADMIN_USER_ADDRESS_REGION','Region');
define ('ADMIN_USER_ADDRESS_COUNTRY','Country');
define ('ADMIN_USER_USEFULL_FOR_DELIVERIES','Usefull informations for deliveries');



// Error

define ('ADMIN_ERROR_LIST_TITLE', 'Error list');
define ('ADMIN_ERROR_GET_LIST_ERROR', 'Error get list error!');
define ('ADMIN_ERROR_DATE', 'Date');
define ('ADMIN_ERROR_USER', 'User');
define ('ADMIN_ERROR_URL', 'Url');
define ('ADMIN_ERROR_NAME', 'Name');
define ('ADMIN_ERROR_DESCRIPTION', 'Description');
define ('ADMIN_ERROR_DELETE_START_DATE', 'Delete errors from date');
define ('ADMIN_ERROR_DELETE_END_DATE', 'to');
define ('ADMIN_ERROR_DELETE_DELETE', 'Delete');
define ('ADMIN_ERROR_DELETE_QUESTION', 'Are you sure you want to delete this error range?');
define ('ADMIN_ERROR_DELETED', 'Error(s) deleted!');
define ('ADMIN_ERROR_DELETE_ERROR', 'Error delete error!');

// Log

define ('ADMIN_LOG_LIST_TITLE', 'Log list');
define ('ADMIN_LOG_GET_LIST_ERROR', 'Log get list error!');
define ('ADMIN_LOG_DATE', 'Date');
define ('ADMIN_LOG_USER', 'User');
define ('ADMIN_LOG_NAME', 'Name');
define ('ADMIN_LOG_DESCRIPTION', 'Description');
define ('ADMIN_LOG_DELETE_START_DATE', 'Delete logs from date');
define ('ADMIN_LOG_DELETE_END_DATE', 'to');
define ('ADMIN_LOG_DELETE_DELETE', 'Delete');
define ('ADMIN_LOG_DELETE_QUESTION', 'Are you sure you want to delete this log range?');
define ('ADMIN_LOG_DELETED', 'Log(s) deleted!');
define ('ADMIN_LOG_DELETE_ERROR', 'Log delete error!');

// Version

define ('ADMIN_VERSION_LIST_TITLE', 'Version list');
define ('ADMIN_VERSION_ADD_ADD', 'Add a version');
define ('ADMIN_VERSION_ADD_TITLE', 'Add a version');
define ('ADMIN_VERSION_GET_LIST_ERROR', 'Version get list error!');
define ('ADMIN_VERSION_NUMBER', 'Number');
define ('ADMIN_VERSION_NAME', 'Name');
define ('ADMIN_VERSION_DATE', 'Date');
define ('ADMIN_VERSION_DESCRIPTION', 'Description');
define ('ADMIN_VERSION_UPDATE_UPDATE','Update version');
define ('ADMIN_VERSION_UPDATE_TITLE','Version update');
define ('ADMIN_VERSION_UPDATED','Version updated!');
define ('ADMIN_VERSION_UPDATE_ERROR','Version not updated!');
define ('ADMIN_VERSION_GET_ERROR','Version loading error!');
define ('ADMIN_VERSION_DELETE_DELETE','Delete');
define ('ADMIN_VERSION_DELETED', 'Version deleted!');
define ('ADMIN_VERSION_DELETE_ERROR', 'Version delete error!');
define ('ADMIN_VERSION_ADDED', 'Version added!');
define ('ADMIN_VERSION_ADD_ERROR', 'Version add error!');
define ('ADMIN_VERSION_DUPLICATE_KEY','Version already exists!');
define ('ADMIN_VERSION_DELETE_QUESTION','Are you sure you want to delete this version?');

// Site theme

define ('ADMIN_SITE_THEME_LIST_TITLE', 'Theme list');
define ('ADMIN_SITE_THEME_ADD_ADD', 'Add a theme');
define ('ADMIN_SITE_THEME_ADD_TITLE', 'Add a theme');
define ('ADMIN_SITE_THEME_GET_LIST_ERROR', 'Theme list error');
define ('ADMIN_SITE_THEME_CODE', 'Code');
define ('ADMIN_SITE_THEME_NAME', 'Name');
define ('ADMIN_SITE_THEME_UPDATE_UPDATE','Update theme');
define ('ADMIN_SITE_THEME_UPDATE_TITLE','Theme update');
define ('ADMIN_SITE_THEME_UPDATED','Theme updated!');
define ('ADMIN_SITE_THEME_UPDATE_ERROR','Theme not updated!');
define ('ADMIN_SITE_THEME_GET_ERROR','Theme loading error!');
define ('ADMIN_SITE_THEME_DELETE_DELETE','Delete');
define ('ADMIN_SITE_THEME_DELETED', 'Theme deleted!');
define ('ADMIN_SITE_THEME_DELETE_ERROR', 'Theme delete error!');
define ('ADMIN_SITE_THEME_ADDED', 'Theme added!');
define ('ADMIN_SITE_THEME_ADD_ERROR', 'Theme add error!');
define ('ADMIN_SITE_THEME_DUPLICATE_KEY','Theme already exists!');
define ('ADMIN_SITE_THEME_DELETE_QUESTION','Are you sure you want to delete this theme?');

// Menu

define ('ADMIN_MENU_ADD_TITLE', 'Add menu');
define ('ADMIN_MENU_ADD_ADD', 'Add menu');
define ('ADMIN_MENU_NAME', 'Name');
define ('ADMIN_MENU_ACCESS', 'Access');
define ('ADMIN_MENU_LINK', 'Link');
define ('ADMIN_MENU_TARGET', 'Link target');
define ('ADMIN_MENU_LEVEL_0', 'Level 0');
define ('ADMIN_MENU_LEVEL_1', 'Level 1');
define ('ADMIN_MENU_STYLE', 'Style');
define ('ADMIN_MENU_ITEM_TYPE', 'Data type');
define ('ADMIN_MENU_ITEM_TYPE_2', 'Data category');
define ('ADMIN_MENU_IMAGE', 'Image');
define ('ADMIN_MENU_LIST_TITLE', 'Menu list');
define ('ADMIN_MENU_DUPLICATE_KEY','Menu already exists!');
define ('ADMIN_MENU_ADDED','Menu added');
define ('ADMIN_MENU_ADD_ERROR','Menu add error!');
define ('ADMIN_MENU_UPDATE_UPDATE','Menu update');
define ('ADMIN_MENU_UPDATE_TITLE','Update menu');
define ('ADMIN_MENU_UPDATED','Menu updated!');
define ('ADMIN_MENU_UPDATE_ERROR','Menu update error!');
define ('ADMIN_MENU_GET_ERROR','Menu get error!');
define ('ADMIN_MENU_DELETE_DELETE','Delete');
define ('ADMIN_MENU_DELETED','Menu deleted!');
define ('ADMIN_MENU_DELETE_ERROR','Menu not deleted!');
define ('ADMIN_MENU_DELETE_QUESTION','Are you sure you want to delete this menu?');

// Blog

define ('BLOG_ADD_TITLE', 'Add blog');
define ('BLOG_ADD_ADD', 'Add blog');
define ('BLOG_ACTIVE', 'Visible');
define ('BLOG_TEXT_LANG', 'Language');
define ('BLOG_TEXT_TITLE', 'Title');
define ('BLOG_TEXT_VALUE', 'Description');
define ('BLOG_LIST_TITLE', 'Blog list');
define ('BLOG_LAST_LIST_TITLE', 'Last blog');
define ('BLOG_DUPLICATE_KEY','Blog already exists!');
define ('BLOG_ADDED','Blog added!');
define ('BLOG_ADD_ERROR','Blog add error!');
define ('BLOG_UPDATE_UPDATE','Blog update');
define ('BLOG_UPDATE_TITLE','Update blog');
define ('BLOG_UPDATED','Blog updated!');
define ('BLOG_UPDATE_ERROR','Blog update error!');
define ('BLOG_GET_ERROR','Blog get error!');
define ('BLOG_DELETE_DELETE','Delete');
define ('BLOG_DELETED','Blog deleted!');
define ('BLOG_DELETE_ERROR','Blog not deleted!');
define ('BLOG_DELETE_QUESTION','Are you sure you want to delete this blog?');
define ('BLOG_TMP_IMAGE_LOADED','Blog temporary image loaded!');
define ('BLOG_IMAGE_LOADED','Blog image loaded!');
define ('BLOG_IMAGE_DELETED','Blog image deleted!');
define ('BLOG_IMAGE',' ');
define ('BLOG_GET_LIST_ERROR','Blog get list error!');
define ('BLOG_IMAGE_UPDATE_ERROR','Blog image update error!');
define ('BLOG_IMAGE_DELETE_ERROR','Blog image delete error!');
define ('BLOG_ACTIVATE_ERROR','Blog activate error!');
define ('BLOG_HITS','view(s)');

// Links

define ('LINKS_ADD_TITLE', 'Add link');
define ('LINKS_ADD_ADD', 'Add link');
define ('LINKS_ACTIVE', 'Visible');
define ('LINKS_TEXT_LANG', 'Language');
define ('LINKS_LINK', 'Link');
define ('LINKS_TITLE', 'Title');
define ('LINKS_TEXT_VALUE', 'Description');
define ('LINKS_LIST_TITLE', 'Link list');
define ('LINKS_LAST_LIST_TITLE', 'Last links');
define ('LINKS_DUPLICATE_KEY','Link already exists!');
define ('LINKS_ADDED','Link added!');
define ('LINKS_ADD_ERROR','Link add error!');
define ('LINKS_UPDATE_UPDATE','Link update');
define ('LINKS_UPDATE_TITLE','Update links');
define ('LINKS_UPDATED','Link updated!');
define ('LINKS_UPDATE_ERROR','Link update error!');
define ('LINKS_GET_ERROR','Link get error!');
define ('LINKS_DELETE_DELETE','Delete');
define ('LINKS_DELETED','Link deleted!');
define ('LINKS_DELETE_ERROR','Link not deleted!');
define ('LINKS_DELETE_QUESTION','Are you sure you want to delete this link?');
define ('LINKS_TMP_IMAGE_LOADED','Link temporary image loaded!');
define ('LINKS_IMAGE_LOADED','Link image loaded!');
define ('LINKS_IMAGE_DELETED','Link image deleted!');
define ('LINKS_IMAGE',' ');
define ('LINKS_GET_LIST_ERROR','Link get list error!');
define ('LINKS_IMAGE_UPDATE_ERROR','Link image update error!');
define ('LINKS_IMAGE_DELETE_ERROR','Link image delete error!');
define ('LINKS_ACTIVATE_ERROR','Link activate error!');

// Item

define ('ITEM_ADD_TITLE','Add item');
define ('ITEM_ADDED','Item added!');
define ('ITEM_ADD_ERROR','Item not added!');
define ('ITEM_LIST_TITLE','Item list');
define ('ITEM_LAST_LIST_TITLE','Last updated items');
define ('ITEM_UPDATE_TITLE','Update item');
define ('ITEM_UPDATED','Item updated!');
define ('ITEM_UPDATE_ERROR','Item not updated!');
define ('ITEM_GET_ERROR','Item not loaded!');
define ('ITEM_IMAGE',' ');
define ('ITEM_NAME','Name');
define ('ITEM_TYPE','Type');
define ('ITEM_TYPE_2','Category');
define ('ITEM_ACTIVE','Visible');
define ('ITEM_TEXT_LANG', 'Language');
define ('ITEM_TEXT_VALUE', 'Description');
define ('ITEM_IMAGE_LOADED','Image loaded!');
define ('ITEM_TMP_IMAGE_LOADED','Image loaded!');
define ('ITEM_TMP_IMAGE_NOT_LOADED','Image not loaded!');
define ('ITEM_TMP_IMAGE_DELETED','Image deleted!');
define ('ITEM_TMP_IMAGE_DELETE_ERROR','Image not deleted!');
define ('ITEM_IMAGE_DELETED','Image deleted!');
define ('ITEM_IMAGE_DELETE_ERROR','Image not deleted!');
define ('ITEM_UPDATE_UPDATE','Update');
define ('ITEM_ADD_ADD','Add');
define ('ITEM_ACTIVATE_ERROR','Item activation/desactivation error!');
define ('ITEM_DUPLICATE_KEY','Item already exists!');
define ('ITEM_DELETE_DELETE','Delete');
define ('ITEM_DELETED','Item deleted!');
define ('ITEM_DELETE_ERROR','Item not deleted!');
define ('ITEM_DELETE_QUESTION','Are you sure you want to delete this item?');
define ('ITEM_PHOTO_GALLERY','Photo gallery');
define ('ITEM_MAIN_PHOTO','Main photo');
define ('ITEM_OTHER_PHOTO','Other photos');
define ('ITEM_HIT','Hits');
define ('TO_SELL','To sell');
define ('ITEM_IMAGE_COPYRIGHT','Copyright information');
define ('ITEM_IMAGE_COPYRIGHT_TITLE','Description');
define ('ITEM_IMAGE_COPYRIGHT_LINK','Link');
define ('ITEM_IMAGE_COPYRIGHT_DATE','Date');


define ('ADMIN_IMAGE_LOADED','Image loaded!');
define ('ADMIN_IMAGE_UPDATED','Image updated!');
define ('ADMIN_IMAGE_DELETED','Image deleted!');


// Configuration

define ('MENU_ADMIN_CONFIGURATION', 'Configuration');

define ('ADMIN_CONFIGURATION_GET_LIST_ERROR', 'Configuration list error!');
define ('ADMIN_CONFIGURATION_DATE', 'Date');
define ('ADMIN_CONFIGURATION_USER', 'User');
define ('ADMIN_CONFIGURATION_ACTIVE', 'Active');
define ('ADMIN_CONFIGURATION_NAME', 'Name');
define ('ADMIN_CONFIGURATION_DELETE_DELETE', 'Delete');
define ('ADMIN_CONFIGURATION_DELETE_QUESTION', 'Are you sure you want to delete this configuration?');
define ('ADMIN_CONFIGURATION_DELETED', 'Configuration deleted!');
define ('ADMIN_CONFIGURATION_DELETE_ERROR', 'Error while deleting configuration!');
define ('ADMIN_CONFIGURATION_BANNER_SIZE', 'Banner size');
define ('ADMIN_CONFIGURATION_HOME_BLOG_NUMBER', 'Home blog number');
define ('ADMIN_CONFIGURATION_HOME_ITEMS_NUMBER', 'Home items number');
define ('ADMIN_CONFIGURATION_HOME_SHOW_BLOG', 'Home blog showing');
define ('ADMIN_CONFIGURATION_HOME_SHOW_ITEMS', 'Home items showing');
define ('ADMIN_CONFIGURATION_SHOW_LANG', 'Show lang choose');
define ('ADMIN_CONFIGURATION_SHOW_MANAGER_ADDRESS', 'Show manager address');
define ('ADMIN_CONFIGURATION_DEFAULT_THEME', 'Default theme');
define ('ADMIN_CONFIGURATION_SITE_NAME', 'Site URL');
define ('ADMIN_CONFIGURATION_HTTP', 'HTTP URL');
define ('ADMIN_CONFIGURATION_ADMINISTRATOR_EMAIL', 'Administrator email');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_1', 'Address line 1');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_2', 'Address line 2');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_3', 'Address line 3');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_POSTAL_CODE', 'Postal code');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_CITY', 'City');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_REGION', 'Region');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_COUNTRY', 'Country');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_TELEPHONE', 'Phone');
define ('ADMIN_CONFIGURATION_MANAGER_EMAIL', 'Manager email');
define ('ADMIN_CONFIGURATION_COPYRIGHT', 'Copyright');
define ('ADMIN_CONFIGURATION_COPYRIGHT_LINK', 'Copyright link');
define ('ADMIN_CONFIGURATION_LOG_DATABASE', 'Database log saving');
define ('ADMIN_CONFIGURATION_LOG_SHOW', 'Log showing');
define ('ADMIN_CONFIGURATION_LOG_FILE', 'File log saving');
define ('ADMIN_CONFIGURATION_ERROR_DATABASE', 'Database error saving');
define ('ADMIN_CONFIGURATION_ERROR_SHOW', 'Error showing');
define ('ADMIN_CONFIGURATION_ERROR_FILE', 'File error saving');
define ('ADMIN_CONFIGURATION_IMAGE_FULL_WIDTH', 'Width of big images');
define ('ADMIN_CONFIGURATION_IMAGE_FULL_HEIGHT', 'Height of big images');
define ('ADMIN_CONFIGURATION_IMAGE_MEDIUM_WIDTH', 'Width of medium images');
define ('ADMIN_CONFIGURATION_IMAGE_MEDIUM_HEIGHT', 'Height of medium images');
define ('ADMIN_CONFIGURATION_IMAGE_LITTLE_WIDTH', 'Width of little images'); 
define ('ADMIN_CONFIGURATION_IMAGE_LITTLE_HEIGHT', 'Height of little images');
define ('ADMIN_CONFIGURATION_IMAGE_MIN_WIDTH', 'Width of min images');
define ('ADMIN_CONFIGURATION_IMAGE_MIN_HEIGHT', 'Height of min images');
define ('ADMIN_CONFIGURATION_IMAGE_TMP_PREFIX', 'Temporary image prefix');
define ('ADMIN_CONFIGURATION_DATABASE_MAX_ROWS', 'Lists max results');
define ('ADMIN_CONFIGURATION_IP_KEY', 'IP key');
define ('ADMIN_CONFIGURATION_SIMPLE_REGISTER', 'Simple register mode');
define ('ADMIN_CONFIGURATION_STORE_ENABLED', 'Store mode');
define ('ADMIN_CONFIGURATION_STORE_ORDER_DELIVERY_TYPE_DEFAULT', 'Default delivery mode'); 
define ('ADMIN_CONFIGURATION_STORE_ORDER_STATUS_INITIAL', 'Order initial status'); 
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0', 'Postal charges level 0');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0_AMOUNT', 'Postal charges level 0 : price');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0_WEIGHT', 'Postal charges level 0 : weight');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1', 'Postal charges level 2');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1_AMOUNT', 'Postal charges level 1 : price');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1_WEIGHT', 'Postal charges level 1 : weight');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2', 'Postal charges level 2');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2_AMOUNT', 'Postal charges level 2 : price');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2_WEIGHT', 'Postal charges level 2 : weight');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_3', 'Postal charges level 3');
define ('ADMIN_CONFIGURATION_BLOG_ENABLED', 'Blog mode');
define ('ADMIN_CONFIGURATION_SITEMAP_FILE', 'SITEMAP file');
define ('ADMIN_ADMIN_CONFIGURATION_LIST_TITLE', 'Configuration list');
define ('ADMIN_ADMIN_CONFIGURATION_ADD_TITLE', 'Add a configuration'); 
define ('ADMIN_ADMIN_CONFIGURATION_UPDATE_TITLE', 'Update configuration'); 
define ('ADMIN_ADMIN_CONFIGURATION_ADD_ADD', 'Add');
define ('ADMIN_ADMIN_CONFIGURATION_UPDATE_UPDATE', 'Update');
define ('ADMIN_ADMIN_CONFIGURATION_DELETE_DELETE', 'Delete');
define ('ADMIN_ADMIN_CONFIGURATION_UPDATED', 'Configuration updated!');
define ('ADMIN_ADMIN_CONFIGURATION_ADDED', 'Configuration added!');
define ('ADMIN_CONFIGURATION_ITEM_COMMENT_ENABLED', 'Item comments');
define ('ADMIN_CONFIGURATION_BLOG_COMMENT_ENABLED', 'Blog comments');

define ('EXPORT_TO_EXCEL', 'Export to Excel');
define ('EXPORT_TO_PDF', 'Export to PDF');

define ('SEARCH', 'Search');
define ('SEARCH_ITEMS', 'Items');
define ('SEARCH_BLOG', 'Topics');

define ('TAG', 'Tag');
define ('TAGS', 'Tags');
define ('TAG_ITEMS', 'Items');
define ('TAG_BLOG', 'Topics');
define ('TAG_LIST', 'Tag list');
define ('ADMIN_ITEM_TAG_ADDED','Tag added!');
define ('ADMIN_ITEM_TAG_DELETED','Tag deleted!');
define ('ADMIN_BLOG_TAG_ADDED','Tag added!');
define ('ADMIN_BLOG_TAG_DELETED','Tag deleted!');

// Specific part
$root = dirname(__FILE__)."/../";
include_once($root.'./config/locale_en_specific.php');
?>