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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aulas`
--

LOCK TABLES `aulas` WRITE;
/*!40000 ALTER TABLE `aulas` DISABLE KEYS */;
INSERT INTO `aulas` VALUES (1,'2024-11-15 08:57:18',1,4);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario_instituicao`
--

LOCK TABLES `funcionario_instituicao` WRITE;
/*!40000 ALTER TABLE `funcionario_instituicao` DISABLE KEYS */;
INSERT INTO `funcionario_instituicao` VALUES (1,'44368446844','Joao','2002-12-26','M',1,'16992577068',2,'joaoarios@hotmail.com','$2y$10$04YKMfinoyQ9ioP8bPdrne8FVxCxP2ks35XgY8cXjZpdqtEQ/j7JW');
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
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas`
--

LOCK TABLES `notas` WRITE;
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
INSERT INTO `notas` (`id_nota`, `aluno_nota`, `disciplina_nota`, `sala_nota`, `bimestre_nota`, `nota1`, `nota2`, `nota3`) VALUES (1,7,1,1,1,NULL,NULL,NULL),(2,7,1,1,2,NULL,NULL,NULL),(3,7,1,1,3,NULL,NULL,NULL),(4,7,1,1,4,NULL,NULL,NULL),(5,7,2,1,1,NULL,NULL,NULL),(6,7,2,1,2,NULL,NULL,NULL),(7,7,2,1,3,NULL,NULL,NULL),(8,7,2,1,4,NULL,NULL,NULL),(9,7,3,1,1,NULL,NULL,NULL),(10,7,3,1,2,NULL,NULL,NULL),(11,7,3,1,3,NULL,NULL,NULL),(12,7,3,1,4,NULL,NULL,NULL),(13,7,4,1,1,1,7,9),(14,7,4,1,2,0,0,0),(15,7,4,1,3,10,10,10),(16,7,4,1,4,0,0,0),(17,7,5,1,1,NULL,NULL,NULL),(18,7,5,1,2,NULL,NULL,NULL),(19,7,5,1,3,NULL,NULL,NULL),(20,7,5,1,4,NULL,NULL,NULL),(21,7,1,1,1,NULL,NULL,NULL),(22,7,1,1,2,NULL,NULL,NULL),(23,7,1,1,3,NULL,NULL,NULL),(24,7,1,1,4,NULL,NULL,NULL),(25,7,2,1,1,NULL,NULL,NULL),(26,7,2,1,2,NULL,NULL,NULL),(27,7,2,1,3,NULL,NULL,NULL),(28,7,2,1,4,NULL,NULL,NULL),(29,7,3,1,1,NULL,NULL,NULL),(30,7,3,1,2,NULL,NULL,NULL),(31,7,3,1,3,NULL,NULL,NULL),(32,7,3,1,4,NULL,NULL,NULL),(33,7,4,1,1,0,0,0),(34,7,4,1,2,0,0,0),(35,7,4,1,3,0,0,0),(36,7,4,1,4,0,0,0),(37,7,5,1,1,NULL,NULL,NULL),(38,7,5,1,2,NULL,NULL,NULL),(39,7,5,1,3,NULL,NULL,NULL),(40,7,5,1,4,NULL,NULL,NULL),(41,10,1,1,1,NULL,NULL,NULL),(42,10,1,1,2,NULL,NULL,NULL),(43,10,1,1,3,NULL,NULL,NULL),(44,10,1,1,4,NULL,NULL,NULL),(45,10,2,1,1,NULL,NULL,NULL),(46,10,2,1,2,NULL,NULL,NULL),(47,10,2,1,3,NULL,NULL,NULL),(48,10,2,1,4,NULL,NULL,NULL),(49,10,3,1,1,NULL,NULL,NULL),(50,10,3,1,2,NULL,NULL,NULL),(51,10,3,1,3,NULL,NULL,NULL),(52,10,3,1,4,NULL,NULL,NULL),(53,10,4,1,1,7.88,10,3.32),(54,10,4,1,2,0,0,0),(55,10,4,1,3,0,0,0),(56,10,4,1,4,NULL,NULL,NULL),(57,10,5,1,1,NULL,NULL,NULL),(58,10,5,1,2,NULL,NULL,NULL),(59,10,5,1,3,NULL,NULL,NULL),(60,10,5,1,4,NULL,NULL,NULL),(61,10,1,1,1,NULL,NULL,NULL),(62,10,1,1,2,NULL,NULL,NULL),(63,10,1,1,3,NULL,NULL,NULL),(64,10,1,1,4,NULL,NULL,NULL),(65,10,2,1,1,NULL,NULL,NULL),(66,10,2,1,2,NULL,NULL,NULL),(67,10,2,1,3,NULL,NULL,NULL),(68,10,2,1,4,NULL,NULL,NULL),(69,10,3,1,1,NULL,NULL,NULL),(70,10,3,1,2,NULL,NULL,NULL),(71,10,3,1,3,NULL,NULL,NULL),(72,10,3,1,4,NULL,NULL,NULL),(73,10,4,1,1,0,0,0),(74,10,4,1,2,0,0,0),(75,10,4,1,3,0,0,0),(76,10,4,1,4,0,0,0),(77,10,5,1,1,NULL,NULL,NULL),(78,10,5,1,2,NULL,NULL,NULL),(79,10,5,1,3,NULL,NULL,NULL),(80,10,5,1,4,NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `presenca_aulas`
--

LOCK TABLES `presenca_aulas` WRITE;
/*!40000 ALTER TABLE `presenca_aulas` DISABLE KEYS */;
INSERT INTO `presenca_aulas` VALUES (1,1,'P',1),(2,2,'P',1),(3,8,'P',1),(4,7,'P',1),(5,10,'P',1);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professor`
--

LOCK TABLES `professor` WRITE;
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` VALUES (1,1,4);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala_alunos`
--

LOCK TABLES `sala_alunos` WRITE;
/*!40000 ALTER TABLE `sala_alunos` DISABLE KEYS */;
INSERT INTO `sala_alunos` VALUES (1,1,1,1),(2,2,1,1),(3,8,1,1),(4,5,1,2),(5,7,1,1),(6,10,1,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala_professor`
--

LOCK TABLES `sala_professor` WRITE;
/*!40000 ALTER TABLE `sala_professor` DISABLE KEYS */;
INSERT INTO `sala_professor` VALUES (1,1,1);
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
INSERT INTO `salas` VALUES (1,2024,1,1);
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

-- Dump completed on 2024-11-15  3:11:56
