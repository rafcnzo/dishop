-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 12, 2025 at 04:25 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dishop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('nanangdorris@gmail.com|127.0.0.1', 'i:2;', 1757596444),
('nanangdorris@gmail.com|127.0.0.1:timer', 'i:1757596444;', 1757596444),
('xynzzdormz@gmail.com|127.0.0.1', 'i:1;', 1757596463),
('xynzzdormz@gmail.com|127.0.0.1:timer', 'i:1757596463;', 1757596463);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_07_28_073903_create_products_table', 1),
(5, '2025_09_10_082027_create_transaksi_table', 1),
(6, '2025_09_10_082034_create_transaksi_detail_table', 1),
(7, '2025_09_10_082044_create_pembayaran_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `bukti_transfer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` enum('T','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'T=Disetujui, F=Ditolak',
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `waktu` datetime DEFAULT NULL COMMENT 'Waktu pembayaran',
  `dtmodi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `transaksi_id`, `bukti_transfer`, `metode`, `status_pembayaran`, `keterangan`, `waktu`, `dtmodi`) VALUES
(1, 1, 'bukti1.jpg', 'QRIS', 'T', 'Pembayaran diterima', '2025-09-09 11:39:43', '2025-09-09 11:39:43'),
(2, 2, 'bukti2.jpg', 'QRIS', 'F', 'Pembayaran ditolak', '2025-09-10 11:39:43', '2025-09-10 11:39:43'),
(3, 3, 'bukti3.jpg', 'Transfer', 'T', 'Pembayaran diterima', '2025-09-10 07:39:43', '2025-09-10 07:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `kode_barang`, `nama_barang`, `deskripsi`, `harga`, `stok`, `supplier_id`, `status`, `image`, `created_at`, `updated_at`) VALUES
(1, 'PRD001', 'Ban Mobil Sedan', 'Ban Mobil kembang siap tempur', 750000, 100, 9, 1, '1842970842769737.10-109117_tire-vector-png-tire-silhouette.png', '2025-09-10 04:39:43', '2025-09-11 05:32:38'),
(2, 'PRD002', 'Coolant motor Shell 4L', 'Coolant cairan air radiator motor', 32000, 50, 8, 1, '1842970897210168.Shell COOLANT Longlife plus 4L.webp', '2025-09-10 04:39:43', '2025-09-11 05:33:30'),
(3, 'PRD003', 'Oli rem Prestone', 'Oli rem motor pakem parah prestone', 60000, 20, 9, 1, '1842970937136910.Prestone Minyak rem.jpg', '2025-09-10 04:39:43', '2025-09-11 05:34:08'),
(4, 'BRG00002', 'Castrol Magnatec Diesel 10w-30', 'Castrol Oil mobil, Oli mesin Kental', 20000, 10, 8, 0, '1842970978768040.Castrol Magnatec Diesel 10w-30.jpg', '2025-09-11 05:34:48', '2025-09-11 05:34:48'),
(5, 'BRG00003', 'Michellin', 'Ban Michelin Motor', 220000, 10, 8, 0, '1842971025212509.ban.webp', '2025-09-11 05:35:32', '2025-09-11 05:35:32'),
(6, 'BRG00004', 'Alenza untuk SUV PREMIUM', 'Ban Mobil guys', 780000, 8, 9, 0, '1842971067666567.Alenza untuk SUV PREMIUM.png', '2025-09-11 05:36:13', '2025-09-11 05:36:13'),
(7, 'BRG00005', 'Kampas rem Motor', 'Kampas rem kualitas original', 55000, 25, 8, 0, '1842971110921069.Kampas rem avanza,xenia,rush,terios Depan.jpg', '2025-09-11 05:36:54', '2025-09-11 05:36:54'),
(8, 'BRG00006', 'laher roda belakang', 'laher roda motor belakang', 32000, 10, 8, 0, '1842971143476281.laher roda belakang.jpeg', '2025-09-11 05:37:25', '2025-09-11 05:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('IHFYY0l7cWxpjizAsK0pClHzNYbKe6n6lOSUctPA', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidjdTc1dVa0NFODFFTG1uS2hxc0JWaE1HMjd1ZWJtdTFOZG91Qkg0TiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9teW9yZGVycyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO30=', 1757694250),
('z66ozIL5IghY0xVsHA8Gsn1jJeXbubxmxFJAQXWR', 10, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMVBFVGVLdGExWGlHNnZSMHpIczZKUVlFeGFuMkE0WUNrS1paNXZRTSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjEwO3M6NDoiY2FydCI7YToxOntpOjY7YTo0OntzOjQ6Im5hbWUiO3M6MjQ6IkFsZW56YSB1bnR1ayBTVVYgUFJFTUlVTSI7czozOiJxdHkiO3M6MToiMSI7czo1OiJwcmljZSI7aTo3ODAwMDA7czo1OiJpbWFnZSI7czo4ODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL3VwbG9hZC9pbWFnZXNfcHJvZHVrLzE4NDI5NzEwNjc2NjY1NjcuQWxlbnphIHVudHVrIFNVViBQUkVNSVVNLnBuZyI7fX19', 1757599450);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pelanggan_id` bigint(20) UNSIGNED NOT NULL,
  `waktu_transaksi` datetime NOT NULL,
  `total` int(11) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dtcrea` datetime DEFAULT NULL,
  `dtmodi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `pelanggan_id`, `waktu_transaksi`, `total`, `keterangan`, `dtcrea`, `dtmodi`) VALUES
(1, 1, '2025-09-08 11:39:43', 50000, 'menunggu Konfirmasi', '2025-09-08 11:39:43', '2025-09-08 11:39:43'),
(2, 2, '2025-09-09 11:39:43', 120000, 'diterima', '2025-09-09 11:39:43', '2025-09-09 11:39:43'),
(3, 1, '2025-09-10 06:39:43', 75000, 'selesai', '2025-09-10 06:39:43', '2025-09-10 06:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `dtcrea` datetime DEFAULT NULL,
  `dtmodi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id`, `transaksi_id`, `barang_id`, `qty`, `harga`, `dtcrea`, `dtmodi`) VALUES
(1, 1, 1, 2, 25000, '2025-09-08 11:39:43', '2025-09-08 11:39:43'),
(2, 2, 2, 3, 40000, '2025-09-09 11:39:43', '2025-09-09 11:39:43'),
(3, 3, 1, 1, 75000, '2025-09-10 06:39:43', '2025-09-10 06:39:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('penjual','pembeli','supplier') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pembeli',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `email`, `email_verified_at`, `password`, `jenis_kelamin`, `phone`, `alamat`, `photo`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Penjual', 'penjual', 'penjual@gmail.com', NULL, '$2y$12$ZrFuRg8Fx9B6OD7nFdDoZ.NNPwR1ukcZLf4vlPUdu1gDp9ENkCvqe', 'L', NULL, NULL, NULL, 'penjual', 'active', NULL, NULL, NULL),
(2, 'Pembeli', 'pembeli', 'pembeli@gmail.com', NULL, '$2y$12$AYshaQT31gZvtINmcuYRm.p5JokRnF4KUdkDimHnodL6GVwlreT/6', 'P', NULL, NULL, NULL, 'pembeli', 'active', NULL, NULL, NULL),
(3, 'Mr. Antonio Oberbrunner', NULL, 'ortiz.kory@example.net', '2025-09-10 04:39:43', '$2y$12$gWkqkspnoiJ1D0JooI6CFOZtFEWS9RhDRcCUAfwhpfbNYgbpaclEm', 'L', '+1 (281) 828-2439', '3877 Monica Island Suite 717\nKieranbury, MO 01354', 'https://via.placeholder.com/60x60.png/006633?text=esse', 'pembeli', 'active', 'eoJOY3yRi3', '2025-09-10 04:39:43', '2025-09-10 04:39:43'),
(4, 'Yadira Marquardt', NULL, 'watsica.douglas@example.com', '2025-09-10 04:39:43', '$2y$12$gWkqkspnoiJ1D0JooI6CFOZtFEWS9RhDRcCUAfwhpfbNYgbpaclEm', 'L', '+1-915-975-2370', '7625 Flatley Inlet\nSusannabury, NM 65363', 'https://via.placeholder.com/60x60.png/002233?text=unde', 'pembeli', 'active', 'BRQkJ4ZtJ7', '2025-09-10 04:39:43', '2025-09-10 04:39:43'),
(5, 'Price Tremblay PhD', NULL, 'hwest@example.com', '2025-09-10 04:39:43', '$2y$12$gWkqkspnoiJ1D0JooI6CFOZtFEWS9RhDRcCUAfwhpfbNYgbpaclEm', 'L', '+19564061469', '447 Hettinger Stravenue\nDuBuquebury, PA 14028-5830', 'https://via.placeholder.com/60x60.png/009955?text=omnis', 'pembeli', 'active', 'gswjCih76z', '2025-09-10 04:39:43', '2025-09-10 04:39:43'),
(6, 'Nedra Dibbert', NULL, 'powlowski.kari@example.net', '2025-09-10 04:39:43', '$2y$12$gWkqkspnoiJ1D0JooI6CFOZtFEWS9RhDRcCUAfwhpfbNYgbpaclEm', 'L', '872-892-3727', '645 Bosco Plains Apt. 870\nLake Joseph, NJ 60439', 'https://via.placeholder.com/60x60.png/0077cc?text=delectus', 'pembeli', 'active', '8lrQxBZ1oE', '2025-09-10 04:39:43', '2025-09-10 04:39:43'),
(7, 'Amy Grimes', NULL, 'dallin77@example.com', '2025-09-10 04:39:43', '$2y$12$gWkqkspnoiJ1D0JooI6CFOZtFEWS9RhDRcCUAfwhpfbNYgbpaclEm', 'L', '660.944.8294', '31242 Monte Streets Suite 514\nWest Murphyburgh, KY 94531-8269', 'https://via.placeholder.com/60x60.png/006677?text=quos', 'pembeli', 'active', 'G8wmFoQF8Z', '2025-09-10 04:39:43', '2025-09-10 04:39:43'),
(8, 'Muhammad Rafi Afriza', NULL, NULL, NULL, NULL, 'L', '0895358265850', '127 Main Street', NULL, 'supplier', 'active', NULL, '2025-09-11 05:31:34', '2025-09-11 05:31:34'),
(9, 'Rafz Gixios', NULL, NULL, NULL, NULL, 'L', '01201991249', 'Jalan Melati No. 54 Kelurahan Pakembaran Kecamatan Slawi, Kabupaten Tegal,\r\nHouse', NULL, 'supplier', 'active', NULL, '2025-09-11 05:31:55', '2025-09-11 05:31:55'),
(10, 'Muhammad Rafi Afriza', 'rafcnzo', 'goncalopavard@gmail.com', NULL, '$2y$12$shAsGqL/qFCPAE4TxrKsTucVeEmkRxX5Z9.Km6eMX1k1gL7ZOKHOC', 'L', '0895358265850', 'Jalan Melati No. 54 Kelurahan Pakembaran Kecamatan Slawi, Kabupaten Tegal,\r\nHouse', NULL, 'pembeli', 'active', NULL, '2025-09-11 06:14:26', '2025-09-11 06:14:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_transaksi_id_foreign` (`transaksi_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_pelanggan_id_foreign` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_detail_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `transaksi_detail_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_pelanggan_id_foreign` FOREIGN KEY (`pelanggan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_detail_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
