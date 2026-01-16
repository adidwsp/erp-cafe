-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2026 at 09:44 AM
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
(3, 1, '2026-01-01', '08:24:00', '08:24:00', 'Hadir', 'Bekasi');

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
('08on2ivr9ttm69jd8fep41bvlbcogfr9', '::1', 1768487126, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736383438373035383b757365725f69647c733a313a2239223b6e616d657c733a31343a22496d656c64612052616b6120432e223b656d61696c7c733a31383a22696d656c64612e7263406d61696c2e636f6d223b726f6c657c733a353a226f776e6572223b6c6f676765645f696e7c623a313b),
('5jvm5n23jqq6n862p8uc637vuj92b3ts', '::1', 1767356898, 0x5f5f63695f6c6173745f726567656e65726174657c693a313736373335363739323b757365725f69647c733a313a2231223b6e616d657c733a31333a2241646d696e6973747261746f72223b656d61696c7c733a31343a2261646d696e406d61696c2e636f6d223b726f6c657c733a31333a2261646d696e6973747261746f72223b6c6f676765645f696e7c623a313b);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `module` varchar(50) NOT NULL,
  `can_view` tinyint(1) DEFAULT '0',
  `can_create` tinyint(1) DEFAULT '0',
  `can_edit` tinyint(1) DEFAULT '0',
  `can_delete` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role`, `module`, `can_view`, `can_create`, `can_edit`, `can_delete`, `created_at`) VALUES
(1, 'administrator', 'dashboard', 1, 1, 1, 1, '2026-01-16 07:39:24'),
(2, 'administrator', 'hr', 1, 1, 1, 1, '2026-01-16 07:39:24'),
(3, 'administrator', 'sales', 1, 1, 1, 1, '2026-01-16 07:39:24'),
(4, 'administrator', 'purchasing', 1, 1, 1, 1, '2026-01-16 07:39:24'),
(5, 'administrator', 'inventory', 1, 1, 1, 1, '2026-01-16 07:39:24'),
(6, 'administrator', 'users', 1, 1, 1, 1, '2026-01-16 07:39:24'),
(7, 'administrator', 'reports', 1, 1, 1, 1, '2026-01-16 07:39:24'),
(15, 'asasaa', 'dashboard', 0, 0, 0, 0, '2026-01-16 07:41:02'),
(16, 'asasaa', 'hr', 0, 0, 0, 0, '2026-01-16 07:41:02'),
(17, 'asasaa', 'sales', 0, 0, 0, 0, '2026-01-16 07:41:02'),
(18, 'asasaa', 'purchasing', 0, 0, 0, 0, '2026-01-16 07:41:02'),
(19, 'asasaa', 'inventory', 0, 0, 0, 0, '2026-01-16 07:41:02'),
(20, 'asasaa', 'users', 0, 0, 0, 0, '2026-01-16 07:41:02'),
(21, 'asasaa', 'reports', 0, 0, 0, 0, '2026-01-16 07:41:02'),
(22, 'cashier', 'dashboard', 0, 0, 0, 0, '2026-01-16 07:51:23'),
(23, 'cashier', 'hr', 0, 0, 0, 0, '2026-01-16 07:51:23'),
(24, 'cashier', 'sales', 0, 0, 0, 0, '2026-01-16 07:51:23'),
(25, 'cashier', 'purchasing', 0, 0, 0, 0, '2026-01-16 07:51:23'),
(26, 'cashier', 'inventory', 0, 0, 0, 0, '2026-01-16 07:51:23'),
(27, 'cashier', 'users', 0, 0, 0, 0, '2026-01-16 07:51:23'),
(28, 'cashier', 'reports', 0, 0, 0, 0, '2026-01-16 07:51:23'),
(36, 'owner', 'dashboard', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(37, 'owner', 'hr', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(38, 'owner', 'sales', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(39, 'owner', 'purchasing', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(40, 'owner', 'inventory', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(41, 'owner', 'users', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(42, 'owner', 'reports', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(50, 'hr_manager', 'dashboard', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(51, 'hr_manager', 'hr', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(52, 'hr_manager', 'sales', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(53, 'hr_manager', 'purchasing', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(54, 'hr_manager', 'inventory', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(55, 'hr_manager', 'users', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(56, 'hr_manager', 'reports', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(57, 'sales_manager', 'dashboard', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(58, 'sales_manager', 'hr', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(59, 'sales_manager', 'sales', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(60, 'sales_manager', 'purchasing', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(61, 'sales_manager', 'inventory', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(62, 'sales_manager', 'users', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(63, 'sales_manager', 'reports', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(64, 'purchase_manager', 'dashboard', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(65, 'purchase_manager', 'hr', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(66, 'purchase_manager', 'sales', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(67, 'purchase_manager', 'purchasing', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(68, 'purchase_manager', 'inventory', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(69, 'purchase_manager', 'users', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(70, 'purchase_manager', 'reports', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(71, 'inventory_manager', 'dashboard', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(72, 'inventory_manager', 'hr', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(73, 'inventory_manager', 'sales', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(74, 'inventory_manager', 'purchasing', 1, 0, 0, 0, '2026-01-16 08:06:47'),
(75, 'inventory_manager', 'inventory', 1, 1, 1, 1, '2026-01-16 08:06:47'),
(76, 'inventory_manager', 'users', 0, 0, 0, 0, '2026-01-16 08:06:47'),
(77, 'inventory_manager', 'reports', 1, 0, 0, 0, '2026-01-16 08:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `category_id` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `min_stock` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `category_id`, `unit`, `min_stock`, `created_at`) VALUES
(1, 'DRK-001', 'Kopi Hitam', 1, 'gelas', 20, '2026-01-01 08:58:09'),
(2, 'DRK-002', 'Es Teh Manis', 1, 'gelas', 30, '2026-01-01 08:58:09'),
(3, 'DRK-003', 'Cappuccino', 1, 'gelas', 15, '2026-01-01 08:58:09'),
(4, 'DRK-004', 'Latte', 1, 'gelas', 15, '2026-01-01 08:58:09'),
(5, 'DRK-005', 'Air Mineral Botol', 1, 'botol', 25, '2026-01-01 08:58:09'),
(6, 'FD-001', 'Nasi Goreng', 2, 'porsi', 10, '2026-01-01 08:58:09'),
(7, 'FD-002', 'Mie Goreng', 2, 'porsi', 10, '2026-01-01 08:58:09'),
(8, 'FD-003', 'Ayam Goreng', 2, 'porsi', 8, '2026-01-01 08:58:09'),
(9, 'FD-004', 'Burger Beef', 2, 'porsi', 7, '2026-01-01 08:58:09'),
(10, 'FD-005', 'Kentang Goreng', 2, 'porsi', 12, '2026-01-01 08:58:09'),
(11, 'SNK-001', 'Donat', 3, 'pcs', 20, '2026-01-01 08:58:09'),
(12, 'SNK-002', 'Roti Bakar', 3, 'porsi', 15, '2026-01-01 08:58:09'),
(13, 'SNK-003', 'Pisang Goreng', 3, 'porsi', 15, '2026-01-01 08:58:09'),
(14, 'SNK-004', 'Keripik Kentang', 3, 'pcs', 25, '2026-01-01 08:58:09'),
(15, 'SNK-005', 'Kacang Goreng', 3, 'pcs', 20, '2026-01-01 08:58:09');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `product_id`, `warehouse_id`, `qty`, `created_at`) VALUES
(1, 1, 1, 50, '2026-01-01 08:58:09'),
(2, 2, 1, 60, '2026-01-01 08:58:09'),
(3, 3, 1, 40, '2026-01-01 08:58:09'),
(4, 4, 1, 40, '2026-01-01 08:58:09'),
(5, 5, 1, 70, '2026-01-01 08:58:09'),
(6, 6, 1, 30, '2026-01-01 08:58:09'),
(7, 7, 1, 30, '2026-01-01 08:58:09'),
(8, 8, 1, 25, '2026-01-01 08:58:09'),
(9, 9, 1, 20, '2026-01-01 08:58:09'),
(10, 10, 1, 35, '2026-01-01 08:58:09'),
(11, 11, 1, 40, '2026-01-01 08:58:09'),
(12, 12, 1, 30, '2026-01-01 08:58:09'),
(13, 13, 1, 30, '2026-01-01 08:58:09'),
(14, 14, 1, 50, '2026-01-01 08:58:09'),
(15, 15, 1, 45, '2026-01-01 08:58:09'),
(16, 1, 1, 50, '2026-01-01 08:58:39'),
(17, 2, 1, 60, '2026-01-01 08:58:39'),
(18, 3, 1, 40, '2026-01-01 08:58:39'),
(19, 4, 1, 40, '2026-01-01 08:58:39'),
(20, 5, 1, 70, '2026-01-01 08:58:39'),
(21, 6, 1, 30, '2026-01-01 08:58:39'),
(22, 7, 1, 30, '2026-01-01 08:58:39'),
(23, 8, 1, 25, '2026-01-01 08:58:39'),
(24, 9, 1, 20, '2026-01-01 08:58:39'),
(25, 10, 1, 35, '2026-01-01 08:58:39'),
(26, 11, 1, 40, '2026-01-01 08:58:39'),
(27, 12, 1, 30, '2026-01-01 08:58:39'),
(28, 13, 1, 30, '2026-01-01 08:58:39'),
(29, 14, 1, 50, '2026-01-01 08:58:39'),
(30, 15, 1, 45, '2026-01-01 08:58:39'),
(31, 1, 1, 50, '2026-01-01 08:58:39'),
(32, 2, 1, 60, '2026-01-01 08:58:39'),
(33, 3, 1, 40, '2026-01-01 08:58:39'),
(34, 4, 1, 40, '2026-01-01 08:58:39'),
(35, 5, 1, 70, '2026-01-01 08:58:39'),
(36, 6, 1, 30, '2026-01-01 08:58:39'),
(37, 7, 1, 30, '2026-01-01 08:58:39'),
(38, 8, 1, 25, '2026-01-01 08:58:39'),
(39, 9, 1, 20, '2026-01-01 08:58:39'),
(40, 10, 1, 35, '2026-01-01 08:58:39'),
(41, 11, 1, 40, '2026-01-01 08:58:39'),
(42, 12, 1, 30, '2026-01-01 08:58:39'),
(43, 13, 1, 30, '2026-01-01 08:58:39'),
(44, 14, 1, 50, '2026-01-01 08:58:39'),
(45, 15, 1, 45, '2026-01-01 08:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `display_name`, `description`, `created_at`) VALUES
(1, 'administrator', 'Administrator', '', '2026-01-16 04:30:21'),
(2, 'sales', 'Sales', '', '2026-01-16 06:13:51'),
(4, 'owner', 'Owner', 'Pemilik bisnis', '2026-01-16 07:22:54'),
(5, 'cashier', 'Kasir', 'Kasir toko', '2026-01-16 07:22:54'),
(6, 'hr_manager', 'HR Manager', 'Manager HR', '2026-01-16 07:22:54'),
(7, 'sales_manager', 'Sales Manager', 'Manager Penjualan', '2026-01-16 07:22:54'),
(8, 'purchase_manager', 'Purchase Manager', 'Manager Pembelian', '2026-01-16 07:22:54'),
(9, 'inventory_manager', 'Inventory Manager', 'Manager Inventori', '2026-01-16 07:22:54');

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
-- Table structure for table `stock_mutations`
--

CREATE TABLE `stock_mutations` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `type` enum('in','out','adjust') NOT NULL,
  `ref_id` varchar(50) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_mutations`
--

INSERT INTO `stock_mutations` (`id`, `product_id`, `qty`, `type`, `ref_id`, `note`, `created_at`) VALUES
(1, 1, 2, 'out', 'INV-001', 'Penjualan kopi', '2026-01-01 08:58:39'),
(2, 11, 3, 'out', 'INV-002', 'Penjualan snack', '2026-01-01 08:58:39'),
(3, 5, -5, 'adjust', 'ADJ-001', 'Stok rusak', '2026-01-01 08:58:39'),
(4, 1, 2, 'out', 'INV-001', 'Penjualan kopi', '2026-01-01 08:58:39'),
(5, 11, 3, 'out', 'INV-002', 'Penjualan snack', '2026-01-01 08:58:39'),
(6, 5, -5, 'adjust', 'ADJ-001', 'Stok rusak', '2026-01-01 08:58:39');

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
(3, 'Adi Dwi S', 'adi3947@gmail.com', '$2y$10$Aexn66EnSL0L9JxvVdQO.e0pOvVg2uilVg/ABznQfhmLaOIdtOKQy', NULL, NULL, 'owner', '2025-10-30 14:47:49'),
(9, 'Imelda Raka C.', 'imelda.rc@mail.com', '$2y$10$B/Nzr0PZq0KHJYhyRTMnLuIUoNFPUBw3xpIJHOsqB9bc.IuqqCvUK', NULL, NULL, 'owner', '2026-01-15 15:15:30'),
(10, 'Siti Aisyah', 'siti@mail.com', '$2y$10$2MYsPN/05BLJYgjnnp8QG.Wrexlm3L4sk0L1YxRbVxe3pEuZRMM3G', NULL, NULL, 'cashier', '2026-01-15 15:17:12'),
(19, '123456', '123456@mail.com', '$2y$10$lE39mTrKu1v7hXG2tZQ1IOi0r1dakYHhdZY3mHI8unQi00PK4LK6a', NULL, NULL, 'hr_manager', '2026-01-16 09:17:07');

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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_role_module` (`role`,`module`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sku` (`sku`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_stock_product` (`product_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_salary_period` (`employee_id`,`period_month`,`period_year`);

--
-- Indexes for table `stock_mutations`
--
ALTER TABLE `stock_mutations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mutation_product` (`product_id`);

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
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `stock_mutations`
--
ALTER TABLE `stock_mutations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD CONSTRAINT `fk_stock_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_mutations`
--
ALTER TABLE `stock_mutations`
  ADD CONSTRAINT `fk_mutation_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
