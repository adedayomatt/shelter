-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2018 at 02:59 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activityID` varchar(50) NOT NULL,
  `action` char(50) NOT NULL,
  `subject` char(50) NOT NULL,
  `subject_ID` bigint(20) NOT NULL,
  `subject_Username` char(255) NOT NULL,
  `status` char(10) NOT NULL,
  `otherlink` varchar(150) NOT NULL DEFAULT 'n/a',
  `timestamp` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activityID`, `action`, `subject`, `subject_ID`, `subject_Username`, `status`, `otherlink`, `timestamp`) VALUES
('14956545705925e0aaea6cf', 'CAO', 'Bussy', 1495645827, 'Bussy', 'unseen', 'n/a', 1495654570),
('14956566115925e8a31e56c', 'AAO', 'Owl City', 1495661773, 'owl', 'unseen', 'n/a', 1495656610),
('14956580375925ee3511acc', 'AAO', 'Owl liz', 1495664324, 'owliz', 'unseen', 'n/a', 1495658036),
('14956594385925f3ae09752', 'upload', 'Owl liz', 0, '1495664324', 'unseen', 'n/a', 1495659437),
('14956604835925f7c39f6c9', 'upload', 'Owl liz', 0, '1495664324', 'unseen', 'n/a', 1495660483),
('14956612945925faee96e5b', 'upload', 'Owl liz', 0, '1495664324', 'unseen', 'n/a', 1495661294),
('14957762205927bbdcdbb19', 'upload', 'Owl liz', 0, '1495664324', 'unseen', 'n/a', 1495776220),
('14957765165927bd045f5d6', 'upload', 'Owl liz', 0, '1495664324', 'unseen', 'n/a', 1495776516),
('14957767125927bdc83260b', 'upload', 'Owl liz', 0, '1495664324', 'unseen', 'n/a', 1495776712),
('14957768715927be67060db', 'upload', '', 0, '', 'unseen', 'n/a', 1495776870),
('14957772675927bff309425', 'upload', 'Owl liz', 0, '1495664324', 'unseen', 'n/a', 1495777266),
('14957780405927c2f8bfb08', 'upload', 'Owl liz', 0, '1495664324', 'unseen', 'EGS7748-Boys-Quater-alabata--Abeokua', 1495778040),
('149579685059280c723e50c', 'AAO', 'Owl State', 1495805257, 'owlis', 'unseen', 'n/a', 1495796849),
('1496066718592c2a9eda195', 'upload', 'Hummer Merchandize', 0, '1477568479', 'unseen', 'YBE9285-Flat-Corporate-Estate-', 1496066718),
('14963436295930644d9d685', 'CAO', 'Adedayo', 1496337666, 'Adedayo', 'unseen', 'n/a', 1496343629),
('14969446585939901258e43', 'upload', 'Hummer Merchandize', 0, '1477568479', 'unseen', '-Duplex-sango--ibadan', 1496944657),
('149694469659399038636eb', 'upload', 'Hummer Merchandize', 0, '1477568479', 'unseen', 'TBC9000-Duplex-sango--ibadan', 1496944696),
('14969452585939926a9cd81', 'upload', 'Jaguar Enterprise', 0, '1477928707', 'unseen', 'EFW9761-Hall-ijokodo-ibadan--oyo-state-', 1496945258),
('1497045411593b19a302691', 'upload', 'Hummer Merchandize', 0, '1477568479', 'unseen', 'TTO7532-Self-Contain-ijokodo-ibadan--oyo-state-', 1497045410),
('14976961115945076f7fe59', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'SZW8651-Office-Space-Eleyele--Ibadan', 1497696111),
('1497696421594508a57e13d', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'KXD1355-Office-Space-Eleyele--Ibadan', 1497696421),
('1497696454594508c6f2828', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'ESA9213-Hall-Eleyele--Ibadan', 1497696454),
('1497696491594508eb718c7', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'VRY1851-Hall-Eleyele--Ibadan', 1497696491),
('1497696708594509c46b2de', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'KOM3166-Hall-Eleyele--Ibadan', 1497696708),
('149769754659450d0a1940c', 'upload', '', 0, '', 'unseen', 'WNW9430-Flat-Eleyele--Ibadan', 1497697546),
('14977358115945a28396ba3', 'upload', '', 0, '', 'unseen', 'GYP6633-Land-ijokodo-ibadan--oyo-state-', 1497735810),
('1498165738594c31ea09138', 'upload', '', 0, '', 'unseen', 'MXX6526-Duplex-Ikeja--Lagos', 1498165737),
('1498324072594e9c68e8d49', 'upload', 'Hummer Merchandize', 0, '1477568479', 'unseen', 'OOM9421-Self-Contain-Akoka-campus--Lagos', 1498324072),
('1498325109594ea075e881d', 'upload', 'Hummer Merchandize', 0, '1477568479', 'unseen', 'AQE6669-Boys-Quater-Ologuneru--Olopomewa-side', 1498325109),
('1498412149594ff4754b21e', 'CAO', 'Matthews', 1498409984, 'Matthews', 'unseen', 'n/a', 1498412148),
('14988453275956908f1bf6b', 'upload', 'Dough Enterprise', 0, '1477499146', 'unseen', 'DOZ4397-Semi-detached-House-ikotun--challenge-molete--ibadan', 1498845326),
('1500498927596fcbefa15ff', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'PQU3148-Flat-Funaab', 1500498926),
('1500500340596fd174a1bcc', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'TOI4350-Bungalow-', 1500500340),
('1500500587596fd26b38409', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'QJX6342-Boys-Quater-', 1500500587),
('1500500724596fd2f46af89', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'IKL3132-Self-Contain-Address', 1500500724),
('1500500756596fd314d35bb', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'KDO6326-Hall-', 1500500756),
('1500503967596fdf9f1683f', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'OAS5817-Warehouse-Ikeja,-Lagos', 1500503966),
('1500504047596fdfef64f07', 'upload', 'Owl City', 0, '1495661773', 'unseen', 'EEG2696-Boys-Quater-Funaab', 1500504047),
('1500504459596fe18b19ca7', 'upload', 'Ade Super & Coy.', 0, '1477562968', 'unseen', 'EFB3597-Self-Contain-Ikeja,-Lagos', 1500504458),
('1500504943596fe36f2815b', 'upload', 'Ade Super & Coy.', 0, '1477562968', 'unseen', 'VGY2633-Office-Space-Ikeja,-Lagos', 1500504943),
('1500521413597023c529033', 'upload', 'Ade Super & Coy.', 0, '1477562968', 'unseen', 'LFR9784-Warehouse-Aba', 1500521412),
('150052416059702e80389f7', 'upload', 'Ade Super & Coy.', 0, '1477562968', 'unseen', 'CFV8600-Land-Ikeja,-Lagos', 1500524159),
('150052425659702ee02df37', 'upload', 'Ade Super & Coy.', 0, '1477562968', 'unseen', 'LNY4564-Duplex-Ikeja,-Lagos', 1500524256),
('1500525054597031fe61fa6', 'upload', 'Ade Super & Coy.', 0, '1477562968', 'unseen', 'ICS9697-Semi-detached-House-Ikeja,-Lagos', 1500525054),
('15005617215970c139eebdf', 'upload', 'Hummer Merchandize', 0, '1477568479', 'unseen', 'FED6627-Office-Space-ijokodo-ibadan,-oyo-state.', 1500561720),
('150066439159725247bfdf4', 'CAO', 'Dayo reals', 1500660041, 'Dayo reals', 'unseen', 'n/a', 1500664390),
('1500668120597260d8991e6', 'upload', 'Jaguar Enterprise', 0, '1477928707', 'unseen', 'IBR6355-Warehouse-ikorodu-lagos', 1500668120),
('1501229345597af1210293d', 'AAO', 'Jaguar Enterprise II', 1501236844, 'jaguar_', 'unseen', 'n/a', 1501229344),
('1501263053597b74cdbe49f', 'upload', 'Hummer Merchandize', 0, '', 'unseen', 'ZVY3413-Office-Space-Eleyele--ibadan', 1501263053),
('1501277657597badd9b3760', 'upload', 'Jaguar Enterprise', 0, '', 'unseen', 'JYP3888-Office-Space-Abeokuta', 1501277657),
('1501279826597bb6526f2d0', 'upload', 'Jaguar Enterprise II', 0, '', 'unseen', 'ZZH2351-Flat-oshodi--lagos', 1501279826),
('1501402898597d9712766af', 'upload', 'Ade Super & Coy.', 0, '', 'unseen', 'NGT7156-Duplex-No-34a--Babatunde-Oyerinde-Street--Ijokodo-Ibadan', 1501402898),
('1501519901597f601d82e0b', 'upload', 'Jaguar Enterprise', 0, '', 'unseen', 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 1501519901),
('150157274859802e8cb5d19', 'upload', 'Dough Enterprise', 0, '', 'unseen', 'HHQ4493-Boys-Quater-Ologuneru--Olopomewa-side', 1501572748),
('150166172959818a21a4389', 'upload', 'Dough Enterprise', 0, '', 'unseen', 'GLY2270-Office-Space-Eleyele--ibadan', 1501661729),
('15018002115983a713abec2', 'upload', 'Owl State', 0, '', 'unseen', 'GWB7379-Office-Space-ikotun--challenge-molete--ibadan', 1501800211),
('150182681359840efdedf6a', 'upload', 'Owl State', 0, '', 'unseen', 'ETB7122-Semi-detached-House-Eleyele--ibadan', 1501826813),
('1501918686598575de4ccf0', 'upload', 'Odekunle Nig Ent', 0, '', 'unseen', 'IYQ7624-Duplex-Apata-ibadan', 1501918686),
('150375797259a186945903f', 'AAO', 'Jaguar Enterpris', 1503761204, 'Dayo', 'unseen', 'n/a', 1503757971),
('150375817459a1875e5a08d', 'AAO', 'Jaguar Enterpri', 1503764033, 'Day', 'unseen', 'n/a', 1503758174);

-- --------------------------------------------------------

--
-- Table structure for table `agent_agent_follow`
--

CREATE TABLE `agent_agent_follow` (
  `agent_follower_id` int(20) NOT NULL,
  `agent_follower_business_name` varchar(255) NOT NULL,
  `agent_follower_username` char(255) NOT NULL,
  `agent_following_id` int(20) NOT NULL,
  `agent_following_business_name` varchar(255) NOT NULL,
  `agent_following_username` char(255) NOT NULL,
  `timestamp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agent_agent_follow`
--

INSERT INTO `agent_agent_follow` (`agent_follower_id`, `agent_follower_business_name`, `agent_follower_username`, `agent_following_id`, `agent_following_business_name`, `agent_following_username`, `timestamp`) VALUES
(1477596792, 'Gods Will', 'Godwill', 1480093605, 'Floccinaucinihilipilification', 'mato', 0),
(1493599503, 'Celine deon organization', 'celine', 1495805257, 'Owl State', 'owlis', 1502290307),
(1477562968, 'Ade Super ', 'adesuper', 1477562968, 'Ade Super ', 'adesuper', 1503744696),
(1477562968, 'Ade Super ', 'adesuper', 1495664324, 'Owl liz', 'owliz', 1503781351),
(1503764033, 'Jaguar Enterpri', 'Day', 1477499146, 'Dough Enterprise', 'Dough', 1503782772),
(1503764033, 'Jaguar Enterpri', 'Day', 1480093605, 'Floccinaucinihilipilification', 'mato', 1503782853),
(1495664324, 'Owl liz', 'owliz', 1480298043, 'Odekunle Nig Ent', 'Kunlex', 1505159278),
(1493599503, 'Celine deon organization', 'celine', 1477596792, 'Gods Will', 'Godwill', 1505915593),
(1477596792, 'Gods Will', 'Godwill', 1495661773, 'Owl City', 'owl', 1512281958),
(1477499146, 'Dough Enterprise', 'Dough', 1503764033, 'Jaguar Enterpri', 'Day', 1513461855),
(1477499146, 'Dough Enterprise', 'Dough', 1493599503, 'Celine deon organization', 'celine', 1513464602),
(1477562968, 'Ade Super ', 'adesuper', 1477928707, 'Jaguar Enterprise', 'jaguar', 1514037710),
(1493599503, 'Celine deon organization', 'celine', 1477928707, 'Jaguar Enterprise', 'jaguar', 1514045565),
(1493599503, 'Celine deon organization', 'celine', 1477499146, 'Dough Enterprise', 'Dough', 1514048186),
(1477499146, 'Dough Enterprise', 'Dough', 1477928707, 'Jaguar Enterprise', 'jaguar', 1514050431),
(1477928707, 'Jaguar Enterprise', 'jaguar', 1477499146, 'Dough Enterprise', 'Dough', 1514331070),
(1477562968, 'Ade Super ', 'adesuper', 1503764033, 'Jaguar Enterpri', 'Day', 1515122177),
(1477928707, 'Jaguar Enterprise', 'jaguar', 1493599503, 'Celine deon organization', 'celine', 1516213021),
(1477928707, 'Jaguar Enterprise', 'jaguar', 1477928707, 'Jaguar Enterprise', 'jaguar', 1516446771),
(1516450078, 'Alowonle properties', 'alowonle', 1477928707, 'Jaguar Enterprise', 'jaguar', 1516447239),
(1516450078, 'Alowonle properties', 'alowonle', 1477562968, 'Ade Super ', 'adesuper', 1516447244),
(1516450078, 'Alowonle properties', 'alowonle', 1477499146, 'Dough Enterprise', 'Dough', 1516447298),
(1515939351, 'Adedayo Kayode Properties', 'adedayokay', 1515939351, 'Adedayo Kayode Properties', 'adedayokay', 1516485409),
(1477928707, 'Jaguar Enterprise', 'jaguar', 1495805257, 'Owl State', 'owlis', 1517331522);

-- --------------------------------------------------------

--
-- Table structure for table `agent_notifications`
--

CREATE TABLE `agent_notifications` (
  `notificationid` varchar(255) NOT NULL,
  `subject` char(255) NOT NULL,
  `subject_username` varchar(255) NOT NULL,
  `subject_id` int(20) NOT NULL,
  `action` char(255) NOT NULL,
  `link` varchar(1000) NOT NULL,
  `receiver` char(255) NOT NULL,
  `receiver_id` int(20) NOT NULL,
  `timestamp` int(20) NOT NULL,
  `status` char(10) DEFAULT 'unseen'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `agent_notifications`
--

INSERT INTO `agent_notifications` (`notificationid`, `subject`, `subject_username`, `subject_id`, `action`, `link`, `receiver`, `receiver_id`, `timestamp`, `status`) VALUES
('1507292784', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Gods Will', 1477596792, 1505825042, 'seen'),
('1508587381', 'Adedayo', 'nil', 1504863885, 'C4A', 'nil', 'Gods Will', 1477596792, 1506584879, 'seen'),
('1508839681', 'Adedayo', 'nil', 1504863885, 'C4A', 'nil', 'Owl City', 1495661773, 1506584494, 'seen'),
('1509352564', 'Adedayo', 'nil', 1504863885, 'C4A', 'nil', 'Dough Enterprise', 1477499146, 1506584864, 'seen'),
('1509662999', 'Celine deon organization', 'celine', 1493599503, 'A4A', 'nil', 'Gods Will', 1477596792, 1505915593, 'seen'),
('1512566595', 'Dough Enterprise', 'Dough', 1477499146, 'A4A', 'nil', 'Dough Enterprise', 1477499146, 1506695532, 'seen'),
('1513934739', 'Adedayo', 'nil', 1504863885, 'C4A', 'nil', 'Jaguar Enterpris', 1503761204, 1506880449, 'seen'),
('1514217524', 'Adedayo', 'nil', 1504863885, 'C4A', 'nil', 'Jaguar Enterprise', 1477928707, 1506585353, 'seen'),
('1514491733', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Dough Enterprise', 1477499146, 1513461246, 'seen'),
('1514761667', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Floccinaucinihilipilification', 1480093605, 1505781199, 'seen'),
('1514828580', 'Adedayo', 'nil', 1504863885, 'C4A', 'nil', 'Celine deon organization', 1493599503, 1507239805, 'seen'),
('1515502321', 'Celine deon organization', 'celine', 1493599503, 'A4A', 'nil', 'Jaguar Enterprise', 1477928707, 1514045565, 'seen'),
('1516063387', 'Dough Enterprise', 'Dough', 1477499146, 'A4A', 'nil', 'Celine deon organization', 1493599503, 1513464602, 'seen'),
('1516374832', 'Dough Enterprise', 'Dough', 1477499146, 'A4A', 'nil', 'Jaguar Enterprise', 1477928707, 1514050431, 'seen'),
('1516434660', 'Celine deon organization', 'celine', 1493599503, 'A4A', 'nil', 'Dough Enterprise', 1477499146, 1514048186, 'seen'),
('1516607192', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Gods Will', 1477596792, 1514260269, 'unseen'),
('1517047090', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Jaguar Enterpri', 1503764033, 1515701296, 'unseen'),
('1517155674', 'nil', 'nil', 0, 'RVN', 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 'Jaguar Enterprise', 1477928707, 1516046086, 'seen'),
('1517474855', 'Dough Enterprise', 'Dough', 1477499146, 'A4A', 'nil', 'Jaguar Enterpri', 1503764033, 1513461855, 'seen'),
('1517604528', 'Gods Will', 'Godwill', 1477596792, 'A4A', 'nil', 'Owl City', 1495661773, 1512281958, 'seen'),
('1517673954', 'nil', 'nil', 0, 'RVN', 'APO5038-Duplex-ibadan', 'Owl liz', 1495664324, 1516046086, 'unseen'),
('1517675292', 'Dare', 'nil', 1515959170, 'C4A', 'nil', 'Owl City', 1495661773, 1515968048, 'unseen'),
('1517714021', 'Dare', 'nil', 1515959170, 'C4A', 'nil', 'Owl State', 1495805257, 1515968050, 'unseen'),
('1517722296', 'nil', 'nil', 0, 'RVN', 'GLY2270-Office-Space-Eleyele--ibadan', 'Dough Enterprise', 1477499146, 1516046088, 'unseen'),
('1517732125', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Celine deon organization', 1493599503, 1516213021, 'unseen'),
('1517741947', 'Alowonle properties', 'alowonle', 1516450078, 'A4A', 'nil', 'Jaguar Enterprise', 1477928707, 1516447239, 'seen'),
('1517825021', 'nil', 'nil', 0, 'RVN', 'OBB8715-Office-Space-nnmm', 'Jaguar Enterprise', 1477928707, 1516046091, 'seen'),
('1517945793', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Alowonle properties', 1516450078, 1516815331, 'unseen'),
('1517980202', 'nil', 'nil', 0, 'RVN', 'KGL6609-Office-Space-ibadan', 'Ade Super & Coy.', 1477562968, 1516046090, 'seen'),
('1518109606', 'Ade Super', 'adesuper', 1477562968, 'A4A', 'nil', 'Jaguar Enterpris', 1503761204, 1515122180, 'unseen'),
('1518227865', 'Ade Super', 'adesuper', 1477562968, 'A4A', 'nil', 'Jaguar Enterprise', 1477928707, 1514037710, 'seen'),
('1518313966', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Alowonle properties', 1516450078, 1516448519, 'seen'),
('1518419103', 'nil', 'nil', 0, 'RVN', 'EHS5005-Bungalow-Agbaje-ijokodo-ibadan', 'Jaguar Enterpris', 1503761204, 1516046087, 'unseen'),
('1518473212', 'nil', 'nil', 0, 'RVN', 'GYP6633-Land-ijokodo-ibadan--oyo-state-', 'Jaguar Enterprise', 1477928707, 1516046088, 'seen'),
('1518614388', 'nil', 'nil', 0, 'RVN', 'KNQ3311-Duplex-uioioij', 'Jaguar Enterprise', 1477928707, 1516046090, 'seen'),
('1518619059', 'nil', 'nil', 0, 'RVN', 'UOX6857-Flat-Ijokodo-Ibadan--Too-state', 'Celine deon organization', 1493599503, 1516046092, 'unseen'),
('1518896734', 'nil', 'nil', 0, 'RVN', 'ETB7122-Semi-detached-House-Eleyele--ibadan', 'Owl State', 1495805257, 1516046088, 'unseen'),
('1519050271', 'nil', 'nil', 0, 'RVN', 'NGT7156-Duplex-No-34a--Babatunde-Oyerinde-Street--Ijokodo-Ibadan', 'Ade Super & Coy.', 1477562968, 1516046091, 'seen'),
('1519284558', 'nil', 'nil', 0, 'RVN', 'YHP3388-Bungalow-Apata--ibadan', 'Owl liz', 1495664324, 1516046094, 'unseen'),
('1519311677', 'Alowonle properties', 'alowonle', 1516450078, 'A4A', 'nil', 'Dough Enterprise', 1477499146, 1516447298, 'unseen'),
('1519358711', 'nil', 'nil', 0, 'RVN', 'IYQ7624-Duplex-Apata-ibadan', 'Odekunle Nig Ent', 1480298043, 1516046089, 'unseen'),
('1519376840', 'nil', 'nil', 0, 'RVN', 'OAS3949-Semi-detached-House-at-ijokodo,-Ibadan', 'Ade Super & Coy.', 1477562968, 1516046091, 'seen'),
('1519388438', 'Matorichy', 'nil', 1512246726, 'C4A', 'nil', 'Jaguar Enterprise', 1477928707, 1514303996, 'seen'),
('1519413092', 'nil', 'nil', 0, 'RVN', 'HHQ4493-Boys-Quater-Ologuneru--Olopomewa-side', 'Dough Enterprise', 1477499146, 1516046088, 'unseen'),
('1519486150', 'nil', 'nil', 0, 'RVN', 'EKB1423-Flat-Eleyele-ibadan', 'Celine deon organization', 1493599503, 1516046087, 'unseen'),
('1519548779', 'nil', 'nil', 0, 'RVN', 'WIB9005-Office-Space-ibadan', 'Ade Super & Coy.', 1477562968, 1516046094, 'seen'),
('1519746800', 'nil', 'nil', 0, 'RVN', 'AHA3569-Self-Contain-Sango-Ottawa-Ogundele-State', 'Jaguar Enterpris', 1503761204, 1516046086, 'unseen'),
('1519835241', 'nil', 'nil', 0, 'RVN', 'EEG2696-Boys-Quater-Funaab', 'Owl City', 1495661773, 1516046087, 'unseen'),
('1519854474', 'nil', 'nil', 0, 'RVN', 'WNW9430-Flat-Eleyele--Ibadan', 'Owl City', 1495661773, 1516046094, 'unseen'),
('1519892647', 'nil', 'nil', 0, 'RVN', 'KXD1355-Office-Space-Eleyele--Ibadan', 'Owl City', 1495661773, 1516046090, 'unseen'),
('1519905833', 'nil', 'nil', 0, 'RVN', 'VES6501-Bungalow-at-getdg', 'Ade Super & Coy.', 1477562968, 1516046092, 'seen'),
('1519944282', 'nil', 'nil', 0, 'RVN', 'ICS9697-Semi-detached-House-Ikeja,-Lagos', 'Ade Super & Coy.', 1477562968, 1516046089, 'seen'),
('1519950050', 'nil', 'nil', 0, 'RVN', 'JYP3888-Office-Space-Abeokuta', 'Jaguar Enterprise', 1477928707, 1516046089, 'seen'),
('1519977792', 'nil', 'nil', 0, 'RVN', 'QJX6342-Boys-Quater-', 'Owl City', 1495661773, 1516046091, 'unseen'),
('1520043607', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Ade Super', 1477562968, 1515961393, 'unseen'),
('1520153884', 'Ade Super', 'adesuper', 1477562968, 'A4A', 'nil', 'Jaguar Enterpri', 1503764033, 1515122177, 'unseen'),
('1520210978', 'nil', 'nil', 0, 'RVN', 'QYQ7568-Shop-apete-ibadan', 'Celine deon organization', 1493599503, 1516046092, 'unseen'),
('1520246339', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Jaguar Enterpri', 1503764033, 1516877687, 'unseen'),
('1520282659', 'nil', 'nil', 0, 'RVN', 'EFB3597-Self-Contain-Ikeja,-Lagos', 'Ade Super & Coy.', 1477562968, 1516046087, 'seen'),
('1520312873', 'nil', 'nil', 0, 'RVN', 'IKL3132-Self-Contain-Address', 'Owl City', 1495661773, 1516046089, 'unseen'),
('1520350230', 'nil', 'nil', 0, 'RVN', 'TOI4350-Bungalow-', 'Owl City', 1495661773, 1516046092, 'unseen'),
('1520489909', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Jaguar Enterpris', 1503761204, 1515504070, 'unseen'),
('1520774025', 'nil', 'nil', 0, 'RVN', 'LFR9784-Warehouse-Aba', 'Ade Super & Coy.', 1477562968, 1516046090, 'seen'),
('1520784691', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Floccinaucinihilipilification', 1480093605, 1514225060, 'seen'),
('1520851752', 'nil', 'nil', 0, 'RVN', 'FXM5524-Bungalow-Apata--ibadan', 'Owl liz', 1495664324, 1516046088, 'unseen'),
('1521087689', 'nil', 'nil', 0, 'RVN', 'VRY1851-Hall-Eleyele--Ibadan', 'Owl City', 1495661773, 1516046094, 'unseen'),
('1521098119', 'nil', 'nil', 0, 'RVN', 'EFW9761-Hall-ijokodo-ibadan--oyo-state-', 'Jaguar Enterprise', 1477928707, 1516046087, 'seen'),
('1521102425', 'Matorichy', 'nil', 1512246726, 'C4A', 'nil', 'Celine deon organization', 1493599503, 1514048135, 'seen'),
('1521125556', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Owl City', 1495661773, 1515503883, 'unseen'),
('1521132410', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Jaguar Enterprise', 1477928707, 1516446772, 'seen'),
('1521232120', 'Dare', 'nil', 1515959170, 'C4A', 'nil', 'Jaguar Enterpris', 1503761204, 1515968052, 'unseen'),
('1521265388', 'nil', 'nil', 0, 'RVN', 'KBA1638-Flat-ijokodo--Ibadan', 'Owl liz', 1495664324, 1516046089, 'unseen'),
('1521337902', 'nil', 'nil', 0, 'RVN', 'VGY2633-Office-Space-Ikeja,-Lagos', 'Ade Super & Coy.', 1477562968, 1516046093, 'seen'),
('1521556249', 'nil', 'nil', 0, 'RVN', 'CFV8600-Land-Ikeja,-Lagos', 'Ade Super & Coy.', 1477562968, 1516046087, 'seen'),
('1521613222', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Owl City', 1495661773, 1515501833, 'unseen'),
('1521640571', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Jaguar Enterprise', 1477928707, 1515796425, 'seen'),
('1521825964', 'Adedayomatt', 'nil', 1515931873, 'C4A', 'nil', 'Jaguar Enterprise', 1477928707, 1515946662, 'seen'),
('1521862498', 'nil', 'nil', 0, 'RVN', 'SAP8871-Duplex-ikorodu-lagos', 'Jaguar Enterprise', 1477928707, 1516046092, 'seen'),
('1521922512', 'Adedayo Kayode Properties', 'adedayokay', 1515939351, 'A4A', 'nil', 'Adedayo Kayode Properties', 1515939351, 1516485409, 'seen'),
('1521966314', 'nil', 'nil', 0, 'RVN', 'DOZ4397-Semi-detached-House-ikotun--challenge-molete--ibadan', 'Dough Enterprise', 1477499146, 1516046087, 'unseen'),
('1522064061', 'Dare', 'nil', 1515959170, 'C4A', 'nil', 'Jaguar Enterpri', 1503764033, 1515968053, 'unseen'),
('1522092656', 'nil', 'nil', 0, 'RVN', 'EGS7748-Boys-Quater-alabata--Abeokua', 'Owl liz', 1495664324, 1516046087, 'unseen'),
('1522203621', 'nil', 'nil', 0, 'RVN', 'LSI1581-Bungalow-abeokuta', 'Owl liz', 1495664324, 1516046090, 'unseen'),
('1522342221', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Celine deon organization', 1493599503, 1515701291, 'unseen'),
('1522464820', 'nil', 'nil', 0, 'RVN', 'IIX9313-Office-Space-at-sango-otta', 'Jaguar Enterprise', 1477928707, 1516046089, 'seen'),
('1522591162', 'nil', 'nil', 0, 'RVN', 'ESA9213-Hall-Eleyele--Ibadan', 'Owl City', 1495661773, 1516046088, 'unseen'),
('1522699654', 'nil', 'nil', 0, 'RVN', 'MVI1839-Bungalow-at-ijokodo--Ibadan', 'Jaguar Enterprise', 1477928707, 1516046090, 'seen'),
('1522783973', 'nil', 'nil', 0, 'RVN', 'IBR6355-Warehouse-ikorodu-lagos', 'Jaguar Enterprise', 1477928707, 1516046089, 'seen'),
('1523201454', 'nil', 'nil', 0, 'RVN', 'MNC4315-Boys-Quater-Ijokodo-ibadan', 'Ade Super & Coy.', 1477562968, 1516046090, 'seen'),
('1523309121', 'nil', 'nil', 0, 'RVN', 'KDE7135-Semi-detached-House-Ijokodo-Ibadan', 'Jaguar Enterprise', 1477928707, 1516046090, 'seen'),
('1523424149', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Dough Enterprise', 1477499146, 1514331071, 'unseen'),
('1523425028', 'nil', 'nil', 0, 'RVN', 'SZW8651-Office-Space-Eleyele--Ibadan', 'Owl City', 1495661773, 1516046092, 'unseen'),
('1523500803', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Owl liz', 1495664324, 1516909312, 'unseen'),
('1523640595', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Jaguar Enterpris', 1503761204, 1515783204, 'unseen'),
('1523847173', 'Adedayomatt', 'nil', 1515931873, 'C4A', 'nil', 'Alowonle properties', 1516450078, 1516552282, 'unseen'),
('1523876013', 'nil', 'nil', 0, 'RVN', 'FQW3546-Bungalow-abeokuta', 'Jaguar Enterprise', 1477928707, 1516046088, 'seen'),
('1523894693', 'nil', 'nil', 0, 'RVN', 'OAS5817-Warehouse-Ikeja,-Lagos', 'Owl City', 1495661773, 1516046091, 'unseen'),
('1523959195', 'Dare', 'nil', 1515959170, 'C4A', 'nil', 'Owl liz', 1495664324, 1515968046, 'unseen'),
('1524012214', 'Adedayomatt', 'nil', 1515931873, 'C4A', 'nil', 'Odekunle Nig Ent', 1480298043, 1515961189, 'unseen'),
('1524310250', 'nil', 'nil', 0, 'RVN', 'KDO6326-Hall-', 'Owl City', 1495661773, 1516046090, 'unseen'),
('1524357023', 'Adedayomatt', 'nil', 1515931873, 'C4A', 'nil', 'Celine deon organization', 1493599503, 1515937407, 'unseen'),
('1524461040', 'nil', 'nil', 0, 'RVN', 'VFD8212-Bungalow-Apata--ibadan', 'Owl liz', 1495664324, 1516046093, 'unseen'),
('1524474574', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Owl liz', 1495664324, 1516124172, 'unseen'),
('1524647526', 'nil', 'nil', 0, 'RVN', 'BAJ1421-Flat-at-kingston', 'Ade Super & Coy.', 1477562968, 1516046086, 'seen'),
('1524656901', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Owl State', 1495805257, 1517331523, 'unseen'),
('1524672523', 'nil', 'nil', 0, 'RVN', 'IQC9892-Duplex-ibadan', 'Owl liz', 1495664324, 1516046089, 'unseen'),
('1524674719', 'nil', 'nil', 0, 'RVN', 'GWB7379-Office-Space-ikotun--challenge-molete--ibadan', 'Owl State', 1495805257, 1516046088, 'unseen'),
('1524695473', 'Alowonle properties', 'alowonle', 1516450078, 'A4A', 'nil', 'Ade Super', 1477562968, 1516447244, 'unseen'),
('1524750269', 'Adedayomatt', 'nil', 1515931873, 'C4A', 'nil', 'Jaguar Enterpris', 1503761204, 1515961238, 'unseen'),
('1525036999', 'Bussy', 'nil', 1495645827, 'C4A', 'nil', 'Owl State', 1495805257, 1515503094, 'unseen'),
('1525130925', 'Jaguar Enterprise', 'jaguar', 1477928707, 'A4A', 'nil', 'Ade Super', 1477562968, 1515942266, 'unseen'),
('1525162514', 'nil', 'nil', 0, 'RVN', 'KOM3166-Hall-Eleyele--Ibadan', 'Owl City', 1495661773, 1516046090, 'unseen'),
('1525754126', 'nil', 'nil', 0, 'RVN', 'GFN6298-Bungalow-Apata--ibadan', 'Owl liz', 1495664324, 1516046088, 'unseen'),
('1525805762', 'nil', 'nil', 0, 'RVN', 'HCF1390-Self-Contain-at-OJO', 'Jaguar Enterprise', 1477928707, 1516046088, 'seen'),
('1526027688', 'nil', 'nil', 0, 'RVN', 'PQU3148-Flat-Funaab', 'Owl City', 1495661773, 1516046091, 'unseen'),
('1526643026', 'Adedayomatt', 'nil', 1515931873, 'C4A', 'nil', 'Adedayo Kayode Properties', 1515939351, 1516743002, 'unseen');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(20) NOT NULL,
  `subject` varchar(1500) NOT NULL,
  `content` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `client_agent_follow`
--

CREATE TABLE `client_agent_follow` (
  `client_id` int(20) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `agent_id` int(20) NOT NULL,
  `agent_business_name` varchar(255) NOT NULL,
  `agent_username` char(255) NOT NULL,
  `timestamp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_agent_follow`
--

INSERT INTO `client_agent_follow` (`client_id`, `client_name`, `agent_id`, `agent_business_name`, `agent_username`, `timestamp`) VALUES
(1501859079, 'yemisi', 1477928707, 'Jaguar Enterprise', 'jaguar', 1501874249),
(1501859079, 'yemisi', 1480298043, 'Odekunle Nig Ent', 'Kunlex', 1501918964),
(1501859079, 'yemisi', 1480093605, 'Floccinaucinihilipilification', 'mato', 1502125840),
(1501859079, 'yemisi', 1495805257, 'Owl State', 'owlis', 1502125873),
(1501859079, 'yemisi', 1477499146, 'Dough Enterprise', 'Dough', 1503750195),
(1495645827, 'Bussy', 1480093605, 'Floccinaucinihilipilification', 'mato', 1505781199),
(1504863885, 'Adedayo', 1477928707, 'Jaguar Enterprise', 'jaguar', 1506585353),
(1504863885, 'Adedayo', 1503761204, 'Jaguar Enterpris', 'Dayo', 1506880449),
(1504863885, 'Adedayo', 1493599503, 'Celine deon organization', 'celine', 1507239804),
(1495645827, 'Bussy', 1477499146, 'Dough Enterprise', 'Dough', 1513461246),
(1512246726, 'Matorichy', 1493599503, 'Celine deon organization', 'celine', 1514048135),
(1495645827, 'Bussy', 1495805257, 'Owl State', 'owlis', 1515503094),
(1495645827, 'Bussy', 1493599503, 'Celine deon organization', 'celine', 1515701291),
(1495645827, 'Bussy', 1477928707, 'Jaguar Enterprise', 'jaguar', 1515796425),
(1515931873, 'Adedayomatt', 1493599503, 'Celine deon organization', 'celine', 1515937407),
(1515931873, 'Adedayomatt', 1477928707, 'Jaguar Enterprise', 'jaguar', 1515946661),
(1515931873, 'Adedayomatt', 1480298043, 'Odekunle Nig Ent', 'Kunlex', 1515961189),
(1515931873, 'Adedayomatt', 1503761204, 'Jaguar Enterpris', 'Dayo', 1515961238),
(1495645827, 'Bussy', 1477562968, 'Ade Super ', 'adesuper', 1515961393),
(1515959170, 'Dare', 1495664324, 'Owl liz', 'owliz', 1515968046),
(1515959170, 'Dare', 1495661773, 'Owl City', 'owl', 1515968048),
(1515959170, 'Dare', 1495805257, 'Owl State', 'owlis', 1515968050),
(1515959170, 'Dare', 1503761204, 'Jaguar Enterpris', 'Dayo', 1515968051),
(1515959170, 'Dare', 1503764033, 'Jaguar Enterpri', 'Day', 1515968053),
(1515931873, 'Adedayomatt', 1516450078, 'Alowonle properties', 'alowonle', 1516552282),
(1515931873, 'Adedayomatt', 1515939351, 'Adedayo Kayode Properties', 'adedayokay', 1516743002),
(1495645827, 'Bussy', 1495664324, 'Owl liz', 'owliz', 1516909312);

-- --------------------------------------------------------

--
-- Table structure for table `client_notifications`
--

CREATE TABLE `client_notifications` (
  `notificationid` int(255) NOT NULL,
  `subject` char(255) NOT NULL,
  `subject_username` varchar(255) NOT NULL,
  `subject_id` int(20) NOT NULL,
  `action` char(255) NOT NULL,
  `receiver` char(255) NOT NULL,
  `receiver_id` int(20) NOT NULL,
  `link` varchar(10000) NOT NULL,
  `timestamp` int(20) NOT NULL,
  `status` char(10) DEFAULT 'unseen'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client_notifications`
--

INSERT INTO `client_notifications` (`notificationid`, `subject`, `subject_username`, `subject_id`, `action`, `receiver`, `receiver_id`, `link`, `timestamp`, `status`) VALUES
(1505741926, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Bussy', 1495645827, 'http://192.168.173.1/shelter/properties/?pid=DOZ4397', 1505214530, 'seen'),
(1505875659, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Bussy', 1495645827, 'http://192.168.173.1/shelter/properties/?pid=GLY2270', 1505214532, 'seen'),
(1508596245, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'yemisi', 1501859079, 'DOZ4397-Semi-detached-House-ikotun--challenge-molete--ibadan', 1506024651, 'unseen'),
(1508678294, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Bussy', 1495645827, 'UOX6857-Flat-Ijokodo-Ibadan--Too-state', 1507161937, 'seen'),
(1508835967, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Adedayo', 1504863885, 'UOX6857-Flat-Ijokodo-Ibadan--Too-state', 1507161956, 'seen'),
(1509389075, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'yemisi', 1501859079, 'EKB1423-Flat-Eleyele-ibadan', 1506934760, 'unseen'),
(1509858136, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Bussy', 1495645827, '', 1505958295, 'seen'),
(1509885955, 'Owl City', 'owl', 1495661773, 'PSG', 'Adedayo', 1504863885, 'EEG2696-Boys-Quater-Funaab', 1506884796, 'seen'),
(1510322288, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Adedayo', 1504863885, 'DOZ4397-Semi-detached-House-ikotun--challenge-molete--ibadan', 1506693535, 'seen'),
(1510460554, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Bussy', 1495645827, 'EKB1423-Flat-Eleyele-ibadan', 1507161940, 'seen'),
(1511906830, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Bussy', 1495645827, 'http://192.168.173.1/shelter/properties/?pid=EKB1423', 1505915467, 'seen'),
(1511925793, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Adedayo', 1504863885, 'http://192.168.173.1/shelter/properties/?pid=GLY2270', 1505912457, 'seen'),
(1512558108, 'Owl City', 'owl', 1495661773, 'PSG', 'Adedayo', 1504863885, 'ESA9213-Hall-Eleyele--Ibadan', 1506884799, 'seen'),
(1512571467, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Adedayo', 1504863885, 'GLY2270-Office-Space-Eleyele--ibadan', 1506693538, 'seen'),
(1513003240, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Bussy', 1495645827, '', 1505958288, 'seen'),
(1513755730, 'Ade Super', 'adesuper', 1477562968, 'PSG', 'Bussy', 1495645827, 'CFV8600-Land-Ikeja,-Lagos', 1512748589, 'seen'),
(1514105761, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Matt', 1492382097, 'http://192.168.173.1/shelter/properties/?pid=EKB1423', 1505915484, 'unseen'),
(1514224065, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Bussy', 1495645827, 'HHQ4493-Boys-Quater-Ologuneru--Olopomewa-side', 1505958532, 'seen'),
(1514726386, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Matt', 1492382097, 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 1512036140, 'unseen'),
(1514787070, 'Ade Super', 'adesuper', 1477562968, 'PSG', 'Bussy', 1495645827, 'BAJ1421-Flat-at-kingston', 1512748588, 'seen'),
(1515271948, 'Dough Enterprise', 'Dough', 1477499146, 'PSG', 'Adedayo', 1504863885, 'http://192.168.173.1/shelter/properties/?pid=DOZ4397', 1505912451, 'seen'),
(1515911630, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Adedayo', 1504863885, 'http://192.168.173.1/shelter/properties/?pid=EKB1423', 1505915476, 'seen'),
(1516334332, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Matorichy', 1512246726, 'QYQ7568-Shop-apete-ibadan', 1514046735, 'seen'),
(1516511379, 'Ade Super', 'adesuper', 1477562968, 'PSG', 'Bussy', 1495645827, 'WIB9005-Office-Space-ibadan', 1512748593, 'seen'),
(1516578822, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Matorichy', 1512246726, 'UOX6857-Flat-Ijokodo-Ibadan--Too-state', 1513463954, 'seen'),
(1516676087, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Adedayo', 1504863885, 'EKB1423-Flat-Eleyele-ibadan', 1507161958, 'seen'),
(1517612520, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Adedayo', 1504863885, 'EFW9761-Hall-ijokodo-ibadan--oyo-state-', 1515701479, 'unseen'),
(1518028515, 'Adedayo Kayode Properties', 'adedayokay', 1515939351, 'PSG', 'Adedayo', 1504863885, 'JUQ6884-Semi-detached-House-obokun-bus-stop--eleyele', 1516044140, 'unseen'),
(1518579309, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Matorichy', 1512246726, 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 1514303736, 'seen'),
(1518591908, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'yemisi', 1501859079, 'DDB3991-Office-Space-Abeokuta', 1516446584, 'unseen'),
(1518617073, 'Ade Super', 'adesuper', 1477562968, 'PSG', 'Matorichy', 1512246726, 'ICS9697-Semi-detached-House-Ikeja,-Lagos', 1512281014, 'seen'),
(1518722186, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Matorichy', 1512246726, 'IIX9313-Office-Space-at-sango-otta', 1515700977, 'unseen'),
(1518869637, 'Owl liz', 'owliz', 1495664324, 'PSG', 'Bussy', 1495645827, 'VFD8212-Bungalow-Apata--ibadan', 1515785531, 'seen'),
(1518919121, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Matorichy', 1512246726, 'IBR6355-Warehouse-ikorodu-lagos', 1515700982, 'unseen'),
(1519869094, 'Owl liz', 'owliz', 1495664324, 'PSG', 'Bussy', 1495645827, 'FXM5524-Bungalow-Apata--ibadan', 1515960189, 'seen'),
(1519964420, 'Owl liz', 'owliz', 1495664324, 'PSG', 'Bussy', 1495645827, 'APO5038-Duplex-ibadan', 1515785526, 'seen'),
(1519983867, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'yemisi', 1501859079, 'EFW9761-Hall-ijokodo-ibadan--oyo-state-', 1514264416, 'unseen'),
(1520173717, 'Adedayo Kayode Properties', 'adedayokay', 1515939351, 'PSG', 'Adedayomatt', 1515931873, 'JUQ6884-Semi-detached-House-obokun-bus-stop--eleyele', 1516043987, 'seen'),
(1520194009, 'Owl liz', 'owliz', 1495664324, 'PSG', 'Bussy', 1495645827, 'GFN6298-Bungalow-Apata--ibadan', 1515960184, 'seen'),
(1520224467, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Dare', 1515959170, 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 1516560283, 'seen'),
(1520521401, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Bussy', 1495645827, 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 1516446603, 'seen'),
(1520560872, 'Alowonle properties', 'alowonle', 1516450078, 'PSG', 'Adedayomatt', 1515931873, 'TRS1591-Duplex-agbaje-ibadan', 1516447622, 'seen'),
(1520573240, 'Alowonle properties', 'alowonle', 1516450078, 'PSG', 'Matorichy', 1512246726, 'TRS1591-Duplex-agbaje-ibadan', 1516447630, 'unseen'),
(1521242241, 'Celine deon organization', 'celine', 1493599503, 'PSG', 'Matorichy', 1512246726, 'EKB1423-Flat-Eleyele-ibadan', 1513463952, 'seen'),
(1521414142, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Adedayo', 1504863885, 'MVI1839-Bungalow-at-ijokodo--Ibadan', 1514298054, 'unseen'),
(1522390120, 'Ade Super', 'adesuper', 1477562968, 'PSG', 'Matorichy', 1512246726, 'BAJ1421-Flat-at-kingston', 1514035048, 'seen'),
(1522568433, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Bussy', 1495645827, 'DDB3991-Office-Space-Abeokuta', 1516446607, 'seen'),
(1522693647, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Dare', 1515959170, 'GYP6633-Land-ijokodo-ibadan--oyo-state-', 1516560286, 'seen'),
(1522757856, 'Alowonle properties', 'alowonle', 1516450078, 'PSG', 'Adedayo', 1504863885, 'TRS1591-Duplex-agbaje-ibadan', 1516447615, 'unseen'),
(1522784557, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Dare', 1515959170, 'DDB3991-Office-Space-Abeokuta', 1516560284, 'seen'),
(1523831883, 'Owl liz', 'owliz', 1495664324, 'PSG', 'Bussy', 1495645827, 'EGS7748-Boys-Quater-alabata--Abeokua', 1515785527, 'seen'),
(1523919643, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Adedayomatt', 1515931873, 'OBB8715-Office-Space-nnmm', 1515970791, 'seen'),
(1523972762, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Adedayomatt', 1515931873, 'MVI1839-Bungalow-at-ijokodo--Ibadan', 1515945632, 'seen'),
(1523979782, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Adedayo', 1504863885, 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 1514294815, 'unseen'),
(1524174170, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Bussy', 1495645827, 'GYP6633-Land-ijokodo-ibadan--oyo-state-', 1516560126, 'seen'),
(1524422249, 'Adedayo Kayode Properties', 'adedayokay', 1515939351, 'PSG', 'Bussy', 1495645827, 'JUQ6884-Semi-detached-House-obokun-bus-stop--eleyele', 1516485207, 'seen'),
(1524456130, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Dare', 1515959170, 'IIQ8059-Office-Space-Abeokuta', 1516560287, 'seen'),
(1524694496, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Matorichy', 1512246726, 'DDB3991-Office-Space-Abeokuta', 1516560250, 'unseen'),
(1525115976, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Bussy', 1495645827, 'IIQ8059-Office-Space-Abeokuta', 1516560129, 'seen'),
(1525117236, 'Ade Super', 'adesuper', 1477562968, 'PSG', 'Adedayo', 1504863885, 'FUX7316-Self-Contain-Asero-housing-estate--abeokuta', 1516047778, 'unseen'),
(1525237533, 'Owl liz', 'owliz', 1495664324, 'PSG', 'Bussy', 1495645827, 'LSI1581-Bungalow-abeokuta', 1515960159, 'seen'),
(1525630496, 'Alowonle properties', 'alowonle', 1516450078, 'PSG', 'Bussy', 1495645827, 'TRS1591-Duplex-agbaje-ibadan', 1516447605, 'seen'),
(1526047015, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Adedayomatt', 1515931873, 'KNQ3311-Duplex-uioioij', 1516716907, 'seen'),
(1526101667, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Adedayomatt', 1515931873, 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 1516716902, 'seen'),
(1526698783, 'Jaguar Enterprise', 'jaguar', 1477928707, 'PSG', 'Adedayomatt', 1515931873, 'KDE7135-Semi-detached-House-Ijokodo-Ibadan', 1516716911, 'seen');

-- --------------------------------------------------------

--
-- Table structure for table `clipped`
--

CREATE TABLE `clipped` (
  `clip_id` int(30) NOT NULL,
  `propertyid` char(10) NOT NULL,
  `clippedby` int(20) NOT NULL,
  `timestamp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clipped`
--

INSERT INTO `clipped` (`clip_id`, `propertyid`, `clippedby`, `timestamp`) VALUES
(1497896071, 'EFW9761', 1495645827, 1515701409),
(1498729109, 'KDE7135', 1495645827, 1515786859),
(1498734877, 'WIB9005', 1495645827, 1506115425),
(1499827742, 'EFB3597', 1495645827, 1515961470),
(1500052138, 'CFV8600', 1495645827, 1505164775),
(1500343275, 'MNC4315', 1495645827, 1504686904),
(1501300184, 'JYP3888', 1495645827, 1504690120),
(1502054396, 'FQW3546', 1495645827, 1505960817),
(1502472426, 'HHQ4493', 1495645827, 1515700911),
(1506854577, 'ICS9697', 1504863885, 1504873059),
(1507953209, 'MVI1839', 1504863885, 1506579853),
(1509950204, 'ETB7122', 1501859079, 1503416393),
(1510817849, 'OAS3949', 1501859079, 1501918051),
(1511455102, 'EFW9761', 1504863885, 1506584319),
(1511781900, 'IYQ7624', 1501859079, 1504014280),
(1513741906, 'ATY5844', 1504863885, 1506584721),
(1514248129, 'EFW9761', 1512246726, 1512254719),
(1514620263, 'AHA3569', 1504863885, 1506931377),
(1515584067, 'ICS9697', 1512246726, 1512281114),
(1517661090, 'ETB7122', 1515931873, 1516412842),
(1518030780, 'TRS1591', 1515931873, 1516552257),
(1518666556, 'QYQ7568', 1512246726, 1514046968),
(1519103046, 'SAP8871', 1515931873, 1516045788),
(1520036609, 'MVI1839', 1515931873, 1515960808),
(1520826526, 'OBB8715', 1515931873, 1516744686),
(1523045764, 'FUX7316', 1515931873, 1516727948),
(1524883608, 'ICS9697', 1515959170, 1516561100);

-- --------------------------------------------------------

--
-- Table structure for table `cta`
--

CREATE TABLE `cta` (
  `ctaid` int(20) NOT NULL,
  `name` char(30) NOT NULL,
  `phone` bigint(11) NOT NULL,
  `email` char(30) DEFAULT NULL,
  `request` tinyint(1) NOT NULL,
  `password` char(30) NOT NULL,
  `datecreated` char(12) NOT NULL,
  `createdTimestamp` int(20) NOT NULL,
  `expiryTimestamp` int(20) NOT NULL,
  `token` char(255) NOT NULL DEFAULT 'nil',
  `last_seen` int(20) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cta`
--

INSERT INTO `cta` (`ctaid`, `name`, `phone`, `email`, `request`, `password`, `datecreated`, `createdTimestamp`, `expiryTimestamp`, `token`, `last_seen`) VALUES
(1492382097, 'Matt', 8139004572, 'adedayomatt@gmail.com', 1, 'xxx', '2017-04-16', 0, 1502728840, '0f9fe690f38da67968280971584cf9c16541f07b', 0),
(1495645827, 'Bussy', 9045465656, 'bussy@gmail.com', 1, 'xxx', '2017-05-24', 1501868773, 1551868773, 'c28e3e9978b4837b07e9dc29537a40d276b9e846', 1518533637),
(1501859079, 'yemisi', 7056915111, 'uniq@g.com', 1, 'yyy', '2017-08-Frid', 1501868584, 1504460584, 'f01c7a3a76f6b371db43660181cd6d6a614542b6', 0),
(1504863885, 'Adedayo', 8139004572, 'adedayomatt@gmail.com', 1, 'aaa', '2017-09-Frid', 1504871151, 1507463151, 'c70d86c29209d63a9de0a30ef8be2eacd5fe991c', 0),
(1512246726, 'Matorichy', 8139004572, 'adedqyomatt@gmail.com', 1, 'mato', '2017-12-Satu', 1512254051, 1514846051, '92e03c1547f6ffc3b3e2adc7225c7ddd16b2e881', 0),
(1515931873, 'Adedayomatt', 8139004572, 'adedayo@gmail.com', 1, 'ade', '2018-01-Sund', 1515934730, 1518526730, '19a856a4ec8d6559e58a16b5d67c029bd20ac741', 1518354063),
(1515959170, 'Dare', 8139004572, 'adedayo@gmail.cok', 1, 'dare', '2018-01-Sund', 1515966562, 1518558562, '4e1024d7aafb52d51565c60d5dc6838e674e93aa', 1516569168);

-- --------------------------------------------------------

--
-- Table structure for table `cta_request`
--

CREATE TABLE `cta_request` (
  `ctaid` int(20) NOT NULL,
  `ctaname` varchar(255) NOT NULL,
  `type` char(30) NOT NULL,
  `maxprice` int(10) NOT NULL,
  `area` char(255) NOT NULL,
  `city` char(255) NOT NULL,
  `timestamp` int(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cta_request`
--

INSERT INTO `cta_request` (`ctaid`, `ctaname`, `type`, `maxprice`, `area`, `city`, `timestamp`) VALUES
(1495645827, 'Bussy', 'Flat', 5000000, 'Ikeja', 'Lagos', 1506034152),
(1504863885, 'Adedayo', 'Flat', 500000, '', '', 1505910570),
(1512246726, 'Matorichy', 'Semi detached House', 200000, '', '', 1512254865),
(1515931873, 'Adedayomatt', 'Flat', 200000, 'Eleyele', 'Ibadan', 1515934882),
(1515959170, 'Dare', 'Semi detached House', 700000, '', '', 1516561059);

-- --------------------------------------------------------

--
-- Table structure for table `messagelinker`
--

CREATE TABLE `messagelinker` (
  `conversationid` bigint(30) NOT NULL,
  `subject` char(255) NOT NULL,
  `initiator` char(255) NOT NULL,
  `participant` char(255) NOT NULL,
  `totalmsg` int(50) NOT NULL,
  `lastmsg` longtext NOT NULL,
  `sender` char(255) NOT NULL,
  `lastmsgtime` int(20) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'unseen'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `conversationid` bigint(30) NOT NULL,
  `messageid` bigint(30) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `sender` char(255) NOT NULL,
  `receiver` char(255) NOT NULL,
  `body` longtext NOT NULL,
  `status` char(10) NOT NULL,
  `timestamp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `ID` int(20) NOT NULL,
  `Business_Name` char(255) NOT NULL,
  `Office_Address` varchar(150) NOT NULL,
  `Office_Tel_No` bigint(11) NOT NULL,
  `Business_email` char(30) NOT NULL,
  `CEO_Name` varchar(30) NOT NULL,
  `Phone_No` bigint(11) NOT NULL,
  `Alt_Phone_No` bigint(11) NOT NULL,
  `email` char(30) NOT NULL,
  `User_ID` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `timestamp` int(20) NOT NULL,
  `token` char(255) NOT NULL DEFAULT 'nil',
  `last_seen` int(20) DEFAULT '0',
  `last_upload` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`ID`, `Business_Name`, `Office_Address`, `Office_Tel_No`, `Business_email`, `CEO_Name`, `Phone_No`, `Alt_Phone_No`, `email`, `User_ID`, `password`, `timestamp`, `token`, `last_seen`, `last_upload`) VALUES
(1477499146, 'Dough Enterprise', 'Lagos lagoon, Nigeria, West Africa', 8035476354, 'mno@gmail.com', 'Xender Alexis', 8156565734, 7056655767, 'alexis@gmail.com', 'Dough', 'dil', 0, '3c156d5474cd4b857fd9ab7f01fb7d1eb3e91bf6', 0, 0),
(1477562968, 'Ade Super & Coy.', 'Eleyele Ibadan', 9077667566, 'adesuper999@yahoo.com', 'Emmanuel Adesuper kayode', 7078675755, 8156675469, 'edayo@hotmail.com', 'adesuper', 'sup', 0, 'ec049d09b3bd83ba3c52c30186c2a40ad6f6d815', 1518531526, 0),
(1477596792, 'Gods Will', 'km 9, Arulogun Area', 8098797986, 'goe@gmail.com', 'Godwin Akpokodje', 8978978687, 8156675465, 'goe@gmail.com', 'Godwill', 'god', 0, 'cff4ee73559c6cd396744994a9daa5ebc09b31cf', 0, 0),
(1477928707, 'Jaguar Enterprise', 'Ibadan, nigeria, West Africa', 8035476358, 'jaguarenterprise@yahoo.com', 'Olivia Ericaa', 8156565739, 8198798758, 'oliviaeric@gmail.com', 'jaguar', 'aaa', 0, 'f001f96576472a769c087f98121b0345a559a11e', 1518536870, 0),
(1480093605, 'Floccinaucinihilipilification', 'Itokun Abeokuta, Nigeria Anglo', 9048877574, 'flha@gmail.com', 'Mato ota', 8139004778, 81390049954, 'matoo@gmail.com', 'mato', 'mat', 0, '3d5c73dbafe57ce4c91415274cd60e3f31b3ebc4', 1516417302, 0),
(1480298043, 'Odekunle Nig Ent', 'suite 9, Ondo Street', 7085476587, 'dekunle@yahoo.com', 'Odekunle Afolabi', 8156565734, 8139004572, 'afoo@gmail.com', 'Kunlex', 'kun', 0, 'e7d7443e45c220a76bd3e0612e98c7b6e8b5db73', 0, 0),
(1493599503, 'Celine deon organization', 'pent house, Pennsylvania, USA', 8139003581, 'celinedeon@gmail', 'Celine Deon', 8162367899, 9064567855, 'celine@yahoo.com', 'celine', 'deon', 0, 'c0ab5820b7bcf572eaecdb9c2d5b33d9b877c0bf', 0, 0),
(1495661773, 'Owl City', 'No 9, Gotham complex, ikeja, Lagos, Nigeria', 8154676783, 'owlcity@yahoo.com', 'Pieper Pepper', 8087468468, 7037537653, 'ppepper@gmailcom', 'owl', 'city', 1495656610, '2c730e3a6d2aad6d914872e45f868d20a543570a', 0, 0),
(1495664324, 'Owl liz', 'No 9, Gotham complex, ikeja, Lagos, Nigeria', 8154676783, 'owlcity@yahoo.com', 'Pieper Pepper', 8087468468, 7037537653, 'ppepper@gmailcom', 'owliz', 'liz', 1495658036, 'f32aa7b6ba1b0fd17ee3f7d248a51f3d1324a5ac', 1515960576, 0),
(1495805257, 'Owl State', 'No 9, Gotham complex, ikeja, Lagos, Nigeria', 8154676783, 'owlcity@yahoo.com', 'Pieper Pepper', 8087468468, 7037537653, 'ppepper@gmailcom', 'owlis', 'ioio', 1495796849, 'e837db2606bd8c6f2915ea108e0441e0cad31b4e', 0, 0),
(1503761204, 'Jaguar Enterpris', 'Sanford Ibadan', 8139001377, 'jaguar@hotmail.com', 'Adedayo Kayode', 90767998, 797588, 'adeda@hg.com', 'Dayo', 'kay', 1503757971, 'c7f9d1409bef489f74c4226e787213ddd17a42b2', 0, 0),
(1503764033, 'Jaguar Enterpri', 'Sanford Ibadan', 8139001377, 'jaguar@hotmail.com', 'Adedayo Kayode', 90767998, 797588, 'adeda@hg.com', 'Day', 'bbb', 1503758174, '987b9ced08d4ac5d11d286ca4b54b99a4f69164b', 0, 0),
(1515939351, 'Adedayo Kayode Properties', 'Eleyele  Ibadan', 8865796789, 'adedayoproperties@gmail.com', 'Adedayo Kayode', 8146754763, 9979689687, 'adeadyokayode@gmail.com', 'adedayokay', 'kay', 1515934232, 'f648261ced41a07330a2189a8266b8efcce1f8be', 1516576185, 0),
(1516450078, 'Alowonle properties', 'Apete Ibadan', 9086548764, 'alowomle@gmail.com', 'Alowonle Omidiji', 9056868664, 8135765473, 'adeadyokayode@gmail.com', 'alowonle', 'owo', 1516447125, 'fe34b18f0f8f4690ad361067bd4004d47fa20dde', 1516448679, 0);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_ID` char(20) NOT NULL,
  `directory` varchar(200) NOT NULL,
  `type` char(20) NOT NULL,
  `area` char(255) NOT NULL,
  `city` char(255) NOT NULL,
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
  `timestamp` int(20) NOT NULL,
  `views` int(10) DEFAULT '0',
  `last_reviewed` int(20) DEFAULT '0',
  `status` char(20) DEFAULT 'Available',
  `display_photo` varchar(20) DEFAULT 'nil'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_ID`, `directory`, `type`, `area`, `city`, `rent`, `min_payment`, `bath`, `toilet`, `pumping_machine`, `borehole`, `well`, `tiles`, `parking_space`, `electricity`, `road`, `socialization`, `security`, `description`, `uploadby`, `date_uploaded`, `timestamp`, `views`, `last_reviewed`, `status`, `display_photo`) VALUES
('AHA3569', 'AHA3569-Self-Contain-Sango-Ottawa-Ogundele-State', 'Self Contain', 'Eleyele', 'Ibadan', 120000, '1 year', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'Dayo', '2017-10-01 19:13:25', 1506881605, 13, 1506881605, 'Available', 'nil'),
('APO5038', 'APO5038-Duplex-ibadan', 'Duplex', 'Eleyele', 'Ibadan', 70000, '1 year, 6 months', 1, 1, 'No', 'Yes', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owliz', '2017-05-24 21:57:17', 1495659437, 28, 1501515920, 'Available', 'APO5038_02.jpeg'),
('ATY5844', 'ATY5844-Semi-detached-House-Adegbile-isale-eko-idumota-paraoke-mosadoluwa-enikuomehin', 'Semi detached House', 'Eleyele', 'Ibadan', 25000, '1 Year, 6 Months', 3, 4, 'Yes', 'Yes', 'No', 'Yes', 'Yes', 40, 70, 70, 90, '', 'jaguar', '2017-07-31 17:51:41', 1501519901, 50, 1516440593, 'Leased out', 'ATY5844_02.jpeg'),
('BAJ1421', 'BAJ1421-Flat-at-kingston', 'Flat', 'Eleyele', 'Ibadan', 150000, '1 year', 1, 1, 'Yes', 'No', 'No', 'Yes', 'No', 0, 0, 0, 100, '', 'adesuper', '2017-02-08 09:36:23', 0, 2, 1501500496, 'Available', ''),
('CFV8600', 'CFV8600-Land-Ikeja,-Lagos', 'Land', 'Eleyele', 'Ibadan', 700000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-07-20 05:16:00', 1500524159, 16, 1501517337, 'Available', ''),
('DDB3991', 'DDB3991-Office-Space-Abeokuta', 'Office Space', 'Eleyele', 'Ibadan', 200000, '1 year, 6 months', 2, 2, 'Yes', 'Yes', 'No', 'Yes', 'No', 50, 50, 80, 60, 'it is located in a serene environment', 'jaguar', '0000-00-00 00:00:00', 1516435478, 9, 1516435478, 'Available', 'nil'),
('DOZ4397', 'DOZ4397-Semi-detached-House-ikotun--challenge-molete--ibadan', 'Semi detached House', 'Eleyele', 'Ibadan', 600000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'dough', '2017-06-30 18:55:26', 1498845326, 33, 1506025214, 'Leased out', ''),
('EEG2696', 'EEG2696-Boys-Quater-Funaab', 'Boys Quater', 'Eleyele', 'Ibadan', 50000, '2 years', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-07-19 23:40:47', 1500504047, 3, 1506798616, 'Available', ''),
('EFB3597', 'EFB3597-Self-Contain-Ikeja,-Lagos', 'Self Contain', 'Eleyele', 'Ibadan', 9000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-07-19 23:47:38', 1500504458, 16, 1506972798, 'Available', 'EFB3597_01.jpeg'),
('EFW9761', 'EFW9761-Hall-ijokodo-ibadan--oyo-state-', 'Hall', 'Eleyele', 'Ibadan', 300000, '1 Year, 6 Months', 5, 5, 'No', 'Yes', 'No', 'Yes', 'No', 100, 90, 80, 100, 'Just OK', 'jaguar', '2017-06-08 19:07:38', 1496945258, 125, 1516911899, 'Available', 'EFW9761_02.jpeg'),
('EGS7748', 'EGS7748-Boys-Quater-alabata--Abeokua', 'Boys Quater', 'Eleyele', 'Ibadan', 150000, '1 Year', 3, 3, 'Yes', 'No', 'Yes', 'Yes', 'No', 70, 60, 90, 90, '', 'owliz', '2017-05-26 06:54:00', 1495778040, 48, 1501531010, 'Available', 'EGS7748_01.png'),
('EHS5005', 'EHS5005-Bungalow-Agbaje-ijokodo-ibadan', 'Bungalow', 'Eleyele', 'Ibadan', 250000, '2 Years', 3, 3, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 20, 30, 70, 90, '', 'Dayo', '2017-10-01 18:59:26', 1506880766, 21, 1506881222, 'Available', 'nil'),
('EKB1423', 'EKB1423-Flat-Eleyele-ibadan', 'Flat', 'Eleyele', 'Ibadan', 200000, '1 year', 1, 1, 'Yes', 'No', 'Yes', 'No', 'Yes', 50, 30, 80, 80, 'It is simply amazing place with no disturbance around. It\'s sometimes refer to \"the UK in Ibadan\"', 'celine', '2017-09-06 16:20:58', 1504711258, 67, 1507300659, 'Available', 'EKB1423_01.jpeg'),
('ESA9213', 'ESA9213-Hall-Eleyele--Ibadan', 'Hall', 'Eleyele', 'Ibadan', 200000, '1 year', 1, 1, 'No', 'Yes', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-06-17 11:47:34', 1497696454, 6, 1506798644, 'Available', ''),
('ETB7122', 'ETB7122-Semi-detached-House-Eleyele--ibadan', 'Semi detached House', 'Eleyele', 'Ibadan', 30000, '1 year', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'owlis', '2017-08-04 07:06:53', 1501826813, 102, 1501826911, 'Leased out', 'ETB7122_02.png'),
('FQW3546', 'FQW3546-Bungalow-abeokuta', 'Bungalow', 'Eleyele', 'Ibadan', 200000, '1 year', 1, 1, 'No', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2017-04-22 09:21:27', 1492849287, 14, 1505948697, 'Available', ''),
('FUX7316', 'FUX7316-Self-Contain-Asero-housing-estate--abeokuta', 'Self Contain', 'Eleyele', 'Ibadan', 150000, '1 year, 6 months', 1, 1, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 70, 80, 90, 100, '', 'adesuper', '0000-00-00 00:00:00', 1516046949, 14, 1516046949, 'Available', 'nil'),
('FXM5524', 'FXM5524-Bungalow-Apata--ibadan', 'Bungalow', 'Eleyele', 'Ibadan', 160000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'Yes', 'Yes', 'No', 60, 80, 80, 90, '', 'owliz', '2017-05-26 06:34:30', 1495776870, 25, 1501530827, 'Available', 'FXM5524_02.png'),
('GFN6298', 'GFN6298-Bungalow-Apata--ibadan', 'Bungalow', 'Eleyele', 'Ibadan', 160000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'Yes', 'Yes', 'No', 60, 80, 80, 90, '', 'owliz', '2017-05-26 06:31:52', 1495776712, 8, 0, '', ''),
('GKS8828', 'GKS8828-Duplex-Idi-aba--ibadan', 'Duplex', 'Eleyele', 'Ibadan', 400000, '2 years', 1, 1, 'Yes', 'No', 'Yes', 'No', 'Yes', 90, 70, 30, 60, '', 'jaguar', '0000-00-00 00:00:00', 1516027324, 9, 1516439127, 'Available', 'GKS8828_02.jpeg'),
('GLY2270', 'GLY2270-Office-Space-Eleyele--ibadan', 'Office Space', 'Eleyele', 'Ibadan', 80000, '2 Years', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'Dough', '2017-08-02 09:15:29', 1501661729, 24, 1507020732, 'Available', 'nil'),
('GWB7379', 'GWB7379-Office-Space-ikotun--challenge-molete--ibadan', 'Office Space', 'Eleyele', 'Ibadan', 250000, '2 years', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'owlis', '2017-08-03 23:43:31', 1501800211, 6, 1501800433, 'Available', 'nil'),
('GYP6633', 'GYP6633-Land-ijokodo-ibadan--oyo-state-', 'Land', 'Eleyele', 'Ibadan', 300000, '1 year', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2017-06-17 22:43:30', 1497735810, 46, 1516433625, 'Leased out', 'GYP6633_01.png'),
('HCF1390', 'HCF1390-Self-Contain-at-OJO', 'Self Contain', 'Eleyele', 'Ibadan', 1200000, '1 year, 6 Months', 1, 1, 'Yes', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2016-12-05 08:24:42', 0, 2, 1513461018, 'Available', ''),
('HHQ4493', 'HHQ4493-Boys-Quater-Ologuneru--Olopomewa-side', 'Boys Quater', 'Eleyele', 'Ibadan', 300000, '1 year', 2, 2, 'Yes', 'Yes', 'No', 'Yes', 'No', 30, 90, 0, 0, '', 'Dough', '2017-08-01 08:32:28', 1501572748, 29, 1501661501, 'Available', 'HHQ4493_01.png'),
('IBR6355', 'IBR6355-Warehouse-ikorodu-lagos', 'Warehouse', 'Eleyele', 'Ibadan', 200000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 70, 20, 80, 10, '', 'jaguar', '2017-07-21 21:15:20', 1500668120, 50, 1516815063, 'Available', 'IBR6355_05.png'),
('ICS9697', 'ICS9697-Semi-detached-House-Ikeja,-Lagos', 'Semi detached House', 'Eleyele', 'Ibadan', 700000, '1 year', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-07-20 05:30:54', 1500525054, 18, 1501519028, 'Available', ''),
('IIQ8059', 'IIQ8059-Office-Space-Abeokuta', 'Office Space', 'Eleyele', 'Ibadan', 200000, '1 year, 6 months', 2, 2, 'Yes', 'Yes', 'No', 'Yes', 'No', 50, 50, 80, 60, 'it is located in a serene environment', 'jaguar', '0000-00-00 00:00:00', 1516435565, 7, 1516436403, 'Available', 'nil'),
('IIX9313', 'IIX9313-Office-Space-at-sango-otta', 'Office Space', 'Eleyele', 'Ibadan', 120000, '1 year', 1, 1, 'No', 'No', 'No', 'Yes', 'No', 60, 20, 15, 70, 'great', 'jaguar', '2016-12-03 23:17:24', 0, 2, 0, '', ''),
('IKL3132', 'IKL3132-Self-Contain-Address', 'Self Contain', 'Eleyele', 'Ibadan', 50000, '1 year', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-07-19 22:45:24', 1500500724, 1, 1506798658, 'Leased out', ''),
('IQC9892', 'IQC9892-Duplex-ibadan', 'Duplex', 'Eleyele', 'Ibadan', 70000, '1 year, 6 months', 1, 1, 'No', 'Yes', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owliz', '2017-05-24 22:14:43', 1495660483, 7, 0, '', ''),
('IYQ7624', 'IYQ7624-Duplex-Apata-ibadan', 'Duplex', 'Eleyele', 'Ibadan', 160000, '1 year', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'Kunlex', '2017-08-05 08:38:06', 1501918686, 345, 1501919221, 'Available', 'nil'),
('JUQ6884', 'JUQ6884-Semi-detached-House-obokun-bus-stop--eleyele', 'Semi detached House', 'Eleyele', 'Ibadan', 500000, '1 year', 3, 3, 'Yes', 'Yes', 'No', 'No', 'No', 80, 90, 15, 90, 'This property is very nice and conducive environment.', 'adedayokay', '0000-00-00 00:00:00', 1516042103, 22, 1516484958, 'Leased out', 'JUQ6884_02.jpeg'),
('JYP3888', 'JYP3888-Office-Space-Abeokuta', 'Office Space', 'Eleyele', 'Ibadan', 50000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2017-07-28 22:34:17', 1501277657, 116, 1516442544, 'Available', 'JYP3888_01.png'),
('KBA1638', 'KBA1638-Flat-ijokodo--Ibadan', 'Flat', 'Eleyele', 'Ibadan', 100000, '2 years', 1, 1, 'No', 'Yes', 'No', 'No', 'Yes', 0, 0, 0, 0, '', 'owliz', '2017-05-26 06:41:06', 1495777266, 35, 1501514595, 'Available', 'KBA1638_03.jpeg'),
('KDE7135', 'KDE7135-Semi-detached-House-Ijokodo-Ibadan', 'Semi detached House', 'Eleyele', 'Ibadan', 500000, '1 year, 6 months', 3, 3, 'Yes', 'Yes', 'No', 'Yes', 'Yes', 10, 50, 40, 70, '', 'jaguar', '2017-12-02 23:04:40', 1512252280, 19, 1516445708, 'Available', 'nil'),
('KDO6326', 'KDO6326-Hall-', 'Hall', 'Eleyele', 'Ibadan', 9000, '', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-07-19 22:45:56', 1500500756, 4, 1506798674, 'Available', ''),
('KGL6609', 'KGL6609-Office-Space-ibadan', 'Office Space', 'Eleyele', 'Ibadan', 40000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-09-04 18:46:06', 1504547166, 20, 1505164317, 'Available', 'nil'),
('KNQ3311', 'KNQ3311-Duplex-uioioij', 'Duplex', 'Eleyele', 'Ibadan', 6546465, '1 year', 1, 1, 'Yes', 'Yes', 'No', 'No', 'No', 70, 90, 50, 15, 'Not bad at all!', 'jaguar', '2017-04-22 18:54:17', 1492883657, 31, 1516433231, 'Available', 'KNQ3311_02.png'),
('KOM3166', 'KOM3166-Hall-Eleyele--Ibadan', 'Hall', 'Eleyele', 'Ibadan', 200000, '1 year', 1, 1, 'No', 'Yes', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-06-17 11:51:48', 1497696708, 1, 1506798594, 'Available', ''),
('KXD1355', 'KXD1355-Office-Space-Eleyele--Ibadan', 'Office Space', 'Eleyele', 'Ibadan', 40000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'Yes', 'Yes', 50, 70, 30, 80, '', 'owl', '2017-06-17 11:47:01', 1497696421, 3, 1506798687, 'Leased out', ''),
('LFR9784', 'LFR9784-Warehouse-Aba', 'Warehouse', 'Eleyele', 'Ibadan', 60000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-07-20 04:30:12', 1500521412, 3, 0, '', ''),
('LSI1581', 'LSI1581-Bungalow-abeokuta', 'Bungalow', 'Eleyele', 'Ibadan', 80000, '2 years', 1, 1, 'No', 'No', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owliz', '2017-05-24 22:28:14', 1495661294, 114, 1501519585, 'Leased out', 'LSI1581_01.jpeg'),
('MNC4315', 'MNC4315-Boys-Quater-Ijokodo-ibadan', 'Boys Quater', 'Eleyele', 'Ibadan', 25000, '1 year, 6 months', 2, 3, 'Yes', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-09-04 19:19:42', 1504549182, 7, 1506973635, 'Leased out', 'nil'),
('MVI1839', 'MVI1839-Bungalow-at-ijokodo--Ibadan', 'Bungalow', 'Eleyele', 'Ibadan', 200000, '1 Year', 5, 2, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 60, 50, 80, 30, '', 'jaguar', '2016-12-05 11:01:35', 0, 2, 1517331663, 'Available', ''),
('NGT7156', 'NGT7156-Duplex-No-34a--Babatunde-Oyerinde-Street--Ijokodo-Ibadan', 'Duplex', 'Eleyele', 'Ibadan', 250000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'No', 'Yes', 'No', 50, 80, 60, 90, '', 'adesuper', '2017-07-30 09:21:38', 1501402898, 24, 1506796766, 'Available', ''),
('OAS3949', 'OAS3949-Semi-detached-House-at-ijokodo,-Ibadan', 'Semi detached House', 'Eleyele', 'Ibadan', 200000, '1 Year, 6 Months', 1, 1, 'Yes', 'No', 'Yes', 'Yes', 'No', 40, 80, 70, 50, '', 'adesuper', '2016-12-03 10:35:06', 0, 2, 1506973620, 'Available', ''),
('OAS5817', 'OAS5817-Warehouse-Ikeja,-Lagos', 'Warehouse', 'Eleyele', 'Ibadan', 200000, '1 year', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-07-19 23:39:26', 1500503966, 0, 1506798744, 'Available', ''),
('OBB8715', 'OBB8715-Office-Space-nnmm', 'Office Space', 'Eleyele', 'Ibadan', 123456, '2 years', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2017-04-22 18:52:38', 1492883558, 39, 1516716979, 'Leased out', ''),
('PQU3148', 'PQU3148-Flat-Funaab', 'Flat', 'Eleyele', 'Ibadan', 200000, '1 year, 6 months', 3, 2, 'Yes', 'Yes', 'Yes', 'Yes', 'No', 0, 0, 0, 0, '', 'owl', '2017-07-19 22:15:27', 1500498926, 6, 1506798700, 'Available', ''),
('QJX6342', 'QJX6342-Boys-Quater-', 'Boys Quater', 'Eleyele', 'Ibadan', 700000, '', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-07-19 22:43:07', 1500500587, 0, 1506798760, 'Available', ''),
('QYQ7568', 'QYQ7568-Shop-apete-ibadan', 'Shop', 'Eleyele', 'Ibadan', 50000, '2 years', 1, 1, 'No', 'No', 'No', 'Yes', 'No', 40, 100, 40, 60, '', 'celine', '2017-12-23 17:31:12', 1514046672, 30, 1514046672, 'Available', 'nil'),
('RHU3365', 'RHU3365-Flat-Ikeja-Lagos', 'Flat', 'Ikeja', 'Lagos', 150000, '1 year, 6 months', 3, 3, 'Yes', 'Yes', 'No', 'Yes', 'No', 50, 50, 15, 70, '', 'jaguar', '0000-00-00 00:00:00', 1516840264, 22, 1516840264, 'Available', 'nil'),
('SAP8871', 'SAP8871-Duplex-ikorodu-lagos', 'Duplex', 'Eleyele', 'Ibadan', 65000, '1 Year, 6 Months', 1, 1, 'Yes', 'Yes', 'Yes', 'No', 'No', 20, 40, 90, 90, 'Not bad at all', 'jaguar', '2017-09-06 08:48:24', 1504684104, 15, 1516814800, 'Available', 'nil'),
('SZW8651', 'SZW8651-Office-Space-Eleyele--Ibadan', 'Office Space', 'Eleyele', 'Ibadan', 40000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'Yes', 'Yes', 50, 70, 30, 80, '', 'owl', '2017-06-17 11:41:51', 1497696111, 3, 1506538289, 'Available', ''),
('TOI4350', 'TOI4350-Bungalow-', 'Bungalow', 'Eleyele', 'Ibadan', 5000, '', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-07-19 22:39:00', 1500500340, 0, 1506798629, 'Available', ''),
('TRS1591', 'TRS1591-Duplex-agbaje-ibadan', 'Duplex', 'Eleyele', 'Ibadan', 2000000, '2 years', 4, 3, 'Yes', 'Yes', 'No', 'Yes', 'No', 0, 0, 0, 0, '', 'alowonle', '0000-00-00 00:00:00', 1516447447, 10, 1516447589, 'Available', 'TRS1591_01.jpeg'),
('UOX6857', 'UOX6857-Flat-Ijokodo-Ibadan--Too-state', 'Flat', 'Eleyele', 'Ibadan', 150000, '1 year, 6 months', 2, 2, 'Yes', 'Yes', 'No', 'Yes', 'No', 0, 0, 0, 0, '', 'celine', '2017-10-05 00:38:54', 1507160334, 87, 1507299832, 'Available', 'UOX6857_02.jpeg'),
('VES6501', 'VES6501-Bungalow-at-getdg', 'Bungalow', 'Eleyele', 'Ibadan', 3456789, '1 year', 3, 1, 'No', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2016-12-03 10:32:25', 0, 2, 1506299709, 'Available', ''),
('VFD8212', 'VFD8212-Bungalow-Apata--ibadan', 'Bungalow', 'Eleyele', 'Ibadan', 160000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'Yes', 'Yes', 'No', 60, 80, 80, 90, '', 'owliz', '2017-05-26 06:28:36', 1495776516, 6, 1501517299, 'Available', 'VFD8212_03.png'),
('VGY2633', 'VGY2633-Office-Space-Ikeja,-Lagos', 'Office Space', 'Eleyele', 'Ibadan', 200000, '2 years', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-07-19 23:55:43', 1500504943, 8, 1506700420, 'Leased out', 'VGY2633_01.png'),
('VRY1851', 'VRY1851-Hall-Eleyele--Ibadan', 'Hall', 'Eleyele', 'Ibadan', 200000, '1 year', 1, 1, 'No', 'Yes', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owl', '2017-06-17 11:48:11', 1497696491, 2, 1506798714, 'Leased out', ''),
('WIB9005', 'WIB9005-Office-Space-ibadan', 'Office Space', 'Eleyele', 'Ibadan', 40000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-09-04 18:38:37', 1504546717, 0, 1505825343, 'Available', 'nil'),
('WNW9430', 'WNW9430-Flat-Eleyele--Ibadan', 'Flat', 'Eleyele', 'Ibadan', 500000, '2 years', 1, 1, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 0, 0, 0, 0, '', 'owl', '2017-06-17 12:05:46', 1497697546, 12, 1506458590, 'Leased out', 'WNW9430_02.png'),
('YHP3388', 'YHP3388-Bungalow-Apata--ibadan', 'Bungalow', 'Eleyele', 'Ibadan', 160000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'Yes', 'Yes', 'No', 60, 80, 80, 90, '', 'owliz', '2017-05-26 06:23:40', 1495776220, 12, 0, '', ''),
('ZIH9918', 'ZIH9918-Shop-Eleyele--Ibadan', 'Shop', 'Eleyele', 'Ibadan', 200000, '1 year, 6 months', 1, 1, 'No', 'No', 'No', 'No', 'No', 30, 0, 20, 60, '', 'jaguar', '0000-00-00 00:00:00', 1516030124, 5, 1516030124, 'Available', 'nil');

-- --------------------------------------------------------

--
-- Table structure for table `property_suggestion`
--

CREATE TABLE `property_suggestion` (
  `client_name` char(255) NOT NULL,
  `client_id` int(20) NOT NULL,
  `property_id` char(20) NOT NULL,
  `agent` varchar(500) NOT NULL,
  `agent_id` int(20) NOT NULL,
  `timestamp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `property_suggestion`
--

INSERT INTO `property_suggestion` (`client_name`, `client_id`, `property_id`, `agent`, `agent_id`, `timestamp`) VALUES
('Bussy', 1495645827, 'DOZ4397', 'Dough', 1477499146, 1505958288),
('Bussy', 1495645827, 'GLY2270', 'Dough', 1477499146, 1505958295),
('Bussy', 1495645827, 'HHQ4493', 'Dough', 1477499146, 1505958532),
('Adedayo', 1504863885, 'GYP6633', 'jaguar', 1477928707, 1506579334),
('Adedayo', 1504863885, 'SAP8871', 'jaguar', 1477928707, 1506585251),
('Adedayo', 1504863885, 'DOZ4397', 'Dough', 1477499146, 1506693535),
('Adedayo', 1504863885, 'GLY2270', 'Dough', 1477499146, 1506693538),
('Adedayo', 1504863885, 'EEG2696', 'owl', 1495661773, 1506884796),
('Adedayo', 1504863885, 'ESA9213', 'owl', 1495661773, 1506884799),
('yemisi', 1501859079, 'EKB1423', 'celine', 1493599503, 1506934760),
('Bussy', 1495645827, 'UOX6857', 'celine', 1493599503, 1507161937),
('Bussy', 1495645827, 'EKB1423', 'celine', 1493599503, 1507161940),
('Adedayo', 1504863885, 'UOX6857', 'celine', 1493599503, 1507161956),
('Adedayo', 1504863885, 'EKB1423', 'celine', 1493599503, 1507161957),
('Matt', 1492382097, 'ATY5844', 'jaguar', 1477928707, 1512036140),
('Matorichy', 1512246726, 'ICS9697', 'adesuper', 1477562968, 1512281013),
('Bussy', 1495645827, 'BAJ1421', 'adesuper', 1477562968, 1512748588),
('Bussy', 1495645827, 'CFV8600', 'adesuper', 1477562968, 1512748589),
('Bussy', 1495645827, 'WIB9005', 'adesuper', 1477562968, 1512748593),
('Adedayo', 1504863885, 'FQW3546', 'jaguar', 1477928707, 1513460953),
('Adedayo', 1504863885, 'HCF1390', 'jaguar', 1477928707, 1513460956),
('Matorichy', 1512246726, 'EKB1423', 'celine', 1493599503, 1513463952),
('Matorichy', 1512246726, 'UOX6857', 'celine', 1493599503, 1513463954),
('Matorichy', 1512246726, 'HCF1390', 'jaguar', 1477928707, 1514034655),
('Matorichy', 1512246726, 'BAJ1421', 'adesuper', 1477562968, 1514035048),
('Matorichy', 1512246726, 'QYQ7568', 'celine', 1493599503, 1514046735),
('Matorichy', 1512246726, 'EFW9761', 'jaguar', 1477928707, 1514287511),
('Adedayo', 1504863885, 'ATY5844', 'jaguar', 1477928707, 1514294814),
('Adedayo', 1504863885, 'MVI1839', 'jaguar', 1477928707, 1514298054),
('Matorichy', 1512246726, 'IIX9313', 'jaguar', 1477928707, 1515700977),
('Matorichy', 1512246726, 'IBR6355', 'jaguar', 1477928707, 1515700982),
('Adedayo', 1504863885, 'EFW9761', 'jaguar', 1477928707, 1515701479),
('Bussy', 1495645827, 'APO5038', 'owliz', 1495664324, 1515785525),
('Adedayomatt', 1515931873, 'MVI1839', 'jaguar', 1477928707, 1515945632),
('Bussy', 1495645827, 'LSI1581', 'owliz', 1495664324, 1515960159),
('Bussy', 1495645827, 'GFN6298', 'owliz', 1495664324, 1515960184),
('Bussy', 1495645827, 'FXM5524', 'owliz', 1495664324, 1515960189),
('Adedayomatt', 1515931873, 'OBB8715', 'jaguar', 1477928707, 1515970791),
('Adedayomatt', 1515931873, 'JUQ6884', 'adedayokay', 1515939351, 1516043986),
('Adedayo', 1504863885, 'JUQ6884', 'adedayokay', 1515939351, 1516044140),
('Adedayo', 1504863885, 'FUX7316', 'adesuper', 1477562968, 1516047778),
('Bussy', 1495645827, 'HCF1390', 'jaguar', 1477928707, 1516258401),
('Bussy', 1495645827, 'SAP8871', 'jaguar', 1477928707, 1516258413),
('yemisi', 1501859079, 'DDB3991', 'jaguar', 1477928707, 1516446583),
('Bussy', 1495645827, 'ATY5844', 'jaguar', 1477928707, 1516446603),
('Bussy', 1495645827, 'DDB3991', 'jaguar', 1477928707, 1516446607),
('Bussy', 1495645827, 'TRS1591', 'alowonle', 1516450078, 1516447605),
('Adedayo', 1504863885, 'TRS1591', 'alowonle', 1516450078, 1516447615),
('Adedayomatt', 1515931873, 'TRS1591', 'alowonle', 1516450078, 1516447622),
('Matorichy', 1512246726, 'TRS1591', 'alowonle', 1516450078, 1516447630),
('Bussy', 1495645827, 'JUQ6884', 'adedayokay', 1515939351, 1516485207),
('Bussy', 1495645827, 'GYP6633', 'jaguar', 1477928707, 1516560126),
('Bussy', 1495645827, 'IIQ8059', 'jaguar', 1477928707, 1516560129),
('Matorichy', 1512246726, 'DDB3991', 'jaguar', 1477928707, 1516560250),
('Dare', 1515959170, 'ATY5844', 'jaguar', 1477928707, 1516560283),
('Dare', 1515959170, 'DDB3991', 'jaguar', 1477928707, 1516560284),
('Dare', 1515959170, 'GYP6633', 'jaguar', 1477928707, 1516560286),
('Dare', 1515959170, 'IIQ8059', 'jaguar', 1477928707, 1516560287),
('Adedayomatt', 1515931873, 'ATY5844', 'jaguar', 1477928707, 1516716901),
('Adedayomatt', 1515931873, 'KNQ3311', 'jaguar', 1477928707, 1516716907),
('Adedayomatt', 1515931873, 'KDE7135', 'jaguar', 1477928707, 1516716910);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agent_agent_follow`
--
ALTER TABLE `agent_agent_follow`
  ADD KEY `client_id` (`agent_follower_id`),
  ADD KEY `agent_id` (`agent_following_id`);

--
-- Indexes for table `agent_notifications`
--
ALTER TABLE `agent_notifications`
  ADD PRIMARY KEY (`notificationid`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Indexes for table `client_agent_follow`
--
ALTER TABLE `client_agent_follow`
  ADD KEY `client_id` (`client_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `client_notifications`
--
ALTER TABLE `client_notifications`
  ADD PRIMARY KEY (`notificationid`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `clipped`
--
ALTER TABLE `clipped`
  ADD PRIMARY KEY (`clip_id`),
  ADD KEY `propertyid` (`propertyid`),
  ADD KEY `clippedby` (`clippedby`);

--
-- Indexes for table `cta`
--
ALTER TABLE `cta`
  ADD PRIMARY KEY (`ctaid`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `cta_request`
--
ALTER TABLE `cta_request`
  ADD PRIMARY KEY (`ctaid`);

--
-- Indexes for table `messagelinker`
--
ALTER TABLE `messagelinker`
  ADD PRIMARY KEY (`conversationid`),
  ADD KEY `initiator` (`initiator`),
  ADD KEY `participant` (`participant`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`messageid`),
  ADD KEY `messages_linker_fk` (`conversationid`);
ALTER TABLE `messages` ADD FULLTEXT KEY `body` (`body`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Business_Name` (`Business_Name`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_ID`),
  ADD KEY `uploadby` (`uploadby`);

--
-- Indexes for table `property_suggestion`
--
ALTER TABLE `property_suggestion`
  ADD KEY `client_id` (`client_id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent_agent_follow`
--
ALTER TABLE `agent_agent_follow`
  ADD CONSTRAINT `agent_follower_fk` FOREIGN KEY (`agent_follower_id`) REFERENCES `profiles` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `agent_following_fk` FOREIGN KEY (`agent_following_id`) REFERENCES `profiles` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `agent_notifications`
--
ALTER TABLE `agent_notifications`
  ADD CONSTRAINT `agent_notification_fk` FOREIGN KEY (`receiver_id`) REFERENCES `profiles` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_agent_follow`
--
ALTER TABLE `client_agent_follow`
  ADD CONSTRAINT `agent_fk` FOREIGN KEY (`agent_id`) REFERENCES `profiles` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `client_fk` FOREIGN KEY (`client_id`) REFERENCES `cta` (`ctaid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `client_notifications`
--
ALTER TABLE `client_notifications`
  ADD CONSTRAINT `client_notification_fk` FOREIGN KEY (`receiver_id`) REFERENCES `cta` (`ctaid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `clipped`
--
ALTER TABLE `clipped`
  ADD CONSTRAINT `clipper_fk` FOREIGN KEY (`clippedby`) REFERENCES `cta` (`ctaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `property_clipped_fk` FOREIGN KEY (`propertyid`) REFERENCES `properties` (`property_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cta_request`
--
ALTER TABLE `cta_request`
  ADD CONSTRAINT `cta_request_fk` FOREIGN KEY (`ctaid`) REFERENCES `cta` (`ctaid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messagelinker`
--
ALTER TABLE `messagelinker`
  ADD CONSTRAINT `agent-update_fk` FOREIGN KEY (`sender`) REFERENCES `profiles` (`Business_Name`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `client_update_fk` FOREIGN KEY (`sender`) REFERENCES `cta` (`name`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_linker_fk` FOREIGN KEY (`conversationid`) REFERENCES `messagelinker` (`conversationid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `agent_properties_fk` FOREIGN KEY (`uploadby`) REFERENCES `profiles` (`User_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `property_suggestion`
--
ALTER TABLE `property_suggestion`
  ADD CONSTRAINT `fk_agent` FOREIGN KEY (`agent_id`) REFERENCES `profiles` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_client` FOREIGN KEY (`client_id`) REFERENCES `cta` (`ctaid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_property` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
