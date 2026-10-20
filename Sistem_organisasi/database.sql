CREATE DATABASE IF NOT EXISTS `db_kepanitiaan`;
USE `db_kepanitiaan`;

-- Tabel Divisi
CREATE TABLE IF NOT EXISTS `divisi` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_divisi` VARCHAR(100) NOT NULL,
  `deskripsi` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Users / Anggota
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama` VARCHAR(100) NOT NULL,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('Ketua', 'Sekretaris', 'Bendahara', 'Koordinator', 'Anggota') NOT NULL,
  `divisi_id` INT DEFAULT NULL,
  `email` VARCHAR(100),
  `no_hp` VARCHAR(20),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`divisi_id`) REFERENCES `divisi`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Acara / Kegiatan
CREATE TABLE IF NOT EXISTS `acara` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nama_acara` VARCHAR(150) NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `lokasi` VARCHAR(150) NOT NULL,
  `status` ENUM('Direncanakan', 'Berjalan', 'Selesai') DEFAULT 'Direncanakan',
  `deskripsi` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Tugas
CREATE TABLE IF NOT EXISTS `tugas` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `acara_id` INT NOT NULL,
  `divisi_id` INT NOT NULL,
  `assigned_to` INT DEFAULT NULL,
  `nama_tugas` VARCHAR(150) NOT NULL,
  `deskripsi` TEXT,
  `deadline` DATE NOT NULL,
  `prioritas` ENUM('Rendah', 'Sedang', 'Tinggi') DEFAULT 'Sedang',
  `status` ENUM('Belum', 'Proses', 'Selesai') DEFAULT 'Belum',
  FOREIGN KEY (`acara_id`) REFERENCES `acara`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`divisi_id`) REFERENCES `divisi`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`assigned_to`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel Keuangan
CREATE TABLE IF NOT EXISTS `keuangan` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `acara_id` INT NOT NULL,
  `jenis` ENUM('Pemasukan', 'Pengeluaran') NOT NULL,
  `kategori` VARCHAR(100) NOT NULL,
  `jumlah` BIGINT NOT NULL,
  `keterangan` TEXT,
  `tanggal` DATE NOT NULL,
  `created_by` INT DEFAULT NULL,
  FOREIGN KEY (`acara_id`) REFERENCES `acara`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal divisi
INSERT INTO `divisi` (`id`, `nama_divisi`, `deskripsi`) VALUES
(1, 'BPH (Badan Pengurus Harian)', 'Pengarah utama kegiatan'),
(2, 'Divisi Acara', 'Penyusun konsep dan susunan acara'),
(3, 'Divisi Humas & Pubdok', 'Pengelola media, dokumentasi, dan pendaftaran'),
(4, 'Divisi Logistik & Perlengkapan', 'Pengelola aset dan kebutuhan tempat'),
(5, 'Divisi Konsumsi', 'Pengurus konsumsi peserta dan panitia');

-- Data awal user (Password default: admin123)
-- Hash password dibuat menggunakan password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `divisi_id`, `email`, `no_hp`) VALUES
(1, 'Ahmad Fikri (Ketua)', 'ketua', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.X0d2907uS', 'Ketua', 1, 'ketua@kampus.ac.id', '081234567890'),
(2, 'Siti Nurhaliza (Sekretaris)', 'sekretaris', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.X0d2907uS', 'Sekretaris', 1, 'sekretaris@kampus.ac.id', '081234567891'),
(3, 'Budi Santoso (Bendahara)', 'bendahara', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.X0d2907uS', 'Bendahara', 1, 'bendahara@kampus.ac.id', '081234567892'),
(4, 'Dewi Lestari (Koor Acara)', 'koor_acara', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.X0d2907uS', 'Koordinator', 2, 'dewi@kampus.ac.id', '081234567893'),
(5, 'Rizky Pratama (Anggota)', 'anggota1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.X0d2907uS', 'Anggota', 2, 'rizky@kampus.ac.id', '081234567894');

-- Data contoh Acara
INSERT INTO `acara` (`id`, `nama_acara`, `tanggal_mulai`, `tanggal_selesai`, `lokasi`, `status`, `deskripsi`) VALUES
(1, 'Seminar Nasional Teknologi 2026', '2026-04-15', '2026-04-15', 'Auditorium Utama Kampus', 'Berjalan', 'Seminar tahunan pembahasan perkembangan AI dan Cyber Security.');

-- Data contoh Keuangan
INSERT INTO `keuangan` (`acara_id`, `jenis`, `kategori`, `jumlah`, `keterangan`, `tanggal`, `created_by`) VALUES
(1, 'Pemasukan', 'Dana DIPA Kampus', 10000000, 'Pencairan Tahap 1 dari Kemahasiswaan', '2026-03-01', 3),
(1, 'Pemasukan', 'Sponsor Utama', 5000000, 'Sponsorship dari PT Tech Indonesia', '2026-03-05', 3),
(1, 'Pengeluaran', 'Sewa Venue & Sound', 3500000, 'DP Gedung & Perlengkapan Audio', '2026-03-10', 3),
(1, 'Pengeluaran', 'Konsumsi Pembicara', 1200000, 'Snack dan Makan Siang VIP', '2026-03-12', 3);

-- Data contoh Tugas
INSERT INTO `tugas` (`acara_id`, `divisi_id`, `assigned_to`, `nama_tugas`, `deskripsi`, `deadline`, `prioritas`, `status`) VALUES
(1, 2, 4, 'Menyusun Rundown Acara', 'Draft susunan acara dari pembukaan hingga penutupan', '2026-04-01', 'Tinggi', 'Selesai'),
(1, 2, 5, 'Menghubungi Moderasi & Pemateri', 'Konfirmasi kedatangan dan kebutuhan materi', '2026-04-05', 'Tinggi', 'Proses'),
(1, 3, NULL, 'Membuat Desain Poster & Feed IG', 'Ukuran 1:1 dan Story Instagram', '2026-04-02', 'Sedang', 'Belum');