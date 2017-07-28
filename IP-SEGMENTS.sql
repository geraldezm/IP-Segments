-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: ip_segments
-- ------------------------------------------------------
-- Server version	5.7.14

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
-- Table structure for table `dc`
--

DROP TABLE IF EXISTS `dc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dc` (
  `dcseg_id` int(11) NOT NULL AUTO_INCREMENT,
  `dc` varchar(45) NOT NULL,
  `ip_range` varchar(45) NOT NULL,
  PRIMARY KEY (`dcseg_id`),
  UNIQUE KEY `dcseg_id_UNIQUE` (`dcseg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=latin1 COMMENT='Data Center';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dc`
--

LOCK TABLES `dc` WRITE;
/*!40000 ALTER TABLE `dc` DISABLE KEYS */;
INSERT INTO `dc` VALUES (101,'SJC1','10.42.0~19.x/24'),(102,'FRA1','10.23.0~19.x/24'),(103,'MUC1','10.36.9~19.x/24'),(104,'IAD1','10.40.0~19.x/24'),(110,'UDC2 CT','10.48.32.x/22');
/*!40000 ALTER TABLE `dc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastic_cloud`
--

DROP TABLE IF EXISTS `elastic_cloud`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastic_cloud` (
  `ecseg_id` int(11) NOT NULL AUTO_INCREMENT,
  `ec_dc` varchar(45) NOT NULL,
  `ecpub_ip` varchar(15) NOT NULL,
  `ecpri_ip` varchar(15) NOT NULL,
  PRIMARY KEY (`ecseg_id`),
  UNIQUE KEY `ecseg_id_UNIQUE` (`ecseg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='elastic cloud dc';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastic_cloud`
--

LOCK TABLES `elastic_cloud` WRITE;
/*!40000 ALTER TABLE `elastic_cloud` DISABLE KEYS */;
INSERT INTO `elastic_cloud` VALUES (1,'SJC1','150.70.176-191','10.42/16'),(2,'SJC1','150.70.176-191','10.43/16'),(4,'MUC1','150.70.224-239','10.36/16'),(5,'IAD1','150.70.160-175','10.50/16'),(6,'FRA1','150.70.240.0/20','10.23.0.0/16');
/*!40000 ALTER TABLE `elastic_cloud` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `global_ip`
--

DROP TABLE IF EXISTS `global_ip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `global_ip` (
  `globalseg_id` int(11) NOT NULL AUTO_INCREMENT,
  `regional` varchar(45) NOT NULL,
  `site` varchar(45) NOT NULL,
  `users` varchar(45) NOT NULL,
  `device_ip` varchar(45) NOT NULL,
  `network` varchar(45) NOT NULL,
  PRIMARY KEY (`globalseg_id`),
  UNIQUE KEY `globalseg_id_UNIQUE` (`globalseg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='Global IP List';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `global_ip`
--

LOCK TABLES `global_ip` WRITE;
/*!40000 ALTER TABLE `global_ip` DISABLE KEYS */;
INSERT INTO `global_ip` VALUES (1,'APAC','ADC','EBB','10.0.28.254/32','10.0.28.0/24'),(2,'APAC','ADC','EBB','10.0.28.254/32','10.0.29.0/24'),(3,'APAC','ADC','EBB','10.0.28.254/32','10.240.0.0/20'),(4,'APAC','ADC','EBB','10.0.28.254/32','192.168.201.0/24');
/*!40000 ALTER TABLE `global_ip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opencloud_az`
--

DROP TABLE IF EXISTS `opencloud_az`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opencloud_az` (
  `ocazseg_id` int(11) NOT NULL AUTO_INCREMENT,
  `oc_az` varchar(45) NOT NULL,
  `ocazpub_ip` varchar(45) NOT NULL,
  `ocazpri_ip` varchar(45) NOT NULL,
  PRIMARY KEY (`ocazseg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Opencloud Availability Zone';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opencloud_az`
--

LOCK TABLES `opencloud_az` WRITE;
/*!40000 ALTER TABLE `opencloud_az` DISABLE KEYS */;
INSERT INTO `opencloud_az` VALUES (2,'IAD1','150.70.202-206.x','(need to check)');
/*!40000 ALTER TABLE `opencloud_az` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sdi_sp`
--

DROP TABLE IF EXISTS `sdi_sp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sdi_sp` (
  `sdispseg_id` int(11) NOT NULL AUTO_INCREMENT,
  `sdi_sp` varchar(45) NOT NULL,
  `sdisppub_ip` varchar(45) DEFAULT NULL,
  `sdisppri_ip` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`sdispseg_id`),
  UNIQUE KEY `sdispseg_id_UNIQUE` (`sdispseg_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1 COMMENT='SDI DC/ Service Pod';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sdi_sp`
--

LOCK TABLES `sdi_sp` WRITE;
/*!40000 ALTER TABLE `sdi_sp` DISABLE KEYS */;
INSERT INTO `sdi_sp` VALUES (1,'SJDC/NBU','150.70.68-71.x','10.31.8-15.x'),(2,'SJDC/NBU','150.70.68-71.x','10.31.27-29.x'),(3,'SJDC/NBU','','10.31.80.0/24'),(4,'SJDC/BA','150.70.72-75.x','10.31.30-39.x'),(5,'SJDC/BA','150.70.95.x','10.31.43.x'),(6,'SJDC/CT','150.70.64-67.x','10.31.0-7.x'),(7,'SJDC/CT','150.70.85.x','10.31.24-26.x'),(8,'SJDC/CT2','150.70.72-75.x','10.31.40-42.x'),(9,'SJDC/CT2','150.70.72-75.x','10.31.16-23.x'),(10,'SJDC/SS','150.70.79.x','10.31.7.x'),(11,'SJDC/SS','150.70.79.x','10.31.15.x'),(12,'SJDC/SS','150.70.79.x','10.31.23.x'),(13,'SJDC/SS','150.70.79.x','10.31.38-39.x'),(14,'SJDC/SS','150.70.79.x','10.31.43.x'),(15,'SDJC/FF','150.99.22.x','10.45.21.x');
/*!40000 ALTER TABLE `sdi_sp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-28 13:59:48
