-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2024 at 07:24 AM
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
-- Database: `student_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `time_in` time NOT NULL,
  `time_out` time NOT NULL,
  `attendance_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `event_id`, `student_number`, `student_name`, `course`, `time_in`, `time_out`, `attendance_date`) VALUES
(34, 40, '202400123', 'Torres, Isabel J.', '', '14:20:00', '16:20:00', '2024-12-12 06:20:59'),
(35, 40, '202400234', 'Cruz, Ana D.', '', '14:23:00', '19:21:00', '2024-12-12 06:21:21'),
(36, 40, '202400333', 'Castillo, Diana N.', '', '14:24:00', '14:26:00', '2024-12-12 06:21:32'),
(37, 40, '202400456', 'Reyes, Maria L.', '', '14:26:00', '14:27:00', '2024-12-12 06:21:43'),
(38, 35, '202400456', 'Reyes, Maria L.', '', '08:22:00', '14:22:00', '2024-12-12 06:22:50'),
(39, 35, '202300456', 'Mendoza, Paulo K.', '', '10:25:00', '14:23:00', '2024-12-12 06:23:10'),
(40, 35, '202400555', 'Gutierrez, Ella P.', '', '13:23:00', '18:23:00', '2024-12-12 06:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `attendance_logs`
--

CREATE TABLE `attendance_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `attendance_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_logs`
--

INSERT INTO `attendance_logs` (`id`, `user_id`, `action`, `attendance_id`, `description`, `timestamp`) VALUES
(15, 1, 'add', 34, 'Added attendance for student: Torres, Isabel J.', '2024-12-12 14:20:59'),
(16, 1, 'update', 34, 'Updated attendance for student: Torres, Isabel J.', '2024-12-12 14:21:05'),
(17, 1, 'add', 35, 'Added attendance for student: Cruz, Ana D.', '2024-12-12 14:21:22'),
(18, 1, 'add', 36, 'Added attendance for student: Castillo, Diana N.', '2024-12-12 14:21:32'),
(19, 1, 'add', 37, 'Added attendance for student: Reyes, Maria L.', '2024-12-12 14:21:43'),
(20, 3, 'add', 38, 'Added attendance for student: Reyes, Maria L.', '2024-12-12 14:22:50'),
(21, 3, 'add', 39, 'Added attendance for student: Mendoza, Paulo K.', '2024-12-12 14:23:10'),
(22, 3, 'add', 40, 'Added attendance for student: Gutierrez, Ella P.', '2024-12-12 14:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `organizers` varchar(255) DEFAULT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `event_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `organizers`, `starttime`, `endtime`, `venue`, `event_date`) VALUES
(35, 'Tech Symposium', 'Annual tech symposium for IT students.', 'WMSU CCS', '08:00:00', '17:00:00', 'WMSU Auditorium', '2024-10-15'),
(36, 'Hackathon 2024', '24-hour coding competition.', 'WMSU GDG', '09:00:00', '09:00:00', 'Computer Lab 1', '2024-11-25'),
(37, 'Career Fair', 'Meet potential employers and learn about careers.', 'KadaKareer', '10:00:00', '16:00:00', 'WMSU Gym', '2024-12-01'),
(38, 'Webinar: AI Trends', 'Discussing the latest trends in AI.', 'AI Society', '14:00:00', '16:00:00', 'Online', '2024-12-03'),
(39, 'Project Showcase', 'Showcase student projects.', 'WMSU CCS Faculty', '13:00:00', '17:00:00', 'LR 3', '2024-12-05'),
(40, 'New Year Kick-off', 'Kick-off event for the new year.', 'WMSU Admin', '09:00:00', '12:00:00', 'WMSU Hall', '2025-01-10'),
(41, 'Tech Bootcamp', 'Hands-on training in web development.', 'GDG Zamboanga', '08:00:00', '17:00:00', 'Computer Lab 2', '2025-01-20'),
(42, 'Innovation Summit', 'Discussing innovations in tech.', 'Innovation Hub', '09:00:00', '15:00:00', 'WMSU Auditorium', '2025-02-05'),
(43, 'Leadership Training', 'Training for student leaders.', 'Student Council', '10:00:00', '16:00:00', 'LR 5', '2025-02-15');

-- --------------------------------------------------------

--
-- Table structure for table `event_logs`
--

CREATE TABLE `event_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_logs`
--

INSERT INTO `event_logs` (`id`, `user_id`, `action`, `event_id`, `description`, `timestamp`) VALUES
(35, 1, 'update', 37, 'Updated event: Career Fair', '2024-12-12 14:11:21'),
(36, 1, 'update', 43, 'Updated event: Leadership Training', '2024-12-12 14:11:30'),
(37, 1, 'update', 39, 'Updated event: Project Showcase', '2024-12-12 14:11:41'),
(38, 1, 'delete', NULL, 'Deleted event: Tech Conference 2025', '2024-12-12 14:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_number` varchar(20) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year_level` int(11) NOT NULL,
  `section` text NOT NULL,
  `birthdate` date NOT NULL,
  `sex` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `wmsu_email` varchar(255) NOT NULL,
  `personal_email` varchar(255) NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_number`, `last_name`, `first_name`, `middle_name`, `course`, `year_level`, `section`, `birthdate`, `sex`, `address`, `wmsu_email`, `personal_email`, `status`) VALUES
(3, '202300727', 'Cassion', 'Ethan Wayne', 'Nodado', 'Computer Science', 2, 'A', '2005-12-04', 'Male', 'a', 'hz202300727@email.com', 'cassionethanwayne@gmail.com', 'Regular'),
(4, '202302172', 'Seupon', 'Paul', 'Patigayon', 'Computer Science', 2, 'A', '2005-04-08', 'Male', 'random address', 'a@email.com', 'a@email.com', 'Regular'),
(16, '202300123', 'Garcia', 'Juan', 'M.', 'BSIT', 2, 'A', '2004-05-12', 'M', 'Zamboanga City', 'juan.garcia@wmsu.edu.ph', 'juan.garcia@example.com', 'Regular'),
(17, '202400456', 'Reyes', 'Maria', 'L.', 'BSCS', 1, 'B', '2005-07-20', 'F', 'Pagadian City', 'maria.reyes@wmsu.edu.ph', 'maria.reyes@example.com', 'Regular'),
(18, '202300789', 'Santos', 'Pedro', 'C.', 'BSIS', 3, 'C', '2003-11-15', 'M', 'Dipolog City', 'pedro.santos@wmsu.edu.ph', 'pedro.santos@example.com', 'Irregular'),
(19, '202400234', 'Cruz', 'Ana', 'D.', 'BSECE', 1, 'D', '2006-01-25', 'F', 'Davao City', 'ana.cruz@wmsu.edu.ph', 'ana.cruz@example.com', 'Regular'),
(20, '202300567', 'Lopez', 'Carlos', 'E.', 'BSIT', 2, 'A', '2004-03-10', 'M', 'Iligan City', 'carlos.lopez@wmsu.edu.ph', 'carlos.lopez@example.com', 'Regular'),
(21, '202400890', 'Martinez', 'Luisa', 'F.', 'BSCS', 1, 'B', '2005-09-05', 'F', 'Cagayan de Oro', 'luisa.martinez@wmsu.edu.ph', 'luisa.martinez@example.com', 'Regular'),
(22, '202300345', 'Hernandez', 'Miguel', 'G.', 'BSIS', 3, 'C', '2003-06-18', 'M', 'General Santos', 'miguel.hernandez@wmsu.edu.ph', 'miguel.hernandez@example.com', 'Irregular'),
(23, '202400678', 'Ramos', 'Julia', 'H.', 'BSECE', 1, 'D', '2006-04-11', 'F', 'Butuan City', 'julia.ramos@wmsu.edu.ph', 'julia.ramos@example.com', 'Regular'),
(24, '202300910', 'Aquino', 'Nico', 'I.', 'BSIT', 2, 'A', '2004-08-23', 'M', 'Tacloban City', 'nico.aquino@wmsu.edu.ph', 'nico.aquino@example.com', 'Regular'),
(25, '202400123', 'Torres', 'Isabel', 'J.', 'BSCS', 1, 'B', '2005-10-14', 'F', 'Tagum City', 'isabel.torres@wmsu.edu.ph', 'isabel.torres@example.com', 'Regular'),
(26, '202300456', 'Mendoza', 'Paulo', 'K.', 'BSIS', 3, 'C', '2003-12-30', 'M', 'Zamboanga City', 'paulo.mendoza@wmsu.edu.ph', 'paulo.mendoza@example.com', 'Irregular'),
(27, '202400789', 'Villanueva', 'Sofia', 'L.', 'BSECE', 1, 'D', '2006-02-19', 'F', 'Davao del Sur', 'sofia.villanueva@wmsu.edu.ph', 'sofia.villanueva@example.com', 'Regular'),
(28, '202300222', 'Delos Reyes', 'Marco', 'M.', 'BSIT', 2, 'A', '2004-11-03', 'M', 'Cebu City', 'marco.delosreyes@wmsu.edu.ph', 'marco.delosreyes@example.com', 'Regular'),
(29, '202400333', 'Castillo', 'Diana', 'N.', 'BSCS', 1, 'B', '2005-12-09', 'F', 'Bacolod City', 'diana.castillo@wmsu.edu.ph', 'diana.castillo@example.com', 'Regular'),
(30, '202300444', 'Navarro', 'Rico', 'O.', 'BSIS', 3, 'C', '2003-07-15', 'M', 'Manila', 'rico.navarro@wmsu.edu.ph', 'rico.navarro@example.com', 'Irregular'),
(31, '202400555', 'Gutierrez', 'Ella', 'P.', 'BSECE', 1, 'D', '2006-03-27', 'F', 'Quezon City', 'ella.gutierrez@wmsu.edu.ph', 'ella.gutierrez@example.com', 'Regular'),
(32, '202300666', 'Bautista', 'Leon', 'Q.', 'BSIT', 2, 'A', '2004-02-17', 'M', 'Pampanga', 'leon.bautista@wmsu.edu.ph', 'leon.bautista@example.com', 'Regular'),
(33, '202400777', 'Fernandez', 'Lara', 'R.', 'BSCS', 1, 'B', '2005-11-21', 'F', 'Baguio City', 'lara.fernandez@wmsu.edu.ph', 'lara.fernandez@example.com', 'Regular'),
(34, '202300888', 'Morales', 'Jorge', 'S.', 'BSIS', 3, 'C', '2003-05-07', 'M', 'Zamboanga Sibugay', 'jorge.morales@wmsu.edu.ph', 'jorge.morales@example.com', 'Irregular'),
(35, '202400999', 'Roxas', 'Clarissa', 'T.', 'BSECE', 1, 'D', '2006-06-30', 'F', 'Iloilo City', 'clarissa.roxas@wmsu.edu.ph', 'clarissa.roxas@example.com', 'Regular'),
(36, '202301754', 'Etac', 'Eros Denz', 'Labrador', 'BSCS', 2, 'A', '2005-06-29', 'Male', 'random address', 'hz202301754@wmsu.edu.ph', 'soredenz@gmail.com', 'Regular');

-- --------------------------------------------------------

--
-- Table structure for table `student_logs`
--

CREATE TABLE `student_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(50) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_logs`
--

INSERT INTO `student_logs` (`id`, `user_id`, `action`, `student_id`, `description`, `timestamp`) VALUES
(12, 1, 'update', 3, 'Updated student: Ethan Wayne Cassion', '2024-12-12 14:18:10'),
(13, 1, 'add', 36, 'Added student: Eros Denz Etac', '2024-12-12 14:19:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','officer') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$JQq8S0KIrdPAW9SxCK6S7uzYACIVk3fbswfJbeSjYWiQvUO63JXvS', 'admin'),
(3, 'officer', '$2y$10$cbeF/itGRnd/ymnFUeV/3OSK4IKkpxZhTL7uzc5sqL/Yq.95Qsfb.', 'officer'),
(15, 'vlad', '$2y$10$QUc.NfINjGghqRLcmfbIf.LhsrrBExLq4IujxHtS/YZlLw8f0OmcS', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_ibfk_1` (`event_id`);

--
-- Indexes for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `attendance_logs_ibfk_2` (`attendance_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_logs`
--
ALTER TABLE `event_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_logs_ibfk_2` (`event_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_logs`
--
ALTER TABLE `student_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `student_logs_ibfk_2` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `event_logs`
--
ALTER TABLE `event_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `student_logs`
--
ALTER TABLE `student_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_logs`
--
ALTER TABLE `attendance_logs`
  ADD CONSTRAINT `attendance_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `attendance_logs_ibfk_2` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `event_logs`
--
ALTER TABLE `event_logs`
  ADD CONSTRAINT `event_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `event_logs_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `student_logs`
--
ALTER TABLE `student_logs`
  ADD CONSTRAINT `student_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `student_logs_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
