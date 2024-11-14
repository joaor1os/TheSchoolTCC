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
-- Table structure for table `aluno`
--

DROP TABLE IF EXISTS `aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aluno` (
  `id_aluno` int(11) NOT NULL AUTO_INCREMENT,
  `cpf_aluno` char(11) NOT NULL,
  `nome_aluno` varchar(200) NOT NULL,
  `data_nascimento_aluno` date NOT NULL,
  `sexo_aluno` enum('M','F') NOT NULL,
  `situacao_aluno` int(11) NOT NULL,
  `contato_aluno` varchar(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id_aluno`),
  UNIQUE KEY `cpf_aluno` (`cpf_aluno`),
  UNIQUE KEY `email` (`email`),
  KEY `situacao_aluno` (`situacao_aluno`),
  CONSTRAINT `aluno_ibfk_1` FOREIGN KEY (`situacao_aluno`) REFERENCES `situacao` (`id_situacao`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` VALUES (1,'12345678901','João Silva','2008-05-15','M',1,'11987654321','joao.silva@email.com','senha123'),(2,'23456789012','Maria Oliveira','2007-09-20','F',1,'11976543210','maria.oliveira@email.com','senha456'),(3,'34567890123','Lucas Pereira','2008-02-10','M',1,'11965432109','lucas.pereira@email.com','senha789'),(4,'45678901234','Ana Costa','2007-12-05','F',1,'11954321098','ana.costa@email.com','senha321'),(5,'56789012345','Rafael Almeida','2008-03-25','M',1,'11943210987','rafael.almeida@email.com','senha654'),(6,'67890123456','Beatriz Souza','2007-07-11','F',1,'11932109876','beatriz.souza@email.com','senha987'),(7,'78901234567','Carlos Lima','2008-08-17','M',1,'11921098765','carlos.lima@email.com','senha111'),(8,'89012345678','Juliana Rocha','2007-11-30','F',1,'11910987654','juliana.rocha@email.com','senha222'),(9,'90123456789','Felipe Costa','2008-01-22','M',1,'11909876543','felipe.costa@email.com','senha333'),(10,'01234567890','Fernanda Martins','2007-04-08','F',1,'11998765432','fernanda.martins@email.com','senha444'),(11,'12309876543','Mateus Fernandes','2008-06-30','M',1,'11987654321','mateus.fernandes@email.com','senha555'),(12,'23498765432','Isabela Santos','2007-10-14','F',1,'11976543210','isabela.santos@email.com','senha666'),(13,'34587654321','Gustavo Ribeiro','2008-09-02','M',1,'11965432109','gustavo.ribeiro@email.com','senha777'),(14,'45676543210','Larissa Almeida','2007-03-17','F',1,'11954321098','larissa.almeida@email.com','senha888'),(15,'56765432109','Eduardo Silva','2008-12-24','M',1,'11943210987','eduardo.silva@email.com','senha999'),(16,'67854321098','Carolina Oliveira','2007-05-06','F',1,'11932109876','carolina.oliveira@email.com','senha000'),(17,'78943210987','Henrique Costa','2008-10-13','M',1,'11921098765','henrique.costa@email.com','senha1234'),(18,'89032109876','Vanessa Souza','2007-02-25','F',1,'11910987654','vanessa.souza@email.com','senha2345'),(19,'90121098765','Marcos Rocha','2008-11-03','M',1,'11909876543','marcos.rocha@email.com','senha3456');
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;
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
