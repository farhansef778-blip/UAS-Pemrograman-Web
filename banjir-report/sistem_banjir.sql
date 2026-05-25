-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Bulan Mei 2026 pada 11.21
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
-- Database: `sistem_banjir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`, `created_at`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator BPBD', '2026-05-25 08:47:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama_pelapor` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `status` enum('diterima','ditindaklanjuti','dikerjakan','selesai') DEFAULT 'diterima',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `user_id`, `nama_pelapor`, `email`, `alamat`, `foto`, `keterangan`, `latitude`, `longitude`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Budi Santoso', 'budi@email.com', 'Jl. Merpati No.10, RT 02 RW 05, Kel. Banjarsari', NULL, 'Air mulai masuk ke dalam rumah setinggi 30cm', '-6.200000', '106.816666', 'diterima', '2026-05-25 08:47:11', '2026-05-25 08:47:11'),
(2, NULL, 'Siti Aminah', 'siti@email.com', 'Jl. Kenanga No.5, RT 03 RW 02, Kel. Kebon Jeruk', NULL, 'Banjir sudah setinggi 1 meter, warga sudah mengungsi', '-6.210000', '106.820000', 'ditindaklanjuti', '2026-05-25 08:47:11', '2026-05-25 08:47:11'),
(3, NULL, 'Ahmad Fauzi', 'ahmad@email.com', 'Jl. Mawar No.15, RT 01 RW 03, Kel. Cipedak', NULL, 'Genangan air 50cm, akses jalan terputus', '-6.190000', '106.810000', 'dikerjakan', '2026-05-25 08:47:11', '2026-05-25 08:47:11'),
(4, NULL, 'Dewi Kartika', 'dewi@email.com', 'Jl. Melati No.8, RT 04 RW 01, Kel. Sukamaju', NULL, 'Banjir surut, warga mulai membersihkan rumah', '-6.195000', '106.825000', 'selesai', '2026-05-25 08:47:11', '2026-05-25 08:47:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `aksi` varchar(100) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `admin_id`, `aksi`, `detail`, `ip_address`, `created_at`) VALUES
(1, 1, 'Login', 'Admin login ke sistem', '::1', '2026-05-25 09:05:55'),
(2, 1, 'Logout', 'Admin logout dari sistem', '::1', '2026-05-25 09:12:27'),
(3, 1, 'Login', 'Admin login ke sistem', '::1', '2026-05-25 09:12:37'),
(4, 1, 'Logout', 'Admin logout dari sistem', '::1', '2026-05-25 09:12:45'),
(5, 1, 'Login', 'Admin login ke sistem', '::1', '2026-05-25 09:14:04'),
(6, 1, 'Update Status', 'Update status laporan ID 1 menjadi diterima', '::1', '2026-05-25 09:16:53'),
(7, 1, 'Logout', 'Admin logout dari sistem', '::1', '2026-05-25 09:16:59'),
(8, 1, 'Login', 'Admin login ke sistem', '::1', '2026-05-25 09:17:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD CONSTRAINT `log_aktivitas_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `admin` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
