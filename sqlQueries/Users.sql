-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 30, 2024 at 04:57 PM
-- Server version: 8.0.37-0ubuntu0.22.04.3
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
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` varchar(160) NOT NULL,
  `email` varchar(250) NOT NULL,
  `hashedpassword` text NOT NULL,
  `ref_id` varchar(320) NOT NULL,
  `ref_by` varchar(320) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `username` varchar(320) NOT NULL,
  `school_name` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `email`, `hashedpassword`, `ref_id`, `ref_by`, `username`, `school_name`, `date_created`) VALUES
('4a2e11fb848ee84eb75f24f430aa6f1b', 'we@gmail.com', '$2y$10$vb1rwz/dcTiQDq4AotW4ru3jWGcWi0Gxf9XH50opJ.OjXFGFseY5e', '59eb251b5d734880', '', 'singolodev', 'we', '2024-07-30 15:46:04'),
('54ddfc3733f17f418f62ad227c9c2495', 'wem@gmail.com', '$2y$10$T/BC0EMaJdiiRv83y30osuckTW8fyh8ZEPy7voIqx30ZkEerMeR9C', '3f323db448b07fbf', '', 'singolodev', 'wemol', '2024-07-30 15:47:50'),
('7e5843e6d9897ddb370327ed7d7a2791', 'wem11041@gmail.com', '$2y$10$sy.vVTK3IgTFNBq9515Chedyibr/J2woEuNtKYrs1j.iwl48bjF6u', '189f914ef944ac02', '', 'singolodev', 'wemo1112', '2024-07-30 16:10:57'),
('8a83762689a89423006dce3b972a3ee9', 'wem104@gmail.com', '$2y$10$w/PgFjYSdCi0vB0jYAh99uHs/Y1ILWy2XPxC1..YS7uGHgXDFCEue', '9b02d68bdf38b1e0', '', 'singolodev', 'wemo11', '2024-07-30 16:00:27'),
('a385e5236ee4102b6eeae05d8213706b', 'javadev@gmail.com', '$2y$10$LlkQEjnE3mplztQe/6Fvk.0HlT1so.5F4UMf1WxIdLW/voRE3RAU2', '2fa554d87b716da2', '', 'singolodev', 'java school', '2024-07-30 16:23:41'),
('a8120f056e3e1cd4e2176850f023d067', 'dunamis11@gmail.com', '$2y$10$v84VCqN.sgRaejPZRfGXFuIwfmxCp4M0JugAhVResDVT5T9bSVBpC', '1ba3f22031922871', '', 'didi', 'de grande', '2024-07-24 16:10:51'),
('d0a53d9495e0a8a6b04f443c0bf16065', 'wem101@gmail.com', '$2y$10$MLf6kYAtPK7UxszUkBVeFux6w2D7YMnmSvQtVrCZISI8Nm74OSBLa', 'e9651747e42513d7', '', 'singolodev', 'wemol101', '2024-07-30 15:48:43'),
('d94c92e829e50185284040972ba10134', 'dunamis121@gmail.com', '$2y$10$H2dYnNzqQhuJ7N4zS0xtcO4AcchQpabIlfiS78xs7Cw9vrTPCUfRi', 'f3961167ff79ce68', '', 'didi', 'de grande de lopez', '2024-07-24 21:16:56'),
('dd6b254d3579bc45284d9eac1ecab3ad', 'wem1041@gmail.com', '$2y$10$taZwjwqiGL/HvGcg/M/VyeOPHsZ1idmKxw3.KNJx9b.zJ5afbeJTK', '6f67c8c3ec4a3324', '', 'singolodev', 'wemo111', '2024-07-30 16:01:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_2` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
