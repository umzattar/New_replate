-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 30 نوفمبر 2024 الساعة 17:08
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbfoods`
--

-- --------------------------------------------------------

--
-- بنية الجدول `foods`
--

CREATE TABLE `foods` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `details` text NOT NULL,
  `rest_id` int(11) NOT NULL,
  `EndAdv` timestamp NOT NULL DEFAULT current_timestamp(),
  `Posted` timestamp NOT NULL DEFAULT current_timestamp(),
  `Price` float NOT NULL,
  `imagePath` varchar(200) NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- إرجاع أو استيراد بيانات الجدول `foods`
--

INSERT INTO `foods` (`id`, `title`, `description`, `details`, `rest_id`, `EndAdv`, `Posted`, `Price`, `imagePath`, `state`) VALUES
(1, 'Amazing Pizza', '', '15-30 mins', 1, '2023-11-22 21:10:49', '2023-11-22 21:10:49', 5, 'img/images1.jpg', 1),
(2, 'Fresh Salad', '', '15-30 mins', 1, '2023-11-22 21:10:49', '2023-11-22 21:10:49', 2, 'img/images2.jpg', 1),
(3, 'Sweet Pancake', '', '15-30 mins', 2, '2023-11-22 21:14:36', '2023-11-22 21:14:36', 2, 'img/images3.jpg', 1),
(4, 'Well Done Steak', '', '15-30 mins', 4, '2023-11-22 21:14:36', '2023-11-22 21:14:36', 10, 'img/images4.jpg', 1),
(5, 'Healty Breakfast', '', '15-30 mins', 2, '2023-11-22 21:14:36', '2023-11-22 21:14:36', 12, 'img/images5.jpg', 1),
(6, 'Fantastic Burger', '', '15-30 mins', 3, '2023-11-22 21:14:36', '2023-11-22 21:14:36', 6, 'img/images6.jpg', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `messages`
--

CREATE TABLE `messages` (
  `msgid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `mycart`
--

CREATE TABLE `mycart` (
  `id` int(4) NOT NULL,
  `foodid` int(4) NOT NULL,
  `usrid` int(4) NOT NULL,
  `type` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `mypoints`
--

CREATE TABLE `mypoints` (
  `id` int(4) NOT NULL,
  `userid` int(4) NOT NULL,
  `ordercode` varchar(8) NOT NULL,
  `v_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` float NOT NULL DEFAULT 0,
  `countpoints` int(4) NOT NULL,
  `code_discount_points` varchar(8) NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `orders`
--

CREATE TABLE `orders` (
  `id` int(4) NOT NULL,
  `usrid` int(4) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `total` float NOT NULL,
  `tax` float NOT NULL,
  `fee` float NOT NULL,
  `discount_points` float NOT NULL DEFAULT 0,
  `netTotal` float NOT NULL,
  `ordercode` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `v_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `state` int(1) NOT NULL DEFAULT 0,
  `payment` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `orders_details`
--

CREATE TABLE `orders_details` (
  `rowid` int(4) NOT NULL,
  `usrid` int(4) NOT NULL,
  `ordercode` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `foodid` int(4) NOT NULL,
  `qty` float NOT NULL,
  `price` float NOT NULL,
  `total` float NOT NULL,
  `v_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `product_id` int(4) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `payment_amount` float(10,2) NOT NULL,
  `currency_code` varchar(255) NOT NULL,
  `payment_status` varchar(20) NOT NULL,
  `invoice_id` varchar(50) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `createdtime` datetime DEFAULT NULL,
  `ordercode` varchar(10) NOT NULL,
  `UsrId` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `resturants`
--

CREATE TABLE `resturants` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(200) NOT NULL,
  `imagePath` varchar(200) NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- إرجاع أو استيراد بيانات الجدول `resturants`
--

INSERT INTO `resturants` (`id`, `name`, `description`, `imagePath`, `state`) VALUES
(1, 'Burgerizzr', 'restaurant don\'t manage to sell all of their food by the end of the day, we throw away surplus', 'img/Resturant1.png', 1),
(2, 'Albaik', 'restaurant don\'t manage to sell all of their food by the end of the day, we throw away surplus', 'img/Resturant2.png', 1),
(3, 'Altazaj', 'restaurant don\'t manage to sell all of their food by the end of the day, we throw away surplus', 'img/Resturant3.jpg', 1),
(4, 'McDonalds', 'restaurant don\'t manage to sell all of their food by the end of the day, we throw away surplus', 'img/Resturant4.png', 1),
(5, 'Burger King', 'restaurant don\'t manage to sell all of their food by the end of the day, we throw away surplus', 'img/Resturant5.png', 1);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `AccountType` int(11) NOT NULL,
  `UserName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `PassWord` varchar(255) NOT NULL,
  `IsActive` int(2) NOT NULL,
  `RegisterDate` datetime NOT NULL,
  `LoginDate` datetime NOT NULL,
  `img` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msgid`);

--
-- Indexes for table `mycart`
--
ALTER TABLE `mycart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mypoints`
--
ALTER TABLE `mypoints`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_details`
--
ALTER TABLE `orders_details`
  ADD PRIMARY KEY (`rowid`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resturants`
--
ALTER TABLE `resturants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `UserName` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msgid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mycart`
--
ALTER TABLE `mycart`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `mypoints`
--
ALTER TABLE `mypoints`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders_details`
--
ALTER TABLE `orders_details`
  MODIFY `rowid` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `resturants`
--
ALTER TABLE `resturants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
