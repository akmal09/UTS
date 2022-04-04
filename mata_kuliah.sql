-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: mata_kuliah
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `dalam_prodi`
--

DROP TABLE IF EXISTS `dalam_prodi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dalam_prodi` (
  `kode_kelas` varchar(4) NOT NULL,
  `kelas` char(2) NOT NULL,
  `kode` char(3) NOT NULL,
  `nama_mata_kuliah` varchar(20) NOT NULL,
  `sks` int(1) NOT NULL,
  `semester` varchar(8) NOT NULL,
  PRIMARY KEY (`kode_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dalam_prodi`
--

LOCK TABLES `dalam_prodi` WRITE;
/*!40000 ALTER TABLE `dalam_prodi` DISABLE KEYS */;
INSERT INTO `dalam_prodi` VALUES ('01jk','RA','jk','Jarkom',3,'ganjil'),('02jk','RB','jk','Jarkom',3,'ganjil'),('03jk','RC','jk','Jarkom',3,'ganjil'),('04jk','RD','jk','Jarkom',3,'ganjil'),('bd01','RA','bd','Basis Data',3,'genap'),('bd02','RB','BD','Basis Data',3,'genap'),('bd03','RC','BD','Basis Data',3,'genap'),('bd04','RD','BD','Basis Data',3,'genap'),('pb01','RA','PBO','Pem Objek',4,'ganjil'),('pb02','RB','PBO','Pem Objek',4,'ganjil'),('pb03','RC','PBO','Pem Objek',4,'ganjil'),('pb04','RD','PBO','Pem Objek',4,'ganjil'),('SI1','RA','SI','Sis Tertanam',3,'ganjil'),('SI2','RB','SI','Sis Tertanam',3,'ganjil'),('SI3','RC','SI','Sis Tertanam',3,'ganjil'),('SI4','RD','SI','Sis Tertanam',3,'ganjil'),('SIS1','RA','SIS','SISTEM INFO',2,'ganjil'),('SIS2','RB','SIS','SISTEM INFO',2,'ganjil'),('SIS3','RC','SIS','SISTEM INFO',2,'ganjil'),('SIS4','RD','SIS','SISTEM INFO',2,'ganjil');
/*!40000 ALTER TABLE `dalam_prodi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luar_prodi`
--

DROP TABLE IF EXISTS `luar_prodi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `luar_prodi` (
  `kode_kelas` varchar(4) NOT NULL,
  `kelas` char(2) NOT NULL,
  `kode` char(3) NOT NULL,
  `nama_mata_kuliah` varchar(20) NOT NULL,
  `sks` int(1) NOT NULL,
  `semester` varchar(8) NOT NULL,
  PRIMARY KEY (`kode_kelas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luar_prodi`
--

LOCK TABLES `luar_prodi` WRITE;
/*!40000 ALTER TABLE `luar_prodi` DISABLE KEYS */;
INSERT INTO `luar_prodi` VALUES ('ME1','RA','ME','Mekatronika',3,'ganjil'),('ME2','RB','ME','Mekatronika',3,'ganjil'),('ME3','RC','ME','Mekatronika',3,'ganjil'),('ME4','RD','ME','Mekatronika',3,'ganjil'),('MG1','RA','MG','Minyak Gas',3,'genap'),('MG2','RB','MG','Minyak Gas',3,'genap'),('MG3','RC','MG','Minyak Gas',3,'genap'),('MG4','RD','MG','Minyak Gas',3,'genap'),('PG1','RA','PG','Pangan',3,'ganjil'),('PG2','RB','PG','Pangan',3,'ganjil'),('PG3','RC','PG','Pangan',3,'ganjil'),('PG4','RD','PG','Pangan',3,'ganjil'),('SF1','RA','SF','Sis Fisis',3,'genap'),('SF2','RB','SF','Sis Fisis',3,'genap'),('SF3','RC','SF','Sis Fisis',3,'genap'),('SF4','RD','SF','Sis Fisis',3,'genap');
/*!40000 ALTER TABLE `luar_prodi` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-03 10:49:21
