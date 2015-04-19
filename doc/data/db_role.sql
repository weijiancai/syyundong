/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-20 00:26:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `db_role`
-- ----------------------------
DROP TABLE IF EXISTS `db_role`;
CREATE TABLE `db_role` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  `pid` int(11) default NULL,
  `status` int(11) default NULL,
  `remark` varchar(225) default NULL,
  `create_time` int(11) default NULL,
  `update_time` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_role
-- ----------------------------
INSERT INTO `db_role` VALUES ('1', '超级管理员', '0', '1', '超级管理员', null, null);
INSERT INTO `db_role` VALUES ('2', '普通管理员', '1', '1', '普通管理员(小飞)', null, '1395133529');
INSERT INTO `db_role` VALUES ('3', '信息审核员', '1', '1', '信息审核员--翠萍\r\n', null, '1396575617');
INSERT INTO `db_role` VALUES ('4', '演示组', '3', '1', '演示组', '1387261755', '1387462351');
INSERT INTO `db_role` VALUES ('6', '广告管理员', '1', '1', '广告客服--庆影\r\n', '1394846541', null);
INSERT INTO `db_role` VALUES ('8', '商家管理员', '1', '1', '商家管理---小雪', '1395122871', null);
INSERT INTO `db_role` VALUES ('11', '广告查看', '1', '1', '张经理查看广告', '1396227328', null);
INSERT INTO `db_role` VALUES ('12', '客服组长', '1', '1', '赛男', '1396445382', null);
INSERT INTO `db_role` VALUES ('13', '营销专员', '1', '1', '何旭', '1400546216', '1402387641');
INSERT INTO `db_role` VALUES ('14', '信息审核员-李想', '0', '1', '信息审核员-李想', '1401074304', null);
INSERT INTO `db_role` VALUES ('16', '营销经理', '0', '1', '廖经理', '1402387676', null);
INSERT INTO `db_role` VALUES ('17', '装修客服', '0', '1', '', '1409623792', null);
