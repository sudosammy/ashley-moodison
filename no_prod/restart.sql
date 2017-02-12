-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for ashley
DROP DATABASE IF EXISTS `ashley`;
CREATE DATABASE IF NOT EXISTS `ashley` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `ashley`;

-- Dumping structure for table ashley.accounts
DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `salt` char(6) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `profile_image` varchar(60) NOT NULL,
  `desc` varchar(200) DEFAULT NULL,
  `credits` tinyint(4) NOT NULL DEFAULT '0',
  `ip_addr` varchar(45) DEFAULT NULL,
  `enc_key` char(32) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table ashley.accounts: ~3 rows (approximately)
DELETE FROM `accounts`;
/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` (`account_id`, `username`, `password`, `salt`, `admin`, `profile_image`, `desc`, `credits`, `ip_addr`, `enc_key`, `last_login`) VALUES
	(1, 'Robert', '9e6f0fabff1fe6a2fee4b24ed761464c4bfb8d4fb73dc8088004495586155c254efd629f615f7b3bfaf7dd014ee6303bdf9c37505e86e192ae07515ba873090b', 'dWTjBo', 1, 'Administrator-712.jpeg', 'Hi, I\'m Robert the administrator of Ashley Moodison.<br /><br />Make sure to check out my sick profile (I\'m levitating a ball). Thanks :)', 8, NULL, 'NVNwYEpIfapop6ymJygLC55gakwDVWHg', '2017-01-14 15:19:03'),
	(2, 'Lucy', '2859d63b60b7b678bb680004ba2b37c8e6322ee871cdefab75eb0419aecaa18c7390bb1c34507ce0ba9cc02fac84058021940f1af40d76493180d3397e7655cc', '7MHbd@', 0, 'Lucy-861.jpeg', 'Lovely. Lucky. Loony. Lazy. Lanky. Lucy &lt;3', 10, NULL, 'qDjefEWUCF67T0I9vUQDLGlGRGzdNJUs', '2017-01-12 19:54:23'),
	(3, 'Sam', 'e6a4e17bf42306ceb821808211022cf7641334335ca56ee9632cd17f66f3f625a78451db219d709b6a7229c971d48884ac510caa6faba932624bb7c7075625ee', 'i!KE8g', 0, 'Sam-194.png', 'Pic from a recent time I was on a plane. I love those things.', 10, NULL, 'xcvf90OVrSpnr47J0yD3vRRlk2ESAV4h', '2017-01-14 15:19:36');
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

-- Dumping structure for table ashley.api
DROP TABLE IF EXISTS `api`;
CREATE TABLE IF NOT EXISTS `api` (
  `api_id` int(11) NOT NULL AUTO_INCREMENT,
  `table` varchar(50) NOT NULL,
  `token` char(32) NOT NULL,
  PRIMARY KEY (`api_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table ashley.api: ~2 rows (approximately)
DELETE FROM `api`;
/*!40000 ALTER TABLE `api` DISABLE KEYS */;
INSERT INTO `api` (`api_id`, `table`, `token`) VALUES
	(1, 'accounts', 'HscMJHMS8b76Sw2YRymGfhAbCuyfYUkr'),
	(2, 'messages', 'Q8AGePGLvSsgTCazpRNZTyNLwkZtCM23'),
	(3, 'flag_table', '376DWALmQ2pdHXxFyXQp7dhW2VtbuGjq');
/*!40000 ALTER TABLE `api` ENABLE KEYS */;

-- Dumping structure for table ashley.flag_table
DROP TABLE IF EXISTS `flag_table`;
CREATE TABLE IF NOT EXISTS `flag_table` (
  `flag_id` int(11) NOT NULL AUTO_INCREMENT,
  `flag` varchar(50) NOT NULL,
  PRIMARY KEY (`flag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table ashley.flag_table: ~5 rows (approximately)
DELETE FROM `flag_table`;
/*!40000 ALTER TABLE `flag_table` DISABLE KEYS */;
INSERT INTO `flag_table` (`flag_id`, `flag`) VALUES
	(1, 'FLAG: HonorablePreviousLiquidHorn'),
	(2, 'The flag is in the flag2.txt file'),
	(3, 'FLAG: MountainRespectMadly'),
	(4, 'The flag is in Robert\'s messages'),
	(5, 'FLAG: HOLYSMOKESYOUDIDIT! Congratulations! THE END');
/*!40000 ALTER TABLE `flag_table` ENABLE KEYS */;

-- Dumping structure for table ashley.hints
DROP TABLE IF EXISTS `hints`;
CREATE TABLE IF NOT EXISTS `hints` (
  `hint_id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`hint_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Dumping data for table ashley.hints: ~10 rows (approximately)
DELETE FROM `hints`;
/*!40000 ALTER TABLE `hints` DISABLE KEYS */;
INSERT INTO `hints` (`hint_id`, `text`) VALUES
	(1, 'The first flag is on the index.php page found in a commonly named directory.'),
	(2, 'The fifth flag is the only one that requires an SQL injection.'),
	(3, 'You don\'t need to be authenticated to get the second flag.'),
	(4, 'The second flag gets included on the admin.php page and the third flag is on your profile page once you have an administrator account.'),
	(5, 'You can\'t esculate an existing account to administrator.'),
	(6, 'If you\'re not using the LFI to help you progress through the game you should start.'),
	(7, 'Your encryption key is account specific and doesn\'t change. The challenge is not bruteforce.'),
	(8, 'You have the ability to know the plain and cipher text of a message encrypted with an unknown key.'),
	(9, 'The game runs on MySQL version 5.5 from the repositories of Ubuntu 14.04 LTS. Why not 16.04 LTS?'),
	(10, 'You don\\\'t need a 10th hint. I\\\'m disappointed in you.');
/*!40000 ALTER TABLE `hints` ENABLE KEYS */;

-- Dumping structure for table ashley.messages
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` varchar(500) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `account_id` (`sender_id`),
  KEY `receiver_id` (`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table ashley.messages: ~1 rows (approximately)
DELETE FROM `messages`;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `message`, `timestamp`) VALUES
	(1, 1, 1, 'HR4BJwkMPg5GLTk8JAxFDzhZSHJ3TRUkAAUEZDkxaDQhIz5LOzdQZlhQQhdQZhAIOUUFPmMaC1AZSzIjMSR0BTx2YUloPVAEDw0bUxJEWUJ0TB9sAkVFCwQYSyYkd2dZfS5uMDg3FCwIQTgAFUUcHnYbFWxsCwQfQSUSM3YUKRM=', '2016-12-14 13:24:41'),
	(2, 1, 1, 'CBoPMGNlIyIPDx4WP1oQGy8KJiAuWkYTNgoDJz4+JgByNDxXdnsiLAsEHQ0VRFkZJVkKLShQFQZBDxYwNzUpFCt2LBY6LgU5R0ElHBUWDQUvWSYcChVdAhMOTWR5NSkEJSM+BHYkACBIERgfTFQLTWVHWy4xFRpZIhkSICV3KRUrbHIVK2VfdyIjSk8RVRoCPxcTP39XR0dOVSMrPTImXW4ePRQUDzgENVkSWEZlDl8TKx4hBFNdJgMoAj0wDh0MPGosBXlqTnUEE1BATnI7V2oUAj8wVFICElcVNnZ4djMhPSsZY2UhcScmFT83eg8+OR4zDyJPRTUvMSM9GBs/DBQiDTprdkwrFEFfUUxUC01lRyMOeRVTCwAMKDA3NSQCcjQ8V3Z7JCYNBB5V', '2017-01-10 19:07:28');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
