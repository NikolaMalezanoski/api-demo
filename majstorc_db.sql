/*
 Navicat MySQL Data Transfer

 Source Server         : localhost 5.6.3
 Source Server Type    : MySQL
 Source Server Version : 50640
 Source Host           : localhost:3306
 Source Schema         : majstorc_db

 Target Server Type    : MySQL
 Target Server Version : 50640
 File Encoding         : 65001

 Date: 25/11/2019 23:31:29
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for client
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client`  (
  `cli_id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_email` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cli_password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `cli_first_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `cli_created_at` datetime(0) NOT NULL,
  `updated_at` datetime(0) NOT NULL,
  PRIMARY KEY (`cli_id`) USING BTREE,
  INDEX `cli_id`(`cli_id`) USING BTREE,
  INDEX `cli_email`(`cli_email`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of client
-- ----------------------------
INSERT INTO `client` VALUES (2, 'malezan@gmail.com', '12121212', NULL, '2019-11-25 23:26:06', '2019-11-25 23:26:06');

SET FOREIGN_KEY_CHECKS = 1;
