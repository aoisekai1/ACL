-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 06, 2023 at 06:28 
-- Server version: 5.6.12
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_belajar`
--
CREATE DATABASE IF NOT EXISTS `db_belajar` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_belajar`;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL,
  `group_code` varchar(6) DEFAULT NULL,
  `group_smenu` varchar(6) DEFAULT NULL,
  `class_name` varchar(50) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `sub_status` enum('L','H','S') DEFAULT 'L',
  `label_sort` int(11) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `code`, `label`, `group_code`, `group_smenu`, `class_name`, `url`, `status`, `sub_status`, `label_sort`, `description`) VALUES
(4, 'M00001', 'Privillages', 'PG', NULL, '', NULL, 1, 'L', 200, 'Label menu'),
(5, 'M00002', 'Transaction', 'T', NULL, NULL, NULL, 1, 'L', 400, '0'),
(6, 'M00003', 'Order', 'T', 'TO', NULL, NULL, 1, 'H', 410, '0'),
(7, 'M00004', 'Payment', 'T', NULL, NULL, NULL, 1, 'H', 420, '0'),
(8, 'M00005', 'Privillage Menu', 'PG', NULL, 'PmController', NULL, 0, 'H', 210, '0'),
(9, 'M00006', 'Privillage User', 'PG', NULL, 'PuController', NULL, 0, 'H', 220, '0'),
(10, 'M00007', 'Master', 'M', NULL, NULL, NULL, 1, 'L', 300, '0'),
(11, 'M00008', 'Cancel', 'T', 'TOS', 'CancelController', '/menu', 1, 'S', 413, '0'),
(12, 'M00009', 'Success', 'T', 'TOS', NULL, '/menu/create', 1, 'S', 412, '0'),
(13, 'M00010', 'Menu', 'M', NULL, 'MenuController', 'menu', 1, 'H', 310, '0'),
(14, 'M00011', 'Group', 'PG', NULL, 'PrivillageController', 'privillage', 1, 'H', 230, '0'),
(20, 'M00012', 'Setting', 'ST', NULL, 'SettingController', '/setting', 1, 'L', 500, 'Menu Setting'),
(21, 'M00013', 'Tes', 'EX', NULL, 'ExampleController', 'tes', 1, 'L', 600, 'Menu testing');

-- --------------------------------------------------------

--
-- Table structure for table `privillage_groups`
--

CREATE TABLE IF NOT EXISTS `privillage_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `label` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;

-- --------------------------------------------------------

--
-- Table structure for table `privillage_menus`
--

CREATE TABLE IF NOT EXISTS `privillage_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privillage_group_code` varchar(6) NOT NULL,
  `menu_code` varchar(6) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `is_insert` tinyint(1) NOT NULL DEFAULT '0',
  `is_update` tinyint(1) NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13;

-- --------------------------------------------------------

--
-- Table structure for table `privillage_users`
--

CREATE TABLE IF NOT EXISTS `privillage_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `privillage_group_code` varchar(6) NOT NULL,
  `user_code` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `code`, `description`) VALUES
(1, 1, 'Super Admin'),
(2, 20, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_maintenance` tinyint(1) NOT NULL DEFAULT '0',
  `link_maintenance` varchar(255) DEFAULT NULL,
  `role_code_access_all` int(11) DEFAULT NULL,
  `default_redirect` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `is_maintenance`, `link_maintenance`, `role_code_access_all`, `default_redirect`) VALUES
(4, 0, NULL, 1, '/dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(8) NOT NULL,
  `role_code` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `code`, `username`, `password`, `role_code`) VALUES
(1, 'USR001', 'Diana', '12345', 1),
(2, 'USR002', 'Mina', '12345', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
