-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 19, 2011 at 02:01 AM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `default`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `uid` char(20) NOT NULL,
  `tid` int(11) NOT NULL,
  PRIMARY KEY (`uid`,`tid`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` VALUES('userA', 1);
INSERT INTO `favorites` VALUES('userA', 5);
INSERT INTO `favorites` VALUES('userA', 15);
INSERT INTO `favorites` VALUES('userA', 16);

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `follower` char(20) NOT NULL,
  `approved` tinyint(4) NOT NULL DEFAULT '0',
  `followee` char(20) NOT NULL,
  PRIMARY KEY (`follower`,`followee`),
  KEY `followee` (`followee`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follows`
--


-- --------------------------------------------------------

--
-- Table structure for table `followslist`
--

CREATE TABLE `followslist` (
  `LID` int(11) NOT NULL,
  `userID` char(20) NOT NULL,
  PRIMARY KEY (`LID`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followslist`
--


-- --------------------------------------------------------

--
-- Table structure for table `hashes`
--

CREATE TABLE `hashes` (
  `word` char(50) NOT NULL,
  `TID` int(11) NOT NULL,
  PRIMARY KEY (`word`,`TID`),
  KEY `TID` (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hashes`
--


-- --------------------------------------------------------

--
-- Table structure for table `hashtags`
--

CREATE TABLE `hashtags` (
  `word` char(50) NOT NULL,
  PRIMARY KEY (`word`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hashtags`
--


-- --------------------------------------------------------

--
-- Table structure for table `lists`
--

CREATE TABLE `lists` (
  `ID` int(11) NOT NULL,
  `private` char(50) DEFAULT NULL,
  `creator` char(20) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `creator` (`creator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lists`
--


-- --------------------------------------------------------

--
-- Table structure for table `mentions`
--

CREATE TABLE `mentions` (
  `TID` int(11) NOT NULL DEFAULT '0',
  `userID` char(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`TID`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mentions`
--


-- --------------------------------------------------------

--
-- Table structure for table `messaged`
--

CREATE TABLE `messaged` (
  `MID` int(11) NOT NULL,
  `userID` char(20) NOT NULL,
  PRIMARY KEY (`MID`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messaged`
--


-- --------------------------------------------------------

--
-- Table structure for table `tweeted`
--

CREATE TABLE `tweeted` (
  `TID` int(11) NOT NULL,
  `userID` char(20) NOT NULL,
  PRIMARY KEY (`TID`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tweeted`
--

INSERT INTO `tweeted` VALUES(1, 'userA');
INSERT INTO `tweeted` VALUES(4, 'userA');
INSERT INTO `tweeted` VALUES(11, 'UserA');
INSERT INTO `tweeted` VALUES(13, 'userA');
INSERT INTO `tweeted` VALUES(14, 'userA');
INSERT INTO `tweeted` VALUES(15, 'userA');
INSERT INTO `tweeted` VALUES(16, 'userA');
INSERT INTO `tweeted` VALUES(17, 'userA');
INSERT INTO `tweeted` VALUES(18, 'userA');
INSERT INTO `tweeted` VALUES(19, 'userA');
INSERT INTO `tweeted` VALUES(2, 'userB');
INSERT INTO `tweeted` VALUES(5, 'userB');

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `favorited` tinyint(1) NOT NULL DEFAULT '0',
  `message` char(140) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` VALUES(1, 0, 0, 'hi there!');
INSERT INTO `tweets` VALUES(2, 0, 1, 'Sup d00d?');
INSERT INTO `tweets` VALUES(4, 0, 0, 'hello!');
INSERT INTO `tweets` VALUES(5, 1, 0, 'hey man');
INSERT INTO `tweets` VALUES(6, 0, 0, 'whats up?dds');
INSERT INTO `tweets` VALUES(7, 0, 0, 'hwdwd');
INSERT INTO `tweets` VALUES(8, 0, 0, 'hdwcs');
INSERT INTO `tweets` VALUES(9, 0, 0, 'hello world\r\n!');
INSERT INTO `tweets` VALUES(11, 0, 0, 'Hello WORLDSzzz!');
INSERT INTO `tweets` VALUES(12, 0, 0, 'NewONE!');
INSERT INTO `tweets` VALUES(13, 0, 0, 'wsadsadpppppppp');
INSERT INTO `tweets` VALUES(14, 0, 0, 'all');
INSERT INTO `tweets` VALUES(15, 0, 1, 'hows it goin?');
INSERT INTO `tweets` VALUES(16, 0, 0, 'my tweet?\r\n');
INSERT INTO `tweets` VALUES(17, 0, 0, 'new tewaets?\r\n');
INSERT INTO `tweets` VALUES(18, 0, 0, 'posting da tweats\r\nstuff');
INSERT INTO `tweets` VALUES(19, 0, 0, 'hello!');
INSERT INTO `tweets` VALUES(20, 0, 0, 'hello?');
INSERT INTO `tweets` VALUES(21, 0, 0, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` char(20) NOT NULL,
  `password` char(50) DEFAULT NULL,
  `first_name` char(50) DEFAULT NULL,
  `last_name` char(50) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `private` tinyint(1) DEFAULT '0',
  `lang` char(50) DEFAULT NULL,
  `bio` char(50) DEFAULT NULL,
  `location` char(50) DEFAULT NULL,
  `URL` char(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES('userA', 'password', 'john', 'doe', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `users` VALUES('userB', 'password', 'jake', 'jakerson', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `tweets` (`ID`);

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`followee`) REFERENCES `users` (`ID`);

--
-- Constraints for table `followslist`
--
ALTER TABLE `followslist`
  ADD CONSTRAINT `followslist_ibfk_1` FOREIGN KEY (`LID`) REFERENCES `lists` (`ID`),
  ADD CONSTRAINT `followslist_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `hashes`
--
ALTER TABLE `hashes`
  ADD CONSTRAINT `hashes_ibfk_1` FOREIGN KEY (`word`) REFERENCES `hashtags` (`word`),
  ADD CONSTRAINT `hashes_ibfk_2` FOREIGN KEY (`TID`) REFERENCES `tweets` (`ID`);

--
-- Constraints for table `lists`
--
ALTER TABLE `lists`
  ADD CONSTRAINT `lists_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `users` (`ID`);

--
-- Constraints for table `mentions`
--
ALTER TABLE `mentions`
  ADD CONSTRAINT `mentions_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `tweets` (`ID`),
  ADD CONSTRAINT `mentions_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `messaged`
--
ALTER TABLE `messaged`
  ADD CONSTRAINT `messaged_ibfk_1` FOREIGN KEY (`MID`) REFERENCES `tweets` (`ID`),
  ADD CONSTRAINT `messaged_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `tweeted`
--
ALTER TABLE `tweeted`
  ADD CONSTRAINT `tweeted_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `tweets` (`ID`),
  ADD CONSTRAINT `tweeted_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);
