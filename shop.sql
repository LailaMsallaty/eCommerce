-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2020 at 05:30 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `card_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `member_name` varchar(255) NOT NULL,
  `member_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `card`
--

INSERT INTO `card` (`card_id`, `item_id`, `member_name`, `member_id`, `quantity`) VALUES
(11, 47, 'laila', 1, 1),
(12, 21, 'lujain', 61, 1),
(13, 54, 'lujain', 61, 2),
(14, 45, 'laila', 1, 2),
(15, 55, 'JOUD', 59, 1),
(16, 20, 'JOUD', 59, 1),
(17, 19, 'laila', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `ar_Name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `ar_Name`) VALUES
(12, 'Hand Made', 'Hand Made Items', 0, 1, 'أشغال يدوية'),
(13, 'Computers', 'Computer Item', 0, 2, 'حواسيب'),
(14, 'Cell Phones', 'Cell Phones ', 0, 3, 'هواتف خلوية'),
(15, 'Clothing', 'Clothin And Fashion', 0, 4, 'ألبسة'),
(16, 'Home crystals', 'Home Glasses', 0, 5, 'بلور منزلي'),
(17, 'Nokia', 'Nokia phones', 14, 1, ' نوكيا'),
(18, 'Blackberry', 'Blackberry Phones', 14, 2, 'هواتف بلاك بيري'),
(19, 'Boxes', 'boxes hand made', 12, 3, 'صناديق'),
(21, 'Electronics ', 'very good Electronies', 0, 4, 'إلكترونيات'),
(22, 'Games', 'Good  game', 0, 4, 'ألعاب'),
(24, 'www', 'samsong B20 3D -in Wireless Bluetooth - Black & Grey', 15, 2, 'fg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(3, 'Very Good ', 1, '2019-10-02', 20, 61),
(4, 'nice', 1, '2020-09-17', 19, 61),
(5, 'good', 1, '2020-09-22', 55, 1),
(6, 'perfect', 1, '2020-09-22', 50, 1),
(7, 'Omg!! Beautiful', 1, '2020-09-22', 48, 59),
(8, 'I love it', 1, '2020-09-22', 20, 59);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` varchar(255) NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `item_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Status`, `Approve`, `Cat_ID`, `Member_ID`, `tags`, `quantity`, `item_photo`) VALUES
(18, 'Apple iMac 21.5in', 'Core i5 , 8GB Memory, 1TB Hard Drive', '5000', '2019-09-27 18:02:16', 'USA', '1', 1, 13, 1, 'Computer , Discount', 0, '493261165__hero_SQ_1LW4045927-1-625cb1ba7a894cc38db8565dd81072b3.jpg'),
(19, ' A50', 'Samsung Galaxy A50', '600000', '2019-09-27 18:07:49', 'korea', '1', 1, 14, 61, ' Discount ', 3, '701031690_samsung-galaxy-a50-dual-sim-en-negro-de-128gb-y-4gb-ram-perfil.jpg'),
(20, 'Shoes', 'Special shoes for a wedding party\r\n', '100', '2019-09-27 18:18:03', 'Europe', '1', 1, 15, 1, 'Shoes', 2, '688470235_61rRaMUqaEL._SY395._SX._UX._SY._UY_.jpg'),
(21, 'HeadPhone', 'ZEALOT B20 3D -in Wireless Bluetooth - Grey', '150', '2019-09-27 18:24:46', 'USA', '1', 1, 21, 1, 'Guarantee', 6, '1646708899_01c49128-3410-49b5-85be-25ca49075618.png'),
(43, 'computer', 'Computer with high specifications\r\n', '4000', '2020-07-08 03:13:33', 'syria', '1', 1, 21, 59, '', 2, '840158426_71pheYd9W0L._SX466_.jpg'),
(45, 'CampMug', 'Nice camping pitcher\r\n', '4000', '2020-09-15 00:49:29', 'syria', '2', 1, 16, 61, ' Discount ', 6, '1903745123_campmug-2.png'),
(47, 'watch', 'Elegant gold watch\r\n', '4000', '2020-09-15 01:12:48', 'syria', '2', 1, 15, 59, ' Discount ', 5, '27491014_xsincelo-watch.png.pagespeed.ic.qdXjs_x6c3.png'),
(48, 'Wooden game', 'Very entertaining game\r\n', '4000', '2020-09-16 18:33:11', 'syria', '3', 1, 22, 61, 'Guarantee', 4, '511231331_HTB16hilr1GSBuNjSspbq6AiipXaL.jpg'),
(50, ' A10', 'samsong - Black', '4000', '2020-09-16 18:53:16', 'syria', '1', 1, 14, 59, ' Discount ', 5, '814498049_570-5709160_samsung-a10-price-in-namibia-hd-png-download.png'),
(54, 'blouse', 'Summer white blouse decorated with flowers\r\n', '4000', '2020-09-18 19:33:45', 'syria', '1', 1, 15, 59, ' Discount ', 4, '2123072271_a89ffdc564b17a39eb01f65791d16d16.png'),
(55, 'Thermos kit', 'A glass of high-purity rosaline to preserve the flavor of your tea or coffee for longer hours', '400000', '2020-09-18 19:49:40', 'syria', '1', 1, 16, 61, 'Guarantee', 6, '1591718823_طقم-ثلاجة-خزامى-كروم-ابيض-.jpg'),
(56, 'Food utensils', 'More than 100 dinnerware is designed to complement every table.\r\n', '200000', '2020-09-18 20:00:11', 'USA', '1', 1, 12, 1, ' Discount ', 150, '1109507544_Dinnerware-masonry-aprile-2019-final-gallery-img-2019-04-24-08-48-44.jpg'),
(59, 'Wooden game', 'Includes a velvet bag to protect the ordered jewelry	', '200000', '2020-09-22 09:58:37', 'syria', '1', 0, 19, 61, ' Discount ', 2, '176928196_cutiu-a-din-lemn-brelso-gravogifts-4540176203869_540x.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'to identify user',
  `Username` varchar(255) NOT NULL COMMENT 'Username to login',
  `Password` varchar(255) NOT NULL COMMENT 'password to login',
  `Email` varchar(255) CHARACTER SET utf32 NOT NULL,
  `FullName` varchar(255) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0' COMMENT 'Identify user Group',
  `RegStatus` int(11) NOT NULL DEFAULT '0' COMMENT 'User Approval',
  `Date` date NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '385-3856300_no-avatar-png.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'laila', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'lailamsallaty607@gmail.com', 'Laila Msallaty', 1, 1, '0000-00-00', '151696564_photo_2020-09-18_18-47-22.jpg'),
(2, 'Amar', '601f1889667efaebb33b8c12572835da3f027f78', 'Amar@gmail.com', 'Amar ', 1, 1, '0000-00-00', '1653080154_—Pngtree—freelancer_3633969.png'),
(44, 'Hend', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'hend@gmail.com', 'Hend Hmedany', 0, 1, '2019-09-21', '1076688493_0d1cfff9d7c39fe3c4f5c67035e11334.jpg'),
(52, 'Ahmad', '601f1889667efaebb33b8c12572835da3f027f78', 'Ahmad@gmail.com', 'Ahmad ', 0, 1, '2019-09-22', 'images (4).jpg'),
(54, 'Kawkab', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'Kawkab@gmail.com', 'Kawkab jeje', 0, 1, '2019-09-22', '373518290_Medical-School-Personal-Statement-Guide.jpg'),
(59, 'Joud', '20eabe5d64b0e216796e834f52d61fd0b70332fc', 'joud@gmail.com', 'Joud Almuhammad', 1, 1, '2019-09-23', '1073616124_images (1).jpg'),
(60, 'Shahed', '7c222fb2927d828af22f592134e8932480637c0d', 'shahed@gmail.com', 'Shahed ', 0, 1, '2019-10-01', '751041594_tmp_Dlvl6H_b33e8a79f54238ab_GettyImages-942347602.jpg'),
(61, 'Lujain', '7c222fb2927d828af22f592134e8932480637c0d', 'july@gmail.com', 'Lujain Alnaser', 1, 1, '2019-10-01', '1330119138_photo_2020-09-21_20-49-25.jpg'),
(66, 'ola ', '20eabe5d64b0e216796e834f52d61fd0b70332fc', 'ola@gmail.com', 'ola', 0, 0, '2020-09-21', '385-3856300_no-avatar-png.png'),
(67, 'karem', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'karem@gmail.com', 'karem', 0, 1, '2020-09-22', '385-3856300_no-avatar-png.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`card_id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `card`
--
ALTER TABLE `card`
  MODIFY `card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identify user', AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `card_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`),
  ADD CONSTRAINT `card_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
