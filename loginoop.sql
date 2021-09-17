-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 17, 2021 at 03:18 PM
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
-- Database: `loginOOP`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `groupID` int(11) NOT NULL,
  `groupName` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `groupPerm` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`groupID`, `groupName`, `groupPerm`) VALUES
(1, 'standard', ''),
(2, 'admin', '{\"admin\": 1}');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sessionID` int(11) NOT NULL,
  `sessionUser` int(11) NOT NULL,
  `sessionHash` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userLogin` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `userPass` varchar(64) COLLATE utf8_polish_ci DEFAULT NULL,
  `userName` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `userGroup` int(11) DEFAULT NULL,
  `userSalt` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `userJoinDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userLogin`, `userPass`, `userName`, `userGroup`, `userSalt`, `userJoinDate`) VALUES
(1, 'Alex', 'password', 'Alex', 0, 'salt', '2021-09-10 00:00:00'),
(2, 'Billy', 'password', 'Billy', 0, 'salt', '2021-09-10 00:00:00'),
(3, 'Dale', 'newpass', 'Casy', 0, NULL, NULL),
(4, 'Eric', 'ericpass', NULL, NULL, NULL, NULL),
(5, 'Felix', 'somepass', 'Dale', 0, 'somesalt', '2021-09-13 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`groupID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sessionID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `groupID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `sessionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
