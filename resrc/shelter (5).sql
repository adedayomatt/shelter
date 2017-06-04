-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2017 at 09:07 PM
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
('14963436295930644d9d685', 'CAO', 'Adedayo', 1496337666, 'Adedayo', 'unseen', 'n/a', 1496343629);

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
-- Table structure for table `clipped`
--

CREATE TABLE `clipped` (
  `propertyId` char(10) NOT NULL,
  `clippedby` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clipped`
--

INSERT INTO `clipped` (`propertyId`, `clippedby`) VALUES
('BAJ1421', 1492382097),
('QVI8094', 0),
('KNQ3311', 1493535158),
('BKI7119', 1493535158),
('IIX9313', 1493695787),
('BKI7119', 1493695787),
('BAJ1421', 1493535158),
('KNQ3311', 1492382097),
('MVI1839', 1493535158),
('FQW3546', 1493535158),
('QVI8094', 1493535158),
('OBB8715', 1493367886),
('KBA1638', 1493535158),
('FXM5524', 1493695787),
('YBE9285', 1496337666),
('LSI1581', 1496337666),
('VES6501', 1496337666),
('OAS3949', 1496337666);

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
  `datecreated` date NOT NULL,
  `timeCreated` int(20) NOT NULL,
  `expiryTime` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cta`
--

INSERT INTO `cta` (`ctaid`, `name`, `phone`, `email`, `request`, `password`, `datecreated`, `timeCreated`, `expiryTime`) VALUES
(1492382097, 'Matt', 8139004572, 'adedayomatt@gmail.com', 1, 'xxx', '2017-04-16', 0, 0),
(1493367886, 'mato', 8139004572, 'ade@d.com', 1, 'yyy', '2017-04-28', 1493375448, 1495967448),
(1493535158, 'dreh', 9086563453, 'drey@gmail.com', 1, 'xxx', '2017-04-30', 1493542605, 1496134605),
(1493695787, 'Loveth ponle', 8076677788, 'loveth@ymail.com', 1, 'love', '2017-05-02', 1493699357, 1496291357),
(1495645827, 'Bussy', 9045465656, 'bussy@gmail.com', 1, 'xxx', '2017-05-24', 1495654570, 1498246570),
(1496337666, 'Adedayo', 8139004572, 'adedayomatt@gmail.com', 1, 'kkk', '2017-06-01', 1496343629, 1498935629);

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
('1492382097', 'Duplex', 50000000, 'ibadan'),
('1493367886', 'Duplex', 5000000, 'ibadan'),
('1493535158', 'Bungalow', 900000, 'ibadan'),
('1493695787', 'Bungalow', 500000, 'Ibadan'),
('1495645827', 'Bungalow', 5000000, 'ibadan'),
('1496337666', 'Flat', 150000, 'Abeokuta'),
('ade1480507790', 'flat', 500000, 'kingston');

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
('Matt', 'Dough Enterprise', 'C4A'),
('Jaguar Enterprise', 'Ade Super', 'A4A'),
('Matt', 'Hummer Merchandize', 'C4A'),
('Hummer Merchandize', 'Jaguar Enterprise', 'A4A'),
('Matt', 'Ade Super', 'C4A'),
('ade', 'MNO Enterprise', 'C4A'),
('dreh', 'Hummer Merchandize', 'C4A'),
('Loveth ponle', 'Jaguar Enterprise', 'C4A'),
('Jaguar Enterprise', 'MNO Enterprise', 'A4A'),
('Hummer Merchandize', 'Ade Super', 'A4A'),
('Jaguar Enterprise', 'Jaguar Enterprise', 'A4A'),
('dreh', 'MNO Enterprise', 'C4A'),
('mato', 'Owl liz', 'C4A'),
('Owl liz', 'Hummer Merchandize', 'A4A'),
('Jaguar Enterprise', 'Owl City', 'A4A'),
('Owl City', 'Jaguar Enterprise', 'A4A'),
('dreh', 'Jaguar Enterprise', 'C4A'),
('dreh', 'Dough Enterprise', 'C4A'),
('dreh', 'Oguns', 'C4A'),
('Hummer Merchandize', 'MNO Enterprise', 'A4A'),
('Jaguar Enterprise', 'Owl liz', 'A4A'),
('Loveth ponle', 'MNO Enterprise', 'C4A'),
('Adedayo', 'Jaguar Enterprise', 'C4A'),
('Owl City', 'Dough Enterprise', 'A4A'),
('Ade Super', 'Owl liz', 'A4A');

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

--
-- Dumping data for table `messagelinker`
--

INSERT INTO `messagelinker` (`conversationid`, `subject`, `initiator`, `participant`, `totalmsg`, `lastmsg`, `sender`, `lastmsgtime`, `status`) VALUES
(29126593, 'no subject', 'mato', 'Jaguar Enterprise', 2, 'kkk', 'mato', 1494705920, 'seen'),
(2955491675, 'HELP!!', 'Jaguar Enterprise', 'Ade Super & Coy.', 1, 'hello, please i need your help on something, reply this message ASAP you get it.\r\nThanks.', 'Jaguar Enterprise', 1493989785, 'seen'),
(2970310804, 'no subject', 'Matt', 'Jaguar Enterprise', 1, 'Hello Jagg.', 'Matt', 1494055609, 'seen'),
(2970867032, 'no subject', 'mato', 'Dough Enterprise', 3, 'dfghj', 'mato', 1493987756, 'unseen'),
(2970936365, 'no subject', 'mato', 'Hummer Merchandize', 6, 'jjjj', 'mato', 1494705955, 'unseen'),
(2970964678, 'no subject', 'mato', 'Gods Will', 6, 'qwertyu', 'mato', 1493988289, 'unseen'),
(2971098126, 'no subject', 'dreh', 'Ade Super & Coy.', 1, 'hello sir\r\n', 'dreh', 1495181298, 'seen'),
(2971296593, 'no subject', 'mato', 'Jaguar Enterprise', 1, 'Why??', 'mato', 1494523985, 'unseen'),
(2971463865, 'Testing', 'dreh', 'Jaguar Enterprise', 5, 'Just checking for something', 'dreh', 1496072210, 'seen'),
(2973227292, 'no subject', 'Owl liz', 'Ade Super & Coy.', 6, 'Now you see me', 'Ade Super', 1495793750, 'seen'),
(2973590480, 'Pleasure', 'Jaguar Enterprise', 'Owl City', 2, 'It was so nice to meet you.', 'Owl City', 1496123358, 'seen'),
(2973593031, 'hey', 'Jaguar Enterprise', 'Owl liz', 7, 'Hello Owl', 'Jaguar Enterprise', 1496057776, 'seen'),
(2973829637, 'hack', 'dreh', 'Oguns & sons', 1, 'Impersonation', 'dreh', 1493989142, 'seen'),
(2973900634, 'no subject', 'Adedayo', 'Ade Super & Coy.', 1, 'Hello Baba', 'Adedayo', 1496346360, 'seen'),
(2989032210, 'no subject', 'mato', 'Owl liz', 2, 'ok', 'mato', 1495823612, 'seen'),
(2989196931, 'Appointment', 'dreh', 'Owl City', 1, 'hello Owl, I saw a property uploaded by you recently, and i am intersted, i was thinking if i could book an appointment with you. Please reply ASAP.', 'dreh', 1496093541, 'seen'),
(2989360111, 'no subject', 'Loveth ponle', 'Owl liz', 1, 'My CTA will expire in some minute time.', 'Loveth ponle', 1496290037, 'seen'),
(4590321477499146, 'Apology', 'Admin, Shelter', 'Dough Enterprise', 1, 'We are sorry for the error in network the other night. we have resolved the issue.\r\n\r\nTeam Shelter', 'Admin, Shelter', 1494843804, 'unseen'),
(4590321477562968, 'Apology', 'Admin, Shelter', 'Ade Super & Coy.', 1, 'We are sorry for the error in network the other night. we have resolved the issue.\r\n\r\nTeam Shelter', 'Admin, Shelter', 1494843805, 'seen'),
(4590321477568479, 'Ok', 'Admin, Shelter', 'Hummer Merchandize', 2, 'is it working?', 'Admin, Shelter', 1494845783, 'unseen'),
(4590321477596792, 'Apology', 'Admin, Shelter', 'Gods Will', 1, 'We are sorry for the error in network the other night. we have resolved the issue.\r\n\r\nTeam Shelter', 'Admin, Shelter', 1494843805, 'unseen'),
(4590321477928707, '', 'Admin, Shelter', 'Jaguar Enterprise', 4, 'hey', 'Admin, Shelter', 1494888622, 'seen');

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

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`conversationid`, `messageid`, `subject`, `sender`, `receiver`, `body`, `status`, `timestamp`) VALUES
(29126593, 1513832421, 'no subject', 'mato', 'Jaguar Enterprise', 'cvbnm', 'seen', 1494705828),
(29126593, 1513832513, 'no subject', 'mato', 'Jaguar Enterprise', 'kkk', 'seen', 1494705920),
(2955491675, 4439481460, 'HELP!!', 'Jaguar Enterprise', 'Ade Super & Coy.', 'hello, please i need your help on something, reply this message ASAP you get it.\r\nThanks.', 'seen', 1493989785),
(2970310804, 4454366413, 'no subject', 'Matt', 'Jaguar Enterprise', 'Hello Jagg.', 'seen', 1494055609),
(2970867032, 4454854760, 'no subject', 'mato', 'Dough Enterprise', 'hey', 'unseen', 1493987728),
(2970867032, 4454854770, 'no subject', 'mato', 'Dough Enterprise', 'ok', 'unseen', 1493987738),
(2970867032, 4454854788, 'no subject', 'mato', 'Dough Enterprise', 'dfghj', 'unseen', 1493987756),
(2970936365, 4454924240, 'no subject', 'mato', 'Hummer Merchandize', 'i am only human', 'unseen', 1493987875),
(2970936365, 4454928415, 'no subject', 'mato', 'Hummer Merchandize', 'Hello', 'unseen', 1493992050),
(2970936365, 4454928461, 'no subject', 'mato', 'Hummer Merchandize', 'Hello sir\r\n', 'unseen', 1493992096),
(2970936365, 4454928635, 'no subject', 'mato', 'Hummer Merchandize', 'Oh baby!', 'unseen', 1493992270),
(2970936365, 4454928658, 'ganga', 'mato', 'Hummer Merchandize', 'Oh baby!', 'unseen', 1493992293),
(2970964678, 4454952733, 'no subject', 'mato', 'Gods Will', 'HELLO GODSWILL!!', 'unseen', 1493988055),
(2970964678, 4454952781, 'Confirmation', 'mato', 'Gods Will', 'got my message?', 'unseen', 1493988103),
(2970964678, 4454952865, 'no subject', 'mato', 'Gods Will', 'alright', 'unseen', 1493988187),
(2970964678, 4454952916, 'no subject', 'mato', 'Gods Will', 'alright', 'unseen', 1493988238),
(2970964678, 4454952932, 'no subject', 'mato', 'Gods Will', 'hello', 'unseen', 1493988254),
(2970964678, 4454952967, 'no subject', 'mato', 'Gods Will', 'qwertyu', 'unseen', 1493988289),
(2971463865, 4455452636, 'no subject', 'dreh', 'Jaguar Enterprise', 'darey', 'seen', 1493988771),
(2971463865, 4455452658, 'no subject', 'dreh', 'Jaguar Enterprise', 'darey', 'seen', 1493988793),
(2971463865, 4455452674, 'no subject', 'dreh', 'Jaguar Enterprise', 'xss', 'seen', 1493988809),
(2971463865, 4455452792, 'no subject', 'dreh', 'Jaguar Enterprise', 'oya nah', 'seen', 1493988927),
(2970936365, 4455642320, 'no subject', 'mato', 'Hummer Merchandize', 'jjjj', 'unseen', 1494705955),
(2971296593, 4455820578, 'no subject', 'mato', 'Jaguar Enterprise', 'Why??', 'unseen', 1494523985),
(2971098126, 4456279424, 'no subject', 'dreh', 'Ade Super & Coy.', 'hello sir\r\n', 'seen', 1495181298),
(2971463865, 4457536075, 'Testing', 'dreh', 'Jaguar Enterprise', 'Just checking for something', 'seen', 1496072210),
(2973829637, 4457818779, 'hack', 'dreh', 'Oguns & sons', 'Impersonation', 'seen', 1493989142),
(2973227292, 4459020255, 'no subject', 'Owl liz', 'Ade Super & Coy.', 'Hello Adesupet', 'seen', 1495792963),
(2973227292, 4459020382, 'no subject', 'Ade Super', 'Owl liz', 'whats up\r\n', 'seen', 1495793090),
(2973227292, 4459020574, 'no subject', 'Ade Super', 'Owl liz', 'pull over!', 'seen', 1495793282),
(2973227292, 4459020879, 'no subject', 'Ade Super', 'Owl liz', 'Now you see me', 'seen', 1495793587),
(2973227292, 4459020933, 'no subject', 'Ade Super', 'Owl liz', 'Now you see me', 'seen', 1495793641),
(2973227292, 4459021042, 'no subject', 'Ade Super', 'Owl liz', 'Now you see me', 'seen', 1495793750),
(2973590480, 4459386876, 'Reminder', 'Jaguar Enterprise', 'Owl City', 'Hello, we haven''t heard from you in a while, what is going on?\r\n', 'seen', 1495796396),
(2973593031, 4459386958, 'no subject', 'Jaguar Enterprise', 'Owl liz', 'now you see me!', 'seen', 1495793927),
(2973593031, 4459387184, 'no subject', 'Jaguar Enterprise', 'Owl liz', 'now you see me!', 'seen', 1495794153),
(2973593031, 4459387507, 'no subject', 'Jaguar Enterprise', 'Owl liz', 'now you see me!', 'seen', 1495794476),
(2973593031, 4459387599, 'no subject', 'Owl liz', 'Jaguar Enterprise', 'Thank you i got your message.\r\n\r\nRegards', 'seen', 1495794568),
(2973593031, 4459387879, 'Treasure', 'Jaguar Enterprise', 'Owl liz', 'I found my treasure in you.', 'seen', 1495794848),
(2973593031, 4459387947, 'Treasure', 'Jaguar Enterprise', 'Owl liz', 'I found my treasure in you.', 'seen', 1495794916),
(2973593031, 4459650807, 'hey', 'Jaguar Enterprise', 'Owl liz', 'Hello Owl', 'seen', 1496057776),
(2973590480, 4459713838, 'Pleasure', 'Owl City', 'Jaguar Enterprise', 'It was so nice to meet you.', 'seen', 1496123358),
(2973900634, 4460246994, 'no subject', 'Adedayo', 'Ade Super & Coy.', 'Hello Baba', 'seen', 1496346360),
(2989032210, 4474827215, 'no subject', 'mato', 'Owl liz', 'Feels soo good', 'seen', 1495795005),
(2989032210, 4474855822, 'no subject', 'mato', 'Owl liz', 'ok', 'seen', 1495823612),
(2989196931, 4475290472, 'Appointment', 'dreh', 'Owl City', 'hello Owl, I saw a property uploaded by you recently, and i am intersted, i was thinking if i could book an appointment with you. Please reply ASAP.', 'seen', 1496093541),
(2989360111, 4475650148, 'no subject', 'Loveth ponle', 'Owl liz', 'My CTA will expire in some minute time.', 'seen', 1496290037),
(4590321477499146, 4590322962343000, 'Apology', 'Admin, Shelter', 'Dough Enterprise', 'We are sorry for the error in network the other night. we have resolved the issue.\r\n\r\nTeam Shelter', 'unseen', 1494843804),
(4590321477562968, 4590322962406800, 'Apology', 'Admin, Shelter', 'Ade Super & Coy.', 'We are sorry for the error in network the other night. we have resolved the issue.\r\n\r\nTeam Shelter', 'seen', 1494843805),
(4590321477568479, 4590322962412300, 'Apology', 'Admin, Shelter', 'Hummer Merchandize', 'We are sorry for the error in network the other night. we have resolved the issue.\r\n\r\nTeam Shelter', 'unseen', 1494843805),
(4590321477568479, 4590322962414300, 'Ok', 'Admin, Shelter', 'Hummer Merchandize', 'is it working?', 'unseen', 1494845783),
(4590321477596792, 4590322962440600, 'Apology', 'Admin, Shelter', 'Gods Will', 'We are sorry for the error in network the other night. we have resolved the issue.\r\n\r\nTeam Shelter', 'unseen', 1494843805),
(4590321477928707, 4590322962772000, 'Appreciation', 'Admin, Shelter', 'Jaguar Enterprise', 'This is to thank you for choosing shelter', 'seen', 1494843270),
(4590321477928707, 4590322962772300, 'hi', 'Admin, Shelter', 'Jaguar Enterprise', 'Hello', 'seen', 1494843632),
(4590321477928707, 4590322962772500, 'Apology', 'Admin, Shelter', 'Jaguar Enterprise', 'We are sorry for the error in network the other night. we have resolved the issue.\r\n\r\nTeam Shelter', 'seen', 1494843805),
(4590321477928707, 4590322962817300, '', 'Admin, Shelter', 'Jaguar Enterprise', 'hey', 'seen', 1494888622);

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
('A4A58fb98282191c', 'Jaguar Enterprise', 'jaguar', 'MNO Enterprise', 'A4Afollow', 'unseen', 1492883496),
('A4A5900bd7848696', 'Jaguar Enterprise', 'jaguar', 'Ade Super', 'A4Afollow', 'unseen', 1493220728),
('A4A5900bd835a637', 'Jaguar Enterprise', 'jaguar', 'Ade Super', 'A4Afollow', 'unseen', 1493220739),
('A4A5900bd85ad6dd', 'Jaguar Enterprise', 'jaguar', 'Ade Super', 'A4Afollow', 'unseen', 1493220741),
('A4A590c792f9790a', 'Jaguar Enterprise', 'jaguar', 'MNO Enterprise', 'A4Afollow', 'unseen', 1493989679),
('A4A59176bc3f01b3', 'Hummer Merchandize', 'sir', 'Ade Super', 'A4Afollow', 'unseen', 1494707139),
('A4A591c9778ad84c', 'Jaguar Enterprise', 'jaguar', 'Dough Enterprise', 'A4Afollow', 'unseen', 1495046008),
('A4A591c97820b0d2', 'Jaguar Enterprise', 'jaguar', 'Jaguar Enterprise', 'A4Afollow', 'unseen', 1495046018),
('A4A5927fa0fc1360', 'Owl liz', 'owliz', 'MNO Enterprise', 'A4Afollow', 'unseen', 1495792143),
('A4A5927fb4b008d3', 'Owl liz', 'owliz', 'Hummer Merchandize', 'A4Afollow', 'unseen', 1495792459),
('A4A5927fb52bed83', 'Owl liz', 'owliz', 'MNO Enterprise', 'A4Afollow', 'unseen', 1495792466),
('A4A59280a65cd6c8', 'Jaguar Enterprise', 'jaguar', 'Owl City', 'A4Afollow', 'unseen', 1495796325),
('A4A59280d0ddd32b', 'Owl City', 'owl', 'Jaguar Enterprise', 'A4Afollow', 'unseen', 1495797005),
('A4A592c285d548aa', 'Hummer Merchandize', 'sir', 'MNO Enterprise', 'A4Afollow', 'unseen', 1496066141),
('A4A592cae973a65c', 'Jaguar Enterprise', 'jaguar', 'Owl liz', 'A4Afollow', 'unseen', 1496100503),
('A4A5934495082be8', 'Owl City', 'owl', 'Dough Enterprise', 'A4Afollow', 'unseen', 1496598864),
('A4A5934580c09565', 'Ade Super', 'adesuper', 'Owl liz', 'A4Afollow', 'unseen', 1496602636),
('A4A5934581068200', 'Ade Super', 'adesuper', 'Owl liz', 'A4Afollow', 'unseen', 1496602640),
('C4A58f4010f56b5a', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1492386063),
('C4A58f407ebd818c', 'Matt', '1492382097', 'Dough Enterprise', 'C4Afollow', 'unseen', 1492387819),
('C4A58f5341cbd7c3', 'Matt', '1492382097', 'Dough Enterprise', 'C4Afollow', 'unseen', 1492464668),
('C4A58f534261db42', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1492464678),
('C4A58f534293bc6d', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1492464681),
('C4A5900b22f3aebb', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493217839),
('C4A5900b5c113f3c', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493218753),
('C4A5900b5f899859', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493218808),
('C4A5900b605c13fe', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493218821),
('C4A5900b61ea3137', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493218846),
('C4A5900b621134f8', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493218849),
('C4A5900b6570fa9d', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493218903),
('C4A5900b68617e00', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493218950),
('C4A5900b7f26889e', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219314),
('C4A5900b9841b056', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219716),
('C4A5900b9bb250ca', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219771),
('C4A5900ba75377f9', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219957),
('C4A5900ba775705b', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219959),
('C4A5900ba7a3bf68', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219962),
('C4A5900ba7dec875', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219965),
('C4A5900ba846d2d2', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219972),
('C4A5900ba8e1c022', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493219982),
('C4A5900bbdfdaa69', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493220319),
('C4A5900bcaca5d0a', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493220524),
('C4A5900bcb3c69fe', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493220531),
('C4A5900bcbde4c9d', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493220541),
('C4A5900bccddfe0c', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493220557),
('C4A5900bcd35585f', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493220563),
('C4A5900bcd9a14ad', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493220569),
('C4A5900c08010654', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493221504),
('C4A5900c091c7fe3', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493221521),
('C4A5900c0dc37010', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493221596),
('C4A5902170836517', 'Matt', '1492382097', 'MNO Enterprise', 'C4Afollow', 'unseen', 1493309192),
('C4A590228513f219', 'Matt', '1492382097', 'Ade Super', 'C4Afollow', 'unseen', 1493313617),
('C4A5904392106589', 'mato', '1493367886', 'Dough Enterprise', 'C4Afollow', 'unseen', 1493448993),
('C4A590439261f0e2', 'mato', '1493367886', 'MNO Enterprise', 'C4Afollow', 'unseen', 1493448998),
('C4A59047b25b8a1b', 'ade', 'ade1480507790', 'MNO Enterprise', 'C4Afollow', 'unseen', 1493465893),
('C4A590502fdf3d33', 'mato', '1493367886', 'Dough Enterprise', 'C4Afollow', 'unseen', 1493500669),
('C4A59064f63459b2', 'dreh', '1493535158', 'Dough Enterprise', 'C4Afollow', 'unseen', 1493585763),
('C4A590c83eb26b5a', 'mato', '1493367886', 'Ade Super', 'C4Afollow', 'unseen', 1493992427),
('C4A591212d27726d', 'mato', '1493367886', 'Dough Enterprise', 'C4Afollow', 'unseen', 1494356690),
('C4A5912141359b7f', 'mato', '1493367886', 'Celine deon organization', 'C4Afollow', 'unseen', 1494357011),
('C4A591769118d992', 'mato', '1493367886', 'Dough Enterprise', 'C4Afollow', 'unseen', 1494706449),
('C4A59189cb6c1ee4', 'mato', '1493367886', 'Ade Super', 'C4Afollow', 'unseen', 1494785206),
('C4A59189cef56c3d', 'mato', '1493367886', 'Ade Super', 'C4Afollow', 'unseen', 1494785263),
('C4A59189cfd905ff', 'mato', '1493367886', 'Ade Super', 'C4Afollow', 'unseen', 1494785277),
('C4A5918b59b5b3b7', 'mato', '1493367886', 'Gods Will', 'C4Afollow', 'unseen', 1494791579),
('C4A591c95ce6eed4', 'mato', '1493367886', 'Hummer Merchandize', 'C4Afollow', 'unseen', 1495045582),
('C4A591d392d62db8', 'dreh', '1493535158', 'Jaguar Enterprise', 'C4Afollow', 'unseen', 1495087405),
('C4A591e28e9c5b62', 'dreh', '1493535158', 'Dough Enterprise', 'C4Afollow', 'unseen', 1495148777),
('C4A591f36ed3e6df', 'dreh', '1493535158', 'MNO Enterprise', 'C4Afollow', 'unseen', 1495217901),
('C4A591f3d5a1c067', 'dreh', '1493535158', 'MNO Enterprise', 'C4Afollow', 'unseen', 1495219546),
('C4A5927cef1a33d7', 'mato', '1493367886', 'Owl liz', 'C4Afollow', 'unseen', 1495781105),
('C4A59287513f0a3e', 'mato', '1493367886', 'Dough Enterprise', 'C4Afollow', 'unseen', 1495823635),
('C4A59296239233b5', 'dreh', '1493535158', 'Ade Super', 'C4Afollow', 'unseen', 1495884345),
('C4A59296eba55004', 'dreh', '1493535158', 'Jaguar Enterprise', 'C4Afollow', 'unseen', 1495887546),
('C4A592989357baf5', 'mato', '1493367886', 'Jaguar Enterprise', 'C4Afollow', 'unseen', 1495894325),
('C4A592bd3b784d6e', 'dreh', '1493535158', 'Dough Enterprise', 'C4Afollow', 'unseen', 1496044471),
('C4A592bd41f80939', 'dreh', '1493535158', 'Oguns', 'C4Afollow', 'unseen', 1496044575),
('C4A592f944aba538', 'Loveth ponle', '1493695787', 'MNO Enterprise', 'C4Afollow', 'unseen', 1496290378),
('C4A5930656b786bc', 'Adedayo', '1496337666', 'Jaguar Enterprise', 'C4Afollow', 'unseen', 1496343915),
('C4A59306880005a8', 'Adedayo', '1496337666', 'Owl liz', 'C4Afollow', 'unseen', 1496344704),
('CTAcreate59080b1d91b0c', 'Loveth ponle', '1493695787', 'Loveth ponle', 'CTA created', 'unseen', 1493699357),
('CTAcreate5925e0aad202a', 'Bussy', '1495645827', 'Bussy', 'CTA created', 'unseen', 1495654570),
('CTAcreate5930644d95983', 'Adedayo', '1496337666', 'Adedayo', 'CTA created', 'unseen', 1496343629);

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
  `password` varchar(30) NOT NULL,
  `timestamp` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`ID`, `Business_Name`, `Office_Address`, `Office_Tel_No`, `Business_email`, `CEO_Name`, `Phone_No`, `Alt_Phone_No`, `email`, `User_ID`, `password`, `timestamp`) VALUES
(1477470316, 'MNO Enterprise', 'lagoon, nigeria, West Africa', 8035476354, 'mno@gmail.com', 'Chals Loveth', 8156565734, 8156565734, 'chals@gmail.com', 'chalz', 'love', 0),
(1477499146, 'Dough Enterprise', 'lagoon, nigeria, West Africa', 8035476354, 'mno@gmail.com', 'Xender Alexis', 8156565734, 0, 'alexis@gmail.com', 'Dough', 'dil', 0),
(1477562968, 'Ade Super & Coy.', 'Eleyele Ibadan', 9077667560, 'adesuper@yahoo.com', 'Emmanuel Adesuper kayode', 7078675755, 8156675469, 'edayo@hotmail.com', 'adesuper', 'sup', 0),
(1477568479, 'Hummer Merchandize', 'olokonla', 8098797986, 'hm@w.com', 'Sorry Sir', 8978978687, 8097986789, 'ss@gmail.com', 'sir', 'you', 0),
(1477596792, 'Gods Will', 'km 9, Arulogun Area', 8098797986, 'goe@gmail.com', 'Godwin Akpokodje', 8978978687, 8156675465, 'goe@gmail.com', 'Godwill', 'god', 0),
(1477928707, 'Jaguar Enterprise', 'Ibadan, nigeria, West Africa', 8035476353, 'jaguarenterprise@gmail.com', 'Olivia Ericy', 8156565730, 8198798758, 'olivia@gmail.com', 'jaguar', 'olivia', 0),
(1480093605, 'Floccinaucinihilipilification ', 'Itokun Abeokuta, Nigeria Anglo', 9048877574, 'flha@gmail.com', 'Mato ota', 8139004778, 81390049954, 'matoo@gmail.com', 'mato', 'mat', 0),
(1480294479, 'Oguns & sons', 'Eleyele Ib"badan''', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Oguns', 'ogun', 0),
(1480294504, 'Oguns & sons', 'Eleyele Ib"badan''', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Oguns', 'ogun', 0),
(1480296365, 'Oguns & sons', 'Eleyele Ib"badan''', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Ogunk', 'ogun', 0),
(1480296426, 'Oguns & sons', 'Eleyele Ib"badan''', 78976879667, 'oguns@gmail.com', 'Ogunmola Ogun''kanmi', 9079868745, 9809786757, '''kanm@gmail.com', 'Ogunk', 'ogun', 0),
(1480298043, 'Odekunle Nig Ent', 'suite 9, Ondo Street', 7085476587, 'dekunle@yahoo.com', 'Odekunle Afolabi', 8156565734, 8139004572, 'afoo@gmail.com', 'Kunlex', 'kun', 0),
(1493599503, 'Celine deon organization', 'pent house, Pennsylvania, USA', 8139003589, 'celinedeon@gmail', 'Celine Deon', 8162367899, 9064567855, 'celine@yahoo.com', 'celine', 'deon', 0),
(1495661773, 'Owl City', 'No 9, Gotham complex, ikeja, Lagos, Nigeria', 8154676783, 'owlcity@yahoo.com', 'Pieper Pepper', 8087468468, 7037537653, 'ppepper@gmailcom', 'owl', 'city', 1495656610),
(1495664324, 'Owl liz', 'No 9, Gotham complex, ikeja, Lagos, Nigeria', 8154676783, 'owlcity@yahoo.com', 'Pieper Pepper', 8087468468, 7037537653, 'ppepper@gmailcom', 'owliz', 'liz', 1495658036),
(1495805257, 'Owl State', 'No 9, Gotham complex, ikeja, Lagos, Nigeria', 8154676783, 'owlcity@yahoo.com', 'Pieper Pepper', 8087468468, 7037537653, 'ppepper@gmailcom', 'owlis', 'ioio', 1495796849);

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
  `timestamp` int(20) NOT NULL,
  `views` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_ID`, `directory`, `type`, `location`, `rent`, `min_payment`, `bath`, `toilet`, `pumping_machine`, `borehole`, `well`, `tiles`, `parking_space`, `electricity`, `road`, `socialization`, `security`, `description`, `uploadby`, `date_uploaded`, `timestamp`, `views`) VALUES
('APO5038', 'APO5038-Duplex-ibadan', 'Duplex', 'ibadan', 70000, '1 year, 6 months', 1, 1, 'No', 'Yes', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owliz', '2017-05-24 21:57:17', 1495659437, 1),
('BAJ1421', 'BAJ1421-Flat-at-kingston', 'Flat', 'kingston', 150000, '1 year', 1, 1, 'Yes', 'No', 'No', 'Yes', 'No', 0, 0, 0, 0, '', 'adesuper', '2017-02-08 09:36:23', 0, 2),
('BKI7119', 'BKI7119-Duplex-ogun-state', 'Duplex', 'ogun state', 5000, '1 year, 6 Months', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'sir', '2017-04-22 09:33:16', 1492849996, 7),
('EGS7748', 'EGS7748-Boys-Quater-alabata--Abeokua', 'Boys Quater', 'alabata, Abeokua', 150000, '1 Year', 3, 3, 'Yes', 'No', 'Yes', 'Yes', 'No', 70, 60, 90, 90, '', 'owliz', '2017-05-26 06:54:00', 1495778040, 6),
('FQW3546', 'FQW3546-Bungalow-abeokuta', 'Bungalow', 'abeokuta', 200000, '1 year', 1, 1, 'No', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2017-04-22 09:21:27', 1492849287, 8),
('FXM5524', 'FXM5524-Bungalow-Apata--ibadan', 'Bungalow', 'Apata, ibadan', 160000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'Yes', 'Yes', 'No', 60, 80, 80, 90, '', 'owliz', '2017-05-26 06:34:30', 1495776870, 6),
('GFN6298', 'GFN6298-Bungalow-Apata--ibadan', 'Bungalow', 'Apata, ibadan', 160000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'Yes', 'Yes', 'No', 60, 80, 80, 90, '', 'owliz', '2017-05-26 06:31:52', 1495776712, 2),
('HCF1390', 'HCF1390-Self-Contain-at-OJO', 'Self Contain', 'OJO', 1200000, '1 year, 6 Months', 1, 1, 'Yes', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2016-12-05 08:24:42', 0, 2),
('IIX9313', 'IIX9313-Office-Space-at-sango-otta', 'Office Space', 'sango otta', 120000, '1 year', 1, 1, 'No', 'No', 'No', 'Yes', 'No', 60, 20, 15, 70, 'great', 'jaguar', '2016-12-03 23:17:24', 0, 2),
('IQC9892', 'IQC9892-Duplex-ibadan', 'Duplex', 'ibadan', 70000, '1 year, 6 months', 1, 1, 'No', 'Yes', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owliz', '2017-05-24 22:14:43', 1495660483, 2),
('KBA1638', 'KBA1638-Flat-ijokodo--Ibadan', 'Flat', 'ijokodo, Ibadan', 100000, '2 years', 1, 1, 'No', 'Yes', 'No', 'No', 'Yes', 0, 0, 0, 0, '', 'owliz', '2017-05-26 06:41:06', 1495777266, 7),
('KNQ3311', 'KNQ3311-Duplex-uioioij', 'Duplex', 'uioioij', 6546465, '1 year', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2017-04-22 18:54:17', 1492883657, 11),
('LSI1581', 'LSI1581-Bungalow-abeokuta', 'Bungalow', 'abeokuta', 80000, '2 years', 1, 1, 'No', 'No', 'Yes', 'No', 'No', 0, 0, 0, 0, '', 'owliz', '2017-05-24 22:28:14', 1495661294, 2),
('MVI1839', 'MVI1839-Bungalow-at-ijokodo--Ibadan', 'Bungalow', 'ijokodo, Ibadan', 200000, '1 Year', 5, 2, 'Yes', 'Yes', 'No', 'Yes', 'Yes', 60, 50, 80, 30, '', 'jaguar', '2016-12-05 11:01:35', 0, 2),
('OAS3949', 'OAS3949-Semi-detached-House-at-ijokodo,-Ibadan', 'Semi detached House', 'ijokodo, Ibadan', 200000, '1 Year, 6 Months', 1, 1, 'Yes', 'No', 'Yes', 'Yes', 'No', 40, 80, 70, 50, '', 'adesuper', '2016-12-03 10:35:06', 0, 2),
('OBB8715', 'OBB8715-Office-Space-nnmm', 'Office Space', 'nnmm', 123456, '2 years', 1, 1, 'No', 'No', 'No', 'No', 'No', 0, 0, 0, 0, '', 'jaguar', '2017-04-22 18:52:38', 1492883558, 11),
('QVI8094', 'QVI8094-Boys-Quater-apata-ibadan', 'Boys Quater', 'apata ibadan', 2000000, '1 year, 6 months', 1, 1, 'Yes', 'Yes', 'No', 'Yes', 'No', 50, 80, 15, 80, 'So so good and lovely. it is detached', 'sir', '2017-04-28 18:53:58', 1493402038, 22),
('VES6501', 'VES6501-Bungalow-at-getdg', 'Bungalow', 'getdg', 3456789, '1 year', 3, 1, 'No', 'Yes', 'No', 'No', 'No', 0, 0, 0, 0, '', 'adesuper', '2016-12-03 10:32:25', 0, 2),
('VFD8212', 'VFD8212-Bungalow-Apata--ibadan', 'Bungalow', 'Apata, ibadan', 160000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'Yes', 'Yes', 'No', 60, 80, 80, 90, '', 'owliz', '2017-05-26 06:28:36', 1495776516, 1),
('WPJ7862', 'WPJ7862-Hall-alabata--abeokuta', 'Hall', 'alabata, abeokuta', 400000, '2 years', 5, 5, 'Yes', 'Yes', 'No', 'No', 'No', 60, 70, 100, 10, '', 'sir', '2017-04-28 14:56:34', 1493387794, 8),
('YBE9285', 'YBE9285-Flat-Corporate-Estate-', 'Flat', 'Corporate Estate.', 150000, '1 year', 2, 2, 'Yes', 'Yes', 'No', 'Yes', 'No', 70, 90, 80, 100, '', 'sir', '2017-05-29 15:05:18', 1496066718, 28),
('YHP3388', 'YHP3388-Bungalow-Apata--ibadan', 'Bungalow', 'Apata, ibadan', 160000, '1 year, 6 months', 2, 2, 'Yes', 'No', 'Yes', 'Yes', 'No', 60, 80, 80, 90, '', 'owliz', '2017-05-26 06:23:40', 1495776220, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

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
