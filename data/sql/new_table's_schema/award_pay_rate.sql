-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2012 at 03:48 PM
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
-- Table structure for table `award_pay_rate`
--

CREATE TABLE IF NOT EXISTS `award_pay_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_award` int(11) NOT NULL,
  `overtime_hrs` time NOT NULL,
  `overtime_pay_rate` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_award` (`id_award`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `award_pay_rate`
--
ALTER TABLE `award_pay_rate`
  ADD CONSTRAINT `award_pay_rate_ibfk_1` FOREIGN KEY (`id_award`) REFERENCES `award` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
