-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 11, 2009 at 07:03 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hasanozgan_com`
--

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE IF NOT EXISTS `marks` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `slug` varchar(128) NOT NULL,
  `status` enum('draft','publish','deleted') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL,
  `slug` varchar(256) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `body` text NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` varchar(32) NOT NULL DEFAULT 'HasanOzgan',
  `status` enum('draft','publish','private','deleted') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE IF NOT EXISTS `relations` (
  `post_id` int(16) NOT NULL,
  `taxonomy_id` int(16) NOT NULL,
  PRIMARY KEY (`post_id`,`taxonomy_id`),
  KEY `fk_relations` (`taxonomy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taxonomies`
--

CREATE TABLE IF NOT EXISTS `taxonomies` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `mark_id` int(16) NOT NULL,
  `type` enum('tag','category') NOT NULL,
  `status` enum('draft','publish','deleted') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mark_and_type` (`mark_id`,`type`),
  KEY `mark_id` (`mark_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `relations`
--
ALTER TABLE `relations`
  ADD CONSTRAINT `relations_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `relations_ibfk_2` FOREIGN KEY (`taxonomy_id`) REFERENCES `taxonomies` (`id`);

--
-- Constraints for table `taxonomies`
--
ALTER TABLE `taxonomies`
  ADD CONSTRAINT `taxonomies_ibfk_1` FOREIGN KEY (`mark_id`) REFERENCES `marks` (`id`);
