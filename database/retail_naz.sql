-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 18, 2020 at 06:58 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `retail`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_messages`
--

CREATE TABLE `admin_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender` varchar(200) DEFAULT NULL,
  `recipient` varchar(200) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `attachment1` text DEFAULT NULL,
  `attachment2` text DEFAULT NULL,
  `attachment3` text DEFAULT NULL,
  `reading_status` tinyint(2) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_ship_methods`
--

CREATE TABLE `admin_ship_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `courier_id` int(11) NOT NULL,
  `fee` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_ship_methods`
--

INSERT INTO `admin_ship_methods` (`id`, `name`, `courier_id`, `fee`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Next Day', 1, 50, '2018-06-01 03:13:50', '2019-10-13 16:57:17', NULL),
(2, 'UPS Ground (3-7 Days)', 1, NULL, '2018-06-01 03:15:23', '2019-09-09 05:56:05', NULL),
(3, 'UPS 2nd Day', 1, NULL, '2018-06-01 03:15:34', '2019-09-09 05:56:47', NULL),
(7, 'UPS 3rd Day', 1, NULL, '2018-07-20 09:44:36', '2019-09-09 05:57:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `age_groups`
--

CREATE TABLE `age_groups` (
  `id` int(11) NOT NULL,
  `lower_limit` int(11) NOT NULL,
  `upper_limit` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `age_groups`
--

INSERT INTO `age_groups` (`id`, `lower_limit`, `upper_limit`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 18, '2020-02-04 15:05:48', '2020-02-04 15:12:43', '2020-02-04 15:12:43'),
(2, 8, 20, '2020-02-04 15:07:53', '2020-02-04 16:05:51', '2020-02-04 16:05:51'),
(3, 8, 14, '2020-02-04 15:13:54', '2020-02-04 16:05:50', '2020-02-04 16:05:50'),
(4, 8, 10, '2020-02-04 15:24:13', '2020-02-04 15:59:50', '2020-02-04 15:59:50'),
(5, 2, 5, '2020-02-04 15:24:56', '2020-02-04 16:05:48', '2020-02-04 16:05:48'),
(6, 18, 24, '2020-02-04 16:06:07', '2020-02-06 13:17:44', NULL),
(7, 25, 35, '2020-02-04 16:21:16', '2020-02-06 13:17:54', NULL),
(8, 35, 44, '2020-02-04 16:21:34', '2020-02-06 13:18:10', NULL),
(9, 45, 55, '2020-02-04 16:21:47', '2020-02-06 13:18:32', NULL),
(10, 55, 60, '2020-02-06 13:19:35', '2020-02-09 19:14:30', NULL),
(11, 80, 100, '2020-02-09 18:41:02', '2020-02-09 18:58:37', '2020-02-09 18:58:37'),
(12, 10, 10, '2020-02-09 18:47:08', '2020-02-09 18:58:29', '2020-02-09 18:58:29'),
(13, 5, 2, '2020-02-09 18:53:25', '2020-02-09 18:58:11', '2020-02-09 18:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lynkto', 1, '2020-02-09 15:43:34', '2020-02-09 15:43:34', NULL),
(2, 'Sony', 1, '2020-02-09 15:46:52', '2020-03-19 13:39:42', '2020-03-19 13:39:42'),
(15, 'Samsung', 0, '2020-02-09 16:32:15', '2020-03-19 13:39:36', '2020-03-19 13:39:36'),
(16, 'Sony', 1, '2020-03-18 07:14:24', '2020-03-19 13:37:54', '2020-03-19 13:37:54'),
(17, 'Sony', 1, '2020-03-19 13:39:48', '2020-03-19 13:39:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `buyer_messages`
--

CREATE TABLE `buyer_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender` varchar(200) NOT NULL,
  `recipient` varchar(200) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `attachment1` text DEFAULT NULL,
  `attachment2` text DEFAULT NULL,
  `attachment3` text DEFAULT NULL,
  `reading_status` tinyint(2) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `buyer_shipping_addresses`
--

CREATE TABLE `buyer_shipping_addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT 0,
  `store_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int(11) DEFAULT NULL,
  `state_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commercial` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `buyer_shipping_addresses`
--

INSERT INTO `buyer_shipping_addresses` (`id`, `user_id`, `default`, `store_no`, `location`, `address`, `unit`, `city`, `state_id`, `state_text`, `zip`, `country_id`, `phone`, `fax`, `commercial`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 10, 0, 'fd', 'US', 'Raj', NULL, 'gsdfgfga', 10, NULL, '5656', 1, '4576767', '4545', 0, '2018-06-14 18:00:00', '2020-05-10 21:06:21', NULL),
(2, 10, 0, 'erwer', 'US', 'mokampur', NULL, 'Khulna', 4, NULL, '34535', 1, '4545', NULL, 0, '2018-06-22 07:18:27', '2020-05-10 21:06:21', NULL),
(7, 10, 1, 'sadfa', 'US', 'asdfa', NULL, 'asdf', 4, NULL, 'asdf', 1, 'rfer', NULL, 0, '2018-06-22 09:49:57', '2020-05-10 21:06:21', NULL),
(91, 10, 0, NULL, 'US', 'asdfa', NULL, 'asdf', 3, NULL, 'asdf', NULL, 'rfer', NULL, 0, '2020-04-24 17:13:17', '2020-05-10 21:06:21', NULL),
(90, 10, 0, NULL, 'US', 'asdfa', NULL, 'asdf', 3, NULL, 'asdf', NULL, 'rfer', NULL, 0, '2020-04-24 17:12:13', '2020-05-10 21:06:21', NULL),
(92, 15, 1, NULL, 'US', 'Mokampur', NULL, 'khulna', 60, NULL, '9220', 1, '1321321', NULL, 0, '2020-04-27 23:01:56', '2020-04-28 00:43:26', '2020-04-28 00:43:26'),
(93, 15, 0, NULL, 'US', 'Mokampur, 12, 12', NULL, 'khulna', 3, NULL, '9220', 1, '234234', NULL, 0, '2020-04-28 00:49:26', '2020-04-28 00:49:35', '2020-04-28 00:49:35'),
(94, 15, 0, NULL, 'US', 'Mokampur, 12, 12', NULL, 'khulna', 4, NULL, '9220', 1, '1321321', NULL, 0, '2020-04-28 01:23:12', '2020-04-28 01:24:11', '2020-04-28 01:24:11'),
(95, 15, 1, NULL, 'US', 'Mokampur, 12, 12', NULL, 'khulna', 4, NULL, '9220', 1, '1321321', NULL, 0, '2020-04-28 01:27:26', '2020-04-28 01:33:58', NULL),
(96, 16, 0, NULL, 'US', 'Mokampur, 12, 12', NULL, 'khulna', 61, NULL, '9220', 1, '1321321', NULL, 0, '2020-04-28 02:26:36', '2020-04-28 02:26:36', NULL),
(97, 27, 1, NULL, 'US', 'Mokampur, 12, 12', NULL, 'khulna', 64, NULL, '897878', 1, '98798798', NULL, 0, '2020-05-03 21:27:12', '2020-05-03 21:27:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `item_id`, `quantity`, `color_id`, `size_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '10', 12, 4, 2, 11, 0, '2020-05-10 19:02:05', '2020-05-10 19:59:48');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent` int(11) NOT NULL DEFAULT 0,
  `sort` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `parent`, `sort`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'Women Dress', 'womendress', 5, 1, NULL, 1, '2020-02-06 18:55:41', '2020-02-06 19:48:41', NULL),
(5, 'Women', 'women', 0, 1, NULL, 1, '2020-01-06 13:08:31', '2020-02-06 19:48:29', NULL),
(9, 'Woman Tops', 'womantops-2', 10, 1, NULL, 1, '2020-02-06 18:55:25', '2020-02-09 14:51:02', '2020-02-09 14:51:02'),
(8, 'Preorder', 'preorder', 0, 2, NULL, 0, '2020-02-06 18:44:35', '2020-02-06 19:06:03', NULL),
(11, 'Pant', 'pant', 10, 1, NULL, 1, '2020-02-09 19:20:18', '2020-03-18 22:11:17', '2020-03-18 22:11:17'),
(12, 'Outware', 'outware', 0, 3, NULL, 1, '2020-02-09 19:46:47', '2020-02-09 19:46:47', NULL),
(13, 'Preorder Dress', 'preorderdress', 8, 1, NULL, 1, '2020-02-10 15:37:29', '2020-02-10 15:37:29', NULL),
(14, 'Tops', 'tops', 5, 0, NULL, NULL, NULL, NULL, NULL),
(15, 'Pants', 'pants', 0, 0, NULL, NULL, NULL, NULL, NULL),
(16, 'Tops', 'tops', 10, 0, NULL, NULL, NULL, NULL, NULL),
(17, 'Pants', 'pants', 5, 0, NULL, NULL, NULL, NULL, NULL),
(18, 'Bags', 'bags', 3, 0, NULL, NULL, NULL, NULL, NULL),
(19, 'Boots', 'boots', 14, 0, NULL, NULL, NULL, NULL, NULL),
(20, 'NO CHIELD', 'nochield', 0, 0, NULL, 0, NULL, '2020-05-10 15:56:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `master_color_id` int(11) DEFAULT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbs_image_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `status`, `master_color_id`, `image_path`, `thumbs_image_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'RED', 1, 1, '/images/colors/23ef1680-4d82-11ea-877c-311169b956ab.png', '/images/colors/thumbs/23ef1680-4d82-11ea-877c-311169b956ab.png', '2019-04-30 02:18:32', '2020-02-12 10:26:33', NULL),
(2, 'GREEN', 1, 4, '/images/colors/f92a8840-6d57-11e9-8c1d-9d3a917391c0.jpg', '/images/colors/thumbs/f92a8840-6d57-11e9-8c1d-9d3a917391c0.jpg', '2019-05-02 22:00:06', '2019-10-16 03:34:57', NULL),
(3, 'Aqua', 1, 2, '/images/colors/bc73fdc0-0767-11ea-a9d2-c912ee648910.jpg', '/images/colors/thumbs/bc73fdc0-0767-11ea-a9d2-c912ee648910.jpg', '2019-05-27 01:40:23', '2019-11-15 05:21:11', NULL),
(4, 'Blue', 1, 3, '/images/colors/32035cf0-0765-11ea-a713-3791a1ced314.png', '/images/colors/thumbs/32035cf0-0765-11ea-a713-3791a1ced314.png', '2019-05-29 22:51:56', '2019-11-15 05:03:00', NULL),
(5, 'Yellow', 1, 11, '/images/colors/b313fea0-0769-11ea-967e-b9b3376787eb.jpg', '/images/colors/thumbs/b313fea0-0769-11ea-967e-b9b3376787eb.jpg', '2019-05-29 22:52:22', '2019-11-15 05:35:14', NULL),
(6, 'Yellow Multi', 1, 11, '/images/colors/bceabbd0-0769-11ea-86e2-cdcbc9ec7d78.jpg', '/images/colors/thumbs/bceabbd0-0769-11ea-86e2-cdcbc9ec7d78.jpg', '2019-05-29 22:52:43', '2019-11-15 05:35:31', NULL),
(7, 'White', 1, 4, '/images/colors/64f6a390-4717-11ea-8794-ebdd2da29b43.png', '/images/colors/thumbs/64f6a390-4717-11ea-8794-ebdd2da29b43.png', '2019-05-29 22:52:54', '2020-02-04 06:27:19', NULL),
(8, 'pink', 1, 7, '/images/colors/d6100fa0-0768-11ea-92c4-75c32fdb9a5b.jpg', '/images/colors/thumbs/d6100fa0-0768-11ea-92c4-75c32fdb9a5b.jpg', '2019-10-14 10:53:16', '2019-11-15 05:29:03', NULL),
(9, 'ORANGE', 1, 1, '/images/colors/c7f41e20-0768-11ea-99e5-c19a2483d7ec.jpg', '/images/colors/thumbs/c7f41e20-0768-11ea-99e5-c19a2483d7ec.jpg', '2019-10-14 10:54:39', '2019-11-15 05:28:40', NULL),
(10, 'BLACK', 1, 3, '/images/colors/3e42e7e0-ef25-11e9-b544-2599e2628c5b.jpg', '/images/colors/thumbs/3e42e7e0-ef25-11e9-b544-2599e2628c5b.jpg', '2019-10-14 10:54:51', '2019-10-16 03:34:46', NULL),
(11, 'Oatmeal', 1, 7, '/images/colors/13c25d00-0768-11ea-b13a-550e108db62c.jpg', '/images/colors/thumbs/13c25d00-0768-11ea-b13a-550e108db62c.jpg', '2019-11-04 08:26:21', '2019-11-15 05:23:37', NULL),
(12, 'Black Multi', 1, 8, '/images/colors/0df95260-0765-11ea-a335-955b0beffc51.png', '/images/colors/thumbs/0df95260-0765-11ea-a335-955b0beffc51.png', '2019-11-04 08:26:21', '2019-11-15 05:01:59', NULL),
(13, 'Multi', 1, 12, '/images/colors/e07700b0-0767-11ea-88be-770a254269bf.jpg', '/images/colors/thumbs/e07700b0-0767-11ea-88be-770a254269bf.jpg', '2019-11-04 10:33:00', '2019-11-15 05:22:11', NULL),
(14, 'Grey', 1, 10, '/images/colors/00be8890-0766-11ea-bb37-bb34b80bec6e.jpg', '/images/colors/thumbs/00be8890-0766-11ea-bb37-bb34b80bec6e.jpg', '2019-11-04 10:34:28', '2019-11-15 05:08:46', NULL),
(15, 'Brown', 1, 9, '/images/colors/7b9b5420-0765-11ea-965f-436dac3a00e8.png', '/images/colors/thumbs/7b9b5420-0765-11ea-965f-436dac3a00e8.png', '2019-11-04 10:34:28', '2019-11-15 05:05:03', NULL),
(16, 'Red/Black', 1, 12, '/images/colors/28caf4c0-0771-11ea-be9b-7361d671bc12.jpg', '/images/colors/thumbs/28caf4c0-0771-11ea-be9b-7361d671bc12.jpg', '2019-11-04 10:34:38', '2019-11-15 06:28:38', NULL),
(17, 'Camel', 1, 9, '/images/colors/ae551e70-0765-11ea-9e51-b3fee7cbde18.png', '/images/colors/thumbs/ae551e70-0765-11ea-9e51-b3fee7cbde18.png', '2019-11-04 10:34:42', '2019-11-15 05:06:28', NULL),
(18, 'Lavender', 1, 5, '/images/colors/1dfb7250-0767-11ea-814f-81aa2ebfeb90.jpg', '/images/colors/thumbs/1dfb7250-0767-11ea-814f-81aa2ebfeb90.jpg', '2019-11-04 10:34:42', '2019-11-15 05:16:45', NULL),
(19, 'Navy', 1, 3, '/images/colors/fb55dda0-0767-11ea-9e31-0311003692ae.jpg', '/images/colors/thumbs/fb55dda0-0767-11ea-9e31-0311003692ae.jpg', '2019-11-04 10:34:45', '2019-11-15 05:22:56', NULL),
(20, 'grey/coral', 1, 12, '/images/colors/39137220-076f-11ea-918a-8f81c586f2c0.jpg', '/images/colors/thumbs/39137220-076f-11ea-918a-8f81c586f2c0.jpg', '2019-11-04 10:34:51', '2019-11-15 06:14:46', NULL),
(21, 'YELLOW/PURPLE', 1, 12, '/images/colors/cfc9e970-0773-11ea-bea4-81652f3c9356.jpg', '/images/colors/thumbs/cfc9e970-0773-11ea-bea4-81652f3c9356.jpg', '2019-11-04 10:34:51', '2019-11-15 06:47:37', NULL),
(22, 'H Grey', 1, 10, '/images/colors/bfab8600-0766-11ea-9645-fdd6b05109d0.jpg', '/images/colors/thumbs/bfab8600-0766-11ea-9645-fdd6b05109d0.jpg', '2019-11-04 10:35:01', '2019-11-15 05:14:07', NULL),
(23, 'Cream', 1, 4, '/images/colors/9cc5b270-0766-11ea-981f-9fba74500c65.jpg', '/images/colors/thumbs/9cc5b270-0766-11ea-981f-9fba74500c65.jpg', '2019-11-04 10:35:01', '2019-11-15 05:13:08', NULL),
(24, 'Tan', 1, 9, '/images/colors/5278a6e0-0769-11ea-a0f5-c198d904ed1e.jpg', '/images/colors/thumbs/5278a6e0-0769-11ea-a0f5-c198d904ed1e.jpg', '2019-11-04 10:35:04', '2019-11-15 05:32:32', NULL),
(25, 'Mustard', 1, 11, '/images/colors/e9625c30-0767-11ea-bc9d-237852e059ae.jpg', '/images/colors/thumbs/e9625c30-0767-11ea-bc9d-237852e059ae.jpg', '2019-11-04 10:35:05', '2019-11-15 05:22:26', NULL),
(26, 'Grey Multi', 1, 10, '/images/colors/06ef8260-0766-11ea-b72e-3dd7ebafca2e.jpg', '/images/colors/thumbs/06ef8260-0766-11ea-b72e-3dd7ebafca2e.jpg', '2019-11-04 10:35:08', '2019-11-15 05:08:57', NULL),
(27, 'Burgundy', 1, 5, '/images/colors/92e052c0-0765-11ea-a755-cbf44c9bf86d.png', '/images/colors/thumbs/92e052c0-0765-11ea-a755-cbf44c9bf86d.png', '2019-11-04 10:35:09', '2019-11-15 05:05:42', NULL),
(28, 'Mustard Multi', 1, 11, '/images/colors/f1d9f1c0-0767-11ea-bf35-81207a087186.jpg', '/images/colors/thumbs/f1d9f1c0-0767-11ea-bf35-81207a087186.jpg', '2019-11-04 10:35:19', '2019-11-15 05:22:40', NULL),
(29, 'RUST MUILTI', 1, 12, '/images/colors/35e3f7e0-0769-11ea-8bbd-3b8f14e4dc5d.jpg', '/images/colors/thumbs/35e3f7e0-0769-11ea-8bbd-3b8f14e4dc5d.jpg', '2019-11-04 10:35:19', '2019-11-15 05:31:44', NULL),
(30, 'Blue/Taupe', 1, 12, '/images/colors/c676f100-076c-11ea-a4e2-b1395114499d.jpg', '/images/colors/thumbs/c676f100-076c-11ea-a4e2-b1395114499d.jpg', '2019-11-04 10:35:26', '2019-11-15 05:57:15', NULL),
(31, 'Ivory', 1, 7, '/images/colors/fac45260-0766-11ea-971e-8148570cca8d.jpg', '/images/colors/thumbs/fac45260-0766-11ea-971e-8148570cca8d.jpg', '2019-11-04 10:35:33', '2019-11-15 05:15:46', NULL),
(32, 'BEIGE/MULTI', 1, 7, '/images/colors/b33535c0-0764-11ea-983c-adf3bc3e3735.png', '/images/colors/thumbs/b33535c0-0764-11ea-983c-adf3bc3e3735.png', '2019-11-04 10:35:39', '2019-11-15 04:59:27', NULL),
(33, 'Taupe', 1, 9, '/images/colors/940f83e0-0769-11ea-996e-d9061a17b7ae.jpg', '/images/colors/thumbs/940f83e0-0769-11ea-996e-d9061a17b7ae.jpg', '2019-11-04 10:35:40', '2019-11-15 05:34:22', NULL),
(34, 'Taupe/Black', 1, 12, '/images/colors/b6bbdf30-0772-11ea-ac93-75ffa707c604.jpg', '/images/colors/thumbs/b6bbdf30-0772-11ea-ac93-75ffa707c604.jpg', '2019-11-04 10:35:58', '2019-11-15 06:39:46', NULL),
(35, 'Olive', 1, 6, '/images/colors/1ba379d0-0768-11ea-bb86-8f1239dd5020.jpg', '/images/colors/thumbs/1ba379d0-0768-11ea-bb86-8f1239dd5020.jpg', '2019-11-04 10:36:08', '2019-11-15 05:23:51', NULL),
(36, 'Tan/Charcoal', 1, 12, '/images/colors/b0ee6920-0771-11ea-a890-1f7cb5ffbad9.jpg', '/images/colors/thumbs/b0ee6920-0771-11ea-a890-1f7cb5ffbad9.jpg', '2019-11-04 10:42:01', '2019-11-15 06:32:26', NULL),
(37, 'Black/White', 1, 12, '/images/colors/d0bc5e00-4d81-11ea-a2e3-9d96bef53046.png', '/images/colors/thumbs/d0bc5e00-4d81-11ea-a2e3-9d96bef53046.png', '2019-11-04 10:42:16', '2020-02-12 10:24:13', NULL),
(38, 'Ivory/Taupe', 1, 12, '/images/colors/c56970e0-076f-11ea-bd9c-2b5b6d02adba.jpg', '/images/colors/thumbs/c56970e0-076f-11ea-bd9c-2b5b6d02adba.jpg', '2019-11-04 10:42:16', '2019-11-15 06:18:42', NULL),
(39, 'Rust', 1, 1, '/images/colors/2b3e0e30-0769-11ea-8729-39e786dc415a.jpg', '/images/colors/thumbs/2b3e0e30-0769-11ea-8729-39e786dc415a.jpg', '2019-11-04 10:42:30', '2019-11-15 05:31:26', NULL),
(40, 'WHIT/NAVY/ TAUPE', 1, 12, '/images/colors/92cca0c0-4d82-11ea-9ead-21d454efdada.jpg', '/images/colors/thumbs/92cca0c0-4d82-11ea-9ead-21d454efdada.jpg', '2019-11-04 10:42:34', '2020-02-12 10:29:39', NULL),
(41, 'WHITE/OLIVE', 1, 12, '/images/colors/14e30480-4d83-11ea-b3da-fb21904c12e9.jpg', '/images/colors/thumbs/14e30480-4d83-11ea-b3da-fb21904c12e9.jpg', '2019-11-04 10:42:40', '2020-02-12 10:33:17', NULL),
(42, 'White/Black', 1, 12, '/images/colors/bbfb0770-4d82-11ea-a9bd-2baf87af544f.jpg', '/images/colors/thumbs/bbfb0770-4d82-11ea-a9bd-2baf87af544f.jpg', '2019-11-04 10:42:40', '2020-02-12 10:30:48', NULL),
(43, 'Navy Multi', 1, 3, '/images/colors/03ea1700-0768-11ea-ae10-6b94a6587036.jpg', '/images/colors/thumbs/03ea1700-0768-11ea-ae10-6b94a6587036.jpg', '2019-11-04 10:42:46', '2019-11-15 05:23:11', NULL),
(44, 'Olive Multi', 1, 6, '/images/colors/26884640-0768-11ea-95ab-9f68b9d50a46.jpg', '/images/colors/thumbs/26884640-0768-11ea-95ab-9f68b9d50a46.jpg', '2019-11-04 10:42:46', '2019-11-15 05:24:09', NULL),
(45, 'Black/Red', 1, 12, '/images/colors/6cba8a40-076b-11ea-80e4-4187d4d7003b.jpg', '/images/colors/thumbs/6cba8a40-076b-11ea-80e4-4187d4d7003b.jpg', '2019-11-04 10:42:51', '2019-11-15 05:47:35', NULL),
(46, 'H Green/Red', 1, 12, '/images/colors/6dafe850-076f-11ea-8d98-bd57a10988aa.jpg', '/images/colors/thumbs/6dafe850-076f-11ea-8d98-bd57a10988aa.jpg', '2019-11-04 10:42:51', '2019-11-15 06:16:15', NULL),
(47, 'Grey/Black', 1, 12, '/images/colors/2ad429c0-076f-11ea-85ae-e1145451c520.jpg', '/images/colors/thumbs/2ad429c0-076f-11ea-85ae-e1145451c520.jpg', '2019-11-04 10:42:54', '2019-11-15 06:14:22', NULL),
(48, 'Gray', 1, 10, '/images/colors/f7119870-0765-11ea-957a-b5eea2febf1b.jpg', '/images/colors/thumbs/f7119870-0765-11ea-957a-b5eea2febf1b.jpg', '2019-11-04 10:42:57', '2019-11-15 05:08:30', NULL),
(49, 'Hunter Green', 1, 6, '/images/colors/e5062050-0766-11ea-abf0-6bb198ca7c8d.jpg', '/images/colors/thumbs/e5062050-0766-11ea-abf0-6bb198ca7c8d.jpg', '2019-11-04 10:42:59', '2019-11-15 05:15:09', NULL),
(50, 'Sienna', 1, 1, '/images/colors/086ce520-0771-11ea-a504-0923ecbce0f4.jpg', '/images/colors/thumbs/086ce520-0771-11ea-a504-0923ecbce0f4.jpg', '2019-11-04 10:43:04', '2019-11-15 06:27:44', NULL),
(51, 'CHARCOAL COMB', 1, 10, '/images/colors/e73e7930-0765-11ea-b84a-8171c900144c.jpg', '/images/colors/thumbs/e73e7930-0765-11ea-b84a-8171c900144c.jpg', '2019-11-04 10:43:06', '2019-11-15 05:08:04', NULL),
(52, 'Mauve/Brown', 1, 12, '/images/colors/1b901670-0770-11ea-97a8-31e29344f5f7.jpg', '/images/colors/thumbs/1b901670-0770-11ea-97a8-31e29344f5f7.jpg', '2019-11-04 10:43:16', '2019-11-15 06:21:06', NULL),
(53, 'Ivory/Black', 1, 12, '/images/colors/b75cd1e0-076f-11ea-a0aa-3f11915e0740.jpg', '/images/colors/thumbs/b75cd1e0-076f-11ea-a0aa-3f11915e0740.jpg', '2019-11-04 10:43:16', '2019-11-15 06:18:18', NULL),
(54, 'BLACK/RED/MUSTARD', 1, 12, '/images/colors/14f8afa0-076c-11ea-97bf-a79bb8ea3921.jpg', '/images/colors/thumbs/14f8afa0-076c-11ea-97bf-a79bb8ea3921.jpg', '2019-11-04 10:43:36', '2019-11-15 05:52:17', NULL),
(55, 'GREEN/RUST/BLUSH', 1, 12, '/images/colors/a3f46160-076e-11ea-80da-9d7adbc4c71f.jpg', '/images/colors/thumbs/a3f46160-076e-11ea-80da-9d7adbc4c71f.jpg', '2019-11-04 10:43:36', '2019-11-15 06:10:36', NULL),
(56, 'Taupe/White', 1, 12, '/images/colors/4105a270-4d82-11ea-bbc1-333520ee4194.jpg', '/images/colors/thumbs/4105a270-4d82-11ea-bbc1-333520ee4194.jpg', '2019-11-04 10:43:53', '2020-02-12 10:27:22', NULL),
(57, 'IVORY/BROWN', 1, 12, '/images/colors/bde89b20-076f-11ea-ab03-c5bc6c1817e3.jpg', '/images/colors/thumbs/bde89b20-076f-11ea-ab03-c5bc6c1817e3.jpg', '2019-11-04 10:44:01', '2019-11-15 06:18:29', NULL),
(58, 'MUSTARD/GREEN', 1, 12, '/images/colors/49824db0-0770-11ea-87fd-4b62467a2784.jpg', '/images/colors/thumbs/49824db0-0770-11ea-87fd-4b62467a2784.jpg', '2019-11-04 10:44:01', '2019-11-15 06:22:23', NULL),
(59, 'TAN/MUSTARD', 1, 12, '/images/colors/ba4adb10-0771-11ea-99a2-57e0e0f7f54e.jpg', '/images/colors/thumbs/ba4adb10-0771-11ea-99a2-57e0e0f7f54e.jpg', '2019-11-04 10:44:09', '2019-11-15 06:32:42', NULL),
(60, 'PURPLE/PINK', 1, 12, '/images/colors/dd580820-0770-11ea-b0a1-33aebfa1b791.jpg', '/images/colors/thumbs/dd580820-0770-11ea-b0a1-33aebfa1b791.jpg', '2019-11-04 10:44:22', '2019-11-15 06:26:31', NULL),
(61, 'White/Burgundy', 1, 12, '/images/colors/350339c0-4d83-11ea-bbe2-abb8ac155d2d.jpg', '/images/colors/thumbs/350339c0-4d83-11ea-bbe2-abb8ac155d2d.jpg', '2019-11-04 10:45:01', '2020-02-12 10:34:11', NULL),
(62, 'White/Pink', 1, 12, '/images/colors/f7947510-4d82-11ea-9516-47659a4239ab.jpg', '/images/colors/thumbs/f7947510-4d82-11ea-9516-47659a4239ab.jpg', '2019-11-04 10:45:01', '2020-02-12 10:32:28', NULL),
(63, 'Mint', 1, 6, '/images/colors/b7e29a90-0767-11ea-8a92-652f19bc9d1b.jpg', '/images/colors/thumbs/b7e29a90-0767-11ea-8a92-652f19bc9d1b.jpg', '2019-11-04 10:45:37', '2019-11-15 05:21:03', NULL),
(64, 'Sage', 1, 6, '/images/colors/480a0ab0-0769-11ea-b9eb-e51ab449eb5a.jpg', '/images/colors/thumbs/480a0ab0-0769-11ea-b9eb-e51ab449eb5a.jpg', '2019-11-04 10:45:55', '2019-11-15 05:32:14', NULL),
(65, 'CREAM/ TAUPE', 1, 12, '/images/colors/e89424c0-076d-11ea-8f12-89071d1394b7.jpg', '/images/colors/thumbs/e89424c0-076d-11ea-8f12-89071d1394b7.jpg', '2019-11-04 10:46:44', '2019-11-15 06:05:22', NULL),
(66, 'Cream Multi', 1, 4, '/images/colors/a361d4c0-0766-11ea-a204-b51cd5768b4a.jpg', '/images/colors/thumbs/a361d4c0-0766-11ea-a204-b51cd5768b4a.jpg', '2019-11-04 10:47:50', '2019-11-15 05:13:19', NULL),
(67, 'Grey/White', 1, 12, '/images/colors/0d3ea420-4d82-11ea-9d2f-e51399e92134.jpg', '/images/colors/thumbs/0d3ea420-4d82-11ea-9d2f-e51399e92134.jpg', '2019-11-04 10:47:57', '2020-02-12 10:25:55', NULL),
(68, 'YELLOW/PINK', 1, 12, '/images/colors/c5d6f5f0-0773-11ea-a334-bb8f2f2b2973.jpg', '/images/colors/thumbs/c5d6f5f0-0773-11ea-a334-bb8f2f2b2973.jpg', '2019-11-04 10:48:38', '2019-11-15 06:47:21', NULL),
(69, 'Taupe Multi', 1, 12, '/images/colors/c94cd940-0769-11ea-b388-8363d33747f1.jpg', '/images/colors/thumbs/c94cd940-0769-11ea-b388-8363d33747f1.jpg', '2019-11-04 10:48:43', '2019-11-15 05:35:51', NULL),
(70, 'Tangerine', 1, 11, '/images/colors/611be400-4d82-11ea-991b-4f1fd103cf4f.png', '/images/colors/thumbs/611be400-4d82-11ea-991b-4f1fd103cf4f.png', '2019-11-04 10:49:16', '2020-02-12 10:28:15', NULL),
(71, 'Tan/Silver', 1, 12, '/images/colors/c3546150-0771-11ea-bb1d-e3b48287eb2a.jpg', '/images/colors/thumbs/c3546150-0771-11ea-bb1d-e3b48287eb2a.jpg', '2019-11-11 09:13:13', '2019-11-15 06:32:57', NULL),
(72, 'Navy/Silver', 1, 12, '/images/colors/8ce88500-0770-11ea-b0a3-4554bdf5db27.jpg', '/images/colors/thumbs/8ce88500-0770-11ea-b0a3-4554bdf5db27.jpg', '2019-11-11 09:13:13', '2019-11-15 06:24:17', NULL),
(73, 'ARMY GREEN', 1, 6, '/images/colors/8a61d580-0764-11ea-a2a8-99ace5b6d509.png', '/images/colors/thumbs/8a61d580-0764-11ea-a2a8-99ace5b6d509.png', '2019-11-11 09:13:24', '2019-11-15 04:58:18', NULL),
(74, 'R CAMEL', 1, 9, '/images/colors/04332910-0769-11ea-95cf-a34981ba6ccc.jpg', '/images/colors/thumbs/04332910-0769-11ea-95cf-a34981ba6ccc.jpg', '2019-11-11 09:13:24', '2019-11-15 05:30:21', NULL),
(75, 'Pink Multi', 1, 7, '/images/colors/e0570930-0768-11ea-8ac8-fded9633641d.jpg', '/images/colors/thumbs/e0570930-0768-11ea-8ac8-fded9633641d.jpg', '2019-11-11 09:14:22', '2019-11-15 05:29:21', NULL),
(76, 'LAVENDER MULTI', 1, 5, '/images/colors/28705e90-0767-11ea-89ff-eb9f61bc4429.jpg', '/images/colors/thumbs/28705e90-0767-11ea-89ff-eb9f61bc4429.jpg', '2019-11-11 09:14:22', '2019-11-15 05:17:02', NULL),
(77, 'Grey/Orange', 1, 12, '/images/colors/40bfa1f0-076f-11ea-bad9-ad8dbb238afb.jpg', '/images/colors/thumbs/40bfa1f0-076f-11ea-bad9-ad8dbb238afb.jpg', '2019-11-11 09:14:56', '2019-11-15 06:14:59', NULL),
(78, 'Blue/White', 1, 12, '/images/colors/dd18dc50-4d81-11ea-b79c-351523d0400f.jpg', '/images/colors/thumbs/dd18dc50-4d81-11ea-b79c-351523d0400f.jpg', '2019-11-11 09:15:18', '2020-02-12 10:24:34', NULL),
(79, 'Taupe/Orange', 1, 12, '/images/colors/cade0c70-0772-11ea-9f47-f70c123cd736.jpg', '/images/colors/thumbs/cade0c70-0772-11ea-9f47-f70c123cd736.jpg', '2019-11-11 09:15:18', '2019-11-15 06:40:19', NULL),
(80, 'HGREY', 1, 10, '/images/colors/ce412c90-0766-11ea-b9fe-0799b72e18aa.jpg', '/images/colors/thumbs/ce412c90-0766-11ea-b9fe-0799b72e18aa.jpg', '2019-11-11 09:16:08', '2019-11-15 05:14:31', NULL),
(81, 'Lemon', 1, 11, '/images/colors/453cb7f0-0767-11ea-9e60-03e6fcfc69c2.jpg', '/images/colors/thumbs/453cb7f0-0767-11ea-9e60-03e6fcfc69c2.jpg', '2019-11-11 09:16:08', '2019-11-15 05:17:51', NULL),
(82, 'Mocha', 1, 9, '/images/colors/c608eb20-0767-11ea-8334-01c496874e40.jpg', '/images/colors/thumbs/c608eb20-0767-11ea-8334-01c496874e40.jpg', '2019-11-11 09:16:46', '2019-11-15 05:21:27', NULL),
(83, 'CREAM/PINK', 1, 12, '/images/colors/fa6bd090-076d-11ea-ab5f-7d7792c105b3.jpg', '/images/colors/thumbs/fa6bd090-076d-11ea-ab5f-7d7792c105b3.jpg', '2019-11-11 09:16:56', '2019-11-15 06:05:52', NULL),
(84, 'GREY/BLACK.', 1, 12, '/images/colors/313872a0-076f-11ea-a522-e1ef7c663456.jpg', '/images/colors/thumbs/313872a0-076f-11ea-a522-e1ef7c663456.jpg', '2019-11-11 09:17:35', '2019-11-15 06:14:33', NULL),
(85, 'Beige', 1, 7, '/images/colors/ababa4b0-0764-11ea-bb6f-7fa5de441076.png', '/images/colors/thumbs/ababa4b0-0764-11ea-bb6f-7fa5de441076.png', '2019-11-11 09:17:46', '2019-11-15 04:59:14', NULL),
(86, 'Oatmeal/Navy', 1, 12, '/images/colors/a9997e50-0770-11ea-96e3-b9d384ad3232.jpg', '/images/colors/thumbs/a9997e50-0770-11ea-96e3-b9d384ad3232.jpg', '2019-11-12 05:39:56', '2019-11-15 06:25:05', NULL),
(87, 'BROWN/BLACK', 1, 12, '/images/colors/274892a0-076d-11ea-a827-952648ffc20c.jpg', '/images/colors/thumbs/274892a0-076d-11ea-a827-952648ffc20c.jpg', '2019-11-12 05:39:56', '2019-11-15 05:59:58', NULL),
(88, 'GRE/WHITE', 1, 12, '/images/colors/ee482940-4d81-11ea-b009-4d2cb6297f42.jpg', '/images/colors/thumbs/ee482940-4d81-11ea-b009-4d2cb6297f42.jpg', '2019-11-12 05:40:48', '2020-02-12 10:25:03', NULL),
(89, 'Rose Smoke', 1, 13, '/images/colors/1f85a3f0-0769-11ea-b990-d3d50e13510c.jpg', '/images/colors/thumbs/1f85a3f0-0769-11ea-b990-d3d50e13510c.jpg', '2019-11-12 05:43:17', '2019-11-15 05:31:07', NULL),
(90, 'Brick', 1, 1, '/images/colors/4b0ad200-0765-11ea-9e05-03e543b6e2be.png', '/images/colors/thumbs/4b0ad200-0765-11ea-9e05-03e543b6e2be.png', '2019-11-12 05:43:27', '2019-11-15 05:03:42', NULL),
(91, 'BURGUNDY/PINK', 1, 12, '/images/colors/5ff2fe20-076d-11ea-bcdb-594fcc0fc08b.jpg', '/images/colors/thumbs/5ff2fe20-076d-11ea-bcdb-594fcc0fc08b.jpg', '2019-11-12 05:43:37', '2019-11-15 06:01:33', NULL),
(92, 'MUSTARD/RUST', 1, 12, '/images/colors/52a142e0-0770-11ea-b3df-95c483ad9fed.jpg', '/images/colors/thumbs/52a142e0-0770-11ea-b3df-95c483ad9fed.jpg', '2019-11-12 05:43:44', '2019-11-15 06:22:39', NULL),
(93, 'MELANGE', 1, 10, '/images/colors/580b2440-0767-11ea-89ee-792040551231.jpg', '/images/colors/thumbs/580b2440-0767-11ea-89ee-792040551231.jpg', '2019-11-12 05:44:04', '2019-11-15 05:18:23', NULL),
(94, 'Coral', 1, 14, '/images/colors/46f64300-4d80-11ea-9b95-cf29f1233133.jpg', '/images/colors/thumbs/46f64300-4d80-11ea-9b95-cf29f1233133.jpg', '2019-11-13 07:34:52', '2020-02-12 10:13:13', NULL),
(95, 'Charcoal', 1, 10, '/images/colors/e02091c0-0765-11ea-b3fd-db85e8ae5bc6.jpg', '/images/colors/thumbs/e02091c0-0765-11ea-b3fd-db85e8ae5bc6.jpg', '2019-11-13 07:36:15', '2019-11-15 05:07:52', NULL),
(96, 'H.GREY', 1, 10, '/images/colors/c74aa9d0-0766-11ea-905e-9196b4dbeb74.jpg', '/images/colors/thumbs/c74aa9d0-0766-11ea-905e-9196b4dbeb74.jpg', '2019-11-13 07:43:47', '2019-11-15 05:14:19', NULL),
(97, 'TAUPE/NAVY', 1, 12, '/images/colors/c08aeab0-0772-11ea-8fbc-cbd99d24c5aa.jpg', '/images/colors/thumbs/c08aeab0-0772-11ea-8fbc-cbd99d24c5aa.jpg', '2019-11-13 07:47:35', '2019-11-15 06:40:02', NULL),
(98, 'Rust/Cream', 1, 12, '/images/colors/49a70400-0771-11ea-8b90-69e41753e0f2.jpg', '/images/colors/thumbs/49a70400-0771-11ea-8b90-69e41753e0f2.jpg', '2019-11-14 07:17:47', '2019-11-15 06:29:33', NULL),
(99, 'Cream/Rust', 1, 12, '/images/colors/0228e690-076e-11ea-a0fa-1348f8e41b7d.jpg', '/images/colors/thumbs/0228e690-076e-11ea-a0fa-1348f8e41b7d.jpg', '2019-11-14 07:17:58', '2019-11-15 06:06:05', NULL),
(100, 'Burgundy Multi', 1, 5, '/images/colors/9a192c00-0765-11ea-8675-258cf9362156.png', '/images/colors/thumbs/9a192c00-0765-11ea-8675-258cf9362156.png', '2019-11-14 07:21:49', '2019-11-15 05:05:54', NULL),
(101, 'Cream/Black', 1, 12, '/images/colors/f3a852d0-076d-11ea-926a-71387eac5b28.jpg', '/images/colors/thumbs/f3a852d0-076d-11ea-926a-71387eac5b28.jpg', '2019-11-14 07:22:00', '2019-11-15 06:05:40', NULL),
(102, 'Navy Combo', 1, 3, '/images/colors/72909100-11aa-11ea-8bba-85d8ec030199.jpg', '/images/colors/thumbs/72909100-11aa-11ea-8bba-85d8ec030199.jpg', '2019-11-15 06:54:11', '2019-11-28 06:43:55', NULL),
(103, 'Green/Taupe', 1, 12, '/images/colors/d463e8b0-11a7-11ea-95d0-132d64d58962.jpg', '/images/colors/thumbs/d463e8b0-11a7-11ea-95d0-132d64d58962.jpg', '2019-11-15 06:54:27', '2019-11-28 06:25:10', NULL),
(104, 'Silver', 1, 10, '/images/colors/950dd610-11aa-11ea-9055-4784d74a0170.jpg', '/images/colors/thumbs/950dd610-11aa-11ea-9055-4784d74a0170.jpg', '2019-11-15 06:56:08', '2019-11-28 06:44:53', NULL),
(105, 'Dusty Pink', 1, 13, '/images/colors/a926d340-11a7-11ea-a6dd-b388c52fb81b.jpg', '/images/colors/thumbs/a926d340-11a7-11ea-a6dd-b388c52fb81b.jpg', '2019-11-15 06:56:08', '2019-11-28 06:23:58', NULL),
(106, 'Taupe/Rust', 1, 12, '/images/colors/b53d0bc0-11aa-11ea-ad60-d9797159b102.jpg', '/images/colors/thumbs/b53d0bc0-11aa-11ea-ad60-d9797159b102.jpg', '2019-11-15 06:57:17', '2019-11-28 06:45:47', NULL),
(107, 'Red Multi', 1, 1, '/images/colors/834844f0-11aa-11ea-88cb-c1706aab4c56.jpg', '/images/colors/thumbs/834844f0-11aa-11ea-88cb-c1706aab4c56.jpg', '2019-11-15 06:58:33', '2019-11-28 06:44:23', NULL),
(108, 'Blush', 1, 13, '/images/colors/00a25b20-11a7-11ea-8ab2-6b8845fe0aa8.jpg', '/images/colors/thumbs/00a25b20-11a7-11ea-8ab2-6b8845fe0aa8.jpg', '2019-11-15 07:01:39', '2019-11-28 06:19:15', NULL),
(109, 'Cream/Grey', 1, 12, '/images/colors/8e55e900-11a7-11ea-89bf-d332c21894ba.jpg', '/images/colors/thumbs/8e55e900-11a7-11ea-89bf-d332c21894ba.jpg', '2019-11-15 07:01:49', '2019-11-28 06:23:13', NULL),
(110, 'Cream/Navy', 1, 12, '/images/colors/30eaadb0-2560-11ea-940f-bf83bfd721fb.jpg', '/images/colors/thumbs/30eaadb0-2560-11ea-940f-bf83bfd721fb.jpg', '2019-12-09 07:34:10', '2019-12-23 08:42:45', NULL),
(111, 'Cream/Burgundy', 1, 12, '/images/colors/252311b0-2560-11ea-88fc-67e1695e8ce8.jpg', '/images/colors/thumbs/252311b0-2560-11ea-88fc-67e1695e8ce8.jpg', '2019-12-09 07:34:10', '2019-12-23 08:42:25', NULL),
(112, 'Peach/Multi', 1, 12, '/images/colors/30ecd710-2561-11ea-8f90-1538d5bf65c8.jpg', '/images/colors/thumbs/30ecd710-2561-11ea-8f90-1538d5bf65c8.jpg', '2019-12-09 07:34:17', '2019-12-23 08:49:55', NULL),
(113, 'Blue/Multi', 1, 12, '/images/colors/b7b0e6d0-255f-11ea-a9fd-4fa5b41aeca2.jpg', '/images/colors/thumbs/b7b0e6d0-255f-11ea-a9fd-4fa5b41aeca2.jpg', '2019-12-09 07:34:17', '2019-12-23 08:39:22', NULL),
(114, 'Blue/Cream', 1, 12, '/images/colors/a9b4df00-255f-11ea-97be-0f1f45577f11.jpg', '/images/colors/thumbs/a9b4df00-255f-11ea-97be-0f1f45577f11.jpg', '2019-12-09 07:35:11', '2019-12-23 08:38:59', NULL),
(115, 'Dark Blue', 1, 3, '/images/colors/3eba8a90-2560-11ea-b2e7-a114bc6163f1.png', '/images/colors/thumbs/3eba8a90-2560-11ea-b2e7-a114bc6163f1.png', '2019-12-09 07:35:13', '2019-12-23 08:43:08', NULL),
(116, 'Royal', 1, 3, '/images/colors/77b4a1f0-2561-11ea-97b9-c1c6ed9a3dcd.png', '/images/colors/thumbs/77b4a1f0-2561-11ea-97b9-c1c6ed9a3dcd.png', '2019-12-09 07:35:25', '2019-12-23 08:51:53', NULL),
(117, 'Navy/Ivory', 1, 12, '/images/colors/f5be75f0-2560-11ea-b0c6-77f7f334ee45.jpg', '/images/colors/thumbs/f5be75f0-2560-11ea-b0c6-77f7f334ee45.jpg', '2019-12-09 07:35:28', '2019-12-23 08:48:15', NULL),
(118, 'Lilac/Cream', 1, 12, '/images/colors/c6ef5610-2560-11ea-83f9-a7192778f4e4.jpg', '/images/colors/thumbs/c6ef5610-2560-11ea-83f9-a7192778f4e4.jpg', '2019-12-09 07:35:54', '2019-12-23 08:46:57', NULL),
(119, 'Ivory/Grey', 1, 12, '/images/colors/abb9c460-2560-11ea-802a-8162a930776d.jpg', '/images/colors/thumbs/abb9c460-2560-11ea-802a-8162a930776d.jpg', '2019-12-09 07:36:06', '2019-12-23 08:46:11', NULL),
(120, 'Red Orange', 1, 1, '/images/colors/65bf1a10-2561-11ea-992a-953782fc7fe8.png', '/images/colors/thumbs/65bf1a10-2561-11ea-992a-953782fc7fe8.png', '2019-12-09 07:36:09', '2019-12-23 08:51:23', NULL),
(121, 'Navy/White', 1, 12, '/images/colors/0661cb50-2561-11ea-a489-c1af00f7d30a.jpg', '/images/colors/thumbs/0661cb50-2561-11ea-a489-c1af00f7d30a.jpg', '2019-12-09 07:36:12', '2019-12-23 08:48:43', NULL),
(122, 'Brick/White', 1, 12, '/images/colors/fc3a3bc0-255f-11ea-a828-87b252c4f31a.jpg', '/images/colors/thumbs/fc3a3bc0-255f-11ea-a828-87b252c4f31a.jpg', '2019-12-09 07:36:15', '2019-12-23 08:41:17', NULL),
(123, 'Dark Navy', 1, 3, '/images/colors/5b4c7e70-2560-11ea-8a76-910ceb700da9.png', '/images/colors/thumbs/5b4c7e70-2560-11ea-8a76-910ceb700da9.png', '2019-12-09 07:36:30', '2019-12-23 08:43:56', NULL),
(124, 'Dusty Cedar', 1, 7, '/images/colors/7daec550-2560-11ea-895e-ab796fbc7cd2.png', '/images/colors/thumbs/7daec550-2560-11ea-895e-ab796fbc7cd2.png', '2019-12-09 07:36:34', '2019-12-23 08:44:54', NULL),
(125, 'Bronze Brown', 1, 9, '/images/colors/0bbd4d60-2560-11ea-bfa5-ef9e86d886d9.jpg', '/images/colors/thumbs/0bbd4d60-2560-11ea-bfa5-ef9e86d886d9.jpg', '2019-12-09 07:36:34', '2019-12-23 08:41:43', NULL),
(126, 'H. Green', 1, 6, '/images/colors/8d613720-2560-11ea-8373-e7660ffecabf.png', '/images/colors/thumbs/8d613720-2560-11ea-8373-e7660ffecabf.png', '2019-12-09 07:36:41', '2019-12-23 08:45:20', NULL),
(127, 'Charcoal/White', 1, 12, '/images/colors/18475be0-2560-11ea-bc3d-b992d2b2fa8c.jpg', '/images/colors/thumbs/18475be0-2560-11ea-bc3d-b992d2b2fa8c.jpg', '2019-12-09 07:36:57', '2019-12-23 08:42:04', NULL),
(128, 'Ivory/Burgundy', 1, 12, '/images/colors/9e3cca70-2560-11ea-9692-53b20363a0d3.jpg', '/images/colors/thumbs/9e3cca70-2560-11ea-9692-53b20363a0d3.jpg', '2019-12-09 07:37:53', '2019-12-23 08:45:49', NULL),
(129, 'Ivory/Navy', 1, 12, '/images/colors/b90b5cc0-2560-11ea-97ac-c93cce8c38da.jpg', '/images/colors/thumbs/b90b5cc0-2560-11ea-97ac-c93cce8c38da.jpg', '2019-12-09 07:37:53', '2019-12-23 08:46:34', NULL),
(130, 'Off white', 1, 4, '/images/colors/165eea90-2561-11ea-9187-171334d5b930.png', '/images/colors/thumbs/165eea90-2561-11ea-9187-171334d5b930.png', '2019-12-09 07:38:00', '2019-12-23 08:49:10', NULL),
(131, 'ORCHID', 1, 5, '/images/colors/67d7f940-4716-11ea-8f74-3333566ec6b0.png', '/images/colors/thumbs/67d7f940-4716-11ea-8f74-3333566ec6b0.png', '2020-01-27 03:47:06', '2020-02-04 06:20:14', NULL),
(132, 'Blush/Peach', 1, 7, '/images/colors/555e6c80-4714-11ea-9614-bfa978226e90.jpg', '/images/colors/thumbs/555e6c80-4714-11ea-9614-bfa978226e90.jpg', '2020-01-27 03:48:57', '2020-02-04 06:05:24', NULL),
(133, 'Black/Silver', 1, 12, '/images/colors/dc3d6660-4713-11ea-b23d-936d7a554b1e.jpg', '/images/colors/thumbs/dc3d6660-4713-11ea-b23d-936d7a554b1e.jpg', '2020-01-27 04:42:45', '2020-02-04 06:02:01', NULL),
(134, 'White/Navy', 1, 12, '/images/colors/71374b00-4717-11ea-b076-4b3d5594f6d6.jpg', '/images/colors/thumbs/71374b00-4717-11ea-b076-4b3d5594f6d6.jpg', '2020-01-27 04:42:55', '2020-02-04 06:27:39', NULL),
(135, 'CAMEL/WHITE', 1, 9, '/images/colors/94a925f0-4714-11ea-9de3-41261aff88ae.jpg', '/images/colors/thumbs/94a925f0-4714-11ea-9de3-41261aff88ae.jpg', '2020-01-27 04:42:55', '2020-02-04 06:07:10', NULL),
(136, 'Mauve/White', 1, 12, '/images/colors/8fe52a40-4715-11ea-8dae-ef7c83ffaef0.jpg', '/images/colors/thumbs/8fe52a40-4715-11ea-8dae-ef7c83ffaef0.jpg', '2020-01-27 04:43:06', '2020-02-04 06:14:12', NULL),
(137, 'Blue/Navy', 1, 3, '/images/colors/354c19d0-4714-11ea-966f-f5995cc67124.jpg', '/images/colors/thumbs/354c19d0-4714-11ea-966f-f5995cc67124.jpg', '2020-01-27 04:43:16', '2020-02-04 06:04:30', NULL),
(138, 'NAVY/TAUPE', 1, 12, '/images/colors/dbee0870-4715-11ea-9cd4-e136d2cb5b54.jpg', '/images/colors/thumbs/dbee0870-4715-11ea-9cd4-e136d2cb5b54.jpg', '2020-01-27 04:43:21', '2020-02-04 06:16:19', NULL),
(139, 'Dusty Rose', 1, 13, '/images/colors/3171bcc0-4715-11ea-82ff-87e609b7fc0f.png', '/images/colors/thumbs/3171bcc0-4715-11ea-82ff-87e609b7fc0f.png', '2020-01-27 04:43:31', '2020-02-04 06:11:33', NULL),
(140, 'Coral/Taupe', 1, 12, '/images/colors/b2f12ee0-4714-11ea-96b0-c15d4b42077d.jpg', '/images/colors/thumbs/b2f12ee0-4714-11ea-96b0-c15d4b42077d.jpg', '2020-01-27 04:43:49', '2020-02-04 06:08:01', NULL),
(141, 'Green Multi', 1, 6, '/images/colors/54528620-4715-11ea-b787-1bbf1270b6cb.jpg', '/images/colors/thumbs/54528620-4715-11ea-b787-1bbf1270b6cb.jpg', '2020-01-27 04:44:39', '2020-02-04 06:12:32', NULL),
(142, 'Mustard/White', 1, 11, '/images/colors/b1653280-4715-11ea-95b8-ade60029ff3b.jpg', '/images/colors/thumbs/b1653280-4715-11ea-95b8-ade60029ff3b.jpg', '2020-01-27 04:45:54', '2020-02-04 06:15:08', NULL),
(143, 'Yellow/White', 1, 11, '/images/colors/7cd666e0-4717-11ea-92bd-73f4b7b40439.jpg', '/images/colors/thumbs/7cd666e0-4717-11ea-92bd-73f4b7b40439.jpg', '2020-01-27 04:46:04', '2020-02-04 06:27:59', NULL),
(144, 'Camel Combo', 1, 9, '/images/colors/6b5d7740-4714-11ea-b858-bd0a223022c3.jpg', '/images/colors/thumbs/6b5d7740-4714-11ea-b858-bd0a223022c3.jpg', '2020-01-27 04:46:20', '2020-02-04 06:06:01', NULL),
(145, 'Rustic Brown', 1, 9, '/images/colors/47fb86b0-4716-11ea-921d-ed335946a473.jpg', '/images/colors/thumbs/47fb86b0-4716-11ea-921d-ed335946a473.jpg', '2020-01-27 04:46:40', '2020-02-04 06:19:21', NULL),
(146, 'Blue Multi', 1, 3, '/images/colors/e58ffcb0-4713-11ea-b016-35a966705b34.jpg', '/images/colors/thumbs/e58ffcb0-4713-11ea-b016-35a966705b34.jpg', '2020-01-27 04:46:51', '2020-02-04 06:02:16', NULL),
(147, 'JADE', 1, 6, '/images/colors/60e5e3d0-4715-11ea-807f-a5c5af4fb2ec.jpg', '/images/colors/thumbs/60e5e3d0-4715-11ea-807f-a5c5af4fb2ec.jpg', '2020-01-27 04:47:10', '2020-02-04 06:12:53', NULL),
(148, 'Orange Red', 1, 1, '/images/colors/389345b0-4716-11ea-8516-51e2120811b4.jpg', '/images/colors/thumbs/389345b0-4716-11ea-8516-51e2120811b4.jpg', '2020-01-27 04:47:10', '2020-02-04 06:18:55', NULL),
(149, 'Seafoam/Orange', 1, 12, '/images/colors/45c9ef00-4717-11ea-a80f-8ffda0155084.jpg', '/images/colors/thumbs/45c9ef00-4717-11ea-a80f-8ffda0155084.jpg', '2020-01-27 04:47:20', '2020-02-04 06:26:26', NULL),
(150, 'Blue/Black', 1, 12, '/images/colors/0a7ba1c0-4714-11ea-a605-a3f8815a4617.jpg', '/images/colors/thumbs/0a7ba1c0-4714-11ea-a605-a3f8815a4617.jpg', '2020-01-28 07:22:03', '2020-02-04 06:03:18', NULL),
(151, 'Denim Blue', 1, 3, '/images/colors/24965db0-4715-11ea-81bb-5750941daa8a.jpg', '/images/colors/thumbs/24965db0-4715-11ea-81bb-5750941daa8a.jpg', '2020-01-28 07:23:25', '2020-02-04 06:11:12', NULL),
(152, 'Natural', 1, 7, '/images/colors/eba664a0-4715-11ea-a822-21304c57d8d9.jpg', '/images/colors/thumbs/eba664a0-4715-11ea-a822-21304c57d8d9.jpg', '2020-01-28 07:23:40', '2020-02-04 06:16:46', NULL),
(153, 'Khaki', 1, 9, '/images/colors/6b399ee0-4715-11ea-b1b7-9ffa2fd823db.jpg', '/images/colors/thumbs/6b399ee0-4715-11ea-b1b7-9ffa2fd823db.jpg', '2020-01-28 07:24:46', '2020-02-04 06:13:10', NULL),
(154, 'Black/Cream', 1, 12, '/images/colors/cff36690-4713-11ea-9ad7-21251b2ef612.jpg', '/images/colors/thumbs/cff36690-4713-11ea-9ad7-21251b2ef612.jpg', '2020-01-28 07:25:26', '2020-02-04 06:01:40', NULL),
(155, 'Tan/Black', 1, 12, '/images/colors/55497ea0-4717-11ea-9897-2349a2eb2d8c.jpg', '/images/colors/thumbs/55497ea0-4717-11ea-9897-2349a2eb2d8c.jpg', '2020-01-28 07:26:18', '2020-02-04 06:26:52', NULL),
(156, 'PEACH MULTI', 1, NULL, NULL, NULL, '2020-02-14 03:58:55', '2020-02-14 03:58:55', NULL),
(157, 'Neon Green', 1, NULL, NULL, NULL, '2020-02-14 03:59:18', '2020-02-14 03:59:18', NULL),
(158, 'Ivory/Olive', 1, NULL, NULL, NULL, '2020-02-14 03:59:43', '2020-02-14 03:59:43', NULL),
(159, 'Natural/Black', 1, NULL, NULL, NULL, '2020-02-14 04:00:22', '2020-02-14 04:00:22', NULL),
(160, 'Sky Blue', 1, NULL, NULL, NULL, '2020-02-14 06:46:34', '2020-02-14 06:46:34', NULL),
(161, 'RAINBOW', 1, NULL, NULL, NULL, '2020-02-14 06:47:20', '2020-02-14 06:47:20', NULL),
(162, 'Orange Multi', 1, NULL, NULL, NULL, '2020-02-14 06:48:14', '2020-02-14 06:48:14', NULL),
(163, 'TAUPE MULIT', 1, NULL, NULL, NULL, '2020-02-18 04:31:14', '2020-02-18 04:31:14', NULL),
(164, 'BLUE/GREEN', 1, NULL, NULL, NULL, '2020-02-18 04:52:11', '2020-02-18 04:52:11', NULL),
(165, 'Black/Rust', 1, NULL, NULL, NULL, '2020-02-18 04:56:28', '2020-02-18 04:56:28', NULL),
(166, 'ALMOND', 1, 2, '/images/colors/78664d00-5a51-11ea-9a02-7f1d69785b15.jpg', '/images/colors/thumbs/78664d00-5a51-11ea-9a02-7f1d69785b15.jpg', '2020-02-28 17:40:54', '2020-02-28 17:41:39', '2020-02-28 17:41:39'),
(167, 'Dusty Mauve', 1, 13, NULL, NULL, '2020-03-05 06:27:03', '2020-03-05 06:27:03', NULL),
(168, 'Light Denim', 1, 3, NULL, NULL, '2020-03-05 07:37:59', '2020-03-05 07:37:59', NULL),
(169, 'LAVENDER', 1, 5, '/images/colors/d1a2e8d0-5ec8-11ea-8a9c-657bdf53f4e7.png', '/images/colors/thumbs/d1a2e8d0-5ec8-11ea-8a9c-657bdf53f4e7.png', '2020-03-05 10:05:19', '2020-03-05 10:05:19', NULL),
(170, 'xxxx', 1, 2, NULL, NULL, '2020-03-11 05:57:02', '2020-03-11 05:58:14', '2020-03-11 05:58:14');

-- --------------------------------------------------------

--
-- Table structure for table `colorsize`
--

CREATE TABLE `colorsize` (
  `id` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `colorid` int(11) NOT NULL,
  `sizeid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `color_item`
--

CREATE TABLE `color_item` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `color_item`
--

INSERT INTO `color_item` (`id`, `item_id`, `color_id`, `available`) VALUES
(1, 7, 1, 1),
(2, 7, 2, 1),
(3, 7, 5, 1),
(4, 7, 7, 1),
(5, 7, 9, 1),
(6, 10, 21, 1),
(7, 10, 12, 1),
(8, 10, 3, 1),
(9, 10, 4, 1),
(16, 8, 11, 1),
(17, 8, 12, 1),
(18, 8, 32, 1),
(19, 8, 16, 1),
(20, 8, 22, 1),
(25, 12, 11, 1),
(26, 12, 12, 1),
(27, 12, 32, 1),
(28, 12, 16, 1),
(29, 2, 5, 1),
(30, 2, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`) VALUES
(1, 'US', 'United States'),
(2, 'CA', 'Canada'),
(3, 'AF', 'Afghanistan'),
(4, 'AL', 'Albania'),
(5, 'DZ', 'Algeria'),
(6, 'AS', 'American Samoa'),
(7, 'AD', 'Andorra'),
(8, 'AO', 'Angola'),
(9, 'AI', 'Anguilla'),
(10, 'AQ', 'Antarctica'),
(11, 'AG', 'Antigua and/or Barbuda'),
(12, 'AR', 'Argentina'),
(13, 'AM', 'Armenia'),
(14, 'AW', 'Aruba'),
(15, 'AU', 'Australia'),
(16, 'AT', 'Austria'),
(17, 'AZ', 'Azerbaijan'),
(18, 'BS', 'Bahamas'),
(19, 'BH', 'Bahrain'),
(20, 'BD', 'Bangladesh'),
(21, 'BB', 'Barbados'),
(22, 'BY', 'Belarus'),
(23, 'BE', 'Belgium'),
(24, 'BZ', 'Belize'),
(25, 'BJ', 'Benin'),
(26, 'BM', 'Bermuda'),
(27, 'BT', 'Bhutan'),
(28, 'BO', 'Bolivia'),
(29, 'BA', 'Bosnia and Herzegovina'),
(30, 'BW', 'Botswana'),
(31, 'BV', 'Bouvet Island'),
(32, 'BR', 'Brazil'),
(33, 'IO', 'British lndian Ocean Territory'),
(34, 'BN', 'Brunei Darussalam'),
(35, 'BG', 'Bulgaria'),
(36, 'BF', 'Burkina Faso'),
(37, 'BI', 'Burundi'),
(38, 'KH', 'Cambodia'),
(39, 'CM', 'Cameroon'),
(40, 'CV', 'Cape Verde'),
(41, 'KY', 'Cayman Islands'),
(42, 'CF', 'Central African Republic'),
(43, 'TD', 'Chad'),
(44, 'CL', 'Chile'),
(45, 'CN', 'China'),
(46, 'CX', 'Christmas Island'),
(47, 'CC', 'Cocos (Keeling) Islands'),
(48, 'CO', 'Colombia'),
(49, 'KM', 'Comoros'),
(50, 'CG', 'Congo'),
(51, 'CK', 'Cook Islands'),
(52, 'CR', 'Costa Rica'),
(53, 'HR', 'Croatia (Hrvatska)'),
(54, 'CU', 'Cuba'),
(55, 'CY', 'Cyprus'),
(56, 'CZ', 'Czech Republic'),
(57, 'CD', 'Democratic Republic of Congo'),
(58, 'DK', 'Denmark'),
(59, 'DJ', 'Djibouti'),
(60, 'DM', 'Dominica'),
(61, 'DO', 'Dominican Republic'),
(62, 'TP', 'East Timor'),
(63, 'EC', 'Ecudaor'),
(64, 'EG', 'Egypt'),
(65, 'SV', 'El Salvador'),
(66, 'GQ', 'Equatorial Guinea'),
(67, 'ER', 'Eritrea'),
(68, 'EE', 'Estonia'),
(69, 'ET', 'Ethiopia'),
(70, 'FK', 'Falkland Islands (Malvinas)'),
(71, 'FO', 'Faroe Islands'),
(72, 'FJ', 'Fiji'),
(73, 'FI', 'Finland'),
(74, 'FR', 'France'),
(75, 'FX', 'France, Metropolitan'),
(76, 'GF', 'French Guiana'),
(77, 'PF', 'French Polynesia'),
(78, 'TF', 'French Southern Territories'),
(79, 'GA', 'Gabon'),
(80, 'GM', 'Gambia'),
(81, 'GE', 'Georgia'),
(82, 'DE', 'Germany'),
(83, 'GH', 'Ghana'),
(84, 'GI', 'Gibraltar'),
(85, 'GR', 'Greece'),
(86, 'GL', 'Greenland'),
(87, 'GD', 'Grenada'),
(88, 'GP', 'Guadeloupe'),
(89, 'GU', 'Guam'),
(90, 'GT', 'Guatemala'),
(91, 'GN', 'Guinea'),
(92, 'GW', 'Guinea-Bissau'),
(93, 'GY', 'Guyana'),
(94, 'HT', 'Haiti'),
(95, 'HM', 'Heard and Mc Donald Islands'),
(96, 'HN', 'Honduras'),
(97, 'HK', 'Hong Kong'),
(98, 'HU', 'Hungary'),
(99, 'IS', 'Iceland'),
(100, 'IN', 'India'),
(101, 'ID', 'Indonesia'),
(102, 'IR', 'Iran (Islamic Republic of)'),
(103, 'IQ', 'Iraq'),
(104, 'IE', 'Ireland'),
(105, 'IL', 'Israel'),
(106, 'IT', 'Italy'),
(107, 'CI', 'Ivory Coast'),
(108, 'JM', 'Jamaica'),
(109, 'JP', 'Japan'),
(110, 'JO', 'Jordan'),
(111, 'KZ', 'Kazakhstan'),
(112, 'KE', 'Kenya'),
(113, 'KI', 'Kiribati'),
(114, 'KP', 'Korea, Democratic People\'s Republic of'),
(115, 'KR', 'Korea, Republic of'),
(116, 'KW', 'Kuwait'),
(117, 'KG', 'Kyrgyzstan'),
(118, 'LA', 'Lao People\'s Democratic Republic'),
(119, 'LV', 'Latvia'),
(120, 'LB', 'Lebanon'),
(121, 'LS', 'Lesotho'),
(122, 'LR', 'Liberia'),
(123, 'LY', 'Libyan Arab Jamahiriya'),
(124, 'LI', 'Liechtenstein'),
(125, 'LT', 'Lithuania'),
(126, 'LU', 'Luxembourg'),
(127, 'MO', 'Macau'),
(128, 'MK', 'Macedonia'),
(129, 'MG', 'Madagascar'),
(130, 'MW', 'Malawi'),
(131, 'MY', 'Malaysia'),
(132, 'MV', 'Maldives'),
(133, 'ML', 'Mali'),
(134, 'MT', 'Malta'),
(135, 'MH', 'Marshall Islands'),
(136, 'MQ', 'Martinique'),
(137, 'MR', 'Mauritania'),
(138, 'MU', 'Mauritius'),
(139, 'TY', 'Mayotte'),
(140, 'MX', 'Mexico'),
(141, 'FM', 'Micronesia, Federated States of'),
(142, 'MD', 'Moldova, Republic of'),
(143, 'MC', 'Monaco'),
(144, 'MN', 'Mongolia'),
(145, 'MS', 'Montserrat'),
(146, 'MA', 'Morocco'),
(147, 'MZ', 'Mozambique'),
(148, 'MM', 'Myanmar'),
(149, 'NA', 'Namibia'),
(150, 'NR', 'Nauru'),
(151, 'NP', 'Nepal'),
(152, 'NL', 'Netherlands'),
(153, 'AN', 'Netherlands Antilles'),
(154, 'NC', 'New Caledonia'),
(155, 'NZ', 'New Zealand'),
(156, 'NI', 'Nicaragua'),
(157, 'NE', 'Niger'),
(158, 'NG', 'Nigeria'),
(159, 'NU', 'Niue'),
(160, 'NF', 'Norfork Island'),
(161, 'MP', 'Northern Mariana Islands'),
(162, 'NO', 'Norway'),
(163, 'OM', 'Oman'),
(164, 'PK', 'Pakistan'),
(165, 'PW', 'Palau'),
(166, 'PA', 'Panama'),
(167, 'PG', 'Papua New Guinea'),
(168, 'PY', 'Paraguay'),
(169, 'PE', 'Peru'),
(170, 'PH', 'Philippines'),
(171, 'PN', 'Pitcairn'),
(172, 'PL', 'Poland'),
(173, 'PT', 'Portugal'),
(174, 'PR', 'Puerto Rico'),
(175, 'QA', 'Qatar'),
(176, 'SS', 'Republic of South Sudan'),
(177, 'RE', 'Reunion'),
(178, 'RO', 'Romania'),
(179, 'RU', 'Russian Federation'),
(180, 'RW', 'Rwanda'),
(181, 'KN', 'Saint Kitts and Nevis'),
(182, 'LC', 'Saint Lucia'),
(183, 'VC', 'Saint Vincent and the Grenadines'),
(184, 'WS', 'Samoa'),
(185, 'SM', 'San Marino'),
(186, 'ST', 'Sao Tome and Principe'),
(187, 'SA', 'Saudi Arabia'),
(188, 'SN', 'Senegal'),
(189, 'RS', 'Serbia'),
(190, 'SC', 'Seychelles'),
(191, 'SL', 'Sierra Leone'),
(192, 'SG', 'Singapore'),
(193, 'SK', 'Slovakia'),
(194, 'SI', 'Slovenia'),
(195, 'SB', 'Solomon Islands'),
(196, 'SO', 'Somalia'),
(197, 'ZA', 'South Africa'),
(198, 'GS', 'South Georgia South Sandwich Islands'),
(199, 'ES', 'Spain'),
(200, 'LK', 'Sri Lanka'),
(201, 'SH', 'St. Helena'),
(202, 'PM', 'St. Pierre and Miquelon'),
(203, 'SD', 'Sudan'),
(204, 'SR', 'Suriname'),
(205, 'SJ', 'Svalbarn and Jan Mayen Islands'),
(206, 'SZ', 'Swaziland'),
(207, 'SE', 'Sweden'),
(208, 'CH', 'Switzerland'),
(209, 'SY', 'Syrian Arab Republic'),
(210, 'TW', 'Taiwan'),
(211, 'TJ', 'Tajikistan'),
(212, 'TZ', 'Tanzania, United Republic of'),
(213, 'TH', 'Thailand'),
(214, 'TG', 'Togo'),
(215, 'TK', 'Tokelau'),
(216, 'TO', 'Tonga'),
(217, 'TT', 'Trinidad and Tobago'),
(218, 'TN', 'Tunisia'),
(219, 'TR', 'Turkey'),
(220, 'TM', 'Turkmenistan'),
(221, 'TC', 'Turks and Caicos Islands'),
(222, 'TV', 'Tuvalu'),
(223, 'UG', 'Uganda'),
(224, 'UA', 'Ukraine'),
(225, 'AE', 'United Arab Emirates'),
(226, 'GB', 'United Kingdom'),
(227, 'UM', 'United States minor outlying islands'),
(228, 'UY', 'Uruguay'),
(229, 'UZ', 'Uzbekistan'),
(230, 'VU', 'Vanuatu'),
(231, 'VA', 'Vatican City State'),
(232, 'VE', 'Venezuela'),
(233, 'VN', 'Vietnam'),
(234, 'VG', 'Virgin Islands (British)'),
(235, 'VI', 'Virgin Islands (U.S.)'),
(236, 'WF', 'Wallis and Futuna Islands'),
(237, 'EH', 'Western Sahara'),
(238, 'YE', 'Yemen'),
(239, 'YU', 'Yugoslavia'),
(240, 'ZR', 'Zaire'),
(241, 'ZM', 'Zambia'),
(242, 'ZW', 'Zimbabwe');

-- --------------------------------------------------------

--
-- Table structure for table `couriers`
--

CREATE TABLE `couriers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `couriers`
--

INSERT INTO `couriers` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'UPS', '2018-05-31 13:43:21', '2020-03-09 19:49:49', NULL),
(6, 'Fedex', '2019-11-12 20:16:00', '2019-11-12 20:16:00', NULL),
(8, 'sean won', '2020-03-30 16:55:28', '2020-03-30 16:56:40', '2020-03-30 16:56:40');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `style_no` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `price` double(8,2) NOT NULL,
  `orig_price` double(8,2) DEFAULT NULL,
  `sorting` int(11) DEFAULT NULL,
  `details` longtext DEFAULT NULL,
  `video` varchar(100) DEFAULT NULL,
  `youtube_url` varchar(150) DEFAULT NULL,
  `specification` int(5) DEFAULT NULL,
  `available_on` date DEFAULT NULL,
  `availability` int(11) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `made_in_id` int(11) DEFAULT NULL,
  `labeled` varchar(100) DEFAULT NULL,
  `memo` varchar(100) DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `total_in_cart` int(11) DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `total_order_qty` int(11) DEFAULT NULL,
  `v_created_at` timestamp NULL DEFAULT NULL,
  `c_created_at` timestamp NULL DEFAULT NULL,
  `o_created_at` timestamp NULL DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `status`, `style_no`, `name`, `slug`, `price`, `orig_price`, `sorting`, `details`, `video`, `youtube_url`, `specification`, `available_on`, `availability`, `stock_quantity`, `brand_id`, `made_in_id`, `labeled`, `memo`, `view`, `total_in_cart`, `total_amount`, `total_order_qty`, `v_created_at`, `c_created_at`, `o_created_at`, `activated_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 1, 'test_lynkto', 'New Pant', 'test1-test_lynkto', 13.75, 15.00, 5, 'test', NULL, 'dfdfdfdf', NULL, NULL, NULL, NULL, 1, 6, 'labeled', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-18 17:13:48', '2020-03-18 17:10:46', '2020-03-19 15:19:08', NULL),
(7, 1, 'test_lynkto.34', 'summer T-shirt', '-test_lynkto', 54.76, 15.00, NULL, 'test', NULL, 'dfdfdfdf', NULL, NULL, NULL, NULL, 1, 6, 'labeled', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-18 22:43:50', '2020-03-18 22:43:50', '2020-03-29 18:05:22', NULL),
(8, 1, 'test_lynkto-Clone.', 'shirt', '-test_lynkto-clone-1', 12.70, 15.00, 2, 'test', NULL, 'dfdfdfdf', NULL, NULL, NULL, NULL, 1, 6, 'labeled', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-18 22:43:50', '2020-03-18 22:43:50', '2020-03-29 14:59:06', NULL),
(9, 1, 'test_lynkto1.', 'Hoodi', '-test_lynkto1', 15.00, 15.00, 3, '<p>Product description from html tags</p>', NULL, 'dfdfdfdf', 3, NULL, NULL, NULL, 1, 6, 'labeled', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-18 22:43:50', '2020-03-18 22:43:50', '2020-04-28 21:49:27', NULL),
(10, 1, 'test_lynkto-Clone..', 'test1', '-test_lynkto-clone.', 130.00, 15.00, 4, 'test', NULL, 'dfdfdfdf', NULL, NULL, NULL, NULL, 1, 6, 'labeled', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-18 22:43:50', '2020-03-18 22:43:50', '2020-03-19 15:19:08', NULL),
(11, 1, 'test_lynkto..', 'test1', '-test_lynkto.', 45.70, 15.00, 1, 'test', NULL, 'dfdfdfdf', NULL, NULL, NULL, NULL, 1, 6, 'labeled', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-19 14:05:01', '2020-03-19 14:05:01', '2020-03-29 14:59:04', NULL),
(12, 1, 'test_lynkto55', 'test1', '-test_lynkto.-1', 826.76, 154.00, NULL, '<ul><li>Soft Burshes provide an incredble thouch and feel.</li><li style=\"\r\n    font-size: 10px;\r\n\">Perfect for liquids, powders or creams to produce a beautiful face and eye makeup application.</li><li>Made of high quality wood and nylon material which offering a sense of luxury.</li><li>Portable and convenient to use and carry.</li></ul>', NULL, 'dfdfdfdf', NULL, NULL, NULL, NULL, 1, 6, 'labeled', 'test', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-03-19 14:05:01', '2020-03-19 14:05:26', '2020-03-29 18:05:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `default_parent_category` int(11) NOT NULL,
  `default_second_category` int(11) DEFAULT NULL,
  `default_third_category` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `item_id`, `default_parent_category`, `default_second_category`, `default_third_category`, `created_at`, `updated_at`, `deleted_at`) VALUES
(30, 2, 5, 14, 19, '2020-03-18 22:10:27', '2020-03-18 22:10:27', NULL),
(36, 7, 20, NULL, NULL, '2020-03-18 22:43:50', '2020-03-19 14:05:37', NULL),
(40, 10, 15, NULL, NULL, '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(42, 12, 20, NULL, NULL, '2020-03-19 14:05:26', '2020-03-19 14:05:26', NULL),
(43, 8, 20, NULL, NULL, '2020-03-19 15:18:57', '2020-03-19 15:18:57', NULL),
(44, 11, 20, NULL, NULL, '2020-03-30 18:08:38', '2020-03-30 18:08:38', NULL),
(45, 9, 8, NULL, NULL, '2020-04-28 21:49:27', '2020-04-28 21:49:27', NULL),
(46, 9, 8, NULL, NULL, '2020-04-28 21:49:28', '2020-04-28 21:49:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_images`
--

CREATE TABLE `item_images` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `color_id` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `image_path` varchar(100) DEFAULT NULL,
  `compressed_image_path` varchar(100) DEFAULT NULL,
  `thumbs_image_path` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_images`
--

INSERT INTO `item_images` (`id`, `item_id`, `color_id`, `sort`, `image_path`, `compressed_image_path`, `thumbs_image_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(18, 2, NULL, 1, 'images/item/original/3d317ef0-69d2-11ea-8753-1992554d22c6.jpg', 'images/item/compressed/3d317ef0-69d2-11ea-8753-1992554d22c6.jpg', 'images/item/thumbs/3d317ef0-69d2-11ea-8753-1992554d22c6.jpg', '2020-03-18 17:10:31', '2020-03-18 22:10:27', NULL),
(20, 2, NULL, 2, 'images/item/original/3d349c40-69d2-11ea-a9b3-e3a799287741.jpg', 'images/item/compressed/3d349c40-69d2-11ea-a9b3-e3a799287741.jpg', 'images/item/thumbs/3d349c40-69d2-11ea-a9b3-e3a799287741.jpg', '2020-03-18 17:10:31', '2020-03-18 22:10:27', NULL),
(21, 2, NULL, 3, 'images/item/original/3d3d7380-69d2-11ea-b2db-ed8db73f2c70.jpg', 'images/item/compressed/3d3d7380-69d2-11ea-b2db-ed8db73f2c70.jpg', 'images/item/thumbs/3d3d7380-69d2-11ea-b2db-ed8db73f2c70.jpg', '2020-03-18 17:10:31', '2020-03-18 22:10:28', NULL),
(34, 7, NULL, 1, 'images/item/original/81b8ad80-627a-11ea-93d6-f5bdcdf32448.jpg', 'images/item/compressed/81b8ad80-627a-11ea-93d6-f5bdcdf32448.jpg', 'images/item/thumbs/81b8ad80-627a-11ea-93d6-f5bdcdf32448.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(35, 7, NULL, 2, 'images/item/original/297f34e0-723c-11ea-b9a4-c9c0b4e9163a.jpg', 'images/item/compressed/297f34e0-723c-11ea-b9a4-c9c0b4e9163a.jpg', 'images/item/thumbs/297f34e0-723c-11ea-b9a4-c9c0b4e9163a.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(36, 7, NULL, 3, 'images/item/original/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', 'images/item/compressed/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', 'images/item/thumbs/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(37, 7, NULL, 1, 'images/item/original/eb283af0-6a61-11ea-b2b6-292aef84ff43.jpg', 'images/item/compressed/eb283af0-6a61-11ea-b2b6-292aef84ff43.jpg', 'images/item/thumbs/eb283af0-6a61-11ea-b2b6-292aef84ff43.jpg', '2020-03-18 22:43:50', '2020-03-19 15:18:57', NULL),
(38, 8, NULL, 2, 'images/item/original/eb2d8e40-6a61-11ea-aab0-05eb226147cc.jpg', 'images/item/compressed/eb2d8e40-6a61-11ea-aab0-05eb226147cc.jpg', 'images/item/thumbs/eb2d8e40-6a61-11ea-aab0-05eb226147cc.jpg', '2020-03-18 22:43:50', '2020-03-19 15:18:57', NULL),
(39, 8, NULL, 3, 'images/item/original/eb3712b0-6a61-11ea-a65f-1d11a212b60a.jpg', 'images/item/compressed/eb3712b0-6a61-11ea-a65f-1d11a212b60a.jpg', 'images/item/thumbs/eb3712b0-6a61-11ea-a65f-1d11a212b60a.jpg', '2020-03-18 22:43:50', '2020-03-19 15:18:57', NULL),
(40, 9, NULL, 1, 'images/item/original/e6d63d40-69d6-11ea-a1e0-c7b29e5445ff.jpg', 'images/item/compressed/e6d63d40-69d6-11ea-a1e0-c7b29e5445ff.jpg', 'images/item/thumbs/e6d63d40-69d6-11ea-a1e0-c7b29e5445ff.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(41, 9, NULL, 2, 'images/item/original/e6d6ee60-69d6-11ea-afc6-cf2db0dd05a3.jpg', 'images/item/compressed/e6d6ee60-69d6-11ea-afc6-cf2db0dd05a3.jpg', 'images/item/thumbs/e6d6ee60-69d6-11ea-afc6-cf2db0dd05a3.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(42, 9, NULL, 3, 'images/item/original/e6d7dcc0-69d6-11ea-be59-9b9533906bb5.jpg', 'images/item/compressed/e6d7dcc0-69d6-11ea-be59-9b9533906bb5.jpg', 'images/item/thumbs/e6d7dcc0-69d6-11ea-be59-9b9533906bb5.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(43, 10, NULL, 1, 'images/item/original/e6db8e00-69d6-11ea-875f-7f39c2094ffd.jpg', 'images/item/compressed/e6db8e00-69d6-11ea-875f-7f39c2094ffd.jpg', 'images/item/thumbs/e6db8e00-69d6-11ea-875f-7f39c2094ffd.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(44, 10, NULL, 2, 'images/item/original/e6dc5b50-69d6-11ea-91a0-cd16c57d3da9.jpg', 'images/item/compressed/e6dc5b50-69d6-11ea-91a0-cd16c57d3da9.jpg', 'images/item/thumbs/e6dc5b50-69d6-11ea-91a0-cd16c57d3da9.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(45, 10, NULL, 3, 'images/item/original/e6dd4e60-69d6-11ea-b582-1322eb9e6997.jpg', 'images/item/compressed/e6dd4e60-69d6-11ea-b582-1322eb9e6997.jpg', 'images/item/thumbs/e6dd4e60-69d6-11ea-b582-1322eb9e6997.jpg', '2020-03-18 22:43:50', '2020-03-18 22:43:50', NULL),
(46, 11, NULL, 1, 'images/item/original/a929a4a0-62b9-11ea-b4c5-359626e74ce5.jpg', 'images/item/compressed/a929a4a0-62b9-11ea-b4c5-359626e74ce5.jpg', 'images/item/thumbs/a929a4a0-62b9-11ea-b4c5-359626e74ce5.jpg', '2020-03-19 14:05:01', '2020-03-30 18:08:38', NULL),
(47, 11, NULL, 2, 'images/item/original/a929a4a0-62b9-11ea-b4c5-359626e74ce5.jpg', 'images/item/compressed/72228840-731e-11ea-9a68-1d5497ba2959.jpg', 'images/item/thumbs/72228840-731e-11ea-9a68-1d5497ba2959.jpg', '2020-03-19 14:05:01', '2020-03-30 18:08:38', NULL),
(48, 11, NULL, 3, 'images/item/original/722c4800-731e-11ea-87f7-a7ef99bb1d13.jpg', 'images/item/compressed/722c4800-731e-11ea-87f7-a7ef99bb1d13.jpg', 'images/item/thumbs/722c4800-731e-11ea-87f7-a7ef99bb1d13.jpg', '2020-03-19 14:05:01', '2020-03-30 18:08:39', NULL),
(49, 12, 11, 1, 'images/item/original/45b5e650-5ec9-11ea-8ca6-41cd3d8b1c81.jpg', 'images/item/compressed/45b5e650-5ec9-11ea-8ca6-41cd3d8b1c81.jpg', 'images/item/thumbs/45b5e650-5ec9-11ea-8ca6-41cd3d8b1c81.jpg', '2020-03-19 14:05:26', '2020-03-19 14:05:26', NULL),
(50, 12, 12, 2, 'images/item/original/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', 'images/item/compressed/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', 'images/item/thumbs/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', '2020-03-19 14:05:26', '2020-03-19 14:05:26', NULL),
(51, 12, 32, 3, 'images/item/original/275ef280-61ab-11ea-8ca5-45753cbdf370.jpg', 'images/item/compressed/275ef280-61ab-11ea-8ca5-45753cbdf370.jpg', 'images/item/thumbs/275ef280-61ab-11ea-8ca5-45753cbdf370.jpg', '2020-03-19 14:05:26', '2020-03-19 14:05:26', NULL),
(52, 12, 11, 4, 'images/item/original/275ef280-61ab-11ea-8ca5-45753cbdf370.jpg', 'images/item/compressed/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', 'images/item/thumbs/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', NULL, NULL, NULL),
(53, 12, 11, 5, 'images/item/original/275ef280-61ab-11ea-8ca5-45753cbdf370.jpg', 'images/item/compressed/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', 'images/item/thumbs/14f5a7f0-624c-11ea-9122-c5920a5f526e.jpg', NULL, NULL, NULL),
(54, 0, NULL, NULL, '/images/item/f8340ed0-8a06-11ea-b603-3bf55f75c104.jpg', NULL, NULL, '2020-04-28 21:48:32', '2020-04-28 21:48:32', NULL),
(55, 0, NULL, NULL, '/images/item/f858a710-8a06-11ea-b65b-8d036223f5fd.jpg', NULL, NULL, '2020-04-28 21:48:32', '2020-04-28 21:48:32', NULL),
(56, 0, NULL, NULL, '/images/item/f8728340-8a06-11ea-88f3-9b65325b2c0d.jpg', NULL, NULL, '2020-04-28 21:48:33', '2020-04-28 21:48:33', NULL),
(57, 0, NULL, NULL, '/images/item/f893b7f0-8a06-11ea-98b7-63c08b6c01d4.jpg', NULL, NULL, '2020-04-28 21:48:33', '2020-04-28 21:48:33', NULL),
(58, 0, NULL, NULL, '/images/item/f8b5e480-8a06-11ea-887a-398be09f71e7.jpg', NULL, NULL, '2020-04-28 21:48:33', '2020-04-28 21:48:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_inv`
--

CREATE TABLE `item_inv` (
  `id` bigint(191) NOT NULL,
  `item_id` bigint(191) NOT NULL,
  `color_id` bigint(191) DEFAULT NULL,
  `color_name` varchar(100) DEFAULT NULL,
  `qty` int(10) NOT NULL DEFAULT 0,
  `itemsize` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `threshold` int(10) DEFAULT NULL,
  `available_on` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_inv`
--

INSERT INTO `item_inv` (`id`, `item_id`, `color_id`, `color_name`, `qty`, `itemsize`, `sort`, `threshold`, `available_on`, `created_at`, `updated_at`) VALUES
(1, 12, 1, 'RED', 2, 10, NULL, NULL, NULL, NULL, NULL),
(2, 12, 2, 'Black', 5, 11, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_list_history`
--

CREATE TABLE `item_list_history` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_list_history`
--

INSERT INTO `item_list_history` (`id`, `item_id`, `status`) VALUES
(348, 12, 1),
(349, 7, 1),
(350, 11, 1),
(351, 8, 1),
(352, 9, 1),
(353, 10, 1),
(354, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_list_url_history`
--

CREATE TABLE `item_list_url_history` (
  `url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item_list_url_history`
--

INSERT INTO `item_list_url_history` (`url`) VALUES
('http://127.0.0.1:8000/admin/items/all');

-- --------------------------------------------------------

--
-- Table structure for table `item_size`
--

CREATE TABLE `item_size` (
  `id` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `available` tinyint(4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_size`
--

INSERT INTO `item_size` (`id`, `item_id`, `size_id`, `available`, `created_at`, `updated_at`) VALUES
(1, 7, 10, NULL, NULL, NULL),
(2, 7, 11, NULL, NULL, NULL),
(3, 7, 17, NULL, NULL, NULL),
(4, 7, 18, NULL, NULL, NULL),
(5, 8, 10, NULL, NULL, NULL),
(6, 8, 11, NULL, NULL, NULL),
(7, 8, 14, NULL, NULL, NULL),
(8, 8, 16, NULL, NULL, NULL),
(13, 10, 14, NULL, NULL, NULL),
(14, 10, 16, NULL, NULL, NULL),
(15, 10, 10, NULL, NULL, NULL),
(16, 10, 17, NULL, NULL, NULL),
(17, 11, 14, NULL, NULL, NULL),
(18, 11, 16, NULL, NULL, NULL),
(19, 11, 10, NULL, NULL, NULL),
(20, 11, 17, NULL, NULL, NULL),
(21, 12, 14, NULL, NULL, NULL),
(22, 12, 16, NULL, NULL, NULL),
(23, 12, 10, NULL, NULL, NULL),
(24, 12, 17, NULL, NULL, NULL),
(25, 9, 18, 1, NULL, NULL),
(26, 9, 16, 1, NULL, NULL),
(27, 9, 14, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_views`
--

CREATE TABLE `item_views` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_history`
--

CREATE TABLE `login_history` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_history`
--

INSERT INTO `login_history` (`id`, `user_id`, `ip`, `created_at`, `updated_at`) VALUES
(1, 2, '127.0.0.1', '2020-01-05 17:11:40', '2020-01-05 17:11:40'),
(2, 1, '127.0.0.1', '2020-01-05 19:40:11', '2020-01-05 19:40:11'),
(3, 1, '127.0.0.1', '2020-01-05 19:43:25', '2020-01-05 19:43:25'),
(4, 1, '127.0.0.1', '2020-01-05 19:44:06', '2020-01-05 19:44:06'),
(5, 1, '127.0.0.1', '2020-01-05 19:49:34', '2020-01-05 19:49:34'),
(6, 1, '127.0.0.1', '2020-02-03 15:08:14', '2020-02-03 15:08:14'),
(7, 1, '127.0.0.1', '2020-02-03 15:35:25', '2020-02-03 15:35:25'),
(8, 1, '127.0.0.1', '2020-02-04 13:49:04', '2020-02-04 13:49:04'),
(9, 1, '127.0.0.1', '2020-02-05 15:27:53', '2020-02-05 15:27:53'),
(10, 1, '127.0.0.1', '2020-02-06 12:07:42', '2020-02-06 12:07:42'),
(11, 1, '127.0.0.1', '2020-02-06 12:50:56', '2020-02-06 12:50:56'),
(12, 1, '127.0.0.1', '2020-02-06 15:56:23', '2020-02-06 15:56:23'),
(13, 1, '127.0.0.1', '2020-02-09 12:17:49', '2020-02-09 12:17:49'),
(14, 1, '127.0.0.1', '2020-02-11 13:58:28', '2020-02-11 13:58:28'),
(15, 1, '127.0.0.1', '2020-02-12 18:04:57', '2020-02-12 18:04:57'),
(16, 1, '127.0.0.1', '2020-02-12 18:06:24', '2020-02-12 18:06:24'),
(17, 1, '127.0.0.1', '2020-02-25 20:55:15', '2020-02-25 20:55:15'),
(18, 1, '127.0.0.1', '2020-03-18 06:54:20', '2020-03-18 06:54:20'),
(19, 1, '127.0.0.1', '2020-03-19 13:14:47', '2020-03-19 13:14:47'),
(20, 1, '127.0.0.1', '2020-03-19 14:31:41', '2020-03-19 14:31:41'),
(21, 1, '127.0.0.1', '2020-03-22 17:20:17', '2020-03-22 17:20:17'),
(22, 1, '127.0.0.1', '2020-03-24 14:48:48', '2020-03-24 14:48:48'),
(23, 1, '127.0.0.1', '2020-03-24 18:14:38', '2020-03-24 18:14:38'),
(24, 1, '127.0.0.1', '2020-03-29 20:22:36', '2020-03-29 20:22:36'),
(25, 1, '127.0.0.1', '2020-03-30 16:28:49', '2020-03-30 16:28:49'),
(26, 10, '127.0.0.1', '2020-03-31 14:15:58', '2020-03-31 14:15:58'),
(27, 10, '127.0.0.1', '2020-03-31 14:16:23', '2020-03-31 14:16:23'),
(28, 10, '127.0.0.1', '2020-03-31 14:16:34', '2020-03-31 14:16:34'),
(29, 10, '127.0.0.1', '2020-03-31 14:27:26', '2020-03-31 14:27:26'),
(30, 10, '127.0.0.1', '2020-03-31 15:02:15', '2020-03-31 15:02:15'),
(31, 10, '127.0.0.1', '2020-03-31 15:03:25', '2020-03-31 15:03:25'),
(32, 1, '127.0.0.1', '2020-04-01 20:20:10', '2020-04-01 20:20:10'),
(33, 1, '127.0.0.1', '2020-04-05 15:55:35', '2020-04-05 15:55:35'),
(34, 1, '127.0.0.1', '2020-04-06 19:19:26', '2020-04-06 19:19:26'),
(35, 10, '127.0.0.1', '2020-04-09 16:15:44', '2020-04-09 16:15:44'),
(36, 10, '127.0.0.1', '2020-04-09 16:17:55', '2020-04-09 16:17:55'),
(37, 1, '127.0.0.1', '2020-04-09 20:08:04', '2020-04-09 20:08:04'),
(38, 10, '127.0.0.1', '2020-04-12 22:14:16', '2020-04-12 22:14:16'),
(39, 10, '127.0.0.1', '2020-04-12 22:15:55', '2020-04-12 22:15:55'),
(40, 10, '127.0.0.1', '2020-04-12 22:16:50', '2020-04-12 22:16:50'),
(41, 10, '127.0.0.1', '2020-04-12 22:17:20', '2020-04-12 22:17:20'),
(42, 10, '127.0.0.1', '2020-04-12 22:25:54', '2020-04-12 22:25:54'),
(43, 10, '127.0.0.1', '2020-04-12 22:26:40', '2020-04-12 22:26:40'),
(44, 10, '127.0.0.1', '2020-04-12 22:27:37', '2020-04-12 22:27:37'),
(45, 10, '127.0.0.1', '2020-04-12 22:33:02', '2020-04-12 22:33:02'),
(46, 10, '127.0.0.1', '2020-04-12 22:47:58', '2020-04-12 22:47:58'),
(47, 10, '127.0.0.1', '2020-04-12 22:47:59', '2020-04-12 22:47:59'),
(48, 10, '127.0.0.1', '2020-04-12 22:53:19', '2020-04-12 22:53:19'),
(49, 10, '127.0.0.1', '2020-04-12 22:53:20', '2020-04-12 22:53:20'),
(50, 10, '127.0.0.1', '2020-04-12 22:53:21', '2020-04-12 22:53:21'),
(51, 10, '127.0.0.1', '2020-04-12 23:21:13', '2020-04-12 23:21:13'),
(52, 10, '127.0.0.1', '2020-04-12 23:22:31', '2020-04-12 23:22:31'),
(53, 10, '127.0.0.1', '2020-04-12 23:27:18', '2020-04-12 23:27:18'),
(54, 10, '127.0.0.1', '2020-04-12 23:28:37', '2020-04-12 23:28:37'),
(55, 10, '127.0.0.1', '2020-04-12 23:28:38', '2020-04-12 23:28:38'),
(56, 12, '127.0.0.1', '2020-04-12 23:31:30', '2020-04-12 23:31:30'),
(57, 10, '127.0.0.1', '2020-04-14 14:25:58', '2020-04-14 14:25:58'),
(58, 1, '127.0.0.1', '2020-04-14 15:51:53', '2020-04-14 15:51:53'),
(59, 1, '127.0.0.1', '2020-04-14 15:55:51', '2020-04-14 15:55:51'),
(60, 10, '127.0.0.1', '2020-04-14 22:39:51', '2020-04-14 22:39:51'),
(61, 10, '127.0.0.1', '2020-04-14 22:46:52', '2020-04-14 22:46:52'),
(62, 10, '127.0.0.1', '2020-04-14 22:55:10', '2020-04-14 22:55:10'),
(63, 10, '127.0.0.1', '2020-04-15 06:10:49', '2020-04-15 06:10:49'),
(64, 10, '127.0.0.1', '2020-04-15 06:15:14', '2020-04-15 06:15:14'),
(65, 10, '127.0.0.1', '2020-04-15 06:17:39', '2020-04-15 06:17:39'),
(66, 10, '127.0.0.1', '2020-04-15 06:33:01', '2020-04-15 06:33:01'),
(67, 10, '127.0.0.1', '2020-04-15 06:35:11', '2020-04-15 06:35:11'),
(68, 10, '127.0.0.1', '2020-04-15 13:21:56', '2020-04-15 13:21:56'),
(69, 10, '127.0.0.1', '2020-04-15 13:23:22', '2020-04-15 13:23:22'),
(70, 1, '103.120.202.118', '2020-04-16 03:11:13', '2020-04-16 03:11:13'),
(71, 1, '37.111.229.212', '2020-04-16 07:19:37', '2020-04-16 07:19:37'),
(72, 1, '202.181.6.17', '2020-04-16 07:42:54', '2020-04-16 07:42:54'),
(73, 1, '202.181.6.17', '2020-04-16 17:38:57', '2020-04-16 17:38:57'),
(74, 1, '127.0.0.1', '2020-04-21 20:47:45', '2020-04-21 20:47:45'),
(75, 1, '127.0.0.1', '2020-04-28 21:47:46', '2020-04-28 21:47:46'),
(76, 1, '127.0.0.1', '2020-04-30 20:13:26', '2020-04-30 20:13:26'),
(77, 1, '127.0.0.1', '2020-05-10 15:55:56', '2020-05-10 15:55:56');

-- --------------------------------------------------------

--
-- Table structure for table `made_in_countries`
--

CREATE TABLE `made_in_countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `made_in_countries`
--

INSERT INTO `made_in_countries` (`id`, `name`, `status`, `default`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'jhhik', 1, 1, '2020-03-18 07:12:12', '2020-03-19 13:23:58', '2020-03-19 13:23:58'),
(6, 'Bangladesh', 1, 1, '2020-01-06 21:00:33', '2020-03-18 07:12:00', NULL),
(7, 'India', 1, 0, '2020-01-06 21:01:47', '2020-03-19 13:37:33', '2020-03-19 13:37:33'),
(9, 'fgfgf', 1, 0, '2020-03-19 13:23:46', '2020-03-19 13:36:57', '2020-03-19 13:36:57'),
(10, 'fgfg', 1, 0, '2020-03-19 13:24:45', '2020-03-19 13:36:54', '2020-03-19 13:36:54'),
(11, 'fgfgfg', 1, 0, '2020-03-19 13:37:02', '2020-03-19 13:37:36', '2020-03-19 13:37:36'),
(12, 'ghdh', 1, 1, '2020-03-19 13:37:40', '2020-03-19 13:37:46', '2020-03-19 13:37:46');

-- --------------------------------------------------------

--
-- Table structure for table `master_colors`
--

CREATE TABLE `master_colors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_colors`
--

INSERT INTO `master_colors` (`id`, `name`, `image_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, 'Black', '/images/master_color/4e77ad10-5df2-11e8-9866-35f0a9aad927.jpg', '2018-05-22 12:59:51', '2018-05-22 12:59:51', NULL),
(7, 'Red', '/images/master_color/3586a0b0-5df2-11e8-8423-fbb0e7848eaf.jpg', '2018-05-22 12:59:09', '2020-04-15 19:45:43', NULL),
(9, 'Blue', '/images/master_color/5e75f940-5df2-11e8-8b31-53e1d9dda377.jpg', '2018-05-22 13:00:18', '2018-05-22 13:00:18', NULL),
(10, 'Brown', '/images/master_color/791e7f20-5df2-11e8-b6ea-f9806acbee22.jpg', '2018-05-22 13:01:03', '2018-05-22 13:01:03', NULL),
(11, 'Gold', '/images/master_color/871c7b10-5df2-11e8-bd06-5d3d96e22977.jpg', '2018-05-22 13:01:26', '2018-05-22 13:01:26', NULL),
(12, 'Gray', '/images/master_color/97251680-5df2-11e8-80d0-0b45ed04fbf9.jpg', '2018-05-22 13:01:53', '2018-05-22 13:01:53', NULL),
(13, 'Green', '/images/master_color/ad0764b0-5df2-11e8-bf69-49778d6fff9a.jpg', '2018-05-22 13:02:30', '2018-05-22 13:02:30', NULL),
(14, 'Ivory', '/images/master_color/c1f2e920-5df2-11e8-8da5-5b7f0944a348.jpg', '2018-05-22 13:03:05', '2018-05-22 13:03:05', NULL),
(15, 'Multi', '/images/master_color/d3727d00-5df2-11e8-8efd-e3a8ede6be2e.jpg', '2018-05-22 13:03:34', '2018-05-22 13:03:34', NULL),
(16, 'Orange', '/images/master_color/e5b44320-5df2-11e8-8331-275f5efbdb75.jpg', '2018-05-22 13:04:05', '2018-05-22 13:04:05', NULL),
(17, 'Pink', '/images/master_color/f9303bb0-5df2-11e8-a50f-230282c65397.jpg', '2018-05-22 13:04:37', '2018-05-22 13:04:37', NULL),
(18, 'Purple', '/images/master_color/12f03b80-5df3-11e8-a134-07210ad6c7cb.jpg', '2018-05-22 13:05:21', '2018-05-22 13:05:21', NULL),
(19, 'Silver', '/images/master_color/283ad410-5df3-11e8-878c-15abac44d755.jpg', '2018-05-22 13:05:56', '2018-05-22 13:05:56', NULL),
(20, 'Beige', '/images/master_color/3bbf2f50-5df3-11e8-861a-ff67af98860e.jpg', '2018-05-22 13:06:29', '2018-05-22 13:06:29', NULL),
(21, 'White', '/images/master_color/4b694870-5df3-11e8-a72e-7702ab347774.jpg', '2018-05-22 13:06:55', '2018-05-22 13:06:55', NULL),
(22, 'Yellow', '/images/master_color/5b5a3520-5df3-11e8-a6bc-bd02725fcab8.jpg', '2018-05-22 13:07:22', '2018-06-29 09:43:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

CREATE TABLE `metas` (
  `id` int(10) UNSIGNED NOT NULL,
  `page` int(11) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `title` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metas`
--

INSERT INTO `metas` (`id`, `page`, `category`, `title`, `description`, `created_at`, `updated_at`) VALUES
(11, NULL, 11, 'Pant', 'Pant', '2020-02-09 19:20:18', '2020-02-09 19:20:18'),
(5, NULL, 5, 'Women', 'Women', '2020-01-06 13:08:31', '2020-01-06 13:08:31'),
(3, NULL, 3, NULL, NULL, '2020-01-06 12:37:16', '2020-01-06 12:37:16'),
(4, NULL, 4, 'Top', 'Top Desc', '2020-01-06 12:57:30', '2020-01-06 12:57:30'),
(12, NULL, 12, 'Outware', 'Outware', '2020-02-09 19:46:47', '2020-02-09 19:46:47'),
(6, NULL, 6, NULL, NULL, '2020-02-06 18:27:17', '2020-02-06 18:27:17'),
(7, NULL, 7, NULL, NULL, '2020-02-06 18:40:39', '2020-02-06 18:40:39'),
(8, NULL, 8, 'Preorder', 'Preorder', '2020-02-06 18:44:35', '2020-02-06 18:44:35'),
(9, NULL, 9, NULL, NULL, '2020-02-06 18:55:25', '2020-02-06 18:55:25'),
(10, NULL, 10, NULL, NULL, '2020-02-06 18:55:41', '2020-02-06 18:55:41'),
(13, NULL, 13, 'Preorder Dress', 'Preorder Dress', '2020-02-10 15:37:29', '2020-02-10 15:37:29'),
(14, NULL, 14, 'test', 'test', '2020-03-22 17:24:39', '2020-03-22 17:24:39'),
(15, NULL, 15, 'tests', 'tests', '2020-03-22 17:29:23', '2020-03-22 17:29:23'),
(16, 1, NULL, NULL, NULL, '2020-03-30 17:16:32', '2020-03-30 17:16:32'),
(17, 2, NULL, NULL, NULL, '2020-03-30 17:16:52', '2020-04-01 20:58:03'),
(18, 6, NULL, NULL, NULL, '2020-03-30 17:16:54', '2020-04-01 20:59:08'),
(19, 5, NULL, NULL, NULL, '2020-03-30 17:16:55', '2020-04-01 20:58:55'),
(20, 4, NULL, NULL, NULL, '2020-03-30 17:16:56', '2020-04-01 20:58:46'),
(21, 3, NULL, NULL, NULL, '2020-03-30 17:16:56', '2020-04-01 20:58:32'),
(22, 8, NULL, NULL, NULL, '2020-03-30 17:16:57', '2020-04-01 20:59:16'),
(23, 14, NULL, 'Home Page Custome Section', 'Home Page Custome Section', '2020-03-30 19:44:49', '2020-04-01 20:37:40'),
(24, NULL, NULL, NULL, NULL, '2020-05-10 15:56:19', '2020-05-10 15:56:19');

-- --------------------------------------------------------

--
-- Table structure for table `meta_buyers`
--

CREATE TABLE `meta_buyers` (
  `id` int(10) UNSIGNED NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `block` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `age_group_id` int(5) DEFAULT NULL,
  `skin_type_id` int(5) DEFAULT NULL,
  `shipping_location` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state_id` int(11) DEFAULT NULL,
  `shipping_state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_unit` int(11) DEFAULT NULL,
  `shipping_zip` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country_id` int(11) DEFAULT NULL,
  `shipping_phone` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_fax` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_location` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_state_id` int(11) DEFAULT NULL,
  `billing_state` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_unit` int(11) DEFAULT NULL,
  `billing_zip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_country_id` int(11) NOT NULL,
  `billing_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_offers` int(11) DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `points_spent` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meta_buyers`
--

INSERT INTO `meta_buyers` (`id`, `verified`, `active`, `block`, `user_id`, `age_group_id`, `skin_type_id`, `shipping_location`, `shipping_address`, `shipping_city`, `shipping_state_id`, `shipping_state`, `shipping_unit`, `shipping_zip`, `shipping_country_id`, `shipping_phone`, `shipping_fax`, `billing_location`, `billing_address`, `billing_city`, `billing_state_id`, `billing_state`, `billing_unit`, `billing_zip`, `billing_country_id`, `billing_phone`, `billing_fax`, `receive_offers`, `avatar`, `points`, `points_spent`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, 1, 0, 6, 9, 1, 'INT', 'House-15, Road-8, Gulshan, Dhaka, Gulshan, Dhaka, Gulshan, Dhaka', 'Dhaka', NULL, 'gulshan', 4, '1212', 3, '1725651254', '1725651254', 'INT', 'House-15, Road-8, Gulshan, Dhaka, Gulshan, Dhaka, Gulshan, Dhaka', 'Dhaka', NULL, 'gulshan', 4, '1212', 3, '1725651254', '1725651254', 1, NULL, 0, 0, '2020-02-05 20:31:09', '2020-02-06 14:57:29', NULL),
(5, 0, 1, 0, 10, 9, 2, 'US', '1128 Crockser St, L18, L18', 'Los Angeles', 2, NULL, 0, '90021', 1, '2137474139', '2137474139', 'US', 'Mokampur, 12', 'khulna', 4, NULL, NULL, '9220', 1, '345345345', '2137474139', 1, NULL, 809, 0, '2020-02-06 15:09:55', '2020-05-03 21:11:57', NULL),
(8, 0, 0, 0, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-12 21:43:59', '2020-04-12 21:43:59', NULL),
(7, 0, 0, 0, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-12 21:33:02', '2020-04-12 21:33:02', NULL),
(9, 0, 0, 0, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-12 22:08:31', '2020-04-12 22:08:31', NULL),
(10, 0, 0, 0, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'US', 'Mokampur, 12', 'khulna', 4, NULL, NULL, '9220', 0, '1321321', NULL, 0, NULL, 0, 0, '2020-04-27 14:19:17', '2020-04-27 23:01:38', NULL),
(11, 0, 0, 0, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'US', 'Mokampur', 'khulna', 5, NULL, NULL, '9220', 0, '1321321', NULL, 0, NULL, 0, 0, '2020-04-28 01:44:01', '2020-04-28 02:26:16', NULL),
(12, 0, 0, 0, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:46:06', '2020-04-28 01:46:06', NULL),
(13, 0, 0, 0, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:46:39', '2020-04-28 01:46:39', NULL),
(14, 0, 0, 0, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:51:05', '2020-04-28 01:51:05', NULL),
(15, 0, 0, 0, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:51:41', '2020-04-28 01:51:41', NULL),
(16, 0, 0, 0, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:52:45', '2020-04-28 01:52:45', NULL),
(17, 0, 0, 0, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:53:11', '2020-04-28 01:53:11', NULL),
(18, 0, 0, 0, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:53:17', '2020-04-28 01:53:17', NULL),
(19, 0, 0, 0, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:53:32', '2020-04-28 01:53:32', NULL),
(20, 0, 0, 0, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:53:40', '2020-04-28 01:53:40', NULL),
(21, 0, 0, 0, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-04-28 01:54:14', '2020-04-28 01:54:14', NULL),
(22, 0, 0, 0, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'INT', 'Mokampur, 12', 'khulna', NULL, 'Arizona', NULL, '9220', 4, '1321321', NULL, 0, NULL, 0, 0, '2020-05-03 21:19:48', '2020-05-03 21:27:39', NULL),
(23, 0, 0, 0, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-05-03 21:40:28', '2020-05-03 21:40:28', NULL),
(24, 0, 0, 0, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'US', 'Mokampur, 12', 'khulna', 60, NULL, NULL, '9220', 0, '1321321', NULL, 0, NULL, 0, 0, '2020-05-03 21:41:05', '2020-05-03 22:13:36', NULL),
(25, 0, 0, 0, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', NULL, NULL, NULL, '', 0, '', NULL, 0, NULL, 0, 0, '2020-05-03 21:42:00', '2020-05-03 21:42:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `meta_settings`
--

CREATE TABLE `meta_settings` (
  `id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `meta_vendors`
--

CREATE TABLE `meta_vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `verified` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_state_id` int(11) DEFAULT NULL,
  `billing_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_zip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_country_id` int(11) NOT NULL,
  `billing_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `billing_alternate_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_commercial` tinyint(1) NOT NULL,
  `factory_location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `factory_address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `factory_unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `factory_city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `factory_state_id` int(11) DEFAULT NULL,
  `factory_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `factory_zip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `factory_country_id` int(11) NOT NULL,
  `factory_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `factory_alternate_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `factory_evening_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `factory_fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `factory_commercial` tinyint(1) DEFAULT NULL,
  `company_info` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hear_about_us` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hear_about_us_other` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_notice` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size_chart` varchar(3000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_offers` tinyint(1) NOT NULL,
  `setting_estimated_shipping_charge` tinyint(1) NOT NULL DEFAULT 0,
  `setting_consolidation` tinyint(1) NOT NULL DEFAULT 0,
  `setting_sort_activation_date` tinyint(1) NOT NULL DEFAULT 0,
  `setting_unverified_checkout` tinyint(1) NOT NULL DEFAULT 0,
  `setting_unverified_user` tinyint(1) NOT NULL DEFAULT 0,
  `setting_not_logged` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_main_slider` tinyint(1) NOT NULL DEFAULT 0,
  `sp_vendor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `return_policy` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp_password` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sp_default_category` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_order` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `meta_vendors`
--

INSERT INTO `meta_vendors` (`id`, `verified`, `active`, `company_name`, `business_name`, `website`, `billing_location`, `billing_address`, `billing_unit`, `billing_city`, `billing_state_id`, `billing_state`, `billing_zip`, `billing_country_id`, `billing_phone`, `billing_alternate_phone`, `billing_fax`, `billing_commercial`, `factory_location`, `factory_address`, `factory_unit`, `factory_city`, `factory_state_id`, `factory_state`, `factory_zip`, `factory_country_id`, `factory_phone`, `factory_alternate_phone`, `factory_evening_phone`, `factory_fax`, `factory_commercial`, `company_info`, `hear_about_us`, `hear_about_us_other`, `order_notice`, `size_chart`, `receive_offers`, `setting_estimated_shipping_charge`, `setting_consolidation`, `setting_sort_activation_date`, `setting_unverified_checkout`, `setting_unverified_user`, `setting_not_logged`, `show_in_main_slider`, `sp_vendor`, `return_policy`, `shipping`, `sp_password`, `sp_category`, `sp_default_category`, `min_order`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Binjar', 'Binjar Inc.', 'www.binjar.com', 'CA', '772 E. 12TH St #3', '2', 'Los Angeles', 6, 'Rampura', '90021', 1, '213-441-7171', NULL, '123456', 1, 'US', '772 E. 12TH St #3', '2', 'Los Angeles', 6, 'Raozan', '90021', 1, '213-441-7171', NULL, NULL, '4555', NULL, 'Company Info in details2', 'other', 'Bola jabena', '<p>Test Order notice</p>', '<p>&nbsp;asdfa<em> ds2</em></p>', 1, 0, 0, 1, 0, 0, 0, 1, 'vendor', '<p>Test Return Policy</p>', '<p>Shipping Information</p>', '123456', 'SALES', 'df', 0.2, '2018-05-08 09:03:20', '2019-09-09 05:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(2, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(3, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(4, '2016_06_01_000004_create_oauth_clients_table', 1),
(5, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `text` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `view` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00e4207c2a396ade9d55c37de50ae5d48852b9a67af62d3e98f0f071e0f74d083ff723b5a4bbbac2', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 21:54:09', '2020-05-03 21:54:09', '2021-05-04 03:54:09'),
('019e8ce591e00cf293c043adb9a3f936a84897bfcfbb347de4a813857a3929973eece4512e7c1b3c', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:43:28', '2020-04-26 16:43:28', '2021-04-26 22:43:28'),
('037895392a6fb196363408c192dbfef9ce7a61fe83698ed384cec0ccd68c43ea8787542cf06f6ace', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 03:25:07', '2020-04-29 03:25:07', '2021-04-29 09:25:07'),
('03e6bd4ded9c542d4b3e43c507fc4bcb75d555cfa621d385f4be0cb2f2ef535200be05b5f54a2b63', 24, 1, 'LynktoORCSsiwerrajul@gmail.com', '[]', 0, '2020-04-28 01:53:32', '2020-04-28 01:53:32', '2021-04-28 07:53:32'),
('04686f7acf11be5364a69313b050363b3845793dce539878d2e240b88e3ddbb0a3257e942a3e4928', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 21:51:35', '2020-05-03 21:51:35', '2021-05-04 03:51:35'),
('05a261ebfa34988997a38b5bd11cde365a53941703a42a1182191cc7f26b41e328b8681213d522d2', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-21 21:16:17', '2020-04-21 21:16:17', '2021-04-22 03:16:17'),
('0713c0e17b14e65908238fd6d627138573f2cd6a546fceacdd37a0da0cd794125134244fb0ea04da', 28, 1, 'LynktoORCSdipti2@gmail.comdd', '[]', 0, '2020-05-03 21:40:28', '2020-05-03 21:40:28', '2021-05-04 03:40:28'),
('08b9ad193785958171770559a212344fc384a304877e887b38f1ec6fdf8cd78b01dd44be050ccf2d', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 23:17:40', '2020-04-28 23:17:40', '2021-04-29 05:17:40'),
('09a3a0043d8f29eac2cfef00995d6529e042f895c7f7d6c90719ffd2043fde098e519b1a3e2f4177', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-21 00:40:10', '2020-04-21 00:40:10', '2021-04-21 06:40:10'),
('0b2822d92ac60e5d4107b7980d6a08eb7fbc8bc78e5ec5d96d8689fb0a2a991105a412aec61cfef6', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-23 16:50:05', '2020-04-23 16:50:05', '2021-04-23 22:50:05'),
('0b923e021c60656a9db796fc9e3766f88c5cb25db626452a14fcc38103ef7a5fcca85880c96f5718', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:42:51', '2020-04-26 16:42:51', '2021-04-26 22:42:51'),
('0df28a3580a06088714e155cf884988ac66217137cc5cf912fd62c1e697e552b53dee7f4be37dcb5', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 23:27:18', '2020-04-12 23:27:18', '2021-04-13 05:27:18'),
('0f067af78093cb419a247b47a9fc5769105b7e4af2f63b664b03cb0e61aea5a25bdd5bc4fcfc6b43', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:45:25', '2020-04-09 20:45:25', '2021-04-10 02:45:25'),
('0ff4d597f3bc2894071d765281e3f6328133b1fbe195fc5102d353bc8dc68b3f6120cf17a67ad945', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 21:57:58', '2020-04-12 21:57:58', '2021-04-13 03:57:58'),
('13850a260e5c1366f72638f0fef92ea6de78f36d8431f1a98ebeea7d516c728bf8c8de25f15d426e', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-27 13:48:15', '2020-04-27 13:48:15', '2021-04-27 19:48:15'),
('139daced65d0fa3aa2af42fc0a36d32fe65c3686682db7a49b7406e14fa66a7dbd7ab9b045eaf883', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-01 16:54:16', '2020-04-01 16:54:16', '2021-04-01 22:54:16'),
('1586b9200bd9a32d720cfe0806eb6c212fa7791a653178b73eb526fa5e30909d3427147f0fe18b32', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:08:48', '2020-04-29 01:08:48', '2021-04-29 07:08:48'),
('1871ddc1364ef3069e3979efc0903f874e750d1d26d344454c30e13c36128e2e380e2e0bca7e0306', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-01 16:44:11', '2020-04-01 16:44:11', '2021-04-01 22:44:11'),
('1a15e0b5ebe94529801671d8676d655cb943f9c368c326ffd14668c8bfc42b9000f5e64d95708f8a', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-27 13:52:10', '2020-04-27 13:52:10', '2021-04-27 19:52:10'),
('1b381ebf6579a863cb75d107aaaf1b83a57c9a87c9b77322804e5f46c532a75b4bc884597cf8ef57', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-10 20:10:59', '2020-05-10 20:10:59', '2021-05-11 02:10:59'),
('1b47515f5962380360477dabddb2c06be5e628d29a85530a3d97bcf4ab1e93a18a46b0d3f307bfaf', 29, 1, 'LynktoORCSdipeti@gmail.com', '[]', 0, '2020-05-03 21:41:05', '2020-05-03 21:41:05', '2021-05-04 03:41:05'),
('1ba71ecd666eacf85b220dffcf26dee459ef7395a4994912adcfbcdcd0716e0bc4cc8e3550740468', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 17:06:03', '2020-04-26 17:06:03', '2021-04-26 23:06:03'),
('1c35369144febc0665f388274279f590dfc4ee85c36b0cddd2e99c02eef76841f0eb75c348e627f1', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 21:34:28', '2020-04-28 21:34:28', '2021-04-29 03:34:28'),
('1c4570ee09df6aa7b99d960fe04b62ac961485013252c0f4bd0b824b012b9ff844caadc94041b565', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:11:41', '2020-04-09 21:11:41', '2021-04-10 03:11:41'),
('1dbb096d532391ab2dcd91a1bdd2095e6f83afe0b120f1684c5994a63059d2583c3307bb7883453f', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-10 21:42:29', '2020-05-10 21:42:29', '2021-05-11 03:42:29'),
('1df50d9e649b4430e29b3ce2dcbebc68d2bc29b9a42f5c6544c0b0312cbd88068f306a5f6474bd24', 16, 1, 'LynktoORCSsirajul@gmail.com123456', '[]', 0, '2020-04-28 01:54:49', '2020-04-28 01:54:49', '2021-04-28 07:54:49'),
('1e0b9259637e3675413caacd10b5fa584f56cdae970eb8304bff44093e78eae32f5452e89212d00c', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-15 13:23:22', '2020-04-15 13:23:22', '2021-04-15 19:23:22'),
('1f3714f7b9ac6032129613ac013811fd9f027e9ecaae08248a76ba48c1a6e48dc8cb8cacc15284e0', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 22:35:02', '2020-04-28 22:35:02', '2021-04-29 04:35:02'),
('1f3b2e03c3cabe9e94bdca48d1932547e74a02f9fcec73a7eeba90d39f2167d6ba1e24d154976e58', 14, 1, 'LynktoORCSsarmin@gmail.com', '[]', 0, '2020-04-12 22:08:32', '2020-04-12 22:08:32', '2021-04-13 04:08:32'),
('1fe23e9a98c4e51a0cae19a4a3f02433c0d11e84e413fa947bb96925583b6c6791513156dfb40984', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-14 22:46:52', '2020-04-14 22:46:52', '2021-04-15 04:46:52'),
('20a0df3e278f38c053045bf65f2208d1c50cbc095107a822218f1ae659c2407a7d407395bf826200', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-25 01:30:28', '2020-04-25 01:30:28', '2021-04-25 07:30:28'),
('21a979d52bd6e3947d40b83a27398f6b9c4bf310db167e8db7a8576f75dd6216ac60c22800e5a67c', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:20:52', '2020-04-29 01:20:52', '2021-04-29 07:20:52'),
('22487d66134439686d30e11020124879253c991e30f1f0f22f91277fd1057a30d3a7b89442562819', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:43:32', '2020-04-26 16:43:32', '2021-04-26 22:43:32'),
('225edc73a70d3a9e098419b772df4e5d1846d8bd6b72f833d801e475d82d8a6a386ca95ec0d8c43f', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 16:13:31', '2020-04-09 16:13:31', '2021-04-09 22:13:31'),
('23b597c84542dde1a2a381e41c53c71662dd7b94f1fa7943d5fcba9744f7660ba7d275ed5ec0d31b', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 00:45:59', '2020-04-29 00:45:59', '2021-04-29 06:45:59'),
('245a41a85ad7d446920dea2f873b6efff683c8b0e722b8d147ab2e8292447733d2a2dd45dbb661ea', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:48:25', '2020-04-09 20:48:25', '2021-04-10 02:48:25'),
('259a2e2300ad92b066891cb1ee369c1f7580298648cba8a25f29a5763e57c262fc0b9bbbae6d96c9', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 21:51:44', '2020-05-03 21:51:44', '2021-05-04 03:51:44'),
('25f30c4e2daeb10ba3380c94f53c056e11be2d95018089b91464d758da532ac2d6d16fc7561e6e7b', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-21 21:21:25', '2020-04-21 21:21:25', '2021-04-22 03:21:25'),
('2633082f9db73a5c3555ff93e0ab8c95b42cbc04d7c212d75d4d4dcc01934287991cbea2ed1e940b', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 21:55:09', '2020-04-12 21:55:09', '2021-04-13 03:55:09'),
('26b7003fde5a2a0a9a44bd1b801cb25852d42be8ac49b761da026bc72bd048c0223fcaadb62a1720', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:28:33', '2020-04-09 20:28:33', '2021-04-10 02:28:33'),
('270543798b8901669cb5891ff87f8c0bf9b8965f5ddc92b9195ede856972124dad5962309a07b170', 20, 1, 'LynktoORCSsirajul@gmail.com33', '[]', 0, '2020-04-28 01:51:41', '2020-04-28 01:51:41', '2021-04-28 07:51:41'),
('2761f51c65ffbd72f4402388a11ec10f7cace49d905cb4c0b11fe8dd5bc3a6a42127d43ac91541d5', 30, 1, 'LynktoORCSertret@gmail.com', '[]', 0, '2020-05-03 21:42:01', '2020-05-03 21:42:01', '2021-05-04 03:42:01'),
('2913f8a6a96c14273ff0f3ae102526de64ed1b366fa81c5901ff23e2bdac02c27840ce0a96c96522', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:08:41', '2020-05-03 22:08:41', '2021-05-04 04:08:41'),
('2a7c754cd3e50d96d332008b6663cec75ac91f772052143ee32f5bcffc966797841e47e2fab40192', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 13:53:49', '2020-04-28 13:53:49', '2021-04-28 19:53:49'),
('2ac0ee64064dfd4e15878b115dfea17eba8182797c23c3d4abce93bad0d89a179cc53215f60dd6d3', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-15 06:35:11', '2020-04-15 06:35:11', '2021-04-15 12:35:11'),
('2d65f053d2018c2cce9f2459291de64e1435c212cc423f92290174363fe378adc64e672dace80171', 26, 1, 'LynktoORCSsirajul098@gmail.com', '[]', 0, '2020-04-28 01:54:14', '2020-04-28 01:54:14', '2021-04-28 07:54:14'),
('2dd9a0fb324621e3bce1c1b5431fe760cb83b56eaf746d7ed03b45b40e0a994bbe7ab21100442629', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:17:39', '2020-04-29 01:17:39', '2021-04-29 07:17:39'),
('2e83ab388fb99f0b61d4532c48c75b512891fa9b62a0cb74eefa3c1e1faca7ca12c2596c18ab22ee', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:33:52', '2020-05-03 22:33:52', '2021-05-04 04:33:52'),
('2e8a921b752b2426d7bab5a329b69acde30999ead464ea79e7bf6d6b366031a097ba86fb1a0a178a', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:51:39', '2020-04-09 20:51:39', '2021-04-10 02:51:39'),
('2efcf301e27bb757a69d1d354bac4e398eb71744b24cb5c537e1ab62061ac85891795e00a71f2828', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:33:02', '2020-04-12 22:33:02', '2021-04-13 04:33:02'),
('2fd87790b814e4bfbb0a2381e24c1f3b604c16c816444b8bd376a6f9db642b580cc9d44dd8e38632', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:04:08', '2020-04-29 01:04:08', '2021-04-29 07:04:08'),
('3028498962b6b83c666101b0485a351ca12f5bf093f7f886c318ebe60ce0c7099ac1127243fd4f6b', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 20:33:23', '2020-05-03 20:33:23', '2021-05-04 02:33:23'),
('30abc8957b90c197af5964de4ab3bd9e45937555a888480c30ab72f088ee2d2de83c55d1fe5655e4', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:01:31', '2020-04-29 01:01:31', '2021-04-29 07:01:31'),
('3291e5c459b75a181374523c273f7c1920c263c17f7699b7d37fa66f705a6c3977934a9298817b6c', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:21:42', '2020-04-29 01:21:42', '2021-04-29 07:21:42'),
('331eb2bcab49040e77c4fcad6e16fdf58f6346242ba80b668b35782e47933bcbcbec5ffe14d4fc48', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 23:28:38', '2020-04-12 23:28:38', '2021-04-13 05:28:38'),
('33d882b5ca900ac2a83569357da9c292e36ff9424b03749a354aa1699c734b207b232c43bf0725ba', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:23:32', '2020-04-29 01:23:32', '2021-04-29 07:23:32'),
('34b0ca7a9a1e9f3a8dc057e802f5c636c6d9a47cbf7191e53747b56f69b77dbc0365546eec7e526e', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:06:12', '2020-04-09 20:06:12', '2021-04-10 02:06:12'),
('351df9cdacda907be5690f212a41010c822044eab7d776dd0e92d7b69a5aca6cef816a1a4387707e', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 23:09:20', '2020-05-03 23:09:20', '2021-05-04 05:09:20'),
('36a12096d4ae3ab3e9bb63d5f3a88f10fd65e339ad8883e636abf18ee935f8bd8c75d4b690ab93bc', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:37:54', '2020-04-09 20:37:54', '2021-04-10 02:37:54'),
('3758434a3187f2ed874e8a369f3d47aa5c497980136f18f597f5370f44d4e3fcd4871b2e44960a17', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:40:29', '2020-04-09 20:40:29', '2021-04-10 02:40:29'),
('37a3f0f58534fac3a73983113310b2deecdb8e4e037232e840c0958b4ded79632390e82904286b34', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 20:34:49', '2020-05-03 20:34:49', '2021-05-04 02:34:49'),
('396c4ea54b9d4f71d4f3816504e19496a9dfc2f8fa169e9972060375002eeeca5d731c7e5e854240', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 13:54:14', '2020-04-28 13:54:14', '2021-04-28 19:54:14'),
('3996182172cc2a6ef6513b47392cfb3900496e47b1258bcfe07341a94d0859c25a4b956f20f620b4', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 00:48:29', '2020-04-29 00:48:29', '2021-04-29 06:48:29'),
('3a3f2bccb1b7ed01337324b8266f83b3d19629b1c67a31110cae756f64b6a55e83494c8498206014', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:24:28', '2020-04-29 01:24:28', '2021-04-29 07:24:28'),
('3bc6e93f4fc2596fb0d19cb40a09212d0991ef7e50f2c13e35e4e4f5efd5253414a1d348d096c9c2', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:40:16', '2020-04-09 20:40:16', '2021-04-10 02:40:16'),
('3c7a3eda845cf4d130a8967263206b04e22bc7c8f9d41e76f7961e0bfad15e32f0e346ccaca15a31', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-25 03:44:14', '2020-04-25 03:44:14', '2021-04-25 09:44:14'),
('3d3cd7c201e14cc4a49335465ca2efd296166a2242a55cf721d994d6030689ee4cb443803b23dd9d', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 23:09:33', '2020-04-28 23:09:33', '2021-04-29 05:09:33'),
('3e11a6bf2c4dd0aafa229be4fb2e154b01e6d7a0b0e194a159d400925a110e5e6018952b0a3f82b6', 22, 1, 'LynktoORCSsiraju3eel@gmail.com', '[]', 0, '2020-04-28 01:53:11', '2020-04-28 01:53:11', '2021-04-28 07:53:11'),
('3ed0e36b24190a6f9d78686b050194faba0b45d2654e912f816164c48f7c9f3575b64a64e0a5ac79', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 02:26:15', '2020-04-29 02:26:15', '2021-04-29 08:26:15'),
('3ed18bde91d62088447c83c6b339e54943bdb698c7d37b972315d27f02524860c9d12dba6421b32f', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:53:57', '2020-04-09 20:53:57', '2021-04-10 02:53:57'),
('4187642867f5bbf71cc8cae51a82bc155ba4f37bac12f3e4ad433e1bd2264189476b2162be7b5da1', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:43:51', '2020-04-09 20:43:51', '2021-04-10 02:43:51'),
('41ae7bee00e06739bc975f2d79fbd33163303eb80b1a9ad3647bc66341086063bed9890de91f0221', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:17:14', '2020-04-29 01:17:14', '2021-04-29 07:17:14'),
('4245a260988ce741c2492e280c57c67bdbe18fab8bc3b58f44eb9b510738619edd734f0526f83ca6', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:06:02', '2020-05-03 22:06:02', '2021-05-04 04:06:02'),
('4518ab5064e06040675574eb709581b7309230f0bb0f30cddf1e431b9a9a876b3d6dff508a565233', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:38:06', '2020-05-03 22:38:06', '2021-05-04 04:38:06'),
('453f43c5db46e1024a3be67d92edcea4824d63de6c1879b0c23d9a6acc1b9289edc5b25a5323ffab', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:42:48', '2020-04-26 16:42:48', '2021-04-26 22:42:48'),
('45ea3945be909dc5c35fcdad01ce9d2d333cf438b42237c1c8fde3e11f7ee9ddae9b58cee16b385e', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 12:41:18', '2020-05-03 12:41:18', '2021-05-03 18:41:18'),
('499f07649efebb8e3490c51e6529e6e0e56203c86cc70890b6fc79656f759ea528011ac3399df898', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-04-29 15:41:29', '2020-04-29 15:41:29', '2021-04-29 21:41:29'),
('49a71a5ad5efc44188099ae1f7c27a7494bc04fc01419feba63ea973ffe5ebf67b9eb57a29685d5e', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 21:59:05', '2020-05-03 21:59:05', '2021-05-04 03:59:05'),
('4a939fc1fa4790b5fd939851cdb45750032e1284a44dcc14fc2dbfad0a35e7b9d6fe3719370cf14d', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 02:05:52', '2020-04-29 02:05:52', '2021-04-29 08:05:52'),
('4b75a74be173220dd2fdaabf3910f479b85b24969d83ca7422367f87d0caee37c0b1e0eecf125e4b', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-04-29 16:10:12', '2020-04-29 16:10:12', '2021-04-29 22:10:12'),
('4bf3af5885a988b65fe4cc3553a13c361118f296a36771ceaff4cd435eebda8dd2acdc362aaac550', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 23:03:41', '2020-04-28 23:03:41', '2021-04-29 05:03:41'),
('4c0aea35b549f25e16509f3509e7326b5bfa6df349c2c9b23bd5f31e07bb2054774d8590578f1e78', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-25 01:32:50', '2020-04-25 01:32:50', '2021-04-25 07:32:50'),
('4d32d00a79cc4ba6a57549a45b2208c91e5dc709dbe5757edd3f23f22882a3189b333c7f895135d9', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:44:25', '2020-05-03 22:44:25', '2021-05-04 04:44:25'),
('4d529e6fc19215bde7729d270d4c106f9c4ffe93a1772f0f705b25d46d1c5c45390f61edf1d59651', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:38:30', '2020-05-03 22:38:30', '2021-05-04 04:38:30'),
('4fc45c47642e9d891d9f1509b12bbe3a75498ec3b6c4801107871cc228c633050cc55b987000012f', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 20:35:11', '2020-05-03 20:35:11', '2021-05-04 02:35:11'),
('500e7d04ade89334e15df3ef5723034ebc59cf25888b4322ebe7ab7adcddc6c62d5f72762c2a1987', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-25 01:52:23', '2020-04-25 01:52:23', '2021-04-25 07:52:23'),
('5019392d7863498d9740649143311d0ef62e4679b5ccbd2be419182e92bfd0d3b5362140e3072351', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 00:56:59', '2020-04-29 00:56:59', '2021-04-29 06:56:59'),
('50ecbf65d355dd2348bd164d17355a9e11bc86812dfad5ffa0b269ec4c7720ad1063f50e80add65f', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:01:38', '2020-04-09 21:01:38', '2021-04-10 03:01:38'),
('5278b89f36aaed021aa9261840a1481ff50a46aba487c0beaa830cce551f5a66c5e4cafff598e1ac', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 13:57:14', '2020-04-28 13:57:14', '2021-04-28 19:57:14'),
('52bda4ed83718ebe3b8a8410e6bac4bdf85cac5ed9d4c95844eb17e5394dc99d2c8b22ec5d313321', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:08:04', '2020-05-03 22:08:04', '2021-05-04 04:08:04'),
('5385af5f9852b3a7f7aa5d0730098076d9a958ad374b25508309b2ffa720957f46e486896873ee24', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:17:02', '2020-04-09 21:17:02', '2021-04-10 03:17:02'),
('53989637e32dd7617cb41e170f07c776ed4b781c92f85a973e97a08e0b4270562cc939cde3432f7a', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:22:55', '2020-04-29 01:22:55', '2021-04-29 07:22:55'),
('54e6cc5b641a2dd08a473e2fa8431f707abad62c6c3e776a8417b7fb512147d9f6dc380fb2f420b7', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-04-23 17:12:57', '2020-04-23 17:12:57', '2021-04-23 23:12:57'),
('55c94dc58a1e4f43b8321efecaed2b6ca88189d6a7d9ecbdb1e8d8c1d21a8b1b07a81cef7160b751', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:17:08', '2020-04-09 21:17:08', '2021-04-10 03:17:08'),
('5648b8db36f33582ec7331cee53cba1a6e8728af424dc5a1fedf7fb4662b8659509c7652bd6847a8', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:08:55', '2020-04-29 01:08:55', '2021-04-29 07:08:55'),
('56cbb0040be1494c77e5f6beb6e1db1115d7c4b70ddbf371ac4e7afcf065e86214bffbfe2523cf07', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:47:59', '2020-04-12 22:47:59', '2021-04-13 04:47:59'),
('588589bf1074ce72895d16feb21d1c3d01ebb68a876dac0edbc1d774a3f3f7739542dacc986fa3d9', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 03:26:28', '2020-04-28 03:26:28', '2021-04-28 09:26:28'),
('58cefc190ec41121f9e77bca03a781f9311265b5c021627b8274a7d55e14ac6304d90581338eff4b', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:05:59', '2020-04-09 20:05:59', '2021-04-10 02:05:59'),
('5974d825cd6f2261c564657230e94224c1295acbadf84f99c7fceb4ae1b4237839a8506564a71cb8', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 06:21:00', '2020-05-02 06:21:00', '2021-05-02 12:21:00'),
('5994a5a09a9cf0b638dffc5798ea105131e036daf602795b9a03523f048237f6c37d3ccc73e096b9', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:25:55', '2020-04-12 22:25:55', '2021-04-13 04:25:55'),
('59f470ce6a40a9f0ac301c54c69d86ad5e1d0182926e84c055e5467b8b20342c191596e72ef9760c', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:47:59', '2020-04-12 22:47:59', '2021-04-13 04:47:59'),
('5bd06b45b73245b72b18f6e99d89ab6118a462c5ad58ff815e0cb7f6381aa67258f70d60afb1f403', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:34:39', '2020-05-03 22:34:39', '2021-05-04 04:34:39'),
('5c750e8eb8615039041175fd178372ca8b312db31da5b571be20d388ccc1621f35bd9fb5d8a9e328', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-25 03:53:43', '2020-04-25 03:53:43', '2021-04-25 09:53:43'),
('5cb5927b463193d06641d17f093b01c8df8a8f811bcb4ba3acc9820345f284ff098fa291ff0e6eea', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-21 00:40:24', '2020-04-21 00:40:24', '2021-04-21 06:40:24'),
('5cb6d0b18dfad07843831298c2b2865f2e6d0b138499daaed888c0de33bd064b6849dee345731727', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 06:23:31', '2020-05-02 06:23:31', '2021-05-02 12:23:31'),
('5ce93f541802f34a651d200b3e0d6d73349acadfc254bc48469bbf5efc207ca4dbc646414c802ca4', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:12:53', '2020-04-09 21:12:53', '2021-04-10 03:12:53'),
('5e7f15a748bc44601f06664a306e04d00deaedfda1522098913fea74137052c9854b62e2875c24a4', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 23:22:31', '2020-04-12 23:22:31', '2021-04-13 05:22:31'),
('5fc5eb0304ed7fd9e98f99a50d8bf2dea54cfb69cf6c8104541f842b9187b99bde550fe8a571dbcd', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 03:33:43', '2020-04-29 03:33:43', '2021-04-29 09:33:43'),
('5fdf4502793ca7f111ee357df5bcb36ccd0b255a06bdec76f7cba119b1140c72b3ad4cab211a03c5', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:04:54', '2020-04-29 01:04:54', '2021-04-29 07:04:54'),
('60651a18320cb3bf8c5a40d072537b0306ee456377bda96c02988019a4807f3a467358738b99f459', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:40:30', '2020-04-09 20:40:30', '2021-04-10 02:40:30'),
('60675b319a5b3515df925c3bfbdd93f08f7353451f99db69d7f26bcbdf03a6daec1afc7cbb16752a', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 07:32:04', '2020-05-02 07:32:04', '2021-05-02 13:32:04'),
('6125379dfc533406b6140a3cd76ef561891f02c8736ffa264343f2231f8debf41588e7f94a64dace', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 07:06:06', '2020-05-02 07:06:06', '2021-05-02 13:06:06'),
('6160ff74399e24dc029b03e189f21b4be84596308400d7080ec0433059b1beb74166cba011674888', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 23:28:37', '2020-04-12 23:28:37', '2021-04-13 05:28:37'),
('63935ec4afcdebd1e0d43d90a57776f1d8e0a632ec7cf69e61c1b9c0531e63d50a2113a520891d19', 12, 1, 'LynktoORCSkader@gmail.com', '[]', 0, '2020-04-12 23:31:30', '2020-04-12 23:31:30', '2021-04-13 05:31:30'),
('654f79ef34fd64d7a5ba6e56559e208a93f1431fcd55a73777fd4ac9bd43fa994bcde6604f189f1a', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:40:25', '2020-04-09 20:40:25', '2021-04-10 02:40:25'),
('67adffa14c4297230694f94ea1c65370d4e8483a13d78e1d8793316859d94c167c2a47c710636a38', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 07:40:47', '2020-05-02 07:40:47', '2021-05-02 13:40:47'),
('688588fba2463dc6e17f3b63730219dbd6c02f215df8ce1ab44b6b2410f6a2b30334bd8c9dcf3e98', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:15:55', '2020-04-12 22:15:55', '2021-04-13 04:15:55'),
('69d6fa3cf85cd1653dd9f1ab2385bb119c96b6fa68a7832a50d38e58a9a83ebdb401c45bb9f0383f', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:30:55', '2020-04-09 21:30:55', '2021-04-10 03:30:55'),
('69f45b69cbadad6d31a97e4d7e4e12fe8a8a2666ff3ac81979406539dca44eac639f28ad2201a91f', 21, 1, 'LynktoORCSsirajueel@gmail.com', '[]', 0, '2020-04-28 01:52:45', '2020-04-28 01:52:45', '2021-04-28 07:52:45'),
('69f98e778d1214ee83163d9cb48bdc11b66ae7d45f5dc4fcefb7248cdda88c49358453e8a540502e', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 21:53:52', '2020-04-12 21:53:52', '2021-04-13 03:53:52'),
('6aa10eb320d67b5cfa35224641152dd1e72be48e5bd78e8c661dc1fa7feb2f26b56846340a3828b7', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-15 06:10:49', '2020-04-15 06:10:49', '2021-04-15 12:10:49'),
('6e0c98633148e4245f8e966299ce2ea68e50efc7f05a1528391d15988d3ff29e1d22d23038e68fe4', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-20 20:11:59', '2020-04-20 20:11:59', '2021-04-21 02:11:59'),
('6fbd4120b4d7cea347659b9aabdbe366c029aa4485970cd869d5580fc3e2671d1cbc9dd28da34439', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 23:21:14', '2020-04-12 23:21:14', '2021-04-13 05:21:14'),
('7104f5acfda60dbf438d379ef0c4ba4c234d014b43bfc9bc4b96c32d6e5f79fce6060627318fdd29', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:26:40', '2020-04-12 22:26:40', '2021-04-13 04:26:40'),
('7315d68e0e499bd6bfed9ab4c89ab8eefba92b59fb247fb9396e7b0d78d655bd6dd28d79036055cd', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-05-03 21:10:54', '2020-05-03 21:10:54', '2021-05-04 03:10:54'),
('74d305beb13a35820506a40db99b60d440b9a638c87730d9a8bee02702cc2e1d8d64ac47af3a293f', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:03:43', '2020-04-09 21:03:43', '2021-04-10 03:03:43'),
('754d6b2f6147c1c56d6b010a172fac47a2f2f12d3fba6e96c054ab72ca18bb5ae44dcce58953f1a2', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 03:29:26', '2020-04-29 03:29:26', '2021-04-29 09:29:26'),
('7675c39b9db35ec5b90eb65f74f9b270c02c702d774628c1e88d40ce55c4ab4dc7089885616335ca', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:31:18', '2020-05-03 22:31:18', '2021-05-04 04:31:18'),
('7859ce987ed10a2a4102b13c95589c7c7769d3fbf045589e41f122630bf52dad38bb716012ebecae', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:42:18', '2020-04-09 20:42:18', '2021-04-10 02:42:18'),
('78c7f8757c5126b4e7ac80e7e1c69c75f75590706951f5e8188bd565e96df68228623c5cd9dc448a', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:14:13', '2020-04-09 21:14:13', '2021-04-10 03:14:13'),
('78d44a9cdc670b47c642f855c7f51efe58f879197e89de5152b9c591a35e498cf4bc13cc899a8205', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 20:35:40', '2020-05-03 20:35:40', '2021-05-04 02:35:40'),
('7b0bf98387bb24d1766fe819d90c797262c26b178023ba36f9d2001d32cb896cf9a36135f2ebe857', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:09:52', '2020-04-29 01:09:52', '2021-04-29 07:09:52'),
('7b66539893cf94b9ba13457bcf75ab01bb3d6b930fc1afc0a262a10e1108b91dff085f7f414c7d46', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-15 06:15:14', '2020-04-15 06:15:14', '2021-04-15 12:15:14'),
('7dd10af4fcce900175ff5ee2241d17e04ea1b4732f4ea5077535a7a0b302cf736603c6b813fa25a5', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 21:57:01', '2020-04-12 21:57:01', '2021-04-13 03:57:01'),
('7e390070ccdb1e2333916adde71518e9222ad317ec4c589f65a9fda8edb4f291b3dfd4f712473c72', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 07:05:40', '2020-05-02 07:05:40', '2021-05-02 13:05:40'),
('7feebd5ca48fa4a65976676339533bfc7138ddffd0797f648853f34e9c9ff59bde81db5de1a75399', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:53:20', '2020-04-12 22:53:20', '2021-04-13 04:53:20'),
('80ee4431833bdb5963685ef5fe8d30b3e2a0561bd67c3cccd21062db7942dc04b6a7302a8f3569e2', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:41:58', '2020-05-03 22:41:58', '2021-05-04 04:41:58'),
('80f91fbe74f7466bc5cccca4411f3707ee0a1352a950a1223719afb569db0773deaabde48156539b', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-04-29 16:19:10', '2020-04-29 16:19:10', '2021-04-29 22:19:10'),
('81b6e314e8b3c9bda8e0656cfcd345ff9fbd5041d5a5cea9c622da90fbff55b8aca0b90a8e37bb7d', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:07:32', '2020-05-03 22:07:32', '2021-05-04 04:07:32'),
('822ad4920a82ef8b253c8da34f7769c0f795d39258e9f5b09f6575bc2d60901ff32bbe976f6cab98', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:39:01', '2020-04-09 20:39:01', '2021-04-10 02:39:01'),
('82d0cdde644db2ab4f3f53e055493fbf80ee8c6dd27be7ea37208ad37300e5a0ac7dadcd8302bc74', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:42:44', '2020-04-26 16:42:44', '2021-04-26 22:42:44'),
('83e3b1f18ca77667fc253fe282f7e89815f3bd5b59d1c6072cb3090adb78798f53b8c5ceea0f966f', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-24 14:28:13', '2020-04-24 14:28:13', '2021-04-24 20:28:13'),
('84084fc6cb16f4f3438d3ac08a3750fd92431ccce22bb2348b7458eb46690946de07c2890fc43d44', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:05:10', '2020-05-03 22:05:10', '2021-05-04 04:05:10'),
('84d087867c577ef134759910a230ac453619c26409a3e5f89baa8b86fc102a06834c507577722721', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-01 16:41:36', '2020-04-01 16:41:36', '2021-04-01 22:41:36'),
('85d8e1d4189134cf1bee475b8a78b09f6c0ff4adf6e68567f6806b9f3115910124c61d983b86c3bb', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 00:45:06', '2020-04-29 00:45:06', '2021-04-29 06:45:06'),
('86d4ca0883d023bdc32f1b63350c6ae20981ad09223a46009bcea6acd293129a51fbfdbbc9c0eaa1', 18, 1, 'LynktoORCSohid1@gmail.com', '[]', 0, '2020-04-28 01:46:39', '2020-04-28 01:46:39', '2021-04-28 07:46:39'),
('88cf5f49d594a05a1ebbb09f29ecece3d52cc70424afa5acabd2f4d535905c75445df38544531699', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 06:13:43', '2020-05-02 06:13:43', '2021-05-02 12:13:43'),
('8a5ce0c3ca7b0b1a429cc02b26b4e3173a56f3da2e0b1f1830e89191d5ecab1449dd2f3d2b06c204', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-04-29 15:32:50', '2020-04-29 15:32:50', '2021-04-29 21:32:50'),
('8adc3b2b7a36597780a81c78542ade58dd787a771a289815b26583b3d27e125fc6c8ba3e9782e47f', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 02:29:30', '2020-04-29 02:29:30', '2021-04-29 08:29:30'),
('8b2ea149dc0e9ff293083f261235b998dbf1a8094de62b43c380d139df91f3feb5e11fa6b99dcbc6', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 16:13:35', '2020-04-09 16:13:35', '2021-04-09 22:13:35'),
('8cbf7e41d36e229d7ce8d9eacdc784fee98ecd7c1bf485991981e0c2160ff93fc0675e5e64c77a2b', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-14 14:25:58', '2020-04-14 14:25:58', '2021-04-14 20:25:58'),
('8d54a2130e03d19dc6ceb81701a7144928c50e07134119f9ac0f3c19119b180b8b65cef899360b1c', 15, 1, 'LynktoORCSmirajul@gmail.com123456', '[]', 0, '2020-04-28 01:31:32', '2020-04-28 01:31:32', '2021-04-28 07:31:32'),
('8d59f9eb7417d6908ed3a7ff6cb0918636d263f2b355f34845856b57284d9604e238055136610a39', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:40:15', '2020-04-09 20:40:15', '2021-04-10 02:40:15'),
('8df338bb09f5183271ce1bf19d331f26b0b8fcda6790397982b62cf9804e26b3e6d9cfe547580e32', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:42:55', '2020-04-26 16:42:55', '2021-04-26 22:42:55'),
('9032ee3cad3da2bd1d8ed2537102e4d8784a8551b6b47d4d7272e758a69b491d2b3da6880a0ca17c', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-15 06:33:01', '2020-04-15 06:33:01', '2021-04-15 12:33:01'),
('90548452780667afd8ec71c95a1ad30b98ea1ff7948950a00796176dbae454ba377494420397e1d0', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-24 14:10:51', '2020-04-24 14:10:51', '2021-04-24 20:10:51'),
('90ec78da61f0c15bfa479cc15bcf4c830d3f3775eb3d10b13a6aaef43c9c0f9ee8bb129e74fafb3a', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 06:22:42', '2020-05-02 06:22:42', '2021-05-02 12:22:42'),
('939efeb9f352cc96e684c050037c7293cd363293bc02a6d823fb6485760d46f2274a1d2e9d1acb2f', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 17:03:02', '2020-04-26 17:03:02', '2021-04-26 23:03:02'),
('943d11426e2cc2b53eb5f43df3db5f12911a7f06db3b555324ec27699a171c127c392abb23dbcf96', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:18:01', '2020-04-29 01:18:01', '2021-04-29 07:18:01'),
('945512edc597e2201b178559ac9c2a71280f095f0c3a7d75543d398d4e71af4ab6f15d56fda06f6c', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-21 00:41:30', '2020-04-21 00:41:30', '2021-04-21 06:41:30'),
('9524502f3e5e97f42ec2dc8dd5ad8ba42a1276370402d76d63d224a5c8f3c159e1e091a9b14da707', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-04-30 15:12:00', '2020-04-30 15:12:00', '2021-04-30 21:12:00'),
('9566776a384c43ccc7943fe41abbafd33f17020602826f0b5d166a7aa4a9aecdae5d1768e0ab937f', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:03:21', '2020-05-03 22:03:21', '2021-05-04 04:03:21'),
('964f6977f4937b12c34004d6772c325b4bccdc93715750f1b404cae28704102a405ede72da3ffd0e', 17, 1, 'LynktoORCSohid@gmail.com', '[]', 0, '2020-04-28 01:46:06', '2020-04-28 01:46:06', '2021-04-28 07:46:06'),
('9675994d06d41b72404738d74df7234c721bbd9ea7272bd3bca76daff96f922541b48b3cde287707', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 20:33:37', '2020-05-03 20:33:37', '2021-05-04 02:33:37'),
('9723903e8387fe1806bc42f44b56519c7476caa14ba254a877dc6f6285d6f9395b3ce9be68bb395d', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 07:13:17', '2020-05-02 07:13:17', '2021-05-02 13:13:17'),
('98c3db0209bfa663621385cbc89d0c7f691b9d9fb0d8513da2c18244e4f9eb3206664ca806921efa', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:44:40', '2020-05-03 22:44:40', '2021-05-04 04:44:40'),
('9aa251f42cfd49bfdf9bcfc98aebdbb4a0436f8a863b1c5a4f9edf7e1001aa5671e953b5cff4cb8f', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-14 22:55:10', '2020-04-14 22:55:10', '2021-04-15 04:55:10'),
('9b86c1c690dae5f8f5017318c7add13aca29353526c18764b449d82848f20b0253d03298f3d420df', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 23:19:23', '2020-04-28 23:19:23', '2021-04-29 05:19:23'),
('9c23499f2ac0fabbf0ac3fb87fcb8d75d1d69f303b8f14ec3af8a8fd0e38c3e0d51d2212b1ca8548', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:43:02', '2020-04-26 16:43:02', '2021-04-26 22:43:02'),
('9c58991d8808632df262b663fb2732c11b6277660205b28dd75f25b09a260a256b62459bfe16c2ed', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 06:54:31', '2020-05-02 06:54:31', '2021-05-02 12:54:31'),
('9e55c204908eb8250a628b9489212778460d323e12f5c550f34e48261f8ada32b1f08970725e638c', 11, 1, 'LynktoORCSkader@gmail.com', '[]', 0, '2020-04-12 21:31:57', '2020-04-12 21:31:57', '2021-04-13 03:31:57'),
('9ea58c084b0e102ade2c58fb05077b85e03ecc586ae0462b6b2028d752048436cb3e689d180627f3', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 17:05:33', '2020-04-26 17:05:33', '2021-04-26 23:05:33'),
('9f78d9c4893fde309361e3d22f542fc8a3deea62ecf450245545dfeef6a170217ceaebb3058b49ba', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:16:24', '2020-04-29 01:16:24', '2021-04-29 07:16:24'),
('9f9a50ba688f74b28a2f7b52940280fc27b782a3b5215683d192663b90c8b320b806f02f3a6ce7b8', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 17:04:27', '2020-04-26 17:04:27', '2021-04-26 23:04:27'),
('9fbe5537753fcfd6b2abbaa1c41a0ff6973f28a8c1e8c3693f3888701c6d993d30a9f390f035066d', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:16:48', '2020-05-03 22:16:48', '2021-05-04 04:16:48'),
('a00533d2cb81372a68d62a9d1a5fbd020ed2f3cf91c059406dcddb737cdd9f2e639dcefe1c02c7fe', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-27 13:56:36', '2020-04-27 13:56:36', '2021-04-27 19:56:36'),
('a061994dcf8e9bb9094774dcaf17f76ed7cf6127ee88f2e335fff90c33c589d5434480196abb2871', 23, 1, 'LynktoORCSsir33aju3eel@gmail.com', '[]', 0, '2020-04-28 01:53:17', '2020-04-28 01:53:17', '2021-04-28 07:53:17'),
('a243ae42ac41d48dbcae864e3152cae213175114776c3f6c77abfc1570731c9c117bde30b5c38b53', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 06:22:07', '2020-05-02 06:22:07', '2021-05-02 12:22:07'),
('a27ec2f445ec95f549b2704cd7656d13ad81dff51ce89e92f99218d97ac7323a319a109b079f395c', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:47:12', '2020-04-09 20:47:12', '2021-04-10 02:47:12'),
('a45d1a32f0904c31958cee64b4681a5010d70f4d24a73853e5dd02447649cbfbd870419f07a6b824', 15, 1, 'LynktoORCSmirajul@gmail.com123456', '[]', 0, '2020-04-27 23:00:24', '2020-04-27 23:00:24', '2021-04-28 05:00:24'),
('a4ae0bfff3001efcd98ac220ebdbb07186e98d981251422ec033a161ced34466bbfa44f1d36e3918', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:09:09', '2020-04-29 01:09:09', '2021-04-29 07:09:09'),
('a58f269ea31bb67164a54e828809e5e962587ef829aa0ab9fd663ad5962884ff70f04f958e26531a', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-20 02:23:40', '2020-04-20 02:23:40', '2021-04-20 08:23:40'),
('a70fd206221040c7203b0abdd15e43078bafe00d3895fe266304564303326aa46e312622c2bf8dd2', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:03:30', '2020-04-29 01:03:30', '2021-04-29 07:03:30'),
('a96c8bde2ab5e76e10d99ba8e263ac5e6aa78887455ea2020a69876b98533f42ef5cb897953964c2', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:42:51', '2020-04-09 20:42:51', '2021-04-10 02:42:51'),
('a9abed81f04b504e595c737123b7cb64e90468f31d6369915ca3b2ca8a90e5de24cb01a610da624f', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:28:32', '2020-05-03 22:28:32', '2021-05-04 04:28:32'),
('aa750667aa6dcc29b530cf5f59686754ef055f60388985c6875dfef334fe5d3acea219330c551d99', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:17:20', '2020-04-12 22:17:20', '2021-04-13 04:17:20'),
('aac9abe17f64249e84b737d429eb6d7d84373ca83a97dcc0c27dda428b41b0588019056330b467b2', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:07:35', '2020-04-29 01:07:35', '2021-04-29 07:07:35'),
('aada05cc6789d412e4f98ac123525ada11c504325fd9b0663f48dfbb777f1b2810b2cb39b9cd9c0f', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:42:04', '2020-04-26 16:42:04', '2021-04-26 22:42:04'),
('ab3bc02dd36de839565cc163c631f6bcab5f9dc066e49fc95b680520e0b5f96256ed98ee9f6930cb', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:33:02', '2020-05-03 22:33:02', '2021-05-04 04:33:02'),
('ab760af7e0a8b311d964fbc6efb6f0f0e45180da62f4a9cc84f0d80ef2cfc1098e5cc76592ad6786', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 22:59:02', '2020-04-28 22:59:02', '2021-04-29 04:59:02'),
('aba63b904769f753d9c4c91a5f0f0551a1e6d841ccf35bb59698ad691109ac164001cd7f474f9770', 27, 1, 'LynktoORCSdipti@gmail.com', '[]', 0, '2020-05-03 21:19:48', '2020-05-03 21:19:48', '2021-05-04 03:19:48'),
('aba886dcdb24e15971fa619abe1c897167e1c3761d2072b840684338b4b843f6aa7ad711e0e96867', 15, 1, 'LynktoORCSmirajul@gmail.com', '[]', 0, '2020-04-27 14:19:18', '2020-04-27 14:19:18', '2021-04-27 20:19:18'),
('aca67e7a86000d400fe41502a96a1c592b9c8de7261c4fcba515169db8428a38b8061a3e6cb21493', 16, 1, 'LynktoORCSsirajul@gmail.com123456', '[]', 0, '2020-04-28 01:55:06', '2020-04-28 01:55:06', '2021-04-28 07:55:06'),
('ad65c0277adac8a57aad000e4f2487ec4c49088c0471779f50041dd69ed483263b300264fc03be49', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:43:19', '2020-04-26 16:43:19', '2021-04-26 22:43:19'),
('b029dd280b92b0292ff93dd43123ec3a7b5fbc5c3b0b9aec4a87b1230daab0e2d3df7375a5771baf', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-01 16:55:14', '2020-04-01 16:55:14', '2021-04-01 22:55:14'),
('b1ac785fed5349a037d66a34f67cb5fd552a6388c8b83d6cfcd5875d444e573d8137ace34d20fe97', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-01 16:43:34', '2020-04-01 16:43:34', '2021-04-01 22:43:34'),
('b2fc9bdca62cb5d3dc36d7641013e81200cb74076e284204a567156451361fbeea9a33683d26940c', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-24 14:19:18', '2020-04-24 14:19:18', '2021-04-24 20:19:18'),
('b47d9752d32ec355701d19d03e503a1f4f2a995aaa16c911b17bbb54c44ed48fa65db2e1a4c74423', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-21 03:02:47', '2020-04-21 03:02:47', '2021-04-21 09:02:47'),
('b5c699963f7663241dee2d6fc6c8bf3d5615b12e472a49887638467b763e8fa249f14ca1320be501', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 20:33:10', '2020-05-03 20:33:10', '2021-05-04 02:33:10'),
('b6c3989b6d97c29ab437ae1d4454e4a9035e418c8dec23f085039483919bb22448824a6b0536abd0', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:16:50', '2020-04-12 22:16:50', '2021-04-13 04:16:50'),
('b7843f54a7ba45ce02c21b164e4358d2b1016c51deedd6cd90dd4c087bb7555f476e12f9d2426950', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:43:35', '2020-04-26 16:43:35', '2021-04-26 22:43:35'),
('b9a87b221b2cadf958d11fe9bf6e5e15b85f29cfb58ddcb41270f01c7b2562d4ad9b7f40aa6e2fe0', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 07:34:59', '2020-05-02 07:34:59', '2021-05-02 13:34:59'),
('ba052f1d00d1b3a3003da4fa002ac7c2c8f183831bc29fa8fa5fcd940dde60a5a1ff338674096bb4', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 06:21:34', '2020-05-02 06:21:34', '2021-05-02 12:21:34'),
('ba3e4c7bc6e792d33360f72ff96a0514e97c61686c547157318fa2c365a115398c8313cd46c96f34', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-04-30 20:36:04', '2020-04-30 20:36:04', '2021-05-01 02:36:04'),
('baade0bffd7e357e313f8550e616d7f695f03860e2fc36be5702f1eb6d31725749c754d415a14780', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:04:01', '2020-04-29 01:04:01', '2021-04-29 07:04:01'),
('bb899328b2a6a09971fffa3daf067e9c9eb22700d44b178a430d9cf886fa8979395c3c00146f4120', 13, 1, 'LynktoORCSmorad@gmail.com', '[]', 0, '2020-04-12 21:44:00', '2020-04-12 21:44:00', '2021-04-13 03:44:00'),
('bcbd16accdfb0c572b224c6231d83339f7cadf348a47ba651a9f56caae92e4fbd02add99f9743f47', 12, 1, 'LynktoORCSkader@gmail.com', '[]', 0, '2020-04-12 21:33:02', '2020-04-12 21:33:02', '2021-04-13 03:33:02'),
('beed995a008fbf4e0d12bf168b96b76d2a39b42a0bf4c20ffb06663499e52045d482fb5a67a19532', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 07:14:09', '2020-05-02 07:14:09', '2021-05-02 13:14:09'),
('bf70eacf67156f25ce84985c1c3caef1a882d7369d08b95ffc42c55cbb4cdd96c209e02bef4c1a8d', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:04:45', '2020-04-29 01:04:45', '2021-04-29 07:04:45'),
('bf994310341f8e60edfbea3d2e17cc74ec0c81c957d76d7ea1d52ad934e84b93273e13bdb98d8280', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 07:06:58', '2020-05-02 07:06:58', '2021-05-02 13:06:58'),
('bfa1978d3d92012e929480b228384adb8deb7de32be8c65d9f272857dd60ced20590fe131285a4b4', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 02:30:47', '2020-04-29 02:30:47', '2021-04-29 08:30:47'),
('c2d7cccfa8b56a1702938e9e394fdfd095b08af02dc881a04ffda9823f1cf7981fe449cd025e46da', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 20:55:26', '2020-05-03 20:55:26', '2021-05-04 02:55:26'),
('c2fd51b3d383a6241f20e6eca2313dba7a18c86d7eea2d15b3774c1ba86b29e35c5f951f1b47abdb', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-15 06:17:39', '2020-04-15 06:17:39', '2021-04-15 12:17:39'),
('c4c1426553c5e9519c216753fae9bde17bb0da52e84e8250af3cfc6703c839329d7841c5a8dffd87', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-10 19:59:48', '2020-05-10 19:59:48', '2021-05-11 01:59:48'),
('c4f694e64e93e2107ed6eb7351454f25e9f6fe838957f2be6565aee234c5d9de42cca20f1c72db27', 16, 1, 'LynktoORCSsirajul@gmail.com', '[]', 0, '2020-04-28 01:44:02', '2020-04-28 01:44:02', '2021-04-28 07:44:02'),
('c5409e9faf1ee2564131fc03162e838628e7139e7432a44f59b5a73790a0f849fc3544fdf66d98a2', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 16:51:08', '2020-04-09 16:51:08', '2021-04-09 22:51:08'),
('c68f22f3510e94506c30af1e38f171a57c0dc086007df7555ceb59aff0b3ae916cc2f389bbe3f336', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:59:02', '2020-04-26 16:59:02', '2021-04-26 22:59:02'),
('c758ccf91fd5d4ef6cc44befcdd3cb8b71e72d126b0c4a760dab2800698d0102d79169aac9ab9cf5', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 08:07:41', '2020-05-02 08:07:41', '2021-05-02 14:07:41'),
('c75e1dfe0f2c89cc34969e95e831e3fba635d3f89f5cfe75c0fc75ae4b2d85046766d8eacc47b214', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-28 23:18:57', '2020-04-28 23:18:57', '2021-04-29 05:18:57'),
('c82a4e9c7da8473834c11e04dc983227c0dd2ec394348b52f4acb2614313b0fc403d84cc0c456214', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:00:51', '2020-05-03 22:00:51', '2021-05-04 04:00:51'),
('c90405bbd3d20d672451b84dd2ba9d0c541d999297b103f70548b1786824360cdb31286746320968', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:43:15', '2020-04-26 16:43:15', '2021-04-26 22:43:15'),
('c9893f902b45da463d469e188a5db88ba774271f4fdd818ec388e6c3a73586eefc547d067bd3d8c5', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-16 12:09:46', '2020-04-16 12:09:46', '2021-04-16 05:09:46'),
('ca9afa2e2e2f91ca0a928317e5a9ddc3508b7fbb217e2427482c9d401501cad2d1406a961c11f000', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:43:25', '2020-04-26 16:43:25', '2021-04-26 22:43:25'),
('caadf9ca481deb94bbdafc926207c4982af37dc19f82d2c2344ccc7b75ff7fdfcd11f681ffa327b7', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:00:28', '2020-04-29 01:00:28', '2021-04-29 07:00:28'),
('cafa85f6c0cfbed3dcb5616461e04c387c84337faacaf1931b0a48f0decd77fa533c204dc25d7fb6', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:41:51', '2020-04-29 01:41:51', '2021-04-29 07:41:51'),
('cda44b83142b57f7325f5464577940e400f1bcf8535df0142d8f1f8ca384c06e98a0ab6ec3f8fe64', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:06:14', '2020-04-09 20:06:14', '2021-04-10 02:06:14'),
('ceda53e364027cb198b83d936633b86887ac8e8fcc708899b92cbf0202f1c1caec6706b05557cdc9', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-02 06:48:37', '2020-05-02 06:48:37', '2021-05-02 12:48:37'),
('cf8c1e4ec1e3f93858086a1587b349225cc180fcf1937fdbf3c861360ce4f09c3589027e0888a9b4', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 00:59:41', '2020-04-29 00:59:41', '2021-04-29 06:59:41'),
('cfd161b38797134f6015eb576866568daeb8d72f1161a712551fb21f47e222ec3a533f53fc51dde8', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-27 13:48:34', '2020-04-27 13:48:34', '2021-04-27 19:48:34'),
('d00a044258992ccceebf4df48c4c814dd714f2fbfc57bcc93a7e146e8fea3f426abe158f0f5ca909', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 17:04:14', '2020-04-26 17:04:14', '2021-04-26 23:04:14'),
('d023d3b1e374e5b9f24933881e2606473690e766b66f18074c1c2fcbea6ba70149292c44c6f71872', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-05-03 20:32:42', '2020-05-03 20:32:42', '2021-05-04 02:32:42'),
('d0ad76493aad7f2ed50725e643c1c3d44479771defdf956372b3fdf2e56769c7c69bbd02468de5c2', 16, 1, 'LynktoORCSsirajul@gmail.com123456', '[]', 0, '2020-04-28 02:00:53', '2020-04-28 02:00:53', '2021-04-28 08:00:53'),
('d229f000ae39e57a07b3b01764e7d2179332c56d2c22ad3b9d1985d3e2745f3a7558d5c47f323e94', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:14:16', '2020-04-12 22:14:16', '2021-04-13 04:14:16'),
('d3dee8cd3a7813ce648c292ff51730fd0bb021ad92b9bf0ab51a6013c9a8fb6b5a676098f2668dfc', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-01 16:43:40', '2020-04-01 16:43:40', '2021-04-01 22:43:40'),
('d568dc84182d2009afb66c865c16f76eca166fa012f249a13caedb3b19feb49c20ab729e1bc54493', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:46:43', '2020-04-29 01:46:43', '2021-04-29 07:46:43'),
('d7cfd10c3e39770eb9e646d69508aa30bbf8acc54a0fcba9a4dbe68e2a33798f504bcec8b453e2ce', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:14:01', '2020-04-29 01:14:01', '2021-04-29 07:14:01'),
('d9bcb773247be5adeb8ad15db3b27fb0f527b28e7cc408cda0b73f0d2265851fe3a39b05fbbaca5b', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:18:24', '2020-04-09 21:18:24', '2021-04-10 03:18:24'),
('da20967935da50e7057f9f70ed1edeacd8134c0a8bd1df8b6dc7192c5e39204bbcf5278fa138da6d', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:02:06', '2020-05-03 22:02:06', '2021-05-04 04:02:06'),
('da2845e3cb5e1bde603b40795636a90497c96f0fa613ed2ebbac825f6484b36d67a159deb57864d6', 19, 1, 'LynktoORCSsirajul@gmail.com3', '[]', 0, '2020-04-28 01:51:05', '2020-04-28 01:51:05', '2021-04-28 07:51:05'),
('da9da3bfd14ef3ca24d489492e14e34b69a82005a1b02a9444312acccd0f6e9e072d982f1347fc05', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:12:02', '2020-04-12 22:12:02', '2021-04-13 04:12:02');
INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('dbb87453243bd2aa4c2e7eee8400eec28142ddc9ab00845903f92f3da36c645d3eb6202b877a3c3a', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-21 00:40:33', '2020-04-21 00:40:33', '2021-04-21 06:40:33'),
('dc0deedd74516b6517ef8c0f509a6d3cfa9b3e38121dfcd4439db7a04beac46c6c71fceba34f6c76', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-21 03:02:44', '2020-04-21 03:02:44', '2021-04-21 09:02:44'),
('dcf281d5b784bb08d26891015ab6bc00ab9e22df4ec4a99af8fd32846011e131dbcdd5e1ab2015ab', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:22:31', '2020-04-29 01:22:31', '2021-04-29 07:22:31'),
('dd61e6c406b7b36f33ae8a37beb2d7045e3f059c00df242ddce4bd4ed69e2ccd01399abd12ffff69', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:47:07', '2020-04-09 20:47:07', '2021-04-10 02:47:07'),
('de4d6f2c0d2cb57fbf7558846b2701a192c44e283fba8af1916c55b635330ca4096945f624f0e78e', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:13:05', '2020-05-03 22:13:05', '2021-05-04 04:13:05'),
('dffbc69ceee24158492c272ece3280f7e6a3ed79dce3e709fc5c9d69b6c6c555c7c68c3d280fdb10', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 00:47:34', '2020-04-29 00:47:34', '2021-04-29 06:47:34'),
('e2c819b5aeb8c33de627ff6c831080c561cf47927c32d35f303eda662f474a2f8b832076d566436e', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:40:13', '2020-05-03 22:40:13', '2021-05-04 04:40:13'),
('e34a2aaf629dd309feb9a38c8ef42e76a5a055229df0b24d4849ab796e2a657544d9841cd9dd1759', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 20:40:08', '2020-04-09 20:40:08', '2021-04-10 02:40:08'),
('e4d9c09815c76a6f05357c5a72669da02d8c8f2415e683f2ffb72b14debebe58ab50d081ad218018', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-25 02:37:07', '2020-04-25 02:37:07', '2021-04-25 08:37:07'),
('e94830211cd4566bffbb944d80d2e990a977549fa279abcf4d740670871eca059d5b0a644e25d78d', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-15 13:21:57', '2020-04-15 13:21:57', '2021-04-15 19:21:57'),
('e9664fbd39c63aaa48478638f49cc573f3cc7e526315bc349c4d2304244c1661c94bc79b7347cdba', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:53:20', '2020-04-12 22:53:20', '2021-04-13 04:53:20'),
('eb7ede780bfaf868d985e2bad60b3cf3b35f0b7acc515b04563d994c27be74b0b8f410daf70b599b', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:02:53', '2020-04-09 21:02:53', '2021-04-10 03:02:53'),
('ec43e688639ca42fb1c857bcb26010eec0ff130504accef4a0876c507e284a123ff0f5ed2491f314', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 00:43:40', '2020-04-29 00:43:40', '2021-04-29 06:43:40'),
('ec6462e66b53ad07bc0c8e020c0943f213b655cda019f8dda2a27e016b5adcb377e0617eed718567', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-09 21:13:53', '2020-04-09 21:13:53', '2021-04-10 03:13:53'),
('ec65ecb922dde9f93a15332ec92075ce859cb09566fb3947e393ab511ba7fada7055c718cf67b1b3', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:53:21', '2020-04-12 22:53:21', '2021-04-13 04:53:21'),
('ed73695da36fb65b198441bd18b5a87691d1c5b6718ac0889f8d2f0516cf1dc91280f99cc5f2e069', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-23 04:21:08', '2020-04-23 04:21:08', '2021-04-23 10:21:08'),
('ee1c89503c6de25e5e69e6637c5936afd1101dd026050fa632e1dc2e21c734f529e1f80930d04acd', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-25 01:33:10', '2020-04-25 01:33:10', '2021-04-25 07:33:10'),
('ef05c5692ce3c5dc9e3fa0a697a2bee9f348394aa9e3ea0e4544918fd156f6ef40f3d73acce0a1c6', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-12 22:27:37', '2020-04-12 22:27:37', '2021-04-13 04:27:37'),
('f33a45c4dbe9f23579e165b64c5b4ff65c2deac9275997f863f93a4f740c36ff527c3c2137c7fc86', 25, 1, 'LynktoORCSsiwerraju232l@gmail.com', '[]', 0, '2020-04-28 01:53:40', '2020-04-28 01:53:40', '2021-04-28 07:53:40'),
('f45bff8d9ec1744de2b1606a19a514537217abdb9b8f630d7b9321177db21b66391b43223284716d', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 17:01:23', '2020-04-26 17:01:23', '2021-04-26 23:01:23'),
('f524d42c5dccb628175aa2215fcc9e70ea5f513179381f4418a6c83ac36d63be519b2c3b98559508', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-25 02:34:45', '2020-04-25 02:34:45', '2021-04-25 08:34:45'),
('f7fd7bc37eaf73fc3fec26232ec25bbcb8b2a9060c5479498bde1db0433d9481007d96a26f9e853c', 29, 1, 'LynktoORCSdipeti@gmail.com123456', '[]', 0, '2020-05-03 22:09:04', '2020-05-03 22:09:04', '2021-05-04 04:09:04'),
('f83a3db89947460f7097bea90d7ff44d0aa86b1ac2e20da61614e51390a2ca1f219c3cbb2a2e8df5', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-26 16:43:08', '2020-04-26 16:43:08', '2021-04-26 22:43:08'),
('fa263c59d8ae125b592170c7120eb83fa3a59f83fcdcde3f92e22658a58106634d88f33bf3305c53', 10, 1, 'LynktoORCScsenazmul96@gmail.com1234567', '[]', 0, '2020-04-30 15:02:34', '2020-04-30 15:02:34', '2021-04-30 21:02:34'),
('fc0a7cc7fb9f2790ba424054f3f3be7c68ed9391111303c5d762404422fff5005dd3062157449fb3', 10, 1, 'LynktoORCScsenazmul96@gmail.com123456', '[]', 0, '2020-04-29 01:00:20', '2020-04-29 01:00:20', '2021-04-29 07:00:20'),
('fc320c47d43fc9106235cc411e156420edd0caf1947cf84f41cee7771532913014dd2c01bc57ae36', 10, 1, 'LynktoORCScsenazmul96@gmail.com', '[]', 0, '2020-04-14 22:39:52', '2020-04-14 22:39:52', '2021-04-15 04:39:52'),
('ff32d06c4a75d59bff4c8d73561e2bb588e3394d72de1659127b0b22338ca380a6303fa5cd5ce756', 16, 1, 'LynktoORCSsirajul@gmail.com123456', '[]', 0, '2020-04-28 02:23:32', '2020-04-28 02:23:32', '2021-04-28 08:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'Id5iI5aFNyYWqcQZwqauSVw7DwnDZunPh6J06oXM', 'http://localhost', 1, 0, 0, '2020-04-01 16:40:16', '2020-04-01 16:40:16'),
(2, NULL, 'Laravel Password Grant Client', 'ApMfDgE36sWUG5BSljen1Iz2OO69pFP5esFhdCMR', 'http://localhost', 0, 1, 0, '2020-04-01 16:40:17', '2020-04-01 16:40:17');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-04-01 16:40:17', '2020-04-01 16:40:17');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL,
  `aStatus` enum('Failed','Success') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rejected` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `order_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracking_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address_id` int(11) DEFAULT NULL,
  `shipping_method_id` int(11) DEFAULT NULL,
  `shipping_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_state_id` int(11) DEFAULT NULL,
  `shipping_zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_country_id` int(11) DEFAULT NULL,
  `shipping_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_location` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_unit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state_text` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_state_id` int(11) DEFAULT NULL,
  `billing_zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing_country_id` int(11) DEFAULT NULL,
  `billing_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_number` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_full_name` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_expire` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_cvc` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` double(8,2) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `points` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `used_point` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `reward_point` int(11) DEFAULT NULL,
  `reward_percantage` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reward_fixed` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used_dollar_point` int(11) DEFAULT NULL,
  `dollar_point_discount` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_credit` float NOT NULL DEFAULT 0,
  `shipping_cost` double(8,2) DEFAULT NULL,
  `total` double(8,2) DEFAULT NULL,
  `note` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin_note` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `can_call` tinyint(1) NOT NULL DEFAULT 0,
  `authorize_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stripe_payment_info` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_payment_id` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_token` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_payer_id` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_amount` double(8,2) DEFAULT NULL,
  `coupon_type` int(11) DEFAULT NULL,
  `coupon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_coupon_id` int(11) DEFAULT NULL,
  `coupon_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `promotion_details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `free_shipping` tinyint(1) DEFAULT 0,
  `promo_type` int(11) DEFAULT NULL,
  `promo_ammount` double(8,2) DEFAULT NULL,
  `promo_percent` double(8,2) DEFAULT NULL,
  `confirm_at` timestamp NULL DEFAULT NULL,
  `partially_shipped_at` timestamp NULL DEFAULT NULL,
  `fully_shipped_at` timestamp NULL DEFAULT NULL,
  `back_ordered_at` timestamp NULL DEFAULT NULL,
  `cancel_at` timestamp NULL DEFAULT NULL,
  `return_at` timestamp NULL DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `status`, `aStatus`, `rejected`, `user_id`, `order_number`, `invoice_number`, `tracking_number`, `name`, `email`, `company_name`, `shipping`, `shipping_address_id`, `shipping_method_id`, `shipping_location`, `shipping_address`, `shipping_unit`, `shipping_city`, `shipping_state`, `shipping_state_text`, `shipping_state_id`, `shipping_zip`, `shipping_country`, `shipping_country_id`, `shipping_phone`, `billing_location`, `billing_address`, `billing_unit`, `billing_city`, `billing_state`, `billing_state_text`, `billing_state_id`, `billing_zip`, `billing_country`, `billing_country_id`, `billing_phone`, `card_number`, `card_full_name`, `card_expire`, `card_cvc`, `token`, `payment_type`, `subtotal`, `discount`, `points`, `used_point`, `reward_point`, `reward_percantage`, `reward_fixed`, `used_dollar_point`, `dollar_point_discount`, `store_credit`, `shipping_cost`, `total`, `note`, `admin_note`, `can_call`, `authorize_info`, `stripe_payment_info`, `paypal_payment_id`, `paypal_token`, `paypal_payer_id`, `coupon_amount`, `coupon_type`, `coupon`, `default_coupon_id`, `coupon_description`, `promotion_details`, `free_shipping`, `promo_type`, `promo_ammount`, `promo_percent`, `confirm_at`, `partially_shipped_at`, `fully_shipped_at`, `back_ordered_at`, `cancel_at`, `return_at`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, NULL, 0, 10, '4WP1136W8F8AT', NULL, NULL, 'Nazmul Hasan', 'csenazmul96@gmail.com', NULL, 'Next Day', NULL, 1, 'US', 'asdfa', NULL, 'asdf', 'AZ', NULL, 4, 'asdf', 'United States', 1, 'rfer', 'US', 'Mokampur, 12', NULL, 'khulna', 'Armed Forces Africa', NULL, 60, '9220', 'United States', 1, NULL, 'eyJpdiI6IkNGVEhcLzJMT2JnVUZ5Z2F1Zk9IbHBRPT0iLCJ2YWx1ZSI6Ilg0ZFVGdTYxU1lMMThhXC8xOUZQbEsrSW1kcWQwc05cL2FiVUZUbEZxZ0t2QT0iLCJtYWMiOiJmYWM5OGNkYzUzMDUwN2VlNmU1ZGM0ZWNkZDFjNGI4MjIzNGYzNGU3Mzk1Y2RlOWE4NTFmODAwMGM3MGFjNjgwIn0=', 'eyJpdiI6Im9CUEtsZzFIVDdUcjEyQzlaZzV4UkE9PSIsInZhbHVlIjoiYVFSSXdORjRsTHpKRWh0MFZleVVZdz09IiwibWFjIjoiYWNjYWY4ODMwMmI5ZjI0MmZiNWZhOGZkNjA2M2Y4OTg3NWUzNzUzZTEyMDUwZWVjZGQxYWYwY2EyZjVlYjQ4MCJ9', 'eyJpdiI6IlR1MnVUbTJMc1FXRUxKVnViZ3c4V2c9PSIsInZhbHVlIjoiOWE5Ym9LK3RrU0ZiaytSeGI2dm1tdz09IiwibWFjIjoiMDEzMjEzYmYyODUwZWIzYjVkMDlmZjkwMDQxMjAxYmM2NjlmMDJhZDM5NzJmNzE4ZDk4ODY1NDEwZmQyZGJlYyJ9', 'eyJpdiI6IkNBb091ckhQRHozUE9aVE9weHBOY3c9PSIsInZhbHVlIjoiSDFrTTdreFBkQ2xWbGtWdVdWcmdLUT09IiwibWFjIjoiNjZiNGQwOGMwMTA3OTI3Zjg5ZWU2MTFkNTA5YzcyMWNmYmNkOWE0YWVkZjdhYWEyZmJjMzNlYjYyMGQ3OGIwMSJ9', NULL, 'mastercard', 1334.60, 0.00, '66', '0', NULL, NULL, NULL, NULL, NULL, 0, 50.00, 1384.60, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-03 18:58:53', '2020-05-03 18:59:28', NULL),
(2, 2, NULL, 0, 10, '2VQA3X5JU4MEL', NULL, NULL, 'Nazmul Hasan', 'csenazmul96@gmail.com', NULL, 'UPS Ground (3-7 Days)', NULL, 2, 'US', 'Raj', NULL, 'gsdfgfga', 'DC', NULL, 10, '5656', 'United States', 1, '4576767', 'US', 'Mokampur, 12', NULL, 'khulna', 'Armed Forces Americas (except Canada)', 'Armed Forces Africa', 61, '9220', 'United States', 1, NULL, 'eyJpdiI6IlYwb1lrK0FIaWtyRGhrblVXZVZEMmc9PSIsInZhbHVlIjoiVnNqYnE1MjRjeFwvN3FWTDJ4UWZZUEhvaXBpMWVBSnZmMjlhcnVVM1o2aXc9IiwibWFjIjoiZmZhNDU0YzYxNTAyNTU2ZDdkMzhlOWNmNjFiOTFkYTFlZDdhZTEyNjViYWNkZjdiNjcyMTE5YTgyNDAzMGY4ZiJ9', 'eyJpdiI6Iml4XC96dXRIRFJSXC96djdlemM1UmNNdz09IiwidmFsdWUiOiJSYUx0REFBOWlIVWNRemZKeEd3M2t3PT0iLCJtYWMiOiI4YjhiZjQ5OWM0MjU4NTljYjc3MWU2NWQyZjcxM2JmY2Y5YWZjMjIyYjVjNDY0NzY3MmQ5MGU0Y2Y2N2U2YWVlIn0=', 'eyJpdiI6InFQYThEUGtnU1A1RWpHelRIQUUwYnc9PSIsInZhbHVlIjoiQ1o3bmRtakJUT1hnaTFqcVB2UWlFQT09IiwibWFjIjoiZDA0MzU3M2E2NDI4M2YzODE0YmY3ODM5ZWRmOGQ5ZDM5ZTgzMTFmYmJlNmQyZDlmZWM1YjlmOTJlYTkxZmM1ZiJ9', 'eyJpdiI6IlBEMGQ3OUNrZG16VUl3UEZQTjRiSHc9PSIsInZhbHVlIjoicjNBZTFhRjU1Nk5MQ0dTUm9GK09vQT09IiwibWFjIjoiOWMxNzRiZmI5Yzk0ODcwZjc5N2JiYjMxYzc4ODJhZjFiNjNkNDI5YmY2YWRiMTY1ZGY1NjFkMDI3ZDU4M2MwMSJ9', NULL, 'mastercard', 109.52, 0.00, '5', '0', NULL, NULL, NULL, NULL, NULL, 0, 0.00, 109.52, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-03 19:47:11', '2020-05-03 19:47:37', NULL),
(3, 2, NULL, 0, 10, 'X18D9H776UJNO', NULL, NULL, 'Nazmul Hasan', 'csenazmul96@gmail.com', NULL, 'UPS 2nd Day', NULL, 3, 'US', 'Raj', NULL, 'gsdfgfga', 'DC', NULL, 10, '5656', 'United States', 1, '4576767', 'US', 'Mokampur, 12', NULL, 'khulna', 'Arizona', 'Armed Forces Americas (except Canada)', 4, '9220', 'United States', 1, NULL, 'eyJpdiI6IjA1a0pPd0duY0tIV2JHMzJpTEE3SkE9PSIsInZhbHVlIjoiWndsOHZrRVlIZDhmR2NuNHlHVFhLSFEyWk84Zmg5ZXpUNGpUSFJWa2dOcz0iLCJtYWMiOiIzMTQ2MTA1ZDVlYjFiYTRmMDdlOWRiMzRkOTE1MGUzZjM4MGVhYjZhY2UxMWYyNTZjY2YxYTllZjhiOWVmNDc4In0=', 'eyJpdiI6IlZmbkNxNlBVYzU4QjlNTjljNDh0cUE9PSIsInZhbHVlIjoiK3dmS2lFQWJvalwvVDJmWDUwS2pVaWc9PSIsIm1hYyI6ImE4ZmE4MTkwZTI5NzFlNTQyNTU2YWUwMmFiZmM1ZTQ0ZmJiMmNhNDA2MmQxY2QyOGZlN2I2YjY3M2JhZDE5MTUifQ==', 'eyJpdiI6Ik9Qalczb3ZLU1RGZm9zZWFwaG1HeXc9PSIsInZhbHVlIjoiMitSTlBOTGMzYzVNZ3Ura0VMT25Hdz09IiwibWFjIjoiYTZkYWNjNzFkYWQxYjlkODYyZmEzM2Y4YjBiMDQ0YTdjOWYzZTI2ODkwZGVlNDliZDViMTJjY2Y2YmVjMDUwMSJ9', 'eyJpdiI6InN5ODQ0UVwvTytPaXJyNjN1S2M5QnZnPT0iLCJ2YWx1ZSI6ImVWXC9hNklXWTd6enJobXFBMGxxTHl3PT0iLCJtYWMiOiJmYzc4OGE4YTA4MTc0MGZkYzFmZTZlMjcxYWU3ZjAzM2E0YWM0YTQzZTZkMGU4MGMyMWY5YjM4ZmMyYTBkZDdjIn0=', NULL, 'mastercard', 826.76, 0.00, '41', '0', NULL, NULL, NULL, NULL, NULL, 0, 0.00, 826.76, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-03 19:52:14', '2020-05-03 19:52:34', NULL),
(4, 1, NULL, 0, 10, 'MVF5HN10K2VFB', NULL, NULL, 'Nazmul Hasan', 'csenazmul96@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'US', 'Mokampur, 12', NULL, 'khulna', 'AZ', NULL, 4, '9220', '{\"id\":1,\"code\":\"US\",\"name\":\"United States\"}', 1, '345345345', NULL, NULL, NULL, NULL, NULL, NULL, 3307.04, 0.00, '0', '0', NULL, NULL, NULL, NULL, NULL, 0, 0.00, 3307.04, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-10 19:59:58', '2020-05-10 19:59:58', NULL),
(5, 1, NULL, 0, 10, 'CXC83RU7RKW4S', NULL, NULL, 'Nazmul Hasan', 'csenazmul96@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'US', 'Mokampur, 12', NULL, 'khulna', 'AZ', NULL, 4, '9220', '{\"id\":1,\"code\":\"US\",\"name\":\"United States\"}', 1, '345345345', NULL, NULL, NULL, NULL, NULL, NULL, 3307.04, 0.00, '0', '0', NULL, NULL, NULL, NULL, NULL, 0, 0.00, 3307.04, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-05-10 21:42:45', '2020-05-10 21:42:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `style_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `per_unit_price` double(8,2) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `style_no`, `color`, `size`, `qty`, `total_qty`, `per_unit_price`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'test_lynkto.34', NULL, NULL, 9, 9, 54.76, 54.76, '2020-05-03 18:58:53', '2020-05-03 18:58:53'),
(2, 1, 9, 'test_lynkto1.', NULL, NULL, 1, 1, 15.00, 15.00, '2020-05-03 18:58:53', '2020-05-03 18:58:53'),
(3, 1, 12, 'test_lynkto55', '32', '16', 1, 1, 826.76, 826.76, '2020-05-03 18:58:53', '2020-05-03 18:58:53'),
(4, 2, 7, 'test_lynkto.34', '1', '11', 2, 2, 54.76, 54.76, '2020-05-03 19:47:11', '2020-05-03 19:47:11'),
(5, 3, 12, 'test_lynkto55', '12', '10', 1, 1, 826.76, 826.76, '2020-05-03 19:52:14', '2020-05-03 19:52:14'),
(6, 4, 12, 'test_lynkto55', '2', '11', 4, 4, 826.76, 826.76, '2020-05-10 19:59:58', '2020-05-10 19:59:58'),
(7, 5, 12, 'test_lynkto55', '2', '11', 4, 4, 826.76, 826.76, '2020-05-10 21:42:45', '2020-05-10 21:42:45');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `content` varchar(10000) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_id`, `content`, `url`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '2020-03-30 17:16:32', '2020-03-30 17:16:32'),
(2, 2, '<p>About us page</p>', NULL, '2020-03-30 17:16:52', '2020-04-01 20:58:03'),
(3, 6, '<p>Terms and condition page</p>', NULL, '2020-03-30 17:16:54', '2020-04-01 20:59:08'),
(4, 5, '<p>return policy page</p>', NULL, '2020-03-30 17:16:55', '2020-04-01 20:58:55'),
(5, 4, '<p>privacy policy page</p>', NULL, '2020-03-30 17:16:56', '2020-04-01 20:58:46'),
(6, 3, '<p>Contact us page</p>', NULL, '2020-03-30 17:16:56', '2020-04-01 20:58:32'),
(7, 8, '<p>size guide page</p>', NULL, '2020-03-30 17:16:57', '2020-04-01 20:59:16'),
(8, 14, '<p><img alt=\"\" src=\"http://127.0.0.1:8080/laravel-filemanager/photos/1/home_hero.jpg\" style=\"width: 100%;\" /></p>', NULL, '2020-03-30 19:44:49', '2020-04-01 20:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `point_dollar_discount`
--

CREATE TABLE `point_dollar_discount` (
  `id` int(11) NOT NULL,
  `points_use` int(11) DEFAULT NULL,
  `dollar_disounts` int(11) DEFAULT NULL,
  `status` int(5) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `point_dollar_discount`
--

INSERT INTO `point_dollar_discount` (`id`, `points_use`, `dollar_disounts`, `status`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `point_systems`
--

CREATE TABLE `point_systems` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `point_type` varchar(255) DEFAULT NULL,
  `from_price_1` float DEFAULT NULL,
  `percentage_discount_1` float DEFAULT NULL,
  `unit_price_discount_1` float DEFAULT NULL,
  `free_shipping_1` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `point_systems`
--

INSERT INTO `point_systems` (`id`, `status`, `point_type`, `from_price_1`, `percentage_discount_1`, `unit_price_discount_1`, `free_shipping_1`, `created_at`, `updated_at`) VALUES
(3, 1, 'Unit price discount by order amount', 100, 0, NULL, 1, '2020-01-08 13:36:19', '2020-01-08 13:36:19'),
(4, 1, 'Percentage discount by order amount', 100, 20, 0, NULL, '2020-01-08 14:05:24', '2020-01-08 14:05:24');

-- --------------------------------------------------------

--
-- Table structure for table `point_system_settings`
--

CREATE TABLE `point_system_settings` (
  `id` int(11) NOT NULL,
  `cost_dollars` int(11) DEFAULT NULL,
  `point_rewards` int(11) DEFAULT NULL,
  `status` int(5) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `point_system_settings`
--

INSERT INTO `point_system_settings` (`id`, `cost_dollars`, `point_rewards`, `status`) VALUES
(1, 20, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `promotion_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `promotion_type_id` int(10) DEFAULT 0,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_permanent` tinyint(1) NOT NULL,
  `valid_from` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `valid_to` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `hasCouponCode` tinyint(1) DEFAULT 0,
  `coupon_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `multiple_use` tinyint(1) NOT NULL DEFAULT 0,
  `priority` tinyint(1) DEFAULT NULL,
  `from_price_1` double DEFAULT NULL,
  `to_price_1` double DEFAULT NULL,
  `percentage_discount_1` double DEFAULT NULL,
  `unit_price_discount_1` double DEFAULT NULL,
  `free_shipping_1` tinyint(1) DEFAULT 0,
  `from_price_2` float DEFAULT NULL,
  `to_price_2` float DEFAULT NULL,
  `percentage_discount_2` float DEFAULT NULL,
  `unit_price_discount_2` float DEFAULT NULL,
  `free_shipping_2` tinyint(1) DEFAULT 0,
  `from_price_3` float DEFAULT NULL,
  `to_price_3` float DEFAULT NULL,
  `percentage_discount_3` float DEFAULT NULL,
  `unit_price_discount_3` float DEFAULT NULL,
  `free_shipping_3` tinyint(1) DEFAULT 0,
  `from_price_4` float DEFAULT NULL,
  `to_price_4` float DEFAULT NULL,
  `percentage_discount_4` float DEFAULT NULL,
  `unit_price_discount_4` float DEFAULT NULL,
  `free_shipping_4` tinyint(1) DEFAULT 0,
  `from_price_5` float DEFAULT NULL,
  `to_price_5` float DEFAULT NULL,
  `percentage_discount_5` float DEFAULT NULL,
  `unit_price_discount_5` float DEFAULT NULL,
  `free_shipping_5` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `desc`, `status`, `created_at`, `updated_at`) VALUES
(1, 'logo-black', 'images/logo/d4f50520-6a5a-11ea-a115-c159b724a400.png', NULL, 1, '2020-03-19 14:28:14', NULL),
(2, 'default-item-image', 'images/logo/d4f52c90-6a5a-11ea-8929-710064f19a04.jpg', NULL, 1, '2020-03-19 14:28:14', NULL),
(3, 'welcome_notification', NULL, NULL, 0, '2020-03-29 22:20:03', '2020-03-29 22:20:03'),
(4, 'top_notification', '<p>hi</p>', 'FFFFFF', 0, '2020-03-29 22:20:05', '2020-03-30 16:54:41');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `default` tinyint(1) NOT NULL,
  `courier_id` int(11) NOT NULL,
  `ship_method_id` int(11) NOT NULL,
  `list_order` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `item_size` varchar(255) NOT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`, `item_size`, `desc`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(10, 'Medium', 'M', 'medium size', 0, '2019-07-06 00:32:43', '2019-07-06 00:39:44', NULL),
(11, 'Small', 'S', 'small size', 1, '2019-07-06 00:33:28', '2019-07-06 02:13:29', NULL),
(14, 'Small', 'hh', NULL, 1, '2019-07-06 00:56:52', '2019-07-06 00:57:14', NULL),
(16, 'Large', 'L', 'large size', 1, '2019-07-06 02:13:51', '2019-07-06 02:13:51', NULL),
(17, 'Extra Large', 'XL', 'extra large', 1, '2019-07-06 02:14:07', '2019-11-22 16:27:41', NULL),
(18, 'Extra Small', 'SS', 'Extera small', 1, '2019-07-06 02:14:27', '2019-07-06 02:14:27', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `skin_types`
--

CREATE TABLE `skin_types` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `skin_types`
--

INSERT INTO `skin_types` (`id`, `type`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Oil', '2020-02-04 16:50:53', '2020-02-04 16:50:53', NULL),
(2, 'Allergy', '2020-02-05 20:11:36', '2020-02-05 20:11:36', NULL),
(3, 'Good', '2020-02-05 20:11:44', '2020-02-05 20:11:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `social_feeds`
--

CREATE TABLE `social_feeds` (
  `id` int(11) NOT NULL,
  `type` varchar(250) NOT NULL,
  `access_token` varchar(250) DEFAULT NULL,
  `user_token` varchar(250) DEFAULT NULL,
  `pass_token` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_feeds`
--

INSERT INTO `social_feeds` (`id`, `type`, `access_token`, `user_token`, `pass_token`) VALUES
(1, 'instagram', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

CREATE TABLE `social_links` (
  `id` int(11) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `pinterest` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `whatsapp` varchar(255) NOT NULL,
  `google_plus` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `social_links`
--

INSERT INTO `social_links` (`id`, `facebook`, `twitter`, `pinterest`, `instagram`, `whatsapp`, `google_plus`, `created_at`, `updated_at`) VALUES
(1, '', '', '', '', '', '', '2020-03-30 16:48:21', '2020-03-30 16:48:21');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `code`) VALUES
(1, 1, 'Alaska', 'AK'),
(2, 1, 'Alabama', 'AL'),
(3, 1, 'American Samoa', 'AS'),
(4, 1, 'Arizona', 'AZ'),
(5, 1, 'Arkansas', 'AR'),
(6, 1, 'California', 'CA'),
(7, 1, 'Colorado', 'CO'),
(8, 1, 'Connecticut', 'CT'),
(9, 1, 'Delaware', 'DE'),
(10, 1, 'District of Columbia', 'DC'),
(11, 1, 'Federated States of Micronesia', 'FM'),
(12, 1, 'Florida', 'FL'),
(13, 1, 'Georgia', 'GA'),
(14, 1, 'Guam', 'GU'),
(15, 1, 'Hawaii', 'HI'),
(16, 1, 'Idaho', 'ID'),
(17, 1, 'Illinois', 'IL'),
(18, 1, 'Indiana', 'IN'),
(19, 1, 'Iowa', 'IA'),
(20, 1, 'Kansas', 'KS'),
(21, 1, 'Kentucky', 'KY'),
(22, 1, 'Louisiana', 'LA'),
(23, 1, 'Maine', 'ME'),
(24, 1, 'Marshall Islands', 'MH'),
(25, 1, 'Maryland', 'MD'),
(26, 1, 'Massachusetts', 'MA'),
(27, 1, 'Michigan', 'MI'),
(28, 1, 'Minnesota', 'MN'),
(29, 1, 'Mississippi', 'MS'),
(30, 1, 'Missouri', 'MO'),
(31, 1, 'Montana', 'MT'),
(32, 1, 'Nebraska', 'NE'),
(33, 1, 'Nevada', 'NV'),
(34, 1, 'New Hampshire', 'NH'),
(35, 1, 'New Jersey', 'NJ'),
(36, 1, 'New Mexico', 'NM'),
(37, 1, 'New York', 'NY'),
(38, 1, 'North Carolina', 'NC'),
(39, 1, 'North Dakota', 'ND'),
(40, 1, 'Northern Mariana Islands', 'MP'),
(41, 1, 'Ohio', 'OH'),
(42, 1, 'Oklahoma', 'OK'),
(43, 1, 'Oregon', 'OR'),
(44, 1, 'Palau', 'PW'),
(45, 1, 'Pennsylvania', 'PA'),
(46, 1, 'Puerto Rico', 'PR'),
(47, 1, 'Rhode Island', 'RI'),
(48, 1, 'South Carolina', 'SC'),
(49, 1, 'South Dakota', 'SD'),
(50, 1, 'Tennessee', 'TN'),
(51, 1, 'Texas', 'TX'),
(52, 1, 'Utah', 'UT'),
(53, 1, 'Vermont', 'VT'),
(54, 1, 'Virgin Islands', 'VI'),
(55, 1, 'Virginia', 'VA'),
(56, 1, 'Washington', 'WA'),
(57, 1, 'West Virginia', 'WV'),
(58, 1, 'Wisconsin', 'WI'),
(59, 1, 'Wyoming', 'WY'),
(60, 1, 'Armed Forces Africa', 'AE'),
(61, 1, 'Armed Forces Americas (except Canada)', 'AA'),
(62, 1, 'Armed Forces Canada', 'AE'),
(63, 1, 'Armed Forces Europe', 'AE'),
(64, 1, 'Armed Forces Middle East', 'AE'),
(65, 1, 'Armed Forces Pacific', 'AP'),
(66, 2, 'Alberta', 'AB'),
(67, 2, 'British Columbia', 'BC'),
(68, 2, 'Manitoba', 'MB'),
(69, 2, 'New Brunswick', 'NB'),
(70, 2, 'Newfoundland and Labrador', 'NL'),
(71, 2, 'Northwest Territories', 'NT'),
(72, 2, 'Nova Scotia', 'NS'),
(73, 2, 'Nunavut', 'NU'),
(74, 2, 'Ontario', 'ON'),
(75, 2, 'Prince Edward Island', 'PE'),
(76, 2, 'Quebec', 'QC'),
(77, 2, 'Saskatchewan', 'SK'),
(78, 2, 'Yukon', 'YT');

-- --------------------------------------------------------

--
-- Table structure for table `store_credits`
--

CREATE TABLE `store_credits` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `store_credit_transections`
--

CREATE TABLE `store_credit_transections` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `order_count` int(11) DEFAULT 0,
  `buyer_meta_id` int(11) DEFAULT NULL,
  `vendor_meta_id` int(11) DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `user_name`, `password`, `role`, `active`, `order_count`, `buyer_meta_id`, `vendor_meta_id`, `remember_token`, `reset_token`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Super', 'Admin', 'admin@gmail.com', 'admin', '$2y$12$9rNLvyA62FzEKlGrFa2wX.p9bE1fEeqW.EPuD.PxWVRAI.GCrkLsm', 1, 1, 0, NULL, 1, 'T0KSRzLISPtoONRtw2HLe99OujIubOzL0ZMZpReGiYpH1Nw9NBsCxhThvSM8', NULL, '2020-05-10 15:55:56', '2018-05-10 05:41:54', '2020-05-10 15:55:56', NULL),
(6, 'Hasib', 'Islam', 'hasib.pust.cse@gmail.com', NULL, '$2y$10$hXNtfHJ1S2gwmLnK0g61g.KtwKI5X5xnrqjnMcEHfr9R6Oe5ySQLq', 3, 1, 0, 1, NULL, NULL, NULL, NULL, '2020-02-05 20:31:09', '2020-04-29 15:20:17', NULL),
(10, 'Nazmul', 'Hasan', 'csenazmul96@gmail.com', NULL, '$2y$10$SNPyEUi0N2B6CMMQSJzaeehjAeH/Fm.gwSJPiMIkSaYUYi4ZPbp0u', 3, 1, 17, 5, NULL, NULL, NULL, '2020-04-15 13:23:22', '2020-02-06 15:09:55', '2020-05-03 21:11:13', NULL),
(12, 'Ab Kader', 'molla', 'kader@gmail.com', NULL, '$2y$10$wa92ZP/Jbl0uL6U8gimuCOHt47yk3jvztwhhAZhP19B1PaFGGrH0K', 3, 1, 0, 7, NULL, NULL, NULL, '2020-04-12 23:31:30', '2020-04-12 21:33:02', '2020-04-12 23:31:30', NULL),
(13, 'muradf', 'molla', 'morad@gmail.com', NULL, '$2y$10$9qKsYY5qvkFyMCuOTPeL7uADdv0nuvPbU5c8deCRUrjfxXS7b8YH6', 3, 1, 0, 8, NULL, NULL, NULL, NULL, '2020-04-12 21:43:59', '2020-04-12 21:43:59', NULL),
(14, 'sharmin', 'sultana', 'sarmin@gmail.com', NULL, '$2y$10$o3dmzTyDxShppdJZb/543O.GhnY/Awfk4.IQtFb3TLHPBNkSViVbG', 3, 1, 0, 9, NULL, NULL, NULL, NULL, '2020-04-12 22:08:31', '2020-04-12 22:08:31', NULL),
(15, 'Mirajul', 'islam', 'mirajul@gmail.com', NULL, '$2y$10$K5OAEqjEzbdgFCLWKyG5c.WqOvqTUu1HyHl7QTL04SWFXwu.ml1LC', 3, 1, 0, 10, NULL, NULL, NULL, NULL, '2020-04-27 14:19:17', '2020-04-27 14:19:17', NULL),
(16, 'siraful islam', 'islam', 'sirajul@gmail.com', NULL, '$2y$10$9zi5mO16VNtzxx8FTaT7/um.24VsZZ6eU9QFL9.65VwxKcggqsL8e', 3, 1, 0, 11, NULL, NULL, NULL, NULL, '2020-04-28 01:44:01', '2020-04-28 01:44:01', NULL),
(17, 'ohid', 'sheikh', 'ohid@gmail.com', NULL, '$2y$10$4siQvZZX4AHXsqBRKcCzSeCvpB93Aoxe5D.I.K7s9cHxQxkNXm2AW', 3, 1, 0, 12, NULL, NULL, NULL, NULL, '2020-04-28 01:46:06', '2020-04-28 01:46:06', NULL),
(18, 'Ohid', 'sheikh', 'ohid1@gmail.com', NULL, '$2y$10$oF2cMei91YMMGFPHaZbRN.YGnldTUVtynjioiGrtR1H02TtzeVA8S', 3, 1, 0, 13, NULL, NULL, NULL, NULL, '2020-04-28 01:46:39', '2020-04-28 01:46:39', NULL),
(19, 'sdfsdf', 'sdf', 'sirajul@gmail.com3', NULL, '$2y$10$WFJ/UpJjNNy8w0gLuPe.buaGfSrsLmm6CEl9u3WLZSlPx/BGOI0kS', 3, 1, 0, 14, NULL, NULL, NULL, NULL, '2020-04-28 01:51:05', '2020-04-28 01:51:05', NULL),
(20, 'sdfsdf', 'cart', 'sirajul@gmail.com33', NULL, '$2y$10$8gYJ.45FfG2g8cxO0b7MB.Z1VxbcSr/a2vJpnI/Ln0bWSl9CUQ2qO', 3, 1, 0, 15, NULL, NULL, NULL, NULL, '2020-04-28 01:51:41', '2020-04-28 01:51:41', NULL),
(21, 'sdfsdf', 'cart', 'sirajueel@gmail.com', NULL, '$2y$10$Z8aI77CykaQTLUB2qwQSreaJUDr3VqA6PWpnCl5pDNMnYKMT2uC.i', 3, 1, 0, 16, NULL, NULL, NULL, NULL, '2020-04-28 01:52:45', '2020-04-28 01:52:45', NULL),
(22, 'sdfsdf', 'cart', 'siraju3eel@gmail.com', NULL, '$2y$10$jr9GaWH5u9aZjrNRciUSJu6l9sD2QdhUwus7fywkMt/i83cCTvyA6', 3, 1, 0, 17, NULL, NULL, NULL, NULL, '2020-04-28 01:53:11', '2020-04-28 01:53:11', NULL),
(23, 'sdfsdf', 'cart', 'sir33aju3eel@gmail.com', NULL, '$2y$10$s0iNbXEqX2FIzkOjkyo1.OL8m34pxY9d9023VPJmqU2PHMlJ/Yzke', 3, 1, 0, 18, NULL, NULL, NULL, NULL, '2020-04-28 01:53:17', '2020-04-28 01:53:17', NULL),
(24, 'sdfsdf', 'cart', 'siwerrajul@gmail.com', NULL, '$2y$10$hAaHupVtFEf7ul8jUoTICeqRQyY5313DqG99/91b4lLroYfL/T.vi', 3, 1, 0, 19, NULL, NULL, NULL, NULL, '2020-04-28 01:53:32', '2020-04-28 01:53:32', NULL),
(25, 'sdfsdf', 'cart', 'siwerraju232l@gmail.com', NULL, '$2y$10$0OFdy7eOti1LwZa3sIk3kOd00TADGsPW1iW3r5fMgev0DWohpA6vq', 3, 1, 0, 20, NULL, NULL, NULL, NULL, '2020-04-28 01:53:40', '2020-04-28 01:53:40', NULL),
(26, 'sdfsdf', 'cart', 'sirajul098@gmail.com', NULL, '$2y$10$I.qe.EzyDnbR3CQaWMPeuOsQoiER5CXabpnKcbc4gFMrk/rmaUPWK', 3, 1, 0, 21, NULL, NULL, NULL, NULL, '2020-04-28 01:54:14', '2020-04-28 01:54:14', NULL),
(27, 'dipti', 'sarker', 'dipti@gmail.com', NULL, '$2y$10$8lq2ixRnsLTZkse5.1Faju8v0aaAqQDthDjphlZn8VOyFe1eIO.UO', 3, 1, 0, 22, NULL, NULL, NULL, NULL, '2020-05-03 21:19:48', '2020-05-03 21:19:48', NULL),
(28, 'new', 'cart', 'dipti2@gmail.comdd', NULL, '$2y$10$L/ZbTPO/e16D/Rpx52HQxOW62yir.CJBmvo4oHxIr2yULS4azntdW', 3, 1, 0, 23, NULL, NULL, NULL, NULL, '2020-05-03 21:40:28', '2020-05-03 21:40:28', NULL),
(29, 'sdfsdf', 'cart', 'dipeti@gmail.com', NULL, '$2y$10$qzc62GgWr7Q9mKdvp4ASGuqeD.XY6roZAhINCZKchA7sF1oHD2Kze', 3, 1, 0, 24, NULL, NULL, NULL, NULL, '2020-05-03 21:41:05', '2020-05-03 21:41:05', NULL),
(30, 'sdfsdf', 'cart', 'ertret@gmail.com', NULL, '$2y$10$mpNgId8Q/Tg/9QIFNXKQmerkrZNdWk52rZ86fBB9.Us81TsI3Upwm', 3, 1, 0, 25, NULL, NULL, NULL, NULL, '2020-05-03 21:42:00', '2020-05-03 21:42:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_permission`
--

CREATE TABLE `user_permission` (
  `user_id` int(11) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_images`
--

CREATE TABLE `vendor_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `image_path` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_images`
--

INSERT INTO `vendor_images` (`id`, `type`, `status`, `image_path`, `sort`, `url`, `title`, `details`, `created_at`, `updated_at`) VALUES
(10, 3, 1, '/images/banner/042c5dc0-77c3-11ea-9eb7-eb13745d3815.jpg', 2, '#', 'Best Wholesale Clothing Store | Best Wholesale Fashion Clothing in USA | Blue B', 'Best Wholesale Clothing Store | Best Wholesale Fashion Clothing in USA | Blue B', '2020-04-05 15:56:46', '2020-04-05 15:57:18'),
(9, 3, 1, '/images/banner/fd4ee1e0-77c2-11ea-ac1c-a5443b01ba4a.jpg', 1, '#', 'Best Wholesale Clothing Store | Best Wholesale Fashion Clothing in USA | Blue B', 'Best Wholesale Clothing Store | Best Wholesale Fashion Clothing in USA | Blue B', '2020-04-05 15:56:34', '2020-04-05 15:57:14'),
(3, 7, 1, 'images/banner/cfcb7230-10b5-11ea-aafc-d3c17e72409d.jpg', NULL, NULL, NULL, 'Our Summer Sale: Final Reductions, Up To 60% Off Selected Styles', NULL, NULL),
(4, 7, 1, 'images/banner/087ded00-3cc3-11ea-bd90-21407d3af7f5.jpg', NULL, NULL, NULL, 'Our Winter Sale: Final Reductions, Up To 60% Off Selected Styles', NULL, NULL),
(5, 7, 1, 'images/banner/9dcf5ea0-54fe-11ea-aedb-9989245ea0c2.jpg', NULL, NULL, NULL, 'Our Spring Sale: Final Reductions, Up To 60% Off Selected Styles', NULL, NULL),
(6, 4, 1, '/images/banner/38f21f20-73d0-11ea-b946-6bbe38241893.jpg', 1, '#', 'Best Wholesale Clothing Store | Best Wholesale Fashion Clothing in USA | Blue B', 'dfgdfg', '2020-03-31 15:21:13', '2020-03-31 15:22:02'),
(7, 4, 1, '/images/banner/40507d00-73d0-11ea-bd7c-83a7845a2d4c.jpg', 3, '#', 'Schedule page meta title', 'ffgdfgdfg', '2020-03-31 15:21:25', '2020-03-31 15:22:02'),
(8, 4, 1, '/images/banner/48a69180-73d0-11ea-be30-8f5a6217a724.jpg', 2, '#', 'Best Wholesale Clothing Store | Best Wholesale Fashion Clothing in USA | Blue B', 'dgrgdfg', '2020-03-31 15:21:39', '2020-03-31 15:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wish_list_items`
--

CREATE TABLE `wish_list_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wish_list_items`
--

INSERT INTO `wish_list_items` (`id`, `user_id`, `item_id`, `created_at`, `updated_at`) VALUES
(52, '10', 12, '2020-05-10 21:47:44', '2020-05-10 21:47:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_messages`
--
ALTER TABLE `admin_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_ship_methods`
--
ALTER TABLE `admin_ship_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `age_groups`
--
ALTER TABLE `age_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer_messages`
--
ALTER TABLE `buyer_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `buyer_shipping_addresses`
--
ALTER TABLE `buyer_shipping_addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colorsize`
--
ALTER TABLE `colorsize`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `color_item`
--
ALTER TABLE `color_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_images`
--
ALTER TABLE `item_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_inv`
--
ALTER TABLE `item_inv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_list_history`
--
ALTER TABLE `item_list_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_size`
--
ALTER TABLE `item_size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_views`
--
ALTER TABLE `item_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_history`
--
ALTER TABLE `login_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `made_in_countries`
--
ALTER TABLE `made_in_countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_colors`
--
ALTER TABLE `master_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `metas`
--
ALTER TABLE `metas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_buyers`
--
ALTER TABLE `meta_buyers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_settings`
--
ALTER TABLE `meta_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meta_vendors`
--
ALTER TABLE `meta_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `point_dollar_discount`
--
ALTER TABLE `point_dollar_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `point_systems`
--
ALTER TABLE `point_systems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `point_system_settings`
--
ALTER TABLE `point_system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skin_types`
--
ALTER TABLE `skin_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_feeds`
--
ALTER TABLE `social_feeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_credits`
--
ALTER TABLE `store_credits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_credit_transections`
--
ALTER TABLE `store_credit_transections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendor_images`
--
ALTER TABLE `vendor_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wish_list_items`
--
ALTER TABLE `wish_list_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_messages`
--
ALTER TABLE `admin_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_ship_methods`
--
ALTER TABLE `admin_ship_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `age_groups`
--
ALTER TABLE `age_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `buyer_messages`
--
ALTER TABLE `buyer_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `buyer_shipping_addresses`
--
ALTER TABLE `buyer_shipping_addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `colorsize`
--
ALTER TABLE `colorsize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `color_item`
--
ALTER TABLE `color_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=243;

--
-- AUTO_INCREMENT for table `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `item_images`
--
ALTER TABLE `item_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `item_inv`
--
ALTER TABLE `item_inv`
  MODIFY `id` bigint(191) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `item_list_history`
--
ALTER TABLE `item_list_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

--
-- AUTO_INCREMENT for table `item_size`
--
ALTER TABLE `item_size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `item_views`
--
ALTER TABLE `item_views`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login_history`
--
ALTER TABLE `login_history`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `made_in_countries`
--
ALTER TABLE `made_in_countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `master_colors`
--
ALTER TABLE `master_colors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `metas`
--
ALTER TABLE `metas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `meta_buyers`
--
ALTER TABLE `meta_buyers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `meta_settings`
--
ALTER TABLE `meta_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meta_vendors`
--
ALTER TABLE `meta_vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `point_dollar_discount`
--
ALTER TABLE `point_dollar_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `point_systems`
--
ALTER TABLE `point_systems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `point_system_settings`
--
ALTER TABLE `point_system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `skin_types`
--
ALTER TABLE `skin_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `social_feeds`
--
ALTER TABLE `social_feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `store_credits`
--
ALTER TABLE `store_credits`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_credit_transections`
--
ALTER TABLE `store_credit_transections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `vendor_images`
--
ALTER TABLE `vendor_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wish_list_items`
--
ALTER TABLE `wish_list_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
