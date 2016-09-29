-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: mysql50-102.wc2:3306
-- Generation Time: Jun 10, 2012 at 03:10 AM
-- Server version: 5.0.77
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `448988_kottu7`
--

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE IF NOT EXISTS `blogs` (
  `bid` int(11) NOT NULL auto_increment,
  `blogName` varchar(64) NOT NULL,
  `blogURL` varchar(64) NOT NULL,
  `blogRSS` varchar(128) NOT NULL,
  `access_ts` int(11) NOT NULL default '0',
  `active` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`bid`),
  UNIQUE KEY `blogURL` (`blogURL`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10000;

-- --------------------------------------------------------

--
-- Table structure for table `clicks`
--

CREATE TABLE IF NOT EXISTS `clicks` (
  `pid` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `hourstamp` int(11) NOT NULL,
  PRIMARY KEY  (`pid`,`ip`,`hourstamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `postID` int(11) NOT NULL auto_increment,
  `blogID` int(11) NOT NULL,
  `link` varchar(320) NOT NULL,
  `title` varchar(192) NOT NULL,
  `postContent` varchar(512) default NULL,
  `thumbnail` varchar(128) default NULL,
  `tags` varchar(32) default NULL,
  `language` set('en','si','ta','dv') NOT NULL default 'en',
  `serverTimestamp` int(11) NOT NULL default '0',
  `tweetCount` int(11) NOT NULL default '0',
  `fbCount` int(11) NOT NULL default '0',
  `api_ts` int(11) NOT NULL default '0',
  `postBuzz` float NOT NULL default '0',
  PRIMARY KEY  (`postID`),
  UNIQUE KEY `link` (`link`),
  KEY `blogID` (`blogID`),
  KEY `serverTimestamp` (`serverTimestamp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100000;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE IF NOT EXISTS `terms` (
  `tid` int(11) NOT NULL auto_increment,
  `term` varchar(31) NOT NULL,
  `term_freq` int(11) NOT NULL default '0',
  `doc_freq` int (11) NOT NULL default '0',
  `inv_doc_freq` float NOT NULL default '0',
  PRIMARY KEY  (`tid`),
  UNIQUE KEY `term` (`term`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post_terms`
--

CREATE TABLE IF NOT EXISTS `post_terms` (
  `pid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `frequency` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pid`, `tid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` varchar(64) NOT NULL,
  `hash` varchar(64) NOT NULL,
  PRIMARY KEY  (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Insert default user into `users`
--

INSERT INTO `kottu`.`users` (`userid` ,`hash`)
VALUES ('indi', SHA1( 'indi' ));

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE IF NOT EXISTS `logins` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(64) default NULL,
  `ipaddr` varchar(32) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `useragent` varchar(196) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



--
-- Constraints for dumped tables
--

--
-- Constraints for table `clicks`
--
ALTER TABLE `clicks`
  ADD CONSTRAINT `clicks_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `posts` (`postID`) ON DELETE CASCADE;
  
--
-- Constraints for table `post_terms`
--
ALTER TABLE `post_terms`
  ADD CONSTRAINT `post_terms_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `posts` (`postID`) ON DELETE CASCADE;
  
ALTER TABLE `post_terms`
  ADD CONSTRAINT `post_terms_ibfk_2` FOREIGN KEY (`tid`) REFERENCES `terms` (`tid`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`blogID`) REFERENCES `blogs` (`bid`) ON DELETE CASCADE ON UPDATE CASCADE;
  
--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`user`) REFERENCES `users` (`userid`) ON DELETE SET NULL ON UPDATE SET NULL;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
