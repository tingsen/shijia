-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: shijia
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

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
-- Table structure for table `sj_assets`
--

DROP TABLE IF EXISTS `sj_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `source_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(2) NOT NULL DEFAULT '1',
  `sort` int(2) NOT NULL DEFAULT '0',
  `kind` tinyint(2) NOT NULL DEFAULT '1',
  `width` int(5) NOT NULL DEFAULT '0',
  `height` int(5) NOT NULL DEFAULT '0',
  `format_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `relateable_id` int(11) DEFAULT NULL,
  `relateable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_assets_on_name` (`name`),
  KEY `index_assets_on_size` (`size`),
  KEY `index_assets_on_sort` (`sort`),
  KEY `index_assets_on_format_type` (`format_type`),
  KEY `index_assets_on_relateable_id` (`relateable_id`),
  KEY `index_assets_on_relateable_type` (`relateable_type`),
  KEY `index_assets_on_created_on` (`created_on`),
  KEY `index_assets_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_assets`
--

LOCK TABLES `sj_assets` WRITE;
/*!40000 ALTER TABLE `sj_assets` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_assets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_blocks`
--

DROP TABLE IF EXISTS `sj_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `mark` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `kind` int(2) NOT NULL DEFAULT '1',
  `state` int(2) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mark` (`mark`),
  UNIQUE KEY `index_blocks_on_mark` (`mark`),
  KEY `index_blocks_on_name` (`name`),
  KEY `index_blocks_on_created_on` (`created_on`),
  KEY `index_blocks_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_blocks`
--

LOCK TABLES `sj_blocks` WRITE;
/*!40000 ALTER TABLE `sj_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_categories`
--

DROP TABLE IF EXISTS `sj_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `kind` tinyint(2) NOT NULL DEFAULT '1',
  `state` tinyint(2) NOT NULL DEFAULT '1',
  `stick` tinyint(2) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL DEFAULT '0',
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_categories_on_user_id` (`user_id`),
  KEY `index_categories_on_kind` (`kind`),
  KEY `index_categories_on_name` (`name`),
  KEY `index_categories_on_pid` (`pid`),
  KEY `index_categories_on_sort` (`sort`),
  KEY `index_categories_on_created_on` (`created_on`),
  KEY `index_categories_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_categories`
--

LOCK TABLES `sj_categories` WRITE;
/*!40000 ALTER TABLE `sj_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_column_spaces`
--

DROP TABLE IF EXISTS `sj_column_spaces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_column_spaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mark` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `kind` tinyint(2) NOT NULL DEFAULT '1',
  `state` tinyint(2) NOT NULL DEFAULT '1',
  `width` int(5) NOT NULL DEFAULT '0',
  `height` int(5) NOT NULL DEFAULT '0',
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_column_spaces_on_mark` (`mark`),
  KEY `index_column_spaces_on_name` (`name`),
  KEY `index_column_spaces_on_user_id` (`user_id`),
  KEY `index_column_spaces_on_state` (`state`),
  KEY `index_column_on_created_on` (`created_on`),
  KEY `index_column_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_column_spaces`
--

LOCK TABLES `sj_column_spaces` WRITE;
/*!40000 ALTER TABLE `sj_column_spaces` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_column_spaces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_columns`
--

DROP TABLE IF EXISTS `sj_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `column_space_id` int(11) NOT NULL,
  `kind` tinyint(2) NOT NULL DEFAULT '1',
  `state` tinyint(2) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '0',
  `created_on` int(12) NOT NULL DEFAULT '0',
  `updated_on` int(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_columns_on_column_space_id` (`column_space_id`),
  KEY `index_columns_on_title` (`title`),
  KEY `index_columns_on_user_id` (`user_id`),
  KEY `index_columns_on_kind` (`kind`),
  KEY `index_columns_on_created_on` (`created_on`),
  KEY `index_columns_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_columns`
--

LOCK TABLES `sj_columns` WRITE;
/*!40000 ALTER TABLE `sj_columns` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_columns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_emails`
--

DROP TABLE IF EXISTS `sj_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_emails` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(9) NOT NULL,
  `email` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `getpasstime` int(12) NOT NULL,
  `created_on` int(12) NOT NULL DEFAULT '0',
  `updated_on` int(12) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_emails_on_uid` (`uid`),
  KEY `index_emails_on_email` (`email`),
  KEY `index_emails_on_token` (`token`),
  KEY `index_emails_on_created_on` (`created_on`),
  KEY `index_emails_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_emails`
--

LOCK TABLES `sj_emails` WRITE;
/*!40000 ALTER TABLE `sj_emails` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_emails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_materials`
--

DROP TABLE IF EXISTS `sj_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `scope` varchar(255) NOT NULL,
  `web_url` varchar(255) DEFAULT NULL,
  `nature` int(2) DEFAULT NULL,
  `total_assets` int(11) NOT NULL,
  `annual_revenue` int(11) NOT NULL,
  `founded` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `cover_id` int(11) DEFAULT NULL,
  `prize_id` int(5) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `mark` varchar(1000) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `introduction` varchar(100) DEFAULT NULL,
  `tel` varchar(20) DEFAULT NULL,
  `kind` tinyint(2) NOT NULL DEFAULT '1',
  `state` tinyint(2) NOT NULL DEFAULT '0',
  `view_count` int(11) NOT NULL DEFAULT '0',
  `stick` tinyint(2) NOT NULL DEFAULT '0',
  `chosen_count` int(10) NOT NULL DEFAULT '0',
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_materials_on_name` (`name`),
  KEY `index_materials_on_user_id` (`user_id`),
  KEY `index_materials_on_cover_id` (`cover_id`),
  KEY `index_materials_on_prize_id` (`prize_id`),
  KEY `index_materials_on_kind` (`kind`),
  KEY `index_materials_on_chosen_count` (`chosen_count`),
  KEY `index_materials_on_created_on` (`created_on`),
  KEY `index_materials_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_materials`
--

LOCK TABLES `sj_materials` WRITE;
/*!40000 ALTER TABLE `sj_materials` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_posts`
--

DROP TABLE IF EXISTS `sj_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `user_id` int(11) NOT NULL,
  `kind` tinyint(2) NOT NULL DEFAULT '1',
  `category_id` int(11) NOT NULL,
  `state` tinyint(2) NOT NULL DEFAULT '1',
  `publish` tinyint(2) NOT NULL DEFAULT '1',
  `view_count` int(11) NOT NULL DEFAULT '0',
  `stick` tinyint(2) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `cover_id` int(11) DEFAULT NULL,
  `deleted` tinyint(2) NOT NULL DEFAULT '0',
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `index_posts_on_user_id` (`user_id`),
  KEY `index_posts_on_kind` (`kind`),
  KEY `index_posts_on_title` (`title`),
  KEY `index_posts_on_view_count` (`view_count`),
  KEY `index_posts_on_sort` (`sort`),
  KEY `index_posts_on_category_id` (`category_id`),
  KEY `index_posts_on_cover_id` (`cover_id`),
  KEY `index_posts_on_created_on` (`created_on`),
  KEY `index_posts_on_updated_on` (`updated_on`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_posts`
--

LOCK TABLES `sj_posts` WRITE;
/*!40000 ALTER TABLE `sj_posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_rater_material`
--

DROP TABLE IF EXISTS `sj_rater_material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_rater_material` (
  `rid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  KEY `index_rater_material_on_name` (`rid`),
  KEY `index_rater_material_on_user_id` (`mid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_rater_material`
--

LOCK TABLES `sj_rater_material` WRITE;
/*!40000 ALTER TABLE `sj_rater_material` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_rater_material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_raters`
--

DROP TABLE IF EXISTS `sj_raters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_raters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  `url` varchar(250) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `material_ids` varchar(100) DEFAULT NULL,
  `prize_ids` varchar(50) DEFAULT NULL,
  `state` tinyint(2) NOT NULL DEFAULT '1',
  `kind` tinyint(2) NOT NULL DEFAULT '1',
  `sort` int(11) NOT NULL DEFAULT '0',
  `created_on` int(11) NOT NULL DEFAULT '0',
  `updated_on` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `index_raters_on_name` (`name`),
  UNIQUE KEY `index_raters_on_user_id` (`user_id`),
  KEY `index_raters_on_avatar_id` (`avatar_id`),
  KEY `index_raters_on_kind` (`kind`),
  KEY `index_raters_on_created_on` (`created_on`),
  KEY `index_raters_on_updated_on` (`updated_on`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_raters`
--

LOCK TABLES `sj_raters` WRITE;
/*!40000 ALTER TABLE `sj_raters` DISABLE KEYS */;
/*!40000 ALTER TABLE `sj_raters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sj_users`
--

DROP TABLE IF EXISTS `sj_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sj_users` (
  `id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `nickname` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `role_id` tinyint(2) NOT NULL DEFAULT '9',
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
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sj_users`
--

LOCK TABLES `sj_users` WRITE;
/*!40000 ALTER TABLE `sj_users` DISABLE KEYS */;
INSERT INTO `sj_users` VALUES (94,'96e79218965eb72c92a549dd5a330112','tian','tian@sina.com',9,1,1393382898,'127.0.0.1',1393382826,1393382826),(95,'96e79218965eb72c92a549dd5a330112','rater','rater@sina.com',9,1,0,'',1393382849,1393382849),(96,'96e79218965eb72c92a549dd5a330112','edit','edit@sina.com',9,1,0,'',1393382870,1393382870),(97,'96e79218965eb72c92a549dd5a330112','user','user@sina.com',9,1,0,'',1393382888,1393382888);
/*!40000 ALTER TABLE `sj_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-26 10:53:47
