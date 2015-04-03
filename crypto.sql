-- phpMyAdmin SQL Dump
-- version 4.1.14deb0.1
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 14 Mai 2014 à 13:45
-- Version du serveur :  5.5.37-0ubuntu0.12.04.1
-- Version de PHP :  5.5.11-3+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `crypto`
--

-- --------------------------------------------------------

--
-- Structure de la table `access_violations`
--

CREATE TABLE IF NOT EXISTS `access_violations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(55) NOT NULL,
  `ip` text NOT NULL,
  `user_agent` varchar(55) NOT NULL,
  `time` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1343 ;

-- --------------------------------------------------------

--
-- Structure de la table `Api_Keys`
--

CREATE TABLE IF NOT EXISTS `Api_Keys` (
  `User_ID` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Public_Key` text NOT NULL,
  `Authentication_Key` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=166 ;

--
-- Contenu de la table `Api_Keys`
--

INSERT INTO `Api_Keys` (`User_ID`, `id`, `Public_Key`, `Authentication_Key`) VALUES
(679, 1, 'IFJEPIFJPOQKJDIJKZJIJRFIRFHIJZEUHF', 'HFIOEFOHEOFHLPAOIEJWBDIZUIEOZPPSMK');

-- --------------------------------------------------------

--
-- Structure de la table `balances`
--

CREATE TABLE IF NOT EXISTS `balances` (
  `Account` varchar(255) NOT NULL,
  `Amount` text NOT NULL,
  `Coin` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Helding` varchar(50) NOT NULL,
  `Wallet_ID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27077 ;

--
-- Contenu de la table `balances`
--

INSERT INTO `balances` (`Account`, `Amount`, `Coin`, `id`, `Helding`, `Wallet_ID`) VALUES
('Test10', '0.0', 'NUT', 27076, '0', 173),
('Test10', '0.0', 'AUR', 27075, '0', 172),
('Test10', '0.0', 'USDE', 27074, '0', 171),
('Test10', '0.0', 'POT', 27073, '0', 170),
('Test10', '0.0', 'XXL', 27072, '0', 169),
('Test10', '0.0', 'WATER', 27071, '0', 168),
('Test10', '0.0', 'MZC', 27070, '0', 167),
('Test10', '0.0', 'LTB', 27069, '0', 166),
('Test10', '0.0', 'DOGE', 27068, '0', 165),
('Test10', '0.0', 'LTC', 27067, '0', 164),
('Test10', '0.0', 'BTC', 27066, '0', 163),
('test1', '0.0', 'NUT', 27054, '0', 173),
('test1', '0.0', 'AUR', 27053, '0', 172),
('test1', '0.0', 'USDE', 27052, '0', 171),
('test1', '0.0', 'POT', 27051, '0', 170),
('test1', '0.0', 'XXL', 27050, '0', 169),
('test1', '0.0', 'WATER', 27049, '0', 168),
('test1', '0.0', 'MZC', 27048, '0', 167),
('test1', '0.0', 'LTB', 27047, '0', 166),
('test1', '0.0', 'DOGE', 27046, '0', 165),
('test1', '0.0', 'LTC', 27045, '0', 164),
('test1', '0.0', 'BTC', 27044, '0', 163),
('test', '0.0', 'NUT', 27043, '0', 173),
('julien', '0.0', 'NUT', 27042, '0', 173),
('pierre', '0.0', 'NUT', 27041, '0', 173),
('admin', '0.0', 'NUT', 27040, '0', 173),
('test', '0.0', 'AUR', 27039, '0', 172),
('julien', '0.0', 'AUR', 27038, '0', 172),
('pierre', '0.0', 'AUR', 27037, '0', 172),
('admin', '0.0', 'AUR', 27036, '0', 172),
('test', '0.0', 'USDE', 27035, '0', 171),
('julien', '0.0', 'USDE', 27034, '0', 171),
('pierre', '0.0', 'USDE', 27033, '0', 171),
('admin', '0.0', 'USDE', 27032, '0', 171),
('test', '0.0', 'POT', 27031, '0', 170),
('julien', '0.0', 'POT', 27030, '0', 170),
('pierre', '0.0', 'POT', 27029, '0', 170),
('admin', '0.0', 'POT', 27028, '0', 170),
('test', '0.0', 'XXL', 27027, '0', 169),
('julien', '0.0', 'XXL', 27026, '0', 169),
('pierre', '0.0', 'XXL', 27025, '0', 169),
('admin', '0.0', 'XXL', 27024, '0', 169),
('test', '0.0', 'WATER', 27023, '0', 168),
('julien', '0.0', 'WATER', 27022, '0', 168),
('pierre', '0.0', 'WATER', 27021, '0', 168),
('admin', '0.0', 'WATER', 27020, '0', 168),
('test', '0.0', 'MZC', 27019, '0', 167),
('julien', '0.0', 'MZC', 27018, '0', 167),
('pierre', '3079.4', 'MZC', 27017, '0', 167),
('admin', '0.0', 'MZC', 27016, '0', 167),
('test', '0.0', 'LTB', 27015, '0', 166),
('julien', '0.0', 'LTB', 27014, '0', 166),
('pierre', '0.0', 'LTB', 27013, '0', 166),
('julien', '0.03130783505', 'LTC', 27006, '0', 164),
('julien', '5667', 'DOGE', 27010, '0', 165),
('admin', '0.0', 'LTB', 27012, '0', 166),
('test', '0.0', 'DOGE', 27011, '0', 165),
('pierre', '419061.96582461', 'DOGE', 27009, '149222', 165),
('admin', '19', 'DOGE', 27008, '0', 165),
('test', '0.0', 'LTC', 27007, '0', 164),
('pierre', '0.78253868755', 'LTC', 27005, '0.20463154', 164),
('admin', '0.0048593774', 'LTC', 27004, '0', 164),
('test', '0.0', 'BTC', 27003, '0', 163),
('julien', '0.0', 'BTC', 27002, '0', 163),
('pierre', '0.0', 'BTC', 27001, '0.00030578045', 163),
('admin', '0.0095', 'BTC', 27000, '0', 163);

-- --------------------------------------------------------

--
-- Structure de la table `bantables_ip`
--

CREATE TABLE IF NOT EXISTS `bantables_ip` (
  `date` text NOT NULL,
  `ip` varchar(55) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Structure de la table `Canceled_Trades`
--

CREATE TABLE IF NOT EXISTS `Canceled_Trades` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `To` text NOT NULL,
  `From` text NOT NULL,
  `Amount` text NOT NULL,
  `Value` double NOT NULL,
  `User_ID` int(11) NOT NULL,
  `Type` text NOT NULL,
  `Finished` int(11) NOT NULL DEFAULT '0',
  `Fee` text NOT NULL,
  `Total` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2276 ;

-- --------------------------------------------------------

--
-- Structure de la table `Chat`
--

CREATE TABLE IF NOT EXISTS `Chat` (
  `Timestamp` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Chat`
--

INSERT INTO `Chat` (`Timestamp`, `Username`, `Message`) VALUES
(1399505337, 'julien', 'salut!'),
(1399507140, 'pierre', 'hello'),
(1399507178, 'julien', 'hello'),
(1399507196, 'julien', 'you should sell all your DOGE !!'),
(1399543439, 'julien', 'hello'),
(1399544152, 'julien', 'ikkdkedzdc'),
(1399544163, 'julien', 'ok'),
(1399544207, 'julien', 'hello'),
(1399544704, 'julien', 'salut Ã§a va?:)'),
(1399544723, 'julien', 'salut oui et toi'),
(1399544727, 'julien', 'ca va impec'),
(1399545258, 'julien', 'salut'),
(1399545259, 'julien', 'ca'),
(1399545260, 'julien', 'va'),
(1399563273, 'pierre ', 'HI there'),
(1399563312, 'pierre ', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(1399563333, 'pierre ', 'javascript:alert("ok");'),
(1399563374, 'pierre ', ''''' OR 1 --'''),
(1399563650, 'pierre ', 'aaaaaaaaaaaaaaaaaaaaa'),
(1399563658, 'pierre ', '1'),
(1399563659, 'pierre ', '2'),
(1399563659, 'pierre ', '434'),
(1399664022, 'pierre', 'hi'),
(1399664110, 'julien', 'hello pierre'),
(1399664127, 'pierre', 'salut julien'),
(1399664224, 'pierre', 'gggg'),
(1399664233, 'julien', 'kkk'),
(1399664236, 'julien', 'tttt'),
(1399664242, 'pierre', 'jjjj'),
(1399664338, 'pierre', 'marcghhhhhh'),
(1399664340, 'pierre', 'l'),
(1399664343, 'pierre', 'nnnnnnn'),
(1399664347, 'julien', 'kkkkkk'),
(1399668574, 'pierre', 'hhhhhh'),
(1399729844, 'pierre', 'hh'),
(1399746934, 'julien', 'hello'),
(1399747413, 'julien', 'ok'),
(1399762020, 'pierre', 'hoyÃ©Ã©Ã©Ã©'),
(1399762061, 'julien', 'salut pier'),
(1399763340, 'julien', 'http://crypto-maniac.com/users/trades.php?market=doge-ltc'),
(1400052858, 'julien', 'hi'),
(1400053185, 'julien', 'hello'),
(1400053207, 'julien', 'hi'),
(1400053508, 'julien', 'l'),
(1400059499, 'pierre', 'ping'),
(1400059502, 'pierre', 'pong'),
(1400060564, 'pierre', 'sell your doges!'),
(1400063774, 'pierre', 'hello');

-- --------------------------------------------------------

--
-- Structure de la table `deposits`
--

CREATE TABLE IF NOT EXISTS `deposits` (
  `Timestamp` int(11) NOT NULL,
  `Transaction_Id` text NOT NULL,
  `Amount` double NOT NULL,
  `Coin` text NOT NULL,
  `Paid` tinyint(1) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Account` text,
  `Confirmations` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6179 ;

--
-- Contenu de la table `deposits`
--

INSERT INTO `deposits` (`Timestamp`, `Transaction_Id`, `Amount`, `Coin`, `Paid`, `id`, `Account`, `Confirmations`) VALUES
(1399392197, 'f98dcb13c6d764b340418cd2a0639400e160daf355e6060aa90b77482079e5c9', 14.8, 'MZC', 1, 6173, 'pierre', 4902),
(1399392197, '96139a332dec59537cd2a6005cd07bfb9bbc5577f9985518c9df360f6f65e0f4', 49.8, 'MZC', 1, 6172, 'pierre', 6400),
(1399251301, 'c6430abe38906ff91e22da448bc7332e361733f83291438867f446f7251cc582', 0.0095, 'BTC', 1, 6171, 'admin', 76),
(1400061061, 'a9b0e8de1fa1574854f5c866833ac7cece7387e8e75674c6687e7af99f2dbef6', 10003.37675496, 'DOGE', 1, 6178, 'pierre', 6),
(1399895641, 'e9f97a292046ec388cf935b8540c58eb9c2d29bc356a94aaed4079c9b29ee27e', 19, 'DOGE', 1, 6176, 'admin', 5),
(1399896361, 'faa94229852ab1c902bc9b60b813154d9dec0abf5f65a2a961338bf952f8a580', 413725.58906965, 'DOGE', 1, 6177, 'pierre', 4),
(1399204801, 'd40148f7e186786cace93aa9fc26741d11e2623abb0c76fc27c51e000d0bed85', 0.1577059, 'LTC', 1, 6166, 'pierre', 5828),
(1399204801, '5c10b51a1ee476631eb0bebf37b660042c07ade271615ebdb84b500de9e2edbe', 0.811, 'LTC', 1, 6165, 'pierre', 6053),
(1399204801, '73fa5f01dcf671adf997a05bfd3aaebc65fdd35c9c8dc1bffca27eea4158e62b', 0.249, 'LTC', 1, 6164, 'pierre', 6743),
(1399392197, '38284285a34e8792765e67834e16264a5f72f7a9a6760f2c83ba0b13eac05fb1', 3014.8, 'MZC', 1, 6174, 'pierre', 4887),
(1399797241, 'd76c7bc77069c7dd122a247a8a5f41e9169625dbb71a1822645a15d34f352b78', 99, 'DOGE', 1, 6175, 'pierre', 5);

-- --------------------------------------------------------

--
-- Structure de la table `Markets`
--

CREATE TABLE IF NOT EXISTS `Markets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Pair` varchar(50) NOT NULL,
  `disabled` tinyint(1) NOT NULL,
  `Fee` double NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=186 ;

--
-- Contenu de la table `Markets`
--

INSERT INTO `Markets` (`ID`, `Pair`, `disabled`, `Fee`) VALUES
(159, 'LTC/BTC', 0, 0.25),
(160, 'DOGE/BTC', 0, 0.25),
(161, 'DOGE/LTC', 0, 0.25),
(162, 'LTB/BTC', 1, 0.25),
(163, 'LTB/LTC', 0, 0.25),
(164, 'LTB/DOGE', 1, 0.25),
(165, 'MZC/BTC', 1, 0.4),
(166, 'MZC/LTC', 1, 0.4),
(167, 'MZC/DOGE', 0, 0.4),
(168, 'WATER/BTC', 1, 0.4),
(169, 'WATER/LTC', 1, 0.4),
(170, 'WATER/DOGE', 1, 0.4),
(171, 'XXL/BTC', 0, 0.4),
(172, 'XXL/LTC', 0, 0.4),
(173, 'XXL/DOGE', 1, 0.4),
(174, 'POT/BTC', 0, 0.4),
(175, 'POT/LTC', 0, 0.4),
(176, 'POT/DOGE', 1, 0.4),
(177, 'USDE/BTC', 0, 0.4),
(178, 'USDE/LTC', 0, 0.4),
(179, 'USDE/DOGE', 0, 0.4),
(180, 'AUR/BTC', 0, 0.4),
(181, 'AUR/LTC', 0, 0.4),
(182, 'AUR/DOGE', 1, 0.4),
(183, 'NUT/BTC', 0, 0.4),
(184, 'NUT/LTC', 0, 0.4),
(185, 'NUT/DOGE', 0, 0.4);

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `username` varchar(55) NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `color` text NOT NULL,
  `timestamp` text NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1455 ;

-- --------------------------------------------------------

--
-- Structure de la table `Notifications`
--

CREATE TABLE IF NOT EXISTS `Notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(50) NOT NULL,
  `Type` varchar(30) NOT NULL,
  `Text` varchar(255) NOT NULL,
  `Viewed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Contenu de la table `Notifications`
--

INSERT INTO `Notifications` (`id`, `Username`, `Type`, `Text`, `Viewed`) VALUES
(1, 'pierre', 'information', 'You just bought 9900.00000000 DOGE at a price of 0.00003000 LTC', 1),
(2, 'julien', 'information', 'You just sold 9900.00000000 DOGE at a price of 0.00003000 LTC', 1),
(3, 'pierre ', 'information', 'You just bought 10000.00000000 DOGE at a price of 0.00004000 LTC', 1),
(4, 'pierre', 'information', 'You just sold 10000.00000000 DOGE at a price of 0.00004000 LTC', 1),
(5, 'julien', 'information', 'You just bought 2000.00000000 DOGE at a price of 0.00003000 LTC', 1),
(6, 'pierre ', 'information', 'You just sold 2000.00000000 DOGE at a price of 0.00003000 LTC', 1),
(7, 'julien', 'information', 'You just bought 400.40636220 DOGE at a price of 0.00001332 LTC', 1),
(8, 'pierre', 'information', 'You just sold 400.40636220 DOGE at a price of 0.00001332 LTC', 1),
(9, 'pierre', 'information', 'You just made a deposit of99 DOGE. Please wait it reach 4 confirmations to use it', 1),
(10, 'admin', 'information', 'You just made a deposit of19 DOGE. Please wait it reach 4 confirmations to use it', 1),
(11, 'pierre', 'information', 'You just made a deposit of413725.58906965 DOGE. Please wait it reach 4 confirmations to use it', 1),
(12, 'pierre', 'information', 'You just made a deposit of 10003.37675496 DOGE. Please wait it reach 4 confirmations to use it', 1),
(13, 'julien', 'information', 'You just bought 4567.00000000 DOGE at a price of 0.00004371 LTC', 1),
(14, 'pierre', 'information', 'You just sold 4567.00000000 DOGE at a price of 0.00004371 LTC', 1),
(15, 'julien', 'information', 'You just bought 100.00000000 DOGE at a price of 0.00004312 LTC', 1),
(16, 'pierre', 'information', 'You just sold 100.00000000 DOGE at a price of 0.00004312 LTC', 1),
(17, 'pierre', 'information', 'You just made a deposit of .Please wait it reach 4 confirmations to use it', 1),
(18, 'pierre', 'information', 'Your order 2616 has been cancelled.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `TicketReplies`
--

CREATE TABLE IF NOT EXISTS `TicketReplies` (
  `ticket_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` longtext NOT NULL,
  `posted` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=249 ;

-- --------------------------------------------------------

--
-- Structure de la table `Tickets`
--

CREATE TABLE IF NOT EXISTS `Tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `posted` text NOT NULL,
  `opened` int(11) DEFAULT '1',
  `body` longblob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=142 ;

-- --------------------------------------------------------

--
-- Structure de la table `Trades`
--

CREATE TABLE IF NOT EXISTS `Trades` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Date` varchar(50) NOT NULL,
  `Pair` varchar(50) NOT NULL,
  `Amount` text NOT NULL,
  `Value` varchar(50) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Type` text NOT NULL,
  `Finished` int(11) NOT NULL DEFAULT '0',
  `Fee` text NOT NULL,
  `Total` text NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2630 ;

--
-- Contenu de la table `Trades`
--

INSERT INTO `Trades` (`Id`, `Date`, `Pair`, `Amount`, `Value`, `Username`, `Type`, `Finished`, `Fee`, `Total`) VALUES
(2615, '1399897738', 'DOGE/LTC', '5678.00000000', '0.00004390', 'pierre', 'SELL', 0, '0.25', '0.24926420000000002'),
(2614, '1399897719', 'DOGE/LTC', '4567.00000000', '0.00004377', 'pierre', 'SELL', 0, '0.25', '0.19989759'),
(2613, '1399897698', 'DOGE/LTC', '9089.00000000', '0.00004386', 'pierre', 'SELL', 0, '0.25', '0.39864353999999996'),
(2612, '1399897681', 'DOGE/LTC', '2987.00000000', '0.00004380', 'pierre', 'SELL', 0, '0.25', '0.1308306'),
(2611, '1399897658', 'DOGE/LTC', '1789.00000000', '0.00004403', 'pierre', 'SELL', 0, '0.25', '0.07876967'),
(2610, '1399897631', 'DOGE/BTC', '16000.00000000', '0.00000113', 'pierre', 'SELL', 0, '0.25', '0.01808'),
(2609, '1399897604', 'DOGE/BTC', '10000.00000000', '0.00000111', 'pierre', 'SELL', 0, '0.25', '0.011099999999999999'),
(2608, '1399897567', 'DOGE/BTC', '20000.00000000', '0.00000106', 'pierre', 'SELL', 0, '0.25', '0.0212'),
(2607, '1399897543', 'DOGE/BTC', '15000.00000000', '0.00000107', 'pierre', 'SELL', 0, '0.25', '0.01605'),
(2606, '1399897522', 'DOGE/BTC', '8000.00000000', '0.00000109', 'pierre', 'SELL', 0, '0.25', '0.00872'),
(2605, '1399897506', 'DOGE/BTC', '4000.00000000', '0.00000108', 'pierre', 'SELL', 0, '0.25', '0.00432'),
(2604, '1399897467', 'DOGE/BTC', '8689.00000000', '0.00000112', 'pierre', 'SELL', 0, '0.25', '0.009731680000000001'),
(2601, '1399897217', 'DOGE/LTC', '100.00000000', '0.00004378', 'pierre', 'SELL', 0, '0.25', '0.004378'),
(2602, '1399897275', 'DOGE/LTC', '10000.00000000', '0.00004400', 'pierre', 'SELL', 0, '0.25', '0.44'),
(2603, '1399897450', 'DOGE/BTC', '10000.00000000', '0.00000110', 'pierre', 'SELL', 0, '0.25', '0.011000000000000001'),
(2619, '1399897827', 'DOGE/LTC', '6780.00000000', '0.00004820', 'pierre', 'SELL', 0, '0.25', '0.326796'),
(2620, '1399897846', 'DOGE/LTC', '1000.00000000', '0.00004410', 'pierre', 'SELL', 0, '0.25', '0.0441'),
(2621, '1399897864', 'DOGE/LTC', '2999.00000000', '0.00004383', 'pierre', 'SELL', 0, '0.25', '0.13144617'),
(2622, '1399897998', 'DOGE/BTC', '1000.00000000', '0.00000114', 'pierre', 'SELL', 0, '0.25', '0.0011400000000000002'),
(2623, '1399898021', 'DOGE/BTC', '15000.00000000', '0.00000108', 'pierre', 'SELL', 0, '0.25', '0.0162'),
(2624, '1399898089', 'LTC/BTC', '0.10000000', '0.02385500', 'pierre', 'SELL', 0, '0.25', '0.0023855000000000005'),
(2625, '1399898109', 'LTC/BTC', '0.10000000', '0.02385000', 'pierre', 'SELL', 0, '0.25', '0.002385');

-- --------------------------------------------------------

--
-- Structure de la table `Trade_History`
--

CREATE TABLE IF NOT EXISTS `Trade_History` (
  `Market` varchar(50) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Price` text NOT NULL,
  `Quantity` text NOT NULL,
  `Timestamp` text NOT NULL,
  `trade_id` int(11) NOT NULL AUTO_INCREMENT,
  `Buyer` varchar(255) NOT NULL,
  `Seller` varchar(255) NOT NULL,
  PRIMARY KEY (`trade_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3653 ;

--
-- Contenu de la table `Trade_History`
--

INSERT INTO `Trade_History` (`Market`, `Type`, `Price`, `Quantity`, `Timestamp`, `trade_id`, `Buyer`, `Seller`) VALUES
('DOGE/LTC', 'SELL', '0.00001332', '16095', '1399650384', 101, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001334', '12380', '1399649844', 102, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001326', '17543', '1399649604', 103, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001333', '15336', '1399649124', 104, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001327', '10471', '1399648824', 105, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001326', '10296', '1399648764', 106, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001332', '19963', '1399648584', 107, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001325', '19291', '1399648344', 108, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001327', '18963', '1399647744', 109, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001331', '19217', '1399647504', 110, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001329', '12082', '1399647024', 111, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001327', '17807', '1399646724', 112, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '16656', '1399646184', 113, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '10982', '1399645944', 114, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001328', '11279', '1399645704', 115, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001329', '15953', '1399645104', 116, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001326', '19247', '1399644624', 117, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001332', '17630', '1399644264', 118, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001333', '16846', '1399643664', 119, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001332', '18443', '1399643544', 120, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001325', '16682', '1399643124', 121, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '18873', '1399642884', 122, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001327', '11535', '1399642584', 123, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001326', '15231', '1399642224', 124, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '16619', '1399641924', 125, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '17151', '1399641684', 126, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001327', '11784', '1399641264', 127, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001330', '15050', '1399641024', 128, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '15994', '1399640904', 129, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001331', '14648', '1399640304', 130, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001330', '11367', '1399639764', 131, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '12121', '1399639164', 132, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001331', '15052', '1399638924', 133, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001333', '10320', '1399638324', 134, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001333', '12946', '1399637904', 135, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001325', '14730', '1399637724', 136, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001333', '16260', '1399637304', 137, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '19116', '1399637244', 138, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001325', '11530', '1399636704', 139, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001328', '10786', '1399636284', 140, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001333', '17452', '1399636164', 141, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001324', '18531', '1399635624', 142, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001326', '16254', '1399635264', 143, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001325', '12788', '1399634724', 144, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001327', '14181', '1399634124', 145, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001332', '10563', '1399633764', 146, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001326', '19680', '1399633404', 147, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '17045', '1399633044', 148, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001327', '16759', '1399632924', 149, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001329', '13349', '1399632624', 150, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001329', '12757', '1399632084', 151, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001332', '13378', '1399632024', 152, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '16684', '1399631904', 153, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001333', '18706', '1399631724', 154, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001332', '11751', '1399631544', 155, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '19892', '1399631424', 156, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001331', '12690', '1399630884', 157, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001326', '12964', '1399630284', 158, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '19669', '1399630164', 159, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001325', '10006', '1399629804', 160, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001325', '10928', '1399629624', 161, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001331', '17613', '1399629324', 162, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '16217', '1399629024', 163, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '16948', '1399628904', 164, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001329', '13051', '1399628724', 165, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001324', '19553', '1399628124', 166, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001327', '19545', '1399627884', 167, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001325', '11416', '1399627824', 168, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001329', '11422', '1399627464', 169, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001324', '12350', '1399626924', 170, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '12396', '1399626564', 171, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '19694', '1399626444', 172, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001330', '12370', '1399626144', 173, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001329', '15422', '1399625664', 174, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001334', '17228', '1399625244', 175, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001332', '11997', '1399624824', 176, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001328', '17933', '1399624464', 177, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001324', '11349', '1399624224', 178, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001332', '19601', '1399624044', 179, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001329', '11997', '1399623564', 180, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001326', '17506', '1399622964', 181, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001329', '11634', '1399622844', 182, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '19123', '1399622784', 183, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001326', '16094', '1399622604', 184, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001329', '18177', '1399622424', 185, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001332', '13912', '1399622304', 186, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001325', '15225', '1399622184', 187, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001331', '17446', '1399621944', 188, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001328', '11222', '1399621464', 189, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001326', '10486', '1399621164', 190, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001328', '16368', '1399620864', 191, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001326', '15177', '1399620624', 192, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001325', '17923', '1399620024', 193, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001324', '16100', '1399619844', 194, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001329', '10012', '1399619544', 195, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001329', '15274', '1399618944', 196, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001332', '16957', '1399618344', 197, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001333', '10736', '1399618044', 198, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001328', '11222', '1399617444', 199, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001333', '13343', '1399617084', 200, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001325', '17556', '1399615493', 201, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001326', '18001', '1399615373', 202, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '16086', '1399615133', 203, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001332', '15549', '1399614593', 204, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001326', '19280', '1399614113', 205, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001331', '10530', '1399613573', 206, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001332', '10224', '1399613333', 207, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001334', '14542', '1399612973', 208, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001328', '18297', '1399612433', 209, 'fake1', 'fake2'),
('DOGE/LTC', 'BUY', '0.00001327', '15721', '1399611893', 210, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '13721', '1399611293', 211, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001333', '15918', '1399611053', 212, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001328', '18600', '1399610573', 213, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '14530', '1399610453', 214, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001330', '10021', '1399609973', 215, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001332', '18169', '1399609373', 216, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001325', '18123', '1399608893', 217, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001327', '13023', '1399608473', 218, 'fake1', 'fake2'),
('DOGE/LTC', 'SELL', '0.00001327', '16815', '1399607873', 219, 'fake1', 'fake2');

-- --------------------------------------------------------

--
-- Structure de la table `UserGroups`
--

CREATE TABLE IF NOT EXISTS `UserGroups` (
  `Group_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Group_Name` varchar(225) NOT NULL,
  `Color` text NOT NULL,
  PRIMARY KEY (`Group_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `User_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(150) NOT NULL,
  `Password` varchar(225) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Country` varchar(250) NOT NULL,
  `LostPasswordRequest` int(1) NOT NULL DEFAULT '0',
  `Last_IP` varchar(50) DEFAULT NULL,
  `SignUpDate` date NOT NULL,
  `LastSignIn` datetime NOT NULL,
  `Actif` int(11) NOT NULL DEFAULT '0',
  `Banned` int(11) DEFAULT NULL,
  `LastTimeSeen` datetime DEFAULT NULL,
  `KeyResetPassword` varchar(100) DEFAULT NULL,
  `KeyActiveAccount` varchar(100) NOT NULL,
  PRIMARY KEY (`User_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=699 ;

--
-- Contenu de la table `Users`
--

INSERT INTO `Users` (`User_ID`, `Username`, `Password`, `Email`, `Country`, `LostPasswordRequest`, `Last_IP`, `SignUpDate`, `LastSignIn`, `Actif`, `Banned`, `LastTimeSeen`, `KeyResetPassword`, `KeyActiveAccount`) VALUES
(679, 'admin', 'd87154517bb10ab6813279f82c0cb4794513be0d', 'adytech2010@gmail.com', 'France', 0, '86.77.145.xxx', '2014-03-03', '2014-05-14 13:35:50', 1, NULL, '2014-08-14 13:35:54', '0', ''),
(691, 'pierre', 'dcf560b3f7e6c4fb46d13ec6d03ed6babde9e24c', 'test@test.com', 'France', 0, '86.77.145.xxx, '2014-04-03', '2014-05-14 12:35:05', 1, NULL, '2014-08-14 12:38:16', '0', ''),

-- --------------------------------------------------------

--
-- Structure de la table `usersactive`
--

CREATE TABLE IF NOT EXISTS `usersactive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_logged_in` int(11) DEFAULT NULL,
  `total_users` int(25) NOT NULL DEFAULT '0',
  `last_update` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `Votes`
--

CREATE TABLE IF NOT EXISTS `Votes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Acronymn` varchar(30) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Total` int(11) NOT NULL,
  `Actif` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `Votes`
--

INSERT INTO `Votes` (`ID`, `Acronymn`, `Name`, `Address`, `Total`, `Actif`) VALUES
(2, 'MZC', 'Mazacoin', '1G6Jc8ipSDcPGCFucVQRb2Xc6yJXhV5UwH', 28, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Votes_History`
--

CREATE TABLE IF NOT EXISTS `Votes_History` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(100) NOT NULL,
  `Coin` varchar(30) NOT NULL,
  `Timestamp` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `Votes_History`
--

INSERT INTO `Votes_History` (`ID`, `Username`, `Coin`, `Timestamp`) VALUES
(2, 'admin', 'MZC', 1399832839),
(3, 'julien', 'MZC', 1399748217),
(4, 'pierre', 'MZC', 1399566049);

-- --------------------------------------------------------

--
-- Structure de la table `Wallets`
--

CREATE TABLE IF NOT EXISTS `Wallets` (
  `Name` text NOT NULL,
  `Acronymn` text NOT NULL,
  `Wallet_IP` text NOT NULL,
  `Wallet_Username` text NOT NULL,
  `Wallet_Password` text NOT NULL,
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Market` tinyint(1) NOT NULL DEFAULT '0',
  `Wallet_Port` int(11) NOT NULL,
  `Fee` double NOT NULL,
  `txFee` double NOT NULL,
  `disabled` int(11) NOT NULL DEFAULT '0',
  `Last_Hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  UNIQUE KEY `Id` (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

--
-- Contenu de la table `Wallets`
--

INSERT INTO `Wallets` (`Name`, `Acronymn`, `Wallet_IP`, `Wallet_Username`, `Wallet_Password`, `Id`, `Market`, `Wallet_Port`, `Fee`, `txFee`, `disabled`, `Last_Hash`) VALUES
('Bitcoin', 'BTC', 'localhost', 'bitcoinrpc', 'nkrt345udsdfjhgjhsdfuyrt78rtTJHRFHTDTYDfzjozfzeof84e84', 163, 1, 8332, 0, 0, 0, '00000000000000008866c8b5755b21d6ed934568f37cdb5077f02e18e25a1f34'),
('Litecoin', 'LTC', 'localhost', 'litecoinrpc', 'BseKLfQMFkyCssisorReGFmZtgWyimBtKHRgLDLzNvPS', 164, 1, 9334, 0, 0, 0, 'd8f02578121ae1888d93955ca48ba5f1661c24e9997bcb63f12920c56119fa59'),
('Dogecoin', 'DOGE', 'localhost', 'dogecoinrpc', 'H92CPU7RfsZxBbrEaDJ51LcezAJ14C8PExJV6HnytyRB', 165, 1, 22555, 0, 0, 0, '7348511aebd4f494c750fd3fd78a32497db6deda80ace7c61acf70feed5ee851'),
('Litebar', 'LTB', 'localhost', 'litebarrpc', 'JbQ4vAmqQTmCGk5V7bQyiX4TkDcpNzEqA5z8Y4Wrdef', 166, 0, 9055, 0, 0, 0, NULL),
('Mazacoin', 'MZC', 'localhost', 'mazacoinrpc', 'F1WFjQ3oJT3AQrRicLZ5aJftxhtPb5ypm3Nfkno7Z8YYjiijfe84ezpaoafkooefj', 167, 0, 12832, 0, 0, 0, '00000000000000b9675c3dd0786ed541b85a18190eade0edc7306a64bb9587f7'),
('Cleanwater', 'WATER', 'localhost', 'cleanwatercoinrpc', 'Su1yWWmSV4HhEyUCLW9dK2goTuL2MLdbcVUgTeEGuhb6wWVvob7GHEBPWD3rF2', 168, 0, 53491, 0, 0, 1, NULL),
('Xxlcoin', 'XXL', 'localhost', 'xxlcoinrpc', '6qQY8i3HRL6TLtSPC7PBWK38ud4UnfDFY89LPPjJgrzh', 169, 0, 50771, 0, 0, 0, NULL),
('Potcoin', 'POT', 'localhost', 'potcoinrpc', 'JDkR3N3H9GgjCJvHMxN4Uq7vYhL1Rg9gJzpb3K1bvC7yKnehfhhozHUHJH58484884ez8f48e4f', 170, 0, 42000, 0, 0, 0, NULL),
('Usde', 'USDE', 'localhost', 'usderpc', '8UaB7gKApsaGJBSGR5YFM6XM7cdCnnKgzFeGp3TKGxQYfjieiofjoifjsdpif854854', 171, 0, 54448, 0, 0, 0, NULL),
('Auroracoin', 'AUR', 'localhost', 'auroracoinrpc', 'Su1yWWmSV4HhEyUCLWP4KrqzdQ35qW8QrYGvbXdCT1FjiijIJijpUHuihohfoze8848z4fze8f4z8ef4', 172, 0, 12341, 0, 0, 1, NULL),
('Nutcoin', 'NUT', 'localhost', 'nutcoinrpc', 'EN7sdaqLXaQSnsS2zCHs4ahFg6FH1JBy5YVUe2JACjBU', 173, 0, 9507, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Withdraw_History`
--

CREATE TABLE IF NOT EXISTS `Withdraw_History` (
  `Timestamp` text NOT NULL,
  `User` varchar(100) NOT NULL,
  `Amount` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Address` text NOT NULL,
  `Coin` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=505 ;

-- --------------------------------------------------------

--
-- Structure de la table `Withdraw_Requests`
--

CREATE TABLE IF NOT EXISTS `Withdraw_Requests` (
  `Amount` text NOT NULL,
  `Address` text NOT NULL,
  `Transaction` varchar(255) NOT NULL,
  `Wallet_Id` int(11) NOT NULL,
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Account` varchar(55) NOT NULL,
  `CoinAcronymn` varchar(55) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=620 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
