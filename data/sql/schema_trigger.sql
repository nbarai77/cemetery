-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2012 at 04:10 PM
-- Server version: 5.1.56
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cemetery`
--

-- --------------------------------------------------------

--
-- Table structure for table `ar_area`
--

CREATE TABLE IF NOT EXISTS `ar_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `area_code` varchar(50) NOT NULL,
  `area_description` text,
  `area_control_numberr` varchar(50) DEFAULT NULL,
  `area_name` varchar(50) NOT NULL,
  `area_user` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `area_map_path` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cemetery_id` (`cem_cemetery_id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_grave`
--

CREATE TABLE IF NOT EXISTS `ar_grave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `ar_section_id` int(11) DEFAULT NULL,
  `ar_row_id` int(11) DEFAULT NULL,
  `ar_plot_id` int(11) DEFAULT NULL,
  `ar_grave_status_id` int(11) NOT NULL,
  `cem_stonemason_id` int(11) DEFAULT NULL,
  `grave_number` varchar(25) NOT NULL,
  `grave_image1` varchar(255) DEFAULT NULL,
  `grave_image2` varchar(255) DEFAULT NULL,
  `length` varchar(10) DEFAULT '0',
  `width` varchar(10) DEFAULT '0',
  `height` varchar(30) DEFAULT '0',
  `unit_type_id` int(11) DEFAULT NULL,
  `details` text,
  `monument` varchar(255) DEFAULT NULL,
  `monuments_grave_position` varchar(255) DEFAULT NULL,
  `monuments_unit_type` int(11) DEFAULT NULL,
  `monuments_depth` varchar(255) DEFAULT NULL,
  `monuments_width` varchar(255) DEFAULT NULL,
  `monuments_length` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `comment1` text,
  `comment2` text,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `unit_type_id` (`unit_type_id`),
  KEY `country_id` (`country_id`),
  KEY `cemetery_id` (`cem_cemetery_id`),
  KEY `area_id` (`ar_area_id`),
  KEY `section_id` (`ar_section_id`),
  KEY `row_id` (`ar_row_id`),
  KEY `plot_id` (`ar_plot_id`),
  KEY `stone_mason_id` (`cem_stonemason_id`),
  KEY `ar_grave_status_id` (`ar_grave_status_id`),
  KEY `monuments_unit_type` (`monuments_unit_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=266 ;



--
-- Triggers `ar_grave`
--
DROP TRIGGER IF EXISTS `trig_ins_grave_logs`;
DELIMITER //
CREATE TRIGGER `trig_ins_grave_logs` AFTER INSERT ON `ar_grave`
 FOR EACH ROW BEGIN
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  
  SELECT c.name AS country_name, cem.name AS cemetery_name,
         arr.area_code AS area_code, sec.section_code AS section_code, rw.row_name AS row_name,
		 pt.plot_name AS plot_name, gr.grave_number AS grave_number
  INTO CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER
  FROM ar_grave gr
  LEFT JOIN country c ON gr.country_id = c.id 
  LEFT JOIN cem_cemetery cem ON gr.cem_cemetery_id = cem.id
  LEFT JOIN ar_area arr ON gr.ar_area_id = arr.id
  LEFT JOIN ar_section sec ON gr.ar_section_id = sec.id
  LEFT JOIN ar_row rw ON gr.ar_row_id = rw.id
  LEFT JOIN ar_plot pt ON gr.ar_plot_id = pt.id 
  WHERE gr.id = NEW.id;

  INSERT INTO grave_logs (country_name, cem_name, cem_id, area_name, section_name, row_name, plot_name, grave_number, operation, operation_date, user_id) 
  	VALUES (CNAME, CEM_NAME, NEW.cem_cemetery_id, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, 'INSERT', NEW.created_at, NEW.user_id);

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_upd_grave_logs`;
DELIMITER //
CREATE TRIGGER `trig_upd_grave_logs` AFTER UPDATE ON `ar_grave`
 FOR EACH ROW BEGIN
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  
  SELECT c.name AS country_name, cem.name AS cemetery_name,
         arr.area_code AS area_code, sec.section_code AS section_code, rw.row_name AS row_name,
		 pt.plot_name AS plot_name, gr.grave_number AS grave_number
  INTO CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER
  FROM ar_grave gr
  LEFT JOIN country c ON gr.country_id = c.id 
  LEFT JOIN cem_cemetery cem ON gr.cem_cemetery_id = cem.id
  LEFT JOIN ar_area arr ON gr.ar_area_id = arr.id
  LEFT JOIN ar_section sec ON gr.ar_section_id = sec.id
  LEFT JOIN ar_row rw ON gr.ar_row_id = rw.id
  LEFT JOIN ar_plot pt ON gr.ar_plot_id = pt.id 
  WHERE gr.id = NEW.id;

  INSERT INTO grave_logs (country_name, cem_name, cem_id, area_name, section_name, row_name, plot_name, grave_number, operation, operation_date, user_id) 
  	VALUES (CNAME, CEM_NAME, NEW.cem_cemetery_id, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, 'UPDATE', NEW.updated_at, NEW.user_id);

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_del_grave_logs`;
DELIMITER //
CREATE TRIGGER `trig_del_grave_logs` BEFORE DELETE ON `ar_grave`
 FOR EACH ROW BEGIN
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  
  SELECT c.name AS country_name, cem.name AS cemetery_name,
         arr.area_code AS area_code, sec.section_code AS section_code, rw.row_name AS row_name,
		 pt.plot_name AS plot_name, gr.grave_number AS grave_number
  INTO CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER
  FROM ar_grave gr
  LEFT JOIN country c ON gr.country_id = c.id 
  LEFT JOIN cem_cemetery cem ON gr.cem_cemetery_id = cem.id
  LEFT JOIN ar_area arr ON gr.ar_area_id = arr.id
  LEFT JOIN ar_section sec ON gr.ar_section_id = sec.id
  LEFT JOIN ar_row rw ON gr.ar_row_id = rw.id
  LEFT JOIN ar_plot pt ON gr.ar_plot_id = pt.id 
  WHERE gr.id = OLD.id;

  INSERT INTO grave_logs (country_name, cem_name, cem_id, area_name, section_name, row_name, plot_name, grave_number, operation, operation_date, user_id) 
  	VALUES (CNAME, CEM_NAME, OLD.cem_cemetery_id, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, 'DELETE', NOW(), OLD.user_id);

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ar_grave_maintenance`
--

CREATE TABLE IF NOT EXISTS `ar_grave_maintenance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `ar_section_id` int(11) DEFAULT NULL,
  `ar_row_id` int(11) DEFAULT NULL,
  `ar_plot_id` int(11) DEFAULT NULL,
  `ar_grave_id` int(11) NOT NULL,
  `date_paid` date DEFAULT NULL,
  `onsite_work_date` date DEFAULT NULL,
  `amount_paid` varchar(255) DEFAULT NULL,
  `receipt` varchar(255) DEFAULT NULL,
  `renewal_term` enum('6 Months','1 Year','5 Years','10 Years','Perpetual') NOT NULL,
  `renewal_date` date DEFAULT NULL,
  `interred_name` varchar(255) DEFAULT NULL,
  `interred_surname` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `address` text,
  `subrub` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `user_country` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `notes` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`,`cem_cemetery_id`,`ar_grave_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`),
  KEY `ar_area_id` (`ar_area_id`),
  KEY `ar_section_id` (`ar_section_id`),
  KEY `ar_row_id` (`ar_row_id`),
  KEY `ar_plot_id` (`ar_plot_id`),
  KEY `ar_grave_id` (`ar_grave_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;



--
-- Table structure for table `ar_grave_status`
--

CREATE TABLE IF NOT EXISTS `ar_grave_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grave_status` varchar(50) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ar_grave_status`
--

INSERT INTO `ar_grave_status` (`id`, `grave_status`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'Vacant', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Pre-Purchased', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'In Use', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'To Be Investigated', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Tree', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Reserved', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'On Hold', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Allocated', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Obstruction', 1, '2012-03-01 00:00:00', '2012-03-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ar_plot`
--

CREATE TABLE IF NOT EXISTS `ar_plot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `ar_section_id` int(11) DEFAULT NULL,
  `ar_row_id` int(11) DEFAULT NULL,
  `plot_name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `plot_user` varchar(25) DEFAULT NULL,
  `length` varchar(25) DEFAULT NULL,
  `width` varchar(25) DEFAULT NULL,
  `depth` varchar(25) DEFAULT NULL,
  `plot_map_path` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `row_id` (`ar_row_id`),
  KEY `country_id` (`country_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`),
  KEY `ar_area_id` (`ar_area_id`),
  KEY `ar_section_id` (`ar_section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;



--
-- Table structure for table `ar_row`
--

CREATE TABLE IF NOT EXISTS `ar_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `ar_section_id` int(11) DEFAULT NULL,
  `row_name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `row_user` varchar(25) DEFAULT NULL,
  `row_map_path` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`ar_section_id`),
  KEY `country_id` (`country_id`,`cem_cemetery_id`,`ar_area_id`),
  KEY `ar_area_id` (`ar_area_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;



--
-- Table structure for table `ar_section`
--

CREATE TABLE IF NOT EXISTS `ar_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `section_code` varchar(255) NOT NULL,
  `section_name` varchar(255) NOT NULL,
  `first_grave` int(11) DEFAULT '1',
  `last_grave` int(11) DEFAULT '1',
  `section_user` varchar(11) DEFAULT NULL,
  `section_map_path` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `area_id` (`ar_area_id`),
  KEY `country_id` (`country_id`,`cem_cemetery_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;



-- --------------------------------------------------------

--
-- Table structure for table `cem_cemetery`
--

CREATE TABLE IF NOT EXISTS `cem_cemetery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `url` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `address` varchar(255) DEFAULT NULL,
  `suburb_town` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax_area_code` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gmap_code` varchar(2000) DEFAULT NULL,
  `cemetery_map_path` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


CREATE TABLE IF NOT EXISTS `cem_cemetery_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cem_cemetery_id` int(11) NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `doc_description` text,
  `doc_path` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



--
-- Table structure for table `cem_cemetery_fndirector`
--

CREATE TABLE IF NOT EXISTS `cem_cemetery_fndirector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fnd_fndirector_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `funeral_director_id` (`fnd_fndirector_id`),
  KEY `cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cem_cemetery_stonemason`
--

CREATE TABLE IF NOT EXISTS `cem_cemetery_stonemason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cem_cemetery_id` int(11) NOT NULL,
  `cms_stonemason_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cemetery_id` (`cem_cemetery_id`),
  KEY `stone_mason_id` (`cms_stonemason_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cem_chapel`
--

CREATE TABLE IF NOT EXISTS `cem_chapel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;



-- --------------------------------------------------------

--
-- Table structure for table `cem_mail`
--

CREATE TABLE IF NOT EXISTS `cem_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_subject` varchar(255) NOT NULL,
  `mail_body` text,
  `attached_file_name` varchar(255) DEFAULT NULL,
  `mail_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cem_mail_users`
--

CREATE TABLE IF NOT EXISTS `cem_mail_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cem_mail_id` int(11) NOT NULL,
  `from_user_id` bigint(20) NOT NULL,
  `to_user_id` bigint(20) DEFAULT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `sent_status` tinyint(1) NOT NULL DEFAULT '0',
  `read_unread_status` tinyint(1) NOT NULL DEFAULT '0',
  `delete_status` tinyint(1) NOT NULL DEFAULT '0',
  `mail_send_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cem_mail_id` (`cem_mail_id`),
  KEY `from_user_id` (`from_user_id`),
  KEY `to_user_id` (`to_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cem_room`
--

CREATE TABLE IF NOT EXISTS `cem_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;



-- --------------------------------------------------------

--
-- Table structure for table `cem_stonemason`
--

CREATE TABLE IF NOT EXISTS `cem_stonemason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `work_type_stone_mason_id` int(11) DEFAULT '0',
  `bond` varchar(255) DEFAULT NULL,
  `annual_license_fee` varchar(255) DEFAULT NULL,
  `abn_acn_number` varchar(255) DEFAULT NULL,
  `contractors_license_number` varchar(255) DEFAULT NULL,
  `general_induction_cards` varchar(255) DEFAULT NULL,
  `operator_licenses` varchar(255) DEFAULT NULL,
  `list_current_employees` varchar(255) DEFAULT NULL,
  `list_contractors` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


--
-- Table structure for table `cem_stonemason_docs`
--

CREATE TABLE IF NOT EXISTS `cem_stonemason_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `doc_description` text,
  `doc_path` varchar(255) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cem_task_notes`
--

CREATE TABLE IF NOT EXISTS `cem_task_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `task_title` varchar(255) NOT NULL,
  `task_description` text NOT NULL,
  `entry_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;



--
-- Table structure for table `cem_worktype_stonemason`
--

CREATE TABLE IF NOT EXISTS `cem_worktype_stonemason` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `coffin_type`
--

CREATE TABLE IF NOT EXISTS `coffin_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;



--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=277 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'Australia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, ' Afghanistan', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Albania', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Algeria', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Andorra', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Angola', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Antigua and Barbuda', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Argentina', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Armenia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Austria', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Azerbaijan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Bahamas, The', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Bahrain', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Bangladesh', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Barbados', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'Belarus', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'Belgium', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'Belize', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Benin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'Bhutan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Bolivia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'Bosnia and Herzegovina', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'Botswana', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'Brazil', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'Brunei', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'Bulgaria', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'Burkina Faso', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'Burundi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'Cambodia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'Cameroon', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'Canada', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'Cape Verde', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'Central African Republic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'Chad', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'Chile', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'China-Peoples Republic of', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'Colombia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'Comoros', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'Congo-Kinshasa  Democratic Rep', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'Congo-Brazzaville Republic of ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'Costa Rica', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'Cote d Ivoire-Ivory Coast', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'Croatia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'Cuba', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'Cyprus', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'Czech Republic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'Denmark', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'Djibouti', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'Dominica', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'Dominican Republic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'Ecuador', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'Egypt', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'El Salvador', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'Equatorial Guinea', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'Eritrea', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'Estonia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'Ethiopia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'Fiji', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'Finland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'France', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'Gabon', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 'Gambia, The', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'Georgia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 'Germany', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 'Ghana', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'Greece', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 'Grenada', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 'Guatemala', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'Guinea', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 'Guinea-Bissau', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'Guyana', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 'Haiti', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 'Honduras', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 'Hungary', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 'Iceland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 'India', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 'Indonesia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 'Iran', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 'Iraq', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, 'Ireland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, 'Israel', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, 'Italy', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, 'Jamaica', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 'Japan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, 'Jordan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 'Kazakhstan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 'Kenya', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 'Kiribati', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 'Korea-North Korea-Democratic P', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 'Korea-South Korea-Republic of ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, 'Kuwait', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 'Kyrgyzstan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 'Laos', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 'Latvia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, 'Lebanon', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, 'Lesotho', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 'Liberia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(98, 'Libya', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(99, 'Liechtenstein', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(100, 'Lithuania', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(101, 'Luxembourg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(102, 'Macedonia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'Madagascar', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 'Malawi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 'Malaysia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'Maldives', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 'Mali', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(108, 'Malta', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(109, 'Marshall Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(110, 'Mauritania', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(111, 'Mauritius', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(112, 'Mexico', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(113, 'Micronesia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(114, 'Moldova', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(115, 'Monaco', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(116, 'Mongolia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(117, 'Montenegro', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(118, 'Morocco', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(119, 'Mozambique', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(120, 'Myanmar-Burma', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(121, 'Namibia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(122, 'Nauru', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(123, 'Nepal', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(124, 'Netherlands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(125, 'New Zealand', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(126, 'Nicaragua', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(127, 'Niger', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(128, 'Nigeria', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(129, 'Norway', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(130, 'Oman', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(131, 'Pakistan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(132, 'Palau', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(133, 'Panama', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(134, 'Papua New Guinea', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(135, 'Paraguay', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(136, 'Peru', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(137, 'Philippines', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(138, 'Poland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(139, 'Portugal', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(140, 'Qatar', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(141, 'Romania', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(142, 'Russia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(143, 'Rwanda', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(144, 'Saint Kitts and Nevis', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(145, 'Saint Lucia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(146, 'Saint Vincent and the Grenadin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(147, 'Samoa', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(148, 'San Marino', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(149, 'Sao Tome and Principe', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(150, 'Saudi Arabia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(151, 'Senegal', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(152, 'Serbia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(153, 'Seychelles', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(154, 'Sierra Leone', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(155, 'Singapore', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(156, 'Slovakia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(157, 'Slovenia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(158, 'Solomon Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(159, 'Somalia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(160, 'South Africa', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(161, 'Spain', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(162, 'Sri Lanka', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(163, 'Sudan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(164, 'Suriname', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(165, 'Swaziland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(166, 'Sweden', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(167, 'Switzerland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(168, 'Syria', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(169, 'Tajikistan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(170, 'Tanzania', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(171, 'Thailand', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(172, 'Timor-Leste-East Timor', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(173, 'Togo', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(174, 'Tonga', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(175, 'Trinidad and Tobago', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(176, 'Tunisia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(177, 'Turkey', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(178, 'Turkmenistan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(179, 'Tuvalu', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(180, 'Uganda', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(181, 'Ukraine', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(182, 'United Arab Emirates', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(183, 'United Kingdom', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(184, 'United States', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(185, 'Uruguay', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(186, 'Uzbekistan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(187, 'Vanuatu', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(188, 'Vatican City', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(189, 'Venezuela', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(190, 'Vietnam', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(191, 'Yemen', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(192, 'Zambia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(193, 'Zimbabwe', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(194, 'Abkhazia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(195, 'Taiwan, Republic of China', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(196, 'Nagorno-Karabakh', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(197, 'Northern Cyprus', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(198, 'Pridnestrovie-Transnistria-', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(199, 'Somaliland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(200, 'South Ossetia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(201, 'Ashmore and Cartier Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(202, 'Christmas Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(203, 'Cocos-Keeling Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(204, 'Coral Sea Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(205, 'Heard Island and McDonald Isla', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(206, 'Norfolk Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(207, 'New Caledonia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(208, 'French Polynesia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(209, 'Mayotte', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(210, 'Saint Barthelemy', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(211, 'Saint Martin', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(212, 'Saint Pierre and Miquelon', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(213, 'Wallis and Futuna', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(214, 'French Southern and Antarctic ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(215, 'Clipperton Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(216, 'Bouvet Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(217, 'Cook Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(218, 'Niue', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(219, 'Tokelau', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(220, 'Guernsey', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(221, 'Isle of Man', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(222, 'Jersey', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(223, 'Anguilla', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(224, 'Bermuda', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(225, 'British Indian Ocean Territory', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(226, 'British Sovereign Base Areas', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(227, 'British Virgin Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(228, 'Cayman Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(229, 'Falkland Islands-Islas Malvina', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(230, 'Gibraltar', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(231, 'Montserrat', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(232, 'Pitcairn Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(233, 'Saint Helena', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(234, 'South Georgia and the South Sa', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(235, 'Turks and Caicos Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(236, 'Northern Mariana Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(237, 'Puerto Rico', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(238, 'American Samoa', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(239, 'Baker Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(240, 'Guam', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(241, 'Howland Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(242, 'Jarvis Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(243, 'Johnston Atoll', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(244, 'Kingman Reef', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(245, 'Midway Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(246, 'Navassa Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(247, 'Palmyra Atoll', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(248, 'US Virgin Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(249, 'Wake Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(250, 'Hong Kong', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(251, 'Macau', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(252, 'Faroe Islands', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(253, 'Greenland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(254, 'French Guiana', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(255, 'Guadeloupe', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(256, 'Martinique', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(257, 'Reunion', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(258, 'Aland', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(259, 'Aruba', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(260, 'Netherlands Antilles', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(261, 'Svalbard', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(262, 'Ascension', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(263, 'Tristan da Cunha', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(264, 'Antarctica', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(265, 'Kosovo', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(266, 'Palestinian Territories-Gaza S', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(267, 'Western Sahara', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(268, 'Australian Antarctic Territory', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(269, 'Ross Dependency', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(270, 'Peter I Island', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(271, 'Queen Maud Land', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(272, 'British Antarctic Territory', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(275, 'test', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(276, 'Grrrrrrr', 1, '2012-03-06 16:03:20', '2012-03-06 16:03:20');

-- --------------------------------------------------------

--
-- Table structure for table `denomination`
--

CREATE TABLE IF NOT EXISTS `denomination` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Dumping data for table `denomination`
--

INSERT INTO `denomination` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(2, 'BUDDHISM', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'BUDDHISM, Theravada', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'BUDDHISM, Hinayana', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'BUDDHISM, Mahayana', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'BUDDHISM, Tibetan', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'BUDDHISM, Zen', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'BUDDHISM, Pure Land', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'BUDDHISM, Nichiren Japanese', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'CHRISTIANITY', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'CHRISTIANITY, Anglican Church of Austral', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'CHRISTIANITY, Anglican Catholic Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'CHRISTIANITY, Baptist', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'CHRISTIANITY, Brethren', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'CHRISTIANITY, Catholic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'CHRISTIANITY, Western Catholic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'CHRISTIANITY, Maronite Catholic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'CHRISTIANITY, Melkite Catholic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'CHRISTIANITY, Ukrainian Catholic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'CHRISTIANITY, Chaldean Catholic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'CHRISTIANITY,  Churches of Christ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'CHRISTIANITY, Churches of Christ (Confer', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'CHRISTIANITY, Church of Christ (Nondenom', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'CHRISTIANITY, International Church of Ch', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'CHRISTIANITY, Jehovah''s Witnesses', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'CHRISTIANITY, Latter Day Saints', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'CHRISTIANITY, Church of Jesus Christ of ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'CHRISTIANITY, Community of Christ LDS', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'CHRISTIANITY,  Lutheran', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'CHRISTIANITY, Orthodox - Armenian Aposto', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'CHRISTIANITY, Orthodox - Albanian', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'CHRISTIANITY, Orthodox - Antiochian', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'CHRISTIANITY, Orthodox - Coptic Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'CHRISTIANITY, Orthodox - Ethiopian Churc', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'CHRISTIANITY, Orthodox -  Greek', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'CHRISTIANITY, Orthodox - Macedonian', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'CHRISTIANITY, Orthodox - Romanian', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'CHRISTIANITY, Orthodox - Russian', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'CHRISTIANITY, Orthodox - Eastern', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'CHRISTIANITY, Orthodox - Serbian ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'CHRISTIANITY, Orthodox - Syrian Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'CHRISTIANITY, Orthodox - Ukrainian ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'CHRISTIANITY, Orthodox - Oriental ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'CHRISTIANITY, Assyrian Apostolic', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'CHRISTIANITY, Assyrian Church of the Eas', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'CHRISTIANITY, Ancient Church of the East', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'CHRISTIANITY, Presbyterian', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'CHRISTIANITY, Reformed', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'CHRISTIANITY, Free Reformed', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'CHRISTIANITY, Salvation Army', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'CHRISTIANITY, Seventh-day Adventist', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'CHRISTIANITY, Uniting Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'CHRISTIANITY, Pentecostal', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'CHRISTIANITY, Pent - Apostolic Church (A', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'CHRISTIANITY, Pent - Assemblies of God', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'CHRISTIANITY, Pent - Bethesda Churches', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'CHRISTIANITY, Pent - Christian City Chur', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'CHRISTIANITY, Pent - Christian Life Chur', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'CHRISTIANITY, Pent - Christian Outreach ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'CHRISTIANITY, Pent - Christian Revival C', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'CHRISTIANITY, Pent - Faith Churches', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 'CHRISTIANITY, Pent - Foursquare Gospel C', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'CHRISTIANITY, Pent - Full Gospel Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 'CHRISTIANITY, Pent - Revival Centres', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 'CHRISTIANITY, Pent - Rhema Family Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'CHRISTIANITY, Pent - United Pentecostal', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 'CHRISTIANITY,  Protestant', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 'CHRISTIANITY,  Aboriginal Evangelical Mi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'CHRISTIANITY,  Born Again Christian ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 'CHRISTIANITY,  Christian and Missionary ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'CHRISTIANITY,  Church of the Nazarene ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 'CHRISTIANITY,  Congregational', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 'CHRISTIANITY,  Ethnic Evangelical Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 'CHRISTIANITY,  Independent Evangelical C', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 'CHRISTIANITY,  Wesleyan Methodist Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 'CHRISTIANITY, Apostolic Church of Queens', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, 'CHRISTIANITY, Christadelphians', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, 'CHRISTIANITY, Christian Science', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, 'CHRISTIANITY, Gnostic Christians', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, 'CHRISTIANITY, Liberal Catholic Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, 'CHRISTIANITY, New Apostolic Church', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, 'CHRISTIANITY, New Churches (Swedenborgia', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, 'CHRISTIANITY, Ratana (Maori)', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, 'CHRISTIANITY, Religious Science', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, 'CHRISTIANITY, Religious Society of Frien', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, 'CHRISTIANITY, Temple Society', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, 'CHRISTIANITY, Unitarian', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, 'CHRISTIANITY, Worldwide Church of God', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, 'HINDUISM', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, 'HINDUISM, Vaishnavas', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, 'HINDUISM, Saivas ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, 'HINDUISM, Saktas ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, 'HINDUISM, Sauras', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, 'HINDUISM, Ganapatyas ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, 'HINDUISM, Kumaras ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(96, 'ISLAM, Sunni', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(97, 'ISLAM', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(98, 'ISLAM, Shi''a', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(99, 'ISLAM, Sufi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(100, 'ISLAM, Ahmaddiya', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(101, 'JUDAISM', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(102, 'JUDAISM, Orthodox', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(103, 'JUDAISM, Orthodox - Hasidim', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(104, 'JUDAISM, Orthodox - Haredim', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(105, 'JUDAISM, Progressive', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(106, 'JUDAISM, Progressive - Reform Judaism', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(107, 'JUDAISM, Progressive - Liberal Judaism', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `department_delegation`
--

CREATE TABLE IF NOT EXISTS `department_delegation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`),
  KEY `country_id` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;



--
-- Table structure for table `disease`
--

CREATE TABLE IF NOT EXISTS `disease` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `disease`
--

INSERT INTO `disease` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(2, 'Creutzfeldt-Jakob disease', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Hepatitis C', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Human immunodeficiency virus infection (HIV)', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Diphtheria', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Plague ', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Respiratory anthrax', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Smallpox', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Tuberculosis', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Viral haemorrhagic fever', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Lassa', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Marburg', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Ebola', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Congo-Crimean fever', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'test', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'eeeeee', 1, '2012-03-10 15:59:03', '2012-03-10 15:59:03');

-- --------------------------------------------------------

--
-- Table structure for table `facility_booking`
--

CREATE TABLE IF NOT EXISTS `facility_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text,
  `state` varchar(255) DEFAULT NULL,
  `suburb_town` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `fax_area_code` varchar(255) DEFAULT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `chapel` enum('YES','NO') DEFAULT 'NO',
  `cem_chapel_ids` varchar(255) DEFAULT NULL,
  `chapel_time_from` datetime DEFAULT NULL,
  `chapel_time_to` datetime DEFAULT NULL,
  `chapel_cost` int(11) DEFAULT NULL,
  `room` enum('YES','NO') DEFAULT 'NO',
  `cem_room_ids` varchar(255) DEFAULT NULL,
  `room_time_from` datetime DEFAULT NULL,
  `room_time_to` datetime DEFAULT NULL,
  `no_of_rooms` int(11) DEFAULT NULL,
  `room_cost` int(11) DEFAULT NULL,
  `special_instruction` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `is_finalized` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;



--
-- Table structure for table `fnd_fndirector`
--

CREATE TABLE IF NOT EXISTS `fnd_fndirector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cem_cemetery_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `address` text,
  `state` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `fax_area_code` varchar(255) DEFAULT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



--
-- Table structure for table `fnd_service`
--

CREATE TABLE IF NOT EXISTS `fnd_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `fnd_service`
--

INSERT INTO `fnd_service` (`id`, `name`, `is_enabled`) VALUES
(1, 'Funeral Director Service 1', 1),
(2, 'Funeral Director Service 2', 1),
(3, 'nfnd service 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fnd_service_fndirector`
--

CREATE TABLE IF NOT EXISTS `fnd_service_fndirector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fnd_fndirector_id` bigint(20) NOT NULL,
  `fnd_service_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `funeral_director_id` (`fnd_fndirector_id`),
  KEY `service_id` (`fnd_service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;


--
-- Table structure for table `grantee`
--

CREATE TABLE IF NOT EXISTS `grantee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grantee_details_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `ar_section_id` int(11) DEFAULT NULL,
  `ar_row_id` int(11) DEFAULT NULL,
  `ar_plot_id` int(11) DEFAULT NULL,
  `ar_grave_id` int(11) NOT NULL,
  `ar_grave_status_id` int(11) DEFAULT NULL,
  `fnd_fndirector_id` int(11) DEFAULT NULL,
  `grantee_identity_id` int(11) DEFAULT NULL,
  `grantee_identity_number` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `control_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_purchase` date DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `tenure_expiry_date` date DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cemetery_id` (`cem_cemetery_id`),
  KEY `area_id` (`ar_area_id`),
  KEY `section_id` (`ar_section_id`),
  KEY `row_id` (`ar_row_id`),
  KEY `plot_id` (`ar_plot_id`),
  KEY `grave_id` (`ar_grave_id`),
  KEY `grave_status_id` (`ar_grave_status_id`),
  KEY `funeral_director_id` (`fnd_fndirector_id`),
  KEY `grantee_identity_id` (`grantee_identity_id`),
  KEY `grantee_details_id` (`grantee_details_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=146 ;



--
-- Triggers `grantee`
--
DROP TRIGGER IF EXISTS `trig_allocate_grave_logs`;
DELIMITER //
CREATE TRIGGER `trig_allocate_grave_logs` AFTER INSERT ON `grantee`
 FOR EACH ROW BEGIN
  DECLARE GRANTEE_NAME VARCHAR(255);
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  
  SELECT CONCAT(gtd.grantee_first_name,' ',gtd.grantee_surname) as grantee_name,
         c.name AS country_name, cem.name AS cemetery_name,
         arr.area_code AS area_code, sec.section_code AS section_code, rw.row_name AS row_name,
		 pt.plot_name AS plot_name, gr.grave_number AS grave_number
  INTO GRANTEE_NAME, CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER
  FROM grantee gt
  LEFT JOIN grantee_details gtd ON gt.grantee_details_id = gtd.id 
  LEFT JOIN country c ON gt.country_id = c.id 
  LEFT JOIN cem_cemetery cem ON gt.cem_cemetery_id = cem.id
  LEFT JOIN ar_area arr ON gt.ar_area_id = arr.id
  LEFT JOIN ar_section sec ON gt.ar_section_id = sec.id
  LEFT JOIN ar_row rw ON gt.ar_row_id = rw.id
  LEFT JOIN ar_plot pt ON gt.ar_plot_id = pt.id
  LEFT JOIN ar_grave gr ON gt.ar_grave_id = gr.id
  WHERE gt.id = NEW.id;

  INSERT INTO grantee_logs (old_grantee, user_id, cem_id, country_name, cem_name, area_name, section_name, row_name, plot_name, grave_number, operation, operation_date) 
  	VALUES (GRANTEE_NAME, NEW.user_id, NEW.cem_cemetery_id, CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, 'ALLOCATE_GRAVE', NEW.created_at);

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_transfer_grave_logs`;
DELIMITER //
CREATE TRIGGER `trig_transfer_grave_logs` AFTER UPDATE ON `grantee`
 FOR EACH ROW BEGIN
  DECLARE OLD_GRANTEE_NAME VARCHAR(255);
  DECLARE NEW_GRANTEE_NAME VARCHAR(255);
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  
  IF OLD.grantee_details_id != NEW.grantee_details_id THEN
  
	SELECT CONCAT(gtd.grantee_first_name,' ',gtd.grantee_surname) as old_grantee
	INTO OLD_GRANTEE_NAME
	FROM grantee_details gtd  
	WHERE gtd.id = OLD.grantee_details_id;

	SELECT CONCAT(gtd.grantee_first_name,' ',gtd.grantee_surname) as new_grantee
	INTO NEW_GRANTEE_NAME
	FROM grantee_details gtd
	WHERE gtd.id = NEW.grantee_details_id;

	SELECT c.name AS country_name, cem.name AS cemetery_name,
		 arr.area_code AS area_code, sec.section_code AS section_code, rw.row_name AS row_name,
		 pt.plot_name AS plot_name, gr.grave_number AS grave_number
	INTO CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER
	FROM grantee gt
	LEFT JOIN country c ON gt.country_id = c.id 
	LEFT JOIN cem_cemetery cem ON gt.cem_cemetery_id = cem.id
	LEFT JOIN ar_area arr ON gt.ar_area_id = arr.id
	LEFT JOIN ar_section sec ON gt.ar_section_id = sec.id
	LEFT JOIN ar_row rw ON gt.ar_row_id = rw.id
	LEFT JOIN ar_plot pt ON gt.ar_plot_id = pt.id
	LEFT JOIN ar_grave gr ON gt.ar_grave_id = gr.id
	WHERE gt.id = NEW.id;

	INSERT INTO grantee_logs(old_grantee, new_grantee, user_id, cem_id, country_name, cem_name, area_name, section_name, row_name, plot_name, grave_number, operation, operation_date) 
	VALUES (OLD_GRANTEE_NAME, NEW_GRANTEE_NAME, NEW.user_id, NEW.cem_cemetery_id, CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, 'TRANSFER_GRAVE', NEW.updated_at);

  END IF;

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_del_grantee_logs`;
DELIMITER //
CREATE TRIGGER `trig_del_grantee_logs` BEFORE DELETE ON `grantee`
 FOR EACH ROW BEGIN
  DECLARE GRANTEE_NAME VARCHAR(255);
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  
  SELECT CONCAT(gtd.grantee_first_name,' ',gtd.grantee_surname) as grantee_name,
         c.name AS country_name, cem.name AS cemetery_name,
         arr.area_code AS area_code, sec.section_code AS section_code, rw.row_name AS row_name,
		 pt.plot_name AS plot_name, gr.grave_number AS grave_number
  INTO GRANTEE_NAME, CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER
  FROM grantee gt
  LEFT JOIN grantee_details gtd ON gt.grantee_details_id = gtd.id 
  LEFT JOIN country c ON gt.country_id = c.id 
  LEFT JOIN cem_cemetery cem ON gt.cem_cemetery_id = cem.id
  LEFT JOIN ar_area arr ON gt.ar_area_id = arr.id
  LEFT JOIN ar_section sec ON gt.ar_section_id = sec.id
  LEFT JOIN ar_row rw ON gt.ar_row_id = rw.id
  LEFT JOIN ar_plot pt ON gt.ar_plot_id = pt.id
  LEFT JOIN ar_grave gr ON gt.ar_grave_id = gr.id
  WHERE gt.id = OLD.id;

  INSERT INTO grantee_logs (old_grantee, user_id, cem_id, country_name, cem_name, area_name, section_name, row_name, plot_name, grave_number, operation, operation_date) 
  	VALUES (GRANTEE_NAME, OLD.user_id, OLD.cem_cemetery_id, CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, 'DELETE_GRAVE', NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `grantee_details`
--

CREATE TABLE IF NOT EXISTS `grantee_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cem_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `grantee_first_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `grantee_middle_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `grantee_surname` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `grantee_address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `grantee_email` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `contact_mobile` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `fax_area_code` varchar(255) DEFAULT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `grantee_dob` date DEFAULT NULL,
  `grantee_id_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `grantee_unique_id` varchar(255) DEFAULT NULL,
  `remarks_1` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks_2` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cem_id` (`cem_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=145599 ;


--
-- Table structure for table `grantee_grave_history`
--

CREATE TABLE IF NOT EXISTS `grantee_grave_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grantee_details_id` int(11) NOT NULL,
  `grantee_details_surrender_id` int(11) NOT NULL,
  `ar_grave_id` int(11) NOT NULL,
  `surrender_date` date NOT NULL,
  `transfer_cost` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `grantee_details_id` (`grantee_details_id`,`grantee_details_surrender_id`,`ar_grave_id`),
  KEY `grantee_details_surrender_id` (`grantee_details_surrender_id`),
  KEY `ar_grave_id` (`ar_grave_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;



--
-- Table structure for table `grantee_identity`
--

CREATE TABLE IF NOT EXISTS `grantee_identity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `grantee_identity`
--

INSERT INTO `grantee_identity` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'Medicare Card', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Bank Account', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Utility Bill', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Driving Licence', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Pension Card', 1, '2012-03-06 17:11:03', '2012-03-06 17:11:03'),
(10, 'Transport Consession Card', 1, '2012-03-06 17:11:19', '2012-03-06 17:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `grantee_logs`
--

CREATE TABLE IF NOT EXISTS `grantee_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `cem_id` int(11) DEFAULT NULL,
  `old_grantee` varchar(255) DEFAULT NULL,
  `new_grantee` varchar(255) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `cem_name` varchar(255) DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `row_name` varchar(255) DEFAULT NULL,
  `plot_name` varchar(255) DEFAULT NULL,
  `grave_number` varchar(255) DEFAULT NULL,
  `operation` varchar(255) DEFAULT NULL,
  `operation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;



--
-- Table structure for table `grave_link`
--

CREATE TABLE IF NOT EXISTS `grave_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `ar_section_id` int(11) DEFAULT NULL,
  `ar_row_id` int(11) DEFAULT NULL,
  `ar_plot_id` int(11) DEFAULT NULL,
  `grave_id` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`),
  KEY `ar_area_id` (`ar_area_id`),
  KEY `ar_section_id` (`ar_section_id`),
  KEY `ar_row_id` (`ar_row_id`),
  KEY `ar_plot_id` (`ar_plot_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;



--
-- Table structure for table `grave_logs`
--

CREATE TABLE IF NOT EXISTS `grave_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `cem_id` int(11) DEFAULT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `cem_name` varchar(255) DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `row_name` varchar(255) DEFAULT NULL,
  `plot_name` varchar(255) DEFAULT NULL,
  `grave_number` varchar(255) DEFAULT NULL,
  `operation` varchar(255) DEFAULT NULL,
  `operation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=607 ;


--
-- Table structure for table `interment_booking`
--

CREATE TABLE IF NOT EXISTS `interment_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `cem_cemetery_id` int(11) DEFAULT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `ar_section_id` int(11) DEFAULT NULL,
  `ar_row_id` int(11) DEFAULT NULL,
  `ar_plot_id` int(11) DEFAULT NULL,
  `ar_grave_id` int(11) DEFAULT NULL,
  `ar_grave_status` int(11) DEFAULT NULL,
  `denomination_id` int(11) DEFAULT NULL,
  `fnd_fndirector_id` int(11) DEFAULT NULL,
  `service_type_id` int(11) DEFAULT NULL,
  `cem_stonemason_id` int(11) DEFAULT NULL,
  `deceased_title` varchar(50) DEFAULT NULL,
  `deceased_surname` varchar(255) NOT NULL,
  `deceased_first_name` varchar(255) NOT NULL,
  `deceased_middle_name` varchar(255) NOT NULL,
  `deceased_other_surname` varchar(255) DEFAULT NULL,
  `deceased_other_first_name` varchar(255) DEFAULT NULL,
  `deceased_other_middle_name` varchar(255) DEFAULT NULL,
  `deceased_gender` enum('Male','Female','Trans-Gender') NOT NULL DEFAULT 'Male',
  `date_notified` date DEFAULT NULL,
  `consultant` varchar(255) DEFAULT NULL,
  `service_date` date DEFAULT NULL,
  `date1_day` varchar(255) DEFAULT NULL,
  `service_booking_time_from` time DEFAULT NULL,
  `service_booking_time_to` time DEFAULT NULL,
  `service_date2` date DEFAULT NULL,
  `date2_day` varchar(255) DEFAULT NULL,
  `service_booking2_time_from` time DEFAULT NULL,
  `service_booking2_time_to` time DEFAULT NULL,
  `service_date3` date DEFAULT NULL,
  `date3_day` varchar(255) DEFAULT NULL,
  `service_booking3_time_from` time DEFAULT NULL,
  `service_booking3_time_to` time DEFAULT NULL,
  `monument` varchar(255) DEFAULT NULL,
  `monuments_grave_position` varchar(255) DEFAULT NULL,
  `monuments_unit_type` int(11) DEFAULT NULL,
  `monuments_depth` int(11) DEFAULT NULL,
  `monuments_width` int(11) DEFAULT NULL,
  `monuments_length` int(11) DEFAULT NULL,
  `grantee_first_name` varchar(255) DEFAULT NULL,
  `grantee_surname` varchar(255) DEFAULT NULL,
  `grantee_id` int(11) NOT NULL DEFAULT '0',
  `grantee_relationship` varchar(255) DEFAULT NULL,
  `grave_size` varchar(50) DEFAULT NULL,
  `grave_length` varchar(50) DEFAULT NULL,
  `grave_width` varchar(50) DEFAULT NULL,
  `grave_depth` varchar(50) DEFAULT NULL,
  `grave_unit_type` int(11) DEFAULT NULL,
  `is_finalized` tinyint(1) NOT NULL DEFAULT '0',
  `is_private` tinyint(1) NOT NULL DEFAULT '0',
  `interment_date` date DEFAULT NULL,
  `taken_by` int(11) DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT '0',
  `comment1` text,
  `comment2` text,
  `user_id` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cemetery_id` (`cem_cemetery_id`),
  KEY `area_id` (`ar_area_id`),
  KEY `section_id` (`ar_section_id`),
  KEY `row_id` (`ar_row_id`),
  KEY `plot_id` (`ar_plot_id`),
  KEY `grave_id` (`ar_grave_id`),
  KEY `service_type_id` (`service_type_id`),
  KEY `stone_mason_id` (`cem_stonemason_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=98 ;


-- Triggers `interment_booking`
--
DROP TRIGGER IF EXISTS `trig_ins_booking1_logs`;
DELIMITER //
CREATE TRIGGER `trig_ins_booking1_logs` AFTER INSERT ON `interment_booking`
 FOR EACH ROW BEGIN  
  DECLARE SERVICE_TYPE VARCHAR(255);
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  DECLARE GRANTEE_NAME VARCHAR(255);
  
  SELECT st.name as service_type,c.name AS country_name, cem.name AS cemetery_name, arr.area_code AS area_code, sec.section_code AS section_code, 
		 rw.row_name AS row_name, pt.plot_name AS plot_name, gr.grave_number AS grave_number,
		 CONCAT(gtd.grantee_first_name,' ',gtd.grantee_surname) as grantee_name
  INTO SERVICE_TYPE, CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, GRANTEE_NAME
  FROM interment_booking ib
  LEFT JOIN service_type st ON ib.service_type_id = st.id
  LEFT JOIN grantee_details gtd ON ib.grantee_id = gtd.id
  LEFT JOIN country c ON ib.country_id = c.id 
  LEFT JOIN cem_cemetery cem ON ib.cem_cemetery_id = cem.id
  LEFT JOIN ar_area arr ON ib.ar_area_id = arr.id
  LEFT JOIN ar_section sec ON ib.ar_section_id = sec.id
  LEFT JOIN ar_row rw ON ib.ar_row_id = rw.id
  LEFT JOIN ar_plot pt ON ib.ar_plot_id = pt.id
  LEFT JOIN ar_grave gr ON ib.ar_grave_id = gr.id
  WHERE ib.id = NEW.id;

  INSERT INTO interment_booking_logs (user_id,cem_id,country,cem_name,area,section,row,plot,grave,grantee,operation,operation_date,deceased_surname,deceased_name,status,service_type) 
		 VALUES (NEW.user_id,NEW.cem_cemetery_id,CNAME,CEM_NAME,AR_CODE,SEC_CODE,RW_NAME,PT_NAME,G_NUMBER,GRANTEE_NAME,'ADD',NEW.created_at,NEW.deceased_surname,NEW.deceased_first_name,NEW.is_finalized,SERVICE_TYPE);

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_upd_booking1_logs`;
DELIMITER //
CREATE TRIGGER `trig_upd_booking1_logs` AFTER UPDATE ON `interment_booking`
 FOR EACH ROW BEGIN  
  DECLARE SERVICE_TYPE VARCHAR(255);
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  DECLARE GRANTEE_NAME VARCHAR(255);
  
  SELECT st.name as service_type,c.name AS country_name, cem.name AS cemetery_name, arr.area_code AS area_code, sec.section_code AS section_code, 
		 rw.row_name AS row_name, pt.plot_name AS plot_name, gr.grave_number AS grave_number,
		 CONCAT(gtd.grantee_first_name,' ',gtd.grantee_surname) as grantee_name
  INTO SERVICE_TYPE, CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, GRANTEE_NAME
  FROM interment_booking ib
  LEFT JOIN service_type st ON ib.service_type_id = st.id
  LEFT JOIN grantee_details gtd ON ib.grantee_id = gtd.id
  LEFT JOIN country c ON ib.country_id = c.id 
  LEFT JOIN cem_cemetery cem ON ib.cem_cemetery_id = cem.id
  LEFT JOIN ar_area arr ON ib.ar_area_id = arr.id
  LEFT JOIN ar_section sec ON ib.ar_section_id = sec.id
  LEFT JOIN ar_row rw ON ib.ar_row_id = rw.id
  LEFT JOIN ar_plot pt ON ib.ar_plot_id = pt.id
  LEFT JOIN ar_grave gr ON ib.ar_grave_id = gr.id
  WHERE ib.id = NEW.id;

  INSERT INTO interment_booking_logs (user_id,cem_id,country,cem_name,area,section,row,plot,grave,grantee,operation,operation_date,deceased_surname,deceased_name,status,service_type) 
		 VALUES (NEW.user_id,NEW.cem_cemetery_id,CNAME,CEM_NAME,AR_CODE,SEC_CODE,RW_NAME,PT_NAME,G_NUMBER,GRANTEE_NAME,'EDIT',NEW.updated_at,NEW.deceased_surname,NEW.deceased_first_name,NEW.is_finalized,SERVICE_TYPE);

END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_del_booking1_logs`;
DELIMITER //
CREATE TRIGGER `trig_del_booking1_logs` BEFORE DELETE ON `interment_booking`
 FOR EACH ROW BEGIN  
  DECLARE SERVICE_TYPE VARCHAR(255);
  DECLARE CNAME VARCHAR(255);
  DECLARE CEM_NAME VARCHAR(255);
  DECLARE AR_CODE VARCHAR(255);
  DECLARE SEC_CODE VARCHAR(255);
  DECLARE RW_NAME VARCHAR(255);
  DECLARE PT_NAME VARCHAR(255);
  DECLARE G_NUMBER VARCHAR(255);
  DECLARE GRANTEE_NAME VARCHAR(255);
  
  SELECT st.name as service_type,c.name AS country_name, cem.name AS cemetery_name, arr.area_code AS area_code, sec.section_code AS section_code, 
		 rw.row_name AS row_name, pt.plot_name AS plot_name, gr.grave_number AS grave_number,
		 CONCAT(gtd.grantee_first_name,' ',gtd.grantee_surname) as grantee_name
  INTO SERVICE_TYPE, CNAME, CEM_NAME, AR_CODE, SEC_CODE, RW_NAME, PT_NAME, G_NUMBER, GRANTEE_NAME
  FROM interment_booking ib
  LEFT JOIN service_type st ON ib.service_type_id = st.id
  LEFT JOIN grantee_details gtd ON ib.grantee_id = gtd.id
  LEFT JOIN country c ON ib.country_id = c.id 
  LEFT JOIN cem_cemetery cem ON ib.cem_cemetery_id = cem.id
  LEFT JOIN ar_area arr ON ib.ar_area_id = arr.id
  LEFT JOIN ar_section sec ON ib.ar_section_id = sec.id
  LEFT JOIN ar_row rw ON ib.ar_row_id = rw.id
  LEFT JOIN ar_plot pt ON ib.ar_plot_id = pt.id
  LEFT JOIN ar_grave gr ON ib.ar_grave_id = gr.id
  WHERE ib.id = OLD.id;

  INSERT INTO interment_booking_logs (user_id,cem_id,country,cem_name,area,section,row,plot,grave,grantee,operation,operation_date,deceased_surname,deceased_name,status,service_type) 
		 VALUES (OLD.user_id,OLD.cem_cemetery_id,CNAME,CEM_NAME,AR_CODE,SEC_CODE,RW_NAME,PT_NAME,G_NUMBER,GRANTEE_NAME,'DELETE',NOW(),OLD.deceased_surname,OLD.deceased_first_name,OLD.is_finalized,SERVICE_TYPE);

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `interment_booking_docs`
--

CREATE TABLE IF NOT EXISTS `interment_booking_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interment_booking_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_description` text,
  `expiry_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interment_booking_id` (`interment_booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `interment_booking_five`
--

CREATE TABLE IF NOT EXISTS `interment_booking_five` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interment_booking_id` int(11) NOT NULL,
  `mail_content_id` int(11) NOT NULL,
  `status` enum('No','Yes') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interment_booking_id` (`interment_booking_id`),
  KEY `mail_content_id` (`mail_content_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;



-- --------------------------------------------------------

--
-- Table structure for table `interment_booking_four`
--

CREATE TABLE IF NOT EXISTS `interment_booking_four` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interment_booking_id` int(11) NOT NULL,
  `lodged_by_id` int(11) DEFAULT NULL,
  `lodged_by_name` varchar(255) DEFAULT NULL,
  `deceased_place_of_death` varchar(255) DEFAULT NULL,
  `deceased_country_id_of_death` int(11) DEFAULT NULL,
  `deceased_country_id_of_birth` int(11) DEFAULT NULL,
  `deceased_place_of_birth` varchar(255) DEFAULT NULL,
  `deceased_date_of_birth` date DEFAULT NULL,
  `deceased_date_of_death` date DEFAULT NULL,
  `deceased_age` int(11) DEFAULT NULL,
  `period` varchar(255) DEFAULT NULL,
  `finageuom` enum('Year','Month','Weeks','Days','Hours','Adult','Child','Unborn') DEFAULT NULL,
  `deceased_usual_address` varchar(255) DEFAULT NULL,
  `deceased_suburb_town` varchar(255) DEFAULT NULL,
  `deceased_state` varchar(255) DEFAULT NULL,
  `deceased_postal_code` varchar(255) DEFAULT NULL,
  `deceased_country_id` int(11) DEFAULT NULL,
  `deceased_marital_status` varchar(255) DEFAULT NULL,
  `deceased_partner_name` varchar(30) DEFAULT NULL,
  `deceased_partner_surname` varchar(255) DEFAULT NULL,
  `deceased_father_name` varchar(255) DEFAULT NULL,
  `deceased_father_surname` varchar(255) DEFAULT NULL,
  `deceased_mother_name` varchar(255) DEFAULT NULL,
  `deceased_mother_maiden_surname` varchar(255) DEFAULT NULL,
  `deceased_children1` varchar(255) DEFAULT NULL,
  `deceased_children2` varchar(255) DEFAULT NULL,
  `deceased_children3` varchar(255) DEFAULT NULL,
  `deceased_children4` varchar(255) DEFAULT NULL,
  `deceased_children5` varchar(255) DEFAULT NULL,
  `deceased_children6` varchar(255) DEFAULT NULL,
  `deceased_children7` varchar(255) DEFAULT NULL,
  `deceased_children8` varchar(255) DEFAULT NULL,
  `deceased_children9` varchar(255) DEFAULT NULL,
  `deceased_children10` varchar(255) DEFAULT NULL,
  `deceased_children11` varchar(255) DEFAULT NULL,
  `deceased_children12` varchar(255) DEFAULT NULL,
  `relationship_to_deceased` varchar(255) DEFAULT NULL,
  `informant_surname` varchar(255) DEFAULT NULL,
  `informant_first_name` varchar(255) DEFAULT NULL,
  `informant_middle_name` varchar(255) DEFAULT NULL,
  `informant_fax_area_code` varchar(255) DEFAULT NULL,
  `informant_fax` varchar(255) DEFAULT NULL,
  `informant_email` varchar(255) DEFAULT NULL,
  `informant_telephone_area_code` varchar(255) DEFAULT NULL,
  `informant_telephone` varchar(255) DEFAULT NULL,
  `informant_mobile` varchar(255) DEFAULT NULL,
  `informant_address` varchar(255) DEFAULT NULL,
  `informant_suburb_town` varchar(255) DEFAULT NULL,
  `informant_state` varchar(255) DEFAULT NULL,
  `informant_postal_code` varchar(255) DEFAULT NULL,
  `informant_country_id` int(11) DEFAULT NULL,
  `control_number` varchar(255) DEFAULT NULL,
  `cul_calender_type` varchar(255) DEFAULT NULL,
  `cul_date_of_death` varchar(255) DEFAULT NULL,
  `cul_time_of_death` varchar(255) DEFAULT NULL,
  `cul_date_of_birth` varchar(255) DEFAULT NULL,
  `cul_date_of_interment` varchar(255) DEFAULT NULL,
  `cul_status` varchar(255) DEFAULT NULL,
  `cul_died_after_dust` tinyint(4) NOT NULL DEFAULT '0',
  `cul_remains_position` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lodged_by_id` (`lodged_by_id`),
  KEY `deceased_country_id_of_death` (`deceased_country_id_of_death`),
  KEY `deceased_country_id_of_birth` (`deceased_country_id_of_birth`),
  KEY `deceased_country_id` (`deceased_country_id`),
  KEY `informant_country_id` (`informant_country_id`),
  KEY `interment_booking_id` (`interment_booking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=269278 ;



--
-- Table structure for table `interment_booking_logs`
--

CREATE TABLE IF NOT EXISTS `interment_booking_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `cem_id` int(11) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `cem_name` varchar(255) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `row` varchar(255) DEFAULT NULL,
  `plot` varchar(255) DEFAULT NULL,
  `grave` varchar(255) DEFAULT NULL,
  `grantee` varchar(255) DEFAULT NULL,
  `operation` varchar(255) DEFAULT NULL,
  `operation_date` datetime DEFAULT NULL,
  `deceased_surname` varchar(255) DEFAULT NULL,
  `deceased_name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=516 ;



--
-- Table structure for table `interment_booking_three`
--

CREATE TABLE IF NOT EXISTS `interment_booking_three` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interment_booking_id` int(11) NOT NULL,
  `file_location` varchar(255) DEFAULT NULL,
  `cemetery_application` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `burial_booking_form` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `ashes_booking_form` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `exhumation_booking_from` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `remains_booking_from` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `health_order` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `court_order` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `checked_fnd_details` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `checked_owner_grave` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `living_grave_owner` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `deceased_grave_owner` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `cecked_chapel_booking` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `advised_fd_to_check` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `advised_fd_recommended` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `advised_fd_coffin_height` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `medical_death_certificate` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `medical_certificate_spelling` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `medical_certificate_infectious` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `request_probe_reopen` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `request_triple_depth_reopen` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `checked_monumental` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `contacted_stonemason` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `checked_accessories` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `balloons_na` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `burning_drum` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `canopy` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `ceremonial_sand_bucket` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `fireworks` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `lowering_device` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `checked_returned_signed` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `check_coffin_sizes_surcharge` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `surcharge_applied` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `compare_burial_booking` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `for_between_burials` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `double_check_yellow_date` enum('Completed','Pending','NA') NOT NULL DEFAULT 'NA',
  `other` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interment_booking_id` (`interment_booking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;



--
-- Table structure for table `interment_booking_two`
--

CREATE TABLE IF NOT EXISTS `interment_booking_two` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interment_booking_id` int(11) NOT NULL,
  `disease_id` int(11) DEFAULT NULL,
  `unit_type_id` int(11) DEFAULT NULL,
  `coffin_type_id` int(11) DEFAULT NULL,
  `death_certificate` tinyint(1) DEFAULT '1',
  `own_clergy` tinyint(1) DEFAULT '1',
  `clergy_name` varchar(255) DEFAULT NULL,
  `coffin_surcharge` tinyint(1) DEFAULT '1',
  `burning_drum` varchar(255) DEFAULT NULL,
  `fireworks` varchar(255) DEFAULT NULL,
  `lowering_device` varchar(255) DEFAULT NULL,
  `balloons` varchar(255) DEFAULT NULL,
  `chapel_multimedia` varchar(255) DEFAULT NULL,
  `facility` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `facility_from` datetime DEFAULT NULL,
  `facility_to` datetime DEFAULT NULL,
  `coffin_length` int(11) DEFAULT NULL,
  `coffin_width` int(11) DEFAULT NULL,
  `coffin_height` int(11) DEFAULT NULL,
  `chapel` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `cem_chapel_ids` varchar(255) DEFAULT NULL,
  `chapel_time_from` datetime DEFAULT NULL,
  `chapel_time_to` datetime DEFAULT NULL,
  `room` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `cem_room_ids` varchar(255) DEFAULT NULL,
  `room_time_from` datetime DEFAULT NULL,
  `room_time_to` datetime DEFAULT NULL,
  `special_instruction` varchar(255) DEFAULT NULL,
  `ceremonial_sand` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `canopy` varchar(255) DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `notes` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `disease_id` (`disease_id`),
  KEY `unit_type_id` (`unit_type_id`),
  KEY `coffin_type_id` (`coffin_type_id`),
  KEY `interment_booking_id` (`interment_booking_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;



--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language_name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `culture` varchar(50) CHARACTER SET latin1 NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `language_name` (`language_name`),
  UNIQUE KEY `culture_2` (`culture`),
  KEY `culture` (`culture`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `language_name`, `culture`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'France', 'fr', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Finish', 'fi', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'Hindi', 'hn', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `letter_confirmation`
--

CREATE TABLE IF NOT EXISTS `letter_confirmation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interment_booking_five_id` int(11) NOT NULL,
  `mail_content_type` varchar(255) DEFAULT NULL,
  `confirmed` tinyint(4) NOT NULL DEFAULT '0',
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `interment_booking_five_id` (`interment_booking_five_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;



--
-- Table structure for table `lodged_by`
--

CREATE TABLE IF NOT EXISTS `lodged_by` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `lodged_by`
--

INSERT INTO `lodged_by` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(2, 'Father', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Brother', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Mother', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Friend', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Family Member', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `mail_content`
--

CREATE TABLE IF NOT EXISTS `mail_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) DEFAULT NULL,
  `cem_cemetery_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `content_type` varchar(100) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'letter',
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=195 ;

--
-- Dumping data for table `mail_content`
--



--
-- Table structure for table `service_type`
--

CREATE TABLE IF NOT EXISTS `service_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `service_type`
--

INSERT INTO `service_type` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'Interment', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Exhumation', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Ashes', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_forgot_password`
--

CREATE TABLE IF NOT EXISTS `sf_guard_forgot_password` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `unique_key` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sf_guard_group`
--

INSERT INTO `sf_guard_group` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Super Admin', '2011-08-17 16:37:28', '2011-08-17 16:37:28'),
(2, 'Cemetery Manager', 'Cemetery Manager (Manager of cemetery)', '2011-08-17 16:38:07', '2011-08-17 16:38:07'),
(3, 'Staff', 'Cemetery Staff', '2011-08-17 16:38:18', '2011-08-17 16:38:18'),
(4, 'Admin Staff', 'Cemetery Staff Admin', '2011-09-07 00:00:00', '2011-09-07 00:00:00'),
(5, 'Funeral Director', 'Funeral Director', '2011-09-15 00:00:00', '2011-09-15 00:00:00'),
(6, 'Stone Mason', 'Stone Mason', '2011-09-27 00:00:00', '2011-09-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_group_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group_permission` (
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `permission_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`group_id`,`permission_id`),
  KEY `sf_guard_group_permission_permission_id_sf_guard_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sf_guard_group_permission`
--

INSERT INTO `sf_guard_group_permission` (`group_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2011-08-17 16:37:28', '2011-08-17 16:37:28'),
(2, 2, '2011-08-17 16:38:07', '2011-08-17 16:38:07'),
(3, 3, '2011-08-17 16:38:18', '2011-08-17 16:38:18'),
(4, 4, '2011-09-07 00:00:00', '2011-09-07 00:00:00'),
(5, 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 6, '2011-09-27 00:00:00', '2011-09-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_permission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `sf_guard_permission`
--

INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Administrator', '0000-00-00 00:00:00', '2011-08-11 17:23:42'),
(2, 'Cemetery Manager', 'Cemetery Manager (Manager of cemetery)', '2011-08-09 18:43:33', '2011-08-11 17:24:05'),
(3, 'Cemetery Staff', 'Cemetery Staff (Member of cemetery)', '2011-08-11 17:24:28', '2011-08-11 18:08:03'),
(4, 'Cemetery Staff Admin', 'Cemetery Staff Admin', '2011-09-07 00:00:00', '2011-09-07 00:00:00'),
(5, 'Funeral Director', 'Funeral Director', '2011-09-15 00:00:00', '2011-09-15 00:00:00'),
(6, 'Stone Mason', 'Stone Mason', '2011-09-27 00:00:00', '2011-09-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_remember_key`
--

CREATE TABLE IF NOT EXISTS `sf_guard_remember_key` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `remember_key` varchar(32) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_user`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `username` varchar(128) NOT NULL,
  `algorithm` varchar(128) NOT NULL DEFAULT 'sha1',
  `salt` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '0',
  `is_super_admin` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email_address` (`email_address`),
  KEY `is_active_idx_idx` (`is_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `sf_guard_user`
--

INSERT INTO `sf_guard_user` (`id`, `first_name`, `last_name`, `email_address`, `username`, `algorithm`, `salt`, `password`, `is_active`, `is_super_admin`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'bruntech@gmail.com', 'administrator', 'sha1', 'cc6e703b67e3a8c9d91023e26e569ce4', '3dc1826295e43193c6ab082672484993c6204a3f', 1, 1, '2012-03-29 16:37:06', '2011-08-03 17:57:39', '2012-03-29 16:37:06');

--
-- Table structure for table `sf_guard_user_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_group` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `sf_guard_user_group_group_id_sf_guard_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `sf_guard_user_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_permission` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `permission_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `sf_guard_user_permission_permission_id_sf_guard_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unit_type`
--

CREATE TABLE IF NOT EXISTS `unit_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `unit_type`
--

INSERT INTO `unit_type` (`id`, `name`, `is_enabled`, `created_at`, `updated_at`) VALUES
(1, 'Millimetres', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Centimetres', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Metres', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Inches', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Feet', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Yard', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_cemetery`
--

CREATE TABLE IF NOT EXISTS `user_cemetery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `group_id` bigint(20) NOT NULL,
  `cem_cemetery_id` int(11) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `organisation` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `address` text,
  `state` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `suburb` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `fax_area_code` varchar(255) DEFAULT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `group_id` (`group_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=264 ;



--
-- Table structure for table `workflow`
--

CREATE TABLE IF NOT EXISTS `workflow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `cem_cemetery_id` int(11) NOT NULL,
  `ar_area_id` int(11) DEFAULT NULL,
  `ar_section_id` int(11) DEFAULT NULL,
  `ar_row_id` int(11) DEFAULT NULL,
  `ar_plot_id` int(11) DEFAULT NULL,
  `ar_grave_id` int(11) DEFAULT NULL,
  `work_date` date DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `department_delegation` int(11) DEFAULT NULL,
  `work_description` text,
  `completed_by` bigint(20) DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `action_taken` text,
  `feed_charges` varchar(255) DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  KEY `cem_cemetery_id` (`cem_cemetery_id`),
  KEY `ar_area_id` (`ar_area_id`),
  KEY `ar_section_id` (`ar_section_id`),
  KEY `ar_row_id` (`ar_row_id`),
  KEY `ar_plot_id` (`ar_plot_id`),
  KEY `ar_grave_id` (`ar_grave_id`),
  KEY `completed_by` (`completed_by`),
  KEY `department_delegation` (`department_delegation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--

--
-- Constraints for table `ar_area`
--
ALTER TABLE `ar_area`
  ADD CONSTRAINT `ar_area_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_area_ibfk_2` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ar_grave`
--
ALTER TABLE `ar_grave`
  ADD CONSTRAINT `ar_grave_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ar_grave_ibfk_11` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_ibfk_12` FOREIGN KEY (`ar_section_id`) REFERENCES `ar_section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_ibfk_13` FOREIGN KEY (`ar_row_id`) REFERENCES `ar_row` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_ibfk_14` FOREIGN KEY (`ar_plot_id`) REFERENCES `ar_plot` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_ibfk_15` FOREIGN KEY (`ar_grave_status_id`) REFERENCES `ar_grave_status` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_ibfk_2` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ar_grave_maintenance`
--
ALTER TABLE `ar_grave_maintenance`
  ADD CONSTRAINT `ar_grave_maintenance_ibfk_3` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_maintenance_ibfk_4` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_maintenance_ibfk_5` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_maintenance_ibfk_6` FOREIGN KEY (`ar_section_id`) REFERENCES `ar_section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_maintenance_ibfk_7` FOREIGN KEY (`ar_row_id`) REFERENCES `ar_row` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_maintenance_ibfk_8` FOREIGN KEY (`ar_plot_id`) REFERENCES `ar_plot` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_grave_maintenance_ibfk_9` FOREIGN KEY (`ar_grave_id`) REFERENCES `ar_grave` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ar_plot`
--
ALTER TABLE `ar_plot`
  ADD CONSTRAINT `ar_plot_ibfk_4` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_plot_ibfk_5` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_plot_ibfk_6` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_plot_ibfk_7` FOREIGN KEY (`ar_section_id`) REFERENCES `ar_section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_plot_ibfk_8` FOREIGN KEY (`ar_row_id`) REFERENCES `ar_row` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ar_row`
--
ALTER TABLE `ar_row`
  ADD CONSTRAINT `ar_row_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ar_row_ibfk_3` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ar_row_ibfk_4` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_row_ibfk_5` FOREIGN KEY (`ar_section_id`) REFERENCES `ar_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ar_section`
--
ALTER TABLE `ar_section`
  ADD CONSTRAINT `ar_section_ibfk_3` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_section_ibfk_4` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ar_section_ibfk_5` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cem_cemetery`
--
ALTER TABLE `cem_cemetery`
  ADD CONSTRAINT `cem_cemetery_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cem_cemetery_docs`
--
ALTER TABLE `cem_cemetery_docs`
  ADD CONSTRAINT `cem_cemetery_docs_ibfk_1` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cem_cemetery_fndirector`
--
ALTER TABLE `cem_cemetery_fndirector`
  ADD CONSTRAINT `cem_cemetery_fndirector_ibfk_1` FOREIGN KEY (`fnd_fndirector_id`) REFERENCES `fnd_fndirector` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cem_cemetery_fndirector_ibfk_2` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cem_cemetery_stonemason`
--
ALTER TABLE `cem_cemetery_stonemason`
  ADD CONSTRAINT `cem_cemetery_stonemason_ibfk_3` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cem_cemetery_stonemason_ibfk_4` FOREIGN KEY (`cms_stonemason_id`) REFERENCES `cem_stonemason` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cem_chapel`
--
ALTER TABLE `cem_chapel`
  ADD CONSTRAINT `cem_chapel_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cem_chapel_ibfk_2` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cem_mail_users`
--
ALTER TABLE `cem_mail_users`
  ADD CONSTRAINT `cem_mail_users_ibfk_1` FOREIGN KEY (`cem_mail_id`) REFERENCES `cem_mail` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cem_mail_users_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cem_mail_users_ibfk_3` FOREIGN KEY (`to_user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cem_room`
--
ALTER TABLE `cem_room`
  ADD CONSTRAINT `cem_room_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cem_room_ibfk_2` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cem_stonemason`
--
ALTER TABLE `cem_stonemason`
  ADD CONSTRAINT `cem_stonemason_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cem_stonemason_docs`
--
ALTER TABLE `cem_stonemason_docs`
  ADD CONSTRAINT `cem_stonemason_docs_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cem_stonemason_docs_ibfk_3` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cem_task_notes`
--
ALTER TABLE `cem_task_notes`
  ADD CONSTRAINT `cem_task_notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `department_delegation`
--
ALTER TABLE `department_delegation`
  ADD CONSTRAINT `department_delegation_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_delegation_ibfk_3` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `facility_booking`
--
ALTER TABLE `facility_booking`
  ADD CONSTRAINT `facility_booking_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `facility_booking_ibfk_2` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fnd_fndirector`
--
ALTER TABLE `fnd_fndirector`
  ADD CONSTRAINT `fnd_fndirector_ibfk_1` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fnd_fndirector_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fnd_service_fndirector`
--
ALTER TABLE `fnd_service_fndirector`
  ADD CONSTRAINT `fnd_service_fndirector_ibfk_2` FOREIGN KEY (`fnd_fndirector_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fnd_service_fndirector_ibfk_3` FOREIGN KEY (`fnd_service_id`) REFERENCES `fnd_service` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grantee`
--
ALTER TABLE `grantee`
  ADD CONSTRAINT `grantee_ibfk_121` FOREIGN KEY (`grantee_details_id`) REFERENCES `grantee_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_ibfk_122` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_ibfk_123` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_ibfk_124` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_ibfk_125` FOREIGN KEY (`ar_section_id`) REFERENCES `ar_section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_ibfk_126` FOREIGN KEY (`ar_row_id`) REFERENCES `ar_row` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_ibfk_127` FOREIGN KEY (`ar_plot_id`) REFERENCES `ar_plot` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_ibfk_128` FOREIGN KEY (`ar_grave_id`) REFERENCES `ar_grave` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_ibfk_129` FOREIGN KEY (`grantee_identity_id`) REFERENCES `grantee_identity` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grantee_details`
--
ALTER TABLE `grantee_details`
  ADD CONSTRAINT `grantee_details_ibfk_1` FOREIGN KEY (`cem_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grantee_grave_history`
--
ALTER TABLE `grantee_grave_history`
  ADD CONSTRAINT `grantee_grave_history_ibfk_1` FOREIGN KEY (`grantee_details_id`) REFERENCES `grantee_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_grave_history_ibfk_2` FOREIGN KEY (`grantee_details_surrender_id`) REFERENCES `grantee_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grantee_grave_history_ibfk_3` FOREIGN KEY (`ar_grave_id`) REFERENCES `ar_grave` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `grave_link`
--
ALTER TABLE `grave_link`
  ADD CONSTRAINT `grave_link_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grave_link_ibfk_2` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grave_link_ibfk_3` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grave_link_ibfk_4` FOREIGN KEY (`ar_section_id`) REFERENCES `ar_section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grave_link_ibfk_5` FOREIGN KEY (`ar_row_id`) REFERENCES `ar_row` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `grave_link_ibfk_6` FOREIGN KEY (`ar_plot_id`) REFERENCES `ar_plot` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interment_booking`
--
ALTER TABLE `interment_booking`
  ADD CONSTRAINT `interment_booking_ibfk_15` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interment_booking_ibfk_16` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interment_booking_ibfk_17` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interment_booking_ibfk_18` FOREIGN KEY (`ar_section_id`) REFERENCES `ar_section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interment_booking_ibfk_19` FOREIGN KEY (`ar_row_id`) REFERENCES `ar_row` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interment_booking_ibfk_20` FOREIGN KEY (`ar_plot_id`) REFERENCES `ar_plot` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interment_booking_ibfk_21` FOREIGN KEY (`ar_grave_id`) REFERENCES `ar_grave` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interment_booking_ibfk_22` FOREIGN KEY (`service_type_id`) REFERENCES `service_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interment_booking_docs`
--
ALTER TABLE `interment_booking_docs`
  ADD CONSTRAINT `interment_booking_docs_ibfk_1` FOREIGN KEY (`interment_booking_id`) REFERENCES `interment_booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interment_booking_five`
--
ALTER TABLE `interment_booking_five`
  ADD CONSTRAINT `interment_booking_five_ibfk_1` FOREIGN KEY (`interment_booking_id`) REFERENCES `interment_booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interment_booking_four`
--
ALTER TABLE `interment_booking_four`
  ADD CONSTRAINT `interment_booking_four_ibfk_1` FOREIGN KEY (`interment_booking_id`) REFERENCES `interment_booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interment_booking_three`
--
ALTER TABLE `interment_booking_three`
  ADD CONSTRAINT `interment_booking_three_ibfk_1` FOREIGN KEY (`interment_booking_id`) REFERENCES `interment_booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `interment_booking_two`
--
ALTER TABLE `interment_booking_two`
  ADD CONSTRAINT `interment_booking_two_ibfk_1` FOREIGN KEY (`interment_booking_id`) REFERENCES `interment_booking` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `letter_confirmation`
--
ALTER TABLE `letter_confirmation`
  ADD CONSTRAINT `letter_confirmation_ibfk_1` FOREIGN KEY (`interment_booking_five_id`) REFERENCES `interment_booking_five` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mail_content`
--
ALTER TABLE `mail_content`
  ADD CONSTRAINT `mail_content_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mail_content_ibfk_2` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_forgot_password`
--
ALTER TABLE `sf_guard_forgot_password`
  ADD CONSTRAINT `sf_guard_forgot_password_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_group_permission`
--
ALTER TABLE `sf_guard_group_permission`
  ADD CONSTRAINT `sf_guard_group_permission_group_id_sf_guard_group_id` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_group_permission_permission_id_sf_guard_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_remember_key`
--
ALTER TABLE `sf_guard_remember_key`
  ADD CONSTRAINT `sf_guard_remember_key_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_user_group`
--
ALTER TABLE `sf_guard_user_group`
  ADD CONSTRAINT `sf_guard_user_group_group_id_sf_guard_group_id` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_group_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sf_guard_user_permission`
--
ALTER TABLE `sf_guard_user_permission`
  ADD CONSTRAINT `sf_guard_user_permission_permission_id_sf_guard_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_permission_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_cemetery`
--
ALTER TABLE `user_cemetery`
  ADD CONSTRAINT `user_cemetery_ibfk_22` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_cemetery_ibfk_23` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_cemetery_ibfk_24` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `workflow`
--
ALTER TABLE `workflow`
  ADD CONSTRAINT `workflow_ibfk_17` FOREIGN KEY (`completed_by`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workflow_ibfk_62` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workflow_ibfk_63` FOREIGN KEY (`cem_cemetery_id`) REFERENCES `cem_cemetery` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workflow_ibfk_64` FOREIGN KEY (`ar_area_id`) REFERENCES `ar_area` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workflow_ibfk_65` FOREIGN KEY (`ar_section_id`) REFERENCES `ar_section` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workflow_ibfk_66` FOREIGN KEY (`ar_row_id`) REFERENCES `ar_row` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workflow_ibfk_67` FOREIGN KEY (`ar_plot_id`) REFERENCES `ar_plot` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workflow_ibfk_68` FOREIGN KEY (`ar_grave_id`) REFERENCES `ar_grave` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `workflow_ibfk_69` FOREIGN KEY (`department_delegation`) REFERENCES `department_delegation` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
