-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2018 at 12:26 AM
-- Server version: 5.6.34-log
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `comic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `group` varchar(255) NOT NULL,
  `chapter` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `pages` int(11) NOT NULL,
  `imagename` text NOT NULL,
  `thumbname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `group`, `chapter`, `title`, `pages`, `imagename`, `thumbname`) VALUES
(1, '1', 1, 'Lovely Monster', 1, 'image_af1ef93f40e65d9200a7e6a797f2d041.png', 'thumb_af1ef93f40e65d9200a7e6a797f2d041.png'),
(11, '1', 2, 'Deadly Demise', 1, 'image_e65787c6094706703fe40e8167346226.png', 'thumb_e65787c6094706703fe40e8167346226.png');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `title`) VALUES
(1, 'HOME'),
(2, 'SHOP'),
(3, 'COMIC'),
(4, 'ABOUT'),
(5, 'FAQ'),
(6, 'CONTACT'),
(7, 'LOGIN'),
(8, 'SETTINGS');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  `group` int(11) NOT NULL,
  `imagename` text NOT NULL,
  `thumbname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page`, `group`, `imagename`, `thumbname`) VALUES
(55, 1, 1, 'image_31afb5505ff808189f440e081d928530.png', 'thumb_31afb5505ff808189f440e081d928530.png'),
(56, 2, 1, 'image_bafbec24ebdc9ac3b7179ae6ded8ea7c.png', 'thumb_bafbec24ebdc9ac3b7179ae6ded8ea7c.png'),
(57, 3, 1, 'image_8bd638c08eb6e9bb1f8c291b18a0b13e.png', 'thumb_8bd638c08eb6e9bb1f8c291b18a0b13e.png'),
(58, 4, 1, 'image_b2e547d9a87557cc709d1c0137b308bb.png', 'thumb_b2e547d9a87557cc709d1c0137b308bb.png');

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

CREATE TABLE `series` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` int(11) NOT NULL,
  `illustrator` int(11) NOT NULL,
  `genre` text NOT NULL,
  `imagename` text NOT NULL,
  `thumbname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`id`, `title`, `author`, `illustrator`, `genre`, `imagename`, `thumbname`) VALUES
(1, 'Hello Holika', 1, 1, 'horror', 'image_d7e89c3f401181b9b696e86d80f8f6c4.png', 'thumb_d7e89c3f401181b9b696e86d80f8f6c4.png');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL,
  `previous_id` varchar(40) NOT NULL,
  `user_agent` text NOT NULL,
  `ip_hash` char(32) NOT NULL DEFAULT '',
  `created` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `updated` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `payload` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `previous_id`, `user_agent`, `ip_hash`, `created`, `updated`, `payload`) VALUES
('84ca753c483a578fbc3ae761343ceb7f', 'd343541ae4af928c013a9a4bec9220ad', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '4869e012aa045958bdf5c461577cf02d', 1541550345, 1541550345, 'a:3:{i:0;a:7:{s:10:\"session_id\";s:32:\"84ca753c483a578fbc3ae761343ceb7f\";s:11:\"previous_id\";s:32:\"d343541ae4af928c013a9a4bec9220ad\";s:7:\"ip_hash\";s:32:\"4869e012aa045958bdf5c461577cf02d\";s:10:\"user_agent\";s:114:\"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36\";s:7:\"created\";i:1541550345;s:7:\"updated\";i:1541550345;s:7:\"payload\";s:0:\"\";}i:1;a:2:{s:8:\"username\";s:5:\"admin\";s:10:\"login_hash\";s:40:\"dcff518c1b11394fbcb45ccdf5add98f5486306c\";}i:2;a:1:{s:29:\"flash::__session_identifier__\";a:2:{s:5:\"state\";s:6:\"expire\";s:5:\"value\";s:40:\"de5939102944c5824ba5b508d6d6126d8692aef0\";}}}');

-- --------------------------------------------------------

--
-- Table structure for table `sublinks`
--

CREATE TABLE `sublinks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sublinks`
--

INSERT INTO `sublinks` (`id`, `title`, `group`) VALUES
(1, 'LINK', 1),
(2, 'LINK', 2),
(3, 'LINK', 3),
(4, 'LINK', 4);

-- --------------------------------------------------------

--
-- Table structure for table `trilinks`
--

CREATE TABLE `trilinks` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `group` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trilinks`
--

INSERT INTO `trilinks` (`id`, `title`, `group`) VALUES
(1, 'Option', 1),
(3, 'Option', 2),
(4, 'Option', 1),
(5, 'Option', 1),
(6, 'Option', 2),
(7, 'Option', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `profile_fields` text NOT NULL,
  `group` int(11) NOT NULL,
  `last_login` int(20) NOT NULL,
  `login_hash` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `profile_fields`, `group`, `last_login`, `login_hash`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'vbW6gH72S1l6qPfTbOVBgI2UHy0VXq/YYVo66el1U1M=', 'admin@email.com', 'a:1:{s:8:\"username\";s:3:\"Joe\";}', 100, 1541547235, 'dcff518c1b11394fbcb45ccdf5add98f5486306c', 1541545199, 0),
(2, 'Star', 'vbW6gH72S1l6qPfTbOVBgI2UHy0VXq/YYVo66el1U1M=', 'star@email.com', 'a:1:{s:8:\"username\";s:4:\"Star\";}', 1, 1541546644, 'feab50d8f88b9d4874f226b6b9cb4e1e3249485b', 1541546644, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD UNIQUE KEY `PREVIOUS` (`previous_id`);

--
-- Indexes for table `sublinks`
--
ALTER TABLE `sublinks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trilinks`
--
ALTER TABLE `trilinks`
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
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `series`
--
ALTER TABLE `series`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sublinks`
--
ALTER TABLE `sublinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `trilinks`
--
ALTER TABLE `trilinks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
