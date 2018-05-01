-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Mar 26, 2018 at 12:21 PM
-- Server version: 5.7.21
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symfony`
--

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` float(11,2) NOT NULL,
  `status` enum('rejected','approved') COLLATE utf8_unicode_ci NOT NULL,
  `datetime` datetime NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `email`, `amount`, `status`, `datetime`, `token`) VALUES
(1, 'test@gmail.com', 1.00, 'rejected', '2018-03-26 11:46:42', NULL),
(2, 'test@gmail.com', 1.00, 'rejected', '2018-03-26 11:49:09', NULL),
(3, 'test@gmail.com', 1.00, 'rejected', '2018-03-26 11:51:00', NULL),
(4, 'test@gmail.com', 1.00, 'rejected', '2018-03-26 11:51:06', NULL),
(5, 'test@gmail.com', 1.00, 'approved', '2018-03-26 11:51:13', '2160bf89ab8e711b5ea512c67fa6c7ce'),
(6, 'test2@gmail.com', 4.00, 'approved', '2018-03-26 13:11:04', '8b8325e8d519bb9d8556e9c9546a2687'),
(7, 'test@gmail.com', 5.70, 'rejected', '2018-03-26 13:11:25', NULL),
(8, 'test@gmail.com', 5.70, 'approved', '2018-03-26 13:11:28', 'd45ff7f17219d9ef654415c6fea717c4'),
(9, 'test@gmail.com', 5.75, 'approved', '2018-03-26 13:43:44', '295f101b352bc4bb59485f96f27dea36'),
(10, 'test@gmail.com', 4.00, 'approved', '2018-03-26 13:44:30', '13082609889cf60af22abaff415b793c'),
(11, 'test@gmail.com', 10.00, 'approved', '2018-03-26 13:44:39', '74aa242334e6df908a2c78b0fa0da5b7'),
(12, 'test@gmail.com', 50.00, 'approved', '2018-03-26 13:49:37', '0c5071bb795942568de10ae80e1f94d4'),
(13, 'test@gmail.com', 60.40, 'approved', '2018-03-27 03:06:00', '07746ddfed9a84cd38d852303604e86f'),
(14, 'test@gmail.com', 10.00, 'approved', '2018-03-27 11:20:00', '07746ddfed9a84cd38d852313604e86f'),
(15, 'test2@gmail.com', 50.30, 'approved', '2018-03-28 00:00:00', 'gh304u4309f43hfj34f32vb6'),
(16, 'test2@gmail.com', 45.30, 'approved', '2018-03-29 07:18:33', 'rvy5tu4nt5vb4yt934n5y80ut3t54by'),
(17, 'test@gmail.com', 457.00, 'approved', '2018-03-30 15:09:00', 'ghjyrthpgufhuibnv9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
