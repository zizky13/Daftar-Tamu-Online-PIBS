-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 07, 2025 at 02:19 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.12
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `daftar_tamu_pibs`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_tamu`
--
cREATE DATABASE IF NOT EXISTS `daftar_tamu_pibs`;
USE `daftar_tamu_pibs`;
CREATE TABLE `data_tamu` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(100) NOT NULL,
  `institusi` varchar(100) NOT NULL,
  `kategori` int NOT NULL,
  `keperluan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data_tamu`
--

INSERT INTO `data_tamu` (`id`, `tanggal`, `nama`, `institusi`, `kategori`, `keperluan`) VALUES
(4, '1993-09-08', 'Ut saepe perspiciati', 'Magna fugit omnis a', 1, 'Voluptatem Ullam ar'),
(5, '1976-11-23', 'Ipsa sunt mollitia ', 'Esse duis excepturi ', 4, 'Optio ipsam est con'),
(6, '2017-10-14', 'Proident omnis omni', 'Recusandae Officia ', 2, 'Voluptatem aut iust'),
(7, '2025-07-15', 'Natus ea molestias e', 'Nisi qui non enim ea', 3, 'Ut optio molestias ');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Tamu Institusi'),
(2, 'Wali Mahasiswa'),
(3, 'Vendor'),
(4, 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `sosmed`
--

CREATE TABLE `sosmed` (
  `id` int NOT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `website_name` varchar(255) DEFAULT NULL,
  `motto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sosmed`
--

INSERT INTO `sosmed` (`id`, `twitter`, `facebook`, `instagram`, `website_name`, `motto`) VALUES
(2, '@dappa.mda', '@dicky', '@Rafi', 'Buku Tamu Online', 'Selamat datang di Buku Tamu Online');

-- --------------------------------------------------------

--
-- Table structure for table `web_info`
--

CREATE TABLE `web_info` (
  `id` int NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `nama_web` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `web_info`
--

INSERT INTO `web_info` (`id`, `logo`, `nama_web`, `subtitle`, `lokasi`) VALUES
(1, 'Buku.jpg', 'Buku Tamu Online', 'Selamat datang di Buku Tamu Online', 'Jakarta, Indonesia');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_tamu`
--
ALTER TABLE `data_tamu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori` (`kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sosmed`
--
ALTER TABLE `sosmed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `web_info`
--
ALTER TABLE `web_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_tamu`
--
ALTER TABLE `data_tamu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sosmed`
--
ALTER TABLE `sosmed`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `web_info`
--
ALTER TABLE `web_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_tamu`
--
ALTER TABLE `data_tamu`
  ADD CONSTRAINT `data_tamu_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
