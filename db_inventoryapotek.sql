-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Des 2025 pada 16.38
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventoryapotek`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(6, 'Obat Bebas', 'obat-bebas', '2025-11-20 00:39:22', '2025-11-20 00:39:22'),
(7, 'Obat Bebas Terbatas', 'obat-bebas-terbatas', '2025-11-20 00:39:35', '2025-11-20 00:39:35'),
(8, 'Obat Keras', 'obat-keras', '2025-11-20 00:39:48', '2025-11-20 00:39:48'),
(9, 'Obat Wajib Apotek', 'obat-wajib-apotek', '2025-11-20 00:40:02', '2025-11-20 04:33:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_obat_keluars`
--

CREATE TABLE `detail_obat_keluars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Id_Detail_Keluar` varchar(100) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `obat_keluar_id` bigint(20) UNSIGNED NOT NULL,
  `Jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_obat_keluars`
--

INSERT INTO `detail_obat_keluars` (`id`, `Id_Detail_Keluar`, `product_id`, `obat_keluar_id`, `Jumlah`, `created_at`, `updated_at`) VALUES
(1, 'DK001', 7, 1, 1, '2025-11-20 04:54:29', '2025-11-20 04:54:29'),
(2, 'DK002', 4, 2, 1, '2025-11-26 07:52:52', '2025-11-26 07:52:52'),
(3, 'DK003', 5, 3, 1, '2025-11-26 07:53:16', '2025-11-26 07:53:16'),
(4, 'DK004', 7, 4, 1, '2025-11-26 08:10:08', '2025-11-26 08:10:08'),
(5, 'DK005', 7, 5, 1, '2025-11-26 08:18:12', '2025-11-26 08:18:12'),
(6, 'DK006', 7, 6, 1, '2025-11-26 08:23:22', '2025-11-26 08:23:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_obat_masuks`
--

CREATE TABLE `detail_obat_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Id_Detail_Masuk` varchar(100) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `obat_masuk_id` bigint(20) UNSIGNED DEFAULT NULL,
  `Jumlah` int(11) DEFAULT NULL,
  `Harga_Beli` int(11) DEFAULT NULL,
  `Tanggal_Kadaluwarsa` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stok_batch` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_obat_masuks`
--

INSERT INTO `detail_obat_masuks` (`id`, `Id_Detail_Masuk`, `product_id`, `obat_masuk_id`, `Jumlah`, `Harga_Beli`, `Tanggal_Kadaluwarsa`, `created_at`, `updated_at`, `stok_batch`) VALUES
(1, 'DM001', 4, 1, 2, 85000, '2027-12-31', '2025-11-20 03:43:58', '2025-11-20 03:43:58', 0),
(2, 'DM002', 5, 2, 1, 56000, '2027-12-31', '2025-11-20 03:47:03', '2025-11-20 03:47:03', 0),
(3, 'DM003', 6, 3, 20, 3500, '2027-12-31', '2025-11-20 03:47:54', '2025-11-20 03:47:54', 0),
(4, 'DM004', 7, 4, 3, 16000, '2027-12-31', '2025-11-20 04:41:22', '2025-11-20 04:41:22', 0),
(5, 'DM005', 8, 5, 5, 21000, '2027-12-31', '2025-11-23 07:20:18', '2025-11-23 07:20:18', 0),
(6, 'DM006', 9, 6, 10, 39000, '2027-12-31', '2025-11-23 07:21:08', '2025-11-23 07:21:08', 0),
(7, 'DM007', 16, 7, 2, 120000, '2028-12-31', '2025-11-23 07:23:53', '2025-11-23 07:23:53', 0),
(8, 'DM008', 17, 7, 1, 43000, '2028-12-31', '2025-11-23 07:23:53', '2025-11-23 07:23:53', 0),
(9, 'DM009', 18, 7, 3, 65000, '2028-12-31', '2025-11-23 07:23:53', '2025-11-23 07:23:53', 0),
(10, 'DM010', 14, 8, 5, 44000, '2027-12-31', '2025-11-23 07:25:35', '2025-11-23 07:25:35', 0),
(11, 'DM011', 15, 9, 5, 110000, '2027-12-31', '2025-11-23 07:29:14', '2025-11-23 07:29:14', 0),
(12, 'DM012', 10, 10, 3, 67000, '2027-12-31', '2025-11-23 07:37:34', '2025-11-23 07:37:34', 0),
(13, 'DM013', 11, 11, 5, 75000, '2027-12-31', '2025-11-23 07:39:07', '2025-11-23 07:39:07', 0),
(14, 'DM014', 12, 11, 4, 63000, '2027-12-31', '2025-11-23 07:39:07', '2025-11-23 07:39:07', 0),
(15, 'DM015', 13, 12, 10, 14000, '2027-12-31', '2025-11-23 07:41:12', '2025-11-23 07:41:12', 0),
(16, 'DM016', 19, 13, 10, 15000, '2027-12-31', '2025-11-23 07:44:31', '2025-11-23 07:44:31', 0),
(17, 'DM017', 23, 14, 5, 25000, '2027-12-31', '2025-11-23 07:45:39', '2025-11-23 07:45:39', 0),
(18, 'DM018', 20, 15, 5, 15000, '2027-12-31', '2025-11-23 07:52:06', '2025-11-23 07:52:06', 0),
(19, 'DM019', 21, 15, 7, 24000, '2027-12-31', '2025-11-23 07:52:06', '2025-11-23 07:52:06', 0),
(20, 'DM020', 22, 15, 3, 31000, '2027-12-31', '2025-11-23 07:52:06', '2025-11-23 07:52:06', 0),
(21, 'DM021', 24, 16, 5, 17000, '2027-12-31', '2025-11-23 08:06:05', '2025-11-23 08:06:05', 0),
(22, 'DM022', 25, 17, 10, 15000, '2027-12-31', '2025-11-23 08:08:20', '2025-11-23 08:08:20', 0),
(23, 'DM023', 26, 17, 5, 26000, '2027-12-31', '2025-11-23 08:08:20', '2025-11-23 08:08:20', 0),
(24, 'DM024', 27, 18, 4, 40000, '2027-12-31', '2025-11-23 08:10:50', '2025-11-23 08:10:50', 0),
(25, 'DM025', 28, 18, 3, 85000, '2027-12-31', '2025-11-23 08:10:50', '2025-11-23 08:10:50', 0),
(26, 'DM026', 29, 18, 3, 125000, '2027-12-31', '2025-11-23 08:10:50', '2025-11-23 08:10:50', 0),
(28, 'DM028', 7, 20, 1, 50000, '2027-12-31', '2025-11-26 08:23:07', '2025-11-26 08:23:07', 0),
(29, 'DM029', 7, 21, 1, 50000, '2027-12-31', '2025-11-26 08:28:50', '2025-11-26 08:28:50', 0),
(30, 'DM030', 5, 22, 2, 56000, '2027-12-31', '2025-11-26 08:32:31', '2025-11-26 08:32:31', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2025_11_04_110505_alter_id_masuk_nullable_on_obat_masuks_table', 4),
(14, '2025_11_04_111330_alter_total_default_in_obat_masuks_table', 5),
(15, '2025_11_04_111823_alter_detail_obat_masuks_nullable', 6),
(25, '0001_01_01_000000_create_users_table', 7),
(26, '0001_01_01_000001_create_cache_table', 7),
(27, '0001_01_01_000002_create_jobs_table', 7),
(28, '2025_10_05_125658_create_categories_table', 7),
(29, '2025_10_05_135006_create_products_table', 7),
(30, '2025_10_26_122312_add_slug_colum_in_categories_table', 7),
(31, '2025_10_26_124614_create_obat_masuks_table', 7),
(32, '2025_10_26_124917_create_detail_obat_masuks_table', 7),
(33, '2025_10_26_125104_create_obat_keluars_table', 7),
(34, '2025_10_26_125233_create_detail_obat_keluars_table', 7),
(35, '2025_10_26_142552_add_role_and_no_wa_to_users_table', 7),
(36, '2025_10_26_142920_modify_role_column_in_users_table', 7),
(37, '2025_11_05_092203_update_id_detail_keluar_nullable_on_detail_obat_keluars_table', 7),
(38, '2025_11_06_104925_change_role_column_in_users_table', 7),
(39, '2025_11_04_154441_alter_id_masuk_nullable_on_obat_masuks_table', 8),
(40, '2025_11_04_154635_alter_total_default_in_obat_masuks_table', 8),
(41, '2025_11_04_155139_alter_detail_obat_masuks_nullable', 8),
(42, '2025_11_07_100015_add_harga_expired_to_detail_obat_masuk_table', 9),
(43, '2025_11_16_144143_add_stok_batch_to_detail_obat_masuk_table', 9),
(44, '2025_11_16_145349_add_batch_columns_to_detail_obat_keluars_table', 9),
(45, '2025_11_16_155139_alter_detail_obat_masuks_nullable', 10),
(46, '2025_11_20_063036_create_satuans_table', 10),
(47, '2025_11_20_074523_add_slug_to_satuans_table', 11),
(48, '2025_11_20_095225_add_satuan_id_to_products_table', 12),
(49, '2025_11_20_095404_remove_price_from_products_table', 13),
(50, '2025_11_20_095504_add_default_stock_to_products_table', 14),
(51, '2025_11_20_095550_remove_expired_at_from_products_table', 15),
(52, '2025_11_20_115348_alter_id_keluar_nullable_in_obat_keluars_table', 16);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat_keluars`
--

CREATE TABLE `obat_keluars` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Id_Keluar` varchar(191) DEFAULT NULL,
  `Id_User` bigint(20) UNSIGNED NOT NULL,
  `Tanggal_Keluar` date NOT NULL,
  `Jenis_Keluar` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `obat_keluars`
--

INSERT INTO `obat_keluars` (`id`, `Id_Keluar`, `Id_User`, `Tanggal_Keluar`, `Jenis_Keluar`, `created_at`, `updated_at`) VALUES
(1, 'K001', 2, '2025-11-20', 'Masuk kedalam etalase penjualan', '2025-11-20 04:54:29', '2025-11-20 04:54:29'),
(2, 'K002', 2, '2025-11-26', 'Masuk kedalam etalase penjualan', '2025-11-26 07:52:52', '2025-11-26 07:52:52'),
(3, 'K003', 2, '2025-11-26', 'Masuk kedalam etalase penjualan', '2025-11-26 07:53:16', '2025-11-26 07:53:16'),
(4, 'K004', 2, '2025-11-26', 'Kadaluarsa', '2025-11-26 08:10:08', '2025-11-26 08:10:08'),
(5, 'K005', 2, '2025-11-26', 'Kadaluarsa', '2025-11-26 08:18:12', '2025-11-26 08:18:12'),
(6, 'K006', 2, '2025-11-26', 'Kadaluarsa', '2025-11-26 08:23:22', '2025-11-26 08:23:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat_masuks`
--

CREATE TABLE `obat_masuks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Id_Masuk` varchar(100) DEFAULT NULL,
  `Id_User` bigint(20) UNSIGNED NOT NULL,
  `Tanggal_Masuk` date NOT NULL,
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `obat_masuks`
--

INSERT INTO `obat_masuks` (`id`, `Id_Masuk`, `Id_User`, `Tanggal_Masuk`, `total`, `created_at`, `updated_at`) VALUES
(1, 'M001', 2, '2025-11-20', 0.00, '2025-11-20 03:43:58', '2025-11-20 03:43:58'),
(2, 'M002', 2, '2025-11-20', 0.00, '2025-11-20 03:47:03', '2025-11-20 03:47:03'),
(3, 'M003', 2, '2025-11-20', 0.00, '2025-11-20 03:47:54', '2025-11-20 03:47:54'),
(4, 'M004', 2, '2025-11-20', 0.00, '2025-11-20 04:41:22', '2025-11-20 04:41:22'),
(5, 'M005', 2, '2025-11-23', 0.00, '2025-11-23 07:20:18', '2025-11-23 07:20:18'),
(6, 'M006', 2, '2025-11-23', 0.00, '2025-11-23 07:21:08', '2025-11-23 07:21:08'),
(7, 'M007', 2, '2025-11-18', 0.00, '2025-11-23 07:23:53', '2025-11-23 07:23:53'),
(8, 'M008', 2, '2025-11-21', 0.00, '2025-11-23 07:25:35', '2025-11-23 07:25:35'),
(9, 'M009', 2, '2025-11-16', 0.00, '2025-11-23 07:29:14', '2025-11-23 07:29:14'),
(10, 'M010', 2, '2025-09-23', 0.00, '2025-11-23 07:37:34', '2025-11-23 07:37:34'),
(11, 'M011', 2, '2025-10-15', 0.00, '2025-11-23 07:39:07', '2025-11-23 07:39:07'),
(12, 'M012', 2, '2025-09-10', 0.00, '2025-11-23 07:41:12', '2025-11-23 07:41:12'),
(13, 'M013', 2, '2025-01-20', 0.00, '2025-11-23 07:44:31', '2025-11-23 07:44:31'),
(14, 'M014', 2, '2025-05-05', 0.00, '2025-11-23 07:45:39', '2025-11-23 07:45:39'),
(15, 'M015', 2, '2025-08-10', 0.00, '2025-11-23 07:52:06', '2025-11-23 07:52:06'),
(16, 'M016', 2, '2025-03-20', 0.00, '2025-11-23 08:06:05', '2025-11-23 08:06:05'),
(17, 'M017', 2, '2025-04-25', 0.00, '2025-11-23 08:08:20', '2025-11-23 08:08:20'),
(18, 'M018', 2, '2025-07-15', 0.00, '2025-11-23 08:10:50', '2025-11-23 08:10:50'),
(19, 'M019', 2, '2025-11-26', 0.00, '2025-11-26 08:09:53', '2025-11-26 08:09:53'),
(20, 'M020', 2, '2025-11-26', 0.00, '2025-11-26 08:23:07', '2025-11-26 08:23:07'),
(21, 'M021', 2, '2025-11-26', 0.00, '2025-11-26 08:28:50', '2025-11-26 08:28:50'),
(22, 'M022', 2, '2025-11-26', 0.00, '2025-11-26 08:32:31', '2025-11-26 08:32:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `satuan_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `sku`, `stock`, `category_id`, `satuan_id`, `created_at`, `updated_at`) VALUES
(4, 'Mixagrip Flu & Batuk', 'O001', 1, 7, 1, '2025-11-20 03:13:32', '2025-11-26 07:52:52'),
(5, 'Bodrex Flu + Batuk Berdahak', 'O002', 2, 7, 1, '2025-11-20 03:14:30', '2025-11-26 08:32:31'),
(6, 'Bodrex Flu', 'O003', 20, 7, 2, '2025-11-20 03:19:50', '2025-11-20 04:22:17'),
(7, 'Komix OBH', 'O004', 2, 7, 5, '2025-11-20 04:32:56', '2025-11-26 08:28:50'),
(8, 'Decadryl 60 ml', 'O005', 5, 7, 3, '2025-11-23 06:28:31', '2025-11-23 07:20:18'),
(9, 'Decadryl 120 ml', 'O006', 10, 7, 3, '2025-11-23 06:28:55', '2025-11-23 07:21:08'),
(10, 'Actifed Merah', 'O007', 3, 7, 3, '2025-11-23 06:30:53', '2025-11-23 07:37:34'),
(11, 'Actifed Kuning', 'O008', 5, 7, 3, '2025-11-23 06:31:34', '2025-11-23 07:39:07'),
(12, 'Actifed Hijau', 'O009', 4, 7, 3, '2025-11-23 06:31:48', '2025-11-23 07:39:07'),
(13, 'Curcuma Plus', 'O010', 10, 6, 3, '2025-11-23 06:35:53', '2025-11-23 07:41:12'),
(14, 'Imboost Kids 60 ml', 'O011', 5, 6, 3, '2025-11-23 06:36:46', '2025-11-23 07:25:35'),
(15, 'Imboost Kids 120 ml', 'O012', 5, 6, 3, '2025-11-23 06:37:07', '2025-11-23 07:29:14'),
(16, 'Paramex', 'O013', 2, 7, 1, '2025-11-23 06:42:51', '2025-11-23 07:23:53'),
(17, 'Paramex Nyeri Otot', 'O014', 1, 7, 1, '2025-11-23 06:44:05', '2025-11-23 07:23:53'),
(18, 'Paramex Flu & Batuk', 'O015', 3, 7, 1, '2025-11-23 06:44:44', '2025-11-23 07:23:53'),
(19, 'Insto', 'O016', 10, 7, 3, '2025-11-23 06:46:34', '2025-11-23 07:44:31'),
(20, 'Vicks Formula 27 ml', 'O017', 5, 7, 3, '2025-11-23 06:48:17', '2025-11-23 07:52:06'),
(21, 'Vicks Formula 54 ml', 'O018', 7, 7, 3, '2025-11-23 06:48:35', '2025-11-23 07:52:06'),
(22, 'Vicks Formula 100 ml', 'O019', 3, 7, 3, '2025-11-23 06:48:51', '2025-11-23 07:52:06'),
(23, 'Promag Tablet', 'O020', 5, 6, 1, '2025-11-23 06:51:41', '2025-11-23 07:45:39'),
(24, 'OBH Combi Batuk Dahak 100 ml', 'O021', 5, 7, 3, '2025-11-23 07:56:56', '2025-11-23 08:06:05'),
(25, 'OBH Combi Batuk + Flu 60 ml', 'O022', 10, 7, 3, '2025-11-23 07:57:28', '2025-11-23 08:08:20'),
(26, 'OBH Combi Batuk + Flu 100 ml', 'O023', 5, 7, 3, '2025-11-23 07:57:43', '2025-11-23 08:08:20'),
(27, 'OBH Ibu & Anak 75 ml', 'O024', 4, 7, 3, '2025-11-23 07:59:51', '2025-11-23 08:10:50'),
(28, 'OBH Ibu & Anak 150 ml', 'O025', 3, 7, 3, '2025-11-23 08:00:06', '2025-11-23 08:10:50'),
(29, 'OBH Ibu & Anak 300 ml', 'O026', 3, 7, 3, '2025-11-23 08:00:20', '2025-11-23 08:10:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuans`
--

CREATE TABLE `satuans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `satuans`
--

INSERT INTO `satuans` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Box', 'box', '2025-11-20 00:45:45', '2025-11-20 00:45:45'),
(2, 'Strip', 'strip', '2025-11-20 00:46:48', '2025-11-20 00:46:48'),
(3, 'Botol', 'botol', '2025-11-20 00:46:54', '2025-11-20 00:46:54'),
(4, 'Pcs', 'pcs', '2025-11-20 00:47:08', '2025-11-20 00:47:08'),
(5, 'Pack', 'pack', '2025-11-20 04:25:26', '2025-11-20 04:25:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `role` varchar(191) NOT NULL,
  `No_Wa` varchar(20) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `No_Wa`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Raihan', 'Admin@gmail.com', NULL, '$2y$12$pyzUr3/hYIBlPU42365FeO.fwjko8wcqlMu46g7repZe6lw7eY3MO', 'Admin', '085229560002', NULL, NULL, '2025-11-16 09:40:09'),
(2, 'Oci', 'Gudang@gmail.com', NULL, '$2y$12$xTRN5lMB15nFu2Kw2U.HSeQqlGwvx/78a5KZkn69SiWZ09Z99eWSu', 'Pengurus Gudang', '0895327755456', NULL, NULL, '2025-11-16 09:41:03');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_obat_keluars`
--
ALTER TABLE `detail_obat_keluars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_obat_keluars_product_id_foreign` (`product_id`),
  ADD KEY `detail_obat_keluars_obat_keluar_id_foreign` (`obat_keluar_id`);

--
-- Indeks untuk tabel `detail_obat_masuks`
--
ALTER TABLE `detail_obat_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_obat_masuks_product_id_foreign` (`product_id`),
  ADD KEY `detail_obat_masuks_obat_masuk_id_foreign` (`obat_masuk_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obat_keluars`
--
ALTER TABLE `obat_keluars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `obat_keluars_id_user_foreign` (`Id_User`);

--
-- Indeks untuk tabel `obat_masuks`
--
ALTER TABLE `obat_masuks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `obat_masuks_id_user_foreign` (`Id_User`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_satuan_id_foreign` (`satuan_id`);

--
-- Indeks untuk tabel `satuans`
--
ALTER TABLE `satuans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `satuans_slug_unique` (`slug`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `detail_obat_keluars`
--
ALTER TABLE `detail_obat_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `detail_obat_masuks`
--
ALTER TABLE `detail_obat_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT untuk tabel `obat_keluars`
--
ALTER TABLE `obat_keluars`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `obat_masuks`
--
ALTER TABLE `obat_masuks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `satuans`
--
ALTER TABLE `satuans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_obat_keluars`
--
ALTER TABLE `detail_obat_keluars`
  ADD CONSTRAINT `detail_obat_keluars_obat_keluar_id_foreign` FOREIGN KEY (`obat_keluar_id`) REFERENCES `obat_keluars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_obat_keluars_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_obat_masuks`
--
ALTER TABLE `detail_obat_masuks`
  ADD CONSTRAINT `detail_obat_masuks_obat_masuk_id_foreign` FOREIGN KEY (`obat_masuk_id`) REFERENCES `obat_masuks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_obat_masuks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `obat_keluars`
--
ALTER TABLE `obat_keluars`
  ADD CONSTRAINT `obat_keluars_id_user_foreign` FOREIGN KEY (`Id_User`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `obat_masuks`
--
ALTER TABLE `obat_masuks`
  ADD CONSTRAINT `obat_masuks_id_user_foreign` FOREIGN KEY (`Id_User`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_satuan_id_foreign` FOREIGN KEY (`satuan_id`) REFERENCES `satuans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
