-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2025 at 06:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pariwisata`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktifitas`
--

CREATE TABLE `aktifitas` (
  `kd_aktifitas` int(10) NOT NULL,
  `nama_aktifitas` varchar(50) NOT NULL,
  `durasi_aktifitas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktifitas`
--

INSERT INTO `aktifitas` (`kd_aktifitas`, `nama_aktifitas`, `durasi_aktifitas`) VALUES
(3, 'Bermain Pasir', 'sampai selesai'),
(4, 'Berenang ', 'Mengikuti jam operasional wisata'),
(5, 'Snorkeling ', '30 menit - 1 jam'),
(6, 'Menyelam (Diving)', '45 menit - 1 jam'),
(7, 'Tur Perahu', '30 menit - 1 jam'),
(8, 'Trekking di hutan', '1 - 2 jam'),
(9, 'Piknik', 'Mengikuti jam operasional wisata'),
(10, 'Olahraga pantai (Voli Pantai da Sepak Bola Pantai)', 'Mengikuti jam operasional wisata'),
(11, 'Eksplorasi Goa', '30 menit - 1 jam'),
(12, 'Fotografi', '20 menit - 30 menit'),
(13, 'Berendam ', 'Mengikuti jam operasional wisata'),
(14, 'Mendayung Perahu atau Kano', '15 menit - 20 menit');

-- --------------------------------------------------------

--
-- Table structure for table `fasilitas`
--

CREATE TABLE `fasilitas` (
  `kd_fasilitas` int(10) NOT NULL,
  `nama_fasilitas` varchar(50) NOT NULL,
  `ket_fasilitas` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasilitas`
--

INSERT INTO `fasilitas` (`kd_fasilitas`, `nama_fasilitas`, `ket_fasilitas`) VALUES
(12, 'Area Parkir', 'Tempat parkir kendaraan yang luas dan sering disediakan baik untuk mobil maupun sepeda motor. Biasanya dilengkapi dengan pengamanan dan petugas yang membantu pengaturan parkir.'),
(13, 'Kios makanan dan minuman', 'Menjual makanan ringan, minuman, dan kadang makanan khas daerah sekitar. Harga cenderung lebih tinggi dibandingkan harga normal.'),
(15, 'Toilet Umum', ' Fasilitas sanitasi yang tersedia di beberapa titik. Sering dilengkapi dengan wastafel dan sabun cuci tangan. Ada toilet duduk atau jongkok.'),
(16, 'Tempat Ibadah', 'Tempat Ibadah yang bersih dan nyaman bagi pengunjung wisata.'),
(17, 'Spot Foto', ' Area yang dirancang khusus untuk pengunjung mengambil foto. Sering dihiasi dengan dekorasi unik atau pemandangan alam yang indah.'),
(18, 'Tempat Duduk atau Gazebo', 'Area untuk istirahat. Bisa berupa bangku biasa, gazebo, atau tempat duduk dengan peneduh.'),
(21, 'Camping', 'Sampai selesai');

-- --------------------------------------------------------

--
-- Table structure for table `jarak`
--

CREATE TABLE `jarak` (
  `kd_jarak` int(10) NOT NULL,
  `jarak_tempuh` varchar(20) NOT NULL,
  `waktu_tempuh` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jarak`
--

INSERT INTO `jarak` (`kd_jarak`, `jarak_tempuh`, `waktu_tempuh`) VALUES
(22, '20 km', '1 jam'),
(23, '20 km', '1 jam'),
(24, '20 km', '30 menit'),
(25, '20 km', '30 menit'),
(26, '20 km', '50 menit '),
(27, '10 km', '20 Menit'),
(28, '10 km', '20 Menit'),
(29, '20 km', '1 jam'),
(30, '20 km', '1 jam'),
(31, '20 km', '45 menit '),
(32, '38 Km', '1 jam 19 menit dari '),
(33, '80 Km', 'Belum pasti dikarena'),
(34, '10 km', '45 menit '),
(35, '35 Km', '1 jam 5 menit dari B');

-- --------------------------------------------------------

--
-- Table structure for table `objek_aktifitas`
--

CREATE TABLE `objek_aktifitas` (
  `id` int(10) NOT NULL,
  `kd_objek` int(10) NOT NULL,
  `kd_aktifitas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `objek_aktifitas`
--

INSERT INTO `objek_aktifitas` (`id`, `kd_objek`, `kd_aktifitas`) VALUES
(7, 46, 13),
(10, 47, 11),
(11, 47, 12),
(14, 48, 9),
(15, 48, 13),
(16, 49, 3),
(17, 49, 4),
(18, 49, 5),
(19, 49, 9),
(20, 49, 10),
(21, 50, 4),
(22, 50, 8),
(23, 50, 13),
(24, 51, 5),
(25, 51, 6),
(26, 51, 7),
(27, 51, 12),
(28, 52, 12),
(29, 53, 12);

-- --------------------------------------------------------

--
-- Table structure for table `objek_fasilitas`
--

CREATE TABLE `objek_fasilitas` (
  `id` int(10) NOT NULL,
  `kd_objek` int(10) NOT NULL,
  `kd_fasilitas` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `objek_fasilitas`
--

INSERT INTO `objek_fasilitas` (`id`, `kd_objek`, `kd_fasilitas`) VALUES
(17, 46, 12),
(18, 46, 13),
(19, 46, 15),
(20, 46, 18),
(25, 47, 12),
(26, 47, 15),
(27, 47, 17),
(28, 47, 18),
(32, 48, 12),
(33, 48, 15),
(34, 48, 17),
(35, 49, 12),
(36, 49, 13),
(37, 49, 15),
(38, 49, 17),
(39, 49, 18),
(40, 49, 21),
(41, 50, 12),
(42, 50, 17),
(43, 51, 13),
(44, 51, 17),
(45, 51, 21),
(46, 52, 12),
(47, 52, 13),
(48, 52, 15),
(49, 52, 17),
(50, 52, 18),
(51, 53, 12),
(52, 53, 13),
(53, 53, 15),
(54, 53, 17),
(55, 53, 18);

-- --------------------------------------------------------

--
-- Table structure for table `objek_wisata`
--

CREATE TABLE `objek_wisata` (
  `kd_objek` int(10) NOT NULL,
  `kd_jarak` int(10) NOT NULL,
  `id_pengelola` int(10) NOT NULL,
  `nama_objek` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `harga_tiket` varchar(20) NOT NULL,
  `ket_objek` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `objek_wisata`
--

INSERT INTO `objek_wisata` (`kd_objek`, `kd_jarak`, `id_pengelola`, `nama_objek`, `foto`, `alamat`, `harga_tiket`, `ket_objek`) VALUES
(46, 26, 26, 'Air Terjun Wafsarak', 'uploads/67796b7e0077d_Air Terjun Wafsarak.jpeg', 'Kampung Inswanbesi, Distrik Warsa, Kabupaten Biak ', '24', 'Air Terjun Wafsarak, terletak sekitar 45 km dari Kota Biak, menawarkan pemandangan yang menakjubkan dengan air terjun yang jatuh deras ke kolam alami. Tempat ini sangat cocok untuk pengunjung yang ingin menikmati suasana alam yang tenang, berenang, atau berfoto di tengah alam yang asri.'),
(47, 28, 28, 'Goa Binsari', 'uploads/677970d23a905_GOA BINSARI.jpeg', 'Jalan Goa Jepang, Kampung Sumberker, Distrik Samof', '50.000', 'Goa Binsari yang berada sekitar 18 km dari Kota Biak terkenal dengan keindahan formasi stalaktit dan stalagmitnya. Gua ini menawarkan pengalaman eksplorasi alam yang menarik dan dapat dikunjungi oleh para petualang yang ingin menikmati suasana alam yang tenang dan misterius.'),
(48, 30, 30, 'Pantai Batu Picah', 'uploads/677973c137a29_Pantai Batu Picah.jpeg', 'Kampung Sor, Kecamatan Biak Utara, Kabupaten Biak ', '20.000', 'Pantai Batu Picah, yang terletak sekitar 7 km dari Kota Biak, merupakan destinasi yang ideal untuk bersantai, berjemur, atau menikmati pemandangan laut yang menakjubkan. Dengan batu-batu karang yang indah, pantai ini memberikan suasana yang damai bagi pengunjung yang mencari ketenangan.'),
(49, 31, 31, 'Pantai Segara Indah (Bosnik)', 'uploads/67797414850ec_Pantai Bosnik.jpg', 'Jalan Raya Bosnik, Kampung Ruar, Distrik Biak Timu', '19', 'Pantai Segara Indah, sekitar 30 km dari Kota Biak, terkenal dengan pasir putihnya yang halus dan air laut yang jernih. Tempat ini populer untuk kegiatan snorkeling, berenang, atau hanya bersantai menikmati pemandangan alam yang luar biasa.​'),
(50, 32, 32, 'Air Terjun Karmon', 'uploads/67797463a5ce3_Air Terjun Karmon.jpeg', 'Kampung Karmon, Distrik Yawosi, Kabupaten Biak Num', '25.000', 'Air Terjun Karmon, sekitar 60 km dari Kota Biak, menawarkan pemandangan alam yang memukau. Terletak di area yang lebih terpencil, air terjun ini dikelilingi oleh vegetasi tropis yang lebat, memberikan suasana alami yang tenang dan menyegarkan.'),
(51, 33, 33, 'Pulau Owi', 'uploads/677974d324e0c_Pulau Owi.jpeg', 'Pulau Owi, Kepulauan Padaido, Kabupaten Biak Numfo', '150.000', 'Pulau Owi, yang dapat dijangkau dengan kapal dari Kota Biak, menawarkan pantai-pantai yang masih alami, dengan pasir putih dan air laut yang sangat jernih. Tempat ini sangat cocok untuk snorkeling, berenang, berkemah, atau sekadar menikmati keindahan alam bawah laut.'),
(52, 34, 34, 'Taman Burung dan Anggrek Biak', 'uploads/677975219ea08_Taman burung.jpg', 'Jalan Raya Bosnik, Kampung Ruar, Distrik Biak Timu', '24', 'Taman Burung dan Anggrek Biak menawarkan pengalaman berinteraksi dengan berbagai spesies burung lokal dan anggrek yang langka. Taman ini memberikan kesempatan untuk menikmati keindahan flora dan fauna di Biak sambil berjalan-jalan di alam terbuka.'),
(53, 35, 35, ' Kuburan Tua Padwa', 'uploads/67797574b3a95_KUBURAN TUA PADWA.jpg', 'Desa Padwa, Distrik Yendidori, Kabupaten Biak Numf', '14', 'Kuburan Tua Padwa merupakan situs bersejarah yang menawarkan wawasan tentang kebudayaan dan sejarah Biak. Dengan makam-makam kuno yang tersebar, tempat ini memberikan pengalaman yang unik untuk belajar tentang masa lalu masyarakat Biak.');

-- --------------------------------------------------------

--
-- Table structure for table `pengelola`
--

CREATE TABLE `pengelola` (
  `id_pengelola` int(10) NOT NULL,
  `nama_pengelola` varchar(50) NOT NULL,
  `kontak_pengelola` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengelola`
--

INSERT INTO `pengelola` (`id_pengelola`, `nama_pengelola`, `kontak_pengelola`) VALUES
(22, 'Masyarakat lokal', '2147483647'),
(23, 'Masyarakat lokal', '2147483647'),
(24, 'Masyarakat lokal', '-'),
(25, 'Masyarakat lokal', '-'),
(26, 'Masyarakat lokal', '08121324567'),
(27, 'Masyarakat lokal', '081234567891'),
(28, 'Masyarakat lokal', '081234567891'),
(29, 'Masyarakat lokal', '08121324567'),
(30, 'Masyarakat lokal', '08121324567'),
(31, 'Masyarakat lokal', '081240171254'),
(32, 'Masyarakat lokal', '081234567891'),
(33, 'Masyarakat lokal', '08121324567'),
(34, 'Masyarakat lokal', '08121324567'),
(35, 'Masyarakat lokal', '08121324567');

-- --------------------------------------------------------

--
-- Table structure for table `stat`
--

CREATE TABLE `stat` (
  `id_statistik` int(10) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `os` varchar(30) NOT NULL,
  `browser` varchar(120) NOT NULL,
  `date_create` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stat`
--

INSERT INTO `stat` (`id_statistik`, `ip`, `os`, `browser`, `date_create`) VALUES
(1, '::1', 'Unknown', 'Google Chrome v.131.0.0.0', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktifitas`
--
ALTER TABLE `aktifitas`
  ADD PRIMARY KEY (`kd_aktifitas`);

--
-- Indexes for table `fasilitas`
--
ALTER TABLE `fasilitas`
  ADD PRIMARY KEY (`kd_fasilitas`);

--
-- Indexes for table `jarak`
--
ALTER TABLE `jarak`
  ADD PRIMARY KEY (`kd_jarak`);

--
-- Indexes for table `objek_aktifitas`
--
ALTER TABLE `objek_aktifitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kd_objek` (`kd_objek`),
  ADD KEY `kd_aktifitas` (`kd_aktifitas`);

--
-- Indexes for table `objek_fasilitas`
--
ALTER TABLE `objek_fasilitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kd_objek` (`kd_objek`),
  ADD KEY `kd_fasilitas` (`kd_fasilitas`);

--
-- Indexes for table `objek_wisata`
--
ALTER TABLE `objek_wisata`
  ADD PRIMARY KEY (`kd_objek`),
  ADD KEY `kd_jarak` (`kd_jarak`),
  ADD KEY `id_pengelola` (`id_pengelola`);

--
-- Indexes for table `pengelola`
--
ALTER TABLE `pengelola`
  ADD PRIMARY KEY (`id_pengelola`);

--
-- Indexes for table `stat`
--
ALTER TABLE `stat`
  ADD PRIMARY KEY (`id_statistik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktifitas`
--
ALTER TABLE `aktifitas`
  MODIFY `kd_aktifitas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `fasilitas`
--
ALTER TABLE `fasilitas`
  MODIFY `kd_fasilitas` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `jarak`
--
ALTER TABLE `jarak`
  MODIFY `kd_jarak` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `objek_aktifitas`
--
ALTER TABLE `objek_aktifitas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `objek_fasilitas`
--
ALTER TABLE `objek_fasilitas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `objek_wisata`
--
ALTER TABLE `objek_wisata`
  MODIFY `kd_objek` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `pengelola`
--
ALTER TABLE `pengelola`
  MODIFY `id_pengelola` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `stat`
--
ALTER TABLE `stat`
  MODIFY `id_statistik` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `objek_aktifitas`
--
ALTER TABLE `objek_aktifitas`
  ADD CONSTRAINT `objek_aktifitas_ibfk_1` FOREIGN KEY (`kd_objek`) REFERENCES `objek_wisata` (`kd_objek`) ON DELETE CASCADE,
  ADD CONSTRAINT `objek_aktifitas_ibfk_2` FOREIGN KEY (`kd_aktifitas`) REFERENCES `aktifitas` (`kd_aktifitas`) ON DELETE CASCADE;

--
-- Constraints for table `objek_fasilitas`
--
ALTER TABLE `objek_fasilitas`
  ADD CONSTRAINT `objek_fasilitas_ibfk_1` FOREIGN KEY (`kd_objek`) REFERENCES `objek_wisata` (`kd_objek`) ON DELETE CASCADE,
  ADD CONSTRAINT `objek_fasilitas_ibfk_2` FOREIGN KEY (`kd_fasilitas`) REFERENCES `fasilitas` (`kd_fasilitas`) ON DELETE CASCADE;

--
-- Constraints for table `objek_wisata`
--
ALTER TABLE `objek_wisata`
  ADD CONSTRAINT `objek_wisata_ibfk_1` FOREIGN KEY (`kd_jarak`) REFERENCES `jarak` (`kd_jarak`),
  ADD CONSTRAINT `objek_wisata_ibfk_2` FOREIGN KEY (`id_pengelola`) REFERENCES `pengelola` (`id_pengelola`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
