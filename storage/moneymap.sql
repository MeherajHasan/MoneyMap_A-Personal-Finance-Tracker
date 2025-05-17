-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 05:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moneymap`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `id_type` int(1) NOT NULL COMMENT 'nid->0 passport->1',
  `id_number` varchar(17) NOT NULL,
  `passport_expiry` date DEFAULT NULL,
  `country_code` varchar(3) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `gender` int(1) NOT NULL COMMENT 'male->0 female->1',
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `photo_path` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `account_status` int(1) NOT NULL COMMENT '0->active 1->inactive 2->suspended 3->pending',
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `id_type`, `id_number`, `passport_expiry`, `country_code`, `phone`, `mail`, `password_hash`, `gender`, `dob`, `address`, `photo_path`, `created_at`, `account_status`, `role`) VALUES
(11, 'John', 'Doe', 0, '1234567890', NULL, '+88', '01555555555', 'john.doe@gmail.com', 'hashed_password_1', 0, '1995-08-15', '123 Main St, City A', 'images/john.png', '2025-05-17 14:41:31', 0, 'user'),
(12, 'Jane', 'Doe', 1, 'P1234567', '2028-06-12', '+88', '01777777777', 'jane.doe@gmail.com', 'hashed_password_2', 1, '1997-05-10', '456 Main St, City B', 'images/jane.png', '2025-05-17 14:41:31', 0, 'user'),
(13, 'David', 'Smith', 0, '9876543210', NULL, '+88', '01666666666', 'david.smith@gmail.com', 'hashed_password_3', 0, '1992-11-22', '789 Main St, City C', 'images/david.png', '2025-05-17 14:41:31', 0, 'user'),
(14, 'Emily', 'Brown', 0, '1122334455', NULL, '+88', '01444444444', 'emily.brown@gmail.com', 'hashed_password_4', 1, '2000-01-19', '111 Main St, City D', 'images/emily.png', '2025-05-17 14:41:31', 0, 'user'),
(15, 'Chris', 'Johnson', 1, 'P2233445', '2027-03-18', '+88', '01333333333', 'chris.johnson@gmail.com', 'hashed_password_5', 0, '1998-09-05', '222 Main St, City E', 'images/chris.png', '2025-05-17 14:41:31', 0, 'user'),
(16, 'Sarah', 'Lee', 0, '5566778899', NULL, '+88', '01888888888', 'sarah.lee@gmail.com', 'hashed_password_6', 1, '2001-07-23', '333 Main St, City F', 'images/sarah.png', '2025-05-17 14:41:31', 0, 'user'),
(17, 'Michael', 'Clark', 1, 'P4455667', '2029-11-30', '+88', '01999999999', 'michael.clark@gmail.com', 'hashed_password_7', 0, '1990-03-12', '444 Main St, City G', 'images/michael.png', '2025-05-17 14:41:31', 0, 'user'),
(18, 'Linda', 'Lewis', 0, '2233445566', NULL, '+88', '01222222222', 'linda.lewis@gmail.com', 'hashed_password_8', 1, '1985-12-28', '555 Main St, City H', 'images/linda.png', '2025-05-17 14:41:31', 0, 'user'),
(19, 'Tom', 'Walker', 0, '3344556677', NULL, '+88', '01111111111', 'tom.walker@gmail.com', 'hashed_password_9', 0, '1993-04-15', '666 Main St, City I', 'images/tom.png', '2025-05-17 14:41:31', 0, 'user'),
(20, 'Admin', 'User', 0, '4455667788', NULL, '+88', '01010101010', 'admin@gmail.com', '11111111', 0, '1988-02-20', 'Admin HQ, City J', 'images/admin.png', '2025-05-17 14:41:31', 0, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
