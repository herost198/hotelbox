/*
 Navicat Premium Data Transfer

 Source Server         : admin
 Source Server Type    : MySQL
 Source Server Version : 100137
 Source Host           : localhost:3306
 Source Schema         : hotel

 Target Server Type    : MySQL
 Target Server Version : 100137
 File Encoding         : 65001

 Date: 21/08/2019 13:29:17
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for tlhotel_background
-- ----------------------------
DROP TABLE IF EXISTS `tlhotel_background`;
CREATE TABLE `tlhotel_background`  (
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `link` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
		`type` int NULL DEFAULT '2',	
  PRIMARY KEY (`id`) USING BTREE,
  CONSTRAINT `tlhotel_background_ibfk_1` FOREIGN KEY (`id`) REFERENCES `tlhotel_information` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tlhotel_background
-- ----------------------------
INSERT INTO `tlhotel_background` VALUES ('H001562549621', '[\"\\/images\\/background\\/idK1565184259Screenshot_20190803-011938.png\",\"\\/images\\/background\\/XRr1565184407IMG_20190609_231858_686.jpg\",\"\\/images\\/background\\/k6N1565193687proxy.jpg\",\"\\/images\\/background\\/8ux1565203186FB_IMG_1549303822685.jpg\"]',null);
INSERT INTO `tlhotel_background` VALUES ('H001562957202', '[\"\\/images\\/background\\/cou15641065917.png\"]',null);
INSERT INTO `tlhotel_background` VALUES ('H001565204608', '[\"\\/images\\/background\\/D4315652052471.jpg\",\"\\/images\\/background\\/q5g15652052472.jpg\",\"\\/images\\/background\\/KGM15652052474.jpg\"]',null);
INSERT INTO `tlhotel_background` VALUES ('H001565234072', '[\"\\/images\\/background\\/75X15652348717.jpg\",\"\\/images\\/background\\/DFR15652348566.jpg\",\"\\/images\\/background\\/5xL1565236405Screenshot_20190803-011938.png\"]',null);

-- ----------------------------
-- Table structure for tlhotel_boxtv
-- ----------------------------
DROP TABLE IF EXISTS `tlhotel_boxtv`;
CREATE TABLE `tlhotel_boxtv`  (
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `serial` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `mac` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NULL DEFAULT 0,
  `tv_package_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `phong_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `mac`(`mac`) USING BTREE,
  INDEX `phong_id`(`phong_id`) USING BTREE,
  CONSTRAINT `tlhotel_boxtv_ibfk_1` FOREIGN KEY (`phong_id`) REFERENCES `tlhotel_phong` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tlhotel_boxtv
-- ----------------------------
INSERT INTO `tlhotel_boxtv` VALUES ('TV0008xRt7B', '', '123184489', 1, '', 'Pjry2KXs');
INSERT INTO `tlhotel_boxtv` VALUES ('TV004LLFzRQ', '', '6456456745', 1, '', 'P4i17BIJ');
INSERT INTO `tlhotel_boxtv` VALUES ('TV004R5sLHR', '', '12345612132', 1, '', 'PJSYsUAJ');
INSERT INTO `tlhotel_boxtv` VALUES ('TV007ODErr5', '', '876888686', 1, '', 'P00Ooh1huTl');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00ageo6Cg', '12312312', '312321312', 1, '', 'P69BbXXC');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00egovv2H', '', '32155325437', 1, '', 'Pjry2KXs');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00GADwGui', '', '7456242342', 1, '', 'P00Ooh1huTl');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00gFjfKcC', '', '5435216645', 1, '', 'P4i17BIJ');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00H66svVV', '', '1231234126', 1, '', 'P00rNcJZI46');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00inrQE1P', '', '74562423422', 1, '', 'P00rNcJZI46');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00iPCAOwL', '', '21232321', 1, '', 'P00Ooh1huTl');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00k1bGfJw', '', '54678134', 1, '', 'P00Ooh1huTl');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00LZ7meeH', '', '54352166456', 1, '', 'P00rNcJZI46');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00mwcmjtE', '', '546781346', 1, '', 'P00rNcJZI46');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00nMFH0LH', '21321321312', '3312312', 1, NULL, 'P101008');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00oVGirSV', '', '123123412', 1, '', 'P00Ooh1huTl');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00TOou6f1', '', '212323212', 1, '', 'P00rNcJZI46');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00TseW11o', '', '12318448', 1, '', 'P4i17BIJ');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00tY2MYiI', '', '64564567457', 1, '', 'P00rNcJZI46');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00UX3EFQj', '', '8768886869', 1, '', 'P00rNcJZI46');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00wlNWuzT', '213123123', '2131232132', 1, NULL, 'PGy4oTpC');
INSERT INTO `tlhotel_boxtv` VALUES ('TV00Y8WfLH7', '', '3215532543', 1, '', 'P00Ooh1huTl');

-- ----------------------------
-- Table structure for tlhotel_cumphong
-- ----------------------------
DROP TABLE IF EXISTS `tlhotel_cumphong`;
CREATE TABLE `tlhotel_cumphong`  (
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `hotel_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `check` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `hotel_id`(`hotel_id`) USING BTREE,
  CONSTRAINT `tlhotel_cumphong_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `tlhotel_information` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tlhotel_cumphong
-- ----------------------------
INSERT INTO `tlhotel_cumphong` VALUES ('0p5GVF5iYO', 'Mặc định', 'H001562549621', 1);
INSERT INTO `tlhotel_cumphong` VALUES ('CP0007JRwGtukc', 'Mặc định', 'H001565204608', 1);
INSERT INTO `tlhotel_cumphong` VALUES ('CP001qEhDDVUOE', 'Mặc định', 'H001565234072', 1);
INSERT INTO `tlhotel_cumphong` VALUES ('CP101002', 'VIP 2', 'H102', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CP1H2l63M', 'dasd', 'H001562549621', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CP5L6XqSO', 'Vila ', 'H001565234072', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPc2S6K7h', 'Vip', 'H001565234072', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPf8aXFp3', 'Lâm abc', 'H102', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPGZTmWzG', 'Vip', 'H001565204608', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPJiMeiPm', 'Standard 1', 'H001565234072', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPNDil9Ze', 'Vila', 'H001565204608', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPoTc0hGB', 'Villa', 'H102', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPp5XEytN', 'Lâm abc', 'H102', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPTZGX9Px', 'An Binh', 'H102', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPv6xNQbB', 'Standard', 'H001565204608', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPVSawRtc', 'Lâm abc', 'H102', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPwmPNd0B', 'Mặc định', 'H001562957202', 0);
INSERT INTO `tlhotel_cumphong` VALUES ('CPyeBI6M4', 'hello', 'H001562957202', 0);

-- ----------------------------
-- Table structure for tlhotel_information
-- ----------------------------
DROP TABLE IF EXISTS `tlhotel_information`;
CREATE TABLE `tlhotel_information`  (
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `greeting` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
	 `link` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `duration` int(11) NULL DEFAULT NULL,
	`background_type`   int NULL DEFAULT '2',	
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tlhotel_information
-- ----------------------------
INSERT INTO `tlhotel_information` VALUES ('H001562549621', 'sunworld', 'images/logo/atm1565202717Screenshot_20190803-011938.png', 'hello','[\"\\/images\\/popup\\/m5X1565797735Screenshot_20190813-180343.png\"]', 2,2);
INSERT INTO `tlhotel_information` VALUES ('H001562957202', 'quang  Anh', 'images/logo/vSP156395180667.png', 'chào mưng bạn đến với khách sạn',null,null,2);
INSERT INTO `tlhotel_information` VALUES ('H001565204608', 'Trường Lâm', '/images/logo/YMa1565204608logo.jpg', 'chào mừng bạn đến với Trường Lâm', '[\"\\/images\\/popup\\/iPI15641064293.jpg\"]', NULL,2);
INSERT INTO `tlhotel_information` VALUES ('H001565234072', 'Lâm', 'images/logo/lhy1565236443FB_IMG_1564914708281.jpg', 'chào mừng khách sạn của Lâm',null,null,2);
INSERT INTO `tlhotel_information` VALUES ('H102', 'Vin Home', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSAOFrAZkWUCEdIf-Lle5ypFOxPB3fEikjy4gn6J5qptZ9pDWZg', 'chào mừng đến với Khách sạn',null,null,2);


-- ----------------------------
-- Table structure for tlhotel_phong
-- ----------------------------
DROP TABLE IF EXISTS `tlhotel_phong`;
CREATE TABLE `tlhotel_phong`  (
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `cumphong_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `notification` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `check` tinyint(255) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `cumphong_id`(`cumphong_id`) USING BTREE,
  CONSTRAINT `tlhotel_phong_ibfk_1` FOREIGN KEY (`cumphong_id`) REFERENCES `tlhotel_cumphong` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tlhotel_phong
-- ----------------------------
INSERT INTO `tlhotel_phong` VALUES ('P00Ooh1huTl', 'Toàn bộ Phòng khách sạn', 'CP0007JRwGtukc',null, 1);
INSERT INTO `tlhotel_phong` VALUES ('P00rNcJZI46', 'Toàn bộ Phòng khách sạn', 'CP001qEhDDVUOE',null, 1);
INSERT INTO `tlhotel_phong` VALUES ('P0DEPx6S', '307', 'CPTZGX9Px', null,0);
INSERT INTO `tlhotel_phong` VALUES ('P101007', 'VIP2-101', 'CP101002',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('P101008', 'Hoạt', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('P2K9OCXh', 'dsadas', 'CPyeBI6M4',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('P4eselFa', 'Royal City', 'CPVSawRtc',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('P4i17BIJ', 'Vip-1', 'CPGZTmWzG', null,0);
INSERT INTO `tlhotel_phong` VALUES ('P5lzV2B9', 'đâsdasdsadasdasdasdsadsa', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('P69BbXXC', 'hello12312', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('P6PJZHtu', 'My', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('P8d4KdyF', 'Nam', 'CP1H2l63M', null,0);
INSERT INTO `tlhotel_phong` VALUES ('PA8vFrDC', 'I love you', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PAlb7FNW', 'dasdas', 'CPyeBI6M4', null,0);
INSERT INTO `tlhotel_phong` VALUES ('PBL8uqSY', 'Vip 101', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PEdky4OY', 'Vip-3', 'CPGZTmWzG',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PGy4oTpC', '5465123', '0p5GVF5iYO',null, 1);
INSERT INTO `tlhotel_phong` VALUES ('PH6bkkYM', 'đâsdasdsa', '0p5GVF5iYO', null,0);
INSERT INTO `tlhotel_phong` VALUES ('Pjry2KXs', 'vila-2', 'CP5L6XqSO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PJSYsUAJ', 'vila-1', 'CP5L6XqSO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('Pkg5a195', '101', 'CPJiMeiPm',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PKYMJzJR', '789654', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PlKjpTWQ', '308', 'CPp5XEytN', null,0);
INSERT INTO `tlhotel_phong` VALUES ('PmjoBNOd', 'Hoạt', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('Pmm3KUcL', '103', '0p5GVF5iYO', null,0);
INSERT INTO `tlhotel_phong` VALUES ('Pn7w1Sns', 'quang anh', 'CPVSawRtc',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PNpCzbHm', 'bàn phím', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PO5afnsu', '333', 'CPTZGX9Px',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PodbDtiU', 'dasdasdasdasdsa', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PoH4NnkI', '308', 'CPTZGX9Px',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PpesKBcg', 'test', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PpL2d2xw', 'An Binh', 'CPVSawRtc',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PPpnFEcj', 'Vila-1', 'CPNDil9Ze',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PqR3IWoa', '102', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('Pr1kJj0r', '456', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PrH5qSo1', 'Hoat', 'CPVSawRtc',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('Ps0hUhw8', '789', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PsTJwDVV', 'Vip-2', 'CPGZTmWzG',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PSx8cseV', 'dsadsadasdsa', '0p5GVF5iYO',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PWPDSGi7', 'Nam Cuong', 'CPVSawRtc',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PWSx9LT8', 'o la', 'CPwmPNd0B',null, 0);
INSERT INTO `tlhotel_phong` VALUES ('PzZQXeFC', 'Phòng của Lâm', 'CPf8aXFp3',null, 0);



-- ----------------------------
-- Table structure for tlhotel_service
-- ----------------------------
DROP TABLE IF EXISTS `tlhotel_service`;
CREATE TABLE `tlhotel_service`  (
  `id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `color_icon` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `tittle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  `link` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `hotel_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `hotel_id`(`hotel_id`) USING BTREE,
  CONSTRAINT `tlhotel_service_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `tlhotel_information` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tlhotel_service
-- ----------------------------
INSERT INTO `tlhotel_service` VALUES ('SV001563760379', 'f6af', '#eb4034', 'sửa lần 2', 'sửa lần 2', 'H001562549621');
INSERT INTO `tlhotel_service` VALUES ('SV001563766687', 'f6af', '#eb4034', 'test 2', 'test 2', 'H001562549621');
INSERT INTO `tlhotel_service` VALUES ('SV001563907354', 'hello1', 'hello1', 'hello1', '<div class=\"main\">\r\n<div class=\"title\">\r\n<h1>PH&Ograve;NG TẬP GYM ĐẲNG CẤP</h1>\r\n</div>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\"><img src=\"http://localhost:8000/photos/1/7.png\" width=\"400\" height=\"300\" /></th>\r\n<th class=\"intro\">Với lối b&agrave;i tr&iacute; nhẹ nh&agrave;ng lấy hoa sen l&agrave;m chủ đạo, kết hợp kiến tr&uacute;c hiện đại với phong c&aacute;ch cổ điển đậm chất thiền nhưng kh&ocirc;ng k&eacute;m phần sang trọng, ấm c&uacute;ng &ndash; Sen Spa tựa như một resort y&ecirc;n b&igrave;nh v&agrave; mộc mạc giữa S&agrave;i G&ograve;n n&aacute;o nhiệt, hứa hẹn sẽ mang đến cho bạn những giờ ph&uacute;t thư gi&atilde;n tuyệt vời để chăm s&oacute;c sức khỏe v&agrave; l&agrave;n da của bạn.</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style=\"margin-top: 20px;\">\r\n<tbody>\r\n<tr>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n</tr>\r\n<tr>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\r\n<th>Oasis (1.5h) <br />1.100.000đ</th>\r\n<th>Oasis (1.5h) <br />1.100.000đ</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>', 'H001562549621');
INSERT INTO `tlhotel_service` VALUES ('SV001565206001', 'f368', '#bf2f24', 'Ăn Uống', '<div class=\"main\">\r\n<div class=\"title\">\r\n<h1>KHU ĂN UỐNG ĐẲNG CẤP</h1>\r\n</div>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\"><img src=\"http://localhost:8000/photos/Trường L&acirc;m/5d4b25799999b.jpg\" width=\"400\" height=\"300\" /></th>\r\n<th class=\"intro\">Với lối b&agrave;i tr&iacute; nhẹ nh&agrave;ng lấy hoa sen l&agrave;m chủ đạo, kết hợp kiến tr&uacute;c hiện đại với phong c&aacute;ch cổ điển đậm chất thiền nhưng kh&ocirc;ng k&eacute;m phần sang trọng, ấm c&uacute;ng &ndash; Sen Spa tựa như một resort y&ecirc;n b&igrave;nh v&agrave; mộc mạc giữa S&agrave;i G&ograve;n n&aacute;o nhiệt, hứa hẹn sẽ mang đến cho bạn những giờ ph&uacute;t thư gi&atilde;n tuyệt vời để chăm s&oacute;c sức khỏe v&agrave; l&agrave;n da của bạn.</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style=\"margin-top: 20px;\">\r\n<tbody>\r\n<tr>\r\n<th><img src=\"http://localhost:8000/photos/Trường L&acirc;m/5d4b25799999b.jpg\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/Trường L&acirc;m/5d4b25799999b.jpg\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/Trường L&acirc;m/5d4b25799999b.jpg\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/Trường L&acirc;m/5d4b25799999b.jpg\" width=\"200\" height=\"150\" /></th>\r\n</tr>\r\n<tr>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\r\n<th>Oasis (1.5h) <br />1.100.000đ</th>\r\n<th>Oasis (1.5h) <br />1.100.000đ</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>', 'H001565204608');
INSERT INTO `tlhotel_service` VALUES ('SV001565206071', 'f44b', '#521612', 'GYM', '<div class=\"main\">\r\n<div class=\"title\">\r\n<h1>PH&Ograve;NG TẬP GYM ĐẲNG CẤP</h1>\r\n</div>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\"><img src=\"http://localhost:8000/photos/1/7.png\" width=\"400\" height=\"300\" /></th>\r\n<th class=\"intro\">Với lối b&agrave;i tr&iacute; nhẹ nh&agrave;ng lấy hoa sen l&agrave;m chủ đạo, kết hợp kiến tr&uacute;c hiện đại với phong c&aacute;ch cổ điển đậm chất thiền nhưng kh&ocirc;ng k&eacute;m phần sang trọng, ấm c&uacute;ng &ndash; Sen Spa tựa như một resort y&ecirc;n b&igrave;nh v&agrave; mộc mạc giữa S&agrave;i G&ograve;n n&aacute;o nhiệt, hứa hẹn sẽ mang đến cho bạn những giờ ph&uacute;t thư gi&atilde;n tuyệt vời để chăm s&oacute;c sức khỏe v&agrave; l&agrave;n da của bạn.</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style=\"margin-top: 20px;\">\r\n<tbody>\r\n<tr>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n</tr>\r\n<tr>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\r\n<th>Oasis (1.5h) <br />1.100.000đ</th>\r\n<th>Oasis (1.5h) <br />1.100.000đ</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>', 'H001565204608');
INSERT INTO `tlhotel_service` VALUES ('SV001565235159', 'f042', '#0a7317', 'Gym', '<div class=\"main\">\r\n<div class=\"title\">\r\n<h1>PH&Ograve;NG TẬP GYM ĐẲNG CẤP</h1>\r\n</div>\r\n<table>\r\n<tbody>\r\n<tr>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\"><img src=\"http://localhost:8000/photos/10/12.png\" width=\"400\" height=\"300\" /></th>\r\n<th class=\"intro\">Với lối b&agrave;i tr&iacute; nhẹ nh&agrave;ng lấy hoa sen l&agrave;m chủ đạo, kết hợp kiến tr&uacute;c hiện đại với phong c&aacute;ch cổ điển đậm chất thiền nhưng kh&ocirc;ng k&eacute;m phần sang trọng, ấm c&uacute;ng &ndash; Sen Spa tựa như một resort y&ecirc;n b&igrave;nh v&agrave; mộc mạc giữa S&agrave;i G&ograve;n n&aacute;o nhiệt, hứa hẹn sẽ mang đến cho bạn những giờ ph&uacute;t thư gi&atilde;n tuyệt vời để chăm s&oacute;c sức khỏe v&agrave; l&agrave;n da của bạn.</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style=\"margin-top: 20px;\">\r\n<tbody>\r\n<tr>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n<th><img src=\"http://localhost:8000/photos/1/7.png\" width=\"200\" height=\"150\" /></th>\r\n</tr>\r\n<tr>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\r\n<th style=\"font-weight: normal; font-size: 20px; color: #727272; padding: 10px;\">Oasis (1.5h) <br />1.100.000đ</th>\r\n<th>Oasis (1.5h) <br />1.100.000đ</th>\r\n<th>Oasis (1.5h) <br />1.100.000đ</th>\r\n</tr>\r\n</tbody>\r\n</table>\r\n</div>', 'H001565234072');
INSERT INTO `tlhotel_service` VALUES ('SV102001', 'abc', 'def', 'Giới thiệu', 'link1', 'H102');
INSERT INTO `tlhotel_service` VALUES ('SV102003', 'abc', 'def', 'Tẩm quất', 'link1', 'H102');

-- ----------------------------
-- Table structure for tlhotel_users
-- ----------------------------
DROP TABLE IF EXISTS `tlhotel_users`;
CREATE TABLE `tlhotel_users`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `access_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hotel_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_username_unique`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of tlhotel_users
-- ----------------------------
INSERT INTO `tlhotel_users` VALUES (1, 'admin', '$2y$10$IKlK5m3FXnekjVbWvGdks.UMtAUAMC05TXvBxzZuEawvjl58JfytK', 'admin', 'vqanYnJFUe5BRe73RepdM2mzQiTynD', '', NULL, '2019-08-16 08:57:16', 'Krxm7NoKXQGxSId8HJ8xbXyGF9oPBuMsjUEAtRN5qE587wTRjSLbq0OYOcag');
INSERT INTO `tlhotel_users` VALUES (2, 'anh', '$2y$10$uxMbTOWcf2H8zq.l7.1bOeUYIB3nd8WczrhZAoR8Cn1ZjIf3Ix1am', 'user', 'm0XSYDHl8kwQBNaZxHkvqC2vnrfCcu1562732111', 'H102', NULL, '2019-07-10 04:15:11', NULL);
INSERT INTO `tlhotel_users` VALUES (10, 'sunworld', '$2y$10$Mrdf5v43NTpOAwnPznzhXO3COnbAGLkv4zOwlF1gJdsLAcxqvhDfe', 'user', '0Dhjy6RoyJAktFRHyzrc4YxVlUBljy1565335869', 'H001562549621', '2019-07-08 01:33:41', '2019-08-09 07:31:09', '7Vkiu7myBGbyXcleDW5hw5vBgV32PbDEviSSCHCdEiSzmPUEMoVaN0in47ov');
INSERT INTO `tlhotel_users` VALUES (12, 'quanganh', '$2y$10$R53QQPL5wH46ScrshSIy5.uAacVYLGXjUi01toC5cv68EO7kKfIIS', 'user', 'OxCMe5200RZnFGILERmjVCaHe9PByZ1562957203', 'H001562957202', '2019-07-12 18:46:43', '2019-07-12 18:46:43', NULL);
INSERT INTO `tlhotel_users` VALUES (23, 'truonglam', '$2y$10$Y498kaoPWlBu3bAH5qBVFeb/tIbk1Xbd7OD/TyMxnoU6ueR.eRcW2', 'user', 'ny2HDLuNlaHXCHVAJFD69mMLJol2341565205375', 'H001565204608', '2019-08-07 19:03:28', '2019-08-07 19:16:15', NULL);
INSERT INTO `tlhotel_users` VALUES (24, 'lam123', '$2y$10$x4/zMZMsgmHbfMPvFROgNejMgJuALhmolRTxzis7H.R6kD1Uj3qW2', 'user', 'c7wdpzh1QglSiFEttE1f5Ksu4NX8WT1565336036', 'H001565234072', '2019-08-08 03:14:32', '2019-08-09 07:33:59', 'sIfiWqgEYh44KR7Eut0EypTunvSfXwJegzpUWRe8I2lNJGclekL2KGI548uO');

SET FOREIGN_KEY_CHECKS = 1;
