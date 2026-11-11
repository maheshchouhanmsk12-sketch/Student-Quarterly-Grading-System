-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2022 at 08:26 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sqgs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_list`
--

CREATE TABLE `admin_list` (
  `admin_id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_list`
--

INSERT INTO `admin_list` (`admin_id`, `fullname`, `username`, `password`, `status`, `date_created`) VALUES
(1, 'Administrator', 'admin', '0192023a7bbd73250516f069df18b500', 1, '2022-02-11 05:24:55'),
(2, 'User 1', 'user1', '24c9e15e52afc47c225b757e7bee1f9d', 1, '2022-02-11 06:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_list`
--

CREATE TABLE `assessment_list` (
  `assessment_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL,
  `component_id` int(30) NOT NULL,
  `quarter` int(30) NOT NULL,
  `name` text NOT NULL,
  `hps` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `assessment_list`
--

INSERT INTO `assessment_list` (`assessment_id`, `class_id`, `component_id`, `quarter`, `name`, `hps`) VALUES
(1, 6, 2, 1, 'P1', 100),
(2, 6, 3, 1, 'EXAM1', 100),
(3, 6, 1, 1, 'W1', 50),
(4, 6, 1, 1, 'W2', 75),
(5, 6, 1, 1, 'W3', 100),
(6, 6, 1, 1, 'W4', 100),
(7, 6, 2, 1, 'P2', 100),
(8, 6, 2, 2, 'P1', 100),
(9, 6, 2, 2, 'P2', 100),
(10, 6, 2, 2, 'P3', 100),
(11, 6, 1, 2, 'W1', 50),
(12, 6, 1, 2, 'W2', 50),
(13, 6, 1, 2, 'W3', 50),
(14, 6, 3, 2, 'EXAM2', 100),
(15, 6, 1, 3, 'W1', 100),
(16, 6, 1, 3, 'W2', 50),
(17, 6, 1, 3, 'W3', 50),
(18, 6, 1, 3, 'W4', 100),
(19, 6, 2, 3, 'P1', 100),
(20, 6, 3, 3, 'Exam3', 100),
(21, 6, 3, 4, 'Exam4', 100),
(22, 6, 2, 4, 'P1', 100),
(23, 6, 2, 4, 'P2', 100),
(24, 6, 1, 4, 'W1', 100),
(25, 6, 1, 4, 'W2', 100),
(26, 6, 1, 4, 'W3', 100);

-- --------------------------------------------------------

--
-- Table structure for table `class_list`
--

CREATE TABLE `class_list` (
  `class_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL,
  `grade` text NOT NULL,
  `section` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class_list`
--

INSERT INTO `class_list` (`class_id`, `subject_id`, `grade`, `section`, `delete_flag`) VALUES
(1, 1, '7', 'A', 0),
(2, 1, '8', 'A', 0),
(5, 1, '7', 'B', 0),
(6, 2, '7', 'A', 0),
(7, 2, '7', 'B', 0),
(8, 6, '7', 'C', 0),
(9, 6, '7', 'A', 0);

-- --------------------------------------------------------

--
-- Table structure for table `component_subject_percentage`
--

CREATE TABLE `component_subject_percentage` (
  `csp_id` int(30) NOT NULL,
  `subject_id` int(30) NOT NULL,
  `component_id` int(30) NOT NULL,
  `percentage` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `component_subject_percentage`
--

INSERT INTO `component_subject_percentage` (`csp_id`, `subject_id`, `component_id`, `percentage`) VALUES
(1, 2, 1, '25'),
(2, 2, 2, '30'),
(3, 2, 3, '45'),
(4, 3, 1, '25'),
(5, 3, 2, '30'),
(6, 3, 3, '45'),
(7, 4, 1, '20'),
(8, 4, 2, '30'),
(9, 4, 3, '50'),
(10, 5, 1, '20'),
(11, 5, 2, '40'),
(12, 5, 3, '40'),
(13, 1, 1, '25'),
(14, 1, 2, '30'),
(15, 1, 3, '45'),
(16, 6, 1, '25'),
(17, 6, 2, '30'),
(18, 6, 3, '45');

-- --------------------------------------------------------

--
-- Table structure for table `grading_components`
--

CREATE TABLE `grading_components` (
  `component_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grading_components`
--

INSERT INTO `grading_components` (`component_id`, `name`, `delete_flag`) VALUES
(1, 'Written', 0),
(2, 'Perfomance', 0),
(3, 'Quarterly Assessment', 0),
(5, 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mark_list`
--

CREATE TABLE `mark_list` (
  `assessment_id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `mark` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mark_list`
--

INSERT INTO `mark_list` (`assessment_id`, `student_id`, `mark`) VALUES
(3, 6, 49),
(3, 7, 45),
(3, 3, 48),
(3, 2, 48),
(3, 1, 50),
(4, 6, 70),
(4, 7, 70),
(4, 3, 68),
(4, 2, 67),
(4, 1, 73),
(5, 6, 98),
(5, 7, 98),
(5, 3, 98),
(5, 2, 98),
(5, 1, 99),
(6, 6, 93),
(6, 7, 93),
(6, 3, 90),
(6, 2, 95),
(6, 1, 96),
(1, 6, 99),
(1, 7, 99),
(1, 3, 99),
(1, 2, 99),
(1, 1, 99),
(7, 6, 100),
(7, 7, 100),
(7, 3, 100),
(7, 2, 100),
(7, 1, 100),
(2, 6, 97),
(2, 7, 95),
(2, 3, 95),
(2, 2, 97),
(2, 1, 98);

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `student_id` int(30) NOT NULL,
  `class_id` int(30) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`student_id`, `class_id`, `name`) VALUES
(1, 6, 'Samantha Jane Miller'),
(2, 6, 'Mark Cooper'),
(3, 6, 'John Smith'),
(4, 7, 'Mike Williams'),
(5, 7, 'George Wilson'),
(6, 6, 'Cynthia Lee'),
(7, 6, 'James Bond');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `name`, `delete_flag`) VALUES
(1, 'Math', 0),
(2, 'English', 0),
(3, 'Filipino', 0),
(4, 'History', 0),
(5, 'MAPEH', 0),
(6, 'Science', 0),
(7, 'Test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transmutation_table`
--

CREATE TABLE `transmutation_table` (
  `trans_id` int(30) NOT NULL,
  `from` double NOT NULL DEFAULT 0,
  `to` double NOT NULL DEFAULT 0,
  `grade` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transmutation_table`
--

INSERT INTO `transmutation_table` (`trans_id`, `from`, `to`, `grade`) VALUES
(1, 100, 100, 100),
(2, 0, 3.99, 60),
(3, 12, 15.99, 63),
(4, 16, 19.99, 64),
(5, 20, 23.99, 65),
(6, 24, 27.99, 66),
(7, 28, 31.99, 67),
(8, 32, 35.99, 68),
(9, 36, 39.99, 69),
(10, 4, 7.99, 61),
(11, 40, 43.99, 70),
(12, 44, 47.99, 71),
(13, 48, 51.99, 72),
(14, 52, 55.99, 73),
(15, 56, 59.99, 74),
(16, 60, 61.59, 75),
(17, 61.6, 63.19, 76),
(18, 63.2, 64.79, 77),
(19, 64.8, 66.39, 78),
(20, 66.4, 67.99, 79),
(21, 68, 69.59, 80),
(22, 69.6, 71.19, 81),
(23, 71.2, 72.79, 82),
(24, 72.8, 74.39, 83),
(25, 74.4, 75.99, 84),
(26, 76, 77.59, 85),
(27, 77.6, 79.19, 86),
(28, 79.2, 80.79, 87),
(29, 8, 11.99, 62),
(30, 80.8, 82.39, 88),
(31, 82.4, 83.99, 89),
(32, 84, 85.59, 90),
(33, 85.6, 87.19, 91),
(34, 87.2, 88.79, 92),
(35, 88.8, 90.39, 93),
(36, 90.4, 91.99, 94),
(37, 92, 93.59, 95),
(38, 93.6, 95.19, 96),
(39, 95.2, 96.79, 97),
(40, 96.8, 98.39, 98),
(41, 98.4, 99.99, 99);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_list`
--
ALTER TABLE `admin_list`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `assessment_list`
--
ALTER TABLE `assessment_list`
  ADD PRIMARY KEY (`assessment_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `component_id` (`component_id`);

--
-- Indexes for table `class_list`
--
ALTER TABLE `class_list`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `component_subject_percentage`
--
ALTER TABLE `component_subject_percentage`
  ADD PRIMARY KEY (`csp_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `component_id` (`component_id`);

--
-- Indexes for table `grading_components`
--
ALTER TABLE `grading_components`
  ADD PRIMARY KEY (`component_id`);

--
-- Indexes for table `mark_list`
--
ALTER TABLE `mark_list`
  ADD KEY `student_id` (`student_id`),
  ADD KEY `assessment_id` (`assessment_id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`);

--
-- Indexes for table `transmutation_table`
--
ALTER TABLE `transmutation_table`
  ADD PRIMARY KEY (`trans_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_list`
--
ALTER TABLE `admin_list`
  MODIFY `admin_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assessment_list`
--
ALTER TABLE `assessment_list`
  MODIFY `assessment_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `class_list`
--
ALTER TABLE `class_list`
  MODIFY `class_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `component_subject_percentage`
--
ALTER TABLE `component_subject_percentage`
  MODIFY `csp_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `grading_components`
--
ALTER TABLE `grading_components`
  MODIFY `component_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `student_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `transmutation_table`
--
ALTER TABLE `transmutation_table`
  MODIFY `trans_id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assessment_list`
--
ALTER TABLE `assessment_list`
  ADD CONSTRAINT `assessment_list_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `class_list` (`class_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_list_ibfk_2` FOREIGN KEY (`component_id`) REFERENCES `grading_components` (`component_id`) ON DELETE CASCADE;

--
-- Constraints for table `class_list`
--
ALTER TABLE `class_list`
  ADD CONSTRAINT `class_list_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE;

--
-- Constraints for table `component_subject_percentage`
--
ALTER TABLE `component_subject_percentage`
  ADD CONSTRAINT `component_subject_percentage_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `component_subject_percentage_ibfk_2` FOREIGN KEY (`component_id`) REFERENCES `grading_components` (`component_id`) ON DELETE CASCADE;

--
-- Constraints for table `mark_list`
--
ALTER TABLE `mark_list`
  ADD CONSTRAINT `mark_list_ibfk_1` FOREIGN KEY (`assessment_id`) REFERENCES `assessment_list` (`assessment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mark_list_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student_list` (`student_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
