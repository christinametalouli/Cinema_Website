-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 20, 2023 at 05:37 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinema`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `booking_date` datetime NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `movie_id`, `booking_date`, `email`) VALUES
(1, 1, 1, '2023-02-19 18:07:19', 'johndoe@example.com'),
(2, 2, 1, '2023-02-19 18:07:19', 'janedoe@example.com'),
(3, 1, 2, '2023-02-19 18:07:19', 'johndoe@example.com'),
(4, 2, 3, '2023-02-19 18:07:19', 'janedoe@example.com'),
(5, 1, 3, '2023-03-05 12:34:56', 'random@nomail.com'),
(7, 1, 3, '2023-03-05 12:34:56', 'random@nomail.com'),
(8, 1, 3, '2023-03-05 12:34:56', 'random@nomail.com'),
(9, 1, 3, '2023-03-05 12:34:56', 'random@nomail.com'),
(10, 1, 1, '2023-02-18 00:00:00', 'johndoe@example.com'),
(11, 1, 1, '2023-02-23 00:00:00', 'johndoe@example.com'),
(12, 1, 3, '2023-02-26 00:00:00', 'johndoe@example.com'),
(13, 1, 3, '2023-03-01 00:00:00', 'johndoe@example.com'),
(14, 1, 3, '2023-02-10 00:00:00', 'johndoe@example.com'),
(15, 1, 3, '2023-02-09 00:00:00', 'johndoe@example.com'),
(16, 1, 3, '2023-02-19 00:00:00', 'johndoe@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `name`, `image_url`) VALUES
(1, 'Avatar', 'images/im1.jpg'),
(2, 'Venom', 'images/im2.jpg'),
(3, 'Avengers', 'images/im3.jpg'),
(4, 'CAPTAIN MARVEL', 'images/im4.jpg'),
(5, 'DOCTOR STRANGE', 'images/im5.jpg'),
(6, 'JUSTICE LEAGUE', 'images/im6.jpg'),
(7, 'SPIDERMAN', 'images/im7.jpg'),
(8, 'BLACK PANTHER', 'images/im8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registration_requests`
--

CREATE TABLE `registration_requests` (
  `request_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `country` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `country`, `city`, `address`, `email`, `username`, `password`, `role_id`) VALUES
(1, 'John', 'Doe', 'USA', 'New York', '123 Main St', 'johndoe@example.com', 'user', 'user', 2),
(2, 'Jane', 'Doe', 'USA', 'Los Angeles', '456 Maple St', 'janedoe@example.com', 'janedoe', 'password456', 2),
(3, 'Admin', 'User', 'USA', 'Washington D.C.', '789 Oak St', 'admin@example.com', 'admin', 'admin', 1),
(4, 'Shahid', 'Doe', 'USA', 'New York', '123 Main St', 'johndoe@example.com', 'johndoeshahid', 'secret', 1),
(8, 'Bob', 'Smith', 'USA', 'Chicago', '246 Elm St', 'bobsmith@example.com', 'bobsmith', 'password123', 2),
(9, 'Alice', 'Jones', 'USA', 'Houston', '135 Pine St', 'alicejones@example.com', 'alicejones', 'password456', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`, `role_description`) VALUES
(1, 'admin', 'Has full access to all parts of the system.'),
(2, 'user', 'Can view and book movies.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_movie_id` (`movie_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `registration_requests`
--
ALTER TABLE `registration_requests`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_role_id` (`role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `registration_requests`
--
ALTER TABLE `registration_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
