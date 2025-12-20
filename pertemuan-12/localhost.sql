-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2025 at 03:54 AM
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
CREATE DATABASE IF NOT EXISTS `db_pwd2025` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_pwd2025`;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tamu`
--

INSERT INTO `tbl_tamu` (`cid`, `cnama`, `cemail`, `cpesan`, `dcreated_at`) VALUES
(1, 'kevin', 'aku@gmail.com', 'selamat malam semuanya', '2025-12-12 09:02:19'),
(2, 'sinta', 'sinta@gmail.com', 'halo nama aku sinta', '2025-12-12 09:02:43'),
(3, 'bagus', 'sumatera@gmail.com', 'apa kabar kita semua yang ada di sini apakah sehat', '2025-12-12 09:03:22'),
(4, 'burtihan', 'musang@gmail.com', 'halo email aku musang', '2025-12-12 09:03:47'),
(5, 'jodi', 'aku@gmail.com', 'hujan banjir semua nya ada di sini apakah kalian terjebak hujan yang tidak berhenti ini', '2025-12-12 09:04:39'),
(6, 'agus', 'sumatera@gmail.com', 'halo nama aku agus', '2025-12-12 09:05:01'),
(7, 'setian', 'sumatera@gmail.com', 'selamat malam dan selamat natal untuk kita semua semoga impian kita terwujud', '2025-12-12 09:06:05'),
(8, 'ddd', 'sumatera@gmail.com', 'kkkkkkkkssssssssssssss', '2025-12-15 15:15:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_tamu`
--
ALTER TABLE `tbl_tamu`
  ADD PRIMARY KEY (`cid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_tamu`
--
ALTER TABLE `tbl_tamu`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
