-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2023 at 07:32 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `www_kn_2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `provider` varchar(50) NOT NULL,
  `instance` varchar(50) NOT NULL,
  `vcpu` int(10) UNSIGNED NOT NULL,
  `memory` int(10) UNSIGNED NOT NULL,
  `storage` varchar(50) NOT NULL,
  `network` int(10) UNSIGNED NOT NULL,
  `price` float UNSIGNED NOT NULL,
  `region` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_danish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`instance`,`region`) USING BTREE;
COMMIT;