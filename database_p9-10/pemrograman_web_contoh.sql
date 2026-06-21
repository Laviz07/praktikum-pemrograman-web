-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 21 Jun 2026 pada 10.16
-- Versi server: 8.0.30
-- Versi PHP: 8.5.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `pemrograman_web_contoh`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `tahun_terbit` int NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `tahun_terbit`, `harga`, `stok`) VALUES
(1, 'cara menanam sawit', 'bowo pratama', 2023, 67000.00, 30),
(2, 'antara ku dan sawit', 'bowo pratama', 2027, 30000.00, 7),
(3, 'cintaku di solo', 'joko carpenter', 2024, 20000.00, 8),
(7, 'ratapan raja solo', 'joko carpenter', 2020, 100000.00, 6),
(9, 'Kisah MyBiniGweh', 'Gilang Brando', 2023, 40000.00, 9),
(10, 'Kejayaan Rongawi', 'Rusdi Barbercute', 2000, 69000.00, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `pesanan_id` int NOT NULL,
  `buku_id` int NOT NULL,
  `kuantitas` int NOT NULL,
  `harga_per_satuan` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`pesanan_id`, `buku_id`, `kuantitas`, `harga_per_satuan`) VALUES
(13, 1, 1, 67000.00),
(14, 1, 1, 67000.00),
(15, 7, 2, 100000.00),
(16, 1, 1, 67000.00),
(16, 2, 2, 30000.00),
(16, 3, 1, 20000.00),
(17, 7, 1, 100000.00),
(18, 9, 1, 40000.00),
(19, 7, 1, 100000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `alamat`, `email`, `telepon`) VALUES
(1, 'Abi Reza', 'ngawi barat', 'abireza@gmail.com', '08123456789'),
(2, 'Umi Ladesh', 'ngawi barat', 'ladeshsayangeja@gmail.com', '08234567891'),
(3, 'Hiura Mihate', 'Bandung pedalaman', 'hiuraimup@gmail.com', '0876543219'),
(4, 'biji mono', 'bekasi', 'biji@gmail.com', '084832');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int NOT NULL,
  `pelanggan_id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','pengguna') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pengguna'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `pelanggan_id`, `username`, `password`, `role`) VALUES
(1, 1, 'abireza', '$2a$12$phpIUnBeNDUhtYyKB6ChNONRtY/iJBWTBIK7fNXTRKKi/p3ViUU3W', 'pengguna'),
--reza123
(2, 2, 'umiladesh', '$2a$12$u47QTAcrtQ4cXC5mHABTU.MqE/NF0J3XPYjNiWHiasz4q3R4HRqqW', 'pengguna'),
--lades123
(3, 3, 'hiuraimup', '$2a$12$Og/TgPQJQBm3MXDnDf7xyu9EOUzgJySHgmEKSWlwfiBtl.Iq2wmzi', 'pengguna'),
--femboyimup
(4, 4, 'admin', '$2a$12$yLHapole5jhPcUr69h2fse//6kmuG/cVHMOoQhaf3vM26xRBlMTMW', 'admin');
--admin123
-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int NOT NULL,
  `tanggal_pesanan` date NOT NULL,
  `pelanggan_id` int NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `dibuat_oleh` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `tanggal_pesanan`, `pelanggan_id`, `total_harga`, `dibuat_oleh`) VALUES
(13, '2026-04-24', 3, 67000.00, NULL),
(14, '2026-04-24', 2, 67000.00, NULL),
(15, '2026-04-24', 1, 200000.00, NULL),
(16, '2026-06-21', 4, 147000.00, NULL),
(17, '2026-06-21', 3, 100000.00, NULL),
(18, '2026-06-21', 3, 40000.00, NULL),
(19, '2026-06-21', 3, 100000.00, 4);

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`pesanan_id`,`buku_id`),
  ADD KEY `fk_detail_pesanan_buku` (`buku_id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_pelanggan_id` (`pelanggan_id`),
  ADD UNIQUE KEY `uq_username` (`username`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pesanan_pelanggan` (`pelanggan_id`),
  ADD KEY `fk_pesanan_dibuat_oleh` (`dibuat_oleh`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_detail_pesanan_buku` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_detail_pesanan_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ketidakleluasaan untuk tabel `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `fk_pengguna_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_dibuat_oleh` FOREIGN KEY (`dibuat_oleh`) REFERENCES `pengguna` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_pesanan_pelanggan` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
