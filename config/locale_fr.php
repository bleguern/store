<?php
/* V1.3
 * 
 * V1.1 : 20130524 : Links
 * V1.2 : 20131004 : Menu style added
 * V1.3 : 20131015 : Item type 2 added
 * 
 */

// Lang

define ('LANG','FR');
define ('LOWER_LANG','fr');

// Legals

define ('LEGALS', 'Design & développement');

// Date

define ('DATABASE_DATE_FORMAT','%d/%m/%Y');
define ('DATABASE_DATE_YEAR_FORMAT','%Y');
define ('DATABASE_DATETIME_FORMAT','%d/%m/%Y %H:%i:%s');
define ('PHP_DATE_FORMAT','d/m/Y');
define ('PHP_DATETIME_FORMAT','d/m/Y H:i:s');
define ('HTML_DATE_FORMAT','dd/mm/YYYY');

define('ON', 'Le ');
define('AT', ' à ');
define('BY', ' par ');
define('FROM', ' de ');
define('YEAR', 'an');
define('YEARS', 'ans');
define('THIS_YEAR', 'Né(e) cette année!');
define('READ_NEXT', '...lire la suite');

define('JANUARY', 'Janvier');
define('FEBRUARY', 'Février');
define('MARCH', 'Mars');
define('APRIL', 'Avril');
define('MAY', 'Mai');
define('JUNE', 'Juin');
define('JULY', 'Juillet');
define('AUGUST', 'Août');
define('SEPTEMBER', 'Septembre');
define('OCTOBER', 'Octobre');
define('NOVEMBER', 'Novembre');
define('DECEMBER', 'Décembre');
define('JANUARY_LITTLE', 'Jan');
define('FEBRUARY_LITTLE', 'Fev');
define('MARCH_LITTLE', 'Mar');
define('APRIL_LITTLE', 'Avr');
define('MAY_LITTLE', 'Mai');
define('JUNE_LITTLE', 'Jui');
define('JULY_LITTLE', 'Jui');
define('AUGUST_LITTLE', 'Aou');
define('SEPTEMBER_LITTLE', 'Sep');
define('OCTOBER_LITTLE', 'Oct');
define('NOVEMBER_LITTLE', 'Nov');
define('DECEMBER_LITTLE', 'Dec');

define('MONDAY', 'Lundi');
define('TUESDAY', 'Mardi');
define('WEDNESDAY', 'Mercredi');
define('THURSDAY', 'Jeudi');
define('FRIDAY', 'Vendredi');
define('SATURDAY', 'Samedi');
define('SUNDAY', 'Dimanche');

define('MONDAY_LITTLE', 'Lun');
define('TUESDAY_LITTLE', 'Mar');
define('WEDNESDAY_LITTLE', 'Mer');
define('THURSDAY_LITTLE', 'Jeu');
define('FRIDAY_LITTLE', 'Ven');
define('SATURDAY_LITTLE', 'Sam');
define('SUNDAY_LITTLE', 'Dim');

define('MONDAY_LETTER', 'L');
define('TUESDAY_LETTER', 'M');
define('WEDNESDAY_LETTER', 'M');
define('THURSDAY_LETTER', 'J');
define('FRIDAY_LETTER', 'V');
define('SATURDAY_LETTER', 'S');
define('SUNDAY_LETTER', 'D');

define('TODAY', 'Aujourd\'hui');

// General

define ('ERROR', 'Erreur');
define ('LOADING', 'Chargement...');

define ('YES', 'Oui');
define ('NO', 'Non');

define ('BACK', 'Retour');
define ('NEW', 'Nouveau');
define ('UPDATE', 'Mettre à jour');
define ('DELETE', 'Supprimer');
define ('ADD', 'Ajouter');
define ('CLEAR', 'Vider');

define ('UPLOAD_MAIN_IMAGE', 'Télécharger une photo principale');
define ('UPLOAD_IMAGE', 'Télécharger une photo');

define ('MANDATORY_FIELDS','* : Champ obligatoire');

define ('NO_RESULT','Pas de résultat');

define ('TABLE_TOTAL_NUMBER','Total');
define ('TABLE_PAGE_NUMBER','page');

define ('LAST_UPDATE_DATE','Mise a jour');
define ('LAST_UPDATE_USER','Utilisateur');

// Error logging

define ('ERROR_FATAL','Erreur fatale : veuillez contacter l\'administrateur!');
define ('ERROR_INITIALISE','Erreur d\'initialisation : veuillez contacter l\'administrateur!');

define ('MISSING_ARGUMENT_ERROR', 'Champ(s) manquant(s)!');
define ('MISSING_METHOD_ERROR', 'Fonction manquante!');
define ('MISSING_FIELDS_ERROR', 'Champ(s) manquant(s)!');

define ('ERROR_LOGIN','Erreur de connexion!');
define ('ERROR_LOGOUT','Erreur de déconnexion!');

define ('ERROR_LOAD_URL','Erreur de chargement d\'URL!');

define ('ERROR_RIGHT','Erreur de droits!');

define ('ERROR_ADMIN_SAVE_LOG','Save log error!');

define ('ERROR_USER_SAVE_CONNECTION','User save connection error!');
define ('ERROR_USER_GET_PASSWORD','User password error!');
define ('ERROR_USER_GET_INFORMATION','User information error!');
define ('ERROR_USER_GET_RIGHT','User right error!');
define ('ERROR_ITEM_GET_ACTIVE_LIST','Get active list error!');
define ('ERROR_GET_HOME_ACTIVE_ITEM_LIST','Get home active item list error!');

define ('ERROR_SAVE_CONNECTION_ERROR','Save connection error!');

define ('GET_LIST_ERROR','Erreur de liste!');

define ('MESSAGE_BAD_LOGIN','Login ou mot de passe incorrect!');
define ('MESSAGE_USER_DESACTIVATED','Utilisateur désactivé : veuillez contacter l\'administrateur!');

define ('MESSAGE_AUTHORISATION','Vous n\'êtes pas autorisé(e) à accéder à cette page!');

// Site definition

define ('MENU', 'Menu');
define ('MENU_HOME', 'Accueil');
define ('MENU_BLOG', 'Blog');
define ('MENU_CONTACT', 'Contact');
define ('MENU_CONNECTION', 'Connexion');
define ('MENU_DISCONNECTION', 'Déconnexion');
define ('MENU_ADMIN', 'Admin');
define ('MENU_ADMIN_ACCESS', 'Accès');
define ('MENU_ADMIN_ERROR', 'Erreurs');
define ('MENU_ADMIN_ITEM', 'Données');
define ('MENU_ADMIN_LOG', 'Journaux');
define ('MENU_ADMIN_BLOG', 'Blog');
define ('MENU_ADMIN_LINKS', 'Liens');
define ('MENU_ADMIN_ROLE', 'Roles');
define ('MENU_ADMIN_STATS', 'Statistiques');
define ('MENU_ADMIN_SITE_THEME', 'Thèmes');
define ('MENU_ADMIN_VERSION', 'Versions');
define ('MENU_ADMIN_USER', 'Utilisateurs');
define ('MENU_ADMIN_MENU', 'Menus');
define ('MENU_ADMIN_ITEM_TYPE', 'Type de données');
define ('MENU_ADMIN_ITEM_TYPE_2', 'Catégorie de données');
define ('MENU_LINKS', 'Liens');
define ('MENU_SEARCH', '');

// Store mode

define ('MENU_CONNECTION_ACCOUNT', 'Mes informations');
define ('MENU_CONNECTION_BASKET', 'Mon panier');
define ('MENU_CONNECTION_ORDER', 'Mes commandes');
define ('MENU_ADMIN_ORDER', 'Commandes');
define ('MENU_ADMIN_ORDER_STATUS', 'Statuts de commande');

define ('ADD_TO_BASKET', 'Ajouter au panier');
define ('NOT_AVAILABLE', 'Réservé');
define ('BASKET_ADDED', 'Article ajouté au <A HREF="../pages/basket.php" TARGET="_self">panier</A>!');
define ('BASKET_ADD_NO_INVENTORY', 'Article non ajouté au panier, stock indisponible!'); 
define ('BASKET_DELETED', 'Article supprimé du panier');
define ('BASKET_GO_TO_ORDER_QUESTION', 'Etes vous sur de vouloir passer une commande?');
define ('PLEASE_CONNECT_BEFORE_CREATE_ORDER', 'Veuillez-vous connecter ou vous enregistrer pour saisir une commande!');
define ('PLEASE_CONNECT_BEFORE_LIST_ORDER', 'Veuillez-vous connecter ou vous enregistrer pour lister vos commandes!');
define ('GO_TO_ORDER', 'Passer commande');
define ('EMPTY_BASKET', 'Vider le panier');
define ('BASKET_EMPTIED', 'Panier vidé!');
define ('BASKET_IS_EMPTY', 'Votre panier est vide!');
define ('BASKET_TITLE', 'Mon panier');
define ('BASKET_DELETE_QUESTION', 'Etes vous sur de vouloir vider le panier?');
define ('GET_BASKET_ERROR', 'Erreur de chargement de panier!');

define ('QUANTITY', 'Quantité');
define ('PRICE', 'Prix');
define ('UNIT_PRICE', 'Prix unitaire');
define ('TOTAL_PRICE', 'Prix total');

define ('TABLE_TOTAL_AMOUNT','Sous-total des articles');
define ('POSTAL_CHARGES_AMOUNT','Frais d\'envoi');
define ('ORDER_DISCOUNT','Remise');
define ('TABLE_FULL_AMOUNT','Montant total');

define ('ADMIN_ORDER_LIST_TITLE','Liste des commandes');
define ('ADMIN_ORDER_STATUS_LIST_TITLE','Liste des statuts de commande');
define ('ADMIN_ORDER_STATUS_ADD_TITLE','Ajouter un statut de commande');
define ('ADMIN_ORDER_STATUS_UPDATE_TITLE','Modifier un statut de commande');
define ('ADMIN_ORDER_STATUS_ADD_ADD','Ajouter');
define ('ADMIN_ORDER_STATUS_UPDATE_UPDATE','Mettre à jour');
define ('ADMIN_ORDER_STATUS_DELETE_DELETE','Supprimer');
define ('ADMIN_ORDER_STATUS_DUPLICATE_KEY','Statut de commande déjà existant!');
define ('ADMIN_ORDER_STATUS_ADDED','Statut de commande ajouté!');
define ('ADMIN_ORDER_STATUS_ADD_ERROR','Erreur d\'ajout de statut de commande!');
define ('ADMIN_ORDER_STATUS_UPDATE_ERROR','Erreur de mise à jour de statut de commande!');
define ('ADMIN_ORDER_STATUS_UPDATED','Statut de commande mis à jour!');
define ('ADMIN_ORDER_STATUS_DELETED','Statut de commande supprimé!');
define ('ADMIN_ORDER_STATUS_DELETE_QUESTION','Etes vous sur de vouloir supprimer ce statut de commande?');
define ('ADMIN_ORDER_STATUS_ID','ID');
define ('ADMIN_ORDER_STATUS_NAME','Statut');
define ('ADMIN_ORDER_STATUS_ACTIVE','Actif');
define ('ADMIN_ORDER_STATUS_INVENTORY_RESERVE','Réservation stock');
define ('ADMIN_ORDER_STATUS_INVENTORY_CLEANUP','Libération stock');
define ('ADMIN_ORDER_STATUS_LOCK','Blocage commande');
define ('ADMIN_ORDER_STATUS_OTHER_POSSIBLE_STATUS','Statuts possibles');
define ('ORDER_TITLE','Commande');
define ('ERROR_ORDER_GET_HEADER','Erreur de chargement d\'en tete de commande!');
define ('CANCEL_ORDER','Annuler la commande');
define ('ORDER_CREATED','Commande créée!');
define ('ORDER_CREATION_DATE','Date de création');
define ('ORDER_STATUS','Statut de commande');
define ('ORDER_LAST_UPDATE','Dernière mise à jour');
define ('ORDER_LAST_UPDATE_BY',' par ');
define ('ORDER_ITEM_LIST','Liste des articles');
define ('ORDER_ITEM_COUNT','Nombre d\'articles');
define ('ORDER_LIST_TITLE','Mes commandes');
define ('ORDER_NUMBER','Commande n°');
define ('ORDER_CUSTOMER','Client');
define ('ORDER_USER','Utilisateur');

define ('ORDER_UPDATE_UPDATE','Mettre à jour');
define ('ADMIN_ORDER_UPDATED','Commande mise à jour!');
define ('ADMIN_ORDER_LINE_DELETED','Ligne de commande supprimée!');
define ('ORDER_ADD_COMMENT','Ajouter un commentaire');
define ('ORDER_COMMENT','Commentaires');
define ('ORDER_COMMENT_ADDED','Commentaire ajouté!');
define ('ADMIN_ORDER_COMMENT_ADDED','Commentaire ajouté!');
define ('ORDER_COMMENT_NOT_YOUR_ORDER_ERROR','Ajout de commentaire impossible sur cette commande!');

define ('MAIL_ORDER_CREATED_1','Commande n°');
define ('MAIL_ORDER_CREATED_2',' créée');
define ('MAIL_ORDER_ORDER_NUMBER','Numéro de commande');
define ('MAIL_ORDER_INFORMATIONS','Informations');
define ('MAIL_ORDER_SEE_ONLINE','Suivre la commande en ligne');
define ('MAIL_ORDER_CREATED_MESSAGE', '<H2>Bonjour,</H2><BR>
Votre commande a bien été créée, elle est maintenant en cours de validation. Un email vous sera envoyé pour chaque étape de suivi de votre commande.<BR>
Si vous souhaitez visualiser une autre commande, veuillez consulter vos commandes sur ');

define ('MAIL_ORDER_UPDATED_1','Commande n°');
define ('MAIL_ORDER_UPDATED_2',' mise à jour');
define ('MAIL_ORDER_UPDATED_MESSAGE', '<H2>Bonjour,</H2><BR>
Votre commande a été mise à jour. Un email vous sera envoyé pour chaque étape de suivi de votre commande.<BR>
Si vous souhaitez visualiser une autre commande, veuillez consulter vos commandes sur ');

define ('MAIL_ORDER_COMMENT_ADDED_1','Commande n°');
define ('MAIL_ORDER_COMMENT_ADDED_2',' : commentaire ajouté');
define ('MAIL_ORDER_COMMENT_ADDED_MESSAGE', '<H2>Bonjour,</H2><BR>
Un commentaire a été ajouté sur votre commande. Un email vous sera envoyé pour chaque étape de suivi de votre commande.<BR>
Si vous souhaitez visualiser une autre commande, veuillez consulter vos commandes sur ');


define ('ORDER_STATUS_CREATED','Créée');
define ('ORDER_STATUS_VALIDATED','Validée');
define ('ORDER_STATUS_CANCELLED','Annulée');
define ('ORDER_STATUS_PENDING_PAYMENT','En attente de paiement');
define ('ORDER_STATUS_DELIVERING','En cours de livraison');
define ('ORDER_STATUS_DELIVERED','Livrée');
define ('ORDER_STATUS_CLOSED','Cloturée');


define ('ORDER_DELIVERY_TYPE','Mode d\'envoi');

define ('ORDER_DELIVERY_TYPE_POST','Envoi colis poste');
define ('ORDER_DELIVERY_TYPE_HAND_OVER','Remise en main propre');


define ('BASKET_INFORMATIONS_TITLE','Informations');
define ('BASKET_INFORMATIONS_EMPTY_MESSAGE','Pour acheter un article ou plus maintenant, cliquez sur le bouton "Ajouter au le panier" à côté d\'un article.<BR><BR>Le prix et la disponibilité des articles sur le site sont sujets à changement.<BR>Le panier est un lieu temporaire où est stockée une liste de vos articles et où se reflète le prix le plus récent de chaque article.<BR><BR>Une question sur un article ou le fonctionnement du site? Veuillez-vous rendre sur la page de <A HREF="contact.php" TARGET="_self"><B>contact</B></A>.');
define ('BASKET_INFORMATIONS_NOT_EMPTY_MESSAGE','Vous pouvez maintenant passer commande ou choisir d\'autres articles sur le site.<BR><BR>Le prix et la disponibilité des articles sur le site sont sujets à changement.<BR>Le panier est un lieu temporaire où est stockée une liste de vos articles et où se reflète le prix le plus récent de chaque article.<BR><BR>Une question sur un article ou le fonctionnement du site? Veuillez-vous rendre sur la page de <A HREF="contact.php" TARGET="_self"><B>contact</B></A>.');

// Value

define ('VALUE_TEXT_LANG_DISPLAY_LIST_ERROR','Text lang list error!');

// Login

define ('LOGIN_LOGIN_TITLE', 'Connexion au site');
define ('LOGIN_LOGOUT_TITLE', 'Déconnexion du site');
define ('LOGIN_LOGIN', 'Utilisateur / email');
define ('LOGIN_PASSWORD', 'Mot de passe');
define ('LOGIN_CONNECT', 'Connexion');
define ('LOGIN_CONNECTED', 'Utilisateur connecté!');
define ('LOGIN_CONNECTED_AS', 'Connecté en tant que ');
define ('LOGIN_DISCONNECT', 'Déconnexion');
define ('LOGIN_DISCONNECTED', 'Utilisateur déconnecté!');
define ('LOGIN_INCORRECT', 'Utilisateur / email ou mot de passe incorrect!');
define ('LOGIN_INACTIVE', 'Utilisateur / email ou mot de passe incorrect! Veuillez contacter l\'administrateur');
define ('LOGIN_CONNECT_ERROR', 'Erreur de connexion!');
define ('LOGIN_DISCONNECT_ERROR', 'Erreur de déconnexion!');
define ('LOGIN_CREATE_ACCOUNT', 'Créer un compte');
define ('LOGIN_REGISTER', 'S\'enregistrer');
define ('LOGIN_FORGOT_PASSWORD', 'Mot de passe oublié');
define ('LOGIN_RESET_PASSWORD', 'Réinitialiser le mot de passe');
define ('MAIL_ACCOUNT_CREATED', 'Compte créé : ');
define ('PASSWORD_RESETED', 'Mot de passe réinitialisé!');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_1', '<H2>Bonjour,</H2><BR>
Votre compte a bien été créé sur notre site.<BR><BR>
Vos informations de connexion :<BR>
Utilisateur : ');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_2', '<BR>Mot de passe : ');
define ('MAIL_ACCOUNT_CREATED_MESSAGE_3', '<BR>
Attention aux majuscules et aux minuscules.<BR><BR>
Vous pouvez maintenant vous connecter sur le site à cette adresse : ');
define ('MAIL_REGISTERED', 'Compte créé : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_1', '<H2>Bonjour,</H2><BR>
Votre email a bien été enregistré sur notre site.<BR><BR>
Vos informations de connexion :<BR>
Utilisateur / email : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_2', '<BR>Mot de passe : ');
define ('MAIL_ACCOUNT_REGISTER_MESSAGE_3', '<BR>
Attention aux majuscules et aux minuscules.<BR><BR>
Vous pouvez maintenant vous connecter sur le site à cette adresse : ');
define ('MAIL_RESET_PASSWORD', 'Réinitialisation du mot de passe');
define ('MAIL_RESET_PASSWORD_MESSAGE_1', '<H2>Bonjour,</H2><BR>
Votre mot de passe sur notre site a bien été changé.<BR><BR>
Voici votre nouveau mot de passe : ');
define ('MAIL_RESET_PASSWORD_MESSAGE_2', '<BR>
Attention aux majuscules et aux minuscules.<BR><BR>
Vous pouvez maintenant vous connecter sur le site à cette adresse : ');

// Account 

define ('ACCOUNT_CREATED', 'Compte créé!');
define ('ACCOUNT_REGISTERED', 'Compte créé!');
define ('UPDATE_ACCOUNT_TITLE','Mes informations');


// Contact

define ('CONTACT_TITLE', 'Contact');
define ('CONTACT_EMAIL', 'Votre email');
define ('CONTACT_NAME', 'Votre nom');
define ('CONTACT_MESSAGE', 'Votre message');
define ('CONTACT_COPY', 'Envoyer une copie du message à mon adresse');
define ('CONTACT_SEND', 'Envoyer le message');
define ('CONTACT_MESSAGE_SENT', 'Message envoyé!');
define ('CONTACT_MAIL_MESSAGE', 'Message');
define ('CONTACT_FORM', 'Formulaire de contact');
define ('CONTACT_INFORMATIONS', 'Informations');

// Link

define ('LINK_TITLE', 'Liens');

// Link

define ('ADMIN_TITLE', 'Administration');

// Item type

define ('ITEM_TYPE_ADD_TITLE', 'Ajouter un type de donnée');
define ('ITEM_TYPE_ADD_ADD', 'Ajouter un type');
define ('ITEM_TYPE_NAME', 'Type');
define ('ITEM_TYPE_LOGO_FILENAME', 'Logo');
define ('ITEM_TYPE_LIST_TITLE', 'Liste des types de donnée');
define ('ITEM_TYPE_DUPLICATE_KEY','Type de donnée déjà existant!');
define ('ITEM_TYPE_ADDED','Type de donnée ajouté!');
define ('ITEM_TYPE_ADD_ERROR','Erreur d\'ajout de type de donnée!');
define ('ITEM_TYPE_UPDATE_UPDATE','Mettre à jour');
define ('ITEM_TYPE_DELETE_DELETE','Supprimer');
define ('ITEM_TYPE_UPDATE_TITLE','Mettre à jour un type de donnée');
define ('ITEM_TYPE_UPDATED','Type de donnée mis à jour!');
define ('ITEM_TYPE_UPDATE_ERROR','Erreur de mise à jour de type de donnée!');
define ('ITEM_TYPE_GET_ERROR','Erreur de chargement de type de donnée!');
define ('ITEM_TYPE_DELETE_QUESTION','Etes vous sur de vouloir supprimer ce type de donnée?');
define ('ITEM_TYPE_DELETED','Type de donnée supprimé!');
define ('ITEM_TYPE_DELETE_ERROR','Erreur de suppression de type de donnée!');
define ('ITEM_TYPE_DELETE_CONSTRAINT','Le type de donnée ne peux pas être supprimé : contrainte!');

// Item type 2

define ('ITEM_TYPE_2_ADD_TITLE', 'Ajouter une catégorie');
define ('ITEM_TYPE_2_ADD_ADD', 'Ajouter une catégorie');
define ('ITEM_TYPE_2_NAME', 'Catégorie');
define ('ITEM_TYPE_2_LOGO_FILENAME', 'Logo');
define ('ITEM_TYPE_2_LIST_TITLE', 'Liste des catégories');
define ('ITEM_TYPE_2_DUPLICATE_KEY','Catégorie déjà existante!');
define ('ITEM_TYPE_2_ADDED','Catégorie ajoutée!');
define ('ITEM_TYPE_2_ADD_ERROR','Erreur d\'ajout de catégorie!');
define ('ITEM_TYPE_2_UPDATE_UPDATE','Mettre à jour');
define ('ITEM_TYPE_2_DELETE_DELETE','Supprimer');
define ('ITEM_TYPE_2_UPDATE_TITLE','Mettre à jour une catégorie');
define ('ITEM_TYPE_2_UPDATED','Catégorie mis à jour!');
define ('ITEM_TYPE_2_UPDATE_ERROR','Erreur de mise à jour de catégorie!');
define ('ITEM_TYPE_2_GET_ERROR','Erreur de chargement de catégorie!');
define ('ITEM_TYPE_2_DELETE_QUESTION','Etes vous sur de vouloir supprimer cette catégorie?');
define ('ITEM_TYPE_2_DELETED','Catégorie supprimée!');
define ('ITEM_TYPE_2_DELETE_ERROR','Erreur de suppression de catégorie!');
define ('ITEM_TYPE_2_DELETE_CONSTRAINT','La catégorie ne peux pas être supprimée : contrainte!');

// Access

define ('ADMIN_ACCESS_ADD_TITLE', 'Ajouter un accès');
define ('ADMIN_ACCESS_ADD_ADD', 'Ajouter un accès');
define ('ADMIN_ACCESS_URL', 'Url');
define ('ADMIN_ACCESS_DESCRIPTION', 'Description');
define ('ADMIN_ACCESS_LIST_TITLE', 'Liste des accès');
define ('ADMIN_ACCESS_DUPLICATE_KEY','Accès déjà existant!');
define ('ADMIN_ACCESS_ADDED','Accès ajouté!');
define ('ADMIN_ACCESS_ADD_ERROR','Erreur d\'ajout d\'accès!');
define ('ADMIN_ACCESS_UPDATE_UPDATE','Mettre à jour');
define ('ADMIN_ACCESS_DELETE_DELETE','Supprimer');
define ('ADMIN_ACCESS_UPDATE_TITLE','Mettre à jour un accès');
define ('ADMIN_ACCESS_UPDATED','Accès mis à jour!');
define ('ADMIN_ACCESS_UPDATE_ERROR','Erreur de mise à jour d\'accès!');
define ('ADMIN_ACCESS_GET_ERROR','Erreur de chargement d\'accès!');
define ('ADMIN_ACCESS_DELETE_QUESTION','Etes vous sur de vouloir supprimer cet accès?');
define ('ADMIN_ACCESS_DELETED','Accès supprimé!');
define ('ADMIN_ACCESS_DELETE_ERROR','Erreur de suppression d\'accès!');

// Role

define ('ADMIN_ROLE_ADD_TITLE', 'Ajouter un role');
define ('ADMIN_ROLE_ADD_ADD', 'Ajouter un role');
define ('ADMIN_ROLE_NAME', 'Nom');
define ('ADMIN_ROLE_LIST_TITLE', 'Liste des roles');
define ('ADMIN_ROLE_DUPLICATE_KEY','Role déjà existant!');
define ('ADMIN_ROLE_ADDED','Role ajouté');
define ('ADMIN_ROLE_ADD_ERROR','Erreur d\'ajout de role!');
define ('ADMIN_ROLE_ACCESS_ADDED','Accès de role ajouté!');
define ('ADMIN_ROLE_ACCESS_ADD_ERROR','Erreur d\'ajout d\'accès de role!');
define ('ADMIN_ROLE_ACCESS_DELETED','Accès de role supprimé!');
define ('ADMIN_ROLE_ACCESS_DELETE_ERROR','Erreur de suppression d\'accès de role!');
define ('ADMIN_ROLE_UPDATE_UPDATE','Mettre à jour');
define ('ADMIN_ROLE_DELETE_DELETE','Supprimer');
define ('ADMIN_ROLE_UPDATE_TITLE','Mettre à jour un role');
define ('ADMIN_ROLE_UPDATED','Role mis à jour!');
define ('ADMIN_ROLE_UPDATE_ERROR','Erreur de mise à jour de role!');
define ('ADMIN_ROLE_GET_ERROR','Erreur de chargement de role!');
define ('ADMIN_ROLE_DELETE_QUESTION','Etes vous sur de vouloir supprimer ce role?');
define ('ADMIN_ROLE_DELETED','Role supprimé!');
define ('ADMIN_ROLE_DELETE_ERROR','Erreur de suppression de role!');
define ('ADMIN_ROLE_GET_LIST_ERROR', 'Erreur de liste de role!');
define ('ADMIN_ROLE_ACCESS_GET_LIST_ERROR', 'Erreur de liste d\'accès de role!');

// User

define ('ADMIN_USER_ADD_TITLE', 'Ajouter un utilisateur');
define ('ADMIN_USER_ADD_ADD', 'Ajouter un utilisateur');
define ('ADMIN_USER_ROLE', 'Role');
define ('ADMIN_USER_ACTIVE', 'Actif');
define ('ADMIN_USER_LOGIN', 'Login');
define ('ADMIN_USER_PASSWORD', 'Mot de passe');
define ('ADMIN_USER_PASSWORD2', 'Mot de passe (confirmation)');
define ('ADMIN_USER_OLD_PASSWORD', 'Ancien mot de passe');
define ('ADMIN_USER_EMAIL', 'Email');
define ('ADMIN_USER_LANG', 'Langue');
define ('ADMIN_USER_THEME', 'Thème');
define ('ADMIN_USER_FIRST_NAME', 'Prénom');
define ('ADMIN_USER_LAST_NAME', 'Nom');
define ('ADMIN_USER_PHONE', 'Téléphone');
define ('ADMIN_USER_LIST_TITLE', 'Liste des utilisateurs');
define ('ADMIN_USER_DUPLICATE_KEY','L\'utilisateur existe déjà!');
define ('ADMIN_USER_ADDED','Utilisateur ajouté!');
define ('ADMIN_USER_ADD_ERROR','Erreur d\'ajout d\'utilisateur!');
define ('ADMIN_USER_UPDATE_UPDATE','Mettre à jour');
define ('ADMIN_USER_DELETE_DELETE','Supprimer');
define ('ADMIN_USER_UPDATE_TITLE','Mettre à jour un utilisateur');
define ('ADMIN_USER_UPDATED','Utilisateur mis à jour!');
define ('ADMIN_USER_UPDATE_ERROR','Erreur de mise à jour d\'utilisateur!');
define ('ADMIN_USER_GET_ERROR','Erreur de chargement d\'utilisateur!');
define ('ADMIN_USER_DELETE_QUESTION','Etes vous sûr de vouloir supprimer cet utilisateur?');
define ('ADMIN_USER_DELETED','Utilisateur supprimé!');
define ('ADMIN_USER_DELETE_ERROR','Erreur de suppression d\'utilisateur!');
define ('ADMIN_USER_GET_LIST_ERROR', 'Erreur de chargement de liste d\'utilisateur!');
define ('ADMIN_USER_PASSWORD_NOT_THE_SAME', 'Les mots de passe sont différents!');
define ('ADMIN_USER_RESET_PASSWORD','Réinitialiser');
define ('ADMIN_USER_RESET_PASSWORD_QUESTION','Etes vous sûr de vouloir réinitialiser le mot de passe à \'password\'?');
define ('ADMIN_USER_PASSWORD_RESETED','Mot de passe réinitialisé!');
define ('ADMIN_USER_PASSWORD_RESET_ERROR','Erreur de réinitialisation de mot de passe!');
define ('ADMIN_USER_GET_PASSWORD_WITH_USER_LOGIN_ERROR','Erreur de récupération de mot de passe!');
define ('ADMIN_USER_GET_INFORMATION_WITH_USER_LOGIN_ERROR','Erreur de récupération d\'information utilisateur!');
define ('ADMIN_USER_OLD_PASSWORD_INCORRECT','Ancien mot de passe incorrect!');
define ('ADMIN_USER_ACCOUNT_UPDATE_ERROR','Erreur de mise à jour de compte!');
define ('ADMIN_USER_GET_PASSWORD_WITH_USER_ID_ERROR','Erreur de récupération de mot de passe!');
define ('ADMIN_USER_ACCOUNT_UPDATED','Compte mis à jour!');
define ('ADMIN_USER_EMAIL_NOT_CORRECT', 'Format email incorrect!');
define ('ADMIN_USER_PASSWORD_RESET_MISSING_EMAIL', 'Compte email non disponible!');
define ('ADMIN_USER_ADDRESS_LINE_1','Adresse ligne 1');
define ('ADMIN_USER_ADDRESS_LINE_2','Adresse ligne 2');
define ('ADMIN_USER_ADDRESS_LINE_3','Adresse ligne 3');
define ('ADMIN_USER_ADDRESS_POSTAL_CODE','Code postal');
define ('ADMIN_USER_ADDRESS_CITY','Ville');
define ('ADMIN_USER_ADDRESS_REGION','Région');
define ('ADMIN_USER_ADDRESS_COUNTRY','Pays');
define ('ADMIN_USER_USEFULL_FOR_DELIVERIES','Informations utiles pour les livraisons');



// Error

define ('ADMIN_ERROR_LIST_TITLE', 'Liste des erreurs');
define ('ADMIN_ERROR_GET_LIST_ERROR', 'Erreur de liste d\'erreurs!');
define ('ADMIN_ERROR_DATE', 'Date');
define ('ADMIN_ERROR_USER', 'Utilisateur');
define ('ADMIN_ERROR_URL', 'Url');
define ('ADMIN_ERROR_NAME', 'Nom');
define ('ADMIN_ERROR_DESCRIPTION', 'Description');
define ('ADMIN_ERROR_DELETE_START_DATE', 'Suppression des erreurs à partir du');
define ('ADMIN_ERROR_DELETE_END_DATE', 'jusqu\'au');
define ('ADMIN_ERROR_DELETE_DELETE', 'Supprimer');
define ('ADMIN_ERROR_DELETE_QUESTION', 'Etes vous sur de vouloir supprimer cette plage d\'erreur?');
define ('ADMIN_ERROR_DELETED', 'Erreur(s) supprimée(s)!');
define ('ADMIN_ERROR_DELETE_ERROR', 'Erreur de suppression d\'erreur!');

// Log

define ('ADMIN_LOG_LIST_TITLE', 'Liste des journaux');
define ('ADMIN_LOG_GET_LIST_ERROR', 'Erreur de liste de journaux!');
define ('ADMIN_LOG_DATE', 'Date');
define ('ADMIN_LOG_USER', 'Utilisateur');
define ('ADMIN_LOG_NAME', 'Nom');
define ('ADMIN_LOG_DESCRIPTION', 'Description');
define ('ADMIN_LOG_DELETE_START_DATE', 'Suppression des journaux à partir du');
define ('ADMIN_LOG_DELETE_END_DATE', 'jusqu\'au');
define ('ADMIN_LOG_DELETE_DELETE', 'Supprimer');
define ('ADMIN_LOG_DELETE_QUESTION', 'Etes vous sur de vouloir supprimer cette plage de journaux?');
define ('ADMIN_LOG_DELETED', 'Journaux supprimées!');
define ('ADMIN_LOG_DELETE_ERROR', 'Erreur de suppression de journaux!');

// Version

define ('ADMIN_VERSION_LIST_TITLE', 'Liste des versions');
define ('ADMIN_VERSION_ADD_ADD', 'Ajouter une version');
define ('ADMIN_VERSION_ADD_TITLE', 'Ajouter une version');
define ('ADMIN_VERSION_GET_LIST_ERROR', 'Erreur de liste de version');
define ('ADMIN_VERSION_NUMBER', 'Numéro');
define ('ADMIN_VERSION_NAME', 'Nom');
define ('ADMIN_VERSION_DATE', 'Date');
define ('ADMIN_VERSION_DESCRIPTION', 'Description');
define ('ADMIN_VERSION_UPDATE_UPDATE','Mettre à jour la version');
define ('ADMIN_VERSION_UPDATE_TITLE','Mise à jour de version');
define ('ADMIN_VERSION_UPDATED','Version mis à jour!');
define ('ADMIN_VERSION_UPDATE_ERROR','Erreur de mise à jour de version!');
define ('ADMIN_VERSION_GET_ERROR','Erreur de chargement de version!');
define ('ADMIN_VERSION_DELETE_DELETE','Supprimer');
define ('ADMIN_VERSION_DELETED', 'Version supprimée!');
define ('ADMIN_VERSION_DELETE_ERROR', 'Erreur de suppression de version!');
define ('ADMIN_VERSION_ADDED', 'Version ajoutée!');
define ('ADMIN_VERSION_ADD_ERROR', 'Erreur d\'ajout de version!');
define ('ADMIN_VERSION_DUPLICATE_KEY','Version déjà existante!');
define ('ADMIN_VERSION_DELETE_QUESTION','Etes vous sur de vouloir supprimer cette version?');

// Site theme

define ('ADMIN_SITE_THEME_LIST_TITLE', 'Liste des thèmes');
define ('ADMIN_SITE_THEME_ADD_ADD', 'Ajouter un thème');
define ('ADMIN_SITE_THEME_ADD_TITLE', 'Ajouter un thème');
define ('ADMIN_SITE_THEME_GET_LIST_ERROR', 'Erreur de liste de thème');
define ('ADMIN_SITE_THEME_CODE', 'Code');
define ('ADMIN_SITE_THEME_NAME', 'Nom');
define ('ADMIN_SITE_THEME_UPDATE_UPDATE','Mettre à jour le thème');
define ('ADMIN_SITE_THEME_UPDATE_TITLE','Mise à jour de thème');
define ('ADMIN_SITE_THEME_UPDATED','Thème mis à jour!');
define ('ADMIN_SITE_THEME_UPDATE_ERROR','Erreur de mise à jour de thème!');
define ('ADMIN_SITE_THEME_GET_ERROR','Erreur de chargement de thème!');
define ('ADMIN_SITE_THEME_DELETE_DELETE','Supprimer');
define ('ADMIN_SITE_THEME_DELETED', 'Thème supprimé!');
define ('ADMIN_SITE_THEME_DELETE_ERROR', 'Erreur de suppression de thème!');
define ('ADMIN_SITE_THEME_ADDED', 'Thème ajouté!');
define ('ADMIN_SITE_THEME_ADD_ERROR', 'Erreur d\'ajout de thème!');
define ('ADMIN_SITE_THEME_DUPLICATE_KEY','Thème déjà existant!');
define ('ADMIN_SITE_THEME_DELETE_QUESTION','Etes vous sur de vouloir supprimer ce thème?');

// Menu

define ('ADMIN_MENU_ADD_TITLE', 'Ajouter un menu');
define ('ADMIN_MENU_ADD_ADD', 'Ajouter un menu');
define ('ADMIN_MENU_NAME', 'Nom');
define ('ADMIN_MENU_ACCESS', 'Accès');
define ('ADMIN_MENU_LINK', 'Lien');
define ('ADMIN_MENU_TARGET', 'Cible lien');
define ('ADMIN_MENU_LEVEL_0', 'Niveau 0');
define ('ADMIN_MENU_LEVEL_1', 'Niveau 1');
define ('ADMIN_MENU_STYLE', 'Style');
define ('ADMIN_MENU_ITEM_TYPE', 'Type de données');
define ('ADMIN_MENU_ITEM_TYPE_2', 'Catégorie de données');
define ('ADMIN_MENU_IMAGE', 'Image');
define ('ADMIN_MENU_LIST_TITLE', 'Liste des menus');
define ('ADMIN_MENU_DUPLICATE_KEY','Menu déjà existant!');
define ('ADMIN_MENU_ADDED','Menu ajouté!');
define ('ADMIN_MENU_ADD_ERROR','Erreur d\'ajout de menu!');
define ('ADMIN_MENU_UPDATE_UPDATE','Mettre à jour le menu');
define ('ADMIN_MENU_UPDATE_TITLE','Mise à jour de menu');
define ('ADMIN_MENU_UPDATED','Menu mis à jour!');
define ('ADMIN_MENU_UPDATE_ERROR','Erreur de mise à jour de menu!');
define ('ADMIN_MENU_GET_ERROR','Erreur de chargement de menu!');
define ('ADMIN_MENU_DELETE_DELETE','Supprimer');
define ('ADMIN_MENU_DELETED','Menu supprimé!');
define ('ADMIN_MENU_DELETE_ERROR','Erreur de suppression de menu!');
define ('ADMIN_MENU_DELETE_QUESTION','Etes vous sur de vouloir supprimer ce menu?');

// Blog

define ('BLOG_ADD_TITLE', 'Ajouter un topic');
define ('BLOG_ADD_ADD', 'Ajouter un topic');
define ('BLOG_ACTIVE', 'Visible');
define ('BLOG_TEXT_LANG', 'Langue');
define ('BLOG_TEXT_TITLE', 'Titre');
define ('BLOG_TEXT_VALUE', 'Description');
define ('BLOG_LIST_TITLE', 'Liste des topics');
define ('BLOG_LAST_LIST_TITLE', 'Derniers topics');
define ('BLOG_DUPLICATE_KEY','Topic déjà existante!');
define ('BLOG_ADDED','Topic ajoutée!');
define ('BLOG_ADD_ERROR','Erreur d\'ajout de topic!');
define ('BLOG_UPDATE_UPDATE','Mettre à jour le topic');
define ('BLOG_UPDATE_TITLE','Mise à jour de topic');
define ('BLOG_UPDATED','Topic mis à jour!');
define ('BLOG_UPDATE_ERROR','Erreur de mise à jour de topic!');
define ('BLOG_GET_ERROR','Erreur de chargement de topic!');
define ('BLOG_DELETE_DELETE','Supprimer');
define ('BLOG_DELETED','Topic supprimé!');
define ('BLOG_DELETE_ERROR','Erreur de suppression de topic!');
define ('BLOG_DELETE_QUESTION','Etes vous sur de vouloir supprimer ce topic?');
define ('BLOG_TMP_IMAGE_LOADED','Image temporaire de topic chargée!');
define ('BLOG_IMAGE_LOADED','Image de topic chargée!');
define ('BLOG_IMAGE_DELETED','Image de topic supprimée!');
define ('BLOG_IMAGE',' ');
define ('BLOG_GET_LIST_ERROR','Erreur de chargement de liste de topic!');
define ('BLOG_IMAGE_UPDATE_ERROR','Erreur de changement d\'image!');
define ('BLOG_IMAGE_DELETE_ERROR','Erreur de suppression d\'image!');
define ('BLOG_ACTIVATE_ERROR','Erreur d\'activation de topic!');
define ('BLOG_HITS','vue(s)');

// Links

define ('LINKS_ADD_TITLE', 'Ajouter un lien');
define ('LINKS_ADD_ADD', 'Ajouter un lien');
define ('LINKS_ACTIVE', 'Visible');
define ('LINKS_TEXT_LANG', 'Langue');
define ('LINKS_LINK', 'Lien');
define ('LINKS_TITLE', 'Titre');
define ('LINKS_TEXT_VALUE', 'Description');
define ('LINKS_LIST_TITLE', 'Liste des liens');
define ('LINKS_LAST_LIST_TITLE', 'Derniers liens');
define ('LINKS_DUPLICATE_KEY','Lien déjà existant!');
define ('LINKS_ADDED','Lien ajouté!');
define ('LINKS_ADD_ERROR','Erreur d\'ajout de lien!');
define ('LINKS_UPDATE_UPDATE','Mettre à jour le lien');
define ('LINKS_UPDATE_TITLE','Mise à jour de lien');
define ('LINKS_UPDATED','Lien mis à jour!');
define ('LINKS_UPDATE_ERROR','Erreur de mise à jour de lien!');
define ('LINKS_GET_ERROR','Erreur de chargement de lien!');
define ('LINKS_DELETE_DELETE','Supprimer');
define ('LINKS_DELETED','Lien supprimé!');
define ('LINKS_DELETE_ERROR','Erreur de suppression de lien!');
define ('LINKS_DELETE_QUESTION','Etes vous sur de vouloir supprimer ce lien?');
define ('LINKS_TMP_IMAGE_LOADED','Image temporaire de lien chargée!');
define ('LINKS_IMAGE_LOADED','Image de lien chargée!');
define ('LINKS_IMAGE_DELETED','Image de lien supprimée!');
define ('LINKS_IMAGE',' ');
define ('LINKS_GET_LIST_ERROR','Erreur de chargement de liste de lien!');
define ('LINKS_IMAGE_UPDATE_ERROR','Erreur de changement de lien!');
define ('LINKS_IMAGE_DELETE_ERROR','Erreur de suppression de lien!');
define ('LINKS_ACTIVATE_ERROR','Erreur d\'activation de lien!');

// Item

define ('ITEM_ADD_TITLE','Ajouter une donnée');
define ('ITEM_ADDED','Donnée ajoutée!');
define ('ITEM_ADD_ERROR','Donnée non ajoutée!');
define ('ITEM_LIST_TITLE','Liste des données');
define ('ITEM_LAST_LIST_TITLE','Nouveautés');
define ('ITEM_UPDATE_TITLE','Mettre à jour une donnée');
define ('ITEM_UPDATED','Donnée mise à jour!');
define ('ITEM_UPDATE_ERROR','Donnée non mise à jour!');
define ('ITEM_GET_ERROR','Erreur de chargement de donnée!');
define ('ITEM_IMAGE',' ');
define ('ITEM_NAME','Nom');
define ('ITEM_TYPE','Type');
define ('ITEM_TYPE_2','Catégorie');
define ('ITEM_ACTIVE','Visible');
define ('ITEM_TEXT_LANG', 'Langue');
define ('ITEM_TEXT_VALUE', 'Description');
define ('ITEM_IMAGE_LOADED','Image chargée!');
define ('ITEM_TMP_IMAGE_LOADED','Image chargée!');
define ('ITEM_TMP_IMAGE_NOT_LOADED','Image non chargée!');
define ('ITEM_TMP_IMAGE_DELETED','Image supprimée!');
define ('ITEM_TMP_IMAGE_DELETE_ERROR','Image non supprimée!');
define ('ITEM_IMAGE_DELETED','Image supprimée!');
define ('ITEM_IMAGE_DELETE_ERROR','Image non supprimée!');
define ('ITEM_UPDATE_UPDATE','Mettre à jour');
define ('ITEM_ADD_ADD','Ajouter');
define ('ITEM_ACTIVATE_ERROR','Erreur d\'activation\\de desactivation!');
define ('ITEM_DUPLICATE_KEY','Donnée déjà existante!');
define ('ITEM_DELETE_DELETE','Supprimer');
define ('ITEM_DELETED','Donnée supprimée!');
define ('ITEM_DELETE_ERROR','Erreur de suppression de donnée!');
define ('ITEM_DELETE_QUESTION','Etes vous sur de vouloir supprimer cette donnée?');
define ('ITEM_PHOTO_GALLERY','Galerie photo');
define ('ITEM_MAIN_PHOTO','Photo principale');
define ('ITEM_OTHER_PHOTO','Autres photos');
define ('ITEM_VIDEO_GALLERY','Galerie vidéo');
define ('ITEM_HIT','Visites');
define ('TO_SELL','A vendre');
define ('ITEM_IMAGE_COPYRIGHT','Copyright information');
define ('ITEM_IMAGE_COPYRIGHT_TITLE','Description');
define ('ITEM_IMAGE_COPYRIGHT_LINK','Lien');
define ('ITEM_IMAGE_COPYRIGHT_DATE','Date');


define ('ADMIN_IMAGE_LOADED','Image chargée!');
define ('ADMIN_IMAGE_UPDATED','Image mise à jour!');
define ('ADMIN_IMAGE_DELETED','Image supprimée!');



// Configuration

define ('MENU_ADMIN_CONFIGURATION', 'Configuration');

define ('ADMIN_CONFIGURATION_GET_LIST_ERROR', 'Erreur de liste de configuration!');
define ('ADMIN_CONFIGURATION_DATE', 'Date');
define ('ADMIN_CONFIGURATION_USER', 'Utilisateur');
define ('ADMIN_CONFIGURATION_ACTIVE', 'Active');
define ('ADMIN_CONFIGURATION_NAME', 'Nom');
define ('ADMIN_CONFIGURATION_DELETE_DELETE', 'Supprimer');
define ('ADMIN_CONFIGURATION_DELETE_QUESTION', 'Etes vous sur de vouloir supprimer cette configuration?');
define ('ADMIN_CONFIGURATION_DELETED', 'Configuration supprimée!');
define ('ADMIN_CONFIGURATION_DELETE_ERROR', 'Erreur de suppression de configuration!');
define ('ADMIN_CONFIGURATION_BANNER_SIZE', 'Taille de bannière');
define ('ADMIN_CONFIGURATION_HOME_BLOG_NUMBER', 'Nombre de blog dans l\'accueil');
define ('ADMIN_CONFIGURATION_HOME_ITEMS_NUMBER', 'Nombre d\'article dans l\'accueil');
define ('ADMIN_CONFIGURATION_HOME_SHOW_BLOG', 'Affichage accueil blog');
define ('ADMIN_CONFIGURATION_HOME_SHOW_ITEMS', 'Affichage accueil liste d\'articles');
define ('ADMIN_CONFIGURATION_SHOW_LANG', 'Affichage choix de langue');
define ('ADMIN_CONFIGURATION_SHOW_MANAGER_ADDRESS', 'Affichage adresse manager');
define ('ADMIN_CONFIGURATION_DEFAULT_THEME', 'Thème par défaut');
define ('ADMIN_CONFIGURATION_SITE_NAME', 'Site URL');
define ('ADMIN_CONFIGURATION_HTTP', 'HTTP URL');
define ('ADMIN_CONFIGURATION_ADMINISTRATOR_EMAIL', 'Email administrateur');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_1', 'Adresse ligne 1');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_2', 'Adresse ligne 2');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_LINE_3', 'Adresse ligne 3');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_POSTAL_CODE', 'Code postal');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_CITY', 'Ville');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_REGION', 'Region');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_COUNTRY', 'Pays');
define ('ADMIN_CONFIGURATION_MANAGER_ADDRESS_TELEPHONE', 'Téléphone');
define ('ADMIN_CONFIGURATION_MANAGER_EMAIL', 'Email manager');
define ('ADMIN_CONFIGURATION_COPYRIGHT', 'Copyright');
define ('ADMIN_CONFIGURATION_COPYRIGHT_LINK', 'Lien copyright');
define ('ADMIN_CONFIGURATION_LOG_DATABASE', 'Sauvegarde des journaux en base');
define ('ADMIN_CONFIGURATION_LOG_SHOW', 'Affichage des journaux');
define ('ADMIN_CONFIGURATION_LOG_FILE', 'Sauvegarde des journaux sur fichier');
define ('ADMIN_CONFIGURATION_ERROR_DATABASE', 'Sauvegarde des erreurs en base');
define ('ADMIN_CONFIGURATION_ERROR_SHOW', 'Affichage des erreurs');
define ('ADMIN_CONFIGURATION_ERROR_FILE', 'Sauvegarde des erreurs sur fichier');
define ('ADMIN_CONFIGURATION_IMAGE_FULL_WIDTH', 'Largeur image grande');
define ('ADMIN_CONFIGURATION_IMAGE_FULL_HEIGHT', 'Hauteur image grande');
define ('ADMIN_CONFIGURATION_IMAGE_MEDIUM_WIDTH', 'Largeur image moyenne');
define ('ADMIN_CONFIGURATION_IMAGE_MEDIUM_HEIGHT', 'Hauteur image moyenne');
define ('ADMIN_CONFIGURATION_IMAGE_LITTLE_WIDTH', 'Largeur image petite'); 
define ('ADMIN_CONFIGURATION_IMAGE_LITTLE_HEIGHT', 'Hauteur image petite');
define ('ADMIN_CONFIGURATION_IMAGE_MIN_WIDTH', 'Largeur image mini');
define ('ADMIN_CONFIGURATION_IMAGE_MIN_HEIGHT', 'Hauteur image mini');
define ('ADMIN_CONFIGURATION_IMAGE_TMP_PREFIX', 'Préfixe images temporaires');
define ('ADMIN_CONFIGURATION_DATABASE_MAX_ROWS', 'Nombre maximal de résultats (listes)');
define ('ADMIN_CONFIGURATION_IP_KEY', 'IP key');
define ('ADMIN_CONFIGURATION_SIMPLE_REGISTER', 'Mode "enregistrement simple"');
define ('ADMIN_CONFIGURATION_STORE_ENABLED', 'Mode "magasin"');
define ('ADMIN_CONFIGURATION_STORE_ORDER_DELIVERY_TYPE_DEFAULT', 'Mode de livraison par défaut'); 
define ('ADMIN_CONFIGURATION_STORE_ORDER_STATUS_INITIAL', 'Statut initial de commande'); 
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0', 'Frais d\'envoie niveau 0');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0_AMOUNT', 'Frais d\'envoie niveau 0 : montant');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_0_WEIGHT', 'Frais d\'envoie niveau 0 : poids');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1', 'Frais d\'envoie niveau 2');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1_AMOUNT', 'Frais d\'envoie niveau 1 : montant');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_1_WEIGHT', 'Frais d\'envoie niveau 1 : poids');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2', 'Frais d\'envoie niveau 2');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2_AMOUNT', 'Frais d\'envoie niveau 2 : montant');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_2_WEIGHT', 'Frais d\'envoie niveau 2 : poids');
define ('ADMIN_CONFIGURATION_STORE_POSTAL_CHARGES_3', 'Frais d\'envoie niveau 3');
define ('ADMIN_CONFIGURATION_BLOG_ENABLED', 'Mode "blog"');
define ('ADMIN_CONFIGURATION_SITEMAP_FILE', 'Fichier SITEMAP');
define ('ADMIN_ADMIN_CONFIGURATION_LIST_TITLE', 'Liste des configurations');
define ('ADMIN_ADMIN_CONFIGURATION_ADD_TITLE', 'Ajouter une configuration'); 
define ('ADMIN_ADMIN_CONFIGURATION_UPDATE_TITLE', 'Mettre à jour une configuration'); 
define ('ADMIN_ADMIN_CONFIGURATION_ADD_ADD', 'Ajouter');
define ('ADMIN_ADMIN_CONFIGURATION_UPDATE_UPDATE', 'Mettre à jour');
define ('ADMIN_ADMIN_CONFIGURATION_DELETE_DELETE', 'Supprimer');
define ('ADMIN_ADMIN_CONFIGURATION_UPDATED', 'Configuration mise à jour!');
define ('ADMIN_ADMIN_CONFIGURATION_ADDED', 'Configuration ajoutée!');
define ('ADMIN_CONFIGURATION_ITEM_COMMENT_ENABLED', 'Commentaires sur les articles');
define ('ADMIN_CONFIGURATION_BLOG_COMMENT_ENABLED', 'Commentaires sur le blog');

define ('EXPORT_TO_EXCEL', 'Exporter la liste sous Excel');
define ('EXPORT_TO_PDF', 'Exporter en fichier PDF');

define ('SEARCH', 'Recherche');
define ('SEARCH_ITEMS', 'Articles');
define ('SEARCH_BLOG', 'Topics');

define ('FILTER', 'Filtre');

define ('TAG', 'Mot-clé');
define ('TAGS', 'Mots-clés');
define ('TAG_ITEMS', 'Articles');
define ('TAG_BLOG', 'Topics');
define ('TAG_LIST', 'Liste des mots-clés');
define ('ADMIN_ITEM_TAG_ADDED','Tag ajouté!');
define ('ADMIN_ITEM_TAG_DELETED','Tag supprimé!');
define ('ADMIN_BLOG_TAG_ADDED','Tag ajouté!');
define ('ADMIN_BLOG_TAG_DELETED','Tag supprimé!');


define ('ADD_COMMENT','Ajouter un commentaire');
define ('COMMENT_ADDED','Commentaire ajouté!');
define ('MAIL_COMMENT_ADDED','Commentaire ajouté!');
define ('MAIL_COMMENT_ADDED_MESSAGE','<H2>Bonjour,</H2><BR>
Un commentaire a été ajouté.');


// Specific part
$root = dirname(__FILE__)."/../";
include_once($root.'./config/locale_fr_specific.php');
?>