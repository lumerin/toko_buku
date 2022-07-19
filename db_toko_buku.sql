-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2018 at 11:27 AM
-- Server version: 5.6.24
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_toko_buku`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE IF NOT EXISTS `buku` (
  `id_buku` varchar(20) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `noisbn` varchar(20) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `tahun` varchar(10) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga_pokok` varchar(50) NOT NULL,
  `harga_jual` varchar(50) NOT NULL,
  `ppn` varchar(10) NOT NULL,
  `diskon` varchar(10) NOT NULL,
  `foto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `noisbn`, `penulis`, `penerbit`, `tahun`, `stok`, `harga_pokok`, `harga_jual`, `ppn`, `diskon`, `foto`) VALUES
('B00001', 'Koala Kumal', '9789797807696', 'Raditya Dika', 'GagasMedia', '2015', -2, '50000', '80000', '10%', '20%', 'WIN_20171205_123506.JPG'),
('B00002', 'Harry Potter dan Batu Bertuah', '617161001', 'J.K. Rowling', 'Gramedia Pustaka Utama ', '2017', 39, '110000', '130000', '10%', '0%', 'step 6.2.png'),
('B00003', 'Merry Riana Mimpi Sejuta Dolar  ', '9789792278477', 'Alberthiene Endah', 'Gramedia Pustaka Utama ', '2012', 69, '230000', '270000', '10%', '10%', 'step 6.2.png'),
('B00004', '123', '123', '123', '123', '123', 0, '123', '123', '10%', '123%', '1'),
('B00005', '123', '123', '123', '123', '1231', 9, '23123', '123', '10%', '123%', 'WIN_20171205_104237.JPG'),
('B00006', 'tes', '312', '123', '213', '123', 0, '123', '123', '10%', '41%', 'step 6.1.png');

-- --------------------------------------------------------

--
-- Table structure for table `distributor`
--

CREATE TABLE IF NOT EXISTS `distributor` (
  `id_distributor` varchar(20) NOT NULL,
  `nama_distributor` varchar(100) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `telepon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distributor`
--

INSERT INTO `distributor` (`id_distributor`, `nama_distributor`, `alamat`, `telepon`) VALUES
('D00001', 'Gyandi Fergiliawan', 'Cibeureum', 2147483647),
('D00002', 'Kevin Rizki', 'Lawang Gintung', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `pasok`
--

CREATE TABLE IF NOT EXISTS `pasok` (
  `id_pasok` varchar(20) NOT NULL,
  `id_distributor` varchar(20) NOT NULL,
  `id_buku` varchar(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pasok`
--

INSERT INTO `pasok` (`id_pasok`, `id_distributor`, `id_buku`, `jumlah`, `tanggal`) VALUES
('P00001', 'D00002', 'B00001', 10, '2017-12-10'),
('P00002', 'D00001', 'B00002', 50, '2017-12-10'),
('P00003', 'D00002', 'B00003', 75, '2017-12-10'),
('P00004', 'D00001', 'B00005', 10, '2017-12-11');

--
-- Triggers `pasok`
--
DELIMITER $$
CREATE TRIGGER `trigger_penambahan` AFTER INSERT ON `pasok`
 FOR EACH ROW BEGIN
UPDATE buku SET
stok = stok + new.jumlah
WHERE id_buku = new.id_buku;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE IF NOT EXISTS `penjualan` (
  `id_penjualan` varchar(100) NOT NULL DEFAULT '',
  `id_user` varchar(50) DEFAULT NULL,
  `jumlah` int(50) DEFAULT NULL,
  `total` int(50) DEFAULT NULL,
  `bayar` int(50) DEFAULT NULL,
  `kembalian` int(50) DEFAULT NULL,
  `tanggal` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `id_user`, `jumlah`, `total`, `bayar`, `kembalian`, `tanggal`) VALUES
('TK00001', 'admin', 7, 1330000, 0, NULL, '2018-01-11 03:31:17'),
('TK00002', 'kasir', 0, 0, 0, NULL, '2018-01-11 07:27:50');

--
-- Triggers `penjualan`
--
DELIMITER $$
CREATE TRIGGER `trigger_pindah_dan_hapus` AFTER INSERT ON `penjualan`
 FOR EACH ROW BEGIN
	INSERT INTO tb_detail_penjualan (id_penjualan,id_buku,jumlah,total_harga) SELECT id_penjualan,id_buku,jumlah_beli,total_harga FROM tmp_penjualan
WHERE id_penjualan = NEW.id_penjualan;
	DELETE FROM tmp_penjualan
	WHERE id_penjualan = NEW.id_penjualan;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `query_pasok`
--
CREATE TABLE IF NOT EXISTS `query_pasok` (
`id_pasok` varchar(20)
,`id_distributor` varchar(20)
,`id_buku` varchar(20)
,`jumlah` int(11)
,`tanggal` date
,`judul` varchar(100)
,`noisbn` varchar(20)
,`penulis` varchar(100)
,`penerbit` varchar(100)
,`harga_jual` varchar(50)
,`stok` int(11)
,`nama_distributor` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `query_penjualan`
--
CREATE TABLE IF NOT EXISTS `query_penjualan` (
`id_penjualan` varchar(100)
,`id_user` varchar(50)
,`jumlah` int(50)
,`total` int(50)
,`bayar` int(50)
,`kembalian` int(50)
,`tanggal` timestamp
,`nama` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_set_lap`
--

CREATE TABLE IF NOT EXISTS `tbl_set_lap` (
  `id_setting` int(11) NOT NULL,
  `nama_perusahaan` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_tlpn` varchar(15) NOT NULL,
  `web` varchar(50) NOT NULL,
  `logo` varchar(50) NOT NULL,
  `no_hp` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_penjualan`
--

CREATE TABLE IF NOT EXISTS `tb_detail_penjualan` (
  `id_penjualan` varchar(100) NOT NULL,
  `id_buku` varchar(100) NOT NULL,
  `jumlah` int(3) NOT NULL,
  `total_harga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_detail_penjualan`
--

INSERT INTO `tb_detail_penjualan` (`id_penjualan`, `id_buku`, `jumlah`, `total_harga`) VALUES
('TK00002', 'B00002', 3, 390000),
('TK00002', 'B00002', 1, 130000);

-- --------------------------------------------------------

--
-- Table structure for table `tmp_penjualan`
--

CREATE TABLE IF NOT EXISTS `tmp_penjualan` (
  `id_penjualan` varchar(100) NOT NULL,
  `id_buku` varchar(50) NOT NULL,
  `jumlah_beli` varchar(50) NOT NULL,
  `total_harga` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `tmp_penjualan`
--
DELIMITER $$
CREATE TRIGGER `trigger_batal` AFTER DELETE ON `tmp_penjualan`
 FOR EACH ROW BEGIN
UPDATE buku SET stok = stok + OLD.jumlah_beli
WHERE id_buku = OLD.id_buku;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trigger_pengurangan` BEFORE INSERT ON `tmp_penjualan`
 FOR EACH ROW BEGIN
UPDATE buku SET stok = stok - NEW.jumlah_beli
WHERE id_buku = NEW.id_buku;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(225) NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `status` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `akses` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `alamat`, `telepon`, `status`, `username`, `password`, `akses`) VALUES
('K001', 'Kampang', 'dimana', '0819371238', 'aktif', 'kampang', 'kampang123', 'Kasir'),
('K002', 'raka', 'jalan pamo', '0236677', 'Aktif', 'raka', '123', 'Admin'),
('K003', 'raihan', 'asd', '2312', 'Aktif', 'raihan', '123', 'Manager'),
('K004', 'Admin', 'Admin', '0001231', 'Aktif', 'admin', 'admin123', 'Admin'),
('K005', 'Manager', 'Manager', '21346', 'Aktif', 'manager', 'manager123', 'Manager'),
('K006', 'Kasir', 'Kasir', '123532', 'Aktif', 'kasir', 'kasir123', 'Kasir');

-- --------------------------------------------------------

--
-- Structure for view `query_pasok`
--
DROP TABLE IF EXISTS `query_pasok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_pasok` AS select `pasok`.`id_pasok` AS `id_pasok`,`pasok`.`id_distributor` AS `id_distributor`,`pasok`.`id_buku` AS `id_buku`,`pasok`.`jumlah` AS `jumlah`,`pasok`.`tanggal` AS `tanggal`,`buku`.`judul` AS `judul`,`buku`.`noisbn` AS `noisbn`,`buku`.`penulis` AS `penulis`,`buku`.`penerbit` AS `penerbit`,`buku`.`harga_jual` AS `harga_jual`,`buku`.`stok` AS `stok`,`distributor`.`nama_distributor` AS `nama_distributor` from ((`pasok` join `buku` on((`pasok`.`id_buku` = `buku`.`id_buku`))) join `distributor` on((`pasok`.`id_distributor` = `distributor`.`id_distributor`)));

-- --------------------------------------------------------

--
-- Structure for view `query_penjualan`
--
DROP TABLE IF EXISTS `query_penjualan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_penjualan` AS select `penjualan`.`id_penjualan` AS `id_penjualan`,`penjualan`.`id_user` AS `id_user`,`penjualan`.`jumlah` AS `jumlah`,`penjualan`.`total` AS `total`,`penjualan`.`bayar` AS `bayar`,`penjualan`.`kembalian` AS `kembalian`,`penjualan`.`tanggal` AS `tanggal`,`user`.`nama` AS `nama` from (`penjualan` join `user` on((`penjualan`.`id_user` = `user`.`id_user`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD UNIQUE KEY `id_buku` (`id_buku`);

--
-- Indexes for table `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`id_distributor`), ADD UNIQUE KEY `id_distributor` (`id_distributor`);

--
-- Indexes for table `pasok`
--
ALTER TABLE `pasok`
  ADD PRIMARY KEY (`id_pasok`), ADD KEY `id_distributor` (`id_distributor`,`id_buku`), ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`), ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tbl_set_lap`
--
ALTER TABLE `tbl_set_lap`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`), ADD UNIQUE KEY `id_kasir` (`id_user`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pasok`
--
ALTER TABLE `pasok`
ADD CONSTRAINT `pasok_ibfk_1` FOREIGN KEY (`id_distributor`) REFERENCES `distributor` (`id_distributor`),
ADD CONSTRAINT `pasok_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

--
-- Constraints for table `tmp_penjualan`
--
ALTER TABLE `tmp_penjualan`
ADD CONSTRAINT `tmp_penjualan_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
