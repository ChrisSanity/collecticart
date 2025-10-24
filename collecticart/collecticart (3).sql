-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2025 at 03:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `collecticart`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `page` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `item_condition` varchar(50) DEFAULT NULL,
  `availability` enum('Available','Sold','In Transit') DEFAULT 'Available',
  `stocks` int(11) DEFAULT 0,
  `is_published` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand`, `name`, `price`, `image`, `page`, `description`, `item_condition`, `availability`, `stocks`, `is_published`) VALUES
(1, 'WCF', 'NAMI NAKAMA', 320.00, 'nami_wcf.jpg', 'products-wcf.php', '', '', 'Available', 1, 1),
(3, 'WCF', 'LUFFY NAKAMA', 400.00, 'luffy1_wcf.jpg', 'products-wcf.php', '', '', 'Available', 1, 1),
(7, 'WCF', 'USOPP NAKAMA', 350.00, 'usopp_wcf.jpg', 'products-wcf.php', NULL, NULL, 'Available', 1, 1),
(11, 'WCF', 'Luffy Happy Gear 5 ', 800.00, 'wcf-luffygear5.jpg', 'products-wcf.php', NULL, NULL, 'Available', 1, 1),
(13, 'WCF', 'Luffy Red Base', 1200.00, 'wcf-luffyredbase.jpg', 'products-wcf.php', NULL, NULL, 'Available', 1, 1),
(16, 'DBZ', 'Gogeta Masterlise', 950.00, 'dbz-gogeta.jpg', 'products-dbz.php', NULL, NULL, 'Available', 1, 1),
(18, 'DBZ', 'Goku Super Saiyan Blue', 1000.00, 'dbz-30.jpg', 'products-dbz.php', NULL, NULL, 'Available', 1, 1),
(19, 'DBZ', 'GOKU GOLD', 800.00, 'dbz-gold.jpg', 'products-dbz.php', NULL, NULL, 'Available', 1, 1),
(20, 'DBZ', 'Goku Prepare', 1100.00, 'dbz-blue.jpg', 'products-dbz.php', NULL, NULL, 'Available', 1, 1),
(21, 'DBZ', 'Goku Celebrate', 1250.00, 'dbz-goks.jpg', 'products-dbz.php', NULL, NULL, 'Sold', 0, 1),
(22, 'MBH', 'Usopp Kid', 450.00, 'mbh-usoppkid.jpg', 'products-mbh.php', 'Hard to find', 'Loose', 'Available', 1, 1),
(23, 'MBH', 'Sogeking', 280.00, 'mbh-sogeking.jpg', 'products-mbh.php', '', '', 'Available', 1, 1),
(24, 'MBH', 'Sol', 200.00, 'mbh-sol.jpg', 'products-mbh.php', 'WYSIWYG, fixed in base.', 'Loose', 'Available', 1, 1),
(25, 'MBH', 'Zoro Dressrosa', 500.00, 'zoro_drosa.jpg', 'products-mbh.php', '', '', 'Available', 1, 1),
(27, 'COLLECTIBLES', 'SHC Folder', 200.00, 'coll-folder.jpg', 'products-collectibles.php', '', '', 'Available', 1, 1),
(28, 'Limited', 'Luffy Gear 4', 2800.00, 'limited-luffy.jpg', 'products-limited.php', 'Rare MBH Luffy Gear 4, no issue.', 'Loose', 'Sold', 0, 1),
(31, 'WCF', 'Kaido Angry', 1500.00, 'wcf-kaidoangry.jpg', 'products-wcf.php', 'WYSIWYG, no box/loose as stated', 'Loose', 'Available', 1, 1),
(32, 'Keychains', 'Luffy Wanted', 100.00, 'kchains-luffywanted.jpg', 'products-kchains.php', 'Printed into wooden kitchen, made to order', 'Loose', 'Available', 1, 1),
(33, 'Keychains', 'Robin Chibi', 100.00, 'kchains-robin.jpg', 'products-kchains.php', 'WYSIWYG', 'Loose', 'Available', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `created_at`, `role`) VALUES
(1, 'Chris Test', 'christest', '$2y$10$1PG9jywKCM33hZeJBaUBLeNePpBd.912lwX4R5zNO1vlA11Ilz1i.', '2025-09-02 15:04:42', 'user'),
(2, 'Test Admin', 'testAdmin', '$2y$10$AvRnyjifAHwtc67cJDn81u4zkHnaH4FsRMAzJboPbf60K7vTfQotq', '2025-09-23 17:54:00', 'admin'),
(3, 'Test Ulit', 'admin_testing', '$2y$10$xmhnhuLXd0mbsqZxmvjKYecmrZ5TT/vxNmJSZJjOK674sDA5GhkBK', '2025-09-24 06:26:14', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(1, 1, 22, '2025-09-03 16:55:38'),
(7, 1, 24, '2025-09-03 22:02:05'),
(16, 1, 21, '2025-09-23 17:21:20'),
(17, 1, 25, '2025-09-23 17:21:28'),
(18, 1, 28, '2025-09-23 17:21:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
