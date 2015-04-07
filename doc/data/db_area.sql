/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-07 16:28:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `db_area`
-- ----------------------------
DROP TABLE IF EXISTS `db_area`;
CREATE TABLE `db_area` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_area
-- ----------------------------
INSERT INTO `db_area` VALUES ('1', '宁江区');
INSERT INTO `db_area` VALUES ('2', '扶余县');
INSERT INTO `db_area` VALUES ('3', '乾安县');
INSERT INTO `db_area` VALUES ('4', '长岭县');
INSERT INTO `db_area` VALUES ('5', '前郭尔罗斯蒙古族自治县');
