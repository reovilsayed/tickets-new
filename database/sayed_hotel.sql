-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 12, 2023 at 11:14 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sayed_hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `company`, `address_1`, `address_2`, `city`, `state`, `post_code`, `country`, `phone`, `created_at`, `updated_at`) VALUES
(1, 4, 'Hoppe, Gaylord and Mann', '894 Parker Drive\nWehnertown, NJ 02035-7898', '6645 Millie Trace Apt. 175\nEast Reganton, MA 72274', 'Alicehaven', 'Vermont', '17012', 'Mongolia', '(463) 718-2633', '2023-09-09 00:34:44', '2023-09-09 00:34:44'),
(2, 5, 'Thiel Group', '233 Baumbach Lakes Apt. 973\nMarychester, VT 25799-9468', '8006 Macejkovic Way\nWolftown, ME 66777-6933', 'Hermanbury', 'North Carolina', '55710', 'Cote d\'Ivoire', '+15707344700', '2023-09-09 00:34:44', '2023-09-09 00:34:44'),
(3, 5, 'Kertzmann-Gorczany', '987 Raegan Ramp\nPort Vadashire, FL 21836-6313', '129 Pfannerstill Meadow\nHowellmouth, AK 91491-5829', 'Kiratown', 'New Jersey', '50673-6349', 'Niue', '212-692-0198', '2023-09-09 00:34:44', '2023-09-09 00:34:44'),
(4, 1, 'McCullough LLC', '72222 Lourdes Viaduct Apt. 420\nMakennaside, OH 49357-5972', '3948 Oberbrunner Flat Apt. 406\nWest Alfredview, CO 83868', 'North Chaimside', 'Minnesota', '23255-0039', 'Pakistan', '612.319.7334', '2023-09-09 00:34:44', '2023-09-09 00:34:44'),
(5, 3, 'Robel, Crona and Lemke', '752 Gaetano Glen\nNorth Lillianamouth, MA 00473-9569', '73380 Orn Plains Suite 977\nWest Winston, MD 83961', 'South Zoila', 'Kansas', '67705', 'Togo', '380.742.0965', '2023-09-09 00:34:44', '2023-09-09 00:34:44');

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `order` int NOT NULL DEFAULT '1',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Category 1', 'category-1', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(2, NULL, 1, 'Category 2', 'category-2', '2023-09-08 23:30:27', '2023-09-08 23:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int NOT NULL,
  `expire_at` date NOT NULL,
  `limit` int NOT NULL,
  `minimum_cart` int NOT NULL,
  `used` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_rows`
--

CREATE TABLE `data_rows` (
  `id` int UNSIGNED NOT NULL,
  `data_type_id` int UNSIGNED NOT NULL,
  `field` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `browse` tinyint(1) NOT NULL DEFAULT '1',
  `read` tinyint(1) NOT NULL DEFAULT '1',
  `edit` tinyint(1) NOT NULL DEFAULT '1',
  `add` tinyint(1) NOT NULL DEFAULT '1',
  `delete` tinyint(1) NOT NULL DEFAULT '1',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_rows`
--

INSERT INTO `data_rows` (`id`, `data_type_id`, `field`, `type`, `display_name`, `required`, `browse`, `read`, `edit`, `add`, `delete`, `details`, `order`) VALUES
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(2, 1, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, NULL, 3),
(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, NULL, 4),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, NULL, 5),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 6),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(8, 1, 'avatar', 'image', 'Avatar', 0, 1, 1, 1, 1, 1, NULL, 8),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":0}', 10),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 11),
(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, NULL, 12),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, NULL, 5),
(21, 1, 'role_id', 'text', 'Role', 1, 1, 1, 1, 1, 1, NULL, 9),
(22, 4, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(23, 4, 'parent_id', 'select_dropdown', 'Parent', 0, 0, 1, 1, 1, 1, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"}}', 2),
(24, 4, 'order', 'text', 'Order', 1, 1, 1, 1, 1, 1, '{\"default\":1}', 3),
(25, 4, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 4),
(26, 4, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(27, 4, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 6),
(28, 4, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(29, 5, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(30, 5, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, NULL, 2),
(31, 5, 'category_id', 'text', 'Category', 1, 0, 1, 1, 1, 0, NULL, 3),
(32, 5, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, NULL, 4),
(33, 5, 'excerpt', 'text_area', 'Excerpt', 1, 0, 1, 1, 1, 1, NULL, 5),
(34, 5, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, NULL, 6),
(35, 5, 'image', 'image', 'Post Image', 0, 1, 1, 1, 1, 1, '{\"resize\":{\"width\":\"1000\",\"height\":\"null\"},\"quality\":\"70%\",\"upsize\":true,\"thumbnails\":[{\"name\":\"medium\",\"scale\":\"50%\"},{\"name\":\"small\",\"scale\":\"25%\"},{\"name\":\"cropped\",\"crop\":{\"width\":\"300\",\"height\":\"250\"}}]}', 7),
(36, 5, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:posts,slug\"}}', 8),
(37, 5, 'meta_description', 'text_area', 'Meta Description', 1, 0, 1, 1, 1, 1, NULL, 9),
(38, 5, 'meta_keywords', 'text_area', 'Meta Keywords', 1, 0, 1, 1, 1, 1, NULL, 10),
(39, 5, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"PUBLISHED\":\"published\",\"DRAFT\":\"draft\",\"PENDING\":\"pending\"}}', 11),
(40, 5, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, NULL, 12),
(41, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 13),
(42, 5, 'seo_title', 'text', 'SEO Title', 0, 1, 1, 1, 1, 1, NULL, 14),
(43, 5, 'featured', 'checkbox', 'Featured', 1, 1, 1, 1, 1, 1, NULL, 15),
(44, 6, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(45, 6, 'author_id', 'text', 'Author', 1, 0, 0, 0, 0, 0, NULL, 2),
(46, 6, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, NULL, 3),
(47, 6, 'excerpt', 'text_area', 'Excerpt', 1, 0, 1, 1, 1, 1, NULL, 4),
(48, 6, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, NULL, 5),
(49, 6, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\"},\"validation\":{\"rule\":\"unique:pages,slug\"}}', 6),
(50, 6, 'meta_description', 'text', 'Meta Description', 1, 0, 1, 1, 1, 1, NULL, 7),
(51, 6, 'meta_keywords', 'text', 'Meta Keywords', 1, 0, 1, 1, 1, 1, NULL, 8),
(52, 6, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"INACTIVE\",\"options\":{\"INACTIVE\":\"INACTIVE\",\"ACTIVE\":\"ACTIVE\"}}', 9),
(53, 6, 'created_at', 'timestamp', 'Created At', 1, 1, 1, 0, 0, 0, NULL, 10),
(54, 6, 'updated_at', 'timestamp', 'Updated At', 1, 0, 0, 0, 0, 0, NULL, 11),
(55, 6, 'image', 'image', 'Page Image', 0, 1, 1, 1, 1, 1, NULL, 12),
(56, 9, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(57, 9, 'shop_id', 'text', 'Shop Id', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 4),
(58, 9, 'name', 'text', 'Name', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 5),
(59, 9, 'slug', 'text', 'Slug', 0, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"},\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 6),
(60, 9, 'type', 'text', 'Type', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 7),
(61, 9, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"},\"default\":\"Active\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', 12),
(62, 9, 'featured', 'select_dropdown', 'Featured', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"default\":\"Off\",\"options\":{\"0\":\"On\",\"1\":\"Off\"},\"validation\":{\"rule\":\"required\"}}', 8),
(63, 9, 'description', 'text_area', 'Description', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 9),
(64, 9, 'short_description', 'text_area', 'Short Description', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 10),
(65, 9, 'sku', 'text', 'Sku', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 11),
(66, 9, 'price', 'text', 'Price', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"},\"validation\":{\"rule\":\"required\"}}', 13),
(67, 9, 'sale_price', 'text', 'Sale Price', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"}}', 14),
(68, 9, 'total_sale', 'text', 'Total Sale', 0, 0, 1, 0, 0, 1, '{}', 17),
(69, 9, 'downloads', 'text', 'Downloads', 0, 0, 1, 0, 0, 1, '{}', 18),
(70, 9, 'manage_stock', 'text', 'Manage Stock', 1, 0, 1, 1, 0, 1, '{\"display\":{\"width\":\"6\"}}', 20),
(71, 9, 'quantity', 'text', 'Quantity', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"},\"validation\":{\"rule\":\"required\"}}', 16),
(72, 9, 'weight', 'text', 'Weight', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"}}', 15),
(73, 9, 'dimensions', 'text', 'Dimensions', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"}}', 19),
(74, 9, 'rating_count', 'text', 'Rating Count', 0, 0, 1, 1, 0, 1, '{\"display\":{\"width\":\"6\"}}', 21),
(75, 9, 'parent_id', 'text', 'Parent Id', 0, 0, 1, 1, 1, 1, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"},\"display\":{\"width\":\"3\"}}', 22),
(76, 9, 'image', 'image', 'Image', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 23),
(77, 9, 'images', 'multiple_images', 'Images', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"default\":\"Active\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', 24),
(78, 9, 'variations', 'text', 'Variations', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 25),
(79, 9, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 26),
(80, 9, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 27),
(81, 9, 'product_belongsto_shop_relationship', 'relationship', 'shops', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\Shop\",\"table\":\"shops\",\"type\":\"belongsTo\",\"column\":\"shop_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(82, 9, 'product_belongsto_product_relationship', 'relationship', 'Parent', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\Product\",\"table\":\"products\",\"type\":\"belongsTo\",\"column\":\"parent_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 3),
(83, 11, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(84, 11, 'user_id', 'text', 'User Id', 0, 0, 0, 0, 0, 0, '{}', 2),
(85, 11, 'code', 'text', 'Code', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 4),
(86, 11, 'discount', 'number', 'Discount', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 5),
(87, 11, 'expire_at', 'date', 'Expire At', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 6),
(88, 11, 'limit', 'number', 'Limit', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 7),
(89, 11, 'minimum_cart', 'number', 'Minimum Cart', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 8),
(90, 11, 'used', 'text', 'Used', 0, 0, 1, 1, 0, 1, '{}', 9),
(91, 11, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 10),
(92, 11, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
(94, 11, 'coupon_belongsto_user_relationship', 'relationship', 'users', 0, 0, 0, 0, 0, 1, '{\"model\":\"App\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 12),
(95, 13, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(96, 13, 'user_id', 'text', 'User Id', 1, 1, 1, 1, 1, 1, '{}', 3),
(99, 13, 'company', 'text', 'Company', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 6),
(100, 13, 'address_1', 'text_area', 'Address 1', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 7),
(101, 13, 'address_2', 'text_area', 'Address 2', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 8),
(102, 13, 'city', 'text', 'City', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 9),
(103, 13, 'state', 'text', 'State', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 10),
(104, 13, 'post_code', 'text', 'Post Code', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 11),
(105, 13, 'country', 'text', 'Country', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 12),
(107, 13, 'phone', 'text', 'Phone', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 14),
(108, 13, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 15),
(109, 13, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 16),
(110, 13, 'address_belongsto_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(111, 14, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(112, 14, 'shop_id', 'text', 'Shop Id', 0, 0, 0, 0, 0, 0, '{}', 3),
(113, 14, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 4),
(114, 14, 'logo', 'image', 'Logo', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 5),
(115, 14, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"slugify\":{\"origin\":\"name\"},\"validation\":{\"rule\":\"required\"}}', 6),
(116, 14, 'parent_id', 'text', 'Parent Id', 0, 1, 1, 1, 1, 1, '{}', 7),
(117, 14, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 8),
(118, 14, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
(119, 14, 'prodcat_belongsto_prodcat_relationship', 'relationship', 'Parent', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\Prodcat\",\"table\":\"prodcats\",\"type\":\"belongsTo\",\"column\":\"parent_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(120, 16, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(121, 16, 'product_id', 'text', 'Product Id', 1, 1, 1, 1, 1, 1, '{}', 2),
(122, 16, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"Active\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', 3),
(123, 16, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 4),
(124, 16, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 5),
(125, 16, 'rating', 'text', 'Rating', 1, 1, 1, 1, 1, 1, '{}', 6),
(126, 16, 'review', 'text', 'Review', 1, 1, 1, 1, 1, 1, '{}', 7),
(127, 16, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 8),
(128, 16, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
(129, 16, 'rating_belongsto_product_relationship', 'relationship', 'products', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Product\",\"table\":\"products\",\"type\":\"belongsTo\",\"column\":\"product_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 10),
(130, 17, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(131, 17, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 4),
(132, 17, 'user_id', 'text', 'User Id', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 3),
(133, 17, 'slug', 'text', 'Slug', 0, 0, 1, 0, 1, 1, '{\"display\":{\"width\":\"6\"},\"slugify\":{\"origin\":\"name\"},\"validation\":{\"rule\":\"required\"}}', 5),
(134, 17, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required|email\"}}', 6),
(135, 17, 'phone', 'text', 'Phone', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 7),
(136, 17, 'logo', 'image', 'Logo', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 8),
(137, 17, 'description', 'rich_text_box', 'Description', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"12\"},\"validation\":{\"rule\":\"required\"}}', 9),
(138, 17, 'short_description', 'text_area', 'Short Description', 1, 0, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\"}}', 10),
(139, 17, 'tags', 'select_multiple', 'Tags', 1, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 11),
(140, 17, 'terms', 'text_area', 'Terms', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 12),
(141, 17, 'company_name', 'text', 'Company Name', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 13),
(142, 17, 'company_registration', 'text', 'Company Registration', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 14),
(143, 17, 'city', 'text', 'City', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 15),
(144, 17, 'state', 'text', 'State', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 16),
(145, 17, 'post_code', 'text', 'Post Code', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 17),
(146, 17, 'country', 'text', 'Country', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 18),
(147, 17, 'status', 'select_dropdown', 'Status', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"default\":\"Active\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', 19),
(148, 17, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 20),
(149, 17, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 21),
(150, 17, 'shop_belongsto_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(151, 18, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(152, 18, 'user_id', 'text', 'User Id', 0, 1, 1, 1, 1, 1, '{}', 5),
(153, 18, 'shop_id', 'text', 'Shop Id', 0, 1, 1, 1, 1, 1, '{}', 6),
(154, 18, 'product_id', 'text', 'Product Id', 0, 1, 1, 1, 1, 1, '{}', 7),
(155, 18, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"pending\",\"options\":{\"0\":\"pending\",\"1\":\"paid\",\"2\":\"on its way\",\"3\":\"cancle\"},\"display\":{\"width\":\"6\"}}', 8),
(156, 18, 'currency', 'text', 'Currency', 0, 0, 0, 1, 0, 1, '{}', 9),
(157, 18, 'discount', 'text', 'Discount', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 10),
(158, 18, 'discount_code', 'text', 'Discount Code', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 11),
(159, 18, 'shipping_total', 'text', 'Shipping Total', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 12),
(160, 18, 'shipping_method', 'text', 'Shipping Method', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 13),
(161, 18, 'shipping_url', 'text', 'Shipping Url', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 14),
(162, 18, 'subtotal', 'text', 'Subtotal', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 15),
(163, 18, 'total', 'text', 'Total', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 16),
(164, 18, 'tax', 'text', 'Tax', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 17),
(165, 18, 'customer_note', 'text', 'Customer Note', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 18),
(166, 18, 'billing', 'text', 'Billing', 0, 0, 1, 1, 0, 1, '{}', 19),
(167, 18, 'shipping', 'text', 'Shipping', 1, 0, 1, 1, 0, 1, '{}', 20),
(168, 18, 'payment_method', 'text', 'Payment Method', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 21),
(169, 18, 'payment_method_title', 'text', 'Payment Method Title', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 22),
(170, 18, 'transaction_id', 'text', 'Transaction Id', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 23),
(171, 18, 'date_paid', 'timestamp', 'Date Paid', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 24),
(172, 18, 'date_completed', 'timestamp', 'Date Completed', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 25),
(173, 18, 'refund_amount', 'text', 'Refund Amount', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 26),
(174, 18, 'company', 'text', 'Company', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 27),
(175, 18, 'aptment', 'text', 'Aptment', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 28),
(176, 18, 'quantity', 'text', 'Quantity', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 29),
(177, 18, 'parent_id', 'text', 'Parent Id', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 30),
(178, 18, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 31),
(179, 18, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 32),
(180, 18, 'order_belongsto_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(181, 18, 'order_belongsto_shop_relationship', 'relationship', 'shops', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\Shop\",\"table\":\"shops\",\"type\":\"belongsTo\",\"column\":\"shop_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 3),
(182, 18, 'order_belongsto_product_relationship', 'relationship', 'products', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\Product\",\"table\":\"products\",\"type\":\"belongsTo\",\"column\":\"product_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 4),
(183, 19, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(184, 19, 'image', 'image', 'Image', 0, 1, 1, 1, 1, 1, '{}', 2),
(185, 19, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 3),
(186, 19, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4),
(187, 17, 'banner', 'text', 'Banner', 0, 0, 1, 1, 0, 1, '{}', 8),
(188, 21, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(189, 21, 'user_id', 'text', 'User Id', 1, 1, 1, 1, 1, 1, '{}', 2),
(190, 21, 'phone', 'text', 'Phone', 1, 1, 1, 1, 1, 1, '{}', 3),
(191, 21, 'dob', 'timestamp', 'Dob', 1, 1, 1, 1, 1, 1, '{}', 4),
(192, 21, 'tax_no', 'text', 'Tax No', 1, 1, 1, 1, 1, 1, '{}', 5),
(193, 21, 'card_no', 'text', 'Card No', 1, 1, 1, 1, 1, 1, '{}', 6),
(194, 21, 'govt_id', 'text', 'Govt Id', 1, 1, 1, 1, 1, 1, '{}', 7),
(195, 21, 'bank_ac', 'text', 'Bank Ac', 1, 1, 1, 1, 1, 1, '{}', 8),
(196, 21, 'address', 'text', 'Address', 1, 1, 1, 1, 1, 1, '{}', 9),
(197, 21, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 10),
(198, 21, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
(199, 21, 'verification_belongsto_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":null}', 12),
(200, 9, 'vendor_price', 'text', 'Vendor Price', 0, 1, 1, 1, 1, 1, '{}', 12),
(201, 9, 'views', 'text', 'Views', 1, 1, 1, 1, 1, 1, '{}', 13),
(202, 18, 'vendor_total', 'text', 'Vendor Total', 0, 1, 1, 1, 1, 1, '{}', 14),
(203, 22, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(204, 22, 'parent_id', 'text', 'Parent Id', 0, 1, 1, 1, 1, 1, '{}', 4),
(205, 22, 'shop_id', 'text', 'Shop Id', 1, 1, 1, 1, 1, 1, '{}', 2),
(206, 22, 'user_id', 'text', 'User Id', 0, 1, 1, 1, 1, 1, '{}', 3),
(207, 22, 'subject', 'text', 'Subject', 0, 1, 1, 1, 1, 1, '{}', 5),
(208, 22, 'massage', 'text', 'Massage', 0, 1, 1, 1, 1, 1, '{}', 6),
(209, 22, 'image', 'image', 'Image', 0, 1, 1, 1, 1, 1, '{}', 7),
(210, 22, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"0\",\"options\":{\"0\":\"Active\",\"1\":\"Closed\"}}', 8),
(211, 22, 'action', 'select_dropdown', 'Action', 0, 1, 1, 1, 1, 1, '{\"default\":\"0\",\"options\":{\"0\":\"Awaiting response from the customer\",\"1\":\"Awaiting response from you\"}}', 9),
(212, 22, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{\"format\":\"%m-%d-%Y\"}', 10),
(213, 22, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
(214, 22, 'ticket_belongsto_shop_relationship', 'relationship', 'shops', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Shop\",\"table\":\"shops\",\"type\":\"belongsTo\",\"column\":\"shop_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":null}', 12),
(215, 14, 'role', 'text', 'Role', 0, 1, 1, 1, 1, 1, '{}', 9);

-- --------------------------------------------------------

--
-- Table structure for table `data_types`
--

CREATE TABLE `data_types` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_singular` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name_plural` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `policy_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `controller` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `generate_permissions` tinyint(1) NOT NULL DEFAULT '0',
  `server_side` tinyint NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `data_types`
--

INSERT INTO `data_types` (`id`, `name`, `slug`, `display_name_singular`, `display_name_plural`, `icon`, `model_name`, `policy_name`, `controller`, `description`, `generate_permissions`, `server_side`, `details`, `created_at`, `updated_at`) VALUES
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', '', 1, 0, NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', '', 1, 0, NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, '', '', 1, 0, NULL, '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(5, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', '', '', 1, 0, NULL, '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(6, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, '', '', 1, 0, NULL, '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(9, 'products', 'products', 'Product', 'Products', 'voyager-shop', 'App\\Models\\Product', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 11:28:10', '2023-05-04 11:48:27'),
(11, 'coupons', 'coupons', 'Coupon', 'Coupons', 'voyager-ticket', 'App\\Models\\Coupon', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:15:49', '2023-04-07 12:23:29'),
(13, 'addresses', 'addresses', 'Address', 'Addresses', 'voyager-location', 'App\\Models\\Address', NULL, NULL, NULL, 0, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:26:46', '2023-09-11 23:29:30'),
(14, 'prodcats', 'prodcats', 'Prodcat', 'Prodcats', 'voyager-company', 'App\\Models\\Prodcat', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:36:57', '2023-09-03 02:01:34'),
(16, 'ratings', 'ratings', 'Rating', 'Ratings', 'voyager-star-two', 'App\\Models\\Rating', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:44:56', '2023-04-07 12:47:30'),
(17, 'shops', 'shops', 'Shop', 'Shops', 'voyager-company', 'App\\Models\\Shop', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:55:49', '2023-05-23 23:33:20'),
(18, 'orders', 'orders', 'Order', 'Orders', 'voyager-basket', 'App\\Models\\Order', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-08 09:32:52', '2023-05-04 11:59:46'),
(19, 'sliders', 'sliders', 'Slider', 'Sliders', 'voyager-images', 'App\\Slider', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-11 11:40:00', '2023-04-12 09:06:59'),
(21, 'verifications', 'verifications', 'Verification', 'Verifications', 'voyager-bookmark', 'App\\Models\\Verification', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
(22, 'tickets', 'tickets', 'Ticket', 'Tickets', 'voyager-ticket', 'App\\Models\\Ticket', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":\"parents\"}', '2023-05-11 00:40:41', '2023-05-11 00:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `feedback` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `massages`
--

CREATE TABLE `massages` (
  `id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint NOT NULL,
  `reciver_id` bigint NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `massage` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(3, 'main', '2023-05-03 15:21:32', '2023-05-03 15:21:32'),
(4, 'leftside', '2023-05-17 00:33:29', '2023-05-17 00:38:25'),
(5, 'middle', '2023-09-03 01:43:41', '2023-09-03 01:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `id` int UNSIGNED NOT NULL,
  `menu_id` int UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '_self',
  `icon_class` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `order` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `title`, `url`, `target`, `icon_class`, `color`, `parent_id`, `order`, `created_at`, `updated_at`, `route`, `parameters`) VALUES
(1, 1, 'Dashboard', '', '_self', 'voyager-boat', NULL, NULL, 1, '2023-03-12 01:03:40', '2023-03-12 01:03:40', 'voyager.dashboard', NULL),
(3, 1, 'Users', '', '_self', 'voyager-person', NULL, 20, 1, '2023-03-12 01:03:40', '2023-04-07 12:58:19', 'voyager.users.index', NULL),
(4, 1, 'Roles', '', '_self', 'voyager-lock', NULL, NULL, 2, '2023-03-12 01:03:40', '2023-03-12 01:03:40', 'voyager.roles.index', NULL),
(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 3, '2023-03-12 01:03:40', '2023-04-07 12:32:34', 'voyager.compass.index', NULL),
(14, 1, 'Products', '', '_self', 'voyager-shop', NULL, 24, 1, '2023-04-07 11:28:10', '2023-04-12 09:15:57', 'voyager.products.index', NULL),
(15, 1, 'Coupons', '', '_self', 'voyager-ticket', NULL, NULL, 6, '2023-04-07 12:15:49', '2023-04-12 09:16:01', 'voyager.coupons.index', NULL),
(16, 1, 'Addresses', '', '_self', 'voyager-location', '#000000', 20, 2, '2023-04-07 12:26:46', '2023-04-07 12:58:21', 'voyager.addresses.index', 'null'),
(17, 1, 'Prodcats', '', '_self', 'voyager-company', NULL, 24, 2, '2023-04-07 12:36:57', '2023-04-12 09:16:01', 'voyager.prodcats.index', NULL),
(18, 1, 'Ratings', '', '_self', 'voyager-star-two', NULL, NULL, 7, '2023-04-07 12:44:57', '2023-04-12 09:16:01', 'voyager.ratings.index', NULL),
(19, 1, 'Shops', '', '_self', 'voyager-company', NULL, NULL, 5, '2023-04-07 12:55:50', '2023-04-12 09:15:57', 'voyager.shops.index', NULL),
(20, 1, 'Users', '', '_self', 'voyager-people', '#000000', NULL, 3, '2023-04-07 12:58:08', '2023-04-07 12:58:19', NULL, ''),
(21, 1, 'Orders', '', '_self', 'voyager-basket', NULL, 33, 1, '2023-04-08 09:32:52', '2023-08-09 01:40:46', 'voyager.orders.index', NULL),
(23, 1, 'Sliders', 'admin/sliders', '_self', 'voyager-images', '#000000', NULL, 9, '2023-04-12 09:03:22', '2023-08-09 01:40:46', NULL, ''),
(24, 1, 'Products', '', '_self', 'voyager-basket', '#000000', NULL, 4, '2023-04-12 09:15:49', '2023-04-12 09:15:54', NULL, ''),
(25, 1, 'Settings', 'admin/settings', '_self', 'voyager-settings', '#000000', 28, 1, '2023-04-12 09:17:03', '2023-05-03 15:26:00', NULL, ''),
(26, 1, 'Pages', 'admin/pages', '_self', 'voyager-file-text', '#000000', 28, 2, '2023-05-03 15:23:47', '2023-05-03 15:26:02', NULL, ''),
(27, 1, 'Menus', 'admin/menus', '_self', 'voyager-list', '#000000', 28, 3, '2023-05-03 15:25:21', '2023-05-03 15:26:03', NULL, ''),
(28, 1, 'Settings', '', '_self', 'voyager-settings', '#000000', NULL, 10, '2023-05-03 15:25:50', '2023-08-09 01:40:46', NULL, ''),
(29, 3, 'About', 'page/about', '_self', NULL, '#000000', NULL, 11, '2023-05-03 15:26:38', '2023-05-03 15:26:38', NULL, ''),
(30, 1, 'Verifications', '', '_self', 'voyager-bookmark', NULL, NULL, 11, '2023-05-04 11:43:33', '2023-08-09 01:40:46', 'voyager.verifications.index', NULL),
(31, 1, 'Tickets', '', '_self', 'voyager-ticket', NULL, NULL, 12, '2023-05-11 00:40:42', '2023-08-09 01:40:46', 'voyager.tickets.index', NULL),
(32, 4, 'About', 'hello', '_self', NULL, '#000000', NULL, 14, '2023-05-17 00:35:54', '2023-05-17 00:35:54', NULL, ''),
(33, 1, 'Ordes', '', '_self', NULL, '#000000', NULL, 8, '2023-08-09 01:40:20', '2023-08-09 01:40:45', NULL, ''),
(34, 5, 'home', '/', '_self', NULL, '#000000', NULL, 15, '2023-09-03 01:44:11', '2023-09-03 01:44:11', NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

CREATE TABLE `metas` (
  `id` bigint UNSIGNED NOT NULL,
  `metable_id` bigint NOT NULL,
  `metable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_value` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metas`
--

INSERT INTO `metas` (`id`, `metable_id`, `metable_type`, `column_name`, `column_value`, `created_at`, `updated_at`) VALUES
(13, 9, 'App\\Models\\User', 'phone', '+1 (924) 591-6431', '2023-09-10 05:48:54', '2023-09-10 05:59:04'),
(14, 9, 'App\\Models\\User', 'country', 'United States', '2023-09-10 05:48:54', '2023-09-11 00:58:29'),
(15, 9, 'App\\Models\\User', 'state', 'Alaska', '2023-09-10 05:48:54', '2023-09-11 00:58:28'),
(16, 9, 'App\\Models\\User', 'city', 'Quia omnis rerum qui', '2023-09-10 05:48:54', '2023-09-10 05:59:04'),
(17, 9, 'App\\Models\\User', 'post_code', '424', '2023-09-10 05:48:54', '2023-09-10 05:59:04'),
(18, 9, 'App\\Models\\User', 'address', 'Ut unde dolorem quo', '2023-09-10 05:48:54', '2023-09-10 05:59:04'),
(19, 10, 'App\\Models\\User', 'phone', '01319828234', '2023-09-12 04:41:37', '2023-09-12 04:41:37'),
(20, 11, 'App\\Models\\User', 'phone', '01409590736', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
(21, 11, 'App\\Models\\User', 'country', 'United States', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
(22, 11, 'App\\Models\\User', 'state', 'New York', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
(23, 11, 'App\\Models\\User', 'city', 'barishal', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
(24, 11, 'App\\Models\\User', 'post_code', '45541', '2023-09-12 04:48:30', '2023-09-12 04:48:30'),
(25, 11, 'App\\Models\\User', 'address', 'sdmsdkfjskfjsok', '2023-09-12 04:48:30', '2023-09-12 04:48:30');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_01_000000_add_voyager_user_fields', 1),
(4, '2016_01_01_000000_create_data_types_table', 1),
(5, '2016_01_01_000000_create_pages_table', 1),
(6, '2016_01_01_000000_create_posts_table', 1),
(7, '2016_02_15_204651_create_categories_table', 1),
(8, '2016_05_19_173453_create_menu_table', 1),
(9, '2016_10_21_190000_create_roles_table', 1),
(10, '2016_10_21_190000_create_settings_table', 1),
(11, '2016_11_30_135954_create_permission_table', 1),
(12, '2016_11_30_141208_create_permission_role_table', 1),
(13, '2016_12_26_201236_data_types__add__server_side', 1),
(14, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(15, '2017_01_14_005015_create_translations_table', 1),
(16, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(17, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(18, '2017_04_11_000000_alter_post_nullable_fields_table', 1),
(19, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(20, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(21, '2017_08_05_000000_add_group_to_settings_table', 1),
(22, '2017_11_26_013050_add_user_role_relationship', 1),
(23, '2017_11_26_015000_create_user_roles_table', 1),
(24, '2018_03_11_000000_add_user_settings', 1),
(25, '2018_03_14_000000_add_details_to_data_types_table', 1),
(26, '2018_03_16_000000_make_settings_value_nullable', 1),
(27, '2019_05_03_000001_create_customer_columns', 1),
(28, '2019_05_03_000002_create_subscriptions_table', 1),
(29, '2019_05_03_000003_create_subscription_items_table', 1),
(30, '2019_08_19_000000_create_failed_jobs_table', 1),
(31, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(32, '2023_02_22_055833_create_products_table', 1),
(33, '2023_02_22_072723_create_shops_table', 1),
(34, '2023_02_22_073354_create_orders_table', 1),
(35, '2023_02_22_080337_create_addresses_table', 1),
(36, '2023_02_22_112352_add_new_shop_id__to_table', 1),
(37, '2023_02_25_071011_create_coupons_table', 1),
(38, '2023_02_25_074950_create_prodcats_table', 1),
(39, '2023_02_25_075231_create_prodcat_products_table', 1),
(40, '2023_03_05_055741_create_order_product_table', 1),
(41, '2023_03_17_053256_create_metas_table', 1),
(42, '2023_03_18_073329_create_ratings_table', 1),
(43, '2023_04_02_195652_create_emails_table', 1),
(44, '2023_04_13_072524_create_massages_table', 1),
(45, '2023_04_13_085601_create_shop_user_table', 1),
(46, '2023_04_13_091356_add_views_column_to_products', 1),
(47, '2023_05_02_064255_create_shop_policies_table', 1),
(48, '2023_05_03_170047_create_verifications_table', 1),
(49, '2023_05_07_084108_create_offers_table', 1),
(50, '2023_05_10_055120_create_tickets_table', 1),
(51, '2023_05_16_110306_add_paid_at_to_users_table', 1),
(52, '2023_05_21_202607_create_notifications_table', 1),
(53, '2023_05_28_085316_create_jobs_table', 1),
(54, '2023_07_08_071244_create_feedback_table', 1),
(55, '2023_09_09_062132_create_attributes_table', 2),
(56, '2023_09_09_062650_create_sliders_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=Unseen 1=seen',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `massage` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `shop_id` bigint UNSIGNED DEFAULT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=pending 1=paid 2=on its way 3=cancle 4=delivered',
  `currency` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `discount_code` int DEFAULT NULL,
  `shipping_total` int DEFAULT NULL,
  `shipping_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtotal` int NOT NULL,
  `total` int NOT NULL,
  `vendor_total` int NOT NULL,
  `seen` tinyint(1) NOT NULL,
  `tax` int DEFAULT NULL,
  `customer_note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `billing` json DEFAULT NULL,
  `shipping` json NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_paid` timestamp NULL DEFAULT NULL,
  `date_completed` timestamp NULL DEFAULT NULL,
  `refund_amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `aptment` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL,
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `total_price` int NOT NULL,
  `variation` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int UNSIGNED NOT NULL,
  `author_id` int NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `author_id`, `title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Hello World', 'Hang the jib grog grog blossom grapple dance the hempen jig gangway pressgang bilge rat to go on account lugger. Nelsons folly gabion line draught scallywag fire ship gaff fluke fathom case shot. Sea Legs bilge rat sloop matey gabion long clothes run a shot across the bow Gold Road cog league.', '<p>Hello World. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', 'pages/page1.jpg', 'hello-world', 'Yar Meta Description', 'Keyword1, Keyword2', 'ACTIVE', '2023-09-08 23:30:27', '2023-09-08 23:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `key`, `table_name`, `created_at`, `updated_at`) VALUES
(1, 'browse_admin', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(2, 'browse_bread', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(3, 'browse_database', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(4, 'browse_media', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(5, 'browse_compass', NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(6, 'browse_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(7, 'read_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(8, 'edit_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(9, 'add_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(10, 'delete_menus', 'menus', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(11, 'browse_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(12, 'read_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(13, 'edit_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(14, 'add_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(15, 'delete_roles', 'roles', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(16, 'browse_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(17, 'read_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(18, 'edit_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(19, 'add_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(20, 'delete_users', 'users', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(21, 'browse_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(22, 'read_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(23, 'edit_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(24, 'add_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(25, 'delete_settings', 'settings', '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(26, 'browse_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(27, 'read_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(28, 'edit_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(29, 'add_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(30, 'delete_categories', 'categories', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(31, 'browse_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(32, 'read_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(33, 'edit_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(34, 'add_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(35, 'delete_posts', 'posts', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(36, 'browse_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(37, 'read_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(38, 'edit_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(39, 'add_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(40, 'delete_pages', 'pages', '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(41, 'browse_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
(42, 'read_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
(43, 'edit_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
(44, 'add_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
(45, 'delete_products', 'products', '2023-04-07 11:28:10', '2023-04-07 11:28:10'),
(46, 'browse_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
(47, 'read_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
(48, 'edit_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
(49, 'add_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
(50, 'delete_coupons', 'coupons', '2023-04-07 12:15:49', '2023-04-07 12:15:49'),
(51, 'browse_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
(52, 'read_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
(53, 'edit_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
(54, 'add_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
(55, 'delete_addresses', 'addresses', '2023-04-07 12:26:46', '2023-04-07 12:26:46'),
(56, 'browse_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
(57, 'read_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
(58, 'edit_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
(59, 'add_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
(60, 'delete_prodcats', 'prodcats', '2023-04-07 12:36:57', '2023-04-07 12:36:57'),
(61, 'browse_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
(62, 'read_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
(63, 'edit_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
(64, 'add_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
(65, 'delete_ratings', 'ratings', '2023-04-07 12:44:57', '2023-04-07 12:44:57'),
(66, 'browse_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
(67, 'read_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
(68, 'edit_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
(69, 'add_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
(70, 'delete_shops', 'shops', '2023-04-07 12:55:50', '2023-04-07 12:55:50'),
(71, 'browse_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
(72, 'read_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
(73, 'edit_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
(74, 'add_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
(75, 'delete_orders', 'orders', '2023-04-08 09:32:52', '2023-04-08 09:32:52'),
(76, 'browse_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
(77, 'read_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
(78, 'edit_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
(79, 'add_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
(80, 'delete_sliders', 'sliders', '2023-04-11 11:40:01', '2023-04-11 11:40:01'),
(81, 'browse_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
(82, 'read_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
(83, 'edit_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
(84, 'add_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
(85, 'delete_verifications', 'verifications', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
(86, 'browse_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
(87, 'read_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
(88, 'edit_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
(89, 'add_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
(90, 'delete_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int UNSIGNED NOT NULL,
  `author_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('PUBLISHED','DRAFT','PENDING') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `seo_title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(1, 0, NULL, 'Lorem Ipsum Post', NULL, 'This is the excerpt for the Lorem Ipsum Post', '<p>This is the body of the lorem ipsum post</p>', 'posts/post1.jpg', 'lorem-ipsum-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(2, 0, NULL, 'My Sample Post', NULL, 'This is the excerpt for the sample Post', '<p>This is the body for the sample post, which includes the body.</p>\r\n                <h2>We can use all kinds of format!</h2>\r\n                <p>And include a bunch of other stuff.</p>', 'posts/post2.jpg', 'my-sample-post', 'Meta Description for sample post', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(3, 0, NULL, 'Latest Post', NULL, 'This is the excerpt for the latest post', '<p>This is the body for the latest post</p>', 'posts/post3.jpg', 'latest-post', 'This is the meta description', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(4, 0, NULL, 'Yarr Post', NULL, 'Reef sails nipperkin bring a spring upon her cable coffer jury mast spike marooned Pieces of Eight poop deck pillage. Clipper driver coxswain galleon hempen halter come about pressgang gangplank boatswain swing the lead. Nipperkin yard skysail swab lanyard Blimey bilge water ho quarter Buccaneer.', '<p>Swab deadlights Buccaneer fire ship square-rigged dance the hempen jig weigh anchor cackle fruit grog furl. Crack Jennys tea cup chase guns pressgang hearties spirits hogshead Gold Road six pounders fathom measured fer yer chains. Main sheet provost come about trysail barkadeer crimp scuttle mizzenmast brig plunder.</p>\r\n<p>Mizzen league keelhaul galleon tender cog chase Barbary Coast doubloon crack Jennys tea cup. Blow the man down lugsail fire ship pinnace cackle fruit line warp Admiral of the Black strike colors doubloon. Tackle Jack Ketch come about crimp rum draft scuppers run a shot across the bow haul wind maroon.</p>\r\n<p>Interloper heave down list driver pressgang holystone scuppers tackle scallywag bilged on her anchor. Jack Tar interloper draught grapple mizzenmast hulk knave cable transom hogshead. Gaff pillage to go on account grog aft chase guns piracy yardarm knave clap of thunder.</p>', 'posts/post4.jpg', 'yarr-post', 'this be a meta descript', 'keyword1, keyword2, keyword3', 'PUBLISHED', 0, '2023-09-08 23:30:27', '2023-09-08 23:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `prodcats`
--

CREATE TABLE `prodcats` (
  `id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prodcats`
--

INSERT INTO `prodcats` (`id`, `shop_id`, `name`, `logo`, `slug`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 5, 'Clair Gleichner', 'cat/1.png', 'walton.barrows', NULL, NULL, NULL),
(2, 4, 'Randall Hickle', 'cat/2.png', 'khalil77', NULL, NULL, NULL),
(3, 1, 'Rosario Blick', 'cat/3.png', 'chanelle.little', NULL, NULL, NULL),
(4, 3, 'Dr. Major Bruen IV', 'cat/4.png', 'faustino57', NULL, NULL, NULL),
(5, 4, 'River Reynolds', 'cat/5.png', 'price.johan', NULL, NULL, NULL),
(6, 2, 'Mrs. Corene Koss III', 'cat/1.png', 'qkuphal', NULL, NULL, NULL),
(7, 1, 'Reuben Gottlieb', 'cat/2.png', 'rosalee21', NULL, NULL, NULL),
(8, 1, 'Amari Ryan', 'cat/3.png', 'weissnat.hilario', NULL, NULL, NULL),
(9, 4, 'Alexis Purdy', 'cat/4.png', 'felton.collier', NULL, NULL, NULL),
(10, 3, 'Adeline Keebler I', 'cat/5.png', 'gabriel.mann', NULL, NULL, NULL),
(11, 4, 'Mollie Skiles', 'cat/1.png', 'alvena.marquardt', NULL, NULL, NULL),
(12, 1, 'Prof. Gabe Marvin', 'cat/2.png', 'vita11', NULL, NULL, NULL),
(13, 4, 'Prof. Coleman Leuschke PhD', 'cat/3.png', 'tobin.ryan', NULL, NULL, NULL),
(14, 1, 'Mr. Estevan Luettgen DVM', 'cat/4.png', 'earnestine.yundt', NULL, NULL, NULL),
(15, 4, 'Willa Mante', 'cat/5.png', 'schulist.jayda', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `prodcat_product`
--

CREATE TABLE `prodcat_product` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `prodcat_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prodcat_product`
--

INSERT INTO `prodcat_product` (`id`, `product_id`, `prodcat_id`, `created_at`, `updated_at`) VALUES
(3, 63, 2, '2023-09-12 02:11:43', '2023-09-12 02:11:43'),
(4, 63, 4, '2023-09-12 02:11:43', '2023-09-12 02:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `views` bigint NOT NULL DEFAULT '0',
  `sale_price` int DEFAULT NULL,
  `total_sale` int DEFAULT NULL,
  `downloads` text COLLATE utf8mb4_unicode_ci,
  `manage_stock` tinyint(1) NOT NULL DEFAULT '0',
  `quantity` int DEFAULT NULL,
  `weight` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensions` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating_count` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` bigint DEFAULT NULL,
  `vendor_price` decimal(10,0) DEFAULT NULL,
  `images` text COLLATE utf8mb4_unicode_ci,
  `variations` json DEFAULT NULL,
  `is_offer` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `shop_id`, `name`, `slug`, `type`, `status`, `featured`, `description`, `short_description`, `sku`, `price`, `views`, `sale_price`, `total_sale`, `downloads`, `manage_stock`, `quantity`, `weight`, `dimensions`, `rating_count`, `parent_id`, `image`, `post_code`, `vendor_price`, `images`, `variations`, `is_offer`, `created_at`, `updated_at`) VALUES
(1, 2, 'Prof. Emely Hessel Jr.', 'voluptatem-in-est-aspernatur-dolorem-quaerat-eum-fugit', 'repudiandae', 1, 0, 'Qui alias aut suscipit in esse harum recusandae. Dolores nam totam fugiat laborum. Doloribus voluptate quasi amet aut rerum. Et id voluptatem sed vel quo.', 'Non omnis at voluptate velit. Eum dicta dicta soluta non natus est voluptas sunt. Aliquam atque aut earum labore pariatur voluptatibus aut.', 'impedit', 118, 0, 534, 60, 'Distinctio et ullam vitae perferendis distinctio reprehenderit possimus accusantium. Omnis et sit quo qui sint sint vel. Sunt dolorem quos qui.', 0, 76, NULL, NULL, 4, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(2, 1, 'Miss Ruthie Schuster PhD', 'explicabo-deleniti-vitae-aut-nostrum-corrupti', 'quasi', 1, 0, 'Possimus dolor perferendis numquam veritatis illum. Occaecati neque dolore perspiciatis quis eligendi voluptas. Repudiandae itaque possimus delectus enim dolores illo molestias rerum.', 'Dignissimos a ipsum et occaecati ipsum. In et provident delectus ut. Et quibusdam aut beatae modi. Vero fugiat id esse provident qui doloribus et.', 'quidem', 355, 0, 342, 82, 'Voluptas dolorem id aut suscipit qui natus. Reiciendis veniam facere magnam sint id sit omnis. Quia occaecati assumenda assumenda recusandae et.', 0, 72, NULL, NULL, 3, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(3, 1, 'Norma Gerhold IV', 'non-et-eius-ullam-esse-error-recusandae-officiis', 'natus', 1, 0, 'Optio eius commodi assumenda commodi ut id necessitatibus. Ut atque dolorem ipsum unde minima architecto. Dolores saepe qui sunt tenetur.', 'Voluptas omnis molestiae quia dolor sunt ducimus tempora. Id et fugit placeat voluptas esse. Rerum quia omnis provident unde voluptas.', 'eos', 833, 0, 796, 88, 'Est ratione ab reprehenderit molestias. Maiores molestias sunt et itaque praesentium. Voluptatem praesentium molestiae dolores molestiae beatae dignissimos iure.', 0, 81, NULL, NULL, 1, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(4, 2, 'Prof. Magdalena Schiller', 'voluptatem-in-et-non-nesciunt-facere-et-dolor-voluptatem', 'nulla', 1, 0, 'Illum ut odit vitae rem consequatur eius eum. Eum est neque est nesciunt quo culpa vel. Dicta id cum omnis dignissimos.', 'Qui labore ipsam placeat et consequatur eius. Nulla itaque provident quia dolorem. Impedit fugiat tempore eum odit et. Consequatur aut iusto hic velit.', 'unde', 658, 0, 263, 57, 'Nihil voluptatem est sunt sed et. Natus ex velit rem ut est eveniet. Accusantium et nobis qui officiis. Omnis facilis eaque deserunt.', 0, 34, NULL, NULL, 4, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(5, 1, 'Glenda Parisian', 'aut-hic-at-ut-tempore-sit-optio-facilis', 'pariatur', 1, 0, 'Voluptates porro consectetur quia quo qui. Quo praesentium incidunt saepe perferendis. Magnam odit quia possimus vitae aut maiores molestias. Rerum accusamus architecto est et et temporibus labore.', 'Aliquid quo ut nulla tempore id consequatur amet quia. Ipsam totam commodi nemo possimus. Eum et voluptas necessitatibus excepturi molestiae laudantium voluptatibus.', 'qui', 860, 0, 599, 62, 'Sequi minima dolores eius repellendus. Natus at repellat numquam sed unde sed. Sit numquam ullam omnis libero debitis aut alias. Quas unde aut dolorem adipisci fugit eaque.', 0, 66, NULL, NULL, 2, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(6, 4, 'Freda Bayer IV', 'iste-quia-fuga-nam-officiis-repellat', 'quo', 1, 0, 'Velit debitis dolorem minus error est velit. Ut voluptatem aut ducimus rerum repudiandae. Quidem corporis at dolore.', 'Ut ratione harum praesentium. Magnam libero repudiandae quia eius et. Est blanditiis sunt molestiae temporibus quo impedit.', 'modi', 507, 0, 731, 44, 'Dolor eligendi consequatur ea numquam quam. Adipisci voluptatem distinctio sint reiciendis labore ipsum sint et. Sunt animi a et rerum. Ut non eum tempora consequatur laudantium.', 0, 92, NULL, NULL, 2, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(7, 1, 'Prof. Jimmy Block', 'voluptas-animi-est-unde', 'officia', 1, 0, 'Voluptas voluptatem fuga sint facere. Vero doloremque ullam et molestias. Omnis occaecati minima sint et. Sequi maiores itaque sequi est sunt aspernatur excepturi. Aut quia iste voluptate odio et.', 'Voluptas eaque id omnis. Eligendi et dolor incidunt quasi eum et ipsam. Eos tempora iusto eligendi debitis. Neque ut sunt quidem blanditiis porro.', 'est', 575, 0, 712, 13, 'Vero ea quaerat suscipit non velit minima. Quod sint non est amet id itaque beatae. Laborum quisquam natus molestiae cum.', 0, 12, NULL, NULL, 5, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(8, 5, 'Rose Dare', 'voluptas-vitae-ratione-voluptatibus-ut-ratione', 'similique', 1, 0, 'Debitis voluptas dicta est ipsa et at. Ipsam explicabo et dolorem. Maiores libero ullam fugit doloribus quia quo.', 'Voluptate ut in quasi aut. Commodi sequi tenetur tenetur quidem. Et voluptates aliquid perferendis laboriosam.', 'numquam', 241, 0, 317, 31, 'Rerum accusantium soluta dolor numquam. Quia quia nam a aut saepe. Omnis doloremque in perspiciatis recusandae minus.', 0, 74, NULL, NULL, 1, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(9, 1, 'Vada Leannon', 'eum-placeat-quaerat-culpa-repellat-quo-velit-odio', 'dignissimos', 1, 0, 'Autem tempora molestias dolor dignissimos commodi. Ut fugiat voluptatem in ipsum in molestiae voluptatum laborum.', 'Enim molestias tempora placeat aliquam soluta. Iusto iure rerum illum magnam ullam officia. Aspernatur hic cumque vero modi occaecati qui est.', 'velit', 139, 0, 705, 26, 'Qui ab aliquid quam esse. Architecto nostrum dolorum adipisci sequi. Nesciunt nesciunt omnis commodi maxime hic sunt reiciendis.', 0, 10, NULL, NULL, 5, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(10, 4, 'Herman Gerhold', 'doloremque-ut-dolore-et-doloremque-numquam-aut-quisquam', 'laboriosam', 1, 0, 'Occaecati illum quaerat magnam. Id quis dolorem nisi. Minima nesciunt dolore quis voluptatem similique debitis laborum.', 'Amet suscipit ut occaecati modi ex. Eos enim dicta commodi rerum sed enim deserunt. Corrupti eveniet dolor quod blanditiis asperiores.', 'nemo', 414, 0, 328, 74, 'Et quaerat sapiente repudiandae ut quisquam. Nihil aut quidem non quis autem. Dicta dicta quia excepturi aut placeat. Sequi est placeat et itaque iure vitae.', 0, 79, NULL, NULL, 1, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(11, 2, 'Miss Margarett Schaefer', 'hic-dicta-dolorem-itaque', 'sapiente', 1, 0, 'Dicta debitis mollitia ad velit. Eum aut sit tempora qui aut est. Qui quam dolor necessitatibus odit nihil qui. Dolores iste sunt minus consectetur voluptas reprehenderit est.', 'Qui nemo nisi totam dolores enim voluptas nemo ut. Voluptatem est reiciendis distinctio enim id.', 'maxime', 844, 0, 164, 72, 'Amet dolor sit voluptate officia cum vero. Voluptates explicabo asperiores possimus iusto. Consequatur exercitationem et laborum modi nulla voluptatum ea.', 0, 85, NULL, NULL, 5, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(12, 5, 'Florian Medhurst I', 'sit-provident-ullam-aliquam-eveniet-et-magni-excepturi', 'impedit', 1, 0, 'Ad nostrum facere harum fugiat. Rem magni sit ut rerum debitis excepturi eligendi. Deserunt architecto omnis sit. Explicabo voluptates dolore est similique quo consequatur enim sed.', 'Eum exercitationem asperiores iusto facilis voluptatibus quis sequi. Excepturi neque in minima vel. Nihil magni beatae dolores.', 'quia', 499, 0, 951, 37, 'Quaerat soluta deserunt eligendi. Dolores consequatur eos eos iusto. Ut aliquam voluptas dignissimos labore ipsum facere.', 0, 30, NULL, NULL, 1, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(13, 2, 'Dr. Christy Keebler III', 'occaecati-placeat-est-officiis-dolorem', 'ut', 1, 0, 'Maxime in laborum consequatur. Quia inventore aut doloremque ipsam excepturi et. Voluptates soluta qui expedita aut quam quis. Non voluptatem quo debitis ipsum.', 'Vitae in qui facere voluptatibus. In velit numquam et qui consequuntur. Nihil aut iste laborum enim omnis et debitis quaerat. Nam qui voluptates eum dolores quia consectetur.', 'officia', 984, 0, 463, 15, 'Omnis cum aut ullam voluptatem. Necessitatibus suscipit vel at odio cumque sit. Illum nemo tenetur expedita quos qui.', 0, 77, NULL, NULL, 2, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(14, 4, 'Jaylon Strosin', 'amet-excepturi-laboriosam-qui-qui-quod-dolores', 'recusandae', 1, 0, 'Dolorum enim hic dolorem et est. Id rerum non quos temporibus est repellat. Sit et enim non explicabo provident.', 'Quisquam odit saepe rerum occaecati. Reiciendis facere quae a. Ut sit laboriosam et fugit deserunt occaecati natus corporis.', 'incidunt', 849, 0, 142, 55, 'Delectus nemo sapiente qui deserunt expedita molestiae omnis. Ipsa recusandae porro recusandae. Atque est quod nisi amet in quidem. Dolorem aut et id voluptatem.', 0, 97, NULL, NULL, 2, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(15, 5, 'April Rempel', 'voluptatibus-in-quae-dolorem-dolore-quis', 'est', 1, 0, 'Illum qui recusandae vitae id velit. Voluptas perferendis iste dolor velit fugit velit. Quam qui sit rerum omnis error reprehenderit. Sapiente aut et porro accusamus.', 'Temporibus ut rem quia. Sunt culpa sed expedita suscipit eum. Aliquid molestiae dolore ut.', 'deleniti', 483, 0, 684, 35, 'Nostrum quidem iste et dolores amet voluptates unde. Dolor ut cum quis quia maxime magnam. Voluptatum dolor atque dolorem qui.', 0, 48, NULL, NULL, 5, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(16, 2, 'Greta Harvey', 'ullam-rem-voluptates-quia-eaque-aliquam', 'fugit', 1, 0, 'Sed dignissimos dicta temporibus sequi. Nihil fugit quia ipsam cumque et. Delectus qui neque aspernatur est. Aut animi odio velit dolore non dolorem sint.', 'Aut quibusdam quo et et quae possimus. Aut dolor quo quo quam optio quidem non. Aut adipisci asperiores tenetur mollitia veniam modi. Ex cupiditate cumque quae dolores et ipsum quia deleniti.', 'unde', 767, 0, 752, 47, 'Amet quam veritatis est et necessitatibus. Error rerum consequatur rerum est. Veniam corrupti iusto numquam ea.', 0, 11, NULL, NULL, 5, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(17, 5, 'Miss Zoe Maggio', 'aut-qui-sit-qui-ut-occaecati-molestiae', 'tempore', 1, 0, 'Autem ut voluptates eligendi nihil. Eligendi et eum vel et. Odit temporibus in et modi quasi officiis incidunt. Veritatis quis et fugit aut.', 'Atque non necessitatibus nihil. Nam ut reprehenderit esse molestiae et fugiat consequuntur. At dolores provident nobis iusto enim delectus ipsa.', 'fugiat', 941, 0, 812, 95, 'Quis vel aut eveniet corrupti nihil nobis. Accusantium ut quo soluta distinctio dolore labore. Et praesentium incidunt tenetur dolores est ut blanditiis consequatur.', 0, 54, NULL, NULL, 5, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(18, 5, 'Nathanael Wisoky', 'iusto-quo-nobis-nesciunt-consequuntur', 'ad', 1, 0, 'Repellat officia esse voluptates perspiciatis laudantium consequatur. Unde quo quo ea placeat non iure. Et aut harum officiis.', 'Aperiam praesentium et aut. Aperiam vel minima assumenda enim laborum ut. Doloremque ut aut sit reprehenderit.', 'corrupti', 959, 0, 732, 14, 'Repudiandae qui quibusdam ut. Deleniti nam laboriosam voluptas fugit qui unde. Consequatur nihil odit id quod omnis neque odit. Accusantium voluptatem animi cum.', 0, 94, NULL, NULL, 5, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(19, 3, 'Melba Trantow', 'optio-deserunt-quod-autem', 'rerum', 1, 0, 'Facere at in ullam sit non. Consequatur non asperiores ullam dolores quibusdam. Fuga sequi veritatis rerum maiores id error modi. Qui ut eaque dolorum deleniti eum voluptatem.', 'Et velit aliquid sed odit praesentium occaecati. Necessitatibus eos quo voluptas. Placeat iusto amet officia ut rerum. Adipisci a iusto veniam consequuntur nobis velit.', 'nemo', 590, 0, 211, 66, 'Quia ipsum iste quia aut autem omnis. Autem aut sed non velit ullam explicabo fugiat. Est ducimus autem et optio ea et.', 0, 58, NULL, NULL, 1, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(20, 3, 'Elna Walsh', 'fugit-ullam-totam-aut', 'voluptas', 1, 0, 'Ut enim aut excepturi rerum at est doloremque. Blanditiis at ut rem error aut tempora. Exercitationem voluptatem est numquam eveniet corporis delectus voluptates.', 'Sed minima commodi nulla et est perferendis. Eveniet ea deserunt ducimus facere hic molestias error. Ipsa a illo aperiam ut inventore rerum.', 'iusto', 457, 0, 956, 15, 'A laboriosam modi qui quia nihil saepe. Delectus ut temporibus facilis veniam inventore sit. Nihil nam qui aliquam voluptatem nobis tenetur.', 0, 95, NULL, NULL, 2, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(21, 4, 'Desiree Kassulke', 'in-est-et-nesciunt-expedita-illum', 'aspernatur', 1, 0, 'Dolorem reprehenderit laboriosam ab error in. Quis quas quo quis sint. Rerum veritatis aliquam accusamus possimus quae autem.', 'Itaque voluptatum quis dolore inventore. Fuga quis non iste et qui a rerum porro. Distinctio consequatur non dignissimos ex. Ea dolores cumque alias explicabo in aliquam repellendus qui.', 'provident', 248, 0, 564, 79, 'Id eos cumque laborum et facilis reprehenderit reiciendis impedit. Perferendis ut quibusdam aut praesentium rerum nulla. Impedit aut qui illo officia libero laudantium. Qui ullam magnam ut.', 0, 95, NULL, NULL, 4, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(22, 1, 'Prof. Allen Crooks Jr.', 'in-reiciendis-temporibus-libero-est-omnis-in-sint', 'odio', 1, 0, 'Enim et doloremque beatae tenetur enim. Et assumenda amet aperiam voluptatem. In aliquid enim animi quasi. Voluptatem et corporis illo minus laboriosam rem.', 'Natus eius saepe ipsa sit enim pariatur et. Similique soluta quae quidem impedit et sint nesciunt. Rerum at dicta possimus sapiente vitae labore vitae voluptatem. Tempora soluta qui nesciunt rerum.', 'qui', 375, 0, 322, 92, 'Et maxime velit amet explicabo similique sunt maiores autem. Consequatur aut tenetur minus eius sit exercitationem facilis quaerat.', 0, 15, NULL, NULL, 5, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(23, 2, 'Karley Beer DVM', 'nostrum-quia-magni-iure-impedit', 'consequatur', 1, 0, 'Ab quia hic similique et ullam eum. Eaque voluptas quas aut. Voluptates est et enim distinctio fuga molestiae sunt. Odio harum tenetur facere tempore sapiente.', 'Vero qui quis magni qui blanditiis. Excepturi voluptatum voluptas voluptas rerum possimus sit. Quia corporis eveniet ut voluptas.', 'eum', 648, 0, 522, 53, 'Recusandae officiis voluptas sequi ut omnis. Consequuntur consequatur rerum quidem. Placeat id aspernatur voluptates unde odit. Sit nobis quae est beatae doloribus.', 0, 78, NULL, NULL, 1, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(24, 5, 'Ryann Marquardt', 'repudiandae-adipisci-ratione-quia-molestiae-quasi-necessitatibus-earum-occaecati', 'esse', 1, 0, 'Et non dolorum qui eum et libero. Unde possimus dolorem ea. Vitae porro odio necessitatibus voluptatibus veritatis cumque et.', 'Voluptas quia inventore aperiam adipisci excepturi aperiam est autem. Rerum et qui sint ipsa.', 'adipisci', 448, 0, 281, 13, 'Magni quisquam necessitatibus aspernatur modi nobis. Voluptatem quo quidem in perspiciatis minus ex. Non corporis praesentium repudiandae error.', 0, 58, NULL, NULL, 3, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(25, 2, 'Torrey Pacocha', 'eum-eveniet-reprehenderit-et-sed-laboriosam', 'doloremque', 1, 0, 'Doloremque quidem accusamus asperiores. Praesentium est in omnis quo sunt dolor ea sunt. Doloremque rem dolor nobis quo qui. Labore illo quam id voluptatem hic adipisci.', 'Dolores et voluptatem ducimus dolores dolor. Inventore esse aliquam cumque consequatur autem corporis at rem. Reiciendis repellat qui et libero velit aut veritatis.', 'non', 178, 0, 215, 26, 'Harum ullam ducimus sapiente provident incidunt et qui. Optio quaerat sed itaque officia nesciunt. Porro et sequi at aut.', 0, 88, NULL, NULL, 2, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(26, 4, 'Eldora Blick Jr.', 'inventore-nihil-fugit-et-nulla', 'voluptatum', 1, 0, 'Libero expedita corrupti laudantium tempora vel fuga earum occaecati. Non veritatis ea expedita eos. Nam fuga tenetur pariatur hic et quod.', 'In sed incidunt consectetur quibusdam velit velit dolores. Eius dolorem id placeat sint. Possimus ut voluptates eos quia. Voluptatem quidem totam voluptatem aliquam voluptates facere.', 'placeat', 537, 0, 501, 90, 'Nisi doloremque enim soluta tempora. Vel et quidem et sed consequatur distinctio. Soluta qui maiores quaerat totam. Repellendus ut dolor quis qui.', 0, 44, NULL, NULL, 4, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(27, 1, 'Natalia Rempel', 'in-neque-excepturi-temporibus-beatae-aliquid-id-in', 'quaerat', 1, 0, 'Est aut et fugiat officiis a aperiam. Error error ipsam earum aperiam aut nulla sit. Quo quidem eos mollitia cum. Voluptas consequuntur molestiae sed et.', 'Sint consequatur laudantium doloremque sint. Nisi unde omnis autem rerum. Sapiente voluptatem voluptatem id et nisi voluptatem. Laudantium libero earum earum.', 'sit', 988, 0, 235, 84, 'Quam suscipit et cupiditate atque quibusdam officia cupiditate. Totam molestiae et delectus. Nobis velit in distinctio quae.', 0, 73, NULL, NULL, 1, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(28, 2, 'Boris Ernser II', 'ab-dolores-minus-voluptates-corporis', 'corporis', 1, 0, 'Unde veniam corporis minima porro nam. Vero quo omnis quia dolor qui. Sunt voluptas commodi repudiandae voluptatibus adipisci voluptatem quas.', 'Veritatis quis ullam voluptas provident rerum enim. Doloribus ut qui tenetur. Possimus laborum excepturi architecto reiciendis possimus eos quia.', 'et', 672, 0, 145, 40, 'Nemo omnis quo aliquam omnis veniam. Impedit repellat nobis temporibus autem. Quo soluta ipsa nihil.', 0, 24, NULL, NULL, 5, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(29, 2, 'Dr. Grant Cruickshank MD', 'ex-in-in-consequatur-quis-error', 'minima', 1, 0, 'Ab nesciunt est aut voluptatem neque sunt odio. Voluptatem quo dolor velit eos odio. Qui sunt officiis qui modi molestiae impedit est.', 'Rem nihil tenetur voluptatibus eum omnis consequatur. Voluptatum molestias iste quos est. Quisquam totam asperiores ducimus quasi quae sit quia.', 'expedita', 252, 0, 483, 34, 'Velit recusandae atque ipsum sit dolores suscipit autem. Atque libero odit ab nostrum. Pariatur et sint itaque odit. Corporis similique veniam occaecati ut doloribus.', 0, 30, NULL, NULL, 5, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(30, 4, 'Miss Phoebe Runolfsson DDS', 'placeat-distinctio-deleniti-sed-quia-quisquam-qui-quidem-ipsum', 'voluptatem', 1, 0, 'Eveniet sit quis voluptas ipsa quaerat ad optio. Omnis perferendis dolorum id sed et.', 'Labore magni rerum distinctio voluptate suscipit qui. Corrupti autem magni est architecto impedit esse blanditiis. Maiores placeat ut modi itaque quis. Aliquam et maiores omnis quae.', 'veritatis', 480, 0, 788, 53, 'Commodi est maiores mollitia et provident. Esse omnis dolores aut deleniti itaque.', 0, 84, NULL, NULL, 4, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(31, 1, 'Agustin Bernier', 'sit-aut-at-pariatur', 'ea', 1, 0, 'Unde consequatur quis cum assumenda quaerat facilis ut vitae. Nobis est qui quos aut. Est id voluptatem accusantium dolor et. Laboriosam hic numquam quam sunt quam.', 'Quia ab numquam dolorum a voluptatem possimus occaecati. Nulla quia qui tempore libero exercitationem error quod.', 'atque', 662, 0, 624, 12, 'Aut vel cumque dignissimos rem qui amet consectetur. Aut odio at veritatis ut molestiae. Consequatur praesentium qui aut.', 0, 30, NULL, NULL, 5, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(32, 2, 'Amos O\'Conner', 'non-consequatur-enim-et-ducimus-consequatur-itaque-sit', 'ut', 1, 0, 'Ipsa quaerat et quibusdam sed quia. Consequatur dolores delectus sunt voluptatem.', 'Officia reprehenderit nihil ut voluptas consequatur quia error. Voluptatem sapiente qui qui ea ab quidem voluptates. Placeat corporis molestiae dolor et dolores.', 'est', 355, 0, 352, 17, 'Qui modi tempore enim ab animi ipsam. Natus voluptas numquam delectus ex voluptas ut. Nihil sed numquam minima et molestiae amet non voluptas. Tenetur beatae eaque similique fuga.', 0, 82, NULL, NULL, 3, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(33, 3, 'Dr. Celia West', 'dolor-perspiciatis-sunt-unde-maiores-fugit-possimus', 'qui', 1, 0, 'Laudantium quasi in nobis corrupti. Qui voluptas et quibusdam minus asperiores quaerat. Quo cum et vel omnis minima fugiat ut. Animi amet possimus at est consectetur modi debitis molestiae.', 'Quo in soluta laborum est nesciunt quasi incidunt. Accusamus quam aut facere omnis. Ullam saepe ipsa ut fugiat expedita officiis. Quia nisi rem aut. Omnis voluptates sint enim quasi cupiditate.', 'voluptate', 859, 0, 921, 75, 'Quibusdam harum fugit totam. Dolorem expedita nulla deserunt earum numquam sunt incidunt est.', 0, 60, NULL, NULL, 1, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(34, 4, 'Clarissa Fay', 'molestiae-similique-autem-harum-debitis-eaque-doloremque-totam', 'at', 1, 0, 'Autem iste eaque a enim. Vel debitis et omnis repudiandae enim sunt. Voluptas optio quam accusamus ullam eos. Commodi et veritatis eius sit.', 'Aliquam id voluptas enim alias commodi aut maiores adipisci. Necessitatibus saepe sequi quas aut reprehenderit deserunt rerum. Rerum laborum debitis sit animi exercitationem veritatis.', 'quam', 729, 0, 185, 70, 'Quasi aut nostrum sed id dolorem eveniet. Sit rerum dicta magni enim. Optio maiores laborum sequi vero est. Libero quaerat dolor error.', 0, 39, NULL, NULL, 2, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(35, 3, 'Greyson Christiansen', 'consequatur-similique-necessitatibus-sunt-sed-iure-vero-id-ut', 'ex', 1, 0, 'Harum molestias accusamus tenetur assumenda numquam dicta voluptatem rem. Aliquid enim delectus consequuntur eum. Qui assumenda eius dolorem velit facilis quo. Vero voluptatem sapiente ipsum ut.', 'Odio dolorem omnis molestiae sit quia et aperiam. Magnam repudiandae inventore alias. Quas quia et voluptatem.', 'reiciendis', 286, 0, 529, 60, 'Fugiat dolor ipsa porro recusandae necessitatibus. Ut officiis corporis ut neque voluptas quia. Odit sequi ad saepe est rerum.', 0, 26, NULL, NULL, 3, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(36, 5, 'Bertha Parker', 'et-inventore-itaque-impedit-dolorum-consectetur', 'omnis', 1, 0, 'Sint quae temporibus neque beatae. Quaerat odio fugit amet sunt dolorem tenetur sunt. Totam non accusantium consequatur rerum et aperiam.', 'Quod corporis id voluptatibus iusto officiis officiis. Et ea sed iure omnis totam minus molestias nulla. Quia aspernatur perspiciatis et praesentium adipisci modi aut.', 'culpa', 649, 0, 106, 14, 'Earum et soluta voluptates iste. Magni optio exercitationem blanditiis odio consequatur incidunt culpa. Tenetur distinctio atque ipsum iure dignissimos accusamus aspernatur.', 0, 86, NULL, NULL, 3, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(37, 3, 'Prof. Virginie Wolff', 'inventore-corporis-similique-natus-voluptatem-ratione', 'repellat', 1, 0, 'Sunt est repellendus rem quo quia harum dolorem. Non delectus aut cupiditate eveniet fuga.', 'Repellendus qui hic est quis accusamus molestiae libero. Sit dignissimos soluta sed reprehenderit sed. Quisquam nostrum reprehenderit vel odit natus.', 'ducimus', 583, 0, 564, 28, 'Laudantium deleniti quibusdam in at. Est provident et debitis. Eius cum temporibus et enim rerum voluptatem. Odio et nihil eius iure sapiente.', 0, 61, NULL, NULL, 2, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(38, 3, 'Rosie Connelly', 'assumenda-sed-commodi-est-neque-nemo', 'repellendus', 1, 0, 'Ratione veniam sit nesciunt expedita iusto nesciunt non. Voluptas adipisci eaque laborum accusamus. Consequuntur quo saepe eius fugiat dolores provident alias ducimus. Dolor itaque ea quod.', 'Eum laborum eaque dolores numquam. Nobis tempora in itaque sit sit alias molestiae perferendis. Magnam iusto enim dolores rerum odit id.', 'autem', 222, 0, 804, 18, 'At molestiae quaerat culpa quidem odio. Laboriosam saepe est et vel sed. Eaque sit voluptatum incidunt enim assumenda id.', 0, 80, NULL, NULL, 5, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(39, 2, 'Prof. Virginie Klein Jr.', 'et-nostrum-laboriosam-sed-rerum', 'veniam', 1, 0, 'Rerum voluptas recusandae similique vel repudiandae ea. Omnis vitae delectus voluptatibus cum quo laudantium. Ipsam eius nisi porro qui consequatur et autem. Sint maxime recusandae non magni enim et.', 'Laboriosam quas voluptas excepturi quis ab. Consequuntur quia omnis aperiam fugiat harum tenetur porro. Aut alias vel incidunt unde odit.', 'vitae', 367, 0, 701, 36, 'Reiciendis itaque et debitis optio maiores quia. Tempore exercitationem molestias eveniet unde deleniti et. Impedit et eius aut fugiat eum ratione unde. At velit in nesciunt.', 0, 93, NULL, NULL, 1, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(40, 1, 'Izabella Goldner', 'culpa-rerum-est-quis-nesciunt-aliquid', 'dolorem', 1, 0, 'Totam eaque vel ratione nulla. Quasi sequi dolorum assumenda nobis nostrum assumenda recusandae ut.', 'Beatae aut autem doloremque maxime accusamus. Quasi neque non ut ut rerum ut omnis. Sunt sit nam repellat ut quia neque sint.', 'expedita', 348, 0, 843, 56, 'Sed ipsam repudiandae repudiandae vel sequi beatae. Ea modi debitis dicta est laborum saepe. Inventore id ipsum minus omnis veniam doloribus sint. Provident earum quisquam alias consequatur.', 0, 66, NULL, NULL, 3, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(41, 4, 'Evert Oberbrunner V', 'ullam-consequatur-eos-harum-assumenda-nihil', 'vitae', 1, 0, 'Repudiandae eligendi veniam non quia atque aperiam. Nulla perspiciatis dolor a sunt. Est dolor consequatur corrupti ratione laborum ullam quo. Quidem ut rerum est minima libero odit corporis.', 'Voluptas quidem voluptatem sit delectus voluptates laborum. In qui neque quasi tempora. Asperiores quo ea sint vel ut quaerat quaerat.', 'iste', 151, 0, 910, 79, 'Nihil et ratione iste nulla ducimus consequuntur. Quod incidunt ut ipsa illum voluptatibus molestiae odit. Est tempora est perferendis nesciunt deleniti magnam nobis.', 0, 14, NULL, NULL, 5, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(42, 4, 'Prof. Christopher Spencer', 'quas-voluptatum-expedita-pariatur-sapiente', 'recusandae', 1, 0, 'Officia impedit cumque veritatis odio totam aut. Maiores qui qui vero iusto aliquid. Est dignissimos ratione error.', 'Ipsa porro suscipit consectetur reiciendis molestias. Vero non asperiores tempora recusandae necessitatibus explicabo. Eos voluptas inventore repudiandae veniam veritatis dolor.', 'recusandae', 447, 0, 323, 34, 'Molestias ipsam fugiat ut corrupti beatae et. Libero voluptas minima sint reiciendis exercitationem. Et necessitatibus et dolorum magnam dicta voluptatibus. Ea qui aut dolorem excepturi et sequi.', 0, 38, NULL, NULL, 1, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(43, 3, 'Myah Ullrich', 'facilis-sit-tenetur-asperiores-aut-odit-mollitia-molestias', 'assumenda', 1, 0, 'Consequatur possimus voluptatum maiores quibusdam. Rerum asperiores doloribus omnis et. Cum sed voluptatem facilis temporibus. Quis quia aut atque corrupti.', 'Tempore corrupti rem sint delectus. Aut et ea non. Rem consequatur odio sit pariatur eum corrupti cumque. Odit error possimus omnis.', 'qui', 320, 0, 729, 65, 'Sunt quo amet quia libero iure vitae quo. Qui quod ut delectus est suscipit porro non. Eaque est deleniti architecto voluptas qui.', 0, 83, NULL, NULL, 4, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(44, 5, 'Mrs. Evalyn Doyle', 'et-nam-quia-est-quidem-id', 'architecto', 1, 0, 'Accusantium rem sunt est est est iste ipsam maxime. Dolorem sint omnis eligendi autem. Dolores labore corporis aliquid in repudiandae dolore. Dicta ut voluptas laudantium voluptatem.', 'Sunt fuga sed magnam enim mollitia laboriosam ut. Illum suscipit rerum dolor est iste sequi. Modi amet excepturi sit maiores aliquid fuga est.', 'maxime', 455, 0, 225, 38, 'Ut quod suscipit quo praesentium omnis. Non eos vel qui necessitatibus ut. Rerum sunt quos et.', 0, 69, NULL, NULL, 5, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(45, 3, 'Rodrigo Huel', 'aut-doloribus-tempora-omnis-id-harum-laudantium', 'ea', 1, 0, 'Sit eligendi dolore sapiente aut doloribus aut nemo. Laudantium voluptatem molestiae blanditiis doloribus ea. Placeat quia itaque eum quae. Cupiditate eum voluptates ut omnis quas voluptas.', 'Delectus consequatur laboriosam id ratione. Adipisci animi quia labore. Eaque porro totam possimus asperiores iusto.', 'et', 697, 0, 278, 23, 'Incidunt molestiae quaerat recusandae molestiae repellat asperiores aut. Non ex optio facilis. Cumque impedit iusto harum rerum qui unde id nihil. Ipsam impedit vel provident possimus.', 0, 64, NULL, NULL, 1, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(46, 1, 'Elnora Emard', 'voluptas-velit-dolorem-dolor-provident-nihil-fuga', 'assumenda', 1, 0, 'Et aspernatur ut ea quia ipsum veritatis velit amet. Mollitia eos mollitia qui voluptatem autem. Repudiandae nisi aliquid dolorem vero ad dolorem consequuntur est.', 'Et est aut excepturi et porro quam. Cumque repellendus eligendi in. Illum aliquam pariatur voluptate non qui. Labore soluta similique est maiores aut.', 'maxime', 307, 0, 280, 67, 'Et eaque dolores qui repellat aliquid ad id. Ut dolor laboriosam itaque aut. Similique aliquam rem sit illo maxime. Animi nemo explicabo aut illo ab.', 0, 22, NULL, NULL, 2, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(47, 1, 'Ms. Maybelle Monahan DVM', 'in-non-eos-omnis-autem', 'omnis', 1, 0, 'Quam hic magni harum minus nesciunt consequatur sequi recusandae. Aliquid accusantium enim excepturi rem dolores voluptatem rerum. Ipsam expedita quas molestiae enim.', 'At cupiditate nulla maxime rerum perferendis accusantium. Corrupti architecto maiores provident omnis reprehenderit sit. Adipisci voluptates vitae nisi nemo consequatur sapiente maiores.', 'illum', 923, 0, 533, 52, 'Voluptatem minus earum non quas earum. Perferendis omnis recusandae ut quo labore nihil. Reiciendis est voluptas et exercitationem rem optio enim.', 0, 47, NULL, NULL, 3, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(48, 5, 'Earnestine Dibbert', 'non-sunt-atque-et-libero-consequuntur-et', 'assumenda', 1, 0, 'Vero est perspiciatis tenetur dolores. Odio tempora asperiores nihil. Id laboriosam nobis ut odit inventore deserunt tenetur. Rem ipsum aut quasi perferendis.', 'Et ea ut a. Sed odit quod expedita magni dolorum. Itaque perferendis voluptas sint rerum. Dolorem earum asperiores in numquam ullam accusantium omnis at.', 'voluptatem', 919, 0, 537, 28, 'Amet et aliquid rerum rerum nostrum. Sit eum velit non quasi voluptatem voluptas. Architecto consequuntur voluptatem eaque tempora soluta id. Pariatur modi voluptates iure quis officia aut.', 0, 66, NULL, NULL, 4, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(49, 3, 'Josh Mante DDS', 'vel-dolorum-voluptate-voluptas-doloribus-minima-possimus-nihil', 'animi', 1, 0, 'Voluptatum ut minima iusto tempore voluptas. Excepturi et voluptate libero. Sed praesentium sit adipisci quae porro harum fugiat. Laboriosam dolores nihil fuga sunt praesentium et eos.', 'Consectetur qui ea corporis reiciendis non eveniet omnis. Repellendus dolorem labore eligendi eos. Dolor iusto quae laudantium quia unde earum.', 'nihil', 839, 0, 784, 76, 'Ut non voluptates aut autem magni. Ut tempore et libero molestias et. Non non voluptatem sunt nostrum ut possimus quis. Rerum consequatur fugit cupiditate porro dolor id.', 0, 49, NULL, NULL, 3, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(50, 1, 'Cheyanne Williamson', 'at-rerum-magnam-commodi-culpa-doloremque', 'eligendi', 1, 0, 'Consectetur aut molestiae est nihil. Facere id minus modi excepturi voluptas omnis. Id est et soluta at odio. Rerum nihil ut dicta rerum. Amet repellendus eius enim facilis enim impedit corporis.', 'Nihil sunt harum officiis. Et aliquam perspiciatis pariatur iusto ipsa aut sed. Facilis qui et fugiat nemo incidunt delectus.', 'impedit', 934, 0, 663, 20, 'Vel ipsam architecto debitis. Fugiat ratione et inventore. Consequuntur ipsa ut sint facilis soluta unde.', 0, 78, NULL, NULL, 5, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(51, 3, 'Leatha Kovacek Sr.', 'quis-eum-aliquid-reiciendis-labore-unde-eum-molestiae', 'libero', 1, 0, 'Et vel veniam ipsum expedita deserunt alias. Aut molestiae officia et. Reprehenderit iure aut enim possimus atque.', 'Nemo reprehenderit aut sed est soluta pariatur voluptas. Dolor quo sed sint placeat.', 'sit', 586, 0, 669, 97, 'Omnis qui magni ipsum possimus est recusandae voluptatem omnis. Cumque veniam magnam vel voluptas voluptates corporis harum. Unde voluptatem vero rerum quisquam. Aut veritatis dolores et et.', 0, 60, NULL, NULL, 5, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(52, 2, 'Ebony Halvorson', 'saepe-et-error-et-ullam-distinctio-aut-inventore-ipsum', 'nostrum', 1, 0, 'Repudiandae pariatur nemo vel autem. Minus perspiciatis dolore nostrum labore sunt ex id. Inventore error dolores itaque minus rerum omnis. Est omnis aut necessitatibus alias a at ut ullam.', 'Deleniti doloremque minus architecto quo dolores atque consequatur sint. Facilis consequuntur culpa repudiandae. Nesciunt dolore ut quis. Tempora sit numquam sed amet et odio.', 'sint', 747, 0, 810, 100, 'Sunt at nesciunt eveniet non illo sed. Doloribus aspernatur velit iusto eum officia aut doloremque. Consequatur eos qui possimus voluptas repellendus. Eligendi odit nihil inventore libero.', 0, 80, NULL, NULL, 4, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(53, 1, 'Miss Patience Borer I', 'nostrum-et-nihil-velit-ex-voluptatem-earum', 'non', 1, 0, 'Odit voluptates voluptas enim molestias. Temporibus ut veritatis illum a voluptatum ab. Doloremque et distinctio labore deleniti ea. Fuga maxime nisi autem magnam dolor.', 'Rem ut doloribus quia est odit officia. Adipisci cupiditate aspernatur illum qui et. In minus dolorem enim error autem facilis facilis. Est at cumque nulla eos dolor.', 'sed', 747, 0, 234, 56, 'Quis voluptatum rerum est consequatur aut. Rerum quo quas quidem qui. Iure delectus omnis et et magnam totam. Culpa et tenetur odit nisi vitae velit.', 0, 100, NULL, NULL, 5, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(54, 2, 'Patsy Huel', 'temporibus-officiis-voluptatem-in-totam-quia-voluptas-totam', 'aut', 1, 0, 'Dolores sed ullam aliquid consequuntur numquam. Vitae reprehenderit iste necessitatibus. At quo error quasi qui. Non sequi molestiae at consectetur.', 'Enim quis a qui quis placeat sint incidunt. Sit deleniti ipsam enim quisquam commodi totam sunt. Qui voluptatum optio aut quod ipsam dignissimos. Porro ut recusandae quia eius vero.', 'quis', 365, 0, 575, 79, 'Possimus nihil quia dolor modi eaque eius eius. Libero quia sit et debitis dolores eaque molestiae. Id fuga sit cupiditate placeat nihil dolore fugit.', 0, 13, NULL, NULL, 1, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(55, 1, 'Dr. Mathias Bednar V', 'laborum-nihil-minima-est-dolores-minus', 'facere', 1, 0, 'Ipsum voluptatem ab eius quod aliquid. Ullam repudiandae ut modi velit hic sit commodi facere. Iste earum nam aut et autem dolor aut.', 'Fugit error magnam quia consequatur voluptatibus. Est et sint aut atque sed neque.', 'et', 262, 0, 890, 20, 'Quia quasi fugit laudantium libero quas. Debitis ipsa ut eum quae et eaque voluptatem.', 0, 31, NULL, NULL, 2, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(56, 1, 'Mr. Lee Zieme II', 'et-sed-et-reprehenderit-sit', 'autem', 1, 0, 'Ut reprehenderit sed eos. Beatae voluptatem soluta minus sapiente animi est ducimus. Quia a totam autem dolorum temporibus.', 'Qui pariatur voluptatem reiciendis. Sed omnis hic placeat exercitationem voluptatum. Dolorem voluptas consequuntur quibusdam molestias perferendis. Quas cupiditate qui dignissimos veritatis.', 'consequuntur', 305, 0, 211, 67, 'Itaque commodi quasi voluptas sunt possimus nisi iusto. Vitae magnam porro et temporibus.', 0, 64, NULL, NULL, 1, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(57, 1, 'Prof. Janiya Conn', 'omnis-consectetur-placeat-sunt-rerum', 'voluptas', 1, 0, 'Inventore fuga possimus enim fuga nam. Hic autem dignissimos eaque pariatur.', 'Sed est odit non tempora et nemo eaque itaque. Ea cum rerum architecto nulla voluptatem dignissimos. Excepturi ratione dolorem qui architecto sint voluptatem velit.', 'a', 957, 0, 878, 58, 'Voluptatem mollitia sint quibusdam et ipsa placeat. Non voluptas qui natus mollitia. Modi quidem magnam ducimus ut est. Molestias non doloribus suscipit cupiditate eum consequuntur.', 0, 34, NULL, NULL, 5, NULL, 'products/1.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(58, 1, 'Paolo Heller DVM', 'voluptatem-est-autem-modi-officia', 'eum', 1, 0, 'Tempore est qui non. Harum omnis quaerat omnis minus at tempore. Id dolorem consequatur repudiandae ut qui.', 'Quibusdam non est asperiores aliquam voluptatem. A eaque nostrum natus voluptatem. Occaecati error velit dolores deserunt ipsa.', 'nostrum', 773, 0, 129, 11, 'Voluptatem possimus sequi iste soluta a aut voluptatem. Corporis doloribus ea modi sit rem dolores nostrum. Animi et temporibus voluptas illum.', 0, 71, NULL, NULL, 1, NULL, 'products/2.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(59, 5, 'Deron Kohler DVM', 'qui-qui-ut-est-autem', 'dolorem', 1, 0, 'Voluptate laudantium est qui amet labore pariatur. Voluptatem voluptatum rerum ducimus recusandae ut. Eos blanditiis nostrum nobis in quidem veniam et.', 'Expedita facilis autem quia dolor dolorum expedita quis. Ea voluptatem dolores asperiores nam enim dolorem. Nostrum aut ab veritatis voluptas.', 'repellendus', 803, 0, 525, 94, 'Quia aperiam non consequatur. Deserunt aut facere est ut. Illum quibusdam iste minima quod iusto.', 0, 84, NULL, NULL, 3, NULL, 'products/3.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(60, 1, 'Kathleen Morar', 'corrupti-nostrum-quod-quo-consectetur-eaque-ut', 'perspiciatis', 1, 0, 'Et et fugit autem praesentium qui minima laudantium. Eum omnis dolores ex quia aliquid. Tempore voluptatem cum consectetur mollitia eum quia temporibus.', 'Eos sed nemo et excepturi omnis quae. Aut consequatur distinctio non debitis et. In id nostrum consequatur quam. Et quidem veritatis nobis.', 'placeat', 447, 0, 291, 84, 'Adipisci fuga tenetur qui. Neque nulla fugit explicabo nobis deleniti consequatur. Nam ducimus corrupti sit amet provident. Quia et deserunt qui.', 0, 27, NULL, NULL, 5, NULL, 'products/4.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(61, 4, 'Jamie Kuphal', 'non-necessitatibus-illo-alias-pariatur-velit-ipsum-voluptatibus', 'at', 1, 0, 'Pariatur tempora aspernatur atque. Quos nesciunt libero amet labore. Id nostrum ut rem ut doloribus illo sunt voluptas.', 'Placeat quia commodi qui molestiae ut. Dolores quas tenetur velit culpa nihil cum dolorem ipsum. Maiores omnis earum recusandae aut accusamus architecto esse.', 'cumque', 298, 0, 654, 88, 'Quis asperiores omnis et maxime accusantium non. Voluptatem et ipsa nulla error veniam ut autem. Itaque repellat reprehenderit sit sit molestiae. Repudiandae quas at aspernatur ut.', 0, 93, NULL, NULL, 1, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(62, 1, 'Gilda Tremblay', 'est-repellat-quod-nihil-ut-voluptas-eaque-quisquam', 'libero', 1, 0, 'Sit aspernatur odit et ab qui voluptate sed. Sint corporis non sint tempora. Dolores corporis culpa sunt cumque dolore possimus.', 'In nostrum non officiis ut aperiam eius repellat. Voluptatem rem voluptatem rerum qui voluptatem non debitis soluta.', 'aut', 121, 0, 633, 37, 'Est tempora at corporis repellendus rerum voluptate. Distinctio ipsam sapiente vel pariatur aliquid dolorum id. Non molestias sit dolor. Repudiandae odio qui vero autem ullam.', 0, 66, NULL, NULL, 2, NULL, 'products/5.png', NULL, NULL, '[\"products\\/2.png\",\"products\\/3.png\",\"products\\/4.png\",\"products\\/5.png\"]', NULL, NULL, NULL, NULL),
(63, 11, 'test', 'test-63', NULL, 1, 0, 'Tenetur sunt, ab eum.&nbsp;&nbsp;', 'Aut inventore odio e.&nbsp;', '3a5b8377-8', 235, 0, 222, NULL, NULL, 0, 10, NULL, NULL, NULL, NULL, 'products/w4QJpIAnduI2f3tfB1jb6JRT6IwRxDojEzxHGCOp.jpg', NULL, NULL, '[\"product-images\\/vNXgvnELi6gFeXrVUAFCPKeKu8rJgU6ONOOsxy6y.jpg\"]', NULL, NULL, '2023-09-12 01:32:35', '2023-09-12 02:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `review` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(2, 'user', 'Normal User', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(3, 'vendor', 'Vendor', '2023-09-08 23:30:27', '2023-09-08 23:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '1',
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `display_name`, `value`, `details`, `type`, `order`, `group`) VALUES
(1, 'site.title', 'Site Title', 'Ahromart', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Site Description', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', 'settings/April2023/58Q6tQ3SY5C7e7PnjKSH.png', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', '', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'Ahromart', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Welcome to Voyager. The Missing Admin for Laravel', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', 'settings\\April2023\\9kzGOSRRtEQIHwATiO0h.png', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', 'settings\\April2023\\9wXS5anP0TuKi8pWgXCr.png', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 1, 'Admin'),
(12, 'site.newslletter_logo', 'newslletter_logo', 'settings/April2023/NhAMYIJ14TgvAaBk3AoK.png', NULL, 'image', 6, 'Site'),
(14, 'offer.offer1Image', 'Offer Image 1', 'settings/April2023/i6kW9obJIAjCLdLSM4gY.png', NULL, 'image', 7, 'offer'),
(15, 'offer.offer1Title', 'Offer Title 1', 'Black Friday Deals', NULL, 'text', 8, 'offer'),
(16, 'offer.offer1category', 'Offer Categories1', 'Electrnics, Fashion', NULL, 'text', 9, 'offer'),
(17, 'offer.offer1link', 'Offer Link 1', 'https://ahromart.com/product/officia-qui-reiciendis-eius-culpa-vero-quis-placeat', NULL, 'text', 10, 'offer'),
(18, 'offer.offer2Image', 'Offer Image 2', 'settings/April2023/MWMZJSyRgoQccbUXa2x2.png', NULL, 'image', 11, 'offer'),
(19, 'offer.offer2Title', 'Offer Title 2', '20% OFF in Every Fashion Iteam', NULL, 'text', 12, 'offer'),
(20, 'offer.offer2category', 'Offer Categories 2', 'Daily Fahion', NULL, 'text', 13, 'offer'),
(21, 'offer.offer2link', 'Offer Link 2', 'https://ahromart.com/product/possimus-accusantium-rerum-autem-ipsam-itaque-vero', NULL, 'text', 14, 'offer'),
(22, 'site.icon', 'Icon', 'settings/April2023/pQmdiOHPRkwOigAWrIx3.png', NULL, 'image', 15, 'Site'),
(23, 'site.shop_settings_info', 'Shop settings info', '<p>test</p>', NULL, 'rich_text_box', 16, 'Site'),
(24, 'site.user_settings_info', 'User setting info', '<p>hello</p>', NULL, 'rich_text_box', 17, 'Site'),
(25, 'site.client_id', 'client ID', 'ASEIeZ0uWYy1q8iGe-LJvFjRqVAK4wg5WtW5dFpKucIhhNFeutYGtiKV2M1kiLoGMb2T5CLmbXpN6Fgz', NULL, 'text', 18, 'Site'),
(27, 'site.paypal_secret_id', 'Paypal Secret ID', 'EN3248ng0HkjmIjwW3iEfxhQL8ll_YeHBoJsYzk-VgXKYgg6c-z8taDRJfn2OohnKdVK3o5m3cRGnM30', NULL, 'text', 20, 'Site'),
(28, 'social.fb_link', 'facebook', 'https://www.facebook.com/', NULL, 'text', 21, 'Social'),
(29, 'social.linkedin', 'linkedin', NULL, NULL, 'text', 22, 'Social'),
(30, 'social.inst_link', 'instagram', NULL, NULL, 'text', 23, 'Social'),
(31, 'social.twiter_link', 'twiter', NULL, NULL, 'text', 24, 'Social'),
(32, 'site.phone', 'phone', NULL, NULL, 'text', 25, 'Site'),
(33, 'site.email', 'email', NULL, NULL, 'text', 26, 'Site');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `terms` text COLLATE utf8mb4_unicode_ci,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_registration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shops`
--

INSERT INTO `shops` (`id`, `name`, `user_id`, `slug`, `email`, `phone`, `logo`, `banner`, `description`, `short_description`, `tags`, `terms`, `company_name`, `company_registration`, `city`, `state`, `post_code`, `country`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Miracle Tillman', 3, 'flabadie', 'henry93@example.org', '+1-620-444-8995', 'shop/shop1.png', NULL, 'Provident ut perferendis rem et non. Ut officiis id et qui. Ab exercitationem et quisquam dolorem. Commodi eum eos et vel minima consectetur ad.\n\nDucimus qui quia ipsam minima dicta non. Sint repellat tempore dolorem placeat. Non dolorem ut culpa eaque unde. Ea nobis eligendi voluptatibus aut debitis velit est.\n\nSint occaecati sequi dolores omnis. Nostrum quos velit libero quibusdam voluptas eos. Placeat vel quos et debitis voluptas voluptatibus qui.', 'Vero impedit iusto assumenda velit. Ab eos sequi maiores quaerat qui. Nihil ratione perspiciatis accusantium in debitis repellendus accusantium praesentium.', '[\"deserunt\", \"est\", \"et\"]', 'Qui ab et quos aliquam vero laudantium. Et ratione deserunt in modi hic.', 'christina21', 'd5c5fb5d-6736-3f11-a8fa-3ea4403350d0', 'Lednerburgh', 'Wisconsin', '20463', 'Saint Barthelemy', 1, NULL, NULL),
(2, 'Roselyn Ortiz', 4, 'frances.bogan', 'purdy.bertha@example.com', '(949) 848-7572', 'shop/shop2.png', NULL, 'Nihil enim est nesciunt ut omnis velit accusamus. Qui quibusdam minima aut est consequuntur.\n\nEsse est et dolorum vel laboriosam vel minus tempore. Quibusdam dolores eos molestias sequi et.\n\nAlias sequi magni itaque ipsam. Quod aut sed repellendus ut qui est pariatur. Quia et eaque placeat dicta. Sed veritatis eum et.', 'Itaque dolore quis et occaecati magnam. Et voluptas voluptates aut doloremque cupiditate dolore. Voluptate illo sit neque consectetur.', '[\"aut\", \"delectus\", \"consequuntur\"]', 'Voluptatem perspiciatis quis modi repudiandae. Nobis et iure sequi voluptas. Rerum totam itaque tenetur in similique qui. Architecto assumenda atque quas laboriosam enim doloremque sunt.', 'maybell02', '9bd2c171-60d7-31bc-97c9-cde45258fac3', 'Lake Nicolette', 'Arkansas', '55667-1908', 'Mauritius', 1, NULL, NULL),
(3, 'Lavon Halvorson', 4, 'kathryn.bradtke', 'laurel02@example.org', '(779) 209-4123', 'shop/shop3.png', NULL, 'Quia natus earum est et aspernatur. Blanditiis quisquam laudantium temporibus suscipit. Corrupti ducimus ut nihil accusamus perferendis laborum.\n\nIn voluptatem ad sint odit illo velit. Assumenda voluptas illo repellendus quo commodi quia voluptatem. Est qui vitae nisi culpa quia sunt.\n\nPraesentium ipsa quasi rerum quia. Illo eos excepturi vero velit. Molestiae dolor vel natus repellendus aut.', 'Sint adipisci ducimus sit necessitatibus nobis enim tempore. Quos voluptatem accusamus inventore et sed laudantium. Assumenda beatae et praesentium voluptates consequuntur nihil quos. Laudantium laborum dolorem laudantium molestiae placeat. Deserunt voluptate sunt delectus nisi commodi est et qui.', '[\"deserunt\", \"voluptates\", \"sit\"]', 'Libero perferendis natus voluptas quae. Quae voluptas iure autem sed. Est reprehenderit doloribus ea est dolor dicta et. Eligendi in reprehenderit repellat nihil.', 'rudolph.wiegand', 'eb1bfb11-301d-3b11-b972-d1306c2cb31e', 'Violaland', 'Louisiana', '26521', 'Honduras', 1, NULL, NULL),
(4, 'Marcella Hartmann', 2, 'mariah.carter', 'ftreutel@example.org', '608-621-1103', 'shop/shop4.png', NULL, 'Ut omnis nulla doloremque dolor. Quidem qui id aut modi et. Deserunt autem tenetur magni voluptatum reprehenderit praesentium veniam. Sit ut quae sint quos voluptas ut.\n\nMinus quisquam sint temporibus corrupti. Temporibus velit eligendi sunt. Molestiae debitis et quia omnis doloribus et.\n\nConsectetur occaecati ut praesentium ab error delectus molestias. Eum hic ad rerum iusto voluptas possimus voluptatibus. Eos sint tenetur modi nisi. Non voluptas occaecati aspernatur quia consequatur est ut similique.', 'Totam optio sit est quam quis. Dolorem omnis consequuntur consequatur reiciendis voluptate. Porro nam repellendus dicta qui officia odit aliquam dolor. Veniam et omnis occaecati.', '[\"id\", \"nisi\", \"officia\"]', 'Autem voluptates et libero reiciendis quia incidunt. Quia et aut id autem molestiae. Harum sequi harum sed velit ut. Rerum eum omnis similique mollitia.', 'ggibson', '6f49daf0-672e-394d-8cdc-d3b702317747', 'Estafurt', 'Kentucky', '90825-0264', 'Jordan', 1, NULL, NULL),
(5, 'Ms. Maybelle Schinner MD', 4, 'khirthe', 'neil.sawayn@example.net', '573-983-4178', 'shop/shop3.png', NULL, 'Quis ut consequatur assumenda culpa nostrum ut. Officiis facere nam expedita voluptatibus velit. Possimus a accusamus omnis. Ut in illum quam ut laborum voluptas quia.\n\nCupiditate architecto et perspiciatis illum vel necessitatibus. Nostrum sed maiores dolorum nihil vero. Iure delectus quis sit repellendus.\n\nEarum sit aut ipsam animi distinctio dicta id harum. Blanditiis ut est impedit officiis debitis illo qui. Aut commodi quo voluptate.', 'Atque est soluta cum dolor non tempora suscipit corrupti. Debitis rerum qui deleniti quibusdam sunt. Eos et ut fugit repudiandae vero.', '[\"facilis\", \"nihil\", \"omnis\"]', 'Facere quae omnis voluptatem eligendi quia sed. Labore iusto ratione quod voluptate.', 'felix.haley', '7d22d712-3902-386f-82b9-50283248f548', 'Lake Ansley', 'Rhode Island', '36085', 'Nauru', 1, NULL, NULL),
(6, 'Sonny Krajcik DDS', 2, 'jensen.nitzsche', 'pohara@example.com', '818.875.0142', 'shop/shop1.png', NULL, 'Cupiditate dolorum in nam quis quod. Voluptatem perspiciatis quos est corrupti quis unde. Nihil aut et dolorem maxime eveniet aut autem repudiandae. Rerum magnam est itaque expedita dolor quis blanditiis.\n\nVeritatis modi reprehenderit distinctio nesciunt. Quaerat commodi at culpa porro aperiam. Iure fugit explicabo quas.\n\nIusto et rerum est culpa sapiente autem voluptas. Blanditiis deleniti odit soluta et a dolorem. Et dicta dolores saepe nesciunt amet. Aut accusantium quia tempora facilis sed nemo. Est officiis cum placeat praesentium quia non.', 'Et consequatur fuga est enim. Tenetur aliquid aperiam repudiandae sapiente consequatur veniam sit. Magnam est sit sed illo non doloremque assumenda. Dolorum enim asperiores cumque in ab eligendi sunt. Quam aut quas et inventore minima asperiores nam.', '[\"sunt\", \"vitae\", \"eum\"]', 'Officia eos iusto ratione sequi ut earum. Doloremque minima et quia. Vitae voluptas autem velit et.', 'lesch.kylee', '9a8100de-d40d-3b29-922b-038b5e749637', 'Wunschfort', 'Ohio', '09237-5134', 'Tonga', 1, NULL, NULL),
(7, 'Ona Johnston', 1, 'kozey.june', 'gleason.rebekah@example.org', '385.310.1612', 'shop/shop2.png', NULL, 'Hic natus nostrum est et qui. In in repudiandae eaque voluptas sunt necessitatibus. Veritatis et esse libero dolorum debitis dicta.\n\nAliquam sed quae dolore error alias est. Est dolores culpa iure est at. Sunt consequuntur ut blanditiis quidem autem. Sunt quod est error eius dolore eum ut. Aliquid necessitatibus dolorem explicabo quisquam vitae ad.\n\nOfficia tempore sit quia nulla repellat vero. Nesciunt impedit et quia. Blanditiis eum quo reprehenderit est facilis. Vitae natus iure in deserunt quasi. Quas molestiae possimus deleniti.', 'Est dolorem veritatis reprehenderit nesciunt dolorum. Et non eligendi maiores ex perspiciatis id quia. Provident distinctio veritatis dolorum perferendis reprehenderit similique.', '[\"velit\", \"aut\", \"velit\"]', 'Commodi velit neque praesentium accusantium quae. Harum autem odio iure quas totam. Eos rem et necessitatibus ullam veniam et. Velit rerum enim provident sed omnis voluptate.', 'brisa.spinka', '0b450faf-aa0d-386e-80c3-d0c1e2e30579', 'Jailynchester', 'Nebraska', '48996-8073', 'Peru', 1, NULL, NULL),
(8, 'Enrico Keebler DVM', 2, 'kuhic.cicero', 'parker.davonte@example.org', '+1 (260) 299-6275', 'shop/shop3.png', NULL, 'Autem recusandae doloremque est doloremque quasi odio ducimus accusantium. Architecto et error ea reprehenderit rem dolor. Quas odit autem architecto quos doloremque quia. Voluptas odio qui architecto nobis et.\n\nSoluta eveniet sunt assumenda omnis. Aut consequatur temporibus dolores quo. Animi velit dolor quod nesciunt repellendus illo est doloremque.\n\nEst ut eius eum. Sunt repellat voluptate at in aut ullam autem. Voluptas temporibus deserunt quod temporibus. Eligendi voluptatem omnis dolorem dolor beatae.', 'Voluptatibus dolorum nobis autem architecto qui doloribus cumque quis. Sint dolorem et laudantium at.', '[\"ullam\", \"et\", \"dolores\"]', 'Autem voluptas omnis excepturi magnam. Molestias et doloremque mollitia harum dolore est et quo. Nobis consectetur vero amet magnam.', 'hackett.roxanne', '87b02bc1-6a1c-37b8-8057-2b24ba6c61a9', 'Emmerichchester', 'South Dakota', '04320', 'British Indian Ocean Territory (Chagos Archipelago)', 1, NULL, NULL),
(9, 'Prof. Kelley Krajcik Jr.', 3, 'aubrey.bergstrom', 'cbrekke@example.com', '726.590.9131', 'shop/shop4.png', NULL, 'Et accusamus qui quam consequatur. Ut sit aut ea officiis. Laborum id est exercitationem earum in in ut maxime. Eum commodi nemo maxime itaque.\n\nEst molestiae molestiae dolor nihil nesciunt qui tempore. Et beatae earum earum. Ab ad corporis illo esse et reiciendis.\n\nConsectetur vero repellendus sit voluptas nobis iure dolores. Cumque eligendi odit placeat impedit autem amet animi. Natus maxime hic vero eius. Aspernatur iste incidunt dolor tempore.', 'Corporis dolor alias quia placeat sint harum quia. Id animi minus molestiae eligendi maxime vitae necessitatibus. Praesentium nesciunt reprehenderit eos officia aut voluptas.', '[\"soluta\", \"quo\", \"sunt\"]', 'Qui eum quod voluptatem officiis quod amet. Itaque aliquam dolores iste doloremque enim. Omnis voluptatibus ullam culpa qui. Debitis omnis praesentium esse alias ad et modi.', 'andreanne25', '33af3d18-4d89-3e6d-9d88-1705e0f5fe5f', 'South Maynardton', 'Ohio', '50796', 'Cyprus', 1, NULL, NULL),
(10, 'Yesenia Koch MD', 4, 'narciso79', 'wsenger@example.net', '253.808.2210', 'shop/shop3.png', NULL, 'Quaerat velit distinctio quod. Mollitia eum molestiae vel qui qui velit dolor. Ut laudantium distinctio non modi. Culpa non ipsum sequi cumque natus et.\n\nCum deleniti dicta sunt dolores rerum saepe ea. Saepe tenetur qui in culpa nulla consequatur quas enim. Et eveniet perferendis repudiandae. Ex cum reprehenderit autem.\n\nTenetur sed aut explicabo. Commodi dignissimos voluptas reprehenderit ipsa dolor sint. Asperiores asperiores sed quisquam occaecati.', 'Non qui aut neque ut unde omnis. Voluptas velit modi itaque iure. Sequi qui fugiat illo deserunt fuga ipsa qui. Similique vero in molestias officiis similique.', '[\"illum\", \"amet\", \"eligendi\"]', 'Voluptas aut error nulla fugiat dolore quia voluptatem. Vero omnis quod sit quidem officia sed. Voluptatem praesentium sit et quod.', 'chyna.weimann', '5a061ca4-7696-3bb5-b970-77552efcff2e', 'East Jayce', 'Missouri', '54854', 'Saint Vincent and the Grenadines', 1, NULL, NULL),
(11, 'Pearl Payne 2', 9, 'pearl-payne-2', 'mopowyqot@mailinator.com', '+1 (975) 996-2654', 'logos/jOvdyrhkfH95PCpe7yFOTYQfeFRjqOxU8FoGYL1i.png', 'banners/uFpozeUjEH6TVysu5P3ATYhTIHQnLOivQT9IK5XX.jpg', 'Sit sunt rerum sed u', 'Esse illo eum quis', NULL, NULL, NULL, NULL, 'Quas non corporis ex', 'Virginia', '1200', 'United States', 1, '2023-09-10 23:39:10', '2023-09-12 03:04:52');

-- --------------------------------------------------------

--
-- Table structure for table `shop_policies`
--

CREATE TABLE `shop_policies` (
  `id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `delivery` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_option` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_exchange` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cancellation` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shop_user`
--

CREATE TABLE `shop_user` (
  `id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_items`
--

CREATE TABLE `subscription_items` (
  `id` bigint UNSIGNED NOT NULL,
  `subscription_id` bigint UNSIGNED NOT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_product` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint DEFAULT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `massage` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `action` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `parent_id`, `shop_id`, `user_id`, `subject`, `massage`, `image`, `status`, `action`, `created_at`, `updated_at`) VALUES
(1, NULL, 11, NULL, 'Nesciunt omnis cons', 'Et lorem quam qui un', NULL, 0, NULL, '2023-09-11 23:53:59', '2023-09-11 23:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int UNSIGNED NOT NULL,
  `table_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int UNSIGNED NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `translations`
--

INSERT INTO `translations` (`id`, `table_name`, `column_name`, `foreign_key`, `locale`, `value`, `created_at`, `updated_at`) VALUES
(1, 'data_types', 'display_name_singular', 5, 'pt', 'Post', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(2, 'data_types', 'display_name_singular', 6, 'pt', 'Página', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(3, 'data_types', 'display_name_singular', 1, 'pt', 'Utilizador', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(4, 'data_types', 'display_name_singular', 4, 'pt', 'Categoria', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(5, 'data_types', 'display_name_singular', 2, 'pt', 'Menu', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(6, 'data_types', 'display_name_singular', 3, 'pt', 'Função', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(7, 'data_types', 'display_name_plural', 5, 'pt', 'Posts', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(8, 'data_types', 'display_name_plural', 6, 'pt', 'Páginas', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(9, 'data_types', 'display_name_plural', 1, 'pt', 'Utilizadores', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(10, 'data_types', 'display_name_plural', 4, 'pt', 'Categorias', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(11, 'data_types', 'display_name_plural', 2, 'pt', 'Menus', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(12, 'data_types', 'display_name_plural', 3, 'pt', 'Funções', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(13, 'categories', 'slug', 1, 'pt', 'categoria-1', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(14, 'categories', 'name', 1, 'pt', 'Categoria 1', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(15, 'categories', 'slug', 2, 'pt', 'categoria-2', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(16, 'categories', 'name', 2, 'pt', 'Categoria 2', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(17, 'pages', 'title', 1, 'pt', 'Olá Mundo', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(18, 'pages', 'slug', 1, 'pt', 'ola-mundo', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(19, 'pages', 'body', 1, 'pt', '<p>Olá Mundo. Scallywag grog swab Cat o\'nine tails scuttle rigging hardtack cable nipper Yellow Jack. Handsomely spirits knave lad killick landlubber or just lubber deadlights chantey pinnace crack Jennys tea cup. Provost long clothes black spot Yellow Jack bilged on her anchor league lateen sail case shot lee tackle.</p>\r\n<p>Ballast spirits fluke topmast me quarterdeck schooner landlubber or just lubber gabion belaying pin. Pinnace stern galleon starboard warp carouser to go on account dance the hempen jig jolly boat measured fer yer chains. Man-of-war fire in the hole nipperkin handsomely doubloon barkadeer Brethren of the Coast gibbet driver squiffy.</p>', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(20, 'menu_items', 'title', 1, 'pt', 'Painel de Controle', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(21, 'menu_items', 'title', 2, 'pt', 'Media', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(22, 'menu_items', 'title', 12, 'pt', 'Publicações', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(23, 'menu_items', 'title', 3, 'pt', 'Utilizadores', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(24, 'menu_items', 'title', 11, 'pt', 'Categorias', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(25, 'menu_items', 'title', 13, 'pt', 'Páginas', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(26, 'menu_items', 'title', 4, 'pt', 'Funções', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(27, 'menu_items', 'title', 5, 'pt', 'Ferramentas', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(28, 'menu_items', 'title', 6, 'pt', 'Menus', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(29, 'menu_items', 'title', 7, 'pt', 'Base de dados', '2023-09-08 23:30:27', '2023-09-08 23:30:27'),
(30, 'menu_items', 'title', 10, 'pt', 'Configurações', '2023-09-08 23:30:27', '2023-09-08 23:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `paid_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `l_name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`, `paid_at`) VALUES
(1, 3, 'Robbie Rohan PhD', NULL, 'wdubuque@example.org', 'users/default.png', '2023-09-08 23:30:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'fSzHi8cvMV', NULL, '2023-09-08 23:30:27', '2023-09-08 23:30:27', NULL, NULL, NULL, NULL, NULL),
(2, 1, 'Rosalee Ferry', NULL, 'test@test.com', 'users/default.png', '2023-09-08 23:30:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'A1QbBWkvuHi2gxf1W9auIt1X6DxluYtlOLuvMvcUiKW1ZaYo9Oy3O5xqSJtg', NULL, '2023-09-08 23:30:27', '2023-09-08 23:30:27', NULL, NULL, NULL, NULL, NULL),
(3, 2, 'Layne Herman', NULL, 'dmueller@example.org', 'users/default.png', '2023-09-08 23:30:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'rE2lYZAVcn', NULL, '2023-09-08 23:30:27', '2023-09-08 23:30:27', NULL, NULL, NULL, NULL, NULL),
(4, 1, 'Prof. Leonard Luettgen', NULL, 'ckilback@example.com', 'users/default.png', '2023-09-08 23:30:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cYwOGcWi2N', NULL, '2023-09-08 23:30:27', '2023-09-08 23:30:27', NULL, NULL, NULL, NULL, NULL),
(5, 2, 'Ms. Ashtyn Wyman', NULL, 'rogahn.dimitri@example.net', 'users/default.png', '2023-09-08 23:30:27', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'WmhR9gTrhD', NULL, '2023-09-08 23:30:27', '2023-09-08 23:30:27', NULL, NULL, NULL, NULL, NULL),
(6, 2, 'Armand Oneal', 'Zenaida Haney', 'reje@mailinator.com', 'users/default.png', NULL, '$2y$10$ZGJ4/aPoQbQXBnTuXddY8O0m.Auh7Q5xd6FdcEDwkYMKyaKrXO8aK', NULL, NULL, '2023-09-09 23:40:47', '2023-09-09 23:40:47', NULL, NULL, NULL, NULL, NULL),
(7, 3, 'Reagan Whitaker', 'Kelly Powell', 'kixira@mailinator.com', 'users/default.png', NULL, '$2y$10$Nl22Xk9VbWn9Hs/a36KAL./wcdRB2MWa/UY3lKBvZPJNj5rqY5nbu', NULL, NULL, '2023-09-10 00:21:22', '2023-09-10 00:21:22', NULL, NULL, NULL, NULL, NULL),
(8, 2, 'Allistair Davidson', 'Wynter Pollard', 'beqovuz@mailinator.com', 'users/default.png', NULL, '$2y$10$h7LalA3v6DnuqtysbnOiweTI659JwFvY.ZT.8bibnWsQlr.DC/ypO', NULL, NULL, '2023-09-10 00:25:08', '2023-09-10 00:25:08', NULL, NULL, NULL, NULL, NULL),
(9, 3, 'Malcolm Griffith', 'Keith Wilson', 'lilikasi@mailinator.com', 'users/default.png', '2023-09-10 00:37:45', '$2y$10$1AYSmgO6YQZNtH6oLT2nveVLws3eLSM4Yz64ecf.9JYNTKFq7bDvO', 'iuH9eg4sS7B4viClWpFLWC4CKcMWYGUra1hDPBABsESOzlBT7xRD9HiJQTu1', NULL, '2023-09-10 00:25:34', '2023-09-10 00:37:45', NULL, NULL, NULL, NULL, NULL),
(10, 2, 'Alamin', 'Sikder', 'asalaminsikder8@gmail.com', 'users/kJnjGvgnlanh9rMs1iV8G2R1lnhlGziiwgivnf7b.jpg', NULL, '$2y$10$hCo/ITi2BUB03Y5.ofudaOHVlfs5Uy/xz6BT7swCpkFTWUD1Fr71y', NULL, NULL, '2023-09-12 04:40:46', '2023-09-12 04:42:30', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `verifications`
--

CREATE TABLE `verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` timestamp NOT NULL,
  `tax_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `card_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `govt_id_front` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `govt_id_back` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_ac` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `verifications`
--

INSERT INTO `verifications` (`id`, `user_id`, `phone`, `dob`, `tax_no`, `card_no`, `govt_id_front`, `govt_id_back`, `bank_ac`, `paypal`, `bank_name`, `created_at`, `updated_at`) VALUES
(8, 9, NULL, '1978-05-04 18:00:00', 'Labore rerum reprehe', NULL, 'verifications/muvbkbpLh7z5NiFGbpLU3fIw9BR4jdooi5FLYXnW.png', 'verifications/N9dbYwivFuquM3pvxsNDRuTYVbiL9OWllErjDJ58.png', NULL, 'tamim@gmail.com', NULL, '2023-09-10 05:59:04', '2023-09-11 00:51:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attributes_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupons_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `data_rows`
--
ALTER TABLE `data_rows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_rows_data_type_id_foreign` (`data_type_id`);

--
-- Indexes for table `data_types`
--
ALTER TABLE `data_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_types_name_unique` (`name`),
  ADD UNIQUE KEY `data_types_slug_unique` (`slug`);

--
-- Indexes for table `emails`
--
ALTER TABLE `emails`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emails_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_order_id_foreign` (`order_id`),
  ADD KEY `feedback_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `massages`
--
ALTER TABLE `massages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `massages_shop_id_foreign` (`shop_id`),
  ADD KEY `massages_user_id_foreign` (`user_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_name_unique` (`name`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menu_items_menu_id_foreign` (`menu_id`);

--
-- Indexes for table `metas`
--
ALTER TABLE `metas`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`),
  ADD KEY `notifications_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_user_id_foreign` (`user_id`),
  ADD KEY `offers_product_id_foreign` (`product_id`),
  ADD KEY `offers_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_shop_id_foreign` (`shop_id`),
  ADD KEY `orders_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_product_id_foreign` (`product_id`),
  ADD KEY `order_product_order_id_foreign` (`order_id`),
  ADD KEY `order_product_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_key_index` (`key`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_permission_id_index` (`permission_id`),
  ADD KEY `permission_role_role_id_index` (`role_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `prodcats`
--
ALTER TABLE `prodcats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodcats_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `prodcat_product`
--
ALTER TABLE `prodcat_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodcat_product_product_id_foreign` (`product_id`),
  ADD KEY `prodcat_product_prodcat_id_foreign` (`prodcat_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_product_id_foreign` (`product_id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`),
  ADD KEY `ratings_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shops_slug_unique` (`slug`),
  ADD KEY `shops_user_id_foreign` (`user_id`);

--
-- Indexes for table `shop_policies`
--
ALTER TABLE `shop_policies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_policies_shop_id_foreign` (`shop_id`);

--
-- Indexes for table `shop_user`
--
ALTER TABLE `shop_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_user_shop_id_foreign` (`shop_id`),
  ADD KEY `shop_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`);

--
-- Indexes for table `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_items_subscription_id_stripe_price_unique` (`subscription_id`,`stripe_price`),
  ADD UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_shop_id_foreign` (`shop_id`),
  ADD KEY `tickets_user_id_foreign` (`user_id`);

--
-- Indexes for table `translations`
--
ALTER TABLE `translations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `translations_table_name_column_name_foreign_key_locale_unique` (`table_name`,`column_name`,`foreign_key`,`locale`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`),
  ADD KEY `users_stripe_id_index` (`stripe_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `user_roles_user_id_index` (`user_id`),
  ADD KEY `user_roles_role_id_index` (`role_id`);

--
-- Indexes for table `verifications`
--
ALTER TABLE `verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verifications_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `massages`
--
ALTER TABLE `massages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `metas`
--
ALTER TABLE `metas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_product`
--
ALTER TABLE `order_product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prodcats`
--
ALTER TABLE `prodcats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `prodcat_product`
--
ALTER TABLE `prodcat_product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shop_policies`
--
ALTER TABLE `shop_policies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop_user`
--
ALTER TABLE `shop_user`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_items`
--
ALTER TABLE `subscription_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `verifications`
--
ALTER TABLE `verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attributes`
--
ALTER TABLE `attributes`
  ADD CONSTRAINT `attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `data_rows`
--
ALTER TABLE `data_rows`
  ADD CONSTRAINT `data_rows_data_type_id_foreign` FOREIGN KEY (`data_type_id`) REFERENCES `data_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `massages`
--
ALTER TABLE `massages`
  ADD CONSTRAINT `massages_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `massages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offers_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `offers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prodcats`
--
ALTER TABLE `prodcats`
  ADD CONSTRAINT `prodcats_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `prodcat_product`
--
ALTER TABLE `prodcat_product`
  ADD CONSTRAINT `prodcat_product_prodcat_id_foreign` FOREIGN KEY (`prodcat_id`) REFERENCES `prodcats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prodcat_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shop_policies`
--
ALTER TABLE `shop_policies`
  ADD CONSTRAINT `shop_policies_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shop_user`
--
ALTER TABLE `shop_user`
  ADD CONSTRAINT `shop_user_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shop_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verifications`
--
ALTER TABLE `verifications`
  ADD CONSTRAINT `verifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
