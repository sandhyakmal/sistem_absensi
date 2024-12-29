-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Dec 14, 2024 at 06:59 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hris`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen`
--

CREATE TABLE `tb_absen` (
  `id` int(11) NOT NULL,
  `id_karyawan` varchar(255) NOT NULL,
  `tanggal_absen` varchar(255) NOT NULL,
  `surat_sakit` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) NOT NULL,
  `type_absen` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_absen`
--

INSERT INTO `tb_absen` (`id`, `id_karyawan`, `tanggal_absen`, `surat_sakit`, `keterangan`, `type_absen`, `status`) VALUES
(5, '6', '2024-11-07', 'Background hardcode Klik Garasi-04.jpg', 'Sakit', 'sakit', 'submit'),
(7, '6', '2024-11-08', NULL, 'Cuti', 'cuti', 'reject'),
(8, '1', '2024-11-07', 'Background hardcode Klik Garasi-04.jpg', 'Sakit', 'sakit', 'submit'),
(9, '1', '2024-11-08', NULL, 'Cuti', 'cuti', 'reject');

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id` int(11) NOT NULL,
  `tanggal_kerja` varchar(255) NOT NULL,
  `jam_in` varchar(255) DEFAULT NULL,
  `jam_out` varchar(255) DEFAULT NULL,
  `id_karyawan` varchar(255) NOT NULL,
  `durasi_lembur` varchar(255) DEFAULT NULL,
  `upah_lembur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_absensi`
--

INSERT INTO `tb_absensi` (`id`, `tanggal_kerja`, `jam_in`, `jam_out`, `id_karyawan`, `durasi_lembur`, `upah_lembur`) VALUES
(1, '2024-11-09', '12:52:48', '20:02:35', '6', '02:02:35', '30500'),
(2, '2024-11-08', '12:52:48', '20:02:35', '1', '02:02:35', '30500'),
(3, '2024-11-08', '12:52:48', '20:02:35', '6', '02:02:35', '20000'),
(4, '2024-11-12', '10:50:13', NULL, '6', NULL, NULL),
(7, '2024-12-14', '12:51:57', NULL, '6', NULL, NULL),
(8, '2024-12-16', NULL, '12:52:04', '6', '00:00:00', '0'),
(9, '2024-12-17', '13:17:22', NULL, '6', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id` int(11) NOT NULL,
  `tanggal_kerja` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_jadwal`
--

INSERT INTO `tb_jadwal` (`id`, `tanggal_kerja`, `status`) VALUES
(35, '2024-11-09', 'approve'),
(36, '2024-11-12', 'approve'),
(37, '2024-12-14', 'approve'),
(38, '2024-12-16', 'approve'),
(39, '2024-12-17', 'approve'),
(40, '2024-12-18', 'approve');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal_detail`
--

CREATE TABLE `tb_jadwal_detail` (
  `id_jadwal` varchar(255) NOT NULL,
  `id_karyawan` varchar(255) NOT NULL,
  `shift` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_jadwal_detail`
--

INSERT INTO `tb_jadwal_detail` (`id_jadwal`, `id_karyawan`, `shift`) VALUES
('35', '1', '2'),
('35', '6', '1'),
('35', '5', '1'),
('36', '1', '1'),
('36', '6', '2'),
('37', '6', '1'),
('38', '6', '1'),
('39', '6', '1'),
('40', '6', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_payroll`
--

CREATE TABLE `tb_payroll` (
  `id` int(11) NOT NULL,
  `id_karyawan` varchar(255) NOT NULL,
  `bulan_payroll` varchar(255) NOT NULL,
  `tahun_payroll` varchar(255) NOT NULL,
  `potongan` varchar(255) NOT NULL,
  `keterangan_potongan` varchar(255) NOT NULL,
  `bonus` varchar(255) NOT NULL,
  `total_lembur` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_payroll`
--

INSERT INTO `tb_payroll` (`id`, `id_karyawan`, `bulan_payroll`, `tahun_payroll`, `potongan`, `keterangan_potongan`, `bonus`, `total_lembur`, `total`) VALUES
(6, '6', '11', '2024', '100000', 'Dipotong karena sering telat', '500000', '50500', '6450500'),
(10, '6', '12', '2024', '1200000', 'Banyak tidak edit abse dan tanpa keterangan', '500000', '0', '5300000');

-- --------------------------------------------------------

--
-- Table structure for table `tb_shift`
--

CREATE TABLE `tb_shift` (
  `id` int(11) NOT NULL,
  `jam_mulai` varchar(255) NOT NULL,
  `jam_akhir` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_shift`
--

INSERT INTO `tb_shift` (`id`, `jam_mulai`, `jam_akhir`) VALUES
(1, '13:00:00', '18:00:00'),
(2, '18:00:00', '23:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `salary` varchar(255) DEFAULT NULL,
  `upah_lembur` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `name`, `password`, `role`, `salary`, `upah_lembur`) VALUES
(1, 'Karyawan', 'karyawan', 'karyawan', '5000000', '15000'),
(2, 'Owner', 'owner', 'owner', '20000000', '15000'),
(4, 'Admin', 'admin', 'admin', '6000000', '15000'),
(5, 'karyawan1', 'karyawan1', 'karyawan', '4500000', '15000'),
(6, 'Sandhy', 'sandhy', 'karyawan', '6000000', '20000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_absen`
--
ALTER TABLE `tb_absen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_payroll`
--
ALTER TABLE `tb_payroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_shift`
--
ALTER TABLE `tb_shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_absen`
--
ALTER TABLE `tb_absen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tb_payroll`
--
ALTER TABLE `tb_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_shift`
--
ALTER TABLE `tb_shift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
