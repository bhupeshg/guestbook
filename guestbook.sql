-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Jul 11, 2015 at 02:53 PM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `guestbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
`id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `lawyer_id` bigint(20) NOT NULL,
  `datetime` datetime NOT NULL,
  `notes` text NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=Pending, 2=Closed',
  `is_deleted` tinyint(2) NOT NULL DEFAULT '0' COMMENT '''0''=No, ''1''=''Yes''',
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  `created_by` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `case_hearings`
--

CREATE TABLE `case_hearings` (
`id` bigint(20) NOT NULL,
  `case_id` bigint(20) NOT NULL,
  `client_id` bigint(20) NOT NULL,
  `date` datetime NOT NULL,
  `judge` varchar(100) NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  `notes` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'Pending',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `case_payments`
--

CREATE TABLE `case_payments` (
`id` bigint(20) NOT NULL,
  `case_id` bigint(20) NOT NULL,
  `type` varchar(10) NOT NULL,
  `amount` float(9,2) NOT NULL,
  `notes` varchar(250) NOT NULL,
  `date` date NOT NULL,
  `created` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_cases`
--

CREATE TABLE `client_cases` (
`id` bigint(20) NOT NULL,
  `title` varchar(30) NOT NULL,
  `number` varchar(30) DEFAULT NULL,
  `ref_number` varchar(30) DEFAULT NULL,
  `court` varchar(30) DEFAULT NULL,
  `type` varchar(10) NOT NULL,
  `stage` varchar(20) DEFAULT NULL,
  `fee_settled` float(10,2) DEFAULT NULL,
  `filing_date` date DEFAULT NULL,
  `referred_by` bigint(20) DEFAULT NULL,
  `description` text,
  `client_id` bigint(20) DEFAULT NULL,
  `representing` enum('Petitionar','Defendant') NOT NULL,
  `client_first_name` varchar(50) NOT NULL,
  `client_last_name` varchar(50) NOT NULL,
  `client_email` varchar(50) NOT NULL,
  `client_phone_number` varchar(15) DEFAULT NULL,
  `client_alternate_number` int(15) DEFAULT NULL,
  `opponent_first_name` varchar(50) NOT NULL,
  `opponent_last_name` varchar(50) NOT NULL,
  `opponent_lawyer` varchar(50) NOT NULL,
  `opponent_phone_number` varchar(15) NOT NULL,
  `opponent_email` varchar(50) NOT NULL,
  `opponent_postal_address` varchar(250) NOT NULL,
  `previous_hearing_date` datetime DEFAULT NULL,
  `next_hearing_date` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `modified` datetime DEFAULT NULL,
  `modified_by` bigint(20) DEFAULT NULL,
  `created` datetime NOT NULL,
  `created_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `value` float(7,2) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=Fixed, 2=Percent',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `name`, `from`, `to`, `value`, `type`, `status`, `created`, `modified`) VALUES
(1, 'Coupon 1', '2014-03-16 00:00:00', '2014-03-26 00:00:00', 10.00, 2, 1, '2014-03-16 00:00:00', '2014-03-16 00:00:00'),
(2, 'Coupon 2', '2014-03-16 00:00:00', '2014-03-29 00:00:00', 2.00, 1, 1, '2014-03-16 00:00:00', '2014-03-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
`id` bigint(20) NOT NULL,
  `action_performed` varchar(255) NOT NULL,
  `previous_values` text NOT NULL,
  `new_values` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `performed_by` int(11) NOT NULL,
  `entity_id` int(11) NOT NULL,
  `user_ip` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Manage Lawyers', '2014-06-11 21:53:41', '2014-06-11 21:53:41'),
(2, 'Manage Cases', '2014-06-11 21:53:41', '2014-06-11 21:53:41'),
(3, 'Manage Staff', '2014-09-14 19:22:57', '2014-09-14 19:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `module_permissions`
--

CREATE TABLE `module_permissions` (
`id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL COMMENT 'Combination of Controller and Action',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_permissions`
--

INSERT INTO `module_permissions` (`id`, `module_id`, `name`, `url`, `created`, `modified`) VALUES
(1, 1, 'Add Lawyer', 'admins/addLawyer', '2014-06-11 22:04:59', '2014-06-11 22:04:59'),
(2, 1, 'List Lawyers', 'admins/manageLawyers', '2014-06-11 22:04:59', '2014-06-11 22:04:59'),
(3, 2, 'Add Case', 'cases/add', '2014-06-11 22:04:59', '2014-06-11 22:04:59'),
(4, 2, 'List Cases', 'cases/list', '2014-06-11 22:04:59', '2014-06-11 22:04:59'),
(5, 3, 'Add Staff', 'users/addStaff', '2014-09-14 19:22:57', '2014-09-14 19:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
`id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` float(7,2) NOT NULL,
  `no_of_days` smallint(4) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `price`, `no_of_days`, `description`, `created`, `modified`) VALUES
(1, 'aaa', 20.00, 180, 'gf', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
`id` int(11) NOT NULL,
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
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `first_name`, `last_name`, `email`, `about_me`, `qualification`, `specialization`, `street_address_1`, `street_address_2`, `city`, `state`, `country`, `zip`, `dob`, `mobile`, `is_mobile_private`, `facebook_id`, `twitter_id`, `is_public_profile`, `created`, `modified`, `modified_by`) VALUES
(1, 1, 'Ashish', 'Chopra', 'ashish@guestbook.com', '', '', '', '', '', 0, 0, 0, '', '0000-00-00', '', 1, '', '', 1, '2014-02-01 22:21:00', '2014-02-01 22:21:00', 0),
(3, 6, 'ashish', 'chopra', '', NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', '0000-00-00', '', 1, NULL, NULL, 1, '2014-02-17 14:57:18', '2014-02-17 14:57:18', 0),
(5, 7, 'b', 'b', 'aashish@guestbook.com', NULL, NULL, NULL, '1111', '22222', 1, 1, 1, '122221', '2014-02-03', '34567u8i9', 1, NULL, NULL, 1, '2014-03-26 19:41:40', '2014-03-27 14:13:57', NULL),
(6, 10, 's', 's', 'ashishaaaaa@guestbook.com', NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', '0000-00-00', '222323', 1, NULL, NULL, 1, '2014-05-05 16:09:07', '2014-05-05 16:09:07', NULL),
(7, 11, 'Staff', 'lname', 'ashishuuuu@guestbook.com', NULL, NULL, NULL, 's', 'sd', 1, 1, 1, '1', '0000-00-00', '222323', 1, NULL, NULL, 1, '2014-05-20 18:34:04', '2014-10-04 16:03:19', NULL),
(8, 12, 'xczxcczx', 'zxczxc', 'ashish@fhc.com', NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', '0000-00-00', '23213213212', 1, NULL, NULL, 1, '2015-03-14 12:19:17', '2015-03-14 12:19:17', NULL),
(9, 13, 'name', 'zxczxc', 'ashish1@fhc.com', NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', '1915-03-22', '23213213212', 1, NULL, NULL, 1, '2015-03-14 12:20:10', '2015-03-22 14:49:30', NULL),
(10, 14, 'CF', 'CL', 'c@guestbook.com', NULL, NULL, NULL, 'A1', 'A2', 1, 1, 1, '161001', '1985-02-21', '9876543210', 1, NULL, NULL, 1, '2015-04-26 07:31:37', '2015-07-11 14:51:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
`id` int(11) NOT NULL,
  `role` tinyint(2) NOT NULL COMMENT '1=Super, 2=Lawyer, 3=Staff, 4=AdminStaff, 5=FrontEndUser',
  `module_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role`, `module_id`, `created`, `modified`) VALUES
(1, 2, 1, '2014-06-11 22:04:59', '2014-06-11 22:04:59'),
(2, 2, 2, '2014-06-11 22:04:59', '2014-06-11 22:04:59');

-- --------------------------------------------------------

--
-- Table structure for table `staff_roles`
--

CREATE TABLE `staff_roles` (
`id` smallint(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `type` enum('Admin','Lawyer') NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=No, 1=Yes',
  `created` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_roles`
--

INSERT INTO `staff_roles` (`id`, `name`, `type`, `active`, `created`) VALUES
(1, 'Staff1', 'Lawyer', '1', '2014-05-05 00:05:14'),
(2, 'Staff2', 'Lawyer', '1', '2014-05-05 00:05:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
`id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `user_pwd` varchar(100) NOT NULL,
  `password_reset_key` varchar(50) DEFAULT NULL,
  `password_reset_key_time` timestamp NULL DEFAULT NULL,
  `is_app_access` tinyint(1) NOT NULL DEFAULT '1',
  `user_type` tinyint(2) NOT NULL COMMENT '1=Super, 2=Lawyer, 3=Staff, 4=Client, 5=AdminStaff',
  `staff_role_id` smallint(6) DEFAULT NULL,
  `parent_id` bigint(20) NOT NULL DEFAULT '0',
  `plan_expiry_date` datetime NOT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(10) DEFAULT NULL,
  `is_forgot` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1=Active, 2=Inactive',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=''No'', 1=''Yes''',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_pwd`, `password_reset_key`, `password_reset_key_time`, `is_app_access`, `user_type`, `staff_role_id`, `parent_id`, `plan_expiry_date`, `last_login`, `last_login_ip`, `is_forgot`, `status`, `is_deleted`, `created`, `modified`, `created_by`, `modified_by`) VALUES
(1, 'Ashish', 'Chopra', 'ashish@guestbook.com', '4de93336fa559ccc2b8d76c66fbca4b83d061878982a664bd4abd6871a8f0efc', NULL, '2014-02-09 16:49:55', 1, 1, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '::1', 0, 1, 0, '2014-02-01 22:19:30', '2015-02-07 06:07:29', NULL, NULL),
(2, 'temp', 'bhaji', 'temp@guestbook.com', '123456', NULL, '2014-02-16 05:38:59', 1, 2, NULL, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '::1', 0, 1, 0, '2014-02-09 11:08:31', '2015-07-11 14:51:23', NULL, NULL),
(6, 'ashish', 'chopra', 'ashish@ashish.com', '123456', NULL, '2014-03-02 07:39:27', 1, 2, NULL, 0, '2014-08-16 14:57:18', '0000-00-00 00:00:00', '::1', 0, 1, 0, '2014-02-17 14:57:18', '2015-03-22 14:49:14', NULL, NULL),
(7, 'b', 'b', 'aashish@guestbook.com', '123456', NULL, NULL, 1, 2, NULL, 0, '2014-09-22 19:41:40', '0000-00-00 00:00:00', '127.0.0.1', 0, 1, 0, '2014-03-26 19:41:40', '2014-04-27 10:09:19', NULL, NULL),
(10, 's', 's', 'ashishaaaaa@guestbook.com', '123456', NULL, NULL, 1, 3, 1, 0, '0000-00-00 00:00:00', NULL, NULL, 0, 1, 0, '2014-05-05 16:09:07', '2014-05-05 16:09:07', NULL, NULL),
(11, 'Staff', 'lname', 'ashishuuuu@guestbook.com', '123456', NULL, NULL, 1, 3, 1, 0, '0000-00-00 00:00:00', NULL, NULL, 0, 2, 0, '2014-05-20 18:34:04', '2014-10-04 16:03:19', NULL, NULL),
(12, 'xczxcczx', 'zxczxc', 'ashish@fhc.com', '1111111', NULL, NULL, 1, 4, NULL, 0, '0000-00-00 00:00:00', NULL, NULL, 0, 2, 1, '2015-03-14 12:19:17', '2015-03-14 12:35:49', NULL, NULL),
(13, 'name', 'zxczxc', 'ashish1@fhc.com', '123456', NULL, NULL, 1, 4, NULL, 2, '0000-00-00 00:00:00', NULL, NULL, 0, 1, 0, '2015-03-14 12:20:10', '2015-03-22 14:49:30', NULL, NULL),
(14, 'CF', 'CL', 'c@guestbook.com', '123456', NULL, NULL, 1, 4, NULL, 2, '0000-00-00 00:00:00', NULL, NULL, 0, 1, 0, '2015-04-26 07:31:37', '2015-07-11 14:51:10', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_modules`
--

CREATE TABLE `user_modules` (
`id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_modules`
--

INSERT INTO `user_modules` (`id`, `user_id`, `module_id`, `created`, `modified`) VALUES
(1, 2, 2, '2014-06-11 22:04:59', '2014-06-11 22:04:59'),
(2, 4, 2, '2014-06-11 22:04:59', '2014-06-11 22:04:59'),
(3, 1, 1, '2014-09-04 16:28:52', '2014-09-04 16:28:52'),
(4, 1, 2, '2014-09-04 16:28:52', '2014-09-04 16:28:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_module_permissions`
--

CREATE TABLE `user_module_permissions` (
`id` bigint(20) NOT NULL,
  `user_module_id` bigint(20) NOT NULL,
  `module_permission_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_module_permissions`
--

INSERT INTO `user_module_permissions` (`id`, `user_module_id`, `module_permission_id`, `created`, `modified`) VALUES
(1, 3, 1, '2014-09-13 18:48:39', '2014-09-13 18:48:39'),
(2, 3, 2, '2014-09-13 18:48:39', '2014-09-13 18:48:39'),
(3, 4, 4, '2014-09-13 18:48:39', '2014-09-13 18:48:39');

-- --------------------------------------------------------

--
-- Table structure for table `user_transactions`
--

CREATE TABLE `user_transactions` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `amount` float(7,2) NOT NULL,
  `mode_of_payment` varchar(50) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `no_of_days` smallint(6) NOT NULL,
  `details` text NOT NULL,
  `plan_expiry_date` datetime NOT NULL,
  `discount_type` tinyint(2) NOT NULL COMMENT '1=Percent, 2=Lumpsum',
  `discount_value` float(5,2) NOT NULL,
  `discount_amount` float(7,2) NOT NULL,
  `notes` text NOT NULL,
  `created` datetime NOT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_transactions`
--

INSERT INTO `user_transactions` (`id`, `user_id`, `plan_id`, `coupon_id`, `amount`, `mode_of_payment`, `transaction_id`, `plan_name`, `no_of_days`, `details`, `plan_expiry_date`, `discount_type`, `discount_value`, `discount_amount`, `notes`, `created`, `created_by`) VALUES
(1, 7, 1, 1, 10.00, '', '', 'aaa', 180, '{"user_name":"b b","plan_description":"gf"}', '2014-09-22 19:41:40', 2, 10.00, 10.00, '', '2014-03-26 19:41:40', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_hearings`
--
ALTER TABLE `case_hearings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `case_payments`
--
ALTER TABLE `case_payments`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_cases`
--
ALTER TABLE `client_cases`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_permissions`
--
ALTER TABLE `module_permissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_roles`
--
ALTER TABLE `staff_roles`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_modules`
--
ALTER TABLE `user_modules`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_module_permissions`
--
ALTER TABLE `user_module_permissions`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_transactions`
--
ALTER TABLE `user_transactions`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `case_hearings`
--
ALTER TABLE `case_hearings`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `case_payments`
--
ALTER TABLE `case_payments`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `client_cases`
--
ALTER TABLE `client_cases`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `module_permissions`
--
ALTER TABLE `module_permissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `staff_roles`
--
ALTER TABLE `staff_roles`
MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user_modules`
--
ALTER TABLE `user_modules`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_module_permissions`
--
ALTER TABLE `user_module_permissions`
MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_transactions`
--
ALTER TABLE `user_transactions`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
