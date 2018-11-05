-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2018 a las 21:57:48
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oop`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `remember_token`, `last_login`) VALUES
(1, 'admin', '$2y$10$i8CU0fVpK1SY2t4khBDkseHP2RuKcvRHlQcON6RMVR99l5MBhNqQm', 'info@oop.com', 'b6IHmYgtxdkuo38PUeYrGHVqMT0ltX7nnCfttltJO9NgMBsKBBJljwDOiS34', '2017-07-12 10:20:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `countries`
--

INSERT INTO `countries` (`id`, `name`, `iso_code_2`, `iso_code_3`, `status`, `sort_order`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', 1, 0),
(2, 'Albania', 'AL', 'ALB', 1, 0),
(3, 'Algeria', 'DZ', 'DZA', 1, 0),
(4, 'American Samoa', 'AS', 'ASM', 1, 0),
(5, 'Andorra', 'AD', 'AND', 1, 0),
(6, 'Angola', 'AO', 'AGO', 1, 0),
(7, 'Anguilla', 'AI', 'AIA', 1, 0),
(8, 'Antarctica', 'AQ', 'ATA', 1, 0),
(9, 'Antigua and Barbuda', 'AG', 'ATG', 1, 0),
(10, 'Argentina', 'AR', 'ARG', 1, 0),
(11, 'Armenia', 'AM', 'ARM', 1, 0),
(12, 'Aruba', 'AW', 'ABW', 1, 0),
(13, 'Australia', 'AU', 'AUS', 1, 7),
(14, 'Austria', 'AT', 'AUT', 1, 0),
(15, 'Azerbaijan', 'AZ', 'AZE', 1, 0),
(16, 'Bahamas', 'BS', 'BHS', 1, 0),
(17, 'Bahrain', 'BH', 'BHR', 1, 0),
(18, 'Bangladesh', 'BD', 'BGD', 1, 0),
(19, 'Barbados', 'BB', 'BRB', 1, 0),
(20, 'Belarus', 'BY', 'BLR', 1, 0),
(21, 'Belgium', 'BE', 'BEL', 1, 0),
(22, 'Belize', 'BZ', 'BLZ', 1, 0),
(23, 'Benin', 'BJ', 'BEN', 1, 0),
(24, 'Bermuda', 'BM', 'BMU', 1, 0),
(25, 'Bhutan', 'BT', 'BTN', 1, 0),
(26, 'Bolivia', 'BO', 'BOL', 1, 0),
(27, 'Bosnia and Herzegovina', 'BA', 'BIH', 1, 0),
(28, 'Botswana', 'BW', 'BWA', 1, 0),
(29, 'Bouvet Island', 'BV', 'BVT', 1, 0),
(30, 'Brazil', 'BR', 'BRA', 1, 0),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', 1, 0),
(32, 'Brunei Darussalam', 'BN', 'BRN', 1, 0),
(33, 'Bulgaria', 'BG', 'BGR', 1, 0),
(34, 'Burkina Faso', 'BF', 'BFA', 1, 0),
(35, 'Burundi', 'BI', 'BDI', 1, 0),
(36, 'Cambodia', 'KH', 'KHM', 1, 0),
(37, 'Cameroon', 'CM', 'CMR', 1, 0),
(38, 'Canada', 'CA', 'CAN', 1, 0),
(39, 'Cape Verde', 'CV', 'CPV', 1, 0),
(40, 'Cayman Islands', 'KY', 'CYM', 1, 0),
(41, 'Central African Republic', 'CF', 'CAF', 1, 0),
(42, 'Chad', 'TD', 'TCD', 1, 0),
(43, 'Chile', 'CL', 'CHL', 1, 0),
(44, 'China', 'CN', 'CHN', 1, 0),
(45, 'Christmas Island', 'CX', 'CXR', 1, 0),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1, 0),
(47, 'Colombia', 'CO', 'COL', 1, 0),
(48, 'Comoros', 'KM', 'COM', 1, 0),
(49, 'Congo', 'CG', 'COG', 1, 0),
(50, 'Cook Islands', 'CK', 'COK', 1, 0),
(51, 'Costa Rica', 'CR', 'CRI', 1, 0),
(52, 'Cote D\'Ivoire', 'CI', 'CIV', 1, 0),
(53, 'Croatia', 'HR', 'HRV', 1, 0),
(54, 'Cuba', 'CU', 'CUB', 1, 0),
(55, 'Cyprus', 'CY', 'CYP', 1, 0),
(56, 'Czech Republic', 'CZ', 'CZE', 1, 0),
(57, 'Denmark', 'DK', 'DNK', 1, 0),
(58, 'Djibouti', 'DJ', 'DJI', 1, 0),
(59, 'Dominica', 'DM', 'DMA', 1, 0),
(60, 'Dominican Republic', 'DO', 'DOM', 1, 0),
(61, 'East Timor', 'TL', 'TLS', 1, 0),
(62, 'Ecuador', 'EC', 'ECU', 1, 0),
(63, 'Egypt', 'EG', 'EGY', 1, 0),
(64, 'El Salvador', 'SV', 'SLV', 1, 0),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', 1, 0),
(66, 'Eritrea', 'ER', 'ERI', 1, 0),
(67, 'Estonia', 'EE', 'EST', 1, 0),
(68, 'Ethiopia', 'ET', 'ETH', 1, 0),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1, 0),
(70, 'Faroe Islands', 'FO', 'FRO', 1, 0),
(71, 'Fiji', 'FJ', 'FJI', 1, 0),
(72, 'Finland', 'FI', 'FIN', 1, 0),
(74, 'France, Metropolitan', 'FR', 'FRA', 1, 0),
(75, 'French Guiana', 'GF', 'GUF', 1, 0),
(76, 'French Polynesia', 'PF', 'PYF', 1, 0),
(77, 'French Southern Territories', 'TF', 'ATF', 1, 0),
(78, 'Gabon', 'GA', 'GAB', 1, 0),
(79, 'Gambia', 'GM', 'GMB', 1, 0),
(80, 'Georgia', 'GE', 'GEO', 1, 0),
(81, 'Germany', 'DE', 'DEU', 1, 0),
(82, 'Ghana', 'GH', 'GHA', 1, 0),
(83, 'Gibraltar', 'GI', 'GIB', 1, 0),
(84, 'Greece', 'GR', 'GRC', 1, 0),
(85, 'Greenland', 'GL', 'GRL', 1, 0),
(86, 'Grenada', 'GD', 'GRD', 1, 0),
(87, 'Guadeloupe', 'GP', 'GLP', 1, 0),
(88, 'Guam', 'GU', 'GUM', 1, 0),
(89, 'Guatemala', 'GT', 'GTM', 1, 0),
(90, 'Guinea', 'GN', 'GIN', 1, 0),
(91, 'Guinea-Bissau', 'GW', 'GNB', 1, 0),
(92, 'Guyana', 'GY', 'GUY', 1, 0),
(93, 'Haiti', 'HT', 'HTI', 1, 0),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1, 0),
(95, 'Honduras', 'HN', 'HND', 1, 0),
(96, 'Hong Kong', 'HK', 'HKG', 1, 0),
(97, 'Hungary', 'HU', 'HUN', 1, 0),
(98, 'Iceland', 'IS', 'ISL', 1, 0),
(99, 'India', 'IN', 'IND', 1, 8),
(100, 'Indonesia', 'ID', 'IDN', 1, 0),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1, 0),
(102, 'Iraq', 'IQ', 'IRQ', 1, 0),
(103, 'Ireland', 'IE', 'IRL', 1, 0),
(104, 'Israel', 'IL', 'ISR', 1, 0),
(105, 'Italy', 'IT', 'ITA', 1, 0),
(106, 'Jamaica', 'JM', 'JAM', 1, 0),
(107, 'Japan', 'JP', 'JPN', 1, 0),
(108, 'Jordan', 'JO', 'JOR', 1, 0),
(109, 'Kazakhstan', 'KZ', 'KAZ', 1, 0),
(110, 'Kenya', 'KE', 'KEN', 1, 0),
(111, 'Kiribati', 'KI', 'KIR', 1, 0),
(112, 'North Korea', 'KP', 'PRK', 1, 0),
(113, 'Korea, Republic of', 'KR', 'KOR', 1, 0),
(114, 'Kuwait', 'KW', 'KWT', 1, 0),
(115, 'Kyrgyzstan', 'KG', 'KGZ', 1, 0),
(116, 'Lao People\'s Democratic Republic', 'LA', 'LAO', 1, 0),
(117, 'Latvia', 'LV', 'LVA', 1, 0),
(118, 'Lebanon', 'LB', 'LBN', 1, 0),
(119, 'Lesotho', 'LS', 'LSO', 1, 0),
(120, 'Liberia', 'LR', 'LBR', 1, 0),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1, 0),
(122, 'Liechtenstein', 'LI', 'LIE', 1, 0),
(123, 'Lithuania', 'LT', 'LTU', 1, 0),
(124, 'Luxembourg', 'LU', 'LUX', 1, 0),
(125, 'Macau', 'MO', 'MAC', 1, 0),
(126, 'FYROM', 'MK', 'MKD', 1, 0),
(127, 'Madagascar', 'MG', 'MDG', 1, 0),
(128, 'Malawi', 'MW', 'MWI', 1, 0),
(129, 'Malaysia', 'MY', 'MYS', 1, 0),
(130, 'Maldives', 'MV', 'MDV', 1, 0),
(131, 'Mali', 'ML', 'MLI', 1, 0),
(132, 'Malta', 'MT', 'MLT', 1, 0),
(133, 'Marshall Islands', 'MH', 'MHL', 1, 0),
(134, 'Martinique', 'MQ', 'MTQ', 1, 0),
(135, 'Mauritania', 'MR', 'MRT', 1, 0),
(136, 'Mauritius', 'MU', 'MUS', 1, 0),
(137, 'Mayotte', 'YT', 'MYT', 1, 0),
(138, 'Mexico', 'MX', 'MEX', 1, 0),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', 1, 0),
(140, 'Moldova, Republic of', 'MD', 'MDA', 1, 0),
(141, 'Monaco', 'MC', 'MCO', 1, 0),
(142, 'Mongolia', 'MN', 'MNG', 1, 0),
(143, 'Montserrat', 'MS', 'MSR', 1, 0),
(144, 'Morocco', 'MA', 'MAR', 1, 0),
(145, 'Mozambique', 'MZ', 'MOZ', 1, 0),
(146, 'Myanmar', 'MM', 'MMR', 1, 0),
(147, 'Namibia', 'NA', 'NAM', 1, 0),
(148, 'Nauru', 'NR', 'NRU', 1, 0),
(149, 'Nepal', 'NP', 'NPL', 1, 0),
(150, 'Netherlands', 'NL', 'NLD', 1, 0),
(151, 'Netherlands Antilles', 'AN', 'ANT', 1, 0),
(152, 'New Caledonia', 'NC', 'NCL', 1, 0),
(153, 'New Zealand', 'NZ', 'NZL', 1, 0),
(154, 'Nicaragua', 'NI', 'NIC', 1, 0),
(155, 'Niger', 'NE', 'NER', 1, 0),
(156, 'Nigeria', 'NG', 'NGA', 1, 0),
(157, 'Niue', 'NU', 'NIU', 1, 0),
(158, 'Norfolk Island', 'NF', 'NFK', 1, 0),
(159, 'Northern Mariana Islands', 'MP', 'MNP', 1, 0),
(160, 'Norway', 'NO', 'NOR', 1, 0),
(161, 'Oman', 'OM', 'OMN', 1, 0),
(162, 'Pakistan', 'PK', 'PAK', 1, 0),
(163, 'Palau', 'PW', 'PLW', 1, 0),
(164, 'Panama', 'PA', 'PAN', 1, 0),
(165, 'Papua New Guinea', 'PG', 'PNG', 1, 0),
(166, 'Paraguay', 'PY', 'PRY', 1, 0),
(167, 'Peru', 'PE', 'PER', 1, 0),
(168, 'Philippines', 'PH', 'PHL', 1, 0),
(169, 'Pitcairn', 'PN', 'PCN', 1, 0),
(170, 'Poland', 'PL', 'POL', 1, 0),
(171, 'Portugal', 'PT', 'PRT', 1, 0),
(172, 'Puerto Rico', 'PR', 'PRI', 1, 0),
(173, 'Qatar', 'QA', 'QAT', 1, 0),
(174, 'Reunion', 'RE', 'REU', 1, 0),
(175, 'Romania', 'RO', 'ROM', 1, 0),
(176, 'Russian Federation', 'RU', 'RUS', 1, 0),
(177, 'Rwanda', 'RW', 'RWA', 1, 0),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1, 0),
(179, 'Saint Lucia', 'LC', 'LCA', 1, 0),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 1, 0),
(181, 'Samoa', 'WS', 'WSM', 1, 0),
(182, 'San Marino', 'SM', 'SMR', 1, 0),
(183, 'Sao Tome and Principe', 'ST', 'STP', 1, 0),
(184, 'Saudi Arabia', 'SA', 'SAU', 1, 0),
(185, 'Senegal', 'SN', 'SEN', 1, 0),
(186, 'Seychelles', 'SC', 'SYC', 1, 0),
(187, 'Sierra Leone', 'SL', 'SLE', 1, 0),
(188, 'Singapore', 'SG', 'SGP', 1, 0),
(189, 'Slovak Republic', 'SK', 'SVK', 1, 0),
(190, 'Slovenia', 'SI', 'SVN', 1, 0),
(191, 'Solomon Islands', 'SB', 'SLB', 1, 0),
(192, 'Somalia', 'SO', 'SOM', 1, 0),
(193, 'South Africa', 'ZA', 'ZAF', 1, 0),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', 1, 0),
(195, 'Spain', 'ES', 'ESP', 1, 0),
(196, 'Sri Lanka', 'LK', 'LKA', 1, 0),
(197, 'St. Helena', 'SH', 'SHN', 1, 0),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1, 0),
(199, 'Sudan', 'SD', 'SDN', 1, 0),
(200, 'Suriname', 'SR', 'SUR', 1, 0),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', 1, 0),
(202, 'Swaziland', 'SZ', 'SWZ', 1, 0),
(203, 'Sweden', 'SE', 'SWE', 1, 0),
(204, 'Switzerland', 'CH', 'CHE', 1, 0),
(205, 'Syrian Arab Republic', 'SY', 'SYR', 1, 0),
(206, 'Taiwan', 'TW', 'TWN', 1, 0),
(207, 'Tajikistan', 'TJ', 'TJK', 1, 0),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1, 0),
(209, 'Thailand', 'TH', 'THA', 1, 0),
(210, 'Togo', 'TG', 'TGO', 1, 0),
(211, 'Tokelau', 'TK', 'TKL', 1, 0),
(212, 'Tonga', 'TO', 'TON', 1, 0),
(213, 'Trinidad and Tobago', 'TT', 'TTO', 1, 0),
(214, 'Tunisia', 'TN', 'TUN', 1, 0),
(215, 'Turkey', 'TR', 'TUR', 1, 0),
(216, 'Turkmenistan', 'TM', 'TKM', 1, 0),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', 1, 0),
(218, 'Tuvalu', 'TV', 'TUV', 1, 0),
(219, 'Uganda', 'UG', 'UGA', 1, 0),
(220, 'Ukraine', 'UA', 'UKR', 1, 0),
(221, 'United Arab Emirates', 'AE', 'ARE', 1, 0),
(222, 'United Kingdom', 'GB', 'GBR', 1, 9),
(223, 'United States', 'US', 'USA', 1, 10),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', 1, 0),
(225, 'Uruguay', 'UY', 'URY', 1, 0),
(226, 'Uzbekistan', 'UZ', 'UZB', 1, 0),
(227, 'Vanuatu', 'VU', 'VUT', 1, 0),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', 1, 0),
(229, 'Venezuela', 'VE', 'VEN', 1, 0),
(230, 'Viet Nam', 'VN', 'VNM', 1, 0),
(231, 'Virgin Islands (British)', 'VG', 'VGB', 1, 0),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1, 0),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1, 0),
(234, 'Western Sahara', 'EH', 'ESH', 1, 0),
(235, 'Yemen', 'YE', 'YEM', 1, 0),
(237, 'Democratic Republic of Congo', 'CD', 'COD', 1, 0),
(238, 'Zambia', 'ZM', 'ZMB', 1, 0),
(239, 'Zimbabwe', 'ZW', 'ZWE', 1, 0),
(242, 'Montenegro', 'ME', 'MNE', 1, 0),
(243, 'Serbia', 'RS', 'SRB', 1, 0),
(244, 'Aaland Islands', 'AX', 'ALA', 1, 0),
(245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', 1, 0),
(246, 'Curacao', 'CW', 'CUW', 1, 0),
(247, 'Palestinian Territory, Occupied', 'PS', 'PSE', 1, 0),
(248, 'South Sudan', 'SS', 'SSD', 1, 0),
(249, 'St. Barthelemy', 'BL', 'BLM', 1, 0),
(250, 'St. Martin (French part)', 'MF', 'MAF', 1, 0),
(251, 'Canary Islands', 'IC', 'ICA', 1, 0),
(252, 'Ascension Island (British)', 'AC', 'ASC', 1, 0),
(253, 'Kosovo, Republic of', 'XK', 'UNK', 1, 0),
(254, 'Isle of Man', 'IM', 'IMN', 1, 0),
(255, 'Tristan da Cunha', 'TA', 'SHN', 1, 0),
(256, 'Guernsey', 'GG', 'GGY', 1, 0),
(257, 'Jersey', 'JE', 'JEY', 1, 0),
(260, 'abcd', 'ds', '', 1, 0),
(261, 'abcdef', 'ab', '', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hour_calculation`
--

CREATE TABLE `hour_calculation` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `work_date` date DEFAULT NULL,
  `start_time` varchar(20) DEFAULT NULL,
  `end_time` varchar(20) DEFAULT NULL,
  `break` varchar(50) DEFAULT NULL,
  `total_hours` varchar(30) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0=>deactive,1=>active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `hour_calculation`
--

INSERT INTO `hour_calculation` (`id`, `project_id`, `worker_id`, `work_date`, `start_time`, `end_time`, `break`, `total_hours`, `status`, `created_at`, `updated_at`) VALUES
(4, 3, 8, '0000-00-00', '01:00', '04:00', '2', '1', 1, '2018-09-29 18:23:18', '2018-09-29 18:23:18'),
(5, 2, 7, '0000-00-00', '01:00', '06:30', '2', '4.30', 1, '2018-09-30 00:53:11', '2018-09-30 00:53:11'),
(6, 2, 7, '0000-00-00', '15:00', '23:00', '2', '6', 1, '2018-09-30 00:54:59', '2018-09-30 00:54:59'),
(7, 2, 7, '0000-00-00', '08:00', '18:00', '1', '9', 1, '2018-09-30 01:16:21', '2018-09-30 01:16:21'),
(8, 3, 8, '0000-00-00', '10:00', '20:00', '1', '9', 1, '2018-09-30 01:17:51', '2018-09-30 01:17:51'),
(9, 2, 7, '0000-00-00', '01:00', '03:00', '1', '1', 1, '2018-09-30 01:47:03', '2018-09-30 01:47:03'),
(10, 2, 7, '2018-10-17', '01:30', '06:30', '1', '4', 1, '2018-10-03 16:27:02', '2018-10-03 16:27:02'),
(11, 4, 11, '2018-10-10', '06:30', '19:30', '40', '12', 1, '2018-10-09 01:16:15', '2018-10-09 01:16:15'),
(12, 4, 12, '2018-10-10', '06:30', '19:30', '40', '12', 1, '2018-10-09 01:16:15', '2018-10-09 01:16:15'),
(13, 4, 13, '2018-10-10', '06:30', '19:30', '40', '12', 1, '2018-10-09 01:16:15', '2018-10-09 01:16:15'),
(17, 2, 7, '2018-10-11', '08:00', '17:00', '30', '8.5', 1, '2018-10-10 13:37:59', '2018-10-10 13:37:59'),
(18, 4, 11, '2018-10-11', '09:30', '18:30', '60', '8.0', 1, '2018-10-10 14:02:47', '2018-10-10 14:02:47'),
(19, 4, 13, '2018-10-11', '09:30', '18:30', '60', '8.0', 1, '2018-10-10 14:02:47', '2018-10-10 14:02:47'),
(20, 4, 11, '2018-09-11', '06:30', '18:00', '30', '11.0', 1, '2018-10-16 16:11:30', '2018-10-16 16:11:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '0=>deactive,1=>active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `projects`
--

INSERT INTO `projects` (`id`, `name`, `address`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Event Planning', 'Jaipur India', 1, '2018-09-29 16:32:17', '2018-10-09 04:20:48'),
(4, 'Proyecto Inmonube', 'Los Reyes Acozac', 1, '2018-10-09 00:32:17', '2018-10-09 00:32:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `project_worker`
--

CREATE TABLE `project_worker` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `project_worker`
--

INSERT INTO `project_worker` (`id`, `project_id`, `worker_id`, `created_at`, `updated_at`) VALUES
(1, 1, 7, '2018-09-29 12:52:39', '2018-09-29 12:52:39'),
(2, 2, 7, '2018-09-29 16:32:17', '2018-09-29 16:32:17'),
(17, 3, 7, '2018-10-08 22:52:09', '2018-10-08 22:52:09'),
(18, 3, 11, '2018-10-08 22:52:09', '2018-10-08 22:52:09'),
(20, 4, 11, '2018-10-09 00:32:17', '2018-10-09 00:32:17'),
(21, 4, 13, '2018-10-09 00:32:17', '2018-10-09 00:32:17'),
(22, 4, 12, '2018-10-09 00:32:17', '2018-10-09 00:32:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `country_id` int(11) DEFAULT NULL,
  `color` varchar(50) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_type` tinyint(2) DEFAULT NULL COMMENT '1=Normal user,2=Concierge',
  `token` varchar(255) NOT NULL DEFAULT ' ',
  `remember_token` varchar(255) DEFAULT NULL,
  `verified` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `country_id`, `color`, `full_name`, `username`, `email`, `profile_image`, `mobile_number`, `dob`, `gender`, `password`, `user_type`, `token`, `remember_token`, `verified`, `status`, `created_at`, `updated_at`) VALUES
(1, 99, '#92e92c', 'Halo', 'admin', 'admin@helo.com', NULL, NULL, NULL, NULL, '$2y$10$i8CU0fVpK1SY2t4khBDkseHP2RuKcvRHlQcON6RMVR99l5MBhNqQm', NULL, ' ', 'MVy9ETajwY1nHVd54z9K6Qqa2WPsSRLMvQAooREiJXkQV8qEjiaJOARQsvmO', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, NULL, '#152560', 'asaSAs', 'devusernew', NULL, '/uploads/user/profile/7/153156087275024368731538220386.jpg', '53454543534543', NULL, NULL, '$2y$10$eGlCYj6KXEvr7bDXpghGo.LnWlatjOeUAKNHz3.9uAxOzX.HIbayi', NULL, ' ', NULL, 0, 1, '2018-09-29 17:01:10', '2018-10-04 06:15:20'),
(11, NULL, '#991690', 'Cesar test', 'kypergio', NULL, '/uploads/user/profile/11/5bb5b11977cbb.png', '5565665656', NULL, NULL, '$2y$10$fvuLVnfIa9CfQacenC/Vv.0KV/qOvro/T4YjgOLO6kYiwPg44K0JK', NULL, ' ', NULL, 0, 1, '2018-10-04 06:20:09', '2018-10-04 06:20:09'),
(12, NULL, '#3c8820', 'Graciela Zamora Martínez', 'Grass', NULL, '/uploads/user/profile/12/5bbbf363f22cd.png', '456789654', NULL, NULL, '$2y$10$7vphDlvnVEcGmlCf7BnFpeRGRA8oM9Y1i8jUSvmYLBigdURPHWFoK', NULL, ' ', NULL, 0, 1, '2018-10-09 00:16:35', '2018-10-09 00:16:35'),
(13, NULL, '#f7b3a7', 'Cesar Giovanni Villanueva Zamora', 'kyper.gio', NULL, '/uploads/user/profile/13/5bc623e8a87ec.png', '5543845305', NULL, NULL, '$2y$10$lUIdzwPDndhZkMC0V72eNOyXHtXNmGyTY5WWiFhRTRrCww/AsJG8W', NULL, ' ', NULL, 0, 1, '2018-10-09 00:30:46', '2018-10-16 17:46:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_devices`
--

CREATE TABLE `user_devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `device_type` varchar(255) NOT NULL,
  `device_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user_devices`
--

INSERT INTO `user_devices` (`id`, `user_id`, `device_type`, `device_token`) VALUES
(1, 1, 'ANDROID', '56464$^&%^&%^'),
(3, 2, 'ANDROID', '897987987'),
(4, 4, 'ANDROID', '123456789'),
(5, 5, 'ANDROID', '49asd4g9s4dgf949sdf49g4sfdg4s949s4f9gfdg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `hour_calculation`
--
ALTER TABLE `hour_calculation`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `project_worker`
--
ALTER TABLE `project_worker`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT de la tabla `hour_calculation`
--
ALTER TABLE `hour_calculation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `project_worker`
--
ALTER TABLE `project_worker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
