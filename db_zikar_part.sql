-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for daftar_tamu_pibs
CREATE DATABASE IF NOT EXISTS `daftar_tamu_pibs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `daftar_tamu_pibs`;

-- Dumping structure for table daftar_tamu_pibs.data_tamu
CREATE TABLE IF NOT EXISTS `data_tamu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `nama` varchar(100) NOT NULL,
  `institusi` varchar(100) NOT NULL,
  `kategori` enum('Tamu Institusi','Wali Mahasiswa','Vendor','Lainnya') NOT NULL,
  `keperluan` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table daftar_tamu_pibs.data_tamu: ~0 rows (approximately)
INSERT INTO `data_tamu` (`id`, `tanggal`, `nama`, `institusi`, `kategori`, `keperluan`) VALUES
	(1, '2024-01-03', 'Jane Doe', 'Universitas Gajayana', 'Tamu Institusi', 'Berkunjung'),
	(2, '2024-01-05', 'John Doe', 'Institut Tambal Ban', 'Tamu Institusi', 'Studi banding'),
	(3, '2024-12-05', 'Jake Doe', 'Umum', 'Wali Mahasiswa', 'Mendaftarkan Anak');

-- Dumping structure for table daftar_tamu_pibs.web_info
CREATE TABLE IF NOT EXISTS `web_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `logo` varchar(255) DEFAULT NULL,
  `nama_web` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table daftar_tamu_pibs.web_info: ~1 rows (approximately)
INSERT INTO `web_info` (`id`, `logo`, `nama_web`, `subtitle`, `lokasi`) VALUES
	(1, 'pepega.jpg', 'Buku Tamu Online', 'Selamat datang di Buku Tamu Online', 'Jakarta, Indonesia');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
