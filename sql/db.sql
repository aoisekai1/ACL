-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2023 at 03:36 
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
  `group_code` varchar(6) NOT NULL,
  `group_smenu` varchar(6) DEFAULT NULL,
  `class_name` varchar(50) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `sub_status` enum('L','H','S') DEFAULT 'L',
  `label_sort` int(11) NOT NULL DEFAULT '0',
  `description` varchar(256) DEFAULT NULL,
RIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `privillage_users`
--

INSERT INTO `privillage_users` (`id`, `privillage_group_code`, `user_code`, `status`) VALUES
(2, 'PG0002', 'USR001', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `is_maintenance`, `link_maintenance`, `role_code_access_all`, `default_redirect`) VALUES
(1, 0, '/maintenance', 0, '/login');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(8) NOT NULL,
  `role_code` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `code`, `username`, `password`, `role_code`) VALUES
(1, 'USR001', 'Diana', '12345', 1),
(2, 'USR002', 'Mina', '12345', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
