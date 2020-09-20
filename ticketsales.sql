-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2020 at 10:42 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketsales`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_book_seat`
--

CREATE TABLE `tb_book_seat` (
  `bs_id` int(11) NOT NULL,
  `bs_round_out` int(11) NOT NULL,
  `bs_time` datetime NOT NULL,
  `bs_book_seat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tb_bus`
--

CREATE TABLE `tb_bus` (
  `b_id` int(11) NOT NULL,
  `b_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_bus`
--

INSERT INTO `tb_bus` (`b_id`, `b_name`) VALUES
(7, 'ตู้'),
(8, 'มินิบัส'),
(9, 'บัส'),
(10, 'ตู้'),
(11, 'ตู้'),
(12, 'มินิบัส'),
(13, 'บัส');

-- --------------------------------------------------------

--
-- Table structure for table `tb_place_end`
--

CREATE TABLE `tb_place_end` (
  `pe_id` int(11) NOT NULL,
  `pe_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_place_end`
--

INSERT INTO `tb_place_end` (`pe_id`, `pe_name`) VALUES
(5, 'ละหานทราย'),
(6, 'บุรีรัมย์');

-- --------------------------------------------------------

--
-- Table structure for table `tb_place_start`
--

CREATE TABLE `tb_place_start` (
  `ps_id` int(11) NOT NULL,
  `ps_name` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_place_start`
--

INSERT INTO `tb_place_start` (`ps_id`, `ps_name`) VALUES
(1, 'บุรีรัมย์'),
(3, 'ประโคนชัย'),
(8, 'ละหานทราย');

-- --------------------------------------------------------

--
-- Table structure for table `tb_round_out`
--

CREATE TABLE `tb_round_out` (
  `ro_id` int(11) NOT NULL,
  `ro_place_start` int(11) NOT NULL,
  `ro_place_end` int(11) NOT NULL,
  `ro_time_start` time NOT NULL,
  `ro_price` int(11) NOT NULL DEFAULT 0,
  `ro_bus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_round_out`
--

INSERT INTO `tb_round_out` (`ro_id`, `ro_place_start`, `ro_place_end`, `ro_time_start`, `ro_price`, `ro_bus`) VALUES
(16, 1, 5, '07:30:00', 0, 7),
(17, 1, 5, '08:00:00', 0, 8),
(18, 1, 5, '08:50:00', 0, 7),
(19, 1, 5, '10:00:00', 0, 9),
(20, 1, 5, '11:00:00', 0, 7),
(21, 1, 5, '12:30:00', 0, 7),
(22, 1, 5, '13:30:00', 0, 8),
(23, 1, 5, '14:30:00', 0, 7),
(24, 1, 5, '15:30:00', 0, 9),
(25, 1, 5, '16:30:00', 0, 9),
(26, 1, 5, '17:10:00', 0, 8),
(27, 1, 5, '18:30:00', 0, 7),
(28, 3, 6, '06:00:00', 0, 8),
(29, 3, 6, '07:00:00', 0, 9),
(30, 3, 6, '07:30:00', 0, 10),
(31, 3, 6, '08:10:00', 0, 9),
(32, 3, 6, '09:30:00', 0, 10),
(33, 3, 6, '11:00:00', 0, 10),
(34, 3, 6, '12:00:00', 0, 8),
(35, 3, 6, '13:00:00', 0, 10),
(36, 3, 6, '14:30:00', 0, 9),
(37, 3, 6, '15:20:00', 0, 8),
(38, 3, 6, '16:10:00', 0, 7),
(39, 3, 6, '17:30:00', 0, 7),
(40, 3, 5, '05:30:00', 0, 9),
(41, 3, 5, '06:00:00', 0, 7),
(42, 3, 5, '08:30:00', 0, 10),
(43, 3, 5, '09:00:00', 0, 8),
(45, 3, 5, '09:50:00', 0, 7),
(46, 3, 5, '11:00:00', 0, 8),
(47, 3, 5, '12:00:00', 0, 10),
(48, 3, 5, '13:30:00', 0, 12),
(49, 1, 5, '15:30:00', 0, 10),
(50, 3, 5, '15:30:00', 0, 7),
(51, 3, 5, '16:30:00', 0, 13),
(52, 3, 5, '18:00:00', 0, 12),
(53, 8, 6, '06:30:00', 0, 13),
(54, 8, 6, '08:00:00', 0, 11),
(56, 8, 6, '11:30:00', 0, 11),
(57, 8, 6, '13:00:00', 0, 9),
(58, 8, 6, '14:30:00', 0, 10),
(59, 8, 6, '15:30:00', 0, 11),
(60, 8, 6, '17:00:00', 0, 10),
(61, 8, 6, '18:00:00', 0, 9),
(62, 8, 6, '09:30:00', 0, 11);

-- --------------------------------------------------------

--
-- Table structure for table `tb_sales`
--

CREATE TABLE `tb_sales` (
  `sale_id` int(11) NOT NULL,
  `sale_round` int(11) NOT NULL,
  `sale_emp` int(11) NOT NULL,
  `sale_emp_name` varchar(80) NOT NULL,
  `sale_seat` int(11) NOT NULL,
  `sale_price` int(11) NOT NULL DEFAULT 0,
  `sale_time_sale` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_sales`
--

INSERT INTO `tb_sales` (`sale_id`, `sale_round`, `sale_emp`, `sale_emp_name`, `sale_seat`, `sale_price`, `sale_time_sale`) VALUES
(60, 16, 1, 'กิตชัย แสงอ่อน', 39, 80, '2020-09-19 22:35:29'),
(61, 16, 1, 'กิตชัย แสงอ่อน', 40, 80, '2020-09-19 22:36:11');

-- --------------------------------------------------------

--
-- Table structure for table `tb_seat`
--

CREATE TABLE `tb_seat` (
  `seat_id` int(11) NOT NULL,
  `seat_name` varchar(10) NOT NULL,
  `seat_bus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_seat`
--

INSERT INTO `tb_seat` (`seat_id`, `seat_name`, `seat_bus`) VALUES
(39, 'V1', 7),
(40, 'V2', 7),
(41, 'V3', 7),
(42, 'V4', 7),
(43, 'V5', 7),
(44, 'V6', 7),
(45, 'V7', 7),
(46, 'V8', 7),
(47, 'MB1', 8),
(50, 'MB2', 8),
(51, 'MB3', 8),
(52, 'MB4', 8),
(53, 'MB5', 8),
(54, 'MB6', 8),
(55, 'MB7', 8),
(56, 'MB8', 8),
(57, 'MB9', 8),
(58, 'MB10', 8),
(59, 'B1', 9),
(60, 'B2', 9),
(61, 'B3', 9),
(62, 'B4', 9),
(63, 'B5', 9),
(64, 'B6', 9),
(65, 'B7', 9),
(66, 'B8', 9),
(67, 'B9', 9),
(68, 'B10', 9),
(69, 'B13_1', 13),
(70, 'B13_2', 13),
(71, 'B13_3', 13),
(72, 'B13_4', 13),
(73, 'B13_5', 13),
(74, 'B13_6', 13),
(75, 'B13_7', 13),
(76, 'B13_8', 13),
(77, 'B13_9', 13),
(78, 'B13_10', 13),
(79, 'MB12_1', 12),
(80, 'MB12_2', 12),
(81, 'MB12_3', 12),
(82, 'MB12_4', 12),
(83, 'MB12_5', 12),
(84, 'MB12_6', 12),
(85, 'MB12_7', 12),
(86, 'MB12_8', 12),
(87, 'V11_1', 11),
(88, 'V11_2', 11),
(89, 'V11_3', 11),
(90, 'V11_4', 11),
(91, 'V11_5', 11),
(92, 'V11_6', 11),
(93, 'V11_7', 11),
(94, 'V11_8', 11),
(95, 'V10_1', 10),
(96, 'V10_2', 10),
(97, 'V10_3', 10),
(98, 'V10_4', 10),
(99, 'V10_5', 10),
(100, 'V10_6', 10),
(101, 'V10_7', 10),
(102, 'V10_8', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `u_id` int(11) NOT NULL,
  `u_email` varchar(70) NOT NULL,
  `u_password` varchar(280) NOT NULL,
  `u_first_name` varchar(180) NOT NULL,
  `u_last_name` varchar(80) NOT NULL,
  `u_role` int(11) NOT NULL DEFAULT 0,
  `u_tel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`u_id`, `u_email`, `u_password`, `u_first_name`, `u_last_name`, `u_role`, `u_tel`) VALUES
(1, 'admin@mail.com', 'd41d8cd98f00b204e9800998ecf8427e', 'กิตชัย', 'แสงอ่อน', 1, '0911111111'),
(7, 'user@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'ทรนาดน', 'แสงศรี', 0, '0915645625'),
(10, 'user2@mail.com', 'e10adc3949ba59abbe56e057f20f883e', 'พงศรี', 'อ่อนแสง', 0, '0941585855');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_book_seat`
--
ALTER TABLE `tb_book_seat`
  ADD PRIMARY KEY (`bs_id`),
  ADD KEY `bs_round_out` (`bs_round_out`),
  ADD KEY `bs_book_seat` (`bs_book_seat`);

--
-- Indexes for table `tb_bus`
--
ALTER TABLE `tb_bus`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `tb_place_end`
--
ALTER TABLE `tb_place_end`
  ADD PRIMARY KEY (`pe_id`);

--
-- Indexes for table `tb_place_start`
--
ALTER TABLE `tb_place_start`
  ADD PRIMARY KEY (`ps_id`);

--
-- Indexes for table `tb_round_out`
--
ALTER TABLE `tb_round_out`
  ADD PRIMARY KEY (`ro_id`),
  ADD KEY `ro_place_start` (`ro_place_start`),
  ADD KEY `ro_place_end` (`ro_place_end`),
  ADD KEY `ro_bus` (`ro_bus`);

--
-- Indexes for table `tb_sales`
--
ALTER TABLE `tb_sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `sale_round` (`sale_round`);

--
-- Indexes for table `tb_seat`
--
ALTER TABLE `tb_seat`
  ADD PRIMARY KEY (`seat_id`),
  ADD KEY `seat_bus` (`seat_bus`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_book_seat`
--
ALTER TABLE `tb_book_seat`
  MODIFY `bs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `tb_bus`
--
ALTER TABLE `tb_bus`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_place_end`
--
ALTER TABLE `tb_place_end`
  MODIFY `pe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_place_start`
--
ALTER TABLE `tb_place_start`
  MODIFY `ps_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_round_out`
--
ALTER TABLE `tb_round_out`
  MODIFY `ro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tb_sales`
--
ALTER TABLE `tb_sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tb_seat`
--
ALTER TABLE `tb_seat`
  MODIFY `seat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_book_seat`
--
ALTER TABLE `tb_book_seat`
  ADD CONSTRAINT `tb_book_seat_ibfk_1` FOREIGN KEY (`bs_round_out`) REFERENCES `tb_round_out` (`ro_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_book_seat_ibfk_2` FOREIGN KEY (`bs_book_seat`) REFERENCES `tb_seat` (`seat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_round_out`
--
ALTER TABLE `tb_round_out`
  ADD CONSTRAINT `tb_round_out_ibfk_1` FOREIGN KEY (`ro_place_start`) REFERENCES `tb_place_start` (`ps_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_round_out_ibfk_2` FOREIGN KEY (`ro_place_end`) REFERENCES `tb_place_end` (`pe_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_round_out_ibfk_3` FOREIGN KEY (`ro_bus`) REFERENCES `tb_bus` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_sales`
--
ALTER TABLE `tb_sales`
  ADD CONSTRAINT `tb_sales_ibfk_1` FOREIGN KEY (`sale_round`) REFERENCES `tb_round_out` (`ro_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_seat`
--
ALTER TABLE `tb_seat`
  ADD CONSTRAINT `tb_seat_ibfk_1` FOREIGN KEY (`seat_bus`) REFERENCES `tb_bus` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
