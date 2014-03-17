-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 17, 2014 at 05:58 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `guestbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `action_performed` varchar(255) NOT NULL,
  `previous_values` text NOT NULL,
  `new_values` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `performed_by` int(11) NOT NULL,
  `user_ip` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` float(7,2) NOT NULL,
  `no_of_days` smallint(4) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `price`, `no_of_days`, `description`, `created`, `modified`) VALUES
(1, 'aaa', 20.00, 180, 'gf', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `about_me` text,
  `qualification` text,
  `specialization` text,
  `street_address_1` varchar(100) DEFAULT NULL,
  `street_address_2` varchar(100) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `state` int(11) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `dob` date NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `is_mobile_private` tinyint(1) NOT NULL DEFAULT '1',
  `facebook_id` varchar(50) DEFAULT NULL,
  `twitter_id` varchar(50) DEFAULT NULL,
  `is_public_profile` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `first_name`, `last_name`, `email`, `about_me`, `qualification`, `specialization`, `street_address_1`, `street_address_2`, `city`, `state`, `country`, `zip`, `dob`, `mobile`, `is_mobile_private`, `facebook_id`, `twitter_id`, `is_public_profile`, `created`, `modified`) VALUES
(1, 1, 'Ashish', 'Chopra', 'ashish@guestbook.com', '', '', '', '', '', 0, 0, 0, '', '0000-00-00', '', 1, '', '', 1, '2014-02-01 22:21:00', '2014-02-01 22:21:00'),
(3, 6, 'ashish', 'chopra', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', '0000-00-00', '', 1, NULL, NULL, 1, '2014-02-17 14:57:18', '2014-02-17 14:57:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_pwd` varchar(50) NOT NULL,
  `password_reset_key` varchar(50) DEFAULT NULL,
  `password_reset_key_time` timestamp NULL DEFAULT NULL,
  `is_app_access` tinyint(1) NOT NULL DEFAULT '1',
  `user_type` tinyint(2) NOT NULL COMMENT '1=Super, 2=Lawyer, 3=Staff',
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `plan_expiry_date` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_login_ip` varchar(10) DEFAULT NULL,
  `is_forgot` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive, 3=Deleted',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_pwd`, `password_reset_key`, `password_reset_key_time`, `is_app_access`, `user_type`, `parent_id`, `plan_expiry_date`, `last_login`, `last_login_ip`, `is_forgot`, `status`, `created`, `modified`) VALUES
(1, 'Ashish', 'Chopra', 'ashish@guestbook.com', '123456', 'e10adc3949ba59abbe56e057f20f883e', '2014-02-09 22:19:55', 1, 1, 0, '0000-00-00 00:00:00', '2014-02-17 04:16:52', '127.0.0.1', 0, 1, '2014-02-01 22:19:30', '2014-02-17 16:16:52'),
(2, 'temp', 'bhaji', 'temp@guestbook.com', '123456', NULL, '2014-02-16 11:08:59', 1, 2, 0, '0000-00-00 00:00:00', NULL, NULL, 0, 2, '2014-02-09 11:08:31', '2014-02-17 16:18:35'),
(6, 'ashish', 'chopra', 'ashish@ashish.com', '123456', NULL, NULL, 1, 2, 0, '2014-08-16 14:57:18', NULL, NULL, 0, 2, '2014-02-17 14:57:18', '2014-02-17 16:18:35');

-- --------------------------------------------------------

--
-- Table structure for table `user_transactions`
--

CREATE TABLE IF NOT EXISTS `user_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `amount` float(7,2) NOT NULL,
  `mode_of_payment` varchar(50) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `plan_description` text NOT NULL,
  `no_of_days` smallint(4) NOT NULL,
  `plan_expiry_date` datetime NOT NULL,
  `discount_type` tinyint(2) NOT NULL COMMENT '1=Percent, 2=Lumpsum',
  `discount_value` float(5,2) NOT NULL,
  `discount_amount` float(7,2) NOT NULL,
  `notes` text NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_transactions`
--

INSERT INTO `user_transactions` (`id`, `user_id`, `plan_id`, `amount`, `mode_of_payment`, `transaction_id`, `plan_name`, `plan_description`, `no_of_days`, `plan_expiry_date`, `discount_type`, `discount_value`, `discount_amount`, `notes`, `created`, `created_by`) VALUES
(1, 6, 1, -80.00, '', '', 'aaa', '', 180, '2014-08-16 14:57:18', 1, 20.00, 100.00, '', '2014-02-17 14:57:19', 0);
