CREATE DATABASE `hlinking` DEFAULT CHARACTER SET utf8;
CREATE USER 'hluser'@localhost IDENTIFIED BY 'hlpassword';
GRANT USAGE ON *.* TO 'hluser'@localhost IDENTIFIED BY 'hlpassword';
GRANT ALL privileges ON `hlinking`.* TO 'hluser'@localhost;
FLUSH PRIVILEGES;

CREATE TABLE `hlinking`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC));

CREATE TABLE `hlinking`.`promotions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `code` varchar(45) NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_UNIQUE` (`code`),
  KEY `fk_promotions_user_idx` (`user_id`),
  CONSTRAINT `fk_promotions_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
