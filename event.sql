-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 06:45 PM
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
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `user_id`, `status`, `date_joined`, `last_updated`) VALUES
(1, 1, 'active', '2024-12-10 08:28:41', '2024-12-10 08:28:41');

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
(2, 'Bachelors Of Science In Information Technology', 'BSIT'),
(3, 'NONE', 'NONE');

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
  `progress_status` enum('pending','scheduled','cancelled','rescheduled') DEFAULT 'pending',
  `completion_status` enum('not_started','in_progress','finished','cancelled') DEFAULT 'not_started',
  `updated_details` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_capacity` int(11) NOT NULL,
  `available_capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_description`, `date`, `start_time`, `end_time`, `location`, `location_status`, `location_notes`, `created_by`, `reviewed_by`, `creation_status`, `progress_status`, `completion_status`, `updated_details`, `created_at`, `total_capacity`, `available_capacity`) VALUES
(4, 'Tech Conference 2025', 'A conference showcasing the latest in technology trends.', '2024-12-30', '09:30:00', '17:10:00', 'Convention Center', 'good', NULL, 2, 1, 'pending', 'pending', 'not_started', NULL, '2024-11-26 10:41:48', 130, 124),
(5, 'Annual Company Meeting', 'A mandatory meeting for all employees.', '2024-12-13', '10:00:00', '13:25:00', 'Office HQ Boardroom', 'good', 'Refreshments provided.', 2, 1, 'pending', 'pending', 'not_started', NULL, '2024-11-26 10:42:09', 150, 146),
(6, 'Annual Tech Symposium', 'A symposium focusing on emerging tech trends and innovations.', '2025-06-15', '08:30:00', '17:00:00', 'Tech Hub Auditorium', 'good', NULL, 10, 1, 'pending', 'pending', 'not_started', NULL, '2024-11-30 12:17:05', 200, 190);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_type` enum('event_update','reservation_update','system_message') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `reservation_status` enum('confirmed','cancelled','pending') DEFAULT 'pending',
  `reservation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `present` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `assigned_events` text DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `user_id`, `department`, `status`, `date_joined`, `assigned_events`, `last_updated`) VALUES
(1, 2, 'College of Computing Studies', 'active', '2024-12-10 08:31:39', NULL, '2024-12-10 08:31:39'),
(2, 10, 'College of Computing Studies', 'active', '2024-12-10 08:32:34', NULL, '2024-12-10 08:32:34');

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
  `role` enum('admin','user','organizer') NOT NULL DEFAULT 'user',
  `email` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `course_id`, `username`, `password`, `first_name`, `last_name`, `middle_name`, `level`, `role`, `email`, `phone_number`, `created_at`) VALUES
(1, 1, 'ace123', '$2y$10$0WPZynXx.3PNIvNRE6CFaeW6069ICCvkqLCR6DAlx.pfIBve0reF.', 'Ace John', 'Nieva', 'Malunes', 0, 'admin', 'acejohnz112@gmail.com', '09659523730', '2024-11-26 04:10:26'),
(2, 1, 'yan123', '$2y$10$Un/W7kUZB5BpfUtN4HQTqeZsRimfpo/QDJZszD.pPFCTNCdYwzpny', 'Yan Mark', 'Darunday', 'Villas', 2, 'organizer', 'yanmark@gmail.com', '09123456789', '2024-11-26 04:46:59'),
(3, 1, 'fra123', '$2y$10$ivdb6bEiVGExNBY.lpobSe/yDRs60scK1x0J0kyQOKT8er2kfgt0K', 'Franco Adrianne', 'Ceniza', 'HAHA', 2, 'user', 'franco@gmail.com', '09987654321', '2024-11-26 04:47:23'),
(10, 1, 'pao123', '$2y$10$f8ydKwnDYoUcHo/upOBrsOkAulK61pL8/VAZJ7y89rPwEQ6OPu956', 'Paolo Lorenzo', 'Longcob', 'Rice', 2, 'organizer', 'staff@gmail.com', '123456789', '2024-11-30 12:12:06');

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
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE;

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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
