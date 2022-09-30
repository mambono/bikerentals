-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.38-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


CREATE USER 'biker'@'localhost' IDENTIFIED BY 'R3ntal';
GRANT USAGE ON *.* TO 'biker'@'localhost';
GRANT SELECT, DELETE, INSERT, UPDATE  ON `bike\_rental`.* TO 'biker'@'localhost';
FLUSH PRIVILEGES;


-- Dumping database structure for bike_rental
CREATE DATABASE IF NOT EXISTS `bike_rental` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `bike_rental`;

-- Dumping structure for table bike_rental.bikes
DROP TABLE IF EXISTS `bikes`;
CREATE TABLE IF NOT EXISTS `bikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_id` int(11) DEFAULT '0',
  `vendor_id` int(11) DEFAULT '0',
  `short_name` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT '0',
  `color` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT '0',
  `hourly_cost` decimal(20,6) DEFAULT '0.000000',
  `size` tinyint(2) DEFAULT '0',
  `electric` tinyint(1) DEFAULT '0',
  `gear_speed` int(11) DEFAULT '0',
  `created_by` int(11) DEFAULT '0',
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT '0',
  `modified_on` datetime DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK__cities` (`city_id`),
  KEY `FK__users` (`vendor_id`),
  CONSTRAINT `FK__cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  CONSTRAINT `FK_bikes_vendors` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table bike_rental.bikes: ~15 rows (approximately)
/*!40000 ALTER TABLE `bikes` DISABLE KEYS */;
INSERT INTO `bikes` (`id`, `city_id`, `vendor_id`, `short_name`, `color`, `hourly_cost`, `size`, `electric`, `gear_speed`, `created_by`, `created_on`, `modified_by`, `modified_on`, `delete_flag`) VALUES
	(1, 1, 1, 'Zuzu Comerera 1', 'Black', 50.000000, 5, 1, 21, NULL, '2022-09-30 10:08:16', 8, '2022-09-30 09:30:26', 0),
	(2, 4, 3, 'Mikeys Mountain Bike 1', 'Blue', 70.000000, 11, 0, 20, NULL, '2022-09-30 10:42:08', 1, '2022-09-30 09:36:48', 0),
	(3, 5, 1, 'Zuzu Electric Scooter 1', 'Green', 120.000000, 15, 1, 6, NULL, '2022-09-30 10:43:13', 0, NULL, 0),
	(4, 5, 2, 'Prime Manual Scooter 1', 'Brown', 200.000000, 6, 0, 6, 8, '2022-09-30 11:18:15', 0, NULL, 0),
	(5, 1, 1, 'Zuzu Comerera 2', 'Black', 50.000000, 5, 1, 21, NULL, '2022-09-30 11:18:15', 8, NULL, 0),
	(6, 4, 3, 'Mikeys Mountain Bike 2', 'Blue', 65.000000, 12, 0, 18, NULL, '2022-09-30 11:18:15', 1, '2022-09-30 09:30:36', 0),
	(7, 5, 1, 'Zuzu Electric Scooter 2', 'Green', 120.000000, 15, 1, 6, NULL, '2022-09-30 11:18:15', 0, NULL, 0),
	(8, 5, 1, 'Zuzu Manual Scooter 2', 'Blue', 200.000000, 6, 0, 6, 8, '2022-09-30 11:18:15', 0, NULL, 0),
	(9, 1, 2, 'Prime Comerera 3', 'Black', 50.000000, 5, 1, 21, NULL, '2022-09-30 11:18:15', 8, '2022-09-30 11:30:15', 0),
	(10, 4, 1, 'Zuzu Mountain Bike 3', 'Blue', 65.000000, 12, 0, 18, NULL, '2022-09-30 11:18:15', 7, '2022-09-30 10:21:33', 0),
	(11, 5, 2, 'Prime Electric Scooter 3', 'Green', 120.000000, 15, 1, 6, NULL, '2022-09-30 11:18:15', 0, NULL, 0),
	(12, 5, 1, 'Zuzu Manual Scooter 3', 'Blue', 200.000000, 6, 0, 6, 8, '2022-09-30 11:18:15', 0, NULL, 0),
	(14, 4, 2, 'Prime Fast Bike', 'Blue', 30.000000, 13, 0, 0, 4, '2022-09-30 11:18:15', 4, '2022-09-30 11:42:40', 0),
	(15, 1, 4, 'Yamaha Mobike', 'Red', 200.000000, 2, 1, 5, 1, '2022-09-30 09:42:39', 0, NULL, 0),
	(16, 4, 3, 'Mikeys Mountain Bike 3', 'Black', 100.000000, 15, 0, 15, 9, '2022-09-30 09:52:32', 9, '2022-09-30 10:05:30', 0);
/*!40000 ALTER TABLE `bikes` ENABLE KEYS */;

-- Dumping structure for table bike_rental.bike_bookings
DROP TABLE IF EXISTS `bike_bookings`;
CREATE TABLE IF NOT EXISTS `bike_bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booked_by` int(11) DEFAULT NULL,
  `bike_id` int(11) DEFAULT NULL,
  `booked_on` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_bike_bookings_users` (`booked_by`),
  KEY `FK_bike_bookings_bikes` (`bike_id`),
  CONSTRAINT `FK_bike_bookings_bikes` FOREIGN KEY (`bike_id`) REFERENCES `bikes` (`id`),
  CONSTRAINT `FK_bike_bookings_users` FOREIGN KEY (`booked_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table bike_rental.bike_bookings: ~12 rows (approximately)
/*!40000 ALTER TABLE `bike_bookings` DISABLE KEYS */;
INSERT INTO `bike_bookings` (`id`, `booked_by`, `bike_id`, `booked_on`, `status`, `start_date`, `end_date`, `modified_by`, `modified_on`, `delete_flag`) VALUES
	(1, 3, 2, '2022-09-30 10:29:47', 'Booked', '2022-10-05 20:24:00', '2022-10-05 22:24:00', NULL, NULL, 0),
	(2, 3, 9, '2022-09-30 10:31:08', NULL, '2022-09-02 22:30:00', '2022-09-04 22:30:00', NULL, NULL, 0),
	(3, 3, 11, '2022-09-30 10:31:37', 'Booked', '2022-09-04 22:31:00', '2022-09-04 23:31:00', NULL, NULL, 0),
	(4, 3, 4, '2022-10-01 20:08:43', 'Paid', '2022-09-09 23:08:00', '2022-09-10 23:08:00', NULL, NULL, 0),
	(5, 3, 4, '2022-10-01 20:08:43', 'Booked', '2022-09-09 23:08:00', '2022-09-10 23:08:00', NULL, NULL, 0),
	(6, 1, 4, '2022-10-01 20:08:43', NULL, '2022-09-09 23:08:00', '2022-09-10 23:08:00', NULL, NULL, 0),
	(7, 3, 4, '2022-10-01 20:08:43', 'Paid', '2022-09-16 23:08:00', '2022-09-17 23:08:00', NULL, NULL, 0),
	(8, 3, 3, '2022-10-02 20:08:43', NULL, '2022-09-01 23:14:00', '2022-09-02 23:14:00', NULL, NULL, 0),
	(9, 7, 11, '2022-10-03 20:08:43', 'Cancelled', '2022-09-03 23:15:00', '2022-09-04 23:15:00', NULL, NULL, 0),
	(10, 3, 10, '2022-10-03 20:08:43', NULL, '2022-09-10 21:16:00', '2022-09-10 23:16:00', NULL, NULL, 1),
	(11, 7, 10, '2022-10-04 20:08:43', 'Cancelled', '2022-09-01 10:20:00', '2022-09-04 10:20:00', 7, '2022-09-30 10:30:04', 0),
	(12, 7, 10, '2022-10-05 20:08:43', NULL, '2022-09-01 10:24:00', '2022-09-04 10:24:00', NULL, NULL, 0);
/*!40000 ALTER TABLE `bike_bookings` ENABLE KEYS */;

-- Dumping structure for table bike_rental.cities
DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `counties_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table bike_rental.cities: ~5 rows (approximately)
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
INSERT INTO `cities` (`id`, `city`, `created_by`, `created_on`, `modified_by`, `modified_on`, `delete_flag`) VALUES
	(1, 'Mombasa', 1, '2022-09-30 10:34:40', NULL, '2022-09-30 10:45:30', 0),
	(2, 'Eldoret', 1, '2022-09-30 10:35:10', NULL, '2022-09-30 10:55:30', 0),
	(3, 'Nakuru', 1, '2022-09-30 10:35:30', NULL, NULL, 0),
	(4, 'Kisumu', 1, '2022-09-30 10:35:30', NULL, NULL, 0),
	(5, 'Nairobi', 1, '2022-09-30 10:35:30', NULL, NULL, 0);
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;

-- Dumping structure for table bike_rental.feedback
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comments` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `created_on` datetime NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

-- Dumping data for table bike_rental.feedback: ~4 rows (approximately)
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
INSERT INTO `feedback` (`id`, `comments`, `created_by`, `created_on`, `delete_flag`) VALUES
	(1, 'I love the variety of bikes in place', 3, '2022-09-30 10:56:51', 0),
	(2, 'I can book again', 3, '2022-09-30 10:59:11', 0),
	(3, 'I can book another bike', 7, '2022-09-30 11:00:22', 0),
	(4, 'Will you stock cars?', 7, '2022-09-30 11:00:34', 0);
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;

-- Dumping structure for table bike_rental.usergroups
DROP TABLE IF EXISTS `usergroups`;
CREATE TABLE IF NOT EXISTS `usergroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table bike_rental.usergroups: ~4 rows (approximately)
/*!40000 ALTER TABLE `usergroups` DISABLE KEYS */;
INSERT INTO `usergroups` (`id`, `name`, `created_by`, `created_on`, `modified_by`, `modified_on`, `delete_flag`) VALUES
	(1, 'Administrator', 1, '2022-09-30 10:35:30', NULL, NULL, 0),
	(2, 'Vendor', 1, '2022-09-30 10:35:30', NULL, NULL, 0),
	(3, 'Standard', 1, '2022-09-30 10:35:30', NULL, NULL, 0),
	(4, 'Guest', 1, '2022-09-30 10:35:30', NULL, NULL, 0);
/*!40000 ALTER TABLE `usergroups` ENABLE KEYS */;

-- Dumping structure for table bike_rental.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `FK_users_usergroups` (`group_id`),
  CONSTRAINT `FK_users_usergroups` FOREIGN KEY (`group_id`) REFERENCES `usergroups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table bike_rental.users: ~9 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `group_id`, `first_name`, `last_name`, `password`, `remember_token`, `email`, `mobile_number`, `created_on`, `modified_by`, `modified_on`, `delete_flag`) VALUES
	(1, 1, 'System', 'Admin', '$2y$10$j2Y/VEIWFSwh.kXDAB4oKODJfotVfil9khTZUs/Oo5N/V9yUn8uxy', 'WFrNbEAdxpmwGiGCZL1vFGCMDDQSaqpBrqEoU7EVSfbsEbOxxi1Nm7sSgWo6', 'admin@bikes.com', NULL, '2022-09-30 10:14:26', NULL, NULL, 0),
	(2, 4, 'System', 'Guest', '$2y$10$j2Y/VEIWFSwh.kXDAB4oKODJfotVfil9khTZUs/Oo5N/V9yUn8uxy', NULL, 'guest@bikes.com', NULL, '2022-09-30 10:24:26', NULL, NULL, 0),
	(3, 3, 'Paul', 'Maina', '$2y$10$j2Y/VEIWFSwh.kXDAB4oKODJfotVfil9khTZUs/Oo5N/V9yUn8uxy', '1qtwjEVU1jdQZkLdz64vJMDvoBbGz1Z4zKYFnhof5qTLoM1ESi7nXJ8RfiB8', 'mambono@mambono.com', '0722822791', '2022-09-30 10:24:26', NULL, NULL, 0),
	(4, 2, 'Paul', 'Mwangi', '$2y$10$R8D8v4fK1hGJdz1p2iJbjeeMmYwHT7sZy/XZ0e6Jow4pfRvlmlDgO', 'RYmpL09F6W1mZZXjq6aL8IvrznaNM7LgVjd8erQZtzu9UuCZxQPahIY4H57H', 'mambono@gmail.com', '0722822791', '2022-09-30 10:24:26', NULL, NULL, 0),
	(7, 3, 'Steven', 'Maina', '$2y$10$0rSAcvOc2c9EJ8QYzrHrvejlAQyC0xIolEEPQcyBP9t4ANJAy76wC', 'NqKyfqgQBBkHMr7vhX0hGiiGe4TwZgnkXYiT3grvrxAUsnEfRsCQs7CfofB2', 'steven.maina@gmail.com', '3345532', '2022-09-30 10:24:26', NULL, NULL, 0),
	(8, 2, 'Joel', 'Waire', '$2y$10$JIePLv14B0HB3e3dVoqTOOAKgLc/6s3SSDTzzbkoytCylhOsjh5L.', 'vjQIquO8rXwueJb4FVQCQLTqwTcJVhZ47FsFE0y5bnox4ADOwyizfgAKTRq6', 'joel.waire@gmail.com', '020987892', '2022-09-30 11:20:27', 1, '2022-09-30 11:22:22', 0),
	(9, 2, 'Mike', 'Coolie', '$2y$10$5e83HmkGHWx0VnkYpXYN5eT5viziyagXKD3p5M016gnPhWToDxtbq', 'CgT4PXhiYsnD8hGpENQChuDi6YXuMwDBaOg6nDg3yiaJwPMbe87avLX308tw', 'mike@bikes.com', '020244644', '2022-09-30 11:21:27', 1, '2022-09-30 11:24:34', 0),
	(10, 2, 'Samuel', 'Mwangi', '$2y$10$j.f31OlPP6s/woPLZ.pqaueFSGHwO1Qr58n367c3IpIAbkY1iC7xO', NULL, 'samwax@gmail.com', '0720579887', '2022-09-30 11:22:28', 1, '2022-09-30 11:24:19', 0),
	(11, 2, 'Phreciah', 'Wanjiru', '$2y$10$5e83HmkGHWx0VnkYpXYN5eT5viziyagXKD3p5M016gnPhWToDxtbq', 'EDtoZOOO63Sx4DSYNvr7AeuqRThsTXGFXNOpArIVC30giHjGL30gr58r7o9y', 'pwaire@gmail.com', '0726444222', '2022-09-30 11:23:06', 1, '2022-09-30 11:24:10', 0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table bike_rental.vendors
DROP TABLE IF EXISTS `vendors`;
CREATE TABLE IF NOT EXISTS `vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendor_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `city_id` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone_number` varchar(255) DEFAULT NULL,
  `created_by` tinyint(1) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `modified_by` tinyint(1) DEFAULT NULL,
  `modified_on` datetime DEFAULT NULL,
  `delete_flag` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `FK_vendors_users` (`user_id`),
  CONSTRAINT `FK_vendors_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table bike_rental.vendors: ~5 rows (approximately)
/*!40000 ALTER TABLE `vendors` DISABLE KEYS */;
INSERT INTO `vendors` (`id`, `vendor_name`, `user_id`, `city_id`, `address`, `email`, `telephone_number`, `created_by`, `created_on`, `modified_by`, `modified_on`, `delete_flag`) VALUES
	(1, 'ZuzuBikeshop', 8, '5', 'P.O. Box 12345', 'zuzu@gmail.com', '123456', NULL, '2022-09-30 10:30:18', 1, '2022-09-30 11:38:22', 0),
	(2, 'Prime Bikes', 4, '5', 'P.O. Box 12345', 'zuzu@gmail.com', '123456', NULL, '2022-09-30 10:32:18', 1, '2022-09-30 11:15:27', 0),
	(3, 'Mikey\'s Bike Rentals', 9, '3', 'P.O. Box 608776', 'mikey@bikes.com', '020244644', 1, '2022-09-30 10:40:18', 1, '2022-09-30 10:43:18', 0),
	(4, 'Samido Bikes', 10, '5', 'P.O. Box 11111', 'samwax@gmail.com', '0720579887', 1, '2022-09-30 11:25:17', NULL, '2022-09-30 09:41:11', 0),
	(5, 'Murera Bike Shop', 11, '5', 'P.O. Box 22222 Nairobi', 'pwaire@gmail.com', '0726444222', 1, '2022-09-30 11:25:51', NULL, NULL, 0);
/*!40000 ALTER TABLE `vendors` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
