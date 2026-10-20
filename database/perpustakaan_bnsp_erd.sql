-- ====================================================================
-- SKEMA DATABASE PERPUSTAKAAN DIGITAL (STANDAR BNSP FR.IA.02 HALAMAN 2)
-- Skema Sertifikasi : Pemrogram Junior (Junior Coder)
-- Unit Kompetensi   : J.620100.004.02 (Menggunakan Struktur Data)
--                     J.620100.009.01 (Menggunakan Spesifikasi Program)
-- ====================================================================

CREATE DATABASE IF NOT EXISTS `perpustakaan_digital` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `perpustakaan_digital`;

-- --------------------------------------------------------
-- 1. Tabel: user
-- --------------------------------------------------------
DROP TABLE IF EXISTS `ulasanbuku`;
DROP TABLE IF EXISTS `koleksipribadi`;
DROP TABLE IF EXISTS `peminjaman`;
DROP TABLE IF EXISTS `kategoribuku_relasi`;
DROP TABLE IF EXISTS `kategoribuku`;
DROP TABLE IF EXISTS `buku`;
DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `NamaLengkap` varchar(255) NOT NULL,
  `Alamat` text DEFAULT NULL,
  `Role` enum('administrator','petugas','peminjam') NOT NULL DEFAULT 'peminjam',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `user_email_unique` (`Email`),
  UNIQUE KEY `user_username_unique` (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 2. Tabel: buku
-- --------------------------------------------------------
CREATE TABLE `buku` (
  `BukuID` int(11) NOT NULL AUTO_INCREMENT,
  `Judul` varchar(255) NOT NULL,
  `Penulis` varchar(255) NOT NULL,
  `Penerbit` varchar(255) NOT NULL,
  `TahunTerbit` int(11) NOT NULL,
  PRIMARY KEY (`BukuID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 3. Tabel: kategoribuku
-- --------------------------------------------------------
CREATE TABLE `kategoribuku` (
  `KategoriID` int(11) NOT NULL AUTO_INCREMENT,
  `NamaKategori` varchar(255) NOT NULL,
  PRIMARY KEY (`KategoriID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 4. Tabel: kategoribuku_relasi
-- --------------------------------------------------------
CREATE TABLE `kategoribuku_relasi` (
  `KategoriBukuID` int(11) NOT NULL AUTO_INCREMENT,
  `BukuID` int(11) NOT NULL,
  `KategoriID` int(11) NOT NULL,
  PRIMARY KEY (`KategoriBukuID`),
  KEY `fk_kategorirelasi_buku` (`BukuID`),
  KEY `fk_kategorirelasi_kategori` (`KategoriID`),
  CONSTRAINT `fk_kategorirelasi_buku` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`) ON DELETE CASCADE,
  CONSTRAINT `fk_kategorirelasi_kategori` FOREIGN KEY (`KategoriID`) REFERENCES `kategoribuku` (`KategoriID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 5. Tabel: koleksipribadi
-- --------------------------------------------------------
CREATE TABLE `koleksipribadi` (
  `KoleksiID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  PRIMARY KEY (`KoleksiID`),
  KEY `fk_koleksi_user` (`UserID`),
  KEY `fk_koleksi_buku` (`BukuID`),
  CONSTRAINT `fk_koleksi_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `fk_koleksi_buku` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 6. Tabel: ulasanbuku
-- --------------------------------------------------------
CREATE TABLE `ulasanbuku` (
  `UlasanID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `Ulasan` text NOT NULL,
  `Rating` int(11) NOT NULL,
  PRIMARY KEY (`UlasanID`),
  KEY `fk_ulasan_user` (`UserID`),
  KEY `fk_ulasan_buku` (`BukuID`),
  CONSTRAINT `fk_ulasan_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `fk_ulasan_buku` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 7. Tabel: peminjaman
-- --------------------------------------------------------
CREATE TABLE `peminjaman` (
  `PeminjamanID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `BukuID` int(11) NOT NULL,
  `TanggalPeminjaman` date NOT NULL,
  `TanggalPengembalian` date NOT NULL,
  `StatusPeminjaman` varchar(50) NOT NULL,
  PRIMARY KEY (`PeminjamanID`),
  KEY `fk_peminjaman_user` (`UserID`),
  KEY `fk_peminjaman_buku` (`BukuID`),
  CONSTRAINT `fk_peminjaman_user` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  CONSTRAINT `fk_peminjaman_buku` FOREIGN KEY (`BukuID`) REFERENCES `buku` (`BukuID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ====================================================================
-- DATA AWAL DUMMY / SEED DATA
-- ====================================================================

-- 1. Insert Data User (Admin, Petugas, Peminjam)
-- Password default: admin123, petugas123, anggota123 (bcrypt hash)
INSERT INTO `user` (`UserID`, `Username`, `Password`, `Email`, `NamaLengkap`, `Alamat`, `Role`) VALUES
(1, 'admin', '$2y$12$7gVhglvPbaABiYh9VqBoVfVfSkKdZ/z6638DrXVMEEU=', 'admin@readify.id', 'Administrator Perpustakaan', 'Jl. Merdeka No. 10 Jakarta', 'administrator'),
(2, 'petugas', '$2y$12$7gVhglvPbaABiYh9VqBoVfVfSkKdZ/z6638DrXVMEEU=', 'petugas@readify.id', 'Petugas Sirkulasi', 'Jl. Pemuda No. 5 Jakarta', 'petugas'),
(3, 'anggota', '$2y$12$7gVhglvPbaABiYh9VqBoVfVfSkKdZ/z6638DrXVMEEU=', 'anggota@readify.id', 'Siswa / Peminjam Buku', 'Jl. Melati No. 8 Jakarta', 'peminjam');

-- 2. Insert Data Kategori
INSERT INTO `kategoribuku` (`KategoriID`, `NamaKategori`) VALUES
(1, 'Fiksi'),
(2, 'Teknologi & Komputer'),
(3, 'Sains & Matematika'),
(4, 'Sejarah & Budaya'),
(5, 'Pengembangan Diri');

-- 3. Insert Data Buku
INSERT INTO `buku` (`BukuID`, `Judul`, `Penulis`, `Penerbit`, `TahunTerbit`) VALUES
(1, 'Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005),
(2, 'Clean Code: A Handbook of Agile Software Craftsmanship', 'Robert C. Martin', 'Prentice Hall', 2008),
(3, 'Atomic Habits: Perubahan Kecil yang Memberikan Hasil Luar Biasa', 'James Clear', 'Gramedia Pustaka Utama', 2018),
(4, 'Sapiens: Riwayat Singkat Umat Manusia', 'Yuval Noah Harari', 'KPG', 2014),
(5, 'Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980);

-- 4. Insert Relasi Kategori Buku
INSERT INTO `kategoribuku_relasi` (`KategoriBukuID`, `BukuID`, `KategoriID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 5),
(4, 4, 3),
(5, 4, 4),
(6, 5, 1);

-- 5. Insert Data Peminjaman
INSERT INTO `peminjaman` (`PeminjamanID`, `UserID`, `BukuID`, `TanggalPeminjaman`, `TanggalPengembalian`, `StatusPeminjaman`) VALUES
(1, 3, 1, '2026-10-10', '2026-10-17', 'Dikembalikan'),
(2, 3, 2, '2026-10-15', '2026-10-22', 'Dipinjam'),
(3, 3, 3, '2026-10-18', '2026-10-25', 'Dipinjam');

-- 6. Insert Data Koleksi Pribadi
INSERT INTO `koleksipribadi` (`KoleksiID`, `UserID`, `BukuID`) VALUES
(1, 3, 2),
(2, 3, 3);

-- 7. Insert Data Ulasan Buku
INSERT INTO `ulasanbuku` (`UlasanID`, `UserID`, `BukuID`, `Ulasan`, `Rating`) VALUES
(1, 3, 1, 'Buku yang sangat menginspirasi semangat belajar anak bangsa!', 5),
(2, 3, 2, 'Wajib dibaca bagi seluruh programmer yang ingin kodenya bersih dan rapi.', 5);
