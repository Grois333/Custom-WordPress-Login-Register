CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `password` varchar(100) CHARACTER SET ucs2 NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `house_number` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `apt_number` int(100) NOT NULL,
  `intercom_code` varchar(100) NOT NULL,
  `phone` int(100) NOT NULL,
  `session` int(100) NOT NULL,
   PRIMARY KEY `id`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;