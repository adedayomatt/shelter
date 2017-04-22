-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2017 at 11:34 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shelter`
--

-- --------------------------------------------------------

--
-- Table structure for table `clipped`
--

CREATE TABLE `clipped` (
  `propertyId` char(10) NOT NULL,
  `clippedby` char(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clipped`
--

INSERT INTO `clipped` (`propertyId`, `clippedby`) VALUES
('BFG2527', 'Kayode Matthew148093'),
('VPH8397', 'Kayode Matthew148093'),
('UPG5367', 'Kayode Matthew148093'),
('ANY8018', 'Kayode Matthew148093'),
('DHY8662', 'Kayode Matthew148093'),
('GHO6075', 'Kayode Matthew148093'),
('LDF1165', 'Kayode Matthew148093'),
('XWC8428', 'Kayode Matthew148093'),
('HCF1390', 'Kayode Matthew148093'),
('MVI1839', 'Kayode Matthew148093'),
('MVI1839', 'ade1480507790'),
('MVI1839', 'matto1486543246'),
('BAJ1421', 'ade1480507790'),
('MVI1839', '1492382097'),
('HCF1390', '1492382097');

-- --------------------------------------------------------

--
-- Table structure for table `cta`
--

CREATE TABLE `cta` (
  `ctaid` char(20) NOT NULL,
  `name` char(30) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `email` char(30) DEFAULT NULL,
  `request` tinyint(1) NOT NULL,
  `password` char(30) NOT NULL,
  `datecreated` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cta`
--

INSERT INTO `cta` (`ctaid`, `name`, `phone`, `email`, `request`, `password`, `datecreated`) VALUES
('1492382097', 'Matt', 8139004572, 'adedayomatt@gmail.com', 0, 'xxx', '2017-04-16'),
('ade1480507790', 'ade', 2345, 'dayo@g.com', 0, 'dayo', '2016-11-30'),
('dada1480507488', 'dada', 111, 'a@k.com', 0, 'bed4eb698c6eeea7f1ddf5397d480d', '2016-11-30'),
('dayo1480505748', 'dayo', 123, 'h@h.com', 0, 'b60d121b438a380c343d5ec3c20375', '2016-11-30'),
('Kayode Matthew148093', 'Kayode Matthew', 8139004572, 'adedayomatt@gmail.com', 0, 'adedayo', '2016-12-05'),
('matto1486543246', 'matto', 8139004572, 'adedayomatt@gmail.com', 0, 'ade', '2017-02-08'),
('temp1480507221', 'temp', 12345, 'ff@j.com', 0, 'b8d09b4d8580aacbd9efc4540a9b88', '2016-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `cta_matches`
--

CREATE TABLE `cta_matches` (
  `ctaid` char(20) NOT NULL,
  `match_id` char(10) NOT NULL,
  `seen` char(5) NOT NULL,
  `another` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cta_matches`
--

INSERT INTO `cta_matches` (`ctaid`, `match_id`, `seen`, `another`) VALUES
('ade', 'dayo', 'kay', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cta_request`
--

CREATE TABLE `cta_request` (
  `ctaid` char(20) NOT NULL,
  `type` char(30) NOT NULL,
  `maxprice` int(10) NOT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cta_request`
--

INSERT INTO `cta_request` (`ctaid`, `type`, `maxprice`, `location`) VALUES
('ade1480507790', 'flat', 500000, 'kingston'),
('Kayode Matthew148093', 'Self Contain', 500000, 'ojo');

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `follower` char(50) NOT NULL,
  `following` char(50) NOT NULL,
  `followtype` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`follower`, `following`, `followtype`) VALUES
('Matt', 'Jaguar Enterprise', 'C4A'),
('Matt', 'Dough Enterprise', 'C4A'),
('Matt', 'Ade Super', 'C4A');

-- --------------------------------------------------------

--
-- Table structure for table `messagelinker`
--

CREATE TABLE `messagelinker` (
  `conversationid` int(50) NOT NULL,
  `subject` char(255) NOT NULL,
  `initiator` char(255) NOT NULL,
  `participant` char(255) NOT NULL,
  `totalmsg` int(50) NOT NULL,
  `lastmsg` longtext NOT NULL,
  `sender` char(255) NOT NULL,
  `lastmsgtime` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messagelinker`
--

INSERT INTO `messagelinker` (`conversationid`, `subject`, `initiator`, `participant`, `totalmsg`, `lastmsg`, `sender`, `lastmsgtime`) VALUES
(2147483647, 'no subject', 'Matt', 'Jaguar Enterprise', 1, 'hi Jag', 'Matt', 1492385331);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `conversationid` int(50) NOT NULL,
  `messageid` int(50) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `sender` char(255) NOT NULL,
  `receiver` char(255) NOT NULL,
  `body` longtext NOT NULL,
  `status` char(10) NOT NULL,
  `timestamp` int(20) NOT NULL,
  `extra` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`conversationid`, `messageid`, `subject`, `sender`, `receiver`, `body`, `status`, `timestamp`, `extra`) VALUES
(2147483647, 2147483647, 'no subject', 'Matt', 'Jaguar Enterprise', 'hi Jag', 'unseen', 1492385331, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationid` char(255) NOT NULL,
  `subject` char(255) NOT NULL,
  `subjecttrace` char(255) NOT NULL,
  `receiver` char(255) NOT NULL,
  `action` char(255) NOT NULL,
  `status` char(10) NOT NULL,
  `time` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notificationid`, `subject`, `subjecttrace`, `receiver`, `action`, `status`, `time`) VALUES
('C4A58f4010f56b5a', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1492386063),
('C4A58f4011ecd314', 'Matt', '1492382097', 'Jaguar Enterprise', 'C4Afollow', 'unseen', 1492386078),
('C4A58f407ebd818c', 'Matt', '1492382097', 'Dough Enterprise', 'C4Afollow', 'unseen', 1492387819),
('C4A58f5341cbd7c3', 'Matt', '1492382097', 'Dough Enterprise', 'C4Afollow', 'unseen', 1492464668),
('C4A58f534261db42', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1492464678),
('C4A58f534293bc6d', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1492464681);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `ID` int(10) NOT NULL,
  `Business_Name` varchar(30) NOT NULL,
  `Office_Address` varchar(150) NOT NULL,
  `Office_Tel_No` bigint(11) NOT NULL,
  `Business_email` char(30) NOT NULL,
  `CEO_Name` varchar(30) NOT NULL,
  `Phone_No` bigint(11) NOT NULL,
  `Alt_Phone_No` bigint(11) NOT NULL,
  `email` char(30) NOT NULL,
  `User_ID` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`ID`, `Business_Name`, `Office_Address`, `Office_Tel_No`, `Business_email`, `CEO_Name`, `Phone_No`, `Alt_Phone_No`, `email`, `User_ID`, `password`) VALUES
(1477470316, 'MNO Enterprise', 'lagoon, nigeria, West Africa', 8035476354, 'mno@gmail.com', 'Chals Loveth', 8156565734, 8156565734, 'chals@gmail.com', 'chalz', 'love'),
(1477499146, 'Dough Enterprise', 'lagoon, nigeria, West Africa', 8035476354, 'mno@gmail.com', 'Xender Alexis', 8156565734, 0, 'alexis@gmail.com', 'Dough', 'dil'),
(1477562968, 'Ade Super & Coy.', 'Eleyele Ibadan', 9077667560, 'adesuper@yahoo.com', 'Emmanuel Adesuper kayode', 7078675755, 8156675465, 'edayo@hotmail.com', 'adesuper', 'sup'),
(1477568479, 'Hummer Merchandize', 'please provide us your infomation below and start connecting with your clients', 8098797986, 'hm@w.com', 'Sorry Sir', 8978978687, 8097986789, 'ss@gmail.com', 'sir', 'you'),
(1477596792, 'Gods Will', 'km 9, Arulogun Area', 8098797986, 'goe@gmail.com', 'Godwin Akpokodje', 8978978687, 8156675465, 'goe@gmail.com', 'Godwill', 'god'),
(1477928707, 'Jaguar Enterprise', 'Ibadan, nigeria, West Africa', 8035476353, 'jaguarenterprise@gmail.com', 'Olivia Ericy', 8156565730, 8198798758, 'olivia@gmail.com', 'jaguar', 'olivia'),
(1480093605, 'Floccinaucinihilipilification ', 'Itokun Abeokuta, Nigeria Anglo', 9048877574, 'flha@gmail.com', 'Mato ota', 8139004778, 81390049954, 'matoo@gmail.com', 'mato', 'mat'),
(1480294479, 'Oguns & sons', 'Eleyele Ib"badan''', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Oguns', 'ogun'),
(1480294504, 'Oguns & sons', 'Eleyele Ib"badan''', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Oguns', 'ogun'),
(1480296365, 'Oguns & sons', 'Eleyele Ib"badan''', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Ogunk', 'ogun'),
(1480296426, 'Oguns & sons', 'Eleyele Ib"badan''', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Ogunk', 'ogun'),
(1480296570, 'Oguns & sons', 'Eleyele Ibadan', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Ogun01', 'ade'),
(1480298043, 'Odekunle Nig Ent', 'suite 9, Ondo Street', 7085476587, 'dekunle@yahoo.com', 'Odekunle Afolabi', 8156565734, 8139004572, 'afoo@gmail.com', 'Kunlex', 'kun'),
(1480327660, 'jjj', 'jj', 9999, 'kkk@gmail.com', 'kkk', 99, 0, 'jj@y.com', 'nn', 'mm');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_ID` char(20) NOT NULL,
  `directory` varchar(200) NOT NULL,
  `type` char(20) NOT NULL,
  `location` varchar(100) NOT NULL,
  `rent` mediumint(10) NOT NULL,
  `min_payment` char(20) NOT NULL,
  `bath` tinyint(2) NOT NULL,
  `toilet` tinyint(2) NOT NULL,
  `pumping_machine` char(5) NOT NULL,
  `borehole` char(5) NOT NULL,
  `well` char(5) NOT NULL,
  `tiles` char(5) NOT NULL,
  `parking_space` char(5) NOT NULL,
  `electricity` tinyint(3) NOT NULL,
  `road` tinyint(3) NOT NULL,
  `socialization` tinyint(3) NOT NULL,
  `security` tinyint(3) NOT NULL,
  `description` varchar(250) NOT NULL,
  `uploadby` char(20) NOT NULL,
  `date_uploaded` datetime NOT NULL,
  `timestamp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_ID`, `directory`, `type`, `location`, `rent`, `min_payment`, `bath`, `toilet`, `pumping_machine`, `borehole`, `well`, `tiles`, `parking_space`, `electricity`, `road`, `socialization`, `security`, `description`, `uploadby`, `date_uploaded`, `timestamp`) VALUES
('BAJ1421', 'BAJ1421-Flat-at-kingston', 'Flat', 'kingston', 150000, '1 year', 1, 1, 'Yes', 'No', 'No', 'Yes', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-02-08 09:36:23', 0),
('HCF1390', 'HCF1390-Self-Contain-at-OJO', 'Self Contain', 'OJO', 1200000, '1 year, 6 Months', 1, 1, 'Yes', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2016-12-05 08:24:42', 0),
('IIX9313', 'IIX9313-Office-Space-at-sango-otta', 'Office Space', 'sango otta', 120000, '1 year', 1, 1, 'No', 'No', 'No', 'Yes', 'No', 60, 20, 15, 70, 'great', 'jaguar', '2016-12-03 23:17:24', 0),
('MVI1839', 'MVI1839-Bungalow-at-ijokodo--Ibadan', 'Bungalow', 'ijokodo, Ibadan', 200000, '1 Year', 5, 2, 'Yes', 'Yes', 'No', 'Yes', 'Yes', 60, 50, 80, 30, '', 'jaguar', '2016-12-05 11:01:35', 0),
('OAS3949', 'OAS3949-Semi-detached-House-at-ijokodo,-Ibadan', 'Semi detached House', 'ijokodo, Ibadan', 200000, '1 Year, 6 Months', 1, 1, 'Yes', 'No', 'Yes', 'Yes', 'No', 40, 80, 70, 50, '', 'adesuper', '2016-12-03 10:35:06', 0),
('VES6501', 'VES6501-Bungalow-at-getdg', 'Bungalow', 'getdg', 3456789, '1 year', 3, 1, 'No', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2016-12-03 10:32:25', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cta`
--
ALTER TABLE `cta`
  ADD PRIMARY KEY (`ctaid`);

--
-- Indexes for table `cta_matches`
--
ALTER TABLE `cta_matches`
  ADD PRIMARY KEY (`ctaid`);

--
-- Indexes for table `cta_request`
--
ALTER TABLE `cta_request`
  ADD PRIMARY KEY (`ctaid`);

--
-- Indexes for table `messagelinker`
--
ALTER TABLE `messagelinker`
  ADD PRIMARY KEY (`conversationid`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageid`);
ALTER TABLE `messages` ADD FULLTEXT KEY `body` (`body`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationid`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
