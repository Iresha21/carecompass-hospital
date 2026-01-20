-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 01, 2025 at 01:50 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `CareCompassHospitals`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `contact_info` varchar(255) NOT NULL,
  `appointment_date` datetime NOT NULL,
  `status` enum('Scheduled','Completed','Cancelled') DEFAULT 'Scheduled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `doctor_id`, `patient_name`, `contact_info`, `appointment_date`, `status`) VALUES
(4, 5, 'thivina dinujaya', '0776181572', '2025-03-04 10:15:00', 'Scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `specialty` varchar(100) NOT NULL,
  `qualifications` text NOT NULL,
  `contact_info` varchar(100) DEFAULT NULL,
  `available_days` varchar(100) DEFAULT NULL,
  `available_time` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `full_name`, `specialty`, `qualifications`, `contact_info`, `available_days`, `available_time`, `created_at`, `image`) VALUES
(4, 'Dr.John Smith', 'Cardiology', 'MBBS(UK) , Phd(UK)', '2345678901', 'Monday-Friday', '10:00 AM - 2:00 PM', '2025-03-01 12:16:14', 'uploads/doctors/1740831374_cardio1.jpg'),
(5, 'Dr. Kelly Dover', 'Cardiology', 'MBBBS(Eng), MBA(UK)', '7766554433', 'Monday-Wednesday', '9:00 AM - 1:00 PM', '2025-03-01 12:17:37', 'uploads/doctors/1740831457_cardio2.jpg'),
(6, 'Dr. Duke Kal', 'Neurology', 'MBA(UK), Phd(UK)', '1122334455', 'Monday-Tuesday', '10:00 AM - 12:00 PM', '2025-03-01 12:20:13', 'uploads/doctors/1740831613_neuro1.jpg'),
(7, 'Dr. Jack Smith', 'Neurology', 'MBBBS(UK), MBA, Phd', '2211445588', 'Monday', '8:00 AM - 11:00 AM', '2025-03-01 12:21:26', 'uploads/doctors/1740831686_neuro2.jpg'),
(8, 'Dr. Jake Paul', 'Orthopedics', 'MBA(UK)', '776181900', 'Monday-Thursday', '10:00 AM - 11:00 AM', '2025-03-01 12:22:43', 'uploads/doctors/1740831763_ortho1.jpg'),
(9, 'Dr. Logan Mike', 'Orthopedics', 'MBA(UK), Phd(Eng)', '7771234567', 'Saturday-Sunday', '1:00 PM - 3:00 PM', '2025-03-01 12:23:40', 'uploads/doctors/1740831820_ortho2.jpg'),
(10, 'Dr. Emily Stella', 'Pediatrics', 'MBBS', '7761230088', 'Monday-Wednesday', '4:00 PM - 6:00 PM', '2025-03-01 12:25:13', 'uploads/doctors/1740831913_ped1.jpg'),
(11, 'Dr. Shilly Kart', 'Pediatrics', 'MBBS(UK) , Phd(UK)', '0112345678', 'Monday-Friday', '9:00 AM - 1:00 PM', '2025-03-01 12:26:34', 'uploads/doctors/1740831994_ped2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `id` int(11) NOT NULL,
  `receipt_number` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`id`, `receipt_number`, `file_path`, `uploaded_at`) VALUES
(1, '12345', 'uploads/medical_records/1740148456_med.docx', '2025-02-21 14:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Completed','Failed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_registrations`
--

CREATE TABLE `service_registrations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `service` varchar(255) NOT NULL,
  `receipt_number` varchar(50) NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `registered_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('Pending','Paid') DEFAULT 'Pending',
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_registrations`
--

INSERT INTO `service_registrations` (`id`, `name`, `phone`, `address`, `service`, `receipt_number`, `registration_date`, `registered_at`, `payment_status`, `amount`) VALUES
(1, 'thivina', '0776181572', '188,inigala road', 'Diabetes Scan', 'REC-32831D22', '2025-02-22 15:07:00', '2025-02-22 15:13:31', 'Pending', 2500.00),
(2, 'iresha ', '0776181572', '188,inigala road', 'Blood Test', 'REC-1A1CCFE6', '2025-02-22 15:09:38', '2025-02-22 15:13:31', 'Pending', NULL),
(3, 'isuru', '0776181572', '188,inigala road', '', 'RCPT-1740243285882', '2025-02-22 16:54:45', '2025-02-22 16:54:45', 'Paid', 2500.00),
(4, 'ella', '0776181572', '188,inigala road,katugasthota', '', 'RCPT-1740243732993', '2025-02-22 17:02:12', '2025-02-22 17:02:12', 'Paid', 2500.00),
(5, 'jack', '0776181572', '188,inigala road,katugasthota', '', 'RCPT-1740243862550', '2025-02-22 17:04:22', '2025-02-22 17:04:22', 'Pending', 100.00),
(6, 'jake', '0776181572', '188,inigala road', 'Diabetes Scan', 'RCPT-1740244041639', '2025-02-22 17:07:21', '2025-02-22 17:07:21', 'Paid', 3000.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','patient') NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `role`, `phone`, `address`, `created_at`) VALUES
(3, 'thivina dinujaya', 'thivi12@gmail.com', '$2y$10$XnLuMAG1jnmcfoTlOqoIEuxjdA5CvuPqwEpynpq1BzLqrGlP4xJuK', 'admin', '0771681572', '188,inigala road', '2025-02-21 07:32:13'),
(5, 'kanchana galagoda', 'kan1@gmail.com', '$2y$10$wCSynLr7M8zTpSJaWQAQpuPaB6b0ksL0zbKSvJ0sJ8SpTFSOqMUcq', 'staff', NULL, NULL, '2025-02-21 14:18:29'),
(6, 'iresha dushmantha', 'iresh12@gmail.com', '$2y$10$ZTGpl7rRotgO8drVynM6Ruu0JDzu2mot.GTU3rmrftI70HLL4o8nK', 'staff', NULL, NULL, '2025-03-01 12:46:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receipt_number` (`receipt_number`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `service_registrations`
--
ALTER TABLE `service_registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `receipt_number` (`receipt_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_registrations`
--
ALTER TABLE `service_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
