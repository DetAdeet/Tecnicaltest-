-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 12:06 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deptech`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(255) NOT NULL,
  `nama_belakang` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama_depan`, `nama_belakang`, `email`, `tanggal_lahir`, `jenis_kelamin`, `password`) VALUES
(1, 'Adid', 'Firman', 'adeetfirman1@gmail.com', '2008-04-08', 'Laki-laki', '$2y$10$0zdl.QkYR/Saq4mBcWdogOlH/NBxYIw2avoGOKQWyn5Nx9Z8vE3gC'),
(2, 'Admin', '123', 'admin@gmail.com', '2008-02-29', 'Perempuan', '$2y$10$W4EEntVJmySu32fgKn9GQusKdZFR/OewEjEFhIQ7hb3C2tzh3M6ou');

-- --------------------------------------------------------

--
-- Table structure for table `eskul`
--

CREATE TABLE `eskul` (
  `id` int(11) NOT NULL,
  `nama_ekstrakulikuler` varchar(255) NOT NULL,
  `nama_penannggungjawab_ekstrakulikuler` varchar(255) NOT NULL,
  `status_ekstrakulikuler` enum('Aktif','Tidak Aktif') NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eskul`
--

INSERT INTO `eskul` (`id`, `nama_ekstrakulikuler`, `nama_penannggungjawab_ekstrakulikuler`, `status_ekstrakulikuler`, `foto`) VALUES
(1, 'Pramuka', 'Ponimin', 'Aktif', '1745545141_WhatsApp Image 2025-04-25 at 01.47.05.jpeg'),
(2, 'Paskibra', 'Aini', 'Aktif', '1745545131_WhatsApp Image 2025-04-25 at 01.47.05 (1).jpeg'),
(3, 'Sains', 'Wide', 'Tidak Aktif', '1745544920_WhatsApp Image 2025-04-25 at 01.43.22.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nama_depan` varchar(255) NOT NULL,
  `nama_belakang` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama_depan`, `nama_belakang`, `no_hp`, `nis`, `alamat`, `jenis_kelamin`, `foto`, `created_at`) VALUES
(1, 'Deris', 'Anugrah', '0811111111111', '11111111111111', 'Tanggerang Selatan\r\n', 'Laki-laki', '1745518179_WhatsApp Image 2025-04-25 at 00.58.32.jpeg', '2025-04-24 17:12:53'),
(2, 'Adit', 'Firmansyah', '08222222222', '22222222222', 'Tanggerang Selatan', 'Laki-laki', '1745516457_WhatsApp Image 2025-04-25 at 00.25.17.jpeg', '2025-04-24 17:40:57'),
(3, 'Aluna', 'Safira', '08333333333333', '33333333333333', 'Tanggerang Selatan', 'Perempuan', '1745517020_WhatsApp Image 2025-04-25 at 00.49.22.jpeg', '2025-04-24 17:50:20'),
(5, 'Picia', 'Prikitiw', '08444444444444', '44444444444444', 'Bali', 'Perempuan', '1745552311_WhatsApp Image 2025-04-25 at 10.38.17.jpeg', '2025-04-25 03:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `siswa_eskul`
--

CREATE TABLE `siswa_eskul` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `eskul_id` int(11) NOT NULL,
  `tahun_mulai` year(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `siswa_eskul`
--

INSERT INTO `siswa_eskul` (`id`, `siswa_id`, `eskul_id`, `tahun_mulai`) VALUES
(2, 1, 1, '2023'),
(3, 2, 3, '2023'),
(4, 3, 1, '2025');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Email` (`email`);

--
-- Indexes for table `eskul`
--
ALTER TABLE `eskul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Nomor Induk Siswa` (`nis`);

--
-- Indexes for table `siswa_eskul`
--
ALTER TABLE `siswa_eskul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `eskul_id` (`eskul_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `eskul`
--
ALTER TABLE `eskul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `siswa_eskul`
--
ALTER TABLE `siswa_eskul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `siswa_eskul`
--
ALTER TABLE `siswa_eskul`
  ADD CONSTRAINT `siswa_eskul_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswa_eskul_ibfk_2` FOREIGN KEY (`eskul_id`) REFERENCES `eskul` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
