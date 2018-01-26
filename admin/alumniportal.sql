-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 26, 2018 at 12:57 PM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumniportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(15) NOT NULL,
  `user_id` int(15) NOT NULL,
  `question_id` int(15) NOT NULL,
  `answer` varchar(1000) NOT NULL,
  `time_elapsed` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `user_id`, `question_id`, `answer`, `time_elapsed`) VALUES
(1, 17, 1, 'some answer  that can\'t answer your question', 1507560469),
(2, 17, 1, 'yeah', 1507562084),
(3, 15, 1, 'owwwwww!!', 1507563993),
(4, 17, 6, 'ahahahahaha', 1507910945),
(5, 17, 6, 'ahahahaha', 1507912080);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `is_approved` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `time_elapsed` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `comment`, `is_approved`, `status`, `url`, `time_elapsed`) VALUES
(131, 18, 70, 'some comments', 1, 1, '/alumniportal/posts/read.php?post=70', 1508651710),
(132, 18, 63, 'ahahahaha', 1, 1, '/alumniportal/posts/read.php?post=63', 1508651967),
(133, 18, 63, 'ahahaha', 1, 1, '/alumniportal/posts/read.php?post=63', 1508652236),
(134, 18, 61, 'this comment need\'s approval', 0, 1, '/alumniportal/posts/read.php?post=61', 1508653050),
(135, 18, 61, 'ahahahaha', 0, 1, '/alumniportal/posts/read.php?post=61', 1508653381),
(136, 18, 61, 'qweqweqweqe', 0, 1, '/alumniportal/posts/read.php?post=61', 1508653479),
(137, 18, 61, 'haaaaaaaaaaaaaaa', 0, 1, '/alumniportal/posts/read.php?post=61', 1508653549),
(138, 15, 62, 'ahahahahahaha', 0, 1, '/alumniportal/posts/read.php?post=62', 1508654714),
(139, 18, 70, 'ahahahaha', 1, 1, '/alumniportal/posts/read.php?post=70', 1508656572),
(140, 18, 70, 'some comment!', 1, 1, '/alumniportal/posts/read.php?post=70', 1508661876),
(141, 18, 65, 'Some comments', 0, 1, '/alumniportal/posts/read?post=65', 1508842515);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `body` varchar(1000) NOT NULL,
  `image` varchar(255) NOT NULL,
  `skills_needed` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `slot` varchar(11) NOT NULL,
  `time_elapsed` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `permission` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `permission`) VALUES
(1, 'Standard user', ''),
(2, 'Administrator', '{\"admin\":1,\"moderator\":1}');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `content` varchar(10000) NOT NULL,
  `posted` date NOT NULL,
  `type` varchar(55) NOT NULL,
  `status` varchar(50) NOT NULL,
  `image` varchar(111) NOT NULL,
  `time_elapsed` int(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `posted`, `type`, `status`, `image`, `time_elapsed`) VALUES
(61, 'Logo', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '2017-09-29', 'news', 'none', '334711.jpg', 1506702824),
(62, 'Some Announcement', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '2017-09-29', 'events', '', '740677.jpg', 1506702861),
(63, 'Some news', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '2017-09-29', 'news', '', '585833.jpg', 1506702876),
(64, 'Some events ', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '2017-09-29', 'events', ' ', '876253.jpg', 1506702923),
(65, 'Some events ', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '2017-09-29', 'events', '', '971830.jpg', 1506702942),
(66, 'Another news ', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '2017-09-29', 'news', ' ', '241390.jpg', 1506702964),
(67, 'some images', '<p>testing imageLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n\r\n<p><img alt=\"\" src=\"https://static.pexels.com/photos/60597/dahlia-red-blossom-bloom-60597.jpeg\" style=\"height:500px; width:90%\" /></p>\r\n\r\n<p>testing imageLorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '2017-09-30', 'events', ' ', '183282.jpg', 1506786846),
(68, 'testing', '<p>/** This file is part of KCFinder project<br />\r\n&nbsp; *<br />\r\n&nbsp; * &nbsp; &nbsp; &nbsp;@desc Base configuration file<br />\r\n&nbsp; * &nbsp; @package KCFinder<br />\r\n&nbsp; * &nbsp; @version 3.12<br />\r\n&nbsp; * &nbsp; &nbsp;@author Pavel Tzonkov<br />\r\n&nbsp; * @copyright 2010-2014 KCFinder Project<br />\r\n&nbsp; * &nbsp; @license http://opensource.org/licenses/GPL-3.0 GPLv3<br />\r\n&nbsp; * &nbsp; @license http://opensource.org/licenses/LGPL-3.0 LGPLv3<br />\r\n&nbsp; * &nbsp; &nbsp; &nbsp;@link http://kcfinder.sunhater.com<br />\r\n&nbsp; */</p>\r\n\r\n<p>/* IMPORTANT!!! Do not comment or remove uncommented settings in this file<br />\r\n&nbsp; &nbsp;even if you are using session configuration.</p>\r\n\r\n<p><img alt=\"\" src=\"/alumniportal/ckeditor/kcfinder/upload/images/22251398_283037902209158_1652610736_o.jpg\" style=\"height:1920px; width:1080px\" /></p>\r\n', '2017-10-07', 'news', ' ', '204409.jpg', 1507390810),
(69, 'New title', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod<br />\r\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,<br />\r\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo<br />\r\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse<br />\r\ncillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non<br />\r\nproident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\r\n', '2017-10-17', 'news', ' ', '885918.jpg', 1508215853),
(70, '404', '<p>some of them</p>\r\n', '2017-10-20', 'events', 'cancelled', '835187.jpg', 1508512390);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question` varchar(1000) NOT NULL,
  `topic` varchar(1000) NOT NULL,
  `time_elapsed` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `user_id`, `question`, `topic`, `time_elapsed`) VALUES
(1, 17, 'bakit gnaun?', 'ewan ko', 1507447415),
(2, 17, 'whhyuyyy', 'qweqweqwe', 1507455348),
(3, 17, 'QWEUOIBUAISDBAUISDBUIASBDUIABSDUsdn oiasdnoiasn oasiodna an naoisdn oaind oinasond aond oiandi oadoi adi nasdni asoin aoisn aoisn doiasn dnas oiasndio ansdi naoi nasoiqdnaoisdn oiasnd oiansdoin asdi naoi naoidn asoind asoind oiasnd oiasn oiasnd oiasnoi asdinaoi dnaosidn aon asoidnoian oiasndoian ioansoi danoi', 'Changing password', 1507455723),
(4, 17, 'eustion', 'topic ', 1507455783),
(5, 17, '		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod 		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo 		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'qweqewqweqeqweqw', 1507455811),
(6, 17, '	Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod 	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo 	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse 	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non 	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Lorem ipusm dolor sit amet', 1507910154);

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `time_elapsed` int(15) NOT NULL,
  `is_closed` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(11) NOT NULL,
  `cellphone` varchar(50) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `course` varchar(155) NOT NULL,
  `company` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `year_graduated` int(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `salt` varchar(100) NOT NULL,
  `joined` date NOT NULL,
  `groups` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `first_name`, `middle_name`, `last_name`, `address`, `birthday`, `gender`, `cellphone`, `telephone`, `nationality`, `course`, `company`, `position`, `year_graduated`, `password`, `salt`, `joined`, `groups`, `status`) VALUES
(15, 'user', 'user@yahoo.com', 'yeeeee', 'yeeeee', 'yeeeee', 'yeeeee', '2017-10-21', 'yeeeee', '1231', '2312312312', 'yeeeee', 'BSIT', 'yeeeee', 'yeeeee', 0, 'ff56a52e7163fc446d9b09804d1c64fb69040023e51fdf2e991eb83960f24737', '\0°÷[Ö®B[ …?FÊÑÌ´…`­\',’°YzzÝï', '2017-09-13', 2, 1),
(16, 'yeahoh212', 'valdepenachubcha@yahoo.com', 'Axel Mhar', 'M', 'Valdepena', 'lorem ipsum st blablablala', '1999-05-02', 'male', '09123801938', '123123123', 'filipino', 'BSIT', 'No company', 'positionsss', 0, 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', '9dhgDYÀ8ý½âþ¦¶ÇU$ì¾øšØ÷Ô w', '2017-10-01', 1, 1),
(18, 'axe', 'axetroxxxxxx', 'axel mhar', 'qweqwe', 'valdepena', 'axeaxeaxeaxe', '2017-10-03', 'male', '123123123', '123123123', 'axe', 'BSIT', '123123123', 'axe', 0, 'c0c43c876b2b3f9f678cd5810477bd7cf43f58d79f440209583241b7d10d8891', '½íÝ£\'¤ãìStÂ5o])Áª«M\'Ë7°Úè½Xl', '2017-10-18', 2, 1),
(19, 'axios', 'axios@yahoo.com', 'somename', 'middlename', 'bugs', 'address', '1999-05-05', 'male', '123123123', '1231231', 'filipino', 'BSIT', 'no company', 'wqeqwe', 2005, '8e1c31f87113b94be93f6fcaeb03175a6ad970c4d6700f13f3e349ec75bfb391', '/{çä±ŽÏ¾çjBî>æà5ŠT\"æp\\5q~2', '2017-10-20', 1, 1),
(20, 'sample', 'qweqweqwe@yahoo.com', 'firstname', 'middle name', 'lastname', 'address', '1999-05-02', 'male', '123123', '123123', 'sine', 'BSIT', 'no company', 'position', 2009, 'a329a87f19f3a6a75bbbeb91a1d93ecb781bbc0e2632761478b6d036fb17e90c', 'A¾)À\\½¹GåWß±!ôS?¨{é´-”‰VYo¯à˜', '2017-10-20', 1, 1),
(21, 'simpleuser', 'qweqweqweqw@yahoo.com', 'qweqweqweqw', 'qweqweqweqw', 'qweqweqweqw', 'qweqweqweqw', '2018-01-10', 'male', '12313131', '1231312312', 'qweqweqweqw', '', 'qweqweqweqw', 'qweqweqweqw', 2016, '3d1c1e6d610277a59d057c8630413947fcdd2be45303ca5bd369a7ac4eeb4c0d', 'uh†÷ša_«#·Äò’aŒž’ZhÐ==(ëSb', '2018-01-10', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users_session`
--

CREATE TABLE `users_session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_session`
--

INSERT INTO `users_session` (`id`, `user_id`, `hash`) VALUES
(3, 14, '1c7f774cd8206dbf84e2bb38ca9d443aa1f9e0429500eafabe335a8ac8727019'),
(4, 15, 'd39ed054a90a36d4e69d59c532466a100a7c1702916aa763597f022425134e62');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
