<?php
/* V1.2
 * 
 * V1.1 : 20130524 : $_SESSION[SITE_ID]['admin_configuration_http']S for facebook link
 * V1.2 : 20130614 : Description and keywords update
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


define ('ADMIN_SPECIFIC_TABLE_GET_LIST_ERROR', 'Liste Ladefehler');

// Item

define ('ADMIN_ITEM_SPECIFIC_ADD_TITLE', 'Fügen Sie eine Daten');
define ('ADMIN_ITEM_SPECIFIC_UPDATE_TITLE', 'Aktualisierung');
define ('ADMIN_ITEM_SPECIFIC_LIST_TITLE', 'Liste');
define ('ADMIN_ITEM_SPECIFIC_ADD_ADD', 'Hinzufügen');
define ('ADMIN_ITEM_SPECIFIC_UPDATE_UPDATE', 'Aktualisierung');
define ('ADMIN_ITEM_SPECIFIC_DELETE_DELETE', 'Löschen');
define ('ADMIN_ITEM_SPECIFIC_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diese Daten gelöscht werden?');
define ('ADMIN_ITEM_SPECIFIC_ADDED', 'Daten hinzugefügt!');
define ('ADMIN_ITEM_SPECIFIC_UPDATED', 'Daten aktualisiert!');
define ('ADMIN_ITEM_SPECIFIC_DELETED', 'Daten gelöscht!');


define ('ITEM_SPECIFIC_PRICE', 'Preis');
define ('ITEM_SPECIFIC_INVENTORY', 'Inventar');
define ('ITEM_SPECIFIC_WEIGHT', 'Gewicht');


// Specific

define ('MENU_BOY', 'Junge');
define ('MENU_GIRL', 'Mädchen');
define ('MENU_CHILDCARE', 'Kinderbetreuung');
define ('MENU_HORSE_RIDING', 'Reiten');


// Brand (specific table)

define ('ITEM_SPECIFIC_BRAND', 'Marke');
define ('ITEM_SPECIFIC_BRAND_NAME', 'Markenname');
define ('ITEM_SPECIFIC_BRAND_LOGO_FILENAME', 'Logo');
define ('ITEM_SPECIFIC_BRAND_WEB_SITE_URL', 'Website-URL');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADD_ADD', 'Hinzufügen');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diese Marke gelöscht werden?');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATE_TITLE', 'Update Marke');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATE_UPDATE', 'Update');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETE_DELETE', 'Löschen');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATED', 'Marke aktualisiert!');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADDED', 'Marke hinzugefügt!');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETED', 'Marke gelöscht!');
define ('MENU_ADMIN_ITEM_SPECIFIC_BRAND', 'Marke');
define ('ADMIN_ITEM_SPECIFIC_BRAND_LIST_TITLE', 'Markenliste');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADD_TITLE', 'Fügen Sie eine Marke');

define ('BOY', 'Junge');
define ('GIRL', 'Mädchen');
define ('CHILDCARE', 'Kinderbetreuung');
define ('HORSE_RIDING', 'Reiten');


define ('BIRTH', 'Geburt');
define ('1_MONTH', '1 Monat');
define ('3_MONTHS', '3 Monaten');
define ('6_MONTHS', '6 Monaten');
define ('9_MONTHS', '9 Monaten');
define ('12_MONTHS', '12 Monaten');
define ('18_MONTHS', '18 Monaten');

define ('TOY', 'Spielzeug');
define ('BABY_EQUIPMENT', 'Babyausstattung');

// End of specific

// End of specific part //
?>