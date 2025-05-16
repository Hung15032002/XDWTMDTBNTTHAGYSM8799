-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 16, 2025 lúc 02:17 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `doantotnghiep`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bank_transactions`
--

CREATE TABLE `bank_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `logo`, `status`, `created_at`, `updated_at`) VALUES
(2, 'xưởng gỗ ánh phương 1234', 'xuong-go-anh-phuong-123', NULL, '1', '2025-04-19 00:03:48', '2025-05-08 23:08:41'),
(9, 'long chau', 'long-chau', NULL, '1', '2025-04-21 03:01:25', '2025-05-08 23:00:06'),
(10, 'hoa phat', 'hoa-phat', NULL, '1', '2025-04-21 03:01:36', '2025-05-08 21:04:20'),
(11, 'tại sao slug không cập nhật', 'tai-sao-slug-khong-cap-nhat', NULL, '1', '2025-05-08 23:02:35', '2025-05-08 23:02:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`) VALUES
(59, 'bàn trà', 'ban-tra', '59.jpg', 1, '2025-04-17 20:27:15', '2025-04-17 20:27:15'),
(60, 'bàn trang điểm', 'ban-trang-diem', '60.jpg', 1, '2025-04-17 20:27:38', '2025-04-17 20:27:38'),
(61, 'bàn ghế ăn', 'ban-ghe-an', '61.jpg', 1, '2025-04-17 20:27:57', '2025-04-26 06:19:28'),
(62, 'giường', 'giuong', '62.jpg', 1, '2025-04-17 20:28:27', '2025-04-17 20:28:27'),
(63, 'kệ sách', 'ke-sach', '63.jpg', 1, '2025-04-17 20:28:39', '2025-04-17 20:28:39'),
(64, 'kệ tivi', 'ke-tivi', '64.jpg', 1, '2025-04-17 20:28:52', '2025-04-27 04:06:03'),
(65, 'nệm ngủ', 'nem-ngu', '65.jpg', 1, '2025-04-17 20:29:04', '2025-04-17 20:29:04'),
(66, 'sofa', 'sofa', '66.jpg', 1, '2025-04-17 20:29:18', '2025-04-17 20:29:18'),
(67, 'tủ bếp', 'tu-bep', '67.jpg', 1, '2025-04-17 20:29:34', '2025-04-17 20:29:34'),
(68, 'tủ giày dép', 'tu-giay-dep', '68.jpg', 1, '2025-04-17 20:29:48', '2025-04-17 20:29:48'),
(69, 'tủ quần áo', 'tu-quan-ao', '69.jpg', 1, '2025-04-17 20:30:04', '2025-04-17 20:30:04'),
(71, 'Bồn Tắm', 'bon-tam', '71.jpg', 1, '2025-04-26 05:13:48', '2025-04-27 04:05:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
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
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_03_31_230521_alter_users_table', 2),
(5, '2025_04_05_071744_create_categories_table', 3),
(6, '2025_04_08_002355_create_temp_images_table', 4),
(7, '2025_04_18_031257_create_sub_categories_table', 5),
(8, '2025_04_18_041741_create_subcategories_table', 6),
(9, '2025_04_19_064929_create_brands_table', 7),
(10, '2025_04_21_032009_create_products_table', 8),
(11, '2025_04_21_054141_add_subcategory_and_brand_to_products_table', 9),
(12, '2025_04_21_103813_add_status_to_products_table', 10),
(13, '2025_05_05_021920_add_more_product_attributes_to_products_table', 11),
(14, '2025_05_06_080823_create_orders_table', 12),
(15, '2025_05_06_083043_add_order_items_to_orders_table', 13),
(16, '2025_05_06_085206_create_order_items_table', 14),
(17, '2025_05_06_094315_add_status_to_orders_table', 15),
(18, '2025_05_06_125855_create_pages_table', 16),
(19, '2025_05_07_094210_create_transactions_table', 17),
(20, '2025_05_07_120235_create_bank_transactions_table', 18);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_method` enum('cod','bank') NOT NULL,
  `total` int(11) NOT NULL,
  `deposit` int(11) NOT NULL DEFAULT 0,
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`order_items`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `name`, `email`, `phone`, `address`, `payment_method`, `total`, `deposit`, `ordered_at`, `status`, `created_at`, `updated_at`, `order_items`) VALUES
(4, '123', 'luongdienmat@gmail.com', '123123123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 35000000, 1750000, '2025-05-06 12:29:30', 'chua_xac_nhan', '2025-05-06 01:56:30', '2025-05-06 01:56:30', NULL),
(5, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 35000000, 1750000, '2025-05-06 12:29:30', 'chua_xac_nhan', '2025-05-06 01:56:57', '2025-05-06 01:56:57', NULL),
(6, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 124000000, 6200000, '2025-05-06 12:29:30', 'chua_xac_nhan', '2025-05-06 02:04:34', '2025-05-06 02:04:34', NULL),
(7, '123123', 'luongdienmat@gmail.com', '123123', 'Da Nang, Hải Châu District, Da Nang, Vietnam', 'bank', 22000000, 0, '2025-05-06 12:29:30', 'chua_xac_nhan', '2025-05-06 02:09:37', '2025-05-06 02:09:37', NULL),
(8, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 22000000, 1100000, '2025-05-05 17:00:00', 'huy', '2025-05-06 02:11:02', '2025-05-06 05:30:24', NULL),
(9, '1231231415411', 'hung150302@gmail.com', '123123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-05 17:00:00', 'da_xac_nhan', '2025-05-06 02:11:51', '2025-05-06 05:14:19', NULL),
(10, 'nguyễn Ngọc Hưng', 'hungnguyenkaka111@gmail.com', '123123', 'Da Nang, Hải Châu District, Da Nang, Vietnam', 'cod', 17000000, 850000, '2025-05-05 17:00:00', 'dang_van_chuyen', '2025-05-06 02:15:00', '2025-05-06 04:49:47', NULL),
(16, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'bank', 7000000, 0, '2025-05-05 17:00:00', 'hoan_thanh', '2025-05-06 02:34:18', '2025-05-06 05:30:09', NULL),
(17, '123123', 'luongdienmat@gmail.com', '123123', '123123', 'cod', 22000000, 1100000, '2025-05-08 21:09:04', 'pending', '2025-05-08 21:09:04', '2025-05-08 21:09:04', NULL),
(18, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 15000000, 750000, '2025-05-08 21:34:31', 'pending', '2025-05-08 21:34:31', '2025-05-08 21:34:31', NULL),
(19, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 15000000, 750000, '2025-05-08 21:37:17', 'pending', '2025-05-08 21:37:17', '2025-05-08 21:37:17', NULL),
(20, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 03:40:11', 'pending', '2025-05-16 03:40:11', '2025-05-16 03:40:11', NULL),
(21, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 04:08:32', 'pending', '2025-05-16 04:08:32', '2025-05-16 04:08:32', NULL),
(22, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'bank', 2000000, 0, '2025-05-16 04:09:00', 'pending', '2025-05-16 04:09:00', '2025-05-16 04:09:00', NULL),
(23, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 04:09:20', 'pending', '2025-05-16 04:09:20', '2025-05-16 04:09:20', NULL),
(24, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 04:33:24', 'pending', '2025-05-16 04:33:24', '2025-05-16 04:33:24', NULL),
(25, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 04:36:27', 'pending', '2025-05-16 04:36:27', '2025-05-16 04:36:27', NULL),
(26, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'bank', 2000000, 0, '2025-05-16 04:45:06', 'pending', '2025-05-16 04:45:06', '2025-05-16 04:45:06', NULL),
(27, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 04:46:09', 'pending', '2025-05-16 04:46:09', '2025-05-16 04:46:09', NULL),
(28, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 04:50:09', 'pending', '2025-05-16 04:50:09', '2025-05-16 04:50:09', NULL),
(29, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'bank', 2000000, 0, '2025-05-16 04:50:23', 'pending', '2025-05-16 04:50:23', '2025-05-16 04:50:23', NULL),
(30, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 05:01:30', 'pending', '2025-05-16 05:01:30', '2025-05-16 05:01:30', NULL),
(31, 'nguyễn Ngọc Hưng', 'luongdienmat@gmail.com', '123', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', 'cod', 2000000, 100000, '2025-05-16 05:04:48', 'pending', '2025-05-16 05:04:48', '2025-05-16 05:04:48', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `name`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 4, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-06 01:56:30', '2025-05-06 01:56:30'),
(2, 4, 'Kệ ti vi gỗ số 1', 1, 15000000.00, '2025-05-06 01:56:30', '2025-05-06 01:56:30'),
(3, 4, 'Bàn Trang Điểm Nhập Khẩu Nhật Bản', 1, 5000000.00, '2025-05-06 01:56:30', '2025-05-06 01:56:30'),
(4, 4, 'Giường gỗ tự nhiên số 1', 1, 10000000.00, '2025-05-06 01:56:30', '2025-05-06 01:56:30'),
(5, 4, 'Tủ Gỗ Cao Cấp số 1', 1, 3000000.00, '2025-05-06 01:56:30', '2025-05-06 01:56:30'),
(6, 5, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-06 01:56:57', '2025-05-06 01:56:57'),
(7, 5, 'Kệ ti vi gỗ số 1', 1, 15000000.00, '2025-05-06 01:56:57', '2025-05-06 01:56:57'),
(8, 5, 'Bàn Trang Điểm Nhập Khẩu Nhật Bản', 1, 5000000.00, '2025-05-06 01:56:57', '2025-05-06 01:56:57'),
(9, 5, 'Giường gỗ tự nhiên số 1', 1, 10000000.00, '2025-05-06 01:56:57', '2025-05-06 01:56:57'),
(10, 5, 'Tủ Gỗ Cao Cấp số 1', 1, 3000000.00, '2025-05-06 01:56:57', '2025-05-06 01:56:57'),
(11, 6, 'Kệ Sách Trang Trí Phòng Khách', 5, 2000000.00, '2025-05-06 02:04:34', '2025-05-06 02:04:34'),
(12, 6, 'Kệ ti vi gỗ số 1', 4, 15000000.00, '2025-05-06 02:04:34', '2025-05-06 02:04:34'),
(13, 6, 'Bàn Trang Điểm Nhập Khẩu Nhật Bản', 3, 5000000.00, '2025-05-06 02:04:34', '2025-05-06 02:04:34'),
(14, 6, 'Giường gỗ tự nhiên số 1', 3, 10000000.00, '2025-05-06 02:04:34', '2025-05-06 02:04:34'),
(15, 6, 'Tủ Gỗ Cao Cấp số 1', 3, 3000000.00, '2025-05-06 02:04:34', '2025-05-06 02:04:34'),
(16, 7, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-06 02:09:37', '2025-05-06 02:09:37'),
(17, 7, 'Kệ ti vi gỗ số 1', 1, 15000000.00, '2025-05-06 02:09:37', '2025-05-06 02:09:37'),
(18, 7, 'Bàn Trang Điểm Nhập Khẩu Nhật Bản', 1, 5000000.00, '2025-05-06 02:09:37', '2025-05-06 02:09:37'),
(19, 8, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-06 02:11:02', '2025-05-06 02:11:02'),
(20, 8, 'Kệ ti vi gỗ số 1', 1, 15000000.00, '2025-05-06 02:11:02', '2025-05-06 02:11:02'),
(21, 8, 'Bàn Trang Điểm Nhập Khẩu Nhật Bản', 1, 5000000.00, '2025-05-06 02:11:02', '2025-05-06 02:11:02'),
(22, 9, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-06 02:11:51', '2025-05-06 02:11:51'),
(23, 10, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-06 02:15:00', '2025-05-06 02:15:00'),
(24, 10, 'Kệ ti vi gỗ số 1', 1, 15000000.00, '2025-05-06 02:15:00', '2025-05-06 02:15:00'),
(37, 16, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-06 02:34:18', '2025-05-06 02:34:18'),
(38, 16, 'Bàn Trang Điểm Nhập Khẩu Nhật Bản', 1, 5000000.00, '2025-05-06 02:34:18', '2025-05-06 02:34:18'),
(39, 17, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-08 21:09:04', '2025-05-08 21:09:04'),
(40, 17, 'Kệ ti vi gỗ số 1', 1, 15000000.00, '2025-05-08 21:09:04', '2025-05-08 21:09:04'),
(41, 17, 'Bàn Trang Điểm Nhập Khẩu Nhật Bản', 1, 5000000.00, '2025-05-08 21:09:04', '2025-05-08 21:09:04'),
(42, 18, 'Kệ ti vi gỗ số 1', 1, 15000000.00, '2025-05-08 21:34:31', '2025-05-08 21:34:31'),
(43, 19, 'Kệ ti vi gỗ số 1', 1, 15000000.00, '2025-05-08 21:37:17', '2025-05-08 21:37:17'),
(44, 20, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 03:40:11', '2025-05-16 03:40:11'),
(45, 21, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:08:32', '2025-05-16 04:08:32'),
(46, 22, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:09:00', '2025-05-16 04:09:00'),
(47, 23, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:09:20', '2025-05-16 04:09:20'),
(48, 24, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:33:24', '2025-05-16 04:33:24'),
(49, 25, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:36:27', '2025-05-16 04:36:27'),
(50, 26, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:45:06', '2025-05-16 04:45:06'),
(51, 27, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:46:09', '2025-05-16 04:46:09'),
(52, 28, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:50:09', '2025-05-16 04:50:09'),
(53, 29, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 04:50:23', '2025-05-16 04:50:23'),
(54, 30, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 05:01:30', '2025-05-16 05:01:30'),
(55, 31, 'Kệ Sách Trang Trí Phòng Khách', 1, 2000000.00, '2025-05-16 05:04:48', '2025-05-16 05:04:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `zalo_link` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone_numbers` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `pages`
--

INSERT INTO `pages` (`id`, `facebook_link`, `zalo_link`, `address`, `phone_numbers`, `created_at`, `updated_at`) VALUES
(6, 'https://www.facebook.com/ryu1503/', 'https://zalo.me/0342720204', 'Phước Tường 12, Hòa Phát, Cẩm Lệ', '\"[\\\"0342720204\\\"]\"', '2025-05-06 08:07:50', '2025-05-06 08:07:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `code` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `origin` varchar(255) DEFAULT NULL,
  `material` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `image`, `description`, `status`, `price`, `code`, `qty`, `created_at`, `updated_at`, `subcategory_id`, `brand_id`, `origin`, `material`, `dimensions`, `color`, `warranty`) VALUES
(5, 'Tủ Gỗ Cao Cấp số 1', 'tu-go-cao-cap-so-1', '5_1745232171.jpg', 'Tủ Gỗ Cao Cấp số 1', 1, 3000000.00, '04', 10, '2025-04-21 03:42:51', '2025-05-04 19:42:12', 16, 2, 'Việt Nam', 'Gỗ', '2000*1600', 'Xám Trắng', '3 Năm'),
(6, 'Giường gỗ tự nhiên số 1', 'giuong-go-tu-nhien-so-1', '6_680cd6392b383.jpg', 'Giường gỗ tự nhiên số 1', 1, 10000000.00, '03', 10, '2025-04-21 03:44:13', '2025-05-04 19:41:18', 5, 10, 'Việt Nam', 'Gỗ', '2000*1600', 'Vàng', '2 năm'),
(7, 'Bàn Trang Điểm Nhập Khẩu Nhật Bản', 'ban-trang-diem-nhap-khau-nhat-ban', '7_680e3933680f4.jpg', 'Bàn Trang Điểm Nhập Khẩu Nhật Bản bằng gỗ cây anh đào , chất lượng cực tốt và có thời gian bảo hành 3 năm từ ngày bán', 1, 5000000.00, '02', 10, '2025-04-21 03:45:54', '2025-05-04 19:40:05', 2, 2, 'Nhập Khẩu', 'Gỗ cây anh đào', '1000*500 mm', 'Xanh', '3 Năm'),
(10, 'Kệ ti vi gỗ số 1', 'ke-ti-vi-go-so-1', '10_680e38988fc1b.jpg', 'Kệ ti vi gỗ số 1', 1, 15000000.00, '01', 10, '2025-04-21 04:05:06', '2025-05-04 19:38:48', 7, 2, 'Việt Nam', 'Gỗ Tự Nhiên Cao Cấp', '600*2000 mm', 'Nâu', '1 Năm'),
(11, 'Kệ Sách Trang Trí Phòng Khách', 'ke-sach-trang-tri-phong-khach', '11_68182712265de.jpg', 'Kệ sách trang  trí phòng khách được thiết kế độc đáo giúp tạo điểm nhấn', 1, 2000000.00, '05', 10, '2025-05-04 19:48:50', '2025-05-04 19:48:50', 7, 9, 'Việt Nam', 'Gỗ', '600*2000 mm', 'Vàng', '1 Năm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('b9Q0pCbkgmDEBDnD2fK1l4aJje8vQnh2GAiKOAPS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaThTcTRRc3c1VXF2YjEySXhTVW1rb2hSVkRJSWNpU1RVc3hPQ1l0WSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wYWdlcyI7fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjEyOiJnb29nbGVfdG9rZW4iO2E6Nzp7czoxMjoiYWNjZXNzX3Rva2VuIjtzOjIyMjoieWEyOS5hMEFXNFh0eGo1R3hyMnJSRV9CWG12NHBMSTFxVlJEWmRFbm5ncjBYcVJ1QnBieDBIRG5QWF9WZXNieGxUVmVSckJReVZaUG5RTW1EU01oRWd0VmdCUTY3VE1BM0FEbjE4aVJnb0JjcklGT3ZvelI5YjR2UlVtVjY0ckd4ZUhDd0RYOTNnWnM2YWlPR2hta1k0bTJTMWFvbDZGalNQWmdmN08wcHdxV0d4UWFDZ1lLQVd3U0FSRVNGUUhHWDJNaXp1MzNheTB5SHBVZE5ZS3B5VTJZRFEwMTc1IjtzOjEwOiJleHBpcmVzX2luIjtpOjM1OTk7czoxMzoicmVmcmVzaF90b2tlbiI7czoxMDM6IjEvLzBlOFAwcXN0bDdhMGVDZ1lJQVJBQUdBNFNOd0YtTDlJcll3MUFzbDQyeXZzb2V6a3Bnc1NHRE95LVhMU1N2NUNHRG1wWFdrZVlsYU5PN2RscXRsS3Mtc05FMWYzaWtpQTdaLUEiO3M6NToic2NvcGUiO3M6NDY6Imh0dHBzOi8vd3d3Lmdvb2dsZWFwaXMuY29tL2F1dGgvZ21haWwucmVhZG9ubHkiO3M6MTA6InRva2VuX3R5cGUiO3M6NjoiQmVhcmVyIjtzOjI0OiJyZWZyZXNoX3Rva2VuX2V4cGlyZXNfaW4iO2k6NjA0Nzk5O3M6NzoiY3JlYXRlZCI7aToxNzQ3Mzk3NDUxO319', 1747397548),
('ohGJ8sLOv2wSytbezxIWmEAmmjYSlDmwYJm6pKxO', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSzBsZDNJMVpUQXBzWmRIcGdzZWFoVnJibFVSUFJZWjBJUGJRTlMxMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1747397365);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `subcategories`
--

INSERT INTO `subcategories` (`id`, `name`, `slug`, `status`, `category_id`, `created_at`, `updated_at`) VALUES
(2, 'bàn trang điểm nhập khẩu', 'ban-trang-diem-nhap-khau', 1, 60, '2025-04-17 21:18:52', '2025-04-17 21:18:52'),
(4, 'bàn trà trung quốc', 'ban-tra-trung-quoc', 1, 59, '2025-04-17 21:19:23', '2025-04-17 21:19:23'),
(5, 'Giường gỗ', 'giuong-go', 1, 62, '2025-04-17 21:22:12', '2025-04-26 06:14:38'),
(7, 'Kệ tivi gỗ', 'ke-tivi-go', 1, 64, '2025-04-17 21:22:42', '2025-05-08 22:57:29'),
(15, 'bàn ghế ăn đá cẩm thạch', 'ban-ghe-an-da-cam-thach', 1, 61, '2025-04-18 20:51:22', '2025-04-26 06:25:42'),
(16, 'tủ quàn áo', 'tu-quan-ao', 1, 69, '2025-04-27 07:05:52', '2025-05-08 22:39:32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `temp_images`
--

CREATE TABLE `temp_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `temp_images`
--

INSERT INTO `temp_images` (`id`, `name`, `created_at`, `updated_at`) VALUES
(4, '1744073776.png', '2025-04-07 17:56:16', '2025-04-07 17:56:16'),
(5, '1744073869.jpg', '2025-04-07 17:57:49', '2025-04-07 17:57:49'),
(6, '1744077536.png', '2025-04-07 18:58:56', '2025-04-07 18:58:56'),
(7, '1744077569.png', '2025-04-07 18:59:29', '2025-04-07 18:59:29'),
(8, '1744077595.png', '2025-04-07 18:59:55', '2025-04-07 18:59:55'),
(9, '1744077674.jpg', '2025-04-07 19:01:14', '2025-04-07 19:01:14'),
(10, '1744077838.png', '2025-04-07 19:03:58', '2025-04-07 19:03:58'),
(11, '1744078201.jpg', '2025-04-07 19:10:01', '2025-04-07 19:10:01'),
(12, '1744078224.jpg', '2025-04-07 19:10:24', '2025-04-07 19:10:24'),
(13, '1744078440.jpg', '2025-04-07 19:14:00', '2025-04-07 19:14:00'),
(14, '1744078545.png', '2025-04-07 19:15:45', '2025-04-07 19:15:45'),
(15, '1744078577.jpg', '2025-04-07 19:16:17', '2025-04-07 19:16:17'),
(16, '1744078595.jpg', '2025-04-07 19:16:35', '2025-04-07 19:16:35'),
(17, '1744078670.jpg', '2025-04-07 19:17:50', '2025-04-07 19:17:50'),
(18, '1744079448.png', '2025-04-07 19:30:48', '2025-04-07 19:30:48'),
(19, '1744079513.jpg', '2025-04-07 19:31:53', '2025-04-07 19:31:53'),
(20, '1744944781.jpg', '2025-04-17 19:53:01', '2025-04-17 19:53:01'),
(21, '1744945142.jpg', '2025-04-17 19:59:02', '2025-04-17 19:59:02'),
(22, '1744945872.jpg', '2025-04-17 20:11:12', '2025-04-17 20:11:12'),
(23, '1744946829.jpg', '2025-04-17 20:27:09', '2025-04-17 20:27:09'),
(24, '1744946850.jpg', '2025-04-17 20:27:30', '2025-04-17 20:27:30'),
(25, '1744946868.jpg', '2025-04-17 20:27:48', '2025-04-17 20:27:48'),
(26, '1744946901.jpg', '2025-04-17 20:28:21', '2025-04-17 20:28:21'),
(27, '1744946914.jpg', '2025-04-17 20:28:34', '2025-04-17 20:28:34'),
(28, '1744946925.jpg', '2025-04-17 20:28:45', '2025-04-17 20:28:45'),
(29, '1744946938.jpg', '2025-04-17 20:28:58', '2025-04-17 20:28:58'),
(30, '1744946951.jpg', '2025-04-17 20:29:11', '2025-04-17 20:29:11'),
(31, '1744946967.jpg', '2025-04-17 20:29:28', '2025-04-17 20:29:28'),
(32, '1744946981.jpg', '2025-04-17 20:29:41', '2025-04-17 20:29:41'),
(33, '1744946996.jpg', '2025-04-17 20:29:56', '2025-04-17 20:29:56'),
(34, '1744950200.png', '2025-04-17 21:23:20', '2025-04-17 21:23:20'),
(35, '1745231560.jpg', '2025-04-21 03:32:40', '2025-04-21 03:32:40'),
(36, '1745231846.jpg', '2025-04-21 03:37:26', '2025-04-21 03:37:26'),
(37, '1745231944.jpg', '2025-04-21 03:39:04', '2025-04-21 03:39:04'),
(38, '1745231948.jpg', '2025-04-21 03:39:08', '2025-04-21 03:39:08'),
(39, '1745231951.jpg', '2025-04-21 03:39:11', '2025-04-21 03:39:11'),
(40, '1745232044.jpg', '2025-04-21 03:40:44', '2025-04-21 03:40:44'),
(41, '1745232061.jpg', '2025-04-21 03:41:01', '2025-04-21 03:41:01'),
(42, '1745232170.jpg', '2025-04-21 03:42:50', '2025-04-21 03:42:50'),
(43, '1745232251.jpg', '2025-04-21 03:44:11', '2025-04-21 03:44:11'),
(44, '1745232354.jpg', '2025-04-21 03:45:54', '2025-04-21 03:45:54'),
(45, '1745233244.jpg', '2025-04-21 04:00:44', '2025-04-21 04:00:44'),
(46, '1745233260.jpg', '2025-04-21 04:01:00', '2025-04-21 04:01:00'),
(49, '1745234316.jpg', '2025-04-21 04:18:36', '2025-04-21 04:18:36'),
(50, '1745234323.jpg', '2025-04-21 04:18:43', '2025-04-21 04:18:43'),
(51, '1745234333.jpg', '2025-04-21 04:18:53', '2025-04-21 04:18:53'),
(52, '1745234605.jpg', '2025-04-21 04:23:25', '2025-04-21 04:23:25'),
(54, '1745234757.jpg', '2025-04-21 04:25:57', '2025-04-21 04:25:57'),
(57, '1745669620.jpg', '2025-04-26 05:13:40', '2025-04-26 05:13:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `transaction_date` datetime NOT NULL,
  `amount` varchar(255) NOT NULL,
  `balance` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transactions`
--

INSERT INTO `transactions` (`id`, `account_number`, `transaction_date`, `amount`, `balance`, `description`, `created_at`, `updated_at`) VALUES
(1, '040095722387', '2025-05-16 12:11:31', '72,000 VND', '3,385,037 VND', 'EWX526021345 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:31', '2025-05-16 05:11:31'),
(2, '040095722387', '2025-05-16 12:11:32', '4,800,000 VND', '3,457,037 VND', 'EWX525850766 05 IBFT NGUYEN NGOC HUNG 38799 hk2 2024 2025', '2025-05-16 05:11:32', '2025-05-16 05:11:32'),
(3, '040095722387', '2025-05-16 12:11:32', '5,000,000 VND', '8,257,037 VND', 'QR - hung CKN 866099 - PHAM THI TAM - Ngan hang TMCP Cong Thuong Viet Nam', '2025-05-16 05:11:32', '2025-05-16 05:11:32'),
(4, '040095722387', '2025-05-16 12:11:33', '201,000 VND', '3,257,037 VND', 'EWX524969700 CHUYEN TIEN NHANH QUA QR', '2025-05-16 05:11:33', '2025-05-16 05:11:33'),
(5, '040095722387', '2025-05-16 12:11:33', '12,000 VND', '3,458,037 VND', 'EWX524666906 NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:33', '2025-05-16 05:11:33'),
(6, '040095722387', '2025-05-16 12:11:34', '25,000 VND', '3,470,037 VND', 'QUAN HANH DANANG VN', '2025-05-16 05:11:34', '2025-05-16 05:11:34'),
(7, '040095722387', '2025-05-16 12:11:34', '29,000 VND', '3,495,037 VND', 'CHINHOQUAN THUTHIENHUE VN', '2025-05-16 05:11:34', '2025-05-16 05:11:34'),
(8, '040095722387', '2025-05-16 12:11:35', '245,000 VND', '3,524,037 VND', 'EWX523348478 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:35', '2025-05-16 05:11:35'),
(9, '040095722387', '2025-05-16 12:11:35', '55,000 VND', '3,769,037 VND', 'EWX523004025 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:35', '2025-05-16 05:11:35'),
(10, '040095722387', '2025-05-16 12:11:36', '20,000 VND', '3,824,037 VND', 'EWX521156006 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:36', '2025-05-16 05:11:36'),
(11, '040095722387', '2025-05-16 12:11:36', '29,000 VND', '3,844,037 VND', 'CHINHOQUAN THUTHIENHUE VN', '2025-05-16 05:11:36', '2025-05-16 05:11:36'),
(12, '040095722387', '2025-05-16 12:11:37', '30,000 VND', '3,873,037 VND', 'EWX519859740 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:37', '2025-05-16 05:11:37'),
(13, '040095722387', '2025-05-16 12:11:37', '56,000 VND', '3,903,037 VND', 'EWX519241842 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:37', '2025-05-16 05:11:37'),
(14, '040095722387', '2025-05-16 12:11:38', '55,000 VND', '3,959,037 VND', 'EWX518474129 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:38', '2025-05-16 05:11:38'),
(15, '040095722387', '2025-05-16 12:11:38', '29,000 VND', '4,014,037 VND', 'CHINHOQUAN THUTHIENHUE VN', '2025-05-16 05:11:38', '2025-05-16 05:11:38'),
(16, '040095722387', '2025-05-16 12:11:39', '20,000 VND', '4,043,037 VND', 'EWX514670194 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:39', '2025-05-16 05:11:39'),
(17, '040095722387', '2025-05-16 12:11:39', '29,000 VND', '4,063,037 VND', 'CHINHOQUAN THUTHIENHUE VN', '2025-05-16 05:11:39', '2025-05-16 05:11:39'),
(18, '040095722387', '2025-05-16 12:11:40', '55,000 VND', '4,092,037 VND', 'EWX513906118 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:40', '2025-05-16 05:11:40'),
(19, '040095722387', '2025-05-16 12:11:40', '10,000 VND', '4,147,037 VND', 'EWX512630041 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:40', '2025-05-16 05:11:40'),
(20, '040095722387', '2025-05-16 12:11:41', '110,000 VND', '4,157,037 VND', 'EWX512602350 NGUYEN XUAN DUC chuyen tien', '2025-05-16 05:11:41', '2025-05-16 05:11:41'),
(21, '040095722387', '2025-05-16 12:11:41', '220,000 VND', '4,047,037 VND', 'EWX512598533 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:41', '2025-05-16 05:11:41'),
(22, '040095722387', '2025-05-16 12:11:42', '2,000 VND', '4,267,037 VND', 'EWX512149833 05 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:42', '2025-05-16 05:11:42'),
(23, '040095722387', '2025-05-16 12:11:42', '1,155,000 VND', '4,269,037 VND', 'LE QUOC AN chuyen tien CKN 283285 - MBBANK IBFT - Ngan hang TMCP Quan Doi', '2025-05-16 05:11:42', '2025-05-16 05:11:42'),
(24, '040095722387', '2025-05-16 12:11:42', '2,312,000 VND', '3,114,037 VND', 'EWX511749465 05 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:42', '2025-05-16 05:11:42'),
(25, '040095722387', '2025-05-16 12:11:43', '4,000,000 VND', '5,426,037 VND', 'QR - hing CKN 167497 - PHAM THI TAM - Ngan hang TMCP Cong Thuong Viet Nam', '2025-05-16 05:11:43', '2025-05-16 05:11:43'),
(26, '040095722387', '2025-05-16 12:11:43', '29,000 VND', '1,426,037 VND', 'CHINHOQUAN THUTHIENHUE VN', '2025-05-16 05:11:43', '2025-05-16 05:11:43'),
(27, '040095722387', '2025-05-16 12:11:44', '28,000 VND', '1,455,037 VND', 'EWX508127244 99 IBFT NGUYEN NGOC HUNG chuyen tien', '2025-05-16 05:11:44', '2025-05-16 05:11:44'),
(28, '040095722387', '2025-05-16 12:11:44', '33,000 VND', '1,483,037 VND', 'CHINHOQUAN THUTHIENHUE VN', '2025-05-16 05:11:44', '2025-05-16 05:11:44'),
(29, '040095722387', '2025-05-16 12:11:45', '2,000 VND', '1,516,037 VND', 'TRAN THANH KHOA chuyen tien CKN 305417 - MBBANK IBFT - Ngan hang TMCP Quan Doi', '2025-05-16 05:11:45', '2025-05-16 05:11:45'),
(30, '040095722387', '2025-05-16 12:11:45', '42,000 VND', '1,514,037 VND', 'EWX504256851 99 IBFT 69885L1O3WFLGNHW0EDR', '2025-05-16 05:11:45', '2025-05-16 05:11:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'luongdienmat@gmail.com', 1, NULL, '$2y$12$HmXx73vnknItDeaG4eN2hOJFRcYuvW92si4V2OI4TEXJ4qnbgDO1y', NULL, '2025-04-04 16:25:04', '2025-04-04 16:25:04'),
(2, 'Hung1503', 'hungnguyenkaka111@gmail.com', 2, NULL, '$2y$12$yt65q7/NEddTwYY8NNlwtOR.rD2W8ePiKlrgl7.lusr4VDHkUzwom', NULL, '2025-04-04 16:26:36', '2025-04-04 16:26:36');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bank_transactions`
--
ALTER TABLE `bank_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `temp_images`
--
ALTER TABLE `temp_images`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bank_transactions`
--
ALTER TABLE `bank_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT cho bảng `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `temp_images`
--
ALTER TABLE `temp_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT cho bảng `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
