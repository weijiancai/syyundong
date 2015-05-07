/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-05-08 00:43:39
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

-- ----------------------------
-- Table structure for `db_activity`
-- ----------------------------
DROP TABLE IF EXISTS `db_activity`;
CREATE TABLE `db_activity` (
  `id` int(11) NOT NULL auto_increment COMMENT '活动ID',
  `name` varchar(40) NOT NULL COMMENT '名称（标题）',
  `sport_id` int(11) NOT NULL COMMENT '项目',
  `image` int(11) NOT NULL COMMENT '图片',
  `reg_begin_date` datetime NOT NULL COMMENT '报名开始时间',
  `reg_end_date` datetime NOT NULL COMMENT '报名结束时间',
  `start_date` datetime NOT NULL COMMENT '开始时间',
  `end_date` datetime NOT NULL COMMENT '结束时间',
  `limit_count` int(11) NOT NULL COMMENT '活动人数',
  `join_need_info` varchar(32) default NULL COMMENT '参加活动所需填写资料（1 真实姓名，2 性别，3 手机号码， 4 身份证号）',
  `is_need_verify` char(1) NOT NULL COMMENT '是否需要审核',
  `cost_type` int(1) NOT NULL COMMENT '费用类型（0 免费，1 收费）',
  `cost` decimal(10,0) default NULL COMMENT '费用',
  `province` varchar(32) NOT NULL COMMENT '省',
  `city` varchar(32) NOT NULL COMMENT '市',
  `region` varchar(32) NOT NULL COMMENT '区',
  `address` varchar(128) NOT NULL COMMENT '地点',
  `content` text COMMENT '赛事介绍',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  `interest_count` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_activity_sport_id` (`sport_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_activity
-- ----------------------------
INSERT INTO `db_activity` VALUES ('1', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-05-04 15:16:54', '2015-05-06 15:16:59', '2015-05-22 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('2', '游泳比赛', '28', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('3', '清明扫墓', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('4', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('5', '铂金路游泳馆', '26', '0', '2015-04-07 13:05:45', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '1', '2', '3', '553号', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('6', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('7', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('8', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('9', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('10', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('11', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('12', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('13', '开春踏青', '29', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '1', '25');
INSERT INTO `db_activity` VALUES ('14', '羽毛球活动', '28', '0', '2015-04-26 22:50:46', '2015-04-30 22:50:47', '2015-06-04 00:00:00', '2015-06-30 00:00:00', '34', ',1,3,4,', 'T', '1', '56', '1', '2', '3', '铂金路', '铂金路铂金路铂金路铂金路铂金路', '2015-04-27 00:04:09', '1', '11');

-- ----------------------------
-- Table structure for `db_doyen_hall`
-- ----------------------------
DROP TABLE IF EXISTS `db_doyen_hall`;
CREATE TABLE `db_doyen_hall` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID',
  `name` varchar(64) NOT NULL COMMENT '达人名称',
  `image` int(11) NOT NULL COMMENT '图片',
  `description` varchar(512) default NULL COMMENT '简介',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_doyen_hall
-- ----------------------------
INSERT INTO `db_doyen_hall` VALUES ('1', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('2', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('3', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('4', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('5', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('6', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('7', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('8', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('9', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('10', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('11', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('12', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('13', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('14', '魏建才', '13', 'IIT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精英IT精', '2015-05-03 21:24:16', '1');
INSERT INTO `db_doyen_hall` VALUES ('17', '刘立婷', '158', '<p>刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷刘立婷</p>', '2015-05-04 23:14:36', '1');

-- ----------------------------
-- Table structure for `db_game`
-- ----------------------------
DROP TABLE IF EXISTS `db_game`;
CREATE TABLE `db_game` (
  `id` int(11) NOT NULL auto_increment COMMENT '赛事ID',
  `name` varchar(40) NOT NULL COMMENT '名称（标题）',
  `sport_id` int(11) NOT NULL COMMENT '比赛项目',
  `sport_sid` int(11) default NULL,
  `image` int(11) NOT NULL COMMENT '图片',
  `reg_begin_date` datetime NOT NULL COMMENT '报名开始时间',
  `reg_end_date` datetime NOT NULL COMMENT '报名结束时间',
  `start_date` datetime NOT NULL COMMENT '开始时间',
  `end_date` datetime NOT NULL COMMENT '结束时间',
  `limit_count` int(11) NOT NULL COMMENT '人数限制',
  `cost` decimal(10,0) default NULL COMMENT '报名费',
  `province` varchar(16) NOT NULL COMMENT '举办城市',
  `city` int(11) default NULL,
  `region` int(11) default NULL,
  `address` varchar(128) NOT NULL COMMENT '地点',
  `sponsor` varchar(128) NOT NULL COMMENT '赛事发起方',
  `phone` varchar(16) NOT NULL COMMENT '联系方式',
  `apply_name` varchar(16) NOT NULL COMMENT '申请人姓名',
  `apply_phone` varchar(16) NOT NULL COMMENT '申请人电话',
  `apply_email` varchar(32) NOT NULL COMMENT '申请人邮箱',
  `description` varchar(512) NOT NULL COMMENT '推荐语',
  `game_declare` text COMMENT '参赛声明',
  `content` text COMMENT '赛事介绍',
  `member_right` text COMMENT '会员权益',
  `aout_route` text COMMENT '比赛路线',
  `about_cost` text COMMENT '关于费用',
  `about_trip` text COMMENT '行程安排',
  `about_hotal` text COMMENT '入住酒店',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  `is_verify` char(1) NOT NULL,
  `verify_date` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_game_sport_id` (`sport_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8 COMMENT='赛事活动';

-- ----------------------------
-- Records of db_game
-- ----------------------------
INSERT INTO `db_game` VALUES ('1', '四季跑', '1', '16', '13', '2015-03-26 08:00:00', '2015-05-10 17:00:53', '2015-05-12 00:00:05', '2015-05-22 00:00:12', '5', '10', '1', '1', '3', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', '<p>1、本人自愿报名参加2015四季跑·南京站活动;&nbsp;</p><p>2、本人全面理解并同意遵守组委会及协办机构(以下统称“组办方”)所制订的各项规程、规则、规定、要求及采取的措施;&nbsp;</p><p>3、本人已在医院做好体检，身体健康，为参加活动做好充分准备；</p><p>4、本人全面理解活动可能出现的风险，且已准备必要的防范措施;本人愿意承担活动期间发生的自身意外风险责任，且同意组办方对于非组办方原因造成的伤害、死亡或其他任何形式的损失不承担任何形式的赔偿;&nbsp;</p><p>5、本人同意接受组办方在活动期间提供的现场急救性质的医务治疗，但在医院救治等发生的相关费用由本人自理;&nbsp;</p><p>6、本人授权组办方及指定媒体无偿使用本人的肖像、姓名、声音和其它个人资料用于活动的组织和推广;</p><p>7、本人承诺以自己的名义报名并参与活动，绝不将报名后获得的号码布以任何方式转让给他人;&nbsp;</p><p>8、本人同意在活动前和活动期间不损害、更改及遮盖四季跑官方号码布;</p><p>9、本人同意向组办方提供有效的身份证件和资料用于核实本人的身份，并同意承担因身份证件和资料不实所产生的全部责任;</p><p>10、本人同意组办方以本人为被保险人投保人身意外险，具体内容已从保险说明书中知晓，本人均予以认可。&nbsp;</p><p>11、本人或法定代理人已认真阅读并全面理解以上内容，且对上述所有内容予以确认并承担相应的法律责任。&nbsp;</p><p>12、本人承诺报名信息填写真实有效，本人承诺合法监护人已知晓本人参与活动意愿并同意本人参与活动，合法监护人应尽到完全监护义务，如在活动现场出现任何非组办方原因导致的意外，四季跑组办方不承担任何责任。&nbsp;</p><p>13、本人承诺如因本人个人原因引起的任何连带责任由本人自行承担。&nbsp;</p><p>14、本人自愿携未成年子女参加2015四季跑·南京站活动。&nbsp;</p><p>15、本人的未成年子女身体健康，为参与跑步活动做好充分准备。&nbsp;</p><p>16、本人承诺在活动期间自行照看未成年子女，因在跑步和活动现场出现非组办方原因导致的意外，与四季跑组办方无关，本人自行承担所造成的一切后果。</p>', '测试内容1', null, '白城-松原', '7899', '松原-长春', '如家酒店', '0000-00-00 00:00:00', '0', 'T', null);
INSERT INTO `db_game` VALUES ('2', '四季跑城市PK塞', '2', '16', '14', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '3', '松原', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('21', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '3', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, '测试内容1', null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('11', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '3', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, '测试内容1', null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('12', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '3', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, '测试内容1', null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('13', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '3', '松原', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('14', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '3', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, '测试内容1', null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('15', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '3', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, '测试内容1', null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('16', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '4', '松原', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('17', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '4', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, '测试内容1', null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('18', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '4', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, '测试内容1', null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('19', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '4', '松原', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('20', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '4', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, '测试内容1', null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('27', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-04-09 17:00:53', '2015-04-11 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '4', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('22', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '4', '松原', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('23', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '4', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('24', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '4', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('25', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '4', '', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('26', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '5', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('47', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('28', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '5', '', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('29', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('30', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '7', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('31', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '7', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('32', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '7', '', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('33', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '7', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('34', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '5', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('35', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '5', '', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('36', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('37', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '7', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('38', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '5', '', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('39', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-05-31 00:00:12', '1', '10', '1', '1', '5', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('40', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-05-31 00:00:12', '1', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('41', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-05-31 00:00:12', '1', null, '1', '1', '7', '', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('42', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '1', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('43', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '1', '10', '1', '1', '5', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('44', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '1', null, '1', '1', '4', '', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '0', 'T', null);
INSERT INTO `db_game` VALUES ('45', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '1', '10', '1', '1', '5', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('66', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '1', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('49', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '1', '10', '1', '1', '7', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('50', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '1', '10', '1', '1', '3', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('51', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '1', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('53', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '1', '10', '1', '1', '3', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('54', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '5', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('55', '四季跑城市PK塞', '2', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '10', null, '1', '1', '5', '', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '', null, '对反对反对法', null, null, null, null, null, '2015-04-02 21:53:34', '1', 'F', '2015-04-24 00:15:20');
INSERT INTO `db_game` VALUES ('56', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('57', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '7', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('59', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '7', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('60', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('62', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '对反对反对法', null, null, null, null, null, null, null, '2015-04-23 23:59:53', '1', 'F', '2015-04-24 00:15:24');
INSERT INTO `db_game` VALUES ('63', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '6', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 21:53:28', '0', 'T', null);
INSERT INTO `db_game` VALUES ('64', '最新内容', '1', null, '11', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-04-01 00:00:05', '2015-04-30 00:00:12', '10', '300', '1', '1', '5', '松原金钻', '大幅度', '18844882669', '22222', '18844882668', '18844882668@125.com', '享受运动的快了', null, '对反对反对法', null, null, null, null, null, '2015-04-23 23:37:50', '1', 'T', '2015-04-24 00:15:51');
INSERT INTO `db_game` VALUES ('65', '四季跑城市PK塞', '1', '16', '0', '2015-03-26 08:00:00', '2015-03-30 17:00:53', '2015-03-31 00:00:05', '2015-04-23 00:00:12', '20', '10', '1', '1', '5', '松原', '吉林省长跑马拉松公司', '18844882669', ' 刘立婷', '18844882669', '404945547@qq.com', '', null, null, null, null, null, null, null, '2015-04-02 17:00:53', '0', 'T', null);
INSERT INTO `db_game` VALUES ('67', '网球球比赛', '1', '9', '152', '2015-04-25 00:26:06', '2015-04-27 00:26:10', '2015-05-07 00:00:00', '2015-05-14 00:00:00', '20', '100', '1', '1', '6', '铂金路', '松原运动网', '18844882669', '刘丽婷', '18844882669', '30393003@qq.com', '松原运动网松原运动网松原运动网', null, null, null, null, null, null, null, '2015-04-24 00:31:13', '1', 'T', null);
INSERT INTO `db_game` VALUES ('68', '台球比赛', '1', '8', '150', '2015-04-24 00:32:46', '2015-04-25 00:32:48', '2015-05-15 00:00:00', '2015-06-19 00:00:00', '12', '123', '1', '1', '7', '松原金钻', '松原运动网', '18844882669', '刘丽婷', '18844882669', '30393003@qq.com', '松原运动网松原运动网松原运动网松原运动网', '<p><span style=\"color: rgb(255, 0, 0);\"><strong>1、本人自愿报名参加2015四季跑·南京站活动;</strong></span></p><p>2、本人全面理解并同意遵守组委会及协办机构(以下统称“组办方”)所制订的各项规程、规则、规定、要求及采取的措施;<br/>3、本人已在医院做好体检，身体健康，为参加活动做好充分准备；<br/>4、本人全面理解活动可能出现的风险，且已准备必要的防范措施;本人愿意承担活动期间发生的自身意外风险责任，且同意组办方对于非组办方原因造成的伤害、死亡或其他任何形式的损失不承担任何形式的赔偿;<br/>5、本人同意接受组办方在活动期间提供的现场急救性质的医务治疗，但在医院救治等发生的相关费用由本人自理;<br/>6、本人授权组办方及指定媒体无偿使用本人的肖像、姓名、声音和其它个人资料用于活动的组织和推广;<br/>7、本人承诺以自己的名义报名并参与活动，绝不将报名后获得的号码布以任何方式转让给他人;<br/>8、本人同意在活动前和活动期间不损害、更改及遮盖四季跑官方号码布;<br/>9、本人同意向组办方提供有效的身份证件和资料用于核实本人的身份，并同意承担因身份证件和资料不实所产生的全部责任;<br/>10、本人同意组办方以本人为被保险人投保人身意外险，具体内容已从保险说明书中知晓，本人均予以认可。<br/>11、本人或法定代理人已认真阅读并全面理解以上内容，且对上述所有内容予以确认并承担相应的法律责任。<br/>12、本人承诺报名信息填写真实有效，本人承诺合法监护人已知晓本人参与活动意愿并同意本人参与活动，合法监护人应尽到完全监护义务，如在活动现场出现任何非组办方原因导致的意外，四季跑组办方不承担任何责任。<br/>13、本人承诺如因本人个人原因引起的任何连带责任由本人自行承担。<br/>14、本人自愿携未成年子女参加2015四季跑·南京站活动。<br/>15、本人的未成年子女身体健康，为参与跑步活动做好充分准备。<br/>16、本人承诺在活动期间自行照看未成年子女，因在跑步和活动现场出现非组办方原因导致的意外，与四季跑组办方无关，本人自行承担所造成的一切后果。</p>', null, null, null, null, null, null, '2015-04-24 00:32:06', '0', 'T', null);

-- ----------------------------
-- Table structure for `db_group`
-- ----------------------------
DROP TABLE IF EXISTS `db_group`;
CREATE TABLE `db_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `title` varchar(50) default NULL,
  `create_time` int(11) default NULL,
  `update_time` int(11) default NULL,
  `status` int(11) default NULL,
  `sort` int(11) default NULL,
  `show` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_group
-- ----------------------------
INSERT INTO `db_group` VALUES ('1', 'GFilm', '今日电影', null, null, '0', '10', null);
INSERT INTO `db_group` VALUES ('2', 'GCon', '综合信息', null, null, '0', '9', null);
INSERT INTO `db_group` VALUES ('3', 'GSystem', '系统设置', null, null, '1', '1', null);
INSERT INTO `db_group` VALUES ('4', 'GGame', '赛事管理', null, null, '1', '4', null);
INSERT INTO `db_group` VALUES ('5', 'GActivity', '活动管理', null, null, '1', '5', null);
INSERT INTO `db_group` VALUES ('6', 'GVenue', '场馆管理', null, null, '1', '6', null);
INSERT INTO `db_group` VALUES ('7', 'GDoyen', '达人协会', null, null, '1', '7', null);
INSERT INTO `db_group` VALUES ('8', 'GResume', '简历管理', null, null, '0', '8', null);
INSERT INTO `db_group` VALUES ('9', 'GSite', '基础信息', null, null, '1', '2', null);
INSERT INTO `db_group` VALUES ('10', 'GMember', '会员管理', null, null, '1', '3', null);
INSERT INTO `db_group` VALUES ('11', 'GBussCard', '商家名片', null, null, '0', '11', null);
INSERT INTO `db_group` VALUES ('12', 'GShopmanager', '商城管理', null, null, '0', '13', null);

-- ----------------------------
-- Table structure for `db_images`
-- ----------------------------
DROP TABLE IF EXISTS `db_images`;
CREATE TABLE `db_images` (
  `id` int(11) NOT NULL auto_increment COMMENT '图片ID',
  `local_url` varchar(128) NOT NULL COMMENT '图片URL',
  `banner_desc` varchar(64) default NULL COMMENT 'banner描述',
  `size1_url` varchar(128) default NULL COMMENT '尺寸1URL（banner 505x355）',
  `size2_url` varchar(128) default NULL COMMENT '尺寸2URL',
  `size3_url` varchar(128) default NULL COMMENT '尺寸3URL',
  `size4_url` varchar(128) default NULL COMMENT '尺寸4URL',
  `size5_url` varchar(128) default NULL COMMENT '尺寸5URL',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=160 DEFAULT CHARSET=utf8 COMMENT='图片';

-- ----------------------------
-- Records of db_images
-- ----------------------------
INSERT INTO `db_images` VALUES ('1', '/Public/upload/game/20150423/55390c546970d.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('2', '/Public/upload/game/20150423/55390c546970d.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('3', '/Public/upload/game/20150423/55390c0b35996.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('4', '/Public/upload/game/20150423/55390c546970d.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('5', '/Public/upload/game/20150423/55390cbbde5be.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('6', '/Public/upload/game/20150423/55390d12680ca.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('7', '/Public/upload/game/20150423/55390dd2ac2da.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('8', '/Public/upload/game/20150423/55390e07bf590.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('9', '/Public/upload/game/20150423/55390ea8397c4.png', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('10', '/Public/upload/game/20150423/553911c629b55.png', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('11', '/Public/upload/game/20150423/553911d4c2fc6.png', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('12', '/Public/upload/game/20150424/55391c73b199c.png', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('13', '/Public/upload/game/20150424/55391d43928bf.png', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('14', '/Public/upload/game/20150424/55391e9c8fe93.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('15', '/Public/upload/game/20150425/553a6f08e0e66.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('16', '/Public/upload/activity/20150426/553cac3d8e44c.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('17', '/Public/upload/activity/20150426/553cfac50afa4.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('18', '/Public/upload/activity/20150426/553cfb677ab59.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('19', '/Public/upload/activity/20150427/553d1472b6576.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('20', '/Public/upload/activity/20150427/553d150e2c979.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('21', '/Public/upload/game/20150430/55421b5372f72.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('22', '/Public/upload//20150501/5542da620c1b3.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('23', '/Public/upload//20150501/5542da89e1bd5.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('24', '/Public/upload//20150501/5542daa598cc8.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('25', '/Public/upload//20150501/5542db21ebcf6.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('26', '/Public/upload//20150501/5542db4dd1b9a.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('27', '/Public/upload//20150501/5542db68cc4e5.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('28', '/Public/upload//20150501/5542db8ed3b11.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('29', '/Public/upload//20150501/5542dcbb69301.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('30', '/Public/upload//20150501/5542e4f985e3a.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('31', '/Public/upload/sport/20150501/5542e71231c8d.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('32', '/Public/upload/sport/20150501/5542e7a4ed5ea.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('33', '/Public/upload/sport/20150501/5542e7dcca788.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('34', '/Public/upload/sport/20150501/5542e8426dc67.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('35', '/Public/upload/sport/20150501/5542e896365f7.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('36', '/Public/upload/sport/20150501/5542ea00b1483.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('37', '/Public/upload/sport/20150501/5542ea16cda0d.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('38', '/Public/upload/sport/20150501/5542ea2e47844.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('39', '/Public/upload/sport/20150501/5542ecd8a0c37.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('40', '/Public/upload/sport/20150501/5542ef124e749.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('41', '/Public/upload/sport/20150501/5542ef1be2fea.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('42', '/Public/upload/sport/20150501/5542ef3e15dfc.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('43', '/Public/upload/sport/20150501/5542ef58abada.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('44', '/Public/upload/sport/20150501/5542efaec687e.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('45', '/Public/upload/sport/20150501/5542efb5b80f4.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('46', '/Public/upload/sport/20150501/5542effe2a8fc.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('47', '/Public/upload/sport/20150501/5542f08345bdd.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('48', '/Public/upload/sport/20150501/5542f09c57ae3.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('49', '/Public/upload/sport/20150501/5542f0ec82e8d.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('50', '/Public/upload/sport/20150501/5542f33d67479.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('51', '/Public/upload/sport/20150501/5542f384ce228.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('52', '/Public/upload/sport/20150501/5542f3b5ccc3c.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('53', '/Public/upload/sport/20150501/5542f3c9a6bf0.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('54', '/Public/upload/sport/20150501/5542f44354e43.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('55', '/Public/upload/user/20150501/554315fbb8380.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('56', '/Public/upload/user/20150501/5543164641174.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('57', '/Public/upload/user/20150501/5543164b080ca.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('58', '/Public/upload/user/20150501/55431686be6e3.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('59', '/Public/upload/user/20150501/554316eb21afd.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('60', '/Public/upload/user/20150501/554316fd5b473.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('61', '/Public/upload/user/20150501/5543199dd6733.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('62', '/Public/upload/user/20150501/55431cce52dba.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('63', '/Public/upload/user/20150501/55431d0438eb8.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('64', '/Public/upload/user/20150501/55431d241ec51.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('65', '/Public/upload/user/20150501/55431d64323df.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('66', '/Public/upload/user/20150501/55431ddbbcb4f.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('67', '/Public/upload/user/20150501/55431e4d81d41.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('68', '/Public/upload/user/20150501/55431e74e94b3.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('69', '/Public/upload/user/20150501/55431f1cb7c2f.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('70', '/Public/upload/user/20150501/554321a0619c6.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('71', '/Public/upload/user/20150501/554322c7a9409.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('72', '/Public/upload/user/20150501/55432438031c8.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('73', '/Public/upload/user/20150503/5545581b28fcf.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('74', '/Public/upload/user/20150503/554558769c60f.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('75', '/Public/upload/user/20150503/55455921ed983.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('76', '/Public/upload/user/20150503/55455978dba2e.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('77', '/Public/upload/user/20150503/554559942d96e.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('78', '/Public/upload/topic/20150503/554559afac571.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('79', '/Public/upload/topic/20150503/554559d1233de.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('80', '/Public/upload/topic/20150503/554559ee2a991.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('81', '/Public/upload/topic/20150503/55455a0266efc.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('82', '/Public/upload/topic/20150503/55455a54e5ced.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('83', '/Public/upload/topic/20150503/55455a851be39.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('84', '/Public/upload/topic/20150503/55455a8d1e810.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('85', '/Public/upload/topic/20150503/55455ad938e1d.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('86', '/Public/upload/topic/20150503/55455af0ac18b.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('87', '/Public/upload/topic/20150503/55455afe0879c.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('88', '/Public/upload/topic/20150503/55455b5f129e2.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('89', '/Public/upload/topic/20150503/55455b63b7939.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('90', '/Public/upload/topic/20150503/55455c4542d31.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('91', '/Public/upload/topic/20150503/55455c52368b2.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('92', '/Public/upload/topic/20150503/55455c70819b3.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('93', '/Public/upload/topic/20150503/55455c803da7b.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('94', '/Public/upload/topic/20150503/55455dceb2a52.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('95', '/Public/upload/topic/20150503/55455de6d59aa.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('96', '/Public/upload/topic/20150503/55455ee7376e0.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('97', '/Public/upload/topic/20150503/55455f01cc878.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('98', '/Public/upload/topic/20150503/55455f84403d5.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('99', '/Public/upload/topic/20150503/55455f997d9bd.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('100', '/Public/upload/topic/20150503/55455fdc0c433.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('101', '/Public/upload/topic/20150503/55455fdfc8bb3.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('102', '/Public/upload/topic/20150503/5545600f292c4.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('103', '/Public/upload/topic/20150503/55456107cccd8.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('104', '/Public/upload/topic/20150503/5545611564c77.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('105', '/Public/upload/topic/20150503/55456148ae315.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('106', '/Public/upload/topic/20150503/55456170bf81c.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('107', '/Public/upload/topic/20150503/554561b56f1e6.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('108', '/Public/upload/topic/20150503/554561b943bf2.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('109', '/Public/upload/topic/20150503/554561c9e1f31.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('110', '/Public/upload/topic/20150503/554561ce31695.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('111', '/Public/upload/topic/20150503/55456289afe46.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('112', '/Public/upload/topic/20150503/5545628dcaae7.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('113', '/Public/upload/topic/20150503/554562a05b02f.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('114', '/Public/upload/topic/20150503/554562cc8a692.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('115', '/Public/upload/topic/20150503/5545635643f53.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('116', '/Public/upload/topic/20150503/554563a78f839.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('117', '/Public/upload/topic/20150503/554564c303319.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('118', '/Public/upload/topic/20150503/55456534d0f61.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('119', '/Public/upload/topic/20150503/554566f3746d7.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('120', '/Public/upload/topic/20150503/554566f7ed704.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('121', '/Public/upload/topic/20150503/554566febc335.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('122', '/Public/upload/topic/20150503/5545670f0191a.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('123', '/Public/upload/topic/20150503/5545671f0c3ba.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('124', '/Public/upload/topic/20150503/5545674103e9a.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('125', '/Public/upload/topic/20150503/554567446d97c.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('126', '/Public/upload/topic/20150503/5545675b574a3.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('127', '/Public/upload/topic/20150503/554567656b5d6.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('128', '/Public/upload/topic/20150503/55456768de970.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('129', '/Public/upload/topic/20150503/554567af1f0eb.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('130', '/Public/upload/topic/20150503/554567b304e57.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('131', '/Public/upload/topic/20150503/554567bec9aad.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('132', '/Public/upload/topic/20150503/554567c5bb9cf.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('133', '/Public/upload/topic/20150503/554567cc8420e.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('134', '/Public/upload/topic/20150503/554567f2eae62.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('135', '/Public/upload/topic/20150503/554567f65c450.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('136', '/Public/upload/topic/20150503/554567fc8c34e.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('137', '/Public/upload/topic/20150503/554568027642f.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('138', '/Public/upload/topic/20150503/55459564e03a2.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('139', '/Public/upload/topic/20150503/5545956a6b26d.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('140', '/Public/upload/topic/20150503/554595b68c47c.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('141', '/Public/upload/topic/20150503/554595b9e0fdb.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('142', '/Public/upload/topic/20150503/5545961426dec.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('143', '/Public/upload/topic/20150503/55459663d6b69.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('144', '/Public/upload/topic/20150503/55459666e00bd.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('145', '/Public/upload/topic/20150503/55459723aef1b.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('146', '/Public/upload/topic/20150503/5545977000821.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('147', '/Public/upload/topic/20150503/55459802293db.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('148', '/Public/upload/topic/20150503/554598aee41f1.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('149', '/Public/upload/topic/20150503/554598d668070.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('150', '/Public/upload/game/20150504/55477a8529bd9.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('151', '/Public/upload/game/20150504/55477aac0f5b1.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('152', '/Public/upload/game/20150504/55477b24ca669.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('153', '/Public/upload/game/20150504/55477c506a832.jpg', null, null, null, null, null, null);
INSERT INTO `db_images` VALUES ('154', '/Public/upload/game/20150504/55477f0c4535f.jpg', null, null, '/Public/upload/game/s_20150504/55477f0c4535f.jpg', null, null, null);
INSERT INTO `db_images` VALUES ('155', '/Public/upload/game/20150504/554780ff2abf7.JPG', null, null, '/Public/upload/game/s_20150504/554780ff2abf7.JPG', null, null, null);
INSERT INTO `db_images` VALUES ('156', '/Public/upload/game/20150504/55478b065028e.jpg', null, null, '/Public/upload/game/s_20150504/55478b065028e.jpg', null, null, null);
INSERT INTO `db_images` VALUES ('157', '/Public/upload/doyen/20150504/55478c185bc2d.jpg', null, null, '/Public/upload/doyen/s_20150504/55478c185bc2d.jpg', null, null, null);
INSERT INTO `db_images` VALUES ('158', '/Public/upload/doyen/20150504/55478ce0b9df8.jpg', null, null, '/Public/upload/doyen/s_20150504/55478ce0b9df8.jpg', null, null, null);
INSERT INTO `db_images` VALUES ('159', '/Public/upload/association/20150504/55478f191c1f9.jpg', null, null, '/Public/upload/association/s_20150504/55478f191c1f9.jpg', null, null, null);

-- ----------------------------
-- Table structure for `db_node`
-- ----------------------------
DROP TABLE IF EXISTS `db_node`;
CREATE TABLE `db_node` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `link` varchar(50) default NULL,
  `title` varchar(50) default NULL,
  `status` int(11) default NULL,
  `remark` varchar(225) default NULL,
  `sort` int(11) default NULL,
  `pid` int(11) default NULL,
  `level` int(11) default NULL,
  `group_id` int(11) default NULL,
  `show` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=459 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_node
-- ----------------------------
INSERT INTO `db_node` VALUES ('1', 'Syweblg2015', 'Syweblg2015', '后台管理', '1', '后台项目', '0', '0', '1', '0', '0');
INSERT INTO `db_node` VALUES ('20', 'LRole', 'LRole', '角色管理', '1', '模块', '10', '1', '2', '3', '0');
INSERT INTO `db_node` VALUES ('32', 'Public', 'Public', '公共模块', '1', '控制器', '360', '1', '2', '0', '0');
INSERT INTO `db_node` VALUES ('33', 'add', 'add', '新增', '1', '动作', '361', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('34', 'insert', 'insert', '写入', '1', '动作', '364', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('35', 'edit', 'edit', '编辑', '1', '动作', '362', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('36', 'index', 'index', '列表', '1', '动作', '363', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('37', 'resume', 'resume', '恢复', '1', '动作', '365', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('38', 'forbid', 'forbid', '禁用', '1', '动作', '366', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('39', 'update', 'update', '更新', '1', '动作', '367', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('40', 'delAll', 'delAll', '删除', '1', '动作', '368', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('41', 'Index', 'Index', '默认模块', '1', '控制器', '370', '1', '2', '0', '0');
INSERT INTO `db_node` VALUES ('42', 'index', 'index', '首页模块', '1', '动作', '372', '41', '3', '0', '0');
INSERT INTO `db_node` VALUES ('43', 'main', 'main', '空白首页', '1', '动作', '371', '41', '3', '0', '0');
INSERT INTO `db_node` VALUES ('44', 'DbGroup', 'DbGroup', '分组管理', '1', '模块', '15', '1', '2', '3', '0');
INSERT INTO `db_node` VALUES ('45', 'add', 'add', '增加分组', '1', '动作', '16', '44', '3', '0', '0');
INSERT INTO `db_node` VALUES ('46', 'edit', 'edit', '修改分组', '1', '动作', '17', '44', '3', '0', '0');
INSERT INTO `db_node` VALUES ('47', 'del', 'dl', '删除分组', '1', '动作', '18', '44', '3', '0', '0');
INSERT INTO `db_node` VALUES ('65', 'DzSport', 'DzSport', '赛事分类', '1', '模块', '40', '1', '2', '9', '0');
INSERT INTO `db_node` VALUES ('86', 'OpGameNews', 'OpGameNews', ' 赛事新闻', '1', '模块', '70', '1', '2', '4', '0');
INSERT INTO `db_node` VALUES ('93', 'DzActivityVenue', 'DzActivityVenue', '活动|场馆分类', '1', '模块', '50', '1', '2', '9', '0');
INSERT INTO `db_node` VALUES ('95', 'LUser', 'LUser', '管理员', '1', '模块', '1', '1', '2', '3', '0');
INSERT INTO `db_node` VALUES ('127', 'DbNode', 'DbNode', '权限管理', '1', '模块', '20', '1', '2', '3', '0');
INSERT INTO `db_node` VALUES ('132', 'second', 'second', '赛事详情页面', '1', '操作', '41', '0', '3', '0', '0');
INSERT INTO `db_node` VALUES ('458', 'DbSportAssociation', 'DbSportAssociation', '体育协会', '1', '模块', '130', '1', '2', '7', '1');
INSERT INTO `db_node` VALUES ('455', 'DbVenue', 'DbVenue', '场馆管理', '1', '模块', '110', '1', '2', '6', '1');
INSERT INTO `db_node` VALUES ('456', 'OpJoinActivity', 'OpJoinActivity', '活动报名', '1', '模块', '95', '1', '2', '5', '1');
INSERT INTO `db_node` VALUES ('457', 'DbDoyenHall', 'DbDoyenHall', '达人堂', '1', '模块', '120', '1', '2', '7', '1');
INSERT INTO `db_node` VALUES ('454', 'DbUser', 'DbUser', '会员管理', '1', '模块', '100', '1', '2', '10', '1');
INSERT INTO `db_node` VALUES ('451', 'DbGame', 'DbGame', '赛事管理', '1', '模块', '60', '1', '2', '4', '1');
INSERT INTO `db_node` VALUES ('453', 'DbActivity', 'DbActivity', '活动管理', '1', '模块', '90', '1', '2', '5', '1');
INSERT INTO `db_node` VALUES ('452', 'OpGameNotice', 'OpGameNotice', '赛事公告', '1', '模块', '80', '1', '2', '4', '1');
INSERT INTO `db_node` VALUES ('189', 'insert_second', 'insert_second', '赛事详情更新', '1', '操作', '42', '65', '3', '0', '0');
INSERT INTO `db_node` VALUES ('200', 'foreverdelete', 'foreverdelete', '彻底删除', '1', '操作', '369', '32', '3', '0', '0');
INSERT INTO `db_node` VALUES ('258', 'node', 'node', '分组节点', '1', '操作', '21', '127', '3', '0', '0');

-- ----------------------------
-- Table structure for `db_region`
-- ----------------------------
DROP TABLE IF EXISTS `db_region`;
CREATE TABLE `db_region` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID',
  `name` varchar(64) NOT NULL COMMENT '区域名称 ',
  `pid` int(11) NOT NULL COMMENT '父ID',
  `level` int(11) default NULL COMMENT '层级',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='区域信息';

-- ----------------------------
-- Records of db_region
-- ----------------------------
INSERT INTO `db_region` VALUES ('1', '吉林省', '0', '1');
INSERT INTO `db_region` VALUES ('2', '松原市', '1', '2');
INSERT INTO `db_region` VALUES ('3', '宁江区', '2', '3');
INSERT INTO `db_region` VALUES ('4', '扶余县', '2', '3');
INSERT INTO `db_region` VALUES ('5', '乾安县', '2', '3');
INSERT INTO `db_region` VALUES ('6', '长岭县', '2', '3');
INSERT INTO `db_region` VALUES ('7', '前郭尔罗斯蒙古族自治县', '2', '3');
INSERT INTO `db_region` VALUES ('8', '金钻商圈', '3', '4');
INSERT INTO `db_region` VALUES ('9', '商贸小区', '3', '4');

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

-- ----------------------------
-- Table structure for `db_sport_association`
-- ----------------------------
DROP TABLE IF EXISTS `db_sport_association`;
CREATE TABLE `db_sport_association` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID',
  `name` varchar(64) NOT NULL COMMENT '协会名称',
  `image` int(11) NOT NULL COMMENT '图片',
  `description` varchar(512) default NULL COMMENT '简介',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_sport_association
-- ----------------------------
INSERT INTO `db_sport_association` VALUES ('1', '乒乓球协会', '12', '乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('2', '乒乓球协会', '12', '乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('3', '乒乓球协会', '12', '乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('4', '乒乓球协会', '12', '乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('5', '乒乓球协会', '12', '乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('6', '乒乓球协会', '12', '乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('7', '乒乓球协会', '12', '乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('8', '乒乓球协会', '12', '乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('9', '乒乓球协会', '12', '乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于', '2015-05-03 21:07:34', '1');
INSERT INTO `db_sport_association` VALUES ('10', '乒乓球协会', '159', '<p>乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于乒乓球协会成立于</p>', '2015-05-04 23:24:02', '1');

-- ----------------------------
-- Table structure for `db_user`
-- ----------------------------
DROP TABLE IF EXISTS `db_user`;
CREATE TABLE `db_user` (
  `id` int(11) NOT NULL auto_increment COMMENT '用户ID',
  `name` varchar(64) NOT NULL COMMENT '姓名',
  `user_head` int(11) NOT NULL COMMENT '用户头像',
  `nick_name` char(10) default NULL COMMENT '昵称',
  `password` varchar(64) NOT NULL COMMENT '密码',
  `gender` char(1) NOT NULL COMMENT '性别（F 女，M 男）',
  `blood_type` char(2) default NULL COMMENT '血型（A，B，AB，O，RH，MN，其它 ）',
  `birthday` date default NULL COMMENT '生日',
  `company` varchar(64) default NULL COMMENT '公司',
  `certificate_type` varchar(10) default NULL COMMENT '证件类型（身份证，军官证，学生证，护照）',
  `certificate_num` varchar(64) default NULL COMMENT '证件号码',
  `height` int(11) default NULL COMMENT '身高',
  `weight` decimal(10,0) default NULL COMMENT '体重',
  `mobile` varchar(16) NOT NULL default '' COMMENT '手机号码',
  `email` varchar(64) default NULL COMMENT '邮箱',
  `postal_code` varchar(16) default NULL COMMENT '邮编',
  `address` varchar(128) default NULL COMMENT '通讯地址',
  `signature` varchar(64) default NULL COMMENT '个性签名',
  `interest` varchar(512) default NULL COMMENT '运动喜好（多值，逗号分隔）',
  `verify_code` varchar(10) default NULL COMMENT '验证码',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  PRIMARY KEY  (`id`,`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='用户';

-- ----------------------------
-- Records of db_user
-- ----------------------------
INSERT INTO `db_user` VALUES ('1', 'admlogin', '60', '囧囧讨厌', 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', 'F', 'B', '2015-05-15', '启众网', null, '220721199102171823', '165', '45', '18844882669', '404945547@qq.com', '138000', '松原金钻', null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('2', '', '0', '囧囧', 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', 'T', null, null, null, null, null, null, null, '18844882668', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('3', '', '0', null, 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', 'F', null, null, null, null, null, null, null, '18844882667', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('4', '', '0', null, 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18844882667', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('5', '', '0', null, 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', '', null, null, null, null, null, null, null, '18844882664', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('6', '', '0', null, 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', '', null, null, null, null, null, null, null, '18844882663', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('7', '', '0', null, 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', '', null, null, null, null, null, null, null, '18844882662', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('8', '', '0', null, 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18844882666', null, null, null, null, null, null, '2015-04-30 20:04:14');
INSERT INTO `db_user` VALUES ('9', '', '0', null, 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18844882699', null, null, null, null, null, null, '2015-05-01 14:13:34');
INSERT INTO `db_user` VALUES ('10', '', '0', null, 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18844882869', null, null, null, null, null, null, '2015-05-01 14:16:01');
INSERT INTO `db_user` VALUES ('11', '', '0', null, 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18844282669', null, null, null, null, null, null, '2015-05-01 14:20:10');
INSERT INTO `db_user` VALUES ('12', '', '0', null, 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18843882669', null, null, null, null, null, null, '2015-05-01 14:20:43');
INSERT INTO `db_user` VALUES ('13', '', '0', null, 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18841882669', null, null, null, null, null, null, '2015-05-01 14:23:06');

-- ----------------------------
-- Table structure for `db_venue`
-- ----------------------------
DROP TABLE IF EXISTS `db_venue`;
CREATE TABLE `db_venue` (
  `id` int(11) NOT NULL auto_increment COMMENT '场馆ID',
  `name` varchar(64) NOT NULL COMMENT '场馆名称',
  `image` int(11) NOT NULL COMMENT '图片',
  `sport_id` int(11) NOT NULL COMMENT '运动项目',
  `province` varchar(32) NOT NULL COMMENT '省',
  `city` varchar(32) NOT NULL COMMENT '市',
  `region` varchar(32) NOT NULL COMMENT '区',
  `businss` int(11) default NULL,
  `address` varchar(128) NOT NULL COMMENT '地点',
  `phone` varchar(32) default NULL COMMENT '电话',
  `person_cost` int(11) NOT NULL COMMENT '人均',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  PRIMARY KEY  (`id`),
  KEY `FK_venue_sport_id` (`sport_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='场馆';

-- ----------------------------
-- Records of db_venue
-- ----------------------------
INSERT INTO `db_venue` VALUES ('1', '松原石油大厦游泳馆', '16', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('2', '松原石油大厦游泳馆', '13', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('3', '松原金钻羽毛球馆', '0', '26', '1', '2', '4', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('4', '查干湖小区乒乓球馆', '0', '26', '1', '2', '4', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('5', '铂金路游泳馆', '0', '26', '1', '2', '5', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('6', '松原石油大厦游泳馆', '0', '26', '1', '2', '5', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('7', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('8', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('9', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('10', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('11', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('12', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('13', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('14', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('15', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('16', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('17', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('18', '松原石油大厦游泳馆', '0', '26', '1', '2', '3', null, '553号', '186867916479', '50', '2015-04-07 13:05:45', '1');
INSERT INTO `db_venue` VALUES ('19', '乒乓球活场馆', '0', '24', '1', '2', '7', null, '111', '18844882669', '23', '0000-00-00 00:00:00', '0');

-- ----------------------------
-- Table structure for `dz_sport`
-- ----------------------------
DROP TABLE IF EXISTS `dz_sport`;
CREATE TABLE `dz_sport` (
  `id` int(11) NOT NULL COMMENT '项目ID',
  `name` varchar(64) NOT NULL COMMENT '项目名称',
  `image` int(11) default NULL,
  `sport_type` int(1) NOT NULL COMMENT '项目类型（0 赛事/活动/场馆，1 赛事，2 活动，3 场馆）',
  `level` int(1) default NULL COMMENT '级别',
  `pid` int(11) NOT NULL COMMENT '父项目ID',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  `sport_show` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赛事活动项目';

-- ----------------------------
-- Records of dz_sport
-- ----------------------------
INSERT INTO `dz_sport` VALUES ('1', '球类项目', null, '1', '1', '0', '2015-04-22 20:56:58', '1', null);
INSERT INTO `dz_sport` VALUES ('2', '户外运动', null, '1', '1', '0', '2015-03-26 22:02:09', '1', null);
INSERT INTO `dz_sport` VALUES ('3', '全民健身', null, '1', '1', '0', '2015-03-26 22:02:09', '1', null);
INSERT INTO `dz_sport` VALUES ('4', '马拉松路跑', null, '1', '1', '0', '2015-03-26 22:02:09', '1', null);
INSERT INTO `dz_sport` VALUES ('5', '综合其他', null, '1', '1', '0', '2015-03-26 22:02:09', '1', null);
INSERT INTO `dz_sport` VALUES ('7', '瑜伽', null, '1', '2', '3', '2015-03-26 22:02:09', '1', '1');
INSERT INTO `dz_sport` VALUES ('21', '徒步', '0', '1', '2', '1', '2015-05-01 11:34:47', '1', '1');
INSERT INTO `dz_sport` VALUES ('12', '门球', '0', '1', '2', '1', '2015-05-01 11:34:47', '1', '1');
INSERT INTO `dz_sport` VALUES ('10', '自行车', null, '1', '2', '2', '2015-03-26 22:02:09', '1', null);
INSERT INTO `dz_sport` VALUES ('11', '轮滑', null, '1', '2', '3', '2015-03-26 22:02:09', '1', '1');
INSERT INTO `dz_sport` VALUES ('9', '网球', '0', '1', '2', '1', '2015-05-01 11:34:47', '1', '1');
INSERT INTO `dz_sport` VALUES ('13', '健美', null, '1', '2', '3', '2015-03-26 22:02:09', '1', '1');
INSERT INTO `dz_sport` VALUES ('14', '游泳', null, '1', '2', '4', '2015-03-26 22:02:09', '1', null);
INSERT INTO `dz_sport` VALUES ('15', '射击', null, '1', '2', '5', '2015-03-26 22:02:09', '1', '1');
INSERT INTO `dz_sport` VALUES ('16', '马拉松', null, '1', '2', '5', '2015-03-26 22:02:09', '1', '1');
INSERT INTO `dz_sport` VALUES ('17', '路跑', null, '1', '2', '5', '2015-03-26 22:02:09', '1', '1');
INSERT INTO `dz_sport` VALUES ('18', '钓鱼', null, '1', '2', '4', '2015-03-26 22:02:09', '1', null);
INSERT INTO `dz_sport` VALUES ('19', '角斗士', null, '1', '2', '4', '2015-03-26 22:02:09', '1', '1');
INSERT INTO `dz_sport` VALUES ('20', '滑雪', null, '1', '2', '4', '2015-03-26 22:02:09', '1', '1');
INSERT INTO `dz_sport` VALUES ('8', '台球', '0', '1', '2', '1', '2015-05-01 11:34:47', '1', '1');
INSERT INTO `dz_sport` VALUES ('26', '游泳', null, '3', '1', '0', '2015-04-22 21:35:26', '1', null);
INSERT INTO `dz_sport` VALUES ('25', '瑜伽', null, '3', '1', '0', '2015-04-22 21:35:26', '1', null);
INSERT INTO `dz_sport` VALUES ('24', '乒乓球', null, '3', '1', '0', '2015-04-22 21:35:26', '1', null);
INSERT INTO `dz_sport` VALUES ('23', '台球', null, '3', '1', '0', '2015-04-22 21:35:26', '1', null);
INSERT INTO `dz_sport` VALUES ('22', '羽毛球', null, '3', '1', '0', '2015-04-22 21:35:26', '1', null);
INSERT INTO `dz_sport` VALUES ('28', '羽毛球', null, '2', '1', '0', '2015-04-22 21:35:31', '1', null);
INSERT INTO `dz_sport` VALUES ('30', '竞走', '0', '1', '2', '1', '2015-05-01 11:34:47', '1', '1');
INSERT INTO `dz_sport` VALUES ('29', '马拉松', null, '2', '1', '0', '2015-04-22 21:35:31', '1', null);
INSERT INTO `dz_sport` VALUES ('27', '网球', null, '3', '1', '0', '2015-04-22 21:35:26', '1', null);
INSERT INTO `dz_sport` VALUES ('33', '网球', null, '3', '1', '0', '2015-04-22 21:35:26', '1', null);
INSERT INTO `dz_sport` VALUES ('34', '跑步', '54', '1', '2', '1', '2015-05-01 11:34:47', '1', '1');

-- ----------------------------
-- Table structure for `mt_field_define`
-- ----------------------------
DROP TABLE IF EXISTS `mt_field_define`;
CREATE TABLE `mt_field_define` (
  `id` int(11) NOT NULL auto_increment COMMENT '字段ID',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `code` varchar(64) NOT NULL COMMENT '英文名',
  `filed_type` int(1) NOT NULL COMMENT '字段类型（1 text，2 textarea，3 dropdown，4 email，5 mobile）',
  `regex` varchar(64) default NULL COMMENT '正则式',
  `tip` varchar(64) default NULL COMMENT '提示信息',
  `required` char(1) NOT NULL COMMENT '是否必须',
  `memo` varchar(128) default NULL COMMENT '备注',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段定义';

-- ----------------------------
-- Records of mt_field_define
-- ----------------------------

-- ----------------------------
-- Table structure for `mt_field_option`
-- ----------------------------
DROP TABLE IF EXISTS `mt_field_option`;
CREATE TABLE `mt_field_option` (
  `field_id` int(11) default NULL COMMENT '字段ID',
  `name` varchar(64) NOT NULL COMMENT '名称',
  `value` varchar(64) NOT NULL COMMENT '值',
  `checked` char(1) NOT NULL COMMENT '默认选中',
  KEY `FK_fieldOption_fieldDefine_id` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='字段选项';

-- ----------------------------
-- Records of mt_field_option
-- ----------------------------

-- ----------------------------
-- Table structure for `op_comment`
-- ----------------------------
DROP TABLE IF EXISTS `op_comment`;
CREATE TABLE `op_comment` (
  `id` int(11) NOT NULL auto_increment COMMENT '评论ID',
  `content` varchar(128) NOT NULL COMMENT '评论内容',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `replay_to` int(11) default NULL COMMENT '回复ID',
  `source_id` int(11) NOT NULL COMMENT '来源ID',
  `source_type` int(1) NOT NULL COMMENT '来源类型（1 赛事，2 活动，3 场馆，4 话题）',
  `star_count` int(11) default NULL COMMENT '评分',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  PRIMARY KEY  (`id`),
  KEY `FK_comment_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COMMENT='评论';

-- ----------------------------
-- Records of op_comment
-- ----------------------------
INSERT INTO `op_comment` VALUES ('1', '挺好的', '1', '2', '1', '4', '4', '2015-04-12 15:58:51');
INSERT INTO `op_comment` VALUES ('2', '挺好的', '1', '0', '1', '4', '5', '2015-04-04 15:58:56');
INSERT INTO `op_comment` VALUES ('3', 'ddfdfdfdfd ', '1', '0', '1', '4', '5', '2015-04-02 15:59:00');
INSERT INTO `op_comment` VALUES ('4', 'ddfdfdfdfd ', '1', '0', '1', '4', '5', '2015-04-10 15:59:04');
INSERT INTO `op_comment` VALUES ('5', '你好阿凡达', '1', '0', '1', '4', '5', '2015-04-12 17:26:06');
INSERT INTO `op_comment` VALUES ('6', '真的不错', '1', '0', '1', '1', '5', '2015-04-12 18:48:55');
INSERT INTO `op_comment` VALUES ('7', 'ddfdfdfdfd ', '1', '0', '1', '1', '5', '2015-04-12 18:49:08');
INSERT INTO `op_comment` VALUES ('8', '真的不错', '1', '0', '1', '3', '5', '2015-04-12 18:49:53');
INSERT INTO `op_comment` VALUES ('9', '真的不错', '1', '0', '1', '3', '5', '2015-04-12 18:50:06');
INSERT INTO `op_comment` VALUES ('10', '很好', '1', '0', '1', '3', '5', '2015-04-12 20:38:32');
INSERT INTO `op_comment` VALUES ('11', '哈哈', '1', '0', '1', '3', '5', '2015-04-12 20:38:48');
INSERT INTO `op_comment` VALUES ('12', '水很好', '1', '0', '1', '3', '5', '2015-04-12 20:39:08');
INSERT INTO `op_comment` VALUES ('13', '活动很好', '1', '0', '1', '2', null, '2015-04-15 20:38:08');
INSERT INTO `op_comment` VALUES ('14', '活动很好', '1', '0', '1', '2', null, '2015-04-15 20:40:39');
INSERT INTO `op_comment` VALUES ('15', 'dfdf', '1', '0', '2', '3', '5', '2015-04-30 20:55:09');
INSERT INTO `op_comment` VALUES ('16', 'dfdfdfd ', '1', '0', '2', '3', '5', '2015-04-30 20:55:16');
INSERT INTO `op_comment` VALUES ('17', 'aaaaa', '1', '0', '1', '2', null, '2015-05-03 08:16:27');
INSERT INTO `op_comment` VALUES ('18', 'bbbb', '1', '0', '1', '2', null, '2015-05-03 08:16:43');
INSERT INTO `op_comment` VALUES ('19', '你好', '1', '0', '1', '2', null, '2015-05-03 08:16:58');
INSERT INTO `op_comment` VALUES ('20', '哈哈', '1', '0', '1', '2', null, '2015-05-03 08:17:43');
INSERT INTO `op_comment` VALUES ('21', '对对对', '1', '0', '1', '2', null, '2015-05-03 08:18:50');
INSERT INTO `op_comment` VALUES ('22', '对对对', '1', '0', '1', '2', null, '2015-05-03 08:20:05');
INSERT INTO `op_comment` VALUES ('23', '对对对顶顶顶顶', '1', '0', '1', '2', null, '2015-05-03 08:20:14');
INSERT INTO `op_comment` VALUES ('24', '对对对顶顶顶顶2222222', '1', '0', '1', '2', null, '2015-05-03 08:20:18');
INSERT INTO `op_comment` VALUES ('25', '55555', '1', '0', '1', '2', null, '2015-05-03 08:20:27');
INSERT INTO `op_comment` VALUES ('26', '333333', '1', '0', '1', '2', null, '2015-05-03 08:20:47');
INSERT INTO `op_comment` VALUES ('27', '6666', '1', '0', '1', '2', null, '2015-05-03 08:24:02');
INSERT INTO `op_comment` VALUES ('28', '6666222', '1', '0', '1', '2', null, '2015-05-03 08:24:05');
INSERT INTO `op_comment` VALUES ('29', '5555', '1', '0', '1', '2', null, '2015-05-03 08:45:25');
INSERT INTO `op_comment` VALUES ('30', '5555对对对', '1', '0', '1', '2', null, '2015-05-03 08:45:27');
INSERT INTO `op_comment` VALUES ('32', '', '1', null, '1', '2', null, '2015-05-03 10:03:45');
INSERT INTO `op_comment` VALUES ('33', '777777', '1', '28', '1', '2', null, '2015-05-03 10:06:07');
INSERT INTO `op_comment` VALUES ('34', '哈哈哈', '1', '27', '1', '2', null, '2015-05-03 10:11:05');
INSERT INTO `op_comment` VALUES ('35', '奇迹啊', '1', '29', '1', '2', null, '2015-05-03 10:11:33');
INSERT INTO `op_comment` VALUES ('36', '地方大幅度', '1', '20', '1', '1', null, '2015-05-03 12:56:08');
INSERT INTO `op_comment` VALUES ('37', '你好', '1', null, '1', '3', '5', '2015-05-03 16:50:59');
INSERT INTO `op_comment` VALUES ('38', '你好', '1', null, '1', '3', '5', '2015-05-03 16:52:27');
INSERT INTO `op_comment` VALUES ('39', '我不好', '1', null, '1', '3', '5', '2015-05-03 16:53:55');
INSERT INTO `op_comment` VALUES ('40', '那你怎么了', '1', '39', '1', '3', null, '2015-05-03 17:03:10');
INSERT INTO `op_comment` VALUES ('41', '我挺好的', '1', '40', '1', '3', null, '2015-05-03 17:05:26');
INSERT INTO `op_comment` VALUES ('42', '哎呀', '1', null, '1', '3', '5', '2015-05-03 17:05:46');
INSERT INTO `op_comment` VALUES ('43', '四季跑 话题 回复', '1', '20', '1', '1', null, '2015-05-03 19:06:42');
INSERT INTO `op_comment` VALUES ('44', '四季跑 话题 回复', '1', '20', '1', '1', null, '2015-05-03 19:06:47');
INSERT INTO `op_comment` VALUES ('45', '四季跑 话题 回复', '1', '20', '1', '1', null, '2015-05-03 19:06:57');
INSERT INTO `op_comment` VALUES ('46', '四季跑 话题 回复', '1', '20', '1', '1', null, '2015-05-03 19:08:08');
INSERT INTO `op_comment` VALUES ('47', '四季跑 话题 回复', '1', '20', '1', '1', null, '2015-05-03 19:08:11');
INSERT INTO `op_comment` VALUES ('48', '你好', '1', '20', '1', '1', null, '2015-05-03 19:24:01');
INSERT INTO `op_comment` VALUES ('49', '你好', '1', '20', '1', '1', null, '2015-05-03 19:24:20');
INSERT INTO `op_comment` VALUES ('50', '我不好', '1', '48', '1', '1', null, '2015-05-03 19:44:21');
INSERT INTO `op_comment` VALUES ('51', '我不啊好', '1', '49', '1', '2', null, '2015-05-03 19:44:29');
INSERT INTO `op_comment` VALUES ('52', '不好', '1', '46', '1', '2', null, '2015-05-03 19:44:39');
INSERT INTO `op_comment` VALUES ('53', '我不好', '1', '43', '1', '1', null, '2015-05-03 19:44:50');
INSERT INTO `op_comment` VALUES ('54', '超级哦不好', '1', '49', '1', '1', null, '2015-05-03 19:45:18');
INSERT INTO `op_comment` VALUES ('55', '哎愁死', '1', '54', '1', '1', null, '2015-05-03 19:48:59');
INSERT INTO `op_comment` VALUES ('56', '奶奶的', '1', '55', '1', '1', null, '2015-05-03 19:49:44');
INSERT INTO `op_comment` VALUES ('57', '平轮2', '1', null, '2', '3', '5', '2015-05-03 20:01:41');

-- ----------------------------
-- Table structure for `op_focus`
-- ----------------------------
DROP TABLE IF EXISTS `op_focus`;
CREATE TABLE `op_focus` (
  `id` int(11) NOT NULL auto_increment COMMENT '评论ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `source_id` int(11) NOT NULL COMMENT '来源ID',
  `source_type` int(1) NOT NULL COMMENT '来源类型（1 赛事，2 活动，3 场馆， 4 话题）',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  PRIMARY KEY  (`id`),
  KEY `FK_focus_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='关注';

-- ----------------------------
-- Records of op_focus
-- ----------------------------
INSERT INTO `op_focus` VALUES ('24', '1', '1', '1', '2015-05-03 12:25:41');
INSERT INTO `op_focus` VALUES ('22', '2', '1', '1', '2015-05-02 20:07:21');
INSERT INTO `op_focus` VALUES ('23', '3', '1', '1', '2015-05-02 20:07:28');
INSERT INTO `op_focus` VALUES ('36', '1', '3', '3', '2015-05-03 20:54:40');

-- ----------------------------
-- Table structure for `op_game_field`
-- ----------------------------
DROP TABLE IF EXISTS `op_game_field`;
CREATE TABLE `op_game_field` (
  `game_id` int(11) NOT NULL COMMENT '赛事ID',
  `field_id` int(11) NOT NULL COMMENT '字段ID',
  `sort_num` int(11) default NULL COMMENT '排序号',
  PRIMARY KEY  (`game_id`,`field_id`),
  KEY `FK_gameField_fieldDefine_id` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赛事字段';

-- ----------------------------
-- Records of op_game_field
-- ----------------------------

-- ----------------------------
-- Table structure for `op_game_group`
-- ----------------------------
DROP TABLE IF EXISTS `op_game_group`;
CREATE TABLE `op_game_group` (
  `id` int(11) NOT NULL auto_increment,
  `game_id` int(11) default NULL,
  `group_name` varchar(256) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of op_game_group
-- ----------------------------
INSERT INTO `op_game_group` VALUES ('1', '1', '女子半程跑');
INSERT INTO `op_game_group` VALUES ('2', '1', '男子半程跑');
INSERT INTO `op_game_group` VALUES ('3', '1', '女子全程跑');
INSERT INTO `op_game_group` VALUES ('4', '1', '男子全程跑');

-- ----------------------------
-- Table structure for `op_game_news`
-- ----------------------------
DROP TABLE IF EXISTS `op_game_news`;
CREATE TABLE `op_game_news` (
  `id` int(11) NOT NULL auto_increment COMMENT '新闻ID',
  `game_id` int(11) default NULL COMMENT '赛事ID',
  `content` varchar(1024) NOT NULL COMMENT '新闻内容',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  `title` varchar(256) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_gameNews_game_id` (`game_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='赛事新闻';

-- ----------------------------
-- Records of op_game_news
-- ----------------------------
INSERT INTO `op_game_news` VALUES ('1', '1', '赛事', '2015-04-24 20:13:14', '1', null);
INSERT INTO `op_game_news` VALUES ('2', '67', '<p>赛事</p>', '2015-04-24 20:21:58', '1', '网球');
INSERT INTO `op_game_news` VALUES ('3', '68', '<p>赛事</p>', '2015-04-24 20:15:09', '1', '台球赛事');
INSERT INTO `op_game_news` VALUES ('4', '64', '<p>最新赛会</p>', '2015-04-24 20:21:28', '1', '最新赛事');

-- ----------------------------
-- Table structure for `op_game_notice`
-- ----------------------------
DROP TABLE IF EXISTS `op_game_notice`;
CREATE TABLE `op_game_notice` (
  `id` int(11) NOT NULL auto_increment COMMENT '公告ID',
  `game_id` int(11) default NULL COMMENT '赛事ID',
  `content` varchar(1024) NOT NULL COMMENT '公告内容',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  `title` varchar(256) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_gameNotice_game_id` (`game_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='赛事公告';

-- ----------------------------
-- Records of op_game_notice
-- ----------------------------
INSERT INTO `op_game_notice` VALUES ('1', '68', '<p>请大家在准时的时间参加</p>', '2015-04-24 20:28:47', '1', '台球比赛公告');

-- ----------------------------
-- Table structure for `op_game_score`
-- ----------------------------
DROP TABLE IF EXISTS `op_game_score`;
CREATE TABLE `op_game_score` (
  `game_id` int(11) default NULL COMMENT '赛事活动ID',
  `user_id` int(11) default NULL COMMENT '用户ID',
  `game_number` int(11) default NULL COMMENT '参赛号码',
  `score` decimal(10,0) default NULL COMMENT '分数',
  `group_id` int(11) default NULL,
  KEY `FK_gameScore_game_id` (`game_id`),
  KEY `FK_gameScore_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='比赛成绩';

-- ----------------------------
-- Records of op_game_score
-- ----------------------------
INSERT INTO `op_game_score` VALUES ('1', '1', '1', '98', '1');
INSERT INTO `op_game_score` VALUES ('1', '2', '2', '96', '1');

-- ----------------------------
-- Table structure for `op_game_topic`
-- ----------------------------
DROP TABLE IF EXISTS `op_game_topic`;
CREATE TABLE `op_game_topic` (
  `id` int(11) NOT NULL auto_increment COMMENT '话题ID',
  `game_id` int(11) default NULL COMMENT '赛事ID',
  `user_id` int(11) default NULL COMMENT '用户ID',
  `content` varchar(512) NOT NULL COMMENT '话题内容',
  `laud_count` int(11) default NULL COMMENT '点赞数',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  PRIMARY KEY  (`id`),
  KEY `FK_gameTopic_game_id` (`game_id`),
  KEY `FK_gameTopic_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='赛事话题';

-- ----------------------------
-- Records of op_game_topic
-- ----------------------------
INSERT INTO `op_game_topic` VALUES ('1', '1', '1', '马拉松马拉松马拉松马拉松马拉松马拉松', '3', '2015-04-18 23:02:15');
INSERT INTO `op_game_topic` VALUES ('2', '1', '1', '马拉松马拉松马拉松马拉松马拉松马拉松', '4', '2015-04-18 23:02:45');
INSERT INTO `op_game_topic` VALUES ('3', '1', '1', '马拉松马拉松马拉松马拉松马拉松马拉松', '3', '2015-04-18 23:03:00');
INSERT INTO `op_game_topic` VALUES ('4', '2', '1', '马拉松马拉松马拉松马拉松马拉松马拉松', '4', '0000-00-00 00:00:00');
INSERT INTO `op_game_topic` VALUES ('5', '2', '1', '马拉松马拉松马拉松马拉松马拉松马拉松', '6', '2015-04-18 23:03:31');
INSERT INTO `op_game_topic` VALUES ('6', '2', '1', '马拉松马拉松马拉松马拉松马拉松马拉松', '7', '2015-04-19 14:46:04');
INSERT INTO `op_game_topic` VALUES ('7', '1', '1', '马拉松马拉松马拉松马拉松马拉松马拉松', '8', '2015-04-19 14:46:19');
INSERT INTO `op_game_topic` VALUES ('8', '1', '1', '马拉松马拉松马拉松马拉松马拉松马拉松', '7', '2015-04-19 14:46:35');
INSERT INTO `op_game_topic` VALUES ('9', '1', '1', '马拉松马拉松马拉松马拉', '4', '2015-04-19 14:46:56');
INSERT INTO `op_game_topic` VALUES ('10', '1', '1', '马拉松马拉松马拉松马拉', '6', '2015-04-19 14:47:13');
INSERT INTO `op_game_topic` VALUES ('11', '1', '1', '马拉松马拉松马拉松马拉', '1', '2015-04-19 14:47:25');
INSERT INTO `op_game_topic` VALUES ('12', '1', '1', '马拉松马拉松马拉松马拉', '4', '2015-04-19 14:47:35');
INSERT INTO `op_game_topic` VALUES ('13', '1', '1', '对反对反对法', null, '2015-05-03 10:26:16');
INSERT INTO `op_game_topic` VALUES ('14', '1', '1', '地方对反对反对法多发点地方大幅度', null, '2015-05-03 11:26:36');
INSERT INTO `op_game_topic` VALUES ('15', '1', '1', 'dfddfdfdfdfdfdfdfdf', null, '2015-05-03 11:27:55');
INSERT INTO `op_game_topic` VALUES ('16', '1', '1', 'dfddfdfdfdfdfdfdfdf', null, '2015-05-03 11:30:48');
INSERT INTO `op_game_topic` VALUES ('17', '1', '1', 'dfddfdfdfdfdfdfdfdf', null, '2015-05-03 11:35:15');
INSERT INTO `op_game_topic` VALUES ('18', '1', '1', '的地方地方对反对反对法多发点分', null, '2015-05-03 11:37:39');
INSERT INTO `op_game_topic` VALUES ('19', '1', '1', '对对反对反对法', null, '2015-05-03 11:40:31');
INSERT INTO `op_game_topic` VALUES ('20', '1', '1', '对对对多发点地方', null, '2015-05-03 11:41:11');

-- ----------------------------
-- Table structure for `op_game_topic_images`
-- ----------------------------
DROP TABLE IF EXISTS `op_game_topic_images`;
CREATE TABLE `op_game_topic_images` (
  `topic_id` int(11) default NULL COMMENT '话题ID',
  `image_id` int(11) NOT NULL COMMENT '图片ID',
  KEY `FK_Reference_23` (`topic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='话题图片';

-- ----------------------------
-- Records of op_game_topic_images
-- ----------------------------
INSERT INTO `op_game_topic_images` VALUES ('1', '13');
INSERT INTO `op_game_topic_images` VALUES ('20', '143');
INSERT INTO `op_game_topic_images` VALUES ('20', '144');
INSERT INTO `op_game_topic_images` VALUES ('20', '145');
INSERT INTO `op_game_topic_images` VALUES ('20', '146');
INSERT INTO `op_game_topic_images` VALUES ('18', '147');

-- ----------------------------
-- Table structure for `op_join_activity`
-- ----------------------------
DROP TABLE IF EXISTS `op_join_activity`;
CREATE TABLE `op_join_activity` (
  `id` int(11) NOT NULL auto_increment COMMENT '报名iD',
  `activity_id` int(11) NOT NULL COMMENT '活动ID',
  `user_id` int(11) default NULL COMMENT '用户ID',
  `true_name` varchar(32) default NULL COMMENT '真实姓名',
  `gender` char(1) default NULL COMMENT '性别（F 女，M 男）',
  `mobile` varchar(16) default NULL COMMENT '手机',
  `certificate_num` varchar(64) default NULL COMMENT '身份证号',
  `verify_state` int(1) NOT NULL COMMENT '审核状态（0 待审核，1 通过，2 不通过）',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `verify_date` datetime default NULL COMMENT '审核时间',
  PRIMARY KEY  (`id`),
  KEY `FK_joinActivity_activity_id` (`activity_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='参加活动';

-- ----------------------------
-- Records of op_join_activity
-- ----------------------------
INSERT INTO `op_join_activity` VALUES ('1', '1', '1', '刘立婷', 'T', '18844882669', '220721199102171823', '1', '2015-04-27 19:54:10', '2015-04-26 19:54:15');
INSERT INTO `op_join_activity` VALUES ('2', '2', '1', '刘立婷', 'T', '18844882669', '220721199102171823', '1', '2015-04-27 19:54:10', '2015-04-26 19:54:15');
INSERT INTO `op_join_activity` VALUES ('3', '1', '1', '刘立婷', 'T', '18844882669', '220721199102171823', '0', '2015-04-27 19:54:10', '2015-04-26 19:54:15');
INSERT INTO `op_join_activity` VALUES ('4', '3', '1', '刘立婷', 'T', '18844882669', '220721199102171823', '2', '2015-04-27 19:54:10', '2015-04-26 19:54:15');
INSERT INTO `op_join_activity` VALUES ('5', '4', '1', '刘立婷', 'T', '18844882669', '220721199102171823', '1', '2015-04-27 19:54:10', '2015-04-26 19:54:15');
INSERT INTO `op_join_activity` VALUES ('6', '5', '1', '刘立婷', 'T', '18844882669', '220721199102171823', '1', '2015-04-27 19:54:10', '2015-04-28 21:42:09');

-- ----------------------------
-- Table structure for `op_join_game`
-- ----------------------------
DROP TABLE IF EXISTS `op_join_game`;
CREATE TABLE `op_join_game` (
  `id` int(11) NOT NULL auto_increment COMMENT '报名ID',
  `game_id` int(11) default NULL COMMENT '赛事ID',
  `group_id` int(11) default NULL,
  `user_id` int(11) default NULL COMMENT '用户ID',
  `verify_state` int(1) NOT NULL COMMENT '审核状态（0 待审核，1 通过，2 不通过）',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `verify_date` datetime default NULL COMMENT '审核时间',
  `true_name` varchar(32) default NULL,
  `gender` int(11) default NULL,
  `mobile` varchar(16) default NULL,
  `certificate_num` varchar(32) default NULL,
  `em_contact` varchar(32) default NULL,
  `em_tel` varchar(16) default NULL,
  PRIMARY KEY  (`id`),
  KEY `FK_joinGame_game_Id` (`game_id`),
  KEY `FK_joinGame_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='参加比赛';

-- ----------------------------
-- Records of op_join_game
-- ----------------------------
INSERT INTO `op_join_game` VALUES ('6', '1', '2', '1', '0', '2015-05-02 19:24:51', null, '刘立婷', '0', '18844883345', '22', '刘立', '18844882669');
INSERT INTO `op_join_game` VALUES ('3', '1', '3', '1', '0', '2015-05-02 17:49:34', null, '刘立', '0', '18844882669', '77', '刘冰', '111');
INSERT INTO `op_join_game` VALUES ('5', '67', '1', '2', '0', '2015-05-02 19:22:05', null, '刘立', null, '18844882669', '66', '刘吧', '22');

-- ----------------------------
-- Table structure for `op_join_game_field`
-- ----------------------------
DROP TABLE IF EXISTS `op_join_game_field`;
CREATE TABLE `op_join_game_field` (
  `join_Id` int(11) default NULL COMMENT '报名ID',
  `field_id` int(11) NOT NULL COMMENT '字段ID',
  `field_value` varchar(1024) default NULL COMMENT '字段值',
  KEY `FK_joinGameField_fieldDefine_id` (`field_id`),
  KEY `FK_joinGameField_joinGame_id` (`join_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of op_join_game_field
-- ----------------------------

-- ----------------------------
-- Table structure for `op_message`
-- ----------------------------
DROP TABLE IF EXISTS `op_message`;
CREATE TABLE `op_message` (
  `id` int(11) NOT NULL auto_increment COMMENT '消息ID',
  `user_id` int(11) default NULL COMMENT '用户ID',
  `title` varchar(64) NOT NULL COMMENT '标题',
  `content` varchar(1024) default NULL COMMENT '内容',
  `source_id` int(11) NOT NULL COMMENT '来源ID',
  `source_type` int(1) NOT NULL COMMENT '来源类型（1 赛事，2 活动，3 场馆，4 话题）',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  PRIMARY KEY  (`id`),
  KEY `FK_message_user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='消息';

-- ----------------------------
-- Records of op_message
-- ----------------------------

-- ----------------------------
-- Table structure for `op_recommend`
-- ----------------------------
DROP TABLE IF EXISTS `op_recommend`;
CREATE TABLE `op_recommend` (
  `id` int(11) NOT NULL auto_increment COMMENT 'ID',
  `gc_id` int(11) NOT NULL COMMENT '赛事/活动id',
  `recommend_type` varchar(16) NOT NULL COMMENT '推荐类型(game 赛事，activity 活动)',
  `sort_num` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of op_recommend
-- ----------------------------
INSERT INTO `op_recommend` VALUES ('1', '1', 'game', '1');
INSERT INTO `op_recommend` VALUES ('2', '2', 'game', '2');
INSERT INTO `op_recommend` VALUES ('5', '1', 'activity', '1');
INSERT INTO `op_recommend` VALUES ('6', '2', 'activity', '2');
INSERT INTO `op_recommend` VALUES ('7', '3', 'activity', '3');
INSERT INTO `op_recommend` VALUES ('8', '4', 'activity', '4');
INSERT INTO `op_recommend` VALUES ('10', '1', 'venue', '1');
INSERT INTO `op_recommend` VALUES ('11', '2', 'venue', '2');
INSERT INTO `op_recommend` VALUES ('12', '3', 'venue', '3');
INSERT INTO `op_recommend` VALUES ('13', '4', 'venue', '4');
INSERT INTO `op_recommend` VALUES ('14', '5', 'venue', '5');

-- ----------------------------
-- Table structure for `op_user_friend`
-- ----------------------------
DROP TABLE IF EXISTS `op_user_friend`;
CREATE TABLE `op_user_friend` (
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `friend_id` int(11) NOT NULL COMMENT '赛友ID',
  PRIMARY KEY  (`user_id`,`friend_id`),
  KEY `FK_userFriend_user_friendId` (`friend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赛友';

-- ----------------------------
-- Records of op_user_friend
-- ----------------------------
INSERT INTO `op_user_friend` VALUES ('1', '2');

-- ----------------------------
-- View structure for `v_activity_join_count`
-- ----------------------------
DROP VIEW IF EXISTS `v_activity_join_count`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_activity_join_count` AS select `op_join_activity`.`activity_id` AS `activity_id`,count(1) AS `join_count` from `op_join_activity` group by `op_join_activity`.`activity_id` ;

-- ----------------------------
-- View structure for `v_banner_images`
-- ----------------------------
DROP VIEW IF EXISTS `v_banner_images`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_banner_images` AS select `v_recommend_game`.`id` AS `id`,`db_images`.`local_url` AS `url`,`db_images`.`banner_desc` AS `banner_desc` from (`v_recommend_game` join `db_images`) where ((`v_recommend_game`.`image` = `db_images`.`id`) and (`v_recommend_game`.`status` = 1)) order by `v_recommend_game`.`focus_count` desc,`v_recommend_game`.`join_count` desc limit 0,6 ;

-- ----------------------------
-- View structure for `v_choice_game`
-- ----------------------------
DROP VIEW IF EXISTS `v_choice_game`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_choice_game` AS select `v_game_activity`.`id` AS `id`,`v_game_activity`.`name` AS `name`,`v_game_activity`.`sport_id` AS `sport_id`,`v_game_activity`.`image` AS `image`,`v_game_activity`.`reg_begin_date` AS `reg_begin_date`,`v_game_activity`.`reg_end_date` AS `reg_end_date`,`v_game_activity`.`start_date` AS `start_date`,`v_game_activity`.`end_date` AS `end_date`,`v_game_activity`.`limit_count` AS `limit_count`,`v_game_activity`.`cost` AS `cost`,`v_game_activity`.`province` AS `province`,`v_game_activity`.`city` AS `city`,`v_game_activity`.`region` AS `region`,`v_game_activity`.`address` AS `address`,`v_game_activity`.`input_date` AS `input_date`,`v_game_activity`.`type` AS `type`,`v_game_activity`.`join_count` AS `join_count`,`v_game_activity`.`focus_count` AS `focus_count`,`v_game_activity`.`topic_count` AS `topic_count`,`v_game_activity`.`status` AS `status` from `v_game_activity` where (((`v_game_activity`.`status` = 1) or (`v_game_activity`.`status` = 2) or (`v_game_activity`.`status` = 3)) and (`v_game_activity`.`type` = _utf8'game')) order by `v_game_activity`.`focus_count` desc,`v_game_activity`.`join_count` ;

-- ----------------------------
-- View structure for `v_comment`
-- ----------------------------
DROP VIEW IF EXISTS `v_comment`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_comment` AS select `op_comment`.`id` AS `id`,`op_comment`.`content` AS `content`,`op_comment`.`user_id` AS `user_id`,`op_comment`.`star_count` AS `star_count`,`op_comment`.`input_date` AS `input_date`,`op_comment`.`source_id` AS `source_id`,`op_comment`.`source_type` AS `source_type`,`db_user`.`nick_name` AS `nick_name`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `db_user`.`user_head`)) AS `image`,(select `db_user`.`nick_name` AS `nick_name` from `db_user` where (`db_user`.`id` = (select `oc`.`user_id` AS `user_id` from `op_comment` `oc` where (`oc`.`id` = `syyundong`.`op_comment`.`reply_to`)))) AS `replyUserName` from (`op_comment` join `db_user` on((`syyundong`.`op_comment`.`user_id` = `syyundong`.`db_user`.`id`))) ;

-- ----------------------------
-- View structure for `v_doyen_hall`
-- ----------------------------
DROP VIEW IF EXISTS `v_doyen_hall`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_doyen_hall` AS select `db_doyen_hall`.`id` AS `id`,`db_doyen_hall`.`name` AS `name`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `db_doyen_hall`.`image`)) AS `image`,`db_doyen_hall`.`description` AS `description`,`db_doyen_hall`.`input_date` AS `input_date`,`db_doyen_hall`.`input_user` AS `input_user` from `db_doyen_hall` ;

-- ----------------------------
-- View structure for `v_doyen_user`
-- ----------------------------
DROP VIEW IF EXISTS `v_doyen_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_doyen_user` AS select `db_user`.`id` AS `id`,`db_user`.`name` AS `name` from (`db_user` join `v_user_topic_count`) where (`db_user`.`id` = `v_user_topic_count`.`user_id`) order by `v_user_topic_count`.`topic_count` desc limit 0,8 ;

-- ----------------------------
-- View structure for `v_focus_game`
-- ----------------------------
DROP VIEW IF EXISTS `v_focus_game`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_focus_game` AS select `op_focus`.`user_id` AS `user_id`,`op_focus`.`input_date` AS `input_date`,`v_game_activity`.`name` AS `game_name`,`v_game_activity`.`sport_id` AS `sport_id`,`v_game_activity`.`image` AS `image`,`v_game_activity`.`start_date` AS `start_date`,`v_game_activity`.`address` AS `address`,`v_game_activity`.`end_date` AS `end_date`,`v_game_activity`.`limit_count` AS `limit_count`,`v_game_activity`.`sponsor` AS `sponsor`,`v_game_activity`.`type` AS `type`,`v_game_activity`.`join_count` AS `join_count`,`v_game_activity`.`focus_count` AS `focus_count`,`v_game_activity`.`topic_count` AS `topic_count`,`v_game_activity`.`status` AS `status`,`v_game_activity`.`sport_name` AS `sport_name` from (`op_focus` join `v_game_activity`) where ((`op_focus`.`source_id` = `v_game_activity`.`id`) and (`op_focus`.`source_type` = 1) and (`v_game_activity`.`type` = _utf8'game')) ;

-- ----------------------------
-- View structure for `v_game_activity`
-- ----------------------------
DROP VIEW IF EXISTS `v_game_activity`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_game_activity` AS select `db_game`.`id` AS `id`,`db_game`.`name` AS `name`,`db_game`.`sport_id` AS `sport_id`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `db_game`.`image`)) AS `image`,`db_game`.`reg_begin_date` AS `reg_begin_date`,`db_game`.`reg_end_date` AS `reg_end_date`,`db_game`.`start_date` AS `start_date`,`db_game`.`end_date` AS `end_date`,`db_game`.`limit_count` AS `limit_count`,`db_game`.`game_declare` AS `game_declare`,`db_game`.`description` AS `description`,`db_game`.`cost` AS `cost`,`db_game`.`province` AS `province`,`db_game`.`city` AS `city`,`db_game`.`region` AS `region`,`db_game`.`address` AS `address`,`db_game`.`sponsor` AS `sponsor`,`db_game`.`content` AS `content`,_utf8'' AS `interest_count`,`db_game`.`input_user` AS `input_user`,`db_game`.`input_date` AS `input_date`,_utf8'game' AS `type`,ifnull(`v_game_join_count`.`join_count`,0) AS `join_count`,(`db_game`.`limit_count` - `v_game_join_count`.`join_count`) AS `remaining`,(select `dz_sport`.`name` AS `name` from `dz_sport` where (`dz_sport`.`id` = `db_game`.`sport_id`)) AS `sport_name`,(select count(1) AS `count(1)` from `op_focus` where ((`op_focus`.`source_id` = `db_game`.`id`) and (`op_focus`.`source_type` = 1))) AS `focus_count`,(select count(1) AS `count(1)` from `op_game_topic` where (`op_game_topic`.`game_id` = `db_game`.`id`)) AS `topic_count`,(case when ((now() < `db_game`.`reg_end_date`) and (ifnull(`v_game_join_count`.`join_count`,0) <= `db_game`.`limit_count`)) then 1 when ((now() < `db_game`.`start_date`) or ((now() > `db_game`.`reg_end_date`) and (ifnull(`v_game_join_count`.`join_count`,0) > `db_game`.`limit_count`) and (now() < `db_game`.`start_date`))) then 2 when ((now() >= `db_game`.`start_date`) and (now() < `db_game`.`end_date`)) then 3 else 4 end) AS `status` from (`db_game` left join `v_game_join_count` on((`db_game`.`id` = `v_game_join_count`.`game_id`))) where (`db_game`.`is_verify` = _utf8'T') union all select `db_activity`.`id` AS `id`,`db_activity`.`name` AS `name`,`db_activity`.`sport_id` AS `sport_id`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `db_activity`.`image`)) AS `image`,`db_activity`.`reg_begin_date` AS `reg_begin_date`,`db_activity`.`reg_end_date` AS `reg_end_date`,`db_activity`.`start_date` AS `start_date`,`db_activity`.`end_date` AS `end_date`,`db_activity`.`limit_count` AS `limit_count`,_utf8'' AS `game_declare`,_utf8'' AS `description`,`db_activity`.`cost` AS `cost`,`db_activity`.`province` AS `province`,`db_activity`.`city` AS `city`,`db_activity`.`region` AS `region`,`db_activity`.`address` AS `address`,_utf8'' AS `sponsor`,`db_activity`.`content` AS `content`,`db_activity`.`interest_count` AS `interest_count`,`db_activity`.`input_user` AS `input_user`,`db_activity`.`input_date` AS `input_date`,_utf8'activity' AS `type`,ifnull(`v_activity_join_count`.`join_count`,0) AS `join_count`,(`db_activity`.`limit_count` - `v_activity_join_count`.`join_count`) AS `remaining`,(select `dz_sport`.`name` AS `name` from `dz_sport` where (`dz_sport`.`id` = `db_activity`.`sport_id`)) AS `sport_name`,(select count(1) AS `count(1)` from `op_focus` where ((`op_focus`.`source_id` = `db_activity`.`id`) and (`op_focus`.`source_type` = 2))) AS `focus_count`,(select count(1) AS `count(1)` from `op_comment` where ((`op_comment`.`source_id` = `db_activity`.`id`) and (`op_comment`.`source_type` = 2))) AS `topic_count`,(case when ((now() < `db_activity`.`reg_end_date`) and (ifnull(`v_activity_join_count`.`join_count`,0) <= `db_activity`.`limit_count`)) then 1 when ((now() < `db_activity`.`start_date`) or ((now() > `db_activity`.`reg_end_date`) and (ifnull(`v_activity_join_count`.`join_count`,0) > `db_activity`.`limit_count`) and (now() < `db_activity`.`start_date`))) then 2 when ((now() >= `db_activity`.`start_date`) and (now() < `db_activity`.`end_date`)) then 3 else 4 end) AS `status` from (`db_activity` left join `v_activity_join_count` on((`db_activity`.`id` = `v_activity_join_count`.`activity_id`))) ;

-- ----------------------------
-- View structure for `v_game_join_count`
-- ----------------------------
DROP VIEW IF EXISTS `v_game_join_count`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_game_join_count` AS select `op_join_game`.`game_id` AS `game_id`,count(1) AS `join_count` from `op_join_game` group by `op_join_game`.`game_id` ;

-- ----------------------------
-- View structure for `v_hot_activity`
-- ----------------------------
DROP VIEW IF EXISTS `v_hot_activity`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hot_activity` AS select `v_game_activity`.`id` AS `id`,`v_game_activity`.`name` AS `name`,`v_game_activity`.`sport_id` AS `sport_id`,`v_game_activity`.`image` AS `image`,`v_game_activity`.`reg_begin_date` AS `reg_begin_date`,`v_game_activity`.`reg_end_date` AS `reg_end_date`,`v_game_activity`.`start_date` AS `start_date`,`v_game_activity`.`end_date` AS `end_date`,`v_game_activity`.`limit_count` AS `limit_count`,`v_game_activity`.`cost` AS `cost`,`v_game_activity`.`province` AS `province`,`v_game_activity`.`address` AS `address`,`v_game_activity`.`input_user` AS `input_user`,`v_game_activity`.`input_date` AS `input_date`,`v_game_activity`.`type` AS `type`,`v_game_activity`.`join_count` AS `join_count`,`v_game_activity`.`focus_count` AS `focus_count`,`v_game_activity`.`topic_count` AS `topic_count`,`v_game_activity`.`status` AS `status`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = (select `db_user`.`user_head` AS `user_head` from `db_user` where (`db_user`.`id` = `v_game_activity`.`input_user`)))) AS `user_image` from `v_game_activity` where (((`v_game_activity`.`status` = 1) or (`v_game_activity`.`status` = 2) or (`v_game_activity`.`status` = 3)) and (`v_game_activity`.`type` = _utf8'activity')) order by `v_game_activity`.`join_count` desc,`v_game_activity`.`focus_count` desc limit 0,6 ;

-- ----------------------------
-- View structure for `v_hot_game_ranking`
-- ----------------------------
DROP VIEW IF EXISTS `v_hot_game_ranking`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_hot_game_ranking` AS select `v_game_activity`.`id` AS `id`,`v_game_activity`.`name` AS `name` from `v_game_activity` where (`v_game_activity`.`type` = _utf8'game') order by `v_game_activity`.`focus_count` desc,`v_game_activity`.`join_count` limit 0,10 ;

-- ----------------------------
-- View structure for `v_join_activity`
-- ----------------------------
DROP VIEW IF EXISTS `v_join_activity`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_join_activity` AS select `op_join_activity`.`activity_id` AS `activity_id`,`op_join_activity`.`user_id` AS `user_id`,`op_join_activity`.`true_name` AS `true_name`,`op_join_activity`.`gender` AS `gender`,`op_join_activity`.`mobile` AS `mobile`,`op_join_activity`.`certificate_num` AS `certificate_num`,`op_join_activity`.`verify_state` AS `verify_state`,`op_join_activity`.`input_date` AS `input_date`,`op_join_activity`.`verify_date` AS `verify_date`,`db_user`.`nick_name` AS `nick_name`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `db_user`.`user_head`)) AS `user_head` from (`op_join_activity` join `db_user`) where (`op_join_activity`.`user_id` = `db_user`.`id`) ;

-- ----------------------------
-- View structure for `v_join_game`
-- ----------------------------
DROP VIEW IF EXISTS `v_join_game`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_join_game` AS select `op_join_game`.`id` AS `id`,`op_join_game`.`game_id` AS `game_id`,(select `op_game_group`.`group_name` AS `group_name` from `op_game_group` where (`op_game_group`.`id` = `op_join_game`.`group_id`)) AS `group_name`,`op_join_game`.`user_id` AS `user_id`,`op_join_game`.`verify_state` AS `verify_state`,`op_join_game`.`input_date` AS `input_date`,`v_game_activity`.`name` AS `game_name`,`v_game_activity`.`sport_id` AS `sport_id`,`v_game_activity`.`image` AS `image`,`v_game_activity`.`start_date` AS `start_date`,`v_game_activity`.`end_date` AS `end_date`,`v_game_activity`.`limit_count` AS `limit_count`,`v_game_activity`.`address` AS `address`,`v_game_activity`.`sponsor` AS `sponsor`,`v_game_activity`.`input_user` AS `input_user`,`v_game_activity`.`type` AS `type`,`v_game_activity`.`join_count` AS `join_count`,`v_game_activity`.`focus_count` AS `focus_count`,`v_game_activity`.`topic_count` AS `topic_count`,`v_game_activity`.`status` AS `status` from (`op_join_game` join `v_game_activity`) where ((`op_join_game`.`game_id` = `v_game_activity`.`id`) and (`v_game_activity`.`type` = _utf8'game')) ;

-- ----------------------------
-- View structure for `v_recommend_game`
-- ----------------------------
DROP VIEW IF EXISTS `v_recommend_game`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_recommend_game` AS select `v_game_activity`.`id` AS `id`,`v_game_activity`.`name` AS `name`,`v_game_activity`.`sport_id` AS `sport_id`,`v_game_activity`.`image` AS `image`,`v_game_activity`.`reg_begin_date` AS `reg_begin_date`,`v_game_activity`.`reg_end_date` AS `reg_end_date`,`v_game_activity`.`start_date` AS `start_date`,`v_game_activity`.`end_date` AS `end_date`,`v_game_activity`.`limit_count` AS `limit_count`,`v_game_activity`.`cost` AS `cost`,`v_game_activity`.`province` AS `province`,`v_game_activity`.`sponsor` AS `sponsor`,`v_game_activity`.`interest_count` AS `interest_count`,`v_game_activity`.`input_date` AS `input_date`,`v_game_activity`.`type` AS `type`,`v_game_activity`.`join_count` AS `join_count`,`v_game_activity`.`focus_count` AS `focus_count`,`v_game_activity`.`topic_count` AS `topic_count`,`v_game_activity`.`status` AS `status` from (`v_game_activity` join `op_recommend`) where ((`v_game_activity`.`id` = `op_recommend`.`gc_id`) and (`v_game_activity`.`type` = _utf8'game') and (`op_recommend`.`recommend_type` = _utf8'game')) order by `op_recommend`.`sort_num` ;

-- ----------------------------
-- View structure for `v_recommend_venues`
-- ----------------------------
DROP VIEW IF EXISTS `v_recommend_venues`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_recommend_venues` AS select `v_venue`.`id` AS `id`,`v_venue`.`city` AS `city`,`v_venue`.`region` AS `region`,`v_venue`.`name` AS `name`,`v_venue`.`person_cost` AS `person_cost`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `v_venue`.`image`)) AS `venue_image` from (`v_venue` join `op_recommend`) where ((`v_venue`.`id` = `op_recommend`.`gc_id`) and (`op_recommend`.`recommend_type` = _utf8'venue')) order by `op_recommend`.`sort_num` ;

-- ----------------------------
-- View structure for `v_sport_association`
-- ----------------------------
DROP VIEW IF EXISTS `v_sport_association`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_sport_association` AS select `db_sport_association`.`id` AS `id`,`db_sport_association`.`name` AS `name`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `db_sport_association`.`image`)) AS `image`,`db_sport_association`.`description` AS `description`,`db_sport_association`.`input_date` AS `input_date`,`db_sport_association`.`input_user` AS `input_user` from `db_sport_association` ;

-- ----------------------------
-- View structure for `v_topic`
-- ----------------------------
DROP VIEW IF EXISTS `v_topic`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_topic` AS select `op_game_topic`.`id` AS `id`,`op_game_topic`.`game_id` AS `game_id`,`op_game_topic`.`user_id` AS `user_id`,`op_game_topic`.`content` AS `content`,`op_game_topic`.`laud_count` AS `laud_count`,`op_game_topic`.`input_date` AS `input_date`,`v_game_activity`.`sport_id` AS `sport_id`,`v_game_activity`.`name` AS `game_name`,`v_topic_comment_count`.`comment_count` AS `comment_count`,(select `db_user`.`name` AS `name` from `db_user` where (`db_user`.`id` = `op_game_topic`.`user_id`)) AS `user_name`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = (select `db_user`.`user_head` AS `user_head` from `db_user` where (`db_user`.`id` = `op_game_topic`.`user_id`)))) AS `user_image`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = (select `op_game_topic_images`.`image_id` AS `image_id` from `op_game_topic_images` where (`op_game_topic_images`.`topic_id` = `op_game_topic`.`id`) limit 1))) AS `topic_image` from ((`op_game_topic` join `v_game_activity` on(((`op_game_topic`.`game_id` = `v_game_activity`.`id`) and (`v_game_activity`.`type` = _utf8'game')))) left join `v_topic_comment_count` on((`op_game_topic`.`id` = `v_topic_comment_count`.`topic_id`))) ;

-- ----------------------------
-- View structure for `v_topic_comment_count`
-- ----------------------------
DROP VIEW IF EXISTS `v_topic_comment_count`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_topic_comment_count` AS select `op_comment`.`source_id` AS `topic_id`,count(1) AS `comment_count` from `op_comment` where (`op_comment`.`source_type` = 4) group by `op_comment`.`source_id` ;

-- ----------------------------
-- View structure for `v_topic_images`
-- ----------------------------
DROP VIEW IF EXISTS `v_topic_images`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_topic_images` AS select `op_game_topic_images`.`topic_id` AS `topic_id`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `op_game_topic_images`.`image_id`)) AS `image` from (`op_game_topic_images` join `v_topic`) where (`op_game_topic_images`.`topic_id` = `v_topic`.`id`) ;

-- ----------------------------
-- View structure for `v_user_topic_count`
-- ----------------------------
DROP VIEW IF EXISTS `v_user_topic_count`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_user_topic_count` AS select `op_game_topic`.`user_id` AS `user_id`,count(1) AS `topic_count` from `op_game_topic` group by `op_game_topic`.`user_id` ;

-- ----------------------------
-- View structure for `v_venue`
-- ----------------------------
DROP VIEW IF EXISTS `v_venue`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_venue` AS select `db_venue`.`id` AS `id`,`db_venue`.`name` AS `name`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `db_venue`.`image`)) AS `image`,`db_venue`.`sport_id` AS `sport_id`,`db_venue`.`province` AS `province`,`db_venue`.`city` AS `city`,`db_venue`.`region` AS `region`,`db_venue`.`address` AS `address`,`db_venue`.`phone` AS `phone`,`db_venue`.`person_cost` AS `person_cost`,(select `db_images`.`local_url` AS `local_url` from `db_images` where (`db_images`.`id` = `db_venue`.`image`)) AS `url`,(select floor((sum(`op_comment`.`star_count`) / count(1))) AS `floor(sum(star_count)/ count(1))` from `op_comment` where ((`op_comment`.`source_id` = `db_venue`.`id`) and (`op_comment`.`source_type` = _utf8'3'))) AS `star_count`,`db_venue`.`input_date` AS `input_date`,`db_venue`.`input_user` AS `input_user`,(select count(1) AS `count(1)` from `op_focus` where ((`op_focus`.`source_id` = `db_venue`.`id`) and (`op_focus`.`source_type` = _utf8'3'))) AS `followCount`,(select count(1) AS `count(1)` from `op_comment` where ((`op_comment`.`source_id` = `db_venue`.`id`) and (`op_comment`.`source_type` = _utf8'3'))) AS `commentCount` from `db_venue` ;
