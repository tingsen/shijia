-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014 年 03 月 03 日 15:26
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
-- 表的结构 `sj_users`
--

CREATE TABLE IF NOT EXISTS `sj_users` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `role_id` tinyint(2) NOT NULL DEFAULT '9',
  `activation` tinyint(2) not NULL DEFAULT '1',
  `state` tinyint(2) NOT NULL DEFAULT '1',
  `last_time` int(12) NOT NULL,
  `login_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` int(12) NOT NULL DEFAULT '0',
  `updated_on` int(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname` (`nickname`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `index_users_on_nickname` (`nickname`),
  UNIQUE KEY `index_users_on_email` (`email`),
  KEY `index_users_on_role_id` (`role_id`),
  KEY `index_users_on_created_on` (`created_on`),
  KEY `index_users_on_updated_on` (`updated_on`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
