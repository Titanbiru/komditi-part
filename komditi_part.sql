-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2026 at 04:27 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `komditi_part`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Rumah',
  `recipient_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `type`, `recipient_name`, `phone`, `address`, `city`, `province`, `postal_code`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 3, 'Rumah', 'ehe1Titanium', '085179572070', 'no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan', 'JAKARTA', 'Jakarta Selatan', '12640', 1, '2026-04-04 14:43:48', '2026-04-04 14:43:48'),
(2, 3, 'Kantor', 'ehe1Titanium', '085179572070', 'no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan\r\n\r\npagar hitam', 'JAKARTA', 'Jakarta Selatan', '12640', 0, '2026-04-04 14:46:01', '2026-04-04 15:02:15'),
(3, 4, 'Rumah', 'nasution', '085179572070', 'no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan', 'JAKARTA', 'Jakarta Selatan', '12640', 1, '2026-04-07 04:17:29', '2026-04-07 04:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 3, '2026-04-02 01:46:43', '2026-04-02 01:46:43'),
(2, 4, '2026-04-07 04:23:14', '2026-04-07 04:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `icon`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Laptop', 'laptop', NULL, NULL, '2026-03-26 11:35:01', '2026-03-26 11:35:01'),
(2, 'Ram', 'ram', 'uploads/categories/1775053728_ram.png', NULL, '2026-03-27 02:55:27', '2026-04-01 14:28:48'),
(3, 'SSD M.2', 'ssd-m2', 'uploads/categories/1775053167_ssd.png', NULL, '2026-04-01 13:54:31', '2026-04-01 14:19:27'),
(4, 'GPU', 'gpu', 'uploads/categories/1775053772_gpu-mining.png', NULL, '2026-04-01 14:29:32', '2026-04-01 14:29:32'),
(5, 'Drink', 'drink', NULL, NULL, '2026-04-09 02:22:55', '2026-04-09 02:22:55');

-- --------------------------------------------------------

--
-- Table structure for table `category_product`
--

CREATE TABLE `category_product` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `category_product`
--

INSERT INTO `category_product` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(3, 3, 2, NULL, NULL),
(5, 4, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(4, 3, 3, NULL, NULL),
(5, 4, 4, NULL, NULL),
(7, 4, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2026_02_11_143720_create_users_table', 1),
(2, '2026_02_11_150729_create_categories_table', 1),
(3, '2026_02_11_151054_create_products_table', 1),
(4, '2026_02_11_151745_create_addresses_table', 1),
(5, '2026_02_11_152035_create_carts_table', 1),
(6, '2026_02_11_152100_create_cart_items_table', 1),
(7, '2026_02_11_152201_create_orders_table', 1),
(8, '2026_02_11_153212_create_order_items_table', 1),
(9, '2026_02_11_153956_create_payments_table', 1),
(10, '2026_02_11_155338_create_sessions_table', 1),
(11, '2026_02_19_154952_create_stock_histories_table', 1),
(12, '2026_03_19_100317_create_favorites_table', 1),
(13, '2026_03_25_172735_add_status_to_users_table', 1),
(14, '2026_03_26_154337_create_category_product_table', 1),
(15, '2026_03_26_181511_create_product_images_table', 1),
(16, '2026_03_27_094233_add_discount_to_products_table', 2),
(17, '2026_04_01_195623_add_icon_to_categories_table', 3),
(18, '2026_04_02_084739_add_price_to_cart_items_table', 4),
(19, '2026_04_03_210013_update_orders_table_fields', 5),
(20, '2026_04_04_215410_add_type_to_addresses_table', 6),
(21, '2026_04_05_171124_create_settings_table', 7),
(22, '2026_04_05_205822_create_cache_table', 8),
(23, '2026_04_06_005928_add_resi_number_to_orders_table', 9),
(24, '2026_04_06_111459_add_receipt_image_to_orders_table', 10),
(25, '2026_04_06_133601_add_receipt_image_to_orders_table', 11),
(26, '2026_04_07_084933_add_google_id_to_users_table', 12),
(27, '2026_04_08_082531_create_password_reset_tokens_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `shipping_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `shipping_cost` decimal(12,2) NOT NULL,
  `admin_fee` decimal(15,2) NOT NULL DEFAULT '2500.00',
  `unique_code` int NOT NULL,
  `grand_total` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `shipment_status` enum('pending','processing','shipped','delivered','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `receipt_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `resi_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` enum('unpaid','paid','refunded') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `shipping_snapshot` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shipping_name`, `shipping_phone`, `shipping_address`, `order_number`, `total_price`, `shipping_cost`, `admin_fee`, `unique_code`, `grand_total`, `payment_method`, `payment_proof`, `notes`, `shipment_status`, `receipt_image`, `delivered_at`, `resi_number`, `payment_status`, `shipping_snapshot`, `created_at`, `updated_at`) VALUES
(13, 3, 'niggha', '085179572070', 'ehe1Titanium | no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan, JAKARTA', 'ORD-KMDT-5CZQIIHARN', 10375000.00, 25000.00, 2500.00, 266, 10402766.00, 'qris', 'payment_proofs/746E25i6xhHgccvzCXwjTPkf4NC963tN4CsHco0K.jpg', 'test', 'delivered', NULL, NULL, 'JP1234567890', 'paid', '{\"cost\": \"25000\", \"courier\": \"J&T Express\"}', '2026-04-05 17:04:28', '2026-04-06 04:23:02'),
(14, 3, 'niggha', '085179572070', 'ehe1Titanium | no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan\r\n\r\npagar hitam, JAKARTA', 'ORD-KMDT-AKJUYVEGTM', 6175000.00, 64000.00, 2500.00, 637, 6242137.00, 'qris', 'payment_proofs/thNFkbEDtZq7rqqpm1v1YwZzCOCH4V8ehH966SoP.jpg', 'disana', 'delivered', 'receipts/WKBRpM1L8IwcCVQxcFVW6F7tcgY1rtOBMLUJqQJ1.jpg', '2026-04-06 06:37:12', 'JP3298881773', 'paid', '{\"cost\": \"64000\", \"courier\": \"J&T Express\"}', '2026-04-06 05:01:24', '2026-04-06 06:37:12'),
(15, 4, 'Tristan Prayogo', '09328791237', 'nasution | no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan, JAKARTA', 'ORD-KMDT-ZWK7JKEETE', 6175000.00, 25000.00, 2500.00, 783, 6203283.00, 'qris', 'payment_proofs/aEupQHMVxeKgLQoyPAxcqPUFTO14JnZsaQSxOwHW.jpg', 'pagar warna putih', 'processing', NULL, NULL, NULL, 'paid', '{\"cost\": \"25000\", \"courier\": \"J&T Express\"}', '2026-04-07 04:28:03', '2026-04-07 15:15:15'),
(16, 4, 'Tristan Prayogo', '09384299', 'nasution | no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan, JAKARTA', 'ORD-KMDT-31U7FQEGMF', 10375000.00, 64000.00, 2500.00, 581, 10442081.00, 'qris', 'payment_proofs/dnHBtsE0OaMAQXag9Pdd8ZMH02sgSqePRuJ7BX5Z.jpg', 'red', 'cancelled', NULL, NULL, NULL, 'paid', '{\"cost\": \"64000\", \"courier\": \"J&T Express\"}', '2026-04-07 15:20:15', '2026-04-07 15:23:41'),
(17, 4, 'Tristan Prayogo', '9786655676', 'nasution | no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan, JAKARTA', 'ORD-KMDT-CO8P2R060H', 5752500.00, 50000.00, 2500.00, 931, 5805931.00, 'qris', 'payment_proofs/woywKQPs4YZefSAqy0b3RUTkhgGjEtZvEi4ZaIp8.jpg', 'nanu', 'cancelled', NULL, NULL, NULL, 'unpaid', '{\"cost\": \"50000\", \"courier\": \"J&T Express\"}', '2026-04-07 15:27:25', '2026-04-07 15:41:05'),
(18, 4, 'Tristan Prayogo', '9786655676', 'nasution | no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan, JAKARTA', 'ORD-KMDT-5IWBD1C5TF', 3835000.00, 18000.00, 2500.00, 272, 3855772.00, 'qris', 'payment_proofs/hEUyiHQn7gvNfsxs821UjjalRJ1o3YZbHNqzhXAx.jpg', NULL, 'delivered', 'receipts/vlgmWCTUOYgSFPJV1x5Yels0BwVXmSgx3xYHRxKt.png', '2026-04-08 16:26:04', 'JP1234567890', 'paid', '{\"cost\": \"18000\", \"courier\": \"J&T Express\"}', '2026-04-08 16:20:17', '2026-04-08 16:26:04'),
(19, 4, 'Tristan Prayogo', '09384299', 'nasution | no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan, JAKARTA', 'ORD-KMDT-FHVZLZEHVH', 3835000.00, 18000.00, 2500.00, 883, 3856383.00, 'qris', 'payment_proofs/d7QXZDiJA0UekQMmBeqSIAmWhpjYgYRdpgUJoX9w.jpg', NULL, 'delivered', NULL, '2026-04-08 17:13:55', 'JP1234567890', 'paid', '{\"cost\": \"18000\", \"courier\": \"J&T Express\"}', '2026-04-08 17:09:12', '2026-04-08 17:13:55'),
(20, 4, 'Tristan Prayogo', '9786655676', 'nasution | no 101 Rt.009, Rw.02, Srengseng Sawah, Jagakarsa, Jakarta Selatan, JAKARTA', 'ORD-KMDT-XBF24KVTFX', 8092500.00, 50000.00, 2500.00, 470, 8145470.00, 'qris', 'payment_proofs/IEIVnGOYgHwapYfiZ9nWcUPn7dvvXIPRwIvNAFeQ.jpg', NULL, 'pending', NULL, NULL, NULL, 'unpaid', '{\"cost\": \"50000\", \"courier\": \"J&T Express\"}', '2026-04-09 02:16:19', '2026-04-09 02:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `product_name_snapshot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price_snapshot` decimal(12,2) NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name_snapshot`, `product_price_snapshot`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 13, 1, 'ASUS VIVOBOOK 14 M1407KA RYZEN AI 5 330 RAM 16GB 512GB W11+OHS 14.0 WUXGA 1', 10375000.00, 1, 10375000.00, '2026-04-05 17:04:29', '2026-04-05 17:04:29'),
(2, 14, 4, 'VGA MSI GeForce RTX 4060 Ventus 2X Black OC 8GB - 8 GB DDR6', 6175000.00, 1, 6175000.00, '2026-04-06 05:01:24', '2026-04-06 05:01:24'),
(3, 15, 4, 'VGA MSI GeForce RTX 4060 Ventus 2X Black OC 8GB - 8 GB DDR6', 6175000.00, 1, 6175000.00, '2026-04-07 04:28:03', '2026-04-07 04:28:03'),
(4, 16, 1, 'ASUS VIVOBOOK 14 M1407KA RYZEN AI 5 330 RAM 16GB 512GB W11+OHS 14.0 WUXGA 1', 10375000.00, 1, 10375000.00, '2026-04-07 15:20:15', '2026-04-07 15:20:15'),
(5, 17, 3, 'ADATA RAM SODIMM DDR5 8GB 5600MHZ', 1917500.00, 3, 5752500.00, '2026-04-07 15:27:26', '2026-04-07 15:27:26'),
(6, 18, 3, 'ADATA RAM SODIMM DDR5 8GB 5600MHZ', 1917500.00, 2, 3835000.00, '2026-04-08 16:20:18', '2026-04-08 16:20:18'),
(7, 19, 3, 'ADATA RAM SODIMM DDR5 8GB 5600MHZ', 1917500.00, 2, 3835000.00, '2026-04-08 17:09:13', '2026-04-08 17:09:13'),
(8, 20, 3, 'ADATA RAM SODIMM DDR5 8GB 5600MHZ', 1917500.00, 1, 1917500.00, '2026-04-09 02:16:19', '2026-04-09 02:16:19'),
(9, 20, 4, 'VGA MSI GeForce RTX 4060 Ventus 2X Black OC 8GB - 8 GB DDR6', 6175000.00, 1, 6175000.00, '2026-04-09 02:16:19', '2026-04-09 02:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `payment_method` enum('qris','bank_transfer') COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gross_amount` decimal(12,2) NOT NULL,
  `payment_status` enum('pending','paid','failed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `discount` int NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `stock` int NOT NULL DEFAULT '0',
  `is_promo` tinyint(1) NOT NULL DEFAULT '0',
  `sold` int NOT NULL DEFAULT '0',
  `weight` decimal(8,2) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `sku`, `price`, `discount`, `description`, `stock`, `is_promo`, `sold`, `weight`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'ASUS VIVOBOOK 14 M1407KA RYZEN AI 5 330 RAM 16GB 512GB W11+OHS 14.0 WUXGA 1', 'asus-vivobook-14-m1407ka-ryzen-ai-5-330-ram-16gb-512gb-w11ohs-140-wuxga-1', 'ASUS-M1407KA', 12500000.00, 17, 'M1407KA-VIPS5151M : Quiet Blue\r\nM1407KA-VIPS5153M : Cool Silver\r\n**REQ WARNA WAJIB NOTE SAAT CO ATAU CHAT AMDIN**\r\n***TIDAK ADA REQ MAKA DIKIRIM WARNA RANDOM***\r\n\r\nASUS VIVOBOOK 14 M1407KA RYZEN AI 5 330 16GB 512GB W11+OHS 14.0 WUXGA\r\n\r\nSPESIFIKASI:\r\nProcessor : AMD Ryzen AI 5 340 Processor 2.0GHz ( 22MB Cache, up to 4.8GHz, 6 cores, 12 Threads) AMD XDNA NPU up to 50TOPS\r\nDisplay : 14.0-inch, WUXGA (1920 x 1200) 16:10 aspect ratio, LED Backlit, IPS-level Panel, 60Hz refresh rate, 300 nita, anti-glare display, Screen-to-body ratio 87%\r\nWeight: 1.46 kg (3.22 lbs)\r\nMemory : 16GB DDR5 on board\r\nStorage : 512GB M.2 NVMe PCIe 4.0 SSD\r\nGraphics : AMD Radeon Graphics\r\nKeyboard : Backlit Chiclet Keyboard With Copilot key\r\nWireless : Wi-Fi 6(802.11ax) (Dual band) 2*2 + Bluetooth 5.3\r\n\r\nPorts : \r\n2x USB 3.2 Gen 1 Type-A (data speed up to 5Gbps)\r\n2x USB 3.2 Gen 1 Type-C with support for display / power delivery (data speed up to 5Gbps)\r\n1x HDMI 1.4\r\n1x 3.5mm Combo Audio Jack”\r\n\r\nAudio : SonicMaster, Built-in speaker, Built-in array microphone\r\nWebcam : 1080p FHD camera With privacy shutter\r\nBattery : 42WHrs, 3S1P, 3-cell Li-ion, TYPE-C, 65W AC Adapter\r\nOS : Windows 11 Home + Microsoft Office Home 2024 + Microsoft 365 Basic\r\n\r\nGARANSI RESMI ASUS 2 TAHUN', 4, 0, 0, NULL, NULL, 'active', '2026-03-26 11:55:40', '2026-04-07 15:20:15'),
(3, NULL, 'ADATA RAM SODIMM DDR5 8GB 5600MHZ', 'adata-ram-sodimm-ddr5-8gb-5600mhz', 'AD5S56008G-S', 2950000.00, 35, 'ADATA RAM SODIMM DDR5 8GB 5600MHz\r\n\r\nADATA DDR5 SODIMM Memory\r\n\r\nADATA DDR5 SODIMM memory is designed for laptops and compact systems that require higher bandwidth and improved efficiency. With a capacity of 8GB, speed up to 5600MHz, and support for the latest Intel platforms, this memory delivers fast and stable performance for multitasking and daily computing.\r\n\r\nFeatures :\r\nMemory Type: DDR5.\r\nForm Factor: SO-DIMM.\r\nCapacity: 8GB.\r\nSpeed: 5600MHz.\r\nDesigned for laptop and small form factor systems.\r\nHigh efficiency and improved power management.\r\n\r\nSpecifications :\r\nCapacity: 8GB.\r\nMemory Type: DDR5.\r\nForm Factor: SO-DIMM.\r\nSpeed: 5600MHz.\r\nOperating Voltage: 1.1V.\r\nWarranty: Limited Lifetime Warranty.', 33, 1, 0, 2.20, NULL, 'active', '2026-03-27 06:03:15', '2026-04-09 02:16:19'),
(4, NULL, 'VGA MSI GeForce RTX 4060 Ventus 2X Black OC 8GB - 8 GB DDR6', 'vga-msi-geforce-rtx-4060-ventus-2x-black-oc-8gb-8-gb-ddr6', 'GPU-MSI-RTX4060-VENTUS-2X-BLK-8G-OC', 6500000.00, 5, 'BEYOND FAST \r\nGeForce RTX™ 40 Series\r\n\r\nMODEL NAME : GeForce RTX™ 4060 VENTUS 2X BLACK 8G OC\r\nGRAPHICS PROCESSING UNIT : NVIDIA® GeForce RTX™ 4060\r\nINTERFACE : PCI Express® Gen 4 x 8\r\n\r\nCORE CLOCKS :\r\nExtreme Performance: 2505 MHz (MSI Center)\r\nBoost: 2490 MHz\r\nCUDA® CORES : 3072 Units\r\nMEMORY SPEED : 17 Gbps\r\nMEMORY : 8GB GDDR6\r\nMEMORY BUS : 128-bit\r\n\r\nOUTPUT :\r\nDisplayPort x 3 (v1.4a)\r\nHDMI™ x 1 (Supports 4K@120Hz HDR and 8K@60Hz HDR and Variable Refresh Rate (VRR) as specified in HDMI™ 2.1a)\r\nHDCP SUPPORT : Y\r\n\r\nPOWER CONSUMPTION : 115 W\r\nPOWER CONNECTORS : 8-pin x 1\r\nRECOMMENDED PSU : 550 W\r\n\r\nCARD DIMENSION (MM) : 199 x 120 x 41 mm\r\nWEIGHT (CARD / PACKAGE) : 546 g / 783 g\r\n\r\nDIRECTX VERSION SUPPORT : 12 Ultimate\r\nOPENGL VERSION SUPPORT : 4.6\r\nMAXIMUM DISPLAYS : 4\r\nG-SYNC® TECHNOLOGY : Y\r\nDIGITAL MAXIMUM RESOLUTION : 7680 x 4320', 13, 0, 0, 3.50, NULL, 'active', '2026-04-01 15:09:43', '2026-04-09 02:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 1, 'products/ku24rXVtVnEn2ypZF68Ku21VLAkcMxJtVLTl7XlP.webp', '2026-03-27 01:06:11', '2026-03-27 01:06:11'),
(2, 1, 'products/HyoyxKBgl94DeRFduTiRCSbEvzw7SEslK45zkGqm.webp', '2026-03-27 02:38:51', '2026-03-27 02:38:51'),
(4, 3, 'products/ZZC9n69OsOrYxydyU91ISRdt66gOGvSX5n9BNDCz.webp', '2026-03-27 06:03:17', '2026-03-27 06:03:17'),
(5, 3, 'products/wTPNuLZkXbVzhrameA5IzRqfgApfnZGywv79ihKZ.webp', '2026-03-27 06:03:17', '2026-03-27 06:03:17'),
(7, 3, 'products/SwlzRzYOu6vn87R3bV9lN51LvEVuPqJYbqZR4lDh.webp', '2026-03-27 06:38:37', '2026-03-27 06:38:37'),
(8, 4, 'products/VHI1nRmtfJ6Ly5xKwri7Qxu8NBR2VjnNFPA0ednK.webp', '2026-04-01 15:09:45', '2026-04-01 15:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7MPl9AA9eeindgydetu1TAUxCQfXAMJsDLbHuWK6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2loYUNJTjY3R0ZTQVlQYUpUSWlrUWd5Qllqa2FqVk5rV3hMZEpMQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1775701445),
('B8jmCMcVtEE1xVJ4fB65fBviyCzPfoNQv0GLs2Mw', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRVFDd1lBUU1mOU1SaVl4NzYyWlRiVHZVVUNWcGFkR3NBNW83aElFTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1775695387),
('pMksSK1Q8b2CX78FWgAD94X8LgCvKenOCRqBjdDX', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUWJtOW03a25Ga2N5a3lIOUNENGFrc1hieWZHME5sNExERXdBRXBrSiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjIxOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAiO3M6NToicm91dGUiO3M6MTI6InB1YmxpYy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjQ7fQ==', 1775701419);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'hero_image', 'settings/DsaMsgas4fWqtBgmgFVC6eLiS13yTgQGlrXt95BL.png', '2026-04-05 13:56:23', '2026-04-05 14:47:57'),
(2, 'bank_name', 'JAGO', '2026-04-05 13:56:23', '2026-04-05 14:47:55'),
(3, 'bank_account', '1048818366745', '2026-04-05 13:56:23', '2026-04-05 14:47:56'),
(4, 'bank_holder', 'PT KOMDITI PART', '2026-04-05 13:56:23', '2026-04-05 13:56:23'),
(5, 'qris_image', 'settings/DBbWPUFfoOcPqOOqNq5WSyiYJLFQmKhSXk0p5OeI.jpg', '2026-04-05 13:56:23', '2026-04-05 14:47:58'),
(6, 'shop_address', 'Ruko Mangga Dua Square, Jl. Gn. Sahari No.1 Blok A, No. 8, Ancol, Kec. Pademangan, Jkt Utara, Daerah Khusus Ibukota Jakarta 14420', '2026-04-05 13:56:23', '2026-04-05 14:47:56'),
(7, 'admin_fee', '2500', '2026-04-05 13:56:23', '2026-04-05 13:56:23'),
(8, 'hero_side_1', 'settings/8cKGWQjftVlHoDXWjTYCuETp1hdR9xeCPBTwvssQ.png', '2026-04-05 14:47:57', '2026-04-05 14:47:57'),
(9, 'hero_side_2', 'settings/YJxd7cjoNODPkaBdbALCpKY4pH788OlE3AAJ6mL9.png', '2026-04-06 01:38:38', '2026-04-06 01:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `stock_histories`
--

CREATE TABLE `stock_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `users_id` bigint UNSIGNED NOT NULL,
  `amount` int NOT NULL,
  `type` enum('in','out') COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `stock_before` int NOT NULL,
  `stock_after` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_histories`
--

INSERT INTO `stock_histories` (`id`, `product_id`, `users_id`, `amount`, `type`, `note`, `stock_before`, `stock_after`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 16, 'in', 'test warning', 25, 41, '2026-03-28 07:08:44', '2026-03-28 07:08:44'),
(2, 1, 2, 6, 'out', 'test warning', 15, 9, '2026-03-28 07:09:38', '2026-03-28 07:09:38'),
(3, 1, 2, 2, 'in', 'restock', 9, 11, '2026-04-03 14:24:13', '2026-04-03 14:24:13'),
(4, 1, 2, 3, 'in', 'restock', 11, 14, '2026-04-03 14:24:49', '2026-04-03 14:24:49'),
(5, 1, 2, 8, 'out', NULL, 13, 5, '2026-04-07 14:11:28', '2026-04-07 14:11:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','staff','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `google_id`, `name`, `email`, `password`, `phone`, `role`, `is_active`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Main Admin', 'admin@gmail.com', '$2y$12$RpxTV.mmwjB04xdIUcSX..lKzOQ8iSCXMhncxvwguX68pWJlhaeCu', NULL, 'admin', 1, NULL, NULL, '2026-04-05 13:56:22', '2026-04-06 03:43:42'),
(2, NULL, 'faiz', 'faizxepher27@gmail.com', '$2y$12$EhXcL7jNBEs8.h3DOcM6dORbRYiHPcKF33gmnrFH4RQpuxw0N1x8O', '085179572070', 'staff', 1, NULL, NULL, '2026-03-27 06:42:08', '2026-03-27 06:42:08'),
(3, NULL, 'niggha', 'nigha@gmail.com', '$2y$12$pRJvaKOjqdUMnWHFR94y7uWfX..PD3blSSNqUUXjvYVo/teRdSY7O', '085179572070', 'user', 1, NULL, NULL, '2026-03-31 06:37:05', '2026-04-04 14:35:29'),
(4, '106761315104298648160', 'Tristan Prayogo', 'tristan.pra07@gmail.com', '$2y$12$b7fRGhj4eqMFKjw.OwJ4/e2a0Or9FH4xwIa1O1mSLERXdySfEdOUO', NULL, 'user', 1, NULL, NULL, '2026-04-07 02:50:49', '2026-04-09 02:08:15');

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
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `category_product`
--
ALTER TABLE `category_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_product_product_id_foreign` (`product_id`),
  ADD KEY `category_product_category_id_foreign` (`category_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `stock_histories`
--
ALTER TABLE `stock_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stock_histories_product_id_foreign` (`product_id`),
  ADD KEY `stock_histories_users_id_foreign` (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category_product`
--
ALTER TABLE `category_product`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `stock_histories`
--
ALTER TABLE `stock_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `category_product`
--
ALTER TABLE `category_product`
  ADD CONSTRAINT `category_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `category_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_histories`
--
ALTER TABLE `stock_histories`
  ADD CONSTRAINT `stock_histories_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stock_histories_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
