-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2014 at 02:14 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tubesweb1`
--

-- --------------------------------------------------------

--
-- Table structure for table `daftarkomentar`
--

CREATE TABLE IF NOT EXISTS `daftarkomentar` (
  `Nama` text NOT NULL,
  `TanggalKomentar` text NOT NULL,
  `Email` text NOT NULL,
  `IsiKomentar` text NOT NULL,
  `ID_post_terkait` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `daftarkomentar`
--

INSERT INTO `daftarkomentar` (`Nama`, `TanggalKomentar`, `Email`, `IsiKomentar`, `ID_post_terkait`) VALUES
('aaa', '13-10-2014', 'aaa', '[object HTMLFormElement]', 11),
('Budi', '13-10-2014', 'budi@gmail.com', '[object HTMLFormElement]', 11),
('Santi Cazorla ', '13-10-2014', 'Santi_Cazorla@gmail.com', 'Persebaya kudu menang !', 11),
('MamihDedeh', '13-10-2014', 'Mamih9999@yahoo.com', 'Menang harga mati persebaya !!', 11),
('Mamat', '13-10-2014', 'juju', 'Hidup Persib...:D', 12),
('Steve', '13-10-2014', 'steveh', 'dfdfdsfdsff', 12),
('Rani', '13-10-2014', 'rani', 'Arghhhh', 12),
('Hayo', '13-10-2014', 'hayo@gmail.com', 'dfsdfdsfdsfsd', 12),
('Steve', '14-10-2014', 'steve@gmail.com', 'FFFFFFF', 13);

-- --------------------------------------------------------

--
-- Table structure for table `daftarpost`
--

CREATE TABLE IF NOT EXISTS `daftarpost` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Judul` text NOT NULL,
  `Tanggal` text NOT NULL,
  `IsiPostHTML` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

--
-- Dumping data for table `daftarpost`
--

INSERT INTO `daftarpost` (`ID`, `Judul`, `Tanggal`, `IsiPostHTML`) VALUES
(12, 'Mitra Kukar', '10-10-2014', 'Mitra Kukar menelan kekalahan pertamanya di babak 8 besar ISL setelah ditekuk 2-3 oleh sang tamu Persib Bandung, Jumat (10/10) di stadion kebanggannya Madya Aji Imbut Tenggarong.'),
(13, 'Arema-Persipura', '13-10-2014', 'Arema gasak persipura 3-0'),
(46, 'Compfest', '14-10-2014', 'Compfest merupakan acara tahunan yang diadakan');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
