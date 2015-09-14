-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 25, 2015 at 10:18 AM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `teams_db`
--
CREATE DATABASE IF NOT EXISTS `teams_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `teams_db`;

-- --------------------------------------------------------

--
-- Table structure for table `accrual_policies`
--

CREATE TABLE IF NOT EXISTS `accrual_policies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `accrual_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `frequency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `accrual_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `day_of_month` int(11) NOT NULL,
  `month` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assign_exceptions`
--

CREATE TABLE IF NOT EXISTS `assign_exceptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `exception_id` int(11) NOT NULL,
  `severity` varchar(255) NOT NULL,
  `grace` time DEFAULT NULL,
  `watch_window` time DEFAULT NULL,
  `email_notification` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `assign_exceptions`
--

INSERT INTO `assign_exceptions` (`id`, `group_id`, `exception_id`, `severity`, `grace`, `watch_window`, `email_notification`) VALUES
(1, 1, 1, 'Critical', '00:00:15', '00:00:01', 'Both'),
(2, 1, 2, 'Critical', '00:00:15', '00:00:01', 'Both'),
(3, 1, 3, 'Medium', NULL, NULL, 'Both'),
(4, 1, 4, 'Medium', '00:00:15', '00:00:01', 'Both'),
(5, 1, 5, 'Medium', '00:00:15', '00:00:01', 'Both'),
(6, 1, 6, 'High', '00:00:15', '00:00:01', 'Both'),
(7, 1, 7, 'Low', '00:00:15', '00:00:01', 'Both'),
(8, 1, 8, 'Medium', '00:00:15', '00:00:01', 'Both'),
(9, 1, 9, 'Critical', '00:00:15', '00:00:01', 'Both'),
(10, 1, 10, 'High', '00:00:15', '00:00:01', 'Both'),
(11, 1, 11, 'Critical', NULL, NULL, 'Both'),
(12, 1, 12, 'Low', '00:00:15', '00:00:01', 'Both'),
(13, 1, 13, 'High', '00:00:15', '00:00:01', 'Both'),
(14, 1, 14, 'High', '00:00:15', '00:00:01', 'Both'),
(15, 1, 15, 'Low', '00:00:15', '00:00:01', 'Both'),
(16, 1, 16, 'Medium', NULL, NULL, 'Both');

-- --------------------------------------------------------

--
-- Table structure for table `assign_overtimes`
--

CREATE TABLE IF NOT EXISTS `assign_overtimes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `range_from` date NOT NULL,
  `range_to` date NOT NULL,
  `overtime_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE IF NOT EXISTS `attendances` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `attendance_time` time NOT NULL,
  `attendance_date` date NOT NULL,
  `punch_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `in_out` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE IF NOT EXISTS `branches` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `status`, `code`, `address`, `city`, `country`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Sta.Mesa', 'Enabled', 'B1', 'Teresa St.', 'MANILA', 'Philippines', 'sta.mesa_company@gmail.com', '2015-07-29 08:36:26', '2015-07-29 08:36:26'),
(2, 'Makati', 'Enabled', 'B2', 'Cembo St.', 'Makati', 'Philippines', 'makati_company@email.com', '2015-07-29 08:37:07', '2015-07-29 08:37:07'),
(3, 'Ortigas', 'Enabled', 'B3', 'Uno St.', 'Manila', 'Philippines', 'ortigas_company@email.com', '2015-07-29 08:38:39', '2015-07-29 08:38:39'),
(4, 'Eastwood', 'Enabled', 'B4', 'santolan rd', 'Pasig', 'Philippines', 'eastwood_company@email.com', '2015-07-29 08:39:26', '2015-07-29 08:39:26');

-- --------------------------------------------------------

--
-- Table structure for table `breaks`
--

CREATE TABLE IF NOT EXISTS `breaks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_id` int(11) NOT NULL,
  `break_in` time NOT NULL,
  `break_out` time NOT NULL,
  `day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `breaks`
--

INSERT INTO `breaks` (`id`, `schedule_id`, `break_in`, `break_out`, `day`, `created_at`, `updated_at`) VALUES
(1, 1, '12:00:00', '13:00:00', 'Monday', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `break_policies`
--

CREATE TABLE IF NOT EXISTS `break_policies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `break_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active_after` time NOT NULL,
  `autodetect_breaksby` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE IF NOT EXISTS `contracts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contract_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `contract_name`, `description`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'Regular', 'regular type employee', 99999, '2015-07-29 08:55:07', '2015-07-29 08:55:07'),
(2, 'Contractual', 'Contractual type employee', 6, '2015-07-29 08:55:32', '2015-07-29 08:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `create_requests`
--

CREATE TABLE IF NOT EXISTS `create_requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `request_date` date NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `request_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `create_requests`
--

INSERT INTO `create_requests` (`id`, `status`, `request_date`, `start_date`, `start_time`, `end_date`, `end_time`, `message`, `request_type`, `employee_id`, `created_at`, `updated_at`) VALUES
(1, 'pending', '2015-02-28', '2015-02-22', '10:00:00', '2015-02-02', '10:00:00', 'This is a description for a Request.', 'Vacation Leave', 2, '2015-02-27 10:24:09', '2015-02-27 12:30:21');

-- --------------------------------------------------------

--
-- Table structure for table `credit_policies`
--

CREATE TABLE IF NOT EXISTS `credit_policies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `credit_reset` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `preset_basis` date DEFAULT NULL,
  `frequency` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_value` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `withdrawable` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `allowed_leaves` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `credit_policies`
--

INSERT INTO `credit_policies` (`id`, `name`, `description`, `credit_reset`, `preset_basis`, `frequency`, `start_value`, `rate`, `withdrawable`, `allowed_leaves`, `created_at`, `updated_at`) VALUES
(1, 'maternal leave', 'leave for pregnancy', '4', '0000-00-00', '', 0, 0, 'no', 0, '2015-06-30 03:14:23', '2015-06-30 03:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `custom_assign_overtimes`
--

CREATE TABLE IF NOT EXISTS `custom_assign_overtimes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active_after` int(11) NOT NULL,
  `Allowed_number_of_hours` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `range_from` date NOT NULL,
  `range_to` date NOT NULL,
  `employee_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `status`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'Sales', 'D1', 'Enabled', 1, '2015-07-29 09:03:01', '2015-07-29 09:03:01'),
(2, 'Quality Assurance', 'D2', 'Enabled', 2, '2015-07-29 09:16:20', '2015-07-29 09:16:20'),
(3, 'Information Technology', 'D3', 'Enabled', 3, '2015-07-29 09:16:52', '2015-07-29 09:16:52'),
(4, 'Marketing', 'D4', 'Enabled', 4, '2015-07-29 09:17:05', '2015-07-29 09:17:05'),
(5, 'Human Resource', 'D5', 'Enabled', 1, '2015-07-29 09:17:25', '2015-07-29 09:17:25'),
(6, 'Executive', 'D6', 'Enabled', 2, '2015-07-29 10:01:59', '2015-07-29 10:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` text COLLATE utf8_unicode_ci NOT NULL,
  `path` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`id`, `file_name`, `path`, `created_at`, `updated_at`) VALUES
(4, '1manual.pdf', '../pdf_files/1manual.pdf', '2015-08-18 18:04:37', '2015-08-18 18:04:37'),
(5, '5this is it pancit.pdf', '../pdf_files/5this is it pancit.pdf', '2015-08-18 18:21:58', '2015-08-18 18:21:58'),
(6, 'DBA Proposal.pdf', '../pdf_files/DBA Proposal.pdf', '2015-08-18 18:24:43', '2015-08-18 18:24:43');

-- --------------------------------------------------------

--
-- Table structure for table `employs`
--

CREATE TABLE IF NOT EXISTS `employs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `midinit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `barangay` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hire_date` date NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fingerprint` blob,
  `qr_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jobtitle_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `contract_id` int(11) NOT NULL,
  `level_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `employs`
--

INSERT INTO `employs` (`id`, `employee_number`, `lname`, `fname`, `midinit`, `picture_path`, `date_of_birth`, `street`, `barangay`, `city`, `phone`, `email`, `hire_date`, `status`, `fingerprint`, `qr_code`, `password`, `jobtitle_id`, `department_id`, `contract_id`, `level_id`, `created_at`, `updated_at`) VALUES
(1, 'EMP-00001', 'Ramos', 'Rock Well', 'L', 'employees/1RamosRockWell.jpg', '1995-05-15', '49-A Santolan Rd.', 'Brgy. Valencia', 'Quezon City', '09368195923', 'kwellramos015@gmail.com', '2015-07-30', 'Active', 0x00f85501c82ae3735cc0413709ab7130a51455922e62c2a50450086ca635183ee9f5296b48f5f872f9b571ece5f840c774d09eeb1c18ea28b56b25a51233ff520dde9c81a946a1b08aa17385966bd651ee461cec2cc5a95385ecacb1e01fa4a2566c070c97f9cc72c59e708d6a83bbafcd7b9c13f318aaa5668f0f05f44c1a4a157ad401b51a4f90fff583163266f5461f5447148ff47e524e2876b173519db11b31217915ad4d438a39e15851af0e8e16a271148d1e664f9b61817b5fbbd891049865c959a65ac1c3928d6c9fb6b83b08967c15281e824240d9cc538bd1eb54765c95e72fbd550641752a3e6ac4dd27951161de9d17cdbec7c0b3bcab02bff2a2a200774035b19c293d9764736ca0f49d1c0b56d2f2ab1f3e6ff46159b0fb4de427a268c02fbe633e2dc81df351b7cdbc25ba6c0b62f4cb424293183af9e8453c69d4ff99432f4f97661873d117f584aaa748e92f8a16473e6f00f84201c82ae3735cc0413709ab71b09414559243708ec9cce8e33aebd1d6e91925001f32d2f823230f8929149dc081e1c1e36ec9124321151824cc1ab18830c61edb445ead9d9e895161f33aada343e34bc267c400d39ff5fcf401472e23a60dbb7270495139297b404c022ca7650937c75bb3b2cc33bbf53bc86ede478c7ca0fa599399ff7b1e17ac2d653d812df1c7c83db2a235057666ffd7917111613f789124841fe9d574feb1b50b53e15a6e35e9fb1b782ff73987f183dab7cd153c2c52990cff4cfa30b293a3954f9b01118c70115c82f912521113b2619c9dc38f52c8f91477e3368be5b55398045cebd097ce8a0a221709b24554618e120dcd2a0849c3f2b7ba5d63b97393e8b653f37343acdefc3dec093a720cf040640ee79d68e6ea25f66fe9a3c1a0b0638e648930c179392785de35a1c73ab801bc0c879383cc57d230f46f00f86601c82ae3735cc0413709ab7170b91455922627ab16df1bf6cc1ad0bb2255e432b5562e3829b7807fe33b03bf0080e433810fe074470ce50585aa4502a2348388d679cf1ae3e80b868d4e02d11cff359fabe8f798768d9176e7932d7b99795b99df16d4ea6d878f1a2b559b1d20ccf4bf6dce12c6f882c4d1b278c4ada71c5597987b5e83eac1567a17a4b1fc4fb17dbce3284cce286eb64a5070ebe158326f0fc84ae62429d61581aa134d092bcc30471f37989464b5f2bc812f42f78235cacb51f5e0430ad69ef6dd03868f01e773f33105504716e6d019f904b510246a807c556f6732e9bed627f4a8000579bcb2d68e64619b69449c63659c78ba0dfd56aa2d4fea9f7fe64518a3b25a924e5d1fb3420236fd5330b5f87b4c981aa3029d3ef456ab286c0b97a142d88784dbdda5aa4cd29949b1e876e78e110067737a8e8b497b7652538de2f3e19896cfacad1f083b383f2903d0ca4ee59f2c06ac3baedef08306bd04495e6f00e82a01c82ae3735cc0413709ab71309e14559255e7d65178d48161d13d6d564f8d7d104747c949626a340f3426c5427f48054433a9e07c31c150930ad0492e1bcb8f21f537ec5e0fa502c6c9f49f6397f648f4e8937ec4c3fcbb576e959609bab06e397864a7f91ca906f3c9627285ac1b70b0c2ea8779a54da7425fbcd43e8ae838ef9e90c2023ddc946ef5f8c6594ada0a3da9318a884f736dc9f7ea2d83476ffc6153697d029bdf32aca4b307cdcbe3aea73348dcf832f6f920a840b5b8df9be9a16d4c277e04e1f150c982a6f2c68ad1dfbf845620a93c37989acd98b8eed72922c703bd8a857027ae8c204132004e931c567099014e0de5a552a8bb1463ade79e5406ed259845b7fbef9398f927d65c1ee094db25ad927915b11be9ec2246f410cb0d6be58b60275d0e756f0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 'qrcodes/1RamosRockWell.png', 'rock123', 3, 1, 1, 3, '2015-07-29 09:07:54', '2015-07-29 09:58:43'),
(2, 'EMP-00002', 'Mante', 'Joshua Elijah', 'T', 'employees/2ManteJoshuaElijah.jpg', '1996-04-29', '266-A Alley 2 Teresa St.', 'Brgy. 591', 'MANILA', '09268475323', 'excelsior.mante@gmail.com', '2015-07-31', 'Active', 0x00f85101c82ae3735cc0413709ab71b083145592569620c2bbbec869e8f8becd2b14820ab931ea279e6c553cd0ec2abbac21ff86bae4ba7afd1a925efb99b421d3c98866238620df27508dd3cc78e7a1f7c4790223e9817e4df01573f5de82da7a60efed21dc14240154f083bdd6504472afea57d11bf805533de276c44532da99fce0a03778c949abca5a1e395509e13df8c0d9801082cc78e13818b30dd8d3969f37af801744b459967a666a1559f49a9b5fbf51d5641fbcfe14d0455dc89e547f0696336d4481368387a712cad34839100b6b63396f1a141164d34936591470536c3e61bdff2e656123d56253aad462469ca9a66718227720025e8d6c1f87b412d89d9a2327f957f5f784c1771922e8ebb55c8dcad3e55fe57d9b296e64ddbbd8dce6d2da10ee1da8c6b1899208476cc39451a867b2ca0b3e177fbc55d704e6af7b9ab2c2c9b1faeaa13317ece071603480414a6f00f86101c82ae3735cc0413709ab71b099145592db4fa0a9757157362efe208d370a7870e01449b37f481baa1386bc9f9ccff512fd09806d6ccd97ad9540283e5f3897bbda57f5e49bb4299f62923a5c4e5f02aeca8a3df1f4ff88de00f0e5253155eafb01519fc458dae505136d7dd038d0d1557c1a719721efb7e6cbc8c5f9e14a4e869ca5eff0746d33b0e0ae770f58018003d7abe32fe5ade5c581cebd48361e6a9faf2169eaac1a5df282c21d96fe72863e0f995bec74c0e79bcc3a942f9bac66d188f5ac904c26176d2dbeac12365f360864baa1b8ffb2f610e6aae0fbcb6dfeb67ccaa81eaa352faa3019e6541019e4461df6dfa36e15f009f6acef5a63979c799cb3d3b77e878a1157ed9e35179289ef3dc97c4d52f87d757cf368e18b01c4c720b54271b1d33a0583788e192f2ee9ec6957a5d2f3dd8d21e4c8eed9e71a2eec1980302fe79427839a385a1e6ed3fc09b2aea3c2b2b9af27accbb2eb4c76d6bb696f00f87f01c82ae3735cc0413709ab717099145592b6f62d66002bf504b0aeeea99c02bb4c5a3112c31409e735ae34c59a11dbb0699259eaf21ce13ce0c1d9b717da7dce6a949e2337e25e1a99222f143f791c6719260429ac0912ed653a25c64b09da873aade8ec60b1d56517a3deb671382b6f54ce1ea8ba7bb6e440dd0c9abef891fcd6cfe87734bfaabd997f9d904c2b78505f86c5ce2a57599203901841d4470dbadd4e8a0155778b2e15c822f9a2b2e7951fb192a814b2446f85650ad5307e7eb4d4a64125cde1410956709c5512e201411ca9c2e8d4df051c9ecef9fd1763f67b84b98fdfb93f248a94d66428b864e4cecd92c89ab832ce28243570ff10c68af4dac35c4c9ef66c88a4f8d206b7adc049c76ae04a8a05d3f2fbdb860ab8fad75a01f91836f1646b266e178f3e1b2f332bc2d00af2cd35bd3e19c6f234dc733471b8de641ff9dc744687a887e4209602061c0b33eec71d33f1185e5d7f33f329ef7e48b178fac676c3c30f42829f92b9335fbc2da0f4a92dd1d75eed8c275daf236f00e87201c82ae3735cc0413709ab71f095145592a9c5dc4cba144fa25a5b5e4e17246bdf2e8802adbc67388a0bda3478a1158b15cb76c3ea527021a90d7a73f0426fbbec592f14612d07b7cdc5707ce3e23323afa9ea44687d796015b13d13ba08877e140a0dd030a823b64e725eca0fc7eb19432ef95cf345e0d1e92e6eeea9fe1fd5a513b91aebdd1f50611bbed633c3484dc4054bdcd23fdb32b598c6a5aa87fdf81add804d1b909a01b740a1f9906dfe4792940b449d29062b7d2f220307250dcc2d1745f4dd70fa2322d281cd84c5de0fafbbdf23c98049630613930409c139ba9f968b0c62baab6b978d2278e7ddaa4ba554616c3b0c2be1d82dd72e9a984af64ee6f0e984df47139b4c043c90a0ac4457ec5231280df6be1f3ab3fcbc257e7c933b85235eb38f4aafb1903e5c48b53eb5807a52cdbc592567554119bb8244589a8a4f9e333ec196be9750315bc3eedbebb936d07b75750142b10f539fe2082f7d04294fce7467c9a3e2b14dde1e8c889ecdcb6f00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 'qrcodes/2ManteJoshuaElijah.png', 'MyNNyZAl', 6, 6, 1, 2, '2015-07-29 09:12:59', '2015-07-29 10:03:01'),
(3, 'EMP-00003', 'Fernandez', 'Denimar', 'F', 'employees/3FernandezDenimar.jpg', '1995-06-23', '1128 Interior Ricky', 'Brgy. Jaypee Deleon', 'Valenzuela', '09123456789', 'fdenimar@gmail.com', '2015-08-01', 'Active', 0x00f84701c82ae3735cc0413709ab717082145592d1cc543f813fafb671d55c1547110a1d2095625f5c186d8adc9cf088ca58e415b22b780351cb5f50cb5a2108c68dc2aef7ad7eb60f853a6fb8c559b95a57c8b0a459e1f9c387e44526598c95a0ccff696b20ea388026c1dd28f93aa11f841d768c8a26f8418b57f9564000faeddf0de5aba3b042cbe0ebbf85c3155e4ba626db770672594b5b32547c56503f45e4f8bce614cf5990e89d643f022ba5f572165d65498343e2fb6a47a36f5462913e181519fd4aa288ddfec061b5fe52772d649bd92683b87b98254f1036fc2e8e02f30826122a2f861372ace0f8b5fba116559e7005493d9089a7b275ec99589f160d3bdcc79fa7869d58af1ef887d3a0c50947bf3f7e6f7faf9792ea8d1afe7a3ab72030492dcb2280712963c91a5875dc0905e3fe10fc95d470304e0c3db5e01fa1e403e31d8b9a6b646f00f85f01c82ae3735cc0413709ab71b08714559253b7e8abf2aed1cd2d4e76ec2c263a57285aab18229e4f5366f8d8f83e00c3790ef2c669c39f955a1f082e36347b837c6396ba378ac2a811dd364c2a0723d31ea7bc30bb35ad3f36bd2b9a925ba7a7abb1f884cb81db2094e190081016ec528ada41af0e5b15640d1e7ee796ecbbe15b154628279ff662212fb6b6d705293cc720099786f9a24b4904f9b1fd381964bcf4f5dd1679da7870f795f5ac589ceb2e456d3873fca11d330afba9755d68ef20b84bfd0d1549579388a095d6cdc0bf35d0d0e4f5e6ecca7adb8027b7a971d6088fa22398cf320456a4b732048e5437a739d978d4d7797dd8f30e0537f16434ec2b84e504b462fbe5eaeff875e880f4c4d797ba4900e10546c52137767c484b5bc99fd2b66ab11f314d5abb9dcb2445d9de7c6d61c7df784d469747423945f6437ee0958b288a67e5c635d6f22e073962ed0cf0d7e22e59ec7ce6b62dfc8a666f00f84301c82ae3735cc0413709ab71f0981455923cf852232fb8af9c97c2f5945848d2655416f887fdf9d36922bf96f2df0318df73bf106501cfb0a32b3c9c09aa6d76f02e1bb34319d114a5ec5801ae8c77e41e3db7f78971a3046b946154a2eda8cb6a7fbc08746ac11b9b62bf9ad35f409006c06cb2a44ebdf10dc0e5344270c42e41a8320ce23386d2a44b1d267d66e3e0a12bbbbcfd5248fcd1cbd3ae1ebae096c05fdb392e01700e9571f26f0eb97399ef6c06101fd3ea3d27b5f4872a07911ec95b5ad370c92f31f6f6945698f518bfe704b9730d81fd65814d8a0d9b1cbec67567a7a6f92d0ad93f570da34f75410f0384c75d8dc38e9ee26ddde690cd7184138e6a9940c40a8ff94d5d3d19987f7628567e577868ace5619af0982a67a3aef9d443633d78135050acdada28082ee41ba1b0e14da15bb0c99b383b2e951a517c01c6696f00e82501c82ae3735cc0413709ab71b09b1455927faffa318c33f6e769a3a2932d7be162ff27eba94260877c35a8c882b04d72854bd8618f8ed7321ef7356c9caae0013c5633eac353dfa9ab431a46a45a0fbc2f4d15f730e91af5a1540903f9901f671bdd66fea450e0d5bac6d13b086778ac4ca0a04138abbcc277039051abcd06c11e954404ab0041336eb5f7dd9e137bb000e44f12b0e55a91e38d8d543b9ac09113371409ffc261bbe0370487932c2a63d11f59ecead21f852234fdfb42c2671246433cddc8a21dc2dc500bafbec3e110b594794d480e53881a75b3df0431b72183953c376bca35543f3b6afd31de455e5542afc8cc007f55d18201b0979bcc015a3d62d78285fedf14e402d8727e2b799344bd348e6e00a4dadfce88bbec9303552ad03d63776f000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 'qrcodes/3FernandezDenimar.png', 'RIh7s34g', 2, 6, 1, 1, '2015-07-29 10:01:09', '2015-07-29 10:02:33'),
(4, 'EMP-00004', 'Alvarez', 'Jose Antonio', 'A', 'employees/4AlvarezJoseAntonio.jpg', '1995-07-22', 'Marinduque St.', 'Brgy. LadLad', 'Marinduque', '09123456789', 'LGBT_Rules@gmail.com', '2015-08-04', 'Active', 0x00f87e01c82ae3735cc0413709ab7170b414559261a61b9b71cea3d81dd12580a4192c09904ca9fd270582fa14f3149d19b13083a43f8a99a28211acf39dae42b8181c403844ec48a1691c4dbaa01673df2c26c317281c9d1be20833d31f61e63e0927cd432703b3e2c56db144038b87a1d862092651b579b174938c8724536daa0086e88db321a663fd644639978c3bd1953f6b2c8aae9826fb93e5681405fe8ab0cb5fa02c032bc6de7c5165787a115beaadbda3e8769170af8515cf26d003b813e4dbc238ba38227717e94a486b48956abba4a08d59d555d45a6af7cf2581d5b4049e2f27f14131a3d8aec2ec57c0406b805ddcf9cb6c0eadccdd2608239a4586cb9e99c35ce7fbef5d9eda7e57b4f401f3c98bdd6df9017d72c92e9771335e7dcb1e56d41f6c2ec40ac5d95f3e0360593d9902adb7f50a490571061e8d8651a9a677b7a5f082479b33d50b34f077c64876687afd4322690f3946fc95586683af008d10c15772d490e0f772a21a09fb610dacdd446c2a357e5a266c47f7c7eac76f00f88001c82ae3735cc0413709ab7130b8145592b61c2a3a9e4653ebcdf38a144c98678b6d7ce385df41adcb54d69f1cf5a2ab3e3ce50e71f0235ad857d34551ef2ee228355b338e9d9407d284fb02d50d3fade1088389d6c2728beab157147ba13d4aec4d556b3555b06606bbdaa8f6ce9fff3c6c96b9c9cb03f2af5049445ef4ced0b62eaad83c6f37414818cc70a1e627b68b4bbd6e4fc4384005c002bf5ee02bd01bd038735af5d40ad277c8ac8a52be0d6627594dc8ceecebc083c87a86d7d59de6a52d89187d384634c2acc9770e82edf7e1ecc69bdfc94f92c1dd8eecdaaecf4314421eb1442b528fd615db5300521223998a2771ef9cbdaba36d6126efe4fbca2d0ebce21f845d59eec7ba7cf310e3f3675d45fff472e5c593c3bcfd7bf539ac1b5decb66ed7e0c5d12160a934ee95cfb5fd7d0ab1fb1a0eafb83da4365cb275d77713bc5b48d16ece16c9d3f52dfad9a96e3d9801e46b113436bd591c0c481b875e8cb3b2f161f98678ce91234980bcbb19767a523b99537407461859c57b576f00f87e01c82ae3735cc0413709ab71b0a31455921601461f984318727a4965bef1287383a31aac8187eec5a674621e3010cd252828100d997ce4161a408b11bf4a1565c6c8dfc9558411432654059f913aeec38e754d251f122860c7c927c17e9de5c2162187986959bbe24c932d6cb4463dfb5064d316fc70c695cfa67a218ea315f6103f33006c2ac8c128d823101b008e685c395d227222a4a837993cab7a87845ebc44a986740e56051d78e11d18fdff20c8fc2f641b3f14b77f569b722552758fc25cc3536004be02ec9e3686eced41cd4301258a7620f14e377269d00146dd44714be94db8d1de74760e87448f47c6f0d264230f87b552df2e378ac133f4e33652dcc247b1fba12103798906bbe750e9585ec6dce5f907e5528612ff63ffc402dbbaf61d5060c12991c471742d2baac974c7a7310bf380a32d17c577736933c006787c255327230b1a68bbcb9dc0c6adf99c9530c1a0594eed57ab1f5e79570a694629397080deabb640eb6732299ac12119f8459a3112462745989b8197c46f00e87f01c82ae3735cc0413709ab71f0a0145592845f34047d6f8ba0b869c129ce081ca4ea841c34b54154bf64c89c1ecc4af226a8f8eab2879aadc95f45e229038d1b4d520c238946dfe42d41b600d792ed6d244a288e64246e67461e0ad507d456a394b62f1d90db87b9de754b81206e80a942c998a22014edee7a50bd4bb4e1ed93feff14e3523df31c25447d1e010aa356830b2e431c0af7a32583121efd11cc6ed06d03f2eb03a8205c49703a634b19897431946a676cd5748b9f072cd49d3025309a4333928c31b8b22a7167482b78baa08cb23dab8586bed1e2c9a032f47663823dc3c9d5ae95a53b0854f8e19bf010fd5c5b12dce54224412629978bacf5109a96494b940ea9f9a015ec3d0e97e14dcdeed999aaa614a2b37de37ee7709db45f8d1c641c6f91f995f21a4608aed0438b62512e4b83adf8b438ab00e9aa9513ed85dbf6bd3989e676319106fc715b548857772cb8bec25c9d80f3b329a3170674a62f4c3adbc0d9d5f1556b875f0cd653a6a359d0d03eefd46fb565d6b573946f000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 'qrcodes/4AlvarezJoseAntonio.png', 'hvhCLgqh', 4, 1, 1, 4, '2015-07-29 10:06:26', '2015-07-29 10:06:26'),
(5, 'EMP-00005', 'Viovicente', 'Lorenzo Joshua', 'M', 'employees/5ViovicenteLorenzoJoshua.jpg', '1996-01-26', 'Kanor St.', 'Brgy Cembo', 'Makati', '09123456789', 'lorenzoviovicente@gmail.com', '2015-07-31', 'Active', 0x00f85201c82ae3735cc0413709ab71b0aa14559284e4f394a6cdbbd2b5d8a145cb9cb3f71eddcb1bc8ad9109d6d5003e5981b5dc2ea75b77a5e9809764cccf855fcaf3aff7a5377c332becc3daf54a4d813819bbff19bab3dde9572230690f195bc14a25688a472b5c4c5a51e9950811fda9a9922b532b7871245d5debcf36282e73d6e56e74a87fd4cc64526c028ec3f747f523763f13263e8a93a4d88cc6f73f89eea692747bc94b4ef4f5fb88013de8071f6da3020f88b1a55e546c61a667d06a2f0745962c9587b53b83d58be1283f4e6288c4f948817daf0922ec5d5a6fe6f5ba3e12e49d2d5021dd4500a15ebf7525e01499c753eb2c99997deee30d893969ea0a8065b5825a1c5a5d489f0f4f0080364ae6acb9f618e4403f42ea0c9ec8f2cee0a7da0c54ab9d4a1dce43d06229fc5999faac93d1ea5929d8c869dfdbdb39419dd55548b35690d6c96690d0ff775c284818066f00f86101c82ae3735cc0413709ab71b0a414559294493a04abf7a0cadc9c703809aa2667333e985b7458f2ab39d8a61e9a00eee7ab523d1a16cb93c188cf41104e84b68aeef84fb99a3f99209467705e78b92392fa1acbccc0fbd4414a7b12fe258cfc12b29a3a3f456ee6e5fb06a2f3a50dfe7dc928693acfaeea310172f3408c8b6c328c49a3658eec98e89025cdb1808df05197d59fecdf017961ab0ff837dd0baba561805cf92f9707a54ca0831f0cd95cabac55667847c09177ae97ba3bc1a8dd4db710a6a561b79a6dfbfa63f6b1c8fa6734b1eb32540f1a9bc6085b114ff8958d7664fc288fd8cc0f626a69a50c2a0bc6b879a10839739036b1c61839b2b355a4871f064c0cfeee211f2a240aedcb689aa5b3c21cefec4474d3ed15736fcb934e83101e927fa3cdca645b90e98b34e621f988933092b1421222d55f9d9d9cea93b472e57540bd43bc21c8132e5fd0d2207741cedd3fd1340a742dcb17ea31a957f16f00f87901c82ae3735cc0413709ab71b097145592c9a30fc358ecc730a52d0893a6978d61e447e790ddad954c2fc6862dc81a5fcb25f0ee2a4e9b09e75adc678be43f9e6b8f067c3d1221f531f743dc9882c2d24de814119c72bcbe54b5ef2ba80af8ed3e8a99bd4ac01f4fc0a3779258c9a1db19787717fbcd32f90f8df2a3ea62828ce4d0cdedacc7d4ba616f85222d9f68753888aef718fe0528e111fe5264fb7b216a17044948fdf1cff1bd81fc13ab58228a39d1e71d3b89add750fbe56762fba180805ed5cb5d8305a9bfbd0af7fbbf384ae0affdc7e491e6808655e4ebd621dbe86752392eeeb689f04a112dd77f2d58704e4afd68d1c6ff0611ae9eb822056bb83f8e40fac9ffb8b6674cbf273cd652706b6422a785fe39f4d6c13d725849166c5772ea23035f84ffff8262572c30879f806fa5abe58cab45ca5772e02b98f6900d413bc347aaddbeed9f8ee545e546db3542a1ca5376610b11dc35c804e7fabd2ec9c8ae61836b3d1de2bec5a3d4e81d6f43b36b78e271946c6f00e84601c82ae3735cc0413709ab71708e145592773f508ea02410238bd117b1385f3704db1059eff58ef4ba9a88c410add1364e9e28c797d4e8e535c2c6e37b3b974fee25a957629f6dc34c4a263cced2742877b0274fd2328db516f93a36c9fecd9f2de7a0e51ae02afdf8be8dc462d3e1a328ac8870e9282bae7a3affff21307d7370bd58a56df2184e1e1f9a4ef75e81c2c3470e9f4c4ff68e31a9acd15806c62ce835b9cde874825b15192c56d66561b798af13f0f522f3fb2a5b3a1b69c06152ea840abf556deb6cb921075b9ede31df507048b6b30ae29409f6c7a2ca07077667d3e53b9ba3e3df4cc3a33623a377ab1b3ac9b2a43099f0d209816ac6000f6b00ba6b78cca548fbb131bb5e0d9312f72b80a70870662e18fb2faa526aaae5f44da4c456cebfec7679c0cca904ea6fb65711c45214e31a8ea18d3512d1ebbd73b6c986c5e42e4f6f0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 'qrcodes/5ViovicenteLorenzoJoshua.png', '45UPn4kh', 5, 1, 1, 5, '2015-07-29 10:08:14', '2015-07-29 10:08:14'),
(6, 'EMP-00006', 'Sierra', 'Harrold', 'S', 'employees/6SierraHarrold.jpg', '1984-07-19', 'Antipolo St.', 'Brgy. Antipolo', 'Antipolo', '09123456789', 'harroldsierra@yahoo.com', '2015-08-21', 'Active', NULL, 'qrcodes/6SierraHarrold.png', 'Y6W7gr9q', 11, 1, 1, 0, '2015-07-29 10:13:34', '2015-07-29 10:13:34'),
(7, 'EMP-00007', 'Avecilla', 'Kenneth', 'S', 'employees/7AvecillaKenneth.jpg', '1993-07-21', 'Mongoloid St.', 'Brgy Abnoy', 'Quezon', '09784561235', 'kennethavecilla@outlook.com', '2015-08-02', 'Active', NULL, 'qrcodes/7AvecillaKenneth.png', '3rkl4nrd', 11, 1, 1, 0, '2015-07-29 10:15:17', '2015-07-29 10:15:17'),
(8, 'EMP-00008', 'Cantoria', 'Pablo', 'V', 'employees/8CantoriaPablo.jpg', '1994-11-29', 'Tata St.', 'Brgy. Tagay', 'Pasig', '09356547894', 'pablocantoria@senior.com', '2015-08-02', 'Active', NULL, 'qrcodes/8CantoriaPablo.png', 'CNdt1aaS', 9, 2, 1, 0, '2015-07-29 10:17:44', '2015-07-29 10:17:44'),
(9, 'EMP-00009', 'Grava', 'Eugene', 'S', 'employees/9GravaEugene.jpg', '1994-12-16', '123 Dingba St.', 'Brgy. Singma', 'Pasig', '09324567894', 'huge_in@lgbt.com', '2015-08-03', 'Active', NULL, 'qrcodes/9GravaEugene.png', 'rDoCU2HP', 9, 2, 1, 0, '2015-07-29 10:19:03', '2015-07-29 10:19:03'),
(10, 'EMP-00010', 'Ramos', 'Shaira Mae', 'A', 'employees/10RamosShairaMae.jpg', '1995-07-20', '143 Rock St.', 'Brgy. Ramos', 'Makati', '09154747561', 'saiaveros@yahoo.com', '2015-08-03', 'Active', NULL, 'qrcodes/10RamosShairaMae.png', 'xFZLSnNk', 10, 3, 1, 0, '2015-07-29 10:21:59', '2015-07-29 10:21:59'),
(11, 'EMP-00011', 'Alzate', 'Joshua', 'F', 'employees/11AlzateJoshua.jpg', '1940-06-25', '654 oyeah st.', 'Brgy. Nayon', 'Pasay', '09854561235', 'joshuaalzate@yahoo.com', '2015-08-02', 'Active', NULL, 'qrcodes/11AlzateJoshua.png', 'zJg2pRYx', 11, 4, 1, 0, '2015-07-29 10:27:13', '2015-07-29 10:27:13'),
(12, 'EMP-00012', 'Mataac', 'Christell Ann', 'C', 'employees/12MataacChristellAnn.jpg', '1995-08-22', '85 ehem St.', 'Brgy. Friendzone', 'Taguig', '09478543264', 'christellmataac@gmail.com', '2015-08-10', 'Active', NULL, 'qrcodes/12MataacChristellAnn.png', 'MvlYT4PP', 8, 3, 1, 0, '2015-07-29 10:29:26', '2015-07-29 10:29:26'),
(13, 'EMP-00013', 'Escano', 'Pristine', 'A', 'employees/13EscanoPristine.jpg', '1994-05-17', '15 Binibini St.', 'Brgy. Rampa', 'Quezon', '09486538549', 'projectrunway@yahoo.com', '2015-07-30', 'Active', NULL, 'qrcodes/13EscanoPristine.png', 'rr34uW2g', 11, 4, 1, 0, '2015-07-29 10:32:08', '2015-07-29 10:32:08'),
(14, 'EMP-00014', 'Pascual', 'Francis Eric', 'B', 'employees/14PascualFrancisEric.jpg', '1995-01-04', '25 Pogi St.', 'Brgy. Chickboy', 'Cainta', '09854851562', 'francispascual@gmail.com', '2015-08-04', 'Active', NULL, 'qrcodes/14PascualFrancisEric.png', 'I1LL1ATx', 11, 5, 1, 0, '2015-07-29 10:34:46', '2015-07-29 10:34:46'),
(15, 'EMP-00015', 'Aquino', 'Morriel', '', 'employees/15AquinoMorriel.jpg', '1996-03-01', '1174 Sa Puso ni Melody', 'San Laan', 'Manila', '09162451291', 'melody.legaspi@gmail.com', '2015-09-10', 'Active', 0x00f87f01c82ae3735cc0413709ab71b0f3145592e6d48184dde403f8296b975810c0f3aa6059ba35ab789aea5c8fe0cf38686939b085389e9ddf424d31957bcb5520e1cbc3bcf01fd4a8639d42a517d3f0ef752c95265b56e3f2bcb16aa4c2f55f688e3b5d56352989ce4e18aaff93cd79a32371680f2869ce817a2f967b3d531e02193358847199a3a85038693ece4a2d50e58cfc42a2b4ac6e2291207b21eee5d105e659deecdbf12c04a5aa96291b79ace95ce46bf77577583739ede1a0992e16ce1d100e45e1c2dc07a55a7370b03c23f63ef0a07555987727e044750a8f6f56cf6b03c1503d6a831e1cdcb1b2a8bf7878cc8e95561ec0b6b63b8e72a6c72d480a4e571e1e8dc841a03a7190e92b4786f2e217a8357cf2f76ee6b0dd3dc358a4c91d8fa71a0b728572a7be3238d217e5683005825488c9580a95d3e428e19edf412ef85375e022851ec56ebe60f9231dabfc1d3ddfcd910c97593ccd6b71fa5f141f98eec7e36571cfb41fb5ad96d8c81473fefaa84ab627a75380a7b8d1d8862b6f00f88001c82ae3735cc0413709ab7130d2145592cf9024a4430e584d0e48431cf2318903174a68f8d80cd5b8b5da591d9f8a78fd5e2be4cae274d031df21e2b24f33de7746a4b1b861876c1c99dfd5f3c7867f7d2be88fd5cbd7d5e4dacfd6a9f880b5c587415eaf2f4eb4444db52eabc5a6d17c4fb97d58b03366ba3d8a0c1a79cc4ee3f595edf77ad3d525eb6c6fc0c9a973d9544d53bde82c3154270204ca87bbd1b0daa78445f35148a5795858b4f36c2f32878089b97aaed5b0eb9963db13375bac0b39127fc528a0ee2619b895c47fe81c8e2965de592c2b3c2b4a4f2dfa26555da9aae9888a7c8a301840bb487410a5a1cd9cc5e7382ec0d66ada723eed175a1d0783ddf32865cf8403f6587ae3b578e0d4e481651c9ed10b558e4365f17666f51abbac03cab828de632708b24b31f70e3e8c6ef63c6c5dc59c883b2da7e820679fb92c3de76d0fc345b5947672c273ac0dbd433f5cc9fb58685da3b81adef219122a92a68ed2bc507efc08d6f6964d52932313353c4cf19e6cd1b8fe76bbf6556f00f88001c82ae3735cc0413709ab71b0f41455920c95782eb9e4d0a7101e98ce007e71efef4cebba7ecb212ecc4f5f42e4eb781feabf089ceecbaca19ed35b991ac96a96d413b90996c25ef6b60f8fd8db26b33f4adda7d3b92e890dc140f6f6421a3643eeabbd9f9b9972e203dacc6c7305e673c4c7e0560c0e07de78c61f2c4a6407a3ba1fed046c1a373bcd39d968eaa455f3171f3c55c509df43b43fd44d4b27c1df768f49c317611e91a588c25aa6d19cb2736181c30f4729d993f4353d7716bc8f5c662617c600a528d152241127d13854f33522e68acb4c2c6d952f85081fcfb0d6e998243f0b40c6391c858b40a8f35e10323711f83cb6f9af0c70032b6dadb60d6f2394bd6dd43042362fc29a9715cd5fe6fed6e13f524c8bc3958e9f4acbae1c13d74f293a2a350ddaed18032a11046c415176a23020c01c2c786adb3d65bc3d4682d79868425518a3c01cfa443ea3387df03d00ff1b43d404bbe132e508c5a0f69a81887eaa4366b77a503f869949dadcf59add09c1e5cbee451940e590006f00e88101c82ae3735cc0413709ab7170ec145592e99497d7d871f132c5ba87ea9de10d660e03e1e719305463bd2e5ec6e0547af285f948d8d6c99df7644f4c89a7e73547a7e6cfde4d5d130f49fc4b71138f09e76fe859be08cd9d3b1b7524a1ff6f3e87ee80ded5753ad314e272772d5ed85cca12ffc18455ba2c6098a4791dd3f424d68469ff48cd13bdf917a53ad5aa77c4b37b7980f52302c732e4f8e923447e08857ad974e9d20a551cc2d010a1a86d944e94f365bef32b0e44021a7542fd8b28de8676a6759818753fdbe8a882c343e845bc7c05ec283dc46a3462688b0eb49d0c20c4fc8dc5c3745baa277ea7b2ce4780518bb09d73727a48ad9dd85e5973855d73afa17184f681c11c21a7e48a48a81bf5a4416bdb472cc3471c61fdc2166a9e24b0c6c09f0f46cd4954482a9c31e03daa13febacd98e243a5b95dc447d5e34fded3f89ae545e80f94c3983acb4c59d38841a41d3ce8dd6161df5eea9a5f5da1805ccb8c520d3779379970a84bb97d38696578a35e8251fa3ea7f736d8c8fb4e936f00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 'qrcodes/15AquinoMorriel.png', '59wjY2b9', 5, 5, 1, 0, '2015-08-23 20:14:34', '2015-08-23 20:14:34'),
(16, 'EMP-00016', 'Bocauto', 'Christine Isabel', 'V', 'employees/16BocautoChristineIsabel.jpg', '1996-12-25', 'P Bonifacio', 'Sumilang', 'Pasig', '09151432163', 'christinebocauto@gmail.com', '2015-09-15', 'Active', 0x00f87101c82ae3735cc0413709ab71f0b4145592436d68f7a9ada1d2e92596d8cbd117ebbd6c93813cbc3fb6b3e38bc4b6a2c7fca5443c9c0673763bc8d31465451d17cae5c4c1fb76139eafb843d3762d19966d7170c1763920c1c83dca617aff6b1980a02f5e900fc0a607bdb4e24cc9fa3d35a35965b9819316d7e012379ee19e226652d270ccc5744f94de65c5ec463aa9820186d1742a789486d08b1227d0b6e388092939fabbed3a485ec0fdc188e8441eda7feb19ade5126328d147c9a4c0d8668ac5b841a2768f684d69a13e7a43a8569db37ef9471ea22b248d0a5098c3e5c92ba73db28de06715dbf3657bb660a9f84535163354bd4376915daab3926254d4f568076f74d7209f2e516933123a5d9e8a1beea8abb66bfd9cbf8dddb670709edb7a2f06dcf9346d4a69248662cf540b656a8056e59fbe90962fe22840e4178da189e1ffd608e363b4e1db6e07f3d74f51430e703419e4bda23ccb5ac5b884452305ce7f47e76d90973de3f9190421f4766f00f87e01c82ae3735cc0413709ab71f0b814559204627e407c091a64e7c7a79d80bb8e18dbf3e8ffd8a99a81ba6b80a6d4594a129bda70ae59b204eabd5f1a34c418c34dd483cdd5b1bb41a25d115839a02920c4c6e5b18cc40e4f272f4d424c327942d78cee35a3a000e801e0d64edab40a57ea2e647da23c3c53804835798cff5a62c365f7414bac5a3e1e381ad25e29a1a15d6beedf5a5f5c11b663a0031ba6bd00cb94aeffc4f00f69d8ee612410de49b14af44750a142698c8020ce0f6d490f7025852af3984602af0bda42bc8db1f51df1f590bf41de77adf8dfc80585c1594c9982c64b5dbb77f50881f0988107f88f552425029fa7a1f6f535d18d62f28c671453ca9d5d7c9721f43a325d0c967cfdbb3ad46eb34230e309cd277b1f34da12e665e67eb397d873f69538c786ccfd835f9a21dedcbb975d1e8eeb474f12178e068f5eb09da32cf75c97054f34f9501e74466afbc554b12afc21f7be206108d5dd6949bdc60f44d4aed29ab2a71d21988b6bd55912b25b5cf473d762f009786f00f88001c82ae3735cc0413709ab71709e145592a36d550d482975865c17ba7d1600cbe053e83078ff460487a02d54ed8727c9397c8146350be6c506e71d0d4df52f247d3d85351584935ddcaf1b6e7353dbc280e8c7c4345d3b7aad7d1da07329fb36def6c7bbfa3f1ac2ef6be95cfe4ae1bdb60040596de34e94b9a5b2ee3e6ecf532dc737ddc31d3bd7f65cbc1de9c10a278b623f08f871f0f064ab37bf2778238acfe70643b5aa53aca1909d229dab124f0da7144fe2e4dc70b99b5d3a7372f4a353df0e5b097acafb3d0ec3ef3e9eb29d9060e2395f4dd1998ad4f00dc0aaeb3056c91510972501772be420a78d57d525e470016302327c6f78c9a5ce983938014998ce2313488681c313a03882454631ed7bde8f49f8667e9767bfca16070b48e2327c6398bbd01d595a99a339014a896f7d3c07fa479bdd770ae57c6ccf31e8aecbf06adeccb158978cd5747a3c73289fe5cbccc4db451f614fcacd361b96b106faa2139733ce3596f13f9c2a36d997bfd5623f56db8f954483bc2b7b13cbf8286f00e81f01c82ae3735cc04101d6c4a078d9ace31be9a00882566144b7dc159b0e4b61d6635647a2e7673d1ae267faf160783f3743df719b479faba53fb5d9a174216a2ac112dffc4d1cb2f204ecdf4d321e0504a2b0e3c675816f99eec3e55e7fe0864e6960975e3267f27b7bb3d7f87f301f0594deb2e6730a2242fee9b8ec92d49af1c656be3bfd0eb5ac962675c8c1e6a9b73de468fc7272702301e6d90957aa6d87740d85e055ea9ec5ab55a5474e48434aab7487320ca5a1e403101ac93f417f0a3f554bbf8a905a5db2ee1c222ecc956132cc3538aef690b1f80c4ecc31a47235145e69b3129addb1b4b3fd70414e9628508fcbc68999fa02776b7bc51eb294eb3a9c711a3a07376cf8ebea03a41d91bc052aaf2d94c4f30566aec00a82220a5a6f00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000, 'qrcodes/16BocautoChristineIsabel.png', 'u4zoSWEY', 5, 2, 1, 0, '2015-08-23 20:41:36', '2015-08-23 20:41:36');

-- --------------------------------------------------------

--
-- Table structure for table `empschedules`
--

CREATE TABLE IF NOT EXISTS `empschedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `empschedules`
--

INSERT INTO `empschedules` (`id`, `employee_id`, `schedule_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 10, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `exception_groups`
--

CREATE TABLE IF NOT EXISTS `exception_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `exceptiongroup_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `exception_groups`
--

INSERT INTO `exception_groups` (`id`, `exceptiongroup_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Default', 'Default Exception triggers', '2015-07-29 11:12:45', '2015-07-29 11:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `exception_policies`
--

CREATE TABLE IF NOT EXISTS `exception_policies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_active` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exception_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `exception_policies`
--

INSERT INTO `exception_policies` (`id`, `is_active`, `exception_name`, `created_at`, `updated_at`) VALUES
(1, '1', 'Missing Out Punch', '2015-02-26 20:38:10', '2015-03-02 02:25:28'),
(2, '1', 'Unscheduled Absence', '2015-02-26 20:38:43', '2015-02-26 20:38:43'),
(3, '1', 'No Branch or Department', '2015-02-26 20:40:24', '2015-02-26 20:40:24'),
(4, '1', 'No Break', '2015-02-26 20:40:58', '2015-02-26 20:40:58'),
(5, '1', 'Too Few Breaks', '2015-02-26 20:41:45', '2015-02-26 20:41:45'),
(6, '1', 'Too Many Breaks', '2015-02-26 20:42:39', '2015-02-26 20:42:39'),
(7, '1', 'Short Break', '2015-02-26 20:43:18', '2015-02-26 20:44:46'),
(8, '1', 'Long Break', '2015-02-26 20:44:20', '2015-02-26 20:44:20'),
(9, '1', 'Missing In Punch', '2015-02-26 20:49:25', '2015-02-26 20:49:25'),
(10, '1', 'Missing Break In/Out Punch', '2015-02-26 20:53:29', '2015-02-26 20:53:29'),
(11, '1', 'Not Scheduled', '2015-02-26 20:53:53', '2015-02-26 20:53:53'),
(12, '1', 'In Early', '2015-02-26 20:56:17', '2015-02-26 20:56:17'),
(13, '1', 'In Late', '2015-02-26 20:58:56', '2015-02-26 20:58:56'),
(14, '1', 'Out Early', '2015-02-26 21:10:22', '2015-02-26 21:10:22'),
(15, '1', 'Out Late', '2015-02-26 21:12:09', '2015-02-26 21:12:09'),
(16, '1', 'TimeSheet Not Verified', '2015-02-26 21:19:32', '2015-02-26 21:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `hierarchies`
--

CREATE TABLE IF NOT EXISTS `hierarchies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hierarchy_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hierarchy_subordinates`
--

CREATE TABLE IF NOT EXISTS `hierarchy_subordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hierarchy_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_policies`
--

CREATE TABLE IF NOT EXISTS `holiday_policies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `holiday_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `default_schedule_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `recurring` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `day_of_month` int(11) NOT NULL,
  `month` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `holiday_policies`
--

INSERT INTO `holiday_policies` (`id`, `holiday_name`, `description`, `default_schedule_status`, `recurring`, `day_of_month`, `month`, `created_at`, `updated_at`) VALUES
(1, 'All Souls Day', 'Awooo!', 'Non-working', 'true', 1, 'November', '2015-07-29 09:32:15', '2015-07-29 09:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `itechs`
--

CREATE TABLE IF NOT EXISTS `itechs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `itechs`
--

INSERT INTO `itechs` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'IT_00001', 'jose123', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `jobtitles`
--

CREATE TABLE IF NOT EXISTS `jobtitles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jobtitle_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `jobtitles`
--

INSERT INTO `jobtitles` (`id`, `jobtitle_name`, `description`, `created_at`, `updated_at`) VALUES
(2, 'CEO', 'This is the ice cold Michelle Pfeiffer that white gold.', '2015-06-29 07:11:06', '2015-06-29 07:11:06'),
(3, 'Sales Manager', 'manager for sales department', '2015-07-29 08:56:33', '2015-07-29 08:56:33'),
(4, 'Assistant Sales Manager', 'Assistant manager for sales', '2015-07-29 08:57:54', '2015-07-29 08:57:54'),
(5, 'QA Supervisor', 'Supervisor for Quality Assurance', '2015-07-29 08:58:34', '2015-07-29 08:58:34'),
(6, 'Executive Head', 'head executive', '2015-07-29 09:57:17', '2015-07-29 09:57:17'),
(7, 'Programmer', 'programmer', '2015-07-29 10:10:34', '2015-07-29 10:10:34'),
(8, 'Database Administrator', 'Database Administrator', '2015-07-29 10:11:03', '2015-07-29 10:11:03'),
(9, 'QA Tester', 'QA Tester', '2015-07-29 10:11:25', '2015-07-29 10:11:25'),
(10, 'Technical Writer', 'Technical Writer', '2015-07-29 10:11:42', '2015-07-29 10:11:42'),
(11, 'Researcher', 'Researcher', '2015-07-29 10:11:55', '2015-07-29 10:11:55');

-- --------------------------------------------------------

--
-- Table structure for table `leave_grants`
--

CREATE TABLE IF NOT EXISTS `leave_grants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allowed_leave` int(11) NOT NULL,
  `grant_automatically` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `withrawable` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE IF NOT EXISTS `levels` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`id`, `number`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Senior Top Management', 'company highest level', '2015-07-29 08:50:08', '2015-07-29 08:50:08'),
(2, 2, 'Top Management', 'Company 2nd highest level', '2015-07-29 08:50:45', '2015-07-29 08:50:45'),
(3, 3, 'Managerial', 'Company 3rd highest level', '2015-07-29 08:51:20', '2015-07-29 08:51:20'),
(4, 4, 'Assistant Managerial', 'Company 4th level', '2015-07-29 08:51:50', '2015-07-29 08:51:50'),
(5, 5, 'Supervisory', 'Company 5th level', '2015-07-29 08:52:30', '2015-07-29 08:52:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2015_02_12_071336_create_users_table', 1),
('2015_02_25_075258_create_branches_table', 1),
('2015_02_25_093616_create_request_types_table', 1),
('2015_02_25_112415_create_attendances_table', 1),
('2015_02_25_120912_create_hierarchies_table', 1),
('2015_02_25_123324_create_holiday_policies_table', 1),
('2015_02_25_130802_create_overtime_policies_table', 1),
('2015_02_25_153322_create_exception_policies_table', 1),
('2015_02_25_162051_create_permissions_table', 1),
('2015_02_27_073932_create_create_requests_table', 1),
('2015_02_27_105217_create_contracts_table', 1),
('2015_02_27_122840_create_companies_table', 3),
('2015_02_27_151859_create_schedules_table', 6),
('2015_03_03_013658_create_stations_table', 8),
('2015_03_03_025853_create_policy_groups_table', 10),
('2015_03_03_062151_create_exception_groups_table', 12),
('2015_03_03_065130_create_assign_exceptions_table', 13),
('2015_03_03_082240_create_leave_grants_table', 14),
('2015_03_05_135453_create_pay_periods_table', 15),
('2015_06_16_022757_create_empschedules_table', 16),
('2015_02_25_145540_create_premium_policies_table', 17),
('2015_02_26_134008_create_accrual_policies_table', 18),
('2015_03_03_021058_create_departments_table', 19),
('2015_06_16_112748_create_credit_policies_table', 20),
('2015_02_27_124201_create_jobtitles_table', 21),
('2015_06_30_044133_create_itechs_table', 25),
('2015_02_25_134604_create_break_policies_table', 26),
('2015_06_30_062249_create_breaks_table', 26),
('2015_07_07_042404_create_levels_table', 27),
('2015_03_03_034419_create_employs_table', 28),
('2015_07_23_145234_create_assign_overtimes_table', 29),
('2015_07_23_173313_create_overtime_subordinates_table', 30),
('2015_07_24_053357_create_custom_overtimes_table', 31),
('2015_07_24_062226_create_custom_assign_overtimes_table', 32),
('2015_08_18_164445_create_downloads_table', 33);

-- --------------------------------------------------------

--
-- Table structure for table `overtime_policies`
--

CREATE TABLE IF NOT EXISTS `overtime_policies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `overtime_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `active_after` int(11) NOT NULL,
  `Allowed_number_of_hours` int(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `overtime_policies`
--

INSERT INTO `overtime_policies` (`id`, `overtime_name`, `description`, `active_after`, `Allowed_number_of_hours`, `created_at`, `updated_at`) VALUES
(1, 'Daily Overtime', 'Default Daily overtime allowed', 0, 4, '2015-07-29 08:27:53', '2015-07-29 08:27:53');

-- --------------------------------------------------------

--
-- Table structure for table `overtime_subordinates`
--

CREATE TABLE IF NOT EXISTS `overtime_subordinates` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `overtime_id` int(11) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  `active_after` int(50) DEFAULT NULL,
  `Allowed_number_of_hours` int(50) DEFAULT NULL,
  `range_from` date NOT NULL,
  `range_to` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pay_periods`
--

CREATE TABLE IF NOT EXISTS `pay_periods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payperiod_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `initial_payperiod` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pay_periods`
--

INSERT INTO `pay_periods` (`id`, `name`, `description`, `type`, `payperiod_day`, `initial_payperiod`, `created_at`, `updated_at`) VALUES
(1, 'bi-weekly', 'weekly pay period', 'Bi-Weekly', 'Sunday', '2015-03-08', '2015-03-05 08:28:10', '2015-03-05 08:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permissiongroup_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permissiongroup_name`, `description`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Permission', 'This is a description for Permission', 'Supervisor(Subordinates only)', '2015-02-27 05:55:47', '2015-02-27 05:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `policygroup_employees`
--

CREATE TABLE IF NOT EXISTS `policygroup_employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policygroup_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `policy_groups`
--

CREATE TABLE IF NOT EXISTS `policy_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `policygroup_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `exception_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `policy_groups`
--

INSERT INTO `policy_groups` (`id`, `policygroup_name`, `description`, `exception_id`, `created_at`, `updated_at`) VALUES
(1, 'Hourly Employees', 'Policy Group for hourly employees', 1, '2015-03-06 11:34:31', '2015-03-06 11:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `policy_group_accrual`
--

CREATE TABLE IF NOT EXISTS `policy_group_accrual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_group_id` int(11) NOT NULL,
  `accrual_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `policy_group_accrual`
--

INSERT INTO `policy_group_accrual` (`id`, `policy_group_id`, `accrual_id`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `policy_group_break`
--

CREATE TABLE IF NOT EXISTS `policy_group_break` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_group_id` int(11) NOT NULL,
  `break_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `policy_group_credit`
--

CREATE TABLE IF NOT EXISTS `policy_group_credit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_group_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `policy_group_holiday`
--

CREATE TABLE IF NOT EXISTS `policy_group_holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_group_id` int(11) NOT NULL,
  `holiday_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `policy_group_leavegrants`
--

CREATE TABLE IF NOT EXISTS `policy_group_leavegrants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_group_id` int(11) NOT NULL,
  `leavegrant_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `policy_group_overtime`
--

CREATE TABLE IF NOT EXISTS `policy_group_overtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_group_id` int(11) NOT NULL,
  `overtime_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `policy_group_overtime`
--

INSERT INTO `policy_group_overtime` (`id`, `policy_group_id`, `overtime_id`) VALUES
(1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `policy_group_premium`
--

CREATE TABLE IF NOT EXISTS `policy_group_premium` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_group_id` int(11) NOT NULL,
  `premium_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `premium_policies`
--

CREATE TABLE IF NOT EXISTS `premium_policies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `premium_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `sun_timein` time DEFAULT NULL,
  `sun_timeout` time DEFAULT NULL,
  `m_timein` time DEFAULT NULL,
  `m_timeout` time DEFAULT NULL,
  `t_timein` time DEFAULT NULL,
  `t_timeout` time DEFAULT NULL,
  `w_timein` time DEFAULT NULL,
  `w_timeout` time DEFAULT NULL,
  `th_timein` time DEFAULT NULL,
  `th_timeout` time DEFAULT NULL,
  `f_timein` time DEFAULT NULL,
  `f_timeout` time DEFAULT NULL,
  `sat_timein` time DEFAULT NULL,
  `sat_timeout` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `request_types`
--

CREATE TABLE IF NOT EXISTS `request_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `request_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE IF NOT EXISTS `schedules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `schedule_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `sun_timein` time DEFAULT NULL,
  `sun_timeout` time DEFAULT NULL,
  `m_timein` time DEFAULT NULL,
  `m_timeout` time DEFAULT NULL,
  `t_timein` time DEFAULT NULL,
  `t_timeout` time DEFAULT NULL,
  `w_timein` time DEFAULT NULL,
  `w_timeout` time DEFAULT NULL,
  `th_timein` time DEFAULT NULL,
  `th_timeout` time DEFAULT NULL,
  `f_timein` time DEFAULT NULL,
  `f_timeout` time DEFAULT NULL,
  `sat_timein` time DEFAULT NULL,
  `sat_timeout` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `schedule_name`, `description`, `sun_timein`, `sun_timeout`, `m_timein`, `m_timeout`, `t_timein`, `t_timeout`, `w_timein`, `w_timeout`, `th_timein`, `th_timeout`, `f_timein`, `f_timeout`, `sat_timein`, `sat_timeout`, `created_at`, `updated_at`) VALUES
(1, 'Regular Day Shift', 'regular government day shift schedule', '00:00:00', '00:00:00', '08:00:00', '17:00:00', '08:00:00', '17:00:00', '08:00:00', '17:00:00', '08:00:00', '17:00:00', '08:00:00', '17:00:00', '08:00:00', '17:00:00', '2015-07-29 08:41:21', '2015-07-29 08:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `stations`
--

CREATE TABLE IF NOT EXISTS `stations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `station_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `stations`
--

INSERT INTO `stations` (`id`, `status`, `station_name`, `type`, `source`, `description`, `branch_id`, `created_at`, `updated_at`) VALUES
(1, 'Enabled', 'Terminal 1 Sta.Mesa', 'PC', '192.168.254.100', 'Terminal 1 Sta. Mesa', 1, '2015-07-29 09:19:17', '2015-07-29 09:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Denimar Fernandez', 'admin', 'teams@FareMatrix.com', '$2y$10$ZmBeM8hPVvlIFFlt9HC/OOXHYJKHGhklmJmz3dMir7Vj3LWrrtI8u', 'Gv1W07CdwuJSaOUs8HFaXS94S9R8A1yJ16N0V7bbLlv4GWavU0ZhDlLIlq6y', '2015-02-27 03:21:49', '2015-08-18 18:24:49');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
