/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-05 22:33:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `dz_sport`
-- ----------------------------
DROP TABLE IF EXISTS `dz_sport`;
CREATE TABLE `dz_sport` (
  `id` int(11) NOT NULL COMMENT '项目ID',
  `name` varchar(64) NOT NULL COMMENT '项目名称',
  `sport_type` int(1) NOT NULL COMMENT '项目类型（0 赛事/活动/场馆，1 赛事，2 活动，3 场馆）',
  `level` int(1) default NULL COMMENT '级别',
  `pid` int(11) NOT NULL COMMENT '父项目ID',
  `input_date` datetime NOT NULL COMMENT '录入时间',
  `input_user` int(11) NOT NULL COMMENT '录入人',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='赛事活动项目';

-- ----------------------------
-- Records of dz_sport
-- ----------------------------
INSERT INTO `dz_sport` VALUES ('1', '球类项目', '1', '1', '0', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('2', '户外运动', '1', '1', '0', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('3', '全民健身', '1', '1', '0', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('4', '其他运动', '1', '1', '0', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('5', '马拉松路跑', '1', '1', '0', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('6', '羽毛球', '1', '2', '2', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('7', '瑜伽', '1', '2', '3', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('8', '台球', '1', '2', '1', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('9', '网球', '1', '2', '1', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('10', '自行车', '1', '2', '2', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('11', '轮滑', '1', '2', '3', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('12', '门球', '1', '2', '1', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('13', '健美', '1', '2', '3', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('14', '游泳', '1', '2', '4', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('15', '射击', '1', '2', '5', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('16', '马拉松', '1', '2', '5', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('17', '路跑', '1', '2', '5', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('18', '钓鱼', '1', '2', '4', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('19', '角斗士', '1', '2', '4', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('20', '滑雪', '1', '2', '4', '2015-03-26 22:02:09', '0');
INSERT INTO `dz_sport` VALUES ('21', '徒步', '1', '2', '1', '2015-03-26 22:02:09', '0');
