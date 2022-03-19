-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 25, 2022 at 10:31 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nestforneedyfoundation`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_commentmeta`
--

DROP TABLE IF EXISTS `wp_commentmeta`;
CREATE TABLE IF NOT EXISTS `wp_commentmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_comments`
--

DROP TABLE IF EXISTS `wp_comments`;
CREATE TABLE IF NOT EXISTS `wp_comments` (
  `comment_ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `comment_author` tinytext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_author_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'comment',
  `comment_parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`,`comment_date_gmt`),
  KEY `comment_date_gmt` (`comment_date_gmt`),
  KEY `comment_parent` (`comment_parent`),
  KEY `comment_author_email` (`comment_author_email`(10))
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_comments`
--

INSERT INTO `wp_comments` (`comment_ID`, `comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES
(1, 1, 'A WordPress Commenter', 'wapuu@wordpress.example', 'https://wordpress.org/', '', '2021-11-28 10:37:06', '2021-11-28 10:37:06', 'Hi, this is a comment.\nTo get started with moderating, editing, and deleting comments, please visit the Comments screen in the dashboard.\nCommenter avatars come from <a href=\"https://gravatar.com\">Gravatar</a>.', 0, '1', '', 'comment', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_links`
--

DROP TABLE IF EXISTS `wp_links`;
CREATE TABLE IF NOT EXISTS `wp_links` (
  `link_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_image` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_target` varchar(25) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_visible` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'Y',
  `link_owner` bigint(20) UNSIGNED NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link_rel` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `link_notes` mediumtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `link_rss` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_visible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_options`
--

DROP TABLE IF EXISTS `wp_options`;
CREATE TABLE IF NOT EXISTS `wp_options` (
  `option_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `option_value` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `autoload` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`),
  KEY `autoload` (`autoload`)
) ENGINE=MyISAM AUTO_INCREMENT=229 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_postmeta`
--

DROP TABLE IF EXISTS `wp_postmeta`;
CREATE TABLE IF NOT EXISTS `wp_postmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_postmeta`
--

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES
(1, 2, '_wp_page_template', 'default'),
(2, 3, '_wp_page_template', 'default'),
(5, 6, '_wp_attached_file', '2021/11/e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg'),
(6, 6, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:500;s:6:\"height\";i:500;s:4:\"file\";s:48:\"2021/11/e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg\";s:5:\"sizes\";a:3:{s:6:\"medium\";a:4:{s:4:\"file\";s:48:\"e6386e45-d262-4bee-a8b6-39f0a1c1cbc5-300x300.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:48:\"e6386e45-d262-4bee-a8b6-39f0a1c1cbc5-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:37:\"ngo-charity-donation-thumbnail-avatar\";a:4:{s:4:\"file\";s:48:\"e6386e45-d262-4bee-a8b6-39f0a1c1cbc5-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(7, 7, '_wp_attached_file', '2021/11/cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg'),
(8, 7, '_wp_attachment_context', 'custom-logo'),
(9, 7, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:250;s:6:\"height\";i:250;s:4:\"file\";s:56:\"2021/11/cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg\";s:5:\"sizes\";a:2:{s:9:\"thumbnail\";a:4:{s:4:\"file\";s:56:\"cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:37:\"ngo-charity-donation-thumbnail-avatar\";a:4:{s:4:\"file\";s:56:\"cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5-100x100.jpg\";s:5:\"width\";i:100;s:6:\"height\";i:100;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(10, 8, '_edit_lock', '1638096809:1'),
(11, 8, '_customize_restore_dismissed', '1'),
(12, 9, '_menu_item_type', 'custom'),
(13, 9, '_menu_item_menu_item_parent', '0'),
(14, 9, '_menu_item_object_id', '9'),
(15, 9, '_menu_item_object', 'custom'),
(16, 9, '_menu_item_target', ''),
(17, 9, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(18, 9, '_menu_item_xfn', ''),
(19, 9, '_menu_item_url', 'http://localhost/nestforneedyfoundation/'),
(30, 2, '_edit_lock', '1638103427:1'),
(21, 10, '_menu_item_type', 'post_type'),
(22, 10, '_menu_item_menu_item_parent', '0'),
(23, 10, '_menu_item_object_id', '2'),
(24, 10, '_menu_item_object', 'page'),
(25, 10, '_menu_item_target', ''),
(26, 10, '_menu_item_classes', 'a:1:{i:0;s:0:\"\";}'),
(27, 10, '_menu_item_xfn', ''),
(28, 10, '_menu_item_url', ''),
(29, 10, '_menu_item_orphaned', '1638097769'),
(31, 13, '_wp_attached_file', '2021/11/cropped-cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg'),
(32, 13, '_wp_attachment_context', 'custom-logo'),
(33, 13, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:150;s:6:\"height\";i:124;s:4:\"file\";s:64:\"2021/11/cropped-cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg\";s:5:\"sizes\";a:0:{}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(34, 14, '_edit_lock', '1638098921:1'),
(35, 14, '_wp_trash_meta_status', 'publish'),
(36, 14, '_wp_trash_meta_time', '1638098943'),
(37, 15, '_wp_attached_file', '2021/11/donatenowbg.jpg'),
(38, 15, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:1400;s:6:\"height\";i:444;s:4:\"file\";s:23:\"2021/11/donatenowbg.jpg\";s:5:\"sizes\";a:4:{s:6:\"medium\";a:4:{s:4:\"file\";s:22:\"donatenowbg-300x95.jpg\";s:5:\"width\";i:300;s:6:\"height\";i:95;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:5:\"large\";a:4:{s:4:\"file\";s:24:\"donatenowbg-1024x325.jpg\";s:5:\"width\";i:1024;s:6:\"height\";i:325;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:23:\"donatenowbg-150x150.jpg\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:10:\"image/jpeg\";}s:12:\"medium_large\";a:4:{s:4:\"file\";s:23:\"donatenowbg-768x244.jpg\";s:5:\"width\";i:768;s:6:\"height\";i:244;s:9:\"mime-type\";s:10:\"image/jpeg\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(39, 15, '_wp_attachment_is_custom_background', 'charity-help-lite'),
(40, 16, '_wp_trash_meta_status', 'publish'),
(41, 16, '_wp_trash_meta_time', '1638099836'),
(42, 17, '_edit_lock', '1638099937:1'),
(43, 17, '_wp_trash_meta_status', 'publish'),
(44, 17, '_wp_trash_meta_time', '1638099941'),
(50, 18, '_customize_restore_dismissed', '1'),
(46, 19, '_customize_draft_post_name', 'home'),
(47, 19, '_customize_changeset_uuid', '68cb4c4c-77a7-4818-87f1-e02c786ad4a3'),
(48, 20, '_customize_draft_post_name', 'home'),
(49, 20, '_customize_changeset_uuid', '68cb4c4c-77a7-4818-87f1-e02c786ad4a3'),
(51, 21, '_wp_attached_file', '2021/11/e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark.png'),
(52, 21, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:500;s:6:\"height\";i:500;s:4:\"file\";s:59:\"2021/11/e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:59:\"e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark-300x300.png\";s:5:\"width\";i:300;s:6:\"height\";i:300;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:59:\"e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(53, 22, '_wp_attached_file', '2021/11/cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark.png'),
(54, 22, '_wp_attachment_context', 'custom-logo'),
(55, 22, '_wp_attachment_metadata', 'a:5:{s:5:\"width\";i:500;s:6:\"height\";i:387;s:4:\"file\";s:67:\"2021/11/cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark.png\";s:5:\"sizes\";a:2:{s:6:\"medium\";a:4:{s:4:\"file\";s:67:\"cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark-300x232.png\";s:5:\"width\";i:300;s:6:\"height\";i:232;s:9:\"mime-type\";s:9:\"image/png\";}s:9:\"thumbnail\";a:4:{s:4:\"file\";s:67:\"cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark-150x150.png\";s:5:\"width\";i:150;s:6:\"height\";i:150;s:9:\"mime-type\";s:9:\"image/png\";}}s:10:\"image_meta\";a:12:{s:8:\"aperture\";s:1:\"0\";s:6:\"credit\";s:0:\"\";s:6:\"camera\";s:0:\"\";s:7:\"caption\";s:0:\"\";s:17:\"created_timestamp\";s:1:\"0\";s:9:\"copyright\";s:0:\"\";s:12:\"focal_length\";s:1:\"0\";s:3:\"iso\";s:1:\"0\";s:13:\"shutter_speed\";s:1:\"0\";s:5:\"title\";s:0:\"\";s:11:\"orientation\";s:1:\"0\";s:8:\"keywords\";a:0:{}}}'),
(56, 23, '_wp_trash_meta_status', 'publish'),
(57, 23, '_wp_trash_meta_time', '1638104339'),
(58, 24, '_wp_trash_meta_status', 'publish'),
(59, 24, '_wp_trash_meta_time', '1638104419'),
(60, 25, '_edit_lock', '1638105559:1'),
(61, 25, '_edit_last', '1'),
(62, 25, 'sine-sidebar-position', 'customizer'),
(63, 25, 'sine-disable-inner-banner', ''),
(64, 25, 'sine-disable-footer-widget', '');

-- --------------------------------------------------------

--
-- Table structure for table `wp_posts`
--

DROP TABLE IF EXISTS `wp_posts`;
CREATE TABLE IF NOT EXISTS `wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_date_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_title` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_excerpt` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'publish',
  `comment_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `ping_status` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'open',
  `post_password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `post_name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `to_ping` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `pinged` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_modified_gmt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `post_parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `guid` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `post_type` varchar(20) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'post',
  `post_mime_type` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `post_name` (`post_name`(191)),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_posts`
--

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES
(1, 1, '2021-11-28 10:37:06', '2021-11-28 10:37:06', '<!-- wp:paragraph -->\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n<!-- /wp:paragraph -->', 'Hello world!', '', 'publish', 'open', 'open', '', 'hello-world', '', '', '2021-11-28 10:37:06', '2021-11-28 10:37:06', '', 0, 'http://localhost/nestforneedyfoundation/?p=1', 0, 'post', '', 1),
(2, 1, '2021-11-28 10:37:06', '2021-11-28 10:37:06', '<!-- wp:paragraph -->\n<p>To provide feasible solutions to enhance overall health across the life span through a multidisciplinary approach. To render exceptional care, hope and support to individuals to help them develop and utilize their potential. To become a Centre of Excellence training center in the field of mental health, gerontology, deaddiction, community development, women and child issues, policy framing and research.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p></p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'Mission', '', 'publish', 'closed', 'open', '', 'sample-page', '', '', '2021-11-28 11:25:35', '2021-11-28 11:25:35', '', 0, 'http://localhost/nestforneedyfoundation/?page_id=2', 0, 'page', '', 0),
(12, 1, '2021-11-28 11:25:35', '2021-11-28 11:25:35', '<!-- wp:paragraph -->\n<p>To provide feasible solutions to enhance overall health across the life span through a multidisciplinary approach. To render exceptional care, hope and support to individuals to help them develop and utilize their potential. To become a Centre of Excellence training center in the field of mental health, gerontology, deaddiction, community development, women and child issues, policy framing and research.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><p></p></blockquote>\n<!-- /wp:quote -->\n\n<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->', 'Mission', '', 'inherit', 'closed', 'closed', '', '2-revision-v1', '', '', '2021-11-28 11:25:35', '2021-11-28 11:25:35', '', 2, 'http://localhost/nestforneedyfoundation/?p=12', 0, 'revision', '', 0),
(3, 1, '2021-11-28 10:37:06', '2021-11-28 10:37:06', '<!-- wp:heading --><h2>Who we are</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Our website address is: http://localhost/nestforneedyfoundation.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Comments</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>When visitors leave comments on the site we collect the data shown in the comments form, and also the visitor&#8217;s IP address and browser user agent string to help spam detection.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>An anonymized string created from your email address (also called a hash) may be provided to the Gravatar service to see if you are using it. The Gravatar service privacy policy is available here: https://automattic.com/privacy/. After approval of your comment, your profile picture is visible to the public in the context of your comment.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Media</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you upload images to the website, you should avoid uploading images with embedded location data (EXIF GPS) included. Visitors to the website can download and extract any location data from images on the website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Cookies</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment on our site you may opt-in to saving your name, email address and website in cookies. These are for your convenience so that you do not have to fill in your details again when you leave another comment. These cookies will last for one year.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you visit our login page, we will set a temporary cookie to determine if your browser accepts cookies. This cookie contains no personal data and is discarded when you close your browser.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>When you log in, we will also set up several cookies to save your login information and your screen display choices. Login cookies last for two days, and screen options cookies last for a year. If you select &quot;Remember Me&quot;, your login will persist for two weeks. If you log out of your account, the login cookies will be removed.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>If you edit or publish an article, an additional cookie will be saved in your browser. This cookie includes no personal data and simply indicates the post ID of the article you just edited. It expires after 1 day.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Embedded content from other websites</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Articles on this site may include embedded content (e.g. videos, images, articles, etc.). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>These websites may collect data about you, use cookies, embed additional third-party tracking, and monitor your interaction with that embedded content, including tracking your interaction with the embedded content if you have an account and are logged in to that website.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Who we share your data with</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you request a password reset, your IP address will be included in the reset email.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>How long we retain your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you leave a comment, the comment and its metadata are retained indefinitely. This is so we can recognize and approve any follow-up comments automatically instead of holding them in a moderation queue.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>For users that register on our website (if any), we also store the personal information they provide in their user profile. All users can see, edit, or delete their personal information at any time (except they cannot change their username). Website administrators can also see and edit that information.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>What rights you have over your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>If you have an account on this site, or have left comments, you can request to receive an exported file of the personal data we hold about you, including any data you have provided to us. You can also request that we erase any personal data we hold about you. This does not include any data we are obliged to keep for administrative, legal, or security purposes.</p><!-- /wp:paragraph --><!-- wp:heading --><h2>Where we send your data</h2><!-- /wp:heading --><!-- wp:paragraph --><p><strong class=\"privacy-policy-tutorial\">Suggested text: </strong>Visitor comments may be checked through an automated spam detection service.</p><!-- /wp:paragraph -->', 'Privacy Policy', '', 'draft', 'closed', 'open', '', 'privacy-policy', '', '', '2021-11-28 10:37:06', '2021-11-28 10:37:06', '', 0, 'http://localhost/nestforneedyfoundation/?page_id=3', 0, 'page', '', 0),
(4, 1, '2021-11-28 10:38:39', '0000-00-00 00:00:00', '', 'Auto Draft', '', 'auto-draft', 'open', 'open', '', '', '', '', '2021-11-28 10:38:39', '0000-00-00 00:00:00', '', 0, 'http://localhost/nestforneedyfoundation/?p=4', 0, 'post', '', 0),
(6, 1, '2021-11-28 10:51:38', '2021-11-28 10:51:38', '', 'e6386e45-d262-4bee-a8b6-39f0a1c1cbc5', '', 'inherit', 'open', 'closed', '', 'e6386e45-d262-4bee-a8b6-39f0a1c1cbc5', '', '', '2021-11-28 10:51:38', '2021-11-28 10:51:38', '', 0, 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg', 0, 'attachment', 'image/jpeg', 0),
(7, 1, '2021-11-28 10:51:43', '2021-11-28 10:51:43', 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg', 'cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg', '', 'inherit', 'open', 'closed', '', 'cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5-jpg', '', '', '2021-11-28 10:51:43', '2021-11-28 10:51:43', '', 0, 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg', 0, 'attachment', 'image/jpeg', 0),
(8, 1, '2021-11-28 10:51:49', '0000-00-00 00:00:00', '{\n    \"ngo-charity-donation::custom_logo\": {\n        \"value\": 7,\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 10:51:49\"\n    }\n}', '', '', 'auto-draft', 'closed', 'closed', '', 'cdc560a1-c3b3-4dd2-94f5-ff8de2514a48', '', '', '2021-11-28 10:51:49', '0000-00-00 00:00:00', '', 0, 'http://localhost/nestforneedyfoundation/?p=8', 0, 'customize_changeset', '', 0),
(9, 1, '2021-11-28 11:10:01', '2021-11-28 11:10:01', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2021-11-28 11:10:01', '2021-11-28 11:10:01', '', 0, 'http://localhost/nestforneedyfoundation/?p=9', 1, 'nav_menu_item', '', 0),
(10, 1, '2021-11-28 11:09:29', '0000-00-00 00:00:00', ' ', '', '', 'draft', 'closed', 'closed', '', '', '', '', '2021-11-28 11:09:29', '0000-00-00 00:00:00', '', 0, 'http://localhost/nestforneedyfoundation/?p=10', 1, 'nav_menu_item', '', 0),
(21, 1, '2021-11-28 12:58:15', '2021-11-28 12:58:15', '', 'e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark', '', 'inherit', 'open', 'closed', '', 'e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark', '', '', '2021-11-28 12:58:15', '2021-11-28 12:58:15', '', 0, 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark.png', 0, 'attachment', 'image/png', 0),
(22, 1, '2021-11-28 12:58:32', '2021-11-28 12:58:32', 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark.png', 'cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark.png', '', 'inherit', 'open', 'closed', '', 'cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark-png', '', '', '2021-11-28 12:58:32', '2021-11-28 12:58:32', '', 0, 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5_adobespark.png', 0, 'attachment', 'image/png', 0),
(13, 1, '2021-11-28 11:28:26', '2021-11-28 11:28:26', 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/cropped-cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg', 'cropped-cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg', '', 'inherit', 'open', 'closed', '', 'cropped-cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5-jpg', '', '', '2021-11-28 11:28:26', '2021-11-28 11:28:26', '', 0, 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/cropped-cropped-e6386e45-d262-4bee-a8b6-39f0a1c1cbc5.jpg', 0, 'attachment', 'image/jpeg', 0),
(14, 1, '2021-11-28 11:29:03', '2021-11-28 11:29:03', '{\n    \"blogdescription\": {\n        \"value\": \"\",\n        \"type\": \"option\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:28:31\"\n    },\n    \"charity-help-lite::custom_logo\": {\n        \"value\": 13,\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:28:31\"\n    },\n    \"charity-help-lite::header_textcolor\": {\n        \"value\": \"blank\",\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:29:03\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', '334ec3a6-520a-4608-997e-971c971bbf2d', '', '', '2021-11-28 11:29:03', '2021-11-28 11:29:03', '', 0, 'http://localhost/nestforneedyfoundation/?p=14', 0, 'customize_changeset', '', 0),
(15, 1, '2021-11-28 11:43:45', '2021-11-28 11:43:45', '', 'donatenowbg', '', 'inherit', 'open', 'closed', '', 'donatenowbg', '', '', '2021-11-28 11:43:45', '2021-11-28 11:43:45', '', 0, 'http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/donatenowbg.jpg', 0, 'attachment', 'image/jpeg', 0),
(16, 1, '2021-11-28 11:43:56', '2021-11-28 11:43:56', '{\n    \"charity-help-lite::background_image\": {\n        \"value\": \"http://localhost/nestforneedyfoundation/wp-content/uploads/2021/11/donatenowbg.jpg\",\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:43:56\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', '7c1a4da8-01a3-447a-bb5d-c6d2bb70cbf8', '', '', '2021-11-28 11:43:56', '2021-11-28 11:43:56', '', 0, 'http://localhost/nestforneedyfoundation/2021/11/28/7c1a4da8-01a3-447a-bb5d-c6d2bb70cbf8/', 0, 'customize_changeset', '', 0),
(17, 1, '2021-11-28 11:45:41', '2021-11-28 11:45:41', '{\n    \"charity-help-lite::background_preset\": {\n        \"value\": \"fit\",\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:44:42\"\n    },\n    \"charity-help-lite::background_size\": {\n        \"value\": \"contain\",\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:44:42\"\n    },\n    \"charity-help-lite::background_repeat\": {\n        \"value\": \"no-repeat\",\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:44:42\"\n    },\n    \"charity-help-lite::background_attachment\": {\n        \"value\": \"fixed\",\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:44:42\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', '8d60a816-a663-42a6-8504-9c7cb8b3ea20', '', '', '2021-11-28 11:45:41', '2021-11-28 11:45:41', '', 0, 'http://localhost/nestforneedyfoundation/?p=17', 0, 'customize_changeset', '', 0),
(18, 1, '2021-11-28 11:46:39', '0000-00-00 00:00:00', '{\n    \"show_on_front\": {\n        \"value\": \"page\",\n        \"type\": \"option\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 11:46:39\"\n    }\n}', '', '', 'auto-draft', 'closed', 'closed', '', '68cb4c4c-77a7-4818-87f1-e02c786ad4a3', '', '', '2021-11-28 11:46:39', '0000-00-00 00:00:00', '', 0, 'http://localhost/nestforneedyfoundation/?p=18', 0, 'customize_changeset', '', 0),
(19, 1, '2021-11-28 11:47:14', '0000-00-00 00:00:00', '', 'Home', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2021-11-28 11:47:14', '0000-00-00 00:00:00', '', 0, 'http://localhost/nestforneedyfoundation/?page_id=19', 0, 'page', '', 0),
(20, 1, '2021-11-28 11:47:14', '0000-00-00 00:00:00', '', 'Home', '', 'auto-draft', 'closed', 'closed', '', '', '', '', '2021-11-28 11:47:14', '0000-00-00 00:00:00', '', 0, 'http://localhost/nestforneedyfoundation/?page_id=20', 0, 'page', '', 0),
(23, 1, '2021-11-28 12:58:59', '2021-11-28 12:58:59', '{\n    \"sine-charity::custom_logo\": {\n        \"value\": 22,\n        \"type\": \"theme_mod\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 12:58:59\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', '5e906348-f26d-4e07-b8da-fba7d39a437d', '', '', '2021-11-28 12:58:59', '2021-11-28 12:58:59', '', 0, 'http://localhost/nestforneedyfoundation/2021/11/28/5e906348-f26d-4e07-b8da-fba7d39a437d/', 0, 'customize_changeset', '', 0),
(24, 1, '2021-11-28 13:00:19', '2021-11-28 13:00:19', '{\n    \"blogname\": {\n        \"value\": \"\",\n        \"type\": \"option\",\n        \"user_id\": 1,\n        \"date_modified_gmt\": \"2021-11-28 13:00:19\"\n    }\n}', '', '', 'trash', 'closed', 'closed', '', '3a7be694-d273-4939-99a1-e98470464b4b', '', '', '2021-11-28 13:00:19', '2021-11-28 13:00:19', '', 0, 'http://localhost/nestforneedyfoundation/2021/11/28/3a7be694-d273-4939-99a1-e98470464b4b/', 0, 'customize_changeset', '', 0),
(25, 1, '2021-11-28 13:02:37', '2021-11-28 13:02:37', '', 'Home', '', 'publish', 'closed', 'closed', '', 'home', '', '', '2021-11-28 13:02:37', '2021-11-28 13:02:37', '', 0, 'http://localhost/nestforneedyfoundation/?page_id=25', 0, 'page', '', 0),
(26, 1, '2021-11-28 13:02:37', '2021-11-28 13:02:37', '', 'Home', '', 'inherit', 'closed', 'closed', '', '25-revision-v1', '', '', '2021-11-28 13:02:37', '2021-11-28 13:02:37', '', 25, 'http://localhost/nestforneedyfoundation/?p=26', 0, 'revision', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_termmeta`
--

DROP TABLE IF EXISTS `wp_termmeta`;
CREATE TABLE IF NOT EXISTS `wp_termmeta` (
  `meta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`meta_id`),
  KEY `term_id` (`term_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wp_terms`
--

DROP TABLE IF EXISTS `wp_terms`;
CREATE TABLE IF NOT EXISTS `wp_terms` (
  `term_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `slug` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `term_group` bigint(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_id`),
  KEY `slug` (`slug`(191)),
  KEY `name` (`name`(191))
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_terms`
--

INSERT INTO `wp_terms` (`term_id`, `name`, `slug`, `term_group`) VALUES
(1, 'Uncategorized', 'uncategorized', 0),
(2, 'Menu 1', 'menu-1', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_relationships`
--

DROP TABLE IF EXISTS `wp_term_relationships`;
CREATE TABLE IF NOT EXISTS `wp_term_relationships` (
  `object_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `term_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_taxonomy_id`),
  KEY `term_taxonomy_id` (`term_taxonomy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_term_relationships`
--

INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`, `term_order`) VALUES
(1, 1, 0),
(9, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wp_term_taxonomy`
--

DROP TABLE IF EXISTS `wp_term_taxonomy`;
CREATE TABLE IF NOT EXISTS `wp_term_taxonomy` (
  `term_taxonomy_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `taxonomy` varchar(32) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `parent` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `count` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`term_taxonomy_id`),
  UNIQUE KEY `term_id_taxonomy` (`term_id`,`taxonomy`),
  KEY `taxonomy` (`taxonomy`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_term_taxonomy`
--

INSERT INTO `wp_term_taxonomy` (`term_taxonomy_id`, `term_id`, `taxonomy`, `description`, `parent`, `count`) VALUES
(1, 1, 'category', '', 0, 1),
(2, 2, 'nav_menu', '', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wp_usermeta`
--

DROP TABLE IF EXISTS `wp_usermeta`;
CREATE TABLE IF NOT EXISTS `wp_usermeta` (
  `umeta_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_520_ci,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`(191))
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_usermeta`
--

INSERT INTO `wp_usermeta` (`umeta_id`, `user_id`, `meta_key`, `meta_value`) VALUES
(1, 1, 'nickname', 'admin'),
(2, 1, 'first_name', ''),
(3, 1, 'last_name', ''),
(4, 1, 'description', ''),
(5, 1, 'rich_editing', 'true'),
(6, 1, 'syntax_highlighting', 'true'),
(7, 1, 'comment_shortcuts', 'false'),
(8, 1, 'admin_color', 'fresh'),
(9, 1, 'use_ssl', '0'),
(10, 1, 'show_admin_bar_front', 'true'),
(11, 1, 'locale', ''),
(12, 1, 'wp_capabilities', 'a:1:{s:13:\"administrator\";b:1;}'),
(13, 1, 'wp_user_level', '10'),
(14, 1, 'dismissed_wp_pointers', 'theme_editor_notice'),
(15, 1, 'show_welcome_panel', '1'),
(17, 1, 'wp_dashboard_quick_press_last_post_id', '4'),
(18, 1, 'wp_user-settings', 'libraryContent=browse&mfold=o'),
(19, 1, 'wp_user-settings-time', '1638098294'),
(20, 1, 'managenav-menuscolumnshidden', 'a:5:{i:0;s:11:\"link-target\";i:1;s:11:\"css-classes\";i:2;s:3:\"xfn\";i:3;s:11:\"description\";i:4;s:15:\"title-attribute\";}'),
(21, 1, 'metaboxhidden_nav-menus', 'a:2:{i:0;s:12:\"add-post_tag\";i:1;s:15:\"add-post_format\";}'),
(22, 1, 'nav_menu_recently_edited', '2');

-- --------------------------------------------------------

--
-- Table structure for table `wp_users`
--

DROP TABLE IF EXISTS `wp_users`;
CREATE TABLE IF NOT EXISTS `wp_users` (
  `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_pass` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_nicename` varchar(50) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_email` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_url` varchar(100) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_registered` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`),
  KEY `user_email` (`user_email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Dumping data for table `wp_users`
--

INSERT INTO `wp_users` (`ID`, `user_login`, `user_pass`, `user_nicename`, `user_email`, `user_url`, `user_registered`, `user_activation_key`, `user_status`, `display_name`) VALUES
(1, 'admin', '$P$B6JG3Q798kTWb90G33rJ6tXlA00KPU0', 'admin', 'smita.mahata@gmail.com', 'http://localhost/nestforneedyfoundation', '2021-11-28 10:37:06', '', 0, 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
