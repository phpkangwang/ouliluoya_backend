/*
 Navicat Premium Data Transfer

 Source Server         : 【互刷宝】
 Source Server Type    : MySQL
 Source Server Version : 50562
 Source Host           : 122.51.175.235:3306
 Source Schema         : hushuabao

 Target Server Type    : MySQL
 Target Server Version : 50562
 File Encoding         : 65001

 Date: 21/12/2019 20:34:23
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT 0 COMMENT 'user表id',
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `now_times` int(11) NOT NULL DEFAULT 0 COMMENT '阅当前助力数',
  `max_times` int(11) NOT NULL DEFAULT 0 COMMENT '最多助力次数',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否显示1显示2不显示',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '账户创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES (1, 1, 'https://www.baidu.com/', 2, 2, 2, 1576829007);
INSERT INTO `article` VALUES (2, 1, 'https://tool.lu/timestamp/', 1, 100, 2, 1576829036);
INSERT INTO `article` VALUES (3, 1, 'https://www.hao123.com/', 1, 250, 2, 1576829080);
INSERT INTO `article` VALUES (4, 2, 'https://www.360.cn/', 1, 110, 2, 1576829134);
INSERT INTO `article` VALUES (5, 1, 'https://www.hao123hao123.com', 1, 100, 2, 0);
INSERT INTO `article` VALUES (6, 1, 'https://www.hao123hao1231.com', 1, 100, 2, 0);
INSERT INTO `article` VALUES (7, 1, 'https://www.hao123hao1231.com', 0, 10, 1, 0);
INSERT INTO `article` VALUES (8, 1, 'https://www.hao123hao1231.com', 0, 10, 1, 0);
INSERT INTO `article` VALUES (9, 2, 'https://www.hao123hao1231.com', 0, 10, 1, 0);
INSERT INTO `article` VALUES (10, 2, 'https://www.hao123hao1231.com', 0, 10, 1, 0);

-- ----------------------------
-- Table structure for article_log
-- ----------------------------
DROP TABLE IF EXISTS `article_log`;
CREATE TABLE `article_log`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT 0 COMMENT 'user表id',
  `article_id` int(10) NOT NULL DEFAULT 0 COMMENT 'article表id',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '账户创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章阅读记录表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of article_log
-- ----------------------------
INSERT INTO `article_log` VALUES (2, 1, 2, 1576931013);
INSERT INTO `article_log` VALUES (3, 1, 3, 1576931016);
INSERT INTO `article_log` VALUES (4, 1, 4, 1576931019);
INSERT INTO `article_log` VALUES (5, 1, 5, 1576931037);
INSERT INTO `article_log` VALUES (6, 1, 6, 1576931041);

-- ----------------------------
-- Table structure for config
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config`  (
  `id` int(10) NOT NULL,
  `short_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '这个配置的简称',
  `content` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置内容',
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '配置描述',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `short_name`(`short_name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES (0, 'TRANSFER_MONEY', '20', '提现比例多少贡献值兑换一块钱');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `shop_id` int(11) NOT NULL COMMENT '商品id',
  `inner_order` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '内部订单号',
  `outer_order` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '外部订单号',
  `pay_price` int(10) NOT NULL DEFAULT 0 COMMENT '支付价格(分)',
  `pay_type` tinyint(2) NOT NULL DEFAULT 1 COMMENT '1微信支付',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1未支付 2已支付',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '修改时间',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for shop
-- ----------------------------
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop`  (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `price` int(10) NOT NULL DEFAULT 0 COMMENT '商品价格（分）',
  `contribution` int(3) NOT NULL DEFAULT 0 COMMENT '获取贡献值',
  `sort` int(10) NOT NULL DEFAULT 1 COMMENT '前端排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否显示1显示2不显示',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of shop
-- ----------------------------
INSERT INTO `shop` VALUES (1, 1, 50, 1, 1);
INSERT INTO `shop` VALUES (2, 5000, 700, 2, 1);
INSERT INTO `shop` VALUES (3, 10000, 2000, 3, 1);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `wx_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信唯一id',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户昵称',
  `image` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户头像',
  `token` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '登录凭证',
  `today_read` int(10) NOT NULL DEFAULT 0 COMMENT '今日阅读次数',
  `total_read` int(10) NOT NULL DEFAULT 0 COMMENT '总阅读次数',
  `today_contribution` int(10) NOT NULL DEFAULT 0 COMMENT '今日贡献度',
  `total_contribution` int(10) NOT NULL DEFAULT 0 COMMENT '总贡献度',
  `total_contribution_ty` int(10) NOT NULL DEFAULT 0 COMMENT '体验总贡献度',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '账户创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'wx11111', 'wangkang', '', 'eyJpZCI6IjEiLCJ0aW1lIjoxNTc2OTI3MTgxfQ==', 6, 0, 7, 1000, 100, 0);
INSERT INTO `user` VALUES (2, 'wx2222', 'wangkang2', '', '', 0, 0, 0, 0, 100, 0);

SET FOREIGN_KEY_CHECKS = 1;
