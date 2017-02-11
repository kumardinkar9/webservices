-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 24, 2014 at 01:27 PM
-- Server version: 5.5.37-0ubuntu0.13.10.1
-- PHP Version: 5.5.3-1ubuntu2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `green_basket`
--

-- --------------------------------------------------------

--
-- Table structure for table `area_details`
--

CREATE TABLE IF NOT EXISTS `area_details` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `area` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_feedback`
--

CREATE TABLE IF NOT EXISTS `customer_feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `feedback_message` text NOT NULL,
  `feedback_date_time` datetime NOT NULL,
  PRIMARY KEY (`feedback_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `customer_feedback`
--

INSERT INTO `customer_feedback` (`feedback_id`, `customer_name`, `customer_mobile_number`, `feedback_message`, `feedback_date_time`) VALUES
(1, 'funki', '9987870000', 'funki orange technologies', '2014-05-19 13:19:10');

-- --------------------------------------------------------

--
-- Table structure for table `customer_signup`
--

CREATE TABLE IF NOT EXISTS `customer_signup` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_mobile` varchar(14) CHARACTER SET utf8 NOT NULL,
  `customer_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_area` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_city` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_latitude` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_longitude` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_approve_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'true=1, false=0',
  `customer_signup_date_time` datetime NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_email` (`customer_email`),
  UNIQUE KEY `customer_mobile` (`customer_mobile`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `customer_signup`
--

INSERT INTO `customer_signup` (`customer_id`, `customer_name`, `customer_mobile`, `customer_address`, `customer_area`, `customer_city`, `customer_email`, `customer_latitude`, `customer_longitude`, `customer_approve_status`, `customer_signup_date_time`) VALUES
(1, 'funki', '9999887711', 'A-33 sector 1 Delhi', 'new delhi', 'patel nagar', 'customer@gmail.com', '28.606607', '77.364895', 1, '2014-05-19 13:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE IF NOT EXISTS `payment_details` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT 'FK For customer_signup',
  `vendor_id` int(11) NOT NULL COMMENT 'FK For vendor_signup',
  `items` varchar(255) CHARACTER SET utf8 NOT NULL,
  `total_payments` varchar(255) NOT NULL,
  `payment_date_time` datetime NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payment_details`
--

INSERT INTO `payment_details` (`payment_id`, `customer_id`, `vendor_id`, `items`, `total_payments`, `payment_date_time`) VALUES
(1, 1, 1, 'apple,banana,grapes,potato,brinjal', '1100', '2014-05-19 13:17:40');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_id` int(11) NOT NULL COMMENT 'FK For product_type',
  `product_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `product_insert_date_time` datetime NOT NULL,
  `product_delete_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'delete=0, not delete=1',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_type_id`, `product_name`, `product_insert_date_time`, `product_delete_status`) VALUES
(1, 0, 'fruits', '2014-05-15 11:40:18', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE IF NOT EXISTS `product_type` (
  `product_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`product_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_address`
--

CREATE TABLE IF NOT EXISTS `shipping_address` (
  `ship_another_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_id` int(11) NOT NULL COMMENT 'FK for customer_signup',
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `area` varchar(255) CHARACTER SET utf8 NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `email_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `ship_register_date_time` datetime NOT NULL,
  `default` tinyint(1) NOT NULL COMMENT '0=shipping address, 1=customer register address',
  PRIMARY KEY (`ship_another_address_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shipping_address`
--

INSERT INTO `shipping_address` (`ship_another_address_id`, `name`, `customer_id`, `address`, `area`, `city`, `mobile_number`, `email_address`, `ship_register_date_time`, `default`) VALUES
(1, 'Ram', 1, 'b-11 Sector 22 noida', 'sector 22', 'noida', '9995300033', 'fruits@gmail.com', '2014-05-19 13:37:00', 0),
(2, 'Ram', 1, 'b-11 Sector 22 noida', 'sector 22', 'noida', '9995399033', 'fruits9@gmail.com', '2014-05-19 13:38:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `suggested_vendor`
--

CREATE TABLE IF NOT EXISTS `suggested_vendor` (
  `suggested_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `vendor_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `suggested_date_time` datetime NOT NULL,
  PRIMARY KEY (`suggested_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `suggested_vendor`
--

INSERT INTO `suggested_vendor` (`suggested_id`, `customer_name`, `customer_mobile_number`, `vendor_name`, `vendor_mobile_number`, `suggested_date_time`) VALUES
(1, 'funki', '9900990099', 'orange', '9988776655', '2014-05-19 13:58:38'),
(2, 'funki', '9900990099', 'orange', '9988776655', '2014-05-19 16:03:37');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_item_list`
--

CREATE TABLE IF NOT EXISTS `vendor_item_list` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_id` int(11) NOT NULL COMMENT 'FK For product_type',
  `vendor_id` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'FK for vendor_signup',
  `item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `item_rate` varchar(255) CHARACTER SET utf8 NOT NULL,
  `product_active_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'not active=0, active=1',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vendor_item_list`
--

INSERT INTO `vendor_item_list` (`item_id`, `product_type_id`, `vendor_id`, `item_name`, `item_rate`, `product_active_status`) VALUES
(1, 1, '1', 'apple', '1220', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_signup`
--

CREATE TABLE IF NOT EXISTS `vendor_signup` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_shop_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `vendor_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_area` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor city` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_shop_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_sell_vegetables` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'if sell=1, not sell=0',
  `vendor_sell_fruits` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'if sell=1, not sell=0',
  `vendor_pick_location_directly` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'if true=1, false=0',
  `vendor_approve_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'if true=1, false=0',
  `vendor_latitude` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_longitude` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_signup_date_time` datetime NOT NULL,
  `vendor_active_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'not active=0, active=1',
  PRIMARY KEY (`vendor_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `vendor_signup`
--

INSERT INTO `vendor_signup` (`vendor_id`, `vendor_shop_name`, `vendor_mobile_number`, `vendor_email`, `vendor_password`, `vendor_area`, `vendor city`, `vendor_shop_address`, `vendor_sell_vegetables`, `vendor_sell_fruits`, `vendor_pick_location_directly`, `vendor_approve_status`, `vendor_latitude`, `vendor_longitude`, `vendor_signup_date_time`, `vendor_active_status`) VALUES
(1, 'delhi fruits vendor', '9999887700', 'funkitest@gmail.com', '3d2172418ce305c7d16d4b05597c6a59', '', '', 'A-33 sector 1 Delhi', 0, 1, 1, 1, '28.606607', '77.364895', '2014-05-19 12:56:46', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
