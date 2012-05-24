-- 
-- Table structure for table `time_data`
-- 

CREATE TABLE `time_data` (
  `time_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) NOT NULL default '0',
  `data_date` date default NULL,
  `type_id` int(10) NOT NULL default '0',
  `hours` double default NULL,
  `notes` text,
  PRIMARY KEY  (`time_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `time_data`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `time_periods`
-- 

CREATE TABLE `time_periods` (
  `period_id` int(10) NOT NULL auto_increment,
  `start_date` date NOT NULL default '0000-00-00',
  `end_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`period_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `time_periods`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `time_types`
-- 

CREATE TABLE `time_types` (
  `type_id` int(10) NOT NULL auto_increment,
  `description` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`type_id`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

-- 
-- Dumping data for table `time_types`
-- 

INSERT INTO `time_types` VALUES (3, 'vacation');
INSERT INTO `time_types` VALUES (2, 'sick');
INSERT INTO `time_types` VALUES (4, 'regular');
INSERT INTO `time_types` VALUES (5, 'no pay');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_info`
-- 

CREATE TABLE `user_info` (
  `user_id` int(10) NOT NULL auto_increment,
  `fname` varchar(50) default NULL,
  `lname` varchar(50) default NULL,
  `level` varchar(20) NOT NULL default 'User',
  `username` varchar(30) NOT NULL default '',
  `password` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `user_info`
-- 

INSERT INTO `user_info` VALUES (1, 'Admin', 'Admin', 'Administrator', 'admin', 'admin');

-- --------------------------------------------------------

-- 
-- Table structure for table `user_log`
-- 

CREATE TABLE IF NOT EXISTS `user_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `loginip` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `lastlogin` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
