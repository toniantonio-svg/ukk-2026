-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2026 at 07:29 AM
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
-- Database: `db_ukk_2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_guru`
--

CREATE TABLE `t_guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated-at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_guru`
--

INSERT INTO `t_guru` (`id`, `nip`, `nama`, `email`, `status_aktif`, `user_id`, `created_at`, `updated-at`) VALUES
(1, '1985010101', 'Guru 01', 'guru01@sekolah.test', 1, 1, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(2, '1985020202', 'Guru 02', 'guru02@sekolah.test', 1, 2, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(3, '1985030303', 'Guru 03', 'guru03@sekolah.test', 1, 3, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(4, '1985040404', 'Guru 04', 'guru04@sekolah.test', 1, 4, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(5, '1985050505', 'Guru 05', 'guru05@sekolah.test', 1, 5, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(6, '1985060606', 'Guru 06', 'guru06@sekolah.test', 1, 6, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(7, '1985070707', 'Guru 07', 'guru07@sekolah.test', 1, 7, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(8, '1985080808', 'Guru 08', 'guru08@sekolah.test', 1, 8, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(9, '1985090909', 'Guru 09', 'guru09@sekolah.test', 1, 9, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(10, '1985101010', 'Guru 10', 'guru10@sekolah.test', 1, 10, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(11, '1985111111', 'Guru 11', 'guru11@sekolah.test', 1, 11, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(12, '1985121212', 'Guru 12', 'guru12@sekolah.test', 1, 12, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(13, '1985131313', 'Guru 13', 'guru13@sekolah.test', 1, 13, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(14, '1985141414', 'Guru 14', 'guru14@sekolah.test', 1, 14, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(15, '1985151515', 'Guru 15', 'guru15@sekolah.test', 1, 15, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(16, '1985161616', 'Guru 16', 'guru16@sekolah.test', 1, 16, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(17, '1985171717', 'Guru 17', 'guru17@sekolah.test', 1, 17, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(18, '1985181818', 'Guru 18', 'guru18@sekolah.test', 1, 18, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(19, '1985191919', 'Guru 19', 'guru19@sekolah.test', 1, 19, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(20, '1985202020', 'Guru 20', 'guru20@sekolah.test', 1, 20, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(21, '1985212121', 'Guru 21', 'guru21@sekolah.test', 1, 21, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(22, '1985222222', 'Guru 22', 'guru22@sekolah.test', 1, 22, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(23, '1985232323', 'Guru 23', 'guru23@sekolah.test', 1, 23, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(24, '1985242424', 'Guru 24', 'guru24@sekolah.test', 1, 24, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(25, '1985252525', 'Guru 25', 'guru25@sekolah.test', 1, 25, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(26, '1985262626', 'Guru 26', 'guru26@sekolah.test', 1, 26, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(27, '1985272727', 'Guru 27', 'guru27@sekolah.test', 1, 27, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(28, '1985282828', 'Guru 28', 'guru28@sekolah.test', 1, 28, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(29, '1985292929', 'Guru 29', 'guru29@sekolah.test', 1, 29, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(30, '1985303030', 'Guru 30', 'guru30@sekolah.test', 1, 30, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(31, '1985313131', 'Guru 31', 'guru31@sekolah.test', 1, 31, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(32, '1985323232', 'Guru 32', 'guru32@sekolah.test', 1, 32, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(33, '1985333333', 'Guru 33', 'guru33@sekolah.test', 1, 33, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(34, '1985343434', 'Guru 34', 'guru34@sekolah.test', 1, 34, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(35, '1985353535', 'Guru 35', 'guru35@sekolah.test', 1, 35, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(36, '1985363636', 'Guru 36', 'guru36@sekolah.test', 1, 36, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(37, '1985373737', 'Guru 37', 'guru37@sekolah.test', 1, 37, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(38, '1985383838', 'Guru 38', 'guru38@sekolah.test', 1, 38, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(39, '1985393939', 'Guru 39', 'guru39@sekolah.test', 1, 39, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(40, '1985404040', 'Guru 40', 'guru40@sekolah.test', 1, 40, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(41, '1985414141', 'Guru 41', 'guru41@sekolah.test', 1, 41, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(42, '1985424242', 'Guru 42', 'guru42@sekolah.test', 1, 42, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(43, '1985434343', 'Guru 43', 'guru43@sekolah.test', 1, 43, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(44, '1985444444', 'Guru 44', 'guru44@sekolah.test', 1, 44, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(45, '1985454545', 'Guru 45', 'guru45@sekolah.test', 1, 45, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(46, '1985464646', 'Guru 46', 'guru46@sekolah.test', 1, 46, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(47, '1985474747', 'Guru 47', 'guru47@sekolah.test', 1, 47, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(48, '1985484848', 'Guru 48', 'guru48@sekolah.test', 1, 48, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(49, '1985494949', 'Guru 49', 'guru49@sekolah.test', 1, 49, '2026-09-23 02:34:44', '2026-09-23 02:34:44'),
(50, '1985505050', 'Guru 50', 'guru50@sekolah.test', 1, 50, '2026-09-23 02:34:44', '2026-09-23 02:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas`
--

CREATE TABLE `t_kelas` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tingkat` varchar(20) NOT NULL,
  `jurusan` varchar(100) NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_kelas`
--

INSERT INTO `t_kelas` (`id`, `nama`, `tingkat`, `jurusan`, `status_aktif`, `created_at`, `updated_at`, `update_at`) VALUES
(1, 'X IPA 1', 'X', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(2, 'XI IPS 1', 'XI', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(3, 'XII Bahasa 1', 'XII', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(4, 'X TKJ 1', 'X', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(5, 'XI RPL 1', 'XI', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(6, 'XII IPA 2', 'XII', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(7, 'X IPS 2', 'X', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(8, 'XI Bahasa 2', 'XI', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(9, 'XII TKJ 2', 'XII', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(10, 'X RPL 2', 'X', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(11, 'XI IPA 3', 'XI', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(12, 'XII IPS 3', 'XII', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(13, 'X Bahasa 3', 'X', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(14, 'XI TKJ 3', 'XI', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(15, 'XII RPL 3', 'XII', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(16, 'X IPA 4', 'X', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(17, 'XI IPS 4', 'XI', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(18, 'XII Bahasa 4', 'XII', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(19, 'X TKJ 4', 'X', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(20, 'XI RPL 4', 'XI', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(21, 'XII IPA 5', 'XII', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(22, 'X IPS 5', 'X', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(23, 'XI Bahasa 5', 'XI', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(24, 'XII TKJ 5', 'XII', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(25, 'X RPL 5', 'X', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(26, 'XI IPA 6', 'XI', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(27, 'XII IPS 6', 'XII', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(28, 'X Bahasa 6', 'X', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(29, 'XI TKJ 6', 'XI', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(30, 'XII RPL 6', 'XII', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(31, 'X IPA 7', 'X', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(32, 'XI IPS 7', 'XI', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(33, 'XII Bahasa 7', 'XII', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(34, 'X TKJ 7', 'X', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(35, 'XI RPL 7', 'XI', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(36, 'XII IPA 8', 'XII', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(37, 'X IPS 8', 'X', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(38, 'XI Bahasa 8', 'XI', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(39, 'XII TKJ 8', 'XII', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(40, 'X RPL 8', 'X', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(41, 'XI IPA 9', 'XI', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(42, 'XII IPS 9', 'XII', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(43, 'X Bahasa 9', 'X', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(44, 'XI TKJ 9', 'XI', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(45, 'XII RPL 9', 'XII', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(46, 'X IPA 10', 'X', 'IPA', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(47, 'XI IPS 10', 'XI', 'IPS', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(48, 'XII Bahasa 10', 'XII', 'Bahasa', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(49, 'X TKJ 10', 'X', 'TKJ', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23'),
(50, 'XI RPL 10', 'XI', 'RPL', 1, '2026-09-23 02:37:23', '2026-09-23 09:37:23', '2026-09-23 02:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `t_kelas_siswa`
--

CREATE TABLE `t_kelas_siswa` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_kelas_siswa`
--

INSERT INTO `t_kelas_siswa` (`id`, `siswa_id`, `tahun_ajaran_id`, `kelas_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2020-07-01', '2021-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(2, 2, 2, 2, '2021-07-01', '2022-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(3, 3, 3, 3, '2022-07-01', '2023-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(4, 4, 4, 4, '2023-07-01', '2024-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(5, 5, 5, 5, '2024-07-01', '2025-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(6, 6, 6, 6, '2025-07-01', '2026-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(7, 7, 7, 7, '2026-07-01', '2027-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(8, 8, 8, 8, '2027-07-01', '2028-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(9, 9, 9, 9, '2028-07-01', '2029-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(10, 10, 10, 10, '2029-07-01', '2030-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(11, 11, 11, 11, '2030-07-01', '2031-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(12, 12, 12, 12, '2031-07-01', '2032-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(13, 13, 13, 13, '2032-07-01', '2033-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(14, 14, 14, 14, '2033-07-01', '2034-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(15, 15, 15, 15, '2034-07-01', '2035-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(16, 16, 16, 16, '2035-07-01', '2036-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(17, 17, 17, 17, '2036-07-01', '2037-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(18, 18, 18, 18, '2037-07-01', '2038-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(19, 19, 19, 19, '2038-07-01', '2039-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(20, 20, 20, 20, '2039-07-01', '2040-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(21, 21, 21, 21, '2040-07-01', '2041-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(22, 22, 22, 22, '2041-07-01', '2042-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(23, 23, 23, 23, '2042-07-01', '2043-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(24, 24, 24, 24, '2043-07-01', '2044-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(25, 25, 25, 25, '2044-07-01', '2045-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(26, 26, 26, 26, '2045-07-01', '2046-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(27, 27, 27, 27, '2046-07-01', '2047-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(28, 28, 28, 28, '2047-07-01', '2048-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(29, 29, 29, 29, '2048-07-01', '2049-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(30, 30, 30, 30, '2049-07-01', '2050-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(31, 31, 31, 31, '2050-07-01', '2051-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(32, 32, 32, 32, '2051-07-01', '2052-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(33, 33, 33, 33, '2052-07-01', '2053-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(34, 34, 34, 34, '2053-07-01', '2054-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(35, 35, 35, 35, '2054-07-01', '2055-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(36, 36, 36, 36, '2055-07-01', '2056-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(37, 37, 37, 37, '2056-07-01', '2057-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(38, 38, 38, 38, '2057-07-01', '2058-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(39, 39, 39, 39, '2058-07-01', '2059-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(40, 40, 40, 40, '2059-07-01', '2060-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(41, 41, 41, 41, '2060-07-01', '2061-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(42, 42, 42, 42, '2061-07-01', '2062-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(43, 43, 43, 43, '2062-07-01', '2063-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(44, 44, 44, 44, '2063-07-01', '2064-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(45, 45, 45, 45, '2064-07-01', '2065-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(46, 46, 46, 46, '2065-07-01', '2066-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(47, 47, 47, 47, '2066-07-01', '2067-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(48, 48, 48, 48, '2067-07-01', '2068-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(49, 49, 49, 49, '2068-07-01', '2069-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44'),
(50, 50, 50, 50, '2069-07-01', '2070-06-30', 1, '2026-09-23 02:40:44', '2026-09-23 02:40:44');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran`
--

CREATE TABLE `t_pelanggaran` (
  `id` int(11) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `kode` varchar(30) DEFAULT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `poin` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran`
--

INSERT INTO `t_pelanggaran` (`id`, `pelanggaran_kategori_id`, `kode`, `nama`, `poin`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 'PLG001', 'Pelanggaran 01', 5, 'Contoh pelanggaran nomor 01', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(2, 2, 'PLG002', 'Pelanggaran 02', 6, 'Contoh pelanggaran nomor 02', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(3, 3, 'PLG003', 'Pelanggaran 03', 7, 'Contoh pelanggaran nomor 03', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(4, 4, 'PLG004', 'Pelanggaran 04', 8, 'Contoh pelanggaran nomor 04', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(5, 5, 'PLG005', 'Pelanggaran 05', 9, 'Contoh pelanggaran nomor 05', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(6, 6, 'PLG006', 'Pelanggaran 06', 10, 'Contoh pelanggaran nomor 06', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(7, 7, 'PLG007', 'Pelanggaran 07', 11, 'Contoh pelanggaran nomor 07', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(8, 8, 'PLG008', 'Pelanggaran 08', 12, 'Contoh pelanggaran nomor 08', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(9, 9, 'PLG009', 'Pelanggaran 09', 13, 'Contoh pelanggaran nomor 09', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(10, 10, 'PLG010', 'Pelanggaran 10', 14, 'Contoh pelanggaran nomor 10', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(11, 11, 'PLG011', 'Pelanggaran 11', 5, 'Contoh pelanggaran nomor 11', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(12, 12, 'PLG012', 'Pelanggaran 12', 6, 'Contoh pelanggaran nomor 12', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(13, 13, 'PLG013', 'Pelanggaran 13', 7, 'Contoh pelanggaran nomor 13', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(14, 14, 'PLG014', 'Pelanggaran 14', 8, 'Contoh pelanggaran nomor 14', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(15, 15, 'PLG015', 'Pelanggaran 15', 9, 'Contoh pelanggaran nomor 15', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(16, 16, 'PLG016', 'Pelanggaran 16', 10, 'Contoh pelanggaran nomor 16', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(17, 17, 'PLG017', 'Pelanggaran 17', 11, 'Contoh pelanggaran nomor 17', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(18, 18, 'PLG018', 'Pelanggaran 18', 12, 'Contoh pelanggaran nomor 18', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(19, 19, 'PLG019', 'Pelanggaran 19', 13, 'Contoh pelanggaran nomor 19', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(20, 20, 'PLG020', 'Pelanggaran 20', 14, 'Contoh pelanggaran nomor 20', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(21, 21, 'PLG021', 'Pelanggaran 21', 5, 'Contoh pelanggaran nomor 21', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(22, 22, 'PLG022', 'Pelanggaran 22', 6, 'Contoh pelanggaran nomor 22', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(23, 23, 'PLG023', 'Pelanggaran 23', 7, 'Contoh pelanggaran nomor 23', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(24, 24, 'PLG024', 'Pelanggaran 24', 8, 'Contoh pelanggaran nomor 24', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(25, 25, 'PLG025', 'Pelanggaran 25', 9, 'Contoh pelanggaran nomor 25', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(26, 26, 'PLG026', 'Pelanggaran 26', 10, 'Contoh pelanggaran nomor 26', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(27, 27, 'PLG027', 'Pelanggaran 27', 11, 'Contoh pelanggaran nomor 27', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(28, 28, 'PLG028', 'Pelanggaran 28', 12, 'Contoh pelanggaran nomor 28', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(29, 29, 'PLG029', 'Pelanggaran 29', 13, 'Contoh pelanggaran nomor 29', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(30, 30, 'PLG030', 'Pelanggaran 30', 14, 'Contoh pelanggaran nomor 30', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(31, 31, 'PLG031', 'Pelanggaran 31', 5, 'Contoh pelanggaran nomor 31', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(32, 32, 'PLG032', 'Pelanggaran 32', 6, 'Contoh pelanggaran nomor 32', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(33, 33, 'PLG033', 'Pelanggaran 33', 7, 'Contoh pelanggaran nomor 33', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(34, 34, 'PLG034', 'Pelanggaran 34', 8, 'Contoh pelanggaran nomor 34', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(35, 35, 'PLG035', 'Pelanggaran 35', 9, 'Contoh pelanggaran nomor 35', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(36, 36, 'PLG036', 'Pelanggaran 36', 10, 'Contoh pelanggaran nomor 36', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(37, 37, 'PLG037', 'Pelanggaran 37', 11, 'Contoh pelanggaran nomor 37', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(38, 38, 'PLG038', 'Pelanggaran 38', 12, 'Contoh pelanggaran nomor 38', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(39, 39, 'PLG039', 'Pelanggaran 39', 13, 'Contoh pelanggaran nomor 39', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(40, 40, 'PLG040', 'Pelanggaran 40', 14, 'Contoh pelanggaran nomor 40', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(41, 41, 'PLG041', 'Pelanggaran 41', 5, 'Contoh pelanggaran nomor 41', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(42, 42, 'PLG042', 'Pelanggaran 42', 6, 'Contoh pelanggaran nomor 42', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(43, 43, 'PLG043', 'Pelanggaran 43', 7, 'Contoh pelanggaran nomor 43', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(44, 44, 'PLG044', 'Pelanggaran 44', 8, 'Contoh pelanggaran nomor 44', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(45, 45, 'PLG045', 'Pelanggaran 45', 9, 'Contoh pelanggaran nomor 45', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(46, 46, 'PLG046', 'Pelanggaran 46', 10, 'Contoh pelanggaran nomor 46', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(47, 47, 'PLG047', 'Pelanggaran 47', 11, 'Contoh pelanggaran nomor 47', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(48, 48, 'PLG048', 'Pelanggaran 48', 12, 'Contoh pelanggaran nomor 48', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(49, 49, 'PLG049', 'Pelanggaran 49', 13, 'Contoh pelanggaran nomor 49', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49'),
(50, 50, 'PLG050', 'Pelanggaran 50', 14, 'Contoh pelanggaran nomor 50', 1, '2026-09-23 02:30:49', '2026-09-23 02:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran_kategori`
--

CREATE TABLE `t_pelanggaran_kategori` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran_kategori`
--

INSERT INTO `t_pelanggaran_kategori` (`id`, `nama`, `deskripsi`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Kedisiplinan 01', 'Kategori pelanggaran kedisiplinan nomor 01', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(2, 'Kerapian 02', 'Kategori pelanggaran kerapian nomor 02', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(3, 'Kehadiran 03', 'Kategori pelanggaran kehadiran nomor 03', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(4, 'Sikap 04', 'Kategori pelanggaran sikap nomor 04', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(5, 'Kebersihan 05', 'Kategori pelanggaran kebersihan nomor 05', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(6, 'Kedisiplinan 06', 'Kategori pelanggaran kedisiplinan nomor 06', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(7, 'Kerapian 07', 'Kategori pelanggaran kerapian nomor 07', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(8, 'Kehadiran 08', 'Kategori pelanggaran kehadiran nomor 08', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(9, 'Sikap 09', 'Kategori pelanggaran sikap nomor 09', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(10, 'Kebersihan 10', 'Kategori pelanggaran kebersihan nomor 10', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(11, 'Kedisiplinan 11', 'Kategori pelanggaran kedisiplinan nomor 11', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(12, 'Kerapian 12', 'Kategori pelanggaran kerapian nomor 12', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(13, 'Kehadiran 13', 'Kategori pelanggaran kehadiran nomor 13', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(14, 'Sikap 14', 'Kategori pelanggaran sikap nomor 14', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(15, 'Kebersihan 15', 'Kategori pelanggaran kebersihan nomor 15', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(16, 'Kedisiplinan 16', 'Kategori pelanggaran kedisiplinan nomor 16', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(17, 'Kerapian 17', 'Kategori pelanggaran kerapian nomor 17', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(18, 'Kehadiran 18', 'Kategori pelanggaran kehadiran nomor 18', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(19, 'Sikap 19', 'Kategori pelanggaran sikap nomor 19', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(20, 'Kebersihan 20', 'Kategori pelanggaran kebersihan nomor 20', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(21, 'Kedisiplinan 21', 'Kategori pelanggaran kedisiplinan nomor 21', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(22, 'Kerapian 22', 'Kategori pelanggaran kerapian nomor 22', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(23, 'Kehadiran 23', 'Kategori pelanggaran kehadiran nomor 23', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(24, 'Sikap 24', 'Kategori pelanggaran sikap nomor 24', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(25, 'Kebersihan 25', 'Kategori pelanggaran kebersihan nomor 25', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(26, 'Kedisiplinan 26', 'Kategori pelanggaran kedisiplinan nomor 26', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(27, 'Kerapian 27', 'Kategori pelanggaran kerapian nomor 27', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(28, 'Kehadiran 28', 'Kategori pelanggaran kehadiran nomor 28', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(29, 'Sikap 29', 'Kategori pelanggaran sikap nomor 29', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(30, 'Kebersihan 30', 'Kategori pelanggaran kebersihan nomor 30', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(31, 'Kedisiplinan 31', 'Kategori pelanggaran kedisiplinan nomor 31', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(32, 'Kerapian 32', 'Kategori pelanggaran kerapian nomor 32', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(33, 'Kehadiran 33', 'Kategori pelanggaran kehadiran nomor 33', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(34, 'Sikap 34', 'Kategori pelanggaran sikap nomor 34', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(35, 'Kebersihan 35', 'Kategori pelanggaran kebersihan nomor 35', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(36, 'Kedisiplinan 36', 'Kategori pelanggaran kedisiplinan nomor 36', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(37, 'Kerapian 37', 'Kategori pelanggaran kerapian nomor 37', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(38, 'Kehadiran 38', 'Kategori pelanggaran kehadiran nomor 38', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(39, 'Sikap 39', 'Kategori pelanggaran sikap nomor 39', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(40, 'Kebersihan 40', 'Kategori pelanggaran kebersihan nomor 40', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(41, 'Kedisiplinan 41', 'Kategori pelanggaran kedisiplinan nomor 41', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(42, 'Kerapian 42', 'Kategori pelanggaran kerapian nomor 42', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(43, 'Kehadiran 43', 'Kategori pelanggaran kehadiran nomor 43', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(44, 'Sikap 44', 'Kategori pelanggaran sikap nomor 44', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(45, 'Kebersihan 45', 'Kategori pelanggaran kebersihan nomor 45', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(46, 'Kedisiplinan 46', 'Kategori pelanggaran kedisiplinan nomor 46', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(47, 'Kerapian 47', 'Kategori pelanggaran kerapian nomor 47', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(48, 'Kehadiran 48', 'Kategori pelanggaran kehadiran nomor 48', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(49, 'Sikap 49', 'Kategori pelanggaran sikap nomor 49', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31'),
(50, 'Kebersihan 50', 'Kategori pelanggaran kebersihan nomor 50', 1, '2026-09-23 02:30:31', '2026-09-23 02:30:31');

-- --------------------------------------------------------

--
-- Table structure for table `t_pelanggaran_siswa`
--

CREATE TABLE `t_pelanggaran_siswa` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `siswa_id` int(11) DEFAULT NULL,
  `nama_siswa` varchar(150) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `nama_kelas` varchar(100) NOT NULL,
  `pelanggaran_id` int(11) DEFAULT NULL,
  `nama_pelanggaran` varchar(150) NOT NULL,
  `pelanggaran_kategori_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `nama_guru` varchar(150) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `keterangan` text NOT NULL,
  `poin` int(11) NOT NULL,
  `tindakan` text NOT NULL,
  `status` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `updated-at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_pelanggaran_siswa`
--

INSERT INTO `t_pelanggaran_siswa` (`id`, `tahun_ajaran_id`, `siswa_id`, `nama_siswa`, `kelas_id`, `nama_kelas`, `pelanggaran_id`, `nama_pelanggaran`, `pelanggaran_kategori_id`, `guru_id`, `nama_guru`, `tanggal`, `keterangan`, `poin`, `tindakan`, `status`, `created_at`, `updated_at`, `updated-at`) VALUES
(1, 1, 1, 'Siswa 01', 1, 'X IPA 1', 1, 'Pelanggaran 01', 1, 1, 'Guru 01', '2026-01-03', 'Keterangan pelanggaran 01', 5, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(2, 2, 2, 'Siswa 02', 2, 'XI IPS 1', 2, 'Pelanggaran 02', 2, 2, 'Guru 02', '2026-02-06', 'Keterangan pelanggaran 02', 6, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(3, 3, 3, 'Siswa 03', 3, 'XII Bahasa 1', 3, 'Pelanggaran 03', 3, 3, 'Guru 03', '2026-03-09', 'Keterangan pelanggaran 03', 7, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(4, 4, 4, 'Siswa 04', 4, 'X TKJ 1', 4, 'Pelanggaran 04', 4, 4, 'Guru 04', '2026-04-12', 'Keterangan pelanggaran 04', 8, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(5, 5, 5, 'Siswa 05', 5, 'XI RPL 1', 5, 'Pelanggaran 05', 5, 5, 'Guru 05', '2026-05-15', 'Keterangan pelanggaran 05', 9, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(6, 6, 6, 'Siswa 06', 6, 'XII IPA 2', 6, 'Pelanggaran 06', 6, 6, 'Guru 06', '2026-06-18', 'Keterangan pelanggaran 06', 10, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(7, 7, 7, 'Siswa 07', 7, 'X IPS 2', 7, 'Pelanggaran 07', 7, 7, 'Guru 07', '2026-07-21', 'Keterangan pelanggaran 07', 11, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(8, 8, 8, 'Siswa 08', 8, 'XI Bahasa 2', 8, 'Pelanggaran 08', 8, 8, 'Guru 08', '2026-08-24', 'Keterangan pelanggaran 08', 12, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(9, 9, 9, 'Siswa 09', 9, 'XII TKJ 2', 9, 'Pelanggaran 09', 9, 9, 'Guru 09', '2026-09-27', 'Keterangan pelanggaran 09', 13, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(10, 10, 10, 'Siswa 10', 10, 'X RPL 2', 10, 'Pelanggaran 10', 10, 10, 'Guru 10', '2026-10-02', 'Keterangan pelanggaran 10', 14, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(11, 11, 11, 'Siswa 11', 11, 'XI IPA 3', 11, 'Pelanggaran 11', 11, 11, 'Guru 11', '2026-11-05', 'Keterangan pelanggaran 11', 5, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(12, 12, 12, 'Siswa 12', 12, 'XII IPS 3', 12, 'Pelanggaran 12', 12, 12, 'Guru 12', '2026-12-08', 'Keterangan pelanggaran 12', 6, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(13, 13, 13, 'Siswa 13', 13, 'X Bahasa 3', 13, 'Pelanggaran 13', 13, 13, 'Guru 13', '2026-01-11', 'Keterangan pelanggaran 13', 7, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(14, 14, 14, 'Siswa 14', 14, 'XI TKJ 3', 14, 'Pelanggaran 14', 14, 14, 'Guru 14', '2026-02-14', 'Keterangan pelanggaran 14', 8, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(15, 15, 15, 'Siswa 15', 15, 'XII RPL 3', 15, 'Pelanggaran 15', 15, 15, 'Guru 15', '2026-03-17', 'Keterangan pelanggaran 15', 9, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(16, 16, 16, 'Siswa 16', 16, 'X IPA 4', 16, 'Pelanggaran 16', 16, 16, 'Guru 16', '2026-04-20', 'Keterangan pelanggaran 16', 10, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(17, 17, 17, 'Siswa 17', 17, 'XI IPS 4', 17, 'Pelanggaran 17', 17, 17, 'Guru 17', '2026-05-23', 'Keterangan pelanggaran 17', 11, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(18, 18, 18, 'Siswa 18', 18, 'XII Bahasa 4', 18, 'Pelanggaran 18', 18, 18, 'Guru 18', '2026-06-26', 'Keterangan pelanggaran 18', 12, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(19, 19, 19, 'Siswa 19', 19, 'X TKJ 4', 19, 'Pelanggaran 19', 19, 19, 'Guru 19', '2026-07-01', 'Keterangan pelanggaran 19', 13, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(20, 20, 20, 'Siswa 20', 20, 'XI RPL 4', 20, 'Pelanggaran 20', 20, 20, 'Guru 20', '2026-08-04', 'Keterangan pelanggaran 20', 14, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(21, 21, 21, 'Siswa 21', 21, 'XII IPA 5', 21, 'Pelanggaran 21', 21, 21, 'Guru 21', '2026-09-07', 'Keterangan pelanggaran 21', 5, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(22, 22, 22, 'Siswa 22', 22, 'X IPS 5', 22, 'Pelanggaran 22', 22, 22, 'Guru 22', '2026-10-10', 'Keterangan pelanggaran 22', 6, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(23, 23, 23, 'Siswa 23', 23, 'XI Bahasa 5', 23, 'Pelanggaran 23', 23, 23, 'Guru 23', '2026-11-13', 'Keterangan pelanggaran 23', 7, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(24, 24, 24, 'Siswa 24', 24, 'XII TKJ 5', 24, 'Pelanggaran 24', 24, 24, 'Guru 24', '2026-12-16', 'Keterangan pelanggaran 24', 8, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(25, 25, 25, 'Siswa 25', 25, 'X RPL 5', 25, 'Pelanggaran 25', 25, 25, 'Guru 25', '2026-01-19', 'Keterangan pelanggaran 25', 9, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(26, 26, 26, 'Siswa 26', 26, 'XI IPA 6', 26, 'Pelanggaran 26', 26, 26, 'Guru 26', '2026-02-22', 'Keterangan pelanggaran 26', 10, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(27, 27, 27, 'Siswa 27', 27, 'XII IPS 6', 27, 'Pelanggaran 27', 27, 27, 'Guru 27', '2026-03-25', 'Keterangan pelanggaran 27', 11, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(28, 28, 28, 'Siswa 28', 28, 'X Bahasa 6', 28, 'Pelanggaran 28', 28, 28, 'Guru 28', '2026-04-28', 'Keterangan pelanggaran 28', 12, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(29, 29, 29, 'Siswa 29', 29, 'XI TKJ 6', 29, 'Pelanggaran 29', 29, 29, 'Guru 29', '2026-05-03', 'Keterangan pelanggaran 29', 13, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(30, 30, 30, 'Siswa 30', 30, 'XII RPL 6', 30, 'Pelanggaran 30', 30, 30, 'Guru 30', '2026-06-06', 'Keterangan pelanggaran 30', 14, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(31, 31, 31, 'Siswa 31', 31, 'X IPA 7', 31, 'Pelanggaran 31', 31, 31, 'Guru 31', '2026-07-09', 'Keterangan pelanggaran 31', 5, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(32, 32, 32, 'Siswa 32', 32, 'XI IPS 7', 32, 'Pelanggaran 32', 32, 32, 'Guru 32', '2026-08-12', 'Keterangan pelanggaran 32', 6, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(33, 33, 33, 'Siswa 33', 33, 'XII Bahasa 7', 33, 'Pelanggaran 33', 33, 33, 'Guru 33', '2026-09-15', 'Keterangan pelanggaran 33', 7, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(34, 34, 34, 'Siswa 34', 34, 'X TKJ 7', 34, 'Pelanggaran 34', 34, 34, 'Guru 34', '2026-10-18', 'Keterangan pelanggaran 34', 8, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(35, 35, 35, 'Siswa 35', 35, 'XI RPL 7', 35, 'Pelanggaran 35', 35, 35, 'Guru 35', '2026-11-21', 'Keterangan pelanggaran 35', 9, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(36, 36, 36, 'Siswa 36', 36, 'XII IPA 8', 36, 'Pelanggaran 36', 36, 36, 'Guru 36', '2026-12-24', 'Keterangan pelanggaran 36', 10, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(37, 37, 37, 'Siswa 37', 37, 'X IPS 8', 37, 'Pelanggaran 37', 37, 37, 'Guru 37', '2026-01-27', 'Keterangan pelanggaran 37', 11, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(38, 38, 38, 'Siswa 38', 38, 'XI Bahasa 8', 38, 'Pelanggaran 38', 38, 38, 'Guru 38', '2026-02-02', 'Keterangan pelanggaran 38', 12, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(39, 39, 39, 'Siswa 39', 39, 'XII TKJ 8', 39, 'Pelanggaran 39', 39, 39, 'Guru 39', '2026-03-05', 'Keterangan pelanggaran 39', 13, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(40, 40, 40, 'Siswa 40', 40, 'X RPL 8', 40, 'Pelanggaran 40', 40, 40, 'Guru 40', '2026-04-08', 'Keterangan pelanggaran 40', 14, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(41, 41, 41, 'Siswa 41', 41, 'XI IPA 9', 41, 'Pelanggaran 41', 41, 41, 'Guru 41', '2026-05-11', 'Keterangan pelanggaran 41', 5, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(42, 42, 42, 'Siswa 42', 42, 'XII IPS 9', 42, 'Pelanggaran 42', 42, 42, 'Guru 42', '2026-06-14', 'Keterangan pelanggaran 42', 6, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(43, 43, 43, 'Siswa 43', 43, 'X Bahasa 9', 43, 'Pelanggaran 43', 43, 43, 'Guru 43', '2026-07-17', 'Keterangan pelanggaran 43', 7, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(44, 44, 44, 'Siswa 44', 44, 'XI TKJ 9', 44, 'Pelanggaran 44', 44, 44, 'Guru 44', '2026-08-20', 'Keterangan pelanggaran 44', 8, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(45, 45, 45, 'Siswa 45', 45, 'XII RPL 9', 45, 'Pelanggaran 45', 45, 45, 'Guru 45', '2026-09-23', 'Keterangan pelanggaran 45', 9, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(46, 46, 46, 'Siswa 46', 46, 'X IPA 10', 46, 'Pelanggaran 46', 46, 46, 'Guru 46', '2026-10-26', 'Keterangan pelanggaran 46', 10, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(47, 47, 47, 'Siswa 47', 47, 'XI IPS 10', 47, 'Pelanggaran 47', 47, 47, 'Guru 47', '2026-11-01', 'Keterangan pelanggaran 47', 11, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(48, 48, 48, 'Siswa 48', 48, 'XII Bahasa 10', 48, 'Pelanggaran 48', 48, 48, 'Guru 48', '2026-12-04', 'Keterangan pelanggaran 48', 12, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(49, 49, 49, 'Siswa 49', 49, 'X TKJ 10', 49, 'Pelanggaran 49', 49, 49, 'Guru 49', '2026-01-07', 'Keterangan pelanggaran 49', 13, 'Teguran', 'Proses', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07'),
(50, 50, 50, 'Siswa 50', 50, 'XI RPL 10', 50, 'Pelanggaran 50', 50, 50, 'Guru 50', '2026-02-10', 'Keterangan pelanggaran 50', 14, 'Teguran', 'Selesai', '2026-09-23 02:40:07', '2026-09-23 09:40:07', '2026-09-23 02:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `t_siswa`
--

CREATE TABLE `t_siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(30) DEFAULT NULL,
  `nisn` varchar(20) NOT NULL,
  `nama` varchar(150) DEFAULT NULL,
  `jenis_kelamin` char(1) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_siswa`
--

INSERT INTO `t_siswa` (`id`, `nis`, `nisn`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '20260001', 'NISN00000001', 'Siswa 01', 'L', '2007-01-02', 'Jl. Pendidikan No. 1', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(2, '20260002', 'NISN00000002', 'Siswa 02', 'P', '2008-02-04', 'Jl. Pendidikan No. 2', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(3, '20260003', 'NISN00000003', 'Siswa 03', 'L', '2009-03-06', 'Jl. Pendidikan No. 3', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(4, '20260004', 'NISN00000004', 'Siswa 04', 'P', '2010-04-08', 'Jl. Pendidikan No. 4', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(5, '20260005', 'NISN00000005', 'Siswa 05', 'L', '2007-05-10', 'Jl. Pendidikan No. 5', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(6, '20260006', 'NISN00000006', 'Siswa 06', 'P', '2008-06-12', 'Jl. Pendidikan No. 6', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(7, '20260007', 'NISN00000007', 'Siswa 07', 'L', '2009-07-14', 'Jl. Pendidikan No. 7', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(8, '20260008', 'NISN00000008', 'Siswa 08', 'P', '2010-08-16', 'Jl. Pendidikan No. 8', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(9, '20260009', 'NISN00000009', 'Siswa 09', 'L', '2007-09-18', 'Jl. Pendidikan No. 9', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(10, '20260010', 'NISN00000010', 'Siswa 10', 'P', '2008-10-20', 'Jl. Pendidikan No. 10', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(11, '20260011', 'NISN00000011', 'Siswa 11', 'L', '2009-11-22', 'Jl. Pendidikan No. 11', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(12, '20260012', 'NISN00000012', 'Siswa 12', 'P', '2010-12-24', 'Jl. Pendidikan No. 12', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(13, '20260013', 'NISN00000013', 'Siswa 13', 'L', '2007-01-26', 'Jl. Pendidikan No. 13', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(14, '20260014', 'NISN00000014', 'Siswa 14', 'P', '2008-02-28', 'Jl. Pendidikan No. 14', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(15, '20260015', 'NISN00000015', 'Siswa 15', 'L', '2009-03-02', 'Jl. Pendidikan No. 15', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(16, '20260016', 'NISN00000016', 'Siswa 16', 'P', '2010-04-04', 'Jl. Pendidikan No. 16', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(17, '20260017', 'NISN00000017', 'Siswa 17', 'L', '2007-05-06', 'Jl. Pendidikan No. 17', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(18, '20260018', 'NISN00000018', 'Siswa 18', 'P', '2008-06-08', 'Jl. Pendidikan No. 18', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(19, '20260019', 'NISN00000019', 'Siswa 19', 'L', '2009-07-10', 'Jl. Pendidikan No. 19', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(20, '20260020', 'NISN00000020', 'Siswa 20', 'P', '2010-08-12', 'Jl. Pendidikan No. 20', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(21, '20260021', 'NISN00000021', 'Siswa 21', 'L', '2007-09-14', 'Jl. Pendidikan No. 21', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(22, '20260022', 'NISN00000022', 'Siswa 22', 'P', '2008-10-16', 'Jl. Pendidikan No. 22', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(23, '20260023', 'NISN00000023', 'Siswa 23', 'L', '2009-11-18', 'Jl. Pendidikan No. 23', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(24, '20260024', 'NISN00000024', 'Siswa 24', 'P', '2010-12-20', 'Jl. Pendidikan No. 24', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(25, '20260025', 'NISN00000025', 'Siswa 25', 'L', '2007-01-22', 'Jl. Pendidikan No. 25', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(26, '20260026', 'NISN00000026', 'Siswa 26', 'P', '2008-02-24', 'Jl. Pendidikan No. 26', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(27, '20260027', 'NISN00000027', 'Siswa 27', 'L', '2009-03-26', 'Jl. Pendidikan No. 27', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(28, '20260028', 'NISN00000028', 'Siswa 28', 'P', '2010-04-28', 'Jl. Pendidikan No. 28', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(29, '20260029', 'NISN00000029', 'Siswa 29', 'L', '2007-05-02', 'Jl. Pendidikan No. 29', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(30, '20260030', 'NISN00000030', 'Siswa 30', 'P', '2008-06-04', 'Jl. Pendidikan No. 30', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(31, '20260031', 'NISN00000031', 'Siswa 31', 'L', '2009-07-06', 'Jl. Pendidikan No. 31', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(32, '20260032', 'NISN00000032', 'Siswa 32', 'P', '2010-08-08', 'Jl. Pendidikan No. 32', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(33, '20260033', 'NISN00000033', 'Siswa 33', 'L', '2007-09-10', 'Jl. Pendidikan No. 33', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(34, '20260034', 'NISN00000034', 'Siswa 34', 'P', '2008-10-12', 'Jl. Pendidikan No. 34', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(35, '20260035', 'NISN00000035', 'Siswa 35', 'L', '2009-11-14', 'Jl. Pendidikan No. 35', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(36, '20260036', 'NISN00000036', 'Siswa 36', 'P', '2010-12-16', 'Jl. Pendidikan No. 36', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(37, '20260037', 'NISN00000037', 'Siswa 37', 'L', '2007-01-18', 'Jl. Pendidikan No. 37', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(38, '20260038', 'NISN00000038', 'Siswa 38', 'P', '2008-02-20', 'Jl. Pendidikan No. 38', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(39, '20260039', 'NISN00000039', 'Siswa 39', 'L', '2009-03-22', 'Jl. Pendidikan No. 39', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(40, '20260040', 'NISN00000040', 'Siswa 40', 'P', '2010-04-24', 'Jl. Pendidikan No. 40', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(41, '20260041', 'NISN00000041', 'Siswa 41', 'L', '2007-05-26', 'Jl. Pendidikan No. 41', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(42, '20260042', 'NISN00000042', 'Siswa 42', 'P', '2008-06-28', 'Jl. Pendidikan No. 42', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(43, '20260043', 'NISN00000043', 'Siswa 43', 'L', '2009-07-02', 'Jl. Pendidikan No. 43', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(44, '20260044', 'NISN00000044', 'Siswa 44', 'P', '2010-08-04', 'Jl. Pendidikan No. 44', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(45, '20260045', 'NISN00000045', 'Siswa 45', 'L', '2007-09-06', 'Jl. Pendidikan No. 45', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(46, '20260046', 'NISN00000046', 'Siswa 46', 'P', '2008-10-08', 'Jl. Pendidikan No. 46', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(47, '20260047', 'NISN00000047', 'Siswa 47', 'L', '2009-11-10', 'Jl. Pendidikan No. 47', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(48, '20260048', 'NISN00000048', 'Siswa 48', 'P', '2010-12-12', 'Jl. Pendidikan No. 48', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(49, '20260049', 'NISN00000049', 'Siswa 49', 'L', '2007-01-14', 'Jl. Pendidikan No. 49', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09'),
(50, '20260050', 'NISN00000050', 'Siswa 50', 'P', '2008-02-16', 'Jl. Pendidikan No. 50', 1, '2026-09-23 02:30:09', '2026-09-23 02:30:09');

-- --------------------------------------------------------

--
-- Table structure for table `t_tahun_ajaran`
--

CREATE TABLE `t_tahun_ajaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_tahun_ajaran`
--

INSERT INTO `t_tahun_ajaran` (`id`, `nama`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, '2020/2021', '2020-07-01', '2021-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(2, '2021/2022', '2021-07-01', '2022-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(3, '2022/2023', '2022-07-01', '2023-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(4, '2023/2024', '2023-07-01', '2024-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(5, '2024/2025', '2024-07-01', '2025-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(6, '2025/2026', '2025-07-01', '2026-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(7, '2026/2027', '2026-07-01', '2027-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(8, '2027/2028', '2027-07-01', '2028-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(9, '2028/2029', '2028-07-01', '2029-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(10, '2029/2030', '2029-07-01', '2030-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(11, '2030/2031', '2030-07-01', '2031-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(12, '2031/2032', '2031-07-01', '2032-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(13, '2032/2033', '2032-07-01', '2033-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(14, '2033/2034', '2033-07-01', '2034-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(15, '2034/2035', '2034-07-01', '2035-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(16, '2035/2036', '2035-07-01', '2036-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(17, '2036/2037', '2036-07-01', '2037-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(18, '2037/2038', '2037-07-01', '2038-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(19, '2038/2039', '2038-07-01', '2039-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(20, '2039/2040', '2039-07-01', '2040-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(21, '2040/2041', '2040-07-01', '2041-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(22, '2041/2042', '2041-07-01', '2042-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(23, '2042/2043', '2042-07-01', '2043-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(24, '2043/2044', '2043-07-01', '2044-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(25, '2044/2045', '2044-07-01', '2045-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(26, '2045/2046', '2045-07-01', '2046-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(27, '2046/2047', '2046-07-01', '2047-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(28, '2047/2048', '2047-07-01', '2048-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(29, '2048/2049', '2048-07-01', '2049-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(30, '2049/2050', '2049-07-01', '2050-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(31, '2050/2051', '2050-07-01', '2051-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(32, '2051/2052', '2051-07-01', '2052-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(33, '2052/2053', '2052-07-01', '2053-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(34, '2053/2054', '2053-07-01', '2054-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(35, '2054/2055', '2054-07-01', '2055-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(36, '2055/2056', '2055-07-01', '2056-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(37, '2056/2057', '2056-07-01', '2057-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(38, '2057/2058', '2057-07-01', '2058-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(39, '2058/2059', '2058-07-01', '2059-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(40, '2059/2060', '2059-07-01', '2060-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(41, '2060/2061', '2060-07-01', '2061-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(42, '2061/2062', '2061-07-01', '2062-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(43, '2062/2063', '2062-07-01', '2063-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(44, '2063/2064', '2063-07-01', '2064-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(45, '2064/2065', '2064-07-01', '2065-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(46, '2065/2066', '2065-07-01', '2066-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(47, '2066/2067', '2066-07-01', '2067-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(48, '2067/2068', '2067-07-01', '2068-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(49, '2068/2069', '2068-07-01', '2069-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09'),
(50, '2069/2070', '2069-07-01', '2070-06-30', 1, '2026-09-23 02:24:09', '2026-09-23 02:24:09');

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE `t_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_users`
--

INSERT INTO `t_users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin01', 'admin01@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(2, 'admin02', 'admin02@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(3, 'admin03', 'admin03@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(4, 'admin04', 'admin04@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(5, 'admin05', 'admin05@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(6, 'admin06', 'admin06@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(7, 'admin07', 'admin07@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(8, 'admin08', 'admin08@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(9, 'admin09', 'admin09@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(10, 'admin10', 'admin10@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(11, 'admin11', 'admin11@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(12, 'admin12', 'admin12@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(13, 'admin13', 'admin13@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(14, 'admin14', 'admin14@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(15, 'admin15', 'admin15@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(16, 'admin16', 'admin16@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(17, 'admin17', 'admin17@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(18, 'admin18', 'admin18@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(19, 'admin19', 'admin19@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(20, 'admin20', 'admin20@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(21, 'admin21', 'admin21@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(22, 'admin22', 'admin22@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(23, 'admin23', 'admin23@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(24, 'admin24', 'admin24@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(25, 'admin25', 'admin25@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(26, 'admin26', 'admin26@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(27, 'admin27', 'admin27@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(28, 'admin28', 'admin28@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(29, 'admin29', 'admin29@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(30, 'admin30', 'admin30@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(31, 'admin31', 'admin31@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(32, 'admin32', 'admin32@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(33, 'admin33', 'admin33@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(34, 'admin34', 'admin34@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(35, 'admin35', 'admin35@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(36, 'admin36', 'admin36@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(37, 'admin37', 'admin37@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(38, 'admin38', 'admin38@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(39, 'admin39', 'admin39@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(40, 'admin40', 'admin40@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(41, 'admin41', 'admin41@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(42, 'admin42', 'admin42@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(43, 'admin43', 'admin43@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(44, 'admin44', 'admin44@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(45, 'admin45', 'admin45@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(46, 'admin46', 'admin46@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(47, 'admin47', 'admin47@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(48, 'admin48', 'admin48@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(49, 'admin49', 'admin49@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41'),
(50, 'admin50', 'admin50@sekolah.test', '2026-09-23 02:23:41', 'password123', '', 'admin', '2026-09-23 02:23:41', '2026-09-23 02:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `t_wali_kelas`
--

CREATE TABLE `t_wali_kelas` (
  `id` int(11) NOT NULL,
  `tahun_ajaran_id` int(11) DEFAULT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `status_aktif` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `t_wali_kelas`
--

INSERT INTO `t_wali_kelas` (`id`, `tahun_ajaran_id`, `kelas_id`, `guru_id`, `tanggal_mulai`, `tanggal_selesai`, `status_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2020-07-01', '2021-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(2, 2, 2, 2, '2021-07-01', '2022-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(3, 3, 3, 3, '2022-07-01', '2023-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(4, 4, 4, 4, '2023-07-01', '2024-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(5, 5, 5, 5, '2024-07-01', '2025-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(6, 6, 6, 6, '2025-07-01', '2026-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(7, 7, 7, 7, '2026-07-01', '2027-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(8, 8, 8, 8, '2027-07-01', '2028-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(9, 9, 9, 9, '2028-07-01', '2029-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(10, 10, 10, 10, '2029-07-01', '2030-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(11, 11, 11, 11, '2030-07-01', '2031-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(12, 12, 12, 12, '2031-07-01', '2032-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(13, 13, 13, 13, '2032-07-01', '2033-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(14, 14, 14, 14, '2033-07-01', '2034-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(15, 15, 15, 15, '2034-07-01', '2035-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(16, 16, 16, 16, '2035-07-01', '2036-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(17, 17, 17, 17, '2036-07-01', '2037-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(18, 18, 18, 18, '2037-07-01', '2038-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(19, 19, 19, 19, '2038-07-01', '2039-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(20, 20, 20, 20, '2039-07-01', '2040-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(21, 21, 21, 21, '2040-07-01', '2041-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(22, 22, 22, 22, '2041-07-01', '2042-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(23, 23, 23, 23, '2042-07-01', '2043-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(24, 24, 24, 24, '2043-07-01', '2044-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(25, 25, 25, 25, '2044-07-01', '2045-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(26, 26, 26, 26, '2045-07-01', '2046-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(27, 27, 27, 27, '2046-07-01', '2047-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(28, 28, 28, 28, '2047-07-01', '2048-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(29, 29, 29, 29, '2048-07-01', '2049-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(30, 30, 30, 30, '2049-07-01', '2050-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(31, 31, 31, 31, '2050-07-01', '2051-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(32, 32, 32, 32, '2051-07-01', '2052-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(33, 33, 33, 33, '2052-07-01', '2053-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(34, 34, 34, 34, '2053-07-01', '2054-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(35, 35, 35, 35, '2054-07-01', '2055-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(36, 36, 36, 36, '2055-07-01', '2056-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(37, 37, 37, 37, '2056-07-01', '2057-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(38, 38, 38, 38, '2057-07-01', '2058-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(39, 39, 39, 39, '2058-07-01', '2059-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(40, 40, 40, 40, '2059-07-01', '2060-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(41, 41, 41, 41, '2060-07-01', '2061-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(42, 42, 42, 42, '2061-07-01', '2062-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(43, 43, 43, 43, '2062-07-01', '2063-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(44, 44, 44, 44, '2063-07-01', '2064-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(45, 45, 45, 45, '2064-07-01', '2065-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(46, 46, 46, 46, '2065-07-01', '2066-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(47, 47, 47, 47, '2066-07-01', '2067-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(48, 48, 48, 48, '2067-07-01', '2068-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(49, 49, 49, 49, '2068-07-01', '2069-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57'),
(50, 50, 50, 50, '2069-07-01', '2070-06-30', 1, '2026-09-23 02:37:57', '2026-09-23 02:37:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_guru`
--
ALTER TABLE `t_guru`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `t_kelas`
--
ALTER TABLE `t_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`);

--
-- Indexes for table `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`,`siswa_id`,`kelas_id`,`pelanggaran_id`,`pelanggaran_kategori_id`,`guru_id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `pelanggaran_kategori_id` (`pelanggaran_kategori_id`),
  ADD KEY `pelanggaran_id` (`pelanggaran_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `t_siswa`
--
ALTER TABLE `t_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tahun_ajaran_id` (`tahun_ajaran_id`,`kelas_id`,`guru_id`),
  ADD KEY `guru_id` (`guru_id`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_guru`
--
ALTER TABLE `t_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_kelas`
--
ALTER TABLE `t_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_pelanggaran_kategori`
--
ALTER TABLE `t_pelanggaran_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_siswa`
--
ALTER TABLE `t_siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_tahun_ajaran`
--
ALTER TABLE `t_tahun_ajaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_guru`
--
ALTER TABLE `t_guru`
  ADD CONSTRAINT `t_guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `t_users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_kelas_siswa`
--
ALTER TABLE `t_kelas_siswa`
  ADD CONSTRAINT `t_kelas_siswa_ibfk_1` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_2` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_kelas_siswa_ibfk_3` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_pelanggaran`
--
ALTER TABLE `t_pelanggaran`
  ADD CONSTRAINT `t_pelanggaran_ibfk_1` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_pelanggaran_siswa`
--
ALTER TABLE `t_pelanggaran_siswa`
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_3` FOREIGN KEY (`siswa_id`) REFERENCES `t_siswa` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_4` FOREIGN KEY (`pelanggaran_kategori_id`) REFERENCES `t_pelanggaran_kategori` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_5` FOREIGN KEY (`pelanggaran_id`) REFERENCES `t_pelanggaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_pelanggaran_siswa_ibfk_6` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `t_wali_kelas`
--
ALTER TABLE `t_wali_kelas`
  ADD CONSTRAINT `t_wali_kelas_ibfk_2` FOREIGN KEY (`tahun_ajaran_id`) REFERENCES `t_tahun_ajaran` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_3` FOREIGN KEY (`guru_id`) REFERENCES `t_guru` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `t_wali_kelas_ibfk_4` FOREIGN KEY (`kelas_id`) REFERENCES `t_kelas` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
