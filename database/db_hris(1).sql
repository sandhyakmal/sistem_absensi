-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 03, 2025 at 12:15 PM
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
(15, '6', '2025-01-02', 'agya.png', 'sa', 'sakit', 'submit'),
(16, '1', '2025-01-03', NULL, 'Cuti', 'cuti', 'submit');

-- --------------------------------------------------------

--
-- Table structure for table `tb_absensi`
--

CREATE TABLE `tb_absensi` (
  `id` int(11) NOT NULL,
  `id_jadwal` varchar(255) DEFAULT NULL,
  `tanggal_kerja` varchar(255) NOT NULL,
  `jam_in` varchar(255) DEFAULT NULL,
  `jam_out` varchar(255) DEFAULT NULL,
  `id_karyawan` varchar(255) NOT NULL,
  `durasi_lembur` varchar(255) DEFAULT NULL,
  `upah_lembur` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_absensi`
--

INSERT INTO `tb_absensi` (`id`, `id_jadwal`, `tanggal_kerja`, `jam_in`, `jam_out`, `id_karyawan`, `durasi_lembur`, `upah_lembur`, `status`) VALUES
(21, '49', '2025-01-01', NULL, NULL, '1', NULL, NULL, NULL),
(22, '49', '2025-01-01', '12:00:00', '18:00:00', '6', NULL, NULL, NULL),
(29, '50', '2025-01-03', '12:00:00', '19:06:59', '6', '01:06:59', '16500', NULL),
(30, '50', '2025-01-03', NULL, NULL, '1', NULL, NULL, NULL);

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
(43, '2025-01-02', 'approve'),
(49, '2025-01-01', 'approve'),
(50, '2025-01-03', 'approve');

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
('43', '6', '1'),
('49', '1', '1'),
('49', '6', '2'),
('50', '6', '1'),
('50', '1', '2');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_absensi`
--
ALTER TABLE `tb_absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tb_payroll`
--
ALTER TABLE `tb_payroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
