-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 04 日 11:46
-- 服务器版本: 5.5.35
-- PHP 版本: 5.3.10-1ubuntu3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `shijia`
--

-- --------------------------------------------------------

--
-- 表的结构 `sj_materials`
--

CREATE TABLE IF NOT EXISTS `sj_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_id` varchar(255),
  `user_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `scope` varchar(1000) DEFAULT NULL,
  `web_url` varchar(500) DEFAULT NULL,
  `nature` int(2) DEFAULT NULL,
  `legal_preson` varchar(255) DEFAULT NULL,
  `total_assets` int(11) DEFAULT NULL,
  `annual_revenue` int(11) DEFAULT NULL,
  `founded` varchar(25) DEFAULT NULL,
  `abroad` tinyint(2) not null default '0',
  `province` int(8) not null default '0',
  `city` int(8) not null default '0',
  `country` varchar(50),
  `head_preson` varchar(255) DEFAULT NULL,
  `staff_count` int(5) DEFAULT NULL,
  `design_count` int(5) DEFAULT NULL,
  `zip_code` int(6),
  `rd_put` int(11) DEFAULT NULL,
  `id_put` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `sex` tinyint(2) NOT NULL DEFAULT '1',
  `cover_id` int(11) DEFAULT NULL,
  `prize_id` int(5) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `mark` varchar(50),
  `fruit` varchar(1000),
  `contact_name` varchar(50),
  `contact_tel` varchar(50),
  `contact_email` varchar(100),
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `introduction` varchar(100) DEFAULT NULL,
  `administration_post` varchar(100),
  `major` varchar(100),
  `tel` varchar(20) DEFAULT NULL,
  `kind` tinyint(2) NOT NULL DEFAULT '1',
  `year` int(5) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(2) NOT NULL DEFAULT '1',
  `view_count` int(11) NOT NULL DEFAULT '0',
  `stick` tinyint(2) NOT NULL DEFAULT '0',
  `chosen_count` int(10) NOT NULL DEFAULT '0',
  `remark` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_materials_on_name` (`name`),
  KEY `index_materials_on_user_id` (`user_id`),
  KEY `index_materials_on_cover_id` (`cover_id`),
  KEY `index_materials_on_prize_id` (`prize_id`),
  KEY `index_materials_on_kind` (`kind`),
  KEY `index_materials_on_year` (`year`),
  KEY `index_materials_on_sort` (`sort`),
  KEY `index_materials_on_province` (`province`),
  KEY `index_materials_on_city` (`city`),
  KEY `index_materials_on_chosen_count` (`chosen_count`),
  KEY `index_materials_on_created_on` (`created_on`),
  KEY `index_materials_on_updated_on` (`updated_on`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
