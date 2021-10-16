-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2021 at 09:36 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `bantu_pelanggan`
--

CREATE TABLE `bantu_pelanggan` (
  `id` int(11) NOT NULL,
  `memberid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bantu_pelanggan`
--

INSERT INTO `bantu_pelanggan` (`id`, `memberid`) VALUES
(1, '888108');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `memberid` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `point` int(100) NOT NULL,
  `alamat` text NOT NULL,
  `telepon` varchar(100) NOT NULL,
  `nik` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `memberid`, `nama`, `point`, `alamat`, `telepon`, `nik`) VALUES
(20, '888101', 'Jajang suherman', 300, 'Jl Tebet Dalam raya', '08965873432', '1234567890123456'),
(22, '888103', 'Ibrahim', 5, 'Jl cikole', '75834535', '1234567890123456'),
(24, '888105', 'Ibrahim aji', 13, 'jl penggansaan', '89475893475', '1234567890123456'),
(26, '888107', 'Aksyal', 100, 'Jl Pancoran', '0897654321', '1234567890123456');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama`, `role`) VALUES
(1, 'admin', '$2y$10$/I7laWi1mlNFxYSv54EUPOH8MuZhmRWxhE.LaddTK9TSmVe.IHP2C', 'Rizky Aksyal', '1'),
(3, 'kasirumum', '$2y$10$/I7laWi1mlNFxYSv54EUPOH8MuZhmRWxhE.LaddTK9TSmVe.IHP2C', 'Jajang Nurjaman', '2');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga_asli` varchar(255) NOT NULL,
  `harga_grosir` varchar(255) NOT NULL,
  `harga_biasa` varchar(255) NOT NULL,
  `jml_grosir` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `barcode`, `nama`, `harga_asli`, `harga_grosir`, `harga_biasa`, `jml_grosir`) VALUES
(1, 'sabun detol', 'Sabun detol 250g', '4500', '5000', '6500', 10),
(2, 'roko djarum', 'Roko Djarum super 12', '1700', '19000', '21000', 5),
(3, 'oreo kecil', 'Oreo red velvet 2000', '1500', '2000', '2500', 8),
(5, 'aqua galon', 'Aqua Galon 19L', '17500', '19500', '21500', 8),
(6, 'tisu paseo', 'Tisu Paseo 900g', '30000', '35000', '40000', 4),
(7, 'sampo clear', 'Sampo Clear 250 ml', '23000', '24000', '25000', 5),
(8, 'roko magnum', 'Roko magnum 12btg', '21000', '22000', '24000', 12);

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `minPoint` int(11) NOT NULL,
  `point` int(11) NOT NULL,
  `jumUang` int(255) NOT NULL,
  `uang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id`, `nama`, `alamat`, `minPoint`, `point`, `jumUang`, `uang`) VALUES
(1, 'Toko Cirebon', 'Jl Cirebon No.69', 200, 1, 20000, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(20) NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_harga` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bayar` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_uang` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pelanggan` int(20) DEFAULT NULL,
  `nota` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kasir` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `barcode`, `qty`, `status_harga`, `total_bayar`, `jumlah_uang`, `pelanggan`, `nota`, `kasir`) VALUES
(2, '2021-10-09 11:48:39', '2,6,7', '1,5,2', '0,1,0', '246000', '250000', 20, 'NBLBRBXLD5OPU0D', 1),
(3, '2021-10-09 16:42:22', '2,7,5,3', '1,1,2,1', '0,0,0,0', '91500', '100000', 0, 'UP2XJJRRNNH4ON3', 1),
(4, '2021-10-09 17:41:17', '2,1,5', '12,1,1', '1,0,0', '28000', '30000', 20, '50K0GEQR5ZWAS0C', 1),
(5, '2021-10-09 17:42:06', '2,6', '1,2', '0,0', '101000', '110000', 20, 'UYBYNU8Q95K7KSA', 1),
(6, '2021-10-10 08:05:14', '1,6,7,8,3', '1,4,2,2,8', '0,1,0,0,1', '260500', '270000', 22, '5HRC4W8NL2UZFFE', 1),
(7, '2021-10-10 08:28:09', '2,6', '1,1', '0,0', '61000', '70000', 0, 'ADTUASH1CW4HUTV', 1),
(23, '2021-10-10 08:35:59', '5,6', '1,3', '0,0', '141500', '150000', 0, 'EXL9FPE1ZNK8ALE', 1),
(24, '2021-10-10 08:38:01', '3,6', '1,5', '0,1', '177500', '180000', 0, '8KW6DXEADZ8KVCZ', 1),
(25, '2021-10-10 20:11:18', '8,5', '1,1', '0,0', '45500', '50000', 22, '41YKFTQ4VJFS8T8', 1),
(26, '2021-10-10 20:12:32', '2,6', '1,4', '0,1', '161000', '170000', 22, 'L4H27I5OBKW3RHQ', 1),
(27, '2021-10-10 20:17:40', '2,7,1,6', '3,1,1,1', '0,0,0,0', '134500', '150000', 26, '0TOJAOBYCT6V02H', 1),
(28, '2021-10-10 20:19:18', '3,7,3,6', '2,1,2,3', '0,0,0,0', '155000', '160000', 26, '9XMUSDRKSAOXUJZ', 1),
(29, '2021-10-10 20:20:21', '2', '1', '0', '21000', '22000', 0, '7YFRA2SL808MXE0', 1),
(30, '2021-10-10 21:27:29', '3', '12', '1', '24000', '25000', 22, 'KCBJ90YPVEFG53J', 1),
(31, '2021-10-10 21:30:33', '2', '1', '0', '21000', '22000', 26, 'MZEBVZ3Y1D3NCAD', 1),
(32, '2021-10-10 21:52:17', '5,8,6', '3,2,5', '0,0,1', '287500', '300000', 26, 'NAH4H09NU7IRRAR', 1),
(33, '2021-10-10 22:05:55', '3', '1', '0', '2500', '3000', 22, 'UGQ41H6U3XBUQAK', 3),
(34, '2021-10-11 05:12:40', '1', '1', '0', '6500', '7000', 0, 'Y41MZ3UMX0653P7', 1),
(35, '2021-10-11 11:33:43', '2', '1', '0', '21000', '22000', 22, '4OFPDJ41XQTB6IQ', 3),
(36, '2021-10-16 05:06:06', '2,8', '1,3', '0,0', '93000', '100000', 24, 'MWBTYSVGURY72I9', 1),
(37, '2021-10-16 05:08:17', '2', '1', '0', '21000', '22000', 24, 'Q808J1FP7L0GCXI', 1),
(38, '2021-10-16 05:25:18', '2,6', '1,2', '0,0', '101000', '150000', 0, '05AWZNHKIZN1150', 1),
(39, '2021-10-16 05:28:11', '3,5', '2,1', '0,0', '26500', '30000', 26, 'F16SIK60A6BR7G3', 1),
(40, '2021-10-16 05:29:18', '7,5', '1,2', '0,0', '68000', '70000', 24, 'J45J7LVLC6VO67N', 1),
(41, '2021-10-16 05:31:00', '3,7', '3,5', '0,1', '127500', '150000', 20, 'EZ313A5IV0R7YC0', 1),
(42, '2021-10-16 05:46:07', '3', '1', '0', '2500', '5000', 24, '1610202145YKZ5Q', 1),
(43, '2021-10-16 05:49:50', '3', '1', '0', '2500', '2500', 22, '1610202149C7AP3', 1),
(44, '2021-10-16 05:50:20', '3', '4', '0', '10000', '12000', 20, '1610202150POWPJ', 1),
(45, '2021-10-16 05:52:17', '2', '3', '0', '63000', '70000', 24, '1610202152DSC1D', 1),
(46, '2021-10-16 05:53:06', '5,1', '1,2', '0,0', '34500', '39000', 20, '161020215257UD9', 1),
(47, '2021-10-16 05:54:34', '2', '3', '0', '63000', '70000', 24, '161020215468Y1F', 1),
(48, '2021-10-16 06:52:06', '5,7,2', '1,3,2', '0,0,0', '138500', '150000', 24, '16102021516GWUM', 1),
(49, '2021-10-16 06:55:05', '3,6', '1,2', '0,0', '82500', '100000', 24, '1610202154DTV7P', 1),
(50, '2021-10-16 06:58:03', '3,8', '1,2', '0,0', '50500', '100000', 20, '1610202157Q53MK', 3),
(51, '2021-10-16 07:07:09', '6,5,7', '1,2,1', '0,0,0', '108000', '140000', 24, '1610202106QXF80', 3),
(52, '2021-10-16 07:10:48', '5,6,2,8', '2,1,2,1', '0,0,0,0', '106000', '108000', 24, '1610202109IQVKV', 3),
(53, '2021-10-16 07:15:11', '5,7,8', '2,2,1', '0,0,0', '117000', '120000', 24, '1610202114U7JWI', 3),
(54, '2021-10-16 07:16:15', '6', '3', '0', '120000', '130000', 26, '1610202116X8O0K', 3),
(55, '2021-10-16 07:20:27', '2,8,6', '1,1,3', '0,0,0', '165000', '170000', 26, '16102021201SV6P', 3),
(56, '2021-10-16 07:23:14', '3,6', '4,1', '0,0', '50000', '50000', 26, '1610202122YUQQ7', 3),
(57, '2021-10-16 07:24:46', '1,7,5,8', '2,1,2,1', '0,0,0,0', '105000', '105000', 26, '1610202123DIY98', 3),
(58, '2021-10-16 07:28:35', '3,7,2', '6,3,1', '0,0,0', '111000', '111000', 20, '1610202127Q82CZ', 3),
(59, '2021-10-16 07:32:36', '3', '10', '1', '20000', '20000', 22, '1610202132MUR12', 3),
(60, '2021-10-16 07:34:55', '3', '10', '1', '20000', '20000', 22, '1610202134391ZE', 3),
(61, '2021-10-16 07:37:19', '3', '10', '1', '20000', '20000', 22, '1610202137GODCH', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tukar_point`
--

CREATE TABLE `tukar_point` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tukar_point` int(100) NOT NULL,
  `jumlah_uangkeluar` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tukar_point`
--

INSERT INTO `tukar_point` (`id`, `tanggal`, `id_pelanggan`, `tukar_point`, `jumlah_uangkeluar`) VALUES
(2, '0000-00-00 00:00:00', 888107, 200, 1000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bantu_pelanggan`
--
ALTER TABLE `bantu_pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD KEY `id` (`id`);

--
-- Indexes for table `tukar_point`
--
ALTER TABLE `tukar_point`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tukar_point`
--
ALTER TABLE `tukar_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
