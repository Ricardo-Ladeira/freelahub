-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 04, 2025 at 01:06 PM
-- Server version: 8.0.40-cll-lve
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;

--
-- Database: `freelahub`
--
CREATE DATABASE IF NOT EXISTS `freelahub` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `freelahub`;

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `p_telefone` varchar(25) NOT NULL,
  `p_tipo_servico` varchar(80) NOT NULL,
  `p_experiencia` varchar(25) NOT NULL,
  `p_descricao` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `p_telefone` (`p_telefone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`id`, `p_telefone`, `p_tipo_servico`, `p_experiencia`, `p_descricao`) VALUES
(1, '--', '--', 'Avançado', '--'),
(2, '1', 'Técnico', 'Iniciante', 'Teste de Software'),
(4, '2', 'Jardinagem', 'Iniciante', 'Jardineiro Amador'),
(7, '3', 'Jardinagem', 'Intermediário', 'Jardineiro avançado'),
(11, '4', 'Cozinheiro', 'Intermediário', 'Cozinha Brasileira'),
(15, '5', 'Jardinagem', 'Avançado', 'Artista'),
(18, '6', 'Uber', 'Avançado', 'Uber Black'),
(20, '7', 'Bartender', 'Avançado', '30 anos de bar');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `u_email` varchar(100) NOT NULL,
  `u_senha` varchar(128) NOT NULL,
  `u_nome` varchar(80) NOT NULL,
  `u_dt_nascimento` date NOT NULL,
  `u_cidade` varchar(80) DEFAULT NULL,
  `u_uf` varchar(2) DEFAULT NULL,
  `p_id_perfil` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_email` (`u_email`),
  KEY `fk_usuario_perfil` (`p_id_perfil`),
  CONSTRAINT `fk_usuario_perfil` FOREIGN KEY (`p_id_perfil`) 
    REFERENCES `perfil` (`id`) 
    ON DELETE RESTRICT
    ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `u_email`, `u_senha`, `u_nome`, `u_dt_nascimento`, `u_cidade`, `u_uf`, `p_id_perfil`) VALUES
(1, 'adm@freela.com', '$2y$10$HL2AV8L/H7uuv3hUhQSw/OWBiHo2IZikP/5KW.XbUT3k5P3UkUvTm', 'Administrador', '1901-01-01', '--', '--', 1),
(2, 'num1@ab.com', '$2y$10$eaz83oa3Ne37gHsrDdeFO.zph7aE9XY8Y3BFzEu4E5K5SqJwckxYC', 'Numero 1', '2025-04-29', 'são paulo', 'SP', 2),
(3, 'num2@ab.com', '$2y$10$BkBXk5RT4IwKFuH5Plwq.OBqZw8rA4d6QYAO7SNNQ8cd4OHRrwqVu', 'Numero 2', '2025-05-22', 'são paulo', 'SP', 4),
(5, 'num3@ab.com', '$2y$10$LxY3DKlUl3tNvq2n74226.RLQplZq/tr1jogyiQ8cjpPIVibKNGqG', 'Numero 3', '2025-05-28', 'Curitiba', 'PR', 7),
(6, 'num4@ab.com', '$2y$10$KBsHTejC6ti3C/HdtctgeuZGzAKoASI6Tb5ARMn3LwT7foZnDN8KW', 'Numero 4', '2025-04-29', 'Curitiba', 'PR', 11),
(8, 'num5@ab.com', '$2y$10$XVyUF85cp3t6pwB5qBNQ0uFLyAHn4XDaMoTHZU/BklqNR.R9kM.lW', 'Numero 5', '2025-04-16', 'SJC', 'PR', 15),
(10, 'num6@ab.com', '$2y$10$eNKt6dRd8uRK2G/ezMgvceqPor4ts00uzWZ2Y676skBRVVdPBJRa.', 'Numero 6', '2025-05-20', 'Rio de Janeiro ', 'RJ', 18),
(12, 'num7@ab.com', '$2y$10$ohDapoP.izSIrH95f.KEbu3UlTxnYg0ei4fEK1KA8E1wBOg4470..', 'Numero 7', '2025-05-20', 'Rio de Janeiro ', 'RJ', 20);

--
-- Indexes for dumped tables
--

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil` AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario` AUTO_INCREMENT=13;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
