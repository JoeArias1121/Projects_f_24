-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 11, 2022 at 07:09 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `p_s22_3_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `f20_academic_dept_info`
--

CREATE TABLE `f20_academic_dept_info` (
  `code` char(6) NOT NULL,
  `ind_name` varchar(64) NOT NULL,
  `sup_email` varchar(128) NOT NULL,
  `admin_email` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f20_application_util`
--

CREATE TABLE `f20_application_util` (
  `fw_id` varchar(64) NOT NULL,
  `progress` tinyint(2) DEFAULT 1,
  `comments` varchar(512) DEFAULT NULL,
  `rejected` tinyint(1) NOT NULL DEFAULT 0,
  `assigned_to` varchar(128) NOT NULL,
  `assigned_when` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f20_app_details_table`
--

CREATE TABLE `f20_app_details_table` (
  `AID` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `step_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_app_details_table`
--

INSERT INTO `f20_app_details_table` (`AID`, `SID`, `step_order`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 5),
(1, 6, 6),
(1, 7, 7),
(2, 8, 1),
(2, 9, 2),
(2, 10, 3),
(2, 11, 4),
(2, 12, 5);

-- --------------------------------------------------------

--
-- Table structure for table `f20_app_status_table`
--

CREATE TABLE `f20_app_status_table` (
  `ASID` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_app_status_table`
--

INSERT INTO `f20_app_status_table` (`ASID`, `title`, `info`) VALUES
(1, 'Done', 'Application that has all of its steps done or approved.'),
(2, 'In-Progress', 'Application that has at least one step unfinished or not approved.'),
(3, 'Deleted', 'Application that is no longer publicly visible.');

-- --------------------------------------------------------

--
-- Table structure for table `f20_app_table`
--

CREATE TABLE `f20_app_table` (
  `AID` int(11) NOT NULL,
  `ASID` int(11) NOT NULL,
  `ATID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `instructions` varchar(255) NOT NULL,
  `deadline` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_app_table`
--

INSERT INTO `f20_app_table` (`AID`, `ASID`, `ATID`, `UID`, `title`, `instructions`, `deadline`, `created`) VALUES
(1, 1, 2, 2, 'Fieldwork', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-10 21:45:59', '2020-11-08 21:45:59'),
(2, 2, 1, 1, 'Independent Study', 'Secretary=>Student=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(5, 2, 2, 1, 'test app', 'Recreg=>Faculty=>Student', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(6, 2, 1, 1, 'test', 'Recreg=>Faculty=>Student', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(7, 2, 1, 1, 'Test1', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(8, 2, 2, 1, 'New Workflow', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(9, 2, 2, 6, 'Today:', 'Secretary=>Student=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(10, 2, 2, 7, 'Tester1', 'Recreg=>Crc=>Dean=>Chair', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(11, 2, 2, 1, 'IDK', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(12, 2, 2, 1, 'testtestt', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(13, 2, 2, 6, 'test 2/27', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(14, 2, 2, 1, 'test1 2/28', 'Secretary=>Student=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(15, 2, 1, 2, 'testcareers 2/28', 'Secretary=>Student=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(16, 2, 2, 4, 'gfjhgjhgg', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(17, 2, 1, 1, 'Form', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(18, 2, 1, 2, 'test 1 3/10/21', 'Secretary=>Student=>Faculty=>Supervisor=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51'),
(19, 2, 2, 2, 'test 2 3/10', 'Secretary=>Student=>Faculty=>Chair=>Dean', '2020-11-28 21:47:51', '2020-11-10 21:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `f20_app_type_table`
--

CREATE TABLE `f20_app_type_table` (
  `ATID` int(11) NOT NULL,
  `title` varchar(10) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_app_type_table`
--

INSERT INTO `f20_app_type_table` (`ATID`, `title`, `info`) VALUES
(1, 'Urgent', 'Workflow with high priority which should be taken care of first.'),
(2, 'Normal', 'Workflow with normal priority.');

-- --------------------------------------------------------

--
-- Table structure for table `f20_course_numbers`
--

CREATE TABLE `f20_course_numbers` (
  `id` int(3) NOT NULL,
  `dept_code` varchar(10) NOT NULL,
  `course_number` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `f20_course_numbers`
--

INSERT INTO `f20_course_numbers` (`id`, `dept_code`, `course_number`) VALUES
(151, 'ART', '001'),
(149, 'ART', '111'),
(153, 'ART', '987'),
(135, 'BUS', '494'),
(136, 'CMD', '403'),
(137, 'CMM', '490'),
(161, 'CPS', '442'),
(150, 'CSE', '123'),
(138, 'CSE', '485'),
(139, 'CSE', '493'),
(140, 'DMJ', '461'),
(141, 'DMJ', '470'),
(159, 'esf', '000'),
(160, 'esf', '010'),
(158, 'esf', '456'),
(157, 'esf', 'erg'),
(156, 'esf', 'esf'),
(142, 'MUS', '480'),
(143, 'POL', '425'),
(144, 'PSY', '497'),
(145, 'SAB', '324'),
(146, 'SAB', '353'),
(147, 'SOC', '481'),
(154, 'the', '3q '),
(148, 'THE', '434');

-- --------------------------------------------------------

--
-- Table structure for table `f20_datastatus_t`
--

CREATE TABLE `f20_datastatus_t` (
  `dataStatus_id` varchar(4) NOT NULL,
  `dataStatus_title` varchar(32) NOT NULL,
  `dataStatus_info` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `f20_datastatus_t`
--

INSERT INTO `f20_datastatus_t` (`dataStatus_id`, `dataStatus_title`, `dataStatus_info`) VALUES
('0***', 'Terminated', 'for data which was created but no longer available (deleted) in the system'),
('1***', 'Alive', 'for data which was created and available in the system'),
('1**0', 'Passive', 'for data which is not visible in the system'),
('1**1', 'Active', 'for data which is visible in the system'),
('1*0*', 'Locked', 'not available for others to use besides the user who is currently using it or last modified it'),
('1*1*', 'Released/Unlocked', 'for data which is available to be used in the system'),
('10**', 'Unapproved', 'for data which was created but not approved yet'),
('11**', 'Approved', 'for data which is approved/unlocked and is ready to be used in the system');

-- --------------------------------------------------------

--
-- Table structure for table `f20_datatype_t`
--

CREATE TABLE `f20_datatype_t` (
  `dataType_id` int(2) NOT NULL,
  `dataType_title` varchar(32) NOT NULL,
  `dataType_info` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `f20_datatype_t`
--

INSERT INTO `f20_datatype_t` (`dataType_id`, `dataType_title`, `dataType_info`) VALUES
(1, 'Any', 'Any data item'),
(2, 'Self', 'Data item created/owned by the same user'),
(3, 'Other', 'Data item created by other users'),
(4, 'Form', 'A web form to be filled in'),
(5, 'File', 'A file attached to a task or owned by a user'),
(6, 'Database', 'Field, tables, in a database'),
(7, 'MessageSender', 'Where IN messages are accepted');

-- --------------------------------------------------------

--
-- Table structure for table `f20_data_t`
--

CREATE TABLE `f20_data_t` (
  `data_id` int(4) NOT NULL,
  `dataStatus_id` varchar(4) NOT NULL,
  `data_location` varchar(64) NOT NULL,
  `dataType_id` int(2) NOT NULL,
  `data_modifier` int(3) NOT NULL,
  `data_changed` datetime NOT NULL,
  `data_owner` int(3) NOT NULL,
  `data_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `f20_data_t`
--

INSERT INTO `f20_data_t` (`data_id`, `dataStatus_id`, `data_location`, `dataType_id`, `data_modifier`, `data_changed`, `data_owner`, `data_created`) VALUES
(1, '1***', 'user|user_info', 1, 1, '2025-01-19 05:10:28', 1, '2020-11-11 17:11:55'),
(104, '1***', '/upload/file1.txt', 2, 2, '2035-01-19 09:13:07', 2, '2020-11-11 17:12:03'),
(105, '1***', '/form/form1.json', 1, 3, '2025-01-19 05:10:28', 3, '2020-11-11 17:12:08'),
(106, '1***', '/var/www/projects/f18-02/var/uploads/fieldworkForm.pdf', 1, 1, '0000-00-00 00:00:00', 8, '2020-11-20 20:32:59'),
(109, '1***', 'path', 1, 1, '0000-00-00 00:00:00', 8, '2020-11-25 02:42:19');

-- --------------------------------------------------------

--
-- Table structure for table `f20_file_upload`
--

CREATE TABLE `f20_file_upload` (
  `fileID` int(8) NOT NULL,
  `owner` varchar(128) NOT NULL,
  `file_type` varchar(24) NOT NULL,
  `file` varchar(128) NOT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `f20_messagestatus_t`
--

CREATE TABLE `f20_messagestatus_t` (
  `messageStatus_id` int(11) NOT NULL,
  `messageStatus_title` varchar(64) NOT NULL,
  `messageStatus_info` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `f20_messagestatus_t`
--

INSERT INTO `f20_messagestatus_t` (`messageStatus_id`, `messageStatus_title`, `messageStatus_info`) VALUES
(1, 'new', 'New unread message'),
(2, 'read', 'Message that has been read'),
(3, 'deleted', 'Not visible');

-- --------------------------------------------------------

--
-- Table structure for table `f20_messagetype_t`
--

CREATE TABLE `f20_messagetype_t` (
  `messageType_id` int(11) NOT NULL,
  `messageType_Title` varchar(16) NOT NULL,
  `messageType_info` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `f20_messagetype_t`
--

INSERT INTO `f20_messagetype_t` (`messageType_id`, `messageType_Title`, `messageType_info`) VALUES
(1, 'urgent', 'Message that needs alert'),
(2, 'normal', 'No message alert ');

-- --------------------------------------------------------

--
-- Table structure for table `f20_message_t`
--

CREATE TABLE `f20_message_t` (
  `message_id` int(6) NOT NULL,
  `message_type` int(11) NOT NULL,
  `message_status` int(11) NOT NULL,
  `task_id` int(4) NOT NULL,
  `message_sender` int(3) NOT NULL,
  `message_receiver` int(3) NOT NULL,
  `message_subject` varchar(36) NOT NULL,
  `message_contents` varchar(256) NOT NULL,
  `message_datalink` int(4) DEFAULT NULL,
  `message_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `f20_message_t`
--

INSERT INTO `f20_message_t` (`message_id`, `message_type`, `message_status`, `task_id`, `message_sender`, `message_receiver`, `message_subject`, `message_contents`, `message_datalink`, `message_created`) VALUES
(1, 2, 2, 1, 2, 4, 'hi', 'Meeting @ 10am Monday', NULL, '2020-11-01 20:07:03'),
(3, 1, 2, 2, 7, 3, 'start', 'Can you review this form?', 105, '2020-11-01 20:08:14'),
(4, 2, 1, 1, 4, 2, 'RE: hi', 'ok', NULL, '2020-11-01 20:09:27'),
(5, 1, 1, 2, 3, 7, 'RE: start', 'Done, approved', 105, '2020-11-01 20:10:24'),
(7, 2, 2, 1, 1, 8, 'test', 'testing', NULL, '2020-11-11 20:44:26'),
(15, 1, 1, 1, 1, 10, 'testing', 'testing2', NULL, '2020-11-11 18:42:50'),
(18, 1, 2, 1, 1, 8, 'asdfswae', 'ffwefw', NULL, '2020-11-11 20:41:58'),
(25, 1, 1, 1, 1, 10, 'asdefgdswae', 'swdfwqae', NULL, '2020-11-11 18:49:20'),
(27, 1, 2, 1, 1, 8, 'sdfc we', 'wce fwqecf', NULL, '2020-11-11 20:42:16'),
(30, 1, 1, 1, 1, 10, 'Hello', 'qw34dt3', NULL, '2020-11-11 18:50:45'),
(33, 2, 1, 1, 1, 10, 'waesfweqf', 'wcqderf', NULL, '2020-11-11 18:54:42'),
(34, 1, 2, 1, 1, 10, 'asdftc34', '3f4cct243', NULL, '2020-11-11 18:54:50'),
(36, 2, 1, 1, 8, 10, 'Hello', 'Hello, instructor', NULL, '2020-11-11 18:57:29'),
(37, 2, 1, 1, 8, 1, 'test', 'hello admin', NULL, '2020-11-11 21:55:34'),
(39, 2, 1, 1, 8, 0, 'helo', 'hello', NULL, '2020-11-11 21:56:20'),
(40, 2, 1, 1, 8, 0, 'helo', 'hello', NULL, '2020-11-11 21:56:20'),
(41, 2, 1, 1, 1, 8, 'name test', 'login name test', NULL, '2020-11-18 21:41:46'),
(42, 2, 1, 1, 8, 4, 'test', 'student to dean', NULL, '2020-11-24 20:23:02'),
(43, 2, 2, 1, 0, 0, 'awsdf', 'wdqcert', NULL, '2020-11-24 22:53:27'),
(44, 1, 2, 1, 4, 6, 'Test1', 'Test1', NULL, '2020-11-25 01:07:46'),
(45, 1, 1, 1, 1, 12, 'Test', 'Final Presentation', NULL, '2020-11-25 15:52:57'),
(46, 2, 1, 1, 6, 10, 'Test', 'Hello', NULL, '2021-02-24 04:22:33'),
(47, 1, 2, 1, 7, 6, 'Tester123', 'can you view this ', NULL, '2021-03-17 14:36:32'),
(48, 2, 1, 1, 8, 1, 'test 2/25', 'help', NULL, '2021-02-25 18:53:05'),
(49, 2, 1, 1, 4, 23, 'testing', 'this is an automated mesage', NULL, '2021-02-27 04:17:07'),
(50, 1, 1, 1, 1, 8, 'test 2/27', 'hello', NULL, '2021-02-28 00:50:40'),
(51, 2, 1, 1, 1, 4, 'confirm meeting 2/28', 'confirm meeting test 1', NULL, '2021-03-01 00:47:48'),
(52, 2, 1, 1, 2, 1, 'test 3/9', 'test 3/9', NULL, '2021-03-10 04:53:22'),
(53, 1, 1, 1, 6, 1, 'Test', 'This is a test', NULL, '2021-04-07 15:16:37'),
(54, 1, 1, 1, 6, 0, 'test', 'testest', NULL, '2021-04-09 02:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `f20_step_details_table`
--

CREATE TABLE `f20_step_details_table` (
  `SID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `DID` int(11) DEFAULT NULL,
  `SSID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_step_details_table`
--

INSERT INTO `f20_step_details_table` (`SID`, `UID`, `DID`, `SSID`) VALUES
(1, 2, NULL, 1),
(2, 8, NULL, 1),
(3, 4, NULL, 1),
(4, 5, NULL, 1),
(5, 6, NULL, 1),
(6, 7, NULL, 1),
(7, 8, NULL, 1),
(8, 2, NULL, 1),
(9, 8, NULL, 1),
(10, 4, NULL, 2),
(11, 5, NULL, 2),
(12, 6, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `f20_step_table`
--

CREATE TABLE `f20_step_table` (
  `SID` int(11) NOT NULL,
  `SSID` int(11) NOT NULL,
  `STID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `instructions` text NOT NULL,
  `location` varchar(50) NOT NULL,
  `deadline` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_step_table`
--

INSERT INTO `f20_step_table` (`SID`, `SSID`, `STID`, `UID`, `title`, `instructions`, `location`, `deadline`, `created`) VALUES
(1, 1, 1, 2, 'Secretary Form', '[participating users = secretary] secretary fill-in form f1 to create/generate an app(enter student email, select Course, Faculty, Chair, Dean), the system automatically generates an urgent message from Secretary to the primary user of the NEXT step (Student) and also  emails student login info', '/steps/0000000001.php', '2020-11-20 21:45:59', '2020-11-10 21:47:51'),
(2, 1, 1, 2, 'Student Form', '                        [participating users = student] Student fill-in the (fieldwork) form f2 including Supervisor info, the system automatically generates an urgent message from Student to the primary user of the NEXT step (Faculty) and also emails faculty login info                ', '/steps/0000000002.php', NULL, NULL),
(3, 1, 1, 2, 'Faculty 1 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also emails Supervisor login info.', '/steps/0000000003.php', NULL, NULL),
(4, 1, 1, 2, 'Supervisor Form', '[participating users = supervisor] Supervisor fill-in the form f4 to edit/approve LO, the system automatically generates a message from Supervisor to Faculty', '/steps/0000000004.php', NULL, NULL),
(5, 1, 1, 2, 'Faculty 2 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also  emails Supervisor login info.', '/steps/0000000005.php', NULL, NULL),
(6, 1, 1, 2, 'Chair Form', '[participating users = Chair] Chair fill-in the form f5 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/steps/0000000006.php', NULL, NULL),
(7, 1, 1, 2, 'Dean Form', '[participating users = Dean] Dean fill-in the form f6 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/steps/0000000007.php', NULL, NULL),
(8, 1, 2, 3, 'Secretary Form', '[participating users = secretary] secretary fill-in form f1 to create/generate an app(enter student email, select Course, Faculty, Chair, Dean), the system automatically generates an urgent message from Secretary to the primary user of the NEXT step (Student) and also  emails student login info', '/steps/0000000008.php', '2020-11-20 21:45:59', '2020-11-10 21:47:51'),
(9, 1, 2, 3, 'Student Form', '[participating users = student] Student fill-in the (fieldwork) form f2 including Supervisor info, the system automatically generates an urgent message from Student to the primary user of the NEXT step (Faculty) and also emails faculty login info', '/steps/0000000009.php', NULL, NULL),
(10, 1, 2, 3, 'Faculty 1 Form', '[participating users = faculty] Faculty fill-in form f3 to specify the Learning Outcomes (LO), the system automatically generates a message from Faculty to the primary user of the NEXT step (Supervisor) and also emails Supervisor login info.', '/steps/0000000010.php', NULL, NULL),
(11, 1, 2, 3, 'Chair Form', '[participating users = Chair] Chair fill-in the form f5 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/steps/0000000011.php', NULL, NULL),
(12, 2, 2, 3, 'Dean Form', '[participating users = Dean] Dean fill-in the form f6 approving or rejecting, the system automatically generates a message from Chair to Dean and also emails Dean login info.', '/steps/0000000012.php', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `f20_step_type_table`
--

CREATE TABLE `f20_step_type_table` (
  `STID` int(11) NOT NULL,
  `title` varchar(10) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_step_type_table`
--

INSERT INTO `f20_step_type_table` (`STID`, `title`, `info`) VALUES
(1, 'Urgent', 'Step with high priority that should be addressed as soon as possible.'),
(2, 'Normal', 'Step with normal priority.');

-- --------------------------------------------------------

--
-- Table structure for table `f20_template_status_table`
--

CREATE TABLE `f20_template_status_table` (
  `TSID` int(11) NOT NULL,
  `title` varchar(15) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_template_status_table`
--

INSERT INTO `f20_template_status_table` (`TSID`, `title`, `info`) VALUES
(1, 'Ready', 'Can be used when needed.'),
(2, 'Not-Ready', 'Incomplete or should not be used yet.'),
(3, 'Deleted', 'No longer visible.');

-- --------------------------------------------------------

--
-- Table structure for table `f20_user_role_table`
--

CREATE TABLE `f20_user_role_table` (
  `URID` int(11) NOT NULL,
  `user_role_title` varchar(30) NOT NULL,
  `user_role_info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_user_role_table`
--

INSERT INTO `f20_user_role_table` (`URID`, `user_role_title`, `user_role_info`) VALUES
(1, 'Administrator', 'Highest access rights.'),
(2, 'Supervisor', 'Supervisor of projects and jobs'),
(3, 'Employee', 'Anyone working on jobs and tasks'),
(4, 'Customer', 'A client that may want access rights to a job that they are relevant on.');

-- --------------------------------------------------------

--
-- Table structure for table `f20_user_status_table`
--

CREATE TABLE `f20_user_status_table` (
  `USID` int(11) NOT NULL,
  `user_status` varchar(30) NOT NULL,
  `user_status_info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_user_status_table`
--

INSERT INTO `f20_user_status_table` (`USID`, `user_status`, `user_status_info`) VALUES
(1, 'Active', 'Status assigned to users who are registered, approved, and can use the system.'),
(2, 'Passive', 'Status assigned to users who are registered, but haven\'t been given access to the system functions.'),
(3, 'Terminated', 'Status assigned to users who are registered, but who no longer have access to the system.');

-- --------------------------------------------------------

--
-- Table structure for table `f20_user_table`
--

CREATE TABLE `f20_user_table` (
  `UID` int(11) NOT NULL,
  `USID` int(11) NOT NULL,
  `URID` int(11) NOT NULL,
  `user_login_name` varchar(10) DEFAULT NULL,
  `user_email` varchar(128) NOT NULL,
  `user_password` varchar(64) NOT NULL,
  `user_name` varchar(128) NOT NULL,
  `user_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `f20_user_table`
--

INSERT INTO `f20_user_table` (`UID`, `USID`, `URID`, `user_login_name`, `user_email`, `user_password`, `user_name`, `user_info`) VALUES
(1, 1, 1, 'admin', 'admin@email.com', '1234', 'Admin Administrator', ''),
(2, 1, 2, 'supervisor', 'supervisor@email.com', '1234', 'Supervisor', ''),
(3, 1, 3, 'employee', 'employee@email.com', '1234', 'Employee', ''),
(4, 1, 4, 'customer', 'customer@email.com', '1234', 'Customer', ''),
(36, 1, 2, NULL, 'carlsona1@newpaltz.edu', '9999', 'Alex Carlson', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `f20_user_validation`
--

CREATE TABLE `f20_user_validation` (
  `email` varchar(128) NOT NULL,
  `token` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='token validation';

-- --------------------------------------------------------

--
-- Table structure for table `jobDetails_T`
--

CREATE TABLE `jobDetails_T` (
  `job_id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  `job_taskOrder` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobDetails_T`
--

INSERT INTO `jobDetails_T` (`job_id`, `task_id`, `job_taskOrder`) VALUES
(1, 1, 1),
(1, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `jobStatus_T`
--

CREATE TABLE `jobStatus_T` (
  `jobStatus_id` int(10) NOT NULL,
  `jobStatus_title` varchar(25) NOT NULL,
  `jobStatus_info` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobStatus_T`
--

INSERT INTO `jobStatus_T` (`jobStatus_id`, `jobStatus_title`, `jobStatus_info`) VALUES
(1, 'done', 'job that has been done'),
(2, 'progress', 'job that is not done yet'),
(3, 'deleted', 'not visible anymore');

-- --------------------------------------------------------

--
-- Table structure for table `jobTemplateDetails_T`
--

CREATE TABLE `jobTemplateDetails_T` (
  `jobTemplate_id` int(10) NOT NULL,
  `taskTemplate_id` int(10) NOT NULL,
  `job_taskOrder` int(10) NOT NULL,
  `detailStatus_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobTemplateDetails_T`
--

INSERT INTO `jobTemplateDetails_T` (`jobTemplate_id`, `taskTemplate_id`, `job_taskOrder`, `detailStatus_id`) VALUES
(1, 1, 1, 1),
(1, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobTemplate_T`
--

CREATE TABLE `jobTemplate_T` (
  `jobTemplate_id` int(10) NOT NULL,
  `job_title` varchar(25) NOT NULL,
  `job_instructions` varchar(250) DEFAULT NULL,
  `templateStatus_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobTemplate_T`
--

INSERT INTO `jobTemplate_T` (`jobTemplate_id`, `job_title`, `job_instructions`, `templateStatus_id`) VALUES
(1, 'report', 'Manager creates report file and adds part A,B, and C; staff view part B; customer view part C', 1),
(2, 'travel', 'Manager creates travel form and fill-in part A, staff fill-in part B, customer view and sign-in part C', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobType_T`
--

CREATE TABLE `jobType_T` (
  `jobType_id` int(10) NOT NULL,
  `jobType_title` varchar(25) NOT NULL,
  `jobType_info` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jobType_T`
--

INSERT INTO `jobType_T` (`jobType_id`, `jobType_title`, `jobType_info`) VALUES
(1, 'urgent', 'job with high priority that needs to get done asap'),
(2, 'normal', 'job with normal priority');

-- --------------------------------------------------------

--
-- Table structure for table `job_T`
--

CREATE TABLE `job_T` (
  `job_id` int(10) NOT NULL,
  `job_status` int(10) NOT NULL,
  `job_owner` int(10) NOT NULL,
  `job_title` varchar(250) NOT NULL,
  `job_instructions` varchar(250) DEFAULT NULL,
  `job_deadline` varchar(250) DEFAULT NULL,
  `job_created` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_T`
--

INSERT INTO `job_T` (`job_id`, `job_status`, `job_owner`, `job_title`, `job_instructions`, `job_deadline`, `job_created`) VALUES
(1, 2, 2, 'TV Service', 'The TV evaluation report is made by a technical manager and a staff and viewed by a customer. Then, a travel plan is put together by a service manager and a staff and is signed by the customer with a broken TV.', '2019-01-19 05:10:28', '2019-01-19 05:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `messageStatus_T`
--

CREATE TABLE `messageStatus_T` (
  `messageStatus_id` int(11) NOT NULL,
  `messageStatus_title` varchar(30) NOT NULL,
  `messageStatus_info` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messageStatus_T`
--

INSERT INTO `messageStatus_T` (`messageStatus_id`, `messageStatus_title`, `messageStatus_info`) VALUES
(1, 'new', ' new message that is not read yet'),
(2, 'read', ' message that has been read'),
(3, 'deleted', 'not visible any more');

-- --------------------------------------------------------

--
-- Table structure for table `messageType_T`
--

CREATE TABLE `messageType_T` (
  `messageType_id` int(11) NOT NULL,
  `messageType_title` varchar(30) NOT NULL,
  `messageType_info` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messageType_T`
--

INSERT INTO `messageType_T` (`messageType_id`, `messageType_title`, `messageType_info`) VALUES
(1, 'urgent ', 'message that needs an alert sent to receiver email '),
(2, ' normal ', ' no need to send email alert ');

-- --------------------------------------------------------

--
-- Table structure for table `message_T`
--

CREATE TABLE `message_T` (
  `message_id` int(11) NOT NULL,
  `message_type` int(11) NOT NULL,
  `message_status` int(11) NOT NULL,
  `task_id` int(10) NOT NULL,
  `message_sender` int(11) NOT NULL,
  `message_receiver` int(11) NOT NULL,
  `message_subject` varchar(200) NOT NULL,
  `message_contents` longtext NOT NULL,
  `message_datalink` int(10) DEFAULT NULL,
  `message_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_T`
--

INSERT INTO `message_T` (`message_id`, `message_type`, `message_status`, `task_id`, `message_sender`, `message_receiver`, `message_subject`, `message_contents`, `message_datalink`, `message_created`) VALUES
(1, 2, 2, 1, 2, 4, 'hi', 'let’s have first meeting on Monday at 10am', 0, '2019-01-20 05:10:28'),
(2, 1, 2, 2, 7, 3, 'start', 'can you review this form?', 105, '2019-01-20 09:13:07'),
(3, 1, 3, 2, 3, 7, 'Re:start', 'ok', 105, '2019-01-20 19:13:07');

-- --------------------------------------------------------

--
-- Table structure for table `s21_active_form_info`
--

CREATE TABLE `s21_active_form_info` (
  `WF_ID` varchar(64) NOT NULL,
  `UID` int(10) NOT NULL,
  `form_info` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `s21_active_form_info`
--

INSERT INTO `s21_active_form_info` (`WF_ID`, `UID`, `form_info`) VALUES
('bdc65990bf1be8912c720e3c14181247bc39609416f88ca371912d0acbf92163', 8, '{\"form_title\":\"Student CPS Form\",\"Project_Title\":\"A Title\",\"Name_of_Organization\":\"\",\"Street\":\"\",\"Apt#\":\"\",\"City\":\"dad\",\"State\":\"\",\"Zip_Code\":\"\",\"Supervisor\":\"\",\"Supervisors_Phone_Number\":\"\",\"Supervisors_Email\":\"update a\",\"What_are_the_responsibilities_on_site?\":\"\",\"What_special_project_will_you_be_working_on?\":\"\",\"What_do_you_expect_to_learn\":\"\",\"How_is_the_proposal_related_to_your_major_areas_of_interest\":\"\",\"Describe_the_course_work_you_have_completed_which_provides_appropriate_background_to_the_project_\":\"\",\"1_)_What_is_the_proposed_method_of_study?\":\"\",\"Where_appropriate,_cite_readings_and_practical_experienc\":\"well\"}'),
('bdc65990bf1be8912c720e3c14181247bc39609416f88ca371912d0acbf92163', 6, '{\"form_title\":\"Secretary Form\",\"Name\":\"sf\",\"Department\":\"feesfe\",\"Course\":\"ffes\",\"Relevant_Info\":\"dfs\"}'),
('bdc65990bf1be8912c720e3c14181247bc39609416f88ca371912d0acbf92163', 5, '{\"Approved?\":\"\",\"Comments\":\"\",\"form_title\":\"Chair Form\"}'),
('bdc65990bf1be8912c720e3c14181247bc39609416f88ca371912d0acbf92163', 4, '{\"Approved\":\"\",\"Comments\":\"\",\"form_title\":\"Dean\"}'),
('8e464fc71141932cbb58f6946686c09019b7137df736b742a13351a1ebc18dc4', 8, '{\"form_title\":\"Student CPS Form\",\"Project Title\":\"another title\",\"Name of Organization\":\"\",\"Street\":\"\",\"Apt#\":\"\",\"City\":\"\",\"State\":\"\",\"Zip Code\":\"\",\"Supervisor\":\"\",\"Supervisors Phone Number\":\"\",\"Supervisors Email\":\"\",\"What are the responsibilities on site?\":\"\",\"What special project will you be working on?\":\"\",\"What do you expect to learn\":\"\",\"How is the proposal related to your major areas of interest\":\"\",\"Describe the course work you have completed which provides appropriate background to the project \":\"\",\"1 ) What is the proposed method of study?\":\"\",\"Where appropriate, cite readings and practical experienc\":\"\"}'),
('8e464fc71141932cbb58f6946686c09019b7137df736b742a13351a1ebc18dc4', 6, '{\"form_title\":\"Secretary Form\",\"Name\":\"a name\",\"Department\":\"a department\",\"Course\":\"a course\",\"Relevant Info\":\"a form\"}'),
('8e464fc71141932cbb58f6946686c09019b7137df736b742a13351a1ebc18dc4', 5, '{\"Approved?\":\"\",\"Comments\":\"\",\"form_title\":\"Chair Form\"}'),
('8e464fc71141932cbb58f6946686c09019b7137df736b742a13351a1ebc18dc4', 4, '{\"Approved\":\"\",\"Comments\":\"\",\"form_title\":\"Dean\"}'),
('d04fc68723026351589c3a5ebec31c8bf956660d13d7ae7682fb112f626366d9', 8, '{\"Project Title\":\"\",\"Name of Organization\":\"\",\"Street\":\"\",\"Apt#\":\"\",\"City\":\"\",\"State\":\"\",\"Zip Code\":\"\",\"Supervisor\":\"\",\"Supervisors Phone Number\":\"\",\"Supervisors Email\":\"\",\"What are the responsibilities on site?\":\"\",\"What special project will you be working on?\":\"\",\"What do you expect to learn\":\"\",\"How is the proposal related to your major areas of interest\":\"\",\"Describe the course work you have completed which provides appropriate background to the project.\":\"\",\"1.) What is the proposed method of study?\":\"\",\"Where appropriate, cite readings and practical experienc\":\"\",\"form_title\":\"Student CPS Form\"}'),
('d04fc68723026351589c3a5ebec31c8bf956660d13d7ae7682fb112f626366d9', 6, '{\"Name\":\"\",\"Department\":\"\",\"Course\":\"\",\"Relevant Info\":\"\",\"form_title\":\"Secretary Form\"}'),
('d04fc68723026351589c3a5ebec31c8bf956660d13d7ae7682fb112f626366d9', 5, '{\"Approved?\":\"\",\"Comments\":\"\",\"form_title\":\"Chair Form\"}'),
('d04fc68723026351589c3a5ebec31c8bf956660d13d7ae7682fb112f626366d9', 4, '{\"Approved\":\"\",\"Comments\":\"\",\"form_title\":\"Dean\"}'),
('41b2355674906b9be0ba33a24d95fe1242d7280b43a4dd8fb2361dc33d3de145', 8, '{\"Field124\":\"\",\"form_title\":\"Form test 2\"}'),
('41b2355674906b9be0ba33a24d95fe1242d7280b43a4dd8fb2361dc33d3de145', 6, '{\"Field 2\":\"\",\"Field 3\":\"\",\"form_title\":\"Final Test 1\"}'),
('41b2355674906b9be0ba33a24d95fe1242d7280b43a4dd8fb2361dc33d3de145', 5, '{\"f3\":\"\",\"form_title\":\"chair form final review\"}'),
('41b2355674906b9be0ba33a24d95fe1242d7280b43a4dd8fb2361dc33d3de145', 4, '{\"field 1\":\"\",\"f2\":\"\",\"form_title\":\"test form final 2\"}'),
('9666f87a2139a8e88ee897a3eeee3d79204c83b9d722487ea1cf39adb4df0436', 8, '{\"form_title\":\"Student Final Presentation\",\"Field 1\":\"John Doe\",\"ABC\":\"123\"}'),
('9666f87a2139a8e88ee897a3eeee3d79204c83b9d722487ea1cf39adb4df0436', 6, '{\"Field 1\":\"\",\"Field 2\":\"\",\"Field abc\":\"\",\"form_title\":\"Final Presentation Form\"}'),
('9666f87a2139a8e88ee897a3eeee3d79204c83b9d722487ea1cf39adb4df0436', 5, '{\"Field 1\":\"\",\"Field 2\":\"\",\"form_title\":\"Chair Final Presentation\"}'),
('9666f87a2139a8e88ee897a3eeee3d79204c83b9d722487ea1cf39adb4df0436', 4, '{\"Field 1\":\"\",\"form_title\":\"Dean Form Final Presentation\"}'),
('1de85d71c70afaa3b45bde8a6fd41a3e17958e6154e4138a89f6883eb58239f0', 0, '{\"Name\":\"\",\"Department\":\"\",\"Course\":\"\",\"Relevant Info\":\"\",\"form_title\":\"Secretary Form\"}'),
('1de85d71c70afaa3b45bde8a6fd41a3e17958e6154e4138a89f6883eb58239f0', 0, '{\"Name\":\"\",\"Last Name\":\"\",\"N#\":\"\",\"Birthday\":\"\"}'),
('1de85d71c70afaa3b45bde8a6fd41a3e17958e6154e4138a89f6883eb58239f0', 0, ''),
('1de85d71c70afaa3b45bde8a6fd41a3e17958e6154e4138a89f6883eb58239f0', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `s21_active_workflow_ids`
--

CREATE TABLE `s21_active_workflow_ids` (
  `WF_ID` varchar(64) NOT NULL DEFAULT '0',
  `RCRG_ID` int(11) DEFAULT NULL,
  `CRC_ID` int(11) DEFAULT NULL,
  `DN_ID` int(11) DEFAULT NULL,
  `CHR_ID` int(11) DEFAULT NULL,
  `SCRTY_ID` int(11) DEFAULT NULL,
  `STDNT_ID` int(11) DEFAULT NULL,
  `EMP_ID` int(11) DEFAULT NULL,
  `FCLTY_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `s21_active_workflow_ids`
--

INSERT INTO `s21_active_workflow_ids` (`WF_ID`, `RCRG_ID`, `CRC_ID`, `DN_ID`, `CHR_ID`, `SCRTY_ID`, `STDNT_ID`, `EMP_ID`, `FCLTY_ID`) VALUES
('000246f3601dcc47b69bff3b30ab3d2d7e2c72ae93a7a265ce30e0eeb20e453f', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('07561af10a49ca2f693b19719387250e0b4d7611058443ca9aa69c085af3f64f', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('1bb6b7aa7e43445ecc75f43cf9694fbad00efecfc44cafa98ae4bdd72335738c', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('1de85d71c70afaa3b45bde8a6fd41a3e17958e6154e4138a89f6883eb58239f0', NULL, NULL, 0, 0, 0, 0, NULL, NULL),
('2a21acc4fb8703ce5fd3d05f51b89adf6222237a7fc1498c1ea2afeb9e4c1862', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('32628adc020b520c488bb82b9ec59cd5ba72a20e19321a8e56310e4a33a42912', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('41b2355674906b9be0ba33a24d95fe1242d7280b43a4dd8fb2361dc33d3de145', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('43c37e45b0921d3bbef4afd44014f40a8a5b2d6fa6a74ad2752a27f267cc5eaa', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('4d7f69da0613c803b52d3f1d9fcf6c5735291bf8f50db3217165be92a07cc77e', NULL, NULL, 0, 0, 0, 0, NULL, NULL),
('4ffc4390e3a37810f5f2021db2a7568be3a193d6c2c9f54c512f2867d4f9585e', NULL, NULL, 4, NULL, 6, 8, NULL, NULL),
('64bf73645c5f2b1fffba8c24be0c5b219918205a070179a3d84a4dae09c8023f', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('6aa9953e4d73b02b70b8ec83933402ad656a5e89b5cf99e034dac53290b0b79c', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('8e464fc71141932cbb58f6946686c09019b7137df736b742a13351a1ebc18dc4', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('9666f87a2139a8e88ee897a3eeee3d79204c83b9d722487ea1cf39adb4df0436', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('9e46ef76e4f951c1c0b59823840d9b9f4ab4ff71358cedec34c69465f2bde33d', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('afb93f102aa16a8c493203dce08b020fd14c574a53d327172826e69f972654ed', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('bdc65990bf1be8912c720e3c14181247bc39609416f88ca371912d0acbf92163', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('bec220ffe5261e940e495ef66eeb365d472239c0974d20a15e3fa516dfd13734', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('c0945c2d84788b8a1f641b65dff5716b22f18b6fa192102f5a1b569700f5a2ce', NULL, NULL, 0, 0, 0, 0, NULL, NULL),
('c3b25cee7b479fc1cf34424734ab68b2d4e25249c602d36e1dc9d9bcef9608df', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('cd40e7e2e37845f4e1c54e1c28ce427b039821bcd97b100fb65ea36edcc8cee6', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('d04fc68723026351589c3a5ebec31c8bf956660d13d7ae7682fb112f626366d9', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('e08bb4920cd2079701deeb020844da342b12ce46bb5064e883c152d00131c31f', NULL, NULL, 4, 5, 6, 8, NULL, NULL),
('fcb3da15a07e5cabe45e44f92146e201e5da0dfbcf8f7f77d02ff79fec9b4694', NULL, NULL, 4, 5, 6, 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `s21_active_workflow_info`
--

CREATE TABLE `s21_active_workflow_info` (
  `WF_ID` varchar(64) NOT NULL,
  `ATPID` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `student_email` varchar(128) NOT NULL,
  `priority` varchar(64) NOT NULL,
  `deadline` datetime NOT NULL,
  `status` varchar(75) NOT NULL DEFAULT 'In-Progress',
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `s21_active_workflow_info`
--

INSERT INTO `s21_active_workflow_info` (`WF_ID`, `ATPID`, `title`, `student_email`, `priority`, `deadline`, `status`, `created`) VALUES
('1de85d71c70afaa3b45bde8a6fd41a3e17958e6154e4138a89f6883eb58239f0', 33, 'Spring22 Testing', '', 'urgent', '0000-00-00 00:00:00', 'In-Progress', '2022-02-09 23:31:48'),
('41b2355674906b9be0ba33a24d95fe1242d7280b43a4dd8fb2361dc33d3de145', 55, 'Final Workflow Template Test1', '', 'normal', '2021-05-14 21:19:00', 'In-Progress', '2021-05-11 01:19:54'),
('8e464fc71141932cbb58f6946686c09019b7137df736b742a13351a1ebc18dc4', 36, '', '', 'urgent', '2021-04-28 01:09:00', '', '0000-00-00 00:00:00'),
('9666f87a2139a8e88ee897a3eeee3d79204c83b9d722487ea1cf39adb4df0436', 56, 'My Final Presentation', '', 'normal', '2021-05-14 16:39:00', 'In-Progress', '2021-05-11 20:40:25'),
('bdc65990bf1be8912c720e3c14181247bc39609416f88ca371912d0acbf92163', 36, '', '', 'urgent', '2021-04-24 21:01:00', '', '0000-00-00 00:00:00'),
('d04fc68723026351589c3a5ebec31c8bf956660d13d7ae7682fb112f626366d9', 36, 'Test WF', '', 'normal', '2021-04-24 16:34:00', 'In-Progress', '2021-04-30 20:34:45');

-- --------------------------------------------------------

--
-- Table structure for table `s21_active_workflow_status`
--

CREATE TABLE `s21_active_workflow_status` (
  `WF_ID` varchar(64) NOT NULL,
  `admin_status` int(11) DEFAULT 4,
  `student_status` int(11) DEFAULT 4,
  `career_status` int(11) DEFAULT 4,
  `records_status` int(11) DEFAULT 4,
  `dean_status` int(11) DEFAULT 4,
  `chair_status` int(11) DEFAULT 4,
  `secretary_status` int(11) DEFAULT 4,
  `faculty_status` int(11) DEFAULT 4,
  `supervisor_status` int(11) DEFAULT 4
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `s21_active_workflow_status`
--

INSERT INTO `s21_active_workflow_status` (`WF_ID`, `admin_status`, `student_status`, `career_status`, `records_status`, `dean_status`, `chair_status`, `secretary_status`, `faculty_status`, `supervisor_status`) VALUES
('1de85d71c70afaa3b45bde8a6fd41a3e17958e6154e4138a89f6883eb58239f0', 4, 4, 4, 4, 4, 4, 4, 4, 4),
('41b2355674906b9be0ba33a24d95fe1242d7280b43a4dd8fb2361dc33d3de145', 4, 4, 4, 4, 4, 4, 4, 4, 4),
('8e464fc71141932cbb58f6946686c09019b7137df736b742a13351a1ebc18dc4', 4, 2, 4, 4, 4, 4, 1, 4, 4),
('9666f87a2139a8e88ee897a3eeee3d79204c83b9d722487ea1cf39adb4df0436', 4, 1, 4, 4, 4, 4, 4, 4, 4),
('bdc65990bf1be8912c720e3c14181247bc39609416f88ca371912d0acbf92163', 4, 2, 4, 4, 4, 4, 2, 4, 4),
('d04fc68723026351589c3a5ebec31c8bf956660d13d7ae7682fb112f626366d9', 4, 4, 4, 4, 4, 4, 4, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `s21_course_workflow_steps`
--

CREATE TABLE `s21_course_workflow_steps` (
  `ATPID` int(11) NOT NULL,
  `TSID` int(11) NOT NULL,
  `workflow_title` varchar(30) NOT NULL,
  `form_assignments` varchar(700) NOT NULL,
  `instructions` varchar(255) NOT NULL,
  `dept_code` char(6) NOT NULL,
  `course_number` int(3) NOT NULL,
  `form_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `s21_course_workflow_steps`
--

INSERT INTO `s21_course_workflow_steps` (`ATPID`, `TSID`, `workflow_title`, `form_assignments`, `instructions`, `dept_code`, `course_number`, `form_type`) VALUES
(33, 1, 'Demo Workflow', '{\"Secretary\":\"Secretary Form\",\"Student\":\"Student Form\",\"Chair\":\"Chair Approval Form\",\"Dean\":\"Dean Approval Form\"}', 'Secretary=>Student=>Chair=>Dean', '', 442, 'internship'),
(34, 1, 'Course1', '{\"Student\":\"Student Form\",\"Secretary\":\"Secretary Form\",\"Chair\":\"Chair Approval Form\",\"Dean\":\"Dean Approval Form\"}', 'Student=>Secretary=>Chair=>Dean', '', 0, 'internship'),
(36, 1, 'Course3', '{\"Student\":\"Student CPS Form\",\"Secretary\":\"Secretary Form\",\"Chair\":\"Chair Form\",\"Dean\":\"Dean\"}', 'Student=>Secretary=>Chair=>Dean', '', 442, 'internship'),
(53, 1, 'CourseTest', '{\"Student\":\"Student Form\",\"Secretary\":\"Secretary Form\",\"Dean\":\"Dean\",\"Chair\":\"Chair Form\"}', 'Student=>Secretary=>Dean=>Chair', '', 442, 'internship'),
(56, 1, 'Final Presentation Workflow Te', '{\"Student\":\"Student Final Presentation\",\"Secretary\":\"Final Presentation Form\",\"Chair\":\"Chair Final Presentation\",\"Dean\":\"Dean Form Final Presentation\"}', 'Student=>Secretary=>Chair=>Dean', '', 442, 'internship');

-- --------------------------------------------------------

--
-- Table structure for table `s21_form_templates`
--

CREATE TABLE `s21_form_templates` (
  `TID` int(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `instructions` varchar(1000) NOT NULL,
  `user_access_role` int(11) NOT NULL,
  `created` date NOT NULL,
  `changed` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `s21_form_templates`
--

INSERT INTO `s21_form_templates` (`TID`, `title`, `instructions`, `user_access_role`, `created`, `changed`) VALUES
(24, 'Student Form', '{\"Name\":\"\",\"Last Name\":\"\",\"N#\":\"\",\"Birthday\":\"\"}', 8, '0000-00-00', '0000-00-00'),
(26, 'CPS Student  Form', '{\"Full Name\":\"\",\"Outcome1\":\"\",\"Project Proposal\":\"\",\"N#\":\"\",\"Birthday\":\"\"}', 8, '0000-00-00', '0000-00-00'),
(30, 'Test 4/20', '{\"name\":\"\",\"email\":\"\",\"dob\":\"\"}', 9, '0000-00-00', '0000-00-00'),
(32, 'Student CPS Form', '{\"Project Title\":\"\",\"Name of Organization\":\"\",\"Street\":\"\",\"Apt#\":\"\",\"City\":\"\",\"State\":\"\",\"Zip Code\":\"\",\"Supervisor\":\"\",\"Supervisors Phone Number\":\"\",\"Supervisors Email\":\"\",\"What are the responsibilities on site?\":\"\",\"What special project will you be working on?\":\"\",\"What do you expect to learn\":\"\",\"How is the proposal related to your major areas of interest\":\"\",\"Describe the course work you have completed which provides appropriate background to the project.\":\"\",\"1.) What is the proposed method of study?\":\"\",\"Where appropriate, cite readings and practical experienc\":\"\",\"form_title\":\"Student CPS Form\"}', 8, '0000-00-00', '0000-00-00'),
(36, 'Secretary Form', '{\"Name\":\"\",\"Department\":\"\",\"Course\":\"\",\"Relevant Info\":\"\",\"form_title\":\"Secretary Form\"}', 6, '0000-00-00', '0000-00-00'),
(37, 'Chair Form', '{\"Approved?\":\"\",\"Comments\":\"\",\"form_title\":\"Chair Form\"}', 5, '0000-00-00', '0000-00-00'),
(38, 'Dean', '{\"Approved\":\"\",\"Comments\":\"\",\"form_title\":\"Dean\"}', 4, '0000-00-00', '0000-00-00'),
(39, '', '{\"field1\":\"\",\"form_title\":\"\"}', 8, '0000-00-00', '0000-00-00'),
(40, 'test', '{\"fidl1\":\"\",\"form_title\":\"test\"}', 7, '0000-00-00', '0000-00-00'),
(41, 'Test3 Form', '{\"Test Some Field\":\"\",\"form_title\":\"Test3 Form\"}', 0, '0000-00-00', '0000-00-00'),
(43, 'Final Test 1', '{\"Field 2\":\"\",\"Field 3\":\"\",\"form_title\":\"Final Test 1\"}', 6, '0000-00-00', '0000-00-00'),
(44, 'test form final 2', '{\"field 1\":\"\",\"f2\":\"\",\"form_title\":\"test form final 2\"}', 4, '0000-00-00', '0000-00-00'),
(45, 'chair form final review', '{\"f3\":\"\",\"form_title\":\"chair form final review\"}', 5, '0000-00-00', '0000-00-00'),
(46, 'Form test 2', '{\"Field124\":\"\",\"form_title\":\"Form test 2\"}', 0, '0000-00-00', '0000-00-00'),
(47, 'Form Test for Report', '{\"This is a field\":\"\",\"This is also a field\":\"\",\"input me please\":\"\",\"form_title\":\"Form Test for Report\"}', 5, '0000-00-00', '0000-00-00'),
(48, 'Final Presentation Form', '{\"Field 1\":\"\",\"Field 2\":\"\",\"Field abc\":\"\",\"form_title\":\"Final Presentation Form\"}', 6, '0000-00-00', '0000-00-00'),
(49, 'Chair Final Presentation', '{\"Field 1\":\"\",\"Field 2\":\"\",\"form_title\":\"Chair Final Presentation\"}', 5, '0000-00-00', '0000-00-00'),
(50, 'Student Final Presentation', '{\"Field 1\":\"\",\"ABC\":\"\",\"form_title\":\"Student Final Presentation\"}', 8, '0000-00-00', '0000-00-00'),
(51, 'Dean Form Final Presentation', '{\"Field 1\":\"\",\"form_title\":\"Dean Form Final Presentation\"}', 4, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `s21_step_status_table`
--

CREATE TABLE `s21_step_status_table` (
  `SSID` int(11) NOT NULL,
  `title` varchar(15) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `s21_step_status_table`
--

INSERT INTO `s21_step_status_table` (`SSID`, `title`, `info`) VALUES
(1, 'Approved', 'Step has been completed and can no longer be modified.'),
(2, 'In-Progress', 'At least one user is still working on the step.'),
(3, 'Rejected', 'At least one user has rejected the step.'),
(4, 'Deleted', 'No longer visible to the users.'),
(5, 'No Started', 'The user has not been given permission to start their part.');

-- --------------------------------------------------------

--
-- Table structure for table `s22_login_logs`
--

CREATE TABLE `s22_login_logs` (
  `LLID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `login_date` date NOT NULL,
  `is_successful` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `s22_login_logs`
--

INSERT INTO `s22_login_logs` (`LLID`, `UID`, `login_date`, `is_successful`) VALUES
(1, 0, '2022-02-25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `s22_pwdreset`
--

CREATE TABLE `s22_pwdreset` (
  `pwdResetID` int(11) NOT NULL,
  `pwdResetEmail` text NOT NULL,
  `pwdResetSelector` text NOT NULL,
  `pwdResetToken` longtext NOT NULL,
  `pwdResetExpires` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `taskDetails_T`
--

CREATE TABLE `taskDetails_T` (
  `task_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `data_id` int(10) NOT NULL,
  `taskPart_status` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `taskDetails_T`
--

INSERT INTO `taskDetails_T` (`task_id`, `user_id`, `data_id`, `taskPart_status`) VALUES
(2, 3, 105, 1),
(2, 5, 105, 1),
(2, 7, 105, 0);

-- --------------------------------------------------------

--
-- Table structure for table `taskStatus_T`
--

CREATE TABLE `taskStatus_T` (
  `taskStatus_id` int(10) NOT NULL,
  `taskStatus_title` varchar(250) NOT NULL,
  `taskStatus_info` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taskStatus_T`
--

INSERT INTO `taskStatus_T` (`taskStatus_id`, `taskStatus_title`, `taskStatus_info`) VALUES
(1, 'approved', 'task that has been done, cannot be changed'),
(2, 'in progress', 'at least one user is still in progress'),
(3, 'rejected', 'task that has at least one user rejected'),
(4, 'deleted', 'not visible anymore');

-- --------------------------------------------------------

--
-- Table structure for table `taskTemplateDetails_T`
--

CREATE TABLE `taskTemplateDetails_T` (
  `taskTemplate_id` int(10) NOT NULL,
  `userRole_id` int(10) NOT NULL,
  `dataType_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taskTemplateDetails_T`
--

INSERT INTO `taskTemplateDetails_T` (`taskTemplate_id`, `userRole_id`, `dataType_id`) VALUES
(1, 2, 4),
(1, 3, 4),
(1, 4, 4),
(2, 2, 5),
(2, 3, 5),
(2, 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `taskTemplate_T`
--

CREATE TABLE `taskTemplate_T` (
  `taskTemplate_id` int(10) NOT NULL,
  `policy_id` int(10) NOT NULL,
  `task_type` int(10) NOT NULL,
  `task_title` varchar(50) NOT NULL,
  `task_instructions` varchar(250) DEFAULT NULL,
  `templateStatus_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taskTemplate_T`
--

INSERT INTO `taskTemplate_T` (`taskTemplate_id`, `policy_id`, `task_type`, `task_title`, `task_instructions`, `templateStatus_id`) VALUES
(1, 2, 2, 'report', 'Manager creates report file and adds part A,B, and C; staff view part B; customer view part C', 1),
(2, 3, 1, 'travel', 'Manager creates travel form and fill-in part A, staff fill-in part B, customer view and sign-in part C', 1);

-- --------------------------------------------------------

--
-- Table structure for table `task_T`
--

CREATE TABLE `task_T` (
  `task_id` int(3) NOT NULL,
  `task_status` int(3) NOT NULL,
  `task_title` varchar(100) NOT NULL,
  `task_instructions` varchar(255) NOT NULL,
  `task_type` int(3) NOT NULL,
  `contract_id` int(3) NOT NULL,
  `task_owner` int(3) NOT NULL,
  `task_deadline` datetime NOT NULL,
  `task_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task_T`
--

INSERT INTO `task_T` (`task_id`, `task_status`, `task_title`, `task_instructions`, `task_type`, `contract_id`, `task_owner`, `task_deadline`, `task_created`) VALUES
(1, 1, 'ABC Company Report', 'The manager uploads part A, the staff adds and upload part B and customer can view (download) it.', 2, 0, 2, '2021-01-19 05:10:28', '2019-01-19 09:13:07'),
(2, 1, 'TV repair Trip', 'Manager creates/selects a travel form. Staff fill-in Traveler’s name and Travel Mode. Manager selects the Total Cost. Customer views and signs with full name.', 1, 3, 3, '2021-01-19 09:13:07', '2019-01-19 09:13:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `f20_app_details_table`
--
ALTER TABLE `f20_app_details_table`
  ADD KEY `AID` (`AID`),
  ADD KEY `SID` (`SID`);

--
-- Indexes for table `f20_app_status_table`
--
ALTER TABLE `f20_app_status_table`
  ADD PRIMARY KEY (`ASID`);

--
-- Indexes for table `f20_app_table`
--
ALTER TABLE `f20_app_table`
  ADD PRIMARY KEY (`AID`),
  ADD KEY `ASID` (`ASID`),
  ADD KEY `ATID` (`ATID`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `f20_app_type_table`
--
ALTER TABLE `f20_app_type_table`
  ADD PRIMARY KEY (`ATID`);

--
-- Indexes for table `f20_course_numbers`
--
ALTER TABLE `f20_course_numbers`
  ADD PRIMARY KEY (`course_number`,`id`) USING BTREE,
  ADD UNIQUE KEY `course_number` (`course_number`),
  ADD KEY `dept_code` (`dept_code`),
  ADD KEY `id` (`id`) USING BTREE;

--
-- Indexes for table `f20_datastatus_t`
--
ALTER TABLE `f20_datastatus_t`
  ADD PRIMARY KEY (`dataStatus_id`);

--
-- Indexes for table `f20_datatype_t`
--
ALTER TABLE `f20_datatype_t`
  ADD PRIMARY KEY (`dataType_id`);

--
-- Indexes for table `f20_data_t`
--
ALTER TABLE `f20_data_t`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `dataStatus_id` (`dataStatus_id`),
  ADD KEY `dataType_id` (`dataType_id`);

--
-- Indexes for table `f20_file_upload`
--
ALTER TABLE `f20_file_upload`
  ADD PRIMARY KEY (`fileID`);

--
-- Indexes for table `f20_messagestatus_t`
--
ALTER TABLE `f20_messagestatus_t`
  ADD PRIMARY KEY (`messageStatus_id`);

--
-- Indexes for table `f20_messagetype_t`
--
ALTER TABLE `f20_messagetype_t`
  ADD PRIMARY KEY (`messageType_id`);

--
-- Indexes for table `f20_message_t`
--
ALTER TABLE `f20_message_t`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `message_status` (`message_status`),
  ADD KEY `message_type` (`message_type`);

--
-- Indexes for table `f20_step_details_table`
--
ALTER TABLE `f20_step_details_table`
  ADD KEY `SID` (`SID`),
  ADD KEY `UID` (`UID`),
  ADD KEY `DID` (`DID`),
  ADD KEY `SSID` (`SSID`);

--
-- Indexes for table `f20_step_table`
--
ALTER TABLE `f20_step_table`
  ADD PRIMARY KEY (`SID`),
  ADD KEY `SSID` (`SSID`),
  ADD KEY `STID` (`STID`),
  ADD KEY `UID` (`UID`);

--
-- Indexes for table `f20_step_type_table`
--
ALTER TABLE `f20_step_type_table`
  ADD PRIMARY KEY (`STID`);

--
-- Indexes for table `f20_template_status_table`
--
ALTER TABLE `f20_template_status_table`
  ADD PRIMARY KEY (`TSID`);

--
-- Indexes for table `f20_user_role_table`
--
ALTER TABLE `f20_user_role_table`
  ADD PRIMARY KEY (`URID`);

--
-- Indexes for table `f20_user_status_table`
--
ALTER TABLE `f20_user_status_table`
  ADD PRIMARY KEY (`USID`);

--
-- Indexes for table `f20_user_table`
--
ALTER TABLE `f20_user_table`
  ADD PRIMARY KEY (`UID`),
  ADD UNIQUE KEY `user_login_name` (`user_login_name`),
  ADD KEY `USID` (`USID`),
  ADD KEY `URID` (`URID`);

--
-- Indexes for table `f20_user_validation`
--
ALTER TABLE `f20_user_validation`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `jobDetails_T`
--
ALTER TABLE `jobDetails_T`
  ADD PRIMARY KEY (`job_id`,`task_id`,`job_taskOrder`);

--
-- Indexes for table `jobStatus_T`
--
ALTER TABLE `jobStatus_T`
  ADD PRIMARY KEY (`jobStatus_id`);

--
-- Indexes for table `jobTemplateDetails_T`
--
ALTER TABLE `jobTemplateDetails_T`
  ADD PRIMARY KEY (`job_taskOrder`);

--
-- Indexes for table `jobTemplate_T`
--
ALTER TABLE `jobTemplate_T`
  ADD PRIMARY KEY (`jobTemplate_id`);

--
-- Indexes for table `jobType_T`
--
ALTER TABLE `jobType_T`
  ADD PRIMARY KEY (`jobType_id`);

--
-- Indexes for table `job_T`
--
ALTER TABLE `job_T`
  ADD PRIMARY KEY (`job_id`);

--
-- Indexes for table `s21_active_workflow_ids`
--
ALTER TABLE `s21_active_workflow_ids`
  ADD PRIMARY KEY (`WF_ID`);

--
-- Indexes for table `s21_active_workflow_info`
--
ALTER TABLE `s21_active_workflow_info`
  ADD PRIMARY KEY (`WF_ID`,`student_email`) USING BTREE,
  ADD KEY `s20_application_info_ibfk_2` (`student_email`);

--
-- Indexes for table `s21_active_workflow_status`
--
ALTER TABLE `s21_active_workflow_status`
  ADD PRIMARY KEY (`WF_ID`);

--
-- Indexes for table `s21_course_workflow_steps`
--
ALTER TABLE `s21_course_workflow_steps`
  ADD PRIMARY KEY (`ATPID`),
  ADD KEY `TSID` (`TSID`);

--
-- Indexes for table `s21_form_templates`
--
ALTER TABLE `s21_form_templates`
  ADD PRIMARY KEY (`TID`);

--
-- Indexes for table `s21_step_status_table`
--
ALTER TABLE `s21_step_status_table`
  ADD PRIMARY KEY (`SSID`);

--
-- Indexes for table `s22_login_logs`
--
ALTER TABLE `s22_login_logs`
  ADD PRIMARY KEY (`LLID`),
  ADD UNIQUE KEY `UID` (`UID`);

--
-- Indexes for table `s22_pwdreset`
--
ALTER TABLE `s22_pwdreset`
  ADD PRIMARY KEY (`pwdResetID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `f20_app_status_table`
--
ALTER TABLE `f20_app_status_table`
  MODIFY `ASID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `f20_app_table`
--
ALTER TABLE `f20_app_table`
  MODIFY `AID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `f20_app_type_table`
--
ALTER TABLE `f20_app_type_table`
  MODIFY `ATID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `f20_course_numbers`
--
ALTER TABLE `f20_course_numbers`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `f20_data_t`
--
ALTER TABLE `f20_data_t`
  MODIFY `data_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `f20_file_upload`
--
ALTER TABLE `f20_file_upload`
  MODIFY `fileID` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `f20_messagestatus_t`
--
ALTER TABLE `f20_messagestatus_t`
  MODIFY `messageStatus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `f20_messagetype_t`
--
ALTER TABLE `f20_messagetype_t`
  MODIFY `messageType_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `f20_message_t`
--
ALTER TABLE `f20_message_t`
  MODIFY `message_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `f20_step_table`
--
ALTER TABLE `f20_step_table`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `f20_step_type_table`
--
ALTER TABLE `f20_step_type_table`
  MODIFY `STID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `f20_template_status_table`
--
ALTER TABLE `f20_template_status_table`
  MODIFY `TSID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `f20_user_table`
--
ALTER TABLE `f20_user_table`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `s21_course_workflow_steps`
--
ALTER TABLE `s21_course_workflow_steps`
  MODIFY `ATPID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `s21_form_templates`
--
ALTER TABLE `s21_form_templates`
  MODIFY `TID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `s21_step_status_table`
--
ALTER TABLE `s21_step_status_table`
  MODIFY `SSID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `s22_login_logs`
--
ALTER TABLE `s22_login_logs`
  MODIFY `LLID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `s22_pwdreset`
--
ALTER TABLE `s22_pwdreset`
  MODIFY `pwdResetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `f20_app_details_table`
--
ALTER TABLE `f20_app_details_table`
  ADD CONSTRAINT `f20_app_details_table_ibfk_1` FOREIGN KEY (`AID`) REFERENCES `f20_app_table` (`AID`),
  ADD CONSTRAINT `f20_app_details_table_ibfk_2` FOREIGN KEY (`SID`) REFERENCES `f20_step_table` (`SID`);

--
-- Constraints for table `f20_app_table`
--
ALTER TABLE `f20_app_table`
  ADD CONSTRAINT `f20_app_table_ibfk_1` FOREIGN KEY (`ASID`) REFERENCES `f20_app_status_table` (`ASID`),
  ADD CONSTRAINT `f20_app_table_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `f20_user_table` (`UID`),
  ADD CONSTRAINT `f20_app_table_ibfk_3` FOREIGN KEY (`ATID`) REFERENCES `f20_app_type_table` (`ATID`);

--
-- Constraints for table `f20_data_t`
--
ALTER TABLE `f20_data_t`
  ADD CONSTRAINT `f20_data_T_ibfk_1` FOREIGN KEY (`dataType_id`) REFERENCES `f20_datatype_t` (`dataType_id`),
  ADD CONSTRAINT `f20_data_T_ibfk_2` FOREIGN KEY (`dataStatus_id`) REFERENCES `f20_datastatus_t` (`dataStatus_id`);

--
-- Constraints for table `f20_message_t`
--
ALTER TABLE `f20_message_t`
  ADD CONSTRAINT `f20_message_T_ibfk_1` FOREIGN KEY (`message_status`) REFERENCES `f20_messagestatus_t` (`messageStatus_id`),
  ADD CONSTRAINT `f20_message_T_ibfk_2` FOREIGN KEY (`message_type`) REFERENCES `f20_messagetype_t` (`messageType_id`);

--
-- Constraints for table `f20_step_details_table`
--
ALTER TABLE `f20_step_details_table`
  ADD CONSTRAINT `f20_step_details_table_ibfk_1` FOREIGN KEY (`SID`) REFERENCES `f20_step_table` (`SID`),
  ADD CONSTRAINT `f20_step_details_table_ibfk_2` FOREIGN KEY (`UID`) REFERENCES `f20_user_table` (`UID`),
  ADD CONSTRAINT `f20_step_details_table_ibfk_3` FOREIGN KEY (`DID`) REFERENCES `f20_data_t` (`data_id`),
  ADD CONSTRAINT `f20_step_details_table_ibfk_4` FOREIGN KEY (`SSID`) REFERENCES `s21_step_status_table` (`SSID`);

--
-- Constraints for table `f20_step_table`
--
ALTER TABLE `f20_step_table`
  ADD CONSTRAINT `f20_step_table_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `f20_user_table` (`UID`),
  ADD CONSTRAINT `f20_step_table_ibfk_2` FOREIGN KEY (`SSID`) REFERENCES `s21_step_status_table` (`SSID`),
  ADD CONSTRAINT `f20_step_table_ibfk_3` FOREIGN KEY (`STID`) REFERENCES `f20_step_type_table` (`STID`);

--
-- Constraints for table `f20_user_table`
--
ALTER TABLE `f20_user_table`
  ADD CONSTRAINT `f20_user_table_ibfk_1` FOREIGN KEY (`URID`) REFERENCES `f20_user_role_table` (`URID`),
  ADD CONSTRAINT `f20_user_table_ibfk_2` FOREIGN KEY (`USID`) REFERENCES `f20_user_status_table` (`USID`);

--
-- Constraints for table `s21_course_workflow_steps`
--
ALTER TABLE `s21_course_workflow_steps`
  ADD CONSTRAINT `s21_course_workflow_steps_ibfk_1` FOREIGN KEY (`TSID`) REFERENCES `f20_template_status_table` (`TSID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
