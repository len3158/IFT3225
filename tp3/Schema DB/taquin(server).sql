-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 30, 2019 at 01:40 PM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `siemenil_taquin`
--

-- --------------------------------------------------------

--
-- Table structure for table `joueurs`
--

CREATE TABLE `joueurs` (
  `ID` int(11) NOT NULL,
  `nom` varchar(24) NOT NULL,
  `prenom` varchar(24) NOT NULL,
  `identifiant` varchar(24) NOT NULL,
  `password` varchar(24) NOT NULL,
  `total_nb_parties` int(11) NOT NULL,
  `total_nb_parties_terminees` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `joueurs`
--

INSERT INTO `joueurs` (`ID`, `nom`, `prenom`, `identifiant`, `password`, `total_nb_parties`, `total_nb_parties_terminees`) VALUES
(4, 'toto', 'tata', 'dift@iro.ca', 'toto', 0, 0),
(15, 'a', 'a', 'test@iro.ca', '1234', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE `scores` (
  `ID_joueur` int(11) NOT NULL,
  `NbLignes` int(3) DEFAULT NULL,
  `NbColonnes` int(3) DEFAULT NULL,
  `Deplacements` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`ID_joueur`, `NbLignes`, `NbColonnes`, `Deplacements`, `Date`) VALUES
(15, 3, 3, 24, '2019-07-30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `identifiant` (`identifiant`);

--
-- Indexes for table `scores`
--
ALTER TABLE `scores`
  ADD KEY `ID_foreign` (`ID_joueur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `joueurs`
--
ALTER TABLE `joueurs`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `ID_foreign` FOREIGN KEY (`ID_joueur`) REFERENCES `joueurs` (`ID`) ON UPDATE CASCADE;
