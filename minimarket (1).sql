-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2025 at 01:50 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `minimarket`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Sembako Harian', NULL, 1, '2025-11-16 05:58:06', '2025-11-16 05:58:06'),
(2, 'Minuman', NULL, 1, '2025-11-16 05:58:30', '2025-11-16 05:58:30'),
(3, 'Makanan Ringan', NULL, 1, '2025-11-16 05:58:48', '2025-11-16 05:58:48'),
(4, 'Bahan Pokok', NULL, 1, '2025-11-22 00:01:40', '2025-11-22 00:01:40'),
(5, 'Makanan', NULL, 1, '2025-11-22 00:01:40', '2025-11-29 04:13:36'),
(6, 'Peralatan Rumah Tangga', NULL, 1, '2025-11-22 00:01:40', '2025-11-22 00:01:40'),
(7, 'Buah dan Sayur', NULL, 1, '2025-11-22 00:01:40', '2025-11-22 00:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint UNSIGNED NOT NULL,
  `kode_member` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poin` int NOT NULL DEFAULT '0',
  `diskon` int NOT NULL DEFAULT '10',
  `tanggal_daftar` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `kode_member`, `user_id`, `nama_lengkap`, `nomor_telepon`, `poin`, `diskon`, `tanggal_daftar`, `created_at`, `updated_at`) VALUES
(1, 'MB202511160001', NULL, 'Iqbal Viskal', '01837189223', 97, 10, '2025-11-16', '2025-11-16 06:44:39', '2025-11-28 07:47:39'),
(2, 'MB202511160002', NULL, 'Ghania Khairinnisa', '08111234456', 0, 10, '2025-11-16', '2025-11-16 06:44:53', '2025-11-16 06:44:53'),
(3, 'MB202511220001', NULL, 'Fika', '01293583445', 25, 10, '2025-11-22', '2025-11-21 23:17:19', '2025-11-25 04:03:18'),
(4, 'MMB001', NULL, 'John Doe', '081234567894', 100, 10, '2025-11-22', '2025-11-22 00:01:40', '2025-11-22 00:01:40'),
(5, 'MMB002', NULL, 'Jane Smith', '081234567895', 50, 10, '2025-11-22', '2025-11-22 00:01:40', '2025-11-22 00:01:40'),
(6, 'MMB003', NULL, 'Bob Johnson', '081234567896', 200, 10, '2025-11-22', '2025-11-22 00:01:40', '2025-11-22 00:01:40'),
(7, 'MMB004', NULL, 'Alice Brown', '081234567897', 75, 10, '2025-11-22', '2025-11-22 00:01:40', '2025-11-22 00:01:40'),
(8, 'MMB005', NULL, 'Charlie Wilson', '081234567898', 150, 10, '2025-11-22', '2025-11-22 00:01:40', '2025-11-22 00:01:40');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_01_01_000003_create_categories_table', 1),
(5, '2025_09_28_082108_create_products_table', 1),
(6, '2025_11_11_013645_create_members_table', 1),
(7, '2025_11_11_013915_create_promos_table', 1),
(8, '2025_11_11_013947_create_carts_table', 1),
(9, '2025_11_11_014027_create_orders_table', 1),
(10, '2025_11_11_014102_create_order_items_table', 1),
(11, '2025_11_11_014146_create_shifts_table', 1),
(12, '2025_11_11_021153_create_stock_history_table', 1),
(13, '2025_11_16_040338_create_sessions_table_for_minimarket', 1),
(14, '2025_11_16_040338_create_sessions', 2),
(15, '2025_11_16_162502_add_is_flash_sale_to_products_table', 3),
(16, '2025_11_23_153445_update_orders_metode_pembayaran_enum', 3),
(17, '2025_11_23_154347_change_enum_to_varchar_in_orders_table', 4),
(18, '2025_11_25_045935_add_diskon_to_members_table', 5),
(19, '2025_11_25_123136_add_wholesale_rules_to_products_table', 6),
(20, '2025_11_28_131041_add_shift_id_to_orders_table', 7),
(21, '2025_11_28_131934_update_shifts_table_add_missing_columns', 8),
(22, '2025_11_28_140429_add_timestamps_to_shifts_table', 9),
(25, '2025_11_28_154050_remove_wholesale_rules_from_products_table', 10),
(26, '2025_11_29_055255_fix_orders_table_structure', 11),
(27, '2025_11_29_064635_add_verification_fields_to_orders_table', 12),
(28, '2025_11_29_124123_add_nama_kasir_to_shifts_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `shift_id` bigint UNSIGNED DEFAULT NULL,
  `member_id` bigint UNSIGNED DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `total_diskon` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_bayar` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) NOT NULL DEFAULT '0.00',
  `metode_pembayaran` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tunai',
  `nomor_rekening` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu_pembayaran',
  `catatan_verifikasi` text COLLATE utf8mb4_unicode_ci,
  `tipe_pesanan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'website',
  `status_pesanan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kota` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `metode_pengiriman` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_number`, `user_id`, `shift_id`, `member_id`, `subtotal`, `total_diskon`, `total_bayar`, `shipping_cost`, `metode_pembayaran`, `nomor_rekening`, `bukti_pembayaran`, `status_pembayaran`, `catatan_verifikasi`, `tipe_pesanan`, `status_pesanan`, `nama_lengkap`, `no_telepon`, `alamat`, `kota`, `metode_pengiriman`, `catatan`, `created_at`, `updated_at`) VALUES
(1, NULL, 2, NULL, 3, '147000.00', '14700.00', '132300.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-24 23:37:26', '2025-11-24 23:37:26'),
(2, NULL, 2, NULL, NULL, '17000.00', '0.00', '17000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 01:18:07', '2025-11-25 01:18:07'),
(3, NULL, 2, NULL, 3, '97000.00', '9700.00', '87300.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 02:12:25', '2025-11-25 02:12:25'),
(4, NULL, 2, NULL, 1, '115000.00', '11500.00', '103500.00', '0.00', 'debit_kredit', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 02:14:23', '2025-11-25 02:14:23'),
(5, NULL, 2, NULL, 1, '85000.00', '8500.00', '76500.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 02:17:50', '2025-11-25 02:17:50'),
(6, NULL, 2, NULL, NULL, '92000.00', '0.00', '92000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 02:22:37', '2025-11-25 02:22:37'),
(7, NULL, 2, NULL, 1, '157500.00', '15750.00', '141750.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 02:40:05', '2025-11-25 02:40:05'),
(8, NULL, 2, NULL, 1, '115000.00', '11500.00', '103500.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 02:48:15', '2025-11-25 02:48:15'),
(9, NULL, 2, NULL, NULL, '100000.00', '0.00', '100000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:07:24', '2025-11-25 03:07:24'),
(10, NULL, 2, NULL, NULL, '55000.00', '0.00', '55000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:08:04', '2025-11-25 03:08:04'),
(11, NULL, 2, NULL, NULL, '35000.00', '0.00', '35000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:10:50', '2025-11-25 03:10:50'),
(12, NULL, 2, NULL, NULL, '50000.00', '0.00', '50000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:12:22', '2025-11-25 03:12:22'),
(13, NULL, 2, NULL, NULL, '5000.00', '0.00', '5000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:14:44', '2025-11-25 03:14:44'),
(14, NULL, 2, NULL, NULL, '39000.00', '0.00', '39000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:28:42', '2025-11-25 03:28:42'),
(15, NULL, 2, NULL, NULL, '12000.00', '0.00', '12000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:31:07', '2025-11-25 03:31:07'),
(16, NULL, 2, NULL, NULL, '5000.00', '0.00', '5000.00', '0.00', 'debit_kredit', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 03:39:08', '2025-11-25 03:39:08'),
(17, NULL, 2, NULL, 3, '15000.00', '1500.00', '13500.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 04:03:15', '2025-11-25 04:03:15'),
(18, NULL, 2, NULL, 3, '15000.00', '1500.00', '13500.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 04:03:18', '2025-11-25 04:03:18'),
(19, NULL, 2, NULL, NULL, '5000.00', '0.00', '5000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 04:09:25', '2025-11-25 04:09:25'),
(20, NULL, 2, NULL, 1, '375000.00', '37500.00', '337500.00', '0.00', 'qris_ewallet', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 05:16:02', '2025-11-25 05:16:02'),
(21, NULL, 2, NULL, NULL, '5000.00', '0.00', '5000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 05:16:36', '2025-11-25 05:16:36'),
(22, NULL, 2, NULL, NULL, '50000.00', '0.00', '50000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-25 05:43:46', '2025-11-25 05:43:46'),
(23, NULL, 2, 2, NULL, '95000.00', '0.00', '95000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 07:36:38', '2025-11-28 07:36:38'),
(24, NULL, 2, 2, NULL, '95000.00', '0.00', '95000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 07:40:25', '2025-11-28 07:40:25'),
(25, NULL, 2, 2, 1, '152000.00', '15200.00', '136800.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 07:47:39', '2025-11-28 07:47:39'),
(26, NULL, 2, 2, NULL, '220000.00', '0.00', '220000.00', '0.00', 'debit_kredit', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 07:49:37', '2025-11-28 07:49:37'),
(27, NULL, 4, NULL, NULL, '203000.00', '0.00', '218000.00', '0.00', 'transfer', NULL, NULL, 'dibatalkan', NULL, 'online', 'dibatalkan', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 21:13:27', '2025-11-28 21:18:12'),
(28, NULL, 4, NULL, NULL, '26500.00', '0.00', '41500.00', '0.00', 'transfer', '12100002938172', 'bukti_pembayaran/payment_1764396390_28.jpg', 'menunggu_verifikasi', NULL, 'online', 'diproses', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 21:21:06', '2025-11-29 02:56:06'),
(29, NULL, 4, NULL, NULL, '85000.00', '0.00', '100000.00', '0.00', 'transfer', NULL, NULL, 'menunggu_pembayaran', NULL, 'online', 'dikirim', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 21:34:44', '2025-11-29 02:55:43'),
(30, NULL, 4, NULL, NULL, '60000.00', '0.00', '75000.00', '0.00', 'transfer', NULL, NULL, 'menunggu_pembayaran', NULL, 'online', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 21:57:10', '2025-11-29 02:55:30'),
(31, NULL, 4, NULL, NULL, '30000.00', '0.00', '45000.00', '0.00', 'transfer', '12100002938172', 'bukti_pembayaran/payment_1764394036_31.jpg', 'menunggu_verifikasi', NULL, 'online', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-28 22:02:16', '2025-11-29 02:55:15'),
(32, 'TS-20251129-IHHNDH', 4, NULL, NULL, '34500.00', '0.00', '34500.00', '0.00', 'tunai', NULL, NULL, 'lunas', NULL, 'website', 'dibatalkan', 'Fika', '01923832929', 'Rumbai', 'Pekanbaru', 'reguler', NULL, '2025-11-28 22:59:34', '2025-11-29 01:21:47'),
(33, 'TS-20251129-NAFLZF', 4, NULL, NULL, '25000.00', '0.00', '40000.00', '15000.00', 'qris', NULL, NULL, 'terverifikasi', NULL, 'website', 'selesai', 'Fika', '01923832929', 'arengka', 'Pekanbaru', 'reguler', NULL, '2025-11-28 23:02:52', '2025-11-29 01:21:27'),
(34, 'TS-20251129-KN3DS3', 4, NULL, NULL, '38500.00', '0.00', '38500.00', '0.00', 'transfer', NULL, NULL, 'terverifikasi', NULL, 'website', 'dikirim', 'Fika', '01923832929', 'rumbai', 'Pekanbaru', 'reguler', NULL, '2025-11-28 23:08:23', '2025-11-29 01:21:06'),
(35, 'TS-20251129-OQXJOL', 4, NULL, NULL, '10000.00', '0.00', '10000.00', '0.00', 'transfer', '12100002938172', 'bukti_pembayaran/payment_1764397232_35.jpg', 'terverifikasi', NULL, 'website', 'selesai', 'Fika', '01923832929', 'rumbai', 'Pekanbaru', 'reguler', NULL, '2025-11-28 23:20:18', '2025-11-29 01:20:47'),
(36, 'TS-20251129-BXLQS9', 4, NULL, NULL, '30000.00', '0.00', '30000.00', '0.00', 'qris', NULL, 'bukti_pembayaran/payment_1764397279_36.jpg', 'terverifikasi', NULL, 'website', 'selesai', 'Fika', '01923832929', 'rumbai', 'Pekanbaru', 'reguler', NULL, '2025-11-28 23:21:04', '2025-11-29 01:03:05'),
(37, 'TS-20251129-9CBCJH', 11, NULL, NULL, '180000.00', '0.00', '195000.00', '15000.00', 'qris', NULL, 'bukti_pembayaran/payment_1764397700_37.jpg', 'terverifikasi', NULL, 'website', 'selesai', 'yono', '09365290012', 'Kulim', 'Pekanbaru', 'reguler', NULL, '2025-11-28 23:28:04', '2025-11-29 00:58:46'),
(38, NULL, 2, 3, NULL, '77000.00', '0.00', '77000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-29 04:09:06', '2025-11-29 04:09:06'),
(39, 'TS-20251129-FMTCRV', 4, NULL, NULL, '35000.00', '0.00', '35000.00', '0.00', 'tunai', NULL, NULL, 'lunas', NULL, 'website', 'selesai', 'Fika', '01923832929', 'rumbai', 'Pekanbaru', 'reguler', NULL, '2025-11-29 04:38:08', '2025-11-29 04:38:56'),
(40, NULL, 2, 4, NULL, '150000.00', '0.00', '150000.00', '0.00', 'tunai', NULL, NULL, 'menunggu_pembayaran', NULL, 'pos', 'selesai', NULL, NULL, NULL, NULL, NULL, NULL, '2025-11-29 05:57:47', '2025-11-29 05:57:47');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `quantity` int NOT NULL,
  `harga_saat_beli` decimal(10,2) NOT NULL,
  `diskon_item` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `harga_saat_beli`, `diskon_item`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 1, '32000.00', '0.00', '2025-11-24 23:37:26', '2025-11-24 23:37:26'),
(2, 1, 2, 1, '25000.00', '0.00', '2025-11-24 23:37:26', '2025-11-24 23:37:26'),
(3, 1, 3, 1, '5000.00', '0.00', '2025-11-24 23:37:26', '2025-11-24 23:37:26'),
(4, 1, 8, 1, '5000.00', '0.00', '2025-11-24 23:37:26', '2025-11-24 23:37:26'),
(5, 1, 6, 1, '75000.00', '0.00', '2025-11-24 23:37:26', '2025-11-24 23:37:26'),
(6, 1, 4, 1, '5000.00', '0.00', '2025-11-24 23:37:26', '2025-11-24 23:37:26'),
(7, 2, 10, 1, '12000.00', '0.00', '2025-11-25 01:18:07', '2025-11-25 01:18:07'),
(8, 2, 3, 1, '5000.00', '0.00', '2025-11-25 01:18:07', '2025-11-25 01:18:07'),
(9, 3, 3, 1, '5000.00', '0.00', '2025-11-25 02:12:25', '2025-11-25 02:12:25'),
(10, 3, 10, 1, '12000.00', '0.00', '2025-11-25 02:12:25', '2025-11-25 02:12:25'),
(11, 3, 6, 1, '75000.00', '0.00', '2025-11-25 02:12:25', '2025-11-25 02:12:25'),
(12, 3, 8, 1, '5000.00', '0.00', '2025-11-25 02:12:25', '2025-11-25 02:12:25'),
(13, 4, 6, 1, '75000.00', '0.00', '2025-11-25 02:14:23', '2025-11-25 02:14:23'),
(14, 4, 8, 4, '5000.00', '0.00', '2025-11-25 02:14:23', '2025-11-25 02:14:23'),
(15, 4, 4, 1, '5000.00', '0.00', '2025-11-25 02:14:23', '2025-11-25 02:14:23'),
(16, 4, 3, 3, '5000.00', '0.00', '2025-11-25 02:14:23', '2025-11-25 02:14:23'),
(17, 5, 3, 1, '5000.00', '0.00', '2025-11-25 02:17:50', '2025-11-25 02:17:50'),
(18, 5, 6, 1, '75000.00', '0.00', '2025-11-25 02:17:50', '2025-11-25 02:17:50'),
(19, 5, 8, 1, '5000.00', '0.00', '2025-11-25 02:17:50', '2025-11-25 02:17:50'),
(20, 6, 3, 1, '5000.00', '0.00', '2025-11-25 02:22:37', '2025-11-25 02:22:37'),
(21, 6, 6, 1, '75000.00', '0.00', '2025-11-25 02:22:37', '2025-11-25 02:22:37'),
(22, 6, 10, 1, '12000.00', '0.00', '2025-11-25 02:22:37', '2025-11-25 02:22:37'),
(23, 7, 6, 1, '75000.00', '0.00', '2025-11-25 02:40:05', '2025-11-25 02:40:05'),
(24, 7, 8, 1, '5000.00', '0.00', '2025-11-25 02:40:05', '2025-11-25 02:40:05'),
(25, 7, 3, 1, '5000.00', '0.00', '2025-11-25 02:40:05', '2025-11-25 02:40:05'),
(26, 7, 10, 1, '12000.00', '0.00', '2025-11-25 02:40:05', '2025-11-25 02:40:05'),
(27, 7, 7, 1, '32000.00', '0.00', '2025-11-25 02:40:05', '2025-11-25 02:40:05'),
(28, 7, 2, 1, '25000.00', '0.00', '2025-11-25 02:40:05', '2025-11-25 02:40:05'),
(29, 7, 12, 1, '3500.00', '0.00', '2025-11-25 02:40:05', '2025-11-25 02:40:05'),
(30, 8, 2, 1, '25000.00', '0.00', '2025-11-25 02:48:15', '2025-11-25 02:48:15'),
(31, 8, 8, 1, '5000.00', '0.00', '2025-11-25 02:48:15', '2025-11-25 02:48:15'),
(32, 8, 4, 1, '5000.00', '0.00', '2025-11-25 02:48:15', '2025-11-25 02:48:15'),
(33, 8, 3, 1, '5000.00', '0.00', '2025-11-25 02:48:15', '2025-11-25 02:48:15'),
(34, 8, 6, 1, '75000.00', '0.00', '2025-11-25 02:48:15', '2025-11-25 02:48:15'),
(35, 9, 3, 1, '5000.00', '0.00', '2025-11-25 03:07:24', '2025-11-25 03:07:24'),
(36, 9, 6, 1, '75000.00', '0.00', '2025-11-25 03:07:24', '2025-11-25 03:07:24'),
(37, 9, 8, 4, '5000.00', '0.00', '2025-11-25 03:07:24', '2025-11-25 03:07:24'),
(38, 10, 8, 11, '5000.00', '0.00', '2025-11-25 03:08:04', '2025-11-25 03:08:04'),
(39, 11, 11, 5, '7000.00', '0.00', '2025-11-25 03:10:50', '2025-11-25 03:10:50'),
(40, 12, 8, 10, '5000.00', '0.00', '2025-11-25 03:12:22', '2025-11-25 03:12:22'),
(41, 13, 8, 1, '5000.00', '0.00', '2025-11-25 03:14:44', '2025-11-25 03:14:44'),
(42, 14, 11, 1, '7000.00', '0.00', '2025-11-25 03:28:42', '2025-11-25 03:28:42'),
(43, 14, 7, 1, '32000.00', '0.00', '2025-11-25 03:28:42', '2025-11-25 03:28:42'),
(44, 15, 8, 1, '5000.00', '0.00', '2025-11-25 03:31:07', '2025-11-25 03:31:07'),
(45, 15, 11, 1, '7000.00', '0.00', '2025-11-25 03:31:07', '2025-11-25 03:31:07'),
(46, 16, 8, 1, '5000.00', '0.00', '2025-11-25 03:39:08', '2025-11-25 03:39:08'),
(47, 17, 8, 3, '5000.00', '0.00', '2025-11-25 04:03:15', '2025-11-25 04:03:15'),
(48, 18, 8, 3, '5000.00', '0.00', '2025-11-25 04:03:18', '2025-11-25 04:03:18'),
(49, 19, 3, 1, '5000.00', '0.00', '2025-11-25 04:09:25', '2025-11-25 04:09:25'),
(50, 20, 6, 5, '75000.00', '0.00', '2025-11-25 05:16:02', '2025-11-25 05:16:02'),
(51, 21, 4, 1, '5000.00', '0.00', '2025-11-25 05:16:36', '2025-11-25 05:16:36'),
(52, 22, 8, 10, '5000.00', '0.00', '2025-11-25 05:43:46', '2025-11-25 05:43:46'),
(53, 23, 10, 1, '12000.00', '0.00', '2025-11-28 07:36:38', '2025-11-28 07:36:38'),
(54, 23, 9, 1, '8000.00', '0.00', '2025-11-28 07:36:38', '2025-11-28 07:36:38'),
(55, 23, 6, 1, '75000.00', '0.00', '2025-11-28 07:36:38', '2025-11-28 07:36:38'),
(56, 24, 10, 1, '12000.00', '0.00', '2025-11-28 07:40:25', '2025-11-28 07:40:25'),
(57, 24, 9, 1, '8000.00', '0.00', '2025-11-28 07:40:25', '2025-11-28 07:40:25'),
(58, 24, 6, 1, '75000.00', '0.00', '2025-11-28 07:40:25', '2025-11-28 07:40:25'),
(59, 25, 10, 12, '12000.00', '0.00', '2025-11-28 07:47:39', '2025-11-28 07:47:39'),
(60, 25, 9, 1, '8000.00', '0.00', '2025-11-28 07:47:39', '2025-11-28 07:47:39'),
(61, 26, NULL, 10, '22000.00', '0.00', '2025-11-28 07:49:37', '2025-11-28 07:49:37'),
(62, 27, 6, 1, '60000.00', '0.00', '2025-11-28 21:13:27', '2025-11-28 21:13:27'),
(63, 27, 7, 4, '25000.00', '0.00', '2025-11-28 21:13:27', '2025-11-28 21:13:27'),
(64, 27, 8, 7, '5000.00', '0.00', '2025-11-28 21:13:27', '2025-11-28 21:13:27'),
(65, 27, 9, 1, '8000.00', '0.00', '2025-11-28 21:13:27', '2025-11-28 21:13:27'),
(66, 28, 8, 1, '5000.00', '0.00', '2025-11-28 21:21:06', '2025-11-28 21:21:06'),
(67, 28, 11, 1, '7000.00', '0.00', '2025-11-28 21:21:06', '2025-11-28 21:21:06'),
(68, 28, 12, 1, '3500.00', '0.00', '2025-11-28 21:21:06', '2025-11-28 21:21:06'),
(69, 28, 13, 1, '11000.00', '0.00', '2025-11-28 21:21:06', '2025-11-28 21:21:06'),
(70, 29, 6, 1, '60000.00', '0.00', '2025-11-28 21:34:44', '2025-11-28 21:34:44'),
(71, 29, 7, 1, '25000.00', '0.00', '2025-11-28 21:34:44', '2025-11-28 21:34:44'),
(72, 30, 6, 1, '60000.00', '0.00', '2025-11-28 21:57:10', '2025-11-28 21:57:10'),
(73, 31, 4, 6, '5000.00', '0.00', '2025-11-28 22:02:16', '2025-11-28 22:02:16'),
(74, 32, 10, 2, '12000.00', '0.00', '2025-11-28 22:59:34', '2025-11-28 22:59:34'),
(75, 32, 11, 1, '7000.00', '0.00', '2025-11-28 22:59:34', '2025-11-28 22:59:34'),
(76, 32, 12, 1, '3500.00', '0.00', '2025-11-28 22:59:34', '2025-11-28 22:59:34'),
(77, 33, 7, 1, '25000.00', '0.00', '2025-11-28 23:02:52', '2025-11-28 23:02:52'),
(78, 34, 12, 11, '3500.00', '0.00', '2025-11-28 23:08:23', '2025-11-28 23:08:23'),
(79, 35, 4, 2, '5000.00', '0.00', '2025-11-28 23:20:18', '2025-11-28 23:20:18'),
(80, 36, 7, 1, '25000.00', '0.00', '2025-11-28 23:21:04', '2025-11-28 23:21:04'),
(81, 36, 8, 1, '5000.00', '0.00', '2025-11-28 23:21:04', '2025-11-28 23:21:04'),
(82, 37, 6, 3, '60000.00', '0.00', '2025-11-28 23:28:04', '2025-11-28 23:28:04'),
(83, 38, 8, 1, '5000.00', '0.00', '2025-11-29 04:09:06', '2025-11-29 04:09:06'),
(84, 38, 6, 1, '60000.00', '0.00', '2025-11-29 04:09:06', '2025-11-29 04:09:06'),
(85, 38, 10, 1, '12000.00', '0.00', '2025-11-29 04:09:06', '2025-11-29 04:09:06'),
(86, 39, 11, 5, '7000.00', '0.00', '2025-11-29 04:38:08', '2025-11-29 04:38:08'),
(87, 40, 7, 6, '25000.00', '0.00', '2025-11-29 05:57:47', '2025-11-29 05:57:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `stok` int NOT NULL,
  `stok_kritis` int NOT NULL DEFAULT '5',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_flash_sale` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `nama_produk`, `barcode`, `deskripsi`, `gambar_url`, `harga_beli`, `harga_jual`, `stok`, `stok_kritis`, `status`, `created_at`, `updated_at`, `is_flash_sale`) VALUES
(2, 1, 'Minyak', '7012xxxxx', NULL, NULL, '20000.00', '25000.00', 0, 5, 1, '2025-11-16 05:59:28', '2025-11-25 02:48:15', 0),
(3, 3, 'Chitato', '12334xxxxx', NULL, NULL, '3000.00', '5000.00', 0, 5, 1, '2025-11-16 06:00:02', '2025-11-25 04:09:25', 0),
(4, 2, 'Aqua 500ml', '9088xxxx', NULL, NULL, '4000.00', '5000.00', 78, 5, 1, '2025-11-17 17:48:52', '2025-11-28 23:20:18', 0),
(5, 3, 'SaltCheese', '29381xxxxx', NULL, 'products/9By1Y7vEdLzn2P4AUYzGC5viQroB6V2qvK0Jjyj7.jpg', '3000.00', '4000.00', 12, 5, 1, '2025-11-21 21:31:10', '2025-11-21 21:31:10', 0),
(6, 1, 'Beras Premium 5kg', '1234567890123', 'Beras premium kualitas terbaik', 'products/s4YYfo3XxJ4G9Mv17JtJa9aWoZOYtukGSZAW3D86.jpg', '60000.00', '60000.00', 44, 10, 1, '2025-11-22 00:01:40', '2025-11-29 04:09:06', 0),
(7, 1, 'Minyak Goreng 2L', '1234567890124', 'Minyak goreng sawit', NULL, '25000.00', '25000.00', 91, 5, 1, '2025-11-22 00:01:40', '2025-11-29 05:57:47', 0),
(8, 2, 'Aqua 600ml', '1234567890125', 'Air mineral', NULL, '3000.00', '5000.00', 144, 20, 1, '2025-11-22 00:01:40', '2025-11-29 04:09:06', 0),
(9, 2, 'Coca-Cola 330ml', '1234567890126', 'Minuman bersoda', NULL, '6000.00', '8000.00', 147, 15, 1, '2025-11-22 00:01:40', '2025-11-28 21:18:12', 0),
(10, 3, 'Chitato 100gr', '1234567890127', 'Chip kentang', NULL, '8000.00', '12000.00', 59, 8, 1, '2025-11-22 00:01:40', '2025-11-29 04:09:06', 0),
(11, 4, 'Lifebuoy Sabun Mandi', '1234567890128', 'Sabun mandi anti bakteri', NULL, '5000.00', '7000.00', 46, 6, 1, '2025-11-22 00:01:40', '2025-11-29 04:38:08', 0),
(12, 3, 'Indomie Goreng', '1234567890129', 'Mi instan goreng', NULL, '2500.00', '3500.00', 186, 20, 1, '2025-11-22 00:01:40', '2025-11-28 23:08:23', 0),
(13, 5, 'Sunlight 450ml', '1234567890130', 'Sabun cuci piring', NULL, '8000.00', '11000.00', 39, 5, 1, '2025-11-22 00:01:40', '2025-11-28 21:21:06', 0);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nama_kasir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `modal_awal` decimal(10,2) NOT NULL,
  `total_penjualan_sistem` decimal(10,2) DEFAULT NULL,
  `total_tunai_sistem` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_debit_sistem` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_qris_sistem` decimal(15,2) NOT NULL DEFAULT '0.00',
  `uang_fisik_di_kasir` decimal(15,2) NOT NULL DEFAULT '0.00',
  `selisih` decimal(15,2) NOT NULL DEFAULT '0.00',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `waktu_mulai` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`id`, `user_id`, `nama_kasir`, `modal_awal`, `total_penjualan_sistem`, `total_tunai_sistem`, `total_debit_sistem`, `total_qris_sistem`, `uang_fisik_di_kasir`, `selisih`, `catatan`, `created_at`, `updated_at`, `waktu_mulai`, `waktu_selesai`, `status`) VALUES
(1, 2, NULL, '1500000.00', NULL, '0.00', '0.00', '0.00', '2533350.00', '1033350.00', NULL, '2025-11-28 07:06:24', '2025-11-28 07:08:23', '2025-11-28 07:06:24', '2025-11-28 07:08:23', 'closed'),
(2, 2, NULL, '100000.00', NULL, '326800.00', '220000.00', '0.00', '426800.00', '0.00', NULL, '2025-11-28 07:11:28', '2025-11-28 07:50:08', '2025-11-28 07:11:28', '2025-11-28 07:50:08', 'closed'),
(3, 2, NULL, '100000.00', NULL, '77000.00', '0.00', '0.00', '177000.00', '0.00', NULL, '2025-11-29 04:08:48', '2025-11-29 04:09:32', '2025-11-29 04:08:48', '2025-11-29 04:09:32', 'closed'),
(4, 2, 'Budi', '150000.00', NULL, '262000.00', '0.00', '0.00', '412000.00', '0.00', NULL, '2025-11-29 05:57:20', '2025-11-29 05:58:19', '2025-11-29 05:57:20', '2025-11-29 05:58:19', 'closed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('owner','admin','kasir','customer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `password`, `role`, `no_telepon`, `alamat`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pemilik Toko', 'owner@minimarket.com', '$2y$12$8NGYDrZmApkU4E0Oi2JWDuZz8NuA2VITXmbH1TjB0JGPnYv/lCcNG', 'owner', '081234567891', 'Jl. Owner No. 1', NULL, '2025-11-15 21:14:54', '2025-11-22 00:01:40'),
(2, 'Kasir Toko', 'kasir@minimarket.com', '$2y$12$7.ueGlLWFlR/J654Q3WSOe0Q0hTdoQ.6SBHxL9OyVGddIyVDpC5JC', 'kasir', '081234567892', 'Jl. Kasir No. 1', NULL, '2025-11-15 21:14:54', '2025-11-22 00:01:40'),
(3, 'Super Admin', 'admin@minimarket.com', '$2y$12$6yUiWySWT3zZjjFP5O5E1uWkVgHbCBqWD8QKkdntfRar7wNt6BMhq', 'admin', '081234567890', 'Jl. Admin No. 1', NULL, '2025-11-15 21:14:54', '2025-11-22 00:01:40'),
(4, 'Fika', 'customer@minimarket.com', '$2y$12$Z0HIQMlY5teS6ANAug0TOOpKDPcCgqM3d4zSEdWKN2kHpFG4ATxCO', 'customer', '01923832929', 'rumbai', NULL, '2025-11-15 21:14:55', '2025-11-28 23:08:23'),
(5, 'Ghania Khairinnisa', 'ghania24ti@mahasiswa.pcr.ac.id', '$2y$12$aYYhae.zAoSPpLN4ZN2.yuCQp0cOelMhQfHONJ9mfWRaLzmGarmtS', 'customer', '081537554726', 'marpoyan', NULL, '2025-11-16 07:11:12', '2025-11-16 07:11:12'),
(6, 'Iqbal Viskal', 'iqbal@gmail.com', '$2y$12$L7c/x0HxNpX78c6cXypImeti.PeD.r8lxH9vow88VzMeyadZL/fL2', 'kasir', NULL, NULL, NULL, '2025-11-16 10:59:01', '2025-11-16 11:03:35'),
(7, 'Yuni', 'yuni@gmail.com', '$2y$12$lFLCY4kjh5phI/LBvB5DCu9f9yfHHp1ZaaMAz4AMtksx83E.JxILy', 'customer', '1020101021', 'harapan raya', NULL, '2025-11-17 09:51:09', '2025-11-17 09:51:09'),
(9, 'Pelanggan Contoh', 'customer@example.com', '$2y$12$iskjk4MgjoKiMLloSW5A7.KoJ0MAk2YCf3GS5ss2TVddG2P9Vljvu', 'customer', '081234567893', 'Jl. Pelanggan No. 1', NULL, '2025-11-22 00:01:40', '2025-11-22 00:01:40'),
(10, 'LalaLulu', 'lala@gmail.com', '$2y$12$q2RV0U6CUMBzeo4Uo7VBj.3polfK/lR1k4ylOirWyK8sczQi74bLq', 'customer', '0856789043', 'harapan raya', NULL, '2025-11-24 23:23:07', '2025-11-24 23:23:07'),
(11, 'yono', 'yono@gmail.com', '$2y$12$T2cv6ksu9qgkVBh6wuSRgun9FREonOoeOQ80w.HeKEL30Hr/a43hC', 'customer', '09365290012', 'Kulim', NULL, '2025-11-28 23:27:35', '2025-11-28 23:27:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `members_kode_member_unique` (`kode_member`),
  ADD UNIQUE KEY `members_nomor_telepon_unique` (`nomor_telepon`),
  ADD KEY `members_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_member_id_foreign` (`member_id`),
  ADD KEY `orders_shift_id_foreign` (`shift_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_barcode_unique` (`barcode`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shifts_user_id_foreign` (`user_id`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
