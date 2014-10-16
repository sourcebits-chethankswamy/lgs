-- phpMyAdmin SQL Dump
-- version 4.2.8
-- http://www.phpmyadmin.net
--
-- Host: localhost:8889
-- Generation Time: Oct 15, 2014 at 11:34 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lead_generation`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('197803b2070b92176e77624e7283993d', '192.168.16.121', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:32.0) Gecko/20100101 Firefox/32.0', 1413362331, ''),
('55326dfe07eb2e70dc6f1391f688701d', '192.168.16.121', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:32.0) Gecko/20100101 Firefox/32.0', 1413361989, 'a:4:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"2";s:10:"user_email";s:20:"admin@sourcebits.com";s:9:"logged_in";b:1;}'),
('9412c22aa9bb44c10003451540f1540a', '192.168.16.121', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:32.0) Gecko/20100101 Firefox/32.0', 1413365206, 'a:4:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"2";s:10:"user_email";s:20:"admin@sourcebits.com";s:9:"logged_in";b:1;}');

-- --------------------------------------------------------

--
-- Table structure for table `cronjob_settings`
--

CREATE TABLE `cronjob_settings` (
`id` int(11) NOT NULL,
  `site_id` int(11) DEFAULT NULL,
  `minute` varchar(5) DEFAULT NULL,
  `hour` varchar(5) DEFAULT NULL,
  `day-of-month` varchar(5) DEFAULT NULL,
  `month` varchar(5) DEFAULT NULL,
  `day-of-week` varchar(5) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cronjob_settings`
--

INSERT INTO `cronjob_settings` (`id`, `site_id`, `minute`, `hour`, `day-of-month`, `month`, `day-of-week`, `created_date`, `modified_date`) VALUES
(1, 1, '10', '*', '*', '*', '*', '2014-10-13 13:39:20', '2014-10-15 14:08:10');

-- --------------------------------------------------------

--
-- Table structure for table `emails_list`
--

CREATE TABLE `emails_list` (
`id` int(7) NOT NULL,
  `email` varchar(250) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0'' - deleted, ''1'' - active',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emails_list`
--

INSERT INTO `emails_list` (`id`, `email`, `status`, `created_date`, `updated_date`) VALUES
(1, 'himashu.arora@sourcebits.com', '1', '2014-10-10 11:08:32', '2014-10-14 12:23:15'),
(2, 'chethan.krishnaswamy@sourcebits.com', '1', '2014-10-10 11:08:44', '2014-10-10 11:08:44'),
(3, 'sai.rajesh@sourcebits.com', '0', '2014-10-10 13:39:57', '2014-10-15 14:07:23'),
(4, 'h.k@sourcebits.com', '0', '2014-10-14 21:02:05', '2014-10-14 21:02:53'),
(5, 'asdasd@asdasd.com', '0', '2014-10-15 14:05:41', '2014-10-15 14:05:45');

-- --------------------------------------------------------

--
-- Table structure for table `fields_list`
--

CREATE TABLE `fields_list` (
`id` int(7) NOT NULL,
  `site_id` int(7) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `field_type` enum('0','1','2','3') NOT NULL COMMENT '''0'' - input field, ''1'' - dropdown, ''2'' - checkbox, ''3'' - Multiselect Dropdown',
  `field_status` enum('0','1','2') NOT NULL COMMENT '''0'' - inactive, ''1'' - active, ''2'' - deleted',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fields_list`
--

INSERT INTO `fields_list` (`id`, `site_id`, `field_name`, `field_type`, `field_status`, `created_date`, `updated_date`) VALUES
(1, 1, 'Notice Type', '1', '1', '2014-10-08 17:32:58', NULL),
(2, 1, 'Multi Funding Agencies', '2', '1', '2014-10-08 17:34:01', NULL),
(3, 1, 'Sector', '1', '1', '2014-10-08 17:34:01', NULL),
(4, 1, 'Country/Region', '3', '1', '2014-10-08 17:34:01', NULL),
(5, 1, 'Bidding Type', '1', '1', '2014-10-08 17:34:01', NULL),
(6, 1, 'Date From', '1', '1', '2014-10-08 17:34:01', NULL),
(7, 1, 'Keyword Search', '0', '1', '2014-10-08 17:34:01', NULL),
(8, 1, 'Deadline', '1', '1', '2014-10-08 17:34:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `field_list_values`
--

CREATE TABLE `field_list_values` (
`id` int(7) NOT NULL,
  `field_id` int(7) NOT NULL,
  `field_value_name` varchar(200) DEFAULT NULL,
  `value` varchar(50) NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '''0'' - inactive, ''1'' - active, ''2'' - deleted',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=379 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `field_list_values`
--

INSERT INTO `field_list_values` (`id`, `field_id`, `field_value_name`, `value`, `status`, `created_date`, `updated_date`) VALUES
(7, 1, 'Tenders, RFPs & Prequalification', '1,2,3,7,10,11,16', '1', '2014-10-08 17:42:25', NULL),
(8, 2, 'mfa', '1', '1', '2014-10-08 17:42:25', NULL),
(9, 1, 'Projects', '9', '1', '2014-10-08 17:42:25', NULL),
(10, 1, 'Procurement News', '4,8', '1', '2014-10-08 17:42:25', NULL),
(11, 1, 'Contract Awards', '5', '1', '2014-10-08 17:42:25', NULL),
(12, 1, 'All', '1,2,3,7,10,11,16,9,4,8', '1', '2014-10-08 17:42:25', '2014-10-14 15:37:41'),
(13, 3, 'All Sector', '0', '1', '2014-10-08 17:47:19', '2014-10-14 15:37:41'),
(14, 3, 'Agriculture and Related Services', '01', '1', '2014-10-08 17:47:19', NULL),
(15, 3, 'Industry', '02', '1', '2014-10-08 17:47:19', NULL),
(16, 3, 'Industry - Automobiles', '0202', '1', '2014-10-08 17:47:19', NULL),
(17, 3, 'Industry - Cement', '0203', '1', '2014-10-08 17:47:19', NULL),
(18, 3, 'Industry - Chemicals and Fertilizers', '0204', '1', '2014-10-08 17:47:19', NULL),
(19, 3, 'Industry - Leather', '0205', '1', '2014-10-08 17:47:19', NULL),
(20, 3, 'Industry - Machinery', '0206', '1', '2014-10-08 17:47:19', NULL),
(21, 3, 'Industry - Minerals and Metals', '0207', '1', '2014-10-08 17:47:19', NULL),
(22, 3, 'Industry - Mining', '0208', '1', '2014-10-08 17:47:19', NULL),
(23, 3, 'Industry - Paper &amp; Packaging', '0209', '1', '2014-10-08 17:47:19', NULL),
(24, 3, 'Industry - Plastic &amp; Rubber', '0210', '1', '2014-10-08 17:47:19', NULL),
(25, 3, 'Industry - Textiles', '0211', '1', '2014-10-08 17:47:19', NULL),
(26, 3, 'Industry - Fire Safety and Security', '0212', '1', '2014-10-08 17:47:19', NULL),
(27, 3, 'Industry - Printing and publishing', '0214', '1', '2014-10-08 17:47:19', NULL),
(28, 3, 'Industry - Furniture', '0215', '1', '2014-10-08 17:47:19', NULL),
(29, 3, 'Retail', '03', '1', '2014-10-08 17:47:19', NULL),
(30, 3, 'Real Estate', '04', '1', '2014-10-08 17:47:19', NULL),
(31, 3, 'BPO', '05', '1', '2014-10-08 17:47:19', NULL),
(32, 3, 'SME', '06', '1', '2014-10-08 17:47:19', NULL),
(33, 3, 'Research &amp; Development', '07', '1', '2014-10-08 17:47:19', NULL),
(34, 3, 'Science &amp; Technology', '08', '1', '2014-10-08 17:47:19', NULL),
(35, 3, 'Engineering Procurement &amp; Construction (EPC)', '09', '1', '2014-10-08 17:47:19', NULL),
(36, 3, 'Sports', '10', '1', '2014-10-08 17:47:19', NULL),
(37, 3, 'Telecommunications', '17', '1', '2014-10-08 17:47:19', NULL),
(38, 3, 'Healthcare and Medical', '18', '1', '2014-10-08 17:47:19', NULL),
(39, 3, 'Energy, Power and Electrical', '19', '1', '2014-10-08 17:47:19', NULL),
(40, 3, 'Energy &amp; Power - Industrial Automation', '1928', '1', '2014-10-08 17:47:19', NULL),
(41, 3, 'Energy &amp; Power - Renewable Energy', '1929', '1', '2014-10-08 17:47:19', NULL),
(42, 3, 'Energy &amp; Power - Non-Renewable Energy', '1930', '1', '2014-10-08 17:47:19', NULL),
(43, 3, 'Water and Sanitation', '20', '1', '2014-10-08 17:47:19', NULL),
(44, 3, 'Transportation', '21', '1', '2014-10-08 17:47:19', NULL),
(45, 3, 'Transportation - Airports &amp; Aviation', '2101', '1', '2014-10-08 17:47:19', NULL),
(46, 3, 'Transportation - Ports,Waterways and Shipping', '2102', '1', '2014-10-08 17:47:19', NULL),
(47, 3, 'Transportation - Railways', '2103', '1', '2014-10-08 17:47:19', NULL),
(48, 3, 'Transportation - Roads and highways', '2104', '1', '2014-10-08 17:47:19', NULL),
(49, 3, 'Banking, Finance, Insurance and Securities (BFIS)', '26', '1', '2014-10-08 17:47:19', NULL),
(50, 3, 'BFIS - Insurance', '2607', '1', '2014-10-08 17:47:19', NULL),
(51, 3, 'BFIS - Merger &amp; Acquisition', '2611', '1', '2014-10-08 17:47:19', NULL),
(52, 3, 'Information Technology (IT)', '27', '1', '2014-10-08 17:47:19', NULL),
(53, 3, 'IT - Access Control', '2703', '1', '2014-10-08 17:47:19', NULL),
(54, 3, 'IT - GIS / GPS', '2704', '1', '2014-10-08 17:47:19', NULL),
(55, 3, 'Consultancy', '28', '1', '2014-10-08 17:47:19', NULL),
(56, 3, 'Consultancy - Education', '2801', '1', '2014-10-08 17:47:19', NULL),
(57, 3, 'Consultancy - Engineering', '2802', '1', '2014-10-08 17:47:19', NULL),
(58, 3, 'Consultancy - Financial', '2803', '1', '2014-10-08 17:47:19', NULL),
(59, 3, 'Consultancy - Health', '2804', '1', '2014-10-08 17:47:19', NULL),
(60, 3, 'Consultancy - HR', '2805', '1', '2014-10-08 17:47:19', NULL),
(61, 3, 'Consultancy - IT', '2806', '1', '2014-10-08 17:47:19', NULL),
(62, 3, 'Consultancy - Management', '2807', '1', '2014-10-08 17:47:19', NULL),
(63, 3, 'Consultancy - Oil &amp; Gas', '2808', '1', '2014-10-08 17:47:19', NULL),
(64, 3, 'Consultancy - Security', '2809', '1', '2014-10-08 17:47:19', NULL),
(65, 3, 'Consultancy - Tourism', '2810', '1', '2014-10-08 17:47:19', NULL),
(66, 3, 'Consultancy - Law', '2811', '1', '2014-10-08 17:47:19', NULL),
(67, 3, 'Oil and Gas', '44', '1', '2014-10-08 17:47:19', NULL),
(68, 3, 'Services', '45', '1', '2014-10-08 17:47:19', NULL),
(69, 3, 'Services - Entertainment &amp; Media', '4501', '1', '2014-10-08 17:47:19', NULL),
(70, 3, 'Services - Postal and Telegraph', '4503', '1', '2014-10-08 17:47:19', NULL),
(71, 3, 'Education', '46', '1', '2014-10-08 17:47:19', NULL),
(72, 3, 'Infrastructure and construction', '47', '1', '2014-10-08 17:47:19', NULL),
(73, 3, 'Infrastructure - Roads and Highways', '4701', '1', '2014-10-08 17:47:19', NULL),
(74, 3, 'Infrastructure - Bridges', '4702', '1', '2014-10-08 17:47:19', NULL),
(75, 3, 'Infrastructure - Tunnels', '4703', '1', '2014-10-08 17:47:19', NULL),
(76, 3, 'Infrastructure - Airports', '4705', '1', '2014-10-08 17:47:19', NULL),
(77, 3, 'Infrastructure - Building', '4708', '1', '2014-10-08 17:47:19', NULL),
(78, 3, 'Environment and Pollution', '55', '1', '2014-10-08 17:47:19', NULL),
(79, 3, 'Defence', '56', '1', '2014-10-08 17:47:19', NULL),
(80, 3, 'Public Private Partnership (PPP)', '57', '1', '2014-10-08 17:47:19', NULL),
(81, 3, 'Privatisation', '58', '1', '2014-10-08 17:47:19', NULL),
(82, 3, 'Rehabilitation', '60', '1', '2014-10-08 17:47:19', NULL),
(83, 3, 'Export and Trade', '63', '1', '2014-10-08 17:47:19', NULL),
(84, 4, 'All Region', '0', '1', '2014-10-08 17:58:09', '2014-10-14 12:25:03'),
(85, 4, 'Africa Region', 'REG0100', '1', '2014-10-08 17:58:09', NULL),
(86, 4, 'Central Africa/Middle Africa Region', 'REG0101', '1', '2014-10-08 17:58:09', NULL),
(87, 4, 'East Africa/Eastern Africa Region', 'REG0102', '1', '2014-10-08 17:58:09', NULL),
(88, 4, 'North Africa/Northern Africa Region', 'REG0103', '1', '2014-10-08 17:58:09', NULL),
(89, 4, 'Southern Africa Region', 'REG0104', '1', '2014-10-08 17:58:09', NULL),
(90, 4, 'West Africa Region', 'REG0105', '1', '2014-10-08 17:58:09', NULL),
(91, 4, 'Sub-Saharan Africa Region', 'REG0106', '1', '2014-10-08 17:58:09', NULL),
(92, 4, 'Americas Region', 'REG0200', '1', '2014-10-08 17:58:09', NULL),
(93, 4, 'Caribbean Region', 'REG0201', '1', '2014-10-08 17:58:09', NULL),
(94, 4, 'Central America Region', 'REG0202', '1', '2014-10-08 17:58:09', NULL),
(95, 4, 'Northern America Region', 'REG0203', '1', '2014-10-08 17:58:09', NULL),
(96, 4, 'South America Region', 'REG0204', '1', '2014-10-08 17:58:09', NULL),
(97, 4, 'Latin America Region', 'REG0205', '1', '2014-10-08 17:58:09', NULL),
(98, 4, 'Asia Region', 'REG0300', '1', '2014-10-08 17:58:09', '2014-10-14 15:37:41'),
(99, 4, 'Central Asia Region', 'REG0301', '1', '2014-10-08 17:58:09', NULL),
(100, 4, 'Eastern Asia Region', 'REG0302', '1', '2014-10-08 17:58:09', NULL),
(101, 4, 'Middle East Region', 'REG0303', '1', '2014-10-08 17:58:09', NULL),
(102, 4, 'South Asia Region', 'REG0304', '1', '2014-10-08 17:58:09', NULL),
(103, 4, 'South East Asia Region', 'REG0305', '1', '2014-10-08 17:58:09', NULL),
(104, 4, 'Western Asia Region', 'REG0306', '1', '2014-10-08 17:58:09', NULL),
(105, 4, 'SAARC Region', 'REG0307', '1', '2014-10-08 17:58:09', NULL),
(106, 4, 'GCC Countries Region', 'REG0308', '1', '2014-10-08 17:58:09', NULL),
(107, 4, 'Gulf Countries Region', 'REG0309', '1', '2014-10-08 17:58:09', NULL),
(108, 4, 'Australia &amp; Oceania Region', 'REG0400', '1', '2014-10-08 17:58:09', NULL),
(109, 4, 'Australia and New Zealand Region', 'REG0401', '1', '2014-10-08 17:58:09', NULL),
(110, 4, 'Melanesia Region', 'REG0402', '1', '2014-10-08 17:58:09', NULL),
(111, 4, 'Micronesia Region', 'REG0403', '1', '2014-10-08 17:58:09', NULL),
(112, 4, 'Polynesia Region', 'REG0404', '1', '2014-10-08 17:58:09', NULL),
(113, 4, 'South Pacific Oceania Region', 'REG0405', '1', '2014-10-08 17:58:09', NULL),
(114, 4, 'Europe Region', 'REG0500', '1', '2014-10-08 17:58:09', NULL),
(115, 4, 'Eastern Europe Region', 'REG0501', '1', '2014-10-08 17:58:09', NULL),
(116, 4, 'Northern Europe Region', 'REG0502', '1', '2014-10-08 17:58:09', NULL),
(117, 4, 'Southern Europe Region', 'REG0503', '1', '2014-10-08 17:58:09', NULL),
(118, 4, 'Western Europe Region', 'REG0504', '1', '2014-10-08 17:58:09', NULL),
(119, 4, 'Central Europe Region', 'REG0505', '1', '2014-10-08 17:58:09', NULL),
(120, 4, 'Baltic Region', 'REG0506', '1', '2014-10-08 17:58:09', NULL),
(121, 4, 'CIS Region', 'REG0600', '1', '2014-10-08 17:58:09', NULL),
(122, 4, 'Mediterranean Region', 'REG0700', '1', '2014-10-08 17:58:09', NULL),
(123, 4, 'MENA Countries Region', 'REG0800', '1', '2014-10-08 17:58:09', NULL),
(124, 4, 'Asia Pacific Region', 'REG0900', '1', '2014-10-08 17:58:09', NULL),
(125, 4, 'APEC Countries Region', 'REG1000', '1', '2014-10-08 17:58:09', NULL),
(126, 4, 'Balkan Region Region', 'REG1100', '1', '2014-10-08 17:58:09', NULL),
(127, 4, 'Afghanistan', 'AF', '1', '2014-10-08 17:58:09', NULL),
(128, 4, 'Albania', 'AL', '1', '2014-10-08 17:58:09', NULL),
(129, 4, 'Algeria', 'DZ', '1', '2014-10-08 17:58:09', NULL),
(130, 4, 'American Samoa', 'AS', '1', '2014-10-08 17:58:09', NULL),
(131, 4, 'Andorra', 'AD', '1', '2014-10-08 17:58:09', NULL),
(132, 4, 'Angola', 'AO', '1', '2014-10-08 17:58:09', NULL),
(133, 4, 'Anguilla', 'AI', '1', '2014-10-08 17:58:09', NULL),
(134, 4, 'Antigua And Barbuda', 'AG', '1', '2014-10-08 17:58:09', NULL),
(135, 4, 'Argentina', 'AR', '1', '2014-10-08 17:58:09', NULL),
(136, 4, 'Armenia', 'AM', '1', '2014-10-08 17:58:09', NULL),
(137, 4, 'Aruba', 'AW', '1', '2014-10-08 17:58:09', NULL),
(138, 4, 'Australia', 'AU', '1', '2014-10-08 17:58:09', NULL),
(139, 4, 'Austria', 'AT', '1', '2014-10-08 17:58:09', NULL),
(140, 4, 'Azerbaijan', 'AZ', '1', '2014-10-08 17:58:09', NULL),
(141, 4, 'Bahamas', 'BS', '1', '2014-10-08 17:58:09', NULL),
(142, 4, 'Bahrain', 'BH', '1', '2014-10-08 17:58:09', NULL),
(143, 4, 'Bangladesh', 'BD', '1', '2014-10-08 17:58:09', NULL),
(144, 4, 'Barbados', 'BB', '1', '2014-10-08 17:58:09', NULL),
(145, 4, 'Belarus', 'BY', '1', '2014-10-08 17:58:09', NULL),
(146, 4, 'Belgium', 'BE', '1', '2014-10-08 17:58:09', NULL),
(147, 4, 'Belize', 'BZ', '1', '2014-10-08 17:58:09', NULL),
(148, 4, 'Benin', 'BJ', '1', '2014-10-08 17:58:09', NULL),
(149, 4, 'Bermuda', 'BM', '1', '2014-10-08 17:58:09', NULL),
(150, 4, 'Bhutan', 'BT', '1', '2014-10-08 17:58:09', NULL),
(151, 4, 'Bolivia', 'BO', '1', '2014-10-08 17:58:09', NULL),
(152, 4, 'Bosnia And Herzegovina', 'BA', '1', '2014-10-08 17:58:09', NULL),
(153, 4, 'Botswana', 'BW', '1', '2014-10-08 17:58:09', NULL),
(154, 4, 'Bouvet Island', 'BV', '1', '2014-10-08 17:58:09', NULL),
(155, 4, 'Brazil', 'BR', '1', '2014-10-08 17:58:09', NULL),
(156, 4, 'British Indian Ocean Territory', 'IO', '1', '2014-10-08 17:58:09', NULL),
(157, 4, 'Brunei Darussalam', 'BN', '1', '2014-10-08 17:58:09', NULL),
(158, 4, 'Bulgaria', 'BG', '1', '2014-10-08 17:58:09', NULL),
(159, 4, 'Burkina Faso', 'BF', '1', '2014-10-08 17:58:09', NULL),
(160, 4, 'Burundi', 'BI', '1', '2014-10-08 17:58:09', NULL),
(161, 4, 'Cambodia', 'KH', '1', '2014-10-08 17:58:09', NULL),
(162, 4, 'Cameroon', 'CM', '1', '2014-10-08 17:58:09', NULL),
(163, 4, 'Canada', 'CA', '1', '2014-10-08 17:58:09', NULL),
(164, 4, 'Cape Verde', 'CV', '1', '2014-10-08 17:58:09', NULL),
(165, 4, 'Cayman Islands', 'KY', '1', '2014-10-08 17:58:09', NULL),
(166, 4, 'Central African Republic', 'CF', '1', '2014-10-08 17:58:09', NULL),
(167, 4, 'Chad', 'TD', '1', '2014-10-08 17:58:09', NULL),
(168, 4, 'Chile', 'CL', '1', '2014-10-08 17:58:09', NULL),
(169, 4, 'China', 'CN', '1', '2014-10-08 17:58:09', NULL),
(170, 4, 'Christmas Islands', 'CX', '1', '2014-10-08 17:58:09', NULL),
(171, 4, 'Cocos (keeling) Islands', 'CC', '1', '2014-10-08 17:58:09', NULL),
(172, 4, 'Colombia', 'CO', '1', '2014-10-08 17:58:09', NULL),
(173, 4, 'Comoros', 'KM', '1', '2014-10-08 17:58:09', NULL),
(174, 4, 'Congo Democratic Republic Of', 'CD', '1', '2014-10-08 17:58:09', NULL),
(175, 4, 'Congo Peoples Republic Of', 'CG', '1', '2014-10-08 17:58:09', NULL),
(176, 4, 'Cook Islands', 'CK', '1', '2014-10-08 17:58:09', NULL),
(177, 4, 'Costa Rica', 'CR', '1', '2014-10-08 17:58:09', NULL),
(178, 4, 'Cote Dlvoire', 'CI', '1', '2014-10-08 17:58:09', NULL),
(179, 4, 'Croatia', 'HR', '1', '2014-10-08 17:58:09', NULL),
(180, 4, 'Cuba', 'CU', '1', '2014-10-08 17:58:09', NULL),
(181, 4, 'Cyprus', 'CY', '1', '2014-10-08 17:58:09', NULL),
(182, 4, 'Czech Republic', 'CZ', '1', '2014-10-08 17:58:09', NULL),
(183, 4, 'Denmark', 'DK', '1', '2014-10-08 17:58:09', NULL),
(184, 4, 'Djibouti', 'DJ', '1', '2014-10-08 17:58:09', NULL),
(185, 4, 'Dominica', 'DM', '1', '2014-10-08 17:58:09', NULL),
(186, 4, 'Dominican Republic', 'DO', '1', '2014-10-08 17:58:09', NULL),
(187, 4, 'Ecuador', 'EC', '1', '2014-10-08 17:58:09', NULL),
(188, 4, 'Egypt', 'EG', '1', '2014-10-08 17:58:09', NULL),
(189, 4, 'El Salvador', 'SV', '1', '2014-10-08 17:58:09', NULL),
(190, 4, 'Equatorial Guinea', 'GQ', '1', '2014-10-08 17:58:09', NULL),
(191, 4, 'Eritrea', 'ER', '1', '2014-10-08 17:58:09', NULL),
(192, 4, 'Estonia', 'EE', '1', '2014-10-08 17:58:09', NULL),
(193, 4, 'Ethiopia', 'ET', '1', '2014-10-08 17:58:09', NULL),
(194, 4, 'Falkland Islands', 'FK', '1', '2014-10-08 17:58:09', NULL),
(195, 4, 'Faroe Islands', 'FO', '1', '2014-10-08 17:58:09', NULL),
(196, 4, 'Fiji', 'FJ', '1', '2014-10-08 17:58:09', NULL),
(197, 4, 'Finland', 'FI', '1', '2014-10-08 17:58:09', NULL),
(198, 4, 'France', 'FR', '1', '2014-10-08 17:58:09', NULL),
(199, 4, 'French Guiana', 'GF', '1', '2014-10-08 17:58:09', NULL),
(200, 4, 'French Polynesia', 'PF', '1', '2014-10-08 17:58:09', NULL),
(201, 4, 'Gabon', 'GA', '1', '2014-10-08 17:58:09', NULL),
(202, 4, 'Gambia', 'GM', '1', '2014-10-08 17:58:09', NULL),
(203, 4, 'Georgia', 'GE', '1', '2014-10-08 17:58:09', NULL),
(204, 4, 'Germany', 'DE', '1', '2014-10-08 17:58:09', NULL),
(205, 4, 'Ghana', 'GH', '1', '2014-10-08 17:58:09', NULL),
(206, 4, 'Gibraltar', 'GI', '1', '2014-10-08 17:58:09', NULL),
(207, 4, 'Greece', 'GR', '1', '2014-10-08 17:58:09', NULL),
(208, 4, 'Greenland', 'GL', '1', '2014-10-08 17:58:09', NULL),
(209, 4, 'Grenada', 'GD', '1', '2014-10-08 17:58:09', NULL),
(210, 4, 'Guadeloupe', 'GP', '1', '2014-10-08 17:58:09', NULL),
(211, 4, 'Guam', 'GU', '1', '2014-10-08 17:58:09', NULL),
(212, 4, 'Guatemala', 'GT', '1', '2014-10-08 17:58:09', NULL),
(213, 4, 'Guinea', 'GN', '1', '2014-10-08 17:58:09', NULL),
(214, 4, 'Guinea-bissau', 'GW', '1', '2014-10-08 17:58:09', NULL),
(215, 4, 'Guyana', 'GY', '1', '2014-10-08 17:58:09', NULL),
(216, 4, 'Haiti', 'HT', '1', '2014-10-08 17:58:09', NULL),
(217, 4, 'Honduras', 'HN', '1', '2014-10-08 17:58:09', NULL),
(218, 4, 'Hong Kong', 'HK', '1', '2014-10-08 17:58:09', NULL),
(219, 4, 'Hungary', 'HU', '1', '2014-10-08 17:58:09', NULL),
(220, 4, 'Iceland', 'IS', '1', '2014-10-08 17:58:09', NULL),
(221, 4, 'India', 'IN', '1', '2014-10-08 17:58:09', NULL),
(222, 4, 'Indonesia', 'ID', '1', '2014-10-08 17:58:09', NULL),
(223, 4, 'Iran Islamic Republic Of', 'IR', '1', '2014-10-08 17:58:09', NULL),
(224, 4, 'Iraq', 'IQ', '1', '2014-10-08 17:58:09', NULL),
(225, 4, 'Ireland', 'IE', '1', '2014-10-08 17:58:09', NULL),
(226, 4, 'Isle Of Man', 'IM', '1', '2014-10-08 17:58:09', NULL),
(227, 4, 'Israel', 'IL', '1', '2014-10-08 17:58:09', NULL),
(228, 4, 'Italy', 'IT', '1', '2014-10-08 17:58:09', NULL),
(229, 4, 'Jamaica', 'JM', '1', '2014-10-08 17:58:09', NULL),
(230, 4, 'Japan', 'JP', '1', '2014-10-08 17:58:09', NULL),
(231, 4, 'Jordan', 'JO', '1', '2014-10-08 17:58:09', NULL),
(232, 4, 'Kazakhstan', 'KZ', '1', '2014-10-08 17:58:09', NULL),
(233, 4, 'Kenya', 'KE', '1', '2014-10-08 17:58:09', NULL),
(234, 4, 'Kiribati', 'KI', '1', '2014-10-08 17:58:09', NULL),
(235, 4, 'Korea Democratic Peoples Republic Of', 'KP', '1', '2014-10-08 17:58:09', NULL),
(236, 4, 'Korea Republic Of', 'KR', '1', '2014-10-08 17:58:09', NULL),
(237, 4, 'Kosovo', 'KV', '1', '2014-10-08 17:58:09', NULL),
(238, 4, 'Kuwait', 'KW', '1', '2014-10-08 17:58:09', NULL),
(239, 4, 'Kyrgyzstan', 'KG', '1', '2014-10-08 17:58:09', NULL),
(240, 4, 'Lao Peoples Democratic Republic', 'LA', '1', '2014-10-08 17:58:09', NULL),
(241, 4, 'Latvia', 'LV', '1', '2014-10-08 17:58:09', NULL),
(242, 4, 'Lebanon', 'LB', '1', '2014-10-08 17:58:09', NULL),
(243, 4, 'Lesotho', 'LS', '1', '2014-10-08 17:58:09', NULL),
(244, 4, 'Liberia', 'LR', '1', '2014-10-08 17:58:09', NULL),
(245, 4, 'Libya', 'LY', '1', '2014-10-08 17:58:09', NULL),
(246, 4, 'Liechtenstein', 'LI', '1', '2014-10-08 17:58:09', NULL),
(247, 4, 'Lithuania', 'LT', '1', '2014-10-08 17:58:09', NULL),
(248, 4, 'Luxembourg', 'LU', '1', '2014-10-08 17:58:09', NULL),
(249, 4, 'Macau', 'MO', '1', '2014-10-08 17:58:09', NULL),
(250, 4, 'Macedonia', 'MK', '1', '2014-10-08 17:58:09', NULL),
(251, 4, 'Madagascar', 'MG', '1', '2014-10-08 17:58:09', NULL),
(252, 4, 'Malawi', 'MW', '1', '2014-10-08 17:58:09', NULL),
(253, 4, 'Malaysia', 'MY', '1', '2014-10-08 17:58:09', NULL),
(254, 4, 'Maldives', 'MV', '1', '2014-10-08 17:58:09', NULL),
(255, 4, 'Mali', 'ML', '1', '2014-10-08 17:58:09', NULL),
(256, 4, 'Malta', 'MT', '1', '2014-10-08 17:58:09', NULL),
(257, 4, 'Marshall Islands', 'MH', '1', '2014-10-08 17:58:09', NULL),
(258, 4, 'Martinique', 'MQ', '1', '2014-10-08 17:58:09', NULL),
(259, 4, 'Mauritania', 'MR', '1', '2014-10-08 17:58:09', NULL),
(260, 4, 'Mauritius', 'MU', '1', '2014-10-08 17:58:09', NULL),
(261, 4, 'Mayotte Islands', 'YT', '1', '2014-10-08 17:58:09', NULL),
(262, 4, 'Mexico', 'MX', '1', '2014-10-08 17:58:09', NULL),
(263, 4, 'Micronesia (federated States Of)', 'FM', '1', '2014-10-08 17:58:09', NULL),
(264, 4, 'Moldova Republic Of', 'MD', '1', '2014-10-08 17:58:09', NULL),
(265, 4, 'Monaco', 'MC', '1', '2014-10-08 17:58:09', NULL),
(266, 4, 'Mongolia', 'MN', '1', '2014-10-08 17:58:09', NULL),
(267, 4, 'Montenegro', 'MJ', '1', '2014-10-08 17:58:09', NULL),
(268, 4, 'Montserrat', 'MS', '1', '2014-10-08 17:58:09', NULL),
(269, 4, 'Morocco', 'MA', '1', '2014-10-08 17:58:09', NULL),
(270, 4, 'Mozambique', 'MZ', '1', '2014-10-08 17:58:09', NULL),
(271, 4, 'Myanmar', 'MM', '1', '2014-10-08 17:58:09', NULL),
(272, 4, 'Namibia', 'NA', '1', '2014-10-08 17:58:09', NULL),
(273, 4, 'Nauru', 'NR', '1', '2014-10-08 17:58:09', NULL),
(274, 4, 'Nepal', 'NP', '1', '2014-10-08 17:58:09', NULL),
(275, 4, 'Netherlands Antilles', 'AN', '1', '2014-10-08 17:58:09', NULL),
(276, 4, 'Netherlands', 'NL', '1', '2014-10-08 17:58:09', NULL),
(277, 4, 'New Caledonia', 'NC', '1', '2014-10-08 17:58:09', NULL),
(278, 4, 'New Zealand', 'NZ', '1', '2014-10-08 17:58:09', NULL),
(279, 4, 'Nicaragua', 'NI', '1', '2014-10-08 17:58:09', NULL),
(280, 4, 'Niger', 'NE', '1', '2014-10-08 17:58:09', NULL),
(281, 4, 'Nigeria', 'NG', '1', '2014-10-08 17:58:09', NULL),
(282, 4, 'Niue', 'NU', '1', '2014-10-08 17:58:09', NULL),
(283, 4, 'Norfolk Islands', 'NF', '1', '2014-10-08 17:58:09', NULL),
(284, 4, 'Northern Mariana Islands', 'MP', '1', '2014-10-08 17:58:09', NULL),
(285, 4, 'Norway', 'NO', '1', '2014-10-08 17:58:09', NULL),
(286, 4, 'Oman', 'OM', '1', '2014-10-08 17:58:09', NULL),
(287, 4, 'Pakistan', 'PK', '1', '2014-10-08 17:58:09', NULL),
(288, 4, 'Palau', 'PW', '1', '2014-10-08 17:58:09', NULL),
(289, 4, 'Palestine', 'PS', '1', '2014-10-08 17:58:09', NULL),
(290, 4, 'Panama', 'PA', '1', '2014-10-08 17:58:09', NULL),
(291, 4, 'Papua New Guinea', 'PG', '1', '2014-10-08 17:58:09', NULL),
(292, 4, 'Paraguay', 'PY', '1', '2014-10-08 17:58:09', NULL),
(293, 4, 'Peru', 'PE', '1', '2014-10-08 17:58:09', NULL),
(294, 4, 'Philippines', 'PH', '1', '2014-10-08 17:58:09', NULL),
(295, 4, 'Pitcairn', 'PN', '1', '2014-10-08 17:58:09', NULL),
(296, 4, 'Poland', 'PL', '1', '2014-10-08 17:58:09', NULL),
(297, 4, 'Portugal', 'PT', '1', '2014-10-08 17:58:09', NULL),
(298, 4, 'Puerto Rico', 'PR', '1', '2014-10-08 17:58:09', NULL),
(299, 4, 'Qatar', 'QA', '1', '2014-10-08 17:58:09', NULL),
(300, 4, 'Reunion', 'RE', '1', '2014-10-08 17:58:09', NULL),
(301, 4, 'Romania', 'RO', '1', '2014-10-08 17:58:09', NULL),
(302, 4, 'Russian Federation', 'RU', '1', '2014-10-08 17:58:09', NULL),
(303, 4, 'Rwanda', 'RW', '1', '2014-10-08 17:58:09', NULL),
(304, 4, 'Saint Helena', 'SH', '1', '2014-10-08 17:58:09', NULL),
(305, 4, 'Saint Kitts And Nevis', 'KN', '1', '2014-10-08 17:58:09', NULL),
(306, 4, 'Saint Lucia', 'LC', '1', '2014-10-08 17:58:09', NULL),
(307, 4, 'Saint Pierre And Miquelon', 'PM', '1', '2014-10-08 17:58:09', NULL),
(308, 4, 'Saint Vincent And The Grenadines', 'VC', '1', '2014-10-08 17:58:09', NULL),
(309, 4, 'Samoa', 'WS', '1', '2014-10-08 17:58:09', NULL),
(310, 4, 'San Marino', 'SM', '1', '2014-10-08 17:58:09', NULL),
(311, 4, 'Sao Tome And Principe', 'ST', '1', '2014-10-08 17:58:09', NULL),
(312, 4, 'Saudi Arabia', 'SA', '1', '2014-10-08 17:58:09', NULL),
(313, 4, 'Senegal', 'SN', '1', '2014-10-08 17:58:09', NULL),
(314, 4, 'Serbia', 'RB', '1', '2014-10-08 17:58:09', NULL),
(315, 4, 'Seychelles', 'SC', '1', '2014-10-08 17:58:09', NULL),
(316, 4, 'Sierra Leone', 'SL', '1', '2014-10-08 17:58:09', NULL),
(317, 4, 'Singapore', 'SG', '1', '2014-10-08 17:58:09', NULL),
(318, 4, 'Slovakia', 'SK', '1', '2014-10-08 17:58:09', NULL),
(319, 4, 'Slovenia', 'SI', '1', '2014-10-08 17:58:09', NULL),
(320, 4, 'Solomon Islands', 'SB', '1', '2014-10-08 17:58:09', NULL),
(321, 4, 'Somalia', 'SO', '1', '2014-10-08 17:58:09', NULL),
(322, 4, 'South Africa', 'ZA', '1', '2014-10-08 17:58:09', NULL),
(323, 4, 'South Georgia And The South Sandwich Islands', 'GS', '1', '2014-10-08 17:58:09', NULL),
(324, 4, 'Spain', 'ES', '1', '2014-10-08 17:58:09', NULL),
(325, 4, 'Sri Lanka', 'LK', '1', '2014-10-08 17:58:09', NULL),
(326, 4, 'Sudan', 'SD', '1', '2014-10-08 17:58:09', NULL),
(327, 4, 'Suriname', 'SR', '1', '2014-10-08 17:58:09', NULL),
(328, 4, 'Svalbard And Jan Mayen', 'SJ', '1', '2014-10-08 17:58:09', NULL),
(329, 4, 'Swaziland', 'SZ', '1', '2014-10-08 17:58:09', NULL),
(330, 4, 'Sweden', 'SE', '1', '2014-10-08 17:58:09', NULL),
(331, 4, 'Switzerland', 'CH', '1', '2014-10-08 17:58:09', NULL),
(332, 4, 'Syria Arab Republic', 'SY', '1', '2014-10-08 17:58:09', NULL),
(333, 4, 'Taiwan Province Of China', 'TW', '1', '2014-10-08 17:58:09', NULL),
(334, 4, 'Tajikistan', 'TJ', '1', '2014-10-08 17:58:09', NULL),
(335, 4, 'Tanzania', 'TZ', '1', '2014-10-08 17:58:09', NULL),
(336, 4, 'Thailand', 'TH', '1', '2014-10-08 17:58:09', NULL),
(337, 4, 'Timor-leste', 'TP', '1', '2014-10-08 17:58:09', NULL),
(338, 4, 'Togo', 'TG', '1', '2014-10-08 17:58:09', NULL),
(339, 4, 'Tokelau', 'TK', '1', '2014-10-08 17:58:09', NULL),
(340, 4, 'Tonga', 'TO', '1', '2014-10-08 17:58:09', NULL),
(341, 4, 'Trinidad And Tobago', 'TT', '1', '2014-10-08 17:58:09', NULL),
(342, 4, 'Tunisia', 'TN', '1', '2014-10-08 17:58:09', NULL),
(343, 4, 'Turkey', 'TR', '1', '2014-10-08 17:58:09', NULL),
(344, 4, 'Turkmenistan', 'TM', '1', '2014-10-08 17:58:09', NULL),
(345, 4, 'Turks And Caicos Islands', 'TC', '1', '2014-10-08 17:58:09', NULL),
(346, 4, 'Tuvalu', 'TV', '1', '2014-10-08 17:58:09', NULL),
(347, 4, 'Uganda', 'UG', '1', '2014-10-08 17:58:09', NULL),
(348, 4, 'Ukraine', 'UA', '1', '2014-10-08 17:58:09', NULL),
(349, 4, 'United Arab Emirates', 'AE', '1', '2014-10-08 17:58:09', NULL),
(350, 4, 'United Kingdom', 'GB', '1', '2014-10-08 17:58:09', NULL),
(351, 4, 'United States', 'US', '1', '2014-10-08 17:58:09', NULL),
(352, 4, 'Uruguay', 'UY', '1', '2014-10-08 17:58:09', NULL),
(353, 4, 'Uzbekistan', 'UZ', '1', '2014-10-08 17:58:09', NULL),
(354, 4, 'Vanuatu', 'VU', '1', '2014-10-08 17:58:09', NULL),
(355, 4, 'Vatican City State (holy See)', 'VA', '1', '2014-10-08 17:58:09', NULL),
(356, 4, 'Venezuela', 'VE', '1', '2014-10-08 17:58:09', NULL),
(357, 4, 'Vietnam', 'VN', '1', '2014-10-08 17:58:09', NULL),
(358, 4, 'Virgin Islands (british)', 'VG', '1', '2014-10-08 17:58:09', NULL),
(359, 4, 'Virgin Islands (u.s.)', 'VI', '1', '2014-10-08 17:58:09', NULL),
(360, 4, 'Wallis And Futuna Islands', 'WF', '1', '2014-10-08 17:58:09', NULL),
(361, 4, 'Western Sahara', 'EH', '1', '2014-10-08 17:58:09', NULL),
(362, 4, 'Yemen', 'YE', '1', '2014-10-08 17:58:09', NULL),
(363, 4, 'Zambia', 'ZM', '1', '2014-10-08 17:58:09', NULL),
(364, 4, 'Zimbabwe', 'ZW', '1', '2014-10-08 17:58:09', NULL),
(365, 5, 'Select Competition', '2', '1', '2014-10-08 18:01:31', NULL),
(366, 5, 'Domestic Tenders', '0', '1', '2014-10-08 18:01:31', NULL),
(367, 5, 'Global Tenders', '1', '1', '2014-10-08 18:01:31', NULL),
(368, 5, 'Both Global and Domestic', '2', '1', '2014-10-08 18:01:31', '2014-10-14 15:37:41'),
(369, 8, 'All Time', 'select', '1', '2014-10-08 18:02:31', '2014-10-14 15:37:41'),
(370, 8, 'Expiring Today', 'today', '1', '2014-10-08 18:02:31', NULL),
(371, 8, 'Expiring Tomorrow', 'tomorrow', '1', '2014-10-08 18:02:31', NULL),
(372, 8, 'Expiring in Next 7 days', 'next7days', '1', '2014-10-08 18:02:31', NULL),
(373, 8, 'Expiring This Month', 'thismonth', '1', '2014-10-08 18:02:31', NULL),
(374, 8, 'Expiring Next Month', 'nextmonth', '1', '2014-10-08 18:02:31', NULL),
(375, 7, 't', 'Mobile', '1', '2014-10-09 00:00:00', NULL),
(376, 6, 'day', '10', '1', '2014-10-09 00:00:00', '2014-10-14 15:37:41'),
(377, 6, 'mon', '10', '1', '2014-10-09 00:00:00', '2014-10-14 15:37:41'),
(378, 6, 'year', '2014', '1', '2014-10-09 00:00:00', '2014-10-14 15:37:41');

-- --------------------------------------------------------

--
-- Table structure for table `keywords_list`
--

CREATE TABLE `keywords_list` (
`id` int(7) NOT NULL,
  `keyword` varchar(250) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '''0'' - deleted, ''1'' - active',
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keywords_list`
--

INSERT INTO `keywords_list` (`id`, `keyword`, `status`, `created_date`, `updated_date`) VALUES
(1, 'mobile', '1', '2014-10-10 11:08:53', '2014-10-10 11:08:53'),
(2, 'mobile application', '1', '2014-10-10 13:40:10', '2014-10-14 16:41:02'),
(3, 'cleaning', '0', '2014-10-14 21:02:31', '2014-10-14 21:02:35'),
(4, 'cleaning', '0', '2014-10-14 21:02:47', '2014-10-15 14:07:49'),
(5, '', '0', '2014-10-15 14:00:59', '2014-10-15 14:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `selected_emails_list`
--

CREATE TABLE `selected_emails_list` (
`id` int(11) NOT NULL,
  `email_id` int(11) NOT NULL,
  `active` enum('0','1') NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `selected_emails_list`
--

INSERT INTO `selected_emails_list` (`id`, `email_id`, `active`, `created_date`, `modified_date`) VALUES
(73, 1, '1', '2014-10-14 21:19:48', '0000-00-00 00:00:00'),
(74, 2, '1', '2014-10-14 21:19:48', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `selected_fields_list`
--

CREATE TABLE `selected_fields_list` (
`id` int(11) NOT NULL,
  `field_list_values_id` int(11) DEFAULT NULL,
  `configuration_id` int(11) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `selected_status` enum('0','1') NOT NULL DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=212 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `selected_fields_list`
--

INSERT INTO `selected_fields_list` (`id`, `field_list_values_id`, `configuration_id`, `value`, `selected_status`, `created_date`, `modified_date`) VALUES
(164, 11, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(165, 8, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(166, 13, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(167, 86, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(168, 365, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(169, 369, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(170, 376, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(171, 377, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(172, 378, 4, 'NULL', '1', '2014-10-15 03:46:57', NULL),
(181, 12, 1, 'NULL', '1', '2014-10-15 04:18:30', NULL),
(182, 13, 1, 'NULL', '1', '2014-10-15 04:18:30', NULL),
(183, 84, 1, 'NULL', '1', '2014-10-15 04:18:30', NULL),
(184, 368, 1, 'NULL', '1', '2014-10-15 04:18:30', NULL),
(185, 369, 1, 'NULL', '1', '2014-10-15 04:18:30', NULL),
(186, 376, 1, '06', '1', '2014-10-15 04:18:30', NULL),
(187, 377, 1, '10', '1', '2014-10-15 04:18:30', NULL),
(188, 378, 1, '2014', '1', '2014-10-15 04:18:30', NULL),
(189, 11, 5, 'NULL', '1', '2014-10-15 04:50:14', NULL),
(190, 17, 5, 'NULL', '1', '2014-10-15 04:50:14', NULL),
(191, 87, 5, 'NULL', '1', '2014-10-15 04:50:14', NULL),
(192, 367, 5, 'NULL', '1', '2014-10-15 04:50:14', NULL),
(193, 369, 5, 'NULL', '1', '2014-10-15 04:50:14', NULL),
(194, 376, 5, 'NULL', '1', '2014-10-15 04:50:14', NULL),
(195, 377, 5, 'NULL', '1', '2014-10-15 04:50:14', NULL),
(196, 378, 5, 'NULL', '1', '2014-10-15 04:50:14', NULL),
(204, 11, 7, 'NULL', '1', '2014-10-15 13:48:59', NULL),
(205, 13, 7, 'NULL', '1', '2014-10-15 13:48:59', NULL),
(206, 84, 7, 'NULL', '1', '2014-10-15 13:48:59', NULL),
(207, 367, 7, 'NULL', '1', '2014-10-15 13:48:59', NULL),
(208, 369, 7, 'NULL', '1', '2014-10-15 13:48:59', NULL),
(209, 376, 7, '10', '1', '2014-10-15 13:48:59', NULL),
(210, 377, 7, '3', '1', '2014-10-15 13:48:59', NULL),
(211, 378, 7, '2014', '1', '2014-10-15 13:48:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `selected_keywords_list`
--

CREATE TABLE `selected_keywords_list` (
`id` int(11) NOT NULL,
  `keyword_id` int(11) NOT NULL,
  `configuration_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `selected_keywords_list`
--

INSERT INTO `selected_keywords_list` (`id`, `keyword_id`, `configuration_id`, `created_date`, `modified_date`) VALUES
(88, 3, 2, '2014-10-14 21:38:08', '2014-10-14 21:38:08'),
(89, 4, 2, '2014-10-14 21:38:08', '2014-10-14 21:38:08'),
(103, 1, 1, '2014-10-15 04:18:30', '2014-10-15 04:18:30'),
(104, 1, 7, '2014-10-15 13:48:59', '2014-10-15 13:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `sites_list`
--

CREATE TABLE `sites_list` (
`id` int(7) NOT NULL,
  `configuration_name` varchar(200) NOT NULL,
  `configuration_url` varchar(250) NOT NULL,
  `configuration_page` varchar(20) DEFAULT NULL COMMENT 'name of the site view page',
  `status` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '''0''-inactive, ''1'' - active, ''2'' - deleted',
  `selected_status` enum('0','1') NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sites_list`
--

INSERT INTO `sites_list` (`id`, `configuration_name`, `configuration_url`, `configuration_page`, `status`, `selected_status`, `created_date`, `updated_date`) VALUES
(1, 'global tenders', '', 'global_tenders', '1', '1', '2014-10-08 00:00:00', '2014-10-15 14:59:18'),
(2, 'ABC Tenders', '', 'abc_tenders', '1', '0', '2014-10-10 00:00:00', '2014-10-15 14:59:08'),
(3, 'XYZ Tenders', '', 'xyz_tenders', '1', '0', '2014-10-10 00:00:00', '2014-10-15 13:58:58');

-- --------------------------------------------------------

--
-- Table structure for table `site_configurations`
--

CREATE TABLE `site_configurations` (
`id` int(11) NOT NULL,
  `site_id` int(11) NOT NULL,
  `configuration_name` varchar(100) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `created_date` datetime DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `site_configurations`
--

INSERT INTO `site_configurations` (`id`, `site_id`, `configuration_name`, `status`, `created_date`, `modified_date`) VALUES
(1, 1, 'Config 1', '1', '2014-10-14 00:00:00', '2014-10-15 04:18:30'),
(4, 1, 'New config', '1', '2014-10-15 02:56:46', '2014-10-15 03:46:57'),
(5, 1, 'hello conf', '0', '2014-10-15 04:50:14', '2014-10-15 04:50:14'),
(7, 1, 'Himanshu config', '1', '2014-10-15 13:48:59', '2014-10-15 13:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
`id` int(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `created_date`, `updated_date`) VALUES
(1, 'chethan.krishnaswamy@sourcebits.com', '96e79218965eb72c92a549dd5a330112', '2014-10-08 15:53:09', '2014-10-15 13:45:51'),
(2, 'admin@sourcebits.com', 'e10adc3949ba59abbe56e057f20f883e', '2014-10-08 15:53:09', '2014-10-08 15:53:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`session_id`), ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `cronjob_settings`
--
ALTER TABLE `cronjob_settings`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emails_list`
--
ALTER TABLE `emails_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fields_list`
--
ALTER TABLE `fields_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `field_list_values`
--
ALTER TABLE `field_list_values`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keywords_list`
--
ALTER TABLE `keywords_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selected_emails_list`
--
ALTER TABLE `selected_emails_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selected_fields_list`
--
ALTER TABLE `selected_fields_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `selected_keywords_list`
--
ALTER TABLE `selected_keywords_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sites_list`
--
ALTER TABLE `sites_list`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_configurations`
--
ALTER TABLE `site_configurations`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cronjob_settings`
--
ALTER TABLE `cronjob_settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `emails_list`
--
ALTER TABLE `emails_list`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `fields_list`
--
ALTER TABLE `fields_list`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `field_list_values`
--
ALTER TABLE `field_list_values`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=379;
--
-- AUTO_INCREMENT for table `keywords_list`
--
ALTER TABLE `keywords_list`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `selected_emails_list`
--
ALTER TABLE `selected_emails_list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `selected_fields_list`
--
ALTER TABLE `selected_fields_list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=212;
--
-- AUTO_INCREMENT for table `selected_keywords_list`
--
ALTER TABLE `selected_keywords_list`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `sites_list`
--
ALTER TABLE `sites_list`
MODIFY `id` int(7) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `site_configurations`
--
ALTER TABLE `site_configurations`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
