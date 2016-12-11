-- phpMyAdmin SQL Dump
-- version 4.6.5.1deb3+deb.cihar.com~xenial.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 11, 2016 at 11:40 PM
-- Server version: 5.7.16-0ubuntu0.16.04.1
-- PHP Version: 7.0.8-0ubuntu0.16.04.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internet_shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Admins`
--

CREATE TABLE `Admins` (
  `id` int(11) NOT NULL,
  `admin_name` varchar(25) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hashed_password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `Admins`
--

INSERT INTO `Admins` (`id`, `admin_name`, `email`, `hashed_password`) VALUES
(1, 'michal', 'michal@gmail.com', '$2y$10$grs.66vbwTiqgErPt8yRx.ZFWz0p3ExHElchyZ2MpjUieQluv//mm');

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE `Categories` (
  `id` int(11) NOT NULL,
  `text` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`id`, `text`) VALUES
(1, 'Batony'),
(5, 'Cukierki'),
(6, 'Czekolady'),
(7, 'Żelki, fasolki, gumy'),
(8, 'Ciastka');

-- --------------------------------------------------------

--
-- Table structure for table `Images`
--

CREATE TABLE `Images` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `Items`
--

CREATE TABLE `Items` (
  `id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `Items`
--

INSERT INTO `Items` (`id`, `item_name`, `description`, `price`, `stock_quantity`, `category_id`) VALUES
(4, 'Milky Way Midnight Night', 'Ta odmiana Milky Waya w połączeniu z ciemną czekoladą sprawia, że odkrywamy go na nowo.', '6.99', 1000, 1),
(5, 'Big Hunk', 'Bardzo nietypowy baton do...żucia. Ciągnący nugat i orzeszki to cała tajemnica Big Hunk\'a.', '5.99', 1000, 1),
(6, 'Butterfinger Mini', 'Wersja mini batonika z masła orzechowego oraz kandyzowanego cukru, który powoduje jego specyficzny smak i chrupkość. Do tego oblany mleczną czekoladą. Jeden z najbardziej popularnych batonów w USA.', '1.99', 10000, 1),
(7, 'Reese\'s White Peanut Butter Cups', 'Dwie przepyszne babeczki z białej czekolady Hershey\'s maksymalnie wypełnione masłem orzechowym. Nie można przejść obok obojętnie.\\r\\n', '6.99', 100, 1),
(8, 'Rocky Road Mint', 'Doskonały, miętowy marshmallow oblany ręcznie robianą ciemną czekoladą, posypany prażonymi orzechami nerkowca - coś pysznego!', '4.59', 200, 1),
(9, 'Hershey\'s Milk Chocolate Giant', 'Klasyczna czekolada Hershey\'s, która podbiła czekoladowy rynek swoim niepowtarzalnym smakiem.', '20.99', 100, 6),
(10, 'Harry Potter Chocolate Frog', 'Czekoladowa żaba z chrupkami ryżowymi. Dobrze znana z filmu o Harrym Potterze i tak jak filmowa zawiera kartę czarodzieja!', '18.99', 100, 6),
(11, 'Hershey\'s Cookies\'n\'Creme Giant', 'Duża, rozpływająca się, biała czekolada z kawałkami ciastek jak Oreo. Czego chcieć więcej?', '19.99', 300, 6),
(12, 'Mike & Ike Berry Blast', 'Miękkie cukierki do żucia czy gryzienia o leśnych smakach: truskawki, jeżyny, jagody, brzoskwini oraz dzikiej jagody. Klasyk w USA.', '5.99', 500, 5),
(13, 'Hot Tamales Tropical Heat', 'Tropikalne wydanie ostrych cukierków do żucia. 3 smaki do okiełznania: paląca limonka, pikantny ananas oraz zmysłowe mango.', '9.99', 150, 5),
(14, 'Wonk Nerds - Peach & Wild Berry', 'Bardzo wyraziste w smaku, lekko kwaśne i soczyste cukierki o smaku brzoskwini i jagody. Czegoś tak dobrego nie spotkasz w żadnym sklepie. Pozycja obowiązkowa!', '5.99', 348, 5),
(15, 'Jelly Belly Bean Boozled', 'Szalone fasolki Jelly Belly wszystkich smakow zaskoczą każdego. Spotkasz tu fasolkę o smaku psiej karmy, zgniłego jaja (one naprawdę tak smakują!) albo o soczystej brzoskwini. Wariacji jest wiele, a kolory złych i tych dobrych są jednakowe.', '17.99', 500, 7),
(16, 'Harry Potter Bertie Bott\'s', 'Fasolki wszystkich smaków od Harrego Pottera. Znajdziesz tutaj fasolkę o smaku mydła, dżdżownicy, pianek marshmallow oraz wiele innych. Wrażenia gwarantowane!', '15.49', 300, 7),
(17, 'LifeSavers Gummies Wild Berries', 'Bardzo owocowe i soczyste żelki w kształcie krążków o 5 leśnych smakach: maliny, truskawki, winogrona, jeżyny i wiśni.', '16.99', 100, 7),
(18, 'Razzles Original', 'Najpierw jest twardy, pudrowy cukierek, ktory następnie zmienia się w gumę balonową. Niezywkłe połączenie o bogatym smaku: cytryny, maliny, winogrona, jagody i pomarańczy.', '5.50', 100, 7),
(19, 'Oreo Heads or Tails Double Stuff', 'Ciasteczka Oreo z podwójnym śmietankowym nadzieniem.', '17.99', 1000, 8),
(20, 'Pop Tarts Cinnamon Rolls', 'Czekoladowe ciastka Pop Tarts z cynamonowym nadzieniem.', '25.99', 100, 8),
(21, 'Hello Panda Double Choco', 'Delikatne, czekoladowe poduszeczki z wizerunkiem pandy uprawiającej różne sporty z czekoladowym nadzieniem w środku. Takie rzeczy mogą być tylko z Azji :)', '6.99', 750, 8);

-- --------------------------------------------------------

--
-- Table structure for table `Items_Orders`
--

CREATE TABLE `Items_Orders` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `Items_Orders`
--

INSERT INTO `Items_Orders` (`id`, `item_id`, `order_id`, `quantity`) VALUES
(3, 6, 21, 1),
(4, 13, 21, 5),
(5, 18, 21, 3),
(6, 10, 23, 1),
(7, 12, 23, 1),
(8, 17, 23, 3),
(9, 14, 24, 3),
(10, 16, 24, 1),
(11, 20, 24, 1),
(12, 15, 25, 1),
(13, 19, 25, 10),
(14, 11, 26, 3),
(15, 18, 26, 15),
(16, 9, 26, 5);

-- --------------------------------------------------------

--
-- Table structure for table `Messages`
--

CREATE TABLE `Messages` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_text` mediumtext NOT NULL,
  `creation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `Messages`
--

INSERT INTO `Messages` (`id`, `admin_id`, `user_id`, `message_text`, `creation_date`) VALUES
(1, 1, 1, 'płatność otrzymana, zamówienie zostanie wkrótce wyspłane', '2016-12-11 23:11:13'),
(2, 1, 2, 'potwierdzam zamówienie. Oczekujemy na płatność', '2016-12-11 23:11:53'),
(3, 1, 3, 'potwierdzam zamówienie. Oczekujemy na płatność', '2016-12-11 23:12:04'),
(4, 1, 4, 'potwierdzam zamówienie. Oczekujemy na płatność', '2016-12-11 23:12:25'),
(5, 1, 4, 'płatność otrzymana, zamówienie zostanie wkrótce wyspłane', '2016-12-11 23:13:19');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`id`, `user_id`, `status_id`) VALUES
(21, 1, 2),
(23, 2, 1),
(24, 3, 1),
(25, 4, 2),
(26, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Status`
--

CREATE TABLE `Status` (
  `id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `Status`
--

INSERT INTO `Status` (`id`, `text`) VALUES
(1, 'do zaplaty'),
(2, 'oczekuje na realizacje'),
(3, 'wyslane');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(140) NOT NULL,
  `last_name` varchar(140) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hashed_password` varchar(60) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `first_name`, `last_name`, `email`, `hashed_password`, `address`) VALUES
(1, 'Aleksandra', 'Ignasiak', 'ola@email.com', '$2y$10$61pjjpnqCNeY48qSOZ9ZOuzKZqNn0pK2sRBNGVVlhoS87gUvMcaY6', 'Fiołkowa 13a/4, Warszawa'),
(2, 'pawel', 'nowak', 'pawel@email.com', '$2y$10$GQaB.LwIwBJu7gtsPGu0tO0NSxahw3JPEI4cPut5ntYyrznos6mHa', 'Wiśniowa 3, Wałbrzych'),
(3, 'Karol', 'Kwiatkowski', 'karol@email.com', '$2y$10$CW4AL8NnjKaWUStXTiwxr.c4VvCAEA/W7pIHNRMLKMsdArHf6q.Eq', 'Spacerowa 8, Gdańsk'),
(4, 'Ignacy', 'Rzepecki', 'ignacy@email.com', '$2y$10$cVpDz2/in3FjssuvpOAHKOO/c7bK2Aa0adkPFgSDX/.uHmsv9v316', 'Kryształowa 9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Admins`
--
ALTER TABLE `Admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_name` (`admin_name`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Images`
--
ALTER TABLE `Images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `Items`
--
ALTER TABLE `Items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item_name` (`item_name`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `Items_Orders`
--
ALTER TABLE `Items_Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `Messages`
--
ALTER TABLE `Messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `Status`
--
ALTER TABLE `Status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Admins`
--
ALTER TABLE `Admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `Images`
--
ALTER TABLE `Images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Items`
--
ALTER TABLE `Items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `Items_Orders`
--
ALTER TABLE `Items_Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `Messages`
--
ALTER TABLE `Messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `Status`
--
ALTER TABLE `Status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Images`
--
ALTER TABLE `Images`
  ADD CONSTRAINT `Images_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `Items` (`id`);

--
-- Constraints for table `Items`
--
ALTER TABLE `Items`
  ADD CONSTRAINT `Items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`id`);

--
-- Constraints for table `Items_Orders`
--
ALTER TABLE `Items_Orders`
  ADD CONSTRAINT `Items_Orders_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `Items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Items_Orders_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `Orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `Admins` (`id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `Orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Orders_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `Status` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
