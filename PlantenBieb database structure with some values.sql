-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 29 aug 2018 om 08:12
-- Serverversie: 5.7.21
-- PHP-versie: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `planten`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_parent` int(22) NOT NULL,
  `cat_visible` int(1) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_parent`, `cat_visible`) VALUES
(1, 'Groente', 0, 1),
(2, 'Fruit', 0, 1),
(3, 'Noten', 0, 1),
(4, 'Kamerplanten', 0, 1),
(5, 'Bloemen', 0, 1),
(6, 'Kruiden', 0, 1),
(7, 'Paddenstoelen', 0, 1),
(8, 'Tomaten', 1, 1),
(9, 'Komkommers', 1, 1),
(10, 'Appels', 2, 1),
(11, 'Peren', 2, 1),
(12, 'Frambozen', 2, 1),
(13, 'Hazelnoten', 3, 1),
(14, 'Aloe Vera', 4, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
  `conv_id` int(11) NOT NULL AUTO_INCREMENT,
  `conv_u1` int(255) NOT NULL,
  `conv_u2` int(255) NOT NULL,
  `conv_startdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`conv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `conversations`
--

INSERT INTO `conversations` (`conv_id`, `conv_u1`, `conv_u2`, `conv_startdate`) VALUES
(12, 14, 15, '2018-08-27 11:27:38'),
(11, 14, 16, '2018-08-27 11:08:52'),
(10, 15, 16, '2018-08-27 10:51:35');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) NOT NULL,
  `image_product` int(22) NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `message_offer` int(255) NOT NULL,
  `message_from` int(255) NOT NULL,
  `message_to` int(255) NOT NULL,
  `message_content` varchar(25555) NOT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_read` int(1) NOT NULL DEFAULT '0',
  `message_conversation` int(255) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `messages`
--

INSERT INTO `messages` (`message_id`, `message_offer`, `message_from`, `message_to`, `message_content`, `message_date`, `message_read`, `message_conversation`) VALUES
(65, 15, 14, 15, 'awofokwa', '2018-08-27 11:57:36', 1, 0),
(64, 15, 14, 15, 'awfaw', '2018-08-27 11:57:33', 1, 0),
(63, 15, 14, 15, 'fwaafw', '2018-08-27 11:56:04', 1, 0),
(62, 14, 15, 14, 'Hihihiii', '2018-08-27 11:54:42', 1, 0),
(61, 15, 14, 15, 'Jajaaa', '2018-08-27 11:54:30', 1, 0),
(60, 15, 14, 15, 'Joooo', '2018-08-27 11:54:24', 1, 0),
(59, 14, 15, 14, 'HOOOI HENKDE TANK!', '2018-08-27 11:46:48', 1, 0),
(58, 15, 14, 15, 'Ja', '2018-08-27 11:40:10', 1, 0),
(57, 15, 14, 15, 'Hoi', '2018-08-27 11:40:08', 1, 0),
(56, 15, 14, 15, 'Hoi!', '2018-08-27 11:40:05', 1, 0),
(55, 15, 14, 15, 'Hoi!', '2018-08-27 11:40:05', 1, 0),
(54, 14, 15, 14, 'Hallo!', '2018-08-27 11:27:49', 1, 0),
(53, 14, 16, 14, 'Beste Henk, zou ik 1 van de walnotenbomen kunnen krijgen? Zo ja, waar moet ik wezen en wanneer kan ik langskomen?', '2018-08-27 11:09:32', 1, 0),
(52, 15, 16, 15, 'fwa', '2018-08-27 11:05:10', 1, 0),
(51, 15, 16, 15, 'fwa', '2018-08-27 11:05:09', 1, 0),
(48, 15, 16, 15, 'fwa', '2018-08-27 11:05:06', 1, 0),
(49, 15, 16, 15, 'fwa\\', '2018-08-27 11:05:07', 1, 0),
(50, 15, 16, 15, 'fwa', '2018-08-27 11:05:08', 1, 0),
(47, 15, 16, 15, 'fwa', '2018-08-27 11:05:04', 1, 0),
(45, 15, 16, 15, 'Hallo!', '2018-08-27 10:51:39', 1, 0),
(46, 16, 15, 16, 'Hooi!', '2018-08-27 10:53:05', 1, 0),
(66, 14, 15, 14, 'fwafwaf', '2018-08-28 07:52:30', 1, 0),
(67, 14, 15, 14, 'ffwafwa', '2018-08-28 08:03:34', 1, 0),
(68, 14, 15, 14, 'aa', '2018-08-28 09:13:29', 1, 0),
(69, 14, 15, 14, 'akak', '2018-08-28 09:15:22', 1, 0),
(70, 14, 15, 14, 'fwafwa', '2018-08-28 09:16:10', 1, 0),
(71, 14, 15, 14, 'fwafw', '2018-08-28 09:16:12', 1, 0),
(72, 15, 14, 15, 'fwafwa', '2018-08-28 09:21:32', 0, 0),
(73, 15, 14, 15, 'hihaa', '2018-08-28 09:35:26', 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `offers`
--

DROP TABLE IF EXISTS `offers`;
CREATE TABLE IF NOT EXISTS `offers` (
  `offer_id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_title` varchar(255) NOT NULL,
  `offer_kind` varchar(255) NOT NULL,
  `offer_category` varchar(255) NOT NULL,
  `offer_description` text NOT NULL,
  `offer_amount` varchar(255) NOT NULL,
  `offer_picture` varchar(255) NOT NULL,
  `offer_user` int(25) NOT NULL,
  `offer_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`offer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `offers`
--

INSERT INTO `offers` (`offer_id`, `offer_title`, `offer_kind`, `offer_category`, `offer_description`, `offer_amount`, `offer_picture`, `offer_user`, `offer_date`) VALUES
(16, ' Cherry Tomaten', 'Zaad', '8', 'Geven hele lekkere tomaten!', '200 stuks', 'axf1JDbegXtRSJVQ9FUFb0gjyrjendVoe1qhe6GRW90AtpgqpANRRUrRp5xT9kWVGnZp6rxlYeUbrYYT3o2WVGZiDB8qjkljvCWqPROD_def6f2dd8a508ae5a726da3f917bac9a_259.png', 15, '2018-08-26 11:33:12'),
(17, 'fwada', 'Zaad', '9', 'fwad', '23', '', 15, '2018-08-26 16:46:50'),
(18, 'Testen', 'Zaad', '8', 'affwfwa', 'fwafwa', 'NEXURT1Fv4LjjUwjnE9Bh0ZG8aSvwTaxxnHLMlOEl0l9P5EKiOzpnTsA9y9hdvZVFYOv4FXvyOiRH894BQn5REjnyNNViZab9ri8Desert.jpg', 15, '2018-08-28 08:21:54'),
(15, ' Walnotenbomen', 'Plant', '13', 'Zelf eruit halen!', '1 Stuk', 'lhAuCfActTTCL87rPulVvTbK8PH9zgwR9FH4JZSwDJ6qIQ0ukNEXizFwYC6pdUAllUcxdCxJasH63rgpc0lRt7v9chSxeq2HU34TWalnoot-25jr-logo1.jpg', 14, '2018-08-25 19:36:53');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `points`
--

DROP TABLE IF EXISTS `points`;
CREATE TABLE IF NOT EXISTS `points` (
  `point_id` int(11) NOT NULL AUTO_INCREMENT,
  `point_amount` int(255) NOT NULL,
  `point_from` int(255) NOT NULL,
  `point_to` int(255) NOT NULL,
  `point_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`point_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_mail` varchar(255) NOT NULL,
  `user_created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_password` varchar(255) NOT NULL,
  `user_zip` varchar(20) NOT NULL,
  `user_points` varchar(255) NOT NULL,
  `user_bio` text NOT NULL,
  `user_active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_mail`, `user_created_at`, `user_password`, `user_zip`, `user_points`, `user_bio`, `user_active`) VALUES
(28, 'hewaknwakj', 'adwhawfwajijiw@dijaijdwadwa.com', '2018-08-26 12:48:20', '5541c7b5a06c39b267a5efae6628e003', '23871', '0', 'kakakaka', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
