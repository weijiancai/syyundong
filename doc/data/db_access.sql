/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-20 00:25:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `db_access`
-- ----------------------------
DROP TABLE IF EXISTS `db_access`;
CREATE TABLE `db_access` (
  `role_id` int(11) default NULL,
  `node_id` int(11) default NULL,
  `level` int(11) default NULL,
  `pid` int(11) default NULL,
  `module` varchar(50) default NULL,
  `group_id` int(11) default NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_access
-- ----------------------------
INSERT INTO `db_access` VALUES ('1', '1', '1', '0', null, '0');
