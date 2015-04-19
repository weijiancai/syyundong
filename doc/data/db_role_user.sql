/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-20 00:26:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `db_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `db_role_user`;
CREATE TABLE `db_role_user` (
  `user_id` int(11) default NULL,
  `role_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_role_user
-- ----------------------------
INSERT INTO `db_role_user` VALUES ('1', '1');
