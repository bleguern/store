<?php
/* V1.3
 *
 * V1.1 : 20130222 : Welcome note copyright 
 * V1.2 : 20130524 : $_SESSION[SITE_ID]['admin_configuration_http']S for facebook link
 * V1.3 : 20130614 : Description and keywords update
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


define ('ADMIN_SPECIFIC_TABLE_GET_LIST_ERROR', 'Error Lista de carga');

// Item

define ('ADMIN_ITEM_SPECIFIC_ADD_TITLE', 'Añadir un datos');
define ('ADMIN_ITEM_SPECIFIC_UPDATE_TITLE', 'udpate');
define ('ADMIN_ITEM_SPECIFIC_LIST_TITLE', 'Lista');
define ('ADMIN_ITEM_SPECIFIC_ADD_ADD', 'Añadir');
define ('ADMIN_ITEM_SPECIFIC_UPDATE_UPDATE', 'udpate');
define ('ADMIN_ITEM_SPECIFIC_DELETE_DELETE', 'Eliminar');
define ('ADMIN_ITEM_SPECIFIC_DELETE_QUESTION', '¿Estás seguro que quieres borrar estos datos?');
define ('ADMIN_ITEM_SPECIFIC_ADDED', 'Datos añadido!');
define ('ADMIN_ITEM_SPECIFIC_UPDATED', 'Datos actualizados!');
define ('ADMIN_ITEM_SPECIFIC_DELETED!', 'Eliminarán los datos');

define ('ITEM_SPECIFIC_PRICE', 'Precio');
define ('ITEM_SPECIFIC_INVENTORY', 'Inventario');
define ('ITEM_SPECIFIC_WEIGHT', 'Peso');


// Specific

define ('MENU_BOY', 'Niño');
define ('MENU_GIRL', 'Chica');
define ('MENU_CHILDCARE', 'Cuidado de los niños');
define ('MENU_HORSE_RIDING', 'Montar a caballo');


// Brand (specific table)

define ('ITEM_SPECIFIC_BRAND', 'Marca');
define ('ITEM_SPECIFIC_BRAND_NAME', 'Marca');
define ('ITEM_SPECIFIC_BRAND_LOGO_FILENAME', 'Logo');
define ('ITEM_SPECIFIC_BRAND_WEB_SITE_URL', 'URL del sitio web');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADD_ADD', 'Añadir');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETE_QUESTION', '¿Está seguro que quiere eliminar esta marca?');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATE_TITLE', 'Actualización de la marca');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATE_UPDATE', 'la actualización');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETE_DELETE', 'Eliminar');
define ('ADMIN_ITEM_SPECIFIC_BRAND_UPDATED', 'Marca actualizado!');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADDED', 'Brand agregó!');
define ('ADMIN_ITEM_SPECIFIC_BRAND_DELETED', 'Marca borrado!');
define ('MENU_ADMIN_ITEM_SPECIFIC_BRAND', 'Marca');
define ('ADMIN_ITEM_SPECIFIC_BRAND_LIST_TITLE', 'lista Marca');
define ('ADMIN_ITEM_SPECIFIC_BRAND_ADD_TITLE', 'Añadir una marca');

define ('BOY', 'Niño');
define ('GIRL', 'Chica');
define ('CHILDCARE', 'Cuidado de los niños');
define ('HORSE_RIDING', 'Montar a caballo');


define ('BIRTH', 'Nacimiento');
define ('1_MONTH', '1 mes');
define ('3_MONTHS', '3 meses');
define ('6_MONTHS', '6 meses');
define ('9_MONTHS', '9 meses');
define ('12_MONTHS', '12 meses');
define ('18_MONTHS', '18 meses');

define ('TOY', 'Juguete');
define ('BABY_EQUIPMENT', 'Equipamiento para bebés');

// End of specific

// End of specific part //
?>