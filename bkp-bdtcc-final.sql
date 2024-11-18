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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aluno`
--

LOCK TABLES `aluno` WRITE;
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` VALUES (1,'12345678901','Lucas Silva Costa','2013-11-18','M',1,'11987654321','lucas.silva@email.com','senha1'),(2,'12345678902','Maria Oliveira Souza','2013-09-22','F',1,'11987654322','maria.oliveira@email.com','senha2'),(3,'12345678903','Pedro Santos Lima','2013-07-10','M',1,'11987654323','pedro.santos@email.com','senha3'),(4,'12345678904','Ana Costa Pereira','2013-06-03','F',1,'11987654324','ana.costa@email.com','senha4'),(5,'12345678905','Carlos Almeida Rocha','2013-04-25','M',1,'11987654325','carlos.almeida@email.com','senha5'),(6,'12345678906','Beatriz Pereira Costa','2013-02-17','F',1,'11987654326','beatriz.pereira@email.com','senha6'),(7,'12345678907','Gabriel Rocha Lima','2012-12-09','M',1,'11987654327','gabriel.rocha@email.com','senha7'),(8,'12345678908','Julia Souza Oliveira','2012-10-21','F',1,'11987654328','julia.souza@email.com','senha8'),(9,'12345678909','Fernando Costa Almeida','2012-08-15','M',1,'11987654329','fernando.costa@email.com','senha9'),(10,'12345678910','Larissa Martins Rocha','2012-06-30','F',1,'11987654330','larissa.martins@email.com','senha10'),(11,'12345678911','Vitor Almeida Costa','2012-11-18','M',1,'11987654331','vitor.almeida@email.com','senha11'),(12,'12345678912','Camila Rocha Pereira','2012-09-22','F',1,'11987654332','camila.rocha@email.com','senha12'),(13,'12345678913','Felipe Silva Costa','2012-07-10','M',1,'11987654333','felipe.silva@email.com','senha13'),(14,'12345678914','Carla Lima Souza','2012-06-03','F',1,'11987654334','carla.lima@email.com','senha14'),(15,'12345678915','Thiago Oliveira Rocha','2012-04-25','M',1,'11987654335','thiago.oliveira@email.com','senha15'),(16,'12345678916','Sofia Costa Lima','2012-02-17','F',1,'11987654336','sofia.costa@email.com','senha16'),(17,'12345678917','João Santos Rocha','2011-12-09','M',1,'11987654337','joao.santos@email.com','senha17'),(18,'12345678918','Letícia Pereira Souza','2011-10-21','F',1,'11987654338','leticia.pereira@email.com','senha18'),(19,'12345678919','Rafael Rocha Almeida','2011-08-15','M',1,'11987654339','rafael.rocha@email.com','senha19'),(20,'12345678920','Isabela Souza Costa','2011-06-30','F',1,'11987654340','isabela.souza@email.com','senha20'),(21,'12345678921','Leonardo Martins Silva','2011-11-18','M',1,'11987654341','leonardo.martins@email.com','senha21'),(22,'12345678922','Fernanda Almeida Costa','2011-09-22','F',1,'11987654342','fernanda.almeida@email.com','senha22'),(23,'12345678923','Eduardo Silva Rocha','2011-07-10','M',1,'11987654343','eduardo.silva@email.com','senha23'),(24,'12345678924','Roberta Oliveira Lima','2011-06-03','F',1,'11987654344','roberta.oliveira@email.com','senha24'),(25,'12345678925','Gustavo Costa Silva','2011-04-25','M',1,'11987654345','gustavo.costa@email.com','senha25'),(26,'12345678926','Patrícia Rocha Souza','2011-02-17','F',1,'11987654346','patricia.rocha@email.com','senha26'),(27,'12345678927','Daniela Lima Santos','2010-12-09','F',1,'11987654347','daniela.lima@email.com','senha27'),(28,'12345678928','Lucas Santos Rocha','2010-10-21','M',1,'11987654348','lucas.santos@email.com','senha28'),(29,'12345678929','Aline Pereira Lima','2010-08-15','F',1,'11987654349','aline.pereira@email.com','senha29'),(30,'12345678930','Matheus Oliveira Costa','2010-06-30','M',1,'11987654350','matheus.oliveira@email.com','senha30'),(31,'12345678931','Raquel Martins Souza','2010-11-18','F',1,'11987654351','raquel.martins@email.com','senha31'),(32,'12345678932','Samuel Costa Rocha','2010-09-22','M',1,'11987654352','samuel.costa@email.com','senha32'),(33,'12345678933','Juliana Souza Almeida','2010-07-10','F',1,'11987654353','juliana.souza@email.com','senha33'),(34,'12345678934','André Lima Costa','2010-06-03','M',1,'11987654354','andre.lima@email.com','senha34'),(35,'12345678935','Mariana Rocha Santos','2010-04-25','F',1,'11987654355','mariana.rocha@email.com','senha35'),(36,'12345678936','Vinícius Silva Pereira','2010-02-17','M',1,'11987654356','vinicius.silva@email.com','senha36'),(37,'12345678937','Larissa Almeida Souza','2009-12-09','F',1,'11987654357','larissa.almeida@email.com','senha37'),(38,'12345678938','Carlos Pereira Rocha','2009-10-21','M',1,'11987654358','carlos.pereira@email.com','senha38'),(39,'12345678939','Cláudia Rocha Lima','2009-08-15','F',1,'11987654359','claudia.rocha@email.com','senha39'),(40,'12345678940','Eduardo Lima Souza','2009-06-30','M',1,'11987654360','eduardo.lima@email.com','senha40');
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ano_letivo`
--

DROP TABLE IF EXISTS `ano_letivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ano_letivo` (
  `id_ano_letivo` int(11) NOT NULL AUTO_INCREMENT,
  `ano_letivo` int(11) NOT NULL,
  PRIMARY KEY (`id_ano_letivo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ano_letivo`
--

LOCK TABLES `ano_letivo` WRITE;
/*!40000 ALTER TABLE `ano_letivo` DISABLE KEYS */;
INSERT INTO `ano_letivo` VALUES (1,2023);
/*!40000 ALTER TABLE `ano_letivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aulas`
--

DROP TABLE IF EXISTS `aulas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aulas` (
  `id_aula` int(11) NOT NULL AUTO_INCREMENT,
  `data_aula` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sala_aula` int(11) NOT NULL,
  `disciplina_aula` int(11) NOT NULL,
  PRIMARY KEY (`id_aula`),
  KEY `disciplina_aula` (`disciplina_aula`),
  CONSTRAINT `aulas_ibfk_1` FOREIGN KEY (`disciplina_aula`) REFERENCES `professor` (`disciplina_professor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aulas`
--

LOCK TABLES `aulas` WRITE;
/*!40000 ALTER TABLE `aulas` DISABLE KEYS */;
/*!40000 ALTER TABLE `aulas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bimestres`
--

DROP TABLE IF EXISTS `bimestres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bimestres` (
  `id_bimestre` int(11) NOT NULL AUTO_INCREMENT,
  `nome_bimestre` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_bimestre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bimestres`
--

LOCK TABLES `bimestres` WRITE;
/*!40000 ALTER TABLE `bimestres` DISABLE KEYS */;
INSERT INTO `bimestres` VALUES (1,'1º Bimestre'),(2,'2º Bimestre'),(3,'3º Bimestre'),(4,'4º Bimestre');
/*!40000 ALTER TABLE `bimestres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disciplinas`
--

DROP TABLE IF EXISTS `disciplinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disciplinas` (
  `id_disciplina` int(11) NOT NULL AUTO_INCREMENT,
  `nome_disciplina` varchar(100) NOT NULL,
  PRIMARY KEY (`id_disciplina`),
  UNIQUE KEY `nome_disciplina` (`nome_disciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disciplinas`
--

LOCK TABLES `disciplinas` WRITE;
/*!40000 ALTER TABLE `disciplinas` DISABLE KEYS */;
INSERT INTO `disciplinas` VALUES (4,'Ciências'),(5,'Geografia'),(3,'História'),(2,'Matemática'),(6,'Não Possui'),(1,'Português');
/*!40000 ALTER TABLE `disciplinas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funcionario_instituicao`
--

DROP TABLE IF EXISTS `funcionario_instituicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funcionario_instituicao` (
  `id_funcionario` int(11) NOT NULL AUTO_INCREMENT,
  `cpf_funcionario` char(11) NOT NULL,
  `nome_funcionario` varchar(200) NOT NULL,
  `data_nascimento_funcionario` date NOT NULL,
  `sexo_funcionario` enum('M','F') NOT NULL,
  `situacao_funcionario` int(11) NOT NULL,
  `contato_funcionario` varchar(11) NOT NULL,
  `tipo_funcionario` int(11) NOT NULL,
  `email` varchar(120) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id_funcionario`),
  UNIQUE KEY `cpf_funcionario` (`cpf_funcionario`),
  UNIQUE KEY `email` (`email`),
  KEY `tipo_funcionario` (`tipo_funcionario`),
  KEY `situacao_funcionario` (`situacao_funcionario`),
  CONSTRAINT `funcionario_instituicao_ibfk_1` FOREIGN KEY (`tipo_funcionario`) REFERENCES `tipo_funcionario` (`id_tipo_funcionario`),
  CONSTRAINT `funcionario_instituicao_ibfk_2` FOREIGN KEY (`situacao_funcionario`) REFERENCES `situacao` (`id_situacao`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario_instituicao`
--

LOCK TABLES `funcionario_instituicao` WRITE;
/*!40000 ALTER TABLE `funcionario_instituicao` DISABLE KEYS */;
INSERT INTO `funcionario_instituicao` VALUES (1,'44368446844','João Pedro Abreu Rios','2002-12-26','M',1,'16992577068',2,'joaoarios@hotmail.com','$2y$10$ALREAVr/zTwkgB.Upa.J8uDHha4BRBLNghl743X9KAJrpmnbsyNbK'),(2,'44455566699','Ryan Machado Marques','2002-09-23','M',1,'16992577066',2,'ryanmarquesrj@hotmail.com','$2y$10$R9Ez./DOhogrvz2CFY4/0eGzJDefZdEMVj8cLIJBaKrXS8ULKGftK'),(3,'44455566686','Fabio Costa Silva','2000-12-12','M',1,'16992577089',2,'jpk1.loop@gmail.com','$2y$10$hA.hVOfwpmR60T3s5/08z.Q75RvbHkzZ7RHt2PjukHnPqwBAZ4HKa'),(4,'44455566653','Angela Correa Lima','1999-04-23','M',1,'16999877068',2,'ryossgesso@gmail.com','$2y$10$kmR2BcrkrS/nSe.LGsK.wuoXsjE.7A4qAA7cEJf5poTcFHBzSNZF6'),(5,'44468446844','Maria Borges Vieira','1987-01-05','F',1,'16992575075',2,'joaoarios2@outlook.com','$2y$10$3EECDRKSUA5PcxQ8Efg1u.i6plnJ3LPKk9nbSXJggBhd5ieZfH4UC');
/*!40000 ALTER TABLE `funcionario_instituicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instituicao`
--

DROP TABLE IF EXISTS `instituicao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `instituicao` (
  `id_instituicao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_instituicao` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(20) NOT NULL,
  PRIMARY KEY (`id_instituicao`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instituicao`
--

LOCK TABLES `instituicao` WRITE;
/*!40000 ALTER TABLE `instituicao` DISABLE KEYS */;
INSERT INTO `instituicao` VALUES (1,'TheSchool','tcc@email.com','1234');
/*!40000 ALTER TABLE `instituicao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mf_aluno`
--

DROP TABLE IF EXISTS `mf_aluno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mf_aluno` (
  `id_mf` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_mf` int(11) NOT NULL,
  `disciplina_mf` int(11) NOT NULL,
  `media_final` float NOT NULL,
  `sala_mf` int(11) NOT NULL,
  `situacao_mf` int(11) NOT NULL,
  PRIMARY KEY (`id_mf`),
  KEY `aluno_mf` (`aluno_mf`),
  KEY `disciplina_mf` (`disciplina_mf`),
  KEY `sala_mf` (`sala_mf`),
  KEY `situacao_mf` (`situacao_mf`),
  CONSTRAINT `mf_aluno_ibfk_1` FOREIGN KEY (`aluno_mf`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `mf_aluno_ibfk_2` FOREIGN KEY (`disciplina_mf`) REFERENCES `disciplinas` (`id_disciplina`),
  CONSTRAINT `mf_aluno_ibfk_3` FOREIGN KEY (`sala_mf`) REFERENCES `salas` (`id_sala`),
  CONSTRAINT `mf_aluno_ibfk_4` FOREIGN KEY (`situacao_mf`) REFERENCES `mf_situacao` (`id_st_mf`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mf_aluno`
--

LOCK TABLES `mf_aluno` WRITE;
/*!40000 ALTER TABLE `mf_aluno` DISABLE KEYS */;
INSERT INTO `mf_aluno` VALUES (1,1,1,0,1,1),(2,1,2,0,1,1),(3,1,3,0,1,1),(4,1,4,0,1,1),(5,1,5,0,1,1),(6,2,1,0,1,1),(7,2,2,0,1,1),(8,2,3,0,1,1),(9,2,4,0,1,1),(10,2,5,0,1,1),(11,3,1,0,1,1),(12,3,2,0,1,1),(13,3,3,0,1,1),(14,3,4,0,1,1),(15,3,5,0,1,1),(16,4,1,0,1,1),(17,4,2,0,1,1),(18,4,3,0,1,1),(19,4,4,0,1,1),(20,4,5,0,1,1),(21,5,1,0,1,1),(22,5,2,0,1,1),(23,5,3,0,1,1),(24,5,4,0,1,1),(25,5,5,0,1,1),(26,6,1,0,1,1),(27,6,2,0,1,1),(28,6,3,0,1,1),(29,6,4,0,1,1),(30,6,5,0,1,1),(31,7,1,0,1,1),(32,7,2,0,1,1),(33,7,3,0,1,1),(34,7,4,0,1,1),(35,7,5,0,1,1),(36,8,1,0,1,1),(37,8,2,0,1,1),(38,8,3,0,1,1),(39,8,4,0,1,1),(40,8,5,0,1,1),(41,9,1,0,1,1),(42,9,2,0,1,1),(43,9,3,0,1,1),(44,9,4,0,1,1),(45,9,5,0,1,1),(46,10,1,0,1,1),(47,10,2,0,1,1),(48,10,3,0,1,1),(49,10,4,0,1,1),(50,10,5,0,1,1);
/*!40000 ALTER TABLE `mf_aluno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mf_situacao`
--

DROP TABLE IF EXISTS `mf_situacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mf_situacao` (
  `id_st_mf` int(11) NOT NULL AUTO_INCREMENT,
  `nome_st_mf` varchar(20) NOT NULL,
  PRIMARY KEY (`id_st_mf`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mf_situacao`
--

LOCK TABLES `mf_situacao` WRITE;
/*!40000 ALTER TABLE `mf_situacao` DISABLE KEYS */;
INSERT INTO `mf_situacao` VALUES (1,'Indefinida'),(2,'Aprovado'),(3,'Reprovado');
/*!40000 ALTER TABLE `mf_situacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notas`
--

DROP TABLE IF EXISTS `notas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notas` (
  `id_nota` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_nota` int(11) NOT NULL,
  `disciplina_nota` int(11) NOT NULL,
  `sala_nota` int(11) NOT NULL,
  `bimestre_nota` int(11) NOT NULL,
  `nota1` float DEFAULT NULL,
  `nota2` float DEFAULT NULL,
  `nota3` float DEFAULT NULL,
  `media` float GENERATED ALWAYS AS ((`nota1` + `nota2` + `nota3`) / 3) STORED,
  PRIMARY KEY (`id_nota`),
  KEY `aluno_nota` (`aluno_nota`),
  KEY `disciplina_nota` (`disciplina_nota`),
  KEY `sala_nota` (`sala_nota`),
  KEY `bimestre_nota` (`bimestre_nota`),
  CONSTRAINT `notas_ibfk_1` FOREIGN KEY (`aluno_nota`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `notas_ibfk_2` FOREIGN KEY (`disciplina_nota`) REFERENCES `disciplinas` (`id_disciplina`),
  CONSTRAINT `notas_ibfk_3` FOREIGN KEY (`sala_nota`) REFERENCES `salas` (`id_sala`),
  CONSTRAINT `notas_ibfk_4` FOREIGN KEY (`bimestre_nota`) REFERENCES `bimestres` (`id_bimestre`)
) ENGINE=InnoDB AUTO_INCREMENT=201 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas`
--

LOCK TABLES `notas` WRITE;
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
INSERT INTO `notas` (`id_nota`, `aluno_nota`, `disciplina_nota`, `sala_nota`, `bimestre_nota`, `nota1`, `nota2`, `nota3`) VALUES (1,1,1,1,1,NULL,NULL,NULL),(2,1,1,1,2,NULL,NULL,NULL),(3,1,1,1,3,NULL,NULL,NULL),(4,1,1,1,4,NULL,NULL,NULL),(5,1,2,1,1,NULL,NULL,NULL),(6,1,2,1,2,NULL,NULL,NULL),(7,1,2,1,3,NULL,NULL,NULL),(8,1,2,1,4,NULL,NULL,NULL),(9,1,3,1,1,NULL,NULL,NULL),(10,1,3,1,2,NULL,NULL,NULL),(11,1,3,1,3,NULL,NULL,NULL),(12,1,3,1,4,NULL,NULL,NULL),(13,1,4,1,1,NULL,NULL,NULL),(14,1,4,1,2,NULL,NULL,NULL),(15,1,4,1,3,NULL,NULL,NULL),(16,1,4,1,4,NULL,NULL,NULL),(17,1,5,1,1,NULL,NULL,NULL),(18,1,5,1,2,NULL,NULL,NULL),(19,1,5,1,3,NULL,NULL,NULL),(20,1,5,1,4,NULL,NULL,NULL),(21,2,1,1,1,NULL,NULL,NULL),(22,2,1,1,2,NULL,NULL,NULL),(23,2,1,1,3,NULL,NULL,NULL),(24,2,1,1,4,NULL,NULL,NULL),(25,2,2,1,1,NULL,NULL,NULL),(26,2,2,1,2,NULL,NULL,NULL),(27,2,2,1,3,NULL,NULL,NULL),(28,2,2,1,4,NULL,NULL,NULL),(29,2,3,1,1,NULL,NULL,NULL),(30,2,3,1,2,NULL,NULL,NULL),(31,2,3,1,3,NULL,NULL,NULL),(32,2,3,1,4,NULL,NULL,NULL),(33,2,4,1,1,NULL,NULL,NULL),(34,2,4,1,2,NULL,NULL,NULL),(35,2,4,1,3,NULL,NULL,NULL),(36,2,4,1,4,NULL,NULL,NULL),(37,2,5,1,1,NULL,NULL,NULL),(38,2,5,1,2,NULL,NULL,NULL),(39,2,5,1,3,NULL,NULL,NULL),(40,2,5,1,4,NULL,NULL,NULL),(41,3,1,1,1,NULL,NULL,NULL),(42,3,1,1,2,NULL,NULL,NULL),(43,3,1,1,3,NULL,NULL,NULL),(44,3,1,1,4,NULL,NULL,NULL),(45,3,2,1,1,NULL,NULL,NULL),(46,3,2,1,2,NULL,NULL,NULL),(47,3,2,1,3,NULL,NULL,NULL),(48,3,2,1,4,NULL,NULL,NULL),(49,3,3,1,1,NULL,NULL,NULL),(50,3,3,1,2,NULL,NULL,NULL),(51,3,3,1,3,NULL,NULL,NULL),(52,3,3,1,4,NULL,NULL,NULL),(53,3,4,1,1,NULL,NULL,NULL),(54,3,4,1,2,NULL,NULL,NULL),(55,3,4,1,3,NULL,NULL,NULL),(56,3,4,1,4,NULL,NULL,NULL),(57,3,5,1,1,NULL,NULL,NULL),(58,3,5,1,2,NULL,NULL,NULL),(59,3,5,1,3,NULL,NULL,NULL),(60,3,5,1,4,NULL,NULL,NULL),(61,4,1,1,1,NULL,NULL,NULL),(62,4,1,1,2,NULL,NULL,NULL),(63,4,1,1,3,NULL,NULL,NULL),(64,4,1,1,4,NULL,NULL,NULL),(65,4,2,1,1,NULL,NULL,NULL),(66,4,2,1,2,NULL,NULL,NULL),(67,4,2,1,3,NULL,NULL,NULL),(68,4,2,1,4,NULL,NULL,NULL),(69,4,3,1,1,NULL,NULL,NULL),(70,4,3,1,2,NULL,NULL,NULL),(71,4,3,1,3,NULL,NULL,NULL),(72,4,3,1,4,NULL,NULL,NULL),(73,4,4,1,1,NULL,NULL,NULL),(74,4,4,1,2,NULL,NULL,NULL),(75,4,4,1,3,NULL,NULL,NULL),(76,4,4,1,4,NULL,NULL,NULL),(77,4,5,1,1,NULL,NULL,NULL),(78,4,5,1,2,NULL,NULL,NULL),(79,4,5,1,3,NULL,NULL,NULL),(80,4,5,1,4,NULL,NULL,NULL),(81,5,1,1,1,NULL,NULL,NULL),(82,5,1,1,2,NULL,NULL,NULL),(83,5,1,1,3,NULL,NULL,NULL),(84,5,1,1,4,NULL,NULL,NULL),(85,5,2,1,1,NULL,NULL,NULL),(86,5,2,1,2,NULL,NULL,NULL),(87,5,2,1,3,NULL,NULL,NULL),(88,5,2,1,4,NULL,NULL,NULL),(89,5,3,1,1,NULL,NULL,NULL),(90,5,3,1,2,NULL,NULL,NULL),(91,5,3,1,3,NULL,NULL,NULL),(92,5,3,1,4,NULL,NULL,NULL),(93,5,4,1,1,NULL,NULL,NULL),(94,5,4,1,2,NULL,NULL,NULL),(95,5,4,1,3,NULL,NULL,NULL),(96,5,4,1,4,NULL,NULL,NULL),(97,5,5,1,1,NULL,NULL,NULL),(98,5,5,1,2,NULL,NULL,NULL),(99,5,5,1,3,NULL,NULL,NULL),(100,5,5,1,4,NULL,NULL,NULL),(101,6,1,1,1,NULL,NULL,NULL),(102,6,1,1,2,NULL,NULL,NULL),(103,6,1,1,3,NULL,NULL,NULL),(104,6,1,1,4,NULL,NULL,NULL),(105,6,2,1,1,NULL,NULL,NULL),(106,6,2,1,2,NULL,NULL,NULL),(107,6,2,1,3,NULL,NULL,NULL),(108,6,2,1,4,NULL,NULL,NULL),(109,6,3,1,1,NULL,NULL,NULL),(110,6,3,1,2,NULL,NULL,NULL),(111,6,3,1,3,NULL,NULL,NULL),(112,6,3,1,4,NULL,NULL,NULL),(113,6,4,1,1,NULL,NULL,NULL),(114,6,4,1,2,NULL,NULL,NULL),(115,6,4,1,3,NULL,NULL,NULL),(116,6,4,1,4,NULL,NULL,NULL),(117,6,5,1,1,NULL,NULL,NULL),(118,6,5,1,2,NULL,NULL,NULL),(119,6,5,1,3,NULL,NULL,NULL),(120,6,5,1,4,NULL,NULL,NULL),(121,7,1,1,1,NULL,NULL,NULL),(122,7,1,1,2,NULL,NULL,NULL),(123,7,1,1,3,NULL,NULL,NULL),(124,7,1,1,4,NULL,NULL,NULL),(125,7,2,1,1,NULL,NULL,NULL),(126,7,2,1,2,NULL,NULL,NULL),(127,7,2,1,3,NULL,NULL,NULL),(128,7,2,1,4,NULL,NULL,NULL),(129,7,3,1,1,NULL,NULL,NULL),(130,7,3,1,2,NULL,NULL,NULL),(131,7,3,1,3,NULL,NULL,NULL),(132,7,3,1,4,NULL,NULL,NULL),(133,7,4,1,1,NULL,NULL,NULL),(134,7,4,1,2,NULL,NULL,NULL),(135,7,4,1,3,NULL,NULL,NULL),(136,7,4,1,4,NULL,NULL,NULL),(137,7,5,1,1,NULL,NULL,NULL),(138,7,5,1,2,NULL,NULL,NULL),(139,7,5,1,3,NULL,NULL,NULL),(140,7,5,1,4,NULL,NULL,NULL),(141,8,1,1,1,NULL,NULL,NULL),(142,8,1,1,2,NULL,NULL,NULL),(143,8,1,1,3,NULL,NULL,NULL),(144,8,1,1,4,NULL,NULL,NULL),(145,8,2,1,1,NULL,NULL,NULL),(146,8,2,1,2,NULL,NULL,NULL),(147,8,2,1,3,NULL,NULL,NULL),(148,8,2,1,4,NULL,NULL,NULL),(149,8,3,1,1,NULL,NULL,NULL),(150,8,3,1,2,NULL,NULL,NULL),(151,8,3,1,3,NULL,NULL,NULL),(152,8,3,1,4,NULL,NULL,NULL),(153,8,4,1,1,NULL,NULL,NULL),(154,8,4,1,2,NULL,NULL,NULL),(155,8,4,1,3,NULL,NULL,NULL),(156,8,4,1,4,NULL,NULL,NULL),(157,8,5,1,1,NULL,NULL,NULL),(158,8,5,1,2,NULL,NULL,NULL),(159,8,5,1,3,NULL,NULL,NULL),(160,8,5,1,4,NULL,NULL,NULL),(161,9,1,1,1,NULL,NULL,NULL),(162,9,1,1,2,NULL,NULL,NULL),(163,9,1,1,3,NULL,NULL,NULL),(164,9,1,1,4,NULL,NULL,NULL),(165,9,2,1,1,NULL,NULL,NULL),(166,9,2,1,2,NULL,NULL,NULL),(167,9,2,1,3,NULL,NULL,NULL),(168,9,2,1,4,NULL,NULL,NULL),(169,9,3,1,1,NULL,NULL,NULL),(170,9,3,1,2,NULL,NULL,NULL),(171,9,3,1,3,NULL,NULL,NULL),(172,9,3,1,4,NULL,NULL,NULL),(173,9,4,1,1,NULL,NULL,NULL),(174,9,4,1,2,NULL,NULL,NULL),(175,9,4,1,3,NULL,NULL,NULL),(176,9,4,1,4,NULL,NULL,NULL),(177,9,5,1,1,NULL,NULL,NULL),(178,9,5,1,2,NULL,NULL,NULL),(179,9,5,1,3,NULL,NULL,NULL),(180,9,5,1,4,NULL,NULL,NULL),(181,10,1,1,1,NULL,NULL,NULL),(182,10,1,1,2,NULL,NULL,NULL),(183,10,1,1,3,NULL,NULL,NULL),(184,10,1,1,4,NULL,NULL,NULL),(185,10,2,1,1,NULL,NULL,NULL),(186,10,2,1,2,NULL,NULL,NULL),(187,10,2,1,3,NULL,NULL,NULL),(188,10,2,1,4,NULL,NULL,NULL),(189,10,3,1,1,NULL,NULL,NULL),(190,10,3,1,2,NULL,NULL,NULL),(191,10,3,1,3,NULL,NULL,NULL),(192,10,3,1,4,NULL,NULL,NULL),(193,10,4,1,1,NULL,NULL,NULL),(194,10,4,1,2,NULL,NULL,NULL),(195,10,4,1,3,NULL,NULL,NULL),(196,10,4,1,4,NULL,NULL,NULL),(197,10,5,1,1,NULL,NULL,NULL),(198,10,5,1,2,NULL,NULL,NULL),(199,10,5,1,3,NULL,NULL,NULL),(200,10,5,1,4,NULL,NULL,NULL);
/*!40000 ALTER TABLE `notas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `presenca_aulas`
--

DROP TABLE IF EXISTS `presenca_aulas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `presenca_aulas` (
  `id_presenca` int(11) NOT NULL AUTO_INCREMENT,
  `aluno_presenca` int(11) NOT NULL,
  `aula_presenca` enum('P','A') NOT NULL,
  `aula_realizada` int(11) NOT NULL,
  PRIMARY KEY (`id_presenca`),
  KEY `aluno_presenca` (`aluno_presenca`),
  KEY `aula_realizada` (`aula_realizada`),
  CONSTRAINT `presenca_aulas_ibfk_1` FOREIGN KEY (`aluno_presenca`) REFERENCES `aluno` (`id_aluno`),
  CONSTRAINT `presenca_aulas_ibfk_2` FOREIGN KEY (`aula_realizada`) REFERENCES `aulas` (`id_aula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presenca_aulas`
--

LOCK TABLES `presenca_aulas` WRITE;
/*!40000 ALTER TABLE `presenca_aulas` DISABLE KEYS */;
/*!40000 ALTER TABLE `presenca_aulas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professor`
--

DROP TABLE IF EXISTS `professor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `professor` (
  `id_professor` int(11) NOT NULL AUTO_INCREMENT,
  `id_prof_func` int(11) NOT NULL,
  `disciplina_professor` int(11) NOT NULL,
  PRIMARY KEY (`id_professor`),
  KEY `id_prof_func` (`id_prof_func`),
  KEY `disciplina_professor` (`disciplina_professor`),
  CONSTRAINT `professor_ibfk_1` FOREIGN KEY (`id_prof_func`) REFERENCES `funcionario_instituicao` (`id_funcionario`),
  CONSTRAINT `professor_ibfk_2` FOREIGN KEY (`disciplina_professor`) REFERENCES `disciplinas` (`id_disciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professor`
--

LOCK TABLES `professor` WRITE;
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` VALUES (1,1,1),(2,2,2),(3,3,4),(4,4,3),(5,5,5);
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala_alunos`
--

LOCK TABLES `sala_alunos` WRITE;
/*!40000 ALTER TABLE `sala_alunos` DISABLE KEYS */;
INSERT INTO `sala_alunos` VALUES (1,1,1,1),(2,2,1,1),(3,3,1,1),(4,4,1,1),(5,5,1,1),(6,6,1,1),(7,7,1,1),(8,8,1,1),(9,9,1,1),(10,10,1,1);
/*!40000 ALTER TABLE `sala_alunos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sala_professor`
--

DROP TABLE IF EXISTS `sala_professor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sala_professor` (
  `id_sp` int(11) NOT NULL AUTO_INCREMENT,
  `professor_sp` int(11) NOT NULL,
  `sala_sp` int(11) NOT NULL,
  PRIMARY KEY (`id_sp`),
  KEY `professor_sp` (`professor_sp`),
  KEY `sala_sp` (`sala_sp`),
  CONSTRAINT `sala_professor_ibfk_1` FOREIGN KEY (`professor_sp`) REFERENCES `professor` (`id_professor`),
  CONSTRAINT `sala_professor_ibfk_2` FOREIGN KEY (`sala_sp`) REFERENCES `salas` (`id_sala`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala_professor`
--

LOCK TABLES `sala_professor` WRITE;
/*!40000 ALTER TABLE `sala_professor` DISABLE KEYS */;
INSERT INTO `sala_professor` VALUES (1,4,1),(2,3,1),(3,1,1),(4,5,1),(5,2,1);
/*!40000 ALTER TABLE `sala_professor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salas`
--

DROP TABLE IF EXISTS `salas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `salas` (
  `id_sala` int(11) NOT NULL AUTO_INCREMENT,
  `ano_sala` int(11) NOT NULL,
  `serie_sala` int(11) NOT NULL,
  `ativa_sala` int(11) NOT NULL,
  PRIMARY KEY (`id_sala`),
  KEY `ativa_sala` (`ativa_sala`),
  KEY `serie_sala` (`serie_sala`),
  CONSTRAINT `salas_ibfk_1` FOREIGN KEY (`ativa_sala`) REFERENCES `situacao` (`id_situacao`),
  CONSTRAINT `salas_ibfk_2` FOREIGN KEY (`serie_sala`) REFERENCES `serie` (`id_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salas`
--

LOCK TABLES `salas` WRITE;
/*!40000 ALTER TABLE `salas` DISABLE KEYS */;
INSERT INTO `salas` VALUES (1,2023,1,1);
/*!40000 ALTER TABLE `salas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `serie`
--

DROP TABLE IF EXISTS `serie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `serie` (
  `id_serie` int(11) NOT NULL AUTO_INCREMENT,
  `nome_serie` varchar(25) NOT NULL,
  `disciplina1` int(11) NOT NULL,
  `disciplina2` int(11) NOT NULL,
  `disciplina3` int(11) NOT NULL,
  `disciplina4` int(11) NOT NULL,
  `disciplina5` int(11) NOT NULL,
  PRIMARY KEY (`id_serie`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `serie`
--

LOCK TABLES `serie` WRITE;
/*!40000 ALTER TABLE `serie` DISABLE KEYS */;
INSERT INTO `serie` VALUES (1,'6º Ano',1,2,3,4,5),(2,'7º Ano',1,2,3,4,5),(3,'8º Ano',1,2,3,4,5),(4,'9º Ano',1,2,3,4,5);
/*!40000 ALTER TABLE `serie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `situacao`
--

DROP TABLE IF EXISTS `situacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `situacao` (
  `id_situacao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_situacao` varchar(20) NOT NULL,
  PRIMARY KEY (`id_situacao`),
  UNIQUE KEY `nome_situacao` (`nome_situacao`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `situacao`
--

LOCK TABLES `situacao` WRITE;
/*!40000 ALTER TABLE `situacao` DISABLE KEYS */;
INSERT INTO `situacao` VALUES (1,'Ativo'),(2,'Inativo');
/*!40000 ALTER TABLE `situacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_funcionario`
--

DROP TABLE IF EXISTS `tipo_funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_funcionario` (
  `id_tipo_funcionario` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tipo_funcionario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_funcionario`
--

LOCK TABLES `tipo_funcionario` WRITE;
/*!40000 ALTER TABLE `tipo_funcionario` DISABLE KEYS */;
INSERT INTO `tipo_funcionario` VALUES (1,'Administrativo'),(2,'Professor');
/*!40000 ALTER TABLE `tipo_funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'bd_tcc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-11-18 16:13:02
