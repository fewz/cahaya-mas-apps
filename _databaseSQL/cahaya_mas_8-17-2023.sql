-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2023 at 05:48 PM
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
(1, 'MINUMAN'),
(2, 'ROKOK');

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
(3, 'AE0001', 'ADRIEL EDGARD', '085232654598', 'JL.TERNATE NO. 40, MAKASSAR', 4),
(4, 'KL0001', 'KENNY LISAL', '085656954252', 'JL. TANJUNG BUNGA NO. 50, MAKASSAR', 3),
(5, 'WES001', 'WILLY ENDRI SETIAWAN', '085212353958', 'JL.BANDANG NO.205, MAKASSAR', 2),
(6, 'EG0001', 'ERLAND GOESWANTO', '085212656958', 'JL. PONEGORO NO.80, MAKASSAR', 1);

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
(20, 'AQUA001', 'AQUA', 1);

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
(13, 2, 5),
(26, 7, 4),
(27, 7, 5);

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
(7, 'GUDANG');

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
(4, 20, 21, '2023-08-01', '2023-08-02', 25, 15000);

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
(1, 'SUPPLIER AQUA', 'SUP001', '085212363256', 'JL. RUNGKUT NO. 2, SURABAYA'),
(3, 'SUPPLIER SURYA', 'SUP002', '085659351526', 'JL. RUNGKUT INDUSTRI NO.10, SURABAYA'),
(4, 'SUPPLIER CLASS MILD', 'SUP003', '085646958254', 'JL. RUNGKUT INDUSTRI NO.20, SURABAYA');

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
  `tier_customer` varchar(255) NOT NULL,
  `sell_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tier_pricing`
--

INSERT INTO `tier_pricing` (`id`, `id_inventory`, `id_unit`, `tier_customer`, `sell_price`) VALUES
(46, 20, 22, 'general', 55000),
(47, 20, 22, 'bronze', 48000),
(48, 20, 22, 'silver', 45000),
(49, 20, 22, 'gold', 40000),
(50, 20, 23, 'general', 35000),
(51, 20, 23, 'bronze', 34000),
(52, 20, 23, 'silver', 30000),
(53, 20, 23, 'gold', 25000);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty_reference` int(11) DEFAULT NULL,
  `id_inventory` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `name`, `qty_reference`, `id_inventory`) VALUES
(21, 'pcs', NULL, 20),
(22, 'box', 24, 20),
(23, 'lusin', 12, 20);

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
(14, 'kasir', '$2y$10$uqk/B9nUk9yv4m1cb0kQxeEnIorAQr5XKuqyJ6ksf0F/lxl0TqEvK', 1),
(16, 'gudang', '$2y$10$5C6d0kh4DNCs5B3U7f.oXuINz5ucWAecL.9n/O3KzBtMRt8szHqZu', 1);

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
  ADD KEY `id_inventory` (`id_inventory`);

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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tier_customer`
--
ALTER TABLE `tier_customer`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tier_pricing`
--
ALTER TABLE `tier_pricing`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`id_tier`) REFERENCES `tier_customer` (`id`);

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
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
