/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : syyundong

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2015-04-06 22:11:46
*/

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of op_recommend
-- ----------------------------
INSERT INTO `op_recommend` VALUES ('1', '1', 'game', '1');
INSERT INTO `op_recommend` VALUES ('2', '2', 'game', '2');
INSERT INTO `op_recommend` VALUES ('3', '11', 'game', '4');
INSERT INTO `op_recommend` VALUES ('4', '12', 'game', '3');
