/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-20 00:25:40
*/

SET FOREIGN_KEY_CHECKS=0;

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
INSERT INTO `db_group` VALUES ('1', 'GFilm', '今日电影', null, null, '1', '10', null);
INSERT INTO `db_group` VALUES ('2', 'GCon', '综合信息', null, null, '1', '9', null);
INSERT INTO `db_group` VALUES ('3', 'GSystem', '系统设置', null, null, '1', '1', null);
INSERT INTO `db_group` VALUES ('4', 'GAdv', '广告管理', null, null, '1', '4', null);
INSERT INTO `db_group` VALUES ('5', 'GTalk', '聊吧管理', null, null, '1', '5', null);
INSERT INTO `db_group` VALUES ('6', 'GLaw', '法律问答', null, null, '1', '6', null);
INSERT INTO `db_group` VALUES ('7', 'GLife', '生活信息', null, null, '1', '7', null);
INSERT INTO `db_group` VALUES ('8', 'GResume', '简历管理', null, null, '1', '8', null);
INSERT INTO `db_group` VALUES ('9', 'GSite', '基础信息', null, null, '1', '2', null);
INSERT INTO `db_group` VALUES ('10', 'GMember', '会员管理', null, null, '1', '3', null);
INSERT INTO `db_group` VALUES ('11', 'GBussCard', '商家名片', null, null, '1', '11', null);
INSERT INTO `db_group` VALUES ('12', 'GShopmanager', '商城管理', null, null, '1', '13', null);
INSERT INTO `db_group` VALUES ('13', 'GStore', '商家管理', null, null, '1', '14', null);
INSERT INTO `db_group` VALUES ('14', 'GActivity', '活动管理', null, null, '1', '15', null);
