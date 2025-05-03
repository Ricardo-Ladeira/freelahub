-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `freelahub`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `perfil`
--

CREATE TABLE `perfil` (
  `id` int(10) UNSIGNED NOT NULL,
  `p_telefone` varchar(25) NOT NULL,
  `p_tipo_servico` varchar(80) NOT NULL,
  `p_experiencia` varchar(25) NOT NULL,
  `p_descricao` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `perfil`
--

INSERT INTO `perfil` (`id`, `p_telefone`, `p_tipo_servico`, `p_experiencia`, `p_descricao`) VALUES
(12, '--', '--', 'Avançado', '--'),
(14, '1234567890', 'Jardinagem', 'Avançado', 'Jardinagem'),
(15, '1234567891', 'Teste de software', 'Intermediário', 'Teste de Software'),
(16, '12345671211', 'Jardinagem', 'Intermediário', 'Jardinagem');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_senha` varchar(128) NOT NULL,
  `u_nome` varchar(80) NOT NULL,
  `u_dt_nascimento` date NOT NULL,
  `u_cidade` varchar(80) DEFAULT NULL,
  `u_uf` varchar(2) DEFAULT NULL,
  `p_id_perfil` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `u_email`, `u_senha`, `u_nome`, `u_dt_nascimento`, `u_cidade`, `u_uf`, `p_id_perfil`) VALUES
(10, 'adm@freela.com', '$2y$10$KAfLy8OQ5yfOeQTFqbcyT.NSgSwUAsOVIUJFYuILv6JvBVDo9D79G', 'adm@freela.com', '2000-01-01', '--', '--', 12),
(12, 'num1@ab.com', '$2y$10$jvPoHLj4vAYHMt8cDkGlYuLSw7ocEWcrnmHaG2ycJvoSmWKxVwsc6', 'Numero 1', '2000-01-01', 'SJC', 'SP', 14),
(13, 'num2@ab.com', '$2y$10$Urw295W8vvknvtSInl97benzI7h2DHO1zuFoA315mpVffyR6gtE3y', 'Numero 2', '2011-01-01', 'são paulo', 'SP', 15),
(14, 'num3@ab.com', '$2y$10$pPm.8fygXOK/3P.C.vatD.m6UVaAr6OWBdfhSVStVuj73ELUr4T0a', 'Numero 3', '2002-05-20', 'Vencelau Brás', 'PR', 16);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `p_telefone` (`p_telefone`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_email` (`u_email`),
  ADD KEY `p_id_perfil` (`p_id_perfil`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `perfil`
--
ALTER TABLE `perfil`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`p_id_perfil`) REFERENCES `perfil` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
