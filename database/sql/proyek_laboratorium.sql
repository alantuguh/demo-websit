-- =========================================================================
-- Tabel: proyek_laboratorium
-- Modul: Proyek Laboratorium (Wibawa, Jarpak, Semesta, DIKTI, Kerja Sama UNS)
--
-- CARA PAKAI (opsional, jika TIDAK menjalankan `php artisan migrate`):
--   mysql -u root lpske < database/sql/proyek_laboratorium.sql
-- atau import manual lewat phpMyAdmin pada database `lpske`.
--
-- Catatan: kalau kamu menjalankan `php artisan migrate`, JANGAN jalankan
-- file ini juga (tabel akan otomatis dibuat oleh migration).
-- =========================================================================

CREATE TABLE IF NOT EXISTS `proyek_laboratorium` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul_proyek` varchar(255) NOT NULL,
  `kategori` enum('wibawa','jarpak','semesta','dikti','kerjasama_uns') NOT NULL,
  `deskripsi` text,
  `tahun` year NOT NULL,
  `mitra` varchar(255) DEFAULT NULL,
  `status` enum('berjalan','selesai') NOT NULL DEFAULT 'berjalan',
  `gambar` varchar(255) DEFAULT NULL,
  `link_terkait` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tandai migration ini "sudah dijalankan" supaya `php artisan migrate` tidak
-- mencoba membuat ulang tabel yang sama (HANYA perlu jika kamu memakai cara
-- import SQL manual di atas, bukan `php artisan migrate`).
-- Sesuaikan nilai `batch` dengan batch migration terakhir di tabel `migrations`.
-- INSERT INTO `migrations` (`migration`, `batch`)
-- VALUES ('2026_07_21_000000_create_proyek_laboratorium_table', 1);
