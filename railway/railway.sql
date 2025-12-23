SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `railway`
--

-- --------------------------------------------------------

--
-- Table structure for table `canc`
--

DROP TABLE IF EXISTS `canc`;
CREATE TABLE IF NOT EXISTS `canc` (
  `pnr` int(11) NOT NULL,
  `rfare` int(11) DEFAULT '0',
  PRIMARY KEY (`pnr`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `canc`
--

INSERT INTO `canc` (`pnr`, `rfare`) VALUES
(57, 1100),
(58, 5600);

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
CREATE TABLE IF NOT EXISTS `class` (
  `cname` varchar(10) NOT NULL,
  PRIMARY KEY (`cname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`cname`) VALUES
('AC1'),
('AC2'),
('AC3'),
('CC'),
('EC'),
('SL');

-- --------------------------------------------------------

--
-- Table structure for table `classseats`
--

DROP TABLE IF EXISTS `classseats`;
CREATE TABLE IF NOT EXISTS `classseats` (
  `trainno` int(11) NOT NULL,
  `sp` varchar(50) NOT NULL COMMENT 'Starting_Point',
  `dp` varchar(50) NOT NULL COMMENT 'Destination_Point',
  `doj` date NOT NULL,
  `class` varchar(10) NOT NULL,
  `fare` int(11) NOT NULL,
  `seatsleft` int(11) NOT NULL,
  PRIMARY KEY (`trainno`,`sp`,`dp`,`doj`,`class`),
  KEY `class` (`class`),
  KEY `sp` (`sp`,`dp`),
  KEY `dp` (`dp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classseats`
--

INSERT INTO `classseats` (`trainno`, `sp`, `dp`, `doj`, `class`, `fare`, `seatsleft`) VALUES
(12, 'Hà Nội', 'Đà Nẵng', '2025-12-23', 'AC1', 450000, 107),
(12, 'Hà Nội', 'Đà Nẵng', '2025-12-28', 'AC2', 550000, 20),
(12, 'Hà Nội', 'Đà Nẵng', '2025-12-28', 'AC3', 380000, 60),
(12, 'Hà Nội', 'Đà Nẵng', '2025-12-28', 'EC', 250000, 100),
(12, 'Hà Nội', 'Đà Nẵng', '2025-12-28', 'SL', 150000, 200),
(12, 'Đà Nẵng', 'Sài Gòn', '2025-12-23', 'AC1', 380000, 243),
(12, 'Đà Nẵng', 'Sài Gòn', '2025-12-28', 'AC2', 480000, 15),
(12, 'Đà Nẵng', 'Sài Gòn', '2025-12-28', 'AC3', 350000, 40),
(12, 'Đà Nẵng', 'Sài Gòn', '2025-12-28', 'EC', 280000, 120),
(12, 'Đà Nẵng', 'Sài Gòn', '2025-12-28', 'SL', 180000, 250),
(12, 'Sài Gòn', 'Huế', '2025-12-23', 'AC1', 320000, 322),
(12, 'Sài Gòn', 'Huế', '2025-12-28', 'AC2', 420000, 30),
(12, 'Sài Gòn', 'Huế', '2025-12-28', 'AC3', 300000, 30),
(12, 'Sài Gòn', 'Huế', '2025-12-28', 'EC', 250000, 150),
(12, 'Sài Gòn', 'Huế', '2025-12-28', 'SL', 150000, 220),
(12, 'Huế', 'Hà Nội', '2025-12-23', 'AC1', 280000, 326),
(12, 'Huế', 'Hà Nội', '2025-12-28', 'AC2', 380000, 20),
(12, 'Huế', 'Hà Nội', '2025-12-28', 'AC3', 320000, 60),
(12, 'Huế', 'Hà Nội', '2025-12-28', 'EC', 220000, 118),
(12, 'Huế', 'Hà Nội', '2025-12-28', 'SL', 180000, 180),
(18, 'Hải Phòng', 'Đà Nẵng', '2025-12-25', 'AC1', 420000, 50),
(18, 'Hải Phòng', 'Đà Nẵng', '2025-12-25', 'AC3', 320000, 20),
(18, 'Hải Phòng', 'Đà Nẵng', '2025-12-25', 'CC', 180000, 120),
(18, 'Đà Nẵng', 'Hà Nội', '2025-12-25', 'AC1', 380000, 20),
(18, 'Đà Nẵng', 'Hà Nội', '2025-12-25', 'AC3', 280000, 20),
(18, 'Đà Nẵng', 'Hà Nội', '2025-12-25', 'CC', 200000, 150),
(20, 'Hà Nội', 'Đà Nẵng', '2025-12-24', 'AC1', 500000, 20),
(20, 'Hà Nội', 'Đà Nẵng', '2025-12-24', 'AC2', 420000, 50),
(20, 'Hà Nội', 'Đà Nẵng', '2025-12-24', 'AC3', 350000, 50),
(20, 'Hà Nội', 'Đà Nẵng', '2025-12-24', 'SL', 180000, 300);

--
-- Triggers `classseats`
--
DROP TRIGGER IF EXISTS `before_insert_on_classseats`;
DELIMITER //
CREATE TRIGGER `before_insert_on_classseats` BEFORE INSERT ON `classseats`
 FOR EACH ROW begin
if datediff(curdate(),new.doj)>0 then
SIGNAL SQLSTATE '45000' 
SET MESSAGE_TEXT = 'Ngày không hợp lệ!!!';
end if;
if new.fare<=0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Giá vé không hợp lệ!!!';
end if;
if new.seatsleft<=0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Số ghế không hợp lệ!!!';
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_classseats`;
DELIMITER //
CREATE TRIGGER `before_update_on_classseats` BEFORE UPDATE ON `classseats`
 FOR EACH ROW begin
if datediff(curdate(),new.doj)>0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Ngày không hợp lệ!!!';
end if;
if new.fare<=0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Giá vé không hợp lệ!!!';
end if;
if new.seatsleft<=0 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Số ghế không hợp lệ!!!';
end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pd` passenger details
--

DROP TABLE IF EXISTS `pd`;
CREATE TABLE IF NOT EXISTS `pd` (
  `pnr` int(11) NOT NULL,
  `pname` varchar(50) NOT NULL,
  `page` int(11) NOT NULL,
  `pgender` varchar(10) NOT NULL,
  PRIMARY KEY (`pnr`,`pname`,`page`,`pgender`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pd`
--

INSERT INTO `pd` (`pnr`, `pname`, `page`, `pgender`) VALUES
(58, 'Nguyễn Văn A', 20, 'M'),
(58, 'Trần Văn B', 21, 'M'),
(58, 'Lê Thị C', 25, 'F'),
(58, 'Phạm Văn D', 50, 'M'),
(59, 'Hoàng Văn Đ', 20, 'M'),
(59, 'Đặng Thị E', 40, 'F'),
(60, 'Vũ Văn G', 20, 'M');


--
-- Triggers `pd`
--
DROP TRIGGER IF EXISTS `before_insert_on_pd`;
DELIMITER //
CREATE TRIGGER `before_insert_on_pd` BEFORE INSERT ON `pd`
 FOR EACH ROW begin
if new.pgender NOT IN ('M','F') then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Nhập M: Nam, F: Nữ.';
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_pd`;
DELIMITER //
CREATE TRIGGER `before_update_on_pd` BEFORE UPDATE ON `pd`
 FOR EACH ROW begin
if new.pgender NOT IN ('M','F') then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Nhập M: Nam, F: Nữ.';
end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `resv`
--

DROP TABLE IF EXISTS `resv`;
CREATE TABLE IF NOT EXISTS `resv` (
  `pnr` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `trainno` int(11) NOT NULL,
  `sp` varchar(50) NOT NULL,
  `dp` varchar(50) NOT NULL,
  `doj` date NOT NULL,
  `tfare` int(11) NOT NULL,
  `class` varchar(50) NOT NULL,
  `nos` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`pnr`),
  UNIQUE KEY `UNIQUE` (`id`,`trainno`,`doj`,`status`),
  UNIQUE KEY `pnr` (`pnr`,`id`,`trainno`,`doj`,`class`,`status`),
  UNIQUE KEY `pnr_2` (`pnr`,`id`,`trainno`,`sp`,`dp`,`doj`,`tfare`,`class`,`nos`,`status`),
  KEY `FK_ID` (`id`),
  KEY `FK_TN_DOJ_C` (`trainno`,`doj`,`class`),
  KEY `class` (`class`),
  KEY `sp` (`sp`,`dp`),
  KEY `dp` (`dp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `resv`
--

INSERT INTO `resv` (`pnr`, `id`, `trainno`, `sp`, `dp`, `doj`, `tfare`, `class`, `nos`, `status`) VALUES
(51, 4, 12, 'Hà Nội', 'Đà Nẵng', '2025-12-23', 900000, 'AC1', 2, 'BOOKED'),
(57, 5, 12, 'Hà Nội', 'Đà Nẵng', '2025-12-23', 450000, 'AC1', 1, 'CANCELLED'),
(58, 6, 20, 'Hà Nội', 'Đà Nẵng', '2025-12-24', 1680000, 'AC2', 4, 'CANCELLED'),
(59, 10, 12, 'Huế', 'Hà Nội', '2025-12-28', 440000, 'EC', 2, 'BOOKED');

--
-- Triggers `resv`
--
DROP TRIGGER IF EXISTS `after_insert_on_resv`;
DELIMITER //
CREATE TRIGGER `after_insert_on_resv` AFTER INSERT ON `resv`
 FOR EACH ROW begin
UPDATE classseats SET seatsleft=seatsleft-new.nos where trainno=new.trainno AND class=new.class AND doj=new.doj AND sp=new.sp AND dp=new.dp;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `after_update_on_resv`;
DELIMITER //
CREATE TRIGGER `after_update_on_resv` AFTER UPDATE ON `resv`
 FOR EACH ROW begin
if (new.status='CANCELLED' AND datediff(new.doj,curdate())<0 ) then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Không thể hủy vé!!!!';
end if;

if (new.status='CANCELLED' AND datediff(new.doj,curdate())>0 )then
UPDATE classseats SET seatsleft=seatsleft+new.nos where trainno=new.trainno AND class=new.class AND doj=new.doj AND sp=new.sp AND dp=new.dp;
 if datediff(new.doj,curdate())>=30 then 
 INSERT INTO canc values (new.pnr,new.tfare);
 end if;
 if datediff(new.doj,curdate())<30 then 
 INSERT INTO canc values (new.pnr,0.5*new.tfare);
 end if;
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_insert_on_resv`;
DELIMITER //
CREATE TRIGGER `before_insert_on_resv` BEFORE INSERT ON `resv`
 FOR EACH ROW begin
if new.tfare<0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Số dư không hợp lệ';
end if;
if new.nos<=0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Số ghế không hợp lệ';
end if;
if (select seatsleft from classseats where trainno=new.trainno AND class=new.class AND doj=new.doj AND sp=new.sp AND dp=new.dp) < new.nos then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Không đủ ghế trống!!!';
end if;
if datediff(new.doj,curdate())<0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Không thể đặt vé!!!!';
end if;
SET new.status='BOOKED';
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_resv`;
DELIMITER //
CREATE TRIGGER `before_update_on_resv` BEFORE UPDATE ON `resv`
 FOR EACH ROW begin
if new.tfare<0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Số dư không hợp lệ';
end if;
if new.nos<=0 then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Số ghế không hợp lệ';
end if;
if (select seatsleft from classseats where trainno=new.trainno AND class=new.class AND doj=new.doj AND sp=new.sp AND dp=new.dp) < new.nos then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Không đủ ghế trống!!!';
end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trainno` int(11) NOT NULL,
  `sname` varchar(50) NOT NULL,
  `arrival_time` time NOT NULL,
  `departure_time` time NOT NULL DEFAULT '00:00:00',
  `distance` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trainno` (`trainno`),
  KEY `sname` (`sname`),
  KEY `id` (`id`),
  KEY `distance` (`distance`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `trainno`, `sname`, `arrival_time`, `departure_time`, `distance`) VALUES
(1, 12, 'Hà Nội', '06:00:00', '06:00:00', 0),
(2, 12, 'Đà Nẵng', '14:30:00', '14:45:00', 764),
(3, 12, 'Sài Gòn', '19:00:00', '19:15:00', 1726),
(4, 12, 'Huế', '12:00:00', '12:15:00', 654),
(5, 12, 'Hà Nội', '22:30:00', '22:30:00', 1726),
(6, 13, 'Hải Phòng', '07:00:00', '07:00:00', 0),
(7, 13, 'Hà Nội', '09:00:00', '09:10:00', 102),
(8, 13, 'Ninh Bình', '11:30:00', '11:40:00', 189),
(9, 13, 'Vinh', '14:00:00', '14:15:00', 319),
(10, 13, 'Đà Nẵng', '20:00:00', '20:10:00', 764),
(11, 13, 'Nha Trang', '06:30:00', '06:30:00', 1278),
(12, 14, 'Hải Phòng', '08:00:00', '08:00:00', 0),
(13, 14, 'Cần Thơ', '22:00:00', '22:00:00', 1800),
(14, 15, 'Hà Nội', '16:00:00', '16:00:00', 0),
(15, 15, 'Đà Nẵng', '06:00:00', '06:00:00', 764),
(16, 16, 'Đà Nẵng', '07:30:00', '07:30:00', 0),
(17, 16, 'Hà Nội', '17:30:00', '17:30:00', 764),
(18, 17, 'Hà Nội', '05:00:00', '05:00:00', 0),
(19, 17, 'Đà Nẵng', '15:00:00', '15:10:00', 764),
(20, 17, 'Hải Phòng', '18:30:00', '18:30:00', 866),
(21, 18, 'Hải Phòng', '08:00:00', '08:00:00', 0),
(22, 18, 'Đà Nẵng', '18:00:00', '18:10:00', 866),
(23, 18, 'Hà Nội', '21:00:00', '21:00:00', 968),
(24, 6, 'Đà Nẵng', '06:30:00', '06:30:00', 0),
(25, 6, 'Quảng Ngãi', '08:30:00', '08:45:00', 130),
(26, 6, 'Huế', '11:00:00', '11:00:00', 100),
(27, 19, 'Huế', '13:30:00', '13:30:00', 0),
(28, 19, 'Quảng Ngãi', '16:00:00', '16:10:00', 130),
(29, 19, 'Đà Nẵng', '18:30:00', '18:30:00', 230),
(30, 20, 'Hà Nội', '10:00:00', '10:00:00', 0),
(31, 20, 'Đà Nẵng', '20:00:00', '20:00:00', 764),
(32, 21, 'Đà Nẵng', '21:00:00', '21:00:00', 0),
(33, 21, 'Hà Nội', '07:00:00', '07:00:00', 764),
(34, 22, 'Hà Nội', '16:00:00', '16:00:00', 0),
(35, 22, 'Vinh', '20:00:00', '20:10:00', 319),
(36, 22, 'Đà Nẵng', '06:30:00', '06:40:00', 764),
(37, 22, 'Sài Gòn', '18:00:00', '18:00:00', 1726),
(38, 23, 'Sài Gòn', '06:00:00', '06:00:00', 0),
(39, 23, 'Đà Nẵng', '18:00:00', '18:10:00', 962),
(40, 23, 'Vinh', '06:00:00', '06:10:00', 1407),
(41, 23, 'Hà Nội', '09:30:00', '09:30:00', 1726);

-- --------------------------------------------------------

--
-- Table structure for table `station`
--

DROP TABLE IF EXISTS `station`;
CREATE TABLE IF NOT EXISTS `station` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(50) NOT NULL,
  PRIMARY KEY (`sname`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `station`
--

INSERT INTO `station` (`id`, `sname`) VALUES
(1, 'Hà Nội'),
(2, 'Sài Gòn'),
(3, 'Đà Nẵng'),
(4, 'Huế'),
(5, 'Hải Phòng'),
(6, 'Cần Thơ'),
(7, 'Nha Trang'),
(8, 'Vinh'),
(9, 'Quảng Ngãi'),
(10, 'Ninh Bình'),
(11, 'Thanh Hóa'),
(12, 'Biên Hòa');

-- --------------------------------------------------------

--
-- Table structure for table `train`
--

DROP TABLE IF EXISTS `train`;
CREATE TABLE IF NOT EXISTS `train` (
  `trainno` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Train_no',
  `tname` varchar(50) NOT NULL COMMENT 'Train_name',
  `sp` varchar(50) NOT NULL COMMENT 'Starting_Point',
  `st` time NOT NULL COMMENT 'Arrival_Time',
  `dp` varchar(50) NOT NULL COMMENT 'Destination_Point',
  `dt` time NOT NULL,
  `dd` varchar(10) DEFAULT NULL COMMENT 'Day',
  `distance` int(11) NOT NULL COMMENT 'Distance',
  PRIMARY KEY (`trainno`),
  KEY `sp` (`sp`),
  KEY `dp` (`dp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `train`
--

INSERT INTO `train` (`trainno`, `tname`, `sp`, `st`, `dp`, `dt`, `dd`, `distance`) VALUES
(6, 'Tàu SE1', 'Đà Nẵng', '06:30:00', 'Huế', '11:00:00', 'Ngày 1', 100),
(12, 'Tàu Thống Nhất', 'Hà Nội', '06:00:00', 'Sài Gòn', '22:30:00', 'Ngày 2', 1726),
(13, 'Tàu SE3', 'Hải Phòng', '07:00:00', 'Nha Trang', '06:30:00', 'Ngày 2', 1278),
(14, 'Tàu SE5', 'Hải Phòng', '08:00:00', 'Cần Thơ', '22:00:00', 'Ngày 2', 1800),
(15, 'Tàu SE7', 'Hà Nội', '16:00:00', 'Đà Nẵng', '06:00:00', 'Ngày 2', 764),
(16, 'Tàu SE8', 'Đà Nẵng', '07:30:00', 'Hà Nội', '17:30:00', 'Ngày 1', 764),
(17, 'Tàu SE9', 'Hà Nội', '05:00:00', 'Hải Phòng', '18:30:00', 'Ngày 1', 866),
(18, 'Tàu SE10', 'Hải Phòng', '08:00:00', 'Hà Nội', '21:00:00', 'Ngày 1', 968),
(19, 'Tàu SE2', 'Huế', '13:30:00', 'Đà Nẵng', '18:30:00', 'Ngày 1', 230),
(20, 'Tàu SE11', 'Hà Nội', '10:00:00', 'Đà Nẵng', '20:00:00', 'Ngày 1', 764),
(21, 'Tàu SE12', 'Đà Nẵng', '21:00:00', 'Hà Nội', '07:00:00', 'Ngày 2', 764),
(22, 'Tàu SE13', 'Hà Nội', '16:00:00', 'Sài Gòn', '18:00:00', 'Ngày 2', 1726),
(23, 'Tàu SE14', 'Sài Gòn', '06:00:00', 'Hà Nội', '09:30:00', 'Ngày 2', 1726);

--
-- Triggers `train`
--
DROP TRIGGER IF EXISTS `before_insert_on_train`;
DELIMITER //
CREATE TRIGGER `before_insert_on_train` BEFORE INSERT ON `train`
 FOR EACH ROW begin
if (new.dt<new.st AND new.dd='Ngày 1') then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Thời gian không hợp lệ!!!';
end if;
if (new.dp=new.sp) then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Điểm đến và điểm đi không được trùng nhau';
end if; 
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_train`;
DELIMITER //
CREATE TRIGGER `before_update_on_train` BEFORE UPDATE ON `train`
 FOR EACH ROW begin
if (new.dt<new.st AND new.dd='Ngày 1') then
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Thời gian không hợp lệ!!!';
end if;
end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emailid` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `mobileno` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUEMN` (`mobileno`),
  UNIQUE KEY `UNIQUEEI` (`emailid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `emailid`, `password`, `mobileno`, `dob`) VALUES
(1, 'nguyenvana@gmail.com', '123456', '0912345678', '1998-01-15'),
(2, 'tranvanb@gmail.com', '123456', '0923456789', '1995-05-20'),
(3, 'lethic@gmail.com', '123456', '0934567890', '1997-08-10'),
(4, 'phamvand@gmail.com', '123456', '0945678901', '1996-12-25'),
(5, 'hoangvand@yahoo.com', '123456', '0913452635', '1993-12-30'),
(6, 'dangthie@gmail.com', '123456', '09876675567', '1991-01-01'),
(7, 'vuvang@hotmail.com', '123456', '09878876654', '1997-09-08');


DROP TRIGGER IF EXISTS `before_insert_on_user`;
DELIMITER //
CREATE TRIGGER `before_insert_on_user` BEFORE INSERT ON `user`
 FOR EACH ROW begin
if (year(curdate())-year(new.dob))<18 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Người dùng chưa đủ 18 tuổi.';
end if;
end
//
DELIMITER ;
DROP TRIGGER IF EXISTS `before_update_on_user`;
DELIMITER //
CREATE TRIGGER `before_update_on_user` BEFORE UPDATE ON `user`
 FOR EACH ROW begin
if (year(curdate())-year(new.dob))<18 then 
SIGNAL SQLSTATE '45000'
SET MESSAGE_TEXT = 'Người dùng chưa đủ 18 tuổi.';
end if;
end
//
DELIMITER ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classseats`
--
ALTER TABLE `classseats`
  ADD CONSTRAINT `classseats_ibfk_1` FOREIGN KEY (`trainno`) REFERENCES `train` (`trainno`),
  ADD CONSTRAINT `classseats_ibfk_3` FOREIGN KEY (`sp`) REFERENCES `station` (`sname`),
  ADD CONSTRAINT `classseats_ibfk_4` FOREIGN KEY (`dp`) REFERENCES `station` (`sname`),
  ADD CONSTRAINT `classseats_ibfk_5` FOREIGN KEY (`class`) REFERENCES `class` (`cname`);

--
-- Constraints for table `resv`
--
ALTER TABLE `resv`
  ADD CONSTRAINT `resv_ibfk_1` FOREIGN KEY (`trainno`) REFERENCES `train` (`trainno`),
  ADD CONSTRAINT `resv_ibfk_2` FOREIGN KEY (`sp`) REFERENCES `station` (`sname`),
  ADD CONSTRAINT `resv_ibfk_3` FOREIGN KEY (`dp`) REFERENCES `station` (`sname`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
