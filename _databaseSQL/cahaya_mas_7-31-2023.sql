-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2023 at 03:05 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cahaya_mas`
--
CREATE DATABASE IF NOT EXISTS `cahaya_mas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cahaya_mas`;

-- --------------------------------------------------------

--
-- Table structure for table `category_inventory`
--

CREATE TABLE `category_inventory` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category_inventory`
--

INSERT INTO `category_inventory` (`id`, `name`) VALUES
(1, 'SNACK'),
(2, 'DRINK');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(8) NOT NULL,
  `code` varchar(10) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `id_tier` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `code`, `full_name`, `phone`, `address`, `id_tier`) VALUES
(1, 'CUST001', 'Customer One', '081234221234', 'Harington St', 2);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(8) NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_category` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `code`, `name`, `id_category`) VALUES
(1, 'LPT54126', 'Leo Potato Chips', 1),
(3, 'RDB33215', 'Red Bean', 1),
(4, 'CCL35124', 'Coca Cola', 2);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_unit`
--

CREATE TABLE `inventory_unit` (
  `id` int(8) NOT NULL,
  `id_inventory` int(8) NOT NULL,
  `id_unit` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory_unit`
--

INSERT INTO `inventory_unit` (`id`, `id_inventory`, `id_unit`) VALUES
(13, 3, 1),
(14, 3, 2),
(15, 3, 4),
(16, 4, 1),
(17, 4, 4),
(18, 1, 1),
(19, 1, 2),
(20, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `id` int(8) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`id`, `description`) VALUES
(1, 'MASTER_USER'),
(2, 'MASTER_CUSTOMER'),
(3, 'MASTER_SUPPLIER'),
(4, 'MASTER_INVENTORY'),
(5, 'MASTER_CATEGORY');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `id` int(8) NOT NULL,
  `id_role` int(8) NOT NULL,
  `id_permission` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`id`, `id_role`, `id_permission`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(11, 2, 2),
(12, 2, 4),
(13, 2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'CASHIER'),
(6, 'TEST');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(8) NOT NULL,
  `id_inventory` int(8) NOT NULL,
  `id_unit` int(8) NOT NULL,
  `date_input` date NOT NULL,
  `date_expired` date DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `price_buy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `id_inventory`, `id_unit`, `date_input`, `date_expired`, `qty`, `price_buy`) VALUES
(1, 1, 1, '2023-07-28', '2026-07-28', 50, 5000),
(3, 3, 2, '2023-07-29', '2024-07-29', 5, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `name`, `code`, `phone`, `address`) VALUES
(1, 'Supplier One', 'SUP001', '6212343123533', 'Sresada St');

-- --------------------------------------------------------

--
-- Table structure for table `tier_customer`
--

CREATE TABLE `tier_customer` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tier_customer`
--

INSERT INTO `tier_customer` (`id`, `name`, `level`) VALUES
(1, 'COMMON', 1),
(2, 'BRONZE', 2),
(3, 'SILVER', 3),
(4, 'GOLD', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tier_pricing`
--

CREATE TABLE `tier_pricing` (
  `id` int(8) NOT NULL,
  `id_inventory` int(8) NOT NULL,
  `id_unit` int(8) NOT NULL,
  `id_tier_customer` int(8) NOT NULL,
  `sell_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tier_pricing`
--

INSERT INTO `tier_pricing` (`id`, `id_inventory`, `id_unit`, `id_tier_customer`, `sell_price`) VALUES
(1, 1, 1, 1, 8000),
(2, 1, 1, 2, 7500),
(3, 1, 1, 3, 7000),
(4, 1, 1, 4, 6500);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `id_reference` int(8) DEFAULT NULL,
  `qty_reference` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `name`, `id_reference`, `qty_reference`) VALUES
(1, 'pcs', NULL, NULL),
(2, 'pack', 1, 12),
(4, 'doz', 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(8) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_role` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `id_role`) VALUES
(1, 'admin', '$2y$10$aAeBZLGRvFKyo/YuS6OjouyV/iSodjXLx50sDBVPaypV7cdgNYsDm', 1),
(14, 'cashier', '$2y$10$X/XHDel5G4vwZmauo2R96OuLHWRgr93vqb5eYYstZkGlxx7i31jJW', 2),
(15, 'test', '$2y$10$snbjIXpjy9.JNdvX.LxMKeaef6Ij6lKePNQis068aOeA7aLI2VQ.i', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category_inventory`
--
ALTER TABLE `category_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `id_tier` (`id_tier`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `inventory_unit`
--
ALTER TABLE `inventory_unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_inventory` (`id_inventory`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `permission`
--
ALTER TABLE `permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_permission` (`id_permission`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_inventory` (`id_inventory`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `tier_customer`
--
ALTER TABLE `tier_customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tier_pricing`
--
ALTER TABLE `tier_pricing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_reference` (`id_reference`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category_inventory`
--
ALTER TABLE `category_inventory`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory_unit`
--
ALTER TABLE `inventory_unit`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tier_customer`
--
ALTER TABLE `tier_customer`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tier_pricing`
--
ALTER TABLE `tier_pricing`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`id_tier`) REFERENCES `tier_customer` (`id`);

--
-- Constraints for table `inventory_unit`
--
ALTER TABLE `inventory_unit`
  ADD CONSTRAINT `inventory_unit_ibfk_1` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `inventory_unit_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id`),
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id`);

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`id_reference`) REFERENCES `unit` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
