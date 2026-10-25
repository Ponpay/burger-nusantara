-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: db_burger_nusantara
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `db_burger_nusantara`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `db_burger_nusantara` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_burger_nusantara`;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','$2y$10$o0DT/oC1KOhaXTvl.dg2lOETMjeJ3WlsfNDGq6nithPEgcH92KDU2');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cabang`
--

DROP TABLE IF EXISTS `cabang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cabang` (
  `id_cabang` int NOT NULL AUTO_INCREMENT,
  `label_cabang` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lokasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fasilitas` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_maps` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_cabang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cabang`
--

LOCK TABLES `cabang` WRITE;
/*!40000 ALTER TABLE `cabang` DISABLE KEYS */;
INSERT INTO `cabang` VALUES (1,'Cabang Utama','Syiah Kuala','Jln. Teuku Nyak Arief, Darussalam, Banda Aceh, 23111.','Free Wi-Fi • 40+ colokan listrik','0812-3456-7890','https://maps.google.com/?q=Darussalam+Banda+Aceh'),(2,'Cabang Panakkukang','Kopelma Darussalam','Jl. Syeikh Abdul Rauf, Kopelma Darussalam, Banda Aceh, 23111.','Suasana vintage nyaman • family friendly','0812-3456-7890','https://maps.google.com/?q=Kopelma+Darussalam+Banda+Aceh'),(3,'Cabang Gowa','Batoh, Lueng Bata','Jalan Muhammadiyah No. 91, Desa Batoh, Kecamatan Lueng Bata, Kota Banda Aceh, 23247.','Area outdoor teduh • parkir luas','0812-3456-7890','https://maps.google.com/?q=Batoh+Banda+Aceh');
/*!40000 ALTER TABLE `cabang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Burger'),(2,'Sampingan'),(3,'Minuman');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id_menu` int NOT NULL AUTO_INCREMENT,
  `id_kategori` int NOT NULL,
  `nama_menu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `harga` int NOT NULL,
  `gambar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT '4.5',
  `is_favorit` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_menu`),
  KEY `id_kategori` (`id_kategori`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,1,'Burger Keju Spesial','Daging sapi asap harum, lelehan saus keju cheddar berempah khas Serambi Mekkah, dan caramelized onion manis gurih.',25000,'burger-keju.jpg','Best Seller',4.9,1),(2,1,'Burger Sambal Matah','Fillet ayam krispi keemasan, sambal matah Bali segar dengan perasan jeruk limau kasturi, keju leleh, dan selada hidroponik.',28000,'burger-sambal-matah.jpg','Favorit Pedas',4.8,1),(3,1,'Burger Rendang Minang','Patty sapi giling tebal 120g, glazed rendang Minang 8 jam, melted cheddar, taburan bawang goreng renyah, dan brioche bun mentega.',32000,'burger-rendang.jpg','Signature',4.9,1),(4,2,'Kentang Goreng','Kentang potong tebal direbus rempah lalu digoreng garing renyah di luar, pulen di dalam. Disajikan dengan saus garlic mayo lokal.',15000,'singkong-krispi.jpg','Snack Wajib',4.7,1),(5,3,'Es Teh Manis','Teh seduh segar dengan es batu.',8000,NULL,NULL,4.5,0);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paket_combo`
--

DROP TABLE IF EXISTS `paket_combo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paket_combo` (
  `id_paket` int NOT NULL AUTO_INCREMENT,
  `nama_paket` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_normal` int NOT NULL,
  `harga_paket` int NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci,
  `is_populer` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_paket`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paket_combo`
--

LOCK TABLES `paket_combo` WRITE;
/*!40000 ALTER TABLE `paket_combo` DISABLE KEYS */;
INSERT INTO `paket_combo` VALUES (1,'Paket Kenyang Kuliah','Hemat 15%',48000,42000,'1 Burger Keju Spesial + 1 Kentang Goreng + 1 Es Teh Manis.',0),(2,'Paket Rendang Komplit','Signature Set',55000,48000,'1 Burger Rendang Minang + 1 Kentang Goreng + 1 Es Teh Manis.',1),(3,'Paket Duo Sahabat','Untuk Berdua',81000,70000,'2 Burger pilihan (Keju / Sambal Matah / Rendang) + 1 Kentang Goreng + 2 Es Teh Manis.',0);
/*!40000 ALTER TABLE `paket_combo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-25 17:29:22
