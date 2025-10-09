-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: Clinic_Management_System
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `Admin`
--

DROP TABLE IF EXISTS `Admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Admin` (
  `AdminID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Admin`
--

LOCK TABLES `Admin` WRITE;
/*!40000 ALTER TABLE `Admin` DISABLE KEYS */;
INSERT INTO `Admin` VALUES (1,'arif','01711955202','arif@gmail.com'),(3,'Hadi Radi','01711955202','radi@gmail.com'),(4,'Alom Neha','01711955202','alom@gmail.com'),(5,'Ahmed Saba','01711955202','saba@gmail.com'),(6,'Ankur ','01305810184','ankur@gmail.com'),(9,'aluboss','01305810184','aluboss@gmail.com');
/*!40000 ALTER TABLE `Admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Appointment`
--

DROP TABLE IF EXISTS `Appointment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Appointment` (
  `AppointmentID` int(11) NOT NULL AUTO_INCREMENT,
  `DoctorID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Status` enum('Booked','Approved','Cancelled','Rescheduled') DEFAULT 'Booked',
  `Reason` text DEFAULT NULL,
  PRIMARY KEY (`AppointmentID`),
  KEY `FK_Appointment_Doctor` (`DoctorID`),
  KEY `FK_Appointment_Patient` (`PatientID`),
  CONSTRAINT `FK_Appointment_Doctor` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Appointment_Patient` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Appointment`
--

LOCK TABLES `Appointment` WRITE;
/*!40000 ALTER TABLE `Appointment` DISABLE KEYS */;
INSERT INTO `Appointment` VALUES (2,2,2,'2025-10-11','10:30:00','Approved','Child vaccination'),(3,3,3,'2025-10-12','08:30:00','Booked','Skin allergy'),(4,4,4,'2025-10-13','14:00:00','Cancelled','Knee pain - rescheduled');
/*!40000 ALTER TABLE `Appointment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `AppointmentSlots`
--

DROP TABLE IF EXISTS `AppointmentSlots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AppointmentSlots` (
  `SlotID` int(11) NOT NULL AUTO_INCREMENT,
  `DoctorID` int(11) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Days` set('Mon','Tue','Wed','Thu','Fri','Sat','Sun') NOT NULL,
  PRIMARY KEY (`SlotID`),
  KEY `FK_Slot_Doctor` (`DoctorID`),
  CONSTRAINT `FK_Slot_Doctor` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AppointmentSlots`
--

LOCK TABLES `AppointmentSlots` WRITE;
/*!40000 ALTER TABLE `AppointmentSlots` DISABLE KEYS */;
INSERT INTO `AppointmentSlots` VALUES (3,2,'10:00:00','12:00:00','Mon,Tue,Wed,Thu,Fri'),(4,3,'08:00:00','10:00:00','Mon,Wed,Fri'),(5,4,'13:00:00','17:00:00','Tue,Thu,Sat');
/*!40000 ALTER TABLE `AppointmentSlots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Backup`
--

DROP TABLE IF EXISTS `Backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Backup` (
  `BackupID` int(11) NOT NULL AUTO_INCREMENT,
  `FileName` varchar(255) NOT NULL,
  `CreatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` varchar(100) NOT NULL,
  PRIMARY KEY (`BackupID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Backup`
--

LOCK TABLES `Backup` WRITE;
/*!40000 ALTER TABLE `Backup` DISABLE KEYS */;
INSERT INTO `Backup` VALUES (3,'backup_20251009_185313.sql','2025-10-09 22:53:13','aluboss@gmail.com');
/*!40000 ALTER TABLE `Backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Doctor`
--

DROP TABLE IF EXISTS `Doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Doctor` (
  `DoctorID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Specialization` varchar(100) DEFAULT NULL,
  `VisitFee` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`DoctorID`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Doctor`
--

LOCK TABLES `Doctor` WRITE;
/*!40000 ALTER TABLE `Doctor` DISABLE KEYS */;
INSERT INTO `Doctor` VALUES (2,'Dr. Michael Chen','01712345679','Pediatrics',1200.00),(3,'Dr. Priya Sharma','01712345680','Dermatology',1300.00),(4,'Dr. Robert Brown','01712345681','Orthopedics',1600.00);
/*!40000 ALTER TABLE `Doctor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Login`
--

DROP TABLE IF EXISTS `Login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Login` (
  `LoginID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('admin','doctor','patient') NOT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `DoctorID` int(11) DEFAULT NULL,
  `PatientID` int(11) DEFAULT NULL,
  PRIMARY KEY (`LoginID`),
  UNIQUE KEY `Email` (`Email`),
  KEY `FK_Login_Admin` (`AdminID`),
  KEY `FK_Login_Doctor` (`DoctorID`),
  KEY `FK_Login_Patient` (`PatientID`),
  CONSTRAINT `FK_Login_Admin` FOREIGN KEY (`AdminID`) REFERENCES `Admin` (`AdminID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Login_Doctor` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Login_Patient` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Login`
--

LOCK TABLES `Login` WRITE;
/*!40000 ALTER TABLE `Login` DISABLE KEYS */;
INSERT INTO `Login` VALUES (12,'aluboss@gmail.com','$2y$10$s/aiG0fWdHkt4FHGhiiYCeo4TV4xoOHJwPIG4qUVJZgfIpQKJRDce','admin',9,NULL,NULL),(18,'rahim.khan@email.com','$2y$10$hashedpassword6','patient',NULL,NULL,1),(19,'fatima.begum@email.com','$2y$10$hashedpassword7','patient',NULL,NULL,2),(20,'ayesha.siddiqua@email.com','$2y$10$hashedpassword8','patient',NULL,NULL,3),(21,'kamal.hossain@email.com','$2y$10$hashedpassword9','patient',NULL,NULL,4);
/*!40000 ALTER TABLE `Login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Medicine`
--

DROP TABLE IF EXISTS `Medicine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Medicine` (
  `MedicineID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Strength` varchar(50) NOT NULL,
  `ManufacturerName` varchar(100) NOT NULL,
  `Status` enum('Active','Inactive') DEFAULT 'Active',
  PRIMARY KEY (`MedicineID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Medicine`
--

LOCK TABLES `Medicine` WRITE;
/*!40000 ALTER TABLE `Medicine` DISABLE KEYS */;
INSERT INTO `Medicine` VALUES (1,'Paracetamol','Tablet','500mg','Square Pharmaceuticals','Active'),(2,'Amoxicillin','Capsule','250mg','Beximco Pharma','Active'),(3,'Omeprazole','Capsule','20mg','Incepta Pharma','Active'),(4,'Salbutamol','Inhaler','100mcg','ACI Limited','Active'),(5,'Atorvastatin','Tablet','10mg','Drug International','Active'),(6,'Metformin','Tablet','500mg','Square Pharmaceuticals','Active'),(7,'eno','syrup','100','aluboss','Active'),(8,'Fenadin','tablet','120','Renata','Active');
/*!40000 ALTER TABLE `Medicine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Patient`
--

DROP TABLE IF EXISTS `Patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Patient` (
  `PatientID` int(11) NOT NULL AUTO_INCREMENT,
  `FullName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PatientID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Patient`
--

LOCK TABLES `Patient` WRITE;
/*!40000 ALTER TABLE `Patient` DISABLE KEYS */;
INSERT INTO `Patient` VALUES (1,'Rahim Khan','01712345683',40,'Male','654 Green Road, Khulna'),(2,'Fatima Begum','01712345684',29,'Female','987 Lake View, Barisal'),(3,'Ayesha Siddiqua','01712345685',34,'Female','234 Hill Street, Rangpur'),(4,'Kamal Hossain','01712345686',61,'Male','567 River Side, Comilla');
/*!40000 ALTER TABLE `Patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Prescription`
--

DROP TABLE IF EXISTS `Prescription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Prescription` (
  `PrescriptionID` int(11) NOT NULL AUTO_INCREMENT,
  `DoctorID` int(11) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `AdditionalNotes` text DEFAULT NULL,
  `MedicineID` int(11) NOT NULL,
  `Dosage` varchar(50) NOT NULL,
  `Duration` varchar(50) NOT NULL,
  PRIMARY KEY (`PrescriptionID`),
  KEY `FK_Prescription_Doctor` (`DoctorID`),
  KEY `FK_Prescription_Patient` (`PatientID`),
  KEY `MedicineID` (`MedicineID`),
  CONSTRAINT `FK_Prescription_Doctor` FOREIGN KEY (`DoctorID`) REFERENCES `Doctor` (`DoctorID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Prescription_Patient` FOREIGN KEY (`PatientID`) REFERENCES `Patient` (`PatientID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prescription_ibfk_1` FOREIGN KEY (`MedicineID`) REFERENCES `Medicine` (`MedicineID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Prescription`
--

LOCK TABLES `Prescription` WRITE;
/*!40000 ALTER TABLE `Prescription` DISABLE KEYS */;
INSERT INTO `Prescription` VALUES (3,2,2,'2025-10-06','Take on empty stomach',3,'1 capsule','Once daily for 14 days'),(4,3,3,'2025-10-07','Use as needed for breathing difficulty',4,'2 puffs','When required'),(5,4,4,'2025-10-08','Take at bedtime',5,'1 tablet','Once daily ongoing');
/*!40000 ALTER TABLE `Prescription` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-09 22:59:20
