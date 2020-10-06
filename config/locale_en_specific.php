<?php
/* V1.3
 *
 * V1.1 : 20130222 : Welcome note copyright 
 * V1.2 : 20130524 : $_SESSION[SITE_ID]['admin_configuration_http']S for facebook link
 * V1.3 : 20130614 : Description and keywords update
 * V1.4 : 20130614 : Description and keywords update
 * 
 */
// Specific part //

define ('FACEBOOK_LINK', '');
define ('FACEBOOK_LANG', '');
define ('SITE_TITLE', 'L\'Armoire Normande');
define ('META_DESCRIPTION_EN', 'Selling baby clothes, baby equipment and riding equipment');
define ('META_KEYWORDS_EN', 'Sale, clothing, baby equipment, baby, riding together baby, sleeping bag, body, stroller toy, awakening');
define ('META_DESCRIPTION_FR', 'Vente de vêtements bébé, matériel de puériculture et matériel d\'équitation');
define ('META_KEYWORDS_FR', 'Vente, vêtements, bébé, matériel, puériculture, équitation, ensemble bébé, gigoteuse, body bébé, poussette, jouet, éveil');
define ('META_DESCRIPTION_ES', 'La venta de ropa de bebé, artículos para bebés y material de equitación');
define ('META_KEYWORDS_ES', 'Venta, ropa, equipamiento para bebés, bebé, caballo juntos bebé, saco de dormir, el cuerpo, juguete cochecito, despertar');
define ('META_DESCRIPTION_DE', 'Verkauf von Babykleidung, Babyzubehör und Reit');
define ('META_KEYWORDS_DE', 'Kaufen, Kleidung, Babyausstattung, baby, Reiten zusammen Baby, Schlafsack, Körper, Kinderwagen Spielzeug, Erwachen');
define ('CONTACT_ADDRESS', 'A question? You can ask by email at this <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_manager_email'].'?subject='.$_SESSION[SITE_ID]['admin_configuration_site_name'].'"><B>address</B></A>.');
define ('WELCOME_NOTE', '<SPAN>Welcome to my website selling baby clothes</SPAN>');
define ('LINKS', 'Links');


define ('ADMIN_SPECIFIC_TABLE_GET_LIST_ERROR', 'List loading error');

// Item

define ('ADMIN_ITEM_SPECIFIC_ADD_TITLE', 'Add a data');
define ('ADMIN_ITEM_SPECIFIC_UPDATE_TITLE', 'Udpate');
define ('ADMIN_ITEM_SPECIFIC_LIST_TITLE', 'List');
define ('ADMIN_ITEM_SPECIFIC_ADD_ADD', 'Add');
define ('ADMIN_ITEM_SPECIFIC_UPDATE_UPDATE', 'Udpate');
define ('ADMIN_ITEM_SPECIFIC_DELETE_DELETE', 'Delete');
define ('ADMIN_ITEM_SPECIFIC_DELETE_QUESTION', 'Are you sure you want to delete this data?');
define ('ADMIN_ITEM_SPECIFIC_ADDED', 'Data added!');
define ('ADMIN_ITEM_SPECIFIC_UPDATED', 'Data updated!');
define ('ADMIN_ITEM_SPECIFIC_DELETED', 'Data deleted!');


define ('ITEM_SPECIFIC_PRICE','Price');
define ('ITEM_SPECIFIC_INVENTORY','Inventory');
define ('ITEM_SPECIFIC_WEIGHT','Weigth');


// Specific

define ('MENU_BOY', 'Boy');
define ('MENU_GIRL', 'Girl');
define ('MENU_CHILDCARE', 'Childcare');
define ('MENU_HORSE_RIDING', 'Horse riding');

// Brand (specific table)

define ('ITEM_SPECIFIC_BRAND','Brand');
define ('ITEM_SPECIFIC_BRAND_NAME','Brand name');
define ('ITEM_SPECIFIC_BRAND_LOGO_FILENAME','Logo');
define ('ITEM_SPECIFIC_BRAND_WEB_SITE_URL','Website URL');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADD_ADD','Add');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETE_QUESTION','Are you sure you want to delete this brand?');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATE_TITLE','Update brand');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATE_UPDATE','Update');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETE_DELETE','Delete');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATED','Brand updated!');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADDED','Brand added!');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETED','Brand deleted!');
define ('MENU_ADMIN_ITEM_SPECIFIC_BRAND', 'Brand');
define ('ADMIN_ITEM_SPECIFIC_BRAND_LIST_TITLE', 'Brand list');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADD_TITLE', 'Add a brand');

define ('BOY', 'Boy');
define ('GIRL', 'Girl');
define ('CHILDCARE', 'Childcare');
define ('HORSE_RIDING', 'Horse riding');


define ('BIRTH', 'Birth');
define ('1_MONTH', '1 month');
define ('3_MONTHS', '3 months');
define ('6_MONTHS', '6 months');
define ('9_MONTHS', '9 months');
define ('12_MONTHS', '12 months');
define ('18_MONTHS', '18 months');

define ('TOY', 'Toy');
define ('BABY_EQUIPMENT', 'Baby equipment');

// End of specific

// End of specific part //
?>