-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2025 at 11:17 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital-feedback-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES
(1, 'Finance', '2024-12-13 02:44:20', '2024-12-13 02:44:20', NULL, 0),
(2, 'hurrey', '2024-12-13 03:05:38', '2024-12-13 03:05:38', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `patient_id` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `ip_number` bigint(20) NOT NULL,
  `Gender` enum('M','F','O') DEFAULT NULL,
  `user_type` varchar(100) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `email`, `patient_id`, `password`, `name`, `age`, `mobile`, `ip_number`, `Gender`, `user_type`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES
(2, 'admin@yopmail.com', NULL, '$2y$10$mxMSxrCHcZMMxHAx1So9OOI7p2nOIGSgDKw/cFBt9DMOv2nQn5DGO', 'admin', '16', '998877665544', 3234223322322, 'M', 'admin', '2024-11-27 05:04:17', '2024-12-04 05:33:43', NULL, 0),
(5, 'patient@yopmail.com', 'patient_121048', '$2y$10$hW3egUfwqL4AGgbbgwj9fe6UO6qcQXUQ4L75BI7H/fUnE0EacyKEO', 'patient', '45', '9910936391', 123321123211, 'F', 'user', '2024-12-06 03:58:13', '2025-01-11 13:37:52', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `patient_feedbacks`
--

CREATE TABLE `patient_feedbacks` (
  `id` int(10) NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `query_type_id` int(10) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `message_reply_by_admin` text DEFAULT NULL,
  `is_reply` enum('yes','no') NOT NULL DEFAULT 'no',
  `name` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `patient_feedbacks`
--

INSERT INTO `patient_feedbacks` (`id`, `patient_id`, `query_type_id`, `message`, `message_reply_by_admin`, `is_reply`, `name`, `age`, `email`, `mobile`, `image`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES
(1, 'patient_121048', 4, 'This is my first query', 'SDs', 'no', 'patient', '40', 'patient@yopmail.com', '9910936397', 'images/7pVHfsrLE70vFqhc2JRfoCfSh7ph9ZCCMSdXrCGw.jpg', '2024-12-13 06:24:29', '2025-01-11 06:43:35', NULL, 0),
(2, 'patient_121040', 2, 'This is my second query', 'asdfd', 'yes', 'patient', '40', 'patient@yopmail.com', '9910936397', '', '2024-12-13 06:24:50', '2024-12-17 11:32:25', NULL, 0),
(3, 'patient_121047', 2, 'This is my third query', 'asdfd', 'yes', 'patient', '40', 'patient@yopmail.com', '9910936397', '', '2024-11-13 06:24:50', '2024-11-13 06:38:45', NULL, 0),
(4, 'patient_1210473', 2, 'This is my third query', 'asdfd', 'yes', 'patient', '40', 'patient@yopmail.com', '9910936397', '', '2024-11-14 06:24:50', '2024-12-17 11:32:16', NULL, 0),
(5, 'patient_121011', 2, 'This is my third query', 'asdfd', 'yes', 'patient', '40', 'patient@yopmail.com', '9910936397', '', '2024-01-14 06:24:50', '2024-01-17 11:32:16', NULL, 0),
(6, 'patient_121048', 3, 'hi twilio', 'hi', 'yes', 'patient', '40', 'patient@yopmail.com', '9910936397', 'images/WsBRBPxdVjccJhoccshR7niyMYJgv7YUA1K86btB.jpg', '2024-12-23 10:08:16', '2024-12-23 10:09:45', NULL, 0),
(7, 'patient_121048', 2, 'hi messge', 'rtyr', 'yes', 'patient', '40', 'patient@yopmail.com', '9910936397', 'images/RGRBYkrcpPyZenHhFUJ95jX2EjMCoIDRVIBprsUF.jpg', '2024-12-24 01:41:27', '2024-12-24 01:42:37', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `query_types`
--

CREATE TABLE `query_types` (
  `id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `query_types`
--

INSERT INTO `query_types` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`, `is_deleted`) VALUES
(1, 'Pharmacy', '2024-12-13 06:54:45', NULL, NULL, 0),
(2, 'Caboratory', '2024-12-13 06:54:45', NULL, NULL, 0),
(3, 'Nursing Services', '2024-12-13 06:55:15', NULL, NULL, 0),
(4, 'Finance', '2024-12-13 06:55:15', NULL, NULL, 0),
(5, 'House Keeping', '2024-12-13 06:55:40', NULL, NULL, 0),
(6, 'Medical Services', '2024-12-13 06:55:40', NULL, NULL, 0),
(7, 'Administration', '2024-12-13 06:56:48', NULL, NULL, 0),
(8, 'Kitchen Services', '2024-12-13 06:56:48', '2024-12-13 04:38:16', NULL, 0),
(9, 'sdfs', '2024-12-13 04:08:22', '2024-12-13 04:20:48', '2024-12-13 04:20:48', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patient_feedbacks`
--
ALTER TABLE `patient_feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `query_types`
--
ALTER TABLE `query_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `patient_feedbacks`
--
ALTER TABLE `patient_feedbacks`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `query_types`
--
ALTER TABLE `query_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
