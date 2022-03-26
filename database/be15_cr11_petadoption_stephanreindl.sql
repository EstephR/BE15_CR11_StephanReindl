-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 26, 2022 at 01:04 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `be15_cr11_petadoption_stephanreindl`
--
CREATE DATABASE IF NOT EXISTS `be15_cr11_petadoption_stephanreindl` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `be15_cr11_petadoption_stephanreindl`;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `gender` varchar(6) NOT NULL,
  `breed` varchar(80) NOT NULL,
  `size` varchar(15) NOT NULL,
  `age` tinyint(3) NOT NULL,
  `vaccine` varchar(3) NOT NULL,
  `description` varchar(100) NOT NULL,
  `hobbies` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `picture` varchar(256) NOT NULL,
  `status` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `gender`, `breed`, `size`, `age`, `vaccine`, `description`, `hobbies`, `location`, `picture`, `status`) VALUES
(1, 'Vincent Van Goat', 'male', 'goat', 'default', 4, 'def', 'shy, yet lovely', 'hiking, skating', 'Goatland', 'vincentVanGoat.jpg', 'available'),
(3, 'Michael J. Fox', 'male', 'fox', 'small', 5, 'Yes', 'quick and agile', 'hunting, making Business', 'Sherwood Forest', 'michaelJFox.jpg', 'available'),
(4, 'El Duderrhino', 'male', 'rhino', 'big', 25, 'No', 'calm and sluggish', 'making trouble', 'Savanna', 'elDuderhino.jpg', 'adopted'),
(5, 'Cleocatra', 'female', 'cat', 'small', 3, 'Yes', 'powerful yet sensitive', 'leading kingdoms, bathing in milk', 'Ancient Egypt', 'cleocatra.jpg', 'available'),
(6, 'Furrnando Cortez', 'male', 'cat', 'small', 6, 'No', 'sometimes little corrupt', 'gambling, cuddling', 'Spain', 'furrnandoCortez.jpg', 'available'),
(7, 'Space Cat-et', 'female', 'cat', 'small', 4, 'Yes', 'adventurous, fearless', 'travelling on warp speed', 'Outer Space', 'spacecatet2.jpg', 'available'),
(8, 'Sherlock Bones', 'male', 'dog', 'big', 13, 'Yes', 'polite yet intrusive', 'observing, snuffling', 'UK', 'sherlockBones.jpg', 'available'),
(9, 'Lord Thunderwoof', 'male', 'dog', 'small', 7, 'No', 'pretentious but loyal', 'shopping, beeing hipsterish', 'Manhattan', 'lordThunderwoof.jpg', 'available'),
(10, 'Barky Boy', 'male', 'dog', 'small', 2, 'No', 'anxious but has a big heart', 'painting, arts', 'San Francisco', 'barkyBoy.jpg', 'available'),
(11, 'Doggo Escobar', 'male', 'dog', 'medium', 12, 'No', 'self confident and deceitful', 'drug dealing, walking on the beach', 'Colombia', 'doggoEscobar.jpg', 'available'),
(13, 'Patrick Layzee', 'male', 'sloth', 'medium', 12, 'No', 'good sleeper', 'philosophizing, sleeping', 'Treehouse', '623ef75815591.jpg', 'available');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) NOT NULL,
  `fk_animal_id` int(11) NOT NULL,
  `adoption_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pet_adoption`
--

INSERT INTO `pet_adoption` (`id`, `fk_user_id`, `fk_animal_id`, `adoption_date`) VALUES
(21, 4, 4, '2022-03-26');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(80) NOT NULL,
  `lname` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `phone` varchar(80) NOT NULL,
  `address` varchar(150) NOT NULL,
  `picture` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `email`, `phone`, `address`, `picture`, `password`, `status`) VALUES
(1, 'Bruce', 'Springsteen', 'bruce.springsteen@admin.com', '0660/23292935', 'White Alley 3, 12000 Los Angeles', '623db43e45494.jpg', 'd2954655e29b2688385ee3f733b470078f0945414056c375e7ed34dcb77a35ad', 'adm'),
(2, 'Amy', 'Winehouse', 'amy.winehouse@heaven.com', '04420/23432423', 'Rest in Peace Street 2, 12035 Sky Garden', '623db4b68a4b5.jpg', '15caede92b79cca70dc66f06714ca5e20ef9d2d20fdd169cde3cb4a3d6b2d691', 'user'),
(3, 'Brant', 'Bjork', 'brant.bjork@kyuss.com', '03434/23410343', 'Rancho de la Luna 1, 12310 Palm Desert', '623db56e3976e.jpg', '69337bf2be18b86bd61c126a5744e22625b6c2b8070f98250d90c6f2222e124e', 'user'),
(4, 'Dave', 'Grohl', 'dave@foofighters.com', '23432/123103456', 'Downtown Alley 101, 123210 Las Vegas', '623db5b998e29.jpg', 'ba3a2237a907ebacd02fdf3962a31655e44d2f32d586d602a5771f7eaedc4601', 'user'),
(5, 'Jack', 'White', 'jack.white@thewhitestripes.com', '234324/2342064', 'Lazaretto 125, 120535 Pasadena', '623db6666221b.jpg', '9e52061cdc7e37936d61695d35cc74ea8b127551ea2f087ae2fe7f5e1bae5e5a', 'user'),
(6, 'Jimi', 'Hendrix', 'jimi.hendrix@hell.com', '23443/8987688', 'Along the Watchtower 11, 123305 Sky Garden', '623db6bcd3e76.jpg', '67e0f6c50d58f0420f424d623d706590581c6b2c7e70a68129ee51693e86d53f', 'user'),
(7, 'Kurt', 'Cobain', 'kurt.cobain@nirvana.com', '7564/23493653', 'Not there anymore 666, 94847 Nirvana', '623db6f03dd00.jpg', '7ef562b8ef3bc3225f7caae510ec1c4ffa2028136f8ec07de73ab26ca7589649', 'user'),
(8, 'Nick', 'Cave', 'nick.cave@thebadseeds.com', '85685/234093234', 'Sunshine Boulevard 39, 23945 Brisbane', '623db72dbc6b9.jpg', '9d7ef4e69573a80092df243dd41f451a99c480cf937051236b2364a13d6af1cd', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_animal_id` (`fk_animal_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`fk_animal_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
