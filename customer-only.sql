-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2020 at 12:49 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `customer-only`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `a_id` int(11) NOT NULL,
  `a_v_no` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `a_date` date NOT NULL,
  `a_amount` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `caret`
--

CREATE TABLE `caret` (
  `id` int(11) NOT NULL,
  `party` int(11) NOT NULL,
  `date` date NOT NULL,
  `caret` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `g_id` int(11) NOT NULL,
  `g_name` varchar(100) NOT NULL,
  `g_customer_com` float NOT NULL,
  `g_customer_wage` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`g_id`, `g_name`, `g_customer_com`, `g_customer_wage`) VALUES
(1, 'caIku', 0, 3),
(2, 'f`uT', 0, 3),
(3, 'SaakBaaP', 7, 3),
(4, 'daDma', 0, 2),
(5, 'SaakBaaP 2', 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `i_id` int(11) NOT NULL,
  `i_name` varchar(100) NOT NULL,
  `i_group_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `opassword` varchar(255) NOT NULL,
  `type` int(1) DEFAULT NULL,
  `valid` date DEFAULT NULL,
  `contact` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `username`, `password`, `opassword`, `type`, `valid`, `contact`) VALUES
(1, 'vatsal', '40F49A5A5F5D0D8F91E19A8983339CD8', 'vatsal', 2, '2020-03-31', '9408203201'),
(3, 'kewal', 'f9e54aa256b98af7abe9d1dd35e545cc', 'kewal', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `type` varchar(10) NOT NULL,
  `amt` float DEFAULT NULL,
  `customer` varchar(50) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `p_id` int(255) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_pending_amount` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sell_bill`
--

CREATE TABLE `sell_bill` (
  `s_id` int(11) NOT NULL,
  `s_b_no` int(11) NOT NULL,
  `s_date` date NOT NULL,
  `s_c_id` int(11) NOT NULL,
  `s_i_id` int(11) NOT NULL,
  `s_qty` int(11) NOT NULL,
  `s_weight` float NOT NULL,
  `s_rate` float NOT NULL,
  `s_o_rate` float NOT NULL,
  `s_com` float NOT NULL,
  `s_wage` int(11) NOT NULL,
  `s_o_e` int(11) NOT NULL,
  `s_total` float NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `value`) VALUES
(1, 'rs', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`a_id`),
  ADD UNIQUE KEY `a_v_no` (`a_v_no`);

--
-- Indexes for table `caret`
--
ALTER TABLE `caret`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`g_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`i_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `sell_bill`
--
ALTER TABLE `sell_bill`
  ADD PRIMARY KEY (`s_id`),
  ADD UNIQUE KEY `s_b_no` (`s_b_no`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `caret`
--
ALTER TABLE `caret`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `g_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `i_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `p_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell_bill`
--
ALTER TABLE `sell_bill`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
