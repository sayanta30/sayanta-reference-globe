-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 15, 2021 at 08:49 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `sayanta_reference_globe`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_pass` varchar(200) NOT NULL,
  `user_mobile` varchar(14) NOT NULL,
  `user_profile_photo` varchar(100) DEFAULT NULL,
  `user_dob` varchar(10) NOT NULL,
  `user_signature` varchar(100) NOT NULL,
  `user_aadhar_card` varchar(100) DEFAULT NULL,
  `user_pan_card` varchar(100) DEFAULT NULL,
  `user_role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`_id`, `user_name`, `user_email`, `user_pass`, `user_mobile`, `user_profile_photo`, `user_dob`, `user_signature`, `user_aadhar_card`, `user_pan_card`, `user_role`) VALUES
(1, 'Super Admin', 'superadmin@superadmin.com', 'c4ca4238a0b923820dcc509a6f75849b', '0123456789', '21.jpg', '2000-04-30', 'S Admin', '21.jpg', '21.jpg', 'Super Admin'),
(2, 'Admin', 'admin@admin.com', 'c4ca4238a0b923820dcc509a6f75849b', '1234567890', '21.jpg', '2021-09-15', 'Admin', '21.jpg', '21.jpg', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
