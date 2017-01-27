-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: application-starter
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_sessions`
--

DROP TABLE IF EXISTS `auth_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_sessions` (
  `id` varchar(40) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `login_time` datetime DEFAULT NULL,
  `modified_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `denied_access`
--

DROP TABLE IF EXISTS `denied_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `denied_access` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  `reason_code` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `groupID` int(11) NOT NULL AUTO_INCREMENT,
  `groupName` varchar(45) NOT NULL,
  `groupDescription` varchar(45) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  PRIMARY KEY (`groupID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ips_on_hold`
--

DROP TABLE IF EXISTS `ips_on_hold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ips_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `login_errors`
--

DROP TABLE IF EXISTS `login_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_errors` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `moduleID` int(11) NOT NULL AUTO_INCREMENT,
  `moduleName` varchar(45) NOT NULL,
  `moduleDescription` varchar(100) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  PRIMARY KEY (`moduleID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `passwordStatuses`
--

DROP TABLE IF EXISTS `passwordStatuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passwordStatuses` (
  `passwordStatusID` int(11) NOT NULL AUTO_INCREMENT,
  `passwordStatusName` varchar(45) NOT NULL,
  `passwordStatusDescription` varchar(45) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  PRIMARY KEY (`passwordStatusID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `permissionID` int(11) NOT NULL AUTO_INCREMENT,
  `groupID` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  PRIMARY KEY (`permissionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `userGroups`
--

DROP TABLE IF EXISTS `userGroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userGroups` (
  `userGroupID` int(11) NOT NULL AUTO_INCREMENT,
  `groupID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  `createdBy` int(11) NOT NULL,
  PRIMARY KEY (`userGroupID`),
  KEY `fk_userGroups_1_idx` (`userID`),
  KEY `fk_userGroups_2_idx` (`groupID`),
  CONSTRAINT `fk_userGroups_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_userGroups_2` FOREIGN KEY (`groupID`) REFERENCES `groups` (`groupID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `username_or_email_on_hold`
--

DROP TABLE IF EXISTS `username_or_email_on_hold`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `username_or_email_on_hold` (
  `ai` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username_or_email` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`ai`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(45) NOT NULL,
  `emailAddress` varchar(45) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `passwordStatus` int(11) NOT NULL,
  `userGroupID` int(11) NOT NULL,
  `dateLastActive` datetime DEFAULT NULL,
  `datePasswordLastChanged` datetime DEFAULT NULL,
  `createdBy` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userName_UNIQUE` (`userName`),
  UNIQUE KEY `emailAddress_UNIQUE` (`emailAddress`),
  KEY `fk_users_1_idx` (`userGroupID`),
  KEY `fk_users_2_idx` (`passwordStatus`),
  CONSTRAINT `fk_users_1` FOREIGN KEY (`userGroupID`) REFERENCES `userGroups` (`userGroupID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_2` FOREIGN KEY (`passwordStatus`) REFERENCES `passwordStatuses` (`passwordStatusID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-27 21:25:16
