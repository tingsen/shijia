-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 03 日 16:16
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
-- 表的结构 `sj_systems`
--

CREATE TABLE IF NOT EXISTS `sj_systems` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mark` varchar(100) not null,
  `user_id` int(11),
  `value` varchar(100),
  `content` varchar(1000),
  `kind` tinyint(2) NOT NULL default 1,
  `state` tinyint(2) NOT NULL default 0,
  `created_on` int(11) not null DEFAULT '0',
  `updated_on` int(11) not null DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_systems_on_mark` (`mark`),
  KEY `index_systems_on_kind` (`kind`),
  KEY `index_systems_on_created_on` (`created_on`),
  KEY `index_systems_on_updated_on` (`updated_on`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sj_systems`
--

INSERT INTO `sj_systems` (`id`, `name`, `state`) VALUES
(1, 'sign', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
