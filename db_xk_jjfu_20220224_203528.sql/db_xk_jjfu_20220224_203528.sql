-- MySQL dump 10.13  Distrib 5.6.49, for Linux (x86_64)
--
-- Host: localhost    Database: xk_jjfu
-- ------------------------------------------------------
-- Server version	5.6.49-log

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
-- Table structure for table `sys_config`
--

DROP TABLE IF EXISTS `sys_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `web` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `k` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `v` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`config_id`) USING BTREE,
  KEY `config_id` (`config_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_config`
--

LOCK TABLES `sys_config` WRITE;
/*!40000 ALTER TABLE `sys_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `sys_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_menu`
--

DROP TABLE IF EXISTS `sys_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_menu` (
  `submenu_id` int(11) NOT NULL AUTO_INCREMENT,
  `submenu_name` varchar(20) DEFAULT NULL,
  `menu_name` varchar(10) DEFAULT NULL,
  `listorder` int(11) DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`submenu_id`) USING BTREE,
  KEY `submenu_id` (`submenu_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu`
--

LOCK TABLES `sys_menu` WRITE;
/*!40000 ALTER TABLE `sys_menu` DISABLE KEYS */;
INSERT INTO `sys_menu` VALUES (1,'权限管理','user',7,1),(11,'财务管理','finance',3,1),(12,'产品通道管理','tongdao',6,1),(13,'账户管理','member',1,1),(14,'新闻公告','article',5,1),(15,'代理管理','agent',8,1),(16,'订单管理','orders',2,1),(17,'统计报表','tongji',4,1);
/*!40000 ALTER TABLE `sys_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_menu_item`
--

DROP TABLE IF EXISTS `sys_menu_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_menu_item` (
  `resource_id` int(11) NOT NULL AUTO_INCREMENT,
  `resource_name` varchar(20) DEFAULT NULL,
  `resource_url` varchar(100) DEFAULT NULL,
  `submenu_id` varchar(20) DEFAULT NULL,
  `listorder` int(11) DEFAULT '0',
  PRIMARY KEY (`resource_id`) USING BTREE,
  KEY `resource_id` (`resource_id`) USING BTREE,
  KEY `submenu_id` (`submenu_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_menu_item`
--

LOCK TABLES `sys_menu_item` WRITE;
/*!40000 ALTER TABLE `sys_menu_item` DISABLE KEYS */;
INSERT INTO `sys_menu_item` VALUES (1,'管理员添加','admin/Admin/admin_add','1',1),(2,'管理员列表','admin/Admin/admin_list','1',2),(23,'提现审核','admin/Finance/tx_shenhe','11',2),(24,'报表统计','admin/Finance/tj','17',3),(25,'提现列表','admin/Finance/lists','11',8),(26,'添加资讯','admin/Article/add_article','14',2),(27,'资讯列表','admin/Article/article_list','14',3),(28,'添加类型','admin/Article/add_cate','14',0),(29,'管理类型','admin/Article/cate_list','14',1),(30,'通道配置','index.php?do=tongdao&view=td_config','99',1),(11,'用户组添加','admin/Admin/user_group_add','1',3),(12,'用户组管理','admin/Admin/user_group','1',4),(19,'订单查询','admin/Member/orders','16',2),(20,'用户列表','admin/Member/member_list','13',1),(21,'实名审核','admin/Member/truename_auth','13',4),(22,'提现设置','admin/Finance/config','11',1),(31,'渠道费率','admin/Tongdao/zc_profit','12',1),(32,'系统费率','index.php?do=tongdao&view=xt_profit','99',0),(34,'添加公告','admin/Article/add_notice','14',4),(35,'公告列表','admin/Article/notice_list','14',5),(36,'用户登录日志','admin/Member/login_log','13',5),(37,'用户账变明细','admin/Finance/card_logg','11',5),(38,'代理列表','admin/Agent/agent_list','15',0),(39,'api文档','admin/Agent/dowloadapi','151',1),(40,'添加站内信','admin/Article/add_message','14',6),(41,'站内信列表','admin/Article/message_list','14',7),(42,'银行卡列表','admin/Finance/bank_list','11',9),(44,'销卡统计','admin/Finance/statistics','17',4),(45,'用户费率','admin/Tongdao/dk_list','12',2),(46,'漏卡查询','admin/Member/louka','16',4),(47,'业绩分析','admin/Finance/yjfx','17',4),(48,'错卡统计','admin/Finance/rongcuo','17',11),(49,'API通道切换','admin/Tongdao/apiqiehuan','99',2),(50,'API订单查询','admin/Member/orders?api=1','16',3),(51,'添加问题','admin/Article/add_question','14',8),(52,'问题列表','admin/Article/question_list','14',9),(53,'通道配置','admin/Tongdao/sys_config','12',3),(54,'批次查询','admin/Member/pici','16',5),(55,'关键词','admin/Article/key_word','14',10);
/*!40000 ALTER TABLE `sys_menu_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user`
--

DROP TABLE IF EXISTS `sys_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) CHARACTER SET gb2312 DEFAULT NULL,
  `password` varchar(128) CHARACTER SET gb2312 DEFAULT NULL,
  `reg_time` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `group_id` int(11) DEFAULT NULL,
  `email` varchar(64) CHARACTER SET gb2312 DEFAULT NULL,
  `qq` varchar(20) CHARACTER SET gb2312 DEFAULT NULL,
  `mobile` varchar(12) CHARACTER SET gb2312 DEFAULT NULL,
  `truename` varchar(64) CHARACTER SET gb2312 DEFAULT NULL,
  `cash` int(11) DEFAULT NULL,
  PRIMARY KEY (`userid`) USING BTREE,
  KEY `email` (`email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=83 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user`
--

LOCK TABLES `sys_user` WRITE;
/*!40000 ALTER TABLE `sys_user` DISABLE KEYS */;
INSERT INTO `sys_user` VALUES (70,'yaozheng','c62e82fe50f838852131ef6a2760fb12',1507535562,1,1,'','',NULL,'yao',NULL),(80,'qw12','a9dcc70709252ac450570f6011e15fab',1507535562,1,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `sys_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user_group`
--

DROP TABLE IF EXISTS `sys_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(20) DEFAULT NULL,
  `group_roles` text,
  `on_time` int(10) DEFAULT '0',
  PRIMARY KEY (`group_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=gbk ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user_group`
--

LOCK TABLES `sys_user_group` WRITE;
/*!40000 ALTER TABLE `sys_user_group` DISABLE KEYS */;
INSERT INTO `sys_user_group` VALUES (1,'超级管理员','19,20,21,36,46,23,24,25,22,37,42,44,47,48,26,27,28,29,34,35,40,41,1,2,11,12,31,45,49,38,39',1473156100),(12,'客服组','20,21,36,19,50,46,22,23,37,25,42,24,44,48,28,29,26,27,34,35,40,41,51,52,31,45,53',1473156194),(14,'管理员组','20,21,36,19,50,46,22,23,37,25,42,24,44,47,48,28,29,26,27,34,35,40,41,31,45,53',1507535406),(15,'SEO','26,27,51,52',1598199958),(16,NULL,NULL,1598199975);
/*!40000 ALTER TABLE `sys_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'xk_jjfu'
--

--
-- Dumping routines for database 'xk_jjfu'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-02-24 20:35:28
