-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Gegenereerd op: 13 nov 2014 om 09:22
-- Serverversie: 5.6.16
-- PHP-versie: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `barroc-it`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
  `AppointmentNR` int(10) NOT NULL AUTO_INCREMENT,
  `CustomerNR` int(10) NOT NULL,
  `AptDate` int(11) NOT NULL,
  `Name` varchar(60) NOT NULL,
  `Place` varchar(60) NOT NULL,
  `Comments` varchar(255) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`AppointmentNR`,`CustomerNR`),
  KEY `Appointments-customers` (`CustomerNR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `Date` int(12) NOT NULL,
  `Subject` varchar(50) NOT NULL,
  `Description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `CustomerNR` int(10) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(60) NOT NULL,
  `Address` varchar(60) NOT NULL,
  `Zipcode` varchar(60) NOT NULL,
  `Residence` varchar(60) NOT NULL,
  `ContactPerson` varchar(60) NOT NULL,
  `Initials` varchar(11) NOT NULL,
  `TelephoneNumber` varchar(60) NOT NULL,
  `FaxNumber` varchar(50) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `BankaccountNr` varchar(60) NOT NULL,
  `Credit` varchar(20) NOT NULL DEFAULT '0',
  `NumberOfInvoices` int(20) NOT NULL,
  `RevenueAmount` varchar(60) NOT NULL,
  `Limit` int(20) NOT NULL,
  `LedgerAccount` varchar(60) NOT NULL,
  `BKR` enum('Y','N') NOT NULL DEFAULT 'N',
  `OfferNumbers` int(20) NOT NULL,
  `OfferStatus` varchar(20) NOT NULL,
  `Prospect` enum('Y','N') NOT NULL DEFAULT 'Y',
  `DateOfAction` int(12) NOT NULL,
  `LastContactDate` int(12) NOT NULL,
  `NextAction` int(12) NOT NULL,
  `SalePercentage` varchar(30) NOT NULL,
  `CreditWorthy` enum('Y','N') NOT NULL DEFAULT 'N',
  `OpenProjects` int(20) NOT NULL,
  `Applications` varchar(60) NOT NULL,
  `InternalContactPerson` varchar(60) NOT NULL,
  PRIMARY KEY (`CustomerNR`,`CompanyName`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Gegevens worden geëxporteerd voor tabel `customers`
--

INSERT INTO `customers` (`CustomerNR`, `CompanyName`, `Address`, `Zipcode`, `Residence`, `ContactPerson`, `Initials`, `TelephoneNumber`, `FaxNumber`, `Email`, `BankaccountNr`, `Credit`, `NumberOfInvoices`, `RevenueAmount`, `Limit`, `LedgerAccount`, `BKR`, `OfferNumbers`, `OfferStatus`, `Prospect`, `DateOfAction`, `LastContactDate`, `NextAction`, `SalePercentage`, `CreditWorthy`, `OpenProjects`, `Applications`, `InternalContactPerson`) VALUES
(7, 'Google', 'Silicon Valley', '3480 AB', 'California', 'Mariana Christiansen', 'MC', '06 12344567', '3489 70134388', 'mariana@google.com', '', '', 0, '', 0, '', 'N', 1, 'Done', 'Y', 2013, 2014, 2014, '20', 'N', 0, '', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `InvoiceNR` int(10) NOT NULL AUTO_INCREMENT,
  `CustomerNR` int(10) NOT NULL DEFAULT '0',
  `InvoiceDuration` date DEFAULT NULL,
  `Quantity` varchar(60) DEFAULT NULL,
  `Description` varchar(60) DEFAULT NULL,
  `Price` int(10) DEFAULT NULL,
  `BTW` int(10) NOT NULL DEFAULT '21',
  `Amount` int(10) DEFAULT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`InvoiceNR`,`CustomerNR`),
  KEY `Invoices-Customer` (`CustomerNR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `portfolios`
--

CREATE TABLE IF NOT EXISTS `portfolios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `descr` text NOT NULL,
  `begin_date` int(12) NOT NULL,
  `end_date` int(12) NOT NULL,
  `comments` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Gegevens worden geëxporteerd voor tabel `portfolios`
--

INSERT INTO `portfolios` (`id`, `uid`, `type`, `status`, `descr`, `begin_date`, `end_date`, `comments`) VALUES
(1, 29, 'Important Notice!', 1, 'This is a very important message everybody should see!', 1412978400, 1418252400, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `ProjectNR` int(20) NOT NULL AUTO_INCREMENT,
  `CustomerNR` int(20) NOT NULL,
  `ProjectName` varchar(60) NOT NULL,
  `MaintenanceContract` enum('Y','N') NOT NULL DEFAULT 'N',
  `Hardware` varchar(255) NOT NULL,
  `Software` varchar(255) NOT NULL,
  `StatusProject` enum('Active','Suspended','Done') NOT NULL,
  PRIMARY KEY (`ProjectNR`,`CustomerNR`),
  KEY `Projects-Customers` (`CustomerNR`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `userrole` int(2) NOT NULL,
  `department` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`userrole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `roles`
--

INSERT INTO `roles` (`userrole`, `department`, `description`) VALUES
(1, 'admin', 'The admin for the website, any user with this role can access all departments.'),
(2, 'sales', 'The sales department. Users with this role can add and edit new users for the company.'),
(3, 'finance', 'Users with the finance role can add and edit invoices, as well as see financial data from the customer.'),
(4, 'development', 'The development department can add projects, and edit existing ones. They can also see all customer data.'),
(5, 'personnel', 'This department can add and edit portfolios for each user in the system.');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `userrole` int(1) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `active`, `userrole`) VALUES
(29, 'admin', '$2y$10$9oWP3vKP/7aynBqj2VI/YeyMgFQk5PTgNdx.UumIu7EELDmNwDxIy', 1, 1),
(30, 'sales01', '$2y$10$xNndH2heyrmHJ4eE2QYd.uuIV2i8yH2pvq0ODPHCDfun9jZCa9vv.', 1, 2),
(31, 'sales02', '$2y$10$l7N4Qmi5mUHCYCAO/Tku3uSOTOAJbsvlf.PYM.F8T34BLkgpvUcXG', 1, 2),
(32, 'sales03', '$2y$10$WbopdptsA30LrteeI4Ee8.K2g40bqo0KrPT5BiPaVbDlu.EMojCAy', 1, 2),
(33, 'finance', '$2y$10$5sKfy3790Q15sqQF79YYC.NFU7pkcxt5SC7f7WcUe9/Gf8erQy0gu', 1, 3),
(34, 'development', '$2y$10$Y0lDQOGAF1SFrjr8mBnlzOs1DmvcDnFYMStz6qI2yGILWZQz0bTeu', 1, 4),
(35, 'personnel', '$2y$10$Tvt4/YnqWVejKhdNyh/OsucHJ5DWhf5GVccIT4SCnh87UprvStqxK', 1, 5);

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `Appointments-customers` FOREIGN KEY (`CustomerNR`) REFERENCES `customers` (`CustomerNR`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `Invoices-Customer` FOREIGN KEY (`CustomerNR`) REFERENCES `customers` (`CustomerNR`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolio-user` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON UPDATE CASCADE;

--
-- Beperkingen voor tabel `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `Projects-Customers` FOREIGN KEY (`CustomerNR`) REFERENCES `customers` (`CustomerNR`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
