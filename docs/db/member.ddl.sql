DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(150) NOT NULL,
  `email` VARCHAR(180) NOT NULL,
  `password` CHAR(72) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_email_uk` (`email`)
) ENGINE=InnoDb CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';