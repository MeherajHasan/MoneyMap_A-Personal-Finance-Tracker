-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 26, 2025 at 05:56 AM
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
-- Table structure for table `debt`
--

CREATE TABLE `debt` (
  `debt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `debt_name` varchar(100) NOT NULL,
  `payee_name` varchar(100) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `debt_date` date NOT NULL,
  `max_pay_date` date NOT NULL,
  `interest_rate` decimal(5,2) DEFAULT 0.00,
  `min_payment` decimal(10,2) DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = Payable, 1 = Fully Paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `debt`
--

INSERT INTO `debt` (`debt_id`, `user_id`, `debt_name`, `payee_name`, `total_amount`, `paid_amount`, `debt_date`, `max_pay_date`, `interest_rate`, `min_payment`, `notes`, `status`) VALUES
(1, 23, 'Car Loan', 'AutoFinance Corp', 15000.00, 3500.00, '2024-01-15', '2026-01-15', 5.50, 300.00, 'Monthly payments ongoing', 0),
(2, 23, 'Credit Card', 'BankPlus', 3200.00, 1200.00, '2024-03-10', '2025-03-10', 19.90, 150.00, 'Try to clear in 6 months', 0),
(3, 23, 'Personal Loan', 'QuickCash Inc.', 5000.00, 5000.00, '2023-06-01', '2024-06-01', 12.00, 250.00, 'Paid off early', 1),
(4, 23, 'Home Renovation', 'RenovateNow', 8000.00, 2000.00, '2024-05-01', '2026-05-01', 6.50, 275.00, 'Used for kitchen upgrade', 0),
(5, 23, 'Medical Bills', 'HealthCare Central', 4200.00, 1500.00, '2023-12-20', '2024-12-20', 0.00, 200.00, 'No interest on balance', 0),
(6, 23, 'Business Loan', 'StartUpFund', 20000.00, 18000.00, '2022-08-15', '2025-08-15', 8.50, 500.00, 'Almost done', 0),
(7, 23, 'Furniture Financing', 'HomeStyle Ltd.', 2800.00, 2800.00, '2023-01-05', '2024-01-05', 4.00, 233.33, 'Paid in full', 1),
(8, 23, 'Education Loan', 'EduFund', 10000.00, 3500.00, '2023-09-01', '2027-09-01', 7.00, 275.00, 'Used for online course', 0),
(9, 23, 'Vacation Debt', 'TravelNow PayLater', 3500.00, 1000.00, '2023-11-20', '2024-11-20', 10.00, 250.00, 'Trip to Europe', 0),
(10, 23, 'Laptop EMI', 'TechZone', 1500.00, 1500.00, '2023-04-10', '2023-10-10', 0.00, 250.00, 'Fully paid in 6 EMIs', 1),
(11, 23, 'Dhar korsi', 'ABC Bank', 5000.00, 0.00, '2025-04-28', '2025-06-07', 5.00, 1000.00, 'back dibo bro', 0);

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
-- Table structure for table `savings`
--

CREATE TABLE `savings` (
  `savings_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `goal_name` varchar(100) NOT NULL,
  `target_amount` decimal(10,2) NOT NULL,
  `saved_amount` decimal(10,2) DEFAULT 0.00,
  `start_date` date DEFAULT curdate(),
  `target_date` date NOT NULL,
  `note` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT '0 = deleted, 1 = active, 2 = reversed',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savings`
--

INSERT INTO `savings` (`savings_id`, `user_id`, `goal_name`, `target_amount`, `saved_amount`, `start_date`, `target_date`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 23, 'Emergency Fund', 5000.00, 200.00, '2025-05-26', '2025-12-31', 'For unexpected expenses', 1, '2025-05-26 01:56:45', '2025-05-26 08:52:45'),
(2, 23, 'Vacation in Bali', 3000.00, 1500.00, '2025-05-26', '2025-08-15', 'Trip with friends', 1, '2025-05-26 01:56:45', '2025-05-26 05:40:36'),
(3, 23, 'New Laptop', 1500.00, 1500.00, '2025-05-26', '2025-06-10', 'Already reached the goal', 2, '2025-05-26 01:56:45', '2025-05-26 05:41:24'),
(4, 23, 'Car Down Payment', 10000.00, 10000.00, '2025-05-26', '2026-01-01', 'Planning to buy a used car', 2, '2025-05-26 01:56:45', '2025-05-26 05:41:52'),
(5, 23, 'Online Course Fund', 1000.00, 500.00, '2025-05-26', '2025-05-30', 'Half Stack Development Course', 1, '2025-05-26 01:56:45', '2025-05-26 08:54:16'),
(6, 23, 'Gift Savings', 500.00, 100.00, '2025-05-26', '2025-12-20', 'Holiday gifts for family', 1, '2025-05-26 01:56:45', '2025-05-26 05:41:03'),
(7, 23, 'New Phone', 1800.00, 0.00, '2025-05-26', '2025-10-30', 'Buy iPhone 17 Pro Max', 1, '2025-05-26 03:28:11', '2025-05-26 05:28:57');

-- --------------------------------------------------------

--
-- Table structure for table `savings_transactions`
--

CREATE TABLE `savings_transactions` (
  `transaction_id` int(11) NOT NULL,
  `savings_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `transaction_date` datetime DEFAULT current_timestamp(),
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savings_transactions`
--

INSERT INTO `savings_transactions` (`transaction_id`, `savings_id`, `amount`, `transaction_date`, `note`) VALUES
(1, 1, 500.00, '2025-05-26 01:57:36', 'Initial deposit'),
(2, 1, 300.00, '2025-05-26 01:57:36', 'Monthly contribution'),
(3, 1, 400.00, '2025-05-26 01:57:36', 'Bonus added'),
(4, 2, 1000.00, '2025-05-26 01:57:36', 'Saved from salary'),
(5, 2, 500.00, '2025-05-26 01:57:36', 'Freelance earnings'),
(6, 3, 1500.00, '2025-05-26 01:57:36', 'One-time transfer'),
(7, 4, 1000.00, '2025-05-26 01:57:36', 'Monthly savings'),
(8, 4, 1500.00, '2025-05-26 01:57:36', 'Tax refund contribution'),
(9, 5, 400.00, '2025-05-26 01:57:36', 'Part-time job income'),
(10, 5, 400.00, '2025-05-26 01:57:36', 'Extra savings'),
(11, 6, 50.00, '2025-05-26 01:57:36', 'Started saving for gifts'),
(12, 2, 100.00, '2025-05-28 00:00:00', ''),
(13, 6, 50.00, '2025-05-14 00:00:00', ''),
(14, 1, 300.00, '2025-05-16 00:00:00', ''),
(15, 2, 1400.00, '2025-05-20 00:00:00', ''),
(16, 6, 50.00, '2025-05-14 00:00:00', ''),
(17, 1, 3500.00, '2025-05-12 00:00:00', ''),
(18, 5, 200.00, '2025-05-21 00:00:00', ''),
(19, 2, 1500.00, '2025-05-21 00:00:00', ''),
(20, 3, 500.00, '2025-05-14 00:00:00', ''),
(21, 4, 7500.00, '2025-05-09 00:00:00', '');

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
(23, 'Meheraj', 'Hasan', 0, '1111111111', NULL, '+88', '123456789', 'hasanmeheraj639@gmail.com', '$2y$10$W7/WvledZhccGgXVHo8kX.OPPcyfrKDM4SjiHoWoP4dr9SVAbjscC', 0, '2002-10-30', 'Uttara', '../../uploads/hasanmeheraj639.jpeg', '2025-05-21 02:04:47', 0, 'user'),
(25, 'Junky', 'Oggy', 0, '0000000000', '0000-00-00', '+65', '123456789', 'junkyoggy@gmail.com', '$2y$10$lhuJn1HyYX7QZHF3CxjOrOPiZwitZycajd9sEqWOuvq7XPex2tU3C', 0, '1999-02-09', 'Khilkhet', '../../uploads/junkyoggy.jpg', '2025-05-23 16:46:01', 3, 'user'),
(26, 'Admin', 'Hasan', 0, '1111100000', '0000-00-00', '+88', '123456789', 'admin@gmail.com', '$2y$10$afajkcI/LswC4WObRITFt.xmqVyN1UwNe2ouD9maBVCbSXUEh25Fi', 0, '2002-10-30', 'Kuratoli', '../../uploads/admin.jpg', '2025-05-24 20:36:38', 0, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `debt`
--
ALTER TABLE `debt`
  ADD PRIMARY KEY (`debt_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`savings_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `savings_id` (`savings_id`);

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
-- AUTO_INCREMENT for table `debt`
--
ALTER TABLE `debt`
  MODIFY `debt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
-- AUTO_INCREMENT for table `savings`
--
ALTER TABLE `savings`
  MODIFY `savings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `debt`
--
ALTER TABLE `debt`
  ADD CONSTRAINT `debt_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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

--
-- Constraints for table `savings`
--
ALTER TABLE `savings`
  ADD CONSTRAINT `savings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `savings_transactions`
--
ALTER TABLE `savings_transactions`
  ADD CONSTRAINT `savings_transactions_ibfk_1` FOREIGN KEY (`savings_id`) REFERENCES `savings` (`savings_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
