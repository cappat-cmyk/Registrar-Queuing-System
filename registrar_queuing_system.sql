-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2023 at 02:55 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `registrar queuing system`
--

-- --------------------------------------------------------

--
-- Table structure for table `courselist`
--

CREATE TABLE `courselist` (
  `course_id` int(255) NOT NULL,
  `CourseAbbr` varchar(255) NOT NULL,
  `Course` varchar(255) NOT NULL,
  `Evaluator_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `courselist`
--

INSERT INTO `courselist` (`course_id`, `CourseAbbr`, `Course`, `Evaluator_id`) VALUES
(1, 'CAS', 'College of Arts and Sciences', '2'),
(2, 'COL', 'College of Law', '2'),
(3, 'CIHM', 'College of International Hospitality Management', '2'),
(4, 'HUMSS ', 'SHS - HUMSS', '2'),
(5, 'TVL', 'SHS - TVL', '2'),
(6, 'PBM', 'SHS - PBM', '2'),
(7, 'ARTS', 'SHS - Arts & Design', '3'),
(8, 'ABM', 'SHS - ABM', '3'),
(9, 'GAS', 'SHS - GAS', '3'),
(10, 'CBA', 'College of Business and Accountancy', '3'),
(11, 'CCS', 'College of Computer Studies', '3'),
(12, 'COE', 'College of Education', '3'),
(13, ' CRIM', ' College of Criminology   ', '3'),
(14, 'GS', 'Graduate School', '4'),
(15, '  COEAA ', ' College of Engineering, Architecture & Aviation  ', '5'),
(16, 'STEM', 'SHS - STEM', '5'),
(17, 'OTHER', 'Others ', '4'),
(18, 'CME', 'College of Maritime Education', '3');

-- --------------------------------------------------------

--
-- Table structure for table `credentials`
--

CREATE TABLE `credentials` (
  `id` int(255) NOT NULL,
  `credential` varchar(255) NOT NULL,
  `allow_transfer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`id`, `credential`, `allow_transfer`) VALUES
(1, 'CAV (Certification, Authentication & Verification)', 'Yes'),
(2, 'Certified True Copy', 'Yes'),
(3, 'TOR/Form-137', 'Yes'),
(4, 'Transfer Credentials', 'Yes'),
(5, 'Copy of Grades', 'Yes'),
(6, 'Add & Drop Form', 'Yes'),
(7, 'Clearance (for Graduating Students) ', 'Yes'),
(8, 'Clearance (for Non-Graduating)', 'Yes'),
(9, 'Completion Form', 'Yes'),
(10, 'Course Description', 'Yes'),
(11, 'Credit Subject Form', 'Yes'),
(12, 'Cross Enroll Form', 'Yes'),
(13, 'Diploma', 'Yes'),
(14, 'Dropping Form', 'Yes'),
(15, 'Educational Benefits', 'Yes'),
(16, 'Overload Form', 'Yes'),
(17, 'Printing of Registration Form', 'Yes'),
(18, 'Request Letter for TOR/Form-137', 'Yes'),
(19, 'Submission of Follow up Requirements', 'Yes'),
(20, 'Shifting Form', 'Yes'),
(21, 'Others', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `failedemails`
--

CREATE TABLE `failedemails` (
  `id` int(255) NOT NULL,
  `eval_id` int(255) NOT NULL,
  `sendTo` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_At` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `queue_id` int(255) NOT NULL,
  `ticket_number` varchar(255) NOT NULL,
  `client_type` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_priority` varchar(255) NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `requestCredentials` varchar(255) NOT NULL,
  `course_id` int(255) NOT NULL,
  `course_name` varchar(255) NOT NULL,
  `counter_id` int(255) NOT NULL,
  `Handled_by` varchar(255) NOT NULL,
  `evaluated_by` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `emailbody` varchar(255) NOT NULL,
  `arrivalTime` datetime(6) NOT NULL,
  `remarksTextArea` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studentinfo`
--

CREATE TABLE `studentinfo` (
  `stdnt_Course` varchar(255) NOT NULL,
  `stdnt_Major` varchar(255) NOT NULL,
  `stdnt_StudentNo` varchar(255) NOT NULL,
  `stdnt_Lastname` varchar(255) NOT NULL,
  `stdnt_Firstname` varchar(255) NOT NULL,
  `stdnt_MName` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactionhistory`
--

CREATE TABLE `transactionhistory` (
  `transact_id` int(255) NOT NULL,
  `counterNumber` int(255) NOT NULL,
  `handled_By` varchar(255) NOT NULL,
  `evaluated_By` varchar(255) NOT NULL,
  `client_type` varchar(255) NOT NULL,
  `studentID` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_priority` varchar(255) NOT NULL,
  `ticketNumber` varchar(255) NOT NULL,
  `transactionType` varchar(255) NOT NULL,
  `requestedDocument` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `remarksTextArea` varchar(255) NOT NULL,
  `additional_Info` varchar(255) NOT NULL,
  `arrivalTime` datetime(6) NOT NULL,
  `servedAt` datetime(6) NOT NULL,
  `finishedAt` datetime(6) NOT NULL,
  `avgwaitingtime` time(6) NOT NULL,
  `claimDate` date NOT NULL,
  `is_claimed` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `First_Name` varchar(255) NOT NULL,
  `Last_Name` varchar(255) NOT NULL,
  `Created_At` date NOT NULL,
  `Updated_At` date NOT NULL,
  `Status` varchar(255) NOT NULL,
  `is_logged_in` tinyint(1) NOT NULL,
  `Role` varchar(255) NOT NULL,
  `CounterNumber` int(255) NOT NULL,
  `pp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courselist`
--
ALTER TABLE `courselist`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failedemails`
--
ALTER TABLE `failedemails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`queue_id`);

--
-- Indexes for table `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD PRIMARY KEY (`stdnt_StudentNo`);

--
-- Indexes for table `transactionhistory`
--
ALTER TABLE `transactionhistory`
  ADD PRIMARY KEY (`transact_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courselist`
--
ALTER TABLE `courselist`
  MODIFY `course_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `failedemails`
--
ALTER TABLE `failedemails`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `queue_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactionhistory`
--
ALTER TABLE `transactionhistory`
  MODIFY `transact_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
