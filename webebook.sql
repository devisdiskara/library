-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2025 at 05:15 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webebook`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `pengarang` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_sampul` varchar(255) DEFAULT NULL,
  `path_file` varchar(255) DEFAULT NULL,
  `tanggal_upload` date DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `jumlah_unduhan` int(11) DEFAULT 0,
  `rating` decimal(3,2) DEFAULT 0.00,
  `jumlah_ulasan` int(11) DEFAULT 0,
  `link_shopee` varchar(255) DEFAULT NULL,
  `link_tokopedia` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `pengarang`, `deskripsi`, `gambar_sampul`, `path_file`, `tanggal_upload`, `id_kategori`, `id_pengguna`, `jumlah_unduhan`, `rating`, `jumlah_ulasan`, `link_shopee`, `link_tokopedia`) VALUES
(1, 'Cara Cepat Membaca Bahasa Tubuh', 'fauzan', 'Panduan lengkap untuk cara cepat membaca bahasa tubuh ', 'ebook1.jpg', 'https://drive.google.com/uc?export=download&id=1o4b3Pr-kIk5jG3Vvr2VKzBjljs1pAKFD', '2024-05-19', 3, NULL, 10, '0.00', 0, 'https://s.shopee.co.id/5VBtMKzOz9', 'https://tokopedia.link/JnHAVTmweMb'),
(2, 'Manipulation Dark Pisilogi', 'Jane Smith', 'Buku ini membahas dasar-dasar algoritma dan penerapannya dalam pemrograman.', 'ebook2.jpg', 'https://drive.google.com/uc?export=download&id=1yPdMJga34tQqpOO7Tz7NsFTT19e7kq5O', '2024-05-18', 1, 2, 120, '4.30', 15, NULL, NULL),
(3, 'Kebenaran Yang Hilang', 'Alice Brown', 'Pelajari konsep dasar jaringan komputer dan cara kerjanya.', 'ebook3.jpg', 'https://drive.google.com/uc?export=download&id=16YUMaape9Lzk9NxFlZVjt97Zt6NOFt6s', '2024-05-17', 2, 3, 90, '4.20', 10, NULL, NULL),
(5, 'Rich Dad For dad', 'Charlie Lee', 'Pengenalan data science dan berbagai teknik analisis data yang digunakan dalam bidang ini.', 'ebook5.jpg', 'https://drive.google.com/uc?export=download&id=1cUnXZhiFP6DfilaZKEGiMDwKn7HPYSyJ', '2024-05-15', 5, 5, 180, '4.60', 18, NULL, NULL),
(54, 'Kisah Sebuah Pohon', 'Aels', 'nasjdbjsbdjs', 'ebook6.png', NULL, '2025-04-29', 5, NULL, 100, '0.00', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `donasi_ebook`
--

CREATE TABLE `donasi_ebook` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar_sampul` varchar(255) DEFAULT NULL,
  `file_ebook` varchar(255) DEFAULT NULL,
  `status` enum('belum diverifikasi','diterima','ditolak','') DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `tanggal_donasi` date DEFAULT NULL,
  `format_file` varchar(50) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorit`
--

CREATE TABLE `favorit` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorit`
--

INSERT INTO `favorit` (`id`, `id_pengguna`, `id_buku`) VALUES
(87, 7, 1),
(88, 7, 2),
(91, 11, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama`) VALUES
(1, 'Programming'),
(2, 'Algorithms'),
(3, 'Networking'),
(4, 'Web Development'),
(5, 'Data Science');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `isi_komentar` text DEFAULT NULL,
  `tanggal_komentar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id_komentar`, `id_buku`, `id_pengguna`, `isi_komentar`, `tanggal_komentar`) VALUES
(11, 1, 11, 'bagus banget bukunya recomended untuk di baca\r\n', '2024-08-20');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `id_pengguna` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `id` int(11) NOT NULL,
  `pengguna_id` int(11) DEFAULT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `nama_pengguna` varchar(100) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `kata_sandi` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `negara` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `profile` varchar(255) NOT NULL,
  `tanggal_registrasi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_pengguna`, `email`, `kata_sandi`, `username`, `bio`, `negara`, `instagram`, `facebook`, `profile`, `tanggal_registrasi`) VALUES
(2, 'Jack', 'admin2@example.com', 'password', '', '', '', '', '', '', '2024-07-07 15:09:48'),
(3, 'muhamad alex al fauzan', 'user1@example.com', 'password123', 'Fauzan', 'Pencinta seni dan desain grafis, aktif di komunitas kreatif lokal dan sering mengadakan pameran seni.\r\n\r\n', 'indonesia', 'https://www.instagram.com/iam_zanss?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==', 'https://www.facebook.com/profile.php?id=100089859462381', 'team-1.jpg', '2024-07-07 15:09:48'),
(4, 'Denis', 'Denis@gmail.com', 'password123', 'denis bg', 'saya denis seorang yang suka baca komik', 'indonesia', 'https://www.instagram.com/iam_zanss?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==', 'https://www.facebook.com/people/Gemoy-Tiktok/pfbid0xjTNeMq8HPPsgksNRM3rFr3U8SEEkbKwpX3kbk6uMc7WFk5bLELoScR6gtBiQHKel/', '668214ff38a540.92773243.png', '2024-07-07 15:09:48'),
(5, 'Merry', 'user3@example.com', 'password123', '', '', '', '', '', '', '2024-07-07 15:09:48'),
(6, 'Alex', 'user4@example.com', 'password123', '', '', '', '', '', '', '2024-07-07 15:09:48'),
(7, 'yusuf ahmad fauzan', 'zanishere676@gmail.com', '$2y$10$v10mPO6CUJLhYsPNKnt7zO61HcgkJhe.lQpWS4y7xfUPrOksXw9X.', 'yusuf', 'saya suka baca buku', 'indonesia', 'https://www.instagram.com/', 'https://www.facebook.com/people/Gemoy-Tiktok/pfbid032NEbD7FCgUxWFPvfrnghx2Fx7RRGjqchMr4rqsmhMNodX3cWaeKu1ojsq7QwdPhxl/', '668cab89325d97.61151117.jpeg', '2024-07-07 15:09:48'),
(10, 'Abdulloh Nashih Ulwan', 'fauzan30@gmail.com', '$2y$10$BYomcPMcU9zt/G5nPFcswuecWqOfrdObkawR.O249BrIslijw3Vm.', 'petugas', '', 'australia', '', '', '_acc0988f-9f7d-4710-96e4-3a1c98f41b38.jpeg', '2024-07-08 02:48:17'),
(11, 'Fauzan', 'patriky700@gmail.com', '$2y$10$QvHgPGEQoE7RSHUlxRMnXuFK10vI5oCuH5g8Qa7L8RgwQlSSN.QqK', 'DAVID', 'saya suka baca buku karna buat saya jadi sedikit lebih pintar', 'indonesia', 'https://www.instagram.com/frameszans', 'https://www.facebook.com/siti.khoirotu ', 'flat,750x,075,f-pad,750x1000,f8f8f8.u3.jpg', '2024-08-19 04:03:05'),
(12, 'FauzanCreative', 'zanishere676@gmail.com', '$2y$10$AWyNJIZ/MiL1PwoWlHDkMejHYN99vIv0pQcK3VERnTuZxTRTVCIPq', 'denis', '', 'Indonesia', '', '', '5017114-removebg-preview.png', '2024-09-03 14:54:24'),
(13, 'Abdulloh Nashih Ulwan', 'jajaagus0873@gmail.com', '$2y$10$F1wWDJfBiF2L.6VbwhCVu.mS85eXkN8O1dSk/20xnehCPEc3wT1Su', 'ales', 'retregrghrt', 'amerika', '', '', 'WhatsApp Image 2025-04-25 at 15.49.07.jpeg', '2025-04-29 08:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `unduhan`
--

CREATE TABLE `unduhan` (
  `id_pengguna` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unduhan`
--

INSERT INTO `unduhan` (`id_pengguna`, `id_buku`) VALUES
(11, 1),
(12, 53),
(13, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `donasi_ebook`
--
ALTER TABLE `donasi_ebook`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorit`
--
ALTER TABLE `favorit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_buku` (`id_buku`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengguna_id` (`pengguna_id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `unduhan`
--
ALTER TABLE `unduhan`
  ADD PRIMARY KEY (`id_pengguna`,`id_buku`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `donasi_ebook`
--
ALTER TABLE `donasi_ebook`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `favorit`
--
ALTER TABLE `favorit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_reset`
--
ALTER TABLE `password_reset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `buku_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`),
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`id_pengguna`);

--
-- Constraints for table `password_reset`
--
ALTER TABLE `password_reset`
  ADD CONSTRAINT `password_reset_ibfk_1` FOREIGN KEY (`pengguna_id`) REFERENCES `pengguna` (`id_pengguna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
