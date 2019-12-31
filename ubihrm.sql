-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 31, 2019 at 10:37 AM
-- Server version: 5.5.54
-- PHP Version: 5.3.10-1ubuntu3.26

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ubihrm`
--

-- --------------------------------------------------------

--
-- Table structure for table `ActivityHistoryMaster`
--

CREATE TABLE IF NOT EXISTS `ActivityHistoryMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LastModifiedById` int(3) unsigned NOT NULL DEFAULT '0',
  `Module` varchar(250) NOT NULL,
  `ActionPerformed` varchar(450) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `ActivityBy` int(1) NOT NULL DEFAULT '0' COMMENT '0 if activuty performed by HRM, 1 if activity perform by attendance',
  `adminid` int(10) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `LastModifiedById` (`LastModifiedById`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `ActivityBy` (`ActivityBy`),
  KEY `LastModifiedDate` (`LastModifiedDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84650 ;

-- --------------------------------------------------------

--
-- Table structure for table `addons_master`
--

CREATE TABLE IF NOT EXISTS `addons_master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE IF NOT EXISTS `admin_login` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `archive` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `OrganizationId` int(10) NOT NULL DEFAULT '0',
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(5) NOT NULL DEFAULT '1',
  `resetPassCounter` int(5) NOT NULL DEFAULT '0' COMMENT 'this colom sill contain the counting of reset password and prevent the reusibility of same link to reset the password',
  `web_admin_login_sts` tinyint(4) NOT NULL DEFAULT '0',
  `visitImageStatus` int(1) NOT NULL DEFAULT '1' COMMENT '1 if image click is available, 0 if dont want to click image while punching the visit',
  `AttnImageStatus` int(1) NOT NULL DEFAULT '1' COMMENT 'if 1, image should be taken while marking attendance/ if 0, image should not be taken while marking attendance',
  `fencearea` int(11) NOT NULL DEFAULT '0' COMMENT '1 within fence attendance 0 for outside fence attendance',
  `qrselector` int(10) NOT NULL DEFAULT '3',
  PRIMARY KEY (`id`),
  KEY `idx_admin_login` (`username`,`password`),
  KEY `ind_admin_login` (`username`,`password`),
  KEY `arc_login` (`archive`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41379 ;

-- --------------------------------------------------------

--
-- Table structure for table `AirportRootFare`
--

CREATE TABLE IF NOT EXISTS `AirportRootFare` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FromCityId` int(10) unsigned NOT NULL,
  `ToCityId` int(10) unsigned NOT NULL,
  `FareAmount` double NOT NULL,
  `TicketType` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `FromCountryId` int(10) unsigned NOT NULL,
  `ToCountryId` int(10) unsigned NOT NULL,
  `ChildFare` double NOT NULL,
  `InfantFare` double NOT NULL,
  `FiscalId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FromCityId` (`FromCityId`),
  KEY `ToCityId` (`ToCityId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `FromCountryId` (`FromCountryId`),
  KEY `ToCountryId` (`ToCountryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=542 ;

-- --------------------------------------------------------

--
-- Table structure for table `Alert_Settings`
--

CREATE TABLE IF NOT EXISTS `Alert_Settings` (
  `OrganizationId` int(5) NOT NULL,
  `Status` tinyint(1) NOT NULL COMMENT '0 Disable, 1Enable',
  `Time` time NOT NULL,
  `Created_Date` date NOT NULL,
  PRIMARY KEY (`OrganizationId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `anonymousfeedback`
--

CREATE TABLE IF NOT EXISTS `anonymousfeedback` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `anonymousfeedbackcategory_id` int(10) NOT NULL,
  `anonymousfeedbackcategoryques_id` int(10) NOT NULL,
  `ratings` int(10) DEFAULT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `OrganizationId` int(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) NOT NULL,
  `OwnerId` int(10) NOT NULL,
  `saveSts` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4049 ;

-- --------------------------------------------------------

--
-- Table structure for table `anonymousfeedbackcategory_ques`
--

CREATE TABLE IF NOT EXISTS `anonymousfeedbackcategory_ques` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `anonymousfeedbackcategory_id` int(11) NOT NULL,
  `Name` varchar(1000) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `VisibleSts` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- Table structure for table `Anonymousfeedback_category`
--

CREATE TABLE IF NOT EXISTS `Anonymousfeedback_category` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `ApprovalProcess`
--

CREATE TABLE IF NOT EXISTS `ApprovalProcess` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ProcessType` tinyint(3) unsigned NOT NULL,
  `EscalationPeriod` int(10) unsigned NOT NULL DEFAULT '1',
  `RuleCriteria` text,
  `Designation` int(10) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(3) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(3) unsigned NOT NULL DEFAULT '0',
  `HrStatus` int(10) unsigned NOT NULL,
  `Approvalupto` int(11) DEFAULT NULL,
  `OtherApprovalSts` tinyint(1) DEFAULT '0',
  `OtherApproverId` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Designation` (`Designation`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `HrStatus` (`HrStatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=671 ;

-- --------------------------------------------------------

--
-- Table structure for table `ApprovalSteps`
--

CREATE TABLE IF NOT EXISTS `ApprovalSteps` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ApprovalProcessId` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` varchar(45) NOT NULL DEFAULT '',
  `Description` varchar(45) NOT NULL DEFAULT '',
  `Manager_Or_User` varchar(45) NOT NULL DEFAULT '',
  `ManagerUserId` int(3) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(3) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `ManagerUserId` (`ManagerUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ArchiveAttendanceMaster`
--

CREATE TABLE IF NOT EXISTS `ArchiveAttendanceMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AttendanceDate` date NOT NULL DEFAULT '0000-00-00',
  `AttendanceStatus` tinyint(1) NOT NULL DEFAULT '0',
  `TimeIn` time NOT NULL,
  `TimeOut` time NOT NULL,
  `ShiftId` int(10) unsigned DEFAULT NULL,
  `Dept_id` int(10) NOT NULL DEFAULT '0' COMMENT 'to store department for this attendance',
  `Desg_id` int(10) NOT NULL DEFAULT '0' COMMENT 'to store designation for this attendance',
  `areaId` int(5) NOT NULL DEFAULT '0' COMMENT 'coming from employee master area_assigned',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Overtime` time NOT NULL,
  `device` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `TimeinIp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `TimeoutIp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `EntryImage` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ExitImage` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `checkInLoc` text COLLATE utf8_unicode_ci NOT NULL,
  `CheckOutLoc` text COLLATE utf8_unicode_ci NOT NULL,
  `timebreak` int(1) NOT NULL DEFAULT '0' COMMENT '0- off break, 1- on break',
  `timeindate` date NOT NULL COMMENT 'to store date of time in',
  `timeoutdate` date NOT NULL COMMENT 'field for capturing the date of marking time out',
  `latit_in` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the latitude of location',
  `longi_in` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the longitude of location',
  `latit_out` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the latitude of location',
  `longi_out` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the longitude of location',
  `HourlyRateId` int(5) NOT NULL DEFAULT '0' COMMENT 'store the is for hpurly rate of user- ref from hourly_rate_master',
  `remarks` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `remark` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'REmark regarding attendance',
  `manual_status` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NM' COMMENT 'half day(HD), Present(P),Absent(A),Not marked(NM)- specially created for victor logistics',
  `manual_action` int(1) NOT NULL DEFAULT '0' COMMENT '0 for no manuaa action tacken, 1 for manual action- specially created for victor logistics',
  `Is_Delete` tinyint(1) NOT NULL DEFAULT '0',
  `Deleted_Date` date DEFAULT NULL,
  `RegularizeSts` int(1) NOT NULL DEFAULT '0',
  `ApproverId` int(11) NOT NULL,
  `RegularizationRemarks` text COLLATE utf8_unicode_ci NOT NULL,
  `RegularizeRequestDate` date NOT NULL,
  `RegularizeTimeOut` time NOT NULL,
  `RegularizeApproverRemarks` text COLLATE utf8_unicode_ci NOT NULL,
  `RegularizeApprovalDate` datetime NOT NULL,
  `RegularizeTimeIn` time DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `Id` (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `AttendanceDate` (`AttendanceDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3642392 ;

-- --------------------------------------------------------

--
-- Table structure for table `AshtechLogs`
--

CREATE TABLE IF NOT EXISTS `AshtechLogs` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Srno` varchar(255) NOT NULL,
  `EmployeeCode` varchar(255) NOT NULL,
  `TicketNo` varchar(255) NOT NULL,
  `EntryDate` varchar(255) NOT NULL,
  `InOutFlag` varchar(255) NOT NULL,
  `EntryTime` varchar(255) NOT NULL,
  `TrfFlag` varchar(255) NOT NULL,
  `UpdateUID` varchar(255) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `ErrorMsg` varchar(255) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=128962 ;

-- --------------------------------------------------------

--
-- Table structure for table `AssessmentObjective`
--

CREATE TABLE IF NOT EXISTS `AssessmentObjective` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DesignationId` int(10) unsigned NOT NULL DEFAULT '0',
  `Period` int(10) unsigned NOT NULL DEFAULT '0',
  `Objective` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationLevel` varchar(45) NOT NULL DEFAULT '',
  `ThreshholdScore` double NOT NULL,
  `AchievingAmount` double NOT NULL,
  `VariablePaySts` tinyint(1) NOT NULL DEFAULT '0',
  `IncludeDesg` varchar(50) NOT NULL,
  `SelfAssessmentSts` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `DesignationId` (`DesignationId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

-- --------------------------------------------------------

--
-- Table structure for table `AssessmentObjectiveChild`
--

CREATE TABLE IF NOT EXISTS `AssessmentObjectiveChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AssessmentObjectiveId` int(10) unsigned NOT NULL DEFAULT '0',
  `QuadrantId` int(10) unsigned NOT NULL DEFAULT '0',
  `Objective` text,
  `Weightage` int(10) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `VisibleSts` tinyint(1) NOT NULL DEFAULT '1',
  `Description` text NOT NULL,
  `ObjectiveId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `AssessmentObjectiveId` (`AssessmentObjectiveId`),
  KEY `QuadrantId` (`QuadrantId`),
  KEY `ObjectiveId` (`ObjectiveId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=227 ;

-- --------------------------------------------------------

--
-- Table structure for table `AssessmentResult`
--

CREATE TABLE IF NOT EXISTS `AssessmentResult` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AssessmentObjectiveId` int(10) unsigned NOT NULL DEFAULT '0',
  `MinMarks` int(10) unsigned NOT NULL DEFAULT '0',
  `Result` varchar(250) DEFAULT NULL,
  `MaxMarks` int(10) unsigned NOT NULL DEFAULT '100',
  `Rating` int(10) unsigned NOT NULL DEFAULT '0',
  `VariablePayAmt` double NOT NULL,
  `tcriteria` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `AssessmentObjectiveId` (`AssessmentObjectiveId`),
  KEY `AssessmentObjectiveId_2` (`AssessmentObjectiveId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

-- --------------------------------------------------------

--
-- Table structure for table `AssetsIssued`
--

CREATE TABLE IF NOT EXISTS `AssetsIssued` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `AssetId` varchar(250) DEFAULT NULL,
  `IssuedDate` date DEFAULT NULL,
  `ReturnDate` date DEFAULT NULL,
  `Description` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `AssetId` (`AssetId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `AssetsMaster`
--

CREATE TABLE IF NOT EXISTS `AssetsMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `AttendanceLog`
--

CREATE TABLE IF NOT EXISTS `AttendanceLog` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LastModifiedById` int(3) unsigned NOT NULL DEFAULT '0',
  `Module` varchar(250) NOT NULL,
  `ActionPerformed` varchar(450) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `ActivityBy` int(1) NOT NULL DEFAULT '0' COMMENT '0 if activuty performed by HRM, 1 if activity perform by attendance',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=259 ;

-- --------------------------------------------------------

--
-- Table structure for table `AttendanceMaster`
--

CREATE TABLE IF NOT EXISTS `AttendanceMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AttendanceDate` date NOT NULL DEFAULT '0000-00-00',
  `AttendanceStatus` tinyint(1) NOT NULL DEFAULT '0',
  `TimeIn` time NOT NULL,
  `TimeOut` time NOT NULL,
  `ShiftId` int(10) unsigned DEFAULT NULL,
  `Dept_id` int(10) NOT NULL DEFAULT '0' COMMENT 'to store department for this attendance',
  `Desg_id` int(10) NOT NULL DEFAULT '0' COMMENT 'to store designation for this attendance',
  `areaId` int(5) NOT NULL DEFAULT '0' COMMENT 'coming from employee master area_assigned',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Overtime` time NOT NULL,
  `device` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `TimeinIp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `TimeoutIp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `EntryImage` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ExitImage` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `checkInLoc` text COLLATE utf8_unicode_ci NOT NULL,
  `CheckOutLoc` text COLLATE utf8_unicode_ci NOT NULL,
  `timebreak` int(1) NOT NULL DEFAULT '0' COMMENT '0- off break, 1- on break',
  `timeindate` date NOT NULL COMMENT 'to store date of time in',
  `timeoutdate` date NOT NULL COMMENT 'field for capturing the date of marking time out',
  `latit_in` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the latitude of location',
  `longi_in` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the longitude of location',
  `latit_out` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the latitude of location',
  `longi_out` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the longitude of location',
  `HourlyRateId` int(5) NOT NULL DEFAULT '0' COMMENT 'store the is for hpurly rate of user- ref from hourly_rate_master',
  `remarks` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `remark` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'REmark regarding attendance',
  `manual_status` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NM' COMMENT 'half day(HD), Present(P),Absent(A),Not marked(NM)- specially created for victor logistics',
  `manual_action` int(1) NOT NULL DEFAULT '0' COMMENT '0 for no manuaa action tacken, 1 for manual action- specially created for victor logistics',
  `Is_Delete` tinyint(1) NOT NULL DEFAULT '0',
  `Deleted_Date` date DEFAULT NULL,
  `RegularizeSts` int(1) NOT NULL DEFAULT '0',
  `ApproverId` int(11) NOT NULL,
  `RegularizationRemarks` text COLLATE utf8_unicode_ci NOT NULL,
  `RegularizeRequestDate` date NOT NULL,
  `RegularizeTimeOut` time NOT NULL,
  `RegularizeApproverRemarks` text COLLATE utf8_unicode_ci NOT NULL,
  `RegularizeApprovalDate` datetime NOT NULL,
  `RegularizeTimeIn` time DEFAULT NULL,
  `FakeLocationStatusTimeIn` int(10) NOT NULL DEFAULT '0',
  `FakeLocationStatusTimeOut` int(10) NOT NULL DEFAULT '0',
  `FakeTimeInTimeStatus` int(10) NOT NULL DEFAULT '0',
  `FakeTimeOutTimeStatus` int(10) NOT NULL DEFAULT '0',
  `Platform` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `Id` (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `AttendanceDate` (`AttendanceDate`),
  KEY `EmployeeId_2` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=111112065 ;

--
-- Triggers `AttendanceMaster`
--
DROP TRIGGER IF EXISTS `attendance_before_delete`;
DELIMITER //
CREATE TRIGGER `attendance_before_delete` BEFORE DELETE ON `AttendanceMaster`
 FOR EACH ROW BEGIN


   
   INSERT INTO `OnDeleteAttendance`(`Id`, `EmployeeId`, `AttendanceDate`, `AttendanceStatus`, `TimeIn`, `TimeOut`, `ShiftId`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Overtime`, `device`, `TimeinIp`, `TimeoutIp`, `EntryImage`, `ExitImage`, `checkInLoc`, `CheckOutLoc`, `timebreak`, `DeletedDate`) VALUES (OLD.Id, OLD.EmployeeId, OLD.AttendanceDate, OLD.AttendanceStatus, OLD.TimeIn, OLD.TimeOut,OLD.ShiftId,OLD.OrganizationId, OLD.CreatedDate,OLD.CreatedById,OLD.LastModifiedDate, OLD.LastModifiedById,OLD.OwnerId,OLD.Overtime,OLD.device, OLD.TimeinIp,OLD.TimeoutIp, OLD.EntryImage, OLD.ExitImage, OLD.checkInLoc,OLD.CheckOutLoc, OLD.timebreak, NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `AttendanceOvertime`
--

CREATE TABLE IF NOT EXISTS `AttendanceOvertime` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AttId` int(20) NOT NULL,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AttTimeoutDate` date NOT NULL,
  `TimeOut` time NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `TimeoutIp` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ExitImage` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `CheckOutLoc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `timeoutdate` date NOT NULL COMMENT 'field for capturing the date of marking time out',
  `latit_out` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the latitude of location',
  `longi_out` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the longitude of location',
  `ApproverId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `Id` (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `AttTimeoutDate` (`AttTimeoutDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `AttendanceTypeMaster`
--

CREATE TABLE IF NOT EXISTS `AttendanceTypeMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `TypeColor` varchar(45) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `DefaultName` varchar(250) NOT NULL,
  `DefaultColor` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_discount_master`
--

CREATE TABLE IF NOT EXISTS `attendance_discount_master` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `currency` varchar(3) NOT NULL,
  `plan` varchar(25) NOT NULL,
  `discount` decimal(5,2) NOT NULL COMMENT 'in percentage',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `Attendance_plan_master`
--

CREATE TABLE IF NOT EXISTS `Attendance_plan_master` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `currency` varchar(25) NOT NULL,
  `range` varchar(10) NOT NULL COMMENT '(A-0 to 20),(B 21 to40), (C 41 to 60),(D 61 to 80),(E 81 to 100),(F 101 to 120),(G 120+)',
  `monthly` decimal(10,2) NOT NULL,
  `yearly` decimal(10,2) NOT NULL,
  `bulk_attendance` decimal(10,2) NOT NULL COMMENT 'Per annum price',
  `location_tracing` decimal(10,2) NOT NULL COMMENT 'Per annum price',
  `visit_punch` decimal(10,2) NOT NULL COMMENT 'Per annum price',
  `geo_fence` decimal(10,2) NOT NULL COMMENT 'Per annum price',
  `payroll` decimal(10,2) NOT NULL COMMENT 'Per annum price',
  `time_off` decimal(10,2) NOT NULL COMMENT 'Per annum price',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `BackgroundAppLocation`
--

CREATE TABLE IF NOT EXISTS `BackgroundAppLocation` (
  `Id` int(20) NOT NULL AUTO_INCREMENT,
  `CreatedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `LocationJson` text NOT NULL,
  `OutSideHours` varchar(10) NOT NULL,
  `EmployeeId` int(10) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `UpdatedDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IsOutSideFence` tinyint(4) NOT NULL COMMENT '0 for in & 1 for out',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=560 ;

-- --------------------------------------------------------

--
-- Table structure for table `BankMaster`
--

CREATE TABLE IF NOT EXISTS `BankMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Code` varchar(45) NOT NULL,
  `agent_id` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=396 ;

-- --------------------------------------------------------

--
-- Table structure for table `BenefitCompansationChild`
--

CREATE TABLE IF NOT EXISTS `BenefitCompansationChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BenefitCompansationId` int(10) unsigned NOT NULL,
  `BenefitId` int(10) unsigned NOT NULL,
  `BenefitAmount` double NOT NULL,
  `AddDeductSts` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `BenefitCompansationId` (`BenefitCompansationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=599 ;

-- --------------------------------------------------------

--
-- Table structure for table `BenefitCompansationMaster`
--

CREATE TABLE IF NOT EXISTS `BenefitCompansationMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `BenCompMonth` date NOT NULL,
  `EmployeeId` int(10) unsigned NOT NULL,
  `TotalGauranteedPay` double NOT NULL,
  `TotalVariablePay` double NOT NULL,
  `TotalCompansation` double NOT NULL,
  `TotalBenefitPay` double NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=315 ;

-- --------------------------------------------------------

--
-- Table structure for table `BenefitMaster`
--

CREATE TABLE IF NOT EXISTS `BenefitMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `BloodGroupMaster`
--

CREATE TABLE IF NOT EXISTS `BloodGroupMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `BreakMaster`
--

CREATE TABLE IF NOT EXISTS `BreakMaster` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) NOT NULL,
  `Date` date NOT NULL,
  `BreakOn` time NOT NULL,
  `BreakOff` time NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Triggers `BreakMaster`
--
DROP TRIGGER IF EXISTS `breakmaster_before_delete`;
DELIMITER //
CREATE TRIGGER `breakmaster_before_delete` BEFORE DELETE ON `BreakMaster`
 FOR EACH ROW BEGIN

 INSERT INTO `onDeleteBreakMaster`(`Id`, `EmployeeId`, `Date`, `BreakOn`, `BreakOff`, `OrganizationId`, `archive`, `DeletedDate`) VALUES (OLD.Id, OLD.EmployeeId, OLD.Date, OLD.BreakOn, OLD.BreakOff, OLD.OrganizationId, OLD.archive, NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `CategoryMaster`
--

CREATE TABLE IF NOT EXISTS `CategoryMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `TypeId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=236 ;

-- --------------------------------------------------------

--
-- Table structure for table `CategoryType`
--

CREATE TABLE IF NOT EXISTS `CategoryType` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `TypeCode` int(10) unsigned NOT NULL,
  `sts` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `CertificateApproval`
--

CREATE TABLE IF NOT EXISTS `CertificateApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CertificateId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `LeaveStatus` tinyint(3) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `CertificateId` (`CertificateId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `CertificateLetter`
--

CREATE TABLE IF NOT EXISTS `CertificateLetter` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TemplateId` int(10) unsigned NOT NULL,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `TemplateId` (`TemplateId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `CertificateReleaseMaster`
--

CREATE TABLE IF NOT EXISTS `CertificateReleaseMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Remarks` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `ApproverSts` int(10) unsigned NOT NULL DEFAULT '3',
  `ApproveDate` datetime NOT NULL,
  `RequestDocId` varchar(50) NOT NULL DEFAULT '0',
  `Address_to` varchar(400) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ChannelMaster`
--

CREATE TABLE IF NOT EXISTS `ChannelMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `ParentId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `checkin_data_vtl`
--

CREATE TABLE IF NOT EXISTS `checkin_data_vtl` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `CheckinId` int(11) NOT NULL,
  `ProductNo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `TrailerNo` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Action` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `OdoMeterStart` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `OdoMeterEnd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

-- --------------------------------------------------------

--
-- Table structure for table `checkin_master`
--

CREATE TABLE IF NOT EXISTS `checkin_master` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) NOT NULL,
  `location` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `latit` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `longi` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `time` time NOT NULL,
  `location_out` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Location for punch out',
  `latit_out` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'chech_out info',
  `longi_out` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'chech_out info',
  `time_out` time NOT NULL DEFAULT '00:00:00' COMMENT 'chech_out info',
  `date` date NOT NULL,
  `client_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ClientId` int(5) NOT NULL COMMENT 'clint id for instatech or other orgn who are using cliemt ,management system through the attendance system',
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `descriptionIn` mediumtext COLLATE utf8_unicode_ci NOT NULL COMMENT 'remark at the time of  visit in',
  `OrganizationId` int(5) NOT NULL,
  `skipped` int(1) NOT NULL DEFAULT '0' COMMENT '0 not skipped, 1 skipped',
  `checkin_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `checkout_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FakeLocationStatusVisitIn` int(10) NOT NULL DEFAULT '0',
  `FakeLocationStatusVisitOut` int(10) NOT NULL DEFAULT '0',
  `FakeVisitInTimeStatus` int(10) NOT NULL DEFAULT '0',
  `FakeVisitOutTimeStatus` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `date` (`date`),
  KEY `ClientId` (`ClientId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=211967 ;

--
-- Triggers `checkin_master`
--
DROP TRIGGER IF EXISTS `checkin_before_delete`;
DELIMITER //
CREATE TRIGGER `checkin_before_delete` BEFORE DELETE ON `checkin_master`
 FOR EACH ROW BEGIN

 INSERT INTO `onDeleteCheckinMaster`(`Id`, `EmployeeId`, `location`, `latit`, `longi`, `time`,`location_out`, `latit_out`, `longi_out`,`time_out`, `date`, `client_name`, `ClientId`, `description`, `descriptionIn`, `OrganizationId`, `skipped`, `checkin_img`, `checkout_img`,`DeletedDate`) VALUES (OLD.Id, OLD.EmployeeId, OLD.location, OLD.latit, OLD.longi, OLD.time, OLD.location_out, OLD.latit_out, OLD.longi_out, OLD.time_out, OLD.date, OLD.client_name, OLD.ClientId, OLD.description, OLD.descriptionIn, OLD.OrganizationId, OLD.skipped, OLD.checkin_img, OLD.checkout_img, NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ChecklistMaster`
--

CREATE TABLE IF NOT EXISTS `ChecklistMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryId` int(10) unsigned NOT NULL,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `CategoryId` (`CategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=566 ;

-- --------------------------------------------------------

--
-- Table structure for table `CityMaster`
--

CREATE TABLE IF NOT EXISTS `CityMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `CountryId` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `CountryId` (`CountryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3346 ;

-- --------------------------------------------------------

--
-- Table structure for table `ClaimApproval`
--

CREATE TABLE IF NOT EXISTS `ClaimApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ClaimId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `ApproverSts` tinyint(3) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `ClaimId` (`ClaimId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=216 ;

-- --------------------------------------------------------

--
-- Table structure for table `ClaimsChild`
--

CREATE TABLE IF NOT EXISTS `ClaimsChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ClaimId` int(10) unsigned NOT NULL DEFAULT '0',
  `EventDate` date NOT NULL DEFAULT '0000-00-00',
  `ClaimHead` int(10) unsigned NOT NULL DEFAULT '0',
  `Description` varchar(250) DEFAULT NULL,
  `ClaimAmt` float NOT NULL DEFAULT '0',
  `Doc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `ClaimId` (`ClaimId`),
  KEY `EventDate` (`EventDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `ClaimsHead`
--

CREATE TABLE IF NOT EXISTS `ClaimsHead` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `ClaimsMaster`
--

CREATE TABLE IF NOT EXISTS `ClaimsMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `FromDate` date NOT NULL DEFAULT '0000-00-00',
  `Fromdata` varchar(100) NOT NULL,
  `ToDate` varchar(100) NOT NULL DEFAULT '0000-00-00',
  `Purpose` varchar(450) DEFAULT NULL,
  `ClaimHead` int(11) NOT NULL DEFAULT '0',
  `ApproverSts` int(10) unsigned NOT NULL DEFAULT '0',
  `ApproverId` int(10) unsigned NOT NULL DEFAULT '0',
  `ApprovalDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TotalAmt` float NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `ApplyMonth` date NOT NULL,
  `Doc` varchar(100) NOT NULL,
  `financeby` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `FromDate` (`FromDate`),
  KEY `ToDate` (`ToDate`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `ApplyMonth` (`ApplyMonth`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=119 ;

-- --------------------------------------------------------

--
-- Table structure for table `ClientMaster`
--

CREATE TABLE IF NOT EXISTS `ClientMaster` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `Company` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Contact` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Address` text COLLATE utf8_unicode_ci NOT NULL,
  `City` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Country` int(3) NOT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `OrganizationId` int(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 0 for inactive',
  `createdBy` int(10) NOT NULL,
  `ModifiedDate` date NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=786 ;

-- --------------------------------------------------------

--
-- Table structure for table `CompanyMaster`
--

CREATE TABLE IF NOT EXISTS `CompanyMaster` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(75) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(45) DEFAULT NULL,
  `State` varchar(45) DEFAULT NULL,
  `Country` varchar(45) DEFAULT NULL,
  `Zipcode` varchar(45) DEFAULT NULL,
  `Phone` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `Website` varchar(45) DEFAULT NULL,
  `Logo` varchar(75) DEFAULT NULL,
  `StartTime` time NOT NULL DEFAULT '00:00:00',
  `LunchStartTime` time NOT NULL DEFAULT '00:00:00',
  `LunchEndTime` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `CompensatoryLeaves`
--

CREATE TABLE IF NOT EXISTS `CompensatoryLeaves` (
  `Id` int(50) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(50) NOT NULL,
  `AttendanceDate` date NOT NULL,
  `Expirydate` date NOT NULL,
  `TotalHours` time NOT NULL,
  `LeaveId` int(50) NOT NULL,
  `AttendenceSts` int(50) NOT NULL COMMENT '5 for public holiday, 3 for weekoff',
  `ApplyDate` datetime NOT NULL,
  `OrganizationId` int(50) NOT NULL,
  `Compoffsts` int(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `CompetencyAnalysis`
--

CREATE TABLE IF NOT EXISTS `CompetencyAnalysis` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designation` int(10) unsigned NOT NULL DEFAULT '0',
  `Period` int(10) unsigned NOT NULL DEFAULT '0',
  `AssessmentLevel` varchar(250) NOT NULL DEFAULT '',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `CompetencyAnalysisChild`
--

CREATE TABLE IF NOT EXISTS `CompetencyAnalysisChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AnalysisId` int(10) unsigned NOT NULL DEFAULT '0',
  `CompetencyType` int(10) unsigned NOT NULL DEFAULT '0',
  `Competency` int(10) unsigned NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  `BehaviouralIndicator` varchar(250) NOT NULL DEFAULT '',
  `VisibleSts` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `AnalysisId` (`AnalysisId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `CompetencyChild`
--

CREATE TABLE IF NOT EXISTS `CompetencyChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CompetencyId` int(10) unsigned NOT NULL DEFAULT '0',
  `CompLevel` varchar(250) NOT NULL DEFAULT '',
  `BehaviouralIndicator` varchar(250) NOT NULL DEFAULT '',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `CompetencyId` (`CompetencyId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

--
-- Table structure for table `CompetencyMaster`
--

CREATE TABLE IF NOT EXISTS `CompetencyMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL DEFAULT '',
  `TypeId` int(10) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `CompetencyType`
--

CREATE TABLE IF NOT EXISTS `CompetencyType` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL DEFAULT '',
  `Color` varchar(100) NOT NULL DEFAULT '',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `Continuousfeedback`
--

CREATE TABLE IF NOT EXISTS `Continuousfeedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `remark` text NOT NULL,
  `CreatedDate` date NOT NULL,
  `LastModifiedDate` date NOT NULL,
  `FeedbackDate` date NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `emp_id` (`emp_id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1003 ;

-- --------------------------------------------------------

--
-- Table structure for table `CostCentre`
--

CREATE TABLE IF NOT EXISTS `CostCentre` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) DEFAULT NULL,
  `Code` varchar(250) DEFAULT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `CostCentreMaster`
--

CREATE TABLE IF NOT EXISTS `CostCentreMaster` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) DEFAULT NULL,
  `Code` varchar(250) DEFAULT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `CountryMaster`
--

CREATE TABLE IF NOT EXISTS `CountryMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `countrycode` varchar(25) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=239 ;

-- --------------------------------------------------------

--
-- Table structure for table `CourseModule`
--

CREATE TABLE IF NOT EXISTS `CourseModule` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `trainingID` int(11) NOT NULL,
  `ModuleName` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `visiblestatus` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `CreditCardMaster`
--

CREATE TABLE IF NOT EXISTS `CreditCardMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `CurrencyMaster`
--

CREATE TABLE IF NOT EXISTS `CurrencyMaster` (
  `Id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `CurrencyCode` char(3) CHARACTER SET utf8 DEFAULT NULL,
  `CurrencyName` varchar(32) CHARACTER SET utf8 DEFAULT NULL,
  `CurrencySymbol` varchar(3) CHARACTER SET utf8 DEFAULT NULL,
  `CountryId` int(10) unsigned NOT NULL,
  `CurrencyImage` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `CountryId` (`CountryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

-- --------------------------------------------------------

--
-- Table structure for table `CurrentReferrenceAmounts`
--

CREATE TABLE IF NOT EXISTS `CurrentReferrenceAmounts` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `ReferrerAmount` varchar(255) NOT NULL,
  `ReferrenceAmount` varchar(255) NOT NULL,
  `ValidFrom` datetime NOT NULL,
  `ModifiedDate` datetime NOT NULL,
  `currencyreferrer` varchar(255) NOT NULL COMMENT '0 for rs , 1  for dollar, 2 for percentage',
  `currencyreference` varchar(255) NOT NULL COMMENT '0 for rs , 1  for dollar, 2 for percentage',
  `ValidTo` datetime NOT NULL,
  `Validity` datetime NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `DepartmentGoals`
--

CREATE TABLE IF NOT EXISTS `DepartmentGoals` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `GoalId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Goal` text NOT NULL,
  `Priority` int(11) NOT NULL,
  `Remarks` varchar(450) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `Description` varchar(450) DEFAULT NULL,
  `Weightage` int(11) NOT NULL,
  `Quadrant` int(11) NOT NULL,
  `TaskNumber` int(11) NOT NULL,
  `Threshold` double NOT NULL,
  `Budget` double DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id` (`Id`),
  KEY `GoalId` (`GoalId`),
  KEY `DepartmentId` (`DepartmentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `DepartmentMaster`
--

CREATE TABLE IF NOT EXISTS `DepartmentMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `ParentId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `ParentId` (`ParentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=169876 ;

--
-- Triggers `DepartmentMaster`
--
DROP TRIGGER IF EXISTS `dept_before_delete`;
DELIMITER //
CREATE TRIGGER `dept_before_delete` BEFORE DELETE ON `DepartmentMaster`
 FOR EACH ROW BEGIN

  INSERT INTO `onDeleteDepartment`(`Id`, `Name`, `ParentId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `OrganizationId`, `Code`, `archive`, `DeletedDate`) VALUES (OLD.Id, OLD.Name, OLD.ParentId, OLD.CreatedDate, OLD.CreatedById, OLD.LastModifiedDate, OLD.LastModifiedById, OLD.OwnerId, OLD.OrganizationId, OLD.Code, OLD.archive, NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `DesignationMaster`
--

CREATE TABLE IF NOT EXISTS `DesignationMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  `RoleId` int(10) unsigned NOT NULL,
  `HRSts` tinyint(1) NOT NULL DEFAULT '0',
  `Description` mediumtext,
  `archive` int(1) NOT NULL DEFAULT '1',
  `daysofnotice` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=214315 ;

--
-- Triggers `DesignationMaster`
--
DROP TRIGGER IF EXISTS `desg_before_delete`;
DELIMITER //
CREATE TRIGGER `desg_before_delete` BEFORE DELETE ON `DesignationMaster`
 FOR EACH ROW BEGIN

 INSERT INTO `onDeleteDesignation`(`Id`, `Name`, `OrganizationId`, `CreatedDate`, `CreatedById`, `LastModifiedDate`, `LastModifiedById`, `OwnerId`, `Code`, `RoleId`,  `HRSts`,  `Description`,  `archive`,  `daysofnotice`, `DeletedDate`) VALUES (OLD.Id, OLD.Name, OLD.OrganizationId, OLD.CreatedDate, OLD.CreatedById, OLD.LastModifiedDate, OLD.LastModifiedById, OLD.OwnerId, OLD.Code, OLD.RoleId, OLD.HRSts, OLD.Description, OLD.archive, OLD.daysofnotice, NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `DesiredLevel`
--

CREATE TABLE IF NOT EXISTS `DesiredLevel` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(150) NOT NULL,
  `Behaviour` text NOT NULL,
  `Level` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `DivisionMaster`
--

CREATE TABLE IF NOT EXISTS `DivisionMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `OrganizationId` int(10) unsigned DEFAULT '0',
  `Name` varchar(250) NOT NULL,
  `ContactPerson` varchar(250) DEFAULT NULL,
  `ContactNumber` varchar(20) DEFAULT NULL,
  `AltContactNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Address` text,
  `CountryId` int(10) unsigned DEFAULT '0',
  `CityId` int(10) unsigned NOT NULL DEFAULT '0',
  `ZipCode` varchar(20) DEFAULT NULL,
  `Landmark` varchar(250) DEFAULT NULL,
  `CurrencyId` int(10) unsigned DEFAULT '0',
  `DateFormatId` int(10) unsigned DEFAULT '0',
  `TimeFormatId` int(10) unsigned DEFAULT '0',
  `TimeZoneId` int(10) unsigned DEFAULT '0',
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  `ArchiveSts` tinyint(1) NOT NULL DEFAULT '0',
  `ShortName` varchar(10) NOT NULL,
  `Establishment` varchar(50) NOT NULL,
  `Account` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=341 ;

-- --------------------------------------------------------

--
-- Table structure for table `DocumentApproval`
--

CREATE TABLE IF NOT EXISTS `DocumentApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DocumentId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `LeaveStatus` tinyint(3) unsigned DEFAULT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=112 ;

-- --------------------------------------------------------

--
-- Table structure for table `DocumentMaster`
--

CREATE TABLE IF NOT EXISTS `DocumentMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  `DocType` int(11) NOT NULL DEFAULT '1',
  `issuedate` date NOT NULL,
  `expiredate` date NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=173 ;

-- --------------------------------------------------------

--
-- Table structure for table `DocumentReleaseMaster`
--

CREATE TABLE IF NOT EXISTS `DocumentReleaseMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `ReleaseFrom` date DEFAULT NULL,
  `ReleaseTo` date DEFAULT NULL,
  `Remarks` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `ApproverSts` int(10) unsigned NOT NULL DEFAULT '3',
  `ApproveDate` datetime NOT NULL,
  `RequestDocId` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `RequestDocId` (`RequestDocId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

-- --------------------------------------------------------

--
-- Table structure for table `DocumentTracking`
--

CREATE TABLE IF NOT EXISTS `DocumentTracking` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `EmployeeId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeAssessment`
--

CREATE TABLE IF NOT EXISTS `EmployeeAssessment` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `FromDate` date NOT NULL DEFAULT '0000-00-00',
  `ToDate` date NOT NULL DEFAULT '0000-00-00',
  `AssessmentType` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `Achievements` varchar(250) NOT NULL DEFAULT '',
  `Issues` varchar(250) NOT NULL DEFAULT '',
  `AssessmentSts` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationLevel` varchar(250) NOT NULL DEFAULT '',
  `Potentials` varchar(250) NOT NULL DEFAULT '',
  `VariablePay` double NOT NULL DEFAULT '0',
  `Description` varchar(250) NOT NULL DEFAULT '',
  `TotalMarks` int(10) NOT NULL,
  `ObtainedMarks` int(10) NOT NULL,
  `Rating` int(10) NOT NULL,
  `Result` varchar(200) NOT NULL,
  `improvements` text NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `Obtainedmarksby_hr` int(11) DEFAULT NULL,
  `Ratingsby_hr` double DEFAULT NULL,
  `descby_hr` text,
  `hr_assessmentSts` int(11) DEFAULT NULL,
  `Recommend_for_appraisalby_hr` tinyint(1) NOT NULL DEFAULT '0',
  `Rating_categoryby_hr` varchar(500) DEFAULT NULL,
  `SettingType` int(11) DEFAULT '0' COMMENT '0 for designation 1 for all',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `FromDate` (`FromDate`),
  KEY `ToDate` (`ToDate`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1773 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeAssessmentApproval`
--

CREATE TABLE IF NOT EXISTS `EmployeeAssessmentApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeAssessmentId` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationId` int(10) unsigned NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AssessmentSts` tinyint(1) NOT NULL DEFAULT '0',
  `Score` int(11) DEFAULT NULL,
  `Score_percent` int(11) DEFAULT NULL,
  `Ratings` int(11) DEFAULT NULL,
  `Remarks` text,
  `Recommend_for_appraisal` int(11) DEFAULT '0',
  `Rating_category` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `EmployeeAssessmentId` (`EmployeeAssessmentId`),
  KEY `DesignationId` (`DesignationId`),
  KEY `EmployeeId_3` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2856 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeAssessmentChild`
--

CREATE TABLE IF NOT EXISTS `EmployeeAssessmentChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeAssessmentId` int(10) unsigned NOT NULL DEFAULT '0',
  `ObjectiveId` int(10) unsigned NOT NULL DEFAULT '0',
  `Score` int(10) unsigned NOT NULL DEFAULT '0',
  `Comments` varchar(250) NOT NULL DEFAULT '',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationLevel` int(10) unsigned NOT NULL DEFAULT '0',
  `Remarks` text,
  PRIMARY KEY (`Id`),
  KEY `EmployeeAssessmentId` (`EmployeeAssessmentId`),
  KEY `ObjectiveId` (`ObjectiveId`),
  KEY `EmployeeAssessmentId_2` (`EmployeeAssessmentId`),
  KEY `ObjectiveId_2` (`ObjectiveId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5794 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeBankDetails`
--

CREATE TABLE IF NOT EXISTS `EmployeeBankDetails` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `BankId` int(10) unsigned NOT NULL DEFAULT '0',
  `IBAN` varchar(300) DEFAULT NULL,
  `SwiftCode` varchar(300) DEFAULT NULL,
  `Branch` text CHARACTER SET utf8,
  `BankStatus` tinyint(1) NOT NULL DEFAULT '0',
  `agent_id` varchar(100) DEFAULT NULL,
  `CountryId` int(11) NOT NULL,
  `Address` text NOT NULL,
  `ClearingCode` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `BankId` (`BankId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2599 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeBankLoan`
--

CREATE TABLE IF NOT EXISTS `EmployeeBankLoan` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `BankId` int(10) unsigned NOT NULL DEFAULT '0',
  `LoanAmount` varchar(250) DEFAULT NULL,
  `Tenure` varchar(250) DEFAULT NULL,
  `EMI` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `BankId` (`BankId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeBonus`
--

CREATE TABLE IF NOT EXISTS `EmployeeBonus` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Description` varchar(250) NOT NULL,
  `IncentiveAmount` double NOT NULL,
  `ApplyDate` date NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeCarriedForward`
--

CREATE TABLE IF NOT EXISTS `EmployeeCarriedForward` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `LeaveTypeId` int(11) NOT NULL,
  `CFLeave` float NOT NULL,
  `CFMonth` date NOT NULL,
  `FiscalId` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=166 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeChecklist`
--

CREATE TABLE IF NOT EXISTS `EmployeeChecklist` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` text NOT NULL,
  `Sts` tinyint(1) NOT NULL DEFAULT '0',
  `CategoryId` int(10) unsigned NOT NULL DEFAULT '0',
  `ChecklistId` int(10) unsigned NOT NULL DEFAULT '0',
  `HRsts` int(11) NOT NULL DEFAULT '0',
  `temp_id` int(11) NOT NULL DEFAULT '0' COMMENT 'used for putting severanceid and other ids',
  `createdDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `CategoryId` (`CategoryId`),
  KEY `ChecklistId` (`ChecklistId`),
  KEY `temp_id` (`temp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5029 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeCreditCard`
--

CREATE TABLE IF NOT EXISTS `EmployeeCreditCard` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `BankId` int(10) unsigned NOT NULL,
  `CreditCardId` int(250) unsigned NOT NULL,
  `Description` varchar(250) NOT NULL,
  `CreditCardNo` varchar(300) DEFAULT NULL,
  `IssueDate` date NOT NULL,
  `ValidTill` date NOT NULL DEFAULT '0000-00-00',
  `CreditCardLimit` double NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `BankId` (`BankId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `EmployeeId_3` (`EmployeeId`),
  KEY `BankId_2` (`BankId`),
  KEY `CreditCardId` (`CreditCardId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeDependant`
--

CREATE TABLE IF NOT EXISTS `EmployeeDependant` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `EmployeeRelationId` int(10) unsigned NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `DOB` date DEFAULT NULL,
  `NomineePercent` float NOT NULL,
  `Gender` tinyint(3) unsigned NOT NULL,
  `Contact` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE,
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `EmployeeId_3` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=250 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeDocument`
--

CREATE TABLE IF NOT EXISTS `EmployeeDocument` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `DocumentTypeId` int(10) unsigned NOT NULL,
  `DocumentNumber` varchar(300) DEFAULT NULL,
  `IssuedOn` date NOT NULL,
  `ExpiredOn` date NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `OriginalDocSts` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `ReleaseSts` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `DocType` int(11) NOT NULL DEFAULT '1',
  `FileName` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `DocumentTypeId` (`DocumentTypeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `DocumentTypeId_2` (`DocumentTypeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4582 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeHistory`
--

CREATE TABLE IF NOT EXISTS `EmployeeHistory` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Title` varchar(250) NOT NULL,
  `EventDate` datetime NOT NULL,
  `Message` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `Title` (`Title`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EventDate` (`EventDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25163 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeIncentive`
--

CREATE TABLE IF NOT EXISTS `EmployeeIncentive` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Description` varchar(250) NOT NULL,
  `IncentiveAmount` double NOT NULL,
  `ApplyDate` date NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1645 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeInsuranceDetails`
--

CREATE TABLE IF NOT EXISTS `EmployeeInsuranceDetails` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `InsuranceId` int(10) unsigned NOT NULL,
  `InsuredAmount` double NOT NULL,
  `PremiumAmount` double NOT NULL,
  `InsurancePeriod` varchar(45) NOT NULL,
  `ValidTill` date NOT NULL,
  `NomineeDetails` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `InsuranceId` (`InsuranceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=345 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeLeave`
--

CREATE TABLE IF NOT EXISTS `EmployeeLeave` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `LeaveFrom` date NOT NULL DEFAULT '0000-00-00',
  `LeaveTo` date NOT NULL DEFAULT '0000-00-00',
  `LeaveReason` varchar(250) DEFAULT NULL,
  `LeaveStatus` int(10) unsigned DEFAULT '3',
  `ApproverComment` varchar(250) DEFAULT NULL,
  `ApplyDate` datetime NOT NULL,
  `LeaveValidDays` float NOT NULL DEFAULT '0',
  `FiscalId` int(10) unsigned NOT NULL DEFAULT '0',
  `ApprovedBy` int(10) unsigned NOT NULL,
  `LeaveTypeId` int(10) unsigned NOT NULL,
  `ResumptionDate` date NOT NULL DEFAULT '0000-00-00',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `SubstituteEmployeeId` int(10) unsigned NOT NULL,
  `EmergencyContact` varchar(250) NOT NULL,
  `FromDayType` tinyint(1) NOT NULL DEFAULT '1',
  `ToDayType` tinyint(1) NOT NULL DEFAULT '1',
  `TimeOfFrom` tinyint(1) NOT NULL DEFAULT '0',
  `TimeOfTo` tinyint(1) NOT NULL DEFAULT '0',
  `LeaveBreakDown` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `LeaveStatus` (`LeaveStatus`),
  KEY `LeaveTypeId` (`LeaveTypeId`),
  KEY `LeaveFrom` (`LeaveFrom`),
  KEY `LeaveTo` (`LeaveTo`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8244 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeLeaveChild`
--

CREATE TABLE IF NOT EXISTS `EmployeeLeaveChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeLeaveId` int(10) unsigned NOT NULL,
  `LeaveDay` date NOT NULL,
  `PaySts` tinyint(1) NOT NULL COMMENT 'Nopay=0,Fullpay=1, Halfpay=2, 3/4pay=3, 1/4pay=4',
  `LeaveStatus` int(10) unsigned NOT NULL,
  `LeaveTypeId` int(10) unsigned NOT NULL,
  `HalfDaySts` tinyint(1) NOT NULL DEFAULT '0',
  `Entitled` tinyint(1) NOT NULL DEFAULT '0',
  `CarriedForward` tinyint(1) NOT NULL DEFAULT '0',
  `Advance` tinyint(1) NOT NULL DEFAULT '0',
  `LossOfPay` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeLeaveId` (`EmployeeLeaveId`),
  KEY `LeaveTypeId` (`LeaveTypeId`),
  KEY `LeaveDay` (`LeaveDay`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31264 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeLTADetail`
--

CREATE TABLE IF NOT EXISTS `EmployeeLTADetail` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `Name` varchar(100) NOT NULL DEFAULT '',
  `DOB` date NOT NULL DEFAULT '0000-00-00',
  `PassportNo` varchar(300) DEFAULT NULL,
  `EmiratesId` varchar(300) DEFAULT NULL,
  `VisaAttachment` varchar(100) NOT NULL DEFAULT '',
  `PassportAttachment` varchar(100) NOT NULL DEFAULT '',
  `Relation` int(10) unsigned NOT NULL DEFAULT '0',
  `familyuidno` varchar(250) DEFAULT NULL,
  `familyfileno` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeMaster`
--

CREATE TABLE IF NOT EXISTS `EmployeeMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeCode` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `FirstName` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `LastName` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Nationality` int(5) unsigned DEFAULT '0',
  `MaritalStatus` int(5) unsigned NOT NULL DEFAULT '0',
  `Religion` int(5) unsigned DEFAULT '0',
  `BloodGroup` int(5) unsigned DEFAULT '0',
  `KnownLanguage` varchar(250) COLLATE utf8_unicode_ci DEFAULT '0',
  `DOJ` date NOT NULL DEFAULT '0000-00-00',
  `DOC` date NOT NULL DEFAULT '0000-00-00',
  `Visa` int(10) unsigned DEFAULT '0',
  `Gender` int(5) unsigned DEFAULT '0',
  `CurrentContactNumber` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CurrentEmailId` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CurrentAddress` mediumtext COLLATE utf8_unicode_ci,
  `CurrentCountry` int(5) unsigned DEFAULT '0',
  `CurrentCity` int(5) unsigned DEFAULT '0',
  `CurrentZipCode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HomeContactNumber` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HomeEmailId` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HomeAddress` mediumtext COLLATE utf8_unicode_ci,
  `HomeCountry` int(5) unsigned DEFAULT '0',
  `HomeCity` int(5) unsigned DEFAULT '0',
  `HomeZipCode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EmergencyContactNumber` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EmergencyEmailId` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EmergencyAddress` mediumtext COLLATE utf8_unicode_ci,
  `EmergencyCountry` int(5) unsigned DEFAULT '0',
  `EmergencyCity` int(5) unsigned DEFAULT '0',
  `EmergencyZipCode` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ReportingTo` int(5) unsigned NOT NULL DEFAULT '0',
  `Division` int(5) unsigned DEFAULT '0',
  `Department` int(5) unsigned NOT NULL DEFAULT '0',
  `Channel` int(11) DEFAULT NULL,
  `Designation` int(5) unsigned NOT NULL DEFAULT '0',
  `Location` int(5) unsigned NOT NULL DEFAULT '0',
  `Shift` int(5) unsigned NOT NULL DEFAULT '0',
  `area_assigned` varchar(250) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0 for no locatio assigned, not 0 means area assigned for marking attendance, comig from geo_settings',
  `EmployeeStatus` int(5) unsigned NOT NULL DEFAULT '0',
  `Grade` int(5) unsigned DEFAULT '0',
  `WorkingDays` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(5) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(5) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(5) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `FunctionalArea` int(10) unsigned NOT NULL DEFAULT '0',
  `ImageName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `EmployeeCTC` double NOT NULL,
  `PayPattern` tinyint(1) NOT NULL DEFAULT '2',
  `ModePayment` int(11) NOT NULL,
  `BankName` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BankIFSCCode` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BankAccount` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `BankAddress` mediumtext COLLATE utf8_unicode_ci,
  `EmploymentType` tinyint(3) unsigned NOT NULL,
  `TotalExp` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `CompanyEmail` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NearestAirport` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `AirTicket` tinyint(2) unsigned NOT NULL,
  `TicketClass` tinyint(2) unsigned NOT NULL,
  `IATAFare` float NOT NULL,
  `LastTicketAmt` float NOT NULL,
  `OnceIn` int(10) unsigned DEFAULT NULL,
  `TravelInstruction` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `FamilyDetail` varchar(40) COLLATE utf8_unicode_ci DEFAULT '0',
  `ProvisionPeriod` int(10) unsigned NOT NULL,
  `MiddleName` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `DOL` date NOT NULL DEFAULT '0000-00-00',
  `countrycode` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT 'country code mobile',
  `PersonalNo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `OvertimePayment` tinyint(1) NOT NULL DEFAULT '0',
  `archive` int(1) NOT NULL DEFAULT '1',
  `CostCentre` int(11) NOT NULL DEFAULT '0',
  `CoCentre` int(11) unsigned NOT NULL DEFAULT '0',
  `NoOfMonths` int(11) NOT NULL,
  `SalaryIncreament` int(11) NOT NULL,
  `FatherName` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VisaCategory` int(11) NOT NULL,
  `EmergencyContactPerson` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hourly_rate` int(5) NOT NULL DEFAULT '0' COMMENT 'Hourly rate storage for each employee for wage calculation',
  `UID_No` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `File_No` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `UniqueId` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AnnualCTC` double DEFAULT NULL,
  `uan` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `esi_no` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_no` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trial_OrganizationId` int(10) DEFAULT NULL,
  `Is_Delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 means alive and 1 means deleted, 2  means permanent deleted',
  `Deleted_Date` date DEFAULT NULL,
  `EmpAddSts` int(11) NOT NULL DEFAULT '1' COMMENT '1 for new recruite,2 for Import file, 3 for onboard',
  `applicable_pf` tinyint(1) NOT NULL DEFAULT '0',
  `applicable_esi` tinyint(1) NOT NULL DEFAULT '0',
  `applicable_pt` tinyint(1) NOT NULL DEFAULT '0',
  `ticket_no` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Local_Job_Title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Local_Employee_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `weeklyAmt` float NOT NULL,
  `publicholidayAmt` float NOT NULL,
  `weekdaysAmt` float NOT NULL,
  PRIMARY KEY (`Id`) USING BTREE,
  KEY `OrganizationId` (`OrganizationId`),
  KEY `Id` (`Id`),
  KEY `Designation` (`Designation`),
  KEY `Department` (`Department`),
  KEY `DOL` (`DOL`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=100223 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeNewJoinee`
--

CREATE TABLE IF NOT EXISTS `EmployeeNewJoinee` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeCode` varchar(45) DEFAULT NULL,
  `FirstName` varchar(80) DEFAULT NULL,
  `LastName` varchar(80) DEFAULT NULL,
  `DOB` date DEFAULT NULL,
  `Nationality` int(5) unsigned DEFAULT '0',
  `MaritalStatus` int(5) unsigned DEFAULT NULL,
  `Religion` int(5) unsigned DEFAULT '0',
  `BloodGroup` int(5) unsigned DEFAULT '0',
  `KnownLanguage` varchar(250) DEFAULT '0',
  `DOJ` date NOT NULL DEFAULT '0000-00-00',
  `DOC` date NOT NULL DEFAULT '0000-00-00',
  `Visa` int(10) unsigned DEFAULT '0',
  `Gender` int(5) unsigned DEFAULT '0',
  `CurrentContactNumber` varchar(250) DEFAULT NULL,
  `CurrentEmailId` varchar(250) DEFAULT NULL,
  `CurrentAddress` text,
  `CurrentCountry` int(5) unsigned DEFAULT '0',
  `CurrentCity` int(5) unsigned DEFAULT '0',
  `CurrentZipCode` varchar(10) DEFAULT NULL,
  `HomeContactNumber` varchar(250) DEFAULT NULL,
  `HomeEmailId` varchar(250) DEFAULT NULL,
  `HomeAddress` text,
  `HomeCountry` int(5) unsigned DEFAULT '0',
  `HomeCity` int(5) unsigned DEFAULT '0',
  `HomeZipCode` varchar(10) DEFAULT NULL,
  `EmergencyContactNumber` varchar(250) DEFAULT NULL,
  `EmergencyEmailId` varchar(250) DEFAULT NULL,
  `EmergencyAddress` text,
  `EmergencyCountry` int(5) unsigned DEFAULT '0',
  `EmergencyCity` int(5) unsigned DEFAULT '0',
  `EmergencyZipCode` varchar(10) DEFAULT NULL,
  `ReportingTo` int(5) unsigned NOT NULL DEFAULT '0',
  `Division` int(5) unsigned DEFAULT '0',
  `Department` int(5) unsigned NOT NULL DEFAULT '0',
  `Designation` int(5) unsigned NOT NULL DEFAULT '0',
  `Location` int(5) unsigned NOT NULL DEFAULT '0',
  `Shift` int(5) unsigned NOT NULL DEFAULT '0',
  `EmployeeStatus` int(5) unsigned NOT NULL DEFAULT '0',
  `Grade` int(5) unsigned DEFAULT '0',
  `WorkingDays` varchar(80) NOT NULL DEFAULT '',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(5) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(5) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(5) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `FunctionalArea` int(10) unsigned NOT NULL DEFAULT '0',
  `ImageName` varchar(45) NOT NULL,
  `EmployeeCTC` double NOT NULL,
  `PayPattern` tinyint(1) NOT NULL,
  `BankName` varchar(250) DEFAULT NULL,
  `BankIFSCCode` varchar(250) DEFAULT NULL,
  `BankAccount` varchar(250) DEFAULT NULL,
  `BankAddress` text,
  `EmploymentType` tinyint(3) unsigned NOT NULL,
  `TotalExp` varchar(10) NOT NULL,
  `CompanyEmail` varchar(250) NOT NULL,
  `OnboardSts` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'if boarded from ubirecruite =1, csv board=2',
  `NearestAirport` varchar(250) NOT NULL DEFAULT '',
  `UpdateSts` tinyint(1) NOT NULL DEFAULT '1',
  `MiddleName` varchar(45) NOT NULL DEFAULT '',
  `FatherName` varchar(250) DEFAULT NULL,
  `EmergencyContactPerson` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=159 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeNewJoiningDocument`
--

CREATE TABLE IF NOT EXISTS `EmployeeNewJoiningDocument` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `DocumentTypeId` int(10) unsigned NOT NULL,
  `DocumentNumber` varchar(250) DEFAULT NULL,
  `IssuedOn` date NOT NULL,
  `ExpiredOn` date NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `FileName` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=528 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeNewJoiningQualification`
--

CREATE TABLE IF NOT EXISTS `EmployeeNewJoiningQualification` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(5) unsigned NOT NULL DEFAULT '0',
  `InstituteName` varchar(250) NOT NULL DEFAULT '',
  `Degree` varchar(100) DEFAULT NULL,
  `FOS` varchar(250) DEFAULT NULL,
  `DOC` date DEFAULT NULL,
  `GPA` varchar(100) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(5) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(5) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(5) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(5) unsigned NOT NULL DEFAULT '0',
  `FileName` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=174 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeNewJoiningReference`
--

CREATE TABLE IF NOT EXISTS `EmployeeNewJoiningReference` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Company` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Contact` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeNewJoiningSkills`
--

CREATE TABLE IF NOT EXISTS `EmployeeNewJoiningSkills` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `SkillsId` int(10) unsigned NOT NULL,
  `Description` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeNewJoiningWorkExperience`
--

CREATE TABLE IF NOT EXISTS `EmployeeNewJoiningWorkExperience` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `CompanyName` varchar(250) NOT NULL DEFAULT '',
  `Designation` varchar(250) DEFAULT NULL,
  `FromDate` date NOT NULL DEFAULT '0000-00-00',
  `ToDate` date NOT NULL DEFAULT '0000-00-00',
  `Description` text,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(5) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(5) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(5) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeOvertime`
--

CREATE TABLE IF NOT EXISTS `EmployeeOvertime` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Overtime` time NOT NULL,
  `HourlyRate` float NOT NULL,
  `OvertimeAmount` double NOT NULL,
  `ApplyDate` date NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `AttendanceDate` date NOT NULL,
  `overtime_sts` int(2) NOT NULL,
  `SalaryDate` date NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `EmployeeId_3` (`EmployeeId`),
  KEY `EmployeeId_4` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `AttendanceDate` (`AttendanceDate`),
  KEY `ApplyDate` (`ApplyDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeePayrollDetails`
--

CREATE TABLE IF NOT EXISTS `EmployeePayrollDetails` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `HeadId` int(11) NOT NULL,
  `HeadType` int(11) NOT NULL COMMENT '1 for other fixed earning and 2 for only  basic and fixed , 4 for deduction,  0 for pf',
  `HeadAmount` decimal(10,5) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `HeadId` (`HeadId`),
  KEY `HeadType` (`HeadType`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=229 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeQualification`
--

CREATE TABLE IF NOT EXISTS `EmployeeQualification` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(5) unsigned NOT NULL DEFAULT '0',
  `InstituteName` varchar(250) NOT NULL DEFAULT '',
  `Degree` int(10) unsigned DEFAULT NULL,
  `FOS` varchar(250) DEFAULT NULL,
  `DOC` date DEFAULT NULL,
  `GPA` varchar(100) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(5) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(5) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(5) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(5) unsigned NOT NULL DEFAULT '0',
  `FileName` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`) USING BTREE,
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `Degree` (`Degree`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1020 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeReference`
--

CREATE TABLE IF NOT EXISTS `EmployeeReference` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Name` varchar(250) NOT NULL,
  `Company` varchar(250) NOT NULL,
  `Email` varchar(250) NOT NULL,
  `Contact` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=403 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeRegination`
--

CREATE TABLE IF NOT EXISTS `EmployeeRegination` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `ResignSubject` varchar(200) NOT NULL,
  `ResignMessage` text NOT NULL,
  `ResignationStatus` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `NoticeDuration` int(10) unsigned NOT NULL,
  `NoticeStart` date NOT NULL,
  `NoticeEnd` date NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeSalaryDetails`
--

CREATE TABLE IF NOT EXISTS `EmployeeSalaryDetails` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `HeadId` int(10) unsigned NOT NULL,
  `HeadType` int(10) unsigned NOT NULL,
  `HeadAmount` double NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `HeadId` (`HeadId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29147 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeSequence`
--

CREATE TABLE IF NOT EXISTS `EmployeeSequence` (
  `Id` int(10) unsigned DEFAULT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  KEY `OrganizationId` (`OrganizationId`),
  KEY `Id` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeSkillAssessment`
--

CREATE TABLE IF NOT EXISTS `EmployeeSkillAssessment` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `FromDate` date NOT NULL DEFAULT '0000-00-00',
  `ToDate` date NOT NULL DEFAULT '0000-00-00',
  `AssessmentType` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `Achievements` varchar(250) NOT NULL DEFAULT '',
  `Issues` varchar(250) NOT NULL DEFAULT '',
  `AssessmentSts` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationLevel` varchar(250) NOT NULL DEFAULT '',
  `Potentials` varchar(250) NOT NULL DEFAULT '',
  `VariablePay` double NOT NULL DEFAULT '0',
  `Description` varchar(250) NOT NULL DEFAULT '',
  `TotalMarks` int(10) NOT NULL,
  `ObtainedMarks` int(10) NOT NULL,
  `Rating` int(10) NOT NULL,
  `Result` varchar(200) NOT NULL,
  `improvements` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=302 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeSkillAssessmentApproval`
--

CREATE TABLE IF NOT EXISTS `EmployeeSkillAssessmentApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeAssessmentId` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationId` int(10) unsigned NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AssessmentSts` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `EmployeeAssessmentId` (`EmployeeAssessmentId`),
  KEY `DesignationId` (`DesignationId`),
  KEY `EmployeeId_3` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=252 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeSkillAssessmentChild`
--

CREATE TABLE IF NOT EXISTS `EmployeeSkillAssessmentChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeAssessmentId` int(10) unsigned NOT NULL DEFAULT '0',
  `ObjectiveId` int(10) unsigned NOT NULL DEFAULT '0',
  `Score` int(10) unsigned NOT NULL DEFAULT '0',
  `Gap` int(11) NOT NULL,
  `Comments` varchar(250) NOT NULL DEFAULT '',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationLevel` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeAssessmentId` (`EmployeeAssessmentId`),
  KEY `ObjectiveId` (`ObjectiveId`),
  KEY `EmployeeAssessmentId_2` (`EmployeeAssessmentId`),
  KEY `ObjectiveId_2` (`ObjectiveId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1399 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeSkills`
--

CREATE TABLE IF NOT EXISTS `EmployeeSkills` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `SkillsId` int(10) unsigned NOT NULL,
  `Description` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `SkillsId` (`SkillsId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=526 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployeeWorkExperience`
--

CREATE TABLE IF NOT EXISTS `EmployeeWorkExperience` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `CompanyName` varchar(250) NOT NULL DEFAULT '',
  `Designation` varchar(250) DEFAULT NULL,
  `FromDate` date NOT NULL DEFAULT '0000-00-00',
  `ToDate` date NOT NULL DEFAULT '0000-00-00',
  `Description` text,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(5) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(5) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(5) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`) USING BTREE,
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=651 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmployerMaster`
--

CREATE TABLE IF NOT EXISTS `EmployerMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `OrganizationId` int(10) unsigned DEFAULT '0',
  `Name` varchar(250) NOT NULL,
  `ClientManager` int(11) NOT NULL,
  `ContactPerson` varchar(250) DEFAULT NULL,
  `ContactNumber` varchar(250) DEFAULT NULL,
  `AltContactNumber` varchar(20) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `CountryId` int(10) unsigned DEFAULT '0',
  `CityId` int(10) unsigned DEFAULT '0',
  `CurrencyId` int(10) unsigned DEFAULT '0',
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `CompanyWebsite` varchar(200) NOT NULL,
  `CompanyType` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Company=1/Consultant=2',
  `Status` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'active=1, inactive=0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=128 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmploymentStatusMaster`
--

CREATE TABLE IF NOT EXISTS `EmploymentStatusMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `EmploymentTypeMaster`
--

CREATE TABLE IF NOT EXISTS `EmploymentTypeMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=168 ;

-- --------------------------------------------------------

--
-- Table structure for table `ErawanArchiveAttendanceMaster`
--

CREATE TABLE IF NOT EXISTS `ErawanArchiveAttendanceMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AttendanceDate` date NOT NULL DEFAULT '0000-00-00',
  `AttendanceStatus` tinyint(1) NOT NULL DEFAULT '0',
  `TimeIn` time NOT NULL,
  `TimeOut` time NOT NULL,
  `ShiftId` int(10) unsigned DEFAULT NULL,
  `Dept_id` int(10) NOT NULL DEFAULT '0' COMMENT 'to store department for this attendance',
  `Desg_id` int(10) NOT NULL DEFAULT '0' COMMENT 'to store designation for this attendance',
  `areaId` int(5) NOT NULL DEFAULT '0' COMMENT 'coming from employee master area_assigned',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Overtime` time NOT NULL,
  `device` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `TimeinIp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `TimeoutIp` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `EntryImage` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ExitImage` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `checkInLoc` text COLLATE utf8_unicode_ci NOT NULL,
  `CheckOutLoc` text COLLATE utf8_unicode_ci NOT NULL,
  `timebreak` int(1) NOT NULL DEFAULT '0' COMMENT '0- off break, 1- on break',
  `timeindate` date NOT NULL COMMENT 'to store date of time in',
  `timeoutdate` date NOT NULL COMMENT 'field for capturing the date of marking time out',
  `latit_in` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the latitude of location',
  `longi_in` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the longitude of location',
  `latit_out` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the latitude of location',
  `longi_out` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0' COMMENT 'store the longitude of location',
  `HourlyRateId` int(5) NOT NULL DEFAULT '0' COMMENT 'store the is for hpurly rate of user- ref from hourly_rate_master',
  `remarks` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `remark` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'REmark regarding attendance',
  `manual_status` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'NM' COMMENT 'half day(HD), Present(P),Absent(A),Not marked(NM)- specially created for victor logistics',
  `manual_action` int(1) NOT NULL DEFAULT '0' COMMENT '0 for no manuaa action tacken, 1 for manual action- specially created for victor logistics',
  `Is_Delete` tinyint(1) NOT NULL DEFAULT '0',
  `Deleted_Date` date DEFAULT NULL,
  `RegularizeSts` int(1) NOT NULL DEFAULT '0',
  `ApproverId` int(11) NOT NULL,
  `RegularizationRemarks` text COLLATE utf8_unicode_ci NOT NULL,
  `RegularizeRequestDate` date NOT NULL,
  `RegularizeTimeOut` time NOT NULL,
  `RegularizeApproverRemarks` text COLLATE utf8_unicode_ci NOT NULL,
  `RegularizeApprovalDate` datetime NOT NULL,
  `RegularizeTimeIn` time DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `Id` (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `AttendanceDate` (`AttendanceDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2231090 ;

-- --------------------------------------------------------

--
-- Table structure for table `EscalationMaster`
--

CREATE TABLE IF NOT EXISTS `EscalationMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL DEFAULT '',
  `Operator` varchar(45) NOT NULL DEFAULT '',
  `Days` int(10) unsigned NOT NULL DEFAULT '0',
  `Description` varchar(999) NOT NULL DEFAULT '',
  `EscalatedToDelegateUser` tinyint(1) NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ESISettings`
--

CREATE TABLE IF NOT EXISTS `ESISettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `MinimumSalary` double DEFAULT NULL,
  `AllEmpSts` int(5) NOT NULL DEFAULT '0',
  `CreatedByid` int(11) DEFAULT NULL,
  `Created Date` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `EmployeeRate` double NOT NULL,
  `EmployeeSalaryType` int(1) NOT NULL,
  `EmployerRate` double NOT NULL,
  `EmployerSalaryType` int(1) NOT NULL,
  `EsiSts` int(1) NOT NULL,
  `SalaryType` int(1) NOT NULL,
  `DivisionId` varchar(450) NOT NULL,
  `DepartmentId` varchar(450) NOT NULL,
  `GradeId` varchar(450) NOT NULL,
  `MinYear` int(11) NOT NULL,
  `MaxYear` int(11) NOT NULL,
  `EmployeeIds` varchar(450) NOT NULL,
  `EmpChk` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for all employees, 2 for specific employees',
  `LocationId` varchar(450) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `DivisionId` (`DivisionId`),
  KEY `DepartmentId` (`DepartmentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `ExternalFeedback`
--

CREATE TABLE IF NOT EXISTS `ExternalFeedback` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(450) DEFAULT NULL,
  `Name` varchar(250) DEFAULT NULL,
  `Designation` varchar(250) DEFAULT NULL,
  `Company` varchar(450) DEFAULT NULL,
  `Subject` varchar(250) DEFAULT NULL,
  `Message` text,
  `RequestedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `OrganizationId` int(11) DEFAULT NULL,
  `EmployeeId` int(11) DEFAULT NULL,
  `FeedbackDate` date DEFAULT NULL,
  `Ratings` int(11) DEFAULT NULL,
  `Remarks` varchar(450) DEFAULT NULL,
  `Sts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for pending 1  for complete',
  `FromDate` date DEFAULT NULL,
  `ToDate` date DEFAULT NULL,
  `CreatedById` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `FAQMaster`
--

CREATE TABLE IF NOT EXISTS `FAQMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryId` int(10) unsigned NOT NULL,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `FeedbackSkills`
--

CREATE TABLE IF NOT EXISTS `FeedbackSkills` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FeedbackId` int(11) NOT NULL,
  `Skill` varchar(450) NOT NULL,
  `Rating` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `FeedbackId` (`FeedbackId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `FinalSettlementHistory`
--

CREATE TABLE IF NOT EXISTS `FinalSettlementHistory` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `TotalAmount` float NOT NULL DEFAULT '0',
  `BalanceAmount` float NOT NULL DEFAULT '0',
  `PaidAmount` float NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=216 ;

-- --------------------------------------------------------

--
-- Table structure for table `FiscalMaster`
--

CREATE TABLE IF NOT EXISTS `FiscalMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `FiscalSts` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `OwnerId` (`OwnerId`),
  KEY `FiscalSts` (`FiscalSts`),
  KEY `StartDate` (`StartDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20570 ;

-- --------------------------------------------------------

--
-- Table structure for table `FlexiShift_master`
--

CREATE TABLE IF NOT EXISTS `FlexiShift_master` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) NOT NULL,
  `location` varchar(250) NOT NULL,
  `latit` varchar(25) NOT NULL,
  `longi` varchar(25) NOT NULL,
  `time` time NOT NULL,
  `location_out` varchar(250) NOT NULL COMMENT 'Location for punch out',
  `latit_out` varchar(25) NOT NULL DEFAULT '0.0' COMMENT 'chech_out info',
  `longi_out` varchar(25) NOT NULL DEFAULT '0.0' COMMENT 'chech_out info',
  `time_out` time NOT NULL DEFAULT '00:00:00' COMMENT 'chech_out info',
  `date` date NOT NULL,
  `timeout_date` date NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `ClientId` int(5) NOT NULL COMMENT 'clint id for instatech or other orgn who are using cliemt ,management system through the attendance system',
  `description` longtext NOT NULL,
  `descriptionIn` text NOT NULL COMMENT 'remark at the time of  visit in',
  `OrganizationId` int(5) NOT NULL,
  `skipped` int(1) NOT NULL DEFAULT '0' COMMENT '0 not skipped, 1 skipped',
  `checkin_img` varchar(255) NOT NULL,
  `checkout_img` varchar(255) NOT NULL,
  `FakeLocationStatusTimeIn` int(10) NOT NULL DEFAULT '0',
  `FakeLocationStatusTimeOut` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `date` (`date`),
  KEY `timeout_date` (`timeout_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=523 ;

-- --------------------------------------------------------

--
-- Table structure for table `Flexishift_settings`
--

CREATE TABLE IF NOT EXISTS `Flexishift_settings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `OrganizationId` int(11) NOT NULL,
  `Hours` int(11) NOT NULL,
  `Minutes` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `FunctionalAreaMaster`
--

CREATE TABLE IF NOT EXISTS `FunctionalAreaMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=152 ;

-- --------------------------------------------------------

--
-- Table structure for table `GapMaster`
--

CREATE TABLE IF NOT EXISTS `GapMaster` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Gap` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `GenerateNotification`
--

CREATE TABLE IF NOT EXISTS `GenerateNotification` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `Title` varchar(300) NOT NULL DEFAULT '',
  `Message` text NOT NULL,
  `NotifyDate` date NOT NULL DEFAULT '0000-00-00',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `VisibleSts` tinyint(1) NOT NULL DEFAULT '1',
  `NotifyType` int(10) unsigned NOT NULL DEFAULT '0',
  `AlertSts` int(11) NOT NULL DEFAULT '0',
  `MailSts` int(11) NOT NULL DEFAULT '0',
  `CreatedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `NotifyDate` (`NotifyDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=150088 ;

-- --------------------------------------------------------

--
-- Table structure for table `Geo_Settings`
--

CREATE TABLE IF NOT EXISTS `Geo_Settings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Lat_Long` varchar(50) NOT NULL,
  `Location` varchar(250) NOT NULL,
  `Radius` decimal(10,3) NOT NULL,
  `archive` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0 means record is die and 1 meanse recorde is alive',
  `OrganizationId` int(11) NOT NULL,
  `Status` enum('1','0') NOT NULL DEFAULT '1',
  `LastModifiedById` int(11) NOT NULL,
  `LastModifiedDate` date NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1198 ;

-- --------------------------------------------------------

--
-- Table structure for table `GoalComments`
--

CREATE TABLE IF NOT EXISTS `GoalComments` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `GoalId` int(11) NOT NULL,
  `TeamGoalId` int(11) NOT NULL,
  `Comments` varchar(450) NOT NULL,
  `GivenBy` int(11) NOT NULL,
  `GivenDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `GoalId` (`GoalId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `GoalMaster`
--

CREATE TABLE IF NOT EXISTS `GoalMaster` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `DepartmentId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `Goal` text NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `Remarks` varchar(450) NOT NULL,
  `Weightage` int(11) NOT NULL,
  `Quadrant` int(11) NOT NULL,
  `TaskNumber` int(11) NOT NULL,
  `GroupBudget` double NOT NULL,
  `DivisionBudget` double NOT NULL,
  `Threshold` double NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `DepartmentId` (`DepartmentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `GoalResult`
--

CREATE TABLE IF NOT EXISTS `GoalResult` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GoalId` int(10) unsigned NOT NULL DEFAULT '0',
  `MinMarks` int(10) unsigned NOT NULL DEFAULT '0',
  `Result` varchar(250) DEFAULT NULL,
  `MaxMarks` int(10) unsigned NOT NULL DEFAULT '100',
  `Rating` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `GoalId` (`GoalId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `GoalsChild`
--

CREATE TABLE IF NOT EXISTS `GoalsChild` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `GoalId` int(11) NOT NULL,
  `KPA` int(11) NOT NULL,
  `KPI` text NOT NULL,
  `Quadrantdesc` text NOT NULL,
  `Weightage` int(11) NOT NULL,
  `EmployeeGoal` text NOT NULL,
  `ManagerGoal` text NOT NULL,
  `Marks` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `GoalId` (`GoalId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=473 ;

-- --------------------------------------------------------

--
-- Table structure for table `GoalsMaster`
--

CREATE TABLE IF NOT EXISTS `GoalsMaster` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `Remark` text NOT NULL,
  `Approvalupto` int(11) NOT NULL DEFAULT '1' COMMENT '1 for Pending,2 for locked, 3 for asset',
  `ManagerRemark` text NOT NULL,
  `Areaimpdesc` text NOT NULL,
  `overallresult` int(11) NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `FromDate` (`FromDate`),
  KEY `ToDate` (`ToDate`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

-- --------------------------------------------------------

--
-- Table structure for table `GoalsObjective`
--

CREATE TABLE IF NOT EXISTS `GoalsObjective` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DesignationId` int(10) unsigned NOT NULL DEFAULT '0',
  `Objective` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `DesignationId` (`DesignationId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=148 ;

-- --------------------------------------------------------

--
-- Table structure for table `GoalsObjectiveChild`
--

CREATE TABLE IF NOT EXISTS `GoalsObjectiveChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AssessmentObjectiveId` int(10) unsigned NOT NULL DEFAULT '0',
  `QuadrantId` int(10) unsigned NOT NULL DEFAULT '0',
  `Objective` text,
  `Weightage` int(11) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `VisibleSts` tinyint(1) NOT NULL DEFAULT '1',
  `Description` text NOT NULL,
  `ObjectiveId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `AssessmentObjectiveId` (`AssessmentObjectiveId`),
  KEY `QuadrantId` (`QuadrantId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `ObjectiveId` (`ObjectiveId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=606 ;

-- --------------------------------------------------------

--
-- Table structure for table `GradeBenefitChild`
--

CREATE TABLE IF NOT EXISTS `GradeBenefitChild` (
  `GradeId` int(10) unsigned NOT NULL,
  `BenefitId` int(10) unsigned NOT NULL,
  `BenefitAmount` double NOT NULL,
  KEY `GradeId` (`GradeId`),
  KEY `BenefitId` (`BenefitId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `GradeMaster`
--

CREATE TABLE IF NOT EXISTS `GradeMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Description` text,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  `GradeLevel` int(10) unsigned NOT NULL DEFAULT '0',
  `NoOfMonths` int(11) NOT NULL,
  `SalaryIncreament` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=250 ;

-- --------------------------------------------------------

--
-- Table structure for table `GratuityChild`
--

CREATE TABLE IF NOT EXISTS `GratuityChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GratuityId` int(10) unsigned NOT NULL,
  `GratuityYear` int(10) unsigned NOT NULL,
  `GratuityDays` int(10) unsigned NOT NULL,
  `GratuityAbove` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `GratuityId` (`GratuityId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `GratuityMaster`
--

CREATE TABLE IF NOT EXISTS `GratuityMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `EmployeeStatusId` int(10) unsigned NOT NULL,
  `MinExp` int(10) unsigned NOT NULL,
  `MaxExp` int(10) unsigned NOT NULL,
  `PayableDays` int(10) unsigned NOT NULL,
  `ApplyDate` date DEFAULT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `GrievanceApproval`
--

CREATE TABLE IF NOT EXISTS `GrievanceApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GrievanceId` int(10) unsigned NOT NULL DEFAULT '0',
  `ApproverId` int(10) unsigned NOT NULL,
  `ApproverSts` tinyint(3) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `GrievanceId` (`GrievanceId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `GrievanceMaster`
--

CREATE TABLE IF NOT EXISTS `GrievanceMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Message` text NOT NULL,
  `EmployeeIds` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `ApplyDate` date NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL DEFAULT '0',
  `ApproveSts` int(1) NOT NULL DEFAULT '3',
  `Priority` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `HolidayMaster`
--

CREATE TABLE IF NOT EXISTS `HolidayMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Description` text,
  `DateFrom` date NOT NULL,
  `DateTo` date NOT NULL,
  `DivisionId` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `FiscalId` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `DivisionId` (`DivisionId`),
  KEY `DateFrom` (`DateFrom`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=927 ;

-- --------------------------------------------------------

--
-- Table structure for table `HourlyRateMaster`
--

CREATE TABLE IF NOT EXISTS `HourlyRateMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `Rate` decimal(15,2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=265 ;

-- --------------------------------------------------------

--
-- Table structure for table `HRMPlayStore`
--

CREATE TABLE IF NOT EXISTS `HRMPlayStore` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `googlepath` varchar(255) NOT NULL,
  `applepath` varchar(255) NOT NULL,
  `android_version` varchar(50) NOT NULL,
  `ios_version` varchar(50) NOT NULL,
  `is_mandatory_android` int(1) NOT NULL DEFAULT '0',
  `is_mandatory_ios` int(1) NOT NULL DEFAULT '0',
  `alert_popup_android` int(2) NOT NULL,
  `alert_popup_ios` int(2) NOT NULL,
  `OrganizationId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `orgid` (`OrganizationId`),
  KEY `orgid_2` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `InsuranceMaster`
--

CREATE TABLE IF NOT EXISTS `InsuranceMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Description` varchar(250) NOT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `JobModificationApproval`
--

CREATE TABLE IF NOT EXISTS `JobModificationApproval` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `JobId` int(11) NOT NULL,
  `ApproverId` int(11) NOT NULL,
  `ApproverSts` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `ApproverComment` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `JobId` (`JobId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `JobModificationChild`
--

CREATE TABLE IF NOT EXISTS `JobModificationChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `JobId` int(10) unsigned NOT NULL,
  `FieldName` varchar(250) NOT NULL,
  `OldValue` varchar(250) NOT NULL,
  `NewValue` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `JobId` (`JobId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=418 ;

-- --------------------------------------------------------

--
-- Table structure for table `JobModificationMaster`
--

CREATE TABLE IF NOT EXISTS `JobModificationMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `ModifyType` tinyint(3) unsigned NOT NULL,
  `ApplyFrom` date NOT NULL,
  `ApplySts` tinyint(1) NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Remarks` varchar(250) NOT NULL,
  `PromotionType` int(10) unsigned NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '3',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=364 ;

-- --------------------------------------------------------

--
-- Table structure for table `kpi`
--

CREATE TABLE IF NOT EXISTS `kpi` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `QuadrantId` int(11) NOT NULL,
  `Name` varchar(150) NOT NULL,
  `Description` text NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `KpiVisibleSts` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for Visible and 0 for Invisible',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `QuadrantId` (`QuadrantId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=90 ;

-- --------------------------------------------------------

--
-- Table structure for table `LanguageMaster`
--

CREATE TABLE IF NOT EXISTS `LanguageMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=192 ;

-- --------------------------------------------------------

--
-- Table structure for table `lead_owner`
--

CREATE TABLE IF NOT EXISTS `lead_owner` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveApproval`
--

CREATE TABLE IF NOT EXISTS `LeaveApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `LeaveId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `ApproverSts` tinyint(3) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `LeaveId` (`LeaveId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8985 ;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveEligibilityMaster`
--

CREATE TABLE IF NOT EXISTS `LeaveEligibilityMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DivisionId` int(10) unsigned NOT NULL,
  `DepartmentId` int(10) unsigned NOT NULL,
  `DesignationId` int(10) unsigned NOT NULL,
  `GradeId` int(10) unsigned NOT NULL DEFAULT '0',
  `Description` varchar(250) NOT NULL DEFAULT '',
  `LeaveDays` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `WeekDays` float DEFAULT '0',
  `SettingType` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `DivisionId` (`DivisionId`),
  KEY `DepartmentId` (`DepartmentId`),
  KEY `DesignationId` (`DesignationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveHistory`
--

CREATE TABLE IF NOT EXISTS `LeaveHistory` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `TotalLeave` float NOT NULL DEFAULT '0',
  `BalanceLeave` float NOT NULL DEFAULT '0',
  `UsedLeave` float NOT NULL DEFAULT '0',
  `FiscalId` int(10) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `LeaveAllotted` float NOT NULL DEFAULT '0',
  `AdvanceLeave` float NOT NULL DEFAULT '0',
  `LeaveSts` tinyint(1) NOT NULL DEFAULT '0',
  `ResetLeave` int(10) unsigned NOT NULL DEFAULT '0',
  `CFLeave` float NOT NULL,
  `EncashDate` date NOT NULL,
  `AnnualSts` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18262 ;

-- --------------------------------------------------------

--
-- Table structure for table `LeaveMaster`
--

CREATE TABLE IF NOT EXISTS `LeaveMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `LeaveDays` float unsigned NOT NULL DEFAULT '0',
  `fiscal_id` int(10) unsigned NOT NULL DEFAULT '0',
  `LeaveUsableSts` tinyint(1) NOT NULL DEFAULT '0',
  `LeaveAllowedSts` tinyint(1) NOT NULL DEFAULT '0',
  `LeaveColor` varchar(45) NOT NULL,
  `DepartmentIds` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationIds` int(10) unsigned NOT NULL DEFAULT '0',
  `GenderId` tinyint(2) unsigned NOT NULL,
  `MaritalId` tinyint(2) unsigned NOT NULL,
  `EmployeeIds` text NOT NULL,
  `EmployeeExperience` varchar(45) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `LeavePayRule` varchar(250) DEFAULT NULL COMMENT '0 for No Pay, 1 for full Pay, 2 for half Pay,  3 for 3/4 Pay,  4 for 1/4 Pay',
  `LeaveRules` varchar(250) NOT NULL,
  `DivisionId` int(10) unsigned NOT NULL,
  `GradeId` varchar(100) NOT NULL,
  `LeaveApply` date NOT NULL,
  `WorkingDays` float DEFAULT NULL,
  `Description` varchar(250) NOT NULL DEFAULT '',
  `AnnualLeaveSts` tinyint(1) NOT NULL DEFAULT '0',
  `ReligionId` int(10) unsigned NOT NULL,
  `CarryForward` tinyint(1) NOT NULL DEFAULT '0',
  `VisibleSts` tinyint(1) NOT NULL DEFAULT '0',
  `ProbationSts` tinyint(1) NOT NULL DEFAULT '0',
  `compoffsts` tinyint(1) NOT NULL DEFAULT '0',
  `workfromhomests` tinyint(1) NOT NULL DEFAULT '0',
  `Period` int(11) NOT NULL,
  `carriedforward` tinyint(1) NOT NULL DEFAULT '0',
  `includeweekoff` tinyint(1) NOT NULL DEFAULT '0',
  `DefaultSts` int(2) NOT NULL DEFAULT '0' COMMENT '1-for attendance app (non-deletable)',
  `Caping` int(2) NOT NULL DEFAULT '0',
  `Capingperiod` varchar(50) NOT NULL,
  `Monthleave` varchar(50) NOT NULL,
  `Noofdaysforsandwich` int(15) NOT NULL,
  `compoffexpireSts` int(15) NOT NULL,
  `CompoffWeekends` int(15) NOT NULL DEFAULT '1',
  `CompoffHolidays` int(15) NOT NULL DEFAULT '1',
  `CompoffExpire` int(15) NOT NULL DEFAULT '1',
  `TotalHours` time NOT NULL,
  `locationId` int(10) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16283 ;

-- --------------------------------------------------------

--
-- Table structure for table `licence_ubiattendance`
--

CREATE TABLE IF NOT EXISTS `licence_ubiattendance` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `OrganizationId` int(5) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `package_id` int(2) NOT NULL DEFAULT '0' COMMENT '0 if licence under trial/ !0 if package bought',
  `user_limit` int(5) NOT NULL DEFAULT '1' COMMENT 'Default user licence limit ',
  `adons` varchar(100) NOT NULL,
  `reg_users` int(5) NOT NULL COMMENT 'total no. of users registered by the organisation',
  `transaction_id` varchar(100) NOT NULL,
  `extended` int(3) NOT NULL DEFAULT '1' COMMENT 'store the info about - how many time end date of trial/bought has changed',
  `remarks` longtext NOT NULL COMMENT 'remarks for trial organization',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '0 for trial/ 1 for buy/ 2 for expired',
  `archive` tinyint(1) NOT NULL DEFAULT '1',
  `Addon_BulkAttn` int(1) NOT NULL DEFAULT '0' COMMENT '1 if org has bulk attenedance functionality else 0',
  `Addon_LocationTracking` int(1) NOT NULL DEFAULT '0' COMMENT '1 for active, 0 for inactive ',
  `Addon_VisitPunch` int(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 0 for inactive ',
  `Addon_GeoFence` int(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 0 for inactive ',
  `Addon_Payroll` int(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 0 for inactive ',
  `Addon_TimeOff` int(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 0 for inactive',
  `Addon_flexi_shif` int(1) NOT NULL DEFAULT '0',
  `image_status` int(2) NOT NULL DEFAULT '1' COMMENT '1 for image active 0 for image inactive',
  `Addon_offline_mode` int(10) NOT NULL DEFAULT '1' COMMENT '1 for active 0 for inactive',
  `Addon_Delete` int(1) NOT NULL DEFAULT '0',
  `Addon_Edit` int(1) NOT NULL DEFAULT '0',
  `Addon_AutoTimeOut` int(1) NOT NULL DEFAULT '0',
  `due_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Thiis is the payable amount due on the companies',
  PRIMARY KEY (`id`),
  KEY `idx_lice` (`OrganizationId`,`end_date`,`status`),
  KEY `end_date` (`end_date`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41374 ;

-- --------------------------------------------------------

--
-- Table structure for table `licence_ubihrm`
--

CREATE TABLE IF NOT EXISTS `licence_ubihrm` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `OrganizationId` int(5) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `package_id` int(2) NOT NULL DEFAULT '0' COMMENT '0 if licence under trial/ !0 if package bought',
  `user_limit` int(5) NOT NULL DEFAULT '1' COMMENT 'Default user licence limit ',
  `adons` varchar(100) NOT NULL,
  `reg_users` int(5) NOT NULL COMMENT 'total no. of users registered by the organisation',
  `transaction_id` varchar(100) NOT NULL,
  `exceed_users` int(5) NOT NULL COMMENT 'total no. of users registered by the organisation',
  `extended` int(3) NOT NULL DEFAULT '1' COMMENT 'store the info about - how many time end date of trial/bought has changed',
  `planstatus` int(1) NOT NULL DEFAULT '0' COMMENT '0 for trial/ 1 for buy/ 2 for expired',
  `archive` tinyint(1) NOT NULL DEFAULT '1',
  `due_amount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'Thiis is the payable amount due on the companies',
  `CreatedDate` date NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_lice` (`OrganizationId`,`end_date`,`planstatus`),
  KEY `end_date` (`end_date`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

-- --------------------------------------------------------

--
-- Table structure for table `LocationMaster`
--

CREATE TABLE IF NOT EXISTS `LocationMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Address` text NOT NULL,
  `Landmark` varchar(250) NOT NULL,
  `CountryId` int(10) unsigned NOT NULL,
  `CityId` int(10) unsigned NOT NULL,
  `ZipCode` varchar(20) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=168 ;

-- --------------------------------------------------------

--
-- Table structure for table `LoginHistory`
--

CREATE TABLE IF NOT EXISTS `LoginHistory` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `loggedinById` varchar(45) NOT NULL DEFAULT '',
  `LoginTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LogoutTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `IpAddress` varchar(45) NOT NULL DEFAULT '',
  `Browser` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44861 ;

-- --------------------------------------------------------

--
-- Table structure for table `MedicalClaim`
--

CREATE TABLE IF NOT EXISTS `MedicalClaim` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `ClaimFor` int(11) NOT NULL,
  `FMemberId` int(11) NOT NULL,
  `MobileNo` int(20) NOT NULL,
  `InsuranceNo` int(20) NOT NULL,
  `tCountry` int(11) NOT NULL,
  `tCity` int(11) NOT NULL,
  `tHospital` varchar(150) NOT NULL,
  `tSymptoms` varchar(150) NOT NULL,
  `tSpeciality` varchar(150) NOT NULL,
  `tRefDoc` varchar(150) NOT NULL,
  `tDetails` text NOT NULL,
  `tDiagnosis` varchar(150) NOT NULL,
  `tPrognosis` varchar(150) NOT NULL,
  `ReqAmount` int(11) NOT NULL,
  `SancAmount` int(11) NOT NULL,
  `LeaveFrom` date NOT NULL,
  `LeaveTo` date NOT NULL,
  `MedDoc` varchar(150) NOT NULL,
  `ApproveSts` int(11) NOT NULL,
  `entitled` int(11) NOT NULL,
  `financeby` int(11) NOT NULL,
  `remark` text NOT NULL,
  `fremark` text NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `Milestone`
--

CREATE TABLE IF NOT EXISTS `Milestone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DefaultMilestoneId` int(20) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  `projectid` int(10) unsigned NOT NULL,
  `assignee_id` int(10) unsigned NOT NULL,
  `description` text NOT NULL,
  `status` varchar(45) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `	CreatedDate` date NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` date NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `Totalhour` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=475 ;

-- --------------------------------------------------------

--
-- Table structure for table `ModeMaster`
--

CREATE TABLE IF NOT EXISTS `ModeMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

-- --------------------------------------------------------

--
-- Table structure for table `ModuleChild`
--

CREATE TABLE IF NOT EXISTS `ModuleChild` (
  `ModuleId` int(10) unsigned NOT NULL,
  `ColumnName` varchar(250) NOT NULL,
  `ColumnLabel` varchar(250) NOT NULL,
  `ColumnSts` tinyint(1) NOT NULL DEFAULT '1',
  `ListTable` tinyint(1) NOT NULL DEFAULT '0',
  `TableName` varchar(45) NOT NULL,
  `FieldType` varchar(45) NOT NULL,
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`Id`),
  KEY `ModuleId` (`ModuleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2721 ;

-- --------------------------------------------------------

--
-- Table structure for table `ModuleMaster`
--

CREATE TABLE IF NOT EXISTS `ModuleMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ModuleName` varchar(45) NOT NULL,
  `ModuleLabel` varchar(45) NOT NULL,
  `ModuleCode` int(10) unsigned NOT NULL,
  `ModuleSts` tinyint(1) NOT NULL,
  `TabId` tinyint(3) unsigned NOT NULL COMMENT '1 for Employee, 2 for Attendance , 3 for Leave, 4 for Salary , 5 for Org, 6 for Performance , 7 for Timesheet, 8 for Payroll',
  `ReportSts` tinyint(1) NOT NULL,
  `SortOnTab` int(10) unsigned NOT NULL DEFAULT '0',
  `SubModule` varchar(100) NOT NULL DEFAULT '',
  `addon_sts` tinyint(1) DEFAULT '0',
  `AttendanceAppSts` int(2) NOT NULL DEFAULT '0' COMMENT '1- use in attendance app, 0- default',
  PRIMARY KEY (`Id`),
  KEY `TabId` (`TabId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=490 ;

-- --------------------------------------------------------

--
-- Table structure for table `ModulePricing`
--

CREATE TABLE IF NOT EXISTS `ModulePricing` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ModuleId` int(11) NOT NULL,
  `SubmoduleId` int(11) NOT NULL,
  `PriceIndia` double NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `PriceUSD` double DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `ModuleId` (`ModuleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `NationalityMaster`
--

CREATE TABLE IF NOT EXISTS `NationalityMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) DEFAULT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=197 ;

-- --------------------------------------------------------

--
-- Table structure for table `NotificationMaster`
--

CREATE TABLE IF NOT EXISTS `NotificationMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Message` text NOT NULL,
  `Division` int(10) unsigned DEFAULT '0',
  `Department` int(10) unsigned DEFAULT '0',
  `Designation` int(10) unsigned DEFAULT '0',
  `EmployeeIds` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `NotificationType` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `NotificationPriority` tinyint(3) unsigned NOT NULL,
  `fileattach` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `LastModifiedDate` (`LastModifiedDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12294 ;

-- --------------------------------------------------------

--
-- Table structure for table `OfficLetterMaster`
--

CREATE TABLE IF NOT EXISTS `OfficLetterMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Title` varchar(250) NOT NULL,
  `Message` text,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `EmployeeId` text NOT NULL,
  `SeniorSts` tinyint(1) NOT NULL DEFAULT '0',
  `SeniorIds` text NOT NULL,
  `MailSts` tinyint(1) NOT NULL,
  `attachfile` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=645 ;

-- --------------------------------------------------------

--
-- Table structure for table `OfflineAttendanceNotSynced`
--

CREATE TABLE IF NOT EXISTS `OfflineAttendanceNotSynced` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `SyncDate` datetime NOT NULL,
  `OfflineMarkedDate` datetime NOT NULL,
  `Time` time NOT NULL,
  `Action` int(11) NOT NULL,
  `Latitude` varchar(255) NOT NULL,
  `Longitude` varchar(255) NOT NULL,
  `ReasonForFailure` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `FakeLocationStatus` int(10) NOT NULL DEFAULT '0',
  `createdDate` datetime NOT NULL,
  `updatedDate` datetime NOT NULL,
  `FakeTimeStatus` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6579 ;

-- --------------------------------------------------------

--
-- Table structure for table `OnDeleteAttendance`
--

CREATE TABLE IF NOT EXISTS `OnDeleteAttendance` (
  `Id` int(10) unsigned NOT NULL,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AttendanceDate` date NOT NULL DEFAULT '0000-00-00',
  `AttendanceStatus` tinyint(1) NOT NULL DEFAULT '0',
  `TimeIn` time NOT NULL,
  `TimeOut` time NOT NULL,
  `ShiftId` int(10) unsigned DEFAULT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Overtime` time NOT NULL,
  `device` varchar(100) NOT NULL,
  `TimeinIp` varchar(100) NOT NULL,
  `TimeoutIp` varchar(100) NOT NULL,
  `EntryImage` varchar(100) NOT NULL,
  `ExitImage` varchar(100) NOT NULL,
  `checkInLoc` text NOT NULL,
  `CheckOutLoc` text NOT NULL,
  `timebreak` int(1) NOT NULL DEFAULT '0' COMMENT '0- off break, 1- on break',
  `DeletedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `AttendanceDate` (`AttendanceDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `onDeleteBreakMaster`
--

CREATE TABLE IF NOT EXISTS `onDeleteBreakMaster` (
  `Id` int(5) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) NOT NULL,
  `Date` date NOT NULL,
  `BreakOn` time NOT NULL,
  `BreakOff` time NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1',
  `DeletedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `onDeleteCheckinMaster`
--

CREATE TABLE IF NOT EXISTS `onDeleteCheckinMaster` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) NOT NULL,
  `location` varchar(250) NOT NULL,
  `latit` varchar(25) NOT NULL,
  `longi` varchar(25) NOT NULL,
  `time` time NOT NULL,
  `location_out` varchar(250) NOT NULL COMMENT 'Location for punch out',
  `latit_out` varchar(25) NOT NULL DEFAULT '0.0' COMMENT 'chech_out info',
  `longi_out` varchar(25) NOT NULL DEFAULT '0.0' COMMENT 'chech_out info',
  `time_out` time NOT NULL DEFAULT '00:00:00' COMMENT 'chech_out info',
  `date` date NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `ClientId` int(5) NOT NULL COMMENT 'clint id for instatech or other orgn who are using cliemt ,management system through the attendance system',
  `description` longtext NOT NULL,
  `descriptionIn` text NOT NULL COMMENT 'remark at the time of  visit in',
  `OrganizationId` int(5) NOT NULL,
  `skipped` int(1) NOT NULL DEFAULT '0' COMMENT '0 not skipped, 1 skipped',
  `checkin_img` varchar(255) NOT NULL,
  `checkout_img` varchar(255) NOT NULL,
  `DeletedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=210022 ;

-- --------------------------------------------------------

--
-- Table structure for table `onDeleteDepartment`
--

CREATE TABLE IF NOT EXISTS `onDeleteDepartment` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `ParentId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1',
  `DeletedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `ParentId` (`ParentId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=169857 ;

-- --------------------------------------------------------

--
-- Table structure for table `onDeleteDesignation`
--

CREATE TABLE IF NOT EXISTS `onDeleteDesignation` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  `RoleId` int(10) unsigned NOT NULL,
  `HRSts` tinyint(1) NOT NULL DEFAULT '0',
  `Description` text,
  `archive` int(1) NOT NULL DEFAULT '1',
  `daysofnotice` int(11) NOT NULL,
  `DeletedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=214302 ;

-- --------------------------------------------------------

--
-- Table structure for table `onDeleteShift`
--

CREATE TABLE IF NOT EXISTS `onDeleteShift` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) DEFAULT NULL,
  `TimeIn` time NOT NULL,
  `TimeOut` time NOT NULL,
  `TimeInGrace` time NOT NULL,
  `TimeOutGrace` time NOT NULL,
  `TimeInBreak` time NOT NULL DEFAULT '12:00:00',
  `TimeOutBreak` time NOT NULL DEFAULT '12:00:00',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `BreakInGrace` time NOT NULL,
  `BreakOutGrace` time NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1',
  `shifttype` int(1) NOT NULL DEFAULT '1' COMMENT '1 is for shift start/end within a day, 2 for shift strt /end in two days',
  `DeletedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48062 ;

-- --------------------------------------------------------

--
-- Table structure for table `onDeleteTimeoff`
--

CREATE TABLE IF NOT EXISTS `onDeleteTimeoff` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` varchar(45) NOT NULL DEFAULT '',
  `TimeofDate` date NOT NULL DEFAULT '0000-00-00',
  `TimeFrom` time DEFAULT NULL,
  `TimeTo` time DEFAULT NULL,
  `Reason` varchar(175) DEFAULT NULL,
  `ApproverId` varchar(45) NOT NULL DEFAULT '',
  `ApprovalSts` int(10) unsigned NOT NULL DEFAULT '3',
  `ApproverComment` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OrganizationId` int(11) NOT NULL,
  `DeletedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14290 ;

-- --------------------------------------------------------

--
-- Table structure for table `ondeletetimesheet`
--

CREATE TABLE IF NOT EXISTS `ondeletetimesheet` (
  `id` int(5) NOT NULL,
  `project_id` int(5) NOT NULL,
  `task_id` int(5) NOT NULL,
  `EmployeeId` int(5) NOT NULL,
  `timesheetstart` datetime NOT NULL,
  `timesheetend` datetime NOT NULL,
  `OrganizationId` int(5) NOT NULL,
  `deletedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `OrganizationId` (`OrganizationId`),
  KEY `project_id` (`project_id`),
  KEY `task_id` (`task_id`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `onDeleteUserMaster`
--

CREATE TABLE IF NOT EXISTS `onDeleteUserMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Password` varchar(250) NOT NULL DEFAULT '',
  `Username` varchar(250) DEFAULT NULL,
  `userprofile` int(11) NOT NULL,
  `username_mobile` varchar(250) NOT NULL,
  `AadharNo` varchar(250) NOT NULL,
  `RoleId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `AdminSts` tinyint(1) NOT NULL,
  `VisibleSts` tinyint(1) NOT NULL DEFAULT '1',
  `appSuperviserSts` int(1) NOT NULL DEFAULT '0' COMMENT 'Permission for  Attendace dashboard in Application',
  `archive` int(1) NOT NULL DEFAULT '1',
  `resetPassCounter` int(3) NOT NULL DEFAULT '0' COMMENT 'this colom sill contain the counting of reset password and prevent the reusibility of same link to reset the password',
  `HRSts` int(11) NOT NULL DEFAULT '0',
  `AppId` text NOT NULL,
  `DeletedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `idx_app_login` (`Username`,`Password`),
  KEY `idx_org` (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96733 ;

-- --------------------------------------------------------

--
-- Table structure for table `Organization`
--

CREATE TABLE IF NOT EXISTS `Organization` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `countrycode` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT 'copuntry code',
  `PhoneNumber` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `AltPhoneNumber` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `AltEmail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Logo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `org_remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Country` int(10) unsigned NOT NULL,
  `City` int(10) unsigned NOT NULL,
  `ZipCode` int(10) unsigned NOT NULL,
  `Landmark` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Currency` int(10) unsigned NOT NULL,
  `DateFormat` int(10) unsigned NOT NULL DEFAULT '1',
  `TimeFormat` int(10) unsigned NOT NULL DEFAULT '7',
  `TimeZone` int(10) unsigned NOT NULL,
  `CreatedDate` date NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `AboutCompany` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `PlanId` int(10) unsigned NOT NULL,
  `NoOfEmp` int(10) NOT NULL,
  `HrmLink` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `no_admin` int(11) DEFAULT NULL,
  `startfiscalyear` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `endfiscalyear` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `mail_varified` int(1) NOT NULL COMMENT '0 not varified/ 1 varified',
  `cleaned_up` int(1) NOT NULL DEFAULT '0' COMMENT '0 is default, 1 for cleaned up automatically',
  `customize_org` int(1) NOT NULL DEFAULT '0' COMMENT '0 for standard package, 1 for customize ateendance app or sw',
  `delete_sts` int(1) NOT NULL DEFAULT '0' COMMENT '0 - Alive, 1 - Deteled',
  `mail_unsubscribe` int(11) NOT NULL,
  `smtpuser` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `Trial_sts` int(11) NOT NULL DEFAULT '0',
  `smtppassword` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ubihrm_sts` int(11) NOT NULL DEFAULT '0' COMMENT '0 means ubiattendance 1 means ubihrm',
  `ubihrm_setup_sts` tinyint(1) DEFAULT '0' COMMENT '0 for incomplete 1 for complete setup',
  `DataDeleteSts` int(11) NOT NULL DEFAULT '0' COMMENT '0 for not accepted, 1 is for accepted',
  `leadowner_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `platform` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `biometric_status` int(10) NOT NULL DEFAULT '0' COMMENT 'This field is used for biometric integration, 0 for inactive 1 for active',
  `SAP_Integration_status` int(10) NOT NULL DEFAULT '0' COMMENT 'This field is used for SAP integration, 0 for inactive 1 for active',
  PRIMARY KEY (`Id`),
  KEY `idx_org1` (`Id`,`Name`),
  KEY `idx_org` (`Id`),
  KEY `idx_org_new` (`Id`),
  KEY `idx_special_case` (`customize_org`),
  KEY `ubihrm_sts` (`ubihrm_sts`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41419 ;

-- --------------------------------------------------------

--
-- Table structure for table `OrgPermission`
--

CREATE TABLE IF NOT EXISTS `OrgPermission` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `OrgId` int(10) unsigned NOT NULL,
  `TabId` int(10) unsigned NOT NULL,
  `ModuleId` int(10) unsigned NOT NULL,
  `ViewPermission` tinyint(1) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrgId` (`OrgId`),
  KEY `TabId` (`TabId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10216 ;

-- --------------------------------------------------------

--
-- Table structure for table `OtherMaster`
--

CREATE TABLE IF NOT EXISTS `OtherMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `OtherType` varchar(45) DEFAULT NULL,
  `DisplayName` varchar(250) DEFAULT NULL,
  `ActualValue` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=109 ;

-- --------------------------------------------------------

--
-- Table structure for table `Overtime`
--

CREATE TABLE IF NOT EXISTS `Overtime` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` varchar(45) NOT NULL DEFAULT '',
  `OvertimeDate` date NOT NULL DEFAULT '0000-00-00',
  `TimeFrom` time DEFAULT NULL,
  `TimeTo` time DEFAULT NULL,
  `Reason` varchar(175) DEFAULT NULL,
  `ApproverId` varchar(45) NOT NULL DEFAULT '',
  `ApprovalSts` int(10) unsigned NOT NULL DEFAULT '3',
  `ApproverComment` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OrganizationId` int(11) NOT NULL,
  `totaltime` time NOT NULL,
  `attendanceSts` int(11) NOT NULL COMMENT '5 for holiday,3 for weekoff, 0for weekdays',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `TimeofDate` (`OvertimeDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `OvertimeApproval`
--

CREATE TABLE IF NOT EXISTS `OvertimeApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `OvertimeId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `ApproverSts` tinyint(3) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `TimeofId` (`OvertimeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

-- --------------------------------------------------------

--
-- Table structure for table `package_master`
--

CREATE TABLE IF NOT EXISTS `package_master` (
  `packege_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `packege_name` varchar(45) NOT NULL DEFAULT '',
  `plugins` varchar(100) NOT NULL DEFAULT '',
  `modules` varchar(250) NOT NULL,
  `price_inr` int(10) unsigned NOT NULL,
  `price_usd` int(10) unsigned NOT NULL,
  PRIMARY KEY (`packege_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `package_master_ubiattendance`
--

CREATE TABLE IF NOT EXISTS `package_master_ubiattendance` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(100) NOT NULL,
  `package_modules` varchar(255) NOT NULL,
  `package_price_inr_yr` int(11) NOT NULL DEFAULT '0',
  `package_price_usd_yr` int(11) NOT NULL DEFAULT '0',
  `per_user_inr` int(5) NOT NULL DEFAULT '0' COMMENT 'price for one user per for 1 year (365 days)@ inr',
  `per_user_usd` int(5) DEFAULT '0' COMMENT 'price for one user per for 1 year (365 days)@ usd',
  `discount` int(2) NOT NULL DEFAULT '0',
  `package_user_limit` int(11) NOT NULL DEFAULT '0',
  `package_date_modified` date NOT NULL,
  `modified_by` int(5) NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `package_master_ubiattendance_new`
--

CREATE TABLE IF NOT EXISTS `package_master_ubiattendance_new` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `packagename` varchar(255) NOT NULL,
  `baseinr` float(12,2) NOT NULL,
  `basedollar` float(12,2) NOT NULL,
  `priceperuserpermonthinr` float(12,2) NOT NULL,
  `priceperuserpermonthdollar` float(12,2) NOT NULL,
  `disinrupeeforinr` float(12,2) NOT NULL,
  `disindollarfordollar` float(12,2) NOT NULL,
  `disinperforinr` float(12,2) NOT NULL,
  `disinperfordollar` float(12,2) NOT NULL,
  `disinmonthforyearlyinr` int(1) NOT NULL,
  `disinmonthforyearlydollar` int(1) NOT NULL,
  `applogin` int(3) NOT NULL,
  `adminlogin` int(3) NOT NULL,
  `modified_date` datetime NOT NULL,
  `addonuseerpminr` float(12,2) NOT NULL,
  `addonuseerpmusd` float(12,2) NOT NULL,
  `igst` float(12,2) NOT NULL,
  `modules` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `PassportHistory`
--

CREATE TABLE IF NOT EXISTS `PassportHistory` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `PassportNumber` varchar(45) NOT NULL,
  `ExpiryDate` date NOT NULL,
  `TransactionType` varchar(250) NOT NULL,
  `IssueDate` date NOT NULL,
  `DepositDate` date NOT NULL,
  `Remarks` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payments_failed`
--

CREATE TABLE IF NOT EXISTS `payments_failed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txnid` varchar(100) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `payment_amount` float(10,2) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `createDate` date NOT NULL,
  `tax` float(10,2) NOT NULL,
  `discount` float(5,2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `street` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `indivisual_name` varchar(100) NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `action` varchar(25) NOT NULL DEFAULT 'BUY' COMMENT 'BUY/UPGRADE',
  `remark` varchar(250) NOT NULL COMMENT 'special comments by admin (if any)',
  `narration` text NOT NULL,
  `Addon_BulkAttn` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_LocationTracking` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_VisitPunch` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_GeoFence` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_Payroll` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_TimeOff` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_payment` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `txnid` (`txnid`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payments_invoice`
--

CREATE TABLE IF NOT EXISTS `payments_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txnid` varchar(100) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `payment_amount` float(10,2) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `createDate` date NOT NULL,
  `leadowner` int(10) NOT NULL,
  `tax` float(10,2) NOT NULL,
  `discount` float(5,2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `street` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `indivisual_name` varchar(100) NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `action` varchar(25) NOT NULL DEFAULT 'BUY' COMMENT 'BUY/UPGRADE',
  `payment_method` varchar(255) NOT NULL,
  `remark` varchar(250) NOT NULL COMMENT 'special comments by admin (if any)',
  `narration` text NOT NULL,
  `Addon_BulkAttn` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_LocationTracking` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_VisitPunch` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_GeoFence` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_Payroll` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Addon_TimeOff` decimal(10,2) NOT NULL DEFAULT '0.00',
  `due_payment` decimal(11,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `txnid` (`txnid`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `OrganizationId_2` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1631 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollChild`
--

CREATE TABLE IF NOT EXISTS `PayrollChild` (
  `SalaryId` int(10) unsigned NOT NULL,
  `HeadId` int(10) unsigned NOT NULL,
  `HeadType` tinyint(1) NOT NULL COMMENT '1 for earning and 2 for duduction',
  `HeadAmount` double NOT NULL,
  `HeadAddDeduct` tinyint(3) unsigned NOT NULL,
  `HeadDays` int(10) unsigned NOT NULL,
  KEY `HeadId` (`HeadId`),
  KEY `HeadType` (`HeadType`),
  KEY `SalaryId` (`SalaryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollESISettings`
--

CREATE TABLE IF NOT EXISTS `PayrollESISettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AllEmpSts` int(5) NOT NULL DEFAULT '0',
  `CreatedByid` int(11) DEFAULT NULL,
  `Created Date` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `EmployeeRate` double NOT NULL,
  `EmployeeSalaryType` int(1) NOT NULL,
  `EmployerRate` double NOT NULL,
  `EmployerSalaryType` int(1) NOT NULL,
  `EsiSts` int(1) NOT NULL,
  `SalaryType` int(1) NOT NULL COMMENT '1 for gross salary',
  `EmployeeIds` varchar(450) NOT NULL,
  `EmpChk` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for all employees, 2 for specific employees',
  `LocationId` varchar(450) NOT NULL,
  `esi_number` varchar(200) NOT NULL,
  `deduction_cycle` varchar(100) NOT NULL,
  `employees_contribution` decimal(10,2) NOT NULL,
  `employers_contribution` decimal(10,2) NOT NULL,
  `minemployee` int(11) NOT NULL,
  `minsalary` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollFinalSettlementHistory`
--

CREATE TABLE IF NOT EXISTS `PayrollFinalSettlementHistory` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `TotalAmount` float NOT NULL DEFAULT '0',
  `BalanceAmount` float NOT NULL DEFAULT '0',
  `PaidAmount` float NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollGenerateMonth`
--

CREATE TABLE IF NOT EXISTS `PayrollGenerateMonth` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SalaryMonth` date NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `SalaryMonth` (`SalaryMonth`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `payrollHeads`
--

CREATE TABLE IF NOT EXISTS `payrollHeads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `earning_name` varchar(200) NOT NULL,
  `payinslip_name` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL COMMENT '1 for earning and 4 for deduction',
  `category_id` int(6) NOT NULL,
  `calculation_type` enum('Flat Amount','Percent of Basic','Percent of CTC') DEFAULT NULL,
  `pay_type` enum('Fixed','Variable') DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `active_sts` enum('Active','Inactive') DEFAULT NULL,
  `include_in_ctc` enum('true','false') NOT NULL,
  `taxable_amount` enum('true','false') DEFAULT NULL,
  `pro_rata_basics` enum('true','false') DEFAULT NULL,
  `include_for_epf` enum('true','false') DEFAULT NULL,
  `include_for_esi` enum('true','false') DEFAULT NULL,
  `include_in_payinslip` enum('true','false') NOT NULL,
  `include_in_flexible_plan` enum('true','false') NOT NULL,
  `type_of_salary` varchar(255) NOT NULL COMMENT '1 for normal salary, 2 for final settlement head',
  `deduction_frequency` enum('One Time','Recurring') DEFAULT NULL,
  `tax_deduction` enum('pre','post','Normal') DEFAULT NULL,
  `is_tax_deduction_preference` enum('true','false') NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `payroll_id` int(11) NOT NULL,
  `permission_sts` enum('0','1') NOT NULL,
  `delete_sts` enum('0','1') NOT NULL,
  `is_variable` set('true','false') NOT NULL COMMENT ' false for Fixed  Type, true for Variable Type ',
  PRIMARY KEY (`id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `OrganizationId_2` (`OrganizationId`),
  KEY `earning_category` (`category_id`),
  KEY `tax_deduction` (`tax_deduction`),
  KEY `category_id` (`category_id`),
  KEY `calculation_type` (`calculation_type`),
  KEY `active_sts` (`active_sts`),
  KEY `include_in_payinslip` (`include_in_payinslip`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `payrollHeadsDefault`
--

CREATE TABLE IF NOT EXISTS `payrollHeadsDefault` (
  `payroll_id` int(11) NOT NULL AUTO_INCREMENT,
  `earning_name` varchar(200) NOT NULL,
  `payinslip_name` varchar(200) NOT NULL,
  `type` tinyint(2) NOT NULL COMMENT '1 for earning, 4 for deduction',
  `category_id` int(6) NOT NULL,
  `calculation_type` enum('Flat Amount','Percent of Basic','Percent of CTC') DEFAULT NULL,
  `pay_type` enum('Fixed','Variable','') DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL,
  `active_sts` enum('Inactive','Active') NOT NULL DEFAULT 'Inactive',
  `include_in_ctc` enum('','true','false') NOT NULL,
  `taxable_amount` enum('true','false') DEFAULT NULL,
  `pro_rata_basics` enum('true','false') DEFAULT NULL,
  `include_for_epf` enum('true','false') DEFAULT NULL,
  `include_for_esi` enum('true','false') DEFAULT NULL,
  `include_in_payinslip` enum('','true','false') DEFAULT NULL,
  `include_in_flexible_plan` enum('true','false') DEFAULT NULL,
  `type_of_salary` varchar(255) NOT NULL COMMENT '1 for normal salary, 2 for final settlement head',
  `deduction_frequency` enum('One Time','Recurring') DEFAULT NULL,
  `tax_deduction` int(11) DEFAULT NULL COMMENT '1 for pre deduction ,2 for post,3 for tax deduction',
  `is_tax_deduction_preference` enum('true','false') DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL COMMENT '1 is used for cannot delete category once assigned',
  `is_variable` set('true','false') NOT NULL COMMENT 'false for fixed, true for variable',
  PRIMARY KEY (`payroll_id`),
  KEY `earning_category` (`category_id`),
  KEY `tax_deduction` (`tax_deduction`),
  KEY `category_id` (`category_id`),
  KEY `is_delete` (`is_delete`),
  KEY `active_sts` (`active_sts`),
  KEY `pay_type` (`pay_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollHistory`
--

CREATE TABLE IF NOT EXISTS `PayrollHistory` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `HeadId` int(10) unsigned NOT NULL,
  `HeadType` int(10) unsigned NOT NULL,
  `HeadAmount` double NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=688 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollMaster`
--

CREATE TABLE IF NOT EXISTS `PayrollMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FiscalId` int(10) unsigned NOT NULL,
  `EmployeeId` int(10) unsigned NOT NULL,
  `SalaryMonth` date NOT NULL,
  `EmployeeCTC` double NOT NULL,
  `PaidDays` float NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `FinalSettlementSts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 if employee exit from company ',
  `BankName` varchar(45) NOT NULL,
  `BankCode` varchar(250) DEFAULT NULL,
  `BankAccountNo` varchar(250) DEFAULT NULL,
  `Description` varchar(250) NOT NULL,
  `agent_id` varchar(100) DEFAULT NULL,
  `ModePayment` int(11) NOT NULL,
  `FinalStatus` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1  means salary generated & 0 means salary not generated',
  `HoldStatus` tinyint(1) NOT NULL DEFAULT '0',
  `VisibleStatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 means salary will show in payroll and 0 is for hide it from payroll',
  `RemainingLateIns` int(11) NOT NULL DEFAULT '0' COMMENT 'Late Coming Instances which will use in next month',
  `RemainingEarlyIns` int(11) NOT NULL DEFAULT '0' COMMENT 'Early Leaving Instances which will use in next month',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `SalaryMonth` (`SalaryMonth`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `FinalStatus` (`FinalStatus`),
  KEY `VisibleStatus` (`VisibleStatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollPaidDays`
--

CREATE TABLE IF NOT EXISTS `PayrollPaidDays` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PaidDays` double NOT NULL,
  `Weekoffs` int(11) NOT NULL,
  `Holidays` tinyint(1) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollPenaltyMaster`
--

CREATE TABLE IF NOT EXISTS `PayrollPenaltyMaster` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `LateComing` int(11) NOT NULL,
  `lateInstance` int(11) NOT NULL,
  `lateDeduct` int(11) NOT NULL,
  `lateSalaryType` int(11) NOT NULL,
  `Earlyleaving` int(11) NOT NULL,
  `EarlyInstance` int(11) NOT NULL,
  `EarlyDeduct` int(11) NOT NULL,
  `EarlySalaryType` int(11) NOT NULL,
  `AbsentUnautorized` int(11) NOT NULL,
  `AbsentDeduct` int(11) NOT NULL,
  `AbsentSalaryType` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `EmpChk` int(11) NOT NULL,
  `DivisionId` varchar(450) COLLATE utf8_unicode_ci NOT NULL,
  `DepartmentId` varchar(450) COLLATE utf8_unicode_ci NOT NULL,
  `EmployeeIds` varchar(450) COLLATE utf8_unicode_ci NOT NULL,
  `lateHours` int(1) NOT NULL,
  `earlyHours` int(1) NOT NULL,
  `lateDeductCheck` enum('true','false') COLLATE utf8_unicode_ci NOT NULL,
  `earlyDeductCheck` enum('true','false') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollPFSettings`
--

CREATE TABLE IF NOT EXISTS `PayrollPFSettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `MinimumSalary` double DEFAULT NULL,
  `MinimumEmployee` int(11) DEFAULT NULL,
  `CreatedByid` int(11) DEFAULT NULL,
  `Created Date` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `PfSts` int(1) NOT NULL,
  `EmployeeIds` varchar(450) NOT NULL,
  `EmpChk` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for all employees, 2 for specific employees',
  `LocationId` varchar(450) NOT NULL,
  `MaxAmountforEmployer` int(11) DEFAULT NULL,
  `is_include_ctc` enum('','true','false') NOT NULL,
  `is_include_pro_rate` enum('','true','false') NOT NULL,
  `is_include_pro_rate_no_of_days` enum('','true','false') NOT NULL,
  `is_include_pf_contribution_rate` enum('','true','false') NOT NULL,
  `epf_number` varchar(200) NOT NULL,
  `deduction_cycle` varchar(200) NOT NULL,
  `employer_contribution_rate` varchar(200) NOT NULL COMMENT 'false for  Percent of Actual PF Wages and true for Restrict Contribution of PF Wages  ',
  `employee_contribution_rate` varchar(100) NOT NULL COMMENT 'false for Percent of Actual PF Wages and true for Restrict Contribution of PF Wages',
  `amount` varchar(200) NOT NULL,
  `employee_amount` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollProfessionalTaxSettings`
--

CREATE TABLE IF NOT EXISTS `PayrollProfessionalTaxSettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TaxSts` int(11) NOT NULL,
  `MinimumSalary` double NOT NULL,
  `MaximumSalary` double NOT NULL,
  `Months` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TaxRate` double NOT NULL,
  `DivisionId` int(11) NOT NULL COMMENT 'In this column we are saving locationid from 11/22/2019',
  `DepartmentId` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EmployeeIds` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EmpChk` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedByid` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ptnumber` varchar(200) NOT NULL,
  `deduction_cycle` varchar(200) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `MinimumSalary` (`MinimumSalary`),
  KEY `MaximumSalary` (`MaximumSalary`),
  KEY `Months` (`Months`(255))
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `payrollProvidentFundMaster`
--

CREATE TABLE IF NOT EXISTS `payrollProvidentFundMaster` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `EmployeePF` double NOT NULL DEFAULT '0',
  `EmployerPF` double NOT NULL DEFAULT '0',
  `EmployeeESI` double NOT NULL,
  `EmployerESI` double NOT NULL,
  `Total` int(30) NOT NULL,
  `SalaryMonth` date NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `SalaryId` int(10) NOT NULL,
  `ModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `SalaryMonth` (`SalaryMonth`),
  KEY `SalaryId` (`SalaryId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollTypeChild`
--

CREATE TABLE IF NOT EXISTS `PayrollTypeChild` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `SalaryId` int(10) unsigned NOT NULL,
  `payrollHeadId` int(10) unsigned NOT NULL,
  `Type` int(11) NOT NULL COMMENT '1 for eaning , 2 for fixed and basic, 4 for deduction',
  `calculation_type` enum('Flat Amount','Percent of Basic','Percent of CTC','Fixed amount') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `SalaryId` (`SalaryId`),
  KEY `payrollHeadId` (`payrollHeadId`),
  KEY `Type` (`Type`),
  KEY `calculation_type` (`calculation_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `PayrollTypeMaster`
--

CREATE TABLE IF NOT EXISTS `PayrollTypeMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `DivisionId` int(11) NOT NULL,
  `GradeId` int(11) NOT NULL,
  `DepartmentIds` int(11) NOT NULL,
  `EmployeeExperience` int(11) NOT NULL,
  `SalaryAmount` int(11) NOT NULL,
  `exptype` int(11) NOT NULL,
  `DesignationIds` int(11) NOT NULL,
  `SalaryApply` date DEFAULT NULL,
  `Description` varchar(250) DEFAULT NULL,
  `SalaryRangeMin` double DEFAULT NULL,
  `SalaryRangeMax` double DEFAULT NULL,
  `EmployeeId` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_category`
--

CREATE TABLE IF NOT EXISTS `payroll_category` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `category_type` tinyint(2) NOT NULL COMMENT '1 for earning, 4 for deduction',
  `sorting` int(30) DEFAULT NULL,
  `deduction_type` int(11) NOT NULL COMMENT '1 for pre deduction ,2 for post,3 for tax deduction',
  PRIMARY KEY (`id`),
  KEY `deduction_type` (`deduction_type`),
  KEY `category_type` (`category_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_configuration`
--

CREATE TABLE IF NOT EXISTS `payroll_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `can_change_calculate_type` enum('','true','false') NOT NULL,
  `can_change_pay_type` enum('','true','false') NOT NULL,
  `can_change_epf` enum('','true','false') NOT NULL,
  `can_change_esi` enum('','true','false') NOT NULL,
  `can_change_pro_rata` enum('','true','false') NOT NULL,
  `can_cange_tax_deduction_preference` enum('true','false') DEFAULT NULL,
  `can_include_as_fbp` enum('','true','false') NOT NULL,
  `is_included_in_ctc` enum('','true','false') NOT NULL,
  `is_included_in_epf` enum('','true','false') NOT NULL,
  `is_included_in_esi` enum('','true','false') NOT NULL,
  `is_pro_rata` enum('true','false') NOT NULL,
  `is_taxable` enum('true','false') NOT NULL,
  `show_in_payslip` enum('','true','false') NOT NULL,
  `is_variable` set('true','false') NOT NULL COMMENT 'false for fixed, true for variable',
  `category_status` enum('','0','1') NOT NULL,
  `is_delete_sts` enum('0','1') NOT NULL COMMENT '1 is used for cannot delete category once assigned',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  KEY `is_variable` (`is_variable`),
  KEY `category_status` (`category_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `PenaltyMaster`
--

CREATE TABLE IF NOT EXISTS `PenaltyMaster` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `LateComing` int(11) NOT NULL,
  `lateInstance` int(11) NOT NULL,
  `lateDeduct` int(11) NOT NULL,
  `lateSalaryType` int(11) NOT NULL,
  `Earlyleaving` int(11) NOT NULL,
  `EarlyInstance` int(11) NOT NULL,
  `EarlyDeduct` int(11) NOT NULL,
  `EarlySalaryType` int(11) NOT NULL,
  `AbsentUnautorized` int(11) NOT NULL,
  `AbsentDeduct` int(11) NOT NULL,
  `AbsentSalaryType` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `EmpChk` int(11) NOT NULL,
  `DivisionId` varchar(450) COLLATE utf8_unicode_ci NOT NULL,
  `DepartmentId` varchar(450) COLLATE utf8_unicode_ci NOT NULL,
  `EmployeeIds` varchar(450) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `PerformanceOverAchieve`
--

CREATE TABLE IF NOT EXISTS `PerformanceOverAchieve` (
  `MinMarks` double NOT NULL,
  `MaxMarks` double NOT NULL,
  `Amount` double NOT NULL,
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `AssessmentObjectiveId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `AssessmentObjectiveId` (`AssessmentObjectiveId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `performance_indicator_master`
--

CREATE TABLE IF NOT EXISTS `performance_indicator_master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attribute` varchar(255) NOT NULL DEFAULT '',
  `marks` double NOT NULL DEFAULT '0',
  `bonus_point` varchar(45) DEFAULT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `PersonnelRequisition`
--

CREATE TABLE IF NOT EXISTS `PersonnelRequisition` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DesignationId` int(10) unsigned NOT NULL DEFAULT '0',
  `TotalVacancy` int(10) unsigned NOT NULL DEFAULT '0',
  `SalaryRange` varchar(100) DEFAULT NULL,
  `NationalityId` int(10) unsigned NOT NULL DEFAULT '0',
  `GenderId` int(10) unsigned NOT NULL DEFAULT '0',
  `AgeRange` varchar(100) DEFAULT NULL,
  `PositionType` tinyint(1) NOT NULL DEFAULT '0',
  `EmploymentType` int(10) unsigned NOT NULL DEFAULT '0',
  `MinQualification` int(10) unsigned NOT NULL DEFAULT '0',
  `Experience` varchar(100) DEFAULT NULL,
  `BudgetApproval` int(10) unsigned NOT NULL DEFAULT '0',
  `SelectionPeriod` int(10) unsigned NOT NULL DEFAULT '0',
  `Description` text,
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `ApplyDate` date NOT NULL DEFAULT '0000-00-00',
  `ApproverSts` tinyint(1) NOT NULL DEFAULT '0',
  `ApproverComment` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `DesignationId` (`DesignationId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `PersonnelRequisitionApproval`
--

CREATE TABLE IF NOT EXISTS `PersonnelRequisitionApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PersonnelRequisitionId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `ApproverSts` tinyint(3) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `PersonnelRequisitionId` (`PersonnelRequisitionId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `PFSettings`
--

CREATE TABLE IF NOT EXISTS `PFSettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `MinimumSalary` double DEFAULT NULL,
  `MinimumEmployee` int(11) DEFAULT NULL,
  `Period` int(11) DEFAULT NULL,
  `CreatedByid` int(11) DEFAULT NULL,
  `Created Date` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `EmployeeRate` double NOT NULL,
  `EmployeeSalaryType` int(1) NOT NULL,
  `EmployerRate` double NOT NULL,
  `EmployerSalaryType` int(1) NOT NULL,
  `Rate` double NOT NULL,
  `PfSts` int(1) NOT NULL,
  `SalaryType` int(1) NOT NULL,
  `MaxAmount` double NOT NULL,
  `DivisionId` varchar(450) NOT NULL,
  `DepartmentId` varchar(450) NOT NULL,
  `GradeId` varchar(450) NOT NULL,
  `MinYear` int(11) NOT NULL,
  `MaxYear` int(11) NOT NULL,
  `EmployeeIds` varchar(450) NOT NULL,
  `EmpChk` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for all employees, 2 for specific employees',
  `LocationId` varchar(450) NOT NULL,
  `MaxAmountforEmployer` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `PFSettingsChild`
--

CREATE TABLE IF NOT EXISTS `PFSettingsChild` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `MinSalary` double NOT NULL,
  `MaxSalary` double NOT NULL,
  `Type` int(11) NOT NULL,
  `Value` double NOT NULL,
  `SalaryType` int(11) NOT NULL,
  `SettingsId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pi_child`
--

CREATE TABLE IF NOT EXISTS `pi_child` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pi_id` varchar(45) NOT NULL DEFAULT '',
  `attributes` varchar(255) NOT NULL DEFAULT '',
  `mark` int(10) unsigned NOT NULL DEFAULT '0',
  `obtain_mark` int(10) unsigned NOT NULL DEFAULT '0',
  `bonus_mark` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pi_id` (`pi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pi_master`
--

CREATE TABLE IF NOT EXISTS `pi_master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `emp_id` varchar(45) NOT NULL DEFAULT '',
  `designation_id` varchar(45) NOT NULL DEFAULT '',
  `month` date DEFAULT NULL,
  `pi_date` date NOT NULL DEFAULT '0000-00-00',
  `marks` int(10) unsigned NOT NULL DEFAULT '0',
  `obtain_marks` int(10) unsigned NOT NULL DEFAULT '0',
  `bonus_marks` int(10) unsigned DEFAULT NULL,
  `assigndby` varchar(45) NOT NULL DEFAULT '',
  `remarks` varchar(255) DEFAULT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `fiscal_id` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `PlayStore`
--

CREATE TABLE IF NOT EXISTS `PlayStore` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `googlepath` varchar(255) NOT NULL,
  `applepath` varchar(255) NOT NULL,
  `android_version` varchar(50) NOT NULL COMMENT 'can not be blank otherwise android app may stop working ',
  `ios_version` varchar(50) NOT NULL COMMENT 'can not be blank otherwise ios app may stop working ',
  `is_mandatory_android` int(1) NOT NULL DEFAULT '0' COMMENT '1,if update is mandatory,0 if update is optional',
  `alert_popup_android` int(2) NOT NULL,
  `alert_popup_ios` int(2) NOT NULL,
  `is_mandatory_ios` int(1) NOT NULL DEFAULT '0' COMMENT '1,if update is mandatory,0 if update is optional',
  `orgid` int(11) NOT NULL DEFAULT '0' COMMENT 'To manage versions for customize packages',
  PRIMARY KEY (`id`),
  KEY `orgid` (`orgid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `PolicyMaster`
--

CREATE TABLE IF NOT EXISTS `PolicyMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryId` int(10) unsigned NOT NULL,
  `Name` text,
  `ApplyDate` date DEFAULT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `attachfile` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `CategoryId` (`CategoryId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProfessionalTaxSettings`
--

CREATE TABLE IF NOT EXISTS `ProfessionalTaxSettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `TaxSts` int(11) NOT NULL,
  `MinimumSalary` double NOT NULL,
  `MaximumSalary` double NOT NULL,
  `Months` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `TaxRate` double NOT NULL,
  `DivisionId` int(11) NOT NULL,
  `DepartmentId` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EmployeeIds` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `EmpChk` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedByid` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProjectEmployeeCost`
--

CREATE TABLE IF NOT EXISTS `ProjectEmployeeCost` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ProjectId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `EmployeeCost` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `ProjectId` (`ProjectId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProjectMilestoneCost`
--

CREATE TABLE IF NOT EXISTS `ProjectMilestoneCost` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Projectid` int(11) NOT NULL,
  `MileStoneId` int(11) NOT NULL,
  `MileStoneCost` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Projectid` (`Projectid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProjectTypeMaster`
--

CREATE TABLE IF NOT EXISTS `ProjectTypeMaster` (
  `Id` int(9) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) NOT NULL,
  `Description` text NOT NULL,
  `ModifiedDate` datetime NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ModifiedById` int(9) NOT NULL,
  `CreatedById` int(9) NOT NULL,
  `OrganizationId` int(9) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_master`
--

CREATE TABLE IF NOT EXISTS `project_master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_no` varchar(100) NOT NULL,
  `project_title` varchar(100) NOT NULL DEFAULT '',
  `estimated_date` date NOT NULL DEFAULT '0000-00-00',
  `created_date` date NOT NULL DEFAULT '0000-00-00',
  `start_date` date NOT NULL DEFAULT '0000-00-00',
  `completed_date` date NOT NULL DEFAULT '0000-00-00',
  `project_status` varchar(45) NOT NULL DEFAULT '',
  `owner_id` int(10) unsigned NOT NULL DEFAULT '0',
  `project_desc` text NOT NULL,
  `updated_by` int(10) unsigned NOT NULL,
  `update_on` datetime NOT NULL,
  `assigned_to` varchar(255) NOT NULL,
  `project_reopen_count` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL,
  `milestones` varchar(50) NOT NULL,
  `ProjectTypeId` int(11) NOT NULL,
  `Billingsts` tinyint(1) NOT NULL DEFAULT '1',
  `ProjectDoc` varchar(250) NOT NULL,
  `BillingMethod` int(11) NOT NULL,
  `CostProject` int(11) NOT NULL,
  `ClientManager` int(11) NOT NULL,
  `ProjectBudget` varchar(200) NOT NULL,
  `ProjectLead` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=237 ;

-- --------------------------------------------------------

--
-- Table structure for table `PromoMaster`
--

CREATE TABLE IF NOT EXISTS `PromoMaster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notification_id` int(11) NOT NULL,
  `promocode_title` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `discount_type` varchar(255) NOT NULL,
  `discount` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `ProvidentFundMaster`
--

CREATE TABLE IF NOT EXISTS `ProvidentFundMaster` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `EmployeePF` double NOT NULL DEFAULT '0',
  `EmployerPF` double NOT NULL DEFAULT '0',
  `EmployeeESI` double NOT NULL,
  `EmployerESI` double NOT NULL,
  `Total` int(30) NOT NULL,
  `SalaryMonth` date NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `SalaryId` int(10) NOT NULL,
  `ModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10645 ;

-- --------------------------------------------------------

--
-- Table structure for table `pushnotification`
--

CREATE TABLE IF NOT EXISTS `pushnotification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0 for preconfigured, 1 for automatic',
  `event` text NOT NULL,
  `sendingdate` date NOT NULL COMMENT '0000-00-00 for sent notifications and date for notification for configured date',
  `organization` int(11) NOT NULL DEFAULT '0' COMMENT '0 = all,1=trial,2=extended trial,3=expired trial,4=premium standard,5 =premium customized,6=premium expired,7=premium exceeded user',
  `countryid` text NOT NULL COMMENT '0 for all and id as per country table',
  `createddate` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0 not sent, 1 sent',
  `lastmodifieddate` date NOT NULL,
  `group` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Table structure for table `Quadrants`
--

CREATE TABLE IF NOT EXISTS `Quadrants` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Color` varchar(100) NOT NULL DEFAULT '',
  `Description` varchar(250) NOT NULL,
  `CompType` int(11) NOT NULL,
  `Designation` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

-- --------------------------------------------------------

--
-- Table structure for table `QualificationTable`
--

CREATE TABLE IF NOT EXISTS `QualificationTable` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryId` int(10) unsigned NOT NULL,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=161 ;

-- --------------------------------------------------------

--
-- Table structure for table `Referrals`
--

CREATE TABLE IF NOT EXISTS `Referrals` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `ReferringOrg` int(10) NOT NULL COMMENT 'Organization id of the employee who referred the app',
  `ReferrerId` int(10) NOT NULL COMMENT 'Id of employee who referred the app',
  `ReferrencedOrg` int(10) NOT NULL COMMENT 'Organization Id of the Employee who got the referrence',
  `ReferenceId` int(10) NOT NULL COMMENT 'Id of employee who got the referrence',
  `DiscountForReferrer` decimal(20,0) NOT NULL DEFAULT '0',
  `DiscountForReferrence` decimal(20,0) NOT NULL DEFAULT '0',
  `DiscountType` int(10) NOT NULL DEFAULT '0' COMMENT '0 for Rupees 1 for Dollars 2 for Percentage',
  `DiscountCurrency` int(10) NOT NULL DEFAULT '0' COMMENT '0 for INR 1 for USD',
  `PaymentStatus` int(10) NOT NULL DEFAULT '0',
  `ReferrenceDate` datetime NOT NULL,
  `PaymentInvoiceId` int(10) NOT NULL DEFAULT '0',
  `ReferrerGivenDiscount` int(10) NOT NULL DEFAULT '0' COMMENT '1 if referrer has used his discount 0 otherwise',
  `ReferrrenceGivenDiscount` int(10) NOT NULL DEFAULT '0' COMMENT '1 if Reference has used his discount',
  `ReferrerDiscountType` int(10) NOT NULL COMMENT 'Same as current referrence discount table',
  `ReferenceDiscountType` int(10) NOT NULL COMMENT 'Same as current referrence discount table',
  PRIMARY KEY (`Id`),
  KEY `ReferringOrg` (`ReferringOrg`),
  KEY `ReferrerId` (`ReferrerId`),
  KEY `ReferenceId` (`ReferenceId`),
  KEY `PaymentStatus` (`PaymentStatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `RegularizationSettings`
--

CREATE TABLE IF NOT EXISTS `RegularizationSettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `RegularizationSts` tinyint(1) NOT NULL,
  `MinTimes` int(11) NOT NULL,
  `MaxDays` int(11) NOT NULL,
  `EmpChk` tinyint(1) NOT NULL DEFAULT '1',
  `DivisionId` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `DepartmentId` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ShiftId` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `EmployeeIds` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `CreatedByid` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ModifiedDate` datetime NOT NULL,
  `ModifiedBy` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `RelatedListMaster`
--

CREATE TABLE IF NOT EXISTS `RelatedListMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ListName` varchar(45) NOT NULL DEFAULT '',
  `ParentObject` varchar(145) NOT NULL DEFAULT '',
  `ChildObject` varchar(145) NOT NULL DEFAULT '',
  `ParentId` varchar(45) NOT NULL DEFAULT '',
  `DisplayFields` varchar(255) NOT NULL DEFAULT '',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedBy` int(3) unsigned NOT NULL DEFAULT '0',
  `LastModifiedById` int(3) unsigned NOT NULL DEFAULT '0',
  `Sts` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `RelationMaster`
--

CREATE TABLE IF NOT EXISTS `RelationMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

--
-- Table structure for table `ReligionMaster`
--

CREATE TABLE IF NOT EXISTS `ReligionMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

-- --------------------------------------------------------

--
-- Table structure for table `ReopenProjectHistory`
--

CREATE TABLE IF NOT EXISTS `ReopenProjectHistory` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `projectId` int(11) NOT NULL,
  `startreopeddate` date NOT NULL,
  `endreopenddate` date NOT NULL,
  `projectstatus` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `projectId` (`projectId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ReportDefaultMaster`
--

CREATE TABLE IF NOT EXISTS `ReportDefaultMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `TabId` int(10) unsigned NOT NULL DEFAULT '0',
  `CustomSts` mediumint(1) NOT NULL DEFAULT '0',
  `Defaultsts` int(11) NOT NULL DEFAULT '0' COMMENT '1 for default report',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=332 ;

-- --------------------------------------------------------

--
-- Table structure for table `ReportFilterMaster`
--

CREATE TABLE IF NOT EXISTS `ReportFilterMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ReportId` varchar(45) NOT NULL DEFAULT '',
  `Condition1` varchar(100) NOT NULL DEFAULT '',
  `SelectedColumn` varchar(100) NOT NULL DEFAULT '',
  `Condition2` varchar(100) NOT NULL DEFAULT '',
  `TextValue` varchar(150) NOT NULL DEFAULT '',
  `ModuleChildId` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `ReportId` (`ReportId`),
  KEY `ModuleChildId` (`ModuleChildId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1326 ;

-- --------------------------------------------------------

--
-- Table structure for table `ReportMaster`
--

CREATE TABLE IF NOT EXISTS `ReportMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `ModuleId` varchar(50) NOT NULL DEFAULT '',
  `SelectedColumn` text,
  `TabId` int(10) unsigned NOT NULL DEFAULT '0',
  `SelectedGroupBy` varchar(250) NOT NULL DEFAULT '',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `ReportType` tinyint(1) NOT NULL DEFAULT '0',
  `TotalColumn` varchar(100) NOT NULL DEFAULT '',
  `CustomSts` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `TabId` (`TabId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1054 ;

-- --------------------------------------------------------

--
-- Table structure for table `ResignationApproval`
--

CREATE TABLE IF NOT EXISTS `ResignationApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ResignationId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `LeaveStatus` tinyint(3) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `ResignationId` (`ResignationId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=325 ;

-- --------------------------------------------------------

--
-- Table structure for table `RoleMaster`
--

CREATE TABLE IF NOT EXISTS `RoleMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(80) DEFAULT NULL,
  `ParentRoleId` varchar(25) DEFAULT NULL,
  `Description` varchar(80) DEFAULT NULL,
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(3) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `ParentRoleId` (`ParentRoleId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryAdvance`
--

CREATE TABLE IF NOT EXISTS `SalaryAdvance` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `AdvanceAmount` double NOT NULL,
  `InstallmentAmt` double NOT NULL,
  `ApprovedBy` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Remarks` varchar(250) DEFAULT NULL,
  `ApplyMonth` date NOT NULL,
  `LeaveStatus` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `FiscalId` int(10) unsigned NOT NULL,
  `LoanSTs` tinyint(1) NOT NULL,
  `CloseDate` date NOT NULL,
  `CloseAmount` double NOT NULL,
  `MonthlyInstallment` double DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `ApplyMonth` (`ApplyMonth`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=149 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryAdvanceAdjustment`
--

CREATE TABLE IF NOT EXISTS `SalaryAdvanceAdjustment` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `salaryadvanceid` int(11) NOT NULL,
  `adjustmentamt` int(11) NOT NULL,
  `adjustmentdate` date NOT NULL,
  `remarks` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `salaryadvanceid` (`salaryadvanceid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryAdvanceChild`
--

CREATE TABLE IF NOT EXISTS `SalaryAdvanceChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SalaryAdvanceId` int(10) unsigned NOT NULL,
  `InstMonth` date NOT NULL,
  `InstAmount` float NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `SalaryAdvanceId` (`SalaryAdvanceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9436 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryAdvanceChildLoan`
--

CREATE TABLE IF NOT EXISTS `SalaryAdvanceChildLoan` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SalaryAdvanceId` int(10) unsigned NOT NULL,
  `InstMonth` date NOT NULL,
  `InstAmount` float NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `SalaryAdvanceId` (`SalaryAdvanceId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=999 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryAdvanceLoan`
--

CREATE TABLE IF NOT EXISTS `SalaryAdvanceLoan` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `AdvanceAmount` double NOT NULL,
  `InstallmentAmt` double NOT NULL,
  `ApprovedBy` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Remarks` varchar(250) DEFAULT NULL,
  `ApplyMonth` date NOT NULL,
  `LeaveStatus` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `FiscalId` int(10) unsigned NOT NULL,
  `LoanSTs` tinyint(1) NOT NULL,
  `CloseDate` date NOT NULL,
  `CloseAmount` double NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `ApplyMonth` (`ApplyMonth`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryApproval`
--

CREATE TABLE IF NOT EXISTS `SalaryApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SalaryAdvanceId` int(10) unsigned DEFAULT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `LeaveStatus` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `SalaryAdvanceId` (`SalaryAdvanceId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryApprovalLoan`
--

CREATE TABLE IF NOT EXISTS `SalaryApprovalLoan` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SalaryAdvanceId` int(10) unsigned DEFAULT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `LeaveStatus` tinyint(3) unsigned NOT NULL DEFAULT '3',
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `SalaryAdvanceId` (`SalaryAdvanceId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryCheckList`
--

CREATE TABLE IF NOT EXISTS `SalaryCheckList` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryChild`
--

CREATE TABLE IF NOT EXISTS `SalaryChild` (
  `SalaryId` int(10) unsigned NOT NULL,
  `HeadId` int(10) unsigned NOT NULL,
  `HeadType` tinyint(1) NOT NULL COMMENT 'SalaryHead or SalaryOtherHead',
  `HeadAmount` double NOT NULL,
  `HeadAddDeduct` tinyint(3) unsigned NOT NULL,
  `HeadDays` int(10) unsigned NOT NULL,
  KEY `HeadId` (`HeadId`),
  KEY `HeadType` (`HeadType`),
  KEY `SalaryId` (`SalaryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryDistributionChild`
--

CREATE TABLE IF NOT EXISTS `SalaryDistributionChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `GradeId` int(10) unsigned NOT NULL,
  `ExpYears` varchar(10) NOT NULL,
  `SalaryRangeMin` double DEFAULT NULL,
  `PayPattern` tinyint(1) NOT NULL,
  `SalaryType` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `SalaryRangeMax` double DEFAULT NULL,
  `ExpType` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryGenerateMonth`
--

CREATE TABLE IF NOT EXISTS `SalaryGenerateMonth` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SalaryMonth` date NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `SalaryMonth` (`SalaryMonth`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=199 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryHead`
--

CREATE TABLE IF NOT EXISTS `SalaryHead` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `HeadType` tinyint(1) NOT NULL,
  `IncludeInPayslip` tinyint(1) DEFAULT NULL,
  `ApplyDate` date DEFAULT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(100) DEFAULT NULL,
  `Main` varchar(250) NOT NULL,
  `Sub` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `WorkDaysSts` int(11) DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=193 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryHistory`
--

CREATE TABLE IF NOT EXISTS `SalaryHistory` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `HeadId` int(10) unsigned NOT NULL,
  `HeadType` int(10) unsigned NOT NULL,
  `HeadAmount` double NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=179 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryMaster`
--

CREATE TABLE IF NOT EXISTS `SalaryMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FiscalId` int(10) unsigned NOT NULL,
  `EmployeeId` int(10) unsigned NOT NULL,
  `SalaryMonth` date NOT NULL,
  `EmployeeCTC` double NOT NULL,
  `PaidDays` float NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `FinalSettlementSts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 if employee exit from company ',
  `BankName` varchar(45) NOT NULL,
  `BankCode` varchar(250) DEFAULT NULL,
  `BankAccountNo` varchar(250) DEFAULT NULL,
  `Description` varchar(250) NOT NULL,
  `agent_id` varchar(100) DEFAULT NULL,
  `ModePayment` int(11) NOT NULL,
  `FinalStatus` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1  means salary generated & 0 means salary not generated',
  `HoldStatus` tinyint(1) NOT NULL DEFAULT '0',
  `VisibleStatus` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 means salary will show in payroll and 0 is for hide it from payroll',
  `RemainingLateIns` int(11) NOT NULL DEFAULT '0' COMMENT 'Late Coming Instances which will use in next month',
  `RemainingEarlyIns` int(11) NOT NULL DEFAULT '0' COMMENT 'Early Leaving Instances which will use in next month',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `SalaryMonth` (`SalaryMonth`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18740 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryOtherHead`
--

CREATE TABLE IF NOT EXISTS `SalaryOtherHead` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Type` tinyint(1) NOT NULL,
  `HeadSts` tinyint(1) NOT NULL DEFAULT '1',
  `IncludeInPayslip` tinyint(1) NOT NULL,
  `ActiveSts` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for active 2 for inactive',
  `OrganizationId` int(11) NOT NULL,
  `HeadCode` int(11) NOT NULL,
  `Code` varchar(250) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `Sub` varchar(100) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1046 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryOtherHeadDefault`
--

CREATE TABLE IF NOT EXISTS `SalaryOtherHeadDefault` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Type` tinyint(1) NOT NULL COMMENT '0 for deduction 1 for addition 2 for fund',
  `HeadSts` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 for final settlement 1 for salary',
  `IncludeInPayslip` tinyint(1) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryPaidDays`
--

CREATE TABLE IF NOT EXISTS `SalaryPaidDays` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `PaidDays` double NOT NULL,
  `Weekoffs` int(11) NOT NULL,
  `Holidays` tinyint(1) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryTypeChild`
--

CREATE TABLE IF NOT EXISTS `SalaryTypeChild` (
  `SalaryId` int(10) unsigned NOT NULL,
  `SalaryHeadId` int(10) unsigned NOT NULL,
  `SalaryPercent` float NOT NULL,
  `IsPercent` tinyint(1) NOT NULL DEFAULT '0',
  `Type` int(11) DEFAULT NULL COMMENT '1 for annualctc , 2 for gross salary, 3 for basic salary',
  KEY `SalaryHeadId` (`SalaryHeadId`),
  KEY `SalaryId` (`SalaryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SalaryTypeMaster`
--

CREATE TABLE IF NOT EXISTS `SalaryTypeMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `DivisionId` int(11) NOT NULL,
  `GradeId` int(11) NOT NULL,
  `DepartmentIds` int(11) NOT NULL,
  `EmployeeExperience` int(11) NOT NULL,
  `SalaryAmount` int(11) NOT NULL,
  `exptype` int(11) NOT NULL,
  `DesignationIds` int(11) NOT NULL,
  `SalaryApply` date DEFAULT NULL,
  `Description` varchar(250) DEFAULT NULL,
  `SalaryRangeMin` double DEFAULT NULL,
  `SalaryRangeMax` double DEFAULT NULL,
  `EmployeeId` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `SettingChild`
--

CREATE TABLE IF NOT EXISTS `SettingChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SettingId` int(10) unsigned NOT NULL,
  `ExecutionType` tinyint(3) unsigned NOT NULL COMMENT 'Hour=0, Day=1, Month=2, Year=3',
  `ExecutionValue` float DEFAULT NULL,
  `NotifyAlert` tinyint(1) NOT NULL,
  `SendMail` tinyint(1) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Title` varchar(200) NOT NULL,
  `DescEmp` text NOT NULL,
  `DescOther` text NOT NULL,
  `notifyall` int(11) NOT NULL,
  `notifyself` tinyint(11) NOT NULL,
  `notifyjsteam` tinyint(11) NOT NULL,
  `notifysupervisor` tinyint(11) NOT NULL DEFAULT '0',
  `notifyhradmin` tinyint(11) NOT NULL DEFAULT '0',
  `notifyteam` tinyint(11) NOT NULL DEFAULT '0',
  `employeeType` int(11) NOT NULL,
  `Settingsonoff` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `SettingId` (`SettingId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=159 ;

-- --------------------------------------------------------

--
-- Table structure for table `SettingMaster`
--

CREATE TABLE IF NOT EXISTS `SettingMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `PageType` int(10) unsigned NOT NULL,
  `module_id` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Id` (`Id`),
  KEY `module_id` (`module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

-- --------------------------------------------------------

--
-- Table structure for table `SettingMilestone`
--

CREATE TABLE IF NOT EXISTS `SettingMilestone` (
  `Id` int(2) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `OrganizationId` int(3) NOT NULL,
  `ProjectTypeId` int(9) NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `ModifiedById` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `ProjectTypeId` (`ProjectTypeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=282 ;

-- --------------------------------------------------------

--
-- Table structure for table `SeveranceMaster`
--

CREATE TABLE IF NOT EXISTS `SeveranceMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `EffectDate` date NOT NULL DEFAULT '0000-00-00',
  `NoticePeriod` int(10) unsigned NOT NULL DEFAULT '0',
  `SeveranceDate` date NOT NULL DEFAULT '0000-00-00',
  `Message` varchar(450) NOT NULL DEFAULT '',
  `Attachment` varchar(100) NOT NULL DEFAULT '',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `SeveranceStatus` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `SeveranceReason` text NOT NULL,
  `EmployeeStatus` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '1 For Resigned, 2 For Terminated, 3 For Absconded, 4 For Other',
  `FinalSts` tinyint(1) NOT NULL DEFAULT '0',
  `TurnoverReason` int(10) unsigned DEFAULT NULL,
  `Chekliststatus` int(11) NOT NULL DEFAULT '0',
  `ChecklistHRSTS` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `SeveranceStatus` (`SeveranceStatus`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=703 ;

-- --------------------------------------------------------

--
-- Table structure for table `ShiftDateSettings`
--

CREATE TABLE IF NOT EXISTS `ShiftDateSettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `ScheduleDate` date NOT NULL,
  `ShiftId` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` date NOT NULL,
  `LastModifiedDate` date NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmployeeId` (`EmployeeId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ShiftMaster`
--

CREATE TABLE IF NOT EXISTS `ShiftMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) DEFAULT NULL,
  `TimeIn` time NOT NULL,
  `TimeOut` time NOT NULL,
  `TimeInGrace` time NOT NULL,
  `TimeOutGrace` time NOT NULL,
  `TimeInBreak` time NOT NULL DEFAULT '12:00:00',
  `TimeOutBreak` time NOT NULL DEFAULT '12:00:00',
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `BreakInGrace` time NOT NULL,
  `BreakOutGrace` time NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1',
  `shifttype` int(1) NOT NULL DEFAULT '1' COMMENT '1 is for shift start/end within a day, 2 for shift strt /end in two days',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48076 ;

--
-- Triggers `ShiftMaster`
--
DROP TRIGGER IF EXISTS `shift_before_delete`;
DELIMITER //
CREATE TRIGGER `shift_before_delete` BEFORE DELETE ON `ShiftMaster`
 FOR EACH ROW BEGIN

 INSERT INTO `onDeleteShift`(`Id`, `Name`, `TimeIn`, `TimeOut`, `TimeInGrace`, `TimeOutGrace`, `TimeInBreak`, `TimeOutBreak`, `OrganizationId`, `CreatedDate`,  `CreatedById`,  `LastModifiedDate`,  `LastModifiedById`,  `OwnerId`, `BreakInGrace`, `BreakOutGrace`, `archive`, `shifttype`, `DeletedDate`) VALUES (OLD.Id, OLD.Name, OLD.TimeIn, OLD.TimeOut, OLD.TimeInGrace, OLD.TimeOutGrace, OLD.TimeInBreak, OLD.TimeOutBreak, OLD.OrganizationId, OLD.CreatedDate, OLD.CreatedById, OLD.LastModifiedDate, OLD.LastModifiedById, OLD.OwnerId, OLD.BreakInGrace, OLD.BreakOutGrace, OLD.archive, OLD.shifttype, NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ShiftMasterChild`
--

CREATE TABLE IF NOT EXISTS `ShiftMasterChild` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `ShiftId` int(10) NOT NULL,
  `Day` tinyint(1) NOT NULL COMMENT '1-Sunday,2-Monday,3-Tuesday,4-Wednesday,5-Thursday,6-Friday,7-Saturday',
  `WeekOff` varchar(10) NOT NULL DEFAULT '0,0,0,0,0' COMMENT '1,1,1,1,1(in this string use 1 for full off, 2 for half off, 0 for present and position of (0/1/2) represent the week of month like 1st week,2nd week.... and maximum 5 weeks are there)',
  `OrganizationId` int(10) NOT NULL,
  `ModifiedBy` int(10) NOT NULL,
  `ModifiedDate` datetime NOT NULL,
  `Archive` varchar(10) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `ShiftId` (`ShiftId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=298278 ;

-- --------------------------------------------------------

--
-- Table structure for table `ShiftMonthlySettings`
--

CREATE TABLE IF NOT EXISTS `ShiftMonthlySettings` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `RotationId` int(11) NOT NULL,
  `FromDay` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `Today` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ShiftId` int(11) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ShiftRotationMaster`
--

CREATE TABLE IF NOT EXISTS `ShiftRotationMaster` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(11) NOT NULL,
  `SettingType` int(11) NOT NULL DEFAULT '1' COMMENT '(Weekly/Monthly)',
  `MonthRotation` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `WeekRotation` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ShiftId` int(11) NOT NULL,
  `EffectiveFrom` date NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `SkillGapApproval`
--

CREATE TABLE IF NOT EXISTS `SkillGapApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SkillGapId` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationId` int(10) unsigned NOT NULL DEFAULT '0',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AssessmentSts` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `DesignationId` (`DesignationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `SkillGapAssessment`
--

CREATE TABLE IF NOT EXISTS `SkillGapAssessment` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `FromDate` date NOT NULL DEFAULT '0000-00-00',
  `ToDate` date NOT NULL DEFAULT '0000-00-00',
  `Period` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedByid` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `AssessmentLevel` varchar(100) NOT NULL DEFAULT '',
  `AssessmentSts` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `FromDate` (`FromDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `SkillGapChild`
--

CREATE TABLE IF NOT EXISTS `SkillGapChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `SkillGapId` int(10) unsigned NOT NULL DEFAULT '0',
  `AnalysisId` int(10) unsigned NOT NULL DEFAULT '0',
  `AssessedLevel` int(10) unsigned NOT NULL DEFAULT '0',
  `Comments` varchar(250) NOT NULL DEFAULT '',
  `Level` int(10) unsigned NOT NULL DEFAULT '0',
  `AssessedBy` int(10) unsigned NOT NULL DEFAULT '0',
  `DesireLevel` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `SkillGapId` (`SkillGapId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

-- --------------------------------------------------------

--
-- Table structure for table `SkillGapObjective`
--

CREATE TABLE IF NOT EXISTS `SkillGapObjective` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DesignationId` int(10) unsigned NOT NULL DEFAULT '0',
  `Period` int(10) unsigned NOT NULL DEFAULT '0',
  `Objective` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `DesignationLevel` varchar(45) NOT NULL DEFAULT '',
  `ThreshholdScore` double NOT NULL,
  `AchievingAmount` double NOT NULL,
  `VariablePaySts` tinyint(1) NOT NULL DEFAULT '0',
  `IncludeDesg` varchar(50) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `DesignationId` (`DesignationId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `SkillGapObjectiveChild`
--

CREATE TABLE IF NOT EXISTS `SkillGapObjectiveChild` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `AssessmentObjectiveId` int(10) unsigned NOT NULL DEFAULT '0',
  `QuadrantId` int(10) unsigned NOT NULL DEFAULT '0',
  `Objective` text,
  `Weightage` int(10) unsigned NOT NULL DEFAULT '0',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(10) unsigned NOT NULL DEFAULT '0',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `OwnerId` int(10) unsigned NOT NULL DEFAULT '0',
  `VisibleSts` tinyint(1) NOT NULL DEFAULT '1',
  `Description` text NOT NULL,
  `ObjectiveId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `AssessmentObjectiveId` (`AssessmentObjectiveId`),
  KEY `QuadrantId` (`QuadrantId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `ObjectiveId` (`ObjectiveId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `SkillTable`
--

CREATE TABLE IF NOT EXISTS `SkillTable` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CategoryId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `Name` varchar(250) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Code` varchar(45) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `CategoryId` (`CategoryId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

-- --------------------------------------------------------

--
-- Table structure for table `slider_settings`
--

CREATE TABLE IF NOT EXISTS `slider_settings` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `archive` int(1) NOT NULL DEFAULT '1' COMMENT '1 visible to all, 2 visible to reg user only, 3 visible to trail user only, 0 invisible',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `state_gst`
--

CREATE TABLE IF NOT EXISTS `state_gst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `code` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `SuperAdminActivity`
--

CREATE TABLE IF NOT EXISTS `SuperAdminActivity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` int(11) NOT NULL,
  `previous_end_date` varchar(255) NOT NULL,
  `extended_end_date` varchar(255) NOT NULL,
  `extended_by` varchar(255) NOT NULL,
  `created_date` datetime NOT NULL,
  `action_performed` text NOT NULL,
  `previous_user_limit` varchar(10) NOT NULL,
  `extend_user_limit` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

-- --------------------------------------------------------

--
-- Table structure for table `SuspiciousAttendance`
--

CREATE TABLE IF NOT EXISTS `SuspiciousAttendance` (
  `CountId` int(20) NOT NULL AUTO_INCREMENT,
  `Id` int(10) unsigned NOT NULL,
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `AttendanceDate` date NOT NULL DEFAULT '0000-00-00',
  `AttendanceStatus` tinyint(1) NOT NULL DEFAULT '0',
  `TimeIn` time NOT NULL,
  `TimeOut` time NOT NULL,
  `ShiftId` int(10) unsigned DEFAULT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Overtime` time NOT NULL,
  `device` varchar(100) NOT NULL,
  `TimeinIp` varchar(100) NOT NULL,
  `TimeoutIp` varchar(100) NOT NULL,
  `EntryImage` varchar(100) NOT NULL,
  `ExitImage` varchar(100) NOT NULL,
  `checkInLoc` text NOT NULL,
  `CheckOutLoc` text NOT NULL,
  `timebreak` int(1) NOT NULL DEFAULT '0' COMMENT '0- off break, 1- on break',
  `AlterdDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `User_Db` varchar(20) NOT NULL,
  `SendMailSts` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1-Mail Sent / 0 - Not Sent',
  PRIMARY KEY (`CountId`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `AttendanceDate` (`AttendanceDate`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3132 ;

-- --------------------------------------------------------

--
-- Table structure for table `SystemHistory`
--

CREATE TABLE IF NOT EXISTS `SystemHistory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ActionType` varchar(45) NOT NULL DEFAULT '',
  `ActionOn` varchar(45) NOT NULL DEFAULT '',
  `OldValue` text NOT NULL,
  `NewValue` text NOT NULL,
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(10) unsigned NOT NULL DEFAULT '0',
  `ActionDate` date NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_comments`
--

CREATE TABLE IF NOT EXISTS `task_comments` (
  `OrganizationId` int(10) NOT NULL,
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `taskid` int(10) NOT NULL,
  `comment` text NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedBy` int(10) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `taskid` (`taskid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=275 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_master`
--

CREATE TABLE IF NOT EXISTS `task_master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_title` varchar(100) NOT NULL,
  `status` int(11) DEFAULT '1',
  `created_by` int(10) unsigned DEFAULT '0',
  `CreatedDate` datetime DEFAULT '0000-00-00 00:00:00',
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` datetime DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(11) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `projectid` int(10) NOT NULL,
  `milestoneid` int(10) NOT NULL,
  `assignto` int(10) NOT NULL,
  `description` text NOT NULL,
  `fromdate` datetime NOT NULL,
  `todate` datetime NOT NULL,
  `priority` int(10) NOT NULL,
  `taskstatus` int(10) NOT NULL,
  `file` varchar(100) NOT NULL,
  `miscunduct` tinyint(1) NOT NULL DEFAULT '0',
  `task_no` varchar(100) NOT NULL,
  `ReOpenCount` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `taskdocs` varchar(300) DEFAULT NULL,
  `Totalhour` varchar(250) NOT NULL,
  `GoalId` int(11) NOT NULL,
  `GivenWeightage` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1517 ;

-- --------------------------------------------------------

--
-- Table structure for table `TDSRangeSlab`
--

CREATE TABLE IF NOT EXISTS `TDSRangeSlab` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `MinimumCTC` double NOT NULL,
  `MaximumCTC` double NOT NULL,
  `Tax` double NOT NULL,
  `Cess` double NOT NULL,
  `Surcharge` int(11) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `ModifiedDate` date NOT NULL,
  `ModifiedBy` int(10) NOT NULL,
  `TdsSts` int(1) NOT NULL,
  `DivisionId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `GradeId` int(11) NOT NULL,
  `MinYear` int(11) NOT NULL,
  `MaxYear` int(11) NOT NULL,
  `EmployeeIds` int(11) NOT NULL,
  `EmpChk` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for all employees, 2 for specific employees',
  `LocationId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `TDSSurchargeSlab`
--

CREATE TABLE IF NOT EXISTS `TDSSurchargeSlab` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `MinimumCTC` double NOT NULL,
  `MaximumCTC` double NOT NULL,
  `Surcharge` int(11) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `ModifiedDate` date NOT NULL,
  `ModifiedBy` int(10) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TeamGoals`
--

CREATE TABLE IF NOT EXISTS `TeamGoals` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `GoalId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL,
  `Goal` text NOT NULL,
  `Priority` int(11) NOT NULL,
  `Remarks` varchar(450) NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '0',
  `Description` varchar(450) DEFAULT NULL,
  `Weightage` int(11) NOT NULL,
  `Quadrant` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `TaskNumber` int(11) NOT NULL,
  `Threshold` double NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `GoalId` (`GoalId`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `DepartmentId` (`DepartmentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `TemplateMaster`
--

CREATE TABLE IF NOT EXISTS `TemplateMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `Message` text NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=110 ;

-- --------------------------------------------------------

--
-- Table structure for table `temp_payment`
--

CREATE TABLE IF NOT EXISTS `temp_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txnid` varchar(100) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `payment_amount` float(10,2) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `createDate` date NOT NULL,
  `tax` float(10,2) NOT NULL,
  `discount` float(5,2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `street` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `zip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `indivisual_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `action` varchar(25) NOT NULL DEFAULT 'BUY' COMMENT 'BUY/UPGRADE',
  `duration` varchar(20) NOT NULL COMMENT '(In Months)',
  `noofusers` varchar(25) NOT NULL,
  `remark` varchar(250) NOT NULL COMMENT 'special comments by admin (if any)',
  `narration` text NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `txnid` (`txnid`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1325 ;

-- --------------------------------------------------------

--
-- Table structure for table `Temp_user_csv`
--

CREATE TABLE IF NOT EXISTS `Temp_user_csv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EmployeeCode` varchar(255) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `Shift` varchar(255) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Designation` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `PersonalNo` varchar(255) NOT NULL,
  `OrganizationId` varchar(255) NOT NULL,
  `createdBy` varchar(255) NOT NULL,
  `Archive` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `CreatedDate` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=231563 ;

-- --------------------------------------------------------

--
-- Table structure for table `Timeoff`
--

CREATE TABLE IF NOT EXISTS `Timeoff` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` varchar(45) NOT NULL DEFAULT '',
  `TimeofDate` date NOT NULL DEFAULT '0000-00-00',
  `TimeFrom` time DEFAULT NULL,
  `TimeTo` time DEFAULT NULL,
  `Reason` varchar(175) DEFAULT NULL,
  `ApproverId` varchar(45) NOT NULL DEFAULT '',
  `ApprovalSts` int(10) unsigned NOT NULL DEFAULT '3',
  `ApproverComment` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `OrganizationId` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `TimeofDate` (`TimeofDate`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14273 ;

--
-- Triggers `Timeoff`
--
DROP TRIGGER IF EXISTS `timeoff_before_delete`;
DELIMITER //
CREATE TRIGGER `timeoff_before_delete` BEFORE DELETE ON `Timeoff`
 FOR EACH ROW BEGIN

 INSERT INTO `onDeleteTimeoff`(`Id`, `EmployeeId`, `TimeofDate`, `TimeFrom`, `TimeTo`, `Reason`,`ApproverId`, `ApprovalSts`, `ApproverComment`,`CreatedDate`, `ModifiedDate`, `OrganizationId`,`DeletedDate`) VALUES (OLD.Id, OLD.EmployeeId, OLD.TimeofDate, OLD.TimeFrom, OLD.TimeTo, OLD.Reason, OLD.ApproverId, OLD.ApprovalSts, OLD.ApproverComment, OLD.CreatedDate, OLD.ModifiedDate, OLD.OrganizationId, NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `TimeoffApproval`
--

CREATE TABLE IF NOT EXISTS `TimeoffApproval` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TimeofId` int(10) unsigned NOT NULL,
  `ApproverId` int(10) unsigned NOT NULL,
  `ApproverSts` tinyint(3) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `ApprovalDate` datetime NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `ApproverComment` varchar(250) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `TimeofId` (`TimeofId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5247 ;

-- --------------------------------------------------------

--
-- Table structure for table `timesheet_master`
--

CREATE TABLE IF NOT EXISTS `timesheet_master` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `project_id` int(10) unsigned NOT NULL DEFAULT '0',
  `task_id` int(10) unsigned NOT NULL DEFAULT '0',
  `EmployeeId` int(10) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `end_time` time NOT NULL DEFAULT '00:00:00',
  `timesheetstart` date NOT NULL,
  `timesheetend` datetime NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time_status` tinyint(1) NOT NULL DEFAULT '0',
  `timesheet_date` date NOT NULL DEFAULT '0000-00-00',
  `OrganizationId` int(10) unsigned NOT NULL DEFAULT '0',
  `total_time` time DEFAULT NULL,
  `hourssts` int(11) NOT NULL,
  `assigned_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2184 ;

--
-- Triggers `timesheet_master`
--
DROP TRIGGER IF EXISTS `timesheet_before_delete`;
DELIMITER //
CREATE TRIGGER `timesheet_before_delete` BEFORE DELETE ON `timesheet_master`
 FOR EACH ROW BEGIN

  

   
   INSERT INTO ondeletetimesheet
   ( id,
     project_id, task_id, EmployeeId, timesheetstart, timesheetend, OrganizationId)
   VALUES
   ( OLD.id,OLD.project_id,OLD.task_id,OLD.EmployeeId,OLD.timesheetstart,OLD.timesheetend,OLD.OrganizationId);

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `timezone`
--

CREATE TABLE IF NOT EXISTS `timezone` (
  `zone_id` int(10) NOT NULL,
  `abbreviation` varchar(6) COLLATE utf8_bin NOT NULL,
  `time_start` int(11) NOT NULL,
  `gmt_offset` int(11) NOT NULL,
  `dst` char(1) COLLATE utf8_bin NOT NULL,
  KEY `idx_zone_id` (`zone_id`),
  KEY `idx_time_start` (`time_start`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `trainer`
--

CREATE TABLE IF NOT EXISTS `trainer` (
  `TrainerId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Mobile` int(20) NOT NULL,
  `Address` text NOT NULL,
  `Email` varchar(50) NOT NULL,
  `EmpId` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `Qualification` varchar(500) NOT NULL,
  `Specialization` varchar(500) NOT NULL,
  `Experience` varchar(500) NOT NULL,
  PRIMARY KEY (`TrainerId`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `EmpId` (`EmpId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `training`
--

CREATE TABLE IF NOT EXISTS `training` (
  `TrainingId` int(11) NOT NULL AUTO_INCREMENT,
  `Training` int(11) NOT NULL,
  `DesignationId` varchar(250) NOT NULL,
  `moduleID` varchar(250) NOT NULL,
  `trainee` int(50) NOT NULL,
  `trainer` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `timefrom` varchar(20) NOT NULL,
  `timeto` varchar(20) NOT NULL,
  `location` varchar(250) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '1',
  `CreatedDate` datetime NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`TrainingId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TrainingFeedback`
--

CREATE TABLE IF NOT EXISTS `TrainingFeedback` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `trainingId` int(11) NOT NULL,
  `moduleId` int(11) NOT NULL,
  `TraineeId` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `remark` text NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `trainingId` (`trainingId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TrainingResult`
--

CREATE TABLE IF NOT EXISTS `TrainingResult` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `trainingId` int(11) NOT NULL,
  `traineeId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `score` int(11) NOT NULL,
  `remark` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`),
  KEY `trainingId` (`trainingId`),
  KEY `traineeId` (`traineeId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `TrainingSets`
--

CREATE TABLE IF NOT EXISTS `TrainingSets` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `trainingName` varchar(250) NOT NULL,
  `modules` varchar(250) NOT NULL,
  `designation` varchar(250) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `TrialOrganization`
--

CREATE TABLE IF NOT EXISTS `TrialOrganization` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ContactPersonName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `countrycode` int(10) NOT NULL COMMENT 'copuntry code',
  `PhoneNumber` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `Country` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `City` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `CreatedDate` date NOT NULL,
  `NoOfEmp` int(10) NOT NULL,
  `ModulesRequired` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PreferredTimeToCall` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `extended_times` int(10) NOT NULL DEFAULT '1',
  `extended_days` int(5) NOT NULL,
  `mail_varified` int(1) NOT NULL COMMENT '0 not varified/ 1 varified',
  `delete_sts` int(1) NOT NULL DEFAULT '0' COMMENT '0 - Alive, 1 - Deteled',
  PRIMARY KEY (`Id`),
  KEY `idx_org1` (`Id`,`ContactPersonName`),
  KEY `idx_org` (`Id`),
  KEY `idx_org_new` (`Id`),
  KEY `start_date` (`start_date`),
  KEY `end_date` (`end_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=494 ;

-- --------------------------------------------------------

--
-- Table structure for table `TurnoverReason`
--

CREATE TABLE IF NOT EXISTS `TurnoverReason` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Severancetype` int(11) NOT NULL,
  `Value` int(11) NOT NULL,
  `Resaon` text NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1401 ;

-- --------------------------------------------------------

--
-- Table structure for table `ubihrm_discount_master`
--

CREATE TABLE IF NOT EXISTS `ubihrm_discount_master` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `currency` varchar(3) NOT NULL,
  `plan` varchar(25) NOT NULL,
  `discount` decimal(5,2) NOT NULL COMMENT 'in percentage',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `modify_date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `ubihrm_login`
--

CREATE TABLE IF NOT EXISTS `ubihrm_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `archive` int(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `trial_days` int(10) NOT NULL DEFAULT '0' COMMENT 'default trial period for newly regstered organizations',
  `user_limit` int(3) NOT NULL DEFAULT '5' COMMENT 'default user limit for newly register organization',
  `LastModifiedDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `ubihrm_module_pricing`
--

CREATE TABLE IF NOT EXISTS `ubihrm_module_pricing` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `tab_id` int(10) NOT NULL,
  `add_on_id` int(10) NOT NULL,
  `users` varchar(200) NOT NULL,
  `monthly_usd` float NOT NULL,
  `monthly_inr` float NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `tab_id` (`tab_id`),
  KEY `add_on_id` (`add_on_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ubihrm_payments_invoice`
--

CREATE TABLE IF NOT EXISTS `ubihrm_payments_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txnid` varchar(100) NOT NULL,
  `license_id` int(10) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `payment_amount` float(10,2) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `createDate` date NOT NULL,
  `tax` float(10,2) NOT NULL,
  `discount` float(5,2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `street` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `zip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `indivisual_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `action` varchar(25) NOT NULL DEFAULT 'BUY' COMMENT 'BUY/UPGRADE',
  `duration` varchar(20) NOT NULL COMMENT '(In Months)',
  `noofusers` varchar(25) NOT NULL,
  `remark` varchar(250) NOT NULL COMMENT 'special comments by admin (if any)',
  `narration` text NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `txnid` (`txnid`),
  KEY `license_id` (`license_id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ubihrm_plan_master`
--

CREATE TABLE IF NOT EXISTS `ubihrm_plan_master` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `monthly_usd` float(10,2) NOT NULL,
  `yearly_usd` float(10,2) NOT NULL,
  `monthly_inr` float(10,2) NOT NULL,
  `yearly_inr` float(10,2) NOT NULL,
  `range` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `ubihrm_purchased_addon`
--

CREATE TABLE IF NOT EXISTS `ubihrm_purchased_addon` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `license_id` int(10) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `addon_id` int(11) NOT NULL,
  `addon_price` int(11) NOT NULL,
  `users` int(11) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `license_id` (`license_id`),
  KEY `addon_id` (`addon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ubihrm_temp_payment`
--

CREATE TABLE IF NOT EXISTS `ubihrm_temp_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txnid` varchar(100) NOT NULL,
  `license_id` int(10) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `payment_amount` float(10,2) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `createDate` date NOT NULL,
  `tax` float(10,2) NOT NULL,
  `discount` float(5,2) NOT NULL,
  `currency` varchar(5) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(80) NOT NULL,
  `city` varchar(80) NOT NULL,
  `street` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `zip` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `indivisual_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `gstin` varchar(50) NOT NULL,
  `action` varchar(25) NOT NULL DEFAULT 'BUY' COMMENT 'BUY/UPGRADE',
  `duration` varchar(20) NOT NULL COMMENT '(In Months)',
  `noofusers` varchar(25) NOT NULL,
  `remark` varchar(250) NOT NULL COMMENT 'special comments by admin (if any)',
  `narration` text NOT NULL,
  `LastModifiedDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `txnid` (`txnid`),
  KEY `license_id` (`license_id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ubitech_login`
--

CREATE TABLE IF NOT EXISTS `ubitech_login` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `archive` int(1) NOT NULL,
  `name` varchar(100) NOT NULL,
  `trial_days` int(10) NOT NULL DEFAULT '0' COMMENT 'default trial period for newly regstered organizations',
  `user_limit` int(3) NOT NULL DEFAULT '10' COMMENT 'default user limit for newly register organization',
  `bulk_attendance` int(1) NOT NULL COMMENT 'Addons-  0 means not active,1 means active',
  `location_tracing` int(1) NOT NULL COMMENT 'Addons-  0 means not active,1 means active',
  `visit_punch` int(1) NOT NULL COMMENT 'Addons-  0 means not active,1 means active',
  `geo_fence` int(1) NOT NULL COMMENT 'Addons-  0 means not active,1 means active',
  `payroll` int(1) NOT NULL COMMENT 'Addons-  0 means not active,1 means active',
  `time_off` int(1) NOT NULL COMMENT 'Addons-  0 means not active,1 means active',
  `Addon_flexi_shif` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `UserMaster`
--

CREATE TABLE IF NOT EXISTS `UserMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `EmployeeId` int(10) unsigned NOT NULL,
  `Password` varchar(250) NOT NULL DEFAULT '',
  `Username` varchar(250) DEFAULT NULL,
  `userprofile` int(11) NOT NULL,
  `username_mobile` varchar(250) NOT NULL,
  `AadharNo` varchar(255) NOT NULL,
  `RoleId` int(10) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `AdminSts` tinyint(1) NOT NULL,
  `VisibleSts` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0 for inactive, 1 for active in HRM',
  `trial_OrganizationId` int(11) DEFAULT '0',
  `appSuperviserSts` int(1) NOT NULL DEFAULT '0' COMMENT 'Permission for  Attendace dashboard in Application',
  `archive` int(1) NOT NULL DEFAULT '1' COMMENT '1 for active, 0 for inactive',
  `resetPassCounter` int(3) NOT NULL DEFAULT '0' COMMENT 'this colom sill contain the counting of reset password and prevent the reusibility of same link to reset the password',
  `HRSts` int(11) NOT NULL DEFAULT '0',
  `AppId` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `EmployeeId` (`EmployeeId`),
  KEY `EmployeeId_2` (`EmployeeId`),
  KEY `idx_app_login` (`Username`,`Password`),
  KEY `idx_org` (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `username_mobile` (`username_mobile`),
  KEY `Username` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96780 ;

--
-- Triggers `UserMaster`
--
DROP TRIGGER IF EXISTS `user_before_delete`;
DELIMITER //
CREATE TRIGGER `user_before_delete` BEFORE DELETE ON `UserMaster`
 FOR EACH ROW BEGIN

 INSERT INTO `onDeleteUserMaster`(`Id`, `EmployeeId`, `Password`, `Username`, `userprofile`, `username_mobile`,`AadharNo`, `RoleId`, `OrganizationId`,`CreatedDate`, `CreatedById`, `LastModifiedDate`,`LastModifiedById`, `OwnerId`, `AdminSts`,`VisibleSts`, `appSuperviserSts`, `archive`,`resetPassCounter`, `HRSts`, `AppId`,`DeletedDate`) VALUES (OLD.Id, OLD.EmployeeId, OLD.Password, OLD.Username, OLD.userprofile, OLD.username_mobile, OLD.AadharNo, OLD.RoleId, OLD.OrganizationId, OLD.CreatedDate, OLD.CreatedById, OLD.LastModifiedDate, OLD.LastModifiedById, OLD.OwnerId, OLD.AdminSts, OLD.VisibleSts, OLD.appSuperviserSts, OLD.archive, OLD.resetPassCounter, OLD.HRSts, OLD.AppId, NOW());

END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `UserPermission`
--

CREATE TABLE IF NOT EXISTS `UserPermission` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `RoleId` int(10) unsigned NOT NULL,
  `ModuleId` int(10) unsigned NOT NULL,
  `ViewPermission` tinyint(1) NOT NULL,
  `EditPermission` tinyint(1) NOT NULL,
  `DeletePermission` tinyint(1) NOT NULL,
  `AddPermission` tinyint(1) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `RoleId` (`RoleId`),
  KEY `ModuleId` (`ModuleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=407750 ;

-- --------------------------------------------------------

--
-- Table structure for table `Userprofile`
--

CREATE TABLE IF NOT EXISTS `Userprofile` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(250) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(11) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(11) NOT NULL,
  `OrganizationId` int(11) NOT NULL,
  `AdminSts` tinyint(1) NOT NULL DEFAULT '0',
  `Description` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=164 ;

-- --------------------------------------------------------

--
-- Table structure for table `UserProfile_permission`
--

CREATE TABLE IF NOT EXISTS `UserProfile_permission` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Userprofileid` int(10) NOT NULL,
  `ModuleId` int(10) NOT NULL,
  `ViewPermission` tinyint(1) NOT NULL,
  `AddPermission` tinyint(1) NOT NULL,
  `EditPermission` tinyint(1) NOT NULL,
  `DeletePermission` tinyint(1) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `CreatedById` int(10) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `LastModifiedById` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Userprofileid` (`Userprofileid`),
  KEY `OrganizationId` (`OrganizationId`),
  KEY `ModuleId` (`ModuleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46318 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `user_password_hash` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password in salted and hashed format',
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
  `user_account_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'user''s account type (basic, premium, etc)',
  `user_has_avatar` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 if user has a local avatar, 0 if not',
  `user_rememberme_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
  `user_creation_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the creation of user''s account',
  `user_last_login_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of user''s last login',
  `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attempts',
  `user_last_failed_login` int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
  `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
  `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
  `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
  `user_provider_type` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `VisaCategory`
--

CREATE TABLE IF NOT EXISTS `VisaCategory` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL,
  `OrganizationId` int(10) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) NOT NULL,
  `OwnerId` int(10) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `VisaMaster`
--

CREATE TABLE IF NOT EXISTS `VisaMaster` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `WeekOffMaster`
--

CREATE TABLE IF NOT EXISTS `WeekOffMaster` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Day` tinyint(1) NOT NULL COMMENT '1-Sunday,2-Monday,3-Tuesday,4-Wednesday,5-Thursday,6-Friday,7-Saturday',
  `WeekOff` varchar(10) NOT NULL DEFAULT '0,0,0,0,0' COMMENT '1,1,1,1,1(in this string use 1 for full off, 2 for half off, 0 for present and position of (0/1/2) represent the week of month like 1st week,2nd week.... and maximum 5 weeks are there)',
  `OrganizationId` int(10) NOT NULL,
  `ModifiedBy` int(10) NOT NULL,
  `ModifiedDate` datetime NOT NULL,
  `Archive` varchar(10) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59256 ;

-- --------------------------------------------------------

--
-- Table structure for table `WorkflowRules`
--

CREATE TABLE IF NOT EXISTS `WorkflowRules` (
  `Id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(250) NOT NULL,
  `TableId` varchar(45) NOT NULL,
  `EvaluationCriteria` tinyint(3) unsigned NOT NULL,
  `RuleCriteria` text NOT NULL,
  `ActionToBeTaken` tinyint(4) unsigned NOT NULL,
  `OrganizationId` int(10) unsigned NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CreatedById` int(10) unsigned NOT NULL,
  `LastModifiedDate` datetime NOT NULL,
  `LastModifiedById` int(10) unsigned NOT NULL,
  `OwnerId` int(10) unsigned NOT NULL,
  `Description` text NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `TableId` (`TableId`),
  KEY `OrganizationId` (`OrganizationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ZoneMaster`
--

CREATE TABLE IF NOT EXISTS `ZoneMaster` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Code` char(2) COLLATE utf8_bin NOT NULL,
  `Name` varchar(35) COLLATE utf8_bin NOT NULL,
  `CountryId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Id`) USING BTREE,
  KEY `idx_zone_name` (`Name`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=417 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
