-- phpMyAdmin SQL Dump
-- version 4.2.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2017 at 08:05 PM
-- Server version: 5.6.20
-- PHP Version: 5.6.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `timetable`
--
CREATE DATABASE IF NOT EXISTS `timetable` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `timetable`;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `weekday` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `user_id`, `room_id`, `weekday`, `time`) VALUES
(1, 2, 1, 'Monday', '8:00 AM'),
(4, 2, 4, 'Monday', '9:00 AM'),
(5, 2, 1, 'Wednesday', '10:00 AM'),
(6, 2, 4, 'Thursday', '4:00 PM'),
(7, 2, 4, 'Friday', '2:00 PM'),
(8, 2, 4, 'Thursday', '1:00 PM'),
(9, 2, 2, 'Tuesday', '10:00 AM'),
(10, 2, 1, 'Monday', '10:00 AM'),
(11, 2, 1, 'Monday', '11:00 AM'),
(12, 2, 1, 'Monday', '1:00 PM'),
(13, 2, 1, 'Monday', '2:00 PM'),
(14, 2, 1, 'Monday', '3:00 PM'),
(15, 2, 1, 'Monday', '4:00 PM'),
(16, 2, 4, 'Monday', '10:00 AM'),
(17, 2, 4, 'Monday', '11:00 AM'),
(18, 2, 4, 'Monday', '1:00 PM'),
(19, 2, 4, 'Monday', '2:00 PM'),
(20, 2, 4, 'Monday', '3:00 PM'),
(21, 2, 4, 'Monday', '4:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE IF NOT EXISTS `rooms` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `num_students` int(11) NOT NULL,
  `has_pc` varchar(255) NOT NULL,
  `has_projector` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `name`, `num_students`, `has_pc`, `has_projector`) VALUES
(1, 'Room1', 50, 'Y', 'Y'),
(2, 'Room2', 30, 'N', 'Y'),
(3, 'Room3', 20, 'N', 'N'),
(4, 'Room4', 100, 'Y', 'Y'),
(5, 'Room5', 70, 'N', 'Y'),
(6, 'Room6', 80, 'Y', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text,
  `level` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `level`) VALUES
(1, 'Jacky891016', 'jackiechan19891016@outlook.com', '$1$ri0.Yw..$3ws9l8U/gf0g4xq5EGo2Z0', 1),
(2, 'Charley951016', 'charley951016@gmail.com', '$1$Be/.0F5.$d1RIuCHyGjbCc3OTvpAZ/.', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
