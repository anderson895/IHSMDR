-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2024 at 01:12 AM
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
-- Database: `ishmdr_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangay`
--

CREATE TABLE `barangay` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay`
--

INSERT INTO `barangay` (`id`, `name`, `province`, `status`) VALUES
(1, 'Barusbus', 'Antique', 1),
(2, 'Bulanao', 'Antique', 1),
(3, 'Centro Este (Pob.)', 'Antique', 1),
(4, 'Centro Weste (Pob.)', 'Antique', 1),
(5, 'Codiong', 'Antique', 1),
(6, 'Cubay', 'Antique', 1),
(7, 'Igcagay', 'Antique', 1),
(8, 'Inyawan', 'Antique', 1),
(9, 'Lindero', 'Antique', 1),
(10, 'Maramig', 'Antique', 1),
(11, 'Pajo', 'Antique', 1),
(12, 'Panangkilon', 'Antique', 1),
(13, 'Paz', 'Antique', 1),
(14, 'Pucio', 'Antique', 1),
(15, 'Sanroque', 'Antique', 1),
(16, 'Taboc', 'Antique', 1),
(17, 'Tinigbas', 'Antique', 1),
(18, 'Tinindugan', 'Antique', 1),
(19, 'Union', 'Antique', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detail_patient_maternal`
--

CREATE TABLE `detail_patient_maternal` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `maternal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_patient_maternal`
--

INSERT INTO `detail_patient_maternal` (`id`, `patient_id`, `maternal_id`) VALUES
(3, 7, 7),
(4, 8, 10),
(5, 8, 33),
(6, 7, 10),
(42, 5, 5),
(43, 6, 1),
(44, 6, 2),
(45, 6, 4);

-- --------------------------------------------------------

--
-- Table structure for table `master_category`
--

CREATE TABLE `master_category` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_category`
--

INSERT INTO `master_category` (`id`, `name`, `status`) VALUES
(1, 'Prenatal Care', 1),
(2, 'Intrapartum Care and Delivery Outcome (TCL)', 1),
(3, 'Postpartum and Newborn Care', 1),
(4, 'CPAB', 1);

-- --------------------------------------------------------

--
-- Table structure for table `master_maternal`
--

CREATE TABLE `master_maternal` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) DEFAULT NULL,
  `types` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `master_maternal`
--

INSERT INTO `master_maternal` (`id`, `name`, `types`, `status`) VALUES
(1, 'No. of pregnant women w/ at least 4 prenatal check', 1, 1),
(2, 'No. of pregnant women assessed of their nutritiona', 1, 1),
(3, 'Number of pregnant women seen in the first trimester who have normal BMI', 1, 1),
(4, 'No. of pregnant women seen in the first trimester who have high BMI', 1, 1),
(5, 'No. of pregnant women for the 1st time given 2 doses of Td vaccination', 1, 1),
(6, 'No. of pregnant women for the 2nd or more times given at least 3 doses of Td vaccination (Td2 Plus)', 1, 1),
(7, 'No. of pregnant women who completed doses of calcium carbonate supplementation', 1, 1),
(8, 'No. of pregnant women given iodine capsules', 1, 1),
(9, 'No. of pregnant women given one dose of deworming tablet', 1, 1),
(10, 'No. of pregnant women screened for syphilis', 1, 1),
(11, 'No. of pregnant women tested positive for syphilis', 1, 1),
(12, 'No. of pregnant women screened for Hepatitis B', 1, 1),
(13, 'No. of pregnant women tested positive for Hepatitis B', 1, 1),
(14, 'No. of pregnant women screened for HIV', 1, 1),
(15, 'No. of pregnant women tested for CBC or Hgb&Hct count', 1, 1),
(16, 'No. of pregnant women tested for CBC or Hgb&Hct count diagnosed with anemia', 1, 1),
(17, 'No. of pregnant women screened for gestational diabetes', 1, 1),
(18, 'No. of pregnant women tested positive for gestational diabetes', 1, 1),
(19, 'No. of deliveries - Total', 2, 1),
(20, 'No. of live births (by Weight) - Total', 2, 1),
(21, 'No. of live births with normal birth', 2, 1),
(22, 'No. of live births with low birth ', 2, 1),
(23, 'No. of live births with unknown birth', 2, 1),
(24, 'No. of deliveries attended by skilled ', 2, 1),
(25, 'No. of deliveries attended by a doctor', 2, 1),
(26, 'No. of deliveries attended by a nurse', 2, 1),
(27, 'No. of deliveries attended by midwives', 2, 1),
(28, 'No. of deliveries attended by non-skilled health professionals (attended by others)', 2, 1),
(29, 'No. of health facility-based', 2, 1),
(30, 'No. of deliveries in public ', 2, 1),
(31, 'No. of deliveries in private ', 2, 1),
(32, 'No. of non-facility-based', 2, 1),
(33, 'No. of vaginal deliveries', 2, 1),
(34, 'No. of deliveries by cesarian section', 2, 1),
(35, 'No. of full-term births', 2, 1),
(36, 'No. of pre-term births', 2, 1),
(37, 'No. of fetal deaths', 2, 1),
(38, 'No. of multiple births*', 2, 1),
(39, 'No. of abortion / miscarriage*', 2, 1),
(40, 'No. of postpartum women together with their newborn who completed at least 2 postpartum check-ups', 3, 1),
(41, 'No. of postpartum women who completed iron with folic acid supplementation', 3, 1),
(42, 'No. of postpartum women with Vitamin A supplementation', 3, 1),
(43, 'CPAB', 4, 1),
(44, 'HepB, within 24 hours', 4, 1),
(45, 'DPT-HiB-HepB 1', 4, 1),
(46, 'DPT-HiB-HepB 2', 4, 1),
(47, 'DPT-HiB-HepB 3 ', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL,
  `medicine_brand` varchar(255) DEFAULT NULL,
  `generic` varchar(255) DEFAULT NULL,
  `medicine_name` varchar(255) DEFAULT NULL,
  `lot_number` varchar(100) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `medicine_brand`, `generic`, `medicine_name`, `lot_number`, `expiry_date`, `quantity`, `category`) VALUES
(5, 'Medicine Brand', 'Generic', 'Medicine ', '2', '2024-12-08', 99, 'Capsule'),
(6, 'Biogesic', 'Biogesic', 'Biogesic', '25', '2024-10-12', 2355, 'Capsule'),
(7, 'Amoxicillin', 'Amoxicillin', 'Amoxicillin 500 mg Cap', '1122334455', '2025-02-01', 1100, 'Tablet'),
(8, 'Alaxan FR', 'Ibuprofen +', 'Alaxan FR', '2233445566', '2025-03-08', 2000, 'Capsule'),
(9, 'Solmux', 'Carbocisteine', 'Solmux', '4455667788', '2025-05-09', 0, 'Capsule'),
(10, 'Buscopan', 'Hyoscine-N-', 'Buscopan', '9900112233', '2025-04-25', 3000, 'Capsule'),
(11, 'Kremil-S', 'Aluminum +', 'Kremil-S Tablet', '3031323334', '2025-02-01', 3600, 'Capsule'),
(12, 'Glucophage', 'Metformin', 'Glucophage', '4041424344', '2024-02-12', 1000, 'Tablet');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `patient_no` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `age` int(11) NOT NULL,
  `sex` enum('Male','Female','Other') NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `medicine_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` date NOT NULL,
  `prescribing_doctor` varchar(100) DEFAULT NULL,
  `dispensing_officer` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_no`, `first_name`, `middle_name`, `last_name`, `age`, `sex`, `address`, `medicine_id`, `quantity`, `date`, `prescribing_doctor`, `dispensing_officer`) VALUES
(6, '7836483', 'Richard', 'Danao', 'Cortes', 22, 'Male', 'Bulanao', 5, 3, '2024-10-09', 'example', 'example2'),
(7, '1231415', 'Jas', 'Per', 'E', 18, 'Male', 'Lindero', 1, 1, '2024-10-09', 'xample', 'xample'),
(8, '6151515', 'S', 'S', 'S', 3, 'Female', 'Bulanao', 5, 2, '1998-02-04', 'S', 'John Due'),
(9, '24252', 'olie', 'B', 'Gown', 23, 'Male', 'Barusbus', 6, 200, '2024-07-11', 'Doc. Florence Jane Legaspi', 'John Due'),
(10, '23535', 'Harvey', 'B', 'Specter', 24, 'Male', 'Barusbus', 7, 100, '2024-07-11', 'Doc. Florence Jane Legaspi', 'John Due'),
(11, '019198', 'Harry', 'v', 'Potter', 24, 'Male', 'Taboc', 11, 400, '2024-07-11', 'Doc. Florence Jane Legaspi', 'John Due'),
(12, '24253', 'grace', '', 'condez', 35, 'Female', 'Pandan', 9, 2600, '2024-07-11', 'Doc. Florence Jane Legaspi', 'Jimmy Samillano');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstName` varchar(250) NOT NULL,
  `lastName` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `reset_token` text NOT NULL,
  `reset_expires_at` datetime NOT NULL,
  `user_type` enum('PharmacistAssistant','Nurse','Midwife','BHW','Pharmacist','Admin') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstName`, `lastName`, `email`, `password`, `reset_token`, `reset_expires_at`, `user_type`, `created_at`) VALUES
(5, 'Cullen', 'Lens', 'SjFFK1lFanNXdzJobUpnOEtteU0rTFFzWEV0RUhUK2x0YkhKU0xXdlg2M3ZSRlV1Y085T29WaUp3ODhXamJHRw==', 'SjFFK1lFanNXdzJobUpnOEtteU0rSmNHdkVXaWZTL2x3WlRTVUluUDVxND0=', '', '0000-00-00 00:00:00', 'Pharmacist', '2024-11-07 01:59:44'),
(7, 'John', 'Due', '\r\nSjFFK1lFanNXdzJobUpnOEtteU0rRzBCcC9sSWUvN1RWbTdmWDI5MEdXQT0=', '\r\nSjFFK1lFanNXdzJobUpnOEtteU0rTlo4NUhoZlgxRUp5Y1dKNU5DQVpwUT0=', '', '2024-10-11 01:02:32', 'Admin', '2024-10-10 15:02:52'),
(10, 'Allen', 'Umapas', 'SjFFK1lFanNXdzJobUpnOEtteU0rQTM5WmFTRVlLY0FqZjdaYzNGT1JoazlFYS9KWkFZa1paeDh4cDNvSGtpeA==', 'SjFFK1lFanNXdzJobUpnOEtteU0rQytrSmkwWjB0dGVhemRQeHRnajNjYz0=', '', '0000-00-00 00:00:00', 'Pharmacist', '2024-11-07 06:56:36'),
(11, 'Luiz', 'Lacasa', 'SjFFK1lFanNXdzJobUpnOEtteU0rTGU3Z3pMb0VFV1BvS25zWUJrclZvTHJiTmRuUEhPMitOaGd6aFBScVVabQ==', 'SjFFK1lFanNXdzJobUpnOEtteU0rTHNHTWM0S1NaLy8zU1QwVUJlSXprdz0=', '', '0000-00-00 00:00:00', 'Nurse', '2024-11-06 17:18:05'),
(12, 'Ben ', 'Doe', 'SjFFK1lFanNXdzJobUpnOEtteU0rRzBCcC9sSWUvN1RWbTdmWDI5MEdXQT0=', 'SjFFK1lFanNXdzJobUpnOEtteU0rTlo4NUhoZlgxRUp5Y1dKNU5DQVpwUT0=', '', '0000-00-00 00:00:00', 'Admin', '2024-11-07 01:29:00'),
(13, 'Jim', 'Jim', 'SjFFK1lFanNXdzJobUpnOEtteU0rRUNFMjdEK2pkWURib2NsL3NtanJseThwdWt4Zk44dkpiY2F5cFNTVVAxcw==', 'SjFFK1lFanNXdzJobUpnOEtteU0rRzE3K2dubFBFb0FlbWV5Z0FNc0Nsbz0=', '', '0000-00-00 00:00:00', 'Pharmacist', '2024-11-14 23:33:04'),
(14, 'eric', 'von', 'SjFFK1lFanNXdzJobUpnOEtteU0rS2xlQmtJWXZuZTlOYVE0VjVZcnlkRzBldHB2VHJLTFY4bTNLUUJNNitXdw==', 'SjFFK1lFanNXdzJobUpnOEtteU0rREhldG9iY3FpblY5dTNrUjlVdWdnND0=', '', '0000-00-00 00:00:00', 'Pharmacist', '2024-11-07 02:03:16'),
(15, 'Jimmy', 'Samillano', 'SjFFK1lFanNXdzJobUpnOEtteU0rQkZ2K3lzenJOYVcrR3FGZlZndmFDeFhJekxLSFFYZjAvb1pUc3BsU1djTw==', 'SjFFK1lFanNXdzJobUpnOEtteU0rSlhqU1Vxb2N4eWt5WnlvWmk1Um52WT0=', '', '0000-00-00 00:00:00', 'Pharmacist', '2024-11-07 02:05:17'),
(16, 'andy', 'andy', 'SjFFK1lFanNXdzJobUpnOEtteU0rUE9MWmRKQ0t5QXRoVFdKbEtCRnpCZz0=', 'SjFFK1lFanNXdzJobUpnOEtteU0rQS9panFmT21KK2dvc2ZxaGRHZWZhcz0=', '', '0000-00-00 00:00:00', 'BHW', '2024-11-07 06:39:04'),
(17, 'Allen', 'Umapas', 'SjFFK1lFanNXdzJobUpnOEtteU0rQ2pwaWRxd2hMY3FhNm5ZMGY1cGM5VT0=', 'SjFFK1lFanNXdzJobUpnOEtteU0rSm13UG0zdFdWRWN2Y25QOW05ck1vUT0=', '', '0000-00-00 00:00:00', 'Pharmacist', '2024-11-14 23:20:49'),
(18, 'newnwew', 'acc', 'SjFFK1lFanNXdzJobUpnOEtteU0rTktmRVl2OVFJbGRRbGZjelRjNFJXMHc2Y1QxYnZyZUEyVnRiZUMwQ1hFYQ==', 'SjFFK1lFanNXdzJobUpnOEtteU0rTnRvaTB1cDN1QmN4MU03NWZHTU9MST0=', '', '0000-00-00 00:00:00', 'Pharmacist', '2024-11-15 01:16:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay`
--
ALTER TABLE `barangay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_patient_maternal`
--
ALTER TABLE `detail_patient_maternal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_category`
--
ALTER TABLE `master_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_maternal`
--
ALTER TABLE `master_maternal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay`
--
ALTER TABLE `barangay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `detail_patient_maternal`
--
ALTER TABLE `detail_patient_maternal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `master_category`
--
ALTER TABLE `master_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_maternal`
--
ALTER TABLE `master_maternal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
