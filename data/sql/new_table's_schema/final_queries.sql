CREATE TABLE IF NOT EXISTS `award` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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


CREATE TABLE IF NOT EXISTS `catalog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `cost_price` float(10,2) NOT NULL,
  `special_cost_price` float(10,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `day_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;




CREATE TABLE IF NOT EXISTS `time_in_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(11) NOT NULL,
  `day_type_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `task_date` date NOT NULL,
  `time_in_time_out` time NOT NULL,
  `time_out` time NOT NULL,
  `total_hrs` time NOT NULL,
  `status` enum('IN','OUT') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `day_type_id` (`day_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `time_in_out`
--
ALTER TABLE `time_in_out`
  ADD CONSTRAINT `time_in_out_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `time_in_out_ibfk_2` FOREIGN KEY (`day_type_id`) REFERENCES `day_type` (`id`) ON DELETE SET NULL;






ALTER TABLE `grantee` ADD `catalog_id` INT NULL DEFAULT NULL AFTER `grantee_identity_id` ,
ADD `payment_id` INT NULL DEFAULT NULL AFTER `catalog_id`;
ALTER TABLE `grantee` ADD INDEX ( `catalog_id` );
ALTER TABLE `grantee` ADD FOREIGN KEY (`catalog_id`) REFERENCES `catalog`(`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `grantee_grave_history` ADD `catalog_id` INT NULL DEFAULT NULL AFTER `ar_grave_id` ,
ADD `payment_id` INT NULL DEFAULT NULL AFTER `catalog_id`;
ALTER TABLE `grantee_grave_history` ADD FOREIGN KEY (`catalog_id`) REFERENCES `catalog`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `interment_booking` ADD `catalog_id` INT NULL DEFAULT NULL AFTER `cem_stonemason_id` ,
ADD `payment_id` INT NULL DEFAULT NULL AFTER `catalog_id`;
ALTER TABLE `interment_booking` ADD INDEX ( `catalog_id` );
ALTER TABLE `interment_booking` ADD FOREIGN KEY (`catalog_id`) REFERENCES `catalog`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

INSERT INTO `day_type` (`id` ,`name`)VALUES ('2', 'Leave'), ('3', 'Holidays');

 ALTER TABLE `user_cemetery` ADD `user_code` VARCHAR( 10 ) NULL AFTER `area_code`;
