-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2016-12-24 07:37:32
-- 伺服器版本: 10.1.16-MariaDB
-- PHP 版本： 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `project`
--

-- --------------------------------------------------------

--
-- 資料表結構 `card`
--

CREATE TABLE `card` (
  `CID` int(11) NOT NULL,
  `cardname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `card`
--

INSERT INTO `card` (`CID`, `cardname`) VALUES
(1, 'C1'),
(2, 'C2'),
(3, 'C3'),
(4, 'C4'),
(5, 'C5'),
(6, 'C6'),
(7, 'C7'),
(8, 'C8');

-- --------------------------------------------------------

--
-- 資料表結構 `history`
--

CREATE TABLE `history` (
  `HID` int(10) NOT NULL,
  `HUID` int(10) NOT NULL,
  `HSID` int(10) NOT NULL,
  `hisprice` int(10) NOT NULL,
  `histime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `history`
--

INSERT INTO `history` (`HID`, `HUID`, `HSID`, `hisprice`, `histime`) VALUES
(1, 1, 4, 2, '2016-12-02 00:00:00'),
(2, 1, 4, 2, '2016-12-02 00:00:00'),
(3, 1, 5, 10, '2016-12-02 21:33:37'),
(4, 1, 6, 11, '2016-12-03 00:52:39'),
(5, 1, 6, 5, '2016-12-03 00:55:06'),
(6, 1, 6, 5, '2016-12-03 00:55:19'),
(7, 1, 6, 5, '2016-12-03 00:56:22'),
(8, 1, 6, 5, '2016-12-03 00:56:55'),
(9, 1, 6, 5, '2016-12-03 00:57:02'),
(10, 1, 6, 5, '2016-12-03 00:57:12'),
(11, 1, 7, 5, '2016-12-03 01:08:35'),
(12, 1, 43, 50, '2016-12-23 15:01:28'),
(13, 1, 43, 5, '2016-12-23 15:06:35'),
(14, 1, 43, 55, '2016-12-23 15:15:52'),
(15, 1, 43, 60, '2016-12-23 15:18:35'),
(16, 1, 43, 45465, '2016-12-23 15:18:41'),
(17, 1, 44, 5454, '2016-12-23 15:56:06'),
(19, 1, 44, 5555, '2016-12-23 16:02:14'),
(20, 1, 43, 545, '2016-12-23 16:03:31'),
(22, 2, 44, 6000, '2016-12-23 16:17:44'),
(23, 2, 43, 600000, '2016-12-23 16:18:10'),
(26, 1, 43, 50, '2016-12-23 18:08:30'),
(27, 1, 43, 50, '2016-12-23 18:08:59'),
(29, 1, 43, 700000, '2016-12-23 18:10:11'),
(30, 1, 43, 4, '2016-12-23 18:14:29'),
(31, 1, 45, 8, '2016-12-23 18:14:36'),
(32, 1, 45, 9, '2016-12-23 18:15:47'),
(33, 3, 46, 101, '2016-12-23 22:33:50'),
(34, 1, 59, 64, '2016-12-24 13:06:07'),
(35, 1, 59, 65, '2016-12-24 13:08:59'),
(36, 1, 59, 66, '2016-12-24 13:24:56'),
(37, 1, 59, 67, '2016-12-24 13:25:02');

-- --------------------------------------------------------

--
-- 資料表結構 `mycard`
--

CREATE TABLE `mycard` (
  `MID` int(10) NOT NULL,
  `MCID` int(10) NOT NULL,
  `account` int(10) NOT NULL,
  `MUID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `mycard`
--

INSERT INTO `mycard` (`MID`, `MCID`, `account`, `MUID`) VALUES
(1, 1, 1715, 1),
(2, 2, 16, 1),
(3, 3, 2457, 1),
(4, 8, 18, 1),
(5, 4, 21, 1),
(6, 5, 21, 1),
(7, 6, 21, 1),
(8, 7, 24, 1),
(16, 1, 290, 3);

-- --------------------------------------------------------

--
-- 資料表結構 `sale`
--

CREATE TABLE `sale` (
  `SID` int(11) NOT NULL,
  `timer` datetime NOT NULL,
  `SUID` int(10) NOT NULL,
  `SCID` int(10) NOT NULL,
  `saleAccount` int(10) NOT NULL,
  `salePrice` int(10) NOT NULL,
  `state` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `sale`
--

INSERT INTO `sale` (`SID`, `timer`, `SUID`, `SCID`, `saleAccount`, `salePrice`, `state`) VALUES
(43, '2016-12-23 18:40:03', 1, 1, 3, 3, 1),
(44, '2016-12-23 16:56:01', 1, 2, 5, 5, 0),
(45, '2016-12-23 18:16:26', 1, 3, 7, 7, 1),
(46, '2016-12-23 22:34:00', 1, 1, 100, 100, 1),
(51, '2016-12-23 23:53:29', 2, 7, 3, 58, 0),
(52, '2016-12-23 23:53:40', 2, 5, 3, 74, 0),
(53, '2016-12-23 23:52:50', 2, 3, 3, 88, 0),
(54, '2016-12-23 23:54:01', 2, 1, 3, 21, 0),
(55, '2016-12-23 23:54:08', 2, 3, 3, 73, 0),
(56, '2016-12-23 23:53:17', 2, 6, 3, 65, 0),
(57, '2016-12-24 01:48:32', 3, 1, 10, 10, 0),
(58, '2016-12-24 02:14:56', 2, 5, 3, 46, 0),
(59, '2016-12-24 13:47:08', 2, 7, 3, 63, 1),
(60, '2016-12-24 14:38:57', 2, 8, 3, 46, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `UID` int(10) NOT NULL,
  `loginID` text NOT NULL,
  `password` text NOT NULL,
  `money` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `user`
--

INSERT INTO `user` (`UID`, `loginID`, `password`, `money`) VALUES
(1, 'test', '123', 4146),
(2, 'boss', '123', 1067),
(3, 'jc', '123', 2000);

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`CID`);

--
-- 資料表索引 `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`HID`);

--
-- 資料表索引 `mycard`
--
ALTER TABLE `mycard`
  ADD PRIMARY KEY (`MID`);

--
-- 資料表索引 `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`SID`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `card`
--
ALTER TABLE `card`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- 使用資料表 AUTO_INCREMENT `history`
--
ALTER TABLE `history`
  MODIFY `HID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- 使用資料表 AUTO_INCREMENT `mycard`
--
ALTER TABLE `mycard`
  MODIFY `MID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- 使用資料表 AUTO_INCREMENT `sale`
--
ALTER TABLE `sale`
  MODIFY `SID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- 使用資料表 AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `UID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
