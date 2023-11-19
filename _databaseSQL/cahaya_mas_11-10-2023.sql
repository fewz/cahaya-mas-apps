-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2023 at 01:17 PM
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
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `tier_customer` varchar(15) NOT NULL DEFAULT 'general',
  `poin` int(15) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `code`, `email`, `password`, `full_name`, `phone`, `address`, `tier_customer`, `poin`) VALUES
(1, 'AE0001', 'adrielegard@gmail.com', '$2y$10$o2v8qdZacZ67vDpGryPWduJDqAi3eKDeQTGd2/MtNPHhHhGC1HPXC', 'ADRIEL EDGARD', '085232654598', 'JL.TERNATE NO. 40, MAKASSAR', 'gold', 2900),
(2, 'KL0001', 'kennylisal@gmail.com', '', 'KENNY LISAL', '085656954252', 'JL. TANJUNG BUNGA NO. 50, MAKASSAR', 'silver', 5000),
(3, 'WES001', 'willyendri@gmail.com', '', 'WILLY ENDRI SETIAWAN', '085212353958', 'JL.BANDANG NO.205, MAKASSAR', 'bronze', 5600),
(4, 'EG0001', 'erlandgoeswanto@gmail.com', '', 'ERLAND GOESWANTO', '085212656958', 'JL. PONEGORO NO.80, MAKASSAR', 'general', 10212),
(8, 'WS001', 'williamsurya@gmail.com', '$2y$10$I9D3/pVrrmpJmjRURVkQO.DQ/OPffJxcn1Ph4J7Mwn3gWmHqvoulO', 'WILLIAM SURYA', '0812343392124', 'JL KARIMATA NO 445', 'general', 20900);

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
(13, 10, 45),
(14, 10, 44);

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
(123, 30, 30, 118, '2024-11-13', 100, 0, 100, 15000),
(124, 30, 30, 119, '2024-11-13', 100, 0, 100, 35000),
(125, 30, 31, 120, '2024-11-13', 100, 0, 100, 16000),
(126, 30, 31, 121, '2024-11-13', 100, 0, 100, 65000),
(127, 30, 33, 124, '2024-11-13', 100, 0, 100, 12000),
(128, 30, 33, 125, '2024-11-13', 100, 0, 100, 45000),
(129, 30, 33, 126, '2024-11-13', 100, 0, 100, 87000),
(130, 30, 35, 129, '2024-11-13', 100, 0, 100, 800000),
(131, 30, 35, 130, '2024-11-13', 100, 0, 100, 4000000),
(136, 31, 32, 122, '2024-11-13', 100, 0, 100, 3000),
(137, 31, 32, 123, '2024-11-13', 100, 0, 100, 25000),
(138, 31, 34, 127, '2024-11-13', 100, 0, 100, 5000),
(139, 31, 34, 128, '2024-11-13', 100, 0, 100, 40000),
(142, 32, 30, 118, '2024-11-13', 10, 0, 10, 16000),
(143, 32, 30, 119, '2024-11-13', 10, 0, 10, 20000);

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
  `sub_total` int(15) NOT NULL,
  `hpp` int(11) NOT NULL,
  `netto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `d_transaction`
--

INSERT INTO `d_transaction` (`id`, `id_h_transaction`, `id_inventory`, `id_unit`, `sell_price`, `qty`, `diskon`, `sub_total`, `hpp`, `netto`) VALUES
(63, 41, 30, 118, 14500, 5, 2500, 72500, 15000, -5000),
(64, 41, 30, 119, 40000, 5, 0, 200000, 35000, 25000),
(65, 42, 30, 118, 14500, 15, 7500, 217500, 15000, -15000),
(66, 42, 31, 120, 22000, 5, 7500, 110000, 16000, 22500),
(67, 42, 32, 122, 4000, 2, 0, 8000, 3000, 2000),
(68, 43, 33, 124, 15000, 25, 0, 375000, 12000, 75000),
(69, 43, 33, 125, 150000, 1, 0, 150000, 45000, 105000),
(70, 44, 34, 128, 65000, 95, 0, 6175000, 40000, 2375000),
(71, 45, 35, 130, 10000000, 1, 0, 10000000, 4000000, 6000000);

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
(10, 'DE1411230', 1, '2023-11-14', 'HADI');

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
(30, 9, '2023-11-14', '2023-11-14', 'PO1411230', 2, 507500000, NULL, 'CASH', 1, NULL),
(31, 10, '2023-11-14', '2023-11-14', 'PO1411231', 2, 7300000, NULL, 'CASH', 1, NULL),
(32, 9, '2023-11-14', '2023-11-14', 'PO1411232', 2, 360000, NULL, 'CASH', 1, NULL);

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
  `id_h_pengiriman` int(8) DEFAULT NULL,
  `netto` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `h_transaction`
--

INSERT INTO `h_transaction` (`id`, `order_number`, `created_date`, `finish_date`, `delivery_date`, `id_customer`, `id_cashier`, `total_diskon`, `diskon_poin`, `grand_total`, `status`, `payment_method`, `due_date`, `transaction_type`, `id_h_pengiriman`, `netto`) VALUES
(41, 'TR1411230', '2023-11-14', NULL, NULL, 1, 1, 2500, 0, 272500, 1, 'CASH', NULL, 'OFFLINE', NULL, 20000),
(42, 'TR1411231', '2023-11-14', NULL, NULL, 2, 1, 15000, 0, 335500, 2, 'CREDIT', '2023-11-21', 'OFFLINE', NULL, 9500),
(43, 'TR1411232', '2023-11-14', NULL, NULL, 3, 1, 0, 0, 525000, 1, 'CASH', NULL, 'OFFLINE', NULL, 180000),
(44, 'TR1411233', '2023-11-14', NULL, '2023-11-14', 4, 1, 0, 0, 6175000, 5, 'CREDIT', '2023-11-21', 'DELIVERY', 10, 2375000),
(45, 'TR1411234', '2023-11-14', NULL, '2023-11-14', 8, 1, 0, 0, 10000000, 5, 'CASH', NULL, 'DELIVERY', 10, 6000000);

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
(10, 30, 20, 118, 1, 5, '2023-09-25 02:54:52', '2023-11-23', ''),
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
(41, 35, 26, 130, 1, 150, '2023-10-12 13:16:38', '2023-10-12', ''),
(42, 30, 27, 118, 1, 25, '2023-10-23 06:58:41', '2023-10-23', ''),
(43, 31, 27, 120, 1, 35, '2023-10-23 06:58:41', '2023-10-23', ''),
(44, 33, 27, 124, 1, 15, '2023-10-23 06:58:41', '2023-10-23', ''),
(45, 30, 28, 118, 1, 5, '2023-11-14 14:37:27', '2024-11-13', ''),
(46, 30, 28, 119, 1, 15, '2023-11-14 14:37:27', '2024-11-13', ''),
(47, 30, 28, 118, 2, 10, '2023-11-14 14:37:58', '2024-11-13', ''),
(48, 30, 29, 118, 1, 5, '2023-11-14 14:44:19', '2024-11-13', ''),
(49, 31, 29, 120, 1, 5, '2023-11-14 14:44:19', '2024-11-13', ''),
(50, 31, 29, 121, 1, 5, '2023-11-14 14:44:19', '2024-11-13', ''),
(51, 33, 29, 124, 1, 5, '2023-11-14 14:44:19', '2024-11-13', ''),
(52, 33, 29, 125, 1, 5, '2023-11-14 14:44:19', '2024-11-13', ''),
(53, 33, 29, 126, 1, 5, '2023-11-14 14:44:19', '2024-11-13', ''),
(54, 35, 29, 129, 1, 5, '2023-11-14 14:44:19', '2024-11-13', ''),
(55, 35, 29, 130, 1, 5, '2023-11-14 14:44:19', '2024-11-13', ''),
(56, 30, 30, 118, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(57, 30, 30, 119, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(58, 31, 30, 120, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(59, 31, 30, 121, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(60, 33, 30, 124, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(61, 33, 30, 125, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(62, 33, 30, 126, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(63, 35, 30, 129, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(64, 35, 30, 130, 1, 100, '2023-11-14 15:03:46', '2024-11-13', ''),
(65, 32, 31, 122, 1, 100, '2023-11-14 15:04:44', '2024-11-13', ''),
(66, 32, 31, 123, 1, 100, '2023-11-14 15:04:44', '2024-11-13', ''),
(67, 34, 31, 127, 1, 100, '2023-11-14 15:04:44', '2024-11-13', ''),
(68, 34, 31, 128, 1, 100, '2023-11-14 15:04:44', '2024-11-13', ''),
(69, 30, 32, 118, 1, 5, '2023-11-14 15:21:57', '2024-11-13', ''),
(70, 30, 32, 119, 1, 5, '2023-11-14 15:21:57', '2024-11-13', ''),
(71, 30, 32, 118, 2, 5, '2023-11-14 15:22:35', '2024-11-13', ''),
(72, 30, 32, 119, 2, 5, '2023-11-14 15:22:35', '2024-11-13', '');

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
(13, 'PENGIRIMAN'),
(14, 'STOK_OPNAME'),
(15, 'LAPORAN_BARANG'),
(16, 'LAPORAN_PENJUALAN'),
(17, 'LAPORAN_PEMBELIAN');

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
(133, 1, 1),
(134, 1, 2),
(135, 1, 3),
(136, 1, 4),
(137, 1, 5),
(138, 1, 6),
(139, 1, 7),
(140, 1, 8),
(141, 1, 9),
(142, 1, 10),
(143, 1, 12),
(144, 1, 13),
(145, 1, 14),
(146, 1, 15),
(147, 1, 16),
(148, 1, 17);

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
-- Table structure for table `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id` int(8) NOT NULL,
  `id_unit` int(8) NOT NULL,
  `stok` int(11) NOT NULL,
  `stok_gudang` int(11) NOT NULL,
  `selisih` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stok_opname`
--

INSERT INTO `stok_opname` (`id`, `id_unit`, `stok`, `stok_gudang`, `selisih`, `id_user`, `status`, `created_date`, `notes`) VALUES
(2, 118, 37, 35, -2, 1, 1, '2023-11-02 14:31:19', NULL),
(3, 118, 35, 36, 1, 1, 1, '2023-11-02 14:49:36', NULL),
(4, 121, 68, 60, -8, 1, 0, '2023-11-02 14:53:06', 'hilang'),
(5, 119, 105, 100, -5, 1, 1, '2023-11-14 15:48:58', 'buka dos jadi pcs'),
(6, 118, 90, 120, 30, 1, 1, '2023-11-14 15:49:34', 'penambahan stok dari dos yang dibuka'),
(7, 118, 120, 100, -20, 1, 0, '2023-11-14 15:53:23', 'hilang');

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
(495, 35, 129, 'general', 1000000),
(496, 35, 129, 'bronze', 1000000),
(497, 35, 129, 'silver', 1000000),
(498, 35, 129, 'gold', 1000000),
(499, 35, 130, 'general', 10000000),
(500, 35, 130, 'bronze', 10000000),
(501, 35, 130, 'silver', 10000000),
(502, 35, 130, 'gold', 10000000),
(503, 32, 122, 'hpp', 3000),
(504, 32, 122, 'general', 4500),
(505, 32, 122, 'bronze', 4500),
(506, 32, 122, 'silver', 4000),
(507, 32, 122, 'gold', 4000),
(508, 32, 123, 'hpp', 25000),
(509, 32, 123, 'general', 35000),
(510, 32, 123, 'bronze', 35000),
(511, 32, 123, 'silver', 35000),
(512, 32, 123, 'gold', 35000),
(523, 31, 120, 'hpp', 16000),
(524, 31, 120, 'general', 25000),
(525, 31, 120, 'bronze', 20000),
(526, 31, 120, 'silver', 25000),
(527, 31, 120, 'gold', 20000),
(528, 31, 121, 'hpp', 65000),
(529, 31, 121, 'general', 75000),
(530, 31, 121, 'bronze', 70000),
(531, 31, 121, 'silver', 70000),
(532, 31, 121, 'gold', 70000),
(533, 30, 118, 'hpp', 15000),
(534, 30, 118, 'general', 17000),
(535, 30, 118, 'bronze', 16500),
(536, 30, 118, 'silver', 16000),
(537, 30, 118, 'gold', 15000),
(538, 30, 119, 'hpp', 35000),
(539, 30, 119, 'general', 45000),
(540, 30, 119, 'bronze', 40000),
(541, 30, 119, 'silver', 40000),
(542, 30, 119, 'gold', 40000);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(8) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty_reference` int(11) DEFAULT NULL,
  `id_inventory` int(8) DEFAULT NULL,
  `stok` int(8) NOT NULL DEFAULT 0,
  `hpp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `name`, `qty_reference`, `id_inventory`, `stok`, `hpp`) VALUES
(118, 'pcs', NULL, 30, 120, 15111),
(119, 'dos', 24, 30, 100, 33571),
(120, 'pcs', NULL, 31, 95, 16000),
(121, 'lusin', 12, 31, 100, 65000),
(122, 'pcs', NULL, 32, 98, 3000),
(123, 'dos', 12, 32, 100, 25000),
(124, 'pcs', NULL, 33, 75, 12000),
(125, 'lusin', 12, 33, 99, 45000),
(126, 'dos', 24, 33, 100, 87000),
(127, 'pcs', NULL, 34, 100, 5000),
(128, 'dos', 12, 34, 5, 40000),
(129, 'pcs', NULL, 35, 100, 800000),
(130, 'dos', 12, 35, 99, 4000000);

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
-- Indexes for table `stok_opname`
--
ALTER TABLE `stok_opname`
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
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `diskon`
--
ALTER TABLE `diskon`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `d_pengiriman`
--
ALTER TABLE `d_pengiriman`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `d_purchase_order`
--
ALTER TABLE `d_purchase_order`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `d_transaction`
--
ALTER TABLE `d_transaction`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `h_pengiriman`
--
ALTER TABLE `h_pengiriman`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `h_purchase_order`
--
ALTER TABLE `h_purchase_order`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `h_transaction`
--
ALTER TABLE `h_transaction`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `log_terima_barang`
--
ALTER TABLE `log_terima_barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `permission`
--
ALTER TABLE `permission`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `permission_role`
--
ALTER TABLE `permission_role`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

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
-- AUTO_INCREMENT for table `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tier_pricing`
--
ALTER TABLE `tier_pricing`
  MODIFY `id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=543;

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
