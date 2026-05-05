-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 03:31 PM
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
-- Database: `kapunongan`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `content`, `date`) VALUES
(1, 'Bayanhinan 123', 'Today we gather in the land of dawn.', '12/04/2025 7:38AM');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_disp`
--

CREATE TABLE `announcement_disp` (
  `announcement_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_disp`
--

INSERT INTO `announcement_disp` (`announcement_id`, `user_id`, `status`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `time` varchar(20) DEFAULT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `user_id`, `time`, `status`) VALUES
(20, 2, '2025-12-04 20:57:44', 2),
(20, 3, NULL, 3),
(20, 4, NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `attendance_main`
--

CREATE TABLE `attendance_main` (
  `attendance_id` int(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `date` varchar(30) NOT NULL,
  `tot_present` int(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_main`
--

INSERT INTO `attendance_main` (`attendance_id`, `title`, `date`, `tot_present`) VALUES
(20, 'Bayan', '2025-10-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `family_list`
--

CREATE TABLE `family_list` (
  `family_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `mi` varchar(5) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `relation` varchar(30) NOT NULL,
  `age` int(2) NOT NULL,
  `bdate` varchar(20) NOT NULL,
  `contact_no` bigint(11) DEFAULT NULL,
  `occupation` varchar(30) DEFAULT NULL,
  `date_listed` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `family_list`
--

INSERT INTO `family_list` (`family_id`, `user_id`, `fname`, `lname`, `mi`, `sex`, `relation`, `age`, `bdate`, `contact_no`, `occupation`, `date_listed`) VALUES
(1, 2, 'John', 'Doe', 'A', 'Male', 'Noidea', 22, '2003-10-10', NULL, NULL, '2025-12-04 07:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `funeral_fund`
--

CREATE TABLE `funeral_fund` (
  `fund_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `balance` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `funeral_fund`
--

INSERT INTO `funeral_fund` (`fund_id`, `user_id`, `balance`) VALUES
(1, 3, 100),
(2, 1, 0),
(3, 5, 100);

-- --------------------------------------------------------

--
-- Table structure for table `funeral_info`
--

CREATE TABLE `funeral_info` (
  `funeral_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `deceased_name` varchar(30) NOT NULL,
  `relation` varchar(30) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `age` int(3) NOT NULL,
  `death_date` varchar(20) NOT NULL,
  `death_cause` varchar(50) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` varchar(30) NOT NULL,
  `recorded_by` int(11) DEFAULT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penalty`
--

CREATE TABLE `penalty` (
  `penalty_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `amount` int(8) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penalty`
--

INSERT INTO `penalty` (`penalty_id`, `user_id`, `reason`, `amount`, `status`) VALUES
(1, 4, 'Absent at Bayan', 100, 'unpaid'),
(2, 4, 'Absent at Bayan', 100, 'unpaid'),
(4, 3, 'Marked as absent at(Bayan)', 100, 'unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(5) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'member'),
(2, 'treasurer'),
(3, 'president');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transac_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `amount` int(8) NOT NULL,
  `type` int(20) NOT NULL,
  `method` int(20) NOT NULL,
  `proof` mediumblob NOT NULL,
  `recorded_by` int(5) NOT NULL,
  `date` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `role_id` int(1) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `mi` varchar(10) DEFAULT NULL,
  `sex` varchar(6) DEFAULT NULL,
  `age` int(2) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `contact_no` bigint(11) DEFAULT NULL,
  `address` varchar(20) DEFAULT NULL,
  `occupation` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `bdate` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `role_id`, `fname`, `lname`, `mi`, `sex`, `age`, `email`, `contact_no`, `address`, `occupation`, `password`, `bdate`) VALUES
(2, 3, 'Erick Cyle', 'Embodo', 'A', NULL, NULL, 'ErickEmbodo@gmail.com', NULL, NULL, NULL, '$2y$12$UefaAScNgT88QZenArBzAOhiZ9/8AidMJM1wQ.0NTCH1rrnifTIsG', NULL),
(4, 1, 'Soco', 'Alfredo', NULL, NULL, NULL, 'soco1@gmail.com', NULL, NULL, NULL, '$2y$12$0OyJCP4mzBR0nl/k629bhePRI4ufBux4RcwWepotAVO532g7af06u', NULL),
(5, 2, 'darbe', 'Alvin', NULL, NULL, NULL, 'darbe@gmail.com', NULL, NULL, NULL, '$2y$12$b2QiW5JhsdoFBhWsFMwOsumL3j4EeCa6q6PWtG5FlHI5sihl9lIym', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `balance` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `attendance_main`
--
ALTER TABLE `attendance_main`
  ADD PRIMARY KEY (`attendance_id`);

--
-- Indexes for table `family_list`
--
ALTER TABLE `family_list`
  ADD PRIMARY KEY (`family_id`);

--
-- Indexes for table `funeral_fund`
--
ALTER TABLE `funeral_fund`
  ADD PRIMARY KEY (`fund_id`);

--
-- Indexes for table `funeral_info`
--
ALTER TABLE `funeral_info`
  ADD PRIMARY KEY (`funeral_id`);

--
-- Indexes for table `penalty`
--
ALTER TABLE `penalty`
  ADD PRIMARY KEY (`penalty_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transac_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `attendance_main`
--
ALTER TABLE `attendance_main`
  MODIFY `attendance_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `family_list`
--
ALTER TABLE `family_list`
  MODIFY `family_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `funeral_fund`
--
ALTER TABLE `funeral_fund`
  MODIFY `fund_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `funeral_info`
--
ALTER TABLE `funeral_info`
  MODIFY `funeral_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penalty`
--
ALTER TABLE `penalty`
  MODIFY `penalty_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transac_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
