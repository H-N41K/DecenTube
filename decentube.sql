-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2020 at 09:15 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `decentube`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, '🎬 Film & Animation'),
(2, '🚙 Autos & Vehicles'),
(3, '🎶 Music'),
(4, '🐈 Pets & Animals'),
(5, '🏏 Sports'),
(6, '🎟️ Travel & Events'),
(7, '🕹️ Gaming'),
(8, '🧑‍🤝‍🧑 People & Blogs'),
(9, '🤣 Comedy'),
(10, '🌠 Entertainment'),
(11, '📰 News & Politics'),
(12, '👜 Howto & Style'),
(13, '📚 Education'),
(14, '⚙️ Science & Technology'),
(15, '☮️ Nonprofits & Activism');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `postedBy` varchar(50) NOT NULL,
  `videoId` int(11) NOT NULL,
  `responseTo` int(11) NOT NULL,
  `body` text CHARACTER SET utf8mb4 NOT NULL,
  `datePosted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `postedBy`, `videoId`, `responseTo`, `body`, `datePosted`) VALUES
(1, 'beta-tester', 2, 0, 'Hi.. This is  a test comment!! Happy Streaming !😁🙌', '2019-12-16 14:42:18'),
(2, 'H3M3N', 2, 1, 'Awesome video! Nicely explained! 👍👍', '2019-12-16 14:44:21'),
(3, 'brave-tester', 1, 0, '🔈Its Definitely a Banger!!!🤩🤩', '2019-12-16 19:17:46'),
(4, 'mobile-tester', 1, 0, 'woah😍😍😍😍', '2019-12-16 19:56:25'),
(5, 'mobile-tester', 5, 0, 'Testing the comments section😍🤩😅ko', '2019-12-16 21:33:09'),
(6, 'mobile-tester', 10, 0, 'First Comment!! 💜💜💙💙💚💙💙', '2019-12-16 23:48:21'),
(7, 'shubham', 21, 0, 'nice 😗', '2020-02-14 11:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `dislikes`
--

CREATE TABLE `dislikes` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `commentid` int(11) NOT NULL,
  `videoid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dislikes`
--

INSERT INTO `dislikes` (`id`, `username`, `commentid`, `videoid`) VALUES
(1, 'beta-tester', 0, 1),
(5, 'mobile-tester', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `commentid` int(11) NOT NULL,
  `videoid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `commentid`, `videoid`) VALUES
(1, 'H3M3N', 0, 1),
(2, 'brave-tester', 0, 1),
(3, 'mobile-tester', 0, 1),
(5, 'mobile-tester', 3, 0),
(6, 'mobile-tester', 0, 10),
(7, 'H3M3N', 0, 10),
(8, 'H3M3N', 2, 0),
(9, 'H3M3N', 1, 0),
(12, 'H3M3N', 4, 0),
(13, 'H3M3N', 3, 0),
(14, 'shubham', 0, 14),
(15, 'shubham', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `previews`
--

CREATE TABLE `previews` (
  `videoId` int(11) NOT NULL,
  `filePath` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `previews`
--

INSERT INTO `previews` (`videoId`, `filePath`) VALUES
(1, 'uploads/videos/previews/1-5df73d36baf8e.gif'),
(2, 'uploads/videos/previews/2-5df749a092ad0.gif'),
(3, 'uploads/videos/previews/3-5df7983774c0a.gif'),
(4, 'uploads/videos/previews/4-5df798edec944.gif'),
(5, 'uploads/videos/previews/5-5df79c364b224.gif'),
(6, 'uploads/videos/previews/6-5df79f7c5e606.gif'),
(7, 'uploads/videos/previews/7-5df7a0ee76847.gif'),
(8, 'uploads/videos/previews/8-5df7a6702a26c.gif'),
(9, 'uploads/videos/previews/9-5df7abbf1b9c5.gif'),
(10, 'uploads/videos/previews/10-5df7c8ec4e645.gif'),
(11, 'uploads/videos/previews/11-5df8723f43194.gif'),
(12, 'uploads/videos/previews/12-5df883ce69a45.gif'),
(13, 'uploads/videos/previews/13-5df88cb278f0d.gif'),
(14, 'uploads/videos/previews/14-5dfb06413be6d.gif'),
(15, 'uploads/videos/previews/15-5dff080331e2f.gif'),
(16, 'uploads/videos/previews/16-5dff08d4e0a5c.gif'),
(17, 'uploads/videos/previews/17-5e03718e73396.gif'),
(18, 'uploads/videos/previews/18-5e2d6d373ad9e.gif'),
(20, 'uploads/videos/previews/20-5e442547edbc8.gif'),
(21, 'uploads/videos/previews/21-5e4631b70b09d.gif');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `videoUrl` varchar(512) NOT NULL,
  `reportCategory` varchar(128) NOT NULL,
  `reportComments` varchar(4096) NOT NULL,
  `reportedBy` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `userTo` varchar(50) NOT NULL,
  `userFrom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `userTo`, `userFrom`) VALUES
(2, 'beta-tester', 'brave-tester'),
(3, 'beta-tester', 'mobile-tester'),
(4, 'H3M3N', 'mobile-tester'),
(5, 'H3M3N', 'shubham'),
(6, 'beta-tester', 'H3M3N');

-- --------------------------------------------------------

--
-- Table structure for table `thumbnails`
--

CREATE TABLE `thumbnails` (
  `id` int(11) NOT NULL,
  `videoId` int(11) NOT NULL,
  `filePath` varchar(250) NOT NULL,
  `selected` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thumbnails`
--

INSERT INTO `thumbnails` (`id`, `videoId`, `filePath`, `selected`) VALUES
(1, 1, 'uploads/videos/thumbnails/1-5df73d3a1049e.jpg', 1),
(2, 1, 'uploads/videos/thumbnails/1-5df73d3c481ac.jpg', 0),
(3, 1, 'uploads/videos/thumbnails/1-5df73d411bb5f.jpg', 0),
(4, 2, 'uploads/videos/thumbnails/2-5df749a1cdff1.jpg', 0),
(5, 2, 'uploads/videos/thumbnails/2-5df749a2b2ae8.jpg', 0),
(6, 2, 'uploads/videos/thumbnails/2-5df749a444797.jpg', 1),
(7, 3, 'uploads/videos/thumbnails/3-5df7983d19e07.jpg', 1),
(8, 3, 'uploads/videos/thumbnails/3-5df7983fad095.jpg', 0),
(9, 3, 'uploads/videos/thumbnails/3-5df7984473bc7.jpg', 0),
(10, 4, 'uploads/videos/thumbnails/4-5df798ee72948.jpg', 1),
(11, 4, 'uploads/videos/thumbnails/4-5df798eebf817.jpg', 0),
(12, 4, 'uploads/videos/thumbnails/4-5df798ef2ad08.jpg', 0),
(13, 5, 'uploads/videos/thumbnails/5-5df79c3c46261.jpg', 0),
(14, 5, 'uploads/videos/thumbnails/5-5df79c3f0c7ca.jpg', 1),
(15, 5, 'uploads/videos/thumbnails/5-5df79c4448cd1.jpg', 0),
(16, 6, 'uploads/videos/thumbnails/6-5df79f7e660d6.jpg', 1),
(17, 6, 'uploads/videos/thumbnails/6-5df79f7fe6585.jpg', 0),
(18, 6, 'uploads/videos/thumbnails/6-5df79f82bdbcb.jpg', 0),
(19, 7, 'uploads/videos/thumbnails/7-5df7a0f293dc3.jpg', 1),
(20, 7, 'uploads/videos/thumbnails/7-5df7a0f5d28ab.jpg', 0),
(21, 7, 'uploads/videos/thumbnails/7-5df7a0fc03fa2.jpg', 0),
(22, 8, 'uploads/videos/thumbnails/8-5df7a68450231.jpg', 1),
(23, 8, 'uploads/videos/thumbnails/8-5df7a6954b0fb.jpg', 0),
(24, 8, 'uploads/videos/thumbnails/8-5df7a6b705d67.jpg', 0),
(25, 9, 'uploads/videos/thumbnails/9-5df7abc3d1d31.jpg', 0),
(26, 9, 'uploads/videos/thumbnails/9-5df7abc7b5740.jpg', 0),
(27, 9, 'uploads/videos/thumbnails/9-5df7abcdef648.jpg', 1),
(28, 10, 'uploads/videos/thumbnails/10-5df7c9012bf1a.jpg', 1),
(29, 10, 'uploads/videos/thumbnails/10-5df7c912b9da7.jpg', 0),
(30, 10, 'uploads/videos/thumbnails/10-5df7c9359d45f.jpg', 0),
(31, 11, 'uploads/videos/thumbnails/11-5df8725925ac6.jpg', 1),
(32, 11, 'uploads/videos/thumbnails/11-5df8726fc8fc8.jpg', 0),
(33, 11, 'uploads/videos/thumbnails/11-5df8729b795da.jpg', 0),
(34, 12, 'uploads/videos/thumbnails/12-5df883d95ac0f.jpg', 1),
(35, 12, 'uploads/videos/thumbnails/12-5df883e2bb054.jpg', 0),
(36, 12, 'uploads/videos/thumbnails/12-5df883f6bc488.jpg', 0),
(37, 13, 'uploads/videos/thumbnails/13-5df88cb7cad64.jpg', 0),
(38, 13, 'uploads/videos/thumbnails/13-5df88cbc9935b.jpg', 1),
(39, 13, 'uploads/videos/thumbnails/13-5df88cc54acda.jpg', 0),
(40, 14, 'uploads/videos/thumbnails/14-5dfb064602687.jpg', 0),
(41, 14, 'uploads/videos/thumbnails/14-5dfb064a63110.jpg', 0),
(42, 14, 'uploads/videos/thumbnails/14-5dfb0651e0350.jpg', 1),
(43, 15, 'uploads/videos/thumbnails/15-5dff080512944.jpg', 1),
(44, 15, 'uploads/videos/thumbnails/15-5dff0806dc681.jpg', 0),
(45, 15, 'uploads/videos/thumbnails/15-5dff08095fcc5.jpg', 0),
(46, 16, 'uploads/videos/thumbnails/16-5dff08d7141ea.jpg', 0),
(47, 16, 'uploads/videos/thumbnails/16-5dff08d93ef08.jpg', 0),
(48, 16, 'uploads/videos/thumbnails/16-5dff08dcd3a2c.jpg', 1),
(49, 17, 'uploads/videos/thumbnails/17-5e0371918451a.jpg', 1),
(50, 17, 'uploads/videos/thumbnails/17-5e037193ec4f5.jpg', 0),
(51, 17, 'uploads/videos/thumbnails/17-5e0371988bb0e.jpg', 0),
(52, 18, 'uploads/videos/thumbnails/18-5e2d6d3e9bd4f.jpg', 0),
(53, 18, 'uploads/videos/thumbnails/18-5e2d6d4464fc8.jpg', 1),
(54, 18, 'uploads/videos/thumbnails/18-5e2d6d4e7a2a7.jpg', 0),
(55, 20, 'uploads/videos/thumbnails/20-5e44254d84ecf.jpg', 1),
(56, 20, 'uploads/videos/thumbnails/20-5e442553890dd.jpg', 0),
(57, 20, 'uploads/videos/thumbnails/20-5e44255af36c5.jpg', 0),
(58, 21, 'uploads/videos/thumbnails/21-5e4631bb25c3f.jpg', 0),
(59, 21, 'uploads/videos/thumbnails/21-5e4631beacef4.jpg', 0),
(60, 21, 'uploads/videos/thumbnails/21-5e4631c42aeec.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signUpDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profilePic` mediumtext NOT NULL,
  `ethAddress` varchar(64) NOT NULL,
  `videoIndexCount` int(11) NOT NULL DEFAULT '0',
  `history` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `username`, `email`, `password`, `signUpDate`, `profilePic`, `ethAddress`, `videoIndexCount`, `history`) VALUES
(1, 'Hemen', 'Naik', 'H3M3N', 'H@q.l', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79', '2019-12-16 13:22:00', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAADpElEQVR4Xu2dsU1DQRBE75dAQCGWO6ADJCJCRO6IBujAIickpQNacBM4InBOAqKGt9JoxCPfu9Xs+7N79ue8vdztf1bw73LcBXfPb311OEWT2AQgqv8SAB0gSqAOEJV/6QDOAM4A4Wcwu70zgDNAlEBngKj8zgDLGcAZIPwMZrd3BnAGiBLoDBCV3xnAGcDvAvwyKGlCtoCk+ssWYAtIt4Dn82P0fYD0MShsAPEHYBOALALpD8IEIFt/HcAWkD0F6QA6gENgkgFngPAxKFn8v70FQACiDDoDROXXAeJvxYbrbwvwGOgxMP0QRvd3CHQIjALoEBiV3yHQITD8TqQO8N8d4PP7Cb0P8H7/gSRMD0Eo+YFgegq6fbtBWWwCgPTDwQIQ7oG4gnABARAAhJAtAMmXD9YBdABEoQ6A5MsH6wA6AKJQB0Dy5YN1AB0AUagDIPnywTqADoAo1AGQfPlgHUAHQBTqAEi+fLAOoAMgCrEDtP97ePp9AvoEp/OvfyMoLaAAIAPjd+QIACuADsD0wy+1pgEWAAHovh8g/QQ5A/zzJ0gABAApkHYwZwBUvv5TjAAIgEMgYcAZgKg3cFlyuocKgAAgBdIAOwOg8jkEQvn6BbQFQATaBWzPP94CID/4yxi6f7qH0/wFACooAFBAGk4tmO4vAFRBGC8ATEBbANMvftUrTH8JAFTQFgAFpOG2AKagDsD0swVA/XC4DsAk1AGYfjoA1A+H6wBMQh2A6acDQP1wuA7AJNQBmH46ANQPh+sATEIdgOnX7wD0uvjXrwuU0HCiwMP1FQlf+PcCBADpj4MFAEvYvYAAdNcPZy8AWMLuBQSgu344ewHAEnYvIADd9cPZCwCWsHsBAeiuH85eALCE3QsIQHf9cPYCgCXsXkAAuuuHsxcALGH3AgLQXT+cPQbg5W7/g7NwgVoFNgGord1I4gIwImPvIgLQW7uRzAVgRMbeRQSgt3YjmQvAiIy9iwhAb+1GMheAERl7FxGA3tqNZC4AIzL2LiIAvbUbyVwARmTsXUQAems3krkAjMjYu4gA9NZuJHN8QQS9oYNetUr3pyqm86f7CwAkgBaAAkz3FwABYD8cmSaY7g/rj+8IovnrAIcTrSGKpwUQgOMOFYAKiDZfSwegBUg/QQJwdgYgEKQBpvt7CiDVtwXkf/qVtiBYf2cAWgBqYXR/AXAGQAykAab7OwOg8nsMxD/eTAm2BbDPUXQAHcDPAQgDaQej+/8CEy9wjoPoG1QAAAAASUVORK5CYII=', '0xcb2698186dD2fAcF6Ba99B5235fCDa606a192C80', 7, '9,16,10,1,7,11,14,12,13,2,17,18,5,5,18,12,12,12,12,12,12,12,12,12,1'),
(2, 'Beta1', 'Tester', 'beta-tester', 'b@q.l', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79', '2019-12-16 13:25:26', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAADzklEQVR4Xu3dsXFUQRCE4b0USEEZYIGJg6EqMiADIiACPHk4CkQGDiZYGJRCkE0Koojho6rr4Jc/t0+9vT098+b2Ljf3d88H/j7cvoXocz4/fKH4aw9e43eJAFsKRYAUgBioCpoCEPwenAKkAMSiFIDg2wenACkAsTAFIPj2wSlACkAsTAEIvn1wCpACEAtTAIJvH5wCpADEwhSA4NsHpwApALEwBSD49sFzBbh7eqR5AIXwx6+P9BHfvr+heA1+/eorfcTLF58oXoMvEcAgjACG30kBUgCiUCmA4DulAMPvlAIQwFJAKYAoVAog+EoBBt8pBSiApYBSAHGoFEDwlQIMvlKA4lcjqFZw7wL4FMEH1AgC8P6E1ghCAKsCqgKIQlUBBN+5vP/5juYBdAN0IEIVxOA7R9/n60SPpqAIgAyIADiRkwLYDSkpAI6UoQCUAvIA5uLzAHjJVCbQhlIzgZgDMoGZQKJQKaAUQASqCqgKIALlAQi+OoGnMrAykM5QncA6gUSg+gD1AYhAGlwfoD4AcWjeB9Cvh68lWE0o7d5fGAnT9VWBeCYwAlgOjgCIQApgZWgKgATUViwuz/MIEQB3IAKMe/GlgFIAnmELTwFSAGMQRlcGYiMK8eevhun6ESACEIeqAgg+/3IoLl8ZWBVQFaCHiOKrAqoCiEAanAnMBBKHMoEE3z9gAvV+AJUgxP+/D9fX8TwWHgG2HIwAW/znq0eA+RZsHyACbPGfrx4B5luwfYAIsMV/vnoEmG/B9gEiwBb/+eoRYL4F2weIAFv856tHgPkWbB8gAmzxn68eAeZbsH2ACLDFf756BJhvwfYBmADr+wH0dbJesKDbt77jSPGbTwTpPxABrnwqOALYr6YpfikA5oBSAI6FK4NLAaUAPMMWngKkAMQgLeNUQfMAtH3npAApAFEoBcBfz84EZgLpBGpwKaAUQBwqBZQCiEBVAQ/2gwuE/qkKOGsJywRmAvUQU/zVm8Cb+7tnQWANwLVfEqU5XBXwEgGE/n5DSATAMjIFMBOcApgA8FWxKUAKQBTMA1z5NXEpQAqQAggCmcBMoPCHY/Wu4FJAKYBImAnMBBKB6gMQfHUC50ORmcBMIJ5hC88E3r4lBHWeIAVIAYiAGnz1CqD3A2gZsp4nUAKs63jFj78ZFAFsJGuNXwRACUgBcCpXJUxNJO4//3BjCjCuIiLA0yMNha4ZnAJYGZ4HQAnIA+QBiEJrBU0BaPtOJnDN4DxAHgDPsIXnAfIAxKC1guYBaPvyAGfN4DxAHgDPsIXnAfIAxKC1gv4GS3T6fT9/kf8AAAAASUVORK5CYII=', '0x1ded052DdCBAEb2B95d166B47B0caAaadAd03A16', 7, '1,11,7,16,9,2,17,13,14,18,20,1,1,1,1,1,1,1,1,1'),
(3, 'Brave', 'Tester', 'brave-tester', 'ba@q.l', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79', '2019-12-16 18:54:52', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAD0ElEQVR4Xu3dsXHWQBCGYakFIhdATA0UQEwK1EFMHUCMc6fUQOQZuwICWoChhF/PzewcvMTs7enbV9+u5ZN8Pj59+33Avxcfv0L0cfz69I7idw+e1u8MgFmEAiAHIALVQXMAkt+Dc4AcgCjKAUi++eAcIAcgCnMAkm8+OAfIAYjCHIDkmw/OAXIAojAHIPnmg3OAHIAozAFIvvngHCAHIApzAJJvPnjcAe4e7uk8gEr4/eVoet0+x79+PnkNWeAMAJHPYwMgB3CKYIUcAMRbEZoD5AArOLq8Rg5wWbo1gTlADrCGpIur5AAXhVsVlgPkAKtYurRODnBJtnVBOUAOsI6mCyvlABdEWxmSA+QAK3m6ea0c4GbJ1gbkADnAWqJuXC0HuFGw1f993AGmXw9XQfVEjObXAx2aX69//O3gaQE0fwDgF0K0AHoHaP4ACABliOL1BqgFkPzHkQPkAIiQhecAw+8V5AA5gN3CGJ0D5ACEUEMgydcQuP0UjPXf/vpzACSgIbAhEBGy8IbAhkAiqBZA8jUEbj8EYf23v352ABWw+FkFAmBW//HsATBegtkNBMCs/uPZA2C8BLMbCIBZ/cezB8B4CWY3EACz+o9nD4DxEsxuIABm9R/PHgDjJZjdQADM6j+ePQDGSzC7gQCY1X88ewCMl2B2AwEwq/949nEA9AMJPz5/GRXx1Yf3lH/67yUEAJXvOAIABcwBZv9iSg6AAOcAKGAOkAMQQg2BJN9RCzD9GgJRv6MWUAsghmoBJF8twOTrOYDqVwsY/lZyQyAi3HMAFLAhsCGQEGoIJPkaAk2+hkDVryFwegj8+fYNNSH9Rg0T9J8voB+pOgNgb4ICYO/68e4DgCXce4EA2Lt+vPsAYAn3XiAA9q4f7z4AWMK9FwiAvevHuw8AlnDvBQJg7/rx7gOAJdx7gQDYu368+wBgCfdeIAD2rh/vPgBYwr0XYAAen77ReQA906fvx2t+Lf/0/jU/nwrWAugFaP4AyAGIgWmANX8OQOU/Di2AOpjmD4AAaAgUBvQOzAHwWLQKKMX/GxsAzydpOC0gbT4ADn6xIwBmb6CGQLSAaYA1fwAEQD8FCAN6B+oQq/lzAKl+Q2BDoN6BOUDPAciDFMBaAMn/DzwIunu4p/MASiDqz88hNP/u138GgCEQANjDTX4fQjV/AASAMkTx+lNELYDk9yEQ0/MMFABYgVpALQARsvBaAJ5HMPlrAXwiRgugd4DmrwXUApQhitcboCGQ5K8F1AI2d8AcIAfol0HCQEPg5hYoxV/xXoDmbwjsOQAx9AegAvWuWUzrcQAAAABJRU5ErkJggg==', '0xA23f5cE981B96eA183FAb1de2fFeB4c5C7Fd42F6', 0, ''),
(4, 'Mobile', 'Tester', 'mobile-tester', 'm@d.ll', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79', '2019-12-16 19:54:10', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAADpElEQVR4Xu3dMW4TURhF4fEKkFhEhOi9gFRIVEjshA3QpmIbaamQWAM9QvS0bCEoa/giXUY+6W+efd+Z8z87zvjycH18OoY/339/odVf/3xPeQ3/ffuNfsW7u0+U1/AlAKzCALD+jgyQAQihRgDVdzQCrL+jEYAFNgIaAYRQI4DqawRYfUcjQAtsBDQCiKFGANXXCLD6GgHaX28E9VZwfwvgqwh+QW8EQXnP0d4IwgJ7FdCrAEKoVwFU33H5+Ofz9PMA1w9v6Bn8+PqL8ho+++MPACQgAG68wAAIAGpgPcIaAbR9x5EBbrzAAAgAaqAR0MtAAkjDnQGwwUbAjRcYAAFADXQG6AxAAGm4MwA22Ai48QIDIACogc4AnQEIIA1f7l9d6fMA+v/t+okgLWCdX/cXAGMCAgDvEDLeP14+AAKAINIR2gig+j2cATIAUZQBqL59OANkAKIwA1B9+3AGyABEYQag+vbhDJABiMIMQPXtwxkgAxCFGYDq24czQAYgCucGoEf/AmG9gvQh6Abo+prnPwbpA9B8AFiDAWD98W3ucHmOBwBW2AjAAjXeCLAGM4D11wjA/jieAazCDGD9ZQDsj+MZwCrMANZfBsD+OJ4BrMIMYP1lAOyP4xnAKswA1l8GwP44ngGswgxg/WUAvQL1jym6Pu4/A6CPX/tjA6yfgK4fACe/Q0gA2LeuZQBUgCpYAdb1AyAAzn2TKL2CcP87BOoGqMJ0/QDoEEgMrAHW9TsD0PYfjQBVsBKs6+P+B4BuQADYdwdrf40AVIBuwPoCCoAA6H0AYSAD3G1nmCpUNv85GwABQAwpwAogf2eQfmWKPgFq/z8IKwD6jSMBMIYgALpFDCGYAai+fTgDZACiMANQfftwBsgARGEGoPr24QyQAYjCDED17cMZIAMQhRmA6tuHM0AGIAozANW3D2eADEAUZgCqbx+eG+D+5P8Yst9CewQKgH6e4vQfCrX69+kA6AxAFGYAqm8fzgAZgCjMAFTfPpwBMgBRmAGovn04A2QAojADUH37cAbIAERhBqD69uEMkAGIwgxA9e3DGSADEIUZgOrbh+cGeLg+PkkNSqCs/ZzVAnX9sz//SwAYAgEwnuEZwO7RlAFMAHyTKFyeR2AA4A40AhoBiJDFdQRmAOu/EXB2BeL+B0AA2Ld2KYCNALxTqW7A2S+AzgBIQAD0KgARsngjoBFABDUCqD6/XTwu3zuBqkDdgM4AnQGUIcrrBfAPMfgE3YYSaKkAAAAASUVORK5CYII=', '0x1D54e476bdbcE8Af860f465fbBE5a8EAfEa0F2F4', 0, ',17,11,11'),
(5, 'Brave', 'Pc user', 'brave-pc', 'b@qw.l', '3627909a29c31381a071ec27f7c9ca97726182aed29a7ddd2e54353322cfb30abb9e3a6df2ac2c20fe23436311d678564d0c8d305930575f60e2d3d048184d79', '2020-01-26 14:43:59', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAADn0lEQVR4Xu3dsVEdMRSFYb0S6IGYHpghpgESQiIHboAOCIgI7RaIX+YOHLsXXMSvmTsaPvKzq3d09r9Xy672cv/052uFv+fbx6Be6+7jR9KfLv778p5+wq9/n0l/EYDkXxYLAAKkECFAsm9ejAAIkFKIAMm+eTECIEBKIQIk++bFCIAAKYUIkOybFyMAAqQUIkCyb16MAAiQUogAyb55MQIgQEohAiT75sXHE+Dtek0u/nx4SPrTxdP+5ecBpn+AALQLSACGEzR9AQmAALRnAqcTPDx/+fTT/iFAnsJ2AAGwCkgJqqsoBEj2dzECIEBKEQIk++bFCIAAKYUIkOybFyMAAqQUIkCyb16MAAiQUogAyb558TgBfr/epP0B6hMp81Nw9gjq/gwXARAABDg4Awhw8OTtGLoA7HDx4GMIwMGTt2PoArDDxYOPIQAHT96OoQvADhcPPoYAHDx5O4YuADtcPPgYAnDw5O0YugDscPHgYwjAwZO3Y+gCsMPFg48hAAdP3o6h5wDU7eLrj6g/oJ5/Wj/9PEV+M6gaKADtgw/VfwGoDkY9AsRPzkT/x+UCIACjIVQCRu1fCwEQYDSCCDBqPwIsy0DLwOFrcPb0egA9wGgC9QCj9usB9ADx2781vwhQHYx6PYAeIEaoyRGg+ZfV354AdYOE+sGFOoN38YsndYePOv5xAghA2+9fAF7eqwdJjwDJvrUQAAFShPQAyb6lB2j+LSUgGqgEKAEpQkpAsk8JaPYtJaAaqAQoASlDSkCyTwlo9ikB1T83goZ3S3cfIEbYfYBooCZQE5gipAlM9q3jt4uvBGn2rTX9//z6XoUAxAQIwPBTrQjwmCKMAMk+JWD89WYEQIB4DTe5HkAP0BIU1VYB12u0sMkRAAFagqIaARAgRcgyMNlnGWgZOPzvXCVACUgMUwKSfUqAEqAEzG5z5lbw8K3gSNAsn95goTZh2YB4gNwDxPNnuQA0CwWg+Xf8LmcCIAA3X9GDUbkS0OxHgOafEhD9y3IEaBYiQPMPAaJ/WY4AzUIEaP4hQPQvyxGgWYgAzT8EiP5lOQI0CxGg+YcA0b8sR4BmIQI0/xCgbpES/R9/P3/6gZS6QUYmgADMvpkkAMPP5CFA/GSKEtAcQAAESAnSAyT7+hdP4ukXAiBAyhACJPsQIO+XH/13HyB+NQ0BYgItAy0DY4SaXBOoCUwJUgKSfZpATeDwBhVKgBKQGKYEJPvOLwH/AXAZlC41vJ9OAAAAAElFTkSuQmCC', '0x780b8D427D09645f9cA000F5531bB9FbFF606814', 0, '2,1,14,5,10,12,7,7,7,1,7'),
(6, 'Shubham', 'Vaity', 'shubham', 'sv@gmail.com', 'a97461efce828b57cd52801bccd5a0db0cf139e03c2539cec250739a15808133ba13809c84b935e45931acab19a2d6e586d7c213751ec0a88ee3a18b4d2fb059', '2020-02-14 10:56:39', 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAADk0lEQVR4Xu3dwW1VWRCE4WdNBmSAJoZZISGQWEwq7CYbQiAFFkgEQAyjyYAMkEeO4VuUWv69L58+1b/r9LXOu+/p3fP75wf8/PXxM6iTqgM/f3yhX/EUAOTfXBwA8xZsCwiArf/z1QNg3oJtAQGw9X++egDMW7AtIAC2/s9XD4B5C7YFBMDW//nqATBvwbaAANj6P189AOYt2BYQAFv/56sHwLwF2wICYOv/fHUG4J8PX+k+wK/v/5EJ//7xjfTXxX/+/pu28ObTW9I/BQD5x+IAKAEIohKA7NuLS4ASgCgsAci+vbgEKAGIwhKA7NuLS4ASgCgsAci+vbgEKAGIwhKA7NuLS4ASgCgsAci+vbgEKAGIwhKA7NuLzyfA2kK9EKH1X38/At8HUANVHwDmYACYf48SAA1UeQlgDpYA5l8JgP6xvAQwC0sA868EQP9YXgKYhSWA+VcCoH8sLwHMwhLA/CsB0D+WlwBmYQlg/pUA6B/LSwCzsAQw/0oA9I/lJYBZyK+Lt+UfD70QsX6/wPX6AwAJDoBXbmAABAA5sD7COgKoffdnmAAIAPvWMPSvp4Dx5yJKACS4IfCVGxgAAUAO9BSAb8pcG1gCEP/3H6MCIADIgXWC9RRA7bufYAEQAP0jSBg4PwPo6+L1Qsb1T9cKPC/atX98JWy9AW3AWr/2LwDGBATAx8/jFmyXD4AAIAJ1huoIIPtdXAKUAERRCUD27cUlQAlAFJYAZN9eXAKUAERhCUD27cUlQAlAFJYAZN9eXAKUAERhCUD27cXzBHj3bBdClEBtgRqo61/fP18Ju25AAJQAxMD1P4ASgNr/mL8kSo/AAAiAhkBhoCNg/ByvESjNf9EGQAAoQ6TXP4BmALK/BDgfgdj/8/svAZCAZoBmAETI5M0AP76Yg6guAUoARMjkJUAJQAQ1BJJ9PQbOH4Owf+flr/4ION9B3EAAoIHX5QFwvYNYfwCggdflAXC9g1h/AKCB1+UBcL2DWH8AoIHX5QFwvYNYfwCggdflAXC9g1h/AKCB1+UBcL2DWH8AoIHX5QFwvYNYPwOw/r4A3P/8PoI2YL3/+buC1wbo+gHQnTxliPR6K7kEIPv9K19weT4CAwA70BHQEYAImbwjoA+mEEEdAWRfMwB/7x36z0OQrt8M0AygDJG+GaAZgABqBiD7mgGaAY4fgSVACfD1WTy4PgXL3l+01/dfAiAB1wH4H7JBo+7B881xAAAAAElFTkSuQmCC', '0x4C99d357C374cf41dEc67f6F08bd1bA9c96eD251', 1, '14,21,21,21');

-- --------------------------------------------------------

--
-- Table structure for table `videoprogress`
--

CREATE TABLE `videoprogress` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `videoId` int(11) NOT NULL,
  `progress` int(11) NOT NULL,
  `finished` int(11) NOT NULL,
  `dateModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `videoprogress`
--

INSERT INTO `videoprogress` (`id`, `username`, `videoId`, `progress`, `finished`, `dateModified`) VALUES
(1, 'beta-tester', 1, 24, 1, '2020-03-08 11:50:17'),
(2, 'H3M3N', 1, 9, 1, '2020-03-08 11:42:22'),
(3, 'beta-tester', 2, 0, 1, '2020-02-12 20:43:28'),
(4, 'H3M3N', 2, 0, 1, '2020-02-12 16:37:41'),
(5, 'brave-tester', 1, 27, 1, '2019-12-16 19:31:25'),
(6, 'brave-tester', 2, 3, 1, '2019-12-16 19:22:49'),
(7, 'mobile-tester', 1, 192, 0, '2019-12-16 21:34:10'),
(8, 'mobile-tester', 2, 0, 1, '2019-12-22 12:30:59'),
(9, 'H3M3N', 5, 0, 1, '2020-02-04 15:29:23'),
(10, 'mobile-tester', 5, 0, 1, '2019-12-16 21:31:44'),
(11, 'H3M3N', 7, 90, 1, '2020-02-04 15:30:23'),
(12, 'mobile-tester', 7, 0, 1, '2019-12-22 12:34:14'),
(13, 'H3M3N', 9, 0, 1, '2020-02-04 14:12:37'),
(14, 'mobile-tester', 9, 27, 0, '2019-12-16 23:00:17'),
(15, 'mobile-tester', 10, 90, 0, '2019-12-16 23:49:45'),
(16, 'H3M3N', 10, 311, 1, '2020-02-04 15:28:22'),
(17, 'beta-tester', 11, 265, 0, '2019-12-17 13:00:29'),
(18, 'beta-tester', 5, 1, 1, '2019-12-17 13:43:54'),
(19, 'beta-tester', 12, 183, 0, '2019-12-17 13:41:54'),
(20, 'beta-tester', 13, 0, 1, '2019-12-17 13:41:08'),
(21, 'H3M3N', 11, 126, 1, '2020-02-08 21:37:40'),
(22, 'H3M3N', 12, 0, 1, '2020-03-08 11:37:31'),
(23, 'H3M3N', 13, 0, 1, '2020-02-09 00:13:38'),
(24, 'H3M3N', 14, 263, 1, '2020-02-12 16:35:16'),
(25, 'H3M3N', 16, 167, 0, '2020-02-04 14:28:27'),
(26, 'mobile-tester', 11, 153, 0, '2019-12-22 12:37:45'),
(27, 'mobile-tester', 14, 294, 0, '2019-12-22 12:57:05'),
(28, 'mobile-tester', 13, 91, 0, '2019-12-22 13:09:04'),
(29, 'beta-tester', 14, 82, 1, '2020-02-22 12:00:03'),
(30, 'beta-tester', 9, 0, 0, '0000-00-00 00:00:00'),
(31, 'H3M3N', 17, 129, 1, '2020-02-12 16:38:38'),
(32, 'beta-tester', 7, 62, 0, '2019-12-26 14:38:55'),
(33, 'brave-tester', 11, 0, 0, '0000-00-00 00:00:00'),
(34, 'brave-tester', 7, 0, 0, '0000-00-00 00:00:00'),
(35, 'brave-tester', 9, 0, 0, '0000-00-00 00:00:00'),
(36, 'brave-tester', 17, 0, 0, '0000-00-00 00:00:00'),
(37, 'brave-tester', 10, 0, 0, '0000-00-00 00:00:00'),
(38, 'brave-pc', 1, 0, 1, '2020-01-26 15:17:40'),
(39, 'brave-pc', 2, 24, 1, '2020-01-26 14:57:37'),
(40, 'mobile-tester', 17, 0, 0, '0000-00-00 00:00:00'),
(41, 'brave-pc', 14, 87, 0, '2020-01-26 15:21:52'),
(42, 'brave-pc', 5, 0, 1, '2020-01-26 15:22:14'),
(43, 'brave-pc', 7, 0, 1, '2020-01-26 15:53:44'),
(44, 'brave-pc', 10, 0, 0, '0000-00-00 00:00:00'),
(45, 'brave-pc', 12, 202, 0, '2020-01-26 15:25:15'),
(46, 'beta-tester', 18, 10, 1, '2020-02-22 12:05:10'),
(47, 'H3M3N', 18, 167, 1, '2020-02-22 11:23:13'),
(48, 'ShubhamVaity', 9, 225, 0, '2020-02-09 00:37:28'),
(49, 'beta-tester', 16, 150, 0, '2020-02-12 20:42:25'),
(50, 'beta-tester', 20, 0, 1, '2020-02-12 22:34:46'),
(51, 'beta-tester', 17, 123, 0, '2020-02-22 10:59:09'),
(52, 'shubham', 14, 74, 0, '2020-02-14 11:01:38'),
(53, 'shubham', 21, 95, 0, '2020-02-14 11:11:06');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `uploadedBy` varchar(100) NOT NULL,
  `uploaderEthAddress` varchar(255) NOT NULL,
  `videoIndex` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `description` varchar(1024) NOT NULL,
  `privacy` int(11) NOT NULL,
  `filePath` varchar(512) NOT NULL,
  `category` int(11) NOT NULL,
  `uploadDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` int(11) NOT NULL,
  `duration` varchar(10) NOT NULL,
  `transactionStatus` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `uploadedBy`, `uploaderEthAddress`, `videoIndex`, `title`, `description`, `privacy`, `filePath`, `category`, `uploadDate`, `views`, `duration`, `transactionStatus`) VALUES
(1, 'beta-tester', '0x1ded052DdCBAEb2B95d166B47B0caAaadAd03A16', 0, 'Martin Garrix, Matisse & Sadko feat. Michel Zitron - Hold On (Official Video)', 'Martijn wrote the lyrics and recorded the vocals for Hold On the same day as <br>he premiered it at his THE ETHER show in Amsterdam RAI 2019 during Amsterdam Dance Event! <br>Let me know if you like it and an early happy New Year to you! ', 1, 'uploads/videos/5df73c5a6263b.mp4', 3, '2019-12-16 13:42:10', 302, '03:35', 1),
(2, 'beta-tester', '0x1ded052DdCBAEb2B95d166B47B0caAaadAd03A16', 1, 'CryptoDoggies Games Tutorial', 'NODE JD JAVACRIPT', 1, 'uploads/videos/5df7499226420.mp4', 14, '2019-12-16 14:38:34', 118, '00:58', 1),
(3, 'mobile-tester', '', 0, 'Walker at Sunburn Arena', 'Sunburn Arena Mumbai', 1, 'uploads/videos/5df797c845dae.mp4', 3, '2019-12-16 20:12:16', 0, '00:18', 0),
(4, 'mobile-tester', '', 0, 'Timelapse Landing', 'Hahsnsnssn', 1, 'uploads/videos/5df798e99ed3d.mp4', 2, '2019-12-16 20:17:05', 0, '00:15', 0),
(5, 'H3M3N', '0xcb2698186dD2fAcF6Ba99B5235fCDa606a192C80', 0, 'Walker Aviation Tour', 'Sunburn Arena Mumbai', 0, 'uploads/videos/5df79bb0976f4.mp4', 6, '2019-12-16 20:28:56', 104, '00:18', 1),
(7, 'H3M3N', '0xcb2698186dD2fAcF6Ba99B5235fCDa606a192C80', 1, 'Build an ICO  Tutorial', 'Leo Trieu', 1, 'uploads/videos/5df7a09e55361.mp4', 13, '2019-12-16 20:49:58', 105, '03:32', 1),
(8, 'H3M3N', '', 0, 'wEth To ETh DApp', 'JOHN QUARNTSTROM', 1, 'uploads/videos/5df7a524ad12a.mp4', 7, '2019-12-16 21:09:16', 0, '23:02', 0),
(9, 'H3M3N', '0xcb2698186dD2fAcF6Ba99B5235fCDa606a192C80', 2, 'Setup Node.js and Truffle on MacOS', 'CryptoDOgs', 1, 'uploads/videos/5df7ab8080182.mp4', 13, '2019-12-16 21:36:24', 55, '03:47', 1),
(10, 'H3M3N', '0xcb2698186dD2fAcF6Ba99B5235fCDa606a192C80', 3, 'Episode 5 - Converting wEth to ETh', 'Quarnstrom Babu', 1, 'uploads/videos/5df7c7aa449df.mp4', 12, '2019-12-16 23:36:34', 35, '23:02', 1),
(11, 'beta-tester', '0x1ded052DdCBAEb2B95d166B47B0caAaadAd03A16', 2, 'Become a highly paid blockchain developer', '#blockchain #dappuniversity #highlypaid #tutorials', 1, 'uploads/videos/5df86ee687048.mp4', 8, '2019-12-17 11:30:06', 114, '14:13', 1),
(12, 'beta-tester', '0x1ded052DdCBAEb2B95d166B47B0caAaadAd03A16', 3, 'Hardwell - Retrograde (Official Music Video)', 'Hardwell - Retrograde (Official Music Video)\nAdd this track to your playlist ?? https://hwl.dj/RETROGRADE-YT\nListen to my mix album "Revealed Volume 10" ?? \nhttps://hwl.dj/VOL10-YT\n\nLately I’ve been reliving so many happy memories from years gone by and so I thought I’d put a video together of how that sound, you know that ‘Hardwell signature sound’, still makes me feel after all these years! From the studio to the stage, I’ve had some of the best times of my life with the most talented artists and most incredible fans any artist could ever ask for. \n\nIt has always been a challenge for me to do my signature sound justice and describe that sound in words. So I’ll let this video explain how it makes me feel...hope you guys feel it too?!?\n\nMusic is Life #UnitedWeAre\n\nThank you for sharing in these moments with me. \nBig love! Hardwell\n\nFor more info:\nhttp://www.djhardwell.com\nhttp://www.instagram.com/hardwell\nhttp://www.facebook.com/djhardwell\n', 1, 'uploads/videos/5df8818ca8465.mp4', 3, '2019-12-17 12:49:40', 84, '04:11', 1),
(13, 'beta-tester', '0x1ded052DdCBAEb2B95d166B47B0caAaadAd03A16', 4, 'Joker Trailer (Now playing in cinemas)', 'Joker movie blah blh blah ', 1, 'uploads/videos/5df88bdbb968f.mp4', 1, '2019-12-17 13:33:39', 103, '02:24', 1),
(14, 'H3M3N', '0xcb2698186dD2fAcF6Ba99B5235fCDa606a192C80', 4, 'MI vs SRH  |  Match 51  Highlights  | Vivo IPLT20 2019', 'MI defeated SRH in the superover.', 1, 'uploads/videos/5dfb05894c517.mp4', 5, '2019-12-19 10:37:21', 237, '06:02', 1),
(15, 'H3M3N', '', 0, 'Blockchain Ninja', 'Become a highly paid blockchain developer', 1, 'uploads/videos/5dff07be94d12.mp4', 13, '2019-12-22 11:35:50', 0, '01:20', 0),
(16, 'H3M3N', '0xcb2698186dD2fAcF6Ba99B5235fCDa606a192C80', 5, 'Choose the right datastructure', 'custom blockchain', 1, 'uploads/videos/5dff08b756b4e.mp4', 1, '2019-12-22 11:39:59', 34, '02:55', 1),
(17, 'H3M3N', '0xcb2698186dD2fAcF6Ba99B5235fCDa606a192C80', 6, 'OpenCV Guide', 'Course summary and how to become an expert !', 1, 'uploads/videos/5e03716693681.mp4', 9, '2019-12-22 19:55:42', 41, '02:51', 1),
(18, 'beta-tester', '0x1ded052DdCBAEb2B95d166B47B0caAaadAd03A16', 5, 'Fast & Furious Presents: Hobbs & Shaw - Official Trailer', 'Hobbs & Shaw <br>\r\nBlu-ray is out now!! <br>\r\n<a href="https://www.HobbsAndShawMovie.com">https://www.HobbsAndShawMovie.com</a> <br>\r\n<br>\r\nAfter eight films that have amassed almost $5 billion worldwide, the Fast & Furious franchise now features its first stand-alone vehicle as Dwayne Johnson and Jason Statham reprise their roles as Luke Hobbs and Deckard Shaw in <i>Fast & Furious Presents: Hobbs & Shaw</i>. <br> <br>\r\n \r\nEver since hulking lawman Hobbs (Johnson), a loyal agent of America''s Diplomatic Security Service, and lawless outcast Shaw (Statham), a former British military elite operative, first faced off in 2015’s Furious 7, the duo have swapped smack talk and body blows as they’ve tried to take each other down.\r\n', 1, 'uploads/videos/5e2d6c5aaa8e6.mp4', 1, '2020-01-26 16:09:22', 148, '02:56', 1),
(20, 'beta-tester', '0x1ded052DdCBAEb2B95d166B47B0caAaadAd03A16', 6, 'CAMSHIFT', 'What is it & Why it is important', 0, 'uploads/videos/5e4425144076f.mp4', 1, '2020-02-12 21:47:24', 9, '04:04', 1),
(21, 'shubham', '0x4C99d357C374cf41dEc67f6F08bd1bA9c96eD251', 0, 'Angrezi Medium 2', 'movie trailer', 0, 'uploads/videos/5e46316b3e595.mp4', 1, '2020-02-14 11:04:35', 6, '02:55', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dislikes`
--
ALTER TABLE `dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `previews`
--
ALTER TABLE `previews`
  ADD PRIMARY KEY (`videoId`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `thumbnails`
--
ALTER TABLE `thumbnails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videoprogress`
--
ALTER TABLE `videoprogress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `dislikes`
--
ALTER TABLE `dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `thumbnails`
--
ALTER TABLE `thumbnails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `videoprogress`
--
ALTER TABLE `videoprogress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
