-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 02 月 25 日 11:36
-- 服务器版本: 5.5.35
-- PHP 版本: 5.3.10-1ubuntu3.9

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
-- 表的结构 `sj_emails`
--

CREATE TABLE IF NOT EXISTS `sj_emails` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(9) NOT NULL,
  `email` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` tinyint(2) not null default '1',
  `getpasstime` int(12) NOT NULL,
  `created_on` int(12) NOT NULL default '0',
  `updated_on` int(12) NOT NULL default '0',
  PRIMARY KEY (`id`),
  KEY `index_emails_on_uid` (`uid`),
  KEY `index_emails_on_email` (`email`),
  KEY `index_emails_on_token` (`token`),
  KEY `index_emails_on_created_on` (`created_on`),
  KEY `index_emails_on_updated_on` (`updated_on`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
