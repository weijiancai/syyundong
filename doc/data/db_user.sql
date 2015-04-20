/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-20 23:27:43
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `high` int(11) default NULL COMMENT '身高',
  `weight` decimal(10,0) default NULL COMMENT '体重',
  `mobile` varchar(16) default NULL COMMENT '手机号码',
  `email` varchar(64) default NULL COMMENT '邮箱',
  `postal_code` varchar(16) default NULL COMMENT '邮编',
  `address` varchar(128) default NULL COMMENT '通讯地址',
  `signature` varchar(64) default NULL COMMENT '个性签名',
  `interest` varchar(512) default NULL COMMENT '运动喜好（多值，逗号分隔）',
  `verify_code` varchar(10) default NULL COMMENT '验证码',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='用户';

-- ----------------------------
-- Records of db_user
-- ----------------------------
INSERT INTO `db_user` VALUES ('1', 'admlogin', '0', 'admlogin', 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18844882669', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('2', '', '0', '囧囧', 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', '', null, null, null, null, null, null, null, '18844882668', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('3', '', '0', null, 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', '', null, null, null, null, null, null, null, '18844882667', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('4', '', '0', null, 'NjcwQjE0NzI4QUQ5OTAyQUVDQkEzMkUyMkZBNEY2QkQ=', '', null, null, null, null, null, null, null, '18844882667', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('5', '', '0', null, 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', '', null, null, null, null, null, null, null, '18844882664', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('6', '', '0', null, 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', '', null, null, null, null, null, null, null, '18844882663', null, null, null, null, null, null, '0000-00-00 00:00:00');
INSERT INTO `db_user` VALUES ('7', '', '0', null, 'OTZFNzkyMTg5NjVFQjcyQzkyQTU0OURENUEzMzAxMTI=', '', null, null, null, null, null, null, null, '18844882662', null, null, null, null, null, null, '0000-00-00 00:00:00');
