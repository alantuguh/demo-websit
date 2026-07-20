-- ============================================================
-- Database: lpske  (export phpMyAdmin)
-- Baris CREATE DATABASE + USE di bawah ditambahkan agar impor
-- lewat CLI (mysql < file.sql) langsung membuat & memakai db lpske.
-- ============================================================
CREATE DATABASE IF NOT EXISTS `lpske` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lpske`;

-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 16 Jul 2026 pada 19.55
-- Versi server: 5.7.44-log
-- Versi PHP: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lpske`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alumni_story`
--

CREATE TABLE `alumni_story` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan` year(4) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `alumni_story`
--

INSERT INTO `alumni_story` (`id`, `deskripsi`, `foto`, `angkatan`, `is_active`, `user_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '<p>contoh aja</p>', 'alumni/01K6HDFJ772VZ2VFD4JECZVW68.jpeg', '2025', 1, NULL, '2025-10-02 02:54:34', '2025-10-02 02:55:14', '2025-10-02 02:55:14'),
(2, '<p>Angkatan 2022</p>', 'alumni/01K6HRM9HQZ8RGGAVR3YZNJW7B.jpeg', '2022', 1, NULL, '2025-10-02 06:09:24', '2025-11-18 18:49:21', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-1e1b85d7263799d8e471ac9fc6ebefc3e2c31bc3', 'i:1;', 1773303909),
('laravel-cache-1e1b85d7263799d8e471ac9fc6ebefc3e2c31bc3:timer', 'i:1773303909;', 1773303909),
('laravel-cache-6427c57d6d7688aba9f7e57c7ddb707037975e0d', 'i:1;', 1759385404),
('laravel-cache-6427c57d6d7688aba9f7e57c7ddb707037975e0d:timer', 'i:1759385404;', 1759385404),
('laravel-cache-livewire-rate-limiter:0079a2639890ebd4858c36fec9ee6fde97c59b49', 'i:2;', 1765728559),
('laravel-cache-livewire-rate-limiter:0079a2639890ebd4858c36fec9ee6fde97c59b49:timer', 'i:1765728559;', 1765728559),
('laravel-cache-livewire-rate-limiter:26fe2074b882fbedcf398347efddd8da89b3baac', 'i:1;', 1774675265),
('laravel-cache-livewire-rate-limiter:26fe2074b882fbedcf398347efddd8da89b3baac:timer', 'i:1774675265;', 1774675265),
('laravel-cache-livewire-rate-limiter:28f012d033660bd5b25bbfa87ad5a48dbc2b2860', 'i:1;', 1773298421),
('laravel-cache-livewire-rate-limiter:28f012d033660bd5b25bbfa87ad5a48dbc2b2860:timer', 'i:1773298421;', 1773298421),
('laravel-cache-livewire-rate-limiter:2ccd65331dd9bd3803afe495003afc1050ecd8ea', 'i:2;', 1768722969),
('laravel-cache-livewire-rate-limiter:2ccd65331dd9bd3803afe495003afc1050ecd8ea:timer', 'i:1768722969;', 1768722969),
('laravel-cache-livewire-rate-limiter:2fc77007f162decdcedc33fea2a8de0bff3c1c60', 'i:1;', 1759976792),
('laravel-cache-livewire-rate-limiter:2fc77007f162decdcedc33fea2a8de0bff3c1c60:timer', 'i:1759976792;', 1759976792),
('laravel-cache-livewire-rate-limiter:3282c3807a3e440cc68210d3114a720f5ae1e2a3', 'i:1;', 1773313940),
('laravel-cache-livewire-rate-limiter:3282c3807a3e440cc68210d3114a720f5ae1e2a3:timer', 'i:1773313940;', 1773313940),
('laravel-cache-livewire-rate-limiter:34217faf9b9936b5fd2a7a30ec0e4407086b7342', 'i:1;', 1767677445),
('laravel-cache-livewire-rate-limiter:34217faf9b9936b5fd2a7a30ec0e4407086b7342:timer', 'i:1767677445;', 1767677445),
('laravel-cache-livewire-rate-limiter:34cf55b220633cb2c2dd62de261fcccb8f2a42c5', 'i:2;', 1759330610),
('laravel-cache-livewire-rate-limiter:34cf55b220633cb2c2dd62de261fcccb8f2a42c5:timer', 'i:1759330610;', 1759330610),
('laravel-cache-livewire-rate-limiter:3a9216b4d96235b1043a80f38142c43e9dd394c7', 'i:2;', 1773296664),
('laravel-cache-livewire-rate-limiter:3a9216b4d96235b1043a80f38142c43e9dd394c7:timer', 'i:1773296664;', 1773296664),
('laravel-cache-livewire-rate-limiter:46cd15abd046a366f541234f7b63b5f2420a5371', 'i:1;', 1761093150),
('laravel-cache-livewire-rate-limiter:46cd15abd046a366f541234f7b63b5f2420a5371:timer', 'i:1761093150;', 1761093150),
('laravel-cache-livewire-rate-limiter:5022f1f230389faf44428661dfe2fb779d999715', 'i:1;', 1765201133),
('laravel-cache-livewire-rate-limiter:5022f1f230389faf44428661dfe2fb779d999715:timer', 'i:1765201133;', 1765201133),
('laravel-cache-livewire-rate-limiter:59fd59c77aa79e7ff23bd8fba570719657721d83', 'i:1;', 1773313952),
('laravel-cache-livewire-rate-limiter:59fd59c77aa79e7ff23bd8fba570719657721d83:timer', 'i:1773313952;', 1773313952),
('laravel-cache-livewire-rate-limiter:6070ea94e4827bb15503cc66d0362a80209d3dfc', 'i:1;', 1780988741),
('laravel-cache-livewire-rate-limiter:6070ea94e4827bb15503cc66d0362a80209d3dfc:timer', 'i:1780988741;', 1780988741),
('laravel-cache-livewire-rate-limiter:68d36422ff4d30d0aacb198cd62008f74f77e5a0', 'i:1;', 1768456743),
('laravel-cache-livewire-rate-limiter:68d36422ff4d30d0aacb198cd62008f74f77e5a0:timer', 'i:1768456743;', 1768456743),
('laravel-cache-livewire-rate-limiter:774886ab13d041f673524f9963ba867048049f62', 'i:1;', 1759327781),
('laravel-cache-livewire-rate-limiter:774886ab13d041f673524f9963ba867048049f62:timer', 'i:1759327781;', 1759327781),
('laravel-cache-livewire-rate-limiter:864c60031f90d2fd6ecaf776051fddf13f923b1b', 'i:1;', 1768722669),
('laravel-cache-livewire-rate-limiter:864c60031f90d2fd6ecaf776051fddf13f923b1b:timer', 'i:1768722669;', 1768722669),
('laravel-cache-livewire-rate-limiter:886900ee841847adff237c6c58e5729c128fd96d', 'i:1;', 1759683512),
('laravel-cache-livewire-rate-limiter:886900ee841847adff237c6c58e5729c128fd96d:timer', 'i:1759683512;', 1759683512),
('laravel-cache-livewire-rate-limiter:9877699ab709e7c2a499c95dbddec349676e1a68', 'i:1;', 1770180250),
('laravel-cache-livewire-rate-limiter:9877699ab709e7c2a499c95dbddec349676e1a68:timer', 'i:1770180250;', 1770180250),
('laravel-cache-livewire-rate-limiter:9bad71935e950b4612286531394dbc7c813f1c0a', 'i:2;', 1763491479),
('laravel-cache-livewire-rate-limiter:9bad71935e950b4612286531394dbc7c813f1c0a:timer', 'i:1763491479;', 1763491479),
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:1;', 1759319711),
('laravel-cache-livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1759319711;', 1759319711),
('laravel-cache-livewire-rate-limiter:af068dc51224f9d4c3bee0cc2a1cc2929f7350ae', 'i:1;', 1761020416),
('laravel-cache-livewire-rate-limiter:af068dc51224f9d4c3bee0cc2a1cc2929f7350ae:timer', 'i:1761020416;', 1761020416),
('laravel-cache-livewire-rate-limiter:b0528f8f1781d380c9845ff235dcb42997345ecc', 'i:2;', 1759488563),
('laravel-cache-livewire-rate-limiter:b0528f8f1781d380c9845ff235dcb42997345ecc:timer', 'i:1759488563;', 1759488563),
('laravel-cache-livewire-rate-limiter:db2a9fc607fe12704466cffcd13b1abd37b33e02', 'i:1;', 1759468240),
('laravel-cache-livewire-rate-limiter:db2a9fc607fe12704466cffcd13b1abd37b33e02:timer', 'i:1759468240;', 1759468240),
('laravel-cache-livewire-rate-limiter:e3428d9d7b3c078764b4060262a7ac12cbc85238', 'i:1;', 1773296578),
('laravel-cache-livewire-rate-limiter:e3428d9d7b3c078764b4060262a7ac12cbc85238:timer', 'i:1773296578;', 1773296578),
('laravel-cache-livewire-rate-limiter:f0368e3ba6ff47fb5809c1d9fd123c2620b39594', 'i:1;', 1773296205),
('laravel-cache-livewire-rate-limiter:f0368e3ba6ff47fb5809c1d9fd123c2620b39594:timer', 'i:1773296205;', 1773296205),
('laravel-cache-livewire-rate-limiter:f620f49837e19115f6f305c8ecfa48042d7ac5f5', 'i:1;', 1773296368),
('laravel-cache-livewire-rate-limiter:f620f49837e19115f6f305c8ecfa48042d7ac5f5:timer', 'i:1773296368;', 1773296368),
('laravel-cache-livewire-rate-limiter:ffe31551fde23a50efb4d7b27bb143084936d2e3', 'i:1;', 1773296611),
('laravel-cache-livewire-rate-limiter:ffe31551fde23a50efb4d7b27bb143084936d2e3:timer', 'i:1773296611;', 1773296611),
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:0:{}s:11:\"permissions\";a:0:{}s:5:\"roles\";a:0:{}}', 1781075082);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `jumlah_tersedia` int(11) NOT NULL DEFAULT '0',
  `kondisi` enum('baik','rusak_ringan','rusak_berat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status_pinjam` enum('tersedia','dipinjam','diproses') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  `peminjam_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jumlah_dipinjam` int(11) NOT NULL DEFAULT '0',
  `tanggal_pinjam` datetime DEFAULT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `alasan_pinjam` text COLLATE utf8mb4_unicode_ci,
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `status_persetujuan` enum('menunggu','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `inventory_items`
--

INSERT INTO `inventory_items` (`id`, `nama_barang`, `jumlah`, `jumlah_tersedia`, `kondisi`, `keterangan`, `status_pinjam`, `peminjam_id`, `jumlah_dipinjam`, `tanggal_pinjam`, `tanggal_kembali`, `alasan_pinjam`, `catatan_admin`, `status_persetujuan`, `created_at`, `updated_at`) VALUES
(1, 'Spirotest', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, '2026-02-05 02:08:16'),
(2, 'Tensimeter', 8, 7, 'baik', 'Mesin Semua Baik, 1 Sambungan Rusak - No. Inventaris: 23.01.03.189882.11.2003-2.08.01.//.00.1310/010', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(3, 'EEG', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, '2025-10-02 06:06:49'),
(4, 'Micrometer Scrub', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, '2025-10-03 03:33:08'),
(5, 'Vibration Meter', 3, 2, 'baik', '2 Baik 1 Rusak - No. Inventaris: 042.04.0300.400053.011.2015-3.08.08.100.08', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(6, 'Anemometer', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(7, 'Karbonmonoksida Meter', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(8, 'Envirometer', 1, 1, 'baik', 'No. Inventaris: 042.04.0300.400053.011.2015-3.08.06.029.99', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(9, 'Termometer', 8, 8, 'baik', 'No. Inventaris: 23.01.03.189881.11.2002-2.08.01.11.', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(10, 'Mi Band', 6, 4, 'baik', '4 Baik 4 Rusak', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(11, 'Digital Caliper', 12, 12, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(12, 'Flexible Curve', 12, 12, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(13, 'Camera', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(14, 'Body Tape Measure', 13, 13, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(15, 'Puzzle', 10, 10, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(16, 'Antropometri Portable', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(17, 'Portable Ceramic Heater', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(18, 'Penggaris 30 cm', 14, 13, 'baik', '13 Baik 1 Rusak', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(19, 'Baterai 9 Volt', 24, 23, 'baik', 'baterai 1 rusak', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(20, 'Penggaris 40 cm', 2, 2, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(21, 'Penggaris 50 cm', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(22, 'Penggaris 1 meter', 7, 7, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(23, 'Penggaris 60 cm', 8, 8, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(24, 'Penggaris Siku', 4, 4, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(25, 'Baterai A2', 2, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(26, 'Baterai Finix', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(27, 'Busur', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(28, 'Penggaris Segitiga', 2, 2, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(29, 'Penggaris Cetak', 2, 2, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(30, 'Safety Shoes', 10, 10, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(31, 'Timbangan Digital', 5, 5, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(32, 'Lightmeter', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(33, 'Heat Stress Monitor', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(34, 'Sound Level Meter', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(35, 'Kursi Antropometri', 1, 0, 'rusak_ringan', 'Akrilik Rusak - No. Inventaris: 042.01.0300.400900.011.2019-3.08.01.56.999', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(36, 'Meja Antropometri', 1, 1, 'baik', 'No. Inventaris: 01/MejaAntropometri/2023', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(37, 'Mesin Drilling', 1, 0, 'rusak_ringan', 'Tidak Bisa Dicek', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(38, 'Mitter Saw', 1, 0, 'rusak_ringan', 'Tidak Bisa Dicek', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(39, 'Rangka Manusia', 1, 0, 'rusak_ringan', 'Tangan Patah - No. Inventaris: 01/RangkaManusia/2023', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(40, 'Sepeda Statis', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(41, 'Treadmill', 1, 1, 'baik', 'No. Inventaris: 023.04.03.189882.011.2014-3.07.01.14.030', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(42, 'Power Supply', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(43, 'Papan Antropometri', 1, 1, 'rusak_ringan', 'Rusak Minor', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(44, 'Safety Helmet', 3, 3, 'baik', 'No. Inventaris: 01/Helm Safety/2023', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(45, 'Timbangan Jarum', 1, 1, 'baik', '', 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', NULL, NULL),
(46, 'LABORATORIUM LPSKE', 1, 1, 'baik', NULL, 'tersedia', NULL, 0, NULL, NULL, NULL, NULL, 'menunggu', '2025-10-07 07:39:24', '2025-10-07 07:39:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
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
-- Struktur dari tabel `job_batches`
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
-- Struktur dari tabel `logbooks`
--

CREATE TABLE `logbooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `asisten_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `logbooks`
--

INSERT INTO `logbooks` (`id`, `activity`, `description`, `date`, `asisten_id`, `created_at`, `updated_at`) VALUES
(1, 'Mie ayam', 'mantap', '2025-10-03', 17, '2025-10-03 03:29:17', '2025-10-03 03:29:17');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_01_175123_add_role_to_users_table', 1),
(5, '2025_08_02_011204_create_teams_table', 1),
(6, '2025_08_02_022258_create_prestasi_kegiatan_table', 1),
(7, '2025_08_02_025155_create_alumni_story_table', 1),
(8, '2025_08_02_042800_create_logbooks_table', 1),
(9, '2025_08_02_051811_create_presensis_table', 1),
(10, '2025_08_02_072500_remove_borrowing_fields_from_inventory_items', 1),
(11, '2025_08_02_131805_create_inventory_items_table', 1),
(12, '2025_08_02_131810_create_peminjaman_table', 1),
(13, '2025_08_02_135353_create_permission_tables', 1),
(14, '2025_08_02_160556_create_perizinans_table', 1),
(15, '2025_08_02_161000_add_absence_fields_to_peminjaman_table', 1),
(16, '2025_08_03_200011_add_encrypted_password_storage_to_users_table', 1),
(17, '2025_08_04_094631_create_peminjaman_lab_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_item_id` bigint(20) UNSIGNED NOT NULL,
  `peminjam_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `tanggal_pengembalian` datetime DEFAULT NULL,
  `alasan_pinjam` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `status` enum('menunggu','disetujui','ditolak','dikembalikan','terlambat') COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_izin` enum('penelitian','kerja','sakit') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deskripsi_izin` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `inventory_item_id`, `peminjam_id`, `jumlah`, `tanggal_pinjam`, `tanggal_kembali`, `tanggal_pengembalian`, `alasan_pinjam`, `catatan_admin`, `status`, `jenis_izin`, `deskripsi_izin`, `created_at`, `updated_at`) VALUES
(1, 3, 16, 1, '2025-10-02 13:04:55', '2025-10-03 00:00:00', '2025-10-02 13:06:49', 'Ingin tahu apa itu EEG?', 'Sangan tepat waktu terimakasih sudah pinjam di LPSKE', 'dikembalikan', NULL, NULL, '2025-10-02 06:04:55', '2025-10-02 06:06:49'),
(2, 4, 18, 1, '2025-10-03 10:32:21', '2025-10-10 00:00:00', '2025-10-03 10:33:08', 'nyoba', 'nyoba kembalikan\n', 'dikembalikan', NULL, NULL, '2025-10-03 03:32:21', '2025-10-03 03:33:08'),
(3, 1, 16, 1, '2026-02-05 09:05:36', '2026-02-06 00:00:00', '2026-02-05 09:08:16', 'untuk tugas', 'kondisi baik', 'dikembalikan', NULL, NULL, '2026-02-05 02:05:36', '2026-02-05 02:08:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman_lab`
--

CREATE TABLE `peminjaman_lab` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `lab` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `tujuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'menunggu',
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `disetujui_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `disetujui_pada` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `peminjaman_lab`
--

INSERT INTO `peminjaman_lab` (`id`, `user_id`, `lab`, `tanggal_pinjam`, `tanggal_selesai`, `tujuan`, `status`, `catatan_admin`, `disetujui_oleh`, `disetujui_pada`, `created_at`, `updated_at`) VALUES
(1, 14, 'Lab Multimedia', '2025-10-07 14:28:07', '2025-10-17 14:25:12', 'sasasas', 'menunggu', NULL, NULL, NULL, '2025-10-07 07:25:15', '2025-10-07 07:25:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perizinans`
--

CREATE TABLE `perizinans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_izin` enum('penelitian','kerja','sakit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `perizinans`
--

INSERT INTO `perizinans` (`id`, `user_id`, `jenis_izin`, `tanggal_mulai`, `tanggal_selesai`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 18, 'sakit', '2025-10-04', '2025-10-10', NULL, '2025-10-03 03:33:47', '2025-10-03 03:33:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `presensis`
--

CREATE TABLE `presensis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `asisten_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `presensis`
--

INSERT INTO `presensis` (`id`, `activity`, `description`, `date`, `time`, `asisten_id`, `created_at`, `updated_at`) VALUES
(1, 'Jumatan', 'ya', '2025-10-03', '10:28:32', 17, '2025-10-03 03:28:32', '2025-10-03 03:28:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `prestasi_kegiatan`
--

CREATE TABLE `prestasi_kegiatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_video` tinyint(1) NOT NULL DEFAULT '0',
  `jenis` enum('prestasi','kegiatan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `featured_at` timestamp NULL DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `prestasi_kegiatan`
--

INSERT INTO `prestasi_kegiatan` (`id`, `judul`, `deskripsi`, `gambar`, `video_url`, `is_video`, `jenis`, `tanggal`, `is_featured`, `is_active`, `featured_at`, `sort_order`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Praktikum Meja Antropometri', 'Mempelajari cara kerja meja Antropometri', 'prestasi-kegiatan/IMG-1804.jpg', NULL, 0, 'kegiatan', '2025-08-04', 1, 1, '2025-08-04 02:37:36', 1, '2025-08-04 02:37:36', '2025-08-04 02:37:36', NULL),
(2, 'Praktikum Cara Duduk yang Ergonomis ', 'Duduk dengan cara yang ergonomis sangat direkomendasikan agar postur tubuh tetap baik dan sehat. Diukur menggunakan meja antropometri.', 'prestasi-kegiatan/IMG-1806.jpg', NULL, 0, 'kegiatan', '2025-08-04', 0, 1, '2025-08-04 02:37:36', 0, '2025-08-04 02:37:36', '2025-08-04 02:37:36', NULL),
(3, 'Membuat Produk Bergerak dari Kardus', NULL, 'prestasi-kegiatan/c39ccc0e-b655-4b64-b1ff-67153dcc0ca1.jpg', NULL, 0, 'prestasi', '2025-08-04', 0, 1, '2025-08-04 02:37:36', 0, '2025-08-04 02:37:36', '2025-08-04 02:37:36', NULL),
(4, 'Membuat Produk Bergerak dari Lego', NULL, 'prestasi-kegiatan/8dad777d-b13f-4a7b-87c9-91d9a08142ca.jpg', NULL, 0, 'prestasi', '2025-08-04', 0, 1, '2025-08-04 02:37:36', 0, '2025-08-04 02:37:36', '2025-08-04 02:37:36', NULL),
(5, 'Hasil Praktikum', 'Membuat produk bergerak dari Lego', 'prestasi-kegiatan/bbb6cf65-eac9-4753-8249-2dbd402d0735.jpg', NULL, 0, 'kegiatan', '2025-08-04', 0, 1, '2025-08-04 02:37:36', 0, '2025-08-04 02:37:36', '2025-08-04 02:37:36', NULL),
(6, 'Pelatihan Neuroteknologi dengan Perangkat EEG oleh Anak Magang LPSKE di SMK 6 Surakarta', 'Pada tanggal 13 Februari 2026, LPSKE menyelenggarakan Pelatihan Neurotechnology dengan Perangkat EEG yang dipandu oleh mahasiswa magang di SMK Negeri 6 Surakarta. Kegiatan ini bertujuan memperkenalkan teknologi neuroteknologi modern, khususnya pemanfaatan perangkat EEG (Electroencephalography) untuk memantau aktivitas otak secara real-time.\n\nMelalui pelatihan ini, peserta mendapatkan pemahaman dasar mengenai cara kerja EEG, mulai dari akuisisi sinyal otak menggunakan perangkat Muse 2, proses preprocessing untuk mengurangi noise, hingga analisis frekuensi gelombang otak (Delta, Theta, Alpha, Beta, dan Gamma) yang berkaitan dengan kondisi mental seperti fokus, relaksasi, maupun kelelahan.\n\nMateri pelatihan disampaikan dengan dukungan presentasi interaktif dari Google Slide, sehingga peserta dapat melihat secara langsung bagaimana integrasi antara hardware, data science, dan aplikasi web dapat menghadirkan sistem monitoring EEG yang relevan dengan kebutuhan pendidikan dan industri.\n\nKegiatan ini tidak hanya memperkaya pengetahuan siswa mengenai teknologi terkini, tetapi juga menumbuhkan minat terhadap bidang neuroteknologi yang masih jarang dikembangkan di Indonesia. Dengan adanya pelatihan ini, diharapkan lahir generasi muda yang mampu menguasai integrasi kompleks antara neuroscience, perangkat keras, dan pengembangan aplikasi berbasis web.', 'prestasi-kegiatan/01KKGJB430PTGK13YWDYSQGEMF.jpg', NULL, 0, 'kegiatan', '2026-02-13', 0, 1, NULL, 0, '2026-03-12 08:21:47', '2026-03-12 08:24:21', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('369ToftVj0CMV75jKW458MFpZBIYdPJavf4tqnu5', NULL, '104.22.60.138', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibUFQRTZlZUNhcTFPalFuWjE5VnJFSE5sSThOd1l5YWd6eHhlcTN5cSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vbHBza2UudGktdW5zLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784131716),
('6BkGUDfow7gaGaI3y8oPOk24k1GxCdbsu0JBc0aR', NULL, '104.23.229.138', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0lGajRGSzVwWFRkdGpSYkhmd0plM215eWNRek1zbGdveGJ2V0VqVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9scHNrZS50aS11bnMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784176737),
('cAn2MN9z2toJ9bW8BRy0URdMCS3gY2gsa7lNV2Gr', NULL, '104.22.105.67', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWFkZGdBY2JTakFPZXY3andMMEtVaUpCbGdxeVR1azh1Vjdvb2hDYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vbHBza2UudGktdW5zLmNvbS9rb2xhYm9yYXRvciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784170064),
('IHKyCQtpZpSXC67WMA1nKfyFNMj3QhZ5M9DFl5OD', NULL, '104.22.93.76', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibXVEVGN2dGtwcWx2ZTJNenIwQjNCbE5OcXY5R3dNWlpCOEFFV1Q2NCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9scHNrZS50aS11bnMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784138373),
('J7qbvb9Ji2KmCkTkXO5XuFgM52GrgqZ7CRc3vIlA', NULL, '104.23.170.141', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicWdWNW9JR2lOaXJTcHM2MWt6SE9MVEZOeERoUW1QbG5NdDEydUx5MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vbHBza2UudGktdW5zLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784137511),
('ngwAjfVyhWMGpMbGM6o1xYiQYNVGErw8FGjONYoR', NULL, '141.101.68.126', 'Hello from Palo Alto Networks, find out more about our scans in https://docs-cortex.paloaltonetworks.com/r/1/Cortex-Xpanse/Scanning-activity', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRmh6Q0NZaUc1amhnak9IMlZINXNmTUIyOXg1NjZxV3BZeU5LS0xYYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9scHNrZS50aS11bnMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784157363),
('o0Dn1MN6b8Ns3R44Q5wPCZmb0FTkxMgpKvWsDwXU', NULL, '104.22.20.216', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWtzdGpmNU9JU3dnUnhPcnRCdWh1aGkxWmRDUlh5MDl4UnJZTHhQMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9scHNrZS50aS11bnMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784151718),
('OGVzb3nIXQX6w3nWYufngdiuXo1pQJTyLnfwW2tK', NULL, '172.71.95.89', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaEg2OXI4QjQ3SXpUN0RURlozVXVEbnBVM3ZIa1c5U1dLbjZhUjh6TCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vbHBza2UudGktdW5zLmNvbS8/cGhwaW5mbz0xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784137515),
('PGgwRxvALc0EpNHfjLmckSqVziLVu5Cth0Sd7cqz', NULL, '104.22.82.138', 'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.3; Trident/4.0)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSGNmQXZVV2xIOW4wbzlHMkdDOUY1QXdDNDZpRmRvM0FIOVhNMndmTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9scHNrZS50aS11bnMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784178449),
('rt3CgsEL3QVepzXEcw10KJfctToB86GgnjTmDWS2', NULL, '162.158.243.141', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTEhOMjdiSGVjaXVnOWhhclc0QU9NODJkQWdGRXJOUUFXVlZTa0tyTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vbHBza2UudGktdW5zLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784185625),
('ubB7LI04XWWeKQfq9QOZO0F8Oa9eaeTb8drainEa', NULL, '104.22.72.63', 'Mozilla/5.0 (compatible; DotBot/1.2; +https://opensiteexplorer.org/dotbot; help@moz.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUXdhVVkxdGRLT2h0RHBSR3lzdTNad1hWSk5mTDExcXR0N2poTDJtWCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9scHNrZS50aS11bnMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784196595),
('xbBqcml5Af7eYy9HrGNs3ex0cMIQX1KOzL1GKnsp', NULL, '104.23.170.179', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieU9ORmZHZ014QVBKaEZqc3Z3NUlxRUluWlF0WEJZRUFFaGhnWUpyOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vbHBza2UudGktdW5zLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784137504),
('xoU3u8IWWMEikhE7cpq3Lh6Y2eqEKinFBb5XUFI9', NULL, '172.68.245.32', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid2ZWZTF5QnZTWmgyY1hlTnFDMXVQUkRkb1kyeThnUUw4b0gwSlRLUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9scHNrZS50aS11bnMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784165355),
('ZeLWCX0Px4IxT8WD1aQvzw99Yd6jdfqaijIXaEFA', NULL, '104.22.105.67', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 (compatible; meta-webindexer/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler))', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicGJMZGt2WU1ZTjJPZDZ6dGUxa1FGclVjNHBRcktZOE9TaGZ1WTkxTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vbHBza2UudGktdW5zLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784189654),
('ZN4GndlTk5E2EEIanTbzJrbJ5dzmYfJz7xfgyEPY', NULL, '172.68.211.9', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVmVQc1hHdDJzNmUyeUR4Yk1PVXdhWTN0eVY3RnZjUTc1bWFPdWZWdyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjM6Imh0dHA6Ly9scHNrZS50aS11bnMuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1784186559);

-- --------------------------------------------------------

--
-- Struktur dari tabel `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('kepala','dosen','asisten') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nim` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `study_program` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expertise` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `angkatan` int(11) DEFAULT NULL COMMENT 'For asisten only',
  `bio` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `teams`
--

INSERT INTO `teams` (`id`, `type`, `name`, `nip`, `nim`, `position`, `study_program`, `expertise`, `email`, `phone`, `photo`, `angkatan`, `bio`, `sort_order`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'kepala', 'Dr. Ir. Rahmaniyah Dwi Astuti S.T.,M.T.', '0022017603', NULL, NULL, NULL, 'Fakultas Teknik / S-1 Teknik Industri', NULL, NULL, 'teams/1754274413-68901a6ded4aa.jpg', NULL, NULL, 0, 1, '2025-08-04 02:26:54', '2025-12-08 12:29:58', NULL),
(2, 'dosen', 'Ir. Irwan Iftadi S.T., M.ENG.', '0004047007', NULL, NULL, NULL, 'Fakultas Teknik / S-1 Teknik Industri', NULL, NULL, 'teams/1754274460-68901a9c49ff4.png', NULL, NULL, 0, 1, '2025-08-04 02:27:40', '2025-12-08 12:31:01', NULL),
(3, 'dosen', 'Prof. Dr. Ir. Bambang Suhardi S.T.,M.T.', '0020057405', NULL, NULL, NULL, 'Fakultas Teknik / S-1 Teknik Industri', NULL, NULL, 'teams/1754274565-68901b051e3c0.png', NULL, NULL, 0, 1, '2025-08-04 02:29:25', '2025-12-08 12:31:33', NULL),
(4, 'asisten', 'M. Junus Atthariq', NULL, 'I0318064', NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL, 0, 1, '2025-10-01 12:34:09', NULL, NULL),
(5, 'asisten', 'Afra Galda N', NULL, 'I0318003', NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL, 0, 1, '2025-10-01 12:34:09', NULL, NULL),
(6, 'asisten', 'Anisa Nur Maya', NULL, 'I0318014', NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL, 0, 1, '2025-10-01 12:34:09', NULL, NULL),
(7, 'asisten', 'Annisa Syahliantina', NULL, 'I0318015', NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL, 0, 1, '2025-10-01 12:34:09', NULL, NULL),
(8, 'asisten', 'Annafis Manaruzzaki', NULL, 'I0318017', NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL, 0, 1, '2025-10-01 12:34:09', NULL, NULL),
(9, 'asisten', 'Eka Nasrul H', NULL, 'I0318028', NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL, 0, 1, '2025-10-01 12:34:09', NULL, NULL),
(10, 'asisten', 'Niken Utami', NULL, 'I0318072', NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL, 0, 1, '2025-10-01 12:34:09', NULL, NULL),
(11, 'asisten', 'Rahma Sabilah N', NULL, 'I0318075', NULL, NULL, NULL, NULL, NULL, NULL, 2018, NULL, 0, 1, '2025-10-01 12:34:09', NULL, NULL),
(12, 'asisten', 'Yunia Nur Afrasaniy', NULL, 'I0319111', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(13, 'asisten', 'Miftah Al Mukarohmah', NULL, 'I0319058', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(14, 'asisten', 'Desika Anggi Fitriana', NULL, 'I0319022', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(15, 'asisten', 'Ainun Rahmansyah G.', NULL, 'I0319008', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(16, 'asisten', 'Muhammad Raihan', NULL, 'I0319069', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(17, 'asisten', 'Zati Hulwani Mindandi', NULL, 'I0319113', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(18, 'asisten', 'Zufar Ariq Marza M', NULL, 'I0319114', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(19, 'asisten', 'Farhana Mazaya P.', NULL, 'I0319033', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(20, 'asisten', 'Rifa’atul Jazilah', NULL, 'I0319090', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(21, 'asisten', 'Muhammad Fawaid Nur Azizi', NULL, 'I0319062', NULL, NULL, NULL, NULL, NULL, NULL, 2019, NULL, 0, 1, '2025-10-01 12:40:08', NULL, NULL),
(22, 'asisten', 'Adrian Kwanadi Setiono', NULL, 'I0320002', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(23, 'asisten', 'Afiq Ramadhan', NULL, 'I0320003', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(24, 'asisten', 'Ardhaneshwara Gea', NULL, 'I0320012', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(25, 'asisten', 'Athallah Naufal Kur’anityo', NULL, 'I0320013', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(26, 'asisten', 'Fahruddin Ari Wicaksono', NULL, 'I0320039', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(27, 'asisten', 'Mira Yunisa Amalia', NULL, 'I0320057', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(28, 'asisten', 'Muhammad Jefri Saputra', NULL, 'I0320066', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(29, 'asisten', 'Oktavianus Auwdri', NULL, 'I0320077', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(30, 'asisten', 'Stefany Caesara Permatasari', NULL, 'I0320096', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(31, 'asisten', 'Vincentia Putri Kharisma', NULL, 'I0320107', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(32, 'asisten', 'Yukuri Hanjani Putri', NULL, 'I0320114', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(33, 'asisten', 'Alfina Diva Ramadhanty', NULL, 'I0320120', NULL, NULL, NULL, NULL, NULL, NULL, 2020, NULL, 0, 1, '2025-10-01 12:40:40', NULL, NULL),
(34, 'asisten', 'Farrelleo Adryanna B.', NULL, 'I0321043', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(35, 'asisten', 'Rakhel Syakira N.', NULL, 'I0321086', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(36, 'asisten', 'Mikail Naufal Kemal', NULL, 'I0321067', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(37, 'asisten', 'Jihan Syafira Zahra', NULL, 'I0321054', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(38, 'asisten', 'Btara Aryanda', NULL, 'I0321023', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(39, 'asisten', 'Auldy Setia M.', NULL, 'I0321018', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(40, 'asisten', 'Caesar Rifqi Ardana', NULL, 'I0321025', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(41, 'asisten', 'Dicky Pamungkas', NULL, 'I0321035', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(42, 'asisten', 'Talitha Bertha I.', NULL, 'I0321101', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(43, 'asisten', 'Aida Nuraini', NULL, 'I0321004', NULL, NULL, NULL, NULL, NULL, NULL, 2021, NULL, 0, 1, '2025-10-01 12:42:12', NULL, NULL),
(44, 'asisten', 'Alrantisa Amiena', NULL, 'I0322012', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(45, 'asisten', 'Katon Adiluhung', NULL, 'I0322063', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(46, 'asisten', 'Steven Alexander Hidayat', NULL, 'I0322119', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(47, 'asisten', 'Adriani Hasna K.', NULL, 'I0322004', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(48, 'asisten', 'Ghaisan Nabiel A.', NULL, 'I0322050', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(49, 'asisten', 'Adz-dzikra Q. A.', NULL, 'I0322005', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(50, 'asisten', 'Dimas Arya Santosa', NULL, 'I0322038', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(51, 'asisten', 'Alif Kus Setyanto', NULL, 'I0322011', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(52, 'asisten', 'Rizky Indra Maulana', NULL, 'I0322112', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(53, 'asisten', 'Audry Angelina Lubis', NULL, 'I0322018', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(54, 'asisten', 'Kavita Lailia Ina Z.', NULL, 'I0322064', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(55, 'asisten', 'Novita Arilfa', NULL, 'I0322095', NULL, NULL, NULL, NULL, NULL, NULL, 2022, NULL, 0, 1, '2025-10-01 12:42:36', NULL, NULL),
(56, 'asisten', 'Citta Gurnita Prasista', NULL, 'I0323024', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(57, 'asisten', 'Desinta Fitarini', NULL, 'I0323028', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(58, 'asisten', 'El Qonita Nur Khayyina', NULL, 'I0323035', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(59, 'asisten', 'Fatimah Wina Kurniasari', NULL, 'I0323040', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(60, 'asisten', 'Haris Ainur Rofiq', NULL, 'I0323051', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(61, 'asisten', 'Immanuel Aryo Prasojo', NULL, 'I0323053', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(62, 'asisten', 'Kezia Vita Christiana', NULL, 'I0323059', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(63, 'asisten', 'Muhammad Dzaki Suryana', NULL, 'I0323080', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(64, 'asisten', 'Qonita Annisa\' Aprillia', NULL, 'I0323101', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(65, 'asisten', 'Rafanda Akhta Prapmadi', NULL, 'I0323102', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(66, 'asisten', 'Zarith Zahwan', NULL, 'I0323121', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(67, 'asisten', 'Shegy Yuniar Amalia', NULL, 'I0323129', NULL, NULL, NULL, NULL, NULL, NULL, 2023, NULL, 0, 1, '2025-10-01 12:43:05', NULL, NULL),
(68, 'dosen', 'rayhan', '0939283', NULL, NULL, NULL, 'TINGIL', 'HANTONK@gmail.com', '0230840283', 'teams/1759379115-68ddfeab76f19.jpeg', NULL, NULL, 0, 1, '2025-10-02 04:25:15', '2025-10-02 04:27:22', '2025-10-02 04:27:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `encrypted_password_storage` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `encrypted_password_storage`, `remember_token`, `created_at`, `updated_at`) VALUES
(14, 'Administrator', 'admin@lpske.com', 'admin', '2025-08-03 13:37:15', '$2y$12$YlDfUKcFUv92jY/6x1Q2bubMWefedQYAzBnv6h.MwiFcn3KM.DK3e', 'eyJpdiI6IlhUN2VXSHREVzhESENsdWp3K05CTGc9PSIsInZhbHVlIjoibUdabmlEWjBCUzNJN1Z4M0ZrOFdhUT09IiwibWFjIjoiY2EzN2Y4YWQxN2MzOGQ3YWJlMDRhZjcwMTY5MzgwZDcwMDMwMTg0ZDc0ZDQ4MjJjODllMTM4MzQ2YjMzMzlmNyIsInRhZyI6IiJ9', NULL, '2025-08-03 13:37:15', '2025-08-03 13:37:15'),
(15, 'Asisten LPSKE', 'asisten@lpske.com', 'asisten', '2025-08-03 13:37:15', '$2y$12$0N04tsQRan/34ZSjKg1yv.LfCFIBehiCMlyPmzEUIXz3qtxj29wUS', 'eyJpdiI6Ik0wbVFnUXdENzIvTjBsWnl3VGZyeWc9PSIsInZhbHVlIjoiVTlZTW1tOWl3dEpIc05qRExveHJPY0pQeHFwc3hvNmZ0Q1c1S2JsL3ZmRT0iLCJtYWMiOiI4MDFmMGI0M2E3Y2U4YzI1YTkxYTBkYzhkZDY0Mjc5MzVhNGZhZWM2OTAyNWI2NTE5NmUxMDRkZTkxNTNhMmQxIiwidGFnIjoiIn0=', NULL, '2025-08-03 13:37:15', '2025-08-03 13:37:15'),
(16, 'Anggota LPSKE', 'anggota@lpske.com', 'anggota', '2025-10-01 14:07:38', '$2y$12$T9NWad30DjhRNTn8KgqAN.UhuLOKFu8WyvlzgWN7LU2H0A2mTNG1u', 'eyJpdiI6Ijk0eFdHTVRkT3NnZG5RTVJaRGtqbEE9PSIsInZhbHVlIjoiTlR5QTZGY0JraHFiaktrRmtiTVE2QStDSlFNNk9GZm9uQjVuZFpWNmxuND0iLCJtYWMiOiI1ZTNmMmNhMTE2YjFkNGM2MzE4ODMyYzFkZWVjZDBlYWUwNDQ3NjMwNjFmZWVkYjFjOWUwNGNiNjE4NjYyNTQ1IiwidGFnIjoiIn0=', NULL, '2025-08-03 13:37:15', '2025-10-01 14:07:38'),
(17, 'Haris', 'Haris@gmail.com', 'asisten', '2025-10-03 03:27:31', '$2y$12$TRgZZXT09MjrMFdLULRYZOiEQy5ulSYQCrNoCUssXQ8oDc6FUZLPK', NULL, NULL, '2025-10-03 03:27:31', '2025-10-03 03:27:31'),
(18, 'Haris', 'Haris2@gmail.com', 'anggota', '2025-10-03 03:31:10', '$2y$12$0HnnHN7f00tMR/t4TK0yc.UbcnDhkYRh/.BSNYNhEUE0U865RTGCe', 'eyJpdiI6InFIZzFGc3p4dDBhN28ya2Eycm8vd1E9PSIsInZhbHVlIjoidUxxK1UyNStnWGYvSEpzY3MyR1czdz09IiwibWFjIjoiZTNiNDg2MTBlOTAxYzhjN2MzNzY3ZGIyYTIzNGU2N2VlM2FiYzZkN2E5ZWY5ZmI3ZmI1MWE1M2RkMGRlNWRiNiIsInRhZyI6IiJ9', NULL, '2025-10-03 03:30:11', '2025-10-03 03:31:10'),
(19, 'katon', 'katon@gmail.com', 'anggota', '2025-10-06 08:07:27', '$2y$12$tvOf4N2o9AVINN25m4y.uu/TFc4V8DOEVlZYGlwJX1kyx1oIhx5aC', 'eyJpdiI6IlU0dWlXUmtMWXNCQkV5eXZkL2ZaaFE9PSIsInZhbHVlIjoidEEzQXZmNVU2d0dKeU5KMjVmc2xpZz09IiwibWFjIjoiZTE3MDVlMTA3NTVlMTFjNWJjMjRhZWM2OGYyOTUxMTA4OTc4YjA2MmE2OTIzNzIzZThhNmU1MDA0YzM0ZDcxNiIsInRhZyI6IiJ9', NULL, '2025-10-06 08:06:45', '2025-10-06 08:07:27');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alumni_story`
--
ALTER TABLE `alumni_story`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_story_user_id_foreign` (`user_id`);

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
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_items_peminjam_id_foreign` (`peminjam_id`);

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
-- Indeks untuk tabel `logbooks`
--
ALTER TABLE `logbooks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `logbooks_asisten_id_foreign` (`asisten_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_inventory_item_id_foreign` (`inventory_item_id`),
  ADD KEY `peminjaman_peminjam_id_foreign` (`peminjam_id`);

--
-- Indeks untuk tabel `peminjaman_lab`
--
ALTER TABLE `peminjaman_lab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_lab_user_id_foreign` (`user_id`),
  ADD KEY `peminjaman_lab_disetujui_oleh_foreign` (`disetujui_oleh`);

--
-- Indeks untuk tabel `perizinans`
--
ALTER TABLE `perizinans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `perizinans_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `presensis`
--
ALTER TABLE `presensis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `presensis_asisten_id_foreign` (`asisten_id`);

--
-- Indeks untuk tabel `prestasi_kegiatan`
--
ALTER TABLE `prestasi_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indeks untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT untuk tabel `alumni_story`
--
ALTER TABLE `alumni_story`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `logbooks`
--
ALTER TABLE `logbooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peminjaman_lab`
--
ALTER TABLE `peminjaman_lab`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `perizinans`
--
ALTER TABLE `perizinans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `presensis`
--
ALTER TABLE `presensis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `prestasi_kegiatan`
--
ALTER TABLE `prestasi_kegiatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `alumni_story`
--
ALTER TABLE `alumni_story`
  ADD CONSTRAINT `alumni_story_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD CONSTRAINT `inventory_items_peminjam_id_foreign` FOREIGN KEY (`peminjam_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `logbooks`
--
ALTER TABLE `logbooks`
  ADD CONSTRAINT `logbooks_asisten_id_foreign` FOREIGN KEY (`asisten_id`) REFERENCES `teams` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_peminjam_id_foreign` FOREIGN KEY (`peminjam_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman_lab`
--
ALTER TABLE `peminjaman_lab`
  ADD CONSTRAINT `peminjaman_lab_disetujui_oleh_foreign` FOREIGN KEY (`disetujui_oleh`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `peminjaman_lab_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `perizinans`
--
ALTER TABLE `perizinans`
  ADD CONSTRAINT `perizinans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `presensis`
--
ALTER TABLE `presensis`
  ADD CONSTRAINT `presensis_asisten_id_foreign` FOREIGN KEY (`asisten_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
