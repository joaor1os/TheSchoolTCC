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
INSERT INTO `aluno` VALUES (1,'12345678901','João Silva Santos','2013-05-15','M',1,'11987654321','joao.silva@email.com','senha123'),(2,'12345678902','Maria Oliveira Costa','2013-03-22','F',1,'11987654322','maria.oliveira@email.com','senha123'),(3,'12345678903','Pedro Souza Lima','2013-07-11','M',1,'11987654323','pedro.souza@email.com','senha123'),(4,'12345678904','Ana Costa Pereira','2013-02-18','F',1,'11987654324','ana.costa@email.com','senha123'),(5,'12345678905','Carlos Lima Rocha','2013-10-05','M',1,'11987654325','carlos.lima@email.com','senha123'),(6,'12345678906','Larissa Santos Almeida','2013-06-13','F',1,'11987654326','larissa.santos@email.com','senha123'),(7,'12345678907','Gustavo Pereira Silva','2013-04-02','M',1,'11987654327','gustavo.pereira@email.com','senha123'),(8,'12345678908','Julia Fernandes Costa','2013-08-29','F',1,'11987654328','julia.fernandes@email.com','senha123'),(9,'12345678909','Lucas Almeida Souza','2013-01-30','M',1,'11987654329','lucas.almeida@email.com','senha123'),(10,'12345678910','Beatriz Rocha Lima','2013-09-09','F',1,'11987654330','beatriz.rocha@email.com','senha123'),(11,'12345678911','Rafael Martins Souza','2012-06-15','M',1,'11987654331','rafael.martins@email.com','senha123'),(12,'12345678912','Fernanda Ribeiro Silva','2012-01-28','F',1,'11987654332','fernanda.ribeiro@email.com','senha123'),(13,'12345678913','Vinícius Castro Pereira','2012-11-03','M',1,'11987654333','vinicius.castro@email.com','senha123'),(14,'12345678914','Marcela Dias Almeida','2012-04-20','F',1,'11987654334','marcela.dias@email.com','senha123'),(15,'12345678915','Bruno Gomes Rocha','2012-07-09','M',1,'11987654335','bruno.gomes@email.com','senha123'),(16,'12345678916','Amanda Silva Santos','2012-12-01','F',1,'11987654336','amanda.silva@email.com','senha123'),(17,'12345678917','Diego Oliveira Costa','2012-02-14','M',1,'11987654337','diego.oliveira@email.com','senha123'),(18,'12345678918','Camila Souza Lima','2012-09-05','F',1,'11987654338','camila.souza@email.com','senha123'),(19,'12345678919','Felipe Pereira Rocha','2012-05-10','M',1,'11987654339','felipe.pereira@email.com','senha123'),(20,'12345678920','Isabela Costa Almeida','2012-08-27','F',1,'11987654340','isabela.costa@email.com','senha123'),(21,'12345678921','Amanda Souza Lima','2010-06-25','F',1,'11987654341','amanda.souza@email.com','senha123'),(22,'12345678922','Lucas Martins Pereira','2010-03-12','M',1,'11987654342','lucas.martins@email.com','senha123'),(23,'12345678923','Vanessa Lima Rocha','2010-08-18','F',1,'11987654343','vanessa.lima@email.com','senha123'),(24,'12345678924','Roberto Silva Costa','2010-12-03','M',1,'11987654344','roberto.silva@email.com','senha123'),(25,'12345678925','Juliana Costa Pereira','2010-04-20','F',1,'11987654345','juliana.costa@email.com','senha123'),(26,'12345678926','Carlos Almeida Silva','2010-10-01','M',1,'11987654346','carlos.almeida@email.com','senha123'),(27,'12345678927','Gustavo Ferreira Lima','2010-07-14','M',1,'11987654347','gustavo.ferreira@email.com','senha123'),(28,'12345678928','Aline Santos Pereira','2010-09-22','F',1,'11987654348','aline.santos@email.com','senha123'),(29,'12345678929','Mário Rocha Almeida','2010-11-10','M',1,'11987654349','mario.rocha@email.com','senha123'),(30,'12345678930','Sofia Oliveira Costa','2010-05-30','F',1,'11987654350','sofia.oliveira@email.com','senha123'),(31,'12345678931','Renato Ferreira Silva','2009-01-10','M',1,'11987654351','renato.ferreira@email.com','senha123'),(32,'12345678932','Cláudia Mendes Souza','2009-11-25','F',1,'11987654352','claudia.mendes@email.com','senha123'),(33,'12345678933','Márcio Rocha Costa','2009-06-30','M',1,'11987654353','marcio.rocha@email.com','senha123'),(34,'12345678934','Patrícia Almeida Lima','2009-04-12','F',1,'11987654354','patricia.almeida@email.com','senha123'),(35,'12345678935','Eduardo Costa Pereira','2009-07-07','M',1,'11987654355','eduardo.costa@email.com','senha123'),(36,'12345678936','Isabel Santos Lima','2009-02-22','F',1,'11987654356','isabel.santos@email.com','senha123'),(37,'12345678937','Rogério Lima Pereira','2009-09-04','M',1,'11987654357','rogerio.lima@email.com','senha123'),(38,'12345678938','Elaine Souza Rocha','2009-12-15','F',1,'11987654358','elaine.souza@email.com','senha123'),(39,'12345678939','Fernando Oliveira Lima','2009-03-19','M',1,'11987654359','fernando.oliveira@email.com','senha123'),(40,'12345678940','Carla Martins Souza','2009-10-25','F',1,'11987654360','carla.martins@email.com','senha123');
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
INSERT INTO `ano_letivo` VALUES (1,2024);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funcionario_instituicao`
--

LOCK TABLES `funcionario_instituicao` WRITE;
/*!40000 ALTER TABLE `funcionario_instituicao` DISABLE KEYS */;
INSERT INTO `funcionario_instituicao` VALUES (1,'44455566677','Joao','1111-11-11','M',1,'1235671212',2,'joaoarios@hotmail.com','$2y$10$oM13Mo/DwScfW3FSj84Yy.iohUakKtfoHwcNjnOjo1jwXgDC9uqy6');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mf_aluno`
--

LOCK TABLES `mf_aluno` WRITE;
/*!40000 ALTER TABLE `mf_aluno` DISABLE KEYS */;
INSERT INTO `mf_aluno` VALUES (1,1,1,0,1,1),(2,1,2,0,1,1),(3,1,3,0,1,1),(4,1,4,0,1,1),(5,1,5,6,1,2),(6,4,1,0,1,1),(7,4,2,0,1,1),(8,4,3,0,1,1),(9,4,4,0,1,1),(10,4,5,7,1,2);
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notas`
--

LOCK TABLES `notas` WRITE;
/*!40000 ALTER TABLE `notas` DISABLE KEYS */;
INSERT INTO `notas` (`id_nota`, `aluno_nota`, `disciplina_nota`, `sala_nota`, `bimestre_nota`, `nota1`, `nota2`, `nota3`) VALUES (1,1,1,1,1,NULL,NULL,NULL),(2,1,1,1,2,NULL,NULL,NULL),(3,1,1,1,3,NULL,NULL,NULL),(4,1,1,1,4,NULL,NULL,NULL),(5,1,2,1,1,NULL,NULL,NULL),(6,1,2,1,2,NULL,NULL,NULL),(7,1,2,1,3,NULL,NULL,NULL),(8,1,2,1,4,NULL,NULL,NULL),(9,1,3,1,1,NULL,NULL,NULL),(10,1,3,1,2,NULL,NULL,NULL),(11,1,3,1,3,NULL,NULL,NULL),(12,1,3,1,4,NULL,NULL,NULL),(13,1,4,1,1,NULL,NULL,NULL),(14,1,4,1,2,NULL,NULL,NULL),(15,1,4,1,3,NULL,NULL,NULL),(16,1,4,1,4,NULL,NULL,NULL),(17,1,5,1,1,10,8,7),(18,1,5,1,2,6,6,6),(19,1,5,1,3,6,6,6),(20,1,5,1,4,6,6,6),(21,4,1,1,1,NULL,NULL,NULL),(22,4,1,1,2,NULL,NULL,NULL),(23,4,1,1,3,NULL,NULL,NULL),(24,4,1,1,4,NULL,NULL,NULL),(25,4,2,1,1,NULL,NULL,NULL),(26,4,2,1,2,NULL,NULL,NULL),(27,4,2,1,3,NULL,NULL,NULL),(28,4,2,1,4,NULL,NULL,NULL),(29,4,3,1,1,NULL,NULL,NULL),(30,4,3,1,2,NULL,NULL,NULL),(31,4,3,1,3,NULL,NULL,NULL),(32,4,3,1,4,NULL,NULL,NULL),(33,4,4,1,1,NULL,NULL,NULL),(34,4,4,1,2,NULL,NULL,NULL),(35,4,4,1,3,NULL,NULL,NULL),(36,4,4,1,4,NULL,NULL,NULL),(37,4,5,1,1,10,10,10),(38,4,5,1,2,6,6,6),(39,4,5,1,3,6,6,6),(40,4,5,1,4,6,6,6);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professor`
--

LOCK TABLES `professor` WRITE;
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` VALUES (1,1,5);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sala_alunos`
--

LOCK TABLES `sala_alunos` WRITE;
/*!40000 ALTER TABLE `sala_alunos` DISABLE KEYS */;
INSERT INTO `sala_alunos` VALUES (1,1,1,1),(2,4,1,1);
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

-- Dump completed on 2024-11-16  1:33:31
