-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 28, 2026 at 08:46 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pwd2025`
--
CREATE DATABASE IF NOT EXISTS `db_pwd2025` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_pwd2025`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_biodata`
--

CREATE TABLE `tbl_biodata` (
  `eid` int(11) NOT NULL,
  `ekodedosen` varchar(20) DEFAULT NULL,
  `enamadosen` varchar(100) DEFAULT NULL,
  `ealamatrumah` varchar(100) DEFAULT NULL,
  `etanggaljadidosen` varchar(50) DEFAULT NULL,
  `ejjadosen` varchar(50) DEFAULT NULL,
  `ehomebaseprodi` varchar(100) DEFAULT NULL,
  `enomorhp` varchar(100) DEFAULT NULL,
  `enamapasangan` varchar(100) DEFAULT NULL,
  `enamaanak` varchar(100) DEFAULT NULL,
  `ebidangilmudosen` varchar(100) DEFAULT NULL,
  `ecreatedat` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_biodata`
--

INSERT INTO `tbl_biodata` (`eid`, `ekodedosen`, `enamadosen`, `ealamatrumah`, `etanggaljadidosen`, `ejjadosen`, `ehomebaseprodi`, `enomorhp`, `enamapasangan`, `enamaanak`, `ebidangilmudosen`, `ecreatedat`) VALUES
(1, 'dfdfdf', 'dfd', 'f', 'df', 'df', 'df', 'd', '3', 'df', 'df', '2026-01-28 07:27:53'),
(2, 'rerere', 'rerererer', 'ererere', 'rerer', 'er', 'ere', 'rer', 'e', 're', 're', '2026-01-28 07:28:53'),
(3, 'ggfg', 'gdg', 'dg', 'dgd', 'gd', 'gd', 'd', 'gd', 'g', 'dg', '2026-01-28 07:34:48'),
(4, 'fdfdfddf', 'df', 'df', 'dfd', 'f', 'df', 'df', 'df', 'd', 'fd', '2026-01-28 07:45:50'),
(5, 'rgfgfgf', 'gfgfg', 'gf', 'gf', 'gf', 'g', 'fgf', 'g', 'fg', 'fg', '2026-01-28 07:45:57'),
(6, 'fgf', 'pak bambang', 'fgfgfg', 'fgfgf', 'g', 'fg', 'fg', 'f', 'gf', 'gfg', '2026-01-28 07:46:02'),
(7, 'dfd', 'fdf', 'dfdf', 'df', 'd', 'fd', 'fd', 'f', 'df', 'd', '2026-01-28 08:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tamu`
--

CREATE TABLE `tbl_tamu` (
  `cid` int(11) NOT NULL,
  `cnama` varchar(100) DEFAULT NULL,
  `cemail` varchar(100) DEFAULT NULL,
  `cpesan` text,
  `dcreated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_tamu`
--

INSERT INTO `tbl_tamu` (`cid`, `cnama`, `cemail`, `cpesan`, `dcreated_at`) VALUES
(1, 'dfdfdf', 'musang@gmail.comdf', 'fffffffffffffffffffff\r\ndfdfdfd', '2026-01-28 14:13:17'),
(2, 'sfdfdfdfd', 'fdfdf@gmail.com', 'dfdfdfdfdfdf', '2026-01-28 15:27:47'),
(3, 'fdfdfdf', 'aku@gmail.com', 'fdfdfdfdfdfdf', '2026-01-28 15:31:07'),
(4, 'dfdfdfd', 'musang@gmail.com', 'fdfdfdfdfddfdf', '2026-01-28 15:34:34'),
(5, 'cvcvcv', 'musang@gmail.com', 'fdfdfdfdfdfdfd', '2026-01-28 15:34:52'),
(6, 'ggd', 'musang@gmail.com', 'fdfdfdfdf\r\nfddf', '2026-01-28 15:35:38'),
(7, 'fdfdfdf', 'musang@gmail.com', 'fdfdfdfdfdfdfd', '2026-01-28 15:36:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_biodata`
--
ALTER TABLE `tbl_biodata`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `tbl_tamu`
--
ALTER TABLE `tbl_tamu`
  ADD PRIMARY KEY (`cid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_biodata`
--
ALTER TABLE `tbl_biodata`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_tamu`
--
ALTER TABLE `tbl_tamu`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
