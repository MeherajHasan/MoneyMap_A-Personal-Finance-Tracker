-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 04:35 PM
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
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expenseID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `expense_date` date NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 0 COMMENT '0 = active, 1 = deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expenseID`, `userID`, `category_id`, `name`, `amount`, `expense_date`, `note`, `created_at`, `status`) VALUES
(1, 23, 1, 'Brunch', 750.00, '2025-05-15', 'Office lunch', '2025-05-23 08:52:05', 0),
(2, 23, 2, 'Bus fare', 60.00, '2025-05-16', 'Commute to work', '2025-05-23 08:52:05', 0),
(3, 23, 3, 'Electricity bill', 3200.00, '2025-05-10', 'Monthly bill', '2025-05-23 08:52:05', 0),
(4, 23, 4, 'Movie ticket', 550.00, '2025-05-12', 'Weekend entertainment', '2025-05-23 08:52:05', 0),
(5, 23, 5, 'Doctor visit', 1200.00, '2025-05-14', 'General checkup', '2025-05-23 08:52:05', 0),
(6, 23, 6, 'Course fee', 7500.00, '2025-05-01', 'Online programming course', '2025-05-23 08:52:05', 0),
(7, 23, 7, 'Supermarket groceries', 1800.00, '2025-05-11', 'Weekly groceries', '2025-05-23 08:52:05', 0),
(8, 23, 8, 'Monthly rent', 15000.00, '2025-05-05', 'Apartment rent', '2025-05-23 08:52:05', 0),
(9, 23, 14, 'Donation to orphanage', 2000.00, '2025-05-13', 'Monthly donation', '2025-05-23 08:52:05', 0),
(10, 23, 16, 'Income tax payment', 3000.00, '2025-05-03', 'Quarterly tax', '2025-05-23 08:52:05', 0),
(11, 23, 1, 'Burger', 150.00, '0000-00-00', 'Cheap Burger', '2025-05-23 10:49:37', 0),
(12, 23, 2, 'Uber', 2000.00, '0000-00-00', 'Urgent varsity', '2025-05-23 10:50:53', 0),
(13, 23, 17, 'Vet bill', 100.00, '0000-00-00', 'why so many times!', '2025-05-23 10:51:41', 0);

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE `expense_categories` (
  `category_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 1 COMMENT '0 = default, 1 = active, 2 = deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`category_id`, `user_id`, `name`, `created_at`, `status`) VALUES
(1, NULL, 'Food', '2025-05-22 21:01:51', 0),
(2, NULL, 'Transport', '2025-05-22 21:01:51', 0),
(3, NULL, 'Utilities', '2025-05-22 21:01:51', 0),
(4, NULL, 'Entertainment', '2025-05-22 21:01:51', 0),
(5, NULL, 'Healthcare', '2025-05-22 21:01:51', 0),
(6, NULL, 'Education', '2025-05-22 21:01:51', 0),
(7, NULL, 'Groceries', '2025-05-22 21:01:51', 0),
(8, NULL, 'Rent', '2025-05-22 21:01:51', 0),
(11, 23, 'Gadgets', '2025-05-22 21:25:44', 2),
(12, 23, 'Gadgets', '2025-05-22 22:28:17', 2),
(14, 23, 'Charity', '2025-05-22 22:31:29', 1),
(15, 23, 'Tax', '2025-05-23 07:54:27', 2),
(16, 23, 'Tax', '2025-05-23 07:55:02', 1),
(17, 23, 'Pet', '2025-05-23 08:44:05', 1),
(18, 23, 'Tour', '2025-05-23 09:31:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE `income` (
  `income_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `income_type` tinyint(4) NOT NULL COMMENT '0 = regular main, 1 = regular side, 2 = irregular',
  `source` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `income_date` date NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `income_status` tinyint(4) DEFAULT 0 COMMENT '0 = active, 1 = deleted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`income_id`, `user_id`, `income_type`, `source`, `amount`, `income_date`, `note`, `created_at`, `income_status`) VALUES
(1, 23, 0, 'Salary', 900000.00, '2025-05-03', 'April Salary', '2025-05-22 16:01:32', 0),
(2, 23, 1, 'Received Rents', 25000.00, '2025-05-02', 'RBMB Rents', '2025-05-22 16:02:59', 0),
(5, 23, 2, 'Babayoga', 150000.00, '2025-05-14', 'Won boxing match!', '2025-05-22 19:55:45', 0),
(6, 23, 2, 'Human Trafficking', 52000.00, '2024-11-06', '2 person', '2025-05-22 19:59:17', 0);

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
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
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

INSERT INTO `users` (`id`, `fname`, `lname`, `id_type`, `id_number`, `passport_expiry`, `country_code`, `phone`, `email`, `password`, `gender`, `dob`, `address`, `photo_path`, `created_at`, `account_status`, `role`) VALUES
(11, 'John', 'Doe', 0, '1234567890', '2028-05-15', '+88', '123456789', 'john.doe@gmail.com', '$2y$10$ZfJJZ3uqoflDBBLeFIynf.dtLBQbG71Qobi0S438LPTEXNlBwvV7W', 0, '1995-08-15', 'Uttara, Dhaka', 'images/john.png', '2025-05-17 14:41:31', 0, 'user'),
(12, 'Jane', 'Doe', 1, 'P1234567', '2028-06-12', '+88', '01777777777', 'jane.doe@gmail.com', 'hashed_password_2', 1, '1997-05-10', '456 Main St, City B', 'images/jane.png', '2025-05-17 14:41:31', 3, 'user'),
(13, 'David', 'Smith', 0, '9876543210', NULL, '+88', '01666666666', 'david.smith@gmail.com', 'hashed_password_3', 0, '1992-11-22', '789 Main St, City C', 'images/david.png', '2025-05-17 14:41:31', 2, 'user'),
(14, 'Emily', 'Brown', 0, '1122334455', NULL, '+88', '01444444444', 'emily.brown@gmail.com', 'hashed_password_4', 1, '2000-01-19', '111 Main St, City D', 'images/emily.png', '2025-05-17 14:41:31', 1, 'user'),
(15, 'Chris', 'Johnson', 1, 'P2233445', '2027-03-18', '+88', '01333333333', 'chris.johnson@gmail.com', 'hashed_password_5', 0, '1998-09-05', '222 Main St, City E', 'images/chris.png', '2025-05-17 14:41:31', 0, 'user'),
(16, 'Sarah', 'Lee', 0, '5566778899', NULL, '+88', '01888888888', 'sarah.lee@gmail.com', 'hashed_password_6', 1, '2001-07-23', '333 Main St, City F', 'images/sarah.png', '2025-05-17 14:41:31', 0, 'user'),
(17, 'Michael', 'Clark', 1, 'P4455667', '2029-11-30', '+88', '01999999999', 'michael.clark@gmail.com', 'hashed_password_7', 0, '1990-03-12', '444 Main St, City G', 'images/michael.png', '2025-05-17 14:41:31', 0, 'user'),
(18, 'Linda', 'Lewis', 0, '2233445566', NULL, '+88', '01222222222', 'linda.lewis@gmail.com', 'hashed_password_8', 1, '1985-12-28', '555 Main St, City H', 'images/linda.png', '2025-05-17 14:41:31', 0, 'user'),
(19, 'Tom', 'Walker', 0, '3344556677', NULL, '+88', '01111111111', 'tom.walker@gmail.com', 'hashed_password_9', 0, '1993-04-15', '666 Main St, City I', 'images/tom.png', '2025-05-17 14:41:31', 0, 'user'),
(20, 'Admin', 'User', 0, '4455667788', NULL, '+88', '01010101010', 'admin@gmail.com', '11111111', 0, '1988-02-20', 'Admin HQ, City J', '../../uploads/admin.jpg', '2025-05-17 14:41:31', 0, 'admin'),
(23, 'Meheraj', 'Hasan', 0, '1111111111', NULL, '+88', '123456789', 'hasanmeheraj639@gmail.com', '$2y$10$W7/WvledZhccGgXVHo8kX.OPPcyfrKDM4SjiHoWoP4dr9SVAbjscC', 0, '2002-10-30', 'Uttara', '../../uploads/hasanmeheraj639.jpeg', '2025-05-21 02:04:47', 0, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expenseID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`income_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `mail` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `income`
--
ALTER TABLE `income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expenses_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD CONSTRAINT `expense_categories_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
