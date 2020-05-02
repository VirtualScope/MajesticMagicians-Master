-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2020 at 02:49 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teampuma_virtualscope`
--

-- --------------------------------------------------------

--
-- Table structure for table `class_passwords`
--

CREATE TABLE `class_passwords` (
  `cpid` int(10) UNSIGNED NOT NULL,
  `class_password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `course_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `section` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `uid` int(10) UNSIGNED NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `microscopes`
--

CREATE TABLE `microscopes` (
  `mid` int(10) UNSIGNED NOT NULL,
  `microscope_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `experiment_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `course_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `availability` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `picture_time_increment` int(10) NOT NULL DEFAULT 5,
  `youtube` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `youtube_stream` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(60) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `star_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `course_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `section` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class_passwords`
--
ALTER TABLE `class_passwords`
  ADD PRIMARY KEY (`cpid`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`uid`,`timestamp`);

--
-- Indexes for table `microscopes`
--
ALTER TABLE `microscopes`
  ADD PRIMARY KEY (`mid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class_passwords`
--
ALTER TABLE `class_passwords`
  MODIFY `cpid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `microscopes`
--
ALTER TABLE `microscopes`
  MODIFY `mid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
