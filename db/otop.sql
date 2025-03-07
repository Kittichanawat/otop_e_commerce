-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 07, 2025 at 02:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `otop`
--

-- --------------------------------------------------------

--
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `a_id` int(11) NOT NULL,
  `a_title` varchar(60) NOT NULL,
  `a_detail` varchar(1000) DEFAULT NULL,
  `a_img` varchar(255) DEFAULT NULL,
  `a_link` varchar(255) NOT NULL,
  `a_show` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`a_id`, `a_title`, `a_detail`, `a_img`, `a_link`, `a_show`) VALUES
(6, 'ที่ตั้งอาณาเขต ', ' ที่ตั้งอาณาเขต\r\nสำนักงานเทศบาลนครเชียงราย ตั้งอยู่เลขที่ 59 ถ.อุตรกิจ ต.เวียง อ.เมือง จ.เชียงราย 57000\r\nอาณาเขต\r\nทิศเหนือ ติดต่อกับตำบลบ้านดู่ และตำบลแม่ยาว อำเภอเมือง จังหวัดเชียงราย (หลักเขตที่ 1 - 2)\r\nทิศใต้ ติดต่อกับตำบลสันทรายและตำบลท่าสาย อำเภอเมือง จังหวัดเชียงราย (หลักเขตที่ 9 -14)\r\nทิศตะวันออก ติดต่อกับอำเภอเวียงชัย จังหวัดเชียงราย (หลักเขตที่ 2 - 9)\r\nทิศตะวันตก ติดต่อกับตำบลป่าอ้อดอนชัย และตำบลรอบเวียงอำเภอเมือง จังหวัดเชียงราย (หลักเขตที่ 14 - 20) ', 'about_img/tree.png', '#', 1);

-- --------------------------------------------------------

--
-- Table structure for table `banking`
--

CREATE TABLE `banking` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `acc_name` varchar(255) NOT NULL,
  `bank_number` varchar(20) NOT NULL,
  `bank_img` varchar(255) NOT NULL,
  `bank_show` tinyint(1) NOT NULL DEFAULT 1,
  `order_column` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banking`
--

INSERT INTO `banking` (`id`, `bank_name`, `acc_name`, `bank_number`, `bank_img`, `bank_show`, `order_column`) VALUES
(1, 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '0688818141', 'pay/kasikorn.png', 1, 2),
(2, 'ttb', 'สุเมธ ภวังครัตน์', '012-1234-456 44', 'pay/TTB.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `detail` varchar(1000) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `link` text NOT NULL,
  `pages_show` tinyint(1) NOT NULL DEFAULT 1,
  `order_column` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `title`, `detail`, `img`, `link`, `pages_show`, `order_column`) VALUES
(24, 'dd', 'dd', 'banner_img/Creative 12.12 Big Sale Promotional Banner.png', 'ff', 1, 2),
(22, '1', '1', 'banner_img/Purple Illustrated 4.4 Sale Banner Landscape.png', '1', 1, 3),
(23, '3', '3', 'banner_img/Orange Red Flash Sale 9.9 Promotion Banner.png', '33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `crt_id` int(11) NOT NULL,
  `prd_id` smallint(6) NOT NULL,
  `prd_name` varchar(50) NOT NULL,
  `item_totals` decimal(10,2) NOT NULL,
  `mmb_id` int(11) NOT NULL,
  `pty_id` smallint(6) NOT NULL,
  `crt_amount` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `detail` varchar(1000) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `link` text NOT NULL,
  `pages_show` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `title`, `detail`, `img`, `link`, `pages_show`) VALUES
(13, 'ติดต่อเรา', 'เทศบาลนครเชียงราย\r\n59 ถนนอุตรกิจ ต.เวียง อ.เมือง จ.เชียงราย 57000\r\n0-5371-1333\r\nsaraban-chiangraicity@lgo.mail.go.th\r\n', 'contact_img/map_1.png', 'wdwd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `h_id` int(11) NOT NULL,
  `h_title` varchar(255) NOT NULL,
  `h_detail` varchar(500) NOT NULL,
  `h_img` varchar(255) DEFAULT NULL,
  `h_show` tinyint(1) NOT NULL DEFAULT 1,
  `h_link` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`h_id`, `h_title`, `h_detail`, `h_img`, `h_show`, `h_link`) VALUES
(4, 'ประวัติของจังหวัดเชียงราย', ' เชียงราย เป็นเมืองเก่าแห่งอาณาจักรล้านนาที่มีประวัติความมายาวมากกก เรียกว่านานกว่า 700 ปีเลยทีเดียว ตามหลักฐานทางประวัติศาสตร์บันทึกไว้ว่า เมื่อวันที่ 26 มกราคม พ.ศ. 1805 หลังจากที่พญามังรายได้รวบรวมหัวเมืองทางเหนือ และเสด็จไปรวมพลที่ เมืองลาวกู่ต้า ช้างก็พระองค์ก็ได้พลัดหายไปทางทิศตะวันออก พระองค์จึงเสด็จตามรอยช้างไปจนถึง ดอยจอมทอง ที่ตั้งอยู่ตรงริ่มฝั่ง แม่น้ำกกนัทธี เห็นว่าชัยภูมิเหมาะแก่การสร้างเมือง จึงให้สร้างเวียงโอบล้อมดอยจอมทองไว้ ขนานนามว่า “เวียงเชียงราย”', 'h_img/h1.jpg', 1, 'https://travel.trueid.net/detail/362lqKq7K0YB');

-- --------------------------------------------------------

--
-- Table structure for table `line_member`
--

CREATE TABLE `line_member` (
  `id` int(11) NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `line_member`
--

INSERT INTO `line_member` (`id`, `username`, `email`) VALUES
(6, 'Mystery', 'newphonej7@outlook.co.th');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mmb_id` smallint(6) NOT NULL,
  `mmb_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mmb_surname` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mmb_username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mmb_pwd` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mmb_addr` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mmb_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mmb_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mmb_show` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mmb_id`, `mmb_name`, `mmb_surname`, `mmb_username`, `mmb_pwd`, `mmb_addr`, `mmb_email`, `mmb_phone`, `mmb_show`) VALUES
(111, 'รัชช์ชกฤตย์', 'กิตติโชคธนวัชร์', 'Test001', '$2y$10$aCKPbRlkWgoTO/Bq0c7RsOjvnlsSJku/qWBq7T.NPlqfPObqJ6SUu', '5/362 ต.หัวหิน อ.หัวหิน จ.ประจวบคีรีขันธ์ 77110', 'ratchakit@gmail.com', '08922411789', 1),
(112, 'Test002', 'Test002', 'Test002', '$2y$10$eHHi6N51Nf2zFlOojz3rUe/6mXJdJHPNWcaxPUdhjWEFepvqc4PYO', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', 'Test002@wd', '21100กกกก', 1),
(115, 'wdwd', 'wdwd', 'FFF555d', '$2y$10$Z1owgqJwW9YyCroTDROi3O21jaSprIf2Lcq83lS8LfUPlh5jkPAYy', 'wdwd', 'wdwd@gmail.com', '5489595955995', 1),
(116, 'สุเมธ', 'ภวังครัตน์', 'Sumet123', '$2y$10$x/voF229PwjtOv2zRghkZeiZu/Xg7hPIbxNcOi5.rnvJApKiT.gCq', 'huana', 'Sumet123@gmail.com', '562626262', 1),
(117, 'wdwd', 'wdwd', 'wdwd111', '$2y$10$NG85WpqNVjeGhZKLmk5z7ewWxh69Tf1hqTOM4981lKqmq6thZkzKa', 'wdd', 'wdwd@gmail.com', '1010', 1),
(118, 'ddd', 'ddd', 'ddd123', '$2y$10$nVC2lzPrF.m/4T6Q7hSQGOG/snrWFGHtnfyaF.8EX0eUvPniFSukO', 'wdwd', 'wdwd@gmail.com', '00000000', 1),
(119, NULL, NULL, 'Mystery', NULL, NULL, 'newphonej7@outlook.co.th', NULL, 1),
(120, 'aaaaaaaa1', 'aaaaaaaa1', 'aaaaaaaa1', '$2y$10$yQMkkblSTofjPbmTva4GZONwRiMBEOw/34tZQHdv4mHqiqfRkAL2u', 'aaaaaaaa1', 'aaaaaaaa1@wd', 'aaaaaaaa1', 1),
(121, 'aadDd12', 'aadDd12', 'aadDd12', '$2y$10$CR8GY4SXtJmM3VYZxg3CLeUpUYVj5sG3zNNwDdhZKecBiRcCtNcAG', 'aadDd12', 'aadDd12w@mail', 'aaadDd12wd', 1),
(122, 'AAdd11', 'AAdd11', 'AAdd11', '$2y$10$MgCRjzIkfLWoJ6NDaj6VweJ3KmyHyfpheHgSsNGWPkfzOBF9.Pfzm', 'AAdd11', 'AAdd11@wdw', 'wdwd', 1),
(123, 'aaadwdwdA1', 'aaadwdwdA1', 'aaadwdwdA1', '$2y$10$xXRm4akAja6UPivY69JsTeXMpq64r.AEGKuM7eX7iyOK3rwx2vp3u', 'aaadwdwdA1', 'aaadwdwdA1@wdwd', 'sdwd', 1),
(124, 'Treesumet112', 'Treesumet112', 'Treesumet112', '$2y$10$M/KAjg0Fc/JG5V2dqyBYnOCD82bA67dXNRDVXL/nVoZFFoQ424cKa', 'Treesumet112', 'Treesumet112@gmail.com', '045145151512', 1),
(125, 'Jsdff11', 'Jsdff11', 'Jsdff11', '$2y$10$1LVmZvPvIDRDWzTMAqJ42.XEvv.CL/SnZy8DEvX.J89fIkGZTR.iu', 'Jsdff11', 'Jsdff11@wdw', '5151', 1),
(126, 'awdwdK1', 'awdwdK1', 'awdwdK1', '$2y$10$WrSSNr0.R4ZTbpY1G5VrN.ud2pY2Ru4cYbp0ETBa1wEatv51G6Q0K', 'awdwdK1', 'awdwdK1@wd', '11111', 1);

-- --------------------------------------------------------

--
-- Table structure for table `member_levels`
--

CREATE TABLE `member_levels` (
  `level_id` int(11) NOT NULL,
  `member` tinyint(1) NOT NULL DEFAULT 1,
  `mmb_id` varchar(500) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `superadmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `member_levels`
--

INSERT INTO `member_levels` (`level_id`, `member`, `mmb_id`, `admin`, `superadmin`) VALUES
(10, 1, '111', 1, 1),
(11, 1, '109', 1, 1),
(13, 1, '114', 0, 0),
(14, 1, '115', 1, 1),
(15, 1, '112', 1, 1),
(16, 1, '116', 0, 0),
(17, 1, '117', 0, 0),
(18, 1, '118', 0, 0),
(19, 1, '119', 0, 0),
(20, 1, '120', 0, 0),
(21, 1, '121', 0, 0),
(22, 1, '122', 0, 0),
(23, 1, '123', 0, 0),
(24, 1, '124', 0, 0),
(25, 1, '125', 0, 0),
(26, 1, '126', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `mmb_id` int(11) DEFAULT NULL,
  `status` enum('รอการชำระเงิน','ชำระเงินสำเร็จ','ชำระเงินไม่สำเร็จ','ยกเลิก','รอดำเนินการจัดส่ง','จัดส่งสินค้าแล้ว','รอตรวจสอบการชำระเงิน') DEFAULT 'รอการชำระเงิน',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `pay_method` enum('จ่ายผ่านบัญชีธนาคาร','เก็บเงินปลายทาง') DEFAULT NULL,
  `totalPrice` decimal(10,2) DEFAULT NULL,
  `parcel_id` varchar(60) DEFAULT NULL,
  `parcel_name` varchar(255) NOT NULL,
  `read_status` enum('unread','read','','') NOT NULL DEFAULT 'unread'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `mmb_id`, `status`, `created_at`, `pay_method`, `totalPrice`, `parcel_id`, `parcel_name`, `read_status`) VALUES
(0000000339, 112, 'จัดส่งสินค้าแล้ว', '2024-03-10 21:48:41', 'จ่ายผ่านบัญชีธนาคาร', 120.00, '10000', 'Kerry', 'unread'),
(0000000340, 112, 'จัดส่งสินค้าแล้ว', '2024-03-10 22:41:39', 'จ่ายผ่านบัญชีธนาคาร', 100.00, '101010101001010', 'Flash', 'unread'),
(0000000341, 112, 'จัดส่งสินค้าแล้ว', '2024-03-10 23:22:57', 'จ่ายผ่านบัญชีธนาคาร', 35.00, 'wdwdwd', 'wdwd', 'unread'),
(0000000342, 112, 'จัดส่งสินค้าแล้ว', '2024-03-10 23:29:36', 'จ่ายผ่านบัญชีธนาคาร', 150.00, '111111111', 'wdwdwd', 'unread'),
(0000000343, 112, 'ยกเลิก', '2024-03-21 18:25:18', 'เก็บเงินปลายทาง', 120.00, '', '', 'unread'),
(0000000344, 112, 'รอดำเนินการจัดส่ง', '2024-03-21 18:36:37', 'เก็บเงินปลายทาง', 12805.00, NULL, '', 'unread'),
(0000000345, 125, 'รอการชำระเงิน', '2024-03-22 07:14:24', 'จ่ายผ่านบัญชีธนาคาร', 175.00, NULL, '', 'unread'),
(0000000346, 125, 'รอการชำระเงิน', '2024-03-22 07:15:12', 'จ่ายผ่านบัญชีธนาคาร', 10.00, NULL, '', 'unread'),
(0000000347, 112, 'รอดำเนินการจัดส่ง', '2024-03-22 17:59:26', 'เก็บเงินปลายทาง', 35.00, NULL, '', 'unread'),
(0000000348, 112, 'ยกเลิก', '2024-03-22 18:03:11', 'จ่ายผ่านบัญชีธนาคาร', 120.00, NULL, '', 'unread'),
(0000000349, 112, 'รอดำเนินการจัดส่ง', '2024-05-15 15:19:27', 'เก็บเงินปลายทาง', 100.00, NULL, '', 'unread'),
(0000000350, 112, 'รอการชำระเงิน', '2025-03-07 11:10:26', 'จ่ายผ่านบัญชีธนาคาร', 1170.00, NULL, '', 'unread');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(10) UNSIGNED ZEROFILL DEFAULT NULL,
  `crt_id` int(11) DEFAULT NULL,
  `mmb_id` int(11) DEFAULT NULL,
  `crt_amount` int(11) DEFAULT NULL COMMENT 'ราคารวมของแต่ละสินค้า',
  `prd_id` int(11) DEFAULT NULL,
  `prd_name` varchar(50) NOT NULL,
  `item_totals` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `crt_id`, `mmb_id`, `crt_amount`, `prd_id`, `prd_name`, `item_totals`) VALUES
(389, 0000000339, 570, 112, 1, 184, 'กล้วยกู้โลก', 120.00),
(390, 0000000340, 571, 112, 1, 189, 'หมวกถักสีขาว', 100.00),
(391, 0000000341, 572, 112, 1, 185, 'ขนมแปปไข่เค็ม', 35.00),
(392, 0000000342, 573, 112, 1, 188, 'กระเป๋าสานพลาสติกลายหัวใจ สีม่วง By บงกช', 150.00),
(393, 0000000343, 577, 112, 1, 184, 'กล้วยกู้โลก', 120.00),
(394, 0000000344, 578, 112, 2, 189, 'หมวกถักสีขาว', 200.00),
(395, 0000000344, 579, 112, 3, 185, 'ขนมแปปไข่เค็ม', 105.00),
(396, 0000000344, 580, 112, 1, 190, 'พระแก้วมรกตหยกขาว หน้าตัก 4 นิ้ว', 12500.00),
(397, 0000000345, 581, 125, 5, 185, 'ขนมแปปไข่เค็ม', 175.00),
(398, 0000000346, 582, 125, 1, 196, 'น้ำอ้อยสด สวนภูขีด', 10.00),
(399, 0000000347, 583, 112, 1, 185, 'ขนมแปปไข่เค็ม', 35.00),
(400, 0000000348, 584, 112, 1, 184, 'กล้วยกู้โลก', 120.00),
(401, 0000000349, 586, 112, 1, 189, 'หมวกถักสีขาว', 100.00),
(402, 0000000350, 587, 112, 6, 184, 'กล้วยกู้โลก', 720.00),
(403, 0000000350, 588, 112, 3, 188, 'กระเป๋าสานพลาสติกลายหัวใจ สีม่วง By บงกช', 450.00);

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `title` varchar(60) NOT NULL,
  `detail` varchar(1000) NOT NULL,
  `img` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `pages_show` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`id`, `title`, `detail`, `img`, `link`, `pages_show`) VALUES
(1, 'ติดต่อเราwdwd', 'เทศบาลนครเชียงราย\r\n59 ถนนอุตรกิจ ต.เวียง อ.เมือง จ.เชียงราย 57000\r\n0-5371-1333\r\nsaraban-chiangraicity@lgo.mail.go.th\r\n', 'pages_img/map_1.png', 'wdwd', 1),
(5, 'เกี่ยวกับ เทศบาลนครเชียงราย', ' ที่ตั้งอาณาเขต\r\nสำนักงานเทศบาลนครเชียงราย ตั้งอยู่เลขที่ 59 ถ.อุตรกิจ ต.เวียง อ.เมือง จ.เชียงราย 57000\r\nอาณาเขต\r\nทิศเหนือ ติดต่อกับตำบลบ้านดู่ และตำบลแม่ยาว อำเภอเมือง จังหวัดเชียงราย (หลักเขตที่ 1 - 2)\r\nทิศใต้ ติดต่อกับตำบลสันทรายและตำบลท่าสาย อำเภอเมือง จังหวัดเชียงราย (หลักเขตที่ 9 -14)\r\nทิศตะวันออก ติดต่อกับอำเภอเวียงชัย จังหวัดเชียงราย (หลักเขตที่ 2 - 9)\r\nทิศตะวันตก ติดต่อกับตำบลป่าอ้อดอนชัย และตำบลรอบเวียงอำเภอเมือง จังหวัดเชียงราย (หลักเขตที่ 14 - 20) ', 'pages_img/flower.png', '', 1),
(3, 'banner', 'wdsd', 'pages_img/canvas.png', 'wdwd', 1);

-- --------------------------------------------------------

--
-- Table structure for table `page_views`
--

CREATE TABLE `page_views` (
  `id` int(11) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `view_count` int(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `page_views`
--

INSERT INTO `page_views` (`id`, `page_name`, `view_count`) VALUES
(4, '/project%20jarnsax/', 128),
(3, '/project%20jarnsax/index.php', 71),
(5, '/project%20jarnsax/indexcopy.php', 6),
(6, '/project-jarnsax/', 2005),
(7, '/project-jarnsax/index', 18),
(8, '/project-jarnsax/index.php', 1136),
(9, '/project-jarnsaxb/', 4),
(10, '/project-jarnsax/?', 3);

-- --------------------------------------------------------

--
-- Table structure for table `payment_notifications`
--

CREATE TABLE `payment_notifications` (
  `id` int(11) NOT NULL,
  `order_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `bank_number` varchar(20) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `acc_name` varchar(255) NOT NULL,
  `pay_date` date NOT NULL,
  `pay_time` time NOT NULL,
  `pay_total` decimal(10,2) NOT NULL,
  `pay_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_notifications`
--

INSERT INTO `payment_notifications` (`id`, `order_id`, `bank_number`, `bank_name`, `acc_name`, `pay_date`, `pay_time`, `pay_total`, `pay_img`) VALUES
(1, 0000000001, 'wdwd', 'wd', 'dwd', '2023-12-06', '10:10:00', 220.00, 'pay/Screenshot 2023-12-05 225443.png'),
(2, 0000000001, 'wdwd', 'wd', 'dwd', '2023-12-06', '10:10:00', 220.00, 'pay/Screenshot 2023-12-05 225443.png'),
(3, 0000000123, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2023-12-10', '11:11:00', 123.00, 'pay/bannersirin.jpg'),
(4, 0000000129, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2023-12-10', '04:16:00', 120.00, 'pay/logo.png'),
(5, 0000000130, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2023-12-10', '11:11:00', 123.00, 'pay/Screenshot 2023-05-05 203008.png'),
(6, 0000000129, '012-1234-456', 'ttb', 'สุเมธ ภวังครัตน์', '2023-12-05', '11:11:00', 1212.00, 'pay/logo.png'),
(7, 0000000244, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-15', '10:10:00', 100.00, 'pay/Screenshot 2023-05-05 203008.png'),
(8, 0000000278, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-20', '10:00:00', 100.00, 'pay/Screenshot_Marseille - Avignon_43.45681-5.31680_13-10-03.jpg'),
(9, 0000000292, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '1010-10-10', '10:10:00', 100.00, 'pay/Screenshot_Marseille - Avignon_43.45681-5.31680_13-10-03.jpg'),
(10, 0000000291, '012-1234-456', 'ttb', 'สุเมธ ภวังครัตน์', '2024-03-06', '10:10:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(11, 0000000294, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '5556-05-25', '10:00:00', 100.00, 'pay/Screenshot_Marseille - Avignon_43.45666-5.31686_13-14-37.jpg'),
(12, 0000000295, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-06', '10:00:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(13, 0000000296, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-12', '10:10:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(14, 0000000311, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-02', '10:10:00', 1000.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(15, 0000000313, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-07', '11:00:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(16, 0000000333, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-14', '10:10:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(17, 0000000334, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-13', '10:00:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(18, 0000000335, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-06', '10:10:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(19, 0000000336, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '0010-10-04', '10:00:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(20, 0000000337, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-06', '10:10:00', 100.00, 'pay/Screenshot_Marseille - Avignon_43.45681-5.31680_13-10-03.jpg'),
(21, 0000000338, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '0101-10-10', '10:10:00', 10000.00, 'pay/Screenshot 2023-05-05 203008.png'),
(22, 0000000339, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-14', '10:10:00', 100.00, 'pay/Screenshot 2023-05-05 203008.png'),
(23, 0000000340, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-01', '10:10:00', 100.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(24, 0000000341, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2024-03-12', '10:10:00', 1000.00, 'pay/ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg'),
(25, 0000000342, '0688818141', 'กสิกรไทย', 'รัชช์ชกฤตย์ กิตติโชคธนวัชร์', '2025-03-07', '18:12:00', 100.00, 'pay/448324821_493665056342141_8886714140022524880_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `prd_id` smallint(6) NOT NULL,
  `prd_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prd_desc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prd_img` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prd_price` decimal(10,2) NOT NULL,
  `pty_id` smallint(6) DEFAULT NULL,
  `amount` int(255) NOT NULL,
  `prd_show` tinyint(1) DEFAULT 1,
  `prd_reccom` tinyint(1) NOT NULL DEFAULT 0,
  `prd_promotion` tinyint(4) NOT NULL DEFAULT 0,
  `price_promotion` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`prd_id`, `prd_name`, `prd_desc`, `prd_img`, `prd_price`, `pty_id`, `amount`, `prd_show`, `prd_reccom`, `prd_promotion`, `price_promotion`) VALUES
(180, 'ชาดอกซ้อ ไฮ่ฮอมฮัก', '<p>จุดเด่นของชาดอกซ้อคือ มีกลิ่นหอมอ่อนๆ ของดอกซ้อธรรมชาติ \r\nรสชาตินุ่มลิ้นทานง่าย มีรสหวานน้ำผึ้งจากดอกซ้อ <br></p>', 'uploads/product_cover_1695095700.jpg', 120.00, 9, 0, 1, 1, 1, 100.00),
(184, 'กล้วยกู้โลก', '<p>กล้วยถือเป็นอาหารที่มีแคลอรี่ต่ำ สารอาหารสูง อุดมด้วยไฟเบอร์ โปแตสเซียม และวิตามินซี การถนอมอาหารด้วยวิธีการตากแห้งนั้น กล้วยจะมีการสูญเสียคุณค่าทางโภชนาการน้อยมาก และสามารถยืดอายุกล้วยได้นานขึ้นอีกด้วย\r\n<img style=\"width: 400px;\" src=\"data:image/jpeg;base64,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\" data-filename=\"atome.jpeg\"><img style=\"width: 496px;\" src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAfAAAABeCAYAAADczUbMAAAgAElEQVR4nOy9d5wdV32w/5wz5fbtq7Ja1ZVkFUu25F5xgQCG0AwOYAi8hEAKhBBIeMObhDckEPKDNMJLCWA6gVAMNhjb2OBuy5ItW5ZkWW21vdfbZ+ac8/tj7qrt3dWqeFeC++gzn5VWd2bOnXK+59uFMcZQoUKFChUqVDinkHM9gAoVKlSoUKHCyVMR4BUqVKhQocI5SEWAV6hQoUKFCucgFQFeoUKFChUqnINUBHiFChUqVKhwDlIR4BUqVKhQocI5SEWAV6hQoUKFCucgFQFeoUKFChUqnINUBHiFChUqVKhwDmLP9QAqVKjw28Oaf93OcD6Y62HMOQYDxmd5dZwn379prodT4RylIsArnFPokRF0WweqrQPT24ceH0MVigDIaBRZXYVcMB976WLEkmZkbd2ZHUCQgUwnZvwQ5LsxhVGMn0cYDZaLcJMQa4TkYkgtQ8TnUzF0HaE/4zNaqAhwIwxon5Ttz/VQKpzDVAR4hbMetecFvAcfxtvyNP7e/eiBAUwuh/F9UIrD5fyFRFgWwrERiThWQyP2qhbcSy/CecnV2OvWnNL5TbYT0/MIpu8xzPBuTLYXvHGMDs8PuvRJgRAWWDZYEYjWI6tXIBo3IxZei2jcDNI9I9fkXMW2xFwP4azClpXrUeHUEZVmJhXOSopFvLvvo3D7nRS3PYUaHMYYjRECASCn0moFYMAYjDEIY0Ba2A11RDdfSOS1r8K96eUQjZ5wCKbnEfTBH6F7HsVku0CVNEchS+cpnav83mBKmxAIN4VsWI9Y9mrEstchog0ndTl+U5j3ia0MZita54QGvqo2wd6/umSuh1PhHKUiwCucdXg/voPcN7+L98wOVD4PQoRCU1D6+wy1lgkBCqA1GLBiUZyN64m/7S1Ebn4dWJMXAqb3YfTu29C9j2GKY6GMFqXPiQnBPaMBlOS7AaOB0Mwuq1uQK9+IWP0OhFs1w2P9ZlAR4CEVAV7hTFAxoVc4awh27CT/H58n/+uHUJlMqGVb1jTa9gk4WthLCVqjCgXUlm34z+0mesfPif/F+7A3h0FEJteDee7f0QfvRBeGCaWvBfJkhPYxAyjtVlqAGA1aoYf3oJ/6Z6z2e7A2/DEsftWpfb8K5y4lr4upWNArnAYVAV7hrKD49W+R+cJteIcOhb+w7VMX3FMh5RFBnsuR/eWv8Xa9QOI97yH26nnonf+K6t0JJgBhH9G6zxSHjydB+ajeJ9FjB7FXbUVc8CFwUmf2fBUqVPiNpiLAK8wpJp8n+4lPk/v+j1Ajo+DYodb9YjIhyANNsa0T8cPPIIYksqkbbAn6RQ40EwKEA0ZjcoMEu76CNXYQecnHoKrlxT13hbOD6cInKlSYIRUBXmHO0KNjZD76MXJ33IUpFiHizty/fdonByMkkQts7OZR/FaNzMSwV2mEa0DNwhiEBMvFBB7q0D3owhD2FZ+Cug2zcPIKc0pJgIuKEK9wGlQEeIU5wYyPk/nI35D96c8xSiEikVk8efgjcp7BWW0Q0oEA9CAEaJxVPjgcyQ57sbFcjA4wvVsIHvsw9pWfqQjxCuccXiFgoD9N3g/QUiAQpRIIR8WiTMSllP4daEMq6rCgNoZtT794z/X34Y+PYpRBCIHEHM4FORzfSrgoEsKACcdgNS1CJhLTKgd5L8tgboBCUEQbQJpwmigdXBCGwkgMEoEUBmU0qUg99dH5yNlSPI6jIsArzD5ak/m7T5L9yV0YzOwLbw1Oi8FZrUO3tOJwjJoekASWjb3SD9/Y2dKQpA1GoHu3ETzxUexrPx8Wg6lQ4SznqWfa+cWD+3jqYD/9wwUCW2BcGyGt0B1ml2ojTPzbsg//XmcUl6+dx9+8YTXzqye7rvKjo+y/8y56Hn2SQkc3Vj6Pow0u4GhwDdhG4GiwNDgGbAO2EFhGIEWemk9+FPeaKxHu5OM/0PoEdx18lN1DB0gXh9AiKA1NY0mDJcGyDI4FUQmuNDjS4EpBNujnusWv5Zbz/oy4nZiFKz2ZigCvMOvkP/sFst//EcZohOvM3olL2Vz2AnDXaoQNHF0UrLTaVr0WRA32EhVqELOliQsLLAfd8xhq28exrv4s2LFZOnmFCidHNlPktu89wX/f9Sy7ukYZ9xVggWuHm+WEwah2+Fxj2WGMi7TBdsCxYDQgUh2jGEx+yQ4+8ig7vvU9eh56nKB/GNfXRDREDUQ0uFoQ0eAogWvAQRAhNJ7ZSGwMknH0wOCRdNIS/Zl+vvDk97lz9694Nt1NoPMgFZYFrm2I2AbXOmqzISJLf5eGiC0Y89pYXbcBbeausmBFgFeYVbxfP0zm81/G+B4iOvuat0wYIusMIgJ4ZT4nwShQnTYiZbDq9OwGHAkbBOjWOxD15yM3fGCWTlyhwswZHs7wxa8/zD//168Z9wNkfZJYdQzjuijLRtkW2raPaNuWE9ZcsCcEeEmwG0kibmMdZ4Le/8gj3PeP/0zfY1uJ2RGqUjXEbOewsHY1ODrUvB0lsBXYgcAKCDclkcogRQRc95gs0PbRbj7z0Ff4/Jbvo4yBZDWxaC0xW+BMCGjHELEErqVxRSjAHWmwS//vWqF2n7BTp5RgeqaoFGmuMGuYwSEyn/oX/IFBmE3hDaH2bYG70iDrTHnhXUJYgA+qzcYUxREn22whbYzW6Oe+AAPbZvHEFSqcmHze5wc/fYpPffZuxn2PhuYaUrEIFgK0CTdTbmPqrYQxhqG2Nn72f/+Rtq3biTU0kJw/D+lYGK1DE9qJNo7fjpApZvjakz/iPx/+LgoXqhdh29HQW2Z0uBH+1EahjeboP2bSNrdRiBUBXmHWyH/92xS3boP4LJuFS3OH1QjOMgMzKQRmgRkVoTl9Lt5RK4LO9qKe+TdQ+TkYQIUK5dn+bDu3ffcx0tk8CxZUowPDmSro6WVzPPCV2+jY+TzR2lrsSAQdqDP2Dj54YCvffeoXoCxINoDxOZfz+Som9JOg4AeM5XwyhYBioNDaIIXAtiQRWxKPWCSiDnG3clmPwRjUgVZyX/s2xrIRsx2xaUC4BrfFhOnXxRnsIwjrrfRYyDqFTJnZf8/tGLrjXmTnvYilr2F2zQAVKkxGa8NDj+5hx+5O6ppqUYEOayecLgLAMNLbzdN3/IxIqgrLCi1RZ+K5F0KitOLnux9l72AnVNWD9uFFLjnxYlNW0hh/GJ3dB7oQ+uROFhOAjCLiq5DuzNs5Km1o7R/nQF+aiDuF5iPACzRxx+L8xXXUJMLIwv7xPM93jhFojTVFh5+ir1jdVM3iugR2mRrY5egcytI1nKNtMM3+3nE6hrMMjBfJFHyUMkgpiDgWVVGb2oTLvJoYzXUJFtcnWFAdY9m8FMnoqQdqdQxm6B7Nk/eCUk3uY/9fG4MjJeuaa6hPnbhBx5xgDPn//h/8jg5E1SzX/i49Q3YD2PNMuOCeKRaQE6hBiUzMckAbgLAxKod+/mtYTdeD89tVN73C2cfISJoX9vdSLHrUuhL/DC1qpbRABbQ/u4PM4CCpVE240D9TrTosm86xbvYOHAStQp/8rBR7eHEpK52D4QdR+/4WEYyDTHJyqocANQbRJmTL3yDnvXbGe/aMZPj4D5/mOw8dpLE2VvbeSQFDowVuungxn3nbpYcF+L3PdPDBrz9J0UDckZNGbAwMZ/J8+T1X89ZrVk1revCV5tBAmt2dI9y+pY2H9vTTOZTFL/ihfweO5DdOHHzip5TgWNQlI5y3MMWrNjfz9mtXsrg+dVKaZ8EPeHL/AF+5bw+P7htgPO8jJjpxlRACCl5ATczln992Cb93ZQtlpfxcYgy6q5vCj+/ARCKzPzIDOGAvCteipnCS+1sGPWBj5mlEYrZVcANWHN3zOFbfk7Do+pKDvsI5zzlaC723b4yB4XGwJMKIMzbVCClQfpHB7h60nHjGz+D7JgUD6RGyxUKYznYOm82PZrIcMwEmuwty+xBWAqOnifYpiwCVAc+GQvdJ7fnEvgHu3t6J9jUjWa+sANfGoLJFrl+/gOaGMPdOacOenjEG+9PIVJSCN/mp8pXGRrO4Pk5kGpNP31ieB3Z28blf7uGJfQME+QDhWsRcm3hNLOxrcfipnRjgkTBlY8LiBOmCz+O7+3n8mQ7WLqpmUV1yUqTlVBR9xQ+eOMhffWsrvQNZcC0cu8zELcD3FIGn2NszdtRYziKUwrv/QYLWNkjE52QIMgXWPM0pZXtYYLICPSax4nOhhVsYL4Nu/Qly4dUvfpnZChWmIZ31yOV9znwbc4EOFLl0hhfh4ACkvQIFXxO+1C/KKWadSQJcFXsxmT1hFR3rqOYKouQUDP8xzSEnWj9a4I/OeCDpgsd9z3UxMJSjpi6JmOIKj+V9zj+vkZduWETUCYffM5Jlf28aXIvqhFN2gh3P+1zcMo+VC2vKHldpw77eMT5zx7N87YH9aN+QSLqkakPz99FK9uS7f+y/bSlwIjZF2yIZibK0sQprho05AmW459kOPnDbFtKFgOraWFjlp8zlEEDRkkgh6BnNzej4s40pFine80u0MbPv+9aABKteI2OnoH1PYAx6WCIbSmVWZxsriu55GJnrh9SS2T//i8LRz4Ip87tyzPRzJ8tM7ulU5yw3phkc7xwtpXp0h94X5fj6xTu4NnMdM37mOUqAh6ZXHaQx0WZE/bWgPSgOQJDGaA9BqZrOCfJqBBKjA1QwiD3tJ4+w7cAAj+/rB8tCiiOW6uOPbPyAt13bwuKG5OHf7usZZU/HMMjQrKPL3CblK9YtqiEemWx00Mawo32ID37jCR7c3kWiOk4kLtCc+sNqgKIfcNHyBubXzLxKT/9Yjr/7/tNkPU0iaiMQU47BAEIIjDH0jOTONuN5KPh6+vC27wjrnM/6+QEHrHpOa8UtLFAZiV0E5uBrYLmYdAcMPwOJpjCP9jeC4y1ZR//ueGbymVNlpg9HufMeP64ZHuscbWYiXuSUyllf5J/jHDUThBfOSa7BWf1J0Bqj0uhiDyazBzP6CHr4EUyxE2F8hB3HmHLmPIOREmM8hD8844FsOzDEC53jxOLulCkJ2WLA0vlJXnPxMqpiR2bS3tE8PWNFLNeaOi/PwJqmmrIR4s+2DvH+rz3GY7t6qakLff5nwkqqAs3y+hSRE9T4nSCT9/jMnTvY0T5Kddyd0YsihUBpQ89InnTBp+o0AubOOEFAsHM3Qf/A7Od9E/oXZQysak4vXsUCCgKdE1gJMweTrwDlYfq3Iha97DdAgBuMOe4iGgOScMFKqXc6AKH1SQgNwmDMyUQ8H32vjnqZBEesdBMCaSIf+XCcicYctnwd/YGjdwr/LoQ5ssguRVMLQ/g9Ssc6uqh2STU4ie9RoUJ5yswEpQdNSoSsxbKrIbEKGl+JCUZR6WfRg3djD/8CKUcwKoYfWMetQ0svYDCGUWMIq3raQeztGeH+nV0UPUVN9dQC3M/7vPZlq5hffWwecedwjpGsh2uX921oA7YrWbWwiqh77KJjYDzH5+7dxRPP9ZKqjTPdi6U1ZD0f5esjH7PAtS1c28KRYmK+CTGwuDGOM0O/5f7+cb718EHiEWfGq1wpwmqg3cNZ9nePsmlF41mjhZsgwN+5G+N5iDnI/RYGZNwgYuaIPDhFhAadE0gzew3TjsYICzO0C2F84NwtryoAaQSYIik3QAkXbTTCNxSUxHI0jmWF8tVobCkQypAPbJQwJGQBISWasFGF1gLLkhhjjl28lyrvGUsitcLIiRiVsAGGsWVovYLwgwpsqfGNIJeXCKWJJsEVJXErQAi7ZEIOENJgKUnBN2hLEA0rgSAIMAIKgYulDE5EhQsPBZYUFLXEwwEdvKim6Aq/HZx4KS8koSPRQVgxbLcBU3M5X7nzYszAT3jLym2kUjlUIYqvrZLvuiTF/DGMNwix6QX4r3Z28VTrELZjI6bQoX1lWFAf5W3XrKImcUSb8wJF+2AW3wuIuU7ZfZU2VCccls1PYR/ni/7p1nZ+9GQHIu5iyalM5gJPKYq+Yv2iGjYsqaUq5pDzNN0jWQ4NpOkYypHJeCAl8aiD60ikBUsbU0ScE2sNozmPrz+wl8GxArWpyMnG/ZMpBrT2j7JpecPcSJhyKIU6cKD0DM0yBrBAJAxCcmoBbMcfsCBAC7DmICdcOphMJwTZczqdTBJgac1Hrq/nD69uwStA1JG0pXP8n5/vpi4S5XNvvJB8IDDaELECxvw8b/v6LhZVxfjk766nPhEnUGExPd/3sC0LRzqIiZe39PgHxiMIwLEsbCHRwmB0qZOV1Pha4wfg2BIQxGKC/97ayr3PdvHmS1q4bHk9yWi4cAiUhfEUwpVIJK4FhaLiU/e/wPauDN9758VEbFBGU+Va/MdDBzk4kObPXrKKproqgiDAkgHv/cEB7t1XDLX7CqeGOG77LebkbXHCQdg1jDoX87kthh/sXc/fXvkA1y5+Acu3KBSjYT1pwHjj6OwhrFjLlIcr+AGP7BlgaKxAKhktL0ANZPMeb7lyFSsXVB3Tuq13NEfbYAa0wbJEWe3d9zXrmpI0Vh2bJ90xlOau7R2MDYeBc2YKNU1hKHgBf/uGC3jzVS3UxF0sKdHGUPQV2WJA51CGLfsGueuZdna0jzA6nAUJzfWJ0DJwAl7oHuXbDx0gHiu/CJmKiaB4PzAcGsyeXX7wIEB1985d5LQkrHl+JtYPAiiWzB1z4aUQFqYwDPkhiC2cgwGcGbRRLKryec9Vi3mmbZD7dg9Tn7R53cZ5vOeyJnZ1jOGIAl95/BCDOUhEDX989TLednE1q+el8P0itz3SyXhRU5uI8MEblvGLXX082TqOsB10Kcoq0Jr5KXjnJcu49/lOtrfniEQdtAwtaYtTDr97/nxa5qX47tOHeGRfP++6YgX/a9Mi/uiKJbzQk+eeXX0MZH2UCrigKcGtl67gkYM9/Gh7FzE3xQ0rI7znsia+sWWQmqjPnc/2sbV9nMtW1PDWC+rxgyS2I/jO460Yo/nrly2lMRkFnT8zxU9+mzCmVCnVlDYwWhze0Ee7O05uBjyXDSGn7ExbvTBJWsS4r3Mtbfc38SfnP8ifbHiUaDxDMZ8CBEJn0IW2aY/zq+e62Lp/ECMkVpm8fUMYZJaI2Nx6TQup+LFRRB1DWXpGciBkWdekATyluHL1AhLHBVLtah/l+a5RsOU0gXOQy3lcu6aBW69uYdUUUexrF9Vw6cp5vOHyZbQNjPPongF+8cwhmmrjUxaWmSBd8PjZU4cYGs5RW5s4qQcqFNihma9tIHsSe84CRQ89Oho2MZhlTMnULc9g0JkJxOymkB2DwARZKI6AUeduPnjg8Lub48StCH/6/Rdo75PgQOtQnn98TQvNccmW9jE+86s+xtMR8DMY6fAX17fQGI3wzm/t4RuPDoCCRJXh3Vcv5QfPDfK9R0dwIhYR7YNtYYKA1fMtrls7n+88PcTdW8axa1yixiNQgkLB5xvnDfCtd6zjpy+k+cFdfWxsamRTcy3/9Kvn+djdvZi8IOJo8ANeemEtr7twCR+/p51fPp0De4xH1ib59tvXcMvmatoGfb782BBP7hjiv2oH+c/fW8n7rlzJI+39/PvdnQjb4Q+vWlUq/HUui4yTxJhwYhWlTZdiCY6umT7NvsYI0BqtNCYwmMCg1YQgl6EgR5aEuAW6ZEYtEysROll0+P6YiZ+gjUAZgzIGWfo5sYUl3MsFW54dnLIAXzUvRkNSkc757BudxyeefAV9uSR/sflBGpOjFNN2mEPu9U1zFMMd29ppHcySiDpl76UxhoKneONli9m8vHFSLvXB3nG6R/JIZ+rkfClg04oGos6xk17bUJqB8QK2a08btqa8gKvXLmBBzfR5zNVxl+q4y7pFNVy5egGvv3QJLfNPbO58vnOEbz18ACdWPtBrQhhNSWnl0jF0dglw7fmYfOFFy+s8IQKEw5l570pdyuZMgAsR+k2D/JQplucCCcfnXZcs447ne2gfFSxZnmAsnef+vQX+aMznmtXL+OXzPURjMXJSoPNxHtqf433X2AyMeTzVk8NJRFFCkKrSSCFIxiJY8Qh/eHUdN6+tI28ClNbUxCLMj7n4GmSNzYdeNp/XraujfSzHZx7pZuuONHc/P0DSNZBI0FCT4IGD3fzb/QNEhcPbrq/nsqUJjLFY0RDl6Y4x7jtYpGFphKiWPNeZ54FDI/z+psXs7sli2S7UpUBovvBwNzeubKQ6EiWaiGHZVqmy2FzfgVnEhK9+1JJIS2AsEf5CCqQUKEuSE8dl2QhACHQQUMzm0UUfJ5YgWVNNqipJItlIrKoKx7JwlEaOFxAj/YjsOGKwiBpMIyhgkQCOzf4xBrTSoDVC69KiAiQGo0KBLaTBMgalDEYYCniMqwwJbZNyorjy7Kp2ecoCfHFDioaES6fME3eyDHsJPrv9RgJj89eX3EtdbIRCwQVvcMpj7Ooc5sn9g/i+Ihl1ypq/tYaoI/iDG1eTKhNhvatzmIGxPNGIM0mDNoQLrVTM4bymatzjzFajWY+8p8OyqtO9WFLQP1Y4qaCT6rjLRSsaT/i58bzHXdvbaesYo7o+NSkCQApBIVBIAZYlkUweqiwF2nQP58gVg9Mq3XpG0Qqj5rBcoTjy48zMm4K581GI0JGvy5fUPVe4piXCmoYa3vM/L1Adg/9zXSM7u9L8570D/OS5Pi5dPB9pGfJ+kVX1MYRweLJjnLahNN0jeQ4O5rhqRZwdgz4KXQqYDQPdCkXNYFHgqVATi6Nw6sKAU1comqot5ldXUZOK0JQYA5NGSbAUIA220Nz3fJqRNLzz8lq+9Mb1iKN05nd8Zwu27/PuS+ppSkb4s28c4vYdI7z1gmXYjkVRB0Qcxbxqze6DHl96ootbNtURtyUFAgTB4Sj1c/YGzoQJS2reY/OGZj7x1kuoibsoLQ5XsIy6NgcHcnzsx3tJZ7zDl0MFAePdvSQWLGTFlZez6uorWLhxIzVLFhFJJbGkjZAyzBaY0O61QhcLBAOjqM5OggOt+A/vwrtnKxRLb34QsHnJWr70pv/DeDGL7YQr+8PhOeJIipwkLKgpEXimwIDXx/6hvTzceT8jhS7qo9WHn4u55pQFeCrmsnJhDTs60+FqN5pnNJ/gizuuodop8peX/ALXzVIsDk15jB8+0UrrYBrXnXwxBBCUfFmXtdRy5eqFk3IE0wWP/b1pfE+RiLtlZ+lAaxbXxVnSkDrGdw5HrDgnepciUZe7nu7kTZf389KNzdN/+CRp7R/jR1vaka6DdZwZXwB5X7GwJgraMJr3CfRkhVYKkNIwmC4ylM6TiDpnx/QgwMywgE2FmSDnJiDwDPJHlzfx6KExntynWbPM5nfWVRN3JFiD3Lt3nL++PkfEcSh6sLgmysZFDvsf6Ocnz3XTPqTwjeC1G2s59Mgg43m/lPllMI7NbdsGuO2RrrBWha9Z1yz4+Xs3EY+5FLTNB+7s4kM/PYgtohR8i0s2pnjZyhr29YYlkgMFI74C5bF5aQ3aiNCth+H5wTR37hoimYzzslW1JCMSu8rm8b0Znu4cYlFNEs/XLElEeccVSb5rj/K1R7rA8vAFk+ae33gE4GvqUlGuXL+QZGSyUlGfilCbcMj7oVnLKAVacekbX89173g7TWvWEK+pwUkmkDOJo1m6BDavR2Wy+JfvZ3D7PkzHMGAwWlEXTXH5igtKaYkgTvAuaWMwRuMZn1xzlte0/C6f2/Fp9g8/i23cE+4/G5xWQunaxXVEtneTLfq4tqQ6lmUkm+Rzz13N8qoBbl33EJYeQOs8Uh6b+tI/nuPu7Z2M5YMwp7uMequUJmoL/uCG84iVyd8+1J+hZ7QIQpSvcGlCAb6sIXZM3vgE8YiNa4vwARJTa+Ex16ZzKM8nbn+WTMHnFZsWH64CdzoUvIAHd/ex89AwyVR0kgVCCMhnCtx0/Qqy+YC7nu0mlwuIlolqlwjGCwG9ozma61Mn9LvPCraDFYmi5spsaDhz/QoMIMNc5bkxgxqQDtjRsyfL4BS4YnEjv/ft50Ao2kYEt9x2gPF8FqI2e3slP9vTz+p51RhjsI3hhpZqHni+wNceHSbt21y22OXS5jjuYfepQWggMNx6UZJXrGtAGQiUZkEiguNE8QoBttBcsChJ/2iEjt4C56+O8P9uXsUFCxvI+t1gDNKSVMUthBvhme5hssUFVEUjCAJ++mwno/kYRCz+/Pa2sJOVlPTlBLc/288Hb0hiAWnP5+VrFlIdifKB7+/jq1tGyBUMq+ujHBNN+VtiSjeGqSPuj4p50kphxxNccfMbiMRizF+5suwu6bY2hrY8hT84gMxrLBsiEZdI00Ji684jtrIFq6oKzmsB1+ZoqRBa5+VhhS1dzPDwoccZKAyFVlhhCIBLF2xmbf2qcNElLGJYxGJR6mP1/Nmmv+JTWz7EYLb3jLVQPR1OSwqtaEwQcyTpiRKVBqrjWfqyNfzbs9exqb6Vdcv6UMVhiC06Zt87n2rjQF8GS0gsIcLo0aMIStrxxiU13Hx5+Sj21v5x+sfyob2jjKHUEPapvWBZbdk65M31CepSLm19WUTUnuadMlSnIjzwTBcH+9L8cfcYr7xwMWuba2YUYT4VL3SP8t1HDoQmPikmuQB8ZbAtwc2XLqd1MMMvd/biB4qYK8usdwT5QkDHcI7NKwzWWaCDy0gEURUPu//MBTosJnhGXjMDwjZz137QaIQTQzjVnMvm1x29Oe7aPUy0KsL6eglFQ5UdYeV82N/u8bNdY7wt4RCzBemCYmNTFRctGWVbWw7yAa+6aT5NtTUE6lCpE5ZEGwGBR2M8yXkNVQTGoA0kXYuiVuRUQBT42xsXEZGGW7+4C288QrpwlI9FhebbVyyr4rbkIF9/vI95yThXLImyoTnO17cOgyXZ0CCIa42WUVYuEOxpy/DgvjFeum6EmohDq5fH823evKmZH+8a5de782CCMODq6Ps2kW177t7KGWGMQYIi21gAACAASURBVKkpsnu0KeXlC4zWSCfCkg0byn62OD7GwR/fSceP7qRwsAsrk8XxDC4QtWyiVdXEFy8kueE8UtdcgpWqDmuZTBOV3p0e4F8f/TYvDO9FxqJICb4JWNewhI9c9l5uXHrtpH3W121kRU0Lw7k+AuXP+Zt4WgJ82bwUiaiNGQ8luAEsoYk6HrtGmvjizsv4l+YtWKoPOCLAfaX5xfZOMp4i4lqTNU9ESVBZvOnK5VP2127tTzOS87AdWT573EDElly1ZiF2mbSNC5fVsb65hkMd4+EkMM1UL4C62iTtgzn++jvb+PGWNt553SpecWEzy+ZNNs+fCKU1j77Qx5YX+omXSZ8TQDbvc/HqRjYsqcfXhogjUWrC5j95sRIow/7ecbSeQ0FzNK6L1TgP5sAPLkrVtmbU+3umx3SZUwFOpBqidee0Gf3LWzvJDATcdHkV3751LcN5RcKNsKN3lNd/6Rnu3gnxaB6bgLGcIelGuXpFki89MgjRItcur8YVkM57FIIAZTRFpVBS8e8PDvPvv+oJI/QDzcIFFne8eyOu0GTyOfJFxWs3L+Nv3pDlw99s5dbbdvDdd68mMIDvM5L2uOXCpXzgqjT/+VAPn/pxK5dfGOWNFyxg76EMS5vj3P6O1UTcsKteT9bnrd94lsdbx/nWti4KxsfTAWP5HA2JWv78JQvZ3tXKaKdPziuij64uN9cz/zmEl82y57s/5KmPfxrVM0AyXk3cdhFGYiuD5xUxXSP4z++lcO8j5H/ya2ItyzHDecQ0OZ/FIODg6BCdQ/2QSJbe7YCu/u1cvGBdWQEOELPjSCHPfQ18SWOSmpLv+bApxAiits+4H+Oe9jW8taOTy1e3ApsP77f1QD9PHRxCa0PUmVzrWxmNMYY1TVXcfPmKsufWxnCwP02m4BOZogKbAeqTETYurccuY1JumVfNqzcv5aE9A2TzPsnYdFo4aDR1VS5eYNi6Z4Ct+wZ4xeZm/uTl67jqvPnUJWdeLvRg3xh3PdMBgSHqyFDoHjd2HQS85eoW6pJRqmMuVTFnyrQLUVrN72wbIlCGMi6n2ceSWEuXTp2f92JjwpRbozj9SDYDImLOTE75qaADRGw+RMqnMZ4rrJ/v8nevX8HrLqhl1Av4xE9bWdMc5U+vb+ZLb13Hjp40LQ2CFdXV1MUjVEddXnd+M596pY+MBFy2rB4hDB9+aTO+UsyPW7x5UwNLaiMoIVHaIBEE2tCUcFhVH+ddVzRx1Yo61s6PcHBggJvPr6f+j5M8tn+I0bTHm86vZVHK4qoV1WTzHu9/yVKuaKnmoYODvHRtA4WM5qOvWsSVK2pYWJfgw/+zl2ob3vfSJr54y/nc8Vw/582PsLlJcPP5VVywIMru7j4uWpjgq29axgMHxljV4DIv4SCFCVOdHANhkbYKJ6B7yzae/dI3yPQMMq9lFRGlsAODrQWWBlsJbC1wfImVD/APdGMOtOFSi5gm3VIKQcyNgBsDJ4pjGSwsIrGlLEjML7vPuDdGd6YbZRSWnHst6bQEeGNVlHlVUSwZ5tFNmKkF4Fo+nbl6vrZrPZde1R62FSc0qXztV3vpHy+W7dAlBBQ9RSJi89qLl7CwunwjkKF0jj1doxQ9RSw5WfBqY9DGsKguxvyq2JRF8t94+XJ2tA3x1V88T+BaWNb0S2Otw25jdfUxir7m7m0dPPh8L+97+Vo+8toLqE9FMRjENEtsbQz37eji/h1duMlI2ZVcIdA01MZ5yZoFCAENVdHDi6VyCASWFLzQPYqnAhKnd2vPCMK2sdetQUyUuJtN3+2EBp4TGN8gbE7LH26EQMTCNJM58V+aAFGzivCLnLtcs6IBa5UkV9R85M7n+cGD47gNkmTc5lXrlrJhURXGaGwp0Rq2tI0hpeRVmxuxpeTpjjGUCXjVugUINI8fGmVRVZy3bk4cXluFgc4GpRQH+n3WL2pg0woYHCvyqfv3Mb8qxvuvXclly1MMZYskbcn5CxP4WvD5hw+xYyDDGzc28KYLF4CMokTAOy5L4kuLf7z3IF+4rxdiNnmp+NOXrOMPrnDRgQIhidgWvVnNJ37Zxur6OO+8YhHrF1ajjWZbxyhdY1642P5tcYKfJsYY2h98lNFD7SQXNUEQhB3LSunkh7dSTrmwBZasxgokqOlrzifcGJsXriEaj+NEYwhhkCbPtYvWc1PLDUfGgMFXHmPeGD9r/RGtI60IYWFJa87v4mnNBrawaKqPY1vhyte2xOHrGZGagnLY2ttEd2eW5oZwn+7RLI/s7ccgcK1yvtwwAGVJQ5ybL10+5bmf7xyhq5T3PNGR62iMCYXtyoU1RKYJOGtIRfnw726kf6zATx9rJZaKIuV04jdEa4NjCepqY2SLik/fuYtdHcN84T1Xs6Q+Ne2+XcMZ7tvVSyEXUFcXneT/BygUAl63eQmL6sKVT0MySn0yCiJcmEwanwApJQMZn5FskdrEWZCvaNs4569FVlejPA8xmxXZShlfJi/QGYFVb05dgCsQjkHE5yqIzSCERDRuDgPZzmHe+702RvNFPKXpGC8imqvQwvCxewf44iNjBNogrPACGyTa+GgMtrBDV7VRaG2whYOwBL7ysIVTioMJCUuqCjAqrCFiS4wApQxtaU2gx7ln7y4swrlGilKOtlD0ZRRDYx7ffSbN0hoHx3KQGGwjKAhBf7qAaKwGS/DV7UXu2/9caGAq1V0XRmJMQHvG5569eX68K41r2RijMUbRmRfgWEij0UKcy/GIs0JQLJLu7ibwfaTrYGYSEWsmpND0LKtt4muv//jh7pXhcxaW3T1mDCpg3/Bebm/9AXcd/AEJ6ZByY3hzFp17hNNezjfVxHEdSa6owqOVvpMsdeDpyaV4pF3y5gs9wOWHTxykeySHQCDFsZXPhRAUPEXMtblmzXxWLpy6hvqBvgyjeYW0ys+oYf9pWNs0fR12gBXzq/j02y8l4lp89+GDRCM2MWdmqyttIB6xsKTg3p19vO+rj/HN911HTXxqc/rje/t5ct8ARNyyK3FtwHEkt16z6rBZviruUlflgiXQenJxMwFYQjCe8+gbL7CssWruU1ekxFqxHGflCtT2HTDLDU2ECH3gagTsxtOQuxpESiNipSPM9nurFSJah2i4+JwX4C8M+AxmFWHkZhQJKCMYLBgG04Ujro6JZ1eUFl7aP/JvIwgroZcQXlh5a+Jxt0oHURbgg9CgJEhdikx22NMxsf/R74gCW0A0gQ40rf1BeF5B6ZwCnEjYUjYwZALBrlHvKMtSyeyDJvRhWezt1seONSLD8ZUalBXPAiFwNqMLeVSxEAZxijNX0QFCq6U9AzO4pzx6M330FfpJOTUolQnLbs/1/MoZEOCL66PEHMF4TnOMBCcs95vxItx/UPJmPHKexX8/fJBAQ+i2Pu5mGMgXAzYureHtL1k97Xlb+8bJFP1SI4LyRG3J2ubqGV3nZY0pPvO2y1g9P8W/3LWLkXSRqmSklAc6PcZAxAn7pD+ws48v3LObv379prKfTeeL/GJ7B10DWapTk4PXDGEf8Q1Lqrm4pTFMbygxPxUhYkkCHZoYJ41LQrao6B3OESzTpxUhf8aIx3CvvZri1qdn/9wCCEAPCswKc1p+cFlr5qYXOIAqIpouh+rlZ8WkcTqImESYUtVEc2QGEI4oCdejMKUyltoDVYRS0Zajjham9pkJc0vp744Tuhq8XCgsjQJnIuS7ZFaNlI4jAeOBCd9fUBAUw786pQ8YHWr4hjBAzi91xhEGJgxdx2htpRQaIyCiSmO0gSBcjBirtKjwQZ3bC7IToQ3TppGe6Gm2q1I4ySpEyYpxJqP/Osd6+eyW77A/3YsVcRHSEOgiLakGfn/ta9gwbz0AcSfONUuu5ZJFl9KZPsTnnv57Do3tJVBqWlfpbHDaAnzj0kYaq+J0jxaPEciGUEv0lWDPYBzlBzy6p4fnu8axhJikHQqgqDSWLbh0ZQObltZPe97WwSx5T+HYVlkhaIwhGbNZvbBmRpOeEIKFtXE+9JoLuG5DE5/66Q7u3tqBcGyq484J535jDI4t8APDNx/azy1XtrC8THT6fc918+DzfRgpseTk9DmMoOgpXrWpeVLluYZUjJhrkfVMOLmUiVz3laF9IE2gzg4BLlyXyE0vI3vbN1CeP/tmdAPBqECNCaxac4wyNCM04ICsUaH/e9ZLqYYLD7n4lWCdBW6R08YwZW/X418FLSAo8LaLktxywVJS0QSWCF2bZqKgrPTJ5A0Jx8aShv6xLB/4aTvDuQz/+eYVbJhfR6aoKaiwfkLYjTB8Bi1jKCiPkZyHQVCXjOFYFgZ9OLhMK8NYJk9RaxoSCSK2RolQ2AsZ1tbOe5qRbIGIY1GXjGMRBqUKAUoahjN5At9Qn7SJShstLUpVuXHPsUJHE+5nTmj+D//TERCfQskSRz42JZa0qVm2GMd1Ubli2JY4mG5FII4M9ASr9bFill/u38Luwb0QT+BYBkca7guGaRtv4++u+HPOb1iDEALXcnEtl7X1G3j3xg/xuWc+zu6h1jkX4Kf99KxaWMOCmliYy3e8QCm9BcM5i9605qfb2igoU/bGCyHI5T1a5iV5/WVLj9E8j2ckU6BjKEugTNnocmMMCMmK+Ula5led1CVORh2uWbOQL777Kj7/3qtY01TF6EiOnKfC6j3T7CsIq6K1DWa559nOMr5tw692dtM+mCURcyb9vzEQKMXa5ir+/Kb1JI4T4JtXNNDckMAv+lM+OMYI2oay+FPkXs46UmKvX0f0qiugUDjx588wAjAFUF3i1LKvFIgajUie6ZHN9PweVvVSxJJXntnOLOcCoeOaG1fVcWNLPeP5DO0jefqzRfqzOfrTWbrH8yQcj97BDP0jGa5sqeYrb1rBP71iAe+8aBH7B0fpGx2lShQZLxTpGcvRl8nQPT5O/3iGJTVRfu/CZbxufQNePk3PyCiDY3n60wV6R3O4ToE3bGriLRctQZssHWNFBjN5erNZ+sZytA2lSbket25ewmvXz6dQ9OgaS9OfydKTyXOod4xLFyR4y6ZFLEy6DOTy9I6nGRjLMziaZSx9dvUvOBE6MAz3Z1C9I2TyoXtBWqFCJiY2S2C8sLrd0tr4pB4UE/RnfAaz/glbJSx/+Y3M27iWTF87RhmEZSFKNdXDzQo3DTqXI/D6UWakZBWZ5uAmzJryjMAYgTQCV9jkAsXjPdvZMbR70i4CwQXzLmNV9TosIfH11HPxbHDaGnhVzGVBdRTbChPzHXmk1cKEXzbrwR1PdXH/cz24tjXphgkBntII4CXr5nPd2qZpz9k6kGYwHapSUhybWSWAQIcR8RcurT8lLVQKwdKGFO+8bjWXrZrHf923h28+dIB0PiAZnTC1lUcIgTKwvXUIpcwxXQPve66TB3b1ojS49uQFDwKEFLiOzTcfOAhHaeiOlLQNZSgG4Lr2lDmIUgjaBrOcLfIbQESjxH7/rRTu+zVK67CW8WwhQ2tl0CuwlwmsuJl5b3ATulbteTos4jIH7kqhC8iVb4J4+bSW32iEAW0Rd1y2dab53z8+SNuITU4VS75pCzJ5/vGWxTw7YPj51jRXb+zgzndexA2r6/jzH7Zy24Pd3HhBjNdduJCP/uwQubwgVyyAMti2zdJqwT+9aTXrFsb5h3t6eKFHMR74Yec5S7MgaXHLpaN8/KYWPn5fLzs7CmQDg/KzoFzwfF5xaRX/8cYU//eOg/x8+yjjgRfOrEVFVcrh53+6iXv3HeKff9lN62A6rDmhgYLHn7xyMa8+f/FcX+kZc96qefyvW6/mR4koz3eNMNiTDv2hcRciLth2uPAqaC66vIXfv+G8KTOAtreP09GbY/550zeJajx/HZs+8F702Djpp3ehrQjYUYywkIGBQGEIBakTryVx7bXEli2neOfjmO6wlGo5lFGMFEYgN4AvCviWIW1p8MdZWXUhq6qXlt3PEhYppyrMBT9jpR5PjdMW4ELAoro4rm0RqDAy++jrZUlBtqD4wr0v0D1SwClTsVQKQS5bZFFDnN/Z2Ez8BEnM2w70MZyeSEObbNzW2hCLSDYurT2t7xZzbTYvb+Bjb9rMxS0N/P0Pn6FvvEiiTO32CYQIv0/faH7S97x9axsv9KaJReyyz5QgvF7dI3k+dcdzh10BE8cFQaA0sUj5fHUBOLZgX/comYJ/UnnpLypS4rzkaqI3Xk/mrnsQqVlWZwWoDASHBNYGE/b0ngkByAaNrC29pLMtwFURUd2CWHkrWGfJvZx1Ql+5Mg79aYualOajL1lKXczGVxpd1Lx0TR2vty22HnqWe58r8Ff3tLK2NsaXHuhkcX2cT75mDd0Zn8Ehn+VNtbz9onnUx8MmKd/ZNsrnHuzmwy9dQMaHcVXkgzc205yK0p/P81+PpfnSY0O84vxalImS89P8ydWLubA5QdYLEEqwuEFy+44uvv94P1esWcBbLk5h2RaZrM+yxiiW0Hz2V30cGsnxv1/RTHNNAqU0XhFuWHN6c9Rs09hYxR+9+zouv2wV23e089zePg72jjFQKDCcUfhI6quirG2ZxztfvZGrNi4qe5z2gSw/e7qH3HiBSPTIfKq1Rh63wLcsm5ZXv5JoMknbD+4gv/8Q9I1jF3O4RIjWpIjXVpNYtpjkBWuJX3MRMhJh4IFtmGle9ppoktevvYb2pmUQiSEkaDyq3Ci3rL6JTY0by+6X9dP05DoItI81x0GlZySptKk+TjJiM5j2iLnHXnwhwlSNfb3ZKbVhT4U37vrzF3LD+dNr3wBPHRgiU/BxrCmq4RhIRGzOW3Rmil4srInzB9efR/dIlv939x7G834oRMtN6KVYqeNTDJ5pG+DRPX34gSq1Ti0vDQRQ8BR57/iVncGSkogd+s6nkiW2JekYzNA7kmFxffKsiXkSsRjxD/4pxS1PEmSyCHcWzcEi1ML9DoHdJJB1M/CFK8ABe7EKW5LOtkXDGIRRyA3vg9SyWT752YU2BtuSWLZNKhawYWGcBVURvABUoFiYilBfFeVLbzyPW7+xmy8+PELUHqG2weUzt7RwwcJGDu3sBjTnL9T8/SuXAXG2dnXx8P5RDgz5jOTDcyQigj+8rIE182sYzGW56/k97GhTDI8XiToGx7ZoabDZvChJxvewhKYhHufR9hxaOTTUSDYvTWErC2V8Ll9Rz7aucQbTPhFHsnp+kvXzkijfo7E6yor6ujm+uidPLOZyxaXLueLS5ahAcahtmPbBMXr68xQCQ9O8OJdvWERNVfmsk31d4/zbL/bxwJ5BcCVCCoSUaK/Anie2EolGaV6/nkjiiGYuLZvFN17PouuuYeS5XRRbuyA3jrRiRBY2El08n9iK5Ux4hVXfCMb3p/0eS2qa+Icb/wyvZAY3AgKtaIjWYcvyojEf5PnZgf9h3+jzCGEhseY0p/+MCPDmugRVMYf+sQJlQ30FRGyLcu1wpRCkcx4LGpPctKmZuuT0gTpeoDjYn8VTumx+98Q825B0WbXg+BSyUn7oKSCE4A0XL+b2J1rpHy8Qi0zdaNoAkeMWMt/49V7292WIOicOiLOkIBUrf2vMCSy5thSM5xWdQ1k2rdA408QSzDbO5gtJvvfdjH3y/8PY9uya0gWYPBT3SGKXKcp3vzkKBdZShazSc1O4JUgjl78KufL3MJn2sA94pAYRnXfOR6LPGAEIgRQSpQLciGH/IPz+bXuQGjASU1B89T2red0FC7nhvAX85SsKfOT2Q/gReP81jbzh/CZA4+sAIhZbewyv/9petPToGDN0dgt+56Ioi5ICy4KcjnDLN/dRG49S8DW7uzya6/NsbqrBU4MUtMvf3NmJo/aFtXU9wc2X13DLZfP5cr3NnY8P8tDuEQRgS5t1i9v5h1ct4ZJVUe580uN93zqEaymEdIlXR3j/VdX85fVr5/Y6nwTjY3mGhtMIKamujpNKRGhpaaSlZYrWycZQ9DW5os9wxmdf9zhfuf8AP9o5EGYdxBwwIC2LIJfm6Z//ghfu/xU3/MG7OO+qK0jW1xOpSuHEYkjbRlo29RdeABdeMPlUKkCnx9GZHMHuVsgFHJnvBYFW+IGHNvpwY5OYHSdx+DMGhEAZRc73DgtmYwxFVWDcH+OJnof53p6v4gVp4naiFIo4d5wRAb6kPklNwsHoqb/MVHOOBlS+yNWXLeYl606sfXeNZOgr9eYuF/ygStGfi+piNE5aDAieax8iFrFZOf/E+eHHU/QVwQnulya84fNS0cMRgof6x7l/Zw+5oqImXr7y2vGcapldIcLI2c6RHF5wdglwbJvYe9+F/9R2snffA6mq2RNGpVVT0A/ePkFkrSlfJ72UOy4bNVaTOv0SrCeLAYIssnol1kV/C04K0u0wtAOTWoqI1J/z1dhOCWHwlcW8GNx0fgPxqIsJPIKgSHNjEiFcin6RRw/0AQLta55uzdKVybJ4wmVjWfSO+vxkdDQMbggsNqyQ/N1NzcxzBQUvwFiGnoLPc30+6ICrWyJ8/OWbWVpXhRcIbMvnZevmsaTGxlM+AZormuNc39LAf79L8PPnBilqCyF9nujI88COHD9fMsJnX7uc61tG2NVbxJY2A+k0d+0t8h+PjfOX18/plT0ptj3Vzhe//EuyxSKXXr6G5c31VNVXMW9enFQ8QsS1kNLCCEPRVwxnfboGc+zpHOWhvcM8eGA4jEGpjofCu1jSkg1I2yaaStG1dx8//ejf0bxsKSs2X0Tz5g3UL19Bct58ItWJUJBPDEgpdN5H9w+h+nrxD7ahdu5H7zyE6ckghQsIhGXTPtbLln1PMJwdxY5ESlHHhLEW0iCFwQiDlCW3pQwD9FQQ0JvtZufwNg6M7qTKiVEdSRIEU7fKni3OyEywbF6K5ro4W0tdxWY6JQsBuaJPVXWEl29cxMKa6YMZAPZ0jzKcDWfe4+dWQWiujzgWG5bUTRIOWhs+fccOMhmPm69u4Zo1C1jSMDN/rBcE/3975x5dVXXv+89cj/3OzjuEkAcJJAIRKBp5iSAC6lGrKNgOPVavtLbaW0tp1V7vsPa0x95r67EPqXVch7XDlp4OrEWt97YV6eAMLVVBBSkPIQIJrwQISUiyk73XY877x9rZEhJeNjyi6zPGGntlZe+55l577/Wbvzl/v++PP6zbw/72ZNrzP8FdXSlqy7LR0iOM3/19B3tae7ycdTGwC30qKRVHNX+SJ0DjoS5StidJez4hcrKJPfId3H37SW7ajIjFzp4RTwe0WTs0RFQSKB/AiKdAy5KYVY6nfX62Y1TcHkQoG33qv0PuOABEvBJC+V4a2Qm0nT9xKEBJlHJAGdhJh6pCwTdmjaA0N4Rlu6QU5AZ0UBYP/nELf/pHgomVEfKDgv/alOCBl7fxu9tqCQcEpBwuGR3nP+aPpjAWQFdQFI2QHQ6xZX8LqZRGlmbzpzvH87M3Gvjt31uJhEzqKvLQhUQpCAnFbRflcuWYArpSLq5wMIROd8rhM6XZTCjNQxMQMh0eWbmLjR+0sac9BWaIO6aVk7IsAqbBtqZ23tzbQCp1boOgTh/Fh40trF+/g1UbduNKA2IBsvKiRMNhjIAXyCZNjaQmOJICy5KgGZ7HHQ15AW+61q9GQm96WjQvl1goQqKtg62v/JmdK14hbIaIRbOIRQKEDEFACUwJhutidGtohxPoiS5MFAECBAhicNQUvq7x3t5tPPSnJ9l5cBtk5+MJqeMZcUMiNIlpKC+dTO/dh6CmETV1wrpBTjCfoO71dsgXM+klNxpi9PBsTHM/tisJnLLXJ0glUvzLpVXMHV96Sq/YsqedHssduIJoer29IB5i6gXF/V6761AHb24/xIcfHOIvmw+wYGo58y8ZSU1xNsOyQ+TFgn3S11yp6OixaGrrZvXmfSx7YyeJlEM4MPAatne/URRkBbm8dji6JmjpTPLyuka6LUko0D94rfctWI7MROIfD4W35BAwNE+29njfHyHY3ZIgZZ+fNwe9ppr4Y48g770Pa1s9IvsseuKal1ZmbdHQTBejxPO4UXiiXRGJMdpBRM9BzrfdBcEY+iX/hii76qPjRgRhnHxw+0lFCIElIBjUeW+/y+ynNqEhkErQk0ry8wUlpFKSp/52iPycIM99rgrTDDB739u88HY3Nfk7qBsZB6UYnhVgYnGUrU0J6lsddrUeZFJJmOHZAUxSdCdtckM6z9w8lsaWf/DXdR3cFdzIz26ciJIaXUmNO55vIGrswBECO2kzf3yAf7mwhPv/sIcOaRLSJS4unZ0GZjzCpFFBvvrC+6xpkJia935SChJtinkThlZwoiYgFAqgx8Pk50WwhI5r6NhS0dKTwrYclK57YjqGgTJNiAZB10E3+ktIDkRaCtcIhQgGgwQlmI5Aui7Jtp60TLbClRohF4QU6LqJHsvHcAS6qxBS6zf4DhgmgVAOhAshlOsZcN3rUtBQBDSJqSsCuiJoKII6BHRFQMcz5lpvCvS5N9y9DJp7VpYXIRrU6Uq5BI2BNc6PRuAVLQkGTW6oq2Bk0Yn1w8ELZvnH7jZsR3mVYI4Vfkj/nR81GTdAANsbW5o40m0THBZDKsWyVdv5z7/t4sLSHGaNHcbUmmEU5YQwNR3bcWlLWLy/u5WVG/eybsdhArpOJHh879t1Ja5SzBlfwmcqvDWh37y+na17O9CEQB9Isz39GDA0YmHzhNdNCIGUCkdKpJTHTc8QhmDv4S5SzvlpwAGM6VPJ/o8f0PHth0lt+cCLTDeMj792cBoIDVQXpDZqKKEwhknoUoiohjHa8VTXTq4DMVi98YRN7C5EKAd98kNo1bd8OqfJB0J4JXSHBU0mVwTZ3wm67mmbS6VQ0qWpM8XfdnQypTLK3dNKKM8O0ZSAZ/+1lgdeamD9nhRRvYUZ1QYXDRd0JCy+93/rWfl+F8oN8MD8Cu6eHmVSWYjS7hBWyqHL1nnm8xUsWbGbnQeTrNy0h6nl0sg6UgAAGOVJREFUUQwdTN1EKg0hU9gRl5LsMNnBEKPygiSkhmEaOLZFrMDirmkjmTsuny37U4zKdQiYnvCUpmwmXSh48Krac32FTxuRTncVeHnfmqahacJTh9Q1pK7j6t4+mvBmHU8mojHgiUAo7zxooCkNzRBoylPF1aQnJiOkAJlW2kvHTRxv7Uv09uOoTWQ20Wff+78CJCKT7X3+GG8YRAM+LCdMdsSkPWExoEzYMQgh6O62uGLCcCYfLwDiGNoTKTY2tnr55kZ/KVFXeR5qcU6Y0vz+VczW72oh6TjoAkIBnUgwiuVINu5uY+OOFpYaHxBK65pLF1Kui0w5oOtkRU2ME0R/g+f9F8aDfHG2JwPbYzm8tLYR2wXT7G+8BZB0XCKmwWcvLuPKiSNI2u5xL13A1DnQ3sPv39zJ2g9byI4FBrR3AUOj+UiS7n6R7OcX5uxZZP/4UTr+7X+T+vubqEgEEToLHokAdJCdGj3rUgTLuwjVumhVOlp++Owab2mj7A707Cr0ix9EjFoI2tDyys4c3o1/T6fDZy+M8Z+3T0grjXsfkBCgoXBSDl+9VEPXBd2pFHf8dgMtScGrd9Xxzn3FJKVEcy3+++U1QIBdrUdIKBMZywLb5Uiym2iwkGe+cBFCQEeqi6/+7h2+fVUtL3xxIjYK23K4cZKBSFezkXhCVUIppKuQCF7+ah66AukVNEWgIdBxpeTHN9Sip42KApRwSDkua3d2UFZ7rlSCBo9eu6kJ4VXuE8eo3g7KScRHM3WZE3IGTgQf3QDOL4N9LINmwIfnRsmLhWhs7jqluJ+U42KYgtsvr2Fc2anlQtY3t9PSmUKJ/mpuApCuxNQ0yvJjBI2+b82Vks37juBK0DUtvfzi5a3nRr2UJlelR/VKoemCmGGgh708vxPe0wX0pFzCAZ275tQwc1wJCnjhrR1s3HMEIciUWj32dZYtGV0U4r7PjqO2rOCk18CyHXYdaOetzU2oWHDAXplCo6XDU5IaaCbifMKYMY34j/8X3T//P3SveBm3rR0tHk+L5Z+hH48QICWyqwPRZWBccwvBBTmog8+hOg97gWPa8WuvD0IHAAl2J0K56GWz0SZ8A1E6l4+bJfHJQ4GuI0Imv/j7If644RAIhav0jMKjpnlle6XU0YWLg0vCMtl4EHQUl/z0LYriIVzpqWwppVCaIuVq7DisIKhDWOel7W28v78VUwviajqWcvjHXpO1ez+gLMdAIlAIpLIwNR2pDCTKUx9DoKTEVRJNx6v1LTz5c6EEtiaQuBi9U69K875+yqHxiEQTBntrTx686+MzEINmwEtywhRmBTi6QMHx0IQg0ZlkzqQRTKk+udHqpX5/B4l00Ee/QYIA25XEQgaVRf1HtJv3tdHQkkApL03raHrb0dIjyKNvoid7L14gnosm4OYpFXxnwcUA2I7k2f+qJ+VIjAFqjAsg5UhCps6MC4adkvEGCJgGpQVZEDTSUrL9n6MbGkc6eti29zDTq4u8tffzGGPChcS++yBG7VgSv/4d9patKMNAy4p5a2fwzxvT3gGUK5GJToTtEKgZReS2WwgtvBm9PIbaNQ53yy+RzWu9WrRmDHQz/SUYDGPeGwrfhXJ60GIj0EffjFZzG+RdOAjtf5IQCOWp9jW2Q+PhdJWvzFBa9Q0IzQT3KTCCICTbWnW2HZZktNdVeqpVV2BqXhqjgOZOk+Z2vM9cOIBCM00auzQa251MfzLTrsqmj4cm0m2L9HJIpm/px6OLsIheUSBvdqGy+JNdzMTnzDJod/ai7DCF8ZC3pHeSm21nyiGeFWTxNbVesZFTZPPeNixHHrdMpuNKYiGT6gHKkL66fg8tHUlvnYN//nasCa9wSGciRSxi8s1rL+R/3vQZwPP212xrYn1DG7om+g0YABCCnpRLRUGYK8YPP61zj8iPkBUySdkuZqh/MRcNQAoaWrpJWM55b8ABtBElRO69G3PSRHpeeJHkyr/i7N6L0jREJOwJv/R+7qdqzDOFDSTKslDdPQipMEtLCM2bTXjhfMyZMzKDBDHqFvTsMYhdL6Ea/h+qbTvKcsCIeEpox1acOnkHPtqVNjjdoGxEuAC94mq0UZ9DlM6BQPzU3s+nEKW8mA4Mnd4iJKh0BKs4ypgDmZkNrxwJwjSPkn7wPguRKUeansxWIHThNS2E5yF7fr1XldQIQtoDV97Nre+5Mh9xxg3w+pdeOz3qnaQf08c0hXIk+vEKu/j4nAKDdmePhQKU5kYQusA5RhO9F5E2enZHN9++7RJmjCk5rZrV9c2dyLQHPVDbSinyogbVw/sGxCkUKzfu50inRShkZgbTp+PU9d4DFJCyJD3dFmhwWW0xS66t5coJZQTTSnOOVPzm9XqSliRoDhx1qfD6WzkszhUXDiw3eDxyIkGyowH2tR2nOEh6fWjf4W56Ui4MlSU2TcOceSnG+FpCV84l+epfsd58G2dXI7K1DTQNFTC9G7Oug6YNOOGspATXBdv2NlciohECY6oJTJlM4Mq5BGdMQeT3r3gnCiah59WiRsxG7fkrsukNVPt2VOoIXrJqwJte13S8vLRjeqAA0l6ftL1SmMpF6AFEVilaUR2ibC5i+MxPvcLax0Yc5VF7BwYwmBzlJB87o3acH/7Rh5X3u/0oLyTd/rFfuKP70Ps84QywLpt2G45uDpk5z6eZMx5ycgYDY8+lChsMogEXQjCqOJuscIDOHrufXKiLIpl0wHb54rVj+fKcMeRET01OUyk42NnNlr1tOK43NSVl3x+IK73njSyKM25Ef3nC/zarhkTK4a36FpIJCwI64aCOoevoYoD7cHo9XCrPs7ccibQckIpwVojLLizm1hmjuPbiMobFwxmZWMdVvF1/gBfebASEF5l+zK9eCEF3yiZkalxaU3hS9bljyYmY5EZM9jZ1YAf6R/wLIUBCw6EOEqkTywmej4jcHALXXU1g1gzsd9djv/Me9oaNODt24jYdQHZ1obp7UFL1/QEpIF0NSQQCiOxsjOIi9KoqzEkTCFw8CeOiz3hpaydCCyBKLkcUz0Ac3oBqeQ918F1U2zZUYj9Y7eB2o6Tz0fT60TKDQkNoJpgRCJcj4iPR8icgiiYjCi+CyOnNuHy66b29913aAsjU/AQGzPnrNfQDvfYEZkOhjrK/J0unOc7/Bzyu+u4JxbmsZHW+oAmv3PqZsYWZKZgzhKcUeK4Y1LnVsoII+VlBOlp6SKZTyXo9XdMUjC3N4a45NSycVklZ3qm6hZ4RfXt7MzuaO7EkuFLr8wMRCBzLRRiC6uJ4P811gWD+5JFMri5kfcNh/rhuN2/VH2Jfazed3SnPW+v9nNM5iJ5KjwamTjRkUJ4donp4NrPGFTOtpojy/Bgj8iKEj5me7kxa/Gp1PZ1HkohoMK3cdqyFBZmwqBlbyI2XVJzWNQbIiQbIi5nQY5M8rrKbYufBTjqTp1sA+zwiK4Z5+WWYl1+GbGrG/XAHclcj7u49uE0HcNuPoLq7wU6vU5oGWiSClpuNVlyMXlGKUVGBNnoUWkl/XYCTohmIwjpEYR2MakO174CunajO3dC1D5Vq9XK3peWJUmgGGCEIZKOFiyCrzPOy46MQ8VGDeml8fIY8CtAE2VGD7LCGHOTKqt4gyUREokcdGLzWNXTCRpTAOSw0NKgG/OKqIn6+aDoH2lOEg33LjoWDGiPyYtSW5vQzeidGoAkYMyKPZ++ZhRd30j8E3XG91LIJpQOvqUeDBtXF2VQXZzN1dBFN7T00t3Wzpy1BS0eKRNLGdmXaZutEAwZZIYO8rBAF8RB50SB5sSAled768/EImgY3TxvFFeNHYOjawANxAUlbUlkYZXxF/2nckzGyMM73PlfHjlljvLz0Ac7hSEnQ0KgoOHl+/VBAG16MNrwYLrsUANXdjersgu4eb5ocwDQR0TAilgWRgQspfGwCuYiiOiiq87590gK7w1vXdlN9DbiZ5W0+g8g/c/c9V689QVvp3TOSATVUcCToGuV5IUIadMtBvNZKenEMBXkYoyozxwYHgSVThI0IxeFydHEWCzMdw6Aa8MJ4mGsmDX5tWyGgZnjOaQW8nYjyglhGQlUqRY/lYjtuRkdd1zRMXSNgCAz99KQrwwGdayadmqrcxyUWMpk1roRZ487oac5rRCSCiJxDdTItAMEC8FO2zyLnwhCfoTXO8zu9+MwjgIRNZXGcS8q9oOPBkyYVKOWijB7MyZ9BL0pn+AxS+0JodNpt1ORUUR6vHpQ2Py7nf3jyGUYTwtMLHyTN8E/zgNpn8LAsi46ODuLxOIGzWXrV5+wwGKkwQxWBF7SUcrlibAFXjy8a3PaV8FL9AjrRb9yOiPUX9fq4CASudEg5CS4puYJx+ZMHre2Pgx8C6fOJp7Ozk02bNtHS0nKuu3JKSCnZsmULDz/8MFu3bj0viib4DDK9aeFD8KPtzcjpDQ0caBvwRYJ0/q2Egwkum1DE3bNHEj9O6eTT61Q6Ek5pSLsVJXqIL/lXQjOnplMQT/6ejud89UrG6kLHcW12d+1kauk8rii/iZAxeIODj4NvwH0+8dTX17No0SJWr159rrtySmiaxo4dO3jqqaeor6/3DbjPeYNUXuElx3axXBfLcb1CTI4kld4sRyId6a1xu+nNcqHHhsPdkLCYe3EJ318wlrqqvsuiSkmk6yJdF+W6KHkKmyORSRv3SDt2ci9abpTsb32B+OI7EWbgqL4rXOl6Qcvyo82RLlZ6c6SLIx3c3k252K5NwkrQ3NNEh93KrPIruaP2G1Rln/s1zE/9FLrP2eXAgQMZg3TgwAFM06SyspJgMMiuXbs4cuQI8XiciooKTPOjYMHW1lb27duHlJJhw4YBXrpcQUEBuq7T2dnJ7t276enpIRwOU1RURG5uLkeOHGH9+vWsW7eO9957j0mTJhEMBikr82I1UqkUDQ0NdHV1EY/HqaysxEjL8DY3N6NpGpZlcejQIQoLCyktLUVKyd69ezl8+DCaplFYWEhhYSGmaWLbNnv27KGtrY2cnBxycnJIJpPE43Gi0SgtLS1YloUQgkOHDlFUVERJSQmO49DY2EhHRwfRaJRAIIAQgmDQX2T3OX9QSuFaDnTbJLsdHF0hXYFrKFw9HSem4603Ky+dFR2EoZEdDVNdkcX02uHcObuKiSNz+7XtWBbJrgQhKdCFhnDxKotJ0NKVxzTpFRLTlMCRXmETXYFRmEXWxIvIvfEqsm+9Hi2nb/uulDhOEuwk2ClPeU8BQmEBSpOekVcKRykCCoK4BDRFTjDM6HgtU4rruKH6c4zOHnuWrviJ8Q24z1lDKcXSpUvZvXs3oVCINWvWYNs2ixcvpqCggGeffZatW7cyfPhwHnjgAa677jqCwSA7duzgZz/7GX/+858xDINp06ZhWRaVlZU8+OCDWJbFk08+yfLly0kmk4TDYa6++moWL17MqlWr+P73v49pmqxYsYJ3332XCy64gKVLl9LV1cVzzz3Hc889R0dHB7m5udx7773cdNNNhEIhfvKTn9DS0kIikWDNmjXcd9993HXXXaxatYqnnnqKbdu2Yds2c+fO5eGHH6akpISXXnqJpUuX0tDQwPjx4xk5ciSdnZ3cdtttzJw5k1/84hds2LCBSCTChg0b+MpXvsI999zD8uXLWbp0Ka2trYwcObLfAMbH53ygpCTODddOYFxtCdHcLK/imK6hdB2peY/oAqXr3iY0NE0nKxJkREEW08YUclntwCmdhhmgrHYcdfOvJxIIERAapoSABEOB6YIphbevwFQCQyoMUyOcHSE6ZhTxqy4nVD1wymZFbjE3XXgFu8priYSj3vqF7qnz6elHoaU19nWFIcDQJOGgTkW8hIuLLmJy8bQzeXlPG9+A+5xV1q1bx8qVK5k6dSrXXnstr776KosXL8YwDK699lrmz5/Pb3/7WxYvXkx1dTWjR49myZIlvPLKK9xwww1UVVWxcuVKNm/ezHXXXYdhGDz//PM89NBDzJ49mwULFvDuu+/S3NxMKpUiJyeHgoICmpqaiMfjFBUVUVBQgJSSFStW8LWvfY358+dzyy238OKLL3LnnXcybNgw5syZw7p161i9ejWzZs1i3rx5zJw5k9WrV7No0SJCoRALFy5k7969HDx4kEQiwWuvvcbdd99Nfn4+N998M/v27ePpp59G0zSuuOIKXNflrbfe4tVXX2XmzJncdNNNTJw4kddee43bb7+dUaNGceONN9LQ0MBvfvMbr6iO5q9y+Zw/jB07gocfuumMtB2MRZm+cAFTF97kpQpnNFjUgHIs3r8UGAYDazL2pa58HHVl4/oGEB4vmPDY55yn+Abc56wSiUTIzc3l97//PaWlpdx5551MmTKF6dOns2zZMsLhMFVVVSxZsoSmpiYaGxtZtWoV9913H4899hgAmzZt4vrrr8+02dLSgqZpXH755dx444184QtfIBqNous6lZWVDBs2jCuvvJJ77rmHRYsWAdDe3s5Pf/pTKioqePzxx4nH41x66aVMmzaNX/3qV8yZM4dgMEh5eTnLli2jtNRLDfzmN7+JEIIXXniBqVOnZvrQ1dXFkiVLiEQi/OEPf2DixIkAPPjggzzxxBOZaXld16muruaVV14hHo/T2trKzTffTGFhIa+//jolJSWZ1/3whz/01799PjUIQOj6mQ3MOlb59tj9gZ57HuMP733OKo7jUFFRQX5ah7yoqAhN05gwYQJ2WpClrKyMWCyG4zhs2rSJSCTC7NmzM22MHTuWuro6urq6sCyL66+/nquuuopHH32U0aNHM2XKFH70ox/R1dUFQEdHB1JKuru7M20kEgkOHjxIZ2cnt956K3PnzuXee+8lLy+PI0eOIKXEsizKy8szr+nq6qKxsZHp06f3OQ7Q1NREc3MzM2bMYOzYj9bHpk6dSn5+Pj09PZljubm5xOOenGtbWxu7d+/m4osvzhhvpRQ33HADmqYhpV/s4hOJPy7zGQR8D9znrOM4DrZtEw6HSaVSgBdM1musHMfx9NyB4cOHY9s29fX1WJaFaZo0NDSwf/9+QqEQ3d3dVFdXs3z5ctavX8/777/P8uXLeeihh8jNzeXuu+9GKYWUEtd1M4/BYJDs7GxCoRDf+ta3ME0zc/6KioqM8bRtO+MFRyIRCgsLaWxspLm5meLiYlzXxXVdotEo+fn57N69m4aGBmpqarAsi8bGRjo7O/vkcvf2Qdd1AoEAhYWF7Nmzh87OTmKxGMlkko0bNyKlzFwHn08YvhKbzyDge+A+Z5Veg3c0Uso+nqZSCsuySCaTXHPNNdTW1vL444+zbNkyNm7cyKOPPsqaNWsyBviNN97gySefpLi4mFtvvZV58+ah6zrJpFetLRaLoes6r7/+OmvXruUvf/kLWVlZLFiwgL1799LR0cEll1zCiBEj2Lp1K6NGjRqwr5qm8fnPf57Nmzfz2GOP8fbbb/Piiy/y7LPPYhgG119/PevWreMHP/gBGzduZPny5TzxxBPYtk0gEOgzkOglPz+fBQsW8MEHH3D//ffzzjvv8PLLL/O9733PK32bNuCJRALHcfDx8fHpxffAfc4q0WiUWOyjQjZCCGKxGMFgMGOsDMMgOzub7u5uioqKeOSRR1iyZAlf+tKX0HWdqqoq8vPzM+1s2bKF73znO3z3u9/NGMrbbruNO+64A4CamhoWLlzIsmXLWLFiBePHj+eyyy7j/vvvp76+ni9/+ctEo1F6enooLi5m3rx5TJ48maysLDRN6+MFf/3rX+fQoUM89dRTPP/880gpGTNmDHV1dSxZsoQ9e/bw5JNP8utf/5phw4YRjUYzHr0Qgkgk0uf9RyIRFi1axPbt2/nlL3/JM888QywWo6amhmQySSAQQErJ008/zZQpU5g8eXJmPd1nCKPhVSf1p9J9/gmE8qNkfM4i27Ztw7Isxo4di2EY2LbNhg0bKCgooKysDMMwaGlpYefOnYwcOZKiIk9m8eDBg6xZswbXdZk8eTKO45BKpaiursYwDD788EPeffddEokE48aNo66uro+hSyQSrF69mvb2diZNmsTYsWMzEd5r1qxh+/btFBYWMnXqVAoKPO3kLVu2IKWkpqamn5zp5s2bee+99wgGg0yePJmKigqEEDiOw/r169m8eTMXXHABVVVVHDx4MBP9Xl9fj+M41NbW9hkYSClZu3Yt27dvZ/To0dTW1rJt2zYuuOACIpEIq1atYvTo0VRVVaGfpj7/+UTe99fSnvRnEpRQIG0qsyPs/B/nVo7TZ+jiG3AfH5+zxpgfr6e1xzfgCgXKM+Br7510rrvjM0TxDbiPj4+Pj88QxA9i8/Hx8fHxGYL4BtzHx8fHx2cI4htwHx8fHx+fIYhvwH18fHx8fIYgvgH38fHx8fEZgvgG3MfHx8fHZwjiG3AfHx8fH58hiG/AfXx8fHx8hiC+Affx8fHx8RmC+Abcx8fHx8dnCOIbcB8fHx8fnyGIb8B9fHx8fHyGIL4B9/Hx8fHxGYL4BtzHx8fHx2cI8v8Bq0X5p17I6hsAAAAASUVORK5CYII=\" data-filename=\"Full Payment.png\"></p>', 'uploads/product_cover_1695101187.jpg', 120.00, 22, 15, 1, 1, 0, 0.00),
(185, 'ขนมแปปไข่เค็ม', 'ขนมไทยโบราณที่ได้ออกแบบการสอดไส้ที่ประยุกต์จากไข่เค็มมีรสชาติหอมหวานเค็มแบบกลมกล่อม เคี้ยวเพิลนอย่าบอกใคร', 'uploads/product_cover_1695101762.jpg', 35.00, 22, 27, 1, 1, 0, 0.00),
(186, 'สบู่น้ำมันรังไหม', 'มีคุณสมบัติในการบำรุงผิวหน้าจากโปรตีนไหม เหมาะที่จะนำมาทำความสะอาดผิวหน้าอย่างอ่อนโยนช่วยให้ผิวหน้านุ่ม', 'uploads/product_cover_1688353699.jpg', 35.00, 12, 0, 1, 1, 0, 0.00),
(187, 'ไข่เค็มหมักสมุนไพรเชียงเคี่ยน', 'ไข่เค็มออแกนิคจากฟาร์มที่รสชาติกลมกล่อมแบบมันๆไม่เค็มจนเกินไป สด สะอาด อร่อย', 'uploads/product_cover_1695101519.jpg', 35.00, 22, 0, 1, 1, 1, 30.00),
(188, 'กระเป๋าสานพลาสติกลายหัวใจ สีม่วง By บงกช', 'สวยเก๋ๆไม่ซ้ำกับใคร มีคุณภาพ เป็นสินค้างาน Handmade ทุกใบ รับประกันความแข็งแรง ทนทาน', 'uploads/product_cover_1695092998.jpg', 150.00, 23, 0, 0, 1, 0, 0.00),
(189, 'หมวกถักสีขาว', 'จะฤดุกาลไหนๆก็สวมใสได้กับคุณผู้หญิง', 'uploads/product_cover_1688711237.png', 199.00, 23, 87, 1, 1, 1, 100.00),
(190, 'พระแก้วมรกตหยกขาว หน้าตัก 4 นิ้ว', 'พระแก้วมรกต หยกขาวมุก หน้าตัก 4 นิ้ว จาก กลุ่มแกะสลักหินหยกเวียงพางคำ อำเภอแม่สาย สำหรับใครที่อยากได้องค์พระแก้วมรกตแบบหยกมุกขาวสวยๆสง่างามแนะนำจากที่นี่เลยค่ะเขามีการออกแบะและแกะสลักหินหยกที่มีความละเอียดและใส่ใจทุกรายละเอียดในการสร้างสรรค์ผลงาน', 'uploads/product_cover_1692846181.jpg', 25000.00, 23, 6, 1, 0, 1, 12500.00),
(191, 'หมอนปักลายม้ง จื้อผ้าม้ง', 'หมอนปักลายม้ง จื้อผ้าม้ง', 'uploads/product_cover_1688713697.jpg', 100.00, 23, 9, 1, 0, 0, 0.00),
(192, 'น้ำมันมะพร้าวสกัดเย็น', 'น้ำมันมะพร้าวสกัดเย็น100%', 'uploads/product_cover_1688704039.png', 150.00, 12, 8, 1, 0, 0, 0.00),
(193, 'ย่ามชนเผ่าไทลื้อสีกรม', 'ย่ามสะพายเก๋ๆ จากกลุ่มทอผ้าบ้านท่าข้าม สวยเด่น เป็นเอกลักษณ์ ปักมือทั้งชิ้น ไม่เหมือนใคร', 'uploads/product_cover_1687404280.jpg', 250.00, 23, 9, 0, 0, 0, 0.00),
(195, 'น้ำผึ่งธรรมชาติณัฐชา', 'หากพูดถึงน้ำผึ้งหลายๆ คนคงนึกถึงเมนูที่ต้องรับประทานกับน้ำผึ้ง หรือมีน้ำผึ้งเป็นส่วนผสมสำคัญ อย่างเช่น กาแฟ หรือเมนูขนมปังต่างๆ หรือนำมาประกอบอาหารก็ย่อมได้ โดยสามารถทดแทนความหวานจากน้ำตาลได้', 'uploads/product_cover_1695096955.jpg', 250.00, 22, 8, 0, 0, 0, 0.00),
(196, 'น้ำอ้อยสด สวนภูขีด', 'บอกเลยว่าใครที่ซื้อน้ำอ้อยของที่นี่ไป รับรองว่า จะได้รับถึงความหอมและหวานอย่างเป็นธรรมชาติ และได้คุณประโยชน์ต่อร่างกายอีกมากมาย ไม่ว่าเป็น ช่วยในการต่อต้านอนุมูลอิสระ เติมความสดชื่น มีวิตามินซี และแคลเซียมสูง', 'uploads/product_cover_1695090552.jpg', 10.00, 9, 7, 0, 0, 0, 0.00),
(199, 'แก้วมัคลายนักษัตร ปีฉลู', 'ใช้สำหรับนำมาตกแต่งหรือนำมาเป็นของฝากในโอกาสและเทศกาลต่างๆ เหมาะสำหรับใช้งานนำมาดื่มชาหรือกาแฟร้อนๆ', 'uploads/product_cover_1684378356.jpg', 250.00, 23, 9, 0, 0, 0, 0.00),
(200, 'กระต่ายไม้ประดู่', 'งานหัตถกรรมจากไม้ประดู่ ใช้ตกแต่งบ้าน สวยงาม ไม่เหมือนใคร อีกทั้ง กระต่ายยังเป็นสัญลักษณ์ของความอุดมสมบูรณ์ อายุยืนยาว โชคลาภหนุนนำ จึงเป็นสิริมงคลแก่ผู้ที่ได้มาครอบครอง', 'uploads/product_cover_1619934086.jpg', 2500.00, 23, 10, 0, 0, 0, 0.00),
(201, 'พระปางสมาธิ หินหยกพม่า กลุ่มแกะสลักหินหยกเวียงพางค', 'พระปางสมาธิ ทำจากหยกพม่า ฐานดอกบัว ทำจากหินอินเดีย แกะสลักโดยช่างมากฝีมือ', 'uploads/product_cover_1627977014.jpg', 700000.00, 23, 10, 0, 0, 0, 0.00),
(202, 'เจ้าแม่กวนอิมพันมือ หยกทองทวี', 'ทำจากหยกแคนาดา แกะสลักโดยช่างฝีมือประสบการณ์ในวงการหยกแกะสลักกว่า 40 ปี เป็นแหล่งผลิต และมีชื่อเสียงที่สุดในงานแกะสลักพระ และส่งออกกว่า 90%', 'uploads/product_cover_1622474320.jpg', 6500000.00, 23, 10, 0, 0, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_img`
--

CREATE TABLE `product_img` (
  `img_id` int(11) NOT NULL,
  `prd_id` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `img_show` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_img`
--

INSERT INTO `product_img` (`img_id`, `prd_id`, `img`, `img_show`) VALUES
(303, 0, 'uploads/385090449_328557973170617_1294940878206411953_n.jpg', 1),
(279, 0, 'otop_img_21564594046.jpg', 0),
(272, 0, 'product_img//otop_img_21564594046.jpg', 1),
(278, 0, 'otop_img_11564594046.jpg', 0),
(276, 0, '386477894_226269800167054_5382092918508581310_n.jpg', 0),
(277, 0, '385090449_328557973170617_1294940878206411953_n.jpg', 0),
(271, 0, 'product_img//ประเภทกีฬา-66.docx', 1),
(270, 0, 'product_img//otop_img_11564594046.jpg', 1),
(145, 72, 'product_img/72/น้ำมันไพลสด.jpg', 1),
(146, 72, 'product_img/72/ฮันนี่วีนี.jpg', 1),
(144, 72, 'product_img/72/น้ำผึ้ง.jpg', 1),
(143, 72, 'product_img/72/งาขาวคั่ว แบบเมล็ด.jpg', 1),
(139, 72, 'product_img/72/1.png', 1),
(387, 201, 'product_img/201/otop_img_31627977014.jpg', 0),
(388, 201, 'product_img/201/otop_img_11627977014.jpg', 0),
(389, 202, 'product_img/202/otop_img_11622474320.jpg', 0),
(390, 202, 'product_img/202/otop_img_61622474320.jpg', 0),
(391, 203, 'product_img/203/Screenshot_Marseille - Avignon_43.45666-5.31686_13-14-37.jpg', 0),
(392, 204, 'product_img/204/logo.png', 0),
(393, 204, 'product_img/204/Screenshot 2023-05-05 203008.png', 0),
(394, 184, 'product_img/184/bannersirin.jpg', 1),
(395, 184, 'product_img/184/logo.png', 1),
(396, 184, 'product_img/184/Screenshot 2023-05-05 203008.png', 1),
(404, 207, 'product_img/207/Screenshot 2023-12-25 214850.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `pty_id` smallint(6) NOT NULL,
  `pty_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pty_desc` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pty_show` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`pty_id`, `pty_name`, `pty_desc`, `pty_show`) VALUES
(9, 'เครื่องดื่ม', 'เครื่องดื่ม', 1),
(11, 'ของประดับตกแต่ง', 'ของประดับตกแต่ง', 0),
(12, 'สมุนไพร (ที่ไม่ใช่อาหาร)', 'สมุนไพร (ที่ไม่ใช่อาหาร)', 1),
(22, 'อาหาร', 'อาหาร', 1),
(23, 'ของใช้ และของประดิษฐ์', 'ของใช้ และของประดิษฐ์', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ship_info`
--

CREATE TABLE `ship_info` (
  `s_id` int(11) NOT NULL,
  `order_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `mmb_name` varchar(255) NOT NULL,
  `mmb_surname` varchar(255) NOT NULL,
  `mmb_addr` varchar(255) NOT NULL,
  `mmb_phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ship_info`
--

INSERT INTO `ship_info` (`s_id`, `order_id`, `mmb_name`, `mmb_surname`, `mmb_addr`, `mmb_phone`) VALUES
(1, 0000000112, 'Test002', 'Test002', 'Test002', '21100'),
(2, 0000000000, 'Test002', 'Test002', 'Test002', '21100'),
(3, 0000000000, 'Test002', 'Test002', 'Test002', '21100'),
(4, 0000000000, 'Test002', 'Test002', 'Test002', '21100'),
(5, 0000000000, 'Test002', 'Test002', 'Test002', '21100'),
(6, 0000000000, 'Test002', 'Test002', 'Test002', '21100'),
(7, 0000000305, 'Test002', 'Test002', 'Test002', '21100'),
(8, 0000000306, 'Test002', 'Test002', 'Test002', '21100'),
(9, 0000000307, 'Test002', 'Test002', 'Test002', '21100'),
(10, 0000000308, 'Test002', 'Test002', 'Test002', '21100'),
(11, 0000000309, 'Test002', 'Test002', 'Test002', '21100'),
(12, 0000000310, 'Test002', 'Test002', 'Test002', '21100'),
(13, 0000000311, 'Test002', 'Test002', 'Test002', '21100'),
(14, 0000000312, 'Test002', 'Test002', 'Test002', '21100'),
(15, 0000000313, 'Test002', 'Test002', 'Test002', '21100'),
(16, 0000000314, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(17, 0000000315, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(18, 0000000316, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(19, 0000000317, 'ddd', 'ddd', 'wdwd', '00000000'),
(20, 0000000000, 'ddd', 'ddd', 'wdwd', '00000000'),
(21, 0000000319, 'ddd', 'ddd', 'wdwd', '00000000'),
(22, 0000000320, 'ddd', 'ddd', 'wdwd', '00000000'),
(23, 0000000321, 'ddd', 'ddd', 'wdwd', '00000000'),
(24, 0000000322, 'ddd', 'ddd', 'wdwd', '00000000'),
(25, 0000000323, 'ddd', 'ddd', 'wdwd', '00000000'),
(26, 0000000324, 'ddd', 'ddd', 'wdwd', '00000000'),
(27, 0000000325, 'ddd', 'ddd', 'wdwd', '00000000'),
(28, 0000000326, 'ddd', 'ddd', 'wdwd', '00000000'),
(29, 0000000327, 'ddd', 'ddd', 'wdwd', '00000000'),
(30, 0000000328, 'ddd', 'ddd', 'wdwd', '00000000'),
(31, 0000000329, 'ddd', 'ddd', 'wdwd', '00000000'),
(32, 0000000330, 'ddd', 'ddd', 'wdwd', '00000000'),
(33, 0000000331, 'ddd', 'ddd', 'wdwd', '00000000'),
(34, 0000000332, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(35, 0000000333, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(36, 0000000334, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(37, 0000000335, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(38, 0000000336, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(39, 0000000337, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(40, 0000000338, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(41, 0000000339, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(42, 0000000340, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(43, 0000000341, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(44, 0000000342, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(45, 0000000343, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '10101010'),
(46, 0000000344, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '1010101010'),
(47, 0000000345, 'Jsdff11', 'Jsdff11', 'Jsdff11', '5151'),
(48, 0000000346, 'Jsdff11', 'Jsdff11', 'Jsdff11', '5151'),
(49, 0000000347, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(50, 0000000348, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '21100'),
(51, 0000000349, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '10101010'),
(52, 0000000350, 'Test002', 'Test002', 'Test0025/362 ถ.ทางรถไฟฝั่งตะวันตก ซ.เขาพิทักษ์ 2 ต.หัวหิน หัวหิน หัวหิน ประจวบคีรีขันธ์ 77110', '122121');

-- --------------------------------------------------------

--
-- Table structure for table `tourist`
--

CREATE TABLE `tourist` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_des` varchar(1000) DEFAULT NULL,
  `p_addr` varchar(255) DEFAULT NULL,
  `p_img` varchar(255) DEFAULT NULL,
  `p_show` tinyint(1) NOT NULL,
  `p_reccom` tinyint(1) NOT NULL,
  `map` varchar(1000) NOT NULL,
  `time` varchar(60) NOT NULL,
  `contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tourist`
--

INSERT INTO `tourist` (`p_id`, `p_name`, `p_des`, `p_addr`, `p_img`, `p_show`, `p_reccom`, `map`, `time`, `contact`) VALUES
(14, '1111', 'ภูชี้ฟ้าเป็นส่วนหนึ่งของดอยผาหม่น อยู่ห่างจากดอยผาตั้ง 25 กิโลเมตร เป็นจุดชมวิวทะเลหมอกและพระอาทิตย์ขึ้นที่สวยงามราวกับภาพวาดและมีชื่อเสียงเป็นอย่างยิ่งในประเทศไทยมาพร้อมด้วยวิวทิวทัศน์ของภูเขาสลับซับซ้อนดูกว้างไกล นักท่องเที่ยวต่างหลงใหลต้องเดินขึ้นไปชมทะเลหมอกบนยอดภูกันตั้งแต่ฟ้ายังมืด\r\n\r\nภาพของภูเขาสูงที่มีแสงอาทิตย์สีทองสาดจับยามเช้าตรู่ที่มีผืนทะเลหมอกสีขาวโพลนสุดอลังการอยู่เบื้องล่าง คือภาพของภูชี้ฟ้าที่ได้กลายสถานที่ท่องเที่ยวชั้นนำของจังหวัดเชียงราย โดยเฉพาะกับนักเดินป่าท่องธรรมชาติแล้ว ครั้งหนึ่งในชีวิตของพวกเขาต้องได้มาเยือนภูสูงแห่งนี้เลยทีเดียว วนอุทยานภูชี้ฟ้าอยู่สูงจากระดับน้ำทะเลปานกลางราว ๆ 1,200-1,628 เมตร', 'หมู่ 9 บ้านร่มฟ้าทองและบ้านร่มฟ้าไทย เวียงแก่น, เชียงราย', 'place_img/P1.jpeg', 1, 1, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d7505.485588741909!2d100.45368!3d19.850833!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTnCsDUxJzAzLjAiTiAxMDDCsDI3JzEzLjMiRQ!5e0!3m2!1sth!2sus!4v1697636744172!5m2!1sth!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'เปิดทุกวัน 4:30–18:00', '084 807 9848'),
(15, 'ดอยผาตั้ง', 'อยู่ห่างจากภูชี้ฟ้า 25 กิโลเมตร เป็นจุดชมทัศนียภาพไทย-ลาว และชมทะเลหมอกได้ตลอดปี ในเดือนธันวาคม-มกราคม มีดอกซากุระและดอกเสี้ยวบานสะพรั่ง เป็นที่ตั้งของหมู่บ้านชาวจีนฮ่อ ม้ง และเย้า ปัจจุบันชาวบ้านประกอบอาชีพเกษตรกรรมปลูกพืชเมืองหนาว เช่น บ๊วย ท้อ แอปเปิล และชา\r\n\r\nดอยผาตั้งมีจุดชมวิวช่องผาบ่อง เป็นช่องหินขนาดใหญ่ มองเห็นแม่น้ำโขงทอดตัวคดเคี้ยวในฝั่งลาว หากเดินเท้าต่อไปอีก 1 กิโลเมตร จะถึงจุดชมวิว 103 สภาพเส้นทางบางช่วงสูงชัน จุดชมวิวแห่งใหม่อยู่ทางด้านเหนือของดอยผาตั้ง คือจุดชมวิวเนิน 104 สูงประมาณ 1,570 เมตร', 'ม.14 ต.ปอ อ.เวียงแก่น จ.เชียงราย', 'place_img/P2.jpeg', 1, 1, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d7501.685466889373!2d100.519573!3d19.931031!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTnCsDU1JzUxLjciTiAxMDDCsDMxJzEwLjUiRQ!5e0!3m2!1sth!2sus!4v1697636500986!5m2!1sth!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'เปิด 24 ชั่วโมง', '084 764 7166'),
(16, 'น้ำตกขุนกรณ์', 'ตั้งอยู่บนเทือกเขาดอยช้าง ตำบลแม่กรณ์ หน่วยพิทักษ์อุทยานแห่งชาติลำน้ำกก ที่ 1 ในเขตอุทยานแห่งชาติลำน้ำกก น้ำตกขุนกรณ์มีความสูง 70 เมตร สองข้างทางเดินเข้าสู่น้ำตกเป็นป่าร่มรื่น บริเวณศูนย์บริการนักท่องเที่ยวน้ำตกขุนกรณ์มีลานกางเต็นท์และห้องน้ำไว้บริการ แต่ยังไม่มีไฟฟ้า ถ้าจะเช่าอุปกรณ์กางเต็นท์ต้องติดต่ออุทยานฯ ล่วงหน้า การเดินทางจากที่ทำการหน่วยพิทักษ์อุทยานฯ ต้องเดินเท้าไปยังตัวน้ำตกอีก 30 นาที ระยะทาง 1,400 เมตร เปิดให้เข้าชมทุกวัน เวลา 08.00-16.30 น. สอบถามข้อมูล โทร. 08 1387 5354 และ 0 5371 1402 ต่อ 701 องค์การบริหารส่วนตำบลแม่กรณ์ โทร. 0 5372 6368', 'เมืองเชียงราย, เชียงราย', 'place_img/P3.jpeg', 1, 1, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d12620.140512750597!2d99.61696705429962!3d19.88263476486711!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTnCsDUyJzU3LjEiTiA5OcKwMzYnNTkuMCJF!5e0!3m2!1sth!2sus!4v1698745306526!5m2!1sth!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'เปิดทุกวัน 09.00-16.30 น.', '+66 5371 1402'),
(22, 'วัดพระธาตุผาเงา', 'ความศักดิ์สิทธิ์ของวัดพระธาตุผาเงาตามความเชื่อของชาวบ้านนั้น เชื่อกันว่าหากใครเจ็บไข้ได้ป่วยแล้วมาสักการบูชาที่วัดนี้ อาการป่วยก็จะทุเลาลงและหายในที่สุดอย่างน่าอัศจรรย์ใจ\r\n\r\nตั้งอยู่ที่บ้านสบคำ ตำบลเวียง สันนิษฐานว่าเป็นวัดที่สำคัญในสมัยอาณาจักรโยนก มีเจดีย์ทรงระฆังขนาดเล็กตั้งอยู่บนหินก้อนใหญ่และพระพุทธรูปหลวงพ่อผาเงา ค้นพบในปี พ.ศ. 2519 มีอายุระหว่าง 700-1,300 ปี บนยอดเขาข้างหลังวัดเป็นที่ตั้งพระบรมธาตุพุทธนิมิตเจดีย์ เป็นจุดที่มองเห็นทิวทัศน์สวยงามได้โดยรอบ ในบริเวณด้านหน้าวัดมีพิพิธภัณฑ์ผ้าทอล้านนาเชียงแสน เป็นบ้านไม้โบราณสองชั้น ชั้นล่างเป็นใต้ถุนโล่งสำหรับกลุ่มแม่บ้านสบคำใช้ทอผ้า ส่วนชั้นบนจัดแสดงผ้าโบราณและของใช้ ตลอดจนโบราณวัตถุที่ถูกค้นพบภายในบริเวณวัดและหมู่บ้านใกล้เคียง', 'เชียงแสน, เชียงราย', 'place_img/P4.jpeg', 1, 4, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d7486.703336616626!2d100.10812900000002!3d20.244245!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjDCsDE0JzM5LjMiTiAxMDDCsDA2JzI5LjMiRQ!5e0!3m2!1sth!2sus!4v1697636692764!5m2!1sth!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'เปิดทุกวัน 6:00–18:00', '+66 5360 2742'),
(36, 'หอนาฬิกาเฉลิมพระเกียรติฯ', 'ตั้งอยู่ตรงวงเวียนบนถนนบรรพปราการ ตัดกับถนนสุขสถิตย์และถนนเจ็ดยอด สร้างขึ้นตั้งแต่ปี พ.ศ. 2548 เพื่อเป็นการเฉลิมพระเกียรติสมเด็จพระนางเจ้าฯ พระบรมราชินีนาถ พระบรมราชชนนีพันปีหลวง ออกแบบโดยอาจารย์เฉลิมชัย โฆษิตพิพัฒน์ ศิลปินแห่งชาติ เป็นสีทองประดับลวดลายงดงามเป็นเอกลักษณ์ และใช้เทคนิคพิเศษที่ทำให้หอนาฬิกามีความสวยงามในยามค่ำคืน เป็นหอนาฬิกาที่สวยที่สุดของประเทศไทย มีการแสดงแสง สี เสียง เป็นเวลา 10 นาที ทุกวัน วันละ 3 เวลา คือ เวลา 19.00, 20.00 และ 21.00 น.', 'เมืองเชียงราย, เชียงราย\r\n\r\n', 'place_img/P03009077_1.jpeg', 1, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m13!1m8!1m3!1d7502.820199408312!2d99.830947!3d19.907116!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTnCsDU0JzI1LjYiTiA5OcKwNDknNTEuNCJF!5e0!3m2!1sth!2sus!4v1698065153219!5m2!1sth!2sus\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'เวลา 19.00-21.00 น.', '053-150192'),
(37, 'วัดร่องขุ่น', 'ออกแบบและก่อสร้าง โดยอาจารย์ เฉลิมชัย โฆษิตพิพัฒน์ เมื่อ พ.ศ. 2540 โดยบนพื้นที่เดิมของวัด 3 ไร่ และขยายออกเป็น 12 ไร่ อุโบสถประดับกระจกสีเงินแวววาววิจิตรงดงามแปลกตา ภายในอุโบสถมีภาพจิตรกรรมฝาผนัง โดยเฉพาะภาพพระพุทธองค์หลังพระประธานซึ่งเป็นภาพที่ใหญ่งดงามมาก\r\n\r\nตั้งอยู่ในตำบลป่าอ้อดอนชัย ออกแบบและก่อสร้างโดยอาจารย์เฉลิมชัย โฆษิตพิพัฒน์ พระอุโบสถสีขาวตกแต่งลวดลายด้วยกระจกสีเงินเป็นเชิงชั้นลดหลั่นกัน หน้าบันประดับด้วยพญานาครูปลักษณ์แปลกตา ภายในพระอุโบสถมีภาพจิตรกรรมฝาผนังเป็นฝีมือภาพเขียนของอาจารย์เฉลิมชัย ด้านนอกมีห้องนิทรรศการภาพวาด หอศิลป์ และห้องแสดงภาพ สามารถเข้าชมภาพศิลปะของอาจารย์เฉลิมชัยได้ทุกวัน เปิดให้เข้าชมทุกวัน เวลา 08.00-18.00 น. ค่าเข้าชม ชาวต่างชาติ ราคา 100 บาท สอบถามข้อมูล โทร. 0 5367 3579', '60 หมู่ที่ 1 ถ. พหลโยธิน ป่าอ้อดอนชัย อำเภอเมืองเชียงราย เชียงราย 57000 ', 'place_img/P03002390_1.jpeg', 1, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3753.369346036914!2d99.7605793749975!3d19.824319181540535!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d70e54b2e18761%3A0xb3495716c9ffd4ac!2z5riF6I6xIOeZveW6mQ!5e0!3m2!1sth!2sth!4v1698583474805!5m2!1sth!2sth\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'เปิดทุกวัน 08.00-18.00 น.', '+66 5367 3579'),
(38, 'วัดพระแก้ว', 'เป็นวัดที่ค้นพบพระแก้วมรกต หรือพระพุทธมหามณีรัตนปฏิมากรที่ประดิษฐานอยู่ ณ วัดพระแก้ว กรุงเทพฯ ในปัจจุบัน ปัจจุบันวัดพระแก้วเชียงรายเป็นที่ประดิษฐานพระหยก\r\n\r\nตั้งอยู่ริมถนนไตรรัตน์ ตำบลเวียง เป็นวัดที่ค้นพบพระแก้วมรกต หรือพระพุทธมหามณีรัตนปฏิมากร (ปัจจุบันประดิษฐานอยู่ที่วัดพระศรีรัตนศาสดารามกรุงเทพฯ) ตามประวัติเล่าว่า เมื่อ พ.ศ. 1897 สมัยพระเจ้าสามฝั่งแกนเป็นเจ้าเมืองเชียงใหม่นั้น เกิดฟ้าผ่าเจดีย์ร้างองค์หนึ่ง และได้พบพระพุทธรูปลงรักปิดทองอยู่ภายใน ต่อมารักที่เคลือบไว้กะเทาะออก จึงได้พบว่าเป็นพระแก้วมรกต ภายหลังจากที่อัญเชิญพระแก้วมรกตมาประดิษฐานที่กรุงเทพฯ แล้วชาวเชียงรายก็ได้สร้างพระแก้วมรกตองค์ใหม่ขึ้นแทน เรียกว่า “พระหยกเชียงราย” หรือพระพุทธรัตนากรนวุติวัสสานุสรณ์มงคล ซึ่งสร้างขึ้นในโอกาสที่สมเด็จพระศรีนครินทราบรมราชชนนีมีพระชนมายุครบ 90 พรรษา เมื่อวันที่ 21 ตุลาคม พ.ศ. 2533 ประดิษฐานในพระอาราม “หอพระหยก” ภายในบริเวณวัดพระแก้วยังมี “โฮงหลวงแสงแก้ว” เป็นอาคารสองชั้น สร้างด้วยคอนกรีตเสริมเหล็ก ประกบไม้สักทั้งภายในและภายนอก ทรงล้านนาประยุกต์ เป็นพิพิธภัณฑ์ที่จัดแสดงพระพุทธรูปที่สำคัญข', '19 หมู่ 1 เวียง เมืองเชียงราย เชียงราย 57000', 'place_img/P03002349_1.jpeg', 1, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3751.302255979943!2d99.82511907499988!3d19.911663831472673!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d70663b6684633%3A0xcff6ffeb06d33768!2zMTkg4Lir4Lih4Li54LmI4LiX4Li14LmIIDEg4LiW4LiZ4LiZIOC5hOC4leC4o-C4o-C4seC4leC4meC5jCDguJXguLPguJrguKXguYDguKfguLXguKLguIcg4Lit4Liz4LmA4Lig4Lit4LmA4Lih4Li34Lit4LiH4LmA4LiK4Li14Lii4LiH4Lij4Liy4LiiIOC5gOC4iuC4teC4ouC4h-C4o-C4suC4oiA1NzAwMA!5e0!3m2!1sth!2sth!4v1698587256569!5m2!1sth!2sth\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', ' 07.00-17.00 น.', '+66 5371 1385'),
(39, 'สามเหลี่ยมทองคำ', 'อยู่ห่างจากอำเภอแม่สาย 28 กิโลเมตร ตามทางหลวงหมายเลข 1290 เป็นบริเวณที่แม่น้ำโขงและแม่น้ำรวกมาบรรจบกัน หรือที่เรียกว่า สบรวก\r\n\r\nดินแดนที่นักท่องเที่ยวจะได้ชมวิวสามประเทศ ได้แก่ ไทย ลาว และเมียนมาร์ ตรงบริเวณสบรวก สามเหลี่ยมทองคำในอดีตนั้นคือแหล่งค้ายาเสพติดระดับโลก แต่ปัจจุบันได้กลายเป็นแหล่งท่องเที่ยวยอดนิยม ที่แต่ละปีมีนักท่องเที่ยวไปเยือนกันมากมาย กิจกรรมน่าทำ นมัสการพระเชียงแสนสี่แผ่นดิน หรือ พระพุทธนวล้านตื้อ ประทับนั่งบนเรือแก้วกุศลธรรมขนาดใหญ่ ประดิษฐานกลางแจ้ง องค์พระนั้นสร้างขึ้นด้วยทองสัมฤทธิ์ขนาดใหญ่ ชมวิวสามประเทศบริเวณสบรวก นั่งเรือหางยาวล่องไปตามลำน้ำเพื่อชมทิวทัศน์สามเหลี่ยมทองคำในอีกมุมมอง โดยใช้เวลาประมาณ 20 นาที อีกทั้งยังสามารถเช่าเรือจากสบรวกไปเชียงแสนและเชียงของได้ โดยใช้เวลา 40 นาที และ 1 ชั่วโมงครึ่ง ตามลำดับ ถ่ายภาพที่ระลึกกับซุ้มซึ่งมีฉากหลังที่สวยงาม ช็อปปิ้งในร้านจำหน่ายสินค้าที่ระลึกที่ตั้งเรียงรายตลอดแนวทั้งเสื้อผ้า เครื่องประดับ ของที่ระลึก และสินค้าจากประเทศจีน', '370 ถนน ท่าแพ, ตำบล เวียง อำเภอ เชียงแสน เชียงราย 57150', 'place_img/6f3ca390-092f-11eb-8c17-5bb542a40882_original.jpg', 1, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3740.7267162219737!2d100.08037917501221!3d20.35290538113269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d6433572d60e31%3A0x688e18d8fad87e4f!2z4Liq4Liy4Lih4LmA4Lir4Lil4Li14LmI4Lii4Lih4LiX4Lit4LiH4LiE4Liz!5e0!3m2!1sth!2sth!4v1698746794575!5m2!1sth!2sth\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '-', '-'),
(40, 'อุทยานศิลปะวัฒนธรรมแม่ฟ้าหลวง', 'อุทยานศิลปะและวัฒนธรรม บนเนื้อที่กว่า 150 ไร่ กลางเมืองเชียงราย เป็นที่เก็บรักษาศิลปะวัตถุอันล้ำค่าของวัฒนธรรมล้านนา เชิญนมัสการพระพุทธรูปศักดิ์สิทธิ์ในหอคำ ชมงานนิทรรศการเรื่องไม้สัก พร้อมชมงานศิลปะพื้นบ้านในหอแก้ว ล้อมรอบตัวด้วยบึงน้ำอันสงบเงียบ มีสวนไม้หอมและพฤกษานานาพรรณ\r\n\r\nหรืออีกนามหนึ่งว่า \"อุทยานศิลปวัฒนธรรมล้านนา มูลนิธิแม่ฟ้าหลวง\" ซึ่งเป็นแหล่งท่องเที่ยวเชิงศิลปวัฒนธรรม นอกจากการเป็นสถานที่จัดการศึกษาแก่เยาวชนชาวเขาเพื่อให้พวกเขาได้นำความรู้ที่ได้กลับไปพัฒนาชุมชนต่อไป ตามพระราชดำริของสมเด็จพระศรีนครินทราบรมราชชนนี ไร่แม่ฟ้าหลวงนั้นได้รับการสร้างสรรค์ขึ้นมาภายใต้แนวคิด \"อุทยานแห่งความสงบงามอย่างล้านนา\" ที่มีบรรยากาศภายในอบอวลด้วยความงดงามแบบล้านนาดั้งเดิม น่าชม หอคำ สถาปัตยกรรมสไตล์ล้านนาโบราณที่สร้างด้วยไม้สักทั้งหลัง ภายในจัดแสดงสัตภัณฑ์หรือเชิงเทียนบูชาไม้แกะสลักโบราณและเป็นที่ประดิษฐานพระพร้าโต้ พระไม้โบราณของล้านนา ตลอดจนพระพุทธรูปอื่น ๆ ทั้งศิลปะแบบล้านนาและพม่า หอคำน้อย อยู่ถัดจากหอคำไปประมาณ 500 เมตรเป็นสถานที่เก็บรักษาจิตรกรรมฝาผนังเขียนสีฝุ่นบนกระดานไม้สักที่เรียกว่า', 'รอบเวียง เมืองเชียงราย เชียงราย 57000', 'place_img/P03002884_1.jpg', 1, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7502.864442431668!2d99.79543599999997!3d19.90618299999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d705cafbeca8d7%3A0xf0d9e491e4db01c7!2z4Lib4LmI4Liy4LiH4Li04LmJ4LinIOC4reC4s-C5gOC4oOC4reC5gOC4oeC4t-C4reC4h-C5gOC4iuC4teC4ouC4h-C4o-C4suC4oiDguYDguIrguLXguKLguIfguKPguLLguKI!5e0!3m2!1sth!2sth!4v1698747162548!5m2!1sth!2sth\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '08.00-16.30 น. ', '+66 5371 6605'),
(41, 'ดอยหัวแม่คำ', 'งอยู่ในตำบลแม่สลองใน ระหว่างชายแดนไทย-เมียนมา มีความสูงจากระดับทะเลปานกลาง 1,850 เมตร เป็นที่ตั้งหมู่บ้านชาวไทยภูเขาขนาดใหญ่ ประกอบด้วยเผ่าลีซอ อาข่า ม้ง และมูเซอ ในช่วงที่ตรงกับวันตรุษจีนของทุกปี ชาวลีซอจะจัดงานประเพณี “กินวอ” ซึ่งเปรียบเสมือนวันขึ้นปีใหม่ จะมีการแต่งกายสวยงาม การกินเลี้ยงเต้นระบำ 7 วัน 7 คืน\r\n\r\nในช่วงเดือนพฤศจิกายน ดอยหัวแม่คำจะปกคลุมไปด้วยดอกบัวตองบานเหลืองทองอร่ามรอบหมู่บ้าน จากบนยอดดอยสามารถมองเห็นทิวทัศน์ของฝั่งเมียนมาได้ชัดเจน และเป็นจุดชมพระอาทิตย์ขึ้นและชมทะเลหมอกที่สวยงาม นอกจากนี้ บนดอยยังมีศูนย์ส่งเสริมเกษตรที่สูงหัวแม่คำสถานที่เพาะปลูกพันธุ์ไม้เมืองหนาว เช่น กล้วยไม้ เยอบีรา คาราลิลี สนหอม คาร์เนชัน ทิวลิป และกุหลาบพันปี ซึ่งทางศูนย์ฯ จะมีการถ่ายทอดเทคนิคการเลี้ยงดูและการเกษตรให้แก่ผู้ที่ไปเยี่ยมชมด้วย วนอุทยานดอยหัวแม่คำตั้งอยู่ห่างจากหมู่บ้านไปประมาณ 2 กิโลเมตร เป็นจุดชมวิวพระอาทิตย์ขึ้นและจุดชมทะเลหมอกที่สวยงาม และน้ำตกหัวแม่คำเป็นน้ำตกขนาดกลางที่ไหลลงมาจากหน้าผาสูงประมาณ 20 เมตร เป็นแหล่งน้ำสำคัญของชุมชนบนดอยหัวแม่คำ', 'แม่สลองใน แม่ฟ้าหลวง เชียงราย 57110', 'place_img/P03025227_1.jpeg', 1, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59848.76872054481!2d99.44731570802095!3d20.36028131826804!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d6c162c4b0c17f%3A0xfb09c663cccd4833!2z4Lit4Li14LiB4LmJ4Lit4LmC4Lib4LmI4LiH4LmE4LiuIOC4leC4s-C4muC4pSDguYHguKHguYjguKrguKXguK3guIfguYPguJkg4Lit4Liz4LmA4Lig4LitIOC5geC4oeC5iOC4n-C5ieC4suC4q-C4peC4p-C4hyDguYDguIrguLXguKLguIfguKPguLLguKIgNTcxMTA!5e0!3m2!1sth!2sth!4v1698747329834!5m2!1sth!2sth\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '08:30 - 16:00', ' 08 9554 8175'),
(42, 'ภูชี้ดาว', 'ตั้งอยู่ที่บ้านร่มโพธิ์เงิน ตำบลปอ เป็นจุดชมทะเลหมอกแบบ 360 องศา โดยมีฉากหลังที่สวยงามเป็นทิวเขาและแม่น้ำโขง อยู่ห่างจากภูชี้ฟ้า 10 กิโลเมตร การเดินทางขึ้นไปยังจุดชมวิวต้องใช้รถขับเคลื่อนสี่ล้อเท่านั้น สอบถามข้อมูล องค์การบริหารส่วนตำบลปอ โทร. 0 5360 2742 รถและคนนำทาง โทร. 08 0034 3984 และ 08 2184 0504', 'ตะปอน เวียงแก่น เชียงราย 22110', 'place_img/P03025228_1.jpeg', 1, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3752.399237860197!2d100.49336497499866!3d19.86535688150869!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d7d1bc93d49e57%3A0x29d39d0ffd058dbf!2zUGh1Y2hlZWRhbyDguKDguLnguIrguLXguYnguJTguLLguKcgUGh1Y2hpZGFv!5e0!3m2!1sth!2sth!4v1698747454889!5m2!1sth!2sth\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '05:00 - 18:00', '+66 5360 2742'),
(43, 'แก่งผาได', 'มีสองแห่ง แห่งแรกตั้งอยู่ที่อำเภอแม่ฟ้าหลวง เนื้อที่กว่า 500 ไร่ สูงจากระดับทะเลปานกลาง 1,200 เมตร เป็นสถานที่ปลูก ไม่เปิดให้เที่ยวชม ส่วนไร่ชาฉุยฟงแห่งที่สองอยู่ในอำเภอแม่จัน ก่อนถึงบ้านเทอดไทย มีพื้นที่กว้างกว่า 600 ไร่ ได้บรรยากาศของไร่ชาที่ปลูกโค้งวนไปตามไหล่เขา ซึ่งนักท่องเที่ยวสามารถแวะถ่ายภาพ และชมความงามได้หลายจุด นอกจากนี้ยังมีร้านอาหารและเครื่องดื่ม เบเกอรีให้บริการ เมนูยอดนิยม เช่น ยำทูน่า สปาเกตตียูนนาน หมั่นโถวใบชานุ่ม ชาเขียว ชาเย็น เค้กชาเขียว และเค้กช็อกโกแลต เปิดให้เข้าชมทุกวัน เวลา 08.00-17.30 น. สอบถามข้อมูล โทร. 0 5377 1563 เว็บไซต์ www.chouifongtea.com', 'โนนป่าซาง แม่จัน เชียงราย 42240', 'place_img/P03015827_1.jpeg', 1, 0, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3744.416725901638!2d99.8140971750079!3d20.199997081250007!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30d6f91f181dfc83%3A0x48a91c0ac3dd57a3!2z4LiK4Liy4LiJ4Li44Lii4Lif4LiH!5e0!3m2!1sth!2sth!4v1698747696232!5m2!1sth!2sth\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '08:00 - 17:30', '+66 5377 1563');

-- --------------------------------------------------------

--
-- Table structure for table `tourist_img`
--

CREATE TABLE `tourist_img` (
  `img_id` int(11) NOT NULL,
  `p_id` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `img_show` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tourist_img`
--

INSERT INTO `tourist_img` (`img_id`, `p_id`, `img`, `img_show`) VALUES
(33, 14, 'place_additional_img/14/P1.3.jpeg', 1),
(31, 14, 'place_additional_img/14/P1.1.jpg', 1),
(32, 14, 'place_additional_img/14/p1.2.jpg', 1),
(68, 37, 'place_additional_img/37/ดาวน์โหลด (3).jpg', 0),
(69, 39, 'place_additional_img/39/5ebf2470-092f-11eb-8c17-5bb542a40882_original.jpg', 0),
(70, 42, 'place_additional_img/42/ดาวน์โหลด (5).jpg', 0),
(71, 43, 'place_additional_img/43/shutterstock_1250536978.jpg', 0),
(72, 43, 'place_additional_img/43/ดาวน์โหลด (6).jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tradition`
--

CREATE TABLE `tradition` (
  `t_id` int(11) NOT NULL,
  `t_name` varchar(60) NOT NULL,
  `t_detail` longtext NOT NULL,
  `t_img` varchar(255) NOT NULL,
  `t_show` tinyint(1) NOT NULL DEFAULT 1,
  `t_reccom` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tradition`
--

INSERT INTO `tradition` (`t_id`, `t_name`, `t_detail`, `t_img`, `t_show`, `t_reccom`) VALUES
(19, 'งานตานหาพญามังราย', 'เนื่องในวันที่ 26 มกราคม ของทุกปี จะเป็นวันคล้ายวันที่พญามังราย หรือ พ่อขุนเม็งรายมหาราช ได้ทรงสร้างเมืองเชียงรายไว้เมื่อวันที่ 26 มกราคม พ.ศ.1805 เทศบาลนครเชียงราย ได้สำนึกในพระมหากรุณาธิคุณของพระองค์ท่าน จึงได้จัดพิธีบำเพ็ญกุศลสักการะดวงพระวิญญาณพ่อขุนเม็งรายมหาราชขึ้นในวันที่ 25 มกราคม ของทุกปี ณ วัดดอยงำเมือง ในงานมีกิจกรรมทางศาสนาจัดพิธีกรรมแบบล้านนา ซึ่งประกอบไปด้วย พิธีสักการะบูชาพระสถูป การสืบชะตาเมือง การทำบุญเมือง และการจัดกิจกรรมสมโภชเมือง อาทิ การฟ้อนเล็บ การฟ้อนดาบ และการตีกลองสะบัดชัย เพื่อถวายแด่องค์พ่อขุนเม็งรายมหาราช อีกทั้งยังเป็นการแสดงออกถึงความกตัญญูกตเวที และการเคารพต่อดวงพระวิญญาณของพระองค์ท่าน โดยพี่น้องชาวเชียงราย และพี่น้องชุมชนในเขตเทศบาลจะเข้าร่วมในพิธีอันศักดิ์สิทธิ์ครั้งนี้ด้วยการนำพานพุ่ม หรือพานดอกไม้เครื่องบูชาสักการะ ถวายดวงพระวิญญาณพ่อขุนเม็งรายมหาราช เพื่อความร่มเย็นของเมืองเชียงรายและความเป็นสิริมงคลแก่ชีวิตอีกด้วย\r\n\r\nนอกจากพิธีดังกล่าวแล้ว ในช่วงปลายเดือนมกราคมของทุกปี จังหวัดเชียงรายร่วมกับองค์กรต่าง ๆ ทั้งภาครัฐและเอกชนจะมีการร่วมกันจัดงานกาชาดประจำปีของจังหวัดเชียงรายหรือที่นิยมเรียกกันว่า \"งานพ่อขุนเม็งรายมหาราช\" ซึ่งจัดขึ้นประมาณปลายเดือนมกราคมของทุกปี ภายในงานจะมีการออกร้านจัดนิทรรศการของส่วนราชการและเอกชน งานรื่นเริงต่าง ๆ การจัดจำหน่ายสินค้า อาหาร และข้าวของเครื่องใช้ ซึ่งสามารถดึงดูดนักท่องเที่ยวและช่วยกระตุ้นเศรษฐกิจของหวัดเชียงรายได้เป็นอย่างดี', 'tradition_img/2021-03_0b232708975045d.jpg', 1, 1),
(20, 'จัดขึ้นเป็นประจำทุกปี เป็นการจัดงานเพื่อเชื่อมความสัมพันธไมต', 'จัดขึ้นเป็นประจำทุกปี เป็นการจัดงานเพื่อเชื่อมความสัมพันธไมตรีของประเทศในอนุภูมิภาคลุ่มน้ำโขง ได้แก่ ไทย ลาว จีน พม่า เวียดนาม และกัมพูชา เป็นการส่งเสริมการท่องเที่ยวและแลกเปลี่ยนศิลปะวัฒนธรรม ประเพณีระหว่างประเทศในอนุภูมิภาคลุ่มแม่น้ำโขง ซึ่งจะส่งผลดีต่อการท่องเที่ยวของจังหวัดเชียงรายและประเทศไทย รวมทั้งเป็นการสานสัมพันธ์กับประเทศเพื่อนบ้านให้แนบแน่น เชื่อมโยงเศรษฐกิจการค้าระหว่างประเทศ เป็นการผูกมิตรไมตรีที่ดีต่อกัน อันจะนำไปสู่การขยายฐานความสัมพันธ์ให้แน่นแฟ้นมากยิ่งขึ้น ส่งผลดีในปัจจุบันและอนาคตทางด้านการค้า การลงทุนการพัฒนาด้านการท่องเที่ยวในประเทศลุ่มแม่น้ำโขง จึงทำให้เป็นงานที่ยิ่งใหญ่และส่งผลดีต่อการพัฒนาประเทศ จัดขึ้นราวปลายเดือนตุลาคมหรือต้นพฤศจิกายนของทุกปี', 'tradition_img/2021-03_6645708a7c24134.jpg', 1, 0),
(21, 'ประเพณีอัญเชิญพระพุทธรูปแวดเวียงเฉียงฮาย', 'เป็นขบวนแห่พระคู่บ้านคู่เมืองที่สำคัญๆ ของวัดต่างๆ ประดิษฐานบนบุษบกแห่ให้ประชาชนสักการะบูชาโปรยข้าวตอกดอกไม้ในบ่ายวันที่ 31 ธันวาคมของทุกปี เพื่อเป็นศิริมงคลสำหรับเมืองเชียงราย ส่งท้ายปีเก่าที่กำลังจะผ่านไปและรับปีใหม่ที่กำลังจะมาถึง แล้วตักบาตรในวันที่ 1 มกราคมตอนเช้ารับวันปีใหม่ ซึ่งมีพื้นฐานความคิดมาจากตำนานพระเจ้าเลียบโลก ด้วยมีจุดมุ่งหมายให้ประชาชนได้มีโอกาสสักการะบูชาพระพุทธรูปศักดิ์สิทธิ์คู่บ้านคู่เมือง ซึ่งประดิษฐานอยู่ตามวัดวาอารามต่างๆ ในตัวเมืองเชียงราย เพื่อเป็นสิริมงคลแก่ชีวิตในวาระของการส่งท้ายปีเก่า ต้อนรับปีใหม่ โดยการอัญเชิญพระพุทธรูปศักดิ์สิทธิ์คู่บ้านคู่เมืองเชียงราย มาประดิษฐานบนบุษบกที่ได้สร้างขึ้นโดยช่างศิลปินที่มีชื่อเสียงของจังหวัดเชียงราย จัดเป็นขบวนอัญเชิญไปรอบเมืองเชียงราย ให้พุทธศาสนิกชนได้มีโอกาสกราบไหว้สักการะบูชาด้วย ข้าวตอก ดอกไม้ จึงถือเป็นการเริ่มต้นปีใหม่ที่เป็นสิริมงคลยิ่งนัก', 'tradition_img/2021-03_17859a50f099c45.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tradition_img`
--

CREATE TABLE `tradition_img` (
  `img_id` int(11) NOT NULL,
  `t_id` int(11) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `img_show` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `banking`
--
ALTER TABLE `banking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`crt_id`),
  ADD KEY `prd_id` (`prd_id`),
  ADD KEY `mmb_id` (`mmb_id`),
  ADD KEY `pty_id` (`pty_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`h_id`);

--
-- Indexes for table `line_member`
--
ALTER TABLE `line_member`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mmb_id`);

--
-- Indexes for table `member_levels`
--
ALTER TABLE `member_levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `mmb_id` (`mmb_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `crt_id` (`crt_id`),
  ADD KEY `mmb_id` (`mmb_id`),
  ADD KEY `prd_id` (`prd_id`);

--
-- Indexes for table `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_views`
--
ALTER TABLE `page_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_notifications`
--
ALTER TABLE `payment_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`prd_id`);

--
-- Indexes for table `product_img`
--
ALTER TABLE `product_img`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `prd_id` (`prd_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`pty_id`);

--
-- Indexes for table `ship_info`
--
ALTER TABLE `ship_info`
  ADD PRIMARY KEY (`s_id`);

--
-- Indexes for table `tourist`
--
ALTER TABLE `tourist`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `tourist_img`
--
ALTER TABLE `tourist_img`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `tradition`
--
ALTER TABLE `tradition`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `tradition_img`
--
ALTER TABLE `tradition_img`
  ADD PRIMARY KEY (`img_id`),
  ADD KEY `t_id` (`t_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about`
--
ALTER TABLE `about`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `banking`
--
ALTER TABLE `banking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `crt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=589;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `h_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `line_member`
--
ALTER TABLE `line_member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mmb_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `member_levels`
--
ALTER TABLE `member_levels`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `page_views`
--
ALTER TABLE `page_views`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_notifications`
--
ALTER TABLE `payment_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `prd_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `product_img`
--
ALTER TABLE `product_img`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=406;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `pty_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ship_info`
--
ALTER TABLE `ship_info`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tourist`
--
ALTER TABLE `tourist`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tourist_img`
--
ALTER TABLE `tourist_img`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tradition`
--
ALTER TABLE `tradition`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tradition_img`
--
ALTER TABLE `tradition_img`
  MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
