-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 04, 2024 at 08:03 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.19

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
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
(10, 'Informatik'),
(11, 'soshum'),
(12, 'hukum'),
(13, 'agama'),
(15, 'test'),
(16, 'testa');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_books`
--

CREATE TABLE `favorite_books` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `favorite_books`
--

INSERT INTO `favorite_books` (`id`, `user_id`, `book_id`) VALUES
(42, 1, 46);

-- --------------------------------------------------------

--
-- Table structure for table `journal_artikel`
--

CREATE TABLE `journal_artikel` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
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

-- --------------------------------------------------------

--
-- Table structure for table `upload_journal`
--

CREATE TABLE `upload_journal` (
  `id` int NOT NULL,
  `ja_id` varchar(255) DEFAULT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `abstract` text,
  `keyword` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `reference` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `file_path_docs` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `file_path_pdf` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `date_uploads` datetime DEFAULT NULL,
  `category` varchar(255) DEFAULT 'Lainnya',
  `language` varchar(255) DEFAULT NULL,
  `finish` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `upload_journal`
--

INSERT INTO `upload_journal` (`id`, `ja_id`, `user_id`, `title`, `subtitle`, `abstract`, `keyword`, `reference`, `file_path_docs`, `file_path_pdf`, `date_uploads`, `category`, `language`, `finish`) VALUES
(58, 'JA_665ec8f2640a6', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-06-04 14:57:38', 'Lainnya', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `upload_journal_user`
--

CREATE TABLE `upload_journal_user` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliation` varchar(255) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

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
-- Indexes for table `favorite_books`
--
ALTER TABLE `favorite_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

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
-- Indexes for table `upload_journal`
--
ALTER TABLE `upload_journal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_journal_user`
--
ALTER TABLE `upload_journal_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `categories_books`
--
ALTER TABLE `categories_books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `categories_journal_artikel`
--
ALTER TABLE `categories_journal_artikel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `favorite_books`
--
ALTER TABLE `favorite_books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `upload_journal`
--
ALTER TABLE `upload_journal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `upload_journal_user`
--
ALTER TABLE `upload_journal_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mahasiswa` (`id`),
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

--
-- Constraints for table `favorite_books`
--
ALTER TABLE `favorite_books`
  ADD CONSTRAINT `favorite_books_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `mahasiswa` (`id`),
  ADD CONSTRAINT `favorite_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);

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
