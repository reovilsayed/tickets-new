-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2024 at 01:21 PM
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
-- Database: `ticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `parent_id` int UNSIGNED DEFAULT NULL,
  `order` int NOT NULL DEFAULT '1',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 'Spis rejs og (op)lev', 'category-1', '2023-09-08 23:30:27', '2024-03-23 16:03:04'),
(2, NULL, 1, 'Artikler og nyheder', 'category-2', '2023-09-08 23:30:27', '2024-03-23 16:03:17');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(7, 'Lisboa', 'lisboa', '2024-07-30 14:01:25', '2024-07-30 14:01:25'),
(9, 'Porto', 'porto', '2024-07-30 14:01:32', '2024-07-30 14:01:32');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(1, 1, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(2, 1, 'name', 'text', 'First Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(3, 1, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 4),
(4, 1, 'password', 'password', 'Password', 1, 0, 0, 1, 1, 0, '{}', 7),
(5, 1, 'remember_token', 'text', 'Remember Token', 0, 0, 0, 0, 0, 0, '{}', 8),
(6, 1, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 9),
(7, 1, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 10),
(8, 1, 'avatar', 'image', 'Avatar', 0, 0, 1, 1, 1, 1, '{}', 12),
(9, 1, 'user_belongsto_role_relationship', 'relationship', 'Role', 0, 1, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsTo\",\"column\":\"role_id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"roles\",\"pivot\":\"0\",\"taggable\":\"0\"}', 6),
(10, 1, 'user_belongstomany_role_relationship', 'relationship', 'Roles', 0, 0, 1, 1, 1, 0, '{\"model\":\"TCG\\\\Voyager\\\\Models\\\\Role\",\"table\":\"roles\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"display_name\",\"pivot_table\":\"user_roles\",\"pivot\":\"1\",\"taggable\":\"0\"}', 13),
(11, 1, 'settings', 'hidden', 'Settings', 0, 0, 0, 0, 0, 0, '{}', 14),
(12, 2, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(13, 2, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(14, 2, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(15, 2, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(16, 3, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(17, 3, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 2),
(18, 3, 'created_at', 'timestamp', 'Created At', 0, 0, 0, 0, 0, 0, NULL, 3),
(19, 3, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 4),
(20, 3, 'display_name', 'text', 'Display Name', 1, 1, 1, 1, 1, 1, NULL, 5),
(21, 1, 'role_id', 'text', 'Role', 0, 1, 1, 1, 1, 1, '{}', 5),
(22, 4, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, NULL, 1),
(23, 4, 'parent_id', 'select_dropdown', 'Parent', 0, 0, 1, 1, 1, 1, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"}}', 2),
(24, 4, 'order', 'text', 'Order', 1, 1, 1, 1, 1, 1, '{\"default\":1}', 3),
(25, 4, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, NULL, 4),
(26, 4, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 5),
(27, 4, 'created_at', 'timestamp', 'Created At', 0, 0, 1, 0, 0, 0, NULL, 6),
(28, 4, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, NULL, 7),
(29, 5, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(30, 5, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, '{}', 2),
(31, 5, 'category_id', 'text', 'Category', 0, 0, 1, 1, 1, 0, '{}', 3),
(32, 5, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 4),
(33, 5, 'excerpt', 'text_area', 'Excerpt', 0, 0, 1, 1, 1, 1, '{}', 5),
(34, 5, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, '{}', 6),
(35, 5, 'image', 'image', 'Post Image', 0, 1, 1, 1, 1, 1, '{\"resize\":{\"width\":\"1000\",\"height\":\"null\"},\"quality\":\"70%\",\"upsize\":true,\"thumbnails\":[{\"name\":\"medium\",\"scale\":\"50%\"},{\"name\":\"small\",\"scale\":\"25%\"},{\"name\":\"cropped\",\"crop\":{\"width\":\"300\",\"height\":\"250\"}}]}', 7),
(36, 5, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:posts,slug\"}}', 8),
(37, 5, 'meta_description', 'text_area', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 9),
(38, 5, 'meta_keywords', 'text_area', 'Meta Keywords', 0, 0, 1, 1, 1, 1, '{}', 10),
(39, 5, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"PUBLISHED\":\"published\",\"DRAFT\":\"draft\",\"PENDING\":\"pending\"}}', 11),
(40, 5, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 12),
(41, 5, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 13),
(42, 5, 'seo_title', 'text', 'SEO Title', 0, 1, 1, 1, 1, 1, '{}', 14),
(43, 5, 'featured', 'checkbox', 'Featured', 1, 1, 1, 1, 1, 1, '{\"on\":\"on\",\"off\":\"Off\",\"checked\":false}', 15),
(44, 6, 'id', 'number', 'ID', 1, 0, 0, 0, 0, 0, '{}', 1),
(45, 6, 'author_id', 'text', 'Author', 1, 0, 0, 0, 0, 0, '{}', 2),
(46, 6, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 3),
(47, 6, 'excerpt', 'text_area', 'Excerpt', 0, 0, 1, 1, 1, 1, '{}', 4),
(48, 6, 'body', 'rich_text_box', 'Body', 0, 0, 1, 1, 1, 1, '{}', 5),
(49, 6, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\"},\"validation\":{\"rule\":\"unique:pages,slug\"}}', 6),
(50, 6, 'meta_description', 'text', 'Meta Description', 0, 0, 1, 1, 1, 1, '{}', 7),
(51, 6, 'meta_keywords', 'text', 'Meta Keywords', 0, 0, 1, 1, 1, 1, '{}', 8),
(52, 6, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"INACTIVE\",\"options\":{\"INACTIVE\":\"INACTIVE\",\"ACTIVE\":\"ACTIVE\"}}', 9),
(53, 6, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 10),
(54, 6, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 11),
(55, 6, 'image', 'image', 'Page Image', 0, 0, 0, 0, 0, 0, '{}', 12),
(56, 9, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(57, 9, 'shop_id', 'text', 'Shop Id', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 38),
(58, 9, 'name', 'text', 'Event Title', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 3),
(59, 9, 'slug', 'text', 'Slug', 0, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"},\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 4),
(60, 9, 'type', 'text', 'Type', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 5),
(61, 9, 'status', 'select_dropdown', 'Status', 1, 0, 0, 1, 1, 0, '{\"display\":{\"width\":\"3\"},\"default\":\"Active\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', 12),
(62, 9, 'featured', 'select_dropdown', 'Featured', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"default\":\"Off\",\"options\":{\"0\":\"Off\",\"1\":\"On\"}}', 6),
(63, 9, 'description', 'rich_text_box', 'Description', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"12\"},\"validation\":{\"rule\":\"required\"}}', 35),
(64, 9, 'short_description', 'rich_text_box', 'Short Description', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 7),
(65, 9, 'sku', 'text', 'Sku', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"}}', 8),
(66, 9, 'price', 'text', 'Price', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"},\"validation\":{\"rule\":\"required\"}}', 15),
(67, 9, 'sale_price', 'text', 'Sale Price', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"3\"}}', 16),
(68, 9, 'total_sale', 'text', 'Total Sale', 0, 0, 0, 0, 0, 0, '{}', 19),
(69, 9, 'downloads', 'text', 'Downloads', 0, 0, 0, 0, 0, 0, '{}', 20),
(70, 9, 'manage_stock', 'text', 'Manage Stock', 1, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"3\"}}', 21),
(71, 9, 'quantity', 'text', 'Quantity', 0, 0, 0, 1, 1, 0, '{\"display\":{\"width\":\"6\"},\"validation\":{\"rule\":\"required\"}}', 9),
(72, 9, 'weight', 'text', 'Weight', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"3\"}}', 18),
(73, 9, 'dimensions', 'text', 'Dimensions', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"3\"}}', 41),
(74, 9, 'rating_count', 'text', 'Rating Count', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"}}', 22),
(75, 9, 'parent_id', 'text', 'Parent Id', 0, 0, 0, 0, 0, 0, '{\"default\":\"\",\"null\":\"\",\"options\":{\"\":\"-- None --\"},\"relationship\":{\"key\":\"id\",\"label\":\"name\"},\"display\":{\"width\":\"3\"}}', 23),
(76, 9, 'image', 'image', 'Image', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 36),
(77, 9, 'images', 'multiple_images', 'Images', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"},\"default\":\"Active\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"}}', 24),
(78, 9, 'variations', 'text', 'Variations', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"}}', 40),
(79, 9, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 1, '{}', 25),
(80, 9, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 37),
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
(112, 14, 'shop_id', 'text', 'Shop Id', 1, 0, 0, 0, 0, 0, '{}', 3),
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
(129, 16, 'rating_belongsto_product_relationship', 'relationship', 'Offer', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Product\",\"table\":\"products\",\"type\":\"belongsTo\",\"column\":\"product_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 10),
(151, 18, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(152, 18, 'user_id', 'text', 'User Id', 0, 1, 1, 1, 1, 1, '{}', 5),
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
(176, 18, 'quantity', 'text', 'Quantity', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":\"6\"}}', 29),
(178, 18, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 31),
(179, 18, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 32),
(180, 18, 'order_belongsto_user_relationship', 'relationship', 'users', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"},\"model\":\"App\\\\Models\\\\User\",\"table\":\"users\",\"type\":\"belongsTo\",\"column\":\"user_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(183, 19, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(184, 19, 'image', 'image', 'Image', 1, 1, 1, 1, 1, 1, '{}', 2),
(185, 19, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 3),
(186, 19, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4),
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
(200, 9, 'vendor_price', 'text', 'Vendor Price', 0, 0, 0, 0, 0, 0, '{}', 11),
(201, 9, 'views', 'text', 'Views', 1, 0, 0, 0, 0, 0, '{}', 13),
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
(216, 23, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(217, 23, 'name', 'text', 'Name', 0, 1, 1, 1, 1, 1, '{}', 2),
(218, 23, 'slug', 'text', 'Slug', 0, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"}}', 3),
(219, 23, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 4),
(220, 23, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
(221, 9, 'city_id', 'text', 'City Id', 0, 0, 1, 1, 1, 1, '{}', 2),
(222, 9, 'amenities', 'text', 'Amenities', 0, 0, 0, 0, 0, 0, '{}', 10),
(223, 9, 'post_code', 'text', 'Post Code', 0, 0, 0, 1, 1, 0, '{\"display\":{\"width\":\"3\"}}', 14),
(224, 9, 'is_offer', 'text', 'Is Offer', 0, 0, 0, 0, 0, 0, '{}', 39),
(225, 9, 'expired_at', 'timestamp', 'Expired At', 1, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"}}', 17),
(226, 9, 'product_belongsto_city_relationship', 'relationship', 'City', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"4\"},\"model\":\"App\\\\City\",\"table\":\"cities\",\"type\":\"belongsTo\",\"column\":\"city_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 29),
(227, 24, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(228, 24, 'user_id', 'text', 'User Id', 0, 0, 0, 0, 0, 0, '{}', 2),
(229, 24, 'product_id', 'text', 'Product Id', 0, 1, 1, 1, 1, 1, '{}', 3),
(230, 24, 'shop_id', 'text', 'Shop Id', 0, 1, 1, 1, 1, 1, '{}', 4),
(231, 24, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 5),
(232, 24, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"title\"}}', 6),
(233, 24, 'description', 'rich_text_box', 'Description', 0, 1, 1, 1, 1, 1, '{}', 7),
(234, 24, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 8),
(235, 24, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 9),
(236, 24, 'images', 'multiple_images', 'Images', 0, 1, 1, 1, 1, 1, '{}', 10),
(237, 24, 'expired_at', 'timestamp', 'Expired At', 0, 1, 1, 1, 1, 1, '{}', 11),
(238, 24, 'featured', 'checkbox', 'Featured', 0, 1, 1, 1, 1, 1, '{\"off\":\"Off\",\"on\":\"On\",\"checked\":true}', 12),
(239, 24, 'offer_belongsto_product_relationship', 'relationship', 'products', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Product\",\"table\":\"products\",\"type\":\"belongsTo\",\"column\":\"product_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 13),
(240, 24, 'offer_belongsto_shop_relationship', 'relationship', 'shops', 0, 1, 1, 1, 1, 1, '{\"model\":\"App\\\\Models\\\\Shop\",\"table\":\"shops\",\"type\":\"belongsTo\",\"column\":\"shop_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"addresses\",\"pivot\":\"0\",\"taggable\":\"0\"}', 14),
(241, 27, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(242, 27, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\"}}', 2),
(243, 27, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\"},\"validation\":{\"rule\":\"required\"}}', 3),
(244, 27, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 4),
(245, 27, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 5),
(246, 27, 'description', 'text_area', 'Description', 0, 1, 1, 1, 1, 1, '{}', 6),
(247, 9, 'product_belongstomany_prodcat_relationship', 'relationship', 'Category', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"4\"},\"model\":\"App\\\\Models\\\\Prodcat\",\"table\":\"prodcats\",\"type\":\"belongsToMany\",\"column\":\"id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"prodcat_product\",\"pivot\":\"1\",\"taggable\":\"on\"}', 30),
(249, 28, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(250, 28, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 2),
(251, 28, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 3),
(252, 28, 'phone', 'text', 'Phone', 1, 1, 1, 1, 1, 1, '{}', 4),
(253, 28, 'subject', 'text', 'Subject', 1, 1, 1, 1, 1, 1, '{}', 5),
(254, 28, 'message', 'text', 'Message', 1, 1, 1, 1, 1, 1, '{}', 6),
(255, 28, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 7),
(256, 28, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 8),
(257, 19, 'title', 'text', 'Title', 0, 1, 1, 1, 1, 1, '{}', 5),
(258, 19, 'sub_title', 'text', 'Sub Title', 0, 1, 1, 1, 1, 1, '{}', 6),
(259, 19, 'link', 'text', 'Link', 0, 1, 1, 1, 1, 1, '{}', 7),
(260, 9, 'bestdeals', 'checkbox', 'Best Deals', 0, 0, 0, 0, 0, 0, '{\"on\":\"On\",\"off\":\"Off\",\"checked\":false,\"display\":{\"width\":\"6\"}}', 26),
(261, 16, 'user_id', 'text', 'User Id', 1, 0, 0, 0, 0, 0, '{}', 3),
(262, 16, 'shop_id', 'text', 'Shop Id', 1, 1, 1, 1, 1, 1, '{}', 4),
(263, 1, 'l_name', 'text', 'Last Name', 0, 1, 1, 1, 1, 1, '{}', 3),
(264, 1, 'email_verified_at', 'timestamp', 'Email Verified At', 0, 0, 0, 0, 0, 0, '{}', 11),
(265, 1, 'stripe_id', 'text', 'Stripe Id', 0, 0, 0, 0, 0, 0, '{}', 15),
(266, 1, 'pm_type', 'text', 'Pm Type', 0, 0, 0, 0, 0, 0, '{}', 16),
(267, 1, 'pm_last_four', 'text', 'Pm Last Four', 0, 0, 0, 0, 0, 0, '{}', 17),
(268, 1, 'trial_ends_at', 'timestamp', 'Trial Ends At', 0, 0, 0, 0, 0, 0, '{}', 18),
(269, 1, 'paid_at', 'text', 'Paid At', 0, 0, 0, 0, 0, 0, '{}', 19),
(270, 29, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(271, 29, 'key', 'text', 'Key', 0, 1, 1, 1, 1, 1, '{}', 2),
(272, 29, 'english', 'markdown_editor', 'English', 0, 1, 1, 1, 1, 1, '{}', 3),
(273, 29, 'danish', 'markdown_editor', 'Danish', 0, 1, 1, 1, 1, 1, '{}', 4),
(274, 29, 'spanish', 'markdown_editor', 'Spanish', 0, 1, 1, 1, 1, 1, '{}', 5),
(275, 29, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 7),
(276, 29, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 8),
(277, 33, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(278, 33, 'email', 'text', 'Email', 1, 1, 1, 1, 1, 1, '{}', 2),
(279, 33, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 3),
(280, 33, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 4),
(281, 9, 'event_name', 'text', 'Event Name', 0, 0, 0, 0, 0, 0, '{}', 27),
(282, 9, 'event_host', 'text', 'Event Host', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"4\"}}', 28),
(283, 9, 'event_start_date', 'timestamp', 'Event Start Date', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 31),
(284, 9, 'event_end_date', 'timestamp', 'Event End Date', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"6\"}}', 32),
(285, 9, 'last_date_of_purchase', 'timestamp', 'Last Date Of Purchase', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"}}', 33),
(286, 9, 'event_location', 'text', 'Event Location', 0, 0, 1, 1, 1, 1, '{\"display\":{\"width\":\"3\"}}', 34),
(287, 18, 'seen', 'text', 'Seen', 0, 0, 0, 0, 0, 0, '{}', 12),
(288, 29, 'portuguese', 'markdown_editor', 'Portuguese', 0, 1, 1, 1, 1, 1, '{}', 6),
(289, 34, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(290, 34, 'thumbnail', 'image', 'Thumbnail', 1, 1, 1, 1, 1, 1, '{}', 13),
(291, 34, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\"},\"display\":{\"width\":6}}', 2),
(292, 34, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{\"slugify\":{\"origin\":\"name\",\"forceUpdate\":true},\"validation\":{\"rule\":\"unique:events,slug\"},\"display\":{\"width\":6}}', 3),
(293, 34, 'organizer', 'text', 'Organizer', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 4),
(294, 34, 'country', 'text', 'Country', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 5),
(295, 34, 'city', 'text', 'City', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 6),
(296, 34, 'location', 'text', 'Location', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 7),
(297, 34, 'description', 'text', 'Description', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 8),
(298, 34, 'start_at', 'timestamp', 'Start At', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 9),
(299, 34, 'end_at', 'timestamp', 'End At', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 10),
(300, 34, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\"},\"display\":{\"width\":6}}', 11),
(301, 34, 'featured', 'checkbox', 'Featured', 1, 1, 1, 1, 1, 1, '{}', 12),
(302, 34, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 1, '{}', 14),
(303, 34, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 15),
(304, 35, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1),
(305, 35, 'event_id', 'text', 'Event Id', 1, 1, 1, 1, 1, 1, '{}', 3),
(306, 35, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\"},\"display\":{\"width\":6}}', 4),
(307, 35, 'description', 'text', 'Description', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 5),
(308, 35, 'price', 'text', 'Price', 1, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 6),
(309, 35, 'sale_price', 'text', 'Sale Price', 0, 0, 0, 0, 0, 0, '{\"display\":{\"width\":6}}', 7),
(310, 35, 'dates', 'text', 'Dates', 1, 0, 0, 0, 0, 0, '{}', 8),
(311, 35, 'status', 'select_dropdown', 'Status', 1, 1, 1, 1, 1, 1, '{\"default\":\"DRAFT\",\"options\":{\"0\":\"Inactive\",\"1\":\"Active\",\"2\":\"Sold\"},\"display\":{\"width\":6}}', 9),
(312, 35, 'quantity', 'number', 'Quantity', 1, 1, 1, 1, 1, 1, '{\"validation\":{\"rule\":\"required\"},\"display\":{\"width\":6}}', 10),
(313, 35, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 1, '{}', 11),
(314, 35, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 12),
(315, 35, 'product_belongsto_event_relationship', 'relationship', 'events', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6},\"model\":\"App\\\\Models\\\\Event\",\"table\":\"events\",\"type\":\"belongsTo\",\"column\":\"event_id\",\"key\":\"id\",\"label\":\"name\",\"pivot_table\":\"categories\",\"pivot\":\"0\",\"taggable\":\"0\"}', 2),
(316, 35, 'limit_per_order', 'number', 'Limit Per Order', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 12),
(317, 35, 'start_date', 'timestamp', 'Start Date', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 13),
(318, 35, 'end_date', 'timestamp', 'End Date', 0, 1, 1, 1, 1, 1, '{\"display\":{\"width\":6}}', 14);

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
(1, 'users', 'users', 'User', 'Users', 'voyager-person', 'TCG\\Voyager\\Models\\User', 'TCG\\Voyager\\Policies\\UserPolicy', 'TCG\\Voyager\\Http\\Controllers\\VoyagerUserController', NULL, 1, 1, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2023-03-12 01:03:40', '2023-10-31 05:46:50'),
(2, 'menus', 'menus', 'Menu', 'Menus', 'voyager-list', 'TCG\\Voyager\\Models\\Menu', NULL, '', '', 1, 0, NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(3, 'roles', 'roles', 'Role', 'Roles', 'voyager-lock', 'TCG\\Voyager\\Models\\Role', NULL, 'TCG\\Voyager\\Http\\Controllers\\VoyagerRoleController', '', 1, 0, NULL, '2023-03-12 01:03:40', '2023-03-12 01:03:40'),
(4, 'categories', 'categories', 'Category', 'Categories', 'voyager-categories', 'TCG\\Voyager\\Models\\Category', NULL, '', '', 1, 0, NULL, '2023-03-12 01:03:41', '2023-03-12 01:03:41'),
(5, 'posts', 'posts', 'Post', 'Posts', 'voyager-news', 'TCG\\Voyager\\Models\\Post', 'TCG\\Voyager\\Policies\\PostPolicy', NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2023-03-12 01:03:41', '2023-11-02 12:16:44'),
(6, 'pages', 'pages', 'Page', 'Pages', 'voyager-file-text', 'TCG\\Voyager\\Models\\Page', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"desc\",\"default_search_key\":null,\"scope\":null}', '2023-03-12 01:03:41', '2023-11-01 14:27:57'),
(11, 'coupons', 'coupons', 'Coupon', 'Coupons', 'voyager-ticket', 'App\\Models\\Coupon', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:15:49', '2023-04-07 12:23:29'),
(13, 'addresses', 'addresses', 'Address', 'Addresses', 'voyager-location', 'App\\Models\\Address', NULL, NULL, NULL, 0, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:26:46', '2023-09-11 23:29:30'),
(14, 'prodcats', 'prodcats', 'Offer Category', 'Offer categories', 'voyager-company', 'App\\Models\\Prodcat', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:36:57', '2023-10-04 08:43:54'),
(16, 'ratings', 'ratings', 'Rating', 'Ratings', 'voyager-star-two', 'App\\Models\\Rating', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-07 12:44:56', '2023-10-04 08:54:41'),
(18, 'orders', 'orders', 'Order', 'Orders', 'voyager-basket', 'App\\Models\\Order', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-08 09:32:52', '2024-07-28 07:38:46'),
(19, 'sliders', 'sliders', 'Slider', 'Sliders', 'voyager-images', 'App\\Slider', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-04-11 11:40:00', '2023-09-26 16:36:19'),
(21, 'verifications', 'verifications', 'Verification', 'Verifications', 'voyager-bookmark', 'App\\Models\\Verification', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2023-05-04 11:43:33', '2023-05-04 11:43:33'),
(22, 'tickets', 'tickets', 'Ticket', 'Tickets', 'voyager-ticket', 'App\\Models\\Ticket', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":\"parents\"}', '2023-05-11 00:40:41', '2023-05-11 00:48:59'),
(23, 'cities', 'cities', 'City', 'Cities', 'voyager-list-add', 'App\\City', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2023-09-19 04:28:13', '2023-09-19 04:28:13'),
(24, 'offers', 'offers', 'Offer', 'Offers', 'voyager-receipt', 'App\\Models\\Offer', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-09-24 13:36:16', '2023-09-24 13:43:40'),
(27, 'facilities', 'facilities', 'Facility', 'Facilities', 'voyager-news', 'App\\Models\\Facility', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-09-25 16:44:21', '2023-09-25 16:47:02'),
(28, 'contacts', 'contacts', 'Contact', 'Contacts', 'voyager-logbook', 'App\\Models\\Contact', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
(29, 'languages', 'languages', 'Language', 'Languages', 'voyager-book', 'App\\Models\\Language', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2023-11-03 21:26:39', '2024-07-28 07:30:23'),
(33, 'emails', 'emails', 'Email', 'Emails', 'voyager-mail', 'App\\Models\\Email', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null}', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
(34, 'events', 'events', 'Event', 'Events', 'voyager-book', 'App\\Models\\Event', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2024-07-31 23:42:10', '2024-07-31 23:49:53'),
(35, 'products', 'products', 'Product', 'Products', 'voyager-bag', 'App\\Models\\Product', NULL, NULL, NULL, 1, 0, '{\"order_column\":null,\"order_display_column\":null,\"order_direction\":\"asc\",\"default_search_key\":null,\"scope\":null}', '2024-07-31 23:53:15', '2024-08-01 00:37:31');

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE `emails` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint UNSIGNED NOT NULL,
  `thumbnail` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `organizer` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_at` timestamp NOT NULL,
  `end_at` timestamp NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `thumbnail`, `name`, `slug`, `organizer`, `country`, `city`, `location`, `description`, `start_at`, `end_at`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(1, 'product/two.jpg', 'Google I/O West Danemouth', 'google-io-west-danemouth', 'Beer and Sons', 'Guam', 'West Danemouth', '9228 Hill Centers\nNorth Adachester, WV 39438', 'Aut aut quaerat consequuntur sit quam animi.', '2024-09-29 14:25:07', '2024-10-04 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(2, 'product/three.jpg', 'Google I/O West Cassidy', 'google-io-west-cassidy', 'Franecki, Torp and Balistreri', 'Canada', 'West Cassidy', '252 Jo Trail Apt. 291\nNew Immanuel, IA 57268-4794', 'Esse ut illum ut natus esse qui.', '2024-10-03 14:25:07', '2024-10-03 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(3, 'product/three.jpg', 'HackMIT South Modesta', 'hackmit-south-modesta', 'Moen LLC', 'Finland', 'South Modesta', '8194 Bernhard Summit\nSerenityville, MT 96974-0505', 'Recusandae corrupti sed qui quas amet.', '2024-10-17 14:25:07', '2024-10-18 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(4, 'product/two.jpg', 'Microsoft Build Lake Marianeborough', 'microsoft-build-lake-marianeborough', 'Connelly, Wolf and Maggio', 'Aruba', 'Lake Marianeborough', '579 Stamm Manors\nSouth Taya, MI 43275-7441', 'Et et dolorem sit quo.', '2024-09-09 14:25:07', '2024-09-09 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(5, 'product/three.jpg', 'Cannes Film Festival West Armandville', 'cannes-film-festival-west-armandville', 'Lind-Koelpin', 'Western Sahara', 'West Armandville', '95642 Berge Rapid\nNorth Dillan, IA 68644-0564', 'Totam molestiae repudiandae provident voluptatem voluptate dolorem architecto.', '2024-10-12 14:25:07', '2024-10-17 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(6, 'product/one.jpg', 'TechCrunch Disrupt North Scottieton', 'techcrunch-disrupt-north-scottieton', 'Dicki, Reinger and Lynch', 'Saint Martin', 'North Scottieton', '352 Yazmin Ramp\nEast Davonteport, OK 16714-8050', 'Cum hic quod vel.', '2024-09-24 14:25:07', '2024-09-27 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(7, 'product/three.jpg', 'Glastonbury Festival Wilkinsonhaven', 'glastonbury-festival-wilkinsonhaven', 'Rogahn-Rodriguez', 'Niue', 'Wilkinsonhaven', '62574 Hegmann Isle\nGibsonport, PA 94301-6514', 'Error ipsam aspernatur totam occaecati.', '2024-10-05 14:25:07', '2024-10-08 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(8, 'product/two.jpg', 'TechCrunch Disrupt South Whitney', 'techcrunch-disrupt-south-whitney', 'Mayert-Prosacco', 'Bahamas', 'South Whitney', '6688 Runolfsson Corner Apt. 407\nChristopherton, AK 01786-7376', 'Quam nobis ut molestias dignissimos rem illo.', '2024-09-18 14:25:07', '2024-09-22 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(9, 'product/four.jpg', 'Music Midtown North Floy', 'music-midtown-north-floy', 'Daniel-Sauer', 'Wallis and Futuna', 'North Floy', '5041 Terry Light Suite 960\nAndrewview, LA 04698', 'Sed possimus est id aut ut doloribus aut.', '2024-10-01 14:25:07', '2024-10-06 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(10, 'product/two.jpg', 'HackMIT Halvorsonton', 'hackmit-halvorsonton', 'Gottlieb PLC', 'Saint Lucia', 'Halvorsonton', '64449 Hamill Forest\nPatienceshire, KS 27556', 'Ipsa eos ea necessitatibus repudiandae in.', '2024-09-08 14:25:07', '2024-09-12 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(11, 'product/one.jpg', 'HackMIT Lake Annalise', 'hackmit-lake-annalise', 'Pollich PLC', 'Faroe Islands', 'Lake Annalise', '76225 Moen Village\nNienowside, NM 79290', 'Voluptatibus quo harum porro doloremque.', '2024-10-09 14:25:07', '2024-10-12 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(12, 'product/four.jpg', 'Glastonbury Festival East Elinormouth', 'glastonbury-festival-east-elinormouth', 'Schuppe, Schimmel and Walsh', 'Jersey', 'East Elinormouth', '3226 Elisa Motorway\nEast Pasquale, KS 12713-0676', 'Accusamus maxime sed veritatis doloribus.', '2024-10-11 14:25:07', '2024-10-14 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(13, 'product/two.jpg', 'TED Conference Lebsackside', 'ted-conference-lebsackside', 'Quitzon-Jast', 'Egypt', 'Lebsackside', '1846 Uriah Forks Apt. 830\nWest Myronshire, GA 17718-8161', 'Quia atque illum sequi nobis dignissimos quia.', '2024-09-05 14:25:07', '2024-09-06 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(14, 'product/two.jpg', 'Lollapalooza Zeldaside', 'lollapalooza-zeldaside', 'Hahn-Lockman', 'Serbia', 'Zeldaside', '12429 Bobby Island Suite 859\nLake Gerardo, AL 57019-5181', 'Dolorem animi minima iste veniam eum quas possimus.', '2024-09-21 14:25:07', '2024-09-26 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(15, 'product/two.jpg', 'DEF CON Lake Leonardo', 'def-con-lake-leonardo', 'Powlowski Group', 'Korea', 'Lake Leonardo', '2660 Kutch Way\nNorth Madie, ND 91187-0565', 'Eaque cupiditate laboriosam asperiores cumque.', '2024-09-16 14:25:07', '2024-09-16 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(16, 'product/two.jpg', 'TechCrunch Disrupt Sawaynview', 'techcrunch-disrupt-sawaynview', 'Schinner, Macejkovic and Quigley', 'Finland', 'Sawaynview', '522 Berry Passage Apt. 253\nAlanabury, NM 80648-7181', 'Consequatur suscipit esse ipsam laborum ratione sequi.', '2024-09-01 14:25:07', '2024-09-03 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(17, 'product/one.jpg', 'Summerfest Lake Elnora', 'summerfest-lake-elnora', 'Macejkovic-Conn', 'Romania', 'Lake Elnora', '596 Rachelle Spring Suite 672\nQuitzonport, ME 54559-4547', 'Reiciendis sit omnis rerum consequatur et similique.', '2024-09-07 14:25:07', '2024-09-08 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(18, 'product/four.jpg', 'Comic-Con International South Arnaldo', 'comic-con-international-south-arnaldo', 'Corwin, Kshlerin and Emard', 'Trinidad and Tobago', 'South Arnaldo', '66312 Madonna Key Apt. 103\nKuvalismouth, DE 10651-5388', 'Similique impedit in rerum sed.', '2024-09-27 14:25:07', '2024-10-02 14:25:07', 1, 0, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(19, 'product/one.jpg', 'Microsoft Build Neomachester', 'microsoft-build-neomachester', 'Wuckert-Lueilwitz', 'Svalbard & Jan Mayen Islands', 'Neomachester', '2254 O\'Conner Course Apt. 525\nOlaton, MS 41510', 'Quia inventore id qui.', '2024-08-30 14:25:07', '2024-08-31 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07'),
(20, 'product/two.jpg', 'Tomorrowland Monteburgh', 'tomorrowland-monteburgh', 'Jaskolski PLC', 'Haiti', 'Monteburgh', '7833 Chasity Flat Suite 526\nMargueriteside, WI 70366-4484', 'Ut quod beatae consequatur reiciendis eveniet error.', '2024-08-30 14:25:07', '2024-09-01 14:25:07', 1, 1, '2024-07-31 14:25:07', '2024-07-31 14:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `english` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `danish` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `spanish` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2024-07-31 14:25:27', '2024-07-31 14:25:27'),
(3, 'main', '2024-07-31 14:25:27', '2024-07-31 14:25:27');

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
(8, 1, 'Compass', '', '_self', 'voyager-compass', NULL, 5, 3, '2023-03-12 01:03:40', '2023-04-07 12:32:34', 'voyager.compass.index', NULL),
(15, 1, 'Coupons', '', '_self', 'voyager-ticket', NULL, 28, 5, '2023-04-07 12:15:49', '2024-07-27 12:45:48', 'voyager.coupons.index', NULL),
(20, 1, 'Users', '', '_self', 'voyager-people', '#000000', NULL, 2, '2023-04-07 12:58:08', '2024-07-27 12:34:15', 'voyager.users.index', 'null'),
(21, 1, 'Orders', '', '_self', 'voyager-basket', NULL, NULL, 5, '2023-04-08 09:32:52', '2024-07-31 23:46:40', 'voyager.orders.index', NULL),
(23, 1, 'Sliders', 'admin/sliders', '_self', 'voyager-images', '#000000', 28, 4, '2023-04-12 09:03:22', '2023-09-21 17:06:19', NULL, ''),
(24, 1, 'Events', '', '_self', 'voyager-basket', '#000000', NULL, 3, '2023-04-12 09:15:49', '2024-07-27 12:29:59', NULL, ''),
(25, 1, 'Settings', 'admin/settings', '_self', 'voyager-settings', '#000000', 28, 1, '2023-04-12 09:17:03', '2023-05-03 15:26:00', NULL, ''),
(26, 1, 'Pages', 'admin/pages', '_self', 'voyager-file-text', '#000000', 28, 2, '2023-05-03 15:23:47', '2023-05-03 15:26:02', NULL, ''),
(27, 1, 'Menus', 'admin/menus', '_self', 'voyager-list', '#000000', 28, 3, '2023-05-03 15:25:21', '2023-05-03 15:26:03', NULL, ''),
(28, 1, 'Settings', '', '_self', 'voyager-settings', '#000000', NULL, 6, '2023-05-03 15:25:50', '2024-07-31 23:46:40', NULL, ''),
(29, 3, 'Om os', '/about', '_self', NULL, '#000000', NULL, 3, '2023-05-03 15:26:38', '2023-11-01 15:05:43', NULL, ''),
(32, 4, 'About', 'hello', '_self', NULL, '#000000', NULL, 14, '2023-05-17 00:35:54', '2023-05-17 00:35:54', NULL, ''),
(34, 5, 'home', '/', '_self', NULL, '#000000', NULL, 15, '2023-09-03 01:44:11', '2023-09-03 01:44:11', NULL, ''),
(38, 1, 'Contacts', '', '_self', 'voyager-logbook', NULL, NULL, 7, '2023-09-26 10:56:10', '2024-07-31 23:46:40', 'voyager.contacts.index', NULL),
(39, 3, 'Forside', '/', '_self', NULL, '#000000', NULL, 1, '2023-10-07 21:17:08', '2023-11-01 15:04:29', NULL, ''),
(42, 3, 'Deals', '/shops', '_self', NULL, '#000000', NULL, 2, '2023-10-07 21:19:35', '2023-11-01 15:04:48', NULL, ''),
(43, 3, 'Kontakt', '/contact', '_self', NULL, '#000000', NULL, 8, '2023-10-07 21:20:00', '2024-03-23 15:15:25', NULL, ''),
(45, 3, 'Handelsbetingelser', 'page/handelsbetingelser', '_self', NULL, '#000000', NULL, 7, '2023-11-01 14:29:18', '2024-03-23 15:15:30', NULL, ''),
(47, 3, 'Sådan fungerer Halaldeals.dk', 'page/Sådan fungerer Halaldeals.dk', '_self', NULL, '#000000', NULL, 5, '2023-11-01 15:05:27', '2024-03-23 15:15:35', NULL, ''),
(48, 1, 'News', '', '_self', 'voyager-news', '#000000', NULL, 4, '2023-11-02 12:49:54', '2024-07-31 23:46:40', NULL, ''),
(49, 1, 'Post', '/admin/posts', '_self', 'voyager-news', '#000000', 48, 1, '2023-11-02 12:50:33', '2023-11-02 12:52:29', NULL, ''),
(50, 1, 'Category', '/admin/categories', '_self', 'voyager-tag', '#000000', 48, 2, '2023-11-02 12:51:58', '2023-11-02 12:53:02', NULL, ''),
(51, 1, 'Languages', '', '_self', 'voyager-book', NULL, NULL, 8, '2023-11-03 21:26:39', '2024-07-31 23:46:40', 'voyager.languages.index', NULL),
(53, 1, 'Emails', '', '_self', 'voyager-mail', NULL, NULL, 9, '2024-03-31 14:26:21', '2024-07-31 23:46:40', 'voyager.emails.index', NULL),
(54, 1, 'Events', '', '_self', 'voyager-book', NULL, 24, 1, '2024-07-31 23:42:10', '2024-07-31 23:46:40', 'voyager.events.index', NULL),
(55, 1, 'Products', '', '_self', 'voyager-bag', NULL, 24, 3, '2024-07-31 23:53:15', '2024-08-01 00:05:42', 'voyager.products.index', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `metas`
--

CREATE TABLE `metas` (
  `id` bigint UNSIGNED NOT NULL,
  `metable_id` bigint NOT NULL,
  `metable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_value` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(6, '2016_05_19_173453_create_menu_table', 1),
(7, '2016_10_21_190000_create_roles_table', 1),
(8, '2016_10_21_190000_create_settings_table', 1),
(9, '2016_11_30_135954_create_permission_table', 1),
(10, '2016_11_30_141208_create_permission_role_table', 1),
(11, '2016_12_26_201236_data_types__add__server_side', 1),
(12, '2017_01_13_000000_add_route_to_menu_items_table', 1),
(13, '2017_01_14_005015_create_translations_table', 1),
(14, '2017_01_15_000000_make_table_name_nullable_in_permissions_table', 1),
(15, '2017_03_06_000000_add_controller_to_data_types_table', 1),
(16, '2017_04_21_000000_add_order_to_data_rows_table', 1),
(17, '2017_07_05_210000_add_policyname_to_data_types_table', 1),
(18, '2017_08_05_000000_add_group_to_settings_table', 1),
(19, '2017_11_26_013050_add_user_role_relationship', 1),
(20, '2017_11_26_015000_create_user_roles_table', 1),
(21, '2018_03_11_000000_add_user_settings', 1),
(22, '2018_03_14_000000_add_details_to_data_types_table', 1),
(23, '2018_03_16_000000_make_settings_value_nullable', 1),
(24, '2019_05_03_000001_create_customer_columns', 1),
(25, '2019_05_03_000002_create_subscriptions_table', 1),
(26, '2019_05_03_000003_create_subscription_items_table', 1),
(27, '2019_08_19_000000_create_failed_jobs_table', 1),
(28, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(29, '2023_01_31_060406_create_events_table', 1),
(30, '2023_02_22_055833_create_products_table', 1),
(31, '2023_02_22_072723_create_shops_table', 1),
(32, '2023_02_22_073354_create_orders_table', 1),
(33, '2023_02_25_071011_create_coupons_table', 1),
(34, '2023_03_05_055741_create_order_product_table', 1),
(35, '2023_03_17_053256_create_metas_table', 1),
(36, '2023_04_02_195652_create_emails_table', 1),
(37, '2023_05_10_055120_create_tickets_table', 1),
(38, '2023_05_21_202607_create_notifications_table', 1),
(39, '2023_05_28_085316_create_jobs_table', 1),
(40, '2023_09_26_055916_create_contacts_table', 1),
(41, '2023_11_02_184320_create_languages_table', 1),
(42, '2024_07_30_202751_add_contact_number_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0=Unseen 1=seen',
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
  `status` tinyint NOT NULL DEFAULT '0',
  `currency` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` int DEFAULT NULL,
  `discount_code` int DEFAULT NULL,
  `subtotal` int NOT NULL,
  `total` int NOT NULL,
  `tax` int DEFAULT NULL,
  `billing` json DEFAULT NULL,
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_method_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_paid` timestamp NULL DEFAULT NULL,
  `date_completed` timestamp NULL DEFAULT NULL,
  `refund_amount` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `currency`, `discount`, `discount_code`, `subtotal`, `total`, `tax`, `billing`, `payment_method`, `payment_method_title`, `transaction_id`, `date_paid`, `date_completed`, `refund_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 4, NULL, 0, NULL, 60, 60, 0, '{\"email\": \"mewamisug@mailinator.com\", \"phone\": \"01814792546\", \"last_name\": \"Gordon\", \"first_name\": \"Zeph\"}', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-31 14:25:55', '2024-07-31 14:25:55'),
(2, 1, 4, NULL, 0, NULL, 100, 100, 0, '{\"email\": \"rowytymip@mailinator.com\", \"phone\": \"01370019391\", \"last_name\": \"Huber\", \"first_name\": \"Alfreda\"}', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-31 14:27:34', '2024-07-31 14:27:34'),
(3, 2, 4, NULL, 0, NULL, 0, 0, 0, '{\"email\": \"geva@mailinator.com\", \"phone\": \"01874909190\", \"taxid\": \"Exercitationem quia\", \"last_name\": \"Webster\", \"first_name\": \"Julie\"}', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-31 21:59:16', '2024-07-31 21:59:16'),
(4, 2, 4, NULL, 0, NULL, 40, 40, 0, '{\"email\": \"rozaqu@mailinator.com\", \"phone\": \"01926521999\", \"taxid\": \"Nisi animi est volu\", \"last_name\": \"Miranda\", \"first_name\": \"Aphrodite\"}', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-31 22:02:28', '2024-07-31 22:02:28'),
(5, 2, 4, NULL, 0, NULL, 60, 60, 0, '{\"email\": \"myhune@mailinator.com\", \"phone\": \"01289743788\", \"taxid\": \"Eligendi dicta sit s\", \"last_name\": \"James\", \"first_name\": \"Brianna\"}', NULL, NULL, NULL, NULL, NULL, NULL, '2024-07-31 22:05:51', '2024-07-31 22:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE `order_product` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `total_price` int NOT NULL,
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
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('ACTIVE','INACTIVE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'INACTIVE',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `author_id`, `title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Terms and Conditions', NULL, '<div id=\"fws_66a8ed39e007d\" class=\"wpb_row vc_row-fluid vc_row full-width-section standard_section   \" data-midnight=\"dark\" data-bg-mobile-hidden=\"\">\n<div class=\"col span_12 dark left\">\n<div class=\"vc_col-sm-12 wpb_column column_container vc_column_container col has-animation no-extra-padding instance-1 animated-in\" data-t-w-inherits=\"default\" data-border-radius=\"none\" data-shadow=\"none\" data-border-animation=\"\" data-border-animation-delay=\"\" data-border-width=\"none\" data-border-style=\"solid\" data-border-color=\"\" data-bg-cover=\"\" data-padding-pos=\"all\" data-has-bg-color=\"false\" data-bg-color=\"\" data-bg-opacity=\"1\" data-hover-bg=\"\" data-hover-bg-opacity=\"1\" data-animation=\"fade-in\" data-delay=\"0\">\n<div class=\"vc_column-inner\">\n<div class=\"wpb_wrapper\">\n<div id=\"fws_66a8ed39e03e7\" class=\"wpb_row vc_row-fluid vc_row standard_section    \" data-midnight=\"\" data-column-margin=\"default\" data-bg-mobile-hidden=\"\">\n<div class=\"col span_12  left\">\n<div class=\"vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding instance-2\" data-t-w-inherits=\"default\" data-shadow=\"none\" data-border-radius=\"none\" data-border-animation=\"\" data-border-animation-delay=\"\" data-border-width=\"none\" data-border-style=\"solid\" data-border-color=\"\" data-bg-cover=\"\" data-padding-pos=\"all\" data-has-bg-color=\"false\" data-bg-color=\"\" data-bg-opacity=\"1\" data-hover-bg=\"\" data-hover-bg-opacity=\"1\" data-animation=\"\" data-delay=\"0\">\n<div class=\"vc_column-inner\">\n<div class=\"wpb_wrapper\">\n<div class=\"iwithtext\">\n<div class=\"iwt-text\">\n<p><strong>PRE&Acirc;MBULO&nbsp;</strong></p>\n<p>1.&ordm; Estas condi&ccedil;&otilde;es gerais de venda s&atilde;o acordadas entre a Ess&ecirc;ncia Eventos E Comunica&ccedil;&atilde;o, Unipessoal, Lda com sede em Av. do Dr. Antunes Guimar&atilde;es 788, 4100-075 Porto, n&uacute;mero de identifica&ccedil;&atilde;o fiscal 506 844 374 e contacto +351 22 208 8499, doravante designada por &ldquo;Ess&ecirc;ncia Company&rdquo; e as pessoas que desejem efetuar compras atrav&eacute;s do website www.events.essenciacompany.com doravante designadas por \"Utilizador\".&nbsp;<br>2.&ordm; As partes acordam que as compras efetuadas atrav&eacute;s do website www.events.essenciacompany.com ser&atilde;o reguladas exclusivamente pelo presente contrato com exclus&atilde;o de quaisquer condi&ccedil;&otilde;es previamente dispon&iacute;veis no website.&nbsp;</p>\n<p><br><span style=\"color: rgb(0, 0, 0);\"><strong>ARTIGO 1 &ndash; OBJETO </strong></span></p>\n<p>1. As presentes condi&ccedil;&otilde;es gerais de venda t&ecirc;m por objeto disponibilizar e definir todas as informa&ccedil;&otilde;es necess&aacute;rias ao Utilizador sobre as modalidades de encomenda, de venda, pagamento e presta&ccedil;&atilde;o do servi&ccedil;o, efetuado no website www.events.essenciacompany.com&nbsp;<br>2. Estas condi&ccedil;&otilde;es regulam todas as etapas necess&aacute;rias para realizar a aquisi&ccedil;&atilde;o e garantem o seguimento desta presta&ccedil;&atilde;o de servi&ccedil;o ao Utilizador.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>ARTIGO 2 &ndash; ENCOMENDA </strong></p>\n<p>1. O Utilizador concretiza a sua encomenda atrav&eacute;s da conclus&atilde;o do processo de compra apresentado no website www.events.essenciacompany.com, adicionando o(s) servi&ccedil;o(s) que pretende encomendar ao cesto de compras:&nbsp;<br>2. Para receber o(s) bilhete(s) de acesso ao(s) evento(s) o Utilizador dever&aacute;:&nbsp;<br>a) Escolher o(s) bilhete(s) que quer adquirir em &nbsp;www.events.essenciacompany.com, indicando a quantidade.&nbsp;<br>b) Registar-se no website www.events.essenciacompany.com, fornecendo para o efeito as informa&ccedil;&otilde;es a&iacute; solicitadas.&nbsp;<br>c) Completar a informa&ccedil;&atilde;o e escolher as op&ccedil;&otilde;es que lhe s&atilde;o disponibilizadas ao longo do processo de t&eacute;rmino da encomenda (email para receber o(s) bilhete(s), morada de factura&ccedil;&atilde;o, forma de pagamento, bem como o NIF e o nome que, para efeitos fiscais, pretende que constem na fatura).&nbsp;<br>3. A confirma&ccedil;&atilde;o final da encomenda pelo Utilizador equivale &agrave; aceita&ccedil;&atilde;o plena e completa dos pre&ccedil;os e descri&ccedil;&atilde;o dos servi&ccedil;os dispon&iacute;veis para venda assim como destas Condi&ccedil;&otilde;es Gerais de Venda que ser&atilde;o as &uacute;nicas aplic&aacute;veis ao contrato assim conclu&iacute;do.&nbsp;<br>4. A EMPRESA honrar&aacute; as encomendas recebidas online. Na falta de disponibilidade da presta&ccedil;&atilde;o do servi&ccedil;o a EMPRESA compromete-se a informar o Utilizador logo que lhe seja poss&iacute;vel.<br>5. Os dados constantes na fatura s&atilde;o da inteira responsabilidade do Utilizador. A fatura depois de emitida n&atilde;o poder&aacute; ser reemitida com altera&ccedil;&otilde;es.&nbsp;<br>6. Caso o pagamento da factura n&atilde;o seja recepcionado pelos servi&ccedil;os dentro do prazo indicado, a compra de bilhete(s) n&atilde;o ser&aacute; garantida.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>ARTIGO 3 &ndash; PAGAMENTO </strong></p>\n<p>1. No website www.events.essenciacompany.com , a EMPRESA prop&otilde;e ao Utilizador as seguintes modalidades de pagamento via Easypay - Institui&ccedil;&atilde;o de Pagamento Lda:&nbsp;<br>a) Cart&atilde;o de cr&eacute;dito (Visa, Mastercard);&nbsp;<br>b) Refer&ecirc;ncia Multibanco;&nbsp;<br>c) Mbway;&nbsp;</p>\n<p><img src=\"https://ticket.sohojware.com/storage/pages/July2024/metodos-de-pagamento.png\" alt=\"\" width=\"75\" height=\"10\"></p>\n<p>2. No caso do pagamento com cart&atilde;o de cr&eacute;dito, o d&eacute;bito ser&aacute; efetuado no cart&atilde;o do Utilizador imediatamente ap&oacute;s confirma&ccedil;&atilde;o da capacidade de presta&ccedil;&atilde;o do servi&ccedil;o. Se algum dos servi&ccedil;os encomendados n&atilde;o for poss&iacute;vel de ser prestado, o valor dos mesmos ser&aacute; creditado no cart&atilde;o do Utilizador, ap&oacute;s o fecho da encomenda.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>ARTIGO 4 &ndash; DISPONIBILIZA&Ccedil;&Atilde;O E CONSUMO </strong></p>\n<p>1. A disponibiliza&ccedil;&atilde;o do servi&ccedil;o ser&aacute; realizada nas datas do evento e ap&oacute;s a confirma&ccedil;&atilde;o do pagamento efectuado.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>ARTIGO 5 &ndash; PRE&Ccedil;OS&nbsp;</strong><br>1. Os pre&ccedil;os devem entender-se em Euros, com taxas e impostos inclu&iacute;dos, tendo em conta o IVA em vigor &agrave; data do pagamento da encomenda.&nbsp;<br>2. Caso se verifique um aumento do Pre&ccedil;os de algum servi&ccedil;o, o Utilizador ser&aacute; informado de imediato, podendo optar por continuar a sua encomenda (efetuando o pagamento da diferen&ccedil;a) ou por proceder ao seu cancelamento.&nbsp;</p>\n<p>&nbsp;</p>\n<p><strong>ARTIGO 6 &ndash; CANCELAMENTO E DEVOLU&Ccedil;&Atilde;O&nbsp;</strong></p>\n<p>1. O processo de cancelamento ou devolu&ccedil;&atilde;o &eacute; tratado caso a caso pela Ess&ecirc;ncia Company. O pedido dever&aacute; chegar por escrito para o e-mail de contacto tickets@essenciacompany.com, at&eacute; 14 dias ap&oacute;s a encomenda, sendo as instru&ccedil;&otilde;es de cancelamento ou devolu&ccedil;&atilde;o do valor pago respondidas e definidas pela EMPRESA, pelo mesmo meio de comunica&ccedil;&atilde;o.&nbsp;<br>2. Sempre que poss&iacute;vel a devolu&ccedil;&atilde;o dever&aacute; realizar-se pela mesma via de pagamento, mas caso n&atilde;o seja poss&iacute;vel, o utilizador dever&aacute; apresentar comprovativos de pagamento e de titularidade de conta ou cart&atilde;o, para que se realize a devolu&ccedil;&atilde;o por Transfer&ecirc;ncia Banc&aacute;ria.&nbsp;<br>3. A EMPRESA compromete-se a reembolsar o Utilizador no prazo m&aacute;ximo de 30 dias.</p>\n<p>&nbsp;</p>\n<p><strong>ARTIGO 7 &ndash; POL&Iacute;TICA DE PRIVACIDADE&nbsp;</strong><br>O tratamento dos seus dados &eacute; feito no cumprimento da legisla&ccedil;&atilde;o sobre a prote&ccedil;&atilde;o de dados pessoais. Os mesmos, sujeitos a tratamento inform&aacute;tico, constar&atilde;o na(s) base(s) de dados da EMPRESA e destinam-se ao registo e apresenta&ccedil;&atilde;o de outros produtos e servi&ccedil;os, bem como informa&ccedil;&atilde;o institucional, a disponibilizar pelas mesmas.&nbsp;<br>O seu fornecimento &eacute; facultativo e &eacute; garantido, nos termos da lei, o direito de acesso, retifica&ccedil;&atilde;o e anula&ccedil;&atilde;o de qualquer dado que lhe diga diretamente respeito, pessoalmente ou por via escrita, diretamente para o endere&ccedil;o constante na p&aacute;gina inicial deste website.</p>\n</div>\n</div>\n</div>\n</div>\n</div>\n</div>\n</div>\n</div>\n</div>\n</div>\n</div>\n</div>', NULL, 'terms-and-conditions', NULL, NULL, 'ACTIVE', '2024-07-31 23:39:56', '2024-07-31 23:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
(90, 'delete_tickets', 'tickets', '2023-05-11 00:40:41', '2023-05-11 00:40:41'),
(91, 'browse_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
(92, 'read_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
(93, 'edit_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
(94, 'add_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
(95, 'delete_cities', 'cities', '2023-09-19 04:28:14', '2023-09-19 04:28:14'),
(96, 'browse_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
(97, 'read_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
(98, 'edit_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
(99, 'add_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
(100, 'delete_offers', 'offers', '2023-09-24 13:36:16', '2023-09-24 13:36:16'),
(101, 'browse_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
(102, 'read_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
(103, 'edit_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
(104, 'add_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
(105, 'delete_facilities', 'facilities', '2023-09-25 16:44:21', '2023-09-25 16:44:21'),
(106, 'browse_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
(107, 'read_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
(108, 'edit_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
(109, 'add_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
(110, 'delete_contacts', 'contacts', '2023-09-26 10:56:10', '2023-09-26 10:56:10'),
(111, 'browse_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
(112, 'read_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
(113, 'edit_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
(114, 'add_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
(115, 'delete_languages', 'languages', '2023-11-03 21:26:39', '2023-11-03 21:26:39'),
(116, 'browse_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
(117, 'read_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
(118, 'edit_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
(119, 'add_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
(120, 'delete_emails', 'emails', '2024-03-31 14:26:21', '2024-03-31 14:26:21'),
(121, 'browse_events', 'events', '2024-07-31 23:42:10', '2024-07-31 23:42:10'),
(122, 'read_events', 'events', '2024-07-31 23:42:10', '2024-07-31 23:42:10'),
(123, 'edit_events', 'events', '2024-07-31 23:42:10', '2024-07-31 23:42:10'),
(124, 'add_events', 'events', '2024-07-31 23:42:10', '2024-07-31 23:42:10'),
(125, 'delete_events', 'events', '2024-07-31 23:42:10', '2024-07-31 23:42:10'),
(126, 'browse_products', 'products', '2024-07-31 23:53:15', '2024-07-31 23:53:15'),
(127, 'read_products', 'products', '2024-07-31 23:53:15', '2024-07-31 23:53:15'),
(128, 'edit_products', 'products', '2024-07-31 23:53:15', '2024-07-31 23:53:15'),
(129, 'add_products', 'products', '2024-07-31 23:53:15', '2024-07-31 23:53:15'),
(130, 'delete_products', 'products', '2024-07-31 23:53:15', '2024-07-31 23:53:15');

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
(89, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
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
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('PUBLISHED','DRAFT','PENDING') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'DRAFT',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `category_id`, `title`, `seo_title`, `excerpt`, `body`, `image`, `slug`, `meta_description`, `meta_keywords`, `status`, `featured`, `created_at`, `updated_at`) VALUES
(5, 2, 1, 'Hvor skal man tage hen på ferie og hvor skal man spise?', NULL, 'Hvor skal man tage på ferie og hvor skal man spise?', '<p>Vi alle har brug for en pause fra hverdagen.&nbsp;</p>\r\n<p>Men hvad skal man g&oslash;re? hvor skal man tilbringe den sparsomme tid?</p>\r\n<p>Hos Halaldeals har vi unikke tilbud til dem, som &oslash;nsker at berige deres dagligdag med en oplevelse, hvor de kan nyde en bid mad eller f&aring; en oplevelse, som er halal. N&aring;r vi siger halal, s&aring; betyder det eksempelvis at maden vil v&aelig;re halal og det er ogs&aring; en stor del af selve oplevelsen.</p>\r\n<p>Tilmeld dig vores nyhedsbrev og berig dig selv med nye oplevelser som vi l&oslash;bende vil opdatere dig med.</p>\r\n<p>&nbsp;</p>\r\n<p>mvh</p>\r\n<p>Halaldeals.dk</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 'posts/March2024/l7SOp6OsIPs51UTKQotx.jpeg', 'hvor-skal-man-tage-hen-pa-ferie-og-hvor-skal-man-spise', NULL, NULL, 'PUBLISHED', 1, '2024-03-23 14:48:29', '2024-03-23 15:19:47'),
(6, 2, 2, 'Er du en globetrotter?', NULL, NULL, '<p><strong>Muslimske Globetrottere: Fra Ibn Battuta til Nutidens Eventyrere</strong></p>\r\n<p>At rejse har altid v&aelig;ret en m&aring;de for mennesker at opdage og forst&aring; verden p&aring;. Det er en kilde til viden, berigelse og &aring;ndelig v&aelig;kst. I dag har vi privilegiet at have utallige muligheder for at udforske nye steder og kulturer, hvilket &aring;bner d&oslash;re til erfaringer, der er lige s&aring; v&aelig;rdifulde som dem, muslimske eventyrere som Ibn Battuta havde i fortiden.</p>\r\n<p><strong>Ibn Battuta: Den Store Rejsende</strong></p>\r\n<p>Lad os starte med en af de mest ikoniske muslimske rejsende gennem tiderne - Ibn Battuta. Han blev f&oslash;dt i Marokko i det 14. &aring;rhundrede og begav sig ud p&aring; en utrolig rejse, der strakte sig over 75.000 kilometer og inkluderede bes&oslash;g i mere end 40 lande. Hans rejse begyndte som en pilgrimsrejse til Mekka, men hans eventyrlyst f&oslash;rte ham til at udforske hele den kendte verden p&aring; det tidspunkt. Han nedskrev sine oplevelser i v&aelig;rket \"Rihla,\" der stadig betragtes som en uvurderlig kilde til historisk og kulturel viden.</p>\r\n<p>Ibn Battutas rejse var en bem&aelig;rkelsesv&aelig;rdig pr&aelig;station p&aring; den tid, da det kr&aelig;vede en enorm viljestyrke og mod at udforske det ukendte. Han m&oslash;dte forskellige kulturer, l&aelig;rte nye sprog og indgik venskaber, der var afg&oslash;rende for hans overlevelse. Hans rejse er en p&aring;mindelse om, at selv i en tid med begr&aelig;nsede teknologiske ressourcer og transportmuligheder, var &oslash;nsket om at udforske og opdage en st&aelig;rk drivkraft.</p>\r\n<p><img title=\"Halaldeals.dk Ibn bin Battuta\" src=\"http://halaldeals.dk/storage/pages/October2023/Ibn bin battura.jpg\" alt=\"\" width=\"516\" height=\"800\"></p>\r\n<p>Ibn Battuta delte scenen med flere andre, der ligeledes tog p&aring; sp&aelig;ndende rejser og berigede verden med deres oplevelser. Lad os udforske nogle af dem:</p>\r\n<p><strong>1. Ibn Battuta (1304-1368):</strong> Selvf&oslash;lgelig starter vi med Ibn Battuta selv. Hans utrolige rejse begyndte som en pilgrimsrejse til Mekka, men hans eventyrlyst f&oslash;rte ham p&aring; en 30-&aring;rig rejse, der f&oslash;rte ham til steder som Marokko, Indien, Kina og flere afrikanske lande. Hans livsfort&aelig;lling i v&aelig;rket \"Rihla\" er stadig en ut&oslash;mmelig kilde til historisk og kulturel viden.</p>\r\n<p><strong>2. Mansa Musa (1280-1337):</strong> Mansa Musa var en ber&oslash;mt muslimsk konge i Mali-riget. Han er kendt for sin legendariske pilgrimsrejse til Mekka, hvor han f&oslash;rte en enorm karavane, der bar store m&aelig;ngder guld, hvilket f&oslash;rte til en &oslash;konomisk katastrofe i de omr&aring;der, han passerede. Ikke desto mindre er han kendt for at have udbredt islam i Vestafrika og for sin velg&oslash;renhed.</p>\r\n<p><strong>3. Ibn Jubayr (1145-1217):</strong> Ibn Jubayr, en anden bem&aelig;rkelsesv&aelig;rdig muslimsk rejsende, foretog en rejse fra Spanien til Mekka i det 12. &aring;rhundrede.&nbsp;</p>\r\n<p>Disse eksempler viser, at muslimske eventyrere har haft sp&aelig;ndende historier, der har bidraget til den globale historie. De har rejst i alle retninger, krydset gr&aelig;nser og kulturer og inspireret os til at udforske verden p&aring; nye m&aring;der.</p>\r\n<p>I dag har b&aring;de m&aelig;nd og kvinder, unge og gamle, muligheden for at tage p&aring; eventyr som disse store muslimske rejsende. Moderne teknologi og rejsemuligheder g&oslash;r det lettere end nogensinde f&oslash;r at udforske verden. S&aring; lad os lade os inspirere af disse eventyrere og f&oslash;lge vores egne dr&oslash;mme om at opdage de skatte, der venter i verdenen uden for vores d&oslash;re. Rejs, opdag og lev livet fuldt ud - som muslimer og som borgere af en mangfoldig og vidunderlig planet.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Nutidens Muligheder for Opdagelse</strong></p>\r\n<p>I dag har vi adgang til utallige muligheder for at f&oslash;lge i fodsporene p&aring; eventyrere som Ibn Battuta. Moderne teknologi og globalisering har gjort det muligt for os at rejse lettere og mere bekvemt end nogensinde f&oslash;r. Der er flyrejser, hurtigtog og internettet, der g&oslash;r det muligt for os at planl&aelig;gge vores rejser, finde information om destinationer og endda booke hoteller og restaurantreservationer fra vores smartphones.</p>\r\n<p><strong>Hvorfor Vi Skal Rejse og Opdage</strong></p>\r\n<p>Rejser og opdagelse handler ikke kun om at se smukke steder og pr&oslash;ve l&aelig;kker mad. Det handler ogs&aring; om at udvide vores horisonter, fordybe vores forst&aring;else af verden og berige vores liv med nye perspektiver. N&aring;r vi udforsker forskellige kulturer, l&aelig;rer vi at v&aelig;rds&aelig;tte mangfoldigheden i Guds skaberv&aelig;rk.</p>\r\n<p>Desuden hj&aelig;lper rejser os med at skabe minder og oplevelser, der former os som individer. Vi l&aelig;rer at overvinde udfordringer, forst&aring;else og tolerance for andre kulturer og styrker vores tro p&aring;, at verden er en skattekiste fyldt med sk&oslash;nhed og underv&aelig;rker.</p>\r\n<p>I dag, som muslimske rejsende, har vi mulighed for at udforske verden og f&oslash;lge i fodsporene p&aring; tidligere eventyrere som Ibn Battuta. Moderne teknologi og rejsefaciliteter har gjort det lettere end nogensinde f&oslash;r. S&aring; lad os pakke vores tasker, lade vores nysgerrighed og eventyrlyst guide os, og begive os ud p&aring; vores eget episke eventyr for at opdage og forst&aring; den vidunderlige verden, der venter p&aring; os derude. Rejs, opdag og lev livet fuldt ud - det er en invitation, vi b&oslash;r omfavne med &aring;bne arme.</p>\r\n<p>Find vores tilbud p&aring; rejser HER</p>', 'posts/March2024/w5CUluok7iitvTPtbsHf.png', 'er-du-en-globetrotter', NULL, NULL, 'PUBLISHED', 0, '2024-03-23 15:53:59', '2024-03-23 15:53:59'),
(7, 2, 2, 'Spis rejs og lev', NULL, NULL, '<p><strong>Opdag Verden med Halaldeals.dk: Rejs, Spis og Lev Livet som Muslim</strong></p>\r\n<p>Rejs, spis og lev - tre ord, der indeholder n&oslash;glen til at udforske verden. Hos Halaldeals.dk &aring;bner vi d&oslash;ren til sp&aelig;ndende muligheder for dig, der s&oslash;ger at berige dit liv med uforglemmelige oplevelser og tilbud, der ikke g&aring;r p&aring; kompromis med din overbevisning. Vores tilbud kan inkludere alt fra eksklusive restaurantoplevelser til fantastiske rejser og hotelophold.</p>\r\n<p><strong>Rejser, der N&aelig;rer Din Sj&aelig;l</strong></p>\r\n<p>Rejser er en mulighed for at udforske verden, forst&aring; forskellige kulturer og fordybe din forbindelse til alt hvad vores skaber har skabt. Halaldeals.dk tilbyder skr&aelig;ddersyede rejseoplevelser, der er skr&aelig;ddersyet prim&aelig;rt til muslimske rejsende. Uanset om du dr&oslash;mmer om en pilgrimsrejse til Mekka eller Medina eller en eventyrlig tur til en eksotisk destination som Bali, s&aring; har vi unikke rejsetilbud, der passer til dine behov.&nbsp;</p>\r\n<p><img title=\"Halaldeals.dk Blog 1. Rejs spis og lev\" src=\"http://halaldeals.dk/storage/pages/October2023/pexels-beyzanur-k-18721555.jpg\" alt=\"\" width=\"1800\" height=\"2700\"></p>\r\n<p><strong>Smag P&aring; Verden med Halalmad</strong></p>\r\n<p>En af de mest forn&oslash;jelige aspekter ved at rejse er at udforske forskellige k&oslash;kkener. Vores deals inkluderer eksklusive aftaler med restauranter, der serverer autentisk og l&aelig;kker mad, som er halal. Uanset om det er gourmetretter i Dubai, traditionelle smagsoplevelser i Tyrkiet eller en gourmet restaurant i indre K&oslash;benhavn, vil du opleve en verden af kulinariske forn&oslash;jelser uden at bekymre dig om det du f&aring;r serveret er halal.</p>\r\n<p><strong>Komfortable Hotelophold for Kvinder</strong></p>\r\n<p>Vi forst&aring;r, at det som muslimsk kvinde kan v&aelig;re udfordrende at finde komfortable og respektfulde hotelophold. Derfor har Halaldeals.dk indg&aring;et aftaler med hoteller, der prioriterer kvindelige g&aelig;sters komfort og sikkerhed. S&aring; uanset om du planl&aelig;gger en afslappende ferie eller forretningsrejse, kan du stole p&aring; vores tilbud til kvinder.</p>\r\n<p><strong>Hvorfor Rejse, Spis og Lev som Muslim?</strong></p>\r\n<p>At rejse, spise og leve som muslim handler ikke kun om at opfylde religi&oslash;se forpligtelser; det handler om at berige dit liv og din sj&aelig;l. Det handler om at omfavne den mangfoldighed, som Gud har skabt i verden. Det handler om at skabe minder og oplevelser, der vil forme dig og dit syn p&aring; verden.</p>\r\n<p>S&aring; hvorfor skal du rejse, spise og leve som muslim? Fordi det er en invitation til at udforske verden p&aring; dine egne vilk&aring;r, i overensstemmelse med dine v&aelig;rdier og tro. Halaldeals.dk er her for at hj&aelig;lpe dig med at g&oslash;re dette til virkelighed. S&aring; g&aring; ikke glip af de unikke tilbud, der kan give dig mulighed for at rejse, smage, og leve livet som muslim.</p>\r\n<p><strong>Slutningen p&aring; Rejsen - Begyndelsen p&aring; Livet</strong></p>\r\n<p>Rejser, spisning og livet som muslim er mere end bare aktiviteter; det er en livsfilosofi. Det er en m&aring;de at fejre din tro og fordybe din forst&aring;else af verden og dine medmennesker. Halaldeals.dk er din partner p&aring; denne rejse, der &aring;bner d&oslash;rene til en verden af muligheder, hvor du kan leve dit liv i overensstemmelse med dine v&aelig;rdier og tro.</p>\r\n<p>S&aring; lad os sammen udforske verden, smage dens skatte og leve vores liv fuldt ud som muslimer. Rejs, spis og lev - det er ikke blot en opfordring, det er en invitation til at omfavne livets sk&oslash;nhed og mangfoldighed med Halaldeals.dk.</p>', 'posts/March2024/iL7IDstayS8nHEwgnASX.jpg', 'spis-rejs-og-lev', NULL, NULL, 'PUBLISHED', 0, '2024-03-23 15:56:05', '2024-03-23 15:56:05'),
(8, 2, 1, 'Halal hvad er det?', NULL, NULL, '<p><strong>Betydning af Halal Mad: Kilden til Tro og Tillid</strong></p>\r\n<p>Halal mad er ikke blot en kostplan, det er en grundpille i den muslimske livsstil. Det indeb&aelig;rer at spise f&oslash;devarer og drikkevarer, der er tilladte i henhold til islamiske love og retningslinjer, og det er mere end blot en religi&oslash;s praksis - det er en livsstil og et udtryk for tro og respekt for Gud. Lad os udforske, hvorfor halal mad er s&aring; vigtig for muslimer og hvordan Halaldeals.dk samarbejder med restauranter for at sikre, at halalforordningerne overholdes.</p>\r\n<p><strong>Halal Mad og Troen</strong></p>\r\n<p>For muslimer er det at spise halal mad en m&aring;de at leve i overensstemmelse med deres religi&oslash;se overbevisninger. Det er baseret p&aring; de klare retningslinjer i koranen og profetens hadith, der specificerer, hvilke f&oslash;devarer der er lovlige (halal) og hvilke der er forbudte (haram). At f&oslash;lge disse retningslinjer er et udtryk for lydighed mod Gud og en m&aring;de at udtrykke taknemmelighed for Hans forsyning og gaver. J&oslash;dedommen f&oslash;lger de samme principper, som kaldes kosher, istedet for halal.</p>\r\n<p>&nbsp;</p>\r\n<p><strong>Sikkerhed og Tillid i Halal Mad</strong></p>\r\n<p>Halal mad handler ikke kun om at spise korrekte f&oslash;devarer, men det omfatter ogs&aring;, hvordan maden tilberedes. En vigtig del af halalforordningerne er, at maden skal tilberedes og h&aring;ndteres p&aring; en m&aring;de, der overholder rene og hygiejniske standarder. Dette garanterer ikke kun, at maden er tilladt if&oslash;lge islamisk lov, men det sikrer ogs&aring;, at den er sund og sikker at indtage.</p>\r\n<p>For muslimer er sp&oslash;rgsm&aring;let om tillid og sikkerhed i maden vigtig. N&aring;r de spiser p&aring; restauranter, &oslash;nsker de at v&aelig;re sikre p&aring;, at de ikke kun spiser halal mad, men at den ogs&aring; er blevet tilberedt korrekt og uden krydsforurening med haram ingredienser. Det er her, Halaldeals.dk kommer ind i billedet.</p>\r\n<p><strong>Halaldeals.dk og Kvalitetskontrol</strong></p>\r\n<p>Halaldeals.dk har skabt en platform, der samarbejder med restauranter og spisesteder, der forpligter sig til at levere &aelig;gte halal mad. Dette betyder, at de kun bruger halal ingredienser og f&oslash;lger strenge retningslinjer indenfor tilberedning og h&aring;ndtering af maden. Dette sikrer, at muslimer, der v&aelig;lger at spise p&aring; disse steder, kan g&oslash;re det med tillid og fred i sindet.</p>\r\n<p>Vi hos Halaldeals.dk forpligter os til at finde spisesteder til jer, der &oslash;nsker at nyde autentisk og velsmagende mad. Dette inkluderer alt fra eksotiske retter fra Mellem&oslash;sten til asiatiske delikatesser og moderne fusionk&oslash;kkener.&nbsp;</p>\r\n<p><strong>Forskel p&aring; 100% halal og delvis halal</strong></p>\r\n<p>&nbsp;</p>', 'posts/March2024/CRFq503HYUPkY4osGrfS.jpg', 'halal-hvad-er-det', NULL, NULL, 'PUBLISHED', 0, '2024-03-23 15:57:23', '2024-03-23 15:57:23');

-- --------------------------------------------------------

--
-- Table structure for table `prodcats`
--

CREATE TABLE `prodcats` (
  `id` bigint UNSIGNED NOT NULL,
  `shop_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prodcats`
--

INSERT INTO `prodcats` (`id`, `shop_id`, `name`, `logo`, `slug`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 5, 'Restaurant', 'cat/1.png', 'Restaurant', NULL, NULL, '2023-10-20 14:04:39'),
(2, 4, 'Hotelophold', 'cat/2.png', 'Hotelophold', NULL, NULL, '2023-10-20 14:05:00'),
(3, 1, 'Skønhed og velvære', 'cat/3.png', 'Skønhed og velvære', NULL, NULL, '2023-10-20 14:05:20'),
(4, 3, 'Familie oplevelser', 'cat/4.png', 'Familie oplevelser', NULL, NULL, '2023-10-20 14:05:53'),
(5, 4, 'Styrk dit indre jeg', 'cat/5.png', 'Styrke dit indre jeg', NULL, NULL, '2023-10-20 14:06:31');

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
(4, 63, 4, '2023-09-12 02:11:43', '2023-09-12 02:11:43'),
(8, 66, 2, '2023-09-14 04:21:04', '2023-09-14 04:21:04'),
(11, 68, 3, '2023-09-19 05:27:22', '2023-09-19 05:27:22'),
(12, 70, 4, NULL, NULL),
(13, 70, 3, NULL, NULL),
(14, 71, 1, NULL, NULL),
(15, 74, 1, NULL, NULL),
(16, 73, 5, NULL, NULL),
(17, 72, 3, NULL, NULL),
(18, 67, 2, NULL, NULL),
(19, 75, 2, NULL, NULL),
(20, 76, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `event_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint NOT NULL,
  `sale_price` bigint DEFAULT NULL,
  `dates` json NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `quantity` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `limit_per_order` int DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `event_id`, `name`, `description`, `price`, `sale_price`, `dates`, `status`, `quantity`, `created_at`, `updated_at`, `limit_per_order`, `start_date`, `end_date`) VALUES
(1, 1, 'Sponsor Ticket', 'Minus magnam ea saepe tempore itaque.', 2000, 9, '[\"2024-09-29\", \"2024-09-30\", \"2024-10-02\"]', 1, 637, '2024-07-31 14:25:07', '2024-08-01 00:26:31', 10, NULL, NULL),
(2, 1, 'Day Pass', 'Ut consequatur ut nulla incidunt autem doloribus et.', 20, NULL, '[\"2024-09-29\"]', 1, 753, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(3, 1, 'Student Ticket', 'Enim ex illum et cum.', 20, NULL, '[\"2024-09-29\", \"2024-09-30\", \"2024-10-01\", \"2024-10-02\", \"2024-10-03\", \"2024-10-04\"]', 1, 646, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(4, 2, 'Sponsor Ticket', 'Sed totam natus est architecto aspernatur et corrupti.', 20, NULL, '[\"2024-10-03\"]', 1, 424, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(5, 2, 'Early Bird', 'Natus et enim delectus.', 20, NULL, '[\"2024-10-03\"]', 1, 949, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(6, 2, 'Sponsor Ticket', 'Odio qui explicabo aut voluptatem dolores.', 20, NULL, '[\"2024-10-03\"]', 1, 537, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(7, 3, 'Day Pass', 'Explicabo qui ea consequatur.', 20, 10, '[\"2024-10-17\", \"2024-10-18\"]', 1, 300, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(8, 3, 'Group Package', 'Totam sit omnis esse eaque omnis atque sunt quasi.', 20, NULL, '[\"2024-10-17\", \"2024-10-18\"]', 1, 519, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(9, 3, 'Exhibition Only', 'Quae explicabo vero amet est recusandae molestiae aut nihil.', 20, NULL, '[\"2024-10-17\", \"2024-10-18\"]', 1, 539, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(10, 4, 'VIP Pass', 'Voluptatem consectetur nam quo sed est velit.', 20, NULL, '[\"2024-09-09\"]', 1, 664, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(11, 4, 'Speaker Pass', 'Dolorum placeat voluptate excepturi mollitia ad sunt.', 20, NULL, '[\"2024-09-09\"]', 1, 329, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(12, 4, 'Early Bird', 'Sunt minima beatae veritatis.', 20, 12, '[\"2024-09-09\"]', 1, 863, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(13, 5, 'VIP Pass', 'Dignissimos saepe amet non a ipsam.', 20, NULL, '[\"2024-10-12\", \"2024-10-14\"]', 1, 430, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(14, 5, 'Group Package', 'Omnis officia quos maxime rem.', 20, NULL, '[\"2024-10-12\", \"2024-10-13\", \"2024-10-14\", \"2024-10-15\", \"2024-10-16\", \"2024-10-17\"]', 1, 382, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(15, 5, 'Student Ticket', 'Adipisci aut voluptatem facere nihil.', 20, NULL, '[\"2024-10-12\", \"2024-10-14\"]', 1, 812, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(16, 6, 'Sponsor Ticket', 'Ea libero perspiciatis distinctio omnis magni omnis est.', 20, 9, '[\"2024-09-24\", \"2024-09-25\"]', 1, 818, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(17, 6, 'Exhibition Only', 'Delectus perferendis quos ipsum sunt.', 20, 9, '[\"2024-09-24\", \"2024-09-25\"]', 1, 988, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(18, 6, 'Group Package', 'Iusto hic sit saepe ducimus quia illum et enim.', 20, 8, '[\"2024-09-24\", \"2024-09-25\", \"2024-09-26\", \"2024-09-27\"]', 1, 955, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(19, 7, 'Sponsor Ticket', 'Rerum non quaerat magni quia consequatur assumenda quibusdam.', 20, 14, '[\"2024-10-05\", \"2024-10-06\"]', 1, 522, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(20, 7, 'VIP Pass', 'Dolores quidem rerum earum recusandae.', 20, NULL, '[\"2024-10-05\", \"2024-10-06\"]', 1, 350, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(21, 7, 'VIP Pass', 'Tempora ab fugiat est sit.', 20, 11, '[\"2024-10-05\"]', 1, 827, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(22, 8, 'Speaker Pass', 'Quas excepturi velit hic dolorum nesciunt doloremque quaerat.', 20, NULL, '[\"2024-09-18\", \"2024-09-19\", \"2024-09-20\", \"2024-09-21\", \"2024-09-22\"]', 1, 839, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(23, 8, 'Exhibition Only', 'Est voluptatem quos officia.', 20, NULL, '[\"2024-09-18\"]', 1, 475, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(24, 8, 'Standard Admission', 'Magni est error dolorem eius illum voluptas.', 20, 13, '[\"2024-09-18\", \"2024-09-19\", \"2024-09-20\"]', 1, 390, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(25, 9, 'Standard Admission', 'Esse quas dolorum vel.', 20, 8, '[\"2024-10-01\", \"2024-10-02\", \"2024-10-03\", \"2024-10-04\", \"2024-10-05\", \"2024-10-06\"]', 1, 370, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(26, 9, 'Day Pass', 'Tenetur illum enim qui occaecati molestias.', 20, NULL, '[\"2024-10-01\", \"2024-10-02\", \"2024-10-03\", \"2024-10-04\", \"2024-10-05\", \"2024-10-06\"]', 1, 949, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(27, 9, 'Standard Admission', 'Quos natus ut eveniet id.', 20, NULL, '[\"2024-10-01\", \"2024-10-02\", \"2024-10-03\", \"2024-10-04\"]', 1, 623, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(28, 10, 'Group Package', 'Voluptatem quibusdam rerum consequuntur in nostrum reiciendis voluptatum at.', 20, 12, '[\"2024-09-08\", \"2024-09-09\", \"2024-09-10\"]', 1, 652, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(29, 10, 'Student Ticket', 'Et aut cumque sed inventore libero quia sed.', 20, 11, '[\"2024-09-08\", \"2024-09-09\", \"2024-09-10\"]', 1, 338, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(30, 10, 'Standard Admission', 'Ad culpa doloribus ab ex fuga perspiciatis.', 20, NULL, '[\"2024-09-08\", \"2024-09-09\", \"2024-09-10\", \"2024-09-11\", \"2024-09-12\"]', 1, 532, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(31, 11, 'Workshop Access', 'Assumenda ullam quia quam natus soluta id quos non.', 20, NULL, '[\"2024-10-09\", \"2024-10-10\"]', 1, 719, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(32, 11, 'Student Ticket', 'Suscipit magni blanditiis atque dolor a non molestias quia.', 20, NULL, '[\"2024-10-09\", \"2024-10-10\", \"2024-10-11\", \"2024-10-12\"]', 1, 352, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(33, 11, 'Standard Admission', 'Hic optio expedita est debitis.', 20, 9, '[\"2024-10-09\", \"2024-10-10\", \"2024-10-11\", \"2024-10-12\"]', 1, 346, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(34, 12, 'Exhibition Only', 'Cupiditate assumenda accusantium et facere odit consequatur aut.', 20, 8, '[\"2024-10-11\"]', 1, 846, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(35, 12, 'Workshop Access', 'Mollitia aliquid ab animi iusto et vitae fuga.', 20, 9, '[\"2024-10-11\"]', 1, 488, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(36, 12, 'Speaker Pass', 'Autem molestias labore mollitia qui.', 20, 8, '[\"2024-10-11\", \"2024-10-12\"]', 1, 743, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(37, 13, 'Workshop Access', 'Et et repudiandae vero pariatur.', 20, 14, '[\"2024-09-05\", \"2024-09-06\"]', 1, 955, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(38, 13, 'Speaker Pass', 'Et et omnis provident.', 20, 15, '[\"2024-09-05\", \"2024-09-06\"]', 1, 349, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(39, 13, 'Exhibition Only', 'Voluptatum esse quam architecto officia consequuntur dolorem.', 20, 8, '[\"2024-09-05\", \"2024-09-06\"]', 1, 769, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(40, 14, 'Speaker Pass', 'Qui beatae velit quis facere explicabo aspernatur.', 20, NULL, '[\"2024-09-21\", \"2024-09-22\", \"2024-09-23\", \"2024-09-24\", \"2024-09-25\", \"2024-09-26\"]', 1, 337, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(41, 14, 'Student Ticket', 'Amet minus esse quos laudantium impedit aut totam perspiciatis.', 20, 14, '[\"2024-09-21\", \"2024-09-23\"]', 1, 332, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(42, 14, 'Student Ticket', 'Omnis consequatur perferendis ut quas.', 20, NULL, '[\"2024-09-21\", \"2024-09-22\", \"2024-09-23\", \"2024-09-24\", \"2024-09-25\", \"2024-09-26\"]', 1, 564, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(43, 15, 'VIP Pass', 'Pariatur et occaecati sit.', 20, 11, '[\"2024-09-16\"]', 1, 831, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(44, 15, 'Workshop Access', 'Eligendi voluptates ut ut sed qui.', 20, 13, '[\"2024-09-16\"]', 1, 346, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(45, 15, 'Sponsor Ticket', 'Dolor inventore sapiente vitae odit.', 20, NULL, '[\"2024-09-16\"]', 1, 387, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(46, 16, 'Early Bird', 'Impedit sint qui qui ipsam accusamus.', 20, 15, '[\"2024-09-01\", \"2024-09-02\", \"2024-09-03\"]', 1, 882, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(47, 16, 'Student Ticket', 'Laborum voluptatem consectetur facere sint.', 20, NULL, '[\"2024-09-01\", \"2024-09-02\", \"2024-09-03\"]', 1, 853, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(48, 16, 'Group Package', 'Ab sequi magni recusandae amet deserunt.', 20, NULL, '[\"2024-09-01\", \"2024-09-02\", \"2024-09-03\"]', 1, 714, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(49, 17, 'Day Pass', 'Beatae quasi veniam pariatur labore nostrum explicabo voluptates provident.', 20, 13, '[\"2024-09-07\", \"2024-09-08\"]', 1, 536, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(50, 17, 'Exhibition Only', 'Voluptatibus facilis dolorem laudantium omnis ab sit aut.', 20, NULL, '[\"2024-09-07\", \"2024-09-08\"]', 1, 535, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(51, 17, 'Student Ticket', 'Voluptas quidem reiciendis a vitae et nam repellendus.', 20, NULL, '[\"2024-09-07\", \"2024-09-08\"]', 1, 753, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(52, 18, 'VIP Pass', 'Impedit deserunt quibusdam quaerat veritatis est.', 20, 14, '[\"2024-09-27\"]', 1, 993, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(53, 18, 'Standard Admission', 'Placeat quia placeat et veniam.', 20, 8, '[\"2024-09-27\", \"2024-09-28\", \"2024-09-30\"]', 1, 449, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(54, 18, 'Standard Admission', 'Impedit vitae sint et ut illo sint tempora et.', 20, NULL, '[\"2024-09-27\", \"2024-09-28\", \"2024-09-29\", \"2024-09-30\"]', 1, 650, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(55, 19, 'Exhibition Only', 'Dolores quo omnis qui non.', 20, NULL, '[\"2024-08-30\", \"2024-08-31\"]', 1, 658, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(56, 19, 'Early Bird', 'Qui ipsa facilis ipsa qui esse.', 20, NULL, '[\"2024-08-30\", \"2024-08-31\"]', 1, 446, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(57, 19, 'Standard Admission', 'Nostrum qui voluptatem et ipsum dolores sunt.', 20, NULL, '[\"2024-08-30\", \"2024-08-31\"]', 1, 491, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(58, 20, 'Sponsor Ticket', 'Officiis est beatae labore dolores nihil aliquid.', 20, 15, '[\"2024-08-30\"]', 1, 838, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(59, 20, 'Sponsor Ticket', 'Dolore quia enim asperiores ab soluta tempora deserunt.', 20, NULL, '[\"2024-08-30\"]', 1, 731, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL),
(60, 20, 'Student Ticket', 'Dolorem ab quis vero fugiat pariatur sit.', 20, 10, '[\"2024-08-30\", \"2024-08-31\", \"2024-09-01\"]', 1, 805, '2024-07-31 14:25:07', '2024-07-31 14:25:07', 10, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator', '2024-07-31 14:25:28', '2024-07-31 14:25:28'),
(2, 'user', 'Normal User', '2024-07-31 14:25:28', '2024-07-31 14:25:28');

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
(1, 'site.title', 'Site Title', 'Event Ticket', '', 'text', 1, 'Site'),
(2, 'site.description', 'Site Description', 'Join Eventify and take your events to the next level!', '', 'text', 2, 'Site'),
(3, 'site.logo', 'Site Logo', 'settings/July2024/D1iQmUcbmm3fMZXXKWDt.png', '', 'image', 3, 'Site'),
(4, 'site.google_analytics_tracking_id', 'Google Analytics Tracking ID', NULL, '', 'text', 4, 'Site'),
(5, 'admin.bg_image', 'Admin Background Image', 'settings/September2023/Wx2g4pOGWbQH5KHuKOJt.jpg', '', 'image', 5, 'Admin'),
(6, 'admin.title', 'Admin Title', 'Event Tickets', '', 'text', 1, 'Admin'),
(7, 'admin.description', 'Admin Description', 'Join Eventify and take your events to the next level!', '', 'text', 2, 'Admin'),
(8, 'admin.loader', 'Admin Loader', 'settings/September2023/4VG5nar1uT57uaSWWpi9.png', '', 'image', 3, 'Admin'),
(9, 'admin.icon_image', 'Admin Icon Image', 'settings/September2023/XF7K5ZoiyJ6wwSWrQ7VP.png', '', 'image', 4, 'Admin'),
(10, 'admin.google_analytics_client_id', 'Google Analytics Client ID (used for admin dashboard)', NULL, '', 'text', 1, 'Admin'),
(28, 'social.fb_link', 'facebook', 'https://www.facebook.com/', NULL, 'text', 21, 'Social'),
(30, 'social.inst_link', 'instagram', NULL, NULL, 'text', 23, 'Social'),
(31, 'social.twiter_link', 'twiter', NULL, NULL, 'text', 24, 'Social'),
(32, 'site.phone', 'phone', '70223322', NULL, 'text', 25, 'Site'),
(33, 'site.email', 'email', NULL, NULL, 'text', 26, 'Site'),
(35, 'site.logo_dark', 'Logo dark', 'settings/July2024/XTUhqTiV88agOd0Mlk8h.png', NULL, 'image', 27, 'Site'),
(38, 'site.about', 'About', NULL, NULL, 'text_area', 29, 'Site'),
(40, 'social.youtube', 'Youtube', NULL, NULL, 'text', 31, 'Social'),
(41, 'social.pinterest', 'Pinterest', NULL, NULL, 'text', 32, 'Social');

-- --------------------------------------------------------

--
-- Table structure for table `shops`
--

CREATE TABLE `shops` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `short_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `terms` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `company_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_registration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `post_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
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
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_product` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `stripe_price` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `owner` json NOT NULL,
  `event_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `order_id` bigint DEFAULT NULL,
  `user_id` bigint DEFAULT NULL,
  `ticket` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `dates` json NOT NULL,
  `price` bigint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `owner`, `event_id`, `product_id`, `order_id`, `user_id`, `ticket`, `status`, `dates`, `price`, `created_at`, `updated_at`) VALUES
(1, '\"{\\\"first_name\\\":\\\"Zeph\\\",\\\"last_name\\\":\\\"Gordon\\\",\\\"email\\\":\\\"mewamisug@mailinator.com\\\",\\\"phone\\\":\\\"01814792546\\\"}\"', 2, 5, 1, 1, '66aa9dd32a8aa', 1, '[\"2024-10-03\"]', 20, '2024-07-31 14:25:55', '2024-07-31 14:25:55'),
(2, '\"{\\\"first_name\\\":\\\"Zeph\\\",\\\"last_name\\\":\\\"Gordon\\\",\\\"email\\\":\\\"mewamisug@mailinator.com\\\",\\\"phone\\\":\\\"01814792546\\\"}\"', 2, 5, 1, 1, '66aa9dd32b2a0', 1, '[\"2024-10-03\"]', 20, '2024-07-31 14:25:55', '2024-07-31 14:25:55'),
(3, '\"{\\\"first_name\\\":\\\"Zeph\\\",\\\"last_name\\\":\\\"Gordon\\\",\\\"email\\\":\\\"mewamisug@mailinator.com\\\",\\\"phone\\\":\\\"01814792546\\\"}\"', 2, 5, 1, 1, '66aa9dd32bd39', 1, '[\"2024-10-03\"]', 20, '2024-07-31 14:25:55', '2024-07-31 14:25:55'),
(4, '\"{\\\"first_name\\\":\\\"Alfreda\\\",\\\"last_name\\\":\\\"Huber\\\",\\\"email\\\":\\\"rowytymip@mailinator.com\\\",\\\"phone\\\":\\\"01370019391\\\"}\"', 5, 14, 2, 1, '66aa9e36372d5', 1, '[\"2024-10-12\", \"2024-10-13\", \"2024-10-14\", \"2024-10-15\", \"2024-10-16\", \"2024-10-17\"]', 20, '2024-07-31 14:27:34', '2024-07-31 14:27:34'),
(5, '\"{\\\"first_name\\\":\\\"Alfreda\\\",\\\"last_name\\\":\\\"Huber\\\",\\\"email\\\":\\\"rowytymip@mailinator.com\\\",\\\"phone\\\":\\\"01370019391\\\"}\"', 5, 14, 2, 1, '66aa9e3637e89', 1, '[\"2024-10-12\", \"2024-10-13\", \"2024-10-14\", \"2024-10-15\", \"2024-10-16\", \"2024-10-17\"]', 20, '2024-07-31 14:27:34', '2024-07-31 14:27:34'),
(6, '\"{\\\"first_name\\\":\\\"Alfreda\\\",\\\"last_name\\\":\\\"Huber\\\",\\\"email\\\":\\\"rowytymip@mailinator.com\\\",\\\"phone\\\":\\\"01370019391\\\"}\"', 5, 14, 2, 1, '66aa9e3638412', 1, '[\"2024-10-12\", \"2024-10-13\", \"2024-10-14\", \"2024-10-15\", \"2024-10-16\", \"2024-10-17\"]', 20, '2024-07-31 14:27:34', '2024-07-31 14:27:34'),
(7, '\"{\\\"first_name\\\":\\\"Alfreda\\\",\\\"last_name\\\":\\\"Huber\\\",\\\"email\\\":\\\"rowytymip@mailinator.com\\\",\\\"phone\\\":\\\"01370019391\\\"}\"', 5, 14, 2, 1, '66aa9e3638c95', 1, '[\"2024-10-12\", \"2024-10-13\", \"2024-10-14\", \"2024-10-15\", \"2024-10-16\", \"2024-10-17\"]', 20, '2024-07-31 14:27:34', '2024-07-31 14:27:34'),
(8, '\"{\\\"first_name\\\":\\\"Alfreda\\\",\\\"last_name\\\":\\\"Huber\\\",\\\"email\\\":\\\"rowytymip@mailinator.com\\\",\\\"phone\\\":\\\"01370019391\\\"}\"', 5, 14, 2, 1, '66aa9e3639433', 1, '[\"2024-10-12\", \"2024-10-13\", \"2024-10-14\", \"2024-10-15\", \"2024-10-16\", \"2024-10-17\"]', 20, '2024-07-31 14:27:34', '2024-07-31 14:27:34'),
(9, '\"{\\\"first_name\\\":\\\"Aphrodite\\\",\\\"last_name\\\":\\\"Miranda\\\",\\\"email\\\":\\\"rozaqu@mailinator.com\\\",\\\"phone\\\":\\\"01926521999\\\",\\\"taxid\\\":\\\"Nisi animi est volu\\\"}\"', 2, 5, 4, 2, '66ab08d4a83da', 1, '[\"2024-10-03\"]', 20, '2024-07-31 22:02:28', '2024-07-31 22:02:28'),
(10, '\"{\\\"first_name\\\":\\\"Aphrodite\\\",\\\"last_name\\\":\\\"Miranda\\\",\\\"email\\\":\\\"rozaqu@mailinator.com\\\",\\\"phone\\\":\\\"01926521999\\\",\\\"taxid\\\":\\\"Nisi animi est volu\\\"}\"', 2, 5, 4, 2, '66ab08d4a8ca6', 1, '[\"2024-10-03\"]', 20, '2024-07-31 22:02:28', '2024-07-31 22:02:28'),
(11, '\"{\\\"first_name\\\":\\\"Brianna\\\",\\\"last_name\\\":\\\"James\\\",\\\"email\\\":\\\"myhune@mailinator.com\\\",\\\"phone\\\":\\\"01289743788\\\",\\\"taxid\\\":\\\"Eligendi dicta sit s\\\"}\"', 14, 40, 5, 2, '66ab099f4e43a', 1, '[\"2024-09-21\", \"2024-09-22\", \"2024-09-23\", \"2024-09-24\", \"2024-09-25\", \"2024-09-26\"]', 20, '2024-07-31 22:05:51', '2024-07-31 22:05:51'),
(12, '\"{\\\"first_name\\\":\\\"Brianna\\\",\\\"last_name\\\":\\\"James\\\",\\\"email\\\":\\\"myhune@mailinator.com\\\",\\\"phone\\\":\\\"01289743788\\\",\\\"taxid\\\":\\\"Eligendi dicta sit s\\\"}\"', 14, 40, 5, 2, '66ab099f4ed3d', 1, '[\"2024-09-21\", \"2024-09-22\", \"2024-09-23\", \"2024-09-24\", \"2024-09-25\", \"2024-09-26\"]', 20, '2024-07-31 22:05:51', '2024-07-31 22:05:51'),
(13, '\"{\\\"first_name\\\":\\\"Brianna\\\",\\\"last_name\\\":\\\"James\\\",\\\"email\\\":\\\"myhune@mailinator.com\\\",\\\"phone\\\":\\\"01289743788\\\",\\\"taxid\\\":\\\"Eligendi dicta sit s\\\"}\"', 14, 40, 5, 2, '66ab099f4f3e0', 1, '[\"2024-09-21\", \"2024-09-22\", \"2024-09-23\", \"2024-09-24\", \"2024-09-25\", \"2024-09-26\"]', 20, '2024-07-31 22:05:51', '2024-07-31 22:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE `translations` (
  `id` int UNSIGNED NOT NULL,
  `table_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `column_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `foreign_key` int UNSIGNED NOT NULL,
  `locale` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `l_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'users/default.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `settings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pm_last_four` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `contact_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `l_name`, `email`, `avatar`, `email_verified_at`, `password`, `remember_token`, `settings`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`, `contact_number`) VALUES
(1, 2, 'Tyler York', 'Allen Waller', 'satekyhely@mailinator.com', 'users/default.png', NULL, '$2y$10$jrlFK3weUO8A11YnNXOlFuAeVOdZQmfbonjQEdDChYozUa1OjkgeC', NULL, NULL, '2024-07-31 14:25:35', '2024-07-31 14:25:35', NULL, NULL, NULL, NULL, '787'),
(2, 2, 'Alice Mcgee', 'Sacha Ray', 'vifyj@mailinator.com', 'users/default.png', NULL, '$2y$10$0YJ9umVCBYg2ibNF6n7Lz.4PX96SM/G23B98NbHE8T5xcwn5iawjm', NULL, NULL, '2024-07-31 21:55:55', '2024-07-31 21:55:55', NULL, NULL, NULL, NULL, '123124124'),
(3, 1, 'Sayed Khan', 'khan', 'reovilsayed@gmail.com', 'users/default.png', NULL, '$2y$10$JuE3u3c6I6jjVPmwF11fTuIQq8JAFhDzk/e73zY5igxyPccDi5pr2', NULL, NULL, '2024-07-31 22:27:49', '2024-07-31 22:27:49', NULL, NULL, NULL, NULL, '01738324024');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_product`
--
ALTER TABLE `order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_product_product_id_foreign` (`product_id`),
  ADD KEY `order_product_order_id_foreign` (`order_id`);

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
  ADD KEY `products_event_id_foreign` (`event_id`);

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
  ADD KEY `tickets_event_id_foreign` (`event_id`),
  ADD KEY `tickets_product_id_foreign` (`product_id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_rows`
--
ALTER TABLE `data_rows`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `data_types`
--
ALTER TABLE `data_types`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `emails`
--
ALTER TABLE `emails`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `metas`
--
ALTER TABLE `metas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `prodcats`
--
ALTER TABLE `prodcats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `prodcat_product`
--
ALTER TABLE `prodcat_product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `shops`
--
ALTER TABLE `shops`
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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `translations`
--
ALTER TABLE `translations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_shop_id_foreign` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shops`
--
ALTER TABLE `shops`
  ADD CONSTRAINT `shops_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_event_id_foreign` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tickets_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
