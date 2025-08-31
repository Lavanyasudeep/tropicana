-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 31, 2025 at 01:04 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tropicana`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(100) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(100) NOT NULL,
  `owner` varchar(100) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_analytical`
--

CREATE TABLE `cs_analytical` (
  `analytical_id` int(11) NOT NULL,
  `company_id` int(3) NOT NULL,
  `analytical_code` varchar(50) DEFAULT NULL,
  `account_code` varchar(50) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_attachments`
--

CREATE TABLE `cs_attachments` (
  `attachment_id` int(11) NOT NULL,
  `company_id` int(2) DEFAULT NULL,
  `branch_id` int(2) DEFAULT NULL,
  `table_name` varchar(50) DEFAULT NULL,
  `row_id` int(11) DEFAULT NULL,
  `file_name` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_bank_master`
--

CREATE TABLE `cs_bank_master` (
  `bank_master_id` int(3) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `bank_name` text DEFAULT NULL,
  `group_name` text DEFAULT NULL,
  `account_code` varchar(10) DEFAULT NULL,
  `account_no` text DEFAULT NULL,
  `ifsc` text DEFAULT NULL,
  `holder_name` text DEFAULT NULL,
  `account_type` varchar(50) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  `del_status` int(1) DEFAULT 1,
  `branch_id` int(11) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_blocks`
--

CREATE TABLE `cs_blocks` (
  `block_id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `block_no` varchar(50) DEFAULT NULL,
  `warehouse_unit_id` int(11) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `total_capacity` decimal(10,2) DEFAULT NULL,
  `temperature_range` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_blocks`
--

INSERT INTO `cs_blocks` (`block_id`, `name`, `block_no`, `warehouse_unit_id`, `room_id`, `description`, `total_capacity`, `temperature_range`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Frozen Goods Block A1', 'A1', 1, 101, 'Primary frozen storage near entrance', 120.50, '-20°C to -18°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(2, 'Frozen Goods Block A2', 'A2', 1, 101, 'Adjacent to A1, same frozen section', 118.75, '-20°C to -18°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(3, 'Chilled Dairy Block B1', 'B1', 1, 102, 'Dairy products and perishable chilled goods', 95.00, '0°C to 4°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(4, 'Chilled Produce Block B2', 'B2', 1, 102, 'Fresh vegetables and fruits', 90.25, '2°C to 6°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(5, 'Dry Goods Block C1', 'C1', 1, 103, 'Ambient temperature storage for dry packaged goods', 150.00, '15°C to 25°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(6, 'Meat Storage Block D1', 'D1', 1, 104, 'Dedicated frozen meat storage', 110.00, '-22°C to -20°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(7, 'Seafood Storage Block D2', 'D2', 1, 104, 'Frozen seafood section', 108.50, '-22°C to -20°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(8, 'Pharma Cold Block E1', 'E1', 1, 105, 'Pharmaceutical cold chain storage', 80.00, '2°C to 8°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(9, 'Ice Cream Block F1', 'F1', 1, 106, 'Ice cream and frozen desserts', 100.00, '-25°C to -23°C', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1),
(10, 'Overflow Block Z1', 'Z1', 1, 107, 'Multi-purpose overflow storage', 130.00, 'Varies by load', 1, '2025-08-26 08:28:16', 1, '2025-08-26 08:28:16', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_branch`
--

CREATE TABLE `cs_branch` (
  `branch_id` bigint(20) NOT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `address1` text DEFAULT NULL,
  `address2` text DEFAULT NULL,
  `state_id` int(2) DEFAULT NULL,
  `district_id` int(4) DEFAULT NULL,
  `pincode` varchar(15) DEFAULT NULL,
  `phone_number` varchar(150) DEFAULT NULL,
  `email_id` varchar(30) DEFAULT NULL,
  `contact_name` varchar(45) DEFAULT NULL,
  `designation` varchar(45) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_brand`
--

CREATE TABLE `cs_brand` (
  `brand_id` int(11) NOT NULL,
  `brand_id_data_mig` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `supplier_id` int(5) NOT NULL,
  `brand_name` varchar(45) DEFAULT NULL,
  `purchase_days` int(11) NOT NULL,
  `active` enum('1','0') DEFAULT NULL,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cs_brand`
--

INSERT INTO `cs_brand` (`brand_id`, `brand_id_data_mig`, `company_id`, `supplier_id`, `brand_name`, `purchase_days`, `active`, `del_status`, `created_by`, `created_at`, `short_name`, `updated_by`, `updated_at`) VALUES
(1, 0, 1, 0, 'Brand', 0, '1', 1, 121, '2020-11-19 12:44:06', 'Brand', NULL, NULL),
(2, 0, 1, 1, 'KASHMIR APPLES', 0, '1', 1, 176, '2022-09-17 08:36:38', 'KASHMIR APPLES', NULL, NULL),
(3, 0, 1, 1, 'AUSTRALIA', 0, '1', 1, 176, '2022-09-17 08:43:40', 'AUSTRALIA', NULL, NULL),
(4, 0, 1, 1, 'HIMACHAL APPLES', 0, '1', 1, 176, '2022-09-17 08:44:32', 'HIMACHAL APPLES', NULL, NULL),
(5, 0, 1, 1, 'SOUTH INDIAN', 0, '1', 1, 176, '2022-09-17 08:45:36', 'SOUTH INDIAN', NULL, NULL),
(6, 0, 1, 1, 'MAHARASHTRA', 0, '1', 1, 176, '2022-09-17 08:50:11', 'MAHARASHTRA', NULL, NULL),
(7, 0, 1, 1, 'IMPORTED', 0, '1', 1, 176, '2022-09-17 09:00:54', 'IMPORTED', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_chart_of_account`
--

CREATE TABLE `cs_chart_of_account` (
  `account_id` int(11) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `account_group_id` int(5) DEFAULT NULL,
  `account_name` varchar(250) DEFAULT NULL,
  `account_code` varchar(50) DEFAULT NULL,
  `contra_account_code` varchar(50) DEFAULT NULL,
  `level_1_id` int(3) DEFAULT 0,
  `level_2_id` int(3) DEFAULT 0,
  `level_3_id` int(5) DEFAULT 0,
  `level_4_id` int(5) DEFAULT 0,
  `is_cash_or_bank` int(1) DEFAULT 0,
  `is_receivable` int(1) DEFAULT 0,
  `is_sales` int(1) DEFAULT 0,
  `is_purchase` int(1) DEFAULT 0,
  `is_logistics` int(1) DEFAULT 0,
  `is_fuel` int(1) DEFAULT NULL,
  `is_fasttag` int(1) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cs_chart_of_account`
--

INSERT INTO `cs_chart_of_account` (`account_id`, `company_id`, `account_group_id`, `account_name`, `account_code`, `contra_account_code`, `level_1_id`, `level_2_id`, `level_3_id`, `level_4_id`, `is_cash_or_bank`, `is_receivable`, `is_sales`, `is_purchase`, `is_logistics`, `is_fuel`, `is_fasttag`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1100, 'Cash in Hand', '1.1.1', NULL, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(2, 1, 1100, 'Bank Account', '1.1.2', NULL, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(3, 1, 1100, 'Accounts Receivable', '1.1.3', NULL, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(4, 1, 1100, 'Inventory - Cold Storage', '1.1.4', NULL, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(5, 1, 1200, 'Cold Storage Machinery', '1.2.1', NULL, 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(6, 1, 1200, 'Vehicles - Logistics Fleet', '1.2.2', NULL, 1, 2, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(7, 1, 2100, 'Accounts Payable', '2.1.1', NULL, 2, 3, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(8, 1, 2100, 'GST/VAT Payable', '2.1.2', NULL, 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(9, 1, 3100, 'Owner’s Capital', '3.1.1', NULL, 3, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(10, 1, 4100, 'Storage Charges Income', '4.1.1', NULL, 4, 6, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(11, 1, 4200, 'Logistics Income', '4.2.1', NULL, 4, 7, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(12, 1, 4200, 'FastTag Reimbursements', '4.2.2', NULL, 4, 7, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(13, 1, 4300, 'Product Sales', '4.3.1', NULL, 4, 8, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(14, 1, 5100, 'Purchase of Goods', '5.1.1', NULL, 5, 9, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(15, 1, 5100, 'Electricity & Power', '5.1.2', NULL, 5, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(16, 1, 5100, 'Fuel Expenses', '5.1.3', NULL, 5, 9, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(17, 1, 5100, 'FastTag Expenses', '5.1.4', NULL, 5, 9, 0, 0, 0, 0, 0, 0, 1, 0, 1, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(18, 1, 5200, 'Salaries & Wages', '5.2.1', NULL, 5, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(19, 1, 5200, 'Office Rent', '5.2.2', NULL, 5, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(20, 1, 5300, 'Vehicle Maintenance', '5.3.1', NULL, 5, 11, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL),
(21, 1, 5400, 'Software & IT Costs', '5.4.1', NULL, 5, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2025-08-21 15:20:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_city`
--

CREATE TABLE `cs_city` (
  `city_id` int(11) NOT NULL,
  `city_name` varchar(45) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `active` enum('1','0') DEFAULT NULL,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_client`
--

CREATE TABLE `cs_client` (
  `client_id` int(11) NOT NULL,
  `client_name` varchar(150) DEFAULT NULL,
  `country_id` int(3) NOT NULL,
  `state_id` int(3) NOT NULL,
  `district_id` int(3) NOT NULL,
  `post_office_id` int(4) NOT NULL,
  `gstin` varchar(100) NOT NULL,
  `logo` text DEFAULT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `fssai_no` varchar(50) DEFAULT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `mobile_number` varchar(50) NOT NULL,
  `email_id` text NOT NULL,
  `website` varchar(250) NOT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_client`
--

INSERT INTO `cs_client` (`client_id`, `client_name`, `country_id`, `state_id`, `district_id`, `post_office_id`, `gstin`, `logo`, `tin`, `fssai_no`, `address`, `phone_number`, `mobile_number`, `email_id`, `website`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'PJJ', 1, 1, 1, 1, '', NULL, NULL, NULL, '', '', '', '', '', 1, 1, '2025-06-01 10:59:08', 1, '2025-06-01 05:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `cs_company`
--

CREATE TABLE `cs_company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `country_id` int(3) DEFAULT NULL,
  `state_id` int(3) DEFAULT NULL,
  `district_id` int(3) DEFAULT NULL,
  `post_office_id` int(4) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `fssai_no` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(50) DEFAULT NULL,
  `email_id` text DEFAULT NULL,
  `website` varchar(250) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_company`
--

INSERT INTO `cs_company` (`company_id`, `company_name`, `country_id`, `state_id`, `district_id`, `post_office_id`, `gstin`, `logo`, `tin`, `fssai_no`, `address`, `phone_number`, `mobile_number`, `email_id`, `website`, `active`, `created_by`, `created_at`) VALUES
(1, 'Tropicana Cold Storage', 1, 1, 1, 1, NULL, 'uploads/company_logos/yoIAXo1ohaAXyyuWtRZNXbLwlhBCXfeNG4kh0Djq.jpg', NULL, '11318005000665', NULL, '094471 21606', '094471 21606', NULL, NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_country`
--

CREATE TABLE `cs_country` (
  `country_id` bigint(20) NOT NULL,
  `company_id` int(2) NOT NULL,
  `country_name` varchar(45) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_country`
--

INSERT INTO `cs_country` (`country_id`, `company_id`, `country_name`, `short_name`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'INDIA', 'IN', 1, 1, '2025-06-01 18:05:17', 1, '2025-05-31 18:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `cs_customer`
--

CREATE TABLE `cs_customer` (
  `customer_id` int(11) NOT NULL,
  `company_id` int(2) DEFAULT NULL,
  `branch_id` int(5) DEFAULT NULL,
  `customer_type_id` int(1) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `customer_cat_id` int(11) DEFAULT NULL,
  `contact_person` varchar(45) DEFAULT NULL,
  `main_address` text DEFAULT NULL,
  `area` text DEFAULT NULL,
  `place_id` int(11) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `post_office_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `phone_number` varchar(250) DEFAULT NULL,
  `phone_number2` varchar(250) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(45) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `shipping_address` varchar(100) DEFAULT NULL,
  `shipping_district_id` int(11) DEFAULT NULL,
  `shipping_state_id` int(11) DEFAULT NULL,
  `shipping_city_id` int(11) DEFAULT NULL,
  `shipping_phonenumber` varchar(20) DEFAULT NULL,
  `shipping_fax` varchar(20) DEFAULT NULL,
  `shipping_email` varchar(45) DEFAULT NULL,
  `billing_address` varchar(100) DEFAULT NULL,
  `billing_district_id` int(11) DEFAULT NULL,
  `billing_state_id` int(11) DEFAULT NULL,
  `billing_city_id` int(11) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `credit_limit` double DEFAULT NULL,
  `tin` varchar(30) DEFAULT NULL,
  `aadhaar` varchar(30) DEFAULT NULL,
  `pan` varchar(45) DEFAULT NULL,
  `cst` varchar(50) DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `sez` char(1) DEFAULT 'N',
  `currency` varchar(4) DEFAULT NULL,
  `payment_terms` int(5) DEFAULT NULL,
  `payment_terms_by` varchar(15) DEFAULT NULL,
  `image_trade_license` varchar(300) DEFAULT NULL,
  `active` enum('1','0') DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_customer`
--

INSERT INTO `cs_customer` (`customer_id`, `company_id`, `branch_id`, `customer_type_id`, `customer_name`, `photo`, `customer_cat_id`, `contact_person`, `main_address`, `area`, `place_id`, `route_id`, `post_office_id`, `city_id`, `district_id`, `state_id`, `pincode`, `phone_number`, `phone_number2`, `fax`, `email`, `website`, `password`, `short_name`, `shipping_address`, `shipping_district_id`, `shipping_state_id`, `shipping_city_id`, `shipping_phonenumber`, `shipping_fax`, `shipping_email`, `billing_address`, `billing_district_id`, `billing_state_id`, `billing_city_id`, `credit_days`, `credit_limit`, `tin`, `aadhaar`, `pan`, `cst`, `gstin`, `sez`, `currency`, `payment_terms`, `payment_terms_by`, `image_trade_license`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(3, 1, 1, NULL, 'test', NULL, NULL, NULL, 'sdfadsgdfs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2354325435', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N', NULL, NULL, NULL, NULL, NULL, 1, '2025-07-18 06:47:05', NULL, '2025-07-18 06:47:05', NULL, NULL),
(4, 1, 1, NULL, 'customer 1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '094471 21606', NULL, NULL, 'customer1@gmail.com', 'https://www.testdemo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-07-30 05:45:27', 1, '2025-07-30 05:46:08', NULL, NULL),
(5, 1, 1, NULL, 'customer 2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-07-31 08:31:35', NULL, '2025-07-31 08:31:35', NULL, NULL),
(6, 1, 1, NULL, 'customer 3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-07-31 08:46:43', NULL, '2025-07-31 08:46:43', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_customer_enquiry`
--

CREATE TABLE `cs_customer_enquiry` (
  `customer_enquiry_id` int(11) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) DEFAULT NULL,
  `doc_no` varchar(50) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `service_type` varchar(50) DEFAULT NULL,
  `item_type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_customer_enquiry`
--

INSERT INTO `cs_customer_enquiry` (`customer_enquiry_id`, `company_id`, `branch_id`, `doc_type`, `doc_no`, `doc_date`, `customer_id`, `service_type`, `item_type`, `description`, `remarks`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'customer-enquiry', 'CE-25-00001', NULL, 3, '[\"rent\"]', '[\"frozen\"]', 'sdfdsgfdsg', 'asdgdfsh', 'created', 1, NULL, '2025-07-18 06:47:05', '2025-07-18 06:47:05');

-- --------------------------------------------------------

--
-- Table structure for table `cs_department`
--

CREATE TABLE `cs_department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(45) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `active` enum('1','0') DEFAULT NULL,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `short_name` varchar(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_designation`
--

CREATE TABLE `cs_designation` (
  `designation_id` int(11) NOT NULL,
  `company_id` int(2) DEFAULT NULL,
  `designation_name` varchar(200) DEFAULT NULL,
  `short_name` varchar(100) DEFAULT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_district`
--

CREATE TABLE `cs_district` (
  `district_id` int(11) NOT NULL,
  `district_name` varchar(45) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `company_id` int(3) NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  `code` varchar(5) NOT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_district`
--

INSERT INTO `cs_district` (`district_id`, `district_name`, `short_name`, `company_id`, `state_id`, `code`, `sort_order`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Ernakkulam', 'ERN', 1, 1, 'ERN', 1, 1, 1, '2025-05-31 18:53:33', 1, '2025-05-31 18:53:33');

-- --------------------------------------------------------

--
-- Table structure for table `cs_docks`
--

CREATE TABLE `cs_docks` (
  `dock_id` bigint(20) UNSIGNED NOT NULL,
  `dock_no` varchar(20) DEFAULT NULL,
  `dock_name` varchar(100) DEFAULT NULL,
  `warehouse_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `dock_type` enum('Loading','Receiving','Multi-purpose') DEFAULT NULL,
  `status` enum('Active','Inactive','Maintenance') DEFAULT 'Active',
  `is_active` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_employee`
--

CREATE TABLE `cs_employee` (
  `employee_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `first_name` varchar(200) DEFAULT NULL,
  `last_name` varchar(200) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `email_id` varchar(250) DEFAULT NULL,
  `photo` text DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `father_name` varchar(250) DEFAULT NULL,
  `mother_name` varchar(250) DEFAULT NULL,
  `spouse_name` varchar(100) DEFAULT NULL,
  `present_address` text DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `pf_no` varchar(50) DEFAULT NULL,
  `esi_no` varchar(50) DEFAULT NULL,
  `pan` varchar(50) DEFAULT NULL,
  `aadhaar_card_no` varchar(20) DEFAULT NULL,
  `emergency_contact_numbers` varchar(30) DEFAULT NULL,
  `emergency_contact_person_name` varchar(250) DEFAULT NULL,
  `employee_category_id` varchar(250) DEFAULT NULL,
  `payroll_number` varchar(20) DEFAULT NULL,
  `years_of_experience` double DEFAULT 0,
  `date_of_joining` date DEFAULT NULL,
  `date_of_confirm` date DEFAULT NULL,
  `date_of_leaving` date DEFAULT NULL,
  `designation_id` int(4) DEFAULT NULL,
  `is_md` int(1) DEFAULT 0,
  `verified` int(1) DEFAULT 0,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `del_status` int(1) NOT NULL DEFAULT 1,
  `short_name` varchar(10) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_employee`
--

INSERT INTO `cs_employee` (`employee_id`, `company_id`, `branch_id`, `department_id`, `division_id`, `first_name`, `last_name`, `date_of_birth`, `mobile_number`, `email_id`, `photo`, `sex`, `marital_status`, `father_name`, `mother_name`, `spouse_name`, `present_address`, `permanent_address`, `pf_no`, `esi_no`, `pan`, `aadhaar_card_no`, `emergency_contact_numbers`, `emergency_contact_person_name`, `employee_category_id`, `payroll_number`, `years_of_experience`, `date_of_joining`, `date_of_confirm`, `date_of_leaving`, `designation_id`, `is_md`, `verified`, `active`, `del_status`, `short_name`, `sort_order`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 'Sudeep', 'J', '1986-11-24', '094471 21606', 'sudeep@gmail.com', NULL, 'male', 'single', 'Jothi', 'Devi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '03209537459', 'Test', NULL, 'EMP0001', 3, '2025-07-24', NULL, NULL, NULL, 0, 0, '1', 1, NULL, NULL, 1, '2025-07-24 09:28:33', NULL, '2025-07-24 09:28:33');

-- --------------------------------------------------------

--
-- Table structure for table `cs_gate_pass`
--

CREATE TABLE `cs_gate_pass` (
  `gate_pass_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) DEFAULT NULL,
  `doc_no` varchar(50) DEFAULT NULL,
  `doc_date` datetime DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `movement_type` enum('Inward','Outward','Returnable','Non-Returnable') DEFAULT NULL,
  `vehicle_no` varchar(50) DEFAULT NULL,
  `driver_name` varchar(100) DEFAULT NULL,
  `transport_mode` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` enum('Draft','Approved','Issued','Closed') DEFAULT 'Draft',
  `requested_by` varchar(100) DEFAULT NULL,
  `approved_by` varchar(100) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_gate_pass`
--

INSERT INTO `cs_gate_pass` (`gate_pass_id`, `company_id`, `branch_id`, `client_id`, `doc_type`, `doc_no`, `doc_date`, `contact_name`, `contact_address`, `movement_type`, `vehicle_no`, `driver_name`, `transport_mode`, `remarks`, `status`, `requested_by`, `approved_by`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 1, 'gatepass', 'GP-25-00001', '2025-07-23 00:00:00', NULL, NULL, 'Inward', 'kl-1234', 'test', 'bus', NULL, 'Draft', '1', NULL, 1, '2025-07-23 07:32:35', NULL, '2025-07-23 07:32:35');

-- --------------------------------------------------------

--
-- Table structure for table `cs_gate_pass_details`
--

CREATE TABLE `cs_gate_pass_details` (
  `gate_pass_detail_id` bigint(20) UNSIGNED NOT NULL,
  `gate_pass_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_name` varchar(150) DEFAULT NULL,
  `item_code` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `uom` varchar(50) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `is_returnable` tinyint(1) DEFAULT 0,
  `expected_return_date` date DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_gate_pass_details`
--

INSERT INTO `cs_gate_pass_details` (`gate_pass_detail_id`, `gate_pass_id`, `item_name`, `item_code`, `description`, `uom`, `quantity`, `is_returnable`, `expected_return_date`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'item1', NULL, NULL, 'kg', 50.00, 0, NULL, 1, '2025-07-23 07:32:35', NULL, '2025-07-23 07:32:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_general_ledger`
--

CREATE TABLE `cs_general_ledger` (
  `gl_id` bigint(20) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `doc_type` varchar(30) DEFAULT NULL,
  `doc_no` varchar(250) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `doc_date_time` datetime DEFAULT NULL,
  `tran_date` date DEFAULT NULL,
  `tran_type` varchar(2) DEFAULT NULL COMMENT 'DR,CR',
  `account_code` varchar(30) DEFAULT NULL,
  `analytical_code` varchar(250) DEFAULT NULL,
  `other_type` varchar(30) DEFAULT NULL,
  `record_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_inward`
--

CREATE TABLE `cs_inward` (
  `inward_id` int(11) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) DEFAULT NULL,
  `doc_no` varchar(50) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `packing_list_id` bigint(20) DEFAULT NULL,
  `packing_list_detail_id` int(11) DEFAULT NULL,
  `tot_package_qty` decimal(15,2) DEFAULT NULL,
  `pallet_qty` decimal(10,2) DEFAULT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_inward`
--

INSERT INTO `cs_inward` (`inward_id`, `company_id`, `branch_id`, `doc_type`, `doc_no`, `doc_date`, `client_id`, `packing_list_id`, `packing_list_detail_id`, `tot_package_qty`, `pallet_qty`, `reference_number`, `remarks`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'inward', 'IW-25-00001', '2025-08-07', 1, 1, 1, 630.00, 7.00, NULL, NULL, NULL, 1, 1, '2025-08-07 15:36:45', '2025-08-07 15:36:45'),
(2, 1, 1, 'inward', 'IW-25-00002', '2025-08-07', 1, 1, 2, 576.00, 7.00, NULL, NULL, NULL, 1, 1, '2025-08-07 15:47:48', '2025-08-07 15:47:48'),
(3, 1, 1, 'inward', 'IW-25-00003', '2025-08-11', 1, 1, 3, 288.00, 4.00, NULL, NULL, NULL, 1, 1, '2025-08-11 06:35:38', '2025-08-11 06:35:38'),
(4, 1, 1, 'inward', 'IW-25-00004', '2025-08-11', 1, 2, 4, 720.00, 15.00, NULL, NULL, NULL, 1, 1, '2025-08-11 13:08:41', '2025-08-11 13:08:42'),
(5, 1, 1, 'inward', 'IW-25-00005', '2025-08-11', 1, 2, 5, 240.00, 4.00, NULL, NULL, NULL, 1, 1, '2025-08-11 15:22:05', '2025-08-11 15:22:05'),
(6, 1, 1, 'inward', 'IW-25-00006', '2025-08-11', 1, 2, 6, 240.00, 4.00, NULL, NULL, NULL, 1, 1, '2025-08-11 15:23:50', '2025-08-11 15:23:50'),
(7, 1, 1, 'inward', 'IW-25-00007', '2025-08-15', 1, 2, 7, 360.00, 5.00, NULL, NULL, 'finalized', 1, 1, '2025-08-15 18:22:09', '2025-08-15 18:24:14');

-- --------------------------------------------------------

--
-- Table structure for table `cs_inward_detail`
--

CREATE TABLE `cs_inward_detail` (
  `inward_detail_id` bigint(20) NOT NULL,
  `inward_id` bigint(20) DEFAULT NULL,
  `packing_list_id` int(11) DEFAULT NULL,
  `packing_list_detail_id` bigint(20) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `pallet_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_journal`
--

CREATE TABLE `cs_journal` (
  `journal_id` bigint(20) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `doc_type` varchar(10) DEFAULT NULL,
  `doc_no` varchar(250) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `doc_date_time` datetime DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_journal_detail`
--

CREATE TABLE `cs_journal_detail` (
  `journal_detail_id` bigint(20) NOT NULL,
  `journal_id` bigint(20) NOT NULL,
  `account_type` varchar(20) DEFAULT 'GL',
  `account_code` varchar(20) DEFAULT NULL,
  `analytical_code` varchar(250) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `tran_type` varchar(3) DEFAULT NULL,
  `narration` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_level_1`
--

CREATE TABLE `cs_level_1` (
  `level_1_id` int(2) NOT NULL,
  `company_id` int(2) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `alias` text DEFAULT NULL,
  `code` int(10) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cs_level_1`
--

INSERT INTO `cs_level_1` (`level_1_id`, `company_id`, `description`, `alias`, `code`, `sort_order`, `active`, `created_by`, `created_at`) VALUES
(1, 1, 'Assets', 'ASSET', 1000, 1, 1, 1, '2025-08-21 15:19:04'),
(2, 1, 'Liabilities', 'LIAB', 2000, 2, 1, 1, '2025-08-21 15:19:04'),
(3, 1, 'Equity', 'EQUITY', 3000, 3, 1, 1, '2025-08-21 15:19:04'),
(4, 1, 'Income', 'INCOME', 4000, 4, 1, 1, '2025-08-21 15:19:04'),
(5, 1, 'Expenses', 'EXPENSES', 5000, 5, 1, 1, '2025-08-21 15:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `cs_level_2`
--

CREATE TABLE `cs_level_2` (
  `level_1_id` int(2) DEFAULT NULL,
  `company_id` int(2) DEFAULT NULL,
  `level_2_id` int(5) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `code` int(10) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `sort_order` int(3) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cs_level_2`
--

INSERT INTO `cs_level_2` (`level_1_id`, `company_id`, `level_2_id`, `description`, `code`, `active`, `sort_order`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 'Current Assets', 1100, 1, 1, 1, '2025-08-21 15:19:36', NULL, NULL),
(1, 1, 2, 'Fixed Assets', 1200, 1, 2, 1, '2025-08-21 15:19:36', NULL, NULL),
(2, 1, 3, 'Current Liabilities', 2100, 1, 1, 1, '2025-08-21 15:19:36', NULL, NULL),
(2, 1, 4, 'Long Term Liabilities', 2200, 1, 2, 1, '2025-08-21 15:19:36', NULL, NULL),
(3, 1, 5, 'Shareholder Equity', 3100, 1, 1, 1, '2025-08-21 15:19:36', NULL, NULL),
(4, 1, 6, 'Cold Storage Revenue', 4100, 1, 1, 1, '2025-08-21 15:19:36', NULL, NULL),
(4, 1, 7, 'Logistics Revenue', 4200, 1, 2, 1, '2025-08-21 15:19:36', NULL, NULL),
(4, 1, 8, 'Sales Revenue', 4300, 1, 3, 1, '2025-08-21 15:19:36', NULL, NULL),
(5, 1, 9, 'Direct Expenses', 5100, 1, 1, 1, '2025-08-21 15:19:36', NULL, NULL),
(5, 1, 10, 'Indirect Expenses', 5200, 1, 2, 1, '2025-08-21 15:19:36', NULL, NULL),
(5, 1, 11, 'Logistics Expenses', 5300, 1, 3, 1, '2025-08-21 15:19:36', NULL, NULL),
(5, 1, 12, 'Administrative Costs', 5400, 1, 4, 1, '2025-08-21 15:19:36', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_menu`
--

CREATE TABLE `cs_menu` (
  `menu_id` int(5) NOT NULL,
  `parent_id` int(5) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `menu_name` text DEFAULT NULL,
  `menu_desc` text DEFAULT NULL,
  `icon_class` varchar(50) DEFAULT NULL,
  `path` text DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 1,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `display` int(1) NOT NULL DEFAULT 1,
  `display_on_dashboard` int(1) DEFAULT 0,
  `is_quick_menu` int(11) DEFAULT NULL,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_menu`
--

INSERT INTO `cs_menu` (`menu_id`, `parent_id`, `company_id`, `menu_name`, `menu_desc`, `icon_class`, `path`, `short_name`, `sort_order`, `active`, `display`, `display_on_dashboard`, `is_quick_menu`, `del_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, NULL, NULL, 'Admin Module', NULL, 'fas fa-tools', NULL, NULL, 8, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(2, 1, 1, 'Master', 'Master', 'fas fa-cogs', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(3, 2, 1, 'Company', 'Company', 'fas fa-building', 'admin/master/general/company', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(5, NULL, 1, 'Dashboard', NULL, 'fas fa-chart-pie', 'admin/dashboard', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(6, NULL, 1, 'Flowboard', NULL, 'fas fa-project-diagram', 'admin/product-flow', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(7, NULL, 1, 'Sales Module', NULL, 'fas fa-file-alt', NULL, NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(8, 7, 1, 'Forms', NULL, 'fas fa-file-alt', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(9, 7, 1, 'Report', NULL, 'fas fa-file-alt', NULL, NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(10, 8, 1, 'New Customer Enquiry', NULL, 'fas fa-file-alt', 'admin/sales/customer-enquiry', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(11, 8, 1, 'Sales Quotation', NULL, 'fas fa-file-signature', 'admin/sales/sales-quotation', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(13, 8, 1, 'Customer Contract', NULL, 'fas fa-file-signature', 'admin/sales/customer-contract', NULL, 0, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(14, 9, 1, 'Menu', NULL, 'fas fa-file', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(15, 7, 1, 'Setup', NULL, 'fas fa-file-alt', NULL, NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(16, NULL, 1, 'Purchase Module', NULL, 'fas fa-shopping-cart', NULL, NULL, 4, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(17, 16, 1, 'Forms', NULL, 'fas fa-file-alt', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(18, 16, 1, 'Report', NULL, 'fas fa-file-alt', NULL, NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(19, 17, 1, 'Menu', NULL, 'fas fa-file', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(20, 18, 1, 'Menu', NULL, 'fas fa-file', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(21, 16, 1, 'Setup', NULL, 'fas fa-file-alt', NULL, NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(22, 21, 1, 'Supplier', NULL, 'fas fa-truck-loading', 'admin/master/purchase/supplier', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(23, NULL, 1, 'Operation Module', NULL, 'fas fa-warehouse', NULL, NULL, 5, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(24, 23, 1, 'Inward', NULL, 'fas fa-file-alt', NULL, NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(25, 24, 1, 'Order/Packing List', NULL, 'fas fa-file', 'admin/inventory/packing-list', NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(26, 24, 1, 'GRN', NULL, 'fas fa-file-invoice', 'admin/purchase/grn', NULL, 6, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(27, 24, 1, 'Put-Away', NULL, 'fas fa-arrow-down', 'admin/inventory/put-away', NULL, 7, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(28, 84, 1, 'Pick List', NULL, 'fas fa-dolly', 'admin/inventory/pick-list', NULL, 4, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(29, 84, 1, 'Outward', NULL, 'fas fa-arrow-up', 'admin/inventory/outward', NULL, 5, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(30, 24, 1, 'Stock Adjustment', NULL, 'fas fa-exchange-alt', 'admin/inventory/stock-adjustment', NULL, 8, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(31, 33, 1, 'Storage Room', NULL, 'fas fa-warehouse', 'admin/inventory/storage-room', NULL, 7, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(32, 84, 1, 'Gate Pass Out', NULL, 'fas fa-id-badge', 'admin/inventory/gatepass', NULL, 6, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(33, 23, 1, 'Reports', NULL, 'fas fa-file-alt', NULL, NULL, 4, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(34, 33, 1, 'Stock Summary Report', NULL, 'fas fa-file', 'admin/report/stock-summary', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(35, 33, 1, 'Stock Detail Report', NULL, 'fas fa-file', 'admin/report/stock-detail', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(36, 23, 1, 'Setup', NULL, 'fas fa-file-alt', NULL, NULL, 5, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(37, 36, 1, 'Room', NULL, 'fas fa-warehouse', 'admin/master/inventory/rooms', NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(38, 36, 1, 'Block', NULL, 'fas fa-cube', 'admin/master/inventory/blocks', NULL, 4, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(39, 36, 1, 'Rack', NULL, 'fas fa-boxes', 'admin/master/inventory/racks', NULL, 5, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(40, 36, 1, 'Slot', NULL, 'fas fa-layer-group', 'admin/master/inventory/slots', NULL, 6, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(41, 36, 1, 'Pallets', NULL, 'fas fa-pallet', 'admin/master/inventory/pallets', NULL, 7, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(42, 36, 1, 'Pallet Type', NULL, 'fas fa-clipboard-list', 'admin/master/inventory/pallet-type', NULL, 8, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(43, 36, 1, 'Box Count', NULL, 'fas fa-cubes', 'admin/master/inventory/box-count', NULL, 9, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(44, 36, 1, 'Product Attribute', NULL, 'fas fa-tags', 'admin/master/inventory/product-attributes', NULL, 10, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(45, NULL, 1, 'Accounting Module', NULL, 'fas fa-wallet', NULL, NULL, 6, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(46, 45, 1, 'Forms', NULL, 'fas fa-file-alt', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(47, 46, 1, 'Payment', NULL, 'fas fa-file', 'admin/accounting/payment', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(48, 46, 1, 'Receipt', NULL, 'fas fa-file', NULL, NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(49, 46, 1, 'Journal', NULL, 'fas fa-book', 'admin/accounting/journal', NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(50, 45, 1, 'Report', NULL, 'fas fa-file-alt', NULL, NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(51, 50, 1, 'Supplier Ledger', NULL, 'fas fa-file', NULL, NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(52, 50, 1, 'General Ledger', NULL, 'fas fa-file', NULL, NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(53, 45, 1, 'Setup', NULL, 'fas fa-file-alt', NULL, NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(54, 53, 1, 'Chart of Account', NULL, 'fas fa-sitemap', 'admin/master/accounting/chart-of-account', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(55, 53, 1, 'Analytical Master', NULL, 'fas fa-file', 'admin/master/accounting/analytical', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(56, 53, 1, 'Payment Purpose', NULL, 'fas fa-file', 'admin/master/accounting/payment-purpose', NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(57, NULL, 1, 'HR Module', NULL, 'fas fa-users', NULL, NULL, 7, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(58, 57, 1, 'Forms', NULL, 'fas fa-file-alt', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(59, 58, 1, 'Employee', NULL, 'fas fa-file', 'admin/master/hr/employee', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(60, 57, 1, 'Report', NULL, 'fas fa-file-alt', NULL, NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(61, 60, 1, 'Menu', NULL, 'fas fa-file', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(62, 57, 1, 'Setup', NULL, 'fas fa-file-alt', NULL, NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(63, 62, 1, 'Employee', NULL, 'fas fa-user-tie', 'admin/master/hr/employee', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(64, 62, 1, 'User', NULL, 'fas fa-user', 'admin/master/hr/user', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(65, 2, 1, 'Branch', NULL, 'fas fa-cubes', 'admin/master/general/branch', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(66, 2, 1, 'Tax', NULL, 'fas fa-receipt', 'admin/master/general/tax', NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(67, 2, 1, 'Unit', NULL, 'fas fa-ruler', 'admin/master/general/unit', NULL, 4, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(68, 2, 1, 'Product Type', NULL, 'fas fa-box', 'admin/master/general/product-type', NULL, 5, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(69, 2, 1, 'Product Type Price', NULL, 'fas fa-rupee-sign', 'admin/master/general/product-type-price', NULL, 6, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(70, 2, 1, 'Menu', NULL, 'fas fa-bars', 'admin/master/general/menu', NULL, 7, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(72, 1, 1, 'Bulk Import', NULL, 'fas fa-file-import', NULL, NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(73, 72, 1, 'Insert/Import', NULL, 'fas fa-plus-square', 'admin/bulk-import/new', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(74, 72, 1, 'Update', NULL, 'fas fa-edit', 'admin/bulk-import/existing', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(75, 1, 1, 'General', NULL, 'fas fa-tools', NULL, NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(76, 75, 1, 'Profile', NULL, 'fas fa-fw fa-user', 'admin/profile', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(77, 75, 1, 'Change Password', NULL, 'fas fa-fw fa-lock', 'admin/change-password', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(78, 75, 1, 'Settings', NULL, 'fas fa-fw fa-cog', 'admin/settings', NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(79, 36, 1, 'Product', NULL, 'fas fa-box', 'admin/master/inventory/product', NULL, 11, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(82, 24, 1, 'Palletization', 'Palletization', 'fas fa-file-alt', 'admin/inventory/palletization', NULL, 5, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(83, 24, 1, 'Vehicle Temp Inspection', 'Vehicle Temperature Inspection', 'fas fa-thermometer-half', 'admin/inventory/temperature-check', NULL, 4, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(84, 23, 1, 'Outward', 'Outward', 'fas fa-file-alt', NULL, NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(85, 84, 1, 'Vehicle Pre-cooling Inspection', NULL, 'fas fa-clipboard-check', 'admin/inventory/vpci-check', NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(86, 84, 1, 'Customer Releasing Order', NULL, 'fas fa-share-square', 'admin/inventory/releasing-order', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(87, 84, 1, 'Gate Pass In', NULL, 'fas fa-id-card', 'admin/inventory/gatepass-in', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(88, 58, 1, 'User', NULL, 'fas fa-file-alt', 'admin/master/hr/user', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(89, 58, 1, 'Role', NULL, 'fas fa-user-shield', 'admin/master/general/role', NULL, 3, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(90, 50, 1, 'Customer Ledger', NULL, 'fas fa-file-alt', NULL, NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(91, 50, 1, 'Balance Sheet', NULL, 'fas fa-file-alt', NULL, NULL, 4, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(92, 50, 1, 'Trial Balance', NULL, 'fas fa-file-alt', NULL, NULL, 5, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(93, 50, 1, 'Profit & Loss', NULL, 'fas fa-file-alt', NULL, NULL, 6, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(94, 36, 1, 'Warehouse Unit', NULL, 'fas fa-building', 'admin/master/inventory/warehouse-unit', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, 1, NULL, NULL, NULL),
(97, 24, 1, 'Gate Pass In', NULL, 'fas fa-id-card', 'admin/inventory/gatepass-in', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(98, 24, 1, 'Pre-alert', NULL, 'fas fa-info-circle', 'admin/inventory/pre-alert', NULL, 1, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL),
(99, 36, 1, 'Docks', NULL, 'fas fa-truck-loading', 'admin/master/inventory/docks', NULL, 2, '1', 1, 0, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_outward`
--

CREATE TABLE `cs_outward` (
  `outward_id` bigint(20) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) DEFAULT NULL,
  `doc_no` varchar(50) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `contact_name` varchar(150) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `picklist_id` bigint(20) DEFAULT NULL,
  `pallet_qty` int(11) DEFAULT NULL,
  `tot_package_qty` double DEFAULT 0,
  `reference_number` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `vehicle_no` varchar(50) DEFAULT NULL,
  `driver` varchar(200) DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_outward`
--

INSERT INTO `cs_outward` (`outward_id`, `company_id`, `branch_id`, `doc_type`, `doc_no`, `doc_date`, `client_id`, `contact_name`, `contact_address`, `picklist_id`, `pallet_qty`, `tot_package_qty`, `reference_number`, `remarks`, `vehicle_no`, `driver`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 101, 'outward', 'OUT-25-0001', '2025-08-29', 1, 'Ravi Kumar', 'Ocean Fresh Exports Pvt Ltd, Kerala', 1, 5, 120, 'REF-OUT-001', 'Urgent export delivery', 'KL-07-BD-1123', 'John Mathew', 'dispatched', 1, '2025-08-29 21:31:22', 1, '2025-08-29 21:31:22'),
(2, 1, 101, 'outward', 'OUT-25-0002', '2025-08-29', 1, 'Anita Menon', 'Sea Harvest Foods, Kochi', 2, 3, 75, 'REF-OUT-002', 'Requires temperature log', 'TN-22-CX-9087', 'Suresh Kumar', 'dispatched', 1, '2025-08-29 21:31:22', 1, '2025-08-29 21:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `cs_outward_detail`
--

CREATE TABLE `cs_outward_detail` (
  `outward_detail_id` bigint(20) NOT NULL,
  `outward_id` bigint(20) DEFAULT NULL,
  `picklist_detail_id` bigint(20) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `pallet_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_outward_detail`
--

INSERT INTO `cs_outward_detail` (`outward_detail_id`, `outward_id`, `picklist_detail_id`, `room_id`, `rack_id`, `slot_id`, `pallet_id`, `quantity`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 1, 3, 12, 5, 101, 25.00, 'loaded', 1, '2025-08-29 21:31:35', 1, '2025-08-29 21:31:35', NULL, NULL),
(2, 1, 2, 3, 12, 6, 102, 30.00, 'loaded', 1, '2025-08-29 21:31:35', 1, '2025-08-29 21:31:35', NULL, NULL),
(3, 2, 3, 2, 8, 3, 103, 20.00, 'loaded', 1, '2025-08-29 21:31:35', 1, '2025-08-29 21:31:35', NULL, NULL),
(4, 2, 4, 2, 8, 4, 104, 25.00, 'loaded', 1, '2025-08-29 21:31:35', 1, '2025-08-29 21:31:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_package_type`
--

CREATE TABLE `cs_package_type` (
  `package_type_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `stock_unit` varchar(100) NOT NULL,
  `conversion_quantity` varchar(45) DEFAULT NULL,
  `kilo` float DEFAULT NULL,
  `sign` varchar(100) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `active` enum('1','0') DEFAULT NULL,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_packing_list`
--

CREATE TABLE `cs_packing_list` (
  `packing_list_id` bigint(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) DEFAULT NULL,
  `doc_no` varchar(30) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `invoice_no` varchar(250) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `grn_id` int(11) DEFAULT NULL,
  `package_type_id` int(11) DEFAULT NULL,
  `loading_date` date DEFAULT NULL,
  `loading_port_id` int(11) DEFAULT NULL,
  `discharge_port_id` int(11) DEFAULT NULL,
  `shipping_line_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `vessel_name` varchar(250) DEFAULT NULL,
  `voyage_no` varchar(250) DEFAULT NULL,
  `no_of_containers` text DEFAULT NULL,
  `weight_per_pallet` double(15,2) DEFAULT NULL,
  `tot_pallet_qty` double(15,2) DEFAULT NULL,
  `tot_package` double(15,2) DEFAULT NULL,
  `total_gw_kg` double(15,2) DEFAULT NULL,
  `total_nw_kg` double(15,2) DEFAULT NULL,
  `ref_no` text DEFAULT NULL,
  `ref_doc_type` varchar(50) DEFAULT NULL,
  `movement_type` varchar(15) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_packing_list`
--

INSERT INTO `cs_packing_list` (`packing_list_id`, `company_id`, `warehouse_id`, `branch_id`, `doc_type`, `doc_no`, `doc_date`, `invoice_no`, `invoice_date`, `grn_id`, `package_type_id`, `loading_date`, `loading_port_id`, `discharge_port_id`, `shipping_line_id`, `supplier_id`, `client_id`, `contact_person`, `contact_address`, `vessel_name`, `voyage_no`, `no_of_containers`, `weight_per_pallet`, `tot_pallet_qty`, `tot_package`, `total_gw_kg`, `total_nw_kg`, `ref_no`, `ref_doc_type`, `movement_type`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 201, 101, 'Export', 'PKL-25-0001', '2025-08-28', 'INV-20250828-001', '2025-08-28', 3001, 1, '2025-08-29', 11, 21, 5, 401, 501, 'Ravi Kumar', 'Ocean Fresh Exports Pvt Ltd, Kerala', 'MV Blue Horizon', 'VOY-789A', 'CNU123456,CNU123457', 850.00, 5.00, 120.00, 4250.00, 3980.00, 'REF-PL-001', 'GRN', 'out', 'confirmed', 1, '2025-08-29 13:06:56', 1, '2025-08-29 13:06:56'),
(2, 1, 202, 101, 'Export', 'PKL-25-0002', '2025-08-28', 'INV-20250828-002', '2025-08-28', 3002, 2, '2025-08-29', 12, 22, 6, 402, 502, 'Anita Menon', 'Sea Harvest Foods, Kochi', 'MV Ocean Pearl', 'VOY-790B', 'CNU123458', 900.00, 3.00, 75.00, 3200.00, 2985.00, 'REF-PL-002', 'GRN', 'out', 'confirmed', 1, '2025-08-29 13:06:56', 1, '2025-08-29 13:06:56');

-- --------------------------------------------------------

--
-- Table structure for table `cs_packing_list_detail`
--

CREATE TABLE `cs_packing_list_detail` (
  `packing_list_detail_id` bigint(11) NOT NULL,
  `packing_list_id` bigint(11) DEFAULT NULL,
  `container_no` text DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `grn_detail_id` int(11) DEFAULT NULL,
  `cargo_description` text DEFAULT NULL,
  `variety_id` int(11) DEFAULT NULL,
  `class` text DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `lot_no` text DEFAULT NULL,
  `expiry_date` varchar(15) DEFAULT NULL,
  `package_type_id` int(11) DEFAULT NULL,
  `package_qty` double(15,2) DEFAULT 0.00,
  `item_size_per_package` double(15,2) DEFAULT 0.00,
  `package_qty_per_half_pallet` double(15,2) DEFAULT NULL,
  `package_qty_per_full_pallet` double(15,2) DEFAULT 0.00,
  `pallet_qty` double(15,2) DEFAULT 0.00,
  `gw_per_package` double(15,2) DEFAULT 0.00,
  `nw_per_package` double(15,2) DEFAULT 0.00,
  `gw_with_pallet` double(15,2) DEFAULT 0.00,
  `nw_kg` double(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_packing_list_detail`
--

INSERT INTO `cs_packing_list_detail` (`packing_list_detail_id`, `packing_list_id`, `container_no`, `product_id`, `grn_detail_id`, `cargo_description`, `variety_id`, `class`, `brand_id`, `lot_no`, `expiry_date`, `package_type_id`, `package_qty`, `item_size_per_package`, `package_qty_per_half_pallet`, `package_qty_per_full_pallet`, `pallet_qty`, `gw_per_package`, `nw_per_package`, `gw_with_pallet`, `nw_kg`) VALUES
(1, 1, 'CNU123456', 1001, 5001, 'Frozen Prawns - Medium Size', 301, 'A', 201, 'LOT-A1', '2026-03-15', 1, 60.00, 1.25, 30.00, 60.00, 2.00, 35.50, 33.00, 850.00, 800.00),
(2, 1, 'CNU123457', 1002, 5002, 'Frozen Squid Rings - Premium', 302, 'B', 202, 'LOT-B2', '2026-04-10', 1, 60.00, 1.50, 30.00, 60.00, 3.00, 36.00, 34.00, 900.00, 850.00),
(3, 2, 'CNU123458', 1003, 5003, 'Frozen Crab Meat - Grade A', 303, 'A', 203, 'LOT-C3', '2026-02-28', 2, 75.00, 1.00, 37.50, 75.00, 3.00, 42.00, 39.80, 950.00, 900.00);

-- --------------------------------------------------------

--
-- Table structure for table `cs_pallets`
--

CREATE TABLE `cs_pallets` (
  `pallet_id` int(11) NOT NULL,
  `pallet_no` text DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
  `pallet_type_id` int(11) DEFAULT NULL,
  `capacity_unit_id` int(11) DEFAULT NULL,
  `capacity` decimal(10,2) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `max_weight` decimal(10,2) DEFAULT NULL,
  `pallet_position` varchar(251) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `movement_type` varchar(50) DEFAULT NULL,
  `status` enum('empty','partial','full') DEFAULT 'empty',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_pallets`
--

INSERT INTO `cs_pallets` (`pallet_id`, `pallet_no`, `room_id`, `block_id`, `rack_id`, `slot_id`, `name`, `barcode`, `pallet_type_id`, `capacity_unit_id`, `capacity`, `weight`, `max_weight`, `pallet_position`, `client_id`, `movement_type`, `status`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_by`, `deleted_at`) VALUES
(1, 'PLT-0001', 3, 1, 12, 5, 'Pallet A1', 'BARC-PLT-0001', 1, 1, 100.00, 850.00, 1000.00, 'R3-B1-R12-S5', 501, 'in', 'full', 1, '2025-08-29 13:11:10', 1, '2025-08-31 09:20:46', NULL, NULL, NULL),
(2, 'PLT-0002', 3, 1, 12, 6, 'Pallet A2', 'BARC-PLT-0002', 1, 1, 100.00, 820.00, 1000.00, 'R3-B1-R12-S6', 501, 'out', 'partial', 1, '2025-08-29 13:11:10', 1, '2025-08-31 09:20:53', NULL, NULL, NULL),
(3, 'PLT-0003', 2, 2, 8, 3, 'Pallet B1', 'BARC-PLT-0003', 2, 1, 120.00, 900.00, 1200.00, 'R2-B2-R8-S3', 502, 'in', 'full', 1, '2025-08-29 13:11:10', 1, '2025-08-31 09:20:58', NULL, NULL, NULL),
(4, 'PLT-0004', 2, 2, 8, 4, 'Pallet B2', 'BARC-PLT-0004', 2, 1, 120.00, 0.00, 1200.00, 'R2-B2-R8-S4', 502, 'in', 'empty', 1, '2025-08-29 13:11:10', 1, '2025-08-31 09:21:02', NULL, NULL, NULL),
(5, 'PLT-0005', 1, 3, 5, 2, 'Pallet C1', 'BARC-PLT-0005', 3, 1, 80.00, 600.00, 900.00, 'R1-B3-R5-S2', 503, 'picked', 'partial', 1, '2025-08-29 13:11:10', 1, '2025-08-31 09:21:13', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_pallet_types`
--

CREATE TABLE `cs_pallet_types` (
  `pallet_type_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `type_name` varchar(100) NOT NULL,
  `color_code` varchar(15) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_payment_purpose`
--

CREATE TABLE `cs_payment_purpose` (
  `purpose_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `purpose_name` varchar(255) DEFAULT NULL,
  `bsheet_account_code` varchar(15) DEFAULT NULL,
  `exp_account_code` varchar(15) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_payment_purpose`
--

INSERT INTO `cs_payment_purpose` (`purpose_id`, `company_id`, `branch_id`, `purpose_name`, `bsheet_account_code`, `exp_account_code`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 'Travel Advance', '1450', '6020', 1, 1, '2010-09-21 15:26:00', NULL, NULL),
(2, 1, 1, 'Salary Advance', '1440', '1440', 1, 1, '2010-09-21 15:26:00', NULL, NULL),
(3, 1, 1, 'Freight Charge', '1470', '6630', 1, 1, '2010-09-21 15:26:00', NULL, NULL),
(4, 1, 1, 'Food / Tea / Refreshments', '1460', '6030', 1, 1, '2010-09-21 15:27:00', NULL, NULL),
(5, 1, 1, 'Diesel / Petrol Expenses', '1480', '6200', 1, 1, '2008-10-21 12:17:00', NULL, NULL),
(6, 1, 1, 'Donation', '1480', '6015', 1, 1, '2008-10-21 12:19:00', NULL, NULL),
(7, 1, 1, 'Electricity Charge', '1480', '6040', 1, 1, '2008-10-21 12:20:00', NULL, NULL),
(8, 1, 1, 'Medical', '1480', '6035', 1, 1, '2008-10-21 12:20:00', NULL, NULL),
(9, 1, 1, 'Admin / Office Expense', '1480', '6010', 1, 1, '2008-10-21 12:21:00', NULL, NULL),
(10, 1, 1, 'Packing Materials', '1480', '6640', 1, 1, '2008-10-21 12:22:00', NULL, NULL),
(11, 1, 1, 'Personal Drawing - Jaison', '1480', '1030', 1, 1, '2008-10-21 12:22:00', NULL, NULL),
(12, 1, 1, 'Rent Paid', '1480', '6050', 1, 1, '2008-10-21 12:29:00', NULL, NULL),
(13, 1, 1, 'Shop Maintenance', '1480', '6070', 1, 1, '2008-10-21 12:30:00', NULL, NULL),
(14, 1, 1, 'Telephone Charges', '1480', '6045', 1, 1, '2008-10-21 12:31:00', NULL, NULL),
(15, 1, 1, 'TIP & Misc Expenses', '1480', '6080', 1, 1, '2008-10-21 12:31:00', NULL, NULL),
(16, 1, 1, 'Unloading Cooli', '1480', '6760', 1, 1, '2008-10-21 12:32:00', NULL, NULL),
(17, 1, 1, 'Vehicle Repairs & Maintenance', '1480', '6210', 1, 1, '2008-10-21 12:35:00', NULL, NULL),
(18, 1, 1, 'Wages', '1480', '6060', 1, 1, '2008-10-21 12:35:00', NULL, NULL),
(19, 1, 1, 'Waste Disposal', '1480', '6100', 1, 1, '2008-10-21 12:37:00', NULL, NULL),
(20, 1, 1, 'Water / Water Authority', '1480', '6030', 1, 1, '2008-10-21 12:39:00', NULL, NULL),
(21, 1, 1, 'Tray Advance', '1490', '1490', 1, 1, '2016-11-21 18:40:00', NULL, NULL),
(22, 1, 1, 'Bonus', '1440', '6068', 1, 1, '2006-09-22 12:58:00', NULL, NULL),
(23, 1, 1, 'Retail - Ice Cube', '', '5510', 1, 1, '2012-09-22 17:41:00', NULL, NULL),
(24, 1, 1, 'Retail - Ice Cream', '', '5515', 1, 1, '2012-09-22 17:41:00', NULL, NULL),
(25, 1, 1, 'Retail - Soft Drinks', '', '5520', 1, 1, '2012-09-22 17:41:00', NULL, NULL),
(26, 1, 1, 'Retail - Juice Items', '', '5530', 1, 1, '2012-09-22 17:42:00', NULL, NULL),
(27, 1, 1, 'Retail - Travel Expenses', '', '5560', 1, 1, '2012-09-22 17:42:00', NULL, NULL),
(28, 1, 1, 'Staff Salary & Wages', '6065', '6065', 0, 1, '2011-11-22 16:58:00', NULL, NULL),
(29, 1, 1, 'Personal Drawing - Bisty Jaison', '1480', '1031', 1, 1, '2002-12-22 11:33:00', NULL, NULL),
(30, 1, 1, 'Personal Drawing - Jessamma Johnson', '1480', '1032', 1, 1, '2002-12-22 11:34:00', NULL, NULL),
(31, 1, 1, 'Personal Drawing - Jackson Johns', '1480', '1033', 1, 1, '2002-12-22 11:35:00', NULL, NULL),
(32, 1, 1, 'Loans to Employees', '1480', '1710', 1, 1, '2003-12-22 15:39:00', NULL, NULL),
(33, 1, 1, 'Loans to Outsiders', '1480', '1720', 1, 1, '2003-12-22 15:41:00', NULL, NULL),
(34, 1, 1, 'Retail Expense', '', '5590', 1, 1, '2011-01-23 16:30:00', NULL, NULL),
(35, 1, 1, 'Kalapura Pumb', '1073', '', 1, 1, '2011-01-23 16:32:00', NULL, NULL),
(36, 1, 1, 'Retail Building Rent', '', '5570', 1, 1, '2011-01-23 16:35:00', NULL, NULL),
(37, 1, 1, 'Salary Payable', '2315', '2315', 1, 1, '2011-01-23 16:40:00', NULL, NULL),
(38, 1, 1, 'Travelling Expense', '', '6020', 1, 1, '2012-01-23 14:21:00', NULL, NULL),
(39, 1, 1, 'Incentive', '', '6067', 1, 1, '2008-02-23 10:58:00', NULL, NULL),
(40, 1, 1, 'Labour Board', '', '6790', 1, 1, '2005-04-23 17:02:00', NULL, NULL),
(41, 1, 1, 'Advance for Vehicle Maintananace', '1496', '6210', 1, 1, '2001-11-23 13:54:00', NULL, NULL),
(42, 1, 1, 'Advance for Shope maintanance', '1495', '6070', 1, 1, '2001-11-23 13:55:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_payment_settlement`
--

CREATE TABLE `cs_payment_settlement` (
  `settlement_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `voucher_id` int(11) DEFAULT NULL,
  `account_code` varchar(15) NOT NULL,
  `analytical_code` varchar(250) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `tran_type` varchar(2) DEFAULT NULL,
  `narration` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `settle_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_payment_voucher`
--

CREATE TABLE `cs_payment_voucher` (
  `payment_voucher_id` bigint(20) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `doc_type` varchar(30) DEFAULT NULL,
  `doc_no` varchar(250) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `doc_date_time` datetime DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `voucher_type` varchar(100) DEFAULT NULL COMMENT 'pettycash, supplier payment, contra',
  `transaction_type` varchar(50) DEFAULT NULL COMMENT 'cash, transfer, cheque, UPI',
  `payment_type` varchar(50) DEFAULT NULL COMMENT 'full,partial,advance',
  `purpose_id` int(11) DEFAULT NULL,
  `from_account_code` varchar(30) DEFAULT NULL,
  `to_account_code` varchar(30) DEFAULT NULL,
  `from_analytical_code` varchar(250) DEFAULT NULL,
  `to_analytical_code` varchar(250) DEFAULT NULL,
  `from_narration` text DEFAULT NULL,
  `to_narration` text DEFAULT NULL,
  `bank_master_id` int(11) DEFAULT NULL,
  `supplier_bank` varchar(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `requested_amount` double DEFAULT NULL,
  `approved_amount` double DEFAULT NULL,
  `settled_amount` double(15,2) DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `reference_date` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `is_advance` tinyint(1) NOT NULL DEFAULT 0,
  `paid_by` int(11) DEFAULT NULL,
  `requested_by` int(11) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `settled_by` int(11) DEFAULT NULL,
  `requested_date` datetime DEFAULT NULL,
  `approved_date` datetime DEFAULT NULL,
  `settled_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_permission`
--

CREATE TABLE `cs_permission` (
  `permission_id` int(11) NOT NULL,
  `code` char(1) NOT NULL COMMENT 'A=Add, E=Edit, D=Delete, V=View',
  `name` varchar(50) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_permission`
--

INSERT INTO `cs_permission` (`permission_id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'A', 'Add', '2025-07-24 17:59:08', NULL),
(2, 'E', 'Edit', '2025-07-24 17:59:08', NULL),
(3, 'D', 'Delete', '2025-07-24 17:59:08', NULL),
(4, 'V', 'View', '2025-07-24 17:59:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_picklist`
--

CREATE TABLE `cs_picklist` (
  `picklist_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) DEFAULT NULL,
  `doc_no` varchar(30) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `packing_list_id` int(11) DEFAULT NULL,
  `pallet_qty` int(11) DEFAULT NULL,
  `tot_package_qty` int(11) DEFAULT NULL,
  `contact_name` varchar(50) DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `dispatch_date` date DEFAULT NULL,
  `dispatch_location` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'picked',
  `remarks` text DEFAULT NULL,
  `client_id` bigint(20) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_picklist`
--

INSERT INTO `cs_picklist` (`picklist_id`, `company_id`, `branch_id`, `doc_type`, `doc_no`, `doc_date`, `packing_list_id`, `pallet_qty`, `tot_package_qty`, `contact_name`, `contact_address`, `dispatch_date`, `dispatch_location`, `status`, `remarks`, `client_id`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 101, 'picklist', 'PL-25-0001', '2025-08-29', 1, 5, 120, 'Ravi Kumar', 'Ocean Fresh Exports Pvt Ltd, Kerala', '2025-08-30', 'Chennai Port Terminal', 'picked', 'Urgent delivery for export', 1, 1, '2025-08-29 13:01:37', 1, '2025-08-29 13:08:02'),
(2, 1, 101, 'picklist', 'PL-25-0002', '2025-08-29', 2, 3, 75, 'Anita Menon', 'Sea Harvest Foods, Kochi', '2025-08-30', 'Tuticorin Port', 'picked', 'Requires temperature log', 1, 1, '2025-08-29 13:01:37', 1, '2025-08-29 13:08:09');

-- --------------------------------------------------------

--
-- Table structure for table `cs_picklist_detail`
--

CREATE TABLE `cs_picklist_detail` (
  `picklist_detail_id` bigint(20) UNSIGNED NOT NULL,
  `picklist_id` int(10) UNSIGNED DEFAULT NULL,
  `packing_list_detail_id` bigint(20) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `pallet_id` int(11) DEFAULT NULL,
  `quantity` double(15,2) NOT NULL,
  `total_weight` decimal(10,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(20) DEFAULT 'picked',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_picklist_detail`
--

INSERT INTO `cs_picklist_detail` (`picklist_detail_id`, `picklist_id`, `packing_list_detail_id`, `room_id`, `rack_id`, `slot_id`, `pallet_id`, `quantity`, `total_weight`, `created_by`, `status`, `remarks`, `created_at`, `updated_by`, `updated_at`, `deleted_by`, `deleted_at`) VALUES
(1, 1, 1, 3, 12, 5, 1, 25.00, 450.50, 1, 'picked', 'Frozen prawns batch A', '2025-08-29 13:01:50', 1, '2025-08-29 13:09:51', NULL, NULL),
(2, 1, 2, 3, 12, 6, 2, 30.00, 520.75, 1, 'picked', 'Frozen squid rings batch B', '2025-08-29 13:01:50', 1, '2025-08-29 13:09:56', NULL, NULL),
(3, 2, 2, 2, 8, 3, 3, 20.00, 380.00, 1, 'picked', 'Frozen crab meat batch C', '2025-08-29 13:01:50', 1, '2025-08-29 13:10:01', NULL, NULL),
(4, 2, 1, 2, 8, 4, 4, 25.00, 410.25, 1, 'picked', 'Frozen fish fillet batch D', '2025-08-29 13:01:50', 1, '2025-08-29 13:10:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_place`
--

CREATE TABLE `cs_place` (
  `place_id` bigint(20) NOT NULL,
  `route_id` int(11) DEFAULT NULL,
  `place_name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` enum('YES','NO') CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(25) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(25) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_port`
--

CREATE TABLE `cs_port` (
  `port_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `port_name` varchar(255) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_post_office`
--

CREATE TABLE `cs_post_office` (
  `post_office_id` int(11) NOT NULL,
  `country_id` int(2) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `post_office` varchar(50) DEFAULT NULL,
  `pincode` varchar(50) DEFAULT NULL,
  `company_id` int(3) DEFAULT NULL,
  `region_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_post_office`
--

INSERT INTO `cs_post_office` (`post_office_id`, `country_id`, `state_id`, `district_id`, `post_office`, `pincode`, `company_id`, `region_id`, `sort_order`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 1, 'Edapally', '123456', 1, 1, 1, 1, 1, '2025-05-31 18:53:33', 1, '2025-05-31 18:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `cs_product`
--

CREATE TABLE `cs_product` (
  `product_id` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `product_name` varchar(45) DEFAULT NULL,
  `product_description` varchar(200) DEFAULT NULL,
  `product_code` varchar(45) DEFAULT NULL,
  `product_group_id` int(11) DEFAULT NULL,
  `tax_id` int(3) NOT NULL,
  `short_name` varchar(50) DEFAULT NULL,
  `datasheet` varchar(45) DEFAULT NULL,
  `recipe` varchar(300) DEFAULT NULL,
  `preparation` varchar(300) DEFAULT NULL,
  `image` varchar(300) DEFAULT NULL,
  `new` int(1) NOT NULL,
  `unknown` int(1) NOT NULL DEFAULT 0,
  `allow_negative` int(1) NOT NULL DEFAULT 0,
  `weight_per_box` double DEFAULT NULL,
  `box_capacity_per_full_pallet` double DEFAULT NULL,
  `box_capacity_per_half_pallet` double(15,2) DEFAULT NULL,
  `active` int(1) DEFAULT 1,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_product_attributes`
--

CREATE TABLE `cs_product_attributes` (
  `product_attribute_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `data_type` varchar(50) DEFAULT 'string',
  `is_required` tinyint(1) DEFAULT 0,
  `default_value` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_product_attributes`
--

INSERT INTO `cs_product_attributes` (`product_attribute_id`, `name`, `data_type`, `is_required`, `default_value`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Grade', 'string', 0, NULL, NULL, '2025-08-30 05:27:33', NULL, '2025-08-30 05:27:33'),
(2, 'Color', 'string', 0, NULL, NULL, '2025-08-30 05:27:33', NULL, '2025-08-30 05:27:33');

-- --------------------------------------------------------

--
-- Table structure for table `cs_product_category`
--

CREATE TABLE `cs_product_category` (
  `product_category_id` int(11) NOT NULL,
  `product_category_id_data_mig` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `product_category_name` varchar(100) DEFAULT NULL,
  `short_name` varchar(50) NOT NULL,
  `product_division_id` int(11) DEFAULT NULL,
  `tax` text DEFAULT NULL,
  `ac_cash_sales` varchar(6) NOT NULL,
  `ac_credit_sales` varchar(6) NOT NULL,
  `ac_interco_sales` varchar(6) NOT NULL,
  `ac_other_sales` varchar(6) NOT NULL,
  `ac_receivable_control` varchar(6) NOT NULL,
  `active` enum('1','0') DEFAULT NULL,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_product_master`
--

CREATE TABLE `cs_product_master` (
  `product_master_id` bigint(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `division_id` int(11) DEFAULT NULL,
  `product_division_id` int(11) DEFAULT NULL,
  `product_category_id` int(11) DEFAULT NULL,
  `product_group_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_packing_id` int(11) DEFAULT NULL,
  `purchase_unit_id` int(3) NOT NULL,
  `selling_unit_id` int(3) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `product_origin_id` int(11) DEFAULT NULL,
  `tax_id` int(3) NOT NULL,
  `tax` double NOT NULL,
  `product_new_group` text NOT NULL,
  `product_description` text DEFAULT NULL,
  `product_description_temp` text DEFAULT NULL,
  `product_code` varchar(45) NOT NULL,
  `product_code_supplier` varchar(15) NOT NULL,
  `prod_desc_supplier` text NOT NULL,
  `hsn_code` varchar(15) NOT NULL,
  `supplier_id` int(3) NOT NULL,
  `min_stock_qty` double NOT NULL DEFAULT 0,
  `max_stock_qty` double NOT NULL DEFAULT 0,
  `re_order_level` double NOT NULL DEFAULT 0,
  `re_order_qty` double NOT NULL DEFAULT 0,
  `barcode_in_house` varchar(48) NOT NULL,
  `barcode_supplier` varchar(48) DEFAULT NULL,
  `new` int(1) NOT NULL,
  `unknown` int(1) NOT NULL DEFAULT 0,
  `product_weight` double NOT NULL,
  `allow_negative` int(1) NOT NULL DEFAULT 0,
  `loose` int(1) NOT NULL DEFAULT 1,
  `single_batch` int(1) NOT NULL DEFAULT 0,
  `weight_per_box` double DEFAULT NULL,
  `box_capacity_per_full_pallet` double DEFAULT NULL,
  `box_capacity_per_half_pallet` double(15,2) DEFAULT NULL,
  `no_of_items_in_box` double DEFAULT NULL,
  `active` int(1) DEFAULT 1,
  `arrival_date` date DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_product_specifications`
--

CREATE TABLE `cs_product_specifications` (
  `prod_spec_id` bigint(20) UNSIGNED NOT NULL,
  `prod_attribute_id` bigint(20) UNSIGNED NOT NULL,
  `prod_attribute_value` varchar(255) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_product_types`
--

CREATE TABLE `cs_product_types` (
  `product_type_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `type_name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `rate_per_day` double DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_product_types`
--

INSERT INTO `cs_product_types` (`product_type_id`, `company_id`, `branch_id`, `type_name`, `description`, `rate_per_day`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 'Chilled', 'Chilled', 100, 1, 1, '2025-07-21 17:03:30', 1, '2025-07-21 17:18:40'),
(2, 1, 1, 'Frozen', 'Frozen', 200, 1, 1, '2025-07-22 15:54:05', NULL, '2025-07-22 15:54:05'),
(3, 1, 1, 'Dry', 'Dry', 300, 1, 1, '2025-07-22 15:54:23', NULL, '2025-07-22 15:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `cs_product_type_price`
--

CREATE TABLE `cs_product_type_price` (
  `price_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00,
  `active` enum('1','0') DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_product_variants`
--

CREATE TABLE `cs_product_variants` (
  `product_variant_id` bigint(20) UNSIGNED NOT NULL,
  `product_master_id` bigint(20) UNSIGNED NOT NULL,
  `variant_name` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_product_variant_specifications`
--

CREATE TABLE `cs_product_variant_specifications` (
  `prod_variant_spec_id` bigint(20) UNSIGNED NOT NULL,
  `product_variant_id` bigint(20) UNSIGNED NOT NULL,
  `prod_spec_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_prod_cat_svg_img`
--

CREATE TABLE `cs_prod_cat_svg_img` (
  `prod_cat_svg_img_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `svg_icon` text NOT NULL,
  `box_count` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` bigint(20) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_prod_cat_svg_img`
--

INSERT INTO `cs_prod_cat_svg_img` (`prod_cat_svg_img_id`, `category_id`, `svg_icon`, `box_count`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🧺\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(2, 2, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍎\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(3, 3, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🥭\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(4, 4, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍊\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(5, 5, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🫐\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(6, 6, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍇\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(7, 7, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🥝\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(8, 8, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🥑\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(9, 9, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍇\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(10, 10, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🥥\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(11, 11, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍋\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(12, 12, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🥒\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(13, 13, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🌴\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(14, 14, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🐉\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(15, 15, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🥭\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(16, 16, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🌰\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(17, 17, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍑\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(18, 18, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍊\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(19, 19, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍉\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(20, 20, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍈\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(21, 21, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🥭\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(22, 22, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍆\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(23, 23, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍋\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(24, 24, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍏\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(25, 25, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍌\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(26, 26, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍊\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(27, 27, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍈\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(28, 28, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍇\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(29, 29, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍑\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(30, 30, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍐\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(31, 31, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍍\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(32, 32, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍑\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(33, 33, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🧠\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(34, 34, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍇\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(35, 35, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍆\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(36, 36, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🌱\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(37, 37, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍈\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(38, 38, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍈\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(39, 39, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍓\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(40, 40, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🍈\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(41, 41, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🎋\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(42, 42, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🌰\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL),
(43, 43, '    <svg width=\"60\" height=\"60\" xmlns=\"http://www.w3.org/2000/svg\">\n    <text x=\"50%\" y=\"50%\" dominant-baseline=\"middle\" text-anchor=\"middle\"\n            font-size=\"28\" font-family=\"Segoe UI Emoji, Apple Color Emoji, sans-serif\">\n            🥦\n    </text>\n    </svg>', NULL, 1, '2025-06-01 00:02:26', NULL, '2025-06-01 00:02:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_racks`
--

CREATE TABLE `cs_racks` (
  `rack_id` int(11) NOT NULL,
  `rack_no` text DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `block_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` decimal(10,2) DEFAULT NULL,
  `position_x` int(11) DEFAULT NULL,
  `position_y` int(11) DEFAULT NULL,
  `no_of_levels` int(11) DEFAULT NULL,
  `no_of_depth` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_racks`
--

INSERT INTO `cs_racks` (`rack_id`, `rack_no`, `room_id`, `block_id`, `name`, `capacity`, `position_x`, `position_y`, `no_of_levels`, `no_of_depth`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'R1', 1, 1, 'R1', NULL, NULL, NULL, 4, 4, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(2, 'R2', 1, 1, 'R2', NULL, NULL, NULL, 4, 4, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(3, 'R3', 1, 1, 'R3', NULL, NULL, NULL, 4, 4, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(4, 'R4', 1, 1, 'R4', NULL, NULL, NULL, 4, 4, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(5, 'R5', 1, 2, 'R5', NULL, NULL, NULL, 4, 4, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(6, 'R6', 1, 2, 'R6', NULL, NULL, NULL, 4, 4, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(7, 'R7', 1, 2, 'R7', NULL, NULL, NULL, 4, 4, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(8, 'R1', 2, 1, 'R1', NULL, NULL, NULL, 4, 5, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(9, 'R2', 2, 1, 'R2', NULL, NULL, NULL, 4, 5, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(10, 'R3', 2, 1, 'R3', NULL, NULL, NULL, 4, 5, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(11, 'R4', 2, 1, 'R4', NULL, NULL, NULL, 4, 5, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(12, 'R5', 2, 2, 'R5', NULL, NULL, NULL, 4, 5, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(13, 'R6', 2, 2, 'R6', NULL, NULL, NULL, 4, 5, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(14, 'R7', 2, 2, 'R7', NULL, NULL, NULL, 4, 5, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(15, 'R1', 3, 1, 'R1', NULL, NULL, NULL, 4, 3, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(16, 'R2', 3, 1, 'R2', NULL, NULL, NULL, 4, 3, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(17, 'R3', 3, 1, 'R3', NULL, NULL, NULL, 4, 3, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(18, 'R4', 3, 1, 'R4', NULL, NULL, NULL, 4, 3, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(19, 'R5', 3, 2, 'R5', NULL, NULL, NULL, 4, 3, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(20, 'R6', 3, 2, 'R6', NULL, NULL, NULL, 4, 3, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(21, 'R7', 3, 2, 'R7', NULL, NULL, NULL, 4, 3, 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_receipt`
--

CREATE TABLE `cs_receipt` (
  `receipt_id` bigint(20) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `doc_type` varchar(10) DEFAULT NULL,
  `doc_no` varchar(250) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `doc_date_time` datetime DEFAULT NULL,
  `receipt_date` date DEFAULT NULL,
  `voucher_type` varchar(100) DEFAULT NULL COMMENT 'pettycash, client payment, contra',
  `payment_mode` varchar(50) DEFAULT NULL COMMENT 'cash, transfer, cheque, UPI',
  `payment_type` varchar(50) DEFAULT NULL COMMENT 'full,partial,advance',
  `from_account_code` varchar(30) DEFAULT NULL,
  `to_account_code` varchar(30) DEFAULT NULL,
  `analytical_code` varchar(250) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `Remarks` text DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_role`
--

CREATE TABLE `cs_role` (
  `role_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_desc` text DEFAULT NULL,
  `mobile_access` tinyint(1) DEFAULT 0,
  `active` tinyint(1) DEFAULT 1,
  `del_status` tinyint(1) DEFAULT 1,
  `short_name` varchar(50) DEFAULT NULL,
  `duties_and_resp` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_role`
--

INSERT INTO `cs_role` (`role_id`, `company_id`, `role_name`, `role_desc`, `mobile_access`, `active`, `del_status`, `short_name`, `duties_and_resp`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, NULL, 'Admin', 'Admin', 1, 0, 1, NULL, NULL, NULL, '2025-07-25 10:07:20', 1, '2025-08-21 12:32:16');

-- --------------------------------------------------------

--
-- Table structure for table `cs_role_menu_permission`
--

CREATE TABLE `cs_role_menu_permission` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_role_menu_permission`
--

INSERT INTO `cs_role_menu_permission` (`id`, `role_id`, `menu_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(2613, 1, 5, 1, '2025-08-26 13:05:48', NULL),
(2614, 1, 5, 2, '2025-08-26 13:05:48', NULL),
(2615, 1, 5, 3, '2025-08-26 13:05:48', NULL),
(2616, 1, 5, 4, '2025-08-26 13:05:48', NULL),
(2617, 1, 6, 1, '2025-08-26 13:05:48', NULL),
(2618, 1, 6, 2, '2025-08-26 13:05:48', NULL),
(2619, 1, 6, 3, '2025-08-26 13:05:48', NULL),
(2620, 1, 6, 4, '2025-08-26 13:05:48', NULL),
(2621, 1, 7, 1, '2025-08-26 13:05:48', NULL),
(2622, 1, 7, 2, '2025-08-26 13:05:48', NULL),
(2623, 1, 7, 3, '2025-08-26 13:05:48', NULL),
(2624, 1, 7, 4, '2025-08-26 13:05:48', NULL),
(2625, 1, 8, 1, '2025-08-26 13:05:48', NULL),
(2626, 1, 8, 2, '2025-08-26 13:05:48', NULL),
(2627, 1, 8, 3, '2025-08-26 13:05:48', NULL),
(2628, 1, 8, 4, '2025-08-26 13:05:48', NULL),
(2629, 1, 13, 1, '2025-08-26 13:05:48', NULL),
(2630, 1, 13, 2, '2025-08-26 13:05:48', NULL),
(2631, 1, 13, 3, '2025-08-26 13:05:48', NULL),
(2632, 1, 13, 4, '2025-08-26 13:05:48', NULL),
(2633, 1, 10, 1, '2025-08-26 13:05:48', NULL),
(2634, 1, 10, 2, '2025-08-26 13:05:48', NULL),
(2635, 1, 10, 3, '2025-08-26 13:05:48', NULL),
(2636, 1, 10, 4, '2025-08-26 13:05:48', NULL),
(2637, 1, 11, 1, '2025-08-26 13:05:48', NULL),
(2638, 1, 11, 2, '2025-08-26 13:05:48', NULL),
(2639, 1, 11, 3, '2025-08-26 13:05:48', NULL),
(2640, 1, 11, 4, '2025-08-26 13:05:48', NULL),
(2641, 1, 9, 1, '2025-08-26 13:05:48', NULL),
(2642, 1, 9, 2, '2025-08-26 13:05:48', NULL),
(2643, 1, 9, 3, '2025-08-26 13:05:48', NULL),
(2644, 1, 9, 4, '2025-08-26 13:05:48', NULL),
(2645, 1, 14, 1, '2025-08-26 13:05:48', NULL),
(2646, 1, 14, 2, '2025-08-26 13:05:48', NULL),
(2647, 1, 14, 3, '2025-08-26 13:05:48', NULL),
(2648, 1, 14, 4, '2025-08-26 13:05:48', NULL),
(2649, 1, 15, 1, '2025-08-26 13:05:48', NULL),
(2650, 1, 15, 2, '2025-08-26 13:05:48', NULL),
(2651, 1, 15, 3, '2025-08-26 13:05:48', NULL),
(2652, 1, 15, 4, '2025-08-26 13:05:48', NULL),
(2653, 1, 16, 1, '2025-08-26 13:05:48', NULL),
(2654, 1, 16, 2, '2025-08-26 13:05:48', NULL),
(2655, 1, 16, 3, '2025-08-26 13:05:48', NULL),
(2656, 1, 16, 4, '2025-08-26 13:05:48', NULL),
(2657, 1, 17, 1, '2025-08-26 13:05:48', NULL),
(2658, 1, 17, 2, '2025-08-26 13:05:48', NULL),
(2659, 1, 17, 3, '2025-08-26 13:05:48', NULL),
(2660, 1, 17, 4, '2025-08-26 13:05:48', NULL),
(2661, 1, 19, 1, '2025-08-26 13:05:48', NULL),
(2662, 1, 19, 2, '2025-08-26 13:05:48', NULL),
(2663, 1, 19, 3, '2025-08-26 13:05:48', NULL),
(2664, 1, 19, 4, '2025-08-26 13:05:48', NULL),
(2665, 1, 18, 1, '2025-08-26 13:05:48', NULL),
(2666, 1, 18, 2, '2025-08-26 13:05:48', NULL),
(2667, 1, 18, 3, '2025-08-26 13:05:48', NULL),
(2668, 1, 18, 4, '2025-08-26 13:05:48', NULL),
(2669, 1, 20, 1, '2025-08-26 13:05:48', NULL),
(2670, 1, 20, 2, '2025-08-26 13:05:48', NULL),
(2671, 1, 20, 3, '2025-08-26 13:05:48', NULL),
(2672, 1, 20, 4, '2025-08-26 13:05:48', NULL),
(2673, 1, 21, 1, '2025-08-26 13:05:48', NULL),
(2674, 1, 21, 2, '2025-08-26 13:05:48', NULL),
(2675, 1, 21, 3, '2025-08-26 13:05:48', NULL),
(2676, 1, 21, 4, '2025-08-26 13:05:48', NULL),
(2677, 1, 22, 1, '2025-08-26 13:05:48', NULL),
(2678, 1, 22, 2, '2025-08-26 13:05:48', NULL),
(2679, 1, 22, 3, '2025-08-26 13:05:48', NULL),
(2680, 1, 22, 4, '2025-08-26 13:05:48', NULL),
(2681, 1, 23, 1, '2025-08-26 13:05:48', NULL),
(2682, 1, 23, 2, '2025-08-26 13:05:48', NULL),
(2683, 1, 23, 3, '2025-08-26 13:05:48', NULL),
(2684, 1, 23, 4, '2025-08-26 13:05:48', NULL),
(2685, 1, 24, 1, '2025-08-26 13:05:48', NULL),
(2686, 1, 24, 2, '2025-08-26 13:05:48', NULL),
(2687, 1, 24, 3, '2025-08-26 13:05:48', NULL),
(2688, 1, 24, 4, '2025-08-26 13:05:48', NULL),
(2689, 1, 98, 1, '2025-08-26 13:05:48', NULL),
(2690, 1, 98, 2, '2025-08-26 13:05:48', NULL),
(2691, 1, 98, 3, '2025-08-26 13:05:48', NULL),
(2692, 1, 98, 4, '2025-08-26 13:05:48', NULL),
(2693, 1, 97, 1, '2025-08-26 13:05:48', NULL),
(2694, 1, 97, 2, '2025-08-26 13:05:48', NULL),
(2695, 1, 97, 3, '2025-08-26 13:05:48', NULL),
(2696, 1, 97, 4, '2025-08-26 13:05:48', NULL),
(2697, 1, 25, 1, '2025-08-26 13:05:48', NULL),
(2698, 1, 25, 2, '2025-08-26 13:05:48', NULL),
(2699, 1, 25, 3, '2025-08-26 13:05:48', NULL),
(2700, 1, 25, 4, '2025-08-26 13:05:48', NULL),
(2701, 1, 83, 1, '2025-08-26 13:05:48', NULL),
(2702, 1, 83, 2, '2025-08-26 13:05:48', NULL),
(2703, 1, 83, 3, '2025-08-26 13:05:48', NULL),
(2704, 1, 83, 4, '2025-08-26 13:05:48', NULL),
(2705, 1, 82, 1, '2025-08-26 13:05:48', NULL),
(2706, 1, 82, 2, '2025-08-26 13:05:48', NULL),
(2707, 1, 82, 3, '2025-08-26 13:05:48', NULL),
(2708, 1, 82, 4, '2025-08-26 13:05:48', NULL),
(2709, 1, 26, 1, '2025-08-26 13:05:48', NULL),
(2710, 1, 26, 2, '2025-08-26 13:05:48', NULL),
(2711, 1, 26, 3, '2025-08-26 13:05:48', NULL),
(2712, 1, 26, 4, '2025-08-26 13:05:48', NULL),
(2713, 1, 27, 1, '2025-08-26 13:05:48', NULL),
(2714, 1, 27, 2, '2025-08-26 13:05:48', NULL),
(2715, 1, 27, 3, '2025-08-26 13:05:48', NULL),
(2716, 1, 27, 4, '2025-08-26 13:05:48', NULL),
(2717, 1, 30, 1, '2025-08-26 13:05:48', NULL),
(2718, 1, 30, 2, '2025-08-26 13:05:48', NULL),
(2719, 1, 30, 3, '2025-08-26 13:05:48', NULL),
(2720, 1, 30, 4, '2025-08-26 13:05:48', NULL),
(2721, 1, 84, 1, '2025-08-26 13:05:48', NULL),
(2722, 1, 84, 2, '2025-08-26 13:05:48', NULL),
(2723, 1, 84, 3, '2025-08-26 13:05:48', NULL),
(2724, 1, 84, 4, '2025-08-26 13:05:48', NULL),
(2725, 1, 86, 1, '2025-08-26 13:05:48', NULL),
(2726, 1, 86, 2, '2025-08-26 13:05:48', NULL),
(2727, 1, 86, 3, '2025-08-26 13:05:48', NULL),
(2728, 1, 86, 4, '2025-08-26 13:05:48', NULL),
(2729, 1, 87, 1, '2025-08-26 13:05:48', NULL),
(2730, 1, 87, 2, '2025-08-26 13:05:48', NULL),
(2731, 1, 87, 3, '2025-08-26 13:05:48', NULL),
(2732, 1, 87, 4, '2025-08-26 13:05:48', NULL),
(2733, 1, 85, 1, '2025-08-26 13:05:48', NULL),
(2734, 1, 85, 2, '2025-08-26 13:05:48', NULL),
(2735, 1, 85, 3, '2025-08-26 13:05:48', NULL),
(2736, 1, 85, 4, '2025-08-26 13:05:48', NULL),
(2737, 1, 28, 1, '2025-08-26 13:05:48', NULL),
(2738, 1, 28, 2, '2025-08-26 13:05:48', NULL),
(2739, 1, 28, 3, '2025-08-26 13:05:48', NULL),
(2740, 1, 28, 4, '2025-08-26 13:05:48', NULL),
(2741, 1, 29, 1, '2025-08-26 13:05:48', NULL),
(2742, 1, 29, 2, '2025-08-26 13:05:48', NULL),
(2743, 1, 29, 3, '2025-08-26 13:05:48', NULL),
(2744, 1, 29, 4, '2025-08-26 13:05:48', NULL),
(2745, 1, 32, 1, '2025-08-26 13:05:48', NULL),
(2746, 1, 32, 2, '2025-08-26 13:05:48', NULL),
(2747, 1, 32, 3, '2025-08-26 13:05:48', NULL),
(2748, 1, 32, 4, '2025-08-26 13:05:48', NULL),
(2749, 1, 33, 1, '2025-08-26 13:05:48', NULL),
(2750, 1, 33, 2, '2025-08-26 13:05:48', NULL),
(2751, 1, 33, 3, '2025-08-26 13:05:48', NULL),
(2752, 1, 33, 4, '2025-08-26 13:05:48', NULL),
(2753, 1, 34, 1, '2025-08-26 13:05:48', NULL),
(2754, 1, 34, 2, '2025-08-26 13:05:48', NULL),
(2755, 1, 34, 3, '2025-08-26 13:05:48', NULL),
(2756, 1, 34, 4, '2025-08-26 13:05:48', NULL),
(2757, 1, 35, 1, '2025-08-26 13:05:48', NULL),
(2758, 1, 35, 2, '2025-08-26 13:05:48', NULL),
(2759, 1, 35, 3, '2025-08-26 13:05:48', NULL),
(2760, 1, 35, 4, '2025-08-26 13:05:48', NULL),
(2761, 1, 31, 1, '2025-08-26 13:05:48', NULL),
(2762, 1, 31, 2, '2025-08-26 13:05:48', NULL),
(2763, 1, 31, 3, '2025-08-26 13:05:48', NULL),
(2764, 1, 31, 4, '2025-08-26 13:05:48', NULL),
(2765, 1, 36, 1, '2025-08-26 13:05:48', NULL),
(2766, 1, 36, 2, '2025-08-26 13:05:48', NULL),
(2767, 1, 36, 3, '2025-08-26 13:05:48', NULL),
(2768, 1, 36, 4, '2025-08-26 13:05:48', NULL),
(2769, 1, 94, 1, '2025-08-26 13:05:48', NULL),
(2770, 1, 94, 2, '2025-08-26 13:05:48', NULL),
(2771, 1, 94, 3, '2025-08-26 13:05:48', NULL),
(2772, 1, 94, 4, '2025-08-26 13:05:48', NULL),
(2773, 1, 99, 1, '2025-08-26 13:05:48', NULL),
(2774, 1, 99, 2, '2025-08-26 13:05:48', NULL),
(2775, 1, 99, 3, '2025-08-26 13:05:48', NULL),
(2776, 1, 99, 4, '2025-08-26 13:05:48', NULL),
(2777, 1, 37, 1, '2025-08-26 13:05:48', NULL),
(2778, 1, 37, 2, '2025-08-26 13:05:48', NULL),
(2779, 1, 37, 3, '2025-08-26 13:05:48', NULL),
(2780, 1, 37, 4, '2025-08-26 13:05:48', NULL),
(2781, 1, 38, 1, '2025-08-26 13:05:48', NULL),
(2782, 1, 38, 2, '2025-08-26 13:05:48', NULL),
(2783, 1, 38, 3, '2025-08-26 13:05:48', NULL),
(2784, 1, 38, 4, '2025-08-26 13:05:48', NULL),
(2785, 1, 39, 1, '2025-08-26 13:05:48', NULL),
(2786, 1, 39, 2, '2025-08-26 13:05:48', NULL),
(2787, 1, 39, 3, '2025-08-26 13:05:48', NULL),
(2788, 1, 39, 4, '2025-08-26 13:05:48', NULL),
(2789, 1, 40, 1, '2025-08-26 13:05:48', NULL),
(2790, 1, 40, 2, '2025-08-26 13:05:48', NULL),
(2791, 1, 40, 3, '2025-08-26 13:05:48', NULL),
(2792, 1, 40, 4, '2025-08-26 13:05:48', NULL),
(2793, 1, 41, 1, '2025-08-26 13:05:48', NULL),
(2794, 1, 41, 2, '2025-08-26 13:05:48', NULL),
(2795, 1, 41, 3, '2025-08-26 13:05:48', NULL),
(2796, 1, 41, 4, '2025-08-26 13:05:48', NULL),
(2797, 1, 42, 1, '2025-08-26 13:05:48', NULL),
(2798, 1, 42, 2, '2025-08-26 13:05:48', NULL),
(2799, 1, 42, 3, '2025-08-26 13:05:48', NULL),
(2800, 1, 42, 4, '2025-08-26 13:05:48', NULL),
(2801, 1, 43, 1, '2025-08-26 13:05:48', NULL),
(2802, 1, 43, 2, '2025-08-26 13:05:48', NULL),
(2803, 1, 43, 3, '2025-08-26 13:05:48', NULL),
(2804, 1, 43, 4, '2025-08-26 13:05:48', NULL),
(2805, 1, 44, 1, '2025-08-26 13:05:48', NULL),
(2806, 1, 44, 2, '2025-08-26 13:05:48', NULL),
(2807, 1, 44, 3, '2025-08-26 13:05:48', NULL),
(2808, 1, 44, 4, '2025-08-26 13:05:48', NULL),
(2809, 1, 79, 1, '2025-08-26 13:05:48', NULL),
(2810, 1, 79, 2, '2025-08-26 13:05:48', NULL),
(2811, 1, 79, 3, '2025-08-26 13:05:48', NULL),
(2812, 1, 79, 4, '2025-08-26 13:05:48', NULL),
(2813, 1, 45, 1, '2025-08-26 13:05:48', NULL),
(2814, 1, 45, 2, '2025-08-26 13:05:48', NULL),
(2815, 1, 45, 3, '2025-08-26 13:05:48', NULL),
(2816, 1, 45, 4, '2025-08-26 13:05:48', NULL),
(2817, 1, 46, 1, '2025-08-26 13:05:48', NULL),
(2818, 1, 46, 2, '2025-08-26 13:05:48', NULL),
(2819, 1, 46, 3, '2025-08-26 13:05:48', NULL),
(2820, 1, 46, 4, '2025-08-26 13:05:48', NULL),
(2821, 1, 47, 1, '2025-08-26 13:05:48', NULL),
(2822, 1, 47, 2, '2025-08-26 13:05:48', NULL),
(2823, 1, 47, 3, '2025-08-26 13:05:48', NULL),
(2824, 1, 47, 4, '2025-08-26 13:05:48', NULL),
(2825, 1, 48, 1, '2025-08-26 13:05:48', NULL),
(2826, 1, 48, 2, '2025-08-26 13:05:48', NULL),
(2827, 1, 48, 3, '2025-08-26 13:05:48', NULL),
(2828, 1, 48, 4, '2025-08-26 13:05:48', NULL),
(2829, 1, 49, 1, '2025-08-26 13:05:48', NULL),
(2830, 1, 49, 2, '2025-08-26 13:05:48', NULL),
(2831, 1, 49, 3, '2025-08-26 13:05:48', NULL),
(2832, 1, 49, 4, '2025-08-26 13:05:48', NULL),
(2833, 1, 50, 1, '2025-08-26 13:05:48', NULL),
(2834, 1, 50, 2, '2025-08-26 13:05:48', NULL),
(2835, 1, 50, 3, '2025-08-26 13:05:48', NULL),
(2836, 1, 50, 4, '2025-08-26 13:05:48', NULL),
(2837, 1, 90, 1, '2025-08-26 13:05:48', NULL),
(2838, 1, 90, 2, '2025-08-26 13:05:48', NULL),
(2839, 1, 90, 3, '2025-08-26 13:05:48', NULL),
(2840, 1, 90, 4, '2025-08-26 13:05:48', NULL),
(2841, 1, 51, 1, '2025-08-26 13:05:48', NULL),
(2842, 1, 51, 2, '2025-08-26 13:05:48', NULL),
(2843, 1, 51, 3, '2025-08-26 13:05:48', NULL),
(2844, 1, 51, 4, '2025-08-26 13:05:48', NULL),
(2845, 1, 52, 1, '2025-08-26 13:05:48', NULL),
(2846, 1, 52, 2, '2025-08-26 13:05:48', NULL),
(2847, 1, 52, 3, '2025-08-26 13:05:48', NULL),
(2848, 1, 52, 4, '2025-08-26 13:05:48', NULL),
(2849, 1, 91, 1, '2025-08-26 13:05:48', NULL),
(2850, 1, 91, 2, '2025-08-26 13:05:48', NULL),
(2851, 1, 91, 3, '2025-08-26 13:05:48', NULL),
(2852, 1, 91, 4, '2025-08-26 13:05:48', NULL),
(2853, 1, 92, 1, '2025-08-26 13:05:48', NULL),
(2854, 1, 92, 2, '2025-08-26 13:05:48', NULL),
(2855, 1, 92, 3, '2025-08-26 13:05:48', NULL),
(2856, 1, 92, 4, '2025-08-26 13:05:48', NULL),
(2857, 1, 93, 1, '2025-08-26 13:05:48', NULL),
(2858, 1, 93, 2, '2025-08-26 13:05:48', NULL),
(2859, 1, 93, 3, '2025-08-26 13:05:48', NULL),
(2860, 1, 93, 4, '2025-08-26 13:05:48', NULL),
(2861, 1, 53, 1, '2025-08-26 13:05:48', NULL),
(2862, 1, 53, 2, '2025-08-26 13:05:48', NULL),
(2863, 1, 53, 3, '2025-08-26 13:05:48', NULL),
(2864, 1, 53, 4, '2025-08-26 13:05:48', NULL),
(2865, 1, 54, 1, '2025-08-26 13:05:48', NULL),
(2866, 1, 54, 2, '2025-08-26 13:05:48', NULL),
(2867, 1, 54, 3, '2025-08-26 13:05:48', NULL),
(2868, 1, 54, 4, '2025-08-26 13:05:48', NULL),
(2869, 1, 55, 1, '2025-08-26 13:05:48', NULL),
(2870, 1, 55, 2, '2025-08-26 13:05:48', NULL),
(2871, 1, 55, 3, '2025-08-26 13:05:48', NULL),
(2872, 1, 55, 4, '2025-08-26 13:05:48', NULL),
(2873, 1, 56, 1, '2025-08-26 13:05:48', NULL),
(2874, 1, 56, 2, '2025-08-26 13:05:48', NULL),
(2875, 1, 56, 3, '2025-08-26 13:05:48', NULL),
(2876, 1, 56, 4, '2025-08-26 13:05:48', NULL),
(2877, 1, 57, 1, '2025-08-26 13:05:48', NULL),
(2878, 1, 57, 2, '2025-08-26 13:05:48', NULL),
(2879, 1, 57, 3, '2025-08-26 13:05:48', NULL),
(2880, 1, 57, 4, '2025-08-26 13:05:48', NULL),
(2881, 1, 58, 1, '2025-08-26 13:05:48', NULL),
(2882, 1, 58, 2, '2025-08-26 13:05:48', NULL),
(2883, 1, 58, 3, '2025-08-26 13:05:48', NULL),
(2884, 1, 58, 4, '2025-08-26 13:05:48', NULL),
(2885, 1, 59, 1, '2025-08-26 13:05:48', NULL),
(2886, 1, 59, 2, '2025-08-26 13:05:48', NULL),
(2887, 1, 59, 3, '2025-08-26 13:05:48', NULL),
(2888, 1, 59, 4, '2025-08-26 13:05:48', NULL),
(2889, 1, 88, 1, '2025-08-26 13:05:48', NULL),
(2890, 1, 88, 2, '2025-08-26 13:05:48', NULL),
(2891, 1, 88, 3, '2025-08-26 13:05:48', NULL),
(2892, 1, 88, 4, '2025-08-26 13:05:48', NULL),
(2893, 1, 89, 1, '2025-08-26 13:05:48', NULL),
(2894, 1, 89, 2, '2025-08-26 13:05:48', NULL),
(2895, 1, 89, 3, '2025-08-26 13:05:48', NULL),
(2896, 1, 89, 4, '2025-08-26 13:05:48', NULL),
(2897, 1, 60, 1, '2025-08-26 13:05:48', NULL),
(2898, 1, 60, 2, '2025-08-26 13:05:48', NULL),
(2899, 1, 60, 3, '2025-08-26 13:05:48', NULL),
(2900, 1, 60, 4, '2025-08-26 13:05:48', NULL),
(2901, 1, 61, 1, '2025-08-26 13:05:48', NULL),
(2902, 1, 61, 2, '2025-08-26 13:05:48', NULL),
(2903, 1, 61, 3, '2025-08-26 13:05:48', NULL),
(2904, 1, 61, 4, '2025-08-26 13:05:48', NULL),
(2905, 1, 62, 1, '2025-08-26 13:05:48', NULL),
(2906, 1, 62, 2, '2025-08-26 13:05:48', NULL),
(2907, 1, 62, 3, '2025-08-26 13:05:48', NULL),
(2908, 1, 62, 4, '2025-08-26 13:05:48', NULL),
(2909, 1, 63, 1, '2025-08-26 13:05:48', NULL),
(2910, 1, 63, 2, '2025-08-26 13:05:48', NULL),
(2911, 1, 63, 3, '2025-08-26 13:05:48', NULL),
(2912, 1, 63, 4, '2025-08-26 13:05:48', NULL),
(2913, 1, 64, 1, '2025-08-26 13:05:48', NULL),
(2914, 1, 64, 2, '2025-08-26 13:05:48', NULL),
(2915, 1, 64, 3, '2025-08-26 13:05:48', NULL),
(2916, 1, 64, 4, '2025-08-26 13:05:48', NULL),
(2917, 1, 1, 1, '2025-08-26 13:05:48', NULL),
(2918, 1, 1, 2, '2025-08-26 13:05:48', NULL),
(2919, 1, 1, 3, '2025-08-26 13:05:48', NULL),
(2920, 1, 1, 4, '2025-08-26 13:05:48', NULL),
(2921, 1, 2, 1, '2025-08-26 13:05:48', NULL),
(2922, 1, 2, 2, '2025-08-26 13:05:48', NULL),
(2923, 1, 2, 3, '2025-08-26 13:05:48', NULL),
(2924, 1, 2, 4, '2025-08-26 13:05:48', NULL),
(2925, 1, 3, 1, '2025-08-26 13:05:48', NULL),
(2926, 1, 3, 2, '2025-08-26 13:05:48', NULL),
(2927, 1, 3, 3, '2025-08-26 13:05:48', NULL),
(2928, 1, 3, 4, '2025-08-26 13:05:48', NULL),
(2929, 1, 65, 1, '2025-08-26 13:05:48', NULL),
(2930, 1, 65, 2, '2025-08-26 13:05:48', NULL),
(2931, 1, 65, 3, '2025-08-26 13:05:48', NULL),
(2932, 1, 65, 4, '2025-08-26 13:05:48', NULL),
(2933, 1, 66, 1, '2025-08-26 13:05:48', NULL),
(2934, 1, 66, 2, '2025-08-26 13:05:48', NULL),
(2935, 1, 66, 3, '2025-08-26 13:05:48', NULL),
(2936, 1, 66, 4, '2025-08-26 13:05:48', NULL),
(2937, 1, 67, 1, '2025-08-26 13:05:48', NULL),
(2938, 1, 67, 2, '2025-08-26 13:05:48', NULL),
(2939, 1, 67, 3, '2025-08-26 13:05:48', NULL),
(2940, 1, 67, 4, '2025-08-26 13:05:48', NULL),
(2941, 1, 68, 1, '2025-08-26 13:05:48', NULL),
(2942, 1, 68, 2, '2025-08-26 13:05:48', NULL),
(2943, 1, 68, 3, '2025-08-26 13:05:48', NULL),
(2944, 1, 68, 4, '2025-08-26 13:05:48', NULL),
(2945, 1, 69, 1, '2025-08-26 13:05:48', NULL),
(2946, 1, 69, 2, '2025-08-26 13:05:48', NULL),
(2947, 1, 69, 3, '2025-08-26 13:05:48', NULL),
(2948, 1, 69, 4, '2025-08-26 13:05:48', NULL),
(2949, 1, 70, 1, '2025-08-26 13:05:48', NULL),
(2950, 1, 70, 2, '2025-08-26 13:05:48', NULL),
(2951, 1, 70, 3, '2025-08-26 13:05:48', NULL),
(2952, 1, 70, 4, '2025-08-26 13:05:48', NULL),
(2953, 1, 72, 1, '2025-08-26 13:05:48', NULL),
(2954, 1, 72, 2, '2025-08-26 13:05:48', NULL),
(2955, 1, 72, 3, '2025-08-26 13:05:48', NULL),
(2956, 1, 72, 4, '2025-08-26 13:05:48', NULL),
(2957, 1, 73, 1, '2025-08-26 13:05:48', NULL),
(2958, 1, 73, 2, '2025-08-26 13:05:48', NULL),
(2959, 1, 73, 3, '2025-08-26 13:05:48', NULL),
(2960, 1, 73, 4, '2025-08-26 13:05:48', NULL),
(2961, 1, 74, 1, '2025-08-26 13:05:48', NULL),
(2962, 1, 74, 2, '2025-08-26 13:05:48', NULL),
(2963, 1, 74, 3, '2025-08-26 13:05:48', NULL),
(2964, 1, 74, 4, '2025-08-26 13:05:48', NULL),
(2965, 1, 75, 1, '2025-08-26 13:05:48', NULL),
(2966, 1, 75, 2, '2025-08-26 13:05:48', NULL),
(2967, 1, 75, 3, '2025-08-26 13:05:48', NULL),
(2968, 1, 75, 4, '2025-08-26 13:05:48', NULL),
(2969, 1, 76, 1, '2025-08-26 13:05:48', NULL),
(2970, 1, 76, 2, '2025-08-26 13:05:48', NULL),
(2971, 1, 76, 3, '2025-08-26 13:05:48', NULL),
(2972, 1, 76, 4, '2025-08-26 13:05:48', NULL),
(2973, 1, 77, 1, '2025-08-26 13:05:48', NULL),
(2974, 1, 77, 2, '2025-08-26 13:05:48', NULL),
(2975, 1, 77, 3, '2025-08-26 13:05:48', NULL),
(2976, 1, 77, 4, '2025-08-26 13:05:48', NULL),
(2977, 1, 78, 1, '2025-08-26 13:05:48', NULL),
(2978, 1, 78, 2, '2025-08-26 13:05:48', NULL),
(2979, 1, 78, 3, '2025-08-26 13:05:48', NULL),
(2980, 1, 78, 4, '2025-08-26 13:05:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_sales_item`
--

CREATE TABLE `cs_sales_item` (
  `sales_item_id` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `sales_item_name` text DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_sales_item`
--

INSERT INTO `cs_sales_item` (`sales_item_id`, `company_id`, `sales_item_name`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'Frozen Goods Storage', 1, 1, '2025-07-26 15:35:09', 1, '2025-07-26 15:35:09'),
(2, 1, 'Chilled Goods Storage', 1, 1, '2025-07-26 15:35:09', 1, '2025-07-26 15:35:09'),
(3, 1, 'Deep Freeze Storage', 1, 1, '2025-07-26 15:35:09', 1, '2025-07-26 15:35:09'),
(5, 1, 'Rent', 1, 1, '2025-07-26 15:35:09', 1, '2025-07-26 15:35:09');

-- --------------------------------------------------------

--
-- Table structure for table `cs_sales_quotation`
--

CREATE TABLE `cs_sales_quotation` (
  `sq_id` bigint(20) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `doc_type` varchar(50) DEFAULT NULL,
  `doc_no` varchar(50) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `service_type` varchar(50) DEFAULT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `total_amount` double(15,2) DEFAULT NULL,
  `cgst_amount` double DEFAULT NULL,
  `sgst_amount` double DEFAULT NULL,
  `igst_amount` double DEFAULT NULL,
  `grand_amount` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_sales_quotation`
--

INSERT INTO `cs_sales_quotation` (`sq_id`, `company_id`, `branch_id`, `doc_type`, `doc_no`, `doc_date`, `customer_id`, `service_type`, `remarks`, `status`, `total_amount`, `cgst_amount`, `sgst_amount`, `igst_amount`, `grand_amount`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(8, 1, 1, 'sales-quotation', 'SQ-25-00001', '2025-07-22', 3, 'rent', NULL, 'created', 1000.00, 90, 90, 0, 1180, 1, NULL, '2025-07-22 17:12:29', '2025-07-22 17:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `cs_sales_quotation_details`
--

CREATE TABLE `cs_sales_quotation_details` (
  `sq_detail_id` bigint(20) NOT NULL,
  `sq_id` bigint(20) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `product_master_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `unit_qty` double(15,2) DEFAULT NULL,
  `pallet_qty` int(11) DEFAULT NULL,
  `rate` double(15,2) DEFAULT NULL,
  `value` double(15,2) DEFAULT NULL,
  `discount_per` double(6,2) DEFAULT NULL,
  `discount_value` double(15,2) DEFAULT NULL,
  `tax_id` double(15,2) DEFAULT NULL,
  `tax_per` double(6,2) DEFAULT NULL,
  `tax_value` double(15,2) DEFAULT NULL,
  `net_value` double(15,2) DEFAULT NULL COMMENT 'net_value = value - discount_value + tax_value',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_sales_quotation_details`
--

INSERT INTO `cs_sales_quotation_details` (`sq_detail_id`, `sq_id`, `product_type_id`, `product_master_id`, `unit_id`, `unit_qty`, `pallet_qty`, `rate`, `value`, `discount_per`, `discount_value`, `tax_id`, `tax_per`, `tax_value`, `net_value`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 8, 1, 30, 112, 1.00, 10, 100.00, 1000.00, NULL, NULL, NULL, 18.00, 180.00, 1180.00, 1, '2025-07-22 17:12:29', NULL, '2025-07-22 17:12:29');

-- --------------------------------------------------------

--
-- Table structure for table `cs_slots`
--

CREATE TABLE `cs_slots` (
  `slot_id` int(11) NOT NULL,
  `slot_no` text DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `capacity` decimal(10,2) DEFAULT NULL,
  `level_no` varchar(11) DEFAULT NULL,
  `depth_no` varchar(11) DEFAULT NULL,
  `pallet_type_id` int(11) DEFAULT NULL,
  `status` enum('empty','partial','full') NOT NULL DEFAULT 'empty',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_slots`
--

INSERT INTO `cs_slots` (`slot_id`, `slot_no`, `room_id`, `rack_id`, `name`, `capacity`, `level_no`, `depth_no`, `pallet_type_id`, `status`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'S1', 1, 1, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 15:04:03', NULL),
(2, 'S2', 1, 1, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 15:04:03', NULL),
(3, 'S3', 1, 1, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 15:04:03', NULL),
(4, 'S4', 1, 1, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 15:04:03', NULL),
(5, 'S5', 1, 1, 'S5', NULL, 'L2', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:06:45', NULL),
(6, 'S6', 1, 1, 'S6', NULL, 'L2', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:06:45', NULL),
(7, 'S7', 1, 1, 'S7', NULL, 'L2', 'D3', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:06:45', NULL),
(8, 'S8', 1, 1, 'S8', NULL, 'L2', 'D4', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:06:45', NULL),
(9, 'S9', 1, 1, 'S9', NULL, 'L3', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:06:45', NULL),
(10, 'S10', 1, 1, 'S10', NULL, 'L3', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:06:45', NULL),
(11, 'S11', 1, 1, 'S11', NULL, 'L3', 'D3', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:17:48', NULL),
(12, 'S12', 1, 1, 'S12', NULL, 'L3', 'D4', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:17:48', NULL),
(13, 'S13', 1, 1, 'S13', NULL, 'L4', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:17:48', NULL),
(14, 'S14', 1, 1, 'S14', NULL, 'L4', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:17:48', NULL),
(15, 'S15', 1, 1, 'S15', NULL, 'L4', 'D3', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:17:48', NULL),
(16, 'S16', 1, 1, 'S16', NULL, 'L4', 'D4', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 10:17:48', NULL),
(17, 'S1', 1, 2, 'S1', NULL, 'L1', 'D1', 2, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:42', NULL),
(18, 'S2', 1, 2, 'S2', NULL, 'L1', 'D2', 2, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:42', NULL),
(19, 'S3', 1, 2, 'S3', NULL, 'L1', 'D3', 2, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:42', NULL),
(20, 'S4', 1, 2, 'S4', NULL, 'L1', 'D4', 2, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:42', NULL),
(21, 'S5', 1, 2, 'S5', NULL, 'L2', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(22, 'S6', 1, 2, 'S6', NULL, 'L2', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(23, 'S7', 1, 2, 'S7', NULL, 'L2', 'D3', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(24, 'S8', 1, 2, 'S8', NULL, 'L2', 'D4', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:42', NULL),
(25, 'S9', 1, 2, 'S9', NULL, 'L3', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(26, 'S10', 1, 2, 'S10', NULL, 'L3', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(27, 'S11', 1, 2, 'S11', NULL, 'L3', 'D3', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(28, 'S12', 1, 2, 'S12', NULL, 'L3', 'D4', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 09:53:50', NULL),
(29, 'S13', 1, 2, 'S13', NULL, 'L4', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(30, 'S14', 1, 2, 'S14', NULL, 'L4', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 01:05:38', NULL),
(31, 'S15', 1, 2, 'S15', NULL, 'L4', 'D3', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(32, 'S16', 1, 2, 'S16', NULL, 'L4', 'D4', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 07:38:41', NULL),
(33, 'S1', 1, 3, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 15:04:03', NULL),
(34, 'S2', 1, 3, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(35, 'S3', 1, 3, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 15:04:03', NULL),
(36, 'S4', 1, 3, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 15:04:03', NULL),
(37, 'S5', 1, 3, 'S5', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(38, 'S6', 1, 3, 'S6', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(39, 'S7', 1, 3, 'S7', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(40, 'S8', 1, 3, 'S8', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(41, 'S9', 1, 3, 'S9', NULL, 'L3', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 09:53:50', NULL),
(42, 'S10', 1, 3, 'S10', NULL, 'L3', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 09:53:50', NULL),
(43, 'S11', 1, 3, 'S11', NULL, 'L3', 'D3', NULL, 'partial', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 09:53:50', NULL),
(44, 'S12', 1, 3, 'S12', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(45, 'S13', 1, 3, 'S13', NULL, 'L4', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 09:52:05', NULL),
(46, 'S14', 1, 3, 'S14', NULL, 'L4', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 09:52:05', NULL),
(47, 'S15', 1, 3, 'S15', NULL, 'L4', 'D3', NULL, 'partial', 1, '2025-08-02 06:58:09', NULL, '2025-08-11 09:52:05', NULL),
(48, 'S16', 1, 3, 'S16', NULL, 'L4', 'D4', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-16 05:16:22', NULL),
(49, 'S1', 1, 4, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 15:04:03', NULL),
(50, 'S2', 1, 4, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(51, 'S3', 1, 4, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(52, 'S4', 1, 4, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(53, 'S5', 1, 4, 'S5', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(54, 'S6', 1, 4, 'S6', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(55, 'S7', 1, 4, 'S7', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(56, 'S8', 1, 4, 'S8', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(57, 'S9', 1, 4, 'S9', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(58, 'S10', 1, 4, 'S10', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(59, 'S11', 1, 4, 'S11', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(60, 'S12', 1, 4, 'S12', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(61, 'S13', 1, 4, 'S13', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(62, 'S14', 1, 4, 'S14', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(63, 'S15', 1, 4, 'S15', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(64, 'S16', 1, 4, 'S16', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(65, 'S1', 1, 5, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:07', NULL),
(66, 'S2', 1, 5, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:09', NULL),
(67, 'S3', 1, 5, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:11', NULL),
(68, 'S4', 1, 5, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:14', NULL),
(69, 'S5', 1, 5, 'S5', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(70, 'S6', 1, 5, 'S6', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(71, 'S7', 1, 5, 'S7', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(72, 'S8', 1, 5, 'S8', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(73, 'S9', 1, 5, 'S9', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(74, 'S10', 1, 5, 'S10', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(75, 'S11', 1, 5, 'S11', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(76, 'S12', 1, 5, 'S12', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(77, 'S13', 1, 5, 'S13', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(78, 'S14', 1, 5, 'S14', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(79, 'S15', 1, 5, 'S15', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(80, 'S16', 1, 5, 'S16', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(81, 'S1', 1, 6, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(82, 'S2', 1, 6, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(83, 'S3', 1, 6, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(84, 'S4', 1, 6, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:32', NULL),
(85, 'S5', 1, 6, 'S5', NULL, 'L2', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-15 12:52:09', NULL),
(86, 'S6', 1, 6, 'S6', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(87, 'S7', 1, 6, 'S7', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(88, 'S8', 1, 6, 'S8', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(89, 'S9', 1, 6, 'S9', NULL, 'L3', 'D1', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-15 12:52:09', NULL),
(90, 'S10', 1, 6, 'S10', NULL, 'L3', 'D2', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-15 12:52:09', NULL),
(91, 'S11', 1, 6, 'S11', NULL, 'L3', 'D3', NULL, 'full', 1, '2025-08-02 06:58:09', NULL, '2025-08-15 12:52:09', NULL),
(92, 'S12', 1, 6, 'S12', NULL, 'L3', 'D4', NULL, 'partial', 1, '2025-08-02 06:58:09', NULL, '2025-08-15 12:52:09', NULL),
(93, 'S13', 1, 6, 'S13', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(94, 'S14', 1, 6, 'S14', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(95, 'S15', 1, 6, 'S15', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(96, 'S16', 1, 6, 'S16', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(97, 'S1', 1, 7, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(98, 'S2', 1, 7, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(99, 'S3', 1, 7, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:38', NULL),
(100, 'S4', 1, 7, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:41', NULL),
(101, 'S5', 1, 7, 'S5', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(102, 'S6', 1, 7, 'S6', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(103, 'S7', 1, 7, 'S7', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(104, 'S8', 1, 7, 'S8', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(105, 'S9', 1, 7, 'S9', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(106, 'S10', 1, 7, 'S10', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(107, 'S11', 1, 7, 'S11', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(108, 'S12', 1, 7, 'S12', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(109, 'S13', 1, 7, 'S13', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(110, 'S14', 1, 7, 'S14', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(111, 'S15', 1, 7, 'S15', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(112, 'S16', 1, 7, 'S16', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(113, 'S1', 2, 8, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:43', NULL),
(114, 'S2', 2, 8, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:46', NULL),
(115, 'S3', 2, 8, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:47', NULL),
(116, 'S4', 2, 8, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:50', NULL),
(117, 'S5', 2, 8, 'S5', NULL, 'L1', 'D5', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:58', NULL),
(118, 'S6', 2, 8, 'S6', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(119, 'S7', 2, 8, 'S7', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(120, 'S8', 2, 8, 'S8', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(121, 'S9', 2, 8, 'S9', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(122, 'S10', 2, 8, 'S10', NULL, 'L2', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(123, 'S11', 2, 8, 'S11', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(124, 'S12', 2, 8, 'S12', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(125, 'S13', 2, 8, 'S13', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(126, 'S14', 2, 8, 'S14', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(127, 'S15', 2, 8, 'S15', NULL, 'L3', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(128, 'S16', 2, 8, 'S16', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(129, 'S17', 2, 8, 'S17', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(130, 'S18', 2, 8, 'S18', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(131, 'S19', 2, 8, 'S19', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(132, 'S20', 2, 8, 'S20', NULL, 'L4', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-07 14:46:42', NULL),
(133, 'S1', 2, 9, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:01', NULL),
(134, 'S2', 2, 9, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:04', NULL),
(135, 'S3', 2, 9, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:06', NULL),
(136, 'S4', 2, 9, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:07', NULL),
(137, 'S5', 2, 9, 'S5', NULL, 'L1', 'D5', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:09', NULL),
(138, 'S6', 2, 9, 'S6', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(139, 'S7', 2, 9, 'S7', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(140, 'S8', 2, 9, 'S8', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(141, 'S9', 2, 9, 'S9', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(142, 'S10', 2, 9, 'S10', NULL, 'L2', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(143, 'S11', 2, 9, 'S11', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(144, 'S12', 2, 9, 'S12', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(145, 'S13', 2, 9, 'S13', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(146, 'S14', 2, 9, 'S14', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(147, 'S15', 2, 9, 'S15', NULL, 'L3', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(148, 'S16', 2, 9, 'S16', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(149, 'S17', 2, 9, 'S17', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(150, 'S18', 2, 9, 'S18', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(151, 'S19', 2, 9, 'S19', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(152, 'S20', 2, 9, 'S20', NULL, 'L4', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(153, 'S1', 2, 10, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:11', NULL),
(154, 'S2', 2, 10, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:13', NULL),
(155, 'S3', 2, 10, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:16', NULL),
(156, 'S4', 2, 10, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:18', NULL),
(157, 'S5', 2, 10, 'S5', NULL, 'L1', 'D5', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:19', NULL),
(158, 'S6', 2, 10, 'S6', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(159, 'S7', 2, 10, 'S7', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(160, 'S8', 2, 10, 'S8', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(161, 'S9', 2, 10, 'S9', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(162, 'S10', 2, 10, 'S10', NULL, 'L2', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(163, 'S11', 2, 10, 'S11', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(164, 'S12', 2, 10, 'S12', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(165, 'S13', 2, 10, 'S13', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(166, 'S14', 2, 10, 'S14', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(167, 'S15', 2, 10, 'S15', NULL, 'L3', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(168, 'S16', 2, 10, 'S16', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(169, 'S17', 2, 10, 'S17', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(170, 'S18', 2, 10, 'S18', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(171, 'S19', 2, 10, 'S19', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(172, 'S20', 2, 10, 'S20', NULL, 'L4', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(173, 'S1', 2, 11, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:21', NULL),
(174, 'S2', 2, 11, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:24', NULL),
(175, 'S3', 2, 11, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:26', NULL),
(176, 'S4', 2, 11, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:28', NULL),
(177, 'S5', 2, 11, 'S5', NULL, 'L1', 'D5', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:30', NULL),
(178, 'S6', 2, 11, 'S6', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(179, 'S7', 2, 11, 'S7', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(180, 'S8', 2, 11, 'S8', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(181, 'S9', 2, 11, 'S9', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(182, 'S10', 2, 11, 'S10', NULL, 'L2', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(183, 'S11', 2, 11, 'S11', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(184, 'S12', 2, 11, 'S12', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(185, 'S13', 2, 11, 'S13', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(186, 'S14', 2, 11, 'S14', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(187, 'S15', 2, 11, 'S15', NULL, 'L3', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(188, 'S16', 2, 11, 'S16', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(189, 'S17', 2, 11, 'S17', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(190, 'S18', 2, 11, 'S18', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(191, 'S19', 2, 11, 'S19', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(192, 'S20', 2, 11, 'S20', NULL, 'L4', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(193, 'S1', 2, 12, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:32', NULL),
(194, 'S2', 2, 12, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:34', NULL),
(195, 'S3', 2, 12, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:37', NULL),
(196, 'S4', 2, 12, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:39', NULL),
(197, 'S5', 2, 12, 'S5', NULL, 'L1', 'D5', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:41', NULL),
(198, 'S6', 2, 12, 'S6', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(199, 'S7', 2, 12, 'S7', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(200, 'S8', 2, 12, 'S8', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(201, 'S9', 2, 12, 'S9', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(202, 'S10', 2, 12, 'S10', NULL, 'L2', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(203, 'S11', 2, 12, 'S11', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(204, 'S12', 2, 12, 'S12', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(205, 'S13', 2, 12, 'S13', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(206, 'S14', 2, 12, 'S14', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(207, 'S15', 2, 12, 'S15', NULL, 'L3', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(208, 'S16', 2, 12, 'S16', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(209, 'S17', 2, 12, 'S17', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(210, 'S18', 2, 12, 'S18', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(211, 'S19', 2, 12, 'S19', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(212, 'S20', 2, 12, 'S20', NULL, 'L4', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(213, 'S1', 2, 13, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:43', NULL),
(214, 'S2', 2, 13, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:45', NULL),
(215, 'S3', 2, 13, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:47', NULL),
(216, 'S4', 2, 13, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:48', NULL),
(217, 'S5', 2, 13, 'S5', NULL, 'L1', 'D5', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:37:56', NULL),
(218, 'S6', 2, 13, 'S6', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(219, 'S7', 2, 13, 'S7', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(220, 'S8', 2, 13, 'S8', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(221, 'S9', 2, 13, 'S9', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(222, 'S10', 2, 13, 'S10', NULL, 'L2', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(223, 'S11', 2, 13, 'S11', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(224, 'S12', 2, 13, 'S12', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(225, 'S13', 2, 13, 'S13', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(226, 'S14', 2, 13, 'S14', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(227, 'S15', 2, 13, 'S15', NULL, 'L3', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(228, 'S16', 2, 13, 'S16', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(229, 'S17', 2, 13, 'S17', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(230, 'S18', 2, 13, 'S18', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(231, 'S19', 2, 13, 'S19', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(232, 'S20', 2, 13, 'S20', NULL, 'L4', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(233, 'S1', 2, 14, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:38:17', NULL),
(234, 'S2', 2, 14, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:38:19', NULL),
(235, 'S3', 2, 14, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:38:22', NULL),
(236, 'S4', 2, 14, 'S4', NULL, 'L1', 'D4', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:38:25', NULL),
(237, 'S5', 2, 14, 'S5', NULL, 'L1', 'D5', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:38:27', NULL),
(238, 'S6', 2, 14, 'S6', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(239, 'S7', 2, 14, 'S7', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(240, 'S8', 2, 14, 'S8', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(241, 'S9', 2, 14, 'S9', NULL, 'L2', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(242, 'S10', 2, 14, 'S10', NULL, 'L2', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(243, 'S11', 2, 14, 'S11', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(244, 'S12', 2, 14, 'S12', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(245, 'S13', 2, 14, 'S13', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(246, 'S14', 2, 14, 'S14', NULL, 'L3', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(247, 'S15', 2, 14, 'S15', NULL, 'L3', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(248, 'S16', 2, 14, 'S16', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(249, 'S17', 2, 14, 'S17', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(250, 'S18', 2, 14, 'S18', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(251, 'S19', 2, 14, 'S19', NULL, 'L4', 'D4', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(252, 'S20', 2, 14, 'S20', NULL, 'L4', 'D5', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(253, 'S1', 3, 15, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:38:29', NULL),
(254, 'S2', 3, 15, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:38:31', NULL),
(255, 'S3', 3, 15, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:38:33', NULL),
(256, 'S4', 3, 15, 'S4', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(257, 'S5', 3, 15, 'S5', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(258, 'S6', 3, 15, 'S6', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(259, 'S7', 3, 15, 'S7', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(260, 'S8', 3, 15, 'S8', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(261, 'S9', 3, 15, 'S9', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(262, 'S10', 3, 15, 'S10', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(263, 'S11', 3, 15, 'S11', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(264, 'S12', 3, 15, 'S12', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(265, 'S1', 3, 16, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 03:01:15', NULL),
(266, 'S2', 3, 16, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 03:01:43', NULL),
(267, 'S3', 3, 16, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 03:02:11', NULL),
(268, 'S4', 3, 16, 'S4', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(269, 'S5', 3, 16, 'S5', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(270, 'S6', 3, 16, 'S6', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(271, 'S7', 3, 16, 'S7', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(272, 'S8', 3, 16, 'S8', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(273, 'S9', 3, 16, 'S9', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(274, 'S10', 3, 16, 'S10', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(275, 'S11', 3, 16, 'S11', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(276, 'S12', 3, 16, 'S12', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(277, 'S1', 3, 17, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 03:03:59', NULL),
(278, 'S2', 3, 17, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:34:57', NULL),
(279, 'S3', 3, 17, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:35:00', NULL),
(280, 'S4', 3, 17, 'S4', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(281, 'S5', 3, 17, 'S5', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(282, 'S6', 3, 17, 'S6', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(283, 'S7', 3, 17, 'S7', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(284, 'S8', 3, 17, 'S8', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(285, 'S9', 3, 17, 'S9', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(286, 'S10', 3, 17, 'S10', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(287, 'S11', 3, 17, 'S11', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(288, 'S12', 3, 17, 'S12', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(289, 'S1', 3, 18, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:35:06', NULL),
(290, 'S2', 3, 18, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:35:12', NULL),
(291, 'S3', 3, 18, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:35:19', NULL),
(292, 'S4', 3, 18, 'S4', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(293, 'S5', 3, 18, 'S5', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(294, 'S6', 3, 18, 'S6', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(295, 'S7', 3, 18, 'S7', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(296, 'S8', 3, 18, 'S8', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(297, 'S9', 3, 18, 'S9', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(298, 'S10', 3, 18, 'S10', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(299, 'S11', 3, 18, 'S11', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(300, 'S12', 3, 18, 'S12', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(301, 'S1', 3, 19, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:35:25', NULL),
(302, 'S2', 3, 19, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:35:28', NULL),
(303, 'S3', 3, 19, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:35:31', NULL),
(304, 'S4', 3, 19, 'S4', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(305, 'S5', 3, 19, 'S5', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(306, 'S6', 3, 19, 'S6', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(307, 'S7', 3, 19, 'S7', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(308, 'S8', 3, 19, 'S8', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(309, 'S9', 3, 19, 'S9', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(310, 'S10', 3, 19, 'S10', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(311, 'S11', 3, 19, 'S11', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(312, 'S12', 3, 19, 'S12', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(313, 'S1', 3, 20, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:35:59', NULL),
(314, 'S2', 3, 20, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:02', NULL),
(315, 'S3', 3, 20, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:04', NULL),
(316, 'S4', 3, 20, 'S4', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(317, 'S5', 3, 20, 'S5', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(318, 'S6', 3, 20, 'S6', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(319, 'S7', 3, 20, 'S7', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(320, 'S8', 3, 20, 'S8', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(321, 'S9', 3, 20, 'S9', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(322, 'S10', 3, 20, 'S10', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(323, 'S11', 3, 20, 'S11', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(324, 'S12', 3, 20, 'S12', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(325, 'S1', 3, 21, 'S1', NULL, 'L1', 'D1', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:17', NULL),
(326, 'S2', 3, 21, 'S2', NULL, 'L1', 'D2', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:21', NULL),
(327, 'S3', 3, 21, 'S3', NULL, 'L1', 'D3', 2, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-06 08:36:23', NULL),
(328, 'S4', 3, 21, 'S4', NULL, 'L2', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(329, 'S5', 3, 21, 'S5', NULL, 'L2', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(330, 'S6', 3, 21, 'S6', NULL, 'L2', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(331, 'S7', 3, 21, 'S7', NULL, 'L3', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(332, 'S8', 3, 21, 'S8', NULL, 'L3', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(333, 'S9', 3, 21, 'S9', NULL, 'L3', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(334, 'S10', 3, 21, 'S10', NULL, 'L4', 'D1', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(335, 'S11', 3, 21, 'S11', NULL, 'L4', 'D2', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL),
(336, 'S12', 3, 21, 'S12', NULL, 'L4', 'D3', NULL, 'empty', 1, '2025-08-02 06:58:09', NULL, '2025-08-02 06:58:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_state`
--

CREATE TABLE `cs_state` (
  `state_id` int(11) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `state_name` varchar(45) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `code` varchar(5) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `sort_order` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT NULL,
  `del_status` int(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_state`
--

INSERT INTO `cs_state` (`state_id`, `company_id`, `state_name`, `short_name`, `code`, `country_id`, `sort_order`, `active`, `del_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'Kerala', 'KL', 'KL', 1, 1, 1, 1, 1, '2025-06-01 18:05:17', 1, '2025-05-31 18:52:56');

-- --------------------------------------------------------

--
-- Table structure for table `cs_status`
--

CREATE TABLE `cs_status` (
  `status_id` int(11) NOT NULL,
  `company_id` int(2) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `status_name` varchar(30) DEFAULT NULL,
  `doc_type` varchar(10) DEFAULT NULL,
  `active` int(1) DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_status`
--

INSERT INTO `cs_status` (`status_id`, `company_id`, `sort_order`, `status_name`, `doc_type`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 'created', 'inward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(2, 1, 2, 'approved', 'inward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(3, 1, 3, 'rejected', 'inward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(5, 1, 5, 'finalized', 'inward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(9, 1, 9, 'cancelled', 'inward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(11, 1, 1, 'created', 'outward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(12, 1, 2, 'approved', 'outward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(13, 1, 3, 'rejected', 'outward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(14, 1, 4, 'requested', 'outward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(15, 1, 5, 'finalized', 'outward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(19, 1, 9, 'cancelled', 'outward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(20, 1, 10, 'dispatched', 'outward', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(21, 1, 1, 'created', 'picklist', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(22, 1, 2, 'approved', 'picklist', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(23, 1, 3, 'rejected', 'picklist', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(25, 1, 5, 'finalized', 'picklist', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(27, 1, 7, 'picked', 'picklist', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(28, 1, 8, 'out', 'picklist', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(29, 1, 9, 'cancelled', 'picklist', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04'),
(30, 1, 10, 'dispatched', 'picklist', 1, 1, '2025-07-16 22:45:04', NULL, '2025-07-16 22:45:04');

-- --------------------------------------------------------

--
-- Table structure for table `cs_status_updates`
--

CREATE TABLE `cs_status_updates` (
  `status_update_id` bigint(20) NOT NULL,
  `company_id` int(2) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `table_name` varchar(250) DEFAULT NULL,
  `row_id` bigint(20) DEFAULT NULL,
  `column_name` varchar(100) DEFAULT NULL,
  `column_value` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_status_updates`
--

INSERT INTO `cs_status_updates` (`status_update_id`, `company_id`, `branch_id`, `table_name`, `row_id`, `column_name`, `column_value`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 101, 'cs_picklist_detail', 1, 'status', 'picked', 'Item marked as picked and assigned to pallet PLT-0001', 1, '2025-08-29 18:46:07', 1, '2025-08-29 18:46:07'),
(2, 1, 101, 'cs_picklist_detail', 1, 'status', 'loaded', 'Item loaded onto container CNU123456 for dispatch', 1, '2025-08-29 18:46:07', 1, '2025-08-29 18:46:07'),
(3, 1, 101, 'cs_picklist_detail', 1, 'quantity', '30.00', 'Quantity updated after final weighing', 1, '2025-08-29 18:46:07', 1, '2025-08-29 18:46:07'),
(4, 1, 101, 'cs_outward_detail', 1, 'status', 'picked', 'Pallet 101 picked from rack 12 slot 5', 1, '2025-08-29 08:15:00', 1, '2025-08-29 08:15:00'),
(5, 1, 101, 'cs_outward_detail', 1, 'status', 'loaded', 'Pallet 101 loaded onto vehicle KL-07-BD-1123', 1, '2025-08-29 09:00:00', 1, '2025-08-29 09:00:00'),
(6, 1, 101, 'cs_outward_detail', 1, 'status', 'dispatched', 'Pallet 101 dispatched for Ocean Fresh Exports', 1, '2025-08-29 09:30:00', 1, '2025-08-29 09:30:00'),
(7, 1, 101, 'cs_outward_detail', 2, 'status', 'picked', 'Pallet 102 picked from rack 12 slot 6', 1, '2025-08-29 08:20:00', 1, '2025-08-29 08:20:00'),
(8, 1, 101, 'cs_outward_detail', 2, 'status', 'loaded', 'Pallet 102 loaded onto vehicle KL-07-BD-1123', 1, '2025-08-29 09:05:00', 1, '2025-08-29 09:05:00'),
(9, 1, 101, 'cs_outward_detail', 2, 'status', 'dispatched', 'Pallet 102 dispatched for Ocean Fresh Exports', 1, '2025-08-29 09:35:00', 1, '2025-08-29 09:35:00');

-- --------------------------------------------------------

--
-- Table structure for table `cs_stock`
--

CREATE TABLE `cs_stock` (
  `stock_id` bigint(20) NOT NULL,
  `room_id` int(11) NOT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `pallet_id` int(11) UNSIGNED DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `batch_no` text DEFAULT NULL,
  `expiry_date` varchar(20) DEFAULT NULL,
  `packing_list_detail_id` bigint(20) DEFAULT NULL,
  `in_qty` double(15,2) DEFAULT NULL,
  `out_qty` double(15,2) DEFAULT NULL,
  `available_qty` double(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_stock_adjustment`
--

CREATE TABLE `cs_stock_adjustment` (
  `stock_adjustment_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `doc_type` varchar(10) DEFAULT NULL,
  `doc_no` varchar(50) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `total_package_qty` decimal(15,2) DEFAULT NULL,
  `tot_pallet_qty` decimal(15,2) DEFAULT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(150) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_stock_adjustment_detail`
--

CREATE TABLE `cs_stock_adjustment_detail` (
  `stock_adjustment_detail_id` bigint(20) NOT NULL,
  `stock_adjustment_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_description` varchar(50) DEFAULT NULL,
  `batch_no` text DEFAULT NULL,
  `expiry_date` varchar(15) DEFAULT NULL,
  `packing_list_id` int(11) DEFAULT NULL,
  `packing_list_detail_id` bigint(20) DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `pallet_id` int(11) DEFAULT NULL,
  `quantity` decimal(10,2) DEFAULT NULL,
  `weight_per_unit` decimal(10,2) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `package_qty_per_half_pallet` decimal(10,2) DEFAULT NULL,
  `package_qty_per_full_pallet` double(15,2) DEFAULT NULL,
  `pallet_qty` decimal(10,2) DEFAULT NULL,
  `ref_doc_type` varchar(50) DEFAULT NULL,
  `ref_doc_no` varchar(100) DEFAULT NULL,
  `ref_doc_date` date DEFAULT NULL,
  `reason` varchar(250) DEFAULT NULL,
  `movement_type` varchar(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_storage_rooms`
--

CREATE TABLE `cs_storage_rooms` (
  `room_id` int(11) NOT NULL,
  `warehouse_unit_id` int(11) NOT NULL,
  `room_no` varchar(20) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `total_capacity` decimal(10,2) DEFAULT NULL,
  `temperature_range` varchar(50) DEFAULT NULL,
  `storage_product_type_id` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive','Maintenance') DEFAULT 'Active',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_storage_rooms`
--

INSERT INTO `cs_storage_rooms` (`room_id`, `warehouse_unit_id`, `room_no`, `name`, `description`, `total_capacity`, `temperature_range`, `storage_product_type_id`, `status`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1, 'R001', 'Frozen Room A', 'Deep freeze for seafood storage', 25.50, '-20°C to -18°C', 2, 'Active', 1, '2025-08-26 07:51:23', 1, '2025-08-26 07:51:23', 1),
(2, 1, 'R002', 'Frozen Room B', 'Backup freezer for overflow stock', 20.00, '-22°C to -18°C', 2, 'Maintenance', 1, '2025-08-26 07:51:23', 1, '2025-08-26 07:51:23', 1),
(3, 2, 'R003', 'Chiller Room A', 'Fresh produce and dairy', 15.75, '0°C to 4°C', 3, 'Active', 1, '2025-08-26 07:51:23', 1, '2025-08-26 07:51:23', 1),
(4, 2, 'R004', 'Chiller Room B', 'Meat and poultry chilled storage', 18.00, '0°C to 2°C', 4, 'Inactive', 0, '2025-08-26 07:51:23', 1, '2025-08-26 07:51:23', 1),
(5, 3, 'R005', 'Dry Storage A', 'Ambient packaged goods', 30.00, '15°C to 25°C', 5, 'Active', 1, '2025-08-26 07:51:23', 1, '2025-08-26 07:51:23', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cs_sub_ledger`
--

CREATE TABLE `cs_sub_ledger` (
  `sl_id` bigint(20) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `doc_type` varchar(30) DEFAULT NULL,
  `doc_no` varchar(250) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `doc_date_time` datetime DEFAULT NULL,
  `tran_date` date DEFAULT NULL,
  `tran_type` varchar(2) DEFAULT NULL COMMENT 'DR,CR',
  `client_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_supplier`
--

CREATE TABLE `cs_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_id_data_mig` varchar(11) DEFAULT NULL,
  `company_id` int(2) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `supplier_type_id` int(11) DEFAULT NULL,
  `supplier_category_id` int(11) DEFAULT NULL,
  `supplier_code` varchar(45) DEFAULT NULL,
  `supplier_name` varchar(150) DEFAULT NULL,
  `supplier_invoice_name` text DEFAULT NULL,
  `contact_person` varchar(50) DEFAULT NULL,
  `contact_number` varchar(250) DEFAULT NULL,
  `mobile` varchar(250) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `post_office_id` int(11) DEFAULT NULL,
  `pincode` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `aadhaar` varchar(30) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `bank_name` varchar(45) DEFAULT NULL,
  `account_number` varchar(250) DEFAULT NULL,
  `ifsc_code` varchar(50) DEFAULT NULL,
  `rtgs_code` varchar(45) DEFAULT NULL,
  `swift_code` varchar(45) DEFAULT NULL,
  `bank_email` varchar(45) DEFAULT NULL,
  `other_details` varchar(300) DEFAULT NULL,
  `terms_of_payment` varchar(100) DEFAULT NULL,
  `tax_percentage` double DEFAULT NULL,
  `discount_type` varchar(45) DEFAULT NULL,
  `discount_terms` varchar(45) DEFAULT NULL,
  `discount_definition` varchar(45) DEFAULT NULL,
  `period_of_discount` int(11) DEFAULT NULL,
  `attachments` varchar(200) DEFAULT NULL,
  `vendor_grade` varchar(45) DEFAULT NULL,
  `supplier_group` varchar(45) DEFAULT NULL,
  `group_code` varchar(30) DEFAULT NULL,
  `currency` varchar(5) DEFAULT NULL,
  `tin` varchar(50) DEFAULT NULL,
  `cst` varchar(50) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `credit_limit` double DEFAULT NULL,
  `gstin` varchar(100) DEFAULT NULL,
  `no_of_days_for_goods_rcv` int(3) DEFAULT 0,
  `active` enum('1','0') DEFAULT NULL,
  `del_status` int(1) DEFAULT 1,
  `short_name` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `advance` int(1) DEFAULT 0,
  `without_tax` int(1) DEFAULT 0,
  `is_branch` int(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_supplier_category`
--

CREATE TABLE `cs_supplier_category` (
  `supplier_category_id` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `supplier_category_name` varchar(45) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `ac_ctrl_cash_purchase` varchar(15) DEFAULT NULL,
  `ac_ctrl_credit_purchase` varchar(15) DEFAULT NULL,
  `ac_ctrl_cash_paid` varchar(15) NOT NULL,
  `ac_ctrl_credit_paid` varchar(15) NOT NULL,
  `ac_payable` varchar(15) DEFAULT NULL,
  `active` enum('1','0') DEFAULT NULL,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_supplier_type`
--

CREATE TABLE `cs_supplier_type` (
  `supplier_type_id` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `branch_id` int(2) NOT NULL,
  `supplier_type_name` varchar(45) DEFAULT NULL,
  `ac_ctrl_cash_purchase` varchar(15) DEFAULT NULL,
  `ac_ctrl_credit_purchase` varchar(15) DEFAULT NULL,
  `ac_ctrl_cash_paid` varchar(15) DEFAULT NULL,
  `ac_ctrl_credit_paid` varchar(15) DEFAULT NULL,
  `ac_payable` varchar(15) DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `active` enum('1','0') NOT NULL DEFAULT '1',
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_tax`
--

CREATE TABLE `cs_tax` (
  `tax_id` int(11) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `tax_per` double(5,2) DEFAULT NULL,
  `gst_input_account_code` varchar(50) DEFAULT NULL,
  `gst_output_account_code` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_tax`
--

INSERT INTO `cs_tax` (`tax_id`, `company_id`, `tax_per`, `gst_input_account_code`, `gst_output_account_code`, `is_active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, NULL, NULL, 0, 1, NULL, '2025-07-21 07:49:01', '2025-07-21 07:49:01'),
(2, 1, 18.00, NULL, NULL, 0, 1, NULL, '2025-07-21 07:59:38', '2025-07-21 07:59:38');

-- --------------------------------------------------------

--
-- Table structure for table `cs_transaction_type`
--

CREATE TABLE `cs_transaction_type` (
  `transaction_type_id` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `transaction_type` varchar(10) DEFAULT NULL,
  `account_code` varchar(10) NOT NULL,
  `sort_order` int(5) DEFAULT 0,
  `active` enum('1','0') DEFAULT '1',
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cs_transaction_type`
--

INSERT INTO `cs_transaction_type` (`transaction_type_id`, `company_id`, `transaction_type`, `account_code`, `sort_order`, `active`, `del_status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'cash', '1010', 1, '1', 0, 1, '2017-08-15 15:23:44', NULL, NULL),
(2, 1, 'cheque', '1020', 2, '1', 0, 1, '2017-08-15 15:23:44', NULL, NULL),
(3, 1, 'transfer', '1020', 3, '1', 0, 1, '2017-08-15 15:23:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cs_unit`
--

CREATE TABLE `cs_unit` (
  `unit_id` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `conversion_unit` varchar(100) NOT NULL,
  `conversion_quantity` varchar(45) DEFAULT NULL,
  `sign` varchar(100) DEFAULT NULL,
  `active` enum('1','0') DEFAULT NULL,
  `del_status` int(1) NOT NULL DEFAULT 1,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `short_name` varchar(20) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cs_unit`
--

INSERT INTO `cs_unit` (`unit_id`, `company_id`, `unit`, `description`, `conversion_unit`, `conversion_quantity`, `sign`, `active`, `del_status`, `created_by`, `created_at`, `short_name`, `updated_by`, `updated_at`) VALUES
(87, 1, 'BOX', 'Box', 'Box', '1', 'multiplication', '1', 1, 1, '2021-07-09 15:16:51', 'BOX', NULL, NULL),
(88, 1, 'BOX SMALL', 'Box small', 'Box small', '1', 'multiplication', '1', 1, 1, '2021-07-09 15:17:06', 'BOX SMALL', NULL, NULL),
(90, 1, 'HALF BOX', 'Half box', 'Half box', '1', 'multiplication', '1', 1, 1, '2021-07-09 15:17:35', 'HALF BOX', NULL, NULL),
(91, 1, 'KG', 'Kg', 'Kg', '1', 'division', '1', 1, 1, '2021-07-09 15:17:51', 'KG', NULL, NULL),
(96, 1, 'NOS', 'Nos', 'Nos', '1', 'multiplication', '1', 1, 1, '2021-07-09 16:16:56', 'NOS', NULL, NULL),
(97, 1, 'PKT', 'Pkt', 'Pkt', '1', 'multiplication', '1', 1, 1, '2021-07-09 16:17:08', 'PKT', NULL, NULL),
(105, 1, 'TRAY', 'Tray', 'Tray', '1', 'multiplication', '1', 1, 1, '2021-08-06 15:32:04', 'TRAY', NULL, NULL),
(111, 1, 'BUNDLE', 'Bundle', 'Bundle', '1', 'multiplication', '1', 1, 1, '2021-08-06 15:36:44', 'BUNDLE', NULL, NULL),
(112, 1, 'Day', 'day', 'days', '1', NULL, NULL, 1, NULL, '2025-07-22 13:46:09', 'day', NULL, '2025-07-22 13:46:09'),
(113, 1, 'Week', 'week', 'days', '7', 'multiplication', NULL, 1, NULL, '2025-07-22 13:47:13', 'week', NULL, '2025-07-22 13:47:13'),
(114, 1, 'Month', 'Month', 'days', '30', 'multiplication', NULL, 1, NULL, '2025-07-22 13:47:13', 'month', NULL, '2025-07-22 13:47:13'),
(115, 1, 'Year', 'Year', 'days', '365', 'multiplication', NULL, 1, NULL, '2025-07-22 13:47:13', 'year', NULL, '2025-07-22 13:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `cs_users`
--

CREATE TABLE `cs_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_users`
--

INSERT INTO `cs_users` (`id`, `company_id`, `branch_id`, `warehouse_id`, `employee_id`, `role_id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 'Admin', 'admin@example.com', '2025-05-31 18:47:15', '$2y$12$NX8jAe9kReSruhghxmrwoePYgqD7sGLeBdUop8BInD12a0Cd9HMgK', NULL, NULL, NULL, NULL, '2025-05-31 18:51:29', '2025-05-31 18:51:32');

-- --------------------------------------------------------

--
-- Table structure for table `cs_warehouse_unit`
--

CREATE TABLE `cs_warehouse_unit` (
  `wu_id` bigint(20) UNSIGNED NOT NULL,
  `wu_no` varchar(50) DEFAULT NULL,
  `wu_name` varchar(100) DEFAULT NULL,
  `temperature_range` varchar(50) DEFAULT NULL,
  `storage_product_type_id` int(11) DEFAULT NULL,
  `no_of_docks` int(11) DEFAULT NULL,
  `no_of_rooms` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive','Maintenance') DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cs_warehouse_unit`
--

INSERT INTO `cs_warehouse_unit` (`wu_id`, `wu_no`, `wu_name`, `temperature_range`, `storage_product_type_id`, `no_of_docks`, `no_of_rooms`, `is_active`, `status`, `created_at`, `updated_at`) VALUES
(1, 'WU-001', 'Main Cold Storage', '-18°C to -22°C', 1, 4, 12, 1, 'Active', '2025-08-26 07:06:30', '2025-08-26 07:06:30'),
(2, 'WU-002', 'Chilled Goods Section', '0°C to 4°C', 2, 2, 6, 1, 'Active', '2025-08-26 07:06:30', '2025-08-26 07:06:30'),
(3, 'WU-003', 'Dry Storage Area', '15°C to 25°C', 3, 1, 8, 1, 'Active', '2025-08-26 07:06:30', '2025-08-26 07:06:30'),
(4, 'WU-004', 'Frozen Seafood Unit', '-20°C', 1, 3, 5, 0, 'Maintenance', '2025-08-26 07:06:30', '2025-08-26 07:06:30'),
(5, 'WU-005', 'Pharma Cold Room', '2°C to 8°C', 4, 2, 4, 1, 'Active', '2025-08-26 07:06:30', '2025-08-26 07:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(100) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GRN`
--

CREATE TABLE `GRN` (
  `GRNBatchID` int(11) NOT NULL,
  `DocType` varchar(15) DEFAULT NULL,
  `Prefix` varchar(20) DEFAULT NULL,
  `Suffix` int(11) DEFAULT NULL,
  `GRNDate` datetime DEFAULT NULL,
  `GRNDateTemp` datetime DEFAULT NULL,
  `InvoiceNumber` varchar(250) DEFAULT NULL,
  `InvoiceDate` date DEFAULT NULL,
  `InvoiceAmount` double DEFAULT NULL,
  `InvoiceAmountUSD` double DEFAULT NULL,
  `BranchOrderNo` varchar(250) DEFAULT NULL,
  `CreditDays` int(3) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `CompanyID` int(11) DEFAULT NULL,
  `BranchID` int(11) DEFAULT NULL,
  `DepartmentID` int(11) DEFAULT NULL,
  `DivisionID` int(11) DEFAULT NULL,
  `LocationID` int(11) DEFAULT NULL,
  `StorageID` varchar(45) DEFAULT NULL,
  `SupplierID` int(11) DEFAULT NULL,
  `Consignment` int(1) DEFAULT 0,
  `OrderType` varchar(45) DEFAULT NULL,
  `Currency` varchar(45) DEFAULT NULL,
  `CurrencyRate` double DEFAULT NULL,
  `OtherCharges` double DEFAULT NULL,
  `LoadingCharge` double DEFAULT NULL,
  `AddCommission` double DEFAULT NULL,
  `LessCommission` double DEFAULT NULL,
  `PackingMaterials` double DEFAULT NULL,
  `AdvanceToDriverOrOther` double DEFAULT NULL,
  `Insurrance` double DEFAULT NULL,
  `LocalRent` double DEFAULT NULL,
  `AddFreight` double DEFAULT NULL,
  `LessFreight` double DEFAULT NULL,
  `CratesCharges` double DEFAULT NULL,
  `FreightAmount` double DEFAULT NULL,
  `FreightTaxID` int(5) DEFAULT NULL,
  `FreightTax` double DEFAULT NULL,
  `FreightCharge` double DEFAULT NULL,
  `Freight2Amount` double DEFAULT NULL,
  `Freight2TaxID` int(5) DEFAULT NULL,
  `Freight2Tax` double DEFAULT NULL,
  `Freight2Charge` double DEFAULT NULL,
  `InsuranceAmount` double DEFAULT NULL,
  `InsuranceTaxID` int(5) DEFAULT NULL,
  `InsuranceTax` double DEFAULT NULL,
  `InsuranceCharge` double DEFAULT NULL,
  `PackingAmount` double DEFAULT NULL,
  `PackingTaxID` int(5) DEFAULT NULL,
  `PackingTax` double DEFAULT NULL,
  `PackingCharge` double DEFAULT NULL,
  `DiscountAmount` double DEFAULT NULL,
  `RoundOff` double DEFAULT 0,
  `Amount` double DEFAULT NULL,
  `Narration` varchar(45) DEFAULT NULL,
  `TransportMode` int(11) DEFAULT NULL,
  `TransportName` varchar(45) DEFAULT NULL,
  `VehicleNo` varchar(30) DEFAULT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `Attachments` text DEFAULT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `HasPO` enum('1','0') DEFAULT '0',
  `AccPosted` int(1) DEFAULT 0,
  `PrintedDate` datetime DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `OC_Discount` double DEFAULT NULL,
  `OC_Insurance` double DEFAULT NULL,
  `SingleBatch` int(1) DEFAULT 0,
  `SingleBatchUpdated` int(1) DEFAULT 0,
  `TempFreight` double DEFAULT 0,
  `GSTINApplied` char(1) DEFAULT NULL,
  `BranchTransfer` int(1) DEFAULT 0,
  `PurchaseOrderID` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GRNDetail`
--

CREATE TABLE `GRNDetail` (
  `GRNProductID` int(11) NOT NULL,
  `GRNBatchID` int(11) DEFAULT NULL,
  `SupplierID` int(11) DEFAULT NULL,
  `Consignment` int(1) DEFAULT 0,
  `PurchaseOrderID` int(11) DEFAULT NULL,
  `POProductID` int(11) DEFAULT NULL,
  `ProductMasterID` int(11) DEFAULT NULL,
  `PurchaseOrderNo` varchar(30) DEFAULT NULL,
  `ProductDescription` varchar(45) DEFAULT NULL,
  `ProductVariantID` bigint(20) DEFAULT NULL,
  `BatchNo` varchar(250) DEFAULT NULL,
  `BarcodeSupplier` varchar(250) DEFAULT NULL,
  `ExpiryDate` varchar(15) DEFAULT NULL,
  `Specification` varchar(45) DEFAULT NULL,
  `OrderQuantity` double DEFAULT NULL,
  `ReceivedQuantity` double DEFAULT NULL,
  `UnitID` int(11) DEFAULT NULL,
  `WeightPerUnit` double DEFAULT NULL,
  `FOC` enum('1','0') DEFAULT '0',
  `Discrepancy` int(1) DEFAULT 0,
  `DRemarks` text DEFAULT NULL,
  `DQty` double(10,2) DEFAULT NULL,
  `D_TQty` double DEFAULT NULL,
  `D_MQty` double DEFAULT NULL,
  `D_LQty` double DEFAULT NULL,
  `D_DUnitID` int(11) DEFAULT NULL,
  `D_TUnitID` int(11) DEFAULT NULL,
  `D_MUnitID` int(11) DEFAULT NULL,
  `D_LUnitID` int(11) DEFAULT NULL,
  `DClose` int(1) DEFAULT 0,
  `DCloseDate` date DEFAULT NULL,
  `DCloseRemarks` text DEFAULT NULL,
  `DescrepancyAttach` text DEFAULT NULL,
  `CurPurchaseRate` double(15,2) DEFAULT NULL,
  `PurchaseRate` double DEFAULT 0,
  `PurchaseValue` double DEFAULT 0,
  `ProductRatePer` double DEFAULT 0,
  `ExpenseRate` double DEFAULT 0,
  `LandedCost` double DEFAULT 0,
  `MRP` double DEFAULT 0,
  `Discount` double DEFAULT 0,
  `DiscountPrice` double DEFAULT 0,
  `TaxType` varchar(10) DEFAULT NULL,
  `TaxID` int(3) DEFAULT NULL,
  `Tax` double DEFAULT 0,
  `TaxValue` double DEFAULT 0,
  `NetValue` double DEFAULT 0,
  `PurchaseRateLC` double DEFAULT 0,
  `PurchaseValueLC` double DEFAULT 0,
  `ProductRatePerLC` double DEFAULT 0,
  `ExpenseRateLC` double DEFAULT 0,
  `LandedCostLC` double DEFAULT 0,
  `OriginalLandedCostLC` double DEFAULT NULL,
  `OriginalPurchaseRateLC` double(15,2) DEFAULT NULL,
  `MRPLC` double DEFAULT 0,
  `DiscountLC` double DEFAULT 0,
  `DiscountPriceLC` double DEFAULT 0,
  `TaxTypeLC` varchar(10) DEFAULT NULL,
  `TaxLC` double DEFAULT 0,
  `TaxValueLC` double DEFAULT 0,
  `NetValueLC` double DEFAULT 0,
  `PrevLandedCost` double DEFAULT NULL,
  `PrevMRP` double(15,2) DEFAULT NULL,
  `StockUpdate` int(1) DEFAULT 0,
  `POUpdate` int(1) DEFAULT 0,
  `AddToClaim` int(1) DEFAULT 0,
  `UpdateBPP` int(1) DEFAULT 0,
  `TrayID` int(11) DEFAULT NULL,
  `TrayQty` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(100) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `login_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(100) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_04_03_080722_add_two_factor_columns_to_users_table', 1),
(5, '2025_04_03_080804_create_login_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7mZNV2mx0r2T9uEysjQnq6vRlWIxmCzDBJqJVyuU', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU1BYSVdMOHZGdVRsa0RETjVNdlBBRXRJSVBneDQwNnUzSDVVa21EciI7czozOiJ1cmwiO2E6MDp7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzU2NjE4NTAwO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1ODoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL3NhbGVzL2N1c3RvbWVyLWNvbnRyYWN0L2NyZWF0ZSI7fX0=', 1756638039);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cs_analytical`
--
ALTER TABLE `cs_analytical`
  ADD PRIMARY KEY (`analytical_id`);

--
-- Indexes for table `cs_attachments`
--
ALTER TABLE `cs_attachments`
  ADD PRIMARY KEY (`attachment_id`);

--
-- Indexes for table `cs_bank_master`
--
ALTER TABLE `cs_bank_master`
  ADD PRIMARY KEY (`bank_master_id`);

--
-- Indexes for table `cs_blocks`
--
ALTER TABLE `cs_blocks`
  ADD PRIMARY KEY (`block_id`);

--
-- Indexes for table `cs_branch`
--
ALTER TABLE `cs_branch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `cs_brand`
--
ALTER TABLE `cs_brand`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cs_chart_of_account`
--
ALTER TABLE `cs_chart_of_account`
  ADD PRIMARY KEY (`account_id`),
  ADD KEY `Level_2_ID` (`level_2_id`),
  ADD KEY `AccountCode` (`account_code`);

--
-- Indexes for table `cs_city`
--
ALTER TABLE `cs_city`
  ADD PRIMARY KEY (`city_id`);

--
-- Indexes for table `cs_client`
--
ALTER TABLE `cs_client`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `cs_company`
--
ALTER TABLE `cs_company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `cs_country`
--
ALTER TABLE `cs_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `cs_customer`
--
ALTER TABLE `cs_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `cs_customer_enquiry`
--
ALTER TABLE `cs_customer_enquiry`
  ADD PRIMARY KEY (`customer_enquiry_id`);

--
-- Indexes for table `cs_department`
--
ALTER TABLE `cs_department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `cs_designation`
--
ALTER TABLE `cs_designation`
  ADD PRIMARY KEY (`designation_id`);

--
-- Indexes for table `cs_district`
--
ALTER TABLE `cs_district`
  ADD PRIMARY KEY (`district_id`);

--
-- Indexes for table `cs_docks`
--
ALTER TABLE `cs_docks`
  ADD PRIMARY KEY (`dock_id`),
  ADD UNIQUE KEY `dock_no` (`dock_no`);

--
-- Indexes for table `cs_employee`
--
ALTER TABLE `cs_employee`
  ADD PRIMARY KEY (`employee_id`);

--
-- Indexes for table `cs_gate_pass`
--
ALTER TABLE `cs_gate_pass`
  ADD PRIMARY KEY (`gate_pass_id`);

--
-- Indexes for table `cs_gate_pass_details`
--
ALTER TABLE `cs_gate_pass_details`
  ADD PRIMARY KEY (`gate_pass_detail_id`);

--
-- Indexes for table `cs_general_ledger`
--
ALTER TABLE `cs_general_ledger`
  ADD PRIMARY KEY (`gl_id`);

--
-- Indexes for table `cs_inward`
--
ALTER TABLE `cs_inward`
  ADD PRIMARY KEY (`inward_id`);

--
-- Indexes for table `cs_inward_detail`
--
ALTER TABLE `cs_inward_detail`
  ADD PRIMARY KEY (`inward_detail_id`);

--
-- Indexes for table `cs_journal`
--
ALTER TABLE `cs_journal`
  ADD PRIMARY KEY (`journal_id`);

--
-- Indexes for table `cs_journal_detail`
--
ALTER TABLE `cs_journal_detail`
  ADD PRIMARY KEY (`journal_detail_id`);

--
-- Indexes for table `cs_level_1`
--
ALTER TABLE `cs_level_1`
  ADD PRIMARY KEY (`level_1_id`),
  ADD KEY `Code` (`code`);

--
-- Indexes for table `cs_level_2`
--
ALTER TABLE `cs_level_2`
  ADD PRIMARY KEY (`level_2_id`),
  ADD KEY `Level_1_ID` (`level_1_id`),
  ADD KEY `Code` (`code`);

--
-- Indexes for table `cs_menu`
--
ALTER TABLE `cs_menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `cs_outward`
--
ALTER TABLE `cs_outward`
  ADD PRIMARY KEY (`outward_id`);

--
-- Indexes for table `cs_outward_detail`
--
ALTER TABLE `cs_outward_detail`
  ADD PRIMARY KEY (`outward_detail_id`);

--
-- Indexes for table `cs_package_type`
--
ALTER TABLE `cs_package_type`
  ADD PRIMARY KEY (`package_type_id`);

--
-- Indexes for table `cs_packing_list`
--
ALTER TABLE `cs_packing_list`
  ADD PRIMARY KEY (`packing_list_id`);

--
-- Indexes for table `cs_packing_list_detail`
--
ALTER TABLE `cs_packing_list_detail`
  ADD PRIMARY KEY (`packing_list_detail_id`);

--
-- Indexes for table `cs_pallets`
--
ALTER TABLE `cs_pallets`
  ADD PRIMARY KEY (`pallet_id`);

--
-- Indexes for table `cs_pallet_types`
--
ALTER TABLE `cs_pallet_types`
  ADD PRIMARY KEY (`pallet_type_id`);

--
-- Indexes for table `cs_payment_purpose`
--
ALTER TABLE `cs_payment_purpose`
  ADD PRIMARY KEY (`purpose_id`);

--
-- Indexes for table `cs_payment_settlement`
--
ALTER TABLE `cs_payment_settlement`
  ADD PRIMARY KEY (`settlement_id`);

--
-- Indexes for table `cs_payment_voucher`
--
ALTER TABLE `cs_payment_voucher`
  ADD PRIMARY KEY (`payment_voucher_id`);

--
-- Indexes for table `cs_permission`
--
ALTER TABLE `cs_permission`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `cs_picklist`
--
ALTER TABLE `cs_picklist`
  ADD PRIMARY KEY (`picklist_id`);

--
-- Indexes for table `cs_picklist_detail`
--
ALTER TABLE `cs_picklist_detail`
  ADD PRIMARY KEY (`picklist_detail_id`);

--
-- Indexes for table `cs_place`
--
ALTER TABLE `cs_place`
  ADD PRIMARY KEY (`place_id`);

--
-- Indexes for table `cs_port`
--
ALTER TABLE `cs_port`
  ADD PRIMARY KEY (`port_id`);

--
-- Indexes for table `cs_post_office`
--
ALTER TABLE `cs_post_office`
  ADD PRIMARY KEY (`post_office_id`);

--
-- Indexes for table `cs_product`
--
ALTER TABLE `cs_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `cs_product_attributes`
--
ALTER TABLE `cs_product_attributes`
  ADD PRIMARY KEY (`product_attribute_id`);

--
-- Indexes for table `cs_product_category`
--
ALTER TABLE `cs_product_category`
  ADD PRIMARY KEY (`product_category_id`),
  ADD KEY `ProductDivisionID` (`product_division_id`);

--
-- Indexes for table `cs_product_master`
--
ALTER TABLE `cs_product_master`
  ADD PRIMARY KEY (`product_master_id`),
  ADD KEY `BrandID` (`brand_id`),
  ADD KEY `ProductCategoryID` (`product_category_id`),
  ADD KEY `ForClosingStockReport` (`brand_id`,`product_category_id`);

--
-- Indexes for table `cs_product_specifications`
--
ALTER TABLE `cs_product_specifications`
  ADD PRIMARY KEY (`prod_spec_id`);

--
-- Indexes for table `cs_product_types`
--
ALTER TABLE `cs_product_types`
  ADD PRIMARY KEY (`product_type_id`);

--
-- Indexes for table `cs_product_type_price`
--
ALTER TABLE `cs_product_type_price`
  ADD PRIMARY KEY (`price_id`);

--
-- Indexes for table `cs_product_variants`
--
ALTER TABLE `cs_product_variants`
  ADD PRIMARY KEY (`product_variant_id`);

--
-- Indexes for table `cs_product_variant_specifications`
--
ALTER TABLE `cs_product_variant_specifications`
  ADD PRIMARY KEY (`prod_variant_spec_id`);

--
-- Indexes for table `cs_prod_cat_svg_img`
--
ALTER TABLE `cs_prod_cat_svg_img`
  ADD PRIMARY KEY (`prod_cat_svg_img_id`);

--
-- Indexes for table `cs_racks`
--
ALTER TABLE `cs_racks`
  ADD PRIMARY KEY (`rack_id`);

--
-- Indexes for table `cs_receipt`
--
ALTER TABLE `cs_receipt`
  ADD PRIMARY KEY (`receipt_id`);

--
-- Indexes for table `cs_role`
--
ALTER TABLE `cs_role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `cs_role_menu_permission`
--
ALTER TABLE `cs_role_menu_permission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_menu_permission_unique` (`role_id`,`menu_id`,`permission_id`),
  ADD KEY `menu_id` (`menu_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `cs_sales_item`
--
ALTER TABLE `cs_sales_item`
  ADD PRIMARY KEY (`sales_item_id`);

--
-- Indexes for table `cs_sales_quotation`
--
ALTER TABLE `cs_sales_quotation`
  ADD PRIMARY KEY (`sq_id`);

--
-- Indexes for table `cs_sales_quotation_details`
--
ALTER TABLE `cs_sales_quotation_details`
  ADD PRIMARY KEY (`sq_detail_id`);

--
-- Indexes for table `cs_slots`
--
ALTER TABLE `cs_slots`
  ADD PRIMARY KEY (`slot_id`);

--
-- Indexes for table `cs_state`
--
ALTER TABLE `cs_state`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `cs_status`
--
ALTER TABLE `cs_status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `cs_status_updates`
--
ALTER TABLE `cs_status_updates`
  ADD PRIMARY KEY (`status_update_id`);

--
-- Indexes for table `cs_stock`
--
ALTER TABLE `cs_stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `cs_stock_adjustment`
--
ALTER TABLE `cs_stock_adjustment`
  ADD PRIMARY KEY (`stock_adjustment_id`);

--
-- Indexes for table `cs_stock_adjustment_detail`
--
ALTER TABLE `cs_stock_adjustment_detail`
  ADD PRIMARY KEY (`stock_adjustment_detail_id`);

--
-- Indexes for table `cs_storage_rooms`
--
ALTER TABLE `cs_storage_rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `cs_supplier`
--
ALTER TABLE `cs_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `cs_supplier_category`
--
ALTER TABLE `cs_supplier_category`
  ADD PRIMARY KEY (`supplier_category_id`);

--
-- Indexes for table `cs_tax`
--
ALTER TABLE `cs_tax`
  ADD PRIMARY KEY (`tax_id`);

--
-- Indexes for table `cs_transaction_type`
--
ALTER TABLE `cs_transaction_type`
  ADD PRIMARY KEY (`transaction_type_id`);

--
-- Indexes for table `cs_unit`
--
ALTER TABLE `cs_unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `cs_users`
--
ALTER TABLE `cs_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cs_warehouse_unit`
--
ALTER TABLE `cs_warehouse_unit`
  ADD PRIMARY KEY (`wu_id`),
  ADD UNIQUE KEY `wu_no` (`wu_no`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `GRN`
--
ALTER TABLE `GRN`
  ADD PRIMARY KEY (`GRNBatchID`),
  ADD KEY `SupplierID` (`SupplierID`),
  ADD KEY `BranchID` (`BranchID`),
  ADD KEY `Status` (`Status`),
  ADD KEY `CreatedDate` (`CreatedDate`);

--
-- Indexes for table `GRNDetail`
--
ALTER TABLE `GRNDetail`
  ADD PRIMARY KEY (`GRNProductID`),
  ADD KEY `GRNBatchID` (`GRNBatchID`),
  ADD KEY `ProductMasterID` (`ProductMasterID`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cs_analytical`
--
ALTER TABLE `cs_analytical`
  MODIFY `analytical_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_attachments`
--
ALTER TABLE `cs_attachments`
  MODIFY `attachment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_blocks`
--
ALTER TABLE `cs_blocks`
  MODIFY `block_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cs_branch`
--
ALTER TABLE `cs_branch`
  MODIFY `branch_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_brand`
--
ALTER TABLE `cs_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cs_chart_of_account`
--
ALTER TABLE `cs_chart_of_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cs_city`
--
ALTER TABLE `cs_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_client`
--
ALTER TABLE `cs_client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_company`
--
ALTER TABLE `cs_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_country`
--
ALTER TABLE `cs_country`
  MODIFY `country_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_customer`
--
ALTER TABLE `cs_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cs_customer_enquiry`
--
ALTER TABLE `cs_customer_enquiry`
  MODIFY `customer_enquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_department`
--
ALTER TABLE `cs_department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_designation`
--
ALTER TABLE `cs_designation`
  MODIFY `designation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_district`
--
ALTER TABLE `cs_district`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_docks`
--
ALTER TABLE `cs_docks`
  MODIFY `dock_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_employee`
--
ALTER TABLE `cs_employee`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_gate_pass`
--
ALTER TABLE `cs_gate_pass`
  MODIFY `gate_pass_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_gate_pass_details`
--
ALTER TABLE `cs_gate_pass_details`
  MODIFY `gate_pass_detail_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_general_ledger`
--
ALTER TABLE `cs_general_ledger`
  MODIFY `gl_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_inward`
--
ALTER TABLE `cs_inward`
  MODIFY `inward_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cs_inward_detail`
--
ALTER TABLE `cs_inward_detail`
  MODIFY `inward_detail_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_journal`
--
ALTER TABLE `cs_journal`
  MODIFY `journal_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_level_1`
--
ALTER TABLE `cs_level_1`
  MODIFY `level_1_id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cs_level_2`
--
ALTER TABLE `cs_level_2`
  MODIFY `level_2_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cs_menu`
--
ALTER TABLE `cs_menu`
  MODIFY `menu_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `cs_outward`
--
ALTER TABLE `cs_outward`
  MODIFY `outward_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_outward_detail`
--
ALTER TABLE `cs_outward_detail`
  MODIFY `outward_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cs_package_type`
--
ALTER TABLE `cs_package_type`
  MODIFY `package_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_packing_list`
--
ALTER TABLE `cs_packing_list`
  MODIFY `packing_list_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_packing_list_detail`
--
ALTER TABLE `cs_packing_list_detail`
  MODIFY `packing_list_detail_id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cs_pallets`
--
ALTER TABLE `cs_pallets`
  MODIFY `pallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cs_pallet_types`
--
ALTER TABLE `cs_pallet_types`
  MODIFY `pallet_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_payment_purpose`
--
ALTER TABLE `cs_payment_purpose`
  MODIFY `purpose_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `cs_payment_settlement`
--
ALTER TABLE `cs_payment_settlement`
  MODIFY `settlement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_payment_voucher`
--
ALTER TABLE `cs_payment_voucher`
  MODIFY `payment_voucher_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_permission`
--
ALTER TABLE `cs_permission`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cs_picklist`
--
ALTER TABLE `cs_picklist`
  MODIFY `picklist_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_picklist_detail`
--
ALTER TABLE `cs_picklist_detail`
  MODIFY `picklist_detail_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cs_place`
--
ALTER TABLE `cs_place`
  MODIFY `place_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_port`
--
ALTER TABLE `cs_port`
  MODIFY `port_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_post_office`
--
ALTER TABLE `cs_post_office`
  MODIFY `post_office_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_product`
--
ALTER TABLE `cs_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_product_attributes`
--
ALTER TABLE `cs_product_attributes`
  MODIFY `product_attribute_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_product_category`
--
ALTER TABLE `cs_product_category`
  MODIFY `product_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_product_master`
--
ALTER TABLE `cs_product_master`
  MODIFY `product_master_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_product_specifications`
--
ALTER TABLE `cs_product_specifications`
  MODIFY `prod_spec_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_product_types`
--
ALTER TABLE `cs_product_types`
  MODIFY `product_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cs_product_type_price`
--
ALTER TABLE `cs_product_type_price`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_product_variants`
--
ALTER TABLE `cs_product_variants`
  MODIFY `product_variant_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_product_variant_specifications`
--
ALTER TABLE `cs_product_variant_specifications`
  MODIFY `prod_variant_spec_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_prod_cat_svg_img`
--
ALTER TABLE `cs_prod_cat_svg_img`
  MODIFY `prod_cat_svg_img_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `cs_racks`
--
ALTER TABLE `cs_racks`
  MODIFY `rack_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cs_receipt`
--
ALTER TABLE `cs_receipt`
  MODIFY `receipt_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_role`
--
ALTER TABLE `cs_role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_role_menu_permission`
--
ALTER TABLE `cs_role_menu_permission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2981;

--
-- AUTO_INCREMENT for table `cs_sales_item`
--
ALTER TABLE `cs_sales_item`
  MODIFY `sales_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cs_sales_quotation`
--
ALTER TABLE `cs_sales_quotation`
  MODIFY `sq_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cs_sales_quotation_details`
--
ALTER TABLE `cs_sales_quotation_details`
  MODIFY `sq_detail_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_slots`
--
ALTER TABLE `cs_slots`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=337;

--
-- AUTO_INCREMENT for table `cs_state`
--
ALTER TABLE `cs_state`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_status`
--
ALTER TABLE `cs_status`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `cs_status_updates`
--
ALTER TABLE `cs_status_updates`
  MODIFY `status_update_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cs_stock`
--
ALTER TABLE `cs_stock`
  MODIFY `stock_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_stock_adjustment`
--
ALTER TABLE `cs_stock_adjustment`
  MODIFY `stock_adjustment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_stock_adjustment_detail`
--
ALTER TABLE `cs_stock_adjustment_detail`
  MODIFY `stock_adjustment_detail_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_storage_rooms`
--
ALTER TABLE `cs_storage_rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cs_supplier`
--
ALTER TABLE `cs_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_supplier_category`
--
ALTER TABLE `cs_supplier_category`
  MODIFY `supplier_category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_tax`
--
ALTER TABLE `cs_tax`
  MODIFY `tax_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cs_transaction_type`
--
ALTER TABLE `cs_transaction_type`
  MODIFY `transaction_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cs_unit`
--
ALTER TABLE `cs_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cs_warehouse_unit`
--
ALTER TABLE `cs_warehouse_unit`
  MODIFY `wu_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `GRN`
--
ALTER TABLE `GRN`
  MODIFY `GRNBatchID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `GRNDetail`
--
ALTER TABLE `GRNDetail`
  MODIFY `GRNProductID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cs_role_menu_permission`
--
ALTER TABLE `cs_role_menu_permission`
  ADD CONSTRAINT `cs_role_menu_permission_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `cs_role` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cs_role_menu_permission_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `cs_menu` (`menu_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cs_role_menu_permission_ibfk_3` FOREIGN KEY (`permission_id`) REFERENCES `cs_permission` (`permission_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
