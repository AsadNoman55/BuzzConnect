-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2025 at 09:37 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buzzconnect`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `content`, `created_at`, `parent_id`) VALUES
(37, 12, 22, 'anaa', '2025-07-17 06:38:04', 0),
(38, 25, 24, 'great', '2025-08-02 07:07:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `follows`
--

CREATE TABLE `follows` (
  `id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follows`
--

INSERT INTO `follows` (`id`, `follower_id`, `followed_id`, `created_at`) VALUES
(725, 12, 11, '2025-07-16 14:44:56'),
(726, 13, 11, '2025-07-17 06:06:26'),
(727, 14, 11, '2025-07-17 06:08:58'),
(728, 15, 11, '2025-07-17 06:12:11'),
(729, 17, 16, '2025-07-17 06:26:41'),
(730, 18, 15, '2025-07-17 06:28:56'),
(731, 12, 18, '2025-07-17 07:02:46'),
(732, 16, 19, '2025-08-02 06:22:01'),
(734, 21, 19, '2025-08-02 06:47:38'),
(735, 17, 19, '2025-08-02 06:52:28'),
(736, 11, 19, '2025-08-02 06:55:16'),
(737, 12, 19, '2025-08-02 06:55:55'),
(738, 13, 19, '2025-08-02 06:57:32'),
(739, 14, 19, '2025-08-02 06:58:53'),
(740, 14, 18, '2025-08-02 07:00:33'),
(741, 15, 19, '2025-08-02 07:00:56'),
(742, 15, 18, '2025-08-02 07:02:49'),
(743, 18, 19, '2025-08-02 07:04:10'),
(744, 25, 19, '2025-08-02 07:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(50, 12, 22, '2025-07-17 06:32:17'),
(51, 16, 24, '2025-08-02 06:21:27'),
(52, 19, 25, '2025-08-02 06:23:53'),
(53, 21, 26, '2025-08-02 06:51:04'),
(54, 21, 24, '2025-08-02 06:51:40'),
(55, 17, 24, '2025-08-02 06:52:13'),
(56, 17, 27, '2025-08-02 06:53:13'),
(57, 17, 26, '2025-08-02 06:53:19'),
(58, 11, 24, '2025-08-02 06:55:26'),
(59, 11, 27, '2025-08-02 06:55:29'),
(60, 12, 24, '2025-08-02 06:56:05'),
(61, 13, 29, '2025-08-02 06:58:12'),
(62, 13, 27, '2025-08-02 06:58:16'),
(63, 13, 24, '2025-08-02 06:58:22'),
(64, 13, 26, '2025-08-02 06:58:30'),
(65, 14, 29, '2025-08-02 06:59:04'),
(66, 14, 27, '2025-08-02 06:59:07'),
(67, 14, 24, '2025-08-02 06:59:15'),
(68, 15, 30, '2025-08-02 07:01:04'),
(69, 15, 29, '2025-08-02 07:01:07'),
(70, 15, 27, '2025-08-02 07:01:13'),
(71, 15, 24, '2025-08-02 07:01:20'),
(72, 18, 31, '2025-08-02 07:03:34'),
(73, 18, 27, '2025-08-02 07:03:39'),
(74, 18, 24, '2025-08-02 07:03:46'),
(75, 18, 22, '2025-08-02 07:04:04'),
(76, 25, 31, '2025-08-02 07:06:53'),
(77, 25, 30, '2025-08-02 07:06:56'),
(78, 25, 29, '2025-08-02 07:07:00'),
(79, 25, 26, '2025-08-02 07:07:06'),
(80, 25, 24, '2025-08-02 07:07:11'),
(81, 25, 27, '2025-08-02 07:07:24'),
(82, 25, 28, '2025-08-02 07:07:30'),
(83, 25, 22, '2025-08-02 07:07:39'),
(84, 19, 32, '2025-08-02 07:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('follow','like','comment') NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `from_user_id`, `post_id`, `is_read`, `created_at`) VALUES
(693, 11, 'like', 12, NULL, 1, '2025-07-16 08:28:59'),
(694, 11, 'comment', 12, NULL, 1, '2025-07-16 08:29:11'),
(695, 11, 'like', 12, NULL, 1, '2025-07-16 08:44:05'),
(696, 11, 'like', 12, NULL, 1, '2025-07-16 13:41:48'),
(697, 11, 'like', 12, NULL, 1, '2025-07-16 13:42:21'),
(698, 11, 'like', 12, NULL, 1, '2025-07-16 13:45:52'),
(699, 11, 'like', 12, NULL, 1, '2025-07-16 13:49:39'),
(700, 11, 'like', 12, NULL, 1, '2025-07-16 13:53:30'),
(701, 11, 'like', 12, NULL, 1, '2025-07-16 13:53:59'),
(702, 11, 'follow', 12, NULL, 1, '2025-07-16 14:44:56'),
(703, 12, 'like', 11, NULL, 1, '2025-07-16 14:57:36'),
(704, 12, 'comment', 11, NULL, 1, '2025-07-16 14:58:09'),
(705, 12, 'like', 11, NULL, 1, '2025-07-16 17:17:41'),
(706, 12, 'comment', 11, NULL, 1, '2025-07-16 17:25:00'),
(707, 12, 'comment', 11, NULL, 1, '2025-07-17 04:11:30'),
(708, 12, 'comment', 11, NULL, 1, '2025-07-17 04:11:36'),
(709, 11, 'comment', 12, NULL, 1, '2025-07-17 04:19:51'),
(710, 11, 'comment', 12, NULL, 1, '2025-07-17 04:22:13'),
(711, 11, 'comment', 12, NULL, 1, '2025-07-17 05:12:18'),
(712, 11, 'follow', 13, NULL, 1, '2025-07-17 06:06:26'),
(713, 11, 'follow', 14, NULL, 1, '2025-07-17 06:08:58'),
(714, 11, 'follow', 15, NULL, 1, '2025-07-17 06:12:11'),
(715, 16, 'follow', 17, NULL, 1, '2025-07-17 06:26:41'),
(716, 15, 'follow', 18, NULL, 1, '2025-07-17 06:28:56'),
(717, 11, 'like', 12, 22, 1, '2025-07-17 06:32:17'),
(718, 11, 'comment', 12, 22, 1, '2025-07-17 06:32:26'),
(719, 11, 'comment', 12, 22, 1, '2025-07-17 06:38:04'),
(720, 18, 'follow', 12, NULL, 1, '2025-07-17 07:02:46'),
(721, 19, 'like', 16, 24, 1, '2025-08-02 06:21:27'),
(722, 19, 'follow', 16, NULL, 1, '2025-08-02 06:22:01'),
(723, 16, 'like', 19, 25, 1, '2025-08-02 06:23:53'),
(725, 19, 'follow', 21, NULL, 1, '2025-08-02 06:47:38'),
(726, 20, 'like', 21, 26, 0, '2025-08-02 06:51:04'),
(727, 19, 'like', 21, 24, 0, '2025-08-02 06:51:40'),
(728, 19, 'like', 17, 24, 0, '2025-08-02 06:52:13'),
(729, 19, 'follow', 17, NULL, 0, '2025-08-02 06:52:28'),
(730, 21, 'like', 17, 27, 0, '2025-08-02 06:53:13'),
(731, 20, 'like', 17, 26, 0, '2025-08-02 06:53:19'),
(732, 19, 'follow', 11, NULL, 0, '2025-08-02 06:55:16'),
(733, 19, 'like', 11, 24, 0, '2025-08-02 06:55:26'),
(734, 21, 'like', 11, 27, 0, '2025-08-02 06:55:29'),
(735, 19, 'follow', 12, NULL, 0, '2025-08-02 06:55:55'),
(736, 19, 'like', 12, 24, 0, '2025-08-02 06:56:05'),
(737, 19, 'follow', 13, NULL, 0, '2025-08-02 06:57:32'),
(738, 12, 'like', 13, 29, 0, '2025-08-02 06:58:12'),
(739, 21, 'like', 13, 27, 0, '2025-08-02 06:58:16'),
(740, 19, 'like', 13, 24, 0, '2025-08-02 06:58:22'),
(741, 20, 'like', 13, 26, 0, '2025-08-02 06:58:30'),
(742, 19, 'follow', 14, NULL, 0, '2025-08-02 06:58:53'),
(743, 12, 'like', 14, 29, 0, '2025-08-02 06:59:04'),
(744, 21, 'like', 14, 27, 0, '2025-08-02 06:59:07'),
(745, 19, 'like', 14, 24, 0, '2025-08-02 06:59:15'),
(746, 18, 'follow', 14, NULL, 1, '2025-08-02 07:00:33'),
(747, 19, 'follow', 15, NULL, 0, '2025-08-02 07:00:56'),
(748, 14, 'like', 15, 30, 0, '2025-08-02 07:01:04'),
(749, 12, 'like', 15, 29, 0, '2025-08-02 07:01:07'),
(750, 21, 'like', 15, 27, 0, '2025-08-02 07:01:13'),
(751, 19, 'like', 15, 24, 0, '2025-08-02 07:01:20'),
(752, 18, 'follow', 15, NULL, 1, '2025-08-02 07:02:49'),
(753, 15, 'like', 18, 31, 0, '2025-08-02 07:03:34'),
(754, 21, 'like', 18, 27, 0, '2025-08-02 07:03:39'),
(755, 19, 'like', 18, 24, 0, '2025-08-02 07:03:46'),
(756, 11, 'like', 18, 22, 0, '2025-08-02 07:04:04'),
(757, 19, 'follow', 18, NULL, 0, '2025-08-02 07:04:10'),
(758, 19, 'follow', 25, NULL, 0, '2025-08-02 07:06:36'),
(759, 15, 'like', 25, 31, 0, '2025-08-02 07:06:53'),
(760, 14, 'like', 25, 30, 0, '2025-08-02 07:06:56'),
(761, 12, 'like', 25, 29, 0, '2025-08-02 07:07:00'),
(762, 20, 'like', 25, 26, 0, '2025-08-02 07:07:06'),
(763, 19, 'like', 25, 24, 0, '2025-08-02 07:07:11'),
(764, 21, 'like', 25, 27, 0, '2025-08-02 07:07:24'),
(765, 17, 'like', 25, 28, 0, '2025-08-02 07:07:30'),
(766, 11, 'like', 25, 22, 0, '2025-08-02 07:07:39'),
(767, 19, 'comment', 25, 24, 0, '2025-08-02 07:07:55'),
(768, 25, 'like', 19, 32, 0, '2025-08-02 07:22:29');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `image`, `created_at`) VALUES
(22, 11, 'blue', '6878986368654_Snapinsta.app_384445519_1973781246327365_607826738759526594_n_1080.jpg', '2025-07-17 06:29:55'),
(24, 19, 'Getting Ready', '688dadea523df_e72c101147380b5e0fc0411f391fa647.jpg', '2025-08-02 06:19:22'),
(25, 16, 'hala', '688daee06f501_Snapinsta.app_443277926_1131322038108213_8262653366200657246_n_1080.jpg', '2025-08-02 06:23:28'),
(26, 20, 'black', '688db0aaa1e6a_Saree Look Hania Amir.jpeg', '2025-08-02 06:31:06'),
(27, 21, 'beautiful', '688db576016dd_wp13550281-laiba-khan-wallpapers.jpg', '2025-08-02 06:51:34'),
(28, 17, 'whoo', '688db5d2a30d0_Snapinsta.app_421977468_18404554798028992_120555980309256075_n_1080.jpg', '2025-08-02 06:53:06'),
(29, 12, 'guzel', '688db6b5f20bb_Snapinsta.app_355119843_780638046866816_6352151012197968637_n_1080.jpg', '2025-08-02 06:56:53'),
(30, 14, 'guzel', '688db76c2a143_Snapinsta.app_449780827_18449835598021594_618579322215684911_n_1080.jpg', '2025-08-02 06:59:56'),
(31, 15, 'guzel', '688db80c5fc9e_Snapinsta.app_296077286_184845707247812_333159854262140356_n_1080.jpg', '2025-08-02 07:02:36'),
(32, 25, 'white', '688db995bb4cd_1712290284401.jpg', '2025-08-02 07:09:09'),
(33, 19, 'gearing up', '688dbc1b920df_gettyimages-2156775068-2048x2048.jpg', '2025-08-02 07:19:55'),
(34, 19, 'toss', '688dbc2ed5aec_gettyimages-1734988444-2048x2048.jpg', '2025-08-02 07:20:14'),
(35, 19, 'getting ready', '688dbc45b6533_gettyimages-1727326758-2048x2048.jpg', '2025-08-02 07:20:37'),
(36, 19, 'Final', '688dbc5803756_gettyimages-1440911242-2048x2048.jpg', '2025-08-02 07:20:56'),
(37, 19, 'WINNIG MOMENT', '688dbc6c2c403_gettyimages-1348632602-2048x2048.jpg', '2025-08-02 07:21:16');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `reported_by` int(11) NOT NULL,
  `reason` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_token` varchar(255) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `bio` text DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user',
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `bio`, `profile_pic`, `created_at`, `role`, `name`) VALUES
(3, NULL, 'admin', 'admin@buzzconnect.com', '$2y$10$vl2kbkMtsZNJJR.WcWJqu.EyqdtMe3/wzMaN0W0Yr3aCD1DSUrUwe', NULL, NULL, '2025-07-11 09:39:15', 'admin', NULL),
(11, 'ozgetorer', 'ozgetorer', 'ozgetorerr786@gmail.com', '$2y$10$p0gEvkXNTk/xcBhUPczsfe0uv3MQGry29gEyhpVxnNNtLn9C3VIuq', 'Turkish Actress and Model', '68776213bd1ed_Snapinsta.app_462838018_918252307019036_8598554139803300828_n_1080.jpg', '2025-07-16 08:23:38', 'user', 'ozgetorer'),
(12, 'leyakirsan', 'leyakirsan', 'leyakirsan786@gmail.com', '$2y$10$hLc3oSWrltFaQ6tRstGd5.tuXgU9oevonk3eWcIFKfaZSP2QfSQ92', 'Turkish actress and Model', '687762b869dde_Snapinsta.app_432664971_778573400847279_8746258219876300633_n_1080.jpg', '2025-07-16 08:27:29', 'user', 'leyakirsan'),
(13, 'ecemsbayir', 'ecemsbayir', 'ecemsbayir786@gmail.com', '$2y$10$gKKT7.tnzM8uxSw1Lmof6.tDNUjV8yTaFHyCqeBhOJ/r3UT.Lvaf.', 'Turkish Actress and Model', '687892c7d0188_Snapinsta.app_447641325_18442672243032204_405609226497290828_n_1080.jpg', '2025-07-17 05:45:04', 'user', 'ecemsbayir'),
(14, 'bucekahraman', 'bucekahraman', 'bucekahraman786@gmail.com', '$2y$10$UH4/wMfuoSLRKvLTFudxcODCmuD2Z2B9UhZNxhCZ7UFus8UtN4PbW', 'Turkish Actress and Model', '6878936ec2b51_Snapinsta.app_455692867_18457693567021594_5893728168079028331_n_1080.jpg', '2025-07-17 06:07:51', 'user', 'bucekahraman'),
(15, 'fahriyeevcen', 'fahriyeevcen', 'fahriyeevcen786@gmail.com', '$2y$10$j7WjOdKMFD0HUsOk3Y5MPe6MWqodfgAuVCpYrDBghgEJyZs39YJZ2', 'Turkish Actress and Model', '68789429cb10a_Snapinsta.app_204769518_184750510316415_3605897138639135129_n_1080.jpg', '2025-07-17 06:10:44', 'user', 'fahriyeevcen'),
(16, 'ainaasif', 'ainaasif', 'ainaasif786@gmail.com', '$2y$10$pod2uauiSSJUuV3K9no5xefDByv4zV0A1.b4L5YXIRHbr5C8gnvR.', 'Pakistani Actress and Model', '6878958948490_Snapinsta.app_412002148_304163309278409_5849028169833544987_n_1080.jpg', '2025-07-17 06:16:23', 'user', 'ainaasif'),
(17, 'yumnazaidi', 'yumnazaidi', 'yumnazaidi786@gmail.com', '$2y$10$syIX5AWyDUIZD2G6vKXi7eYnzmOFWUop4dbNiMExfGtesO1.FQyda', 'Pakistani Actress and Model', '6878979575359_Snapinsta.app_420990395_18401909434028992_4285011395922620761_n_1080.jpg', '2025-07-17 06:25:29', 'user', 'yumnazaidi'),
(18, 'burakozjivit', 'burakozjivit', 'burakozjivit786@gmail.com', '$2y$10$xiH1kQ9Vupm7V.7SeGohyONrEP3Fg5gPKO6qSkLl2SaYyQYVMXJr2', 'Turkish Actor and Model', '6878981ab0929_Snapinsta.app_449657063_452806527476426_807601394894992279_n_1080.jpg', '2025-07-17 06:27:33', 'user', 'burakozjivit'),
(19, 'Babar Azam', 'Babar Azam', 'babarazam@gmail.com', '$2y$10$322x3RTrKRcjuy7rgRo1penouAlneYU/nVFRLCsiIfpLQ7Rw4LOdO', 'Pakistan international Cricketer', '688dac64cbc23_images.jpg', '2025-08-02 06:08:04', 'user', 'Babar Azam'),
(20, 'hania amir', 'hania amir', 'haniaamir@gmail.com', '$2y$10$P1Tw5pBSX7TfEx08pSYuR.VMTCDYH5NC7M0lE8wMHLSAzI26yJQKu', 'Pakistani Actress And Model', '688dafc60ff53_wp6642238-hania-amir-wallpapers.jpg', '2025-08-02 06:24:48', 'user', 'Hania Aamir'),
(21, 'Laiba Khan', 'Laiba Khan', 'laibaKhan786@gmail.com', '$2y$10$j4rwE6yB6qySMvPBYaQLBOAs8JOwtSAmj.6Mq7iiqzxF0piKxhxtG', 'Pakiatani Actress And Model', '688db5196473a_wp13550338-laiba-khan-wallpapers.jpg', '2025-08-02 06:32:52', 'user', 'Laiba Khan'),
(22, 'Asad Noman', 'asadnoman', 'asadnoman055@gmail.com', '$2y$10$B4/5kUcHslnxUIVf3EZO6Ob/kgIg4.sPH7ousBKxDFgFvLST3jkbq', NULL, NULL, '2025-08-02 07:05:11', 'user', NULL),
(25, 'Asad Noman', 'asadnoman99', 'asadnoman786@gmail.com', '$2y$10$X1GW2RxG4bX3dHUwfcb2Retqxqgey6oR6/sklwcufrY9Vk7b6ZWV.', 'Web Developer And CS Graduate', '688dbd3820c7e_IMG_2780.JPG', '2025-08-02 07:06:14', 'user', 'Asad Noman');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `follower_id` (`follower_id`,`followed_id`),
  ADD KEY `followed_id` (`followed_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `from_user_id` (`from_user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reported_by` (`reported_by`),
  ADD KEY `reports_ibfk_1` (`post_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `follows`
--
ALTER TABLE `follows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=745;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=769;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_ibfk_2` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
