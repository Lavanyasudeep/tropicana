-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 26, 2025 at 05:19 PM
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
-- Database: `pjj_coldstorage`
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

-- --------------------------------------------------------

--
-- Table structure for table `cs_chart_of_account`
--

CREATE TABLE `cs_chart_of_account` (
  `account_id` int(11) NOT NULL,
  `company_id` int(3) NOT NULL,
  `account_group_id` int(5) NOT NULL,
  `account_name` varchar(250) DEFAULT NULL,
  `account_code` varchar(50) DEFAULT NULL,
  `contra_account_code` varchar(50) DEFAULT NULL,
  `level_1_id` int(3) DEFAULT NULL,
  `level_2_id` int(3) NOT NULL,
  `level_3_id` int(5) NOT NULL,
  `level_4_id` int(5) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `cs_company`
--

CREATE TABLE `cs_company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(150) DEFAULT NULL,
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
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `cs_outward`
--

CREATE TABLE `cs_outward` (
  `outward_id` bigint(20) NOT NULL,
  `company_id` int(3) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  ```doc_type`` varchar(50) DEFAULT NULL,` varchar(50) DEFAULT NULL,
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
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `package_qty_per_pallet` double(15,2) DEFAULT 0.00,
  `pallet_qty` double(15,2) DEFAULT 0.00,
  `gw_per_package` double(15,2) DEFAULT 0.00,
  `nw_per_package` double(15,2) DEFAULT 0.00,
  `gw_with_pallet` double(15,2) DEFAULT 0.00,
  `nw_kg` double(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cs_pallets`
--

CREATE TABLE `cs_pallets` (
  `pallet_id` int(11) NOT NULL,
  `pallet_no` text DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
  `rack_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `barcode` varchar(50) DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `cs_payment`
--

CREATE TABLE `cs_payment` (
  `payment_id` bigint(20) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `doc_type` varchar(30) DEFAULT NULL,
  `doc_no` varchar(250) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `doc_date_time` datetime DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `voucher_type` varchar(100) DEFAULT NULL COMMENT 'pettycash, supplier payment, contra',
  `payment_mode` varchar(50) DEFAULT NULL COMMENT 'cash, transfer, cheque, UPI',
  `payment_type` varchar(50) DEFAULT NULL COMMENT 'full,partial,advance',
  `from_account_code` varchar(30) DEFAULT NULL,
  `to_account_code` varchar(30) DEFAULT NULL,
  `analytical_code` varchar(250) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `Remarks` text DEFAULT NULL,
  `requested_amount` double DEFAULT NULL,
  `approved_amount` double DEFAULT NULL,
  `paid_amount` double DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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

-- --------------------------------------------------------

--
-- Table structure for table `cs_racks`
--

CREATE TABLE `cs_racks` (
  `rack_id` int(11) NOT NULL,
  `rack_no` text DEFAULT NULL,
  `room_id` int(11) DEFAULT NULL,
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
  `status` enum('empty','partial','full') NOT NULL DEFAULT 'empty',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `cs_status_updates`
--

CREATE TABLE `cs_status_updates` (
  `status_update_id` bigint(20) NOT NULL,
  `company_id` int(2) NOT NULL,
  `table_name` varchar(250) NOT NULL,
  `row_id` bigint(20) DEFAULT NULL,
  `column_name` varchar(100) NOT NULL,
  `column_value` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `doc_no` varchar(50) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `total_qty` decimal(15,2) DEFAULT NULL,
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
  `package_qty_per_pallet` decimal(10,2) DEFAULT NULL,
  `pallet_qty` decimal(10,2) DEFAULT NULL,
  `ref_doc_type` varchar(50) DEFAULT NULL,
  `ref_doc_no` varchar(100) DEFAULT NULL,
  `ref_doc_date` date DEFAULT NULL,
  `reason` varchar(250) DEFAULT NULL,
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
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `total_capacity` decimal(10,2) DEFAULT NULL,
  `temperature_range` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Table structure for table `cs_unit`
--

CREATE TABLE `cs_unit` (
  `unit_id` int(11) NOT NULL,
  `company_id` int(2) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `stock_unit` varchar(100) NOT NULL,
  `conversion_quantity` varchar(45) DEFAULT NULL,
  `kilo` float DEFAULT NULL,
  `sign` varchar(100) DEFAULT NULL,
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
-- Table structure for table `cs_users`
--

CREATE TABLE `cs_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `cs_warehouse`
--

CREATE TABLE `cs_warehouse` (
  `warehouse_id` bigint(20) NOT NULL,
  `warehouse_name` varchar(100) DEFAULT NULL,
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
-- Table structure for table `Product`
--

CREATE TABLE `Product` (
  `ProductID` int(11) NOT NULL,
  `CompanyID` int(2) NOT NULL,
  `ProductName` varchar(45) DEFAULT NULL,
  `ProductDescription` varchar(200) DEFAULT NULL,
  `ProductCode` varchar(45) DEFAULT NULL,
  `ProductGroupID` int(11) DEFAULT NULL,
  `TaxID` int(3) NOT NULL,
  `ShortName` varchar(50) DEFAULT NULL,
  `Datasheet` varchar(45) DEFAULT NULL,
  `Recipe` varchar(300) DEFAULT NULL,
  `Preparation` varchar(300) DEFAULT NULL,
  `Image` varchar(300) DEFAULT NULL,
  `New` int(1) NOT NULL,
  `Unknown` int(1) NOT NULL DEFAULT 0,
  `AllowNegative` int(1) NOT NULL DEFAULT 0,
  `WeightPerBox` double DEFAULT NULL,
  `BoxCapacityPerPallet` double DEFAULT NULL,
  `Active` int(1) DEFAULT 1,
  `DelStatus` int(1) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProductCategory`
--

CREATE TABLE `ProductCategory` (
  `ProductCategoryID` int(11) NOT NULL,
  `ProductCategoryID_DataMig` int(11) NOT NULL,
  `CompanyID` int(2) NOT NULL,
  `ProductCategoryName` varchar(100) DEFAULT NULL,
  `ShortName` varchar(50) NOT NULL,
  `ProductDivisionID` int(11) DEFAULT NULL,
  `Tax` text DEFAULT NULL,
  `AcCashSales` varchar(6) NOT NULL,
  `AcCreditSales` varchar(6) NOT NULL,
  `AcIntercoSales` varchar(6) NOT NULL,
  `AcOtherSales` varchar(6) NOT NULL,
  `AcReceivableControl` varchar(6) NOT NULL,
  `Active` enum('1','0') DEFAULT NULL,
  `DelStatus` int(1) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProductMaster`
--

CREATE TABLE `ProductMaster` (
  `ProductMasterID` bigint(11) NOT NULL,
  `CompanyID` int(11) DEFAULT NULL,
  `DivisionID` int(11) DEFAULT NULL,
  `ProductDivisionID` int(11) DEFAULT NULL,
  `ProductCategoryID` int(11) DEFAULT NULL,
  `ProductGroupID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `ProductPackingID` int(11) DEFAULT NULL,
  `PurchaseUnitID` int(3) NOT NULL,
  `SellingUnitID` int(3) NOT NULL,
  `BrandID` int(11) DEFAULT NULL,
  `ProductOriginID` int(11) DEFAULT NULL,
  `TaxID` int(3) NOT NULL,
  `Tax` double NOT NULL,
  `ProductNewGroup` text NOT NULL,
  `ProductDescription` text DEFAULT NULL,
  `ProductDescriptionTemp` text DEFAULT NULL,
  `ProductCode` varchar(45) NOT NULL,
  `ProductCodeSupplier` varchar(15) NOT NULL,
  `ProdDescSupplier` text NOT NULL,
  `HSNCode` varchar(15) NOT NULL,
  `SupplierID` int(3) NOT NULL,
  `MinStockQty` double NOT NULL DEFAULT 0,
  `MaxStockQty` double NOT NULL DEFAULT 0,
  `ReOrderLevel` double NOT NULL DEFAULT 0,
  `ReOrderQty` double NOT NULL DEFAULT 0,
  `BarcodeInHouse` varchar(48) DEFAULT NULL,
  `BarcodeSupplier` varchar(48) DEFAULT NULL,
  `New` int(1) NOT NULL,
  `Unknown` int(1) NOT NULL DEFAULT 0,
  `ProductWeight` double NOT NULL,
  `AllowNegative` int(1) NOT NULL DEFAULT 0,
  `Loose` int(1) NOT NULL DEFAULT 1,
  `SingleBatch` int(1) NOT NULL DEFAULT 0,
  `WeightPerBox` double DEFAULT NULL,
  `BoxCapacityPerPallet` double DEFAULT NULL,
  `NoOfItemsInBox` double DEFAULT NULL,
  `Active` int(1) DEFAULT 1,
  `ArrivalDate` date DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `Supplier`
--

CREATE TABLE `Supplier` (
  `SupplierID` int(11) NOT NULL,
  `SupplierID_DataMig` varchar(11) DEFAULT NULL,
  `CompanyID` int(2) DEFAULT NULL,
  `SupplierTypeID` int(11) DEFAULT NULL,
  `SupplierCategoryID` int(11) DEFAULT NULL,
  `SupplierCode` varchar(45) DEFAULT NULL,
  `SupplierName` varchar(150) DEFAULT NULL,
  `SupplierInvoiceName` text DEFAULT NULL,
  `ContactPerson` varchar(50) DEFAULT NULL,
  `ContactNumber` varchar(250) DEFAULT NULL,
  `Mobile` varchar(250) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `PostOfficeID` int(11) DEFAULT NULL,
  `Pincode` varchar(15) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Aadhaar` varchar(30) DEFAULT NULL,
  `CityID` int(11) DEFAULT NULL,
  `DistrictID` int(11) DEFAULT NULL,
  `StateID` int(11) DEFAULT NULL,
  `CountryID` int(11) DEFAULT NULL,
  `BankName` varchar(45) DEFAULT NULL,
  `AccountNumber` varchar(250) DEFAULT NULL,
  `IFSCCode` varchar(50) DEFAULT NULL,
  `RTGSCode` varchar(45) DEFAULT NULL,
  `SwiftCode` varchar(45) DEFAULT NULL,
  `BankEmail` varchar(45) DEFAULT NULL,
  `OtherDetails` varchar(300) DEFAULT NULL,
  `TermsofPayment` varchar(100) DEFAULT NULL,
  `TaxPercentage` double DEFAULT NULL,
  `DiscountType` varchar(45) DEFAULT NULL,
  `DiscountTerms` varchar(45) DEFAULT NULL,
  `DiscountDefinition` varchar(45) DEFAULT NULL,
  `PeriodofDiscount` int(11) DEFAULT NULL,
  `Attachments` varchar(200) DEFAULT NULL,
  `VendorGrade` varchar(45) DEFAULT NULL,
  `SupplierGroup` varchar(45) DEFAULT NULL,
  `GroupCode` varchar(30) DEFAULT NULL,
  `Currency` varchar(5) DEFAULT NULL,
  `TIN` varchar(50) DEFAULT NULL,
  `CST` varchar(50) DEFAULT NULL,
  `CreditDays` int(11) DEFAULT NULL,
  `CreditLimit` double DEFAULT NULL,
  `GSTIN` varchar(100) DEFAULT NULL,
  `NoOfDaysForGoodsRcv` int(3) DEFAULT 0,
  `Active` enum('1','0') DEFAULT NULL,
  `DelStatus` int(1) DEFAULT 1,
  `ShortName` text DEFAULT NULL,
  `Password` text DEFAULT NULL,
  `Advance` int(1) DEFAULT 0,
  `WithoutTax` int(1) DEFAULT 0,
  `IsBranch` int(1) DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `SupplierCategory`
--

CREATE TABLE `SupplierCategory` (
  `SupplierCategoryID` int(11) NOT NULL,
  `CompanyID` int(2) NOT NULL,
  `SupplierCategoryName` varchar(45) DEFAULT NULL,
  `ShortName` varchar(20) DEFAULT NULL,
  `AcCtrlCashPurchase` varchar(15) DEFAULT NULL,
  `AcCtrlCreditPurchase` varchar(15) DEFAULT NULL,
  `AcCtrlCashPaid` varchar(15) NOT NULL,
  `AcCtrlCreditPaid` varchar(15) NOT NULL,
  `AcPayable` varchar(15) DEFAULT NULL,
  `Active` enum('1','0') DEFAULT NULL,
  `DelStatus` int(1) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
-- Indexes for table `cs_district`
--
ALTER TABLE `cs_district`
  ADD PRIMARY KEY (`district_id`);

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
-- Indexes for table `cs_payment`
--
ALTER TABLE `cs_payment`
  ADD PRIMARY KEY (`payment_id`);

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
-- Indexes for table `cs_storage_rooms`
--
ALTER TABLE `cs_storage_rooms`
  ADD PRIMARY KEY (`room_id`);

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
-- Indexes for table `cs_warehouse`
--
ALTER TABLE `cs_warehouse`
  ADD PRIMARY KEY (`warehouse_id`);

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
-- Indexes for table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `ProductCategory`
--
ALTER TABLE `ProductCategory`
  ADD PRIMARY KEY (`ProductCategoryID`),
  ADD KEY `ProductDivisionID` (`ProductDivisionID`);

--
-- Indexes for table `ProductMaster`
--
ALTER TABLE `ProductMaster`
  ADD PRIMARY KEY (`ProductMasterID`),
  ADD KEY `BrandID` (`BrandID`),
  ADD KEY `ProductCategoryID` (`ProductCategoryID`),
  ADD KEY `ForClosingStockReport` (`BrandID`,`ProductCategoryID`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `Supplier`
--
ALTER TABLE `Supplier`
  ADD PRIMARY KEY (`SupplierID`);

--
-- Indexes for table `SupplierCategory`
--
ALTER TABLE `SupplierCategory`
  ADD PRIMARY KEY (`SupplierCategoryID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cs_analytical`
--
ALTER TABLE `cs_analytical`
  MODIFY `analytical_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_brand`
--
ALTER TABLE `cs_brand`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_chart_of_account`
--
ALTER TABLE `cs_chart_of_account`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_city`
--
ALTER TABLE `cs_city`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_client`
--
ALTER TABLE `cs_client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_company`
--
ALTER TABLE `cs_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_country`
--
ALTER TABLE `cs_country`
  MODIFY `country_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_district`
--
ALTER TABLE `cs_district`
  MODIFY `district_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_inward`
--
ALTER TABLE `cs_inward`
  MODIFY `inward_id` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `level_1_id` int(2) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_level_2`
--
ALTER TABLE `cs_level_2`
  MODIFY `level_2_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_outward`
--
ALTER TABLE `cs_outward`
  MODIFY `outward_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_outward_detail`
--
ALTER TABLE `cs_outward_detail`
  MODIFY `outward_detail_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_package_type`
--
ALTER TABLE `cs_package_type`
  MODIFY `package_type_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_packing_list`
--
ALTER TABLE `cs_packing_list`
  MODIFY `packing_list_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_packing_list_detail`
--
ALTER TABLE `cs_packing_list_detail`
  MODIFY `packing_list_detail_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_pallets`
--
ALTER TABLE `cs_pallets`
  MODIFY `pallet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_payment`
--
ALTER TABLE `cs_payment`
  MODIFY `payment_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_picklist`
--
ALTER TABLE `cs_picklist`
  MODIFY `picklist_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_picklist_detail`
--
ALTER TABLE `cs_picklist_detail`
  MODIFY `picklist_detail_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_port`
--
ALTER TABLE `cs_port`
  MODIFY `port_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_post_office`
--
ALTER TABLE `cs_post_office`
  MODIFY `post_office_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_prod_cat_svg_img`
--
ALTER TABLE `cs_prod_cat_svg_img`
  MODIFY `prod_cat_svg_img_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_racks`
--
ALTER TABLE `cs_racks`
  MODIFY `rack_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_receipt`
--
ALTER TABLE `cs_receipt`
  MODIFY `receipt_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_slots`
--
ALTER TABLE `cs_slots`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_state`
--
ALTER TABLE `cs_state`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_status_updates`
--
ALTER TABLE `cs_status_updates`
  MODIFY `status_update_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_stock`
--
ALTER TABLE `cs_stock`
  MODIFY `stock_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_storage_rooms`
--
ALTER TABLE `cs_storage_rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_unit`
--
ALTER TABLE `cs_unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_users`
--
ALTER TABLE `cs_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cs_warehouse`
--
ALTER TABLE `cs_warehouse`
  MODIFY `warehouse_id` bigint(20) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Product`
--
ALTER TABLE `Product`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProductCategory`
--
ALTER TABLE `ProductCategory`
  MODIFY `ProductCategoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ProductMaster`
--
ALTER TABLE `ProductMaster`
  MODIFY `ProductMasterID` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Supplier`
--
ALTER TABLE `Supplier`
  MODIFY `SupplierID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `SupplierCategory`
--
ALTER TABLE `SupplierCategory`
  MODIFY `SupplierCategoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD CONSTRAINT `login_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
