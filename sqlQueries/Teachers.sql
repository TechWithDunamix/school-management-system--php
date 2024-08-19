-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 19, 2024 at 01:16 PM
-- Server version: 8.0.39-0ubuntu0.22.04.1
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sms_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `Teachers`
--

CREATE TABLE `Teachers` (
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `date_of_birth` date NOT NULL,
  `id` varchar(56) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `blood_group` varchar(3) DEFAULT NULL,
  `religion` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `class` varchar(20) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `address` text,
  `phone` varchar(20) DEFAULT NULL,
  `school_id` varchar(120) NOT NULL,
  `date_joined` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Teachers`
--

INSERT INTO `Teachers` (`first_name`, `last_name`, `gender`, `date_of_birth`, `id`, `blood_group`, `religion`, `email`, `class`, `section`, `address`, `phone`, `school_id`, `date_joined`) VALUES
('chioma winnersq', 'last_name', 'male', '2006-12-02', 'c9abb480af5a3fc99e8187e7dbecce9c', '0+', 'christain', 'test@guia6.user', 'ss3', 'THe', 'no 14 st ameanyi streen', '0837347738', 'ff3131b66b143384', '2024-08-05 22:59:48'),
('chioma winnersq', 'last_name', 'male', '2006-12-02', 'eef19935dcfc2e5672a8742760e64637', '0+', 'christain', 'test@guia4.user', 'ss3', NULL, NULL, '0837347738', 'ff3131b66b143384', '2024-08-05 23:04:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Teachers`
--
ALTER TABLE `Teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
