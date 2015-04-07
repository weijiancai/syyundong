/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-07 15:20:48
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `is_verify` char(1) NOT NULL COMMENT '是否需要审核',
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of db_activity
-- ----------------------------
INSERT INTO `db_activity` VALUES ('1', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('2', '游泳比赛', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('3', '清明扫墓', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('4', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('5', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('6', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('7', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('8', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('9', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('10', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('11', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('12', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
INSERT INTO `db_activity` VALUES ('13', '开春踏青', '8', '1', '2015-04-01 15:16:49', '2015-04-10 15:16:54', '2015-04-13 15:16:59', '2015-04-17 15:17:03', '10', null, '1', '1', '1', '300', '松原', '宁江区', '江北', '踏青好时节', '2015-04-07 15:18:21', '0', '25');
