-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 23, 2026 at 09:50 AM
-- Server version: 8.4.3
-- PHP Version: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doan_totnghiep`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int NOT NULL,
  `schedule_id` int NOT NULL,
  `tour_customer_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `guide_id` int NOT NULL,
  `status` enum('present','absent','unknown') DEFAULT 'unknown',
  `note` text,
  `marked_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `schedule_id`, `tour_customer_id`, `customer_id`, `guide_id`, `status`, `note`, `marked_at`) VALUES
(2, 2, 3, 2, 2, 'present', 'Điểm danh đầu tour', '2025-12-02 14:29:16'),
(8, 1, 1, 1, 3, 'unknown', 'Chưa đến ngày khởi hành', '2025-12-02 14:29:16'),
(9, 1, 2, 2, 3, 'unknown', 'Chưa đến ngày khởi hành', '2025-12-02 14:29:16'),
(11, 1, 17, 5, 4, 'present', '', '2025-12-03 19:44:02'),
(12, 1, 1, 1, 4, 'absent', 'Chưa đến ngày khởi hành', '2025-12-03 19:44:02'),
(13, 1, 2, 2, 4, 'present', 'Chưa đến ngày khởi hành', '2025-12-03 19:44:02'),
(14, 13, 14, 8, 4, 'absent', '', '2025-12-03 19:45:10'),
(15, 13, 15, 7, 4, 'present', '', '2025-12-03 19:45:10'),
(16, 13, 16, 5, 4, 'present', '', '2025-12-03 19:45:10'),
(17, 13, 14, 8, 4, 'absent', NULL, '2025-12-04 17:54:13'),
(18, 13, 15, 7, 4, 'absent', NULL, '2025-12-04 17:54:13'),
(19, 13, 16, 5, 4, 'present', NULL, '2025-12-04 17:54:13'),
(20, 13, 14, 8, 4, 'absent', NULL, '2025-12-04 17:59:37'),
(21, 13, 15, 7, 4, 'absent', NULL, '2025-12-04 17:59:37'),
(22, 13, 16, 5, 4, 'present', NULL, '2025-12-04 17:59:37'),
(23, 13, 14, 8, 4, 'present', 'kkk', '2025-12-04 18:04:56'),
(24, 13, 15, 7, 4, 'absent', NULL, '2025-12-04 18:04:56'),
(25, 13, 16, 5, 4, 'present', NULL, '2025-12-04 18:04:56'),
(26, 13, 14, 8, 4, 'present', 'Ăn Chay', '2025-12-04 20:25:48'),
(27, 13, 15, 7, 4, 'present', 'Không thích đi suối ', '2025-12-04 20:25:48'),
(28, 13, 16, 5, 4, 'present', NULL, '2025-12-04 20:25:48'),
(29, 13, 24, 6, 4, 'absent', NULL, '2025-12-04 20:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `schedule_id` int NOT NULL,
  `booking_date` datetime DEFAULT (now()),
  `num_people` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `payment_status` enum('unpaid','deposit','paid') DEFAULT 'unpaid',
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `customer_id`, `tour_id`, `schedule_id`, `booking_date`, `num_people`, `total_price`, `status`, `payment_status`, `note`) VALUES
(1, 1, 1, 1, '2025-12-02 14:29:16', 2, 11000000.00, 'upcoming', 'deposit', 'Yêu cầu phòng có view đẹp.'),
(2, 2, 2, 2, '2025-11-27 14:29:16', 4, 50000000.00, 'upcoming', 'paid', NULL),
(3, 3, 3, 3, '2025-11-22 14:29:16', 1, 3200000.00, 'upcoming', 'deposit', 'Đánh giá tốt về hướng dẫn viên.'),
(12, 8, 1, 13, '2025-12-02 12:03:08', 3, 16500000.00, 'ongoing', 'paid', 'kkkk'),
(13, 5, 1, 1, '2025-12-02 13:13:08', 1, 5500000.00, 'upcoming', 'deposit', ''),
(14, 10, 1, 17, '2025-12-03 12:28:46', 2, 11000000.00, 'ongoing', 'unpaid', ''),
(15, 8, 6, 18, '2025-12-04 13:14:23', 4, 18000000.00, 'completed', 'paid', '');

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
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `description`) VALUES
(1, 'Tour trong nước', 'Các chuyến du lịch diễn ra trong lãnh thổ Việt Nam.'),
(2, 'Tour nước ngoài', 'Các chuyến du lịch đến các quốc gia khác trên thế giới.'),
(3, 'Tour tự chọn', 'Các chuyến du lịch được thiết kế theo yêu cầu riêng của khách hàng.');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `gender` enum('Nam','Nữ','Khác') DEFAULT 'Khác',
  `birthdate` date DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `id_number` varchar(20) DEFAULT NULL,
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `fullname`, `gender`, `birthdate`, `phone`, `email`, `id_number`, `notes`) VALUES
(1, 'Lê Văn An', 'Nam', '1990-05-15', '0911223344', 'an.le@example.com', '012345678901', NULL),
(2, 'Phạm Thị Bích', 'Nữ', '1985-11-20', '0911223345', 'bich.pham@example.com', '012345678902', 'Khách hàng thân thiết'),
(3, 'Ngô Đình Cường', 'Nam', '1978-01-01', '0911223346', 'cuong.ngo@example.com', '012345678903', NULL),
(4, 'Trần Thu Dung', 'Nữ', '1995-07-25', '0911223347', 'dung.tran@example.com', '012345678904', NULL),
(5, 'Hoàng Văn Em', 'Nam', '2000-03-10', '0911223348', 'em.hoang@example.com', '012345678905', 'Thích đi tour tự chọn'),
(6, 'Vũ Thị Phương', 'Nữ', '1980-09-05', '0911223349', 'phuong.vu@example.com', '012345678906', NULL),
(7, 'Đặng Hải Long', 'Nam', '1992-12-12', '0911223350', 'long.dang@example.com', '012345678907', NULL),
(8, 'Bùi Minh Nguyệt', 'Nữ', '1998-04-30', '0911223351', 'nguyet.bui@example.com', '012345678908', NULL),
(9, 'Mai Chí Tùng', 'Nam', '1975-02-18', '0911223352', 'tung.mai@example.com', '012345678909', NULL),
(10, 'Lý Thanh Vân', 'Nữ', '1988-06-08', '0911223353', 'van.ly@example.com', '012345678910', 'Đã hủy 1 lần');

-- --------------------------------------------------------

--
-- Table structure for table `departure_schedule`
--

CREATE TABLE `departure_schedule` (
  `schedule_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `meeting_point` varchar(255) DEFAULT NULL,
  `guide_id` int DEFAULT NULL,
  `notes` text,
  `driver_id` int DEFAULT NULL,
  `hotel_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `departure_schedule`
--

INSERT INTO `departure_schedule` (`schedule_id`, `tour_id`, `start_date`, `end_date`, `meeting_point`, `guide_id`, `notes`, `driver_id`, `hotel_id`) VALUES
(1, 1, '2025-12-10', '2025-12-13', 'Sân bay Nội Bài', 3, 'Lịch trình dự kiến không thay đổi.', 7, 1),
(2, 2, '2025-12-15', '2025-12-19', 'Sân bay Tân Sơn Nhất', 2, 'Yêu cầu HDV biết tiếng Thái.', 4, NULL),
(3, 3, '2025-12-20', '2025-12-22', 'Bến xe Miền Tây', NULL, 'Chuẩn bị thêm áo phao.', 2, NULL),
(4, 6, '2025-12-25', '2025-12-27', 'Ga Hà Nội', NULL, 'Thời tiết Sapa lạnh, nhắc khách chuẩn bị kỹ.', 3, NULL),
(5, 8, '2026-01-05', '2026-01-08', 'Sân bay Phú Quốc', NULL, 'Đón khách lúc 8h sáng.', 7, NULL),
(7, 1, '2026-01-20', '2026-01-23', 'Khách sạn Mường Thanh Hà Nội', 3, 'Tour cận Tết, có thể đông khách.', 1, NULL),
(13, 1, '2025-12-03', '2025-12-05', 'Hà Nội', 3, NULL, 7, NULL),
(14, 1, '2025-12-06', '2025-12-07', 'Hà Nội', 1, NULL, 8, NULL),
(15, 1, '2025-12-12', '2025-12-15', 'Hà Nội', 10, 'Có trẻ con ', 8, 1),
(16, 1, '2025-12-04', '2025-12-01', 'Hà Nội', 10, NULL, 8, 1),
(17, 1, '2025-12-03', '2025-12-05', 'Sân Bay Nội Bài', 10, NULL, 8, 1),
(18, 6, '2025-11-27', '2025-11-30', 'Sân Bay Nội Bài', 3, NULL, 6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driver_id` int NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `license_plate` varchar(20) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `status` enum('available','busy') DEFAULT 'available',
  `notes` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `fullname`, `phone`, `license_plate`, `vehicle_type`, `status`, `notes`) VALUES
(1, 'Nguyễn Văn Đạt', '0900111222', '51F-123.45', 'Xe 45 chỗ', 'available', NULL),
(2, 'Trần Hữu Giàu', '0900111223', '50B-567.89', 'Xe 16 chỗ', 'available', 'Chuyên tuyến Miền Tây'),
(3, 'Phạm Công Hiếu', '0900111224', '29A-987.65', 'Xe 7 chỗ', 'busy', 'Đang phục vụ tour Sapa'),
(4, 'Lê Thị Khánh', '0900111225', '60C-321.00', 'Xe 45 chỗ', 'available', NULL),
(5, 'Hoàng Trung Kiên', '0900111226', '51G-000.11', 'Xe 16 chỗ', 'available', 'Tài xế mới'),
(6, 'Vũ Đình Mạnh', '0900111227', '29C-222.33', 'Xe 7 chỗ', 'available', NULL),
(7, 'Đào Thanh Ngọc', '0900111228', '50D-444.55', 'Xe 45 chỗ', 'busy', 'Đang phục vụ tour Phú Quốc'),
(8, 'Bùi Văn Phúc', '0900111229', '60A-666.77', 'Xe 16 chỗ', 'available', NULL),
(9, 'Mai Đình Quyết', '0900111230', '51H-888.99', 'Xe 7 chỗ', 'available', NULL),
(10, 'Ngô Thị Thúy', '0900111231', '29B-101.20', 'Xe 45 chỗ', 'available', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `type` enum('danh_gia','su_co') NOT NULL DEFAULT 'danh_gia',
  `content` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `booking_id`, `type`, `content`, `created_at`) VALUES
(1, 3, 'danh_gia', 'Chuyến đi miền Tây rất tuyệt vời, HDV nhiệt tình.', '2025-12-02 14:29:16'),
(4, 2, 'danh_gia', 'Tour Thái Lan tổ chức tốt, lịch trình hợp lý.', '2025-12-02 14:29:16'),
(5, 1, 'danh_gia', 'Mong đợi chuyến đi Hạ Long sắp tới!', '2025-12-02 14:29:16');

-- --------------------------------------------------------

--
-- Table structure for table `guide`
--

CREATE TABLE `guide` (
  `guide_id` int NOT NULL,
  `user_id` int NOT NULL,
  `cccd` varchar(20) DEFAULT NULL,
  `language` varchar(100) DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL,
  `experience` text,
  `specialization` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guide`
--

INSERT INTO `guide` (`guide_id`, `user_id`, `cccd`, `language`, `certificate`, `experience`, `specialization`) VALUES
(1, 2, '001091000002', 'Tiếng Anh, Tiếng Pháp', 'Chứng chỉ Quốc tế', '5 năm kinh nghiệm du lịch Châu Âu', 'Du lịch Châu Âu'),
(2, 3, '001092000003', 'Tiếng Trung, Tiếng Hàn', 'Chứng chỉ Nội địa', '3 năm kinh nghiệm du lịch Đông Nam Á', 'Du lịch Đông Nam Á'),
(3, 4, '001093000004', 'Tiếng Anh', 'Chứng chỉ Quốc tế', '8 năm kinh nghiệm du lịch Miền Bắc Việt Nam', 'Du lịch Miền Bắc'),
(4, 5, '001094000005', 'Tiếng Nhật', 'Chứng chỉ Nội địa', '2 năm kinh nghiệm du lịch Nhật Bản', 'Du lịch Nhật Bản'),
(10, 1, '001090000001', 'Tiếng Anh', 'Chứng chỉ Quản lý', '2 năm kinh nghiệm quản lý', 'Quản lý tour');

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `hotel_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `manager_name` varchar(100) DEFAULT NULL,
  `manager_phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`hotel_id`, `name`, `address`, `manager_name`, `manager_phone`) VALUES
(1, 'Khách sạn Mường Thanh Hà Nội', 'Hà Nội', 'Đỗ Văn Cảnh', '0243111222'),
(2, 'Khách sạn A La Carte Hạ Long', 'Quảng Ninh', 'Nguyễn Thu Hoài', '0333444555'),
(3, 'Khách sạn Imperial Vũng Tàu', 'Vũng Tàu', 'Trần Bá Sơn', '0254666777'),
(4, 'Resort Novotel Phú Quốc', 'Kiên Giang', 'Phan Thị Mai', '0297888999'),
(5, 'Khách sạn Sapa Jade Hill', 'Lào Cai', 'Hoàng Văn Lực', '0214000111'),
(6, 'Khách sạn Mường Thanh Grand Cần Thơ', 'Cần Thơ', 'Lê Hữu Tín', '0292111222'),
(7, 'Khách sạn Sofitel Legend Metropole Hà Nội', 'Hà Nội', 'Vũ Thị Thanh', '0243222333'),
(8, 'Khách sạn InterContinental Đà Nẵng', 'Đà Nẵng', 'Đặng Quốc An', '0236333444'),
(9, 'Khách sạn Fusion Suites Đà Lạt', 'Lâm Đồng', 'Bùi Ngọc Thảo', '0263444555'),
(10, 'Khách sạn Majestic Sài Gòn', 'TP. Hồ Chí Minh', 'Mai Văn Tám', '028555666');

-- --------------------------------------------------------

--
-- Table structure for table `itinerary`
--

CREATE TABLE `itinerary` (
  `itinerary_id` int NOT NULL,
  `tour_id` int NOT NULL,
  `day_number` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `location` varchar(255) DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `itinerary`
--

INSERT INTO `itinerary` (`itinerary_id`, `tour_id`, `day_number`, `title`, `description`, `location`, `time_start`, `time_end`) VALUES
(1, 1, 1, 'Hà Nội: Tham quan Hồ Gươm, Đền Ngọc Sơn', 'Khám phá trung tâm thủ đô và thưởng thức ẩm thực đường phố.', 'Hà Nội', NULL, NULL),
(2, 1, 2, 'Vịnh Hạ Long: Du thuyền, Hang Sửng Sốt', 'Đi du thuyền khám phá Vịnh, chèo kayak.', 'Vịnh Hạ Long', '08:30:00', '18:00:00'),
(3, 2, 1, 'Bangkok: Cung điện Hoàng Gia, Chùa Vàng', 'Tham quan các điểm du lịch nổi tiếng tại Bangkok.', 'Bangkok', '09:00:00', '17:00:00'),
(4, 2, 3, 'Pattaya: Đảo San Hô Koh Larn', 'Tắm biển và tham gia các trò chơi trên biển.', 'Pattaya', '07:30:00', '16:00:00'),
(5, 3, 1, 'Cần Thơ: Chợ Nổi Cái Răng', 'Trải nghiệm nét văn hóa độc đáo của chợ nổi.', 'Cần Thơ', '05:00:00', '09:00:00'),
(6, 6, 2, 'Sapa: Chinh phục Fansipan', 'Đi cáp treo lên đỉnh Fansipan.', 'Sapa', '07:00:00', '14:00:00'),
(7, 8, 2, 'Phú Quốc: Vinpearl Safari, Bãi Sao', 'Tham quan khu bảo tồn động vật hoang dã và tắm biển.', 'Phú Quốc', '09:00:00', '17:00:00'),
(9, 4, 3, 'Seoul: Tháp Namsan', 'Ngắm toàn cảnh thành phố Seoul.', 'Seoul, Hàn Quốc', '18:00:00', '21:00:00'),
(10, 5, 2, 'Đà Nẵng: Bà Nà Hills', 'Khám phá khu du lịch Bà Nà Hills.', 'Đà Nẵng', '08:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(3, '0001_01_01_000000_create_users_table', 1),
(4, '0001_01_01_000001_create_cache_table', 1),
(5, '0001_01_01_000002_create_jobs_table', 1),
(6, '2026_01_21_082433_create_personal_access_tokens_table', 2);

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
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 13, 'auth_token', '4cd754a1ceef80bfb87451b4f88e1e2e598927df8f43d2703f82256e2f2a9dd9', '[\"*\"]', NULL, NULL, '2026-01-21 01:30:14', '2026-01-21 01:30:14'),
(3, 'App\\Models\\User', 12, 'auth_token', '2b42b026fbb7009b681ba3763d5f3c0c9fc3215463c255e5784f680a4bf8b6f4', '[\"*\"]', '2026-01-23 02:32:46', NULL, '2026-01-21 01:36:33', '2026-01-23 02:32:46'),
(4, 'App\\Models\\User', 13, 'auth_token', 'b48e283d944440ada8d939c8e39ae51276f9cff3487a7a0c9e160397c8cf05bc', '[\"*\"]', NULL, NULL, '2026-01-23 02:23:08', '2026-01-23 02:23:08'),
(5, 'App\\Models\\User', 13, 'auth_token', '8e233c2d16cd8fdb2bbac10a8a8d858796a0465be65c85bc956d5e0bdde65819', '[\"*\"]', NULL, NULL, '2026-01-23 02:29:09', '2026-01-23 02:29:09');

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
('nlUYnLde4Ux06qWwPQ0bWQjEXdEd9zNq1ABHQg95', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1l1VzE1TzVRWE9US1BoSFBTWVBsYTh2Q1JBVkY5bzhhdDZMelhtNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768982477);

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `tour_id` int NOT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `policy` text,
  `supplier` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `price` decimal(15,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`tour_id`, `category_id`, `name`, `description`, `policy`, `supplier`, `image`, `status`, `price`) VALUES
(1, 1, 'Hà Nội - Vịnh Hạ Long 4 Ngày 3 Đêm', 'Khám phá kỳ quan thiên nhiên thế giới Vịnh Hạ Long và thủ đô Hà Nội.', 'Chính sách hủy tour 7 ngày', 'VietTravel', 'hanoi_halong.jpg', 'active', 5500000.00),
(2, 2, 'Tour Thái Lan: Bangkok - Pattaya 5 Ngày 4 Đêm', 'Khám phá văn hóa độc đáo và bãi biển tuyệt đẹp của Thái Lan.', 'Chính sách visa và hộ chiếu', 'Saigontourist', 'thailand_bangkok.jpg', 'active', 12500000.00),
(3, 1, 'Du lịch Miền Tây: Cần Thơ - An Giang 3 Ngày 2 Đêm', 'Trải nghiệm cuộc sống sông nước và ẩm thực đặc trưng miền Tây.', 'Chính sách bảo hiểm du lịch', 'Fiditour', 'mientay_cantho.jpg', 'active', 3200000.00),
(4, 2, 'Tour Hàn Quốc: Seoul - Đảo Jeju 6 Ngày 5 Đêm', 'Khám phá thủ đô Seoul hiện đại và đảo Jeju thơ mộng.', 'Yêu cầu tiêm chủng quốc tế', 'Vietravel', 'korea_jeju.jpg', 'active', 18000000.00),
(5, 3, 'Tour Tự Chọn: Đà Nẵng - Hội An (theo yêu cầu)', 'Tùy chỉnh lịch trình và dịch vụ theo ý khách hàng.', 'Giá thay đổi theo dịch vụ', 'Lữ hành Xanh', 'danang_custom.jpg', 'active', 6000000.00),
(6, 1, 'Du lịch Sapa: Khám phá Fansipan 3 Ngày 2 Đêm', 'Chinh phục đỉnh Fansipan và trải nghiệm văn hóa dân tộc thiểu số.', 'Trang phục giữ ấm cần thiết', 'VietTravel', 'sapa_fansipan.jpg', 'active', 4500000.00),
(7, 2, 'Tour Châu Âu: Pháp - Bỉ - Hà Lan 10 Ngày 9 Đêm', 'Tham quan các thành phố cổ kính và nổi tiếng ở Châu Âu.', 'Yêu cầu visa Schengen', 'Saigontourist', 'europe_tours.jpg', 'inactive', 45000000.00),
(8, 1, 'Tour Phú Quốc 4 Ngày 3 Đêm', 'Thư giãn tại các bãi biển đẹp và khám phá đảo ngọc.', 'Chính sách trẻ em đi kèm', 'Fiditour', 'phuquoc_beach.jpg', 'active', 7500000.00);

-- --------------------------------------------------------

--
-- Table structure for table `tour_customer`
--

CREATE TABLE `tour_customer` (
  `id` int NOT NULL,
  `schedule_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `room_number` varchar(10) DEFAULT NULL,
  `checkin_status` enum('not_checked_in','checked_in') DEFAULT 'not_checked_in',
  `note` text,
  `attendance_status` enum('present','absent','unknown') DEFAULT 'unknown'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tour_customer`
--

INSERT INTO `tour_customer` (`id`, `schedule_id`, `customer_id`, `room_number`, `checkin_status`, `note`, `attendance_status`) VALUES
(1, 1, 1, '101', 'not_checked_in', 'Đi cùng vợ', 'unknown'),
(2, 1, 2, '101', 'not_checked_in', 'Vợ của Lê Văn An', 'unknown'),
(3, 2, 2, '205', 'checked_in', NULL, 'present'),
(4, 2, 4, '206', 'checked_in', NULL, 'present'),
(5, 3, 3, '301', 'checked_in', NULL, 'present'),
(6, 4, 4, '402', 'not_checked_in', 'Chuẩn bị đồ leo núi', 'unknown'),
(7, 5, 5, '501', 'checked_in', NULL, 'present'),
(8, 5, 6, '501', 'checked_in', 'Vợ của Hoàng Văn Em', 'present'),
(14, 13, 8, NULL, 'not_checked_in', NULL, 'unknown'),
(15, 13, 7, NULL, 'not_checked_in', NULL, 'unknown'),
(16, 13, 5, NULL, 'not_checked_in', NULL, 'unknown'),
(17, 1, 5, NULL, 'not_checked_in', NULL, 'unknown'),
(18, 17, 10, NULL, 'not_checked_in', NULL, 'unknown'),
(19, 17, 2, NULL, 'not_checked_in', NULL, 'unknown'),
(20, 18, 8, NULL, 'not_checked_in', NULL, 'unknown'),
(21, 18, 1, NULL, 'not_checked_in', NULL, 'unknown'),
(22, 18, 3, NULL, 'not_checked_in', NULL, 'unknown'),
(23, 18, 6, NULL, 'not_checked_in', NULL, 'unknown'),
(24, 13, 6, NULL, 'not_checked_in', NULL, 'unknown');

-- --------------------------------------------------------

--
-- Table structure for table `tour_hotel`
--

CREATE TABLE `tour_hotel` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `location` varchar(255) NOT NULL,
  `hotel_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tour_hotel`
--

INSERT INTO `tour_hotel` (`id`, `tour_id`, `location`, `hotel_id`) VALUES
(1, 1, 'Hà Nội', 1),
(2, 1, 'Hạ Long', 2),
(3, 3, 'Cần Thơ', 6),
(4, 6, 'Sapa', 5),
(5, 8, 'Phú Quốc', 4),
(7, 7, 'Paris', 7),
(9, 5, 'Đà Nẵng', 8),
(10, 2, 'Bangkok', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `role` enum('admin','tour_guide','user') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'user',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'active',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fullname`, `email`, `phone`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin_nhom5', '123456', 'Quản trị viên Nhóm 5', 'nhom5@gmail.com', '0900000001', 'admin', 'active', '2026-01-21 15:22:50', '2026-01-21 15:22:50'),
(2, 'hdv_nga', '123456', 'Nguyễn Thị Nga', 'nga.hdv@example.com', '0910000002', 'tour_guide', 'active', '2026-01-21 15:22:50', '2026-01-21 15:22:50'),
(3, 'hdv_binh', '123456', 'Trần Văn Bình', 'binh.hdv@example.com', '0920000003', 'tour_guide', 'active', '2026-01-21 15:22:50', '2026-01-21 15:22:50'),
(4, 'hdv_lan', '123456', 'Lê Thị Lan', 'lan.hdv@example.com', '0930000004', 'tour_guide', 'active', '2026-01-21 15:22:50', '2026-01-21 15:22:50'),
(5, 'hdv_hung', '123456', 'Phạm Quốc Hùng', 'hung.hdv@example.com', '0940000005', 'tour_guide', 'active', '2026-01-21 15:22:50', '2026-01-21 15:22:50'),
(12, 'john_doe', '$2y$12$7jCQwMlEtRlaPbtyYczdOuAZ7TtLGHbmZ0yq6J6amN25wXWllzZda', 'John Doe', 'john@example.com', '0123456789', 'user', 'active', '2026-01-21 08:23:10', '2026-01-21 08:23:10'),
(13, 'tuandat', '$2y$12$h4qYWyGJjP72NoEYVGXOfegLqLaeNtioFFbX90s73xlSMVIdLn.Cu', 'Tuan Dat', 'tuandathb102@gmail.com', '0123456789', 'user', 'active', '2026-01-21 08:30:14', '2026-01-21 08:30:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `tour_customer_id` (`tour_customer_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `schedule_id` (`schedule_id`);

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
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `departure_schedule`
--
ALTER TABLE `departure_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `guide_id` (`guide_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driver_id`);

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
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `guide`
--
ALTER TABLE `guide`
  ADD PRIMARY KEY (`guide_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`hotel_id`);

--
-- Indexes for table `itinerary`
--
ALTER TABLE `itinerary`
  ADD PRIMARY KEY (`itinerary_id`),
  ADD KEY `tour_id` (`tour_id`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tour_customer`
--
ALTER TABLE `tour_customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_id` (`schedule_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `tour_hotel`
--
ALTER TABLE `tour_hotel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `departure_schedule`
--
ALTER TABLE `departure_schedule`
  MODIFY `schedule_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `driver_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `guide`
--
ALTER TABLE `guide`
  MODIFY `guide_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `hotel_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `itinerary`
--
ALTER TABLE `itinerary`
  MODIFY `itinerary_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `tour_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tour_customer`
--
ALTER TABLE `tour_customer`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tour_hotel`
--
ALTER TABLE `tour_hotel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`schedule_id`) REFERENCES `departure_schedule` (`schedule_id`) ON DELETE CASCADE;

--
-- Constraints for table `departure_schedule`
--
ALTER TABLE `departure_schedule`
  ADD CONSTRAINT `departure_schedule_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departure_schedule_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `guide` (`guide_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `departure_schedule_ibfk_3` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`driver_id`) ON DELETE SET NULL;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE;

--
-- Constraints for table `guide`
--
ALTER TABLE `guide`
  ADD CONSTRAINT `guide_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `itinerary`
--
ALTER TABLE `itinerary`
  ADD CONSTRAINT `itinerary_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`) ON DELETE CASCADE;

--
-- Constraints for table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `tour_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `tour_customer`
--
ALTER TABLE `tour_customer`
  ADD CONSTRAINT `tour_customer_ibfk_1` FOREIGN KEY (`schedule_id`) REFERENCES `departure_schedule` (`schedule_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_customer_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE;

--
-- Constraints for table `tour_hotel`
--
ALTER TABLE `tour_hotel`
  ADD CONSTRAINT `tour_hotel_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tour` (`tour_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_hotel_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotel` (`hotel_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
