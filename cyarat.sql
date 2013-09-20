-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生日期: 2013 �?09 ??20 ??09:53
-- 伺服器版本: 5.6.11
-- PHP 版本: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫: `cyarat`
--

-- --------------------------------------------------------

--
-- 表的結構 `chh_about_us`
--

CREATE TABLE IF NOT EXISTS `chh_about_us` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `chh_about_us`
--

INSERT INTO `chh_about_us` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `desc`, `is_show`, `sort`) VALUES
(1, 2, '活動宗旨', '', '', '<p>\r\n	活動宗旨內容</p>\r\n<p>\r\n	活動宗旨內容</p>\r\n<p>\r\n	活動宗旨內容</p>', 1, 1),
(2, 3, '單位一', '', '', '<p>\r\n	單位一</p>\r\n<p>\r\n	單位一</p>\r\n<p>\r\n	單位一</p>', 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_about_us_cat`
--

CREATE TABLE IF NOT EXISTS `chh_about_us_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_about_us_cat`
--

INSERT INTO `chh_about_us_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '關於藝動節', '', '', 1, 1, 6),
(2, '藝動節緣起', '', '', 1, 2, 3),
(3, '主協辦單位', '', '', 1, 4, 5);

-- --------------------------------------------------------

--
-- 表的結構 `chh_admin_cat`
--

CREATE TABLE IF NOT EXISTS `chh_admin_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_admin_cat`
--

INSERT INTO `chh_admin_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '管理員分類', '', '', 1, 1, 6),
(2, '最高管理員', '', '', 1, 2, 3),
(3, '管理員', '', '', 1, 4, 5);

-- --------------------------------------------------------

--
-- 表的結構 `chh_admin_priv`
--

CREATE TABLE IF NOT EXISTS `chh_admin_priv` (
  `admin_id` mediumint(10) unsigned NOT NULL,
  `priv_id` mediumint(10) unsigned NOT NULL,
  KEY `admin_id` (`admin_id`),
  KEY `priv_id` (`priv_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `chh_admin_priv`
--

INSERT INTO `chh_admin_priv` (`admin_id`, `priv_id`) VALUES
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(3, 6),
(3, 7),
(3, 8),
(3, 9),
(3, 46),
(3, 45),
(3, 44),
(3, 47),
(3, 48),
(3, 49),
(3, 50),
(3, 51);

-- --------------------------------------------------------

--
-- 表的結構 `chh_admin_user`
--

CREATE TABLE IF NOT EXISTS `chh_admin_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(1) unsigned NOT NULL DEFAULT '1',
  `name` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(32) NOT NULL,
  `add_time` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `action_list` text NOT NULL,
  `nav_list` text NOT NULL,
  `lang_type` varchar(50) NOT NULL,
  `agency_id` smallint(5) unsigned NOT NULL,
  `suppliers_id` smallint(5) unsigned DEFAULT '0',
  `todolist` longtext,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_name` (`name`),
  KEY `agency_id` (`agency_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_admin_user`
--

INSERT INTO `chh_admin_user` (`id`, `cat_id`, `name`, `email`, `password`, `add_time`, `last_login`, `last_ip`, `action_list`, `nav_list`, `lang_type`, `agency_id`, `suppliers_id`, `todolist`, `is_show`, `sort`) VALUES
(1, 2, 'shsing1', 'shsing1@yahoo.com.tw', '94e8cde4612b3fd390677d42e7b22002', 1252915460, 1379661705, '127.0.0.1', 'all', '商品列表|goods.php?act=list,訂單列表|order.php?act=list,用戶評論|comment_manage.php?act=list,會員列表|users.php?act=list,商店設置|shop_config.php?act=list_edit', '', 0, 0, NULL, 1, 1),
(3, 3, 'cyarat', 'shsing2@yahoo.com.tw', 'aeb694d88aa5c5887d7b9ea3473df534', 1260013687, 1379662129, '127.0.0.1', '', '', '', 0, 0, NULL, 1, 3);

-- --------------------------------------------------------

--
-- 表的結構 `chh_cart`
--

CREATE TABLE IF NOT EXISTS `chh_cart` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `session_id` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `goods_sn` varchar(60) NOT NULL DEFAULT '',
  `goods_name` varchar(120) NOT NULL DEFAULT '',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '0',
  `goods_attr` text NOT NULL,
  `is_real` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `extension_code` varchar(30) NOT NULL DEFAULT '',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `rec_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_gift` smallint(5) unsigned NOT NULL DEFAULT '0',
  `can_handsel` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `goods_attr_id` varchar(255) NOT NULL DEFAULT '',
  `sort` mediumint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- 表的結構 `chh_config`
--

CREATE TABLE IF NOT EXISTS `chh_config` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL,
  `code` varchar(30) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL,
  `store_range` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `parent_id` (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

--
-- 轉存資料表中的資料 `chh_config`
--

INSERT INTO `chh_config` (`id`, `cat_id`, `name`, `code`, `type`, `store_range`, `value`, `is_show`, `sort`) VALUES
(1, 2, '網站名稱', 'site_name', 0, '', '2013 新竹藝動節', 1, 12),
(2, 2, '網頁標題', 'site_title', 0, '', '2013 新竹藝動節', 1, 11),
(3, 2, '網站描述', 'site_desc', 0, '', '2013 新竹藝動節', 1, 9),
(4, 2, '網站關鍵字', 'site_keywords', 0, '', '2013 新竹藝動節', 1, 10),
(5, 2, '地址', 'site_address', 0, '', '', 1, 8),
(6, 2, 'Skype', 'skype', 0, '', '', 1, 7),
(7, 2, 'Yahoo Messenger', 'ym', 0, '', '', 1, 6),
(8, 2, 'MSN Messenger', 'msn', 0, '', 'shsing999@gamil.com', 1, 5),
(9, 2, '客服E-mail', 'service_email', 0, '', 'shsing999@gamil.com', 1, 4),
(10, 2, '客服電話', 'service_phone', 0, '', '0912345678', 1, 3),
(11, 2, '暫時關閉網站', 'site_closed', 4, '0,1', '0', 1, 2),
(12, 2, '關閉網店的原因', 'close_comment', 5, '', '', 1, 1),
(13, 3, '系統語言', 'lang', 3, '', '0', 1, 26),
(14, 3, '水印文件', 'watermark', 2, '', '', 1, 25),
(15, 3, '水印位置', 'watermark_place', 4, '0,1,2,3,4,5', '0', 1, 24),
(16, 3, '水印透明度', 'watermark_alpha', 0, '', '65', 1, 23),
(17, 3, '是否啟用庫存管理', 'use_storage', 4, '1,0', '1', 1, 22),
(18, 3, '市場價格比例', 'market_price_rate', 0, '', '1.2', 1, 21),
(19, 3, '商品貨號前綴', 'sn_prefix', 0, '', 'CHH', 1, 20),
(20, 3, '商品的默認圖片', 'no_picture', 2, '', '', 1, 19),
(21, 3, '緩存存活時間（秒）', 'cache_time', 0, '', '3600', 1, 18),
(22, 3, '排行統計的時間', 'top10_time', 4, '0,1,2,3,4', '0', 1, 17),
(23, 3, '默認時區', 'timezone', 7, '-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,8,9,9.5,10,11,12', '8', 1, 16),
(24, 3, '默認庫存', 'default_storage', 0, '', '1', 1, 15),
(25, 3, '縮略圖背景色', 'bgcolor', 0, '', '#FFFFFF', 1, 14),
(26, 3, '是否開啟自動發送郵件', 'send_mail_on', 4, 'on,off', 'off', 1, 13),
(27, 4, '首頁搜索的關鍵字', 'search_keywords', 0, '', '', 1, 34),
(28, 4, '日期格式', 'date_format', 0, '', 'Y-m-d', 1, 33),
(29, 4, '時間格式', 'time_format', 0, '', 'Y-m-d H:i:s', 1, 32),
(30, 4, '貨幣格式', 'currency_format', 0, '', '$%s元', 1, 31),
(31, 4, '商品價格顯示規則', 'price_format', 4, '0,1,2,3,4,5', '3', 1, 30),
(32, 4, '商品分類頁列表的數量', 'page_size', 0, '', '10', 1, 29),
(33, 4, '商品分類頁默認排序類型', 'sort_order_type', 4, '0,1,2', '3', 1, 28),
(34, 4, '商品分類頁默認排序方式', 'sort_order_method', 4, '0,1', '0', 1, 27),
(35, 5, '郵件服務', 'mail_service', 4, '0,1', '1', 1, 42),
(36, 5, '郵件服務器是否要求加密連接(SSL)', 'smtp_ssl', 4, '0,1', '0', 1, 41),
(37, 5, '發送郵件服務器地址(SMTP)', 'smtp_host', 0, '', 'ms1.hinet.net', 1, 40),
(38, 5, '服務器端口', 'smtp_port', 0, '', '25', 1, 39),
(39, 5, '郵件發送帳號', 'smtp_user', 0, '', '', 1, 38),
(40, 5, '帳號密碼', 'smtp_pass', 6, '', '', 1, 37),
(41, 5, '郵件回復地址', 'smtp_mail', 0, '', 'service@cy-arat.com.tw', 1, 36),
(42, 5, '郵件編碼', 'mail_charset', 4, 'UTF8,GB2312,BIG5', 'UTF8', 1, 35),
(43, 6, '干擾金鑰', 'hash_code', 0, '', '31693422540744c0a6b6da635b7a5a93', 1, 47),
(44, 6, '套用樣版', 'template', 0, '', 'default', 1, 46),
(45, 6, '啟用驗證碼', 'captcha', 0, '', '12', 1, 45),
(46, 6, '驗證碼圖片寬度', 'captcha_width', 0, '', '100', 1, 44),
(47, 6, '驗證碼圖片高度', 'captcha_height', 0, '', '20', 1, 43),
(48, 7, '是否顯示貨號', 'show_goodssn', 4, '0,1', '0', 1, 53),
(49, 7, '是否顯示品牌', 'show_brand', 4, '0,1', '0', 1, 52),
(50, 7, '是否顯示重量', 'show_goodsweight', 4, '0,1', '0', 1, 51),
(51, 7, '是否顯示庫存', 'show_goodsnumber', 4, '0,1', '0', 1, 50),
(52, 7, '是否顯示上架時間', 'show_addtime', 4, '0,1', '0', 1, 49),
(53, 7, '是否顯示市場價格', 'show_marketprice', 4, '0,1', '0', 1, 48);

-- --------------------------------------------------------

--
-- 表的結構 `chh_config_cat`
--

CREATE TABLE IF NOT EXISTS `chh_config_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 轉存資料表中的資料 `chh_config_cat`
--

INSERT INTO `chh_config_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '系統設置', '', '', 1, 1, 14),
(2, '網站資訊', '', '', 1, 2, 3),
(3, '基本設置', '', '', 0, 4, 5),
(4, '顯示設置', '', '', 0, 6, 7),
(5, '郵件服務器設置', '', '', 0, 8, 9),
(6, '隱藏參數', '', '', 0, 10, 11),
(7, '商品顯示設置', '', '', 0, 12, 13);

-- --------------------------------------------------------

--
-- 表的結構 `chh_contact`
--

CREATE TABLE IF NOT EXISTS `chh_contact` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(10) unsigned NOT NULL,
  `is_reply` tinyint(1) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `chh_contact_cat`
--

CREATE TABLE IF NOT EXISTS `chh_contact_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `chh_contact_cat`
--

INSERT INTO `chh_contact_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '聯絡我們', '', '', 1, 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_contact_reply`
--

CREATE TABLE IF NOT EXISTS `chh_contact_reply` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `contact_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(10) unsigned NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `chh_custom`
--

CREATE TABLE IF NOT EXISTS `chh_custom` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `chh_custom`
--

INSERT INTO `chh_custom` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `desc`, `is_show`, `sort`) VALUES
(1, 1, '網站首頁介紹', '', '', '<h1>網站首頁介紹</h1> 			此網站是由星爺(shsing1)所開發的，整個網站用以物件導向的方式進行開發，每個功能再以繼承的方式去實現。<br />分類方面是採無限層數進行實做，而且不是以parent和child的方式去實現，而是以最新的左右值方向實現，這是為什麼呢？<br />主要是因為左右值的方式比父子的方式，在效率上要快上好幾倍，例如：如果您的分類有10層的話，如果你要查出這10層的關係，<br />您就必需要對資料庫進行10次查詢，而左右值的方式只要對資料庫進行一次查詢即可查出這10層的關係。<br /><br />再來就是網站上所有的提交動作都是以ajax的方式進行提交，這樣所有的檢查都可以由後台進行，不用再用javascript去進去檢查，<br />在檢查未通過之前，前台會有loading mask防止用戶在系統處理完成前，再次進行動作。<br /><br />圖片或檔案上傳也是以ajax的方式進行上傳，這樣可以在單檔不超過系統設定值進行多檔上傳的動作，這樣可以避免上傳檔案過多時，<br />因為檔案的總容量超過系統的設定值，因而上傳失敗，舉例來說：假設系統上傳的設定值是2m，你上傳單檔為100k的檔案，<br />如果是以前的做法，您頂多只能上傳20個檔案左右，可是，如果是ajax上傳，只要單檔不超過2m，您就可以上傳無限個。<br />', 1, 1);

-- --------------------------------------------------------

--
-- 表的結構 `chh_custom_cat`
--

CREATE TABLE IF NOT EXISTS `chh_custom_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `chh_custom_cat`
--

INSERT INTO `chh_custom_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '自定義畫面', '', '', 1, 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_download`
--

CREATE TABLE IF NOT EXISTS `chh_download` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `chh_download`
--

INSERT INTO `chh_download` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `desc`, `is_show`, `sort`) VALUES
(2, 3, '資料01', '', '', '', 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_download_cat`
--

CREATE TABLE IF NOT EXISTS `chh_download_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_download_cat`
--

INSERT INTO `chh_download_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '檔案下載', '', '', 1, 1, 6),
(2, '大分類01', '123', '456', 1, 2, 5),
(3, '次分類01', '', '', 1, 3, 4);

-- --------------------------------------------------------

--
-- 表的結構 `chh_download_file`
--

CREATE TABLE IF NOT EXISTS `chh_download_file` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `download_id` mediumint(10) unsigned NOT NULL,
  `brief` varchar(50) NOT NULL,
  `file` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 轉存資料表中的資料 `chh_download_file`
--

INSERT INTO `chh_download_file` (`id`, `download_id`, `brief`, `file`, `is_show`, `sort`) VALUES
(25, 2, '22', 'images/download/1261723712718592317.jpg', 1, 23),
(24, 2, '測試', 'images/download/1261723712271075442.jpg', 1, 25),
(23, 2, 'test', 'images/download/1261723712296288302.jpg', 1, 24);

-- --------------------------------------------------------

--
-- 表的結構 `chh_epaper`
--

CREATE TABLE IF NOT EXISTS `chh_epaper` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `last_update` int(10) NOT NULL,
  `last_send` int(10) NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `chh_epaper`
--

INSERT INTO `chh_epaper` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `last_update`, `last_send`, `desc`, `is_show`, `sort`) VALUES
(1, 1, '電子報測試', '', '', 1263815499, 1263815506, '<p>\n	電子報測試<br />\n	<br />\n	<img alt="" src="/images/editor_upload/images/body.jpg" style="width: 1600px; height: 711px;" /><br />\n	<br />\n	電子報測試</p>', 1, 1);

-- --------------------------------------------------------

--
-- 表的結構 `chh_epaper_cat`
--

CREATE TABLE IF NOT EXISTS `chh_epaper_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `chh_epaper_cat`
--

INSERT INTO `chh_epaper_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '電子報', '', '', 1, 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_epaper_queue`
--

CREATE TABLE IF NOT EXISTS `chh_epaper_queue` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `epaper_id` mediumint(10) unsigned NOT NULL,
  `email` varchar(60) NOT NULL,
  `error` tinyint(1) NOT NULL,
  `last_send` int(10) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- 表的結構 `chh_epaper_user`
--

CREATE TABLE IF NOT EXISTS `chh_epaper_user` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 轉存資料表中的資料 `chh_epaper_user`
--

INSERT INTO `chh_epaper_user` (`id`, `cat_id`, `name`, `email`, `is_show`, `sort`) VALUES
(13, 1, '', 'shsing3@yahoo.com.tw', 0, 13),
(10, 1, '', 'shsing1@yahoo.com.tw', 1, 10);

-- --------------------------------------------------------

--
-- 表的結構 `chh_epaper_user_cat`
--

CREATE TABLE IF NOT EXISTS `chh_epaper_user_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 轉存資料表中的資料 `chh_epaper_user_cat`
--

INSERT INTO `chh_epaper_user_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '訂閱名單', '', '', 1, 1, 4),
(2, '01', '', '', 1, 2, 3);

-- --------------------------------------------------------

--
-- 表的結構 `chh_gallery`
--

CREATE TABLE IF NOT EXISTS `chh_gallery` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_gallery`
--

INSERT INTO `chh_gallery` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `img`, `original_img`, `desc`, `is_show`, `sort`) VALUES
(1, 4, '相簿01', '', '', 'images/gallery/1263899299231019182.jpg', 'images/gallery/1263899299717650391.jpg', '', 1, 1),
(2, 4, '相簿02', '', '', 'images/gallery/1263900347374291016.jpg', 'images/gallery/1263900347602588184.jpg', '', 1, 2),
(3, 4, '相簿03', '', '', 'images/gallery/1302530493576946428.jpg', 'images/gallery/1302530493714056881.jpg', '', 1, 3);

-- --------------------------------------------------------

--
-- 表的結構 `chh_gallery_cat`
--

CREATE TABLE IF NOT EXISTS `chh_gallery_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 轉存資料表中的資料 `chh_gallery_cat`
--

INSERT INTO `chh_gallery_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `img`, `original_img`, `is_show`, `lft`, `rgt`) VALUES
(1, '網站相簿', '', '', '', '', 1, 1, 10),
(2, '大分類01', '', '', '', '', 1, 2, 7),
(3, '大分類02', '', '', '', '', 1, 8, 9),
(4, '次分類01_01', '', '', '', '', 1, 3, 4),
(5, '次分類01_02', '', '', '', '', 1, 5, 6);

-- --------------------------------------------------------

--
-- 表的結構 `chh_gallery_img`
--

CREATE TABLE IF NOT EXISTS `chh_gallery_img` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` mediumint(10) unsigned NOT NULL,
  `brief` varchar(50) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- 轉存資料表中的資料 `chh_gallery_img`
--

INSERT INTO `chh_gallery_img` (`id`, `gallery_id`, `brief`, `thumb`, `img`, `original_img`, `is_show`, `sort`) VALUES
(1, 1, '01', 'images/gallery/1263900055044993575.jpg', 'images/gallery/1263900055823242105.jpg', 'images/gallery/1263900055597909851.jpg', 1, 1),
(2, 1, '02', 'images/gallery/1263900055986590260.jpg', 'images/gallery/1263900056448890111.jpg', 'images/gallery/1263900055367566913.jpg', 1, 2),
(3, 1, '03', 'images/gallery/1263900055421520412.jpg', 'images/gallery/1263900056984317764.jpg', 'images/gallery/1263900055371668139.jpg', 1, 3),
(4, 1, '04', 'images/gallery/1263900056808422135.jpg', 'images/gallery/1263900056300040781.jpg', 'images/gallery/1263900055232873900.jpg', 1, 4),
(5, 1, '05', 'images/gallery/1263900056465537187.jpg', 'images/gallery/1263900056610234138.jpg', 'images/gallery/1263900055401493730.jpg', 1, 5),
(6, 1, '06', 'images/gallery/1263900056875973335.jpg', 'images/gallery/1263900056628716135.jpg', 'images/gallery/1263900055422478550.jpg', 1, 6),
(7, 1, '07', 'images/gallery/1263900057440560541.jpg', 'images/gallery/1263900057414485931.jpg', 'images/gallery/1263900056434680436.jpg', 1, 7),
(8, 1, '08', 'images/gallery/1263900057882599280.jpg', 'images/gallery/1263900057149789595.jpg', 'images/gallery/1263900057510241453.jpg', 1, 8),
(9, 1, '09', 'images/gallery/1263900079273694660.jpg', 'images/gallery/1263900079005524465.jpg', 'images/gallery/1263900079699858291.jpg', 1, 9),
(10, 2, '01', 'images/gallery/1263900347109576703.jpg', 'images/gallery/1263900347639614753.jpg', 'images/gallery/1263900347253590240.jpg', 1, 10),
(11, 2, '02', 'images/gallery/1263900347090902839.jpg', 'images/gallery/1263900347051520068.jpg', 'images/gallery/1263900347166638073.jpg', 1, 11),
(12, 2, '03', 'images/gallery/1263900347953527784.jpg', 'images/gallery/1263900348100588220.jpg', 'images/gallery/1263900347167913559.jpg', 1, 12),
(13, 2, '04', 'images/gallery/1263900347644162350.jpg', 'images/gallery/1263900348815893104.jpg', 'images/gallery/1263900347065346373.jpg', 1, 13),
(14, 2, '05', 'images/gallery/1263900347070379112.jpg', 'images/gallery/1263900348660312785.jpg', 'images/gallery/1263900347723579287.jpg', 1, 14),
(15, 3, '', 'images/gallery/1263900749114810626.jpg', 'images/gallery/1263900750382962194.jpg', 'images/gallery/1263900749323593517.jpg', 1, 15),
(16, 3, '', 'images/gallery/1263900749244903160.jpg', 'images/gallery/1263900750183758910.jpg', 'images/gallery/1263900749892653360.jpg', 1, 16),
(17, 3, '', 'images/gallery/1263900750749817799.jpg', 'images/gallery/1263900750208427472.jpg', 'images/gallery/1263900749594659539.jpg', 1, 17),
(18, 3, '', 'images/gallery/1263900750580518611.jpg', 'images/gallery/1263900750952732851.jpg', 'images/gallery/1263900749301876857.jpg', 1, 18),
(19, 3, '', 'images/gallery/1263900750075826032.jpg', 'images/gallery/1263900750182027077.jpg', 'images/gallery/1263900749700954569.jpg', 1, 19),
(20, 3, '', 'images/gallery/1263900750232270205.jpg', 'images/gallery/1263900751466134270.jpg', 'images/gallery/1263900750259221997.jpg', 1, 20),
(21, 3, '', 'images/gallery/1263900751550918963.jpg', 'images/gallery/1263900751810156077.jpg', 'images/gallery/1263900750121873071.jpg', 1, 21),
(22, 3, '', 'images/gallery/1263900751792329031.jpg', 'images/gallery/1263900751266646674.jpg', 'images/gallery/1263900750617016507.jpg', 1, 22),
(23, 3, '', 'images/gallery/1263900751334382490.jpg', 'images/gallery/1263900751388266243.jpg', 'images/gallery/1263900751255407833.jpg', 1, 23),
(24, 3, '', 'images/gallery/1263900751837198536.jpg', 'images/gallery/1263900751891056246.jpg', 'images/gallery/1263900751044588830.jpg', 1, 24),
(25, 3, '', 'images/gallery/1263900751868272261.jpg', 'images/gallery/1263900752663800205.jpg', 'images/gallery/1263900751323094709.jpg', 1, 25),
(26, 3, '', 'images/gallery/1263900752689622246.jpg', 'images/gallery/1263900752951711676.jpg', 'images/gallery/1263900752674202662.jpg', 1, 26),
(27, 3, '', 'images/gallery/1263900752603237023.jpg', 'images/gallery/1263900752637118195.jpg', 'images/gallery/1263900752925220265.jpg', 1, 27),
(28, 3, '', 'images/gallery/1263900752233985466.jpg', 'images/gallery/1263900752967148082.jpg', 'images/gallery/1263900752228715774.jpg', 1, 28),
(29, 3, '', 'images/gallery/1263900752097820643.jpg', 'images/gallery/1263900753928491620.jpg', 'images/gallery/1263900752482439960.jpg', 1, 29),
(30, 3, '', 'images/gallery/1263900752326627582.jpg', 'images/gallery/1263900753858950229.jpg', 'images/gallery/1263900752430713871.jpg', 1, 30),
(31, 3, '', 'images/gallery/1263900753134929222.jpg', 'images/gallery/1263900753832064638.jpg', 'images/gallery/1263900752711261571.jpg', 1, 31),
(32, 3, '', 'images/gallery/1263900753401696650.jpg', 'images/gallery/1263900753224971026.jpg', 'images/gallery/1263900753423917008.jpg', 1, 32),
(33, 3, '', 'images/gallery/1263900753309824325.jpg', 'images/gallery/1263900753689256781.jpg', 'images/gallery/1263900753420971556.jpg', 1, 33),
(34, 3, '', 'images/gallery/1263900753185710178.jpg', 'images/gallery/1263900754271947696.jpg', 'images/gallery/1263900753128344599.jpg', 1, 34),
(35, 3, '', 'images/gallery/1263900754829135084.jpg', 'images/gallery/1263900754009431351.jpg', 'images/gallery/1263900753102916111.jpg', 1, 35),
(36, 3, '', 'images/gallery/1263900754269926705.jpg', 'images/gallery/1263900754379278963.jpg', 'images/gallery/1263900754814686908.jpg', 1, 36),
(37, 3, '', 'images/gallery/1263900754431319667.jpg', 'images/gallery/1263900754540770703.jpg', 'images/gallery/1263900754932778274.jpg', 1, 37),
(38, 3, '', 'images/gallery/1263900754557668075.jpg', 'images/gallery/1263900754369255667.jpg', 'images/gallery/1263900754532517331.jpg', 1, 38);

-- --------------------------------------------------------

--
-- 表的結構 `chh_goods`
--

CREATE TABLE IF NOT EXISTS `chh_goods` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `sn` varchar(60) NOT NULL,
  `market` decimal(10,2) NOT NULL DEFAULT '0.00',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `inventory` smallint(5) unsigned NOT NULL,
  `img` varchar(255) NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_goods`
--

INSERT INTO `chh_goods` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `sn`, `market`, `price`, `inventory`, `img`, `original_img`, `desc`, `is_show`, `sort`) VALUES
(1, 5, 'acer滿15000送1000', '', '', 'CHH000001', '180.00', '150.00', 20, 'images/goods/1261377081599657326.jpg', 'images/goods/1261377081679949359.jpg', '<table border="0" width="710">\n	<tbody>\n		<tr>\n			<td colspan="2">\n				<p align="center">\n					<strong><font color="#0000ff" face="Arial, Helvetica, sans-serif">Acer Aspire 4736G 強猛遊戲格鬥機(640G) <!--gd_name_end--></font></strong></p>\n				<div align="center">\n					<strong><font color="#0000ff" face="Arial, Helvetica, sans-serif">14.1吋LED鏡面寬螢幕 /Intel T6600 (2.2G) / 2G DDRIII /640G<br />\n					NVIDIA 獨顯 G105M實體512M/ DVD燒錄 / 藍芽/ 視訊/ windows 7作業系統<br />\n					</font></strong></div>\n				<p>\n					<strong><font color="#0000ff" face="Arial, Helvetica, sans-serif">&nbsp;</font></strong></p>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				&nbsp;</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<div align="center">\n					<p>\n						<span class="style15"><img alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-1.jpg?u=20091504121214&amp;o=W7_TITLE.jpg" /></span></p>\n					<p>\n						<img alt="" height="518" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-2.jpg?u=20091504121215&amp;o=AS4736%7E2.jpg" width="600" /></p>\n				</div>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<table align="center" border="0" cellpadding="0" cellspacing="0" height="56" width="730">\n					<tbody>\n						<tr>\n							<td background="http://img.monday.com.twhttp//img.monday.com.twhttp://img.monday.com.twhttp://img.monday.com.tw/res/gdsale/st_pic/1196/st-1196449-15.jpg?u=20091806080303&amp;o=/res/product/pic/0570/pdt-570296-14.jpg">\n								<table align="right" border="0" cellpadding="0" cellspacing="0" height="26" width="685">\n									<tbody>\n										<tr>\n											<td>\n												<font color="#89b509" size="4"><strong>Aspire - 規格說明</strong></font></td>\n										</tr>\n									</tbody>\n								</table>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n				<p>\n					&nbsp;</p>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<ul>\n					<li>\n						<font color="#333333" size="2" style="line-height: 2;">處理器:Intel&reg; Core&trade; 2 Duo 雙核心處理器T6600,2.2GHz) </font></li>\n					<li>\n						<font color="#333333" size="2">獨立顯卡: <font color="#ff0066">NVIDIA&reg; 獨顯 G105M實體512M</font></font></li>\n					<li>\n						<font color="#333333" size="2" style="line-height: 2;">螢幕尺寸 : 14.1吋<font color="#ff0066">LED</font> WXGA鏡面寬螢幕 </font></li>\n					<li>\n						<font color="#333333" size="2" style="line-height: 2;">640GB SATA 5400轉高效能硬碟機 </font></li>\n					<li>\n						<font color="#333333" size="2" style="line-height: 2;">超強 <font color="#ff0066">2GB DDRIII </font></font><font color="#333333" size="2">記憶體</font> <font color="#333333" size="2" style="line-height: 2;">/ 無線連線技術,支援Acer SignalUp無線技術</font></li>\n					<li>\n						<font color="#ff0066" size="2" style="line-height: 2;">內建30萬畫素暗光補強視訊鏡頭</font><font color="#333333" size="2" style="line-height: 2;"> / DVD Super Multi DL燒錄光碟機</font></li>\n					<li>\n						<font color="#333333" size="2" style="line-height: 2;">其他 : 多合一讀卡機 (SD/MMC/MS/xD/MS PRO) </font></li>\n				</ul>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2" height="19">\n				<p>\n					&nbsp;</p>\n				<p align="center">\n					<img alt="" height="428" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-3.jpg?u=20091504121215&amp;o=AS4736%7E4.jpg" width="600" /></p>\n				<p align="center">\n					<img alt="" height="409" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-4.jpg?u=20091504121216&amp;o=AS9C86%7E1.jpg" width="550" /></p>\n				<p align="center">\n					<font color="#333333"><font size="2"><font style="line-height: 2;">右方為影音多媒體鍵</font> </font><br />\n					<font size="2" style="line-height: 2;">鍵盤為平浮式鍵盤</font></font></p>\n				<p align="center">\n					<img alt="" height="291" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-5.jpg?u=20091504121217&amp;o=ASAC8A%7E1.jpg" width="550" /></p>\n				<p align="center">\n					<font color="#333333" size="2" style="line-height: 2;">轉軸處及電源部份藍色光芒設計</font></p>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<table align="center" border="0" cellpadding="0" cellspacing="0" height="56" width="730">\n					<tbody>\n						<tr>\n							<td background="http://img.monday.com.twhttp//img.monday.com.twhttp://img.monday.com.twhttp://img.monday.com.tw/res/gdsale/st_pic/1196/st-1196449-15.jpg?u=20091806080303&amp;o=/res/product/pic/0570/pdt-570296-14.jpg">\n								<table align="right" border="0" cellpadding="0" cellspacing="0" height="26" width="685">\n									<tbody>\n										<tr>\n											<td>\n												<font color="#89b509" size="4"><strong>Aspire - 特色解析</strong></font></td>\n										</tr>\n									</tbody>\n								</table>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<p>\n					<font size="2" style="line-height: 2;"><font color="#666666"><font color="#333333">Aspire 4736G系列採<font size="1">用</font>Intel 雙核心處理器，輕鬆駕馭多個應用程式；Intel SpeedStep&reg; 技術，可動態調節處理器電壓與時脈，減少耗電及熱能同時帶來更高效能；搭配全新Gemston blue設計，更輕薄有型! 時尚設計，絕美外型，吸引眾人目光！Acer Empowering Technology1人性化後控管理平台，包含資料加密、電力管理、系統回復等功能，全面提升使用效率，一指搞定，快速便利。 Acer InviLink Nplify 802.11a/b/g/Draft-N無線網路模組，Acer SignalUP?無線連線技術，360&deg;收訊無死角，全面滿足使用者的行動運算需求! 內建多合一讀卡機，支援MMC/SD/xD/MS/MS PRO多種格式；DVD Super Multi燒錄光碟機，支援市面上DVD&plusmn;R、DVD-RAM三大燒錄格式，重要資料，輕鬆備份儲存。</font> </font><br />\n					</font></p>\n			</td>\n		</tr>\n		<tr>\n			<td width="361">\n				<div align="center">\n					<font size="2" style="line-height: 2;"><img alt="" height="212" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-6.jpg?u=20091504121217&amp;o=asred3.jpg" width="320" /><br />\n					<font color="#666666">此為一般筆電在黑暗中呈現的</font> </font></div>\n			</td>\n			<td width="365">\n				<div align="center">\n					<font size="2" style="line-height: 2;"><img alt="" height="212" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-7.jpg?u=20091504121218&amp;o=asred4.jpg" width="320" /><br />\n					</font><font color="#666666" size="2" style="line-height: 2;">acer筆電的超強暗光補強視訊技術黑暗中也超清析</font></div>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2" height="18">\n				<p>\n					<font color="#ff0066" size="2" style="line-height: 2;"><strong><font face="Verdana">《內建30萬畫素攝影機，讓您溝通零距離!</font>》</strong></font><font color="#666666" size="2" style="line-height: 2;"><br />\n					<font color="#333333">acer 貼心設計內建新一代 acer Crystal Eye 30萬畫素網路攝影機，獨家暗光補強技術讓您盡情暢通無阻的視訊聊天。使您的視訊傳輸更為清楚、穩定，有了活潑逗趣的使用介面，讓您在繁忙的商務旅程中也能享受多方溝通、網路聊天的樂趣。</font><br />\n					</font></p>\n				<font size="2" style="line-height: 2;"><font color="#ff0066" size="4"><strong><font size="2">《高彩14.1吋鏡面螢幕》</font><br />\n				</strong></font></font>\n				<p>\n					<font color="#666666" size="2" style="line-height: 2;"><font color="#333333">配置了優異的顯示，再加上 14.1 吋鏡面螢幕，無論是作報告或是看影片、玩遊戲，都提供十分廣大的視野，配上 Acer GridVista 的助力，可同時顯示多重視窗，不用再頻頻切換視窗，十分便利。</font> </font></p>\n				<p>\n					<font size="2" style="line-height: 2;"><font color="#ff0066" size="4"><strong><img alt="" height="292" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-8.gif?u=20091504121218&amp;o=ACER-Gridvista-500.gif" width="500" /></strong></font></font></p>\n				<table align="center" border="0" cellpadding="0" cellspacing="0" height="56" width="730">\n					<tbody>\n						<tr>\n							<td background="http://img.monday.com.twhttp//img.monday.com.twhttp://img.monday.com.twhttp://img.monday.com.tw/res/gdsale/st_pic/1196/st-1196449-15.jpg?u=20091806080303&amp;o=/res/product/pic/0570/pdt-570296-14.jpg">\n								<table align="right" border="0" cellpadding="0" cellspacing="0" height="26" width="685">\n									<tbody>\n										<tr>\n											<td>\n												<font color="#89b509" size="4"><strong>Aspire - 第三代杜比音效更震撼</strong></font></td>\n										</tr>\n									</tbody>\n								</table>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n				<p align="center">\n					<strong><img alt="" height="316" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-9.jpg?u=20091504121219&amp;o=ASAC8E%7E1.jpg" width="550" /></strong></p>\n				<p>\n					<font color="#333333" size="2" style="line-height: 2;">延 續Aspire家族追求頂級音效的傳統，Acer領先採用「第三代Dolby&reg; Home Theater環繞音效」，新增「Dolby&reg; Audio Optimization(音頻優化)」與「Dolby&reg; High Frequency Enhancer(高音頻增強技術)」，讓高音/低音不再受限於筆電的喇叭分貝數，重新獲得定位與還原，帶來更精采、富層次的音響效果與更有劇院臨場感的 立體環繞饗宴。 </font></p>\n				<p>\n					<font color="#333333" size="2" style="line-height: 2;">Dolby&reg; Pro Logic IIx 杜比定向邏輯技術：能將任何雙聲道的電影、電視或遊戲等音源訊號，轉為Dolby&reg; 5.1聲道環繞音效的技術<br />\n					Dolby&reg; Headphone 杜比耳機技術：通過任何一副耳機就能聽到如電影院般的立體環繞音效，並提供更舒適的行動聆賞體驗<br />\n					Dolby&reg; Sound Space Expander 杜比音場拓展技術：透過多聲道喇叭裝置，提高收聽時的3D空間感與360&deg;劇場般的聆賞體驗<br />\n					Dolby&reg; Natural Bass 杜比自然重低音增強技術：透過喇叭或耳機，自然向下延伸低八度音，創造出層次更豐富的頻率響應<br />\n					Dolby&reg; High Frequency Enhancer 杜比高音頻增強技術：重現與加強因傳輸及編碼時所流失的高音頻，呈現更真實、未經加工的原始高音 Dolby&reg; Audio Optimization 杜比音頻優化技術：修正頻率問題，使電腦不受限硬體的分貝數，針對不同電腦規格調校出適合的音頻優化技術<br />\n					Dolby&reg; Digital Live 杜比數字真實編碼技術：提供只需透過一條光纖(S/PDIF)，就能將任何格式轉為Dolby&reg; Digital的編碼技術 </font></p>\n				<p>\n					&nbsp;</p>\n				<p>\n					&nbsp;</p>\n				<p>\n					&nbsp;</p>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				&nbsp;</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<table align="center" border="0" cellpadding="0" cellspacing="0" height="56" width="730">\n					<tbody>\n						<tr>\n							<td background="http://img.monday.com.twhttp//img.monday.com.tw/res/gdsale/st_pic/1196/st-1196449-15.jpg?u=20091806080303&amp;o=/res/product/pic/0570/pdt-570296-14.jpg">\n								<table align="right" border="0" cellpadding="0" cellspacing="0" height="26" width="685">\n									<tbody>\n										<tr>\n											<td>\n												<font color="#89b509" size="4"><strong>【Windows 7 家用進階版】微軟最新、最強的作業系統 - Windows 7 震撼登場!</strong></font></td>\n										</tr>\n									</tbody>\n								</table>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<table align="center" border="0" cellpadding="0" cellspacing="0" width="637">\n					<tbody>\n						<tr>\n							<td>\n								<img alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-1.jpg?u=20091504121214&amp;o=W7_TITLE.jpg" /></td>\n						</tr>\n						<tr>\n							<td>\n								<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold;"><font size="3"><img align="left" alt="" hspace="20" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-11.jpg?u=20091504121220&amp;o=BOX_7.jpg" vspace="20" />微軟最好用的版本! PC 的最佳娛樂體驗</font> </span><br />\n								Windows 7 家用進階版讓您輕鬆建立家用網路，以及分享所有喜愛的相片、影片和音樂。您還可以觀賞、暫停、倒轉和錄製節目。使用 Windows 7 家用進階版取得最佳娛樂體驗。 </font></td>\n						</tr>\n						<tr>\n							<td>\n								<ul>\n									<li>\n										<font color="#0066cc" face="Arial, Helvetica, sans-serif" size="3" style="line-height: 2;"><span style="font-weight: bold;">新- 支援目前最新的技術且具未來性</span><br />\n										</font>\n										<ul>\n											<li>\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold;"><span style="color: rgb(255, 0, 102);">驅動程式找不到?交給Windows 7</span>-</span>支 援目前市面最新的硬體設備外，在安裝上也變得非常便利，你只要將設備接上電腦後，系統會自動透過Windows Update的方式安裝驅動程式。達到隨插即用，不用煩惱不會安裝或忘記找不到驅動程式光碟等問題</font></li>\n											<li style="width: 552px;">\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="color: rgb(255, 0, 102); line-height: 2;"><span style="font-weight: bold;">支援更高的螢幕解析度</span></font><font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="font-weight: bold; color: rgb(255, 0, 102); line-height: 2;">、更大的螢幕尺寸</font><font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">-</span> 有越來越多高解析度的顯示器、液晶電視紛紛上市。前一代僅能支援中低階的顯示輸出， Windows7高解析度的支援下，顯示出更流暢且細膩的畫質，滿足對畫面品質越來越挑剔的你!</font></li>\n											<li style="width: 555px;">\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">玩Game更身歷其 境-Windows 7支援最新DirectX 11及WDDM 1.1。</span> 總覺得打怪時，人物和場景都是貼圖、顆粒畫面不夠細膩嗎? 來試試Windows 7上DirectX 11的新體驗。無論在遊戲或是工作上，在3D的顯示上更為細膩流暢</font></li>\n										</ul>\n									</li>\n								</ul>\n							</td>\n						</tr>\n						<tr>\n							<td>\n								<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><img align="middle" alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-12.jpg?u=20091504121220&amp;o=scan.jpg" style="width: 320px; height: 230px;" /></font><img align="middle" alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-13.jpg?u=20091504121221&amp;o=TOUCH.jpg" style="width: 320px; height: 230px;" /></td>\n						</tr>\n						<tr>\n							<td>\n								<ul>\n									<li>\n										<font color="#0066cc" face="Arial, Helvetica, sans-serif" size="3" style="line-height: 2;"><span style="font-weight: bold;">快- 電腦運作要更快速、操作簡單</span></font><font color="#0066cc" face="Arial, Helvetica, sans-serif" size="3" style="line-height: 2;"><br />\n										</font>\n										<ul>\n											<li style="width: 554px;">\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">簡單好用的操作介面 -Windows 7 可讓您從工作列「一窺」已開啟的文件。</span>您只要將滑鼠移到工作列預覽上面，就可以看到該程式中所有已開啟 的文件。若您接著將滑鼠移到其中一個縮圖預覽，就會看到大的文件預覽。</font></li>\n											<li style="width: 555px;">\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">跳躍清單，幫你找文 件！更輕鬆找到最近和最常用的檔案、資料夾和連結。</span> 跳躍清單會出現在兩處：您可在[開始]功能表中將滑鼠移到某一個程式名稱上，此時跳躍清單就會出現，您也可以在工作列的圖示上按滑鼠右鍵，存取跳躍清單。</font></li>\n											<li style="width: 554px;">\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">支援觸控點選 -</span>除 了可透過原來滑鼠鍵盤的操作外，現在只要加上觸控螢幕</font><font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;">(需硬體支援)</font><font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;">，搭配Windows 7中的觸控技術，使用者可以直接點選螢幕的方式來操作，降低學習操作電腦的門檻。</font></li>\n											<li style="width: 545px;">\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">簡易的無線網路設定 -</span>內建的新的網路和共用中心，可讓使用者更簡單的連線到網際網路，也支援更新的安全加密技術</font></li>\n											<li style="width: 550px;">\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">文件即時預覽功能-</span>， 除了可以利用Windows搜尋外，現在你也可以透過即時預覽的功能，不用等待Office開啟的狀況下直接在視窗上面瀏覽Office 2007支援的檔案</font></li>\n										</ul>\n									</li>\n								</ul>\n							</td>\n						</tr>\n						<tr>\n							<td>\n								<img alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-14.jpg?u=20091504121222&amp;o=SAVE.jpg" style="width: 320px; height: 230px;" /><img alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-15.jpg?u=20091504121222&amp;o=START.jpg" style="width: 320px; height: 230px;" /></td>\n						</tr>\n						<tr>\n							<td>\n								<ul>\n									<li>\n										<font color="#0066cc" face="Arial, Helvetica, sans-serif" size="3" style="line-height: 2;"><span style="font-weight: bold;">好 - 穩定、品質更好</span><br />\n										</font>\n										<ul>\n											<li>\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="font-weight: bold; color: rgb(255, 0, 102); line-height: 2;">微軟最穩定的版本-</font><font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);"> 全方位提升-Windows7無論在開關機速度、記憶體管理、視窗顯示管理等各方面都有了大幅度的提升。</span>不用再像以前一樣擔心 會藍屏(Blue Screen)的噩夢，取而代之的是更豐富具有多元性的使用經驗</font></li>\n											<li>\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">行動作業中心掌管電 腦大小事</span><span style="color: rgb(255, 0, 102);">-</span>忘 記更新、病毒碼過期、防火牆未開啟&hellip;，諸如此類系統的大小事，現在都可以藉由 Windows 7中全新的行動作業中心來幫你管理。可大幅降低中毒等安全性問題及縮短災害復原的時間。 </font></li>\n										</ul>\n									</li>\n								</ul>\n							</td>\n						</tr>\n						<tr>\n							<td>\n								<img align="middle" alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-16.jpg?u=20091504121223&amp;o=MEMO.jpg" style="width: 320px; height: 230px;" /><font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><img align="middle" alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-17.jpg?u=20091504121224&amp;o=DS.jpg" style="width: 320px; height: 230px;" /></font></td>\n						</tr>\n						<tr>\n							<td>\n								<ul>\n									<li>\n										<font color="#0066cc" face="Arial, Helvetica, sans-serif" size="3" style="line-height: 2;"><big><span style="font-weight: bold;">省- 省時、省電也幫你更省錢</span></big><br />\n										</font>\n										<ul>\n											<li>\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold;"><span style="color: rgb(255, 0, 102);">強大最新的 Windows 搜尋功能包括：</span> </span>每一項搜尋結果的所有屬性加上標籤，文字排版 和顏色皆已更新，將搜尋條件中的關鍵字以醒目的方式標示，讓您更容易瞭解搜尋結果。</font></li>\n											<li>\n												<font color="#ff0066" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold;">電源管理功能節能又環保-</span></font><font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;">可依照使用者目前的 需求來管理電源，像是省電、平衡、或高效率模式。另外Windows 7亦可自動辨識電腦的使用狀態或透過網域集中管理方式，於電腦不用時讓電腦進入低電源待機、休眠等狀態，節省電源浪費、延長電池的壽命</font></li>\n											<li>\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">貼心程式及工具-</span>例 如好用的桌面便利貼、利用使用Media Center來播放或錄製電視節目、透過桌面小工具來當字典、透過IE8加速器來查詢地圖、內建DVD燒錄功能等，免額外購買軟體!</font></li>\n										</ul>\n									</li>\n								</ul>\n							</td>\n						</tr>\n						<tr>\n							<td>\n								<img alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-18.jpg?u=20091504121225&amp;o=MC.jpg" style="width: 320px; height: 230px;" /><img alt="" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-19.jpg?u=20091504121225&amp;o=SHARE.jpg" style="width: 320px; height: 230px;" /></td>\n						</tr>\n						<tr>\n							<td>\n								<ul>\n									<li>\n										<font color="#0066cc" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><big><span style="font-weight: bold;">全- 系統更安全，全家人的多媒體娛樂中心！</span></big><br />\n										</font>\n										<ul>\n											<li>\n												<font color="#ff0066" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold;">全方位的備份及復原-而Windows 7內建完整電腦備份與還原的功能。</span> </font><br />\n												<font color="#ff0066" face="Arial, Helvetica, sans-serif" size="2" style="color: rgb(102, 102, 102); line-height: 2;">即使發生嚴重問題，只需透過簡易的操作方式，即可針對重要的檔案或整個系統來進行備份。即使電腦發生嚴重錯誤需 要重新安裝時，也可透過先前備份的檔案透過精靈的方式快速還原</font></li>\n											<li>\n												<font color="#666666" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold; color: rgb(255, 0, 102);">多台電腦分享超容易</span><span style="color: rgb(255, 0, 102);">-</span>透過Windows 7上面的家用群組，簡簡單單兩三下的步驟，即可和家人分享電腦中的文件、音樂或印表機等。</font></li>\n											<li>\n												<font color="#ff0066" face="Arial, Helvetica, sans-serif" size="2" style="font-weight: bold; line-height: 2;"><span style="font-weight: bold;">Media Player 人到哪!音樂到哪!</span>最 酷的是，透過最新的「播放至Play to」功能，你可以選擇將臥房內電腦裡的音樂或影片直接傳至客廳的電腦或Xbox 上面播放。Media Center </font><font color="#ff0066" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;"><span style="font-weight: bold;">現在你可以把 Windows 7裡的Media Center當作家裡的娛樂中心，</span><span style="color: rgb(102, 102, 102);">它支援更高畫質的影片播放，也可用來播放電視、音樂、圖 片、廣播。甚至可以用來錄製電視節目等連接網路後也可欣賞線上精選中的豐富單元，包含遊戲、KTV、電影、教學影片等單元。全家同樂!</span></font></li>\n										</ul>\n									</li>\n								</ul>\n							</td>\n						</tr>\n						<tr>\n							<td>\n								<div style="text-align: center;">\n									<font color="#ff0066" face="Arial, Helvetica, sans-serif" size="2" style="line-height: 2;">※ 以上為 Windows 7作業系統相關介紹，若有任何錯誤，以原廠所公佈資料為準。</font></div>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				&nbsp;</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<table align="center" border="0" cellpadding="0" cellspacing="0" height="56" width="730">\n					<tbody>\n						<tr>\n							<td background="http://img.monday.com.twhttp//img.monday.com.twhttp://img.monday.com.twhttp://img.monday.com.tw/res/gdsale/st_pic/1196/st-1196449-15.jpg?u=20091806080303&amp;o=/res/product/pic/0570/pdt-570296-14.jpg">\n								<table align="right" border="0" cellpadding="0" cellspacing="0" height="26" width="685">\n									<tbody>\n										<tr>\n											<td>\n												<font color="#89b509" size="4"><strong>宏碁，秉持「創新關懷」的企業服務理念，提供全球消費者最優質的服務</strong></font></td>\n										</tr>\n									</tbody>\n								</table>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<div align="center">\n					<img alt="" height="850" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-20.jpg?u=20091504121226&amp;o=about-acer.jpg" width="630" /></div>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<table align="center" border="0" cellpadding="0" cellspacing="0" height="56" width="730">\n					<tbody>\n						<tr>\n							<td background="http://rp1.monday.vip.tw1.yahoo.nethttp//img.monday.com.twhttp://img.monday.com.twhttp://img.monday.com.twhttp://img.monday.com.tw/res/gdsale/st_pic/1196/st-1196449-15.jpg?u=20091806080303&amp;o=/res/product/pic/0570/pdt-570296-14.jpg">\n								<table align="right" border="0" cellpadding="0" cellspacing="0" height="26" width="685">\n									<tbody>\n										<tr>\n											<td>\n												<font color="#89b509" size="4"><strong>宏碁筆記型電腦258服務承諾</strong></font></td>\n										</tr>\n									</tbody>\n								</table>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<font size="2" style="line-height: 2;"><strong><font color="#ff0066" size="4">《2 年完全保固》</font></strong></font><font size="2" style="line-height: 2;"><font color="#666666"><br />\n				<font color="#333333">其 他品牌限定條件、限地機種半套式服務已落伍，往往在維修時才會發現很多零件、型號機種都不在保固範圍內，宏碁全系列筆記型電腦大至螢幕、主機板，小至電源 線整機2年保固，提供完整全套服務，只要在保固期內、正常使用的情況下，所有硬體之維修皆免收費。 （註：電池保固期為一年、另隨機贈品非保固項目）</font><br />\n				</font></font><font size="2" style="line-height: 2;"><strong><font color="#ff0066" size="4">《58 分鐘快速完修》<br />\n				</font></strong></font><font size="2" style="line-height: 2;"><font color="#666666"><font color="#333333">一般電腦維修最少得花上3天的時間，總是造成工作及生活上的諸多不便，宏碁首創全球58分鐘快速完修服務，滿足您在關鍵時刻的緊急需求，當需要更深入檢測、維修而無法於58分鐘內完修，直營服務中心主動提供代用機供您應急使用，保障不因維修影響重要工作。</font> </font><br />\n				</font></td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<div align="center">\n					<img alt="" height="200" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-21.gif?u=20091504121226&amp;o=SERVER-03160001.gif" width="690" /></div>\n			</td>\n		</tr>\n		<tr>\n			<td colspan="2">\n				<iframe frameborder="0" height="490" id="frame1" name="frame1" scrolling="no" src="http://twsupport.acer.com.tw/intro/image/service_map.swf" width="540"></iframe></td>\n		</tr>\n	</tbody>\n</table>\n<!--end01--><!--特別推薦 END--><!-- 藍色=Title1、粉紅色=Title2、綠色=Title3、金色=Title4 --><!--商品規格 --><div class="Title1">\n	商品規格</div>\n<div style="width: 720px; margin-left: 30px;">\n	<table>\n		<tbody>\n			<tr>\n				<td>\n<!--start02-->					<table border="0" cellpadding="0" cellspacing="0" width="700">\n						<tbody>\n							<tr>\n								<td height="30">\n									<font color="#0066cc" face="Verdana, Arial, Helvetica, sans-serif" size="4"><strong>》 NB 規格</strong></font></td>\n							</tr>\n							<tr>\n								<td bgcolor="#e7e7e7" height="1">\n									&nbsp;</td>\n							</tr>\n							<tr>\n								<td height="10">\n									&nbsp;</td>\n							</tr>\n							<tr>\n								<td>\n									<table border="1" bordercolor="#89bff1" cellpadding="1" cellspacing="0" width="700">\n										<tbody>\n											<tr>\n												<td>\n													<table border="1" bordercolor="#ffffff" cellpadding="1" cellspacing="0" style="width: 100%;">\n														<tbody>\n															<tr>\n																<td bgcolor="#eeeeee" height="25" width="30%">\n																	<div align="center">\n																		<font size="2"><strong>LCD尺寸</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd" width="334">\n																	<font color="#ff0066" size="2">16：9</font><font color="#ff0066" size="2"> </font><font color="#000000" size="2">之 14.0&quot; WXGA (HD) 高亮度 (200-nit) Acer CineCrystal&trade; LED-backlit TFT LCD, 支援 Acer GridVista&trade; 技術可同時管理多重視窗配置，16.7 百萬色 / 8毫秒快速反應時間</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>LCD解析度 </strong></font></div>\n																</td>\n																<td>\n																	<font color="#000000" size="2">1366 x 768 畫素</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>中央處理器</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font color="#ff0066" size="2">Intel Core 2 Duo 64位元 雙核心處理器T6600(2.2GHz)</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>L2快取記憶體 </strong></font></div>\n																</td>\n																<td>\n																	<font color="#ff0066" size="2">2M </font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>主機板晶片 </strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font size="2">Mobile Intel&reg; PM45 Express Chipset</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>主記憶體</strong></font></div>\n																</td>\n																<td>\n																	<font color="#000000" size="2">2GB DDR3 1066MHz 系統記憶體，可在雙soDIMM插槽擴充至4GB</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>記憶體擴充槽</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font size="2">2(已佔用*1)</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>擴充記憶體容量 </strong></font></div>\n																</td>\n																<td>\n																	<font size="2">4GB</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>儲存硬碟容量 </strong></font></div>\n																</td>\n																<td style="background-color: rgb(240, 247, 253);">\n																	<font size="2">640 GB SATA硬碟</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>顯示晶片 </strong></font></div>\n																</td>\n																<td>\n																	<font color="#ff0066" size="2">NVIDIA&reg; GeForce&reg; G105M </font><font size="2">with up to 2303 MB of TurboCache&trade; , supporting NVIDIA&reg; CUDA&trade;, PureVideo&reg; HD technology, OpenEXR High Dynamic-Range (HDR) technology, Shader Model 4.0, Microsoft&reg; DirectX&reg; 10</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>視訊記憶體 </strong></font></div>\n																</td>\n																<td style="background-color: rgb(240, 247, 253);">\n																	<font size="2">實體512MB</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>網路裝置</strong></font></div>\n																</td>\n																<td>\n																	<font color="#000000" size="2">Intel&reg; Wireless WiFi Link 5100 (dual-band quad-mode 802.11a/b/g/Draft-N) Wi-Fi CERTIFIED&reg; network connection, featuring MIMO technology, 支援 Acer SignalUp&trade; with Nplify&trade; wireless technology<br />\n																	內建Gigabit Ethernet，具備Wake-on-LAN 功能<br />\n																	內建56K ITU V.92 資料傳真軟體數據機 (含國際 PTT 認證)，具備 Wake-on-Ring 功能</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>視訊</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font size="2">內建Acer CrystalEye 30萬畫素暗光補強視訊鏡頭 </font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>I/O 插槽</strong></font></div>\n																</td>\n																<td>\n																	<p>\n																		<font size="2">1個多合一讀卡機(SD/MMC/xD/MS/MS Pro)<br />\n																		3個 USB 2.0<br />\n																		HDMI&trade; port with HDCP support<br />\n																		1個外接 VGA 連接埠<br />\n																		1個耳機/喇叭/線路輸出支援S/PDIF<br />\n																		1個麥克風/線路輸入插孔<br />\n																		1個RJ-45 乙太網路連接埠<br />\n																		Modem (RJ-11) port<br />\n																		AC 變壓器用的DC-in 直流電源接頭</font></p>\n																</td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>PCMCIA 插槽</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font size="2">無</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>光碟機</strong></font></div>\n																</td>\n																<td>\n																	<font size="2">DVD Super Multi DL(SATA)燒錄光碟機</font></td>\n															</tr>\n															<tr>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>電池</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font size="2">6cell 鋰電池</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>音效裝置</strong></font></div>\n																</td>\n																<td>\n																	<font size="2">內建 Dolby3代環場立體音效系統(包含耳機輸出及2個立體喇叭裝置)<br />\n																	兩各立體喇叭裝置 / 內建麥克風</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>輸入裝置</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font size="2">觸控板</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>作業系統</strong></font></div>\n																</td>\n																<td>\n																	<font size="2">正版Windows 7作業系統</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>附贈軟體</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font size="2"><a href="http://www.so-net.net.tw/sales/monday2/" target="_blank"><img alt="" border="0" height="52" src="http://rp1.monday.vip.tw1.yahoo.net/res/gdsale/st_pic/1850/st-1850590-22.jpg?u=20091504121227&amp;o=SO-net-200x52.jpg" width="200" /></a></font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>保固年限</strong></font></div>\n																</td>\n																<td>\n																	<font size="2">一年國際旅約/二年台灣地區全保固/58分鐘快修</font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>尺寸</strong></font></div>\n																</td>\n																<td bgcolor="#f0f7fd">\n																	<font size="2">342(寬) x 239(深) x 23/38.6(高)mm </font></td>\n															</tr>\n															<tr>\n																<td bgcolor="#eeeeee" height="25">\n																	<div align="center">\n																		<font size="2"><strong>重量</strong></font></div>\n																</td>\n																<td>\n																	<font size="2">重量：2.3公斤 (6 cell)</font></td>\n															</tr>\n														</tbody>\n													</table>\n												</td>\n											</tr>\n										</tbody>\n									</table>\n								</td>\n							</tr>\n							<tr>\n								<td>\n									&nbsp;</td>\n							</tr>\n							<tr>\n								<td height="40">\n									<p>\n										<font color="#ff0066" size="2" style="line-height: 2;"><strong>※以上規格資料若有任何錯誤，以原廠所公佈資料為準。<br />\n										※記憶體擴充需自行安裝。<br />\n										</strong></font></p>\n								</td>\n							</tr>\n							<tr>\n								<td height="30">\n									<font color="#0066cc" face="Verdana, Arial, Helvetica, sans-serif" size="4"><strong>》退貨需知</strong></font></td>\n							</tr>\n							<tr>\n								<td bgcolor="#e7e7e7" height="1">\n									&nbsp;</td>\n							</tr>\n							<tr>\n								<td height="10">\n									<p align="center">\n										<strong><font size="2"><br />\n										依照消費者保護法規定，消費者享有商品到貨七天猶豫期之權益 </font></strong></p>\n									<p>\n										<font size="2" style="line-height: 2;"><strong>・</strong>但退貨的商品必須為全新狀態（不得有刮傷）且完整包裝 【 包含主商品、附件件部份（電源線、變壓器等）、內外包裝、保麗龍、隨機文件、贈品等】 ；此外，著作權相關之商品，軟體部份：應用軟體、作業系統等（不得拆封）。<br />\n										<strong>・</strong> 本商品包裝內外包裝箱皆有序號須與主商品序號相符合，勿直接於原廠包裝上黏貼紙張或書寫文字。若原廠包裝損毀將無法退貨。<br />\n										<strong>・</strong> 限量贈品因價值無法評估，無法另行取得，若有污損、損傷、損壞、磨損，恕無法退貨！</font></p>\n								</td>\n							</tr>\n						</tbody>\n					</table>\n<!--end02-->				</td>\n			</tr>\n		</tbody>\n	</table>\n</div>\n<!--商品規格 END--><!--商品保證 --><div class="Title1">\n	商品保證</div>\n<div style="width: 720px; margin-left: 30px;">\n	<table>\n		<tbody>\n			<tr>\n				<td>\n<!--start03-->					<table align="left" border="0" cellpadding="0" cellspacing="0">\n						<tbody>\n							<tr>\n								<td width="25">\n									&nbsp;</td>\n								<td>\n									<table align="left" border="0" cellpadding="0" cellspacing="0" width="560">\n										<tbody>\n											<tr>\n												<td height="10">\n													&nbsp;</td>\n											</tr>\n											<tr>\n												<td>\n													<p>\n														<font size="2">我們所提供為全新產品，並提供以下保證：<br />\n														保固期：一年<br />\n														保固範圍：產品故障<br />\n														顧客諮詢服務中心：本站客服中心。</font></p>\n												</td>\n											</tr>\n											<tr>\n												<td height="10">\n													&nbsp;</td>\n											</tr>\n										</tbody>\n									</table>\n								</td>\n							</tr>\n						</tbody>\n					</table>\n<!--end03-->				</td>\n			</tr>\n		</tbody>\n	</table>\n</div>\n<!--商品保證 END--><!--商品運送 --><div class="Title1">\n	商品運送</div>\n<table>\n	<tbody>\n		<tr>\n			<td>\n<!--start04-->				<table align="left" border="0" cellpadding="0" cellspacing="0">\n					<tbody>\n						<tr>\n							<td width="25">\n								　</td>\n							<td>\n								<table align="left" border="0" cellpadding="0" cellspacing="0" width="560">\n									<tbody>\n										<tr>\n											<td height="10">\n												&nbsp;</td>\n										</tr>\n										<tr>\n											<td>\n												<ul>\n													<li>\n														<ul>\n															<li>\n																<font size="2">免運費。</font></li>\n															<li>\n																<font size="2">我們所提供的產品配送區域僅限於台灣本島（外島地區的朋友請利用台灣親友地址做為收貨地址）。</font></li>\n															<li>\n																<font size="2">在確認交易條件無誤且有庫存後，商品將於您付款完成後的七個工作天內送達您指定的地址(雜誌/預購/訂製等特殊商品依網頁說明時間出貨)。</font></li>\n														</ul>\n													</li>\n												</ul>\n											</td>\n										</tr>\n									</tbody>\n								</table>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n<!--end04-->			</td>\n		</tr>\n	</tbody>\n</table>\n<!--商品運送 END--><!--其他說明 --><div class="Title1">\n	其他說明</div>\n<!--start05--><table align="left" border="0" cellpadding="0" cellspacing="0">\n	<tbody>\n		<tr>\n			<td width="25">\n				　</td>\n			<td>\n				　\n				<table width="560">\n<!--\n\n		  <tr>\n\n			<td>\n\n			<b><font size=2>特殊商品說明</font></b></td>\n\n		  </tr>\n\n		  <tr>\n\n			<td>\n\n			<ul>\n\n			  <li><font color="red" size="2">此商品為限制級商品，未滿18歲者不得購買。</font></li>\n\n			</ul>\n\n			</td>\n\n		  </tr>-->					<tbody>\n						<tr>\n							<td>\n								<b><font size="2">發票寄送</font></b></td>\n						</tr>\n						<tr>\n							<td>\n								<ul>\n									<li>\n										<ul>\n											<li>\n												<p>\n													<font size="2">由於商品配送皆由廠商直接寄出，發票會在付款完成、出貨後開立，並儲存為電子檔供您查看，您若需要正本，可隨使用馬上寄給我索取 (已捐贈、已索取的發票除外)，詳情請參考「發票託管流程說明」。</font></p>\n											</li>\n											<li>\n												<p>\n													<font size="2">三聯式發票、索取發票將會在廠商完成出貨後10個工作天寄出，約2-7個工作天內送達，如遇國定假日將順延寄送。 如您於收到訂購商品後20天仍未收到發票，請通知<a href="http://buy.yahoo.com.tw/help/helper.asp?p=cs" style="text-decoration: underline;">客服中心</a>。</font></p>\n											</li>\n											<li>\n												<font size="2">發票金額是扣除您使用購物金或福利金折抵後的淨額，若您使用購物金或福利金方式全額折抵，我們將不另行開立發票。</font></li>\n										</ul>\n									</li>\n								</ul>\n							</td>\n						</tr>\n						<tr>\n							<td>\n								<b><font size="2">售後服務</font></b></td>\n						</tr>\n						<tr>\n							<td>\n								<ul>\n									<li>\n										<ul>\n											<li>\n												<font size="2">若商品發生新品瑕疵之情形，您可申請更換新品，請參照<a href="http://buy.yahoo.com.tw/help/helper.asp?p=change" style="text-decoration: underline;">換貨詳細辦法</a>。</font></li>\n											<li>\n												<font size="2"><a href="http://buy.yahoo.com.tw/help/helper.asp?p=return" style="text-decoration: underline;">退貨詳細辦法</a>。</font></li>\n										</ul>\n									</li>\n								</ul>\n							</td>\n						</tr>\n						<tr>\n							<td>\n								<b><font size="2">客服中心</font></b></td>\n						</tr>\n						<tr>\n							<td>\n								<ul>\n									<li>\n										<ul>\n											<li>\n												<font size="2">若您對於購買、付款及運送方式有疑問，請參考<a href="http://buy.yahoo.com.tw/help/helper.asp" style="text-decoration: underline;">服務說明</a>，此外，您可直接透過<a href="https://buy.yahoo.com.tw/usertool/qrycrm.asp?to_url=qrycrm03&amp;gd_id=1850590" style="text-decoration: underline;">客服中心</a>詢問相關問題。</font></li>\n										</ul>\n									</li>\n								</ul>\n							</td>\n						</tr>\n					</tbody>\n				</table>\n			</td>\n		</tr>\n	</tbody>\n</table>', 1, 1);
INSERT INTO `chh_goods` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `sn`, `market`, `price`, `inventory`, `img`, `original_img`, `desc`, `is_show`, `sort`) VALUES
(2, 7, '測試商品01', '', '', 'CHH000002', '240.00', '200.00', 10, 'images/goods/1261396798737266718.jpg', 'images/goods/1261396798522244572.jpg', '<p>\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;<br />\n	測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp; 測試&nbsp;&nbsp;&nbsp;</p>', 1, 3),
(3, 7, '02', '', '', 'CHH000003', '1198.80', '999.00', 0, 'images/goods/1261397350169786338.jpg', 'images/goods/1261397350510986888.jpg', '<p>\n	02<br />\n	02<br />\n	03</p>', 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_goods_cat`
--

CREATE TABLE IF NOT EXISTS `chh_goods_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 轉存資料表中的資料 `chh_goods_cat`
--

INSERT INTO `chh_goods_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `img`, `original_img`, `is_show`, `lft`, `rgt`) VALUES
(1, '商品資訊', '', '', '', '', 1, 1, 26),
(2, '電腦資訊', '', '', '', '', 1, 2, 15),
(3, '消費電子', '', '', '', '', 1, 16, 23),
(4, '服裝', '', '', '', '', 1, 24, 25),
(5, 'NB', '', '', '', '', 1, 3, 4),
(6, 'PC', '', '', '', '', 1, 5, 6),
(7, '記憶卡碟', '', '', '', '', 1, 7, 8),
(8, '週邊', '', '', '', '', 1, 9, 10),
(9, '儲存', '', '', '', '', 1, 11, 12),
(10, 'LCD', '', '', '', '', 1, 13, 14),
(11, '數位相機', '', '', '', '', 1, 17, 18),
(12, '單眼', '', '', '', '', 1, 19, 20),
(13, '手機', '', '', '', '', 1, 21, 22);

-- --------------------------------------------------------

--
-- 表的結構 `chh_goods_img`
--

CREATE TABLE IF NOT EXISTS `chh_goods_img` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` mediumint(10) unsigned NOT NULL,
  `brief` varchar(50) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 轉存資料表中的資料 `chh_goods_img`
--

INSERT INTO `chh_goods_img` (`id`, `goods_id`, `brief`, `thumb`, `img`, `original_img`, `is_show`, `sort`) VALUES
(1, 1, '10', 'images/goods/1261381592889026096.jpg', 'images/goods/1261381592639877814.jpg', 'images/goods/1261381591983686729.jpg', 1, 1),
(2, 1, '02', 'images/goods/1261381635287276035.jpg', 'images/goods/1261381635100921974.jpg', 'images/goods/1261381635610341368.jpg', 1, 2),
(3, 1, '03', 'images/goods/1261382186880861631.jpg', 'images/goods/1261382186339555921.jpg', 'images/goods/1261382186128433637.jpg', 1, 3),
(4, 1, '04', 'images/goods/1261382186283655904.jpg', 'images/goods/1261382186683497792.jpg', 'images/goods/1261382186747317567.jpg', 1, 4),
(5, 1, '05', 'images/goods/1261384265451792662.jpg', 'images/goods/1261384265840744713.jpg', 'images/goods/1261384264625061990.jpg', 1, 5),
(6, 2, '01', 'images/goods/1261396885568201156.jpg', 'images/goods/1261396885887516895.jpg', 'images/goods/1261396885835133976.jpg', 1, 6),
(7, 2, '02', 'images/goods/1261396885135082778.jpg', 'images/goods/1261396885040623710.jpg', 'images/goods/1261396885297264506.jpg', 1, 7),
(8, 2, '03', 'images/goods/1261396885571728955.jpg', 'images/goods/1261396885519657458.jpg', 'images/goods/1261396885696845945.jpg', 1, 8),
(9, 2, '04', 'images/goods/1261396885315048562.jpg', 'images/goods/1261396885442474513.jpg', 'images/goods/1261396885331969471.jpg', 1, 9),
(10, 2, '05', 'images/goods/1261396885303563649.jpg', 'images/goods/1261396885065010643.jpg', 'images/goods/1261396885617742293.jpg', 1, 10),
(11, 2, '06', 'images/goods/1261396885302492866.jpg', 'images/goods/1261396885814590059.jpg', 'images/goods/1261396885161031193.jpg', 1, 11),
(12, 3, '01', 'images/goods/1261397350301875725.jpg', 'images/goods/1261397350633926065.jpg', 'images/goods/1261397350708376388.jpg', 1, 12),
(13, 3, '02', 'images/goods/1261397350208899813.jpg', 'images/goods/1261397350777216948.jpg', 'images/goods/1261397350036961202.jpg', 1, 13);

-- --------------------------------------------------------

--
-- 表的結構 `chh_guestbook`
--

CREATE TABLE IF NOT EXISTS `chh_guestbook` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(10) unsigned NOT NULL,
  `is_reply` tinyint(1) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- 轉存資料表中的資料 `chh_guestbook`
--

INSERT INTO `chh_guestbook` (`id`, `cat_id`, `name`, `email`, `phone`, `content`, `add_time`, `is_reply`, `is_show`, `sort`) VALUES
(1, 1, '測試', 'shsing1@yahoo.com.tw', '0123456789', '<p>\r\n	<span style="color: rgb(0, 0, 205);"><strong>測試</strong></span><br />\r\n	<span style="color: rgb(0, 100, 0);"><em><span style="font-size: 16px;">測試</span></em></span><br />\r\n	<span style="color: rgb(255, 0, 0);"><u><span style="font-size: 18px;">測試</span></u></span></p>', 1264405141, 0, 1, 1),
(2, 1, '111', 'shsing1@yahoo.com.tw', '0123456789', '<p>\n	<span style="color: rgb(218, 165, 32);"><u>444</u></span><br />\n	<span style="color: rgb(0, 0, 128);"><em><span style="font-size: 16px;">555</span></em></span><br />\n	<span style="color: rgb(255, 0, 0);"><strong><span style="font-size: 20px;">666</span></strong></span></p>', 1264405701, 0, 1, 2),
(3, 1, '111', 'shsing1@yahoo.com.tw', '0123456789', '<p>\n	333</p>\n<p>\n	444</p>\n<p>\n	555</p>', 1264406880, 0, 1, 3),
(4, 1, '222', 'shsing1@yahoo.com.tw', '0123456789', '<p>\n	555</p>\n<p>\n	666</p>\n<p>\n	888</p>', 1264406990, 0, 1, 4),
(5, 1, '路人甲', 'shsing999@gmail.com', '0123456789', '<p>\n	路人甲</p>\n<p>\n	路人甲</p>\n<p>\n	路人甲</p>\n<p>\n	路人甲</p>', 1269845325, 0, 1, 5),
(6, 1, '路人乙', 'shsing999@gmail.com', '0123456789', '<p>\n	路人乙</p>\n<p>\n	路人乙</p>\n<p>\n	路人乙</p>\n<p>\n	路人乙</p>', 1269845366, 0, 1, 6);

-- --------------------------------------------------------

--
-- 表的結構 `chh_guestbook_cat`
--

CREATE TABLE IF NOT EXISTS `chh_guestbook_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `chh_guestbook_cat`
--

INSERT INTO `chh_guestbook_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '留言版', '', '', 1, 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_guestbook_reply`
--

CREATE TABLE IF NOT EXISTS `chh_guestbook_reply` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `guestbook_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `content` text NOT NULL,
  `add_time` int(10) unsigned NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的結構 `chh_indexbg`
--

CREATE TABLE IF NOT EXISTS `chh_indexbg` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `main_title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `original_img` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_indexbg`
--

INSERT INTO `chh_indexbg` (`id`, `cat_id`, `name`, `main_title`, `sub_title`, `img`, `original_img`, `desc`, `is_show`, `sort`) VALUES
(1, 1, '01', '主標', '副標', 'images/indexbg/1379393136994952772.jpg', 'images/indexbg/1379393136352780413.jpg', '', 1, 1),
(2, 1, '02', '', '', 'images/indexbg/1379394625583432080.jpg', 'images/indexbg/1379394625940127706.jpg', '', 1, 2),
(3, 1, '03', '', '', 'images/indexbg/1379394889375991452.jpg', 'images/indexbg/1379394889087494056.jpg', '', 1, 3);

-- --------------------------------------------------------

--
-- 表的結構 `chh_indexbg_cat`
--

CREATE TABLE IF NOT EXISTS `chh_indexbg_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `chh_indexbg_cat`
--

INSERT INTO `chh_indexbg_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '首頁背景', '', '', 1, 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_marathon`
--

CREATE TABLE IF NOT EXISTS `chh_marathon` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_marathon`
--

INSERT INTO `chh_marathon` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `date`, `desc`, `is_show`, `sort`) VALUES
(1, 1, '活動說明', '', '', 1379347200, '<p>\r\n	活動說明</p>\r\n<p>\r\n	活動說明</p>\r\n<p>\r\n	活動說明</p>', 1, 1),
(2, 1, '全台超人徵召中', '', '', 1379347200, '<p>\r\n	全台超人徵召中</p>\r\n<p>\r\n	全台超人徵召中</p>\r\n<p>\r\n	全台超人徵召中</p>', 1, 2),
(3, 1, '1010超人國慶', '', '', 1379347200, '<p>\r\n	1010超人國慶</p>\r\n<p>\r\n	1010超人國慶</p>\r\n<p>\r\n	1010超人國慶</p>', 1, 3);

-- --------------------------------------------------------

--
-- 表的結構 `chh_marathon_cat`
--

CREATE TABLE IF NOT EXISTS `chh_marathon_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `chh_marathon_cat`
--

INSERT INTO `chh_marathon_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '1010國慶超人路跑', '', '', 1, 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_news`
--

CREATE TABLE IF NOT EXISTS `chh_news` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `date` int(10) unsigned NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- 轉存資料表中的資料 `chh_news`
--

INSERT INTO `chh_news` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `date`, `desc`, `is_show`, `sort`) VALUES
(1, 1, '國人愛用手機調查　Sony Ericsson奪冠', '國人愛用手機調查　Sony Ericsson奪冠', '國人愛用手機調查　Sony Ericsson奪冠', 1269792000, '<div class="w">\n	<div id="ynwsartcontent">\n		<table cellspacing="0" class="left">\n			<tbody>\n				<tr>\n					<td>\n						<label><a href="http://tw.news.yahoo.com/photo/url/d/i/100329/52/20100329_3554934/20100329_3554934.jpg.html"><img src="http://l.yimg.com/o/xp/cardu/20100329/03/3060653586.jpg" /></a></label></td>\n				</tr>\n			</tbody>\n		</table>\n		<p>\n			　　「手機」已是現代人生活的「必備品」，隨著科技日新月異，功能和外型也不斷推陳出新，原本只是拿來溝通、打電 話的工具，已搖身一變成為生活中的好幫手。而根據線上市調最新調查，2010年第1季國人最常使用的手機品牌為SonyEricsson，硬是擠下過去在 市場獨霸一方的Nokia，手機市場已起了重大變化。</p>\n		<p>\n			　　波仕特市調網最新調查發現，SonyEricsson已經攻下民眾最常使用的手機 品牌第一名，佔全體受訪者的33.68%，而Nokia則是以些微的差距(30.26%)拿下第二名。其次依序為Samsung和Motorola，則是 各佔約7%的支持率，遠遠落後於市場上第一、二名超過20%以上的支持度。</p>\n		<p>\n			　　特別的是，Motorola原本在台灣可以算是數一數二的手 機品牌，但是因為近幾年沒有推出「經典大作」，讓消費者的心漸漸被其它新穎機種給吸引，導致市佔率下滑，知名大廠光芒退去。</p>\n		<p>\n			　　至於國人購 買手機時考量的因素，最注重的項目前三名分別是「價格考量(70.87%)」、「功能性(61.91%)」、「外型設計(54.01%)」。價格和功能一 向是所有人在購買手機的最初考量，在相互比較CP值(價格性能比率)之後，挑出最划算的手機。</p>\n		<p>\n			　　在考量外型設計上，則是年輕人最重視的項 目，例如重視外型設計者以年紀輕的比例最高，且隨著年齡增長重視的比例愈往下降，可看出新一代希望與別人與眾不同，展現自我個性。</p>\n		<p>\n			　　近 來，智慧手機越來越「夯」，像是台灣大哥大及遠傳電信日前同步引進<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/52/22wg4.html?" id="yui-gen0" title="iPhone"><span>iPhone</span></a>，掀起「蘋果」大戰。不 過，這次調查卻顯示，iPhone排名落後，支持率僅佔1.06%，或許電信雙雄的加入，打破<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/52/22wg4.html?" id="yui-gen1" title="中華電信"><span>中華電信</span></a>獨賣模式，將能炒熱市場，帶動買 氣。</p>\n		<p>\n			　　其實，iPhone的使用率不高，也不令人意外，去(2009)年智慧手機銷量才佔全年手機銷售的15%，等於有高達85%都是一 般手機。推估原因，還是有不少民眾偏愛功能簡易的手機，像是不習慣使用觸控式螢幕要「拖來拉去」，或是太多的功能又太複雜。</p>\n		<p>\n			　　手機百百 款，有的人注重功能性、有些就是耍「酷炫」。隨著智慧手機熱燒，各大廠牌也面臨品牌忠誠度、研發技術的考驗，或許唯有不斷創新，才能滿足「胃口」越來越大 的消費者。</p>\n	</div>\n</div>', 1, 1),
(2, 1, '中國紹興 全球駭客大本營', '中國紹興 全球駭客大本營', '中國紹興 全球駭客大本營', 1269792000, '<p>\n	中國東部的紹興市被點名是全球網路間諜活動的大本營。美國知名網路安全公司賽門鐵克針對全球惡意電子郵件進行的追蹤研究，發現「有目標性的攻擊」電 腦的郵件，源自中國的數量比之前所認為的還要多，這些惡意郵件中，有將近三十％來自中國，其中有二十一．三％出自紹興這個城市。</p>\n<p>\n	賽門鐵克︰ 病毒郵件最大比率來自紹興</p>\n<p>\n	根據英國週日泰晤士報二十八日報導，正協助調查<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/78/22wgr.html?" id="yui-gen0" title="Google"><span>Google</span></a>遭入侵事件的賽門鐵克公 司追蹤一百二十億封電子郵件後，提出這樣的說法。研究發現，全球有目標性的<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/78/22wgr.html?" id="yui-gen1" title="駭客"><span>駭客</span></a>攻擊二十八．二％源自中國，其次是<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/78/22wgr.html?" id="yui-gen2" title="羅馬尼亞"><span>羅馬尼亞</span></a>，佔二十一．一％，美國第三，然 後是佔十二．九％的台灣，及佔十二％的英國。</p>\n<p>\n	這份研究是利用ＩＰ位址，找出這些攻擊郵件的真正來源。之前中國駭客曾經利用位於台灣的伺服器 隱藏身分。</p>\n<p>\n	這份研究也發現，這些駭客攻擊的重要目標如亞洲防衛政策的專家、人權運動人士等，強烈顯示有政府涉入這些駭客活動。</p>\n<p>\n	這 份報告說，網路間諜是利用小量寄出夾帶看似正常的附加檔案的電子郵件，騙過收件人點取後植入惡意程式碼滲透電腦，「終極目的&hellip;是針對特定個人或公司取得敏 感資料或進入內部安全系統。」</p>', 1, 2),
(3, 1, '防駭客　Google Gmail新增警報功能', '防駭客　Google Gmail新增警報功能', '防駭客　Google Gmail新增警報功能', 1269792000, '<div class="w">\n	<div id="ynwsartcontent">\n		<p>\n			Google在今年初遭到來源為中國的<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/17/22wrg.html?" id="yui-gen0" title="駭客"><span>駭客</span></a>攻擊，中國維權人士的Gmail帳號被入 侵後，<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/17/22wrg.html?" id="yui-gen1" title="Google"><span>Google</span></a>日前已為Gmail新增 警報功能，系統將自動偵測使用者登入的IP位址，如果原本自A國登入，數小時後又自B國登入，就會觸動警報系統，Gmail收件匣中將以紅底白字顯示警 告。</p>\n		<p>\n			Gmail新功能將提供可疑活動的細節給用戶，包括：最近使用哪一種瀏覽器、IP位址，以及最近登入帳號的時間與日期等。Gmail系 統會自動偵測使用者登入的IP位址，用來判斷使用者位置，雖然無法提供精準的所在地，但是至少知道國別。</p>\n		<p>\n			Gmail產品經理Will Cathcart指出：「如果你一向從某個國家登入，但突然間，另有人從地球另一邊登入，那就很可疑了」；此外，「如果系統偵測到某個特定的IP位址正存 取眾多帳號並更改這些帳號的密碼，也會觸動系統對受影響的帳號發出警告」。</p>\n		<p>\n			警告方式是大型橫幅警語，提醒原用戶「有人正從某地理區域存取你 的帳號」，使用者可以點擊警告「細節」連結，取得更詳細的資訊，並更改帳號密碼來防止他人入侵資料。此外，透過Gmail網頁下方的「最近帳戶活動」功 能，使用者可以檢視最近幾次登入該帳號的時間、IP位址、瀏覽器、行動裝置或POP3等存取方式。</p>\n	</div>\n</div>', 1, 3),
(4, 1, 'Apple iPad預購訂單保證交貨日延後1週', 'Apple iPad預購訂單保證交貨日延後1週', 'Apple iPad預購訂單保證交貨日延後1週', 1269792000, '<div class="w">\n	<div id="ynwsartcontent">\n		<p>\n			蘋果把平板電腦iPad預購訂單的保證交貨日期，延後一個禮拜。</p>\n		<p>\n			Apple平板電腦iPad將在美國時間這個星期六開始發售，依照 公司先前的說法，預購的消費者，也可以在四月三號iPad上市當天，就可以送貨到府，不過蘋果今天把預購訂單的保證交貨日期，延後到四月12號。</p>\n		<p>\n			蘋 果從三月12號開始接受消費者預購iPad，蘋果表示，在上週末以前下訂的消費者，都可以在下週六以前，拿到電腦，之後才下訂的人，恐怕要晚一個多禮拜才 能送貨到府。</p>\n		<p>\n			蘋果沒有說明拖延出貨是因為訂單數量超乎預期，還是生產進度落後。</p>\n		<p>\n			據估計， iPad四月三號發售以前，蘋果最多則可以準備好一百萬台，少的話，應該也有三十萬台。截至上星期五為止，iPad線上預購數量大概是24萬台。</p>\n	</div>\n</div>', 1, 4),
(5, 1, '與蘋果拆夥！AT&T自賣平板電腦OpenTablet尬iPad', '與蘋果拆夥！AT&T自賣平板電腦OpenTablet尬iPad', '與蘋果拆夥！AT&T自賣平板電腦OpenTablet尬iPad', 1269792000, '<div class="w">\n	<div id="ynwsartcontent">\n		<p>\n			AT&amp;T過去是蘋果<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/17/22wuj.html?" id="yui-gen0" title="iPhone"><span>iPhone</span></a>美國獨家代理商，不過雙 方似乎有拆夥意圖，在蘋果App Store自賣平板電腦iPad後，AT&amp;T也決定銷售一款採用新版<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/17/22wuj.html?" id="yui-gen1" title="英特爾"><span>英特爾</span></a>Atom處理器的平板電腦 「OpenTablet」，功能包括iPad主打的瀏覽多媒體內容外，還可作為家用監視器，用來追蹤能源消耗量和居家保全等。</p>\n		<p>\n			在日前拉斯維 加斯CTIA展上，AT&amp;T發表這款由佛羅里達州OpenPeak公司所設計的平板電腦，並公佈部分規格指，產品9x5英吋，厚0.59英吋，重 1.15磅，內附桌面基座，螢幕是7吋多點觸控LED背光面板、可連接HD電視的HDMI輸出口和靜態影像雙相機、一個USB與MicroSD插槽，支援 802.11b/g/n Wi-Fi和藍牙連線。</p>\n		<p>\n			AT&amp;T雖未說明OpenTablet的行銷細節，但根據英特爾官網稍早表示，這 項產品確定將「在今年稍後」、「透過多種零售通路」在全美上市。</p>\n		<p>\n			此外，<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/17/22wuj.html?" id="yui-gen2" title="華爾街"><span>華爾街</span></a>日報報導指出，iPad版華爾街日報 每月訂閱費為17.99<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/17/22wuj.html?" id="yui-gen3" title="美元"><span>美元</span></a>，高過華爾街日報線上版與紙版，甚至是線 上加紙版的售價，這種比傳統報紙還貴的價格遭批評是太荒謬了。</p>\n		<p>\n			華爾街日報目前促銷紙版每周訂閱價為2.29美元（每月約9.8美元），線上 版每周訂閱價格為1.99美元（每月約8.5美元），紙版加上線上版的每周訂閱價為2.69美元（每月約11.5美元），而iPad版竟要價每月 17.99美元，令人咋舌。</p>\n		<p>\n			科技<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/17/22wuj.html?" id="yui-gen4" title="部落格"><span>部落格</span></a>Geeky Gadgets認為，傳統報紙讀者轉向<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/17/22wuj.html?" id="yui-gen5" title="線上新聞"><span>線上新聞</span></a>來源的原因是因為這些內容更便 宜，如果主要報紙及雜誌平台在iPad上都採用類似華爾街日報的訂價策略，那麼應該會面臨銷售困境。</p>\n	</div>\n</div>', 1, 5),
(6, 1, 'iPad上市 打造蘋果網路王國', 'iPad上市 打造蘋果網路王國', 'iPad上市 打造蘋果網路王國', 1269792000, '<p>\n	蘋果iPad平板電腦首批將於四月三日出貨。全球資訊業界與消費者高度矚目，為什麼？很簡單，因為iPad出自史帝夫．賈伯斯領導下的蘋果公司。自 一九七六年賈伯斯推出個人電腦開始，到麥金塔、<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wf8.html?" id="yui-gen0" title="iPod"><span>iPod</span></a>、<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wf8.html?" id="yui-gen1" title="iPhone"><span>iPhone</span></a>，無一不掀起革命性風 潮。就連他買下皮克斯公司（Pixar），也讓動畫電影市場產生翻天覆地的變化。</p>\n<p>\n	熱炒搶手 年獲利25億美元</p>\n<p>\n	美國《新聞周 刊》指出，賈伯斯擁有一種不可思議的本領，把人們不曉得到底需不需要的產品炒熱，而後突然間，大家發現那些竟是生活中不可或缺。iPad是賈伯斯醞釀多年 的夢想，據說他接受換肝手術時，還心繫這項產品。他告訴身邊的人，iPad（見圖，取自網路）是他這輩子所做最重要的一件事。</p>\n<p>\n	iPad使用 iPhone的作業系統，比麥金塔電腦更容易操作。儘管有人說它不過是「放大版的iPhone」，改變不了什麼。可是一台只賣五百<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wf8.html?" id="yui-gen2" title="美元"><span>美元</span></a>，價格誘人，而且十五萬種小程式 （app）任君選擇。蘋果已接獲廿四萬台預購單，預計上市頭一年可賣出五百萬台，創造廿五億美元利潤。</p>\n<p>\n	革命趨勢 想取代報紙電視</p>\n<p>\n	iPad 操作容易，隱藏其下的是一股改變的力量，有人認為iPad將開啟電腦文化的新頁，今後人們使用電腦不再需要鍵盤和滑鼠，只需以手指碰觸螢幕。iPad強大 的網路功能，有朝一日可能取代電視機、報紙和書架。屆時蘋果也將搖身一變，成為擁有大批訂戶的有線電視公司。</p>\n<p>\n	更重要的是，iPad有望實現 賈伯斯更大的野心：建立一個完全由蘋果主宰的網路企業王國。蘋果不但賣你裝置，它的網路商店iTunes也是所需軟體的唯一來源。賈伯斯深信蘋果的產品好 到超乎想像，唯有封閉的系統，才能確保用戶享受到完美的使用經驗。</p>\n<p>\n	平板電腦 十年可達十億台</p>\n<p>\n	當然，封閉的系統也讓蘋果賺更多 錢，iTunes無論賣什麼，三○％利潤必定落入蘋果的口袋。進入蘋果世界，等於跟蘋果簽下浮士德式的交易，為了這些可愛的產品，你必須犧牲若干自由。例 如iPad上網只能使用蘋果的Safari瀏覽器，IE、Firefox一律謝絕，也不能觀看以Adobe公司Flash軟體製作的影片。</p>\n<p>\n	眼 見平板電腦旋風蓄勢待發，其他資訊業者當然爭先恐後，從<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wf8.html?" id="yui-gen3" title="Google"><span>Google</span></a>、戴爾（Dell）到惠 普（HP）莫不摩拳擦掌，業界估計十年內全球將出現十億台平板電腦。而蘋果則會將iPad「家族化」，從袖珍的口袋型到大如兩頁Ａ４的雜誌型，一應俱全。</p>', 1, 6),
(7, 1, '智慧手機上網量 增2倍', '智慧手機上網量 增2倍', '智慧手機上網量 增2倍', 1269792000, '<p>\n	隨著智慧型手機上網成主流，行動廣告公司AdMob表示，智慧型手機上網流量在過去1年內激增近2倍，其中，蘋果<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wex.html?" id="yui-gen0" title="iPhone"><span>iPhone</span></a>貢獻5成智慧型手機上網 流量，是最大贏家，目前仍是全球智慧型手機作業系統龍頭的Symbian，上網流量所佔比例較去年大減25％，是最大輸家。</p>\n<p>\n	全球智慧型手機 上網流量激增，AdMob表示，從2009年2月至2010年2月，這一年間光是智慧型手機上網流量就增加193％，在手機上網總流量比重，也由2009 年2月的35％，上升至2010年2月的48％。</p>\n<p>\n	在各種智慧型手機作業系統，全球蘋果iPhone用戶無疑是最愛用手機上網的一群人，光是 iPhone就貢獻50％的流量，比去年同期增加17個百分點，<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wex.html?" id="yui-gen1" title="Android"><span>Android</span></a>作業系統則貢獻 24％的上網流量，雖然還不到蘋果的一半，不過比起去年同期只佔2％來說，成長速度十分驚人。</p>\n<p>\n	相較於蘋果、RIM，智慧型手機上網流量市場 的最大輸家，則是Symbian與<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wex.html?" id="yui-gen2" title="微軟"><span>微軟</span></a>。根據AdMob資料，現在依然銷售量高 居全球智慧型手機作業系統一哥Symbian，透過Symbian手機上網的流量所佔比例，從去年2月43％大幅萎縮至今年的18％，微軟更只有2％，不 僅反映出微軟手機銷售委靡不振，也反映出現在的微軟智慧型手機作業系統無法滿足用戶對上網的需求。</p>\n<p>\n	值得注意的是，全球智慧型手機三哥 RIM，其黑莓機雖然稱霸行動電子郵件市場，不過透過RIM手機上網的流量卻只有佔智慧型手機總上網流量2％，這也代表，只要行動上網成為智慧型手機用戶 最重要的功能，RIM的地位就會岌岌可危。</p>\n<p>\n	在功能手機方面，雖然各界普遍認為，用戶不會透過功能手機上網，意外的是，功能手機上網流量也出 現成長，AdMob表示，功能手機上網流量比去年同期成長31％，不過由於還是趕不上手機上網的爆炸性成長速度，功能手機上網流量所貢獻的比重，還是比去 年2月下滑23個百分點、僅佔35％。</p>\n<p>\n	另外，MID已經成為行動上網不可小覷的新勢力。AdMob表示，過去1年來透過<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wex.html?" id="yui-gen3" title="iPod"><span>iPod</span></a> Touch、新力PSP與任天堂DSi上網的流量大幅成長403％，同時已經達到整體流量17％，比去年2月增加10個百分點。</p>', 1, 7),
(8, 1, '搜狐三路並進 搶奪大餅', '搜狐三路並進 搶奪大餅', '搜狐三路並進 搶奪大餅', 1269792000, '<p>\n	搜狐（SOHU）掌門人張朝陽接受媒體訪問時肯定地表示，<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wev.html?" id="yui-gen0" title="Google"><span>Google</span></a>離開中國後，留下一個非 常巨大的想像空間，對入口網站業者來說現在是搶進中國搜索引擎的最佳時機。</p>\n<p>\n	根據21世紀經濟報導，張朝陽自信地表示，2010年搜狐 （SOHU）將重點投資搜狗（Sogou）搜索，進攻搜索市場。他認為，搜狐是<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wev.html?" id="yui-gen1" title="創業"><span>創業</span></a>型公司，預算靈活，隨時可以加大投入。搜 狐於2006年推出搜狗搜索，在<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wev.html?" id="yui-gen2" title="百度"><span>百度</span></a>、Google兩雄並立的時代，搜狗沒有 獲得太多機會。Google撤出中國，張朝陽看到新機會，他認為，搜索引擎市場不可能一家獨大，搜狐2010年可能有機會獲得一個較大市場佔有率。</p>\n<p>\n	當 1月12日，Google高級副總裁和法律事務負責人宣布Google可能退出中國之際，搜狐就準備開始著手一旦Google離開中國後，要如何搶奪 Google的資產。</p>\n<p>\n	首先是收編Google廣告代理商。張朝陽解釋，為了收編更多Google的廣告代理商，搜狐今年1月調整了針對廣告 代理商的策略，其中包括調整廣告商轉戶政策、降低保證金額、提高分成比例等策略。</p>\n<p>\n	另一項策略是推廣更多本地化的應用與服務。百度流量超過半 數來自百度貼吧、音樂、百度知道、視頻搜索等本地化應用與服務。而搜狗輸入法是搜狐寄予厚望的一項本土化應用與服務。</p>\n<p>\n	張朝陽認為，與其他輸 入法不同，搜狗這款輸入法有自主知識產權，基於搜索積累線民經驗，可以識別長句，換句話說就是透過搜狗輸入法不是輸入字詞，而是輸入句子。</p>\n<p>\n	Google 員工也成為張朝陽收編的重點資產，Google員工現在身價很高，百度、騰訊、搜狐都在積極爭奪他們。不過，張朝陽也擔心Google員工不見得好用，因 為跨國公司的通病，就是沒有創業公司的激情。目前負責搜狐的搜索部門的員工超過400人。</p>', 1, 8),
(9, 1, 'Google與中國這一回合交手 孰勝孰敗', 'Google與中國這一回合交手 孰勝孰敗', 'Google與中國這一回合交手 孰勝孰敗', 1269792000, '<p>\n	Google創立於1998年，掌握著全世界使用率最高的搜尋引擎，這個會下金蛋的母雞，不只給它賺進大筆財富，也讓它在線上世界裡，佔有無遠弗屆 的影響力。</p>\n<p>\n	不過，Google的野心不僅限於網路世界，它希望能整合全球資訊，被全世界所用。不過，它在追求這個目標的過程中，種種積極的 作為，也引發許多爭議，豎立了不少敵人，從好萊塢到出版業者，電信到電子商務，與Google產生利益衝突的企業，愈來愈多。它在蒐集使用者資料和他們的 上網習慣這件事情上，表現出的莫大興趣，也令人不禁要擔心，會不會有一天，Google成為消費者隱私的威脅。</p>\n<p>\n	2006年，Google和 中國政府達成協議，Google同意把中國當局查禁的資訊，從搜尋結果中過濾掉之後，取得進入中國市場的許可，不過今年一月，Google以它的系統遭到<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/1/22wp0.html?" id="yui-gen1" title="駭客"><span>駭客</span></a>攻擊以及中國試圖限制網路言論自由為由， 表示不再接受網路審查，考慮退出中國市場。一個禮拜前，Google宣佈關閉Google中國搜尋網站，把服務中國網友的伺服器轉到香港，這個引起全球矚 目的行動，等於是當著全世界的面，甩中國一巴掌，它的後果很有可能就是失去擁有將近四億網民的全球最大網路市場。</p>\n<p>\n	Google為了網路審查 的問題，槓上中國，攤牌之後，它是欲走還留，盤算著可以用香港做據點，繼續在中國網路搜尋市場上，佔據一席之地，並且持續在中國從事網路廣告、作業系統、 智慧手機行銷的業務，但是，Google搞不清楚，這一招在中國是行不通的。</p>\n<p>\n	俄亥俄州立大學商學院教授（申卡爾）說，在中國，所謂的自由市 場競爭，只是虛有其表，因為在任何狀況下，中國當局都不會容許企業利益，超越國家和黨的政治利益，如果企業理念符合政府立場，那就好辦，假使不，當局會確 保業者修正作法，它們有得是辦法逼你就範。</p>\n<p>\n	Google有多大能耐，可以改變中國市場的遊戲規則，得看他手上握有多少籌碼，它有沒有中國迫 切需要的技術，它或許有，也可能中國已經取得了一些。</p>\n<p>\n	Google退出中國，突顯出跨國企業在中國市場的處境，日益艱難，其實許多企業已經 知道或者是正在逐漸發覺這個狀況。不過，撇開意識形態，就某些方面來說，<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/1/22wp0.html?" id="yui-gen2" title="日本"><span>日本</span></a>和<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/1/22wp0.html?" id="yui-gen3" title="南韓"><span>南韓</span></a>的市場，對外國企業設限其實比中國還要 多。</p>\n<p>\n	Google與中國的爭執，某種程度上，也代表了美國和中國政府的對立，美國高喊的網路自由口號，聽起來冠冕堂皇，不過它真正的目的， 不外是想替美國企業、特別是美國掌握了競爭優勢的行業，在海外市場上攻城掠地。在利益掛帥的商業領域中，絕大多數業者都願意配合在地的規定，不管它有多困 難，所以，要冀望Google事件在挑戰中國政策上，發揮多大作用，恐怕是不切實際，</p>\n<p>\n	Google在中國市場進行了四年的網路實驗，試圖把 西方對言論自由的標準，移植到中國，這個實驗以失敗、至少是暫時失敗告終，公開的原因是因為雙方在資訊自由上，理念不和，但是事實上，Google也早就 發現自己對中國市場力有未逮，不只Google，包括Yahoo和eBay等美國其他大型網路業者，在中國的表現，都不如人意。</p>\n<p>\n	在中國市場 上，最成功的還是<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/1/22wp0.html?" id="yui-gen4" title="百度"><span>百度</span></a>、騰訊和阿里巴巴之類的在地業者，它們成 功的原因很簡單，中國主力網民，不只在網路上搜尋資訊，也搜尋一種生活方式，他們對下載音樂、玩線上遊戲以及在社交網站上交友，懷抱無比的熱情。中國的網 路使用者，年齡在三十歲以下的，佔了六成，美國則完全不是那麼回事，網路對美國人最大的意義，在於資訊的提供，而中國人使用網路，最大的目的是娛樂。美國 網路業者無法征服中國市場，一方面是因為它們對中國市場不夠了解，再者適應的速度也太慢，而且它們也不懂得如何和中國當局打交道。</p>\n<p>\n	對中國產 業發展而言，Google退出很有可能讓中國網路發展陷入停滯，在網路科技領域，Google一直是扮演著引領創新的角色，而現階段的中國網路產業，還處 於跟隨流行的階段，它複製的能力很強，君不見山寨文化在中國被發揮到多麼的淋漓盡致，Google離開後，少了一個競爭者，大家分到的餅，肯定可以大一 點，但是缺乏外來競爭的驅使，可能也會阻礙中國網路業者進步，讓他們更難晉身世界級企業，競逐海外市場，也有人說，中國有四億網民，它們賺自己人的錢就夠 了，誰希罕海外市場，你瞧，在沒有Facebook競爭下，大陸本土的社交網站開心網，不也吸引了七千多萬人註冊，不過專家說，Google離開，剝奪了 網民的選擇權，這勢必會讓中國網路市場，愈來愈封閉，最大的輸家，還是廣大的中國網民。再怎麼說，Google還是一個多語言的搜尋引擎，而百度只提供中 文搜尋，在浩瀚的網路上，中文資訊畢竟只佔了一小部份。語言限制再加上資訊審查，讓百度變點有點像政府的佈告欄。</p>\n<p>\n	Google事件對極力想 提升軟實力的中國當局來說，也是個形象傷害，中國領導人當然知道，不過現階段的中國，維持絕對統治，依然是中共最優先目標，它不會為了任何顧慮，而鬆動它 對政治的掌控。</p>', 1, 9),
(10, 1, '「殭屍網絡」攻擊 從非洲發動', '「殭屍網絡」攻擊 從非洲發動', '「殭屍網絡」攻擊 從非洲發動', 1269792000, '<p>\n	美國《外交政策》（Foreign Policy）雜誌報導，隨著寬頻逐漸普及，加上電腦使用者多未安裝防毒軟體，<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wf9.html?" id="yui-gen0" title="非洲"><span>非洲</span></a>已然成為網路犯罪的新溫床，有心者若以病 毒劫持非洲一千萬<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wf9.html?" id="yui-gen1" title="台電"><span>台電</span></a>腦，便可以網路版的大規模毀滅性武器： 「殭屍網絡」（botnet）攻擊全世界，讓全球十大先進經濟體瞬間「當機」。</p>\n<p>\n	二○○八年<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wf9.html?" id="yui-gen2" title="象牙海岸"><span>象牙海岸</span></a>一項網路安全會議資料顯示，非洲 網路犯罪率急遽上升，遠超乎全球其它各洲，估計全非洲約有八○％的個人電腦已遭病毒入侵或被植入惡意程式。歐美先進國家或以為此問題事不關己，然而，當非 洲海底寬頻電纜舖設完成後，在網路虛擬世界中，紐約與非洲近在咫尺。</p>\n<p>\n	簡單的說，有不良意圖的<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wf9.html?" id="yui-gen3" title="駭客"><span>駭客</span></a>或犯罪集團可透過一套中央控制系統，在電 腦主人毫不知情下，劫持全非洲的電腦，並將垃圾郵件或病毒強制轉寄至其它連線上網的電腦，從而組建一支強大的「僵屍電腦」大軍，隨時可對外發動駭客攻擊。 據世界銀行統計，非洲總人口中有約八○％缺乏基本的資訊科技知識，加上非洲網咖中的電腦多未安裝防毒軟體，以及多數非洲國家網路犯罪法令闕如，更間接助長 網路犯罪持續增溫。</p>\n<p>\n	《網路戰爭內幕》作者卡爾（Jeffrey Car）指出：「劫持一百萬台電腦的殭屍網絡，便可產生足夠流量讓多數名列美國《財星》雜誌前五百大企業當機；而挾持一千萬台電腦，更可癱瘓西方先進國家 的網路基礎建設。」</p>\n<p>\n	如今全非洲約有一千萬台電腦，一旦淪為「殭屍網絡首腦」（botnet herder）的首要目標，在高速寬頻網路積極布建的助威之下，恐將造成極大的災難。</p>', 1, 10),
(11, 1, '無線通訊－行動上網流量 首度超越通話量', '無線通訊－行動上網流量 首度超越通話量', '無線通訊－行動上網流量 首度超越通話量', 1269792000, '<p>\n	易利信在拉斯維加斯舉行的2010年美國無線通訊展中指出，在2009年12月期間，全球行動資料流量首度超越語音流量。這意味著行動寬頻上網已成 為愈來愈多人生活的一部份。</p>\n<p>\n	易利信調查顯示，全球資料流量在過去兩年內，以每年280%的速度成長，預計在未來5年，每年將以2倍增加。當 愈來愈多的消費者開始使用智慧型手機、小筆電，資料流量將會明顯增加，量測結果還顯示，同一時期3G網路流量也超越了2G網路。</p>\n<p>\n	易利信執行 長魏翰思指出，近4億行動寬頻用戶的資料流量，已經正式超越46億行動用戶所產生的語音流量，這是一項重大的里程碑。隨時隨地上網擁有極大的吸引力，它將 促進行動寬頻持續成長。</p>', 1, 11),
(12, 1, 'WEF資訊科技排名 台灣小升', 'WEF資訊科技排名 台灣小升', 'WEF資訊科技排名 台灣小升', 1269792000, '<p>\n	世界經濟論壇(WEF)2010年全球資訊科技報告指出，在受調查的133國中，台灣IT企業專利使用世界第一，但IT相關法規效率則排名75，寬 頻網路費率合宜度全球第6，手機費率合宜度卻是全球第90名，更嚴重的是：執行合約所需要的手續數目，居然排名第120，屬於全球最後段班，被WEF特別 點名。</p>\n<p>\n	也因此，加總WEF調查的資訊科技環境、政策、使用等70細項的分數，即全球通用的網路整備度（Networked Readiness Index, NRI），全球排名雖連續3年上升，從2008年的17名，2009年13名，到今年的第11名，但仍在10強止步。</p>\n<p>\n	WEF 調查已進行9年時間，台灣僅有1次記錄是排名下滑的。WEF資深經濟學家Irene Mia指出，ICT是推動經濟和社會轉型的動力來源，為各國衡量資訊社會進展的重要參考，現在更需導引為永續發展的觸媒。</p>\n<p>\n	台灣NRI在亞 洲，排名多年來都居於<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wfp.html?" id="yui-gen0" title="新加坡"><span>新加坡</span></a>、香港之後，現在看來，NRI的全球 名次上升更有放緩跡象；而韓國已連續第3年退步，亞洲大國<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22wfp.html?" id="yui-gen1" title="日本"><span>日本</span></a>從去年的第17名掉到今年第21名，中國 每年幾乎都進步10名，09年第46名，今年已是第37名。</p>', 1, 12),
(13, 1, '谷歌3成市占 搜狐「能接多少接多少」', '谷歌3成市占 搜狐「能接多少接多少」', '谷歌3成市占 搜狐「能接多少接多少」', 1269792000, '<p>\n	全球最大搜尋引擎業者谷歌退出大陸市場，轉進香港後，留下三○％市占率給其他網路搜尋業者；彼岸三大入口網站之一的搜狐，最近將二○一○年定為旗下 「搜狗搜索」的重新出發年。首席執行官張朝陽說，搜狐會爭取市場，並強化技術創新。</p>\n<p>\n	面對谷歌退出後留下的龐大市場空間，多日來，大陸網路巨 頭基本保持沉默並未張揚，搜狐是第一家跳出來表態的業者。張朝陽表示，「後谷歌時代」中國市場不會一家壟斷； 創新方面，中國本土互聯網公司毫不遜色，中國本土企業通過市場競爭和優秀的人才同樣能夠創新。</p>\n<p>\n	目前，大陸網路搜尋引擎排名前三大的分別是<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22waw.html?" id="yui-gen0" title="百度"><span>百度</span></a>、谷歌及搜搜（騰訊），搜狗（搜狐所有） 及<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/4/22waw.html?" id="yui-gen1" title="微軟"><span>微軟</span></a>的必應（Bing）相差無幾。</p>\n<p>\n	為 吃下谷歌留下的市場，搜狐不僅強化技術與市場投入，張朝陽透露，搜狗已開始和谷歌的國內廣告代理商談判，其中包括轉戶政策，降低開放資金，關鍵字投放介面 轉移等細節，搜狗的原則是能接多少就接多少。</p>\n<p>\n	除搜狗之外，其餘搜尋業者都將借助它們各自累積的用戶群和財力，在大陸互聯搜尋引擎市場中力爭 上游。</p>\n<p>\n	至於大陸最大搜尋引擎業者百度董事長李彥宏則表示，谷歌的搜尋服務移到香港後，百度不會在搜索領域中一家獨大，原因在於這個產業仍在 快速成長，網路進入門檻又不高，所以未來搜索產業仍會競爭激烈。</p>', 1, 13),
(14, 1, '日本發明手機鈴聲療法', '日本發明手機鈴聲療法', '日本發明手機鈴聲療法', 1347797005, '<div class="w">\r\n	<div id="ynwsartcontent">\r\n		<p>\r\n			日本在手機應用科技的領域上，居於全球領先地位，<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/1/22x0l.html?" id="yui-gen0" title="日本"><span>日本</span></a>人可以用手機看電視，消費的時候，用手機 刷卡，現在日本人的手機，又多了一個用途，它可以治病。</p>\r\n		<p>\r\n			春天來了，日本的櫻花開了，不過鼻子過敏的人，鼻子又要塞了，一家手機科技應用技術 研發公司，宣稱它們研發出花粉熱的鈴聲療法，它們會叩out給患者，手機鈴聲響起的時候，患者只要把手機湊近鼻子，花粉就會一掃而空。</p>\r\n		<p>\r\n			業者 還宣稱手機鈴聲還可以幫你<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/1/22x0l.html?" id="yui-gen1" title="減肥"><span>減肥</span></a>，科學家說，這種療法沒有科學根據，不過 許多使用過的人卻宣稱有效。</p>\r\n	</div>\r\n</div>', 1, 14),
(15, 1, '百萬戶裝智慧電表　網通廠搶商機', '百萬戶裝智慧電表　網通廠搶商機', '百萬戶裝智慧電表　網通廠搶商機', 1379325786, '<p>\r\n	行政院規劃<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/5/22wz2.html?" id="yui-gen0" title="台電"><span>台電</span></a>在2015年前推動100萬戶裝設智慧電 表，台灣部分網通廠去年起切入智慧電表市場，並已有實績展現，可望直接受惠這波商機。</p>\r\n<p>\r\n	行政院預計2012年先選定1萬戶換裝智慧電表，取代 傳統電表，2013至2015年再完成100萬戶裝置；中期視智慧電表裝置效益，建置率以50%即600萬戶規劃換裝為目標。</p>\r\n<p>\r\n	台灣網通廠包 括訊舟科技、中磊電子、正文科技皆已開發智慧電網相關產品，其中，訊舟去年開始出貨給<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/5/22wz2.html?" id="yui-gen1" title="日本"><span>日本</span></a>電力公司客戶，今年第二季出貨量可望放 大，在日本部分地區試行順利下，商機可望擴展至其他地區。</p>\r\n<p>\r\n	中磊則與歐洲電力公司合作，開發電力管理系統，透過網路傳輸管理並分析家中用電狀 況，已陸續出貨，且市場也傳出公司與電信業者合作跨入智慧電網應用。</p>\r\n<p>\r\n	此外，正文宣布與美國On-Ramp Wireless公司結盟，協力生產智慧無線通訊系統產品Ultra-LinkProcessing(ULP)，正式跨入智慧電網通訊市場，並取得On- Ramp亞洲市場產品銷售獨家代理權，也是智慧電網概念股之一。</p>\r\n<p>\r\n	拓墣產業研究所表示，各國政府相繼投入數位化電網與先進電表計畫，未來智慧 型電表可望倍數成長，資訊工業策進會產業情報研究所 (MIC)更預估，2012年光台灣所衍生的智慧電網商機即高達新<a class="ynwsyq yqclass" href="http://tw.news.yahoo.com/article/url/d/a/100329/5/22wz2.html?" id="yui-gen2" title="台幣"><span>台幣</span></a>600億元。</p>', 1, 15);

-- --------------------------------------------------------

--
-- 表的結構 `chh_news_cat`
--

CREATE TABLE IF NOT EXISTS `chh_news_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 轉存資料表中的資料 `chh_news_cat`
--

INSERT INTO `chh_news_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, '最新動態', '', '', 1, 1, 2);

-- --------------------------------------------------------

--
-- 表的結構 `chh_qa`
--

CREATE TABLE IF NOT EXISTS `chh_qa` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 轉存資料表中的資料 `chh_qa`
--

INSERT INTO `chh_qa` (`id`, `cat_id`, `name`, `meta_keywords`, `meta_description`, `desc`, `is_show`, `sort`) VALUES
(1, 2, '國慶超人路跑活動是甚麼阿？', '', '', '上個月跑了二場半程馬拉松繼去年底參加了第一場半程馬拉松（2012台北富邦馬拉松）之後，今年三月又報名了 台北自去年夏天練跑以來，這幾個月幾乎每個月都至少維持50KM的路量。', 1, 1),
(2, 2, '參加者有年齡限制嗎？', '', '', '開心自由的奔跑，沒有壓力、沒有束縛、調劑身心，促進身體健康，只要喜歡路跑的朋友們都可參加！', 1, 2),
(3, 3, '問題01', '', '', '答案01', 1, 3),
(4, 3, '問題1', '', '', '答案2', 1, 4);

-- --------------------------------------------------------

--
-- 表的結構 `chh_qa_cat`
--

CREATE TABLE IF NOT EXISTS `chh_qa_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 轉存資料表中的資料 `chh_qa_cat`
--

INSERT INTO `chh_qa_cat` (`id`, `name`, `meta_keywords`, `meta_description`, `is_show`, `lft`, `rgt`) VALUES
(1, 'Q&A', '', '', 1, 1, 10),
(2, '國慶超人路跑活動', '', '', 1, 2, 3),
(3, '關於活動費用 / 匯款 / 退款疑慮', '', '', 1, 4, 5),
(4, '關於新竹藝動節節目內容？', '', '', 1, 6, 7),
(5, '交通問題', '', '', 1, 8, 9);

-- --------------------------------------------------------

--
-- 表的結構 `chh_sessions`
--

CREATE TABLE IF NOT EXISTS `chh_sessions` (
  `sesskey` char(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL DEFAULT '',
  `expiry` int(10) unsigned NOT NULL DEFAULT '0',
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `adminid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `ip` char(15) NOT NULL DEFAULT '',
  `user_name` varchar(60) NOT NULL,
  `user_rank` tinyint(3) NOT NULL,
  `discount` decimal(3,2) NOT NULL,
  `email` varchar(60) NOT NULL,
  `data` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`sesskey`),
  KEY `expiry` (`expiry`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- 轉存資料表中的資料 `chh_sessions`
--

INSERT INTO `chh_sessions` (`sesskey`, `expiry`, `userid`, `adminid`, `ip`, `user_name`, `user_rank`, `discount`, `email`, `data`) VALUES
('41ae5380e56bc425535a9808db37b93e', 1379661704, 0, 1, '127.0.0.1', '0', 0, '0.00', '0', 'a:4:{s:12:"admin_cat_id";s:1:"2";s:10:"admin_name";s:7:"shsing1";s:11:"action_list";s:3:"all";s:10:"last_check";s:0:"";}'),
('c5e0c2ad37b3f577dd6f2c81113667bf', 1379663450, 0, 3, '127.0.0.1', '0', 0, '1.00', '0', 'a:6:{s:10:"login_fail";i:0;s:12:"admin_cat_id";s:1:"3";s:10:"admin_name";s:6:"cyarat";s:11:"action_list";s:0:"";s:10:"last_check";s:0:"";s:12:"captcha_word";s:16:"ZmMxNWEzMGVmMg==";}'),
('a7f921bc46de1cf1f7a8d3ab09081eb0', 1379663292, 0, 1, '127.0.0.1', '0', 0, '1.00', '0', 'a:6:{s:12:"admin_cat_id";s:1:"2";s:10:"admin_name";s:7:"shsing1";s:11:"action_list";s:3:"all";s:10:"last_check";s:0:"";s:10:"login_fail";i:0;s:12:"captcha_word";s:16:"OTdkMjU1ZWQzMQ==";}'),
('5b9f5bf393a1ce0d6987bf72ac075939', 1379661705, 0, 1, '127.0.0.1', '0', 0, '0.00', '0', 'a:4:{s:12:"admin_cat_id";s:1:"2";s:10:"admin_name";s:7:"shsing1";s:11:"action_list";s:3:"all";s:10:"last_check";s:0:"";}'),
('185c6418345c519fb43f93342847f3c1', 1379661705, 0, 1, '127.0.0.1', '0', 0, '0.00', '0', 'a:4:{s:12:"admin_cat_id";s:1:"2";s:10:"admin_name";s:7:"shsing1";s:11:"action_list";s:3:"all";s:10:"last_check";s:0:"";}'),
('d94140bb99a3213271d5cc3bb25c21b5', 1379661705, 0, 1, '127.0.0.1', '0', 0, '0.00', '0', 'a:4:{s:12:"admin_cat_id";s:1:"2";s:10:"admin_name";s:7:"shsing1";s:11:"action_list";s:3:"all";s:10:"last_check";s:0:"";}');

-- --------------------------------------------------------

--
-- 表的結構 `chh_sys_menu`
--

CREATE TABLE IF NOT EXISTS `chh_sys_menu` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `is_chh` tinyint(1) NOT NULL DEFAULT '0',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- 轉存資料表中的資料 `chh_sys_menu`
--

INSERT INTO `chh_sys_menu` (`id`, `name`, `url`, `is_chh`, `lft`, `rgt`) VALUES
(1, '系統選單', '', 0, 1, 102),
(2, '系統選單管理', '', 1, 2, 5),
(3, '資料管理', 'sys_menu.php', 1, 3, 4),
(4, '關於藝動節', '', 0, 12, 17),
(5, '分類管理', 'about_us_cat.php', 0, 13, 14),
(6, '資料管理', 'about_us.php', 0, 15, 16),
(7, '最新動態', '', 0, 28, 33),
(8, '分類管理', 'news_cat.php', 1, 29, 30),
(9, '資料管理', 'news.php', 0, 31, 32),
(10, '網站相簿', '', 0, 34, 39),
(11, '分類管理', 'gallery_cat.php', 0, 35, 36),
(12, '資料管理', 'gallery.php', 0, 37, 38),
(13, '權限管理', '', 0, 40, 45),
(14, '管理員分類', 'admin_cat.php', 1, 41, 42),
(15, '管理員列表', 'admin.php', 0, 43, 44),
(16, '系統設置', '', 0, 46, 53),
(17, '分類管理', 'config_cat.php', 1, 47, 48),
(18, '資料管理', 'config.php', 1, 49, 50),
(19, '網站設置', 'config_set.php', 0, 51, 52),
(20, '檔案下載', '', 0, 54, 59),
(21, '分類管理', 'download_cat.php', 1, 55, 56),
(22, '資料管理', 'download.php', 0, 57, 58),
(23, '聯絡我們', '', 0, 60, 65),
(24, '分類管理', 'contact_cat.php', 1, 61, 62),
(25, '資料管理', 'contact.php', 0, 63, 64),
(26, '留言版', '', 0, 66, 71),
(27, '分類管理', 'guestbook_cat.php', 1, 67, 68),
(28, '資料管理', 'guestbook.php', 0, 69, 70),
(29, '會員管理', '', 0, 72, 77),
(30, '分類管理', 'user_cat.php', 0, 73, 74),
(31, '資料管理', 'user.php', 0, 75, 76),
(32, '自定義畫面', '', 0, 78, 83),
(33, '分類管理', 'custom_cat.php', 1, 79, 80),
(34, '資料管理', 'custom.php', 0, 81, 82),
(35, '商品管理', '', 0, 84, 89),
(36, '分類管理', 'goods_cat.php', 0, 85, 86),
(37, '資料管理', 'goods.php', 0, 87, 88),
(38, '電子報管理', '', 0, 90, 101),
(39, '訂閱名單分類', 'epaper_user_cat.php', 1, 91, 92),
(40, '訂閱名單', 'epaper_user.php', 0, 93, 94),
(41, '電子報分類', 'epaper_cat.php', 1, 95, 96),
(42, '電子報資料', 'epaper.php', 0, 97, 98),
(43, '發送隊列', 'epaper_queue.php', 0, 99, 100),
(44, '首頁背景', '', 0, 6, 11),
(45, '分類管理', 'indexbg_cat.php', 1, 7, 8),
(46, '資料管理', 'indexbg.php', 0, 9, 10),
(47, '1010國慶超人路跑', '', 0, 18, 27),
(48, '分類管理', 'marathon_cat.php', 1, 19, 20),
(49, '資料管理', 'marathon.php', 0, 21, 22),
(50, 'Q&A分類', 'qa_cat.php', 0, 23, 24),
(51, 'Q&A資料', 'qa.php', 0, 25, 26);

-- --------------------------------------------------------

--
-- 表的結構 `chh_user`
--

CREATE TABLE IF NOT EXISTS `chh_user` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` mediumint(10) unsigned NOT NULL DEFAULT '1',
  `name` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` varchar(32) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `birthday` int(10) NOT NULL,
  `office_phone` varchar(20) NOT NULL,
  `home_phone` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `reg_time` int(10) unsigned NOT NULL,
  `last_login` int(10) unsigned NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `visit_count` smallint(5) unsigned NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `sort` mediumint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 轉存資料表中的資料 `chh_user`
--

INSERT INTO `chh_user` (`id`, `cat_id`, `name`, `email`, `password`, `sex`, `birthday`, `office_phone`, `home_phone`, `mobile`, `reg_time`, `last_login`, `last_ip`, `visit_count`, `is_show`, `sort`) VALUES
(7, 1, 'guest', 'shsing1@yahoo.com.tw', '6a40a5c1b15e7e2d62b1da3ebf7507fc', 0, 633196800, '1111111111', '2222222222', '3333333333', 0, 1271581844, '127.0.0.1', 41, 1, 7);

-- --------------------------------------------------------

--
-- 表的結構 `chh_user_cat`
--

CREATE TABLE IF NOT EXISTS `chh_user_cat` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `is_show` tinyint(1) NOT NULL DEFAULT '1',
  `lft` mediumint(20) unsigned NOT NULL,
  `rgt` mediumint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 轉存資料表中的資料 `chh_user_cat`
--

INSERT INTO `chh_user_cat` (`id`, `name`, `is_show`, `lft`, `rgt`) VALUES
(1, '會員管理', 1, 1, 6),
(2, '一般會員', 1, 2, 3),
(3, 'vip', 1, 4, 5);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
