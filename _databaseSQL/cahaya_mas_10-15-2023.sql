-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2023 at 05:54 PM
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
(1, 'ROKOK'),
(2, 'MINUMAN'),
(3, 'BATTERY'),
(4, 'BISKUIT'),
(5, 'DEODORAN'),
(6, 'PERMEN'),
(7, 'KACANG'),
(8, 'KECAP'),
(9, 'KOPI'),
(10, 'LILIN'),
(11, 'MAKANAN'),
(12, 'MIE'),
(13, 'MINUMAN'),
(14, 'MINYAK GORENG'),
(15, 'OBAT NYAMUK'),
(16, 'ODOL'),
(17, 'PEMBALUT'),
(18, 'PEMBERSIH KAMAR MANDI'),
(19, 'PEMBERSIH LANTAI'),
(20, 'PENYEDAP MAKANAN'),
(21, 'SABUN CUCI BAJU'),
(22, 'SABUN CUCI PIRING'),
(23, 'SABUN MANDI'),
(24, 'SABUN CUCI PAKAIAN'),
(25, 'SAMBAL'),
(26, 'SHAMPOO'),
(27, 'SNACK'),
(28, 'SUSU'),
(29, 'TEH'),
(30, 'TEPUNG'),
(31, 'TISSUE');

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
  `tier_customer` varchar(15) NOT NULL DEFAULT 'general',
  `poin` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `code`, `full_name`, `phone`, `address`, `tier_customer`, `poin`) VALUES
(1, 'AE0001', 'ADRIEL EDGARD', '085232654598', 'JL.TERNATE NO. 40, MAKASSAR', 'gold', 5174),
(2, 'KL0001', 'KENNY LISAL', '085656954252', 'JL. TANJUNG BUNGA NO. 50, MAKASSAR', 'silver', 5000),
(3, 'WES001', 'WILLY ENDRI SETIAWAN', '085212353958', 'JL.BANDANG NO.205, MAKASSAR', 'bronze', 5100),
(4, 'EG0001', 'ERLAND GOESWANTO', '085212656958', 'JL. PONEGORO NO.80, MAKASSAR', 'general', 10212);

-- --------------------------------------------------------

--
-- Table structure for table `diskon`
--

CREATE TABLE `diskon` (
  `id` int(8) NOT NULL,
  `id_inventory` int(8) NOT NULL,
  `id_unit` int(8) NOT NULL,
  `minimal` int(8) NOT NULL,
  `potongan` int(25) NOT NULL,
  `start_date` date NOT NULL DEFAULT current_timestamp(),
  `end_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `diskon`
--

INSERT INTO `diskon` (`id`, `id_inventory`, `id_unit`, `minimal`, `potongan`, `start_date`, `end_date`) VALUES
(2, 32, 123, 5, 15000, '2023-10-02', '2024-03-06'),
(3, 30, 118, 2, 500, '2023-10-02', '2024-02-15'),
(4, 31, 120, 5, 1500, '2023-10-03', '2023-11-23');

-- --------------------------------------------------------

--
-- Table structure for table `d_pengiriman`
--

CREATE TABLE `d_pengiriman` (
  `id` int(8) NOT NULL,
  `id_h_pengiriman` int(8) NOT NULL,
  `id_h_transaction` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `d_pengiriman`
--

INSERT INTO `d_pengiriman` (`id`, `id_h_pengiriman`, `id_h_transaction`) VALUES
(1, 2, 10),
(2, 3, 14),
(3, 3, 13),
(4, 4, 15),
(5, 4, 16);

-- --------------------------------------------------------

--
-- Table structure for table `d_purchase_order`
--

CREATE TABLE `d_purchase_order` (
  `id` int(8) NOT NULL,
  `id_h_purchase_order` int(8) NOT NULL,
  `id_inventory` int(8) NOT NULL,
  `id_unit` int(8) NOT NULL,
  `date_expired` date DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `sisa_qty` int(8) NOT NULL DEFAULT 0,
  `order_qty` int(8) NOT NULL DEFAULT 0,
  `price_buy` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `d_purchase_order`
--

INSERT INTO `d_purchase_order` (`id`, `id_h_purchase_order`, `id_inventory`, `id_unit`, `date_expired`, `qty`, `sisa_qty`, `order_qty`, `price_buy`) VALUES
(64, 20, 30, 118, '2023-09-25', 25, 0, 25, 15000),
(65, 20, 30, 119, '2023-09-25', 15, 0, 15, 45000),
(66, 20, 31, 120, '2023-09-25', 25, 0, 25, 15000),
(67, 20, 31, 121, '2023-09-25', 15, 0, 15, 45000),
(70, 21, 33, 124, '2023-10-02', 20, 5, 25, 12500),
(71, 21, 33, 125, '2023-10-02', 5, 0, 5, 125000),
(73, 22, 32, 123, '2023-10-03', 25, 0, 25, 45000),
(75, 23, 34, 127, '2023-10-03', 15, 0, 15, 5000),
(77, 24, 30, 118, '2023-10-03', 15, 0, 15, 15000),
(81, 25, 30, 119, '2023-10-04', 50, 0, 50, 100000),
(82, 25, 31, 121, '2023-10-04', 50, 0, 50, 100000),
(83, 25, 33, 126, '2023-10-04', 100, 0, 100, 100000),
(86, 26, 35, 129, '2023-10-12', 150, 0, 150, 150000),
(87, 26, 35, 130, '2023-10-12', 150, 0, 150, 150000);

-- --------------------------------------------------------

--
-- Table structure for table `d_transaction`
--

CREATE TABLE `d_transaction` (
  `id` int(8) NOT NULL,
  `id_h_transaction` int(8) NOT NULL,
  `id_inventory` int(8) NOT NULL,
  `id_unit` int(8) NOT NULL,
  `sell_price` int(15) NOT NULL,
  `qty` int(15) NOT NULL,
  `diskon` int(25) NOT NULL DEFAULT 0,
  `sub_total` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `d_transaction`
--

INSERT INTO `d_transaction` (`id`, `id_h_transaction`, `id_inventory`, `id_unit`, `sell_price`, `qty`, `diskon`, `sub_total`) VALUES
(11, 7, 30, 118, 5000, 5, 500, 24500),
(12, 7, 31, 121, 30000, 1, 0, 30000),
(13, 8, 30, 118, 12500, 5, 500, 62000),
(14, 9, 30, 118, 5000, 3, 500, 14500),
(15, 10, 33, 126, 300000, 17, 0, 5100000),
(16, 11, 30, 118, 5000, 5, 500, 24500),
(17, 12, 30, 118, 5000, 5, 500, 24500),
(18, 13, 35, 129, 1000000, 5, 0, 5000000),
(19, 14, 30, 118, 5000, 5, 500, 24500),
(20, 14, 31, 120, 25000, 5, 1500, 123500),
(21, 14, 33, 124, 15000, 4, 0, 60000),
(22, 14, 35, 129, 1000000, 5, 0, 5000000),
(23, 15, 35, 129, 1000000, 5, 0, 5000000),
(24, 15, 35, 130, 10000000, 1, 0, 10000000),
(25, 16, 35, 130, 10000000, 1, 0, 10000000),
(26, 16, 33, 124, 12500, 5, 0, 62500),
(27, 17, 30, 118, 5000, 5, 500, 24500),
(28, 17, 35, 129, 1000000, 5, 0, 5000000),
(29, 18, 35, 129, 1000000, 5, 0, 5000000),
(30, 18, 32, 122, 4500, 2, 0, 9000);

-- --------------------------------------------------------

--
-- Table structure for table `h_pengiriman`
--

CREATE TABLE `h_pengiriman` (
  `id` int(8) NOT NULL,
  `code` varchar(25) NOT NULL,
  `status` int(1) NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `driver` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `h_pengiriman`
--

INSERT INTO `h_pengiriman` (`id`, `code`, `status`, `delivery_date`, `driver`) VALUES
(2, 'PE001', 2, '2023-10-15', 'HADI'),
(3, 'PE002', 1, '2023-10-26', 'HADI'),
(4, 'PE003', 1, '2023-10-24', 'SABI');

-- --------------------------------------------------------

--
-- Table structure for table `h_purchase_order`
--

CREATE TABLE `h_purchase_order` (
  `id` int(8) NOT NULL,
  `id_supplier` int(8) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `finish_date` date NOT NULL DEFAULT current_timestamp(),
  `order_number` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `grand_total` int(8) NOT NULL DEFAULT 0,
  `due_date` date DEFAULT NULL,
  `payment_method` varchar(25) NOT NULL DEFAULT 'CASH',
  `lunas` int(1) NOT NULL DEFAULT 0,
  `tanggal_bayar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `h_purchase_order`
--

INSERT INTO `h_purchase_order` (`id`, `id_supplier`, `created_date`, `finish_date`, `order_number`, `status`, `grand_total`, `due_date`, `payment_method`, `lunas`, `tanggal_bayar`) VALUES
(20, 9, '2023-09-25', '2023-09-25', 'ORD001', 2, 2100000, NULL, 'CASH', 1, NULL),
(21, 9, '2023-10-02', '2023-10-02', 'ORD004', 2, 875000, NULL, 'CASH', 1, NULL),
(22, 10, '2023-10-03', '2023-10-03', '431253', 2, 1125000, NULL, 'CASH', 1, NULL),
(23, 10, '2023-10-03', '2023-10-03', 'ORD006', 2, 75000, '2023-10-31', 'CREDIT', 1, NULL),
(24, 9, '2023-10-03', '2023-10-02', '42351', 2, 225000, '2023-10-10', 'CREDIT', 1, '2023-10-02'),
(25, 9, '2023-10-04', '2023-10-05', 'ORD010', 2, 20000000, NULL, 'CASH', 1, NULL),
(26, 9, '2023-10-12', '2023-10-12', 'ORD0045', 2, 45000000, NULL, 'CASH', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `h_transaction`
--

CREATE TABLE `h_transaction` (
  `id` int(8) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp(),
  `finish_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `id_customer` int(8) NOT NULL,
  `id_cashier` int(8) NOT NULL,
  `total_diskon` int(55) NOT NULL DEFAULT 0,
  `diskon_poin` int(25) NOT NULL DEFAULT 0,
  `grand_total` int(15) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0 COMMENT '0 = draft, 1 = finish, 2= belum lunas, 3= = belum dikirim, 4= siap dikirim, 5= sedang dikirim',
  `payment_method` varchar(255) NOT NULL DEFAULT 'CASH',
  `due_date` date DEFAULT NULL,
  `transaction_type` varchar(255) NOT NULL DEFAULT 'OFFLINE',
  `id_h_pengiriman` int(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `h_transaction`
--

INSERT INTO `h_transaction` (`id`, `order_number`, `created_date`, `finish_date`, `delivery_date`, `id_customer`, `id_cashier`, `total_diskon`, `diskon_poin`, `grand_total`, `status`, `payment_method`, `due_date`, `transaction_type`, `id_h_pengiriman`) VALUES
(7, '12451', '2023-09-26', NULL, NULL, 1, 1, 500, 0, 54500, 1, 'CASH', NULL, 'OFFLINE', NULL),
(8, 'ORD0035', '2023-09-25', NULL, NULL, 3, 1, 500, 0, 62000, 1, 'CASH', NULL, 'OFFLINE', NULL),
(9, 'ORD003', '2023-09-25', NULL, NULL, 2, 2, 500, 0, 14500, 1, 'CASH', NULL, 'OFFLINE', NULL),
(10, 'DEL001', '2023-10-05', NULL, '2023-10-15', 3, 1, 0, 0, 5100000, 1, 'CASH', NULL, 'DELIVERY', 2),
(11, 'ORD003', '2023-10-04', NULL, NULL, 1, 1, 500, 0, 24500, 2, 'CREDIT', '2023-10-12', 'OFFLINE', NULL),
(12, 'ORD005', '2023-10-04', NULL, NULL, 1, 1, 500, 150, 24350, 1, 'CASH', NULL, 'OFFLINE', NULL),
(13, 'DEL002', '2023-10-12', NULL, '2023-10-26', 2, 1, 0, 0, 5000000, 5, 'CASH', NULL, 'DELIVERY', 3),
(14, 'DEL003', '2023-10-13', NULL, '2023-10-26', 4, 1, 2000, 0, 5208000, 5, 'CASH', NULL, 'DELIVERY', 3),
(15, 'DEL005', '2023-10-15', NULL, '2023-10-24', 1, 1, 0, 150, 14999850, 5, 'CREDIT', '2023-11-15', 'DELIVERY', 4),
(16, 'DEL006', '2023-10-17', NULL, '2023-10-24', 2, 1, 0, 5000, 10057500, 5, 'CREDIT', '2023-10-03', 'DELIVERY', 4),
(17, 'DEL007', '2023-10-17', NULL, NULL, 1, 1, 500, 150, 5024350, 3, 'CASH', NULL, 'DELIVERY', NULL),
(18, 'DEL008', '2023-10-17', NULL, NULL, 4, 1, 0, 5208, 5003792, 3, 'CASH', NULL, 'DELIVERY', NULL);

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
(30, 'ROK001', 'ROKOK SURYA', 1),
(31, 'ROK002', 'ROKOK MALBORO', 1),
(32, 'AQ001', 'AQUA 350ML', 2),
(33, 'ROK003', 'ROKOK SAMPOERNA', 1),
(34, 'AQ003', 'AQUA 1.5 L', 2),
(35, 'TES001', 'Tes Barang Mahal', 1);

-- --------------------------------------------------------

--
-- Table structure for table `log_terima_barang`
--

CREATE TABLE `log_terima_barang` (
  `id` int(11) NOT NULL,
  `id_inventory` int(11) NOT NULL,
  `id_h_purchase_order` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `pengiriman_ke` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `exp_date` date NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `log_terima_barang`
--

INSERT INTO `log_terima_barang` (`id`, `id_inventory`, `id_h_purchase_order`, `id_unit`, `pengiriman_ke`, `qty`, `created_date`, `exp_date`, `keterangan`) VALUES
(10, 30, 20, 118, 1, 5, '2023-09-25 02:54:52', '2023-09-25', ''),
(11, 30, 20, 119, 1, 5, '2023-09-25 02:54:52', '2023-09-25', ''),
(12, 31, 20, 120, 1, 5, '2023-09-25 02:54:52', '2023-09-25', ''),
(13, 31, 20, 121, 1, 5, '2023-09-25 02:54:52', '2023-09-25', ''),
(15, 30, 20, 118, 2, 5, '2023-09-25 03:18:17', '2023-09-25', ''),
(16, 30, 20, 118, 3, 5, '2023-09-25 03:18:46', '2023-09-25', ''),
(17, 31, 20, 120, 4, 15, '2023-09-25 03:18:46', '2023-09-25', ''),
(18, 31, 20, 121, 5, 10, '2023-09-25 03:18:46', '2023-09-25', ''),
(19, 30, 20, 118, 6, 5, '2023-09-25 03:20:49', '2023-09-25', ''),
(20, 31, 20, 120, 6, 5, '2023-09-25 03:20:49', '2023-09-25', ''),
(21, 30, 20, 118, 7, 5, '2023-09-25 03:21:08', '2023-09-25', ''),
(22, 30, 20, 119, 7, 10, '2023-09-25 03:21:08', '2023-09-25', ''),
(23, 33, 21, 124, 1, 5, '2023-10-02 13:36:02', '2023-10-02', 'tes'),
(24, 33, 21, 125, 1, 5, '2023-10-02 13:36:02', '2023-10-02', 'full'),
(25, 33, 21, 124, 2, 15, '2023-10-02 13:36:54', '2023-10-02', ''),
(32, 32, 22, 123, 1, 5, '2023-10-03 14:44:30', '2023-10-03', ''),
(33, 32, 22, 123, 2, 20, '2023-10-03 14:51:49', '2023-10-03', ''),
(34, 34, 23, 127, 1, 10, '2023-10-03 16:06:19', '2023-10-03', ''),
(35, 34, 23, 127, 2, 5, '2023-10-03 16:08:49', '2023-10-03', ''),
(36, 30, 24, 118, 1, 15, '2023-10-03 16:33:39', '2023-10-03', 'tes'),
(37, 30, 25, 119, 1, 50, '2023-10-04 13:16:51', '2023-10-04', ''),
(38, 31, 25, 121, 1, 50, '2023-10-04 13:16:51', '2023-10-04', ''),
(39, 33, 25, 126, 1, 100, '2023-10-04 13:16:51', '2023-10-04', ''),
(40, 35, 26, 129, 1, 150, '2023-10-12 13:16:38', '2023-10-12', ''),
(41, 35, 26, 130, 1, 150, '2023-10-12 13:16:38', '2023-10-12', '');

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
(5, 'MASTER_CATEGORY'),
(6, 'TRANSACTION'),
(7, 'MASTER_ROLE'),
(8, 'PURCHASE_ORDER'),
(9, 'MASTER_DISKON'),
(10, 'DASHBOARD'),
(12, 'MASTER_SETTING'),
(13, 'PENGIRIMAN');

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
(64, 2, 2),
(65, 2, 4),
(66, 2, 5),
(67, 2, 6),
(68, 2, 10),
(69, 7, 4),
(70, 7, 5),
(71, 7, 10),
(94, 1, 1),
(95, 1, 2),
(96, 1, 3),
(97, 1, 4),
(98, 1, 5),
(99, 1, 6),
(100, 1, 7),
(101, 1, 8),
(102, 1, 9),
(103, 1, 10),
(104, 1, 12),
(105, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `product_supplier`
--

CREATE TABLE `product_supplier` (
  `id` int(8) NOT NULL,
  `id_supplier` int(8) NOT NULL,
  `id_product` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_supplier`
--

INSERT INTO `product_supplier` (`id`, `id_supplier`, `id_product`) VALUES
(15, 10, 32),
(16, 10, 34),
(17, 9, 30),
(18, 9, 31),
(19, 9, 33),
(20, 9, 35);

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
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name`, `value`) VALUES
(1, 'MINIMAL_BELANJA_CASHBACK_POINT', 100000),
(2, 'NILAI_CASHBACK_POIN_RUPIAH', 100);

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
(9, 'SUPLLIER ROKOK', 'SUP001', '628123463331234', 'Harington St'),
(10, 'SUPPLIER AQUA', 'SUP002', '6281234633124', 'Srezxa St');

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
(435, 31, 120, 'general', 25000),
(436, 31, 120, 'bronze', 20000),
(437, 31, 120, 'silver', 15000),
(438, 31, 120, 'gold', 10000),
(439, 31, 121, 'general', 35000),
(440, 31, 121, 'bronze', 30000),
(441, 31, 121, 'silver', 30000),
(442, 31, 121, 'gold', 30000),
(443, 32, 122, 'general', 4500),
(444, 32, 122, 'bronze', 4500),
(445, 32, 122, 'silver', 4000),
(446, 32, 122, 'gold', 4000),
(447, 32, 123, 'general', 25000),
(448, 32, 123, 'bronze', 25000),
(449, 32, 123, 'silver', 25000),
(450, 32, 123, 'gold', 25000),
(459, 33, 124, 'general', 15000),
(460, 33, 124, 'bronze', 15000),
(461, 33, 124, 'silver', 12500),
(462, 33, 124, 'gold', 12500),
(463, 33, 125, 'general', 150000),
(464, 33, 125, 'bronze', 150000),
(465, 33, 125, 'silver', 125000),
(466, 33, 125, 'gold', 125000),
(467, 33, 126, 'general', 300000),
(468, 33, 126, 'bronze', 300000),
(469, 33, 126, 'silver', 300000),
(470, 33, 126, 'gold', 300000),
(471, 34, 127, 'general', 6500),
(472, 34, 127, 'bronze', 6500),
(473, 34, 127, 'silver', 6000),
(474, 34, 127, 'gold', 6000),
(475, 34, 128, 'general', 65000),
(476, 34, 128, 'bronze', 65000),
(477, 34, 128, 'silver', 60000),
(478, 34, 128, 'gold', 60000),
(487, 30, 118, 'general', 15000),
(488, 30, 118, 'bronze', 12500),
(489, 30, 118, 'silver', 10000),
(490, 30, 118, 'gold', 5000),
(491, 30, 119, 'general', 25000),
(492, 30, 119, 'bronze', 20000),
(493, 30, 119, 'silver', 20000),
(494, 30, 119, 'gold', 20000),
(495, 35, 129, 'general', 1000000),
(496, 35, 129, 'bronze', 1000000),
(497, 35, 129, 'silver', 1000000),
(498, 35, 129, 'gold', 1000000),
(499, 35, 130, 'general', 10000000),
(500, 35, 130, 'bronze', 10000000),
(501, 35, 130, 'silver', 10000000),
(502, 35, 130, 'gold', 10000000);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty_reference` int(11) DEFAULT NULL,
  `id_inventory` int(8) DEFAULT NULL,
  `stok` int(8) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `name`, `qty_reference`, `id_inventory`, `stok`) VALUES
(118, 'pcs', NULL, 30, 28),
(119, 'dos', 24, 30, 66),
(120, 'pcs', NULL, 31, 20),
(121, 'lusin', 12, 31, 68),
(122, 'pcs', NULL, 32, 3),
(123, 'dos', 12, 32, 25),
(124, 'pcs', NULL, 33, 11),
(125, 'lusin', 12, 33, 5),
(126, 'dos', 24, 33, 83),
(127, 'pcs', NULL, 34, 15),
(128, 'dos', 12, 34, 0),
(129, 'pcs', NULL, 35, 125),
(130, 'dos', 12, 35, 148);

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
(2, 'kasir', '$2y$10$XgWgiLdhfaBtfyXfEnaS4ehinxaKi6mim2h5tuwgbVUCgTtVwzgiu', 2),
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
  ADD KEY `id_tier` (`tier_customer`);

--
-- Indexes for table `diskon`
--
ALTER TABLE `diskon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diskon_ibfk_1` (`id_inventory`),
  ADD KEY `diskon_ibfk_2` (`id_unit`);

--
-- Indexes for table `d_pengiriman`
--
ALTER TABLE `d_pengiriman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_h_pengiriman` (`id_h_pengiriman`),
  ADD KEY `id_h_transaction` (`id_h_transaction`);

--
-- Indexes for table `d_purchase_order`
--
ALTER TABLE `d_purchase_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_inventory` (`id_inventory`),
  ADD KEY `id_unit` (`id_unit`),
  ADD KEY `id_h_purchase_order` (`id_h_purchase_order`);

--
-- Indexes for table `d_transaction`
--
ALTER TABLE `d_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_h_transaction` (`id_h_transaction`),
  ADD KEY `id_inventory` (`id_inventory`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `h_pengiriman`
--
ALTER TABLE `h_pengiriman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h_purchase_order`
--
ALTER TABLE `h_purchase_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h_transaction`
--
ALTER TABLE `h_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cashier` (`id_cashier`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_h_pengiriman` (`id_h_pengiriman`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `log_terima_barang`
--
ALTER TABLE `log_terima_barang`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_product` (`id_product`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `tier_pricing`
--
ALTER TABLE `tier_pricing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_inventory` (`id_inventory`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_ibfk_1` (`id_inventory`);

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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `diskon`
--
ALTER TABLE `diskon`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `d_pengiriman`
--
ALTER TABLE `d_pengiriman`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `d_purchase_order`
--
ALTER TABLE `d_purchase_order`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `d_transaction`
--
ALTER TABLE `d_transaction`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `h_pengiriman`
--
ALTER TABLE `h_pengiriman`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `h_purchase_order`
--
ALTER TABLE `h_purchase_order`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `h_transaction`
--
ALTER TABLE `h_transaction`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `log_terima_barang`
--
ALTER TABLE `log_terima_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `product_supplier`
--
ALTER TABLE `product_supplier`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tier_pricing`
--
ALTER TABLE `tier_pricing`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=503;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diskon`
--
ALTER TABLE `diskon`
  ADD CONSTRAINT `diskon_ibfk_1` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `diskon_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `d_pengiriman`
--
ALTER TABLE `d_pengiriman`
  ADD CONSTRAINT `d_pengiriman_ibfk_1` FOREIGN KEY (`id_h_pengiriman`) REFERENCES `h_pengiriman` (`id`),
  ADD CONSTRAINT `d_pengiriman_ibfk_2` FOREIGN KEY (`id_h_transaction`) REFERENCES `h_transaction` (`id`);

--
-- Constraints for table `d_purchase_order`
--
ALTER TABLE `d_purchase_order`
  ADD CONSTRAINT `d_purchase_order_ibfk_1` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_purchase_order_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `d_purchase_order_ibfk_3` FOREIGN KEY (`id_h_purchase_order`) REFERENCES `h_purchase_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `d_transaction`
--
ALTER TABLE `d_transaction`
  ADD CONSTRAINT `d_transaction_ibfk_1` FOREIGN KEY (`id_h_transaction`) REFERENCES `h_transaction` (`id`),
  ADD CONSTRAINT `d_transaction_ibfk_2` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `d_transaction_ibfk_3` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id`);

--
-- Constraints for table `h_transaction`
--
ALTER TABLE `h_transaction`
  ADD CONSTRAINT `h_transaction_ibfk_1` FOREIGN KEY (`id_cashier`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `h_transaction_ibfk_2` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `h_transaction_ibfk_3` FOREIGN KEY (`id_h_pengiriman`) REFERENCES `h_pengiriman` (`id`);

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`id_permission`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_supplier`
--
ALTER TABLE `product_supplier`
  ADD CONSTRAINT `product_supplier_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `inventory` (`id`),
  ADD CONSTRAINT `product_supplier_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `tier_pricing`
--
ALTER TABLE `tier_pricing`
  ADD CONSTRAINT `tier_pricing_ibfk_1` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tier_pricing_ibfk_2` FOREIGN KEY (`id_unit`) REFERENCES `unit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `unit`
--
ALTER TABLE `unit`
  ADD CONSTRAINT `unit_ibfk_1` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
