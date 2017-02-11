-- Adminer 4.0.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+05:30';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `area_details`;
CREATE TABLE `area_details` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `city_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `area` varchar(255) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`city_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `customer_feedback`;
CREATE TABLE `customer_feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `feedback_message` text NOT NULL,
  `feedback_date_time` datetime NOT NULL,
  PRIMARY KEY (`feedback_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `customer_feedback` (`feedback_id`, `customer_name`, `customer_mobile_number`, `feedback_message`, `feedback_date_time`) VALUES
(1,	'',	'2222222222',	'fdgfdgfdg dfdfdfg dfgfdfdgfd gfghgf',	'2014-06-12 14:27:07'),
(2,	'',	'3434343434',	'sdfg dfgd dfgfd fdg fdfxdg reg dfdfg rtg',	'2014-06-12 14:28:44'),
(3,	'',	'4122212233',	'Svsgdgdhd',	'2014-06-12 15:16:22');

DROP TABLE IF EXISTS `customer_signup`;
CREATE TABLE `customer_signup` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `customer_signup` (`customer_id`, `customer_name`, `customer_mobile`, `customer_address`, `customer_area`, `customer_city`, `customer_email`, `customer_latitude`, `customer_longitude`, `customer_approve_status`, `customer_signup_date_time`) VALUES
(1,	'funki',	'4344343433',	'cfsd f',	'Bandra',	'Mumbai',	'funkitest@gmail.com',	'28.88888',	'78.43535',	1,	'2014-05-19 13:15:16'),
(2,	'Funkitest',	'5658958985',	'B-42,59,noida',	'Bandra',	'Mumbai',	'funkitest1@gmil.com',	'28.88888',	'78.43535',	1,	'2014-06-19 10:32:54');

DROP TABLE IF EXISTS `gb_aboutus`;
CREATE TABLE `gb_aboutus` (
  `about_id` int(11) NOT NULL AUTO_INCREMENT,
  `about_text` text NOT NULL,
  PRIMARY KEY (`about_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Store Green Basket about us ';

INSERT INTO `gb_aboutus` (`about_id`, `about_text`) VALUES
(1,	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');

DROP TABLE IF EXISTS `payment_details`;
CREATE TABLE `payment_details` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT 'FK For customer_signup',
  `vendor_id` int(11) NOT NULL COMMENT 'FK For vendor_signup',
  `product_id` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'FK for product',
  `total_payments` varchar(255) NOT NULL,
  `payment_date_time` datetime NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `payment_details` (`payment_id`, `customer_id`, `vendor_id`, `product_id`, `total_payments`, `payment_date_time`) VALUES
(1,	1,	1,	'6,7,8,9',	'1100',	'2014-05-19 13:17:40');

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_id` int(11) NOT NULL COMMENT 'FK For product_type',
  `product_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `product_image` varchar(255) CHARACTER SET utf8 NOT NULL,
  `product_quantity_type` varchar(255) CHARACTER SET utf8 NOT NULL,
  `product_insert_date_time` datetime NOT NULL,
  `product_delete_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'delete=1, not delete=0',
  `product_type_filter` varchar(10) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `product` (`product_id`, `product_type_id`, `product_name`, `product_image`, `product_quantity_type`, `product_insert_date_time`, `product_delete_status`, `product_type_filter`) VALUES
(6,	1,	'apple',	'product_image/apple.jpg',	'Kg',	'2014-05-28 11:20:50',	0,	'Basic'),
(7,	2,	'Onion - Red',	'product_image/onion.png',	'Kg',	'2014-05-28 11:23:10',	0,	'Basic'),
(8,	2,	'Lime',	'product_image/lemon.png',	'Pc',	'2014-05-28 11:31:38',	0,	'Leafy'),
(9,	2,	'Potato',	'product_image/potato.png',	'Kg',	'2014-05-28 11:33:42',	0,	'Leafy'),
(10,	1,	'Banana',	'product_image/banana.jpg',	'Pc',	'2014-06-02 05:19:33',	0,	'Leafy'),
(11,	1,	'Grape',	'product_image/grape.jpeg',	'Kg',	'2014-06-02 05:19:47',	0,	'Leafy'),
(12,	2,	'Tomato',	'product_image/tomato.jpg',	'Kg',	'2014-06-03 05:52:04',	0,	''),
(13,	2,	'Brinjal',	'product_image/brinjal.jpeg',	'Kg',	'2014-06-03 06:36:28',	0,	''),
(14,	1,	'Mango',	'product_image/mango.jpg',	'Kg',	'2014-06-13 08:11:38',	0,	''),
(15,	1,	'Pomegranate',	'product_image/Pomegranate.jpg',	'Kg',	'2014-06-13 08:14:34',	0,	''),
(16,	2,	'Bitter-Gourd',	'product_image/bitter-gourd.jpg',	'Kg',	'2014-06-13 08:16:06',	0,	''),
(17,	2,	'Ladies-Finger',	'product_image/ladies-finger.jpg',	'Kg',	'2014-06-13 08:17:32',	0,	''),
(18,	2,	'Cauliflower',	'product_image/cauliflower.jpeg',	'Kg',	'2014-06-13 08:22:56',	0,	''),
(19,	2,	'Cucumber',	'product_image/cucumber.jpg',	'Kg',	'2014-06-13 08:24:41',	0,	''),
(20,	1,	'Guava.jpg',	'product_image/guava.jpg',	'Kg',	'2014-06-13 08:45:53',	0,	'');

DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `product_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`product_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `product_type` (`product_type_id`, `product_type_name`) VALUES
(1,	'fruits'),
(2,	'veggies');

DROP TABLE IF EXISTS `shipping_address`;
CREATE TABLE `shipping_address` (
  `shipping_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_id` int(11) NOT NULL COMMENT 'FK for customer_signup',
  `address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `area` varchar(255) CHARACTER SET utf8 NOT NULL,
  `city` varchar(255) CHARACTER SET utf8 NOT NULL,
  `mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `email_address` varchar(255) CHARACTER SET utf8 NOT NULL,
  `shipping_register_date_time` datetime NOT NULL,
  `default` tinyint(1) NOT NULL COMMENT '0=shipping address, 1=customer register address',
  PRIMARY KEY (`shipping_address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `shipping_address` (`shipping_address_id`, `name`, `customer_id`, `address`, `area`, `city`, `mobile_number`, `email_address`, `shipping_register_date_time`, `default`) VALUES
(1,	'Ram',	1,	'b-11 Sector 22 noida',	'sector 22',	'noida',	'9995300033',	'fruits@gmail.com',	'2014-05-19 13:37:00',	0),
(2,	'Ram',	1,	'b-11 Sector 22 noida',	'sector 22',	'noida',	'9995399033',	'fruits9@gmail.com',	'2014-05-19 13:38:28',	0),
(3,	'',	0,	'',	'',	'',	'',	'',	'2014-05-27 16:15:46',	0);

DROP TABLE IF EXISTS `suggested_vendor`;
CREATE TABLE `suggested_vendor` (
  `suggested_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `customer_mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `vendor_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `suggested_date_time` datetime NOT NULL,
  PRIMARY KEY (`suggested_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `suggested_vendor` (`suggested_id`, `customer_name`, `customer_mobile_number`, `vendor_name`, `vendor_mobile_number`, `suggested_date_time`) VALUES
(1,	'funki',	'9900990099',	'orange',	'9988776655',	'2014-05-19 13:58:38'),
(2,	'funki',	'9900990099',	'orange',	'9988776655',	'2014-05-19 16:03:37'),
(3,	'dsfdsfdsf',	'2222222222',	'efwerwer wr',	'',	'2014-06-12 15:08:28');

DROP TABLE IF EXISTS `vendor_product_list`;
CREATE TABLE `vendor_product_list` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_type_id` int(11) NOT NULL COMMENT 'FK For product_type',
  `vendor_id` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'FK for vendor_signup',
  `product_id` int(11) NOT NULL COMMENT 'FK For product',
  `item_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `item_rate` varchar(255) CHARACTER SET utf8 NOT NULL,
  `product_active_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'not active=0, active=1',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `vendor_product_list` (`item_id`, `product_type_id`, `vendor_id`, `product_id`, `item_name`, `item_rate`, `product_active_status`) VALUES
(1,	0,	'6',	6,	'',	'120',	1),
(2,	0,	'6',	8,	'',	'11',	1),
(3,	0,	'6',	10,	'',	'6',	1),
(4,	0,	'6',	11,	'',	'100',	1),
(5,	0,	'9',	6,	'',	'120',	1),
(6,	0,	'9',	7,	'',	'25',	1),
(7,	0,	'9',	8,	'',	'10',	1),
(8,	0,	'9',	9,	'',	'25',	1),
(9,	0,	'4',	6,	'',	'160',	0),
(10,	0,	'4',	8,	'',	'04',	1),
(11,	0,	'4',	10,	'',	'40',	0),
(12,	0,	'4',	11,	'',	'70',	1),
(13,	0,	'5',	6,	'',	'42',	1),
(14,	0,	'5',	8,	'',	'5',	1),
(15,	0,	'5',	10,	'',	'5',	1),
(16,	0,	'5',	11,	'',	'89',	1),
(17,	0,	'9',	10,	'',	'12',	1),
(18,	0,	'9',	11,	'',	'100',	1),
(19,	0,	'9',	12,	'',	'20',	1),
(20,	0,	'9',	13,	'',	'35',	1),
(21,	0,	'11',	11,	'',	'0',	0),
(22,	0,	'11',	12,	'',	'0',	0),
(23,	0,	'11',	13,	'',	'50',	0),
(24,	0,	'11',	6,	'',	'0',	0),
(25,	0,	'11',	7,	'',	'0',	0),
(26,	0,	'11',	8,	'',	'0',	0),
(27,	0,	'11',	9,	'',	'0',	0),
(28,	0,	'11',	10,	'',	'0',	0),
(29,	0,	'12',	11,	'',	'0',	0),
(30,	0,	'12',	12,	'',	'56',	1),
(31,	0,	'12',	13,	'',	'45',	1),
(32,	0,	'12',	6,	'',	'44',	0),
(33,	0,	'12',	7,	'',	'42',	1),
(34,	0,	'12',	8,	'',	'43',	0),
(35,	0,	'12',	9,	'',	'24',	0),
(36,	0,	'12',	10,	'',	'0',	0),
(37,	0,	'15',	11,	'',	'0',	0),
(38,	0,	'15',	12,	'',	'0',	1),
(39,	0,	'15',	13,	'',	'0',	1),
(40,	0,	'15',	6,	'',	'0',	1),
(41,	0,	'15',	7,	'',	'0',	0),
(42,	0,	'15',	8,	'',	'0',	0),
(43,	0,	'15',	9,	'',	'0',	0),
(44,	0,	'15',	10,	'',	'0',	0),
(45,	2,	'25',	7,	'Onion - Red',	'0',	0),
(46,	2,	'25',	9,	'Potato',	'0',	0),
(47,	2,	'25',	12,	'Tomato',	'10',	0),
(48,	2,	'25',	13,	'Brinjal',	'0',	0),
(49,	1,	'26',	6,	'apple',	'',	0),
(50,	2,	'26',	7,	'Onion - Red',	'',	0),
(51,	1,	'26',	8,	'Lime',	'',	1),
(52,	2,	'26',	9,	'Potato',	'',	1),
(53,	1,	'26',	10,	'Banana',	'23',	1),
(54,	1,	'26',	11,	'Grape',	'',	1),
(55,	2,	'26',	12,	'Tomato',	'',	1),
(56,	2,	'26',	13,	'Brinjal',	'',	0),
(58,	1,	'9',	15,	'Pomegranate',	'200',	1),
(57,	1,	'9',	14,	'Mango',	'80',	1),
(59,	2,	'9',	16,	'Bitter-Gourd',	'25',	1),
(60,	2,	'9',	17,	'Ladies-Finger',	'15',	1),
(61,	2,	'9',	18,	'Cauliflower',	'20',	1),
(62,	2,	'9',	19,	'Cucumber',	'',	0),
(63,	1,	'9',	20,	'Guava.jpg',	'',	1),
(64,	1,	'26',	14,	'Mango',	'',	0),
(65,	1,	'26',	15,	'Pomegranate',	'',	0),
(66,	2,	'26',	16,	'Bitter-Gourd',	'',	0),
(67,	2,	'26',	17,	'Ladies-Finger',	'',	0),
(68,	2,	'26',	18,	'Cauliflower',	'',	0),
(69,	2,	'26',	19,	'Cucumber',	'',	0),
(70,	1,	'26',	20,	'Guava.jpg',	'',	0),
(71,	1,	'4',	14,	'Mango',	'0',	0),
(72,	1,	'4',	15,	'Pomegranate',	'0',	0),
(73,	1,	'4',	20,	'Guava.jpg',	'54',	1);

DROP TABLE IF EXISTS `vendor_rating`;
CREATE TABLE `vendor_rating` (
  `vendor_rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_id` int(11) NOT NULL COMMENT 'FK for vendor_signup',
  `customer_id` int(11) NOT NULL COMMENT 'FK for customer_signup',
  `rating` int(1) NOT NULL,
  `vendor_rating_date_time` datetime NOT NULL,
  PRIMARY KEY (`vendor_rating_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `vendor_signup`;
CREATE TABLE `vendor_signup` (
  `vendor_id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_shop_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_mobile_number` varchar(14) CHARACTER SET utf8 NOT NULL,
  `vendor_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_area` varchar(255) CHARACTER SET utf8 NOT NULL,
  `vendor_city` varchar(255) CHARACTER SET utf8 NOT NULL,
  `another_area` varchar(255) CHARACTER SET utf8 NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `vendor_signup` (`vendor_id`, `vendor_shop_name`, `vendor_mobile_number`, `vendor_email`, `vendor_password`, `vendor_area`, `vendor_city`, `another_area`, `vendor_shop_address`, `vendor_sell_vegetables`, `vendor_sell_fruits`, `vendor_pick_location_directly`, `vendor_approve_status`, `vendor_latitude`, `vendor_longitude`, `vendor_signup_date_time`, `vendor_active_status`) VALUES
(1,	'delhi fruits vendor',	'9999887700',	'funkitest@gmail.com',	'e10adc3949ba59abbe56e057f20f883e',	'',	'',	'',	'A-33 sector 1 Delhi',	0,	1,	1,	1,	'28.606607',	'77.364895',	'2014-05-19 12:56:46',	1),
(9,	'delhi vegies',	'9876543219',	'braj.singh@funkitechnologies.com',	'd6ee317388a6bd69c9e97018da5a32db',	'Chembur',	'Mumbai',	'',	'b-43',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-05-31 17:53:52',	1),
(3,	'orange fruits shop noida',	'9966332555',	'orange5@gmail.com',	'91a559a279db34cba51fc3ad3946736a',	'sector 11',	'sector 11',	'',	'a-11 sector-55 noida',	1,	1,	1,	1,	'26.858584',	'77.969853',	'2014-05-26 14:44:36',	1),
(4,	'GrocGreen',	'9850889625',	'iyerabhishek15@gmail.com',	'5a105e8b9d40e1329780d62ea2265d8a',	'Andheri',	'Mumbai',	'',	' Test',	0,	0,	1,	1,	'28.606607',	'77.364895',	'2014-05-28 14:35:29',	1),
(10,	'gfdgdgf',	'gfdgfdgdfgdfgf',	'fdgdf@gdf.gfd',	'e10adc3949ba59abbe56e057f20f883e',	'null',	'Mumbai',	'',	'wer',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-04 14:39:58',	1),
(5,	'haldiram',	'88029906199',	'6.suman@gmail.com',	'd728357744aeaffbf3784d775472c33f',	'Bandra',	'Mumbai',	'',	'Qetukudhi',	0,	0,	1,	1,	'28.606607',	'77.364895',	'2014-05-28 18:55:04',	1),
(6,	'myshop',	'3567964326',	'bkishor.singh8@gmail.com',	'af96c71527b9122b8ba2b886d73cb029',	'null',	'Mumbai',	'',	'V-56',	0,	1,	1,	1,	'28.606607',	'77.364895',	'2014-05-29 17:18:57',	1),
(7,	'Gajanand',	'8605381689',	'gajanand.choubey87@gmail.com',	'cef7ccd89dacf1ced6f5ec91d759953f',	'Andheri',	'Mumbai',	'',	'Text1',	0,	0,	1,	1,	'28.606607',	'77.364895',	'2014-05-29 17:37:48',	1),
(11,	'kedar fruits and veg',	'+919967438612',	'kedar.shinde1987@gmail.com',	'b454a6858eb34fee55ec859fa2634510',	'Chembur',	'Mumbai',	'',	'C/3 voltas',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-05 21:37:18',	1),
(12,	'fresh veg',	'+913456789023',	'1987qtp@gmail.com',	'8b587bc1e10d712ea6ff14f93f11b819',	'Bandra',	'Mumbai',	'',	'Noida sec 19',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-06 12:27:16',	1),
(13,	'wetuottu',	'+912359965357',	'xyz@test.com',	'e10adc3949ba59abbe56e057f20f883e',	'Chembur',	'Mumbai',	'',	'Wetyddhgdgu',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-06 12:42:38',	1),
(14,	'test',	'+916789045678',	'test@gmail.com',	'827ccb0eea8a706c4c34a16891f84e7b',	'Dongri',	'Mumbai',	'',	'Test noida',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-07 16:58:46',	1),
(15,	'jalandra vegetables',	'+918796768811',	'pjalandra@hotmail.com',	'b4ace95577db776c40cb19514bf47b3e',	'Bandra',	'Mumbai',	'',	'Old sanghvi Abhinav Nagar',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-08 21:29:15',	1),
(16,	'rajitest1',	'+919850887210',	'rajitest1@gmail.com',	'eb9b73e7d5364bea74b3e28e5d7e1299',	'None Of These',	'Mumbai',	'',	'Rajiaddress1',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-09 08:21:53',	1),
(24,	'dbv',	'+910134456567',	'fghgfh@dggf.con',	'099b3b060154898840f0ebdfb46ec78f',	'Bandra',	'Mumbai',	'xbnk',	'Zccbh',	1,	1,	0,	1,	'28.606607',	'77.364895',	'2014-06-11 20:15:25',	1),
(23,	'jhkhkhk',	'+916778687676',	'hjghg@hjgjh.hghj',	'e10adc3949ba59abbe56e057f20f883e',	'None Of These',	'Mumbai',	'xvcvfx',	'hbhjjklhklj',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-11 19:40:32',	1),
(22,	'hello',	'+919887766555',	'ghh@hghjg.ghgh',	'e10adc3949ba59abbe56e057f20f883e',	'None Of These',	'Mumbai',	'G-43',	'fgdghf',	0,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-11 14:12:13',	1),
(25,	'rajesh',	'+919872833500',	'sarla@funkitechnologies.com',	'7ed0513b1da4a823dbc8f6cb4aac2404',	'Chembur',	'Mumbai',	'',	'Sec 44 chandigarh',	1,	0,	1,	1,	'28.606607',	'77.364895',	'2014-06-12 21:53:30',	1),
(26,	'testshop',	'+918802990619',	'qtest@gmail.com',	'827ccb0eea8a706c4c34a16891f84e7b',	'None Of These',	'Mumbai',	'andheri',	'Noida sec -16',	1,	1,	0,	1,	'28.606607',	'77.364895',	'2014-06-13 14:12:47',	1),
(27,	'testing',	'+912991000007',	'qatest@test.com',	'e10adc3949ba59abbe56e057f20f883e',	'None Of These',	'Mumbai',	'andheri',	'Noida sec -16',	1,	1,	0,	1,	'28.606607',	'77.364895',	'2014-06-13 14:44:35',	1),
(28,	'cbnmmjbvn',	'+912456678888',	'braj.singh@funkitechnologies.comggh',	'e10adc3949ba59abbe56e057f20f883e',	'Chembur',	'Mumbai',	'',	'Fhj',	0,	1,	0,	1,	'28.606607',	'77.364895',	'2014-06-14 16:05:02',	1),
(29,	'cbnmmjbvn',	'+912456678888',	'braj.singh@funitechnologies.com',	'a152e841783914146e4bcd4f39100686',	'Chembur',	'Mumbai',	'',	'Fhj',	0,	1,	0,	1,	'28.606607',	'77.364895',	'2014-06-14 16:05:43',	1),
(30,	'Test',	'+915467655445',	'saumya.ramanan@gmail.com',	'1e10212ee024b1bb90bb186e2db4f0c6',	'Dongri',	'Mumbai',	'',	'Test',	1,	1,	1,	1,	'28.606607',	'77.364895',	'2014-06-15 22:58:23',	1);

-- 2014-06-20 09:45:02
