-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 02:49 PM
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
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('active','inactive','on_leave') DEFAULT 'active',
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(100) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `course_id` int(11) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `course_code` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `course_name`, `course_code`) VALUES
(1, 'Bachelor Of Science In Computer Science', 'BSCS'),
(2, 'NONE', 'NONE');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_description` text DEFAULT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `location` varchar(100) NOT NULL,
  `location_status` enum('good','under_maintenance','unavailable') DEFAULT 'good',
  `location_notes` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `creation_status` enum('pending','approved','denied') DEFAULT 'pending',
  `progress_status` enum('pending','scheduled','postponed','cancelled','delayed') DEFAULT 'pending',
  `completion_status` enum('not_started','in_progress','finished','cancelled') DEFAULT 'not_started',
  `updated_details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `date`, `start_time`, `end_time`, `location`, `location_status`, `location_notes`, `created_by`, `reviewed_by`, `creation_status`, `progress_status`, `completion_status`, `updated_details`, `created_at`, `capacity`) VALUES
(4, 'Tech Conference 2025', 'A conference showcasing the latest in technology trends.', '2025-12-30', '09:30:00', '17:00:00', 'Convention Center', 'good', NULL, 2, 1, 'denied', 'cancelled', 'not_started', NULL, '2024-11-26 10:41:48', 130),
(5, 'Annual Company Meeting', 'A mandatory meeting for all employees.', '2024-12-19', '10:00:00', '13:00:00', 'Office HQ Boardroom', 'good', 'Refreshments provided.', 2, 1, 'pending', 'pending', 'not_started', NULL, '2024-11-26 10:42:09', 150),
(6, 'Annual Tech Symposium', 'A symposium focusing on emerging tech trends and innovations.', '2025-06-15', '08:30:00', '17:00:00', 'Tech Hub Auditorium', 'good', NULL, 10, 1, 'approved', 'scheduled', 'not_started', NULL, '2024-11-30 12:17:05', 200),
(7, 'Session', '', '2024-12-29', '10:00:00', '12:00:00', 'Bahay Ni Yan Mark', 'good', NULL, 2, 1, 'pending', 'pending', 'not_started', NULL, '2024-12-01 08:51:53', 10);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` datetime DEFAULT current_timestamp(),
  `title` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `sender_id`, `receiver_id`, `message`, `status`, `created_at`, `title`) VALUES
(1, 2, 3, 'You have successfully reserved your spot for the upcoming event \"Tech Conference 2024\".', 'unread', '2024-11-28 15:13:39', 'Reservation Confirmed'),
(2, 2, 3, 'Reminder: Your reservation for \"Tech Conference 2024\" is coming up in 2 days. Don\'t forget to attend!', 'unread', '2024-11-28 15:13:39', 'Event Reminder'),
(3, 2, 3, 'Your reservation for \"Tech Conference 2024\" has been canceled due to unforeseen circumstances.', 'read', '2024-11-28 15:13:39', 'Reservation Canceled');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `reservation_status` enum('confirmed','cancelled','pending') DEFAULT 'pending',
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `user_id`, `event_id`, `reservation_status`, `reservation_date`) VALUES
(1, 3, 4, 'pending', '2024-11-28 12:45:08'),
(5, 3, 5, 'pending', '2024-11-29 05:22:32'),
(6, 3, 7, 'pending', '2024-12-01 10:14:05'),
(7, 3, 6, 'pending', '2024-12-01 11:40:30');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `status` enum('active','inactive','on_leave') DEFAULT 'active',
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `assigned_events` text DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL DEFAULT 0,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(30) DEFAULT NULL,
  `level` int(11) DEFAULT 0,
  `role` enum('admin','staff','user') NOT NULL DEFAULT 'user',
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `course_id`, `username`, `password`, `first_name`, `last_name`, `middle_name`, `level`, `role`, `email`, `phone_number`, `created_at`) VALUES
(1, 2, 'ace123', '$2y$10$IUZQpiIEt2jSybsHYrvoJOc.ZVGNlV7.KARCGXtEcdWE.JKUr1Lvq', 'Ace John', 'Nieva', 'Malunes', 0, 'admin', 'acejohnz112@gmail.com', '09659523730', '2024-11-26 04:10:26'),
(2, 2, 'yan123', '$2y$10$EQKReUGMwsooxpRt4jEM7uRPtPDJpzCJoh2rlhSjx0w19Kjf1L83u', 'Yan Mark', 'Darunday', 'Villas', 0, 'staff', 'yanmark@gmail.com', '09123456789', '2024-11-26 04:46:59'),
(3, 1, 'fra123', '$2y$10$lSoX9lgnV4j1dHaztAHIrOqrEaQtIh9AwxruVEmLdhGVF4b/RNwlW', 'Franco Adrianne', 'Ceniza', 'Tiez', 2, 'user', 'franco@gmail.com', '09987654321', '2024-11-26 04:47:23'),
(4, 1, 'user1', 'password1', 'John', 'Doe', 'M', 1, 'user', 'john.doe@example.com', '09171234567', '2024-11-29 11:30:23'),
(5, 1, 'user11', 'password2', 'Jane', 'Smith', 'L', 2, 'user', 'jane.smith@example.com', '09182345678', '2024-11-29 11:30:23'),
(6, 1, 'user3', 'password3', 'Alice', 'Johnson', 'K', 3, 'user', 'alice.johnson@example.com', '09193456789', '2024-11-29 11:30:23'),
(7, 1, 'user4', 'password4', 'Bob', 'Brown', 'H', 4, 'user', 'bob.brown@example.com', '09204567890', '2024-11-29 11:30:23'),
(8, 1, 'user5', 'password5', 'Charlie', 'Davis', 'P', 1, 'user', 'charlie.davis@example.com', '09215678901', '2024-11-29 11:30:23'),
(10, 2, 'staff', '$2y$10$krW5ao6RGm/Cky6j06tD8.aSv3sr77rxis2CAbnrJf4H1wLsCuhJ2', 'staff', 'staff', NULL, 0, 'staff', 'staff@gmail.com', '123456789', '2024-11-30 12:12:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `reviewed_by` (`reviewed_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sender_id` (`sender_id`),
  ADD KEY `fk_receiver_id` (`receiver_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_receiver_id` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_sender_id` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;