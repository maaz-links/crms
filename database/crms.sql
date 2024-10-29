-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2024 at 08:14 AM
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
-- Database: `crms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(20) NOT NULL,
  `admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`admin_id`, `admin_name`, `admin_password`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `tblcar`
--

CREATE TABLE `tblcar` (
  `car_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `number` varchar(20) NOT NULL,
  `category_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `details` varchar(255) NOT NULL,
  `rental_price` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcar`
--

INSERT INTO `tblcar` (`car_id`, `model`, `number`, `category_id`, `owner_id`, `location_id`, `details`, `rental_price`, `image`, `status`) VALUES
(2, 'Toyota Hilux', 'ISL112', 3, 5, 4, 'Transmission: Manual\r\nAir Conditioning: Yes\r\n', 5000, 'IMG-664b349b8290d5.23862170.jpg', 1),
(4, 'Toyota Corolla', 'GAM1222', 1, 17, 9, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nAir Conditioning: Yes\r\nGPS: Yes\r\nAdditional Features: Bluetooth', 6500, 'IMG-6653d0c42ae733.63190088.jpg', 1),
(5, 'Toyota Prado', 'LAW532', 2, 15, 8, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nSeats: 5\r\nAir Conditioning: Yes\r\nGPS: Yes\r\nAdditional Features: None', 10000, 'IMG-664b3e62c8acb4.33264875.jpg', 1),
(6, 'Suzuki Mehran', 'ASD461', 7, 19, 2, 'Transmission: Automatic\r\nMileage: 30,000 km\r\nFuel Type: Petrol\r\nSeats: 5\r\nAir Conditioning: Yes\r\nGPS: No\r\nAdditional Features: Bluetooth', 5500, 'IMG-664b3b491ceee6.17085770.jpg', 1),
(9, 'Suzuki WagonR', 'QWE123', 11, 14, 9, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nSeats: 5\r\nAir Conditioning: Yes\r\nGPS: Yes\r\nAdditional Features: Bluetooth, Backup Camera, Power Windows', 3500, 'IMG-664b52e4963a07.66981298.jpg', 1),
(14, 'Suzuki WagonR', 'ISL456', 11, 17, 2, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nSeats: 5\r\nAir Conditioning: No\r\nGPS: Yes\r\nAdditional Features: Bluetooth, Backup Camera, Power Windows', 10000, 'IMG-664e2f4a886b10.32166557.jpg', 4),
(15, 'Toyota Corolla', 'BVX567', 1, 14, 9, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nAir Conditioning: Yes\r\nGPS: Yes\r\nAdditional Features: Bluetooth', 4500, 'IMG-664e453f6d0df2.75865297.jpg', 1),
(16, 'Toyota Corolla', 'GAM123', 1, 1, 2, 'Automatic\r\nBluetooth Enabled, 4 Seaters', 7000, 'IMG-6653d0b3be0f45.67457244.jpg', 1),
(17, 'Suzuki Alto', 'GAN223', 11, 16, 12, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nAdditional Features: Bluetooth', 4000, 'IMG-6653d0a4c79de5.92570346.jpg', 4),
(18, 'Toyota Hilux', 'GUJ984', 3, 18, 15, 'Transmission: Automatic\r\nMileage: 30,000 km\r\nFuel Type: Diesel\r\nSeats: 4\r\nAir Conditioning: Yes', 8000, 'IMG-6653d251196061.55264963.jpg', 2),
(19, 'Toyota Corolla', 'GAL326', 1, 16, 11, 'Transmission: Manual\r\nMileage: 25,000 km\r\nFuel Type: Petrol\r\nAir Conditioning: Yes\r\nGPS: Yes', 6000, 'IMG-665d10e0bcaf87.79187677.jpg', 1),
(20, 'Honda Civic', 'CIV199', 1, 4, 8, 'Transmission: Manual\r\nMileage: 20,000 km\r\nGPS: Yes', 5500, 'IMG-665d113c3f88e6.42823368.jpg', 2),
(21, 'Honda Civic', 'CVC621', 1, 5, 12, 'Mileage: 25,000 km\r\nFuel Type: Petrol\r\nAir Conditioning: Yes', 5000, 'IMG-665dac86a44d47.56584836.jpg', 1),
(22, 'Suzuki Mehran', 'MEH166', 7, 3, 9, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nSeats: 4', 3500, 'IMG-665dafa7202521.80540255.jpg', 3),
(23, 'Suzuki Mehran', 'MEH188', 7, 14, 4, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nAir Conditioning: Yes', 3500, 'IMG-665e6052e5e198.31587369.jpg', 1),
(24, 'Toyota Fortuner', 'FRT345', 2, 15, 2, 'Transmission: Automatic\r\nMileage: 35,000 km\r\nFuel Type: Petrol\r\nAir Conditioning: Yes', 8500, 'IMG-665e61802363c2.16404490.jpg', 1),
(25, 'Toyota Hilux', 'ISL166', 3, 3, 9, 'Transmission: Manual\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nAir Conditioning: Yes', 4500, 'IMG-665e617151ba15.30917101.jpg', 1),
(26, 'Toyota Fortuner', 'LAT622', 2, 14, 8, 'Transmission: Automatic\r\nMileage: 20,000 km\r\nFuel Type: Petrol\r\nAir Conditioning: Yes', 9000, 'IMG-665e62350a1429.32988577.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`category_id`, `category_name`) VALUES
(1, 'Sedan'),
(2, 'SUV'),
(3, 'Pickup Truck'),
(7, 'Compact'),
(11, 'Hatchback');

-- --------------------------------------------------------

--
-- Table structure for table `tbllocation`
--

CREATE TABLE `tbllocation` (
  `location_id` int(11) NOT NULL,
  `location_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbllocation`
--

INSERT INTO `tbllocation` (`location_id`, `location_address`) VALUES
(2, 'Main Market, Satellite Town, Gujranwala'),
(4, 'Civil Lines, Near District Courts, Gujranwala'),
(8, 'Alam Chowk, Near Pizza Hut, Gujranwala'),
(9, 'Wapda Town, Near Wapda Office, Gujranwala'),
(10, '55-C, Faisal Town, Near Akbar Chowk, Lahore'),
(11, '22-A, PIA Housing Scheme, Lahore, Punjab'),
(12, 'Main Jail Road, Opposite Services Hospital, Lahore'),
(13, 'Shadman Market, Shadman, Lahore'),
(15, 'Main Boulevard, DHA Phase 1, Lahore');

-- --------------------------------------------------------

--
-- Table structure for table `tblowner`
--

CREATE TABLE `tblowner` (
  `owner_id` int(11) NOT NULL,
  `owner_name` varchar(50) NOT NULL,
  `owner_email` varchar(50) NOT NULL,
  `owner_contact` varchar(20) NOT NULL,
  `commission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblowner`
--

INSERT INTO `tblowner` (`owner_id`, `owner_name`, `owner_email`, `owner_contact`, `commission`) VALUES
(1, 'Ali Khan', 'alikhan@gmail.com', '03001234567', 25000),
(3, 'Ahmed Ali', 'ahmedali@gmail.com', '03411233333', 21000),
(4, 'Amir Khan', 'amirkhan@gmail.com', '03171234567', 41500),
(5, 'Fahad Afzal', 'fahadafzal@gmail.com', '03081234567', 35000),
(14, 'Zain Malik', 'zainzain@gmail.com', '02147483647', 50000),
(15, 'Saad Khan', 'saad.khan@gmail.com', '03001234567', 35000),
(16, 'Fatima Javed', 'fatima.javed@gmail.com', '03019876543', 40000),
(17, 'Ahmed Raza', 'ahmed.raza@gmail.com', '03211234567', 45000),
(18, 'Mariam Aurangzeb', 'mariam@gmail.com', '03451234567', 30000),
(19, 'Usman Butt', 'usman.butt@gmail.com', '03331234567', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `tblrental`
--

CREATE TABLE `tblrental` (
  `rental_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `total_rental_price` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `rental_date` date NOT NULL,
  `return_date` date NOT NULL,
  `payment_details` text NOT NULL,
  `rental_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblrental`
--

INSERT INTO `tblrental` (`rental_id`, `user_id`, `car_id`, `total_rental_price`, `reservation_date`, `rental_date`, `return_date`, `payment_details`, `rental_status`) VALUES
(2, 4, 2, 5500, '2024-05-01', '2024-05-01', '2024-05-02', 'Transaction ID:T20240523031357\r\nReference No:240523751923\r\nPayment Method:MWALLET', 3),
(14, 3, 6, 3500, '2024-05-07', '2024-05-07', '2024-05-08', 'Transaction ID:T20240523030357\nReference No:240523753923\nPayment Method:MWALLET\n', 3),
(16, 4, 9, 3500, '2024-05-23', '2024-05-23', '2024-05-24', 'Transaction ID:T20240523031017\nReference No:240523753924\nPayment Method:MWALLET\n', 3),
(21, 5, 6, 16500, '2024-05-23', '2024-05-31', '2024-06-03', 'Transaction ID:T20240523032922\nReference No:240523753926\nPayment Method:MWALLET\n', 3),
(22, 9, 9, 7000, '2024-05-23', '2024-05-23', '2024-05-25', 'Transaction ID:T20240523034144\nReference No:240523753927\nPayment Method:MWALLET\n', 3),
(23, 13, 15, 7000, '2024-05-23', '2024-05-23', '2024-05-25', 'Transaction ID:T20240523104633\nReference No:240523753951\nPayment Method:MWALLET\n', 3),
(25, 12, 9, 10500, '2024-05-23', '2024-05-24', '2024-05-27', 'Transaction ID:T20240524022037\nReference No:240524755930\nPayment Method:MWALLET\n', 3),
(26, 12, 9, 10500, '2024-05-23', '2024-05-24', '2024-05-27', 'Transaction ID:T20240524024200\nReference No:240524755933\nPayment Method:MWALLET\n', 3),
(28, 3, 9, 7000, '2024-05-24', '2024-05-24', '2024-05-26', 'Transaction ID:T20240524051112\nReference No:240524755945\nPayment Method:MWALLET\n', 3),
(30, 2, 4, 6500, '2024-05-26', '2024-05-26', '2024-05-27', 'Transaction ID:T20240526074302\nReference No:240526759883\nPayment Method:MWALLET\n', 3),
(32, 1, 4, 13000, '2024-05-26', '2024-05-26', '2024-05-28', 'Transaction ID:T20240526074828\nReference No:240526759885\nPayment Method:MWALLET\n', 3),
(33, 13, 4, 13000, '2024-05-26', '2024-05-26', '2024-05-28', 'Transaction ID:T20240526074912\nReference No:240526759886\nPayment Method:MWALLET\n', 3),
(35, 5, 4, 6500, '2024-05-26', '2024-05-26', '2024-05-27', 'Transaction ID:T20240526080055\nReference No:240526759888\nPayment Method:MWALLET\n', 3),
(37, 1, 15, 13500, '2024-05-27', '2024-05-29', '2024-06-01', 'Transaction ID:T20240527053803\nReference No:240527763882\nPayment Method:MWALLET\n', 3),
(43, 12, 2, 5000, '2024-05-28', '2024-05-28', '2024-05-29', 'Transaction ID:T20240528041309\nReference No:240528764232\nPayment Method:MWALLET\n', 3),
(46, 1, 5, 30000, '2024-05-29', '2024-05-29', '2024-06-01', 'Transaction ID:T20240529030747\nReference No:240529765915\nPayment Method:MWALLET\n', 3),
(47, 12, 18, 16000, '2024-05-29', '2024-06-05', '2024-06-07', 'Transaction ID:T20240529033620\nReference No:240529765916\nPayment Method:MWALLET\n', 3),
(49, 1, 5, 30000, '2024-05-29', '2024-05-29', '2024-06-01', 'Transaction ID:T20240529114644\nReference No:240529765961\nPayment Method:MWALLET\n', 3),
(50, 13, 6, 11000, '2024-05-29', '2024-05-29', '2024-05-31', 'Transaction ID:T20240529120705\nReference No:240529765968\nPayment Method:MWALLET\n', 3),
(52, 13, 17, 12000, '2024-05-31', '2024-05-31', '2024-06-03', 'Transaction ID:T20240531054150\nReference No:240531767894\nPayment Method:MWALLET\n', 3),
(55, 9, 6, 5500, '2024-05-31', '2024-06-04', '2024-06-05', 'Transaction ID:T20240531054434\nReference No:240531767896\nPayment Method:MWALLET\n', 3),
(60, 1, 14, 10000, '2024-05-31', '2024-05-31', '2024-06-01', 'Transaction ID:T20240531060644\nReference No:240531767900\nPayment Method:MWALLET\n', 2),
(67, 1, 16, 7000, '2024-05-31', '2024-05-31', '2024-06-01', 'Transaction ID:T20240531063501\nReference No:240531767907\nPayment Method:MWALLET\n', 3),
(68, 5, 16, 7000, '2024-05-31', '2024-05-31', '2024-06-01', 'Transaction ID:T20240531063540\nReference No:240531767908\nPayment Method:MWALLET\n', 3),
(71, 12, 17, 4000, '2024-05-31', '2024-05-31', '2024-06-01', 'Transaction ID:T20240531064317\nReference No:240531767910\nPayment Method:MWALLET\n', 2),
(72, 13, 16, 14000, '2024-06-03', '2024-06-13', '2024-06-15', 'Transaction ID:T20240603160523\nReference No:240603778030\nPayment Method:MWALLET\n', 3),
(73, 12, 19, 20000, '2024-06-03', '2024-06-14', '2024-06-16', 'Transaction ID:T20240603162954\nReference No:240603778043\nPayment Method:MWALLET\n', 3),
(74, 13, 22, 7000, '2024-06-03', '2024-06-10', '2024-06-12', 'Transaction ID:T20240603171206\nReference No:240603778047\nPayment Method:MWALLET\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_contact` varchar(20) NOT NULL,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`user_id`, `username`, `user_email`, `user_contact`, `user_password`) VALUES
(1, 'Ali Hassan', 'alihassan@gmail.com', '03338453689', '202cb962ac59075b964b07152d234b70'),
(2, 'Fatima Ahmed', 'fatimaahmed@yahoo.com', '03331234567', '202cb962ac59075b964b07152d234b70'),
(3, 'Ahmed Khan', 'ahmedkhan@yahoo.com', '03411234567', '202cb962ac59075b964b07152d234b70'),
(4, 'Sara Ali', 'sarahali@gmail.com', '03171234567', '202cb962ac59075b964b07152d234b70'),
(5, 'Amir Malik', 'amirmalik@gmail.com', '03338453666', '202cb962ac59075b964b07152d234b70'),
(9, 'Demo Name', 'demo@gmail.com', '02147483647', '202cb962ac59075b964b07152d234b70'),
(12, 'Talha Butt', 'talhabsit@gmail.com', '03123456789', '81dc9bdb52d04dc20036dbd8313ed055'),
(13, 'Talha Younas', 'talhayounas@gmail.com', '03123456789', '202cb962ac59075b964b07152d234b70');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tblcar`
--
ALTER TABLE `tblcar`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `CarToCategory` (`category_id`),
  ADD KEY `CarToOwner` (`owner_id`),
  ADD KEY `CarToLocation` (`location_id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbllocation`
--
ALTER TABLE `tbllocation`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `tblowner`
--
ALTER TABLE `tblowner`
  ADD PRIMARY KEY (`owner_id`);

--
-- Indexes for table `tblrental`
--
ALTER TABLE `tblrental`
  ADD PRIMARY KEY (`rental_id`),
  ADD KEY `CarForRent` (`car_id`),
  ADD KEY `UserRent` (`user_id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcar`
--
ALTER TABLE `tblcar`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbllocation`
--
ALTER TABLE `tbllocation`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tblowner`
--
ALTER TABLE `tblowner`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tblrental`
--
ALTER TABLE `tblrental`
  MODIFY `rental_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcar`
--
ALTER TABLE `tblcar`
  ADD CONSTRAINT `CarToCategory` FOREIGN KEY (`category_id`) REFERENCES `tblcategory` (`category_id`),
  ADD CONSTRAINT `CarToLocation` FOREIGN KEY (`location_id`) REFERENCES `tbllocation` (`location_id`),
  ADD CONSTRAINT `CarToOwner` FOREIGN KEY (`owner_id`) REFERENCES `tblowner` (`owner_id`);

--
-- Constraints for table `tblrental`
--
ALTER TABLE `tblrental`
  ADD CONSTRAINT `CarForRent` FOREIGN KEY (`car_id`) REFERENCES `tblcar` (`car_id`),
  ADD CONSTRAINT `UserRent` FOREIGN KEY (`user_id`) REFERENCES `tblusers` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
