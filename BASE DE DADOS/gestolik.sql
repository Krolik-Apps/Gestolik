-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 04, 2021 at 07:00 PM
-- Server version: 8.0.22-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestolik`
--

-- --------------------------------------------------------

--
-- Table structure for table `balanco`
--

CREATE TABLE `balanco` (
  `id_balanco` int NOT NULL,
  `data` varchar(50) NOT NULL DEFAULT '0',
  `nome` varchar(100) NOT NULL DEFAULT '0',
  `tipo` varchar(50) NOT NULL DEFAULT 'Débito',
  `valor` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `despesas`
--

CREATE TABLE `despesas` (
  `id_despesa` int NOT NULL,
  `nome` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `fecho_de_contas`
--

CREATE TABLE `fecho_de_contas` (
  `id_fecho` int NOT NULL,
  `data_abertura` varchar(50) DEFAULT NULL,
  `data` varchar(50) DEFAULT NULL,
  `data_fecho` varchar(50) DEFAULT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `valor_despesa` double DEFAULT '0',
  `valor_receita` double DEFAULT '0',
  `tipo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gestor`
--

CREATE TABLE `gestor` (
  `id_gestor` int NOT NULL,
  `data_abertura` varchar(50) DEFAULT NULL,
  `conta_aberta` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gestor`
--

INSERT INTO `gestor` (`id_gestor`, `data_abertura`, `conta_aberta`) VALUES
(1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `receitas`
--

CREATE TABLE `receitas` (
  `id_receita` int NOT NULL,
  `nome` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `id_saldo` int NOT NULL,
  `saldo` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `saldo`
--

INSERT INTO `saldo` (`id_saldo`, `saldo`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `totalizadores`
--

CREATE TABLE `totalizadores` (
  `id_totalizador` int NOT NULL,
  `id_despesa` int DEFAULT NULL,
  `id_receita` int DEFAULT NULL,
  `data_abertura` varchar(50) DEFAULT NULL,
  `data` varchar(200) DEFAULT NULL,
  `nome` varchar(200) DEFAULT NULL,
  `valor` double NOT NULL DEFAULT '0',
  `tipo` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balanco`
--
ALTER TABLE `balanco`
  ADD PRIMARY KEY (`id_balanco`);

--
-- Indexes for table `despesas`
--
ALTER TABLE `despesas`
  ADD PRIMARY KEY (`id_despesa`);

--
-- Indexes for table `fecho_de_contas`
--
ALTER TABLE `fecho_de_contas`
  ADD PRIMARY KEY (`id_fecho`);

--
-- Indexes for table `gestor`
--
ALTER TABLE `gestor`
  ADD PRIMARY KEY (`id_gestor`);

--
-- Indexes for table `receitas`
--
ALTER TABLE `receitas`
  ADD PRIMARY KEY (`id_receita`);

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`id_saldo`);

--
-- Indexes for table `totalizadores`
--
ALTER TABLE `totalizadores`
  ADD PRIMARY KEY (`id_totalizador`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balanco`
--
ALTER TABLE `balanco`
  MODIFY `id_balanco` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `despesas`
--
ALTER TABLE `despesas`
  MODIFY `id_despesa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fecho_de_contas`
--
ALTER TABLE `fecho_de_contas`
  MODIFY `id_fecho` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `gestor`
--
ALTER TABLE `gestor`
  MODIFY `id_gestor` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `receitas`
--
ALTER TABLE `receitas`
  MODIFY `id_receita` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `id_saldo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `totalizadores`
--
ALTER TABLE `totalizadores`
  MODIFY `id_totalizador` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
