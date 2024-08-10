-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 10, 2024 at 02:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crisis_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(9) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `description`) VALUES
(7, 'apple'),
(8, 'lemons '),
(9, 'wfcsafsfafaf');

-- --------------------------------------------------------

--
-- Table structure for table `announcement_products`
--

CREATE TABLE `announcement_products` (
  `announcement_id` int(9) NOT NULL,
  `product_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement_products`
--

INSERT INTO `announcement_products` (`announcement_id`, `product_id`) VALUES
(7, 19),
(8, 25),
(9, 16);

-- --------------------------------------------------------

--
-- Table structure for table `base`
--

CREATE TABLE `base` (
  `base_id` int(9) NOT NULL,
  `location_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `base`
--

INSERT INTO `base` (`base_id`, `location_id`) VALUES
(2, 7);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(9) NOT NULL,
  `x_coordinate` double NOT NULL,
  `y_coordinate` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `x_coordinate`, `y_coordinate`) VALUES
(7, 38.12591462924157, 23.747634887695316),
(8, 38.1442775452969, 23.35418701171875),
(9, 38.125644551886154, 23.748235702514652),
(10, 37.932046, 23.795829);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(9) NOT NULL,
  `quantity` int(30) DEFAULT NULL,
  `product_category` int(9) NOT NULL,
  `details` text DEFAULT NULL,
  `product_name` varchar(30) NOT NULL,
  `availability` enum('YES','NO') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `quantity`, `product_category`, `details`, `product_name`, `availability`) VALUES
(16, NULL, 6, 'volume: 1.5l, pack size: 6', 'Water', 'YES'),
(17, NULL, 6, 'volume: 250ml, pack size: 12', 'Orange juice', 'YES'),
(18, 18, 5, 'brand: Trata, weight: 200g', 'Sardines', 'YES'),
(19, NULL, 5, 'weight: 500g', 'Canned corn', 'YES'),
(20, NULL, 5, 'weight: 1kg, type: white', 'Bread', 'YES'),
(21, NULL, 5, 'weight: 100g, type: milk chocolate, brand: ION', 'Chocolate', 'YES'),
(22, NULL, 7, 'size: 44', 'Men Sneakers', 'YES'),
(23, NULL, 9, 'weight: 500g, pack size: 12, expiry date: 13/12/1978', 'Test Product', 'YES'),
(24, NULL, 14, 'Details: 600ml', 'Test Val', 'YES'),
(25, NULL, 5, 'grams: 500', 'Spaghetti', 'YES'),
(26, NULL, 5, 'calories: 200', 'Croissant', 'YES'),
(28, NULL, 10, ':', '', 'YES'),
(29, NULL, 5, ':', 'Biscuits', 'YES'),
(30, NULL, 16, ': 25 pcs', 'Bandages', 'YES'),
(31, NULL, 16, ': 100 pcs', 'Disposable gloves', 'YES'),
(32, NULL, 16, ':', 'Gauze', 'YES'),
(33, NULL, 16, ': 250ml', 'Antiseptic', 'YES'),
(34, NULL, 16, ':', 'First Aid Kit', 'YES'),
(35, NULL, 16, 'volume: 200mg', 'Painkillers', 'YES'),
(36, NULL, 7, 'size: 50\" x 60\"', 'Blanket', 'YES'),
(37, NULL, 5, ':', 'Fakes', 'YES'),
(38, NULL, 21, 'stock: 500, size: 3, :', 'Menstrual Pads', 'YES'),
(39, NULL, 21, 'stock: 500, size: regular', 'Tampon', 'YES'),
(40, NULL, 21, 'stock: 300, ply: 3', 'Toilet Paper', 'YES'),
(41, NULL, 21, 'volume: 500gr, stock : 500, scent: aloe', 'Baby wipes', 'YES'),
(42, NULL, 21, 'stock: 500', 'Toothbrush', 'YES'),
(43, NULL, 21, 'stock: 250', 'Toothpaste', 'YES'),
(44, NULL, 16, 'stock: 200', 'Vitamin C', 'YES'),
(45, NULL, 16, 'stock: 200', 'Multivitamines', 'YES'),
(46, NULL, 16, 'stock: 2000, dosage: 500mg', 'Paracetamol', 'YES'),
(47, NULL, 16, 'stock : 10, dosage: 200mg', 'Ibuprofen', 'YES'),
(48, NULL, 10, ':', '', 'YES'),
(49, NULL, 10, ': , : , :', '', 'YES'),
(50, NULL, 10, ':', '', 'YES'),
(51, NULL, 22, ':', 'Cleaning rag', 'YES'),
(52, NULL, 22, ':', 'Detergent', 'YES'),
(53, NULL, 22, ':', 'Disinfectant', 'YES'),
(54, NULL, 22, ':', 'Mop', 'YES'),
(55, NULL, 22, ':', 'Plastic bucket', 'YES'),
(56, NULL, 22, ':', 'Scrub brush', 'YES'),
(57, NULL, 22, ':', 'Dust mask', 'YES'),
(58, NULL, 22, ':', 'Broom', 'YES'),
(59, NULL, 23, ':', 'Hammer', 'YES'),
(60, NULL, 23, ':', 'Skillsaw', 'YES'),
(61, NULL, 23, ':', 'Prybar', 'YES'),
(62, NULL, 23, ':', 'Shovel', 'YES'),
(63, NULL, 23, ':', 'Flashlight', 'YES'),
(64, NULL, 23, ':', 'Duct tape', 'YES'),
(65, NULL, 7, ':', 'Underwear', 'YES'),
(66, NULL, 7, ':', 'Socks', 'YES'),
(67, NULL, 7, ':', 'Warm Jacket', 'YES'),
(68, NULL, 7, ':', 'Raincoat', 'YES'),
(69, NULL, 7, ':', 'Gloves', 'YES'),
(70, NULL, 7, ':', 'Pants', 'YES'),
(71, NULL, 7, ':', 'Boots', 'YES'),
(72, NULL, 24, ':', 'Dishes', 'YES'),
(73, NULL, 24, ':', 'Pots', 'YES'),
(74, NULL, 24, ':', 'Paring knives', 'YES'),
(75, NULL, 24, ':', 'Pan', 'YES'),
(76, NULL, 24, ':', 'Glass', 'YES'),
(77, NULL, 10, ': , : , :', '', 'YES'),
(78, NULL, 10, ':', '', 'YES'),
(79, NULL, 10, ':', '', 'YES'),
(80, NULL, 10, ':', '', 'YES'),
(81, NULL, 10, ':', '', 'YES'),
(82, NULL, 10, ': , : , : , ghw56: twhwhrwh, :', '', 'YES'),
(83, NULL, 9, 'wtwty: wytwty', 't22', 'YES'),
(84, NULL, 6, ':', 'water ', 'YES'),
(85, NULL, 6, 'Volume: 500ml', 'Coca Cola', 'YES'),
(86, NULL, 26, 'volume: 75ml', 'spray', 'YES'),
(87, NULL, 26, 'duration: 7 hours', 'Outdoor spiral', 'YES'),
(88, NULL, 25, 'volume: 250ml', 'Baby bottle', 'YES'),
(89, NULL, 25, 'material: silicone', 'Pacifier', 'YES'),
(90, NULL, 5, 'weight: 400gr', 'Condensed milk', 'YES'),
(91, NULL, 5, 'weight: 23,5gr', 'Cereal bar', 'YES'),
(92, NULL, 23, 'Number of different tools: 3, Tool: Knife, Tool: Screwdriver, Tool: Spoon', 'Pocket Knife', 'YES'),
(93, NULL, 16, 'Basic Ingredients: Iodine, Suggested for: Everyone expept pregnant women', 'Water Disinfection Tablets', 'YES'),
(94, NULL, 27, 'Power: Batteries, Frequencies Range: 3 kHz - 3000 GHz', 'Radio', 'YES'),
(95, NULL, 14, ': (scrubbers, rubber gloves, kitchen detergent, laundry soap)', 'Kitchen appliances', 'YES'),
(96, NULL, 28, ':', 'Winter hat', 'YES'),
(97, NULL, 28, ':', 'Winter gloves', 'YES'),
(98, NULL, 28, ':', 'Scarf', 'YES'),
(99, NULL, 28, ':', 'Thermos', 'YES'),
(100, NULL, 6, 'volume: 500ml', 'Tea', 'YES'),
(101, NULL, 29, 'volume: 500g', 'Dog Food ', 'YES'),
(102, NULL, 29, 'volume: 500g', 'Cat Food', 'YES'),
(103, NULL, 5, ':', 'Canned', 'YES'),
(104, NULL, 22, 'volume: 500ml', 'Chlorine', 'YES'),
(105, NULL, 22, 'volume: 20pieces', 'Medical gloves', 'YES'),
(106, NULL, 7, 'size: XL', 'T-Shirt', 'YES'),
(107, NULL, 34, ':', 'Cooling Fan', 'YES'),
(108, NULL, 34, ':', 'Cool Scarf', 'YES'),
(109, NULL, 23, ':', 'Whistle', 'YES'),
(110, NULL, 28, ':', 'Blankets', 'YES'),
(111, NULL, 28, ':', 'Sleeping Bag', 'YES'),
(112, NULL, 21, ':', 'Toothbrush', 'YES'),
(113, NULL, 21, ':', 'Toothpaste', 'YES'),
(114, NULL, 16, ':', 'Thermometer', 'YES'),
(115, NULL, 5, ':', 'Rice', 'YES'),
(116, NULL, 5, ':', 'Bread', 'YES'),
(117, NULL, 22, ':', 'Towels', 'YES'),
(118, NULL, 22, ':', 'Wet Wipes', 'YES'),
(119, NULL, 23, ':', 'Fire Extinguisher', 'YES'),
(120, NULL, 5, ': , :', 'Fruits', 'YES'),
(121, NULL, 23, ':', 'Duct Tape', 'YES'),
(122, NULL, 10, ':', '', 'YES'),
(123, NULL, 19, 'Νο 46:', 'Αθλητικά', 'YES'),
(124, NULL, 5, ':', 'Πασατέμπος', 'YES');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `product_category_id` int(9) NOT NULL,
  `name_category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`product_category_id`, `name_category`) VALUES
(5, 'Food'),
(6, 'Beverages'),
(7, 'Clothing'),
(8, 'Hacker of class'),
(9, '2d hacker'),
(10, ''),
(11, 'Test'),
(13, '-----'),
(14, 'Flood'),
(15, 'new cat'),
(16, 'Medical Supplies'),
(19, 'Shoes'),
(21, 'Personal Hygiene '),
(22, 'Cleaning Supplies'),
(23, 'Tools'),
(24, 'Kitchen Supplies'),
(25, 'Baby Essentials'),
(26, 'Insect Repellents'),
(27, 'Electronic Devices'),
(28, 'Cold weather'),
(29, 'Animal Food'),
(30, 'Financial support'),
(33, 'Cleaning Supplies.'),
(34, 'Hot Weather');

-- --------------------------------------------------------

--
-- Table structure for table `rescuer`
--

CREATE TABLE `rescuer` (
  `user_id` int(9) NOT NULL,
  `vehicle_id` int(9) NOT NULL,
  `location_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rescuer`
--

INSERT INTO `rescuer` (`user_id`, `vehicle_id`, `location_id`) VALUES
(6, 1, 9);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `vehicle_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`vehicle_id`, `transaction_id`) VALUES
(1, 3),
(1, 0),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('PENDING','ACCEPTED','COMPLETE','CANCELED') NOT NULL,
  `type` enum('REQUEST','OFFER') NOT NULL,
  `time_of_submition` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `time_of_acceptance` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `time_of_completion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `user_id`, `product_id`, `quantity`, `status`, `type`, `time_of_submition`, `time_of_acceptance`, `time_of_completion`) VALUES
(0, 5, 17, 2, 'COMPLETE', 'REQUEST', '2024-08-05 08:34:53', '2023-12-12 18:39:57', '2023-12-12 18:39:57'),
(1, 5, 16, 5, 'PENDING', 'OFFER', '2024-02-08 17:12:05', '2023-12-11 17:29:13', '2023-12-11 17:29:13'),
(3, 4, 18, 1, 'ACCEPTED', 'OFFER', '2024-02-07 18:27:24', '2024-01-04 18:07:32', '2024-01-04 18:07:32'),
(120, 5, 18, 5, 'PENDING', 'REQUEST', '2024-08-10 11:03:29', '2024-08-10 11:03:29', '2024-08-10 11:03:29'),
(121, 5, 19, 5, 'PENDING', 'REQUEST', '2024-08-10 11:03:29', '2024-08-10 11:03:29', '2024-08-10 11:03:29'),
(122, 5, 18, 5, 'PENDING', 'REQUEST', '2024-08-10 11:03:58', '2024-08-10 11:03:58', '2024-08-10 11:03:58'),
(123, 5, 20, 5, 'PENDING', 'REQUEST', '2024-08-10 11:03:58', '2024-08-10 11:03:58', '2024-08-10 11:03:58'),
(124, 5, 18, 12, 'CANCELED', 'REQUEST', '2024-08-10 11:42:41', '2024-08-10 11:42:41', '2024-08-10 11:42:41'),
(125, 5, 19, 4, 'PENDING', 'OFFER', '2024-08-10 11:45:28', '2024-08-10 11:45:28', '2024-08-10 11:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(9) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `user_type` enum('Admin','Rescuer','Citizen') NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `location_id` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `user_type`, `first_name`, `last_name`, `phone`, `location_id`) VALUES
(4, 'admin', '1234', 'Admin', 'teo', 'kon', '111111', 7),
(5, 'user', '1234', 'Citizen', 'teo', 'kon ', '7777', 8),
(6, 'rescuer', '1234', 'Rescuer', 'Kostas', 'Papanikolaou', '767676', 9),
(7, 'user1', '1234', 'Citizen', 'Den', 'Hai', '1232244', 10);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `vehicle_id` int(9) NOT NULL,
  `location_id` int(9) NOT NULL,
  `vehicle_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`vehicle_id`, `location_id`, `vehicle_name`) VALUES
(1, 9, 'bbnbn');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_product`
--

CREATE TABLE `vehicle_product` (
  `vehicle_id` int(9) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_product`
--

INSERT INTO `vehicle_product` (`vehicle_id`, `product_id`, `quantity`) VALUES
(1, 16, 4),
(1, 17, 15),
(1, 18, 3),
(1, 20, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `announcement_products`
--
ALTER TABLE `announcement_products`
  ADD KEY `announcement_id` (`announcement_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `base`
--
ALTER TABLE `base`
  ADD PRIMARY KEY (`base_id`),
  ADD KEY `location_id_base` (`location_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_type_id` (`product_category`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `rescuer`
--
ALTER TABLE `rescuer`
  ADD KEY `location_id_rescuer` (`location_id`),
  ADD KEY `vehicle_id_rescuer` (`vehicle_id`),
  ADD KEY `user_id_rescuer` (`user_id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD KEY `fk vehicle` (`vehicle_id`),
  ADD KEY `fk transaction` (`transaction_id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk user` (`user_id`),
  ADD KEY `fk product` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `location_id` (`location_id`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD KEY `location_id_vehicle` (`location_id`);

--
-- Indexes for table `vehicle_product`
--
ALTER TABLE `vehicle_product`
  ADD PRIMARY KEY (`vehicle_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `base`
--
ALTER TABLE `base`
  MODIFY `base_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `vehicle_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcement_products`
--
ALTER TABLE `announcement_products`
  ADD CONSTRAINT `announcement_id` FOREIGN KEY (`announcement_id`) REFERENCES `announcement` (`announcement_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `base`
--
ALTER TABLE `base`
  ADD CONSTRAINT `location_id_base` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_category_id` FOREIGN KEY (`product_category`) REFERENCES `product_type` (`product_category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rescuer`
--
ALTER TABLE `rescuer`
  ADD CONSTRAINT `location_id_rescuer` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_id_rescuer` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicle_id_rescuer` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `fk transaction` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk vehicle` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `location_id` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD CONSTRAINT `location_id_vehicle` FOREIGN KEY (`location_id`) REFERENCES `location` (`location_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicle_product`
--
ALTER TABLE `vehicle_product`
  ADD CONSTRAINT `vehicle_product_ibfk_1` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`vehicle_id`),
  ADD CONSTRAINT `vehicle_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
