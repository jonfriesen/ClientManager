-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 09, 2012 at 05:21 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `CustomerManager`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ChangePassword`(
incUserId INT(10),
oldPassword VARCHAR(128),
newPassword VARCHAR(128)
)
BEGIN
UPDATE passwords
SET UserPassword = newPassword
WHERE UserId = incUserId && UserPassword = oldPassword;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `CustomerSearch`(
incCustomerName VARCHAR(128)
)
BEGIN
SELECT *
FROM customers
WHERE FirstName LIKE incCustomerName OR LastName LIKE incCustomerName;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllCustomers`()
BEGIN
SELECT *
FROM customers;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllTechnicians`()
BEGIN
SELECT *
FROM technicians;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCustomer`(
incCustomerId INT(10)
)
BEGIN
SELECT *
FROM customers
WHERE CustomerId = incCustomerId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetRecentServiceCalls`(
incServiceCallAmount INT(10)
)
BEGIN
SELECT
servicecalls.ServiceCallId,
servicecalls.TechnicianId,
CONCAT(technicians.FirstName, ' ', technicians.LastName) AS TechnicianName,
servicecalls.CustomerId,
CONCAT(customers.FirstName, ' ', customers.LastName) AS CustomerName, 
servicecalls.Date,
servicecalls.Notes
FROM servicecalls, technicians, customers
WHERE
servicecalls.TechnicianId = technicians.TechnicianId &&
servicecalls.CustomerId = customers.CustomerId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetServiceCall`(
incServiceId INT(10)
)
BEGIN
SELECT
servicecalls.ServiceCallId,
servicecalls.TechnicianId,
CONCAT(technicians.FirstName, ' ', technicians.LastName) AS TechnicianName,
servicecalls.CustomerId,
CONCAT(customers.FirstName, ' ', customers.LastName) AS CustomerName, 
servicecalls.Date,
servicecalls.Notes
FROM servicecalls, technicians, customers
WHERE ServiceCallId = incServiceId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetServiceCallsByCustomerId`(
incCustomerId INT(10)
)
BEGIN
SELECT
servicecalls.ServiceCallId,
servicecalls.TechnicianId,
CONCAT(technicians.FirstName, ' ', technicians.LastName) AS TechnicianName,
servicecalls.CustomerId,
CONCAT(customers.FirstName, ' ', customers.LastName) AS CustomerName, 
servicecalls.Date,
servicecalls.Notes
FROM servicecalls, technicians, customers
WHERE 
servicecalls.TechnicianId = technicians.TechnicianId &&
servicecalls.CustomerId = customers.CustomerId &&
servicecalls.CustomerId = incCustomerId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetServiceCallsByTechnicianId`(
incTechnicianId INT(10)
)
BEGIN
SELECT
servicecalls.ServiceCallId,
servicecalls.TechnicianId,
CONCAT(technicians.FirstName, ' ', technicians.LastName) AS TechnicianName,
servicecalls.CustomerId,
CONCAT(customers.FirstName, ' ', customers.LastName) AS CustomerName, 
servicecalls.Date,
servicecalls.Notes
FROM servicecalls, technicians, customers
WHERE
servicecalls.TechnicianId = incTechnicianId &&
servicecalls.TechnicianId = technicians.TechnicianId &&
servicecalls.CustomerId = customers.CustomerId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTechnicianByCredentials`(
userName VARCHAR(128),
incUserPass VARCHAR(128)
)
BEGIN
SELECT technicians . *
FROM technicians, passwords
WHERE technicians.UserName = userName && passwords.UserPassword= incUserPass;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTechnicianByID`(
incTechnicianID INT(10)
)
BEGIN
SELECT * FROM technicians
WHERE TechnicianID = incTechnicianID;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetTechnicianRoles`(
incTechnicianId INT(10)
)
BEGIN
SELECT rolelist.Name
FROM rolelist
WHERE rolelist.RoleID
IN (
SELECT rolelist.RoleId
FROM rolelist, userroles
WHERE userroles.TechnicianId = incTechnicianId
);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertCustomer`(
incFirstName VARCHAR(128),
incLastName VARCHAR(128),
incStreetAddress VARCHAR(128),
incCity VARCHAR(128),
incProvince VARCHAR(128),
incPhoneNumber VARCHAR(128),
incEmailAddress VARCHAR(128)
)
BEGIN
INSERT INTO customers
(
`FirstName`,
`LastName`,
`StreetAddress`,
`City`,
`Province`,
`PhoneNumber`,
`EmailAddress`)
VALUES
(
incFirstName,
incLastName,
incStreetAddress,
incCity,
incProvince,
incPhoneNumber,
incEmailAddress
);
SELECT * 
FROM customers
WHERE CustomerId = LAST_INSERT_ID();
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertServiceCall`(
incTechnicianId INT(10),
incCustomerId INT(10),
incDate DATE,
incNotes TEXT
)
BEGIN
INSERT INTO `napos`.`servicecalls`
(
`TechnicianId`,
`CustomerId`,
`Date`,
`Notes`)
VALUES
(
incTechnicianId,
incCustomerId,
incDate,
incNotes
);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertTechnician`(
incUserName VARCHAR(128),
incFirstName VARCHAR(128),
incLastName VARCHAR(128),
incStreetAddress VARCHAR(128),
incCity VARCHAR(128),
incProvince VARCHAR(128),
incHomePhone VARCHAR(128),
incMobilePhone VARCHAR(128),
incPrimaryEmail VARCHAR(128),
incSecondaryEmail VARCHAR(128)
)
BEGIN
INSERT INTO technicians
(
`UserName`,
`FirstName`,
`LastName`,
`StreetAddress`,
`City`,
`Province`,
`HomePhoneNumber`,
`MobilePhoneNumber`,
`PrimaryEmailAddress`,
`SecondaryEmailAddress`)
VALUES
(
incUserName,
incFirstName,
incLastName,
incStreetAddress,
incCity,
incProvince,
incHomePhone,
incMobilePhone,
incPrimaryEmail,
incSecondaryEmail
);
SELECT *
FROM technicians
WHERE TechnicianID = LAST_INSERT_ID();
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `CustomerId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(128) NOT NULL,
  `LastName` varchar(128) NOT NULL,
  `StreetAddress` varchar(128) NOT NULL,
  `City` varchar(128) NOT NULL,
  `Province` varchar(128) NOT NULL,
  `PhoneNumber` varchar(128) NOT NULL,
  `EmailAddress` varchar(128) NOT NULL,
  PRIMARY KEY (`CustomerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerId`, `FirstName`, `LastName`, `StreetAddress`, `City`, `Province`, `PhoneNumber`, `EmailAddress`) VALUES
(1, 'Joe', 'Smith', '123 Fake St.', 'FakeVille', 'BC', '1235555555', 'joe@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `passwords`
--

CREATE TABLE IF NOT EXISTS `passwords` (
  `UserId` int(10) unsigned NOT NULL,
  `UserPassword` varchar(128) NOT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `passwords`
--

INSERT INTO `passwords` (`UserId`, `UserPassword`) VALUES
(1, 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `rolelist`
--

CREATE TABLE IF NOT EXISTS `rolelist` (
  `RoleID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(128) NOT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `rolelist`
--

INSERT INTO `rolelist` (`RoleID`, `Name`) VALUES
(1, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `servicecalls`
--

CREATE TABLE IF NOT EXISTS `servicecalls` (
  `ServiceCallId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TechnicianId` int(10) unsigned NOT NULL,
  `CustomerId` int(10) unsigned NOT NULL,
  `Date` date NOT NULL,
  `Notes` text NOT NULL,
  PRIMARY KEY (`ServiceCallId`),
  KEY `TechnicianId` (`TechnicianId`),
  KEY `CustomerId` (`CustomerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `servicecalls`
--

INSERT INTO `servicecalls` (`ServiceCallId`, `TechnicianId`, `CustomerId`, `Date`, `Notes`) VALUES
(2, 1, 1, '2012-06-20', 'Hello World!'),
(5, 1, 1, '2012-06-22', 'asdasdasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `technicians`
--

CREATE TABLE IF NOT EXISTS `technicians` (
  `TechnicianId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `UserName` varchar(128) NOT NULL,
  `FirstName` varchar(128) NOT NULL,
  `LastName` varchar(128) NOT NULL,
  `StreetAddress` varchar(128) NOT NULL,
  `City` varchar(128) NOT NULL,
  `Province` varchar(128) NOT NULL,
  `HomePhoneNumber` varchar(16) NOT NULL,
  `MobilePhoneNumber` varchar(16) NOT NULL,
  `PrimaryEmailAddress` varchar(128) NOT NULL,
  `SecondaryEmailAddress` varchar(128) NOT NULL,
  PRIMARY KEY (`TechnicianId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `technicians`
--

INSERT INTO `technicians` (`TechnicianId`, `UserName`, `FirstName`, `LastName`, `StreetAddress`, `City`, `Province`, `HomePhoneNumber`, `MobilePhoneNumber`, `PrimaryEmailAddress`, `SecondaryEmailAddress`) VALUES
(1, 'Admin', 'Admin', 'Admin', '123 Fake St.', 'Abbotsford', 'BC', '6045551234', '6045551234', 'admin@nothing.com', 'admin@nothing2.com'),
(2, 'JoeSmith', 'Joe', 'Smith', '123 Fake St', 'FakeVille', 'BC', '6045551234', '7785551234', 'joe@smith.com', 'joesmith@something.com'),
(3, 'MooseManu', 'Moose', 'Manu', '123 Awesome pOssum!', 'Abbypoof', 'AB', '1231231233', '3213213333', 'moose@wildlife.com', 'moosem@antinra.com'),

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE IF NOT EXISTS `userroles` (
  `AutoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TechnicianId` int(10) unsigned NOT NULL,
  `RoleId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`AutoId`),
  KEY `techIdConnector` (`TechnicianId`),
  KEY `roleIdConnector` (`RoleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`AutoId`, `TechnicianId`, `RoleId`) VALUES
(1, 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `passwords`
--
ALTER TABLE `passwords`
  ADD CONSTRAINT `passwords_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `technicians` (`TechnicianId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `servicecalls`
--
ALTER TABLE `servicecalls`
  ADD CONSTRAINT `servicecalls_ibfk_2` FOREIGN KEY (`CustomerId`) REFERENCES `customers` (`CustomerId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `servicecalls_ibfk_1` FOREIGN KEY (`TechnicianId`) REFERENCES `technicians` (`TechnicianId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `userroles`
--
ALTER TABLE `userroles`
  ADD CONSTRAINT `userroles_ibfk_1` FOREIGN KEY (`TechnicianId`) REFERENCES `technicians` (`TechnicianId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userroles_ibfk_2` FOREIGN KEY (`RoleId`) REFERENCES `rolelist` (`RoleID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
