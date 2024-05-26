-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 26, 2024 at 10:40 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gubook`
--
CREATE DATABASE IF NOT EXISTS `gubook` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `gubook`;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `cover` varchar(255) NOT NULL,
  `url_buku` varchar(255) NOT NULL,
  `kategori` varchar(50) NOT NULL DEFAULT 'Lainnya'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `judul`, `pengarang`, `penerbit`, `tanggal_terbit`, `cover`, `url_buku`, `kategori`) VALUES
(37, 'Algoritma & Pemrograman', 'Kurnia Adi Cahyanto. M.Kom', 'PT BLABLA', '2019-05-05', 'Cover-algo.jpg', 'Manajemen Perangkat IO.pdf', 'Non Fiksi'),
(44, 'Laut Bercerita', 'Leila S. Chudori', 'Leila S. Chudori', '2024-05-15', 'Cover-laut bercerita.jpeg', 'KELOMPOK 5_MANAJEMEN MEMORI DINAMIS.pdf', 'Fiksi'),
(45, 'Negeri Para Bedebah', 'Tere Liye', 'Tere Liye', '2024-05-13', 'Cover-negribdb.jpg', 'KELOMPOK 5_MANAJEMEN MEMORI DINAMIS.pdf', 'Fiksi'),
(46, 'Parable', 'Brian Krishna', 'Brian Krishna', '2024-05-16', 'cover-parabel.jpg', 'KELOMPOK 5_MANAJEMEN MEMORI DINAMIS.pdf', 'Fiksi'),
(47, 'Gadis Kretek', 'Ratih Kumaka', 'Ratih Kumaka', '2024-05-10', 'Cover-gadis kretek.jpg', 'KELOMPOK 5_MANAJEMEN MEMORI DINAMIS.pdf', 'Non Fiksi');

-- --------------------------------------------------------

--
-- Table structure for table `categories_books`
--

CREATE TABLE `categories_books` (
  `id` int NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories_books`
--

INSERT INTO `categories_books` (`id`, `nama_kategori`) VALUES
(70, 'Non Fiksi'),
(71, 'Fiksi');

-- --------------------------------------------------------

--
-- Table structure for table `categories_journal_artikel`
--

CREATE TABLE `categories_journal_artikel` (
  `id` int NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `categories_journal_artikel`
--

INSERT INTO `categories_journal_artikel` (`id`, `nama_kategori`) VALUES
(1, 'test'),
(7, 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `journal_artikel`
--

CREATE TABLE `journal_artikel` (
  `id` int NOT NULL,
  `judul` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('on','off') DEFAULT 'off'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `email`, `password`, `status`) VALUES
(1, '2210631170110@student.unsika.ac.id', '$2y$10$sNatiF97BFmchi6.ghmMtOI2sA0SKWCg15jS9/fE03UiRpvHbjCS6', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `pengurus`
--

CREATE TABLE `pengurus` (
  `id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `pengurus`
--

INSERT INTO `pengurus` (`id`, `email`, `password`) VALUES
(1, 'tubagus@gmail.com', '$2a$12$TFIkz7yiZEHpCo9Ugdu5vuWmUQLIhp/BG5Za8GJK9g5zWnaehXiYS');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `rating` int NOT NULL,
  `review_text` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `book_id`, `rating`, `review_text`, `created_at`) VALUES
(10, 1, 37, 5, 'bukunya keren!', '2024-05-26 22:03:58'),
(11, 1, 37, 2, 'Kurang 🙏', '2024-05-26 22:08:04'),
(12, 1, 37, 3, 'test', '2024-05-26 22:16:48'),
(13, 1, 37, 3, 'gaag', '2024-05-26 22:16:53'),
(14, 1, 37, 2, 'fafff', '2024-05-26 22:17:02'),
(15, 1, 44, 4, 'mantap', '2024-05-26 22:21:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_books`
--
ALTER TABLE `categories_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_journal_artikel`
--
ALTER TABLE `categories_journal_artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_artikel`
--
ALTER TABLE `journal_artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pengurus`
--
ALTER TABLE `pengurus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `categories_books`
--
ALTER TABLE `categories_books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `categories_journal_artikel`
--
ALTER TABLE `categories_journal_artikel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `journal_artikel`
--
ALTER TABLE `journal_artikel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengurus`
--
ALTER TABLE `pengurus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mahasiswa` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
