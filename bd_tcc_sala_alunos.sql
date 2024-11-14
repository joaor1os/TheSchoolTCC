CREATE DATABASE  IF NOT EXISTS `bd_tcc` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `bd_tcc`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: bd_tcc
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `sala_alunos`
--

DROP TABLE IF EXISTS `sala_alunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sala_alunos` (
  `id_sa` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_sa` int(11) NOT NULL,
  `sala_sa` int(11) NOT NULL,
  `ativo_sa` int(11) NOT NULL,
  PRIMARY KEY (`id_sa`),
  KEY `aluno_sa` (`aluno_sa`),
  KEY `sala_sa` (`sala_sa`),
  KEY `ativo_sa` (`ativo_sa`),
  CONSTRAINT `sala_alunos_ibfk_1` FOREIGN KEY (`aluno_sa`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `sala_alunos_ibfk_2` FOREIGN KEY (`sala_sa`) REFERENCES `salas` (`id_sala`),
  CONSTRAINT `sala_alunos_ibfk_3` FOREIGN KEY (`ativo_sa`) REFERENCES `situacao` (`id_situacao`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala_alunos`
--

LOCK TABLES `sala_alunos` WRITE;
/*!40000 ALTER TABLE `sala_alunos` DISABLE KEYS */;
INSERT INTO `sala_alunos` VALUES (1,1,2,1),(2,3,1,1),(3,4,2,1),(4,19,2,1),(5,5,2,1),(6,18,1,1);
/*!40000 ALTER TABLE `sala_alunos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-14 19:32:08
