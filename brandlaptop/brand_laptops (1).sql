-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2023 at 11:48 AM
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
-- Table structure for table `brand_laptops`
--

CREATE TABLE `brand_laptops` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_brand` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `totalassetbrand` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand_laptops`
--

INSERT INTO `brand_laptops` (`id`, `nama_brand`, `description`, `status`, `totalassetbrand`, `created_at`, `updated_at`) VALUES
(9001, 'Lenovo', 'lenovo produk dari taiwan', 'Complete', '', '2023-07-04 03:59:21', NULL),
(9057, 'Dell', 'dell', 'pending', '', '2023-07-07 03:44:09', '2023-07-07 10:44:09'),
(9058, 'v', 'v', 'pending', '', '2023-07-07 03:47:36', '2023-07-07 10:47:36'),
(9059, 'bn', 'bn', 'pending', '', '2023-07-07 03:56:43', '2023-07-07 10:56:43'),
(9060, 'hjjh', 'jhjh', 'pending', '', '2023-07-07 04:07:19', '2023-07-07 11:07:19'),
(9061, 'vwdw', 'dewew', 'pending', '', '2023-07-07 06:11:10', '2023-07-07 13:11:10'),
(9062, 'Xzxz', 'xzxz', 'pending', '', '2023-07-07 07:11:34', '2023-07-07 14:11:34'),
(9063, 'Bgt', 'bgt', 'pending', '295500000', '2023-07-07 07:53:21', '2023-07-07 14:53:21'),
(9064, 'Tree', 'tre', 'pending', '2800000', '2023-07-07 08:15:03', '2023-07-07 15:15:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand_laptops`
--
ALTER TABLE `brand_laptops`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand_laptops`
--
ALTER TABLE `brand_laptops`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9065;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
