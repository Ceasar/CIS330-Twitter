-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2011 at 04:37 AM
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
INSERT INTO `favorites` VALUES('userA', 4);
INSERT INTO `favorites` VALUES('userA', 5);
INSERT INTO `favorites` VALUES('userA', 14);
INSERT INTO `favorites` VALUES('userA', 15);
INSERT INTO `favorites` VALUES('userA', 16);
INSERT INTO `favorites` VALUES('userA', 37);
INSERT INTO `favorites` VALUES('userA', 39);
INSERT INTO `favorites` VALUES('userA', 40);
INSERT INTO `favorites` VALUES('userA', 43);
INSERT INTO `favorites` VALUES('heflin', 44);
INSERT INTO `favorites` VALUES('asant', 45);
INSERT INTO `favorites` VALUES('feigenberg', 45);
INSERT INTO `favorites` VALUES('GunzUpSwagOut', 47);
INSERT INTO `favorites` VALUES('asant', 48);

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `follower` char(20) NOT NULL,
  `followee` char(20) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`follower`,`followee`),
  KEY `followee` (`followee`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` VALUES('asant', 'asant', 0);
INSERT INTO `follows` VALUES('asant', 'heflin', 0);
INSERT INTO `follows` VALUES('asdf', 'userA', 0);
INSERT INTO `follows` VALUES('heflin', 'asant', 0);
INSERT INTO `follows` VALUES('userA', 'userB', 0);

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
  `senderID` char(20) NOT NULL,
  `receiverID` char(20) NOT NULL,
  PRIMARY KEY (`MID`),
  KEY `senderID` (`senderID`),
  KEY `receiverID` (`receiverID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messaged`
--

INSERT INTO `messaged` VALUES(20, 'userA', 'userA');
INSERT INTO `messaged` VALUES(21, 'userA', 'userA');
INSERT INTO `messaged` VALUES(22, 'userA', 'userA');
INSERT INTO `messaged` VALUES(23, 'userA', 'userA');
INSERT INTO `messaged` VALUES(24, 'userA', 'userA');
INSERT INTO `messaged` VALUES(25, 'asant', 'heflin');
INSERT INTO `messaged` VALUES(26, 'asant', 'asant');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `message` char(140) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` VALUES(20, 'hjkpl[;', '2011-03-19 03:48:21');
INSERT INTO `messages` VALUES(21, 'ghjaksdfa', '2011-03-19 03:54:21');
INSERT INTO `messages` VALUES(22, 'new message', '2011-03-19 03:55:02');
INSERT INTO `messages` VALUES(23, 'hellyesd', '2011-03-19 03:55:22');
INSERT INTO `messages` VALUES(24, 'jhkl', '2011-04-19 04:50:25');
INSERT INTO `messages` VALUES(25, 'Precisely ONE communication.', '2011-06-19 06:22:11');
INSERT INTO `messages` VALUES(26, 'helo', '2011-08-19 08:19:09');

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

INSERT INTO `tweeted` VALUES(44, 'asant');
INSERT INTO `tweeted` VALUES(49, 'asant');
INSERT INTO `tweeted` VALUES(50, 'asant');
INSERT INTO `tweeted` VALUES(46, 'feigenberg');
INSERT INTO `tweeted` VALUES(48, 'GunzUpSwagOut');
INSERT INTO `tweeted` VALUES(45, 'heflin');
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
INSERT INTO `tweeted` VALUES(20, 'userA');
INSERT INTO `tweeted` VALUES(21, 'userA');
INSERT INTO `tweeted` VALUES(22, 'userA');
INSERT INTO `tweeted` VALUES(23, 'userA');
INSERT INTO `tweeted` VALUES(24, 'userA');
INSERT INTO `tweeted` VALUES(25, 'userA');
INSERT INTO `tweeted` VALUES(26, 'userA');
INSERT INTO `tweeted` VALUES(27, 'userA');
INSERT INTO `tweeted` VALUES(28, 'userA');
INSERT INTO `tweeted` VALUES(29, 'userA');
INSERT INTO `tweeted` VALUES(30, 'userA');
INSERT INTO `tweeted` VALUES(31, 'userA');
INSERT INTO `tweeted` VALUES(32, 'userA');
INSERT INTO `tweeted` VALUES(33, 'userA');
INSERT INTO `tweeted` VALUES(34, 'userA');
INSERT INTO `tweeted` VALUES(35, 'userA');
INSERT INTO `tweeted` VALUES(36, 'userA');
INSERT INTO `tweeted` VALUES(37, 'userA');
INSERT INTO `tweeted` VALUES(38, 'userA');
INSERT INTO `tweeted` VALUES(39, 'userA');
INSERT INTO `tweeted` VALUES(40, 'userA');
INSERT INTO `tweeted` VALUES(41, 'userA');
INSERT INTO `tweeted` VALUES(42, 'userA');
INSERT INTO `tweeted` VALUES(43, 'userA');
INSERT INTO `tweeted` VALUES(2, 'userB');
INSERT INTO `tweeted` VALUES(5, 'userB');
INSERT INTO `tweeted` VALUES(47, 'wellecks');

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `favorited` tinyint(1) NOT NULL DEFAULT '0',
  `message` char(140) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

--
-- Dumping data for table `tweets`
--

INSERT INTO `tweets` VALUES(1, 0, 0, 'hi there!', NULL);
INSERT INTO `tweets` VALUES(2, 0, 0, 'Sup d00d?', NULL);
INSERT INTO `tweets` VALUES(4, 0, 0, 'hello!', NULL);
INSERT INTO `tweets` VALUES(5, 1, 0, 'hey man', NULL);
INSERT INTO `tweets` VALUES(6, 0, 0, 'whats up?dds', NULL);
INSERT INTO `tweets` VALUES(7, 0, 0, 'hwdwd', NULL);
INSERT INTO `tweets` VALUES(8, 0, 0, 'hdwcs', NULL);
INSERT INTO `tweets` VALUES(9, 0, 0, 'hello world\r\n!', NULL);
INSERT INTO `tweets` VALUES(11, 0, 0, 'Hello WORLDSzzz!', NULL);
INSERT INTO `tweets` VALUES(12, 0, 0, 'NewONE!', NULL);
INSERT INTO `tweets` VALUES(13, 0, 0, 'wsadsadpppppppp', NULL);
INSERT INTO `tweets` VALUES(14, 0, 0, 'all', NULL);
INSERT INTO `tweets` VALUES(15, 0, 0, 'hows it goin?', NULL);
INSERT INTO `tweets` VALUES(16, 0, 0, 'my tweet?\r\n', NULL);
INSERT INTO `tweets` VALUES(17, 0, 0, 'new tewaets?\r\n', NULL);
INSERT INTO `tweets` VALUES(18, 0, 0, 'posting da tweats\r\nstuff', NULL);
INSERT INTO `tweets` VALUES(19, 0, 0, 'hello!', NULL);
INSERT INTO `tweets` VALUES(20, 0, 0, 'hell word', '2011-03-19 03:47:05');
INSERT INTO `tweets` VALUES(21, 0, 0, 'ghjk', '2011-03-19 03:47:13');
INSERT INTO `tweets` VALUES(22, 0, 0, 'jasdkjfkjsa', '2011-03-19 03:47:18');
INSERT INTO `tweets` VALUES(23, 0, 0, 'asdflk @userA', '2011-03-19 03:47:25');
INSERT INTO `tweets` VALUES(24, 0, 0, 'bhjksdf', '2011-03-19 03:47:38');
INSERT INTO `tweets` VALUES(25, 0, 0, '', '2011-03-19 03:48:27');
INSERT INTO `tweets` VALUES(26, 0, 0, '', '2011-03-19 03:48:30');
INSERT INTO `tweets` VALUES(27, 0, 0, '', '2011-03-19 03:48:31');
INSERT INTO `tweets` VALUES(28, 0, 0, '', '2011-03-19 03:48:33');
INSERT INTO `tweets` VALUES(29, 0, 0, '', '2011-03-19 03:49:23');
INSERT INTO `tweets` VALUES(30, 0, 0, 'retweet:userBhey man', '2011-03-19 03:49:54');
INSERT INTO `tweets` VALUES(31, 0, 0, 'retweet:userAhi there!', '2011-03-19 03:50:05');
INSERT INTO `tweets` VALUES(32, 0, 0, 'retweet:userBhey man', '2011-03-19 03:50:11');
INSERT INTO `tweets` VALUES(33, 0, 0, 'ReTweet: userB hey man', '2011-03-19 03:50:55');
INSERT INTO `tweets` VALUES(34, 0, 0, 'ReTweet: userA new tewaets?\r\n', '2011-03-19 03:51:39');
INSERT INTO `tweets` VALUES(35, 0, 0, 'hjk', '2011-03-19 03:51:50');
INSERT INTO `tweets` VALUES(36, 0, 0, 'hjk', '2011-03-19 03:51:59');
INSERT INTO `tweets` VALUES(37, 0, 0, 'ghjk', '2011-03-19 03:52:14');
INSERT INTO `tweets` VALUES(38, 0, 0, 'ghjk', '2011-03-19 03:52:23');
INSERT INTO `tweets` VALUES(39, 0, 0, 'ghjk', '2011-03-19 03:52:28');
INSERT INTO `tweets` VALUES(40, 0, 0, 'ghjk', '2011-03-19 03:52:30');
INSERT INTO `tweets` VALUES(41, 0, 0, 'fghjk', '2011-03-19 03:56:00');
INSERT INTO `tweets` VALUES(42, 0, 0, 'ReTweet: userA new tewaets?\r\n', '2011-04-19 04:49:57');
INSERT INTO `tweets` VALUES(43, 0, 0, 'yghjbknlm;,', '2011-04-19 04:50:02');
INSERT INTO `tweets` VALUES(44, 0, 0, 'I love Math! Also, I tend to like ugly girls.', '2011-06-19 06:18:37');
INSERT INTO `tweets` VALUES(45, 0, 0, '@asant, can\\''t you wait for NYC 2011??', '2011-06-19 06:21:02');
INSERT INTO `tweets` VALUES(46, 0, 0, 'ReTweet: heflin @asant, can\\''t you wait for NYC 2011??', '2011-06-19 06:24:26');
INSERT INTO `tweets` VALUES(47, 0, 0, '@GunzUpSwagOut -- biumvirate UNITE', '2011-07-19 07:28:10');
INSERT INTO `tweets` VALUES(48, 0, 0, '@wellecks -- biumvirate.', '2011-07-19 07:29:23');
INSERT INTO `tweets` VALUES(49, 0, 0, 'ReTweet: GunzUpSwagOut @wellecks -- biumvirate.', '2011-08-19 08:18:22');
INSERT INTO `tweets` VALUES(50, 0, 0, 'I love briann', '2011-08-19 08:18:27');

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

INSERT INTO `users` VALUES('asant', 'math', 'Austin', 'Santillo', 'asant@sas.upenn.edu', 0, 'English', 'I Love Math!!!!!!!!', 'New Jersey', 'http://www.math.upenn.edu', '2011-04-13');
INSERT INTO `users` VALUES('asdf', 'asdf', 'asdf', 'asdf', 'asdf', 0, 'asdf', 'asdf', 'asdf', 'asdf', '2011-04-18');
INSERT INTO `users` VALUES('asdffasdf', 'adsfa', 'dsf', '', '', 0, '', '', '', '', '0000-00-00');
INSERT INTO `users` VALUES('dahn_santillo', 'asdf', 'Dahn', 'Santillo', 'net@net.com', 0, 'English', 'Austin''s Long Lost Uncle', 'Alaska', 'http://aust.in', '2011-04-15');
INSERT INTO `users` VALUES('feigenberg', 'bobby', 'bobby', 'feigenberg', 'bobby@wall.street.edu', 0, 'Jewish', 'I work on Wall Street. @asant envies my intelligen', 'New Jersey', 'www.wsj.com', '2011-04-17');
INSERT INTO `users` VALUES('GunzUpSwagOut', 'asdf', 'Mike Ryan', 'Cunningham', 'mike@penn.gov', 0, 'Spanish', 'Biumvirate for life.', 'Wallingford', 'http://twitter.com/TheWallingford', '2011-04-14');
INSERT INTO `users` VALUES('heflin', 'heflin', 'Evan', 'Heflin', 'evan@evan.com', 0, 'English', 'I''m awesome.', 'Virginia', 'http://www.winning.com', '2011-04-13');
INSERT INTO `users` VALUES('userA', 'password', 'john', 'doe', '', 0, '', '', '', '', '0000-00-00');
INSERT INTO `users` VALUES('userB', 'password', 'jake', 'jakerson', NULL, NULL, NULL, NULL, 'texas', NULL, NULL);
INSERT INTO `users` VALUES('wellecks', 'asdf', 'Sean', 'Welleck', 'wellecks@gmail.com', 0, 'English', 'We. created. this.', 'Texas', 'http://twitter.com/wellecks', '2011-04-18');
INSERT INTO `users` VALUES('userC', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Texas', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('user87h', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Texas', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('userd', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Texas', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('usety57', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Texas', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('userf', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Texas', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('userg', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Michigan', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('xerxes', 'pass', 'Bob', 'Welleck', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Michigan', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('usere', 'pass', 'Joseph', 'Juice', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Texas', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('userasdf', 'pass', 'Joseph', 'yetti', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Texas', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('user3r', 'pass', 'Joseph', 'uyasdfn', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('userasd', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('user4', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('user76', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('userkg', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('theMan', 'pass', 'Joseph', 'Welleck', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Michigan', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('gerf', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('afer', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('34refd', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('asdf47', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('yethhfd43', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('huunmy5', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('JHUneda', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('yyruie', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Alaska', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('telltodp', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'TeAlaskaxas', 'http://www.google.com', '2011-04-13');
INSERT INTO `users` VALUES('errews', 'pass', 'Joseph', 'Doe', 'user@sas.upenn.edu', 0, 'English', 'I am awesome!!!!!!!!', 'Texas', 'http://www.google.com', '2011-04-13');





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
  ADD CONSTRAINT `messaged_ibfk_1` FOREIGN KEY (`MID`) REFERENCES `messages` (`ID`),
  ADD CONSTRAINT `messaged_ibfk_2` FOREIGN KEY (`senderID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `messaged_ibfk_3` FOREIGN KEY (`receiverID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `tweeted`
--
ALTER TABLE `tweeted`
  ADD CONSTRAINT `tweeted_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `tweets` (`ID`),
  ADD CONSTRAINT `tweeted_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`);
