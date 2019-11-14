-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 14, 2019 at 08:28 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `_key` varchar(255) NOT NULL,
  `_val` longtext NOT NULL,
  `status` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `first` text NOT NULL,
  `last` text NOT NULL,
  `ip` varchar(20) NOT NULL,
  `avatar` longtext NOT NULL,
  `created` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `_key` bigint(20) NOT NULL,
  `logs` longtext NOT NULL DEFAULT '[]',
  `status` char(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `first`, `last`, `ip`, `avatar`, `created`, `last_update`, `_key`, `logs`, `status`) VALUES
(10, 'fear126', 'ejhoRDZCV3MvVUpoRDYyWGhHRVZGUT09', 'fear126@live.com', 'Taranpreet', 'Singh', '127.0.0.1', 'http://loginsystem.local/assets/images/1573706845.png', '2019-11-14 10:15:43', '2019-11-14 04:45:43', 81598421, '[{\"2019-11-14 10:16:01\":\"Logged In from 127.0.0.1\"},{\"2019-11-14 10:17:24\":\"Changed Avatar Image from 127.0.0.1\"},{\"2019-11-14 10:17:41\":\"Profile detail updated from 127.0.0.1\"},{\"2019-11-14 10:18:11\":\"Logged Out from 127.0.0.1\"}]', '1'),
(11, 'qwerty', 'ejhoRDZCV3MvVUpoRDYyWGhHRVZGUT09', 'qwerty@email.com', 'this', 'is', '127.0.0.1', 'http://loginsystem.local/assets/images/1573707893.png', '2019-11-14 10:34:13', '2019-11-14 05:04:13', 82771401, '[{\"2019-11-14 10:34:28\":\"Logged In from 127.0.0.1\"},{\"2019-11-14 10:34:52\":\"Changed Avatar Image from 127.0.0.1\"},{\"2019-11-14 10:35:04\":\"Profile detail updated from 127.0.0.1\"},{\"2019-11-14 10:35:19\":\"Profile detail updated from 127.0.0.1\"},{\"2019-11-14 10:35:23\":\"Profile detail updated from 127.0.0.1\"},{\"2019-11-14 10:35:36\":\"Logged Out from 127.0.0.1\"},{\"2019-11-14 10:36:05\":\"(Forgot Password)Password token updated from 127.0.0.1\"},{\"2019-11-14 10:36:21\":\"Logged In from 127.0.0.1\"},{\"2019-11-14 10:36:31\":\"Logged Out from 127.0.0.1\"}]', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
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
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
