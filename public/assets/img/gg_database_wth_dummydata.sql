-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 06:03 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gearguard`
--

-- --------------------------------------------------------

--
-- Table structure for table `gg_forum_comment`
--

CREATE TABLE `gg_forum_comment` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_forum_comment`
--

INSERT INTO `gg_forum_comment` (`post_id`, `user_id`, `id`, `content`, `timestamp`) VALUES
(1, 2, 1, 'Great tips, thanks!', '2023-11-01 07:00:00'),
(2, 1, 2, 'Awesome list!', '2023-11-02 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `gg_forum_post`
--

CREATE TABLE `gg_forum_post` (
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_forum_post`
--

INSERT INTO `gg_forum_post` (`topic_id`, `user_id`, `id`, `content`, `timestamp`) VALUES
(1, 1, 1, 'How to maintain your car?', '2023-11-01 06:30:00'),
(2, 2, 2, 'Best cars of 2023', '2023-11-02 07:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `gg_forum_reply`
--

CREATE TABLE `gg_forum_reply` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_forum_reply`
--

INSERT INTO `gg_forum_reply` (`comment_id`, `user_id`, `id`, `content`, `timestamp`) VALUES
(1, 1, 1, 'You are welcome!', '2023-11-01 07:15:00'),
(2, 2, 2, 'Glad you liked it!', '2023-11-02 08:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `gg_forum_topic`
--

CREATE TABLE `gg_forum_topic` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_forum_topic`
--

INSERT INTO `gg_forum_topic` (`id`, `title`) VALUES
(1, 'Maintenance Tips'),
(2, 'Vehicle Reviews');

-- --------------------------------------------------------

--
-- Table structure for table `gg_garage`
--

CREATE TABLE `gg_garage` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `registration_no` varchar(100) DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_garage`
--

INSERT INTO `gg_garage` (`id`, `username`, `password`, `name`, `address`, `email`, `contact_no`, `registration_no`, `status_id`) VALUES
(1, 'garage1', 'garage123', 'Garage One', '789 Maple St', 'garage1@example.com', '5555555555', 'REG123', 2),
(2, 'garage2', 'garage456', 'Garage Two', '101 Oak St', 'garage2@example.com', '4444444444', 'REG456', 1);

-- --------------------------------------------------------

--
-- Table structure for table `gg_garage_mechanic`
--

CREATE TABLE `gg_garage_mechanic` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `nic` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `date_employeed` date NOT NULL,
  `garage_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_garage_mechanic`
--

INSERT INTO `gg_garage_mechanic` (`username`, `password`, `first_name`, `last_name`, `id`, `nic`, `address`, `email`, `contact_no`, `date_employeed`, `garage_id`, `status_id`) VALUES
('mechanic1', 'mech123', 'Tom', 'Hardy', 1, 'NIC789', '567 Pine St', 'mech1@example.com', '3333333333', '2019-01-01', 1, 2),
('mechanic2', 'mech456', 'Jerry', 'Mouse', 2, 'NIC012', '890 Cedar St', 'mech2@example.com', '2222222222', '2020-01-01', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gg_garage_service`
--

CREATE TABLE `gg_garage_service` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `garage_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_garage_service`
--

INSERT INTO `gg_garage_service` (`id`, `type`, `price`, `garage_id`, `status_id`) VALUES
(1, 'Oil Change', 100, 1, 2),
(2, 'Tire Rotation', 50, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gg_owner_ownership_type`
--

CREATE TABLE `gg_owner_ownership_type` (
  `id` int(11) NOT NULL,
  `ownership_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_owner_ownership_type`
--

INSERT INTO `gg_owner_ownership_type` (`id`, `ownership_type`) VALUES
(1, 'Leased'),
(2, 'Owned');

-- --------------------------------------------------------

--
-- Table structure for table `gg_service_mechanic_perform`
--

CREATE TABLE `gg_service_mechanic_perform` (
  `service_id` int(11) NOT NULL,
  `mechanic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gg_sparepart`
--

CREATE TABLE `gg_sparepart` (
  `id` int(11) NOT NULL,
  `serial_no` varchar(100) NOT NULL,
  `type` varchar(150) NOT NULL,
  `manufacturer` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `manufactured_date` date DEFAULT NULL,
  `waranty_period` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_sparepart`
--

INSERT INTO `gg_sparepart` (`id`, `serial_no`, `type`, `manufacturer`, `price`, `manufactured_date`, `waranty_period`) VALUES
(1, 'SP123', 'Brake Pad', 'Bosch', 50, '2021-01-01', '2023-01-01'),
(2, 'SP456', 'Air Filter', 'K&N', 30, '2022-01-01', '2024-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `gg_sparepart_service_vehicle_install`
--

CREATE TABLE `gg_sparepart_service_vehicle_install` (
  `vehicle_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `sparepart_id` int(11) NOT NULL,
  `installed_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_sparepart_service_vehicle_install`
--

INSERT INTO `gg_sparepart_service_vehicle_install` (`vehicle_id`, `service_id`, `sparepart_id`, `installed_date`) VALUES
(1, 1, 1, '2022-11-01'),
(2, 2, 2, '2023-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `gg_sparepart_vehicleuser_vehicle_install`
--

CREATE TABLE `gg_sparepart_vehicleuser_vehicle_install` (
  `vehicle_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sparepart_id` int(11) NOT NULL,
  `installed_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gg_status`
--

CREATE TABLE `gg_status` (
  `id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_status`
--

INSERT INTO `gg_status` (`id`, `status`) VALUES
(2, 'active'),
(3, 'deleted'),
(1, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `gg_user`
--

CREATE TABLE `gg_user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `nic` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_no` varchar(100) NOT NULL,
  `status_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_user`
--

INSERT INTO `gg_user` (`username`, `password`, `first_name`, `last_name`, `id`, `nic`, `address`, `email`, `contact_no`, `status_id`, `status`) VALUES
('san', '$2y$10$FUXxnSwCQ93gO5dvOHCqkOYIOyL2EoxJCiWcKfBRdAlnugREWi5cC', 'san', 'san', 1, '111111111111111', 'san', 'sa@gmail.com', '11111111111111', 1, 1),
('jdoe', 'password123', 'John', 'Doe', 2, 'NIC123', '123 Main St', 'jdoe@example.com', '1234567890', 2, 0),
('asmith', 'password456', 'Alice', 'Smith', 3, 'NIC456', '456 Elm St', 'asmith@example.com', '0987654321', 1, 0);

-- --------------------------------------------------------

--
-- Stand-in structure for view `gg_users_all_view`
-- (See below for the actual view)
--
CREATE TABLE `gg_users_all_view` (
`unique_id` bigint(21)
,`id` int(11)
,`name` varchar(100)
,`username` varchar(30)
,`password` varchar(255)
,`source_table` varchar(18)
);

-- --------------------------------------------------------

--
-- Table structure for table `gg_user_admin`
--

CREATE TABLE `gg_user_admin` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gg_user_owner`
--

CREATE TABLE `gg_user_owner` (
  `vehicle_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ownership_status_id` int(11) NOT NULL,
  `registration_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_user_owner`
--

INSERT INTO `gg_user_owner` (`vehicle_id`, `user_id`, `ownership_status_id`, `registration_date`) VALUES
(1, 1, 2, '2018-02-01'),
(2, 2, 1, '2020-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `gg_user_vehicleuser`
--

CREATE TABLE `gg_user_vehicleuser` (
  `user_id` int(11) NOT NULL,
  `license_no` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_user_vehicleuser`
--

INSERT INTO `gg_user_vehicleuser` (`user_id`, `license_no`) VALUES
(1, 'LN12345'),
(2, 'LN67890');

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle`
--

CREATE TABLE `gg_vehicle` (
  `id` int(11) NOT NULL,
  `vin` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `year_manufactured` date DEFAULT NULL,
  `license_plate_no` varchar(20) NOT NULL,
  `class_id` int(11) NOT NULL,
  `engine_capacity_id` int(11) NOT NULL,
  `fuel_type_id` int(11) NOT NULL,
  `bodytype_id` int(11) NOT NULL,
  `insurance_no` varchar(100) DEFAULT NULL,
  `engine_no` varchar(100) NOT NULL,
  `current_user_id` int(11) DEFAULT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle`
--

INSERT INTO `gg_vehicle` (`id`, `vin`, `model_id`, `year_manufactured`, `license_plate_no`, `class_id`, `engine_capacity_id`, `fuel_type_id`, `bodytype_id`, `insurance_no`, `engine_no`, `current_user_id`, `status_id`) VALUES
(1, 12345, 1, '2018-01-01', 'ABC123', 2, 1, 1, 1, 'INS123', 'ENG123', 1, 2),
(2, 67890, 2, '2020-01-01', 'XYZ789', 3, 2, 2, 2, 'INS456', 'ENG456', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_assignments`
--

CREATE TABLE `gg_vehicle_assignments` (
  `vehicle_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_assigned` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_assignments`
--

INSERT INTO `gg_vehicle_assignments` (`vehicle_id`, `owner_id`, `user_id`, `date_assigned`) VALUES
(1, 1, 1, '2021-01-01'),
(2, 2, 2, '2022-01-01');

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_bodytype`
--

CREATE TABLE `gg_vehicle_bodytype` (
  `id` int(11) NOT NULL,
  `bodytype` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_bodytype`
--

INSERT INTO `gg_vehicle_bodytype` (`id`, `bodytype`) VALUES
(3, 'Convertible'),
(2, 'Coupe'),
(1, 'Hatchback');

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_class`
--

CREATE TABLE `gg_vehicle_class` (
  `id` int(11) NOT NULL,
  `class` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_class`
--

INSERT INTO `gg_vehicle_class` (`id`, `class`) VALUES
(2, 'Sedan'),
(1, 'SUV'),
(3, 'Truck');

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_engine_capacity`
--

CREATE TABLE `gg_vehicle_engine_capacity` (
  `id` int(11) NOT NULL,
  `capacity` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_engine_capacity`
--

INSERT INTO `gg_vehicle_engine_capacity` (`id`, `capacity`) VALUES
(1, '1500cc'),
(2, '2000cc'),
(3, '2500cc');

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_fueltype`
--

CREATE TABLE `gg_vehicle_fueltype` (
  `id` int(11) NOT NULL,
  `fueltype` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_fueltype`
--

INSERT INTO `gg_vehicle_fueltype` (`id`, `fueltype`) VALUES
(2, 'Diesel'),
(3, 'Electric'),
(1, 'Petrol');

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_manufacturer`
--

CREATE TABLE `gg_vehicle_manufacturer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_manufacturer`
--

INSERT INTO `gg_vehicle_manufacturer` (`id`, `name`) VALUES
(3, 'Ford'),
(2, 'Honda'),
(1, 'Toyota');

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_model`
--

CREATE TABLE `gg_vehicle_model` (
  `id` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `manufacturer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_model`
--

INSERT INTO `gg_vehicle_model` (`id`, `model`, `manufacturer_id`) VALUES
(2, 'Civic', 2),
(1, 'Corolla', 1),
(3, 'Focus', 3);

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_service_appointment`
--

CREATE TABLE `gg_vehicle_service_appointment` (
  `vehicle_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_service_appointment`
--

INSERT INTO `gg_vehicle_service_appointment` (`vehicle_id`, `service_id`, `date`, `time`) VALUES
(1, 1, '2022-12-01', '10:00:00'),
(2, 2, '2023-02-01', '15:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `gg_vehicle_service_take`
--

CREATE TABLE `gg_vehicle_service_take` (
  `vehicle_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `mechanic_id` int(11) NOT NULL,
  `begin_timestamp` datetime NOT NULL,
  `end_timestamp` datetime NOT NULL,
  `duration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gg_vehicle_service_take`
--

INSERT INTO `gg_vehicle_service_take` (`vehicle_id`, `service_id`, `mechanic_id`, `begin_timestamp`, `end_timestamp`, `duration`) VALUES
(1, 1, 1, '2022-11-01 10:00:00', '2022-11-01 11:00:00', '0000-00-00 00:00:00'),
(2, 2, 2, '2023-01-01 15:00:00', '2023-01-01 15:30:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(11) NOT NULL,
  `migration` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `created_at`) VALUES
(1, 'm0001_initial.php', '2024-11-26 06:36:23'),
(2, 'm0002_add_password.php', '2024-11-26 06:36:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
<div class="alert alert-danger" role="alert"><img src="themes/dot.gif" title="" alt="" class="icon ic_s_error"> RuntimeException: No statement inside WITH</div></body></html>