/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.10-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: empDB
-- ------------------------------------------------------
-- Server version	10.11.10-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Attendance`
--

DROP TABLE IF EXISTS `Attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Attendance` (
  `EmployeeID` int(11) NOT NULL,
  `ShiftID` int(11) DEFAULT NULL,
  `Datetime` date NOT NULL,
  `CheckInTime` time NOT NULL,
  `CheckOutTime` time DEFAULT NULL,
  `Status` varchar(10) NOT NULL,
  `WorkingHours` decimal(5,2) NOT NULL,
  PRIMARY KEY (`EmployeeID`,`Datetime`),
  KEY `ShiftID` (`ShiftID`),
  CONSTRAINT `Attendance_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `Employee` (`EmployeeID`),
  CONSTRAINT `Attendance_ibfk_2` FOREIGN KEY (`ShiftID`) REFERENCES `Shift` (`ShiftID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Attendance`
--

LOCK TABLES `Attendance` WRITE;
/*!40000 ALTER TABLE `Attendance` DISABLE KEYS */;
INSERT INTO `Attendance` VALUES
(3,3,'2025-01-21','16:28:10',NULL,'Present',0.00),
(9,1,'2025-01-21','16:08:40','16:14:41','Present',0.10);
/*!40000 ALTER TABLE `Attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Department`
--

DROP TABLE IF EXISTS `Department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Department` (
  `DepartmentName` varchar(50) NOT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `ManagerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`DepartmentName`),
  KEY `ManagerID` (`DepartmentID`),
  CONSTRAINT `Department_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `Employee` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Department`
--

LOCK TABLES `Department` WRITE;
/*!40000 ALTER TABLE `Department` DISABLE KEYS */;
INSERT INTO `Department` VALUES
('Finance',5,1),
('HR',1,4),
('IT',2,2),
('Marketing',3,3),
('Operations',4,5);
/*!40000 ALTER TABLE `Department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Employee`
--

DROP TABLE IF EXISTS `Employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Employee` (
  `EmployeeID` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) DEFAULT NULL,
  `DateOfBirth` date NOT NULL,
  `HireDate` date NOT NULL,
  `Position` varchar(50) NOT NULL,
  `Salary` decimal(10,2) NOT NULL,
  `DepartmentID` int(11) NOT NULL,
  `ShiftID` int(11) NOT NULL,
  PRIMARY KEY (`EmployeeID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Employee`
--

LOCK TABLES `Employee` WRITE;
/*!40000 ALTER TABLE `Employee` DISABLE KEYS */;
INSERT INTO `Employee` VALUES
(1,'John','Doe','john.doe@example.com','1234567890','1990-01-15','2020-06-01','HR Manager',75000.00,1,1),
(2,'Jane','Smith','jane.smith@example.com','9876543210','1985-09-20','2018-03-15','IT Manager',90000.00,2,2),
(3,'Alice','Brown','alice.brown@example.com','5678901234','1995-05-10','2021-08-25','Marketing Manager',65000.00,1,3),
(4,'Bob','Johnson','bob.johnson@example.com','4567890123','1992-11-30','2019-12-10','Operations Manager',60000.00,3,1),
(5,'Emma','Davis','emma.davis@example.com','3456789012','1998-02-25','2022-05-15','Finance Manager',70000.00,2,2),
(6,'Sophia','Williams','sophia.williams@example.com','2345678901','1990-03-22','2023-09-05','Product Manager',80000.00,4,3),
(7,'Michael','Lee','michael.lee@example.com','3456789012','1987-07-12','2022-01-10','Business Analyst',72000.00,5,1),
(8,'Olivia','Martinez','olivia.martinez@example.com','4567890123','1994-11-25','2021-05-18','DevOps Engineer',75000.00,3,2),
(9,'M.T.','Ekleel','mtahsinekleel02@gmail.com','+8801935001422','2002-04-20','2025-01-08','Junior Web Developer',20000.00,2,1),
(10,'Nazmul','Hossain','nazmulh95@yahoo.com','+8801732311587','1995-07-21','2016-04-16','Senior Web Developer',65000.00,2,2),
(11,'Anamul','Haque','ahaque95@yahoo.com','0182838273','1995-01-16','2025-01-21','Social Media Manager',65500.00,3,2);
/*!40000 ALTER TABLE `Employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `EmployeeLeave`
--

DROP TABLE IF EXISTS `EmployeeLeave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EmployeeLeave` (
  `EmployeeID` int(11) NOT NULL,
  `LeaveType` varchar(20) DEFAULT NULL,
  `StartDate` timestamp NOT NULL,
  `EndDate` timestamp NULL DEFAULT NULL,
  `LeaveStatus` varchar(20) DEFAULT NULL,
  `Reason` text DEFAULT NULL,
  PRIMARY KEY (`EmployeeID`,`StartDate`),
  CONSTRAINT `EmployeeLeave_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `Employee` (`EmployeeID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `EmployeeLeave`
--

LOCK TABLES `EmployeeLeave` WRITE;
/*!40000 ALTER TABLE `EmployeeLeave` DISABLE KEYS */;
INSERT INTO `EmployeeLeave` VALUES
(1,'Annual','2025-01-05 03:00:00','2025-01-10 11:00:00','Approved','Family vacation'),
(2,'Sick','2025-01-03 02:00:00','2025-01-04 11:00:00','Approved','Flu recovery'),
(3,'Casual','2025-01-07 03:00:00','2025-01-07 11:00:00','Pending','Personal errands'),
(4,'Annual','2025-01-12 03:00:00','2025-01-15 11:00:00','Approved','Travel plans'),
(5,'Sick','2025-01-02 02:00:00','2025-01-03 11:00:00','Rejected','Migraine issues'),
(6,'Casual','2025-01-06 04:00:00','2025-01-06 09:00:00','Approved','Doctor appointment'),
(7,'Annual','2025-01-08 03:00:00','2025-01-10 11:00:00','Pending','Family commitment'),
(8,'Sick','2025-01-09 02:00:00','2025-01-11 11:00:00','Approved','Dental surgery');
/*!40000 ALTER TABLE `EmployeeLeave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payroll`
--

DROP TABLE IF EXISTS `Payroll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payroll` (
  `PayrollID` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeID` int(11) DEFAULT NULL,
  `SalaryMonth` date DEFAULT NULL,
  `BasicSalary` decimal(10,2) DEFAULT NULL,
  `Bonus` decimal(10,2) DEFAULT NULL,
  `Deductions` decimal(10,2) DEFAULT NULL,
  `NetSalary` decimal(10,2) DEFAULT NULL,
  `PaymentDate` date DEFAULT NULL,
  PRIMARY KEY (`PayrollID`),
  KEY `EmployeeID` (`EmployeeID`),
  CONSTRAINT `Payroll_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `Employee` (`EmployeeID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payroll`
--

LOCK TABLES `Payroll` WRITE;
/*!40000 ALTER TABLE `Payroll` DISABLE KEYS */;
INSERT INTO `Payroll` VALUES
(1,1,'2025-01-01',75000.00,5000.00,2000.00,78000.00,'2025-01-08'),
(2,2,'2025-01-01',90000.00,7000.00,3000.00,94000.00,'2025-01-08'),
(3,3,'2025-01-01',65000.00,4000.00,1500.00,69000.00,'2025-01-08'),
(4,4,'2025-01-01',60000.00,3000.00,1200.00,63000.00,'2025-01-08'),
(5,5,'2025-01-01',70000.00,4500.00,1800.00,73300.00,'2025-01-08'),
(6,6,'2025-01-01',80000.00,6000.00,2500.00,84500.00,'2025-01-08'),
(7,7,'2025-01-01',72000.00,5000.00,2200.00,75000.00,'2025-01-08'),
(8,8,'2025-01-01',75000.00,5500.00,2400.00,78000.00,'2025-01-08'),
(9,9,'2025-01-01',20000.00,5000.00,0.00,25000.00,'2025-01-08');
/*!40000 ALTER TABLE `Payroll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Shift`
--

DROP TABLE IF EXISTS `Shift`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Shift` (
  `ShiftID` int(11) NOT NULL AUTO_INCREMENT,
  `ShiftName` varchar(20) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `ShiftDuration` decimal(5,2) NOT NULL,
  PRIMARY KEY (`ShiftID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Shift`
--

LOCK TABLES `Shift` WRITE;
/*!40000 ALTER TABLE `Shift` DISABLE KEYS */;
INSERT INTO `Shift` VALUES
(1,'Morning','08:00:00','16:00:00',8.00),
(2,'Evening','16:00:00','00:00:00',8.00),
(3,'Night','00:00:00','08:00:00',8.00),
(4,'Split','09:00:00','13:00:00',4.00),
(5,'Flexible','10:00:00','18:00:00',8.00);
/*!40000 ALTER TABLE `Shift` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-21 22:31:47
