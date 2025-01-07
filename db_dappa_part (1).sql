-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.168.0.1    Database: daftar_tamu_pibs
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `data_tamu`
--

DROP TABLE IF EXISTS `data_tamu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_tamu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `nama` varchar(100) NOT NULL,
  `institusi` varchar(100) NOT NULL,
  `kategori` enum('Tamu Institusi','Wali Mahasiswa','Vendor','Lainnya') NOT NULL,
  `keperluan` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_tamu`
--

LOCK TABLES `data_tamu` WRITE;
/*!40000 ALTER TABLE `data_tamu` DISABLE KEYS */;
INSERT INTO `data_tamu` VALUES (1,'2024-01-03','Jane Doe','Universitas Gajayana','Tamu Institusi','Berkunjung'),(2,'2024-01-05','John Doe','Institut Tambal Ban','Tamu Institusi','Studi banding'),(3,'2024-12-05','Jake Doe','Umum','Wali Mahasiswa','Mendaftarkan Anak');
/*!40000 ALTER TABLE `data_tamu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sosmed`
--

DROP TABLE IF EXISTS `sosmed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sosmed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `website_name` varchar(255) DEFAULT NULL,
  `motto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sosmed`
--

LOCK TABLES `sosmed` WRITE;
/*!40000 ALTER TABLE `sosmed` DISABLE KEYS */;
INSERT INTO `sosmed` VALUES (2,'@dappa.mda','@dicky','@Rafi','web_dappa','mau kaya');
/*!40000 ALTER TABLE `sosmed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `web_info`
--

DROP TABLE IF EXISTS `web_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `web_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) DEFAULT NULL,
  `nama_web` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `web_info`
--

LOCK TABLES `web_info` WRITE;
/*!40000 ALTER TABLE `web_info` DISABLE KEYS */;
INSERT INTO `web_info` VALUES (1,'pepega.jpg','Buku Tamu Online','Selamat datang di Buku Tamu Online','Jakarta, Indonesia');
/*!40000 ALTER TABLE `web_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'daftar_tamu_pibs'
--

--
-- Dumping routines for database 'daftar_tamu_pibs'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-07 13:10:05
