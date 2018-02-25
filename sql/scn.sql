-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 13, 2018 at 04:26 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `scn`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `area_id` int(11) NOT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `area_status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2- inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`area_id`, `area_code`, `area_name`, `date`, `area_status`) VALUES
(1, 'AR0001', 'Bidhannagar', '2017-11-10 19:30:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cbl_channel`
--

CREATE TABLE `cbl_channel` (
  `channel_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `channel_code` varchar(255) DEFAULT NULL,
  `channel_name` varchar(255) DEFAULT NULL,
  `channel_mode` int(11) NOT NULL DEFAULT '0' COMMENT 'in months',
  `channel_price` decimal(12,2) NOT NULL DEFAULT '0.00',
  `staff_base` int(1) NOT NULL DEFAULT '0',
  `including_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dis_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dis_type` int(1) NOT NULL DEFAULT '1' COMMENT '1-%,2-fixed',
  `discount_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tot_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2- inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cbl_channel`
--

INSERT INTO `cbl_channel` (`channel_id`, `date`, `channel_code`, `channel_name`, `channel_mode`, `channel_price`, `staff_base`, `including_amount`, `dis_amount`, `dis_type`, `discount_total`, `tot_amount`, `status`) VALUES
(4, '2018-01-06 11:40:03', 'CHNL0004', 'Test Channel123', 3, '150.00', 0, '300.00', '0.00', 1, '0.00', '215.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cbl_channel_to_tax`
--

CREATE TABLE `cbl_channel_to_tax` (
  `cbl_channel_to_tax_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL DEFAULT '0',
  `tax_type` int(1) NOT NULL DEFAULT '1' COMMENT '1-Fixed, 2-Percentage ',
  `tax_name` varchar(255) DEFAULT NULL,
  `tax_no` varchar(255) DEFAULT NULL,
  `tax_price` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cbl_channel_to_tax`
--

INSERT INTO `cbl_channel_to_tax` (`cbl_channel_to_tax_id`, `channel_id`, `tax_type`, `tax_name`, `tax_no`, `tax_price`) VALUES
(5, 4, 2, 'CGST', '111', '50.00'),
(6, 4, 1, 'SGST', '222', '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `cbl_customers`
--

CREATE TABLE `cbl_customers` (
  `customer_id` int(11) NOT NULL,
  `cust_code` varchar(255) DEFAULT NULL,
  `caf_no` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `mobile1` varchar(15) DEFAULT NULL,
  `mobile2` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `other_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `gender` int(1) NOT NULL DEFAULT '1' COMMENT '1-m,2-f',
  `dob` date DEFAULT NULL,
  `address1` text,
  `address2` text,
  `language` int(1) NOT NULL DEFAULT '0',
  `pincode` varchar(255) DEFAULT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `package_type` int(1) DEFAULT '0',
  `pack_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `lco_id` int(11) NOT NULL DEFAULT '0',
  `connection_date` date DEFAULT NULL,
  `billing_date` date DEFAULT NULL,
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `mso_id` int(11) NOT NULL DEFAULT '0',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `due_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stb_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deposite_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `added_date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1-active,2-inactive,3-deleted',
  `payment_status` int(1) NOT NULL DEFAULT '0' COMMENT '1-unpaid, 2-paid',
  `last_payment_month` int(3) NOT NULL DEFAULT '0',
  `address_attachment` varchar(255) DEFAULT NULL,
  `caf_page1` varchar(255) DEFAULT NULL,
  `caf_page2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cbl_customers`
--

INSERT INTO `cbl_customers` (`customer_id`, `cust_code`, `caf_no`, `first_name`, `last_name`, `mobile1`, `mobile2`, `email`, `other_id`, `username`, `gender`, `dob`, `address1`, `address2`, `language`, `pincode`, `package_id`, `package_type`, `pack_amount`, `lco_id`, `connection_date`, `billing_date`, `staff_id`, `mso_id`, `balance`, `due_balance`, `stb_amount`, `deposite_amount`, `added_date`, `status`, `payment_status`, `last_payment_month`, `address_attachment`, `caf_page1`, `caf_page2`) VALUES
(1, 'CUST001', 'CAF NO', 'SANJOY MANDAL', NULL, '9876543210', '', '', '123', NULL, 1, '0000-00-00', 'kol', '', 0, NULL, 5, 1, '200.00', 4, '2018-01-11', '2018-01-10', 2, 6, '220.00', '0.00', '100.00', '0.00', '2018-01-13 15:34:53', 1, 2, 1, '151561226158413.PNG', '151561226185048.PNG', '1515612261saf224217.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `cbl_customer_to_stb`
--

CREATE TABLE `cbl_customer_to_stb` (
  `customer_to_stb_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `stb_no` varchar(255) DEFAULT NULL,
  `account` varchar(255) DEFAULT NULL,
  `stb_model_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cbl_customer_to_stb`
--

INSERT INTO `cbl_customer_to_stb` (`customer_to_stb_id`, `customer_id`, `stb_no`, `account`, `stb_model_id`) VALUES
(3, 1, '123', '100', 2),
(4, 5, '32421', '213', 3);

-- --------------------------------------------------------

--
-- Table structure for table `cbl_lco`
--

CREATE TABLE `cbl_lco` (
  `lco_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `lconame` varchar(255) DEFAULT NULL,
  `shtname` varchar(255) DEFAULT NULL,
  `address` text,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2-inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cbl_lco`
--

INSERT INTO `cbl_lco` (`lco_id`, `date`, `lconame`, `shtname`, `address`, `phone`, `email`, `status`) VALUES
(1, '2017-12-11 06:35:23', 'SCN', 'LCO Short', 'Kolkata\r\n ', '9876543210<br />\r\n8538872336<br />\r\n8538872336<br />\r\n8538872336', 'sanjoym152@gmail.com', 1),
(2, '2017-10-22 16:23:36', 'LCO 2', 'LCO 2 Short', 'Bankura', '1234567890', 'lco@gmail.com', 1),
(3, '2017-12-11 06:18:59', 'LCO', 'LCO Short', 'Kol', '7602400355', '', 1),
(4, '2017-12-11 06:30:42', 'LCO', 'LCO', 'Kol', '9876543210<br />\r\n7897564231', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cbl_mso`
--

CREATE TABLE `cbl_mso` (
  `isp_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `mso` varchar(255) DEFAULT NULL,
  `shtname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `phone` bigint(15) NOT NULL DEFAULT '0',
  `mob` bigint(15) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2- inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cbl_mso`
--

INSERT INTO `cbl_mso` (`isp_id`, `date`, `mso`, `shtname`, `address`, `email`, `fax`, `phone`, `mob`, `status`) VALUES
(5, '2017-12-04 19:16:25', 'Wishnet', 'Short Name', 'Dakshindari, Bidahnnagar, Kolkata', 'sanjoym152@gmail.com', '112233', 33252100, 9876543210, 1),
(6, '2017-12-26 20:41:28', 'Cable MSO', 'c_mso', 'Kolkata', '', '', 0, 9876543210, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cbl_package`
--

CREATE TABLE `cbl_package` (
  `package_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `pakcode` varchar(255) DEFAULT NULL,
  `pakname` varchar(255) DEFAULT NULL,
  `pkg_mode` int(11) NOT NULL DEFAULT '0' COMMENT 'in months',
  `pakren` decimal(12,2) NOT NULL DEFAULT '0.00',
  `including_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dis_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dis_type` int(1) NOT NULL DEFAULT '1' COMMENT '1-%,2-fixed',
  `discount_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tot_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2- inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cbl_package`
--

INSERT INTO `cbl_package` (`package_id`, `date`, `pakcode`, `pakname`, `pkg_mode`, `pakren`, `including_amount`, `dis_amount`, `dis_type`, `discount_total`, `tot_amount`, `status`) VALUES
(5, '2018-01-13 15:20:45', 'PAC0005', 'NEW', 1, '150.00', '200.00', '0.00', 1, '0.00', '200.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cbl_package_to_tax`
--

CREATE TABLE `cbl_package_to_tax` (
  `package_to_tax_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `tax_type` int(1) NOT NULL DEFAULT '1' COMMENT '1-Fixed, 2-Percentage ',
  `tax_name` varchar(255) DEFAULT NULL,
  `tax_no` varchar(255) DEFAULT NULL,
  `tax_price` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cbl_package_to_tax`
--

INSERT INTO `cbl_package_to_tax` (`package_to_tax_id`, `package_id`, `tax_type`, `tax_name`, `tax_no`, `tax_price`) VALUES
(1, 1, 0, '', '', '0.00'),
(3, 5, 2, 'GST', '111', '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `cbl_stb_model`
--

CREATE TABLE `cbl_stb_model` (
  `stb_model_id` int(11) NOT NULL,
  `stb_model_no` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2- inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cbl_stb_model`
--

INSERT INTO `cbl_stb_model` (`stb_model_id`, `stb_model_no`, `status`) VALUES
(2, 'STB00111', 1),
(3, 'STB-NEW-001-EDITED', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `cust_code` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `mobile1` varchar(15) DEFAULT NULL,
  `mobile2` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `other_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `gender` int(1) NOT NULL DEFAULT '1' COMMENT '1-m,2-f',
  `dob` date DEFAULT NULL,
  `address1` text,
  `address2` text,
  `language` int(1) NOT NULL DEFAULT '0',
  `pincode` varchar(255) DEFAULT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `lco_id` int(11) NOT NULL DEFAULT '0',
  `connection_date` date DEFAULT NULL,
  `billing_date` date DEFAULT NULL,
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `mso_id` int(11) NOT NULL DEFAULT '0',
  `balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `due_balance` decimal(12,2) NOT NULL DEFAULT '0.00',
  `installation_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `deposite_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `added_date` datetime DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1-active,2-inactive,3-deleted',
  `payment_status` int(1) NOT NULL DEFAULT '0' COMMENT '1-unpaid, 2-paid',
  `last_payment_month` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `cust_code`, `first_name`, `last_name`, `mobile1`, `mobile2`, `email`, `other_id`, `username`, `gender`, `dob`, `address1`, `address2`, `language`, `pincode`, `package_id`, `lco_id`, `connection_date`, `billing_date`, `staff_id`, `mso_id`, `balance`, `due_balance`, `installation_amount`, `deposite_amount`, `added_date`, `status`, `payment_status`, `last_payment_month`) VALUES
(1, 'CUST001', 'Sanjoy', NULL, '7602400355', '', '', 'DSDS', NULL, 1, '0000-00-00', 'KOl', '', 0, NULL, 1, 1, '2017-12-14', '2017-12-20', 3, 5, '600.00', '1000.00', '0.00', '0.00', '2017-12-20 20:28:32', 3, 2, 12),
(2, 'CUST002', 'New', NULL, '7602400355', '', '', '3321', NULL, 1, '0000-00-00', 'Kol', '', 0, NULL, 1, 2, '2017-12-13', '2017-12-03', 2, 5, '-100.00', '1000.00', '0.00', '0.00', '2017-12-21 20:00:04', 3, 2, 12),
(3, 'CUST003', 'TEST TEST', NULL, '7602400355', '', '', '336', NULL, 1, '0000-00-00', 'KOlkata', '', 0, NULL, 1, 1, '2017-12-14', '2017-12-06', 2, 5, '300.00', '200.00', '0.00', '0.00', '2017-12-22 17:30:12', 1, 2, 12),
(4, 'CUST004', 'TEST TEST', NULL, '9876543210', '', '', '9669', NULL, 1, '0000-00-00', 'Kolkata', '', 0, NULL, 1, 1, '2017-12-05', '2017-12-05', 2, 5, '1000.00', '900.00', '0.00', '0.00', '2017-12-22 17:32:05', 1, 2, 12);

-- --------------------------------------------------------

--
-- Table structure for table `customer_to_channel`
--

CREATE TABLE `customer_to_channel` (
  `customer_to_channel_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `channel_id` int(11) NOT NULL DEFAULT '0',
  `chanel_price` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer_to_ip`
--

CREATE TABLE `customer_to_ip` (
  `customer_to_ip_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `ip_address` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_to_ip`
--

INSERT INTO `customer_to_ip` (`customer_to_ip_id`, `customer_id`, `ip_address`, `username`) VALUES
(3, 1, '192.168.2.11', 'sanjoym156'),
(4, 2, '192.168.0.11', 'sanjoym1522'),
(5, 3, '192.168.2.1', 'sanjoym151'),
(6, 4, '192.168.0.123', 'sanjoym151');

-- --------------------------------------------------------

--
-- Table structure for table `isp`
--

CREATE TABLE `isp` (
  `isp_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `mso` varchar(255) DEFAULT NULL,
  `shtname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `phone` bigint(15) NOT NULL DEFAULT '0',
  `mob` bigint(15) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2- inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `isp`
--

INSERT INTO `isp` (`isp_id`, `date`, `mso`, `shtname`, `address`, `email`, `fax`, `phone`, `mob`, `status`) VALUES
(5, '2017-12-04 19:16:25', 'Wishnet', 'Short Name', 'Dakshindari, Bidahnnagar, Kolkata', 'sanjoym152@gmail.com', '112233', 33252100, 9876543210, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lco`
--

CREATE TABLE `lco` (
  `lco_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `lconame` varchar(255) DEFAULT NULL,
  `shtname` varchar(255) DEFAULT NULL,
  `address` text,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2-inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `lco`
--

INSERT INTO `lco` (`lco_id`, `date`, `lconame`, `shtname`, `address`, `phone`, `email`, `status`) VALUES
(1, '2017-12-11 06:35:23', 'SCN', 'LCO Short', 'Kolkata\r\n ', '9876543210<br />\r\n8538872336<br />\r\n8538872336<br />\r\n8538872336', 'sanjoym152@gmail.com', 2),
(2, '2017-10-22 16:23:36', 'LCO 2', 'LCO 2 Short', 'Bankura', '1234567890', 'lco@gmail.com', 1),
(3, '2017-12-11 06:18:59', 'LCO', 'LCO Short', 'Kol', '7602400355', '', 1),
(4, '2017-12-11 06:30:42', 'LCO', 'LCO', 'Kol', '9876543210<br />\r\n7897564231', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lco_tax`
--

CREATE TABLE `lco_tax` (
  `tax_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `lco_id` int(11) DEFAULT '0',
  `taxname` varchar(255) DEFAULT NULL,
  `taxno` varchar(255) DEFAULT NULL,
  `taxtype` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2- inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `lco_tax`
--

INSERT INTO `lco_tax` (`tax_id`, `date`, `lco_id`, `taxname`, `taxno`, `taxtype`, `status`) VALUES
(3, '2017-10-22 16:25:22', 2, 'Tax Name 2', '11', 'none', 1),
(4, '2017-10-22 16:27:28', 1, 'Tax Name 3', '77777', 'more', 2);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `package_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `pakcode` varchar(255) DEFAULT NULL,
  `pakname` varchar(255) DEFAULT NULL,
  `pkg_mode` int(11) NOT NULL DEFAULT '0' COMMENT 'in months',
  `pakren` decimal(12,2) NOT NULL DEFAULT '0.00',
  `staff_base` int(1) NOT NULL DEFAULT '0',
  `including_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dis_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `dis_type` int(1) NOT NULL DEFAULT '1' COMMENT '1-%,2-fixed',
  `discount_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tot_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1-active, 2- inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `date`, `pakcode`, `pakname`, `pkg_mode`, `pakren`, `staff_base`, `including_amount`, `dis_amount`, `dis_type`, `discount_total`, `tot_amount`, `status`) VALUES
(1, '2017-12-11 07:22:24', 'PAC0001', 'Test123', 3, '0.00', 1, '100.00', '0.00', 1, '0.00', '100.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `package_to_tax`
--

CREATE TABLE `package_to_tax` (
  `package_to_tax_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL DEFAULT '0',
  `tax_type` int(1) NOT NULL DEFAULT '1' COMMENT '1-Fixed, 2-Percentage ',
  `tax_name` varchar(255) DEFAULT NULL,
  `tax_no` varchar(255) DEFAULT NULL,
  `tax_price` decimal(12,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_to_tax`
--

INSERT INTO `package_to_tax` (`package_to_tax_id`, `package_id`, `tax_type`, `tax_name`, `tax_no`, `tax_price`) VALUES
(1, 1, 0, '', '', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `staff_id` int(11) DEFAULT '0',
  `payment_date` date DEFAULT NULL,
  `outstanding` decimal(12,2) DEFAULT '0.00' COMMENT 'Previous Due',
  `pack_amount` decimal(12,2) NOT NULL DEFAULT '0.00',
  `package_id` int(11) DEFAULT '0',
  `other_fees` decimal(12,2) DEFAULT '0.00',
  `discount_in` int(11) DEFAULT '0',
  `discount_type` int(1) DEFAULT '1' COMMENT '1-fixed, 2-percentage',
  `discount_total` decimal(12,2) DEFAULT '0.00',
  `payment_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `net_due` decimal(12,2) NOT NULL DEFAULT '0.00' COMMENT 'After Payment',
  `month_of` int(2) NOT NULL DEFAULT '0',
  `remark` text,
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '1-payment, 2- topup',
  `status` int(1) NOT NULL COMMENT '1-unpaid, 2-paid',
  `is_added_time` int(1) NOT NULL DEFAULT '0' COMMENT 'if this field created when customer is added'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `customer_id`, `staff_id`, `payment_date`, `outstanding`, `pack_amount`, `package_id`, `other_fees`, `discount_in`, `discount_type`, `discount_total`, `payment_total`, `sub_total`, `net_due`, `month_of`, `remark`, `type`, `status`, `is_added_time`) VALUES
(13, 2, 3, '2017-12-12', '0.00', '100.00', 1, '0.00', 0, 0, '0.00', '100.00', '100.00', '-100.00', 0, NULL, 1, 0, 0),
(14, 2, 2, '2017-12-06', '-100.00', '0.00', 1, '0.00', 0, 0, '0.00', '120.00', '120.00', '-120.00', 0, NULL, 1, 0, 0),
(15, 2, 2, '2017-12-12', '-120.00', '0.00', 1, '0.00', 0, 0, '0.00', '200.00', '200.00', '-200.00', 0, NULL, 1, 0, 0),
(16, 2, 2, '2017-12-11', '-200.00', '0.00', 1, '0.00', 0, 0, '0.00', '100.00', '100.00', '-100.00', 0, NULL, 1, 0, 0),
(17, 3, 2, '2017-12-06', '200.00', '100.00', 1, '0.00', 0, 1, '0.00', '300.00', '0.00', '100.00', 0, NULL, 2, 0, 1),
(18, 4, 2, '2017-12-05', '900.00', '100.00', 1, '0.00', 0, 1, '0.00', '1000.00', '0.00', '100.00', 0, NULL, 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_commission`
--

CREATE TABLE `payment_commission` (
  `payment_commission_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL DEFAULT '0',
  `payment_id` int(11) NOT NULL DEFAULT '0',
  `commission` decimal(12,2) NOT NULL DEFAULT '0.00',
  `collection_date` date DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '1-internet, 2-cable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment_commission`
--

INSERT INTO `payment_commission` (`payment_commission_id`, `staff_id`, `payment_id`, `commission`, `collection_date`, `type`) VALUES
(1, 3, 13, '4.00', '2017-12-12', 1),
(2, 2, 14, '6.00', '2017-12-06', 1),
(3, 2, 15, '10.00', '2017-12-12', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `staff_code` varchar(255) DEFAULT NULL,
  `staff_name` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `staff_base` int(1) DEFAULT '0' COMMENT '1-> %, 2->Fixed',
  `commission` decimal(12,2) NOT NULL DEFAULT '0.00',
  `address` text,
  `mobile` varchar(255) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `staff_type` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1-active, 2-inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `date`, `staff_code`, `staff_name`, `designation`, `staff_base`, `commission`, `address`, `mobile`, `join_date`, `staff_type`, `status`) VALUES
(2, '2017-12-21 20:52:59', 'SCNS0002', 'Sanjoy', 'Collector', 1, '5.00', 'Kolkata', '9876543210<br />\r\n9876543210<br />\r\n9876543210', '2017-10-25', 'Staff Type', 1),
(3, '2017-12-21 20:44:49', 'SCNS0003', 'Sanjoy123', 'Manager', 1, '4.00', 'Kolkata', '9876543210', '2017-10-25', 'Staff Type', 1);

-- --------------------------------------------------------

--
-- Table structure for table `sub_area`
--

CREATE TABLE `sub_area` (
  `sub_area_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL DEFAULT '0',
  `sub_area_code` varchar(255) DEFAULT NULL,
  `sub_area_name` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `sub_area_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_area`
--

INSERT INTO `sub_area` (`sub_area_id`, `area_id`, `sub_area_code`, `sub_area_name`, `date`, `sub_area_status`) VALUES
(3, 1, 'AR0003', 'Sub Area-1', '2017-10-25 21:12:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` int(1) NOT NULL DEFAULT '0' COMMENT '1->Admin, 2->Customer',
  `status` varchar(500) NOT NULL COMMENT '1-> Active, 2->Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fname`, `lname`, `email`, `password`, `user_type`, `status`) VALUES
(9, 'Admin', 'Admin', 'info@scn.com', '21232f297a57a5a743894a0e4a801fc3', 1, '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`area_id`);

--
-- Indexes for table `cbl_channel`
--
ALTER TABLE `cbl_channel`
  ADD PRIMARY KEY (`channel_id`);

--
-- Indexes for table `cbl_channel_to_tax`
--
ALTER TABLE `cbl_channel_to_tax`
  ADD PRIMARY KEY (`cbl_channel_to_tax_id`);

--
-- Indexes for table `cbl_customers`
--
ALTER TABLE `cbl_customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `cbl_customer_to_stb`
--
ALTER TABLE `cbl_customer_to_stb`
  ADD PRIMARY KEY (`customer_to_stb_id`);

--
-- Indexes for table `cbl_lco`
--
ALTER TABLE `cbl_lco`
  ADD PRIMARY KEY (`lco_id`);

--
-- Indexes for table `cbl_mso`
--
ALTER TABLE `cbl_mso`
  ADD PRIMARY KEY (`isp_id`);

--
-- Indexes for table `cbl_package`
--
ALTER TABLE `cbl_package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `cbl_package_to_tax`
--
ALTER TABLE `cbl_package_to_tax`
  ADD PRIMARY KEY (`package_to_tax_id`);

--
-- Indexes for table `cbl_stb_model`
--
ALTER TABLE `cbl_stb_model`
  ADD PRIMARY KEY (`stb_model_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_to_channel`
--
ALTER TABLE `customer_to_channel`
  ADD PRIMARY KEY (`customer_to_channel_id`);

--
-- Indexes for table `customer_to_ip`
--
ALTER TABLE `customer_to_ip`
  ADD PRIMARY KEY (`customer_to_ip_id`);

--
-- Indexes for table `isp`
--
ALTER TABLE `isp`
  ADD PRIMARY KEY (`isp_id`);

--
-- Indexes for table `lco`
--
ALTER TABLE `lco`
  ADD PRIMARY KEY (`lco_id`);

--
-- Indexes for table `lco_tax`
--
ALTER TABLE `lco_tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `package_to_tax`
--
ALTER TABLE `package_to_tax`
  ADD PRIMARY KEY (`package_to_tax_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `payment_commission`
--
ALTER TABLE `payment_commission`
  ADD PRIMARY KEY (`payment_commission_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `staffid` (`staff_code`);

--
-- Indexes for table `sub_area`
--
ALTER TABLE `sub_area`
  ADD PRIMARY KEY (`sub_area_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cbl_channel`
--
ALTER TABLE `cbl_channel`
  MODIFY `channel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cbl_channel_to_tax`
--
ALTER TABLE `cbl_channel_to_tax`
  MODIFY `cbl_channel_to_tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cbl_customers`
--
ALTER TABLE `cbl_customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cbl_customer_to_stb`
--
ALTER TABLE `cbl_customer_to_stb`
  MODIFY `customer_to_stb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cbl_lco`
--
ALTER TABLE `cbl_lco`
  MODIFY `lco_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cbl_mso`
--
ALTER TABLE `cbl_mso`
  MODIFY `isp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cbl_package`
--
ALTER TABLE `cbl_package`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cbl_package_to_tax`
--
ALTER TABLE `cbl_package_to_tax`
  MODIFY `package_to_tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cbl_stb_model`
--
ALTER TABLE `cbl_stb_model`
  MODIFY `stb_model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_to_channel`
--
ALTER TABLE `customer_to_channel`
  MODIFY `customer_to_channel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_to_ip`
--
ALTER TABLE `customer_to_ip`
  MODIFY `customer_to_ip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `isp`
--
ALTER TABLE `isp`
  MODIFY `isp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lco`
--
ALTER TABLE `lco`
  MODIFY `lco_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lco_tax`
--
ALTER TABLE `lco_tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `package_to_tax`
--
ALTER TABLE `package_to_tax`
  MODIFY `package_to_tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payment_commission`
--
ALTER TABLE `payment_commission`
  MODIFY `payment_commission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sub_area`
--
ALTER TABLE `sub_area`
  MODIFY `sub_area_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
