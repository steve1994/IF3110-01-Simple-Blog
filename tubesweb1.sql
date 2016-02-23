-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2016 at 10:01 AM
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
('Steve', '14-10-2014', 'steve@gmail.com', 'FFFFFFF', 13),
('HHHHH', '14-10-2014', 'hhhh@gmail.com', 'fsdfsdfd', 47),
('Emen', '15-10-2014', 'emen@gmail.com', 'Ya gpp kali', 14),
('Fanji', '15-10-2014', 'fanji@yahoo.com', 'Bantu wasit ya......', 13),
('Dudi', '15-10-2014', 'dudi@yahoo.com', 'Persipura', 13),
('Steve', '15-10-2014', 'steve@gmail.com', 'steve', 16),
('Kevmau', '15-10-2014', 'Kevin@gmail.com', 'Kevin Maulana', 12),
('Saya', '16-10-2014', 'anonymous@gmail.com', 'Selamat bapak Jokowi semoga dilancarkan dalam menjalankan tugasnya......', 21);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `daftarpost`
--

INSERT INTO `daftarpost` (`ID`, `Judul`, `Tanggal`, `IsiPostHTML`) VALUES
(21, 'Pak Jokowi', '12-12-2014', '												Hari senin (20/10) nanti akan menjadi hari yang bersejarah buat bangsa Indonesia karena bapak presiden/wakil presiden yang baru akan dilantik. Makanya nonton berita :p									'),
(22, 'Sat', '22-07-2018', 'Saya suka cakuee		');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `Username` varchar(20) NOT NULL,
  `Password` varchar(20) NOT NULL,
  `Email` varchar(20) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`Username`, `Password`, `Email`) VALUES
('Steve', '8d969eef6ecad3c29a3a', 'steve.harnadi@gmail.'),
('Vanda', '8d969eef6ecad3c29a3a', 'vanda@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
