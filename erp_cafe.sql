-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2026 at 03:49 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `erp_cafe`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` int(50) NOT NULL,
  `employee_id` int(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `employee_id`, `date`, `time_in`, `time_out`, `status`, `location`) VALUES
(1, 2, '2026-01-01', '01:34:00', '01:34:00', 'Hadir', 'Bekasi'),
(2, 7, '2026-01-01', '03:31:00', '09:31:00', 'Hadir', 'Jakarta');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('asiti1vvlguklosk8kp04eemqs5m6trk', '::1', 1767235284, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736373233353030343b757365725f69647c733a313a2231223b6e616d657c733a31333a2241646d696e6973747261746f72223b656d61696c7c733a31343a2261646d696e406d61696c2e636f6d223b726f6c657c733a31333a2261646d696e6973747261746f72223b6c6f676765645f696e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(50) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nik` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `join_date` date NOT NULL,
  `position` varchar(100) NOT NULL,
  `salary_base` int(100) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `nik`, `name`, `join_date`, `position`, `salary_base`, `status`) VALUES
(1, 1, 'A.0000', 'Administrator', '2025-11-03', 'Administrator', 0, 'Aktif'),
(2, NULL, 'A.0002', 'Adi Dwi Saputra', '2025-01-01', 'Chief Executive Officer', 100000000, 'Aktif'),
(3, NULL, 'S.0003', 'Salsabilla Imelda Raka Caswita', '2025-01-01', 'Deputy Excecutive Officer', 100000000, 'Aktif'),
(4, NULL, 'M.0004', 'Moh. Mulky', '2025-01-01', 'Chief Executive Officer', 500000000, 'Aktif'),
(5, NULL, 'A.0005', 'Ahmad Fauzi', '2026-01-01', 'Barista', 3500000, 'Aktif'),
(6, NULL, 'S.0006', 'Siti Aisyah', '2026-01-01', 'Kasir', 3200000, 'Aktif'),
(7, NULL, 'B.0007', 'Budi Santoso', '2026-01-01', 'Supervisor', 5000000, 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `period_month` tinyint(4) NOT NULL,
  `period_year` smallint(6) NOT NULL,
  `base_salary` decimal(15,2) NOT NULL,
  `allowance` decimal(15,2) DEFAULT '0.00',
  `overtime_pay` decimal(15,2) DEFAULT '0.00',
  `deduction` decimal(15,2) DEFAULT '0.00',
  `total_salary` decimal(15,2) NOT NULL,
  `status` enum('draft','approved','paid') DEFAULT 'draft',
  `generated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `approved_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`id`, `employee_id`, `period_month`, `period_year`, `base_salary`, `allowance`, `overtime_pay`, `deduction`, `total_salary`, `status`, `generated_at`, `approved_at`, `created_by`) VALUES
(1, 1, 9, 2025, '3500000.00', '0.00', '150000.00', '50000.00', '3600000.00', 'draft', '2025-12-17 18:15:37', NULL, NULL),
(2, 2, 9, 2025, '3200000.00', '0.00', '0.00', '0.00', '3200000.00', 'draft', '2025-12-17 18:15:37', NULL, NULL),
(3, 3, 9, 2025, '5000000.00', '0.00', '300000.00', '0.00', '5300000.00', 'draft', '2025-12-17 18:15:37', NULL, NULL),
(7, 1, 12, 2025, '500000000.00', '0.00', '0.00', '0.00', '500000000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(8, 2, 12, 2025, '100000000.00', '0.00', '0.00', '0.00', '100000000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(9, 3, 12, 2025, '100000000.00', '0.00', '0.00', '0.00', '100000000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(10, 4, 12, 2025, '5000000.00', '0.00', '0.00', '0.00', '5000000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(11, 5, 12, 2025, '3500000.00', '0.00', '0.00', '0.00', '3500000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(12, 6, 12, 2025, '3200000.00', '0.00', '0.00', '0.00', '3200000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(13, 7, 12, 2025, '5000000.00', '0.00', '0.00', '0.00', '5000000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(14, 8, 12, 2025, '3500000.00', '0.00', '0.00', '0.00', '3500000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(15, 9, 12, 2025, '3200000.00', '0.00', '0.00', '0.00', '3200000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(16, 10, 12, 2025, '5000000.00', '0.00', '0.00', '0.00', '5000000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(17, 11, 12, 2025, '3500000.00', '0.00', '0.00', '0.00', '3500000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(18, 12, 12, 2025, '3200000.00', '0.00', '0.00', '0.00', '3200000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(19, 13, 12, 2025, '5000000.00', '0.00', '0.00', '0.00', '5000000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(20, 14, 12, 2025, '3500000.00', '0.00', '0.00', '0.00', '3500000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(21, 15, 12, 2025, '3200000.00', '0.00', '0.00', '0.00', '3200000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(22, 16, 12, 2025, '5000000.00', '0.00', '0.00', '0.00', '5000000.00', 'draft', '2025-12-17 18:18:19', NULL, NULL),
(23, 1, 1, 2026, '0.00', '0.00', '0.00', '0.00', '0.00', 'draft', '2026-01-01 09:32:35', NULL, NULL),
(24, 2, 1, 2026, '100000000.00', '0.00', '0.00', '0.00', '100000000.00', 'draft', '2026-01-01 09:32:35', NULL, NULL),
(25, 3, 1, 2026, '100000000.00', '0.00', '0.00', '0.00', '100000000.00', 'draft', '2026-01-01 09:32:35', NULL, NULL),
(26, 4, 1, 2026, '500000000.00', '0.00', '0.00', '0.00', '500000000.00', 'draft', '2026-01-01 09:32:35', NULL, NULL),
(27, 5, 1, 2026, '3500000.00', '0.00', '0.00', '0.00', '3500000.00', 'draft', '2026-01-01 09:32:35', NULL, NULL),
(28, 6, 1, 2026, '3200000.00', '0.00', '0.00', '0.00', '3200000.00', 'draft', '2026-01-01 09:32:35', NULL, NULL),
(29, 7, 1, 2026, '5000000.00', '0.00', '0.00', '0.00', '5000000.00', 'draft', '2026-01-01 09:32:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `remember_expire` datetime DEFAULT NULL,
  `role` varchar(50) DEFAULT 'customer',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `remember_expire`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@mail.com', '$2y$10$nTqjkwl6ZBB9ngSwaDXQs.LYiLh1VNssXW4D5pFeWwPxYAC8sCSMq', NULL, NULL, 'administrator', '2025-10-31 10:55:19'),
(3, 'ADI DWI SAPUTRA', 'adi3947@gmail.com', '$2y$10$Aexn66EnSL0L9JxvVdQO.e0pOvVg2uilVg/ABznQfhmLaOIdtOKQy', NULL, NULL, 'admin', '2025-10-30 14:47:49'),
(6, 'coba1', 'coba@mail.com', '$2y$10$94iA7XVvpRjvyX18C5y/Qes4xvMQh6G141lauSJwCg28f5QDQfgO6', NULL, NULL, 'admin', '2025-11-01 14:31:35'),
(8, '123', '123@mail.com', '$2y$10$AN8f2w8g9W14jeomvr1C3eAxhrO/FjBVZ/0aiu.kayRci6vWFZg0S', NULL, NULL, 'admin', '2025-11-01 14:56:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_salary_period` (`employee_id`,`period_month`,`period_year`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
