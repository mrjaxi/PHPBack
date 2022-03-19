-- phpMyAdmin SQL Dump
-- version 5.0.4deb2ubuntu5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 18, 2022 at 07:49 PM
-- Server version: 8.0.28-0ubuntu0.21.10.3
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpback`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ideas` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `ideas`) VALUES
(1, 'TEST', 'TEST', 3);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ideaid` int NOT NULL,
  `userid` int NOT NULL,
  `date` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `ideaid`, `userid`, `date`) VALUES
(1, 'ef', 1, 1, '17/03/22 15:29'),
(9, 'gergergergerg', 3, 1, '17/03/22 16:02'),
(10, 'hnrfrt', 3, 1, '17/03/22 16:10');

-- --------------------------------------------------------

--
-- Table structure for table `flags`
--

CREATE TABLE `flags` (
  `id` int NOT NULL,
  `toflagid` int NOT NULL,
  `userid` int NOT NULL,
  `date` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ideas`
--

CREATE TABLE `ideas` (
  `id` int NOT NULL,
  `title` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `authorid` int NOT NULL,
  `date` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `votes` int NOT NULL,
  `comments` int NOT NULL,
  `status` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `categoryid` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ideas`
--

INSERT INTO `ideas` (`id`, `title`, `content`, `authorid`, `date`, `votes`, `comments`, `status`, `categoryid`) VALUES
(1, 'ewgwegwgwegwegweg', 'egwegwegwegwegwegwegwegwe', 1, '17/03/22 14:30', 0, 1, 'completed', 1),
(2, 'gerggggggggggggggggg', 'ggggggggggggggggggggggggggggggggggg', 1, '17/03/22 15:44', 0, 0, 'considered', 1),
(3, 'ggfhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'hhhhhhhhhhhffggfghfggffggh', 1, '17/03/22 15:45', 0, 2, 'considered', 1);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `content` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `toid` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `content`, `date`, `type`, `toid`) VALUES
(1, 'User registered: jordanpie(bobcatoshigu@gmail.com)', '15/03/22 13:56', 'general', 0),
(2, 'User registered: jordanpie(sergey@mail.com)', '15/03/22 13:57', 'general', 0),
(3, 'User registered: jordanpie(checkmail@gmail.com)', '15/03/22 14:31', 'general', 0),
(4, 'User registered: jordanpie(mailgroup@mail.ru)', '15/03/22 14:41', 'general', 0),
(5, 'Settings have been edited', '15/03/22 16:23', 'system', 1),
(6, 'Пользователь #2 заблокирован на 20220319 дней', '17/03/22 02:27', 'user', 1),
(7, 'Пользователь #$id был заблокирован', '17/03/22 02:27', 'user', 2),
(8, '\'TEST\'Категория создана', '17/03/22 14:30', 'user', 1),
(9, 'Новая идея создана: ewgwegwgwegwegweg', '17/03/22 14:30', 'user', 1),
(10, 'Идея одобрена #1', '17/03/22 14:32', 'user', 1),
(11, 'Статус идеи изменён #1 to completed', '17/03/22 14:32', 'user', 1),
(12, 'Пользователь # заблокирован на 19691231 дней', '17/03/22 02:52', 'user', 1),
(13, 'Пользователь #$id был заблокирован', '17/03/22 02:52', 'user', 0),
(14, 'Пользователь # заблокирован на 19691231 дней', '17/03/22 02:52', 'user', 1),
(15, 'Пользователь #$id был заблокирован', '17/03/22 02:52', 'user', 0),
(16, 'Пользователь #4 заблокирован на 20220417 дней', '17/03/22 02:59', 'user', 1),
(17, 'Пользователь #$id был заблокирован', '17/03/22 02:59', 'user', 4),
(18, 'Идея #1 прокомментирована', '17/03/22 15:29', 'user', 1),
(19, 'Новая идея создана: gerggggggggggggggggg', '17/03/22 15:44', 'user', 1),
(20, 'Идея одобрена #2', '17/03/22 15:44', 'user', 1),
(21, 'Новая идея создана: ggfhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh', '17/03/22 15:45', 'user', 1),
(22, 'Идея #3 прокомментирована', '17/03/22 15:46', 'user', 1),
(23, 'Идея одобрена #3', '17/03/22 15:46', 'user', 1),
(24, 'Идея #3 прокомментирована', '17/03/22 15:47', 'user', 1),
(25, 'Идея #3 прокомментирована', '17/03/22 15:47', 'user', 1),
(26, 'Идея #3 прокомментирована', '17/03/22 15:47', 'user', 1),
(27, 'Идея #3 прокомментирована', '17/03/22 15:47', 'user', 1),
(28, 'Комментарий удален #4', '17/03/22 15:47', 'user', 1),
(29, 'Комментарий удален #5', '17/03/22 15:47', 'user', 1),
(30, 'Комментарий удален #3', '17/03/22 15:48', 'user', 1),
(31, 'Комментарий удален #2', '17/03/22 15:48', 'user', 1),
(32, 'Комментарий удален #6', '17/03/22 15:51', 'user', 1),
(33, 'Идея #3 прокомментирована', '17/03/22 15:52', 'user', 1),
(34, 'Идея #3 прокомментирована', '17/03/22 15:52', 'user', 1),
(35, 'Комментарий удален #8', '17/03/22 15:52', 'user', 1),
(36, 'Комментарий удален #7', '17/03/22 15:59', 'user', 1),
(37, 'Идея #3 прокомментирована', '17/03/22 16:02', 'user', 1),
(38, 'Идея #3 прокомментирована', '17/03/22 16:10', 'user', 1),
(39, 'Идея #3 прокомментирована', '17/03/22 16:12', 'user', 1),
(40, 'Идея #3 прокомментирована', '17/03/22 16:15', 'user', 1),
(41, 'Идея #3 прокомментирована', '17/03/22 16:16', 'user', 1),
(42, 'Идея #3 прокомментирована', '17/03/22 16:16', 'user', 1),
(43, 'Комментарий удален #11', '17/03/22 16:17', 'user', 1),
(44, 'Идея #3 прокомментирована', '17/03/22 16:17', 'user', 1),
(45, 'Идея #3 прокомментирована', '17/03/22 16:17', 'user', 1),
(46, 'Идея #3 прокомментирована', '17/03/22 16:18', 'user', 1),
(47, 'Комментарий удален #12', '17/03/22 16:19', 'user', 1),
(48, 'Комментарий удален #16', '17/03/22 16:19', 'user', 1),
(49, 'Комментарий удален #15', '17/03/22 16:19', 'user', 1),
(50, 'Комментарий удален #13', '17/03/22 16:19', 'user', 1),
(51, 'Комментарий удален #14', '17/03/22 16:19', 'user', 1),
(52, 'Комментарий удален #17', '17/03/22 16:19', 'user', 1),
(53, 'Статус идеи изменён #3 to considered', '17/03/22 16:20', 'user', 1),
(54, 'Идея #1 прокомментирована', '17/03/22 16:28', 'user', 1),
(55, 'Идея #1 прокомментирована', '17/03/22 16:30', 'user', 1),
(56, 'Комментарий удален #19', '17/03/22 16:31', 'user', 1),
(57, 'Комментарий удален #18', '17/03/22 16:31', 'user', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `value` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'title', 'Atmadev'),
(2, 'welcometext-title', 'Добро пожаловать в систему обратной связи'),
(3, 'welcometext-description', 'Здесь вы можете предложить идеи по улучшению наших услуг или проголосовать за идеи других людей'),
(4, 'recaptchapublic', ''),
(5, 'recaptchaprivate', ''),
(6, 'language', 'rus'),
(7, 'maxvotes', '20'),
(8, 'mainmail', 'montes_816@mail.ru'),
(9, 'max_results', '10'),
(10, 'smtp-host', ''),
(11, 'smtp-port', '25'),
(12, 'smtp-user', ''),
(13, 'smtp-pass', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pass` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `votes` int NOT NULL,
  `isadmin` tinyint(1) NOT NULL,
  `banned` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pass`, `votes`, `isadmin`, `banned`) VALUES
(1, 'jordanpie', 'montes_816@mail.ru', '$2a$08$GKGKSIIYEmxWJnULLIN50.3phMrgw4JE7bet6ejoiJo3nnzC54Om6', 20, 3, 0),
(2, 'jordanpie', 'bobcatoshigu@gmail.com', '$2a$08$MWfOcPmxZcg5Yv3NFjMhZ.HrIjefMsFQFJIwy8mtrt1SYkSsoCpjO', 20, 0, 20220319),
(3, 'jordanpie', 'sergey@mail.com', '$2a$08$YSicONm4SeiE51iotGlyoOBgeINi7H4TYw1jbPW5wSISjBqWFnXTC', 20, 0, 0),
(4, 'jordanpie', 'checkmail@gmail.com', '$2a$08$cKOPUrQnBOLNUdit9SAJtOoWp8ps5YVhVZI2CKx58R3qQdMHpFPWG', 20, 0, 20220417),
(5, 'jordanpie', 'mailgroup@mail.ru', '$2a$08$yCYmrhlUOXg7Q4fsBStuGeVbxwODm.YxYFU4oM6Q8pJqHSqdR525S', 20, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int NOT NULL,
  `ideaid` int NOT NULL,
  `userid` int NOT NULL,
  `number` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `_sessions`
--

CREATE TABLE `_sessions` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `token` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `flags`
--
ALTER TABLE `flags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `ideas`
--
ALTER TABLE `ideas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `_sessions`
--
ALTER TABLE `_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `flags`
--
ALTER TABLE `flags`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ideas`
--
ALTER TABLE `ideas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `_sessions`
--
ALTER TABLE `_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
