DROP TABLE IF EXISTS `gg_forum_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_forum_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `gg_forum_comment_gg_forum_post_FK` (`post_id`),
  KEY `gg_forum_comment_gg_forum_comment_FK` (`parent_comment_id`),
  KEY `gg_forum_comment_gg_user_FK` (`user_id`),
  CONSTRAINT `gg_forum_comment_gg_forum_comment_FK` FOREIGN KEY (`parent_comment_id`) REFERENCES `gg_forum_comment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gg_forum_comment_gg_forum_post_FK` FOREIGN KEY (`post_id`) REFERENCES `gg_forum_post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gg_forum_comment_gg_user_FK` FOREIGN KEY (`user_id`) REFERENCES `gg_uid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_forum_comment`
--

LOCK TABLES `gg_forum_comment` WRITE;
/*!40000 ALTER TABLE `gg_forum_comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_forum_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_forum_post`
--

DROP TABLE IF EXISTS `gg_forum_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_forum_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `gg_forum_post_gg_forum_topic_FK` (`topic_id`),
  KEY `gg_forum_post_gg_user_FK` (`user_id`),
  CONSTRAINT `gg_forum_post_gg_forum_topic_FK` FOREIGN KEY (`topic_id`) REFERENCES `gg_forum_topic` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gg_forum_post_gg_user_FK` FOREIGN KEY (`user_id`) REFERENCES `gg_uid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_forum_post`
--

LOCK TABLES `gg_forum_post` WRITE;
/*!40000 ALTER TABLE `gg_forum_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_forum_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_forum_topic`
--

DROP TABLE IF EXISTS `gg_forum_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_forum_topic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_forum_topic_unique_title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_forum_topic`
--

LOCK TABLES `gg_forum_topic` WRITE;
/*!40000 ALTER TABLE `gg_forum_topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_forum_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_garage`
--

DROP TABLE IF EXISTS `gg_garage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_garage` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `registration_no` varchar(100) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_garage_unique_name_address` (`name`,`address`),
  UNIQUE KEY `gg_garage_unique_username` (`username`),
  KEY `gg_garage_gg_status_fk` (`status_id`),
  KEY `gg_garage_id_IDX` (`id`,`username`,`name`) USING BTREE,
  CONSTRAINT `gg_garage_gg_status_fk` FOREIGN KEY (`status_id`) REFERENCES `gg_status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_garage`
--

LOCK TABLES `gg_garage` WRITE;
/*!40000 ALTER TABLE `gg_garage` DISABLE KEYS */;
INSERT INTO `gg_garage` VALUES (1,'asdf','$2y$10$RfL1l2d47ZDRkugOrvPOVOK4SgKK0ej7puIzAGg1WaswAU0oycBSu','AutoCare','No. 123, Kalutara.','autocare@gmail.com','071-0802092','BRN-1234567',2,'Hi there, I am using GearGuard!');
/*!40000 ALTER TABLE `gg_garage` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger before_insert_garage before insert on gearguard.gg_garage for each row begin insert into gearguard.gg_uid values(); set new.id = last_insert_id(); end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `gg_garage_mechanic`
--

DROP TABLE IF EXISTS `gg_garage_mechanic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_garage_mechanic` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nic` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `date_employeed` date NOT NULL,
  `garage_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_garage_mechanic_unique_username` (`username`),
  UNIQUE KEY `gg_garage_mechanic_unique_nic` (`nic`),
  UNIQUE KEY `gg_garage_mechanic_unique_email` (`email`),
  UNIQUE KEY `gg_garage_mechanic_unique_contact` (`contact_no`),
  KEY `gg_garage_mechanic_gg_garage_FK` (`garage_id`),
  KEY `gg_garage_mechanic_gg_status_FK` (`status_id`),
  KEY `gg_garage_mechanic_id_IDX` (`id`,`username`,`first_name`) USING BTREE,
  CONSTRAINT `gg_garage_mechanic_gg_garage_FK` FOREIGN KEY (`garage_id`) REFERENCES `gg_garage` (`id`),
  CONSTRAINT `gg_garage_mechanic_gg_status_FK` FOREIGN KEY (`status_id`) REFERENCES `gg_status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_garage_mechanic`
--

LOCK TABLES `gg_garage_mechanic` WRITE;
/*!40000 ALTER TABLE `gg_garage_mechanic` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_garage_mechanic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_garage_service`
--

DROP TABLE IF EXISTS `gg_garage_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_garage_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `duration` double NOT NULL,
  `description` text DEFAULT NULL,
  `garage_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_garage_service_unique` (`garage_id`,`type`),
  KEY `gg_garage_service_gg_status_fk` (`status_id`),
  CONSTRAINT `gg_garage_service_gg_garage_FK` FOREIGN KEY (`garage_id`) REFERENCES `gg_garage` (`id`),
  CONSTRAINT `gg_garage_service_gg_status_fk` FOREIGN KEY (`status_id`) REFERENCES `gg_status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_garage_service`
--

LOCK TABLES `gg_garage_service` WRITE;
/*!40000 ALTER TABLE `gg_garage_service` DISABLE KEYS */;
INSERT INTO `gg_garage_service` VALUES (1,'Tyre Pressure Check',1000,2,'Pressure should not be more than the atmospheric pressure.',1,2);
/*!40000 ALTER TABLE `gg_garage_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_messages`
--

DROP TABLE IF EXISTS `gg_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fuid` int(11) NOT NULL,
  `tuid` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gg_messages_gg_uid_fuid_FK` (`fuid`),
  KEY `gg_messages_gg_uid_tuid_FK` (`tuid`),
  KEY `gg_messages_gg_status_FK` (`status_id`),
  CONSTRAINT `gg_messages_gg_status_FK` FOREIGN KEY (`status_id`) REFERENCES `gg_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gg_messages_gg_uid_fuid_FK` FOREIGN KEY (`fuid`) REFERENCES `gg_uid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gg_messages_gg_uid_tuid_FK` FOREIGN KEY (`tuid`) REFERENCES `gg_uid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_messages`
--

LOCK TABLES `gg_messages` WRITE;
/*!40000 ALTER TABLE `gg_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_notification`
--

DROP TABLE IF EXISTS `gg_notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(500) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gg_notification_gg_uid_FK` (`user_id`),
  KEY `gg_notification_gg_status` (`status_id`),
  CONSTRAINT `gg_notification_gg_status` FOREIGN KEY (`status_id`) REFERENCES `gg_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gg_notification_gg_uid_FK` FOREIGN KEY (`user_id`) REFERENCES `gg_uid` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_notification`
--

LOCK TABLES `gg_notification` WRITE;
/*!40000 ALTER TABLE `gg_notification` DISABLE KEYS */;
INSERT INTO `gg_notification` VALUES (1,1,'2025-04-18 12:28:13','This is the first notification ever',1),(2,1,'2025-04-18 17:46:12','You just visited this page!',1),(3,1,'2025-04-18 17:47:25','You just visited this page!',1),(4,1,'2025-04-18 17:47:28','You just visited this page!',1),(5,1,'2025-04-18 17:47:38','You just visited this page!',1),(6,1,'2025-04-18 17:48:23','You just visited this page!',1),(7,1,'2025-04-18 17:50:08','You just visited this page!',1),(8,1,'2025-04-18 18:06:28','You just visited this page!',1),(9,1,'2025-04-18 18:19:49','You just visited this page!',1),(10,1,'2025-04-18 18:20:31','You just visited this page!',1),(11,1,'2025-04-18 18:20:59','You just visited this page!',1),(12,1,'2025-04-18 18:21:37','You just visited this page!',1),(13,1,'2025-04-18 18:22:35','You just visited this page!',1),(14,1,'2025-04-18 18:23:21','You just visited this page!',1),(15,1,'2025-04-18 18:23:39','You just visited this page!',1),(16,1,'2025-04-18 18:23:51','You just visited this page!',1),(17,1,'2025-04-18 18:26:10','You just visited this page!',1),(18,1,'2025-04-18 18:27:23','You just visited this page!',1),(19,1,'2025-04-18 18:28:50','You just visited this page!',1),(20,1,'2025-04-18 18:29:50','You just visited this page!',1),(21,1,'2025-04-18 18:31:32','You just visited this page!',1),(22,1,'2025-04-18 18:31:53','You just visited this page!',1),(23,1,'2025-04-19 05:50:44','You just visited this page!',1),(24,1,'2025-04-19 05:52:41','You just visited this page!',1),(25,1,'2025-04-19 05:53:58','You just visited this page!',1),(26,1,'2025-04-19 05:54:12','You just visited this page!',1),(27,1,'2025-04-19 05:54:59','You just visited this page!',1),(28,1,'2025-04-19 05:55:13','You just visited this page!',1),(29,1,'2025-04-19 05:56:11','You just visited this page!',1),(30,1,'2025-04-19 05:56:20','You just visited this page!',1),(31,1,'2025-04-19 05:56:43','You just visited this page!',1),(32,1,'2025-04-19 05:57:38','You just visited this page!',1),(33,1,'2025-04-19 06:00:17','You just visited this page!',1),(34,1,'2025-04-19 06:00:33','You just visited this page!',1),(35,1,'2025-04-19 06:01:29','You just visited this page!',1),(36,1,'2025-04-19 06:01:55','You just visited this page!',1),(37,1,'2025-04-19 06:23:46','You just visited this page!',1),(38,1,'2025-04-19 07:00:05','You just visited this page!',1),(39,2,'2025-04-19 07:47:58','Your appointment has been confirmed by the garage.',1),(40,2,'2025-04-19 09:48:42','Your appointment forEB-1234 has been confirmed by the garage AutoCare',1);
/*!40000 ALTER TABLE `gg_notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_owner_ownership_type`
--

DROP TABLE IF EXISTS `gg_owner_ownership_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_owner_ownership_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownership_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_owner_ownership_type_unique` (`ownership_type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_owner_ownership_type`
--

LOCK TABLES `gg_owner_ownership_type` WRITE;
/*!40000 ALTER TABLE `gg_owner_ownership_type` DISABLE KEYS */;
INSERT INTO `gg_owner_ownership_type` VALUES (1,'Ownership Type 01');
/*!40000 ALTER TABLE `gg_owner_ownership_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_service_mechanic_perform`
--

DROP TABLE IF EXISTS `gg_service_mechanic_perform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_service_mechanic_perform` (
  `service_id` int(11) NOT NULL,
  `mechanic_id` int(11) NOT NULL,
  PRIMARY KEY (`service_id`,`mechanic_id`),
  KEY `gg_service_mechanic_perform_gg_garage_mechanic_FK` (`mechanic_id`),
  CONSTRAINT `gg_service_mechanic_perform_gg_garage_mechanic_FK` FOREIGN KEY (`mechanic_id`) REFERENCES `gg_garage_mechanic` (`id`),
  CONSTRAINT `gg_service_mechanic_perform_gg_garage_service_FK` FOREIGN KEY (`service_id`) REFERENCES `gg_garage_service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_service_mechanic_perform`
--

LOCK TABLES `gg_service_mechanic_perform` WRITE;
/*!40000 ALTER TABLE `gg_service_mechanic_perform` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_service_mechanic_perform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_sparepart`
--

DROP TABLE IF EXISTS `gg_sparepart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_sparepart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(100) NOT NULL,
  `type` varchar(150) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `manufactured_date` date DEFAULT NULL,
  `waranty_period` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_sparepart_unique_serial` (`serial_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_sparepart`
--

LOCK TABLES `gg_sparepart` WRITE;
/*!40000 ALTER TABLE `gg_sparepart` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_sparepart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_sparepart_service_vehicle_install`
--

DROP TABLE IF EXISTS `gg_sparepart_service_vehicle_install`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_sparepart_service_vehicle_install` (
  `vehicle_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `sparepart_id` int(11) NOT NULL,
  `installed_date` date NOT NULL,
  PRIMARY KEY (`service_id`,`sparepart_id`),
  KEY `gg_sparepart_service_vehicle_install_gg_sparepart_FK` (`sparepart_id`),
  KEY `gg_sparepart_service_vehicle_install_gg_vehicle_FK` (`vehicle_id`),
  CONSTRAINT `gg_sparepart_service_vehicle_install_gg_garage_service_FK` FOREIGN KEY (`service_id`) REFERENCES `gg_garage_service` (`id`),
  CONSTRAINT `gg_sparepart_service_vehicle_install_gg_sparepart_FK` FOREIGN KEY (`sparepart_id`) REFERENCES `gg_sparepart` (`id`),
  CONSTRAINT `gg_sparepart_service_vehicle_install_gg_vehicle_FK` FOREIGN KEY (`vehicle_id`) REFERENCES `gg_vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_sparepart_service_vehicle_install`
--

LOCK TABLES `gg_sparepart_service_vehicle_install` WRITE;
/*!40000 ALTER TABLE `gg_sparepart_service_vehicle_install` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_sparepart_service_vehicle_install` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_sparepart_vehicleuser_vehicle_install`
--

DROP TABLE IF EXISTS `gg_sparepart_vehicleuser_vehicle_install`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_sparepart_vehicleuser_vehicle_install` (
  `vehicle_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sparepart_id` int(11) NOT NULL,
  `installed_date` date NOT NULL,
  PRIMARY KEY (`user_id`,`sparepart_id`),
  KEY `gg_sparepart_vehicleuser_vehicle_install_gg_sparepart_FK` (`sparepart_id`),
  CONSTRAINT `gg_sparepart_vehicleuser_vehicle_install_gg_sparepart_FK` FOREIGN KEY (`sparepart_id`) REFERENCES `gg_sparepart` (`id`),
  CONSTRAINT `gg_sparepart_vehicleuser_vehicle_install_gg_user_vehicleuser_FK` FOREIGN KEY (`user_id`) REFERENCES `gg_user_vehicleuser` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_sparepart_vehicleuser_vehicle_install`
--

LOCK TABLES `gg_sparepart_vehicleuser_vehicle_install` WRITE;
/*!40000 ALTER TABLE `gg_sparepart_vehicleuser_vehicle_install` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_sparepart_vehicleuser_vehicle_install` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_status`
--

DROP TABLE IF EXISTS `gg_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_status_unique` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_status`
--

LOCK TABLES `gg_status` WRITE;
/*!40000 ALTER TABLE `gg_status` DISABLE KEYS */;
INSERT INTO `gg_status` VALUES (2,'active'),(3,'deleted'),(1,'Inactive');
/*!40000 ALTER TABLE `gg_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_uid`
--

DROP TABLE IF EXISTS `gg_uid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_uid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_uid`
--

LOCK TABLES `gg_uid` WRITE;
/*!40000 ALTER TABLE `gg_uid` DISABLE KEYS */;
INSERT INTO `gg_uid` VALUES (1),(2);
/*!40000 ALTER TABLE `gg_uid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_user`
--

DROP TABLE IF EXISTS `gg_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `nic` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_user_owner_unique_username` (`username`),
  UNIQUE KEY `gg_user_owner_unique_nic` (`nic`),
  UNIQUE KEY `gg_user_owner_unique_email` (`email`),
  UNIQUE KEY `gg_user_owner_unique_contact` (`contact_no`),
  KEY `gg_user_gg_status_fk` (`status_id`),
  KEY `gg_user_id_IDX` (`id`,`username`,`first_name`) USING BTREE,
  CONSTRAINT `gg_user_gg_status_fk` FOREIGN KEY (`status_id`) REFERENCES `gg_status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_user`
--

LOCK TABLES `gg_user` WRITE;
/*!40000 ALTER TABLE `gg_user` DISABLE KEYS */;
INSERT INTO `gg_user` VALUES (2,'asdf','$2y$10$9bT0PX2t9glpRhR4fseq1uC3J3AxY4KJKcYtrMb1mIMnVevChgvPW','Customer','001','200205800823','No. 123, Kalutara.','gearguardcustomer@gmail.com','071-0802092',2);
/*!40000 ALTER TABLE `gg_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'IGNORE_SPACE,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger before_insert_customer before insert on gearguard.gg_user for each row begin insert into gearguard.gg_uid values (); set new.id = last_insert_id(); end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `gg_user_admin`
--

DROP TABLE IF EXISTS `gg_user_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_user_admin` (
  `user_id` int(11) NOT NULL,
  KEY `gg_user_admin_gg_user_FK` (`user_id`),
  CONSTRAINT `gg_user_admin_gg_user_FK` FOREIGN KEY (`user_id`) REFERENCES `gg_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_user_admin`
--

LOCK TABLES `gg_user_admin` WRITE;
/*!40000 ALTER TABLE `gg_user_admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_user_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_user_owner`
--

DROP TABLE IF EXISTS `gg_user_owner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_user_owner` (
  `vehicle_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ownership_status_id` int(11) NOT NULL,
  `registration_date` date DEFAULT NULL,
  PRIMARY KEY (`user_id`,`vehicle_id`),
  KEY `gg_user_owner_gg_vehicle_fk` (`vehicle_id`),
  KEY `gg_user_owner_gg_owner_ownership_type_fk` (`ownership_status_id`),
  CONSTRAINT `gg_user_owner_gg_owner_ownership_type_fk` FOREIGN KEY (`ownership_status_id`) REFERENCES `gg_owner_ownership_type` (`id`),
  CONSTRAINT `gg_user_owner_gg_user_fk` FOREIGN KEY (`user_id`) REFERENCES `gg_user` (`id`),
  CONSTRAINT `gg_user_owner_gg_vehicle_fk` FOREIGN KEY (`vehicle_id`) REFERENCES `gg_vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_user_owner`
--

LOCK TABLES `gg_user_owner` WRITE;
/*!40000 ALTER TABLE `gg_user_owner` DISABLE KEYS */;
INSERT INTO `gg_user_owner` VALUES (1,2,1,'2025-04-19');
/*!40000 ALTER TABLE `gg_user_owner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_user_vehicleuser`
--

DROP TABLE IF EXISTS `gg_user_vehicleuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_user_vehicleuser` (
  `user_id` int(11) NOT NULL,
  `license_no` varchar(30) NOT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `gg_user_vehicleuser_gg_user_fk` FOREIGN KEY (`user_id`) REFERENCES `gg_user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_user_vehicleuser`
--

LOCK TABLES `gg_user_vehicleuser` WRITE;
/*!40000 ALTER TABLE `gg_user_vehicleuser` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_user_vehicleuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `gg_users_all_view`
--

DROP TABLE IF EXISTS `gg_users_all_view`;
/*!50001 DROP VIEW IF EXISTS `gg_users_all_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gg_users_all_view` AS SELECT
 1 AS `unique_id`,
  1 AS `id`,
  1 AS `name`,
  1 AS `username`,
  1 AS `password`,
  1 AS `source_table` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gg_users_owners_view`
--

DROP TABLE IF EXISTS `gg_users_owners_view`;
/*!50001 DROP VIEW IF EXISTS `gg_users_owners_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gg_users_owners_view` AS SELECT
 1 AS `username`,
  1 AS `password`,
  1 AS `first_name`,
  1 AS `last_name`,
  1 AS `id`,
  1 AS `nic`,
  1 AS `address`,
  1 AS `email`,
  1 AS `contact_no`,
  1 AS `status_id`,
  1 AS `vehicle_id`,
  1 AS `ownership_status_id`,
  1 AS `registration_date` */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `gg_users_vehicleusers_view`
--

DROP TABLE IF EXISTS `gg_users_vehicleusers_view`;
/*!50001 DROP VIEW IF EXISTS `gg_users_vehicleusers_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `gg_users_vehicleusers_view` AS SELECT
 1 AS `username`,
  1 AS `password`,
  1 AS `first_name`,
  1 AS `last_name`,
  1 AS `id`,
  1 AS `nic`,
  1 AS `address`,
  1 AS `email`,
  1 AS `contact_no`,
  1 AS `status_id`,
  1 AS `license_no` */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `gg_vehicle`
--

DROP TABLE IF EXISTS `gg_vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vin` varchar(30) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year_manufactured` date DEFAULT NULL,
  `license_plate_no` varchar(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `engine_capacity_id` int(11) NOT NULL,
  `fuel_type_id` int(11) NOT NULL,
  `bodytype_id` int(11) NOT NULL,
  `insurance_no` varchar(100) DEFAULT NULL,
  `engine_no` varchar(100) NOT NULL,
  `current_user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `vehicle_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_vehicle_unique_engine_no` (`engine_no`),
  UNIQUE KEY `gg_vehicle_unique_vin` (`vin`),
  UNIQUE KEY `gg_vehicle_unique_vin_license_plate` (`vin`,`license_plate_no`),
  KEY `gg_vehicle_gg_vehicle_model_fk` (`model_id`),
  KEY `gg_vehicle_gg_vehicle_class_fk` (`class_id`),
  KEY `gg_vehicle_gg_vehicle_engine_capacity_fk` (`engine_capacity_id`),
  KEY `gg_vehicle_gg_user_vehicleuser_fk` (`current_user_id`),
  KEY `gg_vehicle_gg_status_fk` (`status_id`),
  KEY `gg_vehicle_gg_vehicle_fueltype_fk` (`fuel_type_id`),
  KEY `gg_vehicle_gg_vehicle_bodytype_fk` (`bodytype_id`),
  KEY `gg_vehicle_gg_vehicle_type_FK` (`vehicle_type_id`),
  CONSTRAINT `gg_vehicle_gg_status_fk` FOREIGN KEY (`status_id`) REFERENCES `gg_status` (`id`),
  CONSTRAINT `gg_vehicle_gg_user_vehicleuser_fk` FOREIGN KEY (`current_user_id`) REFERENCES `gg_user_vehicleuser` (`user_id`),
  CONSTRAINT `gg_vehicle_gg_vehicle_bodytype_fk` FOREIGN KEY (`bodytype_id`) REFERENCES `gg_vehicle_bodytype` (`id`),
  CONSTRAINT `gg_vehicle_gg_vehicle_class_fk` FOREIGN KEY (`class_id`) REFERENCES `gg_vehicle_class` (`id`),
  CONSTRAINT `gg_vehicle_gg_vehicle_engine_capacity_fk` FOREIGN KEY (`engine_capacity_id`) REFERENCES `gg_vehicle_engine_capacity` (`id`),
  CONSTRAINT `gg_vehicle_gg_vehicle_fueltype_fk` FOREIGN KEY (`fuel_type_id`) REFERENCES `gg_vehicle_fueltype` (`id`),
  CONSTRAINT `gg_vehicle_gg_vehicle_model_fk` FOREIGN KEY (`model_id`) REFERENCES `gg_vehicle_model` (`id`),
  CONSTRAINT `gg_vehicle_gg_vehicle_type_FK` FOREIGN KEY (`vehicle_type_id`) REFERENCES `gg_vehicle_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle`
--

LOCK TABLES `gg_vehicle` WRITE;
/*!40000 ALTER TABLE `gg_vehicle` DISABLE KEYS */;
INSERT INTO `gg_vehicle` VALUES (1,'VIN 01',1,'2025-04-19','EB-1234',1,1,1,1,'1234','12345',NULL,2,1);
/*!40000 ALTER TABLE `gg_vehicle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_assignments`
--

DROP TABLE IF EXISTS `gg_vehicle_assignments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_assignments` (
  `vehicle_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_assigned` date NOT NULL,
  PRIMARY KEY (`vehicle_id`,`owner_id`,`user_id`),
  KEY `gg_vehicle_assignments_gg_user_vehicleuser_fk` (`user_id`),
  KEY `gg_vehicle_assignments_gg_user_owner_fk` (`owner_id`,`vehicle_id`),
  CONSTRAINT `gg_vehicle_assignments_gg_user_owner_fk` FOREIGN KEY (`owner_id`, `vehicle_id`) REFERENCES `gg_user_owner` (`user_id`, `vehicle_id`),
  CONSTRAINT `gg_vehicle_assignments_gg_user_vehicleuser_fk` FOREIGN KEY (`user_id`) REFERENCES `gg_user_vehicleuser` (`user_id`),
  CONSTRAINT `gg_vehicle_assignments_gg_vehicle_FK` FOREIGN KEY (`vehicle_id`) REFERENCES `gg_vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_assignments`
--

LOCK TABLES `gg_vehicle_assignments` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_assignments` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_vehicle_assignments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_bodytype`
--

DROP TABLE IF EXISTS `gg_vehicle_bodytype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_bodytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bodytype` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_vehicle_bodytype_unique` (`bodytype`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_bodytype`
--

LOCK TABLES `gg_vehicle_bodytype` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_bodytype` DISABLE KEYS */;
INSERT INTO `gg_vehicle_bodytype` VALUES (1,'Vehicle Body Type 01');
/*!40000 ALTER TABLE `gg_vehicle_bodytype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_class`
--

DROP TABLE IF EXISTS `gg_vehicle_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_vehicle_class_unique` (`class`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_class`
--

LOCK TABLES `gg_vehicle_class` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_class` DISABLE KEYS */;
INSERT INTO `gg_vehicle_class` VALUES (1,'Class A');
/*!40000 ALTER TABLE `gg_vehicle_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_engine_capacity`
--

DROP TABLE IF EXISTS `gg_vehicle_engine_capacity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_engine_capacity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `capacity` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_vehicle_engine_capacity_unique` (`capacity`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_engine_capacity`
--

LOCK TABLES `gg_vehicle_engine_capacity` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_engine_capacity` DISABLE KEYS */;
INSERT INTO `gg_vehicle_engine_capacity` VALUES (1,'450  CC');
/*!40000 ALTER TABLE `gg_vehicle_engine_capacity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_fueltype`
--

DROP TABLE IF EXISTS `gg_vehicle_fueltype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_fueltype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fueltype` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_vehicle_fueltype_unique` (`fueltype`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_fueltype`
--

LOCK TABLES `gg_vehicle_fueltype` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_fueltype` DISABLE KEYS */;
INSERT INTO `gg_vehicle_fueltype` VALUES (1,'Petrol');
/*!40000 ALTER TABLE `gg_vehicle_fueltype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_manufacturer`
--

DROP TABLE IF EXISTS `gg_vehicle_manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_vehicle_manufacturer_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_manufacturer`
--

LOCK TABLES `gg_vehicle_manufacturer` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_manufacturer` DISABLE KEYS */;
INSERT INTO `gg_vehicle_manufacturer` VALUES (1,'Vehicle Manufacturer 01');
/*!40000 ALTER TABLE `gg_vehicle_manufacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_model`
--

DROP TABLE IF EXISTS `gg_vehicle_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(100) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_vehicle_model_unique_model_manufacturer` (`model`,`manufacturer_id`),
  KEY `gg_vehicle_model_gg_vehicle_manufacturer_fk` (`manufacturer_id`),
  CONSTRAINT `gg_vehicle_model_gg_vehicle_manufacturer_fk` FOREIGN KEY (`manufacturer_id`) REFERENCES `gg_vehicle_manufacturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_model`
--

LOCK TABLES `gg_vehicle_model` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_model` DISABLE KEYS */;
INSERT INTO `gg_vehicle_model` VALUES (1,'Vehicle Model 01',1);
/*!40000 ALTER TABLE `gg_vehicle_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_service_appointment`
--

DROP TABLE IF EXISTS `gg_vehicle_service_appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_service_appointment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `notes` text DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `gg_vehicle_service_appointment_gg_vehicle_FK` (`vehicle_id`),
  KEY `gg_vehicle_service_appointment_gg_garage_service_FK` (`service_id`),
  KEY `gg_vehicle_service_appointment_gg_status_FK` (`status_id`),
  KEY `gg_vehicle_service_appointment_date_IDX` (`date`) USING BTREE,
  CONSTRAINT `gg_vehicle_service_appointment_gg_garage_service_FK` FOREIGN KEY (`service_id`) REFERENCES `gg_garage_service` (`id`),
  CONSTRAINT `gg_vehicle_service_appointment_gg_status_FK` FOREIGN KEY (`status_id`) REFERENCES `gg_status` (`id`),
  CONSTRAINT `gg_vehicle_service_appointment_gg_vehicle_FK` FOREIGN KEY (`vehicle_id`) REFERENCES `gg_vehicle` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_service_appointment`
--

LOCK TABLES `gg_vehicle_service_appointment` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_service_appointment` DISABLE KEYS */;
INSERT INTO `gg_vehicle_service_appointment` VALUES (1,1,1,'2025-04-28','10:00:00','My tyres are floating in water.',2);
/*!40000 ALTER TABLE `gg_vehicle_service_appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_service_take`
--

DROP TABLE IF EXISTS `gg_vehicle_service_take`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_service_take` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `mechanic_id` int(11) NOT NULL,
  `begin_timestamp` datetime NOT NULL,
  `end_timestamp` datetime NOT NULL,
  `duration` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gg_vehicle_service_take_gg_vehicle_FK` (`vehicle_id`),
  KEY `gg_vehicle_service_take_gg_garage_service_FK` (`service_id`),
  KEY `gg_vehicle_service_take_gg_garage_mechanic_FK` (`mechanic_id`),
  CONSTRAINT `gg_vehicle_service_take_gg_garage_mechanic_FK` FOREIGN KEY (`mechanic_id`) REFERENCES `gg_garage_mechanic` (`id`),
  CONSTRAINT `gg_vehicle_service_take_gg_garage_service_FK` FOREIGN KEY (`service_id`) REFERENCES `gg_garage_service` (`id`),
  CONSTRAINT `gg_vehicle_service_take_gg_vehicle_FK` FOREIGN KEY (`vehicle_id`) REFERENCES `gg_vehicle` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_service_take`
--

LOCK TABLES `gg_vehicle_service_take` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_service_take` DISABLE KEYS */;
/*!40000 ALTER TABLE `gg_vehicle_service_take` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gg_vehicle_type`
--

DROP TABLE IF EXISTS `gg_vehicle_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gg_vehicle_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gg_vehicle_type_unique` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gg_vehicle_type`
--

LOCK TABLES `gg_vehicle_type` WRITE;
/*!40000 ALTER TABLE `gg_vehicle_type` DISABLE KEYS */;
INSERT INTO `gg_vehicle_type` VALUES (1,'Vehicle Type 01');
/*!40000 ALTER TABLE `gg_vehicle_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'m0001_initial.php','2024-11-25 09:01:31'),(2,'m0002_add_password.php','2024-11-25 09:01:31');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'asdf@gmail.com','asdf','asdf',0,'2024-11-25 09:02:13','$2y$10$2kBEEKfAdgGcYv17had/.ugIhEmtVI.Foz67hTCqCZ8WL3lR0pEPi');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
