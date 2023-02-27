-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 03, 2021 at 05:15 PM
-- Server version: 10.3.28-MariaDB-log-cll-lve
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `instakuv_ponzi`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sortname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phonecode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default_flag.png',
  `status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT 'unpublished',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `sortname`, `name`, `phonecode`, `flag`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AF', 'Afghanistan', '93', 'default_flag.png', 'unpublished', NULL, '2020-03-24 21:43:16'),
(2, 'AL', 'Albania', '355', 'default_flag.png', 'unpublished', NULL, NULL),
(3, 'DZ', 'Algeria', '213', 'default_flag.png', 'unpublished', NULL, NULL),
(4, 'AS', 'American Samoa', '1684', 'default_flag.png', 'unpublished', NULL, NULL),
(5, 'AD', 'Andorra', '376', 'default_flag.png', 'unpublished', NULL, NULL),
(6, 'AO', 'Angola', '244', 'default_flag.png', 'unpublished', NULL, NULL),
(7, 'AI', 'Anguilla', '1264', 'default_flag.png', 'unpublished', NULL, NULL),
(8, 'AQ', 'Antarctica', '0', 'default_flag.png', 'unpublished', NULL, NULL),
(9, 'AG', 'Antigua And Barbuda', '1268', 'default_flag.png', 'unpublished', NULL, NULL),
(10, 'AR', 'Argentina', '54', 'default_flag.png', 'unpublished', NULL, NULL),
(11, 'AM', 'Armenia', '374', 'default_flag.png', 'unpublished', NULL, NULL),
(12, 'AW', 'Aruba', '297', 'default_flag.png', 'unpublished', NULL, NULL),
(13, 'AU', 'Australia', '61', 'default_flag.png', 'published', NULL, '2020-03-25 14:59:32'),
(14, 'AT', 'Austria', '43', 'default_flag.png', 'published', NULL, '2020-03-25 14:59:33'),
(15, 'AZ', 'Azerbaijan', '994', 'default_flag.png', 'unpublished', NULL, NULL),
(16, 'BS', 'Bahamas The', '1242', 'default_flag.png', 'unpublished', NULL, NULL),
(17, 'BH', 'Bahrain', '973', 'default_flag.png', 'unpublished', NULL, NULL),
(18, 'BD', 'Bangladesh', '880', 'default_flag.png', 'unpublished', NULL, NULL),
(19, 'BB', 'Barbados', '1246', 'default_flag.png', 'unpublished', NULL, NULL),
(20, 'BY', 'Belarus', '375', 'default_flag.png', 'unpublished', NULL, NULL),
(21, 'BE', 'Belgium', '32', 'default_flag.png', 'unpublished', NULL, NULL),
(22, 'BZ', 'Belize', '501', 'default_flag.png', 'unpublished', NULL, NULL),
(23, 'BJ', 'Benin', '229', 'default_flag.png', 'unpublished', NULL, NULL),
(24, 'BM', 'Bermuda', '1441', 'default_flag.png', 'unpublished', NULL, NULL),
(25, 'BT', 'Bhutan', '975', 'default_flag.png', 'unpublished', NULL, NULL),
(26, 'BO', 'Bolivia', '591', 'default_flag.png', 'unpublished', NULL, NULL),
(27, 'BA', 'Bosnia and Herzegovina', '387', 'default_flag.png', 'unpublished', NULL, NULL),
(28, 'BW', 'Botswana', '267', 'default_flag.png', 'unpublished', NULL, NULL),
(29, 'BV', 'Bouvet Island', '0', 'default_flag.png', 'unpublished', NULL, NULL),
(30, 'BR', 'Brazil', '55', 'default_flag.png', 'published', NULL, '2020-04-11 16:58:50'),
(31, 'IO', 'British Indian Ocean Territory', '246', 'default_flag.png', 'unpublished', NULL, NULL),
(32, 'BN', 'Brunei', '673', 'default_flag.png', 'unpublished', NULL, NULL),
(33, 'BG', 'Bulgaria', '359', 'default_flag.png', 'unpublished', NULL, NULL),
(34, 'BF', 'Burkina Faso', '226', 'default_flag.png', 'unpublished', NULL, NULL),
(35, 'BI', 'Burundi', '257', 'default_flag.png', 'unpublished', NULL, NULL),
(36, 'KH', 'Cambodia', '855', 'default_flag.png', 'unpublished', NULL, NULL),
(37, 'CM', 'Cameroon', '237', 'default_flag.png', 'published', NULL, '2020-03-25 14:56:49'),
(38, 'CA', 'Canada', '1', 'default_flag.png', 'published', NULL, '2020-03-25 15:01:25'),
(39, 'CV', 'Cape Verde', '238', 'default_flag.png', 'unpublished', NULL, NULL),
(40, 'KY', 'Cayman Islands', '1345', 'default_flag.png', 'unpublished', NULL, NULL),
(41, 'CF', 'Central African Republic', '236', 'default_flag.png', 'unpublished', NULL, NULL),
(42, 'TD', 'Chad', '235', 'default_flag.png', 'unpublished', NULL, NULL),
(43, 'CL', 'Chile', '56', 'default_flag.png', 'unpublished', NULL, NULL),
(44, 'CN', 'China', '86', 'default_flag.png', 'published', NULL, '2020-03-25 14:58:34'),
(45, 'CX', 'Christmas Island', '61', 'default_flag.png', 'unpublished', NULL, NULL),
(46, 'CC', 'Cocos (Keeling) Islands', '672', 'default_flag.png', 'unpublished', NULL, NULL),
(47, 'CO', 'Colombia', '57', 'default_flag.png', 'unpublished', NULL, NULL),
(48, 'KM', 'Comoros', '269', 'default_flag.png', 'unpublished', NULL, NULL),
(49, 'CG', 'Republic Of The Congo', '242', 'default_flag.png', 'unpublished', NULL, NULL),
(50, 'CD', 'Democratic Republic Of The Congo', '242', 'default_flag.png', 'unpublished', NULL, NULL),
(51, 'CK', 'Cook Islands', '682', 'default_flag.png', 'unpublished', NULL, NULL),
(52, 'CR', 'Costa Rica', '506', 'default_flag.png', 'unpublished', NULL, NULL),
(53, 'CI', 'Cote D\'Ivoire (Ivory Coast)', '225', 'default_flag.png', 'unpublished', NULL, NULL),
(54, 'HR', 'Croatia (Hrvatska)', '385', 'default_flag.png', 'unpublished', NULL, NULL),
(55, 'CU', 'Cuba', '53', 'default_flag.png', 'unpublished', NULL, NULL),
(56, 'CY', 'Cyprus', '357', 'default_flag.png', 'unpublished', NULL, NULL),
(57, 'CZ', 'Czech Republic', '420', 'default_flag.png', 'unpublished', NULL, NULL),
(58, 'DK', 'Denmark', '45', 'default_flag.png', 'published', NULL, '2020-04-11 16:59:00'),
(59, 'DJ', 'Djibouti', '253', 'default_flag.png', 'unpublished', NULL, NULL),
(60, 'DM', 'Dominica', '1767', 'default_flag.png', 'unpublished', NULL, NULL),
(61, 'DO', 'Dominican Republic', '1809', 'default_flag.png', 'published', NULL, '2020-04-11 16:59:15'),
(62, 'TP', 'East Timor', '670', 'default_flag.png', 'unpublished', NULL, NULL),
(63, 'EC', 'Ecuador', '593', 'default_flag.png', 'unpublished', NULL, NULL),
(64, 'EG', 'Egypt', '20', 'default_flag.png', 'unpublished', NULL, NULL),
(65, 'SV', 'El Salvador', '503', 'default_flag.png', 'unpublished', NULL, NULL),
(66, 'GQ', 'Equatorial Guinea', '240', 'default_flag.png', 'unpublished', NULL, NULL),
(67, 'ER', 'Eritrea', '291', 'default_flag.png', 'unpublished', NULL, NULL),
(68, 'EE', 'Estonia', '372', 'default_flag.png', 'unpublished', NULL, NULL),
(69, 'ET', 'Ethiopia', '251', 'default_flag.png', 'unpublished', NULL, NULL),
(70, 'XA', 'External Territories of Australia', '61', 'default_flag.png', 'unpublished', NULL, NULL),
(71, 'FK', 'Falkland Islands', '500', 'default_flag.png', 'unpublished', NULL, NULL),
(72, 'FO', 'Faroe Islands', '298', 'default_flag.png', 'unpublished', NULL, NULL),
(73, 'FJ', 'Fiji Islands', '679', 'default_flag.png', 'unpublished', NULL, NULL),
(74, 'FI', 'Finland', '358', 'default_flag.png', 'unpublished', NULL, NULL),
(75, 'FR', 'France', '33', 'default_flag.png', 'published', NULL, '2020-03-25 14:56:59'),
(76, 'GF', 'French Guiana', '594', 'default_flag.png', 'unpublished', NULL, NULL),
(77, 'PF', 'French Polynesia', '689', 'default_flag.png', 'unpublished', NULL, NULL),
(78, 'TF', 'French Southern Territories', '0', 'default_flag.png', 'unpublished', NULL, NULL),
(79, 'GA', 'Gabon', '241', 'default_flag.png', 'unpublished', NULL, NULL),
(80, 'GM', 'Gambia The', '220', 'default_flag.png', 'unpublished', NULL, NULL),
(81, 'GE', 'Georgia', '995', 'default_flag.png', 'unpublished', NULL, NULL),
(82, 'DE', 'Germany', '49', 'default_flag.png', 'published', NULL, '2020-03-25 14:55:51'),
(83, 'GH', 'Ghana', '233', 'gh_flag.png', 'published', NULL, NULL),
(84, 'GI', 'Gibraltar', '350', 'default_flag.png', 'unpublished', NULL, NULL),
(85, 'GR', 'Greece', '30', 'default_flag.png', 'unpublished', NULL, NULL),
(86, 'GL', 'Greenland', '299', 'default_flag.png', 'unpublished', NULL, NULL),
(87, 'GD', 'Grenada', '1473', 'default_flag.png', 'unpublished', NULL, NULL),
(88, 'GP', 'Guadeloupe', '590', 'default_flag.png', 'unpublished', NULL, NULL),
(89, 'GU', 'Guam', '1671', 'default_flag.png', 'unpublished', NULL, NULL),
(90, 'GT', 'Guatemala', '502', 'default_flag.png', 'unpublished', NULL, NULL),
(91, 'XU', 'Guernsey and Alderney', '44', 'default_flag.png', 'unpublished', NULL, NULL),
(92, 'GN', 'Guinea', '224', 'default_flag.png', 'unpublished', NULL, NULL),
(93, 'GW', 'Guinea-Bissau', '245', 'default_flag.png', 'unpublished', NULL, NULL),
(94, 'GY', 'Guyana', '592', 'default_flag.png', 'unpublished', NULL, NULL),
(95, 'HT', 'Haiti', '509', 'default_flag.png', 'unpublished', NULL, NULL),
(96, 'HM', 'Heard and McDonald Islands', '0', 'default_flag.png', 'unpublished', NULL, NULL),
(97, 'HN', 'Honduras', '504', 'default_flag.png', 'unpublished', NULL, NULL),
(98, 'HK', 'Hong Kong S.A.R.', '852', 'default_flag.png', 'unpublished', NULL, NULL),
(99, 'HU', 'Hungary', '36', 'default_flag.png', 'unpublished', NULL, NULL),
(100, 'IS', 'Iceland', '354', 'default_flag.png', 'unpublished', NULL, NULL),
(101, 'IN', 'India', '91', 'default_flag.png', 'published', NULL, '2020-03-25 14:55:13'),
(102, 'ID', 'Indonesia', '62', 'default_flag.png', 'unpublished', NULL, NULL),
(103, 'IR', 'Iran', '98', 'default_flag.png', 'unpublished', NULL, NULL),
(104, 'IQ', 'Iraq', '964', 'default_flag.png', 'unpublished', NULL, NULL),
(105, 'IE', 'Ireland', '353', 'default_flag.png', 'unpublished', NULL, NULL),
(106, 'IL', 'Israel', '972', 'default_flag.png', 'unpublished', NULL, NULL),
(107, 'IT', 'Italy', '39', 'default_flag.png', 'published', NULL, '2020-03-25 14:55:26'),
(108, 'JM', 'Jamaica', '1876', 'default_flag.png', 'unpublished', NULL, NULL),
(109, 'JP', 'Japan', '81', 'default_flag.png', 'published', NULL, '2020-04-11 10:31:02'),
(110, 'XJ', 'Jersey', '44', 'default_flag.png', 'unpublished', NULL, NULL),
(111, 'JO', 'Jordan', '962', 'default_flag.png', 'unpublished', NULL, NULL),
(112, 'KZ', 'Kazakhstan', '7', 'default_flag.png', 'unpublished', NULL, NULL),
(113, 'KE', 'Kenya', '254', 'default_flag.png', 'published', NULL, '2020-03-25 14:57:58'),
(114, 'KI', 'Kiribati', '686', 'default_flag.png', 'unpublished', NULL, NULL),
(115, 'KP', 'Korea North', '850', 'default_flag.png', 'unpublished', NULL, NULL),
(116, 'KR', 'Korea South', '82', 'default_flag.png', 'unpublished', NULL, NULL),
(117, 'KW', 'Kuwait', '965', 'default_flag.png', 'published', NULL, '2020-04-14 01:50:56'),
(118, 'KG', 'Kyrgyzstan', '996', 'default_flag.png', 'unpublished', NULL, NULL),
(119, 'LA', 'Laos', '856', 'default_flag.png', 'unpublished', NULL, NULL),
(120, 'LV', 'Latvia', '371', 'default_flag.png', 'unpublished', NULL, NULL),
(121, 'LB', 'Lebanon', '961', 'default_flag.png', 'unpublished', NULL, NULL),
(122, 'LS', 'Lesotho', '266', 'default_flag.png', 'unpublished', NULL, NULL),
(123, 'LR', 'Liberia', '231', 'default_flag.png', 'unpublished', NULL, NULL),
(124, 'LY', 'Libya', '218', 'default_flag.png', 'unpublished', NULL, NULL),
(125, 'LI', 'Liechtenstein', '423', 'default_flag.png', 'unpublished', NULL, NULL),
(126, 'LT', 'Lithuania', '370', 'default_flag.png', 'unpublished', NULL, NULL),
(127, 'LU', 'Luxembourg', '352', 'default_flag.png', 'unpublished', NULL, NULL),
(128, 'MO', 'Macau S.A.R.', '853', 'default_flag.png', 'unpublished', NULL, NULL),
(129, 'MK', 'Macedonia', '389', 'default_flag.png', 'unpublished', NULL, NULL),
(130, 'MG', 'Madagascar', '261', 'default_flag.png', 'unpublished', NULL, NULL),
(131, 'MW', 'Malawi', '265', 'default_flag.png', 'unpublished', NULL, NULL),
(132, 'MY', 'Malaysia', '60', 'default_flag.png', 'unpublished', NULL, NULL),
(133, 'MV', 'Maldives', '960', 'default_flag.png', 'unpublished', NULL, NULL),
(134, 'ML', 'Mali', '223', 'default_flag.png', 'published', NULL, '2020-03-25 14:57:46'),
(135, 'MT', 'Malta', '356', 'default_flag.png', 'unpublished', NULL, NULL),
(136, 'XM', 'Man (Isle of)', '44', 'default_flag.png', 'unpublished', NULL, NULL),
(137, 'MH', 'Marshall Islands', '692', 'default_flag.png', 'unpublished', NULL, NULL),
(138, 'MQ', 'Martinique', '596', 'default_flag.png', 'unpublished', NULL, NULL),
(139, 'MR', 'Mauritania', '222', 'default_flag.png', 'unpublished', NULL, NULL),
(140, 'MU', 'Mauritius', '230', 'default_flag.png', 'unpublished', NULL, NULL),
(141, 'YT', 'Mayotte', '269', 'default_flag.png', 'unpublished', NULL, NULL),
(142, 'MX', 'Mexico', '52', 'default_flag.png', 'published', NULL, '2020-04-11 10:30:18'),
(143, 'FM', 'Micronesia', '691', 'default_flag.png', 'unpublished', NULL, NULL),
(144, 'MD', 'Moldova', '373', 'default_flag.png', 'unpublished', NULL, NULL),
(145, 'MC', 'Monaco', '377', 'default_flag.png', 'unpublished', NULL, NULL),
(146, 'MN', 'Mongolia', '976', 'default_flag.png', 'unpublished', NULL, NULL),
(147, 'MS', 'Montserrat', '1664', 'default_flag.png', 'unpublished', NULL, NULL),
(148, 'MA', 'Morocco', '212', 'default_flag.png', 'unpublished', NULL, NULL),
(149, 'MZ', 'Mozambique', '258', 'default_flag.png', 'unpublished', NULL, NULL),
(150, 'MM', 'Myanmar', '95', 'default_flag.png', 'unpublished', NULL, NULL),
(151, 'NA', 'Namibia', '264', 'default_flag.png', 'unpublished', NULL, NULL),
(152, 'NR', 'Nauru', '674', 'default_flag.png', 'unpublished', NULL, NULL),
(153, 'NP', 'Nepal', '977', 'default_flag.png', 'unpublished', NULL, NULL),
(154, 'AN', 'Netherlands Antilles', '599', 'default_flag.png', 'unpublished', NULL, NULL),
(155, 'NL', 'Netherlands The', '31', 'default_flag.png', 'unpublished', NULL, NULL),
(156, 'NC', 'New Caledonia', '687', 'default_flag.png', 'unpublished', NULL, NULL),
(157, 'NZ', 'New Zealand', '64', 'default_flag.png', 'unpublished', NULL, NULL),
(158, 'NI', 'Nicaragua', '505', 'default_flag.png', 'unpublished', NULL, NULL),
(159, 'NE', 'Niger', '227', 'default_flag.png', 'unpublished', NULL, NULL),
(160, 'NG', 'Nigeria', '234', 'ng_flag.png', 'published', NULL, NULL),
(161, 'NU', 'Niue', '683', 'default_flag.png', 'unpublished', NULL, NULL),
(162, 'NF', 'Norfolk Island', '672', 'default_flag.png', 'unpublished', NULL, NULL),
(163, 'MP', 'Northern Mariana Islands', '1670', 'default_flag.png', 'unpublished', NULL, NULL),
(164, 'NO', 'Norway', '47', 'default_flag.png', 'unpublished', NULL, NULL),
(165, 'OM', 'Oman', '968', 'default_flag.png', 'unpublished', NULL, NULL),
(166, 'PK', 'Pakistan', '92', 'default_flag.png', 'unpublished', NULL, NULL),
(167, 'PW', 'Palau', '680', 'default_flag.png', 'unpublished', NULL, NULL),
(168, 'PS', 'Palestinian Territory Occupied', '970', 'default_flag.png', 'unpublished', NULL, NULL),
(169, 'PA', 'Panama', '507', 'default_flag.png', 'unpublished', NULL, NULL),
(170, 'PG', 'Papua new Guinea', '675', 'default_flag.png', 'unpublished', NULL, NULL),
(171, 'PY', 'Paraguay', '595', 'default_flag.png', 'unpublished', NULL, NULL),
(172, 'PE', 'Peru', '51', 'default_flag.png', 'unpublished', NULL, NULL),
(173, 'PH', 'Philippines', '63', 'default_flag.png', 'unpublished', NULL, NULL),
(174, 'PN', 'Pitcairn Island', '0', 'default_flag.png', 'unpublished', NULL, NULL),
(175, 'PL', 'Poland', '48', 'default_flag.png', 'unpublished', NULL, NULL),
(176, 'PT', 'Portugal', '351', 'default_flag.png', 'unpublished', NULL, NULL),
(177, 'PR', 'Puerto Rico', '1787', 'default_flag.png', 'unpublished', NULL, NULL),
(178, 'QA', 'Qatar', '974', 'default_flag.png', 'unpublished', NULL, NULL),
(179, 'RE', 'Reunion', '262', 'default_flag.png', 'unpublished', NULL, NULL),
(180, 'RO', 'Romania', '40', 'default_flag.png', 'unpublished', NULL, NULL),
(181, 'RU', 'Russia', '70', 'default_flag.png', 'unpublished', NULL, NULL),
(182, 'RW', 'Rwanda', '250', 'default_flag.png', 'unpublished', NULL, NULL),
(183, 'SH', 'Saint Helena', '290', 'default_flag.png', 'unpublished', NULL, NULL),
(184, 'KN', 'Saint Kitts And Nevis', '1869', 'default_flag.png', 'unpublished', NULL, NULL),
(185, 'LC', 'Saint Lucia', '1758', 'default_flag.png', 'unpublished', NULL, NULL),
(186, 'PM', 'Saint Pierre and Miquelon', '508', 'default_flag.png', 'unpublished', NULL, NULL),
(187, 'VC', 'Saint Vincent And The Grenadines', '1784', 'default_flag.png', 'unpublished', NULL, NULL),
(188, 'WS', 'Samoa', '684', 'default_flag.png', 'unpublished', NULL, NULL),
(189, 'SM', 'San Marino', '378', 'default_flag.png', 'unpublished', NULL, NULL),
(190, 'ST', 'Sao Tome and Principe', '239', 'default_flag.png', 'unpublished', NULL, NULL),
(191, 'SA', 'Saudi Arabia', '966', 'default_flag.png', 'unpublished', NULL, NULL),
(192, 'SN', 'Senegal', '221', 'default_flag.png', 'unpublished', NULL, NULL),
(193, 'RS', 'Serbia', '381', 'default_flag.png', 'unpublished', NULL, NULL),
(194, 'SC', 'Seychelles', '248', 'default_flag.png', 'unpublished', NULL, NULL),
(195, 'SL', 'Sierra Leone', '232', 'default_flag.png', 'unpublished', NULL, NULL),
(196, 'SG', 'Singapore', '65', 'default_flag.png', 'unpublished', NULL, NULL),
(197, 'SK', 'Slovakia', '421', 'default_flag.png', 'unpublished', NULL, NULL),
(198, 'SI', 'Slovenia', '386', 'default_flag.png', 'unpublished', NULL, NULL),
(199, 'XG', 'Smaller Territories of the UK', '44', 'default_flag.png', 'unpublished', NULL, NULL),
(200, 'SB', 'Solomon Islands', '677', 'default_flag.png', 'unpublished', NULL, NULL),
(201, 'SO', 'Somalia', '252', 'default_flag.png', 'unpublished', NULL, NULL),
(202, 'ZA', 'South Africa', '27', 'sa_flag.png', 'published', NULL, '2020-03-24 21:51:50'),
(203, 'GS', 'South Georgia', '0', 'default_flag.png', 'unpublished', NULL, NULL),
(204, 'SS', 'South Sudan', '211', 'default_flag.png', 'unpublished', NULL, NULL),
(205, 'ES', 'Spain', '34', 'default_flag.png', 'published', NULL, '2020-03-25 14:56:03'),
(206, 'LK', 'Sri Lanka', '94', 'default_flag.png', 'unpublished', NULL, NULL),
(207, 'SD', 'Sudan', '249', 'default_flag.png', 'unpublished', NULL, NULL),
(208, 'SR', 'Suriname', '597', 'default_flag.png', 'unpublished', NULL, NULL),
(209, 'SJ', 'Svalbard And Jan Mayen Islands', '47', 'default_flag.png', 'unpublished', NULL, NULL),
(210, 'SZ', 'Swaziland', '268', 'default_flag.png', 'unpublished', NULL, NULL),
(211, 'SE', 'Sweden', '46', 'default_flag.png', 'unpublished', NULL, NULL),
(212, 'CH', 'Switzerland', '41', 'default_flag.png', 'published', NULL, '2020-03-25 15:01:56'),
(213, 'SY', 'Syria', '963', 'default_flag.png', 'unpublished', NULL, NULL),
(214, 'TW', 'Taiwan', '886', 'default_flag.png', 'unpublished', NULL, NULL),
(215, 'TJ', 'Tajikistan', '992', 'default_flag.png', 'unpublished', NULL, NULL),
(216, 'TZ', 'Tanzania', '255', 'default_flag.png', 'unpublished', NULL, NULL),
(217, 'TH', 'Thailand', '66', 'default_flag.png', 'unpublished', NULL, NULL),
(218, 'TG', 'Togo', '228', 'default_flag.png', 'published', NULL, '2020-03-25 14:57:32'),
(219, 'TK', 'Tokelau', '690', 'default_flag.png', 'unpublished', NULL, NULL),
(220, 'TO', 'Tonga', '676', 'default_flag.png', 'unpublished', NULL, NULL),
(221, 'TT', 'Trinidad And Tobago', '1868', 'default_flag.png', 'unpublished', NULL, NULL),
(222, 'TN', 'Tunisia', '216', 'default_flag.png', 'unpublished', NULL, NULL),
(223, 'TR', 'Turkey', '90', 'default_flag.png', 'unpublished', NULL, NULL),
(224, 'TM', 'Turkmenistan', '7370', 'default_flag.png', 'unpublished', NULL, NULL),
(225, 'TC', 'Turks And Caicos Islands', '1649', 'default_flag.png', 'unpublished', NULL, NULL),
(226, 'TV', 'Tuvalu', '688', 'default_flag.png', 'unpublished', NULL, NULL),
(227, 'UG', 'Uganda', '256', 'default_flag.png', 'unpublished', NULL, NULL),
(228, 'UA', 'Ukraine', '380', 'default_flag.png', 'unpublished', NULL, NULL),
(229, 'AE', 'United Arab Emirates', '971', 'default_flag.png', 'unpublished', NULL, NULL),
(230, 'GB', 'United Kingdom', '44', 'default_flag.png', 'published', NULL, '2020-04-11 10:31:13'),
(231, 'US', 'United States', '1', 'us_flag.png', 'published', NULL, NULL),
(232, 'UM', 'United States Minor Outlying Islands', '1', 'default_flag.png', 'unpublished', NULL, NULL),
(233, 'UY', 'Uruguay', '598', 'default_flag.png', 'unpublished', NULL, NULL),
(234, 'UZ', 'Uzbekistan', '998', 'default_flag.png', 'unpublished', NULL, NULL),
(235, 'VU', 'Vanuatu', '678', 'default_flag.png', 'unpublished', NULL, NULL),
(236, 'VA', 'Vatican City State (Holy See)', '39', 'default_flag.png', 'unpublished', NULL, NULL),
(237, 'VE', 'Venezuela', '58', 'default_flag.png', 'unpublished', NULL, NULL),
(238, 'VN', 'Vietnam', '84', 'default_flag.png', 'unpublished', NULL, NULL),
(239, 'VG', 'Virgin Islands (British)', '1284', 'default_flag.png', 'unpublished', NULL, NULL),
(240, 'VI', 'Virgin Islands (US)', '1340', 'default_flag.png', 'unpublished', NULL, NULL),
(241, 'WF', 'Wallis And Futuna Islands', '681', 'default_flag.png', 'unpublished', NULL, NULL),
(242, 'EH', 'Western Sahara', '212', 'default_flag.png', 'unpublished', NULL, NULL),
(243, 'YE', 'Yemen', '967', 'default_flag.png', 'unpublished', NULL, NULL),
(244, 'YU', 'Yugoslavia', '38', 'default_flag.png', 'unpublished', NULL, NULL),
(245, 'ZM', 'Zambia', '260', 'default_flag.png', 'unpublished', NULL, '2020-03-24 22:14:34'),
(246, 'ZW', 'Zimbabwe', '263', 'default_flag.png', 'unpublished', NULL, '2020-03-24 22:14:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
