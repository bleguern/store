<?php
/* V1.3
 * 
 * V1.1 : 20130524 : Links
 * V1.2 : 20131004 : Menu style added
 * V1.3 : 20131015 : Item type 2 added
 * 
 */

// Lang

define ('LANG','DE');

// Legals

define ('LEGALS', 'Design & Entwicklung');

// Date

define ('DATABASE_DATE_FORMAT','%m/%d/%Y');
define ('DATABASE_DATETIME_FORMAT','%m/%d/%Y %H:%i:%s');
define ('PHP_DATE_FORMAT','m/d/Y');
define ('PHP_DATETIME_FORMAT','m/d/Y H:i:s');
define ('HTML_DATE_FORMAT','mm/dd/YYYY');

define('ON', 'Auf ');
define('AT', ' bei ');
define('BY', ' von ');
define('FROM', ' von ');
define('YEAR', 'jahre alt');
define('YEARS', 'jahre alt');
define('THIS_YEAR', 'Geboren in diesem Jahr!');
define('READ_NEXT', '...lesen Sie weiter');

define('JANUARY', 'Januar');
define('FEBRUARY', 'Februar');
define('MARCH', 'März');
define('APRIL', 'April');
define('MAY', 'Mai');
define('JUNE', 'Juni');
define('JULY', 'Juli');
define('AUGUST', 'August');
define('SEPTEMBER', 'September');
define('OCTOBER', 'Oktober');
define('NOVEMBER', 'November');
define('DECEMBER', 'Dezember');
define('JANUARY_LITTLE', 'Jan');
define('FEBRUARY_LITTLE', 'Feb');
define('MARCH_LITTLE', 'Mar');
define('APRIL_LITTLE', 'Apr');
define('MAY_LITTLE', 'Mai');
define('JUNE_LITTLE', 'Jun');
define('JULY_LITTLE', 'Jul');
define('AUGUST_LITTLE', 'Aug');
define('SEPTEMBER_LITTLE', 'Sep');
define('OCTOBER_LITTLE', 'Okt');
define('NOVEMBER_LITTLE', 'Nov');
define('DECEMBER_LITTLE', 'Dez');

define('MONDAY', 'Montag');
define('TUESDAY', 'Dienstag');
define('WEDNESDAY', 'Mittwoch');
define('THURSDAY', 'Donnerstag');
define('FRIDAY', 'Freitag');
define('SATURDAY', 'Samstag');
define('SUNDAY', 'Sonntag');

define('MONDAY_LITTLE', 'Mon');
define('TUESDAY_LITTLE', 'Die');
define('WEDNESDAY_LITTLE', 'Mit');
define('THURSDAY_LITTLE', 'Don');
define('FRIDAY_LITTLE', 'Fre');
define('SATURDAY_LITTLE', 'Sam');
define('SUNDAY_LITTLE', 'Son');

define('MONDAY_LETTER', 'M');
define('TUESDAY_LETTER', 'D');
define('WEDNESDAY_LETTER', 'M');
define('THURSDAY_LETTER', 'D');
define('FRIDAY_LETTER', 'F');
define('SATURDAY_LETTER', 'S');
define('SUNDAY_LETTER', 'S');

define('TODAY', 'Heute');

// General

define ('ERROR', 'Fehler');
define ('LOADING', 'Laden...');

define ('YES', 'Ja');
define ('NO', 'Nein');

define ('BACK', 'Zurück');
define ('NEW', 'Neu');
define ('UPDATE', 'Aktualisierung');
define ('DELETE', 'Löschen');
define ('ADD', 'Hinzufügen');

define ('UPLOAD_MAIN_IMAGE', 'Hauptbildgalerie');
define ('UPLOAD_IMAGE', 'Bild hochladen');

define ('MANDATORY_FIELDS','* : Pflichtfeld');

define ('NO_RESULT','Kein Ergebnis');

define ('TABLE_TOTAL_NUMBER','Total');
define ('TABLE_PAGE_NUMBER','seite');

define ('LAST_UPDATE_DATE','Letzte Aktualisierung');
define ('LAST_UPDATE_USER','Benutzer');

// Error logging

define ('ERROR_FATAL','Fatal error: wenden Sie sich bitte <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'" TARGET="_blank">Verwalter</A>!');
define ('ERROR_INITIALISE','Initialisieren Fehler: Bitte wenden <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'" TARGET="_blank">Verwalter</A>!');

define ('MISSING_ARGUMENT_ERROR', 'Fehlende Feld(s)!');
define ('MISSING_METHOD_ERROR', 'Fehlendes Verfahren!');
define ('MISSING_FIELDS_ERROR', 'Fehlende Feld(s)!');

define ('ERROR_LOGIN','Anmelden Fehler!');
define ('ERROR_LOGOUT','Logout Fehler!');

define ('ERROR_LOAD_URL','URL Ladefehler!');

define ('ERROR_RIGHT','Rechtsfehler!');

define ('ERROR_ADMIN_SAVE_LOG','Sparen loggen Fehler!');

define ('ERROR_USER_SAVE_CONNECTION', 'User speichern Verbindungsfehler!');
define ('ERROR_USER_GET_PASSWORD', 'Benutzer-Passwort-Fehler!');
define ('ERROR_USER_GET_INFORMATION', 'Benutzerinformation Fehler!');
define ('ERROR_USER_GET_RIGHT', 'Benutzerrecht Fehler!');
define ('ERROR_ITEM_GET_ACTIVE_LIST', 'Aktiv Liste Fehler!');
define ('ERROR_GET_HOME_ACTIVE_ITEM_LIST', 'Get Hause aktiven Suchergebnis Fehler!');

define ('ERROR_SAVE_CONNECTION_ERROR', 'Speichern Verbindungsfehler!');

define ('GET_LIST_ERROR', 'Liste Fehler!');

define ('MESSAGE_BAD_LOGIN', 'Benutzername oder Kennwort ist falsch!');
define ('MESSAGE_USER_DESACTIVATED', 'Benutzer wurde desactivated: Bitte kontaktieren <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'" TARGET="_blank">Verwalter</A>!');

define ('MESSAGE_AUTHORISATION','Sie sind nicht berechtigt, diese Seite zu betreten!');

// Site definition

define ('MENU', 'Menü');
define ('MENU_HOME', 'Zuhause');
define ('MENU_BLOG', 'Blog');
define ('MENU_CONTACT', 'Kontakt');
define ('MENU_CONNECTION', 'Verbindung');
define ('MENU_DISCONNECTION', 'Abschaltung');
define ('MENU_ADMIN', 'Admin');
define ('MENU_ADMIN_ACCESS', 'Access');
define ('MENU_ADMIN_ERROR', 'Fehler');
define ('MENU_ADMIN_ITEM', 'Artikel');
define ('MENU_ADMIN_LOG', 'Logs');
define ('MENU_ADMIN_BLOG', 'Blog');
define ('MENU_ADMIN_LINKS', 'Links');
define ('MENU_ADMIN_ROLE', 'Rollen');
define ('MENU_ADMIN_STATS', 'Statistik');
define ('MENU_ADMIN_SITE_THEME', 'Theme');
define ('MENU_ADMIN_VERSION', 'Version');
define ('MENU_ADMIN_USER', 'Benutzer');
define ('MENU_ADMIN_MENU', 'Menü');
define ('MENU_ADMIN_ITEM_TYPE', 'Datentyp');
define ('MENU_ADMIN_ITEM_TYPE_2', 'Datenkategorie');
define ('MENU_LINKS', 'Links');
define ('MENU_SEARCH', '');

// Store mode

define ('MENU_CONNECTION_ACCOUNT', 'Mein Konto');
define ('MENU_CONNECTION_BASKET', 'Mein Warenkorb');
define ('MENU_CONNECTION_ORDER', 'Meine Bestellungen');
define ('MENU_ADMIN_ORDER', 'Bestellungen');

define ('ADD_TO_BASKET', 'In den Warenkorb');
define ('NOT_AVAILABLE', 'Nicht verfügbar');
define ('BASKET_ADDED', 'Artikel in den <A HREF="../pages/basket.php" TARGET="_self">Warenkorb</A> gelegt!');
define ('BASKET_ADD_NO_INVENTORY', 'Artikel nicht hinzugefügt, nicht genug Inventar!');
define ('BASKET_DELETED', 'Artikel aus dem Warenkorb gelöscht');
define ('BASKET_GO_TO_ORDER_QUESTION', 'Sind Sie sicher, dass Sie gehen zu bestellen?');
define ('PLEASE_CONNECT_BEFORE_CREATE_ORDER', 'Bitte einloggen oder registrieren, um einen Befehl einzugeben!');
define ('PLEASE_CONNECT_BEFORE_LIST_ORDER', 'Bitte anmelden oder registrieren um Liste Ihrer Aufträge!');
define ('GO_TO_ORDER', 'die Ordnung gehen');
define ('EMPTY_BASKET', 'Warenkorb leeren');
define ('BASKET_EMPTIED', 'Korb geleert!');
define ('BASKET_IS_EMPTY', 'Ihr Warenkorb ist leer!');
define ('BASKET_TITLE', 'Mein Warenkorb');
define ('BASKET_DELETE_QUESTION', 'Sind Sie sicher, dass Sie in Ihren Warenkorb zu leeren?');
define ('GET_BASKET_ERROR', 'Basket Ladefehler!');

define ('QUANTITY', 'Menge');
define ('PRICE', 'Preis');
define ('UNIT_PRICE', 'Stückpreis');
define ('TOTAL_PRICE', 'Gesamtpreis');

define ('TABLE_TOTAL_AMOUNT', 'Artikel Zwischensumme');
define ('POSTAL_CHARGES_AMOUNT', 'Liefermenge');
define ('ORDER_DISCOUNT', 'Rabatt');
define ('TABLE_FULL_AMOUNT', 'Gesamtbetrag');

define ('ADMIN_ORDER_LIST_TITLE', 'Bestellliste');
define ('ADMIN_ORDER_STATUS_LIST_TITLE', 'Auftragsstatus-Liste');
define ('ADMIN_ORDER_STATUS_ADD_TITLE', 'hinzufügen, um Auftragsstatus');
define ('ADMIN_ORDER_STATUS_UPDATE_TITLE', 'Aktualisierung Auftragsstatus');
define ('ADMIN_ORDER_STATUS_ADD_ADD', 'Hinzufügen');
define ('ADMIN_ORDER_STATUS_UPDATE_UPDATE', 'Aktualisierung');
define ('ADMIN_ORDER_STATUS_DELETE_DELETE', 'Löschen');
define ('ADMIN_ORDER_STATUS_DUPLICATE_KEY', 'Auftragsstatus existiert bereits!');
define ('ADMIN_ORDER_STATUS_ADDED', 'Auftragsstatus hinzugefügt!');
define ('ADMIN_ORDER_STATUS_ADD_ERROR', 'Auftragsstatus nicht hinzugefügt!');
define ('ADMIN_ORDER_STATUS_UPDATE_ERROR', 'Fehler beim Auftragsstatus aktualisieren!');
define ('ADMIN_ORDER_STATUS_UPDATED', 'Auftragsstatus aktualisiert!');
define ('ADMIN_ORDER_STATUS_DELETED', 'Auftragsstatus gelöscht!');
define ('ADMIN_ORDER_STATUS_DELETE_QUESTION', 'Sind Sie sicher, dass diese Auftragsstatus gelöscht werden?');
define ('ADMIN_ORDER_STATUS_ID', 'ID');
define ('ADMIN_ORDER_STATUS_NAME', 'Status');
define ('ADMIN_ORDER_STATUS_ACTIVE', 'Aktiv');
define ('ADMIN_ORDER_STATUS_INVENTORY_RESERVE', 'Bestandsschutzgebiet');
define ('ADMIN_ORDER_STATUS_INVENTORY_CLEANUP', 'Bestandsbereinigung');
define ('ADMIN_ORDER_STATUS_LOCK', 'bestellen Lock');
define ('ADMIN_ORDER_STATUS_OTHER_POSSIBLE_STATUS', 'Andere mögliche Status');
define ('ORDER_TITLE', 'Verordnung');
define ('ERROR_ORDER_GET_HEADER', 'Auftragskopf Ladefehler!');
define ('CANCEL_ORDER', 'Bestellung stornieren');
define ('ORDER_CREATED', 'bestellen erstellt!');
define ('ORDER_CREATION_DATE', 'Erstellungsdatum');
define ('ORDER_STATUS', 'Auftragsstatus');
define ('ORDER_LAST_UPDATE', 'Letzte Aktualisierung');
define ('ORDER_LAST_UPDATE_BY', 'durch');
define ('ORDER_ITEM_LIST', 'Artikelliste');
define ('ORDER_ITEM_COUNT', 'Artikelnummer');
define ('ORDER_LIST_TITLE', 'Meine Bestellungen');
define ('ORDER_NUMBER', 'Bestellen n °');
define ('ORDER_CUSTOMER', 'Kunde');
define ('ORDER_USER', 'Benutzer');

define ('ORDER_UPDATE_UPDATE', 'Aktualisierung');
define ('ADMIN_ORDER_UPDATED', 'bestellen aktualisiert!');
define ('ADMIN_ORDER_LINE_DELETED', 'bestellen Linie gelöscht!');
define ('ORDER_ADD_COMMENT', 'Kommentar hinzufügen');
define ('ORDER_COMMENT', 'Kommentar');
define ('ORDER_COMMENT_ADDED', 'Kommentar hinzugefügt!');
define ('ADMIN_ORDER_COMMENT_ADDED', 'Kommentar hinzugefügt!');
define ('ORDER_COMMENT_NOT_YOUR_ORDER_ERROR', 'Impossible um einen Kommentar zu dieser Bestellung hinzufügen!');

define ('MAIL_ORDER_CREATED_1','Bestellen n°');
define ('MAIL_ORDER_CREATED_2',' geschaffen');
define ('MAIL_ORDER_ORDER_NUMBER','Auftragsnummer');
define ('MAIL_ORDER_INFORMATIONS','Informationen');
define ('MAIL_ORDER_SEE_ONLINE','Bestellen online verwalten');
define ('MAIL_ORDER_CREATED_MESSAGE', '<H2>Hallo,</H2><BR>
Ihre Bestellung wurde erfolgreich erstellt und wird im nächsten validiert. Eine e-Mail wird an jedem Orderänderung gesendet.<BR>
Wenn Sie eine andere, um zu sehen, berprüfen Sie bitte Ihre Bestell-Liste auf ');

define ('MAIL_ORDER_UPDATED_1','Bestellen n°');
define ('MAIL_ORDER_UPDATED_2',' aktualisiert');
define ('MAIL_ORDER_UPDATED_MESSAGE', '<H2>Hallo,</H2><BR>
Ihre Bestellung wurden aktualisiert. Eine e-Mail wird an jedem Orderänderung gesendet.<BR>
Wenn Sie eine andere, um zu sehen, berprüfen Sie bitte Ihre Bestell-Liste auf ');

define ('MAIL_ORDER_COMMENT_ADDED_1','Bestellen n°');
define ('MAIL_ORDER_COMMENT_ADDED_2',' : Kommentar hinzugefügt');
define ('MAIL_ORDER_COMMENT_ADDED_MESSAGE', '<H2>Hallo,</H2><BR>
Ein Kommentar wurde Ihrer Bestellung hinzugefügt. Eine e-Mail wird an jedem Orderänderung gesendet.<BR>
Wenn Sie eine andere, um zu sehen, berprüfen Sie bitte Ihre Auftragsliste auf ');


define ('ORDER_STATUS_CREATED','Erstellt');
define ('ORDER_STATUS_VALIDATED','Validierte');
define ('ORDER_STATUS_CANCELLED','Abgesagt');
define ('ORDER_STATUS_PENDING_PAYMENT','Bis zur Erfüllung');
define ('ORDER_STATUS_DELIVERING','Lieferung...');
define ('ORDER_STATUS_DELIVERED','Lieferung');
define ('ORDER_STATUS_CLOSED','Geschlossen');


define ('ORDER_DELIVERY_TYPE','Lieferart');

define ('ORDER_DELIVERY_TYPE_POST','Senden Sie per Post');
define ('ORDER_DELIVERY_TYPE_HAND_OVER','Hand über Lieferung');


define ('BASKET_INFORMATIONS_TITLE','Informationen');
define ('BASKET_INFORMATIONS_EMPTY_MESSAGE', 'Um einen oder mehrere Artikel jetzt zu kaufen, klicken Sie auf "In den backet" - Taste.<BR>Artikel BEZUGS und Preisänderungen vorbehalten.<BR>Eine Frage zum Produkt oder diese Website Bitte gehen Sie auf <A HREF="contact.php" target="_self"><B>Kontakt</B></A> Seite.');
define ('BASKET_INFORMATIONS_NOT_EMPTY_MESSAGE', 'Du kannst jetzt gehen, um zu bestellen, oder wählen Sie weitere Artikel auf dieser website. <BR> Artikel BEZUGS und Preisänderungen vorbehalten.<BR>Eine Frage zum Produkt oder zu dieser Website? Bitte gehen Sie auf <A HREF="contact.php" target="_self"><B>Kontakt</B></A> Seite.');


// Value 

define ('VALUE_TEXT_LANG_DISPLAY_LIST_ERROR','Text lang Liste Fehler!');

// Login

define ('LOGIN_LOGIN_TITLE', 'Auf Seite Verbinden');
define ('LOGIN_LOGOUT_TITLE', 'Trennen Website');
define ('LOGIN_LOGIN', 'Einloggen');
define ('LOGIN_PASSWORD', 'Passwort');
define ('LOGIN_CONNECT', 'Connect');
define ('LOGIN_CONNECTED', 'Benutzer verbunden!');
define ('LOGIN_CONNECTED_AS', 'Verbunden als');
define ('LOGIN_DISCONNECT', 'Trennen');
define ('LOGIN_DISCONNECTED', 'Benutzer getrennt!');
define ('LOGIN_INCORRECT', 'Login oder Passwort falsch!');
define ('LOGIN_INACTIVE', 'Benutzer nicht aktiviert! Bitte kontaktieren <A HREF="mailto:'.$_SESSION[SITE_ID]['admin_configuration_administrator_email'].'" TARGET="_blank">Verwalter</A>');
define ('LOGIN_CONNECT_ERROR', 'Anmelden Fehler!');
define ('LOGIN_DISCONNECT_ERROR', 'Abmelden Fehler!');
define ('LOGIN_CREATE_ACCOUNT', 'Ein Konto erstellen');
define ('LOGIN_FORGOT_PASSWORD', 'Passwort vergessen');
define ('LOGIN_REGISTER', 'Registrieren');
define ('LOGIN_RESET_PASSWORD', 'Passwort zurücksetzen');
define ('MAIL_ACCOUNT_CREATED', 'Konto erstellt : ');
define ('PASSWORD_RESETED', 'Passwort zurückgesetzt!');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_1', '<H2>Hallo,</H2><BR>
Ihr Konto wurde erfolgreich auf unserer Website erstellt.<BR><BR>
Ihre Anmeldeinformationen :<BR>
Benutzer : ');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_2', '<BR>Passwort : ');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_3', '<BR>
Bitte beachten Sie Großbuchstaben.<BR><BR>
Sie können nun die Anmeldung auf unserer Website unter folgender Adresse : ');
define ('MAIL_REGISTERED', 'Konto erstellt : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_1', '<H2>Hallo,</H2><BR>
Ihr Konto wurde erfolgreich auf unserer Website erstellt.<BR><BR>
Ihre Anmeldeinformationen :<BR>
Benutzername / E-Mail : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_2', '<BR>Passwort : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_3', '<BR>
Bitte beachten Sie Großbuchstaben.<BR><BR>
Sie können nun auf unserer Website anmelden unter dieser Adresse : ');
define ('MAIL_RESET_PASSWORD', 'Passwort zurücksetzen');
define ('MAIL_RESET_PASSWORD_MESSAGE_1', '<H2>Hallo,</H2><BR>
Ihr Passwort wurde erfolgreich auf unserer Website zurückgesetzt.<BR><BR>
Hier ist Ihr neues Passwort : ');
define ('MAIL_RESET_PASSWORD_MESSAGE_2', '<BR>
Bitte beachten Sie Großbuchstaben.<BR><BR>
Sie können nun auf unserer Website anmelden unter dieser Adresse : ');

// Account

define ('ACCOUNT_CREATED', 'Konto erstellt');
define ('ACCOUNT_REGISTERED', 'Konto erstellt');
define ('UPDATE_ACCOUNT_TITLE','Mein konto');


// Contact

define ('CONTACT_TITLE', 'Kontakt');
define ('CONTACT_EMAIL', 'Ihre E-Mail');
define ('CONTACT_NAME', 'Ihren Namen');
define ('CONTACT_MESSAGE', 'Ihre Nachricht');
define ('CONTACT_COPY', 'Senden Sie eine Kopie an meine Adresse');
define ('CONTACT_SEND', 'Nachricht senden');
define ('CONTACT_MESSAGE_SENT', 'Nachricht wurde gesendet!');
define ('CONTACT_MAIL_MESSAGE', 'Nachricht');

// Link

define ('LINK_TITLE', 'Links');

// Link

define ('ADMIN_TITLE', 'Verwaltung');

// Item type

define ('ITEM_TYPE_ADD_TITLE', 'Datentyp hinzufügen');
define ('ITEM_TYPE_ADD_ADD', 'Typ hinzufügen');
define ('ITEM_TYPE_NAME', 'Typ');
define ('ITEM_TYPE_LIST_TITLE', 'Datentyp-Liste');
define ('ITEM_TYPE_DUPLICATE_KEY', 'Datentypen gibt es bereits!');
define ('ITEM_TYPE_ADDED', 'Datentypen hinzugefügt!');
define ('ITEM_TYPE_ADD_ERROR', 'Datentypen hinzufügen Fehler!');
define ('ITEM_TYPE_UPDATE_UPDATE', 'Datentyp-Update');
define ('ITEM_TYPE_DELETE_DELETE', 'Datentypen löschen');
define ('ITEM_TYPE_UPDATE_TITLE', 'Update-Datentyp');
define ('ITEM_TYPE_UPDATED', 'Datentypen aktualisiert!');
define ('ITEM_TYPE_UPDATE_ERROR', 'Datentyp Aktualisierung Fehler!');
define ('ITEM_TYPE_GET_ERROR', 'Datentypen erhalten Fehler!');
define ('ITEM_TYPE_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diesen Datentyp gelöscht werden?');
define ('ITEM_TYPE_DELETED', 'Datentypen gelöscht!');
define ('ITEM_TYPE_DELETE_ERROR', 'Datentypen löschen Fehler!');
define ('ITEM_TYPE_DELETE_CONSTRAINT', 'Datentyp konnte nicht gelöscht werden: Einschränkung');

// Item type 2

define ('ITEM_TYPE_2_ADD_TITLE', 'Datentyp hinzufügen 2');
define ('ITEM_TYPE_2_ADD_ADD', 'Hinzufügen Typ 2');
define ('ITEM_TYPE_2_NAME', 'Typenbezeichnung 2');
define ('ITEM_TYPE_2_LIST_TITLE', 'Datentyp 2 Liste');
define ('ITEM_TYPE_2_DUPLICATE_KEY', 'Datentyp 2 existiert bereits!');
define ('ITEM_TYPE_2_ADDED', 'Datentyp 2 hinzugefügt!');
define ('ITEM_TYPE_2_ADD_ERROR', 'Datentyp 2 Add Fehler!');
define ('ITEM_TYPE_2_UPDATE_UPDATE', 'Datentyp 2-Update');
define ('ITEM_TYPE_2_DELETE_DELETE', 'Datentyp 2 delete');
define ('ITEM_TYPE_2_UPDATE_TITLE', 'Update-Datentyp 2');
define ('ITEM_TYPE_2_UPDATED', 'Datentyp 2 aktualisiert!');
define ('ITEM_TYPE_2_UPDATE_ERROR', 'Datentyp 2 Update-Fehler!');
define ('ITEM_TYPE_2_GET_ERROR', 'Datentyp get Fehler!');
define ('ITEM_TYPE_2_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diese Daten Typ 2 gelöscht werden?');
define ('ITEM_TYPE_2_DELETED', 'Datentyp 2 gelöscht!');
define ('ITEM_TYPE_2_DELETE_ERROR', 'Datentyp 2 Lösch Fehler!');
define ('ITEM_TYPE_2_DELETE_CONSTRAINT', 'Datentyp 2 nicht gelöscht werden konnte: Zwang!');

// Access

define ('ADMIN_ACCESS_ADD_TITLE', 'Zugangs hinzufügen');
define ('ADMIN_ACCESS_ADD_ADD', 'Zugangs hinzufügen');
define ('ADMIN_ACCESS_URL', 'URL');
define ('ADMIN_ACCESS_DESCRIPTION', 'Beschreibung');
define ('ADMIN_ACCESS_LIST_TITLE', 'Zugangsliste');
define ('ADMIN_ACCESS_DUPLICATE_KEY', 'Zugang existiert bereits!');
define ('ADMIN_ACCESS_ADDED', 'Zugang hinzugefügt');
define ('ADMIN_ACCESS_ADD_ERROR', 'Zugang hinzufügen Fehler!');
define ('ADMIN_ACCESS_UPDATE_UPDATE', 'Zugang Update');
define ('ADMIN_ACCESS_DELETE_DELETE', 'Zugang zu löschen');
define ('ADMIN_ACCESS_UPDATE_TITLE', 'Zugang zu diesem Titel');
define ('ADMIN_ACCESS_UPDATED', 'Zugang aktualisiert!');
define ('ADMIN_ACCESS_UPDATE_ERROR', 'Zugang Update-Fehler!');
define ('ADMIN_ACCESS_GET_ERROR', 'Zugang zu erhalten Fehler!');
define ('ADMIN_ACCESS_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diesen Zugriff gelöscht werden?');
define ('ADMIN_ACCESS_DELETED', 'Zugang gelöscht!');
define ('ADMIN_ACCESS_DELETE_ERROR', 'Zugang zu löschen Fehler!');

// Role

define ('ADMIN_ROLE_ADD_TITLE', 'Rolle hinzufügen');
define ('ADMIN_ROLE_ADD_ADD', 'Rolle hinzufügen');
define ('ADMIN_ROLE_NAME', 'URL');
define ('ADMIN_ROLE_LIST_TITLE', 'Rollenliste');
define ('ADMIN_ROLE_DUPLICATE_KEY', 'Role existiert bereits!');
define ('ADMIN_ROLE_ADDED', 'Rolle hinzugefügt!');
define ('ADMIN_ROLE_ADD_ERROR', 'Rolle hinzufügen Fehler!');
define ('ADMIN_ROLE_ACCESS_ADDED', 'Rolle Zugriff hinzugefügt!');
define ('ADMIN_ROLE_ACCESS_ADD_ERROR', 'Rollen Zugang hinzufügen Fehler!');
define ('ADMIN_ROLE_ACCESS_DELETED', 'Rollen Zugang gelöscht!');
define ('ADMIN_ROLE_ACCESS_DELETE_ERROR', 'Rollen Zugang löschen Fehler!');
define ('ADMIN_ROLE_UPDATE_UPDATE', 'Rollen Update');
define ('ADMIN_ROLE_DELETE_DELETE', 'Rolle löschen');
define ('ADMIN_ROLE_UPDATE_TITLE', 'Update-Funktion');
define ('ADMIN_ROLE_UPDATED', 'Rollen aktualisiert!');
define ('ADMIN_ROLE_UPDATE_ERROR', 'Rollen Update-Fehler!');
define ('ADMIN_ROLE_GET_ERROR', 'Rolle bekommen Fehler!');
define ('ADMIN_ROLE_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diese Rolle löschen möchten?');
define ('ADMIN_ROLE_DELETED', 'Rolle gelöscht!');
define ('ADMIN_ROLE_DELETE_ERROR', 'Rolle löschen Fehler!');
define ('ADMIN_ROLE_GET_LIST_ERROR', 'Rolle bekommen Liste Fehler!');
define ('ADMIN_ROLE_ACCESS_GET_LIST_ERROR', 'Rollen anmelden Liste Fehler!');

// User

define ('ADMIN_USER_ADD_TITLE', 'Benutzer hinzufügen');
define ('ADMIN_USER_ADD_ADD', 'Benutzer hinzufügen');
define ('ADMIN_USER_ROLE', 'Rolle');
define ('ADMIN_USER_ACTIVE', 'Aktiv');
define ('ADMIN_USER_LOGIN', 'Login');
define ('ADMIN_USER_PASSWORD', 'Passwort');
define ('ADMIN_USER_PASSWORD2', 'Passwort (Bestätigung)');
define ('ADMIN_USER_OLD_PASSWORD', 'Altes Kennwort');
define ('ADMIN_USER_EMAIL', 'E-Mail');
define ('ADMIN_USER_LANG', 'Sprache');
define ('ADMIN_USER_THEME', 'Theme');
define ('ADMIN_USER_FIRST_NAME', 'Vorname');
define ('ADMIN_USER_LAST_NAME', 'Nachname');
define ('ADMIN_USER_PHONE', 'Telefon');
define ('ADMIN_USER_LIST_TITLE', 'Benutzerliste');
define ('ADMIN_USER_DUPLICATE_KEY', 'Benutzer existiert bereits!');
define ('ADMIN_USER_ADDED', 'Benutzer hinzugefügt!');
define ('ADMIN_USER_ADD_ERROR', 'Benutzer hinzufügen Fehler!');
define ('ADMIN_USER_UPDATE_UPDATE', 'User-Update');
define ('ADMIN_USER_DELETE_DELETE', 'Benutzer löschen');
define ('ADMIN_USER_UPDATE_TITLE', 'Benutzer aktualisieren');
define ('ADMIN_USER_UPDATED', 'Benutzer aktualisiert!');
define ('ADMIN_USER_UPDATE_ERROR', 'Benutzer Update-Fehler!');
define ('ADMIN_USER_GET_ERROR', 'Benutzer erhalten Fehler!');
define ('ADMIN_USER_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diesen Benutzer wirklich gelöscht werden?');
define ('ADMIN_USER_DELETED', 'Benutzer ist gelöscht!');
define ('ADMIN_USER_DELETE_ERROR', 'Benutzer löschen Fehler!');
define ('ADMIN_USER_GET_LIST_ERROR', 'Benutzer erhalten Fehlerliste!');
define ('ADMIN_USER_PASSWORD_NOT_THE_SAME', 'Passwörter sind nicht identisch!');
define ('ADMIN_USER_RESET_PASSWORD', 'reset');
define ('ADMIN_USER_RESET_PASSWORD_QUESTION', 'Sind Sie sicher, dass Sie das Benutzerpasswort \'password\' zurücksetzen?');
define ('ADMIN_USER_PASSWORD_RESETED', 'Passwort zurückgesetzt!');
define ('ADMIN_USER_PASSWORD_RESET_ERROR', 'Password Reset Fehler!');
define ('ADMIN_USER_GET_PASSWORD_WITH_USER_LOGIN_ERROR', 'Get Passwort Fehler!');
define ('ADMIN_USER_GET_INFORMATION_WITH_USER_LOGIN_ERROR', 'Get Benutzerinformationen Fehler!');
define ('ADMIN_USER_OLD_PASSWORD_INCORRECT', 'Altes Passwort ist nicht korrekt!');
define ('ADMIN_USER_ACCOUNT_UPDATE_ERROR', 'Konto-Update-Fehler!');
define ('ADMIN_USER_GET_PASSWORD_WITH_USER_ID_ERROR', 'Kennwort immer Fehler!');
define ('ADMIN_USER_ACCOUNT_UPDATED', 'Konto aktualisiert!');
define ('ADMIN_USER_EMAIL_NOT_CORRECT', 'E-Mail-Format ist nicht korrekt!');
define ('ADMIN_USER_PASSWORD_RESET_MISSING_EMAIL', 'E-Mail nicht verfügbar!');
define ('ADMIN_USER_ADDRESS_LINE_1', 'Adresszeile 1');
define ('ADMIN_USER_ADDRESS_LINE_2', 'Adresszeile 2');
define ('ADMIN_USER_ADDRESS_LINE_3', 'Adresszeile 3');
define ('ADMIN_USER_ADDRESS_POSTAL_CODE', 'PLZ');
define ('ADMIN_USER_ADDRESS_CITY', 'Stadt');
define ('ADMIN_USER_ADDRESS_REGION', 'Region');
define ('ADMIN_USER_ADDRESS_COUNTRY', 'Land');
define ('ADMIN_USER_USEFULL_FOR_DELIVERIES','Nützliche Informationen für Lieferungen');



// Error

define ('ADMIN_ERROR_LIST_TITLE', 'Fehlerliste');
define ('ADMIN_ERROR_GET_LIST_ERROR', 'Fehler erhalten Liste Fehler!');
define ('ADMIN_ERROR_DATE', 'Datum');
define ('ADMIN_ERROR_USER', 'Benutzer');
define ('ADMIN_ERROR_URL', 'URL');
define ('ADMIN_ERROR_NAME', 'Name');
define ('ADMIN_ERROR_DESCRIPTION', 'Beschreibung');
define ('ADMIN_ERROR_DELETE_START_DATE', 'Fehler von Datum löschen');
define ('ADMIN_ERROR_DELETE_END_DATE', 'um');
define ('ADMIN_ERROR_DELETE_DELETE', 'Löschen');
define ('ADMIN_ERROR_DELETE_QUESTION', 'Sind Sie sicher, dass diese Fehlerbereich gelöscht werden?');
define ('ADMIN_ERROR_DELETED', 'Fehler (n) gelöscht!');
define ('ADMIN_ERROR_DELETE_ERROR', 'Fehler löschen Fehler!');

// Log

define ('ADMIN_LOG_LIST_TITLE', 'Melden Liste');
define ('ADMIN_LOG_GET_LIST_ERROR', 'Melden Sie sich zu Liste Fehler!');
define ('ADMIN_LOG_DATE', 'Datum');
define ('ADMIN_LOG_USER', 'Benutzer');
define ('ADMIN_LOG_NAME', 'Name');
define ('ADMIN_LOG_DESCRIPTION', 'Beschreibung');
define ('ADMIN_LOG_DELETE_START_DATE', 'Protokolle von Datum löschen');
define ('ADMIN_LOG_DELETE_END_DATE', 'um');
define ('ADMIN_LOG_DELETE_DELETE', 'Löschen');
define ('ADMIN_LOG_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diese Protokollbereich gelöscht werden?');
define ('ADMIN_LOG_DELETED', 'Log (n) gelöscht!');
define ('ADMIN_LOG_DELETE_ERROR', 'Log löschen Fehler!');

// Version

define ('ADMIN_VERSION_LIST_TITLE', 'Versionsliste');
define ('ADMIN_VERSION_ADD_ADD', 'Fügen Sie eine Version');
define ('ADMIN_VERSION_ADD_TITLE', 'Fügen Sie eine Version');
define ('ADMIN_VERSION_GET_LIST_ERROR', 'Version erhalten Liste Fehler!');
define ('ADMIN_VERSION_NUMBER', 'Anzahl');
define ('ADMIN_VERSION_NAME', 'Name');
define ('ADMIN_VERSION_DATE', 'Datum');
define ('ADMIN_VERSION_DESCRIPTION', 'Beschreibung');
define ('ADMIN_VERSION_UPDATE_UPDATE', 'Update-Version');
define ('ADMIN_VERSION_UPDATE_TITLE', 'Version Update');
define ('ADMIN_VERSION_UPDATED', 'Version aktualisiert!');
define ('ADMIN_VERSION_UPDATE_ERROR', 'Version nicht aktualisiert!');
define ('ADMIN_VERSION_GET_ERROR', 'Version Ladefehler!');
define ('ADMIN_VERSION_DELETE_DELETE', 'Löschen');
define ('ADMIN_VERSION_DELETED', 'Version gelöscht!');
define ('ADMIN_VERSION_DELETE_ERROR', 'Version löschen Fehler!');
define ('ADMIN_VERSION_ADDED', 'Version hinzugefügt!');
define ('ADMIN_VERSION_ADD_ERROR', 'Version Fehler hinzuzufügen!');
define ('ADMIN_VERSION_DUPLICATE_KEY', 'Version ist bereits vorhanden!');
define ('ADMIN_VERSION_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diese Version gelöscht werden?');

// Site theme

define ('ADMIN_SITE_THEME_LIST_TITLE', 'Themenliste');
define ('ADMIN_SITE_THEME_ADD_ADD', 'Fügen Sie ein Thema');
define ('ADMIN_SITE_THEME_ADD_TITLE', 'Fügen Sie ein Thema');
define ('ADMIN_SITE_THEME_GET_LIST_ERROR', 'Themenliste Fehler');
define ('ADMIN_SITE_THEME_CODE', 'Kodex');
define ('ADMIN_SITE_THEME_NAME', 'Name');
define ('ADMIN_SITE_THEME_UPDATE_UPDATE', 'Thema aktualisieren');
define ('ADMIN_SITE_THEME_UPDATE_TITLE', 'Theme Update');
define ('ADMIN_SITE_THEME_UPDATED', 'Theme aktualisiert!');
define ('ADMIN_SITE_THEME_UPDATE_ERROR', 'Theme nicht aktualisiert!');
define ('ADMIN_SITE_THEME_GET_ERROR', 'Theme Ladefehler!');
define ('ADMIN_SITE_THEME_DELETE_DELETE', 'Löschen');
define ('ADMIN_SITE_THEME_DELETED', 'Theme gelöscht!');
define ('ADMIN_SITE_THEME_DELETE_ERROR', 'Thema löschen Fehler!');
define ('ADMIN_SITE_THEME_ADDED', 'Theme hinzugefügt!');
define ('ADMIN_SITE_THEME_ADD_ERROR', 'Thema hinzufügen Fehler!');
define ('ADMIN_SITE_THEME_DUPLICATE_KEY', 'Thema existiert bereits!');
define ('ADMIN_SITE_THEME_DELETE_QUESTION', 'Sind Sie sicher, dass Sie dieses Thema wirklich löschen?');

// Menu

define ('ADMIN_MENU_ADD_TITLE', 'Menü hinzufügen');
define ('ADMIN_MENU_ADD_ADD', 'Menü hinzufügen');
define ('ADMIN_MENU_NAME', 'Name');
define ('ADMIN_MENU_ACCESS', 'Access');
define ('ADMIN_MENU_LINK', 'Link');
define ('ADMIN_MENU_TARGET', 'Link-Ziel');
define ('ADMIN_MENU_LEVEL_0', 'Ebene 0');
define ('ADMIN_MENU_LEVEL_1', 'Ebene 1');
define ('ADMIN_MENU_STYLE', 'Style');
define ('ADMIN_MENU_ITEM_TYPE', 'Datentyp');
define ('ADMIN_MENU_ITEM_TYPE_2', 'Datenkategorie');
define ('ADMIN_MENU_IMAGE', 'Bild');
define ('ADMIN_MENU_LIST_TITLE', 'Menüliste');
define ('ADMIN_MENU_DUPLICATE_KEY', 'Menü existiert bereits!');
define ('ADMIN_MENU_ADDED', 'Menü hinzugefügt');
define ('ADMIN_MENU_ADD_ERROR', 'Menü hinzufügen Fehler!');
define ('ADMIN_MENU_UPDATE_UPDATE', 'Menü Update');
define ('ADMIN_MENU_UPDATE_TITLE', 'Menü aktualisieren');
define ('ADMIN_MENU_UPDATED', 'Menü aktualisiert!');
define ('ADMIN_MENU_UPDATE_ERROR', 'Menü Update-Fehler!');
define ('ADMIN_MENU_GET_ERROR', 'Menü erhalten Fehler!');
define ('ADMIN_MENU_DELETE_DELETE', 'Löschen');
define ('ADMIN_MENU_DELETED', 'Menü gelöscht!');
define ('ADMIN_MENU_DELETE_ERROR', 'Menü nicht gelöscht!');
define ('ADMIN_MENU_DELETE_QUESTION', 'Sind Sie sicher, dass Sie dieses Menü gelöscht werden?');

// Blog

define ('BLOG_ADD_TITLE', 'Blog hinzufügen');
define ('BLOG_ADD_ADD', 'Blog hinzufügen');
define ('BLOG_ACTIVE', 'Visible');
define ('BLOG_TEXT_LANG', 'Sprache');
define ('BLOG_TEXT_TITLE', 'Titel');
define ('BLOG_TEXT_VALUE', 'Beschreibung');
define ('BLOG_LIST_TITLE', 'Blog-Liste');
define ('BLOG_LAST_LIST_TITLE', 'Letzte Blog');
define ('BLOG_DUPLICATE_KEY', 'Blog existiert bereits!');
define ('BLOG_ADDED', 'Blog hinzu!');
define ('BLOG_ADD_ERROR', 'Blog hinzufügen Fehler!');
define ('BLOG_UPDATE_UPDATE', 'Blog-Update');
define ('BLOG_UPDATE_TITLE', 'Update-Blogs');
define ('BLOG_UPDATED', 'Blog aktualisiert!');
define ('BLOG_UPDATE_ERROR', 'Blog-Update-Fehler!');
define ('BLOG_GET_ERROR', 'Blog bekommen Fehler!');
define ('BLOG_DELETE_DELETE', 'Löschen');
define ('BLOG_DELETED', 'Blog gelöscht!');
define ('BLOG_DELETE_ERROR', 'Blog nicht gelöscht!');
define ('BLOG_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diesen Blog gelöscht werden?');
define ('BLOG_TMP_IMAGE_LOADED', 'Blog temporäre Image geladen!');
define ('BLOG_IMAGE_LOADED', 'Bild Blog geladen!');
define ('BLOG_IMAGE_DELETED', 'Bild Blog gelöscht!');
define ('BLOG_IMAGE',' ');
define ('BLOG_GET_LIST_ERROR', 'Blog bekommen Liste Fehler!');
define ('BLOG_IMAGE_UPDATE_ERROR', 'Bild Blog Update-Fehler!');
define ('BLOG_IMAGE_DELETE_ERROR', 'Blog Bild zu löschen Fehler!');
define ('BLOG_ACTIVATE_ERROR', 'Blog aktivieren Fehler!');
define ('BLOG_HITS','view(s)');

// Links

define ('LINKS_ADD_TITLE', 'Link hinzufügen');
define ('LINKS_ADD_ADD', 'Link hinzufügen');
define ('LINKS_ACTIVE', 'Visible');
define ('LINKS_TEXT_LANG', 'Sprache');
define ('LINKS_LINK', 'Link');
define ('LINKS_TITLE', 'Titel');
define ('LINKS_TEXT_VALUE', 'Beschreibung');
define ('LINKS_LIST_TITLE', 'Linkliste');
define ('LINKS_LAST_LIST_TITLE', 'Letzte Links');
define ('LINKS_DUPLICATE_KEY', 'Link-existiert bereits!');
define ('LINKS_ADDED', 'Link hinzugefügt!');
define ('LINKS_ADD_ERROR', 'Link hinzufügen Fehler!');
define ('LINKS_UPDATE_UPDATE', 'Link-Update');
define ('LINKS_UPDATE_TITLE', 'Update-Links');
define ('LINKS_UPDATED', 'Link-Update!');
define ('LINKS_UPDATE_ERROR', 'Link-Update-Fehler!');
define ('LINKS_GET_ERROR', 'Link-Fehler bekommen!');
define ('LINKS_DELETE_DELETE', 'Löschen');
define ('LINKS_DELETED', 'Link-gelöscht!');
define ('LINKS_DELETE_ERROR', 'Link-nicht gelöscht!');
define ('LINKS_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diesen Link gelöscht werden?');
define ('LINKS_TMP_IMAGE_LOADED', 'Link-temporäre Image geladen!');
define ('LINKS_IMAGE_LOADED', 'Bild verlinken geladen!');
define ('LINKS_IMAGE_DELETED', 'Bild verlinken gelöscht!');
define ('LINKS_IMAGE', '');
define ('LINKS_GET_LIST_ERROR', 'Link-Liste zu bekommen Fehler!');
define ('LINKS_IMAGE_UPDATE_ERROR', 'Bild verlinken Update-Fehler!');
define ('LINKS_IMAGE_DELETE_ERROR', 'Bild verlinken Fehler löschen!');
define ('LINKS_ACTIVATE_ERROR', 'Link-aktivieren Fehler!');

// Item

define ('ITEM_ADD_TITLE', 'Objekt hinzufügen');
define ('ITEM_ADDED', 'Artikel hinzugefügt!');
define ('ITEM_ADD_ERROR', 'Artikel hinzugefügt!');
define ('ITEM_LIST_TITLE', 'Artikelliste');
define ('ITEM_LAST_LIST_TITLE', 'Letzte Aktualisierung Artikel');
define ('ITEM_UPDATE_TITLE', 'Punkt Update');
define ('ITEM_UPDATED', 'Artikel aktualisiert!');
define ('ITEM_UPDATE_ERROR', 'Artikel nicht mehr aktualisiert!');
define ('ITEM_GET_ERROR', 'Artikel nicht geladen!');
define ('ITEM_IMAGE', '');
define ('ITEM_NAME', 'Name');
define ('ITEM_TYPE', 'Type');
define ('ITEM_TYPE_2', 'Kategorie');
define ('ITEM_ACTIVE', 'Visible');
define ('ITEM_TEXT_LANG', 'Sprache');
define ('ITEM_TEXT_VALUE', 'Beschreibung');
define ('ITEM_IMAGE_LOADED', 'Bild geladen!');
define ('ITEM_TMP_IMAGE_LOADED', 'Bild geladen!');
define ('ITEM_TMP_IMAGE_NOT_LOADED', 'Bild nicht geladen!');
define ('ITEM_TMP_IMAGE_DELETED', 'Bild gelöscht!');
define ('ITEM_TMP_IMAGE_DELETE_ERROR', 'Bild nicht gelöscht!');
define ('ITEM_IMAGE_DELETED', 'Bild gelöscht!');
define ('ITEM_IMAGE_DELETE_ERROR', 'Bild nicht gelöscht!');
define ('ITEM_UPDATE_UPDATE', 'Update');
define ('ITEM_ADD_ADD', 'Hinzufügen');
define ('ITEM_ACTIVATE_ERROR', 'Artikel-Aktivierung / Desaktivierung Fehler!');
define ('ITEM_DUPLICATE_KEY', 'Artikel existiert bereits!');
define ('ITEM_DELETE_DELETE', 'Löschen');
define ('ITEM_DELETED', 'Artikel gelöscht!');
define ('ITEM_DELETE_ERROR', 'Artikel nicht gelöscht!');
define ('ITEM_DELETE_QUESTION', 'Bist du sicher, dass du diesen Inhalt löschen möchtest?');
define ('ITEM_PHOTO_GALLERY', 'Bildergalerie');
define ('ITEM_MAIN_PHOTO','Haupt Bilder');
define ('ITEM_OTHER_PHOTO','Andere Bilder');
define ('ITEM_HIT', 'Hits');
define ('TO_SELL', 'zu verkaufen');

define ('ADMIN_IMAGE_LOADED','Image loaded!');
define ('ADMIN_IMAGE_UPDATED','Image updated!');
define ('ADMIN_IMAGE_DELETED','Image deleted!');


// Configuration

define ('MENU_ADMIN_CONFIGURATION', 'Konfiguration');

define ('ADMIN_CONFIGURATION_GET_LIST_ERROR', 'Konfigurationsliste Fehler!');
define ('ADMIN_CONFIGURATION_DATE', 'Datum');
define ('ADMIN_CONFIGURATION_USER', 'Benutzer');
define ('ADMIN_CONFIGURATION_ACTIVE', 'Aktiv');
define ('ADMIN_CONFIGURATION_NAME', 'Name');
define ('ADMIN_CONFIGURATION_DELETE_DELETE', 'Löschen');
define ('ADMIN_CONFIGURATION_DELETE_QUESTION', 'Sind Sie sicher, dass Sie diese Konfiguration gelöscht werden soll?');
define ('ADMIN_CONFIGURATION_DELETED', 'Konfiguration gelöscht!');
define ('ADMIN_CONFIGURATION_DELETE_ERROR', 'Fehler beim Löschen der Konfiguration!');
define ('ADMIN_CONFIGURATION_BANNER_SIZE', 'Banner Größe');
define ('ADMIN_CONFIGURATION_HOME_BLOG_NUMBER', 'Startseite Blog-Nummer');
define ('ADMIN_CONFIGURATION_HOME_ITEMS_NUMBER', 'Startseite Artikel-Nummer');
define ('ADMIN_CONFIGURATION_HOME_SHOW_BLOG', 'Startseite Blog Vorführung');
define ('ADMIN_CONFIGURATION_HOME_SHOW_ITEMS', 'Startseite Produkte zeigen');
define ('ADMIN_CONFIGURATION_SHOW_LANG', 'Zeigen lang wählen');
define ('ADMIN_CONFIGURATION_SHOW_MANAGER_ADDRESS', 'Manager-Adresse anzeigen');
define ('ADMIN_CONFIGURATION_DEFAULT_THEME', 'Standard-Design');
define ('ADMIN_CONFIGURATION_SITE_NAME', 'Website URL');
define ('ADMIN_CONFIGURATION_HTTP', 'HTTP URL');
define ('ADMIN_CONFIGURATION_ADMINISTRATOR_EMAIL', 'Verwalter e-mail');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_1', 'Adresszeile 1');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_2', 'Adresszeile 2');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_3', 'Adresszeile 3');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_POSTAL_CODE', 'Postleitzahl');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_CITY', 'Stadt');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_REGION', 'Region');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_COUNTRY', 'Land');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_TELEPHONE', 'Telefon');
define ('ADMIN_CONFIGURATION_MANAGER_EMAIL', 'E-Mail-Manager');
define ('ADMIN_CONFIGURATION_COPYRIGHT', 'Copyright');
define ('ADMIN_CONFIGURATION_COPYRIGHT_LINK', 'Copyright link');
define ('ADMIN_CONFIGURATION_LOG_DATABASE', 'Datenbankprotokoll Spar');
define ('ADMIN_CONFIGURATION_LOG_SHOW', 'Log zeigen');
define ('ADMIN_CONFIGURATION_LOG_FILE', 'Dateiprotokoll Spar');
define ('ADMIN_CONFIGURATION_ERROR_DATABASE', 'Datenbankfehler Spar');
define ('ADMIN_CONFIGURATION_ERROR_SHOW', 'Fehler Vorführung');
define ('ADMIN_CONFIGURATION_ERROR_FILE', 'Dateifehler Spar');
define ('ADMIN_CONFIGURATION_IMAGE_FULL_WIDTH', 'Breite große Bilder');
define ('ADMIN_CONFIGURATION_IMAGE_FULL_HEIGHT', 'Höhe der großen Bilder');
define ('ADMIN_CONFIGURATION_IMAGE_MEDIUM_WIDTH', 'Breite mittlere Bilder');
define ('ADMIN_CONFIGURATION_IMAGE_MEDIUM_HEIGHT', 'Höhe der Mittel Bilder');
define ('ADMIN_CONFIGURATION_IMAGE_LITTLE_WIDTH', 'Breite des kleinen Bilder');
define ('ADMIN_CONFIGURATION_IMAGE_LITTLE_HEIGHT', 'Höhe der kleinen Bilder');
define ('ADMIN_CONFIGURATION_IMAGE_MIN_WIDTH', 'Breite min Bilder');
define ('ADMIN_CONFIGURATION_IMAGE_MIN_HEIGHT', 'Höhe min Bilder');
define ('ADMIN_CONFIGURATION_IMAGE_TMP_PREFIX', 'Temporary image Präfix');
define ('ADMIN_CONFIGURATION_DATABASE_MAX_ROWS', 'Listen max Ergebnisse');
define ('ADMIN_CONFIGURATION_IP_KEY', 'IP Schlüssel');
define ('ADMIN_CONFIGURATION_SIMPLE_REGISTER', 'Einfache Registermodus');
define ('ADMIN_CONFIGURATION_STORE_ENABLED', 'Store-Modus');
define ('ADMIN_CONFIGURATION_STORE_ORDER_DELIVERY_TYPE_DEFAULT', 'Standardliefermodus');
define ('ADMIN_CONFIGURATION_STORE_ORDER_STATUS_INITIAL', 'Bestellen Ausgangszustand');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0', 'Postgebühren Niveau 0');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0_AMOUNT', 'Postgebühren Niveau 0 : preis');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0_WEIGHT', 'Postgebühren Niveau 0 : gewicht');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1', 'Postgebühren Niveau 2');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1_AMOUNT', 'Postgebühren Niveau 1 : preis');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1_WEIGHT', 'Postgebühren Niveau 1 : gewicht');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2', 'Postgebühren Niveau 2');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2_AMOUNT', 'Postgebühren Niveau 2 : preis');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2_WEIGHT', 'Postgebühren Niveau 2 : gewicht');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_3', 'Postgebühren Niveau 3');
define ('ADMIN_CONFIGURATION_BLOG_ENABLED', 'Blog-Modus');
define ('ADMIN_CONFIGURATION_SITEMAP_FILE', 'SITEMAP Datei');
define ('ADMIN_ADMIN_CONFIGURATION_LIST_TITLE', 'Konfigurationsliste');
define ('ADMIN_ADMIN_CONFIGURATION_ADD_TITLE', 'Fügen Sie eine Konfiguration');
define ('ADMIN_ADMIN_CONFIGURATION_UPDATE_TITLE', 'Konfiguration aktualisieren');
define ('ADMIN_ADMIN_CONFIGURATION_ADD_ADD', 'Hinzufügen');
define ('ADMIN_ADMIN_CONFIGURATION_UPDATE_UPDATE', 'Aktualisierung');
define ('ADMIN_ADMIN_CONFIGURATION_DELETE_DELETE', 'Löschen');
define ('ADMIN_ADMIN_CONFIGURATION_UPDATED', 'Konfiguration aktualisiert!');
define ('ADMIN_ADMIN_CONFIGURATION_ADDED', 'Konfiguration hinzugefügt!');
define ('ADMIN_CONFIGURATION_ITEM_COMMENT_ENABLED', 'Enabled Kommentar');
define ('ADMIN_CONFIGURATION_BLOG_COMMENT_ENABLED', 'Aktiviert Blog-Kommentar');

define ('EXPORT_TO_EXCEL', 'Export nach Excel');
define ('EXPORT_TO_PDF', 'Export in PDF');

define ('SEARCH', 'Suchen');
define ('SEARCH_ITEMS', 'Artikel');
define ('SEARCH_BLOG', 'Themen');

define ('TAG', 'Stichwort');
define ('TAGS', 'Stichworte');
define ('TAG_ITEMS', 'Artikel');
define ('TAG_BLOG', 'Themen');
define ('TAG_LIST', 'Stichwort liste');
define ('ADMIN_ITEM_TAG_ADDED','Stichwort hinzugefügt!');
define ('ADMIN_ITEM_TAG_DELETED','Stichwort gelöscht!');
define ('ADMIN_BLOG_TAG_ADDED','Stichwort hinzugefügt!');
define ('ADMIN_BLOG_TAG_DELETED','Stichwort gelöscht!');

// Specific part
$root = dirname(__FILE__)."/../";
include_once($root.'./config/locale_de_specific.php');
?>