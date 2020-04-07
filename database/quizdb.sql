-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2020 at 10:35 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `quiz_details`
--

CREATE TABLE `quiz_details` (
  `id` int(11) NOT NULL,
  `title` varchar(80) NOT NULL,
  `category` varchar(80) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quiz_details`
--

INSERT INTO `quiz_details` (`id`, `title`, `category`, `description`, `image`) VALUES
(1, 'Movie stars trivia', 'Actors/Actresses', 'See how good you know the facts about different actors and actresses', 'assets/img/actors.jpg'),
(2, 'Test your culture knowledge', 'Culture', 'The best way to determine your culture level - is to pass this quiz!', 'assets/img/culture.jpg'),
(3, 'Movie/TV Trivia', 'Movies/TV', 'Do you consider yourself a cinema expert? Let\'s see how good you are!', 'assets/img/movies.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_questions`
--

CREATE TABLE `quiz_questions` (
  `id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `wrong_answers` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_questions`
--

INSERT INTO `quiz_questions` (`id`, `quiz_id`, `question`, `correct_answer`, `wrong_answers`) VALUES
(1, 1, 'Despite his breathtakingness, he is often seen sad and completely alone on the streets.', 'Keanu Reeves', 'Anthony Hopkins::Joaquin Phoenix::Nicolas Cage'),
(2, 1, '\r\nWhich star of Fight Club and Requiem for a Dream is also a lead singer of an American band 30 Seconds to Mars?', 'Jared Leto', 'Matt Bellamy::Caleb Followill::Nicolas Cage'),
(3, 1, '\r\nWhich actor played the famous hobbit - Frodo?', 'Elijah Wood', 'Daniel Radcliffe::Jake Gyllenhaal::Nicolas Cage'),
(4, 1, '\r\nWhich actor played the role of a Russian boxer, Ivan Drago, in Rocky 4', 'Dolph Lundgren', 'Jason Statham::Arnold Schwarzenegger::Nicolas Cage'),
(5, 1, '\r\nWhich actor played James Bond in 1990?', 'Pierce Brosnan\r\n', 'Sean Connery::Daniel Craig::Nicolas Cage'),
(7, 2, '\r\nWhat is the Kabbalah?', 'A System of Jewish mystical beliefs', 'A Mortal Kombat character::A jewish word for gambler::An exotic dish'),
(8, 2, '\r\nWho painted the ceiling of the Sistine Chapel?', 'Michelangelo', 'Donatello::Raphael::Leonardo'),
(9, 2, '\r\nIn which city is the famous Manneken Pis fountain?', 'Brussels', 'Paris::Amsterdam::Sydney'),
(10, 2, '\r\nWho is the inventor of photography?', 'Louis Daguerre', 'Thomas Edison::Nikola Tesla::Steve Jobs'),
(11, 2, '\r\nIn which city did Romeo and Juliet live?', 'Verona\r\n', 'London::Birmingham::Montreal'),
(12, 3, '\r\nWhat is the name of the bald commander of the Enterprise in Star Trek?', 'Captain Picard', 'Spock::James T. Kirk::Leonard McCoy'),
(13, 3, '\r\nWhat is the profession of Popeye?', 'Seaman', 'Janitor::Life coach::Software developer'),
(14, 3, '\r\nWho is the director of Reservoir Dogs?', 'Quentin Tarantino', 'Robert Rodriguez::Guy Ritchie::Christopher Nolan'),
(15, 3, '\r\nWho is the protagonist in the Last Action Hero film?', 'Arnold Schwarzenegger', 'Sylvester Stallone::Jean-Claude Van Damme::Nicolas Cage'),
(16, 3, '\r\nWhat is a common saying in the religion of the Drowned God on the Iron Islands in the Game of Thrones universe?', 'What is dead may never die.\r\n\r\n', 'What do we say to the God of death? Not today.::Chaos isn\'t a pit. Chaos is a ladder.::Winter is coming.');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_users`
--

CREATE TABLE `quiz_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quiz_users`
--

INSERT INTO `quiz_users` (`id`, `name`, `email`, `password`) VALUES
(2, 'Daniil Pavlenko', 'danil.pavlenko@gmail.com', '$2y$10$lgBbN/AiuZ8A0pStY3kj/uYZRyZhjWDbV8Wa49u2rGhh7hsgQPEdy'),
(5, 'Victor Hugo', 'v.hugo@mail.fr', '$2y$10$odtSRica3YBh9fwPeyYCte4sPOaeRaP3QqJa4J.NSdMuYFQ6gwJLq'),
(9, 'Anthony Seezlack', 'anthony@gmail.com', '$2y$10$e1le54tg.Aj4F8c441wGUOTdwk7ydk1eRXCB4pqlQSj9TWbga56Pe'),
(15, 'New User', 'user@mail.gouv', '$2y$10$XxD63gxeBygC0A6NIR6AbeSK.XBr1bWiCt6fV7Ng0aqBOSeNZuY8O');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `quiz_details`
--
ALTER TABLE `quiz_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quiz_users`
--
ALTER TABLE `quiz_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `quiz_details`
--
ALTER TABLE `quiz_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `quiz_users`
--
ALTER TABLE `quiz_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quiz_questions`
--
ALTER TABLE `quiz_questions`
  ADD CONSTRAINT `quiz_questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quiz_details` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
