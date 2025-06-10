-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2025 at 03:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spprc`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `iditem` int(11) NOT NULL,
  `namaitem` varchar(50) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `imej` varchar(50) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `idkategori` int(11) DEFAULT NULL,
  `status_item` varchar(20) DEFAULT 'ada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`iditem`, `namaitem`, `detail`, `imej`, `harga`, `idkategori`, `status_item`) VALUES
(2, 'Nasi Ayam Gepuk', '', 'item_67e2901f49307.png', 9.50, 1, 'istimewa'),
(3, 'Matcha Latte', '', 'item_67e28f5426286.png', 4.50, 2, 'ada'),
(4, 'Teh Ais', '', 'item_67e2900cae33a.png', 3.50, 2, 'istimewa'),
(5, 'Otak Otak', '', 'item_67e290efb6ce2.png', 2.50, 1, 'istimewa');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(11) NOT NULL,
  `namakategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`) VALUES
(1, 'MAKANAN'),
(2, 'MINUMAN');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `idpengguna` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `nohp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`idpengguna`, `username`, `password`, `nama`, `nohp`, `email`, `level`) VALUES
(1, 'admin', '123456', 'Shop Owner', '01234567', NULL, 'admin'),
(3, 'norijea', '123456', 'NORIZAN BINTI ISMAIL', '0132434284', 'NORI@GMAIL.COM', 'user'),
(5, 'ahmad', 'abc123', 'Ahmad Jalani', '011234444', 'ahmad@gmai', 'user'),
(6, 'sarah', 'mypassword', 'Siti Sarah', '01234567', '', 'user'),
(7, 'kim', '123456', 'Peter Kim', '', '', 'user'),
(8, 'meeee', '123456', 'meme', '012345678', 'mimi@gmail.com', 'user'),
(9, 'mark', '123456', 'marklee', '012345678', 'mark@gmail.com', 'user'),
(13, 'alia', '123456', 'ali', '1234567', 'ali@gmail.com', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `idpesanan` int(11) NOT NULL,
  `idpengguna` int(11) DEFAULT NULL,
  `nota` varchar(100) DEFAULT NULL,
  `masa` datetime DEFAULT current_timestamp(),
  `meja` varchar(20) DEFAULT NULL,
  `status_pesanan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`idpesanan`, `idpengguna`, `nota`, `masa`, `meja`, `status_pesanan`) VALUES
(1, 3, '', '2025-04-10 14:08:25', 'Bungkus', 'ready'),
(2, 3, '', '2025-04-10 14:08:59', 'Meja 2', 'ready'),
(3, 3, '', '2025-04-10 14:14:10', 'Meja 1', 'ready'),
(4, 3, '', '2025-05-17 10:38:54', 'Bungkus', 'pending'),
(5, 3, '', '2025-05-17 12:16:54', 'Meja 2', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_item`
--

CREATE TABLE `pesanan_item` (
  `idpesanan` int(11) DEFAULT NULL,
  `iditem` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `kuantiti` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan_item`
--

INSERT INTO `pesanan_item` (`idpesanan`, `iditem`, `harga`, `kuantiti`) VALUES
(1, 5, 2.50, 4),
(2, 2, 9.50, 1),
(2, 2, 9.50, 8),
(3, 4, 3.50, 3),
(4, 3, 4.50, 2),
(5, 2, 9.50, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`iditem`),
  ADD KEY `item_kategori` (`idkategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`),
  ADD UNIQUE KEY `namakategori` (`namakategori`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`idpengguna`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`idpesanan`),
  ADD KEY `pesanan_pengguna` (`idpengguna`);

--
-- Indexes for table `pesanan_item`
--
ALTER TABLE `pesanan_item`
  ADD KEY `to_PESANAN` (`iditem`),
  ADD KEY `to_item` (`idpesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `iditem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `idpengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `idpesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_kategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori` (`idkategori`) ON DELETE SET NULL;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_pengguna` FOREIGN KEY (`idpengguna`) REFERENCES `pengguna` (`idpengguna`) ON DELETE CASCADE;

--
-- Constraints for table `pesanan_item`
--
ALTER TABLE `pesanan_item`
  ADD CONSTRAINT `to_PESANAN` FOREIGN KEY (`iditem`) REFERENCES `item` (`iditem`) ON DELETE CASCADE,
  ADD CONSTRAINT `to_item` FOREIGN KEY (`idpesanan`) REFERENCES `pesanan` (`idpesanan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
