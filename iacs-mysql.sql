-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2015 at 12:07 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `iacs_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_name` varchar(100) NOT NULL,
  `client_address` varchar(200) NOT NULL DEFAULT '',
  `client_phone` varchar(11) NOT NULL DEFAULT '',
  `client_fax` varchar(11) NOT NULL DEFAULT '',
  `client_email` varchar(256) NOT NULL DEFAULT '',
  `client_webSite` varchar(2048) NOT NULL DEFAULT '',
  `client_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `client_name`, `client_address`, `client_phone`, `client_fax`, `client_email`, `client_webSite`, `client_delete`) VALUES
(1, 'בנק הפועלים', 'שדרות רוטשילד 50 תל אביב', '03-5673333', '11-1111111', 'audit@hapohalim.co.il', 'http://www.hapohalim.co.il', 0),
(2, 'רפאל', 'תד 2250 חיפה', '04-8794444', '22-2222222', '', 'http://www.rafael.co.il/', 0),
(10, 'בנק דיסקונט', 'יהודה הלוי 23, תל אביב', '03-9439111', '', 'audit@discount.co.il', 'www.discountbank.co.il', 0),
(11, 'כלל ביטוח', 'מנחם בגין 48 תל אביב', '03-6387777', '', 'audit@clalbit.co.il', 'www.clalbit.co.il', 0),
(13, 'עיריית ירושלים', 'כיכר ספרא 1 ירושלים', '02-6297777', '', 'audit@jerusalem.muni.il', 'www.jerusalem.muni.il', 0),
(14, 'רון דדון', 'אביגדור המאירי 10, חיפה', '052-5508321', '', 'rondadon1@gmail.com', 'www.rondadon.co.il', 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_client` int(11) NOT NULL,
  `invoice_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoice_receipt` varchar(50) NOT NULL DEFAULT '',
  `invoice_tax` varchar(50) NOT NULL DEFAULT '',
  `invoice_note` text NOT NULL,
  `invoice_quote` int(11) NOT NULL,
  `invoice_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_id`),
  KEY `invoice_client` (`invoice_client`),
  KEY `invoice_quote` (`invoice_quote`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_client`, `invoice_date`, `invoice_receipt`, `invoice_tax`, `invoice_note`, `invoice_quote`, `invoice_delete`) VALUES
(1, 14, '2015-06-18 17:55:43', '987', '876', '', 12, 0),
(5, 13, '2015-06-20 00:00:00', '1', '1', '', 11, 1),
(6, 13, '2015-06-20 00:00:00', '', '', '', 11, 1),
(7, 13, '2015-07-20 00:00:00', '234', '345', '', 11, 0),
(8, 11, '2015-06-20 00:00:00', '', '', 'Wrong data before', 13, 0),
(9, 2, '2015-06-20 00:00:00', '', '', 'אישור של 20% הנחה לצורך סגירת עסקה לשנתיים', 10, 0),
(10, 1, '2015-06-20 00:00:00', '', '', '', 14, 1),
(11, 1, '2015-06-20 00:00:00', '1', '', '', 14, 0),
(12, 1, '2015-06-21 00:00:00', '1', '1', '', 15, 1),
(13, 1, '2015-06-21 00:00:00', '', '', '', 16, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_products`
--

CREATE TABLE IF NOT EXISTS `invoice_products` (
  `invoice_product_product` int(11) NOT NULL,
  `invoice_product_invoice` int(11) NOT NULL,
  `invoice_product_quantity` int(11) NOT NULL DEFAULT '1',
  KEY `invoice_product_product` (`invoice_product_product`),
  KEY `invoice_product_invoice` (`invoice_product_invoice`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `licenses`
--

CREATE TABLE IF NOT EXISTS `licenses` (
  `license_id` int(11) NOT NULL AUTO_INCREMENT,
  `license_serial` varchar(64) NOT NULL,
  `license_product` int(11) NOT NULL,
  `license_client` int(11) DEFAULT NULL,
  `license_invoice` int(11) DEFAULT NULL,
  `license_type` int(11) NOT NULL,
  `license_creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `license_expire` datetime NOT NULL,
  `license_pcid` varchar(2048) DEFAULT NULL,
  `license_hash` varchar(2048) DEFAULT NULL,
  `license_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`license_id`),
  KEY `license_product` (`license_product`),
  KEY `license_client` (`license_client`),
  KEY `license_type` (`license_type`),
  KEY `license_invoice` (`license_invoice`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `licenses`
--

INSERT INTO `licenses` (`license_id`, `license_serial`, `license_product`, `license_client`, `license_invoice`, `license_type`, `license_creationDate`, `license_expire`, `license_pcid`, `license_hash`, `license_delete`) VALUES
(2, '8f118d856ad64ed48b394d97fb8dd0b6', 1, 1, 11, 1, '2015-06-21 00:00:00', '2015-06-20 00:00:00', NULL, NULL, 0),
(3, '3710cc7629d34421b2593c7ee4cf7a54', 2, 13, 7, 1, '2015-06-21 00:00:00', '2015-12-31 00:00:00', NULL, NULL, 0),
(7, '09d914297de448d7acc776fae2b5413e', 11, 1, NULL, 1, '2015-06-21 00:00:00', '2015-08-21 00:00:00', '4d399e3bd41a38e16648bfa950a229ec314b4ed1d711372324d515c0c7173b8a5b374e1388097506f3045ce9316275de1b665ecf63770f4d42b662829e037a29', '0833935243ce13cef83dca082cf4710b8ca58b0660cfa68923681d11e77144dd6ad7824705df6c19cd3caf1a7c583ca574715286fde662beab12028fa9eda9b6', 1),
(8, '6a4c235c9686d297dcbc272d8b5a806c', 11, 14, NULL, 1, '2015-06-21 00:00:00', '2015-07-21 00:00:00', '4d399e3bd41a38e16648bfa950a229ec314b4ed1d711372324d515c0c7173b8a5b374e1388097506f3045ce9316275de1b665ecf63770f4d42b662829e037a29', '4275d38408905d159fbed926342d0835a92a935fc026367c9f3cd2b572b78dc730def45a3f5d91bcac702d2d9dcc38f0347cf6d62c36bf87a5f586655ad233cf', 1),
(9, 'd73f2ef1ed1f4550b0ceb6989b9995bb', 11, 11, NULL, 1, '2015-06-21 00:00:00', '2015-06-30 00:00:00', '4d399e3bd41a38e16648bfa950a229ec314b4ed1d711372324d515c0c7173b8a5b374e1388097506f3045ce9316275de1b665ecf63770f4d42b662829e037a29', '45770081761f68c7784675762755d3bb90641d0fcac21062954fce65b42b73c4763897a1dccf8eed896dc0c1329b5da0c4afe011203cda1550bb003c997ad7b3', 1),
(17, '5ef24b77c911461c8b7995167ba852f9', 12, 1, NULL, 4, '2015-06-21 00:00:00', '2015-07-11 00:00:00', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `license_types`
--

CREATE TABLE IF NOT EXISTS `license_types` (
  `license_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `license_type_name` varchar(100) NOT NULL,
  `license_type_description` varchar(1000) NOT NULL DEFAULT '',
  `license_type_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`license_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `license_types`
--

INSERT INTO `license_types` (`license_type_id`, `license_type_name`, `license_type_description`, `license_type_delete`) VALUES
(1, 'SSA', 'Single Stand Alone', 0),
(2, 'SNET', 'Single Network', 0),
(3, 'MNET', 'Multi Network', 0),
(4, 'Trial', 'Trial license', 0);

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `log_ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_user` int(11) DEFAULT NULL,
  `log_ip` varchar(15) NOT NULL DEFAULT '0.0.0.0',
  `log_browser` varchar(50) NOT NULL DEFAULT 'n/a',
  `log_platform` varchar(50) NOT NULL DEFAULT 'n/a',
  `log_entry` varchar(1000) NOT NULL DEFAULT '',
  `log_level` set('success','danger','info') NOT NULL DEFAULT 'info',
  PRIMARY KEY (`log_id`),
  KEY `log_user` (`log_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=159 ;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `log_ts`, `log_user`, `log_ip`, `log_browser`, `log_platform`, `log_entry`, `log_level`) VALUES
(1, '2015-06-18 12:52:23', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created client with ID: 14', 'success'),
(2, '2015-06-18 13:01:22', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 3', 'success'),
(3, '2015-06-18 13:01:59', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 5', 'success'),
(4, '2015-06-18 13:02:15', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 1', 'success'),
(5, '2015-06-18 13:02:22', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 2', 'success'),
(6, '2015-06-18 13:03:02', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created product with ID: 9', 'success'),
(7, '2015-06-18 13:04:09', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created quote with ID: 12', 'success'),
(8, '2015-06-18 13:05:27', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated quote with ID: 12', 'success'),
(9, '2015-06-18 13:05:40', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated quote with ID: 12', 'success'),
(10, '2015-06-18 13:06:28', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated quote with ID: 12', 'success'),
(11, '2015-06-18 13:14:13', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created product with ID: 10', 'success'),
(12, '2015-06-18 13:14:23', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 9', 'success'),
(13, '2015-06-18 13:14:46', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated quote with ID: 12', 'success'),
(14, '2015-06-18 15:25:50', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Invoice with ID 1 delete successfully', 'success'),
(15, '2015-06-18 19:54:17', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(16, '2015-06-18 20:01:28', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Successfully updated user profile', 'success'),
(17, '2015-06-18 20:01:35', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(18, '2015-06-18 20:01:53', NULL, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed login attempt with credentials dan-n@iacs.co.il, 1234567', 'danger'),
(19, '2015-06-18 20:01:57', NULL, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed login attempt with credentials dan-n@iacs.co.il, 12345678', 'danger'),
(20, '2015-06-18 20:02:03', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(21, '2015-06-20 10:38:27', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(22, '2015-06-20 10:38:52', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Successfully updated user profile', 'success'),
(23, '2015-06-20 10:38:59', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(24, '2015-06-20 10:42:39', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Successfully updated user profile', 'success'),
(25, '2015-06-20 10:42:49', NULL, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed login attempt with credentials dan-n@iacs.co.il, 123456', 'danger'),
(26, '2015-06-20 10:42:55', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(27, '2015-06-20 13:27:32', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new invoice - invalid data', 'danger'),
(28, '2015-06-20 13:28:52', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new invoice - invalid data', 'danger'),
(29, '2015-06-20 13:30:22', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new invoice', 'danger'),
(30, '2015-06-20 13:31:04', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new invoice', 'danger'),
(31, '2015-06-20 13:33:18', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 5', 'success'),
(32, '2015-06-20 13:35:13', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Invoice with ID 5 delete successfully', 'success'),
(33, '2015-06-20 13:43:59', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated quote with ID: 11', 'success'),
(34, '2015-06-20 13:44:22', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 6', 'success'),
(35, '2015-06-20 13:45:02', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Invoice with ID 6 delete successfully', 'success'),
(36, '2015-06-20 13:45:07', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 7', 'success'),
(37, '2015-06-20 14:11:54', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created quote with ID: 13', 'success'),
(38, '2015-06-20 14:13:45', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 8', 'success'),
(39, '2015-06-20 15:12:49', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated invoice with ID: 8', 'success'),
(40, '2015-06-20 15:13:26', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated invoice with ID: 8', 'success'),
(41, '2015-06-20 15:15:36', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated quote with ID: 10', 'success'),
(42, '2015-06-20 16:37:54', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license - invalid data', 'danger'),
(43, '2015-06-20 17:56:14', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated client with ID: 1', 'success'),
(44, '2015-06-20 17:58:00', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated client with ID: 2', 'success'),
(45, '2015-06-20 18:00:02', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated client with ID: 10', 'success'),
(46, '2015-06-20 18:01:56', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated client with ID: 11', 'success'),
(47, '2015-06-20 18:05:24', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated client with ID: 11', 'success'),
(48, '2015-06-20 18:06:50', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated client with ID: 13', 'success'),
(49, '2015-06-20 18:13:21', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 10', 'success'),
(50, '2015-06-20 18:15:18', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated quote with ID: 10', 'success'),
(51, '2015-06-20 18:15:48', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 9', 'success'),
(52, '2015-06-20 18:18:05', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created quote with ID: 14', 'success'),
(53, '2015-06-20 18:18:51', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 10', 'success'),
(54, '2015-06-20 18:27:14', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Invoice with ID 10 delete successfully', 'success'),
(55, '2015-06-20 18:30:18', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 11', 'success'),
(56, '2015-06-20 18:30:51', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated invoice with ID: 11', 'success'),
(57, '2015-06-21 10:09:13', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(58, '2015-06-21 10:18:53', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created quote with ID: 15', 'success'),
(59, '2015-06-21 10:19:16', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 12', 'success'),
(60, '2015-06-21 10:56:18', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Invoice with ID 12 delete successfully', 'success'),
(61, '2015-06-21 11:22:20', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license - invalid data', 'danger'),
(62, '2015-06-21 11:29:12', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created license with ID: 2', 'success'),
(63, '2015-06-21 11:38:07', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license - invalid data', 'danger'),
(64, '2015-06-21 11:38:40', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created license with ID: 3', 'success'),
(65, '2015-06-21 11:57:24', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to update license - invalid data', 'danger'),
(66, '2015-06-21 11:59:00', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to update license - invalid data', 'danger'),
(67, '2015-06-21 12:00:19', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to update license - invalid data', 'danger'),
(68, '2015-06-21 12:00:40', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to update license - invalid data', 'danger'),
(69, '2015-06-21 12:01:27', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated license with ID: 0', 'success'),
(70, '2015-06-21 12:02:12', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated license with ID: 0', 'success'),
(71, '2015-06-21 12:35:42', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license - invalid data', 'danger'),
(72, '2015-06-21 12:36:17', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(73, '2015-06-21 12:37:32', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(74, '2015-06-21 12:38:09', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(75, '2015-06-21 12:41:13', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Creating license from request failed. Request file product doesn''t match', 'info'),
(76, '2015-06-21 12:41:31', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Creating license from request failed. Request file product doesn''t match', 'info'),
(77, '2015-06-21 12:42:03', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created product with ID: 11', 'success'),
(78, '2015-06-21 12:42:19', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Creating license from request failed. Request file product doesn''t match', 'info'),
(79, '2015-06-21 12:44:11', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Creating license from request failed. Request file product doesn''t match', 'info'),
(80, '2015-06-21 12:48:26', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Creating license from request failed. Request file product doesn''t match', 'info'),
(81, '2015-06-21 12:48:38', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created license 7 successfully', 'success'),
(82, '2015-06-21 12:54:34', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created license 8 successfully', 'success'),
(83, '2015-06-21 13:06:27', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created license 9 successfully', 'success'),
(84, '2015-06-21 13:08:25', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created product with ID: 12', 'success'),
(85, '2015-06-21 13:09:44', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Creating license failed. Error uploading request file ', 'info'),
(86, '2015-06-21 13:10:41', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(87, '2015-06-21 13:11:41', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(88, '2015-06-21 13:12:33', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(89, '2015-06-21 13:12:55', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(90, '2015-06-21 13:13:23', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(91, '2015-06-21 13:14:17', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(92, '2015-06-21 13:15:08', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license', 'danger'),
(93, '2015-06-21 13:16:38', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to create a new license - invalid data', 'danger'),
(94, '2015-06-21 13:17:22', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created license with ID: 17', 'success'),
(95, '2015-06-21 13:21:50', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'License with ID 7 delete successfully', 'success'),
(96, '2015-06-21 13:21:55', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'License with ID 8 delete successfully', 'success'),
(97, '2015-06-21 13:22:03', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'License with ID 9 delete successfully', 'success'),
(98, '2015-06-21 13:24:22', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 10', 'success'),
(99, '2015-06-21 13:24:51', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 9', 'success'),
(100, '2015-06-21 13:24:57', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 1', 'success'),
(101, '2015-06-21 13:25:00', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 2', 'success'),
(102, '2015-06-21 13:50:43', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated license with ID: 0', 'success'),
(103, '2015-06-21 14:09:49', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Can''t perform expired licenses report. Supplied days are invalid.', ''),
(104, '2015-06-21 14:20:01', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to update license - invalid data', 'danger'),
(105, '2015-06-21 14:21:15', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to update license - invalid data', 'danger'),
(106, '2015-06-21 14:22:27', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Failed to update license - invalid data', 'danger'),
(107, '2015-06-21 14:22:46', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated license with ID: 0', 'success'),
(108, '2015-06-21 14:56:35', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 1', 'success'),
(109, '2015-06-21 14:56:38', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 9', 'success'),
(110, '2015-06-21 14:56:41', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated product with ID: 2', 'success'),
(111, '2015-06-21 15:00:37', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created quote with ID: 16', 'success'),
(112, '2015-06-21 15:00:46', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created invoice with ID: 13', 'success'),
(113, '2015-06-21 15:19:56', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated license with ID: 0', 'success'),
(114, '2015-06-21 15:22:49', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Updated client with ID: 2', 'success'),
(115, '2015-06-21 15:26:16', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Expired Licenses create successfully', 'info'),
(116, '2015-06-21 15:27:49', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(117, '2015-06-21 17:49:31', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(118, '2015-06-21 17:49:45', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Products Sales create successfully', 'info'),
(119, '2015-06-22 18:56:13', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(120, '2015-06-22 19:02:53', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Created quote with ID: 17', 'success'),
(121, '2015-06-22 19:08:58', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Expired Licenses create successfully', 'info'),
(122, '2015-06-22 19:09:26', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(123, '2015-06-22 19:09:30', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Open Invoices create successfully', 'info'),
(124, '2015-06-22 19:09:33', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Products Sales create successfully', 'info'),
(125, '2015-06-22 19:15:07', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(126, '2015-06-23 08:44:16', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'User logged in successfully', 'success'),
(127, '2015-06-23 08:50:10', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Products Sales create successfully', 'info'),
(128, '2015-06-23 08:50:31', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Expired Licenses create successfully', 'info'),
(129, '2015-06-23 08:50:48', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(130, '2015-06-23 08:50:52', 1, '::1', 'Chrome(43.0.2357.124)', 'Windows', 'Report Open Invoices create successfully', 'info'),
(131, '2015-06-23 09:02:21', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'User logged in successfully', 'success'),
(132, '2015-06-23 09:02:30', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Failed to retrieve clients from the database', 'danger'),
(133, '2015-06-23 09:04:08', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Non Active Clients create successfully', 'info'),
(134, '2015-06-23 09:09:32', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Non Active Clients create successfully', 'info'),
(135, '2015-06-23 09:17:51', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Open Invoices create successfully', 'info'),
(136, '2015-06-23 09:19:40', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Open Invoices create successfully', 'info'),
(137, '2015-06-23 09:20:15', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Open Invoices create successfully', 'info'),
(138, '2015-06-23 09:20:49', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Open Invoices create successfully', 'info'),
(139, '2015-06-23 09:21:51', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Non Active Clients create successfully', 'info'),
(140, '2015-06-23 09:24:06', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Non Active Clients create successfully', 'info'),
(141, '2015-06-23 09:24:11', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Non Active Clients create successfully', 'info'),
(142, '2015-06-23 09:25:00', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Non Active Clients create successfully', 'info'),
(143, '2015-06-23 09:26:18', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Non Active Clients create successfully', 'info'),
(144, '2015-06-23 09:28:12', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Non Active Clients create successfully', 'info'),
(145, '2015-06-23 09:30:06', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Open Invoices create successfully', 'info'),
(146, '2015-06-23 09:30:20', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Expired Licenses create successfully', 'info'),
(147, '2015-06-23 09:31:52', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Updated client with ID: 10', 'success'),
(148, '2015-06-23 09:32:41', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Created quote with ID: 18', 'success'),
(149, '2015-06-23 09:33:12', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(150, '2015-06-23 09:33:37', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(151, '2015-06-23 09:37:18', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(152, '2015-06-23 09:39:07', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(153, '2015-06-23 09:39:55', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(154, '2015-06-23 09:40:01', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(155, '2015-06-23 09:40:05', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(156, '2015-06-23 09:40:11', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(157, '2015-06-23 09:40:18', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Quotes By Status create successfully', 'info'),
(158, '2015-06-23 09:41:56', 1, '::1', 'Chrome(43.0.2357.130)', 'Windows', 'Report Expired Licenses create successfully', 'info');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_manufactor` set('iacs','caseware') NOT NULL DEFAULT 'iacs',
  `product_name` varchar(200) NOT NULL,
  `product_description` text NOT NULL,
  `product_basePrice` int(11) NOT NULL DEFAULT '0',
  `product_coin` set('usd','nis') NOT NULL DEFAULT 'nis',
  `product_type` set('software','training') NOT NULL DEFAULT 'software',
  `product_version` varchar(20) NOT NULL DEFAULT '',
  `product_license` int(11) DEFAULT NULL,
  `product_length` int(11) NOT NULL DEFAULT '0',
  `product_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `product_license_type` (`product_license`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_manufactor`, `product_name`, `product_description`, `product_basePrice`, `product_coin`, `product_type`, `product_version`, `product_license`, `product_length`, `product_delete`) VALUES
(1, 'caseware', 'IDEA 9 ASCII', 'Caseware IDEA 9', 2000, 'usd', 'software', '9.0 ASCII', 1, 0, 0),
(2, 'caseware', 'IDEA 9 UNICODE', 'Caseware IDEA 9', 2000, 'usd', 'software', '9.0 UNICODE', 1, 0, 0),
(3, 'iacs', 'קורס מתקדמים - IDEA גרסה 9', 'הסבר על הקורס כולל סילבוס.', 1800, 'nis', 'training', '', 1, 50, 0),
(4, 'iacs', 'FiPack', 'Finnacial audits pack', 500, 'usd', 'software', '2.0', 1, 0, 0),
(5, 'iacs', 'קורס בסיסי - IDEA גרסה 9', 'למד את הבסיס של תוכנת IDEA.\r\nכולל סילבוס של הקורס.', 1000, 'nis', 'training', '', 1, 30, 0),
(8, 'iacs', 'ExPack', 'Smart false-positive prevention pack for IDEA.', 400, 'usd', 'software', '1.05', 1, 0, 0),
(9, 'caseware', 'IDEA 9 ASCII', '', 4500, 'usd', 'software', 'ASCII 9.0', 2, 0, 0),
(10, 'iacs', 'FiPack', 'Finnancial audit tests in many subjects.', 0, 'usd', 'software', '2.00', 4, 0, 0),
(11, 'iacs', 'DMR', 'Desktop Macro Runner - DMR.', 500, 'usd', 'software', '1.00', 1, 0, 0),
(12, 'iacs', 'DMR', 'DMR Trial', 0, 'nis', 'software', '1.00', 4, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE IF NOT EXISTS `quotes` (
  `quote_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_client` int(11) NOT NULL,
  `quote_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quote_expire` datetime NOT NULL,
  `quote_taxRate` float NOT NULL DEFAULT '18',
  `quote_discount` float NOT NULL DEFAULT '0',
  `quote_usdRate` float NOT NULL DEFAULT '0',
  `quote_status` int(11) NOT NULL,
  `quote_note` text NOT NULL,
  `quote_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`quote_id`),
  KEY `quote_client` (`quote_client`),
  KEY `quote_status` (`quote_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`quote_id`, `quote_client`, `quote_date`, `quote_expire`, `quote_taxRate`, `quote_discount`, `quote_usdRate`, `quote_status`, `quote_note`, `quote_delete`) VALUES
(10, 2, '2015-06-17 00:00:00', '2015-06-30 00:00:00', 18, 20, 3.8289, 5, '20% off.', 0),
(11, 13, '2015-06-17 00:00:00', '2015-07-04 00:00:00', 18, 0, 3.8289, 5, '25% discount due to IDEA 9 licenses.\r\nNo more discount.', 0),
(12, 14, '2015-06-18 00:00:00', '2015-07-02 00:00:00', 18, 0, 3.8128, 5, 'הנחה של 5% על כל הסכום עקב עסקת חבילה הכוללת גם קורס מתחילים ומתקדמים.', 0),
(13, 11, '2015-06-20 00:00:00', '2015-07-04 00:00:00', 18, 5, 3.8289, 5, '', 0),
(14, 1, '2015-06-20 00:00:00', '2015-07-04 00:00:00', 18, 10, 3.8289, 5, '10% הנחה + 20 יחידות פיפאק חינם לשנה', 0),
(15, 1, '2015-06-21 00:00:00', '2015-07-05 00:00:00', 18, 0, 3.8289, 4, '', 0),
(16, 1, '2015-06-21 00:00:00', '2015-07-05 00:00:00', 18, 0, 3.8289, 5, '', 0),
(17, 2, '2015-06-22 00:00:00', '2015-07-06 00:00:00', 18, 0, 3.7703, 1, '', 0),
(18, 11, '2015-06-23 00:00:00', '2015-07-07 00:00:00', 18, 5, 3.7796, 1, 'Quote note is here!', 0);

-- --------------------------------------------------------

--
-- Table structure for table `quote_products`
--

CREATE TABLE IF NOT EXISTS `quote_products` (
  `quote_product_quote` int(11) NOT NULL,
  `quote_product_product` int(11) NOT NULL,
  `quote_product_quantity` int(11) NOT NULL DEFAULT '1',
  KEY `quote_product_product` (`quote_product_product`),
  KEY `quote_product_quote` (`quote_product_quote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quote_products`
--

INSERT INTO `quote_products` (`quote_product_quote`, `quote_product_product`, `quote_product_quantity`) VALUES
(12, 1, 5),
(12, 5, 5),
(12, 3, 4),
(12, 10, 1),
(11, 2, 3),
(11, 5, 4),
(13, 1, 4),
(13, 10, 1),
(13, 3, 2),
(13, 5, 3),
(10, 2, 5),
(10, 5, 5),
(10, 3, 3),
(14, 1, 10),
(14, 10, 20),
(15, 2, 2),
(16, 4, 100),
(17, 1, 2),
(18, 1, 1),
(18, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `quote_statuses`
--

CREATE TABLE IF NOT EXISTS `quote_statuses` (
  `quote_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_status_name` varchar(50) NOT NULL,
  `quote_status_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`quote_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `quote_statuses`
--

INSERT INTO `quote_statuses` (`quote_status_id`, `quote_status_name`, `quote_status_delete`) VALUES
(1, 'DRAFT', 0),
(2, 'SENT', 0),
(3, 'DECLINE', 0),
(4, 'APPROVED', 0),
(5, 'INVOICED', 0),
(6, 'EXPIRED', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_token` varchar(64) NOT NULL DEFAULT '',
  `user_firstName` varchar(20) NOT NULL,
  `user_lastName` varchar(20) NOT NULL DEFAULT '',
  `user_admin` tinyint(1) NOT NULL DEFAULT '0',
  `user_lastActive` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_delete` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_password`, `user_token`, `user_firstName`, `user_lastName`, `user_admin`, `user_lastActive`, `user_delete`) VALUES
(1, 'dan-n@iacs.co.il', '$2y$10$ldhYOZlLOSi3LsnsUnZh5el8NQn76xT4aIgzBL.nMvfTdFbVUJSaS', '', 'Dan', 'Netaniyahu', 1, '2015-06-23 12:44:51', 0),
(2, 'rond@iacs.co.il', '$2y$10$dhEJtkT7gvoGmMOy8TKCou9fgxM5Xf4I0W9UI8RQVDMdEd46JSpxS', '', 'Ron', 'Dadon', 0, '2015-05-20 13:31:14', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`invoice_client`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`invoice_quote`) REFERENCES `quotes` (`quote_id`);

--
-- Constraints for table `invoice_products`
--
ALTER TABLE `invoice_products`
  ADD CONSTRAINT `invoice_products_ibfk_1` FOREIGN KEY (`invoice_product_product`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `invoice_products_ibfk_2` FOREIGN KEY (`invoice_product_invoice`) REFERENCES `invoices` (`invoice_id`);

--
-- Constraints for table `licenses`
--
ALTER TABLE `licenses`
  ADD CONSTRAINT `licenses_ibfk_1` FOREIGN KEY (`license_product`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `licenses_ibfk_2` FOREIGN KEY (`license_client`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `licenses_ibfk_3` FOREIGN KEY (`license_type`) REFERENCES `license_types` (`license_type_id`),
  ADD CONSTRAINT `licenses_ibfk_4` FOREIGN KEY (`license_invoice`) REFERENCES `invoices` (`invoice_id`);

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`log_user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_license`) REFERENCES `license_types` (`license_type_id`);

--
-- Constraints for table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_ibfk_1` FOREIGN KEY (`quote_client`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `quotes_ibfk_2` FOREIGN KEY (`quote_status`) REFERENCES `quote_statuses` (`quote_status_id`);

--
-- Constraints for table `quote_products`
--
ALTER TABLE `quote_products`
  ADD CONSTRAINT `quote_products_ibfk_1` FOREIGN KEY (`quote_product_product`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `quote_products_ibfk_2` FOREIGN KEY (`quote_product_quote`) REFERENCES `quotes` (`quote_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
