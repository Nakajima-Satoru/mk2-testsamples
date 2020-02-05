CREATE DATABASE  IF NOT EXISTS `mk2dbsample` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `mk2dbsample`;
-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: mk2dbsample
-- ------------------------------------------------------
-- Server version	5.6.45

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
-- Table structure for table `table1`
--

DROP TABLE IF EXISTS `table1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `table1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `delete_flg` int(2) DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `caption` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table1`
--

LOCK TABLES `table1` WRITE;
/*!40000 ALTER TABLE `table1` DISABLE KEYS */;
INSERT INTO `table1` VALUES (1,'2020-01-15 17:21:57','2020-01-15 17:21:57',0,'タイトルテキスト01','item01','テキストテキストテキスト\r\nテキストテキストテキストテキスト'),(2,'2020-01-15 17:23:28','2020-01-15 17:23:28',0,'タイトルテキスト件名02','item02','テキストテキストテキストテキストテキスト...'),(3,'2020-01-15 17:24:44','2020-01-15 17:24:44',0,'件名テキストテキスト03','item03','テキストサンプルテキストサンプルテキストサンプルテキストサンプル\r\nテキストサンプルテキストサンプルテキストサンプルテキストサンプル\r\nテキストサンプルテキストサンプルテキストサンプルテキストサンプル'),(4,'2020-01-15 17:25:12','2020-01-15 17:25:12',0,'件名テキストテキスト04','item04','内容テキスト内容テキスト内容テキスト\r\n内容テキスト内容テキスト内容テキスト内容テキスト\r\n内容テキスト内容テキスト内容テキスト内容テキスト'),(5,'2020-01-15 17:25:29','2020-01-15 17:25:29',0,'件名タイトル05','item05','内容テキスト内容テキスト内容テキスト内容テキスト内容テキスト内容テキスト'),(6,'2020-01-15 17:25:38','2020-01-15 17:25:43',1,'aa','eee','aaaa'),(7,'2020-01-15 17:26:59','2020-01-15 17:27:05',1,'ee','ddd','aaaaa'),(8,'2020-01-15 17:27:21','2020-01-15 17:27:21',0,'件名テキストテキスト06','item06','aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
/*!40000 ALTER TABLE `table1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `table1a`
--

DROP TABLE IF EXISTS `table1a`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `table1a` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table1_id` int(11) NOT NULL,
  `subname` varchar(255) DEFAULT NULL,
  `memo` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `table1a`
--

LOCK TABLES `table1a` WRITE;
/*!40000 ALTER TABLE `table1a` DISABLE KEYS */;
INSERT INTO `table1a` VALUES (1,2,'sub table1a title name1','Subtitle1 Text Text Text'),(2,2,'sub table1a title name2','Subtitle2 Text Text Text Text Text'),(3,3,'sub table1a title name3','Subtitle3 Text Text Text Text Text'),(4,5,'sub table1a title name4','text text....'),(5,5,'sub table1a title name5','text......');
/*!40000 ALTER TABLE `table1a` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-05 18:14:41
