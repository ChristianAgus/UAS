-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2023 at 11:49 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `produk_laptop`
--

CREATE TABLE `produk_laptop` (
  `id` int(10) UNSIGNED NOT NULL,
  `brand_laptop_id` int(10) UNSIGNED DEFAULT NULL,
  `nama_laptop` varchar(50) NOT NULL,
  `price` varchar(12) NOT NULL,
  `discount` varchar(2) DEFAULT NULL,
  `quantity` int(3) NOT NULL,
  `total` varchar(20) DEFAULT NULL,
  `file` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_laptop`
--

INSERT INTO `produk_laptop` (`id`, `brand_laptop_id`, `nama_laptop`, `price`, `discount`, `quantity`, `total`, `file`) VALUES
(101, 9001, 'Lenovo Yoga', '10000000', NULL, 100, '1000000000', ''),
(102, 9001, 'Lenovo Thinkpad', '15000000', NULL, 30, '450000000', ''),
(196, 9057, 'dedede', 'de', 'de', 0, NULL, ''),
(197, 9058, 'v', 'v', 'v', 0, NULL, ''),
(198, 9059, 'bn', 'bn', 'bn', 0, NULL, ''),
(199, 9060, 'hjhjh', 'jhjh', 'jh', 0, NULL, ''),
(200, 9060, 'hjhj', 'jhj', 'jh', 0, NULL, ''),
(201, 9061, 'dew', 'ew', 'de', 0, NULL, 'uploads/JBvDghC5t1nWvQJABAUYGoav9fEerl6ehdGd8z6I.png'),
(202, 9062, 'Cvcvv', '10000000', '10', 10, '90000000', ''),
(203, 9062, 'bvvrt', '15000000', '15', 10, '142500000', ''),
(204, 9063, 'Bgt', '15000000', '15', 5, '67500000', ''),
(205, 9063, 'vfr', '30000000', '30', 8, '228000000', ''),
(206, 9064, 'Trew', '200000', '20', 10, '1800000', ''),
(207, 9064, 'trf', '100000', '10', 10, '1000000', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `produk_laptop`
--
ALTER TABLE `produk_laptop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_laptopid` (`brand_laptop_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `produk_laptop`
--
ALTER TABLE `produk_laptop`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk_laptop`
--
ALTER TABLE `produk_laptop`
  ADD CONSTRAINT `produk_laptop_ibfk_1` FOREIGN KEY (`brand_laptop_id`) REFERENCES `brand_laptops` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
