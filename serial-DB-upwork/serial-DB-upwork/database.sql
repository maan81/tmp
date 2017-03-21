-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 14, 2017 at 01:52 PM
-- Server version: 5.1.73
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `databaseName`
--

-- --------------------------------------------------------

--
-- Table structure for table `3G_serial_numbers`
--

CREATE TABLE `3G_serial_numbers` (
  `id` int(11) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `serial_number_2` varchar(255) NOT NULL,
  `serial_number_3` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `environment` varchar(255) NOT NULL,
  `dealer_name` varchar(255) NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `sold_date_dealer` date DEFAULT NULL,
  `sold_date_customer` date DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_city` varchar(255) NOT NULL,
  `customer_state` varchar(255) NOT NULL,
  `customer_zip` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `warranty_status` varchar(255) NOT NULL,
  `spiff_paid` varchar(255) NOT NULL,
  `spiff_date` date DEFAULT NULL,
  `spiff_approved_date` date DEFAULT NULL,
  `spiff_check_num` int(11) NOT NULL,
  `spiff_amount` varchar(255) NOT NULL,
  `salesperson_id` int(11) NOT NULL,
  `diagnosis` text NOT NULL,
  `solution` text NOT NULL,
  `labor_claim_paid` text NOT NULL,
  `parts_sent_out` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `3G_serial_numbers_installers`
--

CREATE TABLE `3G_serial_numbers_installers` (
  `installer_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `biz_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `labor_rate` varchar(255) NOT NULL,
  `rating` varchar(100) NOT NULL,
  `notes` text NOT NULL,
  `nationwide` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `3G_serial_numbers_models`
--

CREATE TABLE `3G_serial_numbers_models` (
  `model_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `3G_serial_numbers_parts`
--

CREATE TABLE `3G_serial_numbers_parts` (
  `id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `part_num` varchar(255) DEFAULT NULL,
  `compatibility` varchar(255) DEFAULT NULL,
  `part_kind` varchar(255) DEFAULT NULL,
  `part_serial_num` varchar(255) DEFAULT NULL,
  `part_name` varchar(255) NOT NULL DEFAULT '',
  `part_size` varchar(255) DEFAULT NULL,
  `part_set` int(11) DEFAULT NULL,
  `part_cost` varchar(255) DEFAULT NULL,
  `dealer_cost` varchar(255) DEFAULT NULL,
  `part_msrp` varchar(255) DEFAULT NULL,
  `min_qty` int(11) NOT NULL,
  `actual_qty` int(11) NOT NULL,
  `order_qty` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `3G_serial_numbers_salesPersons`
--

CREATE TABLE `3G_serial_numbers_salesPersons` (
  `salesperson_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `ssn` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `store_id` int(11) NOT NULL,
  `mailing_pref` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `3G_users`
--

CREATE TABLE `3G_users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `date_added` datetime DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `email` varchar(125) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  `user_type` int(11) DEFAULT '2',
  `department` varchar(225) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `3G_serial_numbers`
--
ALTER TABLE `3G_serial_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `3G_serial_numbers_installers`
--
ALTER TABLE `3G_serial_numbers_installers`
  ADD PRIMARY KEY (`installer_id`);

--
-- Indexes for table `3G_serial_numbers_models`
--
ALTER TABLE `3G_serial_numbers_models`
  ADD PRIMARY KEY (`model_id`);

--
-- Indexes for table `3G_serial_numbers_parts`
--
ALTER TABLE `3G_serial_numbers_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `3G_serial_numbers_salesPersons`
--
ALTER TABLE `3G_serial_numbers_salesPersons`
  ADD PRIMARY KEY (`salesperson_id`);

--
-- Indexes for table `3G_users`
--
ALTER TABLE `3G_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `3G_serial_numbers`
--
ALTER TABLE `3G_serial_numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2703;
--
-- AUTO_INCREMENT for table `3G_serial_numbers_installers`
--
ALTER TABLE `3G_serial_numbers_installers`
  MODIFY `installer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `3G_serial_numbers_models`
--
ALTER TABLE `3G_serial_numbers_models`
  MODIFY `model_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `3G_serial_numbers_parts`
--
ALTER TABLE `3G_serial_numbers_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=557;
--
-- AUTO_INCREMENT for table `3G_serial_numbers_salesPersons`
--
ALTER TABLE `3G_serial_numbers_salesPersons`
  MODIFY `salesperson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT for table `3G_users`
--
ALTER TABLE `3G_users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
