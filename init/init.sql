-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 29 Avril 2014 à 15:04
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `demo`
--

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_access`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_access` (
  `admin_access_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_access_url` varchar(100) NOT NULL,
  `admin_access_description` varchar(200) DEFAULT NULL,
  `admin_access_creation_date` datetime NOT NULL,
  `admin_access_last_update_date` datetime NOT NULL,
  `admin_access_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_access_id`),
  UNIQUE KEY `UNIQUE` (`admin_access_url`),
  KEY `admin_access_last_update_admin_user_id` (`admin_access_last_update_admin_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_access`
--

INSERT INTO `#DATABASE_PREFIX#admin_access` (`admin_access_id`, `admin_access_url`, `admin_access_description`, `admin_access_creation_date`, `admin_access_last_update_date`, `admin_access_last_update_admin_user_id`) VALUES
(1, 'admin_access', 'Access management', '2012-07-09 09:59:20', '2012-09-11 21:23:39', 0),
(2, 'admin_item', 'Data management', '2012-07-09 10:57:16', '2012-09-11 21:19:55', 0),
(3, 'admin_item_type', 'Data type management', '2012-07-09 10:57:41', '2012-09-11 21:20:31', 0),
(4, 'admin_error', 'Error management', '2012-09-11 21:18:37', '2014-03-19 16:32:52', 1),
(5, 'admin_log', 'Log management', '2012-09-11 21:19:06', '2012-09-11 21:19:06', 0),
(6, 'admin_blog', 'Blog management', '2012-09-11 21:19:32', '2012-09-11 21:19:32', 0),
(7, 'admin_role', 'Role management', '2012-09-11 21:21:06', '2012-09-11 21:21:06', 0),
(8, 'admin_site_theme', 'Site theme management', '2012-09-11 21:21:40', '2012-09-11 21:21:40', 0),
(9, 'admin_version', 'Version management', '2012-09-11 21:22:00', '2012-09-11 21:22:00', 0),
(10, 'admin_user', 'User management', '2012-09-11 21:22:23', '2012-09-11 21:22:23', 0),
(11, 'admin_menu', 'Menu management', '2012-09-11 21:23:01', '2012-09-11 21:23:01', 0),
(12, 'admin', 'Management', '2012-09-11 21:23:58', '2012-09-11 21:24:09', 0),
(13, 'account_update', 'Account update', '2012-09-12 14:42:28', '2012-09-12 14:42:28', 0),
(14, 'admin_links', 'Links management', '2013-05-28 22:14:07', '2013-05-28 22:14:07', 0),
(15, 'basket', 'Own basket management', '2014-01-28 16:39:33', '2014-01-28 16:42:06', 1),
(16, 'order', 'Own order management', '2014-01-28 16:39:52', '2014-01-28 16:42:23', 1),
(17, 'admin_order', 'Order administration', '2014-01-28 16:40:28', '2014-01-28 16:40:28', 1),
(18, 'admin_inventory', 'Inventory management', '2014-01-28 16:41:33', '2014-03-19 16:34:59', 1),
(19, 'admin_item_type_2', 'Data type 2 management', '2014-01-28 17:04:57', '2014-01-28 17:05:12', 1),
(20, 'admin_order_status', 'Order status management', '2014-03-20 15:21:17', '2014-03-20 15:21:17', 1),
(21, 'admin_item_specific_brand', 'Brand management', '2014-04-09 09:15:13', '2014-04-09 09:15:13', 1),
(22, 'admin_configuration', 'Configuration management', '2014-04-22 16:18:41', '2014-04-22 16:18:41', 1);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_configuration`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_configuration` (
  `admin_configuration_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_configuration_active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin_configuration_name` varchar(50) NOT NULL,
  `admin_configuration_http` varchar(50) NOT NULL DEFAULT 'http://',
  `admin_configuration_site_name` varchar(50) NOT NULL,
  `admin_configuration_default_theme` varchar(50) NOT NULL DEFAULT 'main',
  `admin_configuration_administrator_email` varchar(50) NOT NULL,
  `admin_configuration_manager_email` varchar(50) NOT NULL,
  `admin_configuration_banner_size` int(10) unsigned NOT NULL,
  `admin_configuration_show_lang` tinyint(1) unsigned NOT NULL,
  `admin_configuration_home_show_items` tinyint(1) unsigned NOT NULL,
  `admin_configuration_home_items_number` int(10) unsigned NOT NULL DEFAULT '10',
  `admin_configuration_copyright` varchar(50) NOT NULL,
  `admin_configuration_log_database` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `admin_configuration_log_show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin_configuration_log_file` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `admin_configuration_error_database` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `admin_configuration_error_show` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin_configuration_error_file` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `admin_configuration_image_full_width` int(10) unsigned NOT NULL DEFAULT '2048',
  `admin_configuration_image_full_height` int(10) unsigned NOT NULL DEFAULT '1536',
  `admin_configuration_image_medium_width` int(10) unsigned NOT NULL DEFAULT '320',
  `admin_configuration_image_medium_height` int(10) unsigned NOT NULL DEFAULT '240',
  `admin_configuration_image_little_width` int(10) unsigned NOT NULL DEFAULT '160',
  `admin_configuration_image_little_height` int(10) unsigned NOT NULL DEFAULT '120',
  `admin_configuration_image_min_width` int(10) unsigned NOT NULL DEFAULT '80',
  `admin_configuration_image_min_height` int(10) unsigned NOT NULL DEFAULT '60',
  `admin_configuration_image_tmp_prefix` varchar(50) NOT NULL DEFAULT 'tmp_',
  `admin_configuration_ip_key` varchar(50) DEFAULT NULL,
  `admin_configuration_simple_register` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin_configuration_store_enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin_configuration_store_order_delivery_type_default` int(10) unsigned NOT NULL,
  `admin_configuration_store_order_status_initial` int(10) unsigned NOT NULL,
  `admin_configuration_store_postal_charges_0` int(10) unsigned NOT NULL DEFAULT '5',
  `admin_configuration_store_postal_charges_0_amount` int(10) unsigned NOT NULL DEFAULT '15',
  `admin_configuration_store_postal_charges_0_weight` int(10) unsigned NOT NULL DEFAULT '100',
  `admin_configuration_store_postal_charges_1` int(10) unsigned NOT NULL DEFAULT '10',
  `admin_configuration_store_postal_charges_1_amount` int(10) unsigned NOT NULL DEFAULT '150',
  `admin_configuration_store_postal_charges_1_weight` int(10) unsigned NOT NULL DEFAULT '300',
  `admin_configuration_store_postal_charges_2` int(10) unsigned NOT NULL DEFAULT '20',
  `admin_configuration_store_postal_charges_2_amount` int(10) unsigned NOT NULL DEFAULT '150',
  `admin_configuration_store_postal_charges_2_weight` int(10) unsigned NOT NULL DEFAULT '1000',
  `admin_configuration_store_postal_charges_3` int(10) unsigned NOT NULL DEFAULT '50',
  `admin_configuration_blog_enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin_configuration_home_show_blog` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `admin_configuration_home_blog_number` int(10) unsigned NOT NULL DEFAULT '10',
  `admin_configuration_sitemap_file` varchar(50) NOT NULL DEFAULT '/sitemap.xml',
  `admin_configuration_creation_date` datetime NOT NULL,
  `admin_configuration_last_update_date` datetime NOT NULL,
  `admin_configuration_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_configuration_id`),
  UNIQUE KEY `admin_configuration_name` (`admin_configuration_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_configuration`
--

INSERT INTO `#DATABASE_PREFIX#admin_configuration` (`admin_configuration_id`, `admin_configuration_active`, `admin_configuration_name`, `admin_configuration_http`, `admin_configuration_site_name`, `admin_configuration_default_theme`, `admin_configuration_administrator_email`, `admin_configuration_manager_email`, `admin_configuration_banner_size`, `admin_configuration_show_lang`, `admin_configuration_home_show_items`, `admin_configuration_home_items_number`, `admin_configuration_copyright`, `admin_configuration_log_database`, `admin_configuration_log_show`, `admin_configuration_log_file`, `admin_configuration_error_database`, `admin_configuration_error_show`, `admin_configuration_error_file`, `admin_configuration_image_full_width`, `admin_configuration_image_full_height`, `admin_configuration_image_medium_width`, `admin_configuration_image_medium_height`, `admin_configuration_image_little_width`, `admin_configuration_image_little_height`, `admin_configuration_image_min_width`, `admin_configuration_image_min_height`, `admin_configuration_image_tmp_prefix`, `admin_configuration_ip_key`, `admin_configuration_simple_register`, `admin_configuration_store_enabled`, `admin_configuration_store_order_delivery_type_default`, `admin_configuration_store_order_status_initial`, `admin_configuration_store_postal_charges_0`, `admin_configuration_store_postal_charges_0_amount`, `admin_configuration_store_postal_charges_0_weight`, `admin_configuration_store_postal_charges_1`, `admin_configuration_store_postal_charges_1_amount`, `admin_configuration_store_postal_charges_1_weight`, `admin_configuration_store_postal_charges_2`, `admin_configuration_store_postal_charges_2_amount`, `admin_configuration_store_postal_charges_2_weight`, `admin_configuration_store_postal_charges_3`, `admin_configuration_blog_enabled`, `admin_configuration_home_show_blog`, `admin_configuration_home_blog_number`, `admin_configuration_sitemap_file`, `admin_configuration_creation_date`, `admin_configuration_last_update_date`, `admin_configuration_last_update_admin_user_id`) VALUES
(0, 1, 'Main', 'http://', 'localhost/demo', 'main', 'benoit.leguern@gmail.com', 'benoit.leguern@gmail.com', 266, 0, 1, 10, 'Graviton C 2014', 1, 0, 1, 1, 0, 1, 2048, 1536, 320, 240, 160, 120, 80, 60, 'tmp_', NULL, 0, 1, 0, 0, 5, 15, 100, 10, 150, 300, 20, 150, 1000, 50, 1, 0, 10, '/sitemap.xml', '2014-04-29 10:26:01', '2014-04-29 10:26:01', 1);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_connection`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_connection` (
  `admin_connection_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_connection_ip_address` varchar(20) NOT NULL,
  `admin_connection_country` varchar(100) DEFAULT NULL,
  `admin_connection_city` varchar(100) DEFAULT NULL,
  `admin_connection_latitude` varchar(50) DEFAULT NULL,
  `admin_connection_longitude` varchar(50) DEFAULT NULL,
  `admin_connection_date` datetime NOT NULL,
  `admin_connection_operating_system` varchar(50) DEFAULT NULL,
  `admin_connection_browser` varchar(200) DEFAULT NULL,
  `admin_connection_browser_version` varchar(20) DEFAULT NULL,
  `admin_connection_javascript` int(1) DEFAULT NULL,
  `admin_connection_java_applets` int(1) DEFAULT NULL,
  `admin_connection_activex_controls` int(1) DEFAULT NULL,
  `admin_connection_cookies` int(1) DEFAULT NULL,
  `admin_connection_css_version` int(1) DEFAULT NULL,
  `admin_connection_frames` int(1) DEFAULT NULL,
  `admin_connection_iframes` int(1) DEFAULT NULL,
  PRIMARY KEY (`admin_connection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_country`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_country` (
  `admin_country_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_country_code` varchar(2) NOT NULL,
  `admin_country_name` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_country_id`),
  UNIQUE KEY `UNIQUE` (`admin_country_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_currency`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_currency` (
  `admin_currency_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_currency_code` varchar(3) NOT NULL,
  `admin_currency_name` varchar(50) NOT NULL,
  `admin_currency_value_vs_euro` float NOT NULL,
  PRIMARY KEY (`admin_currency_id`),
  UNIQUE KEY `admin_currency_code` (`admin_currency_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_currency`
--

INSERT INTO `#DATABASE_PREFIX#admin_currency` (`admin_currency_id`, `admin_currency_code`, `admin_currency_name`, `admin_currency_value_vs_euro`) VALUES
(1, 'EUR', '', 1),
(2, 'USD', '', 0.737122);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_default`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_default` (
  `admin_default_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_default_name` varchar(50) NOT NULL,
  `admin_default_value` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_default_id`),
  UNIQUE KEY `UNIQUE` (`admin_default_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_default`
--

INSERT INTO `#DATABASE_PREFIX#admin_default` (`admin_default_id`, `admin_default_name`, `admin_default_value`) VALUES
(1, 'TMP_IMAGE_ID', '1');

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_error`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_error` (
  `admin_error_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_error_date` datetime NOT NULL,
  `admin_error_admin_connection_id` bigint(20) unsigned NOT NULL,
  `admin_error_admin_user_id` bigint(20) unsigned NOT NULL,
  `admin_error_url` varchar(200) NOT NULL,
  `admin_error_name` varchar(100) NOT NULL,
  `admin_error_description` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`admin_error_id`),
  KEY `admin_error_admin_connection_id` (`admin_error_admin_connection_id`),
  KEY `admin_error_admin_user_id` (`admin_error_admin_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_log`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_log` (
  `admin_log_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_log_date` datetime NOT NULL,
  `admin_log_admin_connection_id` bigint(20) unsigned NOT NULL,
  `admin_log_admin_user_id` bigint(20) unsigned NOT NULL,
  `admin_log_name` varchar(100) DEFAULT NULL,
  `admin_log_description` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`admin_log_id`),
  KEY `admin_log_admin_connection_id` (`admin_log_admin_connection_id`),
  KEY `admin_log_admin_user_id` (`admin_log_admin_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_menu`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_menu` (
  `admin_menu_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_menu_name` varchar(100) NOT NULL,
  `admin_menu_admin_access_id` int(10) unsigned DEFAULT NULL,
  `admin_menu_link` varchar(200) NOT NULL,
  `admin_menu_target` varchar(20) NOT NULL,
  `admin_menu_level_0` int(10) unsigned NOT NULL,
  `admin_menu_level_1` int(10) unsigned NOT NULL,
  `admin_menu_style` varchar(50) NOT NULL,
  `admin_menu_item_type_id` int(10) unsigned DEFAULT NULL,
  `admin_menu_item_type_2_id` int(10) unsigned DEFAULT NULL,
  `admin_menu_image` varchar(50) DEFAULT NULL,
  `admin_menu_creation_date` datetime NOT NULL,
  `admin_menu_last_update_date` datetime NOT NULL,
  `admin_menu_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_menu`
--

INSERT INTO `#DATABASE_PREFIX#admin_menu` (`admin_menu_id`, `admin_menu_name`, `admin_menu_admin_access_id`, `admin_menu_link`, `admin_menu_target`, `admin_menu_level_0`, `admin_menu_level_1`, `admin_menu_style`, `admin_menu_item_type_id`, `admin_menu_item_type_2_id`, `admin_menu_image`, `admin_menu_creation_date`, `admin_menu_last_update_date`, `admin_menu_last_update_admin_user_id`) VALUES
(1, 'MENU_HOME', NULL, 'index.php', '_self', 0, 0, 'menu_home', NULL, NULL, 'home.png', '2012-04-25 05:00:00', '2012-09-12 16:10:37', 0),
(8, 'MENU_CONTACT', NULL, 'contact.php', '_self', 96, 0, 'menu_nolist', NULL, NULL, 'contact.png', '0000-00-00 00:00:00', '2012-11-06 15:16:24', 0),
(9, 'MENU_CONNECTION', NULL, 'login.php', '_self', 98, 0, 'menu_login', NULL, NULL, 'login.png', '0000-00-00 00:00:00', '2012-11-06 15:02:14', 0),
(10, 'MENU_ADMIN', 12, 'admin.php', '_self', 99, 0, 'menu', NULL, NULL, 'admin.png', '0000-00-00 00:00:00', '2012-11-06 15:00:06', 0),
(11, 'MENU_ADMIN_ACCESS', 1, 'admin_access.php', '_self', 99, 1, 'menu', NULL, NULL, 'access.png', '0000-00-00 00:00:00', '2012-11-06 15:00:23', 0),
(12, 'MENU_ADMIN_ERROR', 4, 'admin_error.php', '_self', 99, 2, 'menu', NULL, NULL, 'error.png', '0000-00-00 00:00:00', '2012-11-06 15:00:29', 0),
(13, 'MENU_ADMIN_ITEM', 2, 'admin_item.php', '_self', 99, 3, 'menu', NULL, NULL, 'data.png', '0000-00-00 00:00:00', '2012-11-06 15:00:37', 0),
(14, 'MENU_ADMIN_LOG', 5, 'admin_log.php', '_self', 99, 4, 'menu', NULL, NULL, 'log.png', '0000-00-00 00:00:00', '2012-11-06 15:01:13', 0),
(16, 'MENU_ADMIN_ROLE', 7, 'admin_role.php', '_self', 99, 6, 'menu', NULL, NULL, 'role.png', '0000-00-00 00:00:00', '2012-11-06 15:01:27', 0),
(18, 'MENU_ADMIN_SITE_THEME', 8, 'admin_site_theme.php', '_self', 99, 8, 'menu', NULL, NULL, 'theme.png', '0000-00-00 00:00:00', '2012-11-06 15:01:38', 0),
(19, 'MENU_ADMIN_VERSION', 9, 'admin_version.php', '_self', 99, 9, 'menu', NULL, NULL, 'version.png', '0000-00-00 00:00:00', '2012-11-06 15:01:43', 0),
(20, 'MENU_ADMIN_USER', 10, 'admin_user.php', '_self', 99, 10, 'menu', NULL, NULL, 'users.png', '0000-00-00 00:00:00', '2012-11-06 15:01:51', 0),
(21, 'MENU_ADMIN_MENU', 11, 'admin_menu.php', '_self', 99, 11, 'menu', NULL, NULL, 'menu.png', '0000-00-00 00:00:00', '2012-11-06 15:01:56', 0),
(22, 'MENU_ADMIN_ITEM_TYPE', 3, 'admin_item_type.php', '_self', 99, 12, 'menu', NULL, NULL, 'type.png', '0000-00-00 00:00:00', '2012-11-06 15:02:02', 0),
(23, 'MENU_CONNECTION_ACCOUNT', 13, 'account_update.php', '_self', 98, 1, 'menu', NULL, NULL, 'user.png', '2012-09-12 14:40:13', '2012-11-06 15:01:33', 0),
(25, 'MENU_LINKS', NULL, 'links.php', '_self', 97, 0, 'menu_nolist', NULL, NULL, 'link.png', '2012-11-06 15:16:41', '2012-11-06 15:16:41', 0),
(26, 'MENU_ADMIN_LINKS', 14, 'admin_links.php', '_self', 99, 6, 'menu', NULL, NULL, 'link.png', '2013-05-28 22:16:00', '2013-05-28 22:16:00', 0),
(27, 'MENU_CONNECTION_BASKET', NULL, 'basket.php', '_self', 100, 0, 'menu_basket', NULL, NULL, 'basket.png', '0000-00-00 00:00:00', '2014-01-28 16:52:26', 1),
(28, 'MENU_CONNECTION_ORDER', 16, 'order_list.php', '_self', 98, 3, 'menu', NULL, NULL, 'order.png', '0000-00-00 00:00:00', '2014-01-28 16:52:40', 1),
(29, 'MENU_ADMIN_ITEM_TYPE_2', 3, 'admin_item_type_2.php', '_self', 99, 13, 'menu', NULL, NULL, 'type.png', '0000-00-00 00:00:00', '2012-11-06 15:02:02', 0),
(50, 'MENU_ADMIN_ORDER', 17, 'admin_order.php', '_self', 99, 5, 'menu', NULL, NULL, 'order.png', '2014-02-11 18:06:08', '2014-02-11 18:06:08', 1),
(51, 'MENU_ADMIN_ORDER_STATUS', 20, 'admin_order_status.php', '_self', 99, 6, 'menu', NULL, NULL, 'order.png', '2014-03-20 15:27:08', '2014-03-21 11:17:20', 1),
(52, 'MENU_ADMIN_ITEM_SPECIFIC_BRAND', 21, 'admin_specific.php?table=item_specific_brand', '_self', 99, 14, 'menu', NULL, NULL, 'type.png', '2014-04-09 09:17:52', '2014-04-09 09:21:49', 1),
(53, 'MENU_ADMIN_BLOG', 6, 'admin_blog.php', '_self', 99, 7, 'menu', NULL, NULL, 'blog.png', '2014-04-17 14:41:44', '2014-04-17 14:41:44', 1),
(54, 'MENU_BLOG', NULL, '../blog/index.php', '_self', 95, 0, 'menu_nolist', NULL, NULL, 'blog.png', '2014-04-17 15:02:15', '2014-04-17 15:02:15', 1),
(55, 'MENU_ADMIN_CONFIGURATION', 22, 'admin_configuration.php', '_self', 99, 1, 'menu', NULL, NULL, 'type.png', '2014-04-29 10:21:36', '2014-04-29 10:21:36', 1);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_role`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_role` (
  `admin_role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_role_name` varchar(50) NOT NULL,
  `admin_role_creation_date` datetime NOT NULL,
  `admin_role_last_update_date` datetime NOT NULL,
  `admin_role_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_role_id`),
  UNIQUE KEY `UNIQUE` (`admin_role_name`),
  KEY `admin_role_last_update_admin_user_id` (`admin_role_last_update_admin_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_role`
--

INSERT INTO `#DATABASE_PREFIX#admin_role` (`admin_role_id`, `admin_role_name`, `admin_role_creation_date`, `admin_role_last_update_date`, `admin_role_last_update_admin_user_id`) VALUES
(0, 'Administrator', '2012-09-11 21:25:07', '2014-03-20 15:25:24', 1),
(1, 'Manager', '2012-09-11 21:25:25', '2012-09-12 09:16:55', 0),
(5, 'User', '2014-01-28 16:43:33', '2014-01-28 16:43:33', 1);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_role_access`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_role_access` (
  `admin_role_access_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_role_access_admin_role_id` int(10) unsigned NOT NULL,
  `admin_role_access_admin_access_id` int(10) unsigned NOT NULL,
  `admin_role_access_creation_date` datetime NOT NULL,
  `admin_role_access_last_update_date` datetime NOT NULL,
  `admin_role_access_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_role_access_id`),
  UNIQUE KEY `UNIQUE` (`admin_role_access_admin_role_id`,`admin_role_access_admin_access_id`),
  KEY `admin_role_access_role_id` (`admin_role_access_admin_role_id`),
  KEY `admin_role_access_access_id` (`admin_role_access_admin_access_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_role_access`
--

INSERT INTO `#DATABASE_PREFIX#admin_role_access` (`admin_role_access_id`, `admin_role_access_admin_role_id`, `admin_role_access_admin_access_id`, `admin_role_access_creation_date`, `admin_role_access_last_update_date`, `admin_role_access_last_update_admin_user_id`) VALUES
(19, 0, 12, '2012-09-11 21:25:46', '2012-09-11 21:25:46', 0),
(20, 0, 1, '2012-09-11 21:25:52', '2012-09-11 21:25:52', 0),
(21, 0, 4, '2012-09-11 21:25:57', '2012-09-11 21:25:57', 0),
(22, 0, 2, '2012-09-11 21:26:06', '2012-09-11 21:26:06', 0),
(23, 0, 5, '2012-09-11 21:26:11', '2012-09-11 21:26:11', 0),
(24, 0, 6, '2012-09-11 21:26:16', '2012-09-11 21:26:16', 0),
(25, 0, 3, '2012-09-11 21:26:21', '2012-09-11 21:26:21', 0),
(26, 0, 11, '2012-09-11 21:26:26', '2012-09-11 21:26:26', 0),
(27, 0, 7, '2012-09-11 21:26:30', '2012-09-11 21:26:30', 0),
(28, 0, 8, '2012-09-11 21:26:41', '2012-09-11 21:26:41', 0),
(29, 0, 10, '2012-09-11 21:26:52', '2012-09-11 21:26:52', 0),
(30, 0, 9, '2012-09-11 21:26:59', '2012-09-11 21:26:59', 0),
(31, 1, 12, '2012-09-11 21:27:31', '2012-09-11 21:27:31', 0),
(32, 1, 2, '2012-09-11 21:27:41', '2012-09-11 21:27:41', 0),
(33, 1, 3, '2012-09-11 21:27:47', '2012-09-11 21:27:47', 0),
(34, 1, 6, '2012-09-11 21:27:57', '2012-09-11 21:27:57', 0),
(35, 0, 13, '2012-09-12 14:43:08', '2012-09-12 14:43:08', 0),
(36, 1, 13, '2012-09-12 14:43:26', '2012-09-12 14:43:26', 0),
(37, 0, 14, '2013-05-28 22:14:45', '2013-05-28 22:14:45', 0),
(38, 1, 14, '2013-05-28 22:17:40', '2013-05-28 22:17:40', 0),
(39, 0, 18, '2014-01-28 16:42:35', '2014-01-28 16:42:35', 1),
(40, 0, 17, '2014-01-28 16:42:40', '2014-01-28 16:42:40', 1),
(41, 0, 15, '2014-01-28 16:42:45', '2014-01-28 16:42:45', 1),
(42, 0, 16, '2014-01-28 16:42:49', '2014-01-28 16:42:49', 1),
(44, 1, 18, '2014-01-28 16:43:10', '2014-01-28 16:43:10', 1),
(45, 1, 15, '2014-01-28 16:43:15', '2014-01-28 16:43:15', 1),
(46, 1, 16, '2014-01-28 16:43:20', '2014-01-28 16:43:20', 1),
(47, 5, 15, '2014-01-28 16:43:45', '2014-01-28 16:43:45', 1),
(48, 5, 16, '2014-01-28 16:43:49', '2014-01-28 16:43:49', 1),
(49, 5, 13, '2014-01-28 16:45:05', '2014-01-28 16:45:05', 1),
(50, 0, 19, '2014-01-28 17:05:44', '2014-01-28 17:05:44', 1),
(51, 1, 19, '2014-01-28 17:05:58', '2014-01-28 17:05:58', 1),
(52, 0, 20, '2014-03-20 15:25:08', '2014-03-20 15:25:08', 1),
(53, 0, 21, '2014-04-09 09:15:30', '2014-04-09 09:15:30', 1),
(54, 1, 21, '2014-04-09 09:15:51', '2014-04-09 09:15:51', 1),
(55, 0, 22, '2014-04-22 16:19:04', '2014-04-22 16:19:04', 1);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_site_theme`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_site_theme` (
  `admin_site_theme_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_site_theme_code` varchar(4) NOT NULL,
  `admin_site_theme_name` varchar(50) NOT NULL,
  `admin_site_theme_creation_date` datetime NOT NULL,
  `admin_site_theme_last_update_date` datetime NOT NULL,
  `admin_site_theme_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_site_theme_id`),
  UNIQUE KEY `UNIQUE` (`admin_site_theme_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_site_theme`
--

INSERT INTO `#DATABASE_PREFIX#admin_site_theme` (`admin_site_theme_id`, `admin_site_theme_code`, `admin_site_theme_name`, `admin_site_theme_creation_date`, `admin_site_theme_last_update_date`, `admin_site_theme_last_update_admin_user_id`) VALUES
(0, 'main', 'Main theme', '2012-09-11 21:37:00', '2014-03-20 10:38:30', 1),
(1, 'new', 'New theme', '2014-03-10 15:38:46', '2014-03-10 15:38:46', 1),
(2, 'gree', 'Green theme', '2014-03-10 16:09:54', '2014-03-10 16:10:03', 1),
(3, 'grey', 'Grey theme', '2014-03-10 16:35:03', '2014-03-10 16:35:03', 1),
(4, 'pink', 'Pink theme', '2014-03-10 22:07:45', '2014-03-10 22:07:45', 1);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_specific_table_list`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_specific_table_list` (
  `admin_specific_table_list_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admin_specific_table_list_table_name` varchar(50) NOT NULL,
  `admin_specific_table_list_number` int(10) unsigned NOT NULL,
  `admin_specific_table_list_header_name` varchar(50) NOT NULL,
  `admin_specific_table_list_database_column_id` int(10) unsigned NOT NULL,
  `admin_specific_table_list_align` varchar(20) NOT NULL,
  `admin_specific_table_list_format` varchar(20) NOT NULL,
  `admin_specific_table_list_order` int(10) unsigned NOT NULL,
  `admin_specific_table_list_database_link_id` int(10) unsigned DEFAULT NULL,
  `admin_specific_table_list_link` varchar(300) DEFAULT NULL,
  `admin_specific_table_list_link_target` varchar(20) DEFAULT NULL,
  `admin_specific_table_list_creation_date` datetime NOT NULL,
  `admin_specific_table_list_last_update_date` datetime NOT NULL,
  `admin_specific_table_list_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_specific_table_list_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_specific_table_list`
--

INSERT INTO `#DATABASE_PREFIX#admin_specific_table_list` (`admin_specific_table_list_id`, `admin_specific_table_list_table_name`, `admin_specific_table_list_number`, `admin_specific_table_list_header_name`, `admin_specific_table_list_database_column_id`, `admin_specific_table_list_align`, `admin_specific_table_list_format`, `admin_specific_table_list_order`, `admin_specific_table_list_database_link_id`, `admin_specific_table_list_link`, `admin_specific_table_list_link_target`, `admin_specific_table_list_creation_date`, `admin_specific_table_list_last_update_date`, `admin_specific_table_list_last_update_admin_user_id`) VALUES
(1, 'item_specific_brand', 0, 'ITEM_SPECIFIC_BRAND_NAME', 1, 'left', 'text', 1, 0, 'admin_specific_update.php', '_self', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 'item_specific_brand', 1, 'LAST_UPDATE_DATE', 3, 'center', 'date', 1, NULL, NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_specific_table_selection`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_specific_table_selection` (
  `admin_specific_table_selection_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_specific_table_selection_table_name` varchar(50) NOT NULL,
  `admin_specific_table_selection_table_select` varchar(2000) NOT NULL,
  `admin_specific_table_selection_default_order` int(10) unsigned NOT NULL,
  `admin_specific_table_selection_default_sort` varchar(5) NOT NULL,
  `admin_specific_table_selection_creation_date` datetime NOT NULL,
  `admin_specific_table_selection_last_update_date` datetime NOT NULL,
  `admin_specific_table_selection_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_specific_table_selection_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_specific_table_selection`
--

INSERT INTO `#DATABASE_PREFIX#admin_specific_table_selection` (`admin_specific_table_selection_id`, `admin_specific_table_selection_table_name`, `admin_specific_table_selection_table_select`, `admin_specific_table_selection_default_order`, `admin_specific_table_selection_default_sort`, `admin_specific_table_selection_creation_date`, `admin_specific_table_selection_last_update_date`, `admin_specific_table_selection_last_update_admin_user_id`) VALUES
(1, 'item_specific_brand', 'SELECT store_item_specific_brand.item_specific_brand_id, store_item_specific_brand.item_specific_brand_name, store_admin_user.admin_user_login, store_item_specific_brand.item_specific_brand_last_update_date FROM store_item_specific_brand LEFT OUTER JOIN store_admin_user ON store_admin_user.admin_user_id = store_item_specific_brand.item_specific_brand_last_update_admin_user_id ORDER BY', 2, 'ASC', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_user`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_user` (
  `admin_user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_user_admin_role_id` int(10) unsigned NOT NULL,
  `admin_user_active` tinyint(1) unsigned NOT NULL,
  `admin_user_login` varchar(30) NOT NULL,
  `admin_user_password` varchar(30) NOT NULL,
  `admin_user_email` varchar(100) NOT NULL,
  `admin_user_first_name` varchar(50) DEFAULT NULL,
  `admin_user_last_name` varchar(50) DEFAULT NULL,
  `admin_user_phone` varchar(20) DEFAULT NULL,
  `admin_user_creation_date` datetime NOT NULL,
  `admin_user_last_update_date` datetime NOT NULL,
  `admin_user_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  `admin_user_last_admin_connection_id` int(10) unsigned DEFAULT NULL,
  `admin_user_lang` varchar(2) DEFAULT NULL,
  `admin_user_admin_site_theme_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`admin_user_id`),
  UNIQUE KEY `UNIQUE_1` (`admin_user_login`),
  UNIQUE KEY `UNIQUE_2` (`admin_user_email`),
  KEY `admin_user_admin_role_id` (`admin_user_admin_role_id`),
  KEY `admin_user_last_update_user_id` (`admin_user_last_update_admin_user_id`),
  KEY `admin_user_last_admin_connection_id` (`admin_user_last_admin_connection_id`),
  KEY `admin_user_admin_site_theme_id` (`admin_user_admin_site_theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_user`
--

INSERT INTO `#DATABASE_PREFIX#admin_user` (`admin_user_id`, `admin_user_admin_role_id`, `admin_user_active`, `admin_user_login`, `admin_user_password`, `admin_user_email`, `admin_user_first_name`, `admin_user_last_name`, `admin_user_phone`, `admin_user_creation_date`, `admin_user_last_update_date`, `admin_user_last_update_admin_user_id`, `admin_user_last_admin_connection_id`, `admin_user_lang`, `admin_user_admin_site_theme_id`) VALUES
(1, 0, 1, 'admin', 'ArNdPA9.iQMz6', 'benoit.leguern@gmail.com', NULL, NULL, NULL, '2012-09-11 21:29:22', '2014-04-04 14:57:47', 1, NULL, 'FR', 2);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_user_address`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_user_address` (
  `admin_user_address_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `admin_user_address_admin_user_id` bigint(20) unsigned NOT NULL,
  `admin_user_address_line_1` varchar(50) DEFAULT NULL,
  `admin_user_address_line_2` varchar(50) DEFAULT NULL,
  `admin_user_address_line_3` varchar(50) DEFAULT NULL,
  `admin_user_address_postal_code` varchar(20) DEFAULT NULL,
  `admin_user_address_city` varchar(100) DEFAULT NULL,
  `admin_user_address_region` varchar(100) DEFAULT NULL,
  `admin_user_address_country` varchar(100) DEFAULT NULL,
  `admin_user_address_creation_date` datetime NOT NULL,
  `admin_user_address_last_update_date` datetime NOT NULL,
  `admin_user_address_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_user_address_id`),
  UNIQUE KEY `admin_user_address_admin_user__2` (`admin_user_address_admin_user_id`),
  KEY `admin_user_address_admin_user_id` (`admin_user_address_admin_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_value`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_value` (
  `admin_value_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_value_name` varchar(50) NOT NULL,
  `admin_value_value` varchar(50) NOT NULL,
  PRIMARY KEY (`admin_value_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `#DATABASE_PREFIX#admin_value`
--

INSERT INTO `#DATABASE_PREFIX#admin_value` (`admin_value_id`, `admin_value_name`, `admin_value_value`) VALUES
(1, 'TEXT_LANG', 'FR'),
(2, 'TEXT_LANG', 'EN'),
(3, 'TEXT_LANG', 'DE');

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#admin_version`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#admin_version` (
  `admin_version_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_version_admin_user_id` bigint(20) unsigned NOT NULL,
  `admin_version_date` datetime NOT NULL,
  `admin_version_number` varchar(10) NOT NULL,
  `admin_version_name` varchar(50) DEFAULT NULL,
  `admin_version_description` varchar(4000) DEFAULT NULL,
  `admin_version_creation_date` datetime NOT NULL,
  `admin_version_last_update_date` datetime NOT NULL,
  `admin_version_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`admin_version_id`),
  UNIQUE KEY `admin_version_number` (`admin_version_number`),
  KEY `admin_version_admin_user_id` (`admin_version_admin_user_id`),
  KEY `admin_version_last_update_admin_user_id` (`admin_version_last_update_admin_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#blog`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#blog` (
  `blog_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_active` tinyint(1) unsigned NOT NULL,
  `blog_image_number` int(10) unsigned DEFAULT NULL,
  `blog_image_type` varchar(20) DEFAULT NULL,
  `blog_creation_date` datetime NOT NULL,
  `blog_last_update_date` datetime NOT NULL,
  `blog_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  `blog_hit` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`blog_id`),
  UNIQUE KEY `UNIQUE` (`blog_image_number`),
  KEY `item_active` (`blog_active`),
  KEY `item_last_update_admin_user_id` (`blog_last_update_admin_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#blog_text`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#blog_text` (
  `blog_text_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_text_blog_id` bigint(20) unsigned NOT NULL,
  `blog_text_lang` varchar(2) NOT NULL,
  `blog_text_title` varchar(300) NOT NULL,
  `blog_text_value` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`blog_text_id`),
  UNIQUE KEY `UNIQUE` (`blog_text_blog_id`,`blog_text_lang`),
  KEY `item_id` (`blog_text_blog_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#blog_image`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#blog_image` (
  `blog_image_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_image_blog_id` bigint(20) unsigned NOT NULL,
  `blog_image_number` int(10) unsigned NOT NULL,
  `blog_image_top` int(1) unsigned NOT NULL,
  `blog_image_type` varchar(20) NOT NULL,
  `blog_image_creation_date` datetime NOT NULL,
  `blog_image_last_update_date` datetime NOT NULL,
  `blog_image_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`blog_image_id`),
  UNIQUE KEY `UNIQUE` (`blog_image_blog_id`,`blog_image_number`),
  KEY `blog_id` (`blog_image_blog_id`),
  KEY `blog_image_number` (`blog_image_number`),
  KEY `blog_image_last_update_admin_user_id` (`blog_image_last_update_admin_user_id`),
  KEY `blog_image_top` (`blog_image_top`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#item`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#item` (
  `item_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_item_type_id` int(10) unsigned NOT NULL,
  `item_item_type_2_id` int(10) unsigned DEFAULT NULL,
  `item_active` tinyint(1) unsigned NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_creation_date` datetime NOT NULL,
  `item_last_update_date` datetime NOT NULL,
  `item_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  `item_hit` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `UNIQUE` (`item_name`),
  KEY `item_type_id` (`item_item_type_id`),
  KEY `item_active` (`item_active`),
  KEY `item_last_update_admin_user_id` (`item_last_update_admin_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#item_image`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#item_image` (
  `item_image_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_image_item_id` bigint(20) unsigned NOT NULL,
  `item_image_number` int(10) unsigned NOT NULL,
  `item_image_top` int(1) unsigned NOT NULL,
  `item_image_type` varchar(20) NOT NULL,
  `item_image_creation_date` datetime NOT NULL,
  `item_image_last_update_date` datetime NOT NULL,
  `item_image_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`item_image_id`),
  UNIQUE KEY `UNIQUE` (`item_image_item_id`,`item_image_number`),
  KEY `item_id` (`item_image_item_id`),
  KEY `item_image_number` (`item_image_number`),
  KEY `item_image_last_update_admin_user_id` (`item_image_last_update_admin_user_id`),
  KEY `item_image_top` (`item_image_top`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#item_specific`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#item_specific` (
  `item_specific_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_specific_item_id` bigint(20) unsigned NOT NULL,
  `item_specific_item_specific_brand_id` bigint(20) unsigned DEFAULT NULL,
  `item_specific_price` float unsigned DEFAULT NULL,
  `item_specific_weight` int(10) unsigned DEFAULT NULL,
  `item_specific_admin_currency_id` int(10) unsigned DEFAULT NULL,
  `item_specific_creation_date` datetime NOT NULL,
  `item_specific_last_update_date` datetime NOT NULL,
  `item_specific_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`item_specific_id`),
  UNIQUE KEY `item_specific_item_id` (`item_specific_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#item_specific_brand`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#item_specific_brand` (
  `item_specific_brand_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_specific_brand_name` varchar(50) NOT NULL,
  `item_specific_brand_logo_filename` varchar(100) DEFAULT NULL,
  `item_specific_brand_web_site_url` varchar(200) DEFAULT NULL,
  `item_specific_brand_creation_date` datetime NOT NULL,
  `item_specific_brand_last_update_date` datetime NOT NULL,
  `item_specific_brand_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`item_specific_brand_id`),
  UNIQUE KEY `item_specific_brand_name` (`item_specific_brand_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#item_text`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#item_text` (
  `item_text_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_text_item_id` bigint(20) unsigned NOT NULL,
  `item_text_lang` varchar(2) NOT NULL,
  `item_text_value` varchar(10000) NOT NULL,
  PRIMARY KEY (`item_text_id`),
  UNIQUE KEY `UNIQUE` (`item_text_item_id`,`item_text_lang`),
  KEY `item_id` (`item_text_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#item_type`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#item_type` (
  `item_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_type_name` varchar(50) NOT NULL,
  `item_type_creation_date` datetime NOT NULL,
  `item_type_last_update_date` datetime NOT NULL,
  `item_type_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`item_type_id`),
  UNIQUE KEY `UNIQUE` (`item_type_name`),
  KEY `item_type_last_update_admin_user_id` (`item_type_last_update_admin_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#item_type_2`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#item_type_2` (
  `item_type_2_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_type_2_name` varchar(50) NOT NULL,
  `item_type_2_creation_date` datetime NOT NULL,
  `item_type_2_last_update_date` datetime NOT NULL,
  `item_type_2_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`item_type_2_id`),
  UNIQUE KEY `UNIQUE` (`item_type_2_name`),
  KEY `item_type_2_last_update_admin_user_id` (`item_type_2_last_update_admin_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#links`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#links` (
  `links_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `links_active` tinyint(1) unsigned NOT NULL,
  `links_link` varchar(500) NOT NULL,
  `links_title` varchar(300) NOT NULL,
  `links_image_number` int(10) unsigned DEFAULT NULL,
  `links_image_type` varchar(20) DEFAULT NULL,
  `links_creation_date` datetime NOT NULL,
  `links_last_update_date` datetime NOT NULL,
  `links_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  `links_hit` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`links_id`),
  UNIQUE KEY `UNIQUE` (`links_image_number`),
  KEY `links_active` (`links_active`),
  KEY `links_last_update_admin_user_id` (`links_last_update_admin_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#links_text`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#links_text` (
  `links_text_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `links_text_links_id` bigint(20) unsigned NOT NULL,
  `links_text_lang` varchar(2) NOT NULL,
  `links_text_value` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`links_text_id`),
  UNIQUE KEY `UNIQUE` (`links_text_links_id`,`links_text_lang`),
  KEY `links_id` (`links_text_links_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#store_basket`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#store_basket` (
  `store_basket_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_basket_admin_connection_id` bigint(20) unsigned NOT NULL,
  `store_basket_item_id` bigint(20) unsigned NOT NULL,
  `store_basket_quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`store_basket_id`),
  UNIQUE KEY `store_basket_admin_connection_id` (`store_basket_admin_connection_id`,`store_basket_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#store_inventory`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#store_inventory` (
  `store_inventory_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_inventory_item_id` bigint(20) unsigned NOT NULL,
  `store_inventory_count` int(10) unsigned NOT NULL,
  `store_inventory_creation_date` datetime NOT NULL,
  `store_inventory_last_update_date` datetime NOT NULL,
  `store_inventory_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`store_inventory_id`),
  UNIQUE KEY `UNIQUE` (`store_inventory_item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#store_order`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#store_order` (
  `store_order_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_order_admin_user_id` bigint(20) unsigned NOT NULL,
  `store_order_store_order_status_id` int(10) unsigned NOT NULL,
  `store_order_store_order_delivery_type_id` int(10) unsigned NOT NULL,
  `store_order_discount` float NOT NULL,
  `store_order_delivery_price` float NOT NULL,
  `store_order_creation_date` datetime NOT NULL,
  `store_order_last_update_date` datetime NOT NULL,
  `store_order_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`store_order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#store_order_delivery_type`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#store_order_delivery_type` (
  `store_order_delivery_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_order_delivery_type_name` varchar(50) NOT NULL,
  `store_order_delivery_type_creation_date` datetime NOT NULL,
  `store_order_delivery_type_last_update_date` datetime NOT NULL,
  `store_order_delivery_type_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`store_order_delivery_type_id`),
  UNIQUE KEY `UNIQUE` (`store_order_delivery_type_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `#DATABASE_PREFIX#store_order_delivery_type`
--

INSERT INTO `#DATABASE_PREFIX#store_order_delivery_type` (`store_order_delivery_type_id`, `store_order_delivery_type_name`, `store_order_delivery_type_creation_date`, `store_order_delivery_type_last_update_date`, `store_order_delivery_type_last_update_admin_user_id`) VALUES
(0, 'ORDER_DELIVERY_TYPE_HAND_OVER', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(1, 'ORDER_DELIVERY_TYPE_POST', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#store_order_line`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#store_order_line` (
  `store_order_line_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `store_order_line_store_order_id` bigint(20) unsigned NOT NULL,
  `store_order_line_number` int(10) unsigned NOT NULL,
  `store_order_line_item_id` bigint(20) unsigned NOT NULL,
  `store_order_line_quantity` int(10) unsigned NOT NULL,
  PRIMARY KEY (`store_order_line_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#store_order_status`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#store_order_status` (
  `store_order_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_order_status_name` varchar(50) NOT NULL,
  `store_order_status_active` int(1) unsigned NOT NULL DEFAULT '1',
  `store_order_status_inventory_reserve` int(1) unsigned NOT NULL DEFAULT '0',
  `store_order_status_inventory_cleanup` int(1) unsigned NOT NULL DEFAULT '0',
  `store_order_status_lock` int(1) unsigned DEFAULT '0',
  `store_order_status_other_possible_status` varchar(20) DEFAULT NULL,
  `store_order_status_creation_date` datetime NOT NULL,
  `store_order_status_last_update_date` datetime NOT NULL,
  `store_order_status_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`store_order_status_id`),
  UNIQUE KEY `UNIQUE` (`store_order_status_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Contenu de la table `#DATABASE_PREFIX#store_order_status`
--

INSERT INTO `#DATABASE_PREFIX#store_order_status` (`store_order_status_id`, `store_order_status_name`, `store_order_status_active`, `store_order_status_inventory_reserve`, `store_order_status_inventory_cleanup`, `store_order_status_lock`, `store_order_status_other_possible_status`, `store_order_status_creation_date`, `store_order_status_last_update_date`, `store_order_status_last_update_admin_user_id`) VALUES
(0, 'ORDER_STATUS_CREATED', 1, 1, 0, 0, '1,2', '0000-00-00 00:00:00', '2014-03-21 09:31:22', 1),
(1, 'ORDER_STATUS_VALIDATED', 1, 0, 0, 0, '2,3', '0000-00-00 00:00:00', '2014-03-21 09:18:13', 1),
(2, 'ORDER_STATUS_CANCELLED', 1, 0, 1, 1, NULL, '0000-00-00 00:00:00', '2014-03-21 09:31:08', 1),
(3, 'ORDER_STATUS_PENDING_PAYMENT', 1, 0, 0, 0, '2,4,5', '0000-00-00 00:00:00', '2014-03-21 09:17:50', 1),
(4, 'ORDER_STATUS_DELIVERING', 1, 0, 0, 0, '2,5', '0000-00-00 00:00:00', '2014-03-21 09:17:37', 1),
(5, 'ORDER_STATUS_DELIVERED', 1, 0, 0, 0, '2,6', '0000-00-00 00:00:00', '2014-03-21 09:17:23', 1),
(6, 'ORDER_STATUS_CLOSED', 1, 0, 0, 1, NULL, '0000-00-00 00:00:00', '2014-03-21 09:17:11', 1);

-- --------------------------------------------------------

--
-- Structure de la table `#DATABASE_PREFIX#store_order_text`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#store_order_text` (
  `store_order_text_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_order_text_store_order_id` bigint(20) unsigned NOT NULL,
  `store_order_text_value` varchar(10000) DEFAULT NULL,
  `store_order_text_creation_date` datetime NOT NULL,
  `store_order_text_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`store_order_text_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



--
-- Structure de la table `#DATABASE_PREFIX#tag`
--

CREATE TABLE IF NOT EXISTS `#DATABASE_PREFIX#tag` (
  `tag_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag_type` varchar(20) NOT NULL,
  `tag_object_id` bigint(20) unsigned NOT NULL,
  `tag_text` varchar(50) NOT NULL,
  `tag_creation_date` datetime NOT NULL,
  `tag_last_update_date` datetime NOT NULL,
  `tag_last_update_admin_user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`tag_id`),
  UNIQUE KEY `tag_type` (`tag_type`,`tag_object_id`,`tag_text`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
