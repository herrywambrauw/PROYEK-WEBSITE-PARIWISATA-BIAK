-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- 
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 11:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `pariwisata`

-- --------------------------------------------------------

-- Table structure for table `aktifitas`

CREATE TABLE `aktifitas` (
  `kd_aktifitas` int(10) NOT NULL,
  `nama_aktifitas` varchar(100) NOT NULL,
  `durasi_aktifitas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `aktifitas`

INSERT INTO `aktifitas` (`kd_aktifitas`, `nama_aktifitas`, `durasi_aktifitas`) VALUES
(1, 'Wisata Budaya', 'Pengunjung dapat belajar dan ikut serta dalam tarian adat bersama masyarakat lokal');

-- --------------------------------------------------------

-- Table structure for table `fasilitas`

CREATE TABLE `fasilitas` (
  `kd_fasilitas` int(10) NOT NULL,
  `nama_fasilitas` varchar(50) NOT NULL,
  `ket_fasilitas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `fasilitas`

INSERT INTO `fasilitas` (`kd_fasilitas`, `nama_fasilitas`, `ket_fasilitas`) VALUES
(1, 'Area Parkir', 'Memadai untuk kendaraan roda dua dan roda empat'),
(2, 'Pondok untuk Bersantai', 'Disediakan untuk bersantai sambil menikmati suasana desa.'),
(3, 'Homestay Sederhana', 'Dikelola oleh masyarakat lokal, cocok untuk wisatawan yang ingin bermalam dan merasakan kehidupan pedesaan.\r\n');

-- --------------------------------------------------------

-- Table structure for table `jarak`

CREATE TABLE `jarak` (
  `kd_jarak` int(10) NOT NULL,
  `jarak_tempuh` varchar(10) NOT NULL,
  `waktu_tempuh` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `jarak`

INSERT INTO `jarak` (`kd_jarak`, `jarak_tempuh`, `waktu_tempuh`) VALUES
(1, '15 km', '30 Menit');

-- --------------------------------------------------------

-- Table structure for table `objek_wisata`

CREATE TABLE `objek_wisata` (
  `kd_objek` int(10) NOT NULL,
  `kd_fasilitas` JSON NOT NULL,
  `kd_jarak` int(10) NOT NULL,
  `kd_aktifitas` JSON NOT NULL,
  `id_pengelola` int(10) NOT NULL,
  `nama_objek` varchar(100) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `harga_tiket` varchar(50) NOT NULL,
  `estimasi_waktu` varchar(50) NOT NULL,
  `ket_objek` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `objek_wisata`

INSERT INTO `objek_wisata` (`kd_objek`, `kd_fasilitas`, `kd_jarak`, `kd_aktifitas`, `id_pengelola`, `nama_objek`, `alamat`, `harga_tiket`, `estimasi_waktu`, `ket_objek`) VALUES
(2, '[1]', 1, '[1]', 1, 'Dewa', 'Jl, Kanoman', '10000', '30 Menit', 'Langit Terang'),
(16, '[2]', 1, '[1]', 1, 'Dewa22', 'Jl. Garuda', '10.000', '30 Menit', 'indp');

-- --------------------------------------------------------

-- Table structure for table `pengelola`

CREATE TABLE `pengelola` (
  `id_pengelola` int(10) NOT NULL,
  `nama_pengelola` varchar(50) NOT NULL,
  `kontak_pengelola` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `pengelola`

INSERT INTO `pengelola` (`id_pengelola`, `nama_pengelola`, `kontak_pengelola`) VALUES
(1, 'Komunitas Masyarakat Desa Anggaduber', 361971821);

-- --------------------------------------------------------

-- Indexes for dumped tables

-- Indexes for table `aktifitas`
ALTER TABLE `aktifitas`
  ADD PRIMARY KEY (`kd_aktifitas`);

-- Indexes for table `fasilitas`
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`kd_fasilitas`);

-- Indexes for table `jarak`
ALTER TABLE `jarak`
  ADD PRIMARY KEY (`kd_jarak`);

-- Indexes for table `objek_wisata`
ALTER TABLE `objek_wisata`
  ADD PRIMARY KEY (`kd_objek`),
  ADD KEY `kd_fasilitas` (`kd_fasilitas`),
  ADD KEY `kd_jarak` (`kd_jarak`),
  ADD KEY `kd_aktifitas` (`kd_aktifitas`),
  ADD KEY `id_pengelola` (`id_pengelola`);

-- Indexes for table `pengelola`
ALTER TABLE `pengelola`
  ADD PRIMARY KEY (`id_pengelola`);

-- --------------------------------------------------------

-- AUTO_INCREMENT for dumped tables

-- AUTO_INCREMENT for table `aktifitas`
ALTER TABLE `aktifitas`
  MODIFY `kd_aktifitas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

-- AUTO_INCREMENT for table `fasilitas`
ALTER TABLE `fasilitas`
  MODIFY `kd_fasilitas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT for table `jarak`
ALTER TABLE `jarak`
  MODIFY `kd_jarak` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- AUTO_INCREMENT for table `objek_wisata`
ALTER TABLE `objek_wisata`
  MODIFY `kd_objek` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

-- AUTO_INCREMENT for table `pengelola`
ALTER TABLE `pengelola`
  MODIFY `id_pengelola` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

-- Constraints for table `objek_wisata`
ALTER TABLE `objek_wisata`
  ADD CONSTRAINT `objek_wisata_ibfk_1` FOREIGN KEY (`id_pengelola`) REFERENCES `pengelola` (`id_pengelola`),
  ADD CONSTRAINT `objek_wisata_ibfk_2` FOREIGN KEY (`kd_jarak`) REFERENCES `jarak` (`kd_jarak`),
  ADD CONSTRAINT `objek_wisata_ibfk_3` FOREIGN KEY (`kd_aktifitas`) REFERENCES `aktifitas` (`kd_aktifitas`),
  ADD CONSTRAINT `objek_wisata_ibfk_4` FOREIGN KEY (`kd_fasilitas`) REFERENCES `fasilitas` (`kd_fasilitas`);

COMMIT;
