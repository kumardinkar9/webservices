-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 04, 2014 at 01:13 PM
-- Server version: 5.5.35-0ubuntu0.13.10.2
-- PHP Version: 5.5.3-1ubuntu2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `health_advice`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT,
  `posted_question_id` int(11) NOT NULL COMMENT 'FK for question id',
  `question_post_patient_id` int(11) NOT NULL COMMENT 'FK for social media user table',
  `suggested_instructor_id` int(11) NOT NULL COMMENT 'FK for instructor table',
  `answer` text NOT NULL,
  `post_date_time` datetime NOT NULL,
  PRIMARY KEY (`answer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Store all answer according to question ' AUTO_INCREMENT=8 ;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `posted_question_id`, `question_post_patient_id`, `suggested_instructor_id`, `answer`, `post_date_time`) VALUES
(1, 1, 1, 1, 'dsasadasdasdasdasdsadasdsadsa', '2014-04-01 15:17:26'),
(2, 1, 1, 1, 'dsasadasdasdasdasdsadasdsadsa', '2014-04-01 15:18:13'),
(3, 1, 1, 1, 'dsasadasdasdasdasdsadasdsadsa', '2014-04-01 15:18:54'),
(4, 1, 1, 1, 'dsasadasdasdasdasdsadasdsadsa', '2014-04-01 15:19:16'),
(5, 1, 1, 1, 'dsasadasdasdasdasdsadasdsadsa', '2014-04-01 15:20:33'),
(6, 1, 1, 1, 'dsasadasdasdasdasdsadasdsadsa', '2014-04-01 15:21:15'),
(7, 1, 1, 1, 'dsasadasdasdasdasdsadasdsadsa', '2014-04-01 15:22:25');

-- --------------------------------------------------------

--
-- Table structure for table `instructors_rating`
--

CREATE TABLE IF NOT EXISTS `instructors_rating` (
  `instructors_rating_id` int(11) NOT NULL AUTO_INCREMENT,
  `instructors_id` int(11) NOT NULL COMMENT 'FK for instructor table',
  `patient_id` int(11) NOT NULL COMMENT 'Fk for user table',
  `rating_value` int(5) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  PRIMARY KEY (`instructors_rating_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Instructor rating given by user' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `instructors_rating`
--

INSERT INTO `instructors_rating` (`instructors_rating_id`, `instructors_id`, `patient_id`, `rating_value`, `device_id`) VALUES
(1, 1, 1, 4, '43432432432'),
(2, 2, 1, 4, '43432432432'),
(3, 1, 2, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `patient_id` int(11) NOT NULL COMMENT 'FK for social_media_login_user table',
  `question_post_date_time` datetime NOT NULL,
  `question_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=approved,0=unapproved',
  PRIMARY KEY (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Store user ask question to instructor ' AUTO_INCREMENT=16 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `question`, `patient_id`, `question_post_date_time`, `question_status`) VALUES
(1, 'How do i loose weight?', 1, '2014-04-01 12:07:23', 1),
(2, 'How do i loose weight?', 1, '2014-04-01 12:07:58', 1),
(3, 'How do i loose weight?', 1, '2014-04-01 12:08:29', 1),
(4, 'How do i loose weight?', 1, '2014-04-01 12:50:08', 1),
(5, 'How do i loose weight?', 1, '2014-04-01 12:50:24', 1),
(6, 'How do i loose weight?', 1, '2014-04-01 12:50:51', 1),
(7, 'How do i loose weight?', 1, '2014-04-01 12:51:09', 1),
(8, 'sdasdsadsadsasadsa', 1, '2014-04-01 13:44:20', 1),
(9, 'sdasdsadsadsasadsa', 1, '2014-04-01 13:44:54', 1),
(10, 'sdasdsadsadsasadsa', 1, '2014-04-01 13:45:27', 1),
(11, 'sdasdsadsadsasadsa', 1, '2014-04-01 13:46:07', 1),
(12, 'sdasdsadsadsasadsa', 1, '2014-04-01 13:46:18', 1),
(13, 'sdasdsadsadsasadsa', 1, '2014-04-01 13:47:23', 1),
(14, 'sdasdsadsadsasadsa', 1, '2014-04-01 13:52:49', 1),
(15, 'sdasdsadsadsasadsa', 1, '2014-04-01 13:53:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `social_media_login_user`
--

CREATE TABLE IF NOT EXISTS `social_media_login_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `social_user_id` int(11) NOT NULL COMMENT 'Social media user id ',
  `user_name` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Male,1=Female',
  `login_date_time` datetime NOT NULL,
  `login_type` varchar(255) NOT NULL COMMENT 'Identification for user',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Table hold user information through social media login' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `social_media_login_user`
--

INSERT INTO `social_media_login_user` (`user_id`, `social_user_id`, `user_name`, `fname`, `lname`, `email`, `gender`, `login_date_time`, `login_type`) VALUES
(1, 1, 'bibhuti', 'bibhuti', 'ranjan', 'bibhuti.ranjan@funkitechnologies.com', 0, '2014-03-12 00:00:00', 'Facebook'),
(14, 32, 'ranjan_bibhuti', 'Ranjan', 'Vibhuti', 'bibhuti@gmail.com', 0, '2014-03-31 13:05:41', 'Twitter');

-- --------------------------------------------------------

--
-- Table structure for table `user_booking`
--

CREATE TABLE IF NOT EXISTS `user_booking` (
  `booking_id` int(11) NOT NULL AUTO_INCREMENT,
  `booker_id` int(11) NOT NULL COMMENT 'FK for  social_media_login_user',
  `instructor_id` int(11) NOT NULL,
  `discuss_topic` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `length_time` varchar(255) NOT NULL,
  `chat_type` varchar(255) NOT NULL COMMENT 'which type chat',
  PRIMARY KEY (`booking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Store user booking details' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_booking`
--

INSERT INTO `user_booking` (`booking_id`, `booker_id`, `instructor_id`, `discuss_topic`, `booking_date`, `length_time`, `chat_type`) VALUES
(1, 1, 1, 'health', '2014-04-13', '4', 'Video');

-- --------------------------------------------------------

--
-- Table structure for table `user_instructors`
--

CREATE TABLE IF NOT EXISTS `user_instructors` (
  `instructor_id` int(11) NOT NULL AUTO_INCREMENT,
  `instructor_user_name` varchar(255) NOT NULL,
  `instructor_password` varchar(255) NOT NULL,
  `instructor_email` varchar(255) NOT NULL,
  `instructor_phone_number` varchar(255) NOT NULL,
  `instructor_gender` tinyint(1) NOT NULL COMMENT '0=Male;1=Female',
  `instructor_about` text NOT NULL,
  `instructor_registraton_date_time` datetime NOT NULL,
  `instructor_approve_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=Not approve;1=approved',
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `skills` varchar(255) NOT NULL,
  `video_call_price` varchar(10) NOT NULL DEFAULT '0',
  `one_two_one_chat_price` varchar(10) NOT NULL DEFAULT '0',
  `group_chat_price` varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`instructor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='This table store for instructors details' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_instructors`
--

INSERT INTO `user_instructors` (`instructor_id`, `instructor_user_name`, `instructor_password`, `instructor_email`, `instructor_phone_number`, `instructor_gender`, `instructor_about`, `instructor_registraton_date_time`, `instructor_approve_status`, `fname`, `lname`, `skills`, `video_call_price`, `one_two_one_chat_price`, `group_chat_price`) VALUES
(1, 'bibhuti', '9a78dae0dfc8f1da35d3bf7be49973d5', 'bibhuti@gmail.com', '', 0, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '2014-03-31 03:09:16', 1, 'BIBHUTI', 'RANJAN', 'Developer', '2', '2', '2'),
(6, 'bibhuti_ranjan', '2f78244beaad23acd66edd3b1b97c848', 'bibhuti123@gmail.com', '', 0, 'It is a long established fact that a reader will be distracted by the readable c', '2014-03-31 16:47:58', 0, 'RANJAN', 'BIBHUTI', 'Developer', '2', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `user_instructors_availability`
--

CREATE TABLE IF NOT EXISTS `user_instructors_availability` (
  `availability_id` int(11) NOT NULL AUTO_INCREMENT,
  `instructor_id` int(11) NOT NULL COMMENT 'FK for instructor table',
  `available_date` date NOT NULL,
  `topic` varchar(255) NOT NULL,
  `video_available_date` date NOT NULL,
  `chat_available_date` date NOT NULL,
  PRIMARY KEY (`availability_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Instructor availability information' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_instructors_availability`
--

INSERT INTO `user_instructors_availability` (`availability_id`, `instructor_id`, `available_date`, `topic`, `video_available_date`, `chat_available_date`) VALUES
(1, 1, '2014-04-12', 'Talk for neurologist', '2014-04-12', '2014-04-12');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
